
var totaPen = 0;
var tr;

$.post(general_base_url+"/Pagos/getEstatusPagosMktd", function (data) {
    var len = data.length;
    for (var i = 0; i < len; i++) {
        var id = data[i]['id_opcion'];
        var name = data[i]['nombre'];
        $("#selectEstatus").append($('<option>').val(id).text(name.toUpperCase()));
    }
}, 'json');

$.post(general_base_url+"/Pagos/getEstatusPagosMktd", function (data) {
    var len = data.length;
    for (var i = 0; i < len; i++) {
        var id = data[i]['id_opcion'];
        var name = data[i]['nombre'];
        $("#selectEstatusR").append($('<option>').val(id).text(name.toUpperCase()));
    }
}, 'json');

$("#tabla_plaza_1").ready( function(){
    let titulos = [];
    $('#tabla_plaza_1 thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();

        titulos.push(title);
        $(this).html('<input type="text" id="t-'+i+'" class="textoshead" placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if (plaza_1.column(i).search() !== this.value ) {
                plaza_1.column(i).search(this.value).draw();
                var total = 0;
                var index = plaza_1.rows({ selected: true, search: 'applied' }).indexes();
                var data = plaza_1.rows( index ).data();
                
                $.each(data, function(i, v){
                    total += parseFloat(v.sum_abono_marketing);
                });
                var to1 = formatMoney(total);
                document.getElementById("disponible_nuevas").textContent = to1;
            }
        });
    });
    
    let c=0;
    $('#tabla_plaza_1').on('xhr.dt', function ( e, settings, json, xhr ) {
        var total = 0;
        
        $.each(json.data, function(i, v){
            total += parseFloat(v.sum_abono_marketing);
        });
        var to = formatMoney(total);
        document.getElementById("disponible_nuevas").textContent = to;
    });

    plaza_1 = $("#tabla_plaza_1").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        bAutoWidth: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'MKTD_CONCENTRADO_PAGO_COMISIONES',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8],
                format: {
                    header: function (d, columnIdx) {
                        return ' '+titulos[columnIdx] +' ';
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url + "static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            "data": function( d ){
                return '<p class="m-0"><b>'+d.id_usuario+'</b></p>';
            }
        },
        {  
            "data": function( d ){
                return '<p class="m-0">'+d.colaborador+'</p>';
            }
        },
        {  
            "data": function( d ){
                return '<p class="m-0">'+d.rfc+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.sede+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.empresa+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+d.valimpuesto+'%</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.sum_abono_marketing)+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.dcto)+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+formatMoney(d.impuesto)+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.forma_pago+'</p>';
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets:   0,
            searchable:false,
            className: 'dt-body-center'
        }],
        ajax: {
            url: general_base_url + "Pagos/getDatosRevisionMktd",
            type: "POST",
            cache: false,
            data: function( d ){}
        },
    });

    $("#tabla_plaza_1 tbody").on("click", ".dispersar_colaboradores", function(){
        var tr = $(this).closest('tr');
        var row = plaza_1.row( tr );
        let c=0;                
        let ubication = $(this).attr("data-value");
        let plen = $(this).val();

        $.getJSON( general_base_url + "Pagos/getDatosSumaMktd/"+ubication+"/"+plen).done( function( data01 ){
            let suma_01 = parseFloat(data01[0].suma_f01);

            $("#modal_colaboradores .modal-body").html("");
            $("#modal_colaboradores .modal-footer").html("");
            $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p>Comisión total:&nbsp;&nbsp;<b>'+formatMoney(suma_01)+'</b></p> </div></div>');
            $("#modal_colaboradores .modal-body").append('<input type="hidden" name="total_comi" value="'+data01[0].suma_f01+'">');
            $("#modal_colaboradores .modal-body").append('<input type="hidden" name="num_plan" value="'+plen+'">');
            $("#modal_colaboradores .modal-body").append('<input type="hidden" name="valores_pago_i" value="'+data01[0].valor_obtenido+'">');
            $("#modal_colaboradores .modal-body").append('<input type="hidden" name="pago_mktd" id="pago_mktd" value="'+parseFloat(suma_01)+'">');

            $.getJSON( general_base_url + "Pagos/getDatosColabMktd/"+ubication+"/"+plen).done( function( data1 ){
                var_sum = 0;
                let fech = data1[0].fecha_plan;
                let fecha = fech.substr(0, 10);
                let nuevaFecha = fecha.split('-');
                let fechaCompleta = nuevaFecha[2]+'-'+nuevaFecha[1]+'-'+nuevaFecha[0];
                let fech2 = data1[0].fin_plan;
                let fecha2 = fech2.substr(0, 10);
                let nuevaFecha2 = fecha2.split('-');
                let fechaCompleta2 = nuevaFecha2[2]+'-'+nuevaFecha2[1]+'-'+nuevaFecha2[0];
                $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-4"><p style="color:blue;">Número plan:&nbsp;&nbsp;<b>'+data1[0].id_plan+'</b></p> </div>  <div class="col-lg-4"><p style="color:green;">Inicio:&nbsp;&nbsp;<b>'+fechaCompleta+'</b></p> </div>  <div class="col-lg-4"><p style="color:green;">Fin:&nbsp;&nbsp;<b>'+fechaCompleta2+'</b></p> </div> </div>');
            
                $.each( data1, function( i, v){
                    valor_money = ((v.porcentaje/100)*suma_01);
                    $("#modal_colaboradores .modal-body").append('<div class="row"><input type="hidden" name="user_mktd[]" value="'+v.id_usuario+'"><div class="col-md-5"><b><p>'+v.colaborador+'</p></b><p>'+v.rol+'</p><br></div>'
                    +'<div class="col-md-2"><input type="text" name="porcentaje_mktd[]" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+v.porcentaje+'%'+'"></div>'+'<div class="col-md-5"><input type="text" readonly name="abono_marketing[]" id="abono_marketing_'+i+'"  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+parseFloat(valor_money.toFixed(3))+'"></div>'
                    +'</div>');
                    var_sum +=  parseFloat(v.porcentaje);
                    c++;
                });

                var_sum2 = parseFloat(var_sum);
                new_valll = parseFloat((suma_01)-((suma_01/100)*var_sum2));
                new_valll2 = parseFloat((suma_01/100)*var_sum2);

                $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p>Comisión distribuida:&nbsp;&nbsp;<b>'+new_valll2.toFixed(3)+'</b></p> </div></div>');
                $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p>Comisión restante:&nbsp;&nbsp;<b style="color:red;">'+new_valll.toFixed(3)+'</b></p> </div></div>');
                $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p>Suma: <b id="Sumto" style="color:red;"></b></p> </div></div>');
                $("#modal_colaboradores .modal-body").append('<input type="hidden" name="cuantos" id="cuantos" value="'+c+'">');
            });

            $("#modal_colaboradores .modal-footer").append('<br><div class="row"><div class="col-md-6"><center><input type="submit" class="btn btn-success" value="DISPERSAR"></center></div><div class="col-md-6"><center><input type="button" class="btn btn-danger"  data-dismiss="modal" value="CANCELAR"></center></div></div>');
            $("#modal_colaboradores").modal();
        });
    });
});

