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
                                                <select name="proyecto" id="proyecto" class="selectpicker select-gral m-0"
                                                        data-style="btn" data-show-subtext="true"  title="Selecciona proyecto"
                                                        data-size="7" data-live-search="true" required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">CONDOMINIO</label>
                                                <select name="condominio" id="condominio" class="selectpicker select-gral m-0"
                                                        data-style="btn" data-show-subtext="true"  title="Selecciona condominio"
                                                        data-size="7" data-live-search="true" required>
                                                    <option disabled selected>- SELECCIONA CONDOMINIO -</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">ESTATUS</label>
                                                <select name="estatus" id="estatus" class="selectpicker select-gral m-0"
                                                        data-style="btn" data-show-subtext="true"  title="Selecciona estatus"
                                                        data-size="7" data-live-search="true" required>
                                                    <option disabled selected>- SELECCIONA ESTATUS -</option>
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
                                            <th>FECHA.AP</th>
                                            <th>COMENTARIO</th>
                                            <th>LUGAR PROSPECCIÓN</th>
                                            <th>FECHA APERTURA</th>
                                            <th>FECHA VAL. ENGANCHE</th>
											<th>CANTIDAD ENGANCHE PAGADO</th>
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
                                                                <select name="proyecto" id="proyecto" class="selectpicker"
                                                                        data-style="btn btn-second" data-show-subtext="true"
                                                                        data-live-search="true"
                                                                        title="--SELECCIONA PROYECTO--" data-size="7"
                                                                        multiple max required>
                                                                </select>
                                                            </div>

                                                            <div class="col-md-4 form-group">
                                                                <label for="condominio">Condominio: </label>
                                                                <select name="condominio" id="condominio"
                                                                        class="selectpicker" data-style="btn btn-second"
                                                                        data-show-subtext="true" data-live-search="true"
                                                                        title="" data-size="7" required>
                                                                    <option disabled selected>- SELECCIONA CONDOMINIO -
                                                                    </option>
                                                                </select>
                                                            </div>

                                                            <div class="col-md-4 form-group">
                                                                <label for="estatus">Estatus: </label>
                                                                <select name="estatus" id="estatus" class="selectpicker"
                                                                        data-style="btn btn-second" data-show-subtext="true"
                                                                        data-live-search="true" title="" data-size="7"
                                                                        required>
                                                                    <option disabled selected>- SELECCIONA ESTATUS -
                                                                    </option>
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
                                            <th style="font-size: .9em;">PROYECTO</th>
                                            <th style="font-size: .9em;">CONDOMINIO</th>
                                            <th style="font-size: .9em;">LOTE</th>
                                            <th style="font-size: .9em;">SUP</th>
                                            <th style="font-size: .9em;">M2</th>
                                            <th style="font-size: .9em;">PRECIO LISTA</th>
                                            <th style="font-size: .9em;">TOTAL CON DESCUENTOS</th>
                                            <th style="font-size: .9em;">REFERENCIA</th>
                                            <th style="font-size: .9em;">MSNI</th>
                                            <th style="font-size: .9em;">ASESOR</th>
                                            <th style="font-size: .9em;">COORDINADOR</th>
                                            <th style="font-size: .9em;">GERENTE</th>
                                            <th style="font-size: .9em;">SUBDIRECTOR</th>
                                            <th style="font-size: .9em;">DIRECTOR REGIONAL</th>
                                            <th style="font-size: .9em;">ESTATUS</th>
                                            <th style="font-size: .9em;">FECHA.AP</th>
                                            <th style="font-size: .9em;">COMENTARIO</th>
                                            <th style="font-size: .9em;">LUGAR PROSPECCIÓN</th>
                                            <th style="font-size: .9em;">FECHA APERTURA</th>
                                            <th style="font-size: .9em;">FECHA VAL. ENGANCHE</th>
											<th style="font-size: .9em;">CANTIDAD ENGANCHE PAGADO</th>
                                            <th style="font-size: .9em;">ACCIONES</th>
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
<script>

var url = "<?=base_url()?>";
var url2 = "<?=base_url()?>/index.php/";
var urlimg = "<?=base_url()?>/img/";

