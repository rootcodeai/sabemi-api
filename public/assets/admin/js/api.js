$(document).ready(function () {
  sendPostApi();
  sendPostApiClass();
  sendPutApi();
  sendPostApiUpload();
  deleteImage();
  sendDeleteApi();
  sendRestoreApi();
  initNotifications();
});

function initNotifications() {
  $(document).on("click", ".notification-item", function (e) {
    e.preventDefault();
    let id = $(this).attr("data-id");
    let link = $(this).attr("data-link");
    let userId = $(this).attr("data-user-id");
    let token = $("#notification_api_token").val();
    let baseUrl = $("#notification_api_base").val();

    if (!token || !baseUrl) {
      if (link && link !== '#') window.location.href = link;
      return;
    }

    $.ajax({
      type: "PUT",
      url: `${baseUrl}/api/admin_v1/notifications/${id}/read?user_id=${userId}`,
      headers: {
        Authorization: token,
        Accept: "application/json",
      },
      success: function (response) {
        if (link && link !== '#') {
          window.location.href = link;
        }
      },
      error: function (xhr, status, error) {
        console.log(error);
        if (link && link !== '#') {
          window.location.href = link;
        }
      },
    });
  });
}

function sendPostApi() {
  $("#FormPostApi").submit(function () {
    $("#FormPostApi .def-msg").fadeIn();
    $(".send-form").attr("disabled", true);

    let formData = {};
    $(this)
      .find('input:not([type="submit"]), textarea, select')
      .each(function () {
        let fieldName = $(this).attr("name");
        let fieldValue = $(this).val();

        const currencyFields = ["amount", "value"];
        if (currencyFields.includes(fieldName) || $(this).hasClass("dinheiro")) {
          fieldValue = fieldValue.replace("R$", "").trim();
          fieldValue = fieldValue.replace(/\./g, "");
          fieldValue = parseFloat(fieldValue.replace(",", "."));
        }
        formData[fieldName] = fieldValue;
      });

    $.ajax({
      type: "POST",
      data: JSON.stringify(formData),
      contentType: "application/json",
      url: $(this).find('input[name="route"]').val(),
      headers: {
        Authorization: $(".api_v2_token").val(),
        Accept: "application/json",
      },
      beforeSend: function () {
        $("#FormPostApi .def-msg, #FormPostApiFooter .def-msg").html(
          "<div class='alert alert-info'>Enviando...</div>"
        );
      },
      error: function (request, status, error) {
        if (request.responseJSON.errors) {
          let arr = request.responseJSON.errors;
          let msgError = "";

          $.each(arr, function (index, value) {
            if (value.length !== 0) {
              msgError = msgError + value + "<br />";
            }
          });

          $("#FormPostApi .def-msg, #FormPostApiFooter .def-msg").html(
            "<div class='alert alert-danger'>" + msgError + "</div>"
          );
        }

        $("#FormPostApi .send-form").removeAttr("disabled");
        $(".send-form").attr("disabled", false);
      },
      success: function (result) {
        $("#FormPostApi .def-msg").html(
          "<div class='alert alert-success'>Cadastro realizado com sucesso!</div>"
        );
        $("input[type=text],input[type=email], textarea, select").val("");
        $("#FormPostApi .send-form").removeAttr("disabled");
        location.reload();
      },
    });
    return false;
  });
}

