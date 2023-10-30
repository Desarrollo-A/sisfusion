$(document).ready(function () {
 
    let meses = [
        {id:'0',mes:'TODOS'},
        {id:'01',mes:'Enero'},
        {id:'02',mes:'Febrero'},
        {id:'03',mes:'Marzo'},
        {id:'04',mes:'Abril'},
        {id:'05',mes:'Mayo'},
        {id:'06',mes:'Junio'},
        {id:'07',mes:'Julio'},
        {id:'08',mes:'Agosto'},
        {id:'09',mes:'Septiembre'},
        {id:'10',mes:'Octubre'},
        {id:'11',mes:'Noviembre'},
        {id:'12',mes:'Diciembre'}
      ];
      
  let anios = [2019,2020,2021,2022,2023,2024];
  
let datos = '';
let datosA = '';

for (let index = 0; index < meses.length; index++) {
    datos = datos + `<option value="${meses[index]['id']}">${meses[index]['mes']}</option>`;
    $('#mes').html(datos);
    $('#mes').selectpicker('refresh');
    }
 
for (let index = 0; index < anios.length; index++) {
    datosA = datosA + `<option value="${anios[index]}">${anios[index]}</option>`;
}
$('#anio').html(datosA);
$('#anio').selectpicker('refresh');

$('#anio').change(function () {
    for (let index = 0; index < meses.length; index++) {
    datos = datos + `<option value="${meses[index]['id']}">${meses[index]['mes']}</option>`;
    // $('#mes').html(datos);
    // $('#mes').selectpicker('refresh');
    }
});


    $('#mes').change(function() {
        anio = $('#anio').val();
        mes = $('#mes').val();
        if(anio == ''){
            anio=0;
        }else{
            loadTable(mes, anio);
        }
        $('#tabla-historial').removeClass('hide');
    });
    
    $('#anio').change(function() {
        mes = $('#mes').val();
        if(mes == ''){
            mes=0;
        }
        anio = $('#anio').val();
        if (anio == '' || anio == null || anio == undefined) {
            anio = 0;
        }
        loadTable(mes, anio);
        $('#tabla-historial').removeClass('hide');
    });
    

    $('body').tooltip({
        selector: '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])',
        trigger: 'hover',
        container: 'body'
    }).on('click mousedown mouseup', '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])', function () {
        $('[data-toggle="tooltip"], [title]:not([data-toggle="popover"])').tooltip('destroy');
    }); 
    
});

let titulos_intxt = [];
$('#tabla-historial thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos_intxt.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $( 'input', this ).on('keyup change', function () {
        if ($('#tabla-historial').DataTable().column(i).search() !== this.value ) {
            $('#tabla-historial').DataTable().column(i).search(this.value).draw();
        }
    });
});

function loadTable(mes, anio) {
    $('#tabla-historial').ready(function () {

        $('#tabla-historial').on('xhr.dt', function (e, settings, json, xhr) {
            var general = 0;

            $.each(json.data, function (i, v) {
                general += parseFloat(v.abono_neodata);
             });

            var totalFinal = formatMoney(general);
            document.getElementById("totalGeneral").textContent = totalFinal;

        });

        tablaGeneral = $('#tabla-historial').DataTable({
            dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons:[{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true" title="DESCARGAR ARCHIVO DE EXCEL"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'DESCARGAR ARCHIVO DE EXCEL',
            title: 'Historial Descuentos Universidad',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos_intxt[columnIdx] + ' ';
                    }
                }
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns:[
                {"data": function (d) {
                    return `<p style="font-size: 1em;">${d.id_pago_i}</p>`;
                }},
                {"data": function (d) {
                    return `<p style="font-size: 1em;">${d.nombreLote}</p>`;
                }},
                {"data": function (d) {
                    return `<p style="font-size: 1em;">${d.empresa}</p>`;
                }},
                {"data": function (d) {
                    return `<p style="font-size: 1em;">${d.id_usuario}</p>`;
                }},
                {"data": function (d) {
                    return `<p style="font-size: 1em;">${d.user_names}</p>`;
                }},
                {"data": function (d) {
                    return `<p style="font-size: 1em;">${d.puesto}</p>`;
                }},
                {"data": function (d) {
                    return `<p style="font-size: 1em;">${d.sede}</p>`;
                }},
                {"data": function (d) {
                    return `<p style="font-size: 1em">${formatMoney(d.abono_neodata)}</p>`;
                }},
                {"data": function (d) {
                    return `<p style="font-size: 1em;">${d.creado}</p>`;
                }},
                {"data": function (d) {
                    return '<p style="font-size: 1em">' + d.fecha_pago_intmex + '</p>';
                }},
                {"data": function (d) {
                    
                        base = `<button href="#" 
                        value=${d.id_pago_i} 
                        data-value=${d.nombreLote} 
                        data-nameuser=${d.user_names} 
                        data-puesto=${d.puesto} 
                        data-monto=${d.abono_neodata} 
                        data-code=${d.cbbtton} 
                        class="btn btn-round btn-fab btn-fab-mini btn-data btn-sky regresarpago"
                        data-toggle="tooltip"  data-placement="top" title="CANCELAR DESCUENTTO">
                        <i class="fas fa-sync-alt"></i></button>`;
 
                    return '<div class="d-flex justify-center">'+base+'</div>';
                }}],
            
                "ajax": {
                "url": `getDatosHistorialUM/`+anio + "/" + mes,
                "type": "GET",
                cache: false,
                "data": function (d) {}
            }
        });



        
    $("#tabla-historial tbody").on("click", ".regresarpago", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();

        id_pago = $(this).val();
        lote = $(this).attr("data-value");
        nameuser = $(this).attr("data-nameuser");
        puesto = $(this).attr("data-puesto");
        monto = $(this).attr("data-monto");
        $("#modalDevolucionUM .modal-body").append(`
        <div><h4 class="card-title" text-align: center"><b>Cancelar descuento</b></h4></div>
        <p>¿Está seguro que desea cancelar el descuento del <b>${puesto} ${nameuser}</b>?</p>
        <div class="form-group">
        <input type="hidden" name="id_pago" id="id_pago" value="${id_pago}">
        <input type="hidden" name="monto" id="monto" value="${monto}">
        <label>¿Cúal es el mótivo de la cancelación? (<span class="isRequired">*</span>)</label>
        <textarea class="text-modal" row="3" name="motivo" id="motivo" required></textarea>
        </div>`);

        $("#modalDevolucionUM .modal-body").append(`
        <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-simple " data-dismiss="modal" ">Cerrar</button>
        <button type="submit" class="btn btn-primary" >Aceptar</button>
        </div>
        
        `);

        $("#modalDevolucionUM").modal();
    });

}); //END DATATABLE



$("#form_baja").submit(function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function(form) {
        var data = new FormData($(form)[0]);
        $.ajax({
            type: 'POST',
            url: 'CancelarDescuento',
            data: data,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){},
            success: function(data) {
                if (data == 1) {
                    alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                    $('#tabla-historial').DataTable().ajax.reload(null, false);

                } else {
                    alerts.showNotification("top", "right", "Oops, algo salió mal. Error al intentar actualizar.", "warning");
                }
            },
            error: function(){
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    }
});

}
