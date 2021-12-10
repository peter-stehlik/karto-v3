<x-app-layout>
    <h1 class="h3 py-2 border-bottom text-uppercase">
		Osobné údaje
	</h1>

	<script>
		$(document).ready(function(){
			let dobrodinec = "<strong>{{ $person->name1 }}</strong><span class='d-block text-secondary'> {{ $person->organization }}</span>{{ $person->address1 }}<span class='d-block text-secondary'> {{ $person->zip_code }} {{ $person->city }}</span>{{ $person->email }}";
			
			$("#dobrodinec").html(dobrodinec);
		});		
	</script>

	<div class="col-lg-12">
		{!! Form::open(['action' => 'App\Http\Controllers\PersonController@postBio', 'id' => 'bioForm']) !!}
			<input type="hidden" name="person_id" value="{!! $person->id !!}">

			<div class="col-lg-5">
				<div class="mb-3">
					<label for="category_id">Kategória</label>
					
					<select name="category_id" id="inc_category_id" class="form-control">
						@foreach( $categories as $cat )
							<option value="{!! $cat->id !!}" @if( $cat->id == $person->category_id ) selected="selected" @endif>{!! $cat->name !!}</option>
						@endforeach
					</select>
				</div>

				<div class="mb-3">
					<div class="row">
						<div class="col-lg-3">
							<label for="title">Titul</label>
								
							<input type="text" name="title" id="inc_title" class="form-control" value="{!! $person->title !!}">
						</div>

						<div class="col-lg-9">
							<label for="name1">Meno 1</label>
							
							<input type="text" name="name1" id="inc_name1" class="form-control" value="{!! $person->name1 !!}">
						</div>
					</div>
				</div>

				<div class="mb-3">
					<div class="row">
						<div class="col-lg-9">
							<label for="name2">Meno 2</label>
							
							<input type="text" name="name2" id="inc_name2" class="form-control" value="{!! $person->name2 !!}">
						</div>
					</div>
				</div>

				<div class="mb-3">
					<div class="row">
						<div class="col-lg-6">
							<label for="address1">Adresa 1</label>
							
							<input type="text" name="address1" id="inc_address1" class="form-control" value="{!! $person->address1 !!}">
						</div>

						<div class="col-lg-6">
							<label for="address2">Adresa 2</label>
							
							<input type="text" name="address2" id="inc_address2" class="form-control" value="{!! $person->address2 !!}">
						</div>
					</div>
				</div>

				<div class="mb-3">
					<div class="row">
						<div class="col-lg-6">
							<label for="organization">Organizácia</label>
							
							<input type="text" name="organization" id="inc_organization" class="form-control" value="{!! $person->organization !!}">
						</div>

						<div class="col-lg-6">
							<label for="zip_code">PSČ</label>
							
							<input type="text" name="zip_code" id="inc_zip_code" class="form-control" value="{!! $person->zip_code !!}">
						</div>
					</div>
				</div>

				<div class="mb-3">
					<div class="row">
						<div class="col-lg-6">
							<label for="city">Mesto</label>
							
							<input type="text" name="city" id="inc_city" class="form-control" value="{!! $person->city !!}">
						</div>

						<div class="col-lg-6">
							<label for="state">Štát</label>
							
							<input type="text" name="state" id="inc_state" class="form-control" value="{!! $person->state !!}">
						</div>
					</div>
				</div>

				<div class="mb-3">
					<label for="email">Email</label>
					
					<input type="email" name="email" id="inc_email" class="form-control" value="{!! $person->email !!}">
				</div>

				<div class="mb-3">
					<label for="note">Poznámka <em>(max. 255 znakov)</em></label>
					
					<textarea name="note" id="inc_note" class="form-control" maxlength="255">{!! $person->note !!}</textarea>
				</div>

				<button type="submit" class="btn btn-lg btn-success mr-2">Uložiť zmeny</button>

				<a href="/dobrodinec/{!! $person->id !!}/ucty"> Späť na Účty</a>
			</div>
			{!! Form::close() !!}
	</div>
</x-app-layout> 