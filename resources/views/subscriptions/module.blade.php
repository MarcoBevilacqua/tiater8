@extends('layouts.pdf')
@section('content')
<div class="text-center my-12" style="text-align: center; font-family:'Nunito'">
    <h3 class="text-xl font-bold">Modulo di tesseramento</h3>
</div>
<div class="container mx-6 w-full my-4 text-lg" style="line-height: 1.5em; font-size:1.2rem;">  
    <div class="row" style="line-height: 1.5em">
        <span class="leading-5">Il / La sottoscritto/a {{$customer->first_name}} {{$customer->last_name}} nato/a {{$customer->city}} ({{ $customer->province }}) il {{$customer->birth}}</span>
    </div>      
    <div class="row">
        <span class="">residente a {{$customer->resident}} in {{$customer->address}} cap {{ $customer->postal_code}}</span>
    </div>
    <div class="row">
        <span class="leading-5"> telefono {{ $customer->phone}} email {{ $customer->email}}</span>
    </div>    
    <div class="my-8 font-bold">
        <span class="leading-5">desidera essere contattato {{$contact_type}}</span>
    </div>                        
    <div class="row font-bold">
        <span>per comunicazioni riguardanti {{ $activity }}</span>
    </div>       
    <div class="font-bold my-6">
        <h3>chiede</h3>
    </div>
    <div class=my-6>
        <p class="leading-4">di aderire all’Associazione Culturale “piccola compagnia impertinente” in qualità di socio/a ordinario/a per l’anno sociale {{ $year }}.</p>
    </div>
    <div class="my-4">
        <p>Conferma di avere preso visione dello Statuto e di condividere le finalità dell’Associazione.</p>
    </div>
    <div class="my-4">
        <p>Autorizza, ai sensi della legge 675/96 e del D.L.196/2003, il trattamento dei dati personali qui o
        altrove dichiarati, esclusivamente per lo svolgimento e la gestione delle attività legate agli scopi
        dell’Associazione, senza possibilità di trasferimento a terzi dei dati medesimi.</p>
    </div>
    <div class="my-8">
        Foggia lì {{ $now_date}}
    </div>
    <div class="my-4 text-right" style="text-align: right;margin: 10px 100px 10px 0;">
        Firma <br />
    </div>
    <div class="my-6 "></div>
            <p>Tessera n. {{ $subscriptionId }}</p>
    </div>
</div>
@endsection