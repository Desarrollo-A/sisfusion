$(document).on('click', '#enviar-autorizacion-link', function (e) {
    e.preventDefault();

    const $itself = $(this);
    const idCliente = $itself.attr('data-idCliente');

    const params = new Proxy(new URLSearchParams(window.location.search), {
        get: (searchParams, prop) => searchParams.get(prop),
    });

    const { codigo } = params;

    let data = new FormData();
    data.append('idCliente', idCliente);
    data.append('codigo', codigo);

    $('#spiner-loader').removeClass('hide');

    $.ajax({
        url: `${general_base_url}Api/validarAutorizacionSms`,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (data) {
            const response = JSON.parse(data);
            $('#spiner-loader').addClass('hide');

            if (response.code === 200) {
                $('#mensaje-success').text(response.mensaje);
            }

            if (response.code === 400) {
                alerts.showNotification("top", "right", response.message, "warning");
            }
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");

            $('#spiner-loader').addClass('hide');
        }
    });
});