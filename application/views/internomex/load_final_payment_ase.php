<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body class="">
<div class="wrapper">

    <?php $this->load->view('template/sidebar', ""); ?>

    <!-- BEGUIN Modals -->
    <div class="modal" tabindex="-1" role="dialog" id="uploadModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="text-center">Selección de archivo a cargar</h5>
                    <div class="file-gph">
                        <input class="d-none" type="file" id="fileElm">
                        <input class="file-name" id="file-name" type="text" placeholder="No has seleccionada nada aún" readonly="">
                        <label class="upload-btn m-0" for="fileElm">
                            <span>Seleccionar</span>
                            <i class="fas fa-folder-open"></i>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button class="btn btn-primary" id="cargaCoincidencias" data-toggle="modal">Cargar</button>
                </div>
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
                            <i class="fas fa-coins fa-2x"></i>
                        </div>
                        <div class="card-content">
                        <div class="toolbar">
                                <h3 class="card-title center-align">Asignación de monto final pagado</h3>
                                <p class="center-align">A través de este panel podrás descargar una plantilla que agrupara por comisionista los n pagos enviados para cobro. De los cuales, se tendrá que ingresar el monto final pagado.</p>
                                <div class="row aligned-row">
                                    <div class="form-group col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="radio_container w-100">
                                          
                                            <input class="d-none generate1" type="rad io" name="radio" id="one">
                                            <label for="one" class="w-50">Cargar</label>
                                            <input class="d-none find-results" type="radio" checked name="radio" id="two">
                                            <label for="two" class="w-50">Consultar</label>
                                        </div>
                                    </div>
                                    
                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4 d-flex align-center justify-evenly  row-load hide ">
                                            <button class="btn-rounded btn-s-greenLight row-load hide "  id="downloadFile"
                                                    name="downloadFile" title="Download">
                                                <i class="fas fa-download"></i>
                                            </button> <!-- DOWNLOAD -->
                                            <button class="btn-rounded btn-s-blueLight row-load hide" name="uploadFile" id="uploadFile" title="Upload" data-toggle="modal" data-target="#uploadModal">
                                                <i class="fas fa-upload"></i>
                                            </button> <!-- UPLOAD -->
                                        </div>
                                        <div class=" form-group d-flex col col-xs-12 col-sm-12 col-md-4 col-lg-4 align-center justify-evenly  box-table hide">
                                                        <input type="date" class="form-control datepicker beginDate box-table hide" name="startDate" id="startDate"/>
                                                        <input type="date" class="form-control datepicker endDate box-table hide" name="endDate" id="endDate"/>
                                                <button class="btn btn-success btn-round btn-fab btn-fab-mini searchByDateRange box-table hide" name="searchByDateRange" id="searchByDateRange">
                                                    <span class="material-icons update-dataTable">search</span>
                                                </button>
                                             
                                        </div>                    
                                </div>
                                

                                <div class="row pt-2 hide">
                                    <div class="col col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                        <div class="form-group label-floating select-is-empty m-0 p-0">
                                            <select id="columns" name="columns" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona las columnas que se requieran" data-size="10" required multiple>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive box-table ">
                                         
                                         <table id="tableLotificacion" name="tableLotificacion" class="table-striped table-hover">
                                             <thead>
                                             <tr>
                                                 <th>Nombre</th>  
                                                 <th>Rol</th>           
                                                 <th>Forma de pago</th>
                                                 <th>Sede </th>                        
                                                 <th>Monto con descuento</th>
                                                 <th>Monto s/n descuento</th>
                                                 <th>Monto internomex</th>
                                                 <th>Fecha</th>
                                             </tr>
                                             </thead>
                                             <tbody>
                                             </tbody>
                                         </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('template/footer_legend'); ?>
</div>
</div>

<?php $this->load->view('template/footer'); ?>
<!--DATATABLE BUTTONS DATA EXPORT-->
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<!--<script type="text/javascript" src="//unpkg.com/xlsx/dist/xlsx.full.min.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>dist/js/xlsx/xlsx.full.min.js"></script>
<script src="<?= base_url() ?>dist/js/es.js"></script>
    <!-- DateTimePicker Plugin -->
    <script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<script src="<?= base_url() ?>dist/js/jwt/hmac-sha256.js"></script>
<script src="<?= base_url() ?>dist/js/jwt/enc-base64-min.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/general/main_services.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/internomex/internomex.js"></script>
</body>