<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BankAccount;
use App\Models\Category;
use App\Models\PeriodicalPublication;
use App\Models\PeriodicalCredit;
use App\Models\NonperiodicalPublication;
use App\Models\NonperiodicalCredit;
use App\Models\Person;
use App\Models\Income;
use App\Models\Transfer;
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
        ini_set('max_execution_time', '900');

        // people
        // 1. delete existing data 2. upload real data
        // 1.
        DB::table('people')->truncate();
        
        // 2.
        $data = DB::connection("mysql_old")
            ->table("person")
            ->leftJoin("person_in_category", "person.person_id", "=", "person_in_category.person_id")
            ->select("person.person_id", "category_id", "title", "name1", "name2", "address1", "address2", "zip_code", "city", "state", "email", "notes", "creation_date", "expiration_date")
            ->orderBy("person.person_id", "asc")
            ->groupBy("person.person_id")
            ->chunk(2000, function($people){
                foreach( $people as $person ){
                    $category_id = $person->category_id ?? 1; 

                    Person::create([
                        'id' => $person->person_id,
                        'category_id' => $category_id,
                        'title' => $person->title,
                        'name1' => $person->name1 . " " . $person->name2,
                        'address1' => $person->address1,
                        'address2' => $person->address2,
                        'zip_code' => $person->zip_code,
                        'city' => $person->city,
                        'state' => $person->state,
                        'note' => $person->notes,
                        'created_at' => $person->creation_date,
                        'deleted_at' => $person->expiration_date,
                    ]);  
                }
            });

        // success
        return redirect()->back()->with('message', 'Operácia sa podarila!');
    }

    public function postMigrateCredits()
    {
        ini_set('max_execution_time', '900');

        // credits
        // 1. delete existing data 2. upload real data
        // 1.
        DB::table('periodical_credits')->truncate();
        DB::table('nonperiodical_credits')->truncate();
        
        // 2.
        $data = DB::connection("mysql_old")
            ->table("intention_account")
            ->orderBy("last_changed", "asc")
            ->chunk(2000, function($credits){
                foreach( $credits as $item ){
                    $periodical_intention_ids = [1,2,3,14]; // id-cka periodik podla starej db
                    $intention_id = $item->intention_id;

                    if( in_array($intention_id, $periodical_intention_ids) ){
                        PeriodicalCredit::create([
                            'person_id' => $item->person_id,
                            'periodical_publication_id' => $intention_id,
                            'credit' => $item->amount,
                            'created_at' => $item->last_changed
                        ]);
                    } else {
                        NonperiodicalCredit::create([
                            'person_id' => $item->person_id,
                            'nonperiodical_publication_id' => $intention_id,
                            'credit' => $item->amount,
                            'created_at' => $item->last_changed
                        ]);
                    }
                }
        });

        // success
        return redirect()->back()->with('message', 'Operácia sa podarila!');
    }

    public function postMigrateIncomes()
    {
        ini_set('max_execution_time', '900');

        // incomes
        // 1. delete existing data 2. upload real data
        // 1.
        DB::table('incomes')->truncate();
        
        // 2.
        $data = DB::connection("mysql_old")
            ->table("income")
            ->orderBy("effective_date", "asc")
            ->chunk(2000, function($incomes){
                foreach( $incomes as $income ){
                    Income::create([
                        'id' => $income->transaction_id,
                        'person_id' => $income->person_id,
                        'user_id' => $income->user_id,
                        'sum' => $income->amount,
                        'bank_account_id' => $income->account_id,
                        'number' => $income->paper,
                        'package_number' => $income->packet,
                        'invoice'  => $income->invoice,
                        'accounting_date' => $income->accounting_date,
                        'confirmed' => 1, // v starej db neexistuje ekvivalent
                        'note' => $income->notes,
                        'income_date' => $income->effective_date,
                        'created_at' => $income->effective_date,
                    ]);
                }
        });

        // success
        return redirect()->back()->with('message', 'Operácia sa podarila!');
    }

    public function postMigrateTransfers()
    {
        ini_set('max_execution_time', '900');

        // transfers
        // 1. delete existing data 2. upload real data
        // 1.
        DB::table('transfers')->truncate();
        
        // 2.
        $data = DB::connection("mysql_old")
            ->table("transfer")
            ->where("storno_id", NULL) // toto by mali byt opravy
            ->where("income_id", "!=", NULL) // toto by mali byt opravy
            ->where("amount", ">", 0) // minusy su tiez opravy
            ->orderBy("effective_date", "asc")
            ->chunk(2000, function($transfers){
                foreach( $transfers as $transfer ){
                    $periodical_intention_ids = [1,2,3,14]; // id-cka periodik podla starej db
                    $intention_id = $transfer->intention_id;
                    $periodical_publication_id = 0;
                    $nonperiodical_publication_id = 0;

                    if( in_array($intention_id, $periodical_intention_ids) ){
                        $periodical_publication_id = $intention_id;
                    } else {
                        $nonperiodical_publication_id = $intention_id;
                    }

                    Transfer::create([
                        'id' => $transfer->transaction_id,
                        'income_id' => $transfer->income_id,
                        'sum' => $transfer->amount,
                        'periodical_publication_id' => $periodical_publication_id,
                        'nonperiodical_publication_id' => $nonperiodical_publication_id,
                        'accounting_date' => $transfer->accounting_date,
                        'note' => $transfer->notes,
                        'transfer_date' => $transfer->effective_date,
                        'created_at' => $transfer->effective_date,
                    ]);
                }
        });

        // success
        return redirect()->back()->with('message', 'Operácia sa podarila!');
    }

    public function postMigratePeriodicalOrders()
    {
        
    }
}
