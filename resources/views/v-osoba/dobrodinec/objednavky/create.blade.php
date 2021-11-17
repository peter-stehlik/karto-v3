<x-app-layout>
    <h1 class="h3 py-2 border-bottom text-uppercase">
		Objednávky 
		<a class="btn btn-sm btn-warning" href="{{ route('dobrodinec.objednavky.index', [$person->id]) }}">Späť</a>
	</h1>

	<script>
		$(document).ready(function(){
			let dobrodinec = "<strong>{{ $person->name1 }}</strong><span class='d-block text-secondary'> {{ $person->organization }}</span>{{ $person->address1 }}<span class='d-block text-secondary'> {{ $person->zip_code }} {{ $person->city }}</span>{{ $person->email }}";
			
			$("#dobrodinec").html(dobrodinec);
		});		
	</script>

    <div class="row">
        {!! Form::open(['route' => ['dobrodinec.objednavky.store', $person->id]]) !!} 	
			<div class="col-lg-6">
                <input name="person_id" type="hidden" value="{!! $person->id !!}">

                <div class="row">
					<div class="col-lg-12">
						<div class="mb-3">
							<label class="pr-2 mb-1" for="name">Periodikum <sup>*</sup></label>

							<div>
								<select class="form-control" id="periodical_publication_id" name="periodical_publication_id" required>
                                    <option>Vyberte</option>
                                    @foreach( $periodical_publications as $pp )
                                        <option value="{!! $pp->id !!}">{!! $pp->name !!}</option>
                                    @endforeach
                                </select>
							</div>
						</div>
					</div>

					<div class="col-lg-6">
                        <div class="mb-3">
							<label class="pr-2 mb-1" for="count">Počet <sup>*</sup></label>

							<div>
								<input class="form-control" id="count" type="text" name="count"
								 autocomplete="off" required>
							</div>
						</div>
					</div>		
                    
                    <div class="col-lg-6">
                        <div class="mb-3">
							<label class="pr-2 mb-1" for="gratis">Grátis </label>

							<div>
								<select class="form-control" id="gratis" type="text" name="gratis">
                                    <option value="0">nie</option>
                                    <option value="1">áno</option>
                                </select>
							</div>
						</div>
					</div>

					<div class="col-lg-6">
                        <div class="mb-3">
							<label class="pr-2 mb-1" for="valid_from">Platné od</label>

							<div>
								<input class="form-control" id="valid_from" type="text" name="valid_from" value="<?php echo $date = date("d.m.Y"); ?>" autocomplete="off">
							</div>
						</div>
					</div>		
                    
                    <div class="col-lg-6">
                        <div class="mb-3">
							<label class="pr-2 mb-1" for="valid_to">Platné do </label>

							<div>
								<input class="form-control" id="valid_to" type="text" name="valid_to"
								 autocomplete="off">
							</div>
						</div>
					</div>

                    <div class="col-lg-12">
                        <div class="mb-3">
							<label class="pr-2 mb-1" for="note">Poznámka </label>

							<div>
								<textarea class="form-control" id="note" name="note"></textarea>
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