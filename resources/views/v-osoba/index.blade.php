<x-app-layout>
    <h1 class="h3 py-2 border-bottom text-uppercase">Filter osôb</h1>


        <div class="col-lg-12 p-3 bg-warning">
            <div class="row">
                <div class="col-lg-1">
                    <div class="mb-3">
                        <label class="mb-2" for="person_id">ID:</label>
                        
                        <input class="form-control" id="person_id" type="number" name="person_id">
                    </div>
                </div>
                
                <div class="col-lg-2">
                    <div class="mb-3">
                        <label class="mb-2" for="transfer">Kategória:</label>
                        
                        <select class="form-control" id="category" name="category">
                            <option>Vyberte</option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-2">
                    <div class="mb-3">
                        <label class="mb-2" for="name">Meno:</label>
                        
                        <input class="form-control" id="name" type="text" name="name">
                    </div>
                </div>

                <div class="col-lg-2">
                    <div class="mb-3">
                        <label class="mb-2" for="address">Adresa:</label>
                        
                        <input class="form-control" id="address" type="text" name="address">
                    </div>
                </div>

                <div class="col-lg-1">
                    <div class="mb-3">
                        <label class="mb-2" for="post_code">PSČ:</label>
                        
                        <input class="form-control" id="post_code" type="text" name="post_code">
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

</x-app-layout>
