<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('name', 'Nome *') !!}
            {!! Form::text('name', null, ['class'=>'form-control', 'required' => 'required', 'maxlength' => 255]) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('text_button', 'Titulo do botão') !!}
            {!! Form::text('text_button', null, ['class'=>'form-control', 'maxlength' => 255]) !!}
        </div>
    </div>
</div>