var reubicacionClientes;
const TIPO_LOTE = Object.freeze({
    HABITACIONAL: 0,
    COMERCIAL: 1
});

const PROYECTO = Object.freeze({
    NORTE: 21,
    PRIVADAPENINSULA: 25
});

const STATUSLOTE = Object.freeze({
    DISPONIBLE : 1,
    CONTRATADO : 2,
    APARTADO : 3,
    ENGANCHE : 4,
    INTERCAMBIO : 6,
    DIRECCIÓN : 7,
    BLOQUEO : 8,
    CONTRATADO_POR_INTERCAMBIO : 9,
    APARTADO_CASAS : 10,
    DONACIÓN : 11,
    INTERCAMBIO_ESCRITURADO : 12,
    DISPONIBLE_REUBICACIÓN : 15,
    PARTICULAR : 102,
    APARTADO_REUBICACIÓN : 16,
});

const ESTATUS_PREPROCESO = ['PENDIENTE CARGA DE PROPUESTAS', 'REVISIÓN DE PROPUESTAS', 'ELABORACIÓN DE CORRIDAS', 'ELABORACIÓN DE CONTRATO Y RESICISIÓN', 'DOCUMENTACIÓN ENTREGADA', 'RECEPCIÓN DE DOCUMENTOS CONFIRMADA'];