$("#tabla_plaza_2").ready( function(){
    let titulos2 = [];
    $('#tabla_plaza_2 thead tr:eq(0) th').each( function (i) {
        if( i!=0 && i!=16){
            var title = $(this).text();
            titulos2.push(title);
            $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
            $( 'input', this ).on('keyup change', function () {

                if (plaza_2.column(i).search() !== this.value ) {
                    plaza_2.column(i).search(this.value).draw();
                    var total = 0;
                    var index = plaza_2.rows({ selected: true, search: 'applied' }).indexes();
                    var data = plaza_2.rows( index ).data();
                    $.each(data, function(i, v){
                        total += parseFloat(v.pago_cliente);
                    });
                    var to1 = formatMoney(total);
                    document.getElementById("myText_proceso").textContent = to1;
                }
            } );
        }
    });

    let c=0;
    $('#tabla_plaza_2').on('xhr.dt', function ( e, settings, json, xhr ) {
        var total = 0;
        $.each(json.data, function(i, v){
            total += parseFloat(v.pago_cliente);
        });
        var to = formatMoney(total);
        document.getElementById("myText_proceso").textContent = to;
    });


    plaza_2 = $("#tabla_plaza_2").DataTable({
        width: '100%',
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        scrollX: true,
        bAutoWidth: true,
        width: '100%',
        buttons:  [{
            text: '<i class="fa fa-check"></i>  MARCAR COMO PAGADO',
            action: function(){
                $.get(general_base_url+"Pagos/pago_internomex_MKTD/").done(function () {
                    plaza_2.ajax.reload();
                    plaza_1.ajax.reload();
                    var mensaje = "Comisiones del área <b>Marketing Dígital</b> fueron marcadas como <b>PAGADAS</b> correctamente.";
                    modalInformation(RESPUESTA_MODAL.SUCCESS, mensaje);
                });
            },
            attr: {
                class: 'btn btn-azure',
                style: '    position: relative; float: right;'
            }
        },
        {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'ASIMILADOS_CONTRALORÍA_SISTEMA_COMISIONES',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14],
                format: {
                    header: function (d, columnIdx) {
                        return ' '+ titulos2[columnIdx] +' ';
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
            "data": function( d ){
                return '<p class="m-0">'+d.id_pago_i+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.proyecto+'</p>';
            }
        },{
            "data": function( d ){
                return '<p class="m-0">'+d.condominio+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+d.lote+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.referencia+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.precio_lote)+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+d.empresa+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.comision_total)+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.pago_neodata)+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.pago_cliente)+'</p>';
            }
        },
        {
            "data": function( d ){
                if(d.lugar_prospeccion == 6){
                    return '<p class="m-0">COMISIÓN + MKTD <br><b> ('+d.porcentaje_decimal+'% de '+d.porcentaje_abono+'%)</b></p>';
                }
                else{
                    return '<p class="m-0">COMISIÓN <br><b> ('+d.porcentaje_decimal+'% de '+d.porcentaje_abono+'%)</b></p>';
                }
            
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+d.usuario+'</b></i></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+d.rfc+'</b></i></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><i> '+d.puesto+'</i></p>';
            }
        },
        {
            "data": function( d ){
                var BtnStats1;
                BtnStats1 =  '<p class="m-0">'+d.fecha_creacion+'</p>';
                return BtnStats1;
            }
        },
        {
            "orderable": false,
            "data": function( data ){
                var BtnStats;
                BtnStats = '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_asimilados" title="Detalles">' +'<i class="fas fa-info"></i></button>';
                return '<div class="d-flex justify-center">'+BtnStats+'</div>';
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets:   0,
            searchable:false,
            className: 'dt-body-center',
            select: {
                style:    'os',
                selector: 'td:first-child'
            },
        }],
        ajax: {
            "url": general_base_url + "pagos/getDatosNuevasmkContraloria",
            "type": "POST",
            cache: false,
            "data": function( d ){}
        },
    });

    $("#tabla_plaza_2 tbody").on("click", ".consultar_logs_asimilados", function(e){
        $("#nombreLote").html('');
        $("#comments-list-remanente").html('');
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        lote = $(this).attr("data-value");
        changeSizeModal('modal-md');
        appendBodyModal(`<div class="modal-body">
                        <div role="tabpanel">
                            <div id="nombreLote"></div>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="changelogTab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-plain">
                                                <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                                    <ul class="timeline-3" id="comentarioListaComisiones"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"><b>Cerrar</b></button>
                    </div>`);
        showModal();

        $("#nombreLote").append('<p><h5>HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
        $.getJSON("getComments/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comentarioListaComisiones").append('<li>\n' +
                '  <div class="container-fluid">\n' +
                '    <div class="row">\n' +
                '      <div class="col-md-6">\n' +
                '        <a><b> ' +v.comentario.toUpperCase()+ '</b></a><br>\n' +
                '      </div>\n' +
                '      <div class="float-end text-right">\n' +
                '        <a>' + v.fecha_movimiento.split(".")[0] + '</a>\n' +
                '      </div>\n' +
                '      <div class="col-md-12">\n' +
                '        <p class="m-0"><small>Usuario: </small><b> ' + v.nombre_usuario + '</b></p>\n'+
                '      </div>\n' +
                '    <h6>\n' +
                '    </h6>\n' +
                '    </div>\n' +
                '  </div>\n' +
                '</li>');
            });
        });
    });
});

