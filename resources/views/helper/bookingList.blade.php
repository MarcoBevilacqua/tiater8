@extends("admin.inner-admin-layout")
@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="page-header text-center">
                <h2 class="no-margin">Prenotazioni</h2>
                <small><a href="{{URL::to('book/create')}}">Aggiungi nuova</a> </small>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                <div class="col-lg-4">
                    <div class="col-lg-6">
                        <label for="select-event" class="select-event-label">Scegli Data Prenotazione: </label>
                    </div>
                    <div class="col-lg-6">
                    <select id="event-select" class="form-control" data-ref="{{URL::to('/book/list/print')}}">
                        @foreach($events as $event)
                            <option id="event-select-{{$event->id}}" value="{{$event->id}}">{{$event->show_date}}</option>
                        @endforeach
                    </select>
                    <div class="progress tiater-progress">
                        <div class="progress-bar tiater-progress-bar active" role="progressbar" aria-valuenow="0"
                             aria-valuemin="0" aria-valuemax="100" style="width: 45%">
                            <span class="sr-only">5% Complete</span>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
        <div class="waiting hidden">
            <div class="jumbotron text-center">
                <i class="fa fa-spinner fa-spin fa-5x"></i>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Codice</th>
                            <th>Qnt</th>
                            <th>Saldo</th>
                            <th class="text-right">Totale</th>
                        </tr>
                    </thead>
                    <tbody id="show-result">
                    </tbody>
                </table>
                <!-- TOTALS -->
                <div class="row hidden" id="totals">
                    <div class="container-fluid">
                        <div class="col-sm-12 col-md-6 ool-lg-6 text-right">
                            <h5 id="booking-total"></h5>
                        </div>
                        <div class="col-sm-12 col-md-6 ool-lg-6 text-left">
                            <button type="button" class="btn btn-sm btn-tiater" onclick="window.print()">
                                Stampa lista <i class="fa fa-print"></i>
                            </button>
                        </div>
                    </div>

                </div>
                <!-- //TOTALS -->
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{URL::asset('javascripts/book/book.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#event-select').on('change', getBookingList);
            //first call on doc.ready
            getBookingList();
        });
    </script>
@stop