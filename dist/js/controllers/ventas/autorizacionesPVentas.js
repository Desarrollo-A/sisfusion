
$(document).ready(function(){ 
    $.post('getCatalogo', {
        id_catalogo: 90
    }, function (data) {        
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#estatusAut").append($('<option>').val(id).text(name));
                if(i == data.length -1) {
                    $("#estatusAut").append($('<option>').val(0).text('Todos'));
                }
        }
        if (len <= 0) {
            $("#estatusAut").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#estatusAut").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
});

    let titulos = [];
    $('#autorizacionesPVentas thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        titulos.push(title);

        $(this).html('<input type="text"  class="textoshead" placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function() {

            if (tablaAutorizacion.column(i).search() !== this.value) {
                tablaAutorizacion
                    .column(i)
                    .search(this.value)
                    .draw();

                var index = tablaAutorizacion.rows({
                    selected: true,
                    search: 'applied'
                }).indexes();
            }
        });
    });
    ConsultarTabla();
    function ConsultarTabla(opcion = 1,anio = '',estatus = ''){
    tablaAutorizacion = $("#autorizacionesPVentas").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'AUTORIZACIONES PLANES DE VENTAS',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                format: {
                    header:  function (d, columnIdx) {
                        return titulos[columnIdx];
                    }
                }
            },
        } ],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{  
            "width": "2%",
            "data": function( d ){
                return '<p class="m-0">'+d.id_autorizacion+'</p>';
            }
        },
        {  
            "width": "10%",
            "data": function( d ){
                return `<p class="m-0">${d.sede}</p>`;
            }
        },
        {  
            "width": "10%",
            "data": function( d ){
                return `<p class="m-0">${d.idResidencial}</p>`;
            }
        },
        {  
            "width": "10%",
            "data": function( d ){
                return `<p class="m-0"><b>${d.fecha_inicio}</b></p>`;
            }
        },
        {
            "width": "15%",
            "data": function( d ){
                return `<p class="m-0"><b>${d.fecha_fin}</b></p>`;
            }
        },
        {
            "width": "10%",
            "data": function( d ){
                return `<p class="m-0">${d.tipoLote}</p>`;
            }
        },
        {  
            "width": "5%",
            "data": function( d ){
                    return `<p class="m-0">${d.tipoSuperficie}</p>`;
                
            }
        },
        {
            "width": "5%",
            "data": function( d ){
                    return `<p class="m-0"><span class="label ${d.colorAutorizacion}">${d.estatusAutorizacion}</span></p>`;
                
            }
        },
        {  
            "width": "5%",
            "data": function( d ){
                return `<p class="m-0"><span class="label ${d.colorEstatus}">${d.estatusA}</span></p>`;
            
        }
        },
        {
            "width": "5%",
            "data": function( d ){
                return `<p class="m-0">${d.fecha_creacion.split('.')[0]}</p>`;
            
        }
        },
        {  
            "width": "5%",
            "data": function( d ){
                return `<p class="m-0">${d.creadoPor}</p>`;
            
             }
        },
        {  
            "width": "5%",
            "data": function( d ){
                $('[data-toggle="tooltip"]').tooltip();
                let botones = '';
                switch(id_rol_general){
                    case 5:
                        if(d.estatus == 1){
                            botones += botonesPermiso(1,1,1,0,d.id_autorizacion,d.estatus);
                        }
                        if(d.estatus == 3){
                            botones += botonesPermiso(1,0,0,0,d.id_autorizacion,d.estatus);
                        }
                        if(d.estatus == 4){
                            botones += botonesPermiso(1,1,1,0,d.id_autorizacion,d.estatus);
                        }
                    break;
                    case 17:
                        if(d.estatus == 2){
                            botones += botonesPermiso(1,0,1,1,d.id_autorizacion,d.estatus);
                        }
                        if(d.estatus == 3){
                            botones += botonesPermiso(1,0,0,0,d.id_autorizacion,d.estatus);
                        }
                        if(d.estatus == 4){
                            botones += botonesPermiso(1,0,0,0,d.id_autorizacion,d.estatus);
                        }
                    break;
                }
                botones += `<button data-idAutorizacion="${d.id_autorizacion}" id="btnHistorial" class="btn-data btn-gray" data-toggle="tooltip" data-placement="top" title="Historial"><i class="fas fa-info"></i></button>`; ;
                return '<div class="d-flex justify-center">' + botones + '<div>';
            
             }
        }],
        columnDefs: [{}],
        ajax: {
            "url": general_base_url + "PaquetesCorrida/getAutorizaciones",
            "type": "POST",
            cache: false,
            data: {
                "opcion": opcion,
                "anio": anio,
                "estatus":estatus
            }
        },

        order: [
            [1, 'asc']
        ]
    });
}