$('#fecha1').change( function(){
    fecha1 = $(this).val(); 
    let fecha2 = $('#fecha2').val();

    if(fecha2 == ''){
    }else{
        totalComisones(fecha1,fecha2);  
    }
});

$('#fecha2').change( function(){  
    fecha2 = $(this).val();  
    let fecha1 = $('#fecha1').val();    
});


$('#selectEstatus').change( function(){  
    estatus = $(this).val();  
    let fecha1 = $('#fecha1').val();
    let fecha2 = $('#fecha2').val();

    if(fecha1 == '' || fecha2 == '' || estatus == ''){
        alerts.showNotification("top", "right", "Debe seleccionar las dos fechas y el estatus", "warning");
    }else{
        totalComisones(fecha1,fecha2,estatus);  
    }
});

totalComisones(0,0,0);  
let titulos = [];
$('#tabla_total_comisionistas thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html('<input type="text" class="textoshead" id="t-'+i+'" placeholder="'+title+'"/>' );
    $( 'input', this ).on('keyup change', function () {
        if (tabla_total_comisionistas.column(i).search() !== this.value ) {
            tabla_total_comisionistas.column(i).search(this.value).draw();
            
            var total = 0;
            var index = tabla_total_comisionistas.rows({ selected: true, search: 'applied' }).indexes();
            var data = tabla_total_comisionistas.rows( index ).data();

            $.each(data, function(i, v){
                total += parseFloat(v.total_dispersado);
            });
            var to1 = formatMoney(total);
            document.getElementById("myText_nuevas_tc").value = to1;
        }
    });
});

