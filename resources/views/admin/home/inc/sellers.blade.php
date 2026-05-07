@if (array_key_exists('dashboard', $data))

    <section class="panel">
        <header class="panel-heading">
            <h2 class="panel-title">Relatório vendas</h2>
        </header>
        <div class="panel-body">

            @include('admin.home.inc.sellers_form_filter')
            <?php
            $totalOrders = 0;
            $quantityOrders = 0;
            $totalCommissions = 0;
            $totalBilling = 0;
            $totalSellerCommissions = 0;
            $totalInsuranceNet = 0;
            $totalClients = 0;
            if ($data['dashboard']) {
                $totalClients = $data['dashboard']['total_clients'];
                foreach ($data['dashboard']['data'] as $row) {
                    # Status cancelado
                    if ($row['status_id'] != 16) {
                        $quantityOrders += $row['orders'];
                        $totalOrders += $row['total_orders'];
                        $totalCommissions += $row['total_commissions'];
                        $totalBilling += $row['total_billing'];
                        $totalSellerCommissions += $row['total_seller_commission_prices'];
                        $totalInsuranceNet += $row['insurance_net'];
                    }
                }
            }
            ?>
            <div class="row">
                <div class="col-md-12 col-lg-4 col-xl-4">
                    <section class="panel panel-featured-left panel-featured-success">
                        <div class="panel-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-success">
                                        <i class="fa fa-shopping-cart"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title"></h4>
                                        <div class="info">
                                            <strong class="amount">
                                                R$ {{ formata_valor($totalOrders) }}<br />
                                            </strong>
                                            Total vendido bruto ({{ $quantityOrders }})<br />
                                            {!! $data['period'] !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-12 col-lg-4 col-xl-4">
                    <section class="panel panel-featured-left panel-featured-success">
                        <div class="panel-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-success">
                                        <i class="fa fa-shopping-cart"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title"></h4>
                                        <div class="info">
                                            <strong class="amount">
                                                R$ {{ formata_valor($totalCommissions) }}<br />
                                            </strong>
                                            Total comissão<br />
                                            {!! $data['period'] !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-12 col-lg-4 col-xl-4">
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
                                                R$ {{ formata_valor($totalBilling) }}<br />
                                            </strong>
                                            Total faturado<br />
                                            {!! $data['period'] !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <!-- div class="col-md-12 col-lg-4 col-xl-4">
                    <section class="panel panel-featured-left panel-featured-success">
                        <div class="panel-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-success">
                                        <i class="fa fa-shopping-cart"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title"></h4>
                                        <div class="info">
                                            <strong class="amount">
                                                R$ {{ formata_valor($totalSellerCommissions) }}<br />
                                            </strong>
                                            Total comissão vendedores<br />
                                            {!! $data['period'] !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div -->

                <div class="col-md-12 col-lg-4 col-xl-4">
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
                                                R$
                                                <?php /* formata_valor($totalBilling - $totalInsuranceNet - $totalSellerCommissions) */ ?>
                                                {{ formata_valor($totalBilling - $totalInsuranceNet) }}
                                                <br />
                                            </strong>
                                            Margem de Contribuição<br />
                                            {!! $data['period'] !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-12 col-lg-4 col-xl-4">
                    <section class="panel panel-featured-left panel-featured-dark">
                        <div class="panel-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-dark">
                                        <i class="fa fa-bank"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title"></h4>
                                        <div class="info">
                                            <strong class="amount">
                                                R$ {{ formata_valor($totalInsuranceNet) }}<br />
                                            </strong>
                                            Valor NET Total Seguradora<br />
                                            {!! $data['period'] !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-12 col-lg-4 col-xl-4">
                    <section class="panel panel-featured-left panel-featured-warning">
                        <div class="panel-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-warning">
                                        <i class="fa fa-users"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title"></h4>
                                        <div class="info">
                                            <strong class="amount">
                                                {{ $totalClients }}<br />
                                            </strong>
                                            Total de Clientes<br />
                                            {!! $data['period'] !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

            </div>

            <table class="table table-no-more table-bordered table-striped mb-0">
                <thead>
                    <tr>
                        <th>Método Pagamento</th>
                        <th>Estatus</th>
                        <th class="text-right">Pedidos</th>
                        <th class="text-right">Bruto</th>
                        <th class="text-right">Comissões</th>
                        <th class="text-right">Faturado</th>
                        <th class="text-right">Comissão Vendedor</th>
                        <th class="text-right">Net Seguradora</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $orders = 0;
                    $total_orders = 0;
                    $total_commissions = 0;
                    $total_billing = 0;
                    $total_seller_commission_prices = 0;
                    $net = 0;
                    ?>
                    @if($data['dashboard'])
                        @foreach ($data['dashboard']['data'] as $row)
                            <?php
                            $orders += $row['orders'];
                            $total_orders += $row['total_orders'];
                            $total_commissions += $row['total_commissions'];
                            $total_billing += $row['total_billing'];
                            $total_seller_commission_prices += $row['total_seller_commission_prices'];
                            $net += $row['insurance_net'];
                            ?>
                            <tr>
                                <td>{{ $row['payment'] }}</td>
                                <td>{!! getSpamStatus($row['status']) !!}</td>
                                <td class="text-right">{{ $row['orders'] }}</td>
                                <td class="text-right">R$ {{ formata_valor($row['total_orders']) }}</td>
                                <td class="text-right">R$ {{ formata_valor($row['total_commissions']) }}</td>
                                <td class="text-right">R$ {{ formata_valor($row['total_billing']) }}</td>
                                <td class="text-right">R$ {{ formata_valor($row['total_seller_commission_prices']) }}</td>
                                <td class="text-right">R$ {{ formata_valor($row['insurance_net']) }}</td>
                            </tr>
                        @endforeach
                    @endif
                    <tr>
                        <td colspan="2" class="text-bold">Totais</td>
                        <td class="text-bold text-right">{{ $orders }}</td>
                        <td class="text-bold text-right">R$ {{ formata_valor($total_orders) }}</td>
                        <td class="text-bold text-right">R$ {{ formata_valor($total_commissions) }}</td>
                        <td class="text-bold text-right">R$ {{ formata_valor($total_billing) }}</td>
                        <td class="text-bold text-right">R$ {{ formata_valor($total_seller_commission_prices) }}</td>
                        <td class="text-bold text-right">R$ {{ formata_valor($net) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
@endif
