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
                    <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remover</a>
                    <?php
                    $route_redirect = null;
                    if(isset($routeRedirect)) {
                        $route_redirect = $routeRedirect;
                    }

                    if(isset($dados[$name]) && $dados[$name]['url']) {
                        $lightBoxCSS = 'lightBox';
                        $targetBlank = '';
                        if (isset($lightBox)) {
                            $lightBoxCSS = '';
                            $targetBlank = 'target="_blank"';
                        }
                    ?>
                    <a href="{{ $path }}" {!! $targetBlank !!} class="{{ $lightBoxCSS }} btn btn-default active">Visualizar</a>
                    <a href="javascript:void(0)" data-route="{{ $route_destroy }}" data-route-redirect="{{ $route_redirect }}" class="btn btn-default deleteImageApi">Deletar</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>