function totalComisones(fecha1,fecha2,estatus){
    $("#tabla_total_comisionistas").ready( function(){
        let c=0;
        $('#tabla_total_comisionistas').on('xhr.dt', function ( e, settings, json, xhr ) {
            var total = 0;
            $.each(json.data, function(i, v){
                total += parseFloat(v.total_dispersado);
            });
            var to = formatMoney(total);
            document.getElementById("myText_nuevas_tc").value = to;
        });

        tabla_total_comisionistas = $("#tabla_total_comisionistas").DataTable({
            dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
            bAutoWidth: true,
            scrollX: true,
            width: '100%',
            buttons: [{
                extend: 'excelHtml5',
                ext: 'Excel',
                className: 'btn btn-success',
                titleAttr: 'Excel',
                title: 'MKTD_CONTRALORÍA_SISTEMA_COMISIONES',
                exportOptions: {
                columns: [0,1,2,3,4,5],
                format: {
                        header: function (columnIdx) {
                            return ' '+titulos_intxt[columnIdx] +' ';
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
                "data": function( d ){
                    return '<p style="font-size: .8em"><br>'+d.id_usuario+'</p>';
                }
            },
            {
                "data": function( d ){
                    return '<p style="font-size: .8em"><br>'+d.rol+'</p>';
                }
            },
            {
                "data": function( d ){
                    return '<p style="font-size: .8em"><b>'+d.nombre_comisionista+'</p>';
                }
            },
            {
                "data": function( d ){
                    return '<p style="font-size: .8em">'+formatMoney(d.total_dispersado)+'</p>';
                }
            },
            {
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.fecha+'<b></b></p>';
                }
            },
            {
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.nombre+'<b></b></p>';
                }
            }],
            ajax: {
                "url": general_base_url + "Pagos/getCommissionsByMktdUser/"+fecha1+"/"+fecha2+"/"+estatus,
                "type": "POST",
                    cache: false,
                    "data": function( d ){}
            },
        });
    });
}

$('#fechaR1').change( function(){
    fecha1 = $(this).val(); 
    let fecha2 = $('#fechaR2').val();
});

$('#fechaR2').change( function(){
    fecha2 = $(this).val();  
    let fecha1 = $('#fechaR1').val();   
});

$('#selectEstatusR').change( function(){
    estatus = $(this).val();  
    let fecha1 = $('#fechaR1').val();
    let fecha2 = $('#fechaR2').val();
    if(fecha1 == '' || fecha2 == '' || estatus == ''){
        alerts.showNotification("top", "right", "Debe seleccionar las dos fechas y el estatus", "warning");
    }
    else{
        totalComisonesR(fecha1,fecha2,estatus);  
    }
});  

$(document).on( "click", ".subir_factura", function(){
    resear_formulario();
    id_comision = $(this).val();
    link_post = general_base_url+"Comisiones/guardar_solicitud/"+id_comision;
    $("#modal_formulario_solicitud").modal( {backdrop: 'static', keyboard: false} );
});

function resear_formulario(){
    $("#modal_formulario_solicitud input.form-control").prop("readonly", false).val("");
    $("#modal_formulario_solicitud textarea").html('');
    $("#modal_formulario_solicitud #obse").val('');

    var validator = $( "#frmnewsol" ).validate();
    validator.resetForm();
    $( "#frmnewsol div" ).removeClass("has-error");
}

$("#cargar_xml").click( function(){
    subir_xml( $("#xmlfile") );
});

var justificacion_globla = "";

function subir_xml( input ){
    var data = new FormData();
    documento_xml = input[0].files[0];
    var xml = documento_xml;
    data.append("xmlfile", documento_xml);
    resear_formulario();

    $.ajax({
        url: general_base_url + "Pagos/cargaxml2",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        method: 'POST',
        type: 'POST',
        success: function(data){
            if( data.respuesta[0] ){
                documento_xml = xml;
                var informacion_factura = data.datos_xml;
                
                cargar_info_xml( informacion_factura );
                $("#solobs").val( justificacion_globla );
            }
            else{
                input.val('');
                alert( data.respuesta[1] );
            }
        },
        error: function( data ){
            input.val('');
            alert("ERROR INTENTE COMUNICARSE CON EL PROVEEDOR");
        }
    });
}

function cargar_info_xml( informacion_factura ){
    $("#emisor").val( ( informacion_factura.nameEmisor ? informacion_factura.nameEmisor[0] : '') ).attr('readonly',true);
    $("#rfcemisor").val( ( informacion_factura.rfcemisor ? informacion_factura.rfcemisor[0] : '') ).attr('readonly',true);
    $("#receptor").val( ( informacion_factura.namereceptor ? informacion_factura.namereceptor[0] : '') ).attr('readonly',true);
    $("#rfcreceptor").val( ( informacion_factura.rfcreceptor ? informacion_factura.rfcreceptor[0] : '') ).attr('readonly',true);
    $("#regimenFiscal").val( ( informacion_factura.regimenFiscal ? informacion_factura.regimenFiscal[0] : '') ).attr('readonly',true);
    $("#formaPago").val( ( informacion_factura.formaPago ? informacion_factura.formaPago[0] : '') ).attr('readonly',true);
    $("#total").val( ('$ '+informacion_factura.total ? '$ '+informacion_factura.total[0] : '') ).attr('readonly',true);
    $("#cfdi").val( ( informacion_factura.usocfdi ? informacion_factura.usocfdi[0] : '') ).attr('readonly',true);
    $("#metodopago").val( ( informacion_factura.metodoPago ? informacion_factura.metodoPago[0] : '') ).attr('readonly',true);
    $("#unidad").val( ( informacion_factura.claveUnidad ? informacion_factura.claveUnidad[0] : '') ).attr('readonly',true);
    $("#clave").val( ( informacion_factura.claveProdServ ? informacion_factura.claveProdServ[0] : '') ).attr('readonly',true);
    $("#obse").val( ( informacion_factura.descripcion ? informacion_factura.descripcion[0] : '') ).attr('readonly',true);
}

$("#form_colaboradores").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        $('#loader').removeClass('hidden');
        var data = new FormData( $(form)[0] );
        let sumat=0;
        let valor = parseFloat($('#pago_mktd').val()).toFixed(3);
        let valor1 = parseFloat(valor-0.10);
        let valor2 = parseFloat(valor)+0.010;

        for(let i=0;i<$('#cuantos').val();i++){
            sumat += parseFloat($('#abono_marketing_'+i).val());
        }

        let sumat2 =  parseFloat((sumat).toFixed(3));
        document.getElementById('Sumto').innerHTML= ''+ parseFloat(sumat2.toFixed(3)) +'';

        if(parseFloat(sumat2.toFixed(3)) < valor1){
            alerts.showNotification("top", "right", "Falta dispersar", "warning");
        }
        else if(parseFloat(sumat2.toFixed(3)) >= valor1 && parseFloat(sumat2.toFixed(3)) <= valor2 ){
            $.ajax({
                url: general_base_url + "Pagos/nueva_mktd_comision",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST',
                success: function(data){
                    if(true){
                        $('#loader').addClass('hidden');
                        $("#modal_colaboradores").modal('toggle');
                        plaza_2.ajax.reload();
                        plaza_1.ajax.reload();
                        alert("¡Se agregó con éxito!");
                    }
                    else{
                        alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                        $('#loader').addClass('hidden');
                    }
                },error: function( ){
                    alert("ERROR EN EL SISTEMA");
                }
            });
        }
        else if(parseFloat(sumat2.toFixed(3)) > valor1 && parseFloat(sumat2.toFixed(3)) > valor2 ){
            alerts.showNotification("top", "right", "Cantidad excedida", "danger");
        }
    }
});

