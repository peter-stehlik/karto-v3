<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeriodicalPublication;
use App\Models\NonperiodicalPublication;
use App\Models\BankAccount;
use App\Models\Transfer;
use App\Models\Income;
use App\Models\Person;
use App\Models\Correction;
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
     * Generate PDF from daily/mothly filter.
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

    /**
     * Display daily/monthly correction filter.
     *
     * @return \Illuminate\Http\Response
     */
    public function dailyMonthlyCorrectionsFilter()
    {
        return view('v-kancelaria/denne-mesacne-opravy/filter');
    }

    /**
     * Generate PDF from daily/mothly corrections filter.
     *
     * @return \Illuminate\Http\Response
     */
    public function dailyMonthlyCorrectionPdf(Request $request)
    {
		$corrections_from = date('Y-m-d', strtotime($request->corrections_from));
        $corrections_to = date('Y-m-d', strtotime($request->corrections_to));

		$data["corrections_from"] = $corrections_from;
        $data["corrections_to"] = $corrections_to;

        $data["corrections_pp_from"] = Correction::where("confirmed", 1)
			//->where('user_id', $user_id)
            ->whereDate('correction_date','<=', $corrections_to)
            ->whereDate('correction_date','>=', $corrections_from)
			->join("periodical_publications AS p_from", "p_from.id", "=", "corrections.from_periodical_id")
			->groupBy("p_from.id")
			->selectRaw("p_from.name, SUM(corrections.sum) AS sum")
			->get();

        $data["corrections_np_from"] = Correction::where("confirmed", 1)
			//->where('user_id', $user_id)
            ->whereDate('correction_date','<=', $corrections_to)
            ->whereDate('correction_date','>=', $corrections_from)
			->join("nonperiodical_publications AS p_from", "p_from.id", "=", "corrections.from_nonperiodical_id")
			->groupBy("p_from.id")
			->selectRaw("p_from.name, SUM(corrections.sum) AS sum")
			->get();

            $data["corrections_pp_for"] = Correction::where("confirmed", 1)
			//->where('user_id', $user_id)
            ->whereDate('correction_date','<=', $corrections_to)
            ->whereDate('correction_date','>=', $corrections_from)
			->join("periodical_publications AS p_for", "p_for.id", "=", "corrections.for_periodical_id")
			->groupBy("p_for.id")
			->selectRaw("p_for.name, SUM(corrections.sum) AS sum")
			->get();

        $data["corrections_np_for"] = Correction::where("confirmed", 1)
			//->where('user_id', $user_id)
            ->whereDate('correction_date','<=', $corrections_to)
            ->whereDate('correction_date','>=', $corrections_from)
			->join("nonperiodical_publications AS p_for", "p_for.id", "=", "corrections.for_nonperiodical_id")
			->groupBy("p_for.id")
			->selectRaw("p_for.name, SUM(corrections.sum) AS sum")
			->get();

        $pdf = PDF::loadView('pdf.denne-mesacne-opravy', $data);
		return $pdf->stream('denne-mesacne-opravy.pdf');
    }

    /**
     * Display Tlac pre ucel - filter.
     *
     * @return \Illuminate\Http\Response
     */
    public function printForTransfer()
    {
        $periodical_publications = PeriodicalPublication::get();
        $nonperiodical_publications = NonperiodicalPublication::get();
        $bank_accounts = BankAccount::get();

        return view('v-kancelaria/tlac-pre-ucel/filter')
            ->with("bank_accounts", $bank_accounts)
            ->with("periodical_publications", $periodical_publications)
            ->with("nonperiodical_publications", $nonperiodical_publications);
    }

    /**
     * Generate PDF from print for transfer filter.
     *
     * @return \Illuminate\Http\Response
     */
    public function printForTransferPdf(Request $request)
    {
        $date_from = date('Y-m-d', strtotime($request->date_from));
        $date_to = date('Y-m-d', strtotime($request->date_to));
        $bank_account_id = $request->bank_account_id;
        $transfer_type_id = $request->transfer_type_id;
        $transfer_type_name = "";
        $data["people"] = "";

        if( substr($transfer_type_id, 0, 3) === "np_" ){ // nonperiodical
            $transfer_type_id = intval(ltrim($transfer_type_id, "np_"));

            $transfer_type_name = NonperiodicalPublication::find($transfer_type_id)->name;

            $data["people"] = Transfer::where("nonperiodical_publication_id", $transfer_type_id)
                                        ->where("incomes.confirmed", 1)
                                        ->whereDate('transfer_date','<=', $date_to)
                                        ->whereDate('transfer_date','>=', $date_from)
                                        ->join("incomes", "incomes.id", "=", "transfers.income_id")
                                        ->join("people", "people.id", "=", "incomes.person_id")
                                        ->select("transfer_date", "people.title", "name1", "address1", "city", "zip_code", "number", "transfers.sum", "transfers.note")
                                        ->orderBy("transfer_date", "desc")
                                        ->get();
        } else { // periodical
            $transfer_type_name = PeriodicalPublication::find($transfer_type_id)->name;

            $data["people"] = Transfer::where("periodical_publication_id", $transfer_type_id)
                                        ->where("incomes.confirmed", 1)
                                        ->whereDate('transfer_date','<=', $date_to)
                                        ->whereDate('transfer_date','>=', $date_from)
                                        ->join("incomes", "incomes.id", "=", "transfers.income_id")
                                        ->join("people", "people.id", "=", "incomes.person_id")
                                        ->select("transfer_date", "people.title", "name1", "address1", "city", "zip_code", "number", "transfers.sum", "transfers.note")
                                        ->orderBy("transfer_date", "desc")
                                        ->get();
        }

        $data["date_from"] = $date_from;
        $data["date_to"] = $date_to;

		$data["bank"] = BankAccount::find($bank_account_id);
		$data["transfer_type_name"] = $transfer_type_name;


        $pdf = PDF::loadView('pdf.tlac-pre-ucel', $data);
		return $pdf->stream('tlac-pre-ucel.pdf');
    }

    /**
     * Vydavatelstvo - Zoznam
     * zobraz filter periodik podla datumu stitkov
     *
     * @return \Illuminate\Http\Response
     */
    public function getListFilter()
    {
        $periodical_publications = PeriodicalPublication::get();

        return view('v-vydavatelstvo/zoznam')
            ->with("periodical_publications", $periodical_publications);
    }

    public function getVydavatelstvo()
    {
        $periodical_publications = PeriodicalPublication::get();

        return view('v-vydavatelstvo/vydavatelstvo')
            ->with("periodical_publications", $periodical_publications);
    }

    public function getNoveCislo()
    {
        $periodical_publications = PeriodicalPublication::get();

        return view('v-vydavatelstvo/nove-cislo')
            ->with("periodical_publications", $periodical_publications);
    }

    public function postNoveCislo(Request $request)
    {
        $pp_id = $request->pp_id;

        $pp = PeriodicalPublication::find($pp_id);

        $current_number = ($pp->current_number === 12) ? 1 : ($pp->current_number+1);
        $current_volume = ($pp->current_number === 12) ? ($pp->current_volume+1) : $pp->current_volume;
        $label_date = $current_volume . "-" . $current_number . "-01";

        PeriodicalPublication::where("id", $pp_id)
            ->update([
                "label_date" => $label_date,
                "current_number" => $current_number,
                "current_volume" => $current_volume,
            ]);

        return redirect('/vydavatelstvo')->with('message', 'Operácia sa podarila!');
    }
}
