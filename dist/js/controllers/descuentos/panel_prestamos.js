var totaPen = 0;
var tr;
var valorGlobal = 3; 
var banderaNewEvidencia = 2; 
var datosDataTable = [];

$(document).ready(function () {
 
    llenado();
});

function llenado(){
    $("#tipo")
    $("#tipo").selectpicker('refresh'); 

    $.post(general_base_url + "/Descuentos/lista_estatus_descuentos", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#tipo").append($('<option>').val(id).text(name));     
        }
        $("#tipo").selectpicker('refresh');
    }, 'json');
}

function MostrarArchivo(tipo){
    var com2 = new FormData(); 
        com2.append("id_opcion", tipo);
    $.ajax({
        url: 'idOpcionMotivosRelacionPrestamos',
        data: com2,
        method: 'POST',
        contentType: false,
        cache: false,
        dataType: 'JSON',
        processData: false,
        success: function (data) {
            if(data.evidencia === true || data.evidencia === 'true'){
                $('#evidenciaDIVarchivo').removeClass('hide');      
                valorGlobal  = 1 ;
            }else if(data.evidencia === ''){
                $('#evidenciaDIVarchivo').addClass('hide');
                valorGlobal  = 0 ;
            }else{
                let cordinador = data.evidencia.split(".",2);
                for(let i = 0;cordinador.length > i; i++)
                {
                    if(cordinador[i] == 'pdf' || cordinador[i] == 'PDF'  ){
                        $('#evidenciaDIVarchivo').addClass('hide');
                        valorGlobal  = 0 ;
                    }
                }
            }
        },  
        error: function () { alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");  }
    });
}

$('#tipo').change(function (ruta) {
    $('#spiner-loader').removeClass('hide');
    // document.getElementById("users").innerHTML = '';    
    tipo = $('#tipo').val();
    let m = $('#monto').val();
    let texto = '';
    MostrarArchivo(tipo);
    if (tipo == 18) {
        texto = 'Esté es un pago recurrente, el cual se hará cada mes hasta cubrir el monto prestado.'
        document.getElementById("numeroP").value = 1;
        if (m != '') {verificar();}
    } else {
        texto = 'Esté es un pago único que se hará en una sola exhibición.'
        document.getElementById("numeroP").value = 1;
        if (m != '') {verificar();}
    }
    
    document.getElementById("texto").innerHTML = texto;
    $('#spiner-loader').addClass('hide');
});

function closeModalEng() {
    document.getElementById("form_prestamos").reset();
    $("#tipo").selectpicker("refresh");
    $("#roles").selectpicker("refresh");
    document.getElementById("users").innerHTML = '';
    $("#miModal").modal('toggle');
}

function replaceAll(text, busca, reemplaza) {
    while (text.toString().indexOf(busca) != -1)
        text = text.toString().replace(busca, reemplaza);
    return text;
}

$("#form_prestamos").on('submit', function (e) {

    e.preventDefault();
    
    let formData = new FormData(document.getElementById("form_prestamos"));
    banderaEvidencia = document.getElementById("banderaEvidencia").value;
    formData.append("banderaEvidencia", valorGlobal);
    let uploadedDocument = $("#evidencia")[0].files[0];
    let validateUploadedDocument = (uploadedDocument == undefined) ? 0 : 1;
    // SE VALIDA QUE HAYA SELECCIONADO UN ARCHIVO ANTES DE LLEVAR A CABO EL REQUEST
    if (validateUploadedDocument == 0  && banderaEvidencia != 0) alerts.showNotification("top", "right", "Asegúrese de haber seleccionado un archivo antes de guardar.", "warning");
    else sendRequestPermission = 1; // PUEDE MANDAR EL REQUEST PORQUE SÍ HAY ARCHIVO SELECCIONADO
    if(uploadedDocument == undefined && banderaEvidencia == 0 ){

    }
    $.ajax({
        url: 'savePrestamo',
        data: formData,
        method: 'POST',
        contentType: false,
        cache: false,
        processData: false,
        dataType: 'JSON',
        success: function (data) {
            alerts.showNotification("top", "right", "" + data.message + "", "" + data.response_type + "");
            $('#miModal').modal('hide')
            document.getElementById("form_prestamos").reset();
            $('#tabla_prestamos').DataTable().ajax.reload(null, false);
            $('#form_prestamos').trigger('reset');

            $("#usuarioid").selectpicker('refresh');

            $("#tipo").selectpicker('refresh');
            $("#roles").selectpicker('refresh');
            // if (data == 1) {
            //    
            //     closeModalEng();
            //     $('#miModal').modal('hide');
            //     alerts.showNotification("top", "right", "Préstamo registrado con éxito.", "success");
            // } else if (data == 2) {
            //     $('#tabla_prestamos').DataTable().ajax.reload(null, false);
            //     closeModalEng();
            //     $('#miModal').modal('hide');
            //     alerts.showNotification("top", "right", "Pago liquidado.", "warning");
            // } else if (data == 3) {
            //     closeModalEng();
            //     $('#miModal').modal('hide');
            //     alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un préstamo activo.", "warning");
            // }
            // else if (data == 4) {
            //     closeModalEng();
            //     $('#miModal').modal('hide');
            //     alerts.showNotification("top", "right", "Erro al subir el archivo activo.", "warning");
            // }
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            document.getElementById("form_prestamos").reset();
            $('#miModal').modal('hide')
            $('#form_prestamos').trigger('reset');
            $("#usuarioid").selectpicker('refresh');

            $("#tipo").selectpicker('refresh');
            $("#roles").selectpicker('refresh');
        }
    });
});

$("#form_delete").on('submit', function (e) {
    e.preventDefault();
    let formData = new FormData(document.getElementById("form_delete"));
    $.ajax({
        url: 'BorrarPrestamo',
        data: formData,
        method: 'POST',
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            
            if (data == 1) {
                $('#tabla_prestamos').DataTable().ajax.reload(null, false);
                $('#myModalDelete').modal('hide');
                alerts.showNotification("top", "right", "Préstamo eliminado con éxito.", "success");
                document.getElementById("form_delete").reset();
            } else {
                $('#myModalDelete').modal('hide');
                alerts.showNotification("top", "right", "Error.", "warning");
            }
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$("#tabla_prestamos").ready(function () {
    let titulos = [];
    $('#tabla_prestamos thead tr:eq(0) th').each(function (i) {
        var title = $(this).text();
        titulos.push(title);
        $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {

            if (tablaPrestamos.column(i).search() !== this.value) {
                tablaPrestamos.column(i).search(this.value).draw();
                var total = 0;
                var totalAbonado = 0;
                var totalPendiente = 0;
                var index = tablaPrestamos.rows({ selected: true, search: 'applied' }).indexes();
                var data = tablaPrestamos.rows(index).data();

                $.each(data, function (i, v) {
                    total += parseFloat(v.monto);
                    totalPendiente += v.monto - v.total_pagado;

                    if (v.total_pagado == null) {
                        totalAbonado += 0;
                    } else {
                        totalAbonado += parseFloat(v.total_pagado);
                    }
                });
                var to1 = formatMoney(total);
                var to2 = formatMoney(totalAbonado);
                var to3 = formatMoney(totalPendiente);
                // alert(13)
                texto1 = "totalPendiente";
                texto2 = "totalp";
                texto3 = "totalAbonado";
                
                // count(totalPendiente,texto3)
                document.getElementById("totalPendiente").textContent = to3;
                document.getElementById("totalp").textContent = to1;
                document.getElementById("totalAbonado").textContent = to2;
            }
        });
    });

    $('#tabla_prestamos').on('xhr.dt', function (e, settings, json, xhr) {
        var total = 0;
        var total2 = 0;
        var total3 = 0;

        $.each(json.data, function (i, v) {
            total += parseFloat(v.monto);
            total3 += v.monto - v.total_pagado;

            if (v.total_pagado == null) {
                total2 += 0;
            } else {
                total2 += parseFloat(v.total_pagado);
            }
        });

        var to = formatMoney(total);
        var to2 = formatMoney(total2);
        var to3 = formatMoney(total3);
        texto1 = "totalPendiente";
        texto2 = "totalp";
        texto3 = "totalAbonado";
        // alert(12)
        // count(total,total2,total3 )
        document.getElementById("totalPendiente").textContent = to3;
        document.getElementById("totalp").textContent = to;
        document.getElementById("totalAbonado").textContent = to2;
    });

    tablaPrestamos = $("#tabla_prestamos").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'PRÉSTAMOS Y PENALIZACIONES',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 9, 10, 11,12],
                format: {
                    header: function (d, columnIdx) {
                        if (columnIdx >= 0) {
                            return ' ' + titulos[columnIdx] + ' ';
                        }
                    }
                }
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: general_base_url + "/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        scrollX: true,
        destroy: true,
        ordering: false,
        columns: [
        { data: 'id_prestamo'},
        { data: 'id_usuario'},
        { data: 'nombre'},
        {
            data: function (d) {
                let formato
                formato = `<p class="m-0">${formatMoney(d.monto)} </p> `;
                return formato;
            }
        },
        {data: 'num_pagos'},
        {
            data: function (d) {
                let formato
                formato = `<p class="m-0">${formatMoney(d.pago_individual)} </p> `;
                return formato;
            }
        },
        {
            data: function (d) {
                let formato
                formato = `<p class="m-0">${formatMoney(d.total_pagado)} </p> `;
                return formato;
            }
        },
        {
            data: function (d) {
                let color = 'lbl-gral';
                let resultado = d.monto - d.total_pagado;
                if (resultado > 0.5) {
                    color = 'lbl-orangeYellow';
                }
                if (resultado < 0.0) {
                    resultado = 0;
                }
                return '<span class="m-0 ' + color + '">' + formatMoney(resultado) + '</span>';
            }
        },
        { 
            data: function (d) { return '<p class="m-0">'+d.comentario+'</p>' ;}
        },
        { 
            data: function( d){         
                const letras = d.comentario.split(" ");
                if(letras.length <= 4)
                {

                    return '<p class="m-0">'+d.comentario+'</p>';
                }else{
                    
                    letras[2] = undefined ? letras[2] = '' : letras[2];
                    letras[3] = undefined ? letras[3] = '' : letras[3];
                    return `    
                        <div class="muestratexto${d.id_prestamo}" id="muestratexto${d.id_prestamo}">
                            <p class="m-0">${letras[0]} ${letras[1]} ${letras[2]} ${letras[3]}....</p> 
                            <a href='#' data-toggle="collapse" data-target="#collapseOne${d.id_prestamo}" 
                                onclick="esconder(${d.id_prestamo})" aria-expanded="true" aria-controls="collapseOne${d.id_prestamo}">
                                <span class="lbl-blueMaderas">Ver más</span> 
                                
                            </a>
                        </div>
                        <div id="collapseOne${d.id_prestamo}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                ${d.comentario}</p> 
                                <a href='#'  data-toggle="collapse" data-target="#collapseOne${d.id_prestamo}" 
                                    onclick="mostrar(${d.id_prestamo})" aria-expanded="true" aria-controls="collapseOne${d.id_pago_i}">
                                    <span class="lbl-blueMaderas">Ver menos</span> 
                                </a>
                            </div>
                        </div>
                    `;
                }
            }
        },
        {
            data: function (d) {
                    return `<span class="label ${d.colorP}" >${d.estatusPrestamo}</span>`;
                
            }
        },
        {
            "data": function (d) {
                let etiqueta = '';
                color = 'lbl-blueMaderas';

                if (d.id_opcion == 18) { 
                    color = 'lbl-green';
                } else if (d.id_opcion == 19) {
                    color = 'lbl-azure';
                } else if (d.id_opcion == 20) { 
                    color = 'lbl-sky';
                } else if (d.id_opcion == 21) {
                    color = 'lbl-violetDeep';
                } else if (d.id_opcion == 22) {
                    color = 'lbl-violetDeep';
                } else if (d.id_opcion == 23) { 
                    color = 'lbl-violetChin';
                } else if (d.id_opcion == 24) {
                    color = 'lbl-orangeYellow';
                } else if (d.id_opcion == 25) { 
                    color = 'lbl-acidGreen';
                } else if (d.id_opcion == 26) {
                    color = 'lbl-gray';
                }
                return '<p><span class="label ' + color + '" >' + d.tipo + '</span></p>';
            }
        },
        {
            data: function (d) {
                
                if (d.fecha_creacion_referencia !== null && d.estatus == 1) {
                    const fecha = new Date(d.fecha_creacion_referencia);
                    const now = new Date();
                    const mesesDif = monthDiff(fecha, now);

                    if (mesesDif >= 2) {
                        return `<p> ${d.fecha_creacion_referencia.split('.')[0]} <span class="label" style="background: orange">Sin saldo en ${mesesDif} meses</label></p>`;
                    }
                }
                return '<p class="m-0">' + d.fecha_creacion.split('.')[0] + '</p>';
            }
        },
        {
            "orderable": false,
            data: function (d) {
                var botonesModal = '';

                if (d.id_prestamo2 == null && d.estatus == 1 && d.id_opcion != 28) {
                    botonesModal += `
                        <button href="#" value="${d.id_prestamo}" data-name="${d.nombre}" class="btn-data btn-warning delete-prestamo" 
                        title="Eliminar">
                            <i class="fas fa-trash">
                            </i>
                        </button>`;
                }

                if (d.estatus == 1 && d.total_pagado == null && d.id_opcion != 28 ) {
                    botonesModal += `
                        <button href="#" value="${d.id_prestamo}" data-idPrestamo="${d.id_prestamo}" 
                            data-tipo="${d.tipo}" data-idtipo="${d.id_opcion}"  data-name="${d.nombre}" data-comentario="${d.comentario}" 
                            data-individual="${d.pago_individual}" data-npagos="${d.num_pagos}" data-monto="${d.monto}" 
                            class="btn-data btn-sky edit-prestamo" title="Editar">
                            <i class="fas fa-pen-nib">
                            </i>
                        </button>`;
                }
                if(d.relacion_evidencia != '' ){
                    if(d.relacion_evidencia != 'true' ){
                        botonesModal += `
                        <button href="#" value="${d.id_prestamo}"  id="preview" 
                        data-ruta="UPLOADS/EvidenciaGenericas"
                        data-doc="${d.relacion_evidencia}"   
                        class="btn-data btn-orangeLight " title="Ver Evidencia">
                            <i class="fas fa-folder-open">
                            </i>
                        </button>`; 
                        }   else if(d.evidencia != null){
                            botonesModal += `
                            <button href="#" value="${d.id_prestamo}"  id="preview" data-doc="${d.evidencia}"  
                            data-ruta="static/documentos/evidencia_prestamo_auto" 
                            class="btn-data btn-violetDeep " title="Ver Evidencia">
                                <i class="fas fa-folder-open">
                                </i>
                            </button>`; 
                            }else{
                                botonesModal += ``; 
                            }
                    }
                if (d.total_pagado != null || d.total_pagado > 0) {
                    botonesModal += `
                        <button href="#" value="${d.id_prestamo}" 
                            class="btn-data btn-blueMaderas detalle-prestamo" title="Historial">
                            <i class="fas fa-info">
                            </i>
                        </button>`;
                        botonesModal += d.estatus == 1 ? `
                        <button href="#" value="${d.id_prestamo}" 
                            class="btn-data btn-warning toparPrestamo" title="Topar préstamo">
                            <i class="fas fa-ban">
                            </i>
                        </button>` : '';
                }

                return '<div class="d-flex justify-center">' + botonesModal + '<div>';
            }
        }],
        columnDefs: [{
            targets: [8], visible: false,
            searchable:true,
            }],
        ajax: {
            url: general_base_url + "Descuentos/getPrestamos",
            type: "POST",
            cache: false,
            data: function (d) {
            }
        },
    });
    
    $('#tabla_prestamos tbody').on('click', '.delete-prestamo', function () {
        const idPrestamo = $(this).val();
        const nombreUsuario = $(this).attr("data-name");
        const Modalbody = $('#myModalDelete .modal-body');
        const Modalfooter = $('#myModalDelete .modal-footer');
        Modalbody.html('');
        Modalfooter.html('');
        Modalbody.append(`
            <input type="hidden" value="${idPrestamo}" name="idPrestamo" id="idPrestamo"> 
                <h4 class="lbl-orangeYellow center-align">¿Está seguro que desea borrar el préstamo de <br>  ${nombreUsuario} ?
                </h4>`);
        Modalfooter.append(`
            <button type="button"  class="btn btn-danger btn-simple " data-dismiss="modal" >
                Cerrar
            </button>
			<button  type="submit" name=/"disper_btn"  id="dispersar" class="btn btn-primary">
                Aceptar
            </button>`);
        $("#myModalDelete").modal();
    });
$('#tabla_prestamos tbody').on('click', '.toparPrestamo', function () {
    datosDataTable = [];
    datosDataTable = tablaPrestamos.row($(this).parents('tr')).data();
    $('#modalAlert').modal('show');
});
$('#formTopar').on('submit', function (e) {
    $('#spiner-loader').removeClass('hide');
    document.getElementById('btnTopar').disabled = true;
    e.preventDefault();
    if(datosDataTable.length == 0)
        return false;
    else
    $.post('toparPrestamo',{id_prestamo:datosDataTable.id_prestamo,pagado:datosDataTable.total_pagado}, function (data) {
        datosDataTable = [];
        data = JSON.parse(data);
        alerts.showNotification("top", "right", "" + data.message + "", "" + data.response_type + "");
        $('#tabla_prestamos').DataTable().ajax.reload(null, false);
        $('#modalAlert').modal('toggle');
        $('#spiner-loader').addClass('hide');
    });
    document.getElementById('btnTopar').disabled = false;
});


    $('#tabla_prestamos tbody').on('click', '.edit-prestamo', function () {
        const idPrestamo = $(this).val();
        const prestamoId = $(this).attr("data-idPrestamo");
        const montoPagos = $(this).attr("data-individual");
        const nombreUsuario = $(this).attr("data-name");
        const numeroPagos = $(this).attr("data-npagos");
        const pagoEdit = $(this).attr("data-monto");
        const comentario = $(this).attr("data-comentario");
        const tipo = $(this).attr("data-tipo");
        const id_tipo = $(this).attr("data-idtipo");

        document.getElementById("montoPagos").value = '';
        document.getElementById("numeroPagos").value = '';
        document.getElementById("pagoEdit").value = '';
        document.getElementById("informacionText").value = '';
        document.getElementById("prestamoId").value = '';

        $("#tipoD").val(id_tipo).selectpicker('refresh');
        
        document.getElementById("montoPagos").value = pagoEdit;
        document.getElementById("numeroPagos").value = numeroPagos;
        document.getElementById("pagoEdit").value = montoPagos;
        document.getElementById("informacionText").value = comentario;
        document.getElementById("prestamoId").value = prestamoId;
    
        $("#ModalEdit").modal();
    });
    $(document).on("click", ".updatePrestamo", function () {

        montoPagos = document.getElementById("montoPagos").value;
        numeroPagos = document.getElementById("numeroPagos").value;
        pagoEdit = document.getElementById("pagoEdit").value;
        comentario = document.getElementById("informacionText").value;
        prestamoId = document.getElementById("prestamoId").value;
        tipoD      = document.getElementById("tipoD").value;
        bandera_request = comentario == '' ? false : true;
        pagoEdit = pagoEdit.replace(/,/g, "");
        pagoEdit = pagoEdit.replace(/[$]/g,'');
        montoPagos = montoPagos.replace(/,/g, "");
        montoPagos = montoPagos.replace(/[$]/g,'');
        numeroPagos = numeroPagos.replace(/,/g, "");
        numeroPagos = numeroPagos.replace(/[$]/g,'');
        if (pagoEdit != '' && numeroPagos != '' && montoPagos != '' && comentario != '' && prestamoId != '' && bandera_request) {
            if (pagoEdit > 0 && montoPagos > 0 && numeroPagos > 0) {
                $.ajax({
                    url: 'updatePrestamos',
                    type: 'POST',
                    dataType: "json",
                    data: {
                        "tipoD":    tipoD,
                        "pagoEdit": parseInt(pagoEdit),
                        "numeroPagos": parseInt(numeroPagos),
                        "montoPagos": parseInt(montoPagos),
                        "comentario": comentario,
                        "prestamoId": prestamoId,
                    },
                    success: function (data) {
                        alerts.showNotification("top", "right", "" + data.message + "", "" + data.response_type + "");
                        $('#tabla_prestamos').DataTable().ajax.reload(null, false);
                        $('#ModalEdit').modal('toggle');
                    },
                    error: (a, b, c) => {
                        alerts.showNotification("top", "right", "Descuento No actualizado .", "error");
                    }
                });
            } else {
                alerts.showNotification("top", "right", "Asegúrese que no existan valores negativos.", "warning");
            }
        } else {
            alerts.showNotification("top", "right", "Es necesario revisar que no se tenga valores vacios.", "error");
        }
    });

    $('#montoPagos').change(function () {
        const bandera = true;
        Monto = document.getElementById("montoPagos").value;
        numeroPagos = document.getElementById("numeroPagos").value;
        mensualidades = document.getElementById("pagoEdit").value;
        comentario = document.getElementById("informacionText").value;
        var input1=  document.getElementById('montoPagos');
        var input2=  document.getElementById('numeroPagos');
        
        input1.addEventListener('input',function(){

        if (this.value.length > 12) 
            this.value = this.value.slice(0,12); 
        })
        input2.addEventListener('input',function(){

            if (this.value.length > 3) 
                this.value = this.value.slice(0,3); 
            })

        if (numeroPagos == null || numeroPagos == '') {
            bandera = false;
        }

        if (Monto == null || Monto == '') {
            bandera = false;
        }

        if (bandera) {
            NuevasMensualidades = Monto / numeroPagos;
            document.getElementById("pagoEdit").value = (formatMoney(NuevasMensualidades.toFixed(3)));
        } else {
            alerts.showNotification("top", "right", "Todos los campos deben de estar llenos.", "error");

        }
    });
    $('#numeroPagos').change(function () {
        const bandera = true;
        Monto = document.getElementById("montoPagos").value;
        numeroPagos = document.getElementById("numeroPagos").value;
        mensualidades = document.getElementById("pagoEdit").value;
        comentario = document.getElementById("informacionText").value;
        var input1=  document.getElementById('montoPagos');
        var input2=  document.getElementById('numeroPagos');

        input1.addEventListener('input',function(){

        if (this.value.length > 12) 
            this.value = this.value.slice(0,12); 
        })
        input2.addEventListener('input',function(){

            if (this.value.length > 3) 
                this.value = this.value.slice(0,3); 
            })

        if (numeroPagos == null || numeroPagos == '') {
            bandera = false;
        }

        if (Monto == null || Monto == '') {
            bandera = false;
        }

        if (bandera) {
            NuevasMensualidades = Monto / numeroPagos;
            document.getElementById("pagoEdit").value = (formatMoney(NuevasMensualidades.toFixed(3)));
        } else {
            alerts.showNotification("top", "right", "Todos los campos deben de estar llenos.", "error");
        }
    });

    $('#tabla_prestamos tbody').on('click', '.detalle-prestamo', function () {
        $('#spiner-loader').removeClass('hide');
        const idPrestamo = $(this).val();
        let importacion = '';
        $.getJSON(`${general_base_url}Comisiones/getDetallePrestamo/${idPrestamo}`).done(function (data) {
            
            const { general, detalle } = data;
            $('#spiner-loader').addClass('hide');

            if (detalle.length == 0) {
                alerts.showNotification("top", "right", "Este préstamo no tiene pagos aplicados.", "warning");
            } else {
                const detalleHeaderModal = $('#detalle-prestamo-modal .modal-header');
                const detalleBodyModal = $('#detalle-prestamo-modal .modal-body');
                const importaciones = [20, 19, 18, 17, 16, 15, 14, 13, 12, 11];

                if (importaciones.indexOf(parseInt(idPrestamo)) >= 0) {
                    importacion = 'Importación contraloría';
                }
                detalleHeaderModal.html('');
                detalleBodyModal.html('');
                let numPagosReal = general.num_pago_act == general.num_pagos ? general.num_pago_act : general.num_pago_act - 1;

                detalleHeaderModal.append(`<h4 class="card-title"><b>Detalle del préstamo</b><br><p>${importacion}</p></h4>`);
                detalleBodyModal.append(`<div class="row">
                        <div class="col col col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <h6>USUARIO: <b>${general.nombre_completo}</b></h6>
                        </div>
                        <div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <h6>PAGO MENSUAL: <b>${formatMoney(general.pago_individual)}</b></h6>
                        </div>
                        <div class="col col-xs-12 col-sm-2 col-md-2 col-lg-2">
                            <h6>PAGOS APLICADOS: <b>${numPagosReal}</b></h6>
                        </div>
                        <div class="col col-xs-12 col-sm-2 col-md-2 col-lg-2">
                            <h6>MENSUALIDADES: <b>${general.num_pagos}</b></h6>
                        </div>
                        <div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <h6>MONTO PRESTADO: <b>${formatMoney(general.monto_prestado)}</b></h6>
                        </div>
                        <div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <h6>ABONADO: <b style="color:green;">${formatMoney(general.total_pagado)}</b></h6>
                        </div>
                        <div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <h6>PENDIENTE: <b style="color:orange;">${formatMoney(general.pendiente)}</b></h6>
                        </div>
                    </div>`);

                let htmlTableBody = '';
                for (let i = 0; i < detalle.length; i++) {
                    htmlTableBody += '<tr>';
                    htmlTableBody += `<td scope="row">${general.nombre_completo}</td>`;
                    htmlTableBody += `<td scope="row">${detalle[i].sede}</td>`;
                    htmlTableBody += `<td scope="row">${detalle[i].tipo}</td>`;
                    htmlTableBody += `<td scope="row"><b>${detalle[i].np}</b></td>`;
                    htmlTableBody += `<td scope="row">${detalle[i].nombreResidencial}</td>`;
                    htmlTableBody += `<td>${detalle[i].nombreLote}</td>`;
                    htmlTableBody += `<td scope="row"><b>${detalle[i].id_pago_i}</b></td>`;
                    htmlTableBody += `<td style="width:50% !important;">${detalle[i].comentario}</td>`;
                    htmlTableBody += `<td style="width:20% !important;">${detalle[i].fecha_pago}</td>`;
                    htmlTableBody += `<td><b>${formatMoney(detalle[i].abono_neodata)}</b></td>`;
                    htmlTableBody += `<td style="width:20% !important;">${detalle[i].estatus}</td>`;
                    htmlTableBody += '</tr>';
                }

                detalleBodyModal.append(`<table class="table table-striped table-hover" id="table_detalles">
                        <thead>
                            <tr>
                                <th>USUARIO</th>
                                <th>SEDE</th>
                                <th>TIPO</th>
                                <th>NUMERO</th>
                                <th>PROYECTO</th>
                                <th>LOTE</th>
                                <th>ID PAGO</th>
                                <th>COMENTARIO</th>
                                <th>FECHA</th>
                                <th>MONTO</th>
                                <th>ESTATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${htmlTableBody}
                        </tbody>
                    </table>`);

                $("#detalle-prestamo-modal").modal();

                let titulos2 = [];
                $('#table_detalles thead tr:eq(0) th').each(function (i) {
                    var title = $(this).text();
                    titulos2.push(title);
                    $(this).html('<input type="text" data-toggle="tooltip" data-placement="top" placeholder="' + title + '" title="' + title + '"/>');
                    $('input', this).on('keyup change', function () {
                        if (tableDetalles.column(i).search() !== this.value) {
                            tableDetalles.column(i).search(this.value).draw();
                        }
                    });
                });

                var tableDetalles = $('#table_detalles').DataTable({
                    dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
                    width: "100%",
                    scrollX: true,
                    bAutoWidth:true,
                    buttons: [{
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                        className: 'btn buttons-excel',
                        titleAttr: 'Descargar archivo de Excel',
                        title: 'PRÉSTAMOS Y PENALIZACIONES',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                            format: {
                                header: function (d, columnIdx) {
                                    return ' ' + titulos2[columnIdx] + ' ';
                                }
                            }
                        }
                    }],
                    ordering: false,
                    "pageLength": 5,
                    "lengthMenu": [5, 10, 25, 50, 75, 100],
                    language: {
                        url: general_base_url + "/static/spanishLoader_v2.json",
                        paginate: {
                            previous: "<i class='fa fa-angle-left'>",
                            next: "<i class='fa fa-angle-right'>"
                        }
                    }
                });
                tableDetalles.order([0, 'desc']).draw();
            }
        })
    });
});

