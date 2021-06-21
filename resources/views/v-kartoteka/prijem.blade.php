<x-app-layout>
	<h1 class="h3 py-2 border-bottom text-uppercase">Zadať príjem</h1>

	<div class="row">
		<div class="col-lg-5">
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
							<!-- 4 UCELY -->
							@for( $i=1; $i <= 4; $i++)
								<div class="col-lg-5 @if( $i % 2 == 0 ) offset-lg-1 @endif">
									<div class="row">
										<h3 class="text-center mb-2">Účel</h3>

										<div class="col-lg-6">
											<div class="mb-2">
												<label class="pr-2 mb-1" for="p{{ $i }}">Publikácia</label>

												<select class="form-control" id="p{{ $i }}" name="periodical_publication[]">
													<option value="0">Vyberte</option>

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
													<option value="0">Vyberte</option>

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

								@if( $i % 2 == 0 ) <hr class="my-4"> @endif
							@endfor
						</div>
					</div>
				</div>



				<div class="mb-3">
					<button class="btn btn-primary" type="submit">Uložiť</button>
				</div>
		{!! Form::close() !!}
		</div>

		<div class="col-lg-5 offset-lg-1 income-search-results" style="/*display:none;*/">
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

	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				{!! Form::open(array("id"=>"create_user_dynamically")) !!}

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Vytvorte nového používateľa</h4>
				</div>

				<div class="modal-body">
					<div class="col-sm-12 income-new-person">
						<div class="row">							
							
								<div class="form-group">
									<label for="category_id">Kategória <sup class="text-danger">*</sup></label>
									<select name="category_id" id="inc_category_id" class="form-control input-sm" required>
										@foreach( $categories as $cat )
											<option value="{!! $cat->id !!}">{!! $cat->name !!}</option>
										@endforeach
									</select>
								</div><!-- / .form-group -->
							
								<div class="form-group row">
									<div class="col-sm-12">
										<label for="title">Titul</label>
									</div><!-- / .col-sm-12 -->
									
									<div class="col-sm-6">
										<input type="text" name="title" id="inc_title" class="form-control input-sm">
									</div><!-- / .col-sm-6 -->
								</div><!-- / .form-group -->

								<div class="form-group">
									<label for="name1">Meno 1 <sup class="text-danger">*</sup></label>
									<input type="text" name="name1" id="inc_name1" class="form-control input-sm name1a" required autofocus>
								</div><!-- / .form-group -->

								<div class="form-group">
									<label for="name2">Meno 2 </label>
									<input type="text" name="name2" id="inc_name2" class="form-control input-sm">
								</div><!-- / .form-group -->
								
								<div class="form-group">
									<label for="address1">Adresa 1</label>
									<input type="text" name="address1" id="inc_address1" class="form-control input-sm">
								</div><!-- / .form-group -->

								<div class="form-group">
									<label for="address2">Adresa 2</label>
									<input type="text" name="address2" id="inc_address2" class="form-control input-sm">
								</div><!-- / .form-group -->
								
								<div class="form-group row">
									<div class="col-sm-6">
										<label for="city">Mesto</label>
										<input type="text" name="city" id="inc_city" class="form-control input-sm">
									</div><!-- / .col-sm-6 -->
									
									<div class="col-sm-6">
										<label for="zip_code">PSČ</label>
										<input type="text" name="zip_code" id="inc_zip_code" class="form-control input-sm">
									</div><!-- / .col-sm-6 -->
								</div><!-- / .form-group -->

								<div class="form-group">
									<label for="state">Štát</label>
									<input type="text" name="state" id="inc_state" class="form-control input-sm">
								</div><!-- / .form-group -->
								
								<div class="form-group row">
									<div class="col-sm-6">
										<label for="phone">Tel. číslo</label>
										<input type="text" name="phone" id="inc_phone" class="form-control input-sm">
									</div><!-- / .col-sm-6 -->
									
									<div class="col-sm-6">
										<label for="fax">Fax</label>
										<input type="text" name="fax" id="inc_fax" class="form-control input-sm">
									</div><!-- / .col-sm-6 -->
								</div><!-- / .form-group -->

								<div class="form-group">
									<label for="bank_account">Číslo účtu</label>
									<input type="text" name="bank_account" id="inc_bank_account" class="form-control input-sm">
								</div><!-- / .form-group -->

								<div class="form-group">
									<label for="email">Email</label>
									<input type="email" name="email" id="inc_email" class="form-control input-sm">
								</div><!-- / .form-group -->

								<div class="form-group">
									<label for="note">Poznámka <em>(max. 255 znakov)</em></label>
									<textarea name="note" id="inc_note" class="form-control input-sm" maxlength="255"></textarea>
								</div><!-- / .form-group -->

								<div class="form-group row">
									<div class="col-sm-6">
										<label for="birthday">Dátum narodenia</label>
										<input type="text" name="birthday" id="inc_birthday" class="form-control input-sm">
									</div><!-- / .col-sm-6 -->
									
									<div class="col-sm-6">
										<label for="anniversary">Výročie</label>
										<input type="text" name="anniversary" id="inc_anniversary" class="form-control input-sm">
									</div><!-- / .col-sm-6 -->
								</div><!-- / .form-group -->
						</div><!-- / .row -->
					</div><!-- / .col-sm-12 -->
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Zatvoriť</button>
					<button type="submit" class="btn btn-success">Vytvoriť osobu</button>
				</div>

				{!! Form::close() !!}
			</div>
		</div>
	</div>
</x-app-layout>