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


    <!-- modal  CONFIRMAR PAGO-->
    <div class="modal fade modal-alertas" id="modal_addPago" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-red">
                </div>
                <form method="post" id="form_addPago">
                    <div class="modal-body"></div>
                </form>
            </div>
        </div>
    </div>
    <!-- modal -->


        <div class="modal fade" id="seeInformationModalBaja" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="material-icons" onclick="cleanCommentsAsimilados()">clear</i>
                    </button>
                </div>
                <div class="modal-body">
                    <div role="tabpanel">
                        <ul class="nav nav-tabs" role="tablist" style="background: #949494;">
                            <!-- <h5 style="color: white;"><b>BITÁCORA DE CAMBIOS</b></h5> -->
                            <div id="nameLote"></div>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="changelogTab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-plain">
                                            <div class="card-content">
                                                <ul class="timeline timeline-simple" id="comments-list-asimilados"></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsAsimilados()"><b>Cerrar</b></button>
                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">

                        <div class="card-content">
                            <h3 class="card-title center-align">Comisiones Asesores Baja - <b>Historial</b></h3>
                            <div class="toolbar">
                            </div>
                            <div class="material-datatables">
                            <label style="color: #0a548b;">&nbsp;Saldo dispersado: $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text"  name="totpagar" id="totpagar"></label>

                                <div class="form-group">

                                <div class="row">
	                                                                            <div class="col-md-6 form-group text-left">
	                                                                                <label for="proyecto2">Proyecto</label>
	                                                                                <select name="proyecto2" id="proyecto2" class="selectpicker" data-style="btn btn-second"data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" required>
	                                                                                    <option value="0">Selecciona una opción</option>
	                                                                                </select>
	                                                                            </div>

	                                                                            <div class="col-md-6 form-group text-left">
	                                                                                <label for="condominio">Condominio</label>
	                                                                                <select name="condominio2" id="condominio2" class="selectpicker" data-style="btn btn-second"data-show-subtext="true" data-live-search="true"  title="Selecciona una opción" data-size="7" required>
	                                                                                    <option disabled selected>Selecciona una opción</option>
	                                                                                </select>
	                                                                            </div>
	                                                                        </div>
                                                                    
                                                                    </div>


                                    <div class="table-responsive">

                                        <table class="table table-responsive table-bordered table-striped table-hover"
                                               id="tabla_ingresar_9" name="tabla_ingresar_9" style="text-align:center;">

                                            <thead>
                                            <tr style="background:#003D82;">
                                                <th></th>
                                                <th style="font-size: .9em;">ID PAGO</th>
                                                <th style="font-size: .9em;">LOTE</th>
                                                <th style="font-size: .8em;">PRECIO LOTE</th>
                                                <th style="font-size: .8em;">TOTAL COM. ($)</th>
                                                <th style="font-size: .8em;">PAGO CLIENTE</th>
                                                <th style="font-size: .8em;">ABONO NEO.</th>
                                                <th style="font-size: .8em;">PAGADO</th>
                                                <th style="font-size: .8em;">PENDIENTE</th>
                                                <th style="font-size: .9em;">USUARIO</th>
                                                <th style="font-size: .9em;">PUESTO</th>
                                                <th style="font-size: .9em;">ESTATUS</th>
                                                <th style="font-size: .8em;"></th>
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



    <?php $this->load->view('template/footer_legend'); ?>
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

    function cleanCommentsAsimilados() {
        var myCommentsList = document.getElementById('comments-list-asimilados');
        var myCommentsLote = document.getElementById('nameLote');
        myCommentsList.innerHTML = '';
        myCommentsLote.innerHTML = '';
    }


    var url = "<?=base_url()?>";
    var url2 = "<?=base_url()?>index.php/";


    var getInfo1 = new Array(6);
    var getInfo3 = new Array(6);

    $(document).ready(function() {
    
        $.post(url + "Contratacion/lista_proyecto", function (data) {
            var len = data.length;
            for (var i = 0; i < len; i++) {
                var id = data[i]['idResidencial'];
                var name = data[i]['descripcion'];
                $("#proyecto2").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#proyecto2").selectpicker('refresh');
        }, 'json');
    });

    $('#proyecto2').change( function(){
        index_proyecto = $(this).val();
        index_condominio = 0
        $("#condominio2").html("");
        $(document).ready(function(){
            $.post(url + "Contratacion/lista_condominio/"+index_proyecto, function(data) {
                var len = data.length;
                $("#condominio2").append($('<option disabled selected>Selecciona una opción</option>'));

                for( var i = 0; i<len; i++)
                {
                    var id = data[i]['idCondominio'];
                    var name = data[i]['nombre'];
                    $("#condominio2").append($('<option>').val(id).text(name.toUpperCase()));
                }
                $("#condominio2").selectpicker('refresh');
            }, 'json');
        });
        fillCommissionTableWithoutPayment2(index_proyecto, 0);
        // SE MANDA LLAMAR FUNCTION QUE LLENA LA DATA TABLE DE COMISINONES SIN PAGO EN NEODATA
        /*if (userType != 2 && userType != 3 && userType != 13 && userType != 32 && userType != 17) { // SÓLO MANDA LA PETICIÓN SINO ES SUBDIRECTOR O GERENTE
            fillCommissionTableWithoutPayment2(index_proyecto, index_condominio);
        }*/
    });

    $('#condominio2').change( function(){
        index_proyecto = $('#proyecto2').val();
        index_condominio = $(this).val();
        // SE MANDA LLAMAR FUNCTION QUE LLENA LA DATA TABLE DE COMISINONES SIN PAGO EN NEODATA
        fillCommissionTableWithoutPayment2(index_proyecto, index_condominio);
    });


    let titulos = [];
        $('#tabla_ingresar_9 thead tr:eq(0) th').each(function (i) {

            if (i != 0 && i != 12) {
                var title = $(this).text();
                titulos.push(title);

                $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500"  placeholder="' + title + '"/>');
                $('input', this).on('keyup change', function () {
                    // if (tabla_1.column(i).search() !== this.value ) {
                    //  tabla_1
                    //  .column(i)
                    //  .search(this.value)
                    //  .draw();
                    // }

                    if (tabla_1.column(i).search() !== this.value) {
                        tabla_1
                            .column(i)
                            .search(this.value)
                            .draw();

                        var total = 0;
                        var index = tabla_1.rows({selected: true, search: 'applied'}).indexes();
                        var data = tabla_1.rows(index).data();

                        $.each(data, function (i, v) {
                            total += parseFloat(v.impuesto);
                        });
                        var to1 = formatMoney(total);
                        document.getElementById("myText_nuevas").value = formatMoney(total);
                    }


                });
            }
        });



function  fillCommissionTableWithoutPayment2(proyecto,condominio){
    $("#tabla_ingresar_9").ready(function () {

        

        $('#tabla_ingresar_9').on('xhr.dt', function(e, settings, json, xhr) {
            var total = 0;
            $.each(json.data, function(i, v) {
                total += parseFloat(v.pago_cliente);
            });
            var to = formatMoney(total);
            document.getElementById("totpagar").value = to;
        });

        tabla_1 = $('#tabla_ingresar_9').DataTable({
            dom: "Bfrtip",
            buttons: [

 
        {
           extend:    'excelHtml5',
           text:      'Excel',
           titleAttr: 'Excel',
           title: 'HISTORIAL_GENERAL_SISTEMA_COMISIONES',

          exportOptions: {
              columns: [1,2,3,4,5,6,7,8,9,10,11],
              format: {
                 header:  function (d, columnIdx) {
                     if(columnIdx == 0){
                        //  return ' '+d +' ';
                         return 'ID LOTE';
                        
                        // }else if(columnIdx == 1){
                        //     return 'ID LOTE';
                        }else if(columnIdx == 1){
                            return 'ID PAGO';
                        }else if(columnIdx == 2){
                            return 'NOMBRE LOTE';
                        }else if(columnIdx == 3){
                            return 'PRECIO LOTE ';
                        }else if(columnIdx == 4){
                            return 'TOTAL COMISIÓN';
                        }else if(columnIdx == 5){
                            return 'PAGO NEODATA';
                        }else if(columnIdx == 6){
                            return 'SALDO A PAGAR';
                        }else if(columnIdx == 7){
                            return 'PAGADO';
                        }else if(columnIdx == 8){
                            return 'PENDIENTE';
                        }else if(columnIdx == 9){
                            return 'COMISIONISTA';
                        }else if(columnIdx == 10){
                            return 'PUESTO';
                        }else if(columnIdx == 11){
                            return 'ESTATUS ACTUAL';
                        }
                        else if(columnIdx != 12 && columnIdx !=0){
                        //     if(columnIdx == 11){
                        //         return 'nose2'
                        //     }
                        //     else{
                                return ' '+titulos[columnIdx-1] +' ';
                        //     }
                        }
                    }
                }
            },

            attr: {
                    class: 'btn btn-success',
                 }
        },
 

        ],
            pagingType: "full_numbers",
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Todos"]
            ],
            language: {
                /*url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"*/
                url: "../../static/spanishLoader.json"
            },
            columnDefs: [{
                defaultContent: "",
                targets: "_all",
                searchable: true,
                orderable: false
            }],
            destroy: true,
            ordering: false,
            columns: [
                {
                    "width": "3%",
                    "className": 'details-control',
                    "orderable": false,
                    "data": null,
                    "defaultContent": '<i class="material-icons" style="color:#003D82;" title="Click para más detalles">play_circle_filled</i>'
                },
                {
                    "width": "5%",
                    "data": function (d) {
                        var lblStats;
                        lblStats = '<p style="font-size: .8em"><b>' + d.id_pago_i + '</b></p>';
                        return lblStats;
                    }
                },
                {
                    "width": "10%",
                    "data": function (d) {
                        if(d.registro_comision == 8){
                            return '<p style="font-size: .8em">' + d.nombreLote + '</p><span class="label" style="background:#D02804;">Rescisión de contrato</span>';
                        }else{
                            return '<p style="font-size: .8em">' + d.nombreLote + '</p>';
                        }
                        //return '<p style="font-size: .8em">' + d.nombreLote + '</p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function (d) {
                        return '<p style="font-size: .8em">$' + formatMoney(d.precio_lote) + '</p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function (d) {
                        return '<p style="font-size: .8em">$' + formatMoney(d.comision_total) + ' </p>';
                    }
                },

                {
                    "width": "8%",
                    "data": function (d) {
                        return '<p style="font-size: .8em">$' + formatMoney(d.pago_neodata) + '</p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function (d) {
                        return '<p style="font-size: .8em"><b>$' + formatMoney(d.pago_cliente) + '</b></p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function (d) {
                        return '<p style="font-size: .8em">$' + formatMoney(d.pagado) + '</p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function (d) {
                        if (d.restante == null || d.restante == '') {
                            return '<p style="font-size: .8em">$' + formatMoney(d.comision_total) + '</p>';
                        } else {
                            if(d.restante<=0){
                                return '<p style="font-size: .8em">$' + formatMoney(0) + '</p>';
                            }
                            else{
                                return '<p style="font-size: .8em">$' + formatMoney(d.restante) + '</p>';
                            }
                            
                        }
                    }
                },
                { 
                    "width": "9%",
                    "data": function (d) {
                        return '<p style="font-size: .8em">' + d.user_names + '<br></p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function (d) {
                        return '<p style="font-size: .8em"><b>' + d.puesto + '</b></p>';
                    }
                },
  


                {
    "width": "8%",
    "data": function( d ){
    // return '<p style="font-size: .8em">'+d.user_names+'<br><b>'+d.puesto+'</b></p>';


    // if(d.restante<=0 && d.restante!=null && d.restante!=''){
    //     return '<p style="font-size: .8em"><span class="label" style="background:#29CC59;">LIQUIDADO</span></p>';
    // }

    // else{

        if((d.id_estatus_actual == 11 || d.id_estatus_actual == 11) && d.descuento_aplicado == 1 ){
            return '<p style="font-size: .8em"><span class="label" style="background:#ED7D72;">DESCUENTO</span></p>';
        }
        else{
            
            switch(d.id_estatus_actual){
                        case '1':
                            case 2:
                            return '<p style="font-size: .8em"><span class="label" style="background:#29A2CC;">'+d.estatus_actual+'</span></p>';
                        break;

                        case '3':
                            case 3:
                            return '<p style="font-size: .8em"><span class="label" style="background:#CC6C29;">'+d.estatus_actual+'</span></p>';
                        break;

                        case '4':
                            case 4:
                            return '<p style="font-size: .8em"><span class="label" style="background:#9129CC;">'+d.estatus_actual+'</span></p>';
                        break;

                        case '5':
                            case 5:
                            return '<p style="font-size: .8em"><span class="label" style="background:#CC2976;">'+d.estatus_actual+'</span></p>';
                        break;

                        case '6':
                            case 6:
                            return '<p style="font-size: .8em"><span class="label" style="background:#81BFBE;">'+d.estatus_actual+'</span></p>';
                        break;

                        case '7':
                            case 7:
                            return '<p style="font-size: .8em"><span class="label" style="background:#28A255;">'+d.estatus_actual+'</span></p>';
                        break;

                        case '8':
                            case 8:
                            return '<p style="font-size: .8em"><span class="label" style="background:#4D7FA1;">'+d.estatus_actual+'</span></p>';
                        break;

                        case '9':
                            case 9:
                            return '<p style="font-size: .8em"><span class="label" style="background:#E86606;">'+d.estatus_actual+'</span></p>';
                        break;

                        case '10':
                            case 10:
                            return '<p style="font-size: .8em"><span class="label" style="background:#E89606;">'+d.estatus_actual+'</span></p>';
                        break;

                        case '11':
                        case 11:
                            case '12':
                            case 12:
                            return '<p style="font-size: .8em"><span class="label" style="background:#05A134;">'+d.estatus_actual+'</span></p>';
                        break;

                        default:
                        return '<p style="font-size: .8em"><span class="label" style="background:gray;">'+d.estatus_actual+'</span></p>';                        
                        break;

                    }
                }
                // }
}
},


                { 
    "width": "9%",
    "orderable": false,
    "data": function( data ){


        switch(data.id_estatus_actual){
                        // case '1':
                        // case 1:
                        //        return '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.nombreLote+'" data-code="'+data.cbbtton+'" ' +'class="btn btn-round btn-fab btn-fab-mini historial_logs_baja" style="background: #39A1C0;" title="Detalles">' +'<span class="material-icons">info</span></button>&nbsp;<button href="#" value="'+data.id_pago_i+'"  data-value2="'+data.user_names+'" data-value3="'+data.id_comision+'" data-value4="'+data.id_usuario+'" data-value="'+data.nombreLote+'" data-code="'+data.cbbtton+'" ' +'class="btn btn-round btn-fab btn-fab-mini add_pago" style="background: #447DD8;" title="Agregar pago">' +'<span class="material-icons">edit</span></button>&nbsp;';
                        // break;

                        case '11':
                        case 11:

                        return '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.nombreLote+'" data-code="'+data.cbbtton+'" ' +'class="btn btn-round btn-fab btn-fab-mini historial_logs_baja" style="background: #39A1C0;" title="Detalles">' +'<span class="material-icons">info</span></button>&nbsp;<button href="#" value="'+data.id_pago_i+'" data-value="'+data.nombreLote+'" data-value2="'+data.user_names+'" data-value3="'+data.id_comision+'"  data-value4="'+data.id_usuario+'"  data-code="'+data.cbbtton+'" ' +'class="btn btn-round btn-fab btn-fab-mini modificar_saldo" style="background: #F3A947;" title="Modificar saldo">' +'<span class="material-icons">edit</span></button>&nbsp;';
                        break;

                        default:
                        return '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.nombreLote+'" data-code="'+data.cbbtton+'" ' +'class="btn btn-round btn-fab btn-fab-mini historial_logs_baja" style="background: #39A1C0;" title="Detalles">' +'<span class="material-icons">info</span></button>&nbsp;';                        
                        break;

                    }
 

        }
    }

            ],
            "ajax": {
                "url": "<?=base_url()?>index.php/Comisiones/getDatosComisionesHistorialBaja/"+proyecto+"/"+condominio,
                "type": "POST",
                cache: false,
                "data": function (d) {
                }
            }
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
                var informacion_adicional = '<table class="table text-justify">' +
                    '<tr><b>INFORMACIÓN ADICIONAL</b>:' +
                    '<td style="font-size: .8em"><strong>PORCENTAJE A COMISIONAR: </strong>' + row.data().porcentaje_decimal + '%</td>' +
                    '<td style="font-size: .8em"><strong>FECHA PAGO: </strong>' + row.data().fecha_creacion + '</td>' +
                    '</tr>' +
                    '</table>';


                row.child(informacion_adicional).show();
                tr.addClass('shown');
                $(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
            }
        });


        $("#tabla_ingresar_9 tbody").on("click", ".historial_logs_baja", function(){

        var myCommentsList = document.getElementById('comments-list-asimilados');
        var myCommentsLote = document.getElementById('nameLote');
        myCommentsList.innerHTML = '';
        myCommentsLote.innerHTML = '';

          id_pago = $(this).val();
          lote = $(this).attr("data-value");


          $("#seeInformationModalBaja").modal();
          $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
          $.getJSON("getComments/"+id_pago).done( function( data ){
              $.each( data, function(i, v){
                $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:gray;">'+v.comentario+'</i><br><b style="color:#39A1C0">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.nombre_usuario+'</b></p></div>');
              });
          });
        });


        //         $("#tabla_ingresar_9 tbody").on("click", ".modificar_saldo", function(){
        //   id_pago = $(this).val();
        //   lote = $(this).attr("data-value");

        //   $("#seeInformationModalBaja").modal();
        //   $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
        //   $.getJSON("getComments/"+id_pago).done( function( data ){
        //       $.each( data, function(i, v){
        //         $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:gray;">'+v.comentario+'</i><br><b style="color:#39A1C0">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.nombre_usuario+'</b></p></div>');
        //       });
        //   });
        // });


 


        $("#tabla_ingresar_9 tbody").on("click", ".modificar_saldo", function () {
        
            id_pago = $(this).val();
            lote = $(this).attr("data-value");
            user = $(this).attr("data-value2");
            comision = $(this).attr("data-value3");
            iduser = $(this).attr("data-value4");

            $("#modal_addPago .modal-body").html("");
            $("#modal_addPago .modal-body").append('<h4 class="modal-title">Digita la cantidad a abonar al lote <b>' + lote +'</b> como <b style="color:#05A134">pagada a</b> <b>' + user + '</b></h4>');
            $("#modal_addPago .modal-body").append('<input type="hidden" name="idUsuario" value="' + iduser + '"><input type="hidden" name="idComision" value="' + comision + '">');

            $("#modal_addPago .modal-body").append('<div class="row"><div class="col-md-12"><input class="form-control" type="number" id="montodisponible" name="montodisponible" value="" required></div></div>');
            $("#modal_addPago .modal-body").append('<div class="row"><div class="col-md-3"></div><div class="col-md-3"><input type="submit" class="btn btn-primary" value="AGREGAR"></div><div class="col-md-3"><input type="button" class="btn btn-danger" value="CANCELAR" onclick="closeModalEng()"></div><div class="col-md-3"></div></div>');
            $("#modal_addPago").modal();
        });

    });

}
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



$("#form_addPago").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        $('#loader').removeClass('hidden');
        var data = new FormData( $(form)[0] );
        $.ajax({
            url: url2 + "Comisiones/agregar_pago",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data){
                    // alert(data);
                    if(data == true){
                        $('#loader').addClass('hidden');
                        $("#modal_addPago").modal('toggle');
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




    function closeModalEng() {
        $("#modal_addPago").modal('toggle');
    }


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

