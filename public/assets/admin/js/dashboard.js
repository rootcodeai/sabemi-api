$(document).ready(function () {
    loadClientMetrics();
});

// Função para obter configurações da API
function getApiConfig() {
    return {
        endpoint: $('#api-endpoint').val() || 'http://localhost:8989',
        token: $('#api-token').val()
    };
}

// Função para carregar todas as métricas de clientes
function loadClientMetrics() {
    loadClientsNeverOrdered();
    loadClientsInactive();
    loadClientsActiveRecent();
    loadClientsNewlyConverted();
    loadClientsReactivated();
    loadClientsNews();
}

// Clientes que nunca fizeram pedido
function loadClientsNeverOrdered() {
    const config = getApiConfig();
    $.ajax({
        type: "GET",
        url: config.endpoint + "/api/admin_v1/dashboard/clients/never-ordered",
        contentType: "application/json",
        cache: false,
        headers: {
            'Authorization': 'Bearer ' + config.token
        },
        beforeSend: function () {
            $('#clients-never-ordered').text('...');
            // Mostrar loading na tabela se ela existir
            if ($('#clients-never-sold-tbody').length) {
                $('#clients-never-sold-tbody').html(`
                    <tr>
                        <td colspan="5" class="text-center">
                            <i class="fa fa-spinner fa-spin"></i> Carregando dados...
                        </td>
                    </tr>
                `);
            }
        },
        success: function (result) {
            // A API agora retorna um objeto com 'data' e 'meta'
            let count = result.meta ? result.meta.total : 0;
            $('#clients-never-ordered').text(count);

            // Popular a tabela se ela existir
            if ($('#clients-never-sold-tbody').length) {
                populateClientsNeverSoldTable(result.data || []);
            }
        },
        error: function (xhr, status, error) {
            console.error('Erro ao carregar clientes que nunca pediram:', error);
            $('#clients-never-ordered').text('0');

            // Mostrar erro na tabela se ela existir
            if ($('#clients-never-sold-tbody').length) {
                $('#clients-never-sold-tbody').html(`
                    <tr>
                        <td colspan="7" class="text-center text-danger">
                            Erro ao carregar os dados
                        </td>
                    </tr>
                `);
            }
        }
    });
}

// Função para popular a tabela de clientes que nunca venderam
function populateClientsNeverSoldTable(data) {
    const tbody = $('#clients-never-sold-tbody');

    if (!Array.isArray(data) || data.length === 0) {
        tbody.html(`
            <tr>
                <td colspan="7" class="text-center text-muted">
                    Nenhum cliente encontrado
                </td>
            </tr>
        `);
        return;
    }

    let rows = '';
    let route = $('#route').val();
    data.forEach(function (client) {
        const createdDate = client.created_at ? new Date(client.created_at).toLocaleString('pt-BR') : '-';
        const clientType = client.type && client.type.name ? client.type.name : '-';
        rows += `
             <tr>
                 <td>${client.id || '-'}</td>
                 <td>${client.fantasy_name || '-'}</td>
                 <td>${clientType}</td>
                 <td class="text-center">${createdDate}</td>
                 <td class="text-center">
                    <a href="${route.replace('/0', `/${client.id}`)}" class="btn btn-default white-hover">
                        <i class="fa el-icon-file-edit"></i>
                    </a>
                 </td>
             </tr>
         `;
    });

    tbody.html(rows);
}

// Clientes inativos
function loadClientsInactive() {
    const config = getApiConfig();
    $.ajax({
        type: "GET",
        url: config.endpoint + "/api/admin_v1/dashboard/clients/inactive",
        contentType: "application/json",
        cache: false,
        headers: {
            'Authorization': 'Bearer ' + config.token
        },
        beforeSend: function () {
            $('#clients-inactive').text('...');
            // Mostrar loading na tabela se ela existir
            if ($('#clients-inactive-tbody').length) {
                $('#clients-inactive-tbody').html('<tr><td colspan="7" class="text-center"><i class="fa fa-spinner fa-spin"></i> Carregando dados...</td></tr>');
            }
        },
        success: function (result) {
            // A API agora retorna um objeto com 'data' e 'meta'
            let count = result.meta ? result.meta.total : 0;
            $('#clients-inactive').text(count);

            // Popular a tabela se ela existir
            if ($('#clients-inactive-tbody').length) {
                populateClientsInactiveTable(result.data || []);
            }
        },
        error: function (xhr, status, error) {
            console.error('Erro ao carregar clientes inativos:', error);
            $('#clients-inactive').text('0');
            // Mostrar erro na tabela se ela existir
            if ($('#clients-inactive-tbody').length) {
                $('#clients-inactive-tbody').html('<tr><td colspan="7" class="text-center text-danger">Erro ao carregar dados</td></tr>');
            }
        }
    });
}

