<li class="nav-parent @if(isset($config['activeMenu']) && $config['activeMenu'] == 'insurance') nav-expanded nav-active @endif">
    <a>
        <i class="fa fa-bank" aria-hidden="true"></i>
        <span>Seguradoras</span>
    </a>
    <ul class="nav nav-children">
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'insurance')class="active"@endif>
            <a href="{{ route('admin.insurance.insurance.index') }}">
                Seguradoras
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'page-7')class="active"@endif>
            <a href="{{ route('admin.configuration.page.edit', 7) }}">
                Descrição Página
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'plan')class="active"@endif>
            <a href="{{ route('admin.insurance.plan.index') }}">
                Planos
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'cover-plan')class="active"@endif>
            <a href="{{ route('admin.insurance.cover-plan.index') }}">
                Detaque Planos
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'page-9')class="active"@endif>
            <a href="{{ route('admin.configuration.page.edit', 9) }}">
                Formas de Pagamento
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'page-10')class="active"@endif>
            <a href="{{ route('admin.configuration.page.edit', 10) }}">
                Prazo para cancelamento
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'accreditation-network')class="active"@endif>
            <a href="{{ route('admin.insurance.accreditation-network.index') }}">
                Estabelecimentos Credenciados
            </a>
        </li>
         <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'insurance-value-day-log')class="active"@endif>
            <a href="{{ route('admin.insurance.insurance.cambio.index') }}">
                Historico de Câmbio do Dia
            </a>
        </li>
    </ul>
</li>