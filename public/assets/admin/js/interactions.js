/**
 * Módulo para gerenciar interações de clientes
 * Pode ser reutilizado em diferentes páginas
 */
var InteractionModule = (function () {
    'use strict';

    var config = {
        modalId: '#modalNewInteraction',
        formId: '#FormInteractionApi',
        buttonClass: '.btn-new-interaction',
        apiEndpoint: null // será definido dinamicamente
    };

    /**
     * Formata uma data para o formato YYYY-MM-DD HH:mm:ss
     * @param {Date|string} date - Data a ser formatada
     * @returns {string} Data formatada no padrão YYYY-MM-DD HH:mm:ss
     */
    function formatDateToMysql(date) {
        var dateObj = new Date(date);
        return dateObj.getFullYear() + '-' + 
            String(dateObj.getMonth() + 1).padStart(2, '0') + '-' + 
            String(dateObj.getDate()).padStart(2, '0') + ' ' + 
            String(dateObj.getHours()).padStart(2, '0') + ':' + 
            String(dateObj.getMinutes()).padStart(2, '0') + ':' + 
            String(dateObj.getSeconds()).padStart(2, '0');
    }

    /**
     * Inicializa o módulo de interações
     * @param {Object} options - Opções de configuração
     */
    function init(options) {
        if (options) {
            $.extend(config, options);
        }

        loadInteractionTypes();
        bindEvents();
    }

    /**
     * Vincula os eventos necessários
     */
    function bindEvents() {
        // Event listener para botão de nova interação
        $(document).on('click', config.buttonClass, function () {
            var clientId = $(this).data('client-id');
            openModal(clientId);
        });

        // Event listener para envio do formulário
        $(document).on('submit', config.formId, function (e) {
            e.preventDefault();
            submitForm();
        });
    }

    /**
     * Carrega os tipos de interação da API
     */
    function loadInteractionTypes() {
        // Buscar endpoint da API a partir da configuração
        var apiEndpoint = $(config.formId).find('input[name="route"]').val();
        if (!apiEndpoint) {
            // Fallback para endpoint padrão se não encontrar
            apiEndpoint = '/api/admin_v1/clients/interaction-types/all';
        } else {
            // Extrair base URL e construir endpoint
            var baseUrl = apiEndpoint.replace('/api/admin_v1/clients/interactions', '');
            apiEndpoint = baseUrl + '/api/admin_v1/clients/interaction-types/all';
        }

        $.ajax({
            url: apiEndpoint,
            type: 'GET',
            headers: {
                'Authorization': 'Bearer ' + $(config.formId).find('.api_v2_token').val(),
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                populateInteractionTypes(response.data);
            },
            error: function (xhr) {
                console.warn('Erro ao carregar tipos de interação da API:', xhr);
            }
        });
    }

    /**
     * Popula o select de tipos de interação
     * @param {Array} types - Array com os tipos de interação
     */
    function populateInteractionTypes(types) {
        var select = $('#interaction_type_id');
        select.empty().append('<option value="">Selecione...</option>');

        types.forEach(function (type) {
            select.append('<option value="' + type.id + '">' + type.name + '</option>');
        });
    }

    /**
     * Abre a modal de interação
     * @param {number} clientId - ID do cliente
     */
    function openModal(clientId) {
        // Definir o client_id no campo hidden
        $('#interaction_client_id').val(clientId);

        // Definir data atual no campo de data do contato
        var now = new Date();
        var formattedDate = now.toISOString().slice(0, 16);
        $('input[name="contact_date"]').val(formattedDate);

        // Limpar mensagens de erro
        $('.def-msg').empty();

        // Resetar formulário
        $(config.formId)[0].reset();
        $('#interaction_client_id').val(clientId); // Manter o client_id após reset
        $('input[name="contact_date"]').val(formattedDate); // Manter a data após reset

        // Abrir modal
        $.magnificPopup.open({
            items: {
                src: config.modalId
            },
            type: 'inline',
            modal: true
        });
    }

    /**
     * Submete o formulário de interação
     */
    function submitForm() {
        var form = $(config.formId);
        var formData = new FormData(form[0]);
        var route = form.find('input[name="route"]').val();

        // Converter FormData para objeto JSON
        var data = {};
        for (var pair of formData.entries()) {
            var key = pair[0];
            var value = pair[1];

            if (key !== 'route' && key !== 'api_v2_token') {
                data[key] = value;
            }
        }

        // Converter data para formato YYYY-MM-DD HH:mm:ss se preenchida
        if (data.contact_date) {
            data.contact_date = formatDateToMysql(data.contact_date);
        }

        // Converter next_contact_date para formato YYYY-MM-DD HH:mm:ss se preenchida
        if (data.next_contact_date) {
            data.next_contact_date = formatDateToMysql(data.next_contact_date);
        }

        // Remover next_contact_date se estiver vazio
        if (!data.next_contact_date) {
            delete data.next_contact_date;
        }

        // Converter IDs para números
        if (data.client_id) data.client_id = parseInt(data.client_id);
        if (data.user_id) data.user_id = parseInt(data.user_id);
        if (data.interaction_type_id) data.interaction_type_id = parseInt(data.interaction_type_id);

        $.ajax({
            url: route,
            type: 'POST',
            data: JSON.stringify(data),
            contentType: 'application/json',
            headers: {
                'Authorization': 'Bearer ' + form.find('.api_v2_token').val(),
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                form.find('.send-form').prop('disabled', true).text('Enviando...');
                $('.def-msg').empty();
            },
            success: function (response) {
                showMessage('success', 'Interação cadastrada com sucesso!');

                setTimeout(function () {
                    closeModal();
                }, 1500);
            },
            error: function (xhr) {
                var errorMessage = 'Erro ao cadastrar interação.';

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    errorMessage = Object.values(errors).flat().join('<br>');
                }

                showMessage('error', errorMessage);
                form.find('.send-form').prop('disabled', false).text('Cadastrar Interação');
            }
        });
    }

    /**
     * Exibe mensagem na modal
     * @param {string} type - Tipo da mensagem (success, error)
     * @param {string} message - Mensagem a ser exibida
     */
    function showMessage(type, message) {
        var alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        $('.def-msg').html('<div class="alert ' + alertClass + '">' + message + '</div>');
    }

    /**
     * Fecha a modal e reseta o formulário
     */
    function closeModal() {
        $.magnificPopup.close();
        $(config.formId)[0].reset();
        $(config.formId).find('.send-form').prop('disabled', false).text('Cadastrar Interação');
        $('.def-msg').empty();
    }

    /**
     * Método público para abrir modal programaticamente
     * @param {number} clientId - ID do cliente
     */
    function openInteractionModal(clientId) {
        openModal(clientId);
    }

    // API pública
    return {
        init: init,
        openModal: openInteractionModal,
        formatDateToMysql: formatDateToMysql
    };
})();

// Auto-inicialização quando o documento estiver pronto
$(document).ready(function () {
    if ($('#modalNewInteraction').length > 0) {
        InteractionModule.init();
    }
});