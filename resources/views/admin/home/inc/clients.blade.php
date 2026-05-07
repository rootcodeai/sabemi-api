@if(!$data['clients']->isEmpty())
<section class="panel">
    <header class="panel-heading">
        <h2 class="panel-title">Clientes</h2>
    </header>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12 text-right">
                <div class="mb-md">
                    <a href="{{ route('admin.client.client.index') }}" title="Cadastrar" class="btn btn-default"><i class="fa el-icon-search"></i> Todos os Clientes</a>
                </div>
            </div>
        </div>

        <table class="table table-no-more table-bordered table-striped mb-0">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>Tipo Cadastro</th>
                    <th class="col-md-1 text-center">Ativo</th>
                    <th class="col-md-1 text-center">Data Cadastro</th>
                    <th class="col-md-2 text-center">Ação</th>
                </tr>
            </thead>
            <tbody>
            @foreach($data['clients'] as $row)
                <tr>
                    <td data-title="#" class="text-center">{{ $row->id }}</td>
                    <td data-title="Nome">{{ showClientName($row) }}</td>
                    <td data-title="E-mail">{{ $row->email }}</td>
                    <td data-title="Telefone">{{ $row->phone }}</td>
                    <td data-title="Tipo Cadastro">{{ $row->type->name }}</td>
                    <td data-title="Ativo" class="text-center"><i class="fa  @if($row->active == 'y') fa-check-square alert-success @else fa-times-circle alert-danger @endif"></i></td>
                    <td data-title="Data Cadastro" class="text-center">{{ mysql_to_data($row->created_at, true, false) }}</td>
                    <td class="actions text-center" data-title="Ação">
                        @if($row->client_type_id != 1)
                            <a href="{{ route('admin.client.client.wallets.index', ['id' => $row->id]) }}" class="btn btn-default white-hover" title="Carteira"><i class="fa fa-bar-chart-o"></i></a>
                        @endif
                        @if($row->client_type_id == 1)
                            <a href="{{ route('admin.client.client.wallet-transfer.index', ['id' => $row->id]) }}" class="btn btn-default white-hover" title="Tranferência Fidelidade"><i class="fa el-icon-star"></i></a>
                        @endif
                        <a href="{{ route('admin.client.client.show', ['id' => $row->id]) }}" class="btn btn-default white-hover" title="Visualizar"><i class="fa el-icon-search"></i></a>
                        @if($row->client_type_id != 1 && $row->client_type_id != 2)
                        <a href="{{ route('admin.client.client.related.index', ['id' => $row->id]) }}" class="btn btn-default white-hover" title="Clientes Relacionados"><i class="fa fa-users"></i></a>
                        @endif
                        <a href="{{ route('admin.client.client.reset-password.edit', ['id' => $row->id]) }}" class="btn btn-default white-hover" title="Alterar Senha"><i class="el-icon-key"></i></a>
                        <a href="{{ route('admin.client.client.edit', ['id' => $row->id]) }}" class="btn btn-default white-hover" title="Editar"><i class="fa el-icon-file-edit"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
</section>
@endif