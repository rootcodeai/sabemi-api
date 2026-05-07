<?php
$placeholder = $placeholder ?? '';
?>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('video', 'Vídeo *') !!}
            {!! Form::text('video', null, ['class'=>'form-control', 'maxlength' => 255, 'placeholder' => $placeholder]) !!}
        </div>
    </div>
</div>