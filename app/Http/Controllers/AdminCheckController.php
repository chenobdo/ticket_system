<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Model\Client;

require_once base_path('vendor/tecnickcom/tcpdf/tcpdf.php');
require_once base_path('vendor/tecnickcom/tcpdf/config/tcpdf_config.php');

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

        foreach ($clients as $client) {
            $html = view('admin.check.template', ['client' => $client])->__toString();
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadHTML($html);
            $filepath = storage_path('app/pdf/');
            $filename = $client->contractno.$client->client.'.pdf';
//            $rt = $pdf->save($filepath.$filename);
//            dd($rt);
            return $pdf->stream();
        }
    }
}
