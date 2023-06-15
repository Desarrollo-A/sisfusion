<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php
        if($this->session->userdata('id_rol')=="18" || $this->session->userdata('id_rol')=="28" )//contraloria
        {/*-------------------------------------------------------*/
            $this->load->view('template/sidebar');
        }else{
            echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
        }
        ?>

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
                                <!-- <h5 style="color: white;"><b>BITÁCORA DE CAMBIOS</b></h5> -->
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

        <!--<div class="modal fade modal-alertas" id="modal_nuevas" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form method="post" id="form_interes">
                        <div class="modal-body"></div>
                    </form>
                </div>
            </div>
        </div>-->

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="material-icons">reorder</i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align">Historial general</h3>
                                    <p class="card-title pl-1">(Listado de todos los pagos aplicados y en proceso de Marketing Digítal)</p>
                                </div>
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                            <div class="form-group">
                                                <label for="proyecto">Proyecto</label>
                                                <select name="filtro33" id="filtro33" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="Selecciona un proyecto" data-size="7" required> <option value="0">Seleccione todo</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- param -->
                                        <?php
                                            if($this->session->userdata('id_rol') == 13 || $this->session->userdata('id_rol') == 32 || $this->session->userdata('id_rol') == 17){
                                                ?>
                                                <input type="hidden" id="param" name="param" value="0"> 
                                                <?php 
                                            }else{
                                                ?>
                                                <input type="hidden" id="param" name="param" value="1">
                                                <?php
                                            }
                                        ?>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                            <div class="form-group">
                                                <label>Condominio</label>
                                                <select class="selectpicker select-gral" id="filtro44" name="filtro44[]" data-style="btn " data-show-subtext="true" data-live-search="true" title="Selecciona un condominio" data-size="7" required/>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table-striped table-hover" id="tabla_historialGral" name="tabla_historialGral"><thead>
                                                <tr>
                                                    <th id="th_pago">ID</th>
                                                    <th id="th_proyecto">PROY.</th>
                                                    <th id="th_condominio">CONDOMINIO</th>
                                                    <th id="th_lote">LOTE</th>
                                                    <th id="th_ref">REF.</th>
                                                    <th id="th_precio">PRECIO LOTE</th>
                                                    <th id="th_totalcom">TOTAL COM.</th>
                                                    <th id="th_paycliente">PAGO CLIENTE</th>
                                                    <th id="th_abononeo">DISPERSADO</th>
                                                    <th id="th_pagado">PAGADO</th>
                                                    <th id="th_pendiente">PENDIENTE</th>
                                                    <th id="th_usuario">USUARIO</th>
                                                    <th id="th_PUESTO">PLAZA MKTD</th>
                                                    <th id="th_PUESTO">DETALLE</th>
                                                    <th id="th_estatus">ESTATUS</th>
                                                    <th id="th_more">MÁS</th>
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
    
    <script>
    var url = "<?=base_url()?>";
    var url2 = "<?=base_url()?>index.php/";
    </script>
    <script src="<?= base_url() ?>dist/js/controllers/comisiones/historial_marketing.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <script src="<?= base_url() ?>dist/js/dataTables.select.js"></script>
    <script src="<?= base_url() ?>dist/js/dataTables.select.min.js"></script>

</body>