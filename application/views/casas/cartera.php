
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<style>

    .cont {
        display: flex;
        align-items: center;
        transform: scale(1);
    }

    input[type="checkbox"] {
        height: 2.5rem;
        width: 2.5rem;
        margin: 1px;
        display: inline-block;
        appearance: none;
        position: relative;
        background-color: #c9c9c9;
        border-radius: 15%;
        cursor: pointer;
        overflow: hidden;
    }

    input[type="checkbox"]::after {
        content: '';
        display: block;
        height: 1.5rem;
        width: .6rem;
        border-bottom: .31rem solid #a0ffe7;
        border-right: .31rem solid #a0ffe7;
        opacity: 0;
        transform: rotate(45deg) translate(-50%, -50%);
        position: absolute;
        top: 45%;
        left: 30%;
        transition: .25s ease;
    }

    input[type="checkbox"]::before {
        content: '';
        display: block;
        height: 0;
        width: 0;
        background-color: #00C896;
        border-radius: 50%;
        opacity: .5;
        transform: translate(-50%, -50%);
        position: absolute;
        top: 50%;
        left: 50%;
        transition: .3s ease;
    }

input[type="checkbox"]:checked::after {
 opacity: 100%;
}
.bootstrap-select .dropdown-menu {
    max-height: 200px; 
    overflow-y: auto;  
    padding: 0;        
}

.bootstrap-select .dropdown-menu .inner {
    max-height: none;  
    overflow: hidden;  
}

input[type="checkbox"]:checked::before {
    height: 130%;
    width: 130%;
    opacity: 100%;
}

input[type=checkbox]:focus{
    outline: 0px;
    outline-offset: 0px;
}
</style>
<body class="">
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>
        <div class="modal fade" id="preguntaConfirmacion" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header"></div>
                    <div class="modal-body text-center">
                        <h5 id="mainLabelText"></h5>
                        <p id="txtLotes"></p>
                    </div>
                    <div class="modal-footer mt-2">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="fusionarLotes" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-caret-square-o-down fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="toolbar">
                                    <h3 class="card-title center-align">Originación de cartera</h3>
                                    <div id="table-filters" class="row mb-1"></div>
                                </div>
                                
                                <table id="tableDoct" class="table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>PROYECTO</th>
                                            <th>CONDOMINIO</th>
                                            <th>NOMBRE LOTE</th>
                                            <th>ID LOTE</th>
                                            <th>PRECIO FINAL</th>
                                            <th>SUPERFICIE</th>
                                            <th>NOMBRE CLIENTE</th>
                                            <th>TELÉFONO 1</th>
                                            <th>TELÉFONO 2</th>
                                            <th>TELÉFONO 3</th>
                                            <th>EMAIL</th>
                                            <th>LUGAR DE PROSPECCIÓN</th>
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
        <?php $this->load->view('template/footer_legend');?>
    </div>
    </div>
    <?php $this->load->view('template/footer');?>
    <?php $this->load->view('template/modals');?>

    <script src="<?= base_url() ?>dist/js/controllers/casas/cartera.js"></script>
</body>