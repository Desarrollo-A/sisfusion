$(document).ready(function () {
    getResidenciales();

    $("#rescision-file-input").on("change", function () {
        let archivo = $(this).siblings("#rescision-file-name");
        let nombre = $(this)[0].files[0].name;
        archivo.val(nombre);
    });
});

let titulos = [];
$('#liberacionesTable thead tr:eq(0) th').each( function (i) {
    let title = $(this).text();
    titulos.push(title);
    $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
    $( 'input', this ).on('keyup change', function () {
        console.log($("#liberacionesTable").DataTable().column(i).search(), this.value)
        if ($('#liberacionesTable').DataTable().column(i).search() !== this.value ) {
            $('#liberacionesTable').DataTable().column(i).search(this.value).draw();
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
})

function closeModal(){
    $('#marcarLiberarModal').modal("hide");
    document.getElementById('msj').innerHTML = '';
    $('#idLote').val('')
    $('#selectTipoLiberacion').val('');
    $('#justificacionMarcarLiberar').val('');
}

function getResidenciales() {
    $("#selectResidenciales").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url + 'General/getResidencialesList',
        type: 'post',
        dataType: 'json',
        success: function (response) {
            for (let i = 0; i < response.length; i++) {
                let id = response[i]['idResidencial'];
                let name = response[i]['descripcion'];
                $("#selectResidenciales").append($('<option>').val(id).text(name));
            }
            $("#selectResidenciales").selectpicker('refresh');
        }
    });
}

function updateLotesStatusLiberacion(e) {
    let idLote = $(generalDataTable.$('input[name="idT[]"]:checked')).map(function () {
        return this.value;
    }).get();
    $.ajax({
        type: 'POST',
        url: general_base_url + 'Contraloria/updateLotesStatusLiberacion',
        data: {
            'idLote': idLote
        },
        dataType: 'json',
        success: function (data) {
            if (data == 0) {
                alerts.showNotification("top", "right", "Los registros han sido actualizados de manera éxitosa.", "success");
                $("#liberacionesTable").DataTable().ajax.reload();
            } else {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
            }
        }, error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
}

function fillTable(idCondominio) {
    generalDataTable = $('#liberacionesTable').dataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true" title="DESCARGAR ARCHIVO DE EXCEL"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'DESCARGAR ARCHIVO DE EXCEL',
                title: 'Liberaciones',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7, 8],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos[columnIdx] + ' ';
                        }
                    }
                }
            }
        ],
        pagingType: "full_numbers",
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
                visible: false,
            },
            {
                data: function (d){
                    return d.nombreResidencial;
                }
            },
            {
                data: function (d){
                    return d.nombre;
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
                    return d.referencia;
                }
            },
            {
                data: function (d) {
                    if(d.nombreCliente == 0 || d.nombreCliente == null)
                    {
                        return 'Sin Cliente';
                    }else{
                        return d.nombreCliente;
                    }
                }
            },
            {
                data: function (d) {
                    return d.fechaApartado ? d.fechaApartado.split('.')[0] : 'Sin fecha';
                }
            },
            {
                data: function (d) {
                    return '<span class="label" style="color:#' + d.colorEstatusContratacion +'; background:#' + d.colorEstatusContratacion + '18;">' + d.estatusContratacion + '</span>';
                }
            },
            {
                data: function (d) {
                    btns = '';
                    return btns = '<div class="d-flex justify-center"><button data-toggle="tooltip" data-placement="left" title="Liberar"'+
                    ' class="btn-data btn-green marcar-para-liberar" data-id-lote="' + d.idLote +'" data-nombre-lote="' + d.nombreLote +'" data-proceso="1"'+
                    ' data-idrol="'+d.id_rol+'"><i class="fas fa-thumbs-up"></i></button></div>';
                }
            }
        ],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox dt-body-center',
            targets: 0,
            searchable: false,
            render: function (d, type, full, meta) {
                return '';
            },
            select: {
                style: 'os',
                selector: 'td:first-child'
            },
        }],
        ajax: {
            url: general_base_url + 'Contraloria/getLiberacionesInformation',
            type: "POST",
            cache: false,
            data: {
                "idCondominio": idCondominio
            }
        }
    });
}

