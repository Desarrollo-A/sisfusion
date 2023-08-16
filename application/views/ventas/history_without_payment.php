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

<!--<div class="modal fade modal-alertas" id="modal_nuevas" role="dialog">
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
</div>-->

 
<!--<div class="modal fade bd-example-modal-sm" id="myModalEnviadas" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body"></div>
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
                                

                                <div class="tab-content">

                                    <div class="tab-pane active" id="nuevas-1">
                                        <div class="content">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                               
                                                                <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                	<h4 class="card-title">HISTORIAL DE COMISIONES SIN PAGO</h4>
                                                                <p class="category">El pago de comisiones no se encuentra reflejado en neodata.</p></div>
                                                            </div>
                                                            <div class="card-content">
                                                                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                	<div class="material-datatables">
                                                                    <div class="form-group">
                                                                        <div class="table-responsive">
                                                                        	<table class="table table-responsive table-bordered table-striped table-hover" id="tabla_historial_comisiones" name="tabla_historial_comisiones">
                                                                                <thead>
                                                                                     <tr>
                                                                                         
                                                                                        <th style="font-size: .8em;">ID LOTE</th>
                                                                                        <th style="font-size: .8em;">LOTE</th>
                                                                                        <th style="font-size: .8em;">REFERENCIA</th>
                                                                                        <th style="font-size: .8em;">PRECIO LOTE</th>
                                                                                        <th style="font-size: .8em;">COMISIÓN TOTAL</th>
                                                                                        <th style="font-size: .8em;">% DECIMAL</th>
                                                                                        <th style="font-size: .8em;">ESTATUS</th>
                                                                                        <th style="font-size: .8em;">PAGO NEODATA</th>
                                                                                        <th style="font-size: .8em;">PAGADO</th>
                                                                                        <th style="font-size: .8em;">USUARIO</th>
                                                                                        <th style="font-size: .8em;">PUESTO</th>
                                                                                         
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

  $("#tabla_historial_comisiones").ready( function(){     
        tabla_nuevas = $("#tabla_historial_comisiones").DataTable({
            dom: 'Bfrtip',
            width: 'auto',
            "language":{ "url": "../../static/spanishLoader.json" },
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

             {
                "width": "5%",
                "data": function( d ){
                    return '<p style="font-size: .8em"><b>'+d.idLote+'</p>';
                }
            },

            {
                "width": "12%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.lote+'</p>';
                }
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+d.referencia+'</p>';
                }
            },
             {
                "width": "9%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+d.precio_lote+' </p>';
                }
            },

            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+formatMoney(d.comision_total)+'%</p>';
                }
            },
             {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em"><b>'+d.porcentaje_decimal+'%</b></p>';
                }
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em"><span class="label" style="background:#D5B226;">SIN PAGO EN NEODATA</span></p>';
                }
            },
          
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.pago_neodata)+'</p>';
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
                    return '<p style="font-size: .8em">'+d.colaborador+'</p>';
                }
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.puesto+'</p>';
                }
            }],
            columnDefs: [

                {
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
                "url": url2 + "Comisiones/getHistoryWithoutPayment",
                    "type": "POST",
                	cache: false,
                	"data": function( d ){}},
                	"order": [[ 1, 'asc' ]]
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

</script>

