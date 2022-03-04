<x-app-layout>
	<h1 class="h3 py-2 border-bottom text-uppercase">Nové číslo</h1>

	<p>Vyberte periodikum.</p>

	<div class="row">
		<div class="col-sm-6">
			{!! Form::open(['action' => 'App\Http\Controllers\ListingController@postNoveCislo']) !!}
			<div class="accordion" id="accordion">
				@foreach( $periodical_publications as $pp )
					<div class="accordion-item">
						<h2 class="accordion-header" id="headingTwo">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{!! $pp->id !!}" aria-expanded="false" aria-controls="collapse-{!! $pp->id !!}">
							{!! $pp->name !!}
						</button>
						</h2>

						<div id="collapse-{!! $pp->id !!}" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordion">
							<div class="accordion-body">
								<h2>{!! $pp->name !!}</h2>

								<p>
									Číslo: {!! $pp->current_number !!} <br/>
									Ročník: {!! $pp->current_volume !!} <br/>
									Dátum publikácie: {!! date("d.m.Y", strtotime($pp->label_date)) !!}
								</p>

								<p>Chcete zaevidovať nové číslo?</p>

								<button class="btn btn-success" type="submit" value="{!! $pp->id !!}" name="pp_id">Áno</button>
								<a class="btn btn-secondary" href="{{ route('vydavatelstvo.uvod') }}">Nie</a>
							</div>
						</div>
					</div>
				@endforeach
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</x-app-layout>
