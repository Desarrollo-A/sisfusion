$(document).ready(function () {
    $('#spiner-loader').removeClass('hide');

    $.post(`${general_base_url}Contabilidad/lista_proyectos`, function(data) {
        for( let i = 0; i<data.length; i++){
            const id = data[i]['idResidencial'];
            const name = data[i]['descripcion'];
            $("#proyecto").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#proyecto").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
});

let titulos = [];
$('#foliosTable thead tr:eq(0) th').each(function (i) {
    title = $(this).text();
    titulos.push(title);
    $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $( 'input', this).on('keyup change', function () {
        if ($('#foliosTable').DataTable().column(i).search() !== this.value) {
            $('#foliosTable').DataTable().column(i).search(this.value).draw();
        }
    });
    $('[data-toggle="tooltip"]').tooltip({trigger: "hover" });
});

// CONFIGURACIÓN DEL DATATABLE 
let miDatatable;
const dataTable = (idCondominio) => {
    $(".box-table").removeClass('hide');
    generalDataTable = $('#foliosTable').dataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX:true,
        buttons: [
        {
            text: '<i class="fa fa-file-csv" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Plantilla para carga de folios',
            action: () => downloadTemplate(idCondominio)
        },
        {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Lotes con folios',
            title:"Lotes con folios",
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, /*11 acciones*/],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
            }
        },
        { 
            text: '<i class="fa fa-upload"></i>',
            className: 'btn btn-azure btn-upload-file',
            titleAttr: 'Cargar folios',
            action: () => $('#uploadModal').modal('toggle')
        }
        ],
        pagingType: "full_numbers",
        fixedHeader: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: "../static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [
            {
                data: function (d) {
                    return d.idInfoLote;
                }
            },
            {
                data: function (d) {
                    return d.idLote;
                }
            },
            {
                data: function (d) {
                    return d.nombreLote;
                }
            },
            {
                data: function (d) {
                    return d.calle;
                }
            },
            {
                data: function (d) {
                    return d.colonia;
                }
            },
            {
                data: function (d) {
                    return d.numExterior;
                }
            },
            {
                data: function (d) {
                    return d.codigoPostal;
                }
            },
            {
                data: function (d) {
                    return d.superficie;
                }
            },
            {
                data: function (d) {
                    return d.sup;
                }
            },
            {
                data: function (d) {
                    if (d.regimen == 1) return 'SI';
                    if (d.regimen == 0) return 'NO';
                    return 'N/A';
                }
            },
            {
                data: function (d) {
                    return d.folio;
                }
            },
            {
                data: function (d) {
                    return `<div class="d-flex justify-center">${datatableButtons(d)}</div>`;
                }
            }
        ],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
        ajax: {
            url: `${general_base_url}Contabilidad/getLotesConFolios`,
            type: "POST",
            cache: false,
            data : {
                idCondominio: idCondominio,
                filtrado: 1
            }
        },
        initComplete: function(){
            $("#spiner-loader").addClass('hide');
        }
    });
}

