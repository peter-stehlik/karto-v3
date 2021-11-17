<x-app-layout>
    <h1 class="h3 py-2 border-bottom text-uppercase">
		Účty
	</h1>

	<script>
		$(document).ready(function(){
			let dobrodinec = "<strong>{{ $person->name1 }}</strong><span class='d-block text-secondary'> {{ $person->organization }}</span>{{ $person->address1 }}<span class='d-block text-secondary'> {{ $person->zip_code }} {{ $person->city }}</span>{{ $person->email }}";
			
			$("#dobrodinec").html(dobrodinec);
		});		
	</script>

	<div class="col-lg-12">
		@if( $peniaze_na_ceste )
			<p class="d-flex align-items-center mb-3">
				<span class="pt-1">Peniaze na ceste: <strong> {{ number_format($peniaze_na_ceste, 2, ",", " ") }} &euro;</strong></span>
			</p>
		@endif

		@foreach( $periodical_orders as $po )
			<p class="d-flex align-items-center mb-1">
				<span class="pt-1 @if( $po->credit < 0 ) text-danger @endif">{{ $po->name }}: {{ number_format($po->credit, 2, ",", " ") }} &euro;</span>
				
				<a class="d-inline-block ml-1" href="{{ route('dobrodinec.opravacezhviezdicku', [$person->id]) }}?periodical_publication_id={{ $po->id }}">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="yellow" stroke="black" class="bi bi-star-fill" viewBox="0 0 16 16">
						<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
					</svg>
				</a>
			</p>
		@endforeach

		@foreach( $nonperiodical_credits as $po )
			<p class="d-flex align-items-center mb-1">
				<span class="pt-1 @if( $po->credit < 0 ) text-danger @endif">{{ $po->name }}: {{ number_format($po->credit, 2, ",", " ") }} &euro;</span>
				
				<a class="d-inline-block ml-1" href="{{ route('dobrodinec.opravacezhviezdicku', [$person->id]) }}?nonperiodical_publication_id={{ $po->id }}">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="yellow" stroke="black" class="bi bi-star-fill" viewBox="0 0 16 16">
						<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
					</svg>
				</a>
			</p>
		@endforeach
	</div>
</x-app-layout> 