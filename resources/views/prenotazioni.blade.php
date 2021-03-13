@extends("admin/admin-layout")

@section('content')
<div id="page-wrapper">
<div class="row">
    <div class="page-header">
        {{ HTML::ul($errors->all()) }}
        <h2>Prenotazioni</h2>
    </div>
</div>
    <div class="col-xs-6">
        {{Form::label('spettacoli', 'Spettacoli')}}
        {{--{{Form::select('spettacoli', $gigs,  array('class' => 'form-control'))}}--}}
        <select id="spettacoli" name="spettacoli" autocomplete="off" class="form-control">
            <option value="" selected> --- </option>
            @foreach($gigs as $gig)
                <option value="{{$gig->id}}">{{$gig->nome}}</option>
            @endforeach
        </select>
    </div>
    <table class="table table-striped">
        <thead>
            <th>Nome</th>
            <th>Data Spettacolo</th>
            <th class="text-center">Quantit&aacute;</th>
            <th>Posto</th>
            <th></th>
        </thead>
        <tbody>
        @foreach($prenotazioni as $pren)
        {{--var_dump($pren)--}}
            <tr id="{{$pren->id}}" class="fetch-gig-{{$pren->spettacolo_id}}">
             <td>
                <h2>{{Spettatori::find($pren->spettatore_id)->nome}}</h2>
                    <ul class="list-inline">
                    <li>{{date('d/M/y H:i', strtotime($pren->data_prenotazione))}}</li>
                    <li><p class="{{($pren->pagato == "N") ? "bg-danger" : "bg-success"}}"
                    style="padding: 5px;">{{($pren->pagato == "N") ? " Da pagare" : "Pagato"}}</p></li>
                    </ul>
                </td>
                <td>
                    <h3 class="lead">
                    {{date('d/M/y H:i', strtotime(Eventi::find($pren->evento_id)->data_spettacolo))}}
                    </h3>
                </td>
                <td class="qnt text-center">
                    <ul class="list-inline">
                        <li><h3>{{$pren->qnt_interi}}<br /><small>Interi</small></h3></li>
                        <li><h3>{{$pren->qnt_ridotti}}<br /><small>Ridotti</small></h3></li>
                    </ul>
                </td>
                <td class="cod_posto">
                    <h3 class="lead">{{$pren->codice_posto}}</h3>
                </td>
                <td>
                    <a href="{{URL::to('prenotazioni/'.$pren->id.'/edit')}}">Modifica</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>

    <script type="text/javascript">
        $('#spettacoli').on('change', function(){
            var _id = $(this).val();
            //mostro tutti
            $('tr.hidden').removeClass('hidden');
            //rimuovo quelli non selezionati
            var _classToShow = 'fetch-gig-'+_id;
            $('tbody tr').not('.'+_classToShow).addClass('hidden');

        });
    </script>

@stop