<x-app-layout>
    <h1 class="h3 py-2 border-bottom text-uppercase">Zoznam</h1>

    <p>Ak chcete vybrať naraz viac periodík držte stlačenú klávesu <strong>Ctrl + klik</strong> označte všetky.</p>

    <div class="col-lg-12 p-3 bg-warning">
        {!! Form::open(['action' => 'App\Http\Controllers\ListingController@printForTransferPdf', 'id' => 'printForTransferPdf', 'target' => 'blank']) !!}
            <div class="row">
                <div class="col-lg-2">
                    <label class="mb-2" for="periodical_publication_id">Periodikum:</label>

                    <select class="form-control" id="periodical_publication_id" name="periodical_publication_id" multiple>
                        <option>Vyberte</option>
                        
                        @foreach( $periodical_publications as $pp )
                            <option value="{!! $pp->id !!}">{!! $pp->name !!}</option>
                        @endforeach
                    </select>

                    <button class="btn btn-info mt-2" type="submit">Vybrať</button>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</x-app-layout>