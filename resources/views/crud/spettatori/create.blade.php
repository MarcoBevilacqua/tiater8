@extends("admin.inner-admin-layout")

@section("content")
<div id="page-wrapper">
    <div class="row text-center">
        <div class="page-header">
            {{Html::ul($errors->all()) }}
            <h2>Soci / Aggiungi</h2>
        </div>
    </div>
    <div class="container-fluid">
        {{ Form::open(array('url' => 'viewer', 'class' => 'crud-form', 'method' => 'POST')) }}

        <div class="row row-tiater">
            <div class="form-inner-container col-lg-4">
            {{ Form::label('first_name', 'Nome', array('class' => 'form-label-custom tiater')) }}
            {{ Form::text('first_name', null, array('class' => 'form-control form-control-custom tiater', 'required')) }}
            </div>
            <div class="form-inner-container col-lg-8 ">
                {{ Form::label('last_name', 'Cognome', array('class' => 'form-label-custom tiater')) }}
                {{ Form::text('last_name', null, array('class' => 'form-control form-control-custom tiater', 'required')) }}
            </div>
        </div>

        <div class="row row-tiater">
            <div class="form-inner-container col-lg-8">
                {{ Form::label('email', 'Email', array('class' => 'form-label-custom tiater')) }}
                {{ Form::text('email',  null, array('class' => 'form-control form-control-custom tiater', 'required')) }}
            </div>
            <div class="form-inner-container col-lg-4">
                {{ Form::label('phone', 'Numero di telefono', array('class' => 'form-label-custom tiater')) }}
                {{ Form::text('phone', "", array('class' => 'form-control form-control-custom tiater', 'required')) }}
            </div>
        </div>

        <div class="row row-tiater">
            <div class="form-inner-container col-lg-6">
                <div class="col-lg-2 no-padding switch-label">
                    <div class="onoffswitch">
                        {{Form::checkbox('quota', "S", "N", ['id' => 'myonoffswitch', 'class' => 'onoffswitch-checkbox', 'checked'])}}
                        <label class="onoffswitch-label" for="myonoffswitch"></label>
                    </div>
                </div>
                <div class="col-lg-6 switch-label">
                    <p>Quota di iscrizione pagata</p>
                </div>
            </div>
        </div>

        <div class="row row-tiater">
            <div class="form-inner-container form-control-custom form-submit-container text-center">
                <a class="btn tiater btn-tiater-undo" href="{{URL::to("viewer")}}">Annulla</a>
                {{ Form::submit('Crea utente', array('class' => 'btn btn-lg btn-primary btn-tiater')) }}
            </div>
        </div>

    </div>
</div>

@stop