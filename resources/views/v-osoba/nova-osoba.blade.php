<x-app-layout>
	<h1 class="h3 py-2 border-bottom text-uppercase">Pridať novú osobu <a class="btn btn-sm btn-success" href="{{ route('osoba.filter') }}">Filter</a></h1>

	<div class="row">
		{!! Form::open(['action' => 'App\Http\Controllers\PersonController@postNewPerson']) !!}	

		{!! Form::close() !!}
	</div>
</x-app-layout>