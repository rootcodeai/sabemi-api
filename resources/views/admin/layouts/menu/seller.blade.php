<li class="@if(isset($config['activeMenu']) && $config['activeMenu'] == 'order') nav-expanded nav-active @endif">
    <a href="{{ route('admin.order.order.index') }}">
        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
        <span>Pedidos</span>
    </a>
</li>
<li class="@if(isset($config['activeMenu']) && $config['activeMenu'] == 'client') nav-expanded nav-active @endif">
    <a href="{{ route('admin.client.client.index') }}">
        <i class="fa fa-users" aria-hidden="true"></i>
        <span>Clientes</span>
    </a>
</li>
<!--li class="@if(isset($config['activeMenu']) && $config['activeMenu'] == 'wallet') nav-expanded nav-active @endif">
    <a href="{{ route('admin.seller.wallet.index') }}">
        <i class="fa fa-money" aria-hidden="true"></i>
        <span>Carteira</span>
    </a>
</li-->
<li class="nav-parent @if(isset($config['activeMenu']) && $config['activeMenu'] == 'report') nav-expanded nav-active @endif">
    <a>
        <i class="fa fa-bar-chart" aria-hidden="true"></i>
        <span>Relatórios</span>
    </a>
    <ul class="nav nav-children">
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'sale-day')class="active"@endif>
            <a href="{{ route('admin.seller.report.sale-day') }}">
                Vendas por dia
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'sale-client')class="active"@endif>
            <a href="{{ route('admin.seller.report.sale-client') }}">
                Vendas por cliente
            </a>
        </li>
    </ul>
</li>