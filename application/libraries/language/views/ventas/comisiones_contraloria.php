<body>
<div class="wrapper">
 
    <?php
 
 
  if($this->session->userdata('id_rol')=="13")//contraloria
    {
        $dato = array(
        'home'           => 0,
        'listaCliente'   => 0,
        'expediente'     => 0,
        'corrida'        => 0,
        'documentacion'  => 0,
        'historialpagos' => 0,
        'inventario'     => 0,
        'estatus20'      => 0,
        'estatus2'       => 0,
        'estatus5'       => 0,
        'estatus6'       => 0,
        'estatus9'       => 0,
        'estatus10'      => 0,
        'estatus13'      => 0,
        'estatus15'      => 0,
        'enviosRL'       => 0,
        'estatus12'      => 0,
        'acuserecibidos' => 0,
        'tablaPorcentajes' => 0,
        'comnuevas'      => 1,
        'comhistorial'   => 0,
        'integracionExpediente' => 0,
        'expRevisados' => 0,
        'estatus10Report' => 0,
        'rechazoJuridico' => 0
    );
        //$this->load->view('template/contraloria/sidebar', $dato);
        $this->load->view('template/sidebar', $dato);
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
</style>

<div class="modal fade modal-alertas" id="modal_nuevas" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
 
            <form method="post" id="form_interes">
                <div class="modal-body"></div>
            </form>
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







<div class="modal fade modal-alertas" id="documento_preview" role="dialog">
    <div class="modal-dialog" style= "margin-top:20px;"></div>
</div>
 
 
<div class="modal fade bd-example-modal-sm" id="myModalEnviadas" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
  </div>
</div>
  
<div class="modal fade bd-example-modal-sm" id="myModalTQro" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body"></div>
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
                                    <ul class="nav nav-pills nav-pills-success nav-pills-icons" role="tablist" >
                                        <li class="active" style="margin-right: 40px;">
                                            <a href="#FACTURA-1" role="tab" data-toggle="tab">
                                                COMISIONES FACTURA
                                            </a>
                                        </li>

                                        <li style="margin-right: 40px;">
                                            <a href="#ASIMILADOS-1" role="tab" data-toggle="tab">
                                                COMISIONES ASIMILADOS
                                            </a>
                                        </li>

                                        <li style="margin-right: 40px;">
                                            <a href="#leon-1" role="tab" data-toggle="tab">
                                                ENVIADAS A INTERNOMEX 
                                            </a>
                                        </li>
                                       
                                        <li style="margin-right: 40px;">
                                            <a href="#cdmx-1" role="tab" data-toggle="tab">
                                                OTRAS
                                            </a>
                                        </li>
 
                                    </ul>
                                </div>

                                <div class="tab-content">

                                    <div class="tab-pane active" id="FACTURA-1">
                                        <div class="content">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                               
                                                                <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                	<h4 class="card-title" >COMISIONES NUEVAS - <b>FACTURA</b></h4>
                                                                <p class="category">Comisiones solictadas por colaboradores para proceder a pago con factura</b>.</p></div>

                                                                <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6"><br>
                                                                	<label style="color: #0a548b;">&nbsp;Disponible: $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text"  name="myText_qro" id="myText_qro"></label> 


                                                                	<label style="color: #0a548b;">&nbsp;Autorizar: $

                                                                		<span style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text" id="totpagarQro"></span>
                                                                	</label>

                                                                	<!-- <span id="totpagarLeon"></span> -->
                                                                </div>

                                                            </div>
                                                            <div class="card-content">
                                                                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                	<div class="material-datatables">
                                                                    <div class="form-group">
                                                                        <div class="table-responsive">
                                                                        	<table class="table table-responsive table-bordered table-striped table-hover" id="tabla_nuevas" name="tabla_nuevas">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th style="font-size: .9em;"></th>
                                                                                        <th style="font-size: .9em;">PROYECTO</th>
                                                                                        <th style="font-size: .9em;">LOTE</th>
                                                                                        <th style="font-size: .9em;">EMPRESA</th>
                                                                                        <th style="font-size: .9em;">PRECIO LOTE</th>
                                                                                        <th style="font-size: .9em;">TOT. COM.</th>
                                                                                        <th style="font-size: .9em;">COM. %</th>
                                                                                        <th style="font-size: .9em;">COMISIÓN $</th>
                                                                                        <th style="font-size: .9em;"># COM</th>
                                                                                        <th style="font-size: .9em;">COMISIONISTA</th>
                                                                                        <th style="font-size: .9em;">PUESTO</th>
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





                                      <!-- ///////////////// -->

                                 <div class="tab-pane" id="ASIMILADOS-1">
                                    <div class="content">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                               
                                                                <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                    <h4 class="card-title" >COMISIONES NUEVAS - <b>ASIMILADOS</b></h4>
                                                                <p class="category">Comisiones solictadas por colaboradores para proceder a pago sin factura</b>.</p></div>

                                                                <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6"><br>
                                                                    <label style="color: #0a548b;">&nbsp;Disponible: $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text"  name="myText_asimilados" id="myText_asimilados"></label> 


                                                                    <label style="color: #0a548b;">&nbsp;Autorizar: $

                                                                        <span style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text" id="totpagarAsimilados"></span>
                                                                    </label>

                                                                    <!-- <span id="totpagarLeon"></span> -->
                                                                </div>

                                                            </div>
                                                            <div class="card-content">
                                                                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <div class="material-datatables">
                                                                    <div class="form-group">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-responsive table-bordered table-striped table-hover" id="tabla_asimilados" name="tabla_asimilados">
                                                                                 <thead>
                                                                                    <tr>
                                                                                        <th style="font-size: .9em;"></th>
                                                                                        <th style="font-size: .9em;">PROYECTO</th>
                                                                                        <th style="font-size: .9em;">LOTE</th>
                                                                                        <th style="font-size: .9em;">EMPRESA</th>
                                                                                        <th style="font-size: .9em;">PRECIO LOTE</th>
                                                                                        <th style="font-size: .9em;">TOT. COM.</th>
                                                                                        <th style="font-size: .9em;">COM. %</th>
                                                                                        <th style="font-size: .9em;">COMISIÓN $</th>
                                                                                        <th style="font-size: .9em;"># COM</th>
                                                                                        <th style="font-size: .9em;">COMISIONISTA</th>
                                                                                        <th style="font-size: .9em;">PUESTO</th>
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

                                   

                                      <!-- ///////////////// -->

                                 <div class="tab-pane" id="leon-1">
                                        <div class="content">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                               
                                                                <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                    <h4 class="card-title">ENVIADAS INTERNOMEX</h4>
                                                                <p class="category">Comisiones enviadas a INTERNOMEX para su dispersion de pago</p></div>

                                                                <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                    <label style="color: #0a548b;">&nbsp;Total solicitado: $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text"  name="myText_internomex" id="myText_internomex"></label> 
 
                                                                </div>


                                                                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <br>
 
                                                                </div>

                                                               <div class="report_empresa">
                                                               </div>


                                                             


                                                            </div>
                                                            <div class="card-content">
                                                                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <div class="material-datatables">
                                                                    <div class="form-group">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-responsive table-bordered table-striped table-hover" id="tabla_internomex" name="tabla_internomex">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th style="font-size: .9em;">ID</th>
                                                                                        <th style="font-size: .9em;">PROYECTO</th>
                                                                                        <th style="font-size: .9em;">LOTE</th>
                                                                                        <th style="font-size: .9em;">EMPRESA</th>
                                                                                        <th style="font-size: .9em;">PRECIO LOTE</th>
                                                                                        <th style="font-size: .9em;">TOT. COM.</th>
                                                                                        <th style="font-size: .9em;">COM. %</th>
                                                                                        <th style="font-size: .9em;">COMISIÓN $</th>
                                                                                        <th style="font-size: .9em;">FORMA PAGO</th>
                                                                                        <th style="font-size: .9em;"># COM</th>
                                                                                        <th style="font-size: .9em;">COMISIONISTA</th>
                                                                                        <th style="font-size: .9em;">PUESTO</th>
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

                                   
 

                                <!-- /////////////// -->
 

                                      <div class="tab-pane" id="cdmx-1">
                                        <div class="content">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                               
                                                                <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                     <h4 class="card-title">OTRAS</h4>
                                                                <p class="category">Otras comisiones con estatus pausadas o canceladas.</b>.</p>
                                                            </div> 
                                                                <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6"><br>
                                                                    <label style="color: #0a548b;">&nbsp;Acumulado: $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text"  name="myText_otras" id="myText_otras"></label> 
 

                                                                    <!-- <span id="totpagarPen"></span> -->
                                                                </div>

                                                            </div>
                                                            <div class="card-content">
                                                                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <div class="material-datatables">
                                                                    <div class="form-group">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-responsive table-bordered table-striped table-hover" id="tabla_otras" name="tabla_otras">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th style="font-size: .9em;">ID</th>
                                                                                        <th style="font-size: .9em;">PROYECTO</th>
                                                                                        <th style="font-size: .9em;">LOTE</th>
                                                                                        <th style="font-size: .9em;">PRECIO LOTE</th>
                                                                                        <th style="font-size: .9em;">TOT. COMISIÓN</th>
                                                                                        <th style="font-size: .9em;">COM. %</th>
                                                                                        <th style="font-size: .9em;">COMISIÓN $</th>
                                                                                        <th style="font-size: .9em;"># COM</th>
                                                                                        <th style="font-size: .9em;">COMISIONISTA</th>
                                                                                        <th style="font-size: .9em;">PUESTO</th>
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

                                <!-- ////////////////// -->
                                
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
    var totalLeon = 0;
    var totalQro = 0;
    var totalSlp = 0;
    var totalMerida = 0;
    var totalCdmx = 0;
    var totalCancun = 0;
    var tr;
//INICIO TABLA QUERETARO****************************************************************************************
  
var tabla_nuevas2;
  $("#tabla_nuevas").ready( function(){     

  $('#tabla_nuevas thead tr:eq(0) th').each( function (i) {
   if( i!=0 && i!=10){
    var title = $(this).text();

    $(this).html('<input type="text" style="width: 100%; background: #003D82; color: white; border: 0; font-weight: 500;"  placeholder="'+title+'"/>' );
    $( 'input', this ).on('keyup change', function () {

        if(tabla_nuevas2.column(i).search() !== this.value ) {
            tabla_nuevas2
            .column(i)
            .search(this.value)
            .draw();

            var total = 0;
            var index = tabla_nuevas2.rows({ selected: true, search: 'applied' }).indexes();
            var data = tabla_nuevas2.rows( index ).data();
            $.each(data, function(i, v){
                total += parseFloat(v.porcentaje_dinero);
            });
            var to1 = formatMoney(total);
            document.getElementById("myText_qro").value = formatMoney(total);
        }
    });
}
});

  $('#tabla_nuevas').on('xhr.dt', function ( e, settings, json, xhr ) {
    var total = 0;
    $.each(json.data, function(i, v){
        total += parseFloat(v.porcentaje_dinero);
    });
    var to = formatMoney(total);
    document.getElementById("myText_qro").value = to;
});

  tabla_nuevas2 = $("#tabla_nuevas").DataTable({
    dom: 'Brtip',
    width: 'auto',
    "buttons": [
     
    {
        text: '<i class="fa fa-check"></i> ENVIAR A INTERNOMEX',
        action: function(){

            if ($('input[name="idTQ[]"]:checked').length > 0) {
                var idcomision = $(tabla_nuevas2.$('input[name="idTQ[]"]:checked')).map(function () { return this.value; }).get();

                $.get(url+"Comisiones/acepto_comisiones_factura/"+idcomision).done(function () {
                    $("#myModalEnviadas").modal('toggle');
                    tabla_nuevas2.ajax.reload();
                    tabla_internomex2.ajax.reload();
                    $("#myModalEnviadas .modal-body").html("");
                    $("#myModalEnviadas").modal();
                    $("#myModalEnviadas .modal-body").append("<center><img style='width: 25%; height: 25%;' src='<?= base_url('dist/img/mktd.png')?>'><br><br><b><P style='color:#BCBCBC;'>COMISIONES ENVIADAS A INTERNOMEX CORRECTAMENTE.</P></b></center>");
                });
            }
        },
        attr: {
            class: 'btn bg-olive',
            style: 'background: #3D8E9F;',
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
    "columns": [{   
        "width": "5%"
    },

    {   "width": "8%",
        "data": function( d ){
            return '<p style="font-size: .8em">'+d.proyecto+'</p>';
        }
    },
 
    {   "width": "10%",
        "data": function( d ){
            return '<p style="font-size: .8em">'+d.lote+'</p>';
        }
    },
 

    {   "width": "7%",
        "data": function( d ){
            return '<p style="font-size: .8em"><b>'+d.empresa+'</b></p>';
        }
    }, 


    {   "width": "9%",
        "data": function( d ){
            return '<p style="font-size: .8em">$'+formatMoney(d.total)+'</p>';
        }
    },
    {   "width": "9%",
        "data": function( d ){
            return '<p style="font-size: .8em">$'+formatMoney(d.precio_neto)+'</p>';
        }
    },

    {   "width": "6%",
        "data": function( d ){
            return '<p style="font-size: .8em">'+(d.porcentaje_decimal).toFixed(2)+' %</p>';
        }
    },

    {   "width": "9%",
        "data": function( d ){
            return '<p style="font-size: .8em"><b>$ '+formatMoney(d.porcentaje_dinero)+'</b></p>';
        }
    },



     {   "width": "6%",
        "data": function( d ){
            return '<p style="font-size: .8em"><span class="label label-primary">'+d.numero_mensualidad+' / 13</span></p>';
        }
    },

    {   "width": "12%",
        "data": function( d ){
            return '<p style="font-size: .8em">'+d.nombre+" "+d.apellido_paterno+" "+d.apellido_materno+'</p>';
        }
    },
    {   "width": "9%",
        "data": function( d ){
            return '<p style="font-size: .8em"><b>'+(d.puesto).toUpperCase();+'</b></p>';
        }
    },
 

    {   "width": "10%",
        "orderable": false,
          data: function (d) {
          
             return '<button class="btn btn-round btn-fab btn-fab-mini info consultar_documentos" data-personalidad="' + d.personalidad_juridica +'" value="' + d.id_comision +'" style="margin-right: 3px"><i class="material-icons">info</i></button>' +

            '<button class="btn btn-warning btn-round btn-fab btn-fab-mini cambiar_estatus" value="' + d.id_comision +'" style="margin-right: 3px;color:#fff;"><i class="material-icons">build</i></button>';
        }
            
    }],

    columnDefs: [{
        orderable: false,
        className: 'select-checkbox',
        targets:   0,
        'searchable':false,
        'className': 'dt-body-center',
        'render': function (d, type, full, meta){
            if(full.id_comision){
                return '<input type="checkbox" name="idTQ[]" style="width:20px;height:20px;"  value="' + full.id_comision + '">';
            }else{
                return '';
            }     
        },
        select: {
            style:    'os',
            selector: 'td:first-child'
        },
    }],

    "ajax": {
        "url": url2 + "Comisiones/getDatosNuevasFContraloria",
        "type": "POST",
        cache: false,
        "data": function( d ){
                }
            },
            "order": [[ 1, 'asc' ]]
    });



$('#tabla_nuevas').on( 'click', 'input', function () {
    tr = $(this).closest('tr');
    var row = tabla_nuevas2.row( tr ).data();

    if( row.pa == 0 ){
        row.pa = row.porcentaje_dinero;
        totalQro += parseFloat( row.pa );
        tr.children().eq(1).children('input[type="checkbox"]').prop( "checked",true );
    }else{
        totalQro -= parseFloat( row.pa );
        row.pa = 0;
    }
    $("#totpagarQro").html(formatMoney(totalQro));
});


$("#tabla_nuevas tbody").on("click", ".cambiar_estatus", function(){
    var tr = $(this).closest('tr');
    var row = tabla_nuevas2.row( tr );

    id_comision = $(this).val();

    $("#modal_nuevas .modal-body").html("");
    $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Está seguro de pausar la comision de <b>'+row.data().lote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().nombre+" "+row.data().apellido_paterno+" "+row.data().apellido_materno+'</i>?</p></div></div>');

    $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="text" class="form-control" required placeholder="Describe mótivo por el cual se pauso la solicitud"></input></div></div>');

    $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-md-6"></div><div class="col-md-3"><input type="submit" class="btn btn-primary" value="PAUSAR"></div><div class="col-md-3"><input type="button" class="btn btn-danger" value="CANCELAR" onclick="cancela()"></div></div>');
   
    $("#modal_nuevas").modal();
});









$("#tabla_nuevas tbody").on("click", ".consultar_documentos", function(){
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
                $("#seeInformationModal .documents").append('<div class="col-md-7"><label style="font-size:10px; margin:0; color:#0a548b;"><b>'+(v.nombre).substr(0, 52)+'</b></label></div> <div class="col-md-5"><label style="font-size:10px; margin:0; color:#0a548b;"><b>('+v.expediente+')</label></b> - <button onclick="preview_info(&#39;'+(v.expediente)+'&#39;)" style="border:none; background-color:#fff;"><i class="fa fa-file" aria-hidden="true" style="font-size: 12px; color:#0a548b;"></i></button></div>');
             }
             $("#seeInformationModal .documents").append('</div>');
         });
    });

    $.getJSON( url + "Comisiones/getDatosFactura/"+id_com).done( function( data ){
        // $.each( data, function( i, v){

            // alert(data.datos_solicitud['id_factura']);

           $("#seeInformationModal .facturaInfo").append('<div class="row">');
            if (!data.datos_solicitud['id_factura'] == '' && !data.datos_solicitud['id_factura'] == '0'){

                $("#seeInformationModal .facturaInfo").append('<BR><div class="col-md-12"><label style="font-size:14px; margin:0; color:gray;"><b>NOMBRE EMISOR</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['nombre']+' '+data.datos_solicitud['apellido_paterno']+' '+data.datos_solicitud['apellido_materno']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b> LOTE</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['nombreLote']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                 $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>TOTAL FACT.</b></label><br><label style="font-size:12px; margin:0; color:gray;">$ '+data.datos_solicitud['total']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>MONTO COMSN.</b></label><br><label style="font-size:12px; margin:0; color:gray;">$ '+data.datos_solicitud['porcentaje_dinero']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');



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
                // $("#seeInformationModal .facturaInfo").append('<label color="red;">SIN HAY DATOS A MOSTRAR</label>');
             }
             $("#seeInformationModal .facturaInfo").append('</div>');


        // });
    });

    // $.getJSON( url + "Comisiones/getCambios/"+id_com+"/"+id_pj).done( function( data ){
    //     $.each( data, function( i, v){
    //         fillFields(v, 1);
    //     });
    // });

});



 
 
 
});

