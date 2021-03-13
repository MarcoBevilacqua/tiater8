@extends("admin/admin-layout")

@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="page-header">
            <h1>Prenota</h1>
        </div>
    </div>
    <!-- apertura form -->
    {{Form::open(array('url' => 'book/confirm', 'class' => 'form form-horizontal')) }}
    {{Form::hidden('gig')}}
    <div class="col-lg-4">
    <table class="table table-condensed table-responsive">
        <thead>
            <th colspan="2"><h4>Spettacoli disponibili</h4></th>
        </thead>
        <tbody>
            @foreach($gigs as $gig)
            <tr class="clickable" data-show="{{$gig->id}}">
                <td class="vert-align">{{$gig->nome}}</td>
                <td><i class="fa fa-angle-double-right fa-2x"></i></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    <div class="col-lg-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5>Impostazioni</h5>
            </div>
            <div class="panel-body">

                <!-- start date -->
                <div class="form-group">
                    {{Form::Label('date', 'Data', array('class' => 'col-sm-2 control-label'))}}
                    <div class="col-sm-5">
                        <select autocomplete="off" name="data_spettacolo" id="data_spettacolo"
                        class="form-control" data-ref="{{URL::to('/').'/api/events/avail'}}">
                            <option value="" selected>Nessuna data</option>
                        </select>
                    </div>
                    <div class="col-sm-4 text-center">
                        <h5 id="posti"><em>Posti disponibili:</em> <b>--</b></h5>
                    </div>
                </div>
                <!-- end date -->
                <!-- SPETTATORI -->
                <div class="form-group">
                    {{Form::hidden('spettatore_id', '', array('id' => 'spettatore_id'))}}

                    {{Form::Label('spettatori', 'Spettatori', array('class' => 'col-sm-2 control-label'))}}
                    <div class="col-sm-6">
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
                <!-- END Spettatori -->
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
                <!-- END BIGLIETTI -->
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
                    <div class="col-sm-2 checkbox">
                        <select name="pagato" class="form-control" autocomplete="off">
                            <option value="0" selected="selected">No</option>
                            <option value="1">Sì</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 text-center">
        <div class="space-60" style="height: 80px;width:100%;"></div>
        <a href="{{URL::to('spettacoli')}}" class="btn btn-default">Annulla</a>
        <button type="submit" class="btn btn-primary">Prenota</button>
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
<script type="text/javascript" src="{{ URL::asset('javascripts/book/book.js')}}"></script>

@stop


