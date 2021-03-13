<?php
/**
 * Created by PhpStorm.
 * User: Mare
 * Date: 02/12/2016
 * Time: 21:42
 */ ?>

<div id="{{$show->id}}" class="col-lg-3 col-md-6 col-sm-12 show-container">
    <div class="inner-container">
        <div class="show-title">
            <h1>{{$show->name}}</h1>
            @if($show->getEvents()->count() > 0)
                <small class="show-places">Un evento disponibile</small>
                @elseif($show->getEvents()->count() > 1)
                <small class="show-places">{{$show->getEvents()->count()}} eventi disponibili</small>
                @elseif($show->getEvents()->count() == 0)
                <small class="show-places">Nessun evento disponibile.<a href="{{URL::to('event/create')}}"> Aggiungi</a></small>
            @endif
        </div>
        <div class="show-image-container no-padding">
            <img class="img-responsive" src="{{"/public/img/360x480/" . $show->image}}">
        </div>
        <div class="show-tools col-sm-12 no-padding">
            <div class="show-tools-item col-sm-6 no-padding">
                <a title="date previste" class="show-url btn btn-sm btn-tiater" href="{{URL::to("/show") . "/" . $show->url}}">
                    <i class="fa fa-pencil" title="modifica"></i>
                    Date
                </a>
            </div>
            <div class="show-tools-item col-sm-6 no-padding">
                <a title="prenotazioni" class="show-url btn btn-sm btn-tiater" href="{{URL::to("/book/get/list"). "/" . $show->url}}">
                    <i class="fa fa-ticket" title="modifica"></i>
                    prenotazioni
                </a>
            </div>
        </div>
    </div>
</div>
