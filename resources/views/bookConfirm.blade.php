@extends('admin.inner-admin-layout')
@section('content')
    <div id="page-wrapper">
        <div class="errors">

        </div>
        <div class="row">
            <div class="page-header">
                <h1>Prenotazione / Riepilogo</h1>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4>Prenotazione #{{ $data['token']->id}}</h4>
                </div>
                <div class="panel-body">
                    <div class="col-lg-6">
                        <dl class="dl-horizontal">
                            <dt>Nome: </dt>
                            <dd><a href="#">{{ $data['viewer']->full_name }}</a></dd>
                            <dt>Info spettatore: </dt>
                            <dd><a href="#">{{ $data['viewer']->email }}</a></dd>
                            <dt>Spettacolo:</dt>
                            <dd>{{ $data['show']->name }}</dd>
                            <dt>Data & Ora: </dt>
                            <dd><?php echo date('d M Y', strtotime($data['event']->show_date)). ' ore '. date('H', strtotime($data['event']->show_date)).':00' ?></dd>
                            <dt>Interi/ridotti: </dt>
                            <dd>{{$data['token']->full_price_qnt.'/'.$data['token']->half_price_qnt}}</dd>
                            <dt>Pagamento: </dt>
                            <dd><?php echo ($data['token']->paid == "S") ? 'saldato' : 'da saldare' ?></dd>
                        </dl>
                    </div>
                    <div class="col-lg-4 pull-right" id="confirm-actions">
                        <ul class="list-unstyled text-center">
                            <li><a href="#" class="btn btn-primary">Manda mail di conferma</a> </li>
                            <li><a href="{{URL::to('book/get/list', array('id' => $data['event']->id))}}"
                                   class="btn btn-info">Stampa promemoria</a> </li>
                            <li><a href="{{URL::to('/')}}" class="btn btn-default">Torna in home</a> </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <style>
            #confirm-actions li a{width: 200px;margin: 5px 0px 5px 0px}
        </style>
    </div>

@stop