<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <?php
            $formRequired = '';
            if(isset($required) && $required){
                $formRequired = 'required';
                $label = $label.' *';
            }
            ?>
            {!! Form::label($name, $label) !!}
            {!! Form::select($name, $select, null, ['class'=>'form-control', $formRequired]) !!}
        </div>
    </div>
</div>