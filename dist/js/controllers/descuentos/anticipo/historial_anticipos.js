let titulosInventario = [];
$('#historial_general thead tr:eq(0) th').each(function (i) {

        var title = $(this).text();
        titulosInventario.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($('#historial_general').DataTable().column(i).search() !== this.value)
                $('#historial_general').DataTable().column(i).search(this.value).draw();
        });

});
var getInfo1 = new Array(6);
var getInfo3 = new Array(6);
$("#historial_general").ready(function () {
    tabla_9 = $("#historial_general").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Reporte anticipo',
            title: "Reporte anticipo",
            exportOptions: {
                columns: [0,1, 2, 3, 4, 5, 7, 8, 9,10,11],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulosInventario[columnIdx - 1] + ' ';
                    }
                }
            }
        }],
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        pagingType: "full_numbers",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        fixedColumns: true,
        ordering: false,
        scrollX: true,
        columns: [
        { data: 'id_anticipo' },
        { data: 'nombre' },

        { data: 'puesto' },
        { data: 'sede' },

        { data: 'monto_formateado' },
        { data: 'comentario' },
        { 
            data: function( d){         
                const letras = d.comentario.split(" ");
                if(letras.length <= 4)
                {
                    return '<p class="m-0">'+d.comentario+'</p>';
                }else{
                    
                    letras[2] = undefined ? letras[2] = '' : letras[2];
                    letras[3] = undefined ? letras[3] = '' : letras[3];
                    return `    
                        <div class="muestratexto${d.id_anticipo}" id="muestratexto${d.id_anticipo}">
                            <p class="m-0">${letras[0]} ${letras[1]} ${letras[2]} ${letras[3]}....</p> 
                            <a href='#' data-toggle="collapse" data-target="#collapseOne${d.id_anticipo}" 
                                onclick="esconder(${d.id_anticipo})" aria-expanded="true" aria-controls="collapseOne${d.id_anticipo}">
                                <span class="lbl-blueMaderas">Ver más</span> 
                                
                            </a>
                        </div>
                        <div id="collapseOne${d.id_anticipo}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                ${d.comentario}</p> 
                                <a href='#'  data-toggle="collapse" data-target="#collapseOne${d.id_anticipo}" 
                                    onclick="mostrar(${d.id_anticipo})" aria-expanded="true" aria-controls="collapseOne${d.id_anticipo}">
                                    <span class="lbl-blueMaderas">Ver menos</span> 
                                </a>
                            </div>
                        </div>
                    `;
                }
            }
        },
        
        { data: 'fecha_movimiento' },
        { data: 'proceso' },

        { data: 'prioridad_nombre' },
        { data: 'nombre_forma_pago' },
        
            
        { 
            data: function (d) {    
            var botonesModal = '';
            botonesModal += `
            <button href="#" value="${d.id_anticipo}" data-name="${d.nombre}" data-id_usuario="${d.id_usuario}" class="btn-data btn-blueMaderas consultar_logs" title="Historial">
                <i class="fas fa-info"></i>
            </button>`;
                    return '<div class="d-flex justify-center">' + botonesModal + '<div>';
            }
        }

            ],
        columnDefs: [{
            
            defaultContent: "Sin especificar",
            // targets: "_all",
            targets: [5], visible: false,
            searchable: true,
            orderable: false
        }],
        ajax: {
            url: `${general_base_url}Descuentos/solicitudes_generales_reporte`,
            dataSrc: "",
            type: "POST",
            cache: false,
            data :{
                bandera : 1,
            }
        },
        order: [[1, 'asc']]
    });

    $('#historial_general').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
    $('#historial_general tbody').on('click', '.delete-anticipo', function () {
        const idAnticipo = $(this).val();
        const monto1 = $(this).attr("data-monto");
        const id_usuario = $(this).attr("data-id_usuario");
        const nombreUsuario = $(this).attr("data-name");
        const Modalbody = $('#myModalDelete .modal-body');
        const Modalfooter = $('#myModalDelete .modal-footer');
        Modalbody.html('');
        Modalfooter.html('');
        Modalbody.append(`
            <input class="center-align" type="hidden"  value="${idAnticipo}" name="idAnticipo_Aceptar" id="idAnticipo_Aceptar"> 
            <h4 class=" center-align">¿Ésta seguro que desea borrar el Anticipo de ${nombreUsuario}?</h4>
            <div class="form-group">
                <label class="label control-label">Mótivo del rechazo</label>
                <textarea id="motivoDescuento" name="motivoDescuento" class="text-modal" rows="3" required></textarea>
            </div>
            <div class="form-group col-md-12 ">
                    
                <input  type="hidden" value="${monto1}" name="monto" id="monto">
            </div>
            <div class="form-group">
                <input type="hidden" value="${id_usuario}" name="id_usuario" id="id_usuario">
            </div>
            `);
        Modalfooter.append(`
                <button type="button"  class="btn btn-danger btn-simple " data-dismiss="modal" >Cerrar</button>
				<button  type="submit" name="disper_btn"  id="detener_adelanto" class="btn btn-primary">Aceptar</button>`);
        $("#myModalDelete").modal();
    });

    $('#historial_general tbody').on('click', '.aceptar_anticipo', function () {
        const idAnticipo = $(this).val();
        const nombreUsuario = $(this).attr("data-name");
        const id_usuario = $(this).attr("data-id_usuario");
        const Modalbody = $('#myModalAceptar .modal-body');
        const monto1 = $(this).attr("data-monto");
        const Modalfooter = $('#myModalAceptar .modal-footer');
        Modalbody.html('');
        Modalfooter.html('');
        Modalbody.append(`
            <input type="hidden" value="${idAnticipo}" name="idAnticipo_Aceptar" id="idAnticipo_Aceptar"> 

            <h4>¿Ésta seguro que desea aceptar el Anticipo de ${nombreUsuario}?</h4>
            <div class="form-group">
                <label class="label control-label">Prioridad</label>

                <div class="row aligned-row d-flex align-end pt-3" style="display: flex; justify-content: center"> 
                    <div id="selectorModo" class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div >
                            <div class="radio_container w-100">
                                <input class="d-none find-results" type="radio" name="modoSubida" id="prioridad_normal" checked value="0">
                                <label for="prioridad_normal" class="w-50">Normal</label>
                                <input class="d-none generate" type="radio" name="modoSubida" id="prioridad_urge"  value="1">
                                <label for="prioridad_urge" class="w-50">Urgente</label>
                                
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="form-group col-md-12 ">
                <label class="label control-label">Confirmar monto</label>
                <input class="form-control input-gral" 
                data-type="currency" maxlength="10" 
                oncopy="return false" 
                onpaste="return false"
                oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" 
                onkeypress="return onlyNumbers(event)"
                required
                type="text" value="${monto1}" name="monto" id="monto">
            </div>
            <div class="form-group">
                <input type="hidden" value="${id_usuario}" name="id_usuario" id="id_usuario">
            </div>
            <div class="form-group">
                <input type="hidden" value="0" name="bandera_a" id="bandera_a">
            </div>

            <div class="form-group">
                <label class="label control-label">Aceptar comentario</label>
                <textarea id="motivoDescuento_aceptar" name="motivoDescuento_aceptar" class="text-modal" rows="3" required></textarea>
            </div>
            `);
        Modalfooter.append(`
                <button type="button"  class="btn btn-danger btn-simple " data-dismiss="modal" >Cerrar</button>
				<button  type="submit" name="Activo_aceptar"  id="Activo_aceptar" class="btn btn-primary">Aceptar</button>`);
        $("#myModalAceptar").modal();
    });


    $('#historial_general tbody').on('click', '.aceptar_anticipo_confirmar', function () {
        
        const idAnticipo1 = $(this).val();
        const nombreUsuario1 = $(this).attr("data-name");
        const monto1 = $(this).attr("data-monto");
        const id_usuario1 = $(this).attr("data-id_usuario");
        const Modalbody_subir = $('#myModalAceptar_subir .modal-body');
        const Modalfooter_subir = $('#myModalAceptar_subir .modal-footer');
        Modalbody_subir.html('');
        Modalfooter_subir.html('');
        Modalbody_subir.append(`
            <input type="hidden" value="${idAnticipo1}" name="idAnticipo_Aceptar" id="idAnticipo_Aceptar"> 

            <h4>¿Ésta seguro que desea aceptar el Anticipo de ${nombreUsuario1}?</h4>
            <div class="form-group">
                <label class="label control-label">Prioridad</label>

                <div class="row aligned-row  col-md-12  " style=" justify-content: center"> 
                    <div id="selectorModo" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                            <div class="radio_container w-100">
                                <input class="d-none find-results" type="radio" name="modoSubida" id="prioridad_normal" checked value="0">
                                <label for="prioridad_normal" class="w-50">Normal</label>
                                <input class="d-none generate" type="radio" name="modoSubida" id="prioridad_urge"  value="1">
                                <label for="prioridad_urge" class="w-50">Urgente</label>
                                
                            </div>
                    </div>
                </div>
                
            </div>
            <div class="form-group col-md-12 ">
                <label class="label control-label">Confirmar monto</label>
                <input class="form-control input-gral" type="number" value="${monto1}" name="monto" id="monto">
            </div>
            <br>
            <div class="form-group">
            
                <div class="col-md-12 " id="evidenciaNuevadiv" name="evidenciaNuevadiv" style="padding-top:30px;" >
                <label class="label control-label">Evidencia de D.C</label>
                    <div class="file-gph">
                        <input class="d-none" type="file" id="evidenciaNueva" onchange="changeName(this)" name="evidenciaNueva"  >
                        <input class="file-name overflow-text" id="evidenciaNueva" type="text" placeholder="No has seleccionada nada aún" readonly="">
                        <label class="upload-btn w-auto" for="evidenciaNueva"><span>Seleccionar</span><i class="fas fa-folder-open"></i></label>
                    </div>
                </div>
            </div>
            <br>
            <div class="form-group">
                <input type="hidden" value="1" name="bandera_a" id="bandera_a">
            </div>
            <div class="form-group">
                <input type="hidden" value="${id_usuario1}" name="id_usuario" id="id_usuario">
            </div>
            <div class="form-group col-md-12 ">
                <label class="label control-label">Aceptar comentario</label>
                
                <textarea id="motivoDescuento_aceptar" name="motivoDescuento_aceptar" class="text-modal" rows="3" required></textarea>
            </div>
            `);
        Modalfooter_subir.append(`
                <button type="button"  class="btn btn-danger btn-simple " data-dismiss="modal" >Cerrar</button>
				<button  type="submit" name="Activo_aceptar_confirmar"  id="Activo_aceptar_confirmar" class="btn btn-primary">Aceptar</button>`);
        $("#myModalAceptar_subir").modal();
    });
    $("#historial_general tbody").on("click", ".consultar_logs", function(e){
        $('#spiner-loader').removeClass('hide');
        const idAnticipo = $(this).val();
        const nombreUsuario = $(this).attr("data-name");
        e.preventDefault();
        e.stopImmediatePropagation();
        // $("#nombreLote").html('');
        // $("#comentariosAsimilados").html('');
        id_pago = $(this).val();
        lote = $(this).attr("data-value");

        // changeSizeModal('modal-md');
        appendBodyModal(`<div class="modal-body">
                <div role="tabpanel">
                    <ul>
                        <div id="nombreLote"></div>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="changelogTab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-plain">
                                        <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                            <ul class="timeline-3" id="comentariosAsimilados"></ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"><b>Cerrar</b></button>
            </div>`);
        showModal();

        $("#nombreLote").append('<p><h5">HISTORIAL DEL ANTICIPO DE: <b>'+nombreUsuario+'</b></h5></p>');
        $.getJSON(general_base_url+"Descuentos/getComments/"+idAnticipo).done( function( data ){
            console.log(data)
            $.each( data, function(i, v){
                console.log(i);
                console.log(v.comentario_general);
                $("#comentariosAsimilados").append('<li>\n' +
                '  <div class="container-fluid">\n' +
                '    <div class="row">\n' +
                '      <div class="col-md-6">\n' +
                '        <a> Proeso : <b> ' +v.nombre+ '</b></a><br>\n' +
                '      </div>\n' +
                '      <div class="float-end text-right">\n' +
                '        <a> Comentario : ' +v.comentario_general + '</a>\n' +
                '      </div>\n' +

                '    <h6>\n' +
                '    </h6>\n' +
                '    </div>\n' +
                '  </div>\n' +
                '</li>');
            });
            $('#spiner-loader').addClass('hide');
        });
    });

});

