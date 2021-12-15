<x-app-layout>
	<h1 class="h3 py-2 border-bottom text-uppercase">Prenos dát zo starej kartotéky</h1>

	<div class="col-lg-12">
		<ol>
			<li>Stiahnuť zo servera DB dump.</li>
			<li>Ručne nahrať z SQL súboru dáta jednotlivých tabuliek pomocou SQL príkazov.</li>
			<li>Nastaviť, aký <strong> účtovný dátum </strong> sa im má preniesť.</li>
			<li>Spúšťať postupne skripty na prenos.</li>
			<li>Pomocou HeidiSQL preniesť novú DB na nový hostin.</li>
		</ol>

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
					<button class="btn btn-warning" type="submit">1.: správcovia, bankové účty, kategórie, (ne)periodiká</button>
				{!! Form::close() !!}
			</div>
			
			<div class="col-lg-3">
				{!! Form::open(['action' => 'App\Http\Controllers\XadminController@postMigratePeople', 'id' => 'migratePeople']) !!}
					<button class="btn btn-info" type="submit">2.: dobrodinci - osobné údaje, kategória</button>
				{!! Form::close() !!}
			</div>

			<div class="col-lg-3">
				{!! Form::open(['action' => 'App\Http\Controllers\XadminController@postMigrateCredits', 'id' => 'migrateCredits']) !!}
					<button class="btn btn-primary" type="submit">3.: kredity - periodiká, neperiodiká</button>
				{!! Form::close() !!}
			</div>

			<div class="col-lg-3">
				{!! Form::open(['action' => 'App\Http\Controllers\XadminController@postMigrateIncomes', 'id' => 'migrateIncomes']) !!}
					<button class="btn btn-secondary" type="submit">4.: príjmy dobrodincov - okrem opráv</button>
				{!! Form::close() !!}
			</div>

			<div class="col-lg-3 mt-3">
				{!! Form::open(['action' => 'App\Http\Controllers\XadminController@postMigrateTransfers', 'id' => 'migrateTransfers']) !!}
					<button class="btn btn-success" type="submit">5.: jednotlivé prevody k príjmom</button>
				{!! Form::close() !!}
			</div>

			<div class="col-lg-3 mt-3">
				{!! Form::open(['action' => 'App\Http\Controllers\XadminController@postMigratePeriodicalOrders', 'id' => 'migratePeriodicalOrders']) !!}
					<button class="btn btn-dark" type="submit">6.: periodické objednávky dobrodincov</button>
				{!! Form::close() !!}
			</div>

			<div class="col-lg-3 mt-3">
				{!! Form::open(['action' => 'App\Http\Controllers\XadminController@postMigrateCorrections', 'id' => 'migrateCorrections']) !!}
					<button class="btn btn-danger" type="submit">7.: opravy periodík aj neperiodík</button>
				{!! Form::close() !!}
			</div>

			<div class="col-lg-3 mt-3">
				{!! Form::open(['action' => 'App\Http\Controllers\XadminController@postMigrateOutcomes', 'id' => 'migrateOutcomes']) !!}
					<button class="btn btn-notice text-dark" type="submit">8.: všetky výdajky dobrodincov</button>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</x-app-layout>