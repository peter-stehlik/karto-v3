<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class PersonFilterController extends Controller
{
	public function index()
	{
		$categories = Category::get();

		/*
		echo "<pre>";
		print_r($transfers);
		echo "</pre>"; */

		return view('v-osoba/index')
				->with('categories', $categories);
	}

	public function filter()
	{
		/*$id = $_GET['userId'];
		$publication_id = $_GET['publicationId'];

		$data = array('result' => 1);

		return response()->json($data);*/
	}
}