<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use DB;

class PersonFilterController extends Controller
{
	public function index()
	{
		$categories = Category::get();

		return view('v-osoba/filter')
				->with('categories', $categories);
	}

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
}