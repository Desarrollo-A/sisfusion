<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade" id="seeInformationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons" onclick="cleanComments()">clear</i></button>
                        <h4 class="modal-title" data-i18n="consultar-informacion">Consulta información</h4>
                    </div>
                    <div class="modal-body">
                        <div role="tabpanel">
                            <ul class="nav nav-tabs" role="tablist" style="background: #003d82;">
                                <li role="presentation" class="active"><a href="#generalTab" aria-controls="generalTab" role="tab" data-toggle="tab">General</a></li>
                                <li role="presentation"><a href="#commentsTab" aria-controls="commentsTab" role="tab" data-toggle="tab"><span data-i18n="comentarios">Comentarios</span></a></li>
                                <li role="presentation"><a href="#changelogTab" aria-controls="changelogTab" role="tab" data-toggle="tab"><span data-i18n="bitacora-cambios">Bitácora de cambios</span></a></li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="generalTab">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="control-label" data-i18n="personalidad-juridica">Personalidad jurídica</label>
                                                <input id="legal-personality-lbl" type="text" class="form-control input-gral" disabled>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="control-label"data-i18n="nacionalidad">Nacionalidad</label>
                                                <input id="nationality-lbl" type="text" class="form-control input-gral" disabled>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="control-label" data-i18n="curp">CURP</label>
                                                <input id="curp-lbl" type="text" class="form-control input-gral" disabled>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="control-label" data-i18n="rfc">RFC</label>
                                                <input id="rfc-lbl" type="text" class="form-control input-gral" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label" data-i18n="nombre-razon-social">Nombre / Razón social</label>
                                                <input id="name-lbl" type="text" class="form-control input-gral" disabled>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label" data-i18n="correo">Correo electrónico</label>
                                                <input id="email-lbl" type="text" class="form-control input-gral" disabled>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label class="control-label" data-i18n="telefono">Teléfono</label>
                                                <input id="phone-number-lbl" type="text" class="form-control input-gral" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label" data-i18n="como-nos-contactaste">¿Cómo nos contactaste?</label>
                                                <input id="prospecting-place-lbl" type="text" class="form-control input-gral" disabled>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label" data-i18n="plaza-venta">Plaza de venta</label>
                                                <input id="sales-plaza-lbl" type="text" class="form-control input-gral" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label" data-i18n="asesor">Asesor</label>
                                                <input id="asesor-lbl" type="text" class="form-control input-gral" disabled>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label" data-i18n="coordinador">Coordinador</label>
                                                <input id="coordinador-lbl" type="text" class="form-control input-gral" disabled>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label" data-i18n="gerente">Gerente</label>
                                                <input id="gerente-lbl" type="text" class="form-control input-gral" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <input type="hidden" id="id-prospecto-lbl" name="id_prospecto_lbl">
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="commentsTab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-plain">
                                                <div class="card-content">
                                                    <ul class="timeline timeline-simple" id="comments-list"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="changelogTab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-plain">
                                                <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                                    <ul class="timeline-3" id="changelog"></ul>
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
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanComments()"><span data-i18n="cerrar">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="{{$('#prospecting-place-lbl').val() == 'MKT digital (especificar)' ? printProspectInfoMktd() : printProspectInfo()}}"><i class="material-icons">cloud_download</i><span data-i18n="descargar-pdf"> Descargar pdf</span></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <a href="https://youtu.be/pj80dBMw6y4" class="align-center justify-center u2be" target="_blank">
                                    <i class="fab fa-youtube p-0" rel="tooltip" data-placement="top" title="Tutorial" style="font-size:25px!important"></i>
                                </a>
                            </div>
                            <div class="card-content">
                                <!--<h3 class="card-title center-align">Lista de nuevos clientes</h3>-->
                                <h3 class="card-title center-align" data-i18n="lista-nuevos-clientes">Lista de nuevos clientes</h3>
                                <div class="toolbar">
                                    <div class="row"></div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table id="clients-datatable" class="table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>cliente</th>
                                                    <th>correo</th>
                                                    <th>telefono</th>
                                                    <th>lugar-prospeccion</th>
                                                    <th>asesor</th>
                                                    <th>coordinador</th>
                                                    <th>gerente</th>
                                                    <th>subdirector</th>
                                                    <th>director-regional</th>
                                                    <th>fecha-creacion</th>
                                                    <th>fecha-cliente</th>
                                                    <th>acciones</th>
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
<?php $this->load->view('template/footer');?>
<script src="<?=base_url()?>dist/js/modal-steps.min.js"></script>
<script src="<?=base_url()?>dist/js/controllers/consultaClientes.js"></script>
</body>