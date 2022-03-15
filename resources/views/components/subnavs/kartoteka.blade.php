<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link @if( request()->route()->getName() === 'kartoteka.prijem-get' ) active @endif" href="{{ route('kartoteka.prijem-get') }}">
			Príjem platby
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link @if( request()->route()->getName() === 'kartoteka.money-xml-import' ) active @endif" href="{{ route('kartoteka.money-xml-import') }}">
			Money XML Import
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link @if( request()->route()->getName() === 'kartoteka.nepotvrdene-prijmy.index' ) active @endif" href="{{ route('kartoteka.nepotvrdene-prijmy.index') }}">
			Zoznam príjmov
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link @if( request()->route()->getName() === 'kartoteka.nepotvrdene-prevody-get' ) active @endif" href="{{ route('kartoteka.nepotvrdene-prevody-get') }}">
			Zoznam prevodov
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link @if( request()->route()->getName() === 'kartoteka.nepotvrdene-opravy-get' ) active @endif" href="{{ route('kartoteka.nepotvrdene-opravy-get') }}">
			Zoznam opráv
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link @if( request()->route()->getName() === 'kartoteka.unconfirmed-incomes-summary-get' ) active @endif" href="{{ route('kartoteka.unconfirmed-incomes-summary-get') }}">
			Zaúčtovať
		</a>
	</li><!-- / .nav-item -->
</ul><!-- / .nav -->