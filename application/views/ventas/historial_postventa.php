<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body class="">
<div class="wrapper ">
    <?php

    if ($this->session->userdata('id_rol') == "33" || $this->session->userdata('id_rol') == "17" || $this->session->userdata('id_rol') == "82" || $this->session->userdata('id_rol') == "83") {
        $datos = array();
        $datos = $datos4;
        $datos = $datos2;
        $datos = $datos3;
        $this->load->view('template/sidebar', $datos);
    } else {
        echo '<script>alert("ACCESSO DENEGADO"); window.location.href="' . base_url() . '";</script>';
    }
    ?>
    <!--Contenido de la página-->


    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-user-circle fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title center-align">Comisiones - Pagado por lote</h3>
                            <div class="toolbar">
                                <div class="row">
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table id="tabla_ingresar_9" name="tabla_ingresar_9"
                                               class="table-striped table-hover" style="text-align:center;">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>ID LOTE</th>
                                                    <th>PROYECTO</th>
                                                    <th>CONDOMINIO</th>
                                                    <th>LOTE</th>
                                                    <th>REFERENCIA</th>
                                                    <th>PRECIO LOTE</th>
                                                    <th>TOTAL COM. ($)</th>
                                                    <th>ABONADO</th>
                                                    <th>PAGADO</th>
                                                    <th>CLIENTE</th>
                                                    <th>ESTATUS</th>
                                                    <th></th>
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



     <!--<div class="modal fade" id="seeInformationModalAsimilados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="material-icons" onclick="cleanCommentsAsimilados()">clear</i>
                    </button>
                    <h4 class="modal-title">Consulta información</h4>
                </div>
                <div class="modal-body">
                    <div role="tabpanel">-->
                        <!-- Nav tabs -->
                        <!--<ul class="nav nav-tabs" role="tablist" style="background: #003d82;">
                            <li role="presentation" class="active"><a href="#changelogTab" aria-controls="changelogTab" role="tab" data-toggle="tab">Bitácora de cambios</a></li>
                        </ul>-->
                        <!-- Tab panes -->
                        <!--<div class="tab-content">
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
    </div>-->


    <div class="content hide">
        <div class="container-fluid">

            <div class="row">
                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">

                        <div class="card-content">
                            <h3 class="card-title center-align">Comisiones - <b>Pagado por lote</b></h3>
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
                                                <th style="font-size: .9em;">ID LOTE</th>
                                                <th style="font-size: .9em;">PROYECTO</th>
                                                <th style="font-size: .9em;">CONDOMINIO</th>
                                                <th style="font-size: .9em;">LOTE</th>
                                                <th style="font-size: .9em;">REFERENCIA</th>
                                                <th style="font-size: .9em;">PRECIO LOTE</th>
                                                <th style="font-size: .8em;">TOTAL COM. ($)</th>
                                                <th style="font-size: .8em;">ABONADO</th>
                                                <th style="font-size: .8em;">PAGADO</th>
                                                <th style="font-size: .8em;">CLIENTE</th>
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

            if (i != 0) {
                var title = $(this).text();
                titulos.push(title);

                $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
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

        /*REPORTE_GENERAL_TOTALES_COMISIONES*/
        tabla_1 = $('#tabla_ingresar_9').DataTable({
            dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'REPORTE_GENERAL_TOTALES_COMISIONES',
                    title: 'REPORTE GENERAL TOTALES COMISIONES',
                    exportOptions: {
                        columns: [1,2,3,4,5,6,7,8,9,10,11],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 1:
                                        return 'ID LOTE';
                                        break;
                                    case 2:
                                        return 'PROYECTO';
                                    case 3:
                                        return 'CONDOMINIO';
                                        break;
                                    case 4:
                                        return 'LOTE';
                                        break;
                                    case 5:
                                        return 'REFERENCIA';
                                        break;
                                    case 6:
                                        return 'PRECIO LOTE';
                                        break;
                                    case 7:
                                        return 'TOTAL COM. ($)';
                                        break;
                                    case 8:
                                        return 'ABONADO';
                                        break;
                                    case 9:
                                        return 'PAGADO';
                                        break;
                                    case 10:
                                        return 'CLIENTE';
                                        break;
                                    case 11:
                                        return 'ESTATUS';
                                        break;
                                }
                            }
                        }
                    }

                },
            ],
            pagingType: "full_numbers",
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Todos"]
            ],
            language: {
                url: "<?=base_url()?>/static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
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
                    "data" : null,
                    "defaultContent": '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
                },
                {
                    "width": "5%",
                    "data": function (d) {
                        var lblStats;
                        lblStats = '<p style="font-size: .8em"><b>' + d.idLote + '</b></p>';
                        return lblStats;
                    }
                },
                {
                    "width": "10%",
                    "data": function (d) {
                        return '<p style="font-size: .8em">' + d.proyecto + '</p>';
                    }
                },

                 {
                    "width": "10%",
                    "data": function (d) {
                        return '<p style="font-size: .8em">' + d.condominio + '</p>';
                    }
                },


                {
                    "width": "10%",
                    "data": function (d) {
                        return '<p style="font-size: .8em">' + d.nombreLote + '</p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function (d) {
                        return '<p style="font-size: .8em">' + d.referencia + '</p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function (d) {
                        var lblStats;
                        lblStats = '<p style="font-size: .8em">$' + formatMoney(d.totalNeto2) + '</p>';
                        return lblStats;
                    }
                },
                {
                    "width": "10%",
                    "data": function (d) {
                        return '<p style="font-size: .8em; "><b>$' + formatMoney(d.total_comision) + ' </b></p>';
                    }
                },

                {
                    "width": "10%",
                    "data": function (d) {
                        return '<p style="font-size: .8em; color:gray;">$<b>' + formatMoney(d.abonados) + '</b></p>';
                    }
                },

                {
                    "width": "10%",
                    "data": function (d) {
                        return '<p style="font-size: .8em; color:gray;">$<b>' + formatMoney(d.abono_pagos) + '</b></p>';
                    }
                },
               
                {
                    "width": "10%",
                    "data": function (d) {
                        return '<p style="font-size: .8em"><b>' + d.nombre+' '+d.apellido_paterno+' '+d.apellido_materno+ '</b></p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function (d) {

                        switch (d.registro_comision) {
                            case '1':
                            case 1:
                                return '<p style="font-size: .8em"><span class="label" style="background:#29A2CC;">ACTIVA</span></p>';
                                break;

                            case '7':
                            case 7:
                                return '<p style="font-size: .8em"><span class="label" style="background:#CC6C29;">LIQUIDADA</span></p>';
                                break;
                            default:
                                return '<p style="font-size: .8em"><span class="label" style="background:gray;">NA</span></p>';
                                break;

                        
                        }
                    }
                },

 
            ],
            "ajax": {
                "url": "<?=base_url()?>index.php/Comisiones/getDatosHistorialPostventa",
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
                $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
            } else {
                var status;
                var informacion_adicional2 = '<table class="table text-justify">' +
                    '<tr><b>INFORMACIÓN ADICIONAL</b>:' +
                    '<td style="font-size: .8em"><strong>PORCENTAJE A COMISIONAR: </strong>' + row.data().porcentaje_decimal + '%</td>' +
                    '<td style="font-size: .8em"><strong>FECHA PAGO: </strong>' + row.data().fecha_creacion + '</td>' +
                    '</tr>' +
                    '</table>';

                var informacion_adicional = '<div class="container subBoxDetail">';
                    informacion_adicional += '  <div class="row">';
                    informacion_adicional += '      <div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px">';
                    informacion_adicional += '          <label><b>Información adicional</b></label>';
                    informacion_adicional += '      </div>';
                    informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>PORCENTAJE A COMISIONAR: </b>'+ row.data().porcentaje_decimal +'%</label></div>';
                    informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>FECHA PAGO: </b> ' + row.data().fecha_creacion + '</label></div>';
                    informacion_adicional += '  </div>';
                    informacion_adicional += '</div>';




                row.child(informacion_adicional).show();
                tr.addClass('shown');
                $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");

            }
        });



              /*$("#tabla_ingresar_9 tbody").on("click", ".consultar_logs_asimilados", function(){


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

      });*/


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

