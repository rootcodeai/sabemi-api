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
        </div>
    </section>

    @include('admin.order.order.modal._cancellation_request-modal',['orderCancellations' => $data['orderCancellations'] ?? collect(), 'orderPlanCancellations' => $data['orderPlanCancellations'] ?? collect()])
    @include('admin.home.goals')
    @include('admin.modals._insurance')

    <div class="row">
        <div class="col-md-12">
            @include('admin.layouts._msg')
        </div>
    </div>
    @include('admin.home.inc.order-cancelled')
    @include('admin.home.inc.order-plan-cancelled')
    @include('admin.home.inc.clients-seller')

    <div class="row">
        @include('admin.home.inc.insurances')

        <div class="col-md-12 col-lg-8 col-xl-8">
            <section class="panel panel-featured-left panel-featured-warning">
                <div class="panel-body">
                    <div class="widget-summary">
                        <div class="widget-summary-col widget-summary-col-icon">
                            <div class="summary-icon bg-warning">
                                <i class="fa fa-shopping-cart"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 class="title"></h4>
                                <div class="info">
                                    <strong class="amount">
                                        Acompanhar pedidos
                                    </strong><br />
                                    Pedidos gerados no dia de hoje
                                </div>
                            </div>
                            <div class="summary-footer">
                                <a href="{{ route('admin.order.report.index') }}" class="text-muted text-uppercase">
                                    (Acompanhar)
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    @include('admin.home.inc.pedidos')

</section>
@endsection