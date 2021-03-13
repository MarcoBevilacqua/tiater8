@extends("admin/admin-layout")

@section("content")
<div id="page-wrapper">
    <div class="row">
        <div class="page-header">
            <h2>{{$socio->nome}}</h2>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="col-lg-4">
            <h2>{{$socio->email}}</h2>
        </div>
    </div>
</div>

@stop