<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Tag;
use App\Models\PersonInTag;
use App\Models\User;
use App\Models\BankAccount;
use App\Models\PeriodicalPublication;
use App\Models\NonperiodicalPublication;
use PDF;
use DB;

class PersonFilterController extends Controller
{
	/*
		filter osob sablonka
	*/
	public function index()
	{
		$categories = Category::get();
		$tags = Tag::get();

		return view('v-osoba/filter')
				->with('tags', $tags)
				->with('categories', $categories);
	}

	/**
	 * AJAX filter osob
	 */
	public function filter()
	{
		$id = $_GET["person_id"];
		$category_id = $_GET["category_id"];
		$tag_id = $_GET["tag_id"];
		$name1 = $_GET["name1"];
		$address1 = $_GET["address1"];
		$zip_code = $_GET["zip_code"];
		$city = $_GET["city"];
		$bin = $_GET["bin"];

		if( $id || $category_id || $tag_id || $name1 || $address1 || $zip_code || $city || $bin ){ // if filter active		
			$people = DB::table('people')
				->where(function($query) use ($id, $category_id, $tag_id, $name1, $address1, $zip_code, $city, $bin) {
					if($id > 0){
						$query->where('people.id', $id);
					}
					if($category_id > 0){
						$query->where('category_id', $category_id);
					}
					if($tag_id > 0){
						$query->where('tag_id', $tag_id);
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
				->leftJoin("person_in_tags", "people.id", "=", "person_in_tags.person_id")
				->groupBy("people.id")
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
	 * Tlac filter osob
	 * SQL skopirovane z "filter", drobne upravene
	 */
	public function filterPrint(Request $request)
	{
		$excludePeopleArr = PersonInTag::where("deleted_at", NULL)
								->where("tag_id", 1) // netlacit adresky
								->select("person_id")
								->get()
								->toArray();

		$data;
		$id = $request->person_id;
		$category_id = $request->category_id;
		$tag_id = $request->tag_id;
		$name1 = $request->name1;
		$address1 = $request->address1;
		$zip_code = $request->zip_code;
		$city = $request->city;
		$bin = $request->bin;

		if( $id || $category_id || $tag_id || $name1 || $address1 || $zip_code || $city || $bin ){ // if filter active		
			$people = DB::table('people')
				->where(function($query) use ($id, $category_id, $tag_id, $name1, $address1, $zip_code, $city, $bin) {
					if($id > 0){
						$query->where('people.id', $id);
					}
					if($category_id > 0){
						$query->where('category_id', $category_id);
					}
					if($tag_id > 0){
						$query->where('tag_id', $tag_id);
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
				->leftJoin("person_in_tags", "people.id", "=", "person_in_tags.person_id")
				->whereNotIn("people.id", $excludePeopleArr)
				->groupBy("people.id")
				->select("people.id", "title", "name1", "name2", "address1", "address2", "zip_code", 'city', 'state')
				->get();	
		} else {
			$people = [];
		}

		$data["people"] = $people;
		$data["columns"] = $request->columns;
		$data["start_position"] = $request->start_position;

		return view('v-tlac/a4')
			->with('columns', $data["columns"])
			->with('start_position', $data["start_position"])
			->with('people', $people);
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

	/**
	 * sablonka pre filter vsetkych vydajov
	 * podobne ako OutcomeController:getDobrodinecVydavky
	 * samotny AJAX filter sa pouziva rovnaky - OutcomeController:getOutcomesFilter
	 */
	public function getAllOutcomes()
	{
		$periodical_publications = PeriodicalPublication::get();
		$nonperiodical_publications = NonperiodicalPublication::get();

		return view('v-uzivatel/zoznam-vydajov')
			->with('periodical_publications', $periodical_publications)
			->with('nonperiodical_publications', $nonperiodical_publications);
	}
}