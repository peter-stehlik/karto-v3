<x-app-layout>
    <h1 class="h3 py-2 border-bottom text-uppercase">
		Neplatiči
	</h1>

	<div class="col-lg-12">
		<ul class="mb-3">
			<?php $total = 0; ?>
			@foreach( $overall as $o )
				<li>{!! $o->name !!} <span class="text-danger">{!! number_format($o->credit, 2, ",", " ") !!} &euro;</span></li>
				<?php $total += $o->credit; ?>
			@endforeach
			<li><strong>Spolu <span class="text-danger">{!! number_format($total, 2, ",", " ") !!} &euro;</span></strong></li>
		</ul>

		<div class="preloader" style="display:none;">
			Prehrabávam zásuvky, moment prosím <img src="{{ asset('assets/images/ajax-loader.gif') }}" width="16" height="11" alt="" class="ajax-loader">
		</div>

		<div class="mt-3">
			<p class="total-count-wrap">Celkový počet: <strong id="totalCount"></strong></p>

			<div id="neplaticiTabulator"></div>
		</div>
	</div>

	<script>
		$(document).ready(function () {
    		if ($("#neplaticiTabulator").length) {
				var data = @json($people);

				if (data.length) {
					$("#totalCount").text(data.length);

					let table = new Tabulator("#neplaticiTabulator", {
					layout: "fitColumns",
					pagination: "local",
					paginationSize: 20,
					paginationSizeSelector: [10, 20, 50, 100],
					data: data, //assign data to table
					columns: [
						{title:"ID", field:"id", sorter:"number", width: 60},
						{title:"titul", field:"title", sorter:"string", visible:false},
						{title:"meno", field:"name1", sorter:"string", formatter: function(cell, formatterParams){
							let value = cell.getValue();
							let id = cell.getRow().getCells()[0].getValue();
							let titul = cell.getRow().getCells()[1].getValue();
			
							return "<a href='/dobrodinec/" + id + "/ucty' target='_blank'>" + titul + " " + value + "</a>";
						}},
						{title:"adresa", field:"address1", sorter:"string"},
						{title:"mesto", field:"city", sorter:"string"},
						{title:"PSČ", field:"zip_code", sorter:"string"},
						{title:"Hlasy", field:"hlasy_credit", sorter:"number", formatter: function(cell, formatterParams){
							let value = cell.getValue();
							if( !value ){
								return value;
							}

							let credit = Help.beautifyDecimal(value);
							credit += " &euro;"
							if(value<0){
								credit = "<span class='text-danger'>" + credit + "</span>";
							}

							return credit;
		                }},
						{title:"Malý kalendár", field:"maly_kalendar_credit", sorter:"number", formatter: function(cell, formatterParams){
							let value = cell.getValue();
							if( !value ){
								return value;
							}
							let credit = Help.beautifyDecimal(value);
							credit += " &euro;"
							if(value<0){
								credit = "<span class='text-danger'>" + credit + "</span>";
							}

							return credit;
		                }},
						{title:"Kalendár knižný", field:"kalendar_knizny_credit", sorter:"number", formatter: function(cell, formatterParams){
							let value = cell.getValue();
							if( !value ){
								return value;
							}
							let credit = Help.beautifyDecimal(value);
							credit += " &euro;"
							if(value<0){
								credit = "<span class='text-danger'>" + credit + "</span>";
							}

							return credit;
		                }},
						{title:"Kalendár nástenný", field:"kalendar_nastenny_credit", sorter:"number", formatter: function(cell, formatterParams){
							let value = cell.getValue();
							if( !value ){
								return value;
							}
							let credit = Help.beautifyDecimal(value);
							credit += " &euro;"
							if(value<0){
								credit = "<span class='text-danger'>" + credit + "</span>";
							}

							return credit;
		                }},
					],
					locale: "sk",
					langs: {
						"sk": {
						"pagination":{
							"first":"prvá",
							"first_title":"prvá strana",
							"last":"posledná",
							"last_title":"posledná strana",
							"prev":"predošlá",
							"prev_title":"predošlá strana",
							"next":"ďalšia",
							"next_title":"ďalšia strana",
							"all":"všetky",
							"page_size": "počet na stranu",
						},
						}
					},
					});
				} else {
					alert("Nič som nenašiel.");
				}
			}
		});
	</script>
</x-app-layout>