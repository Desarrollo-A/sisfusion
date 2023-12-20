function cleanCommentsAsimilados() {
    var myCommentsList = document.getElementById('comments-list-asimilados');
    var myCommentsLote = document.getElementById('nameLote');
    myCommentsList.innerHTML = '';
    myCommentsLote.innerHTML = '';
}

var totalLeon = 0;
var totalQro = 0;
var totalSlp = 0;
var totalMerida = 0;
var totalCdmx = 0;
var totalCancun = 0;
var tr;
var tabla_asimilados2 ;
var totaPen = 0;
let titulos = [];
$(document).ready(function () {

    tabla_general();

})


$('#comisiones_solicitadas thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function() {
        if (tabla_asimilados2.column(i).search() !== this.value) {
            tabla_asimilados2.column(i).search(this.value).draw();
            var total = 0;
            var index = tabla_asimilados2.rows({
                selected: true,
                search: 'applied'
            }).indexes();
            var data = tabla_asimilados2.rows(index).data();
            $.each(data, function(i, v) {
                total += parseFloat(v.impuesto);
            });
            var to1 = formatMoney(total);
            document.getElementById("totalDisponible").textContent = formatMoney(total);
        }
    });
});

$('#comisiones_solicitadas').on('xhr.dt', function(e, settings, json, xhr) {
    var total = 0;
    $.each(json.data, function(i, v) {
        total += parseFloat(v.impuesto);
    });
    var to = formatMoney(total);
    document.getElementById("totalDisponible").textContent = to;
});

    function tabla_general(){
        $("#comisiones_solicitadas").prop('hidden', false);

        $('#comisiones_solicitadas').on('xhr.dt', function (e, settings, json) {
            let total = 0;
    
            $.each(json.data, function(i, v) {
                total += parseFloat(v.abono_neodata);
            });
    
         
        });
    tabla_asimilados2 = $("#comisiones_solicitadas").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'REPORTE GENERAL PAGOS INTERNOMEX',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17],
                format: 
                {
                    header:  function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
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
            data: function( d ){
                return d.id_pago_i;
            }
        },
        {
            data: function( d ){
                return d.proyecto;
            }
        },{
            data: function( d ){
                return  d.condominio;
            }
        },
        {
            data: function( d ){
                return d.lote;
            }
        },
        {
            data: function( d ){
                return d.referencia;
            }
        },
        {
            data: function( d ){
                return formatMoney(d.precio_lote);
            }
        },
        {
            data: function( d ){
                return d.empresa;
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+formatMoney(d.valimpuesto)+'%</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.dcto)+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.impuesto)+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.usuario+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.puesto+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+d.nombre+'</b></i></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+d.rfc+'</b></i></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><i> '+d.forma_pago+'</i></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><i> '+d.fecha_pago_intmex+'</i></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><i> '+d.estatus_usuario+'</i></p>';
            }
        },
        {
            "orderable": false,
            "data": function( data ){
                var BtnStats = '';
                BTN_DETASI11 = '<div class="d-flex justify-center"><button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas btn-historial-lo" title="Detalles">' +'<i class="fas fa-info"></i></button></div>';
                const BTN_DETASI = `<button href="#" value="${data.id_pago_i}" data-value='"${data.lote}"' data-code="${data.cbbtton}" class="btn-data btn-blueMaderas consultar_logs_asimilados" title="Detalles"><i class="fas fa-info"></i></button>`;
                BtnStats += BTN_DETASI;
                return BtnStats;
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets:   0,
            searchable: false,
            className: 'dt-body-center',
            render: function (d, type, full, meta){
                if(full.estatus == 8){
                    if(full.id_comision){
                    return '<input type="checkbox" name="idTQ[]" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
                    }
                    else{
                        return '<p>N/A</p>';
                    }
                }
                else{
                    return '<p>N/A</p>';
                }
            },
            select: {
                style:    'os',
                selector: 'td:first-child'
            },
        }],
        ajax: {
            "url": general_base_url + "pagos/getDatosGralInternomex/",
            "type": "POST",
            cache: false,
            "data": function( d ){
                    }
        }
    });
    
    $("#comisiones_solicitadas tbody").on("click", ".consultar_logs_asimilados", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        lote = $(this).attr("data-value");
        changeSizeModal("modal-md");
        appendBodyModal(`<div class="modal-body">
            <div role="tabpanel">
                <ul class="nav" role="tablist">
                    <div id="nameLote"></div>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="changelogTab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-plain">
                                    <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                        <ul class="timeline-3" id="comments-list-asimilados"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsAsimilados()"><b>Cerrar</b></button>
        </div>`);
        showModal();
        $("#nameLote").append('<p><h5>HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
        $.getJSON("getComments/"+id_pago).done( function( data ){
            if(data == ''){
                $("#comments-list-asimilados").append('<p>Sin datos a mostrar   </p>');
            }

            $.each( data, function(i, v){
                $("#comments-list-asimilados").append('<li><div class="container-fluid"><div class="row"><div class="col-md-6"><a><small>Campo: </small><b>' + v.comentario + '</b></a><br></div><div class="float-end text-right"><a>' + v.fecha_movimiento + '</a></div><div class="col-md-12"><p class="m-0"><small>USUARIO: </small><b> ' + v.nombre_usuario + '</b></p></div><h6></h6></div></div></li>');
            });
        });
    });
    }




