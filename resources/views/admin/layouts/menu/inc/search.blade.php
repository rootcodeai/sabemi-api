<?php
if (isset($config['activeMenu'])) {
    if ($config['activeMenu'] == 'age-range' || $config['activeMenu'] == 'type-trip' || $config['activeMenu'] == 'value-range' || $config['activeMenu'] == 'destiny' || $config['activeMenu'] == 'banner-search') {
        $config['activeMenu'] = 'search';
    }
}
?>
<li class="nav-parent @if (isset($config['activeMenu']) && $config['activeMenu'] == 'search') nav-expanded nav-active @endif">
    <a>
        <i class="fa fa-search" aria-hidden="true"></i>
        <span>Busca</span>
    </a>
    <ul class="nav nav-children">
        <li @if (isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'banner-search') class="active" @endif>
            <a href="{{ route('admin.banner-search.index') }}">
                Banner
            </a>
        </li>
        <li @if (isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'page-14') class="active" @endif>
            <a href="{{ route('admin.configuration.page.edit', ['id' => 14]) }}">
                Descrição
            </a>
        </li>
        <li @if (isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'age-range') class="active" @endif>
            <a href="{{ route('admin.age-range.index') }}">
                Faixa Etária
            </a>
        </li>
        <li @if (isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'value-range') class="active" @endif>
            <a href="{{ route('admin.value-range.index') }}">
                Faixa Valor
            </a>
        </li>
        <li @if (isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'type-trip') class="active" @endif>
            <a href="{{ route('admin.type-trip.index') }}">
                Tipo de Viagem
            </a>
        </li>
        <li @if (isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'destiny') class="active" @endif>
            <?php //{{ route('admin.destiny.index') }}
            ?>
            <a href="https://sistema.euviajoseguro.com.br/admin/destinies" target="_blank">
                Destinos
            </a>
        </li>
        <li @if (isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'document') class="active" @endif>
            <a href="{{ route('admin.documents.index') }}">
                Documentos
            </a>
        </li>
    </ul>
</li>
