var tr;
var totaPagoBonos = 0;


let titulosp = [];
    $('#tabla_plaza_1_casas thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        titulosp.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');

        if (i == 0){
            $(this).html('<input id="all" type="checkbox" style="width:20px; height:20px;" onchange="selectAllS(this)"/>');

        }else{
        $( 'input', this ).on('keyup change', function () {
            
            if (plaza_1.column(i).search() !== this.value ) {
                plaza_1.column(i).search(this.value).draw();
                var total = 0;
                var index = plaza_1.rows({ selected: true, search: 'applied' }).indexes();
                var data = plaza_1.rows( index ).data();
                $.each(data, function(i, v){
                    total += parseFloat(v.abono_bono);
                });
                document.getElementById("myText_nuevas_casas").textContent = formatMoney(numberTwoDecimal(total));

            }
        });
    }
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

$("#tabla_plaza_1_casas").ready( function(){
    let c=0;
    $('#tabla_plaza_1_casas').on('xhr.dt', function ( e, settings, json, xhr ) {
        var total = 0;
        $.each(json.data, function(i, v){
            total += parseFloat(v.abono_bono);
        });
        var to = formatMoney(numberTwoDecimal(total));
        document.getElementById("myText_nuevas_casas").textContent = to;
    });
    

    plaza_1 = $("#tabla_plaza_1_casas").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'CASAS_CONCENTRADO_PAGO_COMISIONES',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8],
                format: 
                {
                    header:  function (d, columnIdx) {
                        return ' ' + titulosp[columnIdx] + ' ';
                    }
                }
            },
        }, 
            {
                text: '<i class="fa fa-check"></i> ENVIAR A INTERNOMEX',
                action: function() {
                    if ($('input[name="idPagoBono[]"]:checked').length > 0) {
                        $('#spiner-loader').removeClass('hide');
                        var idcomision = $(plaza_1.$('input[name="idPagoBono[]"]:checked')).map(function() {
                            return this.value;
                        }).get();
                        var com2 = new FormData();
                        com2.append("idcomision", idcomision); 
                        $.ajax({
                            url : general_base_url + 'Pagos_casas/updateRevisionBonoaInternomex/',
                            data: com2,
                            cache: false,
                            contentType: false,
                            processData: false,
                            type: 'POST', 
                            success: function(data){
                                response = JSON.parse(data);
                                if(data == 1) {
                                    $('#spiner-loader').addClass('hide');
                                    $("#all").prop('checked', false);
                                    $("#autorizar_intmex").html(formatMoney(0));
                                    tota2 =0
                                    plaza_1.ajax.reload();
                                    var mensaje = "Comisiones de esquema <b>asimilados</b>, fueron enviadas a <b>INTERNOMEX</b> correctamente.";
                                    modalInformation(RESPUESTA_MODAL.SUCCESS, mensaje);
                                }
                                else {
                                    $('#spiner-loader').addClass('hide');
                                    modalInformation(RESPUESTA_MODAL.FAIL);
                                }
                            },
                            error: function( data ){
                                $('#spiner-loader').addClass('hide');
                                modalInformation(RESPUESTA_MODAL.FAIL);
                            }
                        });
                    }else{
                        alerts.showNotification("top", "right", "Selecciona una comisión.", "warning");
                    }
                },
                attr: {
                    class: 'btn btn-azure',
                    style: 'position: relative;',
                }
        }],
        
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url + "static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
        }, 
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+d.id_usuario+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.colaborador+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.sede+'</p>';
            }
        },
        {
            "data": function( d ){
                if(d.empresa == null || d.empresa == "")
                    return '<p class="m-0">SIN ESPECIFICAR</p>';
                else
                    return '<p class="m-0">'+d.empresa+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+d.valimpuesto+'%</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(numberTwoDecimal(d.abono_bono))+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(numberTwoDecimal(d.descuento))+'</p>';
                // verificar que dato pasara en esta linea
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+formatMoney(numberTwoDecimal(d.impuesto))+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.forma_pago+'</p>';
            }
        },{
            "orderable": false,
            "data": function( data ){
                let btns = '';

                const BTN_DETASI = `<button href="#" value="${data.id_pago_bono}" data-value='"${data.lote}"' data-code="${data.cbbtton}" class="btn-data btn-blueMaderas consultar_logs_Bono" data-toggle="tooltip"  title="Detalles"><i class="fas fa-info"></i></button>`;
                const BTN_PAUASI = `<button href="#" value="${data.id_pago_bono}" data-value="${data.id_pago_bono}" data-code="${data.cbbtton}" class="btn-data btn-orangeYellow cambiar_estatus" data-toggle="tooltip" title="Pausar solicitud"> <i class="fas fa-pause"></i></button>`;
                const BTN_ACTASI = `<button href="#" value="${data.id_pago_bono}" data-value="${data.id_pago_bono}" data-code="${data.cbbtton}" class="btn-data btn-green regresar_estatus" data-toggle="tooltip" title="Activar solicitud"><i class="fas fa-play"></i></button>`

                if(data.estatus == 4){
                    btns += BTN_DETASI;
                    btns += BTN_PAUASI;
                }
                else{
                    btns += BTN_DETASI;
                    btns += BTN_ACTASI;
                }
                return `<div class="d-flex justify-center">${btns}</div>`;
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets:   0,
            searchable:false,
            className: 'dt-body-center',
            render: function (d, type, full, meta){
                if(full.estatus == 4){
                            return '<input type="checkbox" name="idPagoBono[]" class="checkPagosIndividual" style="width:20px;height:20px;"  value="' + full.id_pago_bono + '">';
                   
                }else{
                    return '';
                }
            },
        }],
        ajax: {
            url: general_base_url + "Pagos_casas/getDatosRevisionBonos",
            type: "POST",
            cache: false,
            data: function( d ){}
        },
    });

    $('#tabla_plaza_1_casas').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
    });
    
    $("#tabla_plaza_1_casas tbody").on("click", ".consultar_logs_Bono", function(e){
        $('#spiner-loader').removeClass('hide');
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        lote = $(this).attr("data-value");
        $("#seeInformationModal_casas").modal();
        $("#nameLote_casas").append('<p><h5>HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
        $.getJSON(general_base_url+"Pagos_casas/getCommentsBono/"+id_pago).done( function( data ){

            $.each( data, function(i, v){
                $("#comments-list_casas").append('<li><div style="margin-right: 10px; class="container-fluid"><div class="row"><div class="col-md-6"><a><b>' + v.comentario + '</b></a><br></div><div class="float-end text-right"><a>'+v.fecha_movimiento.split('.')[0]+'</a></div><div class="col-md-12"><p class="m-0"><small>Modificado por: </small><b> ' +v.nombre_usuario+ '</b></p></div><h6></h6></div></div></li>');
            });
            $('#spiner-loader').addClass('hide');
        });
    });

    $("#tabla_plaza_1_casas tbody").on("click", ".cambiar_estatus", function(){
        var tr = $(this).closest('tr');
        var row = plaza_1.row( tr );
        id_pago_bono = $(this).val();

        $("#modalPausarBono .modal-body").html("");
        $("#modalPausarBono .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Está seguro de pausar la comisión de <b>'+row.data().lote+'</b> para<b>: </b> <i>'+row.data().colaborador+'</i>?</p></div></div>');
        $("#modalPausarBono .modal-body").append('<div class="row"><div class="col-lg-12"><input type="hidden" name="value_pago" value="1"><input type="hidden" name="estatus" value="6"><input type="text" class="text-modal observaciones" name="observaciones" rows="3" required placeholder="Describe mótivo por el cual se va activar nuevamente la solicitud"></input></div></div>');
        $("#modalPausarBono .modal-body").append('<input type="hidden" name="id_pago" value="'+row.data().id_pago_bono+'">');
        $("#modalPausarBono .modal-body").append(`<div class="row"><div class="col-md-6"></div><div class="d-flex justify-end"><button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">CANCELAR</button><button type="submit" class="btn btn-primary" value="PAUSAR">PAUSAR</button></div></div>`);
        $("#modalPausarBono").modal();
    });

    $("#tabla_plaza_1_casas tbody").on("click", ".regresar_estatus", function(){
        var tr = $(this).closest('tr');
        var row = plaza_1.row( tr );
        id_pago_bono = $(this).val();

        $("#modalPausarBono .modal-body").html("");
        $("#modalPausarBono .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Está seguro de activar la comisión de <b>'+row.data().lote+'</b> para<b>: </b> <i>'+row.data().colaborador+'</i>?</p></div></div>');
        $("#modalPausarBono .modal-body").append('<div class="row"><div class="col-lg-12"><input type="hidden" name="value_pago" value="2"><input type="hidden" name="estatus" value="4"><input type="text" class="text-modal observaciones"  rows="3" name="observaciones" required placeholder="Describe mótivo por el cual se va activar nuevamente la solicitud"></input></div></div>');
        $("#modalPausarBono .modal-body").append(`<div class="d-flex justify-end"><input type="hidden" name="id_pago" value="'+row.data().id_pago_bono+'"><button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">CANCELAR</button><button type="submit" class="btn btn-primary" value="ACTIVAR">ACTIVAR</button></div>`);        
        $("#modalPausarBono").modal();
    });

});



$("#formPausarBono").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        $('#spiner-loader').removeClass('hide');
        var data = new FormData($(form)[0]);
        data.append("id_pago_bono", id_pago_bono);
        $.ajax({
            url: general_base_url + "Pagos_casas/despausar_solicitud_Bono_casas",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST',
            success: function(data){
                if( data[0] ){
                    $("#modalPausarBono").modal('toggle' );
                    alerts.showNotification("top", "right", "Se aplicó el cambio exitosamente", "success");
                    setTimeout(function() {
                        plaza_1.ajax.reload();
                        $('#spiner-loader').addClass('hide');

                    }, 3000);
                }else{
                    alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");
                    $('#spiner-loader').addClass('hide');

                }
            },error: function( ){
                $('#spiner-loader').addClass('hide');

                alert("ERROR EN EL SISTEMA");

            }
        });
    }
});


