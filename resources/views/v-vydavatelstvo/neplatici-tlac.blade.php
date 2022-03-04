<x-app-layout>
    <h1 class="h3 py-2 border-bottom text-uppercase">
		Tlač neplatičov
	</h1>

	<div class="col-lg-12 p-3 bg-warning">
		<div class="row">
			{!! Form::open(['action' => 'App\Http\Controllers\ListingController@printNeplaticiPdf', 'id' => 'printNeplaticiPdf', 'target' => 'blank']) !!}	
			<div class="col-lg-4 mb-2">
				<button class="btn btn-info" type="submit">Generuj pdf</button>
			</div>
			{!! Form::close() !!}
				
			{!! Form::open(['action' => 'App\Http\Controllers\PrintController@neplatici', 'id' => 'neplatici', 'target' => 'blank']) !!}
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
	</div>
</x-app-layout>