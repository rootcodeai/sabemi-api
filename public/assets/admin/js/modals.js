(function ($) {
  "use strict";
  $(
    ".excluir, .sendEmail, .modalInvoice, .sendMailWarning, .sendSubAccount, .openModal, .excluirSubAccount, .restoreSubAccount .openModal"
  ).magnificPopup({
    type: "inline",

    fixedContentPos: false,
    fixedBgPos: true,

    overflowY: "auto",

    closeBtnInside: true,
    preloader: false,

    midClick: true,
    removalDelay: 300,
    mainClass: "my-mfp-zoom-in",
    modal: true,
  });

  $(document).on("click", ".modal-dismiss", function (e) {
    e.preventDefault();
    $.magnificPopup.close();
    e.stopImmediatePropagation();
  });

  $(document).on("click", ".excluir", function (e) {
    var route = $(this).attr("data-route");
    $(".btnConfirmarExcluir").prop("href", route);
  });

  $(document).on("click", ".excluirOrder", function (e) {
    var route = $(this).attr("data-route");
    $("#fCancelOrder").prop("action", route);
  });

  $(document).on("click", ".paidOrder", function (e) {
    var route = $(this).attr("data-route");
    $("#fPaidOrder").prop("action", route);
  });

  $(document).on("click", ".paymentMethodOrder", function (e) {
    var route = $(this).attr("data-route");
    $("#fPaymentMethodOrder").prop("action", route);
  });

  $(document).on("click", ".openModalSetRoute", function (e) {
    let route = $(this).attr("data-route");
    let text = $(this).attr("data-text");
    $(".modalSetRoute").find("input[name='route']").val(route);
    $(".modalSetRoute .modal-text p").text(text);
  });

  $(document).on("click", ".formExcluir", function (e) {
    e.preventDefault();
    $.magnificPopup.close();
    var id = $(this).attr("data-id");
    $("#idexcluir").val(id);
    $("#fexcluir").submit();

    new PNotify({
      title: "Success!",
      text: "Modal Confirm Message.",
      type: "success",
    });
  });

  $(document).on("click", ".modal-form", function (e) {
    var id = $(this).attr("data-id");
    var legenda = $(".legenda[data-id=" + id + "]").html();
    $("#legenda-input").val("");
    $(".btnSalvarLegenda").attr("data-id", id);
    $("#legenda-input").val(legenda);
  });

  $(document).on("click", ".set-modal-value", function (e) {
    let data = $(this).attr("data-value");
    $("#value-input").val(data);
  });

  $(".modal-form").magnificPopup({
    type: "inline",

    fixedContentPos: false,
    fixedBgPos: true,

    overflowY: "auto",

    closeBtnInside: true,
    preloader: false,

    midClick: true,
    removalDelay: 300,
    mainClass: "my-mfp-zoom-in",
    modal: true,
  });

  $(".btnInsuranceCambio").magnificPopup({
    type: "inline",

    fixedContentPos: false,
    fixedBgPos: true,

    overflowY: "auto",

    closeBtnInside: true,
    preloader: false,

    midClick: true,
    removalDelay: 300,
    mainClass: "my-mfp-zoom-in",
    modal: true,
  });

  $(document).on("click", ".sendEmail", function (e) {
    var route = $(this).attr("data-route");
    $(".btnConfirmSendEmail").prop("href", route);
  });

  $(document).on("click", ".modalInvoice", function (e) {
    let route = $(this).attr("data-route");
    $(".btnConfirmInvoice").prop("href", route);
  });

  $(document).on("click", ".sendMailWarning", function (e) {
    let route = $(this).attr("data-route");
    $(".btnConfirmSendEmail").prop("href", route);

    let message = $(this).attr("data-message");
    $(".modal-text p").text(message);

    let title = $(this).attr("data-title");
    $(".panel-title").text(title);
  });

  $(document).on("click", ".excluirSubAccount", function (e) {
    var route = $(this).attr("data-route");
    $(".endPointAjax").val(route);
  });

  $(document).on("click", ".restoreSubAccount", function (e) {
    var route = $(this).attr("data-route");
    $(".endPointAjax").val(route);
  });

  $('.openModalSetRoute').on('click', function () {
  const route = $(this).data('route');
  const reason_cancellation = $(this).data('reason_cancellation') ?? '';
  const modal = $('#modalApproveOrderPlanCancellation');
  modal.find('input[name="route"]').val(route);
  modal.find('input[name="reason_cancellation"]').val(reason_cancellation);
});
}).apply(this, [jQuery]);
