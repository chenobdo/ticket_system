<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Excel;
use Storage;
use App\Model\Client;
use App\Model\ClientInfo;
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
        Excel::load($realpath, function($reader) use ($realpath)  {
            $reader = $reader->getSheet(0);
            $datas = $reader->toArray();
            foreach ($datas as $key => $data) {
                if (in_array($key, [0, 1])) {
                    continue;
                }

                $client = new Client();
                $client->contractno = $data[1];
                $client->is_continue = Client::IsContinueNo($data[2]);
                $client->client = $data[3];
                $client->cardid = $data[4];
                $client->gender = Client::GenderNo($data[5]);
                $client->loan_amount = $data[6];
                $client->product_name = $data[7];
                $client->nper = $data[8];
                $client->annualized_return = $data[9];
                $client->gross_interest = $data[10];
                $client->interest_monthly = $data[11];
                $client->deduct_date = ($data[12]-70*365-19)*86400-8*3600;
                $client->loan_date = ($data[13]-70*365-19)*86400-8*3600;
                $client->due_date = ($data[14]-70*365-19)*86400-8*3600;
                $client->billing_days = $data[15];
                $client->expire_days = $data[16];
                $client->status = Client::StatusNo($data[17]);
                $client->FTC = $data[23];
                $client->FTA = $data[24];
                $client->bond_type = Client::BondTypeNo($data[31]);
                $client->address = $data[32];
                $client->postcode = $data[33];
                $client->receipt_date = ($data[47]-70*365-19)*86400-8*3600;
                $client->is_confirm = Client::IsConfirmNo($data[48]);
                $client->created_at = time();
                $client->updated_at = time();
                $clientId = $client->save();

                dd($clientId);
            }
        });
    }
}
