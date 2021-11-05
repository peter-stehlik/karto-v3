<x-app-layout>
	<h1 class="h3 py-2 border-bottom text-uppercase">Nové číslo</h1>

	<div class="row">
		<div class="col-lg-5">
			<table class="table">
				<thead>
					<tr>
						<th>Názov</th>
					</tr>
				</thead>

				<tbody>
					@foreach( $periodical_publications as $p )
						<tr>
							<td><a href="">{!! $p->name !!}</a></td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</x-app-layout>
