@include('admin.layouts.menu.inc.order')
@include('admin.layouts.menu.inc.financial')
@include('admin.layouts.menu.inc.insurance')
@include('admin.layouts.menu.inc.search')


<li class="nav-parent @if(isset($config['activeMenu']) && $config['activeMenu'] == 'benefit') nav-expanded nav-active @endif">
    <a>
        <i class="fa fa-trophy" aria-hidden="true"></i>
        <span>Benefícios</span>
    </a>
    <ul class="nav nav-children">
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'benefit-area')class="active"@endif>
            <a href="{{ route('admin.benefit-areas.index') }}">
                Área de Benefícios
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'benefit-area-description')class="active"@endif>
            <a href="{{ route('admin.page-site.edit', 9) }}">
                Descrição Área de Benefícios
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'benefit')class="active"@endif>
            <a href="{{ route('admin.benefit.index') }}">
                Benefícios
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'page-5')class="active"@endif>
            <a href="{{ route('admin.configuration.page.edit', 5) }}">
                Descrição
            </a>
        </li>
    </ul>
</li>

@include('admin.layouts.menu.inc.general')
@include('admin.layouts.menu.inc.report')
@include('admin.layouts.menu.inc.contact')
@include('admin.layouts.menu.inc.configuration')