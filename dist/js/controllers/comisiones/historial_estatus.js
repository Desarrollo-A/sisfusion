$(document).ready(function() {
    $("#tabla_historialGral").prop("hidden", true);

    $.post(url+"Contratacion/lista_proyecto", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];
            $("#filtro33").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#filtro33").selectpicker('refresh');
    }, 'json');

    $.get(`${url2}Comisiones/getPuestoByIdOpts`, function (data) {
        const puestos = JSON.parse(data);
        $('#roles').append($('<option>').val('').text('SELECCIONA UN ROL'));
        puestos.forEach(puesto => {
            const id = puesto.id_opcion;
            const name = puesto.nombre.toUpperCase();

            $('#roles').append($('<option>').val(id).text(name));
        });

        $("#roles").selectpicker('refresh');
    });
});

$('#filtro33').change(function(ruta){
    $("#filtro44").empty().selectpicker('refresh');

    $.ajax({
        url: url+'Comisiones/lista_estatus',
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
        }
    });
});

$('#filtro44').change(function(ruta){
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

    $.ajax({
        url: `${url}Comisiones/getUsersName`,
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

$('#tabla_historialGral thead tr:eq(0) th').each( function (i) {
    let titulos = [];
    if(i != 0){
        var title = $(this).text();
        titulos.push(title);
        $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>');
        $('input', this).on('keyup change', function() {
            if (tabla_historialGral2.column(i).search() !== this.value) {
                tabla_historialGral2.column(i).search(this.value).draw();

                var total = 0;
                var index = tabla_historialGral2.rows({
                    selected: true,
                    search: 'applied'
                }).indexes();
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

const optNueva = `
    <div class="form-check">
        <input class="form-check-input"
            type="radio"
            name="estatus"
            id="estatus-nueva"
            value="1"
            required>
        <label class="form-check-label"
            for="estatus-nueva">
        Nueva
        </label>
    </div>`;
const optRevision = `
    <div class="form-check">
        <input class="form-check-input"
            type="radio"
            name="estatus"
            id="estatus-revision"
            value="4"
            required>
        <label class="form-check-label"
            for="estatus-revision">
        Revisión contraloría
        </label>
    </div>`;
const optPausado = `
    <div class="form-check">
        <input class="form-check-input"
            type="radio"
            name="estatus"
            id="estatus-pausado"
            value="6"
            required>
        <label class="form-check-label"
            for="estatus-pausado">
        Pausado
        </label>
    </div>`;
const optPagado = `
    <div class="form-check">
        <input class="form-check-input"
            type="radio"
            name="estatus"
            id="estatus-pagado"
            value="11"
            required>
        <label class="form-check-label"
            for="estatus-pagado">
        Pagado
        </label>
    </div>`;

let seleccionados = [];
//INICIO TABLA QUERETARO*****************************************

function getAssimilatedCommissions(proyecto, condominio, usuario){
    let titulos = [];
    $("#tabla_historialGral").prop("hidden", false);
    tabla_historialGral2 = $("#tabla_historialGral").DataTable({
        dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
        width: 'auto',
        buttons: [{
            text: 'MOVIMIENTO',
            action: function() {
                seleccionados = [];

                if ($('input[name="idTQ[]"]:checked').length > 0) {
                    const estatus = $('#filtro44').val();
                    const idComisiones = $(tabla_historialGral2.$('input[name="idTQ[]"]:checked'))
                        .map(function () {
                            return this.value;
                        })
                        .get();

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

                    const titlePagos = (idComisiones.length > 1)
                        ? `<b>${idComisiones.length}</b> pagos seleccionados`
                        : `<b>${idComisiones.length}</b> pago seleccionado`;

                    $('#total-pagos').html('').html(titlePagos);
                    $('#div-options').html('').html('<label>Seleccione una opción:</label>'+options);
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
                        if(columnIdx == 0){
                            return ' '+d +' ';
                        }else if(columnIdx == 1){
                            return 'ID PAGO';
                        }else if(columnIdx == 2){
                            return 'PROYECTO';
                        }else if(columnIdx == 3){
                            return 'CONDOMINIO';
                        }else if(columnIdx == 4){
                            return 'NOMBRE LOTE';
                        }else if(columnIdx == 5){
                            return 'REFERENCIA';
                        }else if(columnIdx == 6){
                            return 'PRECIO LOTE';
                        }else if(columnIdx == 7){
                            return 'TOTAL COMISIÓN';
                        }else if(columnIdx == 8){
                            return 'PAGO CLIENTE';
                        }else if(columnIdx == 9){
                            return 'DISPERSADO NEODATA';
                        }else if(columnIdx == 10){
                            return 'PAGADO';
                        }else if(columnIdx == 11){
                            return 'PENDIENTE';
                        }else if(columnIdx == 12){
                            return 'COMISIONISTA';
                        }else if(columnIdx == 13){
                            return 'PUESTO';
                        }else if(columnIdx == 14){
                            return 'DETALLE';
                        }else if(columnIdx == 15){
                            return 'ESTATUS ACTUAL';
                        }else if(columnIdx != 16 && columnIdx !=0){
                            return ' '+titulos[columnIdx-1] +' ';
                        }
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: url+"/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            "width": "2%",
        },
        {
            "width": "5%",
            "data": function( d ){
                var lblStats;
                lblStats ='<p class="m-0"><b>'+d.id_pago_i+'</b></p>';
                return lblStats;
            }
        },
        {
            "width": "5%",
            "data": function( d ){
                return '<p class="m-0">'+d.proyecto+'</p>';
            }
        },
        {
            "width": "6%",
            "data": function( d ){
                return '<p class="m-0">'+d.condominio+'</p>';
            }
        },
        {
            "width": "7%",
            "data": function( d ){
                return '<p class="m-0">'+d.nombreLote+'</p>';
            }
        },
        {
            "width": "5%",
            "data": function( d ){
                return '<p class="m-0">'+d.referencia+'</p>';
            }
        },
        {
            "width": "6%",
            "data": function( d ){
                return '<p class="m-0">$'+formatMoney(d.precio_lote)+'</p>';
            }
        },
        {
            "width": "6%",
            "data": function( d ){
                return '<p class="m-0">$'+formatMoney(d.comision_total)+' </p>';
            }
        },
        {
            "width": "6%",
            "data": function( d ){
                return '<p class=""m-0>$'+formatMoney(d.pago_neodata)+'</p>';
            }
        },
        {
            "width": "7%",
            "data": function( d ){
                return '<p class=""m-0><b>$'+formatMoney(d.pago_cliente)+'</b></p>';
            }
        },
        {
            "width": "6%",
            "data": function( d ){
                return '<p class=""m-0>$'+formatMoney(d.pagado)+'</p>';
            }
        },
        {
            "width": "6%",
            "data": function( d ){
                if(d.restante==null||d.restante==''){
                    return '<p class=""m-0>$'+formatMoney(d.comision_total)+'</p>';
                }else{
                    return '<p class=""m-0>$'+formatMoney(d.restante)+'</p>';
                }
            }
        }, 
        {
            "width": "5%",
            "data": function( d ){
                if(d.activo == 0 || d.activo == '0'){
                    return '<p class=""m-0><b>'+d.user_names+'</b></p><p class=""m-0><span class="label" style="background:red;">BAJA</span></p>';
                }
                else{
                    return '<p class=""m-0><b>'+d.user_names+'</b></p>';
                }
            }
        },
        {
            "width": "5%",
            "data": function( d ){
                return '<p class=""m-0>'+d.puesto+'</p>';
            }
        },
        {
            "width": "5%",
            "data": function( d ){
                var lblPenalizacion = '';

                if (d.penalizacion == 1){
                    lblPenalizacion ='<p class="m-0" title="Penalización + 90 días"><span class="label" style="background:orange;">Penalización + 90 días</span></p>';
                }

                if(d.bonificacion >= 1){
                    p1 = '<p class="m-0" title="Lote con bonificación en NEODATA"><span class="label" style="background:pink;color: black;">Bon. $'+formatMoney(d.bonificacion)+'</span></p>';
                }
                else{
                    p1 = '';
                }

                if(d.lugar_prospeccion == 0){
                    p2 = '<p class="m-0" title="Lote con cancelación de CONTRATO"><span class="label" style="background:RED;">Recisión</span></p>';
                }
                else{
                    p2 = '';
                }
                
                return p1 + p2 + lblPenalizacion;
            }
        },
        {
            "width": "5%",
            "data": function( d ){
                var etiqueta;

                        if(d.pago_neodata < 1){
                            etiqueta = '<p class="m-0"><span class="label" style="background:'+d.color+';">'+d.estatus_actual+'</span></p><p class="m-0"><span class="label" style="background:#5FD482;">IMPORTACIÓN</span></p>';
                        }else{

                            etiqueta = '<p class="m-0"><span class="label" style="background:'+d.color+';">'+d.estatus_actual+'</span></p>';
                        }

                return etiqueta;
            }
        },
        { 
            "width": "2%",
            "orderable": false,
            "data": function( data ){
                var BtnStats;

                BtnStats = '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.nombreLote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_asimilados" title="Detalles">' +'<i class="fas fa-info"></i></button>';
        
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
                /*Moficacion Uri*/ 
                if (( full.recision == '1' || estatus === '3' || estatus === '5' || estatus === '6' || estatus === '7') && rol != 17 ) {
                    return '';
                } else if ( full.recision != '1' && estatus === '7' && (full.estatus === '1' || full.estatus === '6') && rol == 17 ) {
                    return '<input type="checkbox" name="idTQ[]" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
                } else if ($('#filtro44').val() === '2' && rol == 17 ) {
                    if (full.forma_pago.toLowerCase() !== 'factura' && rol == 17 && full.recision != '1' ) {
                        return '<input type="checkbox" name="idTQ[]" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
                    } else {
                        return '';
                    }
                } else {
                    if(rol == 17 && full.recision != '1'){
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
            url: `${url2}Comisiones/getDatosHistorialPagoEstatus/${proyecto}/${condominio}/${usuario}`,
            type: "POST",
            cache: false,
            data: function( d ){}
        },
    });

    $("#tabla_historialGral tbody").on("click", ".consultar_logs_asimilados", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();

        id_pago = $(this).val();
        lote = $(this).attr("data-value");

        $("#seeInformationModalAsimilados").modal();
        $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
        $.getJSON("getComments/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:gray;">'+v.comentario+'</i><br><b style="color:#3982C0">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.nombre_usuario+'</b></p></div>');
            });
        });
    }); 

    /*$("#tabla_historialGral tbody").on("click", ".cambiar_pausa", function(){
        var tr = $(this).closest('tr');
        var row = tabla_historialGral2.row( tr );

        id_pago_i = $(this).val();

        $("#modal_nuevas .modal-body").html("");
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Está seguro de despausar la comisión de <b>'+row.data().nombreLote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().user_names+'</i>?</p></div></div>');
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="hidden" name="value_pago" value="1"><input type="text" class="form-control observaciones" name="observaciones" required placeholder="Describe mótivo por el cual se va activar nuevamente la solicitud"></input></div></div>');
        $("#modal_nuevas .modal-body").append('<input type="hidden" name="id_pago" value="'+row.data().id_pago_i+'"><input type="hidden" name="estatus" id="estatus" readonly="true" value="4">');
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-md-6"></div><div class="col-md-3"><input type="submit" class="btn btn-primary" value="ACTIVAR"></div><div class="col-md-3"><button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button></div></div>');
        $("#modal_nuevas").modal();
    });*/

    /*$("#tabla_historialGral tbody").on("click", ".actualizar_pago", function(){
        var tr = $(this).closest('tr');
        var row = tabla_historialGral2.row( tr );

        id_pago_i = $(this).val();

        $("#modal_nuevas .modal-body").html("");
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p> Actualizar pago <b>'+row.data().nombreLote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().user_names+'</i>?</p></div></div>');
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="hidden" name="value_pago" value="2"><input type="number" class="form-control observaciones" name="observaciones" required placeholder="Monto a editar"></input></div></div>');
        $("#modal_nuevas .modal-body").append('<input type="hidden" name="id_pago" value="'+row.data().id_pago_i+'">');
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-md-6"></div><div class="col-md-3"><input type="submit" class="btn btn-primary" value="ACTIVAR"></div><div class="col-md-3"><button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button></div></div>');
        $("#modal_nuevas").modal();
    });*/

    /*$("#tabla_historialGral tbody").on("click", ".agregar_pago", function(){
        var tr = $(this).closest('tr');
        var row = tabla_historialGral2.row( tr );

        id_pago_i = $(this).val();

        $("#modal_nuevas .modal-body").html("");
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>Agregar nuevo pago a <b>'+row.data().nombreLote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().user_names+'</i>?</p></div></div>');
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="hidden" name="value_pago" value="3"><input type="number" class="form-control observaciones" name="observaciones" required placeholder="Monto a agregar"></input></div></div>');
        $("#modal_nuevas .modal-body").append('<input type="hidden" name="id_pago" value="'+row.data().id_pago_i+'">');
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-md-6"></div><div class="col-md-3"><input type="submit" class="btn btn-primary" value="ACTIVAR"></div><div class="col-md-3"><button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button></div></div>');
        $("#modal_nuevas").modal();
    });*/
}

//FIN TABLA  **********************************************

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
                            <img style='width: 200px; height: 200px;'
                                src='${url}dist/img/check.gif'>
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
                            <img style='width: 200px; height: 200px;'
                                        src='${url}dist/img/error.gif'>
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

function formatMoney( n ) {
    var c = isNaN(c = Math.abs(c)) ? 2 : c,
    d = d == undefined ? "." : d,
    t = t == undefined ? "," : t,
    s = n < 0 ? "-" : "",
    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
    j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

/*function cancela(){
    $("#modal_nuevas").modal('toggle');
}*/

//Función para pausar la solicitud
/*$("#form_interes").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        console.log(data);
        data.append("id_pago_i", id_pago_i);
        $.ajax({
            url: url + "Comisiones/despausar_solicitud",
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
                    alerts.showNotification("top", "right", "Se ha pausado la comisión exitosamente", "success");
                    setTimeout(function() {
                        tabla_historialGral2.ajax.reload();
                    }, 3000);
                }else{
                    alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");

                }
            },error: function( ){
                alert("ERROR EN EL SISTEMA");
            }
        });
    }
});*/

/*$(document).on("click", ".btn-historial-lo", function(){
    window.open(url+"Comisiones/getHistorialEmpresa", "_blank");
});*/

/*function cleanComments(){
    var myCommentsList = document.getElementById('documents');
    myCommentsList.innerHTML = '';

    var myFactura = document.getElementById('facturaInfo');
    myFactura.innerHTML = '';
}*/