<body>
<div class="wrapper">
 
    <?php $this->load->view('template/sidebar'); ?>



 



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
    }
</style>




<div class="modal fade modal-alertas" id="modal_nuevas" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">DETALLES COMISIÓN</h4>
            </div>
            <form method="post" id="form_interes">
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="seeInformationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons" onclick="cleanComments()">clear</i>
                </button>
                <h4 class="modal-title">Consulta información</h4>
            </div>
            <div class="modal-body">
                <div role="tabpanel">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist" style="background: #003d82;">
                        <li role="presentation" class="active"><a href="#documents" aria-controls="documents" role="tab" data-toggle="tab">Documentación</a></li>
                        <li role="presentation"><a href="#facturaInfo" aria-controls="facturaInfo" role="tab" data-toggle="tab">Datos factura</a></li>
                        <li role="presentation"><a href="#changelogTab" aria-controls="changelogTab" role="tab" data-toggle="tab">Bitácora de cambios</a></li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">

                        <div role="tabpanel" class="tab-pane active documents" id="documents"></div>
                        <div role="tabpanel" class="tab-pane facturaInfo" id="facturaInfo"></div>
                        <div role="tabpanel" class="tab-pane changelogTab" id="changelogTab"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanComments()">Cerrar</button>
            </div>
        </div>
    </div>
</div>






<div class="modal fade modal-alertas" id="modal_documentacion" role="dialog">
        <div class="modal-dialog" style="width:800px; margin-top:20px">
            <div class="modal-content">
                <div class="modal-body">


                    <div class="row">
                    </div>
                </div>
            </div>
        </div>
    </div>


<div class="modal fade bd-example-modal-sm" id="myModalEnviadas" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
  </div>
</div>



<div class="modal fade modal-alertas" id="documento_preview" role="dialog">
    <div class="modal-dialog" style= "margin-top:20px;"></div>
</div>


