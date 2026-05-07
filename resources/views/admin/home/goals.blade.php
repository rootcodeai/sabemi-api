@if (isset($goalsDashboard) && count($goalsDashboard) > 0)
    <section class="panel">
        <header class="panel-heading">
            <h2 class="panel-title">Acompanhamento de Metas</h2>
            <div class="panel-actions">
                <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
            </div>
        </header>
        <div class="panel-body">

            <!-- Estatísticas Gerais -->
            <div class="row mb-lg">
                <div class="col-md-3">
                    <div class="panel panel-featured panel-featured-primary">
                        <div class="panel-body text-center">
                            <h3 class="panel-title">Total Metas</h3>
                            <h2 class="text-primary">{{ $goalsDashboard['resume']['goal_value'] }}</h2>
                            <p class="text-muted">Clientes Ativados e Reativados</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-featured panel-featured-success">
                        <div class="panel-body text-center">
                            <h3 class="panel-title">Meta Atingida</h3>
                            <h2 class="text-success">{{ $goalsDashboard['resume']['goal_reached'] }}%</h2>
                            <p class="text-muted">Do objetivo mensal</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-featured panel-featured-warning">
                        <div class="panel-body text-center">
                            <h3 class="panel-title">Média Semanal</h3>
                            <h2 class="text-warning">{{ $goalsDashboard['resume']['avg_week'] }}</h2>
                            <p class="text-muted">Vendas por semana</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-featured panel-featured-info">
                        <div class="panel-body text-center">
                            <h3 class="panel-title">Top Performer</h3>
                            @if(array_key_exists(0, $goalsDashboard['team']) && count($goalsDashboard['team']) > 0)
                            <h2 class="text-info">{{ $goalsDashboard['team'][0]['name'] }}</h2>
                            @else
                                Nenhum usuário atingiu a meta
                            @endif
                            <p class="text-muted">Líder do mês</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabela de Ranking -->
            @if(array_key_exists('team', $goalsDashboard) && count($goalsDashboard['team']) > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover mb-0" id="goals-ranking-table">
                    <thead>
                        <tr class="bg-dark">
                            <th class="text-center" width="60">#</th>
                            <th>Usuário</th>
                            @for($i = 1; $i <= count($goalsDashboard['team'][0]['weeks']); $i++)
                            <th class="text-center" width="120">Semana {{ $i }}</th>
                            @endfor
                            <th class="text-center" width="140">Total Acumulado</th>
                            <th class="text-center" width="120">Meta</th>
                            <th class="text-center" width="100">% Atingido</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Usuário 1 - Maurício (Líder) -->
                        <?php $count = 0; ?>
                        @foreach ($goalsDashboard['team'] as $row)
                            <?php $count++; ?>
                            <tr>
                                <td class="text-center" data-label="Posição">
                                    <span class="badge @if($count == 1) badge-success @endif">{{ $count }}</span>
                                </td>
                                <td data-label="Usuário">
                                    <div class="media">
                                        <div class="media-body" style="padding-left: 10px;">
                                            <h5 class="media-heading mb-0">
                                                <strong>{{ $row['name'] }}</strong>
                                                @if($count == 1)
                                                <span class="badge badge-dark mb-sm ml-1">TOP</span>
                                                @endif
                                            </h5>
                                        </div>
                                    </div>
                                </td>
                                <?php $countWeek = 0; ?>
                                @foreach($row['weeks'] as $week)
                                <?php 
                                    $countWeek++;

                                    $classProccessBar = '';
                                    $classBadge = '';

                                    if ($week['goal']['percent'] >= 100) {
                                        $classProccessBar = 'progress-bar-success';
                                        $classBadge = 'badge-success';
                                    }
                                    if ($week['goal']['percent'] < 100) {
                                        $classProccessBar = 'progress-bar-warning';
                                        $classBadge = 'badge-warning';
                                    }
                                    if ($week['goal']['percent'] < 50) {
                                        $classProccessBar = 'progress-bar-danger';
                                        $classBadge = 'badge-danger';
                                    }
                                ?>
                                <td class="text-center" data-label="Semana {{ $countWeek }}">
                                    <span class="badge {{ $classBadge }} mb-sm">{{ $week['total'] }}</span> de 
                                    <span class="badge {{ $classBadge }} mb-sm">{{ $week['goal']['value'] }}</span>
                                    <div class="progress progress-xs">                                        
                                        <div class="progress-bar {{ $classProccessBar }}" style="width: {{ $week['goal']['percent'] }}%"></div>
                                    </div>
                                </td>
                                @endforeach
                                <?php    
                                    $classProccessBarGoal = '';
                                    $classBadgeGoal = '';
                                    $classTextGoal = '';
                                    if ($row['percent'] >= 100) {
                                        $classProccessBarGoal = 'progress-bar-success';
                                        $classBadgeGoal = 'badge-success';
                                        $classTextGoal = 'text-success';
                                    }
                                    if ($row['percent'] < 100) {
                                        $classProccessBarGoal = 'progress-bar-warning';
                                        $classBadgeGoal = 'badge-warning';
                                        $classTextGoal = 'text-warning';
                                    }
                                    if ($row['percent'] < 50) {
                                        $classProccessBarGoal = 'progress-bar-danger';
                                        $classBadgeGoal = 'badge-danger';
                                        $classTextGoal = 'text-danger';
                                    }
                                ?>
                                <td class="text-center" data-label="Total">
                                    <h4 class="{{ $classTextGoal }} mb-0">
                                        <strong>{{ $row['total'] }}</strong>
                                    </h4>
                                </td>
                                <td class="text-center" data-label="Meta">
                                    <h4 class="text-info mb-0">
                                        <strong>{{ $row['goal'] }}</strong>
                                    </h4>
                                </td>
                                <td class="text-center" data-label="% Atingido">
                                    <span class="badge {{ $classBadgeGoal }} mb-sm">{{ $row['percent'] }}%</span>
                                    <div class="progress progress-xs mt-1">
                                        <div class="progress-bar {{ $classProccessBarGoal }}" style="width: {{ $row['percent'] }}%"></div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            <!-- Legenda e Informações Adicionais -->
            <div class="row mt-lg">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><span class="badge badge-success">Verde</span> Meta atingida (≥100%)</p>
                                    <p><span class="badge badge-warning mb-sm">Amarelo</span> Próximo da meta (50-99%)
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p><span class="badge badge-danger">Vermelho</span> Abaixo da meta (<50%)</p>
                                    <p><span class="badge badge-warning mb-sm">TOP</span> Melhor performance</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
