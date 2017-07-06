<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Excel;
use Storage;
use App\Model\Client;

class AdminClientController extends Controller
{
    public function index()
    {
        return view('admin.clients.index');
    }

    public function data()
    {
        return Datatables::of(Client::query())->make(true);
    }

    public function upload()
    {
        return view('admin.clients.upload');
    }

    public function store(Request $request)
    {
        $file = $request->file('file_name');
        $filename = $file->getRealPath();
        $entension = $file->getClientOriginalExtension();
        $filepath = 'excel/'.date('Y_m_d').'_'.rand(100,999).'.'.$entension;
        Storage::put($filepath, file_get_contents($filename));

        $realpath = storage_path('app/'.$filepath);
        $rt = Excel::load($realpath, function($reader) use ($realpath)  {
//            $reader = $reader->getSheet(0);
//            $results = $reader->toArray();
//            $data = $reader->all();
//            dd($results);
//            $excel_data = Excel::load($realpath)->get()->toArray();
            $data = $reader->all();
            dd($data);
        });
        dd("43");
    }
}
