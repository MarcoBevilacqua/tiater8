<?php
/**
 * Created by PhpStorm.
 * User: marco.bevilacqua
 * Date: 29/11/2016
 * Time: 16:19
 */
?>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="height: 130px;;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="text-center">
                    <h3 class="modal-title" id="myModalLabel">Nuova iscrizione</h3>
                </div>
            </div>
            <div class="modal-body">
                {{ Form::open(array(
                    'url' => 'viewer',
                    'id' => 'remote-save-user',
                    'method' => 'POST'))
                }}
                <div class="text-center row">
                    <div class="form-group col-md-offset-2 col-md-8">
                        {{ Form::text('first_name', null, array(
                        'class'         => 'form-control text-center',
                        'placeholder'   => 'Nome'
                        )) }}
                    </div>
                    <div class="form-group col-md-offset-2 col-md-8">
                        {{ Form::text('last_name', null, array(
                        'class'         => 'form-control text-center',
                        'placeholder'   => 'Cognome'
                        )) }}
                    </div>
                    <div class="form-group col-md-offset-2 col-md-8">
                        {{ Form::text('email', "", array(
                            'class'         => 'form-control text-center',
                            'placeholder'   => 'indirizzo email')) }}
                    </div>
                    {{Form::hidden('remote', true)}}
                </div>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    {{ Form::submit('Salva', array('class' => 'btn btn-primary btn-lg')) }}
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>