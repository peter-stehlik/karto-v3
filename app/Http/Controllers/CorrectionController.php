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

	/**
	 * Uloz opravu cez hviezdicku
	 */
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

	/**
	 * vypis zoznam zatial nepotvrdenych oprav
	 */
	public function listUnconfirmedCorrections()
	{
		$corrections = Correction::where("confirmed", 0)
						->where("user_id", Auth::user()->id)
						->join("people AS from_person_id", "from_person_id.id", "=", "corrections.from_person_id")
						->join("people AS for_person_id", "for_person_id.id", "=", "corrections.for_person_id")
						->leftJoin("periodical_publications AS from_periodical_publications", "from_periodical_publications.id", "=", "corrections.from_periodical_id")
						->leftJoin("periodical_publications AS for_periodical_publications", "for_periodical_publications.id", "=", "corrections.for_periodical_id")
						->leftJoin("nonperiodical_publications AS from_nonperiodical_publications", "from_nonperiodical_publications.id", "=", "corrections.from_nonperiodical_id")
						->leftJoin("nonperiodical_publications AS for_nonperiodical_publications", "for_nonperiodical_publications.id", "=", "corrections.for_nonperiodical_id")
						->select("corrections.id AS correction_id", "corrections.sum AS correction_sum", "correction_date", "corrections.note AS correction_note", "from_person_id.name1 AS from_person_id_name1", "for_person_id.name1 AS for_person_id_name1", "from_periodical_publications.name AS from_periodical_publications_name", "for_periodical_publications.name AS for_periodical_publications_name", "from_nonperiodical_publications.name AS from_nonperiodical_publications_name", "for_nonperiodical_publications.name AS for_nonperiodical_publications_name")
						->get();

		return view('v-kartoteka/nepotvrdene-opravy/index')
		->with('corrections', $corrections);
	}

	public function confirmCorrectionIndividually()
	{
		
	}

	public function editGet($id)
	{
		$correction = Correction::find($id);
		$periodical_publications = PeriodicalPublication::get();
		$nonperiodical_publications = NonperiodicalPublication::get();
		$from_person_name = Person::find($correction->from_person_id)->name1;
		$for_person_name = Person::find($correction->for_person_id)->name1;
		$transfer_name = "";

		if( $correction->from_periodical_id ){
			$transfer_name = PeriodicalPublication::find($correction->from_periodical_id)->name;
		}

		if( $correction->from_nonperiodical_id ){
			$transfer_name = NonperiodicalPublication::find($correction->from_nonperiodical_id)->name;
		}

		return view('v-kartoteka/nepotvrdene-opravy/edit')
				->with('correction', $correction)
				->with('from_person_name', $from_person_name)
				->with('for_person_name', $for_person_name)
				->with('transfer_name', $transfer_name)
				->with('periodical_publications', $periodical_publications)
				->with('nonperiodical_publications', $nonperiodical_publications);
	}

	public function editPost()
	{

	}

	/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Correction::find($id)->delete($id);

        return response()->json([
            'success' => '1'
        ]);
    }
}