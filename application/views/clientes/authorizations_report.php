<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
    <div class="wrapper ">
        <?php $this->load->view('template/sidebar'); ?>
        
        <!-- modal  INSERT COMENTARIOS-->
    <div class="modal fade" id="addFile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content" >
                <form method="POST" name="sendAutsFromD" enctype="multipart/form-data" action="<?=base_url()?>index.php/registroCliente/updateAutsFromsDC">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <center><h3 class="modal-title" id="myModalLabel"><b>Autorizaciones</b></h3></center>
                    </div>
                    <div class="modal-body">


                        <div id="loadAuts">

                        </div>
                        <input type="hidden" name="numeroDeRow"  id="numeroDeRow" value="">
                        <input type="hidden" name="idCliente"  id="idCliente" value="">
                        <input type="hidden" name="idCondominio"  id="idCondominio" value="">
                        <input type="hidden" name="idLote"  id="idLote" value="">
                        <input type="hidden" name="id_autorizacion"  id="id_autorizacion" value="">

                        <input type="hidden" name="nombreResidencial"  id="nombreResidencial" value="">
                        <input type="hidden" name="nombreCondominio"  id="nombreCondominio" value="">
                        <input type="hidden" name="nombreLote"  id="nombreLote" value="">



                    </div>
                    <div class="modal-footer">
                        <button type="submit"  class="btn btn-primary">
                            Enviar autorización
                        </button>
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-shield-alt fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align" data-i18n="tus-autorizaciones">Tus autorizaciones</h3>
                                </div>
                                <div class="material-datatables">
                                    <table id="authorizationsTable" class="table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>estatus</th>
                                                <th>proyecto</th>
                                                <th>condominio</th>
                                                <th>lote</th>
                                                <th>asesor</th>
                                                <th>cliente</th>
                                                <th>solicitud</th>
                                                <th>comentario</th>
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
        <?php $this->load->view('template/footer_legend');?>
    </div>
</body>
<?php $this->load->view('template/footer');?>
<script src="<?= base_url() ?>dist/js/controllers/clientes/authorizationsReport.js"></script>