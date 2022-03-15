<x-app-layout>
    <h1 class="h3 py-2 border-bottom text-uppercase">Money XML Import</h1>

    {!! Form::open(['action' => ['App\Http\Controllers\MoneyXmlImportController@import'], 'method' => 'POST', 'id' => 'moneyXmlImport', 'files' => 'true']) !!}	
    <div class="row">
        <div class="col-lg-6">
            <div class="col-lg-3">
                <div class="mb-3">
                    <label class="pr-2 mb-1" for="xml">Nahrajte XML súbor</label>

                    <div>
                        <input id="xml" type="file" name="xml">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <button class="btn btn-primary" type="submit">Nahrať</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</x-app-layout>
