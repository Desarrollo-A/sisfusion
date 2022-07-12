<link href="<?= base_url() ?>dist/css/commonModals.css" rel="stylesheet"/>

<div class="modal fade" id="urlModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">    
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-center mb-1">
                <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11 form-group m-0 pr-0 d-flex justify-between align-center">
                    <h3 class="modal-title">URL generada con exito</h3>
                </div>
            </div>
            <div class="modal-body pt-0">
                <div class="mb-1 tokenArea">
                    <div class="row d-flex align-center direction-row">
                        <div class="col-12 col-sm-12 col-md-10 col-lg-10">
                            <p class="titleMini m-0">*Copia este enlace y entrégaselo a tu cliente: </p>
                            <!-- <textarea name="url" id="url" cols="90" rows="5" disabled>
                            </textarea> -->
                        </div>
                        <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                            <i class="fas fa-copy iconCopy" title="Copiar"></i>
                        </div>
                    </div>
                </div>   
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                </div> 
            </div>
        </div>
    </div>
</div>
