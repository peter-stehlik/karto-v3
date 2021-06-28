<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
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
     * Change accounting date for a given user. GET AJAX
     *
     * @param  int  $id
     * @param  date  $accounting_date
     * @return json
     */
	public function updateAccountingDate()
	{
		$id = $_GET['userId'];
		$accountingDate = date('Y-m-d', strtotime($_GET['accountingDate']));

		User::where('id', '=', $id)
			->update([
				'accounting_date' => $accountingDate,
			]);		

		$data = array('result' => 1);

		return response()->json($data);
	}
}