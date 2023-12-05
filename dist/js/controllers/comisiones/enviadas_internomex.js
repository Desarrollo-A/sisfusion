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

$(document).ready(function() {
    $("#tabla_asimilados").prop("hidden", true);
    $.get('getFormasPago', function (data) {
        const formasPago = JSON.parse(data);
        formasPago.forEach(formaPago => {
            const id = formaPago.id_opcion;
            const name = formaPago.nombre;
            $("#formaPagoInter").append($('<option>').val(id).text(name.toUpperCase()));
        });
        $('#formaPagoInter').selectpicker('refresh');
    });

    $.post(`${general_base_url}Contratacion/lista_proyecto`, function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];
            $("#catalogoInter").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#catalogoInter").selectpicker('refresh');
    }, 'json');
});

$('#catalogoInter').change(function(ruta){
    residencial = $('#catalogoInter').val();
    $("#condominioInter").empty().selectpicker('refresh');
    $.ajax({
        url: `${general_base_url}Pagos/getCondominioDesc/${residencial}`,
        type: 'post',
        dataType: 'json',
        success:function(response){
            var len = response.length;
            for( var i = 0; i<len; i++){
                var id = response[i]['idCondominio'];
                var name = response[i]['nombre'];
                $("#condominioInter").append($('<option>').val(id).text(name));
            }
            $("#condominioInter").selectpicker('refresh');
        }
    });
});

$('#catalogoInter').change(function(ruta){
    const formaPago = $('#formaPagoInter').val() || 0;
    const proyecto = $('#catalogoInter').val();
    let condominio = $('#condominioInter').val();
    if(condominio === undefined || condominio == null || condominio === '') {
        condominio = 0;
    }
    getAssimilatedCommissions(proyecto, condominio, formaPago);
});

$('#condominioInter').change(function(ruta){
    const formaPago = $('#formaPagoInter').val() || 0;
    const proyecto = $('#catalogoInter').val();
    let condominio = $('#condominioInter').val();
    if(condominio === undefined || condominio == null || condominio === '') {
        condominio = 0;
    }
    getAssimilatedCommissions(proyecto, condominio, formaPago);
});

$('#formaPagoInter').change(function () {
    const formaPago = $(this).val() || 0;
    const proyecto = $('#catalogoInter').val();
    let condominio = $('#condominioInter').val();
    if(condominio === undefined || condominio == null || condominio === '') {
        condominio = 0;
    }
    getAssimilatedCommissions(proyecto, condominio, formaPago);
});

$('#tabla_asimilados thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
    $('input', this).on('keyup change', function() {
        if (tabla_asimilados2.column(i).search() !== this.value) {
            tabla_asimilados2.column(i).search(this.value).draw();
            var total = 0;
            var index = tabla_asimilados2.rows({ selected: true, search: 'applied' }).indexes();
            var data = tabla_asimilados2.rows(index).data();
            $.each(data, function(i, v) {
                total += parseFloat(v.impuesto);
            });
            document.getElementById("totpagarAsimilados").textContent = formatMoney(numberTwoDecimal(total));
        }
    });
});