//FIN TABLA QUERETARO**************************************************************************************






//INICIO TABLA QUERETARO****************************************************************************************
  
var tabla_asimilados2;
  $("#tabla_asimilados").ready( function(){     

  $('#tabla_asimilados thead tr:eq(0) th').each( function (i) {
   if( i!=0 && i!=10){
    var title = $(this).text();

    $(this).html('<input type="text" style="width: 100%; background: #003D82; color: white; border: 0; font-weight: 500;"  placeholder="'+title+'"/>' );
    $( 'input', this ).on('keyup change', function () {

        if(tabla_asimilados2.column(i).search() !== this.value ) {
            tabla_asimilados2
            .column(i)
            .search(this.value)
            .draw();

            var total = 0;
            var index = tabla_asimilados2.rows({ selected: true, search: 'applied' }).indexes();
            var data = tabla_asimilados2.rows( index ).data();
            $.each(data, function(i, v){
                total += parseFloat(v.porcentaje_dinero);
            });
            var to1 = formatMoney(total);
            document.getElementById("myText_asimilados").value = formatMoney(total);
        }
    });
}
});

  $('#tabla_asimilados').on('xhr.dt', function ( e, settings, json, xhr ) {
    var total = 0;
    $.each(json.data, function(i, v){
        total += parseFloat(v.porcentaje_dinero);
    });
    var to = formatMoney(total);
    document.getElementById("myText_asimilados").value = to;
});

  tabla_asimilados2 = $("#tabla_asimilados").DataTable({
    dom: 'Brtip',
    width: 'auto',
    "buttons": [
     
    {
        text: '<i class="fa fa-check"></i> ENVIAR A INTERNOMEX',
        action: function(){

            if ($('input[name="idTQ[]"]:checked').length > 0) {
                var idcomision = $(tabla_asimilados2.$('input[name="idTQ[]"]:checked')).map(function () { return this.value; }).get();

                $.get(url+"Comisiones/acepto_comisiones_asimilados/"+idcomision).done(function () {
                    $("#myModalEnviadas").modal('toggle');
                    tabla_asimilados2.ajax.reload();
                    tabla_internomex2.ajax.reload();
                    $("#myModalEnviadas .modal-body").html("");
                    $("#myModalEnviadas").modal();
                    $("#myModalEnviadas .modal-body").append("<center><img style='width: 25%; height: 25%;' src='<?= base_url('dist/img/mktd.png')?>'><br><br><b><P style='color:#BCBCBC;'>COMISIONES ENVIADAS A INTERNOMEX CORRECTAMENTE.</P></b></center>");
                });
            }
        },
        attr: {
            class: 'btn bg-olive',
            style: 'background: #3D8E9F;',
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
   "columns": [{   
        "width": "5%"
    },

    {   "width": "8%",
        "data": function( d ){
            return '<p style="font-size: .8em">'+d.proyecto+'</p>';
        }
    },
 
    {   "width": "10%",
        "data": function( d ){
            return '<p style="font-size: .8em">'+d.lote+'</p>';
        }
    },
 

    {   "width": "7%",
        "data": function( d ){
            return '<p style="font-size: .8em"><b>'+d.empresa+'</b></p>';
        }
    }, 


    {   "width": "9%",
        "data": function( d ){
            return '<p style="font-size: .8em">$'+formatMoney(d.total)+'</p>';
        }
    },
    {   "width": "9%",
        "data": function( d ){
            return '<p style="font-size: .8em">$'+formatMoney(d.precio_neto)+'</p>';
        }
    },

    {   "width": "6%",
        "data": function( d ){
            return '<p style="font-size: .8em">'+(d.porcentaje_decimal).toFixed(2)+' %</p>';
        }
    },

    {   "width": "9%",
        "data": function( d ){
            return '<p style="font-size: .8em"><b>$ '+formatMoney(d.porcentaje_dinero)+'</b></p>';
        }
    },

     {   "width": "6%",
        "data": function( d ){
            return '<p style="font-size: .8em"><span class="label label-primary">'+d.numero_mensualidad+' / 13</span></p>';
        }
    },

    {   "width": "12%",
        "data": function( d ){
            return '<p style="font-size: .8em">'+d.nombre+" "+d.apellido_paterno+" "+d.apellido_materno+'</p>';
        }
    },
    {   "width": "9%",
        "data": function( d ){
            return '<p style="font-size: .8em"><b>'+(d.puesto).toUpperCase();+'</b></p>';
        }
    },
 

    {   "width": "10%",
        "orderable": false,
          data: function (d) {
          
             return '<button class="btn btn-round btn-fab btn-fab-mini info consultar_documentos" data-personalidad="' + d.personalidad_juridica +'" value="' + d.id_comision +'" style="margin-right: 3px"><i class="material-icons">info</i></button>' +

            '<button class="btn btn-warning btn-round btn-fab btn-fab-mini cambiar_estatus" value="' + d.id_comision +'" style="margin-right: 3px;color:#fff;"><i class="material-icons">build</i></button>';
        }
            
    }],

    columnDefs: [{
        orderable: false,
        className: 'select-checkbox',
        targets:   0,
        'searchable':false,
        'className': 'dt-body-center',
        'render': function (d, type, full, meta){
            if(full.id_comision){
                return '<input type="checkbox" name="idTQ[]" style="width:20px;height:20px;"  value="' + full.id_comision + '">';
            }else{
                return '';
            }     
        },
        select: {
            style:    'os',
            selector: 'td:first-child'
        },
    }],

    "ajax": {
        "url": url2 + "Comisiones/getDatosNuevasAContraloria",
        "type": "POST",
        cache: false,
        "data": function( d ){
                }
            },
            "order": [[ 1, 'asc' ]]
    });



$('#tabla_asimilados').on( 'click', 'input', function () {
    tr = $(this).closest('tr');
    var row = tabla_asimilados2.row( tr ).data();

    if( row.pa == 0 ){
        row.pa = row.porcentaje_dinero;
        totalQro += parseFloat( row.pa );
        tr.children().eq(1).children('input[type="checkbox"]').prop( "checked",true );
    }else{
        totalQro -= parseFloat( row.pa );
        row.pa = 0;
    }
    $("#totpagarAsimilados").html(formatMoney(totalQro));
});


$("#tabla_asimilados tbody").on("click", ".cambiar_estatus", function(){
    var tr = $(this).closest('tr');
    var row = tabla_asimilados2.row( tr );

    id_comision = $(this).val();

    $("#modal_nuevas .modal-body").html("");
    $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Está seguro de pausar la comision de <b>'+row.data().lote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().nombre+" "+row.data().apellido_paterno+" "+row.data().apellido_materno+'</i>?</p></div></div>');

    $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="text" class="form-control" required placeholder="Describe mótivo por el cual se pauso la solicitud"></input></div></div>');

    $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-md-6"></div><div class="col-md-3"><input type="submit" class="btn btn-primary" value="PAUSAR"></div><div class="col-md-3"><input type="button" class="btn btn-danger" value="CANCELAR" onclick="cancela()"></div></div>');
   
    $("#modal_nuevas").modal();
});










$("#tabla_asimilados tbody").on("click", ".consultar_documentos", function(){
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
                $("#seeInformationModal .documents").append('<div class="col-md-7"><label style="font-size:10px; margin:0; color:#0a548b;"><b>'+(v.nombre).substr(0, 52)+'</b></label></div> <div class="col-md-5"><label style="font-size:10px; margin:0; color:#0a548b;"><b>('+v.expediente+')</label></b> - <button onclick="preview_info(&#39;'+(v.expediente)+'&#39;)" style="border:none; background-color:#fff;"><i class="fa fa-file" aria-hidden="true" style="font-size: 12px; color:#0a548b;"></i></button></div>');
             }
             $("#seeInformationModal .documents").append('</div>');
         });
    });

    $.getJSON( url + "Comisiones/getDatosFactura/"+id_com).done( function( data ){
        // $.each( data, function( i, v){

            // alert(data.datos_solicitud['id_factura']);

           $("#seeInformationModal .facturaInfo").append('<div class="row">');
            if (!data.datos_solicitud['id_factura'] == '' && !data.datos_solicitud['id_factura'] == '0'){

                $("#seeInformationModal .facturaInfo").append('<BR><div class="col-md-12"><label style="font-size:14px; margin:0; color:gray;"><b>NOMBRE EMISOR</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['nombre']+' '+data.datos_solicitud['apellido_paterno']+' '+data.datos_solicitud['apellido_materno']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b> LOTE</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['nombreLote']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                 $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>TOTAL FACT.</b></label><br><label style="font-size:12px; margin:0; color:gray;">$ '+data.datos_solicitud['total']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>MONTO COMSN.</b></label><br><label style="font-size:12px; margin:0; color:gray;">$ '+data.datos_solicitud['porcentaje_dinero']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');



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
                // $("#seeInformationModal .facturaInfo").append('<label color="red;">SIN HAY DATOS A MOSTRAR</label>');
             }
             $("#seeInformationModal .facturaInfo").append('</div>');


        // });
    });

    // $.getJSON( url + "Comisiones/getCambios/"+id_com+"/"+id_pj).done( function( data ){
    //     $.each( data, function( i, v){
    //         fillFields(v, 1);
    //     });
    // });

});




 
 
 
});