let titulosTabla = [];
$('#reubicacionClientes thead tr:eq(0) th').each(function (i) {
    const title = $(this).text();
    titulosTabla.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function () {
        if ($('#reubicacionClientes').DataTable().column(i).search() !== this.value) {
            $('#reubicacionClientes').DataTable().column(i).search(this.value).draw();
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
});

reubicacionClientes = $('#reubicacionClientes').DataTable({
    dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
    width: '100%',
    scrollX: true,
    buttons: [{
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Lotes para reubicar',
        title:"Lotes para reubicar",
        exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
            format: {
                header: function (d, columnIdx) {
                    return ' ' + titulosTabla[columnIdx] + ' ';
                }
            }
        }
    },
    {
        extend: 'pdfHtml5',
        text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
        className: 'btn buttons-pdf',
        titleAttr: 'Lotes para reubicar',
        title:"Lotes para reubicar",
        orientation: 'landscape',
        pageSize: 'LEGAL',
        exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
            format: {
                header: function (d, columnIdx) {
                    return ' ' + titulosTabla[columnIdx] + ' ';
                }
            }
        }
    }],
    columnDefs: [{
        searchable: false,
        visible: false
    }],
    pageLength: 10,
    bAutoWidth: false,
    fixedColumns: true,
    ordering: false,
    language: {
        url: general_base_url+"static/spanishLoader_v2.json",
        paginate: {
            previous: "<i class='fa fa-angle-left'>",
            next: "<i class='fa fa-angle-right'>"
        }
    },
    order: [[4, "desc"]],
    destroy: true,
    columns: [
        { data: "nombreResidencial" },
        { data: "nombreCondominio" },
        { data: "nombreLote" },
        { data: "idLote" },
        { data: "cliente" },
        { data: "nombreAsesor" },
        { data: "nombreCoordinador" },
        { data: "nombreGerente" },
        { data: "nombreSubdirector" },
        { data: "nombreRegional" },
        { data: "nombreRegional2" },
        { data: "fechaApartado" },
        { data: "sup"},
        {
            data: function (d) {
                if( d.costom2f == 'SIN ESPECIFICAR')
                    return d.costom2f;
                else
                    return `$${formatMoney(d.costom2f)}`;
            }
        },
        {
            data: function (d) {
                return `$${formatMoney(d.total)}`;
            }
        },
        {
            data: function (d) {
                return `<span class='label lbl-violetBoots'>${d.estatusPreproceso}</span>`;
            }
        },
        { data: "nombreAsesorAsignado"},
        {
            data: function (d) {
                let btns = '';
                let editar = 0;
                let btnShow = 'fa-upload';
                if(d.id_estatus_preproceso == 2){
                    if(d.totalCorridas==3){
                        editar = 1;
                        btnShow = 'fa-edit';
                    }
                }else if(d.id_estatus_preproceso == 3){
                    if(d.totalContratos==3){
                        editar = 1;
                        btnShow = 'fa-edit';

                    }
                }

                const BTN_PROPUESTAS =  `<button class="btn-data btn-blueMaderas btn-asignar-propuestas" data-toggle="tooltip" data-placement="left" title="${d.id_estatus_preproceso == 0 ? 'ASIGNAR PROPUESTAS' : 'ACTUALIZAR PROPUESTAS'}" data-idCliente="${d.idCliente}" data-tipoLote="${d.tipo_lote}" data-idProyecto="${d.idProyecto}" data-statusPreproceso="${d.id_estatus_preproceso}"><i class="fas fa-user-edit"></i></button>`;
                const BTN_AVANCE =  `<button class="btn-data btn-green btn-avanzar" data-toggle="tooltip" data-placement="left" title="ENVIAR A ${ESTATUS_PREPROCESO[d.id_estatus_preproceso + 1]}" data-idCliente="${d.idCliente}" data-tipoTransaccion="${d.id_estatus_preproceso}"><i class="fas fa-thumbs-up"></i></button>`;
                const BTN_INFOCLIENTE =  `<button class="btn-data btn-green infoUser" data-toggle="tooltip" data-placement="left" data-idCliente="${d.idCliente}" data-idLote="${d.idLote}"><i class="fas fa-user-check"></i></button>`;
                const BTN_SUBIR_ARCHIVO =  `<button class="btn-data btn-blueMaderas btn-abrir-modal" data-toggle="tooltip" data-placement="left" title="CARGAR DOCUMENTACIÓN" data-idCliente="${d.idCliente}" data-idLote="${d.idLote}" data-nombreLote="${d.nombreLote}" data-estatusLoteArchivo="${d.status}" data-editar="${editar}" data-rescision="${d.rescision}" data-id_dxc="${d.id_dxc}" data-tipoTransaccion="${d.id_estatus_preproceso}"><i class="fas ${btnShow}"></i></button>`;

                if (d.id_estatus_preproceso == 0 && id_rol_general == 3)
                    btns += BTN_PROPUESTAS;
                else if (d.id_estatus_preproceso == 1 && id_rol_general == 3){
                    btns += BTN_PROPUESTAS;
                    if(d.idLoteXcliente == null){
                        btns += BTN_INFOCLIENTE;
                    }else{
                        btns += BTN_AVANCE;
                        btns += BTN_INFOCLIENTE;
                    }
                }
                else if (d.id_estatus_preproceso == 2 && id_rol_general == 17) {
                    if (d.totalCorridas == 3)
                        btns += BTN_AVANCE;
                        btns += BTN_SUBIR_ARCHIVO
                }
                else if (d.id_estatus_preproceso == 3 && id_rol_general == 15) {
                    if (d.totalContratos == 3 && d.totalRescision == 1)
                        btns += BTN_AVANCE;
                        btns += BTN_SUBIR_ARCHIVO    
                }
                else if (d.id_estatus_preproceso == 4 && id_rol_general == 6)
                    btns += BTN_AVANCE;
                else if (d.id_estatus_preproceso == 5) {
                    if(d.idProyecto == PROYECTO.NORTE || d.idProyecto == PROYECTO.PRIVADAPENINSULA){
                        btns +=  `<button class="btn-data btn-sky btn-reestructurar" data-toggle="tooltip" data-placement="left" title="REESTRUCTURAR" data-idCliente="${d.idCliente}"><i class="fas fa-map-marker"></i></button>`;
                    }
                        btns += `<button class="btn-data btn-green btn-reubicar" data-toggle="tooltip" data-placement="left" title="REUBICAR CLIENTE" data-idCliente="${d.idCliente}" data-idProyecto="${d.idProyecto}" data-tipoLote="${d.tipo_lote}"><i class="fas fa-route"></i></button>`;
                }
                return `<div class="d-flex justify-center">${btns}</div>`;
            }
        }
    ],
    ajax: {
        url: `${general_base_url}Reestructura/getListaClientesReubicar`,
        dataSrc: "",
        type: "POST",
        cache: false,
    },
    initComplete: function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    },
});

