<x-app-layout>
    <h1 class="h3 py-2 border-bottom text-uppercase">Nepotvrdené príjmy <a class="btn btn-sm btn-success" href="{{ route('kartoteka.prijem-get') }}">Pridať nový</a></h1>   

    <div class="row">
        <div class="col-lg-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Meno</th>
                        <th>Dátum príjmu</th>
                        <th>Balík</th>
                        <th>Číslo</th>
                        <th>Faktúra</th>
                        <th>Banka</th>
                        <th>Poznámka</th>
                        <th>Suma</th>
                        <th>Účely</th>
                        <th>Upraviť</th>
                        <th>Vymazať</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($incomes as $income)
                    <?php $transfers_sum = 0; ?>
                    @foreach($income->transfers as $transfer)
                        <?php $transfers_sum += $transfer->sum; ?>
                    @endforeach

                    <tr class="@if( $income->sum != $transfers_sum ) bg-notice @endif" data-id="{{ $income->id }}">
                        <td>{{ $income->id }}</td>
                        <td>{{ $income->person->name1 }}</td>
                        <td>{{ date('j.n.Y', strtotime($income->income_date)) }}</td>
                        <td>{{ $income->package_number }}</td>
                        <td>{{ $income->number }}</td>
                        <td>{{ $income->invoice }}</td>
                        <td>{{ $income->bank_account->bank_name }}</td>
                        <td>{{ $income->note }}</td>
                        <td>
                            {{ number_format($income->sum, 2, ",", " ") }}
                            @if( $income->sum != $transfers_sum )
                                <br><a class="d-inline-block p-1 px-2 mt-1 rounded bg-danger text-white text-uppercase text-decoration-none" href="{{ route('kartoteka.nepotvrdene-prijmy.edit', [$income->id]) }}"><small>Peniaze na ceste</small></a>
                            @endif
                        </td>
                        <td>
                            <ul class="m-0">
                            @foreach($income->transfers as $transfer)
                                <li>
                                    @if($transfer->periodical_publication_id)
                                        @foreach( $periodicals as $p )
                                            {{ $transfer->periodical_publication_id===$p->id ? $p->name : "" }}
                                        @endforeach
                                    @else
                                        @foreach( $nonperiodicals as $p )
                                            {{ $transfer->nonperiodical_publication_id===$p->id ? $p->name : "" }}
                                        @endforeach
                                    @endif

                                    <span class="text-secondary">{{ number_format($transfer->sum, 2, ",", " ") }} €</span>
                                </li>
                            @endforeach
                            </ul>
                        </td>
                        <td class="text-center"><a href="{{ route('kartoteka.nepotvrdene-prijmy.edit', [$income->id]) }}">
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
                            <a class="" data-id="{{ $income->id }}" data-bs-toggle="modal" data-bs-target="#deleteIncomeModal" href="javascript:void(0);">
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
        </div><!-- / .col-lg-5 -->
    </div><!-- / .row -->

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- ----------------------------------- -->
    <!-- FILL DELETE MODAL WITH DYNAMIC DATA -->
    <!-- ----------------------------------- -->
    <script>
        $(document).ready(function(){
            $(document).on("click", ".js-delete-income", function(){
                let id = $(this).attr("data-id");

                $(".js-confirm-delete").attr("data-id", id);
            });

            $(document).on("click", ".js-confirm-delete", function(){
                let id = $(this).attr("data-id");
                let token = $("meta[name='csrf-token']").attr("content");

                $.ajax({
                    url: "/kartoteka/nepotvrdene-prijmy/" + id,
                    type: 'DELETE',
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
    <div class="modal fade" id="deleteIncomeModal" tabindex="-1" aria-labelledby="deleteIncomeModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Potvrďte vymazanie</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p>Naozaj chcete <strong>vymazať</strong> tento príjem so všetkými účelmi?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">zrušiť</button>
                    <button type="button" class="js-confirm-delete btn btn-danger" data-id="">vymazať</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
