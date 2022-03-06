<x-app-layout>
	<h1 class="h3 py-2 border-bottom text-uppercase">Pridať novú osobu <a class="btn btn-sm btn-success" href="{{ route('osoba.uvod') }}">Filter</a></h1>

	<div class="row">
		{!! Form::open(['action' => 'App\Http\Controllers\PersonController@postNewPerson']) !!}
			<div class="row">
				<div class="col-sm-6">
					<div class="mb-3">
						<label for="category_id">Kategória</label>
						
						<select name="category_id" id="inc_category_id" class="form-control">
							@foreach( $categories as $cat )
								<option value="{!! $cat->id !!}">{!! $cat->name !!}</option>
							@endforeach
						</select>
					</div>

					<div class="mb-3">
						<div class="row">
							<div class="col-lg-3">
								<label for="title">Titul</label>
									
								<input type="text" name="title" id="inc_title" class="form-control" maxlength="30">
							</div>

							<div class="col-lg-9">
								<label for="name1">Meno 1</label>
								
								<input type="text" name="name1" id="inc_name1" class="form-control name1a" maxlength="30">
							</div>
						</div>
					</div>
					
					<div class="mb-3">
						<div class="row">
							<div class="col-lg-12">
								<label for="name2">Meno 2</label>
								
								<input type="text" name="name2" id="inc_name2" class="form-control name1a" maxlength="30">
							</div>
						</div>
					</div>

					<div class="mb-3">
						<div class="row">
							<div class="col-lg-6">
								<label for="address1">Adresa 1</label>
								
								<input type="text" name="address1" id="inc_address1" class="form-control" maxlength="30">
							</div>

							<div class="col-lg-6">
								<label for="address2">Adresa 2</label>
								
								<input type="text" name="address2" id="inc_address2" class="form-control" maxlength="30">
							</div>
						</div>
					</div>

					<div class="mb-3">
						<div class="row">
							<div class="col-lg-6">
								<label for="organization">Organizácia</label>
								
								<input type="text" name="organization" id="inc_organization" class="form-control" maxlength="30">
							</div>

							<div class="col-lg-6">
								<label for="zip_code">PSČ</label>
								
								<input type="text" name="zip_code" id="inc_zip_code" class="form-control" maxlength="10">
							</div>
						</div>
					</div>

					<div class="mb-3">
						<div class="row">
							<div class="col-lg-6">
								<label for="city">Mesto</label>
								
								<input type="text" name="city" id="inc_city" class="form-control" maxlength="40">
							</div>

							<div class="col-lg-6">
								<label for="state">Štát</label>
								
								<input type="text" name="state" id="inc_state" class="form-control" maxlength="20">
							</div>
						</div>
					</div>

					<div class="mb-3">
						<label for="email">Email</label>
						
						<input type="email" name="email" id="inc_email" class="form-control" maxlength="70">
					</div>

					<div class="mb-3">
						<label for="note">Poznámka <em>(max. 255 znakov)</em></label>
						
						<textarea name="note" id="inc_note" class="form-control" maxlength="255"></textarea>
					</div>

					<div class="mb-3">
						<label for="tags">Štítky <em>(viac štítkov označíte Ctrl + klik)</em></label>
						
						<select name="tags[]" id="inc_tags" class="form-control" multiple>
							<option value="0" selected>Vyberte</option>
							@foreach( $tags as $tag )
							<option value="{!! $tag->id !!}">{!! $tag->name !!}</option>
							@endforeach
						</select>
					</div>

					<div class="">
						<button type="submit" class="btn btn-lg btn-success">vytvoriť</button>
					</div>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
</x-app-layout>