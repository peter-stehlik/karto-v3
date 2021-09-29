<x-app-layout>
	<h1 class="h3 py-2 border-bottom text-uppercase">Zadať príjem</h1>

	<div class="row">
		<div class="col-lg-5" style="z-index: 7;">
		{!! Form::open(['action' => 'App\Http\Controllers\IncomeController@store', 'id' => 'incomeForm']) !!}	
				<div class="row">
					<div class="bg-warning p-3 mb-4">
						<div class="row">
							<div class="col-lg-7">
								<div class="mb-2">
									<label class="pr-2 mb-1" for="search_name">Meno</label>
									
									<div>
										<input class="form-control" id="search_name" type="text" name="search_name"	autocomplete="off" autofocus>
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

					<input type="hidden" name="person_id" id="person_id">

					<div class="col-lg-5">
						<div class="mb-3">
							<label class="pr-2 mb-1" for="name1">Meno</label>

							<div>
								<input class="form-control" id="name1" type="text" name="name1" autocomplete="off" readonly>
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
						
						<select class="form-control" name="bank_account_id" id="bank_account_id" required>
							<option value="">Vyberte</option>
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
									{!! $bank_account->bank_name !!}  {!! $bank_account->number !!}
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
					<div class="bg-light pt-3 p-2 mb-3" id="transfers" style="width: 210%; max-width: 210%; display: none;">
						<div class="row">
							<!-- 6 UCELOV -->
							@for( $i=1; $i <= 6; $i++)
								<div class="col-lg-4" id="transfer-{{ $i }}" style="display: none;">
									<div class="row">
										<h3 class="text-center mb-2">Účel</h3>

										<div class="col-lg-6">
											<div class="mb-2">
												<label class="pr-2 mb-1" for="p{{ $i }}">Publikácia</label>

												<select class="form-control" id="p{{ $i }}" name="periodical_publication[]">
													<option value="">Vyberte</option>

													@foreach( $periodicals as $item )
													<option value="{!! $item->id !!}">{!! $item->name !!}</option>
													@endforeach
												</select>
											</div>
										</div>

										<div class="col-lg-6">
											<div class="mb-2">
												<label class="pr-2 mb-1" for="np{{ $i }}">Neperiodikum</label>

												<select class="form-control" id="np{{ $i }}" name="nonperiodical_publication[]">
													<option value="">Vyberte</option>

													@foreach( $nonperiodicals as $item )
													<option value="{!! $item->id !!}">{!! $item->name !!}</option>
													@endforeach
												</select>
											</div>
										</div>

										<div class="col-lg-6">
											<div class="mb-2">
												<label class="pr-2 mb-1" for="s{{ $i }}">Suma</label>

												<input class="form-control" type="text" id="s{{ $i }}" name="sum[]">
											</div>
										</div>

										<div class="col-lg-6">
											<div class="mb-2">
												<label class="pr-2 mb-1" for="d{{ $i }}">Dátum</label>

												<input class="form-control" id="d{{ $i }}" type="text" name="transfer_date[]">
											</div>
										</div>

										<div class="col-lg-12">
											<div class="mb-2">
												<label class="pr-2 mb-1" for="n{{ $i }}">Poznámka</label>

												<textarea class="form-control" id="n{{ $i }}" name="note[]"></textarea>
											</div>
										</div>
									</div>
								</div>

								@if( $i % 3 == 0 ) <hr class="my-4"> @endif
							@endfor
						</div>
					</div>
				</div>



				<div class="mb-3">
					<button class="btn btn-primary" type="submit">Uložiť</button>
				</div>
		{!! Form::close() !!}
		</div>

		<div class="col-lg-5 offset-lg-1">
			<div class="preloader" data-id="income-search" style="display:none;">
				Prehrabávam zásuvky, moment prosím <img src="{{ asset('assets/images/ajax-loader.gif') }}" width="16" height="11" alt="" class="ajax-loader">
			</div>

			<div class="income-search-results" style="display:none;">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>ID</th>
							<th>Meno 1</th>
							<th>Adresa</th>
							<th>Mesto</th>
							<th>PSČ</th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
						</tr>
					</thead>

					<tbody id="incomeSearchResults">

					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- ----------------------- -->
    <!-- CREATE NEW PERSON MODAL -->
    <!-- ----------------------- -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Vytvorte nového používateľa</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

				{!! Form::open(array("id"=>"create_user_dynamically")) !!}
                <div class="modal-body">
					<div class="mb-3">
						<label for="category_id">Kategória</label>
						
						<select name="category_id" id="inc_category_id" class="form-control">
							@foreach( $categories as $cat )
								<option value="{!! $cat->id !!}">{!! $cat->name !!}</option>
							@endforeach
						</select>
					</div>

					<div class="mb-3">
						<div class="row">
							<div class="col-lg-3">
								<label for="title">Titul</label>
									
								<input type="text" name="title" id="inc_title" class="form-control">
							</div>

							<div class="col-lg-9">
								<label for="name1">Meno a priezvisko</label>
								
								<input type="text" name="name1" id="inc_name1" class="form-control name1a">
							</div>
						</div>
					</div>

					<div class="mb-3">
						<div class="row">
							<div class="col-lg-6">
								<label for="address1">Adresa 1</label>
								
								<input type="text" name="address1" id="inc_address1" class="form-control">
							</div>

							<div class="col-lg-6">
								<label for="address2">Adresa 2</label>
								
								<input type="text" name="address2" id="inc_address2" class="form-control">
							</div>
						</div>
					</div>

					<div class="mb-3">
						<div class="row">
							<div class="col-lg-6">
								<label for="organization">Organizácia</label>
								
								<input type="text" name="organization" id="inc_organization" class="form-control">
							</div>

							<div class="col-lg-6">
								<label for="zip_code">PSČ</label>
								
								<input type="text" name="zip_code" id="inc_zip_code" class="form-control">
							</div>
						</div>
					</div>

					<div class="mb-3">
						<div class="row">
							<div class="col-lg-6">
								<label for="city">Mesto</label>
								
								<input type="text" name="city" id="inc_city" class="form-control">
							</div>

							<div class="col-lg-6">
								<label for="state">Štát</label>
								
								<input type="text" name="state" id="inc_state" class="form-control">
							</div>
						</div>
					</div>

					<div class="mb-3">
						<label for="email">Email</label>
						
						<input type="email" name="email" id="inc_email" class="form-control">
					</div>

					<div class="mb-3">
						<label for="note">Poznámka <em>(max. 255 znakov)</em></label>
						
						<textarea name="note" id="inc_note" class="form-control" maxlength="255"></textarea>
					</div>
				</div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">zrušiť</button>
                    <button type="submit" class="js-confirm-delete btn btn-danger" data-id="">vytvoriť</button>
                </div>
				{!! Form::close() !!}
            </div>
        </div>
    </div>
</x-app-layout>