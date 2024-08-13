<style>
#form-modal2 .modal-dialog {
    max-width: 600px; 
    margin: 1.75rem auto; 
}
#form-modal2 .modal-body {
    max-height: 70vh; 
    overflow-y: auto; 
}
</style>

<div id="alert-modal" class="modal fade" role="dialog" tabindex='-1'>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex d-wrap">
                <h4 class="modal-title text-center"><b id="title-alert-modal"></b></h4>
            </div>
            <div class="modal-body">
                <span id="text-alert-modal"></span>
            </div>
            <div class="modal-footer">
                <button id="cancel-button-alert-modal" type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div id="ask-modal" class="modal fade" role="dialog" tabindex='-1'>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex d-wrap">
                <h4 class="modal-title text-center"><b id="title-ask-modal"></b></h4>
            </div>
            <div class="modal-body">
                <span id="text-ask-modal"></span>
            </div>
            <div class="modal-footer">
                <button id="cancel-button-ask-modal" type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                <button id="ok-button-ask-modal" type="button" class="btn btn-primary">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<div id="form-modal" class="modal fade" role="dialog" tabindex='-1'>
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form-form-modal" method="post" novalidate>
                <div class="modal-header">
                    <h4 class="modal-title text-center"><b id="title-form-modal"></b></h4>
                </div>
                <div class="modal-body">
                    <span id="text-form-modal"></span>
                    <div id="fields-form-modal" class="row">

                    </div>
                    <div class="mt-4">ㅤ</div>
                </div>
                <div class="modal-footer">
                    <button id="cancel-button-form-modal" type="button" class="btn btn-danger btn-simple" data-dismiss="modal">cerrar</button>
                    <button id="ok-button-form-modal" type="submit" class="btn btn-primary">
                        aceptar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="form-modal2" class="modal fade" role="dialog" tabindex='-1'>
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form-form-modal2" method="post" novalidate>
                <div class="modal-header">
                    <h4 class="modal-title text-center"><b id="title-form-modal2"></b></h4>
                </div>
                <div class="modal-body scroll-styles">
                    <span id="text-form-modal2"></span>
                    <div id="fields-form-modal2" class="row">

                    </div>
                    <div class="mt-4"></div>
                </div>
                <div class="modal-footer">
                    <button id="cancel-button-form-modal2" type="button" class="btn btn-danger btn-simple" data-dismiss="modal">cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="form-modal3" class="modal fade" role="dialog" tabindex='-1'>
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form-form-modal3" method="post" novalidate>
                <div class="modal-header d-flex justify-content-center">
                    <h4 class="modal-title text-center w-100">
                        <b id="title-form-modal3">Your Title Here</b>
                    </h4>
                </div>
                <div class="modal-footer">
                    <button id="cancel-button-form-modal3" type="button" class="btn btn-danger btn-simple" data-dismiss="modal">cerrar</button>
                    <button id="ok-button-form-modal3" type="submit" class="btn btn-primary">
                        aceptar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>