<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('description', isset($label) ? $label : 'Descrição') !!}
            {!! Form::text('description', null, ['class'=>'form-control', 'maxlength' => 255]) !!}
        </div>
    </div>
</div>