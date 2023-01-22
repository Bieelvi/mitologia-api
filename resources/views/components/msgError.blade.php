@if (session('msgError'))
    @if (is_array(session('msgError')))
        <div class="alert alert-danger position-fixed" style="bottom: 15px; left: 15px">
            @foreach (session('msgError') as $msgError)
                <span class="d-block"> - {{ $msgError }}</span>
            @endforeach
        </div> 
    @else
        <div class="alert alert-danger position-fixed" style="bottom: 15px; left: 15px">
            <span>{{ session('msgError') }}</span>
        </div>        
    @endif 
@endif