<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('link_youtube', 'Youtube') !!}
            {!! Form::text('link_youtube', null, ['class'=>'form-control', 'maxlength' => 255]) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('link_facebook', 'Facebook') !!}
            {!! Form::text('link_facebook', null, ['class'=>'form-control', 'maxlength' => 255]) !!}
        </div>
    </div>
</div>