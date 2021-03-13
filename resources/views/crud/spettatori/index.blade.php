@extends("admin.inner-admin-layout")

@section('content')
<div id="page-wrapper">
<div class="row">
    <div class="page-header text-center">
        {{ Html::ul($errors->all()) }}
        <h2 class="no-margin">Soci</h2>
        <small><a href="{{URL::to('viewer/create')}}">aggiungi nuovo</a></small>
    </div>
</div>
    <div class="row row-tiater">
    @foreach($viewers as $key => $viewer)
        @include('crud.spettatori.template.viewer', array('key' =>$key))
        @if($key > 0 && ++$key % 4 == 0)
            </div><div class="row row-tiater">
        @endif
    @endforeach
    </div>
</div>
@stop