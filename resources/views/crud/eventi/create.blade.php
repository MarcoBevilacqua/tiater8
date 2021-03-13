@extends('admin.inner-admin-layout')

@section('content')
<script type="text/javascript" src="{{ URL::asset('javascripts/bootstrap-datepicker.js')}}"></script>
<link rel="stylesheet" href="{{ URL::asset('stylesheets/datepicker.css') }}" >
<div id="page-wrapper">
    <div class="row">
        <div class="page-header">
            <h1>Aggiungi date</h1>
        </div>
    </div>
    <div class="alert">
        @if(count($errors) > 0)
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </div>
    {{Form::open(array('url' => 'event/add', 'class' => 'form form-horizontal'))}}
    <!-- COLLAPSE -->
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <!-- SPETTACOLO COLLAPSE -->
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <h4>Spettacolo</h4>
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <div class="col-lg-6 col-md-6 col-xs-6">
                        <select id="show" name="show"
                                autocomplete="off"
                                class="form-control"
                                data-url-target="{{URL::to('api/event-for-show/')}}">
                            <option value="" selected> --- </option>
                            @foreach(Show::all() as $gig)
                                <option value="{{$gig->id}}">{{$gig->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- COLLAPSE -->
                    <div class="col-lg-6 col-md-6 col-xs-6 text-right">
                        <a href="#" class="btn btn-success close-panel" data-target="#collapseTwo">
                            Inserisci date
                            <i class="fa fa-check-circle" title="OK"></i>
                        </a>
                    </div>
                    <!-- /COLLAPSE -->
                </div>
            </div>
        </div>
        <!-- /SPETTACOLO COLLAPSE -->
        <!-- DATE COLLAPSE -->
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingTwo">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <h4>Date</h4>
                    </a>
                </h4>
            </div>
            <!-- PANEL TWO -->
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                <!-- PANEL BODY -->
                <div class="panel-body">
                    <!-- FORM GROUP -->
                    <div class="form-group col-lg-12 colmd-12 col-sm-12 date-to-clone">
                        <!-- INSERT DATA -->
                        <div class="to-clone">
                            <div class="col-xs-3 col-xs-offset-1">
                                {{ Form::label('data[]', 'Data') }}
                                {{ Form::text('data[]',  null, array(
                                'class' => 'form-control input-datepicker text-center',
                                'placeholder' => 'dd/mm/aaaa')
                                )}}
                            </div>
                            <div class="col-xs-2">
                                {{ Form::label('ora[]', 'Ora') }}
                                {{Form::select('ora[]', array(19 => "19", 20 => "20", 21 => "21"), null, ['class' => 'form-control'])}}
                            </div>
                            <div class="col-xs-2">
                                {{ Form::label('minuti[]', 'Minuti') }}
                                {{Form::select('minuti[]', array(00 => "00", 30 => "30", 45 => "45"), null, ['class' => 'form-control'])}}
                            </div>
                            <!-- ADD DATA BUTTON -->
                            <div class="col-xs-4 text-center lg-icon">
                                <a href="#" class="btn btn-default add-data-evento">Aggiungi data
                                    <i class="fa fa-plus-circle" title="aggiungi data"></i>
                                </a>
                            </div>
                            <!-- /ADD DATA BUTTON -->
                        </div>
                        <!-- /INSERT DATA -->

                    </div>
                    <!-- /FORM GROUP -->
                    <!-- COLLAPSE -->
                    <div class="col-lg-12 col-md-12 col-xs-12 text-center">
                        <a href="#" class="btn btn-success close-panel" data-target="#collapseThree">
                            Inserisci posti
                            <i class="fa fa-check-circle" title="OK"></i>
                        </a>
                    </div>
                    <!-- /COLLAPSE -->
                </div>
            </div>
            <!-- /PANEL TWO -->
        </div>
        <!-- /DATE COLLAPSE -->
        <!-- PLACES COLLAPSE -->
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingThree">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseTwo">
                        <h4>Posti</h4>
                    </a>
                </h4>
            </div>
            <!-- PANEL TWO -->
            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                <!-- PANEL BODY -->
                <div class="panel-body">
                    <!-- FORM GROUP -->
                    <div class="form-group col-lg-12 colmd-12 col-sm-12">
                        <div class="col-lg-6">
                            {{Form::label('full_price', 'Posti a prezzo pieno')}}
                            {{Form::text('full_price', "", ['class' => 'form-control'])}}
                        </div>
                        <div class="col-lg-6">
                            {{Form::label('half_price', 'Posti a prezzo ridotto')}}
                            {{Form::text('half_price', "", ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <!-- /FORM GROUP -->
                </div>
            </div>
            <!-- /PANEL TWO -->
        </div>
        <!-- /PLACES COLLAPSE -->
    </div>
    <!-- /COLLAPSE -->
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 text-center">
            <a class="btn btn-default" href="{{URL::to("/")}}">Annulla</a>
            {{ Form::submit('Salva', array('class' => 'btn btn-primary')) }}
        </div>
    </div>
    {{ Form::close() }}

    @include('helper.eventsForShow')
</div>
    <script type="text/javascript" src="{{URL::asset('javascripts/spettacoli/script.js')}}"></script>
    <script type="text/javascript">

        var maxDate = 7;

    $(document).ready(function(){

        /**
         * "Next step" buttons click
         */
        $('.close-panel').on('click', function (e){

            //prevent default action
            e.preventDefault();

            //current panel
            var $current = '#' + $(this).closest('.panel-collapse').attr('id'),
                    $next = $(this).data('target');

            //close current panel and show next
            $($current + ", " + $next).collapse('toggle');
        });

        $('#show').on('change', function () {
            eventForShow($(this).val(), $(this).data('url-target'));
        });

        //inizializzo il datepicker al load della pagina
        $('.input-datepicker').datepicker({
            format: 'dd/mm/yyyy',
            startDate: Date.now()
        })
        //tweak: l'opzione 'autoclose' sembra non funzionare
                .on('changeDate', function(){
                    $(this).datepicker('hide');
                });

        //listener on add-event click
        $('.add-data-evento').on('click', function(e){
            addEvent(e);
        });
    });

    $('__form').on('submit', function(e){
        e.preventDefault();

        //vars
        $dates = [],
                $full_price = $('[name="full_price"]').val(),
                $half_price = $('[name="half_price"]').val();

        $.each($('.to-clone'), function(i, el){
            //console.log(el);

            $el = $(el);
            $dates.push({
                date    : $el.find('[name="data[]"]').val(),
                hour    : $el.find('[name="ora[]"]').val(),
                minutes : $el.find('[name="minuti[]"]').val()
            });
        });

        $data = {
            show_id : $('#show').val(),
            dates   : $dates,
            full_price : $full_price,
            half_price : $half_price
        };

        asyncSubmitForm($(this), $data);

    });

</script>

@stop
