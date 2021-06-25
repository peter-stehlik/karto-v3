<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href="{{ route('kartoteka.prijem-get') }}">
			Príjem platby
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link" href="{{ route('kartoteka.nepotvrdene-prijmy.index') }}">
			Zoznam príjmov
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link" href="{{ route('kartoteka.nepotvrdene-prevody-get') }}">
			Zoznam prevodov
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link" href="#ui-page-no-sidebar">
			Zoznam opráv
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link" href="{{ route('kartoteka.unconfirmed-incomes-summary-get') }}">
			Zaúčtovať
		</a>
	</li><!-- / .nav-item -->
</ul><!-- / .nav -->