<x-app-layout>
	<script src="{{ asset('assets/dist/js/people-filter-subpages.js') }}" defer></script>

	<h1 class="h3 py-2 border-bottom text-uppercase">Oprava <a class="btn btn-sm btn-success" href="{{ route('kartoteka.nepotvrdene-opravy-get') }}">Späť na opravy</a></h1>

	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-5">
				<div class="p-3 bg-light">
					<h2>Od:</h2>

					<div class="d-flex justify-content-between">
						<p class="pr-2 mb-0">{{ $from_person_name }}</p>
						
						<p class="mb-0">{{ $transfer_name }}</p>
					</div>
				</div>

				{!! Form::open(['action' => 'App\Http\Controllers\CorrectionController@editPost', 'id' => 'correctionForm']) !!}
				<input type="hidden" name="correction_id" value="{!! $correction->id !!}">

				<div class="p-3">
					<h2>Pre:</h2>

					<div class="d-flex mb-3">
						<input type="hidden" name="from_person_id" value="{{ $correction->from_person_id }}">
						<input type="hidden" name="from_periodical_id" value="{{ $correction->from_periodical_id ?? 0 }}">
						<input type="hidden" name="from_nonperiodical_id" value="{{ $correction->from_nonperiodical_id ?? 0 }}">


						<input type="hidden" name="for_person_id" id="for_person_id" value="{{ $correction->for_person_id }}">

						<input class="form-control" id="name1" type="text" name="name1" value="{{ $for_person_name }}" style="border-top-right-radius: 0; border-bottom-right-radius: 0;" readonly>
						
						<button class="btn btn-sm btn-warning" id="toggleSearch" type="button" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">Hľadať</button>
					</div>

					<div class="row">
						<div class="col-lg-6">
							<div class="mb-3">
								<label class="pr-2 mb-1" for="for_periodical_id">Periodikum</label>

								<div class="">
									<select name="for_periodical_id" id="for_periodical_id" class="form-control">
										<option value="">Vyberte</option>
										
										@foreach( $periodical_publications as $item )
											<option value="{!! $item->id !!}" @if( $correction->from_periodical_id === $item->id ) selected @endif>{!! $item->name !!}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>

						<div class="col-lg-6">
							<div class="mb-3">
								<label class="pr-2 mb-1" for="for_nonperiodical_id">Neperiodikum</label>

								<div class="">
									<select name="for_nonperiodical_id" id="for_nonperiodical_id" class="form-control">
										<option value="">Vyberte</option>

										@foreach( $nonperiodical_publications as $item )
											<option value="{!! $item->id !!}" @if( $correction->from_nonperiodical_id === $item->id ) selected @endif>{!! $item->name !!}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-6">
							<div class="mb-3">
								<label class="pr-2 mb-1" for="sum">Suma</label>
			
								<input class="form-control" name="sum" id="sum" type="text" value='{!! number_format($correction->sum, 2, ",", " ") !!}'>
							</div>
						</div>

						<div class="col-lg-6">
							<div class="mb-3">
								<label class="pr-2 mb-1" for="correction_date">Dátum opravy</label>

								<input class="form-control" name="correction_date" id="correction_date" type="text" value="{!! date('j.n.Y', strtotime($correction->correction_date)) !!}">
							</div>
						</div>
					</div>

					<div class="mb-3">
						<label for="note">Poznámka</label>

						<textarea class="form-control" name="note" id="note">{!! $correction->note !!}</textarea>
					</div>

					<button class="btn btn-info" type="submit">Uložiť zmeny</button>
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