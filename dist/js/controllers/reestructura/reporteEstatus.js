let titulosTabla = [];
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
    ordering: false,
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
            data: function(d) {
                if(d.tipoValor == 1)
                    return `<label class="label lbl-azure">${d.tipo}</label>`;
                if(d.tipoValor == 2)
                    return `<label class="label lbl-warning">${d.tipo}</label>`;
                if(d.tipoValor == 3)
                    return `<label class="label lbl-yellow">${d.tipo}</label>`;
                if(d.tipoValor == 4)
                    return `<label class="label lbl-azure">Sin especificar</label>`;
            }
        },
        {   data: function(d) {
                if (d.nombreResidencialOrigen == null || d.nombreResidencialOrigen == '') return 'SIN ESPECIFICAR'
                return d.nombreResidencialOrigen;
            }
        },
        {   data: function(d) {
                if (d.nombreCondominioOrigen == null || d.nombreCondominioOrigen == '') return 'SIN ESPECIFICAR'
                return d.nombreCondominioOrigen;
            }
        },
        {   data: function(d) {
                if (d.nombreLoteOrigen == null || d.nombreLoteOrigen == '') return 'SIN ESPECIFICAR'
                return d.nombreLoteOrigen;
            }
        },
        {   data: function(d) {
                if (d.nombreCliente == null || d.nombreCliente == '' || '  ') return 'SIN ESPECIFICAR'
                return d.nombreCliente;
            }
        },
        {   
            visible: (id_rol_general == 17) ? true : false,
            data: function(d) {
                if (d.referenciaOrigen == null || d.referenciaOrigen == '') return 'SIN ESPECIFICAR'
                return d.referenciaOrigen;
            }
        },
        {   data: function(d) {
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
                // let dato = d.totalNeto.split(',').map(Number);
                return (d.totalNeto).toString().split(',').map(valor => formatMoney(valor.trim())).join(', ');
            }
        },
        { 
            visible: (id_rol_general == 2 || id_rol_general == 6) ? true : false,
            data: function (d) {
                if (d.preciom2 == null) {
                    return 'NA'; // o el valor que quieras devolver si es null
                }
                // let dato = d.totalNeto.split(',').map(Number);
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
            data: "superficieDestino" },
        {
            data: function(d) {
                return `<label class="label lbl-green">${d.estatusProceso}</label>`;
            }
        },
        {
            visible: (id_rol_general == 17) ? true : false,
            data: function(d) {
                    return `<label class="label lbl-azure ">${d.validacionAdministracion}</label>`;
            }
        },
        {
            data: function(d) {
                return `${d.fechaUltimoMovimiento}`;
            }
        },
        {
            data: function(d) {
                return `${d.fechaEstatus2}`;
            }
        },
        {
            data: function(d) {
                return `${d.estatus2Contraloria}`;
            }
        },
        { data: "asesor" },
        { data: "gerente" },
        {   
            data: function(d) {
                if (d.asesor == null || d.asesor == '') return 'SIN ESPECIFICAR'
                return d.asesor;
            }
        },
        {   
            data: function(d) {
                if (d.gerente == null || d.gerente == '') return 'SIN ESPECIFICAR'
                return d.gerente;
            }
        },
        {   
            data: function(d) {
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
                        data-idLote="${d.idLoteOrigen}" 
                        data-comentario="${d.comentario}"
                        data-flagFusion="${ (d.tipo_proceso == "Fusión" || d.tipo_proceso == "FUSIÓN" ) ? 1 : 0}">
                        <i class="fas fa-info"></i>
                    </button>
                </div>`;
            }
        },
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
