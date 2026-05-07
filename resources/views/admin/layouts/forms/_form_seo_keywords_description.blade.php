<hr>
<div class="row">
    <div class="col-md-6">
        <br />
        <div class="alert alert-info">
            Máximo de 255 caracteres, palavras separadas por virgula
        </div>
        <div class="form-group">
            {!! Form::label('seo_keywords', 'SEO Keywords *') !!}
            {!! Form::text('seo_keywords', null, ['class'=>'form-control', 'required' => 'required', 'maxlength' => 255]) !!}
        </div>
    </div>
    <div class="col-md-6">
        <br />
        <div class="alert alert-info">
            Recomendamos não ultrapassar 160 caracteres
        </div>
        <div class="form-group">
            {!! Form::label('seo_description', 'SEO Descrição Página *') !!}
            {!! Form::text('seo_description', null, ['class'=>'form-control', 'required' => 'required', 'maxlength' => 255]) !!}
        </div>
    </div>
</div>