<div id="modalInsurance" class="zoom-anim-dialog modal-block modal-block-success modal-header-color mfp-hide">
    <section class="panel">
        {!! Form::open(['route' => 'admin.insurance.insurance.storeValueDay']) !!}
        <header class="panel-heading">
            <h2 class="panel-title">Câmbio do Dia</h2>
        </header>
        <div class="panel-body">
            <div class="modal-wrapper">
                <table class="table table-no-more table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th class="text-right">Câmbio</th>
                        <th class="text-center">Última Atualização</th>
                        @if(!in_array(auth()->user()->role, ['seller']))
                        <th>Câmbio do dia</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['insurances'] as $row)
                    <tr>
                        <td data-title="Nome">{{ $row->name }}</td>
                        <td class="text-right" data-title="Câmbio">R$ {{ formata_valor($row->value_day) }}</td>
                        <td class="text-center" data-title="Última Atualização">{{ mysql_to_data($row->updated_at, true, true) }}</td>
                        @if(auth()->user()->role != 'seller')
                        <td><input name="insurance[{{ $row->id }}]" type="text" class="form-control dinheiro" placeholder="Novo valor" required /></td>
                        @endif
                    </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        <footer class="panel-footer">
            <div class="row">
                <div class="col-md-12 text-right">
                    @if(!in_array(auth()->user()->role, ['seller']))
                    <button type="submit" class="btn btn-success modal-confirm">
                        Atualizar
                    </button>
                    @endif
                    <button class="btn btn-default modal-dismiss">Cancelar</button>
                </div>
            </div>
        </footer>
        {!! Form::close() !!}
    </section>
</div>