<!-- inicia modal subir factura -->


 <div id="modal_formulario_solicitud" class="modal" style="position:fixed; top:0; left:0; margin-bottom: 1%;  margin-top: -5%;">
        <div class="modal-dialog modal-md">

        <div class="modal-content">
            <div class="modal-body">
                <div class="tab-content">
                     <div class="active tab-pane" id="generar_solicitud">
                        <div class="row">
                            <div class="col-lg-12">

                                //poner modal
                                
                                <div class="row">

                                    <div class="col-lg-5">
                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                            <div><br>
                                                <span class="fileinput-new">Selecciona archivo</span>
                                                <input type="file" name="xmlfile" id="xmlfile" accept="application/xml">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-7">
                                        <center>

                                        <button class="btn btn-warning" type="button" id="cargar_xml"><i class="fa fa-upload"></i> CARGAR</button>
                                    </center>
                                    </div>
                                </div>

                                <form id="frmnewsol" method="post" action="#">
                                    <div class="row">
                                         <div class="col-lg-8 form-group">
                                            <label for="emisor">Emisor:<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="emisor" name="emisor" placeholder="Emisor" value="" required>
                                        </div>
                                        <div class="col-lg-4 form-group">
                                            <label for="rfcemisor">RFC Emisor:<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="rfcemisor" name="rfcemisor" placeholder="RFC Emisor" value="" required>
                                        </div>
                                        <div class="col-lg-8 form-group">
                                            <label for="receptor">Receptor:<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="receptor" name="receptor" placeholder="Receptor" value="" required>
                                        </div>
                                        <div class="col-lg-4 form-group">
                                            <label for="rfcreceptor">RFC Receptor:<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="rfcreceptor" name="rfcreceptor" placeholder="RFC Receptor" value="" required>
                                        </div>
                                        <div class="col-lg-3 form-group">
                                            <label for="regimenFiscal">Régimen Fiscal:<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="regimenFiscal" name="regimenFiscal" placeholder="Regimen Fiscal" value="" required>
                                        </div>
                                        <div class="col-lg-3 form-group">
                                            <label for="total">Monto:<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="total" name="total" placeholder="Total" value="" required>
                                        </div>
                                        <div class="col-lg-3 form-group">
                                            <label for="formaPago">Forma Pago:</label>
                                            <input type="text" class="form-control" placeholder="Forma Pago" id="formaPago" name="formaPago" value="">
                                        </div>
                                        <div class="col-lg-3 form-group">
                                            <label for="cfdi">Uso del CFDI:</label>
                                            <input type="text" class="form-control" placeholder="Uso de CFDI" id="cfdi" name="cfdi" value="">
                                        </div>
                                        <div class="col-lg-3 form-group">
                                            <label for="metodopago">Método de Pago:</label>
                                            <input type="text" class="form-control" id="metodopago" name="metodopago" placeholder="Método de Pago" value="" readonly>
                                        </div>
                                        <div class="col-lg-3 form-group">
                                            <label for="unidad">Unidad:</label>
                                            <input type="text" class="form-control" id="unidad" name="unidad" placeholder="Unidad" value="" readonly>
                                        </div>
                                        <div class="col-lg-3 form-group">
                                            <label for="clave">Clave Prod/Serv:<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="clave" name="clave" placeholder="Clave" value="" required>
                                        </div>
                                    </div>
                                   
                                    <div class="row">
                                        <div class="col-lg-12 form-group">
                                            <label for="obse">OBSERVACIONES FACTURA <i class="fa fa-question-circle faq" tabindex="0" data-container="body" data-trigger="focus" data-toggle="popover" title="Observaciones de la factura" data-content="En este campo pueden ser ingresados datos opcionales como descuentos, observaciones, descripción de la operación, etc." data-placement="right"></i></label><br>
                                            <textarea class="form-control" rows='1' data-min-rows='1' id="obse" name="obse" placeholder="Observaciones"></textarea>
                                      

 
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4 form-group"></div>  <div class="col-lg-4 form-group">
                                            <button type="submit" class="btn btn-primary btn-block">GUARDAR</button>
                                        </div>
                                    </div>


                                </form>
                            </div>
                        </div>
                    </div>
                   
                </div>
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
                        <div class="row">
                            <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="nav-center">
                                    <ul class="nav nav-pills nav-pills-info nav-pills-icons" role="tablist">
                                        <li class="active" style="margin-right: 50px;">
                                            <a href="#nuevas-1" role="tab" data-toggle="tab">
                                                <i class="fa fa-file-text-o" aria-hidden="true"></i> Nuevas
                                            </a>
                                        </li>

                                        <li style="margin-right: 50px;">
                                            <a href="#proceso-1" role="tab" data-toggle="tab">
                                                <i class="fa fa-clipboard" aria-hidden="true"></i> EN REVISIÓN
                                            </a>
                                        </li>

                                        <li style="margin-right: 50px;">
                                            <a href="#proceso-2" role="tab" data-toggle="tab">
                                               <i class="fa fa-wpforms" aria-hidden="true"></i> Por pagar
                                            </a>
                                        </li>

                                        <li style="margin-right: 50px;">
                                            <a href="#otras-1" role="tab" data-toggle="tab">
                                                <i class="fa fa-files-o" aria-hidden="true"></i> Otras
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="tab-content">

                                    <div class="tab-pane active" id="nuevas-1">
                                        <div class="content">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <div class="card">
                                                            <div class="card-header">

                                                                <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                    <h4 class="card-title">COMISIONES NUEVAS</h4>
                                                                <p class="category">Las comisiones se encuentran disponibles para solicitar tu pago.</p>
                                                                <p class="estado_horario"></p>

                                                            </div>

                                                                <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6"><br>
                                                                    <label style="color: #0a548b;">&nbsp;Disponible: $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text"  name="myText_nuevas" id="myText_nuevas"></label>


                                                                    <label style="color: #0a548b;">&nbsp;Solicitar: $

                                                                        <span style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text" id="totpagarPen"></span>

                                                                    </label>

                                                                    <!-- <span id="totpagarPen"></span> -->
                                                                </div>

                                                            </div>
                                                            <div class="card-content">
                                                                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <div class="material-datatables">
                                                                    <div class="form-group">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-responsive table-bordered table-striped table-hover" id="tabla_nuevas_comisiones" name="tabla_nuevas_comisiones">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th style="font-size: .8em;"></th>
                                                                                        <th style="font-size: .8em;">LOTE</th>
                                                                                        <th style="font-size: .8em;">PRECIO LOTE</th>
                                                                                        <th style="font-size: .8em;">TOTAL COM. ($)</th>
                                                                                        <th style="font-size: .8em;">COM %.</th>
                                                                                        <th style="font-size: .8em;">PAGO CLIENTE</th>
                                                                                        <th style="font-size: .8em;">ABONO NEO.</th>
                                                                                        <th style="font-size: .8em;">PAGADO</th>
                                                                                        <th style="font-size: .8em;">PENDIENTE</th>
                                                                                        <th style="font-size: .8em;">TIPO VENTA</th>
                                                                                        <th style="font-size: .8em;">ESTATUS</th>
                                                                                        <th style="font-size: .8em;">FEC. CREACIÓN</th>
                                                                                        <th style="font-size: .8em;">MÁS</th>
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

                                    <!-- ///////////////// -->

                                    <div class="tab-pane" id="proceso-1">
                                        <div class="content">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <div class="card">
                                                            <div class="card-header">

                                                                <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                    <h4 class="card-title">COMISIONES EN REVISIÓN</h4>
                                                                <p class="category">Las comisiones se encuentran en revisión por el área de <b>Contraloría.</b></p></div>

                                                                <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6"><br>
                                                                    <label style="color: #0a548b;">&nbsp;Total: $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text" name="myText_proceso" id="myText_proceso"></label>
                                                                </div>

                                                            </div>
                                                            <div class="card-content">
                                                                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <div class="material-datatables">
                                                                    <div class="form-group">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-responsive table-bordered table-striped table-hover" id="tabla_revision_comisiones" name="tabla_revision_comisiones">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th style="font-size: .8em;">ID</th>
                                                                                        <th style="font-size: .8em;">LOTE</th>
                                                                                        <th style="font-size: .8em;">PRECIO LOTE</th>
                                                                                        <th style="font-size: .8em;">TOTAL COM. ($)</th>
                                                                                        <th style="font-size: .8em;">COM %.</th>
                                                                                        <th style="font-size: .8em;">PAGO CLIENTE</th>
                                                                                        <th style="font-size: .8em;">ABONO NEO.</th>
                                                                                        <th style="font-size: .8em;">PAGADO</th>
                                                                                        <th style="font-size: .8em;">PENDIENTE</th>
                                                                                        <th style="font-size: .8em;">TIPO VENTA</th>
                                                                                        <th style="font-size: .8em;">ESTATUS</th>
                                                                                        <th style="font-size: .8em;">FEC. CREACIÓN</th>
<!--                                                                                         <th style="font-size: .8em;">MÁS</th>
 -->                                                                                    </tr>
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


                                    <!-- /////////////// -->

                                    <div class="tab-pane" id="proceso-2">
                                        <div class="content">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <div class="card">
                                                            <div class="card-header">

                                                                <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                    <h4 class="card-title">COMISIONES POR PAGAR</h4>
                                                                <p class="category">Las comisiones se encuentran en proceso de pago por parte de <B>INTERNOMEX.</B></p></div>

                                                                <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6"><br>
                                                                    <label style="color: #0a548b;">&nbsp;Total: $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text"  name="myText_pagadas" id="myText_pagadas"></label>
                                                                </div>

                                                            </div>
                                                            <div class="card-content">
                                                                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <div class="material-datatables">
                                                                    <div class="form-group">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-responsive table-bordered table-striped table-hover" id="tabla_pagadas_comisiones" name="tabla_pagadas_comisiones">
                                                                                <thead>
                                                                                   <tr>
                                                                                        <th style="font-size: .8em;">ID</th>
                                                                                        <th style="font-size: .8em;">LOTE</th>
                                                                                        <th style="font-size: .8em;">PRECIO LOTE</th>
                                                                                        <th style="font-size: .8em;">TOTAL COM. ($)</th>
                                                                                        <th style="font-size: .8em;">COM %.</th>
                                                                                        <th style="font-size: .8em;">PAGO CLIENTE</th>
                                                                                        <th style="font-size: .8em;">ABONO NEO.</th>
                                                                                        <th style="font-size: .8em;">PAGADO</th>
                                                                                        <th style="font-size: .8em;">PENDIENTE</th>
                                                                                        <th style="font-size: .8em;">TIPO VENTA</th>
                                                                                        <th style="font-size: .8em;">ESTATUS</th>
                                                                                        <th style="font-size: .8em;">FEC. CREACIÓN</th>
