var totalLeon = 0, 
    totalQro = 0,
    totalSlp = 0,
    totalMerida = 0,
    totalCdmx = 0,
    totalCancun = 0,
    totaPen = 0;
var tabla_descuento_historial ;
var tr;
let titulos = [];



$(document).ready(function() {
    $("#tabla_descuento_historial").prop("hidden", true);
    $.post(`${general_base_url}Contratacion/lista_proyecto`, function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];
            $("#catalogo_descuento").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#catalogo_descuento").selectpicker('refresh');
    }, 'json');
});

$('#catalogo_descuento').change(function(ruta){
    residencial = $('#catalogo_descuento').val();
    $("#condominio_descuento").empty().selectpicker('refresh');
    $.ajax({
        url: `${general_base_url}Asesor/getCondominioDesc/${residencial}`,
        type: 'post',
        dataType: 'json',
        success:function(response){
            var len = response.length;
            for( var i = 0; i<len; i++){
                var id = response[i]['idCondominio'];
                var name = response[i]['nombre'];
                $("#condominio_descuento").append($('<option>').val(id).text(name));
            }
            $("#condominio_descuento").selectpicker('refresh');
        }
    });
});

$('#catalogo_descuento').change(function(ruta){
    proyecto = $('#catalogo_descuento').val();
    condominio = $('#condominio_descuento').val();
    if(condominio == '' || condominio == null || condominio == undefined)
        condominio = 0;
    getDescuentos(proyecto, condominio);
});

$('#condominio_descuento').change(function(ruta){
    proyecto = $('#catalogo_descuento').val();
    condominio = $('#condominio_descuento').val();
    if(condominio == '' || condominio == null || condominio == undefined)
        condominio = 0;
    getDescuentos(proyecto, condominio);
});

$('#tabla_descuento_historial thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();

    titulos.push(title);
    $(this).html('<input class="textoshead" type="text" placeholder="' + title + '" title="'+title+'" />');
    $('input', this).on('keyup change', function() {
        if (tabla_descuento_historial.column(i).search() !== this.value) {
            tabla_descuento_historial.column(i).search(this.value).draw();
            var total = 0;
            var index = tabla_descuento_historial.rows({ selected: true, search: 'applied' }).indexes();
            var data = tabla_descuento_historial.rows(index).data();

            $.each(data, function(i, v) {
                total += parseFloat(v.monto);
            });
            var to1 = formatMoney(total);
            document.getElementById("total_pagar_descuento").textContent = to1;
        }
    });
});