$('#table_detalles').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
});

$(window).resize(function () {
    tablaPrestamos.columns.adjust();
});

$("#roles").change(function () {
    var parent = $(this).val();
    document.getElementById("users").innerHTML = '';

    $('#users').append(` <label class="label control-label">Usuario</label>   
    <select id="usuarioid" name="usuarioid" class="selectpicker m-0 select-gral directorSelect ng-invalid ng-invalid-required" title="SELECCIONA UNA OPCIÓN" required data-live-search="true"></select>`);
    $.post('getUsuariosRol/' + parent + '/1', function (data) {
        var len = data.length;

        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['id_usuario'] +' - '+ data[i]['name_user'];
            $("#usuarioid").append($('<option>').val(id).attr('data-value', id).text(name));
        }

        if (len <= 0) {
            $("#usuarioid").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }

        $("#usuarioid").selectpicker('refresh');
    }, 'json');
});

function verificar() {
    var input1=  document.getElementById('monto');
    var input2=  document.getElementById('numeroP');
    let monto = parseFloat(replaceAll($('#monto').val(), ',', ''));
    input1.addEventListener('input',function(){

        if (this.value.length > 12) 
            this.value = this.value.slice(0,12); 
        })
        input2.addEventListener('input',function(){
            if (this.value.length > 3) 
                this.value = this.value.slice(0,3); 
            })
            
    if ($('#numeroP').val() != '') {
        if (monto < 1 || isNaN(monto)) {
            alerts.showNotification("top", "right", "Debe ingresar un monto valido.", "warning");
            document.getElementById('btn_abonar').disabled = true;
        }
        else {
            let cantidad = parseFloat(replaceAll($('#numeroP').val(), ',', ''));
            resultado = parseFloat(monto / cantidad);
            $('#pago').val(formatMoney(parseFloat(resultado)));
            document.getElementById('btn_abonar').disabled = false;
        }
    }

}
$(document).on('input', '.monto', function () {
    verificar();
});

