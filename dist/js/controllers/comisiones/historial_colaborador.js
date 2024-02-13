const excluir_column = ['MÁS', ''];
let columnas_datatable = {};

$(document).on("click", "#fechaHistorialActivos", function () {
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    getAssimilatedCommissions(finalBeginDate, finalEndDate);
});

$(document).on("click", "#fechaCancelados", function () {
    let finalBeginDate = $("#inicioCancelados").val();
    let finalEndDate = $("#finalCancelados").val();
    getAssimilatedCancelacion(finalBeginDate, finalEndDate);
});

$(document).on("click", "#fechaSuma", function () {
    let finalBeginDate = $("#inicioSuma").val();
    let finalEndDate = $("#finalSuma").val();
    tableComisionesSuma(finalBeginDate, finalEndDate);
}); 

$(document).ready(function () {
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    setIniDatesXMonth("#beginDate", "#endDate");
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    getAssimilatedCommissions(finalBeginDate, finalEndDate);
    $('#tabla_historialGral').removeClass('hide');
});

$("#historialCanceladas").on("click", function(){
    if ($('#tabla_comisiones_canceladas').DataTable().data().length === 0){ 
        setIniDatesXMonth("#inicioCancelados", "#finalCancelados");
        let inicioCanceladas = $("#inicioCancelados").val();
        let finalCanceladas = $("#finalCancelados").val();
        getAssimilatedCancelacion(inicioCanceladas, finalCanceladas);
        $('#tabla_comisiones_canceladas').removeClass('hide');
    }
});

$("#historialSuma").on("click", function(){
    if ($('#tabla_comisiones_suma').DataTable().data().length === 0){ 
        setIniDatesXMonth("#inicioSuma", "#finalSuma");
        let inicioSuma = $("#inicioSuma").val();
        let finalSuma = $("#finalSuma").val();
        tableComisionesSuma(inicioSuma, finalSuma);
        $('#tabla_comisiones_suma').removeClass('hide');
    }
});

sp = { //  SELECT PICKER
    initFormExtendedDatetimepickers: function () {
        $('.datepicker').datetimepicker({
            format: 'DD/MM/YYYY',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove',
                inline: true
            }
        });
    }
}

var totalLeon = 0;
var totalQro = 0;
var totalSlp = 0;
var totalMerida = 0;
var totalCdmx = 0;
var totalCancun = 0;
var tr;
var tabla_historialGral2 ; 
var tabla_historialGral3 ;
var totaPen = 0;

function modalHistorial(){
    changeSizeModal("modal-md");
    appendBodyModal(`<div class="modal-header"></div>
        <div class="modal-body">
            <div role="tabpanel">
                <h6 id="nameLote"></h6>
                <div class="container-fluid" id="changelogTab">
                    <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                        <ul class="timeline-3" id="comments-list-asimilados"></ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"><b>Cerrar</b></button>
        </div>`);
    showModal();
}

function getAssimilatedCommissions(beginDate, endDate){
    asignarValorColumnasDT("tabla_historialGral");
    $('#tabla_historialGral thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        if (!excluir_column.includes(title)) {
            columnas_datatable.tabla_historialGral.titulos_encabezados.push(title);
            columnas_datatable.tabla_historialGral.num_encabezados.push(columnas_datatable.tabla_historialGral.titulos_encabezados.length-1);
        }
        let readOnly = excluir_column.includes(title) ? 'readOnly' : '';
        if (title !== '') {
            $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}" ${readOnly}/>`);
            $( 'input', this ).on('keyup change', function () {
                if ($('#tabla_historialGral').DataTable().column(i).search() !== this.value ) {
                    $('#tabla_historialGral').DataTable().column(i).search(this.value).draw();
                }
            });
        }
    });

    $("#tabla_historialGral").prop("hidden", false);
    tabla_historialGral2 = $("#tabla_historialGral").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%', 
        scrollX:true,               
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'HISTORIAL GENERAL ACTIVAS',
            exportOptions: {
                columns: columnas_datatable.tabla_historialGral.num_encabezados,
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + columnas_datatable.tabla_historialGral.titulos_encabezados[columnIdx] + ' ';
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
        deferRender: true,
        columns: [{
            "data": function( d ){
                var lblStats;
                lblStats ='<p class="m-0"><b>'+d.id_pago_i+'</b></p>';
                return lblStats;
            }
        },
        { data: "proyecto" },
        { data: "condominio" },
        { data: "nombreLote" },
        { data: "referencia" },
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
        { data: "puesto" },
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
            className: 'select-checkbox',
            targets:   0,
            'searchable':true,
            'className': 'dt-body-center',
            select: {
                style:    'os',
                selector: 'td:first-child'
            },
        }],
        ajax: {
            "url": general_base_url + "Comisiones/getDatosHistorialPago",
            "type": "POST",
            cache: false,
            data: {
                "beginDate": beginDate,
                "endDate": endDate,
            }
        },
        order: [[ 1, 'asc' ]],
    });

    $('#tabla_historialGral').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
    });
}

