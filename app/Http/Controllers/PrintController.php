<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;

class PrintController extends Controller
{
	public function person($id)
	{
		$person = Person::withTrashed()->find($id);
		
		return view('v-tlac/person')
                    ->with('person', $person);
	}
}