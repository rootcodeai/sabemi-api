<aside id="sidebar-left" class="sidebar-left">
    <div class="sidebar-header">
        <div class="sidebar-title">Menu</div>
        <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
            <i class="fa fa-bars" aria-label="Menu"></i>
        </div>
    </div>
    <div class="nano">
        <div class="nano-content">
            <nav id="menu" class="nav-main" role="navigation">
                <ul class="nav nav-main">
                    <li class="{{ request()->routeIs('admin.home') ? 'nav-active' : '' }}">
                        <a href="{{ route('admin.home') }}">
                            <i class="fa fa-dashboard" aria-hidden="true"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('admin.users.*') ? 'nav-active' : '' }}">
                        <a href="{{ route('admin.users.index') }}">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            <span>Usuários</span>
                        </a>
                    </li>
                    {{-- Adicione itens de menu aqui conforme os módulos forem criados --}}
                </ul>
            </nav>
        </div>
    </div>
</aside>