$(document).on('click', '.btn-reestructurar', function () {
    const tr = $(this).closest('tr');
    const row = $('#reubicacionClientes').DataTable().row(tr);
    const idCliente = $(this).attr("data-idCliente");
    const nombreCliente = row.data().cliente;
    const nombreLote = row.data().nombreLote;

    changeSizeModal('modal-md');
    appendBodyModal(`
        <form method="post" id="formReestructura">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 text-center">
                        <h3 class="m-0">Restructuración del cliente</h3>
                        <h6 class="m-0">${nombreCliente}</h6>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 mt-2">
                        <p class="text-center">¿Estás seguro que deseas reestructurar el lote <b>${nombreLote}</b>? <br>Recuerda que al realizar este movimiento, el lote sufrirá algunos cambios al confirmar.</p>
                        <input type="hidden" id="idCliente" name="idCliente" value="${idCliente}">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-end">
                        <button type="button" class="btn btn-simple btn-danger" onclick="hideModal()">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Aceptar</button>
                    </div>
                </div>
            </div>
        </form>`);
    showModal();
});

$(document).on('click', '.btn-asignar-propuestas', function () {
    const tr = $(this).closest('tr');
    const row = $('#reubicacionClientes').DataTable().row(tr);
    const nombreCliente = row.data().cliente;
    const nombreLote = row.data().nombreLote;
    const superficie = row.data().sup;
    const idProyecto = $(this).attr("data-idProyecto");
    const tipoLote = $(this).attr("data-tipoLote");
    const idLoteOriginal = row.data().idLote;
    const statusPreproceso = $(this).attr("data-statusPreproceso"); 

    changeSizeModal('modal-md');
    appendBodyModal(`
        <form method="post" id="formAsignarPropuestas">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 text-center">
                        <h3 class="m-0">Reubicación</h3>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <p class="m-0 text-center">Cliente. ${nombreCliente}</p>
                        <p class="m-0 text-center">Lote. ${nombreLote}</p>
                        <p class="m-0 text-center">Superficie. ${superficie}</p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 overflow-hidden">
                        <label class="lbl-gral">Proyecto</label>
                        <select name="proyectoAOcupar" title="SELECCIONA UNA OPCIÓN" id="proyectoAOcupar" class="selectpicker m-0 select-gral" data-live-search="true" data-container="body" data-width="100%">
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 overflow-hidden">
                        <label class="lbl-gral">Condominio</label>
                        <select name="condominioAOcupar" title="SELECCIONA UNA OPCIÓN" id="condominioAOcupar" class="selectpicker m-0 select-gral" data-live-search="true" data-container="body" data-width="100%">
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 overflow-hidden">
                        <label class="lbl-gral">Lote</label>
                        <select name="loteAOcupar" title="SELECCIONA UNA OPCIÓN" id="loteAOcupar" class="selectpicker m-0 select-gral" data-live-search="true" data-container="body" data-width="100%">
                        </select>
                    </div>
                    <div class="col-12 col-sm-9 col-md-9 col-lg-9">
                    </div>
                    <div class="col-12 col-sm-3 col-md-3 col-lg-3">
                        <button type="button" id="btnAddPropuesta" data-statusPreproceso="${statusPreproceso}" class="btn btn-gral d-none">Añadir</button>
                    </div>
                </div>
                <div class="row mt-2" id="infoLotesSeleccionados">
                </div>
                <input type="hidden" id="superficie" value="${superficie}">
                <input type="hidden" id="tipoLote" value="${tipoLote}">
                <input type="hidden" id="idLoteOriginal" name="idLoteOriginal" value="${idLoteOriginal}">
                <input type="hidden" id="statusPreproceso" name="statusPreproceso" value="${statusPreproceso}">
                <div class="row mt-2">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-end">
                        <button type="button" class="btn btn-simple btn-danger" onclick="hideModal()">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Aceptar</button>
                    </div>
                </div>
            </div>
        </form>
    `);
    showModal();

    getProyectosAOcupar(idProyecto, superficie, tipoLote);
    getPropuestas(idLoteOriginal, statusPreproceso, idProyecto, superficie, tipoLote);
});

