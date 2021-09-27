<x-app-layout>
	<h1 class="h3 py-2 border-bottom text-uppercase">Vytvoriť nové neperiodikum <a class="btn btn-sm btn-success" href="{{ route('vydavatelstvo.neperiodika.index') }}">Späť</a></h1>

	<div class="row">
		{!! Form::open(['action' => 'App\Http\Controllers\NonperiodicalController@store']) !!}	
			<div class="col-lg-5">
				<div class="row">
					<div class="col-lg-8">
						<div class="mb-3">
							<label class="pr-2 mb-1" for="name">Názov <sup>*</sup></label>

							<div>
								<input class="form-control" id="name" type="text" name="name"
								 autocomplete="off" autofocus required>
							</div>
						</div>
					</div>

					<div class="col-lg-4">
						<div class="mb-3">
							<label class="pr-2 mb-1" for="abbreviation">Skratka</label>

							<div>
								<input class="form-control" id="abbreviation" type="text" name="abbreviation"
									autocomplete="off">
							</div>
						</div>
					</div>
				</div>

				<div class="mb-3">
					<button class="btn btn-primary" type="submit">Uložiť</button>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
</x-app-layout>