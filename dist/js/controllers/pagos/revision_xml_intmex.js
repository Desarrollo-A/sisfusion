function cleanCommentsfactura() {
    var myCommentsList = document.getElementById('comments-list-factura');
    var myCommentsLote = document.getElementById('nameLote');
    myCommentsList.innerHTML = '';
    myCommentsLote.innerHTML = '';
}

$('body').tooltip({
    selector: '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])',
    trigger: 'hover',
    container: 'body'
}).on('click mousedown mouseup', '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])', function () {
    $('[data-toggle="tooltip"], [title]:not([data-toggle="popover"])').tooltip('destroy');
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

var tr;
var tabla_factura2 ;

//INICIO TABLA QUERETARO
let titulos = [];
$('#tabla_factura thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
    $('input', this).on('keyup change', function() {
        if (tabla_factura2.column(i).search() !== this.value) {
            tabla_factura2
                .column(i)
                .search(this.value)
                .draw();
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
            document.getElementById("totpagarfactura").textContent = formatMoney(numberTwoDecimal(total));
        }
    });
});

function getFacturaCommissions(proyecto, condominio){
    $('#tabla_factura').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.total);
        });
        var to = formatMoney(numberTwoDecimal(total));
        document.getElementById("totpagarfactura").textContent = to;
    });

    $("#tabla_factura").prop("hidden", false);
    tabla_factura2 = $("#tabla_factura").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        bAutoWidth: true,
        scrollX: true,
        buttons: [{
            text: 'XMLS',
            action: function(){
                    window.location = general_base_url+'XMLDownload/descargar_XML';
            },
            attr: {
                class: 'btn btn-azure ml-1',
                style: 'position: relative;',
            }
        },
        {
            text: 'Opiniones de cumplimiento',
            action: function(){            
                $('#spiner-loader').removeClass('hide');   
                window.location = general_base_url+'XMLDownload/descargar_PDF';
                $('#spiner-loader').addClass('hide');
            },
            attr: {
                class: 'btn buttons-pdf',
                style: 'position: relative;',
            }
        },
        {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            title: 'CONCENTRADO_FACTURAS',
            exportOptions: {
                columns: [1,2,3,4,5,6],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
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
            "className": 'details-control',
            "orderable": false,
            data : null,
            "defaultContent": '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
        },
        {
            data: function( d ){
                return '<p>'+d.usuario+'</p>';
            }
        },
        {
            data: function( d ){
                return '<p>'+d.rfc+'</p>';
            }
        },
        {
            data: function( d ){
                return '<p><b> '+formatMoney(numberTwoDecimal(d.total))+'</b></p>';
            }
        },
        {
            data: function( d ){
                return '<p>'+d.proyecto+'</p>';
            }
        },
        {
            data: function( d ){
                return '<p><b>'+d.empresa+'</b></p>';
            }
        },
        {
            data: function( d ){
                if(d.estatus_opinion == 1 || d.estatus_opinion == 2){
                    return '<span class="label lbl-yellow">OPINIÓN DE CUMPLIMIENTO</span>';
                }else{
                    return '<span class="label lbl-gray">SIN ARCHIVO</span>';
                }
            }
        },
        {
            "orderable": false,
            data: function( data ){
                var BtnStats;
                if(data.estatus_opinion == 1 || data.estatus_opinion == 2){
                    BtnStats = '<button href="#" value="'+data.uuid+'" data-value="'+data.idResidencial+'" data-userfactura="'+data.usuario+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_documentos" title="Detalle de factura">' +'<i class="fas fa-info"></i></button><a href="#" class="btn-data btn-gray verPDF" title= "Ver opinión de cumplimiento" data-usuario="'+data.archivo_name+'" ><i class="fas fa-file-alt"></i></a>';
                }
                else{
                    BtnStats = '<button href="#" value="'+data.uuid+'" data-value="'+data.idResidencial+'" data-userfactura="'+data.usuario+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_documentos" title="Detalles">' +'<i class="fas fa-info"></i></button>';
                }
                return '<div class="d-flex justify-center">'+BtnStats+'</div>';
            }
        }],
        columnDefs: [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        ajax: {
            "url": general_base_url + "Pagos/getDatosNuevasXContraloria/",
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
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
        }
        else {
            if( row.data().solicitudes == null || row.data().solicitudes == "null" ){
                $.post( general_base_url + "Pagos/carga_listado_factura" , { "idResidencial" : row.data().idResidencial, "id_usuario" : row.data().id_usuario } ).done( function( data ){
                    row.data().solicitudes = JSON.parse( data );
                    tabla_factura2.row( tr ).data( row.data() );
                    row = tabla_factura2.row( tr );
                    row.child( construir_subtablas( row.data().solicitudes ) ).show();
                    tr.addClass('shown');
                    $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
                });
            }
            else{
                row.child( construir_subtablas( row.data().solicitudes ) ).show();
                tr.addClass('shown');
                $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
            }
        }
    });

    function construir_subtablas( data ){
        var solicitudes = '<div class="container subBoxDetail">';
        $.each( data, function( i, v){ 
            solicitudes += '<div class="row"><div class="col-xs-1 col-sm-1 col-sm-1 col-lg-1"><label><b>'+(i+1)+'</b></label></div>';
            solicitudes += '<div class="col-xs-2 col-sm-2 col-sm-2 col-lg-2"><label><b>ID: </b>'+v.id_pago_i+'</label></div>';
            solicitudes += '<div class="col-xs-2 col-sm-2 col-sm-2 col-lg-2"><label><b>CONDOMINIO: </b>'+v.condominio+'</label></div>';
            solicitudes += '<div class="col-xs-2 col-sm-2 col-sm-2 col-lg-2"><label><b>LOTE: </b>'
            +v.lote+'</label></div>';
            solicitudes += '<div class="col-xs-2 col-sm-2 col-sm-2 col-lg-2"><label><b>MONTO: </b>'+formatMoney(numberTwoDecimal(v.pago_cliente))+'</label></div>';
            solicitudes += '<div class="col-xs-3 col-sm-3 col-sm-3 col-lg-3"><label><b>USUARIO: </b>'+v.usuario+'</label></div></div>';
            
        });          
        return solicitudes + '</div>';
    }

    $("#tabla_factura tbody").on("click", ".consultar_documentos", function(e){
        $("#seeInformationModalfactura .modal-body").html("");
        e.preventDefault();
        e.stopImmediatePropagation();
        id_usuario = $(this).val();
        id_residencial = $(this).attr("data-value");
        user_factura = $(this).attr("data-userfactura");
        $("#seeInformationModalfactura").modal();
        $.getJSON( general_base_url + "Pagos/getDatosFactura/"+id_usuario+"/"+id_residencial).done( function( data ){
            $("#seeInformationModalfactura .modal-body").append('<div class="row">');
            let uuid,fecha,folio,tot,descripcion;
            if (!data.datos_solicitud['uuid'] == '' && !data.datos_solicitud['uuid'] == '0'){
                $.get(general_base_url+"Pagos/GetDescripcionXML/"+data.datos_solicitud['nombre_archivo']).done(function (dat) {
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

//FIN TABLA  
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable()
    .columns.adjust();
});

$(window).resize(function(){
    tabla_factura2.columns.adjust();
});

function preview_info(archivo){
    $("#documento_preview .modal-dialog").html("");
    $("#documento_preview").css('z-index', 9999);
    archivo = general_base_url+"dist/documentos/"+archivo+"";
    var re = /(?:\.([^.]+))?$/;
    var ext = re.exec(archivo)[1];
    elemento = "";
    if (ext == 'pdf'){
        elemento += '<iframe src="'+archivo+'" style="overflow:hidden; width: 100%; height: -webkit-fill-available">';
        elemento += '</iframe>';
        $("#documento_preview .modal-dialog").append(elemento);
        $("#documento_preview").modal();
    }
    if(ext == 'jpg' || ext == 'jpeg'){
        elemento += '<div class="modal-content" style="background-color: #333; display:flex; justify-content: center; padding:20px 0">';
        elemento += '<img src="'+archivo+'" style="overflow:hidden; width: 40%;">';
        elemento += '</div>';
        $("#documento_preview .modal-dialog").append(elemento);
        $("#documento_preview").modal();
    }
    if(ext == 'xlsx'){
        elemento += '<div class="modal-content">';
        elemento += '<iframe src="'+archivo+'"></iframe>';
        elemento += '</div>';
        $("#documento_preview .modal-dialog").append(elemento);
    }
}

function cleanComments(){
    var myCommentsList = document.getElementById('documents');
    myCommentsList.innerHTML = '';
    var myFactura = document.getElementById('facturaInfo');
    myFactura.innerHTML = '';
}


$(document).ready( function(){
    $.getJSON( general_base_url + "Pagos/getReporteEmpresa").done( function( data ){
        $(".report_empresa").html();
        $.each( data, function( i, v){
            $(".report_empresa").append('<div class="col xol-xs-3 col-sm-3 col-md-3 col-lg-3"><label style="color: #00B397;">&nbsp;'+v.empresa+': $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #00B397; font-weight: bold;" value="'+formatMoney(v.porc_empresa)+'" disabled="disabled" readonly="readonly" type="text"  name="myText_FRO" id="myText_FRO"></label></div>');
        });
    });
});


$(document).on('click', '.verPDF', function () {
    var $itself = $(this);
    Shadowbox.open({
        content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="'+general_base_url+'static/documentos/cumplimiento/'+$itself.attr('data-usuario')+'"></iframe></div>',
        player:     "html",
        title:      "Visualizando archivo de cumplimiento: " + $itself.attr('data-usuario'),
        width:      985,
        height:     660
    });
});