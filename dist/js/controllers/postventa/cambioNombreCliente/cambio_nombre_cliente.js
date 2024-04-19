let contador = 0;
let banderasPosiciones = [];
$(document).ready(function () {
    $('#spiner-loader').removeClass('hide');
    $.post(`${general_base_url}Contratacion/lista_proyecto`, function (data) {
        for (var i = 0; i < data.length; i++) {
            $("#proyecto").append($('<option>').val(data[i]['idResidencial']).text(data[i]['descripcion']));
        }
        $("#proyecto").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
    $.post(`${general_base_url}General/getOpcionesPorCatalogo/122`, function (data) {
        for (var i = 0; i < data.length; i++) {
            $("#tipoTramite").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
        }
        $("#tipoTramite").selectpicker('refresh');
    }, 'json');
});

$('#proyecto').change(function () {
    let index_proyecto = $(this).val();
    $("#condominio").html("");
    $("#table_cambio_nombre_cliente").removeClass('hide');
    $('#spiner-loader').removeClass('hide');
    $.post(`${general_base_url}Contratacion/lista_condominio/${index_proyecto}`, function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idCondominio'];
            var name = data[i]['nombre'];
            $("#condominio").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#condominio").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
    fillTable(index_proyecto, 0);
});

$('#condominio').change(function () {
    // $('#spiner-loader').removeClass('hide');
    let index_proyecto = $("#proyecto").val();
    let index_condominio = $(this).val();
    fillTable(index_proyecto, index_condominio);
    // $('#spiner-loader').addClass('hide');
});

let titulos = [];
$('#table_cambio_nombre_cliente thead tr:eq(0) th').each(function (i) {
    title = $(this).text();
    titulos.push(title);
    $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#table_cambio_nombre_cliente').DataTable().column(i).search() !== this.value)
            $('#table_cambio_nombre_cliente').DataTable().column(i).search(this.value).draw();
    });
    $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
});

function fillTable(index_proyecto, index_condominio) {
    tabla_valores_cliente = $("#table_cambio_nombre_cliente").DataTable({
        width: '100%',
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Listado de lotes',
            title: 'Listado de lotes',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        processing: true,
        pageLength: 10,
        bAutoWidth: true,
        bLengthChange: false,
        scrollX: true,
        bInfo: true,
        searching: true,
        ordering: false,
        fixedColumns: true,
        destroy: true,
        columns: [
            { data: 'nombreResidencial' },
            { data: 'nombreCondominio' },
            { data: 'nombreLote' },
            { data: 'idLote' },
            { data: 'nombreCliente' },
            { data: 'fechaApartado' },
            { data: 'nombreAsesor' },
            { data: 'nombreCoordinador' },
            { data: 'nombreGerente' },
            { data: 'nombreSubdirector' },
            { data: 'nombreRegional' },
            { data: 'nombreRegional2' },
            {
                data: function (d) {
                    return `<span class="label lbl-azure">${d.tipoVenta}</span>`;
                },
            },
            {
                data: function (d) {
                    return `<span class="label lbl-yellow">${d.ubicacion}</span>`;
                },
            },
            {
                data: function (d) {
                    let classStatus = '';
                    if(d.estatusProceso == 'Rechazado'){
                        classStatus = 'lbl-warning';
                    }else if(d.estatusProceso == 'Aceptado'){
                        classStatus = 'lbl-green';
                    }else if(d.estatusProceso = 'Sin iniciar proceso'){
                        classStatus = 'lbl-gray';
                    }
                    return `<span class="label ${classStatus}">${d.estatusProceso}</span>`;
                },
            },
            {
                data: function (d) {
                    return `<span class="label lbl-violetBoots">${d.tipoTramite}</span>`;
                },
            },
            {
                data: function (d) {
                    let comentario = (d.comentario=='' || d.comentario==null) ? '' : d.comentario;
                    return `${comentario}`;
                },
            },
            {
                data: function (d) {
                    let btns = '';
                    const DATE = new Date();
                    const DATE_STR = [DATE.getMonth() + 1, DATE.getDate(), DATE.getFullYear()].join('-');
                    const TITULO_DOCUMENTO = `${d.nombreResidencial}_${d.nombreLote}_${d.idLote}_${d.idCliente}_TDOC51${'ESCRITURA CON SELLOS DE NOTARIA'.slice(0, 4)}_${DATE_STR}`;

                    let btnBase = `<button class="btn-data btn-blueMaderas iniciarTramite" data-toggle="tooltip" 
                    data-placement="top" title= "Iniciar trámite para cambio de nombre" data-idLote="${d.idLote}" 
                    data-idCliente="${d.idCliente}" data-tipoTransaccion="${d.estatusCambioNombre}" 
                    data-nombreCteNuevo="${d.nombreCteNuevo}" data-apCteNuevo="${d.apCteNuevo}" 
                    data-amCteNuevo="${d.amCteNuevo}" data-idTipoTramite="${d.idTipoTramite}" 
                    data-idRegistro="${d.id_registro}" data-tituloDocumento="${TITULO_DOCUMENTO}"><i class="fas fa-user-edit"></i></button>`;
                    if (d.estatusCambioNombre == 1)
                        btns = btnBase;
                    else if (d.estatusCambioNombre == 2 || d.estatusCambioNombre == 5)
                        btns = btnBase + `<button class="btn-data btn-green btn-avanzar" data-toggle="tooltip" data-placement="top" 
                        title= "Enviar" data-idLote="${d.idLote}" data-idCliente="${d.idCliente}" 
                        data-tipoTransaccion="${d.estatusCambioNombre}" 
                        data-precioFinal="${d.precioFinalLote}" ><i class="fas fa-thumbs-up"></i></button>`;
                    return `<div class="d-flex justify-center">${btns}</div>`;
                }
            }
        ],
        columnDefs: [{
            defaultContent: "",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        ajax: {
            url: `${general_base_url}Postventa/getListaClientes`,
            dataSrc: "",
            type: "POST",
            cache: false,
            data: {
                "index_proyecto": index_proyecto,
                "index_condominio": index_condominio
            }
        },
        order: [
            [1, 'asc']
        ],
    });
    $('#table_cambio_nombre_cliente').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
}

$(document).on('click', '.iniciarTramite', async function () {
    banderasPosiciones = [];
    contador = 0;
    $('#idLote').val($(this).attr('data-idLote'));
    $('#idCliente').val($(this).attr('data-idCliente'));
    $('#tipoTransaccion').val($(this).attr('data-tipoTransaccion'));
    $('#idRegistro').val($(this).attr('data-idRegistro'));
    $('#tituloDocumentoInput').val($(this).attr('data-tituloDocumento'));
    $('#banderaCoprop').val(contador);
    document.getElementById('divHtmlCoprop').innerHTML = '';
    document.getElementById('fileEscrituraSellos').innerHTML = '';
    document.getElementById('fileEscrituraSellos').classList.add = 'hide';
    if ($(this).attr('data-tipoTransaccion') == 1) {
        $("#tipoTramite").val('').selectpicker('refresh');
        $('#txtNombre').val('');
        $('#txtApellidop').val('');
        $('#txtApellidom').val('');
    } 
    else if ($(this).attr('data-tipoTransaccion') == 2 || $(this).attr('data-tipoTransaccion') == 5) {
        $("#tipoTramite").val($(this).attr('data-idTipoTramite')).selectpicker('refresh');
        $('#txtNombre').val($(this).attr('data-nombreCteNuevo'));
        $('#txtApellidop').val($(this).attr('data-apCteNuevo'));
        $('#txtApellidom').val($(this).attr('data-amCteNuevo'));
        let id_cliente = $(this).attr('data-idcliente');
        let idLote = $(this).attr('data-idLote');
        let tipoTramite = $(this).attr('data-idTipoTramite');
        let valoresGenerales = await getDescriptionNotaria(id_cliente, idLote);
        let copropietarios = valoresGenerales.copropietarios;
        let contadorInner = 0;
        let divAddCoprop = document.getElementById('divHtmlCoprop');
        let divEscrituraNotariada = document.getElementById('fileEscrituraSellos');
        let escrituraNotariadaValor = valoresGenerales.escrituraNotariadaObject.escrituraNotariada;

        copropietarios.map((elemento, index)=>{
            console.log(index);
            console.log(elemento['apellido_paterno']);
            contadorInner = index + 1;
            contador = index + 1; //se inicia el contador agregando las posiciones actuales
            banderasPosiciones.push(contador);
            $('#banderaCoprop').val(contador);
            let contenidoDinamico  = '<div class="row mt-4" id="campoDinamico'+contadorInner+'">';
            contenidoDinamico += '  <div class="row">';
            contenidoDinamico += '    <div class="col-lg-12">';
            contenidoDinamico += '        <div class="form-group text-left m-0">';
            contenidoDinamico += '            <label class="control-label label-gral">Nombre (<small style="color: red;">*</small>)</label>';
            contenidoDinamico += '            <input id="nomCopro'+contadorInner+'" name="nomCopro'+contadorInner+'" value="'+elemento.nombre+'" class="form-control input-gral" type="text">';
            contenidoDinamico += '        </div>';
            contenidoDinamico += '    </div>';
            contenidoDinamico += '    <div class="col-lg-6">';
            contenidoDinamico += '        <div class="form-group text-left m-0">';
            contenidoDinamico += '            <label class="control-label label-gral">Apellido paterno (<small style="color: red;">*</small>)</label>';
            contenidoDinamico += '            <input id="appCopro'+contadorInner+'" name="app'+contadorInner+'" class="form-control input-gral" value="'+elemento.apellido_paterno+'" type="text">';
            contenidoDinamico += '        </div>';
            contenidoDinamico += '    </div>';
            contenidoDinamico += '    <div class="col-lg-6">';
            contenidoDinamico += '        <div class="form-group text-left m-0">';
            contenidoDinamico += '            <label class="control-label label-gral">Apellido materno (<small style="color: red;">*</small>)</label>';
            contenidoDinamico += '            <input id="apmCopro'+contadorInner+'" name="apm'+contadorInner+'" class="form-control input-gral" value="'+elemento.apellido_materno+'" type="text">';
            contenidoDinamico += '            <input id="idCoprop'+contadorInner+'" name="idCoprop'+contadorInner+'" type="hidden" value="'+elemento.id_copropietario+'" type="text">';
            contenidoDinamico += '        </div>';
            contenidoDinamico += '    </div>';

            contenidoDinamico += '    <div class="col-lg-2 col-lg-offset-9 center-align text-center justify-center">';
            contenidoDinamico += '            <button type="button" class="btn btn-danger btn-simple" onClick="eliminarCopropDiv('+contadorInner+'); eliminarCoproP('+elemento.id_copropietario+')">eliminar</button>';
            contenidoDinamico += '    </div>';

            contenidoDinamico += '  </div>';
            contenidoDinamico += '  <hr>';
            contenidoDinamico += '</div>';

            divAddCoprop.innerHTML += contenidoDinamico;

        });

        if(tipoTramite == 6){
            let escrituraNotariadaINNER = '<h5>Escritura notariada</h5><hr>';
            escrituraNotariadaINNER    += '<iframe src="'+general_base_url+'static/documentos/cliente/escrituraNotariada/'+escrituraNotariadaValor+'" width="100%" height="250px"></iframe>\n';
            escrituraNotariadaINNER    += '<br><br><p id="secondaryLabelDetail"> Sube la escritura con sellos de notaria para actualizar el registro actual</p>' +
                '           <div class="" id="selectFileSection">\n' +
                '                        <div class="file-gph">\n' +
                '                            <input class="d-none" type="file" name="fileElm" id="fileElm">\n' +
                '                            <input class="file-name" id="file-name" type="text" placeholder="No has seleccionada nada aún" readonly="">\n' +
                '                            <label class="upload-btn m-0" for="fileElm">\n' +
                '                                <span>Seleccionar</span>\n' +
                '                                <i class="fas fa-folder-open"></i>\n' +
                '                            </label>\n' +
                '                        </div>\n' +
                '             </div>';
            divEscrituraNotariada.innerHTML = escrituraNotariadaINNER;
            divEscrituraNotariada.classList.remove('hide');
            $("input:file").on("change", function () {
                const target = $(this);
                const relatedTarget = target.siblings(".file-name");
                const fileName = target[0].files[0].name;
                relatedTarget.val(fileName);
            });
        }



        async function getDescriptionNotaria(idCliente, idLote) {
            $("#spiner-loader").removeClass("hide");
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: "getCopropsByIdCliente",
                    data: { idCliente: idCliente, idLote: idLote },
                    type: "POST",
                    dataType: "json",
                    success: function (response) {
                        resolve({copropietarios:response['copropietarios'], escrituraNotariadaObject:response['escrituraNotariada']});
                        $("#spiner-loader").addClass("hide");
                    },
                });
            });
        }


    }
    $('#inicioTramite').modal();
});

