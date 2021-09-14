<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\NonperiodicalOrder;
use App\Models\PeriodicalOrder;
use App\Models\Category;
use App\Models\User;
use App\Models\BankAccount;
use DB;

class PersonController extends Controller
{
	/*
		GET
		zobrazit ucty ku konkretnej osobe (dobrodincovi)
	*/
	public function index($id)
	{
		$person = Person::find($id);
		$periodical_orders = PeriodicalOrder::where("person_id", $id)
								->join("periodical_publications", "periodical_orders.periodical_publication_id", "=", "periodical_publications.id")
								->select("name", "credit")
								->get();
		$nonperiodical_orders = NonperiodicalOrder::where("person_id", $id)
								->join("nonperiodical_publications", "nonperiodical_orders.nonperiodical_publication_id", "=", "nonperiodical_publications.id")
								->select("name", "credit")
								->get();

		return view('v-osoba/dobrodinec/ucty')
			->with('periodical_orders', $periodical_orders)
			->with('nonperiodical_orders', $nonperiodical_orders)
			->with('person', $person);
	}

	/*
		GET
		(edit) zobrazit formular s osobnymi udajmi
	*/
	public function getBio($id)
	{
		$person = Person::find($id);
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

		Person::where('id', $id)
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
		GET
		zobrazit filter prijmov
	*/
	public function getIncomes($id)
	{
		$person = Person::find($id);
		$users = User::get();
		$bank_accounts = BankAccount::get();

		return view('v-osoba/dobrodinec/prijmy')
			->with('users', $users)
			->with('bank_accounts', $bank_accounts)
			->with('person', $person);
	}

	/*
		GET JSON
		nacitat vysledky filtra
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
		$data = array('result' => 1);

		return response()->json($data);	
	}
}