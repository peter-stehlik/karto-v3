<x-app-layout>
    <h1 class="h3 py-2 border-bottom text-uppercase">
		Prevody
	</h1>

	<script>
		$(document).ready(function(){
			let dobrodinec = "<strong>{{ $person->name1 }}</strong><span class='d-block text-secondary'> {{ $person->organization }}</span>{{ $person->address1 }}<span class='d-block text-secondary'> {{ $person->zip_code }} {{ $person->city }}</span>{{ $person->email }}";
			
			$("#dobrodinec").html(dobrodinec);
		});		
	</script>

	<div class="col-lg-12 p-3 bg-warning">
		<input id="person_id" type="hidden" value="{!! $person->id !!}">

        <div class="row">
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
                    <label class="mb-2" for="periodical_publication_id">Periodikum:</label>
                    
                    <select class="form-control" id="periodical_publication_id">
						<option value="0">Nezáleží</option>
						@foreach( $periodical_publications as $pp )
							<option value="{!! $pp->id !!}">{!! $pp->name !!}</option>
						@endforeach
					</select>
                </div>
            </div>

			<div class="col-lg-2">
                <div class="mb-3">
                    <label class="mb-2" for="nonperiodical_publication_id">Neperiodikum:</label>
                    
                    <select class="form-control" id="nonperiodical_publication_id">
						<option value="0">Nezáleží</option>
						@foreach( $nonperiodical_publications as $pp )
							<option value="{!! $pp->id !!}">{!! $pp->name !!}</option>
						@endforeach
					</select>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="mb-3">
                    <label class="mb-2" for="transfer_date_from">Dát. prevodu od:</label>
                    
                    <input class="form-control" id="transfer_date_from" type="text">
                </div>
            </div>

            <div class="col-lg-2">
                <div class="mb-3">
                    <label class="mb-2" for="transfer_date_to">Dát. prevodu do:</label>
                    
                    <input class="form-control" id="transfer_date_to" type="text">
                </div>
            </div>

            <div class="col-lg-2">
                <div class="mb-3">
                    <label class="d-block mb-2" for="">&nbsp;</label>
                    
                    <button class="btn btn-primary" id="initPersonTransfersFilter" type="submit">Filtrovať</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="preloader" style="display:none;">
            Prehrabávam zásuvky, moment prosím <img src="{{ asset('assets/images/ajax-loader.gif') }}" width="16" height="11" alt="" class="ajax-loader">
        </div>

        <table class="table" id="personTransferFilterTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Suma</th>
                    <th>Periodikum</th>
                    <th>Neperiodikum</th>
                    <th>Poznámka</th>
                    <th>Dát. prevodu</th>
                    <th></th>
                </tr>
            </thead>

            <tbody id="personTransferFilterTableResults">

            </tbody>
        </table>
    </div> 
</x-app-layout> 