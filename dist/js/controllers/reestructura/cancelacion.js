$(document).ready(function () {
    $("#tabla_lotes").addClass('hide');
    $('#spiner-loader').removeClass('hide');
    $.post(general_base_url + "Reestructura/listaLiberacionRes", function (data) {
        var len = data.length;
        
        $("#proyectoLiberado").append($('<option>').val(0).text('SELECCIONAR TODOS'));
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];
            var lotes = data[i]['tipoLote'];           
            $("#"+lotes+"").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#proyectoLiberado").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');   
});

$('#proyectoLiberado').change(function () {
    let index_proyecto = $(this).val();
    $("#spiner-loader").removeClass('hide');
    $("#tabla_lotes").removeClass('hide');
    fillTable(index_proyecto);
});

$(document).on('click', '.cancel', function (){
    const idLoteCa= $(this).attr('data-idLote');

    changeSizeModal('modal-md');
        appendBodyModal(`<div class="modal-body">
                            <form method="post" id="formCancelarLote">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-1 text-center">
                                    <h4>¿Está usted seguro de cancelar el contrato del lote?</h4>
                                </div>
                                <br>
                                <input type="hidden" name="idLote" id="idLote" value="${idLoteCa}">
                                <textarea name="obsLiberacion" id="obsLiberacion" placeholder="Observaciones" class="text-modal" required row="4"></textarea>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                            <button type="button" id="saveCancel" name="saveCancel" class="btn btn-primary">Aceptar</button>
                    </div>`);
    showModal();
});

$(document).on('click', '#saveCancel', function(){
    var obsLiberacion = $("#obsLiberacion").val();
    
    if(obsLiberacion.trim() == ''){
        alerts.showNotification("top", "right", "Debe ingresar una observación.", "warning");
        return false;
    }
    var datos = new FormData($("#formCancelarLote")[0]);
    $("#spiner-loader").removeClass('hide');
    datos.append("tipoLiberacion", 3);
    $.ajax({
        method: 'POST',
        url: general_base_url + 'Reestructura/aplicarLiberacion',
        data: datos,
        processData: false,
        contentType: false,
        success: function(data) {
            if (data == 1) {
            $('#tabla_lotes').DataTable().ajax.reload(null, false);
            $("#spiner-loader").addClass('hide');
            hideModal();
            alerts.showNotification("top", "right", "Opcion editada correctamente.", "success");
            $('#idLote').val('');
            $('#obsLiberacion').val('');
            }
        },
        error: function(){
            hideModal();
            $("#spiner-loader").addClass('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

let titulos_intxt = [];
$('#tabla_lotes thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos_intxt.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $( 'input', this ).on('keyup change', function () {
        if ($('#tabla_lotes').DataTable().column(i).search() !== this.value ) {
            $('#tabla_lotes').DataTable().column(i).search(this.value).draw();
        }
    });
});

function fillTable(index_proyecto) {
    tabla_valores_cliente = $("#tabla_lotes").DataTable({
        width: '100%',
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [
        {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Reestructuración',
        title: 'Reestructuración',
            exportOptions: {
                columns: [0,1,2,3,4,5,6],
                format: {
                    header: function (d, columnIdx) {
                        return ' '+titulos_intxt[columnIdx] +' ';
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        language: {
            url: general_base_url + "static/spanishLoader_v2.json",
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
        columns: [{
            data: function (d) {
                return '<p class="m-0">' + d.nombreResidencial + '</p>';
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.condominio + '</p>';
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.nombreLote + '</p>';
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.idLote + '</p>';
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.superficie + '</p>';
            }
        },
        {
            data: function (d){
                return '<p class="m-0">' + formatMoney(d.precio) + '</p>';
            }
        },
        {
            data: function (d){
                return '<p class="m-0">' + d.nombreCliente + '</p>'
            }
        },
        {
            data: function (d) {
                    return '<div class="d-flex justify-center"><button class="btn-data btn-warning cancel" data-toggle="tooltip" data-placement="top" title= "CANCELAR CONTRATO" data-idLote="' +d.idLote+ '" data-nombreLote="' +d.nombreLote+ '"><i class="fas fa-user-times"></i></button>';
            }
        }],
        columnDefs: [{
            defaultContent: "",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        ajax: {
            url: general_base_url + "Reestructura/getregistrosLotes",
            dataSrc: "",
            type: "POST",
            cache: false,
            data: {
                "index_proyecto": index_proyecto,
            }
        },
        initComplete: function(){
            $("#spiner-loader").addClass('hide');
        },
        "order": [
            [1, 'asc']
        ],
    });
    
    $('#tabla_lotes').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
}