<!--                                                                                         <th style="font-size: .8em;">MÁS</th>
 -->                                                                                    </tr>
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

                                    <!-- //////////////// -->


                                    <!-- /////////////// -->

                                    <div class="tab-pane" id="otras-1">
                                        <div class="content">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <div class="card">
                                                            <div class="card-header">

                                                                <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                    <h4 class="card-title">OTRAS COMISIONES</h4>
                                                                <p class="category">Comisiones pausadas, rechazadas.</p></div>

                                                                <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6"><br>
                                                                    <label style="color: #0a548b;">&nbsp;Total: $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text"  name="myText_otras" id="myText_otras"></label>
                                                                </div>

                                                            </div>
                                                            <div class="card-content">
                                                                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <div class="material-datatables">
                                                                    <div class="form-group">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-responsive table-bordered table-striped table-hover" id="tabla_otras_comisiones" name="tabla_otras_comisiones">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th style="font-size: .8em;">ID</th>
                                                                                        <th style="font-size: .8em;">LOTE</th>
                                                                                        <th style="font-size: .8em;">PRECIO LOTE</th>
                                                                                        <th style="font-size: .8em;">TOTAL COM. ($)</th>
                                                                                        <th style="font-size: .8em;">COM %.</th>
                                                                                        <th style="font-size: .8em;">PAGO CLIENTE</th>
                                                                                        <th style="font-size: .8em;">ABONO NEO.</th>
                                                                                        <th style="font-size: .8em;">PAGADO</th>
                                                                                        <th style="font-size: .8em;">PENDIENTE</th>
                                                                                        <th style="font-size: .8em;">TIPO VENTA</th>
                                                                                        <th style="font-size: .8em;">ESTATUS</th>
                                                                                        <th style="font-size: .8em;">FEC. CREACIÓN</th>
