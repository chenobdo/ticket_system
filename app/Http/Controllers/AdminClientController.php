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

                $rt = DB::transaction(function () {
                    $client = new Client();
                    $client->contractno = $data[1];
                    $client->is_continue = Client::IsContinueNo($data[2]);
                    $client->client = $data[3];
                    $client->cardid = $data[4];
                    $client->gender = Client::GenderNo($data[5]);
                    $client->loan_amount = sprintf("%.2f", $data[6]);
                    $client->product_name = sprintf("%.2f", $data[7]);
                    $client->nper = $data[8];
                    $client->annualized_return = sprintf("%.4f", $data[9]);;
                    $client->gross_interest = sprintf("%.2f", $data[10]);;
                    $client->interest_monthly = sprintf("%.2f", $data[11]);
                    $client->deduct_date = date('Y-m-d', $client->generateTimestamp($data[12]));
                    $client->loan_date = date('Y-m-d', $client->generateTimestamp($data[13]));
                    $client->due_date = date('Y-m-d', $client->generateTimestamp($data[14]));;
                    $client->billing_days = $data[15];
                    $client->expire_days = $data[16];
                    $client->status = Client::StatusNo($data[17]);
                    $client->FTC = sprintf("%.2f", $data[23]);
                    $client->FTA = sprintf("%.2f", $data[24]);
                    $client->bond_type = Client::BondTypeNo($data[31]);
                    $client->address = $data[32];
                    $client->postcode = $data[33];
                    $client->receipt_date = date('Y-m-d', $client->generateTimestamp($data[47]));
                    $client->is_confirm = Client::IsConfirmNo($data[48]);
                    $client->created_at = time();
                    $client->updated_at = time();
                    $client->save();

                    $clientInfo = new ClientInfo();
                    $clientInfo->fuyou_account = $data[18];
                    $clientInfo->pay_type = ClientInfo::PayTypeNo($data[19]);
                    $clientInfo->deduct_time = date('H:i:s', $client->generateTimestamp($data[20]));
                    $clientInfo->posno = $data[21];
                    $clientInfo->fee = sprintf("%.2f", $data[22]);
                    $clientInfo->import_bank = $data[25];
                    $clientInfo->import_account = $data[26];
                    $clientInfo->import_name = $data[27];
                    $clientInfo->export_bank = $data[28];
                    $clientInfo->export_account = $data[29];
                    $clientInfo->export_name = $data[30];
                    $clientInfo->region_name = $data[35];
                    $clientInfo->area_name = $data[36];
                    $clientInfo->city_name = $data[37];
                    $clientInfo->section = $data[38];
                    $clientInfo->director = $data[39];
                    $clientInfo->area_manager = $data[40];
                    $clientInfo->city_manager = $data[41];
                    $clientInfo->store_manager = $data[42];
                    $clientInfo->team_manager = $data[43];
                    $clientInfo->account_manager = $data[44];
                    $clientInfo->account_manager_cardid = $data[45];
                    $clientInfo->created_at = time();
                    $clientInfo->updated_at = time();
                    $clientInfo->client_id = $client->id;
                    $clientInfo->save();
                });

                dd($rt);
            }
        });
    }
}
