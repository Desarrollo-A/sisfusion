<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
  <div class="wrapper">
    <?php $this->load->view('template/sidebar'); ?>

    <div class="content boxContent">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card">
              <div class="card-header card-header-icon" data-background-color="goldMaderas">
                <i class="fas fa-chart-pie fa-2x"></i>
              </div>
              <div class="card-content">
                <div class="encabezadoBox">
                  <h3 class="card-title center-align" >REPORTE COMISIONES</h3>
                  <p class="card-title pl-1">Reporte de todos los bonos y comisiones enviados a contraloría y pagados</p>
                </div>
                <div class="toolbar">
                  <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 overflow-hidden">
                      <div class="form-group">
                        <label className="m-0" for="proyecto">Mes</label>
                        <select name="mes" id="mes" class="selectpicker select-gral m-0" data-style="btn " data-show-subtext="true" data-live-search="true" data-container="body" title="SELECCIONA UNA OPCIÓN" data-size="7" required>
                          <?php
                            setlocale(LC_ALL, 'es_ES');
                            for ($i=1; $i<=12; $i++) {
                              $monthNum  = $i;
                              $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                              $monthName = strftime('%B', $dateObj->getTimestamp());
                              echo '<option value="'.$i.'">'.$monthName.'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 overflow-hidden">
                      <div class="form-group"> 
                        <label className="m-0">Año</label>
                        <select name="anio" id="anio" class="selectpicker select-gral m-0" data-style="btn " data-show-subtext="true" data-live-search="true" data-container="body" title="SELECCIONA UNA OPCIÓN" data-size="7" required>
                          <?php
                            setlocale(LC_ALL, 'es_ES');
                            for ($i=2019; $i<=2021; $i++) {
                                $yearName  = $i;
                                echo '<option value="'.$i.'">'.$yearName.'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div>         
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                      <div class="form-group text-center">
                        <h4 class="title-tot center-align m-0 ">Saldo pendiente comisiones:</h4>
                        <p class="category input-tot pl-1" ><b class="" name="totalC" id="totalC"></b></p>
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                      <div class="form-group text-center">
                        <h4 class="title-tot center-align m-0 ">Total pagado comisiones:</h4>
                        <p class="category input-tot pl-1" ><b class="" name="pagadas_mktd" id="pagadas_mktd"></b></p>
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                      <div class="form-group text-center">
                        <h4 class="title-tot center-align m-0 ">Saldo pendiente MKTD:</h4>
                        <p class="category input-tot pl-1" ><b class="" name="totalM" id="totalM"></b></p>
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                      <div class="form-group text-center">
                        <h4 class="title-tot center-align m-0 ">Total pagado MKTD:</h4>
                        <p class="category input-tot pl-1" ><b class="" name="totalM2" id="totalM2"></b></p>
                      </div>
                    </div>                        
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                      <div class="form-group text-center">
                        <h4 class="title-tot center-align m-0 ">Saldo pendiente NUSKAH:</h4>
                        <p class="category input-tot pl-1" ><b class="" name="totalN" id="totalN"></b></p>
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                      <div class="form-group text-center">
                        <h4 class="title-tot center-align m-0 ">Total pagado NUSKAH:</h4>
                        <p class="category input-tot pl-1" ><b class="" name="totalN2" id="totalN2"></b></p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="material-datatables">
                  <div class="form-group">
                    <table class="table-striped table-hover" id="tabla_bonos" name="tabla_bonos">
                      <thead>
                        <tr>
                          <th>USUARIO</th>
                          <th>COMISIÓN TOTAL</th>
                          <th>Bono NUSKAH</th>
                          <th># PAGO</th>
                          <th>MONTO BONO</th>
                          <th>PAGADO NUSKAH</th>
                          <th>Bono MKTD</th>
                          <th># PAGO</th>
                          <th>MONTO BONO</th>
                          <th>PAGADO MKTD</th>
                          <th>TOTAL</th>
                        </tr>
                        <tr style="background:#003D82 !important;font-size: .7em;line-height:10px;" >
                          <th style="font-size: 1em;"></th>                
                          <th style="font-size: 1em;background-color:#FE9F3F;">MONTO GENERAL DE COMISIÓN</th>
                          <th style="font-size: 1em;background-color:#6393C4;line-height:10px;" colspan="4">BONO NUSKAH - MKTD 5 MENSUALIDADES</th>
                          <th style="font-size: 1em;background-color:#9863C4;line-height:10px;" colspan="4">BONO MARKETING - COMISIONES SIN EVIDENCIA DISPERSADO A 12 MESES ENTRE TODOS LOS INVOLUCRADOS</th>
                          <th style="font-size: 1em;background-color:#37B617;">TOTAL</th>
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
  <script src="<?= base_url() ?>dist/js/controllers/ventas/reporteRevisionMKTD.js"></script>
</body>