function obtenerModoSeleccionado() {
    var radioButtons = document.getElementsByName("modoSubida");
    var modoSeleccionado = "";

    for (var i = 0; i < radioButtons.length; i++) {
        if (radioButtons[i].checked) {
            modoSeleccionado = radioButtons[i].value;
            break;
        }
    }

    return modoSeleccionado;
}

$("#form_aceptar").on('submit', function (e) {

    e.preventDefault();
    
    let formData = new FormData(document.getElementById("form_aceptar"));
    var seleccion = obtenerModoSeleccionado();
    formData.append("proceso", 4);
    formData.append("seleccion", seleccion);
    $.ajax({
        url: 'anticipo_update_generico',
        data: formData,
        method: 'POST',
        contentType: false,
        cache: false,
        processData: false,
        dataType: 'JSON',
        success: function (data) {
            alerts.showNotification("top", "right", "" + data.message + "", "" + data.response_type + "");
            $('#myModalAceptar').modal('hide')
            document.getElementById("form_aceptar").reset();
            $('#historial_general').DataTable().ajax.reload(null, false);
            $('#form_aceptar').trigger('reset');
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            document.getElementById("form_aceptar").reset();
            $('#myModalAceptar').modal('hide')
            $('#form_aceptar').trigger('reset');
            $("#usuarioid").selectpicker('refresh');

            
        }
    });
});

