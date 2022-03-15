<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transfer;
use App\Models\Income;
use App\Models\Person;
use Auth;

class MoneyXmlImportController extends Controller
{
    /**
     * Upload XML.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('v-kartoteka/money-xml-import');
    }

    /**
     * parse XML
     */
    public function import(Request $request)
    {
        $money = $request->file('xml');

        if (!$money) {
            return;
        }

        $extension = $money->getClientOriginalExtension();

        if( $extension != "xml" ){
            return;
        }

        $destinationPath = public_path('/uploads/money-xml/');
        $filename = date("Y-m-d_H-i-s");
        $filename .= ".xml";
        // $filename = $money->getClientOriginalName();
        $money->move($destinationPath,$filename);

        $xmlDataString = file_get_contents(public_path('/uploads/money-xml/' . $filename . ''));
        $xmlObject = simplexml_load_string($xmlDataString);

        foreach( $xmlObject->Detail1 as $item ){
            $person_id = $item->_27; //

            $person = Person::find($person_id);

            if( !is_object($person) ){
                $person_id = 28;
                // return redirect('/kartoteka/nepotvrdene-prijmy')->with('message', 'Chyba! ID osoby neexistuje!');
            }

            $number = 9999; //
            $package_number = 9999; //
            $invoice = 9999; //
            $note = ""; //
            $accounting_date = ""; //
            $income_date = ""; //
            
            $sum = floatval(str_replace(',', '.', $item->_23));
            // $bank_account_code = $item->_18;
            $bank_account_id = 5; // SLSP
            $user_id = Auth::user()->id;
            $confirmed = 0;

            $income_date = strtotime($income_date);
            $income_date = date('Y-m-d', $income_date);

            $new_income = Income::create([
                'person_id' => $person_id,
                'user_id' => $user_id,
                'sum' => $sum,
                'bank_account_id' => $bank_account_id,
                'number' => $number,
                'package_number' => $package_number,
                'invoice' => $invoice,
                'confirmed' => $confirmed,
                'note' => $note,
                'accounting_date' => $accounting_date,
                'income_date' => $income_date,
            ]);

            $transfers_codes = explode(",", $item->_19);

            if( $transfers_codes ){
                foreach( $transfers_codes as $tc ){
                    $tc = trim($tc);
                    $codeStart = substr($tc, 0, 1);

                    if( $codeStart === "p" ){
                        // PERIODICAL
                        $tc = substr($codeStart, 1);

                        Transfer::create([
                            "income_id" => $new_income->id,
                            "periodical_publication_id" => intval($tc),
                            "note" => "",
                            "sum" => 0,
                            "transfer_date" => $income_date,
                        ]);

                    } else {
                        // NONPERIODICAL

                        Transfer::create([
                            "income_id" => $new_income->id,
                            "nonperiodical_publication_id" => intval($tc),
                            "note" => "",
                            "sum" => 0,
                            "transfer_date" => $income_date,
                        ]);
                    }
                }
            }
        }

        return redirect('/kartoteka/nepotvrdene-prijmy')->with('message', 'Operácia sa podarila!');
    }
}
