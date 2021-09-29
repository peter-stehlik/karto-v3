<x-app-layout>
    <h1 class="h3 py-2 border-bottom text-uppercase">Nepotvrdené prevody <a class="btn btn-sm btn-success" href="{{ route('kartoteka.prijem-get') }}">Pridať nový príjem</a></h1>   

    <div class="row">
        <div class="col-lg-3">
			<div class="p-3 mb-3 bg-warning">
				<label class="mb-2" for="filterTransfers">Účel:</label>

				<select class="form-control" id="filterTransfers">
					<option value="0">Zobraz všetky</option>

					@foreach( $periodicals as $p )
						<option value="{{ $p->id+100 }}">{{ $p->name }}</option>
					@endforeach
					
					@foreach( $nonperiodicals as $p )
						<option value="{{ $p->id }}">{{ $p->name }}</option>
					@endforeach
				</select>
			</div>
		</div>

        <script>
            /**
             * filtruj prevody podla ucelu
             */
            $(document).ready(function(){
                $("#filterTransfers").change(function(){
                    let id = parseInt($(this).val());

                    $(".unconfirmedTransfers tr").hide();
                    $(".unconfirmedTransfers tr[data-ucel-id='" + id + "']").show();

                    if( !id ){
                        $(".unconfirmedTransfers tr").show();
                    }
                });
            });
        </script>

		<div class="col-lg-12">
			<table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Meno</th>
                        <th>Účel</th>
                        <th>Suma</th>
                        <th>Poznámka</th>
                        <th>Dátum prevodu</th>
						<th>Príjem</th>
                        <th>Upraviť (v rámci príjmu)</th>
                        <th>Zaúčtovať</th>
                        <th>Vymazať</th>
                    </tr>
                </thead>

				<tbody class="unconfirmedTransfers">
					@foreach( $transfers as $transfer )
					<tr data-ucel-id="{{ $transfer->pp_id ? $transfer->pp_id+100 : $transfer->np_id }}">
						<td>{{ $transfer->id }}</td>					
						<td>{{ $transfer->name1 }}</td>					
						<td>{{ $transfer->pp_name ? $transfer->pp_name : $transfer->np_name }}</td>					
						<td>{{ number_format($transfer->sum, 2, ",", " ") }} &euro;</td>					
						<td>{{ $transfer->note }}</td>					
						<td>{{ date("j.n.Y", strtotime($transfer->transfer_date)) }}</td>
						<td>
							<ul>
								<li>ID: {{ $transfer->income_id }}</li>
								<li><span class="text-secondary">Banka:</span> {{ $transfer->bank_name }}, <span class="text-secondary">Suma:</span> {{ number_format($transfer->income_sum, 2, ",", " ") }} &euro;</li>
								<li><span class="text-secondary">Číslo:</span> {{ $transfer->number }}, <span class="text-secondary">Balík:</span> {{ $transfer->package_number }}, <span class="text-secondary">Faktúra:</span> {{ $transfer->invoice }}</li>
								<li><span class="text-secondary">Dátum príjmu:</span> {{ date("j.n.Y", strtotime($transfer->income_date)) }}</li>
							</ul>
						</td>		
						<td class="text-center"><a href="{{ route('kartoteka.nepotvrdene-prijmy.edit', [$transfer->income_id, 'transfer_id' => $transfer->id]) }}">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
									fill="currentColor" class="bi bi-pencil-square text-success"
									viewBox="0 0 16 16">
									<path
										d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
									<path fill-rule="evenodd"
										d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
								</svg>
							</a>
						</td>

                        <td class="text-center">
                            
                        </td>

						<td class="text-center">
							<a class="js-delete-transfer" data-id="{{ $transfer->id }}" data-bs-toggle="modal" data-bs-target="#deleteTransferModal" href="javascript:void(0);">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
									fill="currentColor" class="bi bi-trash text-danger"
									viewBox="0 0 16 16">
									<path
										d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
									<path fill-rule="evenodd"
										d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
								</svg>
							</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>


    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- ----------------------------------- -->
    <!-- FILL DELETE MODAL WITH DYNAMIC DATA -->
    <!-- ----------------------------------- -->
    <script>
        $(document).ready(function(){
            $(document).on("click", ".js-delete-transfer", function(){
                let id = $(this).attr("data-id");

                $(".js-confirm-delete").attr("data-id", id);
            });

            $(document).on("click", ".js-confirm-delete", function(){
                let id = $(this).attr("data-id");
                let token = $("meta[name='csrf-token']").attr("content");

                $.ajax({
                    url: "/kartoteka/nepotvrdene-prevody-vymazat/" + id,
                    type: 'GET',
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    success: function (data){
                        if( data.success != "1" ){
                            alert("Došlo k chybe!");

                            return;
                        }
                        alert( "Vymazanie prebehlo úspešne." );
                        location.reload();
                    }
                });
            });
        });
    </script>

    <!-- ------------ -->
    <!-- DELETE MODAL -->
    <!-- ------------ -->
    <div class="modal fade" id="deleteTransferModal" tabindex="-1" aria-labelledby="deleteTransferModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Potvrďte vymazanie</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p>Naozaj chcete <strong>vymazať</strong> tento prevod?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">zrušiť</button>
                    <button type="button" class="js-confirm-delete btn btn-danger" data-id="">vymazať</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>