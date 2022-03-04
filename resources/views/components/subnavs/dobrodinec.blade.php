<?php $dobrodinec_id = request()->segment(2); ?>

<p class="pl-2 mt-3" id="dobrodinec"></p>

<a class="d-flex pl-2 text-warning" href="{{ route('dobrodinec.getbio', $dobrodinec_id) }}">Upraviť osobné údaje</a>

<hr class="mr-2">


<script>
	$(document).ready(function(){
		setTimeout(function(){
			let dobrodinecName = $("#dobrodinec strong").first().text();
			
			$(".js-add-to-print-row").attr("data-person-name", dobrodinecName);
		}, 500);
	});		
</script>

<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link js-add-to-print-row" data-person-name="" data-person-id="{{ $dobrodinec_id }}" href="javascript:void(0);">
			Listová adreska
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link @if( request()->route()->getName() == 'dobrodinec.getincomes' ) active @endif" href="{{ route('dobrodinec.getincomes', $dobrodinec_id) }}">
			Zoznam príjmov
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link @if( request()->route()->getName() == 'dobrodinec.gettransfers' ) active @endif" href="{{ route('dobrodinec.gettransfers', $dobrodinec_id) }}">
			Zoznam prevodov
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link @if( request()->route()->getName() == 'dobrodinec.listcorrections' ) active @endif" href="{{ route('dobrodinec.listcorrections', $dobrodinec_id) }}">
			Zoznam opráv
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link @if( request()->route()->getName() == 'dobrodinec.dobrodinecvydavky' ) active @endif" href="{{ route('dobrodinec.dobrodinecvydavky', $dobrodinec_id) }}">
			Zoznam výdajov
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link @if( request()->route()->getName() == 'dobrodinec.objednavky.index' ) active @endif" href="{{ route('dobrodinec.objednavky.index' , $dobrodinec_id) }}">
			Objednávky periodické
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link @if( request()->route()->getName() == 'dobrodinec.ucty' ) active @endif" href="{{ route('dobrodinec.ucty', $dobrodinec_id) }}">
			Účty
		</a>
	</li><!-- / .nav-item -->

	<li class="nav-item">
		<a class="nav-link @if( request()->route()->getName() == 'dobrodinec.getfusion' ) active @endif" href="{{ route('dobrodinec.getfusion', $dobrodinec_id) }}">
			Zlúčiť
		</a>
	</li><!-- / .nav-item -->
</ul>