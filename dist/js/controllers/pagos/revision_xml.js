var url = "<?=base_url()?>";

var rol = id_rol_global;

function cleanCommentsfactura() {
    var myCommentsList = document.getElementById('comments-list-factura');
    var myCommentsLote = document.getElementById('nameLote');
    myCommentsList.innerHTML = '';
    myCommentsLote.innerHTML = '';
}

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
        url: general_base_url+'/pagos/SubirPDF',
        data: formData,
        contentType: false,
        cache: false,
        processData:false,
        success: function(data) {
            if (data == 1) {
                cleanCommentsPDF();
                $("#sendFile").prop("disabled", false);

                setTimeout(function() {
                    tabla_factura2.ajax.reload();
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

$(document).ready(function() {
    $("#tabla_factura").prop("hidden", true);
    $.post(general_base_url+"Contratacion/lista_proyecto", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];
            $("#filtro33").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#filtro33").selectpicker('refresh');
    }, 'json');
});

$('#filtro33').change(function(ruta){
    residencial = $('#filtro33').val();
    $("#filtro44").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url+'Asesor/getCondominioDesc/'+residencial,
        type: 'post',
        dataType: 'json',
        success:function(response){
            var len = response.length;
            for( var i = 0; i<len; i++){
                var id = response[i]['idCondominio'];
                var name = response[i]['nombre'];
                $("#filtro44").append($('<option>').val(id).text(name));
            }
            $("#filtro44").selectpicker('refresh');
        }
    });
});


$('#filtro33').change(function(ruta){
    proyecto = $('#filtro33').val();
    condominio = $('#filtro44').val();
    if(condominio == '' || condominio == null || condominio == undefined){
        condominio = 0;
    }
    console.log(proyecto);
    console.log(condominio);
    getFacturaCommissions(proyecto, condominio);
});

$('#filtro44').change(function(ruta){
    proyecto = $('#filtro33').val();
    condominio = $('#filtro44').val();
    if(condominio == '' || condominio == null || condominio == undefined){
        condominio = 0;
    }
    getFacturaCommissions(proyecto, condominio);
});


var totalLeon = 0;
var totalQro = 0;
var totalSlp = 0;
var totalMerida = 0;
var totalCdmx = 0;
var totalCancun = 0;
var tr;
var tabla_factura2 ;
var totaPen = 0;
//INICIO TABLA QUERETARO******************************************
let titulos = [];

$('#tabla_factura thead tr:eq(0) th').each( function (i) {
    if(i != 15 && i != 0){
        var title = $(this).text();
        titulos.push(title);
        $(this).html('<input class="textoshead" type="text" placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function() {
            if (tabla_factura2.column(i).search() !== this.value) {
                tabla_factura2.column(i).search(this.value).draw();

                var total = 0;
                var index = tabla_factura2.rows({
                    selected: true,
                    search: 'applied'
                }).indexes();
                var data = tabla_factura2.rows(index).data();

                $.each(data, function(i, v) {
                    total += parseFloat(v.total);
                });
                var to1 = formatMoney(total);
                document.getElementById("totpagarfactura").textContent = formatMoney(total);
            }
        });
    }
});

