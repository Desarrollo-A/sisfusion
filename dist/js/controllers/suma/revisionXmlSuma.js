function cleanCommentsPDF() {
    $('#seeInformationModalPDF').modal('toggle');
    var myCommentsList = document.getElementById('pdfbody');
    var myCommentsLote = document.getElementById('pdffooter');
    myCommentsList.innerHTML = '';
    myCommentsLote.innerHTML = ''; 
}
$("#EditarPerfilForm").on('submit', function(e){
    document.getElementById('sendFile').disabled =true; 
    $("#sendFile").prop("disabled", true);
    e.preventDefault();	
    var formData = new FormData(document.getElementById("EditarPerfilForm"));
    formData.append("dato", "valor");   
    $.ajax({
        type: 'POST',
        url: general_base_url+'index.php/Comisiones/SubirPDF',
        data: formData,
        contentType: false,
        cache: false,
        processData:false,
        success: function(data) {
            if (data == 1) {
                cleanCommentsPDF();
                $("#sendFile").prop("disabled", false);
                setTimeout(function() {
                    tabla_factura.ajax.reload();
                }, 100);
                alerts.showNotification("top", "right", "El registro se ha ingresado exitosamente.", "success");    
            }
            else {
                cleanCommentsPDF();
                $("#seeInformationModalPDF").modal('hide'); 
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function(){
            $("#seeInformationModalPDF").modal('hide'); 
            cleanCommentsPDF();
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

let titulos_intxt = [];
$('#tabla_factura thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos_intxt.push(title);
    $(this).html(`<input type="text" class="textoshead w-100" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function() {
        if (tabla_factura.column(i).search() !== this.value) {
            tabla_factura.column(i).search(this.value).draw();
            var total = 0;
            var index = tabla_factura.rows({
                selected: true,
                search: 'applied'
            }).indexes();
            var data = tabla_factura.rows(index).data();
            $.each(data, function(i, v) {
                total += parseFloat(v.total);
            });
            document.getElementById("totpagarfactura").textContent = formatMoney(total);
        }
    });
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});

$('#tabla_factura').on('xhr.dt', function(e, settings, json, xhr) {
    var total = 0;
    $.each(json.data, function(i, v) {
        total += parseFloat(v.total);
    });
    var to = formatMoney(total);
    document.getElementById("totpagarfactura").textContent = to;
});

tabla_factura = $("#tabla_factura").DataTable({
    dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
    width: '100%',
    scrollX:true,
    buttons: [{
        text: 'XMLS',
        action: function(){
            if(id_rol_general == 68 || id_rol_general == 31 || id_rol_general== 32){
                window.location = general_base_url+'SUMA_XML/descargar_XML';
            }
            else{
                alerts.showNotification("top", "right", "No tienes permisos para descargar archivos.", "warning");
            }
        },
        attr: {
            class: 'btn btn-azure',
            style: 'position: relative; float: right;',
        }
    },
    {
        text: 'OPINIONES CUMPLIMIENTO',
        action: function(){
            if(id_rol_general == 68 || id_rol_general == 31 || id_rol_general== 32){
                window.location = general_base_url+'SUMA_XML/descargar_PDF';
            }
            else{
                alerts.showNotification("top", "right", "No tienes permisos para descargar archivos.", "warning");
            }
        },
        attr: {
            class: 'btn buttons-pdf',
            style: 'position: relative; float: right;',
        }
    },
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo de Excel',
        title: 'COMISIONES NUEVAS XML Y OC',
        exportOptions: {
            columns: [ 1, 2, 3, 4],
            format: {
                header: function (d, columnIdx) {
                    return ' ' + titulos_intxt[columnIdx ] + ' ';
                }
            }
        },
    }],
    pagingType: "full_numbers",
    fixedHeader: true,
    language: {
        url: general_base_url + "/static/spanishLoader_v2.json",
        paginate: {
            previous: "<i class='fa fa-angle-left'>",
            next: "<i class='fa fa-angle-right'>"
        }
    },
    destroy: true,
    ordering: false,
    columns: [
    {
        "className": 'details-control',
        "orderable": false,
        "data" : null,
        "defaultContent": '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
    },
    {
        "data": function( d ){
            return '<p class="m-0">'+d.id_usuario+'</p>';
        }
    },
    {
        "data": function( d ){
            return '<p class="m-0">'+d.usuario+'</p>';
        }
    },
    {
        "data": function( d ){
            return '<p class="m-0"><b>'+formatMoney(d.total)+'</b></p>';
        }
    },
    {
        "data": function( d ){
            if(d.estatus_opinion == 1 || d.estatus_opinion == 2){
            return '<span class="label lbl-yellow">OPINIÓN DE CUMPLIMIENTO</span>';
            }else{
                return '<span class="label lbl-gray">SIN ARCHIVO</span>';
            }
        }
    },
    {
        "orderable": false,
        "data": function( data ){
            var BtnStats ='';
            let btnpdf = '';
            let btnpausar = '';
            if(data.estatus_opinion != 1 || data.estatus_opinion != 2){
                BtnStats = '<button value="'+data.uuid+'" data-value="'+data.idResidencial+'" data-userfactura="'+data.usuario+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_documentos" data-toggle="tooltip" data-placement="top" title="DETALLES">' +'<i class="fas fa-info"></i></button>';
            }
            return '<div class="d-flex justify-center">'+BtnStats+btnpdf+btnpausar+'</div>';
        }
    }],
    columnDefs: [{
        "searchable": false,
        "orderable": false,
        "targets": 0
    }],
    ajax: {
        "url": general_base_url + "Suma/getDatosNuevasXSuma/",
        "type": "POST",
        cache: false,
        "data": function( d ){
        }
    },
    initComplete: function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    },
});
$('#tabla_factura tbody').on('click', 'td.details-control', function () {
    console.log("entra");
    var tr = $(this).closest('tr');
    var row = tabla_factura.row(tr);
    console.log(row.child.isShown());
    if ( row.child.isShown() ) {
        row.child.hide();
        tr.removeClass('shown');
        $(this).parent().find('.animacion').removeClass("fa-caret-down").addClass("fa-caret-right");
    }
    else {
        if( row.data().solicitudes == null || row.data().solicitudes == "null" ){
            $.post( general_base_url + "Suma/carga_listado_factura" , { "id_usuario" : row.data().id_usuario } ).done( function( data ){
                row.data().solicitudes = JSON.parse( data );
                tabla_factura.row( tr ).data( row.data() );
                row = tabla_factura.row( tr );
                row.child( construir_subtablas( row.data().solicitudes ) ).show();
                tr.addClass('shown');
                $(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
            });
        }
        else{
            row.child( construir_subtablas( row.data().solicitudes ) ).show();
            tr.addClass('shown');
            $(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
        }
    }
});

function construir_subtablas( data ){
    var solicitudes = '<table class="table">';
    $.each( data, function( i, v){ 
        solicitudes += '<tr>';
        solicitudes += '<td><b>'+(i+1)+'</b></td>';
        solicitudes += '<td>'+'<b>'+'ID PAGO: '+'</b> '+v.id_pago_suma+'</td>';
        solicitudes += '<td>'+'<b>'+'REFERENCIA: '+'</b> '+v.referencia+'</td>';
        solicitudes += '<td>'+'<b>'+'MONTO: '+'</b>'+formatMoney(v.total_comision)+'</td>';
        solicitudes += '</tr>';
    });
    return solicitudes += '</table>';
}

$("#tabla_factura tbody").on("click", ".consultar_documentos", function(e){
    $("#seeInformationModalfactura .modal-body").html("");
    e.preventDefault();
    e.stopImmediatePropagation();
    uuid = $(this).val();
    id_usuario = $(this).attr("data-value");
    user_factura = $(this).attr("data-userfactura");
    $("#seeInformationModalfactura").modal();
    $.getJSON( general_base_url + "Suma/getDatosFactura/"+uuid+"/"+id_usuario).done( function( data ){
        $("#seeInformationModalfactura .modal-body").append('<div class="row">');
        let uuid,fecha,folio,tot,descripcion;
        if (!data.datos_solicitud['uuid'] == '' && !data.datos_solicitud['uuid'] == '0'){
            $.get(general_base_url+"Suma/GetDescripcionXML/"+data.datos_solicitud['nombre_archivo']).done(function (dat) {
                let datos = JSON.parse(dat);
                uuid = datos[0][0];
                fecha = datos[1][0];
                folio = datos[2][0];
                tot = datos[3][0];
                descripcion = datos[4];
                $("#seeInformationModalfactura .modal-body").append('<BR><div class="col-md-12"><label style="font-size:14px; margin:0; color:gray;"><b>NOMBRE EMISOR</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['nombre']+' '+data.datos_solicitud['apellido_paterno']+' '+data.datos_solicitud['apellido_materno']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#seeInformationModalfactura .modal-body").append('<div class="col-md-6"><label style="font-size:14px; margin:0; color:gray;"><b>TOTAL FACT.</b></label><br><label style="font-size:12px; margin:0; color:gray;">$ '+tot+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#seeInformationModalfactura .modal-body").append('<div class="col-md-6"><label style="font-size:14px; margin:0; color:gray;"><b>MONTO COMISIÓN.</b></label><br><label style="font-size:12px; margin:0; color:gray;">$ '+data.datos_solicitud['porcentaje_dinero']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#seeInformationModalfactura .modal-body").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>FECHA FACTURA</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+fecha+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#seeInformationModalfactura .modal-body").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>FECHA CAPTURA</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['fecha_ingreso']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#seeInformationModalfactura .modal-body").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>MÉTODO</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['metodo_pago']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#seeInformationModalfactura .modal-body").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>RÉGIMEN F.</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['regimen']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#seeInformationModalfactura .modal-body").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>FORMA P.</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['forma_pago']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#seeInformationModalfactura .modal-body").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>CFDI</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['cfdi']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#seeInformationModalfactura .modal-body").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>UNIDAD</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['unidad']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#seeInformationModalfactura .modal-body").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>CLAVE PROD.</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['claveProd']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#seeInformationModalfactura .modal-body").append('<div class="col-md-6"><label style="font-size:14px; margin:0; color:gray;"><b>UUID</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+uuid+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#seeInformationModalfactura .modal-body").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>FOLIO</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+folio+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#seeInformationModalfactura .modal-body").append('<div class="col-md-12"><label style="font-size:14px; margin:0; color:gray;"><b>DESCRIPCIÓN</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+descripcion+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
            });
        }
        else {
            $("#seeInformationModalfactura .modal-body").append('<div class="col-md-12"><label>NO HAY DATOS A MOSTRAR</label></div>');
        }
        $("#seeInformationModalfactura .modal-body").append('</div>');
    });
});

/*  FIN DE TABLA    */
/*  REFACTURACIÓN   */
function xml2(id_user) {
    subir_xml2($("#xmlfile2"),id_user);
}

function subir_xml2(input,id_user) {
    var data = new FormData();
    documento_xml = input[0].files[0];
    var xml = documento_xml;
    data.append("xmlfile", documento_xml);
    $.ajax({
        url: general_base_url + "Comisiones/cargaxml2/"+id_user,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        method: 'POST',
        type: 'POST', // For jQuery < 1.9
        success: function(data) {
            if (data.respuesta[0]) {
                documento_xml = xml;
                var informacion_factura = data.datos_xml;
                cargar_info_xml2(informacion_factura);
            }
            else {
                input.val('');
                alert.showNotification("top", "right",data.respuesta[1], "warning");
            }
        },
        error: function(data) {
            input.val('');
            alerts.showNotification("top", "right", "ERROR INTENTE COMUNICARSE CON EL PROVEEDOR.", "warning");    
        }
    });
}

function cargar_info_xml2(informacion_factura){
    let totalSeleccionado = $('#totalxml').val();
    let cantidadXml = Number.parseFloat(informacion_factura.total[0]);
    if((parseFloat(totalSeleccionado) + .10).toFixed(2) >= cantidadXml.toFixed(2) && cantidadXml.toFixed(2) >= (parseFloat(totalSeleccionado) - .10).toFixed(2)){
        var myCommentsList = document.getElementById('cantidadSeleccionadaMal');
        myCommentsList.setAttribute('style', 'color:green;');
        myCommentsList.innerHTML = 'Cantidad correcta';
        document.getElementById('sendFile').disabled = false;
    }
    else{
        var myCommentsList = document.getElementById('cantidadSeleccionadaMal');
        myCommentsList.setAttribute('style', 'color:red;');
        myCommentsList.innerHTML = 'Cantidad incorrecta';
        document.getElementById('sendFile').disabled = true;
        alerts.showNotification("top", "right", "El total del XML no es igual al monto seleccionado.", "warning");
    }
    $("#emisor").val((informacion_factura.nameEmisor ? informacion_factura.nameEmisor[0] : '')).attr('readonly', true);
    $("#rfcemisor").val((informacion_factura.rfcemisor ? informacion_factura.rfcemisor[0] : '')).attr('readonly', true);
    $("#receptor").val((informacion_factura.namereceptor ? informacion_factura.namereceptor[0] : '')).attr('readonly', true);
    $("#rfcreceptor").val((informacion_factura.rfcreceptor ? informacion_factura.rfcreceptor[0] : '')).attr('readonly', true);
    $("#regimenFiscal").val((informacion_factura.regimenFiscal ? informacion_factura.regimenFiscal[0] : '')).attr('readonly', true);
    $("#formaPago").val((informacion_factura.formaPago ? informacion_factura.formaPago[0] : '')).attr('readonly', true);
    $("#total").val(('$ ' + informacion_factura.total ? '$ ' + informacion_factura.total[0] : '')).attr('readonly', true);
    $("#cfdi").val((informacion_factura.usocfdi ? informacion_factura.usocfdi[0] : '')).attr('readonly', true);
    $("#metodopago").val((informacion_factura.metodoPago ? informacion_factura.metodoPago[0] : '')).attr('readonly', true);
    $("#unidad").val((informacion_factura.claveUnidad ? informacion_factura.claveUnidad[0] : '')).attr('readonly', true);
    $("#clave").val((informacion_factura.claveProdServ ? informacion_factura.claveProdServ[0] : '')).attr('readonly', true);
    $("#obse").val((informacion_factura.descripcion ? informacion_factura.descripcion[0] : '')).attr('readonly', true);
}

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable()
    .columns.adjust();
});

$(document).on('click', '.verPDF', function () {
    var $itself = $(this);
    Shadowbox.open({
        content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>static/documentos/cumplimiento/'+$itself.attr('data-usuario')+'"></iframe></div>',
        player:     "html",
        title:      "Visualizando archivo de cumplimiento: " + $itself.attr('data-usuario'),
        width:      985,
        height:     660
    });
});

$(window).resize(function(){
    tabla_factura.columns.adjust();
});