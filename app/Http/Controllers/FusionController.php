<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\User;
use App\Models\Income;
use App\Models\Outcome;
use App\Models\Correction;
use App\Models\PeriodicalCredit;
use App\Models\NonperiodicalCredit;
use App\Models\Fusion;
use Auth;

/** zlucenie 2 osob */
class FusionController extends Controller
{
	/* formular na zlucenie */
	public function getFusion($id)
	{
		$person = Person::find($id);

		return view('v-osoba/dobrodinec/zlucenie')
				->with('person', $person);
	}

	/* vyhladat osobu, ktora bude zlucena */
	public function getFusionFilter()
	{
		/* netreba, pouziva sa rovnaky filter ako pri oprave cez hviezdicku */
	}

	/* zlucenie */
	public function postFusion(Request $request)
	{
		$user_id = Auth::user()->id;
		$fusion_person_id = $request->fusion_person_id;
		$fused_person_id = $request->fused_person_id;

		// zlucenie prijmov (a tym padom aj prevodov, tam netreba nic robit)
		Income::where("person_id", $fused_person_id)
				->update([
					"person_id" => $fusion_person_id
				]);

		// zlucenie oprav
		Correction::where("from_person_id", $fused_person_id)
					->update([
						"from_person_id" => $fusion_person_id
					]);

		Correction::where("for_person_id", $fused_person_id)
					->update([
						"for_person_id" => $fusion_person_id
					]);

		// zlucenie vydajov
		Outcome::where("person_id", $fused_person_id)
				->update([
					"person_id" => $fusion_person_id
				]);

		// zlucenie kredit periodik
		$periodical_credit = PeriodicalCredit::where("person_id", $fused_person_id)
			->get();
		
		if( $periodical_credit ){
			foreach( $periodical_credit as $po ){
				PeriodicalCredit::where("person_id", $fusion_person_id)
				->where("periodical_publication_id", $po->periodical_publication_id)
				->increment("credit", $po->credit);
			}
		}

		// zlucenie kredit neperiodik
		$nonperiodical_credit = NonperiodicalCredit::where("person_id", $fused_person_id)
			->update([
				"person_id" => $fusion_person_id
			]);

		if( $nonperiodical_credit ){
			foreach( $nonperiodical_credit as $po ){
				NonperiodicalCredit::where("person_id", $fusion_person_id)
				->where("nonperiodical_publication_id", $po->nonperiodical_publication_id)
				->increment("credit", $po->credit);
			}
		}

		// zaznam o zluceni
		Fusion::create([
			"user_id" => $user_id,
			"fused_person_id" => $fused_person_id,
			"fusion_person_id" => $fusion_person_id,
		]);

		// vymazanie osoby
		Person::find($fused_person_id)->delete($fused_person_id);

		return redirect('/dobrodinec/' . $fusion_person_id . '/ucty')->with('message', 'Operácia sa podarila!');
	}
}