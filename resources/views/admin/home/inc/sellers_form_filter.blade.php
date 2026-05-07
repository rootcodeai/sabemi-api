{!! Form::open(['route' => 'admin.home.index', 'method' => 'get']) !!}
<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::text(
                'seller[from]',
                !isPost(request('seller') && request('seller')['from']) ? '01/' . date('m/Y') : request('seller')['from'],
                [
                    'class' => 'form-control mb-md',
                    'placeholder' => 'De',
                    'data-plugin-datepicker data-plugin-masked-input',
                    'data-input-mask' => '99/99/9999',
                ],
            ) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::text(
                'seller[to]',
                !isPost(request('seller') && request('seller')['to']) ? date('d/m/Y') : request('seller')['to'],
                [
                    'class' => 'form-control mb-md',
                    'placeholder' => 'Até',
                    'data-plugin-datepicker data-plugin-masked-input',
                    'data-input-mask' => '99/99/9999',
                ],
            ) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::select(
                'seller[insurance_id]',
                $selectInsurances,
                !isPost(request('seller') && request('seller')['insurance_id']) ? null : request('seller')['insurance_id'],
                ['class' => 'form-control mb-md'],
            ) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::select(
                'seller[client_id]',
                $clients,
                !isPost(request('seller') && request('seller')['client_id']) ? null : request('seller')['client_id'],
                ['data-plugin-selectTwo', 'class' => 'form-control mb-md populate select-client'],
            ) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::select(
                'seller[client_sub_account_id]',
                $clientSubAccounts,
                !isPost(request('seller') && array_key_exists('client_sub_account_id', request('seller')))
                    ? null
                    : request('seller')['client_sub_account_id'],
                ['data-plugin-selectTwo', 'class' => 'form-control mb-md populate selectSubAccount'],
            ) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::select(
                'seller[seller_id]',
                $sellers,
                !isPost(request('seller') && array_key_exists('seller_id', request('seller')))
                    ? null
                    : request('seller')['seller_id'],
                ['data-plugin-selectTwo', 'class' => 'form-control mb-md populate'],
            ) !!}
        </div>
    </div>
    <div class="col-md-12 text-right">
        <a href="{{ route('admin.home.index') }}" title="Limpar" class="btn btn-danger mb-md"><i
                class="fa fa-trash"></i> Limpar</a>
        <button type="submit" class="btn btn-warning mb-md" value="Filtrar Dados"><i class="fa fa-search-plus"></i>
            Filtrar Dados</button>
        <br />
        <a href="{{ route('admin.home.exportAdminSeller') . '?' . request()->getQueryString() }}" title="Limpar"
            class="btn btn-warning mb-md"><i class="fa fa-file-excel-o"></i> Exportar</a>
    </div>
</div>
{!! Form::close() !!}
<hr />
