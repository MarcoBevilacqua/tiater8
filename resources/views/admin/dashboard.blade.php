@extends('admin/admin-layout')

@section('content')

    <div id="page-wrapper">
        <div class="row">
            <div class="row" style="padding-top:20px;">
                @if($new_bookings > 0)
                    @include('admin.sections.prenotazioninuove')
                @endif
                @if($bookings_to_pay > 0)
                    @include('admin.sections.prenotazionidasaldare')

                @endif
                @if($to_confirm > 0)
                    @include('admin.sections.socidaconfermare')
                @endif
            </div>
            <div class="row">
                <div class="col-lg-6">
                    @include('admin.contents.ultimeprenotazioni')
                </div>
                <div class="col-lg-6">
                    @include('admin.sections.calendar')
                </div>
            <!-- /.col-lg-4 -->
            </div>
        <!-- /.row -->
        </div>
    </div>
    <!-- /#page-wrapper -->

@stop
