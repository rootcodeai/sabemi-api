@if(!$data['orders']->isEmpty())
<section class="panel">
    <header class="panel-heading">
        <h2 class="panel-title">Últimos pedidos</h2>
    </header>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12 text-right">
                <div class="mb-md">
                    <a href="{{ route('admin.order.order.index') }}" title="Cadastrar" class="btn btn-default"><i class="fa el-icon-search"></i> Todos os Pedidos</a>
                </div>
            </div>
        </div>

        <table class="table table-no-more table-bordered table-striped mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Total</th>
                    <th class="text-center">Data</th>
                    <th class="text-center">Forma Pagamento</th>
                    <th class="text-center">Lido</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Ação</th>
                </tr>
            </thead>
            <tbody>
            @foreach($data['orders'] as $row)
                <tr>
                    <td data-title="#"><a href="{{ route('admin.order.order.edit', $row->id) }}" title="Acessar Pedido">{{ $row->id }}</a></td>
                    <td data-title="Nome"><a href="{{ route('admin.client.client.edit', $row->client_id) }}" title="Acessar Cliente">{{ $row->name }}</a></td>
                    <td data-title="E-mail">{{ $row->email }}</td>
                    <td data-title="Total">R$ {{ formata_valor($row->total) }}</td>
                    <td data-title="Data" class="text-center">{{ mysql_to_data($row->created_at, true) }}</td>
                    <td data-title="Forma Pagamento" class="text-center">{{ $row->paymentMethod->name }}</td>
                    <td class="text-center"><i class="fa  @if($row->view == 'y') fa-check-square alert-success @else fa-times-circle alert-danger @endif"></i></td>
                    <td class="text-center">{!! getSpamStatus($row->status->description ?? null) !!}</td>
                    <td data-title="Ação" class="actions text-center">
                        <a href="{{ route('admin.order.order.show', ['id' => $row->id]) }}" class="btn btn-default white-hover" title="Visualizar"><i class="fa el-icon-search"></i></a>
                        @if($row->status_id !== 16)
                            @if ($row->payment_method_id == 3 && $row->status_id == 1)
                                @if($row->invoiced)
                                    <a href="#modalInvoice" data-route="{{ route('admin.order.invoice.createByOrderId', ['id' => $row->id]) }}" class="btn btn-default white-hover modalInvoice" title="Faturar">
                                        <i class="fa fa-barcode" aria-hidden="true"></i>
                                    </a>
                                @endif
                            @endif
                        <a href="{{ route('admin.order.order.edit', ['id' => $row->id]) }}" class="btn btn-default white-hover" title="Editar"><i class="fa el-icon-file-edit"></i></a>
                        <a href="#modalCancel" data-route="{{ route('admin.order.order.cancel', ['id' => $row->id]) }}" class="excluir remove-row btn btn-danger white" title="Cancelar">
                            <i class="fa el-icon-trash"></i>
                        </a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
</section>
@endif