<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeriodicalPublication;
use App\Models\NonperiodicalPublication;
use App\Models\Category;
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
        $date_from = $_GET["date_from"];
        if( $date_from ){
            $date_from = date('Y-m-d', strtotime($_GET["date_from"]));
        }
        $date_to = $_GET["date_to"];
        if( $date_to ){
            $date_to = date('Y-m-d', strtotime($_GET["date_to"]));
        }
        $category_id = $_GET["category_id"];
        $category_excluded_id = $_GET["category_excluded_id"];
        $periodical_publication_id = $_GET["periodical_publication_id"];
        $nonperiodical_publication_id = $_GET["nonperiodical_publication_id"];
        $selection;

        // filter podla prijmu
        if( $periodical_publication_id == 0 && $nonperiodical_publication_id == 0 ){
            $selection = DB::table("people")
                    ->where(function($query) use ($date_from, $date_to, $category_id, $category_excluded_id){
                        if( strlen($date_from) > 0 ){
                            $query->whereDate('incomes.income_date', '>=', $date_from);
                        }
                        if( strlen($date_to) > 0 ){
                            $query->whereDate('incomes.income_date', '<=', $date_to);
                        }
                        if( $category_id > 0 ){
                            $query->where("category_id", $category_id);
                        }
                        if( $category_excluded_id > 0 ){
                            $query->where("category_id", "!=", $category_excluded_id);
                        }
                    })
                    ->join("categories", "people.category_id", "=", "categories.id")
                    ->join("incomes", "people.id", "=", "incomes.person_id")
                    ->select("people.id AS person_id", "people.title", "name1", "address1", "city", "zip_code", "people.note")
                    ->groupBy("person_id")
                    ->get();
        } else {
            // filter podla prevodu
            $selection = DB::table("people")
                    ->where(function($query) use ($date_from, $date_to, $category_id, $category_excluded_id, $periodical_publication_id, $nonperiodical_publication_id){
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
                        if( $category_excluded_id > 0 ){
                            $query->where("category_id", "!=", $category_excluded_id);
                        }
                    })
                    ->join("categories", "people.category_id", "=", "categories.id")
                    ->join("incomes", "people.id", "=", "incomes.person_id")
                    ->join("transfers", "incomes.id", "=", "transfers.income_id")
                    ->select("people.id AS person_id", "people.title", "name1", "address1", "city", "zip_code", "people.note")
                    ->groupBy("person_id")
                    ->get();
        }



        $data = array('result' => 1);
        
        $data["selection"] = $selection;

		return response()->json($data);
    }

    /* tlac adresky */
    public function printSelection()
    {

    }
}