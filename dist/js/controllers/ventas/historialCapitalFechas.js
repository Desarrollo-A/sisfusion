
$('#mes').change(function() {
    anio = $('#anio').val();
    mes = $('#mes').val();
    if(anio == ''){
        anio=0;
    }else{
        getAssimilatedCommissions(mes, anio);
    }
    $('#tabla_historialGral').removeClass('hide');
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
    getAssimilatedCommissions(mes, anio);
    $('#tabla_historialGral').removeClass('hide');
});

//INICIO TABLA QUERETARO********************************************
var tr;
var tabla_historialGral2 ;
var totaPen = 0;
let rol  = "<?=$this->session->userdata('id_rol')?>";
//INICIO TABLA QUERETARO***************************************
let titulos = [];

$('#tabla_historialGral thead tr:eq(0) th').each( function (i) {
    if(i != 10){
        var title = $(this).text();
        titulos.push(title);
        $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);                       
        $('input', this).on('keyup change', function() {
            if (tabla_historialGral2.column(i).search() !== this.value) {
                tabla_historialGral2.column(i).search(this.value).draw();
                var total = 0;
                var index = tabla_historialGral2.rows({
                    selected: true,
                    search: 'applied'
                }).indexes();
                var data = tabla_historialGral2.rows(index).data();
                $.each(data, function(i, v) {
                    total += parseFloat(v.abono_neodata);
                });
                var to1 = formatMoney(total);
                document.getElementById("myText_desU").value = to1;
            }
        });
    }  
});

function getAssimilatedCommissions(mes, anio) {
    $('#tabla_historialGral').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.abono_neodata);
        });
        var to = formatMoney(total);
        document.getElementById("myText_desU").textContent = '$' + to;
    });

    $("#tabla_historialGral").prop("hidden", false);
    tabla_historialGral2 = $("#tabla_historialGral").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX : true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'DESCUENTOS UNIVERSIDAD',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: "../static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            data: function( d ){
                var lblStats;
                lblStats ='<p class="m-0">'+d.id_pago_i+'</p>';
                return lblStats;
            }
        },
        {
            data: function( d ){
                return '<p class="m-0">'+d.nombreLote+'</p>';
            }
        },
        {
            data: function( d ){
                return '<p class="m-0">'+d.empresa+'</p>';
            }
        },
        {
            data: function( d ){
                return '<p class="m-0">'+d.id_usuario+'</p>';
            }
        },
        {
            data: function( d ){
                return '<p class="m-0">'+d.user_names+'</p>';
            }
        },
        {
            data: function( d ){
                return '<p class="m-0">'+d.puesto+'</p>';
            }
        },
        {
            data: function( d ){
                return '<p class="m-0">'+d.sede+'</p>';
            }
        },
        {
            data: function( d ){
                return '<p class="m-0"><b>$'+formatMoney(d.abono_neodata)+'</b></p>';
            }
        }, 
        {
            data: function( d ){
                var etiqueta;
                etiqueta = '<p class="m-0">'+d.creado+'</p>';
                return etiqueta;
            }
        },
        {
            data: function( d ){
                var etiqueta;
                etiqueta = '<p class="m-0">'+d.fecha_pago_intmex+'</p>';
                return etiqueta;     
            }
        },
        {
            data: function( data ){
                var BtnStats = '';
                if(rol == 49){
                BtnStats = '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.nombreLote+'" data-nameuser="'+data.user_names+'" data-puesto="'+data.puesto+'" data-monto="'+data.abono_neodata+'" data-code="'+data.cbbtton+'" class="btn-data btn-sky regresarpago" data-toggle="tooltip"  data-placement="top" title="CANCELAR DESCUENTTO"><i class="fas fa-sync-alt"></i></button>';
                }else{
                    BtnStats = '<p class="m-0">NO APLICA</p>'
                }
                return BtnStats;
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0,
            searchable: false,
            className: 'dt-body-center',
            select: {
                style: 'os',
                selector: 'td:first-child'
            },
        }],
        ajax: {
            url: general_base_url + "Comisiones/getDatosHistorialDU/" + anio + "/" + mes,
            type: "POST",
            cache: false,
            data: function(d) {}
        },
    });


    $("#tabla_historialGral tbody").on("click", ".regresarpago", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();

        id_pago = $(this).val();
        lote = $(this).attr("data-value");
        nameuser = $(this).attr("data-nameuser");
        puesto = $(this).attr("data-puesto");
        monto = $(this).attr("data-monto");
        $("#seeInformationModalAsimilados .modal-body").append(`
        <div style="background-color: crimson;" ><h4 class="card-title" style ="color: white; text-align: center"><b>Cancelar descuento</b></h4></div>
        <p>¿Está seguro que desea cancelar el descuento del <b>${puesto} ${nameuser}</b>?</p>
        <div class="form-group">
        <input type="hidden" name="id_pago" id="id_pago" value="${id_pago}">
        <input type="hidden" name="monto" id="monto" value="${monto}">
        <label>¿Cúal es el motivo de la cancelación? (<span class="isRequired">*</span>)</label>
        <textarea class="text-modal" row="3" name="motivo" id="motivo" required></textarea>
        </div>`);

        $("#seeInformationModalAsimilados .modal-body").append(`
        <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-simple " data-dismiss="modal" onclick="cleanCommentsAsimilados()">Cerrar</button>
        <button type="submit" class="btn btn-primary" >Aceptar</button>
        </div>
        
        `);

        $("#seeInformationModalAsimilados").modal();
    });


}

//FIN TABLA  ****************************************************************************************

$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
});

$(window).resize(function() {
    tabla_historialGral2.columns.adjust();
});

function formatMoney(n) {
    var c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

function cleanCommentsAsimilados() {
    $('#seeInformationModalAsimilados').modal('hide');
    var cancelacion = document.getElementsByClassName('cancelacion');
    $('.cancelacion').html('');
    cancelacion.innerHTML = '';
}

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
                    cleanCommentsAsimilados();
                    alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                    tabla_historialGral2.ajax.reload();
                } else {
                    cleanCommentsAsimilados();
                    alerts.showNotification("top", "right", "Oops, algo salió mal. Error al intentar actualizar.", "warning");
                }
            },
            error: function(){
                cleanCommentsAsimilados();
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    }
});

$('#tabla_historialGral').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});