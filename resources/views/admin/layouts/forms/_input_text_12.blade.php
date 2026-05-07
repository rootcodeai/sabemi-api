<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label($name, $label) !!}
            <?php
            $varRequired = '';
            if(isset($required) && $required){
                $varRequired = 'required';
            }
            ?>
            {!! Form::text($name, null, ['class'=>'form-control', $varRequired, 'maxlength' => 255]) !!}
        </div>
    </div>
</div>