<x-app-layout>
    <h1 class="h3 py-2 border-bottom text-uppercase">Upraviť príjem <a class="btn btn-sm btn-success" href="{{ route('kartoteka.prijem-get') }}">Pridať nový</a></h1>   

	{!! Form::open(['action' => 'App\Http\Controllers\IncomeUnconfirmedController@store', 'id' => 'incomeEditForm']) !!}	
	<div class="row">
			<div class="col-lg-5">
				<div class="row">
					<input type="hidden" name="person_id" id="person_id" value="{{ $income->person_id }}">

					<div class="col-lg-5">
						<div class="mb-3">
							<label class="pr-2 mb-1" for="name1">Meno</label>

							<div>
								<input class="form-control" id="name1" type="text" name="name1" value="{{ $income->person->name1 }}" autocomplete="off">
							</div>
						</div>
					</div>

					<div class="col-lg-2">
						<div class="mb-3">
							<label class="pr-2 mb-1" for="income_sum">Suma</label>

							<div>
								<input class="form-control" id="income_sum" type="text" name="income_sum" value="{{ number_format($income->sum, 2, ',', ' ') }}" autocomplete="off">
							</div>
						</div>
					</div>

					<div class="col-lg-5">
						<div class="mb-3">
							<label class="pr-2 mb-1" for="income_date">Dátum príjmu</label>

							<div>
								<input class="form-control" id="income_date" type="text" name="income_date" value="{{ date('d.m.Y', strtotime($income->income_date)) }}" autocomplete="off">
							</div>
						</div>
					</div>

					<div class="col-lg-6 mb-3">
						<label class="pr-2 mb-1" for="package_number">Balík </label>
							
						<input class="form-control" type="text" name="package_number" id="package_number" value="{{ $income->package_number }}">
					</div>

					<div class="col-lg-6 mb-3">
						<label class="pr-2 mb-1" for="number">Číslo</label>
							
						<input class="form-control" type="text" name="number" id="number" value="{{ $income->number }}">
					</div>

					<div class="col-lg-6 mb-3">
						<label class="pr-2 mb-1" for="invoice">Faktúra</label>
						
						<input class="form-control" type="text" name="invoice" id="invoice" value="{{ $income->invoice }}">
					</div>

					<div class="col-lg-6 mb-3">
						<label class="pr-2 mb-1" for="bank_account_id">Bankový účet</label>
						
						<select class="form-control" name="bank_account_id" id="bank_account_id">
							<option value="0">Vyberte</option>
							@foreach( $bank_accounts as $bank_account )
								<option
									value="{{ $bank_account->id }}"

									@if( $income->bank_account_id===$bank_account->id )
										selected="selected"
									@endif
								>
									{{ $bank_account->bank_name }}, {{ $bank_account->number }}
								</option>
							@endforeach
						</select>
					</div>

					<div class="col-lg-12 mb-3">
						<label class="pr-2 mb-1" for="income_note">Poznámka</label>
						
						<textarea class="form-control" name="income_note" id="income_note">{{ $income->note }}</textarea>
					</div>

				</div>
			</div>

			<div class="col-lg-6 offset-lg-1">
				<div class="row">
					<!-- ///////////////////// -->
					<!-- ///////////////////// -->
					<!-- ///   U C E L Y   /// -->
					<!-- ///////////////////// -->
					<!-- ///////////////////// -->
					<div class="bg-light pt-3 p-2 mb-3">
						<div class="row">
							<!-- UCEL 1 -->
							<div class="col-lg-5">
								<div class="row">
									<h3 class="text-center mb-2">Účel</h3>

									<input type="hidden" name="transfer_id[]" value="{{ $income->transfers[0]->id }}">

									<div class="col-lg-6">
										<div class="mb-2">
											<label class="pr-2 mb-1">Publikácia</label>

											<select class="form-control" id="p1" name="periodical_publication[]">
												<option value="0">Vyberte</option>

												@foreach( $periodicals as $item )
													<option value="{{ $item->id }}"
														@if( $income->transfers[0]->periodical_publication_id===$item->id )
															selected="selected"
														@endif
													>
														{{ $item->name }}
													</option>
												@endforeach
											</select>
										</div>
									</div>

									<div class="col-lg-6">
										<div class="mb-2">
											<label class="pr-2 mb-1">Neperiodikum</label>

											<select class="form-control" id="np1" name="nonperiodical_publication[]">
												<option value="0">Vyberte</option>

												@foreach( $nonperiodicals as $item )
													<option value="{{ $item->id }}"
														@if( $income->transfers[0]->nonperiodical_publication_id===$item->id )
															selected="selected"
														@endif
													>
														{{ $item->name }}
													</option>
												@endforeach
											</select>
										</div>
									</div>

									<div class="col-lg-6">
										<div class="mb-2">
											<label class="pr-2 mb-1">Suma</label>

											<input class="form-control" type="text" id="s1" name="sum[]" value="{{ number_format($income->transfers[0]->sum, 2, ',', ' ') }}">
										</div>
									</div>

									<div class="col-lg-6">
										<div class="mb-2">
											<label class="pr-2 mb-1">Dátum</label>

											<input class="form-control" id="d1" type="text" name="transfer_date[]" value="{{ date('d.m.Y', strtotime($income->transfers[0]->transfer_date)) }}">
										</div>
									</div>

									<div class="col-lg-12">
										<div class="mb-2">
											<label class="pr-2 mb-1">Poznámka</label>

											<textarea class="form-control" id="n1" name="note[]">{{ $income->transfers[0]->note }}</textarea>
										</div>
									</div>
								</div>
							</div>

							<!-- UCEL 2 -->
							<div class="col-lg-5 offset-lg-1">
								<div class="row">
									<h3 class="text-center mb-2">Účel</h3>

									<div class="col-lg-6">
										<div class="mb-2">
											<label class="pr-2 mb-1">Publikácia</label>

											<select class="form-control" id="p1" name="periodical_publication[]">
												<option value="0">Vyberte</option>

												@foreach( $periodicals as $item )
												<option value="{!! $item->id !!}">{!! $item->name !!}</option>
												@endforeach
											</select>
										</div>
									</div>

									<div class="col-lg-6">
										<div class="mb-2">
											<label class="pr-2 mb-1">Neperiodikum</label>

											<select class="form-control" id="np1" name="nonperiodical_publication[]">
												<option value="0">Vyberte</option>

												@foreach( $nonperiodicals as $item )
												<option value="{!! $item->id !!}">{!! $item->name !!}</option>
												@endforeach
											</select>
										</div>
									</div>

									<div class="col-lg-6">
										<div class="mb-2">
											<label class="pr-2 mb-1">Suma</label>

											<input class="form-control" type="text" id="s1" name="sum[]">
										</div>
									</div>

									<div class="col-lg-6">
										<div class="mb-2">
											<label class="pr-2 mb-1">Dátum</label>

											<input class="form-control" id="d1" type="text" name="transfer_date[]">
										</div>
									</div>

									<div class="col-lg-12">
										<div class="mb-2">
											<label class="pr-2 mb-1">Poznámka</label>

											<textarea class="form-control" id="n1" name="note[]"></textarea>
										</div>
									</div>
								</div>
							</div>

							<hr class="my-4">

							<!-- UCEL 3 -->
							<div class="col-lg-5">
								<div class="row">
									<h3 class="text-center mb-2">Účel</h3>

									<div class="col-lg-6">
										<div class="mb-2">
											<label class="pr-2 mb-1">Publikácia</label>

											<select class="form-control" id="p1" name="periodical_publication[]">
												<option value="0">Vyberte</option>

												@foreach( $periodicals as $item )
												<option value="{!! $item->id !!}">{!! $item->name !!}</option>
												@endforeach
											</select>
										</div>
									</div>

									<div class="col-lg-6">
										<div class="mb-2">
											<label class="pr-2 mb-1">Neperiodikum</label>

											<select class="form-control" id="np1" name="nonperiodical_publication[]">
												<option value="0">Vyberte</option>

												@foreach( $nonperiodicals as $item )
												<option value="{!! $item->id !!}">{!! $item->name !!}</option>
												@endforeach
											</select>
										</div>
									</div>

									<div class="col-lg-6">
										<div class="mb-2">
											<label class="pr-2 mb-1">Suma</label>

											<input class="form-control" type="text" id="s1" name="sum[]">
										</div>
									</div>

									<div class="col-lg-6">
										<div class="mb-2">
											<label class="pr-2 mb-1">Dátum</label>

											<input class="form-control" id="d1" type="text" name="transfer_date[]">
										</div>
									</div>

									<div class="col-lg-12">
										<div class="mb-2">
											<label class="pr-2 mb-1">Poznámka</label>

											<textarea class="form-control" id="n1" name="note[]"></textarea>
										</div>
									</div>
								</div>
							</div>

							<!-- UCEL 4 -->
							<div class="col-lg-5 offset-lg-1">
								<div class="row">
									<h3 class="text-center mb-2">Účel</h3>

									<div class="col-lg-6">
										<div class="mb-2">
											<label class="pr-2 mb-1">Publikácia</label>

											<select class="form-control" id="p1" name="periodical_publication[]">
												<option value="0">Vyberte</option>

												@foreach( $periodicals as $item )
												<option value="{!! $item->id !!}">{!! $item->name !!}</option>
												@endforeach
											</select>
										</div>
									</div>

									<div class="col-lg-6">
										<div class="mb-2">
											<label class="pr-2 mb-1">Neperiodikum</label>

											<select class="form-control" id="np1" name="nonperiodical_publication[]">
												<option value="0">Vyberte</option>

												@foreach( $nonperiodicals as $item )
												<option value="{!! $item->id !!}">{!! $item->name !!}</option>
												@endforeach
											</select>
										</div>
									</div>

									<div class="col-lg-6">
										<div class="mb-2">
											<label class="pr-2 mb-1">Suma</label>

											<input class="form-control" type="text" id="s1" name="sum[]">
										</div>
									</div>

									<div class="col-lg-6">
										<div class="mb-2">
											<label class="pr-2 mb-1">Dátum</label>

											<input class="form-control" id="d1" type="text" name="transfer_date[]">
										</div>
									</div>

									<div class="col-lg-12">
										<div class="mb-2">
											<label class="pr-2 mb-1">Poznámka</label>

											<textarea class="form-control" id="n1" name="note[]"></textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>



				<div class="mb-3">
					<button class="btn btn-primary" type="submit">Uložiť</button>
				</div>
			</div>
	</div>
		{!! Form::close() !!}
</x-app-layout>
