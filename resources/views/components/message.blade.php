@if(session('message') && session('type'))
    <div class="continer notifications
        @if(session('type') === 'success') success 
        @elseif(session('type') === 'error') error 
        @elseif(session('type') === 'warning') warning 
        @endif "
    >
        <span>{{session('type')}}:</span>
        {{session('message')}}
    </div>
@endif