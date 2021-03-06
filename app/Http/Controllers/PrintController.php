<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\PeriodicalOrder;
use App\Models\PersonInTag;
use Auth;
use DB;

class PrintController extends Controller
{
	public function person($id)
	{
		$person = Person::withTrashed()->find($id);
        $user_printer = Auth::user()->printer;
        $template = "person-lx-300II";

        switch( $user_printer ){
            case "EPSON LX-300II+":
                $template = "person-lx-300II";
                break;
            case "EPSON LX-350":
                $template = "person-lx-350";
                break;
        }

		return view('v-tlac/' . $template)
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
                    ->select("people.id", "title", "name1", "name2", "address1", "address2", "zip_code", "city", "state", "count", "abbreviation")
                    ->get();

        $data["people"] = $people;
        $data["columns"] = $request->columns;
        $data["start_position"] = $request->start_position;

        return view('v-tlac/a4')
            ->with('columns', $data["columns"])
            ->with('start_position', $data["start_position"])
            ->with('people', $people);
	}

	public function selekcie(Request $request)
	{
		$excludePeopleArr = PersonInTag::where("deleted_at", NULL)
								->where("tag_id", 1) // netlacit adresky
								->select("person_id")
								->get()
								->toArray();
        
		$date_from = $request->date_from;
        if( $date_from ){
            $date_from = date('Y-m-d', strtotime($date_from));
        }
        $date_to = $request->date_to;
        if( $date_to ){
            $date_to = date('Y-m-d', strtotime($date_to));
        }
        $category_id = $request->category_id;
        $periodical_publication_id = $request->periodical_publication_id ? explode(",", $request->periodical_publication_id) : [];
        $nonperiodical_publication_id = $request->nonperiodical_publication_id ? explode(",", $request->nonperiodical_publication_id) : [];
        $people;

        // filter podla prijmu
        if( !$periodical_publication_id && !$nonperiodical_publication_id ){
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
                    ->whereNotIn("people.id", $excludePeopleArr)
                    ->select("people.id", "people.title", "name1", "name2", "address1", "address2", "city", "zip_code", "state")
                    ->groupBy("people.id")
                    ->get();
        } else {
            // filter podla prevodu
            $selection1 = collect();
            $selection2 = collect();

            if( count($periodical_publication_id) ){
                $selection1 = DB::table("people")
                    ->where(function($query) use ($date_from, $date_to, $category_id, $periodical_publication_id){
                        if( strlen($date_from) > 0 ){
                            $query->whereDate('transfers.transfer_date', '>=', $date_from);
                        }
                        if( strlen($date_to) > 0 ){
                            $query->whereDate('transfers.transfer_date', '<=', $date_to);
                        }
                        if( count($periodical_publication_id) ){
                            $query->whereIn("transfers.periodical_publication_id", $periodical_publication_id);
                        }
                        if( $category_id > 0 ){
                            $query->where("category_id", $category_id);
                        }
                    })
                    ->join("categories", "people.category_id", "=", "categories.id")
                    ->join("incomes", "people.id", "=", "incomes.person_id")
                    ->join("transfers", "incomes.id", "=", "transfers.income_id")
                    ->whereNotIn("people.id", $excludePeopleArr)
                    ->select("people.id AS id", "people.title", "name1", "name2", "address1", "address2", "city", "zip_code", "state")
                    ->groupBy("id")
                    ->get();
            }

            if( count($nonperiodical_publication_id) ){
                $selection2 = DB::table("people")
                    ->where(function($query) use ($date_from, $date_to, $category_id, $nonperiodical_publication_id){
                        if( strlen($date_from) > 0 ){
                            $query->whereDate('transfers.transfer_date', '>=', $date_from);
                        }
                        if( strlen($date_to) > 0 ){
                            $query->whereDate('transfers.transfer_date', '<=', $date_to);
                        }
                        if( count($nonperiodical_publication_id) ){
                            $query->whereIn("transfers.nonperiodical_publication_id", $nonperiodical_publication_id);
                        }
                        if( $category_id > 0 ){
                            $query->where("category_id", $category_id);
                        }
                    })
                    ->join("categories", "people.category_id", "=", "categories.id")
                    ->join("incomes", "people.id", "=", "incomes.person_id")
                    ->join("transfers", "incomes.id", "=", "transfers.income_id")
                    ->whereNotIn("people.id", $excludePeopleArr)
                    ->select("people.id AS id", "people.title", "name1", "name2", "address1", "address2", "city", "zip_code", "state")
                    ->groupBy("id")
                    ->get();
            }

            $people = $selection1->concat($selection2);
            $people = $people->unique("id");
            $people = $people->values()->all();
        }

        $data["columns"] = $request->columns;
        $data["start_position"] = $request->start_position;

        return view('v-tlac/a4')
            ->with('columns', $data["columns"])
            ->with('start_position', $data["start_position"])
            ->with('people', $people);
	}

    public function neplatici(Request $request)
    {
        $data;
        $people = Person::join("periodical_credits", "people.id", "=", "periodical_credits.person_id")
            ->where("periodical_credits.credit", "<", -3)
            ->select("people.id", "title", "name1", "name2", "address1", "address2", "zip_code", "city", "state")
            ->get();

        $data["people"] = $people;
        $data["columns"] = $request->columns;
        $data["start_position"] = $request->start_position;

        return view('v-tlac/a4')
            ->with('columns', $data["columns"])
            ->with('start_position', $data["start_position"])
            ->with('people', $people);
    }

    public function printRow(Request $request)
    {
        $people = [];
        $peopleIds = explode("|", $request->ids);

        $people = Person::whereIn("id", $peopleIds)->get();

		$data["people"] = $people;
		$data["columns"] = $request->columns;
		$data["start_position"] = $request->start_position;

		return view('v-tlac/a4')
			->with('columns', $data["columns"])
			->with('start_position', $data["start_position"])
			->with('people', $people);
    }
}