@if($data['invoices'])
<div class="col-md-12 col-lg-4 col-xl-3">
    <section class="panel panel-featured-left panel-featured-danger">
        <div class="panel-body">
            <div class="widget-summary">
                <div class="widget-summary-col widget-summary-col-icon">
                    <div class="summary-icon bg-danger">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                </div>
                <div class="widget-summary-col">
                    <div class="summary">
                        <h4 class="title"></h4>
                        <div class="info">
                            <strong class="amount">
                                Faturas ({{ $data['invoices']['status_four'] }})<br/>
                            </strong>
                            Vencidas
                        </div>
                    </div>
                    <div class="summary-footer">
                        <a href="{{ route('admin.order.invoice.index') }}?status_id=4" class="text-muted text-uppercase">Visualizar</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="col-md-12 col-lg-4 col-xl-3">
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
                                Faturas ({{ $data['invoices']['status_one'] }})<br/>
                            </strong>
                            Aguardando Pagamento
                        </div>
                    </div>
                    <div class="summary-footer">
                        <a href="{{ route('admin.order.invoice.index') }}?status_id=1" class="text-muted text-uppercase">Visualizar</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="col-md-12 col-lg-4 col-xl-3">
    <section class="panel panel-featured-left panel-featured-dark">
        <div class="panel-body">
            <div class="widget-summary">
                <div class="widget-summary-col widget-summary-col-icon">
                    <div class="summary-icon bg-dark">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                </div>
                <div class="widget-summary-col">
                    <div class="summary">
                        <h4 class="title"></h4>
                        <div class="info">
                            <strong class="amount">
                                Faturas  ({{ $data['invoices']['tomorrow'] }})<br/>
                            </strong>
                            Programadas {{ gerarDataAdiante(1, 'd-m-Y') }}
                        </div>
                    </div>
                    <div class="summary-footer">
                        <a href="{{ route('admin.order.invoice.index') }}?status_id=1" class="text-muted text-uppercase">Visualizar</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endif