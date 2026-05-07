let APP_URL = window.location.protocol + '//' + window.location.hostname + '/';

if (window.location.hostname == '127.0.0.1') {
    APP_URL = "http://127.0.0.1:8080/";
    APP_URL_V2 = "http://127.0.0.1:8989/";
}

if (window.location.hostname == 'localhost') {
    APP_URL = "http://localhost:8080/";
    APP_URL_V2 = "http://localhost:8989/";
}

$(document).ready(function () {
    startPlanCheckCommission();
    stateChangeCity();
    getAddrress();
    changeSelected();
    getSelectCategory();
    btnRestrictPlan();
    getPlansByInsurance();
    getClientPaymentMethod();
    selectInsuranceInventaryType();

    masks();

    typeClientRegister();

    if ($("#splitComission").length > 0) {
        changeCuponType();
    }

    if ($("#selectClient").length > 0) {
        changeCuponRestriction();
    }
    planCheckCommission();
    changeClientInvoiceType();

    $("#modal-include-pax").click(function () {
        $("#myModal").css("display", "block");
    });

    $(".close").click(function () {
        $("#myModal").css("display", "none");
    });

    /*
    $(".btn-include-pax").on('click', (e) => {
        e.preventDefault();
        $(".close").hide();

        const formData = getFormData();
    
        if (!formData) {
            $(".close").show();
            return;
        }
    
        $('.btn-include-pax').hide();
        $(".loader-container").fadeIn();

        makeAjaxCall(formData);
    });
    */

    function getFormData() {
        const name = $("input[name='name']").val();
        const date = $("input[name='date']").val();
        const orderId = $("input[name='order_id']").val();
        const document = $("input[name='document']").val();
        const routeInclude = $("input[name='route_include']").val();
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        if (!orderId || !name || !document || !date) {
            return null;
        }

        return { _token: csrfToken, orderId, name, document, date, url: routeInclude };
    }

    function makeAjaxCall(formData) {
        const loaderContainer = $(".loader-container");
        const progressBar = $("#progress-bar");

        let progress = 0;
        let timer;

        loaderContainer.show();
        const startTime = Date.now();
        timer = setInterval(() => {
            const elapsedTime = Date.now() - startTime;
            progress = (elapsedTime / 3000) * 100;
            progressBar.css('width', progress + '%');
            if (progress >= 100) {
                clearInterval(timer);
            }
        }, 30);

        $.ajax({
            method: 'POST',
            url: formData.url,
            data: formData,
            success: (response) => {
                setTimeout(() => {
                    loaderContainer.hide();
                    showAlert('Success', response.message);
                    setTimeout(() => {
                        $(".close").show();
                        $('.btn-include-pax').fadeIn();
                        window.location.reload();
                    }, 5000);
                }, 3000);
            },
            error: (error) => {
                setTimeout(() => {
                    loaderContainer.hide();
                    let message = 'Erro ao incluir passageiro. Tente novamente mais tarde.';
                    if (error.responseJSON.message) {
                        message = error.responseJSON.message;
                    }
                    showAlert('Error', message);
                    setTimeout(() => {
                        $(".close").show();
                        $('.btn-include-pax').fadeIn();
                    }, 5000);
                }, 3000);
            },
            complete: () => {
                clearInterval(timer);
                progressBar.css('width', '0%');
            }
        });
    }

    function showAlert(type, message) {
        const alertElement = $(`#alert${type}`);
        $(".alert").stop(true, true).hide();
        $(".container-alerts").show();
        alertElement.html(message);
        alertElement.show();

        setTimeout(() => {
            alertElement.hide();
            $(".container-alerts").hide();
        }, 5000);
    }

    getClientsBySeller();
    getClientSubAccount();

    let timestamp = $('.auxGallery').attr('data-timestamp');
    let token = $('.auxGallery').attr('data-token');
    let token2 = $('.auxGallery').attr('data-token-2');
    let uploadScript = $('.auxGallery').attr('data-uploadScript');

    if (uploadScript) {
        $(function () {
            $('#file_upload').uploadifive({
                'auto': false,
                //'checkScript'      : 'check-exists.php',
                'buttonText': 'Selecionar imagem',
                'formData': {
                    'timestamp': timestamp,
                    '_token': token,
                    'token': token2
                },
                'queueID': 'queue',
                'uploadScript': uploadScript,
                'onQueueComplete': function () {
                    location.reload();
                }
            });
        });
    }
});

