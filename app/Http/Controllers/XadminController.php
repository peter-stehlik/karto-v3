<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;

class XadminController extends Controller
{
    /**
     * Show form to transfer data.
     * DOLEZITE - stare data su v DB, ktorej pripojenie sa vola 'mysql_old', definovane v config.database
     *
     * @return \Illuminate\Http\Response
     */
    public function transferOldDbIndex()
    {
        // $data = DB::connection("mysql_old")->table("users")->get();

        return view('x-admin/transfer-old-db');
    }
}
