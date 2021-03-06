<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transfer;
use App\Models\Income;
use App\Models\BankAccount;
use App\Models\PeriodicalPublication;
use App\Models\NonperiodicalPublication;
use App\Models\PeriodicalCredit;
use App\Models\NonperiodicalCredit;
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
                    ->orderBy("income_date", "desc")
                    ->orderBy('id', 'desc')
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
        //
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
        Income::where('id', $id)
            ->update([
                'person_id' => $request->person_id,
                'sum' => floatval(str_replace(',', '.', $request->income_sum)),
                'bank_account_id' => $request->bank_account_id,
                'number' => $request->number,
                'package_number' => $request->package_number,
                'invoice' => $request->invoice,
                'note' => $request->income_note,
                'income_date' => date('Y-m-d', strtotime($request->income_date)),
            ]);

        // TRANSFERS
        $transfer_ids = $request->transfer_id;
        $periodical_publication = $request->periodical_publication;
        $nonperiodical_publication = $request->nonperiodical_publication;
        $note = $request->note;
        $sum = $request->sum;
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
				
				Transfer::where('id', $transfer_ids[$key])
                    ->update([
                        "sum" => $p,
                        "periodical_publication_id" => $pp,
                        "nonperiodical_publication_id" => $np,
                        "note" => $n,
                        "sum" => floatval(str_replace(',', '.', $p)),
                        "transfer_date" => $a,
                    ]);

                if( $transfer_ids[$key] === null ){
                    Transfer::create([
                        "income_id" => $id,
                        "sum" => $p,
                        "periodical_publication_id" => $pp,
                        "nonperiodical_publication_id" => $np,
                        "note" => $n,
                        "sum" => floatval(str_replace(',', '.', $p)),
                        "transfer_date" => $a,
                    ]);
                }
			} else {
                // if sum is not defined delete transfer if exists
                $transfer = Transfer::find($transfer_ids[$key]);

                if( $transfer != null ){
                    $transfer->delete($transfer_ids[$key]);
                }
            }
		}
        
        return redirect('/kartoteka/nepotvrdene-prijmy')->with('message', 'Oper??cia sa podarila!');
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

    /**
     * Confirm only one chosen income from the list.
     * method copied from IncomeController.confirmIncomes and modified
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirmIncomeIndividually($id)
    {
        $incomes = Income::where("id", $id)
                ->get();

        foreach( $incomes as $income ){
            foreach( $income->transfers as $transfer ){
                if( $transfer->periodical_publication_id ){
                    $exists = PeriodicalCredit::where("person_id", $income->person_id)
                                        ->where("periodical_publication_id", $transfer->periodical_publication_id)
                                        ->first();

                    if ( $exists ) {
                        PeriodicalCredit::where("person_id", $income->person_id)
                            ->where("periodical_publication_id", $transfer->periodical_publication_id)
                            ->increment("credit", $transfer->sum);
                    } else {
                        PeriodicalCredit::create([
                            "person_id" => $income->person_id,
                            "periodical_publication_id" => $transfer->periodical_publication_id,
                            "credit" => $transfer->sum,
                        ]);
                    }
                }
                
                if( $transfer->nonperiodical_publication_id ){
                    $exists = NonperiodicalCredit::where("person_id", $income->person_id)
                                        ->where("nonperiodical_publication_id", $transfer->nonperiodical_publication_id)
                                        ->first();

                    if ( $exists ) {
                        NonperiodicalCredit::where("person_id", $income->person_id)
                            ->where("nonperiodical_publication_id", $transfer->nonperiodical_publication_id)
                            ->increment("credit", $transfer->sum);
                    } else {
                        NonperiodicalCredit::create([
                            "person_id" => $income->person_id,
                            "nonperiodical_publication_id" => $transfer->nonperiodical_publication_id,
                            "credit" => $transfer->sum,
                        ]);
                    }
                }
            }

            Income::where("id", $income->id)
                ->update([
                    "confirmed" => 1
                ]);
        }

        return redirect('/kartoteka/nepotvrdene-prijmy')->with('message', 'Oper??cia sa podarila!');
    }
}
