$(document).ready(function () {
    selectTypeBank();
    selectTypePix();

    let typePix = $('.selectTypePix').val();
    showTypePix(typePix);

    let typeBank = $('.selectTypeBank').val();
    changeTypeBank(typeBank);
});

$(window).on("load", function () {

});

function changeTypeBank(type) {
    if (type === 'pix') {
        $('.typeBank').hide();
        $('.typeBank input').removeAttr('required');
        $('.contactInput input').removeAttr('required');

        $('.typePix').fadeIn();
        $('.selectTypePix').attr('required', true);
    } else if (type === 'bank') {
        $('.typePix').hide();
        $('.typePix input').removeAttr('required');
        $('.selectTypePix').removeAttr('required');

        $('.typeBank').fadeIn();
        $('.typeBank input').attr('required', true);
        $('.contactInput input').attr('required', true);
        clearInputPix();
    } else {
        $('.typeBank').hide();
        $('.typeBank input').removeAttr('required');

        $('.typePix').hide();
        $('.typePix input').removeAttr('required');
        $('.contactInput input').removeAttr('required');
        $('.selectTypePix').removeAttr('required');
        clearInputPix();
    }
}

function selectTypeBank() {
    $('.selectTypeBank').change(function () {
        let type = $(this).val();
        $('.selectTypePix').val('');
        changeTypeBank(type);
    });
}

function selectTypePix() {
    $('.selectTypePix').change(function () {
        let typePix = $(this).val();
        showTypePix(typePix);
    });
}

function showTypePix(typePix) {
    clearInputPix();
    if (typePix === 'CPF') {
        $('.fieldCPFPix').attr('required', true).fadeIn();
    } else if (typePix === 'CNPJ') {
        $('.fieldCNPJPix').attr('required', true).fadeIn();
    } else if (typePix === 'EMAIL') {
        $('.fieldEmailPix').attr('required', true).fadeIn();
    } else if (typePix === 'PHONE') {
        $('.fieldPhonePix').attr('required', true).fadeIn();
    } else if (typePix === 'EVP') {
        $('.fieldEVPPix').attr('required', true).fadeIn();
    } else {
        $('.labelPix').hide();
        $('.fieldPix').hide();
    }
}

function clearInputPix() {
    $('.labelPix').show();
    $('.fieldPix').hide();
    $('.fieldPix').removeAttr('required');
}