function sendPostApiClass() {
  $(".FormPostApi").submit(function () {
    $(".FormPostApi .def-msg").fadeIn();

    let formData = {};
    $(this)
      .find('input:not([type="submit"]), textarea, select')
      .each(function () {
        let fieldName = $(this).attr("name");
        let fieldValue = $(this).val();

        const currencyFields = ["amount", "value"];
        if (currencyFields.includes(fieldName) || $(this).hasClass("dinheiro")) {
          fieldValue = fieldValue.replace("R$", "").trim();
          fieldValue = fieldValue.replace(/\./g, "");
          fieldValue = parseFloat(fieldValue.replace(",", "."));
        }
        formData[fieldName] = fieldValue;
      });

    $.ajax({
      type: "POST",
      data: JSON.stringify(formData),
      contentType: "application/json",
      url: $(this).find('input[name="route"]').val(),
      headers: {
        Authorization: $(".api_v2_token").val(),
        Accept: "application/json",
      },
      beforeSend: function () {
        $(".send-form").attr("disabled", true);
        $(".FormPostApi .def-msg, .FormPostApiFooter .def-msg").html(
          "<div class='alert alert-info'>Enviando...</div>"
        );
      },
      error: function (request, status, error) {
        if (request.responseJSON.errors) {
          let arr = request.responseJSON.errors;
          let msgError = "";

          $.each(arr, function (index, value) {
            if (value.length !== 0) {
              msgError = msgError + value + "<br />";
            }
          });

          $(".FormPostApi .def-msg, .FormPostApiFooter .def-msg").html(
            "<div class='alert alert-danger'>" + msgError + "</div>"
          );
        }

        $(".send-form").attr("disabled", false);
      },
      success: function (result) {
        $(".FormPostApi .def-msg").html(
          "<div class='alert alert-success'>Cadastro realizado com sucesso!</div>"
        );
        $("input[type=text],input[type=email], textarea, select").val("");
        $(".send-form").attr("disabled", false);
        location.reload();
        setTimeout(function () {
          location.reload(true);
        }, 1000);
      },
    });
    return false;
  });
}

