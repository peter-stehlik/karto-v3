<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use App\Models\BankAccount;
use App\Models\PeriodicalPublication;
use App\Models\NonperiodicalPublication;
use DB;

class PersonFilterController extends Controller
{
	/*
		filter osob sablonka
	*/
	public function index()
	{
		$categories = Category::get();

		return view('v-osoba/filter')
				->with('categories', $categories);
	}

	/**
	 * AJAX filter osob
	 */
	public function filter()
	{
		$id = $_GET["person_id"];
		$category_id = $_GET["category_id"];
		$name1 = $_GET["name1"];
		$address1 = $_GET["address1"];
		$zip_code = $_GET["zip_code"];
		$city = $_GET["city"];
		$bin = $_GET["bin"];

		if( $id || $category_id || $name1 || $address1 || $zip_code || $city || $bin ){ // if filter active		
			$people = DB::table('people')
				->where(function($query) use ($id, $category_id, $name1, $address1, $zip_code, $city, $bin) {
					if($id > 0){
						$query->where('people.id', $id);
					}
					if($category_id > 0){
						$query->where('category_id', $category_id);
					}
					if($name1){
						$query->where('name1', 'like', '%' . $name1 . '%');
					}
					if($address1){
						$query->where('address1', 'like', '%' . $address1 . '%');
					}
					if($zip_code){
						$query->where('zip_code', 'like', '%' . $zip_code . '%');
					}
					if($city){
						$query->where('city', 'like', '%' . $city . '%');
					}
					if($bin){
						if( $bin == 1 ){
							$query->where("people.deleted_at", "!=", NULL);											
						}
					}else{
						$query->where("people.deleted_at", NULL);			
					}
				})
				->join("categories", "people.category_id", "=", "categories.id")
				->select("people.id", "title", "name1", "address1", "address2", "organization", "people.note", "zip_code", 'city', 'state', 'categories.name AS category_name')
				->get();	
		} else {
			$people = [];
		}

		$data = array('result' => 1);

		$data["people"] = $people;

		return response()->json($data);
	}

	/**
	 * sablonka pre filter vsetkych prijmov
	 * podobne ako PersonController:getIncomes
	 * samotny AJAX filter sa pouziva rovnaky - PersonController:getIncomesFilter
	 */
	public function getAllIncomes()
	{
		$users = User::get();
		$bank_accounts = BankAccount::get();

		return view('v-uzivatel/zoznam-prijmov')
			->with('users', $users)
			->with('bank_accounts', $bank_accounts);
	}

	/**
	 * sablonka pre filter vsetkych prevodov
	 * podobne ako PersonController:getTransfers
	 * samotny AJAX filter sa pouziva rovnaky - PersonController:getTransfersFilter
	 */
	public function getAllTransfers()
	{
		$periodical_publications = PeriodicalPublication::get();
		$nonperiodical_publications = NonperiodicalPublication::get();

		return view('v-uzivatel/zoznam-prevodov')
			->with('periodical_publications', $periodical_publications)
			->with('nonperiodical_publications', $nonperiodical_publications);
	}

	/**
	 * sablonka pre filter vsetkych oprav
	 * podobne ako CorrectionController:listCorrections
	 * samotny AJAX filter sa pouziva rovnaky - CorrectionController:getCorrectionsFilter
	 */
	public function getAllCorrections()
	{
		$users = User::get();
		$periodical_publications = PeriodicalPublication::get();
		$nonperiodical_publications = NonperiodicalPublication::get();

		return view('v-uzivatel/zoznam-oprav')
			->with('users', $users)
			->with('periodical_publications', $periodical_publications)
			->with('nonperiodical_publications', $nonperiodical_publications);
	}
}