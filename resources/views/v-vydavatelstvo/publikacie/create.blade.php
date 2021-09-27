<x-app-layout>
	<h1 class="h3 py-2 border-bottom text-uppercase">Vytvoriť novú publikáciu <a class="btn btn-sm btn-success" href="{{ route('vydavatelstvo.publikacie.index') }}">Späť</a></h1>

	<div class="row">
		{!! Form::open(['action' => 'App\Http\Controllers\PeriodicalController@store']) !!}	
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

				<div class="row">
					<div class="col-lg-4">
						<div class="mb-3">
							<label class="pr-2 mb-1" for="price">Cena</label>

							<div class="">
								<input class="form-control" id="price" type="number" name="price" autocomplete="off" step=".01">
							</div>
						</div>
					</div>

					<div class="col-lg-4">
						<div class="mb-3">
							<label class="pr-2 mb-1" for="label_date">Štítky</label>

							<div class="">
								<input class="form-control" id="label_date" type="text" name="label_date" autocomplete="off">
							</div>
						</div>
					</div>

					<div class="col-lg-4">
						<div class="mb-3">
							<label class="pr-2 mb-1" for="current_number">Aktuálne číslo</label>

							<div class="">
								<input class="form-control" id="current_number" type="text" name="current_number" autocomplete="off">
							</div>
						</div>
					</div>
				</div>


				<div class="mb-3">
					<label class="pr-2 mb-1" for="note">Poznámka</label>

					<div class="">
						<textarea class="form-control" id="note" name="note"></textarea>
					</div>
				</div>

				<div class="mb-3">
					<button class="btn btn-primary" type="submit">Uložiť</button>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
</x-app-layout>