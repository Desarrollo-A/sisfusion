var arrayKeysArchivos = [];
let flagProceso = 0;
var rescisionArchivo = '';
var rescisionArchivos = [];
var id_dxc = 0;
var id_dxcs = [];
var id_pxls = [];
var editarFile = 0;
var archivosAborrar = [];
var acceptFiles = '';
var nombreLote = '';
var nombreLotes = [];
var arrayCF = [];
var editarContrafoFirmado = 0;
var archivosResicion = [];
var banderaTipoProceso = 0;
var banderaFusionGlobal=0;
var idsArchivos = [];
var flagProcesoJuridicoGlobal = null;
var flagProcesoContraloriaGlobal = null;
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
    let banderaFusion = $(this).attr("data-banderaFusion");
    console.log(banderaFusion)
    var flagProcesoContraloria = $(this).attr("data-flagProcesoContraloria");
    var flagProcesoJuridico = $(this).attr("data-flagProcesoJuridico");
    flagProcesoJuridicoGlobal = flagProcesoJuridico;
    flagProcesoContraloriaGlobal = flagProcesoContraloria;
    console.log(flagProcesoJuridico)
    banderaFusion = banderaFusion == null ? 0 : banderaFusion
    banderaFusionGlobal = banderaFusion;
    nombreLote = $(this).attr("data-nombreLote");
    flagFusion = $(this).attr("data-fusion");
    let contenedorTitulo = $('#tituloLote');
    let tipotransaccion = $(this).attr("data-tipotransaccion");
    rescisionArchivo = $(this).attr("data-rescision");
    id_dxc = $(this).attr("data-id_dxc");
    contenedorTitulo.text(nombreLote);
    let flagEditar = $(this).attr("data-editar");
    var formData = new FormData();
    formData.append("idLote", idLote);
    formData.append("flagFusion", banderaFusion);
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
            formArchivos(tipotransaccion, data['opcionesLotes'], flagEditar, nombreLote,banderaFusion,flagProcesoContraloria,flagProcesoJuridico)
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });

    $("#archivosReestructura").modal();
});
function formArchivos(estatusProceso, datos, flagEditar, nombreLote, banderaFusion = 0,flagProcesoContraloria,flagProcesoJuridico) {
    archivosResicion = [];
    idsArchivos = [];
    id_dxcs = [];
    id_pxls = [];
    nombreLotes = [];
    rescisionArchivos = [];
    let label = '';
    console.log(datos)
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
    switch (id_rol_general) {
        case 17:
            label = '<b>Subir corrida del lote</b>';
            flagProceso = 2;
            acceptFiles = '.csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel';
            columnWith = 'col-md-12 col-lg-12';
            hideButton = 'hide';
            break;
        case 15:
            label = '<b>Subir contrato del lote</b>';
            flagProceso = 2;
            acceptFiles = 'application/pdf';
            columnWith = 'col-md-11 col-lg-11';
            hideButton = '';
            break;
    }
    console.log(flagProceso);
    console.log(flagProcesoJuridico);
    console.log(id_rol_general)
    if (flagEditar == 0) {
        editarFile = 0;
        let nuevosDatosOrigenBack= banderaFusion != 0 ?  datos.filter(destino => destino.origen == 1) : datos;
       let nuevosDatosDestino = banderaFusion != 0 ?  datos.filter(destino => destino.destino == 1) : datos;
       console.log(nombreLote);
      /* nuevosDatosOrigenBack.map((elementoBack, index2) => {
       // elementoBack.idStatusLote == 17 || elementoBack.idStatusLote == 16
        banderaFusion != 0  ?  nombreLotes.push(elementoBack.nombreLote) : nombreLotes.push(nombreLote);
    });*/
    if(banderaFusion != 0){
        nuevosDatosOrigenBack.map((elementoBack, index2) => {
            nombreLotes.push(elementoBack.nombreLote)
        });
    }else{
        nombreLotes.push(nombreLote);
    }
       nuevosDatosDestino.map((elemento, index) => {
        id_pxls.push(elemento.id_pxl);
        banderaTipoProceso=elemento.tipo_proceso;
       // elemento.idStatusLote == 17 || elemento.idStatusLote == 16  ? nombreLotes.push(elemento.nombreLote) : '';
        

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
            if (flagProceso == 2 && flagProcesoJuridico == 0 && id_rol_general == 15  ) {
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
        if (flagProceso == 2 && flagProcesoJuridico == 0 && id_rol_general == 15  ) {
            //se esta subiendo contrato se debe pedir uno adicional
            //cambiar el último número de la siguiente línea por datos[0]['tipo_proceso']
            let nuevosDatosOrigen = banderaFusion != 0 ? datos.filter(datosFusion => datosFusion.origen == 1) : [{"nombreLote" : nombreLote,"tipo_proceso":5,"id_pxl" : id_dxc, "rescisionArchivo" : rescisionArchivo}] ;
            console.log(datos);
            nombreLotes = [];
            nuevosDatosOrigen.map((elemento, index) => {
            nombreLotes.length == 0 ?  nombreLotes.push(elemento.nombreLote) : 0;
            idsArchivos.push(elemento.id_pxl);
            id_dxcs.push(elemento.id_pxl);
            rescisionArchivos.push(banderaFusion != 0 ? elemento.rescision : elemento.rescisionArchivo)
            const archivoLbl = elemento.tipo_proceso != "3" ? 'la rescisión del contrato' : 'el documento de reestructura';
            contenidoHTML += ' <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2"><hr>\n' +
                '                            <h6 class="text-left"><b>Subir '+archivoLbl+': </b>' + elemento.nombreLote + '<span class="text-red">*</span></h6>\n' +
                '                            <div class="" id="selectFileSectionResicion_'+elemento.id_pxl+'">\n' +
                '                                <div class="file-gph">\n' +
                '                                    <input class="d-none" type="file" required accept="application/pdf" id="Resicion_'+elemento.id_pxl+'">\n' +
                '                                    <input class="file-name" id="resicion-name_'+elemento.id_pxl+'" type="text" placeholder="No has seleccionada nada aún" readonly="">\n' +
                '                                    <label class="upload-btn m-0" for="Resicion_'+elemento.id_pxl+'"><span>Seleccionar</span><i class="fas fa-folder-open"></i></label>\n' +
                '                                </div>\n' +
                '                            </div>\n' +
                '                        </div>';
            });
        }
    }
    else if (flagEditar == 1) {
        editarFile = 1;
        let nuevosDatosOrigenBack= banderaFusion != 0 ?  datos.filter(destino => destino.origen == 1) : datos;
        console.log(datos);
        /*nuevosDatosOrigenBack.map((elementoBack, index2) => {
         elementoBack.idStatusLote == 17 || elementoBack.idStatusLote == 16 || elementoBack.idStatusLote == 2  ?  nombreLotes.push(elementoBack.nombreLote) : '';
     });*/
        if(banderaFusion != 0){
            nuevosDatosOrigenBack.map((elementoBack, index2) => {
                nombreLotes.push(elementoBack.nombreLote)
            });
        }else{
            nombreLotes.push(nombreLote);
        }
        let nuevosDatosDestino = banderaFusion != 0 ? datos.filter(destino => destino.destino == 1) : datos;
        nuevosDatosDestino.map((elemento, index) => {
            arrayKeysArchivos.push(elemento);
            id_pxls.push(elemento.id_pxl);

            if (flagProceso == 2 && flagProcesoJuridico == 0 && id_rol_general == 15  ) {
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
        if (flagProceso == 2 && flagProcesoJuridico == 0 && id_rol_general == 15  ) {
            //se esta subiendo contrato se debe pedir uno adicional
            let nuevosDatosOrigen = banderaFusion != 0 ? datos.filter(datosFusion => datosFusion.origen == 1) : [{"nombreLote" : nombreLote,"id_dxc" : id_dxc, "rescisionArchivo" : rescisionArchivo}] ;
            const archivoLbl = datos[0]['tipo_proceso'] != "3" ? 'la rescisión del contrato' : 'el documento de reestructura';

            nuevosDatosOrigen.map((elemento, index) => {
                nombreLotes.length == 0 ?  nombreLotes.push(elemento.nombreLote) : 0;
                elemento.id_dxc = banderaFusion != 0 ? elemento.id_pxl : elemento.id_dxc;
                idsArchivos.push(banderaFusion != 0 ? elemento.id_pxl : elemento.id_dxc);
                let idArchivo = banderaFusion != 0 ? elemento.id_pxl : elemento.id_dxc;
                id_dxcs.push(banderaFusion != 0 ? elemento.id_pxl : elemento.id_dxc);
                elemento.rescisionArchivo = banderaFusion != 0 ? elemento.rescision : elemento.rescisionArchivo;
                rescisionArchivos.push(banderaFusion != 0 ? elemento.rescision : elemento.rescisionArchivo)

                contenidoHTML += ' <div class="col col-xs-12 col-sm-12 col-md-10 col-lg-10 mb-2"><hr>\n' +
                '                            <h6 class="text-left"><b>Subir '+archivoLbl+': </b>' + elemento.nombreLote + '<span class="text-red">*</span></h6>\n' +
                '                            <div class="" id="selectFileSectionResicion">\n' +
                '                                <div class="file-gph">\n' +
                '                                    <input class="d-none" type="file" required accept="application/pdf" id="Resicion_'+idArchivo+'">\n' +
                '                                    <input class="file-name" id="resicion-name" type="text" placeholder="No has seleccionada nada aún" readonly="">\n' +
                '                                    <label class="upload-btn m-0 w-50" for="Resicion_'+idArchivo+'"><span>Seleccionar</span><i class="fas fa-folder-open"></i></label>\n' +
                '                                </div>\n' +
                '                            </div>\n' +
                '                        </div>';
            contenidoHTML += '          <div class="col col-xs-12 col-sm-12 col-md-2 col-lg-2  "><hr>\n' +
                '                           <div class="d-flex justify-center mt-4">' +
                '                               <button data-toggle="tooltip" data-placement="top" title="Visualizar archivo"' +
                '                               class="btn-data btn-sky ver-archivo" data-idPxl="' + idArchivo + '" ' +
                '                               data-nomArchivo="' + elemento.rescisionArchivo + '" data-nombreOriginalLote="' + elemento.nombreLote + '"' +
                '                               data-rescision="1"><i class="fas fa-eye"></i></button>' +
                '                           </div>' +
                '                        </div>';

            });
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
            contenidoHTML += '     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center"><span style="font-size: 1.5rem; text-transform: uppercase;">'+nombreCopropietario+'</span></div>';
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
            contenidoHTML += '                  <label class="control-label">INE/Pasaporte</label>';
            contenidoHTML += '                  <input readonly class="form-control input-gral" type="text" required="true" value="'+elemento.ine+'"/>';
            contenidoHTML += '          </div>';
            contenidoHTML += '     </div>';
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
    let arrayResicion = [];
    let validacionArray = [];
    let flagValidacion = 0;
    console.log(idsArchivos);
    for (let m = 0; m < idsArchivos.length; m++) {
        if($(`#Resicion_${idsArchivos[m]}`)[0].files[0] != undefined){
            arrayResicion.push(1);
        }else{
            arrayResicion.push(0);
        }        
    }
    arrayKeysArchivos.map((element, raiz)=>{
        if($("#fileElm"+raiz)[0].files[0] != undefined){
            validacionArray.push(1);
            flagValidacion = flagValidacion + 1;
        }
    });

    if (editarFile == 1) {
        console.log(arrayResicion);
        if (flagValidacion > 0 && banderaFusionGlobal == 0) {
            //hay al menos un archivo actualizado
            flagEnviar = true;
        }else if(flagValidacion > 0 && banderaFusionGlobal != 0){
            flagEnviar = true;
        }
        else if(banderaFusionGlobal != 0 && (((arrayResicion.includes(1) || flagValidacion > 0) && id_rol_general == 15 ) || id_rol_general == 17)){
            flagEnviar = true;
        }else{
            //detecta que no hay ni un archivo subido
            if (flagProceso == 2 && flagProcesoJuridicoGlobal == 0 && id_rol_general == 15  ) {
                if (!arrayResicion.includes(1) || flagValidacion == 0) {
                    alerts.showNotification('top', 'right', 'Nada que actualizar', 'warning');
                    flagEnviar = false;
                }
            } else if (flagProceso == 2  && flagProcesoContraloriaGlobal == 0 && id_rol_general == 17  ) {
                alerts.showNotification('top', 'right', 'Nada que actualizar', 'warning');
                flagEnviar = false;
            }
        }



        let data = new FormData();
        data.append("tipoProceso", flagProceso);
        data.append("longArray", arrayKeysArchivos.length);
        data.append("nombreLoteOriginal[]", nombreLotes);
        data.append("id_dxc[]", id_dxcs);
        data.append("id_pxls[]",id_pxls);
        data.append("editarFile", editarFile);
        data.append("banderaFusion", banderaFusionGlobal);

        arrayKeysArchivos.map((elemento, index) => {
            let flagEditar = ($("#fileElm" + index)[0].files[0] == undefined) ? 0 : 1;
            let idLotePR = (flagFusion==1) ? elemento.idFusion : elemento.id_pxl;

            data.append("flagEditado" + index, flagEditar);
            data.append("archivo" + index, $("#fileElm" + index)[0].files[0]);
            data.append("idLoteArchivo" + index, $("#idLotep" + idLotePR).val());
            data.append("nombreLote" + index, $("#nombreLote" + idLotePR).val());
            data.append('archivoEliminar' + index, archivosAborrar[index]);
        });
        if (flagProceso == 2 && flagProcesoJuridicoGlobal == 0 && id_rol_general == 15  ) {
            for (let m = 0; m < idsArchivos.length; m++) {
                data.append("archivoResicion_"+m, $(`#Resicion_${idsArchivos[m]}`)[0].files[0]);
                let flagEditarRescision = ($(`#Resicion_${idsArchivos[m]}`)[0].files[0] == undefined) ? 0 : 1;
                data.append("flagEditarRescision_"+m, flagEditarRescision);
            }
            data.append("countArchResi",idsArchivos.length);
            if (editarFile == 1) {
                data.append('rescisionArchivo[]', rescisionArchivos);
            }
        }
        console.log(flagEnviar);
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
                        flagProcesoJuridicoGlobal = null;
                        reubicacionClientes.ajax.reload();
                        flagProcesoJuridicoGlobal = null;
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
        
        if ((flagProceso == 2 && flagProcesoJuridicoGlobal == 0 && id_rol_general == 15  ) && arrayResicion.includes(0)) {
            $("#spiner-loader").addClass('hide');
            const archivoLbl = ([2,5,6].includes(banderaTipoProceso)) ? 'archivo de rescisión' : 'documento de reestructura';
            alerts.showNotification('top', 'right', `Selecciona ${archivoLbl}`, 'warning');
        }
        else {
            if (flagEnviar) {
                let data = new FormData();
                data.append("tipoProceso", flagProceso);
                data.append("longArray", arrayKeysArchivos.length);
                data.append("banderaFusion", banderaFusionGlobal);
                data.append("nombreLoteOriginal[]", nombreLotes);
                data.append("id_dxc[]", id_dxcs);
                data.append("id_pxls[]",id_pxls);
                data.append("editarFile", editarFile);
                data.append("flagFusion", flagFusion);
                console.log(arrayKeysArchivos);
                arrayKeysArchivos.map((elemento, index) => {
                    let idLotePR = (flagFusion==1) ? elemento.idFusion : elemento.id_pxl;
                    data.append("archivo" + index, $("#fileElm" + index)[0].files[0]);
                    data.append("idLoteArchivo" + index, $("#idLotep" + idLotePR).val());
                    data.append("nombreLote" + index, $("#nombreLote" + idLotePR).val());
                    data.append('archivoEliminar' + index, archivosAborrar[index]);
                });
                if (flagProceso == 2 && flagProcesoJuridicoGlobal == 0 && id_rol_general == 15  ) {
                    for (let m = 0; m < idsArchivos.length; m++) {
                        data.append("archivoResicion_"+m, $(`#Resicion_${idsArchivos[m]}`)[0].files[0]);
                    }
                    data.append("countArchResi",idsArchivos.length);
                    if (editarFile == 1) {
                        data.append('rescisionArchivo[]', rescisionArchivos);
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
                        flagProcesoJuridicoGlobal = null;
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
                            banderaFusionGlobal = 0, nombreLotes = [], id_dxcs = [], id_pxls = [];
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
    if (flagProceso == 2 && flagProcesoJuridicoGlobal == 0 && id_rol_general == 15  ) {
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
    if ((flagProceso == 2 && flagProcesoJuridicoGlobal == 0 && id_rol_general == 15  ) || rescision == 1) {
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
