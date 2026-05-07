<?php
$label = $label ?? 'Descrição';
$name = $name ?? 'description';
?>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label($name, $label) !!}
            {!! Form::textarea($name, null, ['class'=>'form-control ckeditor']) !!}
        </div>
    </div>
</div>