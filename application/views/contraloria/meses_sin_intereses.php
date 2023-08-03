<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
<div class="wrapper ">
    <?php $this->load->view('template/sidebar'); ?>

    <div class="modal fade" id="addFile" style="z-index: 9999;" >
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                    <center><h3 class="modal-title" id="myModalLabel"><span class="lote"></span></h3></center>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <label class="input-group-btn">
								<span class="btn btn-primary btn-file">
								Seleccionar archivo&hellip;<input type="file" name="file_msni" id="file_msni" style="display: none;">
								</span>
                        </label>
                        <input type="text" class="form-control" id= "txtexp" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="sendFile" class="btn btn-primary">Actualizar </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="verAut" style="z-index: 9999;" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content" >
                <div class="modal-header">
                    <center><h3 class="modal-title" id="myModalLabel"><span class="lote"></span></h3></center>
                </div>
                <form name="cambiosMSIF" id="cambiosMSIF" method="post">
                    <div class="modal-body">
                        <div class="material-datatables">
                            <div class="form-group">
                                <table class="table-striped table-hover" id="tabla_msni_visualizacion" name="tabla_msni_visualizacion">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>NOMBRE</th>
                                        <th>MSI</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary no-shadow rounded-circle" id="cambiosGuardaMSI">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalHistorialAM" style="z-index: 9999;" >
        <div class="modal-dialog ">
            <div class="modal-content" >
                <div class="modal-header">
                    <center><h3 class="modal-title" id="myModalLabelAM">HISTORIAL</h3></center>
                </div>
                <div class="modal-body" style="height: 550px;overflow-x: auto;">
                    <div id="historialAutAM" >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="avanzarAutAM" style="z-index: 9999;" >
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                    <center><h3 class="modal-title" id="tittleModalAM"></h3><h5 id="leyendaAdvAM"></h5></center>
                </div>
                <div class="modal-body">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <label>Comentario:</label>
                        <textarea class="text-modal" name="comentarioAvance" id="comentarioAvanceAM" rows="3"></textarea>
                        <br>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary no-shadow" id="enviarAutBtnAM">Enviar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-box fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title center-align" >Meses sin intereses</h3>
                            <div class="toolbar">
                                <div class="container-fluid p-0"></div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <table class="table-striped table-hover" id="tabla_aut" name="tabla_aut_name">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>COMENTARIO</th>
                                            <th>ESTATUS AUTORIZACIÓN</th>
                                            <th>ÚLT. MODIFICACIÓN</th>
                                            <th>ACCIONES</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade " id="subirMeses" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content" >
                            <div class="modal-body">
                                <!-- Esto se debe pasar al modal-->
                                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="card">
                                        <div class="card-content">
                                            <h3 class="card-title center-align" >Meses sin intereses</h3>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row aligned-row d-flex align-end">
                                                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <label style="font-size: small">Elige el modo para subir los meses sin interés:</label>
                                                        </div>
                                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4 pb-3">
                                                            <div class="radio_container w-100">
                                                                <input class="d-none generate" type="radio" name="modoSubida" id="condominioM" checked value="1">
                                                                <label for="condominioM" class="w-50">Por Condominio</label>
                                                                <input class="d-none find-results" type="radio" name="modoSubida" id="loteM" value="0">
                                                                <label for="loteM" class="w-50">Por lote</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row aligned-row d-flex align-end">
                                                        <div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                            <label class="m-0" for="filtro3">Proyecto</label>
                                                            <select name="filtro3" id="filtro3" class="selectpicker select-gral mb-0"
                                                                    data-show-subtext="true" data-live-search="true"  data-style="btn"
                                                                    onchange="changeCondominio()" title="Selecciona Proyecto" data-size="4" required>
                                                                <?php
                                                                if($residencial != NULL) :
                                                                    foreach($residencial as $fila) : ?>
                                                                        <option value= <?=$fila['idResidencial']?> data-nombre='<?=$fila['nombreResidencial']?>' style="text-transform: uppercase"> <?=$fila['descripcion']?> </option>
                                                                    <?php endforeach;
                                                                endif;
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4 hide" id="contenedor-condominio">
                                                            <label class="m-0" for="filtro4">Condominio</label>
                                                            <select name="filtro4" id="filtro4" class="selectpicker select-gral mb-0"
                                                                    data-show-subtext="true" data-live-search="true"  data-style="btn"
                                                                    title="Selecciona Condominio" data-size="4" required onChange="loadLotes()">
                                                            </select>
                                                        </div>
                                                        <input id="typeTransaction" type="hidden" value="1">
                                                        <div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4 mt-2">
                                                            <button type="button" id="loadFile" class="btn-data-gral btn-success d-flex justify-center align-center">Cargar información<i class="fas fa-paper-plane pl-1"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <div class="table-responsive">
                                                        <table class="table-striped table-hover" id="tabla_msni" name="tabla_msni_name">
                                                            <thead>
                                                            <tr>
                                                                <th>ID CONDOMINIO</th>
                                                                <th>NOMBRE</th>
                                                                <th>MSI</th>
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
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
                                <!--                                <button type="button" id="guardar" class="btn btn-primary">Registrar</button>-->
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
<script type="text/javascript" src="//unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/contraloria/meses_sin_intereses.js"></script>
</body>