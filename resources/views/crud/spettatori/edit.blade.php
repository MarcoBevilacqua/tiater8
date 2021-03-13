@extends("admin/inner-admin-layout")

@section("content")
<div id="page-wrapper">
    <div class="row text-center">
        <div class="page-header">
            {{Html::ul($errors->all())}}
            <h2>{{$viewer->first_name. " ". $viewer->last_name}} / Modifica</h2>
        </div>
    </div>
    <div class="container-fluid">

        {{ Form::model($viewer, array('route' => array('viewer.update', $viewer->id), 'method' => 'PUT')) }}

        <div class="row row-tiater">
            <div class="form-inner-container col-lg-4">
                {{ Form::label('first_name', 'Nome', array('class' => 'form-label-custom tiater')) }}
                {{ Form::text('first_name', $viewer->first_name, array('class' => 'form-control form-control-custom tiater', 'required')) }}
            </div>
            <div class="form-inner-container col-lg-8">
                {{ Form::label('last_name', 'Cognome', array('class' => 'form-label-custom tiater')) }}
                {{ Form::text('last_name', $viewer->last_name , array('class' => 'form-control form-control-custom tiater', 'required')) }}
            </div>
        </div>

        <div class="row row-tiater">
            <div class="form-inner-container col-lg-8">
                {{ Form::label('email', 'Email', array('class' => 'form-label-custom tiater')) }}
                {{ Form::text('email', $viewer->email, array('class' => 'form-control form-control-custom tiater', 'required'))}}
            </div>
            <div class="form-inner-container col-lg-4">
                {{ Form::label('phone', 'Phone Number', array('class' => 'form-label-custom tiater')) }}
                {{ Form::text('phone', $viewer->phone, array('class' => 'form-control form-control-custom tiater', 'required')) }}
            </div>
        </div>

        <div class="row row-tiater">
            <div class="form-inner-container col-lg-6">
                <div class="col-lg-2 no-padding switch-label">
                    <div class="onoffswitch">
                        {{Form::checkbox('quota',
                        $viewer->quota, $viewer->quota == "S",
                        ['id' => 'myonoffswitch', 'class' => 'onoffswitch-checkbox'])}}
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


                {{ Form::submit('aggiorna utente', array('class' => 'btn btn-lg btn-primary btn-tiater')) }}
            </div>
        </div>
        {{ Form::close() }}
        {{Form::model($viewer, array('route' => array('viewer.destroy', $viewer), 'method' => 'delete'))}}
        {{Form::submit('elimina', array('class' => 'btn btn-lg btn-danger btn-tiater'))}}
        {{Form::close() }}
    </div>
</div>
@stop