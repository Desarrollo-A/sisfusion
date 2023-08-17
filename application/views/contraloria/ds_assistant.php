<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
  <div class="wrapper ">
    <?php $this->load->view('template/sidebar'); ?>

    <!-- Modals -->

    <!-- modal  ENVIA A CONTRALORIA 2-->
    <div class="modal fade" id="modal1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content" >
          <div class="modal-header">
            <center><h4 class="modal-title"><label>Integración de Expediente - <b><span class="lote"></span></b></label></h4></center>
          </div>
          <div class="modal-body">
            <label>Comentario:</label>
            <textarea class="form-control" id="comentario" rows="3"></textarea>
            <br>
          </div>
          <div class="modal-footer">
            <button type="button" id="save1" class="btn btn-success"><span class="material-icons" >send</span> </i> Registrar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- modal  ENVIA A CONTRALORIA 5 por rechazo 1-->
    <div class="modal fade" id="modal2" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content" >
          <div class="modal-header">
            <center><h4 class="modal-title"><label>Integración de Expediente (Rechazo estatus 5 Contraloría) - <b><span class="lote"></span></b></label></h4></center>
          </div>
          <div class="modal-body">
            <label>Comentario:</label>
            <textarea class="form-control" id="comentario2" rows="3"></textarea>
            <br>
          </div>
          <div class="modal-footer">
            <button type="button" id="save2" class="btn btn-success"><span class="material-icons" >send</span> </i> Registrar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- modal  ENVIA A CONTRALORIA 5 por rechazo 1-->
    <div class="modal fade" id="modal3" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content" >
          <div class="modal-header">
            <center><h4 class="modal-title"><label>Integración de Expediente (Rechazo estatus 5 Contraloría) - <b><span class="lote"></span></b></label></h4></center>
          </div>
          <div class="modal-body">
            <label>Comentario:</label>
            <textarea class="form-control" id="comentario3" rows="3"></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" id="save3" class="btn btn-success"><span class="material-icons" >send</span> </i> Registrar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- modal  ENVIA A CONTRALORIA 6 por rechazo 1-->
    <div class="modal fade" id="modal4" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <center><h4 class="modal-title"><label>Integración de Expediente (Rechazo estatus 6 Contraloría) - <b><span class="lote"></span></b></label></h4></center>
          </div>
          <div class="modal-body">
            <label>Comentario:</label>
            <textarea class="form-control" id="comentario4" rows="3"></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" id="save4" class="btn btn-success"><span class="material-icons" >send</span> </i> Registrar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- modal  ENVIA A VENTAS 8 por rechazo 1-->
    <div class="modal fade" id="modal5" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content" >
          <div class="modal-header">
            <center><h4 class="modal-title"><label>Integración de Expediente (Rechazo estatus 8 Ventas) - <b><span class="lote"></span></b></label></h4></center>
          </div>
          <div class="modal-body">
            <label>Comentario:</label>
            <textarea class="form-control" id="comentario5" rows="3"></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" id="save5" class="btn btn-success"><span class="material-icons" >send</span> </i> Registrar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- modal  ENVIA A JURIDICO por rechazo 1-->
    <div class="modal fade" id="modal6" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content" >
          <div class="modal-header">
            <center><h4 class="modal-title"><label>Integración de Expediente (Rechazo estatus 7 Jurídico) - <b><span class="lote"></span></b></label></h4></center>
          </div>
          <div class="modal-body">
            <label>Comentario:</label>
            <textarea class="form-control" id="comentario6" rows="3"></textarea>
            <br>
          </div>
          <div class="modal-footer">
            <button type="button" id="save6" class="btn btn-success"><span class="material-icons" >send</span> </i> Registrar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- modal  ENVIA A JURIDICO por rechazo 1-->
    <div class="modal fade" id="modal7" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content" >
          <div class="modal-header">
            <center><h4 class="modal-title"><label>Integración de Expediente (Rechazo estatus 5 Contraloría) - <b><span class="lote"></span></b></label></h4></center>
          </div>
          <div class="modal-body">
            <label>Comentario:</label>
            <textarea class="form-control" id="comentario7" rows="3"></textarea>
            <br>
          </div>
          <div class="modal-footer">
            <button type="button" id="save7" class="btn btn-success"><span class="material-icons" >send</span> </i> Registrar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- modal  ENVIA A JURIDICO por rechazo 2-->
    <div class="modal fade" id="modal_return1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
          <div class="modal-content" >
              <div class="modal-header">
                  <center><h4 class="modal-title"><label>Integración de Expediente (Rechazo estatus 7 Jurídico) - <b><span class="lote"></span></b></label></h4></center>
              </div>
              <div class="modal-body">
                  <label>Comentario:</label>
                  <textarea class="form-control" id="comentario8" rows="3"></textarea>
                  <br>
              </div>
              <div class="modal-footer">
                  <button type="button" id="b_return1" class="btn btn-success"><span class="material-icons" >send</span> </i> Registrar</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
              </div>
          </div>
      </div>
    </div>

        <!-- modal -->

    <!-- modal  INSERT FILE-->
    <div class="modal fade" id="addFile" >
      <div class="modal-dialog">
        <div class="modal-content" >
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <center><h3 class="modal-title" id="myModalLabel"><span class="lote"></span></h3></center>
          </div>
          <div class="modal-body">
            <div class="input-group">
              <label class="input-group-btn">
                <span class="btn btn-primary btn-file">
                Seleccionar archivo&hellip;<input type="file" name="expediente" id="expediente" style="display: none;">
                </span>
              </label>
              <input type="text" class="form-control" id= "txtexp" readonly>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="sendFile" class="btn btn-primary"><span class="material-icons" >send</span> Guardar documento </button>
            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </div>

    <!--modal que pregunta cuando se esta borrando un archivo-->
    <div class="modal fade" id="cuestionDelete">
      <div class="modal-dialog">
        <div class="modal-content" >
          <div class="modal-header">
            <center><h3 class="modal-title">¡Eliminar archivo!</h3></center>
          </div>
          <div class="modal-body">
            <div class="container-fluid">
              <div class="row centered center-align">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-2">
                  <h1 class="modal-title"> <i class="fa fa-exclamation-triangle fa-2x" aria-hidden="true"></i></h1>
                </div>
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-10">
                  <h4 class="modal-title">¿Está seguro de querer eliminar definivamente este archivo (<b><span class="tipoA"></span></b>)? </h4>
                  <h5 class="modal-title"><i> Esta acción no se puede deshacer.</i> </h5>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <br><br>
            <button type="button" id="aceptoDelete" class="btn btn-primary"> Si, borrar </button>
            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> Cancelar </button>
          </div>
        </div>
      </div>
    </div>
    <!-- END Modals -->

    <!--Contenido de la página-->
    <div class="content boxContent">
      <div class="container-fluid">
        <div class="row">
          <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card">
              <div class="card-header card-header-icon" data-background-color="goldMaderas">
                <i class="material-icons">next_week</i>
              </div>
              <div class="card-content">
                <h3 class="card-title center-align">Depósitos de seriedad</h3>
                <div class="material-datatables">
                  <div class="form-group">
                    <div class="table-responsive">
                      <table class="table-striped table-hover" id="tabla_deposito_seriedad">
                        <thead>
                          <tr>
                            <th>PROYECTO</th>
                            <th>CONDOMINIO</th>
                            <th>LOTE</th>
                            <th>CLIENTE</th>
                            <th>FECHA DE APARTADO</th>
                            <th>FECHA DE VENCIMIENTO</th>
                            <th>COMENTARIO</th>
                            <th>EXPEDIENTE</th>
                            <th>ACCIONES</th>
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
    <?php $this->load->view('template/footer_legend');?>
  </div>
  </div>
  <?php $this->load->view('template/footer');?>
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
  <script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
  <script type="text/javascript">
    Shadowbox.init();
  </script>
  <script></script>
</body>
