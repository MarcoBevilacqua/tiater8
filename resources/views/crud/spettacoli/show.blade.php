@extends("admin.inner-admin-layout")
@section("content")
    <script type="text/javascript" src="{{ URL::asset('javascripts/datepicker/js/bootstrap-datepicker.js')}}"></script>
    <link rel="stylesheet" href="{{ URL::asset('javascripts/datepicker/css/bootstrap-datepicker3.css') }}">
    <div id="page-wrapper">
        <div class="row">
            <div class="page-header text-center">
                <h2>
                    {{$show->name}} / Aggiungi Date
                </h2>
            </div>
        </div>
        <div class="container-fluid">
            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                @if(count($events) > 0)
                    @foreach($events as $event)
                        @include('crud.spettacoli.template.event')
                    @endforeach
                @else
                    <h2 class="text-center">Nessuna data prevista</h2>
                @endif
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                <div class="page-header">
                    <h4>Inserisci altre date</h4>
                </div>
                {{Form::model(\App\ShowEvent::getModel(), array(
                'method' => 'POST',
                'route' => ['event.store'],
                'class' => 'form form-horizontal'))
                }}
                {{Form::hidden('show', $show->id)}}
                {{Form::hidden('redirect', URL::current())}}
                @include('crud.spettacoli.template.add-date')
                <div class="col-lg-12 col-md-12 col-sm-12 text center">
                    <a class="btn btn-default" href="{{URL::to('show')}}">annulla</a>
                    {{Form::submit('Salva', array('class' => 'btn btn-primary'))}}
                </div>
                {{Form::close()}}
            </div>
        </div>


        <script type="text/javascript">
            $(document).ready(function () {
                $('#dp-embed').datepicker({
                    container   : '#dp-container',
                    format      : 'dd/mm/yyyy',
                    multiDate   : true,
                    startDate   : new Date()
                })
                        .on('changeDate', function(e){
                            console.log(e);
                            $('#data').val(
                                    e.format('dd/mm/yyyy')
                            );
                        })

                ;
            });

        </script>
@stop