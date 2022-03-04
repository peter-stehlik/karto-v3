<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Outcome;
use App\Models\PeriodicalPublication;
use App\Models\NonperiodicalPublication;
use DB;

class OutcomeController extends Controller
{
	public function getDobrodinecVydavky($id)
	{
		$person = Person::find($id);
		$periodical_publications = PeriodicalPublication::get();
		$nonperiodical_publications = NonperiodicalPublication::get();

		return view('v-osoba/dobrodinec/vydavky')
				->with("person", $person)
				->with("periodical_publications", $periodical_publications)
				->with("nonperiodical_publications", $nonperiodical_publications);
	}

	public function getOutcomesFilter()
	{
		$person_id = $_GET["person_id"];
		$sum_from = $_GET["sum_from"];
		$sum_to = $_GET["sum_to"];
		$goal = $_GET["goal"];
		$outcome_date_from = $_GET["outcome_date_from"] ? date("Y-m-d", strtotime($_GET["outcome_date_from"])) : "";
		$outcome_date_to = $_GET["outcome_date_to"] ? date("Y-m-d", strtotime($_GET["outcome_date_to"])) : "";

		$outcomes = [];
		
		$outcomes = DB::table('outcomes')
			->where(function($query) use ($person_id, $sum_from, $sum_to, $goal, $outcome_date_from, $outcome_date_to) {
				if($person_id > 0){
					$query->where('outcomes.person_id', $person_id);
				}
				if($sum_from){
					$query->where('outcomes.sum', '>=', $sum_from);
				}
				if($sum_to){
					$query->where('outcomes.sum', '<=', $sum_to);
				}
				if($goal){
					$query->where('outcomes.goal', 'LIKE', '%' . $goal . '%');
				}
				if(strlen($outcome_date_from) > 0){
					$query->whereDate('outcomes.created_at', ">=", $outcome_date_from);
				}
				if(strlen($outcome_date_to) > 0){
					$query->whereDate('outcomes.created_at', "<=", $outcome_date_to);
				}
			})
			->join("people", "people.id", "=", "outcomes.person_id")
			->select("outcomes.id", "outcomes.sum", "outcomes.created_at", "people.name1", "outcomes.goal")
			->orderBy("outcomes.created_at", "desc")
			->get();

		$data = array('result' => 1);

		$data["outcomes"] = $outcomes;

		return response()->json($data);
	}

}