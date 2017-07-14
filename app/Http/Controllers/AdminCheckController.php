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
        if (empty($contractnos)) {
            return redirect()->route('clients.index')->with('warning', "合同编号为空");
        }
        $clients = Client::whereIn('contractno', $contractnos)->get();

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