function eliminarCoproP(id_copropietario){
    console.log('id_copropietario', id_copropietario);
    $("#spiner-loader").removeClass("hide");
    $.ajax({
        url: "eliminaCopropietario",
        data: { idCopropietario: id_copropietario },
        type: "POST",
        dataType: "json",
        success: function (response) {
            if(response.status = 1){
                alerts.showNotification('top','right', response.message,'success');
            }else{
                alerts.showNotification('top','right', response.message,'danger');
            }
            $("#spiner-loader").addClass("hide");
        },
    });
}

$(document).on("submit", "#formCambioNombre", function (e) {
    e.preventDefault();
    let data = new FormData($(this)[0]);
    data.append('arrayPosiciones', banderasPosiciones);
    //$('#spiner-loader').removeClass('hide');

    $.ajax({
        url: `${general_base_url}Postventa/setInformacionCliente`,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (data) {
            data = JSON.parse(data);
            alerts.showNotification("top", "right", data.message, "success");
            //$('#spiner-loader').addClass('hide');
            $('#table_cambio_nombre_cliente').DataTable().ajax.reload();
            $('#inicioTramite').modal('hide');
        },
        error: function (data) {
            alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
        }
    });
});

$(document).on('click', '.btn-avanzar', function () {
    $('#idLoteA').val($(this).attr('data-idLote'));
    $('#idClienteA').val($(this).attr('data-idCliente'));
    $('#tipoTransaccionA').val($(this).attr('data-tipoTransaccion'));
    $('#comentarioAvanzar').val('');
    $('#avance').modal();
})

