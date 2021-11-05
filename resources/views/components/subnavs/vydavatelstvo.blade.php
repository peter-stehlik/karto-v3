<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link @if( request()->route()->getName() === 'vydavatelstvo.get-nove-cislo' ) active @endif" href="{{ route('vydavatelstvo.get-nove-cislo') }}">
			Nové číslo
		</a>
	</li><!-- / .nav-item -->
	
	<li class="nav-item">
		<a class="nav-link @if( request()->route()->getName() === 'vydavatelstvo.get-zauctovat' ) active @endif" href="{{ route('vydavatelstvo.get-zauctovat') }}">
			Zaúčtovať
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link @if( request()->route()->getName() === 'vydavatelstvo.get-list-filter' ) active @endif" href="{{ route('vydavatelstvo.get-list-filter') }}">
			Zoznam
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link @if( request()->route()->getName() === 'vydavatelstvo.publikacie.index' ) active @endif" href="{{ route('vydavatelstvo.publikacie.index') }}">
			Periodiká (Publikácie)
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link @if( request()->route()->getName() === 'vydavatelstvo.neperiodika.index' ) active @endif" href="{{ route('vydavatelstvo.neperiodika.index') }}">
			Neperiodiká
		</a>
	</li><!-- / .nav-item -->
</ul>