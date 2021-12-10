<x-app-layout>
    <script src="{{ asset('assets/dist/js/people-filter.js') }}" defer></script>

    <h1 class="h3 py-2 border-bottom text-uppercase">Filter osôb</h1>

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
                    
                    <button class="btn btn-primary" id="initFilter" type="submit">Filtrovať</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="row">
            <div class="preloader" style="display:none;">
                Prehrabávam zásuvky, moment prosím <img src="{{ asset('assets/images/ajax-loader.gif') }}" width="16" height="11" alt="" class="ajax-loader">
            </div>

            <!-- OLD WAY HOW TO DISPLAY AJAX RESULTS, REPLACED BY TABULATOR.JS PLUGIN
            <table class="table" id="filterTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Meno 1</th>
                        <th>Adresa 1</th>
                        <th>Kategória</th>
                        <th>Poznámka</th>
                    </tr>
                </thead>

                <tbody id="filterResults">

                </tbody>
            </table> -->

            <div class="mt-3">
                <div id="personFilterTabulator"></div>
            </div>
        </div>
    </div>    
</x-app-layout>