function getDescuentos(proyecto, condominio) {
    $('#tabla_descuento_historial').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.monto);
        });
        var to = formatMoney(total);
        document.getElementById("total_pagar_descuento").textContent = to;
    });

    $("#tabla_descuento_historial").prop("hidden", false);
    tabla_descuento_historial = $("#tabla_descuento_historial").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        bAutoWidth:true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'HISTORIAL_DESCUENTOS',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 6, 7,8],
                format: {
                    header:  function (d, columnIdx) {
                            return titulos[columnIdx];
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
        columns: [{data: "id_pago_i"},
        {data: "usuario"},
        {data: function( d ){
            return '<p class="m-0">$'+formatMoney(d.monto)+'</p>';}},
        {data: "nombreLote"},
        {data: "motivo"},
        { data: function( d ){          
            if(d.motivo != '' || d.motivo != null ){

                const letras = d.motivo.split(" ");
                
                if(letras.length <= 4)
            {

                return '<p class="m-0">'+d.motivo+'</p>';
            }else{
                letras[2] = undefined ? letras[2] = '' : letras[2];
                letras[3] = undefined ? letras[3] = '' : letras[3];
                return `    
                <div class="muestratexto${d.id_pago_i}" id="muestratexto${d.id_pago_i}">
                    <p class="m-0">${letras[0]} ${letras[1]} ${letras[2]} ${letras[3]}....</p> 
                    <a href='#' data-toggle="collapse" data-target="#collapseOne${d.id_pago_i}" 
                        onclick="esconder(${d.id_pago_i})" aria-expanded="true" aria-controls="collapseOne${d.id_pago_i}">
                        <span class="lbl-blueMaderas">Ver más</span> 
                        
                    </a>
                </div>
                <div id="collapseOne${d.id_pago_i}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        ${d.motivo}</p> 
                        <a href='#'  data-toggle="collapse" data-target="#collapseOne${d.id_pago_i}" 
                            onclick="mostrar(${d.id_pago_i})" aria-expanded="true" aria-controls="collapseOne${d.id_pago_i}">
                            <span class="lbl-blueMaderas">Ver menos</span> 
                        </a>
                    </div>
                </div>`;
                    }
                }else{
                    return '<p class="m-0">No definido</p>';
                }
            }
        },
        { 
            data: function( d ){
                if(d.estatus == 11 || d.estatus == '11' || d.estatus == 17 || d.estatus == '17')
                    return `<span class="label lbl-orange">Aplicado</span>`;
                else if(d.estatus == 16 || d.estatus == '16')
                    return `<span class="label lbl-blueMaderas">Descuento pago solicitado</span>`;
                else
                    return `<span class="label lbl-gray">Inactivo</span>`;
            }
        },
        {data: "modificado_por"},
        {data: "fecha_abono"},
        {
            orderable: false,
            data: function( data ){
                var BtnStats;
                BtnStats = '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.id_pago_i+'" data-code="'+data.cbbtton+'" ' + 'class="btn-data btn-blueMaderas consultar_logs_asimilados" title="Detalles">' +'<i class="fas fa-info"></i></button>';
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
        columnDefs: [{
            targets: [4], visible: false,
            searchable:true,
            }],
        ajax: {
            url: `${general_base_url}Comisiones/getHistorialDescuentos/${proyecto}/${condominio}`,
            type: "POST",
            cache: false,
            data: function( d ){}
        },
    });

    $('#tabla_descuento_historial').on('click', 'input', function() {
        tr = $(this).closest('tr');
        var row = tabla_descuento_historial.row(tr).data();

        if (row.pa == 0) {
            row.pa = row.monto;
            totaPen += parseFloat(row.pa);
            tr.children().eq(1).children('input[type="checkbox"]').prop("checked", true);
        } else {
            totaPen -= parseFloat(row.pa);
            row.pa = 0;
        }
        $("#totpagarPen").html(formatMoney(totaPen));
    });

    $("#tabla_descuento_historial tbody").on("click", ".consultar_logs_asimilados", function(e){
        $('#spiner-loader').removeClass('hide');
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        lote = $(this).attr("data-value");
        $("#seeInformationModalDescuentos").modal();
        $("#nameLote").append('<p><h5">HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
        $.getJSON(general_base_url+"Comisiones/getComments/"+id_pago  ).done( function( data ){
            $.each( data, function(i, v){
                $("#comments-list-descuentos").append(`
                <li>
                    <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <a><b>${v.comentario.toUpperCase()}</b></a><br>
                        </div>
                        <div class="float-end text-right">
                            <a>${v.fecha_movimiento.split(".")[0]} </a>
                        </div>
                        <div class="col-md-12">
                            <p class="m-0"><small>Usuario: </small><b> ${v.nombre_usuario} </b></p>
                        </div>
                    </div>
                    </div>
                </li>`);
            });
        $('#spiner-loader').addClass('hide');
        });
    });
}

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
});

$(window).resize(function(){
    tabla_descuento_historial.columns.adjust();
});


function preview_info(archivo){
    $("#documento_preview .modal-dialog").html("");
    $("#documento_preview").css('z-index', 9999);
    archivo = `${general_base_url}dist/documentos/${archivo}`;
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



function esconder(id){
    // alert(1331)
    $('#muestratexto'+id).addClass('hide');
    // $('#muestratexto'+id).removeClass('hide');
    
}


function mostrar(id){
    // $('#muestratexto'+id).addClass('hide');
    $('#muestratexto'+id).removeClass('hide');
    
}

