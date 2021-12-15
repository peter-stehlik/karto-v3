<x-app-layout>
    <script src="{{ asset('assets/dist/js/person-transfers-filter.js') }}" defer></script>

    <h1 class="h3 py-2 border-bottom text-uppercase">
		Prevody
	</h1>

	<script>
		$(document).ready(function(){
			let dobrodinec = "<strong>{{ $person->name1 }}</strong><span class='d-block text-secondary'> {{ $person->organization }}</span>{{ $person->address1 }}<span class='d-block text-secondary'> {{ $person->zip_code }} {{ $person->city }}</span>{{ $person->email }}";
			
			$("#dobrodinec").html(dobrodinec);
		});		
	</script>

	<div class="col-lg-12 p-3 bg-warning">
		<input id="person_id" type="hidden" value="{!! $person->id !!}">

        <div class="row">
            <div class="col-lg-1">
                <div class="mb-3">
                    <label class="mb-2" for="sum_from">Suma od:</label>
                    
                    <input class="form-control" id="sum_from" type="number">
                </div>
            </div>

            <div class="col-lg-1">
                <div class="mb-3">
                    <label class="mb-2" for="sum_to">Suma do:</label>
                    
                    <input class="form-control" id="sum_to" type="number">
                </div>
            </div>

			<div class="col-lg-2">
                <div class="mb-3">
                    <label class="mb-2" for="periodical_publication_id">Periodikum:</label>
                    
                    <select class="form-control" id="periodical_publication_id">
						<option value="0">Nezáleží</option>
						@foreach( $periodical_publications as $pp )
							<option value="{!! $pp->id !!}">{!! $pp->name !!}</option>
						@endforeach
					</select>
                </div>
            </div>

			<div class="col-lg-2">
                <div class="mb-3">
                    <label class="mb-2" for="nonperiodical_publication_id">Neperiodikum:</label>
                    
                    <select class="form-control" id="nonperiodical_publication_id">
						<option value="0">Nezáleží</option>
						@foreach( $nonperiodical_publications as $pp )
							<option value="{!! $pp->id !!}">{!! $pp->name !!}</option>
						@endforeach
					</select>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="mb-3">
                    <label class="mb-2" for="transfer_date_from">Dát. prevodu od:</label>
                    
                    <input class="form-control" id="transfer_date_from" type="text">
                </div>
            </div>

            <div class="col-lg-2">
                <div class="mb-3">
                    <label class="mb-2" for="transfer_date_to">Dát. prevodu do:</label>
                    
                    <input class="form-control" id="transfer_date_to" type="text">
                </div>
            </div>

            <div class="col-lg-2">
                <div class="mb-3">
                    <label class="d-block mb-2" for="">&nbsp;</label>
                    
                    <button class="btn btn-primary" id="initPersonTransfersFilter" type="submit">Filtrovať</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="preloader" style="display:none;">
            Prehrabávam zásuvky, moment prosím <img src="{{ asset('assets/images/ajax-loader.gif') }}" width="16" height="11" alt="" class="ajax-loader">
        </div>

        <div class="mt-3">
            <p class="total-count-wrap" style="display: none;">Celkový počet: <strong id="totalCount"></strong></p>

            <div id="personTransfersFilterTabulator"></div>
        </div>
    </div> 

    <!-- ----------------------------------- -->
    <!-- FILL MODAL WITH DYNAMIC DATA -->
    <!-- ----------------------------------- -->
    <script>
        $(document).ready(function(){
            $(document).on("click", ".js-edit-transfer-btn", function(){
                let transfer_id = $(this).attr("data-transfer-id");
                let transfer_date = Help.beautifyDate($(this).attr("data-transfer-date"));
                let sum = Help.beautifyDecimal($(this).attr("data-transfer-sum"));

                $("#old_transfer_id").val(transfer_id);
                $("#transfer_sum").val(sum);
                $("#transfer_transfer_date").val(transfer_date);
            });

            $(document).on("click", ".js-edit-transfer-submit", function(){
                let old_transfer_id = $("#old_transfer_id").val();
                let transfer_periodical_publication_id = $("#transfer_periodical_publication_id").val();
                let transfer_nonperiodical_publication_id = $("#transfer_nonperiodical_publication_id").val();
                let transfer_sum = $("#transfer_sum").val();
                let transfer_transfer_date = $("#transfer_transfer_date").val();
                let transfer_note = $("#transfer_note").val();

                $.getJSON(
                    "/dobrodinec/prevody-filter-uprav-prevod",
                    {
                        old_transfer_id: old_transfer_id,
                        periodical_publication_id: transfer_periodical_publication_id,
                        nonperiodical_publication_id: transfer_nonperiodical_publication_id,
                        sum: transfer_sum,
                        transfer_date: transfer_transfer_date,
                        note: transfer_note,
                    },
                    function (data) {
                        if (data.result) {   
                            if( data.result != "1" ){
                                alert("Došlo k chybe!");

                                return;
                            }
                            
                            alert( "Úprava prebehla úspešne." );
                            location.reload();
                        }
                    }
                );
            });
        });
    </script>

    <div class="modal fade" id="editTransfer" tabindex="-1" aria-labelledby="editTransfer" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pridajte nový účel</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <p>Starý účel sa automaticky vymaže.</p>

                    <input type="hidden" id="old_transfer_id">

                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="transfer_periodical_publication_id">Publikácia</label>

                            <select class="form-control" id="transfer_periodical_publication_id">
                                <option value="0">Nezáleží</option>
                                @foreach( $periodical_publications as $pp )
                                    <option value="{!! $pp->id !!}">{!! $pp->name !!}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-lg-6 mb-3">
                            <label for="transfer_periodical_publication_id">Neperiodikum</label>

                            <select class="form-control" id="transfer_nonperiodical_publication_id">
                                <option value="0">Nezáleží</option>
                                @foreach( $nonperiodical_publications as $pp )
                                    <option value="{!! $pp->id !!}">{!! $pp->name !!}</option>
                                @endforeach
                            </select>
                        </div>    
                        
                        <div class="col-lg-6 mb-3">
                            <label for="transfer_sum">Suma</label>

                            <input class="form-control" id="transfer_sum" type="text">
                        </div>
                        
                        <div class="col-lg-6 mb-3">
                            <label for="transfer_transfer_date">Dátum</label>

                            <input class="form-control" id="transfer_transfer_date" type="text">
                        </div>

                        <div class="col-lg-12">
                            <label for="transfer_note">Poznámka</label>

                            <textarea class="form-control" id="transfer_note"></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">zrušiť</button>
                    <button type="button" class="js-edit-transfer-submit btn btn-danger" data-id="">potvrdiť</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 