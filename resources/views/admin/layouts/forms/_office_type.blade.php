<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('office', 'Cargo') !!}
            {!! Form::text('office', null, ['class'=>'form-control', 'maxlength' => 255]) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('type', 'Tipo *') !!}
            {!! Form::select('type', ['commercial' => 'Comercial', 'operation' => 'Operação', 'director' => 'Diretoria'], null, ['class'=>'form-control', 'required' => 'required']) !!}
        </div>
    </div>
</div>