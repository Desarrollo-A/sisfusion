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



     <div class="modal fade" id="seeInformationModalAsimilados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="material-icons" onclick="cleanCommentsAsimilados()">clear</i>
                    </button>
                    <h4 class="modal-title">Consulta información</h4>
                </div>
                <div class="modal-body">
                    <div role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist" style="background: #003d82;">
                            <li role="presentation" class="active"><a href="#changelogTab" aria-controls="changelogTab" role="tab" data-toggle="tab">Bitácora de cambios</a></li>
                        </ul>
                        <!-- Tab panes -->
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
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsAsimilados()">Cerrar</button>
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
                            <h3 class="card-title center-align">Comisiones - <b>Historial</b></h3>
                            <div class="toolbar">
                            </div>
                            <div class="material-datatables">

                                <div class="form-group">
                                    <div class="table-responsive">

                                        <table class="table table-responsive table-bordered table-striped table-hover"
                                               id="tabla_ingresar_9" name="tabla_ingresar_9" style="text-align:center;">

                                            <thead>
                                            <tr>
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


    <!-- modal  CONFIRMAR PAGO-->
    <!--<div class="modal fade modal-alertas" id="modal_confirmPay" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-red">
                </div>
                <form method="post" id="form_enganche">
                    <div class="modal-body"></div>
                </form>
            </div>
        </div>
    </div>-->
    <!-- modal -->


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
                            total += parseFloat(v.pago_cliente);
                        });
                        var to1 = formatMoney(total);
                        document.getElementById("myText_nuevas").value = formatMoney(total);
                    }


                });
            }
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
                    "width": "11%",
                    "data": function (d) {
                        return '<p style="font-size: .8em">' + d.lote + '</p>';
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
                    "width": "11%",
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
                    "width": "9%",
                    "data": function (d) {


                        if(d.restante<=0){
                                return '<p style="font-size: .8em"><span class="label" style="background:#29CC59;">LIQUIDADO</span></p>';
                            }
                            else{

                        switch (d.id_estatus_actual) {
                            case '1':
                            case 2:
                                return '<p style="font-size: .8em"><span class="label" style="background:#29A2CC;">' + d.estatus_actual + '</span></p>';
                                break;

                            case '3':
                            case 3:
                                return '<p style="font-size: .8em"><span class="label" style="background:#CC6C29;">' + d.estatus_actual + '</span></p>';
                                break;

                            case '4':
                            case 4:
                                return '<p style="font-size: .8em"><span class="label" style="background:#9129CC;">' + d.estatus_actual + '</span></p>';
                                break;

                            case '5':
                            case 5:
                                return '<p style="font-size: .8em"><span class="label" style="background:#CC2976;">' + d.estatus_actual + '</span></p>';
                                break;

                            case '6':
                            case 6:
                                return '<p style="font-size: .8em"><span class="label" style="background:#81BFBE;">' + d.estatus_actual + '</span></p>';
                                break;

                            case '7':
                            case 7:
                                return '<p style="font-size: .8em"><span class="label" style="background:#28A255;">' + d.estatus_actual + '</span></p>';
                                break;

                            case '8':
                            case 8:
                                return '<p style="font-size: .8em"><span class="label" style="background:#4D7FA1;">' + d.estatus_actual + '</span></p>';
                                break;

                            case '9':
                            case 9:
                                return '<p style="font-size: .8em"><span class="label" style="background:#E86606;">' + d.estatus_actual + '</span></p>';
                                break;

                            case '10':
                            case 10:
                                return '<p style="font-size: .8em"><span class="label" style="background:#E89606;">' + d.estatus_actual + '</span></p>';
                                break;

                            case '11':
                            case 11:
                                return '<p style="font-size: .8em"><span class="label" style="background:#05A134;">' + d.estatus_actual + '</span></p>';
                                break;

                            default:
                                return '<p style="font-size: .8em"><span class="label" style="background:gray;">' + d.estatus_actual + '</span></p>';
                                break;

                        }
                        }
                    }
                },


                { 
    "width": "5%",
    "orderable": false,
    "data": function( data ){

        var BtnStats;
 
 BtnStats = '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.id_pago_i+'" data-code="'+data.cbbtton+'" ' +
     'class="btn btn-round btn-fab btn-fab-mini consultar_logs_asimilados" style="background: #A569BD;" title="Detalles">' +
     '<span class="material-icons">info</span></button>&nbsp;&nbsp;';

return BtnStats;


        }
    }

            ],
            "ajax": {
                "url": "<?=base_url()?>index.php/Comisiones/getDatosComisionesHistorial",
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



              $("#tabla_ingresar_9 tbody").on("click", ".consultar_logs_asimilados", function(){


          id_pago = $(this).val();
          user = $(this).attr("data-usuario");

          $("#seeInformationModalAsimilados").modal();

          $.getJSON("getComments/"+id_pago).done( function( data ){
              counter = 0;
              $.each( data, function(i, v){
                  counter ++;
                  $("#comments-list-asimilados").append('<li class="timeline-inverted">\n' +
                      ' <div class="timeline-badge info"></div>\n' +
                      ' <div class="timeline-panel">\n' +
                      ' <label><h6>'+v.nombre_usuario+'</h6></label>\n' +
                      ' <br>'+v.comentario+'\n' +
                      ' <h6>\n' +
                      ' <span class="small text-gray"><i class="fa fa-clock-o mr-1"></i> '+v.fecha_movimiento+'</span>\n' +
                      ' </h6>\n' +
                      ' </div>\n' +
                      '</li>');
              });
          });

      });


        /*$("#tabla_ingresar_9 tbody").on("click", ".confirmPayment", function () {
            var tr = $(this).closest('tr');
            var row = tabla_1.row(tr);
            id_pago_i = $(this).val();

            $("#modal_confirmPay .modal-body").html("");
            $("#modal_confirmPay .modal-body").append('<h4 class="modal-title">¿Esta seguro que el pago por <b>$' + formatMoney(row.data().pago_cliente) + '</b> correspondiente al lote <b>' + row.data().nombreLote + '</b> fue pagado correctamente a <b>' + row.data().user_names + '</b>?</h4>');
            $("#modal_confirmPay .modal-body").append('<input type="hidden" name="idPagoInd" value="' + id_pago_i + '">');

            $("#modal_confirmPay .modal-body").append('<div class="row"><div class="col-md-12"><br></div></div>');
            $("#modal_confirmPay .modal-body").append('<div class="row"><div class="col-md-3"></div><div class="col-md-3"><input type="submit" class="btn btn-primary" value="CONFIRMAR"></div><div class="col-md-3"><input type="button" class="btn btn-danger" value="CANCELAR" onclick="closeModalEng()"></div><div class="col-md-3"></div></div>');
            $("#modal_confirmPay").modal();
        });*/

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
        $("#modal_confirmPay").modal('toggle');
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

