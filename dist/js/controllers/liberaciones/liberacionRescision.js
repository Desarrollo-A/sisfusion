const LIBERACION = Object.freeze({
    PARTICULARES: 133,
    RESCISION: 134
})

const TIPO_VENTA = Object.freeze({
    PARTICULARES: 1,
    NORMALES: 2
})
let liberacionesDataTable;

$(document).ready(function(){
    //Manejamos la carga de inputs desde la carga del archivo de JS
    if (id_rol_general == 55){ // Postventa inicia proceso
        $.post(`${general_base_url}Liberaciones/lista_proyectos`, function(data) {
            for( let i = 0; i<data.length; i++){
                const id = data[i]['idResidencial'];
                const name = data[i]['descripcion'];
                $("#proyecto").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#proyecto").selectpicker('refresh');
        }, 'json');
    }

    // Pulsamos sobre el tab de proceso
    if (id_rol_general != 55) {
       $('#pendientes').click();
    }

    if (id_rol_general != 55) $('.toolbar').addClass('hide'); // Quito spinner
    if (id_rol_general != 55) $('.material-datatables').removeClass('hide'); // Quito la tabla
});

// Pestaña de liberar lotes desde el primer paso.
$(document).on("click", "#liberar", function () {
    if ($('.toolbar').hasClass('hide')) $('.toolbar').removeClass('hide');
    if (!$('.toolbar').hasClass('hide') && !$("#lote").val()) $('.material-datatables').addClass('hide');
})

$(document).on("click", "#pendientes", function () {
    $('#spiner-loader').removeClass('hide'); // Aparece spinner
    if (!$('.toolbar').hasClass('hide')) $('.toolbar').addClass('hide');
    if ($('.toolbar').hasClass('hide')) $('.material-datatables').removeClass('hide'); // Quito la tabla

    $.ajax({
        type: 'POST',
        url: `${general_base_url}Liberaciones/getLotesPendientesLiberacion`,
        data: {tipoVenta: TIPO_VENTA.NORMALES, idProcesoTipoLiberacion: LIBERACION.RESCISION},
        cache: false,
        success: function(rs) {
            const res = JSON.parse(rs);
            datatableFn(res, 1);
            $('#spiner-loader').addClass('hide'); // Desaparece spinner
        },
        error: function(xhr, status, error) {
            console.error("Error en la petición AJAX:", error);
            $('#spiner-loader').addClass('hide'); // Desaparece spinner
        }
    });
})

$(document).on("click", "#proceso", function () {
    $('#spiner-loader').removeClass('hide'); // Aparece spinner
    if (!$('.toolbar').hasClass('hide')) $('.toolbar').addClass('hide');
    if ($('.toolbar').hasClass('hide')) $('.material-datatables').removeClass('hide'); // Quito la tabla
    
    $.ajax({
        type: 'POST',
        url: `${general_base_url}Liberaciones/getLotesEnProcesoLiberacion`,
        data: {tipoVenta: TIPO_VENTA.NORMALES, idProcesoTipoLiberacion: LIBERACION.RESCISION},
        cache: false,
        success: function(rs) {
            const res = JSON.parse(rs);
            datatableFn(res, 2);
            $('#spiner-loader').addClass('hide'); // Desaparece spinner
        },
        error: function(xhr, status, error) {
            console.error("Error en la petición AJAX:", error);
            $('#spiner-loader').addClass('hide'); // Desaparece spinner
        }
    });
})

$('#proyecto').change(function() {
    $("#condominio").html("");
    $.post(`${general_base_url}Liberaciones/lista_condominios/${$('#proyecto').val()}`, function(data) {
        $("#condominio").append($('<option disabled selected>SELECCIONA UN CONDOMINIO</option>'));
        for( let i = 0; i<data.length; i++){
            const id = data[i]['idCondominio'];
            const name = data[i]['nombre'];
            $("#condominio").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#condominio").selectpicker('refresh');
    }, 'json');
});

$('#condominio').change( function() {
    const index_condominio = $(this).val();
    $("#lote").html("");
    $.post(`${general_base_url}Liberaciones/lista_lotes/${index_condominio}/${TIPO_VENTA.NORMALES}`, function(data) {
        $("#lote").append($('<option disabled selected>SELECCIONA UN LOTE</option>'));
        for( let i = 0; i<data.length; i++){
            const id = data[i]['idLote'];
            const name = data[i]['nombreLote'];
            $("#lote").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#lote").selectpicker('refresh');
    }, 'json');
});

$('#lote').change( function() {
    if ($("#lote").val() != '') {
        $('#spiner-loader').removeClass('hide'); // Aparece spinner
        const loteValue = $(this).val();
        $("#lote").val(loteValue);
        if ($('.material-datatables').hasClass('hide')) $('.material-datatables').removeClass('hide');
    
        const values = { tipoVenta: TIPO_VENTA.NORMALES, idProcesoTipoLiberacion: LIBERACION.RESCISION, lotes: loteValue }
        
        $.ajax({
            type: 'POST',
            url: `${general_base_url}Liberaciones/getLotesParaLiberacion`,
            data: values,
            cache: false,
            success: function(rs) {
                const res = JSON.parse(rs);
                datatableFn(res, 1);
                $('#spiner-loader').addClass('hide'); // Aparece spinner
            },
            error: function(xhr, status, error) {
                console.error("Error en la petición AJAX:", error);
                $('#spiner-loader').addClass('hide'); // Aparece spinner
            }
        });
    } 
});

// Función para colocar el nombre del archivo en el input de texto que comparte con el input de archivo
$(document).on("change", "#archivo_liberacion", function () {
    const target = $(this);
    const relatedTarget = target.siblings(".file-name");
    const fileName = target[0].files[0].name;
    relatedTarget.val(fileName);
});

// Función para formatear el input de tipo currency (incluso inputs embebidos con JS)
$(document).on('keyup', "input[data-type='currency']", function() {
    formatCurrencyG($(this));
});

// Encabezados de datatable
let titulosTabla = [];
$('#liberacionesDataTable thead tr:eq(0) th').each(function (i) {
    const title = $(this).text();
    titulosTabla.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function () {
        if ($('#liberacionesDataTable').DataTable().column(i).search() !== this.value) {
            $('#liberacionesDataTable').DataTable().column(i).search(this.value).draw();
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
});

// ABRIR MODAL
$(document).on('click', '.btn-accion', async function(){

    // Leemos los datos del registro
    const d = JSON.parse($(this).attr("data-data"));
    const accion = $(this).attr("data-accion");

    // Creamos el label del titulo del modal.
    let titulo = '';
    if (accion === 'AVANCE') titulo = '<h4><b>Avanzar</b> la liberación del lote <b>'+d.nombreLote+'</b></h4>'    
    if (accion === 'RECHAZO') titulo = '<h4>¿Está seguro de <b>rechazar</b> la liberación del lote <b>'+d.nombreLote+'</b>?</h4>'
    if (accion === 'HISTORICO') titulo = '<h4>Historico del proceso de liberación de <b>'+d.nombreLote+'</b>?</h4>'    

    // Creamos el label de comentario
    let comentarioLabel = 'Comentario (opcional)';
    if (accion === 'RECHAZO') comentarioLabel = 'Motivo del rechazo (opcional)';

    // Embebemos contenido a header y comentario.
    $('#labelHeaderAccionModal').html(titulo);
    $('#labelComentarioAccionModal').html(comentarioLabel);

    // Declaramos el contenido extra que embeberemos
    let content = ``;
    if (d.enProcesoLiberacion === 0 || d.enProcesoLiberacion === 1) {
        content = `
            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-1">
                <div id="selectFileSection">
                    <div class="file-gph">
                        <input type="file" accept=".pdf" id="archivo_liberacion">
                        <input class="file-name" id="file-name" type="text" placeholder="No has seleccionada nada aún" readonly="">
                        <label class="upload-btn m-0" for="archivo_liberacion">
                            <span>Seleccionar</span>
                            <i class="fas fa-folder-open"></i>
                        </label>
                    </div>
                </div>
            </div>`;
    }
    if (d.enProcesoLiberacion === 4) {
        content = `
            <div class="col-12 col-sm-12 col-md-12 col-lg-12" id="cambioPrecio">
                <label class="control-label"> Precio por m<sup>2</sup> (<span class="isRequired">*</span>)</label>
                <input class="form-control input-gral" placeholder="$" name="costoM2" id="costoM2" data-type="currency" step="any">
            </div>`;
    }

    // Embebemos el contenido extra
    $('#extra-content-accion-modal').html(content);

    // Limpiamos valores de los campos antes de abrir el modal.
    $('#comentarioAccionModal').val('');

    // Mostramos el modal y mostramos la info del lote en el modal
    $('#accion-modal').modal('show');

    // Inputs ocultos para utilizar la información para validar acciones.
    const info = 
        '<input type="hidden" id="accion"></input>' + 
        '<input type="hidden" id="data"></input>' ;
    $('#data-modal').append(info);
    
    // Asignación de valores a los inputs
    $("#accion").val(accion);
    $("#data").val(JSON.stringify(d));
});

// FUNCIONALIDAD DEL BOTÓN DE ACEPTAR DEL MODAL
$(document).on("click", "#btn-accion", async function (e) {
    e.preventDefault();

    // Obteniendo los valores para su proceso
    const accion = $("#accion").val();
    const d = JSON.parse($("#data").val());
    let comentario = $('#comentarioAccionModal').val();
    let rescision = 1;
    let archivo, proceso, estatusLib, concepto, precioLiberacion;

    //Validaciones en caso de tener
    if ((d.enProcesoLiberacion === 1 || d.enProcesoLiberacion === 0)) { // POSTVENTA: LIBERAR LOTE
        archivo = $("#archivo_liberacion");
        
        // Input sin archivo
        if (archivo.val().length === 0) return alerts.showNotification("top", "right", "Seleccione el archivo a adjuntar.", "warning");

        // Archivo incorrecto
        if (!validateExtension(archivo[0].files[0].name.split('.').pop(), 'pdf, PDF')) return alerts.showNotification("top", "right", "El tipo de archivo es incorrecto", "warning");
        
    }
    if ((d.enProcesoLiberacion === 4 )) { // VENTAS: Generar las condiciones de venta (precio).
        precioLiberacion = $('#costoM2').val().replace('$', '').replace(',', ''); // El precio del lote
        
        // Input de precio sin monto
        if (precioLiberacion === '') return alerts.showNotification("top", "right", `Digite el nuevo precio por m<sup>2</sup> del lote.`, "warning");
    }

    // Asignación de valores dependiendo el proceso
    if (accion === 'AVANCE') {
        proceso = d.enProcesoLiberacion === 0 || d.enProcesoLiberacion === 1 ? 2 : d.enProcesoLiberacion + 1; // Avanza proceso
        estatusLib = d.estatus_lib === 2 ? 3 : 1; // 1: avance normal, 2 rechazo y 3 correccion.
        concepto = d.enProcesoLiberacion === 0 || d.enProcesoLiberacion === 1 ? 3 : d.concepto;
        if ( d.enProcesoLiberacion >=  5 ) { // Arrastramos el valor de precio en los registros ya una vez registrado.
            precioLiberacion = d.precioLiberacion;
        }
    }
    if (accion === 'RECHAZO') {
        if ( [3, 4, 5].includes(d.enProcesoLiberacion) ) { proceso = 7 } // Si [Administración(3), ventas(4), cajas(5)] rechazan, no se regresa si no se finaliza.
        else { proceso = d.enProcesoLiberacion - 1 } // Cualquier otro caso si se regresa al paso anterior. 

        if ( [3, 4, 5].includes(d.enProcesoLiberacion) ) { estatusLib = 1 } // Si el proceso se rechaza en esos procesos, no es rechazo ya que se finaliza pero no se libera.
        else { estatusLib = 2 } // Cualquier otro si es marcado como rechazo
        rescision = proceso === 1 ? 0 : d.rescision; // Si lo regresan para validar doc, se asigna 0 sino el que ya tenia registrado.
        concepto = d.concepto;
        if ( d.enProcesoLiberacion >=  5 ) { // Arrastramos el valor de precio en los registros ya una vez registrado.
            precioLiberacion = d.precioLiberacion;
        }
    }

    // Loading y disables mientras hace la carga
    $('#btn-accion').attr('disabled', true); // Deshabilita botón
    $('#spiner-loader').removeClass('hide'); // Aparece spinner

    // Datos a envíar al endpoint para su registro.
    const data = new FormData();
    data.append("idLote", d.idLote);
    data.append("id_cliente", d.idCliente);
    data.append("rescision", rescision);
    data.append("autorizacion_DG", 0); // En Rescisión no tenemos autorización por DG
    data.append("proceso_lib", proceso);
    data.append("estatus_lib", estatusLib);
    data.append("concepto", concepto);
    data.append("comentario", comentario);
    if (precioLiberacion) data.append("precioLiberacion", precioLiberacion); // Solo se envia cuando tenga valor o mas bien cuando no sea null, undefined, false, 0, NaN.
    await $.ajax({
        type: 'POST',
        url: 'actualizaLiberacionLote',
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            const res = JSON.parse(data);
            alerts.showNotification("top", "right", res.msg, res.code === 200 ? "success" : "warning");
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });

    // Hacemos el registro de en historial_documento
    if (d.enProcesoLiberacion === 0 || d.enProcesoLiberacion === 1 && proceso === 2) {
        
        // Borramos el archivo en caso de tener uno y actualizamos los registros de historial_documento 
        if (d.expediente) {
            const docData = new FormData();
            docData.append("idDocumento", d.idDocumento);
            docData.append("tipoDocumento", d.tipo_doc);
            let rs1 = await $.ajax({
                type: 'POST',
                url: `${general_base_url}Documentacion/eliminarArchivo`,
                data: docData,
                contentType: false,
                cache: false,
                processData: false,
            });

            rs1 = JSON.parse(rs1);
            console.log('Eliminar archivo', rs1);
            
            if (rs1.code == 500 ){
                alerts.showNotification("top", "right", 'Surgió un error al eliminar archivo', "warning");
                return;
            } 
        }

        const tipoDocumento = 53;
        const movimiento = 'RESCICIÓN DE CONTRATO';
        const expediente = generarTituloDocumento(d.nombreResidencial, d.nombreLote, d.idLote, d.idCliente, tipoDocumento);
        const ndata = new FormData();
        ndata.append("movimiento", movimiento); // Nombre del tipo de documento
        ndata.append("expediente", expediente); // Nombre del archivo CCSPQ-15005-PPYUC-ETC.pdf
        ndata.append("idCliente", d.idCliente);
        ndata.append("idCondominio", d.idCondominio);
        ndata.append("idLote", d.idLote);
        ndata.append('tipo_doc', tipoDocumento); // TipoDocumento es el id del opc de mis archivos (53, 54)

        let res = await $.ajax({
            type: 'POST',
            url: `${general_base_url}Liberaciones/registrarDocumentoEnArbol`,
            data: ndata,
            contentType: false,
            cache: false,
            processData: false,
        });

        res = JSON.parse(res);
        console.log('Historial documento', res);

        const xdata = new FormData();
        xdata.append("idLote", d.idLote);
        xdata.append("idDocumento", res.documentId);
        xdata.append("tipoDocumento", tipoDocumento);
        xdata.append("tituloDocumento", expediente);
        xdata.append("uploadedDocument", archivo[0].files[0]);
        let rs = await $.ajax({
            type: 'POST',
            url: `${general_base_url}Documentacion/subirArchivo`,
            data: xdata,
            contentType: false,
            cache: false,
            processData: false,
        });

        rs = JSON.parse(rs);
        console.log('Subir archivo', rs);
        if (rs.code == 500 ){
            alerts.showNotification("top", "right", 'Surgió un error al registrar el archivo', "warning");
            return;
        } 
    }

    // En caso de ser el ultimo proceso, ya se libera.
    if (d.enProcesoLiberacion === 5 && proceso === 6) {
        // Generamos el token para liberar el lote
        let res = await $.ajax({
            type: 'POST',
            url: `${general_base_url}Api/getToken`,
            data: JSON.stringify({"id": 6489}),
            contentType: 'application/json',
            cache: false,
            processData: false,
        });

        res = JSON.parse(res);
        console.log('getToken', res);

        // Realizamos la acción de la función que libera el lote!
        let data = await $.ajax({
            type: 'POST',
            url: `${general_base_url}Caja_outside/caja_modules`,
            headers: {
                'Authorization': res.id_token
            },
            data: JSON.stringify({
                "accion": 3,
                "activeLE": false,
                "activeLP": false,
                "id_proy": d.idResidencial,
                "idCondominio": d.idCondominio,
                "id_usuario": id_usuario_general,
                "tipo": "1",
                "lotes": [
                    {
                        "nombreLote": d.nombreLote,
                        "idLote": d.idLote,
                        "precio": precioLiberacion,
                        "tipo_lote": "1"
                    }
                ]
            }),
            contentType: 'application/json',
            cache: false,
            processData: false,
        });

        // Notificamos al usuario
        data = JSON.parse(data);
        console.log('Proceso liberación final', data);
        alerts.showNotification("top", "right", data.message === 'SUCCESS' ? 'La liberación se ha completado' : 'Surgió un error al intentar liberar el lote', data.message === 'SUCCESS' ? "success" : "warning");
        if (data.message != 'SUCCESS') return;
    }

    await liberacionesDataTable.ajax.reload();
    $('#accion-modal').modal('hide');
    $('#btn-accion').attr('disabled', false);  // Lo vuelvo a activar
    $('#spiner-loader').addClass('hide'); // Quito spinner  
});

$(document).on('click', '.btn-historico', async function(){
    $('.btn-historico').attr('disabled', true);  // Lo vuelvo a activar
    $('#spiner-loader').removeClass('hide'); // Aparece spinner
    // Leemos los datos del registro
    const d = JSON.parse($(this).attr("data-data"));
    $("#changelog").html('');

    // ACTION
    await $.ajax({
        url: general_base_url + 'Liberaciones/historialLiberacionLote',
        type: 'POST',
        data: {
            "idLote": d.idLote,
            "tipoVenta" : 2,
            "idProcesoTipoLiberacion": LIBERACION.RESCISION
          },
        dataType: 'JSON',
        success: function (res) {
          $.each( res, function(i, data){
            fillChangelog(i, data);
          });
          $("#seeInformationModal").modal('show')
          $('#spiner-loader').addClass('hide'); // Quito spinner  
        },
        error: function () {},
        catch: function () {},
    });

    $('.btn-historico').attr('disabled', false);  // Lo vuelvo a activar
    $('#spiner-loader').addClass('hide'); // Quito spinner  
});

$(document).on('click', '.btn-archivo', function () {
    $('.btn-archivo').attr('disabled', true);  // Lo vuelvo a activar
    $('#spiner-loader').removeClass('hide'); // Aparece spinner
    Shadowbox.init();
    const d = JSON.parse($(this).attr("data-data"));
    let filePath = `${general_base_url}Documentacion/archivo/${d.expediente}`;
    Shadowbox.open({
        content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="${filePath}"></iframe></div>`,
        player: "html",
        title: `Visualizando archivo: ${d.movimiento}`,
        width: 985,
        height: 660
    });
    $('.btn-historico').attr('disabled', false);  // Lo vuelvo a activar
    $('#spiner-loader').addClass('hide'); // Quito spinner  
});

// DATATABLE
const datatableFn = (ndata, type) => {
    liberacionesDataTable = $('#liberacionesDataTable').DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Liberación de lotes (Particulares)',
            title:"Liberación de lotes (Particulares)",
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24],
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
            titleAttr: 'Liberación de lotes (Particulares)',
            title:"Liberación de lotes (Particulares)",
            orientation: 'landscape',
            pageSize: 'LEGAL',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 21, 22, 24],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulosTabla[columnIdx] + ' ';
                    }
                }
            }
        }],
        columnDefs: [
            {
                searchable: true,
                visible: true
            },
            { 
                orderable: true, 
                targets: '_all' 
            }
        ],
        pageLength: 4,
        bAutoWidth: false,
        fixedColumns: true,
        ordering: true,
        language: {
            url: general_base_url+"static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        order: [[15, 'DESC']],
        destroy: true,
        columns: [
            {
                data: (d) => {
                    if (d.enProcesoLiberacion === 0 || d.estatus_lib === 1) return `<span class="label" style="color: #1B4F72; background: #1B4F7218;}">NUEVO</span>`;
                    if (d.estatus_lib === 2) return `<span class="label" style="color: #B03A2E; background: #B03A2E18;}">RECHAZO</span>`;
                    if (d.estatus_lib === 3) return `<span class="label" style="color: #DF7314; background: #DF731418;}">CORRECCIÓN</span>`;
                    return 'SIN ESPECIFICAR';
                }
            },
            { data: "nombreProcesoLiberacion" },
            { data: "movimiento" },
            { data: "nombreResidencial" },
            { data: "nombreCondominio" },
            { data: "nombreLote" },
            { data: "idLote" },
            { data: "cliente" },
            { data: "referencia" },
            { data: "nombreAsesor" },
            { data: "nombreCoordinador" },
            { data: "nombreGerente" },
            { data: "nombreSubdirector" },
            { data: "nombreRegional" },
            { data: "nombreRegional2" },
            { data: "fechaApartado" },
            {
                data: function (d) {
                    return `${formatMoney(d.precio)}`
                }
            },
            { data: "sup"},
            {
                data: function (d) {
                    return d.costom2f == 'SIN ESPECIFICAR' ? d.costom2f : `${formatMoney(d.costom2f)}`;
                }
            },
            {
                data: function (d) {
                    return `${formatMoney(d.total)}`
                }
            },
            {
                data: function (d) {
                    return d.precioLiberacion === null ? 'SIN ASIGNAR' : `${formatMoney(d.precioLiberacion)}`;
                }
            },
            { data: "comentario" },
            {
                data: function (d) {
                    return `<div class="d-flex justify-center">${datatableButtons(d, type)}</div>`;
                }
            }
        ],
        // ajax: {
        //     url: `${general_base_url}Liberaciones/getLotesParaLiberacion`,
        //     dataSrc: "",
        //     type: "POST",
        //     cache: false,
        //     data: {"tipoVenta": 2, idProcesoTipoLiberacion: 134},
        // }, 
        data: ndata,
        initComplete: function () {
            $('[data-toggle="tooltip"]').tooltip({
                trigger: "hover"
            });
        }
    });
}

/**
 * newButton function => Create a custom button with parameters
 *
 * @param {string} btnClass
 * @param {string} title
 * @param {string} action
 * @param {object} data
 * @param {string} icon
 * @returns {string} 
 */
const newButton = (btnClass, title, action = '', data, icon) => {
    const CUSTOM_BTN = `<button class='${btnClass}'
        data-toggle='tooltip' 
        data-placement='top'
        title='${title.toUpperCase()}'
        data-accion='${action}'
        data-data='${JSON.stringify(data)}'>
            <i class='${icon}'></i>
        </button>`;

    return CUSTOM_BTN;
}

const datatableButtons = (d, type) => {
    const BTN_AVANCE_P1  = newButton('btn-data btn-green btn-accion', 'AVANZAR LIBERACIÓN A CONTRALORÍA', 'AVANCE', d, 'fas fa-thumbs-up');
    const BTN_AVANCE_P2  = newButton('btn-data btn-green btn-accion', 'AVANZAR LIBERACIÓN A ADMINISTRACIÓN', 'AVANCE', d, 'fas fa-thumbs-up');
    const BTN_AVANCE_P3  = newButton('btn-data btn-green btn-accion', 'AVANZAR LIBERACIÓN A VENTAS', 'AVANCE', d, 'fas fa-thumbs-up');
    const BTN_AVANCE_P4  = newButton('btn-data btn-green btn-accion', 'AVANZAR LIBERACIÓN A CAJAS', 'AVANCE', d, 'fas fa-thumbs-up');
    const BTN_RECHAZO_P2 = newButton('btn-data btn-warning btn-accion', 'RECHAZAR LIBERACIÓN A POSTVENTA', 'RECHAZO', d, 'fas fa-thumbs-down');
    const BTN_LIBERA     = newButton('btn-data btn-green btn-accion', 'APROBAR LIBERACIÓN', 'AVANCE', d, 'fa fa-check');
    const BTN_NO_LIBERA  = newButton('btn-data btn-warning btn-accion', 'RECHAZAR LIBERACIÓN', 'RECHAZO', d, 'fa fa-times-circle');
    const BTN_INFO       = newButton('btn-data btn-blueMaderas btn-historico', 'HISTORICO DE LA LIBERACIÓN', 'HISTORICO', d, 'fas fa-info');
    const BTN_VER_DOC    = newButton('btn-data btn-sky btn-archivo', 'VISUALIZAR ARCHIVO', 'VER-ARCHIVO', d, 'fas fa-eye');
    
    let NO_BTN = '';

    if (type === 2) {
        if (d.expediente) return BTN_VER_DOC + BTN_INFO ;
        if (!d.expediente) return BTN_INFO;
        return BTN_INFO;
    }

    if (type === 1) {
        if (id_rol_general == 55) { // POSTVENTA
            if (d.enProcesoLiberacion === 0 && d.expediente) return BTN_AVANCE_P1 + BTN_VER_DOC + BTN_INFO ;
            if (d.enProcesoLiberacion === 0 && !d.expediente) return BTN_AVANCE_P1 + BTN_INFO;
            if (d.enProcesoLiberacion === 1 ) return BTN_AVANCE_P1 + BTN_VER_DOC + BTN_INFO;
            return BTN_INFO;
        }
        if (id_rol_general == 17) { // CONTRALORIA
            if (d.enProcesoLiberacion === 2) return BTN_AVANCE_P2 + BTN_RECHAZO_P2 + BTN_VER_DOC +BTN_INFO;
            return BTN_INFO;
        }
        if (id_rol_general == 11 ) { // ADMINISTRACIÓN
            if (d.enProcesoLiberacion === 3) return BTN_AVANCE_P3 + BTN_NO_LIBERA + BTN_VER_DOC +BTN_INFO;
            return BTN_INFO;
        }
        if (id_rol_general == 2) { // VENTAS
            if (d.enProcesoLiberacion === 4) return BTN_AVANCE_P4 + BTN_NO_LIBERA + BTN_VER_DOC +BTN_INFO;
            return BTN_INFO;
        }
        if (id_rol_general == 12) { // CAJAS
            if (d.enProcesoLiberacion === 5) return BTN_LIBERA + BTN_NO_LIBERA + BTN_VER_DOC + BTN_INFO;      
            return BTN_INFO;
        }
    }

    return NO_BTN;
}

const fillChangelog = (i, d) => {
    let accion = 'Enviado a '
    if (d.estatus_lib == '2') {
        accion = 'Se regresó a:'
    }
    $("#changelog").append('<li>\n' +
  '            <a style="float: right">'+d.fecha_modificacion+'</a><br>\n' +
  '            <a><b>Tipo de liberación:</b> '+ d.nombreConceptoLiberacion + '</a> \n' +
  '            <br>\n' + 
  '            <a><b>Estatus: </b> '+accion+d.nombreProcesoLiberacion.toLowerCase()+' </a>\n' +
  '            <br>\n' +  
  '            <a><b>Modificado por: </b> '+(d.nombreMod+' '+d.ap1_mod+ ' '+ d.ap2_mod).toUpperCase()+' </a>\n' +
  '            <br>\n' +
  '            <a><b>Comentario: </b> '+d.comentario+' </a>\n' +
      '</li>');
}

const generarTituloDocumento = (abreviaturaNombreResidencial, nombreLote, idLote, idCliente, tipoDocumento) => {
    let rama;
    if (tipoDocumento === 53) rama = 'RESCICIÓN DE CONTRATO' ;
    if (tipoDocumento === 54) rama = 'AUTORIZACIÓN DG' ;

    const DATE = new Date();
    const DATE_STR = [DATE.getMonth() + 1, DATE.getDate(), DATE.getFullYear()].join('-');
    const TITULO_DOCUMENTO = `${abreviaturaNombreResidencial}_${nombreLote}_${idLote}_${idCliente}_TDOC${tipoDocumento}${rama.slice(0, 4)}_${DATE_STR}`;
    return TITULO_DOCUMENTO;
}