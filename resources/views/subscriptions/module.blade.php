@extends('layouts.pdf')
@section('content')
<div class="text-center my-4" style="text-align: center;">
    <h3 class="text-xl font-bold">Modulo di tesseramento</h3>
</div>
<div class="container">
    <div class="row">
        <p>Il/La sottoscritto/a {{$customer->first_name}} {{$customer->last_name}}</p>
        <p>nato/a a {{$customer->city}} ({{ $customer->province }}) il {{$customer->birth->format('d-m-Y')}}</p>
        <p>residente a {{$customer->resident}} in {{$customer->address}} cap {{ $customer->postal_code}}</p>
        <p>telefono {{ $customer->phone}} email {{ $customer->email}}</p>
    </div>

    <div class="font-bold my-6">
        <h3>chiede</h3>
    </div>
    <div class=my-6>
        <p>di aderire all’Associazione Culturale “piccola compagnia impertinente” in qualità di socio/a ordinario/a per l’anno sociale {{ $year }}.</p>
    </div>
    @if ($contact_type == "")
        <div class="my-8 font-bold">
            <span class="leading-5">di non essere contattato per le attività dell'associazione</span>
        </div>
    @else
    <div class="row font-bold">
        <span class="leading-5">di essere contattato <b>{{$contact_type}}</b>
            per comunicazioni riguardanti <b>{{ lcfirst($activity) }}</b>
        </span>
    </div>
    @endif
    <div style="margin-bottom: 30px"></div>
    <div class="my-4">
        <p>Conferma di avere preso visione dello Statuto e di condividere le finalità dell’Associazione.</p>
    </div>
    <div class="my-4">
        <p>Autorizza, ai sensi della legge 675/96 e del D.L.196/2003, il trattamento dei dati personali qui o
        altrove dichiarati, esclusivamente per lo svolgimento e la gestione delle attività legate agli scopi
        dell’Associazione, senza possibilità di trasferimento a terzi dei dati medesimi.</p>
    </div>
    <div style="margin-bottom: 30px"></div>
    <div class="my-4">
        Foggia, lì {{ $now_date}}
    </div>
    <div style="text-align: right;margin: 30px 100px 10px 0;">
        Firma <br />
    </div>
</div>
@endsection
