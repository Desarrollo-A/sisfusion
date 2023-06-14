$(document).ready(function() {
    if (id_usuario_general == 9651) { // MJ: ERNESTO DEL PINO SILVA
        $.post(`${general_base_url}Contratacion/lista_proyecto`, function(data) {
            var len = data.length;
            for(var i = 0; i<len; i++){
                var id = data[i]['idResidencial'];
                var name = data[i]['descripcion'];
                $("#proyecto").append($('<option>').val(id).text(name.toUpperCase()));
            }

            $("#proyecto").selectpicker('refresh');
        }, 'json');
    }
    else // MJ: PARA LOS DEMÁS SÍ CARGA EN EL READY
        fillDataTable(0);
});

$('#proyecto').change( function(){
	index_proyecto = $(this).val();
	$("#condominio").html("");
	$(document).ready(function(){
		$.post(`${general_base_url}Contratacion/lista_condominio/`+index_proyecto, function(data) {
			var len = data.length;
			$("#condominio").append($('<option disabled selected>Selecciona un codominio</option>'));

			for( var i = 0; i<len; i++)
			{
				var id = data[i]['idCondominio'];
				var name = data[i]['nombre'];
				$("#condominio").append($('<option>').val(id).text(name.toUpperCase()));
			}
			$("#condominio").selectpicker('refresh');
		}, 'json');
	});
});

$('#condominio').change( function(){
	let id_condominio = $(this).val();
    fillDataTable(id_condominio);
});

Shadowbox.init();
var miArray = new Array(6);
var miArrayAddFile = new Array(6);

var getInfo2A = new Array(7);
var getInfo2_2A = new Array(7);
var getInfo5A = new Array(7);
var getInfo6A = new Array(7);
var getInfo2_3A = new Array(7);
var getInfo2_7A = new Array(7);
var getInfo5_2A = new Array(7);
var return1a = new Array(7);
var tipo_comprobante ;
var aut;
let titulos_intxt = [];
    