function masks() {
    $("input.dinheiro").maskMoney({ showSymbol: true, symbol: "R$ ", decimal: ",", thousands: "." });
    $("input.decimal").maskMoney({ showSymbol: true, symbol: "", decimal: ",", thousands: "." });
    let masks = ['(00) 00000-0000', '(00) 0000-00009'];
    $(".masked-phone").mask(masks[1], {
        onKeyPress: function (val, e, field, options) {
            field.mask(val.length > 14 ? masks[0] : masks[1], options);
        }
    });
    $(".masked-cpf").mask("999.999.999-99");
    $(".masked-cnpj").mask("99.999.999/9999-99");
}

function planCheckCommission() {
    $('.planCheckCommission').change(function () {
        let type = $(this).val();
        if (type === 'fixed') {
            $('.inputCheckCommission').show();
        }

        if (type === '0,00') {
            $('.inputCheckCommission').hide();
            $('#commission').val('0,00');
        }

        if (type === 'no') {
            $('.inputCheckCommission').hide();
            $('#commission').val('');
        }
    });
}

function startPlanCheckCommission() {
    let typeStart = $('.planCheckCommission').val();
    if (typeStart === 'fixed') {
        $('.inputCheckCommission').show();
    }

    if (typeStart === '0,00') {
        $('.inputCheckCommission').hide();
    }

    if (typeStart === 'no') {
        $('.inputCheckCommission').hide();
    }
}

function typeClientRegister() {
    let check = $('.formEditClient').attr('data-check');
    if (check == 1) {
        let type = $('#clientType option:selected').val();
        getTypeClient(type);
    }

    $('#clientType').change(function () {
        let type = $(this).val();
        getTypeClient(type);
    });
}

function getTypeClient(type) {
    switch (type) {
        case '1':
            $(".registerBank").hide();
            $(".registerFinancial").hide();
            $(".registerCNPJ").hide();
            $(".registerCPForCNPJ").hide();
            $(".registerCPF").fadeIn();
            $(".registerSusep").hide();
            break;
        case '2':
            $(".registerBank").fadeIn();
            $(".registerFinancial").hide();
            $(".registerCNPJ").hide();
            $(".registerCPForCNPJ").hide();
            $(".registerCPF").fadeIn();
            $(".registerSusep").hide();
            break;
        case '3':
            $(".registerBank").fadeIn();
            $(".registerFinancial").fadeIn();
            $(".registerCNPJ").hide();
            $(".registerCPForCNPJ").fadeIn();
            $(".registerCPF").hide();
            $(".registerSusep").hide();
            break;
        case '4':
            $(".registerBank").fadeIn();
            $(".registerFinancial").fadeIn();
            $(".registerCNPJ").fadeIn();
            $(".registerCPForCNPJ").hide();
            $(".registerCPF").fadeIn();
            $(".registerSusep").hide();
            break;
        case '5':
            $(".registerBank").fadeIn();
            $(".registerFinancial").fadeIn();
            $(".registerCNPJ").fadeIn();
            $(".registerCPForCNPJ").hide();
            $(".registerCPF").fadeIn();
            $(".registerSusep").fadeIn();
            break;
        case '6':
            $(".registerBank").fadeIn();
            $(".registerFinancial").fadeIn();
            $(".registerCNPJ").fadeIn();
            $(".registerCPForCNPJ").hide();
            $(".registerCPF").fadeIn();
            $(".registerSusep").hide();
            break;
        default:
    }
}

function getSelectCategory() {
    $('#category').change(function () {
        let id = $(this).val();
        $.ajax({
            type: "GET",
            url: APP_URL + "admin/category/sub-category/getSelectCategory/" + id,
            data: { id: id },
            beforeSend: function () {
                $('#subcategory').html('<option value="">Carregando...</option>');
            },
            success: function (html) {
                $('#subcategory').html(html);
            }
        });
        return false;
    });
}

$('.optionBanner').change(function () {
    let type = $(this).val();
    if (type === 'image') {
        $('.showImage').fadeIn();
        $('.showImage input').prop('required', true);
        $('.showImage input.link_url').prop('required', false);
        $('.showVideo').hide();
        $('.showVideo input').prop('required', false);
    } else {
        $('.showVideo').fadeIn();
        $('.showVideo input').prop('required', true);
        $('.showImage').hide();
        $('.showImage input').prop('required', false);
    }
});

