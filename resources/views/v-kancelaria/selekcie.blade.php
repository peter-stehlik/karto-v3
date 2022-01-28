<x-app-layout>
    <script src="{{ asset('assets/dist/js/selection-filter.js') }}" defer></script>

    <h1 class="h3 py-2 border-bottom text-uppercase">Selekcie</h1>

    <div class="col-lg-12 p-3 bg-warning">
        {!! Form::open(['action' => 'App\Http\Controllers\PrintController@selekcie', 'id' => 'printSelection', 'target' => 'blank']) !!}
            <div class="row">
                <div class="col-lg-2">
                    <label class="mb-2" for="date_from">Dátum od:</label>

                    <input class="form-control" type="text" id="date_from" name="date_from" required>
                </div>

                <div class="col-lg-2">
                    <label class="mb-2" for="date_to">Dátum do:</label>

                    <input class="form-control" type="text" id="date_to" name="date_to" value="<?php echo date("j.n.Y"); ?>">
                </div>

                <div class="col-lg-2">
                    <label class="mb-2" for="transfer">Účel:</label>

                    <select class="form-control" id="transfer" name="transfer[]" multiple>
                        <option value="0">Nezáleží, ľubovoľný príjem</option>
                        
                        @foreach( $periodical_publications as $pp )
                            <option value="p{!! $pp->id !!}">{!! $pp->name !!}</option>
                        @endforeach

                        @foreach( $nonperiodical_publications as $pp )
                            <option value="n{!! $pp->id !!}">{!! $pp->name !!}</option>
                        @endforeach
                    </select>

                    <input type="hidden" id="periodical_publication_ids" name="periodical_publication_id">
                    <input type="hidden" id="nonperiodical_publication_ids" name="nonperiodical_publication_id">
                </div>

                <div class="col-lg-2">
                    <label class="mb-2" for="category">Kategória:</label>

                    <select class="form-control" id="category" name="category">
                        <option>Nezáleží</option>
                        
                        @foreach( $categories as $category )
                            <option value="{!! $category->id !!}">{!! $category->name !!}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 mb-2">
                    <button class="btn btn-info mt-2" id="initSelectionFilter" type="button">Vybrať</button>
                </div>
            </div>

            <div class="row">	
                <div class="col-lg-12" id="printSettings" style="display: none;">
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
                
                <div class="col-lg-12">
                    <div class="mb-3">								
                        <button class="btn btn-secondary" id="togglePrintSettings" type="button">Nastaviť tlač</button>
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
            <div id="selectionFilterTabulator"></div>
        </div>
    </div>
</x-app-layout>