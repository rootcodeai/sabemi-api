@extends('admin.layouts.app')
@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Home</h2>
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="{{ route('admin.home.index') }}">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Home</span></li>
            </ol>
            <a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <section class="panel">
        <header class="panel-heading">
            <h2 class="panel-title">Conteúdo do Gerenciador</h2>
        </header>
        <div class="panel-body">
            <p>Olá {{ auth()->user()->name }},<br><br>
                Seja bem vindo ao seu gerenciador de conteúdo do site Eu Viajo Seguro onde você poderá deixar sempre o seu site atualizado de forma simples e eficaz.<br>
                Qualquer dúvida você pode entrar em contato pelo email <a href="mailto:contato@euviajoseguro.com.br" title="contato@euviajoseguro.com.br">contato@euviajoseguro.com.br</a>
            </p>
            <a href="{{ config('v2.endpoint') }}/api/clear-cache" target="_blank" class="btn btn-warning btn-lg col-md-12"><i class="fa fa-trash-o"></i> Limpar o cache!</a>
        </div>
    </section>

    @include('admin.home.goals')
    @include('admin.modals._insurance')
    @include('admin.order.order.modal._cancellation_request-modal', ['orderCancellations' => $data['orderCancellations'] ?? collect()])

    <div class="row">
        <div class="col-md-12">
            @include('admin.layouts._msg')
        </div>
    </div>

    @include('admin.home.inc.clients-seller')

    <div class="row">
        @include('admin.home.inc.insurances')

        @include('admin.home.inc.invoices')
        @include('admin.home.inc.wallets')
        @include('admin.home.inc.transfer_asaas')
    </div>

    @include('admin.home.inc.tickets')

    @include('admin.home.inc.order-cancelled')
    @include('admin.home.inc.sellers')
</section>
@endsection