function getAssimilatedCancelacion(finalBeginDate, finalEndDate){
    asignarValorColumnasDT("tabla_comisiones_canceladas");
    $('#tabla_comisiones_canceladas thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        if (!excluir_column.includes(title)) {
            columnas_datatable.tabla_comisiones_canceladas.titulos_encabezados.push(title);
            columnas_datatable.tabla_comisiones_canceladas.num_encabezados.push(columnas_datatable.tabla_comisiones_canceladas.titulos_encabezados.length-1);
        }
        let readOnly = excluir_column.includes(title) ? 'readOnly' : '';
        if (title !== '') {
            $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}" ${readOnly}/>`);
            $( 'input', this ).on('keyup change', function () {
                if ($('#tabla_comisiones_canceladas').DataTable().column(i).search() !== this.value ) {
                    $('#tabla_comisiones_canceladas').DataTable().column(i).search(this.value).draw();
                }
            });
        }
    });

    $("#tabla_comisiones_canceladas").prop("hidden", false);
    tabla_historialGral3 = $("#tabla_comisiones_canceladas").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',        
        scrollX:true,                       
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'HISTORIAL GENERAL CANCELADAS',
            exportOptions: {
                columns: columnas_datatable.tabla_comisiones_canceladas.num_encabezados,
                format: {
                    header:  function (d, columnIdx) {
                        return ' '+columnas_datatable.tabla_comisiones_canceladas.titulos_encabezados[columnIdx] +' ';
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
        deferRender: true,
        columns: [{
            "data": function( d ){
                var lblStats;
                lblStats ='<p class="m-0"><b>'+d.id_pago_i+'</b></p>';
                return lblStats;
            }
        },
        { data: "proyecto" },
        { data: "condominio" },
        { data: "nombreLote" },
        { data: "referencia" },
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
        { data: "puesto" },
        {
            "data": function( d ){
                var lblPenalizacion = '';

                if (d.penalizacion == 1){
                    lblPenalizacion ='<p class="m-0" title="PENALIZACIÓN + 90 DÍAS"><span class="label lbl-vividOrange"> + 90 DÍAS</span></p>';
                }
                if(d.bonificacion >= 1){
                    p1 = '<p class="m-0" title="LOTE CON BONIFICACIÓN EN NEODATA"><span class="label lbl-darkPink"">BON.'+formatMoney(d.bonificacion)+'</span></p>';
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
                            etiqueta = '<p class="m-0">'+
                                '<span class="label" style="background:'+d.color+'18; color:'+d.color+'">'
                                    +d.estatus_actual+
                                '</span>'+
                            '</p>'+
                            '<p class="m-0">'+
                                '<span class="label lbl-green">'+
                                    'IMPORTACIÓN'+
                                '</span>'+
                            '</p>';
                        }else{
                            etiqueta = '<p class="m-0"><span class="label" style="background:'+d.color+'18; color:'+d.color+'">'+d.estatus_actual+'</span></p>';
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
            className: 'select-checkbox',
            targets:   0,
            'searchable':false,
            'className': 'dt-body-center',
            select: {
                style:    'os',
                selector: 'td:first-child'
            },
        }],
        ajax: {
            "url": general_base_url + "Comisiones/getDatosHistorialCancelacion",
            "type": "POST",
            cache: false,
            data: {
                "beginDate": finalBeginDate,
                "endDate": finalEndDate,
            }
        },
        order: [[ 1, 'asc' ]],
    });

    $('#tabla_comisiones_canceladas').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
    });
}

$('a[data-toggle="tooltip"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
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
            type: 'POST',
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
});

function cleanComments(){
    var myCommentsList = document.getElementById('documents');
    myCommentsList.innerHTML = '';
    var myFactura = document.getElementById('facturaInfo');
    myFactura.innerHTML = '';
}