//FIN TABLA QUERETARO**************************************************************************************




//INICIO TABLA LEON****************************************************************************************
  var tabla_internomex2;
  $("#tabla_internomex").ready( function(){     

  $('#tabla_internomex thead tr:eq(0) th').each( function (i) {
   if( i!=0 && i!=10){
    var title = $(this).text();

    $(this).html('<input type="text" style="width:100%; background: #003D82; color: white; border: 0; font-weight: 500;"  placeholder="'+title+'"/>' );
    $( 'input', this ).on('keyup change', function () {

        if(tabla_internomex2.column(i).search() !== this.value ) {
            tabla_internomex2
            .column(i)
            .search(this.value)
            .draw();

            var total = 0;
            var index = tabla_internomex2.rows({ selected: true, search: 'applied' }).indexes();
            var data = tabla_internomex2.rows( index ).data();
            $.each(data, function(i, v){
                total += parseFloat(v.porcentaje_dinero);
            });
            var to1 = formatMoney(total);
            document.getElementById("myText_internomex").value = formatMoney(total);
        }
    });
}
});

  $('#tabla_internomex').on('xhr.dt', function ( e, settings, json, xhr ) {
    var total = 0;
    $.each(json.data, function(i, v){
        total += parseFloat(v.porcentaje_dinero);
    });
    var to = formatMoney(total);
    document.getElementById("myText_internomex").value = to;
});

  tabla_internomex2 = $("#tabla_internomex").DataTable({
    dom: 'Brtip',
    width: 'auto',
    "buttons": [
     
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

      {   "width": "5%",
        "data": function( d ){
            return '<p style="font-size: .8em">'+d.id_comision+'</p>';
        }
    },
 
    {   "width": "8%",
        "data": function( d ){
            return '<p style="font-size: .8em">'+d.proyecto+'</p>';
        }
    },
 
    {   "width": "8%",
        "data": function( d ){
            return '<p style="font-size: .8em">'+d.lote+'</p>';
        }
    }, 

    {   "width": "8%",
        "data": function( d ){
            return '<p style="font-size: .8em"><B>'+d.empresa+'</B></p>';
        }
    },

    {   "width": "8%",
        "data": function( d ){
            return '<p style="font-size: .8em">$'+formatMoney(d.total)+'</p>';
        }
    },
    {   "width": "9",
        "data": function( d ){
            return '<p style="font-size: .8em">$'+formatMoney(d.precio_neto)+'</p>';
        }
    },
 
    {   "width": "6%",
        "data": function( d ){
            return '<p style="font-size: .8em">'+(d.porcentaje_decimal).toFixed(2)+' %</p>';
        }
    },

    {   "width": "8%",
        "data": function( d ){
            return '<p style="font-size: .8em"><b>$ '+formatMoney(d.porcentaje_dinero)+'</b></p>';
        }
    },

     {   "width": "9%",
        "data": function( d ){
            if(d.f_pago=='Factura'){
                return '<p style="font-size: .8em"><span class="label" style="background:#8ACA93;">'+(d.f_pago).toUpperCase()+'</span></p>';
            }
            else{
                return '<p style="font-size: .8em"><span class="label" style="background:#98BFDD;">'+(d.f_pago).toUpperCase()+'</span></p>';
            }
        }
    },

     {   "width": "6%",
        "data": function( d ){
            return '<p style="font-size: .8em"><span class="label label-primary">'+d.numero_mensualidad+' / 13</span></p>';
        }
    },

    {   "width": "12%",
        "data": function( d ){
            return '<p style="font-size: .8em">'+d.nombre+" "+d.apellido_paterno+" "+d.apellido_materno+'</p>';
        }
    },
    {   "width": "8%",
        "data": function( d ){
            return '<p style="font-size: .8em"><b>'+(d.puesto).toUpperCase();+'</b></p>';
        }
    },
 

    {   "width": "6%",
        "orderable": false,
          data: function (d) {
            return '<button class="btn btn-round btn-fab btn-fab-mini info" data-value="' + d.id_comision +'" style="margin-right: 3px"><i class="material-icons">info</i></button>';
        }
    
    }],

    columnDefs: [{
        orderable: false,
        className: 'select-checkbox',
        targets:   0,
        'searchable':false,
        'className': 'dt-body-center',
        // 'render': function (d, type, full, meta){
        //     if(full.id_comision){
        //         return '<input type="checkbox" name="idTL[]" style="width:20px;height:20px;"  value="' + full.id_comision + '">';
        //     }else{
        //         return '';
        //     }     
        // },
        select: {
            style:    'os',
            selector: 'td:first-child'
        },
    }],

    "ajax": {
        "url": url2 + "Comisiones/getDatosInternomexContraloria",
        "type": "POST",
        cache: false,
        "data": function( d ){
                }
            },
            "order": [[ 1, 'asc' ]]
    });



// $('#tabla_internomex').on( 'click', 'input', function () {
//     tr = $(this).closest('tr');
//     var row = tabla_internomex2.row( tr ).data();

//     if( row.pa == 0 ){
//         row.pa = row.porcentaje_dinero;
//         totalLeon += parseFloat( row.pa );
//         tr.children().eq(1).children('input[type="checkbox"]').prop( "checked",true );
//     }else{
//         totalLeon -= parseFloat( row.pa );
//         row.pa = 0;
//     }
//     $("#totpagarLeon").html(formatMoney(totalLeon));
// });


$("#tabla_internomex tbody").on("click", ".mas_opciones_8", function(){
    var tr = $(this).closest('tr');
    var row = tabla_internomex2.row( tr );

    $("#modal_info .modal-body").html("");
    $("#modal_info .modal-body").append('<div class="row"><div class="col-lg-12"><p>ASESOR:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p> </div></div>');
    $("#modal_info .modal-body").append('<div class="row"><div class="col-lg-6"><p>PLAN DE PAGO:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div><div class="col-lg-6"><p>NOMBRE LOTE:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div></div>');
    $("#modal_info .modal-body").append('<div class="row"><div class="col-lg-6"><p>VENTA:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div><div class="col-lg-6"><p>COMISIÓN $:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div></div>');
    $("#modal_info .modal-body").append('<div class="row"><div class="col-lg-12"><p>MEDIO(S) DE VENTA:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div></div>');
    $("#modal_info").modal();
});


});

