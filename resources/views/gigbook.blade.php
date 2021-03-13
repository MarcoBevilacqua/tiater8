@extends("admin/admin-layout")

@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="page-header">
            <h1>{{$gig->nome}} / prenota<br />
                <small><?php echo (count($gig->eventi) > 1 ) ?
                count($gig->eventi).' date disponibili' :
                'una data disponibile' ; ?>
                </small>
            </h1>
        </div>
    </div>

    <div class="form-group col-lg-4">
        <img src="{{URL::to('/').'/archive/'.$gig->immagine}}" class="img-responsive img-thumbnail" />
    </div>

        <div class="col-lg-6">
            <!-- apertura form -->
            {{Form::open(array('url' => 'book/confirm', 'class' => 'form form-horizontal')) }}
            {{Form::hidden('gig', $gig->id)}}

            <div class="form-group">
                {{Form::Label('date', 'Data', array('class' => 'col-sm-2 control-label'))}}
                <div class="col-sm-5">
                    <select autocomplete="off" name="data_spettacolo" id="data_spettacolo"
                    class="form-control" data-ref="{{URL::to('/').'/api/events/avail'}}">
                        <option value="" selected>Nessuna data</option>
                        @foreach($gig->eventi as $d)
                            <option value="<?php echo $d->id ?>">
                                {{date('d/m/Y H:m', strtotime($d->data_spettacolo)); }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4 text-center">
                    <h5 id="posti"><em>Posti disponibili:</em> <b>--</b></h5>
                </div>
            </div>
            <!-- SPETTATORI -->
            <div class="form-group">
                {{Form::hidden('spettatore_id', '', array('id' => 'spettatore_id'))}}

                {{Form::Label('spettatori', 'Spettatori', array('class' => 'col-sm-2 control-label'))}}
                <div class="col-sm-8">
                    {{Form::text('spettatore', '',
                    array(
                        'id' => 'spettatori-autocomplete',
                        'class' => 'form-control',
                        'data-ref' => URL::to('/') .'/api/users/search',
                        'autocomplete' => 'off'))
                    }}
                </div>
                <div class="col-sm-2">
                    <!-- trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">crea nuovo</button>
                </div>
            </div>
            <!-- Biglietti interi/ridotti -->
            <div class="form-group">
                <label for="interi" class="col-sm-2 control-label">Interi</label>
                <div class="col-sm-3">
                    <select name="interi" class="form-control" autocomplete="off">
                        <option value="0" selected="selected">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </div>
                <label for="ridotti" class="col-sm-2 control-label">Ridotti</label>
                <div class="col-sm-3">
                    <select name="ridotti" class="form-control" autocomplete="off">
                        <option value="0" selected="selected">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </div>
            </div>

            <!-- check pagamento -->
            <div class="form-group">
            <label for="pagato" class="col-sm-2 control-label">Cod.Posto</label>
            <div class="col-sm-3">
                {{Form::text('Cod.posto', '',
                    array(
                        'name' => 'cod_posto',
                        'class' => 'form-control',
                        'data-ref' => URL::to('/') .'/api/users/search',
                        'autocomplete' => 'off'))
                }}
            </div>
            <label for="pagato" class="col-sm-2 control-label">Pagato</label>
                <div class="col-sm-4 checkbox">
                    {{Form::checkbox('pagato', 'S');}}
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                <div class="space-60" style="height: 80px;width:100%;"></div>
                <a href="{{URL::to('spettacoli')}}" class="btn btn-default">Annulla</a>
                <button type="submit" class="btn btn-primary">Prenota</button>
            </div>

        </div>
        {{ Form::close()}}


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuova iscrizione</h4>
      </div>
      <div class="modal-body">
        {{ Form::open(array('url' => 'spettatori', 'id' => 'remote-save-user', 'data-ref' => URL::to('/').'/api/users/save')) }}

        <div class="form-group">
            {{ Form::label('nome', 'Nome') }}
            {{ Form::text('nome', Input::old('nome'), array('class' => 'form-control col-lg-4')) }}
        </div>
        <div class="form-group">
            {{ Form::label('email', 'Email') }}
            {{ Form::text('email', "", array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('telefono', 'Numero di telefono') }}
            {{ Form::text('telefono', "", array('class' => 'form-control')) }}
        </div>

      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal" id="modal-close">Chiudi</button>
        {{ Form::submit('Salva', array('class' => 'btn btn-primary')) }}
      </div>
      {{ Form::close() }}
    </div>
  </div>
</div>
</div>

<link rel="stylesheet" href="{{ URL::asset('stylesheets/jquery-ui.min.css') }}" >
<script type="text/javascript" src="{{ URL::asset('javascripts/jquery-ui.min.js')}}"></script>

<script type="text/javascript">

    var _href = $('#spettatori-autocomplete').data('ref');
    $('#spettatori-autocomplete').autocomplete({
        source: function(request, response){

            $.ajax({
                url: _href,
                type: 'GET',
                data: request,
                success:function(data){
                    //var _data = $.parseJSON(data[0]);
                    response(

                        $.map(data, function(item){
                            var s = [];
                            var __label = '<span>'+item.nome+'<br /><small> '+item.email+'</small></span>';
                            s.push({name: item.nome, label:__label, value: item.id});
                            return s;
                        })
                    );
                }
            });// end AJAX

        },
        minLength: 3,
        select:function(event, ui){
            //console.log(ui);
            $(this).val(ui.item.name);
            $('input[name="spettatore_id"]').val(ui.item.value);

            return false;
        },
        open:function(){
            $(this).data("uiAutocomplete").menu.element.addClass("custom-autocomplete");
        }

    }).data("ui-autocomplete")._renderItem = function(ul, item){
                  return $('<li></li>')
                  .data('item.autocomplete', item)
                  .append(item.label)
                  .appendTo(ul);
              };

        $('#data_spettacolo').on('change', function(){

            var eventId = $(this).val();
            var url = $(this).data('ref');

                $.ajax({
                    url:url,
                    type: 'GET',
                    dataType: 'JSON',
                    data:{'ev_id':eventId},
                    success:function(data){
                        //console.log(data);
                        $('#posti b').html(data[0].qnt);
                    },
                    error:function(err, text, obj){
                        console.log(text);
                    }
                });

        });

        $('#remote-save-user').submit(function(evt){
            evt.preventDefault();

            var _url = $(this).data('ref');

            $.ajax({
                url:_url,
                data:$(this).serialize(),
                type:'POST',
                success:function(data){
                    if(data.success){
                        //console.log(data);
                        $('.modal-body').html('<h2>Utente Registrato Correttamente</h2>');
                        //$('#modal-close').trigger('click');
                    }
                }
            });

        }); //end submit

</script>

@stop