$(document).on("submit", "#formAvanzarEstatus", function(e) {
    $('#spiner-loader').removeClass('hide');
    e.preventDefault();
    let data = new FormData($(this)[0]);
    $.ajax({
        url : `${general_base_url}Postventa/setAvance`,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(data){
            data = JSON.parse(data);
            alerts.showNotification("top", "right", data.message, "success");
            $('#table_cambio_nombre_cliente').DataTable().ajax.reload();
            $('#spiner-loader').addClass('hide');
            $('#avance').modal('hide');
        },
        error: function( data ){
            alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            $('#avance').modal('hide');
        }
    });
});

function agregarCoprop(){
    let divAddCoprop = document.getElementById('divHtmlCoprop');
    contador = contador + 1;

    $('#banderaCoprop').val(contador);
    let divInternoInner  = '<div class="row mt-4" id="campoDinamico'+contador+'">';
        divInternoInner += '  <div class="row">';
        divInternoInner += '    <div class="col-lg-12">';
        divInternoInner += '        <div class="form-group text-left m-0">';
        divInternoInner += '            <label class="control-label label-gral">Nombre (<small style="color: red;">*</small>)</label>';
        divInternoInner += '            <input id="nomCopro'+contador+'" name="nomCopro'+contador+'" class="form-control input-gral" type="text">';
        divInternoInner += '        </div>';
        divInternoInner += '    </div>';
        divInternoInner += '    <div class="col-lg-6">';
        divInternoInner += '        <div class="form-group text-left m-0">';
        divInternoInner += '            <label class="control-label label-gral">Apellido paterno (<small style="color: red;">*</small>)</label>';
        divInternoInner += '            <input id="appCopro'+contador+'" name="app'+contador+'" class="form-control input-gral" type="text">';
        divInternoInner += '        </div>';
        divInternoInner += '    </div>';
        divInternoInner += '    <div class="col-lg-6">';
        divInternoInner += '        <div class="form-group text-left m-0">';
        divInternoInner += '            <label class="control-label label-gral">Apellido materno (<small style="color: red;">*</small>)</label>';
        divInternoInner += '            <input id="apmCopro'+contador+'" name="apm'+contador+'" class="form-control input-gral" type="text">';
        divInternoInner += '        </div>';
        divInternoInner += '    </div>';

        divInternoInner += '    <div class="col-lg-2 col-lg-offset-9 center-align text-center justify-center">';
        divInternoInner += '            <button type="button" class="btn btn-danger btn-simple" onClick="eliminarCopropDiv('+contador+')">eliminar</button>';
        divInternoInner += '    </div>';

        divInternoInner += '  </div>';
        divInternoInner += '  <hr>';
        divInternoInner += '</div>';
    divAddCoprop.innerHTML += divInternoInner;

    banderasPosiciones.push(contador);

}

