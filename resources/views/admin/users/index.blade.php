@extends('admin.layouts.app')

@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Usuários</h2>
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i></a></li>
                <li><span>Usuários</span></li>
            </ol>
        </div>
    </header>

    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <div class="panel-actions">
                        <form method="GET" action="{{ route('admin.users.index') }}" class="form-inline pull-right">
                            <div class="input-group input-group-sm">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control" placeholder="Buscar por nome ou e-mail">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    @if(request('search'))
                                        <a href="{{ route('admin.users.index') }}" class="btn btn-default">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    @endif
                                </span>
                            </div>
                        </form>
                    </div>
                    <h2 class="panel-title">
                        Lista de Usuários
                        <span class="badge badge-default">{{ $users->total() }}</span>
                    </h2>
                </header>

                <div class="panel-body">
                    <table class="table table-bordered table-striped mb-none">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Perfil</th>
                                <th>Criado em</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="label label-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'teacher' ? 'warning' : 'default') }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Nenhum usuário encontrado.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($users->hasPages())
                <footer class="panel-footer">
                    <div class="row">
                        <div class="col-sm-6">
                            <small class="text-muted">
                                Exibindo {{ $users->firstItem() }}–{{ $users->lastItem() }} de {{ $users->total() }} registros
                            </small>
                        </div>
                        <div class="col-sm-6 text-right">
                            {{ $users->links() }}
                        </div>
                    </div>
                </footer>
                @endif

            </section>
        </div>
    </div>
</section>
@endsection
