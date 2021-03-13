
@extends('admin/admin-layout')

@section('content')
<script type="text/javascript" src="{{ URL::asset('javascripts/bootstrap-datepicker.js')}}"></script>
<link rel="stylesheet" href="{{ URL::asset('stylesheets/datepicker.css') }}" >
<div id="page-wrapper">
    <div class="row">
        <div class="page-header">
            <h1>Aggiungi date</h1>
        </div>
    </div>
 {{Form::open(array('url' => 'eventi/add', 'class' => 'form form-horizontal'))}}
 <div class="row">
    <div class="col-lg-7">
        <div class="col-xs-12">
            {{Form::label('spettacoli', 'Spettacolo')}}
            {{--{{Form::select('spettacoli', $gigs,  array('class' => 'form-control'))}}--}}
            <select name="spettacoli" autocomplete="off" class="form-control">
                <option value="" selected> --- </option>
                @foreach($gigs as $gig)
                    <option value="{{$gig->id}}">{{$gig->nome}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group col-lg-7" id="date-to-clone">
        <div class="col-lg-12 colmd-12 col-sm-12 to-clone">
            <div class="col-xs-6">
                {{ Form::label('data', 'Data') }}
                {{ Form::text('data[]',  null, array('class' => 'form-control input-datepicker text-center', 'placeholder' => 'dd/mm/aaaa')) }}
            </div>
            <div class="col-xs-3">
                {{ Form::label('ora[]', 'Ora') }}
                {{Form::selectRange('ora[]', 12,24,21, ['class' => 'form-control'])}}

            </div>
            <div class="col-xs-2">
                {{ Form::label('minuti[]', 'Minuti') }}
                {{Form::text('minuti[]', null,  array('class' => 'form-control'))}}

            </div>
            <div class="col-xs-1 lg-icon">
                <i class="fa fa-plus-square add-evento" title="aggiungi data"></i>
            </div>
        </div>
    </div>

</div>
<div class="space-60" style="height: 60px"></div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 text-center">

        <a class="btn btn-default" href="{{URL::to("/")}}">Annulla</a>
        {{ Form::submit('Salva', array('class' => 'btn btn-primary')) }}
    </div>
</div>

    {{ Form::close() }}
</div>

<script type="text/javascript">

    var maxDate = 7;

    //inizializzo il datepicker al load della pagina
    $(document).ready(function(){
        //datepicker
        $('.input-datepicker').datepicker({
            format: 'dd/mm/yyyy',
            multidate: true,
            multidateSeparator: ","
            //startDate: Date.now()
        })
        //tweak: l'opzione 'autoclose' sembra non funzionare
        .on('changeDate', function(ev){
            $(this).datepicker('hide');
        });
    });


$(document).ready(function(){
    //aggiungi data
    $('.add-evento').on('click', addEvento);
});
    function addEvento(){

        //per evitare loop infiniti
        if($('#date-to-clone .to-clone').size() < maxDate){
            $('.to-clone:last').clone().insertAfter($('.to-clone:last'));
            $('.input-datepicker:last').datepicker({
                 format: 'dd/mm/yyyy'
             }).on('changeDate', function(){
                $(this).datepicker('hide');
             }).val('');

             //bind evento
             $('.add-evento:last').on('click',addEvento);
        }
    }

</script>
@stop
