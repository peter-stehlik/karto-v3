<x-app-layout>
    <h1 class="h3 py-2 border-bottom text-uppercase">Uzávierka</h1>

    <div class="col-lg-12">
        {!! Form::open(['action' => 'App\Http\Controllers\UserController@updateAccountingDatePost', 'id' => 'uzavierka']) !!}
            <p>{!! Auth::user()->name !!}, súčasný účtovný dátum: {!! date("d.m.Y", strtotime(Auth::user()->accounting_date)) !!} </p>

            <p>Chcete spraviť uzávierku?</p>

            <button class="btn btn-danger" type="submit">Potvrdzujem uzávierku</button>
        {!! Form::close() !!}
    </div>
</x-app-layout>