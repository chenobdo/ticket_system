<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Model\Client;
use App;

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
            $filename = $client->contractno().$client->client.'.pdf';
            $rt = $pdf->save('/pdf/'.$filename);
            dd($rt);
            return $pdf->stream();
        }
    }
}
