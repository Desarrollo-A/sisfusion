let titulosTabla = [];
let getInfoData = new Array(2);

$('#tablaTraspasoAportaciones thead tr:eq(0) th').each(function (i) {
    const title = $(this).text();
    titulosTabla.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function () {
        if ($('#tablaTraspasoAportaciones').DataTable().column(i).search() !== this.value)
            $('#tablaTraspasoAportaciones').DataTable().column(i).search(this.value).draw();
    });
    $('[data-toggle="tooltip"]').tooltip();
});

tablaTraspasoAportaciones = $('#tablaTraspasoAportaciones').DataTable({
    dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
    width: '100%',
    scrollX: true,
    buttons: [{
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Lotes para reubicar',
        title: "Lotes para reubicar",
        exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24],
            format: {
                header: function (d, columnIdx) {
                    return ' ' + titulosTabla[columnIdx] + ' ';
                }
            }
        }
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
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24],
            format: {
                header: function (d, columnIdx) {
                    return ' ' + titulosTabla[columnIdx] + ' ';
                }
            }
        }
    }],
    columnDefs: [{
        searchable: false,
        visible: false
    }],
    pageLength: 10,
    bAutoWidth: false,
    fixedColumns: true,
    language: {
        url: general_base_url + "static/spanishLoader_v2.json",
        paginate: {
            previous: "<i class='fa fa-angle-left'>",
            next: "<i class='fa fa-angle-right'>"
        }
    },
    order: [[4, "desc"]],
    destroy: true,
    columns: [
        {
            data: function (d) {
                return `<span class='label lbl-violetBoots'>${d.tipo_proceso}</span>`;
            }
        },
        {
            data: function (d) {
                if (d.tipoValor == 1)
                    return `<label class="label lbl-azure">${d.tipo}</label>`;
                if (d.tipoValor == 2)
                    return `<label class="label lbl-warning">${d.tipo}</label>`;
                if (d.tipoValor == 3)
                    return `<label class="label lbl-yellow">${d.tipo}</label>`;
                if (d.tipoValor == 4)
                    return `<label class="label lbl-azure">Sin especificar</label>`;
            }
        },
        {
            data: function (d) {
                if (d.nombreResidencialOrigen == null || d.nombreResidencialOrigen == '') return 'SIN ESPECIFICAR'
                return d.nombreResidencialOrigen;
            }
        },
        {
            data: function (d) {
                if (d.nombreCondominioOrigen == null || d.nombreCondominioOrigen == '') return 'SIN ESPECIFICAR'
                return d.nombreCondominioOrigen;
            }
        },
        {
            data: function (d) {
                if (d.nombreLoteOrigen == null || d.nombreLoteOrigen == '') return 'SIN ESPECIFICAR'
                return d.nombreLoteOrigen;
            }
        },
        {
            data: function (d) {
                if (d.nombreCliente == null || d.nombreCliente == '' || '  ') return 'SIN ESPECIFICAR'
                return d.nombreCliente;
            }
        },
        {
            visible: (id_rol_general == 17) ? true : false,
            data: function (d) {
                if (d.referenciaOrigen == null || d.referenciaOrigen == '') return 'SIN ESPECIFICAR'
                return d.referenciaOrigen;
            }
        },
        {
            data: function (d) {
                if (d.idLoteOrigen == null || d.idLoteOrigen == '') return 'SIN ESPECIFICAR'
                return d.idLoteOrigen;
            }
        },
        {
            visible: (id_rol_general == 2 || id_rol_general == 6) ? true : false,
            data: function (d) {
                if (d.totalNeto == null) {
                    return 'NA'; // o el valor que quieras devolver si es null
                }
                return (d.totalNeto).toString().split(',').map(valor => formatMoney(valor.trim())).join(', ');
            }
        },
        {
            visible: (id_rol_general == 2 || id_rol_general == 6) ? true : false,
            data: function (d) {
                if (d.preciom2 == null) {
                    return 'NA'; // o el valor que quieras devolver si es null
                }
                return (d.preciom2).toString().split(',').map(valor => formatMoney(valor.trim())).join(', ');
            }
        },
        {
            visible: (id_rol_general == 2 || id_rol_general == 6) ? true : false,
            data: "superficieOrigen"
        },
        { data: "nombreResidencialDestino" },
        { data: "nombreCondominioDestino" },
        { data: "nombreLoteDestino" },
        { data: "referenciaDestino" },
        { data: "idLoteDestino" },
        {
            visible: (id_rol_general == 2 || id_rol_general == 6) ? true : false,
            data: "superficieDestino"
        },
        {
            data: function (d) {
                return `<label class="label lbl-green">${d.estatusProceso}</label>`;
            }
        },
        {
            visible: (id_rol_general == 17) ? true : false,
            data: function (d) {
                return `<label class="label lbl-azure ">${d.validacionAdministracion}</label>`;
            }
        },
        {
            data: function (d) {
                return `${d.fechaUltimoMovimiento}`;
            }
        },
        {
            data: function (d) {
                return `${d.fechaEstatus2}`;
            }
        },
        {
            data: function (d) {
                return `${d.estatus2Contraloria}`;
            }
        },
        {
            visible: (id_rol_general == 15) ? false : true,
            data: function (d) {
                if (d.asesor == null || d.asesor == '') return 'SIN ESPECIFICAR'
                return d.asesor;
            }
        },
        {
            visible: (id_rol_general == 15) ? false : true,
            data: function (d) {
                if (d.gerente == null || d.gerente == '') return 'SIN ESPECIFICAR'
                return d.gerente;
            }
        },
        {
            visible: (id_rol_general == 15) ? false : true,
            data: function (d) {
                if (d.subdirector == null || d.subdirector == '') return 'SIN ESPECIFICAR'
                return d.subdirector;
            }
        },
        {
            data: function (d) {
                return `<div class="d-flex justify-center">
                    <button class="btn-data btn-blueMaderas btn-historial"
                        data-toggle="tooltip" 
                        data-placement="left"
                        title="Consultar historial de movimientos"
                        data-nombreLote="${d.nombreLoteOrigen}"
                        data-idLote="${d.idLoteOrigen}" 
                        data-comentario="${d.comentario}"
                        data-flagFusion="${(d.tipo_proceso == "Fusión" || d.tipo_proceso == "FUSIÓN") ? 1 : 0}">
                        <i class="fas fa-info"></i>
                    </button>` +
                    construirBotonDoc(d, d.fechaVenc, 'getDocumento') +
                    `</div>`;
            }
        }
    ],
    ajax: {
        url: `${general_base_url}Reestructura/getReporteEstatus`,
        dataSrc: "",
        type: "POST",
        cache: false,
    },
    initComplete: function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    },
});

