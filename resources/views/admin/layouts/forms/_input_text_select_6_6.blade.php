<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label($i_0['name'], $i_0['label']) !!}
            <?php
            $varRequired = '';
            if(isset($i_0['required']) && $i_0['required']){
                $varRequired = 'required';
            }
            $varClass = '';
            if(isset($i_0['class']) && $i_0['class']){
                $varClass = $i_0['class'];
            }
            ?>
            {!! Form::text($i_0['name'], null, ['class'=>'form-control '.$varClass, $varRequired, 'maxlength' => 255]) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label($i_1['name'], $i_1['label']) !!}
            <?php
            $varRequired = '';
            if(isset($i_1['required']) && $i_1['required']){
                $varRequired = 'required';
            }
            ?>
            {!! Form::select($i_1['name'], $i_1['select'], null, ['class'=>'form-control', $varRequired]) !!}
        </div>
    </div>
</div>