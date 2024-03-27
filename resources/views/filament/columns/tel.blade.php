@if($state->phone)
    <a style="color: #34d399" href="tel:+{{ $state->phone }}">+{{ $state->phone }}</a>  ({{ $state->first_name ? $state->first_name . ' ' . $state->last_name : $state->name }})
@else
    Нет номера
@endif
