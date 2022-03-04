<x-app-layout>
	<h1 class="h3 py-2 border-bottom text-uppercase">Zmeniť tlačiareň</h1>

	<div class="row">
		<div class="col-lg-5">
			<form method="POST" action="{{ route('uzivatel.zmenit-tlaciaren-post') }}">
				@csrf

				<div class="d-flex align-items-center mb-3">
					<label class="pr-2" for="printer">Vyberte, na ktorej tlačiarni chcete tlačiť <sup>*</sup></label>

					<div class="flex-fill">
						<select class="form-control" id="printer" name="printer"  required>
                            <option>Vyberte</option>
                            <option value="EPSON LX-350" @if( Auth::user()->printer == "EPSON LX-350" ) selected @endif>EPSON LX-350</option>
                            <option value="EPSON LX-300II+" @if( Auth::user()->printer == "EPSON LX-300II+" ) selected @endif>EPSON LX-300II+</option>
                        </select>
					</div>
				</div>

				<div class="mb-3 d-flex justify-content-end">
					<button class="btn btn-primary" type="submit">Potvrďte zmenu tlačiarne</button>
				</div>
			</form>
		</div>
	</div>
</x-app-layout>