$("#form_subir").on('submit', function (e) {

    e.preventDefault();
    
    let formData = new FormData(document.getElementById("form_subir"));
    var seleccion = obtenerModoSeleccionado();
    // let uploadedDocument = $("#"+boton)[0].files[0];
    formData.append("proceso", 4);
    formData.append("seleccion", seleccion);
    $.ajax({
        url: 'anticipo_update_generico',
        data: formData,
        method: 'POST',
        contentType: false,
        cache: false,
        processData: false,
        dataType: 'JSON',
        success: function (data) {
            alerts.showNotification("top", "right", "" + data.message + "", "" + data.response_type + "");
            $('#myModalAceptar').modal('hide')
            document.getElementById("form_aceptar").reset();
            $('#historial_general').DataTable().ajax.reload(null, false);
            $('#form_aceptar').trigger('reset');
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            document.getElementById("form_aceptar").reset();
            $('#myModalAceptar').modal('hide')
            $('#form_aceptar').trigger('reset');
            $("#usuarioid").selectpicker('refresh');

            
        }
    });
}); 
function changeName(e){
    const fileName = e.files[0].name;
    let relatedTarget = $( e ).closest( '.file-gph' ).find( '.file-name' );
    relatedTarget[0].value = fileName;
}
$("#form_delete").on('submit', function (e) {

    e.preventDefault();
    let formData = new FormData(document.getElementById("form_delete"));

    // let uploadedDocument = $("#"+boton)[0].files[0];
    formData.append("proceso", 0);
    formData.append("estatus", 0);


    $.ajax({
        url: 'anticipo_update_generico',
        data: formData,
        method: 'POST',
        contentType: false,
        cache: false,
        processData: false,
        dataType: 'JSON',
        success: function (data) {
            alerts.showNotification("top", "right", "" + data.message + "", "" + data.response_type + "");
            $('#myModalDelete').modal('hide')
            document.getElementById("form_delete").reset();
            $('#historial_general').DataTable().ajax.reload(null, false);
            $('#form_delete').trigger('reset');
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            // document.getElementById("form_aceptar").reset();
            $('#myModalDelete').modal('hide')
            $('#form_delete').trigger('reset');
            // $("#usuarioid").selectpicker('refresh');

            
        }
    });
}); 







