
const tipo_ventas =  [
    {
        id_venta:1,
        ruta:'Comisiones/getDatosHistorialPagoEstatus'
    },
    {
        id_venta:2,
        ruta:'Comisiones/getDatosHistorialPagoEstatus'
    },
    {
        id_venta:3,
        ruta:'Casas_comisiones/getDatosHistorialCasas'
    },
    {
        id_venta:0,
        ruta: ''	
    }
];


$(document).ready(function() {
    $("#tabla_historialGral").prop("hidden", true);
    $("#spiner-loader").removeClass('hide');
    $.post(general_base_url + "Contratacion/lista_proyecto", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];
            $("#catalogo_general").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#catalogo_general").selectpicker('refresh');
    }, 'json');

    $.ajax({
        url: general_base_url + 'Comisiones/lista_estatus',
        type: 'post',
        dataType: 'json',
        success:function(response){
            const len = response.length;
            for(let i = 0; i<len; i++){
                const id = response[i]['idEstatus'];
                const name = response[i]['nombre'];
                $("#estatus_general").append($('<option>').val(id).text(name));
            }
            $("#estatus_general").selectpicker('refresh');
            $("#spiner-loader").addClass('hide');
        }
    });

    $.getJSON( general_base_url + "Incidencias/getUsers/").done( function( data ){
        listaUsuarios = data;
        gerente = data.filter((gere) => gere.id_rol == parseInt(3));
        len3 = gerente.length;
        for( let i3=0; i3<len3; i3++){
            var id_usario_gerente = gerente[i3]['id_usuario'];
            var nombre_gerente = gerente[i3]['name_user'];

            var id3 = id_usario_gerente+','+nombre_gerente;
            
            $("#elegir_gerente").append($('<option>').val(id_usario_gerente).attr('data-value',id_usario_gerente ).text(id_usario_gerente+ "- "+ nombre_gerente));
        }
        coordinador = data.filter((coor) => coor.id_rol == parseInt(9));
        len2 = coordinador.length;
        for( var i2= 0; i2<len2; i2++){
            var id_opcion_coordinador = coordinador[i2]['id_usuario'];
            var nombre_coordinador = coordinador[i2]['name_user'];

            var id2 = id_opcion_coordinador+','+nombre_coordinador;
            $("#elegir_coordinador").append($('<option>').val(id_opcion_coordinador).attr('data-value',id_opcion_coordinador ).text(id_opcion_coordinador+ "- "+ nombre_coordinador)); 
        }
        asesor = data.filter((ases) => ases.id_rol == parseInt(7));
        len = asesor.length;
        for( var i= 0; i<len; i++){
            var id_usuario_asesor = asesor[i]['id_usuario'];
            var nombre_asesor = asesor[i]['name_user'];
            
            id =id_usuario_asesor+','+nombre_asesor; 
            $("#elegir_asesor").append($('<option>').val(id_usuario_asesor).attr('data-value',id_usuario_asesor ).text(id_usuario_asesor+ "- "+ nombre_asesor));             
        }
        $("#elegir_coordinador, #elegir_gerente, #elegir_subdirector, #elegir_asesor").selectpicker('refresh');
        
    });

    $.ajax({
        url: general_base_url + 'Casas_comisiones/selectTipo',
        type: 'post',
        dataType: 'json',
        success:function(response){
            const len = response.length;
            for(let i = 0; i<len; i++){
                const id = response[i]['id_opcion'];
                const name = response[i]['nombre'];

                if(id != 4){
                    $("#tipo_general").append($('<option>').val(id).text(name.toUpperCase()));
                }

            }
            $("#tipo_general").selectpicker('refresh');
            $("#spiner-loader").addClass('hide');
        }
    });

    

});


