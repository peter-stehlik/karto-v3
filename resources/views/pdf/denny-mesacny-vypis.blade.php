<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	
	<style>
		body { font-family: 'DejaVu Sans', sans-serif; font-size:12px; }
		table { width:100%; }
		table caption { text-align:left; }
		table thead { border-bottom:1px solid #000; }
		table td, table th { padding:5px 10px 5px 0; text-align:left; }
		table td:first-child { width:50%; }
		table th:last-child, table td:last-child { text-align: right; }
		.page-break { page-break-after: always; }
		a { text-decoration:none; }
	</style>
</head>
<body>
	<header style="text-align:center; margin-bottom: 45px;">
		<h2 style="margin-bottom:0;">{!! date("d.m.Y", strtotime($date_from)) !!} - {!! date("d.m.Y", strtotime($date_to)) !!}</h2>
		<p style="margin-top:0;">{!! $bank->bank_name !!}</p>
	</header>

	<?php
		$incomeThisYearTotal = 0;
		$incomeInvoiceThisYearTotal = 0;
		$incomeNextYearTotal = 0;
	?>

	<table>
		<tr>
			<th>Príjmy</th>
			<th></th>
		</tr>
		<tr>
			<td>Príjmy</td>
			<td>{{ str_replace(".", ",", $total_incomes ?? '') }} &euro;</td>
		</tr>
		<tr>
			<th>Prevody</th>
			<th></th>
		</tr>
	<tr>
			<td><em>do aktuálneho roku</em></td>
			<td></td>
		</tr>
    	@foreach( $periodicalThisYear as $pty )
		<tr>
			<td>{!! $pty->name !!}</td>
			<td>{!! str_replace(".", ",", $pty->sum) !!} &euro;</td>
		</tr>
			<?php $incomeThisYearTotal += $pty->sum; ?>
		@endforeach
        @foreach( $nonperiodicalThisYear as $nty )
		<tr>
			<td>{!! $nty->name !!}</td>
			<td>{!! str_replace(".", ",", $nty->sum) !!} &euro;</td>
		</tr>
			<?php $incomeThisYearTotal += $nty->sum; ?>
		@endforeach
        <tr>
			<td><em>Spolu</em></td>
			<td>{!! str_replace(".", ",", $incomeThisYearTotal) !!} &euro;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td></td>
		</tr>		
		<tr>
			<td><em>do aktuálneho roku na faktúru</em></td>
			<td></td>
		</tr>
		@foreach( $periodicalInvoiceThisYear as $pty )
		<tr>
			<td>{!! $pty->name !!}</td>
			<td>{!! str_replace(".", ",", $pty->sum) !!} &euro;</td>
		</tr>
			<?php $incomeInvoiceThisYearTotal += $pty->sum; ?>
		@endforeach
		@foreach( $nonperiodicalInvoiceThisYear as $nty )
		<tr>
			<td>{!! $nty->name !!}</td>
			<td>{!! str_replace(".", ",", $nty->sum) !!} &euro;</td>
		</tr>
			<?php $incomeInvoiceThisYearTotal += $nty->sum; ?>
		@endforeach
		<tr>
			<td><em>Spolu</em></td>
			<td>{!! str_replace(".", ",", $incomeInvoiceThisYearTotal) !!} &euro;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td></td>
		</tr>
		<tr>
			<td><em>do nasledujúceho roku</em></td>
			<td></td>
		</tr>
		@foreach( $periodicalNextYear as $pty )
		<tr>
			<td>{!! $pty->name !!}</td>
			<td>{!! str_replace(".", ",", $pty->sum) !!} &euro;</td>
		</tr>
			<?php $incomeNextYearTotal += $pty->sum; ?>
		@endforeach
		@foreach( $nonperiodicalNextYear as $nty )
		<tr>
			<td>{!! $nty->name !!}</td>
			<td>{!! str_replace(".", ",", $nty->sum) !!} &euro;</td>
		</tr>
			<?php $incomeNextYearTotal += $nty->sum; ?>
		@endforeach
		<tr>
			<td><em>Spolu</em></td>
			<td>{!! str_replace(".", ",", $incomeNextYearTotal) !!} &euro;</td>
		</tr>
        
		<tr>
			<th>Zostatok</th>
			<th></th>
		</tr>
		<tr>
			<td>Príjmy</td>
			<td>{{ str_replace(".", ",", $total_incomes ?? '') }} &euro;</td>
		</tr>
		<tr>
			<td>Prevody</td>
			<td>{{ str_replace(".", ",", $total_transfers ?? '') }} &euro;</td>
		</tr>
		<tr>
			<td><em>Peniaze na ceste</em></td>
			<td>{{ str_replace(".", ",", $on_the_way ?? '') }} &euro;</td>
		</tr>
	</table>

</body>
</html>