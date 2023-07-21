<body class="">
<div class="wrapper ">
            <?php


  if($this->session->userdata('id_rol')=="13" || $this->session->userdata('id_rol')=="17" || $this->session->userdata('id_rol')=="32")//contraloria
    {
        /*-------------------------------------------------------*/
$datos = array();
    $datos = $datos4;
    $datos = $datos2;
    $datos = $datos3;
    $this->load->view('template/sidebar', $datos);
    }
    else
    {
        echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
    }
    ?>
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
                            <h3 class="card-title center-align">Descuentos - <b>Historial</b></h3>
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
    <div class="modal fade modal-alertas" id="modal_confirmPay" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-red">
                </div>
                <form method="post" id="form_enganche">
                    <div class="modal-body"></div>
                </form>
            </div>
        </div>
    </div>
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


        function cleanCommentsAsimilados() {
        var myCommentsList = document.getElementById('comments-list-asimilados');
        myCommentsList.innerHTML = '';
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
    });

    $('#condominio2').change( function(){
        index_proyecto = $('#proyecto2').val();
        index_condominio = $(this).val();
        // SE MANDA LLAMAR FUNCTION QUE LLENA LA DATA TABLE DE COMISINONES SIN PAGO EN NEODATA
        fillCommissionTableWithoutPayment2(index_proyecto, index_condominio);
    });
function  fillCommissionTableWithoutPayment2(proyecto,condominio){
    $("#tabla_historial_descuentos").ready(function () {

        let titulos = [];
        $('#tabla_historial_descuentos thead tr:eq(0) th').each(function (i) {

            if (i != 0 && i != 12) {
                var title = $(this).text();
                titulos.push(title);

                $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500"  placeholder="' + title + '"/>');
                $('input', this).on('keyup change', function () {
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


        tabla_1 = $('#tabla_historial_descuentos').DataTable({
            dom: "Bfrtip",
            buttons: [

 
        {
           extend:    'excelHtml5',
           text:      'Excel',
           titleAttr: 'Excel',
           title: 'DESCUENTOS_SISTEMA_COMISIONES',

          exportOptions: {
              columns: [0,1,2,3,4,5,6,7],
              format: {
                 header:  function (d, columnIdx) {
                     if(columnIdx == 0){
                         return 'ID';
                        }else if(columnIdx == 1){
                            return 'USUARIO';
                        }else if(columnIdx == 2){
                            return 'DESCUENTO';
                        }else if(columnIdx == 3){
                            return 'LOTE ';
                        }else if(columnIdx == 4){
                            return 'MÓTIVO';
                        }else if(columnIdx == 5){
                            return 'ESTATUS';
                        }else if(columnIdx == 6){
                            return 'CREADO POR';
                        }else if(columnIdx == 7){
                            return 'FECHA CREACIÓN';
                        }else if(columnIdx != 8 && columnIdx !=0){
                                return ' '+titulos[columnIdx-1] +' ';
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
                      

                        if(d.estatus == 11 || d.estatus == '11' ){
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
                            BtnStats = '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.id_pago_i+'" data-code="'+data.cbbtton+'" ' + 'class="btn btn-round btn-fab btn-fab-mini consultar_logs_asimilados" style="background: #A569BD;" title="Detalles">' +'<span class="material-icons">info</span></button>&nbsp;&nbsp;';
                            return BtnStats;
 
                    }
                }],
            "ajax": {
                "url": url2 + "Comisiones/getHistorialDescuentos/"+proyecto+"/"+condominio,
                "type": "POST",
                cache: false,
                "data": function (d) {
                }
            }
        });

        $('#tabla_historial_descuentos tbody').on('click', 'td.details-control', function () {
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



              $("#tabla_historial_descuentos tbody").on("click", ".consultar_logs_asimilados", function(){


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


        $("#tabla_historial_descuentos tbody").on("click", ".confirmPayment", function () {
            var tr = $(this).closest('tr');
            var row = tabla_1.row(tr);
            id_pago_i = $(this).val();

            $("#modal_confirmPay .modal-body").html("");
            $("#modal_confirmPay .modal-body").append('<h4 class="modal-title">¿Esta seguro que el pago por <b>$' + formatMoney(row.data().pago_cliente) + '</b> correspondiente al lote <b>' + row.data().nombreLote + '</b> fue pagado correctamente a <b>' + row.data().user_names + '</b>?</h4>');
            $("#modal_confirmPay .modal-body").append('<input type="hidden" name="idPagoInd" value="' + id_pago_i + '">');

            $("#modal_confirmPay .modal-body").append('<div class="row"><div class="col-md-12"><br></div></div>');
            $("#modal_confirmPay .modal-body").append('<div class="row"><div class="col-md-3"></div><div class="col-md-3"><input type="submit" class="btn btn-primary" value="CONFIRMAR"></div><div class="col-md-3"><input type="button" class="btn btn-danger" value="CANCELAR" onclick="closeModalEng()"></div><div class="col-md-3"></div></div>');
            $("#modal_confirmPay").modal();
        });

    });

}
    jQuery(document).ready(function () {

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

    })


    function SoloNumeros(evt) {
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
    }

    function closeModalEng() {
        $("#modal_confirmPay").modal('toggle');
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

