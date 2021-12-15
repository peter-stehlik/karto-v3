<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use Hash;

class UserController extends Controller
{
    /**
     * Change password for a given user. POST
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function changePassword(Request $request)
    {
		$id = Auth::user()->id;
		$newPassword = $request->input('newPassword');
		$repeatNewPassword = $request->input('repeatNewPassword');

		$validated = $request->validate([
			'newPassword' => 'required|min:6',
            'repeatNewPassword' => 'required|same:newPassword',
		]);

		User::where('id', '=', $id)
			->update([
				'password' => Hash::make($request->newPassword),
			]);

		return redirect('/uzivatel/zmenit-heslo')->with('message', 'Úspešne ste zmenili heslo.');
    }

	/**
	 * Change Printer
	 */
	public function changePrinter(Request $request)
	{
		$id = Auth::user()->id;
		$printer = $request->printer;

		User::where('id', '=', $id)
			->update([
				'printer' => $printer,
			]);

		return redirect('/uzivatel/zmenit-tlaciaren')->with('message', 'Úspešne ste nastavili tlačiareň.');
	}

	/**
     * Change accounting date for a given user. GET AJAX
     *
     * @param  int  $id
     * @param  date  $accounting_date
     * @return \Illuminate\View\View
     */
	public function updateAccountingDate()
	{
		return view('v-uzivatel/uzavierka');
	}

	public function updateAccountingDatePost()
	{
		$user_id = Auth::user()->id;
		$user = User::find($user_id);

		User::where("id", $user_id)
			->update([
				"accounting_date" => Carbon::parse($user->accounting_date)->addMonth()
			]);

		return redirect('/kartoteka')->with('message', 'Operácia sa podarila!');
	}
}