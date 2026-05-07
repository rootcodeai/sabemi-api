<li class="@if(isset($config['activeMenu']) && $config['activeMenu'] == 'campaigns') nav-expanded nav-active @endif">
    <a href="{{ route('admin.campaigns.index') }}">
        <i class="fa fa-flag" aria-hidden="true"></i>
        <span>Campanhas</span>
    </a>
</li>
<li class="nav-parent @if(isset($config['activeMenu']) && $config['activeMenu'] == 'client') nav-expanded nav-active @endif">
    <a>
        <i class="fa fa-users" aria-hidden="true"></i>
        <span>Clientes</span>
    </a>
    <ul class="nav nav-children">
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'client')class="active"@endif>
            <a href="{{ route('admin.client.client.index') }}">
                Clientes
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'pre-registration')class="active"@endif>
            <a href="{{ route('admin.client.pre-registration.index') }}">
                Pré-Cadastro
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'birthdays')class="active"@endif>
            <a href="{{ route('admin.client.report.birthdays') }}">
                Aniversáriantes
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'interaction-types')class="active"@endif>
            <a href="{{ route('admin.client.interaction-types.index') }}">
                Tipos de Interação
            </a>
        </li>
        @if(in_array(auth()->user()->role, ['admin', 'financial']))
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'special-rates')class="active"@endif>
            <a href="{{ route('admin.client.report.special-rates') }}">
                Tarifas Especiais
            </a>
        </li>
        @endif
    </ul>
</li>
<li class="@if(isset($config['activeMenu']) && $config['activeMenu'] == 'coupon') nav-expanded nav-active @endif">
    <a href="{{ route('admin.coupon.index') }}">
        <i class="fa fa-ticket" aria-hidden="true"></i>
        <span>Cupons</span>
    </a>
</li>
<li class="@if(isset($config['activeMenu']) && $config['activeMenu'] == 'video') nav-expanded nav-active @endif">
    <a href="{{ route('admin.video.index') }}">
        <i class="fa fa-youtube-play" aria-hidden="true"></i>
        <span>Vídeos de conteúdo</span>
    </a>
</li>
<li class="nav-parent @if(isset($config['activeMenu']) && $config['activeMenu'] == 'refund') nav-expanded nav-active @endif">
    <a>
        <i class="fa fa-money" aria-hidden="true"></i>
        <span>Reembolso</span>
    </a>
    <ul class="nav nav-children">
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'page-13')class="active"@endif>
            <a href="{{ route('admin.configuration.page.edit', 13) }}">
                Resumo
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'page-19')class="active"@endif>
            <a href="{{ route('admin.configuration.page.edit', 19) }}">
                Descrição Página
            </a>
        </li>
    </ul>
</li>
<li class="@if(isset($config['activeMenu']) && $config['activeMenu'] == 'terms') nav-expanded nav-active @endif">
    <a href="{{ route('admin.configuration.page.edit', 15) }}">
        <i class="fa fa-text-width" aria-hidden="true"></i>
        <span>Termos de uso</span>
    </a>
</li>
<li class="@if(isset($config['activeMenu']) && $config['activeMenu'] == 'coverage') nav-expanded nav-active @endif">
    <a href="{{ route('admin.coverage.coverage.index') }}">
        <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
        <span>Coberturas</span>
    </a>
</li>
<li class="nav-parent @if(isset($config['activeMenu']) && $config['activeMenu'] == 'step-by-step') nav-expanded nav-active @endif">
    <a>
        <i class="fa fa-list-ol" aria-hidden="true"></i>
        <span>Passo a Passo</span>
    </a>
    <ul class="nav nav-children">
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'step-by-step')class="active"@endif>
            <a href="{{ route('admin.step-by-step.index') }}">
                Passo a Passo
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'page-8')class="active"@endif>
            <a href="{{ route('admin.configuration.page.edit', 8) }}">
                Descrição
            </a>
        </li>
    </ul>
</li>
<li class="nav-parent @if(isset($config['activeMenu']) && $config['activeMenu'] == 'common-question') nav-expanded nav-active @endif">
    <a>
        <i class="fa fa-question" aria-hidden="true"></i>
        <span>Perguntas Frequentes</span>
    </a>
    <ul class="nav nav-children">
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'common-question')class="active"@endif>
            <a href="{{ route('admin.common-question.index') }}">
                Perguntas Frequentes
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'page-6')class="active"@endif>
            <a href="{{ route('admin.configuration.page.edit', 6) }}">
                Descrição Página
            </a>
        </li>
    </ul>
</li>
<li class="nav-parent @if(isset($config['activeMenu']) && $config['activeMenu'] == 'about') nav-expanded nav-active @endif">
    <a>
        <i class="fa fa-plane" aria-hidden="true"></i>
        <span>Quem Somos</span>
    </a>
    <ul class="nav nav-children">
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'page-1')class="active"@endif>
            <a href="{{ route('admin.configuration.page.edit', 1) }}">
                Sobre nós
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'page-2')class="active"@endif>
            <a href="{{ route('admin.configuration.page.edit', 2) }}">
                Missão
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'page-3')class="active"@endif>
            <a href="{{ route('admin.configuration.page.edit', 3) }}">
                Visão
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'page-4')class="active"@endif>
            <a href="{{ route('admin.configuration.page.edit', 4) }}">
                Valores
            </a>
        </li>
    </ul>
</li>
<li class="@if(isset($config['activeMenu']) && $config['activeMenu'] == 'page-site') nav-expanded nav-active @endif">
    <a href="{{ route('admin.page-site.index') }}">
        <i class="fa fa-file" aria-hidden="true"></i>
        <span>Páginas do site</span>
    </a>
</li>
<li class="nav-parent @if(isset($config['activeMenu']) && $config['activeMenu'] == 'blog') nav-expanded nav-active @endif">
    <a>
        <i class="fa fa-tags" aria-hidden="true"></i>
        <span>Blog</span>
    </a>
    <ul class="nav nav-children">
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'post')class="active"@endif>
            <a href="{{ route('admin.blog.post.index') }}">
                Post
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'tag')class="active"@endif>
            <a href="{{ route('admin.blog.tag.index') }}">
                Tag
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'author')class="active"@endif>
            <a href="{{ route('admin.blog.author.index') }}">
                Autor
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'category-post')class="active"@endif>
            <a href="{{ route('admin.blog.category.index') }}">
                Categorias
            </a>
        </li>
    </ul>
</li>