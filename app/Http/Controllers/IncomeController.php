<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankAccount;
use App\Models\PeriodicalPublication;
use App\Models\NonperiodicalPublication;
use App\Models\Income;
use App\Models\Transfer;
use Auth;

class IncomeController extends Controller
{
	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$periodicals = PeriodicalPublication::get();
		$nonperiodicals = NonperiodicalPublication::get();
		$bank_accounts = BankAccount::get();

        return view('v-kartoteka/prijem')
				->with('periodicals', $periodicals)
				->with('nonperiodicals', $nonperiodicals)
				->with('bank_accounts', $bank_accounts);
    }

	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$income_date = strtotime($request->income_date);
		$income_date = date('Y-m-d', $income_date);

        $new_income = Income::create([
            'person_id' => $request->person_id,
            'user_id' => Auth::user()->id,
            'sum' => floatval($request->income_sum),
            'bank_account_id' => $request->bank_account_id,
            'number' => $request->number,
            'package_number' => $request->package_number,
            'invoice' => $request->invoice,
            'confirmed' => 0,
            'note' => $request->income_note,
            'accounting_date' => Auth::user()->accounting_date,
            'income_date' => $income_date,
        ]);

        // TRANSFERS
        $sum = $request->sum;
        $periodical_publication = $request->periodical_publication;
        $nonperiodical_publication = $request->nonperiodical_publication;
        $note = $request->note;
        $transfer_date = $request->transfer_date;
        foreach( $sum as $key=>$value ){
			if( $value ){
				if( isset( $periodical_publication[$key] ) ){
					$pp = $periodical_publication[$key];
				}else{
					$pp = 0;					
				}
				
				if( isset( $nonperiodical_publication[$key] ) ){
					$np = $nonperiodical_publication[$key];
				}else{
					$np = 0;					
				}
				
				if( isset( $transfer_date[$key] ) ){
					$a = strtotime($transfer_date[$key]);
					$a = date('Y-m-d', $a);
				}else{
					$a = date("Y-m-d");					
				}
				
				if( isset( $sum[$key] ) ){
					$p = $sum[$key];
				}else{
					$p = 0;					
				}

                if( isset( $note[$key] ) ){
					$n = $note[$key];
				}else{
					$n = "";					
				}
				
				Transfer::create([
                    "income_id" => $new_income->id,
					"sum" => $p,
					"periodical_publication_id" => $pp,
					"nonperiodical_publication_id" => $np,
					"note" => $n,
					"sum" => floatval($p),
					"transfer_date" => $a,
				]);
			}
		}

        return redirect('/kartoteka')->with('message', 'Operácia sa podarila!');
    }
}