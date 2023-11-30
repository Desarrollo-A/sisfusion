$(document).ready(function () {
    if (id_usuario_general === 13733) { // ES EL USUARIO DE CONTROL JURÍDICO PARA REASIGNACIÓN DE EXPEDIENTES
        $.post(`${general_base_url}Reestructura/getListaUsuariosReasignacionJuridico`, function (data) {
            for (var i = 0; i < data.length; i++) {
                $("#id_usuario").append($('<option>').val(data[i]['id_usuario']).text(data[i]['nombreUsuario']));
            }
            $("#id_usuario").selectpicker('refresh');
        }, 'json');
    }
});

function obtenerDataFusion(idLoteOriginal) {
    return new Promise((resolve) => {
        $.post(`${general_base_url}Reestructura/getFusion`, {idLote: idLoteOriginal, tipoOrigenDestino:1}, (data) => {
            $("#spiner-loader").addClass('hide');
            const response = JSON.parse(data);
            resolve(response);
        });
    });
}

let reubicacionClientes;
let estadoCivilList = [];
let copropietariosEliminar = [];
let sumatoriaLS = 0; //

const TIPO_LOTE = Object.freeze({
    HABITACIONAL: 0,
    COMERCIAL: 1
});

const TIPO_PROCESO = Object.freeze({
    REUBICACION: 2,
    REESTRUCTURA: 3
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
    DIRECCION : 7,
    BLOQUEO : 8,
    CONTRATADO_POR_INTERCAMBIO : 9,
    APARTADO_CASAS : 10,
    DONACION : 11,
    INTERCAMBIO_ESCRITURADO : 12,
    DISPONIBLE_REUBICACION : 15,
    PARTICULAR : 102,
    APARTADO_REUBICACION : 16,
});

const ESTATUS_PREPROCESO = [
    'PENDIENTE CARGA DE PROPUESTAS',
    'REVISIÓN DE PROPUESTAS',
    'ELABORACIÓN DE CORRIDAS, CONTRATO Y RESCISIÓN',
    'RECEPCIÓN DE DOCUMENTACIÓN',
    'OBTENCIÓN DE FIRMA DEL CLIENTE',
    'CONTRATO FIRMADO CONFIRMADO, PENDIENTE TRASPASO DE RECURSO',
    'RECURSO TRASPASADO, PENDIENTE EJECUCIÓN APARTADO NUEVO',
    'PROCESO DE CONTRATACIÓN'
];

