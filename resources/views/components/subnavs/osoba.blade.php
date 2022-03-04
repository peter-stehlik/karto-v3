<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link @if( request()->route()->getName() === 'osoba.get-new-person' ) active @endif" href="{{ route('osoba.get-new-person') }}">
			Pridať novú osobu
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link @if( request()->route()->getName() === 'osoba.kategorie.index' ) active @endif" href="{{ route('osoba.kategorie.index') }}">
			Kategórie
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link @if( request()->route()->getName() === 'osoba.stitky.index' ) active @endif" href="{{ route('osoba.stitky.index') }}">
			Štítky
		</a>
	</li><!-- / .nav-item -->
</ul>