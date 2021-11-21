<x-app-layout>
	<h1 class="h3 py-2 border-bottom text-uppercase">Prenos dát zo starej kartotéky</h1>

	<div class="col-lg-12">
		<p>Prenos dát musí ísť postupne:</p>

		<ol>
			<li>prerekvizity - správcovia, bankové účty, kategórie, (ne)periodiká</li>
			<li>dobrodinci <strong><small>(big data)</small></strong></li>
			<li>kredity dobrodincov <strong><small>(big data)</small></strong></li>
			<li>príjmy <strong><small>(big data)</small></strong></li>
			<li>prevody <strong><small>(big data)</small></strong></li>
			<li>objednávky periodík <em>(odtiaľto už na poradí nezáleží)</em></li>
			<li>opravy</li>
			<li>výdaje <strong><small>(big data)</small></strong></li>
		</ol>

		<hr>

		<div class="row">
			<div class="col-lg-3">
				{!! Form::open(['action' => 'App\Http\Controllers\XadminController@postMigrateBasic', 'id' => 'migrateBasic']) !!}
					<button class="btn btn-warning" type="submit">1.fáza: správcovia, bankové účty, kategórie, (ne)periodiká</button>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</x-app-layout>