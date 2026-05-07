<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('address', 'Endereço') !!}
            {!! Form::text('address', null, ['class'=>'form-control', 'maxlength' => 191]) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('link_google_maps', 'Link Google Maps') !!}
            {!! Form::url('link_google_maps', null, ['class'=>'form-control', 'maxlength' => 191]) !!}
        </div>
    </div>
</div>