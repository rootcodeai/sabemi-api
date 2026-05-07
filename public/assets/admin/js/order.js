$(document).ready(function () {
  getInsurance();
  stateChangeCity();
  getAddrress();
  getAddrressId();
  getPlan();
  //getResume();
  getPlansInsurance();
  markup();
  plansGetMarkup();
  setAddress();
  setContact();
  selectFilterIndex();
  addPassenger();
  calculateAgeByDate();
  selectDocument();
  selectDocumentSingle();
  searchPassenger();
  changeHasMarkup();

  $(document).on('click', '.btn-utilize-data', function () {
    $('#contact_name').val($(this).attr('data-fantasy-name'));
    $('#contact_phone').val($(this).attr('data-phone'));
    $('#contact_email').val($(this).attr('data-email'));
  });

  $(document).on('change', '.select-plan', function () {
     let insurancePlanId = $(this).val();

     if (insurancePlanId && insurancePlanId != "" && !isNaN(insurancePlanId)) {
       $.ajax({
         type: "GET",
         url: APP_URL + "admin/insurance/insurance/inventories/search/" + insurancePlanId,
         dataType: "json",
         beforeSend: function () {
           //container.html('<div class="col-md-12 text-center"><i class="fa fa-spinner fa-spin"></i> Buscando inventários...</div>');
         },
         success: function (response) {
           if (response && response.length > 0) {
              $('.inventory').show();
           } else {
              $('.inventory').hide();
           }
         },
         error: function () {
         }
       });
     } else {
     }
   });

});

  $(window).on("load", function () {
    $(".btn-voucher-admin").removeClass('disabled');
    btnGenerateVoucher();
  })

  function selectFilterIndex() {
    $('.selectIndex').change(function () {
      $('.filterOrder').hide();
      $('.filterOrder input').val('');

      let value = $(this).val();
      $('.' + value).fadeIn();
    });
  }

  function btnGenerateVoucher() {
    $('.btn-voucher-admin').click(function () {
      $.ajax({
        type: "GET",
        url: APP_URL + "admin/order/order/generate-voucher/" + $(this).attr('data-id'),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {
          $('.btn-voucher-admin').hide();
          $('.btn-gerando-vouchers').fadeIn();
        },
        success: function (result) {
          $('select[name="insurance_id"]').html(result);
        },
      });
      return false;
    });
  }

  function markup() {
    $(".selectMarkup").change(function () {
      let markup = $(this).val();
      if (markup == "y") {
        $(".select_markup_percent").show();
        $(".markup_percent").find("input").prop("required", true);
      } else {
        $(".select_markup_percent").hide();
        $(".markup_percent").find("input").prop("required", false);
      }

      let markupValue = $(".markup_percent").val();

      // update plans with markup
      $(".select-plan").each(function () {
        let age = $(this).closest(".row").find(".age").val();
        let id = $(this).attr("data-id");
        getPlansByAge(age, id, markupValue);
      });

    });
  }

  function getInsurance() {
    $(".order-destiny, .order-type-trip").change(function () {
      let params =
        "?destiny_id=" +
        $(".order-destiny").val() +
        "&type_trip_id=" +
        $(".order-type-trip").val();

      $.ajax({
        type: "GET",
        url: APP_URL + "admin/order/order/create/getInsurances" + params,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {
          $('select[name="insurance_id"]').val("Pesquisando...");
        },
        success: function (result) {
          $('select[name="insurance_id"]').html(result);
        },
      });
      return false;
    });
  }

  function getPlansInsurance() {
    $(".order-insurance").change(function () {
      let params =
        "?destiny_id=" +
        $(".order-destiny").val() +
        "&type_trip_id=" +
        $(".order-type-trip").val() +
        "&from=" +
        $(".order-from").val() +
        "&to=" +
        $(".order-to").val() +
        "&insurance_id=" +
        $(this).val() +
        "&client_id=" +
        $(".select-client").val();

      $.ajax({
        type: "GET",
        url: APP_URL + "admin/order/order/create/getPlans" + params,
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

  function getResume() {
    $(".select-plan").change(function () {
      alert('asdasd');
      /** 
      $.ajax({
        type: "GET",
        url: APP_URL + "admin/order/order/create/getResume",
        data: $("#formCreateOrder").serialize(),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {
          $(".create-order-resume").html("Atualizando....");
        },
        success: function (result) {
          $(".create-order-resume").html(result);
        },
      });
      return false;
      */
    });
  }

  function stateChangeCity() {
    $(".uf").change(function () {
      let id = $(this).val();
      let i = $(this).attr("data-id");
      $.ajax({
        type: "GET",
        url: APP_URL + "admin/ajax/cityByStateSelect/" + id,
        beforeSend: function () {
          $(".select-city-" + i).html("<option>Localizando cidades...</option>");
        },
        success: function (result) {
          $(".select-city-" + i).html(result);
        },
      });
      return false;
    });
  }

  function getAddrressId() {
    $('#zip_code').blur(function () {

      let zip_code = $('#zip_code').val();
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

            getSelectCities(data.dados.state_id, data.dados.city_id, 0, true);

            $('#number').focus();
          } else {
            alert('CEP não encontrado!');
          }
        }
      });
      return false;
    });
  }

  function getAddrress() {
    $(".zip-code").blur(function () {
      let id = $(this).attr("data-id");
      let zip_code = $('input[name="passenger[' + id + '][zip_code]"]').val();

      if (zip_code) {
        $.ajax({
          url: APP_URL + "admin/ajax/getAddress/" + zip_code,
          type: "GET",
          dataType: "json",
          beforeSend: function () {
            $('input[name="passenger[' + id + '][address]"]').val("Pesquisando...");
            $('input[name="passenger[' + id + '][district]"]').val(
              "Pesquisando..."
            );
          },
          success: function (data) {
            if (data.success) {
              getSelectCities(data.dados.state_id, data.dados.city_id, id);

              $('input[name="passenger[' + id + '][address]"]').val(
                data.dados.address
              );
              $('input[name="passenger[' + id + '][district]"]').val(
                data.dados.district
              );

              setStateId(id, data.dados.state_id);

              $('input[name="passenger[' + id + '][number]"]').focus();
            } else {
              alert("CEP não encontrado!");
            }
          },
        });

        return false;
      }
    });
  }

  function getSelectCities(state_id, city_id, id, sigle = false) {
    if (state_id !== "") {
      $.ajax({
        url: APP_URL + "admin/ajax/citiesSelect/" + state_id + "/" + city_id,
        type: "GET",
        dataType: "html",
        beforeSend: function () {
          if (sigle) {
            $('#city_id').html("<option>Pesquisando...</option>");
          } else {
            $('select[name="passenger[' + id + '][city_id]"]').html(
              "<option>Pesquisando...</option>"
            );
          }
        },
        success: function (result) {
          if (sigle) {
            $('#city_id').html(result);
            $('#city_id').val(city_id);
          } else {
            $('select[name="passenger[' + id + '][city_id]"]').html(result);
          }

          setStateId(id, state_id, sigle);
        },
      });
    }
    return false;
  }

  function setStateId(id, state_id, sigle = false) {
    if (sigle) {
      $('#state_id').val(state_id);
    } else {
      $('select[name="passenger[' + id + '][state_id]"]').val(state_id).select2();
    }
  }

  function getPlan() {
    $(".age").focusout(function () {

      let age = $(this).val();
      let id = $(this).attr("data-id");
      let markup = $(".markup_percent").val();

      getPlansByAge(age, id, markup)
    });
  }

  function getPlansByAge(age, id, markup) {
    if (age) {
      getPlansAjax(id, markup);
    }
  }

  function plansGetMarkup() {
    $(".markup_percent").focusout(function () {
      let searchParams = new URLSearchParams(window.location.search);
      let amount = searchParams.get("amount");
      let markup = $(this).val();

      for ($i = 0; $i < amount; $i++) {
        getPlansAjax($i, markup);
      }
    });
  }

  function getPlansAjax(id = null, markup = null) {
    let searchParams = new URLSearchParams(window.location.search);
    let destiny_id = searchParams.get("destiny_id");
    let from = searchParams.get("from");
    let to = searchParams.get("to");
    let type_trip_id = searchParams.get("type_trip_id");

    setTimeout(function () {
      let params =
        "?destiny_id=" +
        destiny_id +
        "&from=" +
        from +
        "&to=" +
        to +
        "&type_trip_id=" +
        type_trip_id +
        "&age=" +
        $('input[name="passenger[' + id + '][age]"]').val();

      if (markup && $('.selectMarkup').val() == 'y') {
        params += "&markup=" + markup;
      }

      let oldId = $('select[name="passenger[' + id + '][insurance_plan_id]"] option:selected').val();
      if (oldId) {
        params += "&old_id=" + oldId;
      }

      params += "&client_id=" + searchParams.get("client_id");

      $.ajax({
        url: APP_URL + "admin/order/order/create/getPlans" + params,
        type: "GET",
        dataType: "html",
        beforeSend: function () {
          $('select[name="passenger[' + id + '][insurance_plan_id]"]').html(
            "<option>Pesquisando...</option>"
          );
        },
        success: function (result) {
          $('select[name="passenger[' + id + '][insurance_plan_id]"]').html(
            result
          );
        },
      });
    }, 1000);
  }

  function setAddress() {
    $('.setAddress').change(function () {
      let passagerSelected = $(this).val();
      let id = $(this).attr('data-id');

      if (passagerSelected == 98) {
        $('input[name="passenger[' + id + '][zip_code]"]').val($('input[name="client_selected[zip_code]"]').val());
        $('input[name="passenger[' + id + '][address]"]').val($('input[name="client_selected[address]"]').val());
        $('input[name="passenger[' + id + '][district]"]').val($('input[name="client_selected[district]"]').val());
        $('input[name="passenger[' + id + '][number]"]').val($('input[name="client_selected[number]"]').val());
        $('input[name="passenger[' + id + '][complement]"]').val($('input[name="client_selected[complement]"]').val());

        let state_id = $('input[name="client_selected[state_id]"]').val();
        setStateId(passagerSelected, state_id);

        let city_id = $('input[name="client_selected[city_id]"]').val();
        getSelectCities(state_id, city_id, id);
        $('select[name="passenger[' + id + '][city_id]"]').children("option[value=" + city_id + "]").attr("selected", "selected");
      }

      if (passagerSelected != 99 && passagerSelected != 98) {
        $('input[name="passenger[' + id + '][zip_code]"]').val($('input[name="passenger[' + passagerSelected + '][zip_code]"]').val());
        $('input[name="passenger[' + id + '][address]"]').val($('input[name="passenger[' + passagerSelected + '][address]"]').val());
        $('input[name="passenger[' + id + '][district]"]').val($('input[name="passenger[' + passagerSelected + '][district]"]').val());


        $('input[name="passenger[' + id + '][number]"]').val($('input[name="passenger[' + passagerSelected + '][number]"]').val());
        $('input[name="passenger[' + id + '][complement]"]').val($('input[name="passenger[' + passagerSelected + '][complement]"]').val());

        let state_id = $('select[name="passenger[' + passagerSelected + '][state_id]"]').val();
        //$('select[name="passenger[' + id + '][state_id]"]').children("option[value=" + state_id + "]").attr("selected", "selected");
        setStateId(passagerSelected, state_id);

        let city_id = $('select[name="passenger[' + passagerSelected + '][city_id]"]').val();

        getSelectCities(state_id, city_id, id);
        $('select[name="passenger[' + id + '][city_id]"]').children("option[value=" + city_id + "]").attr("selected", "selected");
      }
    });
  }

  function setContact() {
    $('.setContact').change(function () {
      let passagerSelected = $(this).val();
      let id = $(this).attr('data-id');

      if (passagerSelected == 98) {
        $('input[name="passenger[' + id + '][contact_name]"]').val($('input[name="client_selected[company_name]"]').val());
        $('input[name="passenger[' + id + '][contact_phone]"]').val($('input[name="client_selected[phone]"]').val());
        $('input[name="passenger[' + id + '][contact_email]"]').val($('input[name="client_selected[email]"]').val());
      }

      if (passagerSelected != 99 && passagerSelected != 98) {
        $('input[name="passenger[' + id + '][contact_name]"]').val($('input[name="passenger[' + passagerSelected + '][contact_name]"]').val());
        $('input[name="passenger[' + id + '][contact_phone]"]').val($('input[name="passenger[' + passagerSelected + '][contact_phone]"]').val());
        $('input[name="passenger[' + id + '][contact_email]"]').val($('input[name="passenger[' + passagerSelected + '][contact_email]"]').val());
      }
    });
  }

  function addPassenger() {
    $('#fAddPassenger').on('submit', function (event) {

      event.preventDefault();

      $('#fAddPassenger .container-alerts').fadeIn();
      $('.btn-include-pax').hide();

      let formData = new FormData(this);

      let formObject = {};
      formData.forEach((value, key) => {
        formObject[key] = value;
      });

      if (formObject.date_birth) {
        formObject.date_birth = formatDateBar(formObject.date_birth);
      }

      const token = $('.api_v2_token').val();

      $.ajax({
        type: "POST",
        contentType: 'application/json',
        data: JSON.stringify(formObject),
        url: $('#fAddPassenger #route-api').val(),
        headers: {
          'Authorization': token
        },
        beforeSend: function () {
          $('#fAddPassenger .container-alerts #alertError').hide();
          $('#fAddPassenger .container-alerts #alertSuccess').hide();
          $('#fAddPassenger .container-alerts #alertInfo').fadeIn();
        },
        success: function (result) {
          $('#fAddPassenger .container-alerts #alertInfo').hide();
          $('#fAddPassenger .container-alerts #alertSuccess').fadeIn();

          $('input[type=text],input[type=email], textarea, select').val('');

          location.reload();

          $('.btn-include-pax').fadeIn();
        },
        error: function (result) {
          $('#fAddPassenger .container-alerts #alertInfo').hide();

          let msgError = '';
          if (result.responseJSON && result.responseJSON.message) {
            msgError = result.responseJSON.message;
          } else if (result.responseJSON && result.responseJSON.errors) {
            let arr = result.responseJSON.errors;
            $.each(arr, function (index, value) {
              if (value.length !== 0) {
                msgError += '* ' + value + '<br />';
              }
            });
          } else {
            msgError = 'Ocorreu um erro inesperado.';
          }

          $('#fAddPassenger .container-alerts #alertError').html(msgError);
          $('#fAddPassenger .container-alerts #alertError').fadeIn();

          $('.btn-include-pax').fadeIn();
        }
      });
      return false;
    });

  }

  function formatDateBar(date) {
    let parts = date.split('/');
    return `${parts[2]}-${parts[1]}-${parts[0]}`;
  }

  function calculateAgeByDate() {
    $('.dateBirth').blur(function () {
      let id = $(this).attr('data-id');
      let date_birth = $(this).val();

      setDateBirth(id, date_birth);
    });
  }

  function setDateBirth(id, date_birth) {
    let age = calculateAge(date_birth);
    let markup = $(".markup_percent").val();

    $('input[name="passenger[' + id + '][age]"]').val(age);
    getPlansByAge(age, id, markup)
  }

  function calculateAge(birthDate) {
    const [day, month, year] = birthDate.split("/").map(Number);
    const today = new Date();
    const currentYear = today.getFullYear();
    const currentMonth = today.getMonth() + 1;
    const currentDay = today.getDate();

    let age = currentYear - year;

    if (currentMonth < month || (currentMonth === month && currentDay < day)) {
      age--;
    }

    return age;
  }

  function changeHasMarkup() {

  }

  function selectDocument() {
    $(".selectDocument").change(function () {
      let value = $(this).val();
      let id = $(this).attr("data-id");
      let text = $(this).find("option:selected").text();

      setDocument(value, text, id);
    });
  }

  function selectDocumentSingle() {
    $(".selectDocumentSingle").change(function () {
      let value = $(this).val();
      let text = $(this).find("option:selected").text();

      setDocumentSingle(value, text);
    });
    $(".selectDocumentSingle").trigger('change');
  }

  function setDocumentSingle(value, text) {
    var $form = $('#fAddPassenger');
    var $doc = $form.find('input[name="doc"]');
    var $dateContainer = $form.find('.passenger-date-password');
    var $date = $form.find('input[name="date_passport"]');

    $dateContainer.hide();
    $date.prop('required', false);

    $doc.val('');
    $doc.attr('placeholder', '');
    try { $doc.unmask(); } catch (e) { }

    $doc.prop('required', true);

    if (value == 1) {
      $doc.attr('placeholder', '999.999.999-99');
      $doc.mask('999.999.999-99');
    } else if (value == 2) {
      $doc.attr('placeholder', 'ABC-2HFH2HY');
      $dateContainer.fadeIn();
      $date.prop('required', true);
    } else if (value == 3) {
      $doc.attr('placeholder', '9999999999');
      $doc.mask('9999999999');
    } else {
      // sem máscara e sem placeholder
    }
  }

  function setDocument(value, text, id) {
    if (value == 1) {
      // CPF
      $('.passenger-cpf-' + id).show();
      $('input[name="passenger[' + id + '][cpf]"]').prop("required", true);

      // Other
      $('.passenger-doc-' + id).hide();
      $('input[name="passenger[' + id + '][doc]"]').prop("required", false);

      // Date passport
      $('.passenger-date-password-' + id).fadeOut();
      $('input[name="passenger[' + id + '][date_passport]"]').prop("required", false);
    } else if (value == 2) {
      // CPF
      $('.passenger-cpf-' + id).hide();
      $('input[name="passenger[' + id + '][cpf]"]').prop("required", false);

      // Other
      $('label[for="passenger[' + id + '][doc]"]').text(text + ' *');
      $('.passenger-doc-' + id).show();
      $('input[name="passenger[' + id + '][doc]"]').prop("required", true);

      // Date passport
      $('.passenger-date-password-' + id).fadeIn();
      $('input[name="passenger[' + id + '][date_passport]"]').prop("required", true);
    } else {
      // CPF
      $('.passenger-cpf-' + id).hide();
      $('input[name="passenger[' + id + '][cpf]"]').prop("required", false);

      // Other
      $('label[for="passenger[' + id + '][doc]"]').text(text + ' *');
      $('.passenger-doc-' + id).show();
      $('input[name="passenger[' + id + '][doc]"]').prop("required", true);

      // Date passport
      $('.passenger-date-password-' + id).fadeOut();
      $('input[name="passenger[' + id + '][date_passport]"]').prop("required", false);
    }
  }

  function searchPassenger() {
    $('.searchPassenger').blur(function () {

      let id = $(this).attr('data-id');

      let date_birth = $('input[name="passenger[' + id + '][date_birth]"]').val();
      if (date_birth) {
        date_birth = convertFormatDateTwo(date_birth);
      }

      let document_id = $('select[name="passenger[' + id + '][document_id]"]').val();

      let doc = $('input[name="passenger[' + id + '][doc]"]').val();
      if (document_id == 1) {
        doc = $('input[name="passenger[' + id + '][cpf]"]').val();
      }

      let clientId = $('#formCreateOrder input[name="client_id"]').val();

      let data = JSON.stringify({
        'document_id': document_id,
        'doc': doc,
        'date_birth': date_birth,
        'client_id': clientId
      });

      let fields = [
        { name: 'name', value: '' },
        { name: 'email', value: '' },
        { name: 'phone', value: '' },
        { name: 'date_birth', value: '' },
        { name: 'date_passport', value: '' },
        { name: 'zip_code', value: '' },
        { name: 'address', value: '' },
        { name: 'district', value: '' },
        { name: 'state_id', value: '' },
        { name: 'city_id', value: '' },
        { name: 'number', value: '' },
        { name: 'complement', value: '' },
        { name: 'contact_name', value: '' },
        { name: 'contact_phone', value: '' },
        { name: 'contact_email', value: '' }
      ];

      const route = $('.api_v2_route').val();
      const token = $('.api_v2_token').val();

      $.ajax({
        type: "POST",
        data: data,
        contentType: "application/json",
        cache: false,
        processData: false,
        url: route + '/api/cart/search-passenger', headers: {
          'Authorization': token
        },
        headers: {
          'Authorization': $('.api_v2_token').val(),
          'Accept': 'application/json',
        },
        beforeSend: function () {
          fillFields(id, fields, 'Buscando...');
        },
        success: function (result) {
          let passenger = result.data;

          let formattedDate = passenger.date_birth;
          if (formattedDate) {
            formattedDate = formatDate(passenger.date_birth);
          }

          let formattedDatePassport = passenger.date_passport;
          if (formattedDatePassport) {
            formattedDatePassport = formatDate(passenger.date_passport);
          }

          passengerFields = [
            { name: 'name', value: passenger.name },
            { name: 'email', value: passenger.email },
            { name: 'phone', value: passenger.phone },
            { name: 'date_birth', value: formattedDate },
            { name: 'date_passport', value: formattedDatePassport },
            { name: 'date_passport', value: '' },
            { name: 'zip_code', value: passenger.zip_code },
            { name: 'address', value: passenger.address },
            { name: 'district', value: passenger.district },
            { name: 'state_id', value: passenger.state_id },
            { name: 'city_id', value: passenger.city_id },
            { name: 'number', value: passenger.number },
            { name: 'complement', value: passenger.complement },
            { name: 'contact_name', value: passenger.contact_name },
            { name: 'contact_phone', value: passenger.contact_phone },
            { name: 'contact_email', value: passenger.contact_email }
          ];

          fillFields(id, passengerFields);
        },
        error: function (result) {
          fillFields(id, fields, '');

          let arr = result.responseJSON.errors;
          let msgError = '';
          $.each(arr, function (index, value) {
            if (value.length !== 0) {
              msgError += value + '<br />';
            }
          });
          console.dir(msgError);
        }
      });

    });
  }

  function fillFields(id, fields, defaultValue) {
    fields.forEach(function (field) {
      let selector = 'input[name="passenger[' + id + '][' + field.name + ']"]';

      if (field.name == 'state_id' && field.value !== '') {
        $('select[name="passenger[' + id + '][' + field.name + ']"]')
          .children('option[value=' + field.value + ']')
          .attr("selected", "selected");
      }

      if (field.name == 'city_id' && field.value !== '') {
        let state_id = $('select[name="passenger[' + id + '][state_id]"]').val();
        getSelectCities(state_id, field.value, id);
      }

      if (field.name == 'date_birth' && field.value !== '') {
        setDateBirth(id, field.value);
      }

      if ($(selector).val() === '' || $(selector).val() === 'Buscando...') {
        $(selector).val(defaultValue !== undefined ? defaultValue : field.value);
      }
    });
  }

  function convertFormatDateTwo(date) {
    const d = date.split("/");
    return d[2] + "-" + d[1] + "-" + d[0];
  }

  function formatDate(date) {
    let dateParts = date.split("-");
    return dateParts[2] + "/" + dateParts[1] + "/" + dateParts[0];  // Return DD/MM/YYYY
  }