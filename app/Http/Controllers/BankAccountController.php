<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankAccount;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bank_accounts = BankAccount::orderBy("created_at", "desc")->get();

        return view('v-kancelaria/bankove-ucty/index')
                ->with('bank_accounts', $bank_accounts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('v-kancelaria/bankove-ucty/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bank_name = $request->bank_name; 
        $abbreviation = $request->abbreviation; 
        $number = $request->number;

        BankAccount::create([
            'bank_name' => $bank_name,
            'abbreviation' => $abbreviation,
            'number' => $number,
        ]);

        return redirect('kancelaria/bankove-ucty')->with('message', 'Operácia sa podarila!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bank_account = BankAccount::find($id);

        return view('v-kancelaria/bankove-ucty/edit')
            ->with('bank_account', $bank_account);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bank_name = $request->bank_name; 
        $abbreviation = $request->abbreviation; 
        $number = $request->number;

        BankAccount::where('id', $id)
            ->update([
                'bank_name' => $bank_name,
                'abbreviation' => $abbreviation,
                'number' => $number,
            ]);

        return redirect('kancelaria/bankove-ucty')->with('message', 'Operácia sa podarila!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BankAccount::find($id)->delete($id);
  
        return response()->json([
            'success' => '1'
        ]);
    }
}
