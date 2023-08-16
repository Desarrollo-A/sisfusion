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

    :root {
        --color-green: #00a878;
        --color-red: #fe5e41;
        --color-button: #fdffff;
        --color-black: #000;
        }
            .switch-button {
                display: inline-block;
            }
            .switch-button .switch-button__checkbox {
                display: none;
            }
            .switch-button .switch-button__label {
                background-color: var(--color-red);
                width: 5rem;
                height: 3rem;
                border-radius: 3rem;
                display: inline-block;
                position: relative;
            }
            .switch-button .switch-button__label:before {
                transition: .2s;
                display: block;
                position: absolute;
                width: 3rem;
                height: 3rem;
                background-color: var(--color-button);
                content: '';
                border-radius: 50%;
                box-shadow: inset 0px 0px 0px 1px var(--color-black);
            }
            .switch-button .switch-button__checkbox:checked + .switch-button__label {
                background-color: var(--color-green);
            }
            .switch-button .switch-button__checkbox:checked + .switch-button__label:before {
                transform: translateX(2rem);
            }

            .dropdown-toggle{
                background-color: #eaeaea!important;
                color: #333!important;
            }
 
</style>

<!--<div class="modal fade modal-alertas" id="modal_users" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
       
            <form method="post" id="form_interes">
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>-->

<div class="modal fade modal-alertas" id="modal_colaboradores" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
       
            <form method="post" id="form_colaboradores">
                <div class="modal-body"></div>
                <div class="modal-footer"></div>
            </form>

        </div>
    </div>
</div>

<!--<div class="modal fade modal-alertas" id="modal_mktd" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">EDITAR INFORMACIÓN</h4>
            </div>
            <form method="post" id="form_MKTD">
                <div class="modal-body"></div>
                <div class="modal-footer"></div>
            </form>
        </div>
    </div>
</div>-->

<!--<div class="modal fade modal-alertas" id="modalParcialidad" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">SOLICITAR PARCIALIDAD DE PAGO</h4>
            </div>
            <form method="post" id="form_parcialidad">
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>-->
 
<!--<div class="modal fade" id="seeInformationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons" onclick="cleanComments()">clear</i>
                </button>
                <h4 class="modal-title">Consulta información</h4>
            </div>
            <div class="modal-body">
                <div role="tabpanel">-->
                    <!-- Nav tabs -->
                    <!--<ul class="nav nav-tabs" role="tablist" style="background: #003d82;">
                        <li role="presentation" class="active"><a href="#documents" aria-controls="documents" role="tab" data-toggle="tab">Documentación</a></li>
                        <li role="presentation"><a href="#facturaInfo" aria-controls="facturaInfo" role="tab" data-toggle="tab">Datos factura</a></li>
                        <li role="presentation"><a href="#changelogTab" aria-controls="changelogTab" role="tab" data-toggle="tab">Bitácora de cambios</a></li>
                    </ul>-->
                    <!-- Tab panes -->
                    <!--<div class="tab-content">
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
</div>-->

<!--<div class="modal fade modal-alertas" id="modal_documentacion" role="dialog">
        <div class="modal-dialog" style="width:800px; margin-top:20px">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                    </div>
                </div>
            </div>
        </div>
    </div>-->

<!--<div class="modal fade bd-example-modal-sm" id="myModalEnviadas" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
  </div>
</div>-->

<!--<div class="modal fade modal-alertas" id="documento_preview" role="dialog">
    <div class="modal-dialog" style= "margin-top:20px;"></div>
</div>-->

