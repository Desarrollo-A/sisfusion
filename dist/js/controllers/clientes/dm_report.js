$(document).ready(function(){
    construirHead("mktdProspectsTable");
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    setIniDatesXMonth("#beginDate", "#endDate");
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    fillTable(1, finalBeginDate, finalEndDate, 0);
});

sp = {
    initFormExtendedDatetimepickers: function () {
        $('.datepicker').datetimepicker({
            format: 'DD/MM/YYYY',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove',
                inline: true
            }
        });
    }
}

$(document).on("click", "#searchByDateRange", function () {
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    fillTable(3, finalBeginDate, finalEndDate, 0);
});

function fillTable(typeTransaction, beginDate, endDate, where) {
    tabla_6 = $('#mktdProspectsTable').DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width:'100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: `${_("descargar-excel")}`,
            title: `${_("reporte-estatus-prospecto")}`,
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                format: {
                    header:  function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
            }
        }],
        pagingType: "full_numbers",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: general_base_url + '/static/spanishLoader_v2.json',
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        columnDefs: [{
            defaultContent: `${_("sin-especificar")}`,
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        destroy: true,
        ordering: false,
        columns:[{
            data: function(d) {
                if (d.estatus == 1) {
                    return `<center><span class="label lbl-green" data-i18n="vigente">${_("vigente")}</span><center>`;
                } else {
                    return `<center><span class="label lbl-warning" data-i18n="sin-vigencia">${_("sin-vigencia")}</span><center>`;
                }
            }
        },
        {
            data: function(d) {
                if (d.estatus_particular == 1) { // DESCARTADO
                    b = `<center><span class="label lbl-warning" data-i18n="descartado">${_("descartado")}</span><center>`;
                } else if (d.estatus_particular == 2) { // INTERESADO SIN CITA
                    b = `<center><span class="label lbl-yellow" data-i18n="interesado-cita">${_("interesado-cita")}</span><center>`;
                } else if (d.estatus_particular == 3) { // CON CITA
                    b = `<center><span class="label lbl-green" data-i18n="con-cita">${_("con-cita")}</span><center>`;
                } else if (d.estatus_particular == 5) { // PAUSADO
                    b = `<center><span class="label lbl-sky" data-i18n="pausado">${_("pausado")}</span><center>`;
                } else if (d.estatus_particular == 6) { // PREVENTA
                    b = `<center><span class="label lbl-violetChin" data-i18n="preventa">${_("preventa")}</span><center>`;
                }
                return b;
            }
        },
        {
            data: function(d) {
                return d.nombre;
            }
        },
        {
            data: function(d) {
                return d.otro_lugar;
            }
        },
        {
            data: function(d) {
                return d.asesor;
            }
        },
        {
            data: function(d) {
                return d.gerente;
            }
        },
        {
            data: function(d) {
                return d.fecha_creacion;
            }
        },
        {
            data: function(d) {
                return d.fecha_vencimiento;
            }
        },
        {
            data: function(d) {
                return d.fecha_modificacion;
            }
        },
        {
            data: function(d) {
                return '<center><button class="btn-data btn-details-grey see-comments" data-toggle="tooltip" data-placement="top" title="' + _("consulta-informacion") + '" data-id-prospecto="' + d.id_prospecto + '"><i class="fas fa-ellipsis-h"></i></button></center>';
            }
        }],
        "ajax": {
            "url" : 'getProspectsReport',
            "type": "POST",
            cache: false,
            data: {
                "typeTransaction": typeTransaction,
                "beginDate": beginDate,
                "endDate": endDate,
                "where": where
            }
        }
    });

    $('#mktdProspectsTable').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
}