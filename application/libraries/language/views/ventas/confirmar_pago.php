<div>
    <div class="wrapper">
        <?php
        if($this->session->userdata('id_rol')=="32") // CONTRALORRÍA CORPORATIVA
        {
            $dato = array(
                'home'           => 0,
                'listaCliente'   => 0,
                'expediente'     => 0,
                'corrida'        => 0,
                'documentacion'  => 0,
                'historialpagos' => 0,
                'inventario'     => 0,
                'estatus20'      => 0,
                'estatus2'       => 0,
                'estatus5'       => 0,
                'estatus6'       => 0,
                'estatus9'       => 0,
                'estatus10'      => 0,
                'estatus13'      => 0,
                'estatus15'      => 0,
                'enviosRL'       => 0,
                'estatus12'      => 0,
                'acuserecibidos' => 0,
                'tablaPorcentajes' => 0,
                'comnuevas'      => 0,
                'comhistorial'   => 0,
                'integracionExpediente' => 0,
                'expRevisados' => 0,
                'estatus10Report' => 0,
                'rechazoJuridico' => 0,
                'confirmarPago' => 1
            );
            //$this->load->view('template/contraloria/sidebar', $dato);
            $this->load->view('template/sidebar', $dato);
        }
        else
        {
            echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
        }
        ?>

        <style>

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
                                                <h4 class="card-title">Confirmar pago</h4>
                                                <div class="table-responsive">
                                                    <div class="material-datatables">

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
</html>