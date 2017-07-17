<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App;
use ZipArchive;

class PackageContacts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package_contacts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display an inspiring quote';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $clients = \App\Model\Client::limit(2)->get();

        $dir = date('YmdHis');
        $pdfdir = storage_path("app/pdf/{$dir}/");
        $month = date('m', strtotime('+1 month'));
        foreach ($clients as $client) {
            $pdfname = $client->contractno.'.pdf';
            $accounts = $this->generateAccount($client);
            $html = view('admin.check.template', compact('client', 'month',
                'accounts'))->__toString();
            $pdf = App::make('snappy.pdf.wrapper');
            $filepath = $pdfdir.$pdfname;
            if (file_exists($filepath)) {
                unlink($filepath);
            }
            $pdf->loadHTML($html)->save($filepath);
        }

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

        $zip = new \App\Model\Zip();
        $zip->zip_name = $zipname;
        $zip->path = $zipdir;
        $zip->type = \App\Model\Zip::TYPE_AUTO;
        $zip->uid = 1;
        $zip->mark = json_encode(['all']);
        $zip->created_at = time();
        $zip->updated_at = time();
        $zip->save();

        $this->deldir($pdfdir);
    }

    private function generateAccount($client)
    {
        $loanDate = $client->loan_date;
        $day = $client->billing_days;
        $nper = $client->nper;

        $accounts = [];
        $currentDate = $loanDate;
        $currentNper = 0;
        while ($currentNper < $nper) {
            if (date('Y/m', strtotime($currentDate)) == date('Y/m')) {
                $nper = -1;
            }
            $account['date'] = getAccountDay(strtotime($currentDate), $day);
            $account['interest_monthly'] = $client->interest_monthly;
            $account['fee'] = 0;
            $account['total_assets'] = $client->loan_amount + $client->interest_monthly * ($currentNper + 1);
            $accounts[] = $account;
            $currentDate = $account['date'];
            $currentNper += 1;
        }

        return $accounts;
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
