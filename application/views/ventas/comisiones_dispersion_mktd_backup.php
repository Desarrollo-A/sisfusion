<body>
<div class="wrapper">
<?php
if($this->session->userdata('id_rol')=="18")//sistemas
{
    $datos = array();
    $datos = $datos4;
    $datos = $datos2;
    $datos = $datos3;  
    $this->load->view('template/sidebar', $datos);
}
else if($this->session->userdata('id_rol')=="19" ||  $this->session->userdata('id_rol')=="20" ||$this->session->userdata('id_rol')=="21")//users  mktd
{
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
 
            .bkLoading
{
   /* background:#000; *//*b3b3b3*/
   background-image: linear-gradient(to bottom, #000, #000);
   position:absolute;
   top:0%;
   left:0%;
   width:100%;
   height:100%;
   z-index:99999;
   padding-top:200px;
   color:white;
   font-weight:300;
   opacity: 0.5;


   /* display:none; */
}
 </style>

<div class="modal fade modal-alertas" id="modal_users" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
       
            <form method="post" id="form_interes">
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade modal-alertas" id="modal_colaboradores" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
       
            <form method="post" id="form_colaboradores">
                <div class="modal-body"></div>
                <div class="modal-footer"></div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade modal-alertas" id="modal_mktd" role="dialog">
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
</div>

<div class="modal fade modal-alertas" id="modalParcialidad" role="dialog">
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

 <div id="modal_formulario_solicitud" class="modal" style="position:fixed; top:0; left:0; margin-bottom: 1%;  margin-top: -5%;">
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
                                            <span class="material-icons">pin_drop</span><br>PLAZA  1
                                            </a>
                                        </li>

                                        <li style="margin-right: 50px;">
                                            <a href="#proceso-1" role="tab" data-toggle="tab">
                                            <span class="material-icons">pin_drop</span><br>PLAZA  2
                                            </a>
                                        </li>

                                        <li style="margin-right: 50px;">
                                            <a href="#planes-1" role="tab" data-toggle="tab">
                                            <span class="material-icons">content_paste</span><br>PLANES
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

                                                                <div class="col xol-xs-8 col-sm-8 col-md-8 col-lg-8">
                                                                    <h4 class="card-title">COMISIONES NUEVAS PLAZA 1</h4>
                                                                <p class="category">Comisiones disponibles para dispersar el pago dentro de las sedes, Querétaro, San Luis Potosí y León.</p>
                                                                <p class="estado_horario"></p>

                                                            </div>

                                                                <div class="col xol-xs-4 col-sm-4 col-md-4 col-lg-4"><br>
                                                                    <label style="color: #0a548b;">&nbsp;Total: $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text"  name="myText_nuevas" id="myText_nuevas"></label>
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
                                                                                        <th style="font-size: .8em;">USUARIO</th>
                                                                                        <th style="font-size: .8em;">SEDE</th>
                                                                                        <th style="font-size: .8em;">NÚMERO PLAN</th>
                                                                                        <th style="font-size: .8em;">ESTATUS</th>
                                                                                        <th style="font-size: .8em;">TOTAL</th>
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
                                                                                        <th style="font-size: .8em;">USUARIO</th>
                                                                                        <th style="font-size: .8em;">SEDE</th>
                                                                                        <th style="font-size: .8em;">NÚMERO PLAN</th>
                                                                                        <th style="font-size: .8em;">ESTATUS</th>
                                                                                        <th style="font-size: .8em;">TOTAL</th>
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
                                                                    <h4 class="card-title">HISTORIAL DE PLANES mktd</h4>
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

<div class="bkLoading hide" id="loaderDiv">
   <div class="center-align">
      <img src="<?=base_url()?>static/images/cargando.gif" ><br>
      Este proceso puede demorar algunos segundos, espere por favor ...
   </div>
</div>
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
              total += parseFloat(v.total);
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
                  total += parseFloat(v.total);
              });
              var to = formatMoney(total);
              document.getElementById("myText_nuevas").value = to;
          });

      plaza_1 = $("#tabla_plaza_1").DataTable({
          dom: "Bfrtip",
          "buttons": [ 
      {
          extend: 'excelHtml5',
          text: 'Excel',
          className: 'btn btn-success',
          titleAttr: 'Excel',
          exportOptions: {
              columns: [0,1,2,3],
              format: {
                 header:  function (d, columnIdx) {
                     if(columnIdx == 0){
                         return ' '+d +' ';
                        }
                       
                                return ' '+titulos[columnIdx-1] +' ';
                          
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
                "width": "20%",
                "data": function( d ){
                    return '<p style="font-size: .8em">COMISIÓN - <b>'+d.nombre+' '+d.apellido_paterno+'</b></p>';
                }
            },
            {  
                "width": "20%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.sede+'</p>';
                }
            },
            {
                "width": "20%",
                "data": function( d ){
                    return '<p style="font-size: .8em">PLAN <b>'+d.id_plan+'</b></p>';
                }
            },
            {
                "width": "20%",
                "data": function( d ){
                    return '<span class="label" style="background:#4B94CC;">DISPONIBLE</span>';
                }
            },
           {
                "width": "20%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.total)+'</p>';
                }
            },
            {
                "width": "10%",
                "orderable": false,
                "data": function( d ){
                    return '<button class="btn btn-round btn-fab btn-fab-mini dispersar_colaboradores" title="PARCIALIDAD" value="' + d.id_plan +'" data-value="' + d.ubicacion_dos +'" style="margin-right: 3px;color:#fff; background:#FBCF5B;"><i class="material-icons">pie_chart</i></button>';   
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
              "url": url2 + "Comisiones/getDatosNuevasMktd",/*registroCliente/getregistrosClientes*/
                  "type": "POST",
                  cache: false,
                  "data": function( d ){}},
                  "order": [[ 1, 'asc' ]]
              });

      $("#tabla_plaza_1 tbody").on("click", ".dispersar_colaboradores", function(){
        // document.getElementById('btnplz1').disabled=false;
        $("#btnplz1").button({ disabled: false });

          var tr = $(this).closest('tr');
          var row = plaza_1.row( tr );
          let c=0;
         
          let ubication = $(this).attr("data-value");
          let plen = $(this).val();

          console.log(ubication);
          console.log(plen);
         
        //   $.getJSON( url + "Comisiones/getDatosSumaMktd/"+ubication).done( function( data01 ){
            $.getJSON( url + "Comisiones/getDatosSumaMktd/"+ubication+"/"+plen).done( function( data01 ){

            let suma_01 = parseFloat(data01[0].suma_f01);

            $("#modal_colaboradores .modal-body").html("");
          $("#modal_colaboradores .modal-footer").html("");
          $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p style="color:gray;font-size:16px;">Comisión total:&nbsp;&nbsp;<b>$'+formatMoney(suma_01)+'</b></p> </div></div>');
          $("#modal_colaboradores .modal-body").append('<input type="hidden" name="total_comi" value="'+data01[0].suma_f01+'">');
          $("#modal_colaboradores .modal-body").append('<input type="hidden" name="num_plan" value="'+plen+'">');
          $("#modal_colaboradores .modal-body").append('<input type="hidden" name="valores_pago_i" value="'+data01[0].valor_obtenido+'">');
          $("#modal_colaboradores .modal-body").append('<input type="hidden" name="pago_mktd" id="pago_mktd" value="'+parseFloat(suma_01)+'">');

          $.getJSON( url + "Comisiones/getDatosColabMktd/"+ubication+"/"+plen).done( function( data1 ){


            
               var_sum = 0;
              let fech = data1[0].fecha_plan;
              let fecha = fech.substr(0, 10);
              let nuevaFecha = fecha.split('-');
              let fechaCompleta = nuevaFecha[2]+'-'+nuevaFecha[1]+'-'+nuevaFecha[0];
              let fech2 = data1[0].fin_plan;
              let fecha2 = fech2.substr(0, 10);
              let nuevaFecha2 = fecha2.split('-');
              let fechaCompleta2 = nuevaFecha2[2]+'-'+nuevaFecha2[1]+'-'+nuevaFecha2[0];
              $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-4"><p style="color:blue; font-size:14px;">Número plan:&nbsp;&nbsp;<b>'+data1[0].id_plan+'</b></p> </div>  <div class="col-lg-4"><p style="color:green; font-size:14px;">Inicio:&nbsp;&nbsp;<b>'+fechaCompleta+'</b></p> </div>  <div class="col-lg-4"><p style="color:green; font-size:14px;">Fin:&nbsp;&nbsp;<b>'+fechaCompleta2+'</b></p> </div></div><br>');
              
              $.each( data1, function( i, v){
                  valor_money = ((v.porcentaje/100)*suma_01)
                  $("#modal_colaboradores .modal-body").append('<div class="row"><input type="hidden" name="user_mktd[]" value="'+v.id_usuario+'"><div class="col-md-5"><b style="font-size:14px;"><p>'+v.colaborador+'</p></b><p style="font-size:12px;">'+v.rol+'</p><br></div>'
                  +'<div class="col-md-2"><input type="text" name="porcentaje_mktd[]" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+v.porcentaje+'%'+'"></div>'+'<div class="col-md-1"><br><b><p style="text-align:right">$</p></b></div><div class="col-md-4"><input type="text" readonly name="abono_mktd[]" id="abono_mktd_'+i+'"  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+parseFloat(valor_money.toFixed(3))+'"></div>'
                  +'</div>');
                  var_sum +=  parseFloat(v.porcentaje);
                  c++;
                });

                var_sum2 = parseFloat(var_sum);

                 new_valll = parseFloat((suma_01)-((suma_01/100)*var_sum2));
                 new_valll2 = parseFloat((suma_01/100)*var_sum2);


                 console.log("suma "+var_sum2);
                 console.log("row_table "+suma_01);
                 console.log("new_val "+new_valll);
                 console.log("new_val2 "+new_valll2);
                  $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p>Comisión distribuida:&nbsp;&nbsp;<b>'+new_valll2.toFixed(3)+'</b></p> </div></div>');
                  $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p>Comisión restante:&nbsp;&nbsp;<b style="color:red;">'+new_valll.toFixed(3)+'</b></p> </div></div>');
                  $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p>Suma: <b id="Sumto" style="color:red;"></b></p> </div></div>');
                  $("#modal_colaboradores .modal-body").append('<input type="hidden" name="cuantos" id="cuantos" value="'+c+'">');
                });

           
 

      $("#modal_colaboradores .modal-footer").append('<br><div class="row"><div class="col-md-6"><center><input type="submit" id="btnplz1" class="btn btn-success" value="DISPERSAR"></center></div><div class="col-md-6"><center><input type="button" class="btn btn-danger"  data-dismiss="modal" value="CANCELAR"></center></div></div>');
      $("#modal_colaboradores").modal();
            });
        });
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
                total += parseFloat(v.total);
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
                    total += parseFloat(v.total);
                });
                var to = formatMoney(total);
               document.getElementById("myText_proceso").value = to;
            });


        plaza_2 = $("#tabla_plaza_2").DataTable({
             dom: "Bfrtip",
             "buttons": [
      {
          extend: 'excelHtml5',
          text: 'Excel',
          className: 'btn btn-success',
          titleAttr: 'Excel',
          exportOptions: {
              columns: [0,1,2,3,4],
              format: {
                header:  function (d, columnIdx) {
                     if(columnIdx == 0){
                         return ' '+d +' ';
                        }
                       
                                return ' '+titulos[columnIdx-1] +' ';
                          
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
                "width": "20%",
                "data": function( d ){
                    return '<p style="font-size: .8em">COMISIÓN - <b>'+d.nombre+' '+d.apellido_paterno+'</b></p>';
                }
            },
            {  
                "width": "20%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.sede+'</p>';
                }
            },
            {
                "width": "20%",
                "data": function( d ){
                    return '<p style="font-size: .8em">PLAN <b>'+d.id_plan+'</b></p>';
                }
            },
            {
                "width": "20%",
                "data": function( d ){
                    return '<span class="label" style="background:#4B94CC;">DISPONIBLE</span>';
                }
            },
           {
                "width": "20%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.total)+'</p>';
                }
            },
            {
                "width": "10%",
                "orderable": false,
                "data": function( d ){
                    return '<button class="btn btn-round btn-fab btn-fab-mini dispersar_colaboradores" title="PARCIALIDAD" value="' + d.id_plan +'" data-value="' + d.ubicacion_dos +'" style="margin-right: 3px;color:#fff; background:#FBCF5B;"><i class="material-icons">pie_chart</i></button>';   
              }
            }
          ],            columnDefs: [
            {

    orderable: false,
    className: 'select-checkbox',
    targets:   0,
    'searchable':false,
    'className': 'dt-body-center'
    }],



            "ajax": {
                "url": url2 + "Comisiones/getDatosNuevasMktd2",/*registroCliente/getregistrosClientes*/
                    "type": "POST",
                    cache: false,
                    "data": function( d ){}},
                    "order": [[ 1, 'asc' ]]
                });

         

                
      $("#tabla_plaza_2 tbody").on("click", ".dispersar_colaboradores", function(){
        // document.getElementById('btnplz2').disabled=false;
        $("#btnplz2").button({ disabled: false });
          var tr = $(this).closest('tr');
          var row = plaza_1.row( tr );
          let c=0;

          let ubication = $(this).attr("data-value");
          let plen = $(this).val();
         
          $.getJSON( url + "Comisiones/getDatosSumaMktd/"+ubication+"/"+plen).done( function( data01 ){
            let suma_01 = parseFloat(data01[0].suma_f01);

            $("#modal_colaboradores .modal-body").html("");
          $("#modal_colaboradores .modal-footer").html("");
           $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p style="color:gray;font-size:16px;">Comisión total:&nbsp;&nbsp;<b>$'+formatMoney(suma_01)+'</b></p> </div></div>');
          $("#modal_colaboradores .modal-body").append('<input type="hidden" name="total_comi" value="'+data01[0].suma_f01+'">');
          $("#modal_colaboradores .modal-body").append('<input type="hidden" name="num_plan" value="'+plen+'">');
          $("#modal_colaboradores .modal-body").append('<input type="hidden" name="valores_pago_i" value="'+data01[0].valor_obtenido+'">');
          $("#modal_colaboradores .modal-body").append('<input type="hidden" name="pago_mktd" id="pago_mktd" value="'+parseFloat(suma_01)+'">');

          $.getJSON( url + "Comisiones/getDatosColabMktd2/"+ubication+"/"+plen).done( function( data1 ){
              var_sum = 0;
              let fech = data1[0].fecha_plan;
              let fecha = fech.substr(0, 10);
              let nuevaFecha = fecha.split('-');
              let fechaCompleta = nuevaFecha[2]+'-'+nuevaFecha[1]+'-'+nuevaFecha[0];
              let fech2 = data1[0].fin_plan;
              let fecha2 = fech2.substr(0, 10);
              let nuevaFecha2 = fecha2.split('-');
              let fechaCompleta2 = nuevaFecha2[2]+'-'+nuevaFecha2[1]+'-'+nuevaFecha2[0];
              // $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-4"><p style="color:blue;">Número plan:&nbsp;&nbsp;<b>'+data1[0].id_plan+'</b></p> </div>  <div class="col-lg-4"><p style="color:green;">Inicio:&nbsp;&nbsp;<b>'+fechaCompleta+'</b></p> </div>  <div class="col-lg-4"><p style="color:green;">Fin:&nbsp;&nbsp;<b>'+fechaCompleta2+'</b></p> </div> </div>');
              
              // $.each( data1, function( i, v){
              //     valor_money = ((v.porcentaje/100)*suma_01)
              //     $("#modal_colaboradores .modal-body").append('<div class="row"><input type="hidden" name="user_mktd[]" value="'+v.id_usuario+'"><div class="col-md-5"><b style="font-size:14px; color:black;"><p>'+v.colaborador+'</p></b><p style="font-size:12px;">'+v.rol+'</p><br></div>'
              //     +'<div class="col-md-2"><input type="text" name="porcentaje_mktd[]" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+v.porcentaje+'%'+'"></div>'+'<div class="col-md-1"><br><b><p style="text-align:right">$</p></b></div><div class="col-md-4"><input type="text" readonly name="abono_mktd[]" id="abono_mktd_'+i+'"  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+parseFloat(valor_money.toFixed(3))+'"></div>'
              //     +'</div>');
              //     var_sum +=  parseFloat(v.porcentaje);
              //     c++;
              //   });

              $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-4"><p style="color:blue; font-size:14px;">Número plan:&nbsp;&nbsp;<b>'+data1[0].id_plan+'</b></p> </div>  <div class="col-lg-4"><p style="color:green; font-size:14px;">Inicio:&nbsp;&nbsp;<b>'+fechaCompleta+'</b></p> </div>  <div class="col-lg-4"><p style="color:green; font-size:14px;">Fin:&nbsp;&nbsp;<b>'+fechaCompleta2+'</b></p> </div></div><br>');
              
              $.each( data1, function( i, v){
                  valor_money = ((v.porcentaje/100)*suma_01)
                  $("#modal_colaboradores .modal-body").append('<div class="row"><input type="hidden" name="user_mktd[]" value="'+v.id_usuario+'"><div class="col-md-5"><b style="font-size:14px;"><p>'+v.colaborador+'</p></b><p style="font-size:12px;">'+v.rol+'</p><br></div>'
                  +'<div class="col-md-2"><input type="text" name="porcentaje_mktd[]" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+v.porcentaje+'%'+'"></div>'+'<div class="col-md-1"><br><b><p style="text-align:right">$</p></b></div><div class="col-md-4"><input type="text" readonly name="abono_mktd[]" id="abono_mktd_'+i+'"  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+parseFloat(valor_money.toFixed(3))+'"></div>'
                  +'</div>');
                  var_sum +=  parseFloat(v.porcentaje);
                  c++;
                });

                var_sum2 = parseFloat(var_sum);

                 new_valll = parseFloat((suma_01)-((suma_01/100)*var_sum2));
                 new_valll2 = parseFloat((suma_01/100)*var_sum2);


                 console.log("suma "+var_sum2);
                 console.log("row_table "+suma_01);
                 console.log("new_val "+new_valll);
                 console.log("new_val2 "+new_valll2);
                  $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p>Comisión distribuida:&nbsp;&nbsp;<b>'+new_valll2.toFixed(3)+'</b></p> </div></div>');
                  $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p>Comisión restante:&nbsp;&nbsp;<b style="color:red;">'+new_valll.toFixed(3)+'</b></p> </div></div>');
                  $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p>Suma: <b id="Sumto" style="color:red;"></b></p> </div></div>');
                  $("#modal_colaboradores .modal-body").append('<input type="hidden" name="cuantos" id="cuantos" value="'+c+'">');
                });

           
 

      $("#modal_colaboradores .modal-footer").append('<br><div class="row"><div class="col-md-6"><center><input type="submit" id="btnplz2" class="btn btn-success" value="DISPERSAR"></center></div><div class="col-md-6"><center><input type="button" class="btn btn-danger"  data-dismiss="modal" value="CANCELAR"></center></div></div>');
      $("#modal_colaboradores").modal();
            });
        });



    });

