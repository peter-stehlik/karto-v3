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
		$periodicals = PeriodicalPublication::get();
		$nonperiodicals = NonperiodicalPublication::get();

		return view('v-kartoteka/nepotvrdene-prevody/index')
				->with('periodicals', $periodicals)
				->with('nonperiodicals', $nonperiodicals);
	}

	public function filter()
	{

	}
}