function sendPutApi() {
  $(".FormPutApi").submit(function () {
    $(".FormPutApi .def-msg").fadeIn();
    $(".send-form").attr("disabled", true);

    // Verificar se há campos de arquivo no formulário
    let hasFileInputs = $(this).find('input[type="file"]').length > 0;
    let formData;

    if (hasFileInputs) {
      // Se há arquivos, usar FormData
      formData = new FormData(this);

      // Converter campos datetime-local para formato Y-m-d H:i:s
      $(this)
        .find('input[type="datetime-local"]')
        .each(function () {
          let fieldName = $(this).attr("name");
          let fieldValue = $(this).val();

          if (fieldValue && fieldValue.includes("T")) {
            // Converter de 'YYYY-MM-DDTHH:mm' para 'YYYY-MM-DD HH:mm:ss'
            let formattedDate = fieldValue.replace("T", " ") + ":00";
            formData.set(fieldName, formattedDate);
          }
        });

      // Converter campos date para formato Y-m-d (caso necessário)
      $(this)
        .find('input[type="date"]')
        .each(function () {
          let fieldName = $(this).attr("name");
          let fieldValue = $(this).val();

          if (fieldValue) {
            // Garantir formato Y-m-d para campos date
            formData.set(fieldName, fieldValue);
          }
        });
    } else {
      // Se não há arquivos, usar objeto JSON
      formData = {};

      // Coletar todos os dados do formulário
      $(this)
        .find('input:not([type="submit"]), textarea, select')
        .each(function () {
          formData[$(this).attr("name")] = $(this).val();
        });

      // Converter campos datetime-local para formato Y-m-d H:i:s
      $(this)
        .find('input[type="datetime-local"]')
        .each(function () {
          let fieldName = $(this).attr("name");
          let fieldValue = $(this).val();

          if (fieldValue && fieldValue.includes("T")) {
            // Converter de 'YYYY-MM-DDTHH:mm' para 'YYYY-MM-DD HH:mm:ss'
            let formattedDate = fieldValue.replace("T", " ") + ":00";
            formData[fieldName] = formattedDate;
          }
        });

      // Converter campos date para formato Y-m-d (caso necessário)
      $(this)
        .find('input[type="date"]')
        .each(function () {
          let fieldName = $(this).attr("name");
          let fieldValue = $(this).val();

          if (fieldValue) {
            // Garantir formato Y-m-d para campos date
            formData[fieldName] = fieldValue;
          }
        });
    }

    $.ajax({
      type: "PUT",
      data: hasFileInputs ? formData : JSON.stringify(formData),
      processData: hasFileInputs ? false : true,
      contentType: hasFileInputs ? false : "application/json",
      url: $(this).find('input[name="route"]').val(),
      headers: {
        Authorization: $(".api_v2_token").val(),
        Accept: "application/json",
      },
      beforeSend: function () {
        $(".FormPutApi .def-msg").html(
          "<div class='alert alert-info'>Enviando...</div>"
        );
      },
      error: function (request, status, error) {
        if (request.responseJSON.errors) {
          let arr = request.responseJSON.errors;
          let msgError = "";

          $.each(arr, function (index, value) {
            if (value.length !== 0) {
              msgError = msgError + value + "<br />";
            }
          });

          $(".FormPutApi .def-msg").html(
            "<div class='alert alert-danger'>" + msgError + "</div>"
          );
        }

        $(".FormPutApi .send-form").removeAttr("disabled");
      },
      success: function (result) {
        $(".FormPutApi .def-msg").html(
          "<div class='alert alert-success'>Cadastro realizado com sucesso!</div>"
        );
        $("input[type=text],input[type=email], textarea, select").val("");
        $(".FormPutApi .send-form").removeAttr("disabled");
        setTimeout(function () {
          location.reload(true);
        }, 1000);
      },
    });
    return false;
  });
}
function sendPostApiUpload() {
  $(".FormPostApiUpload, #FormPostApiUpload").submit(function (event) {
    event.preventDefault();

    $(".FormPostApiUpload .def-msg, #FormPostApiUpload .def-msg").fadeIn();
    $(".send-form").attr("disabled", true);

    for (let instance in CKEDITOR.instances) {
      CKEDITOR.instances[instance].updateElement();
    }

    let formData = new FormData(this);

    // Converter campos datetime-local para formato Y-m-d H:i:s
    $(this)
      .find('input[type="datetime-local"]')
      .each(function () {
        let fieldName = $(this).attr("name");
        let fieldValue = formData.get(fieldName);

        if (fieldValue && fieldValue.includes("T")) {
          // Converter de 'YYYY-MM-DDTHH:mm' para 'YYYY-MM-DD HH:mm:ss'
          let formattedDate = fieldValue.replace("T", " ") + ":00";
          formData.set(fieldName, formattedDate);
        }
      });

    // Converter campos date para formato Y-m-d (caso necessário)
    $(this)
      .find('input[type="date"]')
      .each(function () {
        let fieldName = $(this).attr("name");
        let fieldValue = formData.get(fieldName);

        if (fieldValue) {
          // Garantir formato Y-m-d para campos date
          formData.set(fieldName, fieldValue);
        }
      });

    if (!formData.get("image") || formData.get("image").size === 0) {
      formData.delete("image");
    }

    $.ajax({
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      url: $(this).find('input[name="route"]').val(),
      headers: {
        Authorization: $(".api_v2_token").val(),
        Accept: "application/json",
      },
      beforeSend: function () {
        $(".FormPostApiUpload .def-msg").html(
          "<div class='alert alert-info'>Enviando...</div>"
        );
      },
      error: function (request, status, error) {
        if (request.responseJSON && request.responseJSON.errors) {
          let arr = request.responseJSON.errors;
          let msgError = "";

          $.each(arr, function (index, value) {
            if (value.length !== 0) {
              msgError += value + "<br />";
            }
          });

          $(".FormPostApiUpload .def-msg").html(
            "<div class='alert alert-danger'>" + msgError + "</div>"
          );
        } else {
          $(".FormPostApiUpload .def-msg").html(
            "<div class='alert alert-danger'>Erro ao enviar os dados.</div>"
          );
        }

        $(".send-form").removeAttr("disabled");
      },
      success: function (result) {
        $(".FormPostApiUpload .def-msg").html(
          "<div class='alert alert-success'>Cadastro realizado com sucesso!</div>"
        );
        $("input[type=text],input[type=email], textarea, select").val("");
        $(".send-form").removeAttr("disabled");
        location.reload();
      },
    });
    return false;
  });
}