const ROLES_PROPUESTAS = [2, 3, 5, 6]; // ROLES PERMITIDOS PARA CARGA, EDICIÓN Y ENVÍO DE PROPUESTAS

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
            columns: id_rol_general === 15 ? [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20] : [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
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
            columns: id_rol_general === 15 ? [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20] : [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
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
        {
            data: (d) => {
                return `<span class="label" 
                    style="color: ${d.estatus_modificacion_color}; background: ${d.estatus_modificacion_color}18;}">
                    ${d.estatus_modificacion}
                </span>`;
            }
        },
        {
            data: (d)=>{
                let nombreResidencial = d.nombreResidencial;
                let lblFusion = '';
                if(d.idLotePvOrigen != null){
                    if(d.idLotePvOrigen == d.idLote){
                        lblFusion = '<br><label class="label lbl-fusionMaderas ">FUSIÓN PV '+d.idLotePvOrigen+'</label>';
                    }else{
                        lblFusion = '<br><label class="label lbl-fusionMaderas ">FUSIÓN '+d.idLotePvOrigen+'</label>';
                    }
                }
                return nombreResidencial + lblFusion;
            }
        },
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
            data: (d) => {
                return (d.comentario == null || d.comentario == '')
                    ? '<p class="m-0">NO DEFINIDO</p>'
                    : `<p class="m-0">${d.comentario}</p>`;
            }
        },
        {
            visible: (id_rol_general == 15) ? true : false,
            data: "nombreEjecutivoJuridico"
        },
        {
            visible: (id_rol_general == 15) ? true : false,
            data: "sedeAsesorAsignado"
        },
        {
            data: function (d) {
                let boton = (d.plan_comision != 0 && d.plan_comision != undefined) ? `<div class="d-flex justify-center">${botonesAccionReubicacion(d)}</div>` : `<p class="m-0">SIN PLAN COMISIÓN</p>`;
                return (d.idLotePvOrigen != null && d.idLotePvOrigen == d.idLote) ?                
                boton
                :((d.idLotePvOrigen == null) ? boton : '');
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

$(document).on('click', '.btn-asignar-propuestas-rees', function () {
    const tr = $(this).closest('tr');
    const row = $('#reubicacionClientes').DataTable().row(tr);
    const nombreCliente = row.data().cliente;
    const nombreLote = row.data().nombreLote;
    const idLoteOriginal = row.data().idLote;
    const superficie = row.data().superficie;
    const statusPreproceso = $(this).attr("data-statusPreproceso");
    const idCliente = $(this).attr("data-idCliente");
    const idProyecto = $(this).attr("data-idProyecto");
    const tipoEstatusRegreso = $(this).attr("data-tipoEstatusRegreso");
    const idPxl = $(this).attr("data-idPxl");

    const botones = (statusPreproceso == 0) ? `<button type="submit" id="" class="btn btn-primary">Aceptar</button>` : `  
                                               <button type="button" id="resetReestructura" class="btn btn-primary mr-1" onclick="removeLote(this, ${idLoteOriginal}, ${statusPreproceso}, ${idPxl}, ${idProyecto}, ${superficie}, ${tipoEstatusRegreso}, ${TIPO_PROCESO.REESTRUCTURA})">Regresar movimiento</button>`;

    changeSizeModal('modal-md');
    appendBodyModal(`
        <form method="post" id="formAsignarPropuestaRees">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 text-center">
                        <h3 class="m-0">Restructuración del cliente</h3>
                        <h6 class="m-0">${nombreCliente}</h6>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 mt-2">
                        <p class="text-center">${statusPreproceso == 0 ? '¿Estás seguro que deseas reestructurar el lote ' : '¿Deseas regresar a asignación de propuestas el lote ' }  <b>${nombreLote}</b>?</p>
                        <input type="hidden" id="idCliente" name="idCliente" value="${idCliente}">
                        <input type="hidden" id="idLotes" name="idLotes[]" value="${idLoteOriginal}">
                        <input type="hidden" id="idLoteOriginal" name="idLoteOriginal" value="${idLoteOriginal}">
                        <input type="hidden" id="statusPreproceso" name="statusPreproceso" value="${statusPreproceso}">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-end">
                        <button type="button" class="btn btn-simple btn-danger" onclick="hideModal()">Cancelar</button>
                        ${botones}
                    </div>
                </div>
            </div>
        </form>
    `);

    showModal();
});

$(document).on('click', '.btn-asignar-propuestas', async function (){
    $("#spiner-loader").removeClass('hide');

    sumatoriaLS = 0;
    const tr = $(this).closest('tr');
    const row = $('#reubicacionClientes').DataTable().row(tr);
    const nombreCliente = row.data().cliente;
    const idProyecto = $(this).attr("data-idProyecto");
    const idLoteOriginal = row.data().idLote;
    const statusPreproceso = $(this).attr("data-statusPreproceso");
    const idCliente = $(this).attr("data-idCliente");

    const botonAceptar = (statusPreproceso != 1) ? '<button type="submit" class="btn btn-primary">Aceptar</button>' : '';

    let flagFusion = $(this).attr('data-fusion');
    let superficie = 0;
    let nombreLote = '';
    if(flagFusion==1){
        const responseLotesFusionados = await obtenerDataFusion(idLoteOriginal);

        if (responseLotesFusionados.status === 200) {
            lotesFusionados = responseLotesFusionados.data;
            lotesFusionados.map((elemento, index)=>{
                superficie = parseFloat(elemento.sup) + superficie;
                nombreLote += elemento.nombreLotes+' ';
            });
            superficie = (superficie).toFixed(2);
        }
        if (responseLotesFusionados.status === 500) {
            return;
        }
    }
    else{
        $("#spiner-loader").addClass('hide');
        nombreLote = row.data().nombreLote;
        superficie = row.data().sup;
    }

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
                    <select name="loteAOcupar" 
                        title="SELECCIONA UNA OPCIÓN" 
                        id="loteAOcupar" 
                        class="selectpicker m-0 select-gral" 
                        data-live-search="true" 
                        data-container="body" 
                        data-width="100%"
                        data-statusPreproceso="${statusPreproceso}"
                        data-idProyecto="${idProyecto}" 
                        data-superficie="${superficie}"
                        data-idLoteOriginal="${idLoteOriginal}">
                    </select>
                </div>
            </div>
            <div class="row mt-2" id="infoLotesSeleccionados">
            </div>
            <input type="hidden" id="superficie" value="${superficie}">
            <input type="hidden" id="idLoteOriginal" name="idLoteOriginal" value="${idLoteOriginal}">
            <input type="hidden" id="statusPreproceso" name="statusPreproceso" value="${statusPreproceso}">
            <input type="hidden" name="idCliente" value="${idCliente}">
            <input type="hidden" id="flagFusion" value="${flagFusion}">
            <div class="row mt-2">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-end">
                    <button type="button" class="btn btn-simple btn-danger" onclick="cerrarModalPropuestas(${statusPreproceso}, ${flagFusion});">Cancelar</button>
                    ${botonAceptar}
                </div>
            </div>
        </div>
    </form>
    `);

    const config = (statusPreproceso == 1)
        ? { backdrop: 'static', keyboard: false, show: true }
        : { backdrop: true, keyboard: true, show: true };

    showModal();
    changeOptionsModal(config);
    getProyectosAOcupar(idProyecto, superficie, flagFusion);
    getPropuestas(idLoteOriginal, statusPreproceso, idProyecto, superficie, flagFusion);
});

const cerrarModalPropuestas = async (preproceso, flagFusion) => {
    if (preproceso != 1) {
        hideModal();
        return;
    }
    if(flagFusion == 1){
        let sumSuperficieD = 0;
        const idLoteOriginal = $("#idLoteOriginal").val();
        const superficieFusion = parseFloat($('#superficie').val());
        const dataFusionDes = await totalSuperficieFusion(idLoteOriginal, 0);
        //AA: Obtenemos la superfice destino de la fusión.
        dataFusionDes.data.forEach((fusionLotes) => {
            sumSuperficieD = sumSuperficieD + parseFloat(fusionLotes.sup);
        });
        if(!validarSuperficiesFusion(sumSuperficieD, superficieFusion)){
            return;
        }
        hideModal();
    }
    else if (validarLotesRequeridos($('#infoLotesSeleccionados .lotePropuesto').length)) {
        hideModal();
    }
}

$(document).on('click', '.btn-informacion-cliente', async function (){
    $('#ineCLi').val('');
    $("#estadoCli").empty();

    const idCliente = $(this).attr('data-idCliente');
    const idLote = $(this).attr('data-idLote');
    const idStatusLote = $(this).attr('data-idStatusLote');

    $("#spiner-loader").removeClass('hide');

    copropietariosEliminar = [];
    estadoCivilList = await obtenerEstadoCivilLista();

    $.getJSON(`${general_base_url}Reestructura/getCliente/${idCliente}/${idLote}`, function(cliente) {
        const nombreLote = cliente.nombre;
        const apePaterno = cliente.apellido_paterno;
        const apeMaterno = cliente.apellido_materno;
        const telefono = cliente.telefono1;
        const correo = cliente.correo;
        const domicilio = cliente.domicilio_particular;
        const ocupacion= cliente.ocupacion;
        const ine = cliente.ine;

        changeSizeModal('modal-md');
        appendBodyModal(`
                <form method="post" id="formInfoCliente" class="scroll-styles" style="max-height:500px; padding:0 20px; overflow:auto">
                    <div class="modal-header">
                        <h4 class="modal-title text-center">Corrobora la información del cliente</h4>
                    </div>	
                    <div class="modal-body p-0">
                        <div class="container-fluid">
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
                                    <input class="form-control input-gral" name="correoCli" id="correoCli" oninput= "validarCorreo('#correoCli', '#result')" type="email" value="${correo}" required/>
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
                                    <label class="control-label">INE/Pasaporte (<small style="color: red;">*</small>)</label>
                                    <input class="form-control input-gral" name="ineCLi" id="ineCLi" type="text" value="${ine}" required/>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 m.0">
                                    <label class="control-label">Ocupación (<small style="color: red;">*</small>)</label>
                                    <input class="form-control input-gral" name="ocupacionCli" id="ocupacionCli" type="text" value="${ocupacion}" required/>
                                </div>
                            </div>        
                            <input type="hidden" name="idCliente" id="idCliente" value="${idCliente}">
                            <input type="hidden" name="idLote" id="idLote" value="${idLote}">
                            <input type="hidden" name="idStatusLote" id="idStatusLote" value="${idStatusLote}">
                            
                            <!-- COPROPIETARIOS -->
                            <div class="row mt-3">
                                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7"></div>
                                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                    <button type="button" onclick="agregarCopropietario()" class="" style="width: 100%; color: green; background-color: #00800024; border: none; border-radius: 25px; font-size: 13px; padding: 10px 5px;">AGREGAR COPROPIETARIO</button>
                                </div>
                                <form id="formCopropietarios">
                                    <div class="container-fluid" id="copropietariosDiv"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple"  onclick="hideModal()">Cancelar</button>
                        <button type="button" id="guardarCliente" name="guardarCliente" class="btn btn-primary guardarValidacion">GUARDAR</button>
                    </div>
                </form>`);

        cliente.copropietarios.forEach(agregarCopropietario);

        estadoCivilList.forEach((estadoCivil) => {
            const id = estadoCivil.id_opcion;
            const name = estadoCivil.nombre;

            if (id === cliente.idEstadoC){
                $("#estadoCli").append($('<option selected>').val(id).text(name.toUpperCase()));
            } else {
                $("#estadoCli").append($('<option>').val(id).text(name.toUpperCase()));
            }
        });
        $("#estadoCli").selectpicker('refresh');

        showModal();

        $('[data-toggle="tooltip"]').tooltip();

        $("#spiner-loader").addClass('hide');

    }, 'json');
});

const validateEmail = (email) => {
    return email.match(
        /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );
}

const validarCorreo = (idCorreoInput, idMsgLbl) => {
    const $result = $(idMsgLbl);
    const email = $(idCorreoInput).val();
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
    const idLote = $('#idLote').val();
    const telefonoCli = $('#telefonoCli').val();
    const correoCli = $('#correoCli').val();
    const domicilioCli = $('#domicilioCli').val();
    const ineCLi = $('#ineCLi').val();
    const ocupacionCli = $('#ocupacionCli').val();

    if(ineCLi == '' || telefonoCli == '' || telefonoCli == null || correoCli == '' || correoCli == null || domicilioCli == '' || domicilioCli == null || ocupacionCli == '' || ocupacionCli == null){
        alerts.showNotification("top", "right", "Asegúrate de llenar todos los campos requeridos (*).", "warning");
        return;
    }

    if (
        !validateInputArray('nombre[]') ||
        !validateInputArray('apellido_p[]') ||
        !validateInputArray('apellido_m[]') ||
        !validateInputArray('telefono2[]') ||
        !validateInputArray('correo[]') ||
        !validateInputArray('identificacion[]') ||
        !validateInputArray('domicilio[]') ||
        !validateInputArray('estado_civil[]') ||
        !validateInputArray('ocupacion[]')
    ) {
        alerts.showNotification("top", "right", "Asegúrate de llenar todos los campos requeridos (*) para los copropietarios.", "warning");
        return;
    }

    if (!validarCorreoInputArray('correo[]')) {
        alerts.showNotification("top", "right", "Los correos de los copropietarios deben tener el formato correcto", "warning");
        return;
    }

    let datos = new FormData($("#formInfoCliente")[0]);

    $('#formCopropietarios').serializeArray().forEach(({name, value}) => {
        datos.append(name, value);
    });
    datos.append('id_cop_eliminar', copropietariosEliminar.join());

    $("#spiner-loader").removeClass('hide');

    $.ajax({
        method: 'POST',
        url: general_base_url + 'Reestructura/insertarInformacionCli/'+ idLote,
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
    const idLoteOriginal = row.data().idLote;
    const statusPreproceso = $(this).attr("data-statusPreproceso");
    const idCliente = $(this).attr("data-idCliente");

    changeSizeModal('modal-md');
    appendBodyModal(`
        <form method="post" id="formReubicacion">
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
                <input type="hidden" id="idLoteOriginal" name="idLoteOriginal" value="${idLoteOriginal}">
                <input type="hidden" id="idCliente" name="idCliente" value="${idCliente}">
                <input type="hidden" id="statusPreproceso" name="statusPreproceso" value="${statusPreproceso}">
                <input type="hidden" id="idProyecto" name="idProyecto" value="${idProyecto}">
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

function getProyectosAOcupar(idProyecto, superficie, flagFusion) {
    $('#spiner-loader').removeClass('hide');
    $('#proyectoAOcupar').html("").selectpicker('refresh');
    $("#condominioAOcupar").html("").selectpicker('refresh');
    $("#loteAOcupar").html("").selectpicker('refresh');

    $.post("getProyectosDisponibles", {"idProyecto" : idProyecto, "superficie" : superficie, "flagFusion":flagFusion}, function(data) {
        const len = data.length;
        for (let i = 0; i < len; i++) {
            const id = data[i]['proyectoReubicacion'];
            const name = data[i]['descripcion'];
            const disponible = data[i]['disponibles'];
            $("#proyectoAOcupar").append($('<option>').val(id).text(name +' ('+ disponible + ')'));
        }
        $('#spiner-loader').addClass('hide');
        $("#proyectoAOcupar").selectpicker('refresh');
    }, 'json');
}

function getPropuestas(idLoteOriginal, statusPreproceso, idProyecto, superficie, flagFusion){
    $('#spiner-loader').removeClass('hide');
    $.post("obtenerPropuestasXLote", {"idLoteOriginal" : idLoteOriginal, "flagFusion": flagFusion}, function(data) {
        $('#infoLotesSeleccionados').html('');

        for (let lote of data) {
            let html = divLotesSeleccionados(statusPreproceso, lote.nombreLote, lote.sup, lote.id_lotep, lote.id_pxl, idProyecto, superficie, lote.idCondominio, lote.tipo_estatus_regreso, flagFusion);

            $("#infoLotesSeleccionados").append(html);
        }
        $('#spiner-loader').addClass('hide');
    }, 'json');
}

$(document).on("change", "#proyectoAOcupar", function(e){
    $('#spiner-loader').removeClass('hide');
    $("#condominioAOcupar").html("");
    $("#loteAOcupar").html("").selectpicker('refresh');

    const idProyecto = $(this).val();
    const superficie = $("#superficie").val();
    const flagFusion = $("#flagFusion").val();

    $.post("getCondominiosDisponibles", {"idProyecto": idProyecto, "superficie": superficie, "flagFusion": flagFusion}, function(data) {
        const len = data.length;
        for (let i = 0; i < len; i++) {
            const id = data[i]['idCondominio'];
            const name = data[i]['nombre'];
            const disponible = data[i]['disponibles'];
            $("#condominioAOcupar").append($('<option>').val(id).text(name +' ('+ disponible + ')'));
        }
        $('#spiner-loader').addClass('hide');
        $("#condominioAOcupar").selectpicker('refresh');
    }, 'json');
});

$(document).on("change", "#condominioAOcupar", function(e){
    $('#spiner-loader').removeClass('hide');
    $("#loteAOcupar").html("");
    const idCondominio = $(this).val();
    const superficie = $("#superficie").val();
    const flagFusion = $("#flagFusion").val();

    $.post("getLotesDisponibles", {"idCondominio": idCondominio, "superficie": superficie, "flagFusion":flagFusion}, function(data) {
        const len = data.length;
        for (let i = 0; i < len; i++) {
            const id = data[i]['idLote'];
            const name = data[i]['nombreLote'];
            const precioMetro = data[i]['precio'];
            const superficie = data[i]['sup'];
            const total = data[i]['total'];
            const a_favor = data[i]['a_favor'];
            const tipoEstatusRegreso = data[i]['tipo_estatus_regreso'];
            $("#loteAOcupar")
                .append($('<option>')
                .val(id)
                .attr('data-nombre', name)
                .attr('data-precioMetro', precioMetro)
                .attr('data-superficie', superficie)
                .attr('data-total', total)
                .attr('data-tipo_estatus_regreso', tipoEstatusRegreso)
                .text(name +' ('+ a_favor + ')'));
        }
        $('#spiner-loader').addClass('hide');
        $("#loteAOcupar").selectpicker('refresh');
    }, 'json');
});

$(document).on("change", "#loteAOcupar", function(e){
    const $itself = $("#loteAOcupar").find(':selected');
    const statusPreproceso = $(this).attr("data-statusPreproceso");
    let flagFusion = $('#flagFusion').val();
    let numeroMaximoLotes = (flagFusion==1) ? 1000 : 2;

    if ($itself.val() === '') {
        alerts.showNotification("top", "right", "Debe seleccionar un lote", "danger");
        return;
    }

    const numberLotes = $('#infoLotesSeleccionados .lotePropuesto').length;
    const idLotes = document.getElementsByClassName('idLotes');
    let existe = false;
    for (let idLote of idLotes) {
        if(idLote.value == $itself.val()){
            existe = true;
        }
    }

    if(existe){
        alerts.showNotification("top", "right", "El lote ya ha sido agregado", "danger");
        return;
    }

    if (numberLotes > numeroMaximoLotes) {
        alerts.showNotification("top", "right", "No puedes seleccionar más de tres lotes", "danger");
        return;
    }

    const idLoteSeleccionado = $itself.val();
    const idLoteOriginal = $(this).attr('data-idLoteOriginal');
    const idProyecto = $(this).attr("data-idProyecto");
    const superficieLoteOriginal = $(this).attr('data-superficie');
    const tipoEstatusRegreso = $(this).attr("data-tipo_estatus_regreso");
    // let sumatoriaLS = 0; //lotes seleccionados(propuestas)

    if (statusPreproceso != 1) {
        const nombreLote = $itself.attr("data-nombre");
        const superficie = parseFloat($itself.attr("data-superficie"));
        sumatoriaLS = sumatoriaLS + superficie;
        const html = divLotesSeleccionados(statusPreproceso, nombreLote, superficie, idLoteSeleccionado, tipoEstatusRegreso);
        $("#infoLotesSeleccionados").append(html);
        getProyectosAOcupar(idProyecto, superficieLoteOriginal, flagFusion);
        return;
    }
    $.post(`${general_base_url}Reestructura/agregarLotePropuesta`, {idLoteOriginal, idLotePropuesta: idLoteSeleccionado, flagFusion}, (data) => {
        const response = JSON.parse(data);
        if (response.code === 200) {
            getPropuestas(idLoteOriginal, statusPreproceso, idProyecto, superficieLoteOriginal, flagFusion);
            getProyectosAOcupar(idProyecto, superficieLoteOriginal, flagFusion);

            alerts.showNotification("top", "right", 'Lote agregado con éxito', 'success');
        }
        if (response.code === 400) {
            alerts.showNotification("top", "right", response.message, 'warning');
        }
        if (response.code === 500) {
            alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
        }
    });
})

function removeLote(e, idLote, statusPreproceso, id_pxl, idProyecto, superficie, tipoEstatusRegreso, tipoProceso, flagFusion) {
    if (statusPreproceso != 1 && tipoProceso != 3) { // SON LOTES QUE ELIMINA CUANDO ES LA PRIMERA VEZ QUE ASIGNA PROPUESTAS
        let divLote = e.closest( '.lotePropuesto' );
        divLote.remove();
        return;
    }

    // REVISIÓN DE PROPUESTAS (YA ESTÁN EN LA BASE DE DATOS)
    $('#spiner-loader').removeClass('hide');
    let data = new FormData();
    data.append("idLote", idLote);
    data.append("id_pxl", id_pxl);
    data.append("tipoEstatusRegreso", tipoEstatusRegreso);
    data.append("tipoProceso", tipoProceso);
    data.append("flagFusion", flagFusion);
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
                // SE VUELVE A LLENAR SELECT PARA REFRESCAR OPCIONES
                if (tipoProceso == TIPO_PROCESO.REUBICACION){
                    getProyectosAOcupar(idProyecto, superficie, flagFusion);
                    let divLote = e.closest( '.lotePropuesto' );
                    divLote.remove();  }
                else{
                    $('#reubicacionClientes').DataTable().ajax.reload();
                    hideModal();
                }
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

function divLotesSeleccionados(statusPreproceso, nombreLote, superficie, idLote, id_pxl = null, idProyecto = null, superficieAnterior = null, idCondominio=null, tipoEstatusRegreso = null, flagFusion=null){
    if (statusPreproceso == 0 || statusPreproceso == 1 ){
        return `
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 mt-2 lotePropuesto">
                <div class="p-2 pt-1" style="background-color: #eaeaea; border-radius:15px">
                    <div class="d-flex justify-between">
                        <h5 class="mb-0 mt-2 text-center">LOTE SELECCIONADO</h5>
                        <button type="button" class="fl-r" onclick="removeLote(this, ${idLote}, ${statusPreproceso}, ${id_pxl}, ${idProyecto}, ${superficieAnterior}, ${tipoEstatusRegreso}, ${TIPO_PROCESO.REUBICACION}, ${flagFusion})" style="color: gray; background-color:transparent; border:none;" title="Eliminar selección"><i class="fas fa-times"></i></button>
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
        return `
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 mt-2 lotePropuesto">
                <div class="" id="checkDS">
                    <div class="container boxChecks p-0">
                        <label class="m-0 checkstyleDS">
                            <input type="radio" name="idLote" id="idLote" value="${idLote}">
                            
                            <span class="w-100 d-flex justify-between">
                                <p class="m-0">Lote <b>${nombreLote}</b></p>
                            </span>
                            <span class="w-100 d-flex justify-between">
                                <p class="m-0">Superficie <b>${superficie}</b></p>
                            </span>
                        </label>
                    </div>
                </div>
            </div>
        `;
    }
}

$(document).on("submit", "#formReubicacion", function(e){
    e.preventDefault();
    const existeSeleccion = $(this).serializeArray().find(obj => obj.name === 'idLote');

    if (!existeSeleccion) {
        alerts.showNotification("top", "right", "Debe seleccionar un lote para la reubicación.", "warning");
        return;
    }

    let data = new FormData($(this)[0]);
    $('#spiner-loader').removeClass('hide');

    $.ajax({
        url : 'setReubicacion',
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

$(document).on("submit", "#formAsignarPropuestaRees", function(e){
    e.preventDefault();

    $('#spiner-loader').removeClass('hide');
    let data = new FormData($(this)[0]);
    //Identificamos si es reestructura
    data.append("proceso", TIPO_PROCESO.REESTRUCTURA);
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
    let flagFusion= parseInt($('#flagFusion').val());
    let superficieFusion = parseFloat($('#superficie').val());
    let superficiePropuestas = sumatoriaLS;
    if(flagFusion == 1){
        if(!validarSuperficiesFusion(superficiePropuestas, superficieFusion)){
            return;
        }
    }

    if (!validarLotesRequeridos($('#infoLotesSeleccionados .lotePropuesto').length)) {
        return;
    }

    $('#spiner-loader').removeClass('hide');
    let data = new FormData($(this)[0]);
    data.append("proceso", TIPO_PROCESO.REUBICACION);
    data.append("flagFusion", flagFusion);
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

$(document).on('click', '.btn-avanzar', async function () {
    const tr = $(this).closest('tr');
    const row = $('#reubicacionClientes').DataTable().row(tr);
    let nombreLote='';
    let pluralidad=' EL LOTE ';
    const idLote = row.data().idLote;
    const tipoTransaccion = $(this).attr("data-tipoTransaccion");
    const idCliente = $(this).attr("data-idCliente");
    const idEstatusMovimento = $(this).attr("data-idEstatusMovimiento");
    let sumSuperficieD = 0;
    let sumSuperficieO = 0;
    let flagFusionRev = $(this).attr('data-fusion');


    if (tipoTransaccion == 1) {
        if(flagFusionRev == 1){
            const dataFusionDes = await totalSuperficieFusion(idLote, 3);
            //AA: Obtenemos la superfices de origen y destino de la fusión.
            let separador=', ';
            dataFusionDes.data.forEach((fusionLotes, index) => {
                separador = (index==0) ? '' : ', ';
                if(fusionLotes.origen == 1){
                    sumSuperficieO = sumSuperficieO + parseFloat(fusionLotes.sup);
                    nombreLote += separador+fusionLotes.nombreLotes;
                }
                else{
                    sumSuperficieD = sumSuperficieD + parseFloat(fusionLotes.sup);
                }
            });
            pluralidad = ' LOS LOTES ';
            if (!validarSuperficiesFusion(sumSuperficieD,sumSuperficieO)) {
                return;
            }
        }
        else{
            const totalP = await totalPropuestas(idLote, flagFusionRev);
            if (!validarLotesRequeridos(totalP)) {
                return;
            }
            nombreLote = row.data().nombreLote;
        }   
    }



    changeSizeModal('modal-sm');
    appendBodyModal(`
        <form method="post" id="formAvanzarEstatus">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 text-center">
                        <h6 class="m-0">¿Estás seguro de envíar ${pluralidad} <b>${nombreLote}</b> a <b><i>${ESTATUS_PREPROCESO[parseInt(tipoTransaccion) + 1]}</i></b></h6>
                    </div>
                    <div class="col-12">
                        <label class="control-label">Comentario</label>
                        <input class="text-modal mb-1" name="comentario" autocomplete="off">
                    </div>

                    <input type="hidden" id="idLote" name="idLote" value="${idLote}">
                    <input type="hidden" id="tipoTransaccion" name="tipoTransaccion" value="${tipoTransaccion}">
                    <input type="hidden" name="idCliente" value="${idCliente}">
                    <input type="hidden" name="idEstatusMovimento" value="${idEstatusMovimento}">
                    <input type="hidden" name="flagFusion" value="${flagFusionRev}">
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

$(document).on('click', '.btn-rechazar', function () {
    const tr = $(this).closest('tr');
    const row = $('#reubicacionClientes').DataTable().row(tr);
    const nombreLote = row.data().nombreLote;
    const idLote = row.data().idLote;
    const tipoTransaccion = $(this).attr("data-tipoTransaccion");
    const idCliente = $(this).attr("data-idCliente");
    let flagFusion = $(this).attr("data-fusion");

    changeSizeModal('modal-sm');
    appendBodyModal(`
        <form method="post" id="formRechazarEstatus">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 text-center">
                        <h6 class="m-0">¿Estás seguro de rechazar el lote <b>${nombreLote}</b> a <b><i>${ESTATUS_PREPROCESO[parseInt(tipoTransaccion) -1]}</i></b></h6>
                    </div>
                    <div class="col-12">
                        <label class="control-label">Comentario</label>
                        <input class="text-modal mb-1" name="comentario" autocomplete="off">
                    </div>

                    <input type="hidden" id="idLote" name="idLote" value="${idLote}">
                    <input type="hidden" id="tipoTransaccion" name="tipoTransaccion" value="${tipoTransaccion}">
                    <input type="hidden" name="idCliente" value="${idCliente}">
                    <input type="hidden" name="flagFusion" value="${flagFusion}">
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

const totalSuperficieFusion  = async (idLoteOriginal, tipoOrigenDestino) => {
    return new Promise((resolve) => {
        $('#spiner-loader').removeClass('hide');
        $.post(`${general_base_url}Reestructura/getFusion`, {idLote: idLoteOriginal, tipoOrigenDestino: tipoOrigenDestino}, (data) => {
            $("#spiner-loader").addClass('hide');
            const response = JSON.parse(data);
            resolve(response);
        });
    });
}

const totalPropuestas = async (idLoteOriginal, flagFusion) => {
    return new Promise((resolve) => {
        $('#spiner-loader').removeClass('hide');
        $.getJSON(`${general_base_url}Reestructura/totalPropuestas/${idLoteOriginal}/${flagFusion}`, (data) => {
            $('#spiner-loader').addClass('hide');
            resolve(data);
        });
    });
}

$(document).on("submit", "#formAvanzarEstatus", function(e) {
    $('#spiner-loader').removeClass('hide');
    e.preventDefault();

    let data = new FormData($(this)[0]);
    $.ajax({
        url : 'setAvance',
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

$(document).on("submit", "#formRechazarEstatus", function(e) {
    e.preventDefault();

    $('#spiner-loader').removeClass('hide');
    let data = new FormData($(this)[0]);
    $.ajax({
        url : `${general_base_url}Reestructura/rechazarRegistro`,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(data){
            alerts.showNotification("top", "right", "El registro se ha rechazado con éxito.", "success");
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

/**
 * @return {boolean}
 */
const validarLotesRequeridos = (numberLotes) => {
    let flagFusion = parseInt($('#flagFusion').val());
    let numeroMaxLotes;
    if(flagFusion == 1){
        numeroMaxLotes = 100;
    }else{
        numeroMaxLotes = 3;
    }
    if (numberLotes === 0) {
        alerts.showNotification("top", "right", "Debes seleccionar al menos un lote", "warning");
        return false;
    }
    if(numberLotes > numeroMaxLotes){
        alerts.showNotification("top", "right", "Debes seleccionar máximo 3 lotes", "warning");
        return false;
    }
    return true;
}

const validarSuperficiesFusion = (superficiePropuestas,superficieFusion ) => {
    if(superficiePropuestas < superficieFusion){
        alerts.showNotification('top', 'right', 'La sumatoria de superficie de los lotes propuesta (<b>'+(superficiePropuestas).toFixed(2)+'</b>) es menor al total de ' +
            'superficie de los lotes fusionados (<b>'+superficieFusion+'</b>)', 'danger');
        return false;
    }
    else{
        return true;
    }
}

const botonesAccionReubicacion = (d) => {
    const FLAGPROCESOCONTRALORIA = parseInt(d.flagProcesoContraloria);
    const FLAGPROCESOJURIDICO = parseInt(d.flagProcesoJuridico);
    const banderaFusion = (d.idLotePvOrigen != 0 && d.idLotePvOrigen != null) ? 1 : 0;
    const idEstatusPreproceso = parseInt(d.id_estatus_preproceso);
    const totalCorridas = parseInt(banderaFusion == 0 ? d.totalCorridas : (d.idLotePvOrigen!=d.idLote ? d.totalCorridas : d.totalCorridaFusion));
    const totalContrato = parseInt(banderaFusion == 0 ? d.totalContratos : (d.idLotePvOrigen!=d.idLote ? d.totalContratos : d.totalContratosFusion));
    const totalCorridasRef = parseInt(banderaFusion == 0 ? d.totalCorridasNumero : (d.idLotePvOrigen!=d.idLote ? d.totalCorridasNumero : d.totalCorridasFusionNumero));
    const totalContratoRef = parseInt(banderaFusion == 0 ? d.totalContratoNumero : (d.idLotePvOrigen!=d.idLote ? d.totalContratoNumero : d.totalContratoNumero));
    const totalContratoFirmado = parseInt( banderaFusion == 1 ? d.totalContratoFirmadoFusion : d.totalContratoFirmado);
    let editar = 0;
    let btnShow = 'fa-upload';
    let btnContratoFirmado = 'fa-file-upload';
    let editarContratoFirmado = 0;
    let tooltipCF = 'SUBIR CONTRATO FIRMADO';
    let botonJuridico = '';
    let botonFusionadoEstatus = banderaFusion == 0 ? '' : (d.idLotePvOrigen!=d.idLote ? 'disabled=false' : '');
    let flagFusion = (d.idLotePvOrigen != 0 && d.idLotePvOrigen != null) ? 1 : 0;


    /*if(d.idLotePvOrigen!=null){
        //valores para lotes fusionados
        if(d.idLotePvOrigen!=d.idLote){//si no es el lote pivote se le deshabilitan las opciones
           // botonFusionadoEstatus = "disabled=false";
            totalCorridas = parseInt(d.totalCorridas);
            totalContrato = parseInt(d.totalContratos);
            totalCorridasRef = parseInt(d.totalCorridasNumero);
            totalContratoRef = parseInt(d.totalContratoNumero);
        }else{
            //si es el pivote se le dejan las opciones
            //botonFusionadoEstatus = "";
            flagFusion = 1;
            totalCorridas = parseInt(d.totalCorridaFusion);
            totalContrato = parseInt(d.totalContratosFusion);
            totalCorridasRef = parseInt(d.totalCorridasFusionNumero);
            totalContratoRef = parseInt(d.totalContratoNumero);
        }
    }else{
        //se le asignan las variables a los lotes con proceso normal (SIN FUSION)
        //botonFusionadoEstatus = "";
        totalCorridas = parseInt(d.totalCorridas);
        totalContrato = parseInt(d.totalContratos);
        totalCorridasRef = parseInt(d.totalCorridasNumero);
        totalContratoRef = parseInt(d.totalContratoNumero);
    }*/


    if (idEstatusPreproceso === 2 && totalCorridas === totalCorridasRef && FLAGPROCESOCONTRALORIA === 0) { //subiendo corridas //&& FLAGPROCESOCONTRALORIA === 0 //aun no es el cambio final se comenta para seguir con el proceso
        editar = 1;
        btnShow = 'fa-edit';
    }

    if (idEstatusPreproceso === 2 && totalContrato === totalContratoRef && FLAGPROCESOJURIDICO === 0) { //subiendo contratos //&& FLAGPROCESOJURIDICO === 0  //aun no es el cambio final se comenta para seguir con el proceso
        editar = 1;
        btnShow = 'fa-edit';
        btnContratoFirmado = 'fa-eye';
        tooltipCF = 'VER CONTRATO FIRMADO';
    }
    if(d.idContratoFirmado != null){
        btnContratoFirmado = 'fa-eye';
        editarContratoFirmado = 1;
        tooltipCF = 'VER CONTRATO FIRMADO';
    }


    const BTN_PROPUESTAS =  `<button class="btn-data btn-blueMaderas btn-asignar-propuestas"
                            data-toggle="tooltip" 
                            data-placement="left"
                            title="${idEstatusPreproceso === 0 ? 'ASIGNAR PROPUESTAS' : 'ACTUALIZAR PROPUESTAS'}"
                            data-idCliente="${d.idCliente}"
                            data-idProyecto="${d.idProyecto}"
                            data-statusPreproceso="${idEstatusPreproceso}"
                            data-idEstatusMovimiento="${d.id_estatus_modificacion}"
                            ${botonFusionadoEstatus}
                            data-fusion="${flagFusion}"
                            >
                            <i class="fas fa-clipboard-list"></i>
                    </button>`;
    const BTN_PROPUESTAS_REES =  `<button class="btn-data btn-violetDeep btn-asignar-propuestas-rees"
                            data-toggle="tooltip" 
                            data-placement="left"
                            title="${idEstatusPreproceso === 0 ? 'ASIGNAR REESTRUCTURA' : 'REGRESAR A ASIGNACIÓN DE REESTRUCTURA'}"
                            data-idCliente="${d.idCliente}" 
                            data-idProyecto="${d.idProyecto}"
                            data-statusPreproceso="${idEstatusPreproceso}"
                            data-idEstatusMovimiento="${d.id_estatus_modificacion}"
                            data-tipoEstatusRegreso="${d.tipo_estatus_regreso}">
                            ${idEstatusPreproceso === 0 ? '<i class="fas fa-map-marker"></i>': '<i class="fas fa-undo"></i>'}
                            
                        </button>`;

    const BTN_AVANCE =  `<button class="btn-data btn-green btn-avanzar"
                    data-toggle="tooltip" 
                    data-placement="left"
                    title="ENVIAR A ${ESTATUS_PREPROCESO[idEstatusPreproceso + 1]}"
                    data-idCliente="${d.idCliente}"
                    data-tipoTransaccion="${idEstatusPreproceso}"
                    data-idEstatusMovimiento="${d.id_estatus_modificacion}"
                    data-fusion="${flagFusion}">
                    <i class="fas fa-thumbs-up"></i>
                </button>`;

    const BTN_RECHAZO =  `<button class="btn-data btn-warning btn-rechazar"
                    data-toggle="tooltip" 
                    data-placement="left"
                    title="ENVIAR A ${ESTATUS_PREPROCESO[idEstatusPreproceso - 1]}"
                    data-idCliente="${d.idCliente}"
                    data-tipoTransaccion="${idEstatusPreproceso}"
                    ${botonFusionadoEstatus}
                    data-fusion="${flagFusion}">
                    <i class="fas fa-thumbs-down"></i>
                </button>`;

    const BTN_INFOCLIENTE =  `<button class="btn-data btn-green btn-informacion-cliente"
                    data-toggle="tooltip" 
                    data-placement="left"
                    title="INFORMACIÓN CLIENTE"
                    data-idCliente="${d.idCliente}" 
                    data-idLote="${d.idLote}"
                    ${botonFusionadoEstatus}
                    data-idStatusLote="${d.idStatusLote == 17 ? 17 : 16}">
                    <i class="fas fa-user-check"></i>
                </button>`;
    const BTN_SUBIR_ARCHIVO =  `<button class="btn-data btn-blueMaderas btn-abrir-modal"
                    data-toggle="tooltip" 
                    data-placement="left"
                    title="CARGAR DOCUMENTACIÓN"
                    data-idCliente="${d.idCliente}"
                    data-idLote="${d.idLote}"
                    data-nombreLote="${d.nombreLote}"
                    data-estatusLoteArchivo="${d.status}"
                    data-banderaFusion="${(d.idLotePvOrigen != 0 && d.idLotePvOrigen != null) ? d.idLotePvOrigen : 0}"
                    data-flagProcesoContraloria="${d.flagProcesoContraloria}"
                    data-flagProcesoJuridico="${d.flagProcesoJuridico}"
                    data-editar="${editar}"   
                    data-rescision="${(d.idLotePvOrigen != 0 && d.idLotePvOrigen != null) ? d.rescision : d.rescisioncl}"
                    data-id_dxc="${d.id_dxc}"   
                    data-tipoTransaccion="${idEstatusPreproceso}"
                    ${botonFusionadoEstatus}
                    data-fusion="${flagFusion}">
                    <i class="fas ${btnShow}"></i>
                </button>`;
    const BTN_REESTRUCTURA = `<button class="btn-data btn-green btn-reestructurar"
                    data-toggle="tooltip" 
                    data-placement="left"
                    title="REESTRUCTURAR"
                    data-idCliente="${d.idCliente}">
                    <i class="fas fa-map-marker"></i>
                </button>`;
    const BTN_REUBICACION = `
        <button class="btn-data btn-sky btn-reubicar"
                data-toggle="tooltip" 
                data-placement="left"
                title="REUBICAR CLIENTE"
                data-idCliente="${d.idCliente}"
                data-idProyecto="${d.idProyecto}"
                data-statusPreproceso="${idEstatusPreproceso}">
            <i class="fas fa-route"></i>
        </button>`;

    const BTN_SUBIR_CONTRATO_FIRMADO =  `
        <button class="btn-data btn-green-excel btn-abrir-contratoFirmado"
            data-toggle="tooltip" 
            data-placement="left"
            title="${tooltipCF}"
            data-idCliente="${d.idCliente}"
            data-idLote="${d.idLote}"
            data-nombreLote="${d.nombreLote}"
            data-estatusLoteArchivo="${d.status}"
            data-editar="${editarContratoFirmado}"   
            data-rescision="${(d.idLotePvOrigen != 0 && d.idLotePvOrigen != null) ? d.rescision : d.rescisioncl}"
            data-idDocumento="${d.idContratoFirmado}"   
            data-idCondominio="${d.idCondominio}"   
            data-tipoTransaccion="${d.id_estatus_preproceso}"
            data-nombreResidencial = "${d.nombreResidencial}"
            data-nombreCondominio = "${d.nombreCondominio}"
            data-contratoFirmado = "${d.contratoFirmado}">
            <i class="fas ${btnContratoFirmado}"></i>
        </button>`;

    const BTN_REASIGNAR_EXPEDIENTE_JURIDICO =  `<button class="btn-data btn-green btn-reasignar"
            data-toggle="tooltip" 
            data-placement="left"
            title="REASIGNAR EXPEDIENTE"
            data-idLote="${d.idLote}"
            data-idEjecutivoAsignado="${d.id_juridico_preproceso}">
            <i class="fas fa-user-alt"></i>
        </button>`;

        // BOTÓN QUE ABRIRÁ MODAL PARA CAPTURAR / EDITAR LA CANTIDAD TRASPASADA (ES PARA ADMINISTRACIÓN)
        const BTN_TRASPASO_RECURSO =  `<button class="btn-data btn-blueMaderas btn-traspaso"
        data-toggle="tooltip" 
        data-placement="left"
        title="Confirmar traspaso / Editar cantidad traspasada"
        data-idLote="${d.idLote}"
        data-cantidadTraspaso="${d.cantidadTraspaso}"
        data-comentarioTraspaso="${d.comentarioTraspaso}">
        <i class="fas fa-money-check-alt"></i>
    </button>`;

    if (idEstatusPreproceso === 0 && ROLES_PROPUESTAS.includes(id_rol_general)) // Gerente / Subdirector: PENDIENTE CARGA DE PROPUESTAS
        return (d.idProyecto == PROYECTO.NORTE || d.idProyecto == PROYECTO.PRIVADAPENINSULA) ? BTN_PROPUESTAS_REES + BTN_PROPUESTAS : BTN_PROPUESTAS;
    if (idEstatusPreproceso === 1 && ROLES_PROPUESTAS.includes(id_rol_general)) { // Gerente/Subdirector: REVISIÓN DE PROPUESTAS
        if (d.idLoteXcliente == null && d.idStatusLote != 17)
            return BTN_PROPUESTAS + BTN_INFOCLIENTE;
        else if (d.idLoteXcliente == null && d.idStatusLote == 17)
            return BTN_INFOCLIENTE;
        else if (d.idLoteXcliente != null && d.idStatusLote != 17)
            return BTN_PROPUESTAS + BTN_AVANCE + BTN_INFOCLIENTE;
        else
            return BTN_AVANCE + BTN_INFOCLIENTE;
    }
    if (idEstatusPreproceso === 1 && id_rol_general == 7){ // EEC: Ver/Editar la información del cliente
        return BTN_INFOCLIENTE;
    }

    if (idEstatusPreproceso === 2 && id_rol_general == 17 && FLAGPROCESOCONTRALORIA === 0) { // Contraloría: ELABORACIÓN DE CORRIDAS
        if(flagFusion==1){
            //en la segunda validacion se ocupa "totalCorridasRef" ya que trae el numero de corridas que debe haber(el mismo número que los contratos
            //firmados que debe de haber
            return (totalCorridas === totalCorridasRef && d.totalContratoFirmadoFusionNumero===d.totalContratoFirmadoFusion )
                ? BTN_AVANCE + BTN_RECHAZO + BTN_SUBIR_ARCHIVO + BTN_SUBIR_CONTRATO_FIRMADO
                : BTN_SUBIR_ARCHIVO + BTN_RECHAZO + BTN_SUBIR_CONTRATO_FIRMADO;
        }else{
            return (totalCorridas === totalCorridasRef && totalContratoFirmado==1)
                ? BTN_AVANCE + BTN_RECHAZO + BTN_SUBIR_ARCHIVO + BTN_SUBIR_CONTRATO_FIRMADO
                : BTN_SUBIR_ARCHIVO + BTN_RECHAZO + BTN_SUBIR_CONTRATO_FIRMADO;
        }

    }
    if (idEstatusPreproceso === 2 && id_rol_general == 15 && id_usuario_general != 13733 && FLAGPROCESOJURIDICO === 0) { // Jurídico: ELABORACIÓN DE CONTRATO Y RESICISIÓN
        if(totalContratoFirmado==1)
            botonJuridico = BTN_SUBIR_CONTRATO_FIRMADO;
        else
            botonJuridico = '';
        return (totalContrato === totalContratoRef && parseInt(d.totalRescision) === 1) ? BTN_AVANCE + BTN_RECHAZO + BTN_SUBIR_ARCHIVO + botonJuridico : BTN_SUBIR_ARCHIVO + BTN_RECHAZO  + botonJuridico ;
    }
    if (idEstatusPreproceso === 3 && id_rol_general == 6) // Asistente gerente: Recepción de documentación
        return BTN_AVANCE + BTN_RECHAZO;
    if (idEstatusPreproceso === 4 && id_rol_general == 7) // MJ: ASESOR - Obtención de firma del cliente
        return BTN_AVANCE;
    if (idEstatusPreproceso === 5 && id_rol_general == 11) // MJ: ADMINISTRACIÓN - Contrato firmado confirmado, pendiente traspaso de recurso.
    return d.cantidadTraspaso > 0.00 ? BTN_AVANCE + BTN_TRASPASO_RECURSO : BTN_TRASPASO_RECURSO; // SI YA HAY RECURSO SE MUESTRAN AMBOS BOTONES, SINO SÓLO EL DE CAPTURAR LA CANTIDA CORRESPONDIENTE AL TRASPASO
    if (idEstatusPreproceso === 6) // EEC: CONFIRMACIÓN DE RECEPCIÓN DE DOCUMENTOS
        return d.idStatusLote == 17 ? BTN_REESTRUCTURA : BTN_REUBICACION;
    if(id_usuario_general === 13733) // ES EL USUARIO DE CONTROL JURÍDICO PARA REASIGNACIÓN DE EXPEDIENTES
        return BTN_REASIGNAR_EXPEDIENTE_JURIDICO ;
    return '';
}

$(document).on('click', '.btn-reasignar', function () {
    const tr = $(this).closest('tr');
    const row = $('#reubicacionClientes').DataTable().row(tr);
    const idEjecutivoAsignado = $(this).attr("data-idEjecutivoAsignado");
    const idLote = row.data().idLote;
    const nombreLote = row.data().nombreLote;
    $("#id_usuario").val(idEjecutivoAsignado == 0 ? '' : idEjecutivoAsignado).selectpicker('refresh');
    $("#idLote").val(idLote);
    $("#nombreLote").val(nombreLote);
    document.getElementById("mainLabelTextAsignacion").innerHTML = `Asigna un ejecutivo de jurídico para el seguimiento de la venta <b>${nombreLote}</b>`;
    $("#asignacionModal").modal("show");
});

$(document).on("click", "#sendRequestButtonAsignacion", function (e) {
    e.preventDefault();
    const idLote = $("#idLote").val();
    const id_usuario = $("#id_usuario").val();
    const select = document.getElementById("id_usuario");
    const textNombreAsesor = select.options[select.selectedIndex].innerText;
    const nombreLote = $("#nombreLote").val();
    let data = new FormData();
    data.append("idLote", idLote);
    data.append("id_usuario", id_usuario);
    if (id_usuario == '')
        alerts.showNotification("top", "right", `Asegúrate de asignar un ejecutivo de jurídico para continuar con este proceso.`, "warning");
    else {
        $.ajax({
            url: `${general_base_url}Reestructura/setEjecutivoJuridico`,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: "POST",
            success: function (response) {
                $("#sendRequestButton").prop("disabled", false);
                if (response) {
                    alerts.showNotification("top", "right", `El asignación del lote <b>${nombreLote}</b> a <b>${textNombreAsesor}</b> ha sido exitosa.`, "success");
                    $('#reubicacionClientes').DataTable().ajax.reload(null, false);
                    $("#asignacionModal").modal("hide");
                }
                else
                alerts.showNotification("top", "right", "Oops, algo salió mal. Inténtalo más tarde.", "warning");
            },
            error: function () {
                $("#sendRequestButton").prop("disabled", false);
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    }
});

const agregarCopropietario = (copropietario = null) => {
    const idDiv = copropietario?.id_dxcop ?? new Date().getTime();
    const titulo = (copropietario === null) ? 'NUEVO COPROPIETARIO' : 'COPROPIETARIO';
    const idCopropietario = copropietario?.id_dxcop ?? 'Nuevo';

    $('#copropietariosDiv').append(`
        <div class="row" 
            id="copropietarioDiv${idDiv}">
            <div class="col-lg-12">
                <div id="accordion${idDiv}">
                    <div class="card mt-2 mb-0" style="border-radius: 27px!important">
                        <div class="card-header collapsed cursor-point" 
                            id="copropietario-collapse${idDiv}"
                            data-toggle="collapse" 
                            data-target="#copropietarioCollapse${idDiv}" 
                            aria-expanded="false" 
                            aria-controls="collapseTwo">
                            <div class="mb-1">
                                <div class="row">
                                    <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11 text-center">
                                        <span class="fs-2">${titulo}</span>
                                    </div>
                                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 text-right">
                                        <span class="fs-2">
                                            <i onclick="eliminarCopropietario(${idDiv}, '${idCopropietario}')" id="eliminarIcon${idDiv}" class="fa fa-close" data-toggle="tooltip" data-placement="left" title="ELIMINAR COPROPIETARIO"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="copropietarioCollapse${idDiv}" 
                            class="collapse" 
                            aria-labelledby="copropietario-collapse${idDiv}" 
                            data-parent="#accordion${idDiv}">
                            <div class="card-body pb-2">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <label class="control-label">Nombre (<small style="color: red;">*</small>)</label>
                                            <input class="form-control input-gral"
                                                name="nombre[]" 
                                                type="text" 
                                                value="${copropietario?.nombre ?? ''}"
                                                minlength="1"
                                                maxlength="50" 
                                                autocomplete="off"/>
                                            
                                            <input id="id_cop[]" 
                                                name="id_cop[]" 
                                                type="hidden" 
                                                value="${idCopropietario}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <label class="control-label">Apellido paterno (<small style="color: red;">*</small>)</label>
                                            <input class="form-control input-gral"
                                                name="apellido_p[]" 
                                                type="text"
                                                value="${copropietario?.apellido_paterno ?? ''}"
                                                minlength="1"
                                                maxlength="50"
                                                autocomplete="off"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <label class="control-label">Apellido materno (<small style="color: red;">*</small>)</label>
                                            <input class="form-control input-gral"
                                                name="apellido_m[]" 
                                                type="text"
                                                value="${copropietario?.apellido_materno ?? ''}"
                                                minlength="1"
                                                maxlength="50"
                                                autocomplete="off"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                            <label class="control-label">Teléfono (<small style="color: red;">*</small>)</label>
                                            <input class="form-control input-gral" 
                                                name="telefono2[]" 
                                                type="number" 
                                                step="any" 
                                                onKeyPress="if(this.value.length === 10) return false;" 
                                                value="${copropietario?.telefono_2 ?? ''}"/>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                            <label class="control-label">Correo (<small style="color: red;">*</small>)<small class="pl-1" id="errorMsgCorreo${idDiv}"></small></label></label>
                                            <input class="form-control input-gral" 
                                                name="correo[]" 
                                                id="correoCop${idDiv}"
                                                type="email" 
                                                value="${copropietario?.correo ?? ''}"
                                                oninput= "validarCorreo('#correoCop${idDiv}', '#errorMsgCorreo${idDiv}')"
                                                autocomplete="off"/>
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 m-0">
                                            <label class="control-label">Domicilio (<small style="color: red;">*</small>)</label>
                                            <input class="form-control input-gral" 
                                                name="domicilio[]" 
                                                type="text" 
                                                value="${copropietario?.domicilio_particular ?? ''}"
                                                autocomplete="off"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 m-0">
                                            <label class="control-label">Estado civil (<small style="color: red;">*</small>)</label>
                                            <select name="estado_civil[]" 
                                                id="estadoCivilSelect${idDiv}"
                                                title="SELECCIONA UNA OPCIÓN" 
                                                class="selectpicker m-0 select-gral" 
                                                data-container="body" 
                                                data-width="100%"></select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                            <label class="control-label">INE/Pasaporte (<small style="color: red;">*</small>)</label>
                                            <input class="form-control input-gral" 
                                                name="identificacion[]" 
                                                type="text"
                                                value="${copropietario?.ine ?? ''}"/>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                            <label class="control-label">Ocupación (<small style="color: red;">*</small>)</label>
                                            <input class="form-control input-gral" 
                                                name="ocupacion[]" 
                                                type="text" 
                                                value="${copropietario?.ocupacion ?? ''}"
                                                autocomplete="off"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `);

    estadoCivilList.forEach((estadoCivil) => {
        const id = estadoCivil.id_opcion;
        const name = estadoCivil.nombre;

        if (copropietario == null) {
            $(`#estadoCivilSelect${idDiv}`).append($('<option>').val(id).text(name.toUpperCase()));
        } else if (copropietario?.estado_civil === id) {
            $(`#estadoCivilSelect${idDiv}`).append($('<option selected>').val(id).text(name.toUpperCase()));
        } else {
            $(`#estadoCivilSelect${idDiv}`).append($('<option>').val(id).text(name.toUpperCase()));
        }
    });
    $(`#estadoCivilSelect${idDiv}`).selectpicker('refresh');
    $(`#eliminarIcon${idDiv}`).tooltip({ trigger: "hover" });
}

const eliminarCopropietario = (idDiv, idCopropietario) => {
    if (idCopropietario !== 'Nuevo') {
        copropietariosEliminar.push(idCopropietario);
    }

    $(`#copropietarioDiv${idDiv}`).html('');
}

/**
 * @param {string} input
 * @return {boolean}
 */
function validateInputArray(input) {
    let result = true;
    const inputArr = document.getElementsByName(input);
    for (let i = 0; i < inputArr.length; i++) {
        if (inputArr[i].value.trim().length === 0) {
            result = false;
        }
    }
    return result;
}

const validarCorreoInputArray = (input) => {
    let result = true;
    const inputArr = document.getElementsByName(input);
    for (let i = 0; i < inputArr.length; i++) {
        if (!validateEmail(inputArr[i].value)) {
            result = false;
        }
    }
    return result;
}

const obtenerEstadoCivilLista = () =>{
    return new Promise((resolve) => {
        $.getJSON(`${general_base_url}Reestructura/getEstadoCivil`,function (estadoCivil) {
            resolve(estadoCivil);
        });
    });
}

$(document).on('click', '.btn-traspaso', function () {
    const tr = $(this).closest('tr');
    const row = $('#reubicacionClientes').DataTable().row(tr);
    $("#idLoteTraspaso").val(row.data().idLote);
    $("#comentarioTraspaso").val($(this).attr("data-comentarioTraspaso"));
    $("#cantidadTraspaso").val($(this).attr("data-cantidadTraspaso") <= 0 ? '' : $(this).attr("data-cantidadTraspaso"));
    document.getElementById("mainLabelTextTraspaso").innerHTML = `Confirma la cantidad que se va a traspasar del <b>${row.data().nombreLote}</b>.`;
    $("#capturaTraspasoModal").modal("show");
});

// ESTA FUNCIÓN LA VOY A MOVER A GENERALES
function soloNumeros(evt) {
	if (window.event)
		keynum = evt.keyCode;
	else
		keynum = evt.which;
	if ((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6 || keynum == 46)
		return true;
	else {
		alerts.showNotification("top", "left", "Oops, algo salió mal. Asegúrate de ingresar únicamente números.", "danger");
		return false;
	}
}

// SE ENVÍA COMENTARIO Y CANTIDAD A TRASPASAR PARA ACTUALIZAR EN DATOS X CLIENTE
$(document).on("click", "#guardarTraspaso", function (e) {
    e.preventDefault();
    let data = new FormData();
    data.append("idLote", $("#idLoteTraspaso").val());
    data.append("cantidadTraspaso", $("#cantidadTraspaso").val());
    data.append("comentarioTraspaso", $("#comentarioTraspaso").val());
    if ($("#cantidadTraspaso").val() == '')
        alerts.showNotification("top", "right", `Asegúrate de ingresar la cantidad que se traspasó.`, "warning");
    else {
        $.ajax({
            url: `${general_base_url}Reestructura/setTraspaso`,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: "POST",
            success: function (response) {
                $("#guardarTraspaso").prop("disabled", false);
                if (response) {
                    alerts.showNotification("top", "right", `La información ha sido capturada de manera exitosa.`, "success");
                    $('#reubicacionClientes').DataTable().ajax.reload(null, false);
                    $("#capturaTraspasoModal").modal("hide");
                }
                else
                alerts.showNotification("top", "right", "Oops, algo salió mal. Inténtalo más tarde.", "warning");
            },
            error: function () {
                $("#guardarTraspaso").prop("disabled", false);
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    }
});
