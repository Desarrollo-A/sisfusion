<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
    <div class="wrapper ">
        <?php
            switch ($this->session->userdata('id_rol')) {
                case '18':
                    // code...
                    $datos = array();
                    $datos = $datos4;
                    $datos = $datos2;
                    $datos = $datos3;
                    $this->load->view('template/sidebar', $datos);
                    break;
                default:
                    // code...
                    echo '<script>alert("ACCESSO DENEGADO"); window.location.href="' . base_url() . '";</script>';
                    break;
            }
        ?>
        <!--Contenido de la página-->
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-user-friends fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Clientes por proyecto</h3>
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label class="m-0" for="proyecto">Proyecto</label>
                                                <select name="proyecto" id="proyecto" class="selectpicker select-gral m-0"
                                                        data-style="btn" data-show-subtext="true"  data-live-search="true" title="Selecciona proyecto" data-size="7" required>
                                                    <option value="0">Seleccionar todo</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table-striped table-hover"
                                                id="tabla_clientes" name="tabla_clientes">
                                                <thead>
                                                <tr>
                                                    <th>PROYECTO</th>
                                                    <th>CONDOMINIO</th>
                                                    <th>ID LOTE</th>
                                                    <th>ESTATUS CONTRATACION</th>
                                                    <th>ESTATUS LOTE</th>
                                                    <th>NOMBRE COMPLETO</th>
                                                    <th>FECHA APARTADO</th>
                                                    <th>PERSONALIDAD JURIDICA</th>
                                                    <th>FECHA NACIMIENTO</th>
                                                    <th>EDAD</th>
                                                    <th>OCUPACION</th>
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
            <?php $this->load->view('template/footer_legend'); ?>
        </div>
    </div><!--main-panel close-->
    <?php $this->load->view('template/footer');?>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>dist/js/controllers/clientes/consulta_clientes_proyecto.js"></script>
</body>