<!--                                                                                         <th style="font-size: .8em;">MÁS</th>
 -->                                                                                    </tr>
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

                                    <!-- //////////////// -->

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
<?php $this->load->view('template/footer');?>
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
    var totaPen = 0;
    var tr;

  $("#tabla_nuevas_comisiones").ready( function(){

  $('#tabla_nuevas_comisiones thead tr:eq(0) th').each( function (i) {
   if( i!=0 && i!=10){
    var title = $(this).text();


    $(this).html('<input type="text" style="width:100%; background: #003D82; color: white; border: 0; font-weight: 500;"  placeholder="'+title+'"/>' );
    $( 'input', this ).on('keyup change', function () {

        if (tabla_nuevas.column(i).search() !== this.value ) {
            tabla_nuevas
            .column(i)
            .search(this.value)
            .draw();

            var total = 0;
            var index = tabla_nuevas.rows({ selected: true, search: 'applied' }).indexes();
            var data = tabla_nuevas.rows( index ).data();

            $.each(data, function(i, v){
                total += parseFloat(v.pago_cliente);
            });
            var to1 = formatMoney(total);
            document.getElementById("myText_nuevas").value = formatMoney(total);
        }
    } );
}
});

  $('#tabla_nuevas_comisiones').on('xhr.dt', function ( e, settings, json, xhr ) {
    var total = 0;
    $.each(json.data, function(i, v){
        total += parseFloat(v.pago_cliente);
    });
    var to = formatMoney(total);
    document.getElementById("myText_nuevas").value = to;
});


        tabla_nuevas = $("#tabla_nuevas_comisiones").DataTable({
            dom: 'Brtip',
            width: 'auto',
            "buttons": [
            {
                text: '<i class="fa fa-check"></i> ENVIAR COMISIÓN',
                action: function(){

                    if ($('input[name="idT[]"]:checked').length > 0) {

                        var idcomision = $(tabla_nuevas.$('input[name="idT[]"]:checked')).map(function () { return this.value; }).get();

                        $.get(url+"Comisiones/acepto_comisiones_user/"+idcomision).done(function () {

                            var fecha = new Date();
                            // alert(fecha.getHours()+' - '+fecha.getDay());

                            if(fecha.getHours()>=14 && fecha.getDay()==2){//miercoles 3 fecha.getHours()>=10 && f

                                 // alert("no pasa");

                            $("#myModalEnviadas").modal('toggle');
                            tabla_nuevas.ajax.reload();
                            tabla_revision.ajax.reload();

                            $("#myModalEnviadas .modal-body").html("");
                            $("#myModalEnviadas").modal();
                            $("#myModalEnviadas .modal-body").append("<center><img style='width: 25%; height: 25%;' src= '<?=base_url('dist/img/check_com.png')?>'><br><br><P>LAS COMISIONES ENVIADAS SE PAGARÁN LA <b>PRÓXIMA SEMANA</b> YA QUE EL DÍA MARTES EL <b>HORARIO LIMITE ES A LAS 2:00 PM</b> PARA EL CORTE DE ESTA SEMANA.<BR><i style='font-size:12px;'>PUEDES VER ESTAS SOLICITUDES EN EL PANEL <B>'EN REVISIÓN'</B></i></P></center>");


                            }
                            else{

                                // alert("pasa");

                            $("#myModalEnviadas").modal('toggle');
                            tabla_nuevas.ajax.reload();
                            tabla_revision.ajax.reload();

                            $("#myModalEnviadas .modal-body").html("");
                            $("#myModalEnviadas").modal();
                            $("#myModalEnviadas .modal-body").append("<center><img style='width: 25%; height: 25%;' src= '<?=base_url('dist/img/check_com.png')?>'><br><br><P>COMISIONES ENVIADAS A <b>CONTRALORÍA</b> PARA SU REVISIÓN.</P><BR><i style='font-size:12px;'>PUEDES VER ESTAS SOLICITUDES EN EL PANEL <B>'EN REVISIÓN'</B></i></P></center>");
                            }

                        });
                    }
                },
                attr: {
                    class: 'btn bg-navy',
                }

            },
        ],

            "language":{ "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
            "processing": true,
            "pageLength": 10,
            "bAutoWidth": false,
            "bLengthChange": false,
            "scrollX": true,
            "bInfo": false,
            "searching": true,
            "ordering": false,
            "fixedColumns": true,
            "ordering": false,
            "columns": [

            {  "width": "4%" },
 // y("SELECT pci1.id_comision, lo.total precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus, com.fecha_creacion, pci1.id_usuario, oxcpj.nombre as pj_name, cl.personalidad_juridica, u.forma_pago, f.id_comision as factura 
            {
                "width": "12%",
                "data": function( d ){
                    return '<p style="font-size: .8em"><b>'+d.proyecto+'</b><br>'+d.lote+' fp'+d.forma_pago+'</p>';
                }
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.precio_lote)+'</p>';
                }
            },
             {
                "width": "8%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.comision_total)+' </p>';
                }
            },

            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+formatMoney(d.porcentaje_decimal)+'%</p>';
                }
            },
           {
                "width": "8%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.pago_neodata)+'</p>';
                }
            },
             {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em"><b>$'+formatMoney(d.pago_cliente)+'</b></p>';
                }
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.pagado)+'</p>';
                }
            },
               {
                "width": "10%",
                "data": function( d ){
 
                    if(d.restante==null||d.restante==''){
                          return '<p style="font-size: .8em">$'+formatMoney(d.comision_total)+'</p>';
                    }
                    else{
                         return '<p style="font-size: .8em">$'+formatMoney(d.restante)+'</p>';
                    }
                   
                }
            },
             
             
            {
                "width": "8%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.lugar_prosp+'<b> ('+d.porcentaje_abono+'%)</b></p>';
                }
            },

            {
                "width": "8%",
                "data": function( d ){

                    switch(d.forma_pago){
                        case '1'://SIN DEFINIR
                          return '<p style="font-size: .8em"><span class="label" style="background:#CC4B4B;">SIN DEFINIR FORMA DE PAGO</span></p>';
                        break;

                        case '2'://FACTURA

                            if(d.factura != null && d.factura != 0 && d.factura != ''){
                                return '<p style="font-size: .8em"><span class="label" style="background:#00B397;">LISTA PARA APROBAR</span></p>';
                            }
                            // else if((d.expediente == null || d.expediente == 0 || d.expediente == '') && (d.factura == null || d.factura == 0 || d.factura == '')){
                            //     return '<p style="font-size: .8em"><span class="label" style="background:#B5646B;">SIN CONTRATO DE CLIENTE</span></p><p style="font-size: .8em"><span class="label" style="background:#CC4B4B;">REQUIERE FACTURA</span></p>';
                            // }
                            // if(d.expediente == null || d.expediente == 0 || d.expediente == '' && d.factura != null && d.factura != 0 && d.factura != ''){
                            //     return '<p style="font-size: .8em"><span class="label" style="background:#B5646B;">SIN CONTRATO DE CLIENTE</span></p>';
                            // }

                            else if(d.factura == null || d.factura == 0 || d.factura == ''){
                                return '<p style="font-size: .8em"><span class="label" style="background:#CC4B4B;">REQUIERE FACTURA</span></p>';
                            }
                            
                        break;

                        case '3'://ASIMILADOS

                        // if(d.expediente != null && d.expediente != 0 && d.expediente){
                             return '<p style="font-size: .8em"><span class="label" style="background:#4B94CC;">ASIMILADOS</span></p><p style="font-size: .8em"><span class="label" style="background:#00B397;">LISTA PARA APROBAR</span></p>';
                        //  }
                        //  else{
                        //     return '<p style="font-size: .8em"><span class="label" style="background:#B5646B;">SIN CONTRATO DE CLIENTE</span></p>';
                        // }


                        break;

                        default:
                        return '';
                        break;

                    }
                  
                }
            },
            {
                "width": "12%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.fecha_creacion+'</p>';
                }
            },
            {
                "width": "10%",
                "orderable": false,
                "data": function( d ){

                     switch(d.forma_pago){
                        case '1'://SIN DEFINIR
                          return '<button class="btn btn-round btn-fab btn-fab-mini info consultar_documentos" data-personalidad="' + d.personalidad_juridica +'" value="' + d.id_comision +'" style="margin-right: 3px"><i class="material-icons">info</i></button>';
                        break;

                         case '2'://FACTURA
                             if(d.factura != null && d.factura != 0 && d.factura != ''){
                                // alert("aqui 1");
                                return '<button class="btn btn-round btn-fab btn-fab-mini info consultar_documentos" data-personalidad="' + d.personalidad_juridica +'" value="' + d.id_comision +'" style="margin-right: 3px"><i class="material-icons">info</i></button>'+
                                '<button disabled  class="btn btn-secondary btn-round btn-fab btn-fab-mini subir_factura" title="YA TIENE UNA FACTURA" value="' + d.id_comision +'" style="margin-right: 3px;color:#fff;"><i class="material-icons">publish</i></button>';

                             }else{
                                 // alert("aqui 2");
                                return '<button class="btn btn-round btn-fab btn-fab-mini info consultar_documentos" data-personalidad="' + d.personalidad_juridica +'" value="' + d.id_comision +'" style="margin-right: 3px"><i class="material-icons">info</i></button>'+
                                '<button class="btn btn-info btn-round btn-fab btn-fab-mini subir_factura" title="SUBIR FACTURA" value="' + d.id_comision +'" style="margin-right: 3px;color:#fff;"><i class="material-icons">publish</i></button>';
                            }
                        break;

                        case '3'://ASIMILADOS
                        // return '<p style="font-size: .8em"><span class="label label-success">LISTA PARA APROBAR</span></p>';
                        return '<button class="btn btn-round btn-fab btn-fab-mini info consultar_documentos" data-personalidad="' + d.personalidad_juridica +'" value="' + d.id_comision +'" style="margin-right: 3px"><i class="material-icons">info</i></button>';
                        break;

                        default:
                        return '<button class="btn btn-round btn-fab btn-fab-mini info consultar_documentos" data-personalidad="' + d.personalidad_juridica +'" value="' + d.id_comision +'" style="margin-right: 3px"><i class="material-icons">info</i></button>';
                        break;

                    }
 
                }
            }],

            columnDefs: [
            {
                orderable: false,
                className: 'select-checkbox',
                targets:   0,
                'searchable':false,
                'className': 'dt-body-center',
                'render': function (d, type, full, meta){

 

                     switch(full.forma_pago){
                        case '1'://SIN DEFINIR
                          return '';
                        break;

                        case '2'://FACTURA
                            if(full.factura != null && full.factura != 0 && full.factura != ''){
                                return '<input type="checkbox" name="idT[]" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
                            }else{
                                return '';
                            }
                        break;

                        case '3'://ASIMILADOS
                        // if(full.expediente != null && full.expediente != 0 && full.expediente != ''){
                                return '<input type="checkbox" name="idT[]" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
                            // }else{
                            //     return '';
                            // }

                        // return '<input type="checkbox" name="idT[]" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';;

                        break;

                        default:
                        return '';
                        break;

                    }
 
                },
                select: {
                    style: 'os',
                    selector: 'td:first-child'
                },
            }],

            "ajax": {
                "url": url2 + "Comisiones/getDatosComisionesNuevas",
                /*registroCliente/getregistrosClientes*/
                    "type": "POST",
                    cache: false,
                    "data": function( d ){}},
                    "order": [[ 1, 'asc' ]]
                });

        $("#tabla_nuevas_comisiones tbody").on("click", ".mas_opciones_8", function(){
            var tr = $(this).closest('tr');
            var row = tabla_nuevas.row( tr );

            $("#modal_nuevas .modal-body").html("");
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>ASESOR:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p> </div></div>');
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-6"><p>PLAN DE PAGO:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div><div class="col-lg-6"><p>NOMBRE LOTE:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div></div>');
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-6"><p>VENTA:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div><div class="col-lg-6"><p>COMISIÓN $:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div></div>');
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>MEDIO(S) DE VENTA:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div></div>');
            $("#modal_nuevas").modal();
        });





        $('#tabla_nuevas_comisiones').on( 'click', 'input', function () {
            tr = $(this).closest('tr');

            var row = tabla_nuevas.row( tr ).data();

            if( row.pa == 0 ){

                row.pa = row.pago_cliente;
                // tabla_nuevas.row( tr ).data( row );
                totaPen += parseFloat( row.pa );
                tr.children().eq(1).children('input[type="checkbox"]').prop( "checked",true );
            }else{

                totaPen -= parseFloat( row.pa );
                row.pa = 0;
                // tabla_nuevas.row( tr ).data( row );

            }

            $("#totpagarPen").html(formatMoney(totaPen));
        });



