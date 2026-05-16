@extends('admin.layouts.app')

@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Novo Usuário</h2>
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i></a></li>
                <li><a href="{{ route('admin.users.index') }}">Usuários</a></li>
                <li><span>Novo</span></li>
            </ol>
        </div>
    </header>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <section class="panel">
                <header class="panel-heading">
                    <h2 class="panel-title">Dados do Usuário</h2>
                </header>

                <div class="panel-body">

                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-none pl-md">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('admin.users.store') }}" class="form-horizontal">
                        @csrf

                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label class="col-sm-3 control-label">Nome <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="name" value="{{ old('name') }}"
                                    class="form-control" placeholder="Nome completo">
                                @if($errors->has('name'))
                                    <span class="help-block">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label class="col-sm-3 control-label">E-mail <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="form-control" placeholder="email@exemplo.com">
                                @if($errors->has('email'))
                                    <span class="help-block">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('role') ? 'has-error' : '' }}">
                            <label class="col-sm-3 control-label">Perfil <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <select name="role" class="form-control">
                                    <option value="">Selecione...</option>
                                    <option value="admin"   {{ old('role') === 'admin'   ? 'selected' : '' }}>Admin</option>
                                    <option value="teacher" {{ old('role') === 'teacher' ? 'selected' : '' }}>Teacher</option>
                                    <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>Student</option>
                                </select>
                                @if($errors->has('role'))
                                    <span class="help-block">{{ $errors->first('role') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                            <label class="col-sm-3 control-label">Senha <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <input type="password" name="password"
                                    class="form-control" placeholder="Mínimo 8 caracteres">
                                @if($errors->has('password'))
                                    <span class="help-block">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                            <label class="col-sm-3 control-label">Confirmar Senha <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <input type="password" name="password_confirmation"
                                    class="form-control" placeholder="Repita a senha">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-save"></i> Salvar
                                </button>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-default">
                                    <i class="fa fa-times"></i> Cancelar
                                </a>
                            </div>
                        </div>

                    </form>
                </div>
            </section>
        </div>
    </div>
</section>
@endsection