function cleanComments_casas() {
    var myCommentsList = document.getElementById('comments-list_casas');
    var myCommentsLote = document.getElementById('nameLote_casas');
    myCommentsList.innerHTML = '';
    myCommentsLote.innerHTML = '';
}

$(document).on("click", ".checkPagosIndividual", function() {
    tota2 = 0;
    plaza_1.$('input[type="checkbox"]').each(function () {
        let totalChecados = plaza_1.$('input[type="checkbox"]:checked') ;
        let totalCheckbox = plaza_1.$('input[type="checkbox"]');
        if(this.checked){
            tr = this.closest('tr');
            row = plaza_1.row(tr).data();
            tota2 += parseFloat(row.impuesto); 
        }
        if( totalChecados.length == totalCheckbox.length )
            $("#all").prop("checked", true);
        else 
            $("#all").prop("checked", false);
    });
    $("#autorizar_intmex").html(formatMoney(numberTwoDecimal(tota2)));
});

function selectAllS(e) {
    tota2 = 0;
    if(e.checked == true){
        $(plaza_1.$('input[type="checkbox"]')).each(function (i, v) {
            tr = this.closest('tr');
            row = plaza_1.row(tr).data();
             tota2 += parseFloat(row.impuesto);
            if(v.checked == false){
                $(v).prop("checked", true);
            }
        }); 
        $("#autorizar_intmex").html(formatMoney(numberTwoDecimal(tota2)));
    }
    if(e.checked == false){
        $(plaza_1.$('input[type="checkbox"]')).each(function (i, v) {
            if(v.checked == true){
                $(v).prop("checked", false);
            }
        }); 
        $("#autorizar_intmex").html(formatMoney(0));
    }
}