function eliminarCopropDiv(index){
    console.log('contador: ', index);
    $("#campoDinamico"+index).remove();
    contador = contador - 1;
    $('#banderaCoprop').val(contador);


    var indice = banderasPosiciones.indexOf(index); // obtenemos el indice
    banderasPosiciones.splice(indice, 1); // 1 es la cantidad de elemento a eliminar

    console.log('banderasPosiciones', banderasPosiciones);

}

$(document).on('change', '#tipoTramite', ()=>{
    let tipoTramite = $('#tipoTramite').val();
    //6: escrituracion tercero
    let contenedorInput = document.getElementById('fileEscrituraSellos');
    if(tipoTramite == 6){
        let htmlInner = '<p id="secondaryLabelDetail"> Sube la escritura con sellos de notaria</p>' +
            '           <div class="" id="selectFileSection">\n' +
            '                        <div class="file-gph">\n' +
            '                            <input class="d-none" type="file" name="fileElm" id="fileElm">\n' +
            '                            <input class="file-name" id="file-name" type="text" placeholder="No has seleccionada nada aún" readonly="">\n' +
            '                            <label class="upload-btn m-0" for="fileElm">\n' +
            '                                <span>Seleccionar</span>\n' +
            '                                <i class="fas fa-folder-open"></i>\n' +
            '                            </label>\n' +
            '                        </div>\n' +
            '             </div>';

        contenedorInput.innerHTML = htmlInner;
        contenedorInput.classList.remove('hide');
        $("input:file").on("change", function () {
            const target = $(this);
            const relatedTarget = target.siblings(".file-name");
            const fileName = target[0].files[0].name;
            relatedTarget.val(fileName);
        });
    }else{
        contenedorInput.classList.add('hide');
    }
});