// FIN TABLA PROCESO






// INICIO TABLA EN PROCESO

$("#tabla_planes").ready( function(){

$('#tabla_planes thead tr:eq(0) th').each( function (i) {
 if( i!=0 && i!=10){
  var title = $(this).text();


  $(this).html('<input type="text" style="width:100%; background: #003D82; color: white; border: 0; font-weight: 500"  placeholder="'+title+'"/>' );
  $( 'input', this ).on('keyup change', function () {

      if (tabla_planes.column(i).search() !== this.value ) {
          tabla_planes
          .column(i)
          .search(this.value)
          .draw();

          var total = 0;
          var index = tabla_planes.rows({ selected: true, search: 'applied' }).indexes();
          var data = tabla_planes.rows( index ).data();

          $.each(data, function(i, v){
              total += parseFloat(v.pago_cliente);
          });
          var to1 = formatMoney(total);
        //  document.getElementById("myText_proceso").value = formatMoney(total);
      }
  } );
}
});

$('#tabla_planes').on('xhr.dt', function ( e, settings, json, xhr ) {
  var total = 0;
  $.each(json.data, function(i, v){
      total += parseFloat(v.pago_cliente);
  });
  var to = formatMoney(total);
 // document.getElementById("myText_proceso").value = to;
});


      tabla_planes = $("#tabla_planes").DataTable({
          dom: '<"clear">',
          width: 'auto',
"language":{ url: "../static/spanishLoader.json" },
 
"pageLength": 10,
"bAutoWidth": false,
"fixedColumns": true,
"ordering": false,
"columns": [

          {  "width": "5%",
          "data": function( d ){
                  return '<p style="font-size: .8em">'+d.id_plan+'</p>';
              }},

            {
              "orderable": false,
              "width": "30%",
              "data": function( d ){
                fe_crea = (d.fecha_plan).substr(0,10);
                var fecha = new Date(fe_crea);
                var dias = 1;  
                fecha.setDate(fecha.getDate() + dias);
                var options = { year: 'numeric', month: 'long', day: 'numeric' };
                return '<p style="font-size: .8em">'+(fecha.toLocaleDateString("es-ES", options))+'</p>';
              }
            },
 
            {
              "orderable": false,
              "width": "30%",
              "data": function( d ){
                  if(!d.fin_plan){
                    return '<p style="font-size: .8em"><b>ACTUAL</b></p>';


                  }
                  else{
                fe_din = (d.fin_plan).substr(0,10);
                var fecha = new Date(fe_din);
                var dias = 1;  
                fecha.setDate(fecha.getDate() + dias);
                var options = { year: 'numeric', month: 'long', day: 'numeric' };
                return '<p style="font-size: .8em">'+(fecha.toLocaleDateString("es-ES", options))+'</p>';
            }
              }
            },

          {
              "width": "35%",
              "data": function( d ){
                //   return '<p style="font-size: .8em">'+formatMoney(d.id_plan)+'%</p>';
                  return '<button class="btn btn-round btn-fab btn-fab-mini btn-info ver_plan_details" value="' + d.id_plan +'" title="VER DETALLES DE PLAN"><i class="fa fa-table"></i></button>';

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
              "url": url2 + "Comisiones/getDatosPlanesMktd",/*registroCliente/getregistrosClientes*/
                  "type": "POST",
                  cache: false,
                  "data": function( d ){}},
                  "order": [[ 1, 'asc' ]]
              });

      $("#tabla_planes tbody").on("click", ".ver_plan_details", function(){
          var tr = $(this).closest('tr');
          var row = tabla_planes.row( tr );
          $val_plan =  $(this).val();
          
          $("#modal_users .modal-body").html("");
               $.getJSON( url + "Comisiones/getDatosUsersMktd/"+$val_plan).done( function( data ){
                  $.each( data, function( i, v){
                      

                      if(v.porcentaje!=0 && v.id_usuario!=0){
                        est = '<label style="color:green; font-size: 10px;"><i class="fa fa-check"></i><b>ACTIVO</b></label>';
                      }
                      else{
                        est = '<label style="color:red; font-size: 10px;"><i class="fa fa-close"></i> NO APLICA</label>';
                        }

                        if(v.plaza!="NA"){
                        plaz = v.plaza;
                      }
                      else{
                        plaz = '-';
                        }

                        if(v.sede!=null){
                        sed = '<b>'+v.sede+'</b>';
                      }
                      else{
                        sed = '-';
                        }

                      
                      $("#modal_users .modal-body").append('<div class="row">'
                      +'<div class="col-lg-4"> '+v.usuario+'<br><b>'+v.puesto+'</b></label></div>'
                      +'<div class="col-lg-2"><b style="font-size: 12px;">'+v.porcentaje+'%</b></div>'
                      +'<div class="col-lg-2" style="font-size: 10px;">'+plaz+'</div>'
                      +'<div class="col-lg-2">'+sed+'</div>'
                      +'<div class="col-lg-2">'+est+'</div>'
                      +'</div>'
                      +'</div><hr>');
                      });
                    });
                    
                    $("#modal_users").modal();
                           

    });




// FIN TABLA PROCESO

// INICIO TABLA EN PROCESO
 
// FUNCTION MORE

 

    // $(window).resize(function(){
    //     tabla_nuevas.columns.adjust();
    //     // tabla_revision.columns.adjust();
        
     });


     



     $(document).on( "click", ".nuevo_plan", function(){

        $("#modal_mktd .modal-body").html("");
        $("#modal_mktd .modal-footer").html("");

        
        
        $.getJSON( url + "Comisiones/getDatosNuevo/").done( function( data1 ){
            $("#modal_mktd .modal-body").append('<div class="row"><div class="col-md-6"><label>Fecha inicio: </label><input type="date" class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" name="fecha_inicio" id="fecha_inicio" required=""></div></div>');


            $.each( data1, function( i, v){
               
                $("#modal_mktd .modal-body").append('<div class="row">'
                        +'<div class="col-md-3"><br><input class="form-contol ng-invalid ng-invalid-required" style="border: 1px solid white; outline: none;" value="'+v.puesto+'"  readonly><input id="puesto" name="puesto[]" value="'+v.id_rol+'" type="hidden"></div>'

                        +'<div class="col-md-3"><select id="userMKTDSelect'+i+'" name="userMKTDSelect[]" class="form-control userMKTDSelect ng-invalid ng-invalid-required" required data-live-search="true"></select></div>'

                        +'<div class="col-md-2"><input id="porcentajeUserMk'+i+'" name="porcentajeUserMk[]" class="form-control porcentajeUserMk ng-invalid ng-invalid-required" required placeholder="%" value="0"></div>'

                        +'<div class="col-md-2"><select id="plazaMKTDSelect'+i+'" name="plazaMKTDSelect[]" class="form-control plazaMKTDSelect ng-invalid ng-invalid-required"   data-live-search="true"></select></div>'

                        +'<div class="col-md-2"><select id="sedeMKTDSelect'+i+'" name="sedeMKTDSelect[]" class="form-control sedeMKTDSelect ng-invalid ng-invalid-required"   data-live-search="true"></select></div></div>');

                        $.post('getUserMk', function(data) {
                        $("#userMKTDSelect"+i+"").append($('<option disabled>').val("default").text("Seleccione una opción"))
                        var len = data.length;
                        for( var j = 0; j<len; j++)
                        {
                            var id = data[j]['id_usuario'];
                            var name = data[j]['name_user'];
                            // var sede = data[i]['id_sede'];
                            // alert(name);
                            $("#userMKTDSelect"+i+"").append($('<option>').val(id).attr('data-value', id).text(name));
                        }
                        if(len<=0)
                        {
                        $("#userMKTDSelect"+i+"").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                        }
                        
                        $("#userMKTDSelect"+i+"").val(data1[i].id_usuario);                     
 
                        $("#userMKTDSelect"+i+"").selectpicker('refresh');
                    }, 'json');



                    $.post('getPlazasMk', function(data) {
                        $("#plazaMKTDSelect"+i+"").append($('<option disabled>').val("default").text("Seleccione una opción"))
                        var len = data.length;
                        for( var j = 0; j<len; j++)
                        {
                            var id = data[j]['id_opcion'];
                            var name = data[j]['nombre'];
                            // var sede = data[i]['id_sede'];
                            // alert(name);
                            $("#plazaMKTDSelect"+i+"").append($('<option>').val(id).attr('data-value', id).text(name));
                        }
                        if(len<=0)
                        {
                        $("#plazaMKTDSelect"+i+"").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                        }
                
                                $("#plazaMKTDSelect"+i+"").val(1); 
    
                        $("#plazaMKTDSelect"+i+"").selectpicker('refresh');
                    }, 'json');



                    $.post('getSedeMk', function(data) {
                        $("#sedeMKTDSelect"+i+"").append($('<option disabled>').val("default").text("Seleccione una opción"))
                        var len = data.length;
                        for( var j = 0; j<len; j++)
                        {
                            var id = data[j]['id_sede'];
                            var name = data[j]['nombre'];
                            
                            $("#sedeMKTDSelect"+i+"").append($('<option>').val(id).attr('data-value', id).text(name));
                        }
                        if(len<=0)
                        {
                        $("#sedeMKTDSelect"+i+"").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                        }
                        console.log(data1[i].id_sede);

                        if(data1[i].id_rol=='20'){
                               
                               $("#sedeMKTDSelect"+i+"").val(data1[i].id_sede);

                           }else{
                                $("#sedeMKTDSelect"+i+"").val(2); 
                           }


                            // $("#sedeMKTDSelect"+i+"").val(data1[i].id_usuario);
                        $("#sedeMKTDSelect"+i+"").selectpicker('refresh');
                    }, 'json'); 
            });
 
 
        });

        $("#modal_mktd .modal-footer").append('<br><div class="row"><div class="col-md-12"><center><input type="submit" id="btnsubmit" class="btn btn-success" value="GUARDAR"></center></div></div>');
        $("#modal_mktd").modal();
        
 
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





    $("#form_colaboradores").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {

        //bloquear boton 
        $("#btnplz1").button({ disabled: true });
        $("#btnplz2").button({ disabled: true });

        // document.getElementById('btnplz1').disabled=true;
        // document.getElementById('btnplz12').disabled=true;
        //alert('#pago_mktd'.val());
        
        $('#loaderDiv').removeClass('hide');
        var data = new FormData( $(form)[0] );
       let sumat=0;
       let valor = parseFloat($('#pago_mktd').val()).toFixed(3);
       let valor1 = parseFloat(valor-0.10);
       let valor2 = parseFloat(valor)+0.010;
       
       console.log($('#cuantos').val());
       
       for(let i=0;i<$('#cuantos').val();i++){
           sumat += parseFloat($('#abono_mktd_'+i).val());
        }
       
        let sumat2 =  parseFloat((sumat).toFixed(3));
       
        // console.log('suma '+sumat2);
        // console.log('normal '+valor);
        // console.log('-0.10 '+valor1);
        // console.log('+0.10 '+valor2);

        document.getElementById('Sumto').innerHTML= ''+ parseFloat(sumat2.toFixed(3)) +'';
       
        if(parseFloat(sumat2.toFixed(3)) < valor1){
            alerts.showNotification("top", "right", "Falta dispersar", "warning");
        //    console.log("Faltan");
        }
        else 
        // if(parseFloat(sumat2) == parseFloat(valor)){
            if(parseFloat(sumat2.toFixed(3)) >= valor1 && parseFloat(sumat2.toFixed(3)) <= valor2 ){
        //    console.log("Bien");
            $.ajax({
            url: url2 + "Comisiones/nueva_mktd_comision",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data){
                    if(true){
                        $('#loaderDiv').addClass('hide');
                        $("#modal_colaboradores").modal('toggle');
                        plaza_2.ajax.reload();
                        plaza_1.ajax.reload();
                        alert("¡Se agregó con éxito!");
                    }else{
                        alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                        $('#loaderDiv').addClass('hide');
                    }
                },error: function( ){
                    alert("ERROR EN EL SISTEMA");
                }
            });
        }
        else if(parseFloat(sumat2.toFixed(3)) > valor1 && parseFloat(sumat2.toFixed(3)) > valor2 ){
            alerts.showNotification("top", "right", "Cantidad excedida", "danger");
            // console.log("Ya te pasaste prro");
        }
       
    }
});

 
    


 // id_comision = id_comision;

    $("#frmnewsol").submit( function(e) {
        e.preventDefault();
    }).validate({
        submitHandler: function( form ) {
 
                    var data = new FormData( $(form)[0] );
                    // data.append("id_comision", id_comision);
                    data.append("xmlfile", documento_xml);
 
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
                        },error: function(){
                            alert("ERROR EN EL SISTEMA");
                        }
                    });

             
        }
    });          
        
    // $(document).on('click', '#btnsubmit', function(){
    //     $(".plazaMKTDSelect").prop("disabled",false); 
    //     // var a = (parseInt($(".plazaMKTDSelect").length)) / 2;
    //     // console.log("longitud: "+a);
    //     // for(i=0; i<a; i++){
    //     //     console.log("perrito");
    //     //     console.log($("#plazaMKTDSelect"+i));
    //     //     $(".plazaMKTDSelect").prop("disabled",false); 
    //     // } 
    // });

    $("#form_MKTD").submit( function(e) {
        // var a = (parseInt($(".plazaMKTDSelect").length)) / 2;
        // console.log("longitud: "+a);
        // for(i=0; i<a; i++){
        //     console.log("perrito");
        //     console.log($("#plazaMKTDSelect"+i));
        //     $("#plazaMKTDSelect"+i).prop("disabled",false); 
        // } 
        e.preventDefault();        
    }).validate({

        rules: {
                'porcentajeUserMk[]':{
                    required: true,
                }
            },
        messages: {
                'porcentajeUserMk[]':{
                    required : "Dato requerido"
                }
            },

        submitHandler: function( form ) {
            var data = new FormData( $(form)[0] );
            $.ajax({
                url: url + "Comisiones/save_new_mktd",
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
                            $("#modal_mktd").modal( 'toggle' );
                        //  tabla_nuevas.ajax.reload();
                    }else{
                        alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                    }
                },error: function(){
                    alert("ERROR EN EL SISTEMA");
                }
            });   
        }
    });
    



    function calcularMontoParcialidad() {
        // $('#pagoCon').val(0);
        $precioFinal = parseFloat($('#value_pago_cliente').val());
        $precioNuevo = parseFloat($('#new_value_parcial').val());

        // alert($precioFinal);

        if ($precioNuevo >= $precioFinal) {
            // alert("si entra");
            $('#label_estado').append('<label>MONTO NO VALIDO</label>');

            // label_estado
        }
        else if ($precioNuevo < $precioFinal) {
            $('#label_estado').append('<label>MONTO VALIDO</label>');
        }
        // validateAdvance();
    }


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

