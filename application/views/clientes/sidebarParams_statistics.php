<?php
    date_default_timezone_set ('America/Mexico_City');
    setlocale(LC_TIME, 'spanish');

    $this->load->view('template/sidebar', "");
    


    $month_name = array();

    $prospectsNumber = $tprospectos->prospects_number;
    $currentProspectsNumber = $pvigentes->prospects_number;
    $nonCurrentProspectsNumber = $pnovigentes->prospects_number;
    $clientsNumber = $tclientes->prospects_number;

    /*$prospectsNumber = $tprospectos[0]->prospects_number;
    $currentProspectsNumber = $pvigentes[0]->prospects_number;
    $nonCurrentProspectsNumber = $pnovigentes[0]->prospects_number;
    $clientsNumber = $tclientes[0]->clients_number;*/

    $t1 = 0;
    $t2 = 0;
    $t3 = 0;
    $t4 = 0;
    $t5 = 0;
    $t6 = 0;

//var_dump($monthlyProspects);
    
        for ($i = 0; $i < COUNT($monthlyProspects); $i++) {
        $month_name[$i] = "'".$monthlyProspects[$i]->month_name."'";
        $prospects_number[$i] = $monthlyProspects[$i]->prospects_number;
    }
//var_dump($month_name);
    // SAN LUIS POTOSÍ
    for ($i = 0; $i < COUNT($dataSlp); $i++) {
        $slp_name[$i] = "'".$dataSlp[$i]->month_name."'";
        $slp_number[$i] = $dataSlp[$i]->prospects_number;
        $t1 += intval($slp_number[$i]);
    }

    // QUERÉTARO
    for ($i = 0; $i < COUNT($dataQro); $i++) {
        $qro_name[$i] = "'".$dataQro[$i]->month_name."'";
        $qro_number[$i] = $dataQro[$i]->prospects_number;
        $t2 += intval($qro_number[$i]);
    }

    // PENÍNSULA
    for ($i = 0; $i < COUNT($dataPen); $i++) {
        $pen_name[$i] = "'".$dataPen[$i]->month_name."'";
        $pen_number[$i] = $dataPen[$i]->prospects_number;
        $t3 += intval($pen_number[$i]);
    }

    // CDMX
    for ($i = 0; $i < COUNT($dataCdmx); $i++) {
        $cdmx_name[$i] = "'".$dataCdmx[$i]->month_name."'";
        $cdmx_number[$i] = $dataCdmx[$i]->prospects_number;
        $t4 += intval($cdmx_number[$i]);
    }

    // LEÓN
    for ($i = 0; $i < COUNT($dataLeo); $i++) {
        $leo_name[$i] = "'".$dataLeo[$i]->month_name."'";
        $leo_number[$i] = $dataLeo[$i]->prospects_number;
        $t5 += intval($leo_number[$i]);
    }

    // CANCÚN
    for ($i = 0; $i < COUNT($dataCan); $i++) {
        $can_name[$i] = "'".$dataCan[$i]->month_name."'";
        $can_number[$i] = $dataCan[$i]->prospects_number;
        $t6 += intval($can_number[$i]);
    }
?>