function botonesPermiso(permisoVista,permisoEditar,permisoAvanzar,permisoRechazar,idAutorizacion,estatus){
    let botones = '';
    /**Permisos
     * 1.- vista
     * 2.- Editar
     * 3.- Avanzar
     * */
        if(permisoVista == 1){ botones += `<button data-idAutorizacion="${idAutorizacion}" id="btnVer" class="btn-data btn-sky" data-toggle="tooltip" data-placement="top" title="Ver"><i class="fas fa-eye"></i></button>`;   }
        if(permisoEditar == 1){ botones += `<button data-idAutorizacion="${idAutorizacion}" id="btnEditar" class="btn-data btn-yellow" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></button>`; }
        if(permisoAvanzar == 1){ botones += `<button data-idAutorizacion="${idAutorizacion}" data-tipo="1" data-estatus="${estatus}" id="btnAvanzar" class="btn-data btn-green" data-toggle="tooltip" data-placement="top" title="Avanzar"><i class="fas fa-thumbs-up"></i></button>`;  }
        if(permisoRechazar == 1){ botones += `<button data-idAutorizacion="${idAutorizacion}" data-tipo="2" data-estatus="${estatus}" id="btnAvanzar" class="btn-data btn-warning" data-toggle="tooltip" data-placement="top" title="Rechazar"><i class="fas fa-trash"></i></button>`;  }
      return  botones;
    }

    $(document).on('click', '#btnAvanzar', function () {
        var data = tablaAutorizacion.row($(this).parents('tr')).data();    
        let idAutorizacion = $(this).attr('data-idAutorizacion');
        let estatus = $(this).attr('data-estatus');
        let tipo = $(this).attr('data-tipo');
        document.getElementById('titleAvance').innerHTML = tipo == 1 ? 'Avanzar autorización' : 'Rechazar autorización';
        $('#id_autorizacion').val(idAutorizacion);
        $('#estatus').val(estatus);
        $('#tipo').val(tipo);
        document.getElementById('modal-body').innerHTML = tipo == 2 ? `<textarea class="text-modal scroll-styles" max="255" type="text" name="comentario" id="comentario" autofocus="true" onkeyup="javascript:this.value=this.value.toUpperCase();" placeholder="Escriba aquí su comentario"></textarea>
        <b id="text-observations" class="text-danger"></b>` : ''; 
        $("#avanzarAut").modal();
    });
    
    $(document).on('submit', '#avanceAutorizacion', function (e) {
        e.preventDefault();
        let data = new FormData($(this)[0]);
        $('#spiner-loader').removeClass('hide');
        $.ajax({
            url: "avanceAutorizacion",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (response) {
                if (response == 1) {
                    $("#avanzarAut").modal("hide");
                    $('#spiner-loader').addClass('hide');
                    alerts.showNotification("top", "right", "Oops, Estatus actualizado", "success");
                    tablaAutorizacion.ajax.reload(null,false);
                    
                }
            }, error: function () {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                $('#spiner-loader').addClass('hide');
            }
        });
    });


    $(document).on('click', '#searchByEstatus', function () { 
        if($('#estatusAut').val() == '' || $('#anio').val() == ''){
            alerts.showNotification("top", "right", "Debe seleccionar ambas opciones.", "warning");
        }else{
            let estatus = $('#estatusAut').val();
            let anio = $('#anio').val();
            ConsultarTabla(2,anio,estatus);
        }

    });


    $(document).on('click', '#btnHistorial', function () {
        var data = tablaAutorizacion.row($(this).parents('tr')).data();    
        let idAutorizacion = $(this).attr('data-idAutorizacion');
        document.getElementById('historialAut').innerHTML = '';
        //historialAut
            $.post('getHistorialAutorizacion', {
                id_autorizacion: idAutorizacion
            }, function (data) {      
                console.log(data)  
                var len = data.length;
                for (var i = 0; i < len; i++) {
                    let estatus=data[i]['estatus'];
                    let comentario = data[i]['comentario'];
                        $('#historialAut').append(`
                        <div class="d-flex mb-2">
                            <div class="w-10 d-flex justify-center align-center">
                                <span style="width:40px; height:40px; display:flex; justify-content:center; align-items:center; border-radius:27px; background-color: ${estatus == 1 ? '#28B46318' : '#c0131318' }">
                                    <i class="fas fa-check fs-2" style="color: ${estatus == 1 ? '#28B463' : '#c01313'} "></i>
                                </span>
                            </div>
                            <div class="w-90">
                                <b>${data[i]['creadoPor']}</b>
                                ${estatus == 1 ? '' : '<p class="m-0" style="font-size:12px">'+comentario+'</p>' }
                                <p class="m-0" style="font-size:10px; line-height:12px; color:#999">${data[i]['fecha_movimiento'].split('.')[0]}</p>
                            </div>
                        </div>`)
                }
            }, 'json');
        $("#modalHistorial").modal();
    });