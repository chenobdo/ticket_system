<?php

namespace App\Http\Controllers;

use App\User;
use DB;
use Illuminate\Http\Request;
use Excel;
use Storage;

class AdminClientController extends Controller
{
    public function index()
    {
        $menucount = $this->menucount();

        $tickets = Ticket::orderBy('created_at', 'desc')->paginate(5);
        $categories = Category::all();
        $prioritys = Priority::all();
        $statuses = Status::all();

        return view('admin.tickets.index', compact('menucount', 'tickets', 'categories', 'statuses', 'prioritys'));
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
        $filepath = 'excel/'.date('Y_m_d').'_'.rand(1,999).'.'.$entension;
        Storage::put($filepath, file_get_contents($filename));

        $realpath = storage_path('app/'.$filepath);
        dd($realpath);

        $rt = Excel::selectSheets('总表')->load($realpath, function($reader) {

            // reader methods

        });

        dd($rt);
    }
}