$(document).on('click', '.infoUser', function (){
    $('#ineCLi').val('');
    $("#estadoCli").empty();

    var idCliente = $(this).attr('data-idCliente');
    var idLote = $(this).attr('data-idLote');

    $.getJSON("getCliente/" + idCliente + "/" + idLote  , function(cliente) {
        
        const nombreLote = cliente.nombre;
        const apePaterno = cliente.apellido_paterno;
        const apeMaterno = cliente.apellido_materno;
        const telefono = cliente.telefono1;
        const correo = cliente.correo;
        const domicilio = cliente.domicilio_particular;
        const ocupacion= cliente.ocupacion;
        const ine = cliente.ine;

        changeSizeModal('modal-md');
        appendBodyModal(`<form method="post" id="formInfoCliente">
                    <div class="modal-header">
                        <h4 class="modal-title text-center">Corrobora la información del cliente</h4>
                    </div>	
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 m-0">
                                <label class="control-label">Nombre (<small style="color: red;">*</small>)</label>
                                <input class="form-control input-gral" name="nombreCli" id="nombreCli" type="text" value="${nombreLote}" required/>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 m-0">
                                <label class="control-label">Apellido paterno (<small style="color: red;">*</small>)</label>
                                <input class="form-control input-gral" name="apellidopCli" id="apellidopCli" value="${apePaterno}" type="text" required/>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 m-0">
                                <label class="control-label">Apellido materno (<small style="color: red;">*</small>)</label>
                                <input class="form-control input-gral" name="apellidomCli" id="apellidomCli" type="text" value="${apeMaterno}" required/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 m-0">
                                <label class="control-label">Teléfono (<small style="color: red;">*</small>)</label>
                                <input class="form-control input-gral" name="telefonoCli" id="telefonoCli" type="number" maxlength="10" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" value="${telefono}" required/>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 m-0">
                                <label class="control-label">Correo (<small style="color: red;">*</small>)<small class="pl-1" id="result"></small></label>
                                <input class="form-control input-gral" name="correoCli" id="correoCli" oninput= "validate()" type="email" value="${correo}" required/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 m-0">
                                <label class="control-label">Domicilio (<small style="color: red;">*</small>)</label>
                                <input class="form-control input-gral" name="domicilioCli" id="domicilioCli" type="text" value="${domicilio}" required/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 m-0">
                                <label class="control-label">Estado civil (<small style="color: red;">*</small>)</label>
                                <select name="estadoCli" title="SELECCIONA UNA OPCIÓN" id="estadoCli" class="selectpicker m-0 select-gral" data-container="body" data-width="100%" required></select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 m-0">
                                <label class="control-label">INE (<small style="color: red;">*</small>)</label>
                                <input class="form-control input-gral" name="ineCLi" id="ineCLi" type="number" maxlength="13" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" value="${ine}" required/>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 m.0">
                                <label class="control-label">Ocupación (<small style="color: red;">*</small>)</label>
                                <input class="form-control input-gral" name="ocupacionCli" id="ocupacionCli" type="text" value="${ocupacion}" required/>
                            </div>
                        </div>        
                        <input type="hidden" name="idCliente" id="idCliente" value="${idCliente}">
                        <input type="hidden" name="idLote" id="idLote" value="${idLote}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="cancelarValidacion" class="btn btn-danger btn-simple cancelarValidacion" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="guardarCliente" name="guardarCliente" class="btn btn-primary guardarValidacion">GUARDAR</button>
                    </div>
                </form>`);
        showModal();

        $.post("getEstadoCivil", function(estadoCivil) {
            var len = estadoCivil.length;
            for (var i = 0; i < len; i++) {
                var id = estadoCivil[i]['id_opcion'];
                var name = estadoCivil[i]['nombre'];

                if(id == cliente.idEstadoC){
                    $("#estadoCli").append($('<option selected>').val(id).text(name.toUpperCase()));    
                }else{
                    $("#estadoCli").append($('<option>').val(id).text(name.toUpperCase()));
                }
            }
            $("#estadoCli").selectpicker('refresh');
        }, 'json');

    }, 'json');
});

