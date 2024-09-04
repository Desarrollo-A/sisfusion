const excluir_column = ['MÁS', ''];
let columnas_datatable = {};
$('#ano_historial').change(function(){


proyecto =  $('#catalogo_historial').val();

if(proyecto == ''){
    residencial = $('#ano_historial').val();
    param = $('#param').val();
    condominio = '';
    $("#catalogo_historial").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url+'Contratacion/lista_proyecto/',
        type: 'post',
        dataType: 'json',
        success:function(response){
            var len = response.length;
            for( var i = 0; i<len; i++){
                var id = response[i]['idResidencial'];
                var name = response[i]['descripcion'];
                $("#catalogo_historial").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#catalogo_historial").selectpicker('refresh');
        }
    });
}else{

    proyecto = $('#ano_historial').val();
    condominio = $('#catalogo_historial').val();
    $('#tabla_historialGral').removeClass('hide');
    
        if (condominio == '' || condominio == null || condominio == undefined) {
        condominio = 0;
    }

        if (tabla_historialGral2) {
        tabla_historialGral2.destroy();
    }
    getAssimilatedCommissions(proyecto, condominio);


}

    


});


$('#catalogo_historial').change(function(){

    var catalogoSeleccionado = $('#catalogo_historial').val() !== '';
    var tipoSeleccionado = $('#tipo_historial').val() !== '';

    if (catalogoSeleccionado && tipoSeleccionado) {
        proyecto = $('#ano_historial').val();
        condominio = $('#catalogo_historial').val();
    $('#tabla_historialGral').removeClass('hide');
    
        if (condominio == '' || condominio == null || condominio == undefined) {
        condominio = 0;
    }
    
        if (tabla_historialGral2) {
        tabla_historialGral2.destroy();
    }
    getAssimilatedCommissions(proyecto, condominio);

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

// function modalHistorial(){
//     changeSizeModal("modal-md");
//     appendBodyModal(`<div class="modal-header"></div>
//         <div class="modal-body">
//             <div role="tabpanel">
//                 <h6 id="nameLote"></h6>
//                 <div class="container-fluid" id="changelogTab">
//                     <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
//                         <ul class="timeline-3" id="comments-list-asimilados"></ul>
//                     </div>
//                 </div>
//             </div>
//         </div>
//         <div class="modal-footer">
//             <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"><b>Cerrar</b></button>
//         </div>`);
//     showModal();
// }

function getAssimilatedCommissions(proyecto, condominio){


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

    $("#tabla_historialGral").removeClass("hidden");
    tabla_historialGral2 = $("#tabla_historialGral").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%', 
        scrollX:true,               
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'HISTORIAL BONOS',
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
            "orderable": false,
            "data": function( d ){
                var lblStats;
                lblStats ='<p class="m-0"><b>'+d.id_pago_bono+'</b></p>'; 
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
                return '<p class="m-0"><b>'+formatMoney(d.dispersado)+'</b></p>'; 
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
                var etiqueta;
                var descuento = d.descuento_aplicado == 1 ? `<p class="m-0"><span class="label lbl-gray" style=""> DESCUENTO</span></p>` : ''; 
                    if(d.pago_neodata < 1){
                        etiqueta = '<p class="m-1">'+'<span class="label" style="background:'+d.color+'18; color:'+d.color+'">'+d.estatus_actual+'</span>'+'</p>'+'<p class="m-1">'+'<span class="label lbl-green">IMPORTACIÓN</span></p>';
                    }else{
                        etiqueta = '<p class="m-0"><span class="label" style="background:'+d.color+'18; color: '+d.color+'; ">'+d.estatus_actual+'</span></p>';
                    }

                return etiqueta + descuento;
            }
        }
        // ,
        // { 
        //     "orderable": false,
        //     "data": function( data ){
        //         var BtnStats = '';
        //         const BTN_DETASI = `<button href="#" value="${data.id_pago_bono}" data-value='"${data.nombreLote}"' data-code="${data.cbbtton}" class="btn-data btn-blueMaderas consultarDetalleDelPago" title="DETALLES" data-toggle="tooltip" data-placement="top"><i class="fas fa-info"></i></button>`;
                
        //          BtnStats += BTN_DETASI;
 
        //         return '<div class="d-flex justify-center">'+BtnStats+'</div>';
        //     }
        // }
    ],
    columnDefs: [{
        "orderable": false,
    }],
        
        ajax: {
            "url": general_base_url + "Casas_comisiones/historial_bono/" + proyecto + "/" + condominio,
            "type": "POST",
            cache: false,
            "data": function( d ){}
        }
    });

    $('#tabla_historialGral').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
    });
}


$('a[data-toggle="tooltip"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
});


function asignarValorColumnasDT(nombre_datatable) {
    if(!columnas_datatable[`${nombre_datatable}`]) {
        columnas_datatable[`${nombre_datatable}`] = {titulos_encabezados: [], num_encabezados: []};
    }
}

// $(document).on('click', '.consultarDetalleDelPago', function(e) {
//     $("#comments-list-asimilados").html('');
//     $("#nameLote").html('');
//     $('#spiner-loader').removeClass('hide');
//     e.preventDefault();
//     e.stopImmediatePropagation();
//     id_pago = $(this).val();
//     lote = $(this).attr("data-value");
//     modalHistorial();
//     $("#nameLote").append(`<p><h5>HISTORIAL DEL PAGO DE: <b>${lote}</b></h5></p>`);
//     $.getJSON(general_base_url+ 'Casas_comisiones/getComments/'+id_pago).done( function( data ){
//         $.each( data, function(i, v){
//             $("#comments-list-asimilados").append(`<li><div class="container-fluid"><div class="row"><div class="col-md-6"><a><small>Usuario: </small><b>${v.nombre_usuario}</b></a><br></div><div class="float-end text-right"><a>${v.fecha_movimiento}</a></div><div class="col-md-12"><p class="m-0"><small>Comentario: </small><b>${v.comentario}</b></p></div><h6></h6></div></div></li>`);
//             $('#spiner-loader').addClass('hide');
//         });
//     });
// });




