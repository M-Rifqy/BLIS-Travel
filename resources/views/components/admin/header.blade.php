@if (auth()->user()->role == 'admin')
    @include('components.admin.header.admin')
@elseif (auth()->user()->role == 'client')
    @include('components.admin.header.client')
@endif

