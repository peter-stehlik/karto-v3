<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\NonperiodicalOrder;
use App\Models\PeriodicalOrder;
use App\Models\Category;
use App\Models\User;
use App\Models\BankAccount;
use App\Models\Income;
use App\Models\Transfer;
use App\Models\PeriodicalPublication;
use App\Models\NonperiodicalPublication;
use DB;

class PersonController extends Controller
{
	/*
		GET
		zobrazit ucty ku konkretnej osobe (dobrodincovi)
	*/
	public function index($id)
	{
		$person = Person::withTrashed()->find($id);
		$periodical_orders = PeriodicalOrder::where("person_id", $id)
								->join("periodical_publications", "periodical_orders.periodical_publication_id", "=", "periodical_publications.id")
								->select("name", "credit")
								->get();
		$nonperiodical_orders = NonperiodicalOrder::where("person_id", $id)
								->join("nonperiodical_publications", "nonperiodical_orders.nonperiodical_publication_id", "=", "nonperiodical_publications.id")
								->select("name", "credit")
								->get();
		
		// vyratat Peniaze na ceste
		$incomes_sum = Income::where("person_id", $id)
							->where("confirmed", 1)
							->sum("sum");
		$transfers_sum = Transfer::join("incomes", "incomes.id", "=", "transfers.income_id")
									->where("person_id", $id)
									->sum("transfers.sum");
		$peniaze_na_ceste = $incomes_sum - $transfers_sum;


		return view('v-osoba/dobrodinec/ucty')
			->with('periodical_orders', $periodical_orders)
			->with('nonperiodical_orders', $nonperiodical_orders)
			->with('peniaze_na_ceste', $peniaze_na_ceste)
			->with('person', $person);
	}

	/*
		GET
		(edit) zobrazit formular s osobnymi udajmi
	*/
	public function getBio($id)
	{
		$person = Person::withTrashed()->find($id);
		$categories = Category::get();

		return view('v-osoba/dobrodinec/osobne-udaje')
			->with('person', $person)
			->with('categories', $categories);
	}

	/*
		POST
		(edit) ulozit formular s osobnymi udajmi
	*/
	public function postBio(Request $request)
	{
		$id = $request->person_id;

		Person::withTrashed()->where('id', $id)
		->update([
			'category_id' => $request->category_id,
			'title' => $request->title,
			'name1' => $request->name1,
			'address1' => $request->address1,
			'address2' => $request->address2,
			'organization' => $request->organization,
			'zip_code' => $request->zip_code,
			'city' => $request->city,
			'state' => $request->state,
			'email' => $request->email,
			'note' => $request->note,
		]);

		return redirect('/dobrodinec/' . $id . '/ucty')->with('message', 'Operácia sa podarila!');
	}

	/*
		GET prijmy
		zobrazit filter prijmov pre konkretnu osobu
	*/
	public function getIncomes($id)
	{
		$person = Person::withTrashed()->find($id);
		$users = User::get();
		$bank_accounts = BankAccount::get();

		return view('v-osoba/dobrodinec/prijmy')
			->with('users', $users)
			->with('bank_accounts', $bank_accounts)
			->with('person', $person);
	}

	/*
		GET JSON prijmy
		nacitat vysledky filtra
		rovnaka metoda sa pouziva pri osobe aj vseobecne 
	*/
	public function getIncomesFilter()
	{
		$person_id = $_GET["person_id"];
		$user_id = $_GET["user_id"];
		$sum_from = $_GET["sum_from"];
		$sum_to = $_GET["sum_to"];
		$bank_account_id = $_GET["bank_account_id"];
		$number_from = $_GET["number_from"];
		$number_to = $_GET["number_to"];
		$package_number = $_GET["package_number"];
		$invoice = $_GET["invoice"];
		$accounting_date_from = $_GET["accounting_date_from"] ? date("Y-m-d", strtotime($_GET["accounting_date_from"])) : "";
		$accounting_date_to = $_GET["accounting_date_to"] ? date("Y-m-d", strtotime($_GET["accounting_date_to"])) : "";
		$income_date_from = $_GET["income_date_from"] ? date("Y-m-d", strtotime($_GET["income_date_from"])) : "";
		$income_date_to = $_GET["income_date_to"] ? date("Y-m-d", strtotime($_GET["income_date_to"])) : "";

		$incomes = [];
		
		$incomes = DB::table('incomes')
			->where("confirmed", 1)
			->where(function($query) use ($person_id, $user_id, $sum_from, $sum_to, $bank_account_id, $number_from, $number_to, $package_number, $invoice, $accounting_date_from, $accounting_date_to, $income_date_from, $income_date_to) {
				if($person_id > 0){
					$query->where('incomes.person_id', $person_id);
				}
				if($user_id > 0){
					$query->where('incomes.user_id', $user_id);
				}
				if($sum_from){
					$query->where('incomes.sum', '>=', $sum_from);
				}
				if($sum_to){
					$query->where('incomes.sum', '<=', $sum_to);
				}
				if($bank_account_id > 0){
					$query->where('incomes.bank_account_id', $bank_account_id);
				}
				if($number_from){
					$query->where('incomes.number', '>=', $number_from);
				}
				if($number_to){
					$query->where('incomes.number', '<=', $number_to);
				}
				if($package_number){
					$query->where('incomes.package_number', $package_number);
				}
				if($invoice){
					$query->where('incomes.invoice', $invoice);
				}
				if(strlen($accounting_date_from) > 0){
					$query->whereDate('incomes.accounting_date', ">=", $accounting_date_from);
				}
				if(strlen($accounting_date_to) > 0){
					$query->whereDate('incomes.accounting_date', "<", $accounting_date_to);
				}
				if(strlen($income_date_from) > 0){
					$query->whereDate('incomes.income_date', ">=", $income_date_from);
				}
				if(strlen($income_date_to) > 0){
					$query->whereDate('incomes.income_date', "<=", $income_date_to);
				}
			})
			->join("people", "incomes.person_id", "=", "people.id")
			->join("users", "incomes.user_id", "=", "users.id")
			->join("bank_accounts", "incomes.bank_account_id", "=", "bank_accounts.id")
			->select("incomes.id AS income_id" , "people.name1", "people.city", "users.name AS username", "incomes.sum AS income_sum", "bank_accounts.bank_name", "incomes.number", "incomes.package_number", "incomes.invoice", "incomes.accounting_date", "incomes.note", "incomes.income_date")
			->orderBy("incomes.income_date", "desc")
			->get();

		$data = array('result' => 1);

		$data["incomes"] = $incomes;

		return response()->json($data);	
	}

