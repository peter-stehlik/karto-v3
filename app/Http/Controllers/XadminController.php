<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BankAccount;
use App\Models\Category;
use App\Models\PeriodicalPublication;
use App\Models\NonperiodicalPublication;
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

        // bank accounts
        // 1. delete existing data 2. upload real data
        // 1.
        DB::table('bank_accounts')->truncate();

        // 2.
        $bank_accounts = DB::connection("mysql_old")
            ->table("bank_account")
            ->leftJoin("bank", "bank_account.bank_id", "=", "bank.bank_id")
            ->select("account_id" ,"bank_name", "bank_code", "account_number", "bank_account.creation_date", "bank_account.expiration_date")
            ->get();

        foreach( $bank_accounts as $bank_account ){
            if( $bank_account->account_id === 1 ){ // pokladna
                BankAccount::create([
                    'id' => $bank_account->account_id,
                    'bank_name' => 'Pokladňa',
                    'abbreviation' => '',
                    'number' => '',
                    'created_at' => $bank_account->creation_date,
                    'deleted_at' => $bank_account->expiration_date,
                ]);
            } else {                
                BankAccount::create([
                    'id' => $bank_account->account_id,
                    'bank_name' => $bank_account->bank_name,
                    'abbreviation' => $bank_account->bank_code,
                    'number' => $bank_account->account_number,
                    'created_at' => $bank_account->creation_date,
                    'deleted_at' => $bank_account->expiration_date,
                ]);
            }
        }

        // categories
        // 1. delete existing data 2. upload real data
        // 1.
        DB::table('categories')->truncate();
        
        // 2.
        $categories = DB::connection("mysql_old")
                ->table("category")
                ->get();

        foreach( $categories as $cat ){
            Category::create([
                'id' => $cat->category_id, 
                'name' => $cat->category_name,
            ]);
        }

        // periodicals
        // 1. delete existing data 2. upload real data
        // 1.
        DB::table('periodical_publications')->truncate();
        
        // 2.
        $pp = DB::connection("mysql_old")
                ->table("intention")
                ->where("publication", 1)
                ->join("publication", "intention.intention_id", "=", "publication.intention_id")
                ->join("periodical_publication", "publication.publication_id", "=", "periodical_publication.publication_id")
                ->select("intention.intention_id", "intention_name", "intention.creation_date", "abbreviation", "amount", "publication_date", "accounting_date", "publication_number", "publication_volume")
                ->get();

        foreach( $pp as $p ){
            PeriodicalPublication::create([
                'id' => $p->intention_id,
                'name' => $p->intention_name,
                'label_date' => $p->publication_date,
                'accounting_date' => $p->accounting_date,
                'abbreviation' => $p->abbreviation,
                'price' => $p->amount,
                'current_number' => $p->publication_number,
                'current_volume' => $p->publication_volume,
                'created_at' => $p->creation_date,
            ]);
        }
        
        // nonperiodicals
        // 1. delete existing data 2. upload real data
        // 1.
        DB::table('nonperiodical_publications')->truncate();
        
        // 2.
        $np = DB::connection("mysql_old")
                ->table("intention")
                ->where("publication", 0)
                ->get();

        foreach( $np as $p ){
            NonperiodicalPublication::create([
                'id' => $p->intention_id,
                'name' => $p->intention_name,
                'created_at' => $p->creation_date,
            ]);
        }

        // success
        return redirect()->back()->with('message', 'Operácia sa podarila!');
    }

    public function postMigratePeople()
    {
        
    }
}
