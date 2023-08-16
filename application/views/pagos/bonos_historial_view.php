<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
  <div class="wrapper">

    <?php $this->load->view('template/sidebar'); ?>

    <!-- Modals -->
    <div class="modal fade modal-alertas" id="myModalEspera" role="dialog">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <form method="post" id="form_espera_uno">
            <div class="modal-body"></div>
            <div class="modal-footer"></div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade modal-alertas" id="modal-delete" role="dialog">
      <div class="modal-dialog modal-sm">
        <div class="modal-content" >
            <div class="modal-body"></div>
            <div class="modal-footer"></div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal_bonos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="material-icons" onclick="cleanCommentsAsimilados()">clear</i>
              </button>
            </div>
            <div class="modal-body">
              <div role="tabpanel">
                <ul class="nav nav-tabs" role="tablist" style="background: #949494;">
                  <div id="nameLote"></div>
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
    
    <div class="modal fade modal-alertas" id="modal_abono" data-backdrop="static" data-keyboard="false" role="dialog">
      <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header"></div>
            <form method="post" id="form_abono">
              <div class="modal-body"></div>
              <div class="modal-footer"></div>
            </form>
        </div>
      </div>
    </div>
    <!-- END Modals -->
  
    <div class="content boxContent">
      <div class="container-fluid">
        <div class="row">
          <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card">
              <div class="card-header card-header-icon" data-background-color="goldMaderas">
                <i class="fas fa-gift fa-2x"></i>
              </div>
              <div class="card-content">
                <div class="encabezadoBox">
                  <h3 class="card-title center-align" >Historial de bonos</h3>
                  <p class="card-title pl-1">(Historial de todos los bonos y estatus de pago, para ver bonos activos y/o agregar un abono puedes consultarlos en el panel "Bonos")</p>
                </div>
                <div class="toolbar">
                  <div class="container-fluid p-0">
                    <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group d-flex justify-center align-center">
                          <h4 class="title-tot center-align m-0">Total bonos:</h4>
                          <p class="input-tot pl-1" name="totalp" id="totalp">$0.00</p>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                          <label class="m-0" for="roles">Puesto</label>
                          <select class="selectpicker select-gral" name="roles" id="roles" required>
                            <option value="" disabled="true" selected="selected">Selecciona un rol </option>
                            <?php
                            if($this->session->userdata('id_rol') == 18){
                              echo '  <option value="20">Marketing Digital</option>';
                            } 
                            else{
                              echo '
                              <option value="7">Asesor</option>
                              <option value="9">Coordinador</option>
                              <option value="3">Gerente</option>
                              <option value="2">Sub director</option>   
                              <option value="20">Marketing Digital</option> 
                              ';
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                          <label class="m-0" for="users">Usuario</label>
                          <select class="selectpicker select-gral" id="users" name="users" data-style="btn " data-show-subtext="true" data-live-search="true" title="SELECCIONA UN USUARIO" data-size="7" required></select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="material-datatables">
                  <div class="form-group">
                    <div class="table-responsive">
                      <table class="table-striped table-hover" id="tabla_bonos" name="tabla_bonos">
                        <thead>
                        <tr>
                          <th>ID PAGO</th>
                          <th># BONO</th>
                          <th>USUARIO</th>
                          <th>RFC</th>
                          <th>PUESTO</th>
                          <th>MONTO BONO</th>
                          <th>ABONADO</th>
                          <th>PENDIENTE</th>
                          <th># PAGOS</th>
                          <th>MONTO INDIVIDUAL</th>
                          <th>IMPUESTO</th>
                          <th>TOTAL A PAGAR</th>
                          <th>FECHA CREACIÓN</th>
                          <th>ESTATUS</th>
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
    <?php $this->load->view('template/footer_legend');?>
  </div>
  </div><!--main-panel close-->
  <?php $this->load->view('template/footer');?>
  <!--DATATABLE BUTTONS DATA EXPORT-->
  <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
  <script src="<?= base_url() ?>dist/js/controllers/pagos/bonos_historial.js"></script>
</body>