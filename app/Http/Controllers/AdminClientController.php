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
        $isContinue = Client::IsContinue();
        $gender = Client::Gender();
        $status = Client::Status();
        $payType = ClientInfo::PayType();
        $bondType = Client::BondType();

        return view('admin.clients.show', compact('client', 'isContinue',
            'gender', 'status', 'payType', 'bondType'));
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
        Excel::load($realpath, function($reader) use ($realpath, $total)  {
            $reader = $reader->getSheet(0);
            $datas = $reader->toArray();
            foreach ($datas as $key => $data) {
                if (in_array($key, [0, 1])) {
                    continue;
                }

                DB::transaction(function () use ($data) {
                    $this->storeData($data);
                });
            }
        });

        return redirect()->route('clients.index')
            ->with('success', "客户导入成功，共更新了{$total}条客户信息");
    }

    private function storeData($data)
    {
        $client = Client::where('contractno', $data[1])->first() ?: new Client();
        $client->contractno = $data[1];
        $client->is_continue = Client::IsContinueNo($data[2]);
        $client->client = $data[3];
        $client->cardid = $data[4];
        $client->gender = Client::GenderNo($data[5]);
        $client->loan_amount = sprintf("%.2f", $data[6]);
        $client->product_name = $data[7];
        $client->nper = $data[8];
        $client->annualized_return = sprintf("%.4f", $data[9]);
        $client->gross_interest = sprintf("%.2f", $data[10]);
        $client->interest_monthly = is_numeric($data[11]) ? sprintf("%.2f", $data[11]) : 0;
        $client->deduct_date = date('Y-m-d', $client->generateTimestamp($data[12]));
        $client->loan_date = date('Y-m-d', $client->generateTimestamp($data[13]));
        $client->due_date = date('Y-m-d', $client->generateTimestamp($data[14]));
        $client->billing_days = $data[15];
        $cnt = preg_match("/(?<=还有)\d+/", $data[16], $expireDays);
        $client->expire_days = empty($cnt)? 0 : $expireDays[0];
        $client->status = Client::StatusNo($data[17]);
        $client->FTC = sprintf("%.2f", $data[23]);
        $client->FTA = sprintf("%.2f", $data[24]);
        $client->bond_type = Client::BondTypeNo($data[31]);
        $client->address = $data[32];
        $client->postcode = $data[33];
        $client->receipt_date = date('Y-m-d', $client->generateTimestamp($data[47]));
        $client->is_confirm = Client::IsConfirmNo($data[48]);
        $client->email = empty($data[34]) ? '' : $data[34];
        $client->created_at = time();
        $client->updated_at = time();
        $client->save();

        $clientInfo = ClientInfo::where('client_id', $client->id)->first() ?: new ClientInfo();
        $clientInfo->fuyou_account = empty($data[18]) ? '' : $data[18];
        $clientInfo->pay_type = ClientInfo::PayTypeNo($data[19]);
        $clientInfo->deduct_time = date('H:i:s', $client->generateTimestamp($data[20]));
        $clientInfo->posno = empty($data[21]) ? '' : $data[21];
        $clientInfo->fee = is_numeric($data[22]) ? sprintf("%.2f", $data[22]) : 0;
        $clientInfo->import_bank = $data[25];
        $clientInfo->import_account = $data[26];
        $clientInfo->import_name = $data[27];
        $clientInfo->export_bank = $data[28];
        $clientInfo->export_account = $data[29];
        $clientInfo->export_name = $data[30];
        $clientInfo->region_name = $data[35];
        $clientInfo->area_name = $data[36];
        $clientInfo->city_name = $data[37];
        $clientInfo->section = empty($data[38]) ? '' : $data[38];
        $clientInfo->director = empty($data[39]) ? '' : $data[39];
        $clientInfo->area_manager = $data[40];
        $clientInfo->city_manager = empty($data[41]) ? '' : $data[41];
        $clientInfo->store_manager = empty($data[42]) ? '' : $data[42];
        $clientInfo->team_manager = $data[43];
        $clientInfo->account_manager = $data[44];
        $clientInfo->account_manager_cardid = $data[45];
        $clientInfo->created_at = time();
        $clientInfo->updated_at = time();
        $clientInfo->client_id = $client->id;
        $clientInfo->save();
    }
}
