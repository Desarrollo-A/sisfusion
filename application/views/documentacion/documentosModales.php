<div class="modal fade" id="addDeleteFileModal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"></div>
            <div class="modal-body text-center">
                <h5 id="mainLabelText"></h5>
                <p id="secondaryLabelDetail"></p>
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                    <div class="hide" id="selectFileSection">
                        <div class="file-gph">
                            <input class="d-none" type="file" id="fileElm">
                            <input class="file-name" id="file-name" type="text" placeholder="No has seleccionada nada aún" readonly="">
                            <label class="upload-btn m-0" for="fileElm">
                                <span>Seleccionar</span>
                                <i class="fas fa-folder-open"></i>
                            </label>
                        </div>
                    </div>
                </div>
                <input type="text" class="hide" id="idLoteValue">
                <input type="text" class="hide" id="idDocumento">
                <input type="text" class="hide" id="tipoDocumento">
                <input type="text" class="hide" id="nombreDocumento">
                <input type="text" class="hide" id="tituloDocumento">
                <input type="text" class="hide" id="accion">
            </div>
            <div class="modal-footer mt-2">
                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                <button type="button" id="sendRequestButton" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