// CARGA DE CONDOMINIOS AL SELECCCIONAR LA RESIDENCIAL
$('#proyecto').change(function() {
    $('#spiner-loader').removeClass('hide');
    const proyectoSeleccionado = $(this).val();
    $("#condominio").html("");
    $.post(`${general_base_url}Contabilidad/lista_condominios/${proyectoSeleccionado}`, function(data) {
        $("#condominio").append($('<option disabled selected>SELECCIONA UN CONDOMINIO</option>'));
        for( let i = 0; i<data.length; i++){
            const id = data[i]['idCondominio'];
            const name = data[i]['nombre'];
            $("#condominio").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#condominio").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
    
});

// LLENADO DE LA TABLA Y PLANTILLA AL SELECCIONAR EL CONDOMINIO
$('#condominio').change( function() {
    const condominio = $(this).val();
    $("#lote").html("");
    dataTable(condominio);
});

$(document).on('click', '.btn-upload-file', function () {
    document.getElementById("archivo").value = "";
    document.getElementById("file-name").value = "";
});

$(document).on('click', '#btnCargaFolios', async function () {
    $('#btnCargaFolios').attr('disabled', true); 
    const filename = document.getElementById("archivo").value;
    const archivo = document.getElementById("archivo").files[0];
    const extension = filename.substring(filename.lastIndexOf("."));
    const fechaActual = fechaServidor();

    // Validaciones
    if (filename == '') {
        return alerts.showNotification("top", "right", "Asegúrate de seleccionar un archivo para llevar a cabo la carga de la información.", "warning");
    }
    if (extension !== ".xlsx" && extension !== ".xls") {
        return alerts.showNotification("top", "right", "El archivo que has intentado cargar con la extensión <b>" + extension + "</b> no es válido. Recuerda seleccionar un archivo <b>.xlsx</b>.", "warning");
    }

    const idCondominio = $('#condominio').val();
    let res = await $.ajax({
        type: 'POST',
        url: `${general_base_url}Contabilidad/getLotesConFolios`,
        data: {idCondominio: idCondominio, filtrado: 0},
        cache: false,
    });

    res = JSON.parse(res);
    console.log('DATOS', res.data);

    const lector = new FileReader();
    
    lector.onload = async function(e) {
        const contenido = e.target.result;
        const libro = XLSX.read(contenido, { type: 'binary' });

        // Obtener la primera hoja del libro
        const primeraHoja = libro.SheetNames[0];
        // Obtener los datos de la primera hoja
        const datos = XLSX.utils.sheet_to_json(libro.Sheets[primeraHoja]);

        // Procesar los datos como desees
        console.log('Excel', datos);

        const lotesDescartados = [];
        const lotesAInsertar = [];
        datos.forEach(row => {
            const found = res.data.some(registered => registered.idLote === row['ID LOTE']);
            if (found) {
                lotesDescartados.push(row);
            } else {
                lotesAInsertar.push({ 
                    idLote: row['ID LOTE'], 
                    nombreLote: row['NOMBRE LOTE'].toUpperCase(),
                    calle: row['CALLE'].toUpperCase(),
                    colonia: row['COLONIA'].toUpperCase(),
                    numExterior: row['EXTERIOR'].toString().toUpperCase(),
                    codigoPostal: row['CÓDIGO POSTAL'],
                    superficie: row['SUPERFICIE'],
                    regimen: row['RÉGIMEN'],
                    folio: row['FOLIO'],
                    estatus: 1,
                    creadoPor: id_usuario_general,
                    fechaCreacion: fechaActual, 
                    modificadoPor: id_usuario_general,
                    fechaModificacion: fechaActual,
                });
            }
        });
        
        console.log('lotesDescartados', lotesDescartados);
        console.log('lotesAInsertar', lotesAInsertar);

        // Realizar la llamada AJAX para enviar los datos a insertar
        let rs = await $.ajax({
            type: 'POST',
            url: `${general_base_url}Contabilidad/insertBatchLotesConFolios`,
            data: {lotesConFolio: lotesAInsertar},
            cache: false,
        });
    
        rs = JSON.parse(rs);
        console.log('INSERT', rs);
        
        if(rs.result) {
            if (lotesDescartados.length > 0) {
                const nombresLotes = lotesDescartados.map(lote => lote['NOMBRE LOTE']);
                const resultado = `(${nombresLotes.join(', ')})`;
                alerts.showNotification("top", "right", `¡Se omitió el registro de los lotes ${resultado}!`, "warning");
            }
            alerts.showNotification("top", "right", "¡Se registró los folios correctamente!", "success");
        } else {
            alerts.showNotification("top", "right", "Asegúrate de seleccionar un archivo para llevar a cabo la carga de la información.", "warning");
        }
        
        $('#foliosTable').DataTable().ajax.reload();

        $('#uploadModal').modal('toggle');
        $('#btnCargaFolios').attr('disabled', false);
    };

    lector.readAsArrayBuffer(archivo);
});

$(document).on('click', '.btn-editar-folio', function(e){
    // $('.btn-archivo').attr('disabled', true);  // Desactivo btn
    $('#spiner-loader').removeClass('hide'); // Aparece spinner
    const d = JSON.parse($(this).attr("data-data"));

    console.log("INFO", d);
    
    changeSizeModal('modal-md');
    appendBodyModal(`
        <div method="post" id="formInfoCliente" class="scroll-styles" style="max-height:500px; padding:0px 20px 30px 20px; overflow:auto">
            <div class="modal-header">
                <h4 class="modal-title text-center">Edita la información</h4>
            </div>

            <div class="modal-body p-0">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 m-0">
                            <label class="control-label">Nombre lote</label>
                            <input class="form-control input-gral" name="inputNombreLote" id="inputNombreLote" type="text" value="${d.nombreLote}" disabled/>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 m-0">
                            <label class="control-label">Calle (<small style="color: red;">*</small>)</label>
                            <input class="form-control input-gral" name="inputCalle" id="inputCalle" type="text" value="${d.calle}" required/>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 m-0">
                            <label class="control-label">Colonia (<small style="color: red;">*</small>)</label>
                            <input class="form-control input-gral" name="inputColonia" id="inputColonia" value="${d.colonia}" type="text" required/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 m-0">
                            <label class="control-label">Exterior (<small style="color: red;">*</small>)<small class="pl-1" id="result"></small></label>
                            <input class="form-control input-gral" name="inputExterior" id="inputExterior" value="${d.numExterior}" required/>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 m-0">
                            <label class="control-label">Código postal (<small style="color: red;">*</small>)</label>
                            <input class="form-control input-gral" name="inputCodigoPostal" id="inputCodigoPostal" type="number" min="0" step="1" maxlength="6" oninput="validateInput(this)" value="${d.codigoPostal}" required/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 m-0">
                            <label class="control-label">Superficie (<small style="color: red;">*</small>)<small class="pl-1" id="result"></small></label>
                            <input class="form-control input-gral" name="inputSuperficie" id="inputSuperficie" type="number" value="${d.superficie}" min="0" oninput="validity.valid||(value='');" required/>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 m-0">
                            <label class="control-label">Régimen (<small style="color: red;">*</small>)</label>
                            <select name="inputRegimen" id="inputRegimen" title="SELECCIONA UNA OPCIÓN" class="selectpicker m-0 select-gral" data-container="body" data-width="100%" value="${d.regimen}" required>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 m-0">
                            <label class="control-label">Folio (<small style="color: red;">*</small>)</label>
                            <input class="form-control input-gral" name="inputFolio" id="inputFolio" type="number" value="${d.folio}" required/>
                        </div>
                    </div>
                    <input type="hidden" name="inputIdInfoLote" id="inputIdInfoLote" value="${d.idInfoLote}">
                </div>
            </div>
        </div>
        `
    );

    appendFooterModal(
        `<button type="button" class="btn btn-danger btn-simple" onclick="hideModal()" style='margin-top: 15px'>Cancelar</button>
        <button type="button" id="actualizaLoteConFolio" name="actualizaLoteConFolio" class="btn btn-primary" style='margin-top: 15px'>GUARDAR</button>`
    );

    showModal();
    if (d.regimen == 0) {$("#inputRegimen").append($('<option selected>').val(0).text('NO'))} else {$("#inputRegimen").append($('<option>').val(0).text('NO'))};
    if (d.regimen == 1) {$("#inputRegimen").append($('<option selected>').val(1).text('SÍ'))} else {$("#inputRegimen").append($('<option>').val(1).text('SÍ'))};
    $("#inputRegimen").selectpicker('refresh');
    $('#spiner-loader').addClass('hide'); // Aparece spinner
});

$(document).on('click', '.btn-borrar-folio', function(e){
    // $('.btn-archivo').attr('disabled', true);  // Desactivo btn
    $('#spiner-loader').removeClass('hide'); // Aparece spinner
    const d = JSON.parse($(this).attr("data-data"));

    console.log("INFO", d);
    
    changeSizeModal('modal-md');
    appendBodyModal(`
        <div class="modal-header">
            <h4 class="modal-title text-center">¿Estás seguro de eliminar el folio del lote ${d.nombreLote}?</h4>
        </div>
        
        <input type="hidden" name="inputIdInfoLote" id="inputIdInfoLote" value="${d.idInfoLote}">
        `
    );

    appendFooterModal(
        `<button type="button" class="btn btn-danger btn-simple" onclick="hideModal()" style='margin-top: 15px'>Cancelar</button>
        <button type="button" id="eliminaLoteConFolio" name="eliminaLoteConFolio" class="btn btn-primary" style='margin-top: 15px'>Aceptar</button>`
    );

    showModal();
    $('#spiner-loader').addClass('hide'); // Aparece spinner
});

$(document).on('click', '.btn-cambios-folio', async function(e){
    $('#spiner-loader').removeClass('hide'); // Aparece spinner
    const d = JSON.parse($(this).attr("data-data"));

    // d.idInfoLote
    let rs = await $.ajax({
        type: 'POST',
        url: `${general_base_url}Contabilidad/historicoLoteConFolio`,
        data: {idInfoLote: d.idInfoLote},
        cache: false,
    });

    rs = JSON.parse(rs);
    console.log('updateee', rs);

    $("#changelog").html('');
    $.each(rs, function(i, data){
        fillChangelog(i, data);
    });
    console.log(rs.length === 0)
    if (rs.length === 0) {$("#changelog").append("No hay información por mostrar");}
    $("#seeInformationModal").modal('show')

    $('#spiner-loader').addClass('hide');
});

$(document).on('click', '#actualizaLoteConFolio', async function (){
    const idInfoLote = $('#inputIdInfoLote').val();
    const calle = $('#inputCalle').val();
    const colonia = $('#inputColonia').val();
    const exterior = $('#inputExterior').val();
    const codigoPostal = $('#inputCodigoPostal').val();
    const superficie = $('#inputSuperficie').val();
    const regimen = $('#inputRegimen').val();
    const folio = $('#inputFolio').val();


    if(calle =='' || colonia == '' || exterior == '' || codigoPostal == null || superficie == '' || regimen == null || folio == '' )
        return alerts.showNotification("top", "right", "Asegúrate de llenar todos los campos requeridos (*).", "warning");

    $("#spiner-loader").removeClass('hide');

    const data = {calle, colonia, numExterior: exterior, codigoPostal, superficie, regimen, folio, modificadoPor: id_usuario_general, fechaModificacion: fechaServidor()}

    let rs = await $.ajax({
        type: 'POST',
        url: `${general_base_url}Contabilidad/updateLoteConFolio`,
        data: {idInfoLote, data},
        cache: false,
    });

    rs = JSON.parse(rs);
    console.log('updateee', rs);
    hideModal();
    $('#foliosTable').DataTable().ajax.reload();
    alerts.showNotification("top", "right", "Información capturada con éxito.", "success");
    $("#spiner-loader").addClass('hide');
});

$(document).on('click', '#eliminaLoteConFolio', async function (){
    const idInfoLote = $('#inputIdInfoLote').val();

    $("#spiner-loader").removeClass('hide');
    const data = {estatus: 0, modificadoPor: id_usuario_general, fechaModificacion: fechaServidor()}

    let rs = await $.ajax({
        type: 'POST',
        url: `${general_base_url}Contabilidad/updateLoteConFolio`,
        data: {idInfoLote, data},
        cache: false,
    });

    rs = JSON.parse(rs);
    console.log('updateee', rs);
    hideModal();
    $('#foliosTable').DataTable().ajax.reload();
    alerts.showNotification("top", "right", "Información actualizada con éxito.", "success");
    $("#spiner-loader").addClass('hide');
});

$(document).on("change", "#archivo", function () {
    const target = $(this);
    const relatedTarget = target.siblings(".file-name");
    const fileName = target[0].files[0].name;
    relatedTarget.val(fileName);
});

$(document).on('keyup', "input[data-type='currency']", function() {
    formatCurrencyG($(this));
});

const downloadTemplate = (idCondominio) => {
    $.ajax({
        url: `${general_base_url}Contabilidad/lista_lotes`,
        type: 'post',
        dataType: 'json',
        data: {
            idCondominio: idCondominio,
        },
        beforeSend: function() {
            $('#spiner-loader').removeClass('hide');
        },
        success: function (response) {
            let template = [];
            const headers = ['ID LOTE', 'NOMBRE LOTE', 'CALLE', 'COLONIA', 'EXTERIOR', 'CÓDIGO POSTAL', 'SUPERFICIE', 'RÉGIMEN', 'FOLIO'];
            template.push(headers);
            for (let i = 0; i < response.length; i++) {
                const row = [];
                row.push(response[i]['idLote']);
                row.push(response[i]['nombreLote']);
                template.push(row);
            }

            const date = new Date();
            const filename = "PlantillaIngresoFolios_" + date.getDate() + "-" + date.getMonth() + "-" + date.getFullYear() + " " + date.getHours() + date.getMinutes() + date.getSeconds() + date.getMilliseconds() + ".xlsx";
            const ws_name = "Plantilla";
            const wb = XLSX.utils.book_new(),
                ws = XLSX.utils.aoa_to_sheet(template);
            XLSX.utils.book_append_sheet(wb, ws, ws_name);
            XLSX.writeFile(wb, filename);
            $('#spiner-loader').addClass('hide');
        },
        error: function() {
            $('#spiner-loader').addClass('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
}

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

const datatableButtons = (d) => {
    const EDIT_ROW = newButton('btn-data btn-blueMaderas btn-editar-folio', 'EDITAR INFORMACIÓN', 'EDIT', d, 'fas fa-pencil-alt');
    const DELETE_ROW = newButton('btn-data btn-warning btn-borrar-folio', 'BORRAR FOLIO', 'DELETE', d, 'fas fa-trash');
    const CHANGES_ROW = newButton('btn-data btn-sky btn-cambios-folio', 'BITÁCORA DE CAMBIOS', 'CHANGES', d, 'fas fa-eye');

    return CHANGES_ROW + EDIT_ROW + DELETE_ROW ;
}

const validatePositiveNumber = (input) => {
    if (input.value < 0) {
        input.value = '';
    }
}

const validateInput = (input) => {
    // Elimina el valor si es inválido
    if (!input.validity.valid) {
        input.value = '';
    }
    // Limita la longitud del valor
    if (input.value.length > input.maxLength) {
        input.value = input.value.slice(0, input.maxLength);
    }
}

const fillChangelog = (i, d) => {
    let anterior, nuevo;
    if (d.col_afect.toUpperCase() === 'REGIMEN' && d.nuevo == 1) {nuevo = 'SI'} else {nuevo = 'NO'}
    if (d.col_afect.toUpperCase() === 'REGIMEN' && d.anterior == 1) {anterior = 'SI'} else {anterior = 'NO'}
    if (d.col_afect.toUpperCase() != 'REGIMEN') {anterior = d.anterior; nuevo = d.nuevo } 
    $("#changelog").append('<li>\n' +
    '<a style="float: right">'+d.fecha_creacion+'</a><br>\n' +
    '<a><b>CAMPO:</b> '+ d.col_afect.toUpperCase() + '</a> \n' +
    '<br>\n' + 
    '<a><b>Valor anterior: </b> '+anterior+' </a>\n' +
    '<br>\n' +
    '<a><b>Nuevo valor: </b> '+nuevo+' </a>\n' +
    '<br>\n' +
    '<a><b>Modificado por: </b> '+(d.nombreUsuario).toUpperCase()+' </a>\n' +
    '<br>\n' +
    '</li>');
}
