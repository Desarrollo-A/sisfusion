<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <!-- Modals -->
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

        <div class="modal fade"
             id="movimiento-modal"
             tabindex="-1"
             role="dialog"
             aria-labelledby="movimientoModal"
             aria-hidden="true"
             data-backdrop="static"
             data-keyboard="false">
            <div class="modal-dialog modal-md modal-dialog-scrollable"
                 role="document">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="modal-title">Cambio de estatus</h4>
                    </div>

                    <form method="post"
                          class="row"
                          id="estatus-form"
                          autocomplete="off">
                        <div class="modal-body">
                            <div class="col-lg-12">
                                <h5 id="total-pagos">
                                </h5>
                            </div>

                            <div class="col-lg-12"><hr></div>

                            <div class="col-lg-12">
                                <div id="div-options"></div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group is-empty">
                                    <textarea class="form-control"
                                              name="comentario"
                                              id="comentario"
                                              rows="3"
                                              placeholder="Escriba el comentario..."
                                              required></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit"
                                    class="btn btn-primary">
                                Aceptar
                            </button>
                            <button type="button"
                                    class="btn btn-danger btn-simple"
                                    data-dismiss="modal">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
 
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-wallet fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align" >Historial <b>general estatus</b></h3>
                                    <p class="card-title pl-1">(Listado de todos los pagos por proyecto y estatus)</p>
                                </div>
                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <label class="m-0" for="proyecto">Proyecto *</label>
                                                    <select name="filtro33" id="filtro33" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="Selecciona un proyecto" data-size="7" required>
                                                        <option value="0">Seleccione todo</option>
                                                    </select>
                                                    <!-- param -->
                                                    <?php
                                                    if($this->session->userdata('id_rol') == 13 || $this->session->userdata('id_rol') == 32 || $this->session->userdata('id_rol') == 17){
                                                        ?>
                                                        <input type="hidden" id="param" name="param" value="0"> 
                                                        <?php 
                                                    }
                                                    else{
                                                        ?>
                                                        <input type="hidden" id="param" name="param" value="1">
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <label class="m-0" for="filtro44">Estatus *</label>
                                                    <select class="selectpicker select-gral" id="filtro44" name="estatus[]" data-style="btn " data-show-subtext="true" data-live-search="true" title="Selecciona estatus" data-size="7" required/>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <label class="m-0"
                                                           for="roles">Puesto</label>
                                                    <select class="selectpicker select-gral"
                                                            name="roles"
                                                            id="roles"
                                                            required>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <label class="m-0"
                                                           for="users">Usuario</label>
                                                    <select class="selectpicker select-gral"
                                                            id="users"
                                                            name="users"
                                                            data-style="btn"
                                                            data-show-subtext="true"
                                                            data-live-search="true"
                                                            title="SELECCIONA UN USUARIO"
                                                            data-size="7"
                                                            required>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table-striped table-hover" id="tabla_historialGral" name="tabla_historialGral">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>ID</th>
                                                        <th>PROY.</th>
                                                        <th>CONDOMINIO</th>
                                                        <th>LOTE</th>
                                                        <th>REF.</th>
                                                        <th>PRECIO LOTE</th>
                                                        <th>TOTAL COM.</th>
                                                        <th>PAGO CLIENTE</th>
                                                        <th>DISPERSADO</th>
                                                        <th>PAGADO</th>
                                                        <th>PENDIENTE</th>
                                                        <th>USUARIO</th>
                                                        <th>PUESTO</th>
                                                        <th>DETALLE</th>
                                                        <th>ESTATUS</th>
                                                        <th>MÁS</th>
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
    </div>
    </div><!--main-panel close-->
    <?php $this->load->view('template/footer');?>
    <!--DATATABLE BUTTONS DATA EXPORT-->
    <script src="<?= base_url() ?>dist/js/core/modal-general.js"></script>
    <script>
                let rol  = "<?=$this->session->userdata('id_rol')?>";
                var url = "<?=base_url()?>";
                var url2 = url;
    </script>
    <script src="<?= base_url() ?>dist/js/controllers/comisiones/historial_estatus.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <!-- Modal general -->
 
</body>