$('#tabla_deposito_seriedad thead tr:eq(0) th').each( function (i) {
    $(this).css('text-align', 'center');
    var title = $(this).text();
    titulos_intxt.push(title);
    $(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
    $( 'input', this ).on('keyup change', function () {
        if ($('#tabla_deposito_seriedad').DataTable().column(i).search() !== this.value ) {
            $('#tabla_deposito_seriedad').DataTable()
                .column(i)
                .search(this.value)
                .draw();
        }
    });
});

$("#tabla_deposito_seriedad").ready( function(){
    $(document).on('click', '.abrir_prospectos', function () {
        $('#nom_cliente').html('');
        $('#id_cliente_asignar').val(0);
        var $itself = $(this);
        var id_cliente = $itself.attr('data-idCliente');
        var nombre_cliente = $itself.attr('data-nomCliente');
        $('#nom_cliente').append(nombre_cliente);
        $('#id_cliente_asignar').val(id_cliente);

        tabla_valores_ds = $("#table_prospectos").DataTable({
            width: 'auto',
            "dom": "Bfrtip",
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Prospectos',
                title:"Prospectos",
                exportOptions: {
                    columns: [0,1,2,3],
                    format: {
                        header: function (d, columnIdx) {
                            return ' '+titulos_encabezado[columnIdx] +' ';
                        }
                    }
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                className: 'btn buttons-pdf',
                titleAttr: 'Prospectos',
                title:"Prospectos",
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: [0,1,2,3],
                    format: {
                        header: function (d, columnIdx) {
                            return ' '+titulos_encabezado[columnIdx] +' ';
                        }
                    }
                }
            }],
            columnDefs: [{
                defaultContent: "",
                targets: "_all",
                searchable: true,
                orderable: false
            }],
            "pageLength": 10,
            "bAutoWidth": false,
            "fixedColumns": true,
            "ordering": false,
            "destroy": true,
            "language": {
                "url": general_base_url+"static/spanishLoader.json"
            },
            "order": [[4, "desc"]],
            columns: [
                {
                    "data": function(d){
                        return d.nombre + ' ' + d.apellido_paterno + ' ' + d.apellido_materno;
                    }
                },
                {
                    "data": function(d){
                        return myFunctions.validateEmptyField(d.correo);
                    }
                },
                {
                    "data": function(d){
                        return d.telefono;
                    }
                },
                {
                    "data": function(d){
                        var info = '';
                        info = '<b>Observación:</b> '+myFunctions.validateEmptyField(d.observaciones)+'<br>';
                        info += '<b>Lugar prospección:</b> '+d.lugar_prospeccion+'<br>';
                        info += '<b>Plaza venta:</b> '+d.plaza_venta+'<br>';
                        info += '<b>Nacionalidad:</b> '+d.nacionalidad+'<br>';


                        return info;
                    }
                },
                {
                    "data": function(d){
                        return '<center><button class="btn-data btn-green became_prospect_to_cliente"' +
                            'data-id_prospecto="'+d.id_prospecto+'" data-id_cliente="'+id_cliente+'" data-toggle="tooltip" data-placement="top" title="NUEVO PROSPECTO">' +
                            '<i class="fas fa-user-check"></i></button></center>';
                    }
                },
            ],

            "ajax": {
                "url": general_base_url+"Asesor/get_info_prospectos/",
                "dataSrc": "",
                "type": "POST",
                cache: false,
                "data": function( d ){
                }
            },
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip("destroy");
                $('[data-toggle="tooltip"]').tooltip({trigger: "hover"});
            }
            

        });

        $('#asignar_prospecto_a_cliente').modal();
    });

    let titulos_encabezado = [];
    $('#table_prospectos thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
        $( 'input', this ).on('keyup change', function () {
            if ($('#table_prospectos').DataTable().column(i).search() !== this.value ) {
                $('#table_prospectos').DataTable().column(i).search(this.value).draw();
            }
        });
        titulos_encabezado.push(title);
        $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
    });

    $(document).on('click', '.became_prospect_to_cliente', function() {
        var $itself = $(this);
        var id_cliente = $itself.attr('data-id_cliente');
        var id_prospecto = $itself.attr('data-id_prospecto');
        $('#modal_pregunta').modal();

        $(document).on('click', '#asignar_prospecto', function () {
            //ajax con el post de update prospecto a cliente
            $.ajax({
                type: 'POST',
                url: general_base_url+'asesor/prospecto_a_cliente',
                data: {'id_prospecto':id_prospecto,'id_cliente':id_cliente},
                dataType: 'json',
                beforeSend: function(){
                    $('#modal_loader_assign').modal();

                },
                success: function(data) {
                    if (data.cliente_update == 'OK' && data.prospecto_update=='OK') {
                        $('#modal_loader_assign').modal("hide");
                        $('#asignar_prospecto_a_cliente').modal('hide');
                        $('#table_prospectos').DataTable().ajax.reload();
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification('top', 'right', 'Se ha asignado correctamente', 'success');
                    } 
                    else {
                        alerts.showNotification('top', 'right', 'Ha ocurrido un error inesperado verificalo ['+data+']', 'danger');
                    }
                },
                error: function(){
                    $('#modal_loader_assign').modal("hide");
                    $('#asignar_prospecto_a_cliente').modal('hide');
                    $('#table_prospectos').DataTable().ajax.reload();
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification('top', 'right', 'OCURRIO UN ERROR, INTENTALO DE NUEVO', 'danger');
                }
            });
        });
    });

    $(document).on('click', '.pdfLink2', function () {
        var $itself = $(this);
        Shadowbox.open({
            content:    '<div><iframe style="overflow:hidden;width: 100%;height: -webkit-fill-available;" src="'+general_base_url+'asesor/deposito_seriedad/'+$itself.attr('data-idc')+'/0/"></iframe></div>',
            player:     "html",
            title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
            width:      1600,
            height:     900
        });
    });

    $(document).on('click', '.pdfLink22', function () {
        var $itself = $(this);
        Shadowbox.open({
            content:    '<div><iframe style="overflow:hidden;width: 100%;height: -webkit-fill-available;" src="'+general_base_url+'asesor/deposito_seriedad_ds/'+$itself.attr('data-idc')+'/0/"></iframe></div>',
            player:     "html",
            title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
            width:      1600,
            height:     900
        });
    });
});

$(document).on("click", ".getInfo2", function (e) {
    e.preventDefault();
    getInfo2A[0] = $(this).attr("data-idCliente");
    getInfo2A[1] = $(this).attr("data-nombreResidencial");
    getInfo2A[2] = $(this).attr("data-nombreCondominio");
    getInfo2A[3] = $(this).attr("data-idCondominio");
    getInfo2A[4] = $(this).attr("data-nombreLote");
    getInfo2A[5] = $(this).attr("data-idLote");
    getInfo2A[6] = $(this).attr("data-fechavenc");
    nombreLote = $(this).data("nomlote");
    tipo_comprobante = $(this).attr('data-ticomp');
    $(".lote").html(nombreLote);
    $('#modal1').modal('show');
});

