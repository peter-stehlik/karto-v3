<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankAccount;
use App\Models\PeriodicalPublication;
use App\Models\NonperiodicalPublication;
use App\Models\PeriodicalOrder;
use App\Models\NonperiodicalOrder;
use App\Models\Income;
use App\Models\Outcome;
use App\Models\Transfer;
use App\Models\Person;
use App\Models\Category;
use App\Models\Correction;
use Auth;
use DB;

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
		$categories = Category::get();

        return view('v-kartoteka/prijem')
				->with('categories', $categories)
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
			if( $value && ( isset( $periodical_publication[$key] ) || isset( $nonperiodical_publication[$key] ) ) ){
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

        return redirect('/kartoteka/nepotvrdene-prijmy')->with('message', 'Operácia sa podarila!');
    }
	/**
     * Autocomplete search for people.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function autocomplete()
	{
		$name1 = $_GET['search_name'];
		$city = $_GET['search_city'];
		$address = $_GET['search_address'];
		$zip_code = $_GET['search_zip_code'];
		
		$people = DB::table('people')
			->where(function($query) use ($name1, $city, $address, $zip_code) {
				if($name1){
					$query->where('name1', 'like', '%' . $name1 . '%');
				}
				if($city){
					$query->where('city', 'like', '%' . $city . '%');
				}
				if($address){
					$query->where('address1', 'like', '%' . $address . '%');
				}
				if($zip_code){
					$query->where('zip_code', 'like', '%' . $zip_code . '%');
				}
			})->whereNull('deleted_at')->get();
		
		$data = array('result' => 1);
		
		if( $people ){
			foreach( $people as $person ){
				$data["people"][] = [
					"id" => $person->id,
					"name1" => $person->name1,
					"address" => $person->address1,
					"city" => $person->city,
					"zip_code" => $person->zip_code,
				];
			}
		}
		
		return response()->json($data);
	}

	/**
     * Create new person on the fly.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function createNewPerson()
	{
		Person::create([
			"category_id" => $_GET["category_id"],
			"title" => $_GET["title"],
			"name1" => $_GET["name1"],
			"address1" => $_GET["address1"],
			"address2" => $_GET["address2"],
			"organization" => $_GET["organization"],
			"zip_code" => $_GET["zip_code"],
			"city" => $_GET["city"],
			"state" => $_GET["state"],
			"email" => $_GET["email"],
			"note" => $_GET["note"],
		]);

		$data = array('result' => 1);
		
		return response()->json($data);
	}

	/**
     * Confirm unconfirmed incomes - preview.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function unconfirmedIncomesSummary()
	{
		$user_id = Auth::user()->id;
		$current_year = date('Y');

		$all_incomes = Income::where('confirmed', 0)
			->where("incomes.deleted_at", NULL)
			->where('user_id', $user_id)
			->sum('sum');
		
		$all_transfers = Income::where('confirmed', 0)
			->join('transfers', 'transfers.income_id', '=', 'incomes.id')
			->where('user_id', $user_id)
			->where("incomes.deleted_at", NULL)
			->where("transfers.deleted_at", NULL)
			->sum('transfers.sum');

		$on_the_way = $all_incomes - $all_transfers;
			
		$periodicalThisYear = Transfer::whereYear("transfer_date", "=", $current_year)
			->join("incomes", "incomes.id", "=", "transfers.income_id")
			->where("user_id", $user_id)
			->where('confirmed', 0)
			->where("invoice", NULL)
			->where("transfers.deleted_at", NULL)
			->join("periodical_publications", "periodical_publications.id", "=", "transfers.periodical_publication_id")
			->groupBy("periodical_publications.id")
			->selectRaw("name, SUM(transfers.sum) AS sum")
			->get();

		$nonperiodicalThisYear = Transfer::whereYear("transfer_date", "=", $current_year)
			->join("incomes", "incomes.id", "=", "transfers.income_id")
			->where("user_id", $user_id)
			->where('confirmed', 0)
			->where("invoice", NULL)
			->where("transfers.deleted_at", NULL)
			->join("nonperiodical_publications", "nonperiodical_publications.id", "=", "transfers.nonperiodical_publication_id")
			->groupBy("nonperiodical_publications.id")
			->selectRaw("name, SUM(transfers.sum) AS sum")
			->get();

		$periodicalThisYearInvoice = Transfer::whereYear("transfer_date", "=", $current_year)
			->join("incomes", "incomes.id", "=", "transfers.income_id")
			->where("user_id", $user_id)
			->where('confirmed', 0)
			->where("invoice", "!=", NULL)
			->where("transfers.deleted_at", NULL)
			->join("periodical_publications", "periodical_publications.id", "=", "transfers.periodical_publication_id")
			->groupBy("periodical_publications.id")
			->selectRaw("name, SUM(transfers.sum) AS sum")
			->get();

		$nonperiodicalThisYearInvoice = Transfer::whereYear("transfer_date", "=", $current_year)
			->join("incomes", "incomes.id", "=", "transfers.income_id")
			->where("user_id", $user_id)
			->where('confirmed', 0)
			->where("invoice", "!=", NULL)
			->where("transfers.deleted_at", NULL)
			->join("nonperiodical_publications", "nonperiodical_publications.id", "=", "transfers.nonperiodical_publication_id")
			->groupBy("nonperiodical_publications.id")
			->selectRaw("name, SUM(transfers.sum) AS sum")
			->get();

		$periodicalNextYear = Transfer::whereYear("transfer_date", ">", $current_year)
			->join("incomes", "incomes.id", "=", "transfers.income_id")
			->where("user_id", $user_id)
			->where('confirmed', 0)
			->where("transfers.deleted_at", NULL)
			->join("periodical_publications", "periodical_publications.id", "=", "transfers.periodical_publication_id")
			->groupBy("periodical_publications.id")
			->selectRaw("name, SUM(transfers.sum) AS sum")
			->get();

		$nonperiodicalNextYear = Transfer::whereYear("transfer_date", ">", $current_year)
			->join("incomes", "incomes.id", "=", "transfers.income_id")
			->where("user_id", $user_id)
			->where('confirmed', 0)
			->where("transfers.deleted_at", NULL)
			->join("nonperiodical_publications", "nonperiodical_publications.id", "=", "transfers.nonperiodical_publication_id")
			->groupBy("nonperiodical_publications.id")
			->selectRaw("name, SUM(transfers.sum) AS sum")
			->get();

		$periodicalCorrectionsFrom = Correction::where("user_id", $user_id)
									->where('confirmed', 0)
									->where("corrections.deleted_at", NULL)
									->join("periodical_publications", "periodical_publications.id", "=", "corrections.from_periodical_id")
									->groupBy("periodical_publications.id")
									->selectRaw("periodical_publications.name, SUM(corrections.sum) AS sum")
									->get();
									
		$periodicalCorrectionsFor = Correction::where("user_id", $user_id)
									->where('confirmed', 0)
									->where("corrections.deleted_at", NULL)
									->join("periodical_publications", "periodical_publications.id", "=", "corrections.for_periodical_id")
									->groupBy("periodical_publications.id")
									->selectRaw("periodical_publications.name, SUM(corrections.sum) AS sum")
									->get();
									
		$nonperiodicalCorrectionsFrom = Correction::where("user_id", $user_id)
									->where('confirmed', 0)
									->where("corrections.deleted_at", NULL)
									->join("nonperiodical_publications", "nonperiodical_publications.id", "=", "corrections.from_nonperiodical_id")
									->groupBy("nonperiodical_publications.id")
									->selectRaw("nonperiodical_publications.name, SUM(corrections.sum) AS sum")
									->get();

		$nonperiodicalCorrectionsFor = Correction::where("user_id", $user_id)
									->where('confirmed', 0)
									->where("corrections.deleted_at", NULL)
									->join("nonperiodical_publications", "nonperiodical_publications.id", "=", "corrections.for_nonperiodical_id")
									->groupBy("nonperiodical_publications.id")
									->selectRaw("nonperiodical_publications.name, SUM(corrections.sum) AS sum")
									->get();

		return view('v-kartoteka/potvrdit-prijmy')
				->with('all_incomes', $all_incomes)
				->with('all_transfers', $all_transfers)
				->with('on_the_way', $on_the_way)
				->with('periodicalThisYear', $periodicalThisYear)
				->with('nonperiodicalThisYear', $nonperiodicalThisYear)
				->with('periodicalThisYearInvoice', $periodicalThisYearInvoice)
				->with('nonperiodicalThisYearInvoice', $nonperiodicalThisYearInvoice)
				->with('periodicalNextYear', $periodicalNextYear)
				->with('nonperiodicalNextYear', $nonperiodicalNextYear)
				->with('periodicalCorrectionsFrom', $periodicalCorrectionsFrom)
				->with('periodicalCorrectionsFor', $periodicalCorrectionsFor)
				->with('nonperiodicalCorrectionsFrom', $nonperiodicalCorrectionsFrom)
				->with('nonperiodicalCorrectionsFor', $nonperiodicalCorrectionsFor);
	}

	/**
     * Confirm unconfirmed incomes - POST.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function confirmIncomes()
	{
		$incomes = Income::where("confirmed", 0)
                    ->where("user_id", Auth::user()->id)
					->get();
					
		$corrections = Correction::where("confirmed", 0)
                    ->where("user_id", Auth::user()->id)
					->get();

		foreach( $incomes as $income ){
			foreach( $income->transfers as $transfer ){
				if( $transfer->periodical_publication_id ){
					$exists = PeriodicalOrder::where("person_id", $income->person_id)
										->where("periodical_publication_id", $transfer->periodical_publication_id)
										->first();

					if ( $exists ) {
						PeriodicalOrder::where("person_id", $income->person_id)
							->where("periodical_publication_id", $transfer->periodical_publication_id)
							->increment("credit", $transfer->sum);
					} else {
						PeriodicalOrder::create([
							"person_id" => $income->person_id,
							"periodical_publication_id" => $transfer->periodical_publication_id,
							"credit" => $transfer->sum,
						]);
					}
				}
				
				if( $transfer->nonperiodical_publication_id ){
					$exists = NonperiodicalOrder::where("person_id", $income->person_id)
										->where("nonperiodical_publication_id", $transfer->nonperiodical_publication_id)
										->first();

					if ( $exists ) {
						NonperiodicalOrder::where("person_id", $income->person_id)
							->where("nonperiodical_publication_id", $transfer->nonperiodical_publication_id)
							->increment("credit", $transfer->sum);
					} else {
						NonperiodicalOrder::create([
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

		foreach( $corrections as $correction ){
			$from_person_id = $correction->from_person_id;
			$from_periodical_id = $correction->from_periodical_id;
			$from_nonperiodical_id = $correction->from_nonperiodical_id;
			$for_person_id = $correction->for_person_id;
			$for_periodical_id = $correction->for_periodical_id;
			$for_nonperiodical_id = $correction->for_nonperiodical_id;
			$periodical_name = "";

			// odpocitat peniaze za opravu
			if( $from_periodical_id ){
				PeriodicalOrder::where("person_id", $from_person_id)
							->where("periodical_publication_id", $from_periodical_id)
							->decrement("credit", $correction->sum);

				$periodical_name = PeriodicalPublication::find($from_periodical_id)->name;
			}
			
			if( $from_nonperiodical_id ){
				NonperiodicalOrder::where("person_id", $from_person_id)
							->where("nonperiodical_publication_id", $from_nonperiodical_id)
							->decrement("credit", $correction->sum);

				$periodical_name = NonperiodicalPublication::find($from_nonperiodical_id)->name;
			}

			// poznacit vydavok
			Outcome::create([
				"person_id" => $from_person_id,
				"sum" => $correction->sum,
				"goal" => "Oprava: " . $periodical_name . ", ID: " . $correction->id,
			]);

			// pridat peniaze za opravu
			if( $for_periodical_id ){
				$exists = PeriodicalOrder::where("person_id", $for_person_id)
											->where("periodical_publication_id", $for_periodical_id)
											->first();
											
				if( $exists ){
					PeriodicalOrder::where("person_id", $for_person_id)
					->where("periodical_publication_id", $for_periodical_id)
					->increment("credit", $correction->sum);
				} else {	
					PeriodicalOrder::create([
						"person_id" => $for_person_id,
						"periodical_publication_id" => $for_periodical_id,
						"credit" => $correction->sum,
					]);
				}
			}

			if( $correction->for_nonperiodical_id ){
				$exists = NonperiodicalOrder::where("person_id", $for_person_id)
								->where("nonperiodical_publication_id", $for_nonperiodical_id)
								->first();
				
				if( $exists ){
					NonperiodicalOrder::where("person_id", $for_person_id)
					->where("nonperiodical_publication_id", $for_nonperiodical_id)
					->increment("credit", $correction->sum);
				} else {	
					NonperiodicalOrder::create([
						"person_id" => $for_person_id,
						"nonperiodical_publication_id" => $for_nonperiodical_id,
						"credit" => $correction->sum,
					]);
				}
			}

			Correction::where("id", $correction->id)
					->update([
						"confirmed" => 1
					]);
		}

		return redirect('/kartoteka')->with('message', 'Operácia sa podarila!');
	}

	/**
     * Delete the person.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function deletePerson()
	{
		$id = $_GET['userId'];

		Person::find($id)->delete($id);

		$data = array('result' => 1);

		return response()->json($data);
	}
}