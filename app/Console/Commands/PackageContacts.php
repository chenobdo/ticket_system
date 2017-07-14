<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

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
        $clients = \App\Model\Client::get();

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
}
