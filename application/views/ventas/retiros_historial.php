<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
<div class="wrapper ">
    <?php $this->load->view('template/sidebar'); ?>
    <!--Contenido de la página-->

    <style type="text/css">

        .addNewRecord {
            background-image: linear-gradient(to bottom, #ffffff, #e0ffff 100%) !important;
        }


        
    </style>

    <div class="modal fade" id="seeInformationModalAsimilados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="material-icons" onclick="cleanCommentsAsimilados()">clear</i>
                    </button>
                </div>
                <div class="modal-body">
                    <div role="tabpanel">
                        <ul class="nav nav-tabs" role="tablist" style="background: #C0B1C4;">
                            <h5 style="color: white;"><b>BITÁCORA DE CAMBIOS</b></h5>
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

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-save fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Historial de retiros</h3>
                                <p class="card-title pl-1"></p>
                            </div>
                            <div  class="toolbar">
                                <div class="row">
                                    <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6 form-group">
                                        <div class="form-group label-floating select-is-empty">
                                            <label for="proyecto">Proyecto:</label>
                                            <select name="proyecto2" id="proyecto2" class="selectpicker select-gral m-0"
                                                    data-style="btn" data-show-subtext="true" data-live-search="true"
                                                    title="Selecciona directivo" data-size="7" required>
                                                <option value="0">Selecciona una opción</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6 form-group">
                                        <div class="form-group label-floating select-is-empty">
                                            <label for="condominio2">Condominio:</label>
                                            <select name="condominio2" id="condominio2" class="selectpicker select-gral m-0"
                                                    data-style="btn" data-show-subtext="true" data-live-search="true"
                                                    title="Selecciona condomino" data-size="7" required>
                                                    <option disabled selected>Selecciona una opción</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="table-responsive">
                                    <table  id="tabla_historial_descuentos" name="tabla_historial_descuentos"
                                            class="table-striped table-hover" style="text-align:center;">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>USUARIO</th>
                                                <th>$ DESCUENTO</th>
                                                <th>LOTE</th>
                                                <th>MOTIVO</th>
                                                <th>ESTATUS</th>
                                                <th>CREADO POR</th>
                                                <th>FECHA CAPTURA</th>
                                                <th>OPCIONES</th>
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
    <?php $this->load->view('template/footer_legend'); ?>




    <div class="content hide">
        <div class="container-fluid">

            <div class="row">
                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">

                        <div class="card-content">
                            <h3 class="card-title center-align">Retiros - <b>Historial</b></h3>
                            <div class="toolbar">
                            </div>
                            <div class="material-datatables">

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
                                           id="tabla_historial_descuentos" name="tabla_historial_descuentos" style="text-align:center;">

                                        <thead>
                                        <tr>
                                            <th style="font-size: .9em;">ID</th>
                                            <th style="font-size: .9em;">USUARIO</th>
                                            <th style="font-size: .9em;">$ DESCUENTO</th>
                                            <th style="font-size: .9em;">LOTE</th>
                                            <th style="font-size: .9em;">MOTIVO</th>
                                            <th style="font-size: .9em;">ESTATUS</th>
                                            <th style="font-size: .9em;">CREADO POR</th>
                                            <th style="font-size: .9em;">FECHA CAPTURA</th>
                                            <th style="font-size: .9em;">OPCIONES</th>
                                        </tr>

                                        <!--  <tr>
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
                                         </tr> -->
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


    $('#tabla_historial_descuentos thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        $(this).html('<input class="textoshead"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if ($('#tabla_historial_descuentos').DataTable().column(i).search() !== this.value ) {
                $('#tabla_historial_descuentos').DataTable().column(i).search(this.value).draw();
            }
        });
    });


    function cleanCommentsAsimilados() {
        var myCommentsList = document.getElementById('comments-list-asimilados');
        myCommentsList.innerHTML = '';
    }

   /* $('#tabla_historial_descuentos thead tr:eq(0) th').each(function (i) {

        if (i != 8) {
            var title = $(this).text();
            titulos.push(title);

            $(this).html('<input type="text" class="textoshead"  placeholder="' + title + '"/>');
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
    });*/
    var url = "<?=base_url()?>";
    var url2 = "<?=base_url()?>index.php/";


    var getInfo1 = new Array(6);
    var getInfo3 = new Array(6);

    $(document).ready(function() {

        $.post(url + "Contratacion/lista_proyecto", function (data) {
            $('#spiner-loader').removeClass('hide');
            var len = data.length;
            for (var i = 0; i < len; i++) {
                var id = data[i]['idResidencial'];
                var name = data[i]['descripcion'];
                $("#proyecto2").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $('#spiner-loader').addClass('hide');
            $("#proyecto2").selectpicker('refresh');
        }, 'json');
        // $('#spiner-loader').addClass('hide');
    });

    $('#proyecto2').change( function(){
        index_proyecto = $(this).val();
        index_condominio = 0
        $("#condominio2").html("");
        $('#spiner-loader').removeClass('hide');
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
        $('#spiner-loader').addClass('hide');
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
    function  fillCommissionTableWithoutPayment2(proyecto,condominio){
        $("#tabla_historial_descuentos").ready(function () {
            tabla_1 = $('#tabla_historial_descuentos').DataTable({
                dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
                buttons: [


                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                        className: 'btn buttons-excel',
                        titleAttr: 'Listado de descuentos',
                        title: 'Listado de descuentos',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7],
                            format: {
                                header: function (d, columnIdx) {
                                    if (columnIdx == 0) {
                                        //  return ' '+d +' ';
                                        return 'ID';

                                        // }else if(columnIdx == 1){
                                        //     return 'ID LOTE';
                                    } else if (columnIdx == 1) {
                                        return 'USUARIO';
                                    } else if (columnIdx == 2) {
                                        return 'DESCUENTO';
                                    } else if (columnIdx == 3) {
                                        return 'LOTE ';
                                    } else if (columnIdx == 4) {
                                        return 'MÓTIVO';
                                    } else if (columnIdx == 5) {
                                        return 'ESTATUS';
                                    } else if (columnIdx == 6) {
                                        return 'CREADO POR';
                                    } else if (columnIdx == 7) {
                                        return 'FECHA CREACIÓN';
                                    } else if (columnIdx != 8 && columnIdx != 0) {
                                        //     if(columnIdx == 11){
                                        //         return 'nose2'
                                        //     }
                                        //     else{
                                        return ' ' + titulos[columnIdx - 1] + ' ';
                                        //     }
                                    }
                                }
                            }
                        }

                    }
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
                "columns": [

                    {
                        "width": "5%",
                        "data": function( d ){
                            return '<p style="font-size: .8em"><center>'+d.id_pago_i+'</center></p>';
                        }
                    },
                    {
                        "width": "13%",
                        "data": function( d ){
                            return '<p style="font-size: .8em"><center>'+d.usuario+'</center></p>';
                        }
                    },

                    {
                        "width": "10%",
                        "data": function( d ){
                            return '<p style="font-size: .8em"><center>$'+formatMoney(d.monto)+'</center></p>';
                        }
                    },
                    {
                        "width": "11%",
                        "data": function( d ){
                            return '<p style="font-size: .7em"><center>'+d.nombreLote+'</center></p>';
                        }
                    },
                    {
                        "width": "13%",
                        "data": function( d ){
                            return '<p style="font-size: .8em"><center>'+d.motivo+'</center></p>';
                        }
                    },
                    {
                        "width": "10%",
                        "data": function( d ){

                            if(d.estatus == 12 || d.estatus == '12' ){
                                return '<center><span class="label label-info">APLICADO</span><center>';
                            }
                            else{
                                return '<center><span class="label label-warning">INACTIVO</span><center>';
                            }

                        }
                    },

                    {
                        "width": "10%",
                        "data": function( d ){
                            return '<p style="font-size: .7em"><center>'+d.modificado_por+'</center></p>';
                        }
                    },
                    {
                        "width": "10%",
                        "data": function( d ){
                            return '<p style="font-size: .8em"><center>'+d.fecha_abono+'</center></p>';
                        }
                    },
                    {
                        "width": "8%",
                        "orderable": false,
                        "data": function( data ){

                            var BtnStats;
                            BtnStats = '<div class="d-flex justify-center"><button href="#" value="'+data.id_pago_i+'" data-value="'+data.id_pago_i+'" data-code="'+data.cbbtton+'" ' + 'class="btn-data btn-details-grey consultar_logs_asimilados" style="background: #A569BD;" title="Detalles">' +'<i class="fas fa-info"></i></button></div>&nbsp;&nbsp;';
                            return BtnStats;

                        }
                    }],
                "ajax": {
                    // "url": "<?=base_url()?>index.php/Comisiones/getdescuentos/"+proyecto+"/"+condominio,
                    "url": url2 + "Comisiones/getHistorialRetiros/"+proyecto+"/"+condominio,
                    "type": "POST",
                    cache: false,
                    "data": function (d) {
                    }
                }
            });

            /*$('#tabla_historial_descuentos tbody').on('click', 'td.details-control', function () {
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
            });*/




            $("#tabla_historial_descuentos tbody").on("click", ".consultar_logs_asimilados", function(){
                id_pago = $(this).val();
                user = $(this).attr("data-usuario");

                $("#seeInformationModalAsimilados").modal();
                $.getJSON("getComments/"+id_pago).done( function( data ){
                    $.each( data, function(i, v){
                        $("#comments-list-asimilados").append('<div class="col-lg-12"><p><b style="color:#896597">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.nombre_usuario+'</b><br><i style="color:gray;">'+v.comentario+'</i></p><br></div>');
                    });
                });
            });



            /*$("#tabla_historial_descuentos tbody").on("click", ".confirmPayment", function () {
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

