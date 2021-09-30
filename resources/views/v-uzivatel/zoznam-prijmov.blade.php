<x-app-layout>
    <h1 class="h3 py-2 border-bottom text-uppercase">
		Zoznam všetkých príjmov
	</h1>

	<div class="col-lg-12 p-3 bg-warning">
        <div class="row">
            <input id="person_id" type="hidden" value="0">

            <div class="col-lg-2">
                <div class="mb-3">
                    <label class="mb-2" for="user_id">Užívateľ:</label>
                    
                    <select class="form-control" id="user_id">
                        <option value="0">Nezáleží</option>

                        @foreach( $users as $user )
                            <option value="{!! $user->id !!}">{!! $user->name !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-lg-1">
                <div class="mb-3">
                    <label class="mb-2" for="sum_from">Suma od:</label>
                    
                    <input class="form-control" id="sum_from" type="number">
                </div>
            </div>

            <div class="col-lg-1">
                <div class="mb-3">
                    <label class="mb-2" for="sum_to">Suma do:</label>
                    
                    <input class="form-control" id="sum_to" type="number">
                </div>
            </div>

            <div class="col-lg-2">
                <div class="mb-3">
                    <label class="mb-2" for="bank_account_id">Bankový účet:</label>
                    
                    <select class="form-control" id="bank_account_id">
                        <option value="0">Nezáleží</option>

                        @foreach( $bank_accounts as $ba )
                            <option value="{!! $ba->id !!}">{!! $ba->bank_name !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-lg-1">
                <div class="mb-3">
                    <label class="mb-2" for="number_from">Číslo od:</label>
                    
                    <input class="form-control" id="number_from" type="number">
                </div>
            </div>

            <div class="col-lg-1">
                <div class="mb-3">
                    <label class="mb-2" for="number_to">Číslo do:</label>
                    
                    <input class="form-control" id="number_to" type="number">
                </div>
            </div>

            <div class="col-lg-1">
                <div class="mb-3">
                    <label class="mb-2" for="package_number">Balík:</label>
                    
                    <input class="form-control" id="package_number" type="number">
                </div>
            </div>

            <div class="col-lg-1">
                <div class="mb-3">
                    <label class="mb-2" for="invoice">Faktúra:</label>
                    
                    <input class="form-control" id="invoice" type="text">
                </div>
            </div>

            <div class="col-lg-12"></div>

            <div class="col-lg-2">
                <div class="mb-3">
                    <label class="mb-2" for="accounting_date_from">Účt. dátum od:</label>
                    
                    <input class="form-control" id="accounting_date_from" type="text">
                </div>
            </div>

            <div class="col-lg-2">
                <div class="mb-3">
                    <label class="mb-2" for="accounting_date_to">Účt. dátum do:</label>
                    
                    <input class="form-control" id="accounting_date_to" type="text">
                </div>
            </div>

            <div class="col-lg-2">
                <div class="mb-3">
                    <label class="mb-2" for="income_date_from">Dát. príjmu od:</label>
                    
                    <input class="form-control" id="income_date_from" type="text">
                </div>
            </div>

            <div class="col-lg-2">
                <div class="mb-3">
                    <label class="mb-2" for="income_date_to">Dát. príjmu do:</label>
                    
                    <input class="form-control" id="income_date_to" type="text">
                </div>
            </div>

            <div class="col-lg-2">
                <div class="mb-3">
                    <label class="d-block mb-2" for="">&nbsp;</label>
                    
                    <button class="btn btn-primary" id="initPersonIncomesFilter" type="submit">Filtrovať</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="preloader" style="display:none;">
            Prehrabávam zásuvky, moment prosím <img src="{{ asset('assets/images/ajax-loader.gif') }}" width="16" height="11" alt="" class="ajax-loader">
        </div>

        <!-- OLD WAY, REPLACED BY TABULATOR.JS
        <table class="table" id="personIncomeFilterTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Užívateľ</th>
                    <th>Suma</th>
                    <th>Bankový účet</th>
                    <th>Číslo</th>
                    <th>Balík</th>
                    <th>Faktúra</th>
                    <th>Účt. dátum</th>
                    <th>Poznámka</th>
                    <th>Dát. príjmu</th>
                    <th></th>
                </tr>
            </thead>

            <tbody id="personIncomeFilterTableResults">

            </tbody>
        </table>-->

        <div class="mt-3">
            <div id="personIncomesFilterTabulator"></div>
        </div>
    </div>  
</x-app-layout> 