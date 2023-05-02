<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
<div class="wrapper ">
    <?php
/*-------------------------------------------------------*/
	$datos = array();
	$datos = $datos4;
	$datos = $datos2;
	$datos = $datos3;  
			$this->load->view('template/sidebar', $datos);
 /*--------------------------------------------------------*/
 
    ?>
    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-receipt fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Inventario lotes</h3>
                                <p class="card-title pl-1"></p>
                            </div>
                            <div  class="toolbar">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="col-md-4 form-group">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">PROYECTO</label>
                                                <select name="proyecto"
                                                        id="proyecto" 
                                                        class="selectpicker select-gral m-0"
                                                        data-style="btn"
                                                        data-show-subtext="true"
                                                        title="Selecciona una opción"
                                                        data-size="7"
                                                        data-live-search="true"
                                                        required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">CONDOMINIO</label>
                                                <select name="condominio"
                                                        id="condominio" 
                                                        class="selectpicker select-gral m-0"                                                             
                                                        data-style="btn btn-second"
                                                        data-show-subtext="true"
                                                        data-live-search="true"
                                                        title="Selecciona una opción"
                                                        data-size="7" 
                                                        data-live-search="true"
                                                        required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">ESTATUS</label>
                                                <select name="estatus"
                                                        id="estatus"
                                                        class="selectpicker select-gral m-0"                                                             
                                                        data-style="btn btn-second"
                                                        data-show-subtext="true"
                                                        data-live-search="true"
                                                        title="Selecciona una opción"
                                                        data-size="7"
                                                        data-live-search="true"
                                                        required>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="table-responsive">
                                    <table id="tabla_inventario_contraloria" name="tabla_inventario_contraloria"
                                           class="table-striped table-hover" style="text-align:center;">
                                        <thead>
                                        <tr>
                                            <th>PROYECTO</th>
                                            <th>CONDOMINIO</th>
                                            <th>LOTE</th>
                                            <th>SUP</th>
                                            <th>M2</th>
                                            <th>PRECIO LISTA</th>
                                            <th>TOTAL CON DESCUENTOS</th>
                                            <th>REFERENCIA</th>
                                            <th>MSNI</th>
                                            <th>ASESOR</th>
                                            <th>COORDINADOR</th>
                                            <th>GERENTE</th>
                                            <th>SUBDIRECTOR</th>
                                            <th>DIRECTOR REGIONAL</th>
                                            <th>ESTATUS</th>
                                            <th>FECHA DE APARTADO</th>
                                            <th>COMENTARIO</th>
                                            <th>LUGAR PROSPECCIÓN</th>
                                            <th>FECHA APERTURA</th>
                                            <th>FECHA VAL. ENGANCHE</th>
											<th>CANTIDAD ENGANCHE PAGADO</th>
                                            <th>UBICACIÓN</th>
                                            <th>ACCIONES</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="modal fade" id="seeInformationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                 aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                        aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">Consulta de historial <b id="nomLoteHistorial"></b></h4>
                                        </div>

                                        <div class="modal-body">
                                            <div role="tabpanel">
                                                <ul class="nav nav-tabs" role="tablist" style="background: #003d82;">
                                                    <li role="presentation" class="active"><a href="#changeprocesTab"
                                                                                              aria-controls="changeprocesTab" role="tab"
                                                                                              onclick="javascript:$('#verDet').DataTable().ajax.reload();"
                                                                                              data-toggle="tab">Proceso de
                                                            contratación</a>
                                                    </li>
                                                    <li role="presentation"><a href="#changelogTab" aria-controls="changelogTab"
                                                                               role="tab" data-toggle="tab"
                                                                               onclick="javascript:$('#verDetBloqueo').DataTable().ajax.reload();">Liberación</a>
                                                    </li>
                                                    <li role="presentation"><a href="#coSellingAdvisers"
                                                                               aria-controls="coSellingAdvisers" role="tab"
                                                                               data-toggle="tab"
                                                                               onclick="javascript:$('#seeCoSellingAdvisers').DataTable().ajax.reload();">Asesores
                                                            venta compartida</a>
                                                    </li>
                                                    <li role="presentation" class="hide" id="li_individual_sales"><a
                                                                href="#salesOfIndividuals" aria-controls="salesOfIndividuals" role="tab"
                                                                data-toggle="tab">Clausulas</a></li>
                                                </ul>
                                                <!-- Tab panes -->



                                                <div class="tab-content">
                                                    <div role="tabpanel" class="tab-pane active" id="changeprocesTab">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="card card-plain">
                                                                    <div class="card-content">
                                                                        <div class="material-datatables">
                                                                            <div class="table-responsive">
                                                                                <table id="verDet"
                                                                                       class="table-striped table-hover" style="text-align:center;">
                                                                                    <thead>
                                                                                    <tr>
                                                                                        <th>
                                                                                            LOTE
                                                                                        </th>
                                                                                        <th>
                                                                                            ESTATUS
                                                                                        </th>
                                                                                        <th>
                                                                                            DETALLES
                                                                                        </th>
                                                                                        <th>
                                                                                            COMENTARIOS
                                                                                        </th>
                                                                                        <th>
                                                                                            FECHA
                                                                                        </th>
                                                                                        <th>
                                                                                            USUARIO
                                                                                        </th>
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                        <!--<ul class="timeline timeline-simple" id="changeproces"></ul>-->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div role="tabpanel" class="tab-pane" id="changelogTab">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="card card-plain">
                                                                    <div class="card-content">
                                                                        <!--<ul class="timeline timeline-simple" id="changelog"></ul>-->
                                                                        <div class="material-datatables">
                                                                            <div class="table-responsive">
                                                                                <table id="verDetBloqueo"
                                                                                       class="table-striped table-hover" style="text-align:center;">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>
                                                                                                <center>LOTE</center>
                                                                                            </th>
                                                                                            <th>
                                                                                                <center>PRECIO</center>
                                                                                            </th>
                                                                                            <th>
                                                                                                <center>FECHA LIBERACIÓN</center>
                                                                                            </th>
                                                                                            <th>
                                                                                                <center>COEMNTARIO LIBERACIÓN</center>
                                                                                            </th>
                                                                                            <th>
                                                                                                <center>USUARIO</center>
                                                                                            </th>
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

                                                    <div role="tabpanel" class="tab-pane" id="coSellingAdvisers">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="card card-plain">
                                                                    <div class="card-content">
                                                                        <!--<ul class="timeline timeline-simple" id="changelog"></ul>-->
                                                                        <div class="material-datatables">
                                                                            <div class="table-responsive">
                                                                                <table id="seeCoSellingAdvisers"
                                                                                       class="table-striped table-hover" style="text-align:center;">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>
                                                                                                <center>ASESOR</center>
                                                                                            </th>
                                                                                            <th>
                                                                                                <center>COORDINADOR</center>
                                                                                            </th>
                                                                                            <th>
                                                                                                <center>GERENTE</center>
                                                                                            </th>
                                                                                            <th>
                                                                                                <center>FECHA ALTA</center>
                                                                                            </th>
                                                                                            <th>
                                                                                                <center>USUARIO</center>
                                                                                            </th>
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

                                                    <div role="tabpanel" class="tab-pane" id="salesOfIndividuals">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="card card-plain">
                                                                    <div class="card-content">
                                                                        <h4 id="clauses_content"></h4>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>

                                            </div>
                                            <input type="hidden" name="prospecto_lbl" id="prospecto_lbl">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> CERRAR
                                            </button>
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


