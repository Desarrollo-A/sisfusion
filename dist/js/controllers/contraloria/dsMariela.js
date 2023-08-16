var getInfo2A = new Array(7);
var getInfo2_2A = new Array(7);
var getInfo5A = new Array(7);
var getInfo6A = new Array(7);
var getInfo2_3A = new Array(7);
var getInfo2_7A = new Array(7);
var getInfo5_2A = new Array(7);
let titulos = [];

$('body').tooltip({
    selector: '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])',
    trigger: 'hover',
    container: 'body'
}).on('click mousedown mouseup', '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])', function () {
    $('[data-toggle="tooltip"], [title]:not([data-toggle="popover"])').tooltip('destroy');
});

$(document).ready (function() {
    $(document).on('fileselect', '.btn-file :file', function(event, numFiles, label) {
        var input = $(this).closest('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;
        if (input.length) {
            input.val(log);
        } else {
            if (log) alert(log);
        }
    });

    $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
        console.log('triggered');
    });

    $('#filtro3').change(function(){
        var valorSeleccionado = $(this).val();
        $("#filtro4").empty().selectpicker('refresh');
        $.ajax({
            url: general_base_url+'registroCliente/getCondominios/'+valorSeleccionado,
            type: 'post',
            dataType: 'json',
            beforeSend:function(){
                $('#spiner-loader').removeClass('hide');
            },
            success:function(response){
                var len = response.length;
                for( var i = 0; i<len; i++)
                {
                    var id = response[i]['idCondominio'];
                    var name = response[i]['nombre'];
                    $("#filtro4").append($('<option>').val(id).text(name));
                }
                $("#filtro4").selectpicker('refresh');
                $('#spiner-loader').addClass('hide');
            }
        });
    });


    $('#filtro4').change(function(){
        var residencial = $('#filtro3').val();
        var valorSeleccionado = $(this).val();
        $("#filtro5").empty().selectpicker('refresh');
        $.ajax({
            url: general_base_url+'Contraloria/getLotesAllTwo/'+valorSeleccionado,
            type: 'post',
            dataType: 'json',
            beforeSend:function(){
                $('#spiner-loader').removeClass('hide');
            },
            success:function(response){
                var len = response.length;
                if(len > 0){
                    for( var i = 0; i<len; i++)
                    {
                        var id = response[i]['idLote'];
                        var name = response[i]['nombreLote'];
                        $("#filtro5").append($('<option>').val(id).text(name));
                    }
                }else{
                    $("#filtro5").append($('<option >').val(0).text('No se encontraron lotes'));
                }
                $("#filtro5").selectpicker('refresh');
                $('#spiner-loader').addClass('hide');
            }
        });
    });

    $('#tabla_deposito_seriedad thead tr:eq(0) th').each(function (i) {
        var title = $(this).text();
        titulos.push(title);
        $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
        $('input', this).on('keyup change', function () {
            if ($('#tabla_deposito_seriedad').DataTable().column(i).search() !== this.value) {
                $('#tabla_deposito_seriedad').DataTable().column(i).search(this.value).draw();
            }
        });
    });

    $('#filtro5').change(function(){
        $('#tabla_deposito_seriedad').removeClass('hide');
        var valorSeleccionado = $(this).val();
        $('#tabla_deposito_seriedad').DataTable({
            destroy: true,
            lengthMenu: [[15, 25, 50, -1], [10, 25, 50, "All"]],
            ajax:
                {
                    url: general_base_url+'Contraloria/getAllDsByLote/'+valorSeleccionado,
                    dataSrc: ""
                },
            dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
            width: "100%",
            scrollX: true,
            bAutoWidth:true,
            ordering: false,
            language: {
                url: "../static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            buttons:[
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o"></i>',
                    titleAttr: 'Deposito de seriedad',
                    title:'Deposito de seriedad',
                    className: 'btn buttons-excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6],
                        format: {
                            header: function (d, columnIdx) {
                                return ' ' + titulos[columnIdx] + ' ';
                            }
                        }
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf-o"></i>',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    titleAttr: 'Deposito de seriedad',
                    title:'Deposito de seriedad',
                    className: 'btn buttons-pdf',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6],
                        format: {
                            header: function (d, columnIdx) {
                                return ' ' + titulos[columnIdx] + ' ';
                            }
                        }
                    }
                }
            ],
            pagingType: "full_numbers",
            columns:
                [
                    { data: "nombreResidencial" },
                    { data: "nombreCondominio" },
                    { data: "nombreLote" },
                    {
                        data: function( d ){
                            return d.nombre+" "+d.apellido_paterno+" "+d.apellido_materno;
                        }
                    },
                    { data: "fecApartado" },
                    { data: "fechaVenc" },
                    {
                        data: function( d ){
                            comentario = d.idMovimiento == 31 ? d.comentario + "<br> <span class='label lbl-green'>Nuevo apartado</span>":
                            d.idMovimiento == 85 ? d.comentario + "<br> <span class='label lbl-warning'>Rechazo Contraloría estatus 2</span>":
                            d.idMovimiento == 20 ?  d.comentario + "<br> <span class='label lbl-warning'>Rechazo Contraloría estatus 5</span>":
                            d.idMovimiento == 63 ?  d.comentario + "<br> <span class='label lbl-warning'>Rechazo Contraloría estatus 6</span>":
                            d.idMovimiento == 73 ?  d.comentario + "<br> <span class='label lbl-warning'>Rechazo Ventas estatus 8</span>":
                            d.idMovimiento == 82 ?  d.comentario + "<br> <span class='label lbl-warning'>Rechazo Jurídico estatus 7</span>":
                            d.idMovimiento == 92 ?  d.comentario + "<br> <span class='label lbl-warning'>Rechazo Contraloría estatus 5</span>":
                            d.idMovimiento == 96 ?  d.comentario + "<br> <span class='label lbl-warning'>Rechazo Contraloría estatus 5</span>":
                            d.comentario;
                            return comentario;
                        }
                    },
                    {
                        data: function( d ){        
                            buttonst = 
                            d.idMovimiento == 31 ?  '<a href="#" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="getInfo2 btn-data btn-green"><i class="fas fa-check" aria-hidden="true" title= "Enviar estatus"></i></a>':
                            d.idMovimiento == 85 ?  '<a href="#" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="getInfo2_2 btn-data btn-green"><i class="fas fa-check" aria-hidden="true" title= "Enviar estatus"></i></a>':
                            d.idMovimiento == 20 ?  '<a href="#" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="getInfo5 btn-data btn-green"><i class="fas fa-check" aria-hidden="true" title= "Enviar estatus"></i></a>':
                            d.idMovimiento == 63 ?  '<a href="#" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="getInfo6 btn-data btn-green"><i class="fas fa-check" aria-hidden="true" title= "Enviar estatus"></i></a>':
                            d.idMovimiento == 73 ?  '<a href="#" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="getInfo2_3 btn-data btn-green"><i class="fas fa-check" aria-hidden="true" title= "Enviar estatus"></i></a>':
                            d.idMovimiento == 82 ?  '<a href="#" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="getInfo2_7 btn-data btn-green"><i class="fas fa-check" aria-hidden="true" title= "Enviar estatus"></i></a>':
                            d.idMovimiento == 92 ?  '<a href="#" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.modificado+'" class="getInfo5_2 btn-data btn-green"><i class="fas fa-check" aria-hidden="true" title= "Enviar estatus"></i></a>':
                            d.idMovimiento == 96 ?  '<a href="#" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.modificado+'" class="getInfo5_2 btn-data btn-green"><i class="fas fa-check" aria-hidden="true" title= "Enviar estatus"></i></a>':
                            d.comentario;
                            return "<div class='d-flex justify-center'>" + buttonst + "</div>";
                        }
                    },
                    {
                        data: function( d ){
                            buttonDS ='<a href="'+general_base_url+'Asesor/deposito_seriedad/'+d.id_cliente+'/0" class="btn-data btn-blueMaderas" data-toggle="tooltip"  data-placement="top" title= "Depósito de seriedad"><i class="fas fa-print" aria-hidden="true" ></i></a>';
                            return "<div class='d-flex justify-center'>" + buttonDS + "</div>";
                        }
                    }
                ],
        });
    });

    $(document).on("click", ".getInfo2", function(e){
        e.preventDefault();
        getInfo2A[0] = $(this).attr("data-idCliente");
        getInfo2A[1] = $(this).attr("data-nombreResidencial");
        getInfo2A[2] = $(this).attr("data-nombreCondominio");
        getInfo2A[3] = $(this).attr("data-idCondominio");
        getInfo2A[4] = $(this).attr("data-nombreLote");
        getInfo2A[5] = $(this).attr("data-idLote");
        getInfo2A[6] = $(this).attr("data-fechavenc");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#modal1').modal('show');
    });

    $(document).on("click", ".getInfo2_2", function(e){
        e.preventDefault();
        getInfo2_2A[0] = $(this).attr("data-idCliente");
        getInfo2_2A[1] = $(this).attr("data-nombreResidencial");
        getInfo2_2A[2] = $(this).attr("data-nombreCondominio");
        getInfo2_2A[3] = $(this).attr("data-idCondominio");
        getInfo2_2A[4] = $(this).attr("data-nombreLote");
        getInfo2_2A[5] = $(this).attr("data-idLote");
        getInfo2_2A[6] = $(this).attr("data-fechavenc");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#modal2').modal('show');
    });


    $(document).on("click", ".getInfo5", function(e){
        e.preventDefault();
        getInfo5A[0] = $(this).attr("data-idCliente");
        getInfo5A[1] = $(this).attr("data-nombreResidencial");
        getInfo5A[2] = $(this).attr("data-nombreCondominio");
        getInfo5A[3] = $(this).attr("data-idCondominio");
        getInfo5A[4] = $(this).attr("data-nombreLote");
        getInfo5A[5] = $(this).attr("data-idLote");
        getInfo5A[6] = $(this).attr("data-fechavenc");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#modal3').modal('show');
    });

    $(document).on("click", ".getInfo6", function(e){
        e.preventDefault();
        getInfo6A[0] = $(this).attr("data-idCliente");
        getInfo6A[1] = $(this).attr("data-nombreResidencial");
        getInfo6A[2] = $(this).attr("data-nombreCondominio");
        getInfo6A[3] = $(this).attr("data-idCondominio");
        getInfo6A[4] = $(this).attr("data-nombreLote");
        getInfo6A[5] = $(this).attr("data-idLote");
        getInfo6A[6] = $(this).attr("data-fechavenc");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#modal4').modal('show');
    });



    $(document).on("click", ".getInfo2_3", function(e){
        e.preventDefault();
        getInfo2_3A[0] = $(this).attr("data-idCliente");
        getInfo2_3A[1] = $(this).attr("data-nombreResidencial");
        getInfo2_3A[2] = $(this).attr("data-nombreCondominio");
        getInfo2_3A[3] = $(this).attr("data-idCondominio");
        getInfo2_3A[4] = $(this).attr("data-nombreLote");
        getInfo2_3A[5] = $(this).attr("data-idLote");
        getInfo2_3A[6] = $(this).attr("data-fechavenc");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#modal5').modal('show');
    });

    $(document).on("click", ".getInfo2_7", function(e){
        e.preventDefault();
        getInfo2_7A[0] = $(this).attr("data-idCliente");
        getInfo2_7A[1] = $(this).attr("data-nombreResidencial");
        getInfo2_7A[2] = $(this).attr("data-nombreCondominio");
        getInfo2_7A[3] = $(this).attr("data-idCondominio");
        getInfo2_7A[4] = $(this).attr("data-nombreLote");
        getInfo2_7A[5] = $(this).attr("data-idLote");
        getInfo2_7A[6] = $(this).attr("data-fechavenc");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#modal6').modal('show');
    });

    $(document).on("click", ".getInfo5_2", function(e){
        e.preventDefault();
        getInfo5_2A[0] = $(this).attr("data-idCliente");
        getInfo5_2A[1] = $(this).attr("data-nombreResidencial");
        getInfo5_2A[2] = $(this).attr("data-nombreCondominio");
        getInfo5_2A[3] = $(this).attr("data-idCondominio");
        getInfo5_2A[4] = $(this).attr("data-nombreLote");
        getInfo5_2A[5] = $(this).attr("data-idLote");
        getInfo5_2A[6] = $(this).attr("data-fechavenc");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#modal7').modal('show');
    });
});

