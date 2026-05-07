@if($data['wallets'])
<div class="col-md-12 col-lg-4 col-xl-3">
    <section class="panel panel-featured-left panel-featured-info">
        <div class="panel-body">
            <div class="widget-summary">
                <div class="widget-summary-col widget-summary-col-icon">
                    <div class="summary-icon bg-info">
                        <i class="fa fa-bar-chart-o"></i>
                    </div>
                </div>
                <div class="widget-summary-col">
                    <div class="summary">
                        <h4 class="title">Comissões Amanhã</h4>
                        <div class="info">
                            <strong class="amount">
                                R$ {{ formata_valor($data['wallets']['tomorrow']) }}<br/>
                            </strong>
                            Programadas {{ gerarDataAdiante(1, 'd-m-Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="col-md-12 col-lg-4 col-xl-3">
    <section class="panel panel-featured-left panel-featured-info">
        <div class="panel-body">
            <div class="widget-summary">
                <div class="widget-summary-col widget-summary-col-icon">
                    <div class="summary-icon bg-info">
                        <i class="fa fa-bar-chart-o"></i>
                    </div>
                </div>
                <div class="widget-summary-col">
                    <div class="summary">
                        <h4 class="title">Próximas Comissões</h4>
                        <div class="info">
                            <strong class="amount">
                                R$ {{ formata_valor($data['wallets']['next']) }}<br/>
                            </strong>
                            A partir de {{ gerarDataAdiante(2, 'd-m-Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endif