<div>
    <div class="wrapper">
        <?php
            $dato= array(
                'actualizaPrecio' => 0,
                'actualizaReferencia' => 0,
                'acuserecibidos' => 0,
                'altaCluster' => 0,
                'altaLote' => 0,
                'aparta' => 0,
                'asesores' => 0,
                'autorizacion' => 0,
                'bulkload' => 0,
                'cambiarAsesor' => 0,
                'comhistorial' => 0,
                'comnuevas' => 0,
                'consulta12Status' => 0,
                'consulta9Status' => 0,
                'contrato' => 0,
                'coOwners' => 0,
                'corrida' => 0,
                'corridaF' => 0,
                'corridasElaboradas' => 0,
                'disponibles' => 0,
                'documentacion' => 0,
                'DS' => 0,
                'DSConsult' => 0,
                'enviosRL' => 0,
                'estatus10' => 0,
                'estatus10Report' => 0,
                'estatus12' => 0,
                'estatus13' => 0,
                'estatus14' => 0,
                'estatus15' => 0,
                'estatus2' => 0,
                'estatus20' => 0,
                'estatus5' => 0,
                'estatus6' => 0,
                'estatus7' => 0,
                'estatus8' => 0,
                'estatus9' => 0,
                'expediente' => 0,
                'expedientesIngresados' => 0,
                'expRevisados' => 0,
                'gerentesAsistentes' => 0,
                'histComisiones' => 0,
                'historialPagos' => 0,
                'home' => 0,
                'integracionExpediente' => 0,
                'inventario' => 0,
                'inventarioDisponible' => 0,
                'liberacion' => 0,
                'listaCliente' => 0,
                'lotes45dias' => 0,
                'lotesContratados' => 0,
                'manual' => 0,
                'nuevasComisiones' => 0,
                'pagosCancelados' => 0,
                'prospectos' => 0,
                'prospectosAlta' => 0,
                'prospectosMktd' => 0,
                'rechazoJuridico' => 0,
                'references' => 0,
                'sharedSales' => 0,
                'status11' => 0,
                'status14' => 0,
                'status3' => 0,
                'status7' => 0,
                'status8' => 0,
                'ultimoStatus' => 0,
                'usuarios' => 0,
                'listaAsesores' => 1,
                'clientsList' => 0
            );
        $this->load->view('template/sidebar', $dato);

        ?>


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
                                                <h4 class="card-title">Asesores y coordinadores</h4>
                                                <div class="table-responsive">
                                                    <table id="users_datatable" class="table table-striped table-no-bordered table-hover" style="text-align:center;"><!--table table-bordered table-hover -->
                                                        <thead>
                                                        <tr>
                                                            <th class="disabled-sorting text-right"><center>Estatus</center></th>
                                                            <th class="disabled-sorting text-right"><center>ID</center></th>
                                                            <th class="disabled-sorting text-right"><center>Nombre</center></th>
                                                            <th class="disabled-sorting text-right"><center>Teléfono</center></th>
                                                            <th class="disabled-sorting text-right"><center>Puesto</center></th>
                                                            <th class="disabled-sorting text-right"><center>Jefe directo</center></th>
                                                            <th class="disabled-sorting text-right"><center>Sede</center></th>
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
                </div>
            </div>
        </div>

        <?php $this->load->view('template/footer_legend');?>

    </div>
</div>
</body>

<?php $this->load->view('template/footer');?>
<script src="<?=base_url()?>dist/js/controllers/usuarios-1.1.0.js"></script>

</html>