$(document).on('click', '#save1', function(e) {
    e.preventDefault();
    var comentario = $("#comentario").val();
    var validaComent = ($("#comentario").val().length == 0) ? 0 : 1;
    var dataExp1 = new FormData();
    dataExp1.append("idCliente", getInfo2A[0]);
    dataExp1.append("nombreResidencial", getInfo2A[1]);
    dataExp1.append("nombreCondominio", getInfo2A[2]);
    dataExp1.append("idCondominio", getInfo2A[3]);
    dataExp1.append("nombreLote", getInfo2A[4]);
    dataExp1.append("idLote", getInfo2A[5]);
    dataExp1.append("comentario", comentario);
    dataExp1.append("fechaVenc", getInfo2A[6]);
    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }
    if (validaComent == 1) {
        // $('#save1').prop('disabled', true);
        $.ajax({
            url : general_base_url+'asesor/intExpAsesor/',
            data: dataExp1,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#save1').prop('disabled', false);
                    $('#modal1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'MISSING_DOCUMENTS'){
                    $('#save1').prop('disabled', false);
                    $('#modal1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Asegúrate de incluir los documentos; IDENTIFICACIÓN OFICIAL, COMPROBANTE DE DOMICILIO y DEPÓSITO DE SERIEDAD antes de llevar a cabo el avance.", "danger");
                } else if(response.message == 'FALSE'){
                    $('#save1').prop('disabled', false);
                    $('#modal1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save1').prop('disabled', false);
                    $('#modal1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
                else if(response.message == 'VERIFICACION CORREO\/SMS'){
                    $('#save1').prop('disabled', false);
                    $('#modal1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error verifica Correo y/o SMS.", "danger");
                }
            },
            error: function( data ){
                $('#save1').prop('disabled', false);
                $('#modal1').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});




$(document).on('click', '#save2', function(e) {
    e.preventDefault();
    var comentario = $("#comentario2").val();
    var validaComent = ($("#comentario2").val().length == 0) ? 0 : 1;
    var dataExp2 = new FormData();
    dataExp2.append("idCliente", getInfo2_2A[0]);
    dataExp2.append("nombreResidencial", getInfo2_2A[1]);
    dataExp2.append("nombreCondominio", getInfo2_2A[2]);
    dataExp2.append("idCondominio", getInfo2_2A[3]);
    dataExp2.append("nombreLote", getInfo2_2A[4]);
    dataExp2.append("idLote", getInfo2_2A[5]);
    dataExp2.append("comentario", comentario);
    dataExp2.append("fechaVenc", getInfo2_2A[6]);
    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }
    if (validaComent == 1) {
        $('#save2').prop('disabled', true);
        $.ajax({
            url : general_base_url+'asesor/intExpAsesor/',
            data: dataExp2,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#save2').prop('disabled', false);
                    $('#modal2').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'MISSING_DOCUMENTS'){
                    $('#save1').prop('disabled', false);
                    $('#modal1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Asegúrate de incluir los documentos; IDENTIFICACIÓN OFICIAL, COMPROBANTE DE DOMICILIO y DEPÓSITO DE SERIEDAD antes de llevar a cabo el avance.", "danger");
                } else if(response.message == 'FALSE'){
                    $('#save2').prop('disabled', false);
                    $('#modal2').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save2').prop('disabled', false);
                    $('#modal2').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }else if(response.message == 'VERIFICACION CORREO\/SMS'){
                    $('#save2').prop('disabled', false);
                    $('#modal2').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error verifica Correo y/o SMS.", "danger");
                }
            },
            error: function( data ){
                $('#save2').prop('disabled', false);
                $('#modal2').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#save3', function(e) {
    e.preventDefault();
    var comentario = $("#comentario3").val();
    var validaComent = ($("#comentario3").val().length == 0) ? 0 : 1;
    var dataExp3 = new FormData();
    dataExp3.append("idCliente", getInfo5A[0]);
    dataExp3.append("nombreResidencial", getInfo5A[1]);
    dataExp3.append("nombreCondominio", getInfo5A[2]);
    dataExp3.append("idCondominio", getInfo5A[3]);
    dataExp3.append("nombreLote", getInfo5A[4]);
    dataExp3.append("idLote", getInfo5A[5]);
    dataExp3.append("comentario", comentario);
    dataExp3.append("fechaVenc", getInfo5A[6]);
    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }
    if (validaComent == 1) {
        $('#save3').prop('disabled', true);
        $.ajax({
            url : general_base_url+'asesor/editar_registro_loteRevision_asistentesAContraloria_proceceso2/',
            data: dataExp3,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#save3').prop('disabled', false);
                    $('#modal3').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#save3').prop('disabled', false);
                    $('#modal3').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save3').prop('disabled', false);
                    $('#modal3').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }else if(response.message == 'VERIFICACION CORREO\/SMS'){
                    $('#save3').prop('disabled', false);
                    $('#modal3').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error verifica Correo y/o SMS.", "danger");
                }
            },
            error: function( data ){
                $('#save3').prop('disabled', false);
                $('#modal3').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#save4', function(e) {
    e.preventDefault();
    var comentario = $("#comentario4").val();
    var validaComent = ($("#comentario4").val().length == 0) ? 0 : 1;
    var dataExp4 = new FormData();
    dataExp4.append("idCliente", getInfo6A[0]);
    dataExp4.append("nombreResidencial", getInfo6A[1]);
    dataExp4.append("nombreCondominio", getInfo6A[2]);
    dataExp4.append("idCondominio", getInfo6A[3]);
    dataExp4.append("nombreLote", getInfo6A[4]);
    dataExp4.append("idLote", getInfo6A[5]);
    dataExp4.append("comentario", comentario);
    dataExp4.append("fechaVenc", getInfo6A[6]);
    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }
    if (validaComent == 1) {
        $('#save4').prop('disabled', true);
        $.ajax({
            url : general_base_url+'asesor/editar_registro_loteRevision_asistentesAContraloria6_proceceso2/',
            data: dataExp4,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#save4').prop('disabled', false);
                    $('#modal4').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#save4').prop('disabled', false);
                    $('#modal4').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save4').prop('disabled', false);
                    $('#modal4').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }else if(response.message == 'VERIFICACION CORREO\/SMS'){
                    $('#save4').prop('disabled', false);
                    $('#modal4').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error verifica Correo y/o SMS.", "danger");
                }
            },
            error: function( data ){
                $('#save4').prop('disabled', false);
                $('#modal4').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#save5', function(e) {
    e.preventDefault();
    var comentario = $("#comentario5").val();
    var validaComent = ($("#comentario5").val().length == 0) ? 0 : 1;
    var dataExp5 = new FormData();
    dataExp5.append("idCliente", getInfo2_3A[0]);
    dataExp5.append("nombreResidencial", getInfo2_3A[1]);
    dataExp5.append("nombreCondominio", getInfo2_3A[2]);
    dataExp5.append("idCondominio", getInfo2_3A[3]);
    dataExp5.append("nombreLote", getInfo2_3A[4]);
    dataExp5.append("idLote", getInfo2_3A[5]);
    dataExp5.append("comentario", comentario);
    dataExp5.append("fechaVenc", getInfo2_3A[6]);
    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }
    if (validaComent == 1) {
        $('#save5').prop('disabled', true);
        $.ajax({
            url : general_base_url+'asesor/editar_registro_loteRevision_eliteAcontraloria5_proceceso2/',
            data: dataExp5,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#save5').prop('disabled', false);
                    $('#modal5').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#save5').prop('disabled', false);
                    $('#modal5').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save5').prop('disabled', false);
                    $('#modal5').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }else if(response.message == 'VERIFICACION CORREO\/SMS'){
                    $('#save5').prop('disabled', false);
                    $('#modal5').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error verifica Correo y/o SMS.", "danger");
                }
            },
            error: function( data ){
                $('#save5').prop('disabled', false);
                $('#modal5').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#save6', function(e) {
    e.preventDefault();
    var comentario = $("#comentario6").val();
    var validaComent = ($("#comentario6").val().length == 0) ? 0 : 1;
    var dataExp6 = new FormData();
    dataExp6.append("idCliente", getInfo2_7A[0]);
    dataExp6.append("nombreResidencial", getInfo2_7A[1]);
    dataExp6.append("nombreCondominio", getInfo2_7A[2]);
    dataExp6.append("idCondominio", getInfo2_7A[3]);
    dataExp6.append("nombreLote", getInfo2_7A[4]);
    dataExp6.append("idLote", getInfo2_7A[5]);
    dataExp6.append("comentario", comentario);
    dataExp6.append("fechaVenc", getInfo2_7A[6]);
    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }
    if (validaComent == 1) {
        $('#save6').prop('disabled', true);
        $.ajax({
            url : general_base_url+'asesor/envioRevisionAsesor2aJuridico7/',
            data: dataExp6,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#save6').prop('disabled', false);
                    $('#modal6').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#save6').prop('disabled', false);
                    $('#modal6').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save6').prop('disabled', false);
                    $('#modal6').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }else if(response.message == 'VERIFICACION CORREO\/SMS'){
                    $('#save6').prop('disabled', false);
                    $('#modal6').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error verifica Correo y/o SMS.", "danger");
                }
            },
            error: function( data ){
                $('#save6').prop('disabled', false);
                $('#modal6').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#save7', function(e) {
    e.preventDefault();
    var comentario = $("#comentario7").val();
    var validaComent = ($("#comentario7").val().length == 0) ? 0 : 1;
    var dataExp7 = new FormData();
    dataExp7.append("idCliente", getInfo5_2A[0]);
    dataExp7.append("nombreResidencial", getInfo5_2A[1]);
    dataExp7.append("nombreCondominio", getInfo5_2A[2]);
    dataExp7.append("idCondominio", getInfo5_2A[3]);
    dataExp7.append("nombreLote", getInfo5_2A[4]);
    dataExp7.append("idLote", getInfo5_2A[5]);
    dataExp7.append("comentario", comentario);
    dataExp7.append("fechaVenc", getInfo5_2A[6]);
    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }
    if (validaComent == 1) {
        $('#save7').prop('disabled', true);
        $.ajax({
            url : general_base_url+'asesor/editar_registro_loteRevision_eliteAcontraloria5_proceceso2_2/',
            data: dataExp7,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#save7').prop('disabled', false);
                    $('#modal7').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#save7').prop('disabled', false);
                    $('#modal7').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save7').prop('disabled', false);
                    $('#modal7').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }else if(response.message == 'VERIFICACION CORREO\/SMS'){
                    $('#save7').prop('disabled', false);
                    $('#modal7').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error verifica Correo y/o SMS.", "danger");
                }
            },
            error: function( data ){
                $('#save7').prop('disabled', false);
                $('#modal7').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

jQuery(document).ready(function(){
    jQuery('#modal1').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario').val('');
    })
    jQuery('#modal2').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario2').val('');
    })
    jQuery('#modal3').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario3').val('');
    })
    jQuery('#modal4').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario4').val('');
    })
    jQuery('#modal5').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario5').val('');
    })
    jQuery('#modal6').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario6').val('');
    })
    jQuery('#modal7').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario7').val('');
    })

})