function fillFilesTable(idLote) {
    let tabla_archivos_lotes = $("#archivosDataTable").DataTable({
        width: '100%',
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [],
        pagingType: "full_numbers",
        language: {
            url: general_base_url + "static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        processing: true,
        pageLength: 5,
        bAutoWidth: true,
        bLengthChange: false,
        scrollX: true,
        bInfo: true,
        searching: true,
        ordering: false,
        fixedColumns: true,
        destroy: true,
        columns: [{
            data: function (d) {
                return '<p class="m-0">' + d.nombre_archivo + '</p>';
            }
        },
        {
            data: function (d) {
                return '<div class="d-flex justify-center"><button class="btn-data btn-info see-doc-btn" data-toggle="tooltip" data-placement="left" title= "Visualizar archivo" data-id-archivo="' +d.id_archivo_liberacion+ '"><i class="fas fa-file-alt"></i></button></div>';        
            }
        }],
        columnDefs: [{
            defaultContent: "",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        ajax: {
            url: general_base_url + "Contraloria/get_archivos_lote",
            type: "POST",
            cache: false,
            data: {
                "idLote": idLote,
            }, dataSrc: ''
        },
        initComplete: function(){
            $("#spiner-loader").addClass('hide');
        },
        "order": [
            [1, 'asc']
        ],
    });
    
    $('#archivosDataTable').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
}

function openFilesModal(idLote){
    $("#filesModal").modal('show');
    fillFilesTable(idLote); 
}

function openUploadFileModal(){
    $("#uploadfilesModal").modal('show');
}

function refreshTipoLiberacionesPicker() {
    let fileContainer = document.getElementById("fileContainer");
    if (!fileContainer.classList.contains('d-none')) fileContainer.classList.add('d-none');
    $("#selectTipoLiberacion").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url + 'Contraloria/get_tipo_liberaciones',
        type: 'GET',
        dataType: 'JSON',
        success: function (res) {
            for (let i = 0; i < res.length; i++) {
                let id = res[i]['id_opcion'];
                let tipo = res[i]['nombre_opc'];
                $("#selectTipoLiberacion").append($('<option>').val(id).text(tipo));
            }
            $("#selectTipoLiberacion").selectpicker('refresh');
        }, error: function (e) {
            console.log('error:', e)
        }, catch: function (c) {
            console.log('catch:', c)
        }
    });
}

$(document).on('click', '.remove-mark', function () { // MJ: FUNCIÓN CAMBIO DE ESTATUS ACTIVO / INACTIVO
    $.ajax({
        type: 'POST',
        url: general_base_url + 'Contraloria/removeMark',
        data: {
            'idLote': $(this).attr("data-idLote")
        },
        dataType: 'json',
        success: function (data) {
            if (data == 1) {
                alerts.showNotification("top", "right", "El registro se ha actualizado con éxito.", "success");
                $("#liberacionesTable").DataTable().ajax.reload();
            } else {
                alerts.showNotification(" ", "right", "Oops, algo salió mal.", "warning");
            }
        }, error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$(document).on('click', '.marcar-para-liberar', function(e) {
    e.preventDefault();
    refreshTipoLiberacionesPicker();
    document.getElementById('btnMarcarParaLiberar').disabled = false;
    document.getElementById("rescision-file-input").value = "";
    document.getElementById("rescision-file-name").value = "";
    // Contraloria /marcar-para-liberar
    let proceso = $(this).attr("data-proceso");
    let id_lote = $(this).attr("data-id-lote");
    let nombre_lote = $(this).attr("data-nombre-lote");
    //let id_rol = $(this).attr("data-rol");
    if(proceso == 1){
        document.getElementById('msj').innerHTML = 'Liberación del lote <b>' + id_lote + '</b> con nombre <b>' + nombre_lote + '</b>';
        $('#idLote').val(id_lote)
        $('#marcarLiberarModal').modal('toggle');
    }
});

$(document).on('click', '.delete-btn', function(e) {
    let idArchivoLote = $(this).data('id-archivo');
    console.log("Este es el id del archivo a borrar: ", idArchivoLote);
});

$("#marcarLiberarForm").on('submit', function(e){
    e.preventDefault();
    let idLote = $('#idLote').val();
    let selectTipoLiberacion = $('#selectTipoLiberacion').val();
    let textoSeleccionado = $(this).find("option:selected").text();
    let justificacionMarcarLiberar = $('#justificacionMarcarLiberar').val();
    let archivo = document.getElementById('rescision-file-input');
    let hacerUpdate = 0;

    if (!idLote){
        return alerts.showNotification('top', 'right', '¡Algo salió mal, intentalo de nuevo!', 'warning');
    } else if (selectTipoLiberacion == '') {
        return alerts.showNotification('top', 'right', '¡Falta seleccionar el tipo de liberación!', 'warning');
    } else if (justificacionMarcarLiberar.length == 0 || justificacionMarcarLiberar == '') {
        return alerts.showNotification('top', 'right', '¡Falta por llenar el campo de comentarios!', 'warning');
    } else if (selectTipoLiberacion == '1' && textoSeleccionado == 'Rescisión') {
        if (!archivo.files.length > 0) {
            return alerts.showNotification('top', 'right', '¡Anexa el archivo de rescisión!', 'warning');
        }else{
            // Es rescisión y necesita archivo
            hacerUpdate = 1;
        }
    }else if (selectTipoLiberacion == '2' && textoSeleccionado == 'Devolución'){
        //Es devolución
        hacerUpdate = 1;
    }else {
        return alerts.showNotification('top', 'right', 'ops, algo salió mal, intentalo de nuevo', 'danger');
    }

    if (hacerUpdate === 1) {
        document.getElementById('btnMarcarParaLiberar').disabled = true;
        $.ajax({
            url: general_base_url + 'Contraloria/updateLoteMarcarParaLiberar',
            type: 'POST',
            data: {
                'idLote': idLote,
                'tipoLiberacion': selectTipoLiberacion,
                'justificacion': justificacionMarcarLiberar,
                'archivo': archivo.files.length > 0 ? '' : '',
            },
            dataType: 'JSON',
            success: function (response) {
                console.log("Response: ", response);
                
                if(response == true){
                    closeModal();
                    $("#liberacionesTable").DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El registro se ha actualizado con éxito.", "success");
                }else if(response == false){
                    document.getElementById('btnMarcarParaLiberar').disabled = true;
                    alerts.showNotification('top', 'right', 'ops, algo salió mal, intentalo de nuevo', 'danger');
                } else {
                    document.getElementById('btnMarcarParaLiberar').disabled = true;
                    alerts.showNotification('top', 'right', 'ops, algo salió mal, intentalo de nuevo', 'danger');
                }
            },
            error: function (e) {
                console.log('catch',e);
                document.getElementById('btnMarcarParaLiberar').disabled = true;
                alerts.showNotification('top', 'right', 'ops, algo salió mal, intentalo de nuevo', 'danger');
            }
        });
    }
});

$('#liberacionesTable').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});

$('#selectTipoLiberacion').change(function () {
    let fileContainer = document.getElementById("fileContainer");

    let valorSeleccionado = $(this).val();
    let textoSeleccionado = $(this).find("option:selected").text();

    if (valorSeleccionado === "1" && textoSeleccionado === 'Rescisión') {
        if (fileContainer.classList.contains('d-none')) fileContainer.classList.remove('d-none'); // Para ocultar el fragmento
    }else if (valorSeleccionado === "1" && textoSeleccionado != 'Rescisión'){
        if (!fileContainer.classList.contains('d-none')) fileContainer.classList.add('d-none'); // Para ocultar el fragmento
    }else {
        if (!fileContainer.classList.contains('d-none')) fileContainer.classList.add('d-none'); // Para ocultar el fragmento
    }
});

$('#selectResidenciales').change(function () {
    let idResidencial = $(this).val();
    $("#selectCondominios").empty().selectpicker('refresh');
    let postData = "idResidencial=" + idResidencial;
    $.ajax({
        url: general_base_url + 'General/getCondominiosList',
        type: 'post',
        data:postData,
        dataType: 'JSON',
        success: function (response) {
            for (let i = 0; i < response.length; i++) {
                let id = response[i]['idCondominio'];
                let name = response[i]['nombre'];
                $("#selectCondominios").append($('<option>').val(id).text(name));
                // $('#liberacionesTable').removeClass('hide');
                // fillTable(idResidencial);
            }
            $("#selectCondominios").selectpicker('refresh');
        }
    });
});

$('#selectCondominios').change(function () {
    let idCondominio = $(this).val();
    $('#liberacionesTable').removeClass('hide');
    fillTable(idCondominio);
});