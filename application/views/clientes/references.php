<body>
<div class="wrapper">
    <?php $this->load->view('template/sidebar', $dato); ?>
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
                                                Referencias
                                                <i class="material-icons" data-toggle="modal" data-target="#addReferencesModal" onclick="cleanFields(4)">add_circle</i>
                                            </h4>
                                            <div class="table-responsive">

                                                <div class="material-datatables">
                                                    <table id="references-datatable" class="table table-striped table-no-bordered table-hover" style="text-align:center;"><!--table table-bordered table-hover -->
                                                        <thead>
                                                            <tr>
                                                                <th class="disabled-sorting text-right"><center>Estado</center></th>
                                                                <th class="disabled-sorting text-right"><center>Prospecto</center></th>
                                                                <th class="disabled-sorting text-right"><center>Nombre</center></th>
                                                                <th class="disabled-sorting text-right"><center>Teléfono</center></th>
                                                                <th class="disabled-sorting text-right"><center>Parentesco</center></th>
                                                                <th class="disabled-sorting text-right"><center>Fecha alta</center></th>
                                                                <th class="disabled-sorting text-right"><center>Acciones</center></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>

                                                    <div class="modal fade" id="addReferencesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                                        <i class="material-icons">clear</i>
                                                                    </button>
                                                                    <h4 class="modal-title">Agrega sus referencias</h4>
                                                                </div>
                                                                <form id="referencesForm" name="referencesForm" method="post">
                                                                    <div class="modal-body">
                                                                        <div class="col-lg-12">
                                                                            <label class="control-label"> Selecciona tu prospecto<small> (requerido)</small></label>
                                                                            <select class="selectpicker" name="prospecto" id="prospecto" data-style="select-with-transition" data-live-search="true" data-size="7" required></select>
                                                                        </div>
                                                                        <div class="col-sm-8">
                                                                            <div class="form-group label-floating">
                                                                                <label class="control-label">Nombre<small> (requerido)</small></label>
                                                                                <input id="name" name="name" type="text" class="form-control" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-4">
                                                                            <div class="form-group label-floating">
                                                                                <label class="control-label">Teléfono<small> (requerido)</small></label>
                                                                                <input id="phone_number" name="phone_number" type="text" class="form-control" required maxlength="10" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                            <label class="control-label"> ¿Cuál es su parentezco?<small> (requerido)</small></label>
                                                                            <select class="selectpicker" name="kinship" id="kinship" data-style="select-with-transition" data-live-search="true" data-size="7" required></select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit" class="btn btn-primary">Aceptar</button>
                                                                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal fade" id="editReferencesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                                        <i class="material-icons">clear</i>
                                                                    </button>
                                                                    <h4 class="modal-title">Edita los datos de sus referencias</h4>
                                                                </div>
                                                                <form id="editReferencesForm" name="referencesForm" method="post">
                                                                    <div class="modal-body">
                                                                        <div class="col-lg-12">
                                                                            <label class="control-label"> Selecciona tu prospecto<small> (requerido)</small></label>
                                                                            <select class="selectpicker" name="prospecto_ed" id="prospecto_ed" data-style="select-with-transition" data-live-search="true" data-size="7" required></select>
                                                                        </div>
                                                                        <div class="col-sm-8">
                                                                            <div class="form-group label-floating div-name">
                                                                                <label class="control-label">Nombre<small> (requerido)</small></label>
                                                                                <input id="name_ed" name="name_ed" type="text" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-4">
                                                                            <div class="form-group label-floating div-phone-number">
                                                                                <label class="control-label">Teléfono<small> (requerido)</small></label>
                                                                                <input id="phone_number_ed" name="phone_number_ed" type="text" class="form-control" maxlength="10" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                            <label class="control-label"> ¿Cuál es su parentezco?<small> (requerido)</small></label>
                                                                            <select class="selectpicker" name="kinship_ed" id="kinship_ed" data-style="select-with-transition" data-live-search="true" data-size="7" required></select>
                                                                        </div>
                                                                        <div class="col-sm-4">
                                                                            <div class="form-group">
                                                                                <input id="id_referencia" name="id_referencia" type="hidden" class="form-control">
                                                                            </div>
                                                                        </div>
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
<script src="<?php base_url()?>dist/js/jquery.validate.js"></script>
<script src="<?=base_url()?>dist/js/controllers/general-1.1.0.js"></script>

</html>
