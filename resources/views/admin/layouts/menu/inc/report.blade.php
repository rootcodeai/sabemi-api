<li class="nav-parent @if(isset($config['activeMenu']) && $config['activeMenu'] == 'report') nav-expanded nav-active @endif">
    <a>
        <i class="fa fa-bar-chart" aria-hidden="true"></i>
        <span>Relatório</span>
    </a>
    <ul class="nav nav-children">
        <!--li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'commissions')class="active"@endif>
            <a href="{{ route('admin.report.commissions.index') }}">
                Comissões e saldos
            </a>
        </li-->
        <!--li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'sales')class="active"@endif>
            <a href="{{ route('admin.report.general.index') }}">
                Vendas
            </a>
        </li-->
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'report')class="active"@endif>
            <a href="{{ route('admin.report.invoice.index') }}">
                Faturas
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'clients')class="active"@endif>
            <a href="{{ route('admin.report.clients.index') }}">
                Clientes
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'orders')class="active"@endif>
            <a href="{{ route('admin.report.orders.index') }}">
                Pedidos
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'order-plans')class="active"@endif>
            <a href="{{ route('admin.report.order-plans.index') }}">
                Passageiros
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'sale-day')class="active"@endif>
            <a href="{{ route('admin.report.seller.sale-day') }}">
                Vendedor Por Dia
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'sale-client')class="active"@endif>
            <a href="{{ route('admin.report.seller.sale-client') }}">
                Vendedor Por Cliente
            </a>
        </li>
        <!--li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'tickets')class="active"@endif>
            <a href="{{ route('admin.report.payments.tickets') }}">
                Boletos
            </a>
        </li-->
        <!--li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'wallets')class="active"@endif>
            <a href="{{ route('admin.report.sellers.wallets.index') }}">
                Carteira Vendedor
            </a>
        </li-->
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'voucher-alerts')class="active"@endif>
            <a href="{{ route('admin.report.voucher-alerts.index') }}">
                Vouchers em Alertas
            </a>
        </li>
    </ul>
</li>