$(document).ready(function() {
    $("#tabla_historialGral").prop("hidden", true);
    $("#spiner-loader").removeClass('hide');
    $.post(general_base_url + "Contratacion/lista_proyecto", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];
            $("#filtro33").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#filtro33").selectpicker('refresh');
    }, 'json');

    $.get(`${general_base_url}Comisiones/getPuestoByIdOpts`, function (data) {
        const puestos = JSON.parse(data);
        puestos.forEach(puesto => {
            const id = puesto.id_opcion;
            const name = puesto.nombre.toUpperCase();
            $('#roles').append($('<option>').val(id).text(name));
        });
        $("#roles").selectpicker('refresh');
        $("#spiner-loader").addClass('hide');
    });
});

$('#filtro33').change(function(ruta){
    $("#filtro44").empty().selectpicker('refresh');
    $("#spiner-loader").removeClass('hide');
    $.ajax({
        url: general_base_url + 'Comisiones/lista_estatus',
        type: 'post',
        dataType: 'json',
        success:function(response){
            const len = response.length;
            for(let i = 0; i<len; i++){
                const id = response[i]['idEstatus'];
                const name = response[i]['nombre'];
                $("#filtro44").append($('<option>').val(id).text(name));
            }
            $("#filtro44").selectpicker('refresh');
            $("#spiner-loader").addClass('hide');
        }
    });
});

$('#filtro44').change(function(ruta){
    $("#spiner-loader").removeClass('hide');
    const proyecto = $('#filtro33').val();
    let condominio = $('#filtro44').val();
    if(condominio === '' || condominio === null || condominio === undefined){
        condominio = 0;
    }
    let usuario = $('#users').val();
    if (usuario === undefined || usuario === null || usuario === '') {
        usuario = 0;
    }
    getAssimilatedCommissions(proyecto, condominio, usuario);
});

$('#roles').change(function () {
    $("#users").empty().selectpicker('refresh');
    $("#spiner-loader").removeClass('hide');
    $.ajax({
        url: `${general_base_url}Comisiones/getUsersName`,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            const len = data.length;
            for(let i = 0; i < len; i++){
                const id = data[i]['id_usuario'];
                const name = data[i]['name_user'].toUpperCase();
                $("#users").append($('<option>').val(id).text(name));
            }
            $("#users").selectpicker('refresh');
            const proyecto = $('#filtro33').val();
            let condominio = $('#filtro44').val();
            if (proyecto === undefined || proyecto === null || proyecto === '') {
                return;
            }
            if(condominio === '' || condominio === null || condominio === undefined){
                condominio = 0;
            }
            let usuario = $('#users').val();
            if (usuario === undefined || usuario === null || usuario === '') {
                usuario = 0;
            }
            getAssimilatedCommissions(proyecto, condominio, usuario);
        }
    });
});

$('#users').change(function () {
    const proyecto = $('#filtro33').val();
    let condominio = $('#filtro44').val();
    $("#spiner-loader").removeClass('hide');
    if(condominio === '' || condominio === null || condominio === undefined){
        condominio = 0;
    }

    let usuario = $('#users').val();
    if (usuario === undefined || usuario === null || usuario === '') {
        usuario = 0;
    }

    getAssimilatedCommissions(proyecto, condominio, usuario);
});

function cleanCommentsAsimilados() {
    var myCommentsList = document.getElementById('comments-list-asimilados');
    var myCommentsLote = document.getElementById('nameLote');
    myCommentsList.innerHTML = '';
    myCommentsLote.innerHTML = '';
} 

let titulos_intxt = [];
$('#tabla_historialGral thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos_intxt.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function() {
        if (tabla_historialGral2.column(i).search() !== this.value) {
            tabla_historialGral2.column(i).search(this.value).draw();
        }
    });
});


var totalLeon = 0;
var totalQro = 0;
var totalSlp = 0;
var totalMerida = 0;
var totalCdmx = 0;
var totalCancun = 0;
var tr;
var tabla_historialGral2 ;
var totaPen = 0;

const optNueva = `
    <div class="w-100">
        <input class="d-none" type="radio" name="estatus" id="estatus-nueva" value="1" required>
        <label class="w-100" for="estatus-nueva">Nueva</label>
    </div>`;
const optRevision = `
    <div class="w-100">
        <input class="d-none" type="radio" name="estatus" id="estatus-revision" value="4" required>
        <label class="w-100" for="estatus-revision"> Revisión contraloría</label>
    </div>`;
