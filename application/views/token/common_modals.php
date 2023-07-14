<link href="<?= base_url() ?>dist/css/evidenciasRecisiones.css" rel="stylesheet"/>

<div class="modal fade" id="videoPreview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">    
    <div class="modal-dialog">
        <div class="modal-content content_video">
            <div class="modal-header d-flex align-center justify-center mb-1">
                <h3 class="modal-title text-center preview_title">Evidencia <span id="nombre_lote"></span></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="modal-body-video" class="modal-body pt-0">
                <video id="video_preview" controls width="100%">
                </video>
            </div>
        </div>
    </div>
</div>

<div class="modal fade in" id="reviewTokenEvidence" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >   
    <div class="modal-dialog" style="max-width: inherit;">
        <div class="modal-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 p-0">
                        <div id="img_actual">
                        </div>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="generateTokenModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content boxContent">
            <div class="modal-body card no-shadow">
                <div class="card-content">
                    <div class="toolbar">
                        <h3 class="card-title center-align">Selecciona un asesor</h3>
                        <div class="row aligned-row">
                            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                                <div class="form-group label-floating select-is-empty m-0 p-0">
                                    <select id="asesoresList" name="asesoresList" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true"
                                        title="SELECCIONA UNA OPCIÓN" data-size="7" required>
                                    </select>
                                 </div>
                            </div>
                            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group label-floating select-is-empty m-0 p-0">
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
                        </div>
                    </div>
                </div>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"    onclick="cleanSelects()">Cerrar</button>
                <button class="btn btn-primary" onclick="generateToken()">Generar</button>
            </div>
        </div>
    </div>
</div>
    