<x-app-layout>
    <script src="{{ asset('assets/dist/js/people-filter.js') }}" defer></script>

    <h1 class="h3 py-2 border-bottom text-uppercase">Filter osôb</h1>

    {!! Form::open(['action' => 'App\Http\Controllers\PersonFilterController@filterPrint', 'target' => '_blank']) !!}
    <div class="col-lg-12 p-3 bg-warning">
        <div class="row">
            <div class="col-lg-1">
                <div class="mb-3">
                    <label class="mb-2" for="id">ID:</label>
                    
                    <input class="form-control" id="id" type="number" name="id">
                </div>
            </div>
            
            <div class="col-lg-2">
                <div class="mb-3">
                    <label class="mb-2" for="category_id">Kategória:</label>
                    
                    <select class="form-control" id="category_id" name="category_id">
                        <option value="0">Vyberte</option>
                        @foreach( $categories as $cat )
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="mb-3">
                    <label class="mb-2" for="name1">Meno 1:</label>
                    
                    <input class="form-control" id="name1" type="text" name="name1">
                </div>
            </div>

            <div class="col-lg-2">
                <div class="mb-3">
                    <label class="mb-2" for="address1">Adresa 1:</label>
                    
                    <input class="form-control" id="address1" type="text" name="address1">
                </div>
            </div>

            <div class="col-lg-1">
                <div class="mb-3">
                    <label class="mb-2" for="zip_code">PSČ:</label>
                    
                    <input class="form-control" id="zip_code" type="text" name="zip_code">
                </div>
            </div>

            <div class="col-lg-2">
                <div class="mb-3">
                    <label class="mb-2" for="city">Mesto:</label>
                    
                    <input class="form-control" id="city" type="text" name="city">
                </div>
            </div>

            <div class="col-lg-1">
                <div class="mb-3">
                    <label class="mb-2" for="city">V koši:</label>
                    
                    <select class="form-control" id="bin" name="bin">
                        <option value="0">Nie</option>
                        <option value="1">Áno</option>
                    </select>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="mb-3">
                    <label class="mb-2" for="city">&nbsp;</label>
                    
                    <button class="btn btn-primary" id="initFilter" type="button">Filtrovať</button>
                </div>
            </div>

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
                    <label class="mb-2" for="city">&nbsp;</label>
                    
                    <button class="btn btn-secondary" id="togglePrintSettings" type="button">Nastaviť tlač</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    <div class="col-lg-12">
        <div class="row">
            <div class="preloader" style="display:none;">
                Prehrabávam zásuvky, moment prosím <img src="{{ asset('assets/images/ajax-loader.gif') }}" width="16" height="11" alt="" class="ajax-loader">
            </div>

            <div class="mt-3">
                <p class="total-count-wrap" style="display: none;">Celkový počet: <strong id="totalCount"></strong></p>

                <div id="personFilterTabulator"></div>
            </div>
        </div>
    </div>    
</x-app-layout>
