<li class="nav-parent @if(isset($config['activeMenu']) && $config['activeMenu'] == 'order') nav-expanded nav-active @endif">
    <a>
        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
        <span>Pedidos</span>
    </a>
    <ul class="nav nav-children">
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'order')class="active"@endif>
            <a href="{{ route('admin.order.order.index') }}">
                Pedidos
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'invoice')class="active"@endif>
            <a href="{{ route('admin.order.invoice.index') }}">
                Faturas
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'report')class="active"@endif>
            <a href="{{ route('admin.order.report.index') }}">
                Acompanhamento
            </a>
        </li>
    </ul>
</li>