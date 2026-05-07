<!-- Dados para configuração do JavaScript -->
<input type="hidden" id="api-endpoint" value="{{ config('v2.endpoint_ajax') }}">
<input type="hidden" id="api-token" value="{{ config('v2.token') }}">
<input type="hidden" id="route" value="{{ route('admin.client.client.edit', ['id' => 0]) }}">

<section class="panel">
    <header class="panel-heading">
        <h2 class="panel-title">Métricas de Clientes</h2>
    </header>
    <div class="panel-body">
        <p>Toda as métricas abaixo são referente aos últimos 30 dias.</p>
    </div>
</section>
        <div class="row">
            
            <!-- Clientes ativos recentes -->
            <div class="col-md-12 col-lg-3 col-xl-3">
                <section class="panel panel-featured-left panel-featured-success">
                    <div class="panel-body">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-success">
                                    <i class="fa fa-user-plus"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title"></h4>
                                    <div class="info">
                                        <strong class="amount">
                                            Recentes (<strong id="clients-active-recent">0</strong>)
                                        </strong>
                                    </div>
                                </div>
                                <div class="summary-footer">
                                    <a href="{{ route('admin.client.report.active-recent') }}" class="text-muted text-uppercase">Visualizar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Clientes recém convertidos -->
            <div class="col-md-12 col-lg-3 col-xl-3">
                <section class="panel panel-featured-left panel-featured-info">
                    <div class="panel-body">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-info">
                                    <i class="fa fa-user-plus"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title"></h4>
                                    <div class="info">
                                        <strong class="amount">
                                            Convertidos (<strong id="clients-newly-converted">0</strong>)
                                        </strong>
                                    </div>
                                </div>
                                <div class="summary-footer">
                                    <a href="{{ route('admin.client.report.newly-converted') }}" class="text-muted text-uppercase">Visualizar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Clientes reativados -->
            <div class="col-md-12 col-lg-3 col-xl-3">
                <section class="panel panel-featured-left panel-featured-primary">
                    <div class="panel-body">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-primary">
                                    <i class="fa fa-user-plus"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title"></h4>
                                    <div class="info">
                                        <strong class="amount">
                                            Reativados (<strong id="clients-reactivated">0</strong>)
                                        </strong>
                                    </div>
                                </div>
                                <div class="summary-footer">
                                    <a href="{{ route('admin.client.report.reactivated') }}" class="text-muted text-uppercase">Visualizar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Clientes novos -->
            <div class="col-md-12 col-lg-3 col-xl-3">
                <section class="panel panel-featured-left panel-featured-success">
                    <div class="panel-body">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-success">
                                    <i class="fa fa-users"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title"></h4>
                                    <div class="info">
                                        <strong class="amount">
                                            Novos (<strong id="clients-news">0</strong>)
                                        </strong>
                                    </div>
                                </div>
                                <div class="summary-footer">
                                    <a href="{{ route('admin.client.report.news') }}" class="text-muted text-uppercase">Visualizar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

        </div>

<section class="panel col-md-6" style="padding-left: 0px;">
    <header class="panel-heading">
        <h2 class="panel-title">Nunca venderam (<strong id="clients-never-ordered">0</strong>)</h2>
    </header>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped mb-none" id="clients-never-sold-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome Fantasia</th>
                        <th>Tipo</th>
                        <th class="text-center">Data de Cadastro</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody id="clients-never-sold-tbody">
                    <tr>
                        <td colspan="7" class="text-center">
                            <i class="fa fa-spinner fa-spin"></i> Carregando dados...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-12 text-right mt-md">
                <a href="{{ route('admin.client.report.never-ordered') }}" class="btn btn-warning white-hover">Visualizar Todos</a>
            </div>
        </div>
    </div>
</section>

<!-- Clientes Inativos -->
<section class="panel col-md-6" style="padding-right: 0px;">
    <header class="panel-heading">
        <h2 class="panel-title">Clientes Inativos (<strong id="clients-inactive">0</strong>)</h2>
    </header>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped mb-none" id="clients-inactive-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome Fantasia</th>
                        <th>Tipo</th>
                        <th class="text-center">Última Compra</th>
                        <th class="text-center">Dias</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody id="clients-inactive-tbody">
                    <tr>
                        <td colspan="7" class="text-center">
                            <i class="fa fa-spinner fa-spin"></i> Carregando dados...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-12 text-right mt-md">
                <a href="{{ route('admin.client.report.inactive') }}" class="btn btn-warning white-hover">Visualizar Todos</a>
            </div>
        </div>
    </div>
</section>

<hr />