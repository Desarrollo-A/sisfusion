<body class="">
<div class="wrapper ">
    <?php $this->load->view('template/sidebar'); ?>
    <!--Contenido de la página-->

    <style type="text/css">
        ::-webkit-input-placeholder { /* Chrome/Opera/Safari */
            color: white;
            opacity: 0.4;

        ::-moz-placeholder { /* Firefox 19+ */
            color: white;
            opacity: 0.4;
        }

        :-ms-input-placeholder { /* IE 10+ */
            color: white;
            opacity: 0.4;
        }

        :-moz-placeholder { /* Firefox 18- */
            color: white;
            opacity: 0.4;
        }

        .addNewRecord {
            background-image: linear-gradient(to bottom, #ffffff, #e0ffff 100%) !important;
        }


        }
    </style>




<!-- modal verifyNEODATA -->
<div class="modal fade modal-alertas" id="modal_NEODATA" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <form method="post" id="form_NEODATA">
                <div class="modal-body"></div>
                <div class="modal-footer"></div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade modal-alertas" id="modal_pagadas" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <form method="post" id="form_pagadas">
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>



<!-- modal -->
<!-- modal verifyNEODATA -->
<div class="modal fade modal-alertas" id="modal_NEODATA2" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <form method="post" id="form_NEODATA2">
                <div class="modal-body"></div>
                <div class="modal-footer"></div>
            </form>
        </div>
    </div>
</div>
<!-- modal -->

 

    <!--<div class="modal fade" id="myUpdateBanderaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="material-icons">clear</i>
                    </button>
                </div>
                <form id="my_updatebandera_form" name="my_updatebandera_form" method="post">
                    <div class="modal-body" style="text-align: center;">
                        <input type="hidden" name="id_pagoc" id="id_pagoc">
                        <h4 class="modal-title">¿Estás seguro que deseas actualizar este registro?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Aceptar</button>
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>-->


 
    <div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="card">
                                 <div class="card-content">
                                    <div class="material-datatables">
                                    <div class="tab-pane active" id="factura-1">
                                        <div class="content">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <h4 class="card-title" ><b>ADMINISTRADOR COMISIONES</b></h4>
                                                                    <!-- <p class="category">Comisiones solictadas por colaboradores para proceder a pago sin factura.</b></p> -->
                                                                    <p class="category"><i class="material-icons">info</i> Comisiones en todos los estatus.</p>

                                                                </div>

                                                            </div>
                                                            <div class="card-content">
                                                                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <div class="material-datatables">
                                                                    <div class="form-group">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-responsive table-bordered table-striped table-hover" id="tabla_ingresar_9" name="tabla_ingresar_9">
                                                                                 <thead>
                                                                                 <tr>
                                                                                    <th></th>
                                                                                    <th style="font-size: .9em;">ID LOTE</th>
                                                                                    <th style="font-size: .9em;">PROYECTO</th>
                                                                                    <th style="font-size: .9em;">CONDOMINIO</th>
                                                                                    <th style="font-size: .9em;">LOTE</th>
                                                                                    <th style="font-size: .9em;">CLIENTE</th>
                                                                                    <th style="font-size: .9em;">TIPO VENTA</th>
                                                                                    <th style="font-size: .9em;">MODALIDAD</th>
                                                                                    <th style="font-size: .9em;">EST. CONTRATACIÓN</th>
                                                                                   <!--  <th style="font-size: .9em;">ENT. VENTA</th>
                                                                                    <th style="font-size: .9em;">ÚLTIMA ACT.</th> -->
                                                                                    <th style="font-size: .9em;">ESTATUS</th>
                                                                                    <th style="font-size: .9em;">MÁS</th>
                                                                                </tr>

                                                                                
                                                                                </thead>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


<?php $this->load->view('template/footer_legend');?>
</div>
</div>

</div><!--main-panel close-->
</body>
<?php $this->load->view('template/footer'); ?>
<!--DATATABLE BUTTONS DATA EXPORT-->
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<script>

    /*$(document).on('click', '.update_bandera', function(e){
        id_pagoc = $(this).attr("data-idpagoc");
        $("#myUpdateBanderaModal").modal();
        $("#id_pagoc").val(id_pagoc);
    });*/

    /*$("#my_updatebandera_form").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'updateBandera',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                // Actions before send post
            },
            success: function(data) {
                if (data == 1) {
                    $('#myUpdateBanderaModal').modal("hide");
                    $("#id_pagoc").val("");
                    alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                    tabla_1.ajax.reload();
                } else {
                    alerts.showNotification("top", "right", "Oops, algo salió mal. Error al intentar actualizar.", "warning");
                }
            },
            error: function(){
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    });*/

    var url = "<?=base_url()?>";
    var url2 = "<?=base_url()?>index.php/";


    var getInfo1 = new Array(6);
    var getInfo3 = new Array(6);


    $("#tabla_ingresar_9").ready(function () {

        let titulos = [];
        $('#tabla_ingresar_9 thead tr:eq(0) th').each(function (i) {

            if (i != 0 && i != 12) {
                var title = $(this).text();
                titulos.push(title);

                $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500; text-align: center;"  placeholder="' + title + '"/>');
                $('input', this).on('keyup change', function () {
                    if (tabla_1.column(i).search() !== this.value) {
                        tabla_1
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            }
        });


        tabla_1 = $("#tabla_ingresar_9").DataTable({
            dom: 'Brtip',
            width: 'auto',
            "buttons": [
                {
                    extend: 'excelHtml5',
                    text: 'Excel',
                    className: 'btn btn-success',
                    titleAttr: 'Excel',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7],
                        format: {
                            header: function (d, columnIdx) {
                                if (columnIdx == 0) {
                                    return ' ' + d + ' ';
                                } else if (columnIdx == 10) {
                                    return ' ' + d + ' ';
                                } else if (columnIdx != 10 && columnIdx != 0) {
                                    if (columnIdx == 11) {
                                        return 'SEDE ';
                                    }
                                    if (columnIdx == 12) {
                                        return 'TIPO'
                                    } else {
                                        return ' ' + titulos[columnIdx - 1] + ' ';
                                    }
                                }
                            }
                        }
                    }
                }
            ],


            width: 'auto',
            "language": {url: "../static/spanishLoader.json"},

            "pageLength": 10,
            "bAutoWidth": false,
            "fixedColumns": true,
            "ordering": false,
            "columns":   [
{
"width": "3%",
"className": 'details-control',
"orderable": false,
"data" : null,
"defaultContent": '<i class="material-icons" style="color:#003D82;" title="Click para más detalles">play_circle_filled</i>'
},
{
    "width": "5%",
    "data": function( d ){
        var lblStats;
        lblStats ='<p style="font-size: .8em"><b>'+d.idLote+'</b></p>';
        return lblStats;
    }
},
{
"width": "8%",
"data": function( d ){
    return '<p style="font-size: .8em">'+d.nombreResidencial+'</p>';
}
},
{
"width": "8%",
"data": function( d ){
    return '<p style="font-size: .8em">'+(d.nombreCondominio).toUpperCase();+'</p>';
}
},
{
"width": "11%",
"data": function( d ){
    return '<p style="font-size: .8em">'+d.nombreLote+'</p>';

}
}, 
{
"width": "11%",
"data": function( d ){
    return '<p style="font-size: .8em"><b>'+d.nombre_cliente+'</b></p>';

}
}, 
{
"width": "8%",
"data": function( d ){
 
    var lblType;
            if(d.tipo_venta==1) {
                lblType ='<span class="label label-danger">Venta Particular</span>';
            }
            else if(d.tipo_venta==2) {
                lblType ='<span class="label label-success">Venta normal</span>';
            }
        return lblType;
    }
}, 

{
"width": "8%",
"data": function( d ){
    var lblStats;
            if(d.compartida==null) {
                lblStats ='<span class="label label-warning" style="background:#E5D141;">Individual</span>';
            }else {
                lblStats ='<span class="label label-warning">Compartida</span>';
            }
    return lblStats;
}
}, 


{
"width": "8%",
"data": function( d ){
    var lblStats;
    if(d.idStatusContratacion==15) {
        // lblStats ='';
        lblStats ='<span class="label label-success" style="background:#9E9CD5;">Contratado</span>';

    }
    else {
        lblStats ='<p><b>'+d.idStatusContratacion+'</b></p>';

        
    }
    return lblStats;
}
},

// {
// "width": "8%",
// "data": function( d ){
//     var lblStats;
 
//     if(d.totalNeto2==null) {
//             lblStats ='<span class="label label-danger">Sin precio lote</span>';
//     }
//     else {
        
//         switch(d.lugar_prospeccion){
//         case '6':
//             lblStats ='<span class="label" style="background:#B4A269;">MARKETING DIGÍTAL</span>';
//         break;
        
//         case '12':
//             lblStats ='<span class="label" style="background:#00548C;">CLUB MADERAS</span>';
//         break;
//         case '25':
//             lblStats ='<span class="label" style="background:#0860BA;">IGNACIO GREENHAM</span>';
//         break;

//         default:
//             lblStats ='';
//         break;
//     }
// }
// return lblStats;
 
// }
// },


// {
// "width": "8%",
// "data": function( d ){
//     var lblStats;

//     // LAST_NEODATA = new Date(d.fecha_modificacion);
//     // lblStats ='<span class="label label-warning">'+d.fecha_modificacion+'</span>';

//     if(d.fecha_modificacion <= '2021-01-01' || d.fecha_modificacion == null ) {
//          lblStats ='';
//             }else {
//                 lblStats ='<span class="label label-info">'+d.date_final+'</span>';
//             }
//     return lblStats;
// }
// }, 


{
"width": "8%",
"data": function( d ){
    var lblStats;

    switch(d.bandera){
        case '8':
            lblStats ='<span class="label" style="background:red;">RECISION</span>';
        break;
        
        case '7':
            lblStats ='<span class="label" style="background:green;">LIQUIDADA</span>';
        break;
        case '0':
        case '9':
            lblStats ='<span class="label" style="background:blue;">NUEVA</span>';
        break;

        default:
            lblStats ='<span class="label" style="background:orange;">ACTIVA</span>';
        break;
    }

    return lblStats;
}
}, 


 { 
"width": "14%",
"orderable": false,


"data": function( data ){
    var BtnStats;
    // let btnreubicacion= `<button class="btn btn-info btn-round btn-fab btn-fab-mini reubicar" title="Re-ubicación" data-nombre="${data.nombreLote}" value="${data.idLote}" style="color:#fff;background:#B5AD5E;background-color:#B5AD5E;"><i class="large material-icons" style="font-size:30px;left:40%;">edit_location</i></button>`;

    
    if(data.totalNeto2==null) {
        BtnStats = '';
    }else {
        if(data.compartida==null) {
            BtnStats = '<button class="btn btn-warning btn-round btn-fab btn-fab-mini marcar_pagada" title="Marcar como liquidada" value="' + data.idLote +'" color:#fff;"><i class="material-icons">how_to_reg</i></button><button href="#" value="'+data.idLote+'" data-estatus="'+data.idStatusContratacion+'"  data-value="'+data.registro_comision+'" data-code="'+data.cbbtton+'" ' +
             'class="btn btn-info btn-round btn-fab btn-fab-mini verify_neodata" title="Verificar en NEODATA">' +
             '<span class="material-icons">verified_user</span></button>&nbsp;&nbsp;';
            }else {
                BtnStats = '<button class="btn btn-warning btn-round btn-fab btn-fab-mini marcar_pagada" title="Marcar como liquidada" value="' + data.idLote +'" color:#fff;"><i class="material-icons">how_to_reg</i></button><button href="#" value="'+data.idLote+'" data-estatus="'+data.idStatusContratacion+'" data-value="'+data.registro_comision+'"  data-code="'+data.cbbtton+'" ' +
                'class="btn btn-success btn-round btn-fab btn-fab-mini verify_neodataCompartida" title="Verificar en NEODATA">' +
                '<span class="material-icons">verified_user</span></button>&nbsp;&nbsp;';  
            }
        }
        // return BtnStats+btnreubicacion;
        /*<button class="btn btn-danger btn-round btn-fab btn-fab-mini pausar" title="Rescisión de contrato" value="' + data.idLote +'" color:#fff;"><i class="material-icons">do_not_disturb</i></button>
       <button class="btn btn-danger btn-round btn-fab btn-fab-mini pausar" title="Rescisión de contrato" value="' + data.idLote +'" color:#fff;"><i class="material-icons">do_not_disturb</i></button>*/
        return BtnStats;
    }
}

],

            columnDefs: [
                {
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                },

            ],

            "ajax": {
                "url": '<?=base_url()?>index.php/Comisiones/getAllCommissions',
                "dataSrc": "",
                "type": "POST",
                cache: false,
                "data": function (d) {
                }
            },
            "order": [[1, 'asc']]

        });

        $('#tabla_ingresar_9 tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = tabla_1.row(tr);

            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
                $(this).parent().find('.animacion').removeClass("fa-caret-down").addClass("fa-caret-right");
            } else {
                var status;

                var fechaVenc;
                if (row.data().idStatusContratacion == 8 && row.data().idMovimiento == 38) {
                    status = 'Status 8 listo (Asistentes de Gerentes)';
                } else if (row.data().idStatusContratacion == 8 && row.data().idMovimiento == 65) {
                    status = 'Status 8 enviado a Revisión (Asistentes de Gerentes)';
                } else {
                    status = 'N/A';
                }

                if (row.data().idStatusContratacion == 8 && row.data().idMovimiento == 38 ||
                    row.data().idStatusContratacion == 8 && row.data().idMovimiento == 65) {
                    fechaVenc = row.data().fechaVenc;
                } else {
                    fechaVenc = 'N/A';
                }


                var informacion_adicional = '<table class="table text-justify">' +
                    '<tr><b>INFORMACIÓN COLABORADORES</b>:' +
                    '<td style="font-size: .8em"><strong>SUBDIRECTOR: </strong>' + row.data().subdirector + '</td>' +
                    '<td style="font-size: .8em"><strong>GERENTE: </strong>' + row.data().gerente + '</td>' +
                    '<td style="font-size: .8em"><strong>COORDINADOR: </strong>' + row.data().coordinador + '</td>' +
                    '<td style="font-size: .8em"><strong>ASESOR: </strong>' + row.data().asesor + '</td>' +
                    '</tr>' +
                    '</table>';


                row.child(informacion_adicional).show();
                tr.addClass('shown');
                $(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
            }


        });



        $("#tabla_ingresar_9 tbody").on("click", ".marcar_pagada", function(){
            var tr = $(this).closest('tr');
            var row = tabla_1.row( tr );
            idLote = $(this).val();
            // alert(idLote);


            // $("#modal_pagadas .modal-header").html("");
            $("#modal_pagadas .modal-body").html("");

            $("#modal_pagadas .modal-body").append('<h4 class="modal-title">¿Ya se pago completa la comision para el lote <b>'+row.data().nombreLote+'</b>?</h4>');
            $("#modal_pagadas .modal-body").append('<input type="hidden" name="ideLotep" id="ideLotep" value="'+idLote+'"><input type="hidden" name="estatusL" id="estatusL" value="7">');

            $("#modal_pagadas .modal-body").append('<br><div class="row"><div class="col-md-12"><center><input type="submit" class="btn btn-success" value="ACEPTAR"></center></div></div>');
        $("#modal_pagadas").modal();
        });

        /*$("#tabla_ingresar_9 tbody").on("click", ".pausar", function(){
            var tr = $(this).closest('tr');
            var row = tabla_1.row( tr );
            idLote = $(this).val();
            // alert(idLote);


            // $("#modal_pagadas .modal-header").html("");
            $("#modal_pagadas .modal-body").html("");

            $("#modal_pagadas .modal-body").append('<h4 class="modal-title">¿Estás seguro de mandar a recisión este lote? <b style="color:red;" >'+row.data().nombreLote+'</b>?</h4>');
            $("#modal_pagadas .modal-body").append('<input type="hidden" name="ideLotep" id="ideLotep" value="'+idLote+'"><input type="hidden" name="estatusL" id="estatusL" value="8">');

            $("#modal_pagadas .modal-body").append('<br><div class="row"><div class="col-md-12"><center><input type="submit" class="btn btn-success" value="ACEPTAR"></center></div></div>');
        $("#modal_pagadas").modal();
        });*/



        /*$("#tabla_ingresar_9 tbody").on("click", ".addPlanEnganche", function () {
            var tr = $(this).closest('tr');
            var row = tabla_1.row(tr);
            idLote = $(this).val();

            $("#modal_enganche .modal-body").html("");
            $("#modal_enganche .modal-body").append('<h4 class="modal-title">Plan de enganche: <b>' + row.data().nombreLote + '</b>?</h4>');
            $("#modal_enganche .modal-body").append('<input type="hidden" name="ideLotenganche" id="ideLotenganche" value="' + idLote + '">');
            $("#modal_enganche .modal-body").append('<br><div class="col-md-12"><select id="planSelect" name="planSelect" class="form-control planSelect ng-invalid ng-invalid-required" required data-live-search="true"></select></div>');

            $.post('getPlanesEnganche/' + idLote, function (data) {
                $("#planSelect").append($('<option disabled>').val("default").text("Seleccione una opción"))
                var len = data.length;
                for (var i = 0; i < len; i++) {
                    var id = data[i]['id_usuario'];
                    var name = data[i]['name_user'];
                    $("#planSelect").append($('<option>').val(id).attr('data-value', id).text(name));
                }
                if (len <= 0) {
                    $("#planSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                }
                $("#planSelect").val(0);
                $("#planSelect").selectpicker('refresh');
            }, 'json');

            $("#modal_enganche .modal-body").append('<div class="row"><div class="col-md-12"><br></div></div>');
            $("#modal_enganche .modal-body").append('<div class="row"><div class="col-md-3"></div><div class="col-md-3"><input type="submit" class="btn btn-primary" value="ACEPTAR"></div><div class="col-md-3"><input type="button" class="btn btn-danger" value="CANCELAR" onclick="closeModalEng()"></div><div class="col-md-3"></div></div>');
            $("#modal_enganche").modal();
        });*/


        $("#tabla_ingresar_9 tbody").on("click", ".verify_neodata", function () {
            var tr = $(this).closest('tr');
            var row = tabla_1.row(tr);
            idLote = $(this).val();

            registro_status = $(this).attr("data-value");

            $("#modal_NEODATA .modal-header").html("");
            $("#modal_NEODATA .modal-body").html("");
            $("#modal_NEODATA .modal-footer").html("");

            $.getJSON(url + "ComisionesNeo/getStatusNeodata/" + idLote).done(function (data) {

                if (data.length > 0) {

                    console.log("entra 1");
                    switch (data[0].Marca) {
                        case '0':
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>En espera de próximo abono en NEODATA de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                            break;
                        case '1':

                           if(registro_status==1){

                        $.getJSON( url + "Comisiones/getDatosAbonadoSuma11/"+idLote).done( function( data1 ){
                            
                            let total0 = parseFloat((data[0].Aplicado));
                            let total = 0;

                            if(total0 > 0){
                               total = total0;
                            }else{
                               total = 0; 
                            }

                             
                            // let total = 100000;
                            var counts=0;
                            // console.log(total);

                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Precio lote: $'+formatMoney(data1[0].totalNeto2)+'</b></h4></div></div>');

                            $("#modal_NEODATA .modal-header").append('<div class="row">'+
                            '<div class="col-md-4">Total pago: <b style="color:blue">'+formatMoney(data1[0].total_comision)+'</b></div>'+
                            '<div class="col-md-4">Total abonado: <b style="color:green">'+formatMoney(data1[0].abonado)+'</b></div>'+
                            '<div class="col-md-4">Total pendiente: <b style="color:orange">'+formatMoney((data1[0].total_comision)-(data1[0].abonado))+'</b></div></div>');

                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4>Aplicado neodata: <b>$'+formatMoney(data[0].Aplicado)+'</b></h4></div></div>');
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h3><i class="fa fa-info-circle" style="color:gray;"></i> Saldo diponible para <i>'+row.data().nombreLote+'</i>: <b>$'+formatMoney(total0-(data1[0].abonado))+'</b></h3></div></div><br>');
                       

                        $.getJSON( url + "Comisiones/getDatosAbonadoDispersion/"+idLote).done( function( data ){
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-3"><p style="font-zise:10px;"><b>USUARIOS</b></p></div><div class="col-md-1"><b>%</b></div><div class="col-md-2"><b>TOT. COMISIÓN</b></div><div class="col-md-2"><b><b>ABONADO</b></div><div class="col-md-2"><b>PENDIENTE</b></div><div class="col-md-2"><b>DISPONIBLE</b></div></div>');
                          //  console.log(total);
                          let contador=0;
                          console.log('gree:'+data.length);

                          for (let index = 0; index < data.length; index++) {
                                    const element = data[index].id_usuario;
                                    if(data[index].id_usuario == 4415){
                                        contador +=1;
                                    }
                                    
                                }

                            $.each( data, function( i, v){

                                /*if( v.rol == "Gerente" && v.id_usuario == 832){

                                }else{*/

                                

                                
     saldo =0;                           
if(v.rol_generado == 7 && v.id_usuario == 4415){
    saldo = (( (v.porcentaje_saldos/2) /100)*(total));
    contador +=1;
}else if(v.rol_generado == 7 && contador > 0){
    saldo = (( (v.porcentaje_saldos/2) /100)*(total));
}else if(v.rol_generado == 7 && contador == 0){
    saldo = ((v.porcentaje_saldos /100)*(total));
}
else if(v.rol_generado != 7){
    saldo = ((v.porcentaje_saldos /100)*(total));
}
 
                                if(v.abono_pagado>0){
                                    console.log("OPCION 1");


                                   evaluar = (v.comision_total-v.abono_pagado);
                                    if(evaluar<1){
                                        pending = 0;
                                        saldo = 0;
                                    }
                                    else{
                                        pending = evaluar;
                                    }
                                    
                                    resta_1 = saldo-v.abono_pagado;
                                    
                                    if(resta_1<1){
                                        // console.log("entra aqui 1");
                                        saldo = 0;
                                    }
                                    else if(resta_1 >= 1){
                                        // console.log("entra aqui 2");

                                        if(resta_1 > pending){
                                            saldo = pending;
                                        }
                                        else{
                                            saldo = saldo-v.abono_pagado;

                                        }
                                        
                                    }


                                    

                                }
                                else if(v.abono_pagado<=0){

                                    console.log("OPCION 2");

                                    pending = (v.comision_total);

                                if(saldo > pending){
                                    saldo = pending;
                                }
                                
                                if(pending < 1){
                                    saldo = 0;
                                }
                                }

                                  if(v.id_usuario == 832){
                                    saldo = (saldo*2);
                                }

                                $("#modal_NEODATA .modal-body").append('<div class="row">'
                                +'<div class="col-md-3"><input id="id_disparador" type="hidden" name="id_disparador" value="1"><input type="hidden" name="pago_neo" id="pago_neo" value="'+total.toFixed(3)+'"><input type="hidden" name="pending" id="pending" value="'+pending+'"><input type="hidden" name="idLote" id="idLote" value="'+idLote+'"><input id="rol" type="hidden" name="id_comision[]" value="'+v.id_comision+'"><input id="rol" type="hidden" name="rol[]" value="'+v.id_usuario+'"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="'+v.colaborador+'" style="font-size:12px;"><b><p style="font-size:12px;">'+v.rol+'</p></b></div>'

                                +'<div class="col-md-1"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="'+v.porcentaje_decimal+'%"></div>'
                                +'<div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="'+formatMoney(v.comision_total)+'"></div>'
                                
                                +'<div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="'+formatMoney(v.abono_pagado)+'"></div>'
                                +'<div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="'+formatMoney(pending)+'"></div>'
                                +'<div class="col-md-2"><input id="abono_nuevo'+counts+'" onkeyup="nuevo_abono('+counts+');" class="form-control ng-invalid ng-invalid-required abono_nuevo"  name="abono_nuevo[]" value="'+saldo+'" type="hidden">'
                                +'<input class="form-control ng-invalid ng-invalid-required decimals"  data-old="" id="inputEdit"  value="'+formatMoney(saldo)+'"></div>'+'</div>');
                           // }  
                                counts++
                            });
                        });
                        // $("#modal_NEODATA .modal-footer").append('<div class="row"><div class="col-md-3"></div><div class="col-md-3"><input type="submit" class="btn btn-success" name="disper_btn"  id="dispersar" value="Dispersar"></div><div class="col-md-3"><input type="button" class="btn btn-danger" data-dismiss="modal" value="CANCELAR"></div></div>');
                        if(total < 1 ){
                            $('#dispersar').prop('disabled', true);
                        }
                        else{
                            $('#dispersar').prop('disabled', false);
                        }
                    });
                } 

                            break;
                        case '2':
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No se encontró esta referencia de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                            break;
                        case '3':
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No tiene vivienda, si hay referencia de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                            break;
                        case '4':
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No hay pagos aplicados a esta referencia de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                            break;
                        case '5':
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Referencia duplicada de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                            break;
                        default:
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Sin localizar.</b></h4><br><h5>Revisar con sistemas: ' + row.data().nombreLote + '.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');

                            break;
                    }
                } else {
                    console.log("entra 2");
                    $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h3><b>No se encontró esta referencia en NEODATA de ' + row.data().nombreLote + '.</b></h3><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                }
            });

            $("#modal_NEODATA").modal();

        });


        //INICIO COMPARTIDA

        $("#tabla_ingresar_9 tbody").on("click", ".verify_neodataCompartida", function () {
            var tr = $(this).closest('tr');
            var row = tabla_1.row(tr);
            idLote = $(this).val();

            registro_status = $(this).attr("data-value");

            $("#modal_NEODATA2 .modal-header").html("");
            $("#modal_NEODATA2 .modal-body").html("");
            $("#modal_NEODATA2 .modal-footer").html("");

            // $.getJSON( url + "ComisionesNeo/getStatusNeodata/"+idLote).done( function( data ){
            $.getJSON(url + "ComisionesNeo/getStatusNeodata/" + idLote).done(function (data) {

                if (data.length > 0) {


                    // console.log("entra 1");
                    console.log(data[0].Marca);


                    switch (data[0].Marca) {
                        case '0':
                            $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>En espera de próximo abono en NEODATA de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                            break;
                        case '1':
                            console.log(registro_status);

                           if(registro_status==1){

$.getJSON( url + "Comisiones/getDatosAbonadoSuma11/"+idLote).done( function( data1 ){
    let total0 = parseFloat((data[0].Aplicado));
    let total = 0;
    
    if(total0 > 0){
        total = total0;
    }else{
        total = 0; 
    }

    // let total = 100000;
    var counts=0;
    // console.log(total);
    $("#modal_NEODATA2 .modal-header").append('<div class="row">'+
    '<div class="col-md-4">Total pago: <b style="color:blue">'+formatMoney(data1[0].total_comision)+'</b></div>'+
    '<div class="col-md-4">Total abonado: <b style="color:green">'+formatMoney(data1[0].abonado)+'</b></div>'+
    '<div class="col-md-4">Total pendiente: <b style="color:orange">'+formatMoney((data1[0].total_comision)-(data1[0].abonado))+'</b></div></div>');


    $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h4>Aplicado neodata: <b>$'+formatMoney(data[0].Aplicado)+'</b></h4></div></div>');
    $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h3><i class="fa fa-info-circle" style="color:gray;"></i> Saldo diponible para <i>'+row.data().nombreLote+'</i>: <b>$'+formatMoney(total0-data1[0].abonado)+'</b></h3></div></div><br>');


    $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Precio lote: $'+formatMoney(data1[0].totalNeto2)+'</b></h4></div></div><br>');


$.getJSON( url + "Comisiones/getDatosAbonadoDispersion/"+idLote).done( function( data ){
    $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-3"><p style="font-zise:10px;"><b>USUARIOS</b></p></div><div class="col-md-1"><b>%</b></div><div class="col-md-2"><b>TOT. COMISIÓN</b></div><div class="col-md-2"><b><b>ABONADO</b></div><div class="col-md-2"><b>PENDIENTE</b></div><div class="col-md-2"><b>DISPONIBLE</b></div></div>');

    $.each( data, function( i, v){
     //   console.log(data);
        pending = (v.comision_total-v.abono_pagado);
console.log(v.porcentaje_saldos);
       let nuevosaldo = 0;
       let nuevoabono=0;
       let evaluar =0;

        if( v.rol_generado == 7 && v.porcentaje_decimal == 1.5){
            nuevosaldo = parseFloat(v.porcentaje_saldos) /2;
        }else  if( v.rol_generado == 7 && v.porcentaje_decimal == 1){
            nuevosaldo = parseFloat(v.porcentaje_saldos) /3;   
        }else if( v.rol_generado == 9 && v.porcentaje_decimal == 1){
            nuevosaldo = parseFloat(v.porcentaje_saldos) ;   
        }else if( v.rol_generado == 9 && v.porcentaje_decimal == 0.5){
            nuevosaldo = parseFloat(v.porcentaje_saldos) /2;   
        }else if( v.rol_generado == 9 && v.porcentaje_decimal == 0.3333333333333333){
            nuevosaldo = parseFloat(v.porcentaje_saldos) /3;   
        }else if( v.rol_generado == 3 && v.porcentaje_decimal == 1){
            nuevosaldo = parseFloat(v.porcentaje_saldos);   
        }else if( v.rol_generado == 3 && v.porcentaje_decimal == 0.5){
            nuevosaldo = parseFloat(v.porcentaje_saldos) / 2;   
        }else if( v.rol_generado == 3 && v.porcentaje_decimal == 0.3333333333333333){
            nuevosaldo = parseFloat(v.porcentaje_saldos) /3;   
        }else if( v.rol_generado == 2 && v.porcentaje_decimal == 1){
            nuevosaldo = parseFloat(v.porcentaje_saldos) ;   
        }else if( v.rol_generado == 2 && v.porcentaje_decimal == 0.5){
            nuevosaldo = parseFloat(v.porcentaje_saldos) /2;   
        }else if( v.rol_generado == 2 && v.porcentaje_decimal == 0.3333333333333333){
            nuevosaldo = parseFloat(v.porcentaje_saldos) /3;   
        }else if( v.rol_generado == 1 && v.porcentaje_decimal == 1){
            nuevosaldo = parseFloat(v.porcentaje_saldos);   
        }else if( v.rol_generado == 38 && v.porcentaje_decimal == 1){
            nuevosaldo = parseFloat(v.porcentaje_saldos);   
        }else if( v.rol_generado == 42 && v.porcentaje_decimal == 1){
            nuevosaldo = parseFloat(v.porcentaje_saldos);   
        }else if( v.rol_generado == 45 && v.porcentaje_decimal == 1){
            nuevosaldo = parseFloat(v.porcentaje_saldos);   
        }

        //console.log(nuevosaldo);
        saldo = ((nuevosaldo/100)*(total));
        // alert(v.porcentaje_saldos);
        // console.log(v.porcentaje_saldos);
        // console.log(total);
        // console.log(saldo);
       /* nuevoabono = saldo - v.abono_pagado;

        if(nuevoabono < 0){

        }else{

        }*/

        console.log("saldo"+saldo);

        if(v.abono_pagado>0){
                                    console.log("OPCION 1");


                                   evaluar = (v.comision_total-v.abono_pagado);

                                    if(evaluar<1){
                                        pending = 0;
                                        saldo = 0;
                                    }
                                    else{
                                        pending = evaluar;
                                    }
                                    
                                    nuevoabono = saldo-v.abono_pagado;
                                    
                                    if(nuevoabono<1){
                                        console.log("entra aqui 1");
                                        saldo = 0;
                                    }
                                    else if(nuevoabono>=1){
                                        console.log("entra aqui 2");

                                        if(nuevoabono>pending){
                                            saldo = pending;
                                        }
                                        else{
                                            saldo = saldo-v.abono_pagado;

                                        }
                                        
                                    }


                                    

                                }
                                else if(v.abono_pagado<=0){

                                    console.log("OPCION 2");

                                    pending = (v.comision_total);

                                if(saldo > pending){
                                    saldo = pending;
                                }
                                
                                if(pending < 1){
                                    saldo = 0;
                                }
                                }
        /* */

        if(saldo > pending){
            saldo = pending;
        }
        
        if(pending < 1){
            saldo = 0;
            pending = 0;
        }




        $("#modal_NEODATA2 .modal-body").append('<div class="row">'
        +'<div class="col-md-3"><input id="id_disparador" type="hidden" name="id_disparador" value="1"><input type="hidden" name="pago_neo" id="pago_neo" value="'+total.toFixed(3)+'"><input type="hidden" name="pending" id="pending" value="'+pending+'"><input type="hidden" name="idLote" id="idLote" value="'+idLote+'"><input id="rol" type="hidden" name="id_comision[]" value="'+v.id_comision+'"><input id="rol" type="hidden" name="rol[]" value="'+v.id_usuario+'"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="'+v.colaborador+'" style="font-size:12px;"><b><p style="font-size:12px;">'+v.rol+'</p></b></div>'

        +'<div class="col-md-1"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="'+v.porcentaje_decimal+'%"></div>'
        +'<div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="'+formatMoney(v.comision_total)+'"></div>'
        +'<div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="'+formatMoney(v.abono_pagado)+'"></div>'
        +'<div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="'+formatMoney(pending)+'"></div>'
        +'<div class="col-md-2"><input id="abono_nuevo'+counts+'" onkeyup="nuevo_abono('+counts+');" class="form-control ng-invalid ng-invalid-required abono_nuevo"  name="abono_nuevo[]" value="'+saldo+'" type="hidden">'
        +'<input class="form-control ng-invalid ng-invalid-required" readonly="true" name="" value="'+formatMoney(saldo)+'"></div>'+'</div>');
        
        counts++
    });
    console.log('dfsfsfsdf'+counts);
});
// $("#modal_NEODATA2 .modal-footer").append('<div class="row"><div class="col-md-3"></div><div class="col-md-3"><input type="submit" class="btn btn-success" name="disper_btn" id="dispersar" value="Dispersar"></div><div class="col-md-3"><input type="button" class="btn btn-danger" data-dismiss="modal" value="CANCELAR"></div></div>');
if(total < 1 ){
    $('#dispersar').prop('disabled', true);
}
});

} 

//                   else if(registro_status==1)
//                   {
 

// }
                                       
                    break;
                        case '2':
                            $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No se encontró esta referencia de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                            break;
                        case '3':
                            $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No tiene vivienda, si hay referencia de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                            break;
                        case '4':
                            $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No hay pagos aplicados a esta referencia de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                            break;
                        case '5':
                            $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Referencia duplicada de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                            break;
                        default:
                            $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Sin localizar.</b></h4><br><h5>Revisar con sistemas: ' + row.data().nombreLote + '.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');

                            break;
                    }
                } else {
                    console.log("entra 2");
                    $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h3><b>No se encontró esta referencia en NEODATA de ' + row.data().nombreLote + '.</b></h3><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                }
            });

            $("#modal_NEODATA2").modal();

        });


    });


    $("#form_NEODATA").submit(function (e) {
        e.preventDefault();
    }).validate({
        submitHandler: function (form) {

            var data = new FormData($(form)[0]);


            $.ajax({
                url: url + 'Comisiones/InsertNeo',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function (data) {
                    if (data == 1) {
                        alert("Dispersión guardada con exito.");
                        tabla_1.ajax.reload();
                        $("#modal_NEODATA").modal('hide');

                    } else {
                        alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                    }
                }, error: function () {
                    alert("ERROR EN EL SISTEMA");
                }
            });


        }
    });




$("#form_pagadas").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        $('#loader').removeClass('hidden');
        var data = new FormData( $(form)[0] );
        $.ajax({
            url: url2 + "Comisiones/liquidar_comision",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data){
                    if(true){
                        $('#loader').addClass('hidden');
                        $("#modal_pagadas").modal('toggle');
                        tabla_1.ajax.reload();
                        alert("¡Se agregó con éxito!");


                    }else{
                        alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                        $('#loader').addClass('hidden');
                    }
                },error: function( ){
                    alert("ERROR EN EL SISTEMA");
                }
            });
    }
});



    /*$("#form_enganche").submit(function (e) {
        e.preventDefault();
    }).validate({
        submitHandler: function (form) {
            $('#loader').removeClass('hidden');
            var data = new FormData($(form)[0]);
            $.ajax({
                url: url2 + "Comisiones/enganche_comision",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function (data) {
                    if (true) {
                        $('#loader').addClass('hidden');
                        $("#modal_enganche").modal('toggle');
                        tabla_1.ajax.reload();
                        alert("¡Se agregó con éxito!");
                    } else {
                        alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                        $('#loader').addClass('hidden');
                    }
                }, error: function () {
                    alert("ERROR EN EL SISTEMA");
                }
            });
        }
    });*/


    $("#form_NEODATA2").submit(function (e) {
        e.preventDefault();
    }).validate({
        submitHandler: function (form) {

            var data = new FormData($(form)[0]);
            $.ajax({
                url: url + 'Comisiones/InsertNeoCompartida',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function (data) {
                    if (data == 1) {
                        tabla_1.ajax.reload();
                        alert("Dispersión guardada con exito.");
                        $("#modal_NEODATA2").modal('hide');
                    } else {
                        alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                    }
                }, error: function () {
                    alert("ERROR EN EL SISTEMA");
                }
            });


        }
    });

    /*jQuery(document).ready(function () {

        jQuery('#editReg').on('hidden.bs.modal', function (e) {
            jQuery(this).removeData('bs.modal');
            jQuery(this).find('#comentario').val('');
            jQuery(this).find('#totalNeto').val('');
            jQuery(this).find('#totalNeto2').val('');
        })

        jQuery('#rechReg').on('hidden.bs.modal', function (e) {
            jQuery(this).removeData('bs.modal');
            jQuery(this).find('#comentario3').val('');
        })

    })*/


    /*function SoloNumeros(evt) {
        if (window.event) {
            keynum = evt.keyCode;
        } else {
            keynum = evt.which;
        }

        if ((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6 || keynum == 46) {
            return true;
        } else {
            alerts.showNotification("top", "left", "Solo Numeros.", "danger");
            return false;
        }
    }*/

    /*function closeModalEng() {
        $("#modal_enganche").modal('toggle');
    }*/


    function formatMoney(n) {
        var c = isNaN(c = Math.abs(c)) ? 2 : c,
            d = d == undefined ? "." : d,
            t = t == undefined ? "," : t,
            s = n < 0 ? "-" : "",
            i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
            j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };


</script>