$('.optionCity').change(function () {
    let type = $(this).val();
    if (type === 'iframe' || type === 'link_url') {
        $('.showLink').fadeIn();
        $('.showLink input').prop('required', true);
    } else {
        $('.showLink').hide();
        $('.showLink input').prop('required', false);
    }
});

$('#switch-free').on('change', function () {
    if ($(this).is(':checked')) {
        $(this).val(1);
    } else {
        $(this).val(0);
    }

    const free = $(this).val();
    const url = $("#free_path").val();
    const id = $("#order_plan_id").val();
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        method: 'POST',
        url: url,
        data: { id, _token: csrfToken, free },
        success: (response) => {
            console.log(response);
            setTimeout(() => { window.location.reload(true) }, 2000);
        },
        error: (error) => {
            console.log(error);
        }
    });
});

$('#switch-change').on('change', function () {
    if ($(this).is(':checked')) {
        $(this).val(1);
    } else {
        $(this).val(0);
    }

    const free_insurance = $(this).val();
    const url = $("#switch-route").val();
    const id = $("#order_plan_id").val();
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        method: 'POST',
        url: url,
        data: { id, _token: csrfToken, free_insurance: free_insurance },
        success: (response) => {
            console.log(response);
            setTimeout(() => { window.location.reload(true) }, 2000);
        },
        error: (error) => {
            console.log(error);
        }
    });

});


function changeSelected() {
    $('.changeSelected').change(function () {
        let vClass = $(this).attr('data-classe');
        let id = $(this).val();
        let route = $(this).attr('data-route');
        route = route.replace('/0', '/' + id);
        $.ajax({
            type: "GET",
            url: route,
            beforeSend: function () {
                $('.' + vClass).prev('span').find('p').html('Localizando...');
            },
            success: function (result) {
                $('.' + vClass).html(result);
            }
        });
        return false;
    });
}

function stateChangeCity() {
    $('.uf').change(function () {
        let id = $(this).val();
        let vClass = $(this).attr('data-classe');
        $.ajax({
            type: "GET",
            url: APP_URL + "admin/ajax/cityByStateSelect/" + id,
            beforeSend: function () {
                $('.selectCities').html('<option>Carregando...</option>');
            },
            success: function (result) {
                //$('.selectCities').html(result);
                $('#city_id').html(result);
            }
        });
        return false;
    });
}

function getAddrress() {
    $('#zip_code').blur(function () {
        let zip_code = $('#zip_code').val();
        //zip_code = zip_code.replace(' ', '').replace('-', '');
        $('.address').fadeOut();
        $.ajax({
            url: APP_URL + 'admin/ajax/getAddress/' + zip_code,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('.address').fadeIn();
                if (data.success) {
                    $('#address').val(data.dados.address);
                    $('#district').val(data.dados.district);
                    $('#state_id').val(data.dados.state_id);
                    getSelectCities(data.dados.state_id, data.dados.city_id);
                    $('#number').focus();
                } else {
                    alert('CEP não encontrado!');
                }
            }
        });
        return false;
    });
}

function getSelectCities(state_id, city_id) {
    if (state_id !== '') {
        $.ajax({
            url: APP_URL + 'admin/ajax/citiesSelect/' + state_id + '/' + city_id,
            type: 'GET',
            dataType: 'html',
            success: function (result) {
                $('#city_id').html(result);
            }
        });
    }
    return false;
}

function changeCuponType() {
    /*let type = $("#type").val();
    if (type != 'client') {
        $("#splitComission").hide();
    } else {
        $("#splitComission").show();
    }
    $("#type").change(function(){
        let type = $(this).val();
        if (type == 'client') {
            $("#splitComission").show();
            $("#value_client").prop("required", true);
        } else {
            $("#value_client").prop("required", false);
            $("#splitComission").hide();
        }
    });*/
}

