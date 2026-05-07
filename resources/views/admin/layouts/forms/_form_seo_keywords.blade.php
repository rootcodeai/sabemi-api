<hr>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info"><strong>SEO KEYWORDS:</strong> Máximo de 255 caracteres, palavras separadas por virgula</div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('seo_keywords', 'SEO Keywords *') !!}
            {!! Form::text('seo_keywords', null, ['class'=>'form-control', 'required' => 'required', 'maxlength' => 255]) !!}
        </div>
    </div>
</div>