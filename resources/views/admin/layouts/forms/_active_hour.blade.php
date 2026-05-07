<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('hour', 'Horário *') !!}
            {!! Form::text('hour', null, ['class'=>'form-control', 'data-input-mask' => '99:99', 'data-plugin-masked-input', 'placeholder' => '__:__', 'required' => 'required']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('active', 'Ativo? *') !!}
            {!! Form::select('active', ['y' => 'Sim', 'n' => 'Não'], null, ['class'=>'form-control', 'required' => 'required']) !!}
        </div>
    </div>
</div>