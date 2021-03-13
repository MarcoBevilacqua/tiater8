@extends("admin.inner-admin-layout")

@section("content")
    <div id="page-wrapper">
        <div class="row">
            <div class="page-header text-center">
                {{ Html::ul($errors->all()) }}
                <h2>Nuovo spettacolo</h2>
            </div>
        </div>
        <div class="col-lg-12">
            {{Form::model('show', array('route' => array('show.store'), 'method' => 'POST', 'files' => TRUE)) }}
            <div class="form-group">
                <div class="col-lg-5">
                    <div class="col-lg-12">
                        <figure style="width:360px;height:480px;background-color: #cccccc">
                            <span class="btn btn-default btn-file">
                                Carica file
                            {{ Form::file('image', array('class' => 'form-control')) }}
                            </span>
                        </figure>

                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="form-group tiater-form-group">
                        <h5>Info Generali</h5>
                        <div class="col-lg-9">
                            {{ Form::label('name', 'Nome') }}
                            {{ Form::text('name', "", array('class' => 'form-control')) }}
                        </div>
                        <div class="col-lg-11">
                            {{ Form::label('description', 'Descrizione') }}
                            {{ Form::textarea('description', "", array('class' => 'form-control', 'rows' => '5')) }}
                        </div>
                    </div>
                    <div class="col-lg-4">
                        {{ Form::label('places', 'Posti') }}
                        {{ Form::text('places', null , array('class' => 'form-control input-small')) }}
                    </div>
                    <div class="form-group col-lg-4">
                        {{ Form::label('full_price', 'Prezzo Intero') }}
                        {{ Form::text('full_price', null, array('class' => 'form-control')) }}
                    </div>
                    <div class="form-group col-lg-4">
                        {{ Form::label('half_price', 'Prezzo Ridotto') }}
                        {{ Form::text('half_price', null, array('class' => 'form-control')) }}
                    </div>
                    <div class="form-group col-lg-4">
                        {{ Form::label('full_price_qnt', 'Posti a prezzo Intero') }}
                        {{ Form::text('full_price_qnt', null, array('class' => 'form-control')) }}
                    </div>
                    <div class="form-group col-lg-4">
                        {{ Form::label('half_price_qnt', 'Posti a prezzo Ridotto') }}
                        {{ Form::text('half_price_qnt', null, array('class' => 'form-control')) }}
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group col-lg-12 text-center">
                        <ul class="list-inline">
                            <li><a href="{{URL::to("show")}}" class="btn btn-default">Annulla</a></li>
                            <li>{{ Form::submit('Salva', array('class' => 'btn btn-primary')) }}
                                {{ Form::close() }}
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{URL::asset('javascripts/spettacoli/script.js')}}"></script>
    <script type="text/javascript">

        $('#add-data').on('click', insertRow);

        $('.data-remove').on('submit', function (e) {
            e.preventDefault();
            asyncSubmitForm(this);
            //console.log($(this).attr('action')+ " " + $(this).attr('method'));
        });
    </script>
@stop