<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Excel;
use Storage;
use App\Model\Client;
use Yajra\Datatables\Datatables;

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

    public function show($id)
    {
        $client = Client::findOrFail($id);

        return view('admin.clients.show', compact('client'));
    }

    public function edit($id)
    {
        $client = Client::find($id);

        return view('admin.clients.edit', compact('client'));
    }

    public function destroy($id)
    {
        DB::table('clients')->where('id', $id)->delete();

        return redirect()->route('clients.index')
            ->with('success', '客户删除成功');
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