// Função para popular a tabela de clientes inativos
function populateClientsInactiveTable(data) {
    const tbody = $('#clients-inactive-tbody');

    if (!data || data.length === 0) {
        tbody.html('<tr><td colspan="7" class="text-center">Nenhum cliente inativo encontrado</td></tr>');
        return;
    }

    let rows = '';
    let route = $('#route').val();
    data.forEach(function(client) {
        const lastOrderDate = client.last_order_date ? new Date(client.last_order_date).toLocaleString('pt-BR') : '-';
        const clientType = client.type && client.type.name ? client.type.name : '-';
        rows += `
            <tr>
                <td>${client.id || '-'}</td>
                <td>${client.fantasy_name || '-'}</td>
                <td>${clientType}</td>
                <td class="text-center">${lastOrderDate}</td>
                <td class="text-center">${client.days_since_last_order}</td>
                <td class="text-center">
                    <a href="${route.replace('/0', `/${client.id}`)}" class="btn btn-default white-hover">
                        <i class="fa el-icon-file-edit"></i>
                    </a>
                </td>
            </tr>
        `;
    });

    tbody.html(rows);
}

// Clientes ativos recentes
function loadClientsActiveRecent() {
    const config = getApiConfig();
    $.ajax({
        type: "GET",
        url: config.endpoint + "/api/admin_v1/dashboard/clients/active-recent",
        contentType: "application/json",
        cache: false,
        headers: {
            'Authorization': 'Bearer ' + config.token
        },
        beforeSend: function () {
            $('#clients-active-recent').text('...');
        },
        success: function (result) {
            let count = result.meta ? result.meta.total : 0;
            $('#clients-active-recent').text(count);
        },
        error: function (xhr, status, error) {
            console.error('Erro ao carregar clientes ativos recentes:', error);
            $('#clients-active-recent').text('0');
        }
    });
}

// Clientes recém convertidos
function loadClientsNewlyConverted() {
    const config = getApiConfig();
    $.ajax({
        type: "GET",
        url: config.endpoint + "/api/admin_v1/dashboard/clients/newly-converted",
        contentType: "application/json",
        cache: false,
        headers: {
            'Authorization': 'Bearer ' + config.token
        },
        beforeSend: function () {
            $('#clients-newly-converted').text('...');
        },
        success: function (result) {
            let count = result.meta ? result.meta.total : 0;
            $('#clients-newly-converted').text(count);
        },
        error: function (xhr, status, error) {
            console.error('Erro ao carregar clientes recém convertidos:', error);
            $('#clients-newly-converted').text('0');
        }
    });
}

// Clientes reativados
function loadClientsReactivated() {
    const config = getApiConfig();
    $.ajax({
        type: "GET",
        url: config.endpoint + "/api/admin_v1/dashboard/clients/reactivated",
        contentType: "application/json",
        cache: false,
        headers: {
            'Authorization': 'Bearer ' + config.token
        },
        beforeSend: function () {
            $('#clients-reactivated').text('...');
        },
        success: function (result) {
            let count = result.meta ? result.meta.total : 0;
            $('#clients-reactivated').text(count);
        },
        error: function (xhr, status, error) {
            console.error('Erro ao carregar clientes reativados:', error);
            $('#clients-reactivated').text('0');
        }
    });
}

// Clientes novos
function loadClientsNews() {
    const config = getApiConfig();
    $.ajax({
        type: "GET",
        url: config.endpoint + "/api/admin_v1/dashboard/clients/news",
        contentType: "application/json",
        cache: false,
        headers: {
            'Authorization': 'Bearer ' + config.token
        },
        beforeSend: function () {
            $('#clients-news').text('...');
        },
        success: function (result) {
            let count = result.meta ? result.meta.total : 0;
            $('#clients-news').text(count);
        },
        error: function (xhr, status, error) {
            console.error('Erro ao carregar clientes novos:', error);
            $('#clients-news').text('0');
        }
    });
}

// Função para visualizar detalhes dos clientes
function viewClientDetails(type, clientId = null) {
    // Aqui você pode implementar a navegação para uma página de detalhes
    // ou abrir um modal com os dados detalhados
    let url = '';

    if (clientId) {
        // Se um ID específico foi fornecido, redireciona para a página do cliente
        url = `/admin/clients/${clientId}`;
    } else {
        // Caso contrário, redireciona para a listagem do tipo
        switch (type) {
            case 'never-ordered':
                url = '/admin/clients/never-ordered';
                break;
            case 'inactive':
                url = '/admin/clients/inactive';
                break;
            case 'active-recent':
                url = '/admin/clients/active-recent';
                break;
            case 'newly-converted':
                url = '/admin/clients/newly-converted';
                break;
            case 'reactivated':
                url = '/admin/clients/reactivated';
                break;
            case 'news':
                url = '/admin/clients/news';
                break;
            default:
                console.error('Tipo de cliente não reconhecido:', type);
                return;
        }
    }

    // Redireciona para a página de detalhes
    window.location.href = url;
}

// Função para editar cliente
function editClient(clientId) {
    const baseRoute = $('#route').val();
    const editRoute = baseRoute.replace('/0', `/${clientId}`);
    window.location.href = editRoute;
}