function getFacturaCommissions(proyecto, condominio){
    $('#tabla_factura').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.total);
        });
        var to = formatMoney(total);
        document.getElementById("totpagarfactura").textContent = '$' + to;
    });

    $("#tabla_factura").prop("hidden", false);
    tabla_factura2 = $("#tabla_factura").DataTable({
        dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
        width: 'auto',
        buttons: [{
            text: 'XMLS',
            action: function(){
                if(rol == 17 || rol == 13 || rol == 31 || rol== 32){
                    window.location = general_base_url+'XMLDownload/descargar_XML';
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
                if(rol == 17 || rol == 13 || rol == 31 || rol== 32){
                    window.location = general_base_url+'XMLDownload/descargar_PDF';
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
            title: 'CONCENTRADO_FACTURAS',
            exportOptions: {
                columns: [1,2,3,4,5],
                format: {
                    header:  function (d, columnIdx) {
                        if(columnIdx == 0){
                            return ' '+d +' ';
                        }else if(columnIdx == 1){
                            return 'USUARIO';
                        }else if(columnIdx == 2){
                            return 'MONTO ACUMULADO';
                        }else if(columnIdx == 3){
                            return 'PROYECTO';
                        }else if(columnIdx == 4){
                            return 'EMPRESA ';
                        }else if(columnIdx == 5){
                            return 'OPINIÓN CUMPLIMIENTO';
                        }else if(columnIdx != 15 && columnIdx !=0){
                            return ' '+titulos[columnIdx-1] +' ';
                        }
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url+"/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            "width": "3%",
            "className": 'details-control',
            "orderable": false,
            "data" : null,
            "defaultContent": '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
        },
        {
            "width": "15%",
            "data": function( d ){
                return '<p class="m-0">'+d.usuario+'</p>';
            }
        },
        {
            "width": "15%",
            "data": function( d ){
                return '<p class="m-0"><b> $'+formatMoney(d.total)+'</b></p>';
            }
        },{
            "width": "15%",
            "data": function( d ){
                return '<p class="m-0">'+d.proyecto+'</p>';
            }
        },
        {
            "width": "15%",
            "data": function( d ){
                return '<p class="m-0"><b>'+d.empresa+'</b></p>';
            }
        },
        {
            "width": "15%",
            "data": function( d ){

                if(d.estatus_opinion == 1 || d.estatus_opinion == 2){
                return '<span class="label label-success" style="background:#F1C40F;">OPINIÓN DE CUMPLIMIENTO</span>';
                }else{
                    return '<span class="label" style="background:#A6A6A6;">SIN ARCHIVO</span>';
                }
            }
        },
        {
            "width": "15%",
            "orderable": false,
            "data": function( data ){
                var BtnStats ='';
                let btnpdf = '';
                let btnpausar = '';
                if(data.estatus_opinion == 1 || data.estatus_opinion == 2){
                    if(rol == 2 || rol == 3 || rol == 7 || rol==9){
                        let namefile2 = data.xmla.split('.');
                        if(data.bandera != 3 ){
                            btnpdf = '<button value="'+data.uuid+'" data-userfactura="'+data.usuario+'" data-file="'+data.xmla+'" class="btn-data btn-green subirPDF" title="Subir PDF">' +'<i class="fas fa-upload"></i></button>';
                        }
                        else{
                            btnpdf = '<a class="btn-data btn-warning verPDF2" title= "Ver pdf" data-usuario="'+namefile2[0]+'" ><i class="fas fa-file-pdf"></i></a>';
                        }
                    }
                    else{
                        BtnStats = '<button href="#" value="'+data.uuid+'" data-value="'+data.idResidencial+'" data-userfactura="'+data.usuario+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_documentos" title="Detalle de factura">' +'<i class="fas fa-info"></i></button><a href="#" class="btn-data btn-warning verPDF" title= "Ver opinión de cumplimiento" data-usuario="'+data.archivo_name+'" ><i class="material-icons">description</i></a>';
            
                        let namefile = data.xmla.split('.');
                        if(data.bandera != 3 ){
                            btnpdf = '<button value="'+data.uuid+'" data-userfactura="'+data.usuario+'" data-file="'+data.xmla+'" class="btn-data btn-blueMaderas subirPDF" title="Subir PDF">' +'<i class="fas fa-upload"></i></button>';
                        }
                        else{
                            btnpdf = '<a class="btn-data btn-warning verPDF2" title= "Ver pdf" data-usuario="'+namefile[0]+'" ><i class="fas fa-file-pdf"></i></a>';
                        }

                        btnpausar = '<button value="'+data.uuid+'" data-id_user="'+data.id_usuario+'" data-userfactura="'+data.usuario+'" data-total="'+data.total+'" class="btn-data btn-violetChin regresar" title="Refacturar">' +'<span class="material-icons">autorenew</span></button>';
                    }
                }
                else{
                    BtnStats = '<button value="'+data.uuid+'" data-value="'+data.idResidencial+'" data-userfactura="'+data.usuario+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_documentos" title="Detalles">' +'<i class="fas fa-info"></i></button>';
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
            "url": general_base_url + "pagos/getDatosNuevasXContraloria/",
            "type": "POST",
            cache: false,
            data:{
                proyecto:proyecto,
                condominio:condominio,
            }
        },
    });


    $('#tabla_factura tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tabla_factura2.row(tr);

        if ( row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');
            $(this).parent().find('.animacion').removeClass("fa-caret-down").addClass("fa-caret-right");
        }
        else {
            if( row.data().solicitudes == null || row.data().solicitudes == "null" ){
                $.post( general_base_url + "Pagos/carga_listado_factura" , { "idResidencial" : row.data().idResidencial, "id_usuario" : row.data().id_usuario } ).done( function( data ){
                    row.data().solicitudes = JSON.parse( data );
                    tabla_factura2.row( tr ).data( row.data() );
                    row = tabla_factura2.row( tr );
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
            solicitudes += '<td>'+'<b>'+'ID: '+'</b> '+v.id_pago_i+'</td>';
            solicitudes += '<td>'+'<b>'+'CONDOMINIO: '+'</b> '+v.condominio+'</td>';
            solicitudes += '<td>'+'<b>'+'LOTE: '+'</b> '+v.lote+'</td>';
            solicitudes += '<td>'+'<b>'+'MONTO: '+'</b> $'+formatMoney(v.pago_cliente)+'</td>';
            solicitudes += '<td>'+'<b>'+'USUARIO: '+'</b> '+v.usuario+'</td>';
            solicitudes += '</tr>';
        });          

        return solicitudes += '</table>';
    }

  
    $("#tabla_factura tbody").on("click", ".subirPDF", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        uuid = $(this).val();
        user_factura = $(this).attr("data-userfactura");
        xmlfname = $(this).attr("data-file");
        $("#seeInformationModalPDF").modal();

        $("#seeInformationModalPDF .modal-body").append(`
        <div class="input-group">
            <input type="hidden" name="opc" id="opc" value="1">
            <input type="hidden" name="uuid" id="uuid" value="${uuid}">
            <input type="hidden" name="user" id="user" value="${user_factura}">
            <input type="hidden" name="xmlfile" id="xmlfile" value="${xmlfname}">

            <label  class="input-group-btn">
            </label>
            <span class="btn btn-primary">
            <i class="fa fa-cloud-upload"></i> Subir archivo
            <input id="file-uploadE" name="file-uploadE" required  accept="application/pdf" type="file"   / >
            </span>
            <p id="archivoE"></p>
        </div>`);

        $("#seeInformationModalPDF .modal-footer").append(`
            <button type="submit" id="sendFile" class="btn btn-primary"><span
            class="material-icons" >send</span> Guardar documento </button>
            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsPDF()"><b>Cerrar</b></button>`);
    });

    $("#tabla_factura tbody").on("click", ".regresar", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        uuid = $(this).val();
        usuario = $(this).attr("data-userfactura");
        total = $(this).attr("data-total");
        id_user = $(this).attr("data-id_user");

        $("#seeInformationModalPDF").modal();
        $("#seeInformationModalPDF .modal-body").append(`
        <div class="input-group">
        <input type="hidden" name="opc" id="opc" value="4">

        <input type="hidden" name="uuid2" id="uuid2" value="${uuid}">
        <input type="hidden" name="totalxml" id="totalxml" value="${total}">
        <input type="hidden" name="id_user" id="id_user" value="${id_user}">

        <h6>¿Estas seguro que deseas regresar esta factura de <b>${usuario}</b> por la cantidad de <b> $${formatMoney(total)}</b> ?</h6>
        <span>Motivo</span>
        <textarea id="motivo" name="motivo" class="form-control"></textarea>`);

        $("#seeInformationModalPDF .modal-body").append(`<div class="row">
            <div class="col-md-12 col-lg-12 text-left"></div></div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="fileinput fileinput-new text-center" data-provides="fileinput" style='width:250px'>
                        <div>
                            <br>
                            <span class="fileinput-new">Selecciona archivo XML</span>
                            <input type="file" name="xmlfile2" id="xmlfile2" accept="application/xml" style='width:250px'>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 ">
                    <button class="btn btn-warning" type="button" onclick="xml2(${id_user})" id="cargar_xml2"><i class="fa fa-upload"></i> VERIFICAR Y <br> CARGAR</button>
                </div>
            </div>`);
            
        $("#seeInformationModalPDF .modal-body").append('<b id="cantidadSeleccionadaMal"></b>');
        $("#seeInformationModalPDF .modal-body").append(
            '<div class="row"><div class="col-lg-3 form-group"><label for="emisor">Emisor:<span class="text-danger">*</span></label><input type="text" class="form-control" id="emisor" name="emisor" placeholder="Emisor" value="" required></div>' +
            '<div class="col-lg-3 form-group"><label for="rfcemisor">RFC Emisor:<span class="text-danger">*</span></label><input type="text" class="form-control" id="rfcemisor" name="rfcemisor" placeholder="RFC Emisor" value="" required></div><div class="col-lg-3 form-group"><label for="receptor">Receptor:<span class="text-danger">*</span></label><input type="text" class="form-control" id="receptor" name="receptor" placeholder="Receptor" value="" required></div>' +
            '<div class="col-lg-3 form-group"><label for="rfcreceptor">RFC Receptor:<span class="text-danger">*</span></label><input type="text" class="form-control" id="rfcreceptor" name="rfcreceptor" placeholder="RFC Receptor" value="" required></div>' +
            '<div class="col-lg-3 form-group"><label for="regimenFiscal">Régimen Fiscal:<span class="text-danger">*</span></label><input type="text" class="form-control" id="regimenFiscal" name="regimenFiscal" placeholder="Regimen Fiscal" value="" required></div>' +
            '<div class="col-lg-3 form-group"><label for="total">Monto:<span class="text-danger">*</span></label><input type="text" class="form-control" id="total" name="total" placeholder="Total" value="" required></div>' +
            '<div class="col-lg-3 form-group"><label for="formaPago">Forma Pago:</label><input type="text" class="form-control" placeholder="Forma Pago" id="formaPago" name="formaPago" value=""></div>' +
            '<div class="col-lg-3 form-group"><label for="cfdi">Uso del CFDI:</label><input type="text" class="form-control" placeholder="Uso de CFDI" id="cfdi" name="cfdi" value=""></div>' +
            '<div class="col-lg-3 form-group"><label for="metodopago">Método de Pago:</label><input type="text" class="form-control" id="metodopago" name="metodopago" placeholder="Método de Pago" value="" readonly></div><div class="col-lg-3 form-group"><label for="unidad">Unidad:</label><input type="text" class="form-control" id="unidad" name="unidad" placeholder="Unidad" value="" readonly> </div>' +
            '<div class="col-lg-3 form-group"> <label for="clave">Clave Prod/Serv:<span class="text-danger">*</span></label> <input type="text" class="form-control" id="clave" name="clave" placeholder="Clave" value="" required> </div> </div>' +
            ' <div class="row"> <div class="col-lg-12 form-group"> <label for="obse">OBSERVACIONES FACTURA <i class="fa fa-question-circle faq" tabindex="0" data-container="body" data-trigger="focus" data-toggle="popover" title="Observaciones de la factura" data-content="En este campo pueden ser ingresados datos opcionales como descuentos, observaciones, descripción de la operación, etc." data-placement="right"></i></label><br><textarea class="form-control" rows="1" data-min-rows="1" id="obse" name="obse" placeholder="Observaciones"></textarea> </div> </div><div class="row">  <div class="col-md-4"></div><div class="col-md-4"></div><div class="col-md-4"> </div></div>');

        $("#seeInformationModalPDF .modal-footer").append(`<button type="submit" id="sendFile" class="btn btn-primary"> Aceptar</button><button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsPDF()"><b>Cerrar</b></button>`);
    });

    /**----------------------------------------------------------------- */
 
    /**--------------------------------------------------- */
    $("#tabla_factura tbody").on("click", ".consultar_documentos", function(e){
        $("#seeInformationModalfactura .modal-body").html("");

        e.preventDefault();
        e.stopImmediatePropagation();

        uuid = $(this).val();
        id_residencial = $(this).attr("data-value");
        user_factura = $(this).attr("data-userfactura");
        $("#seeInformationModalfactura").modal();
        $.getJSON( general_base_url + "pagos/getDatosFactura/"+uuid+"/"+id_residencial).done( function( data ){
            $("#seeInformationModalfactura .modal-body").append('<div class="row">');
            let uuid,fecha,folio,tot,descripcion;
            if (!data.datos_solicitud['uuid'] == '' && !data.datos_solicitud['uuid'] == '0'){
                $.get(general_base_url+"pagos/GetDescripcionXML/"+data.datos_solicitud['nombre_archivo']).done(function (dat) {
                    let datos = JSON.parse(dat);
                    uuid = datos[0][0];
                    fecha = datos[1][0];
                    folio = datos[2][0];
                    
                    tot = datos[3][0];
                    descripcion = datos[4];

                    $("#seeInformationModalfactura .modal-body").append('<BR><div class="col-md-12"><label style="font-size:14px; margin:0; color:gray;"><b>NOMBRE EMISOR</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['nombre']+' '+data.datos_solicitud['apellido_paterno']+' '+data.datos_solicitud['apellido_materno']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                    $("#seeInformationModalfactura .modal-body").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b> PROYECTO</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['nombreLote']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                    $("#seeInformationModalfactura .modal-body").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>TOTAL FACT.</b></label><br><label style="font-size:12px; margin:0; color:gray;">$ '+tot+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                    $("#seeInformationModalfactura .modal-body").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>MONTO COMISIÓN.</b></label><br><label style="font-size:12px; margin:0; color:gray;">$ '+data.datos_solicitud['porcentaje_dinero']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

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
                $("#seeInformationModalfactura .modal-body").append('<div class="col-md-12"><label style="font-size:16px; margin:0; color:black;">NO HAY DATOS A MOSTRAR</label></div>');
            }
            $("#seeInformationModalfactura .modal-body").append('</div>');
        });
    });
}
//FIN TABLA  *****************************************************************

/**-----------------------REFACTURACIÓN---------------------------------- */
function xml2(id_user) {
    subir_xml2($("#xmlfile2"),id_user);
}

function subir_xml2(input,id_user) {
    var data = new FormData();
    documento_xml = input[0].files[0];
    
    var xml = documento_xml;
    data.append("xmlfile", documento_xml);
    $.ajax({
        url: general_base_url + "Pagos/cargaxml2/"+id_user,
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
                alert(data.respuesta[1]);
            }
        },
        error: function(data) {
            input.val('');
            alert("ERROR INTENTE COMUNICARSE CON EL PROVEEDOR");
        }
    });
}

function cargar_info_xml2(informacion_factura) {
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

/**---------------------------------------------------------- */
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable()
    .columns.adjust();
});

$(window).resize(function(){
    tabla_factura2.columns.adjust();
});

function formatMoney( n ) {
    var c = isNaN(c = Math.abs(c)) ? 2 : c,
    d = d == undefined ? "." : d,
    t = t == undefined ? "," : t,
    s = n < 0 ? "-" : "",
    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
    j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};


$(document).on('click', '.verPDF', function () {
    var $itself = $(this);
    Shadowbox.open({
        content:    `<div>
                        <iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" 
                            src="${general_base_url}static/documentos/cumplimiento/${$itself.attr('data-usuario')}"></iframe>
                    </div>` ,
        player:     "html",
        title:      "Visualizando archivo de cumplimiento: " + $itself.attr('data-usuario'),
        width:      985,
        height:     660

    });
});

$(document).on('click', '.verPDF2', function () {
    var $itself = $(this);
    Shadowbox.open({
        content:    `<div>
                        <iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" 
                        src="${general_base_url}UPLOADS/PDF/${$itself.attr('data-usuario')}.pdf"></iframe>
                    </div>`,
        player:     "html",
        title:      "Visualizando pdf: " + $itself.attr('data-usuario'),
        width:      985,
        height:     660
    });
});