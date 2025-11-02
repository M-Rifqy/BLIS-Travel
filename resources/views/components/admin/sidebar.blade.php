@if (auth()->user()->role == 'admin')
    @include('components.admin.sidebar.admin')
@elseif (auth()->user()->role == 'client')
    @include('components.admin.sidebar.client')
@endif

