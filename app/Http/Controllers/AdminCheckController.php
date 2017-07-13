<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Model\Client;
use App;
use Response;

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
            $pdf = App::make('snappy.pdf.wrapper');
            $path = base_path();
            $pdf->loadHTML($html)->save(storage_path('myfile.pdf'));
            return $pdf->inline();
        }
    }
}
