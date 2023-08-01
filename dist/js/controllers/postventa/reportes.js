$('[data-toggle="tooltip"]').tooltip(); 
sp = { 
    initFormExtendedDatetimepickers: function () {
        var today = new Date();
        var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
        var time = today.getHours() + ":" + today.getMinutes();
        var dateTime = date + ' ' + time;
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

sp2 = {
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
            minDate: new Date(),
        });
    }
}

$(document).ready(function () {
    sp.initFormExtendedDatetimepickers();
    sp2.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({ locale: 'es' });
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

$(document).ready(function () {
    getData(0, 0);
})

$(document).on('click', '.details', function (e) {
    e.preventDefault();
    var tr = $(this).closest('tr');
    var row = reportsTable.row(tr);
    createDocRow(row, tr, $(this));

})

$(document).on("click", "#searchByDateRange", function () {
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    let fDate = formatDate(finalBeginDate);
    let fEDate = formatDate(finalEndDate);
    getData(fDate, fEDate);

});

function formatDate(date) {
    var dateParts = date.split("/");
    var d = new Date(+dateParts[2], dateParts[1] - 1, +dateParts[0]),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();
    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;
    return [year, month, day].join('-');
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
}

function getData(beginDate, endDate) {
    let data = new FormData();
    data.append("beginDate", beginDate);
    data.append("endDate", endDate);
    $.ajax({
        url: "getData",
        cache: false,
        data: data,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: 'json',
        success: function (response) {
                let columns = dynamicColumns(response.columns);
                let data = response.data;
                buildTable(columns, data);
        }, error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            $('#spiner-loader').addClass('hide');
        }
    });
}

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

function buildTable(columns, data) {
    reportsTable = $('#reports-datatable').DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        pagingType: "full_numbers",
        //scrollX: true,
        buttons: [{ 
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo de Excel',
        title:'Reporte de solicitudes escrituración',
        exportOptions: {
            columns: [0,1,2,3,4,5,6,7,8,9,10,11,12],
            format: {
                    header:  function (d, columnIdx) {
                    if(columnIdx == 0){
                        return ' ID SOLICITUD ';
                    }else if(columnIdx == 1){
                        return 'REFERENCIA';
                    }else if(columnIdx == 2){
                        return 'LOTE';
                    }else if(columnIdx == 3){
                        return 'CONDOMINIO';
                    }else if(columnIdx == 4){
                        return 'RESIDENCIAL';
                    }else if(columnIdx == 5){
                        return 'CLIENTE';
                    }else if(columnIdx == 6){
                        return 'NOMBRE A ESCRITURAR';
                    }else if(columnIdx == 7){
                        return 'ESTATUS';
                    }else if(columnIdx == 8){
                        return 'ÁREA';
                    }else if(columnIdx == 9){
                        return 'VIGENCIA';
                    }else if(columnIdx == 10){
                        return 'DÍAS TRANSCURRIDOS';
                    }else if(columnIdx == 11){
                        return 'FECHA ULTIMO ESTATUS';
                    }else if(columnIdx ==12){
                        return 'ÚLTIMO COMENTARIO';
                    }
                }
            }
        },
        }],
        language: {
            url: "../static/spanishLoader.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: columns,
        data: data,
        columnDefs: [{
            "searchable": true,
            "orderable": false,
            "targets": 0
        },
        {
            targets: 0,
            render: function (data, type, full, meta) {
                return `<div><button id="details" class="btn-unstyled details w-50" data-toggle="tooltip" data-placement="top" title="DESGLOSE DETALLADO"><i class="fas fa-caret-right"></i></button><a class="w-50">${data}</a></div>`;
            }
        },
        {
            targets: 1,
            visible: false
        }
        ,
        {
            targets: 6,
            visible: false
        }
    ],
        fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {            
        },
        initComplete: function(settings, json) {
            $('#reports-datatable thead tr:eq(0) th').each( function (i) {
                var title = $(this).text();
                $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" placeholder="${title}"  title="${title}"/>` );
                $( 'input', this ).on('keyup change', function () {
                    if ($('#reports-datatable').DataTable().column(i).search() !== this.value ) {
                        $('#reports-datatable').DataTable().column(i).search(this.value).draw();
                    }
                });
                $('[data-toggle="tooltip"]').tooltip(); 
            });
        }
    });
}

function createDocRow(row, tr, thisVar) {
    if (row.child.isShown()) {
        row.child.hide();
        tr.removeClass('shown');
        $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
    } else {
        $.post("getFullReportContraloria", {
            idEscritura: row.data().id_solicitud
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

function buildTableDetail(data) {
    var solicitudes = '<table class="table subBoxDetail">';
    solicitudes += '<tr style="border-bottom: 1px solid #fff; color: #4b4b4b;">';
    solicitudes += '<td>' + '<b>' + '# ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'ESTATUS' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'ÁREA' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'CREADO POR' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'ACTIVIDAD' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'COMENTARIO' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'FECHA DEL ESTATUS' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'VIGENCIA ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'DÍAS TRANSCURRIDOS ' + '</b></td>';
    solicitudes += '</tr>';
    $.each(data, function (i, v) {
        solicitudes += '<tr>';
        solicitudes += '<td> ' + i + ' </td>';
        solicitudes += '<td> ' + v.idStatus + ' </td>';
        solicitudes += '<td> ' + v.area + ' </td>';
        solicitudes += '<td> ' + v.creado_por + ' </td>';
        solicitudes += '<td> ' + v.nombre + ' </td>';
        solicitudes += '<td> ' + (v.comentarios == null ? v.descripcion : v.comentarios) + ' </td>';
        solicitudes += '<td> ' + moment(v.fechados.split('.')[0],'YYYY/MM/DD HH:mm:ss').format('DD/MM/YYYY HH:mm:ss') + ' </td>';
        solicitudes += '<td> ' + v.atrasado + '</td>';
        solicitudes += '<td> ' + v.diferencia + '</td>';
    });
    return solicitudes += '</table>';
}

$(window).resize(function(){
    reportsTable.columns.adjust();
});