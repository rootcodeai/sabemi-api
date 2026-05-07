<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('active', 'Ativo? *') !!}
            {!! Form::select('active', ['y' => 'Sim', 'n' => 'Não'], null, ['class'=>'form-control', 'required' => 'required']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('year', 'Ano (Somente Números)') !!}
            {!! Form::text('year', null, ['class'=>'form-control', 'maxlength' => 10, 'pattern' => '[0-9]+$']) !!}
        </div>
    </div>
</div>