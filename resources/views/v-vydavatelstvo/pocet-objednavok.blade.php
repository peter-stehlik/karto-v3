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
			<p><em>Výber ľubovoľného mesiaca.</em></p>

			<div class="p-3 bg-warning">
				<div class="row">
					<div class="col-lg-4">
						<div class="mb-3">
							<label class="mb-2" for="periodical_publication_id">Periodikum:</label>
							
							<select class="form-control" id="periodical_publication_id" required>
								<option>Vyberte</option>
								@foreach( $periodical_publications as $pp )	
									<option value="{!! $pp->id !!}">{!! $pp->name !!}</option>	
								@endforeach	
							</select>
						</div>
					</div>	

					<div class="col-lg-3">
						<div class="mb-3">
							<label class="mb-2" for="month">Mesiac:</label>
							
							<select class="form-control" id="month" required>
								<option>Vyberte</option>	
								<option value="01">Január</option>	
								<option value="02">Február</option>	
								<option value="03">Marec</option>	
								<option value="04">Apríl</option>	
								<option value="05">Máj</option>	
								<option value="06">Jún</option>	
								<option value="07">Júl</option>	
								<option value="08">August</option>	
								<option value="09">September</option>	
								<option value="10">Október</option>	
								<option value="11">November</option>	
								<option value="12">December</option>	
							</select>
						</div>
					</div>

					<div class="col-lg-3">
						<div class="mb-3">
							<label class="mb-2" for="year">Rok:</label>
							
							<input class="form-control" type="number" id="year" required>
						</div>
					</div>

					<div class="col-lg-12">
						<div class="mb-3">							
							<button class="btn btn-info" type="submit" id="showCountFilter">Zobraz počet</button>
						</div>
					</div>
				</div>
			</div>

			<div class="preloader" style="display:none;">
				Prehrabávam zásuvky, moment prosím <img src="{{ asset('assets/images/ajax-loader.gif') }}" width="16" height="11" alt="" class="ajax-loader">
			</div>

			<p class="js-show-count-wrap mt-4" style="display: none;">Počet objednávok za vybraný mesiac: <strong id="showCount"></strong></p>
		</div>
	</div>
</x-app-layout>