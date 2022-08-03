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