<!--<div id="modal_formulario_solicitud" class="modal" style="position:fixed; top:0; left:0; margin-bottom: 1%;  margin-top: -5%;">
        <div class="modal-dialog modal-md">

        <div class="modal-content">
            <div class="modal-body">
                <div class="tab-content">
                     <div class="active tab-pane" id="generar_solicitud">
                        <div class="row">
                            <div class="col-lg-12">
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
                                            <button type="submit" class="btn btn-primary btn-block save">GUARDAR</button>
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
</div>-->


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
                                            <span class="material-icons">pin_drop</span><br>PLAZA  1
                                            </a>
                                        </li>

                                        <li style="margin-right: 50px;">
                                            <a href="#proceso-1" role="tab" data-toggle="tab">
                                            <span class="material-icons">pin_drop</span><br>PLAZA  2
                                            </a>
                                        </li>

                                        <!-- <li style="margin-right: 50px;">
                                            <a href="#planes-1" role="tab" data-toggle="tab">
                                            <span class="material-icons">content_paste</span><br>PLANES
                                            </a>
                                        </li> -->
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

                                                                <div class="col xol-xs-8 col-sm-8 col-md-8 col-lg-8">
                                                                    <h4 class="card-title">COMISIONES NUEVAS PLAZA 1</h4>
                                                                <p class="category">Comisiones disponibles para dispersar el pago dentro de las sedes, Querétaro, San Luis Potosí y León.</p>
                                                                <p class="estado_horario"></p>

                                                            </div>

                                                                <div class="col xol-xs-4 col-sm-4 col-md-4 col-lg-4"><br>
                                                                    <label style="color: #0a548b;">&nbsp;Disponible: $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text"  name="myText_nuevas" id="myText_nuevas"></label>
                                                                </div>

                                                            </div>
                                                            <div class="card-content">
                                                                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <div class="material-datatables">
                                                                    <div class="form-group">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-responsive table-bordered table-striped table-hover" id="tabla_plaza_1" name="tabla_plaza_1">
                                                                                <thead>
                                                                                <tr>
                                                                                <th style="font-size: .8em;">LOTE</th>
                                                                                        <th style="font-size: .8em;">ID PAGO</th>
                                                                                        <th style="font-size: .8em;">LOTE</th>
                                                                                        <th style="font-size: .8em;">PRECIO LOTE</th>
                                                                                        <th style="font-size: .8em;">TOTAL COM. ($)</th>
                                                                                        <th style="font-size: .8em;">COM %.</th>
                                                                                        <th style="font-size: .8em;">PAGO CLIENTE</th>
                                                                                        <th style="font-size: .8em;">ABONO NEO.</th>
                                                                                        <th style="font-size: .8em;">PAGADO</th>
                                                                                        <th style="font-size: .8em;">PENDIENTE</th>
                                                                                        <th style="font-size: .8em;">FECHA APARTADO</th>
                                                                                        <th style="font-size: .8em;">SEDE</th>
                                                                                        <th style="font-size: .8em;">TIPO</th>
                                                                                        <!-- <th style="font-size: .8em;"></th> -->
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
                                                                    <h4 class="card-title">COMISIONES PLAZA 2</h4>
                                                                    <p class="category">Comisiones disponibles para dispersar el pago dentro de las sedes, Ciudad de México, Mérida, Cancún.</p></div>

                                                                <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6"><br>
                                                                    <label style="color: #0a548b;">&nbsp;Total: $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text" name="myText_proceso" id="myText_proceso"></label>
                                                                </div>
                                                            </div>
                                                            <div class="card-content">
                                                                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <div class="material-datatables">
                                                                    <div class="form-group">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-responsive table-bordered table-striped table-hover" id="tabla_plaza_2" name="tabla_plaza_2">
                                                                                <thead>
                                                                                    <tr>
                                                                                    <th style="font-size: .8em;">LOTE</th>
                                                                                        <th style="font-size: .8em;">ID PAGO</th>
                                                                                        <th style="font-size: .8em;">LOTE</th>
                                                                                        <th style="font-size: .8em;">PRECIO LOTE</th>
                                                                                        <th style="font-size: .8em;">TOTAL COM. ($)</th>
                                                                                        <th style="font-size: .8em;">COM %.</th>
                                                                                        <th style="font-size: .8em;">PAGO CLIENTE</th>
                                                                                        <th style="font-size: .8em;">ABONO NEO.</th>
                                                                                        <th style="font-size: .8em;">PAGADO</th>
                                                                                        <th style="font-size: .8em;">PENDIENTE</th>
                                                                                        <th style="font-size: .8em;">FECHA APARTADO</th>
                                                                                        <th style="font-size: .8em;">SEDE</th>
                                                                                        <th style="font-size: .8em;">TIPO</th>
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
                                    
                                    <!-- /////////////// -->

                                
                                    <!-- ///////////////// -->

                                    <div class="tab-pane" id="planes-1">
                                        <div class="content">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col xol-xs-8 col-sm-8 col-md-8 col-lg-8">
                                                        <div class="card">
                                                            <div class="card-header">

                                                                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <h4 class="card-title">HISTORIAL DE PLANES</h4>
                                                                <p class="category">Historial de planes de pago de comisiones para Marketing Digital.</p></div>

                                                            </div>
                                                            <div class="card-content">
                                                                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <div class="material-datatables">
                                                                    <div class="form-group">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-responsive table-bordered table-striped table-hover" id="tabla_planes" name="tabla_planes">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th style="font-size: .8em;">ID</th>
                                                                                        <th style="font-size: .8em;">FECHA INICIO</th>
                                                                                        <!-- <th style="font-size: .8em;">FECHA FIN</th> -->
                                                                                        <th style="font-size: .8em;">FECHA FIN</th>
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

                                                    <div class="col xol-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                        <div class="card">
                                                            <div class="card-header">
                                                            <p class="category">Registrar nuevo plan de pago de comisiones</p>
                                                        </div>
                                                            <div class="card-content">
                                                                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <div class="material-datatables">
                                                                    <div class="form-group">

                                                                    <input type="button" class="btn btn-success nuevo_plan" value="NUEVO PLAN">

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

    $("#tabla_plaza_1").ready( function(){
     
let titulos = [];
$('#tabla_plaza_1 thead tr:eq(0) th').each( function (i) {
 if( i!=0 && i!=13){
  var title = $(this).text();

  titulos.push(title);

  $(this).html('<input type="text" style="width:100%; background: #003D82; color: white; border: 0; font-weight: 500" id="t-'+i+'"  placeholder="'+title+'"/>' );
  $( 'input', this ).on('keyup change', function () {
      if (plaza_1.column(i).search() !== this.value ) {
          plaza_1
          .column(i)
          .search(this.value)
          .draw();
          
        //  titulos[i]= title;
          var total = 0;
          var index = plaza_1.rows({ selected: true, search: 'applied' }).indexes();
          var data = plaza_1.rows( index ).data();

          $.each(data, function(i, v){
              total += parseFloat(v.pago_cliente);
          });
          var to1 = formatMoney(total);
          document.getElementById("myText_nuevas").value = formatMoney(total);
      }
  } );
}
});
console.log(titulos);
let c=0;
          $('#tabla_plaza_1').on('xhr.dt', function ( e, settings, json, xhr ) {
              var total = 0;
              
              $.each(json.data, function(i, v){
                  total += parseFloat(v.pago_cliente);
              });
              var to = formatMoney(total);
              document.getElementById("myText_nuevas").value = to;
          });

      plaza_1 = $("#tabla_plaza_1").DataTable({
          dom: "Bfrtip",
          "buttons": [
      {
          extend: 'excelHtml5',
          text: ' Descargar Excel',
          className: 'btn btn-success',
          titleAttr: 'Excel',
          exportOptions: {
              columns: [0,1,2,3,4,5,6,7,8,9,10,11,12],
              format: {
                 header:  function (d, columnIdx) {
                     if(columnIdx == 0){
                         return ' '+d +' ';
                        }else if(columnIdx == 10){
                            return ' '+d +' ';
                        }
                        else if(columnIdx != 10 && columnIdx !=0){
                            if(columnIdx == 11){
                                return 'SEDE ';
                            }
                            if(columnIdx == 12){
                                return 'TIPO'
                            }
                            else{
                                return ' '+titulos[columnIdx-1] +' ';
                            }
                        }
                    }
                }
            }
        }
    ],
        width: 'auto',
        "language":{ url: "../static/spanishLoader.json" },
        "pageLength": 10,
        "bAutoWidth": false,
        "fixedColumns": true,
        "ordering": false,
        "columns": [
            {  
                "width": "4%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.id_lote+'</p>';
                }
            },
            {  
                "width": "4%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.id_pago_i+'</p>';
                }
            },
            {
                "width": "9%",
                "data": function( d ){
                    return '<p style="font-size: .8em"><b>'+d.proyecto+'</b><br>'+d.lote+'</p>';
                }
            },
            {
                "width": "7%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.precio_lote)+'</p>';
                }
            },
            {
                "width": "7%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.comision_total)+' </p>';
                }
            },
            {
                "width": "7%",
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
                "width": "8%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.pagado)+'</p>';
                }
            },
            {
                "width": "8%",
                "data": function(d) {
                    if (d.restante == null || d.restante == '') {
                        return '<p style="font-size: .8em">$' + formatMoney(d.comision_total) + '</p>';
                    } else {
                        return '<p style="font-size: .8em">$' + formatMoney(d.restante) + '</p>';
                    }
                }
            },
            {
                "width": "8%",
                "data": function( d ){
                    let fech = d.fechaApartado;
                    let fecha = fech.substr(0, 10);
                    let nuevaFecha = fecha.split('-');
                    return '<p style="font-size: .8em">'+nuevaFecha[2]+'-'+nuevaFecha[1]+'-'+nuevaFecha[0]+'</p>';
                }
            },
            {
                "width": "8%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.nombre+'</p>';
                }
            },
            {
                "width": "12%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.lugar_prosp+'</p>';
                }
            },
            {
                "width": "10%",
                "orderable": false,
                "data": function( d ){
                    return '<button class="btn btn-round btn-fab btn-fab-mini aprobar_solicitud" title="PARCIALIDAD" value="' + d.id_pago_i +'" data-value="' + d.id_sede +'" style="margin-right: 3px;color:#fff; background:#FBCF5B;"><i class="material-icons">done</i></button>';   
              }
            }
          ],
          columnDefs: [{
              orderable: false,
              className: 'select-checkbox',
              targets:   0,
              'searchable':false,
              'className': 'dt-body-center'
            }],
            "ajax": {
              "url": url2 + "Comisiones/getDatosNuevasMktd_pre",/*registroCliente/getregistrosClientes*/
                  "type": "POST",
                  cache: false,
                  "data": function( d ){}},
                  "order": [[ 1, 'asc' ]]
              });

      $("#tabla_plaza_1 tbody").on("click", ".aprobar_solicitud", function(){
          var tr = $(this).closest('tr');
          var row = plaza_1.row( tr );
          let c=0;
          $("#modal_colaboradores .modal-body").html("");
          $("#modal_colaboradores .modal-footer").html("");
          $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Desea aprobar la solicitud del lote: <b>'+row.data().lote+'</b> por la cantidad de: <b>$'+formatMoney(row.data().pago_cliente)+'</b>?</p> </div></div>');
          $("#modal_colaboradores .modal-body").append('<input type="hidden" id="id_pago" name="pago_id" value="'+row.data().id_pago_i+'">');
          $("#modal_colaboradores .modal-body").append('<input type="hidden" id="id_comision" name="com_value" value="'+row.data().id_comision+'">');
          $("#modal_colaboradores .modal-body").append('<input type="hidden" name="pago_mktd" id="pago_mktd" value="'+row.data().pago_cliente+'">');
          $("#modal_colaboradores .modal-footer").append('<br><div class="row"><div class="col-md-6"><center><input type="submit" class="btn btn-success" value="Aprobar"></center></div><div class="col-md-6"><center><input type="button" class="btn btn-danger"  data-dismiss="modal" value="CANCELAR"></center></div></div>');
          $("#modal_colaboradores").modal();
        });

