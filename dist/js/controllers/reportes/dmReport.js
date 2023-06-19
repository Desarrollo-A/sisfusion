const excluir_column = ['MÁS', 'ACCIONES', ''];//Arreglo para controlar columnas que no se tomaran en cuenta en la exportacion de archivo de excel.
let columnas_datatable = {};//

$("#mktdProspectsTable").ready(function () {
    asignarValorColumnasDT('mktdProspectsTable');
    $('#mktdProspectsTable thead tr:eq(0) th').each(function (i) {
        var title = $(this).text();
        if (!excluir_column.includes(title)) {
            columnas_datatable.mktdProspectsTable.titulos_encabezados.push(title);
            columnas_datatable.mktdProspectsTable.num_encabezados.push(columnas_datatable.mktdProspectsTable.titulos_encabezados.length-1);
        }
        let readOnly = excluir_column.includes(title) ? 'readOnly' : '';
        $(this).html(`<input    type="text"
                                class="textoshead"
                                data-toggle="tooltip" 
                                data-placement="top"
                                title="${title}"
                                placeholder="${title}"
                                ${readOnly}/>`);
        $('input', this).on('keyup change', function () {
            if ($('#mktdProspectsTable').DataTable().column(i).search() !== this.value) {
                $('#mktdProspectsTable').DataTable()
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    });
});

$(document).ready(function(){
    sp.initFormExtendedDatetimepickers();
    let month = ('0' + (new Date().getMonth()+1)).slice(-2);
    let dayFinal =  ('0' + new Date(new Date().getFullYear(), month, 0).getDate()).slice(-2);
    $('#beginDate').val(month +'/01/'+new Date().getFullYear());
    $('#endDate').val([month, dayFinal, new Date().getFullYear()].join('/'));
    setInitialValues();
});
sp = { //  SELECT PICKER
    initFormExtendedDatetimepickers: function () {
        $('.datepicker').datetimepicker({
            format: 'MM/DD/YYYY',
            locale: 'es-es',
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
                inline: true,
            }
        });
    }
}

function setInitialValues() {
    // BEGIN DATE
    const fechaInicio = new Date();
    // Iniciar en este año, este mes, en el día 1
    const beginDate = new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), 1);
    // END DATE
    const fechaFin = new Date();
    // Iniciar en este año, el siguiente mes, en el día 0 (así que así nos regresamos un día)
    const endDate = new Date(fechaFin.getFullYear(), fechaFin.getMonth() + 1, 0);
    finalBeginDate = [beginDate.getFullYear(), ('0' + (beginDate.getMonth() + 1)).slice(-2), ('0' + beginDate.getDate()).slice(-2)].join('-');
    finalEndDate = [endDate.getFullYear(), ('0' + (endDate.getMonth() + 1)).slice(-2), ('0' + endDate.getDate()).slice(-2)].join('-');
    fillTable(1, finalBeginDate, finalEndDate, 0);

}

$(document).on("click", "#searchByDateRange", function () {
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    fillTable(3, finalBeginDate, finalEndDate, 0);
});

var mktdProspectsTable
function fillTable(typeTransaction, beginDate, endDate, where) {
    mktdProspectsTable = $('#mktdProspectsTable').DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        scrollX: true,
        width: '100%',
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Reporte de estatus por prospecto',
            title:'Reporte de estatus por prospecto',
            exportOptions: {
                columns: columnas_datatable.mktdProspectsTable.num_encabezados,
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + columnas_datatable.mktdProspectsTable.titulos_encabezados[columnIdx] + '';
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
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        columnDefs: [{
            defaultContent: "Sin especificar",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        destroy: true,
        ordering: false,
        fixedHeader: true,
        columns:
            [
                {
                    data: function(d) {
                        if (d.estatus == 1) {
                            return '<center><span class="label lbl-green">Vigente</span><center>';
                        } else {
                            return '<center><span class="label lbl-warning">Sin vigencia</span><center>';
                        }
                    }
                },
                {
                    data: function(d) {
                        if (d.estatus_particular == 1) { // DESCARTADO
                            b = '<center><span class="label lbl-warning">Descartado</span><center>';
                        } else if (d.estatus_particular == 2) { // INTERESADO SIN CITA
                            b = '<center><span class="label lbl-warning">Interesado sin cita</span><center>';
                        } else if (d.estatus_particular == 3) { // CON CITA
                            b = '<center><span class="label lbl-dark-blue">Con cita</span><center>';
                        } else if (d.estatus_particular == 5) { // PAUSADO
                            b = '<center><span class="label lbl-dark-blue">Pausado</span><center>';
                        } else if (d.estatus_particular == 6) { // PREVENTA
                            b = '<center><span class="label lbl-dark-blue">Preventa</span><center>';
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
                        return `<center>
                                    <button class="btn-data btn-blueMaderas see-comments"
                                            data-id-prospecto="${d.id_prospecto}"
                                            data-toggle="tooltip" 
                                            data-placement="top"
                                            title="Detalle">
                                                <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                </center>;`
                    }
                }
            ],
        "ajax": {
            "url" : "getProspectsReport",
            "type": "POST",
            cache: false,
            data: {
                "typeTransaction": typeTransaction,
                "beginDate": beginDate,
                "endDate": endDate,
                "where": where
            }
        },
        initComplete: function () {
            $('[data-toggle="tooltip"]').tooltip("destroy");
            $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
        }
    });
}

function asignarValorColumnasDT(nombre_datatable) {
    if(!columnas_datatable[`${nombre_datatable}`]) {
        columnas_datatable[`${nombre_datatable}`] = {titulos_encabezados: [], num_encabezados: []};
    }
}