const validateEmail = (email) => {
    return email.match(
        /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );
}

const validate = () => {
    const $result = $('#result');
    const email = $('#correoCli').val();
    $result.text('');

    if(validateEmail(email)){
        $result.text('El correo es válido');
        $result.css('color', 'rgb(26 159 10)');
    } else{
        $result.text('El correo es inválido.');
        $result.css('color', 'red');
    }
    return false;
}

$(document).on('click', '#guardarCliente', function (){
    var idLote = $('#idLote').val();
    var telefonoCli = $('#telefonoCli').val();
    var correoCli = $('#correoCli').val();
    var domicilioCli = $('#domicilioCli').val();
    var ineCLi = $('#ineCLi').val();
    var ocupacionCli = $('#ocupacionCli').val();

    if(ineCLi == ''){
        alerts.showNotification("top", "right", "Captura la INE", "warning");
        return;
    }

    if (telefonoCli == '' || telefonoCli == null){
        alerts.showNotification("top", "right", "El número de el INE debe tener 13 caracteres", "warning");
        return;
    }

    if (correoCli == '' || correoCli == null){
        alerts.showNotification("top", "right", "Captura el correo", "warning");
        return;
    }

    if(!validateEmail(correoCli)){
        alerts.showNotification("top", "right", "Capture el correo de forma correcta", "warning");
        return;
    }
    
    if (domicilioCli == '' || domicilioCli == null){
        alerts.showNotification("top", "right", "Captura el domicilio", "warning");
        return;
    }

    if(ocupacionCli == '' || ocupacionCli == null){
        alerts.showNotification("top", "right", "Captura la ocupación", "warning");
        return;
    }

    let datos = new FormData($("#formInfoCliente")[0]);
    $("#spiner-loader").removeClass('hide');
    $.ajax({
        method: 'POST',
        url: general_base_url + 'Reestructura/insetarCliente/'+ idLote,
        data: datos,
        processData: false,
        contentType: false,
        success: function(data) {
            if (data == 1) {
            hideModal();
            alerts.showNotification("top", "right", "Información capturada con éxito.", "success");
            $("#spiner-loader").addClass('hide');
            $('#ineCLi').val('');
            $('#telefonoCli').val('');
            $('#correoCli').val('');
            $('#domicilioCli').val('');
            $('#ocupacionCli').val('');
            $('#reubicacionClientes').DataTable().ajax.reload(null, false);
            }
        },
        error: function(){
            $('#aceptarReestructura').modal('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            $("#spiner-loader").addClass('hide');
        }
    });
});

$(document).on('click', '.btn-reubicar', function () {
    const tr = $(this).closest('tr');
    const row = $('#reubicacionClientes').DataTable().row(tr);
    const nombreCliente = row.data().cliente;
    const nombreLote = row.data().nombreLote;
    const superficie = row.data().sup;
    const idProyecto = $(this).attr("data-idProyecto");
    const tipoLote = $(this).attr("data-tipoLote");
    const idLoteOriginal = row.data().idLote;
    const statusPreproceso = $(this).attr("data-statusPreproceso"); 
    const idCliente = $(this).attr("data-idCliente");


    changeSizeModal('modal-md');
    appendBodyModal(`
        <form method="post" id="formAsignarPropuestas">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 text-center">
                        <h3 class="m-0">Reubicación</h3>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <p class="m-0 text-center">Cliente. ${nombreCliente}</p>
                        <p class="m-0 text-center">Lote. ${nombreLote}</p>
                        <p class="m-0 text-center">Superficie. ${superficie}</p>
                    </div>
                </div>
                <div class="row mt-2" id="infoLotesSeleccionados">
                </div>
                <input type="hidden" id="superficie" value="${superficie}">
                <input type="hidden" id="tipoLote" value="${tipoLote}">
                <input type="hidden" id="idLoteOriginal" name="idLoteOriginal" value="${idLoteOriginal}">
                <input type="hidden" id="idCliente" name="idCliente" value="${idCliente}">
                <input type="hidden" id="statusPreproceso" name="statusPreproceso" value="${statusPreproceso}">
                <div class="row mt-2">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-end">
                        <button type="button" class="btn btn-simple btn-danger" onclick="hideModal()">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Aceptar</button>
                    </div>
                </div>
            </div>
        </form>
    `);
    showModal();

    getPropuestas(idLoteOriginal, statusPreproceso);
});

function getProyectosAOcupar(idProyecto, superficie, tipoLote) {
    $('#spiner-loader').removeClass('hide');
    $.post("getProyectosDisponibles", {"idProyecto" : idProyecto, "superficie" : superficie, "tipoLote": tipoLote}, function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['proyectoReubicacion'];
            var name = data[i]['descripcion'];
            var disponible = data[i]['disponibles'];
            $("#proyectoAOcupar").append($('<option>').val(id).text(name +' ('+ disponible + ')'));
        }
        $('#spiner-loader').addClass('hide');
        $("#proyectoAOcupar").selectpicker('refresh');
    }, 'json');
}

