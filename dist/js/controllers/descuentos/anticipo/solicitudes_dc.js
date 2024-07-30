let titulosInventario = [];
$('#tabla_anticipo_revision_dc thead tr:eq(0) th').each(function (i) {

        var title = $(this).text();
        titulosInventario.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($('#tabla_anticipo_revision_dc').DataTable().column(i).search() !== this.value)
                $('#tabla_anticipo_revision_dc').DataTable().column(i).search(this.value).draw();
        });

});
var getInfo1 = new Array(6);
var getInfo3 = new Array(6);
$("#tabla_anticipo_revision_dc").ready(function () {
    tabla_9 = $("#tabla_anticipo_revision_dc").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Registro estatus 9',
            title: "Registro estatus 9",
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9],
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
        { data: 'proceso' },
        { data: 'prioridad_nombre' },
        { 
            data: function (d) {    
            var botonesModal = '';
            
            if(d.id_proceso == 3 )
            {
                
                botonesModal += `
                <button href="#" value="${d.id_anticipo}" data-id_usuario="${d.id_usuario}" 
                data-forma_pago="${d.forma_pago}"
                data-mensualidades_pra="${d.mensualidades}"
                data-monto_parcialidad="${d.monto_parcialidad}"
                data-id_parcialidad="${d.id_parcialidad}"
                data-monto_formateado="${d.monto_formateado}"
                data-monto="${d.monto}"
                data-name="${d.nombre}" class="btn-data btn-green aceptar_anticipo" title="Continuar Anticipo">
                <i class="fas fa-forward"></i>
                </button>`;
                botonesModal += `
                <button href="#" value="${d.id_anticipo}" 
                data-forma_pago="${d.forma_pago}"
                data-id_usuario="${d.id_usuario}" 
                data-monto="${d.monto}"
                data-anticcipo="${d.id_anticipo}" data-name="${d.nombre}" 
                class="btn-data btn-warning delete-anticipo" title="Detener Anticipo">
                <i class="fas fa-stop"></i>
                </button>`;
                
            }
            botonesModal += `
            <button href="#" value="${d.id_anticipo}" data-name="${d.nombre}" 
            data-id_usuario="${d.id_usuario}" 
            class="btn-data btn-blueMaderas consultar_logs" title="Historial">
                <i class="fas fa-info"></i>
            </button>`;
                    return '<div class="d-flex justify-center">' + botonesModal + '<div>';
            }
        }

            ],
        columnDefs: [{
            defaultContent: "Sin especificar",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        ajax: {
            url: `${general_base_url}Descuentos/solicitudes_generales_dc`,
            dataSrc: "",
            type: "POST",
            cache: false,
            data: function (d) {
            }
        },
        order: [[1, 'asc']]
    });

    $('#tabla_anticipo_revision_dc').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
    $('#tabla_anticipo_revision_dc tbody').on('click', '.delete-anticipo', function () {
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
            <h4 class=" center-align">¿Estás seguro que desea borrar el Anticipo de ${nombreUsuario}?</h4>
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

    $('#tabla_anticipo_revision_dc tbody').on('click', '.aceptar_anticipo', function () {
        const idAnticipo = $(this).val();
        const nombreUsuario = $(this).attr("data-name");

        const forma_pago = $(this).attr("data-forma_pago");

        const id_usuario = $(this).attr("data-id_usuario");
        const Modalbody = $('#myModalAceptar .modal-body');
        const monto1 = $(this).attr("data-monto");
        const Modalfooter = $('#myModalAceptar .modal-footer');

        const mensualidades_pra = $(this).attr("data-mensualidades_pra");
        const monto_parcialidad = $(this).attr("data-monto_parcialidad");
        const id_parcialidad    = $(this).attr("data-id_parcialidad");

        modalidad =  id_parcialidad == 'null' ? `PRÉSTAMO <br>`  : `APOYO <br>
                                                    MENSUALIDADES   : ${mensualidades_pra} <br>
                                                    MONTO           : ${monto_parcialidad} <br>` ;

        

        const monto_formateado = $(this).attr("data-monto_formateado");
        
        const formulario = id_parcialidad != 'null' ? `       
        <div class="form-group col-md-6 ">
            <label class="label control-label">número de mensualidades</label>
            <input class="form-control input-gral" 
                data-type="number" maxlength="2" 
                required
                type="text" value="${mensualidades_pra}" name="num_mensualidades" id="num_mensualidades">
        </div>
        
        <div class="form-group col-md-6 ">
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
        


        <div class="form-group col-md-10">
            <label class="label control-label">Monto por mes</label>
            <input class="form-control input-gral" 
                data-type="currency" maxlength="10" 
                required
                type="text" value="${monto_parcialidad}" name="mensualidad" id="mensualidad">
        </div>

        <div class="form-group col-md-2">
            <label class="label control-label"></label>
                <a  name="nuevosNumeros"  
                    id="nuevosNumeros" 
                    onclick="validar_nuevosNumeros()"
                    title="Calcular datos"
                    class="btn-data btn-green">
                    <i class="fas fa-calculator" style="font-size: 24px;"></i>
                    
                </a>
        </div>` 
        : 
        `<div class="form-group col-md-12 ">
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
        ` ; 


        Modalbody.html('');
        Modalfooter.html('');
        Modalbody.append(`
            <input type="hidden" value="${idAnticipo}" name="idAnticipo_Aceptar" id="idAnticipo_Aceptar"> 
            <h4>¿Estás seguro que desea aceptar el Anticipo de ${nombreUsuario}?</h4>
                <div>
                    <h2 class="card_title">Detalles</h2>
                    <p class="center-align"> 
                        Monto solicitado : ${monto_formateado}.<br>
                        Mediante la modalidad : ${modalidad}
                    </p>
                </div>

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

                ${formulario}
                
                
            
            <div class="form-group">
                <input type="hidden" value="${id_usuario}" name="id_usuario" id="id_usuario">
            </div>
            <div class="form-group">
                <input type="hidden" value="0" name="bandera_a" id="bandera_a">
            </div>

            <div class="form-group">
                <input type="hidden" value="${forma_pago}" name="forma_pago" id="forma_pago">
            </div>

            <div class="form-group col-md-12">
                <label class="label control-label">Aceptar comentario</label>
                <textarea id="motivoDescuento_aceptar" name="motivoDescuento_aceptar" class="text-modal" rows="3" required></textarea>
            </div>
            `);
        Modalfooter.append(`
        <div class="form-group col-md-12 ">
                <button type="button"  class="btn btn-danger btn-simple " data-dismiss="modal" >Cerrar</button>
				<button  type="submit" name="Activo_aceptar"  id="Activo_aceptar" class="btn btn-primary">Aceptar</button>
        </div>       
            `);
        $("#myModalAceptar").modal();
    });


    $('#tabla_anticipo_revision_dc tbody').on('click', '.aceptar_anticipo_confirmar', function () {
        
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

            <h4>¿Estás seguro que desea aceptar el Anticipo de ${nombreUsuario1}?</h4>
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
    $("#tabla_anticipo_revision_dc tbody").on("click", ".consultar_logs", function(e){
        $('#spiner-loader').removeClass('hide');
        const idAnticipo = $(this).val();
        const nombreUsuario = $(this).attr("data-name");
        e.preventDefault();
        e.stopImmediatePropagation();
        // $("#nombreLote").html('');
        // $("#comentariosAsimilados").html('');
        id_pago = $(this).val();
        lote = $(this).attr("data-value");

        changeSizeModal('modal-md');
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
            $('#tabla_anticipo_revision_dc').DataTable().ajax.reload(null, false);
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
            $('#tabla_anticipo_revision_dc').DataTable().ajax.reload(null, false);
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


// document.getElementById('num_mensualidades').addEventListener('input', validateInput);

function validar_nuevosNumeros() {
    const numero_mensualidades = document.getElementById('num_mensualidades').value;
    const monto = document.getElementById('monto').value;
    // const numero_mensualidades = document.getElementById('num_mensualidades');
    // monto = parseFloat(monto);
    // numero_mensualidades = parseFloat(numero_mensualidades);

    const number = parseInt(numero_mensualidades, 10);
    const validationMessage = document.getElementById('validationMessage');
    var nuevo_dato = 0;


    // if (isNaN(number) || number < 1 || number > 99) {
    //     // validationMessage.textContent = 'Por favor, ingrese un número válido entre 1 y 99.';
    //     // input.focus();
    // } else {
        
        
        console.log('nuevo dato',nuevo_dato);
        console.log('numero_mensualidades', numero_mensualidades);
        console.log('monto',monto);

        nuevo_dato = (monto/numero_mensualidades);

        document.getElementById('mensualidad').value = parseFloat(nuevo_dato);


        // validationMessage.textContent = 'El número de mensualidades es válido.';
        // Aquí puedes añadir la lógica adicional, como enviar los datos a un servidor
        // console.log('Número de mensualidades:', number);
    // }
}
// document.addEventListener('DOMContentLoaded', function() {
//     const input = document.getElementById('num_mensualidades');
//     input.addEventListener('input', validateInput);

//     function validateInput() {
//         const value = input.value;
//         const number = parseInt(value, 10);
//         const validationMessage = document.getElementById('validationMessage');

//         if (isNaN(number) || number < 1 || number > 99) {
//             validationMessage.textContent = 'Por favor, ingrese un número válido entre 1 y 99.';
//         } else {
//             validationMessage.textContent = '';
//         }
//     }
// });





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
            $('#tabla_anticipo_revision_dc').DataTable().ajax.reload(null, false);
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







