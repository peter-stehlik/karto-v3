<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\NonperiodicalOrder;
use App\Models\PeriodicalOrder;
use App\Models\Category;

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
}