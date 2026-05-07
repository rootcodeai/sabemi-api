<section class="panel">
    <header class="panel-heading panel-danger bg-danger">
        <h2 class="panel-title">Solicitações de Cancelamento de Voucher</h2>
    </header>

    <div class="panel-body">
        @if($orderPlanCancellations && count($orderPlanCancellations) > 0)
        <table class="table table-no-more table-bordered table-striped mb-0">
            <thead>
                <tr>
                    <th>Pedido</th>
                    <th>Cliente</th>
                    <th>Passageiro</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Data</th>
                    <th class="text-center">Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orderPlanCancellations as $row)
                <tr>
                    <td data-title="Pedido"><a href="{{ route('admin.order.order.edit', $row->orderPlan->order_id) }}" title="Acessar Pedido">{{ $row->orderPlan->order_id }}</a></td>
                    <td data-title="Cliente">
                        <a href="{{ route('admin.client.client.edit', $row->client_id) }}" title="Acessar Cliente">{{ $row->client_id . ' | ' . showClientName($row->client) }}</a>
                    </td>
                    <td>{{$row->order_plan_id}} | {{$row->orderPlan->name}}</td>
                    <td data-title="Status" class="text-center">{!! getSpamStatus($row->status, 'Pendente de Aprovação') !!}</td>
                    <td data-title="Data" class="text-center">{{ mysql_to_data($row->created_at, true, false) }}</td>
                    <td data-title="Ação" class="actions text-center">
                        <a href="{{ route('admin.order.order.show', ['id' => $row->orderPlan->order_id]) }}" class="btn btn-default white-hover" title="Visualizar"><i class="fa el-icon-search"></i></a>
                        <a href="{{ route('admin.order.order.edit', ['id' => $row->orderPlan->order_id]) }}" class="btn btn-default white-hover" title="Editar"><i class="fa el-icon-file-edit"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        Nenhuma solicitação de cancelamento de cancelamento de voucher recebida.
        @endif
    </div>
</section>