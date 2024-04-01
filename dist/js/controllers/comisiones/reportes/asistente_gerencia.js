let tablaComisiones;

$(document).ready(function () {
    $("#div-tabla").prop("hidden", true);
    $.ajax({
        url: `${general_base_url}Comisiones/getPuestoComisionesAsistentes`,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            for (let i = 0; i < data.length; i++) {
                const id = data[i].id_opcion;
                const nombre = data[i].nombre;
                $('#puestos').append($('<option>').val(id).text(nombre));
            }
            $('#puestos').selectpicker('refresh');
        }
    });

    $.ajax({
        url: `${general_base_url}Comisiones/findAllResidenciales`,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            for (let i = 0; i < data.length; i++) {
                const id = data[i].idResidencial;
                const nombre = data[i].descripcion;
                $('#proyectos').append($('<option>').val(id).text(nombre));
            }
            $('#proyectos').selectpicker('refresh');
        }
    });

    $.ajax({
        url: `${general_base_url}Comisiones/getEstatusComisionesAsistentes`,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            for (let i = 0; i < data.length; i++) {
                if (data[i].idEstatus !== 6) {
                    const id = data[i].idEstatus;
                    const nombre = data[i].nombre;
                    $('#estatus').append($('<option>').val(id).text(nombre));
                }
            }
            $('#estatus').selectpicker('refresh');
        }
    });
});

$('#puestos').on('change', function () {
    const puesto = $(this).val();
    $("#div-tabla").prop("hidden", true);
    $("#usuarios").html("");
    $('#usuarios').selectpicker('refresh');
    
    if (puesto !== '0') {
        $.ajax({
            url: `${general_base_url}Comisiones/findUsuariosByPuestoAsistente/${puesto}`,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                for (let i = 0; i < data.length; i++) {
                    const id = data[i].id_usuario;
                    const nombre = data[i].nombre_completo;
                    var diferente_lider ='';
                    diferente_lider =  data[i].id_lider  == lider_general ? '' : ' '; 
                    $('#usuarios').append($('<option>').val(id).text(nombre+diferente_lider ));
                }
                $('#usuarios').selectpicker('refresh');
            }
        });
    
    
    }
});

$('#usuarios').on('change', function () {
    const idUsuario = $(this).val();
    const idProyecto = $('#proyectos').val() || 0;
    const idEstatus = $('#estatus').val() || 0;

    if (idUsuario !== '') {
        loadTable(idUsuario, idProyecto, idEstatus);
    } else {
        $("#div-tabla").prop("hidden", true);
    }
});

$('#proyectos').on('change', function () {
    const idProyecto = $(this).val() || 0;
    const idUsuario = $('#usuarios').val();
    const idEstatus = $('#estatus').val() || 0;

    if (idUsuario !== '0') {
        loadTable(idUsuario, idProyecto, idEstatus);    console.log( idProyecto);
        console.log( idEstatus);
        console.log(idUsuario);
    }
});

$('#estatus').on('change', function () {
    const idEstatus = $(this).val();
    const idUsuario = $('#usuarios').val();
    const idProyecto = $('#proyectos').val();

    if (idUsuario !== '0') {
        loadTable(idUsuario, idProyecto, idEstatus);
    }
});

let titulos_intxt = [];
$('#tabla-historial thead tr:eq(0) th').each( function (i) {
    const title = $(this).text();
    titulos_intxt.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function () {
        if ($('#tabla-historial').DataTable().column(i).search() !== this.value ) {
            $('#tabla-historial').DataTable().column(i).search(this.value).draw();
        }
    });
});

