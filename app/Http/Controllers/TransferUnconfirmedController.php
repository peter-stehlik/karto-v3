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
							->join("bank_accounts", "bank_accounts.id", "=", "incomes.bank_account_id")
							->join("people", "people.id", "=", "incomes.person_id")
							->where("confirmed", 0)
							->where("user_id", Auth::user()->id)
							->leftJoin("periodical_publications", "periodical_publications.id", "periodical_publication_id")
							->leftJoin("nonperiodical_publications", "nonperiodical_publications.id", "nonperiodical_publication_id")
							->select("transfers.id AS id", "transfers.sum AS sum", "transfers.note AS note", "transfer_date", "incomes.id AS income_id", "incomes.sum AS income_sum", "bank_name", "incomes.number", "incomes.package_number", "incomes.invoice", "income_date", "name1", "periodical_publications.id AS pp_id", "periodical_publications.name AS pp_name", "nonperiodical_publications.name AS np_name", "nonperiodical_publications.id AS np_id")
							->orderBy("transfer_date", "desc")
							->get();
		$periodicals = PeriodicalPublication::get();
		$nonperiodicals = NonperiodicalPublication::get();

		return view('v-kartoteka/nepotvrdene-prevody/index')
				->with('transfers', $transfers)
				->with('periodicals', $periodicals)
				->with('nonperiodicals', $nonperiodicals);
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Transfer::find($id)->delete($id);

        return response()->json([
            'success' => '1'
        ]);
    }
}