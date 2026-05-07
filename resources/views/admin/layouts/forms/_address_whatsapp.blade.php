<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('address', 'Endereço') !!}
            {!! Form::text('address', null, ['class'=>'form-control', 'maxlength' => 255]) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('whatsapp', 'Whatsapp') !!}
            {!! Form::text('whatsapp', null, ['class'=>'form-control', 'maxlength' => 255]) !!}
        </div>
    </div>
</div>