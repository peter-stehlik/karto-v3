<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Hash;
use Str;

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
        return view('x-admin/transfer-old-db');
    }

    /**
     * transfer data from old DB - users, bank accounts, categories, (non)periodicals
     */
    public function postMigrateBasic()
    {
        // users
        // 1. delete existing data 2. upload real data
        // 1.
        DB::table('users')->truncate();
        
        // 2.
        $i = 0;
        $users = DB::connection("mysql_old")
                    ->table("users")
                    ->orderBy("user_id", "asc")
                    ->get();

        foreach( $users as $user ){
            if( $user->user_name === "Katarína Mancírová" ){
                User::create([
                    "id" => $user->user_id,
                    "name" => $user->user_name,
                    "email" => "katarina.mancirova@svd.sk",
                    'email_verified_at' => now(),
                    "password" => Hash::make('kalvaria2'),
                    "remember_token" => Str::random(10),
                    "accounting_date" => "2021-12-01",
                    "created_at" => $user->creation_date,
                ]);                
            } else if( $user->user_name === "Katarína Vallová" ){
                User::create([
                    "id" => $user->user_id,
                    "name" => $user->user_name,
                    "email" => "katarina.vallova@svd.sk",
                    'email_verified_at' => now(),
                    "password" => Hash::make('kalvaria1'),
                    "remember_token" => Str::random(10),
                    "accounting_date" => "2021-12-01",
                    "created_at" => $user->creation_date,
                ]);
            } else {   
                User::create([
                    "id" => $user->user_id,
                    "name" => $user->user_name,
                    "email" => $user->user_code . "@vymyslenyemail.sk",
                    'email_verified_at' => now(),
                    "password" => Hash::make("kalvaria+" . $i),
                    "remember_token" => Str::random(10),
                    "accounting_date" => "2021-12-01",
                    "created_at" => $user->creation_date,
                ]);
            }

            $i++;
        }

        User::create([
            'id' => 88,
            'name' => 'Peter Stehlík',
            'email' => 'peter@inovative.sk',
            'email_verified_at' => now(),
            'accounting_date' => now(),
            'password' => Hash::make('.KartotekA1510/'),
            'remember_token' => Str::random(10),
            "accounting_date" => "2021-12-01",
            "created_at" => "2021-12-01",
        ]);

        return redirect()->back()->with('message', 'Operácia sa podarila!');
    }
}