function construirBotonDoc(d, fechaVenc, classButton, atributoButton = '', titulo = 'VER DOCUMENTACIÓN') {
    return `<button href='#' ${atributoButton} 
                data-toggle="tooltip" 
                data-placement="left"
                title="Consultar historial de movimientos"
                data-idLote="${d.idLoteOrigen}"
                data-nombreLote="${d.nombreLoteOrigen}"
                data-comentario="${d.comentario}"
                data-flagFusion="${(d.tipo_proceso == "Fusión" || d.tipo_proceso == "FUSIÓN") ? 1 : 0}"
                class="btn-data btn-orangeYellow ${classButton}" 
                data-toggle="tooltip" data-placement="top" 
                title="${titulo}"> <i class="fas fa-file"></i></button>`;
}

function construirBotonVista(classButton, nombreDoc, titulo = 'VER DOCUMENTO') {
    return `<button href='#'         
                data-toggle="tooltip" data-placement="top"
                data-nombreDoc="${nombreDoc}"
                class="btn-data btn-green ${classButton}"
                title="${titulo}"> <i class="fas fa-eye"></i></button>`;
}

$(document).on("click", ".getDocumento", function (e) {
    e.preventDefault();
    getInfoData[0] = $(this).attr("data-idLote");
    getInfoData[1] = $(this).attr("data-flagFusion");
    getInfoData[2] = $(this).attr("data-nombreLote")

    $(".loteDocumento").html(getInfoData[2]);
    $('#modalDocumento').modal('show');

    cargarDocumentos(getInfoData);
});

let titulosTabla2 = [];
$('#tablaDocumento thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulosTabla2.push(title);
    $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#tablaDocumento').DataTable().column(i).search() !== this.value) {
            $('#tablaDocumento').DataTable().column(i).search(this.value).draw();
        }
    });
});

function cargarDocumentos(data) {
    tablaDocumento = $('#tablaDocumento').DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [],
        width: '100%',
        scrollX: true,
        pageLength: 10,
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
            { data: "nombreDocumento" },
            { data: "nombreLote" },
            {
                data: function (d) {
                    return `<div class="d-flex justify-center">` + construirBotonVista('verDoc', d.documento) + `</div>`;
                }
            }
        ],
        ajax: {
            url: `${general_base_url}Reestructura/getDocumentos`,
            method: 'POST',
            data: {
                "idLote": data[0],
                "flagFusion": data[1]
            },
            dataType: 'JSON',
            dataSrc: "",
            cache: false
        },
        initComplete: function () {
            $('[data-toggle="tooltip"]').tooltip({
                trigger: "hover"
            });
        }
    });
}

$(document).on("click", ".verDoc", function (e) {
    e.preventDefault();
    doc = $(this).attr("data-nombreDoc");
    let url = `${general_base_url}documentacion/archivo/${doc}`;

    var fileExtension = ['pdf'];

    if ($.inArray(doc.split('.').pop().toLowerCase(), fileExtension) == -1) {
        window.open(url, '_blank');
    }
    else{
        Shadowbox.init();
        $("#sb-container").attr("style", "z-index: 10000");

        Shadowbox.open({
            content: `<iframe style="width: 100%;height: 100%;position:absolute; z-index: 10000;" src="${url}"></iframe>`,
            player: "html",
            title: `Visualizando archivo: ${doc}`,
            width: 985,
            height: 660
        });
    }
});
