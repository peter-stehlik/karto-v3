<?php $dobrodinec_id = request()->segment(2); ?>

<p class="pl-2 mt-3" id="dobrodinec"></p>

<a class="d-flex pl-2" href="{{ route('dobrodinec.bio', $dobrodinec_id) }}">Upraviť osobné údaje</a>

<hr class="mr-2">

<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href="{{ route('osoba.kategorie.index') }}">
			Listová zásielka
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link" href="{{ route('osoba.kategorie.index') }}">
			Zoznam príjmov
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link" href="{{ route('osoba.kategorie.index') }}">
			Zoznam prevodov
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link" href="{{ route('osoba.kategorie.index') }}">
			Zoznam opráv
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link" href="{{ route('osoba.kategorie.index') }}">
			Zoznam výdajov
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link" href="{{ route('dobrodinec.ucty', $dobrodinec_id) }}">
			Účty
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link" href="{{ route('osoba.kategorie.index') }}">
			Zlúčiť
		</a>
	</li><!-- / .nav-item -->
</ul>