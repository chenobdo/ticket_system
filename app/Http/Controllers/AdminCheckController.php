<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Model\Client;
use App;
use Response;
use ZipArchive;

class AdminCheckController extends Controller
{
    public function index()
    {
        return view('admin.check.index');
    }

    public function package(Request $request)
    {
        $contractnos = $request->input('contractnos');
        $clients = Client::whereIn('contractno', $contractnos)->get();

        $dir = date('YmdHis');
        $pdfdir = storage_path("app/pdf/{$dir}/");
        foreach ($clients as $client) {
            $filename = $client->contractno.'.pdf';

            $html = view('admin.check.template', ['client' => $client])->__toString();
            $pdf = App::make('snappy.pdf.wrapper');
            $filepath = $pdfdir.$filename;
            if (file_exists($filepath)) {
                unlink($filepath);
            }
            $pdf->loadHTML($html)->save($filepath);
        }

        $zip = new ZipArchive();
        $zipdir = storage_path("app/zip");
        if (!is_dir($zipdir)) {
            mkdir($zipdir);
        }
        $zippath = $zipdir."/{$dir}.zip";
        if ($zip->open($zippath, ZIPARCHIVE::CREATE) === TRUE) {
            $this->zip($pdfdir, $zip);
            $zip->close();
        }

        return response()->download($zippath);

        return redirect()->route('clients.index')->with('success', "客户打包成功");;
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
}
