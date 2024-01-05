<body>
<div class="wrapper">
<?php $this->load->view('template/sidebar'); ?>

    <style>
        .label-inf {
            color: #333;
        }
        /*.modal-body-scroll{
            height: 100px;
            width: 100%;
            overflow-y: auto;
        }*/
        select:invalid {
            border: 2px dashed red;
        }

    </style>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="block full">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                        <i class="material-icons">list</i>
                                    </div>
                                    <div class="card-content">
                                        <div class="row">
                                            <h4 class="card-title">
                                                Ventas compartidas
                                                <i class="material-icons" data-toggle="modal" data-target="#addSalesPartnerModal">add_circle</i>
                                            </h4>
                                            <div class="table-responsive">

                                                <div class="material-datatables">
                                                    <table id="shared-sales-datatable" class="table table-striped table-no-bordered table-hover" style="text-align:center;"><!--table table-bordered table-hover -->
                                                        <thead>
                                                            <tr>
                                                                <th class="disabled-sorting text-right"><center>Estado</center></th>
                                                                <th class="disabled-sorting text-right"><center>Prospecto</center></th>
                                                                <th class="disabled-sorting text-right"><center>Asesor</center></th>
                                                                <th class="disabled-sorting text-right"><center>Coordinador</center></th>
                                                                <th class="disabled-sorting text-right"><center>Gerente</center></th>
                                                                <th class="disabled-sorting text-right"><center>Fecha alta</center></th>
                                                                <th class="disabled-sorting text-right"><center>Acciones</center></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>

                                                    <div class="modal fade" id="addSalesPartnerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                                        <i class="material-icons">clear</i>
                                                                    </button>
                                                                    <h4 class="modal-title">¿Con quién compartirás este prospecto?</h4>
                                                                </div>
                                                                <form id="addSalesPartnerForm" name="addSalesPartnerForm" method="post">
                                                                    <div class="modal-body">
                                                                        <div class="col-lg-12">
                                                                            <label class="control-label"> Selecciona tu prospecto</label>
                                                                            <select class="selectpicker" name="prospecto" id="prospecto" data-style="select-with-transition" data-live-search="true" data-size="7" required></select>
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                            <label class="control-label">Ahora, elije un asesor</label>
                                                                            <select class="selectpicker" name="asesor" id="asesor" data-style="select-with-transition" data-live-search="true" data-size="7" required onchange="getSalesPartnerInformation(this)"></select>
                                                                        </div>
                                                                        <input type="hidden" name="id_coordinador" id="id_coordinador">
                                                                        <input type="hidden" name="id_gerente" id="id_gerente">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit" class="btn btn-primary">Aceptar</button>
                                                                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php $this->load->view('template/footer_legend');?>
</div>
</div>
</body>
<?php $this->load->view('template/footer');?>
<script src="<?php base_url()?>dist/js/jquery.validate.js"></script>

<script src="<?=base_url()?>dist/js/controllers/general-1.1.0.js"></script>

</html>
