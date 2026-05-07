<div class="col-md-12 col-lg-4 @if(auth()->user()->role == 'seller') col-xl-4 @else col-xl-3 @endif">
    <section class="panel panel-featured-left panel-featured-success">
        <div class="panel-body">
            <div class="widget-summary">
                <div class="widget-summary-col widget-summary-col-icon">
                    <div class="summary-icon bg-success">
                        <i class="fa fa-bank"></i>
                    </div>
                </div>
                <div class="widget-summary-col">
                    <div class="summary">
                        <h4 class="title"></h4>
                        <div class="info">
                            <strong class="amount">
                                Seguradoras<br />
                            </strong>
                            Câmbio do dia
                        </div>
                    </div>
                    <div class="summary-footer">
                        <a href="#modalInsurance" class="text-muted text-uppercase btnInsuranceCambio">
                            @if(auth()->user()->role == 'seller')
                            (Visualizar)
                            @else
                            (Atualizar)
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>