$(document).on("click", ".getInfo2_2", function (e) {
    e.preventDefault();
    getInfo2_2A[0] = $(this).attr("data-idCliente");
    getInfo2_2A[1] = $(this).attr("data-nombreResidencial");
    getInfo2_2A[2] = $(this).attr("data-nombreCondominio");
    getInfo2_2A[3] = $(this).attr("data-idCondominio");
    getInfo2_2A[4] = $(this).attr("data-nombreLote");
    getInfo2_2A[5] = $(this).attr("data-idLote");
    getInfo2_2A[6] = $(this).attr("data-fechavenc");
    nombreLote = $(this).data("nomlote");
    tipo_comprobante = $(this).attr('data-ticomp');
    $(".lote").html(nombreLote);
    $('#modal2').modal('show');
});

$(document).on("click", ".getInfo5", function (e) {
    e.preventDefault();
    getInfo5A[0] = $(this).attr("data-idCliente");
    getInfo5A[1] = $(this).attr("data-nombreResidencial");
    getInfo5A[2] = $(this).attr("data-nombreCondominio");
    getInfo5A[3] = $(this).attr("data-idCondominio");
    getInfo5A[4] = $(this).attr("data-nombreLote");
    getInfo5A[5] = $(this).attr("data-idLote");
    getInfo5A[6] = $(this).attr("data-fechavenc");
    nombreLote = $(this).data("nomlote");
    tipo_comprobante = $(this).attr('data-ticomp');
    $(".lote").html(nombreLote);
    $('#modal3').modal('show');
});

$(document).on("click", ".getInfo6", function (e) {
    e.preventDefault();
    getInfo6A[0] = $(this).attr("data-idCliente");
    getInfo6A[1] = $(this).attr("data-nombreResidencial");
    getInfo6A[2] = $(this).attr("data-nombreCondominio");
    getInfo6A[3] = $(this).attr("data-idCondominio");
    getInfo6A[4] = $(this).attr("data-nombreLote");
    getInfo6A[5] = $(this).attr("data-idLote");
    getInfo6A[6] = $(this).attr("data-fechavenc");
    nombreLote = $(this).data("nomlote");
    tipo_comprobante = $(this).attr('data-ticomp');
    $(".lote").html(nombreLote);
    $('#modal4').modal('show');
});

$(document).on("click", ".getInfo2_3", function (e) {
    e.preventDefault();
    getInfo2_3A[0] = $(this).attr("data-idCliente");
    getInfo2_3A[1] = $(this).attr("data-nombreResidencial");
    getInfo2_3A[2] = $(this).attr("data-nombreCondominio");
    getInfo2_3A[3] = $(this).attr("data-idCondominio");
    getInfo2_3A[4] = $(this).attr("data-nombreLote");
    getInfo2_3A[5] = $(this).attr("data-idLote");
    getInfo2_3A[6] = $(this).attr("data-fechavenc");
    nombreLote = $(this).data("nomlote");
    tipo_comprobante = $(this).attr('data-ticomp');
    $(".lote").html(nombreLote);
    $('#modal5').modal('show');
});

$(document).on("click", ".getInfo2_7", function (e) {
    e.preventDefault();
    getInfo2_7A[0] = $(this).attr("data-idCliente");
    getInfo2_7A[1] = $(this).attr("data-nombreResidencial");
    getInfo2_7A[2] = $(this).attr("data-nombreCondominio");
    getInfo2_7A[3] = $(this).attr("data-idCondominio");
    getInfo2_7A[4] = $(this).attr("data-nombreLote");
    getInfo2_7A[5] = $(this).attr("data-idLote");
    getInfo2_7A[6] = $(this).attr("data-fechavenc");
    nombreLote = $(this).data("nomlote");
    tipo_comprobante = $(this).attr('data-ticomp');
    $(".lote").html(nombreLote);
    $('#modal6').modal('show');
});

$(document).on("click", ".getInfo5_2", function (e) {
    e.preventDefault();
    getInfo5_2A[0] = $(this).attr("data-idCliente");
    getInfo5_2A[1] = $(this).attr("data-nombreResidencial");
    getInfo5_2A[2] = $(this).attr("data-nombreCondominio");
    getInfo5_2A[3] = $(this).attr("data-idCondominio");
    getInfo5_2A[4] = $(this).attr("data-nombreLote");
    getInfo5_2A[5] = $(this).attr("data-idLote");
    getInfo5_2A[6] = $(this).attr("data-fechavenc");
    nombreLote = $(this).data("nomlote");
    tipo_comprobante = $(this).attr('data-ticomp');
    $(".lote").html(nombreLote);
    $('#modal7').modal('show');
});

