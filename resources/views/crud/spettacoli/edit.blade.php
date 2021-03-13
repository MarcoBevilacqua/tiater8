@extends("admin.inner-admin-layout")

@section("content")
    <div id="page-wrapper">
        <div class="row text-center">
            <div class="page-header">
                {{ Html::ul($errors->all()) }}
                <h2>{{$show->name}} / Modifica</h2>
            </div>
        </div>
        <div class="container-fluid">
            {{Form::model($show, array('route' => array('show.update', $show->url), 'method' => 'PUT', 'files' => TRUE)) }}
        </div>

        <div class="row row-tiater">
            <div class="form-inner-container-col-lg-4">
                {{ Form::label('name', 'Nome', array('class' => 'form-label-custom tiater')) }}
                {{ Form::text('name', $show->name, array('class' => 'form-control form-control-custom tiater')) }}
            </div>
        </div>
        <div class="row row-tiater">
            {{ Form::label('description', 'Descrizione', array('class' => 'form-label-custom tiater')) }}
            {{ Form::textarea('description', $show->descrizione, array('class' => 'form-control form-control-custom tiater', 'rows' => '5')) }}
        </div>
        {{-- TODO: fix thumbnail --}}
        <div class="row row-tiater text-center">
            <figure>
                <img class="img-responsive img-thumbnail"
                     src="{{URL::asset('/img') . "/360x480/" . $show->image}}" alt="{{$show->name}}">
                <span class="btn btn-default btn-file hidden">Carica file
                    {{ Form::file('image', array('class' => 'form-control')) }}
                </span>
            </figure>
        </div>
        {{-- TODO: fix thumbnail --}}
        <div class="row row-tiater">
            <div class="form-inner-container col-lg-4">
                {{ Form::label('url', 'Url', array('class' => 'form-label-custom tiater')) }}
                {{ Form::text('url', $show->url, array('class' => 'form-control form-control-custom tiater')) }}
            </div>
            <div class="form-inner-container col-lg-4">
                {{ Form::label('full_price', 'Prezzo Intero', array('class' => 'form-label-custom tiater')) }}
                {{ Form::text('full_price', $show->prezzo_intero, array('class' => 'form-control form-control-custom tiater')) }}
            </div>
            <div class="form-inner-container col-lg-4">
                {{ Form::label('half_price', 'Prezzo Ridotto', array('class' => 'form-label-custom tiater')) }}
                {{ Form::text('half_price', $show->prezzo_ridotto, array('class' => 'form-control form-control-custom tiater')) }}
            </div>
        </div>
        <div class="row row-tiater">
            <div class="form-inner-container col-lg-4">
                {{ Form::label('places', 'Posti',array('class' => 'form-label-custom tiater'))}}
                {{ Form::text('places', $show->posti, array('class' => 'form-control form-control-custom tiater')) }}
            </div>
            <div class="form-inner-container col-lg-4">
                {{ Form::label('full_price_qnt', 'Posti a prezzo Intero', array('class' => 'form-label-custom tiater')) }}
                {{ Form::text('full_price_qnt', $show->full_price_qnt, array('class' => 'form-control form-control-custom tiater')) }}
            </div>
            <div class="form-inner-container col-lg-4">
                {{ Form::label('half_price_qnt', 'Posti a prezzo Ridotto', array('class' => 'form-label-custom tiater')) }}
                {{ Form::text('half_price_qnt', $show->half_price_qnt, array('class' => 'form-control form-control-custom tiater')) }}
            </div>
        </div>
        {{-- TODO: fix buttons alignment --}}
        <div class="row row-tiater">
            <div class="form-inner-container form-control-custom form-submit-container text-center">
                <div class="form-group col-lg-12 text-center">
                    <a href="{{URL::to("show")}}" class="btn btn-default">Annulla</a></li>
                        {{ Form::submit('Salva', array('class' => 'btn btn-primary')) }}
                    {{ Form::close() }}
                    {{Form::model($show, array('route' => array('show.destroy', $show->url), 'method' => 'DELETE'))}}
                    {{ Form::submit('Cancella', array('class' => 'btn btn-danger')) }}
                    {{Form::close()}}
                </div>
            </div>
        </div>
        {{-- TODO: fix buttons alignment --}}
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