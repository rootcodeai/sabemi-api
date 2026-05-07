@if($data['transferAsaas'])
    <div class="col-md-12 col-lg-4 col-xl-3">
        <section class="panel panel-featured-left panel-featured-warning">
            <div class="panel-body">
                <div class="widget-summary">
                    <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-warning">
                            <i class="fa el-icon-usd"></i>
                        </div>
                    </div>
                    <div class="widget-summary-col">
                        <div class="summary">
                            <h4 class="title">Transferências Hoje</h4>
                            <div class="info">
                                <strong class="amount">
                                    R$ {{ formata_valor($data['transferAsaas']['day']['value']) }} ({{ $data['transferAsaas']['day']['total'] }})<br/>
                                </strong>
                            </div>
                        </div>
                        <div class="summary-footer">
                            <a href="{{ route('admin.report.transfer-asaas.index') }}" class="text-muted text-uppercase">Visualizar</a>
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
                            <i class="fa el-icon-usd"></i>
                        </div>
                    </div>
                    <div class="widget-summary-col">
                        <div class="summary">
                            <h4 class="title">Transferências Total</h4>
                            <div class="info">
                                <strong class="amount">
                                    R$ {{ formata_valor($data['transferAsaas']['all']['value']) }} ({{ $data['transferAsaas']['all']['total'] }})<br/>
                                </strong>
                            </div>
                        </div>
                        <div class="summary-footer">
                            <a href="{{ route('admin.report.transfer-asaas.index') }}" class="text-muted text-uppercase">Visualizar</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="col-md-12 col-lg-4 col-xl-3">
        <section class="panel panel-featured-left panel-featured-danger">
            <div class="panel-body">
                <div class="widget-summary">
                    <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-danger">
                            <i class="fa el-icon-usd"></i>
                        </div>
                    </div>
                    <div class="widget-summary-col">
                        <div class="summary">
                            <h4 class="title">Transferências Erros</h4>
                            <div class="info">
                                <strong class="amount">
                                    R$ {{ formata_valor($data['transferAsaas']['errors']['value']) }} ({{ $data['transferAsaas']['errors']['total'] }})<br/>
                                </strong>
                            </div>
                        </div>
                        <div class="summary-footer">
                            <a href="{{ route('admin.report.transfer-asaas.errors') }}" class="text-muted text-uppercase">Visualizar</a>
                        </div>                                    
                    </div>
                </div>
            </div>
        </section>
    </div>
@endif