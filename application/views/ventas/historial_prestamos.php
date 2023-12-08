<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>
        
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-wallet fa-2x"></i>
                            </div>
                            <div class="card-content">            
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align" >Historial Descuentos</h3>
                                </div>
                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Acumulado:</h4>
                                                    <p class="input-tot pl-1" name="pagar_descuentos" id="pagar_descuentos">$0.00</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row aligned-row d-flex align-end">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
                                            <div class="form-group">
                                                <label for="proyecto">Mes</label>
                                                    <select name="mes" id="mes" class="selectpicker select-gral m-0" data-style="btn " data-show-subtext="true" data-live-search="true" title="Selecciona mes" data-size="7" required>
                                                        <?php
                                                        setlocale(LC_ALL, 'es_ES');
                                                                    for ($i = 1; $i <= 12; $i++) {
                                                                    $monthNum  = $i;
                                                                    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                                                    $monthName = strftime('%B', $dateObj->getTimestamp());
                                                                    echo '<option value="' . $i . '">' . $monthName . '</option>';
                                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
                                            <div class="form-group">
                                                <label>Año</label>
                                                <select name="anio" id="anio" class="selectpicker select-gral m-0" data-style="btn " data-show-subtext="true" data-live-search="true" title="Selecciona año" data-size="7" required>
                                                    <?php
                                                        setlocale(LC_ALL, 'es_ES');
                                                        for ($i = 2021; $i <= 2024; $i++) {
                                                        $yearName  = $i;
                                                        echo '<option value="' . $i . '">' . $yearName . '</option>';
                                                        }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class="table-striped table-hover" id="tabla_descuentos" name="tabla_descuentos">
                                            <thead>
                                                <tr>
                                                    <th>PROYECTO</th>
                                                    <th>CONDOMINIO</th>
                                                    <th>LOTE</th>
                                                    <th>ID PAGO</th>
                                                    <th>ID PRÉSTAMO</th>
                                                    <th>USUARIO</th>
                                                    <th>PUESTO</th>
                                                    <th>SEDE</th>
                                                    <th>MONTO PRESTÁMO</th>
                                                    <th>ABONADO</th>
                                                    <th>MONTO DEL PAGO</th>
                                                    <th>FECHA</th>
                                                    <th>COMENTARIOS</th>
                                                    <th>COMENTARIO OCULTO</th>
                                                    <th>ESTATUS PRESTÁMO</th>
                                                    <th>TIPO DESCUENTO</th>
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
        <?php $this->load->view('template/footer_legend');?>
    </div>
    </div>
    <?php $this->load->view('template/footer');?>
    <script src="<?= base_url() ?>dist/js/core/modal-general.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/comisiones/historial_prestamos.js"></script>
</body>