<x-app-layout>
	<h1 class="h3 py-2 border-bottom text-uppercase">Potvrdiť príjmy</h1>

	<?php
		$incomeThisYearTotal = 0;
		$incomeInvoiceThisYearTotal = 0;
		$incomeNextYearTotal = 0;
	?>

	<div class="col-lg-5">
		<table class="table" id="confirm_incomes_summary">
			<tr>
				<th>Príjmy</th>
				<th></th>
			</tr>
			<tr>
				<td>Príjmy</td>
				<td>{{ str_replace(".", ",", $all_incomes) }}</td>
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
				<td>{!! str_replace(".", ",", $pty->sum) !!}</td>
			</tr>
				<?php $incomeThisYearTotal += $pty->sum; ?>
			@endforeach
			@foreach( $nonperiodicalThisYear as $oty )
			<tr>
				<td>{!! $oty->name !!}</td>
				<td>{!! str_replace(".", ",", $oty->sum) !!}</td>
			</tr>
				<?php $incomeThisYearTotal += $oty->sum; ?>
			@endforeach
			<tr>
				<td><em>Spolu</em></td>
				<td>{!! str_replace(".", ",", $incomeThisYearTotal) !!}</td>
			</tr>

			<tr>
				<td><em>do aktuálneho roku na faktúru</em></td>
				<td></td>
			</tr>
			@foreach( $periodicalThisYearInvoice as $pty )
			<tr>
				<td>{!! $pty->name !!}</td>
				<td>{!! str_replace(".", ",", $pty->sum) !!}</td>
			</tr>
				<?php $incomeInvoiceThisYearTotal += $pty->sum; ?>
			@endforeach
			@foreach( $nonperiodicalThisYearInvoice as $oty )
			<tr>
				<td>{!! $oty->name !!}</td>
				<td>{!! str_replace(".", ",", $oty->sum) !!}</td>
			</tr>
				<?php $incomeInvoiceThisYearTotal += $oty->sum; ?>
			@endforeach
			<tr>
				<td><em>Spolu</em></td>
				<td>{!! str_replace(".", ",", $incomeInvoiceThisYearTotal) !!}</td>
			</tr>

			<tr>
				<td><em>do nasledujúceho roku</em></td>
				<td></td>
			</tr>
			@foreach( $periodicalNextYear as $pty )
			<tr>
				<td>{!! $pty->name !!}</td>
				<td>{!! str_replace(".", ",", $pty->sum) !!}</td>
			</tr>
				<?php $incomeNextYearTotal += $pty->sum; ?>
			@endforeach
			@foreach( $periodicalNextYear as $oty )
			<tr>
				<td>{!! $oty->name !!}</td>
				<td>{!! str_replace(".", ",", $oty->sum) !!}</td>
			</tr>
				<?php $incomeNextYearTotal += $oty->sum; ?>
			@endforeach
			<tr>
				<td><em>Spolu</em></td>
				<td>{!! str_replace(".", ",", $incomeNextYearTotal) !!}</td>
			</tr>
			<tr>
				<th>Zostatok</th>
				<th></th>
			</tr>
			<tr>
				<td>Príjmy</td>
				<td>{{ str_replace(".", ",", $all_incomes) }}</td>
			</tr>
			<tr>
				<td>Prevody</td>
				<td>{{ str_replace(".", ",", $all_transfers) }}</td>
			</tr>
			<tr>
				<td><em>Peniaze na ceste</em></td>
				<td>{{ str_replace(".", ",", $on_the_way) }}</td>
			</tr>
		</table>

		{!! Form::open(['action' => 'App\Http\Controllers\IncomeController@confirmIncomes']) !!}					
			<div class="mr-3 mt-4">
				<p>Chcete platby zaúčtovať?</p>

				<button class="btn btn-success mr-4" type="submit">áno</button>

				<a class="btn btn-secondary" href="{{ route('kartoteka.uvod') }}">Nie</a>
			</div>
		{!! Form::close() !!}
	</div>
</x-app-layout>
