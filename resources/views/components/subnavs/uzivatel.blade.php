<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href="#ui-page-right-sidebar">
			Zoznam príjmov
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link" href="#ui-page-no-sidebar">
			Zoznam prevodov
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link" href="#ui-page-no-sidebar">
			Zoznam opráv
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link" href="#ui-page-no-sidebar">
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
		<a class="nav-link" href="#ui-page-no-sidebar">
			Uzávierka
		</a>
	</li><!-- / .nav-item -->
</ul><!-- / .nav -->