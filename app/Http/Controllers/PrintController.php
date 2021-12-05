<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\PeriodicalOrder;
use DB;

class PrintController extends Controller
{
	public function person($id)
	{
		$person = Person::withTrashed()->find($id);
		
		return view('v-tlac/person')
                    ->with('person', $person);
	}

	public function objPeriodicke(Request $request)
	{
		$count_from = $request->count_from;
        $count_to = $request->count_to;
        $periodical_publication_id = $request->periodical_publication_id;

        $people = PeriodicalOrder::join("people", "periodical_orders.person_id", "=", "people.id")
                    ->join("periodical_publications", "periodical_orders.periodical_publication_id", "=", "periodical_publications.id")
                    ->whereDate("valid_from", "<=", DB::raw("periodical_publications.label_date"))
                    ->whereDate("valid_to", ">=", DB::raw("periodical_publications.label_date"))
                    ->where("periodical_publication_id", $periodical_publication_id)
                    ->where(function($query) use ($count_from, $count_to){
                        if($count_from > 0){
                            $query->where('count', '>=', $count_from);
                        }
                        if($count_to > 0){
                            $query->where('count', '<=', $count_to);
                        }
                    })
                    ->select("people.id", "title", "name1", "address1", "address2", "zip_code", "city", "state")
                    ->get();

		return view('v-tlac/people')
                    ->with('people', $people);
	}

	public function selekcie(Request $request)
	{
		$date_from = $request->date_from;
        if( $date_from ){
            $date_from = date('Y-m-d', strtotime($date_from));
        }
        $date_to = $request->date_to;
        if( $date_to ){
            $date_to = date('Y-m-d', strtotime($date_to));
        }
        $category_id = $request->category_id;
        $periodical_publication_id = $request->periodical_publication_id;
        $nonperiodical_publication_id = $request->nonperiodical_publication_id;
        $people;

        // filter podla prijmu
        if( $periodical_publication_id == 0 && $nonperiodical_publication_id == 0 ){
            $people = DB::table("people")
                    ->where(function($query) use ($date_from, $date_to, $category_id){
                        if( strlen($date_from) > 0 ){
                            $query->whereDate('incomes.income_date', '>=', $date_from);
                        }
                        if( strlen($date_to) > 0 ){
                            $query->whereDate('incomes.income_date', '<=', $date_to);
                        }
                        if( $category_id > 0 ){
                            $query->where("category_id", $category_id);
                        }
                    })
                    ->join("categories", "people.category_id", "=", "categories.id")
                    ->join("incomes", "people.id", "=", "incomes.person_id")
                    ->select("people.id", "people.title", "name1", "address1", "address2", "city", "zip_code", "state")
                    ->groupBy("person_id")
                    ->get();
        } else {
            // filter podla prevodu
            $people = DB::table("people")
                    ->where(function($query) use ($date_from, $date_to, $category_id, $periodical_publication_id, $nonperiodical_publication_id){
                        if( strlen($date_from) > 0 ){
                            $query->whereDate('transfers.transfer_date', '>=', $date_from);
                        }
                        if( strlen($date_to) > 0 ){
                            $query->whereDate('transfers.transfer_date', '<=', $date_to);
                        }
                        if( $periodical_publication_id > 0 ){
                            $query->where("transfers.periodical_publication_id", $periodical_publication_id);
                        }
                        if( $nonperiodical_publication_id > 0 ){
                            $query->where("transfers.nonperiodical_publication_id", $nonperiodical_publication_id);
                        }
                        if( $category_id > 0 ){
                            $query->where("category_id", $category_id);
                        }
                    })
                    ->join("categories", "people.category_id", "=", "categories.id")
                    ->join("incomes", "people.id", "=", "incomes.person_id")
                    ->join("transfers", "incomes.id", "=", "transfers.income_id")
                    ->select("people.id", "people.title", "name1", "address1", "address2", "city", "zip_code", "state")
                    ->groupBy("person_id")
                    ->get();
        }

		return view('v-tlac/people')
			->with('people', $people);
	}
}