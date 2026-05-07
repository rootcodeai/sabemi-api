<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('color', 'Cor') !!}
            <div class="input-group color" data-plugin-colorpicker>
                <span class="input-group-addon"><i></i></span>
                {!! Form::text('color', null, ['class'=>'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('color_border', 'Cor Borda') !!}
            <div class="input-group color" data-plugin-colorpicker>
                <span class="input-group-addon"><i></i></span>
                {!! Form::text('color_border', null, ['class'=>'form-control']) !!}
            </div>
        </div>
    </div>
</div>