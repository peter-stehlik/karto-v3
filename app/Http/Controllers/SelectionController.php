<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeriodicalPublication;
use App\Models\NonperiodicalPublication;
use App\Models\Category;
use App\Models\PersonInTag;
use DB;

class SelectionController extends Controller
{
    /**
     * Display filter.
     *
     * @return \Illuminate\Http\Response
     */
    public function selekcie()
    {
        $categories = Category::get();
        $periodical_publications = PeriodicalPublication::get();
        $nonperiodical_publications = NonperiodicalPublication::get();


        return view('v-kancelaria/selekcie')
                ->with('categories', $categories)
                ->with('periodical_publications', $periodical_publications)
                ->with('nonperiodical_publications', $nonperiodical_publications);
    }

    public function selectionJSON()
    {
		$excludePeopleArr = PersonInTag::where("deleted_at", NULL)
								->where("tag_id", 1) // netlacit adresky
								->select("person_id")
								->get()
								->toArray();
        $periodical_publication_id = $_GET["periodical_publication_id"] ? explode(",", $_GET["periodical_publication_id"]) : [];
        $nonperiodical_publication_id = $_GET["nonperiodical_publication_id"] ? explode(",", $_GET["nonperiodical_publication_id"]) : [];

        $date_from = $_GET["date_from"];
        if( $date_from ){
            $date_from = date('Y-m-d', strtotime($_GET["date_from"]));
        }
        $date_to = $_GET["date_to"];
        if( $date_to ){
            $date_to = date('Y-m-d', strtotime($_GET["date_to"]));
        }
        $category_id = $_GET["category_id"];
        $selection;

        // filter podla prijmu
        if( !$periodical_publication_id && !$nonperiodical_publication_id ){
            $selection = DB::table("people")
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
                    ->select("people.id AS person_id", "people.title", "name1", "address1", "city", "zip_code", "people.note")
                    ->groupBy("person_id")
                    ->get();
        } else {
            // filter podla prevodu
            $selection1 = collect();
            $selection2 = collect();

            if( $periodical_publication_id ){
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
                    ->select("people.id AS person_id", "people.title", "name1", "address1", "city", "zip_code", "people.note")
                    ->groupBy("person_id")
                    ->get();
            }

            if( $nonperiodical_publication_id ){
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
                    ->select("people.id AS person_id", "people.title", "name1", "address1", "city", "zip_code", "people.note")
                    ->groupBy("person_id")
                    ->get();
            }

            $selection = $selection1->concat($selection2);
            $selection = $selection->unique("person_id");
            $selection = $selection->values()->all();
        }

        $data = array('result' => 1);
        
        $data["selection"] = $selection;

		return response()->json($data);
    }
}