<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label">{{ $label }} @if(isPost($size))<strong>( {{ $size }} )</strong>@endif</label>
            <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="input-append">
                    <div class="uneditable-input">
                        <i class="fa fa-file fileupload-exists"></i>
                        <span class="fileupload-preview"></span>
                    </div>
                    <span class="btn btn-default btn-file">
                        <span class="fileupload-exists">Trocar</span>
                        <span class="fileupload-new">Selecionar</span>
                        <input type="file" name="{{ $name }}" />
                    </span>
                    <a href="#" class="btn btn-default   fileupload-exists" data-dismiss="fileupload">Remover</a>
                    <?php
                    if(isset($dados->$name) && $dados->$name != ''){
                    $lightBoxCSS = 'lightBox';
                    $targetBlank = '';
                    if (isset($lightBox)) {
                        $lightBoxCSS = '';
                        $targetBlank = 'target="_blank"';
                    }
                    ?>
                    <a href="{{ config('gcp.asset') . $path.'/'.$dados->$name }}" {!! $targetBlank !!} class="{{ $lightBoxCSS }} btn btn-default active">Visualizar</a>
                    <a href="{{ $route_destroy }}" class="btn btn-default">Deletar</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>