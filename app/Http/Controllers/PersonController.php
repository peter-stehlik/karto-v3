<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\NonperiodicalOrder;
use App\Models\PeriodicalOrder;

class PersonController extends Controller
{
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

	public function bio($id)
	{
		$person = Person::find($id);

		return view('v-osoba/dobrodinec/osobne-udaje')
			->with('person', $person);
	}
}