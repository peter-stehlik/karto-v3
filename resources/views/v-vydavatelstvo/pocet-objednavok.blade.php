<x-app-layout>
    <script src="{{ asset('assets/dist/js/count-obj-filter.js') }}" defer></script>

    <h1 class="h3 py-2 border-bottom text-uppercase">Počet objednávok</h1>

	<div class="row">
		<div class="col-lg-5">
			<p><em>Počet objednávok za posledných 12 mesiacov.</em></p>

			<div class="accordion" id="accordionExample">
				<div class="accordion-item">
					<h2 class="accordion-header" id="headingOne">
						<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
							Malý kalendár
						</button>
					</h2>

					<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
						<div class="accordion-body">
							<h2>Malý kalendár</h2>

							<ul>
								@foreach( $maly_kalendar as $item )
									<li>
										<span class="inline-block mr-3">{!! date("m, Y", strtotime($item->label_date)) !!}</span>
										 {!! $item->total_count !!} ks
									</li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>

				<div class="accordion-item">
					<h2 class="accordion-header" id="headingTwo">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
							Kalendár nástenný
						</button>
					</h2>

					<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
						<div class="accordion-body">
							<h2>Kalendár nástenný</h2>

							<ul>
								@foreach( $kalendar_nastenny as $item )
									<li>
										<span class="inline-block mr-3">{!! date("m, Y", strtotime($item->label_date)) !!}</span>
										 {!! $item->total_count !!} ks
									</li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>

				<div class="accordion-item">
					<h2 class="accordion-header" id="headingThree">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
							Kalendár knižný
						</button>
					</h2>

					<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
						<div class="accordion-body">
							<h2>Kalendár knižný</h2>

							<ul>
								@foreach( $kalendar_knizny as $item )
									<li>
										<span class="inline-block mr-3">{!! date("m, Y", strtotime($item->label_date)) !!}</span>
										{!! $item->total_count !!} ks
									</li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>

				<div class="accordion-item">
					<h2 class="accordion-header" id="heading4">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
							Hlasy
						</button>
					</h2>

					<div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample">
						<div class="accordion-body">
							<h2>Hlasy</h2>

							<ul>
								@foreach( $hlasy as $item )
									<li>
										<span class="inline-block mr-3">{!! date("m, Y", strtotime($item->label_date)) !!}</span>
										{!! $item->total_count !!} ks
									</li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-6 offset-lg-1">
			offset
		</div>
	</div>
</x-app-layout>