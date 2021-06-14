<header class="navbar navbar-dark navbar-expand sticky-top bg-dark flex-md-nowrap p-0 shadow justify-content-start">
	<a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3 text-primary" href="{{ route('kartoteka.uvod') }}">
		SVD kancelária
	</a>

	<nav class="w-100 px-md-2 pt-0 pb-0">
		<div class="container-fluid d-flex align-items-center justify-content-between pl-md-1 pr-md-2">
			<ul class="navbar-nav mb-0">
				<li class="nav-item">
					<a class="nav-link @if( str_starts_with(request()->route()->getName(), 'kartoteka.') ) active @endif" href="{{ route('kartoteka.uvod') }}">Kartotéka</a>

					@include('components/subnavs/kartoteka')
				</li><!-- / .nav-item -->

				<li class="nav-item">
					<a class="nav-link @if( str_starts_with(request()->route()->getName(), 'vydavatelstvo.') ) active @endif" href="{{ route('vydavatelstvo.uvod') }}">Vydavateľstvo</a>

					@include('components/subnavs/vydavatelstvo')
				</li><!-- / .nav-item -->

				<li class="nav-item">
					<a class="nav-link" href="components.html">Osoba</a>
				</li><!-- / .nav-item -->

				<li class="nav-item">
					<a class="nav-link @if( str_starts_with(request()->route()->getName(), 'kancelaria.') ) active @endif" href="{{ route('kancelaria.uvod') }}">Kancelária</a>

					@include('components/subnavs/kancelaria')
				</li><!-- / .nav-item -->

				<li class="nav-item">
					<a class="nav-link @if( str_starts_with(request()->route()->getName(), 'uzivatel.') ) active @endif" href="{{ route('uzivatel.uvod') }}">Užívateľ</a>

					@include('components/subnavs/uzivatel')
				</li><!-- / .nav-item -->
			</ul><!-- / .navbar-nav -->
			
			<ul class="navbar-nav">
				<li class="nav-item">
					<form method="POST" action="{{ route('logout') }}">
						@csrf

						<a class="nav-link" href="route('logout')"
								onclick="event.preventDefault();
											this.closest('form').submit();">
							Odhlásiť sa
						</a>
					</form>
				</li>
			</ul>
		</div><!-- / .container-fluid -->
	</nav><!-- / .navbar -->
</header>