<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\User;
use App\Models\PeriodicalPublication;
use App\Models\NonperiodicalPublication;
use App\Models\Correction;
use App\Models\PeriodicalOrder;
use App\Models\NonperiodicalOrder;
use Auth;
use DB;

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

	public function confirmCorrectionIndividually($id)
	{
		$correction = Correction::find($id);

		if( $correction->from_periodical_id ){
			PeriodicalOrder::where("person_id", $correction->from_person_id)
                            ->where("periodical_publication_id", $correction->from_periodical_id)
                            ->decrement("credit", $correction->sum);
		}

		if( $correction->from_nonperiodical_id ){
			NonperiodicalOrder::where("person_id", $correction->from_person_id)
                            ->where("nonperiodical_publication_id", $correction->from_nonperiodical_id)
                            ->decrement("credit", $correction->sum);
		}

		/////////////////////////////////////

		if( $correction->for_periodical_id ){
			$exists = PeriodicalOrder::where("person_id", $correction->for_person_id)
                                        ->where("periodical_publication_id", $correction->for_periodical_id)
                                        ->first();
										
			if( $exists ){
				PeriodicalOrder::where("person_id", $correction->for_person_id)
				->where("periodical_publication_id", $correction->for_periodical_id)
				->increment("credit", $correction->sum);
			} else {	
				PeriodicalOrder::create([
					"person_id" => $correction->for_person_id,
					"periodical_publication_id" => $correction->for_periodical_id,
					"credit" => $correction->sum,
				]);
			}
		}

		if( $correction->for_nonperiodical_id ){
			$exists = NonperiodicalOrder::where("person_id", $correction->for_person_id)
							->where("nonperiodical_publication_id", $correction->for_nonperiodical_id)
							->first();
			
			if( $exists ){
				NonperiodicalOrder::where("person_id", $correction->for_person_id)
				->where("nonperiodical_publication_id", $correction->for_nonperiodical_id)
				->increment("credit", $correction->sum);
			} else {	
				NonperiodicalOrder::create([
					"person_id" => $correction->for_person_id,
					"nonperiodical_publication_id" => $correction->for_nonperiodical_id,
					"credit" => $correction->sum,
				]);
			}
		}

		Correction::where("id", $correction->id)
                ->update([
                    "confirmed" => 1
                ]);
		
		return redirect('/kartoteka/nepotvrdene-opravy')->with('message', 'Operácia sa podarila!');
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

	public function editPost(Request $request)
	{
		$correction_date = strtotime($request->correction_date);
		$correction_date = date('Y-m-d', $correction_date);

		Correction::where("id", $request->correction_id)
					->update([
						"from_person_id" => $request->from_person_id,
						"for_person_id" => $request->for_person_id,
						"sum" => floatval($request->sum),
						"from_periodical_id" => $request->from_periodical_id,
						"from_nonperiodical_id" => $request->from_nonperiodical_id,
						"for_periodical_id" => $request->for_periodical_id,
						"for_nonperiodical_id" => $request->for_nonperiodical_id,
						"correction_date" => $correction_date,
						"note" => $request->note,
					]);

		return redirect('/kartoteka/nepotvrdene-opravy')->with('message', 'Operácia sa podarila!');
	}

	public function listCorrections($id)
	{
		$users = User::get();
		$person = Person::withTrashed()->find($id);
		$periodical_publications = PeriodicalPublication::get();
		$nonperiodical_publications = NonperiodicalPublication::get();

		return view('v-osoba/dobrodinec/opravy')
				->with('person', $person)
				->with('users', $users)
				->with('periodical_publications', $periodical_publications)
				->with('nonperiodical_publications', $nonperiodical_publications);	
	}

	public function getCorrectionsFilter()
	{
		$person_id = $_GET["person_id"];
		$sum_from = $_GET["sum_from"];
		$sum_to = $_GET["sum_to"];
		$from_periodical_id = $_GET["from_periodical_id"];
		$from_nonperiodical_id = $_GET["from_nonperiodical_id"];
		$for_periodical_id = $_GET["for_periodical_id"];
		$for_nonperiodical_id = $_GET["for_nonperiodical_id"];
		$correction_date_from = $_GET["correction_date_from"] ? date("Y-m-d", strtotime($_GET["correction_date_from"])) : "";
		$correction_date_to = $_GET["correction_date_to"] ? date("Y-m-d", strtotime($_GET["correction_date_to"])) : "";
		$user_id = $_GET["user_id"];

		$corrections = [];
		
		$corrections = DB::table('corrections')
			->where("confirmed", 1)
			->where(function($query) use ($person_id, $user_id, $sum_from, $sum_to, $from_periodical_id, $from_nonperiodical_id, $for_periodical_id, $for_nonperiodical_id, $correction_date_from, $correction_date_to) {
				if($person_id > 0){
					$query->where(function($q) use ($person_id){
						$q->where('corrections.from_person_id', $person_id)
							->orWhere('corrections.for_person_id', $person_id);
					});
				}
				if($user_id > 0){
					$query->where('corrections.user_id', $user_id);
				}
				if($sum_from){
					$query->where('corrections.sum', '>=', $sum_from);
				}
				if($sum_to){
					$query->where('corrections.sum', '<=', $sum_to);
				}
				if($from_periodical_id){
					$query->where('corrections.from_periodical_id', $from_periodical_id);
				}
				if($from_nonperiodical_id){
					$query->where('corrections.from_nonperiodical_id', $from_nonperiodical_id);
				}
				if($for_periodical_id){
					$query->where('corrections.for_periodical_id', $for_periodical_id);
				}
				if($for_nonperiodical_id){
					$query->where('corrections.for_nonperiodical_id', $for_nonperiodical_id);
				}
				if(strlen($correction_date_from) > 0){
					$query->whereDate('corrections.correction_date', ">=", $correction_date_from);
				}
				if(strlen($correction_date_to) > 0){
					$query->whereDate('corrections.correction_date', "<", $correction_date_to);
				}
			})
			->join("people AS from_person_id", "from_person_id.id", "=", "corrections.from_person_id")
			->join("people AS for_person_id", "for_person_id.id", "=", "corrections.for_person_id")
			->join("users", "corrections.user_id", "=", "users.id")
			->leftJoin("periodical_publications AS from_periodical_publications", "from_periodical_publications.id", "=", "corrections.from_periodical_id")
			->leftJoin("periodical_publications AS for_periodical_publications", "for_periodical_publications.id", "=", "corrections.for_periodical_id")
			->leftJoin("nonperiodical_publications AS from_nonperiodical_publications", "from_nonperiodical_publications.id", "=", "corrections.from_nonperiodical_id")
			->leftJoin("nonperiodical_publications AS for_nonperiodical_publications", "for_nonperiodical_publications.id", "=", "corrections.for_nonperiodical_id")
			->select("corrections.id AS correction_id", "corrections.sum AS correction_sum", "correction_date", "corrections.note AS correction_note", "from_person_id.name1 AS from_person_id_name1", "from_person_id.city AS from_person_id_city", "for_person_id.name1 AS for_person_id_name1", "for_person_id.city AS for_person_id_city", "from_periodical_publications.name AS from_periodical_publications_name", "for_periodical_publications.name AS for_periodical_publications_name", "from_nonperiodical_publications.name AS from_nonperiodical_publications_name", "for_nonperiodical_publications.name AS for_nonperiodical_publications_name", "users.name AS username")
			->orderBy("correction_date", "desc")
			->get();

		$data = array('result' => 1);

		$data["corrections"] = $corrections;

		return response()->json($data);
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