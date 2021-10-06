<x-app-layout>
    <h1 class="h3 py-2 border-bottom text-uppercase">Denné/mesačné opravy</h1>

    <div class="col-lg-12 p-3 bg-warning">
        {!! Form::open(['action' => 'App\Http\Controllers\ListingController@dailyMonthlyCorrectionPdf', 'id' => 'dailyMonthlyCorrectionPdf', 'target' => 'blank']) !!}
            <div class="row">
                <div class="col-lg-2">
                    <label class="mb-2" for="corrections_from">Dátum od:</label>

                    <input class="form-control" type="text" id="corrections_from" name="corrections_from" />
                </div>

                <div class="col-lg-2">
                    <label class="mb-2" for="corrections_to">Dátum do:</label>

                    <input class="form-control" type="text" id="corrections_to" name="corrections_to" />
                </div>

                <div class="col-lg-2">
                    <label class="d-block mb-2" for="date_to">&nbsp;</label>

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