function changeCuponRestriction() {
    let restriction = $("#restriction").val();
    console.log(restriction);

    if (restriction == 'commission') {
        $("#splitComission").show();
        $("#value_client").prop("required", true);
    } else {
        $("#splitComission").hide();
        $("#value_client").prop("required", false);
    }

    if (restriction == 'commission' || restriction == 'client') {
        $("#selectClient").show();
    } else {
        $("#selectClient").hide();
    }

    $("#restriction").change(function () {
        let restriction = $(this).val();

        if (restriction == 'commission') {
            $("#splitComission").show();
            $("#value_client").prop("required", true);
        } else {
            $("#splitComission").hide();
            $("#value_client").prop("required", false);
        }

        if (restriction == 'commission' || restriction == 'client') {
            $("#selectClient").show();
            $("#client_id").prop("required", true);
        } else {
            $("#client_id").prop("required", false);
            $("#selectClient").hide();
        }
    });
}

function changeClientInvoiceType() {
    $('.selectClientInvoiceType').change(function () {
        let value = $(this).val();
        if (value == 'defined') {
            $('.invoice-day').removeClass('none');
        } else {
            $('.invoice-day').addClass('none');
        }
    });
}

function getClientsBySeller() {
    $('.selectSaller').change(function () {
        const sellerId = $(this).val();

        $.ajax({
            type: "GET",
            url: APP_URL + "admin/client/client/select-by-seller/" + sellerId,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('.select-client').html('<option value="">Buscando clientes...</option>');
            },
            success: function (result) {
                $('.select-client').html(result);
            },
        });
        return false;
    });
}

function getClientSubAccount() {
    $(".select-client").change(function () {
        let id = $(this).val();

        $.ajax({
            type: "GET",
            url: APP_URL + "admin/order/order/create/get-sub-accounts/" + id,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('select[name="client_sub_account_id"]').val("Pesquisando...");
                $('.selectSubAccount').val("Pesquisando...");
            },
            success: function (result) {
                $('select[name="client_sub_account_id"]').html(result);
                $('.selectSubAccount').html(result);
            },
        });
        return false;
    });
}

function btnRestrictPlan() {
    $('.btnRestrictPlan').change(function () {
        let value = $(this).val();
        if (value == 'y') {
            $('.inputRestrictPlan').removeClass('hide');
            $('.inputRestrictPlan').show();
        } else {
            $('.inputRestrictPlan').hide();
        }
    });
}

function getPlansByInsurance() {
    $(".getPlansByInsurance").change(function () {
        let insuranceId = $(this).val();

        $.ajax({
            type: "GET",
            url: APP_URL + "admin/insurance/plan/select-by-insurance/" + insuranceId,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('select[name="insurance_plan_id"]').val("Pesquisando...");
            },
            success: function (result) {
                $('select[name="insurance_plan_id"]').html(result);
            },
        });
        return false;
    });
}

function selectInsuranceInventaryType() {
    $('#inventoryType').change(function () {
        if ($(this).val() == 'client') {
            $('#clientSelectContainer').show();
        } else {
            $('#clientSelectContainer').hide();
        }
    });

    $('#allowNegativeBalance, #editAllowNegativeBalance').change(function () {
        if ($(this).val() == 1) {
            $('#negativeBalanceLimitContainer, #editNegativeBalanceLimitContainer').show();
        } else {
            $('#negativeBalanceLimitContainer, #editNegativeBalanceLimitContainer').hide();
        }
    });

    $('.editInventory').click(function () {
        let allowNegativeBalance = $(this).data('allow-negative');
        let negativeBalanceLimit = $(this).data('negative-limit');

        $('#editAllowNegativeBalance').val(allowNegativeBalance);
        $('#editNegativeBalanceLimitContainer').val(negativeBalanceLimit);
        $('#editInventoryRoute').val($(this).data('route'));

        if (allowNegativeBalance == 1) {
            $('#editNegativeBalanceLimitContainer').show();
        } else {
            $('#editNegativeBalanceLimitContainer').hide();
        }
    });
}

function getClientPaymentMethod() {
    $(".select-client-payment-methods").change(function () {
        let id = $(this).val();
        $.ajax({
            type: "GET",
            url: APP_URL + "admin/order/order/create/get-payment-methods/" + id,
            contentType: false,
            cache: false,
            processData: false,

            beforeSend: function () {
                $('select[name="payment_method_id"]').val("Pesquisando...");
                $('.selectPaymentMethod').val("Pesquisando...");
            },

            success: function (result) {
                $('select[name="payment_method_id"]').html(result);
                $('.selectPaymentMethod').html(result);
            },
        });
        return false;
    });
}