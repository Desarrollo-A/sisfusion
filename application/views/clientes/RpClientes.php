<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<div class="wrapper">
<?php $this->load->view('template/sidebar'); ?>

<style type="text/css">
    .container .img{
    text-align:center;
}
.container .details{
    border-left:3px solid #ded4da;
}
.container .details p{
    font-size:15px;
    font-weight:bold;
}
@media screen and (min-width: 990px) { 
      #imgp{
        width: 200px;
        height: 200px;
        border-radius: 50%;
      }
      
    }
    @media screen and (max-width: 990px) { 
      #imgp{
        width: 400px;
        height: 400px;
        border-radius: 50%;
      }
      
    }
    .textoshead::placeholder { color: white; }

</style>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-user-circle fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Reporte general de clientes</h3>
                                <div class="toolbar">
                                    <div class="row">
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table id="tabla_Reporte" class="table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>NOMBRE</th>
                                                        <th>TELÉFONO</th>
                                                        <th>CORREO</th>
                                                        <th>EMPRESA</th>
                                                        <th>ESTADO</th>
                                                        <th>DOMICILIO</th>
                                                        <th>ESTADO CIVIL</th>
                                                        <th>LOTE</th>
                                                        <th>CONDOMINIO</th>
                                                        <th>RESIDENCIAL</th>
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

<div class="content hide">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="block full">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                        <i class="material-icons">list</i>
                                    </div>
                                    <div class="card-content">
                                        <div class="row">
                                            <h4 class="card-title">Reporte general de clientes</h4>
                                            <div class="table-responsive">
                                                <div class="material-datatables">
                                                    <table id="tabla_Reporte" class="table table-striped table-no-bordered table-hover" style="text-align:center;"><!--table table-bordered table-hover -->
                                                        <thead>
                                                        <tr>
                                                            <th class="text-right col-sm-1"><center>Nombre</center></th>
                                                            <th class="text-right col-sm-1"><center>Telefono</center></th>
                                                            <th class="text-right col-sm-1"><center>Correo</center></th>
                                                            <th class=" text-right col-sm-1"><center>Empresa</center></th>
                                                            <th class="text-right col-sm-1"><center>Estado</center></th>
                                                            <th class="text-right col-sm-1"><center>Domicilio</center></th>
                                                            <th class="text-right col-sm-1"><center>Estado civil</center></th>
                                                            <th class="text-right col-sm-1"><center>Lote</center></th>
                                                            <th class="text-right col-sm-1"><center>Condominio</center></th>
                                                            <th class="text-right col-sm-1"><center>Residencial</center></th>
                                                           
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
    </div>
    <?php $this->load->view('template/footer_legend');?>
</div><!--main-panel close-->
<?php $this->load->view('template/footer');?>
<script type="text/javascript">
  let url = "<?=base_url()?>";


      /*agregar input de buscar al header de la tabla*/
      let titulos_intxt = [];
      $('#tabla_Reporte thead tr:eq(0) th').each( function (i) {
          // if( i!=7){
              $(this).css('text-align', 'center');
              var title = $(this).text();
              titulos_intxt.push(title);
              $(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
              $( 'input', this ).on('keyup change', function () {
                  if ($('#tabla_Reporte').DataTable().column(i).search() !== this.value ) {
                      $('#tabla_Reporte').DataTable()
                          .column(i)
                          .search(this.value)
                          .draw();
                  }
              });
          // }

      });
    $(document).ready(function () {
      $('#tabla_Reporte').DataTable({
          dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
          buttons: [
              {

                  extend: 'excelHtml5',
                  text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                  className: 'btn buttons-excel',
                  titleAttr: 'Reporte general de clientes',
                  title:'Reporte general de clientes' ,
                  exportOptions: {
                      columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                      format: {
                          header:  function (d, columnIdx) {
                              switch (columnIdx) {
                                  case 0:
                                      return 'NOMBRE';
                                      break;
                                  case 1:
                                      return 'TELÉFONO';
                                      break;
                                  case 2:
                                      return 'CORREO';
                                      break;
                                  case 3:
                                      return 'EMPRESA';
                                      break;
                                  case 4:
                                      return 'ESTADO';
                                      break;
                                  case 5:
                                      return 'DOMICILIO';
                                      break;
                                  case 6:
                                      return 'ESTADO CIVIL';
                                      break;
                                  case 7:
                                      return 'LOTE';
                                      break;
                                  case 8:
                                      return 'CONDOMINIO';
                                      break;
                                  case 9:
                                      return 'RESIDENCIAL';
                                      break;
                              }
                          }
                      }
                  }
              }
          ],
          columnDefs: [{
              defaultContent: "",
              targets: "_all",
              searchable: true
          }],
          scrollX: true,
          fixedHeader: true,
          pageLength: 10,
          width: '100%',
          pagingType: "full_numbers",
          language: {
              url: "<?=base_url()?>/static/spanishLoader_v2.json",
              paginate: {
                  previous: "<i class='fa fa-angle-left'>",
                  next: "<i class='fa fa-angle-right'>"
              }
          },
        destroy: true,
        columns: [
            { data: function (d) {
                    return d.nombre;
                }
            },
            { data: function (d) {
                    return d.telefono;
                }
            },
            { data: function (d) {
                    return d.correo;
                }
            },
            { data: function (d) {
                    return d.empresa;
                }
            },
            
            { data: function (d) {
                    return d.originario_de;
                }
            },
            { data: function (d) {
                    return d.domicilio_particular;
                }
            },
            { data: function (d) {
                    return d.civil;
                }
            },
            { data: function (d) {

                    return d.nombreLote;

                }
            },
            { data: function (d) {

                    return d.condominio;

                }
            },
            { data: function (d) {

                    return d.nombreResidencial;

                }
            }
        ],
        "ajax": {
            "url": "getRpClientes",
            "type": "POST",
            cache: false,
            "data": function( d ){
            }
        }
    });

});




</script>
</body>
</html>