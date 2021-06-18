<x-app-layout>
	<h1 class="h3 py-2 border-bottom text-uppercase">Zadať príjem</h1>

	<div class="row">
		{!! Form::open(['action' => 'App\Http\Controllers\IncomeController@store', 'id' => 'incomeForm']) !!}	
			<div class="col-lg-5">
				<div class="row">
					<div class="bg-warning p-3 mb-4">
						<div class="row">
							<div class="col-lg-7">
								<div class="mb-2">
									<label class="pr-2 mb-1" for="search_name">Názov</label>
									
									<div>
										<input class="form-control" id="search_name" type="text" name="search_name"	autocomplete="off">
									</div>
								</div>
							</div>
							
							<div class="col-lg-5">
								<div class="mb-2">
									<label class="pr-2 mb-1" for="search_zip_code">PSČ</label>
									
									<div>
										<input class="form-control" id="search_zip_code" type="text" name="search_zip_code"	autocomplete="off">
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-7">
								<div class="mb-1">
									<label class="pr-2 mb-1" for="search_address">Adresa</label>

									<div>
										<input class="form-control" id="search_address" type="text" name="search_address"	autocomplete="off">
									</div>
								</div>
							</div>
							
							<div class="col-lg-5">
								<div class="mb-1">
									<label class="pr-2 mb-1" for="search_city">Mesto</label>
									
									<div>
										<input class="form-control" id="search_city" type="text" name="search_city"	autocomplete="off">
									</div>
								</div>
							</div>
						</div>
					</div>

					<input type="text" name="person_id" id="person_id">

					<div class="col-lg-5">
						<div class="mb-3">
							<label class="pr-2 mb-1" for="name1">Meno</label>

							<div>
								<input class="form-control" id="name1" type="text" name="name1" autocomplete="off">
							</div>
						</div>
					</div>

					<div class="col-lg-2">
						<div class="mb-3">
							<label class="pr-2 mb-1" for="income_sum">Suma</label>

							<div>
								<input class="form-control" id="income_sum" type="text" name="income_sum" autocomplete="off">
							</div>
						</div>
					</div>

					<div class="col-lg-5">
						<div class="mb-3">
							<label class="pr-2 mb-1" for="income_date">Dátum príjmu</label>

							<div>
								<input class="form-control" id="income_date" type="text" name="income_date" value="<?php echo $date = date("d.m.Y"); ?>" autocomplete="off">
							</div>
						</div>
					</div>

					<div class="col-lg-6 mb-3">
						<label class="pr-2 mb-1" for="package_number">Balík </label>
							
						<input class="form-control" type="text" name="package_number" id="package_number">
					</div>

					<div class="col-lg-6 mb-3">
						<label class="pr-2 mb-1" for="number">Číslo</label>
							
						<input class="form-control" type="text" name="number" id="number">
					</div>

					<div class="col-lg-6 mb-3">
						<label class="pr-2 mb-1" for="invoice">Faktúra</label>
						
						<input class="form-control" type="text" name="invoice" id="invoice">
					</div>

					<div class="col-lg-6 mb-3">
						<label class="pr-2 mb-1" for="bank_account_id">Bankový účet</label>
						
						<select class="form-control" name="bank_account_id" id="bank_account_id">
							<option value="0">Vyberte</option>
							@foreach( $bank_accounts as $bank_account )
								<option
									value="{!! $bank_account->id !!}"

									@if( Auth::user()->email=="katarina.mancirova@svd.sk" && $bank_account->id==1 )
										selected="selected"
									@endif

									@if( Auth::user()->email=="katarina.vallova@svd.sk" && $bank_account->id==3 )
										selected="selected"
									@endif
								>
									{!! $bank_account->bank_name !!}, {!! $bank_account->number !!}
								</option>
							@endforeach
						</select>
					</div>

					<div class="col-lg-12 mb-3">
						<label class="pr-2 mb-1" for="income_note">Poznámka</label>
						
						<textarea class="form-control" name="income_note" id="income_note"></textarea>
					</div>

					<div class="col-lg-12">
						<hr>
					</div>


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
		{!! Form::close() !!}
	</div>
</x-app-layout>