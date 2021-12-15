<x-app-layout>
    <h1 class="h3 py-2 border-bottom text-uppercase">
		Tlač neplatičov
	</h1>

	<div class="col-lg-12 p-3 bg-warning">
		<div class="row">
			{!! Form::open(['action' => 'App\Http\Controllers\ListingController@printNeplaticiPdf', 'id' => 'printNeplaticiPdf', 'target' => 'blank']) !!}	
			<!-- <div class="col-lg-4">
				<label class="mb-2" for="date_from">Periodikum:</label>
				
				<select class="form-control" id="periodical_publication_id" name="periodical_publication_id">
					<option value="0">Nezáleží (pre všetky)</option>
					@foreach( $periodical_publications as $pp )
					<option value="{{ $pp->id }}">{{ $pp->name }}</option>
					@endforeach
				</select>
			</div> 
			
			<div class="col-lg-12"></div> -->

			<div class="col-lg-4 mb-2">
				<button class="btn btn-info" type="submit">Generuj pdf</button>
			</div>
			{!! Form::close() !!}
				
			{!! Form::open(['action' => 'App\Http\Controllers\PrintController@neplatici', 'id' => 'neplatici', 'target' => 'blank']) !!}	
				<button class="btn btn-danger" type="submit">Tlač adresiek</button>
			{!! Form::close() !!}
		</div>
	</div>
</x-app-layout>