<script>
     $(document).ready( function()
   {
    $.getJSON( url + "Comisiones/report_plazas").done( function( data ){
        $(".report_plazas").html();
        $(".report_plazas1").html();
        $(".report_plazas2").html();
 
            if(data[0].id_plaza == '0' || data[1].id_plaza == 0){
                if(data[0].plaza00==null || data[0].plaza00=='null' ||data[0].plaza00==''){
                    $(".report_plazas").append('<label style="color: #6a2c70;">&nbsp;<b>Porcentaje:</b> '+data[0].plaza01+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> 0%</label>');
                }
                else{
                    $(".report_plazas").append('<label style="color: #6a2c70;">&nbsp;<b>Porcentaje:</b> '+data[0].plaza01+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> '+data[0].plaza00+'%</label>');
                }
               
             }
            if(data[1].id_plaza == '1' || data[1].id_plaza == 1){
                if(data[1].plaza10==null || data[1].plaza10=='null' ||data[1].plaza10==''){
                    $(".report_plazas1").append('<label style="color: #b83b5e;">&nbsp;<b>Porcentaje:</b> '+data[1].plaza11+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> 0%</label>');
                }
                else{
                    $(".report_plazas1").append('<label style="color: #b83b5e;">&nbsp;<b>Porcentaje:</b> '+data[1].plaza11+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> '+data[1].plaza10+'%</label>');
                }
               
             }

            if(data[2].id_plaza == '2' || data[2].id_plaza == 2){
                if(data[2].plaza20==null || data[2].plaza20=='null' ||data[2].plaza20==''){
                    $(".report_plazas2").append('<label style="color: #f08a5d;">&nbsp;<b>Porcentaje:</b> '+data[2].plaza21+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> 0%</label>');
                }
                else{
                    $(".report_plazas2").append('<label style="color: #f08a5d;">&nbsp;<b>Porcentaje:</b> '+data[2].plaza21+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> '+data[2].plaza20+'%</label>');
                }
               
             }
         });
});
 
                                                         
</script>