$("#tabla_nuevas_comisiones tbody").on("click", ".consultar_documentos", function(){
    id_com = $(this).val();
    id_pj = $(this).attr("data-personalidad");

    $("#seeInformationModal").modal();
 
    $.getJSON( url + "Comisiones/getDatosDocumentos/"+id_com+"/"+id_pj).done( function( data ){
        $.each( data, function( i, v){

            $("#seeInformationModal .documents").append('<div class="row">');
            if (v.estado == "NO EXISTE"){

                $("#seeInformationModal .documents").append('<div class="col-md-7"><label style="font-size:10px; margin:0; color:gray;">'+(v.nombre).substr(0, 52)+'</label></div><div class="col-md-5"><label style="font-size:10px; margin:0; color:gray;">(No existente)</label></div>');
            }
            else{
                $("#seeInformationModal .documents").append('<div class="col-md-7"><label style="font-size:10px; margin:0; color:#0a548b;"><b>'+(v.nombre).substr(0, 52)+'</b></label></div> <div class="col-md-5"><label style="font-size:10px; margin:0; color:#0a548b;"><b>('+v.id_cliente+')</label></b> - <button onclick="preview_info(&#39;'+(v.id_cliente)+'&#39;)" style="border:none; background-color:#fff;"><i class="fa fa-file" aria-hidden="true" style="font-size: 12px; color:#0a548b;"></i></button></div>');
             }
             $("#seeInformationModal .documents").append('</div>');
         });
    });

    $.getJSON( url + "Comisiones/getDatosFactura/"+id_com).done( function( data ){
       

           $("#seeInformationModal .facturaInfo").append('<div class="row">');
            if (!data.datos_solicitud['id_factura'] == '' && !data.datos_solicitud['id_factura'] == '0'){

                $("#seeInformationModal .facturaInfo").append('<BR><div class="col-md-12"><label style="font-size:14px; margin:0; color:gray;"><b>NOMBRE EMISOR</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['nombre']+' '+data.datos_solicitud['apellido_paterno']+' '+data.datos_solicitud['apellido_materno']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b> LOTE</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['nombreLote']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                 $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>TOTAL FACT.</b></label><br><label style="font-size:12px; margin:0; color:gray;">$ '+data.datos_solicitud['total']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>MONTO COMSN.</b></label><br><label style="font-size:12px; margin:0; color:gray;">$ '+data.datos_solicitud['pago_cliente']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>FOLIO</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['folio_factura']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>FECHA FACTURA</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['fecha_factura']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>FECHA CAPTURA</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['fecha_ingreso']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');                

                $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>MÉTODO</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['metodo_pago']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
 
                $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>RÉGIMEN F.</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['regimen']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>FORMA P.</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['forma_pago']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>CFDI</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['cfdi']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>UNIDAD</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['unidad']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>CLAVE PROD.</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['claveProd']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModal .facturaInfo").append('<div class="col-md-6"><label style="font-size:14px; margin:0; color:gray;"><b>UUID</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['uuid']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModal .facturaInfo").append('<div class="col-md-12"><label style="font-size:14px; margin:0; color:gray;"><b>DESCRIPCIÓN</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['descripcion']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
            }
            else {
                 $("#seeInformationModal .facturaInfo").append('<div class="col-md-12"><label style="font-size:10px; margin:0; color:orange;">SIN HAY DATOS A MOSTRAR</label></div>');
              }
             $("#seeInformationModal .facturaInfo").append('</div>');
 
    });

    // $.getJSON( url + "Comisiones/getCambios/"+id_com+"/"+id_pj).done( function( data ){
    //     $.each( data, function( i, v){
    //         fillFields(v, 1);
    //     });
    // });

});



 


 
    });

//FIN TABLA NUEVA

