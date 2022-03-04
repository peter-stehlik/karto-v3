<nav class="col-12 pb-4 pl-0 pl-md-2 col-md-3 col-lg-2 bg-light sidebar overflow-auto">
	<div class="position-sticky pt-2">
		<h6 class="sidebar-heading px-2 mt-3 mb-1 text-muted">
			@if( str_starts_with(request()->route()->getName(), 'kartoteka.') )
				Kartotéka
			@elseif( str_starts_with(request()->route()->getName(), 'kancelaria.') )
				Kancelária
			@elseif( str_starts_with(request()->route()->getName(), 'vydatavelstvo.') )
				Vydavateľstvo
			@elseif( str_starts_with(request()->route()->getName(), 'osoba.') )
				Osoba
			@elseif( str_starts_with(request()->route()->getName(), 'dobrodinec.') )
				Dobrodinec
			@elseif( str_starts_with(request()->route()->getName(), 'uzivatel.') )
				Užívateľ
			@endif
		</h6>

		@if( str_starts_with(request()->route()->getName(), 'kartoteka.') )
			@include('components/subnavs/kartoteka')
		@endif

		@if( str_starts_with(request()->route()->getName(), 'vydavatelstvo.') )
			@include('components/subnavs/vydavatelstvo')
		@endif
		
		@if( str_starts_with(request()->route()->getName(), 'osoba.') )
			@include('components/subnavs/osoba')
		@endif

		@if( str_starts_with(request()->route()->getName(), 'dobrodinec.') )
			@include('components/subnavs/dobrodinec')
		@endif

		@if( str_starts_with(request()->route()->getName(), 'kancelaria.') )
			@include('components/subnavs/kancelaria')
		@endif

		@if( str_starts_with(request()->route()->getName(), 'uzivatel.') )
			@include('components/subnavs/uzivatel')
		@endif

		<hr class="mr-2">

		<div class="printRowWrap" style="display: none;">
			<div class="printRowInner p-2 bg-primary">
				<div class="m-0" id="printRow">

				</div>

				<style>
					.printRowInner {
						max-height: 200px;
						border-bottom: 1px solid #fff;
						overflow: auto;
					}
					#printRow p {
						margin-bottom: 0;
					}
				</style>
			</div>
				
			{!! Form::open(['action' => 'App\Http\Controllers\PrintController@printRow', 'target' => '_blank', 'id' => 'printRowForm']) !!}
			<div class="p-2 bg-primary">
				<div class="row">
					<input type="hidden" id="printRowNames" name="names">
					<input type="hidden" id="printRowIds" name="ids">

					<div class="col-sm-6">
						<label class="mb-2" for="columns">Počet stĺpcov</label>
								
						<select class="form-control" id="printRowColumns" name="columns">
							<option value="2">2</option>
							<option value="3">3</option>
						</select>
					</div>
		
					<div class="col-sm-6">
						<label class="mb-2" for="start_position">Zač. pozícia</label>
								
						<input class="form-control" id="printRowStartPosition" name="start_position" type="text" value="1">
					</div>

					<div class="col-sm-12 mt-2">
						<button class="btn btn-danger" id="printRowSubmit" type="submit">Tlačiť</button>
					</div>
				</div>
			</div>
			{!! Form::close() !!}
		</div>

		<hr class="mr-2">

		<h6 class="sidebar-heading px-2 mt-3 mb-1 text-muted">
			užívateľ
		</h6>

		<ul class="nav flex-column">
			<li class="nav-item">
				<a class="nav-link" href="{{ route('uzivatel.zmenit-heslo') }}">
					{{ Auth::user()->name }}
				</a>

				<a class="nav-link text-secondary" href="{{ route('uzivatel.zmenit-tlaciaren') }}">
					<small>tlačiareň:</small> {{ Auth::user()->printer }} <em>(zmeniť)</em>
				</a>
			</li><!-- / .nav-item -->

			<li class="nav-item">
				<a class="nav-link" href="{{ route('uzivatel.update-accounting-date-get') }}">
					Účtovný dátum: <br>
					<span id="accountingDatePreview">{{ date('d.m.Y', strtotime(Auth::user()->accounting_date)) }}</span>
				</a>
			</li><!-- / .nav-item -->
		</ul><!-- / .nav -->

		@if( Route::currentRouteName() == 'kartoteka.prijem-get' )  
			<hr class="mr-2">

			<h6 class="sidebar-heading px-2 mt-3 mb-1 text-muted">
				klávesové skratky
			</h6>

			<dl class="px-2">
				<dt>Alt + L</dt>
				<dd>Listovať, potom použite šípky hore/dole.</dd>		
				<dt>Enter</dt>
				<dd>Vložiť osobu <br> (pri listovaní)</dd>
				<dt>Esc</dt>
				<dd>Zrušiť listovanie</dd>
			</dl>
		@endif
		
		@if( auth()->user()->name === "Peter Stehlík")
			<hr class="mr-2">
		
			<ul class="nav flex-column">
				<li class="nav-item">
					<a class="nav-link @if( request()->route()->getName() == 'x-admin.prenos-dat-zo-starej-kartoteky' ) active @endif" href="{{ route('x-admin.prenos-dat-zo-starej-kartoteky') }}">
						Prenos dát zo starej kartotéky
					</a>
				</li><!-- / .nav-item -->
			</ul><!-- / .nav -->
		@endif
	</div>
</nav><!-- / .sidebar -->