$("#frmnewsol").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        data.append("xmlfile", documento_xml);
        $.ajax({
            url:   link_post,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST',
            success: function(data){
                if( data.resultado ){
                    alert("LA FACTURA SE SUBIO CORRECTAMENTE");
                    $("#modal_formulario_solicitud").modal( 'toggle' );
                    tabla_nuevas.ajax.reload();
                }
                else{
                    alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                }
            },error: function(){
                alert("ERROR EN EL SISTEMA");
            }
        });
    }
});          

$("#form_MKTD").submit( function(e) {
    e.preventDefault();        
}).validate({
    rules: {
        'porcentajeUserMk[]':{
            required: true,
        }
    },
    messages: {
        'porcentajeUserMk[]':{
            required : "Dato requerido"
        }
    },
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        $.ajax({
            url: general_base_url + "Pagos/save_new_mktd",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST',
            success: function(data){
                if( data.resultado ){
                    alert("LA FACTURA SE SUBIO CORRECTAMENTE");
                    $("#modal_mktd").modal( 'toggle' );
                }else{
                    alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                }
            },error: function(){
                alert("ERROR EN EL SISTEMA");
            }
        });   
    }
});

function calcularMontoParcialidad() {
    $precioFinal = parseFloat($('#value_pago_cliente').val());
    $precioNuevo = parseFloat($('#new_value_parcial').val());
    if ($precioNuevo >= $precioFinal) {
        $('#label_estado').append('<label>MONTO NO VALIDO</label>');
    }
    else if ($precioNuevo < $precioFinal) {
        $('#label_estado').append('<label>MONTO VALIDO</label>');
    }            
}

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