$(document).on('click', '.ver-info-asesor', function(){
    $('#modal_informacion').modal();

    $("#tabla_modal").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX:true,               
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel ',
            titleAttr: 'Descargar archivo de Excel',
            title: 'HISTORIAL',
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
                var lblStats;
                lblStats ='<p class="m-0"><b>'+d.id_pago_i+'</b></p>';
                return lblStats;
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.nombreLote+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.abono_neodata)+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.fecha_modificacion+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.saldo_comisiones)+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">DESCUENTOS UNIVERSIDAD</p>';
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets:   0,
            'searchable':false,
            'className': 'dt-body-center',
            select: {
                style:    'os',
                selector: 'td:first-child'
            },
        }],
        ajax: {
            "url": general_base_url + "Comisiones/inforReporteAsesor",
            "type": "POST",
            cache: false,
            "data": function( d ){}
        },
        order: [[ 1, 'asc' ]]
    });
});

function tableComisionesSuma(inicioSuma, finalSuma){
    asignarValorColumnasDT("tabla_comisiones_suma");
    $('#tabla_comisiones_suma thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        if (!excluir_column.includes(title)) {
            columnas_datatable.tabla_comisiones_suma.titulos_encabezados.push(title);
            columnas_datatable.tabla_comisiones_suma.num_encabezados.push(columnas_datatable.tabla_comisiones_suma.titulos_encabezados.length-1);
        }
        let readOnly = excluir_column.includes(title) ? 'readOnly' : '';
        if (title !== '') {
            $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}" ${readOnly}/>`);
            $( 'input', this ).on('keyup change', function () {
                if ($('#tabla_comisiones_suma').DataTable().column(i).search() !== this.value ) {
                    $('#tabla_comisiones_suma').DataTable().column(i).search(this.value).draw();
                }
            });
        }
    });

    $('#tabla_comisiones_suma').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json, function(i, v) {
            total += parseFloat(v.total_comision);
        });        
    });

    tabla_suma = $("#tabla_comisiones_suma").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width:'100%',
        scrollX:true,               
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'REPORTE COMISIONES SUMA PAGADAS',
            exportOptions: {
                columns: columnas_datatable.tabla_comisiones_suma.num_encabezados,
                format: {
                    header:  function (d, columnIdx) {
                        return ' '+columnas_datatable.tabla_comisiones_suma.titulos_encabezados[columnIdx] +' ';
                    }
                }
            },
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
            "data": function(d) {
                return '<p class="m-0">' + d.id_pago_suma + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + d.referencia + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' + d.nombre_comisionista + '</b></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' + d.sede + '</b></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' + d.forma_pago + '</b></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + formatMoney(d.total_comision) + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + formatMoney(d.impuesto) + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' + d.porcentaje_comision + '%</b></p>';
            }
        },
        {
            "data": function(d) {
                return `<span padding: 7px 10px; border-radius: 20px;"><label class="m-0 fs-125"><b class="label lbl-dark-blue">${d.estatus}</b></label><span>`;
            }
        },
        {
            "orderable": false,
            "data": function(data) {
                return '<button href="#" value="'+data.id_pago_suma+'"  data-referencia="'+data.referencia+'" ' +'class="btn-data btn-blueMaderas consultar_history m-auto" data-toggle="tooltip" data-placement="top"title="DETALLES">' +'<i class="fas fa-info"></i></button>';
            }
        }],
        ajax: {
            url: general_base_url + "Suma/getAllComisionesByUser",
            type: "POST",
            data: {
                "beginDate": inicioSuma,
                "endDate": finalSuma,
            },
            dataType: 'json',
            dataSrc: ""
        },
    });

    $('#tabla_comisiones_suma').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
    });

    $("#tabla_comisiones_suma tbody").on("click", ".consultar_history", function(e){
        $('#spiner-loader').removeClass('hide');
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        referencia = $(this).attr("data-referencia");
        modalHistorial();
        $("#nameLote").html("");
        $("#comments-list-asimilados").html("");
        $("#nameLote").append('<p><h5>REFERENCIA: <b text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">'+referencia+'</b></h5></p>');
        $.getJSON(general_base_url+"Suma/getHistorial/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comments-list-asimilados").append('<li><div class="container-fluid"><div class="row"><div class="col-md-6"><a><small>MODIFICADO POR: </small><b>'+v.modificado_por+' </b></a><br></div><div class="float-end text-right"><a> '+v.fecha_movimiento+' </a></div><div class="col-md-12"><p class="m-0"><small>COMENTARIOS: </small><b>'+v.comentario+'</b></p></div><h6></h6></div></div></li>');
                $('#spiner-loader').addClass('hide');
            });
        });
    });
}

$("#anio_suma").ready( function(){
    let yearBegin = 2019;
    let currentYear = moment().year()
    while( yearBegin <= currentYear ){
        $("#anio_suma").append(`<option value="${yearBegin}">${yearBegin}</option>`);
        yearBegin++;
    }
    $("#anio_suma").selectpicker('refresh');  
});

