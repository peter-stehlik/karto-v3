<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeriodicalPublication;
use App\Models\NonperiodicalPublication;
use App\Models\BankAccount;
use App\Models\Transfer;
use App\Models\Income;
use App\Models\Outcome;
use App\Models\Person;
use App\Models\Correction;
use App\Models\PeriodicalOrder;
use App\Models\PeriodicalCredit;
use App\Models\PostedPeriodicalPublication;
use Auth;
use PDF;
use DB;
use Carbon\Carbon;

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
        $date_to = date('Y-m-d', strtotime("1.1.3000"));
        if( strlen($request->date_to) > 0 ){
            $date_to = date('Y-m-d', strtotime($request->date_to));
        }
		$current_year = date('Y');
		// $user_id = Auth::user()->id;

		$data["date_from"] = $date_from;
        $data["date_to"] = $date_to;

		$data["bank"] = BankAccount::find($bank_account_id);	
		
		$data["total_incomes"] = Income::where('confirmed', 1)
			// ->where('user_id', $user_id)
            ->where(function($query) use ($bank_account_id){
                if($bank_account_id > 0){
					$query->where('bank_account_id', $bank_account_id);
				}
            })
            ->whereDate('income_date','<=', $date_to)
            ->whereDate('income_date','>=', $date_from)
			->sum('sum');
		
		$data["total_transfers"] = Transfer::where('confirmed', 1)
    		// ->where('user_id', $user_id)
            ->where(function($query) use ($bank_account_id){
                if($bank_account_id > 0){
					$query->where('bank_account_id', $bank_account_id);
				}
            })
            ->join("incomes", "incomes.id", "=", "transfers.income_id")
            ->whereDate('income_date','<=', $date_to)
            ->whereDate('income_date','>=', $date_from)
			->sum('transfers.sum');
			
		$data["on_the_way"] = $data["total_incomes"] - $data["total_transfers"];
			
		$data["periodicalThisYear"] = Transfer::where("confirmed", 1)
			//->where('user_id', $user_id)
            ->where(function($query) use ($bank_account_id){
                if($bank_account_id > 0){
					$query->where('incomes.bank_account_id', $bank_account_id);
				}
            })
            ->whereDate('transfer_date','<=', $date_to)
            ->whereDate('transfer_date','>=', $date_from)
			->whereYear("transfer_date", "=", $current_year)
            ->join("incomes", "incomes.id", "=", "transfers.income_id")
			->join("periodical_publications", "periodical_publications.id", "=", "transfers.periodical_publication_id")
			->groupBy("periodical_publications.id")
			->selectRaw("periodical_publications.name, SUM(transfers.sum) AS sum")
			->get();
			
		$data["nonperiodicalThisYear"] = Transfer::where("confirmed", 1)
            //->where('user_id', $user_id)
            ->where(function($query) use ($bank_account_id){
                if($bank_account_id > 0){
					$query->where('incomes.bank_account_id', $bank_account_id);
				}
            })
            ->whereDate('transfer_date','<=', $date_to)
            ->whereDate('transfer_date','>=', $date_from)
            ->whereYear("transfer_date", "=", $current_year)
            ->join("incomes", "incomes.id", "=", "transfers.income_id")
            ->join("nonperiodical_publications", "nonperiodical_publications.id", "=", "transfers.nonperiodical_publication_id")
            ->groupBy("nonperiodical_publications.id")
            ->selectRaw("nonperiodical_publications.name, SUM(transfers.sum) AS sum")
            ->get();

		$data["periodicalInvoiceThisYear"] = Transfer::where("confirmed", 1)
			// ->where('user_id', $user_id)
			->where(function($query) use ($bank_account_id){
                if($bank_account_id > 0){
					$query->where('incomes.bank_account_id', $bank_account_id);
				}
            })
            ->whereDate('transfer_date','<=', $date_to)
            ->whereDate('transfer_date','>=', $date_from)
            ->whereYear("transfer_date", "=", $current_year)
			->where("invoice", "!=", "")
            ->join("incomes", "incomes.id", "=", "transfers.income_id")
			->join("periodical_publications", "periodical_publications.id", "=", "transfers.periodical_publication_id")
			->groupBy("periodical_publications.id")
			->selectRaw("periodical_publications.name, SUM(transfers.sum) AS sum")
			->get();

		$data["nonperiodicalInvoiceThisYear"] = Transfer::where("confirmed", 1)
            // ->where('user_id', $user_id)
            ->where(function($query) use ($bank_account_id){
                if($bank_account_id > 0){
					$query->where('incomes.bank_account_id', $bank_account_id);
				}
            })
            ->whereDate('transfer_date','<=', $date_to)
            ->whereDate('transfer_date','>=', $date_from)
            ->whereYear("transfer_date", "=", $current_year)
            ->where("invoice", "!=", "")
            ->join("incomes", "incomes.id", "=", "transfers.income_id")
            ->join("nonperiodical_publications", "nonperiodical_publications.id", "=", "transfers.nonperiodical_publication_id")
            ->groupBy("nonperiodical_publications.id")
            ->selectRaw("nonperiodical_publications.name, SUM(transfers.sum) AS sum")
            ->get();


		$data["periodicalNextYear"] = Transfer::where("confirmed", 1)
			// ->where('user_id', $user_id)
			->where(function($query) use ($bank_account_id){
                if($bank_account_id > 0){
					$query->where('incomes.bank_account_id', $bank_account_id);
				}
            })
			->whereYear("transfer_date", ">", $current_year)
            ->join("incomes", "incomes.id", "=", "transfers.income_id")
			->join("periodical_publications", "periodical_publications.id", "=", "transfers.periodical_publication_id")
			->groupBy("periodical_publications.id")
			->selectRaw("periodical_publications.name, SUM(transfers.sum) AS sum")
			->get();

		$data["nonperiodicalNextYear"] = Transfer::where("confirmed", 1)
        // ->where('user_id', $user_id)
        ->where(function($query) use ($bank_account_id){
            if($bank_account_id > 0){
                $query->where('incomes.bank_account_id', $bank_account_id);
            }
        })
        ->whereYear("transfer_date", ">", $current_year)
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
        $corrections_to = date('Y-m-d', strtotime("1.1.3000"));
        if( strlen($request->corrections_to) > 0 ){
            $corrections_to = date('Y-m-d', strtotime($request->corrections_to));
        }

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
        $date_to = date('Y-m-d', strtotime("1.1.3000"));
        if( $request->date_to ){
            $date_to = date('Y-m-d', strtotime($request->date_to));
        }
        $date_to;
        $bank_account_id = $request->bank_account_id;
        $transfer_type_id = $request->transfer_type_id;
        $transfer_type_name = "";
        $data["people"] = "";

        if( substr($transfer_type_id, 0, 3) === "np_" ){ // nonperiodical
            $transfer_type_id = intval(ltrim($transfer_type_id, "np_"));

            $transfer_type_name = NonperiodicalPublication::find($transfer_type_id)->name;

            $data["people"] = Transfer::where("nonperiodical_publication_id", $transfer_type_id)
                                        ->where("incomes.confirmed", 1)
                                        ->where(function($query) use ($bank_account_id) {
                                            if($bank_account_id){
                                                $query->where('incomes.bank_account_id', $bank_account_id);
                                            }
                                        })
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
                                        ->where(function($query) use ($bank_account_id) {
                                            if($bank_account_id){
                                                $query->where('incomes.bank_account_id', $bank_account_id);
                                            }
                                        })
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
    public function getZoznamFilter()
    {
        $periodical_publications = PeriodicalPublication::get();

        return view('v-vydavatelstvo/zoznam')
            ->with("periodical_publications", $periodical_publications);
    }

    /**
     * Vydavatelstvo - Zoznam
     * vysledky filtra
     *
     * @return \Illuminate\Http\Response
     */
    public function getZoznamFilterJSON()
    {
        $periodical_publication_ids = $_GET["periodical_publication_ids"];
        $pp_ids = [];

        foreach( $periodical_publication_ids as $pp ){
            $pp_id = intval($pp);

            array_push($pp_ids, $pp_id);
        }

        $people = PeriodicalOrder::join("people", "periodical_orders.person_id", "=", "people.id")
                    ->join("periodical_publications", "periodical_orders.periodical_publication_id", "=", "periodical_publications.id")
                    ->join("periodical_credits", "periodical_publications.id", "=", "periodical_credits.periodical_publication_id")
                    ->whereDate("valid_from", "<=", DB::raw("periodical_publications.label_date"))
                    ->whereDate("valid_to", ">=", DB::raw("periodical_publications.label_date"))
                    ->whereIn("periodical_orders.periodical_publication_id", $pp_ids)
                    ->select("people.id AS person_id", "title", "name1", "address1", "zip_code", "city", "name", "count", "valid_from", "valid_to", "periodical_orders.note", "credit")
                    ->get();

        $data = array('result' => 1);
        
        $data["list"] = $people;

		return response()->json($data);
    }

    /**
     * Vydavatelstvo - Zoznam
     * generovanie PDF zoznamu
     *
     * @return \Illuminate\Http\Response
     */
    public function printListFilterPdf(Request $request)
    {
        $periodical_publication_ids = $request->periodical_publication_ids;

        $data["people"] = PeriodicalOrder::join("people", "periodical_orders.person_id", "=", "people.id")
                    ->join("periodical_publications", "periodical_orders.periodical_publication_id", "=", "periodical_publications.id")
                    ->whereDate("valid_from", "<=", DB::raw("periodical_publications.label_date"))
                    ->whereDate("valid_to", ">=", DB::raw("periodical_publications.label_date"))
                    ->whereIn("periodical_publication_id", $periodical_publication_ids)
                    ->select("people.id AS person_id", "title", "name1", "address1", "zip_code", "city", "name", "count", "valid_from", "valid_to", "periodical_orders.note")
                    ->get();

        $pdf = PDF::loadView('pdf.zoznam', $data);
        return $pdf->stream('zoznam.pdf');
    }

    /**
     * Vydavatelstvo - Objednavky periodicke
     * zobraz filter periodik podla datumu stitkov a poctu
     *
     * @return \Illuminate\Http\Response
     */
    public function getObjPeriodickeFilter()
    {
        $periodical_publications = PeriodicalPublication::get();

        return view('v-vydavatelstvo/objednavky-periodicke')
            ->with("periodical_publications", $periodical_publications);
    }

    /**
     * Vydavatelstvo - Objednavky periodicke
     * vysledky filtra
     *
     * @return \Illuminate\Http\Response
     */
    public function getObjPeriodickeFilterJSON()
    {
        $count_from = $_GET["count_from"];
        $count_to = $_GET["count_to"];
        $periodical_publication_id = $_GET["periodical_publication_id"];

        $people = PeriodicalOrder::join("people", "periodical_orders.person_id", "=", "people.id")
                    ->join("periodical_publications", "periodical_orders.periodical_publication_id", "=", "periodical_publications.id")
                    ->whereDate("valid_from", "<=", DB::raw("periodical_publications.label_date"))
                    ->whereDate("valid_to", ">=", DB::raw("periodical_publications.label_date"))
                    ->where("periodical_publication_id", $periodical_publication_id)
                    ->where(function($query) use ($count_from, $count_to){
                        if($count_from > 0){
                            $query->where('count', '>=', $count_from);
                        }
                        if($count_to > 0){
                            $query->where('count', '<=', $count_to);
                        }
                    })
                    ->select("people.id AS person_id", "title", "name1", "address1", "zip_code", "city", "name", "count", "valid_from", "valid_to", "periodical_orders.note")
                    ->get();

        $data = array('result' => 1);
        
        $data["obj_periodical"] = $people;

		return response()->json($data);
    }

    /* Vydavatelstvo - Pocet objednavok */
    public function getPocetObj()
    {
        $periodical_publications = PeriodicalPublication::get();

        $maly_kalendar_id = PeriodicalPublication::where("name", "LIKE", "%" . "malý kalendár" . "%")->first()->id;
        $maly_kalendar = PostedPeriodicalPublication::where("periodical_publication_id", $maly_kalendar_id)
                                        ->take(12)
                                        ->orderBy("created_at", "desc")
                                        ->get();

        $kalendar_nastenny_id = PeriodicalPublication::where("name", "LIKE", "%" . "kalendár nástenný" . "%")->first()->id;
        $kalendar_nastenny = PostedPeriodicalPublication::where("periodical_publication_id", $kalendar_nastenny_id)
                                        ->take(12)
                                        ->orderBy("created_at", "desc")
                                        ->get();

        $kalendar_knizny_id = PeriodicalPublication::where("name", "LIKE", "%" . "kalendár knižný" . "%")->first()->id;
        $kalendar_knizny = PostedPeriodicalPublication::where("periodical_publication_id", $kalendar_knizny_id)
                                        ->take(12)
                                        ->orderBy("created_at", "desc")
                                        ->get();

        $hlasy_id = PeriodicalPublication::where("name", "LIKE", "%" . "hlasy" . "%")->first()->id;
        $hlasy = PostedPeriodicalPublication::where("periodical_publication_id", $hlasy_id)
                                        ->take(12)
                                        ->orderBy("created_at", "desc")
                                        ->get();

        return view('v-vydavatelstvo/pocet-objednavok')
                ->with("periodical_publications", $periodical_publications)
                ->with("maly_kalendar", $maly_kalendar)
                ->with("kalendar_nastenny", $kalendar_nastenny)
                ->with("hlasy", $hlasy)
                ->with("kalendar_knizny", $kalendar_knizny);
    }

    /* Vydavatelstvo - Pocet objednavok filter */
    public function getPocetObjFilterJSON()
    {
        $month = $_GET["month"];
        $year = $_GET["year"];
        $periodical_publication_id = $_GET["periodical_publication_id"];
        $date_to_compare = $year . "-" . $month . "-01";

        $count = PeriodicalOrder::where("periodical_publication_id", $periodical_publication_id)
                                ->whereDate("periodical_orders.valid_from", "<=", $date_to_compare)
                                ->whereDate("periodical_orders.valid_to", ">=", $date_to_compare)
                                ->sum('count');

        $data = array('result' => 1);
        
        $data["count"] = $count;

		return response()->json($data);
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
        $label_date = $pp->label_date;

        PeriodicalPublication::where("id", $pp_id)
            ->update([
                "label_date" => Carbon::parse($label_date)->addMonth(),
                "current_number" => $current_number,
                "current_volume" => $current_volume,
            ]);

        return redirect('/vydavatelstvo')->with('message', 'Operácia sa podarila!');
    }

    public function getZauctovat()
    {
        $periodical_publications = PeriodicalPublication::get();

        return view('v-vydavatelstvo/zauctovat')
            ->with("periodical_publications", $periodical_publications);
    }

    public function postZauctovat(Request $request)
    {
        $pp_id = $request->pp_id;
        $user_id = Auth::user()->id;
        $periodical_name = PeriodicalPublication::find($pp_id)->name; 
        $current_number = PeriodicalPublication::find($pp_id)->current_number;
        $current_volume = PeriodicalPublication::find($pp_id)->current_volume;
        $label_date = PeriodicalPublication::find($pp_id)->label_date;

        // zaznamenat zauctovanie
        $posted = PostedPeriodicalPublication::create([
            "user_id" => $user_id,
            "periodical_publication_id" => $pp_id,
            "label_date" => $label_date,
            "posted_number" => $current_number,
            "posted_volume" => $current_volume,
        ]);

        // posunut uctovny datum na nasledujuci mesiac
        $accounting_date = PeriodicalPublication::find($pp_id)->accounting_date;

        PeriodicalPublication::where("id", $pp_id)
            ->update([
                "accounting_date" => Carbon::parse($accounting_date)->addMonth(),
            ]);

        // odobrat platbu za periodikum
        $periodical_orders = PeriodicalOrder::whereDate("periodical_orders.valid_from", "<=", $accounting_date)
                        ->whereDate("periodical_orders.valid_to", ">=", $accounting_date)
                        ->where("periodical_orders.periodical_publication_id", $pp_id)
                        ->where("gratis", 0)
                        ->join("periodical_credits", "periodical_orders.person_id", "=", "periodical_credits.person_id")
                        ->where("periodical_credits.periodical_publication_id", $pp_id)
                        ->get();

        $periodical_price = PeriodicalPublication::find($pp_id)->price;

        $total_count = 0;
        foreach( $periodical_orders as $order ){
            $count = $order->count;
            $minus = $count*$periodical_price;
            $new_credit = $order->credit - $minus;
            $total_count += $count;

            PeriodicalCredit::where("id", $order->id)
            ->update([
                "credit" => $new_credit,
            ]);

            // poznacit vydavok
            Outcome::create([
                "person_id" => $order->person_id,
                "sum" => $minus,
                "goal" => "Zauctovanie: " . $periodical_name . ", ID: " . $posted->id,
            ]);
        }

        // poznacit kolko periodik bolo zauctovanych
        PostedPeriodicalPublication::where("id", $posted->id)
            ->update([
                "total_count" => $total_count,
        ]);

        return redirect('/vydavatelstvo')->with('message', 'Operácia sa podarila!');
    }

    public function getNeplatici()
    {
        $overall = PeriodicalCredit::join("periodical_publications", "periodical_credits.periodical_publication_id", "=", "periodical_publications.id") 
                                    ->where("credit", "<", 0)
                                    ->groupBy("periodical_publication_id")
                                    ->select(DB::raw("name, SUM(credit) as credit"))
                                    ->get();

        $maly_kalendar_id = PeriodicalPublication::where("name", "LIKE", "%" . "maly kalendar" . "%")->first()->id;                            
        $kalendar_nastenny_id = PeriodicalPublication::where("name", "LIKE", "%" . "kalendar nastenny" . "%")->first()->id;
        $kalendar_knizny_id = PeriodicalPublication::where("name", "LIKE", "%" . "kalendar knizny" . "%")->first()->id;
        $hlasy_id = PeriodicalPublication::where("name", "LIKE", "%" . "hlasy" . "%")->first()->id;

        $people = Person::join("periodical_credits", "people.id", "=", "periodical_credits.person_id")
                        ->where("periodical_credits.credit", "<", -3)
                        ->select("people.id", "title", "name1", "address1", "zip_code", "city")
                        ->get();

        $list = [];

        foreach( $people as $p ){
            $hlasy = PeriodicalCredit::where("person_id", $p->id)
                                    ->where("periodical_publication_id", $hlasy_id)
                                    ->sum("credit");

            $maly_kalendar = PeriodicalCredit::where("person_id", $p->id)
                                    ->where("periodical_publication_id", $maly_kalendar_id)
                                    ->sum("credit");

            $kalendar_nastenny = PeriodicalCredit::where("person_id", $p->id)
                                    ->where("periodical_publication_id", $kalendar_nastenny_id)
                                    ->sum("credit");

            $kalendar_knizny = PeriodicalCredit::where("person_id", $p->id)
                                    ->where("periodical_publication_id", $kalendar_knizny_id)
                                    ->sum("credit");

            $list_item = [
                "id" => $p->id,
                "title" => $p->title,
                "name1" => $p->name1,
                "address1" => $p->address1,
                "zip_code" => $p->zip_code,
                "city" => $p->city,
                "hlasy_credit" => $hlasy,
                "maly_kalendar_credit" => $maly_kalendar,
                "kalendar_nastenny_credit" => $kalendar_nastenny,
                "kalendar_knizny_credit" => $kalendar_knizny,
            ];

            array_push($list, $list_item);
        }

        return view('v-vydavatelstvo/neplatici')
            ->with("overall", $overall)
            ->with("people", $list);
    }

    public function getTlacNeplaticov()
    {
        $periodical_publications = PeriodicalPublication::get();

        return view('v-vydavatelstvo/neplatici-tlac')
            ->with("periodical_publications", $periodical_publications);
    }

    public function printNeplaticiPdf(Request $request)
    {
        $periodical_publication_id = $request->periodical_publication_id;

        $maly_kalendar_id = PeriodicalPublication::where("name", "LIKE", "%" . "maly kalendar" . "%")->first()->id;                            
        $kalendar_nastenny_id = PeriodicalPublication::where("name", "LIKE", "%" . "kalendar nastenny" . "%")->first()->id;
        $kalendar_knizny_id = PeriodicalPublication::where("name", "LIKE", "%" . "kalendar knizny" . "%")->first()->id;
        $hlasy_id = PeriodicalPublication::where("name", "LIKE", "%" . "hlasy" . "%")->first()->id;

        $people = Person::join("periodical_credits", "people.id", "=", "periodical_credits.person_id")
                        ->where("periodical_credits.credit", "<", -3)
                        ->where(function($query) use ($periodical_publication_id){
                            if( $periodical_publication_id > 0 ){
                                $query->where("periodical_credits.periodical_publication_id", $periodical_publication_id);
                            }
                        })
                        ->select("people.id", "title", "name1", "address1", "zip_code", "city")
                        ->get();

        $list = [];

        foreach( $people as $p ){
            $hlasy = PeriodicalCredit::where("person_id", $p->id)
                                    ->where("periodical_publication_id", $hlasy_id)
                                    ->sum("credit");

            $maly_kalendar = PeriodicalCredit::where("person_id", $p->id)
                                    ->where("periodical_publication_id", $maly_kalendar_id)
                                    ->sum("credit");

            $kalendar_nastenny = PeriodicalCredit::where("person_id", $p->id)
                                    ->where("periodical_publication_id", $kalendar_nastenny_id)
                                    ->sum("credit");

            $kalendar_knizny = PeriodicalCredit::where("person_id", $p->id)
                                    ->where("periodical_publication_id", $kalendar_knizny_id)
                                    ->sum("credit");

            $list_item = [
                "id" => $p->id,
                "title" => $p->title,
                "name1" => $p->name1,
                "address1" => $p->address1,
                "zip_code" => $p->zip_code,
                "city" => $p->city,
                "hlasy_credit" => $hlasy,
                "maly_kalendar_credit" => $maly_kalendar,
                "kalendar_nastenny_credit" => $kalendar_nastenny,
                "kalendar_knizny_credit" => $kalendar_knizny,
            ];

            array_push($list, $list_item);
        }

        $data["people"] = $list;


        $pdf = PDF::loadView('pdf.tlac-neplaticov', $data);
		return $pdf->stream('neplatici.pdf');
    }
}
