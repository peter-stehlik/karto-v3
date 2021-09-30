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
		<h2 style="margin-bottom:0;">{!! date("d.m.Y", strtotime($date_from)) !!} - {!! date("d.m.Y", strtotime($date_to)) !!}</h2>
		<p style="margin-top:0;">{!! $transfer_type_name !!}   {!! $bank->bank_name ?? '' !!}</p>
	</header>


	<table>
		<thead>
			<tr>
				<th>Dátum</th>
				<th>Meno</th>
				<th>Adresa</th>
				<th>Mesto</th>
				<th>Číslo</th>
				<th>Suma</th>
				<th>Poznámka</th>
			</tr>
		</thead>

		<tbody>
			<?php $total = 0; ?>

			@foreach( $people as $person )
				<tr>
					<td>{!! date("d.m.Y", strtotime($person->transfer_date)) !!}</td>
					<td>{!! $person->title !!} <br> {!! $person->name1 !!}</td>
					<td>{!! $person->address1 !!}</td>
					<td>{!! $person->zip_code !!} <br> {!! $person->city !!}</td>
					<td>{!! $person->number !!}</td>
					<td>{!! str_replace(".", ",", $person->sum) !!} &euro;</td>
					<td>{!! $person->note !!}</td>
				</tr>

				<?php $total += $person->sum; ?>
			@endforeach
		</tbody>

		<tfoot>
			<tr>
				<th colspan="5">Spolu:</th>
				<th colspan="2" style="text-align: left;"><?php echo $total; ?> &euro;</th>
			</tr>
		</tfoot>
	</table>
</body>
</html>