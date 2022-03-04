<x-app-layout>
    <script src="{{ asset('assets/dist/js/list-filter.js') }}" defer></script>

    <h1 class="h3 py-2 border-bottom text-uppercase">Zoznam</h1>

    <p>Ak chcete vybrať naraz viac periodík držte stlačenú klávesu <strong>Ctrl + klik</strong> označte všetky.</p>

    <div class="col-lg-12 p-3 bg-warning">
        <div class="row">
            {!! Form::open(['action' => 'App\Http\Controllers\ListingController@printListFilterPdf', 'id' => 'printListFilter', 'target' => 'blank']) !!}
                <div class="col-lg-2">
                    <label class="mb-2" for="periodical_publication_id">Periodikum:</label>

                    <select class="form-control" id="periodical_publication_id" name="periodical_publication_ids[]" multiple>
                        <option>Vyberte</option>
                        
                        @foreach( $periodical_publications as $pp )
                            <option value="{!! $pp->id !!}">{!! $pp->name !!}</option>
                        @endforeach
                    </select>

                    <button class="btn btn-info mt-2" id="initListFilter" type="button">Vybrať</button>

                    <button class="btn btn-secondary mt-2" type="submit">Generuj PDF</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>

    <div class="col-lg-12">
        <div class="preloader" style="display:none;">
            Prehrabávam zásuvky, moment prosím <img src="{{ asset('assets/images/ajax-loader.gif') }}" width="16" height="11" alt="" class="ajax-loader">
        </div>

        <div class="mt-3">
            <p class="total-count-wrap" style="display: none;">Celkový počet: <strong id="totalCount"></strong></p>

            <div id="listFilterTabulator"></div>
        </div>
    </div>
</x-app-layout>