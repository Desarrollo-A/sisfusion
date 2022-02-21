<body>
<div class="wrapper">
    <?php
    switch ($this->session->userdata('id_rol')) {
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
                'plazasComisiones'     => 0,
                'manual'	=>	1,
                'nuevasComisiones'  =>  0,
                'histComisiones'  =>  0  ,
                'prospectosMktd' => 0,
                'bulkload' => 0,
				'sharedSales'	=>	0,
				'coOwners' =>	0,
				'references'	=>	0,
				'autoriza'	=>	0,
                'clientsList' => 0
				);
            $this->load->view('template/sidebar', $dato);
            break;
        case "1": // DIRECTOR
        case "2": // SUBDIRECTOR
        case "3": // GERENTE
        case "4": // ASISTENTE DIRECTOR
        case "5": // ASISTENTE SUBDIRECTOR
        case "9": // COORDINADOR
        case "19": // SUBDIRECTOR MKTD
        case "20": // GERENTE MKTD
        case "21": // CLIENTE
            $dato= array(
                'home' => 0,
                'usuarios' => 0,
                'aparta' => 0,
                'prospectos' => 0,
                'prospectosAlta' => 0,
                'statistics' => 0,
                'manual'	=>	1,
                'prospectosMktd' => 0,
                'bulkload' => 0,
                'corridaF' => 0,
                'inventario' => 0,
                 'nuevasComisiones'     => 0,
                    'histComisiones'       => 0,
                'inventarioDisponible'	=>	0,
				'autorizaciones'	=>	0,
				'listaUsuarios'	=> 0,
				'altaUsuarios' =>	0,
				'listaAsesores' => 0,
                'clientsList' => 0
            );
            $this->load->view('template/sidebar', $dato);
            break;


        case "18": // DIRECTOR MKTD
           $dato= array(
                'home' => 0,
                'usuarios' => 0,
                'statistics' => 0,
                'manual' => 1,
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
                'bulkload' => 0,
                'corridaF' => 0,
                'inventario' => 0,
                'inventarioDisponible'	=>	0,
               'clientsList' => 0
            );
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
                'statistics' => 0,
                'manual'	=>	1,
                'prospectosMktd' => 0,
                'bulkload' => 0,
                'inventarioDisponible'	=>	0,
                'clientsList' => 0
            );
            $this->load->view('template/sidebar', $dato);
            break;
        default:
            $dato= array(
            	'home' => 0,
                'prospectos' => 0,
                'prospectosAlta' => 0,
                'statistics' => 0,
                'manual'	=>	1,
                'nuevasComisiones'  =>  0,
                'histComisiones'  =>  0,
                'prospectosMktd' => 0,
                'bulkload' => 0,
                'corridaF' => 0,
                'inventario' => 0,
                'inventarioDisponible'	=>	0,
				'aparta' => 0,
				'documentacionMKT' => 0,
				'inventarioMKT' => 0,
				'mkt_digital' => 0,
				'prospectPlace' => 0,
                'clientsList' => 0
            );
            $this->load->view('template/sidebar', $dato);
            break;
    }
    ?>
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<center>
						<h3>MANUAL</h3>
					</center>
				</div>
			</div>
			<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="row ">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">

							<div class="container-fluid">
								<!--"static/documentos/manuales/muc_asesor.pdf#toolbar=0"-->
								<embed src="https://contratacion.gphsis.com/contratacion/static/documentos/manuales/muc_asesor.pdf#toolbar=0" frameborder="0" width="100%" height="770em">
							</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<?php $this->load->view('template/footer_legend');?>
</div>


</div><!--main-panel close-->
</body>
<?php $this->load->view('template/footer');?>


</html>