//FIN TABLA LEON****************************************************************************************


 //INICIO TABLA OTRAS****************************************************************************************
  var tabla_otras2;
  $("#tabla_otras").ready( function(){     

  $('#tabla_otras thead tr:eq(0) th').each( function (i) {
   if( i!=0 && i!=10){
    var title = $(this).text();

    $(this).html('<input type="text" style="width:100%; background: #003D82; color: white; border: 0; font-weight: 500;"  placeholder="'+title+'"/>' );
    $( 'input', this ).on('keyup change', function () {

        if(tabla_otras2.column(i).search() !== this.value ) {
            tabla_otras2
            .column(i)
            .search(this.value)
            .draw();

            var total = 0;
            var index = tabla_otras2.rows({ selected: true, search: 'applied' }).indexes();
            var data = tabla_otras2.rows( index ).data();
            $.each(data, function(i, v){
                total += parseFloat(v.porcentaje_dinero);
            });
            var to1 = formatMoney(total);
            document.getElementById("myText_otras").value = formatMoney(total);
        }
    });
}
});

  $('#tabla_otras').on('xhr.dt', function ( e, settings, json, xhr ) {
    var total = 0;
    $.each(json.data, function(i, v){
        total += parseFloat(v.porcentaje_dinero);
    });
    var to = formatMoney(total);
    document.getElementById("myText_otras").value = to;
});

  tabla_otras2 = $("#tabla_otras").DataTable({
    dom: 'Brtip',
    width: 'auto',
    "buttons": [
     
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

      {   "width": "5%",
        "data": function( d ){
            return '<p style="font-size: .8em">'+d.id_comision+'</p>';
        }
    },
 

    {   "width": "8%",
        "data": function( d ){
            return '<p style="font-size: .8em">'+d.proyecto+'</p>';
        }
    },
 
    {   "width": "11%",
        "data": function( d ){
            return '<p style="font-size: .8em">'+d.lote+'</p>';
        }
    }, 

    {   "width": "10%",
        "data": function( d ){
            return '<p style="font-size: .8em">$'+formatMoney(d.total)+'</p>';
        }
    },
    {   "width": "10%",
        "data": function( d ){
            return '<p style="font-size: .8em">$'+formatMoney(d.precio_neto)+'</p>';
        }
    },

    {   "width": "6%",
        "data": function( d ){
            return '<p style="font-size: .8em">'+(d.porcentaje_decimal).toFixed(2)+' %</p>';
        }
    },

    {   "width": "10%",
        "data": function( d ){
            return '<p style="font-size: .8em"><b>$ '+formatMoney(d.porcentaje_dinero)+'</b></p>';
        }
    },

     {   "width": "6%",
        "data": function( d ){
            return '<p style="font-size: .8em"><span class="label label-primary">'+d.numero_mensualidad+' / 13</span></p>';
        }
    },

    {   "width": "14%",
        "data": function( d ){
            return '<p style="font-size: .8em">'+d.nombre+" "+d.apellido_paterno+" "+d.apellido_materno+'</p>';
        }
    },
    {   "width": "10%",
        "data": function( d ){
            return '<p style="font-size: .8em"><b>'+(d.puesto).toUpperCase();+'</b></p>';
        }
    },
 

    {   "width": "10%",
        "orderable": false,
          data: function (d) {
            return '<button class="btn btn-round btn-fab btn-fab-mini info" data-value="' + d.id_comision +'" style="margin-right: 3px"><i class="material-icons">info</i></button>';
        }
    
    }],

    columnDefs: [{
        orderable: false,
        className: 'select-checkbox',
        targets:   0,
        'searchable':false,
        'className': 'dt-body-center',
 
        select: {
            style:    'os',
            selector: 'td:first-child'
        },
    }],

    "ajax": {
        "url": url2 + "Comisiones/getDatosOtrasContraloria",
        "type": "POST",
        cache: false,
        "data": function( d ){
                }
            },
            "order": [[ 1, 'asc' ]]
    });
 
// $('#tabla_otras').on( 'click', 'input', function () {
//     tr = $(this).closest('tr');
//     var row = tabla_otras2.row( tr ).data();

//     if( row.pa == 0 ){
//         row.pa = row.porcentaje_dinero;
//         totalLeon += parseFloat( row.pa );
//         tr.children().eq(1).children('input[type="checkbox"]').prop( "checked",true );
//     }else{
//         totalLeon -= parseFloat( row.pa );
//         row.pa = 0;
//     }
//     $("#totpagarLeon").html(formatMoney(totalLeon));
// });


$("#tabla_otras tbody").on("click", ".mas_opciones_8", function(){
    var tr = $(this).closest('tr');
    var row = tabla_otras2.row( tr );

    $("#modal_info .modal-body").html("");
    $("#modal_info .modal-body").append('<div class="row"><div class="col-lg-12"><p>ASESOR:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p> </div></div>');
    $("#modal_info .modal-body").append('<div class="row"><div class="col-lg-6"><p>PLAN DE PAGO:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div><div class="col-lg-6"><p>NOMBRE LOTE:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div></div>');
    $("#modal_info .modal-body").append('<div class="row"><div class="col-lg-6"><p>VENTA:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div><div class="col-lg-6"><p>COMISIÓN $:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div></div>');
    $("#modal_info .modal-body").append('<div class="row"><div class="col-lg-12"><p>MEDIO(S) DE VENTA:&nbsp;&nbsp;<b>'+row.data().nombreLote+'</b></p></div></div>');
    $("#modal_info").modal();
});


});