function getPropuestas(idLoteOriginal, statusPreproceso, idProyecto, superficie, tipoLote){
    $('#spiner-loader').removeClass('hide');
    $.post("obtenerPropuestasXLote", {"idLoteOriginal" : idLoteOriginal}, function(data) {
        for (let lote of data) {
            let html = divLotesSeleccionados(statusPreproceso, lote.nombreLote, lote.sup, lote.id_lotep, lote.id_pxl, idProyecto, superficie, tipoLote);
            $("#infoLotesSeleccionados").append(html);
        }
        $('#spiner-loader').addClass('hide');
    }, 'json');
}

$(document).on("change", "#proyectoAOcupar", function(e){
    $('#spiner-loader').removeClass('hide');
    $("#condominioAOcupar").html("");
    $("#loteAOcupar").html("");
    $("#loteAOcupar").selectpicker('refresh');
    idProyecto = $(this).val();
    superficie = $("#superficie").val();
    tipoLote = $("#tipoLote").val();
    $.post("getCondominiosDisponibles", {"idProyecto": idProyecto, "superficie": superficie, "tipoLote": tipoLote}, function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idCondominio'];
            var name = data[i]['nombre'];
            var disponible = data[i]['disponibles'];
            $("#condominioAOcupar").append($('<option>').val(id).text(name +' ('+ disponible + ')'));
        }
        $('#spiner-loader').addClass('hide');
        $("#condominioAOcupar").selectpicker('refresh');
    }, 'json');
});

$(document).on("change", "#condominioAOcupar", function(e){
    $('#spiner-loader').removeClass('hide');
    $("#loteAOcupar").html("");
    idCondominio = $(this).val();
    superficie = $("#superficie").val();

    $.post("getLotesDisponibles", {"idCondominio": idCondominio, "superficie": superficie}, function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idLote'];
            var name = data[i]['nombreLote'];
            var precioMetro = data[i]['precio'];
            var superficie = data[i]['sup'];
            var total = data[i]['total'];
            var a_favor = data[i]['a_favor'];
            $("#loteAOcupar").append($('<option>').val(id).attr('data-nombre', name).attr('data-precioMetro', precioMetro).attr('data-superficie', superficie).attr('data-total', total).addClass('green').text(name +' ('+ a_favor + ')'));
        }
        $('#spiner-loader').addClass('hide');
        $("#loteAOcupar").selectpicker('refresh');
    }, 'json');
});

$(document).on("change", "#loteAOcupar", function(e){
    $('#btnAddPropuesta').removeClass('d-none');
})

