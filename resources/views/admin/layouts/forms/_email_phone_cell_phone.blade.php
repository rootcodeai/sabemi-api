<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('email', 'E-mail') !!}
            {!! Form::text('email', null, ['class'=>'form-control', 'maxlength' => 255]) !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('phone', 'Telefone') !!}
            {!! Form::text('phone', null, ['class'=>'form-control', 'maxlength' => 255]) !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('cell_phone', 'Celular *') !!}
            {!! Form::text('cell_phone', null, ['class'=>'form-control', 'maxlength' => 255]) !!}
        </div>
    </div>
</div>