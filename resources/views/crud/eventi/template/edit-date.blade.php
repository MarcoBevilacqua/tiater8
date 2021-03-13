<?php
/**
 * Created by PhpStorm.
 * User: marco.bevilacqua
 * Date: 23/01/2017
 * Time: 16:07
 */ ?>
{{Form::model($event, array('method' => 'PUT', 'route' => ['event.update', $event->id],  'class' => 'form form-horizontal'))}}
{{Form::hidden('show', $event->show_id)}}
{{Form::hidden('redirect', URL::current())}}
<div class="col-lg-6 col-md-12 col-sm-12">
    <div class="inner-container" id="#dp-container">
        <div id="dp-embed" data-date="{{date('d/m/Y', strtotime($event->show_date))}}"></div>
        {{Form::hidden('data[]', date('d/m/Y', strtotime($event->show_date)), array('id' => 'data'))}}
    </div>
</div>
<div class="col-lg-6 col-md-12 col-sm-12">
    <div class="form-group text-left">
        <h5 class="tiater-form-heading">Orario</h5>
        <div class="col-xs-6">
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
                {{Form::select('ora[]',
                array(19 => "Diciannove", 20 => "Venti", 21 => "Ventuno"),
                date('H', strtotime($event->show_date)), ['class' => 'form-control'])
                }}
            </div>
        </div>
        <div class="col-xs-6">
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-clock-o"></i> </div>
                {{Form::select('minuti[]',
                    array(00 => "", 30 => "e trenta", 45 => "e quarantacinque"),
                    date('i', strtotime($event->show_date)), ['class' => 'form-control'])
                }}
            </div>
        </div>
    </div>
    <!-- POSTI -->
    <div class="form-group text-left">
        <h5 class="tiater-form-heading">Posti</h5>
        <div class="col-xs-6">
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-star"></i> </div>
                {{ Form::text('full_price_qnt', $event->full_price_qnt, array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="col-xs-6">
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-star-half-full"></i> </div>
                {{ Form::text('half_price_qnt', $event->half_price_qnt, array('class' => 'form-control')) }}
            </div>
        </div>
    </div>
    <div class="form-group text-left">
        <h5 class="tiater-form-heading">Prezzi</h5>
        <div class="col-xs-6">
            <div class="input-group">
                <div class="input-group-addon">Prezzo pieno</div>
                {{ Form::text('full_price', $event->full_price, array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="col-xs-6">
            <div class="input-group">
                <div class="input-group-addon">Prezzo ridotto</div>
                {{ Form::text('half_price', $event->half_price, array('class' => 'form-control')) }}
            </div>
        </div>
    </div>
</div>

