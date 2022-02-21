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
            'prospectos' => 1,
            'prospectosMktd' => 0,
            'prospectosAlta' => 0,
            'autorizacionesReport' => 0,
            'clubMaderasReport' => 0,
            'sharedSales' => 0,
            'coOwners' => 0,
            'references' => 0,
            'nuevasComisiones' => 0,
            'histComisiones' => 0,
            'bulkload' => 0,
            'corridaF' => 0,
            'inventario' => 0,
            'listaAsesores' => 0,
            'inventarioDisponible' => 0,
			'autorizaciones' =>	0,
			'listaUsuarios'	=> 0,
			'altaUsuarios'=>	0,
            'consDepositoSeriedad' => 0,
            'clientsList' => 0,
            'DS' => 0,
            'autoriza' => 0,
            'DSConsult' => 0,
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
            'listaAsesores' => 0,
            'inventarioDisponible' => 0,
            'altaUsuarios' => 0,
            'asignarVentas' => 0,
            'listaUsuarios' => 0,
            'carpetaPdf' => 0,
            'busquedaDetallada' => 0

        );
        $this->load->view('template/sidebar', $dato);
        break;
    case "7": // ASESOR
        $dato= array(
            'home' => 0,
            'listaCliente' => 0,
			'corridaF' => 0,
            'inventario' => 0,
            'prospectos' => 1,
            'prospectosMktd' => 0,
            'prospectosAlta' => 0,
            'statistic' => 0,
            'comisiones' => 0,
            'DS'	=> 0,
            'DSConsult' => 0,
            'documentacion'	=> 0,
            'inventarioDisponible'	=>	0,
            'manual'	=>	0,
            'statistics' => 0,
            'sharedSales' => 0,
            'DS' => 0,
                'autoriza' => 0,
                'DSConsult' => 0,
            'coOwners' => 0,
            'references' => 0,
            'nuevasComisiones' => 0,
            'histComisiones' => 0,
            'bulkload' => 0,
			'autoriza' => 0,
            'listaAsesores' => 0,
            'altaUsuarios' => 0,
            'consDepositoSeriedad' => 0,
            'listaUsuarios' => 0,
            'asignarVentas' => 0,
			'clientsList' => 0,
            'carpetaPdf' => 0
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
                'prospectosAlta' => 1,
                'sharedSales' => 0,
                'coOwners' => 0,
                'references' => 0,
                'plazasComisiones'     => 0,
                'nuevasComisiones' => 0,
                'histComisiones' => 0,
                'bulkload' => 0,
                'corridaF' => 0,
                'inventario' => 0,
                'listaAsesores' => 0,
                'inventarioDisponible' => 0,
                'altaUsuarios' => 0,
                'asignarVentas' => 0,
                'listaUsuarios' => 0,
            'busquedaDetallada' => 0
            );

             //$this->load->view('template/ventas_pr/sidebar', $dato);
             $this->load->view('template/sidebar', $dato);
             break;
                 // case "5": // ASISTENTE SUBDIRECTOR
    // case "5": // ASISTENTE SUBDIRECTOR
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
            'DS' => 0,
                'autoriza' => 0,
                'DSConsult' => 0,
            'asesores' => 0,
            'nuevasComisiones' => 0,
            'histComisiones' => 0,
            'prospectos' => 1,
            'prospectosMktd' => 0,
            'prospectosAlta' => 0,
            'statistics' => 0,
            'sharedSales' => 0,
            'coOwners' => 0,
            'references' => 0,
            'bulkload' => 0,
            'listaAsesores' => 0,
            'inventarioDisponible' => 0,
            'altaUsuarios' => 0,
            'listaUsuarios' => 0,
            'consDepositoSeriedad' => 0,
            'asignarVentas' => 0,
            'consDepositoSeriedad' => 0,
            'busquedaDetallada' => 0
        );
        $this->load->view('template/sidebar', $dato);
        break;
    default:
        $dato= array(
            'prospectos' => 1,
            'prospectosMktd' => 0,
            'prospectosAlta' => 0,
            'statistics' => 0,
            'sharedSales' => 0,
            'coOwners' => 0,
            'references' => 0,
            'nuevasComisiones' => 0,
            'histComisiones' => 0,
            'bulkload' => 0,
            'listaAsesores' => 0,
            'corridaF' => 0,
            'inventario' => 0,
            'inventarioDisponible' => 0,
            'altaUsuarios' => 0,
            'consDepositoSeriedad' => 0,
            'asignarVentas' => 0,
            'listaUsuarios' => 0
        );
        $this->load->view('template/sidebar', $dato);
        break;
}
?>
