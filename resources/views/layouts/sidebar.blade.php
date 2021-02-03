<nav class="col-12 pb-4 pl-0 pl-md-2 col-md-3 col-lg-2 bg-light sidebar overflow-auto">
	<div class="position-sticky pt-2">
		<h6 class="sidebar-heading px-2 mt-3 mb-1 text-muted">
			@if( str_starts_with(request()->route()->getName(), 'kartoteka.') )
				Kartotéka
			@elseif( str_starts_with(request()->route()->getName(), 'uzivatel.') )
				Užívateľ
			@endif
		</h6>

		@if( str_starts_with(request()->route()->getName(), 'kartoteka.') )
			@include('components/subnavs/kartoteka')
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
				<a class="nav-link" href="#ui-homepage">
					{{ Auth::user()->name }}
				</a>
			</li><!-- / .nav-item -->

			<li class="nav-item">
				<a class="nav-link" href="#ui-homepage">
					Účtovný dátum: <br>
					13.2.2021
				</a>
			</li><!-- / .nav-item -->
		</ul><!-- / .nav -->
	</div>
</nav><!-- / .sidebar -->