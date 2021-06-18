<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transfer;
use App\Models\Income;
use App\Models\BankAccount;
use App\Models\PeriodicalPublication;
use App\Models\NonperiodicalPublication;
use Auth;

class IncomeUnconfirmedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $incomes = Income::where("confirmed", 0)
                    ->where("user_id", Auth::user()->id)
                    ->get();
        $periodicals = PeriodicalPublication::get();
        $nonperiodicals = NonperiodicalPublication::get();

        return view('v-kartoteka/nepotvrdene-prijmy/index')
                    ->with('incomes', $incomes)
                    ->with('periodicals', $periodicals)
                    ->with('nonperiodicals', $nonperiodicals);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return "store";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $income = Income::find($id);
        $periodicals = PeriodicalPublication::get();
		$nonperiodicals = NonperiodicalPublication::get();
		$bank_accounts = BankAccount::get();

        return view('v-kartoteka/nepotvrdene-prijmy/edit')
            ->with('periodicals', $periodicals)
            ->with('nonperiodicals', $nonperiodicals)
            ->with('bank_accounts', $bank_accounts)
            ->with('income', $income);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Income::find($id)->delete($id);
        Transfer::where("income_id", $id)->delete();

        return response()->json([
            'success' => '1'
        ]);
    }
}
