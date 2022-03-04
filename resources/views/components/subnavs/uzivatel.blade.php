<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link @if( request()->route()->getName() === 'uzivatel.zoznam-prijmov' ) active @endif" href="{{ route('uzivatel.zoznam-prijmov') }}">
			Zoznam príjmov
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link @if( request()->route()->getName() === 'uzivatel.zoznam-prevodov' ) active @endif" href="{{ route('uzivatel.zoznam-prevodov') }}">
			Zoznam prevodov
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item @if( request()->route()->getName() === 'uzivatel.zoznam-oprav' ) active @endif">
		<a class="nav-link" href="{{ route('uzivatel.zoznam-oprav') }}">
			Zoznam opráv
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link @if( request()->route()->getName() === 'uzivatel.zoznam-vydajov' ) active @endif" href="{{ route('uzivatel.zoznam-vydajov') }}">
			Zoznam výdajov
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link" href="#ui-page-no-sidebar">
			Peniaze na ceste
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link @if( request()->route()->getName() === 'uzivatel.zmenit-heslo' ) active @endif" href="{{ route('uzivatel.zmenit-heslo') }}">
			Zmeniť heslo
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link @if( request()->route()->getName() === 'uzivatel.update-accounting-date-get' ) active @endif" href="{{ route('uzivatel.update-accounting-date-get') }}">
			Uzávierka
		</a>
	</li><!-- / .nav-item -->
</ul><!-- / .nav -->