$("#anio_suma").on("change", function(){
    tableComisionesSuma(this.value);
    $('#tabla_comisiones_suma').removeClass('hide');
})

$('a[data-toggle="tooltip"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
});

function asignarValorColumnasDT(nombre_datatable) {
    if(!columnas_datatable[`${nombre_datatable}`]) {
        columnas_datatable[`${nombre_datatable}`] = {titulos_encabezados: [], num_encabezados: []};
    }
}

let titulosHistorialDescuentos = [];
$('#tablaHistorialDescuentos thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulosHistorialDescuentos.push(title);
    $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);                       
    $('input', this).on('keyup change', function () {
        if ($('#tablaHistorialDescuentos').DataTable().column(i).search() !== this.value) {
            $('#tablaHistorialDescuentos').DataTable().column(i).search(this.value).draw();
        }
    });
	$('[data-toggle="tooltip"]').tooltip({trigger: "hover" });
});

function consultarHistorialDescuentos() {
    tablaHistorialDescuentos = $("#tablaHistorialDescuentos").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%', 
        scrollX:true,  
        ordering: false,             
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'HISTORIAL DESCUENTOS',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosHistorialDescuentos[columnIdx] + ' ';
                        }
                    }
                }
            }
        ],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: `${general_base_url}/static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        deferRender: true,
        columns: [{
            data: 'id_pago_i'
        },
        {   
            data: 'nombreResidencial'
        },
        {   
            data: 'nombreCondominio'
        },
        {   
            data: 'nombreLote'
        },
        {
            data: 'referencia'
        },
        {   
            data: 'precioLote'
        },
        {   
            data: 'comisionTotal'
        },
        {   
            data: 'montoDescuento'
        },
        {
            data: function(d){
                TextoMostrar = '';
                if(d.RelacionMotivo == 'NA'){
                    if(d.evidenciaDocs == null ){
                        TextoMostrar += `
                        <p class="m-0">
                        <span  id="textoInformacion" name="textoInformacion" class="label lbl-gray">
                            PRÉSTAMO SIN EVIDENCIA
                            ANTES DE FEBRERO DEL 2024 
                        </span>
                        </p>
                        `;
                    }else{

                    }
                }else if(d.RelacionMotivo == 'Sin préstamo relacionado'){

                    TextoMostrar += `	
                    <p class="m-0">
                    <span  id="textoInformacion" name="textoInformacion" class="label lbl-gray">
                        ${d.RelacionMotivo} 
                    </span>
                    </p>`;
    
                }
                

                TextoMostrar += `<p class="m-0"><span class="label lbl-green">${d.tipoDescuento}</span></p>`;
                return TextoMostrar;
                }
        },
        { 
            data: function(d) {
                
                var botonesMostrar = ``;
                botonesMostrar += `
                    <div class="d-flex justify-center">
                        <button href="#" value="${d.id_pago_i}" data-value="${d.nombreLote}" class="btn-data btn-blueMaderas consultarDetalleDelPago" title="VeER MÁS DETALLES" data-toggle="tooltip" data-placement="top">
                            <i class="fas fa-info">
                            </i>
                        </button></div>`;
            if(d.RelacionMotivo == 'Sin préstamo relacionado'){

            }else if(d.RelacionMotivo == 'NA'){
                if(d.evidenciaDocs != null ){
                    botonesMostrar += `
                            <button href="#" value="${d.id_pago_i}"  
                                id="preview" data-doc="${d.evidenciaDocs}"  
                                data-ruta="static/documentos/evidencia_prestamo_auto" 
                                class="btn-data btn-violetDeep " title="Ver Evidencia">
                                <i class="fas fa-folder-open">
                                </i>
                            </button>`;
                    }else{
                       botonesMostrar += ``; 
                    }
            }else if(d.RelacionMotivo != null && d.evidenciaDocs == null ) {
                botonesMostrar += `
                            <button href="#" value="${d.id_pago_i}"  
                                id="preview" data-doc="${d.RelacionMotivo}"  
                                data-ruta="UPLOADS/EvidenciaGenericas" 
                                class="btn-data lbl-melon " title="Ver Evidencia">
                                <i class="fas fa-folder-open">
                                </i>
                            </button>`;
                    
            }
                // botonesMostrar += `
                //     <button href="#" value="${d.id_prestamo}"  
                //         id="preview" data-doc="${d.evidencia}"  
                //         data-ruta="static/documentos/evidencia_prestamo_auto" 
                //         class="btn-data btn-violetDeep " title="Ver Evidencia">
                //         <i class="fas fa-folder-open">
                //         </i>
                //     </button>`;
                        
                return '<div class="d-flex justify-center">'+ botonesMostrar + '<div>';;
            }
        }],
        columnDefs: [{
			defaultContent: "",
			targets: "_all",
			searchable: true,
			orderable: false
		}],
        initComplete: function () {
            $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
        },
        ajax: {
            url: `${general_base_url}Comisiones/getHistorialDescuentosPorUsuario`,
            type: "POST",
            cache: false,
        }
    });
}