$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable()
    .columns.adjust();
});

function cancela(){
    $("#modal_nuevas").modal('toggle');
}

$("#form_interes").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        data.append("id_pago_i", id_pago_i);
        $.ajax({
            url: general_base_url + "Comisiones/despausar_solicitud",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function(data){
                if( data[0] ){
                    $("#modal_nuevas").modal('toggle' );
                    alerts.showNotification("top", "right", "Se aplicó el cambio exitosamente", "success");
                    setTimeout(function() {
                        tabla_asimilados2.ajax.reload();
                    }, 3000);
                }
                else{
                    alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");
                }
            },error: function( ){
                alert("ERROR EN EL SISTEMA");
            }
        });
    }
});

function CloseModalDelete2(){
    document.getElementById("form_multiples").reset();
    a = document.getElementById('borrarProyect');
    padre = a.parentNode;
    padre.removeChild(a);
    $("#modal_multiples").modal('toggle');  
}

$(document).on("click", ".Pagar", function() {          
    $("#modal_multiples .modal-body").html("");
    $("#modal_multiples .modal-header").html("");
    $("#modal_multiples .modal-header").append('<h4 class="card-title"><b>Marcar pagadas</b></h4>');
    $("#modal_multiples .modal-footer").append(`<div class="row" id="borrarProyect"><center><input type="submit" disabled id="btn-aceptar" class="btn btn-primary" value="ACEPTAR"><button type="button" class="btn btn-danger" data-dismiss="modal" onclick="CloseModalDelete2()">CANCELAR</button></center></div>`);
    $("#modal_multiples .modal-header").append(`<div class="row">
    <div class="col-md-12"><select id="desarrolloSelect" name="desarrolloSelect" class="form-control desarrolloSelect ng-invalid ng-invalid-required" required data-live-search="true"></select></div></div>`);
    $.post('getDesarrolloSelectINTMEX/'+3, function(data) {
        $("#desarrolloSelect").append($('<option disabled>').val("default").text("Seleccione una opción"))
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['name_user'];
            $("#desarrolloSelect").append($('<option>').val(id).attr('data-value', id).text(name));
        }
        if (len <= 0) {
            $("#desarrolloSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#desarrolloSelect").val(0);
        $("#desarrolloSelect").selectpicker('refresh');
    }, 'json');
        
    $('#desarrolloSelect').change(function() {
        $("#modal_multiples .modal-body .bodypagos").html("");
        if(document.getElementById('bodypago2')){
            let a =  document.getElementById('bodypago2');
            padre = a.parentNode;
            padre.removeChild(a);
        }
        var valorSeleccionado = $(this).val();
        var combo = document.getElementById("desarrolloSelect");
        var selected = combo.options[combo.selectedIndex].text;

        $.getJSON(general_base_url + "Comisiones/getPagosByProyect/"+valorSeleccionado+"/"+3).done(function(data) {
            let sumaComision = 0;
            if (!data) {
                $("#modal_multiples .modal-body").append('<div class="row"><div class="col-md-12">SIN DATOS A MOSTRAR</div></div>');
            } 
            else {
                if(data.length > 0){
                    $("#modal_multiples .modal-body ").append(`<div class="row bodypagos" >
                    <p style='color:#9D9D9D;'>¿Estas seguro que deseas autorizar $<b style="color:green">${formatMoney(data[0][0].suma)}</b> de ${selected}?</div>`);
                } 
                $("#modal_multiples .modal-body ").append(`<div  id="bodypago2"></div>`);
                $.each(data[1], function(i, v) {
                    $("#modal_multiples .modal-body #bodypago2").append(`
                    <input type="hidden" name="ids[]" id="ids" value="${v.id_pago_i}"></div>`);
                    
                });
                document.getElementById('btn-aceptar').disabled = false;
            }
        });
    });
    $("#modal_multiples").modal({
        backdrop: 'static',
        keyboard: false
    });
});

