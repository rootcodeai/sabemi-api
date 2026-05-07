<li class="nav-parent @if(isset($config['activeMenu']) && $config['activeMenu'] == 'financial') nav-expanded nav-active @endif">
    <a>
        <i class="fa fa-bar-chart-o" aria-hidden="true"></i>
        <span>Financeiro</span>
    </a>
    <ul class="nav nav-children">
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'transfers-availables')class="active"@endif>
            <a href="{{ route('admin.report.transfers.available') }}">
                Transferências
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'commissions')class="active"@endif>
            <a href="{{ route('admin.financial.commissions.index') }}">
                Comissões em aberto
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'transfers-asaas')class="active"@endif>
            <a href="{{ route('admin.report.transfer-asaas.index') }}">
                Últimas Asaas
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'transfers-asaas-errors')class="active"@endif>
            <a href="{{ route('admin.report.transfer-asaas.errors') }}">
                Asaas Errors
            </a>
        </li>
    </ul>
</li>