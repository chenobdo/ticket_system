<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Model\Client;
use App;
use Response;

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

        $pdfdir = storage_path('pdf/'.date('YmdHis').'/');
        foreach ($clients as $client) {
            $filename = $client->contractno.'.pdf';

            $html = view('admin.check.template', ['client' => $client])->__toString();
            $pdf = App::make('snappy.pdf.wrapper');
            $filepath = $pdfdir.$filename;
            $pdf->loadHTML($html)->save($filepath);
        }

        $zip = new ZipArchive();
        $zippath = storage_path('zip/'.date('YmdHis').'.zip');
        if ($zip->open($zippath, ZipArchive::OVERWRITE) === TRUE) {
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
