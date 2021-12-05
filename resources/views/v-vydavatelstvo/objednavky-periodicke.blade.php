<x-app-layout>
    <script src="{{ asset('assets/dist/js/obj-periodical-filter.js') }}" defer></script>

    <h1 class="h3 py-2 border-bottom text-uppercase">Objednávky periodické</h1>

    <div class="col-lg-12 p-3 bg-warning">
        {!! Form::open(['action' => 'App\Http\Controllers\PrintController@objPeriodicke', 'target' => '_blank']) !!}
        <div class="row">
			<div class="col-lg-2">
                <label class="mb-2" for="count_from">Počet od:</label>

                <input class="form-control" type="number" id="count_from" name="count_from">
            </div>

			<div class="col-lg-2">
                <label class="mb-2" for="count_to">Počet do:</label>

                <input class="form-control" type="number" id="count_to" name="count_to">
            </div>

			<div class="col-lg-2">
                <label class="mb-2" for="periodical_publication_id">Periodikum:</label>

                <select class="form-control" id="periodical_publication_id" name="periodical_publication_id">
                    <option>Vyberte</option>
                    
                    @foreach( $periodical_publications as $pp )
                        <option value="{!! $pp->id !!}">{!! $pp->name !!}</option>
                    @endforeach
                </select>
            </div>
			
			<div class="col-lg-12">
				<button class="btn btn-info mt-2" id="initObjPeriodicalFilter" type="button">Vybrať</button>

                <button class="btn btn-danger mt-2" id="" type="submit">Tlač adresiek</button>
			</div>
        </div>
        {!! Form::close() !!}
    </div>

    <div class="col-lg-12">
        <div class="preloader" style="display:none;">
            Prehrabávam zásuvky, moment prosím <img src="{{ asset('assets/images/ajax-loader.gif') }}" width="16" height="11" alt="" class="ajax-loader">
        </div>

        <div class="mt-3">
            <div id="objPeriodicalFilterTabulator"></div>
        </div>
    </div>
</x-app-layout>