// INICIO TABLA EN PROCESO

  $("#tabla_revision_comisiones").ready( function(){

  $('#tabla_revision_comisiones thead tr:eq(0) th').each( function (i) {
   if( i!=0 && i!=10){
    var title = $(this).text();


    $(this).html('<input type="text" style="width:100%; background: #003D82; color: white; border: 0; font-weight: 500"  placeholder="'+title+'"/>' );
    $( 'input', this ).on('keyup change', function () {

        if (tabla_revision.column(i).search() !== this.value ) {
            tabla_revision
            .column(i)
            .search(this.value)
            .draw();

            var total = 0;
            var index = tabla_revision.rows({ selected: true, search: 'applied' }).indexes();
            var data = tabla_revision.rows( index ).data();

            $.each(data, function(i, v){
                total += parseFloat(v.pago_cliente);
            });
            var to1 = formatMoney(total);
            document.getElementById("myText_proceso").value = formatMoney(total);
        }
    } );
}
});

  $('#tabla_revision_comisiones').on('xhr.dt', function ( e, settings, json, xhr ) {
    var total = 0;
    $.each(json.data, function(i, v){
        total += parseFloat(v.pago_cliente);
    });
    var to = formatMoney(total);
    document.getElementById("myText_proceso").value = to;
});


        tabla_revision = $("#tabla_revision_comisiones").DataTable({
            dom: '<"clear">',
            width: 'auto',

            "language":{ "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
            "processing": true,
            "pageLength": 10,
            "bAutoWidth": false,
            "bLengthChange": false,
            "scrollX": true,
            "bInfo": false,
            "searching": true,
            "ordering": false,
            "fixedColumns": true,
            "ordering": false,

            "columns": [

            {  "width": "4%",
            "data": function( d ){
                    return '<p style="font-size: .8em">'+d.id_pago_i+'</p>';
                }},

 // y("SELECT pci1.id_comision, lo.total precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus, com.fecha_creacion, pci1.id_usuario, oxcpj.nombre as pj_name, cl.personalidad_juridica, u.forma_pago, f.id_comision as factura 
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em"><b>'+d.proyecto+'</b><br>'+d.lote+'</p>';
                }
            },
            {
                "width": "8%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.precio_lote)+'</p>';
                }
            },
             {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.comision_total)+' </p>';
                }
            },

            {
                "width": "8%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+formatMoney(d.porcentaje_decimal)+'%</p>';
                }
            },
           {
                "width": "9%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.pago_neodata)+'</p>';
                }
            },
             {
                "width": "9%",
                "data": function( d ){
                    return '<p style="font-size: .8em"><b>$'+formatMoney(d.pago_cliente)+'</b></p>';
                }
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.pagado)+'</p>';
                }
            },
             {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.restante)+'</p>';
                }
            },
             
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.lugar_prosp+'</p>';
                }
            },

            {
                "width": "10%",
                "orderable": false,
                "data": function( d ){
                    // return '<p style="font-size: .8em">'+d.estado_fecha+'</p>';
                    return '<p style="font-size: .8em"><span class="label" style="background:#A5C9F3;">'+d.estado_fecha+'</span></p>';
                }
                 
            },
 
            {
                "width": "12%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.fecha_creacion+'</p>';
                }
            }
            ],






            columnDefs: [
            {

    orderable: false,
    className: 'select-checkbox',
    targets:   0,
    'searchable':false,
    'className': 'dt-body-center'
    }],



            "ajax": {
                "url": url2 + "Comisiones/getDatosComisionesRevision",/*registroCliente/getregistrosClientes*/
                    "type": "POST",
                    cache: false,
                    "data": function( d ){}},
                    "order": [[ 1, 'asc' ]]
                });

        $("#tabla_revision_comisiones tbody").on("click", ".mas_opciones_8", function(){
            var tr = $(this).closest('tr');
            var row = tabla_revision.row( tr );

            $("#modal_nuevas .modal-body").html("");
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>ASESOR:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p> </div></div>');
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-6"><p>PLAN DE PAGO:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div><div class="col-lg-6"><p>NOMBRE LOTE:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div></div>');
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-6"><p>VENTA:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div><div class="col-lg-6"><p>COMISIÓN $:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div></div>');
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>MEDIO(S) DE VENTA:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div></div>');
            $("#modal_nuevas").modal();
        });


    });

// FIN TABLA PROCESO


