<x-app-layout>
	<h1 class="h3 py-2 border-bottom text-uppercase">Upravte <a class="btn btn-sm btn-success" href="{{ route('vydavatelstvo.publikacie.index') }}">Späť</a></h1>

	<div class="row">
		{!! Form::open(['action' => ['App\Http\Controllers\PeriodicalController@update', $periodical->id], 'method' => 'PUT']) !!}	
			<div class="col-lg-5">
				<div class="row">
					<div class="col-lg-8">
						<div class="mb-3">
							<label class="pr-2 mb-1" for="name">Názov <sup>*</sup></label>

							<div>
								<input class="form-control" id="name" type="text" name="name"
								 autocomplete="off" value="{{ $periodical->name }}" required>
							</div>
						</div>
					</div>

					<div class="col-lg-4">
						<div class="mb-3">
							<label class="pr-2 mb-1" for="abbreviation">Skratka </label>

							<div>
								<input class="form-control" id="abbreviation" type="text" name="abbreviation"
									autocomplete="off" value="{{ $periodical->abbreviation }}">
							</div>
						</div>
					</div>
				</div>

				<div class="mb-3">
					<label class="pr-2 mb-1" for="price">Cena</label>

					<div class="">
						<input class="form-control" id="price" type="number" name="price" autocomplete="off" value="{{ number_format($periodical->price, 2) }}" step=".01">
					</div>
				</div>

				<div class="mb-3">
					<label class="pr-2 mb-1" for="note">Poznámka</label>

					<div class="">
						<textarea class="form-control" id="note" name="note">{{ $periodical->note }}</textarea>
					</div>
				</div>

				<div class="mb-3">
					<button class="btn btn-primary" type="submit">Uložiť</button>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
</x-app-layout>