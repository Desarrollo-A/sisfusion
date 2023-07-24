$(document).ready(function() {
    $("#tabla_extranjero").prop("hidden", true);
    $.post(general_base_url + "index.php/Contratacion/lista_proyecto", function (data) {
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
        url: general_base_url + 'Asesor/getCondominioDesc/'+residencial,
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
    getAssimilatedCommissions(proyecto, condominio);
});

$('#filtro44').change(function(ruta){
    proyecto = $('#filtro33').val();
    condominio = $('#filtro44').val();
    if(condominio == '' || condominio == null || condominio == undefined){
        condominio = 0;
    }
    getAssimilatedCommissions(proyecto, condominio);
});

var totalLeon = 0;
var totalQro = 0;
var totalSlp = 0;
var totalMerida = 0;
var totalCdmx = 0;
var totalCancun = 0;
var tr;
var tabla_remanente2 ;
var totaPen = 0;
let titulos = [];
$('#tabla_extranjero thead tr:eq(0) th').each( function (i) {
    if(i != 0){
        var title = $(this).text();
        titulos.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function() {
            if (tabla_extranjero2.column(i).search() !== this.value) {
                tabla_extranjero2.column(i).search(this.value).draw();
                var total = 0;
                var index = tabla_extranjero2.rows({
                selected: true,
                search: 'applied'
            }).indexes();
                var data = tabla_extranjero2.rows(index).data();
                $.each(data, function(i, v) {
                    total += parseFloat(v.impuesto);
                });
                var to1 = formatMoney(total);
                document.getElementById("totpagarextranjero").textcontent = formatMoney(total);
            }
        });
    }
    else {
        $(this).html('<input id="all" type="checkbox" style="width:20px; height:20px;" onchange="selectAll(this)"/>');
    }
});

function getAssimilatedCommissions(proyecto, condominio){
    $('#tabla_extranjero').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.impuesto);
        });
        var to = formatMoney(total);
        document.getElementById("totpagarextranjero").textContent = to;
    });

    $("#tabla_extranjero").prop("hidden", false);
    tabla_extranjero2 = $("#tabla_extranjero").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            text: '<i class="fa fa-check"></i> ENVIAR A INTERNOMEX',
            action: function() {
                if ($('input[name="idTQ[]"]:checked').length > 0) {
                    $('#spiner-loader').removeClass('hide');
                    var idcomision = $(tabla_extranjero2.$('input[name="idTQ[]"]:checked')).map(function() {
                        return this.value;
                    }).get();
                    var com2 = new FormData();
                    com2.append("idcomision", idcomision); 
                    $.ajax({
                        url : general_base_url + 'Comisiones/acepto_internomex_remanente/',
                        data: com2,
                        cache: false,
                        contentType: false,
                        processData: false,
                        type: 'POST', 
                        success: function(data){
                            response = JSON.parse(data);
                            if(data == 1) {
                                $('#spiner-loader').addClass('hide');
                                $("#totpagarPen").html(formatMoney(0));
                                $("#all").prop('checked', false);
                                var fecha = new Date();
                                $("#myModalEnviadas").modal('toggle');
                                tabla_extranjero2.ajax.reload();
                                $("#myModalEnviadas .modal-body").html("");
                                $("#myModalEnviadas").modal();
                                $("#myModalEnviadas .modal-body").append(`<center><img style='width: 75%; height: 75%;' src='${general_base_url}dist/img/send_intmex.gif'><p style='color:#676767;'>Comisiones de esquema <b>Factura extranjero</b>, fueron enviadas a <b>INTERNOMEX</b> correctamente.</p></center>`);
                            }
                            else {
                                $('#spiner-loader').addClass('hide');
                                $("#myModalEnviadas").modal('toggle');
                                $("#myModalEnviadas .modal-body").html("");
                                $("#myModalEnviadas").modal();
                                $("#myModalEnviadas .modal-body").append("<center><P>ERROR AL ENVIAR COMISIONES </P><BR><i style='font-size:12px;'>NO SE HA PODIDO EJECUTAR ESTA ACCIÓN, INTÉNTALO MÁS TARDE.</i></P></center>");
                            }
                        },
                        error: function( data ){
                            $('#spiner-loader').addClass('hide');
                            $("#myModalEnviadas").modal('toggle');
                            $("#myModalEnviadas .modal-body").html("");
                            $("#myModalEnviadas").modal();
                            $("#myModalEnviadas .modal-body").append("<center><P>ERROR AL ENVIAR COMISIONES </P><BR><i style='font-size:12px;'>NO SE HA PODIDO EJECUTAR ESTA ACCIÓN, INTÉNTALO MÁS TARDE.</i></P></center>");
                        }
                    });
                }
            },
            attr: {
                class: 'btn btn-azure',
                style: 'position: relative; float: right;',
            }
        },
        {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'EXTRANJERO_CONTRALORÍA_SISTEMA_COMISIONES',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15],
                format: 
                {
                    header:  function (d, columnIdx) {
                        return ' ' + titulos[columnIdx-1]  + ' ';
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
        columns: [{
            "width": "3%"},
        {
            
            "data": function( d ){
                return '<p class="m-0">'+d.id_pago_i+'</p>';
            }
        },
        {
            
            "data": function( d ){
                return '<p class="m-0">'+d.proyecto+'</p>';
            }
        },
        {
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
                return '<p class="m-0"><b>'+formatMoney(d.impuesto)+'</b></p>';
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
                BtnStats = '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_extranjero" title="Detalles">' +'<i class="fas fa-info"></i></button>'+
                '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.id_pago_i+'" data-code="'+data.cbbtton+'" ' + 'class="btn-data btn-warning cambiar_estatus" title="Pausar solicitud">' + '<i class="fas fa-ban"></i></button>';
                return '<div class="d-flex justify-center">'+BtnStats+'</div>';
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets:   0,
            searchable:false,
            className: 'dt-body-center',
            render: function (d, type, full, meta){
                if(full.estatus == 4){
                    if(full.id_comision){
                        return '<input type="checkbox" name="idTQ[]" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
                    }
                    else{
                        return '';
                    }
                }
                else{
                    return '';
                }
            },
            select: {
                style:    'os',
                selector: 'td:first-child'
            },
        }],
        ajax: {
            "url": general_base_url + "Comisiones/getDatosNuevasEContraloria/" + proyecto + "/" + condominio,
            "type": "POST",
            cache: false,
            "data": function( d ){
            }
        },
    });

    $('#tabla_extranjero').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $("#tabla_extranjero tbody").on("click", ".consultar_logs_extranjero", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        lote = $(this).attr("data-value");
        $("#seeInformationModalExtranjero").modal();
        $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
        $.getJSON("getComments/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comments-list-extranjero").append('<div class="col-lg-12"><p><i style="color:gray;">'+v.comentario+'</i><br><b style="color:#3982C0">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.nombre_usuario+'</b></p></div>');
            });
        });
    });

    $('#tabla_extranjero').on('click', 'input', function() {
        tr = $(this).closest('tr');
        var row = tabla_extranjero2.row(tr).data();
        if (row.pa == 0) {
            row.pa = row.impuesto;
            totaPen += parseFloat(row.pa);
            tr.children().eq(1).children('input[type="checkbox"]').prop("checked", true);
        }
        else {
            totaPen -= parseFloat(row.pa);
            row.pa = 0;
        }
        $("#totpagarPen").html(formatMoney(totaPen));
    });

    $("#tabla_extranjero tbody").on("click", ".cambiar_estatus", function(){
        var tr = $(this).closest('tr');
        var row = tabla_extranjero2.row( tr );
        id_pago_i = $(this).val();
        $("#modal_nuevas .modal-body").html("");
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Está seguro de pausar la comisión de <b>'+row.data().lote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().usuario+'</i>?</p></div></div>');
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="hidden" name="value_pago" value="1"><input type="hidden" name="estatus" value="6"><input type="text" class="form-control observaciones" name="observaciones" required placeholder="Describe mótivo por el cual se va activar nuevamente la solicitud"></input></div></div>');
        $("#modal_nuevas .modal-body").append('<input type="hidden" name="id_pago" value="'+row.data().id_pago_i+'">');
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-md-6"></div><div class="col-md-3"><input type="submit" class="btn btn-primary" value="PAUSAR"></div><div class="col-md-3"><button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button></div></div>');
        $("#modal_nuevas").modal();
    });
}