// INICIO TABLA EN PAGADAS

  $("#tabla_pagadas_comisiones").ready( function(){

  $('#tabla_pagadas_comisiones thead tr:eq(0) th').each( function (i) {
   if( i!=0 && i!=10){
    var title = $(this).text();


    $(this).html('<input type="text" style="width:100%; background: #003D82; color: white; border: 0; font-weight: 500"  placeholder="'+title+'"/>' );
    $( 'input', this ).on('keyup change', function () {

        if (tabla_pagadas.column(i).search() !== this.value ) {
            tabla_pagadas
            .column(i)
            .search(this.value)
            .draw();

            var total = 0;
            var index = tabla_pagadas.rows({ selected: true, search: 'applied' }).indexes();
            var data = tabla_pagadas.rows( index ).data();

            $.each(data, function(i, v){
                total += parseFloat(v.pago_cliente);
            });
            var to1 = formatMoney(total);
            document.getElementById("myText_pagadas").value = formatMoney(total);
        }
    } );
}
});

  $('#tabla_pagadas_comisiones').on('xhr.dt', function ( e, settings, json, xhr ) {
    var total = 0;
    $.each(json.data, function(i, v){
        total += parseFloat(v.pago_cliente);
    });
    var to = formatMoney(total);
    document.getElementById("myText_pagadas").value = to;
});


        tabla_pagadas = $("#tabla_pagadas_comisiones").DataTable({
            dom: '<"clear">',
            width: 'auto',

            "language":{ "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
            "processing": true,
            "pageLength": 10,
            "bAutoWidth": false,
            "bLengthChange": false,
            "scrollX": true,
            "bInfo": false,
            "searching": true,
            "ordering": false,
            "fixedColumns": true,
            "ordering": false,
            
            "columns": [

            {  "width": "4%",
            "data": function( d ){
                    return '<p style="font-size: .8em">'+d.id_pago_i+'</p>';
                }},

 // y("SELECT pci1.id_comision, lo.total precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus, com.fecha_creacion, pci1.id_usuario, oxcpj.nombre as pj_name, cl.personalidad_juridica, u.forma_pago, f.id_comision as factura 
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em"><b>'+d.proyecto+'</b><br>'+d.lote+'</p>';
                }
            },
            {
                "width": "8%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.precio_lote)+'</p>';
                }
            },
             {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.comision_total)+' </p>';
                }
            },

            {
                "width": "8%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+formatMoney(d.porcentaje_decimal)+'%</p>';
                }
            },
           {
                "width": "9%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.pago_neodata)+'</p>';
                }
            },
             {
                "width": "9%",
                "data": function( d ){
                    return '<p style="font-size: .8em"><b>$'+formatMoney(d.pago_cliente)+'</b></p>';
                }
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.pagado)+'</p>';
                }
            },
             {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.restante)+'</p>';
                }
            },
             
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.lugar_prosp+'</p>';
                }
            },

            {
                "width": "10%",
                "orderable": false,
                "data": function( d ){
                    // return '<p style="font-size: .8em">'+d.estado_fecha+'</p>';
                    return '<p style="font-size: .8em"><span class="label" style="background:#A41760;">revisión INTERNOMEX</span></p>';
                }
                 
            },
 
            {
                "width": "12%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.fecha_creacion+'</p>';
                }
            }
            ],
            columnDefs: [

{

    orderable: false,
    className: 'select-checkbox',
    targets:   0,
    'searchable':false,
    'className': 'dt-body-center'
    }],



            "ajax": {
                "url": url2 + "Comisiones/getDatosComisionesPorPagar",/*registroCliente/getregistrosClientes*/
                    "type": "POST",
                    cache: false,
                    "data": function( d ){}},
                    "order": [[ 1, 'asc' ]]
                });

        $("#tabla_pagadas_comisiones tbody").on("click", ".mas_opciones_8", function(){
            var tr = $(this).closest('tr');
            var row = tabla_pagadas.row( tr );

            $("#modal_nuevas .modal-body").html("");
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>ASESOR:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p> </div></div>');
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-6"><p>PLAN DE PAGO:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div><div class="col-lg-6"><p>NOMBRE LOTE:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div></div>');
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-6"><p>VENTA:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div><div class="col-lg-6"><p>COMISIÓN $:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div></div>');
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>MEDIO(S) DE VENTA:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div></div>');
            $("#modal_nuevas").modal();
        });

    });

// FIN TABLA PAGADAS


// INICIO TABLA OTRAS

  $("#tabla_otras_comisiones").ready( function(){

  $('#tabla_otras_comisiones thead tr:eq(0) th').each( function (i) {
   if( i!=0 && i!=10){
    var title = $(this).text();


    $(this).html('<input type="text" style="width:100%; background: #003D82; color: white; border: 0; font-weight: 500"  placeholder="'+title+'"/>' );
    $( 'input', this ).on('keyup change', function () {

        if (tabla_otras.column(i).search() !== this.value ) {
            tabla_otras
            .column(i)
            .search(this.value)
            .draw();

            var total = 0;
            var index = tabla_otras.rows({ selected: true, search: 'applied' }).indexes();
            var data = tabla_otras.rows( index ).data();

            $.each(data, function(i, v){
                total += parseFloat(v.pago_cliente);
            });
            var to1 = formatMoney(total);
            document.getElementById("myText_otras").value = formatMoney(total);
        }
    } );
}
});

  $('#tabla_otras_comisiones').on('xhr.dt', function ( e, settings, json, xhr ) {
    var total = 0;
    $.each(json.data, function(i, v){
        total += parseFloat(v.pago_cliente);
    });
    var to = formatMoney(total);
    document.getElementById("myText_otras").value = to;
});


        tabla_otras = $("#tabla_otras_comisiones").DataTable({
            dom: '<"clear">',
            width: 'auto',

            "language":{ "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
            "processing": true,
            "pageLength": 10,
            "bAutoWidth": false,
            "bLengthChange": false,
            "scrollX": true,
            "bInfo": false,
            "searching": true,
            "ordering": false,
            "fixedColumns": true,
            "ordering": false,
            "columns": [

            {  "width": "4%",
            "data": function( d ){
                    return '<p style="font-size: .8em">'+d.id_pago_i+'</p>';
                }},

 // y("SELECT pci1.id_comision, lo.total precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus, com.fecha_creacion, pci1.id_usuario, oxcpj.nombre as pj_name, cl.personalidad_juridica, u.forma_pago, f.id_comision as factura 
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em"><b>'+d.proyecto+'</b><br>'+d.lote+'</p>';
                }
            },
            {
                "width": "8%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.precio_lote)+'</p>';
                }
            },
             {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.comision_total)+' </p>';
                }
            },

            {
                "width": "8%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+formatMoney(d.porcentaje_decimal)+'%</p>';
                }
            },
           {
                "width": "9%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.pago_neodata)+'</p>';
                }
            },
             {
                "width": "9%",
                "data": function( d ){
                    return '<p style="font-size: .8em"><b>$'+formatMoney(d.pago_cliente)+'</b></p>';
                }
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.pagado)+'</p>';
                }
            },
             {
                "width": "10%",
                "data": function( d ){

                    if(d.restante==0){
                         return '<p style="font-size: .8em">$'+formatMoney(d.comision_total)+'</p>';
                    }
                    else{
                        return '<p style="font-size: .8em">$'+formatMoney(d.restante)+'</p>';
                    }
                   
                }
            },
             
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.lugar_prosp+'</p>';
                }
            },

            {
                "width": "10%",
                "orderable": false,
                "data": function( d ){
                    // return '<p style="font-size: .8em">'+d.estado_fecha+'</p>';
                    return '<p style="font-size: .8em"><span class="label" style="background:#D5B226;">PAUSADA</span></p>';
                }
                 
            },
 
            {
                "width": "12%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.fecha_creacion+'</p>';
                }
            }
            ],
            columnDefs: [

{

    orderable: false,
    className: 'select-checkbox',
    targets:   0,
    'searchable':false,
    'className': 'dt-body-center'
    }],



            "ajax": {
                "url": url2 + "Comisiones/getDatosComisionesOtras",/*registroCliente/getregistrosClientes*/
                    "type": "POST",
                    cache: false,
                    "data": function( d ){}},
                    "order": [[ 1, 'asc' ]]
                });

        $("#tabla_otras_comisiones tbody").on("click", ".mas_opciones_8", function(){
            var tr = $(this).closest('tr');
            var row = tabla_otras.row( tr );

            $("#modal_nuevas .modal-body").html("");
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>ASESOR:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p> </div></div>');
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-6"><p>PLAN DE PAGO:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div><div class="col-lg-6"><p>NOMBRE LOTE:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div></div>');
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-6"><p>VENTA:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div><div class="col-lg-6"><p>COMISIÓN $:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div></div>');
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>MEDIO(S) DE VENTA:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div></div>');
            $("#modal_nuevas").modal();
        });


    });