$("#form_refresh").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        console.log(data);
        data.append("id_pago_i", id_pago_i);
        $.ajax({
            url: general_base_url + "Comisiones/refresh_solicitud/",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function(data){
                if( data[0] ){
                    $("#modal_refresh").modal('toggle' );
                    alerts.showNotification("top", "right", "Se ha procesado la solicitud exitosamente", "success");
                    setTimeout(function() {
                        tabla_asimilados2.ajax.reload();
                    }, 3000);
                }else{
                    alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");
                }
            },error: function( ){
                alert("ERROR EN EL SISTEMA");
            }
        });
    }
});

$(document).on("click", ".btn-historial-lo", function(){
    window.open(general_base_url + "Comisiones/getHistorialEmpresa", "_blank");
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


function selectAll(e) {
    tota2 = 0;
    $(tabla_asimilados2.$('input[type="checkbox"]')).each(function (i, v) {
        if (!$(this).prop("checked")) {
            $(this).prop("checked", true);
            tota2 += parseFloat(tabla_asimilados2.row($(this).closest('tr')).data().impuesto);
        } else {
            $(this).prop("checked", false);
        }
        $("#totpagarPen").html(formatMoney(tota2));
    });
}

$(document).ready( function(){
    $.getJSON( general_base_url + "Comisiones/getReporteEmpresa").done( function( data ){
        $(".report_empresa").html();
        $.each( data, function( i, v){
            $(".report_empresa").append('<div class="col xol-xs-3 col-sm-3 col-md-3 col-lg-3"><label style="color: #00B397;">&nbsp;'+v.empresa+': $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #00B397; font-weight: bold;" value="'+formatMoney(v.porc_empresa)+'" disabled="disabled" readonly="readonly" type="text"  name="myText_FRO" id="myText_FRO"></label></div>');
        });
    });
});

$("#form_multiples").submit( function(e) {
    $('#spiner-loader').removeClass('hidden');
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        console.log(data);
        $.ajax({
            url: general_base_url + "Comisiones/IntMexPagadosByProyect",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function(data){
                if( data == 1){
                    CloseModalDelete2();
                    alerts.showNotification("top", "right", "Se aplicó el cambio exitosamente", "success");
                }else{
                    CloseModalDelete2();
                    alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");
                }
                $('#spiner-loader').addClass('hidden');
            },error: function( ){
                CloseModalDelete2();
                alert("ERROR EN EL SISTEMA");
                $('#spiner-loader').addClass('hidden');
            }
        });
    }
});