var arrayKeysArchivos = [];
let titulosTablaArchivos = [];
let flagProceso = 0;
var rescisionArchivo = '';
var id_dxc = 0;
var editarFile = 0;
var archivosAborrar = [];
var acceptFiles = '';

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
});



$('#tablaLotesArchivosReestructura thead tr:eq(0) th').each(function (i) {
    const title = $(this).text();
    titulosTablaArchivos.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function () {
        if ($('#tablaLotesArchivosReestructura').DataTable().column(i).search() !== this.value) {
            $('#tablaLotesArchivosReestructura').DataTable().column(i).search(this.value).draw();
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
});

var tablaLotesArchivosReestructura = $('#tablaLotesArchivosReestructura').DataTable({
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
            columns: [0, 1, 2],
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
                columns: [0, 1, 2],
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
    order: [[1, "desc"]],
    destroy: true,
    columns: [
        {
            data: function (d) {
                return d.nombre+' '+d.apellido_paterno+' '+d.apellido_materno;
            }
        },
        { data: "idLote" },
        { data: "nombreLote" },
        {
            data: function (d) {
                //editar: 1 -> se edita el registro actual
                //editar: 0 -> se están dando de alta nuevos registros
                //data-rescision:
                btns = `<button class="btn-data btn-sky btn-abrir-modal"
                            data-toggle="tooltip" 
                            data-placement="left"
                            title="ABRIR MODAL"
                            data-idCliente="${d.idCliente}"
                            data-idLote="${d.idLote}"
                            data-nombreLote="${d.nombreLote}"
                            data-estatusLoteArchivo="${d.status}"
                            data-id_dxc="${d.id_dxc}"  
                            data-editar="1"   
                            data-rescision="${d.rescision}"                       
                            >
                            <i class="fas fa-adjust"></i>
                    </button>`;
                return `<div class="d-flex justify-center">${btns}</div>`;
            }
        }
    ],
    ajax: {
        url: `${general_base_url}reestructura/getListaLotesArchivosReestrucura`,
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

$(document).on('click', '.btn-abrir-modal',function(){
    let idLote = $(this).attr("data-idLote");
    let nombreLote = $(this).attr("data-nombreLote");
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
                formArchivos(tipotransaccion, data, flagEditar, nombreLote)
            },
            error: function(){
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });

    $("#archivosReestructura").modal();
});

function formArchivos(estatusProceso, datos, flagEditar, nombreLote){
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
    let contenidoHTMLinfoCL = `<div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 text-left">
                                        <p class="m-0 ">Cliente. ${nombreCliente}</p>
                                        <p class="m-0">Lote. ${nombreLote}</p>
                                        <p class="m-0 text-left">Domicilio particular. ${domicilio_particular}</p>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 text-left">
                                        <p class="m-0">Correo. ${correo}</p>
                                        <p class="m-0">Teléfono. ${telefono1}</p>
                                        <p class="m-0">Ocupación. ${ocupacion}</p>
                                        <p class="m-0">INE. ${ine}</p>
                                        <p class="m-0">Estado civil. ${estadoCivil}</p>
                                    </div>
                                </div>`;

    arrayKeysArchivos = [];
    let nombreArchivo = '';
    switch (estatusProceso) {
        case '2':
            label = '<b>Subir corrida del lote</b>';
            flagProceso = 2;
            acceptFiles = '.csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel';
            break;
        case '3':
            label = '<b>Subir contrato del lote</b>';
            flagProceso = 3;
            acceptFiles = 'application/pdf';
            break;
    }

    if(flagEditar ==0){
        editarFile = 0;
        datos.map((elemento, index)=>{

            contenidoHTML += '<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2">\n' +
                '                            <input type="hidden" name="idLotep'+elemento.id_pxl+'" id="idLotep'+elemento.id_pxl+'" value="'+elemento.id_pxl+'">\n' +
                '                            <input type="hidden" id="nombreLote'+elemento.id_pxl+'" value="'+elemento.nombreLote+'">\n' +
                '                            <h6 class="text-left">'+label+'<b>: </b>'+elemento.nombreLote+'<span class="text-red">*</span></h6>\n' +
                '                            <div class="" id="selectFileSection'+index+'">\n' +
                '                                <div class="file-gph">\n' +
                '                                    <input class="d-none" type="file" required accept="'+acceptFiles+'" id="fileElm'+index+'">\n' +
                '                                    <input class="file-name" id="file-name'+index+'" type="text" placeholder="No has seleccionada nada aún" readonly="">\n' +
                '                                    <label class="upload-btn m-0" for="fileElm'+index+'"><span>Seleccionar</span><i class="fas fa-folder-open"></i></label>\n' +
                '                                </div>\n' +
                '                            </div>\n' +
                '                        </div>';

            arrayKeysArchivos.push(elemento);
        });
        if(flagProceso == 3){
            //se esta subiendo contrato se debe pedir uno adicional
            contenidoHTML += ' <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2"><hr>\n' +
                '                            <h6 class="text-left"><b>Subir la resición del contrato: </b>'+nombreLote+'<span class="text-red">*</span></h6>\n' +
                '                            <div class="" id="selectFileSectionResicion">\n' +
                '                                <div class="file-gph">\n' +
                '                                    <input class="d-none" type="file" required accept="application/pdf" id="Resicion">\n' +
                '                                    <input class="file-name" id="resicion-name" type="text" placeholder="No has seleccionada nada aún" readonly="">\n' +
                '                                    <label class="upload-btn m-0" for="Resicion"><span>Seleccionar</span><i class="fas fa-folder-open"></i></label>\n' +
                '                                </div>\n' +
                '                            </div>\n' +
                '                        </div>';
        }
        // contenedorArchivos.innerHTML = contenidoHTML;

    }
    else if(flagEditar==1){
        editarFile = 1;
        datos.map((elemento, index)=>{
            arrayKeysArchivos.push(elemento);

            if(flagProceso==3){
                nombreArchivo = elemento.contrato;
            }else if(flagProceso==2){
                nombreArchivo = elemento.corrida;
            }
            archivosAborrar.push(nombreArchivo);
            contenidoHTML += '          <div class="col col-xs-12 col-sm-12 col-md-10 col-lg-10 mb-2">\n' +
                '                            <input type="hidden" name="idLotep'+elemento.id_pxl+'" id="idLotep'+elemento.id_pxl+'" value="'+elemento.id_pxl+'">\n' +
                '                            <input type="hidden" id="nombreLote'+elemento.id_pxl+'" value="'+elemento.nombreLote+'">\n' +
                '                            <h6 class="text-left">'+label+':'+elemento.nombreLote+'</h6>\n' +
                '                            <div class="" id="selectFileSection'+index+'">\n' +
                '                                <div class="file-gph">\n' +
                '                                    <input class="d-none" type="file" required accept="'+acceptFiles+'" id="fileElm'+index+'">\n' +
                '                                    <input class="file-name" id="file-name'+index+'" type="text" placeholder="No has seleccionada nada aún" readonly="">\n' +
                '                                    <label class="upload-btn w-50 m-0" for="fileElm'+index+'"><span>Seleccionar</span><i class="fas fa-folder-open"></i></label>\n' +
                '                                </div>\n' +
                '                            </div>\n' +
                '                        </div>';
            contenidoHTML += '          <div class="col col-xs-12 col-sm-12 col-md-2 col-lg-2 mt-4">\n' +
                '                           <div class="d-flex justify-center">' +
                '                               <button class="btn-data btn-sky ver-archivo" data-idPxl="'+elemento.id_pxl+'" ' +
                '                               data-nomArchivo="'+nombreArchivo+'" data-nombreOriginalLote="'+nombreLote+'"' +
                '                               data-rescision="0"><i class="fas fa-eye"></i></button>'+
                '                           </div>'+
                '                        </div>';
        });
        if(flagProceso == 3){
            //se esta subiendo contrato se debe pedir uno adicional
            contenidoHTML += ' <div class="col col-xs-12 col-sm-12 col-md-10 col-lg-10 mb-2"><hr>\n' +
                '                            <h6 class="text-left">Subir la resición del contrato:'+nombreLote+'</h6>\n' +
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
                '                               <button class="btn-data btn-sky ver-archivo" data-idPxl="'+id_dxc+'" ' +
                '                               data-nomArchivo="'+rescisionArchivo+'" data-nombreOriginalLote="'+nombreLote+'"' +
                '                               data-rescision="1"><i class="fas fa-eye"></i></button>'+
                '                           </div>'+
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
}

$(document).on("click", "#sendRequestButton", function (e) {
    e.preventDefault();

    const archivo0 = $("#fileElm0")[0].files[0];
    const archivo1 = $("#fileElm1")[0].files[0];
    const archivo2 = $("#fileElm2")[0].files[0];
    $("#spiner-loader").removeClass('hide');

    if(editarFile==1){
        let data = new FormData();
        let nombreLote = $('.btn-abrir-modal').attr("data-nombreLote");
        let idRegDXC = $('.btn-abrir-modal').attr("data-id_dxc");

        data.append("tipoProceso", flagProceso);
        data.append("longArray", arrayKeysArchivos.length);
        data.append("nombreLoteOriginal", nombreLote);
        data.append("id_dxc", idRegDXC);
        data.append("editarFile", editarFile);
        arrayKeysArchivos.map((elemento, index)=>{
            let flagEditar = ($("#fileElm"+index)[0].files[0]==undefined) ? 0 : 1;
            data.append("flagEditado"+index, flagEditar);
            data.append("archivo"+index, $("#fileElm"+index)[0].files[0]);
            data.append("idLoteArchivo"+index, $("#idLotep"+elemento.id_pxl).val());
            data.append("nombreLote"+index, $("#nombreLote"+elemento.id_pxl).val());
            data.append('archivoEliminar'+index, archivosAborrar[index]);
        });
        if(flagProceso==3){
            data.append("archivoResicion", $("#Resicion")[0].files[0]);
            let flagEditarRescision = ( $("#Resicion")[0].files[0]==undefined) ? 0 : 1;
            data.append("flagEditarRescision", flagEditarRescision);

            if(editarFile==1){
                data.append('rescisionArchivo', rescisionArchivo);
            }
        }
        $.ajax({
            type: 'POST',
            url: 'actualizaExpecifico',
            data: data,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
            },
            success: function(data) {
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
            error: function(){
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });

    }
    else if(editarFile==0){
        if(archivo0==undefined || archivo1==undefined || archivo2 == undefined){
            $("#spiner-loader").addClass('hide');
            alerts.showNotification('top', 'right', 'Debes seleccionar los archivos requeridos', 'warning');
        }
        else{
            if(flagProceso==3 && $("#Resicion")[0].files[0]==undefined){
                $("#spiner-loader").addClass('hide');
                alerts.showNotification('top', 'right', 'Selecciona archivo de rescisión', 'warning');
            }else{
                let data = new FormData();
                let nombreLote = $('.btn-abrir-modal').attr("data-nombreLote");
                let idRegDXC = $('.btn-abrir-modal').attr("data-id_dxc");

                data.append("tipoProceso", flagProceso);
                data.append("longArray", arrayKeysArchivos.length);
                data.append("nombreLoteOriginal", nombreLote);
                data.append("id_dxc", idRegDXC);
                data.append("editarFile", editarFile);
                arrayKeysArchivos.map((elemento, index)=>{
                    data.append("archivo"+index, $("#fileElm"+index)[0].files[0]);
                    data.append("idLoteArchivo"+index, $("#idLotep"+elemento.id_pxl).val());
                    data.append("nombreLote"+index, $("#nombreLote"+elemento.id_pxl).val());
                    data.append('archivoEliminar'+index, archivosAborrar[index]);
                });
                if(flagProceso==3){
                    data.append("archivoResicion", $("#Resicion")[0].files[0]);
                    if(editarFile==1){
                        data.append('rescisionArchivo', rescisionArchivo);
                    }
                }

                $.ajax({
                    type: 'POST',
                    url: 'updateArchivos',
                    data: data,
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function(){
                    },
                    success: function(data) {
                        const res = JSON.parse(data);
                        if (res.code === 200) {
                            alerts.showNotification(
                                "top",
                                "right",
                                `Los documentos se han cargado con éxito.`,
                                "success"
                            );
                            reubicacionClientes.ajax.reload();
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
                    error: function(){
                        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                    }
                });
            }
        }
    }
});

$(document).on('click', '.ver-archivo', function(){
    // visorArchivo(rutaArchivo, nombreArchivo);
    let id_pxl = $(this).attr("data-idPxl");
    let nombreArchivo = $(this).attr("data-nomArchivo");
    let nombreArchivoOriginal = $(this).attr("data-nombreOriginalLote");
    let rescision = $(this).attr("data-rescision");
    let url_base = general_base_url+'static/documentos/contratacion-reubicacion-temp/'+nombreArchivoOriginal+'/';
    let carpetaVisor = '';
    let url = '';
    if(flagProceso==3){
        carpetaVisor = 'CONTRATO/';
    }else if(flagProceso==2){
        carpetaVisor = 'CORRIDA/';
    }
    if(rescision==1){
        carpetaVisor = 'RESCISIONES/';
    }

    url = url_base+carpetaVisor+nombreArchivo;

    if(flagProceso==3 || rescision==1){
        visorArchivo(url, nombreArchivo);
    }else if(flagProceso==2){
        window.open(url, "_blank");
    }

});