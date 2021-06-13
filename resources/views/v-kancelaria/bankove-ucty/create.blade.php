<x-app-layout>
	<h1 class="h3 py-2 border-bottom text-uppercase">Vytvoriť nový bankový účet <a class="btn btn-sm btn-success" href="{{ route('kancelaria.bankove-ucty.index') }}">Späť</a></h1>

	<div class="row">
		{!! Form::open(['action' => 'App\Http\Controllers\BankAccountController@store']) !!}	
			<div class="col-lg-5">
				<div class="row">
					<div class="col-lg-8">
						<div class="mb-3">
							<label class="pr-2 mb-1" for="bank_name">Názov banky <sup>*</sup></label>

							<div>
								<input class="form-control" id="bank_name" type="text" name="bank_name"
								 autocomplete="off" required>
							</div>
						</div>
					</div>

					<div class="col-lg-4">
						<div class="mb-3">
							<label class="pr-2 mb-1" for="abbreviation">Skratka <sup>*</sup></label>

							<div>
								<input class="form-control" id="abbreviation" type="text" name="abbreviation"
									autocomplete="off" required>
							</div>
						</div>
					</div>
				</div>

				<div class="mb-3">
					<label class="pr-2 mb-1" for="number">Číslo účtu <sup>*</sup></label>

					<div class="">
						<input class="form-control" id="number" type="text"
							name="number" autocomplete="off" required>
					</div>
				</div>

				<div class="mb-3">
					<button class="btn btn-primary" type="submit">Vytvoriť</button>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
</x-app-layout>