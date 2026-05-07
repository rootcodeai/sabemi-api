
<li class="nav-parent @if(isset($config['activeMenu']) && $config['activeMenu'] == 'configuration') nav-expanded nav-active @endif">
    <a>
        <i class="fa fa-gears" aria-hidden="true"></i>
        <span>Configurações</span>
    </a>
    <ul class="nav nav-children">
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'payment-methods')class="active"@endif>
            <a href="{{ route('admin.configuration.payment-methods.index') }}">
                Métodos de Pagamento
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'payment-plot')class="active"@endif>
            <a href="{{ route('admin.configuration.payment-plot.index') }}">
                Pagamento Parcelas
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'bank')class="active"@endif>
            <a href="{{ route('admin.configuration.banks.index') }}">
                Bancos
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'payment-plot')class="active"@endif>
            <a href="{{ route('admin.configuration.level-wallet.index') }}">
                Níveis Fidelidade
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'wallet-coupon-configuration')class="active"@endif>
            <a href="{{ route('admin.configuration.wallet-coupon-configuration.index') }}">
                Configuração Cupom Fidelidade
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'page')class="active"@endif>
            <a href="{{ route('admin.configuration.page.index') }}">
                Páginas e Textos
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'form')class="active"@endif>
            <a href="{{ route('admin.configuration.form.index') }}">
                Formulários
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'seo-page')class="active"@endif>
            <a href="{{ route('admin.configuration.seo-page.index') }}">
                SEO Páginas
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'keyword')class="active"@endif>
            <a href="{{ route('admin.configuration.keyword.index') }}">
                Keywords
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'page-18')class="active"@endif>
            <a href="{{ route('admin.configuration.page.edit', 18) }}">
                Aviso de cookeis
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'configuration')class="active"@endif>
            <a href="{{ route('admin.configuration.configuration.index') }}">
                Configurações
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'user')class="active"@endif>
            <a href="{{ route('admin.configuration.user.index') }}">
                Usuários
            </a>
        </li>
    </ul>
</li>