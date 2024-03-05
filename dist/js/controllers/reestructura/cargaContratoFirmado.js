Shadowbox.init();

$(document).ready(function () {
    $('#addDeleteFileModal').on('hidden.bs.modal', function () {
        $('#fileElm').val(null);
        $('#file-name').val('');
    })

    $("input:file").on("change", function () {
        const target = $(this);
        const relatedTarget = target.siblings(".file-name");
        const fileName = target[0].files[0].name;
        relatedTarget.val(fileName);
    });
});

const AccionDoc = {
    DOC_NO_CARGADO: 1, // NO HAY DOCUMENTO CARGADO
    DOC_CARGADO: 2, // LA RAMA TIENE UN DOCUMENTO CARGADO
    SUBIR_DOC: 3, // NO HAY DOCUMENTO CARGADO, PERO TIENE PERMISO PARA SUBIRLO
    ELIMINAR_DOC: 4, // LA RAMA TIENE UN DOCUMENTO CARGADO, TIENE PERMISO PARA ELIMINAR EL ARCHIVO
    ENVIAR_SOLICITUD: 5
};

let titulosTabla = [];
$('#cargaContratoFirmadoTabla thead tr:eq(0) th').each(function (i) {
    const title = $(this).text();
    titulosTabla.push(title);
    $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#cargaContratoFirmadoTabla').DataTable().column(i).search() !== this.value)
            $('#cargaContratoFirmadoTabla').DataTable().column(i).search(this.value).draw();
    });
    $('[data-toggle="tooltip"]').tooltip();
});

cargaContratoFirmadoTabla = $('#cargaContratoFirmadoTabla').DataTable({
    dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
    width: '100%',
    scrollX: true,
    buttons: [
        {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Reestructuración',
            title: 'Reestructuración',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulosTabla[columnIdx] + ' ';
                    }
                }
            },
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
            className: 'btn buttons-pdf',
            titleAttr: 'Lotes para reubicar',
            title: "Lotes para reubicar",
            orientation: 'landscape',
            pageSize: 'LEGAL',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulosTabla[columnIdx] + ' ';
                    }
                }
            }
        }
    ],
    columnDefs: [],
    pageLength: 10,
    bAutoWidth: false,
    fixedColumns: true,
    ordering: true,
    language: {
        url: `${general_base_url}static/spanishLoader_v2.json`,
        paginate: {
            previous: "<i class='fa fa-angle-left'>",
            next: "<i class='fa fa-angle-right'>"
        }
    },
    destroy: true,
    ordering: false,
    columns: [
        { data: "nombreResidencial" },
        { data: "nombreCondominio" },
        { data: "nombreLote" },
        { data: "idLote" },
        { data: "nombreCliente" },
        {
            data: (d) => {
                return d.fechaApartado == null ? '-' : d.fechaApartado;
            }
        },
        {
            data: (d) => {
                return `<label class="label lbl-violetBoots">${d.estatusPreproceso}</label>`;
            }
        },
        {
            data: (d) => {
                return `<label class="label ${d.nombreDocumento == null ? 'lbl-warning' : 'lbl-green'}">${d.estatusContratoFirmado}</label>`;
            }
        },
        {
            data: function (d) {
                const DATE = new Date();
                const DATE_STR = [DATE.getMonth() + 1, DATE.getDate(), DATE.getFullYear()].join('-');
                const TITULO_DOCUMENTO = `${d.abreviaturaNombreResidencial}_${d.nombreLote}_${d.idLote}_${d.idCliente}_TDOC${d.tipoDocumento}${d.rama.slice(0, 4)}_${DATE_STR}`;
                let BOTON_ELIMINAR = `<button class="btn-data btn-warning addRemoveFile" data-toggle="tooltip" data-placement="top" title= "ELIMINAR DOCUMENTO" data-idLote="${d.idLote}" data-nombreLote="${d.nombreLote}" data-idDocumento="${d.idDocumento}" data-tipoDocumento="${d.tipoDocumento}" data-accion="2" data-nombre="${d.rama}"><i class="fas fa-trash"></i></button>`;
                let BOTON_CARGAR = `<button class="btn-data btn-green addRemoveFile" data-toggle="tooltip" data-placement="top" title= "SUBIR DOCUMENTO" data-idLote="${d.idLote}" data-nombreLote="${d.nombreLote}" data-idDocumento="${d.idDocumento}" data-tipoDocumento="${d.tipoDocumento}" data-accion="1" data-nombre="${d.rama}" data-tituloDocumento="${TITULO_DOCUMENTO}"><i class="fas fa-upload"></i></button>`;
                let BOTON_VER = `<button class="btn-data btn-blueMaderas verDocumento" data-toggle="tooltip" data-placement="top" title= "VER DOCUMENTO" data-idLote="${d.idLote}" data-nombreLote="${d.nombreLote}" data-idDocumento="${d.idDocumento}" data-tipoDocumento="${d.tipoDocumento}" data-accion="3" data-nombre="${d.rama}" data-nombreDocumento="${d.nombreDocumento}"><i class="fas fa-eye"></i></button>`;
                return `<div class="d-flex justify-center">${d.nombreDocumento == null ? BOTON_CARGAR : BOTON_VER + BOTON_ELIMINAR}</div>`;
            }
        }
    ],
    ajax: {
        url: `${general_base_url}Reestructura/getLotesParaCargarContratoFirmado`,
        dataSrc: "",
        type: "POST",
        cache: false,
    },
    initComplete: function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    }
});


$(document).on('click', '.verDocumento', function () {
    const $itself = $(this);
    let pathUrl = `${general_base_url}static/documentos/cliente/contratoFirmado/${$itself.attr("data-nombreDocumento")}`;
    Shadowbox.open({
        content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="${pathUrl}"></iframe></div>`,
        player: "html",
        title: `Visualizando archivo: ${$itself.attr('data-nombreDocumento')}`,
        width: 985,
        height: 660
    });
});

