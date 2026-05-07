<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('district', 'Bairro') !!}
            {!! Form::text('district', null, ['class'=>'form-control', 'maxlength' => 255]) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('phone', 'Telefone') !!}
            {!! Form::text('phone', null, ['class'=>'form-control', 'maxlength' => 255]) !!}
        </div>
    </div>
</div>