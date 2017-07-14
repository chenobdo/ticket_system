<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Model\Client;
use App;
use Response;
use ZipArchive;
use App\Model\Zip;
use Auth;
use Datatables;
use App\User;

class AdminCheckController extends Controller
{
    public function index()
    {
        $users = User::pluck('fullname', 'id')->toArray();
        return view('admin.check.index', ['users' => json_encode($users)]);
    }

    public function data()
    {
        return Datatables::of(Zip::query())->make(true);
    }

    public function download($id)
    {
        $zip = Zip::find($id);
        $zippath = $zip->path.$zip->zip_name;
        return response()->download($zippath, $zip->zip_name, ['Content-Type' => 'application/zip']);
    }

    public function package(Request $request)
    {
        $contractnos = $request->input('contractnos');
        $clients = Client::whereIn('contractno', $contractnos)->get();

        $dir = date('YmdHis');
        $pdfdir = public_path("pdf/{$dir}/");
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
        $zipdir = public_path("zip/");
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
        $zip->type = Zip::TYPE_MANUAL;
        $zip->uid = $user->id;
        $zip->mark = json_encode($contractnos);
        $zip->created_at = time();
        $zip->updated_at = time();
        $zip->save();

        if (empty($zip->id)) {
            return redirect()->route('clients.index')->with('success', "客户打包条目添加失败");
        }

        $this->deldir($pdfdir);

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
