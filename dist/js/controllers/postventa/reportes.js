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

$('#reports-datatable thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    $(this).html('<input class="textoshead"  placeholder="'+title+'"/>' );
    $( 'input', this ).on('keyup change', function () {
        if ($('#reports-datatable').DataTable().column(i).search() !== this.value ) {
            $('#reports-datatable').DataTable().column(i).search(this.value).draw();
        }
    });
});

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

$(document).ready(function () {
    getData(0,0);
})

$(document).on('click', '.details', function(e){
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

function getData(beginDate,endDate){
    let data = new FormData();
    data.append("beginDate", beginDate);
    data.append("endDate", endDate);
    $.ajax({
        url: "getData",
        cache: false,
        data : data,
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
function buildTable (columns, data){
    reportsTable = $('#reports-datatable').DataTable({
        dom: 'rt' + "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
        width: "auto",
        pagingType: "full_numbers",
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
            render: function (data, type, full, meta){
                return `<div><button id="details" class="btn-unstyled details w-50" data-toggle="tooltip" data-placement="top" title="Desglose detallado"><i class="fas fa-caret-right"></i></button><a class="w-50">${data}</a></div>`;

            }
        }],
        fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
           console.log('atrasado',aData['atrasado']);
        }
    });
}

function createDocRow(row, tr, thisVar){
    if ( row.child.isShown() ) {
        row.child.hide();
        tr.removeClass('shown');
        $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
    }else{
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
    solicitudes += '<td>' + '<b>' + 'AREA' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'FECHA INICIAL ESTATUS' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'FECHA FINAL ESTATUS' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'VIGENCIA ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'DÍAS DE ATRASO ' + '</b></td>';
    solicitudes += '</tr>';
    $.each(data, function (i, v) {
        //i es el indice y v son los valores de cada fila
        solicitudes += '<tr>';
        solicitudes += '<td> ' + i + ' </td>';
        solicitudes += '<td> ' + v.idStatus + ' </td>';
        solicitudes += '<td> ' + v.area + ' </td>';
        solicitudes += '<td> ' + v.fechados + ' </td>';
        solicitudes += '<td> ' + v.fecha_creacion + ' </td>';
        solicitudes += '<td> ' + v.atrasado + '</td>';
        solicitudes += '<td> ' + v.diferencia + '</td>';
    });
    return solicitudes += '</table>';
}