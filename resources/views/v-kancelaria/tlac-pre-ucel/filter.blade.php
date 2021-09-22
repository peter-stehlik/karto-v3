<x-app-layout>
    <h1 class="h3 py-2 border-bottom text-uppercase">Tlač pre účel</h1>

    <div class="col-lg-12 p-3 bg-warning">
        {!! Form::open(['action' => 'App\Http\Controllers\ListingController@printForTransferPdf', 'id' => 'printForTransferPdf', 'target' => 'blank']) !!}
            <div class="row">
                <div class="col-lg-2">
                    <label class="mb-2" for="date_from">Dátum od:</label>

                    <input class="form-control" type="text" id="date_from" name="date_from" />
                </div>

                <div class="col-lg-2">
                    <label class="mb-2" for="date_to">Dátum do:</label>

                    <input class="form-control" type="text" id="date_to" name="date_to" />
                </div>

                <div class="col-lg-2">
                    <label class="mb-2" for="banks">Banka:</label>

                    <select class="form-control" id="banks" name="bank_account_id">
                        <option value="0">Nezáleží</option>

                        @foreach( $bank_accounts as $bank_account )
                            <option value="{{ $bank_account->id }}">{{ $bank_account->bank_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2">
                    <label class="mb-2" for="transfer_type_id">Účel:</label>

                    <select class="form-control" id="transfer_type_id" name="transfer_type_id" required>
                        <option value="">Nezáleží</option>

                        @foreach( $periodical_publications as $pp )
                            <option value="{{ $pp->id }}">{{ $pp->name }}</option>
                        @endforeach

                        @foreach( $nonperiodical_publications as $np )
                            <option value="np_{{ $np->id }}">{{ $np->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2">
                    <label class="d-block mb-2" for="">&nbsp;</label>

                    <button class="btn btn-info" type="submit">Vybrať</button>
                </div>
            </div>
        {!! Form::close() !!}
    </div>

    <script>
        $(document).ready(function(){
             $("#date_from").on("input", function(){                 
                let val = $(this).val();

                $("#date_to").val(val);
             });
        });
    </script>
</x-app-layout>