$(document).on('click', '.consultarDetalleDelPago', function(e) {
    $("#comments-list-asimilados").html('');
    $("#nameLote").html('');
    $('#spiner-loader').removeClass('hide');
    e.preventDefault();
    e.stopImmediatePropagation();
    id_pago = $(this).val();
    lote = $(this).attr("data-value");
    modalHistorial();
    $("#nameLote").append(`<p><h5>HISTORIAL DEL PAGO DE: <b>${lote}</b></h5></p>`);
    $.getJSON(`${general_base_url}Pagos/getComments/${id_pago}`).done( function( data ){
        $.each( data, function(i, v){
            $("#comments-list-asimilados").append(`<li><div class="container-fluid"><div class="row"><div class="col-md-6"><a><small>Usuario: </small><b>${v.nombre_usuario}</b></a><br></div><div class="float-end text-right"><a>${v.fecha_movimiento}</a></div><div class="col-md-12"><p class="m-0"><small>Comentario: </small><b>${v.comentario}</b></p></div><h6></h6></div></div></li>`);
            $('#spiner-loader').addClass('hide');
        });
    });
});

$(document).ready(function () {

    let titulosHistorialOOAM = [];
    $('#tablaHistorialOOAM thead tr:eq(0) th').each(function (i) {
        var titleooam = $(this).text();
        titulosHistorialOOAM.push(titleooam);
        $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${titleooam}" placeholder="${titleooam}"/>`);                       
        $('input', this).on('keyup change', function () {
            if ($('#tablaHistorialOOAM').DataTable().column(i).search() !== this.value) {
                $('#tablaHistorialOOAM').DataTable().column(i).search(this.value).draw();
            }
        });
        $('[data-toggle="tooltip"]').tooltip({trigger: "hover" });
    });
    consultarHistorialOOAM();
});

function consultarHistorialOOAM() {
    consultarHistorialOOAM = $("#tablaHistorialOOAM").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%', 
        scrollX:true,  
        ordering: false,             
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'HISTORIAL DESCUENTOS',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulosHistorialOOAM[columnIdx] + ' ';
                    }
                }
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: `${general_base_url}/static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        deferRender: true,
        columns: [{
            data: 'id_pago_i'
        },
        {
            data: 'id_comision'
        },
        {
            data: 'proyecto'
        },
        {
            data: 'precio_lote'
        },
        {
            data: 'comision_total'
        },
        {
            data: 'porcentaje_decimal'
        },
        {
            data: 'estatus'
        },
        {
            data: 'fecha_creacion'
        },
        {
            data: 'id_usuario'
        },
        {
            data: 'lote'
        },
        {
            data: 'pj_name'
        },
        {
            data: 'forma_pago'
        },
        { 
            data: function(d) {
                return `<div class="d-flex justify-center"><button href="#" value="${d.id_pago_i}" data-value="${d.nombreLote}" class="btn-data btn-blueMaderas consultarDetalleDelPago" title="VER MÁS DETALLES" data-toggle="tooltip" data-placement="top"><i class="fas fa-info"></i></button></div>`;
            }
        }],
        columnDefs: [{
			defaultContent: "",
			targets: "_all",
			searchable: true,
			orderable: false
		}],
        initComplete: function () {
            $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
        },
        ajax: {
            url: `${general_base_url}Ooam/getDatosHistorialOOAM`,
            type: "POST",
            cache: false,
        }
    });
}

$(document).on("click", "#preview", function () {
    var itself = $(this);
    var ruta = $(this).attr('data-ruta');
    Shadowbox.open({
        content: `<div>
                    <iframe style="overflow:hidden;width: 100%;height: 100%; position:absolute;z-index:999999!important;" 
                        src="${general_base_url}${itself.attr('data-ruta')}/${itself.attr('data-doc')}">
                    </iframe>
                </div>`,
        player: "html",
        title: `Visualizando archivo: evidencia `,
        width: 985,
        height: 660
    });
});