$(document).on("click", ".return1", function (e) {
    e.preventDefault();
    return1a[0] = $(this).attr("data-idCliente");
    return1a[1] = $(this).attr("data-nombreResidencial");
    return1a[2] = $(this).attr("data-nombreCondominio");
    return1a[3] = $(this).attr("data-idCondominio");
    return1a[4] = $(this).attr("data-nombreLote");
    return1a[5] = $(this).attr("data-idLote");
    return1a[6] = $(this).attr("data-fechavenc");
    nombreLote = $(this).data("nomlote");
    tipo_comprobante = $(this).attr('data-ticomp');
    $(".lote").html(nombreLote);
    $('#modal_return1').modal('show');
});

function fillDataTable(id_condominio) {
    tabla_valores_ds = $("#tabla_deposito_seriedad").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Tus ventas',
            title:"Tus ventas",
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos_intxt[columnIdx] + ' ';
                    }
                }
            }
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
            className: 'btn buttons-pdf',
            titleAttr: 'Tus ventas',
            title:"Tus ventas",
            orientation: 'landscape',
            pageSize: 'LEGAL',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos_intxt[columnIdx] + ' ';
                    }
                }
            }
        }],
        columnDefs: [{
            defaultContent: "",
            targets: "_all",
            searchable: true,
            orderable: false
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
            { "data": "nombreResidencial" },
            { "data": "nombreCondominio" },
            { "data": "nombreLote" },
            { "data": "nombreCliente" },
            {
                "data": function( d ){
                    return d.coordinador;
                }
            },
            {
                "data": function( d ){
                    return d.gerente;
                }
            },
            {
                "data": function( d ){
                    return d.subdirector;
                }
            },
            {
                "data": function( d ){
                    return d.regional;
                }
            },
            {
                "data": function( d ){
                    return d.regional2;
                }
            },
            { "data": "fechaApartado" },
            {
                "data": function( d ){
                    fv = (d.idMovimiento == 73 || d.idMovimiento == 92 || d.idMovimiento == 96 || d.idMovimiento == 102 || d.idMovimiento == 104 || d.idMovimiento == 108|| d.idMovimiento == 107 || d.idMovimiento == 109 || d.idMovimiento == 111 ) ?  d.modificado: d.fechaVenc;
                    return fv;
                }
            },
            {
                "data": function( d ){
                    comentario = d.idMovimiento == 31 ? d.comentario + "<br> <span class='label lbl-sky'>Nuevo apartado</span>":
                    d.idMovimiento == 85 ?  d.comentario + "<br><span class='label lbl-warning'>Rechazo Contraloria estatus 2</span>":
                    d.idMovimiento == 20 ?  d.comentario + "<br><span class='label lbl-warning'>Rechazo Contraloria estatus 5</span>":
                    d.idMovimiento == 63 ?  d.comentario + "<br><span class='label lbl-warning'>Rechazo Contraloria estatus 6</span>":
                    d.idMovimiento == 73 ?  d.comentario + "<br><span class='label lbl-warning'>Rechazo Ventas estatus 8</span>":
                    d.idMovimiento == 82 ?  d.comentario + "<br><span class='label lbl-warning'>Rechazo Jurídico estatus 7</span>":
                    d.idMovimiento == 92 ?  d.comentario + "<br><span class='label lbl-warning'>Rechazo Contraloria estatus 5</span>":
                    d.idMovimiento == 96 ?  d.comentario + "<br><span class='label lbl-warning'>Rechazo Jurídico estatus 7</span>":
                    d.idMovimiento == 99 ?  d.comentario + "<br><span class='label lbl-warning'>Rechazo Postventa estatus 3</span>":
                    d.idMovimiento == 102 ?  d.comentario + "<br><span class='label lbl-warning'>Rechazo Contraloria estatus 2</span>":
                    d.idMovimiento == 104 ?  d.comentario + "<br><span class='label lbl-warning'>Rechazo Contraloria estatus 6</span>":
                    d.idMovimiento == 108 ?  d.comentario + "<br><span class='label lbl-warning'>Rechazo Postventa estatus 3</span>":
                    d.idMovimiento == 109 ?  d.comentario + "<br><span class='label lbl-warning'>Rechazo Juridico estatus 7</span>":
                    d.idMovimiento == 111 ?  d.comentario + "<br><span class='label lbl-warning'>Rechazo Postventa 3</span>":
                    d.idMovimiento == 107 ?  d.comentario + "<br><span class='label lbl-warning'>Rechazo de Contraloria estatus 6</span>":
                    d.comentario;
                    return comentario;
                }
            },
            {
                "data" : function(d){
                    var action='';
                    if (d.dsType == 1) {
                        if (d.idMovimiento == 31 && d.idStatusContratacion == 1) {
                            if (d.id_prospecto == 0)/*APARTADO DESDE LA PAGINA DE CIUDAD MADERAS*/
                            {
                                if (d.id_coordinador == 10807 || d.id_coordinador == 10806 || d.id_gerente == 10807 || d.id_gerente == 10806)
                                    action = 'Asignado correctamente';
                                else {
                                    var nombre_cliente = '';
                                    nombre_cliente = d.nombre + ' ' + d.apellido_paterno + ' ' + d.apellido_materno;
                                    action = '<center><button class="btn-data btn-green abrir_prospectos ' +
                                    'btn-fab btn-fab-mini" data-idCliente="'+d.id_cliente+'" data-nomCliente="'+nombre_cliente+'" data-toggle="tooltip" data-placement="left" title="NUEVO PROSPECTO">' +
                                    '<i class="fas fa-user-check"></i></button></center><br>';
                                    action += 'Debes asignar el prospecto al cliente para poder acceder al depósito de seriedad o integrar el expediente';
                                }
                            } 
                            else {
                                action = 'Asignado correctamente';
                            }
                        }
                        else {
                            action = 'Asignado correctamente';
                        }
                    }
                    return action;
                }
            },
            {
                "data": function( d ){
                    var atributo_button ='';
                    var buttonst;
                    var tipo_comprobanteD = d.tipo_comprobanteD;
                    if(d.vl == '1') {
                        buttonst = 'En proceso de Liberación';
                    } else {
                        if (d.idMovimiento == 31 && d.idStatusContratacion == 1) {
                            if (d.id_prospecto == 0 ){
                                if (d.id_coordinador == 10807 || d.id_coordinador == 10806 || d.id_gerente == 10807 || d.id_gerente == 10806) {
                                    buttonst = d.idMovimiento == 31 ?  '<a href="#" '+atributo_button+'  data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green getInfo2" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS"><i class="fas fa-check"></i></a>':
                                    d.idMovimiento == 85 ?  '<a href="#" '+atributo_button+' data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green getInfo2_2" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS"><i class="fas fa-check"></i></a>':
                                    d.idMovimiento == 20 ?  '<a href="#" '+atributo_button+' data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green getInfo5" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS">  <i class="fas fa-check"></i></a>':
                                    d.idMovimiento == 63 ?  '<a href="#" '+atributo_button+' data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green getInfo6" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS">  <i class="fas fa-check"></i></a>':
                                    d.idMovimiento == 73 ?  '<a href="#" '+atributo_button+' data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green getInfo2_3" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS"><i class="fas fa-check"></i></a>':
                                    d.idMovimiento == 82 ?  '<a href="#" '+atributo_button+' data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green getInfo2_7" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS"><i class="fas fa-check"></i></a>':
                                    d.idMovimiento == 92 ?  '<a href="#" '+atributo_button+' data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.modificado+'" class="btn-data btn-green getInfo5_2" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS"><i class="fas fa-check"></i></a>':
                                    d.idMovimiento == 96 ?  '<a href="#" '+atributo_button+' data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green return1" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS"><i class="fas fa-check"></i></a>':
                                    d.comentario;
                                } else {
                                    buttonst = d.idMovimiento == 31 ?  '<a href="#" disabled  data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green disabled" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS">  <i class="fas fa-check"></i></a>':
                                    d.idMovimiento == 85 ?  '<a href="#" disabled data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'"  data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green disabled" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS"><i class="fas fa-check"></i></a>':
                                    d.idMovimiento == 20 ?  '<a href="#" disabled data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'"  data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green disabled" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS">  <i class="fas fa-check"></i></a>':
                                    d.idMovimiento == 63 ?  '<a href="#" disabled data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'"  data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green disabled" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS">  <i class="fas fa-check"></i></a>':
                                    d.idMovimiento == 73 ?  '<a href="#" disabled data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'"  data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green disabled" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS"><i class="fas fa-check"></i></a>':
                                    d.idMovimiento == 82 ?  '<a href="#" disabled data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'"  data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green disabled" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS"><i class="fas fa-check"></i></a>':
                                    d.idMovimiento == 92 ?  '<a href="#" disabled data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'"  data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.modificado+'" class="btn-data btn-green disabled" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS"><i class="fas fa-check"></i></a>':
                                    d.idMovimiento == 96 ?  '<a href="#" disabled data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green disabled" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS"><i class="fas fa-check"></i></a>':
                                    d.comentario;
                                }
                            }
                            else {
                                buttonst = d.idMovimiento == 31 ?  '<a href="#" '+atributo_button+' data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green getInfo2" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS">  <i class="fas fa-check"></i></a>':
                                d.idMovimiento == 85 ?  '<a href="#" '+atributo_button+' data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green getInfo2_2" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS"><i class="fas fa-check"></i></a>':
                                d.idMovimiento == 20 ?  '<a href="#" '+atributo_button+' data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green getInfo5" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS">  <i class="fas fa-check"></i></a>':
                                d.idMovimiento == 63 ?  '<a href="#" '+atributo_button+' data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green getInfo6" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS">  <i class="fas fa-check"></i></a>':
                                d.idMovimiento == 73 ?  '<a href="#" '+atributo_button+' data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green getInfo2_3" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS"><i class="fas fa-check"></i></a>':
                                d.idMovimiento == 82 ?  '<a href="#" '+atributo_button+' data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green getInfo2_7" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS"><i class="fas fa-check"></i></a>':
                                d.idMovimiento == 92 ?  '<a href="#" '+atributo_button+' data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.modificado+'" class="btn-data btn-green getInfo5_2" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS"><i class="fas fa-check"></i></a>':
                                d.idMovimiento == 96 ?  '<a href="#" '+atributo_button+' data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green return1" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS"><i class="fas fa-check" ></i></a>':
                                d.idMovimiento == 104 ?  '<a href="#" '+atributo_button+' data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green getInfo2" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS">  <i class="fas fa-check"></i></a>':
                                d.idMovimiento == 108 ?  '<a href="#" '+atributo_button+' data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green getInfo2" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS">  <i class="fas fa-check"></i></a>':
                                d.comentario;
                            }
                        }                            
                        else 
                        {
                            buttonst = d.idMovimiento == 31 ?  '<a href="#" '+atributo_button+' data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green getInfo2" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS">  <i class="fas fa-check"></i></a>':
                            d.idMovimiento == 85 ?  '<a href="#" '+atributo_button+' data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green getInfo2_2" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS"><i class="fas fa-check"></i></a>':
                            d.idMovimiento == 20 ?  '<a href="#" '+atributo_button+' data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green getInfo5" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS">  <i class="fas fa-check" ></i></a>':
                            d.idMovimiento == 63 ?  '<a href="#" '+atributo_button+' data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green getInfo6" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS">  <i class="fas fa-check"></i></a>':
                            d.idMovimiento == 73 ?  '<a href="#" '+atributo_button+' data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green getInfo2_3" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS"><i class="fas fa-check"></i></a>':
                            d.idMovimiento == 82 ?  '<a href="#" '+atributo_button+' data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green getInfo2_7" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS"><i class="fas fa-check"></i></a>':
                            d.idMovimiento == 92 ?  '<a href="#" '+atributo_button+' data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.modificado+'" class="btn-data btn-green getInfo5_2" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS"><i class="fas fa-check"></i></a>':
                            d.idMovimiento == 96 ?  '<a href="#" '+atributo_button+' data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green return1" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS"><i class="fas fa-check"></i></a>':
                            d.idMovimiento == 99 ?  '<a href="#" '+atributo_button+' data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green enviar_nuevamente_estatus3"><i class="fas fa-check" title= "ENVIAR A ESTATUS 3"></i></a>':
                            d.idMovimiento == 102 ?  '<a href="#" '+atributo_button+' data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green getInfo2" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS">  <i class="fas fa-check"></i></a>':
                            d.idMovimiento == 104 ?  '<a href="#" '+atributo_button+' data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green getInfo2" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS">  <i class="fas fa-check"></i></a>':
                            d.idMovimiento == 108 ?  '<a href="#" '+atributo_button+' data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green getInfo2" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS">  <i class="fas fa-check"></i></a>':
                            d.idMovimiento == 107 ?  '<a href="#" '+atributo_button+' data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green getInfo2" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS">  <i class="fas fa-check"></i></a>':
                            d.idMovimiento == 109 ?  '<a href="#" '+atributo_button+' data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green getInfo2" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS">  <i class="fas fa-check"></i></a>':
                            d.idMovimiento == 111 ?  '<a href="#" '+atributo_button+' data-tiComp="'+tipo_comprobanteD+'" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green getInfo2" data-toggle="tooltip" data-placement="left" title="ENVIAR ESTATUS">  <i class="fas fa-check"></i></a>':
                            d.comentario;
                        }
                    }

                    var atributo_button ='';
                    var url_to_go  = '';
                    if (d.idMovimiento == 31 && d.idStatusContratacion == 1) {
                        if (d.id_prospecto == 0)/*APARTADO DESDE LA PAGINA DE CIUDAD MADERAS*/
                        {
                            if (d.id_coordinador == 10807 || d.id_coordinador == 10806 || d.id_gerente == 10807 || d.id_gerente == 10806) {
                                atributo_button = '';
                                url_to_go  = general_base_url+'Asesor/deposito_seriedad/'+d.id_cliente+'/0';
                            } else {
                                atributo_button = 'disabled';
                                url_to_go  = '#';
                            }
                        } else {
                            atributo_button = '';
                            url_to_go  = general_base_url+'Asesor/deposito_seriedad/'+d.id_cliente+'/0';
                        }
                    }
                    else {
                        atributo_button = '';
                        url_to_go  = general_base_url+'Asesor/deposito_seriedad/'+d.id_cliente+'/0';
                    }
                    if (d.dsType == 1){
                        buttonst += '<a class="btn-data btn-blueMaderas btn_ds'+d.id_cliente+'" '+atributo_button+' id="btn_ds'+d.id_cliente+'" href="'+url_to_go+'" data-toggle="tooltip" data-placement="left" title="DEPÓSITO DE SERIEDAD" target=”_blank”><i class="fas fa-print"></i></a>';
                    } else if(d.dsType == 2) { // DATA FROM DEPOSITO_SERIEDAD_CONSULTA OLD VERSION
                        buttonst += '<a class="btn-data btn-blueMaderas" href="'+general_base_url+'Asesor/deposito_seriedad_ds/'+d.id_cliente+'/0" title= "DEPÓSITO DE SERIEDAD" target=”_blank”><i class="fas fa-print"></i></a>';
                    }
                    return '<div class="d-flex justify-center">'+buttonst+'</div>';
                }
            }
        ],
        ajax: {
            url: general_base_url+"Asesor/tableClienteDS/",
            dataSrc: "",
            type: "POST",
            cache: false,
            data: {
                "id_condominio": id_condominio,
            }
        },
        initComplete: function () {
            $('[data-toggle="tooltip"]').tooltip("destroy");
            $('[data-toggle="tooltip"]').tooltip({trigger: "hover"});
        }
    });
}

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
    dataExp1.append('tipo_comprobante', tipo_comprobante);

    let comprobante_domicilio = (tipo_comprobante==1) ? '' : ', COMPROBANTE DE DOMICILIO';
    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }

    if (validaComent == 1) {
        $('#save1').prop('disabled', true);
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
                } else if(response.message == 'FALSE'){
                    $('#save1').prop('disabled', false);
                    $('#modal1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'MISSING_DOCUMENTS'){
                    $('#save1').prop('disabled', false);
                    $('#modal1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Asegúrate de incluir los documentos: IDENTIFICACIÓN OFICIAL "+comprobante_domicilio+", RECIBOS DE APARTADO Y ENGANCHE Y DEPÓSITO DE SERIEDAD antes de llevar a cabo el avance.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save1').prop('disabled', false);
                    $('#modal1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al envial la solicitud.", "danger");
                } else if(response.message == 'MISSING_AUTORIZACION'){
                    $('#save1').prop('disabled', false);
                    $('#modal1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "EN PROCESO DE AUTORIZACIÓN. Hasta que la autorización no haya sido aceptada o rechazada, no podrás avanzar la solicitud.", "danger");
                } else if(response.message == 'OBSERVACION_CONTRATO'){
                    $('#save1').prop('disabled', false);
                    $('#modal1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "EN PROCESO DE LIBERACIÓN. No podrás avanzar la solicitud hasta que el proceso de liberación haya concluido", "danger");
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

$(document).on('click', '#guardar_re3pv', function(e) {
    e.preventDefault();
    var comentario = $("#comentarioST3PV2").val();
    var validaComent = ($("#comentarioST3PV2").val().length == 0) ? 0 : 1;
    var dataExp1 = new FormData();

    dataExp1.append("idCliente", getInfo2A[0]);
    dataExp1.append("nombreResidencial", getInfo2A[1]);
    dataExp1.append("nombreCondominio", getInfo2A[2]);
    dataExp1.append("idCondominio", getInfo2A[3]);
    dataExp1.append("nombreLote", getInfo2A[4]);
    dataExp1.append("idLote", getInfo2A[5]);
    dataExp1.append("comentario", comentario);
    dataExp1.append("fechaVenc", getInfo2A[6]);
    dataExp1.append('tipo_comprobante', tipo_comprobante);

    let comprobante_domicilio = (tipo_comprobante==1) ? '' : ', COMPROBANTE DE DOMICILIO';
    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }

    if (validaComent == 1) {
        $('#guardar_re3pv').prop('disabled', true);
        $.ajax({
            url : general_base_url+'Postventa/enviarLoteARevisionPostVenta3/',
            data: dataExp1,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#guardar_re3pv').prop('disabled', false);
                    $('#enviarNuevamenteEstatus3PV  ').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#guardar_re3pv').prop('disabled', false);
                    $('#enviarNuevamenteEstatus3PV  ').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'MISSING_DOCUMENTS'){
                    $('#guardar_re3pv').prop('disabled', false);
                    $('#enviarNuevamenteEstatus3PV  ').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Asegúrate de incluir los documentos: IDENTIFICACIÓN OFICIAL "+comprobante_domicilio+", RECIBOS DE APARTADO Y ENGANCHE Y DEPÓSITO DE SERIEDAD antes de llevar a cabo el avance.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#guardar_re3pv').prop('disabled', false);
                    $('#enviarNuevamenteEstatus3PV  ').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al envial la solicitud.", "danger");
                } else if(response.message == 'MISSING_AUTORIZACION'){
                    $('#guardar_re3pv').prop('disabled', false);
                    $('#enviarNuevamenteEstatus3PV  ').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "EN PROCESO DE AUTORIZACIÓN. Hasta que la autorización no haya sido aceptada o rechazada, no podrás avanzar la solicitud.", "danger");
                } else if(response.message == 'OBSERVACION_CONTRATO'){
                    $('#guardar_re3pv').prop('disabled', false);
                    $('#enviarNuevamenteEstatus3PV').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "EN PROCESO DE LIBERACIÓN. No podrás avanzar la solicitud hasta que el proceso de liberación haya concluido", "danger");
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
    dataExp2.append('tipo_comprobante', tipo_comprobante);

    let comprobante_domicilio = (tipo_comprobante==1) ? '' : ', COMPROBANTE DE DOMICILIO';
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
                } else if(response.message == 'FALSE'){
                    $('#save2').prop('disabled', false);
                    $('#modal2').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'MISSING_DOCUMENTS'){
                    $('#save2').prop('disabled', false);
                    $('#modal2').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Asegúrate de incluir los documentos; IDENTIFICACIÓN OFICIAL "+comprobante_domicilio+", RECIBOS DE APARTADO Y ENGANCHE y DEPÓSITO DE SERIEDAD antes de llevar a cabo el avance.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save2').prop('disabled', false);
                    $('#modal2').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
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
    dataExp3.append('tipo_comprobante', tipo_comprobante);

    let comprobante_domicilio = (tipo_comprobante==1) ? '' : ', COMPROBANTE DE DOMICILIO';
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
                } else if(response.message == 'MISSING_DOCUMENTS'){
                    $('#save3').prop('disabled', false);
                    $('#modal3').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Asegúrate de incluir los documentos; IDENTIFICACIÓN OFICIAL "+comprobante_domicilio+", RECIBOS DE APARTADO Y ENGANCHE y DEPÓSITO DE SERIEDAD antes de llevar a cabo el avance.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save3').prop('disabled', false);
                    $('#modal3').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
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

$(document).on('click', '#b_return1', function(e) {
    e.preventDefault();
    var comentario = $("#comentario8").val();
    var validaComent = ($("#comentario8").val().length == 0) ? 0 : 1;
    var dataExp8 = new FormData();

    dataExp8.append("idCliente", return1a[0]);
    dataExp8.append("nombreResidencial", return1a[1]);
    dataExp8.append("nombreCondominio", return1a[2]);
    dataExp8.append("idCondominio", return1a[3]);
    dataExp8.append("nombreLote", return1a[4]);
    dataExp8.append("idLote", return1a[5]);
    dataExp8.append("comentario", comentario);
    dataExp8.append("fechaVenc", return1a[6]);
    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }

    if (validaComent == 1) {
        $('#b_return1').prop('disabled', true);
        $.ajax({
            url : general_base_url+'asesor/return1aaj/',
            data: dataExp8,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#b_return1').prop('disabled', false);
                    $('#modal_return1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#b_return1').prop('disabled', false);
                    $('#modal_return1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#b_return1').prop('disabled', false);
                    $('#modal_return1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function( data ){
                $('#b_return1').prop('disabled', false);
                $('#modal_return1').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on("click", ".enviar_nuevamente_estatus3", function (e) {
    e.preventDefault();
    getInfo2A[0] = $(this).attr("data-idCliente");
    getInfo2A[1] = $(this).attr("data-nombreResidencial");
    getInfo2A[2] = $(this).attr("data-nombreCondominio");
    getInfo2A[3] = $(this).attr("data-idCondominio");
    getInfo2A[4] = $(this).attr("data-nombreLote");
    getInfo2A[5] = $(this).attr("data-idLote");
    getInfo2A[6] = $(this).attr("data-fechavenc");
    nombreLote = $(this).data("nomlote");
    tipo_comprobante = $(this).attr('data-ticomp');
    $(".lote").html(nombreLote);
    $('#enviarNuevamenteEstatus3PV').modal('show');
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

    jQuery('#modal_return1').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario8').val('');
    })
})

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
});

