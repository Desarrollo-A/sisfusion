$(document).on('click', '.details', function (e) {
    e.preventDefault();
    var tr = $(this).closest('tr');
    var row = reportsTable.row(tr);
    createDocRow(row, tr, $(this));

})

$(document).on("click", "#searchByDateRange", function () {
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    console.log("Campo en el END"+ finalEndDate);
    let fDate = formatDate(finalBeginDate);
    let fEDate = formatDate(finalEndDate);
    buildTable(fDate, fEDate);
    
});

sp = { // MJ: SELECT PICKER
    initFormExtendedDatetimepickers: function () {
        var today = new Date();
        var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        var time = today.getHours() + ":" + today.getMinutes();
        var dateTime = date+' '+time;

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
                inline: true,
            }
        });
    }
}

sp2 = { // CHRIS: SELECT PICKER
    initFormExtendedDatetimepickers: function () {
        $('.datepicker2').datetimepicker({
            format: 'DD/MM/YYYY LT',
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
            },
            minDate:new Date(),
        });
    }
}

$(document).ready(function () {
    sp.initFormExtendedDatetimepickers();
    sp2.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    setInitialValues();

    $(document).on('fileselect', '.btn-file :file', function (event, numFiles, label) {
        var input = $(this).closest('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;
        if (input.length) {
            input.val(log);
        } else {
            if (log) alert(log);
        }
    });

    $(document).on('change', '.btn-file :file', function () {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });

});

// function getData() {
//     $.ajax({
//         url: "getData",
//         cache: false,
//         contentType: false,
//         processData: false,
//         type: 'POST',
//         dataType: 'json',
//         success: function (response) {
//             let columns = dynamicColumns(response.columns);
//             let data = response.data;
//             buildTable(columns, data);
//         }, error: function () {
//             alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
//             $('#spiner-loader').addClass('hide');
//         }
//     });
// }

function dynamicColumns(columnData) {
    var dynamicColumns = [];
    columnData.forEach(function (columnItem) {
        // extract the column definitions:
        var dynamicColumn = {};
        dynamicColumn['data'] = columnItem['data'];
        dynamicColumn['title'] = columnItem['title'];
        dynamicColumns.push(dynamicColumn);
    });
    return dynamicColumns;
}

$('#reports-datatable thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    $(this).html('<input class="textoshead"  placeholder="'+title+'"/>' );
    $( 'input', this ).on('keyup change', function () {
        if ($('#reports-datatable').DataTable().column(i).search() !== this.value ) {
            $('#reports-datatable').DataTable().column(i).search(this.value).draw();
        }
    });
});

function buildTable(beginDate,endDate) {
    reportsTable = $('#reports-datatable').DataTable({
        dom: 'rt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        pagingType: "full_numbers",
        language: {
            url: "../static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [
            {
                "width": "0.5%",
                data: function (d) {
                    return d.id_solicitud
                }

            },
            {
                "width": "2.5%",
                data: function (d) {
                    return d.nombreResidencial
                }

            },
            {
                "width": "2.5%",
                data: function (d) {
                    return d.nombreLote
                }
            },
            {
                "width": "2.5%",
                data: function (d) {
                    return d.cliente;
                }
            },
            {
                "width": "2.5%",
                data: function (d) {
                    return d.fecha_creacion;
                }
            },
            {
                "width": "2.5%",
                data: function (d) {
                    return `<center><span><b> ${d.nombre_estatus}</b></span><center>`;
                    // <center><span>(${d.area})</span><center></center>
                }
            },
            {
                "width": "2.5%",
                data: function (d) {
                    return `<center>${d.area}</center>`;
                }
            },
            {
                "width": "2.5%",
                data: function (d) {
                    return `<center>${d.asignada_a}</center>`;
                }
            },
            {
                "width": "2.5%",
                data: function (d) {
                    return d.ultimo_comentario;
                }
            },
            {
                "width": "2.5%",
                data: function (d) {
                    return `<span class="label" style="background:#F5B7B1; color:#78281F;">${d.rechazo}</span><span class="label" style="background:#A9CCE3; color:#154360;">${d.vencimiento}</span>`;
                }
            },
        ],
        columnDefs: [{
            "searchable": true,
            "orderable": false,
            "targets": 0
        }
        ],
        ajax: {
            url: 'getReportes',
            type: "POST",
            cache: false,
            data: {
                "beginDate": beginDate,
                "endDate": endDate,
            }
        }

    });
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
    finalBeginDate2 = [('0' + beginDate.getDate()).slice(-2), ('0' + (beginDate.getMonth() + 1)).slice(-2), beginDate.getFullYear()].join('/');
    finalEndDate2 = [('0' + endDate.getDate()).slice(-2), ('0' + (endDate.getMonth() + 1)).slice(-2), endDate.getFullYear()].join('/');
    $('#beginDate').val(finalBeginDate2);
    $('#endDate').val(finalEndDate2);
/*cuando se carga por primera vez, se mandan los valores en cero, para no filtar por mes*/
    buildTable(0, 0);
}

function createDocRow(row, tr, thisVar) {
    if (row.child.isShown()) {
        row.child.hide();
        tr.removeClass('shown');
        $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
    } else {
        $.post("getFullReportContraloria", {
            idEscritura: row.data().idSolicitud
        }).done(function (data) {
            row.data().reporte = JSON.parse(data);
            reportsTable.row(tr).data(row.data());
            row = reportsTable.row(tr);
            row.child(buildTableDetail(row.data().reporte)).show();
            tr.addClass('shown');
            thisVar.parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
            $('#spiner-loader').addClass('hide');
        });
    }
}