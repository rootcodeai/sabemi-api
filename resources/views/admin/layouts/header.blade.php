<header class="header">
    <div class="logo-container">
        <a href="{{ route('admin.home') }}" class="logo">
            {{ config('app.name') }}
        </a>
        <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
            <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>

    <div class="header-right">
        <ul class="notifications">
            <li class="dropdown notification-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-user"></i>
                    <span class="hidden-xs"> {{ auth()->user()->name ?? 'Admin' }}</span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-link">
                                <i class="fa fa-sign-out"></i> Sair
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</header>
