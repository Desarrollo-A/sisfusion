<?php
    date_default_timezone_set ('America/Mexico_City');
    setlocale(LC_TIME, 'spanish');
    switch ($this->session->userdata('id_rol')) {
        case "1": // DIRECTOR
        case "2": // SUBDIRECTOR
        case "3": // GERENTE
        case "4": // ASISTENTE DIRECTOR
        case "5": // ASISTENTE SUBDIRECTOR
        case "8": // SOPORTE
        case "9": // COORDINADOR
        case "10": // EJECUTIVO ADMINISTRATIVO DE MKTD
        case "19": // SUBDIRECTOR MKTD
        case "20": // GERENTE MKTD
        case "21": // CLIENTE
        case "22": // GERENTE MKTD
        case "23": // CLIENTE
		case "28": // CLIENTE
            $dato= array(
                'home' => 1,
                'usuarios' => 0,
                'statistics' => 0,
                'manual' => 0,
                'aparta' => 0,
                'prospectos' => 0,
                'clientsList' => 0,
                'prospectosMktd' => 0,
                'prospectosAlta' => 0,
                'corridaF' => 0,
                'inventario' => 0,
                'inventarioDisponible' => 0,
                'sharedSales' => 0,
                'coOwners' => 0,
                'references' => 0,
                'statistics1' => 0,
                'statistics2' => 0,
                'nuevasComisiones' => 0,
                'histComisiones' => 0,
                'bulkload' => 0,
                'listaAsesores' => 0,
                'listaUsuarios' => 0,
                'altaUsuarios' => 0,
				'autorizaciones' => 0,
				'mkt_digital' => 0,
				'prospectPlace' => 0,
				'documentacionMKT' => 0,
				'inventarioMKT' => 0
            );
            $this->load->view('template/sidebar', $dato);
            break;


             case "18": // DIRECTOR MKTD
            $dato= array(
                'home' => 1,
                'usuarios' => 0,
                'statistics' => 0,
                'manual' => 0,
                'aparta' => 0,
                'prospectos' => 0,
                'clientsList' => 0,
                'prospectosMktd' => 0,
                'prospectosAlta' => 0,
                'sharedSales' => 0,
                'coOwners' => 0,
                'references' => 0,
                'plazasComisiones'     => 0,
                'nuevasComisiones' => 0,
                'histComisiones' => 0,
                'bulkload' => 0,
                'listaAsesores' => 0,
                'listaUsuarios' => 0,
                'altaUsuarios' => 0
            );

            //$this->load->view('template/ventas_pr/sidebar', $dato);
            $this->load->view('template/sidebar', $dato);
            break;

        case "7": // ASESOR
            $dato= array(
                'home' => 1,
                'listaCliente' => 0,
                'corridaF' => 0,
                'inventario' => 0,
                'prospectos' => 0,
                'clientsList' => 0,
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
                'coOwners' => 0,
                'references' => 0,
                'bulkload' => 0,
                'listaAsesores' => 0,
                'nuevasComisiones' => 0,
                'histComisiones' => 0,
				'autoriza' => 0,
                'listaUsuarios' => 0,
                'altaUsuarios' => 0
            );
            $this->load->view('template/sidebar', $dato);
//            var_dump("entra  a statistics.php case 7 asesor and load sidebar");
            break;
        case "6": // ASISTENTE GERENCIA
            $dato= array(
                'home' => 1,
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
                'clientsList' => 0,
                'prospectosMktd' => 0,
                'prospectosAlta' => 0,
                'statistics' => 0,
                'sharedSales' => 0,
                'coOwners' => 0,
                'references' => 0,
                'manual' => 0,
                'aparta' => 0,
                'bulkload' => 0,
                'listaAsesores' => 0,
                'listaUsuarios' => 0,
                'altaUsuarios' => 0
            );
            $this->load->view('template/sidebar', $dato);
            break;
        default:
            $dato= array(
                'home' => 1,
                'prospectos' => 0,
                'clientsList' => 0,
                'prospectosMktd' => 0,
                'prospectosAlta' => 0,
                'statistics' => 1,
                'sharedSales' => 0,
                'coOwners' => 0,
                'references' => 0,
                'bulkload' => 0,
                'listaAsesores' => 0,
                'listaUsuarios' => 0,
                'altaUsuarios' => 0
            );
            $this->load->view('template/sidebar', $dato);
            break;
    }

    $prospectsNumber = $tprospectos[0]->prospects_number;
    $currentProspectsNumber = $pvigentes[0]->prospects_number;
    $nonCurrentProspectsNumber = $pnovigentes[0]->prospects_number;
    $clientsNumber = $tclientes[0]->clients_number;
    $t1 = 0;
    $t2 = 0;
    $t3 = 0;
    $t4 = 0;
    $t5 = 0;
    $t6 = 0;

    for ($i = 0; $i < COUNT($monthlyProspects); $i++) {
        $month_name[$i] = "'".$monthlyProspects[$i]->month_name."'";
        $prospects_number[$i] = $monthlyProspects[$i]->prospects_number;
    }

    // SAN LUIS POTOSÍ
    for ($i = 0; $i < COUNT($dataSlp); $i++) {
        $slp_name[$i] = "'".$dataSlp[$i]->month_name."'";
        $slp_number[$i] = $dataSlp[$i]->prospects_number;
        $t1 += $slp_number[$i];
    }

    // QUERÉTARO
    for ($i = 0; $i < COUNT($dataQro); $i++) {
        $qro_name[$i] = "'".$dataQro[$i]->month_name."'";
        $qro_number[$i] = $dataQro[$i]->prospects_number;
        $t2 += $qro_number[$i];
    }

    // PENÍNSULA
    for ($i = 0; $i < COUNT($dataPen); $i++) {
        $pen_name[$i] = "'".$dataPen[$i]->month_name."'";
        $pen_number[$i] = $dataPen[$i]->prospects_number;
        $t3 += $pen_number[$i];
    }

    // CDMX
    for ($i = 0; $i < COUNT($dataCdmx); $i++) {
        $cdmx_name[$i] = "'".$dataCdmx[$i]->month_name."'";
        $cdmx_number[$i] = $dataCdmx[$i]->prospects_number;
        $t4 += $cdmx_number[$i];
    }

    // LEÓN
    for ($i = 0; $i < COUNT($dataLeo); $i++) {
        $leo_name[$i] = "'".$dataLeo[$i]->month_name."'";
        $leo_number[$i] = $dataLeo[$i]->prospects_number;
        $t5 += $leo_number[$i];
    }

    // CANCÚN
    for ($i = 0; $i < COUNT($dataCan); $i++) {
        $can_name[$i] = "'".$dataCan[$i]->month_name."'";
        $can_number[$i] = $dataCan[$i]->prospects_number;
        $t6 += $can_number[$i];
    }
?>
