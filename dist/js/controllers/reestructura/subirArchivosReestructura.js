var arrayKeysArchivos = [];
let flagProceso = 0;
var rescisionArchivo = '';
var id_dxc = 0;
var editarFile = 0;
var archivosAborrar = [];
var acceptFiles = '';
var nombreLote = '';
var arrayCF = [];
var editarContrafoFirmado = 0;
$(document).ready(function () {
    $("#archivosReestructura").on("hidden.bs.modal", function () {
        $("#fileElm1").val(null);
        $("#file-name1").val("");
        $("#fileElm2").val(null);
        $("#file-name2").val("");
        $("#fileElm3").val(null);
        $("#file-name3").val("");
        $("#Resicion").val(null);
        $("#resicion-name").val("");
    });
    Shadowbox.init();
    $('.collapse').collapse();
    $('[data-toggle="tooltip"]').tooltip();


});
$(document).on('click', '.btn-abrir-modal', function () {
    let idLote = $(this).attr("data-idLote");
    nombreLote = $(this).attr("data-nombreLote");
    let contenedorTitulo = $('#tituloLote');
    let tipotransaccion = $(this).attr("data-tipotransaccion");
    rescisionArchivo = $(this).attr("data-rescision");
    id_dxc = $(this).attr("data-id_dxc");
    contenedorTitulo.text(nombreLote);
    let flagEditar = $(this).attr("data-editar");
    var formData = new FormData();
    formData.append("idLote", idLote);
    $.ajax({
        type: 'POST',
        url: 'getOpcionesLote',
        data: formData,
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function(){
        },
        success: function(data) {
            data = JSON.parse(data);
            if(tipotransaccion==3){
                loadCopropietarios(data['copropietarios']);
                document.getElementById('co-propietarios').classList.remove('hide');
            }
            formArchivos(tipotransaccion, data['opcionesLotes'], flagEditar, nombreLote)
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });

    $("#archivosReestructura").modal();
});
function formArchivos(estatusProceso, datos, flagEditar, nombreLote) {
    let label = '';
    let contenedorArchivos = document.getElementById('formularioArchivos');
    let contenidoHTML = '';
    flagProceso = estatusProceso;
    let nombreCliente = datos[0]['nombreCliente'];
    let estadoCivil = datos[0]['estadoCivil'];
    let ine = datos[0]['ine'];
    let domicilio_particular = datos[0]['domicilio_particular'];
    let correo = datos[0]['correo'];
    let telefono1 = datos[0]['telefono1'];
    let ocupacion = datos[0]['ocupacion'];
    let infoClienteContenedor = document.getElementById('info-cliente');
    let contenidoHTMLinfoCL = `
    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 text-left">
            <p class="m-0"><b>Cliente.</b>${nombreCliente}</p>
            <p class="m-0"><b>Lote. </b>${nombreLote}</p>
            <p class="m-0 text-left"><b>Domicilio particular. </b>${domicilio_particular}</p>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 text-right">
            <p class="m-0"><b>Correo. </b>${correo}</p>
            <p class="m-0"><b>Teléfono. </b>${telefono1}</p>
            <p class="m-0"><b>Ocupación. </b>${ocupacion}</p>
            <p class="m-0"><b>INE. </b>${ine}</p>
            <p class="m-0"><b>Estado civil. </b>${estadoCivil}</p>
        </div>
    </div>`;

    arrayKeysArchivos = [];
    archivosAborrar = [];
    let nombreArchivo = '';
    let columnWith = '';
    let hideButton = '';
    switch (estatusProceso) {
        case '2':
            label = '<b>Subir corrida del lote</b>';
            flagProceso = 2;
            acceptFiles = '.csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel';
            columnWith = 'col-md-12 col-lg-12';
            hideButton = 'hide';
            break;
        case '3':
            label = '<b>Subir contrato del lote</b>';
            flagProceso = 3;
            acceptFiles = 'application/pdf';
            columnWith = 'col-md-11 col-lg-11';
            hideButton = '';
            break;
    }
    if (flagEditar == 0) {
        editarFile = 0;
        datos.map((elemento, index) => {
            contenidoHTML += '<div class="col col-xs-12 col-sm-12 ' + columnWith + ' mb-2">\n' +
                '                            <input type="hidden" name="idLotep' + elemento.id_pxl + '" id="idLotep' + elemento.id_pxl + '" value="' + elemento.id_pxl + '">\n' +
                '                            <input type="hidden" id="nombreLote' + elemento.id_pxl + '" value="' + elemento.nombreLote + '">\n' +
                '                            <h6 class="text-left">' + label + '<b>: </b>' + elemento.nombreLote + '<span class="text-red">*</span></h6>\n' +
                '                            <div class="" id="selectFileSection' + index + '">\n' +
                '                                <div class="file-gph">\n' +
                '                                    <input class="d-none" type="file" required accept="' + acceptFiles + '" id="fileElm' + index + '">\n' +
                '                                    <input class="file-name" id="file-name' + index + '" type="text" placeholder="No has seleccionada nada aún" readonly="">\n' +
                '                                    <label class="upload-btn m-0" for="fileElm' + index + '"><span>Seleccionar</span><i class="fas fa-folder-open"></i></label>\n' +
                '                                </div>\n' +
                '                            </div>\n' +
                '                        </div>';
            if (flagProceso == 3) {
                contenidoHTML += '          <div class="col col-xs-12 col-sm-12 col-md-1     col-lg-1 mt-4">\n' +
                    '                           <div class="d-flex justify-center">' +
                    '                               <button data-toggle="tooltip" data-placement="top" title="Descargar excel" ' +
                    '                               class="btn-data btn-green-excel ver-archivo" data-idPxl="' + elemento.id_pxl + '" ' +
                    '                               data-nomArchivo="' + elemento.corrida + '" data-nombreOriginalLote="' + nombreLote + '"' +
                    '                               data-rescision="0" data-excel="1"><i class="fas fa-file-excel-o"></i></button>' +
                    '                           </div>' +
                    '                        </div>';
            }
            arrayKeysArchivos.push(elemento);
        });
        if (flagProceso == 3) {
            //se esta subiendo contrato se debe pedir uno adicional
            contenidoHTML += ' <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2"><hr>\n' +
                '                            <h6 class="text-left"><b>Subir la rescisión del contrato: </b>' + nombreLote + '<span class="text-red">*</span></h6>\n' +
                '                            <div class="" id="selectFileSectionResicion">\n' +
                '                                <div class="file-gph">\n' +
                '                                    <input class="d-none" type="file" required accept="application/pdf" id="Resicion">\n' +
                '                                    <input class="file-name" id="resicion-name" type="text" placeholder="No has seleccionada nada aún" readonly="">\n' +
                '                                    <label class="upload-btn m-0" for="Resicion"><span>Seleccionar</span><i class="fas fa-folder-open"></i></label>\n' +
                '                                </div>\n' +
                '                            </div>\n' +
                '                        </div>';
        }
    }
    else if (flagEditar == 1) {
        editarFile = 1;
        datos.map((elemento, index) => {
            arrayKeysArchivos.push(elemento);

            if (flagProceso == 3) {
                nombreArchivo = elemento.contrato;
            } else if (flagProceso == 2) {
                nombreArchivo = elemento.corrida;
            }
            archivosAborrar.push(nombreArchivo);
            contenidoHTML += '          <div class="col col-xs-12 col-sm-12 col-md-9 col-lg-9 mb-2">\n' +
                '                            <input type="hidden" name="idLotep' + elemento.id_pxl + '" id="idLotep' + elemento.id_pxl + '" value="' + elemento.id_pxl + '">\n' +
                '                            <input type="hidden" id="nombreLote' + elemento.id_pxl + '" value="' + elemento.nombreLote + '">\n' +
                '                            <h6 class="text-left">' + label + ':' + elemento.nombreLote + '</h6>\n' +
                '                            <div class="" id="selectFileSection' + index + '">\n' +
                '                                <div class="file-gph">\n' +
                '                                    <input class="d-none" type="file" required accept="' + acceptFiles + '" id="fileElm' + index + '">\n' +
                '                                    <input class="file-name" id="file-name' + index + '" type="text" placeholder="No has seleccionada nada aún" readonly="">\n' +
                '                                    <label class="upload-btn w-50 m-0" for="fileElm' + index + '"><span>Seleccionar</span><i class="fas fa-folder-open"></i></label>\n' +
                '                                </div>\n' +
                '                            </div>\n' +
                '                        </div>';
            contenidoHTML += '          <div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3 mt-4">\n' +
                '                           <div class="d-flex justify-center">' +
                '                               <button data-toggle="tooltip" data-placement="top" title="Visualizar archivo"' +
                '                               class="btn-data btn-sky ver-archivo" data-idPxl="' + elemento.id_pxl + '" ' +
                '                               data-nomArchivo="' + nombreArchivo + '" data-nombreOriginalLote="' + nombreLote + '"' +
                '                               data-rescision="0"><i class="fas fa-eye"></i></button>' +
                '                               <button data-toggle="tooltip" data-placement="top" title="Descargar excel" ' +
                '                               class="btn-data btn-green-excel ver-archivo ' + hideButton + '" data-idPxl="' + elemento.id_pxl + '" ' +
                '                               data-nomArchivo="' + elemento.corrida + '" data-nombreOriginalLote="' + nombreLote + '"' +
                '                               data-rescision="0" data-excel="1"><i class="fas fa-file-excel-o"></i></button>' +
                '                           </div>' +
                '                        </div>';
        });
        if (flagProceso == 3) {
            //se esta subiendo contrato se debe pedir uno adicional
            contenidoHTML += ' <div class="col col-xs-12 col-sm-12 col-md-10 col-lg-10 mb-2"><hr>\n' +
                '                            <h6 class="text-left"><b>Subir la rescisión del contrato</b>:' + nombreLote + '</h6>\n' +
                '                            <div class="" id="selectFileSectionResicion">\n' +
                '                                <div class="file-gph">\n' +
                '                                    <input class="d-none" type="file" required accept="application/pdf" id="Resicion">\n' +
                '                                    <input class="file-name" id="resicion-name" type="text" placeholder="No has seleccionada nada aún" readonly="">\n' +
                '                                    <label class="upload-btn m-0 w-50" for="Resicion"><span>Seleccionar</span><i class="fas fa-folder-open"></i></label>\n' +
                '                                </div>\n' +
                '                            </div>\n' +
                '                        </div>';
            contenidoHTML += '          <div class="col col-xs-12 col-sm-12 col-md-2 col-lg-2  "><hr>\n' +
                '                           <div class="d-flex justify-center mt-4">' +
                '                               <button data-toggle="tooltip" data-placement="top" title="Visualizar archivo"' +
                '                               class="btn-data btn-sky ver-archivo" data-idPxl="' + id_dxc + '" ' +
                '                               data-nomArchivo="' + rescisionArchivo + '" data-nombreOriginalLote="' + nombreLote + '"' +
                '                               data-rescision="1"><i class="fas fa-eye"></i></button>' +
                '                           </div>' +
                '                        </div>';
        }
    }
    infoClienteContenedor.innerHTML = contenidoHTMLinfoCL;
    contenedorArchivos.innerHTML = contenidoHTML;
    //nombre de archivo en front
    $("input:file").on("change", function () {
        const target = $(this);
        const relatedTarget = target.siblings(".file-name");
        const fileName = target[0].files[0].name;
        relatedTarget.val(fileName);
    });
    $(document).on("change", ".btn-file :file", function () {
        const input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, "/").replace(/.*\//, "");
        input.trigger("fileselect", [numFiles, label]);
    });
    $('[data-toggle="tooltip"]').tooltip();

}
function loadCopropietarios(datos){
    // cnt-headers //contenedor de las cabeceras
    let contenidoHTML = '';
    let contenedorContenido = document.getElementById('contenedorCoprop');
    if(datos.length>0){
        datos.map((elemento, index)=>{
            let nombreCopropietario = elemento.nombre + ' ' + elemento.apellido_paterno+' '+elemento.apellido_materno;
            contenidoHTML += '<div class="card-body mb-3">';
            contenidoHTML += '  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center"><span style="font-size: 1.5rem; text-transform: uppercase;">'+nombreCopropietario+'</span></div>';
            contenidoHTML += '          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-left">';
            contenidoHTML += '                  <label class="control-label">Nombre</label>';
            contenidoHTML += '                  <input readonly class="form-control input-gral" type="text" required="true" value="'+elemento.nombre+'"/>';
            contenidoHTML += '          </div>';
            contenidoHTML += '          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-left">';
            contenidoHTML += '                  <label class="control-label">Apellido paterno</label>';
            contenidoHTML += '                  <input readonly class="form-control input-gral" type="text" required="true" value="'+elemento.apellido_paterno+'"/>';
            contenidoHTML += '          </div>';
            contenidoHTML += '          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-left">';
            contenidoHTML += '                  <label class="control-label">Apellido materno</label>';
            contenidoHTML += '                  <input readonly class="form-control input-gral" type="text" required="true" value="'+elemento.apellido_materno+'"/>';
            contenidoHTML += '          </div>';
            contenidoHTML += '          <div class="col-xs-12 col-sm-4 col-md-6 col-lg-6 text-left">';
            contenidoHTML += '                  <label class="control-label">Correo</label>';
            contenidoHTML += '                  <input readonly class="form-control input-gral" type="text" required="true" value="'+elemento.correo+'"/>';
            contenidoHTML += '          </div>';
            contenidoHTML += '          <div class="col-xs-12 col-sm-4 col-md-6 col-lg-6 text-left">';
            contenidoHTML += '                  <label class="control-label">Teléfono</label>';
            contenidoHTML += '                  <input readonly class="form-control input-gral" type="text" required="true" value="'+elemento.telefono_2+'"/>';
            contenidoHTML += '          </div>';
            contenidoHTML += '          <div class="col-xs-12 col-sm-4 col-md-12 col-lg-12 text-left">';
            contenidoHTML += '                  <label class="control-label">Dirección</label>';
            contenidoHTML += '                  <input readonly class="form-control input-gral" type="text" required="true" value="'+elemento.domicilio_particular+'"/>';
            contenidoHTML += '          </div>';
            contenidoHTML += '          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-left">';
            contenidoHTML += '                  <label class="control-label">Estado civil</label>';
            contenidoHTML += '                  <input readonly class="form-control input-gral" type="text" required="true" value="'+elemento.estado_civil+'"/>';
            contenidoHTML += '          </div>';
            contenidoHTML += '          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-left">';
            contenidoHTML += '                  <label class="control-label">Ocupación</label>';
            contenidoHTML += '                  <input readonly class="form-control input-gral" type="text" required="true" value="'+elemento.ocupacion+'"/>';
            contenidoHTML += '          </div>';
            contenidoHTML += '          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-left">';
            contenidoHTML += '                  <label class="control-label">Fecha nacimiento</label>';
            contenidoHTML += '                  <input readonly class="form-control input-gral" type="text" required="true" value="'+elemento.fecha_nacimiento+'"/>';
            contenidoHTML += '          </div>';
            contenidoHTML += '</div>';
        });
    }else{
        contenidoHTML += '<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12"><center><h5 class="fs-2">Sin copropietarios</h5></center></div>';
    }

    contenedorContenido.innerHTML = contenidoHTML;
}

$(document).on("click", "#sendRequestButton", function (e) {
    e.preventDefault();
    let flagEnviar = true;
    let validacionArray = [];
    let flagValidacion = 0;
    arrayKeysArchivos.map((element, raiz)=>{
        if($("#fileElm"+raiz)[0].files[0] != undefined){
            validacionArray.push(1);
            flagValidacion = flagValidacion + 1;
        }
    });

    if (editarFile == 1) {
        if (flagValidacion>0) {
            //hay al menos un archivo actualizado
            flagEnviar = true;
        }else{
            //detecta que no hay ni un archivo subido
            if (flagProceso == 3) {
                if ($("#Resicion")[0].files[0] == undefined) {
                    alerts.showNotification('top', 'right', 'Nada que actualizar', 'warning');
                    flagEnviar = false;
                }
            } else if (flagProceso == 2) {
                alerts.showNotification('top', 'right', 'Nada que actualizar', 'warning');
                flagEnviar = false;
            }
        }
        let data = new FormData();
        data.append("tipoProceso", flagProceso);
        data.append("longArray", arrayKeysArchivos.length);
        data.append("nombreLoteOriginal", nombreLote);
        data.append("id_dxc", id_dxc);
        data.append("editarFile", editarFile);
        arrayKeysArchivos.map((elemento, index) => {
            let flagEditar = ($("#fileElm" + index)[0].files[0] == undefined) ? 0 : 1;
            data.append("flagEditado" + index, flagEditar);
            data.append("archivo" + index, $("#fileElm" + index)[0].files[0]);
            data.append("idLoteArchivo" + index, $("#idLotep" + elemento.id_pxl).val());
            data.append("nombreLote" + index, $("#nombreLote" + elemento.id_pxl).val());
            data.append('archivoEliminar' + index, archivosAborrar[index]);
        });
        if (flagProceso == 3) {
            data.append("archivoResicion", $("#Resicion")[0].files[0]);
            let flagEditarRescision = ($("#Resicion")[0].files[0] == undefined) ? 0 : 1;
            data.append("flagEditarRescision", flagEditarRescision);
            if (editarFile == 1) {
                data.append('rescisionArchivo', rescisionArchivo);
            }
        }
        if (flagEnviar) {
            $.ajax({
                type: 'POST',
                url: 'actualizaExpecifico',
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    $("#spiner-loader").removeClass('hide');
                },
                success: function (data) {
                    const res = JSON.parse(data);
                    if (res.code === 200) {
                        reubicacionClientes.ajax.reload();
                        alerts.showNotification(
                            "top",
                            "right",
                            `Los documentos se han cargado con éxito.`,
                            "success"
                        );
                        $("#spiner-loader").addClass('hide');
                        $("#archivosReestructura").modal("hide");
                    }
                    if (res.code === 400) {
                        alerts.showNotification("top", "right", "ocurrió un error", "warning");
                    }
                    if (res.code === 500) {
                        alerts.showNotification(
                            "top",
                            "right",
                            "Oops, algo salió mal.",
                            "warning"
                        );
                    }
                },
                error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        }
    }
    else if (editarFile == 0) {

        if(arrayKeysArchivos.length == flagValidacion){
            flagEnviar = true;
        }else{
            alerts.showNotification('top', 'right', 'Ingresa los archivos requeridos', 'warning');
            flagEnviar = false;
        }

        if (flagProceso == 3 && $("#Resicion")[0].files[0] == undefined) {
            $("#spiner-loader").addClass('hide');
            alerts.showNotification('top', 'right', 'Selecciona archivo de rescisión', 'warning');
        }
        else {
            if (flagEnviar) {
                let data = new FormData();
                data.append("tipoProceso", flagProceso);
                data.append("longArray", arrayKeysArchivos.length);
                data.append("nombreLoteOriginal", nombreLote);
                data.append("id_dxc", id_dxc);
                data.append("editarFile", editarFile);
                arrayKeysArchivos.map((elemento, index) => {
                    data.append("archivo" + index, $("#fileElm" + index)[0].files[0]);
                    data.append("idLoteArchivo" + index, $("#idLotep" + elemento.id_pxl).val());
                    data.append("nombreLote" + index, $("#nombreLote" + elemento.id_pxl).val());
                    data.append('archivoEliminar' + index, archivosAborrar[index]);
                });
                if (flagProceso == 3) {
                    data.append("archivoResicion", $("#Resicion")[0].files[0]);
                    if (editarFile == 1) {
                        data.append('rescisionArchivo', rescisionArchivo);
                    }
                }
                $.ajax({
                    type: 'POST',
                    url: 'updateArchivos',
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                    },
                    success: function (data) {
                        const res = JSON.parse(data);
                        if (res.code === 200) {
                            alerts.showNotification(
                                "top",
                                "right",
                                `Los documentos se han cargado con éxito.`,
                                "success"
                            );
                            reubicacionClientes.ajax.reload();
                            $("#spiner-loader").addClass('hide');
                            $("#archivosReestructura").modal("hide");
                            $("#spiner-loader").addClass('hide');
                        }
                        if (res.code === 400) {
                            alerts.showNotification("top", "right", "ocurrió un error", "warning");
                        }
                        if (res.code === 500) {
                            alerts.showNotification(
                                "top",
                                "right",
                                "Oops, algo salió mal.",
                                "warning"
                            );
                        }
                    },
                    error: function () {
                        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                    }
                });
            }
        }

    }
});
$(document).on('click', '.ver-archivo', function () {
    let id_pxl = $(this).attr("data-idPxl");
    let nombreArchivo = $(this).attr("data-nomArchivo");
    let nombreArchivoOriginal = $(this).attr("data-nombreOriginalLote");
    let rescision = $(this).attr("data-rescision");
    let excel = $(this).attr("data-excel");
    let url_base = general_base_url + 'static/documentos/contratacion-reubicacion-temp/' + nombreArchivoOriginal + '/';
    let carpetaVisor = '';
    let url = '';
    if (flagProceso == 3) {
        carpetaVisor = 'CONTRATO/';
        if (excel == 1) {
            carpetaVisor = 'CORRIDA/';
        }
    } else if (flagProceso == 2) {
        carpetaVisor = 'CORRIDA/';
    }
    if (rescision == 1) {
        carpetaVisor = 'RESCISIONES/';
    }
    url = url_base + carpetaVisor + nombreArchivo;
    if (flagProceso == 3 || rescision == 1) {
        if (excel == 1) {
            window.open(url, "_blank");
        } else {
            visorArchivo(url, nombreArchivo);
        }
    } else if (flagProceso == 2) {
        window.open(url, "_blank");
    }
});


$(document).on('click', '.btn-abrir-contratoFirmado', function(){
   $('#contratoFirmadoModal').modal('toggle');
    let flagEditar = $(this).attr("data-editar");
    let formularioArchivoscf = document.getElementById('formularioArchivoscf');
    let contenidoHTMLCF = '';
    let idLote = $(this).attr("data-idLote");
    let nombreLotecf = $(this).attr("data-nombreLote");
    nombreLote = nombreLotecf;
    let estatusProceso = $(this).attr("data-tipotransaccion");
    arrayCF['idCondominio'] = $(this).attr("data-idCondominio");
    arrayCF['idDocumento'] = $(this).attr("data-iddocumento");
    arrayCF['idClienteCF'] = $(this).attr("data-idcliente");
    arrayCF['idLoteCF'] = idLote;
    arrayCF['nombreResidencial'] = $(this).attr("data-nombreResidencial");
    arrayCF['nombreCondominio'] = $(this).attr("data-nombreCondominio");
    arrayCF['nombreDocumento'] = $(this).attr("data-contratofirmado");

    editarContrafoFirmado = flagEditar;
    editarFile = flagEditar;
    let heightIframe = '400px';
   if(flagEditar == 0){//es primera ves no hay archivo
       document.getElementById('txtTituloCF').innerHTML = 'Selecciona el archivo que desees asociar a <b>CONTRATO FIRMADO</b>';
       document.getElementById('secondaryLabelDetail').innerHTML = 'El documento que hayas elegido se almacenará de manera automática una vez que des clic en <i>Guardar</i>.';
       document.getElementById('dialoSection').classList.remove('modal-lg');
       contenidoHTMLCF += ' <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2">\n' +
           '                            <div class="" id="selectFileSectionResicioncf">\n' +
           '                                <div class="file-gph">\n' +
           '                                    <input class="d-none" type="file" required accept="application/pdf" id="contratoFirmado">\n' +
           '                                    <input class="file-name" id="contratoFirmado-name" type="text" placeholder="No has seleccionada nada aún" readonly="">\n' +
           '                                    <label class="upload-btn m-0" for="contratoFirmado"><span>Seleccionar</span><i class="fas fa-folder-open"></i></label>\n' +
           '                                </div>\n' +
           '                            </div>\n' +
           '                        </div>';
   }else if(flagEditar == 1){//ya hay un archivo hay que actualizarlo
       if(estatusProceso==2){
           document.getElementById('txtTituloCF').innerHTML = 'Archivo actual asociado a <b>CONTRATO FIRMADO</b>';
           document.getElementById('secondaryLabelDetail').innerHTML = 'Si selecciona algún archivo y da clic en el botón de "<b>Guardar</b>", este reemplezara al mostrado.';
           document.getElementById('sendRequestButtoncf').classList.remove('hide');
           heightIframe = '400px'
       }else if(estatusProceso==3){
           document.getElementById('txtTituloCF').innerHTML = 'Visualizando el contrato firmado <b>'+ nombreLote + '</b>';
           document.getElementById('secondaryLabelDetail').innerHTML = '';
           document.getElementById('sendRequestButtoncf').classList.add('hide');
           heightIframe = '650px';
       }
       document.getElementById('dialoSection').classList.add('modal-lg');
       let contratoFirmado = $(this).attr("data-contratoFirmado");
       let ruta = general_base_url+'static/documentos/cliente/contratoFirmado/'+contratoFirmado;
       contenidoHTMLCF += '<iframe id="inlineFrameExample" title="Inline Frame Example"\n' +
           '  width="100%"\n' +
           '  height="'+heightIframe+'"\n' +
           '  src="'+ruta+'">\n' +
           '</iframe>';

       if(estatusProceso==2){
           contenidoHTMLCF += ' <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2 mt-4">\n' +
               '                            <div class="" id="selectFileSectionResicioncf">\n' +
               '                                <div class="file-gph">\n' +
               '                                    <input class="d-none" type="file" required accept="application/pdf" id="contratoFirmado">\n' +
               '                                    <input class="file-name" id="contratoFirmado-name" type="text" placeholder="No has seleccionada nada aún" readonly="">\n' +
               '                                    <label class="upload-btn m-0" for="contratoFirmado"><span>Seleccionar</span><i class="fas fa-folder-open"></i></label>\n' +
               '                                </div>\n' +
               '                            </div>\n' +
               '                        </div>';
       }


   }
    formularioArchivoscf.innerHTML = contenidoHTMLCF;

    $("input:file").on("change", function () {
        const target = $(this);
        const relatedTarget = target.siblings(".file-name");
        const fileName = target[0].files[0].name;
        relatedTarget.val(fileName);
    });
    $(document).on("change", ".btn-file :file", function () {
        const input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, "/").replace(/.*\//, "");
        input.trigger("fileselect", [numFiles, label]);
    });
    $('[data-toggle="tooltip"]').tooltip();
});

$(document).on("click", "#sendRequestButtoncf", function (e) {
    e.preventDefault();
    let flagEnviar = true;
    let validacionArray = [];
    let flagValidacion = 0;

    if (editarFile == 1) {
        if ($("#contratoFirmado")[0].files[0] == undefined) {
            $("#spiner-loader").addClass('hide');
            alerts.showNotification('top', 'right', 'Nada que actualizar', 'warning');
            flagEnviar = false;
        }else{
            flagEnviar = true;
        }
    }
    else if (editarFile == 0) {

        if ($("#contratoFirmado")[0].files[0] == undefined) {
            $("#spiner-loader").addClass('hide');
            alerts.showNotification('top', 'right', 'Selecciona el contrato firmado', 'warning');
            flagEnviar = false;
        }
        else {
            flagEnviar = true;
        }

    }

    if (flagEnviar) {
        let data = new FormData();
        data.append("idLote", arrayCF['idLoteCF']);
        data.append("nombreLoteOriginal", nombreLote);
        data.append("idDocumento", arrayCF['idDocumento']);
        data.append("idCliente", arrayCF['idClienteCF']);
        data.append("editarFile", editarContrafoFirmado);
        data.append('contratoFirmado', $("#contratoFirmado")[0].files[0]);
        data.append('idCondominio', arrayCF['idCondominio'] );
        data.append('nombreResidencial', arrayCF['nombreResidencial'] );
        data.append('nombreCondominio', arrayCF['nombreCondominio'] );
        data.append('nombreDocumento', arrayCF['nombreDocumento'] );
        let flagEditarCF = ($("#contratoFirmado")[0].files[0] == undefined) ? 0 : 1;
        data.append("flagEditarCF", flagEditarCF);
        $.ajax({
            type: 'POST',
            url: 'contratoFirmadoR',
            data: data,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
            },
            success: function (data) {
                const res = JSON.parse(data);
                if (res.code === 200) {
                    alerts.showNotification(
                        "top",
                        "right",
                        `El contrato firmado se ha cargado con éxito.`,
                        "success"
                    );
                    reubicacionClientes.ajax.reload();
                    $("#spiner-loader").addClass('hide');
                    $("#contratoFirmadoModal").modal("hide");
                    $("#spiner-loader").addClass('hide');
                }
                if (res.code === 400) {
                    alerts.showNotification("top", "right", "ocurrió un error", "warning");
                }
                if (res.code === 500) {
                    alerts.showNotification(
                        "top",
                        "right",
                        "Oops, algo salió mal al subir el archivo, inténtalo de nuevo.",
                        "warning"
                    );
                }
            },
            error: function () {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    }
});
