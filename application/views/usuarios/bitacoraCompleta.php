<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-address-book fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Bitacora Completa</h3>
                                <div class="toolbar">
                                    <div class="row"></div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="material-datatables">
                                            <div class="form-group">
                                                 <table id="users_datatable" class="table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>ESTATUS</th>
                                                            <th>ID</th>
                                                            <th>NOMBRE</th>
                                                            <th>APELLIDOS</th>
                                                            <th>CORREO</th>
                                                            <th>TELÉFONO</th>
                                                            <th>PUESTO</th>
                                                            <th>TIPO</th>
                                                            <th>SEDE</th>
                                                            <th>COORDINADOR</th>
                                                            <th>GERENTE</th>
                                                            <th>SUBDIRECTOR</th>            
                                                            <th>ID JEFE DIRECTO</th>
                                                            <th>FECHA DE REGISTRO A CRM</th>
                                                            <th>FECHA DE ÚLTIMA ACTIVACIÓN A CRM</th>
                                                            <th>FECHA DE ÚLTIMO CAMBIO DE PUESTO</th>
                                                            <th>ETIQUETA FACTOR HUMANO</th>
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
        <?php $this->load->view('template/footer_legend');?>
    </div>
    </div>
    <?php $this->load->view('template/footer');?>
    
    <script src="<?=base_url()?>dist/js/controllers/Usuarios/bitacoraCompleta.js"></script>
</body>