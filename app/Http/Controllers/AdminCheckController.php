<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Model\Client;
use App;
use Response;
use ZipArchive;
use App\Model\Zip;

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
            $pdfname = $client->contractno.'.pdf';

            $html = view('admin.check.template', ['client' => $client])->__toString();
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

        $user = Auth::user();
        $zip = new Zip();
        $zip->zip_name = $zipname;
        $zip->path = $zipdir;
        $zip->uid = $user->id;
        $zip->mark = json_encode($contractnos);
        $zip->created_at = time();
        $zip->updated_at = time();
        $zip->save();

        if (empty($zip->id)) {
            return redirect()->route('clients.index')->with('success', "客户打包条目添加失败");
        }

        return redirect()->route('clients.index')->with('success', "客户打包成功");
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