// FIN TABLA PAGADAS







    // FUNCTION MORE

    $(window).resize(function(){
        tabla_nuevas.columns.adjust();
        tabla_revision.columns.adjust();
        tabla_pagadas.columns.adjust();
        tabla_otras.columns.adjust();
    });

    function formatMoney( n ) {
        var c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };

    $(document).on( "click", ".subir_factura", function(){
        resear_formulario();
        id_comision = $(this).val();
        link_post = "Comisiones/guardar_solicitud/"+id_comision;
        $("#modal_formulario_solicitud").modal( {backdrop: 'static', keyboard: false} );
        });




    //FUNCION PARA LIMPIAR EL FORMULARIO CON DE PAGOS A PROVEEDOR.
    function resear_formulario(){
        $("#modal_formulario_solicitud input.form-control").prop("readonly", false).val("");
        $("#modal_formulario_solicitud textarea").html('');

        $("#modal_formulario_solicitud #obse").val('');
 
        var validator = $( "#frmnewsol" ).validate();
        validator.resetForm();
        $( "#frmnewsol div" ).removeClass("has-error");

    }
 
    $("#cargar_xml").click( function(){
            subir_xml( $("#xmlfile") );
        });







    var justificacion_globla = "";

        function subir_xml( input ){

            var data = new FormData();
            documento_xml = input[0].files[0];
            var xml = documento_xml;

            data.append("xmlfile", documento_xml);
 
            resear_formulario();

            $.ajax({
                url: url + "Comisiones/cargaxml",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data){

                     if( data.respuesta[0] ){

                        documento_xml = xml;

                        var informacion_factura = data.datos_xml;
                        
                        cargar_info_xml( informacion_factura );
                        $("#solobs").val( justificacion_globla );

 
                    }else{
                        input.val('');
                        alert( data.respuesta[1] );
                    }
                },
                error: function( data ){
                    input.val('');
                    alert("ERROR INTENTE COMUNICARSE CON EL PROVEEDOR");
                }
            });

        }








    function cargar_info_xml( informacion_factura ){

        // alert(informacion_factura);



 

        $("#emisor").val( ( informacion_factura.nameEmisor ? informacion_factura.nameEmisor[0] : '') ).attr('readonly',true);
        $("#rfcemisor").val( ( informacion_factura.rfcemisor ? informacion_factura.rfcemisor[0] : '') ).attr('readonly',true);


        $("#receptor").val( ( informacion_factura.namereceptor ? informacion_factura.namereceptor[0] : '') ).attr('readonly',true);
        $("#rfcreceptor").val( ( informacion_factura.rfcreceptor ? informacion_factura.rfcreceptor[0] : '') ).attr('readonly',true);


        $("#regimenFiscal").val( ( informacion_factura.regimenFiscal ? informacion_factura.regimenFiscal[0] : '') ).attr('readonly',true);

        $("#formaPago").val( ( informacion_factura.formaPago ? informacion_factura.formaPago[0] : '') ).attr('readonly',true);
        $("#total").val( ('$ '+informacion_factura.total ? '$ '+informacion_factura.total[0] : '') ).attr('readonly',true);

        $("#cfdi").val( ( informacion_factura.usocfdi ? informacion_factura.usocfdi[0] : '') ).attr('readonly',true);

        $("#metodopago").val( ( informacion_factura.metodoPago ? informacion_factura.metodoPago[0] : '') ).attr('readonly',true);

        $("#unidad").val( ( informacion_factura.claveUnidad ? informacion_factura.claveUnidad[0] : '') ).attr('readonly',true);

        $("#clave").val( ( informacion_factura.claveProdServ ? informacion_factura.claveProdServ[0] : '') ).attr('readonly',true);

        $("#obse").val( ( informacion_factura.descripcion ? informacion_factura.descripcion[0] : '') ).attr('readonly',true);
  

       
 
        
    }




 // id_comision = id_comision;

    $("#frmnewsol").submit( function(e) {
        e.preventDefault();
    }).validate({
        submitHandler: function( form ) {
 
                    var data = new FormData( $(form)[0] );
                    // data.append("id_comision", id_comision);
                    data.append("xmlfile", documento_xml);

                    // if( !$("#proveedor").prop("disabled") ){
                    //     data.append("idproveedor", $("#proveedor").val());
                    // }
                    
                    // data.append("descr", $("#descr").val());

                    $.ajax({
                        url: url + link_post,
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        method: 'POST',
                        type: 'POST', // For jQuery < 1.9
                        success: function(data){
                            if( data.resultado ){
                                alert("LA FACTURA SE SUBIO CORRECTAMENTE");
                                 $("#modal_formulario_solicitud").modal( 'toggle' );
                                 tabla_nuevas.ajax.reload();
                            }else{
                                alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                            }
                        },error: function( ){
                            alert("ERROR EN EL SISTEMA");
                        }
                    });

             
        }
    });








// location.reload();



    function preview_info(archivo){
    $("#documento_preview .modal-dialog").html("");
    $("#documento_preview").css('z-index', 9999);
    archivo = url+"dist/documentos/"+archivo+"";
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


function cleanComments()
{

    var myCommentsList = document.getElementById('documents');
    myCommentsList.innerHTML = '';

    var myFactura = document.getElementById('facturaInfo');
    myFactura.innerHTML = '';
  

}


function fillFields (v) {

    // alert(v.nombre);




}



 

</script>