function getAssimilatedCommissions(proyecto, condominio, formaPago) {
    $('#tabla_asimilados').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) { total += parseFloat(v.impuesto); });
        var to = formatMoney(numberTwoDecimal(total));
        document.getElementById("totpagarAsimilados").textContent =to;
    });

    $("#tabla_asimilados").prop("hidden", false);
    tabla_asimilados2 = $("#tabla_asimilados").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'Comisiones enviadas INTERNOMEX',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15],
                format: {
                    header: function (columnIdx){
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
            },
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
        ordering: false,
        columns: [{
            data: "id_pago_i" 
        },
        {   
            data: "proyecto" 
        },
        {   
            data: "condominio" 
        },
        { 
            data: "lote" 
        },
        { 
            data: "referencia" 
        },
        {
            data: function( d ){
                return  formatMoney(numberTwoDecimal(d.precio_lote));
            }
        },
        { 
            data: "empresa" 
        },
        {
            data: function( d ){
                return formatMoney(numberTwoDecimal(d.comision_total));
            }
        },
        {
            data: function( d ){
                return formatMoney(numberTwoDecimal(d.pago_neodata));
            }
        },
        {
            data: function( d ){
                if(d.id_usuario == 4394)
                    return '<p style="color: red;"><b>NA</b></p>';
                else {
                    if(d.forma_pago == 3)
                        return formatMoney(numberTwoDecimal(d.dcto));
                    else
                        return formatMoney(numberTwoDecimal(d.dcto));
                }
            }
        },
        {
            data: function( d ){
                return '<b>'+formatMoney(numberTwoDecimal(d.impuesto))+'</b>';
            }
        },
        {
            data: function( d ){
                if(d.lugar_prospeccion == 6){
                    return '<p class="m-0">COMISIÓN + MKTD <br><b> ('+d.porcentaje_decimal+'% de '+d.porcentaje_abono+'%)</b></p>';
                }
                else{
                    return '<p class="m-0">COMISIÓN <br><b> ('+d.porcentaje_decimal+'% de '+d.porcentaje_abono+'%)</b></p>';
                }
            
            }
        },
        {
            data: "usuario" 
        },
        { 
            data: "puesto" 
        },
        {
            data: function( d ){
                if(d.id_usuario == 4394){
                    return '<p style="color: red;"><b>NO APLICA</b></p>';
                }
                else{
                    return '<p class="m-0"><b>'+d.regimen+'</b></p>';
                }
            }
        },
        {
            data: function( d ){
                return'<p class="m-0">' +d.fecha_creacion.split('.')[0] +'</p>';
            }
        },
        {
            orderable: false,
            data: function( data ){
                let btns = '';
                const BTN_INFINTER = `<button href="#" value="${data.id_pago_i}" data-value="${data.lote}" data-code="${data.cbbtton}" class="btn-data btn-blueMaderas consultar_logs_asimilados" data-toggle="tooltip"  data-placement="top" title="HISTORIAL"><i class="fas fa-info"></i></button>`;
                btns += BTN_INFINTER;
                return `<div class="d-flex justify-center">${btns}</div>`;
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            searchable:false,
            className: 'dt-body-center',
            select: {
                style:    'os',
                selector: 'td:first-child'
            },
        }],
        ajax: {
            url: `${general_base_url}Pagos/getDatosEnviadasInternomex/`,
            type: "POST",
            cache: false,
            data:{
                proyecto: proyecto,
                condominio:condominio,
                formaPago:formaPago,
            }
        },
    });

    $("#tabla_asimilados tbody").on("click", ".consultar_logs_asimilados", function(e){
        $('#spiner-loader').removeClass('hide');
        $("#comments-list-asimilados").html('');
        $("#nameLote").html('');
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        lote = $(this).attr("data-value");

        changeSizeModal('modal-md');
        appendBodyModal(`<div class="modal-body">
                        <div role="tabpanel">
                            <div id="nameLote"></div>
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"><b>Cerrar</b></button>
                    </div>`);
        showModal();
        
        $("#nameLote").append('<p><h5 class="text-center">HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
        $.getJSON("getComments/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comments-list-asimilados").append(
                    '<li>'+
                        '<div class="container-fluid">'+
                            '<div class="row">'+
                                '<div class="col-md-6">'+
                                    '<a><b>' + v.comentario + '</b></a><br>'+
                                '</div>'+
                                '<div class="float-end text-right"><a>'+v.fecha_movimiento.split('.')[0]+'</a></div>'+
                                '<div class="col-md-12">'+
                                    '<p class="m-0">'+
                                        '<b> ' +v.nombre_usuario+ '</b>'+
                                    '</p>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</li>'
                );
            }); 
            $('#spiner-loader').addClass('hide');
        });
    });

    $('#tabla_asimilados').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
    });
}

