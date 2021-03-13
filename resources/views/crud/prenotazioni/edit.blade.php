@extends("admin.inner-admin-layout")

@section("content")
    <?php
    $viewer = Viewer::find($booking->viewer_id);
            ?>
<div id="page-wrapper">
    <div class="row">
        <div class="page-header text-center">
            <h3>Modifica prenotazione</h3>
        </div>
    </div>
    <div class="row" style="margin-bottom: 30px;">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="col-lg-6 col-md-5 col-sm-5 booking-viewer-name text-right">
                <h3>{{$viewer->full_name}}</h3>
                <span>{{$viewer->email}}</span>
            </div>
            <div class="col-lg-6 col-md-5 col-sm-5 booking-viewer-name">
                <h3>{{Show::find($booking->show_id)->name}}</h3>
                <span>prenotato il {{date('d MONTH Y', strtotime($booking->booking_date))}}
                 alle {{date('H:i', strtotime($booking->booking_date))}}</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-12 col-md-12 col-sm-12">
            {{ Form::model($booking, array('route' => array('book.update', $booking->public_code), 'method' => 'PUT')) }}
            <!-- EVENTS -->
            <div class="col-lg-4 form-section-heading-container">
                <h3 class="form-section-heading">Data spettacolo</h3>
                    <div class="form-section-content">
                        {{Form::hidden('event_id'), $booking->event_id, array('id' => 'event-id')}}
                        @foreach($events as $event)
                            <div class="col-lg-3 col-md-3 text-center form-section-content-select {{($event->id == $booking->event_id) ? 'select-alt-selected' : ''}} select-alt" data-ev="{{$event->id}}" data-booking="{{$booking->event_id}}">
                                <div>
                                <h4 data-value="{{$event->id}}">
                                    {{date('d/m/Y', strtotime($event->show_date))}}
                                </h4>
                                <h5>{{date('H:i', strtotime($event->show_date))}}</h5>
                                    <h5>{{$event->full_price_qnt + $event->half_price_qnt}} <small>posti disponibili</small></h5>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            <!-- //EVENTS -->
            <!-- PLACES -->
            <div class="col-lg-4 form-section-heading-container">
                <h3 class="form-section-heading text-center">Posti Prenotati</h3>
                <div class="form-section-content col-lg-6 col-lg-offset-3">
                    <div class="form-group">
                        {{Form::label('full_price_qnt', 'Interi', array('class' => 'control-label'))}}
                        {{Form::text('full_price_qnt', ($booking->full_price_qnt), array('class' => 'form-control'))}}
                    </div>
                    <div class="form-group">
                        {{Form::label('half_price_qnt', 'Ridotti', array('class' => 'control-label'))}}
                        {{Form::text('half_price_qnt', ($booking->half_price_qnt), array('class' => 'form-control'))}}
                    </div>
                    <div class="input-group">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-default" aria-label="-">
                                <i class="fa fa-minus-circle"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control" />
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-default" aria-label="+">
                                <i class="fa fa-plus-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //PLACES -->
            <!-- PAID -->
            <div class="col-lg-4 form-section-heading-container">
                <h3 class="form-section-heading text-center">Info aggiuntive</h3>
                <div class="form-section-content col-lg-8 col-lg-offset-2">
                    <div class="form-group">
                        {{Form::label('paid', 'Saldo', array('class' => 'control-label'))}}
                        {{Form::select('paid', [1 => 'saldato', 0 => 'da saldare'], $booking->paid, array('class' => 'form-control'))}}
                    </div>
                    <div class="form-group">
                        {{Form::label('place_code', 'Codice Posto')}}
                        {{Form::text('place_code', $booking->place_code, array('class' => 'form-control'))}}
                    </div>
                </div>
            </div>
            <!-- //PAID -->
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 text-center">
        <ul class="list-inline">
            <li>
                <a href="{{URL::to('book')}}" class="btn btn-default">Annulla</a>
            </li>
            <li>
                {{ Form::submit('Salva', array('class' => 'btn btn-primary')) }}
                {{ Form::close() }}
            </li>
            <li>
                {{Form::model(
$booking, array('route' => array('book.destroy', $booking->public_code), 'method' => 'DELETE'))}}
                {{ Form::submit('Cancella', array('class' => 'btn btn-danger')) }}
                {{Form::close()}}
            </li>
        </ul>



    </div>
</div>



<script type="text/javascript">

    $(document).ready(function(){
        $('.select-alt').on('click', eventSelect);
    });

    function eventSelect() {

        var $element = $(this);

        if(!$element){
            return false;
        }

        $element.addClass('select-alt-selected')
                .parent()
                .find('.select-alt')
                .not($element)
                .removeClass('select-alt-selected');

        $('[name="event_id"]').val($element.data('ev'));

    }
</script>
@stop