<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;

class UpdateBill extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $clients;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Client $clients)
    {
        $this->clients = $clients;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //生成账单条目

        $dir = date('YmdHis');
        $pdfdir = storage_path("app/pdf/{$dir}/");

        foreach ($this->clients as $client) {
            $pdfname = "{$client->contractno}_{$client->client}.pdf";
            $bills = $this->generateBill($client);

            //生成PDF
            $html = view('admin.check.template', compact('client', 'bills'))->__toString();
            $pdf = App::make('snappy.pdf.wrapper');
            $filepath = $pdfdir.$pdfname;
            if (file_exists($filepath)) {
                unlink($filepath);
            }
            $pdf->loadHTML($html)->save($filepath);
        }



        //打包


    }

    private function generateBill($client)
    {
        $bills = [];
        $currentDate = $this->getBillDay(strtotime($client->loan_date), $client->billing_days);
        $currentNper = 0;
        while ($currentNper < $client->nper) {
            if (date('Ym', strtotime($currentDate)) == date('Ym')) {
                $client->nper = -1;
            }
            $bill['date'] = $currentDate;
            $bill['interest_monthly'] = $client->interest_monthly;
            $bill['total_assets'] = $client->loan_amount + $client->interest_monthly * ($currentNper + 1);
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
}
