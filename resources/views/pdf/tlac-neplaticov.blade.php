<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	
	<style>
		body { font-family: 'DejaVu Sans', sans-serif; font-size:10px; }
		table { width:100%; }
		table caption { text-align:left; }
		table thead { border-bottom:1px solid #333; }
		table tfoot { border-top:1px solid #333; }
		table td, table th { padding:3px 5px 3px 0; text-align:left; }
		/*table td:first-child { width:25%; }*/
		table th:last-child, table td:last-child { text-align: right; }
		.page-break { page-break-after: always; }
		a { text-decoration:none; }
	</style>
</head>
<body>
	<header style="text-align:center; margin-bottom: 45px;">
		<h2 style="margin-bottom:0;">Zoznam neplatičov ({!! date("d.m.Y") !!})</h2>
	</header>

	<table>
		<thead>
			<tr>
				<th>P.č.</th>
				<th>Meno</th>
				<th>Adresa</th>
				<th>Mesto</th>
				<th>Hlasy</th>
				<th>Malý kalendár</th>
				<th>Kalendár knižný</th>
				<th>Kalendár nástenný</th>
			</tr>
		</thead>

		<?php $i=1; ?>

		<tbody>
			@foreach( $people as $person )
				<tr>
					<td>{!! $i !!}</td>
					<td>@if($person['title']) {!! $person['title'] !!} <br>@endif {!! $person['name1'] !!}</td>
					<td>{!! $person['address1'] !!}</td>
					<td>{!! $person['city'] !!}</td>
					<td>{!! str_replace(".", ",", $person['hlasy_credit']) !!} &euro;</td>
					<td>{!! str_replace(".", ",", $person['maly_kalendar_credit']) !!} &euro;</td>
					<td>{!! str_replace(".", ",", $person['kalendar_nastenny_credit']) !!} &euro;</td>
					<td>{!! str_replace(".", ",", $person['kalendar_knizny_credit']) !!} &euro;</td>
				</tr>

				<?php $i++; ?>
			@endforeach
		</tbody>
	</table>
</body>
</html>