	/*
		GET JSON
		nacitat prevody pre vybrany prijem
	*/
	public function getTransfersForIncome()
	{
		$income_id = $_GET["income_id"];
		$transfers = Transfer::where("income_id", $income_id)
							->leftJoin("periodical_publications", "transfers.periodical_publication_id", "=", "periodical_publications.id")
							->leftJoin("nonperiodical_publications", "transfers.nonperiodical_publication_id", "=", "nonperiodical_publications.id")
							->select("income_id", "transfers.sum", "transfer_date", "transfers.note", "periodical_publications.name AS pp_name", "nonperiodical_publications.name AS np_name")
							->orderBy("transfers.transfer_date", "desc")
							->get();
		
		$data = array('result' => 1);
		
		$data["transfers"] = $transfers;

		return response()->json($data);	
	}

	/*
		GET prevody
		zobrazit filter prevodov pre konkretnu osobu
	*/
	public function getTransfers($id)
	{
		$person = Person::withTrashed()->find($id);
		$periodical_publications = PeriodicalPublication::get();
		$nonperiodical_publications = NonperiodicalPublication::get();

		return view('v-osoba/dobrodinec/prevody')
			->with('periodical_publications', $periodical_publications)
			->with('nonperiodical_publications', $nonperiodical_publications)
			->with('person', $person);
	}

	/*
		GET JSON prevody
		nacitat vysledky filtra
		rovnaka metoda sa pouziva pri osobe aj vseobecne 
	*/
	public function getTransfersFilter()
	{
		$person_id = $_GET["person_id"];
		$sum_from = $_GET["sum_from"];
		$sum_to = $_GET["sum_to"];
		$periodical_publication_id = $_GET["periodical_publication_id"];
		$nonperiodical_publication_id = $_GET["nonperiodical_publication_id"];
		$transfer_date_from = $_GET["transfer_date_from"] ? date("Y-m-d", strtotime($_GET["transfer_date_from"])) : "";
		$transfer_date_to = $_GET["transfer_date_to"] ? date("Y-m-d", strtotime($_GET["transfer_date_to"])) : "";

		$transfers = [];
		
		$transfers = DB::table('transfers')
			->where("confirmed", 1)
			->where(function($query) use ($person_id, $sum_from, $sum_to, $periodical_publication_id, $nonperiodical_publication_id, $transfer_date_from, $transfer_date_to) {
				if($person_id > 0){
					$query->where('incomes.person_id', $person_id);
				}
				if($sum_from){
					$query->where('transfers.sum', '>=', $sum_from);
				}
				if($sum_to){
					$query->where('transfers.sum', '<=', $sum_to);
				}
				if($periodical_publication_id > 0){
					$query->where('transfers.periodical_publication_id', $periodical_publication_id);
				}
				if($nonperiodical_publication_id > 0){
					$query->where('transfers.nonperiodical_publication_id', $nonperiodical_publication_id);
				}
				if(strlen($transfer_date_from) > 0){
					$query->whereDate('transfers.transfer_date', ">=", $transfer_date_from);
				}
				if(strlen($transfer_date_to) > 0){
					$query->whereDate('transfers.transfer_date', "<", $transfer_date_to);
				}
			})
			->join("incomes", "incomes.id", "=", "transfers.income_id")
			->join("people", "incomes.person_id", "=", "people.id")
			->leftJoin("periodical_publications", "transfers.periodical_publication_id", "=", "periodical_publications.id")
			->leftJoin("nonperiodical_publications", "transfers.nonperiodical_publication_id", "=", "nonperiodical_publications.id")
			->select("incomes.id AS income_id", "people.name1", "people.city", "transfers.id AS transfer_id", "periodical_publications.name AS pp_name", "nonperiodical_publications.name AS np_name", "transfers.sum AS transfer_sum", "transfers.transfer_date", "transfers.note")
			->orderBy("transfers.transfer_date", "desc")
			->get();

		$data = array('result' => 1);

		$data["transfers"] = $transfers;

		return response()->json($data);	
	}

	/*
		GET JSON
		nacitat prijem pre vybrany prevod
	*/
	public function getIncomeForTransfer()
	{
		$transfer_id = $_GET["transfer_id"];
		$income_id = $_GET["income_id"];
		$income = Transfer::where("transfers.id", $transfer_id)
							->join("incomes", "transfers.income_id", "=", "incomes.id")
							->join("bank_accounts", "incomes.bank_account_id", "=", "bank_accounts.id")
							->join("users", "incomes.user_id", "=", "users.id")
							->select("transfers.id AS transfer_id", "incomes.id AS income_id", "incomes.sum", "incomes.number", "package_number", "invoice", "incomes.note", "incomes.accounting_date", "bank_accounts.bank_name AS bank_account_name", "users.name AS username")
							->get();
		
		$data = array('result' => 1);
		
		$data["income"] = $income;

		return response()->json($data);	
	}
}