//FIN TABLA OTRAS****************************************************************************************

 

 
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
           $($.fn.dataTable.tables(true)).DataTable()
           .columns.adjust();
           //.responsive.recalc();
    });


$(window).resize(function(){
    tabla_nuevas2.columns.adjust();
    tabla_asimilados2.columns.adjust();
    tabla_internomex2.columns.adjust();
    tabla_otras2.columns.adjust();
     
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




function cancela(){
   $("#modal_nuevas").modal('toggle');
} 




 
    $("#form_interes").submit( function(e) {
        e.preventDefault();
    }).validate({
        submitHandler: function( form ) {

            var data = new FormData( $(form)[0] );
            data.append("id_comision", id_comision);

            $.ajax({
                url: url + "Comisiones/pausar_solicitud",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                    type: 'POST', // For jQuery < 1.9
                    success: function(data){
                        if( data[0] ){
                           
                            $("#modal_nuevas").modal('toggle' );
                            tabla_nuevas2.ajax.reload();
                            tabla_otras2.ajax.reload();

                             alert("SE PAUSO CORRECTAMENTE LA SOLICITUD");
                        }else{
                            alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                        }
                    },error: function( ){
                        alert("ERROR EN EL SISTEMA");
                    }
                });
        }
    });







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


 
</script>

<script>
     $(document).ready( function()
   {
      

       $.getJSON( url + "Comisiones/getReporteEmpresa").done( function( data ){
        $(".report_empresa").html();
        $.each( data, function( i, v){
            $(".report_empresa").append('<div class="col xol-xs-3 col-sm-3 col-md-3 col-lg-3"><label style="color: #00B397;">&nbsp;'+v.empresa+': $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #00B397; font-weight: bold;" value="'+formatMoney(v.porc_empresa)+'" disabled="disabled" readonly="readonly" type="text"  name="myText_FRO" id="myText_FRO"></label></div>');
             
        });
    });
    
});
 
                                                         
</script>