function loadTable(idUsuario, idProyecto, idEstatus) {


    $("#div-tabla").prop("hidden", false);

    tablaComisiones = $('#tabla-historial').DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        bAutoWidth: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'HISTORIAL_GENERAL_COMISIONES',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14],
                format: {
                    header:  function (d, columnIdx) {
                        return ' ' + titulos_intxt[columnIdx] + ' ';
                    }
                }
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
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
                return '<p class="m-0">'+formatMoney(d.pago_neodata)+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+formatMoney(d.pago_cliente)+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.pagado)+'</p>';
            }
        },
        {
            "data": function( d ){
                if(d.restante==null||d.restante==''){
                    return '<p class="m-0">'+formatMoney(d.comision_total)+'</p>';
                }
                else{
                    return '<p class="m-0">'+formatMoney(d.restante)+'</p>';
                }
            }
        }, 
        {
            "data": function( d ){
                if(d.activo == 0 || d.activo == '0'){
                    return '<p class="m-0"><b>'+d.user_names+'</b></p><p><span class="label lbl-warning">BAJA</span></p>';
                }
                else{
                    return '<p class="m-0"><b>'+d.user_names+'</b></p>';
                }
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.puesto+'</p>';
            }
        },
        {
            "data": function( d ){
                var lblPenalizacion = '';

                if (d.penalizacion == 1){
                    lblPenalizacion ='<p class="m-0" title="PENALIZACIÓN + 90 DÍAS"><span class="label lbl-vividOrange"> + 90 DÍAS</span></p>';
                }

                if(d.bonificacion >= 1){
                    p1 = '<p class="m-0" title="LOTE CON BONIFICACIÓN EN NEODATA"><span class="label lbl-darkPink"">BON. '+formatMoney(d.bonificacion)+'</span></p>';
                }
                else{
                    p1 = '';
                }

                if(d.lugar_prospeccion == 0){
                    p2 = '<p class="m-0" title="LOTE CON CANCELACIÓN DE CONTRATO"><span class="label lbl-warning">RECISIÓN</span></p>';
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
                        etiqueta = '<p class="m-1">'+'<span class="label" style="background:'+d.color+'18; color:'+d.color+'">'+d.estatus_actual+'</span>'+'</p>'+'<p class="m-1">'+'<span class="label lbl-green">IMPORTACIÓN</span></p>';
                    }else{
                        etiqueta = '<p class="m-0"><span class="label" style="background:'+d.color+'18; color: '+d.color+'; ">'+d.estatus_actual+'</span></p>';
                    }

                return etiqueta;
            }
        },
        { 
            "orderable": false,
            "data": function( data ){
                var BtnStats;
                BtnStats = `<button href="#" value="${data.id_pago_i}" data-value='"${data.nombreLote}"' data-code="${data.cbbtton}" class="btn-data btn-blueMaderas consultarDetalleDelPago" title="DETALLES" data-toggle="tooltip" data-placement="top"><i class="fas fa-info"></i></button>`;
                return '<div class="d-flex justify-center">'+BtnStats+'</div>';
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox dt-body-center',
            targets:   0,
            'searchable':false,
            select: {
                style:    'os',
                selector: 'td:first-child'
            },
        }],
        
        ajax: {
            "url": `${general_base_url}Comisiones/getUsuariosByComisionesAsistentes/${idUsuario}/${idProyecto}/${idEstatus}`,
            "type": "GET",
            "cache": false,
            "data": function( d ) {}
        },
        order: [[ 1, 'asc' ]]
    });

    $('#tabla-historial').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
    });

    $("#tabla-historial tbody").on("click", ".consultarDetalleDelPago", function(e){
        $("#spiner-loader").removeClass('hide');
        e.preventDefault();
        e.stopImmediatePropagation();
        const id_pago = $(this).val();
        const lote = $(this).attr("data-value");
        $("#comments-list-asimilados").html('');
        $("#nameLote").html('');

        changeSizeModal('modal-md');
        appendBodyModal(`<div class="modal-body">
            <div role="tabpanel">
                <ul class="nav" role="tablist">
                    <div id="nameLote"></div>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="changelogTab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-plain m-0">
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
            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
        </div>`);
        showModal();

        $.getJSON(general_base_url+"Pagos/getComments/"+id_pago).done( function( data ){
            $("#spiner-loader").addClass('hide');
            $("#nameLote").append('<p><h5>HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
            $.each( data, function(i, v){
                $("#comments-list-asimilados").append('<li><div class="container-fluid"><div class="row"><div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><a><b>' + v.nombre_usuario + '</b></a><br></div> <div class="float-end text-right"><a>' + v.fecha_movimiento + '</a></div><div class="col-md-12"><p class="m-0"><b> ' + v.comentario + '</b></p></div></div></div></li>');
            });
        });
    });
}
