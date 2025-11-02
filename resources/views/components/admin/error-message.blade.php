    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">Terjadi Kesalahan!</h4>
            <hr>
            <p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            </p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif