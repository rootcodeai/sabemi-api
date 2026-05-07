@extends('admin.layouts.app')

@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Dashboard</h2>
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="{{ route('admin.home') }}">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Dashboard</span></li>
            </ol>
        </div>
    </header>

    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <h2 class="panel-title">Bem-vindo ao painel administrativo</h2>
                </header>
                <div class="panel-body">
                    <p>Olá, <strong>{{ auth()->user()->name }}</strong>. O painel está pronto.</p>
                </div>
            </section>
        </div>
    </div>
</section>
@endsection
