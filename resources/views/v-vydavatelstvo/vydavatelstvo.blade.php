<x-app-layout>
	<h1 class="h3 py-2 border-bottom text-uppercase">Vydavateľstvo</h1>

	<div class="row">
		<div class="col-lg-5">
			<table class="table">
				<thead>
					<tr>
						<th>Názov</th>
						<th>Účtovanie</th>
						<th>Štítky</th>
					</tr>
				</thead>

				<tbody>
					@foreach( $periodical_publications as $p )
						<tr>
							<td>{!! $p->name !!}</td>
							<td>{!! date("d.m.Y", strtotime($p->accounting_date)) !!}</td>
							<td>{!! date("d.m.Y", strtotime($p->label_date)) !!}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</x-app-layout>