function removeLote(e, idLote, statusPreproceso, id_pxl, idProyecto, superficie, tipoLote) {
    if (statusPreproceso == 1) {
        $('#spiner-loader').removeClass('hide');
        let data = new FormData();
        data.append("idLote", idLote);
        data.append("id_pxl", id_pxl);
        $.ajax({
            url : 'setLoteDisponible',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST', 
            success: function(data) {
                $('#spiner-loader').addClass('hide');
                if(data) {
                    alerts.showNotification("top", "right", "El registro se ha eliminado y liberado con éxito.", "success");
                    getProyectosAOcupar(idProyecto, superficie, tipoLote);
                    let divLote = e.closest( '.lotePropuesto' );
                    divLote.remove();
                }
                else
                    alerts.showNotification("top", "right", "Oops, algo salió mal. Inténtalo más tarde.", "danger")
            },
            error: function(data){
                alerts.showNotification("top", "right", "Oops, algo salió mal. Inténtalo más tarde.", "danger");
                $('#spiner-loader').addClass('hide');
            }
        });
    }
    else {
        let divLote = e.closest( '.lotePropuesto' );
        divLote.remove();
    }
}

$(document).on("click", "#btnAddPropuesta", function(e) {
    const statusPreproceso = $(this).attr("data-statusPreproceso");
    const $itself = $("#loteAOcupar").find(':selected');
    const numberLotes = $('#infoLotesSeleccionados .lotePropuesto').length;
    const idLotes = document.getElementsByClassName('idLotes');
    let existe = false;
    for (let idLote of idLotes) {
        if(idLote.value == $itself.val()){
            existe = true;
        };
    }

    if(existe){
        alerts.showNotification("top", "right", "El lote ya ha sido agregado", "danger");
        return;
    }
    if ( numberLotes <= 2 ){
        const nombreLote = $itself.attr("data-nombre");
        const superficie = $itself.attr("data-superficie");
        const idLote = $itself.val();
        const html = divLotesSeleccionados(statusPreproceso, nombreLote, superficie, idLote);
        
        $("#infoLotesSeleccionados").append(html);
    }
    else{
        alerts.showNotification("top", "right", "No puedes seleccionar más de tres lotes", "danger");
    }
});