$(document).ready(function(){
	$.post(url + "Contratacion/lista_proyecto", function(data) {
		var len = data.length;
		for(var i = 0; i<len; i++)
		{
			var id = data[i]['idResidencial'];
			var name = data[i]['descripcion'];
			$("#proyecto").append($('<option>').val(id).text(name.toUpperCase()));
		}

		$("#proyecto").selectpicker('refresh');
	}, 'json');

	$.post(url + "Contratacion/lista_estatus", function(data) {
		var len = data.length;
		for( var i = 0; i<len; i++)
		{
			var id = data[i]['idStatusLote'];
			var name = data[i]['nombre'];
			$("#estatus").append($('<option>').val(id).text(name.toUpperCase()));
		}
		$("#estatus").selectpicker('refresh');
	}, 'json');
});


$('#proyecto').change( function(){
	index_proyecto = $(this).val();
	$("#condominio").html("");
	$(document).ready(function(){
		$.post(url + "Contratacion/lista_condominio/"+index_proyecto, function(data) {
			var len = data.length;
			$("#condominio").append($('<option disabled selected>- SELECCIONA CONDOMINIO -</option>'));

			for( var i = 0; i<len; i++)
			{
				var id = data[i]['idCondominio'];
				var name = data[i]['nombre'];
				$("#condominio").append($('<option>').val(id).text(name.toUpperCase()));
			}
			$("#condominio").selectpicker('refresh');
		}, 'json');
	});
});

       $('#tabla_inventario_contraloria thead tr:eq(0) th').each( function (i) {
           if(i!=17){
               var title = $(this).text();
               $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500;" class="textoshead"  placeholder="'+title+'"/>' );
               $( 'input', this ).on('keyup change', function () {
                   if ($('#tabla_inventario_contraloria').DataTable().column(i).search() !== this.value ) {
                       $('#tabla_inventario_contraloria').DataTable().column(i).search(this.value).draw();
                   }
               });
           }

       });

