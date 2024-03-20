<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
<div class="wrapper ">
    <?php $this->load->view('template/sidebar'); ?>

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas"><i class="fas fa-expand fa-2x"></i></div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Registro estatus 14</h3>
                                <p class="card-title pl-1"></p>
                            </div>
                            <div  class="toolbar">
                                <div class="row">
                                    <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6 form-group">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Proyecto:</label>
                                            <select name="filtro3" id="filtro3" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true"  title="Selecciona proyecto" data-size="7" required></select>
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6 form-group">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Condominio:</label>
                                            <select id="filtro4" name="filtro4" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true"  title="Selecciona condominio" data-size="7" required></select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <table  id="tableStatus15Clients" class="table-striped table-hover" style="text-align:center;">
                                    <thead>
                                        <tr>
                                            <th>PROYECTO</th>
                                            <th>CONDOMINIO</th>
                                            <th>LOTE</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="modal fade " id="returnStatus15" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title"><label>Agrega tus comentarios</b></label></h4>
                                        </div>
                                        <form id="returnEditaStatus15" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <label id="tvLbl">Lote</label>
                                                    <input type="text" class="form-control" id="nombreLote" name="nombreLote" readonly>
                                                    <input type="hidden" class="form-control" id="idLote" name="idLote">
                                                    <input type="hidden" class="form-control" id="idCondominio" name="idCondominio">
                                                    <input type="hidden" class="form-control" id="idCliente" name="idCliente">
                                                </div>
                                                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <label>Comentario</label>
                                                    <textarea class="form-control" rows="2" id="comentario" name="comentario" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" id="save" class="btn btn-success"><span class="material-icons">send</span> </i> Guardar </button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar </button>
                                            </div>
                                        </form>
                                    </div>
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
</div>
</div>
</body>
<?php $this->load->view('template/footer'); ?>
<script src="<?=base_url()?>dist/js/controllers/contraloria/returnToStatusFourteen.js"></script>

