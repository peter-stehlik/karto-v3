<x-app-layout>
	<script src="{{ asset('assets/dist/js/people-filter-subpages.js') }}" defer></script>

    <h1 class="h3 py-2 border-bottom text-uppercase">
		Zlúčenie <a class="btn btn-sm btn-success" onclick="history.back();">Späť</a>
	</h1>

	<script>
		$(document).ready(function(){
			let dobrodinec = "<strong>{{ $person->name1 }}</strong><span class='d-block text-secondary'> {{ $person->organization }}</span>{{ $person->address1 }}<span class='d-block text-secondary'> {{ $person->zip_code }} {{ $person->city }}</span>{{ $person->email }}";
			
			$("#dobrodinec").html(dobrodinec);
		});		
	</script>

	<div class="col-lg-12">
	<div class="row">
			<div class="col-lg-5">
				<div class="p-3 bg-light">
					<h2>Osoba, ktorá ostáva:</h2>

					<div class="d-flex justify-content-between">
						<p class="pr-2 mb-0">{{ $person->name1 }}</p>
						
						<p class="mb-0">{{ $person->address1 }}, {{ $person->zip_code }} {{ $person->city }}</p>
					</div>
				</div>

				{!! Form::open(['action' => 'App\Http\Controllers\FusionController@postFusion', 'id' => 'fusionForm']) !!}
				<div class="p-3">
					<h2>Zlúčená osoba (vymazaná):</h2>

					<div class="d-flex mb-3">
						<input type="hidden" name="fusion_person_id" value="{{ $person->id }}">

						<input type="hidden" name="fused_person_id" id="for_person_id" value="">

						<input class="form-control" id="name1" type="text" name="name1" value="" style="border-top-right-radius: 0; border-bottom-right-radius: 0;" readonly>
						
						<button class="btn btn-sm btn-warning" id="toggleSearch" type="button" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">Hľadať</button>
					</div>

					<button class="btn btn-info" type="submit">Zlúčiť osoby</button>
				</div>
				{!! Form::close() !!}
			</div>

			<div class="col-lg-6 offset-lg-1">
				<div class="bg-warning p-3 mb-4" id="searchBox" style="display: none;">
					<div class="row">
						<div class="col-lg-7">
							<div class="mb-2">
								<label class="pr-2 mb-1" for="search_name">Meno</label>
								
								<div>
									<input class="form-control" id="search_name" type="text" name="search_name"	autocomplete="off">
								</div>
							</div>
						</div>
						
						<div class="col-lg-5">
							<div class="mb-2">
								<label class="pr-2 mb-1" for="search_zip_code">PSČ</label>
								
								<div>
									<input class="form-control" id="search_zip_code" type="text" name="search_zip_code"	autocomplete="off">
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-7">
							<div class="mb-1">
								<label class="pr-2 mb-1" for="search_address">Adresa</label>

								<div>
									<input class="form-control" id="search_address" type="text" name="search_address"	autocomplete="off">
								</div>
							</div>
						</div>
						
						<div class="col-lg-5">
							<div class="mb-1">
								<label class="pr-2 mb-1" for="search_city">Mesto</label>
								
								<div>
									<input class="form-control" id="search_city" type="text" name="search_city"	autocomplete="off">
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="preloader" data-id="income-search" style="display:none;">
					Prehrabávam zásuvky, moment prosím <img src="{{ asset('assets/images/ajax-loader.gif') }}" width="16" height="11" alt="" class="ajax-loader">
				</div>

				<div class="people-search-results" style="display:none;">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>ID</th>
								<th>Meno 1</th>
								<th>Adresa</th>
								<th>Mesto</th>
								<th>PSČ</th>
								<th></th>
							</tr>
						</thead>

						<tbody id="peopleSearchResults">

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){
			$(document).on("click", "#toggleSearch", function(){
				$("#searchBox").fadeToggle();
			});
		});
	</script>
</x-app-layout> 