$(document).on('change','#proyecto, #condominio, #estatus', function() {
	ix_proyecto = $("#proyecto").val();
   	ix_condominio = $("#condominio").val();
   	ix_estatus = $("#estatus").val();

   	tabla_inventario = $("#tabla_inventario_contraloria").DataTable({
        dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
        destroy: true,
   		"ajax":
   		{
   			"url": '<?=base_url()?>index.php/Contratacion/get_inventario/'+ix_estatus+"/"+ix_condominio+"/"+ix_proyecto,
   			"dataSrc": ""
   		},
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Inventario Lotes',
                    title:"Inventario Lotes",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return 'PROYECTO';
                                        break;
                                    case 1:
                                        return 'CONDOMINIO';
                                        break;
                                    case 2:
                                        return 'LOTE';
                                    case 3:
                                        return 'SUP';
                                        break;
                                    case 4:
                                        return 'M2';
                                        break;
                                    case 5:
                                        return 'PRECIO LISTA';
                                        break;
                                    case 6:
                                        return 'TOTAL DESCUENTOS';
                                        break;
                                    case 7:
                                        return 'REFERENCIA';
                                        break;
                                    case 8:
                                        return 'MSI';
                                        break;
                                    case 9:
                                        return 'ASESOR';
                                        break;
                                    case 10:
                                        return 'COORDINADOR';
                                        break;
                                    case 11:
                                        return 'GERENTE';
                                        break;
                                    case 12:
                                        return 'SUBDIRECTOR';
                                        break;
                                    case 13:
                                        return 'DIRECTOR REGIONAL';
                                        break;
                                    case 14:
                                        return 'ESTATUS';
                                        break;
                                    case 15:
                                        return 'FECHA AP';
                                        break;
                                    case 16:
                                        return 'COMENTARIO';
                                        break;
                                    case 17:
                                        return 'LUGAR PROSPECCIÓN';
                                        break;
                                    case 18:
                                        return 'FECHA APERTURA';
                                        break;
                                    case 19:
										return 'FECHA VALIDACION ENGANCHE';
										break;
									case 20:
										return 'CANTIDAD ENGANCHE PAGADO';
										break;
                                }
                            }
                        }
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                    className: 'btn buttons-pdf',
                    titleAttr: 'Inventario Lotes',
                    title: "Inventario Lotes",
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return 'PROYECTO';
                                        break;
                                    case 1:
                                        return 'CONDOMINIO';
                                        break;
                                    case 2:
                                        return 'LOTE';
                                    case 3:
                                        return 'SUP';
                                        break;
                                    case 4:
                                        return 'M2';
                                        break;
                                    case 5:
                                        return 'PRECIO LISTA';
                                        break;
                                    case 6:
                                        return 'TOTAL DESCUENTOS';
                                        break;
                                    case 7:
                                        return 'REFERENCIA';
                                        break;
                                    case 8:
                                        return 'MSI';
                                        break;
                                    case 9:
                                        return 'ASESOR';
                                        break;
                                    case 10:
                                        return 'COORDINADOR';
                                        break;
                                    case 11:
                                        return 'GERENTE';
                                        break;
                                    case 12:
                                        return 'SUBDIRECTOR';
                                        break;
                                    case 13:
                                        return 'DIRECTOR REGIONAL';
                                        break;
                                    case 14:
                                        return 'ESTATUS';
                                        break;
                                    case 15:
                                        return 'FECHA AP';
                                        break;
                                    case 16:
                                        return 'COMENTARIO';
                                        break;
                                    case 17:
                                        return 'LUGAR PROSPECCIÓN';
                                        break;
                                    case 18:
                                        return 'FECHA APERTURA';
                                        break;
                                    case 19:
										return 'FECHA VALIDACION ENGANCHE';
										break;
									case 20:
										return 'CANTIDAD ENGANCHE PAGADO';
										break;
                                }
                            }
                        }
                    }
                }
            ],
        language: {
            url: "<?=base_url()?>/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
		processing: true,
		pageLength: 10,
		bAutoWidth: false,
		bLengthChange: false,
		scrollX: true,
		bInfo: true,
		searching: true,
		paging: true,
		ordering: true,
		fixedColumns: true,
		columnDefs: [{
                defaultContent: "",
                targets: "_all",
                searchable: true,
                orderable: false
            }],
		columns:
		[{
			"width": "10%",
			data: 'nombreResidencial'
		},
		{
			"width": "10%",
			"data": function(d){
				return '<p>'+(d.nombreCondominio).toUpperCase()+'</p>';
			}
		},
		{
			"width": "14%",
			"data": function(d){
                if (d.casa == 1)
                    return `${d.nombreLote} <br><span class="label" style="background:#D7BDE2; color:#512E5F;">${d.nombre_tipo_casa}</span>`
				else
					return (d.nombreLote).toUpperCase();
			}
		},
		{
			"width": "10%",
			"data": function(d){
				return '<p>'+d.superficie+'</p>';
			}
		},
	    {
			"width": "10%",
			"data": function(d){
				
				
		var preciom2;				
				
		if(d.nombreResidencial == 'CCMP'){
			
			if(d.idStatusLote != 3){
				var stella;
				var aura;
				
				if (d.nombreLote == 'CCMP-LAMAY-011' || d.nombreLote == 'CCMP-LAMAY-021' || d.nombreLote == 'CCMP-LAMAY-030' ||
					d.nombreLote == 'CCMP-LAMAY-031' || d.nombreLote == 'CCMP-LAMAY-032' || d.nombreLote == 'CCMP-LAMAY-045' ||
					d.nombreLote == 'CCMP-LAMAY-046' || d.nombreLote == 'CCMP-LAMAY-047' || d.nombreLote == 'CCMP-LAMAY-054' || 
					d.nombreLote == 'CCMP-LAMAY-064' || d.nombreLote == 'CCMP-LAMAY-079' || d.nombreLote == 'CCMP-LAMAY-080' ||
					d.nombreLote == 'CCMP-LAMAY-090' || d.nombreLote == 'CCMP-LIRIO-010' ||
					
					d.nombreLote == 'CCMP-LIRIO-010' ||
					d.nombreLote == 'CCMP-LIRIO-033' || d.nombreLote == 'CCMP-LIRIO-048' || d.nombreLote == 'CCMP-LIRIO-049' ||
					d.nombreLote == 'CCMP-LIRIO-067' || d.nombreLote == 'CCMP-LIRIO-089' || d.nombreLote == 'CCMP-LIRIO-091' ||
					d.nombreLote == 'CCMP-LIRIO-098' || d.nombreLote == 'CCMP-LIRIO-100') {
					    
						stella = ( (parseInt(d.total) + parseInt(2029185)) / d.superficie);
						aura = ( (parseInt(d.total) + parseInt(1037340)) / d.superficie );
					    
						preciom2 = '<p>S:'+formatMoney(stella)+'</p>' +'A:'+formatMoney(aura);


				} else {
					
						stella = ( (parseInt(d.total) + parseInt(2104340)) / d.superficie );
						aura = ( (parseInt(d.total) + parseInt(1075760)) / d.superficie );
					
						preciom2 = '<p>S:'+formatMoney(stella)+'</p>' +'A:'+formatMoney(aura);

				}
			} else if(d.idStatusLote == 3) {
			
			preciom2 = '<p>'+formatMoney(d.precio)+'</p>';

			}
			
		} else {
		
			preciom2 = '<p>'+formatMoney(d.precio)+'</p>';

		}

		return preciom2;
				
				
			}
		},
		{
			"width": "10%",
			"data": function(d){
				
		var preciot;				
				
		if(d.nombreResidencial == 'CCMP'){
			
			if(d.idStatusLote != 3){
				var stella;
				var aura;
				
				if (d.nombreLote == 'CCMP-LAMAY-011' || d.nombreLote == 'CCMP-LAMAY-021' || d.nombreLote == 'CCMP-LAMAY-030' ||
					d.nombreLote == 'CCMP-LAMAY-031' || d.nombreLote == 'CCMP-LAMAY-032' || d.nombreLote == 'CCMP-LAMAY-045' ||
					d.nombreLote == 'CCMP-LAMAY-046' || d.nombreLote == 'CCMP-LAMAY-047' || d.nombreLote == 'CCMP-LAMAY-054' || 
					d.nombreLote == 'CCMP-LAMAY-064' || d.nombreLote == 'CCMP-LAMAY-079' || d.nombreLote == 'CCMP-LAMAY-080' ||
					d.nombreLote == 'CCMP-LAMAY-090' || d.nombreLote == 'CCMP-LIRIO-010' ||
					
					d.nombreLote == 'CCMP-LIRIO-010' ||
					d.nombreLote == 'CCMP-LIRIO-033' || d.nombreLote == 'CCMP-LIRIO-048' || d.nombreLote == 'CCMP-LIRIO-049' ||
					d.nombreLote == 'CCMP-LIRIO-067' || d.nombreLote == 'CCMP-LIRIO-089' || d.nombreLote == 'CCMP-LIRIO-091' ||
					d.nombreLote == 'CCMP-LIRIO-098' || d.nombreLote == 'CCMP-LIRIO-100') {
					    
						stella = ( parseInt(d.total) + parseInt(2029185) );
						aura = ( parseInt(d.total) + parseInt(1037340) );
					    
						preciot = '<p>S:'+formatMoney(stella)+'</p>' +'A:'+formatMoney(aura);


				} else {
					
						stella = ( parseInt(d.total) + parseInt(2104340) );
						aura = ( parseInt(d.total) + parseInt(1075760) );
					
						preciot = '<p>S:'+formatMoney(stella)+'</p>' +'A:'+formatMoney(aura);

				}
			} else if(d.idStatusLote == 3){
			
			preciot = '<p>'+formatMoney(d.total)+'</p>';

			}
			
		} else {
		
			preciot = '<p>'+formatMoney(d.total)+'</p>';

		}

		return preciot;
						
			}
		},
		{
			"width": "10%",
			"data": function(d){
				if (d.totalNeto2 == null || d.totalNeto2 == '' || d.totalNeto2 == undefined) {
					return '$0.00';
				} else {
					return formatMoney(d.totalNeto2);
				}
			}
		},
		{
			"width": "10%",
			data: 'referencia'
		},
		{
			"width": "5%",
			data: 'msni'
		},
		{
			data: function(d){
				var asesor;
				if(d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
					asesor = d.asesor2 == '  ' ? 'SIN ESPECIFICAR' : d.asesor2;
				else
					asesor = d.asesor == '  ' ? 'SIN ESPECIFICAR' : d.asesor;
				return asesor;
			}
		},
		{
			data: function(d){
				var coordinador;
				if(d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
					coordinador = d.coordinador2 == '  ' ? 'SIN ESPECIFICAR' : d.coordinador2;
				else
					coordinador = d.coordinador == '  ' ? 'SIN ESPECIFICAR' : d.coordinador;
				return coordinador;
			}
		},
		{
			data: function(d){
				var gerente;
				if(d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
					gerente = d.gerente2 == '  ' ? 'SIN ESPECIFICAR' : d.gerente2;
				else
					gerente = d.gerente == '  ' ? 'SIN ESPECIFICAR' : d.gerente;
				return gerente;
			}
		},
		{
			data: function(d){
				var subdirector;
				if(d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
					subdirector = d.subdirector2 == '  ' ? 'SIN ESPECIFICAR' : d.subdirector2;
				else
					subdirector = d.subdirector == '  ' ? 'SIN ESPECIFICAR' : d.subdirector;
				return subdirector;
			}
		},
		{
			data: function(d){
				var regional;
				if(d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
					regional = d.regional2 == '  ' ? 'SIN ESPECIFICAR' : d.regional2;
				else
					regional = d.regional == '  ' ? 'SIN ESPECIFICAR' : d.regional;
				return regional;
			}
		},
		{
			"width": "12%",
			"data": function(d){
			    libContraloria = (d.observacionContratoUrgente == '1') ? '<center><span class="label" style="background:#E6B0AA; color:#641E16">Lib. Contraloría</span> <center><p><p>' : '';

                valTV = (d.tipo_venta == null) ? `<center><span class="label" style="background:#${d.background_sl}; color:#${d.color};">${d.descripcion_estatus}</span> <center>` :
				`<center><span class="label" style="background:#${d.background_sl}; color:#${d.color};">${d.descripcion_estatus}</span> <p><p> <span class="label" style="background:#A5D6A7; color:#1B5E20;">${d.tipo_venta}</span> <center>`;

				return valTV + libContraloria;
			}
		},
		{
			"width": "10%",
			"data": function(d){
				
				if(d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10){
				  return '<p>'+d.fecha_modst+'</p>';
				} else {
				  return '<p>'+d.fechaApartado+'</p>';

				}
			}
		},
		{
			"width": "16%",
			"data": function(d){

				
				if(d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10 || d.idStatusLote == 11 || d.idStatusLote == 4 
				   || d.idStatusLote == 6 || d.idStatusLote == 7){
					
						if(d.motivo_change_status=='NULL'||d.motivo_change_status=='null'||d.motivo_change_status==null){
							return ' - ';
						}
						else {
							return '<p>'+d.motivo_change_status+'</p>';
						}
						
				} else {
				
						if(d.comentario=='NULL'||d.comentario=='null'||d.comentario==null){
							return ' - ';
						}
						else {
							return '<p>'+d.comentario+'</p>';
						}
				  
				}
				
			}
		},
		{
                "width": "50%",
                "data": function(d){
                    if(d.lugar_prospeccion=='NULL'||d.lugar_prospeccion=='null'||d.lugar_prospeccion==null){
                        return ' - ';
                    }
                    else
                    {
                        return '<p>'+d.lugar_prospeccion+'</p>';
                    }
                }
            },
            {
                "width": "5%",
                "data": function(d){
                    if(d.fecha_creacion == 'NULL' || d.fecha_creacion == 'null' || d.fecha_creacion == null){
                        return ' - ';
                    }
                    else
                    {
                        return '<p>'+d.fecha_creacion+'</p>';
                    }
                }
            },
            {
				"width": "8%",
				data: 'fecha_validacion'
			},
			{
				"width": "8%",
				"data": function( d ){
					return '<p>$ '+formatMoney(d.cantidad_enganche)+'</p>';
				}
			},
		{
			"width": "8%",
			"data": function( d ){
				return '<center><button class="btn-data btn-green ver_historial" value="' + d.idLote +'" data-nomLote="'+d.nombreLote+'" data-tipo-venta="'+d.tipo_venta+'" title="Ver detalles generales"><i class="fas fa-history"></i></button></center>';
			}
		}
		]
	});


    $(window).resize(function(){
    tabla_inventario.columns.adjust();
	});
});
$(document).on("click", ".ver_historial", function(){
	var tr = $(this).closest('tr');
	var row = tabla_inventario.row( tr );
	idLote = $(this).val();
	var $itself = $(this);

	var element = document.getElementById("li_individual_sales");

	if ($itself.attr('data-tipo-venta') == 'Venta de particulares') {
		$.getJSON(url+"Contratacion/getClauses/"+idLote).done( function( data ){
			$('#clauses_content').html(data[0]['nombre']);
		});
		element.classList.remove("hide");
	} else {
		element.classList.add("hide");
		$('#clauses_content').html('');
	}

	$("#seeInformationModal").on("hidden.bs.modal", function(){
		$("#changeproces").html("");
		$("#changelog").html("");
		$('#nomLoteHistorial').html("");
	});
	$("#seeInformationModal").modal();

	var urlTableFred = '';
	$.getJSON(url+"Contratacion/obtener_liberacion/"+idLote).done( function( data ){
		urlTableFred = url+"Contratacion/obtener_liberacion/"+idLote;
		fillFreedom(urlTableFred);
	});


	var urlTableHist = '';
	$.getJSON(url+"Contratacion/historialProcesoLoteOp/"+idLote).done( function( data ){
		$('#nomLoteHistorial').html($itself.attr('data-nomLote'));
			urlTableHist = url+"Contratacion/historialProcesoLoteOp/"+idLote;
			fillHistory(urlTableHist);
	});

	var urlTableCSA = '';
    $.getJSON(url+"Contratacion/getCoSallingAdvisers/"+idLote).done( function( data ){
        urlTableCSA = url+"Contratacion/getCoSallingAdvisers/"+idLote;
        fillCoSellingAdvisers(urlTableCSA);
    });
    
});

function fillLiberacion (v) {
	$("#changelog").append('<li class="timeline-inverted">\n' +
        '<div class="timeline-badge success"></div>\n' +
        '<div class="timeline-panel">\n' +
        '<label><h5><b>LIBERACIÓN - </b>'+v.nombreLote+'</h5></label><br>\n' +
        '<b>ID:</b> '+v.idLiberacion+'\n' +
        '<br>\n' +
        '<b>Estatus:</b> '+v.estatus_actual+'\n' +
        '<br>\n' +
        '<b>Comentario:</b> '+v.observacionLiberacion+'\n' +
        '<br>\n' +
        '<span class="small text-gray"><i class="fa fa-clock-o mr-1"></i> '+v.nombre+' '+v.apellido_paterno+' '+v.apellido_materno+' - '+v.modificado+'</span>\n' +
        '</h6>\n' +
        '</div>\n' +
        '</li>');
}

function fillProceso (i, v) {
	$("#changeproces").append('<li class="timeline-inverted">\n' +
        '<div class="timeline-badge info">'+(i+1)+'</div>\n' +
        '<div class="timeline-panel">\n' +
		'<b>'+v.nombreStatus+'</b><br><br>\n' +
        '<b>Comentario:</b> \n<p><i>'+v.comentario+'</i></p>\n' +
        '<br>\n' +
        '<b>Detalle:</b> '+v.descripcion+'\n' +
        '<br>\n' +
        '<b>Perfil:</b> '+v.perfil+'\n' +
		'<br>\n' +
        '<b>Usuario:</b> '+v.usuario+'\n' +
        '<br>\n' +
        '<span class="small text-gray"><i class="fa fa-clock-o mr-1"></i> '+v.modificado+'</span>\n' +
        '</h6>\n' +
        '</div>\n' +
        '</li>');

	 // comentario, perfil, modificado,
}


function formatMoney( n ) {
	var c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;

        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };

    function fillHistory(urlTableHist)
	{
		tableHistorial = $('#verDet').DataTable( {
			responsive: true,
            dom: "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'B><'col-12 col-sm-12 col-md-6 col-lg-6'f>rt> <'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            buttons: [
				{
					extend:    'excelHtml5',
					text:      '<i class="fa fa-file-excel-o"></i>',
					titleAttr: 'Excel'
				},
				{
					extend:    'pdfHtml5',
					text:      '<i class="fa fa-file-pdf-o"></i>',
					titleAttr: 'PDF'
				}
			],
			columnDefs: [{
                defaultContent: "",
                targets: "_all",
                searchable: true,
                orderable: false
            }],
			"scrollX": true,
			"pageLength": 10,
            language: {
                url: "<?=base_url()?>/static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
			"destroy": true,
			"ordering": false,
			columns: [
				{ "data": "nombreLote" },
				{ "data": "nombreStatus" },
				{ "data": "descripcion" },
				{ "data": "comentario" },
				{ "data": "modificado" },
				{ "data": "usuario" }

			],
			/*"ajax": {
				"url": urlTableHist,//"<?=base_url()?>index.php/registroLote/historialProcesoLoteOp/"
				"type": "POST",
				cache: false,
				"data": function( d ){
					d.idLote = idlote_global;
				}
			},*/
			"ajax":
				{
					"url": urlTableHist,
					"dataSrc": ""
				},
		});
	}
	function fillFreedom(urlTableFred)
	{
		tableHistorialBloqueo = $('#verDetBloqueo').DataTable( {
			responsive: true,

            dom: "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'B><'col-12 col-sm-12 col-md-6 col-lg-6'f>rt> <'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            buttons: [
				{
					extend:    'excelHtml5',
					text:      '<i class="fa fa-file-excel-o"></i>',
					titleAttr: 'Excel'
				},
				{
					extend:    'pdfHtml5',
					text:      '<i class="fa fa-file-pdf-o"></i>',
					titleAttr: 'PDF'
				}
			],
			columnDefs: [{
                defaultContent: "",
                targets: "_all",
                searchable: true,
                orderable: false
            }],
			"scrollX": true,
			"pageLength": 10,
            language: {
                url: "<?=base_url()?>/static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
			"destroy": true,
			"ordering": false,
			columns: [
				{ "data": "nombreLote" },
				{ "data": "precio" },
				{ "data": "modificado" },
				{ "data" : "observacionLiberacion"},
				{ "data": "userLiberacion" }

			],
			/*"ajax": {
				"url": urlTableFred,//<?=base_url()?>index.php/registroLote/historialBloqueos/
				"type": "POST",
				cache: false,
				"data": function( d ){
				}
			},*/
			"ajax":
				{
					"url": urlTableFred,
					"dataSrc": ""
				},
		});
	}

	function fillCoSellingAdvisers(urlTableCSA)
{
    tableCoSellingAdvisers = $('#seeCoSellingAdvisers').DataTable( {
        responsive: true,
        dom: "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'B><'col-12 col-sm-12 col-md-6 col-lg-6'f>rt> <'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
        buttons: [
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel-o"></i>',
                titleAttr: 'Excel'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fa fa-file-pdf-o"></i>',
                titleAttr: 'PDF'
            }
        ],
        columnDefs: [{
                defaultContent: "",
                targets: "_all",
                searchable: true,
                orderable: false
            }],
        "scrollX": true,
        "pageLength": 10,
        language: {
            url: "<?=base_url()?>/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        "destroy": true,
        "ordering": false,
        columns: [
            { "data": "asesor" },
            { "data": "coordinador" },
            { "data": "gerente" },
            { "data" : "fecha_creacion"},
            { "data": "creado_por" }

        ],
        "ajax":
            {
                "url": urlTableCSA,
                "dataSrc": ""
            },
    });
}
</script>

