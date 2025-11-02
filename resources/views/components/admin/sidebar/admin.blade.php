<style>
    .nav-link-admin:hover span,
    .nav-link-admin:hover i {
        color: #136AD5 !important;
    }

    .nav-link-admin span,
    .nav-link-admin i {
        color: #012970 !important;
    }

    .sidebar .nav-admin.collapsed:hover span,
    .sidebar .nav-admin.collapsed:hover i {
        color: #136AD5 !important;
    }

    .nav-admin[aria-expanded="true"] span,
    .nav-admin[aria-expanded="true"] i,
    .nav-admin.show span,
    .nav-admin.show i {
        color: #136AD5 !important;
    }

    .sidebar .nav-link.nav-admin:not(.collapsed) {
        background-color: #136AD5 !important;
        color: #fff !important;
    }

    .sidebar .nav-link.nav-admin:not(.collapsed) i,
    .sidebar .nav-link.nav-admin:not(.collapsed) span {
        color: #fff !important;
    }


    .nav-admin.collapsed:not(.text-white) span,
    .nav-admin.collapsed:not(.text-white) i {
        color: #012970 !important;
    }

    .nav-admin.text-white span,
    .nav-admin.text-white i {
        color: #FFFFFF !important;
    }

    .nav-content a.active .bi-circle::before,
    .nav-content a.text-primary .bi-circle::before {
        font-family: "bootstrap-icons" !important;
        content: "\f287";
        color: #136AD5 !important;
    }

    .bg-primary {
        background-color: #136AD5 !important;
    }
</style>

<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-heading text-primary">Dashboard</li>

        <li class="nav-item">
            <a class="nav-link text-14px {{ request()->routeIs('admin.index') ? 'bg-primary text-white' : 'collapsed nav-link-admin' }}"
                href="{{ route('admin.index') }}">
                <i class="bi bi-grid {{ request()->routeIs('admin.index') ? 'text-white' : 'collapsed' }}"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- Dashboard -->

        {{-- <li class="nav-heading text-primary">Menu</li> --}}

        {{-- <li class="nav-item">
            <a class="nav-link text-14px {{ request()->routeIs('admin.activity.*') ? 'bg-primary text-white' : 'collapsed nav-link-admin' }}"
                href="{{ route('admin.activity.index') }}">
                <i class="bi bi-activity {{ request()->routeIs('admin.activity.*') ? 'text-white' : 'collapsed' }}"></i>
                <span>Kegiatan</span>
            </a>
        </li><!-- Activities --> --}}

    </ul>
</aside>
