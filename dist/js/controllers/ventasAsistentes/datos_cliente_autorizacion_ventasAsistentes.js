$(document).ready(function(){
    construirHead("tabla_autorizaciones_ventas");
    $.post(general_base_url + "Asistente_gerente/lista_proyecto", function(data) {
        var len = data.length;
        for( var i = 0; i<len; i++)
        {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];
            $("#proyecto").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#proyecto").selectpicker('refresh');
    }, 'json');
});

$('#proyecto').change( function() {
    index_proyecto = $(this).val();
    $("#condominio").html("");
    $('#spiner-loader').removeClass('hide');
    $(document).ready(function(){
        $.post(general_base_url + "Asistente_gerente/lista_condominio/"+index_proyecto, function(data) {
            var len = data.length;
            for( var i = 0; i<len; i++)
            {
                var id = data[i]['idCondominio'];
                var name = data[i]['nombre'];
                $("#condominio").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#condominio").selectpicker('refresh');
            $('#spiner-loader').addClass('hide');
        }, 'json');
    });

});


$('#condominio').change( function() {
    index_condominio = $(this).val();
    $("#lote").html("");
    $('#spiner-loader').removeClass('hide');
    $(document).ready(function(){
        $.post(general_base_url + "Asistente_gerente/lista_lote/"+index_condominio, function(data) {
            var len = data.length;
            for( var i = 0; i<len; i++)
            {
                var id = data[i]['idLote'];
                var name = data[i]['nombreLote'];
                $("#lote").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#lote").selectpicker('refresh');
            $('#spiner-loader').addClass('hide');
        }, 'json');
    });
});

$('#lote').change( function() { 
    index_lote = $(this).val();
    $("#spiner-loader").removeClass("hide");
    $("#tabla_autorizaciones_ventas").removeClass('hide');
    tabla_6 = $("#tabla_autorizaciones_ventas").DataTable({
            width: '100%',
            dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
            destroy: true,
            "ajax":
                {
                    "url": general_base_url + 'index.php/Asistente_gerente/get_lote_autorizacion/'+index_lote,
                    "dataSrc": ""
                },
                initComplete: function () {
                    $("#spiner-loader").addClass("hide");
				},
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: `${_("descargar-excel")}`,
                    title: `${"autorizacion-por-ingresar"}`,
                    fileName : `${"autorizacion-por-ingresar"}`,
                    exportOptions: {
                        columns: [0,1,2,3],
                        format: {
                            header: function (d, columnIdx) {
                                return $(d).attr('placeholder').toUpperCase();
                            }
                        }
                    },

                }
            ],
            pagingType: "full_numbers",
            language: {
                url: general_base_url + '/static/spanishLoader_v2.json',
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            processing: true,
            pageLength: 10,
            bAutoWidth: false,
            bLengthChange: false,
            scrollX: true,
            bInfo: true,
            searching: true,
            ordering: false,
            fixedColumns: true,
            "columns":
            [
                {data: 'nombreLote'},
                {data: 'condominio'},
                {data: 'nombreResidencial'},
                {
                    data: null,
                    render: function ( data, type, row )
                    {
                        return data.nombre+' ' +data.apellido_paterno+' '+data.apellido_materno;
                    },
                },

                { 
                    "orderable": false,
                    "data": function( data ){
                        var id_rol = localStorage.getItem('id_rol');

                    if(id_rol==53){
                        opciones = '<div class="btn-group" role="group">';
                                opciones += '<div class="col-md-1 col-sm-1"><button class="btn btn-just-icon btn-info" disabled><i class="material-icons">open_in_browser</i></button></div>';
                                return opciones + '</div>';
                    }else{
                        opciones = '<div class="btn-group" role="group">';
                                opciones += `<div class="col-md-1 col-sm-1"><button class="btn-data btn-blueMaderas agregar_autorizacion" title="${_("subir-archivo")}" data-i18n-tooltip="subir-archivo" data-toggle="tooltip" data-placement="top" data-id_condominio="${data.idCondominio}" data-id_cliente="${data.id_cliente}" data-idClienteHistorial=${data.id_cliente} data-idLoteHistorial=${data.idLote} data-id_user=${id_usuario_general} data-nomResidencial="${data.nombreResidencial}" data-nomLote="${data.nombreLote}" data-nomCondominio="${data.condominio}"><i class="fas fa-plus"></i></button></div>`;
                                return opciones + '</div>';
                        }
                        
                    } 
                }

            ]

    });
    
    applySearch(tabla_6);
    $('#tabla_autorizaciones_ventas').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $("#tabla_autorizaciones_ventas tbody").on("click", ".agregar_autorizacion", function(){
        
        var tr = $(this).closest('tr');
        var row = tabla_6.row( tr );
        idautopago = $(this).val();

        $('#idCliente').val($(this).attr("data-id_cliente"));//data-id_cliente
        $('#idClienteHistorial').val($(this).attr("data-idclientehistorial"));//data-idclientehistorial
        $('#idLoteHistorial').val($(this).attr("data-idlotehistorial"));
        $('#idUser').val($(this).attr("data-id_condominio"));
        $('#idCondominio').val($(this).attr("data-id_user"));
        $('#nombreResidencial').val($(this).attr("data-nomResidencial"));
        $('#nombreLote').val($(this).attr("data-nomLote"));
        $('#nombreCondominio').val($(this).attr("data-nomCondominio"));

        $("#modal_autorizacion .modal-body").html("");
        $("#modal_autorizacion .modal-body").append(`<div class="file-gph"><input class="d-none" type="file" id="expediente" name="expediente" onchange="changeName(this)"><input class="file-name" type="text" placeholder="${_("archivo-no-selecionado")}" readonly required><label class="upload-btn m-0" for="expediente" readonly><span>${_("buscar")}</span><i class="fas fa-search text-right"></i></label></div>`);
        $("#modal_autorizacion").modal();
    });

});

function changeName(e){
    const fileName = e.files[0].name;
    let relatedTarget = $( e ).closest( '.file-gph' ).find( '.file-name' );
    relatedTarget[0].value = fileName;
}


$(document).on("submit", "#envioAutorizacion", function (e) { 
    e.preventDefault();
    let data = new FormData($(this)[0]);
    const uploadedDocument = $("#expediente")[0].files[0];

    if (uploadedDocument == undefined) {
        alerts.showNotification("top", "right", "Asegúrate de haber seleccionado un archivo antes de guardar.", "warning");
        return;
    }
  
    $.ajax({
      url: "alta_autorizacionVentas",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      type: "POST",
      success: function (response) {
        const res = JSON.parse(response);

        $("#sendRequestButton").prop("disabled", false);

        if (res.message === "OK") {
            alerts.showNotification("top", "right", `${_("documento-subido")}`, "success");
            $("#modal_autorizacion").modal("hide");
        }
        
      },error: function () {
        alerts.showNotification("top", "right", `${_("algo-salio-mal")}`, "danger");
      }
    });
});

$(window).resize(function(){
    tabla_autorizaciones.columns.adjust();
});