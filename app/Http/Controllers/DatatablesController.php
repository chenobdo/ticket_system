<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Datatables;
use User;

class DatatablesController extends Controller
{
        /**
                *  * Displays datatables front end view
                *   *
                *    * @return \Illuminate\View\View
                *     */
        public function getIndex()
        {
                    return view('datatables.index');
        }
        
        /**
         *  * Process datatables ajax request.
         *   *
         *    * @return \Illuminate\Http\JsonResponse
         *     */
        public function anyData()
        {
                    return Datatables::of(User::query())->make(true);
        }
}
