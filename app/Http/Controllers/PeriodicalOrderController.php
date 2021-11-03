<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\PeriodicalPublication;
use App\Models\PeriodicalOrder;

class PeriodicalOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $person = Person::withTrashed()->find($id);
        $periodical_orders = PeriodicalOrder::where("person_id", $id)
                                ->join("periodical_publications", "periodical_publications.id", "=", "periodical_orders.periodical_publication_id")
                                ->select("periodical_orders.id", "periodical_publications.name", "periodical_publication_id", "count", "credit", "valid_from", "valid_to", "periodical_orders.note", "gratis")
                                ->orderBy("periodical_orders.created_at", "desc")
                                ->get();
        
        return view('v-osoba/dobrodinec/objednavky/index')
                    ->with('person', $person)
                    ->with('periodical_orders', $periodical_orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $person = Person::withTrashed()->find($id);
        $periodical_publications = PeriodicalPublication::get();

        return view('v-osoba/dobrodinec/objednavky/create')
                ->with('person', $person)
                ->with('periodical_publications', $periodical_publications);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $person_id = $request->person_id;
        $periodical_publication_id = $request->periodical_publication_id; 
        $count = $request->count; 
        $credit = $request->credit; 
        $valid_from = strtotime($request->valid_from);
		$valid_from = date('Y-m-d', $valid_from);
        $valid_to = $request->valid_to;
        if( !$valid_to ){
            $valid_to = "1.1.3000";
        }
        $valid_to = strtotime($valid_to);
        $valid_to = date('Y-m-d', $valid_to); 
        $note = $request->note; 
        $gratis = $request->gratis; 

        PeriodicalOrder::create([
            'person_id' => $person_id,
            'periodical_publication_id' => $periodical_publication_id,
            'count' => $count,
            'credit' => $credit,
            'valid_from' => $valid_from,
            'valid_to' => $valid_to,
            'note' => $note,
            'gratis' => $gratis,
        ]);

        return redirect('dobrodinec/' . $person_id . '/objednavky')->with('message', 'Operácia sa podarila!');
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
    public function edit($id, $po_id)
    {
        $person = Person::withTrashed()->find($id);
        $periodical_order = PeriodicalOrder::find($po_id);
        $periodical_publications = PeriodicalPublication::get();

        return view('v-osoba/dobrodinec/objednavky/edit')
                ->with('person', $person)
                ->with('periodical_order', $periodical_order)
                ->with('periodical_publications', $periodical_publications);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $po_id)
    {
        $person_id = $request->person_id;
        $periodical_publication_id = $request->periodical_publication_id; 
        $count = $request->count; 
        $credit = $request->credit; 
        $valid_from = strtotime($request->valid_from);
		$valid_from = date('Y-m-d', $valid_from);
        $valid_to = $request->valid_to;
        if( !$valid_to ){
            $valid_to = "1.1.3000";
        }
        $valid_to = strtotime($valid_to);
        $valid_to = date('Y-m-d', $valid_to); 
        $note = $request->note; 
        $gratis = $request->gratis; 

        PeriodicalOrder::where("id", $po_id)
            ->update([
                'person_id' => $person_id,
                'periodical_publication_id' => $periodical_publication_id,
                'count' => $count,
                'credit' => $credit,
                'valid_from' => $valid_from,
                'valid_to' => $valid_to,
                'note' => $note,
                'gratis' => $gratis,
            ]);
        
        return redirect('/dobrodinec/ ' . $id . ' /objednavky')->with('message', 'Operácia sa podarila!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $po_id)
    {
        PeriodicalOrder::find($po_id)->delete($po_id);

        return response()->json([
            'success' => '1'
        ]);
    }
}
