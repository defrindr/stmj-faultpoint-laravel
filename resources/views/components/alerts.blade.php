@if($showMessage)
<div class='alert alert-{{ $type }} alert-dismissible'>
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <h5><i class='icon fas fa-{{ $icon }}'></i> {{ $title }} </h5>
    <ul>
        {!! $message !!}
    </ul>
</div>
@endif
