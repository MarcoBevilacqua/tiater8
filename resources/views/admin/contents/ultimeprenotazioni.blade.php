<div class="panel panel-default">
    <div class="panel-heading">
        <i class="fa fa-clock-o fa-fw"></i> Ultime prenotazioni
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
        @if(count($bookings) > 0)
        <div class="list-group">
            @foreach($bookings as $booking)
            <div class="list-group-item" style="min-height: 60px;">
                <div class="col-lg-2 text-center book-count">
                    <h3>{{$booking->total_qnt}}</h3>
                    <small class="text-uppercase"><b>posti</b></small>
                </div>
                <div class="col-lg-9">
                    <ul class="list-unstyled">
                        <li>
                            <strong>{{\App\Models\Viewer::find($booking->viewer_id)->first_name}}
                                {{\App\Models\Viewer::find($booking->viewer_id)->last_name}}
                            </strong>
                        </li>
                        <li>
                            <span>
                                <small>(
                                    
                                    )</small>
                            </span>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-1 book-edit">
                    <div class="book-edit-child">
                    <a href="{{URL::to('book/'.$booking->public_code.'/edit')}}" title="edit">
                        <i class="fa fa-2x fa-ellipsis-h"></i>
                    </a>
                    </div>
                    {{--
                    <div class="text-right">
                        <ul class="list-inline">
                            <li>
                            <i class="fa fa-2x fa-{{($booking->paid)
                                    ? 'check-circle" title="saldato" style="color:green"'
                                    : 'exclamation-circle" title="da saldare" style="color:red"'}}"></i>
                            </li>
                            <li>
                                <a href="{{URL::to('book/'.$booking->id.'/edit')}}" style="color:#000000;">
                                    <i class="fa fa-2x fa-pencil"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    --}}
                </div>
            </div>
            @endforeach
        </div>
        <!-- /.list-group -->
        <div class="col-lg-12 text-center">
            <a href="{{URL::to('book')}}" class="btn btn-default"><i class="fa fa-list"></i> Tutte le prenotazioni</a>
            <a href="{{URL::to('book/create')}}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Aggiungi prenotazione</a>
        </div>

        @else
            <h4 class="text-center">Nessuna prenotazione <br /><small><a href="{{URL::to('shows/book')}}">Aggiungi</a></small></h4>
        @endif
    </div>
    <!-- /.panel-body -->
</div>