function divLotesSeleccionados(statusPreproceso, nombreLote, superficie, idLote, id_pxl = null, idProyecto = null, tipoLote = null){
    if (statusPreproceso == 0){
        html = `
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 mt-2 lotePropuesto">
                <div class="p-2 pt-1" style="background-color: #eaeaea; border-radius:15px">
                    <div class="d-flex justify-between">
                        <h5 class="mb-0 mt-2 text-center">LOTE SELECCIONADO</h5>
                        <button type="button" class="fl-r" onclick="removeLote(this, ${idLote}, ${statusPreproceso}, ${id_pxl}, ${idProyecto}, ${superficie}, ${tipoLote})" style="color: gray; background-color:transparent; border:none;" title="Eliminar selección"><i class="fas fa-times"></i></button>
                    </div>
                    <span class="w-100 d-flex justify-between">
                        <p class="m-0">Lote</p>
                        <p class="m-0"><b>${nombreLote}</b></p>
                    </span>
                    <span class="w-100 d-flex justify-between">
                        <p class="m-0">Superficie</p>
                        <p class="m-0"><b>${superficie}</b></p>
                    </span>
                    <input type="hidden" class="idLotes" name="idLotes[]" value="${idLote}">
                </div>
            </div>
        `;
    }
    else{
        html = `
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 mt-2 lotePropuesto">
                <div class="" id="checkDS">
                    <div class="container boxChecks p-0">
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 p-0">
                            <label class="m-0 checkstyleDS">
                                <input type="checkbox" name="idOficial_pf" id="idOficial_pf" value="1" >
                                <span>IDENTIFICACIÓN OFICIAL</span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 p-0">
                            <label class="m-0 checkstyleDS">
                                <input type="checkbox" name="idOficial_pf" id="idOficial_pf" value="1" >
                                <span>IDENTIFICACIÓN OFICIAL</span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 p-0">
                            <label class="m-0 checkstyleDS">
                                <input type="checkbox" name="idOficial_pf" id="idOficial_pf" value="1" >
                                <span>IDENTIFICACIÓN OFICIAL</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
    return html;
}

$(document).on("submit", "#formReubicacion", function(e){
    e.preventDefault();
    $('#spiner-loader').removeClass('hide');
    let data = new FormData($(this)[0]);
    $.ajax({
        url : 'asignarPropuestasLotes',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST', 
        success: function(data){
            data = JSON.parse(data);
            alerts.showNotification("top", "right", ""+data.message+"", ""+data.color+"");
            $('#spiner-loader').addClass('hide');
            $('#reubicacionClientes').DataTable().ajax.reload();
            hideModal();
        },
        error: function( data ){
            alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            hideModal();
        }
    });
});

$(document).on("submit", "#formAsignarPropuestas", function(e){
    e.preventDefault();
    const numberLotes = $('#infoLotesSeleccionados .lotePropuesto').length;
    if(numberLotes < 3){
        alerts.showNotification("top", "right", "Debes seleccionar 3 lotes", "danger");
        return;
    }
    else{
        $('#spiner-loader').removeClass('hide');
        let data = new FormData($(this)[0]);
        $.ajax({
            url : 'asignarPropuestasLotes',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST', 
            success: function(data){
                data = JSON.parse(data);
                alerts.showNotification("top", "right", ""+data.message+"", ""+data.color+"");
                $('#spiner-loader').addClass('hide');
				$('#reubicacionClientes').DataTable().ajax.reload();
                hideModal();
            },
            error: function( data ){
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                hideModal();
            }
        });
    }
});

$(document).on("submit", "#formReestructura", function(e){
    $('#spiner-loader').removeClass('hide');
    e.preventDefault();
    let data = new FormData($(this)[0]);
    $.ajax({
        url : 'setReestructura',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST', 
        success: function(data){
            data = JSON.parse(data);
            alerts.showNotification("top", "right", ""+data.message+"", ""+data.color+"");
            $('#reubicacionClientes').DataTable().ajax.reload();
            $('#spiner-loader').addClass('hide');
            hideModal();
        },
        error: function( data ){
            alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            hideModal();
        }
    });
});



$(document).on('click', '.btn-avanzar', function () {

    const tr = $(this).closest('tr');
    const row = $('#reubicacionClientes').DataTable().row(tr);
    const nombreLote = row.data().nombreLote;
    const idLote = row.data().idLote;
    const tipoTransaccion = $(this).attr("data-tipoTransaccion");
    changeSizeModal('modal-sm');
    appendBodyModal(`
        <form method="post" id="formAvanzarEstatus">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 text-center">
                        <h6 class="m-0">¿Estás seguro de envíar el lote <b>${nombreLote}</b> a <b><i>${ESTATUS_PREPROCESO[parseInt(tipoTransaccion) + 1]}</i></b></h6>
                    </div>                
                    <input type="hidden" id="idLote" name="idLote" value="${idLote}">
                    <input type="hidden" id="tipoTransaccion" name="tipoTransaccion" value="${tipoTransaccion}">
                    <div class="row mt-2">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-end">
                            <button type="button" class="btn btn-simple btn-danger" onclick="hideModal()">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Aceptar</button>
                        </div>
                </div>
            </div>
        </form>
    `);
    showModal();
});

$(document).on("submit", "#formAvanzarEstatus", function(e) {
    $('#spiner-loader').removeClass('hide');
    e.preventDefault();
    let data = new FormData();
    data.append("idLote", $("#idLote").val());
    data.append("tipoTransaccion", $("#tipoTransaccion").val());
    $.ajax({
        url : 'setAvance',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST', 
        success: function(data){
            alerts.showNotification("top", "right", "El registro se ha avanzado con éxito.", "success");
            $('#reubicacionClientes').DataTable().ajax.reload();
            $('#spiner-loader').addClass('hide');
            hideModal();
        },
        error: function( data ){
            alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            hideModal();
        }
    });
});
