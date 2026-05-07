<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('zip_code', 'CEP') !!}
            {!! Form::text('zip_code', null, ['class'=>'form-control', 'data-input-mask' => '99999-999', 'data-plugin-masked-input', 'placeholder' => '_____-___', 'maxlength' => 255]) !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('street', 'Rua') !!}
            {!! Form::text('street', null, ['class'=>'form-control', 'maxlength' => 255]) !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('district', 'Bairro') !!}
            {!! Form::text('district', null, ['class'=>'form-control', 'maxlength' => 255]) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('number', 'Número') !!}
            {!! Form::text('number', null, ['class'=>'form-control', 'maxlength' => 255]) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('state', 'Estado') !!}
            {!! Form::text('state', null, ['class'=>'form-control', 'maxlength' => 255]) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('city', 'Cidade') !!}
            {!! Form::text('city', null, ['class'=>'form-control', 'maxlength' => 255]) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('complement', 'Complemento') !!}
            {!! Form::text('complement', null, ['class'=>'form-control', 'maxlength' => 255]) !!}
        </div>
    </div>
</div>