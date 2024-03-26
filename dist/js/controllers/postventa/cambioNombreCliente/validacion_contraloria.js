$(document).ready(function () {
    fillTable();
});

let titulos = [];
$('#table_revision_contraloria thead tr:eq(0) th').each(function (i) {
    title = $(this).text();
    titulos.push(title);
    $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#table_revision_contraloria').DataTable().column(i).search() !== this.value)
            $('#table_revision_contraloria').DataTable().column(i).search(this.value).draw();
    });
    $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
});

function fillTable() {
    tabla_valores_cliente = $("#table_revision_contraloria").DataTable({
        width: '100%',
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Revisión Contraloría',
            title: 'Revisión Contraloría',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        processing: true,
        pageLength: 10,
        bAutoWidth: true,
        bLengthChange: false,
        scrollX: true,
        bInfo: true,
        searching: true,
        ordering: false,
        fixedColumns: true,
        destroy: true,
        columns: [
            { data: 'nombreResidencial' },
            { data: 'nombreCondominio' },
            { data: 'nombreLote' },
            { data: 'idLote' },
            { data: 'nombreCliente' },
            { data: 'nombreClienteNuevo' },
            { data: 'fechaApartado' },
            { data: 'nombreAsesor' },
            { data: 'nombreCoordinador' },
            { data: 'nombreGerente' },
            { data: 'nombreSubdirector' },
            { data: 'nombreRegional' },
            { data: 'nombreRegional2' },
            {
                data: function (d) {
                    return `<span class="label lbl-azure">${d.tipoVenta}</span>`;
                },
            },
            {
                data: function (d) {
                    return `<span class="label lbl-yellow">${d.ubicacion}</span>`;
                },
            },
            {
                data: function (d) {
                    return `<span class="label ${d.estatusCambioNombre == 1 ? 'lbl-gray' : 'lbl-green'}">${d.estatusProceso}</span>`;
                },
            },
            {
                data: function (d) {
                    return `<span class="label lbl-violetBoots">${d.tipoTramite}</span>`;
                },
            },
            { data: 'fechaUltimoEstatus' },
            {
                data: function (d) {
                    let comentario = (d.comentario == '' || d.comentario == null || d.comentario == 'NULL') ? '--' : d.comentario;
                    return `${comentario}`;
                },
            },
            {
                data: function (d) {
                    let btnAceptar = `<button class="btn-data btn-green btn-avanzar" data-toggle="tooltip" 
                    data-placement="top" title= "Aceptar" data-idLote="${d.idLote}" data-idCliente="${d.idCliente}" 
                    data-tipoTransaccion="${d.estatusCambioNombre}" data-tipo="1" data-precioFinal="${d.precioFinal}">
                        <i class="fas fa-thumbs-up"></i>
                    </button>`;
                    let btnRechazar = `<button class="btn-data btn-warning btn-avanzar" data-toggle="tooltip" data-placement="top" title= "Rechazar" data-idLote="${d.idLote}" data-idCliente="${d.idCliente}" data-tipoTransaccion="${d.estatusCambioNombre}" data-tipo="0"><i class="fas fa-thumbs-down"></i></button>`;
                    return `<div class="d-flex justify-center">${btnAceptar} ${btnRechazar}</div>`;
                }
            }
        ],
        columnDefs: [{
            defaultContent: "",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        ajax: {
            url: `${general_base_url}Postventa/getListaClientesRevision`,
            dataSrc: "",
            type: "POST",
            cache: false,
            data: {}
        },
        order: [
            [1, 'asc']
        ],
    });
    $('#table_revision_contraloria').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
}
// $("#precioFinal").on({
//     "focus": function (event) {
//         $(event.target).select();
//     },
//     "keyup": function (event) {
//         $(event.target).val(function (index, value ) {
//             return value.replace(/\D/g, "")
//                 .replace(/([0-9])([0-9]{2})$/, '$1.$2')
//                 .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
//         });
//     }
// });

$(document).on('click', '.btn-avanzar', function () {
    let tipoTransaccion = $(this).attr('data-tipo');
    let precioFinal = $(this).attr('data-precioFinal');
    let precioFinalCrudo = $(this).attr('data-precioFinal');
    let inputEditar = '';
    var options = { style: 'currency', currency: 'MXN' };
    var numberFormat = new Intl.NumberFormat('es-MX', options);
    precioFinal = numberFormat.format(precioFinal);
    $('#idLoteA').val($(this).attr('data-idLote'));
    $('#idClienteA').val($(this).attr('data-idCliente'));
    $('#tipoTransaccionA').val($(this).attr('data-tipoTransaccion'));
    $('#tipo').val(tipoTransaccion);
    $('#comentarioAvanzar').val('');
    if(precioFinalCrudo == '' || precioFinalCrudo == null || precioFinalCrudo == ' ' || precioFinalCrudo == 'null'){
        inputEditar = '<div class="col-lg-12">\n' +
            '                  <label class="control-label">Precio Final</label>\n' +
            '                  <input class="form-control input-gral mb-1" data-type="currency" ' +
            '                   name="precioFinal" autocomplete="off" id="precioFinal" step="any"\n' +
            '                  style="margin-top: 0px;" >' +
            '            </div><script>$("input[data-type=\'currency\']").on({keyup: function() {formatCurrencyG($(this));},blur: function() { formatCurrencyG($(this), "blur");} });</script>';

    }
    else{
        inputEditar = '<div class="col-lg-12">\n' +
            '                  <label class="control-label">Precio Final</label>\n' +
            '                  <input class="form-control input-gral mb-1" data-type="currency" pattern="^\\$\\d{1,3}(,\\d{3})*(\\.\\d+)?$" ' +
            '                    autocomplete="off" id="precioFinal" step="any"\n' +
            '                  style="margin-top: 0px;"\n' +
            '                   disabled value="'+precioFinal+'">' +
            '                  <input type="hidden" value="'+$(this).attr('data-precioFinal')+'" name="precioFinal">'+
            '            </div>';
    }

    if(tipoTransaccion == 1){
        /*let htmlInput = '<div class="col-lg-12">\n' +
            '                  <label class="control-label">Precio Final</label>\n' +
            '                  <input class="form-control input-gral mb-1" pattern="^\\$\\d{1,3}(,\\d{3})*(\\.\\d+)?$" ' +
            '                   name="precioFinal" autocomplete="off" id="precioFinal" step="any"\n' +
            '                  style="margin-top: 0px;"\n' +
            '                  disabled value="'+precioFinal+'">' +
            '                  <input type="hidden" value="'+$(this).attr('data-precioFinal')+'" name="precioFinalpost">'+
            '            </div>';*/
        $('#divTotalNeto').html(inputEditar);
        $('#divTotalNeto').removeClass('hide');
    }else{
        $('#divTotalNeto').html('');
        $('#divTotalNeto').addClass('hide');
    }

    $('#avance').modal();
})

$(document).on("submit", "#formAvanzarEstatus", function(e) {
    $('#spiner-loader').removeClass('hide');
    e.preventDefault();
    let data = new FormData($(this)[0]);
    $.ajax({
        url : `${general_base_url}Postventa/setAvance`,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(data){
            data = JSON.parse(data);
            alerts.showNotification("top", "right", data.message, "success");
            $('#table_revision_contraloria').DataTable().ajax.reload();
            $('#spiner-loader').addClass('hide');
            $('#avance').modal('hide');
        },
        error: function( data ){
            alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            $('#avance').modal('hide');
        }
    });
});