function validar(proyecto, condominio, ruta, usuario) { 

    if(proyecto === '' || proyecto === null || proyecto === undefined || condominio === '' || condominio === null || condominio === undefined || ruta === '' || ruta === null || ruta === undefined ){

    }else {

        $('#puesto_general').html('');
        $("#puesto_general").selectpicker("refresh");
        $('#puesto_general').val('default');

        $('#puesto_general').append($('<option>').val(1).text('GERENTE'));
        $('#puesto_general').append($('<option>').val(2).text('ASESOR'));
        $('#puesto_general').append($('<option>').val(3).text('COORDINADOR'));
        $("#puesto_general").selectpicker('refresh');

        if (usuario === undefined || usuario === null || usuario === '' || usuario === 0) {
            usuario = 0;
            $('#puesto_general').html('');
            $("#puesto_general").selectpicker("refresh");
            $('#puesto_general').val('default');
            $('#puesto_general').append($('<option>').val(1).text('GERENTE'));
            $('#puesto_general').append($('<option>').val(2).text('ASESOR'));
            $('#puesto_general').append($('<option>').val(3).text('COORDINADOR'));
            $("#puesto_general").selectpicker('refresh');
            $('#add_coordinador, #add_asesor,#add_gerente').addClass('hidden'); 

        }
        $("#spiner-loader").removeClass('hide');

        asimiladoComisiones(ruta, proyecto, condominio, usuario);
      
    }

}

$('#tipo_general, #catalogo_general, #estatus_general').change(function(ruta){
    
    var seleccionado = $('#tipo_general').val();
    tipo_selec = seleccionado == '' ? 0 : seleccionado; 
    const dataTipo = tipo_ventas.find((tipo) => tipo.id_venta == parseInt(tipo_selec));
    var ruta = dataTipo.ruta;
    var proyecto = $('#catalogo_general').val();
    var condominio = $('#estatus_general').val();
    var usuario = 0

    validar(proyecto, condominio,ruta, usuario);
    
});

$('#puesto_general').change(function(ruta){
    $('#elegir_gerente, #elegir_asesor, #elegir_coordinador').val('default');
    $("#elegir_gerente, #elegir_asesor, #elegir_coord inador").selectpicker("refresh");

    let puesto_seleccionado = $(this).val();
    puesto_seleccionado == 1 ? $('#add_coordinador, #add_asesor').addClass('hidden') && $('#add_gerente').removeClass('hidden') : '';  
    puesto_seleccionado == 2 ? $('#add_coordinador, #add_gerente').addClass('hidden') && $('#add_asesor').removeClass('hidden') : '';  
    puesto_seleccionado == 3 ? $('#add_asesor, #add_gerente').addClass('hidden') && $('#add_coordinador').removeClass('hidden') : '';  


});

$('.seleccionar_puesto').change(function () {
   usuario = $(this).val();
   var seleccionado = $('#tipo_general').val();
   tipo_selec = seleccionado == '' ? 0 : seleccionado; 
   const dataTipo = tipo_ventas.find((tipo) => tipo.id_venta == parseInt(tipo_selec));
   var ruta = dataTipo.ruta;
   var proyecto = $('#catalogo_general').val();
   var condominio = $('#estatus_general').val();

   validar(proyecto, condominio,ruta, usuario);
    
});

$('#usuario_general').change(function () {
    let proyecto = $('#catalogo_general').val();
    let condominio = $('#estatus_general').val();
    $("#spiner-loader").removeClass('hide');
    if(condominio === '' || condominio === null || condominio === undefined){
        condominio = 0;
    }

    let usuario = $('#usuario_general').val();
    if (usuario === undefined || usuario === null || usuario === '') {
        usuario = 0;
    }

    asimiladoComisiones(proyecto, condominio, usuario);
});

let titulos_intxt = [];
$('#tabla_historialGral thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos_intxt.push(title);
    if(i != 0){
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function() {
            if (tabla_historialGral2.column(i).search() !== this.value) {
                tabla_historialGral2.column(i).search(this.value).draw();
            }
        });
    }      
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

const optNueva = `<div class="w-100"><input class="d-none" type="radio" name="estatus" id="estatus-nueva" value="1" required><label class="w-100" for="estatus-nueva">Nueva</label></div>`;
const optRevision = `<div class="w-100"><input class="d-none" type="radio" name="estatus" id="estatus-revision" value="4" required><label class="w-100" for="estatus-revision"> Revisión contraloría</label></div>`;
const optPausado = `<div class="w-100"><input class="d-none" type="radio" name="estatus" id="estatus-pausado" value="6" required><label class="w-100" for="estatus-pausado"> Pausado</label></div>`;
const optPagado = `<div class="w-100"><input class="d-none" type="radio" name="estatus" id="estatus-pagado" value="11" required><label class="w-100" for="estatus-pagado"> Pagado</label></div>`;

