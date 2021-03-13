<?php
/**
 * Created by PhpStorm.
 * User: marco.bevilacqua
 * Date: 23/01/2017
 * Time: 16:05
 */ ?>

<div class="col-lg-3 text-center no-padding">
    <div class="event-show-date inner-container single-item-container">
        <div class="event-show-info">
            <h4>{{date("d-m-Y", strtotime($event->show_date))}}</h4>
            <small>{{date("H:i", strtotime($event->show_date))}}</small>
        </div>
        <div class="bottom-tools no-padding col-lg-12">
            <div class="bottom-tools-item col-lg-6">
                <a href="{{URL::to('event/' . $event->id . '/edit')}}" class="btn btn-link">
                    <i class="fa fa-edit"></i>
                    Modifica
                </a>
            </div>
            <div class="bottom-tools-item col-lg-6">
                {{Form::open([
                'method' => 'DELETE',
                'route' => ['event.destroy' , $event->id],
                'class' => 'no-margin'])}}
                {{ Form::button('<i class="fa fa-times-circle"></i> Elimina',
                    array('type' => 'submit', 'class' => 'btn btn-md btn-link'))}}
                {{Form::close() }}
            </div>
        </div>
    </div>
</div>