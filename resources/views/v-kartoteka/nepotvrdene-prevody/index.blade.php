<x-app-layout>
    <h1 class="h3 py-2 border-bottom text-uppercase">Nepotvrdené prevody</h1>   

    <div class="row">
        <div class="col-lg-5">
			<div class="p-3 mb-3 bg-warning">
				<label class="mb-2" for="transfer">Účel:</label>

				<select class="form-control" id="transfer">
					<option>Vyberte</option>

					@foreach( $periodicals as $p )
						<option value="{{ $p->id }}">{{ $p->name }}</option>
					@endforeach
					
					@foreach( $nonperiodicals as $p )
						<option value="{{ $p->id }}">{{ $p->name }}</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="col-lg-8">
			<table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Meno</th>
                        <th>Dátum prevodu</th>
                        <th>Poznámka</th>
                        <th>Suma</th>
                        <th>Upraviť</th>
                        <th>Vymazať</th>
                    </tr>
                </thead>

				<tbody>
					<tr>
						<td></td>					
						<td></td>					
						<td></td>					
						<td></td>					
						<td></td>					
						<td class="text-center"><a href=" route('kartoteka.nepotvrdene-prijmy.edit', [$income->id]) ">
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
							<a class="js-delete-income" data-id="" data-bs-toggle="modal" data-bs-target="#deleteTransferModal" href="javascript:void(0);">
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
				</tbody>
			</table>
		</div>
	</div>
</x-app-layout>