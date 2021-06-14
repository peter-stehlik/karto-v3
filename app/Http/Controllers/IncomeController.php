<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankAccount;
use App\Models\Income;
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
		$bank_accounts = BankAccount::get();

        return view('v-kartoteka/prijem')
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

        Income::create([
            'person_id' => $request->person_id,
            'user_id' => Auth::user()->id,
            'sum' => floatval($request->sum),
            'bank_account_id' => $request->bank_account_id,
            'number' => $request->number,
            'package_number' => $request->package_number,
            'invoice' => $request->invoice,
            'posted' => 0,
            'note' => $request->note,
            'accounting_date' => Auth::user()->accounting_date,
            'income_date' => $income_date,
        ]);

        return redirect('/kartoteka')->with('message', 'Operácia sa podarila!');
    }
}