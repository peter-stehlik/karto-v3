<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transfer;
use App\Models\Income;
use App\Models\PeriodicalPublication;
use App\Models\NonperiodicalPublication;
use Auth;

class TransferUnconfirmedController extends Controller
{
	public function index()
	{
		$transfers = Transfer::join("incomes", "incomes.id", "=", "transfers.income_id")
							->join("people", "people.id", "=", "incomes.person_id")
							->where("user_id", Auth::user()->id)
							->leftJoin("periodical_publications", "periodical_publications.id", "periodical_publication_id")
							->leftJoin("nonperiodical_publications", "nonperiodical_publications.id", "nonperiodical_publication_id")
							->select("transfers.id AS id", "transfers.sum AS sum", "transfers.note AS note", "transfer_date", "incomes.id AS income_id", "name1", "periodical_publications.name AS pp_name", "nonperiodical_publications.name AS np_name")
							->get();
		$periodicals = PeriodicalPublication::get();
		$nonperiodicals = NonperiodicalPublication::get();

		/*
		echo "<pre>";
		print_r($transfers);
		echo "</pre>"; */

		return view('v-kartoteka/nepotvrdene-prevody/index')
				->with('transfers', $transfers)
				->with('periodicals', $periodicals)
				->with('nonperiodicals', $nonperiodicals);
	}

	public function filter()
	{
		$id = $_GET['userId'];
		$publication_id = $_GET['publicationId'];

		$data = array('result' => 1);

		return response()->json($data);
	}
}