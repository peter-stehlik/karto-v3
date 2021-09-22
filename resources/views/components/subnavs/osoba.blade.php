<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link @if( request()->route()->getName() === 'osoba.kategorie.index' ) active @endif" href="{{ route('osoba.kategorie.index') }}">
			Kategórie
		</a>
	</li><!-- / .nav-item -->
</ul>