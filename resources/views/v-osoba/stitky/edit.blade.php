<x-app-layout>
	<h1 class="h3 py-2 border-bottom text-uppercase">Upravte <a class="btn btn-sm btn-success" href="{{ route('osoba.stitky.index') }}">Späť</a></h1>

	<div class="row">
		{!! Form::open(['action' => ['App\Http\Controllers\TagController@update', $tag->id], 'method' => 'PUT']) !!}	
			<div class="col-lg-5">
				<div class="row">
					<div class="col-lg-8">
						<div class="mb-3">
							<label class="pr-2 mb-1" for="name">Názov <sup>*</sup></label>

							<div>
								<input class="form-control" id="name" type="text" name="name"
								 autocomplete="off" value="{{ $tag->name }}" required>
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