function deleteImage() {
  $(".deleteImageApi").click(function () {
    if (!confirm("Tem certeza que deseja excluir esta imagem?")) {
      return;
    }

    let routeRedirect = $(this).attr("data-route-redirect");

    $.ajax({
      type: "DELETE",
      url: $(this).attr("data-route"),
      headers: {
        Authorization: $(".api_v2_token").val(),
        Accept: "application/json",
      },
      beforeSend: function () {
        //$(`#image-${imageId}`).html("<span class='text-info'>Excluindo...</span>");
      },
      success: function (response) {
        if (routeRedirect) {
          window.location.href = routeRedirect;
        } else {
          location.reload();
        }
        alert("Imagem excluída com sucesso!");
      },
      error: function (xhr, status, error) {
        let errorMessage = "Erro ao excluir a imagem.";
        if (xhr.responseJSON && xhr.responseJSON.message) {
          errorMessage = xhr.responseJSON.message;
        }
        alert(errorMessage);
        $(`#image-${imageId}`).html(
          "<span class='text-danger'>Erro ao excluir</span>"
        );
      },
    });
  });
}

function sendDeleteApi() {
  $(".FormDeleteApi").submit(function () {
    $(".FormDeleteApi .btn").attr("disabled", true);
    let formData = {};
    $(this)
      .find('input:not([type="submit"]), textarea, select')
      .each(function () {
        let fieldName = $(this).attr("name");
        let fieldValue = $(this).val();

        const currencyFields = ["amount", "value"];
        if (currencyFields.includes(fieldName) || $(this).hasClass("dinheiro")) {
          fieldValue = fieldValue.replace("R$", "").trim();
          fieldValue = fieldValue.replace(/\./g, "");
          fieldValue = parseFloat(fieldValue.replace(",", "."));
        }
        formData[fieldName] = fieldValue;
      });

    $.ajax({
      type: "DELETE",
      url: $('.FormDeleteApi input[name="route"]').val(),
      headers: {
        Authorization: $(".api_v2_token").val(),
        Accept: "application/json",
      },
      contentType: "application/json",
      data: JSON.stringify(formData),

      beforeSend: function () {
        $(".FormDeleteApi .msg-destroy-passenger").html(
          "<div class='alert alert-info'>Enviando...</div>"
        );
      },
      success: function (response) {
        $(".FormDeleteApi .msg-destroy-passenger").html(
          "<div class='alert alert-success'>Passageiro removido com sucesso!</div>"
        );

        setTimeout(function () {
          location.reload(true);
        }, 1000);

      },
      error: function (xhr, status, error) {
        let errorMessage = "";
        if (xhr.responseJSON && xhr.responseJSON.message) {
          errorMessage = xhr.responseJSON.message;

          $(".FormDeleteApi .msg-destroy-passenger").html(
            "<div class='alert alert-danger'>" + errorMessage + "</div>"
          );

          $(".FormDeleteApi .btn").attr("disabled", false);

        }
      },
    });
    return false;
  });
}

function sendRestoreApi() {
  $(".FormRestoreApi").submit(function () {
    let formData = {};
    $(this)
      .find('input:not([type="submit"]), textarea')
      .each(function () {
        formData[$(this).attr("name")] = $(this).val();
      });

    console.log(formData);

    $.ajax({
      type: "POST",
      url: $('.FormRestoreApi input[name="route"]').val(),
      headers: {
        Authorization: $(".api_v2_token").val(),
        Accept: "application/json",
      },
      contentType: "application/json",
      data: JSON.stringify(formData),

      beforeSend: function () {
        //$(`#image-${imageId}`).html("<span class='text-info'>Excluindo...</span>");
      },
      success: function (response) {
        setTimeout(function () {
          location.reload(true);
        }, 1000);
      },
      error: function (xhr, status, error) {
        let errorMessage = "Erro ao resturar a sub conta.";
        if (xhr.responseJSON && xhr.responseJSON.message) {
          errorMessage = xhr.responseJSON.message;
        }
        alert(errorMessage);
      },
    });
    return false;
  });
}
