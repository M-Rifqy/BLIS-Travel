@if (auth()->user()->role == 'admin')
    @include('components.admin.footer.admin')
@elseif (auth()->user()->role == 'client')
    @include('components.admin.footer.client')
@endif

