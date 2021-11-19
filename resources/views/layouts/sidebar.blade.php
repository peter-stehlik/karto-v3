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

		<h6 class="sidebar-heading px-2 mt-3 mb-1 text-muted">
			užívateľ
		</h6>

		<ul class="nav flex-column">
			<li class="nav-item">
				<a class="nav-link" href="{{ route('uzivatel.zmenit-heslo') }}">
					{{ Auth::user()->name }}
				</a>
			</li><!-- / .nav-item -->

			<li class="nav-item">
				<a class="nav-link" id="changeAccountingDate" href="javascript:void(0);">
					Účtovný dátum: <br>
					<span id="accountingDatePreview">{{ date('d.m.Y', strtotime(Auth::user()->accounting_date)) }}</span>
				</a>
			</li><!-- / .nav-item -->
		</ul><!-- / .nav -->

		<div id="accountingDateBox" style="display: none;">
			<div class="px-2">
				<label class="mb-2" for="setAccountingDate">Zmeňte <em>(v tvare dd.mm.rrrr)</em>:</label>

				<input class="form-control mb-2" id="accountingDate" type="text" value="{{ date('d.m.Y', strtotime(Auth::user()->accounting_date)) }}">

				<input id="accountingDateUserId" type="hidden" value="{{ Auth::user()->id }}">

				<button class="btn btn-success" id="setAccountingDate" type="button">Uložiť</button>

				<p class="text-success mt-2" id="successChangeAccountingDate" style="display: none;">Účtovný dátum ste úspešne zmenili.</p>
			</div>
		</div>

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