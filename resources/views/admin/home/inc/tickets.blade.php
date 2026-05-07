
<section class="panel">
    <header class="panel-heading">
        <h2 class="panel-title">Boletos dos pedidos</h2>
    </header>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12 text-right">
                <div class="mb-md">
                    <a href="{{ route('admin.report.payments.tickets') }}" title="Ver Mais" class="btn btn-info"><i class="fa fa-search"></i> Ver Mais</a>
                </div>
            </div>
        </div>
        @if($data['tickets'])
        <table class="table table-no-more table-bordered table-striped mb-0">
            <thead>
                <tr>
                    <th>Pedido</th>
                    <th>Cliente</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Data</th>
                    <th>Total</th>
                    <th class="text-center">Vencimento</th>
                    <th class="text-center">Dias Viagem</th>
                    <th class="text-center">Boleto</th>
                    <th class="text-center">Ação</th>
                </tr>
            </thead>
            <tbody>
            @foreach($data['tickets'] as $row)
            <tr>
                <td data-title="Pedido"><a href="{{ route('admin.order.order.edit', $row['id']) }}" title="Acessar Pedido">{{ $row['id'] }}</a></td>
                <td data-title="Cliente">    
                    <a href="{{ route('admin.client.client.edit', $row['client_id']) }}" title="Acessar Cliente">{{ $row['client_id'] . ' | ' . showClientNameArray($row) }}</a>
                </td>
                <td data-title="Status" class="text-center">{!! getSpamStatus($row['description'] ?? null) !!}</td>
                <td data-title="Data" class="text-center">{{ mysql_to_data($row['created_at'], true) }}</td>
                <td data-title="Total">R$ {{ formata_valor($row['total']) }}</td>
                <td data-title="Vencimento" class="text-center">{{ mysql_to_data($row['due_date']) }}</td>
                <td data-title="Dias Viagem" class="text-center">
                    <?php 
                    $classDays = 'badge-success';
                    if ($row['days'] <= 3) {
                        $classDays = 'badge-warning';
                    }
                    if ($row['days'] <= 1) {
                        $classDays = 'badge-danger';  
                    }
                    echo '<span class="badge ' . $classDays . '">' . $row['days'] . '</span>';
                    ?>
                </td>
                <td data-title="Boleto" class="text-center">
                    <a href="{{ $row['invoice_url'] }}" target="_blank" class="mb-xs mt-xs mr-xs btn btn-dark">Visualizar</a>
                </td>
                <td data-title="Ação" class="actions text-center">
                    <a href="{{ route('admin.order.order.show', ['id' => $row['id']]) }}" class="btn btn-default white-hover" title="Visualizar"><i class="fa el-icon-search"></i></a>
                    <a href="{{ route('admin.order.order.edit', ['id' => $row['id']]) }}" class="btn btn-default white-hover" title="Editar"><i class="fa el-icon-file-edit"></i></a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        @else 
            Nenhum pedido com boleto para acompanhar. 
        @endif
    </div>
</section>