//FIN TABLA NUEVA
/**--------------------------------------------------------------------------------------------------------------------------------------- */
// INICIO TABLA EN PROCESO

  $("#tabla_plaza_2").ready( function(){
let titulos = [];
  $('#tabla_plaza_2 thead tr:eq(0) th').each( function (i) {
   if( i!=0 && i!=13){
    var title = $(this).text();
    titulos.push(title);

    $(this).html('<input type="text" style="width:100%; background: #003D82; color: white; border: 0; font-weight: 500"  placeholder="'+title+'"/>' );
    $( 'input', this ).on('keyup change', function () {

        if (plaza_2.column(i).search() !== this.value ) {
            plaza_2
            .column(i)
            .search(this.value)
            .draw();

            var total = 0;
            var index = plaza_2.rows({ selected: true, search: 'applied' }).indexes();
            var data = plaza_2.rows( index ).data();

            $.each(data, function(i, v){
                total += parseFloat(v.pago_cliente);
            });
            var to1 = formatMoney(total);
            document.getElementById("myText_proceso").value = formatMoney(total);
        }
    } );
}
});
let c=0;
            $('#tabla_plaza_2').on('xhr.dt', function ( e, settings, json, xhr ) {
                var total = 0;
                $.each(json.data, function(i, v){
                    total += parseFloat(v.pago_cliente);
                });
                var to = formatMoney(total);
                document.getElementById("myText_proceso").value = to;
            });


        plaza_2 = $("#tabla_plaza_2").DataTable({
             dom: "Bfrtip",
             "buttons": [
      {
          extend: 'excelHtml5',
          text: ' Descargar Excel',
          className: 'btn btn-success',
          titleAttr: 'Excel',
          exportOptions: {
              columns: [0,1,2,3,4,5,6,7,8,9,10,11,12],
              format: {
                 header:  function (d, columnIdx) {
                     if(columnIdx == 0){
                         return ' '+d +' ';
                        }else if(columnIdx == 10){
                            return ' '+d +' ';
                        }
                        else if(columnIdx != 10 && columnIdx !=0){
                            if(columnIdx == 11){
                                return 'SEDE ';
                            }
                            if(columnIdx == 12){
                                return 'TIPO'
                            }
                            else{
                                return ' '+titulos[columnIdx-1] +' ';
                            }
                        }
                    }
                }
            }
        }
    ],
        width: 'auto',
"language":{ url: "../static/spanishLoader.json" },
 
"pageLength": 10,
"bAutoWidth": false,
"fixedColumns": true,
"ordering": false,
"columns": [

            {  "width": "4%",
            "data": function( d ){
                    return '<p style="font-size: .8em">'+d.id_lote+'</p>';
                }},
                {  "width": "4%",
            "data": function( d ){
                    return '<p style="font-size: .8em">'+d.id_pago_i+'</p>';
                }},
            {
                "width": "9%",
                "data": function( d ){
                    return '<p style="font-size: .8em"><b>'+d.proyecto+'</b><br>'+d.lote+'</p>';
                }
            },
            {
                "width": "7%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.precio_lote)+'</p>';
                }
            },
             {
                "width": "7%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.comision_total)+' </p>';
                }
            },
            {
                "width": "7%",
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
                "width": "8%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.pagado)+'</p>';
                }
            },
             {
                "width": "8%",
                "data": function(d) {
                    if (d.restante == null || d.restante == '') {
                        return '<p style="font-size: .8em">$' + formatMoney(d.comision_total) + '</p>';
                    } else {
                        return '<p style="font-size: .8em">$' + formatMoney(d.restante) + '</p>';
                    }
                }
            },

            {
                "width": "8%",
                "data": function( d ){
                    let fech = d.fechaApartado;
       let fecha = fech.substr(0, 10);

       let nuevaFecha = fecha.split('-');
        return '<p style="font-size: .8em">'+nuevaFecha[2]+'-'+nuevaFecha[1]+'-'+nuevaFecha[0]+'</p>';
                }
            },
             
            {
                "width": "8%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.nombre+'</p>';
                }
            },
 
            {
                "width": "12%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.lugar_prosp+'</p>';
                }
            },
            {
                "width": "10%",
                "orderable": false,
                "data": function( d ){
                    return '<button class="btn btn-round btn-fab btn-fab-mini aprobar_solicitud" title="PARCIALIDAD" value="' + d.id_pago_i +'" data-value="' + d.id_sede +'" style="margin-right: 3px;color:#fff; background:#FBCF5B;"><i class="material-icons">done</i></button>';
                     
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
                "url": url2 + "Comisiones/getDatosNuevasMktd2_pre",/*registroCliente/getregistrosClientes*/
                    "type": "POST",
                    cache: false,
                    "data": function( d ){}},
                    "order": [[ 1, 'asc' ]]
                });

         

         $("#tabla_plaza_2 tbody").on("click", ".aprobar_solicitud", function(){
            var tr = $(this).closest('tr');
            var row = plaza_2.row( tr );
            let c=0;
            $("#modal_colaboradores .modal-body").html("");
            $("#modal_colaboradores .modal-footer").html("");
            $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Desea aprobar la solicitud del lote: <b>'+row.data().lote+'</b> por la cantidad de: <b>$'+formatMoney(row.data().pago_cliente)+'</b>?</p> </div></div>');
            $("#modal_colaboradores .modal-body").append('<input type="hidden" id="id_pago" name="pago_id" value="'+row.data().id_pago_i+'">');
            $("#modal_colaboradores .modal-body").append('<input type="hidden" id="id_comision" name="com_value" value="'+row.data().id_comision+'">');
            $("#modal_colaboradores .modal-body").append('<input type="hidden" name="pago_mktd" id="pago_mktd" value="'+row.data().pago_cliente+'">');
            $("#modal_colaboradores .modal-footer").append('<br><div class="row"><div class="col-md-6"><center><input type="submit" class="btn btn-success" value="Aprobar"></center></div><div class="col-md-6"><center><input type="button" class="btn btn-danger"  data-dismiss="modal" value="CANCELAR"></center></div></div>');
            $("#modal_colaboradores").modal();
            });

       });





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


    $("#form_colaboradores").submit( function(e) {
        e.preventDefault();
        var id_pago = $('#id_pago').val();
        var id_comision=$('#id_comision').val();
        $.ajax({
            type: "POST",
            url: url2 + "Comisiones/aprobar_comision",
            data: {id_pago: id_pago, id_comision: id_comision},
            dataType: 'json',
            success: function(data){
                    // if(true){
                    //     $('#loader').addClass('hidden');
                        $("#modal_colaboradores").modal('toggle');
                        plaza_2.ajax.reload();
                        plaza_1.ajax.reload();
                        alert("¡Se agregó con éxito!");
                    // }else{
                    //     alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                    //     $('#loader').addClass('hidden');
                    // }
            },error: function( ){
                alert("ERROR EN EL SISTEMA");
            }
        });
          
    })
 


// location.reload();





/*function cleanComments()
{
    var myCommentsList = document.getElementById('documents');
    myCommentsList.innerHTML = '';

    var myFactura = document.getElementById('facturaInfo');
    myFactura.innerHTML = '';
  
}*/


/*function fillFields (v) {
    // alert(v.nombre);
}*/

$(window).resize(function(){
        plaza_1.columns.adjust();
        plaza_2.columns.adjust();
      
    });


$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
           $($.fn.dataTable.tables(true)).DataTable()
           .columns.adjust();
           //.responsive.recalc();
    });
</script>