$(document).on("click", "#preview", function () {
    var itself = $(this);
    Shadowbox.open({
        content: `<div>
                    <iframe style="overflow:hidden;width: 100%;height: 100%; 
                                    position:absolute;z-index:999999!important;" 
                                    src="${general_base_url}${itself.attr('data-ruta')}/${itself.attr('data-doc')}">
                    </iframe>
                </div>`,
        player: "html",
        title: `Visualizando archivo: evidencia `,
        width: 985,
        height: 660
    });
});

function monthDiff(dateFrom, dateTo) {
    return dateTo.getMonth() - dateFrom.getMonth() + (12 * (dateTo.getFullYear() - dateFrom.getFullYear()))
}


function esconder(id){
    // alert(1331)
    $('#muestratexto'+id).addClass('hide');
    // $('#muestratexto'+id).removeClass('hide');
    
}


function mostrar(id){
    // $('#muestratexto'+id).addClass('hide');
    $('#muestratexto'+id).removeClass('hide');
    
}


// function NuevoMotivo(){
//     alert (444);
// }
    var valorCheck = ''; 
    $('#nombreSwitch').change(function () {
        valorCheck = this.checked;
        if (this.checked) {
            $('#noTexto').addClass('hide');
            $('#siTexto').removeClass('hide');
            $('#evidenciaSwitchDIV').addClass('hide');

            $('#noTextoDescripcion').addClass('hide');
            $('#siTextoDescripcion').removeClass('hide');
            // alert ('rojo');
        }else{

            $('#siTexto').addClass('hide');
            $('#noTexto').removeClass('hide');
            $('#evidenciaSwitchDIV').removeClass('hide');

            $('#noTextoDescripcion').removeClass('hide');
            $('#siTextoDescripcion').addClass('hide');
            // alert ('azul');
        }
        
    })
    var valorCheckGeneral = ''; 
    $('#nombreSwitchGeneral').change(function () {
        valorCheckGeneral = this.checked;
        if (this.checked) {
            $('#noTextoGeneral').addClass('hide');
            $('#siTextoGeneral').removeClass('hide');
           
            
            // alert ('azul');
        }else{
            $('#siTextoGeneral').addClass('hide');
            $('#noTextoGeneral').removeClass('hide');
            
            // alert ('gris');
        }
        
    })
 
    $(document).on("click", ".addMotivos", function () {
        
        if(valorCheck == undefined || valorCheck == ''  )
        {
            valorCheck = 'false'
        }
        if(valorCheck == true  )
        {
            valorCheck = 'true'
        }
        
        MotivoAlta = document.getElementById("MotivoAlta").value;
        nombreSwitch = document.getElementById("nombreSwitch").value;
        descripcionAlta = document.getElementById("descripcionAlta").value;

        textoPruebas = document.getElementById("body").value;
        var com2 = new FormData();
        let uploadedDocument = $("#evidenciaSwitch")[0].files[0];
        alert
        com2.append("evidencia", uploadedDocument);
        com2.append("MotivoAlta", MotivoAlta); 
        com2.append("valorCheck", valorCheck); 
        com2.append("descripcionAlta", descripcionAlta); 
        com2.append("textoPruebas", textoPruebas); 
        // evidenciaSwitch
        if(MotivoAlta != '' && nombreSwitch != '' && descripcionAlta != '' ){
            $.ajax({
                url: 'altaMotivo',
                data: com2,
                method: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'JSON',
                success: function (data) {
                    llenado();
                    $("#ModalAddMotivo").modal('toggle');
                    alerts.showNotification("top", "right", "" + data.message + "", "" + data.response_type + "");
                    document.getElementById("claveNuevoMotivo").reset();

                    $('#siTexto').addClass('hide');
                    $('#noTexto').removeClass('hide');
                    $('#evidenciaSwitchDIV').removeClass('hide');

                    $('#noTextoDescripcion').removeClass('hide');
                    $('#siTextoDescripcion').addClass('hide');
                    document.getElementById("textoPruebas").style.color = "#f6b73c";
                },
                error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal Intentar más tarde.", "danger");
                    $("#ModalAddMotivo").modal('toggle');
                    document.getElementById("claveNuevoMotivo").reset();
                    $('#siTexto').addClass('hide');
                    $('#noTexto').removeClass('hide');
                    $('#evidenciaSwitchDIV').removeClass('hide');

                    $('#noTextoDescripcion').removeClass('hide');
                    $('#siTextoDescripcion').addClass('hide');
                    document.getElementById("textoPruebas").style.color = "#f6b73c";
                }
            });
            
        }
        else{
            
            alerts.showNotification("top", "right", "No deben de quedar campos vacios.", "warning");
        
        }

    }
    )



    // colorPicker.addEventListener("input", updateFirst, false);
    // colorPicker.addEventListener("change", watchColorPicker, false);

    
    $("#body").change(function () {
        inputColor = document.getElementById("body").value;
        document.getElementById("textoPruebas").style.color = inputColor;
    });
    function watchColorPicker(event) {
        document.querySelectorAll("p").forEach((p) => {
            p.style.color = event.target.value;
        });
    }

    function changeName(e){
        const fileName = e.files[0].name;
        let relatedTarget = $( e ).closest( '.file-gph' ).find( '.file-name' );
        relatedTarget[0].value = fileName;
    }
    



    function configMotivo(){

        $("#modal_config_motivo .modal-header").html("");
        $("#modal_config_motivo .modal-body").html("");
        $("#modal_config_motivo .modal-footer").html("");


        $("#modal_config_motivo").modal();
       
            
            const Modalheader = $('#modal_config_motivo .modal-body');
            const Modalbody = $('#modal_config_motivo .modal-body');
            const Modalfooter = $('#modal_config_motivo .modal-footer');
            var dataModal = ``;

            Modalheader.append(`
                <input type="hidden" value="EDITAR" name="idPrestamo" id="idPrestamo"> 
                    <h4>¿Ésta seguro que desea borrar el préstamo de VAMOS A EDITAR 
                    </h4>
            `);
            dataModal += ``; 

            $.ajax({
                url: 'motivosOpc',
                method: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'JSON',
                success: function (data) {
                    console.log(data)
                    data.forEach(idx =>{
                        console.log(idx)
                        dataModal += `
                        <div class="form-group row">
                            <div class="col-md-8">
                                <label class="control-label">Tipo de descuento</label>
                                <input class="form-control input-gral" value="${idx.nombre}" type="text" step="any"id="tipo" readonly name="tipo">
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex justify-center " style="padding-top: 25px;">
                                    <button href="#"  class="btn-data btn-violetDeep documentoMOTIVO"
                                    id="documentoMOTIVO" name="documentoMOTIVO" 
                                    title="Docuementos"
                                    data-ruta="${idx.ruta}" data-evidencia="${idx.evidencia}" data-motivo="${idx.id_motivo}">
                                    <i class="fas fa-clipboard fa-2x"></i>
                                    </button>

                                    <button href="#"  id="evidenciaNew" name="evidenciaNew"
                                        class="btn-data btn-sky baja-motivo" 
                                        data-motivo="${idx.id_motivo}"
                                        title="Subir nuevo archivo">
                                        <i class="fas fa-plus-square fa-2x"></i>
                                    </button>

                                    <button href="#"  class="btn-data btn-warning baja-motivo" title="Eliminar">
                                        <i class="fas fa-trash fa-2x"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-8 hide" id="evidenciaNuevadiv_${idx.id_motivo}" name="evidenciaNuevadiv_${idx.id_motivo}" style="padding-top:30px;" >
								<div class="file-gph">
									<input class="d-none" type="file" id="evidenciaNueva_${idx.id_motivo}" onchange="changeName(this)" name="evidenciaNueva_${idx.id_motivo}"  >
									<input class="file-name overflow-text" id="evidenciaNueva_${idx.id_motivo}" type="text" placeholder="No has seleccionada nada aún" readonly="">
									<label class="upload-btn w-auto" for="evidenciaNueva_${idx.id_motivo}"><span>Seleccionar</span><i class="fas fa-folder-open"></i></label>
								</div>
							</div>
                            <div class="col-md-4 hide" style="padding-top:30px; " id="evidenciaNuevaDOC_${idx.id_motivo}" name="evidenciaNuevaDOC_${idx.id_motivo}" >
                            <button href="#"  class="btn-data btn-warning baja-motivo" title="Eliminar">

                                    <i class="fas fa-sync-alt fa-1x"></i>
                                </button>
                            </div>
                            

                        </div>
                        <hr>
                        `; 
                    }
                    );


                    Modalheader.append(dataModal);
                },
                error: function () {
                
                }
                });
    }

    $(document).on("click", "#documentoMOTIVO", function () {
        var itself = $(this);
        Shadowbox.open({
            content: `<div>
                        <iframe style="overflow:hidden;width: 100%;height: 100%; 
                                        position:absolute;z-index:999999999999999999999r!important;" 
                                        src="${general_base_url}${itself.attr('data-ruta')}/${itself.attr('data-evidencia')}">
                        </iframe>
                    </div>`,
            player: "html",
            title: `Visualizando archivo: evidencia `,
            width: 985,
            height: 660
        });
    });


    $(document).on("click", "#evidenciaNew", function () {
        var motivo = $(this).attr('data-motivo');

        // bandera en 2 es para cuando se bloquea y 1 para desbloquear
        if(banderaNewEvidencia == 2){
            $('#evidenciaNuevadiv_'+motivo).removeClass('hide');
            $('#evidenciaNuevaDOC_'+motivo).removeClass('hide');

            banderaNewEvidencia = 1;
        }else{
            banderaNewEvidencia = 2;
            $('#evidenciaNuevadiv_'+motivo).addClass('hide');
            $('#evidenciaNuevaDOC_'+motivo).removeClass('hide');
        }
        // $('#evidenciaNuevadiv').addClass('hide');
        

    });


    //$(document).on('input', '.monto', function () {
    //     verificar();
    // });