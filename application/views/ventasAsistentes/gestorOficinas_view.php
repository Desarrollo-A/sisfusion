<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" type="text/css"/>

<body>
<div class="wrapper">
	<?php $this->load->view('template/sidebar'); ?>
    <style>
        .form-group{
            margin:0;
        }
    </style>
    <div class="modal fade" id="editOffice" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <form id="formEditOffice">
                <div class="modal-content">
                    <div class="modal-body">
                        <label>Ingresa la nueva dirección a editar</label>
                        <input class="form-control input-gral" name="direccionOffice" id="direccionOffice" type="text" placeholder="Tu dirección" required/>
                        <input class="form-control input-gral d-none" name="idDireccion" id="idDireccion" type="text"/>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Aceptar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="statusOffice" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <form id="formStatus">
                <div class="modal-content">
                    <div class="modal-body"></div>
                    <input class="input-gral d-none" name="idDireccionS" id="idDireccionS" type="text"/>
                    <input class="input-gral d-none" name="status" id="status" type="text"/>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Aceptar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="addOffice" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <form id="formAddOffice">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title text-center">Añadir nueva oficina de comercialización</h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 overflow-hidden p-0 mb-1">
                            <label class="control-label">Sede a la que pertenece</label>
                            <select name="idSede" id="idSede" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" >
                            </select>
                        </div>
                        <label class="control-label">Dirección</label>
                        <input class="form-control input-gral m-0" name="newOffice" id="newOffice" type="text" placeholder="Carranza #36, Col. Centro CP. 76000 Querétaro, Qro. Col." required/> 
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 pl-0">
                            <label class="control-label">Hora inicio (am)</label>
                            <input class="form-control input-gral m-0" name="inicio" id="inicio" type="number" max='12' required/>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 pr-0">
                            <label class="control-label">Hora fin (pm)</label>
                            <input class="form-control input-gral m-0" name="fin" id="fin" type="number" max='12' required/> 
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Aceptar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

	<div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="far fa-building p-0" rel="tooltip" data-placement="top" title="Tutorial" style="font-size:25px!important"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Listado de oficinas de comercialización Ciudad Maderas</h3>
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-md-10">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" data-toggle="modal" id="btnAgregarOffice" class="btn-azure w-100" rel="tooltip" data-placement="top" title="AGREGAR OFICINA">Agregar</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <table class="table-striped table-hover" id="tablaOficinas">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>SEDE</th>
                                                <th>DIRECCIÓN</th>
                                                <th>HORARIO</th>
                                                <th>ESTATUS</th>
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
</body>
<?php $this->load->view('template/footer');?>
<script src="<?= base_url() ?>dist/js/controllers/ventasAsistentes/gestorOficinas.js"></script>
