<?php
/**
 * Created by PhpStorm.
 * User: marco.bevilacqua
 * Date: 23/01/2017
 * Time: 16:07
 */ ?>
<div class="col-lg-6 col-md-12 col-sm-12">
    <div class="inner-container" id="#dp-container">
        <div id="dp-embed" data-date="17/01/2017"></div>
        {{Form::hidden('data[]', "", array('id' => 'data'))}}
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
                null, ['class' => 'form-control'])
                }}
            </div>
        </div>
        <div class="col-xs-6">
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-clock-o"></i> </div>
                {{Form::select('minuti[]',
                    array(00 => "", 30 => "e trenta", 45 => "e quarantacinque"),
                    array(00 => ""), ['class' => 'form-control'])
                }}
            </div>
        </div>
    </div>
    <!-- POSTI -->
    <div class="form-group text-left">
        <h5 class="tiater-form-heading">Posti</h5>
        <div class="col-xs-6">
            <div class="input-group">
                <div class="input-group-addon">Posti Interi</div>
                {{ Form::text('full_price', 0, array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="col-xs-6">
            <div class="input-group">
                <div class="input-group-addon">Posti Ridotti </div>
                {{ Form::text('half_price', 0, array('class' => 'form-control')) }}
            </div>
        </div>
    </div>
    <div class="form-group text-left">
        <h5 class="tiater-form-heading">Prezzi</h5>
        <div class="col-xs-6">
            <div class="input-group">
                <div class="input-group-addon">Prezzo pieno</div>
                {{ Form::text('full_price_qnt', 0, array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="col-xs-6">
            <div class="input-group">
                <div class="input-group-addon">Prezzo ridotto</div>
                {{ Form::text('half_price_qnt', 0, array('class' => 'form-control')) }}
            </div>
        </div>
    </div>
</div>

