<?php
/**
 * Created by PhpStorm.
 * User: marco.bevilacqua
 * Date: 06/12/2016
 * Time: 12:08
 */ ?>

<div id="div-{{$key}}" class="viewer col-lg-3 col-md-6 col-sm-6 col-xs-6">
    <div class="inner">
        <div class="info-primary">
            <i class="fa fa-2x fa-user pull-left"></i>
            <p class="name">{{$viewer->full_name}}</p>
            <span class="email">{{$viewer->email}}</span>
        </div>
        <div class="info-quota bg-{{$viewer->class}} text-center">
            @if($viewer->class == 'success')
                <p class="lead" data-background-icon="&#xf058">{{$viewer->quota}}</p>
                @else
                <p class="lead" data-background-icon="&#xf06a">{{$viewer->quota}}</p>
            @endif
        </div>
        <div class="info-support">
            <p>Data iscrizione: {{$viewer->sign_date}}</p>
            <p>Telefono: {{$viewer->phone}}</p>
        </div>
        <div class="action-container text-right">
            <a class="" href="{{URL::to("viewer") . "/" . $viewer->id . "/edit" }}">modifica</a>
        </div>
    </div>

</div>