<div class="content hide">
		<div class="container-fluid">
            <div class="modal fade" id="seeInformationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Consulta de historial <b id="nomLoteHistorial"></b></h4>
                        </div>

                        <div class="modal-body">
                            <div role="tabpanel">
                                <ul class="nav nav-tabs" role="tablist" style="background: #003d82;">
                                    <li role="presentation" class="active"><a href="#changeprocesTab"
                                                                              aria-controls="changeprocesTab" role="tab"
                                                                              onclick="javascript:$('#verDet').DataTable().ajax.reload();"
                                                                              data-toggle="tab">Proceso de
                                            contratación</a>
                                    </li>
                                    <li role="presentation"><a href="#changelogTab" aria-controls="changelogTab"
                                                               role="tab" data-toggle="tab"
                                                               onclick="javascript:$('#verDetBloqueo').DataTable().ajax.reload();">Liberación</a>
                                    </li>
                                    <li role="presentation"><a href="#coSellingAdvisers"
                                                               aria-controls="coSellingAdvisers" role="tab"
                                                               data-toggle="tab"
                                                               onclick="javascript:$('#seeCoSellingAdvisers').DataTable().ajax.reload();">Asesores
                                            venta compartida</a>
                                    </li>
                                    <li role="presentation" class="hide" id="li_individual_sales"><a
                                                href="#salesOfIndividuals" aria-controls="salesOfIndividuals" role="tab"
                                                data-toggle="tab">Clausulas</a></li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="changeprocesTab">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card card-plain">
                                                    <div class="card-content">
                                                        <!--<ul class="timeline timeline-simple" id="changeproces"></ul>-->
                                                        <table id="verDet" class="table table-bordered table-hover"
                                                               width="100%" style="text-align:center;">
                                                            <thead>
                                                            <tr>
                                                                <th>
                                                                    <center>Lote</center>
                                                                </th>
                                                                <th>
                                                                    <center>Status</center>
                                                                </th>
                                                                <th>
                                                                    <center>Detalles</center>
                                                                </th>
                                                                <th>
                                                                    <center>Comentario</center>
                                                                </th>
                                                                <th>
                                                                    <center>Fecha</center>
                                                                </th>
                                                                <th>
                                                                    <center>Usuario</center>
                                                                </th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                            <tfoot>
                                                            <tr>
                                                                <th>
                                                                    <center>Lote</center>
                                                                </th>
                                                                <th>
                                                                    <center>Status</center>
                                                                </th>
                                                                <th>
                                                                    <center>Detalles</center>
                                                                </th>
                                                                <th>
                                                                    <center>Comentario</center>
                                                                </th>
                                                                <th>
                                                                    <center>Fecha</center>
                                                                </th>
                                                                <th>
                                                                    <center>Usuario</center>
                                                                </th>
                                                            </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="changelogTab">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card card-plain">
                                                    <div class="card-content">
                                                        <!--<ul class="timeline timeline-simple" id="changelog"></ul>-->
                                                        <table id="verDetBloqueo"
                                                               class="table table-bordered table-hover" width="100%"
                                                               style="text-align:center;">
                                                            <thead>
                                                            <tr>
                                                                <th>
                                                                    <center>Lote</center>
                                                                </th>
                                                                <th>
                                                                    <center>Precio</center>
                                                                </th>
                                                                <th>
                                                                    <center>Fecha Liberación</center>
                                                                </th>
                                                                <th>
                                                                    <center>Comentario Liberación</center>
                                                                </th>
                                                                <th>
                                                                    <center>Usuario</center>
                                                                </th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                            <tfoot>
                                                            <tr>
                                                                <th>
                                                                    <center>Lote</center>
                                                                </th>
                                                                <th>
                                                                    <center>Precio</center>
                                                                </th>
                                                                <th>
                                                                    <center>Fecha Liberación</center>
                                                                </th>
                                                                <th>
                                                                    <center>Comentario Liberación</center>
                                                                </th>
                                                                <th>
                                                                    <center>Usuario</center>
                                                                </th>
                                                            </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="coSellingAdvisers">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card card-plain">
                                                    <div class="card-content">
                                                        <!--<ul class="timeline timeline-simple" id="changelog"></ul>-->
                                                        <table id="seeCoSellingAdvisers"
                                                               class="table table-bordered table-hover" width="100%"
                                                               style="text-align:center;">
                                                            <thead>
                                                            <tr>
                                                                <th>
                                                                    <center>Asesor</center>
                                                                </th>
                                                                <th>
                                                                    <center>Coordinador</center>
                                                                </th>
                                                                <th>
                                                                    <center>Gerente</center>
                                                                </th>
                                                                <th>
                                                                    <center>Fecha alta</center>
                                                                </th>
                                                                <th>
                                                                    <center>Usuario</center>
                                                                </th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                            <tfoot>
                                                            <tr>
                                                                <th>
                                                                    <center>Asesor</center>
                                                                </th>
                                                                <th>
                                                                    <center>Coordinador</center>
                                                                </th>
                                                                <th>
                                                                    <center>Gerente</center>
                                                                </th>
                                                                <th>
                                                                    <center>Fecha alta</center>
                                                                </th>
                                                                <th>
                                                                    <center>Usuario</center>
                                                                </th>
                                                            </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="salesOfIndividuals">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card card-plain">
                                                    <div class="card-content">
                                                        <h4 id="clauses_content"></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>
                            <input type="hidden" name="prospecto_lbl" id="prospecto_lbl">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> CERRAR
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="block full">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header card-header-icon" data-background-color="gray"
                                                 style=" background: linear-gradient(45deg, #AEA16E, #96843D);">
                                                <i class="material-icons">list</i>
                                            </div>

                                            <div class="card-content">
                                                <div class="row">
                                                    <h4 class="card-title"><B>Inventario</B> Lotes</h4>
                                                    <div class="container-fluid" style="padding: 20px 20px;">
                                                        <div class="row col col-xs-12 col-sm-12 col-md-12 col-lg-12">

                                                            <div class="col-md-4 form-group">
                                                                <label for="proyecto">Proyecto: </label>
                                                                <select name="proyecto"
                                                                        id="proyecto"
                                                                        class="selectpicker select-gral m-0"                                                             
                                                                        data-style="btn btn-second"
                                                                        data-show-subtext="true"
                                                                        data-live-search="true"
                                                                        title="Selecciona una opción"
                                                                        data-size="7"
                                                                        multiple max required>
                                                                </select>
                                                            </div>

                                                            <div class="col-md-4 form-group">
                                                                <label for="condominio">Condominio: </label>
                                                                <select name="condominio"
                                                                        id="condominio"
                                                                        class="selectpicker select-gral m-0"                                                             
                                                                        data-style="btn btn-second"
                                                                        data-show-subtext="true"
                                                                        data-live-search="true"
                                                                        title="Selecciona una opción"
                                                                        data-size="7" 
                                                                        required>
                                                                </select>
                                                            </div>

                                                            <div class="col-md-4 form-group">
                                                                <label for="estatus">Estatus: </label>
                                                                <select name="estatus"
                                                                        id="estatus"
                                                                        class="selectpicker select-gral m-0"                                                             
                                                                        data-style="btn btn-second"
                                                                        data-show-subtext="true"
                                                                        data-live-search="true"
                                                                        title="Selecciona una opción"
                                                                        data-size="7"
                                                                        required>
                                                                </select>
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

                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-content" style="padding: 50px 20px;">
                                <div class="material-datatables">
                                <table class="table table-responsive table-bordered table-striped table-hover"
                                       id="tabla_inventario_contraloria" name="tabla_inventario_contraloria">

                                    <thead>
                                        <tr>
                                            <th>PROYECTO</th>
                                            <th>CONDOMINIO</th>
                                            <th>LOTE</th>
                                            <th>SUP</th>
                                            <th>M2</th>
                                            <th>PRECIO LISTA</th>
                                            <th>TOTAL CON DESCUENTOS</th>
                                            <th>REFERENCIA</th>
                                            <th>MSNI</th>
                                            <th>ASESOR</th>
                                            <th>COORDINADOR</th>
                                            <th>GERENTE</th>
                                            <th>SUBDIRECTOR</th>
                                            <th>DIRECTOR REGIONAL</th>
                                            <th>ESTATUS</th>
                                            <th>FECHA DE APARTADO</th>      
                                            <th>COMENTARIO</th>
                                            <th>LUGAR PROSPECCIÓN</th>
                                            <th>FECHA APERTURA</th>
                                            <th>FECHA VAL. ENGANCHE</th>
											<th>CANTIDAD ENGANCHE PAGADO</th>
                                            <th>UBICACIÓN</th>
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

    <?php $this->load->view('template/footer_legend');?>
    </div>
        </div>
</div><!--main-panel close-->
</body>
<?php $this->load->view('template/footer');?>
<!--DATATABLE BUTTONS DATA EXPORT-->
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<!--CARGA DE DATOS.-->
<script src="<?= base_url() ?>dist/js/controllers/contraloria/datos_lote_contratacion_c.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/general/main_services.js"></script>

