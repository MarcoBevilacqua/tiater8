@extends("admin/inner-admin-layout")

@section('content')
<div id="page-wrapper">
    <!-- PAGE WRAPPER -->
    <div class="row">
        <div class="page-header text-center">
        {{ Html::ul($errors->all()) }}
            <h2 class="no-margin">Spettacoli</h2>
            <small><a href="{{URL::to('show/create')}}">aggiungi nuovo</a></small>
        </div>
    </div>
    <div class="row">
        <?php $count = 1; ?>
        <!-- NEW LAYOUT -->
        @foreach($shows as $show)
            @include(".crud.spettacoli.template.show")
            <?php if ($count > 0 && ($count % 4 == 0) ) { ?>
    </div>
    <div class="row">
            <?php } ?>
            <?php $count++; ?>
        @endforeach
        <!-- /NEW LAYOUT -->
    </div>
    <!-- /PAGE WRAPPER -->
</div>
@stop