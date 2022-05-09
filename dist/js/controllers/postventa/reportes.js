$(document).ready(function () {
    getData();
})

$(document).on('click', '.details', function(e){
    e.preventDefault();
    var tr = $(this).closest('tr');
    var row = reportsTable.row(tr);
    createDocRow(row, tr, $(this));

})

function getData(){
    $.ajax({
        url: "getData",
        cache: false,
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
                return `<div><button id="details" class="btn-unstyled details" data-toggle="tooltip" data-placement="top" title="Desglose detallado"><i class="fas fa-caret-right"></i></button><a>${data}</a></div>`;

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

function buildTableDetail(data) {
    var solicitudes = '<table class="table subBoxDetail">';
    solicitudes += '<tr style="border-bottom: 1px solid #fff; color: #4b4b4b;">';
    solicitudes += '<td>' + '<b>' + '# ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'ESTATUS' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'AREA' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'VIGENCIA ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'DÍAS DE ATRASO ' + '</b></td>';
    solicitudes += '</tr>';
    $.each(data, function (i, v) {
        //i es el indice y v son los valores de cada fila
        solicitudes += '<tr>';
        solicitudes += '<td> ' + i + ' </td>';
        solicitudes += '<td> ' + v.estatus + ' </td>';
        solicitudes += '<td> ' + v.area + ' </td>';
        solicitudes += '<td> ' + v.atrasado + '</td>';
        solicitudes += '<td> ' + v.diferencia + '</td>';
    });
    return solicitudes += '</table>';
}