const optPausado = `
    <div class="w-100">
        <input class="d-none" type="radio" name="estatus" id="estatus-pausado" value="6" required>
        <label class="w-100" for="estatus-pausado"> Pausado</label>
    </div>`;
const optPagado = `
    <div class="w-100">
        <input class="d-none" type="radio" name="estatus" id="estatus-pagado" value="11" required>
        <label class="w-100" for="estatus-pagado"> Pagado</label>
    </div>`;

let seleccionados = [];
function getAssimilatedCommissions(proyecto, condominio, usuario){
    $("#tabla_historialGral").prop("hidden", false);
    tabla_historialGral2 = $("#tabla_historialGral").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width:'100%',
        scrollX: true,
        bAutoWidth: true,
        buttons: [{
            text: 'MOVIMIENTO',
            action: function() {
                seleccionados = [];
                if ($('input[name="idTQ[]"]:checked').length > 0) {
                    const estatus = $('#filtro44').val();
                    const idComisiones = $(tabla_historialGral2.$('input[name="idTQ[]"]:checked')).map(function () { return this.value; }).get();
                    seleccionados = idComisiones;
                    let options = '';
                    if (estatus === '1') {
                        options = optRevision + optPausado;
                    } else if (estatus === '2') {
                        options = optNueva + optPausado;
                    } else if (estatus === '4') {
                        options = optNueva;
                    } else if (estatus === '8') {
                        options = optPagado;
                    }
                    const titlePagos = (idComisiones.length > 1) ? `<b>${idComisiones.length}</b> pagos seleccionados` : `<b>${idComisiones.length}</b> pago seleccionado`;
                    $('#total-pagos').html('').html('('+titlePagos+')');
                    $('#div-options').html('').html(options);
                    $('#movimiento-modal').modal();
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
            title: 'HISTORIAL_ESTATUS_COMISIONES',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15],
                format: {
                    header:  function (d, columnIdx) {
                        return ' ' + titulos_intxt[columnIdx] + ' ';
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
        columns: [{},
        {
            "data": function( d ){
                var lblStats;
                lblStats ='<p class="m-0"><b>'+d.id_pago_i+'</b></p>';
                return lblStats;
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
                return '<p class="m-0">'+d.nombreLote+'</p>';
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
                return '<p class="m-0">'+formatMoney(d.comision_total)+' </p>';
            }
        },
        {
            "data": function( d ){
                return '<p class=""m-0>'+formatMoney(d.pago_neodata)+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class=""m-0><b>'+formatMoney(d.pago_cliente)+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class=""m-0>'+formatMoney(d.pagado)+'</p>';
            }
        },
        {
            "data": function( d ){
                if(d.restante==null||d.restante==''){
                    return '<p class=""m-0>'+formatMoney(d.comision_total)+'</p>';
                }else{
                    return '<p class=""m-0>'+formatMoney(d.restante)+'</p>';
                }
            }
        }, 
        {
            "data": function( d ){
                if(d.activo == 0 || d.activo == '0'){
                    return '<p class=""m-0><b>'+d.user_names+'</b></p><p class=""m-0><span class="label lbl-warning">BAJA</span></p>';
                }
                else{
                    return '<p class=""m-0><b>'+d.user_names+'</b></p>';
                }
            }
        },
        {
            "data": function( d ){
                return '<p class=""m-0>'+d.puesto+'</p>';
            }
        },
        {
            "data": function( d ){
                var lblPenalizacion = '';
                if (d.penalizacion == 1){
                    lblPenalizacion ='<p class="m-0" title="Penalización + 90 días"><span class="label lbl-orange">Penalización + 90 días</span></p>';
                }
                if(d.bonificacion >= 1){
                    p1 = '<p class="m-0" title="Lote con bonificación en NEODATA"><span class="label lbl-pink">Bon. $'+formatMoney(d.bonificacion)+'</span></p>';
                }
                else{
                    p1 = '';
                }
                if(d.lugar_prospeccion == 0){
                    p2 = '<p class="m-0" title="Lote con cancelación de CONTRATO"><span class="label lbl-warning">Recisión</span></p>';
                }
                else{
                    p2 = '';
                }
                
                return p1 + p2 + lblPenalizacion;
            }
        },
        {
            "data": function( d ){
                var etiqueta;
                if(d.pago_neodata < 1){
                    etiqueta = '<p class="m-0"><span class="label lbl-azure">'+d.estatus_actual+'</span></p><p class="m-0"><span class="label lbl-green">IMPORTACIÓN</span></p>';
                }else{
                    etiqueta = '<p class="m-0"><span class="label lbl-azure">'+d.estatus_actual+'</span></p>';
                }
                return etiqueta;
            }
        },
        { 
            "orderable": false,
            "data": function( data ){
                var BtnStats;
                BtnStats = '<div class="d-flex justify-center"><button href="#" value="'+data.id_pago_i+'" data-value="'+data.nombreLote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_asimilados" data-toggle="tooltip" data-placement="top" title="HISTORIAL DE PAGO">' +'<i class="fas fa-info"></i></button></div>';
                return BtnStats;
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets:   0,
            'searchable':true,
            'className': 'dt-body-center',
            'render': function (d, type, full) {
                const estatus = $('#filtro44').val();
                if (( full.recision == '1' || estatus === '3' || estatus === '5' || estatus === '6' || estatus === '7') && id_rol_general != 17 ) {
                    return '';
                } else if ( full.recision != '1' && estatus === '7' && (full.estatus === '1' || full.estatus === '6') && id_rol_general == 17 ) {
                    return '<input type="checkbox" name="idTQ[]" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
                } else if ($('#filtro44').val() === '2' && id_rol_general == 17 ) {
                    if (full.forma_pago.toLowerCase() !== 'factura' && id_rol_general == 17 && full.recision != '1' ) {
                        return '<input type="checkbox" name="idTQ[]" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
                    } else {
                        return '';
                    }
                } else {
                    if(id_rol_general == 17 && full.recision != '1'){
                        return '<input type="checkbox" name="idTQ[]" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
                    }else{
                        return '';
                    }
                }
            },
            select: {
                style:    'os',
                selector: 'td:first-child'
            },
        }],
        ajax: {
            url: `${general_base_url}Comisiones/getDatosHistorialPagoEstatus/${proyecto}/${condominio}/${usuario}`,
            type: "POST",
            cache: false,
            data: function( d ){}
        },
        initComplete: function(){
            $("#spiner-loader").addClass('hide');
        },
    });

    $('#tabla_historialGral').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $("#tabla_historialGral tbody").on("click", ".consultar_logs_asimilados", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        lote = $(this).attr("data-value");
        $("#seeInformationModalAsimilados").modal();
        $("#nameLote").append('<p><h5>HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
        $.getJSON("getComments/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comments-list-asimilados").append('<li><div class="container-fluid"><div class="row"><div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><a><b>' + v.nombre_usuario + '</b></a><br></div> <div class="float-end text-right"><a>' + v.fecha_movimiento + '</a></div><div class="col-md-12"><p class="m-0"><b> ' + v.comentario + '</b></p></div></div></div></li>');
            });
        });
    }); 
}

