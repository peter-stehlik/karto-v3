<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankAccount;
use App\Models\Transfer;
use App\Models\Income;
use PDF;

class ListingController extends Controller
{
    /**
     * Display daily/monthly filter.
     *
     * @return \Illuminate\Http\Response
     */
    public function dailyMonthlyListingFilter()
    {
        $bank_accounts = BankAccount::get();

        return view('v-kancelaria/denny-mesacny-vypis/filter')
            ->with("bank_accounts", $bank_accounts);
    }

    /**
     * Generate PDF from daily/mothly filter filter.
     *
     * @return \Illuminate\Http\Response
     */
    public function dailyMonthlyListingPdf(Request $request)
    {
		$bank_account_id = $request->bank_account_id;
		$date_from = date('Y-m-d', strtotime($request->date_from));
        $date_to = date('Y-m-d', strtotime($request->date_to));
		$current_year = date('Y');
		// $user_id = Auth::user()->id;

		$data["date_from"] = $date_from;
        $data["date_to"] = $date_to;

		$data["bank"] = BankAccount::find($bank_account_id);	
		
		$data["total_incomes"] = Income::where('confirmed', 1)
			// ->where('user_id', $user_id)
			->where('bank_account_id', $bank_account_id)
            ->whereDate('income_date','<=', $date_to)
            ->whereDate('income_date','>=', $date_from)
			->sum('sum');
		
		$data["total_transfers"] = Transfer::where('confirmed', 1)
    		// ->where('user_id', $user_id)
			->where('bank_account_id', $bank_account_id)
            ->join("incomes", "incomes.id", "=", "transfers.income_id")
            ->whereDate('income_date','<=', $date_to)
            ->whereDate('income_date','>=', $date_from)
			->sum('transfers.sum');
			
		$data["on_the_way"] = $data["total_incomes"] - $data["total_transfers"];
			
		$data["periodicalThisYear"] = Transfer::where("confirmed", 1)
			//->where('user_id', $user_id)
			->where('incomes.bank_account_id', $bank_account_id)
            ->whereDate('income_date','<=', $date_to)
            ->whereDate('income_date','>=', $date_from)
			->whereYear("incomes.income_date", "=", $current_year)
            ->join("incomes", "incomes.id", "=", "transfers.income_id")
			->join("periodical_publications", "periodical_publications.id", "=", "transfers.periodical_publication_id")
			->groupBy("periodical_publications.id")
			->selectRaw("periodical_publications.name, SUM(transfers.sum) AS sum")
			->get();
			
		$data["nonperiodicalThisYear"] = Transfer::where("confirmed", 1)
            //->where('user_id', $user_id)
            ->where('incomes.bank_account_id', $bank_account_id)
            ->whereDate('income_date','<=', $date_to)
            ->whereDate('income_date','>=', $date_from)
            ->whereYear("incomes.income_date", "=", $current_year)
            ->join("incomes", "incomes.id", "=", "transfers.income_id")
            ->join("nonperiodical_publications", "nonperiodical_publications.id", "=", "transfers.nonperiodical_publication_id")
            ->groupBy("nonperiodical_publications.id")
            ->selectRaw("nonperiodical_publications.name, SUM(transfers.sum) AS sum")
            ->get();

		$data["periodicalInvoiceThisYear"] = Transfer::where("confirmed", 1)
			// ->where('user_id', $user_id)
			->where('bank_account_id', $bank_account_id)
            ->whereDate('income_date','<=', $date_to)
            ->whereDate('income_date','>=', $date_from)
            ->whereYear("incomes.income_date", "=", $current_year)
			->where("invoice", "!=", "")
            ->join("incomes", "incomes.id", "=", "transfers.income_id")
			->join("periodical_publications", "periodical_publications.id", "=", "transfers.periodical_publication_id")
			->groupBy("periodical_publications.id")
			->selectRaw("periodical_publications.name, SUM(transfers.sum) AS sum")
			->get();

		$data["nonperiodicalInvoiceThisYear"] = Transfer::where("confirmed", 1)
            // ->where('user_id', $user_id)
            ->where('bank_account_id', $bank_account_id)
            ->whereDate('income_date','<=', $date_to)
            ->whereDate('income_date','>=', $date_from)
            ->whereYear("incomes.income_date", "=", $current_year)
            ->where("invoice", "!=", "")
            ->join("incomes", "incomes.id", "=", "transfers.income_id")
            ->join("nonperiodical_publications", "nonperiodical_publications.id", "=", "transfers.nonperiodical_publication_id")
            ->groupBy("nonperiodical_publications.id")
            ->selectRaw("nonperiodical_publications.name, SUM(transfers.sum) AS sum")
            ->get();


		$data["periodicalNextYear"] = Transfer::where("confirmed", 1)
			// ->where('user_id', $user_id)
			->where('bank_account_id', $bank_account_id)
			->whereYear("incomes.income_date", ">", $current_year)
            ->join("incomes", "incomes.id", "=", "transfers.income_id")
			->join("periodical_publications", "periodical_publications.id", "=", "transfers.periodical_publication_id")
			->groupBy("periodical_publications.id")
			->selectRaw("periodical_publications.name, SUM(transfers.sum) AS sum")
			->get();

		$data["nonperiodicalNextYear"] = Transfer::where("confirmed", 1)
        // ->where('user_id', $user_id)
        ->where('bank_account_id', $bank_account_id)
        ->whereYear("incomes.income_date", ">", $current_year)
        ->join("incomes", "incomes.id", "=", "transfers.income_id")
        ->join("nonperiodical_publications", "nonperiodical_publications.id", "=", "transfers.nonperiodical_publication_id")
        ->groupBy("nonperiodical_publications.id")
        ->selectRaw("nonperiodical_publications.name, SUM(transfers.sum) AS sum")
        ->get();

        $pdf = PDF::loadView('pdf.denny-mesacny-vypis', $data);
		return $pdf->stream('denny-mesacny-vypis.pdf');
    }
}
