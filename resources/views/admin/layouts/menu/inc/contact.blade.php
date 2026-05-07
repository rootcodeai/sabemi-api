<li class="nav-parent @if(isset($config['activeMenu']) && $config['activeMenu'] == 'form') nav-expanded nav-active @endif">
    <a>
        <i class="fa fa-envelope" aria-hidden="true"></i>
        <span>Formulários</span>
    </a>
    <ul class="nav nav-children">
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'contact')class="active"@endif>
            <a href="{{ route('admin.form.contact.index') }}">
                Contato
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'subject')class="active"@endif>
            <a href="{{ route('admin.form.subject.index') }}">
                Assunto
            </a>
        </li>
        <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'newsletter')class="active"@endif>
            <a href="{{ route('admin.form.newsletter.index') }}">
                Newsletter
            </a>
        </li>
    </ul>
</li>