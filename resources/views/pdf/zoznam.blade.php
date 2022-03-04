<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	
	<style>
		body { font-family: 'DejaVu Sans', sans-serif; font-size:10px; }
		table { width:100%; }
		table caption { text-align:left; }
		table thead { border-bottom:1px solid #333; }
		table tfoot { border-top:1px solid #333; }
		table td, table th { padding:3px 5px 3px 0; border-bottom:1px solid #eee; text-align:left; }
		/*table td:first-child { width:25%; }*/
		table th:last-child, table td:last-child { text-align: right; }
		.page-break { page-break-after: always; }
		a { text-decoration:none; }
	</style>
</head>
<body>
	<table>
		<thead>
			<tr>
				<th>Meno</th>
				<th>Adresa</th>
				<th>PSČ, mesto</th>
				<th>Publikácia</th>
				<th>Ks</th>
				<th>Platné od</th>
				<th>Platné do</th>
				<th>Poznámka</th>
			</tr>
		</thead>

		<tbody>
			@foreach( $people as $person )
				<tr>
                    <td>{!! $person->title !!} <br> {!! $person->name1 !!}</td>
					<td>{!! $person->address1 !!}</td>
					<td>{!! $person->zip_code !!} <br> {!! $person->city !!}</td>
					<td>{!! $person->name !!}</td>
					<td>{!! $person->count !!}</td>
					<td>{!! date("d.m.Y", strtotime($person->valid_from)) !!}</td>
					<td>{!! date("d.m.Y", strtotime($person->valid_to)) !!}</td>
					<td>{!! $person->note !!}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>