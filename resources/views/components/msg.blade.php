@if (session('msg'))
    @if (is_array(session('msg')))
        <div class="alert alert-success position-fixed" style="bottom: 15px; left: 15px">
            @foreach (session('msg') as $msg)
                <span class="d-block"> - {{ $msg }}</span>
            @endforeach
        </div> 
    @else
        <div class="alert alert-success position-fixed" style="bottom: 15px; left: 15px">
            <span>{{ session('msg') }}</span>
        </div>        
    @endif 
@endif