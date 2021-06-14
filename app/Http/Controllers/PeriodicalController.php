<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeriodicalPublication;

class PeriodicalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periodicals = PeriodicalPublication::orderBy("created_at", "desc")->get();

        return view('v-vydavatelstvo/publikacie/index')
                ->with('periodicals', $periodicals);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('v-vydavatelstvo/publikacie/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->name; 
        $abbreviation = $request->abbreviation; 
        $price = $request->price;
        $note = $request->note;

        PeriodicalPublication::create([
            'name' => $name,
            'abbreviation' => $abbreviation,
            'price' => $price,
            'note' => $note,
        ]);

        return redirect('vydavatelstvo/publikacie')->with('message', 'Operácia sa podarila!');
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
        $periodical = PeriodicalPublication::find($id);

        return view('v-vydavatelstvo/publikacie/edit')
            ->with('periodical', $periodical);
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
        $name = $request->name; 
        $abbreviation = $request->abbreviation; 
        $price = $request->price;
        $note = $request->note;

        PeriodicalPublication::where('id', $id)
            ->update([
                'name' => $name,
                'abbreviation' => $abbreviation,
                'price' => $price,
                'note' => $note,
            ]);

        return redirect('vydavatelstvo/publikacie')->with('message', 'Operácia sa podarila!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PeriodicalPublication::find($id)->delete($id);
  
        return response()->json([
            'success' => '1'
        ]);
    }
}
