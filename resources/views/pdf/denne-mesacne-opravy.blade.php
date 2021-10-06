<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	
	<style>
		body { font-family: 'DejaVu Sans', sans-serif; font-size:12px; }
		table { width:100%; }
		table caption { text-align:left; }
		table thead { border-bottom:1px solid #ddd; }
		table td, table th { padding:5px 10px 5px 0; text-align:left; }
		table td:first-child { width:50%; }
		table th:last-child, table td:last-child { text-align: right; }
		.page-break { page-break-after: always; }
		a { text-decoration:none; }
	</style>
</head>
<body>
	<header style="text-align:center; margin-bottom: 45px;">
		<h2 style="margin-bottom:0;">{!! date("d.m.Y", strtotime($corrections_from)) !!} - {!! date("d.m.Y", strtotime($corrections_to)) !!}</h2>
	</header>

	<table>
		<thead>
			<tr>
				<th>Opravy</th>
				<th></th>
			</tr>
		</thead>

		<?php $total = 0; ?>

		<tbody>
			@foreach( $corrections_pp_from as $c )
			<tr>
				<td>{!! $c->name !!}</td>
				<td>-{!! str_replace(".", ",", $c->sum) !!} &euro;</td>
			</tr>
			<?php $total -= $c->sum; ?>
			@endforeach
			@foreach( $corrections_np_from as $c )
			<tr>
				<td>{!! $c->name !!}</td>
				<td>-{!! str_replace(".", ",", $c->sum) !!} &euro;</td>
			</tr>
			<?php $total -= $c->sum; ?>
			@endforeach

			@foreach( $corrections_pp_for as $c )
			<tr>
				<td>{!! $c->name !!}</td>
				<td>{!! str_replace(".", ",", $c->sum) !!} &euro;</td>
			</tr>
			<?php $total += $c->sum; ?>
			@endforeach
			@foreach( $corrections_np_for as $c )
			<tr>
				<td>{!! $c->name !!}</td>
				<td>{!! str_replace(".", ",", $c->sum) !!} &euro;</td>
			</tr>
			<?php $total += $c->sum; ?>
			@endforeach
		</tbody>

		<tfoot>
			<tr>
				<td><em>Spolu:</em></td>
				<td><em>{!! $total !!} &euro;</em></td>
			</tr>
		</tfoot>
	</table>
</body>
</html>