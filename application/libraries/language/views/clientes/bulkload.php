<link href="<?=base_url()?>dist/js/controllers/files/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
<link href="<?=base_url()?>dist/js/controllers/files/themes/explorer-fas/theme.css" media="all" rel="stylesheet" type="text/css"/>

<div>
    <div class="wrapper">
        <?php
        switch ($this->session->userdata('id_rol')) {
            case "1": // DIRECTOR
            case "2": // SUBDIRECTOR
            case "3": // GERENTE
            case "4": // ASISTENTE DIRECTOR
            case "5": // ASISTENTE SUBDIRECTOR
            case "9": // COORDINADOR
            case "19": // SUBDIRECTOR MKTD
            case "20": // GERENTE MKTD
                $dato= array(
                    'home' => 0,
                    'usuarios' => 0,
                    'statistics' => 0,
                    'manual' => 0,
                    'aparta' => 0,
                    'prospectos' => 0,
                    'prospectosAlta' => 0,
                    'sharedSales' => 0,
                    'coOwners' => 0,
                    'bulkload' => 1,
                    'listaAsesores' => 0,
                    'prospectosMktd' => 0,
                    'altaUsuarios' => 0,
                    'listaUsuarios' => 0
                );
                $this->load->view('template/sidebar', $dato);
                break;


            case "18": // DIRECTOR MKTD
                      $dato= array(
                'home' => 0,
                'usuarios' => 0,
                'statistics' => 0,
                'manual' => 0,
                'aparta' => 0,
                'prospectos' => 0,
                'prospectosMktd' => 0,
                'prospectosAlta' => 0,
                'sharedSales' => 0,
                'coOwners' => 0,
                'references' => 0,
                'plazasComisiones'     => 0,
                'nuevasComisiones' => 0,
                'histComisiones' => 0,
                'bulkload' => 1,
                'listaAsesores' => 0,
                'altaUsuarios' => 0,
                'listaUsuarios' => 0
            );
                $this->load->view('template/sidebar', $dato);
                break;


            case "7": // ASESOR
                $dato= array(
                    'home' => 0,
                    'listaCliente' => 0,
                    'corridaF' => 0,
                    'inventario' => 0,
                    'prospectos' => 0,
                    'prospectosAlta' => 0,
                    'statistic' => 0,
                    'comisiones' => 0,
                    'DS'	=> 0,
                    'DSConsult' => 0,
                    'documentacion'	=> 0,
                    'inventarioDisponible'	=>	0,
                    'manual'	=>	0,
                    'sharedSales' => 0,
                    'coOwners' => 0,
                    'bulkload' => 1,
                    'listaAsesores' => 0,
                    'prospectosMktd' => 0,
                    'altaUsuarios' => 0,
                    'listaUsuarios' => 0
                );
                //$this->load->view('template/asesor/sidebar', $dato);
                $this->load->view('template/sidebar', $dato);
                break;
            case "6": // ASISTENTE GERENCIA
                $dato= array(
                    'home' => 0,
                    'listaCliente' => 0,
                    'corridaF' => 0,
                    'documentacion' => 0,
                    'autorizacion' => 0,
                    'contrato' => 0,
                    'inventario' => 0,
                    'estatus8' => 0,
                    'estatus14' => 0,
                    'estatus7' => 0,
                    'reportes' => 0,
                    'estatus9' => 0,
                    'disponibles' => 0,
                    'asesores' => 0,
                    'nuevasComisiones' => 0,
                    'histComisiones' => 0,
                    'prospectos' => 0,
                    'prospectosAlta' => 0,
                    'sharedSales' => 0,
                    'coOwners' => 0,
                    'bulkload' => 1,
                    'listaAsesores' => 0,
                    'prospectosMktd' => 0,
                    'altaUsuarios' => 0,
                    'listaUsuarios' => 0
                );
                $this->load->view('template/sidebar', $dato);//template/ventas/sidebar
                break;
            default:
                $dato= array(
                    'prospectos' => 0,
                    'prospectosAlta' => 0,
                    'sharedSales' => 0,
                    'coOwners' => 0,
                    'bulkload' => 1,
                    'listaAsesores' => 0,
                    'prospectosMktd' => 0,
                    'altaUsuarios' => 0,
                    'listaUsuarios' => 0
                );
                $this->load->view('template/sidebar', $dato);
                break;
        }
        ?>

        <style>

        </style>

        <div class="content" id="bulkload_div">
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
                                                <h4 class="card-title">Carga masiva de prospectos</h4>
                                                <div class="table-responsive">
                                                    <div class="material-datatables">
                                                        <form method="post" enctype="multipart/form-data" name="my_bulkload_form" id="my_bulkload_form  ">

                                                            <div class="file-loading" >
                                                                <input id="customFile" name="customFile" class="file" type="file" data-min-file-count="1" data-theme="fas" accept=".csv" >
                                                            </div>
                                                            <br>
                                                            <button type="reset" class="btn">Limpiar</button>
<!--                                                            <button type="submit" class="btn" style="background-color: #4caf50;">Insertar</button>-->
                                                            <button type="button" class="btn" style="background-color: #4caf50;" onclick="sendCsvFile()">Insertar</button>

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

        <?php $this->load->view('template/footer_legend');?>

    </div>
</div>
</body>

<?php $this->load->view('template/footer');?>
<script src="<?=base_url()?>dist/js/controllers/general-1.1.0.js"></script>

<script src="<?=base_url()?>dist/js/controllers/files/plugins/piexif.js" type="text/javascript"></script>
<script src="<?=base_url()?>dist/js/controllers/files/plugins/sortable.js" type="text/javascript"></script>
<script src="<?=base_url()?>dist/js/controllers/files/fileinput.js" type="text/javascript"></script>
<!--        <script src="--><?//=base_url()?><!--dist/js/controllers/files/locales/fr.js" type="text/javascript"></script>-->
<script src="<?=base_url()?>dist/js/controllers/files/locales/es.js" type="text/javascript"></script>
<script src="<?=base_url()?>dist/js/controllers/files/themes/fas/theme.js" type="text/javascript"></script>
<script src="<?=base_url()?>dist/js/controllers/files/themes/explorer-fas/theme.js" type="text/javascript"></script>

<script>
    $('#file-es').fileinput({
        theme: 'fas',
        language: 'es',
        uploadUrl: '#',
        allowedFileExtensions: ['jpg', 'png', 'gif']
    });

</script>

</html>
