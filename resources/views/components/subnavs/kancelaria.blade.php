<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link @if( request()->route()->getName() == 'kancelaria.bankove-ucty.index' ) active @endif" href="{{ route('kancelaria.bankove-ucty.index') }}">
			Bankové účty
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link @if( request()->route()->getName() == 'kancelaria.denny-mesacny-vypis' ) active @endif" href="{{ route('kancelaria.denny-mesacny-vypis') }}">
			Denný (mesačný) výpis
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link @if( request()->route()->getName() == 'kancelaria.denne-mesacne-opravy' ) active @endif" href="{{ route('kancelaria.denne-mesacne-opravy') }}">
			Denné (mesačné) opravy
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link @if( request()->route()->getName() == 'kancelaria.tlac-pre-ucel' ) active @endif" href="{{ route('kancelaria.tlac-pre-ucel') }}">
			Tlač pre účel
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link @if( request()->route()->getName() == 'kancelaria.selekcie' ) active @endif" href="{{ route('kancelaria.selekcie') }}">
			Selekcie
		</a>
	</li><!-- / .nav-item -->
</ul>