$(window).resize(function(){
    plaza_1.columns.adjust();
    plaza_2.columns.adjust();
});

$(document).ready( function(){
    $.getJSON( general_base_url + "Comisiones/report_plazas").done( function( data ){
        $(".report_plazas").html();
        $(".report_plazas1").html();
        $(".report_plazas2").html();
        
        if(data[0].id_plaza == '0' || data[1].id_plaza == 0){
            if(data[0].plaza00==null || data[0].plaza00=='null' ||data[0].plaza00==''){
                $(".report_plazas").append('<label style="color: #6a2c70;">&nbsp;<b>Porcentaje:</b> '+data[0].plaza01+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> 0%</label>');
            }
            else{
                $(".report_plazas").append('<label style="color: #6a2c70;">&nbsp;<b>Porcentaje:</b> '+data[0].plaza01+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> '+data[0].plaza00+'%</label>');
            }
        
        }
        if(data[1].id_plaza == '1' || data[1].id_plaza == 1){
            if(data[1].plaza10==null || data[1].plaza10=='null' ||data[1].plaza10==''){
                $(".report_plazas1").append('<label style="color: #b83b5e;">&nbsp;<b>Porcentaje:</b> '+data[1].plaza11+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> 0%</label>');
            }
            else{
                $(".report_plazas1").append('<label style="color: #b83b5e;">&nbsp;<b>Porcentaje:</b> '+data[1].plaza11+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> '+data[1].plaza10+'%</label>');
            }
        
        }

        if(data[2].id_plaza == '2' || data[2].id_plaza == 2){
            if(data[2].plaza20==null || data[2].plaza20=='null' ||data[2].plaza20==''){
                $(".report_plazas2").append('<label style="color: #f08a5d;">&nbsp;<b>Porcentaje:</b> '+data[2].plaza21+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> 0%</label>');
            }
            else{
                $(".report_plazas2").append('<label style="color: #f08a5d;">&nbsp;<b>Porcentaje:</b> '+data[2].plaza21+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> '+data[2].plaza20+'%</label>');
            }
        }
    });
});  