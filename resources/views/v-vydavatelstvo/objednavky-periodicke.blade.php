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
			</div>

            <div class="col-lg-12 mt-2" id="printSettings" style="display: none;">
                <div class="row">
                    <div class="col-lg-2">
                        <div class="mb-3">
                            <label class="mb-2" for="columns">Počet stĺpcov</label>
                            
                            <select class="form-control" id="columns" name="columns">
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-lg-2">
                        <div class="mb-3">
                            <label class="mb-2" for="start_position">Začiatočná pozícia</label>
                            
                            <input class="form-control" id="start_position" name="start_position" type="text" value="1">
                        </div>
                    </div>
                    
                    <div class="col-lg-2">
                        <div class="mb-3">
                            <label class="d-block mb-2" for="city">&nbsp;</label>
                            
                            <button class="btn btn-danger" type="submit">Tlačiť</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-12 mt-2">
                    <div class="mb-3">                    
                        <button class="btn btn-secondary" id="togglePrintSettings" type="button">Nastaviť tlač</button>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <div class="col-lg-12">
        <div class="preloader" style="display:none;">
            Prehrabávam zásuvky, moment prosím <img src="{{ asset('assets/images/ajax-loader.gif') }}" width="16" height="11" alt="" class="ajax-loader">
        </div>

        <div class="mt-3">
            <p class="total-count-wrap" style="display: none;">Celkový počet: <strong id="totalCount"></strong></p>

            <div id="objPeriodicalFilterTabulator"></div>
        </div>
    </div>
</x-app-layout>