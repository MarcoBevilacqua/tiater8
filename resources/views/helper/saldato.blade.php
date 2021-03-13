
@if($booking->paid)
    <span class="label label-success">pagato</span>
@else
    <span class="label label-danger">da saldare</span>
@endif