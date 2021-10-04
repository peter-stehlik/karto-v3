<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\PeriodicalPublication;
use App\Models\NonperiodicalPublication;
use App\Models\Correction;
use Auth;

class CorrectionController extends Controller
{
	/**
     * Display a form.
     *
     * @return \Illuminate\Http\Response
     */
	public function opravaCezHviezdicku($id)
	{
		$person = Person::find($id);
		$periodical_publication_id;
		$nonperiodical_publication_id;
		$transfer_name;
		if( isset($_GET["periodical_publication_id"]) ){
			$periodical_publication_id = $_GET["periodical_publication_id"];
			$transfer_name = PeriodicalPublication::find($periodical_publication_id);
			$transfer_name = $transfer_name->name;
		}
		if( isset($_GET["nonperiodical_publication_id"]) ){
			$nonperiodical_publication_id = $_GET["nonperiodical_publication_id"];
			$transfer_name = NonperiodicalPublication::find($nonperiodical_publication_id);
			$transfer_name = $transfer_name->name;
		}
		$periodical_publications = PeriodicalPublication::get();
		$nonperiodical_publications = NonperiodicalPublication::get();

		return view('v-osoba/dobrodinec/oprava-cez-hviezdicku')
			->with('periodical_publications', $periodical_publications)
			->with('nonperiodical_publications', $nonperiodical_publications)
			->with('transfer_name', $transfer_name)
			->with('person', $person);
	}

	public function store(Request $request)
	{
		$from_person_id = $request->from_person_id;

		$correction_date = strtotime($request->correction_date);
		$correction_date = date('Y-m-d', $correction_date);

		Correction::create([
			"from_person_id" => $request->from_person_id,
			"for_person_id" => $request->for_person_id,
			"sum" => floatval($request->sum),
			"from_periodical_id" => $request->from_periodical_id,
			"from_nonperiodical_id" => $request->from_nonperiodical_id,
			"for_periodical_id" => $request->for_periodical_id,
			"for_nonperiodical_id" => $request->for_nonperiodical_id,
			"user_id" => Auth::user()->id,
			"confirmed" => 0,
			"correction_date" => $correction_date,
			"note" => $request->note,
		]);

		return redirect('/dobrodinec/' . $from_person_id . '/ucty')->with('message', 'Operácia sa podarila!');
	}
}