let seleccionados = [];
function asimiladoComisiones(ruta, proyecto, condominio, usuario){
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
                    const estatus = $('#estatus_general').val();
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
                var lblPenalizacion = '', p3='', p1='';

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

                if(d.id_cliente_reubicacion_2 != 0 ) {
                    p3 = `<p class="${d.colorProcesoCl}">${d.procesoCl}</p>`;
                }else{
                    p3 = '';
                }

                return p1 + p2 + lblPenalizacion + p3;                
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
                const estatus = $('#estatus_general').val();
                if (( full.recision == '1' || estatus === '3' || estatus === '5' || estatus === '6' || estatus === '7') && id_rol_general != 17 ) {
                    return '';
                } else if ( full.recision != '1' && estatus === '7' && (full.estatus === '1' || full.estatus === '6') && id_rol_general == 17 ) {
                    return '<input type="checkbox" name="idTQ[]" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
                } else if ($('#estatus_general').val() === 2 && id_rol_general == 17 ) {
                    if (full.forma_pago !== 2 && id_rol_general == 17 && full.recision != '1' ) {
                        return '<input type="checkbox" name="idTQ[]" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
                    } else {
                        return '';
                    }
                } else {
                    if(id_rol_general == 17 && full.recision != '1' && full.estatus != 11 ){
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
            url: `${general_base_url}${ruta}/${proyecto}/${condominio}/${usuario}`,
            type: "POST",
            cache: false,
            data: function( d ){}
        },
        initComplete: function(){
            $("#spiner-loader").addClass('hide');
        },
    });

    $('#tabla_historialGral').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
    });

    $("#tabla_historialGral tbody").on("click", ".consultar_logs_asimilados", function(e){
        let tipo = $('#tipo_general').val();
        let ruta = tipo == 1 || tipo == 2 ? 'Comisiones/getComments' : 'Casas_comisiones/getComments';
        $("#nombreLote").html('');
        $("#comentariosListaAsimilados").html('');
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        lote = $(this).attr("data-value");

        changeSizeModal("modal-md");
        appendBodyModal(`<div class="modal-body">
            <div role="tabpanel">
                <ul class="nav" role="tablist">
                    <div id="nombreLote"></div>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="changelogTab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-plain">
                                    <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                        <ul class="timeline-3" id="comentariosListaAsimilados"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"<b>Cerrar</b></button>
        </div>`);
        showModal();

        $("#nombreLote").append('<p><h5>HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
        $.getJSON(general_base_url+ruta+"/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comentariosListaAsimilados").append('<li><div class="container-fluid"><div class="row"><div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><a><b>' + v.nombre_usuario + '</b></a><br></div> <div class="float-end text-right"><a>' + v.fecha_movimiento + '</a></div><div class="col-md-12"><p class="m-0"><b> ' + v.comentario + '</b></p></div></div></div></li>');
            });
        });
    }); 
}

$('#estatus-form').on('submit', function (e) {
    let tipo = $('#tipo_general').val();
    let ruta = tipo == 1 || tipo == 2 ? 'Comisiones/cambiarEstatusComisiones' : 'Casas_comisiones/cambiarEstatusComisiones';
    e.preventDefault();
    const estatusId = $('input[name="estatus"]:checked').val();
    let comentario = $('#comentario').val();
    if (estatusId === 1) {
        comentario = `Se marcó como NUEVA: ${comentario}`;
    } else if (estatusId === 4) {
        comentario = `Se marcó como REVISIÓN CONTRALORÍA: ${comentario}`;
    } else if (estatusId === 6) {
        comentario = `Se marcó como PAUSADA: ${comentario}`;
    }

    let formData = new FormData();
    formData.append('idPagos', seleccionados);
    formData.append('estatus', estatusId);
    formData.append('comentario', comentario);

    $.ajax({
        type: 'POST',
        url: general_base_url+ruta,
        data: formData,
        contentType: false,
        cache: false,
        processData:false,
        success: function (response) {
            if (JSON.parse(response)) {
                $('#movimiento-modal').modal('hide');
                appendBodyModal(`<div class="row">
                        <div class="col-lg-12 text-center">
                            <h3 style='color:#676767;'>Se cambiaron los estatus de los pagos seleccionados</h3>
                        </div>
                        <div class="col-lg-12 text-right ">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>`);
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