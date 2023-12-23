@if (Session::has('error'))

    <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h4><i class="icon fa fa-ban"></i> Error!</h4> {{ Session::get('error') }}
    </div>

    {{-- <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div> --}}
    
@endif


@if (Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h4><i class="icon fa fa-check"></i> Success!</h4> {{ Session::get('success') }}
    </div>
@endif