$('#estatus-form').on('submit', function (e) {
    e.preventDefault();
    const estatusId = $('input[name="estatus"]:checked').val();
    let comentario = $('#comentario').val();

    if (estatusId === '1') {
        comentario = `Se marcó como NUEVA: ${comentario}`;
    } else if (estatusId === '4') {
        comentario = `Se marcó como REVISIÓN CONTRALORÍA: ${comentario}`;
    } else if (estatusId === '6') {
        comentario = `Se marcó como PAUSADA: ${comentario}`;
    }

    let formData = new FormData();
    formData.append('idPagos', seleccionados);
    formData.append('estatus', estatusId);
    formData.append('comentario', comentario);

    $.ajax({
        type: 'POST',
        url: 'cambiarEstatusComisiones',
        data: formData,
        contentType: false,
        cache: false,
        processData:false,
        success: function (response) {
            if (JSON.parse(response)) {
                $('#movimiento-modal').modal('hide');
                appendBodyModal(`
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h3 style='color:#676767;'>Se cambiaron los estatus de los pagos seleccionados</h3>
                        </div>
                        <div class="col-lg-12 text-right ">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                `);
                showModal();
                tabla_historialGral2.ajax.reload();
            } else {
                $('#movimiento-modal').modal('hide');
                appendBodyModal(`
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h3>Error al enviar comisiones</h3>
                            <img style='width: 200px; height: 200px;' src='${general_base_url}dist/img/error.gif'>
                            <br>
                            <p style="font-size: 16px">No se pudo ejecutar esta acción, intentalo más tarde.</p>
                        <div>
                    </div>
                `);
                showModal();
            }
        },
        error: function() {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$('#movimiento-modal').on('hidden.bs.modal', function() {
    $('#estatus-form').trigger('reset');
});

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
});