let titulosFac = [];
$('#tabla_factura thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulosFac.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $( 'input', this ).on('keyup change', function () {
        if ($('#mktdProspectsTable').DataTable().column(i).search() !== this.value ) {
            $('#mktdProspectsTable').DataTable().column(i).search(this.value).draw();
        }
    });
});

$('#tabla_factura').ready(function () {
    $('#tabla_factura').on('xhr.dt', function (e, settings, json, xhr) {
        let total = 0;
        $.each(json.data, function (i, v) {
            total += parseFloat(v.total);
        });
        document.getElementById('myText_proceso').textContent = `${formatMoney(total)}`;
    });

    $('#tabla_factura').DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'REPORTE COMPROBANTES FISCALES EXTRANJEROS',
                exportOptions: {
                    columns: [0,1,2,3,4,5,6],
                    format: {
                        header: function (d, columnIndex) {
                            return ' '+titulosFac[columnIndex] +' ';
                        }
                    }
                }
            }
        ],
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
                "data": function(d) {
                    return `<p class="m-0"><b>${d.id_usuario}</b></p>`;
                }
            },
            {
                "data": function(d) {
                    return `<p class="m-0">${d.usuario}</p>`;
                }
            },
            {
                "data": function (d) {
                    return `<p class="m-0">${d.rfc}</p>`;
                }
            },
            {
                "data": function (d) {
                    return `<p class="m-0">${formatMoney(d.total)}</p>`;
                }
            },
            {
                "data": function (d) {
                    return `<p class="m-0">${d.forma_pago}</p>`;
                }
            },
            {
                "data": function (d) {
                    return `<p class="m-0">${d.nacionalidad}</p>`;
                }
            },
            {
                "data": function (d) {
                    return `<p class="m-0">${d.estatus_usuario}</p>`;
                }
            },
            {
                "data": function (d) {
                    return `
                        <div class="d-flex justify-center">
                            <button data-usuario="${d.archivo_name}" class="btn-data btn-blueMaderas consultar-archivo" title="Detalles"><i class="fas fa-file-pdf-o"></i></button>
                        </div>`;
                }
            }
        ],
        ajax: {
            "url": "getComprobantesExtranjero",
            "type": "GET",
            "data": function(d) {}
        },
    });

    $('#tabla_factura tbody').on('click', '.consultar-archivo', function () {
        const $itself = $(this);
        Shadowbox.open({
            content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="${general_base_url}static/documentos/extranjero/'+$itself.attr('data-usuario')+'"></iframe></div>`,
            player: "html",
            title: "Visualizando documento fiscal: " + $itself.attr('data-usuario'),
            width: 985,
            height: 660
        });
    });
});

function resear_formulario(){
    $("#modal_formulario_solicitud input.form-control").prop("readonly", false).val("");
    $("#modal_formulario_solicitud textarea").html('');
    $("#modal_formulario_solicitud #obse").val('');
    var validator = $( "#frmnewsol" ).validate();
    validator.resetForm();
    $( "#frmnewsol div" ).removeClass("has-error");
}

var justificacion_globla = "";
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
        else{
            if(parseFloat(sumat2.toFixed(3)) >= valor1 && parseFloat(sumat2.toFixed(3)) <= valor2 ){
                $.ajax({
                    url: general_base_url + "Comisiones/nueva_mktd_comision",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    method: 'POST',
                    type: 'POST', // For jQuery < 1.9
                    success: function(data){
                        if(true){
                            $('#loader').addClass('hidden');
                            $("#modal_colaboradores").modal('toggle');
                            plaza_2.ajax.reload();
                            plaza_1.ajax.reload();
                            alert("¡Se agregó con éxito!");
                        }else{
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
    }
});

$("#frmnewsol").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        data.append("xmlfile", documento_xml);
        $.ajax({
            url: general_base_url + link_post,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function(data){
                if( data.resultado ){
                    alert("LA FACTURA SE SUBIO CORRECTAMENTE");
                    $("#modal_formulario_solicitud").modal( 'toggle' );
                    tabla_nuevas.ajax.reload();
                }else{
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
            url: general_base_url + "Comisiones/save_new_mktd",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function(data){
                if( data.resultado ){
                    alert("LA FACTURA SE SUBIO CORRECTAMENTE");
                        $("#modal_mktd").modal( 'toggle' );
                    //  tabla_nuevas.ajax.reload();
                }else{
                    alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                }
            },error: function(){
                alert("ERROR EN EL SISTEMA");
            }
        });   
    }
}); 

function cleanComments() {
    var myCommentsList = document.getElementById('comments-list-asimilados');
    var myCommentsLote = document.getElementById('nameLote');
    myCommentsList.innerHTML = '';
    myCommentsLote.innerHTML = '';
}

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