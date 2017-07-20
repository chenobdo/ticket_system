<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;
use App\Model\Client;
use App;
use ZipArchive;
use App\Model\Zip;

class UpdateBill extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $contractnos;

    protected $user;

    protected $type;

    /**
     * UpdateBill constructor.
     * @param null $contractnos
     * @param int $type
     * @param null $user
     */
    public function __construct($contractnos = null, $type = Zip::TYPE_AUTO, $user = null)
    {
        $this->contractnos = $contractnos;
        $this->type = $type;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (empty($this->contractnos)) {
            $this->clients = Client::get();
        } else {
            $this->clients = Client::whereIn('contractno', $this->contractnos)->get();
        }

        //生成账单条目
        $dir = date('YmdHis');
        $pdfdir = storage_path("app/pdf/{$dir}/");

        foreach ($this->clients as $client) {
            $pdfname = "{$client->contractno}.pdf";
            $bills = $this->generateBill($client);

            //生成PDF_纸质版
            $html = view('admin.check.template_papery', compact('client', 'bills'))->__toString();
            $pdf = App::make('snappy.pdf.wrapper');
            $filepath = $pdfdir.$pdfname;
            if (file_exists($filepath)) {
                unlink($filepath);
            }
            $pdf->loadHTML($html)->save($filepath);
        }

        //打包
        $zip = new ZipArchive();
        $zipdir = storage_path("app/zip/");
        if (!is_dir($zipdir)) {
            mkdir($zipdir);
        }
        $zipname = $dir.'.zip';
        $zippath = $zipdir."{$zipname}";
        if ($zip->open($zippath, ZIPARCHIVE::CREATE) === TRUE) {
            $this->zip($pdfdir, $zip);
            $zip->close();
        }

        if (!file_exists($zippath)) {
            return redirect()->route('clients.index')->with('success', "客户打包失败");
        }

        $zip = new Zip();
        $zip->zip_name = $zipname;
        $zip->path = $zipdir;
        $zip->type = $this->type;
        $zip->uid = empty($this->user) ? -1 : $this->user->id;
        $zip->mark = '';
        $zip->created_at = time();
        $zip->updated_at = time();
        $zip->save();

        $this->deldir($pdfdir);
    }

    private function generateBill($client)
    {
        $bills = [];
        $currentDate = $this->getBillDay(strtotime($client->loan_date), $client->billing_days);
        $currentNper = 0;
        while ($currentNper < $client->nper) {
            $yearMonth = date('Ym', strtotime($currentDate));

            if ($yearMonth == date('Ym')) { //账单出到本月为止
                $client->nper = -1;
            }

            $bill = DB::table('bills')->where([
                'year_month' => $yearMonth,
                'client_id' => $client->id
            ])->first();
            if (empty($bill)) {
                $bill = [
                    'year_month' => strpos($currentDate, 0, 6),
                    'client_id' => $client->id,
                    'date' => $currentDate,
                    'interest' => $client->interest_monthly,
                    'net_interest' => $client->interest_monthly,
                    'total_assets' => $client->loan_amount + $client->interest_monthly * ($currentNper + 1),
                    'created_at' => time(),
                    'updated_at' => time()
                ];
                DB::table('bills')->insert($bill);
            }

            $bills[] = $bill;
            $currentDate = $this->getBillDay(strtotime($bill['date']), $client->billing_days);
            $currentNper += 1;
        }

        return $bills;
    }

    private function getBillDay($t, $day)
    {
        // 获取下个月
        $month = getNextMonth($t);
        // 获取年份
        $year = $month == '01' ? getNextYear($t) : date('Y', $t);
        // 判断月最后一天
        $ymd = strtotime($year.$month.'01');
        $lastDay = getLastDay($ymd);
        $day = min($day, $lastDay);

        return date('Y/m/d', mktime(0, 0, 0, $month, $day, $year));
    }

    private function zip($path, $zip)
    {
        $handler = opendir($path);
        while (($filename = readdir($handler)) !== false) {
            if ($filename != "." && $filename != "..") {
                if (is_dir($path . "/" . $filename)) {
                    $this->zip($path . "/" . $filename, $zip);
                } else {
                    $zip->addFile($path . "/" . $filename);
                }
            }
        }
        @closedir($path);
    }

    private function deldir($dir)
    {
        $dh = opendir($dir);
        while ($file = readdir($dh)) {
            if ($file != "." && $file != "..") {
                $fullpath = $dir . "/" . $file;
                if (!is_dir($fullpath)) {
                    unlink($fullpath);
                } else {
                    $this->deldir($fullpath);
                }
            }
        }

        closedir($dh);
        return rmdir($dir) ? true : false;
    }
}
