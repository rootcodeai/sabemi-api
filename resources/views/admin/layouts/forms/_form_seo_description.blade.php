<hr>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info"><strong>SEO DESCRIÇÃO:</strong> Recomendamos não ultrapassar 160 caracteres</div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('seo_description', 'SEO Descrição Página *') !!}
            {!! Form::text('seo_description', null, ['class'=>'form-control', 'required' => 'required', 'maxlength' => 191]) !!}
        </div>
    </div>
</div>
