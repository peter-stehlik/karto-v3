<?php

namespace App\Http\Controllers;
use App\Models\NonperiodicalPublication;

use Illuminate\Http\Request;

class NonperiodicalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nonperiodicals = NonperiodicalPublication::orderBy("created_at", "desc")->get();

        return view('v-vydavatelstvo/neperiodika/index')
                ->with('nonperiodicals', $nonperiodicals);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('v-vydavatelstvo/neperiodika/create');
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

        NonperiodicalPublication::create([
            'name' => $name,
            'abbreviation' => $abbreviation,
        ]);

        return redirect('vydavatelstvo/neperiodika')->with('message', 'Operácia sa podarila!');
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
        $nonperiodical = NonperiodicalPublication::find($id);

        return view('v-vydavatelstvo/neperiodika/edit')
            ->with('nonperiodical', $nonperiodical);
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

        NonperiodicalPublication::where('id', $id)
            ->update([
                'name' => $name,
                'abbreviation' => $abbreviation,
            ]);

        return redirect('vydavatelstvo/neperiodika')->with('message', 'Operácia sa podarila!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        NonperiodicalPublication::find($id)->delete($id);
  
        return response()->json([
            'success' => '1'
        ]);
    }
}
