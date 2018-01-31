@if(session()->has('msg') && session()->has('tipoAlerta'))
    <div class="container">
        <div class="alert alert-{{ session('tipoAlerta') }} alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ session('msg') }}
        </div>
    </div>
@endif