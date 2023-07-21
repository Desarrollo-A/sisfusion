<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Contraloria extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Contraloria_model');
        $this->load->model('registrolote_modelo');
        $this->load->model('Clientes_model');
        $this->load->model('asesor/Asesor_model'); //EN ESTE MODELO SE ENCUENTRAN LAS CONSULTAS DEL MENU
        $this->load->model('General_model');
        $this->load->library(array('session','form_validation', 'get_menu', 'Formatter'));
        $this->load->helper(array('url','form'));
        $this->load->database('default');
        $this->load->library('email');
        $this->validateSession();
        date_default_timezone_set('America/Mexico_City');
        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
    }

    public function index() {
        if($this->session->userdata('perfil') == FALSE || ($this->session->userdata('perfil') != 'contraloria' && $this->session->userdata('perfil') != 'contraloriaCorporativa' && $this->session->userdata('perfil') != 'subdirectorContraloria' && $this->session->userdata('perfil') != 'direccionFinanzas' && $this->session->userdata('perfil') != 'direccionFinanzas' && $this->session->userdata('perfil') != 'ejecutivoContraloriaJR'))
        {
            redirect(base_url().'login');
        }
        $this->load->view('template/header');
        $this->load->view('template/home');
        $this->load->view('template/footer');
    }

    public function expediente_contraloria() {
		$this->load->view('template/header');
		$datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
		$this->load->view("contraloria/vista_expediente_contraloria", $datos);
	}

	public function corrida_contraloria() {
		$datos=array();
		$this->load->view('template/header');
	 	$this->load->view("contraloria/vista_corrida_contraloria");
	}

    public function documentacion_contraloria() {
		$this->validateSession();
		$datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
		$this->load->view('template/header');
		$this->load->view("contraloria/vista_documentacion_contraloria",$datos);
	}

	public function documentacion_contraloria_ds() {
        $this->validateSession();
        $datos=array();
        $datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
        $this->load->view('template/header');
        $this->load->view("contraloria/vista_documentacion_contraloria_ds",$datos);
    }

	public function historial_pagos_contraloria() {          
        $this->load->view('template/header');
        $this->load->view("contraloria/vista_historial_pagos_contraloria");
    }

    public function estatus_2_0_contraloria() {
        $this->load->view('template/header');
        $this->load->view("contraloria/vista_2_0_contraloria");
    }

    public function estatus_2_contraloria() {
        $this->load->view('template/header');
        $this->load->view("contraloria/vista_2_contraloria");
    }

    public function estatus_5_contraloria() {
        $this->load->view('template/header');
        $this->load->view("contraloria/vista_5_contraloria");
    }

    public function estatus_6_contraloria() {
        $this->load->view('template/header');
        $this->load->view("contraloria/vista_6_contraloria");
    }

    public function getCommissionPlans() {
        echo json_encode($this->Contraloria_model->getCommissionPlans()->result_array());
    }

    public function estatus_9_contraloria() {
        $this->load->view('template/header');
        $this->load->view("contraloria/vista_9_contraloria");
    }

    public function estatus_10_contraloria() {
        $this->load->view('template/header');
        $this->load->view("contraloria/vista_10_contraloria");
    }

    public function envio_RL_contraloria() {
        $this->load->view('template/header');
        $this->load->view("contraloria/vista_envio_RL_contraloria");
    }

    public function envio_RL_contraloria_2() {
		$this->load->view('template/header');
	 	$this->load->view("contraloria/vista_envio_RL_contraloria_2");
	}

    public function estatus_12_contraloria() {
        $this->load->view('template/header');
        $this->load->view("contraloria/vista_12_contraloria");
    }

    public function estatus_13_contraloria() {
        $this->load->view('template/header');
        $this->load->view("contraloria/vista_13_contraloria");
    }

    public function estatus_15_contraloria() {
        $this->load->view('template/header');
        $this->load->view("contraloria/vista_15_contraloria");
    }

    public function getProyectoExpediente() {
        echo json_encode($this->Contraloria_model->getProyecto()->result_array());
    }

    public function listaClientes() {
        $this->validateSession();
        $this->load->view('template/header');
        $this->load->view("contratacion/datos_cliente_contratacion_view");
    }

    public function inventario() {
        $this->validateSession();
        $datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
        $this->load->view('template/header');
        $this->load->view("contratacion/datos_lote_contratacion_view", $datos);
    }

    public function lista_proyecto() {
        echo json_encode($this->Contraloria_model->get_proyecto_lista()->result_array());
    }

    public function lista_condominio($proyecto) {
        echo json_encode($this->Contraloria_model->get_condominio_lista($proyecto)->result_array());
    }

    public function lista_lote($condominio) {
        $residencial = 0;
        $data = $this->registrolote_modelo->getLotesGral($condominio,$residencial);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function lista_estatus($condominio) {
        echo json_encode($this->Contraloria_model->get_lote_lista($condominio)->result_array());
    }

    public function get_lote_expediente($lote) {
        echo json_encode($this->Contraloria_model->get_datos_lote_exp($lote)->result_array());
    }

    public function get_lote_historial_pagos($lote) {
        echo json_encode($this->Contraloria_model->get_datos_lote_pagos($lote)->result_array());
    }

    public function getStatus2_0() {
        $data = $this->registrolote_modelo->registroStatusContratacion2_0();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }
    public function registroStatusContratacionAsistentes2() {
        $data = array();
        $data = $this->registrolote_modelo->registroStatusContratacion2();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function getregistroStatus6ContratacionContraloria() {
        $data = array();
        $data = $this->Contraloria_model->registroStatusContratacion6();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function getregistroStatus9ContratacionContraloria() {
        $datos = array();
        $datos = $this->Contraloria_model->registroStatusContratacion9();
        if($datos != null) {
            echo json_encode($datos);
        } else {
            echo json_encode(array());
        }
    }
    public function getregistroStatus10ContratacionContraloria() {
        $datos = array();
        $datos= $this->registrolote_modelo->registroStatusContratacion10();
        if($datos != null) {
            echo json_encode($datos);
        } else {
            echo json_encode(array());
        }
    }

    public function getregistroStatus13ContratacionContraloria() {
        $datos = array();
        $datos = $this->Contraloria_model->registroStatusContratacion13();

        if($datos != null) {
            echo json_encode($datos);
        } else {
            echo json_encode(array());
        }

    }

    public function getregistroStatus15ContratacionContraloria() {
        $datos = array();
        $datos = $this->Contraloria_model->registroStatusContratacion15();
        if($datos != null) {
            echo json_encode($datos);
        } else {
            echo json_encode(array());
        }
    }

    public function getrecepcionContratos() {
        $datos = array();
        $datos = $this->Contraloria_model->registroStatusContratacion10v2();
        if ($datos != null) {
            echo json_encode($datos);
        }
        else {
            echo json_encode(array());
        }
    }

    public function getManagersVentas() {
        echo json_encode($this->Clientes_model->getManagersVentas()->result_array());
    }

    public function getCoordinatorsVentas() {
        echo json_encode($this->Clientes_model->getCoordinatorsVentas()->result_array());
    }

    public function getAdvisersVentas() {
        echo json_encode($this->Clientes_model->getAdvisersVentas()->result_array());
    }

    public function consultClients() {
        $this->validateSession();
        $datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
        $this->load->view('template/header');
        $this->load->view("contraloria/vista_documentacion_contraloria_cl",$datos);
    }

    public function reasignClient() {
        $data = array(
            "id_gerente" => $_POST['id_gerente'],
            "id_coordinador" => $_POST['id_coordinador'],
            "id_asesor" => $_POST['id_asesor'],
            "fecha_modificacion" => date("Y-m-d H:i:s"),
            "modificado_por" => $this->session->userdata('id_usuario')
        );
        $response = $this->Clientes_model->updateClient($data, $this->input->post("id_cliente"));
        echo json_encode($response);
    }

    public function validateSession() {
        if($this->session->userdata('id_usuario')=="" || $this->session->userdata('id_rol')=="")
        {
            redirect(base_url() . "index.php/login");
        }
    }

    public function getCorridasContraloria() {
        $data= $this->registrolote_modelo->corridaContraloria();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }

    }

    public function depositoSeriedad_SPU() {
        $this->validateSession();
        $datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
        $this->load->view('template/header');
        $this->load->view("contraloria/ds_mariela",$datos);
    }

    function getLotesAll($condominio) {
        $data = $this->Contraloria_model->getLotes($condominio);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function getAllDsByLote($idLote) {
        $dato = $this->Contraloria_model->getAllDsByLote($idLote);
        if($dato != null) {
            echo json_encode($dato);
        }
        else
        {
            echo json_encode(array());
        }
    }

    public function sendMailRecepExp() {
        $idLote=$this->input->post('idLote');
        $nombreLote=$this->input->post('nombreLote');

        $datos= $this->registrolote_modelo->getInfoAsRechazoEst3($idLote);

        $arregloAs =array();
        $arregloAs["asesor1"]=$datos["correo"];


        $listCheckVacio = array_filter($arregloAs, "strlen");
        $correosClean = implode(', ', $listCheckVacio);
        $array=explode(",",$correosClean);

        $encabezados = [
            'nombreResidencial'    => 'PROYECTO',
            'nombreCondominio'     => 'CONDOMINIO',
            'nombreLote'           => 'LOTE',
            'fechaHora'            => 'FECHA/HORA'
        ];

        $contenido[] = array_merge($datos, ['fechaHora' => date("Y-m-d H:i:s")]);

        $this->email
            ->initialize()
            ->from('Ciudad Maderas')
            ->to('tester.ti2@ciudadmaderas.com')
            ->subject('EXPEDIENTE INGRESADO - CIUDAD MADERAS')
            ->view($this->load->view('mail/contraloria/recep-exp', [
                'encabezados' => $encabezados,
                'contenido' => $contenido
            ], true));

        $arreglo=array();
        $arreglo["idStatusContratacion"]=2;
        $arreglo["idMovimiento"]=84;
        $arreglo["usuario"]=$this->session->userdata('usuario');
        $arreglo["perfil"]=$this->session->userdata('id_rol');
        $arreglo["modificado"]=date("Y-m-d H:i:s");
        $arreglo["comentario"]= "Ok recepción de expediente";


        $horaActual = date('H:i:s');
        $horaInicio = date("08:00:00");
        $horaFin = date("16:00:00");


        if ($horaActual > $horaInicio and $horaActual < $horaFin) {

            $fechaAccion = date("Y-m-d H:i:s");
            $hoy_strtotime2 = strtotime($fechaAccion);
            $sig_fecha_dia2 = date('D', $hoy_strtotime2);
            $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);



            if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
                $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
                $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
                $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
                $sig_fecha_feriado2 == "25-12") {

                $fecha = $fechaAccion;
                $i = 0;

                while($i <= 1) {
                    $hoy_strtotime = strtotime($fecha);
                    $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                    $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                    $sig_fecha_dia = date('D', $sig_strtotime);
                    $sig_fecha_feriado = date('d-m', $sig_strtotime);


                    if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
                        $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                        $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                        $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                        $sig_fecha_feriado == "25-12") {
                    }
                    else {
                        $fecha= $sig_fecha;
                        $i++;
                    }
                    $fecha = $sig_fecha;

                }
                $arreglo["fechaVenc"]= $fecha;

            }else{

                $fecha = $fechaAccion;
                $i = 0;
                while($i <= 0) {
                    $hoy_strtotime = strtotime($fecha);
                    $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                    $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                    $sig_fecha_dia = date('D', $sig_strtotime);
                    $sig_fecha_feriado = date('d-m', $sig_strtotime);

                    if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
                        $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                        $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                        $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                        $sig_fecha_feriado == "25-12") {
                    }
                    else {
                        $fecha= $sig_fecha;
                        $i++;
                    }
                    $fecha = $sig_fecha;
                }

                $arreglo["fechaVenc"]= $fecha;

            }

        }
        elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {

            $fechaAccion = date("Y-m-d H:i:s");
            $hoy_strtotime2 = strtotime($fechaAccion);
            $sig_fecha_dia2 = date('D', $hoy_strtotime2);
            $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);

            if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
                $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
                $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
                $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
                $sig_fecha_feriado2 == "25-12") {

                $fecha = $fechaAccion;
                $i = 0;

                while($i <= 1) {
                    $hoy_strtotime = strtotime($fecha);
                    $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                    $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                    $sig_fecha_dia = date('D', $sig_strtotime);
                    $sig_fecha_feriado = date('d-m', $sig_strtotime);

                    if($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
                        $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                        $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                        $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                        $sig_fecha_feriado == "25-12") {
                    }
                    else {
                        $fecha= $sig_fecha;
                        $i++;
                    }
                    $fecha = $sig_fecha;
                }

                $arreglo["fechaVenc"]= $fecha;

            }else{
                $fecha = $fechaAccion;
                $i = 0;

                while($i <= 1) {
                    $hoy_strtotime = strtotime($fecha);
                    $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                    $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                    $sig_fecha_dia = date('D', $sig_strtotime);
                    $sig_fecha_feriado = date('d-m', $sig_strtotime);

                    if($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
                        $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                        $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                        $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                        $sig_fecha_feriado == "25-12") {
                    }
                    else {
                        $fecha= $sig_fecha;
                        $i++;
                    }
                    $fecha = $sig_fecha;
                }

                $arreglo["fechaVenc"]= $fecha;

            }
        }


        $arreglo2=array();
        $arreglo2["idStatusContratacion"]=2;
        $arreglo2["idMovimiento"]=84;
        $arreglo2["nombreLote"]=$nombreLote;
        $arreglo2["usuario"]=$this->session->userdata('usuario');
        $arreglo2["perfil"]=$this->session->userdata('id_rol');
        $arreglo2["modificado"]=date("Y-m-d H:i:s");
        $arreglo2["fechaVenc"]= $datos["fechaVenc"];
        $arreglo2["idLote"]= $idLote;
        $arreglo2["idCondominio"]= $datos["idCondominio"];
        $arreglo2["idCliente"]= $datos["idCliente"];
        $arreglo2["comentario"]= "Ok recepción de expediente";

        if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote,$arreglo) && $this->registrolote_modelo->insertHistorialLotes($arreglo2)){
            if($this->email->send()){
                echo 1;
            }else{
                echo $this->email->print_debugger();
            }
        }
        else
        {
            echo 0;
        }
    }

    public function sendMailRechazoEst2_0() {
        $idLote=$this->input->post('idLote');
        $nombreLote=$this->input->post('nombreLote');
        $motivoRechazo=$this->input->post('motivoRechazo');
        $datos= $this->registrolote_modelo->getInfoAsRechazoEst3($idLote);
        $arregloAs =array();
        $arregloAs["asesor1"]=$datos["correo"];
        $listCheckVacio = array_filter($arregloAs, "strlen");
        $correosClean = implode(', ', $listCheckVacio);
        $array=explode(",",$correosClean);

        $encabezados = [
            'nombreResidencial' => 'PROYECTO',
            'nombreCondominio'  => 'CONDOMINIO',
            'nombreLote'        => 'LOTE',
            'motivoRechazo'     => 'MOTIVO DE RECHAZO',
            'fechaHora'         => 'FECHA/HORA'
        ];

        $contenido = array_merge($datos, ['motivoRechazo' => $motivoRechazo, 'fechaHora' => date("Y-m-d H:i:s")]);

        $this->email
            ->initialize()
            ->from('Ciudad Maderas')
            ->to('tester.ti2@ciudadmaderas.com')
            ->subject('EXPEDIENTE RECHAZADO-CONTRALORÍA (2. Integración de Expediente)')
            ->view($this->load->view('mail/contraloria/rechazo-est2-0', [
                'encabezados' => $encabezados,
                'contenido' => $contenido
            ], true));

        $arreglo=array();
        $arreglo["idStatusContratacion"]=2;
        $arreglo["idMovimiento"]=85;
        $arreglo["comentario"]=$motivoRechazo;
        $arreglo["usuario"]=$this->session->userdata('usuario');
        $arreglo["perfil"]=$this->session->userdata('id_rol');
        $arreglo["modificado"]=date("Y-m-d H:i:s");
        $arreglo["fechaVenc"]= date("Y-m-d H:i:s");


        $arreglo2=array();
        $arreglo2["idStatusContratacion"]=2;
        $arreglo2["idMovimiento"]=85;
        $arreglo2["nombreLote"]=$nombreLote;
        $arreglo2["comentario"]=$motivoRechazo;
        $arreglo2["usuario"]=$this->session->userdata('usuario');
        $arreglo2["perfil"]=$this->session->userdata('id_rol');
        $arreglo2["modificado"]=date("Y-m-d H:i:s");
        $arreglo2["fechaVenc"]= date("Y-m-d H:i:s");
        $arreglo2["idLote"]= $idLote;
        $arreglo2["idCondominio"]= $datos["idCondominio"];
        $arreglo2["idCliente"]= $datos["idCliente"];

        if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote,$arreglo) && $this->registrolote_modelo->insertHistorialLotes($arreglo2)){
            if($this->email->send()){
                echo 1;
            }else{
                echo $this->email->print_debugger();
            }
        }
        else
        {
            echo 0;
        }

    }

    /*reportes*/
    public function integracionExpediente() {
        $this->load->view('template/header');
        $this->load->view("contraloria/integracionExpediente");
    }

    public function getRevision2(){
        ini_set('max_execution_time', 900);
        set_time_limit(900);
        ini_set('memory_limit','2048M');

        $fechaInicio = $this->input->post('beginDate');
        $fechaFinal = $this->input->post('endDate');
        $data=array();
        $data = $this->registrolote_modelo->getRevision2($fechaInicio, $fechaFinal);
        if ($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function expRevisados() {
        $this->load->view('template/header');
        $this->load->view("contraloria/expedientesRevisados");
    }

    public function getRevision5() {
        $datos = array(
            "one" => array(
                "idStatusContratacion" => 5,
                "idMovimiento" => 35,
            ),
            "two" => array(
                "idStatusContratacion" => 5,
                "idMovimiento" => 75,
            )
        );

        if (isset($_POST) && !empty($_POST)) {
            $fechaInicio = explode('/', $this->input->post("beginDate"));
            $fechaFin = explode('/', $this->input->post("endDate"));
            $typeTransaction = $this->input->post("typeTransaction");
            $beginDate = date("Y-m-d", strtotime("{$fechaInicio[2]}-{$fechaInicio[1]}-{$fechaInicio[0]}"));
            $endDate = date("Y-m-d", strtotime("{$fechaFin[2]}-{$fechaFin[1]}-{$fechaFin[0]}"));
            $where = $this->input->post("where");
            $data['data'] = $this->registrolote_modelo->getRevision5($datos, $typeTransaction, $beginDate, $endDate, $where);
            echo json_encode($data);
        } else {
            json_encode(array());
        }
    }

    public function estatus10() {
        $this->load->view('template/header');
        $this->load->view("contraloria/status10");
    }

    public function getRevision10() {
        if (isset($_POST) && !empty($_POST)) {
            $fechaInicio = explode('/', $this->input->post("beginDate"));
            $fechaFin = explode('/', $this->input->post("endDate"));
            $typeTransaction = $this->input->post("typeTransaction");
            $beginDate = date("Y-m-d", strtotime("{$fechaInicio[2]}-{$fechaInicio[1]}-{$fechaInicio[0]}"));
            $endDate = date("Y-m-d", strtotime("{$fechaFin[2]}-{$fechaFin[1]}-{$fechaFin[0]}"));
            $where = $this->input->post("where");
            $data = $this->registrolote_modelo->getRevision10($typeTransaction, $beginDate, $endDate, $where);
            echo json_encode($data);
        } else {
            json_encode(array());
        }
    }

    public function rechazoJuridico() {
        $this->load->view('template/header');
        $this->load->view("contraloria/rechazoJuridico");
    }

    public function getRevision7() {
        $data=array();
        $data = $this->registrolote_modelo->getRevision7();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function getregistroStatus5ContratacionContraloria() {
        $data = array();
        $data = $this->Contraloria_model->registroStatusContratacion5();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function editar_registro_lote_contraloria_proceceso5() {
        $idLote=$this->input->post('idLote');
        $idCondominio=$this->input->post('idCondominio');
        $nombreLote=$this->input->post('nombreLote');
        $idCliente=$this->input->post('idCliente');
        $comentario=$this->input->post('comentario');
        $modificado=date('Y-m-d H:i:s');
        $fechaVenc=$this->input->post('fechaVenc');
        $ubicacion=$this->input->post('ubicacion');
        $tipo_venta=$this->input->post('tipo_venta');

        $arreglo=array();
        $arreglo["idStatusContratacion"]= 5;
        $arreglo["idMovimiento"]=35;
        $arreglo["comentario"]=$comentario;
        $arreglo["usuario"]=$this->session->userdata('id_usuario');
        $arreglo["perfil"]=$this->session->userdata('id_rol');
        $arreglo["modificado"]=date("Y-m-d H:i:s");
        $arreglo["ubicacion"]= $ubicacion;
        $arreglo["tipo_venta"]= $tipo_venta;

        $horaActual = date('H:i:s');
        $horaInicio = date("08:00:00");
        $horaFin = date("16:00:00");

        if ($horaActual > $horaInicio and $horaActual < $horaFin) {
            $fechaAccion = date("Y-m-d H:i:s");
            $hoy_strtotime2 = strtotime($fechaAccion);
            $sig_fecha_dia2 = date('D', $hoy_strtotime2);
            $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);


            if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
                $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
                $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
                $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
                $sig_fecha_feriado2 == "25-12") {
                $fecha = $fechaAccion;

                $i = 0;
                while($i <= 2) {
                    $hoy_strtotime = strtotime($fecha);
                    $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                    $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                    $sig_fecha_dia = date('D', $sig_strtotime);
                    $sig_fecha_feriado = date('d-m', $sig_strtotime);


                    if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
                        $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                        $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                        $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                        $sig_fecha_feriado == "25-12") {}
                    else {
                        $fecha= $sig_fecha;
                        $i++;
                    }
                    $fecha = $sig_fecha;
                }
                $arreglo["fechaVenc"]= $fecha;
            }else{
                $fecha = $fechaAccion;

                $i = 0;
                while($i <= 1) {
                    $hoy_strtotime = strtotime($fecha);
                    $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                    $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                    $sig_fecha_dia = date('D', $sig_strtotime);
                    $sig_fecha_feriado = date('d-m', $sig_strtotime);

                    if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
                        $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                        $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                        $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                        $sig_fecha_feriado == "25-12") {}
                    else {
                        $fecha= $sig_fecha;
                        $i++;
                    }
                    $fecha = $sig_fecha;
                }
                $arreglo["fechaVenc"]= $fecha;
            }

        }elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {
            $fechaAccion = date("Y-m-d H:i:s");
            $hoy_strtotime2 = strtotime($fechaAccion);
            $sig_fecha_dia2 = date('D', $hoy_strtotime2);
            $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);

            if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
                $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
                $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
                $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
                $sig_fecha_feriado2 == "25-12") {
                $fecha = $fechaAccion;
                $i = 0;
                while($i <= 2) {
                    $hoy_strtotime = strtotime($fecha);
                    $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                    $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                    $sig_fecha_dia = date('D', $sig_strtotime);
                    $sig_fecha_feriado = date('d-m', $sig_strtotime);

                    if($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
                        $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                        $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                        $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                        $sig_fecha_feriado == "25-12") {}
                    else {
                        $fecha= $sig_fecha;
                        $i++;
                    }
                    $fecha = $sig_fecha;
                }
                $arreglo["fechaVenc"]= $fecha;
            }else{
                $fecha = $fechaAccion;
                $i = 0;
                while($i <= 2) {
                    $hoy_strtotime = strtotime($fecha);
                    $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                    $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                    $sig_fecha_dia = date('D', $sig_strtotime);
                    $sig_fecha_feriado = date('d-m', $sig_strtotime);


                    if($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
                        $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                        $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                        $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                        $sig_fecha_feriado == "25-12") {}
                    else {
                        $fecha= $sig_fecha;
                        $i++;
                    }
                    $fecha = $sig_fecha;
                }
                $arreglo["fechaVenc"]= $fecha;
            }
        }
        $arreglo2=array();
        $arreglo2["idStatusContratacion"]= 5;
        $arreglo2["idMovimiento"]=35;
        $arreglo2["nombreLote"]=$nombreLote;
        $arreglo2["comentario"]=$comentario;
        $arreglo2["usuario"]=$this->session->userdata('id_usuario');
        $arreglo2["perfil"]=$this->session->userdata('id_rol');
        $arreglo2["modificado"]=date("Y-m-d H:i:s");
        $arreglo2["fechaVenc"]= $fechaVenc;
        $arreglo2["idLote"]= $idLote;
        $arreglo2["idCondominio"]= $idCondominio;
        $arreglo2["idCliente"]= $idCliente;
        $validate = $this->Contraloria_model->validateSt5($idLote);

        if($validate == 1){

            if ($this->Contraloria_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){
                $data['message'] = 'OK';
                echo json_encode($data);
            }else{
                $data['message'] = 'ERROR';
                echo json_encode($data);
            }
        }else {
            $data['message'] = 'FALSE';
            echo json_encode($data);
        }
    }

    public function get_sede() {
        echo json_encode($this->Contraloria_model->get_sede()->result_array());
    }

    public function get_tventa() {
        echo json_encode($this->Contraloria_model->get_tventa()->result_array());
    }

    public function editar_registro_loteRechazo_contraloria_proceceso5() {
        $idLote=$this->input->post('idLote');
        $idCondominio=$this->input->post('idCondominio');
        $nombreLote=$this->input->post('nombreLote');
        $idStatusContratacion=$this->input->post('idStatusContratacion');
        $idMovimiento=$this->input->post('idMovimiento');
        $idCliente=$this->input->post('idCliente');
        $comentario=$this->input->post('comentario');
        $perfil=$this->input->post('perfil');
        $modificado=date("Y-m-d H:i:s");

        $valida_tl = $this->Contraloria_model->checkTipoVenta($idLote);

        if($valida_tl[0]['tipo_venta'] == 1){
            $idStaC = 1;
            $idMov = 102;
        }else{
            $idStaC = 1;
            $idMov = 20;
        }

        $arreglo=array();
        $arreglo["idStatusContratacion"]= 1;
        $arreglo["idMovimiento"]=20;
        $arreglo["comentario"]=$comentario;
        $arreglo["usuario"]=$this->session->userdata('id_usuario');
        $arreglo["perfil"]=$this->session->userdata('id_rol');
        $arreglo["modificado"]=date("Y-m-d H:i:s");
        $arreglo["fechaVenc"]= $modificado;


        $arreglo2=array();
        $arreglo2["idStatusContratacion"]=$idStaC;
        $arreglo2["idMovimiento"]=$idMov;
        $arreglo2["nombreLote"]=$nombreLote;
        $arreglo2["comentario"]=$comentario;
        $arreglo2["usuario"]=$this->session->userdata('id_usuario');
        $arreglo2["perfil"]=$this->session->userdata('id_rol');
        $arreglo2["modificado"]=date("Y-m-d H:i:s");
        $arreglo2["fechaVenc"]= $modificado;
        $arreglo2["idLote"]= $idLote;
        $arreglo2["idCondominio"]= $idCondominio;
        $arreglo2["idCliente"]= $idCliente;

//        $datos= $this->Contraloria_model->getCorreoSt($idCliente);
//        $lp = $this->Contraloria_model->get_lp($idLote);
//        $infoCliente = $this->Clientes_model->buscarPorId($idCliente);
//        $correosEntregar = [];
//
//        if(empty($lp)){
//            $correos = array_unique(explode(',', $datos[0]["correos"]));
//        } else {
//            $correos = array_unique(explode(',', $datos[0]["correos"].','.'ejecutivo.mktd@ciudadmaderas.com,cobranza.mktd@ciudadmaderas.com'));
//        }
//
//        foreach($correos as $email)
//        {
//            if (trim($email) == 'gustavo.mancilla@ciudadmaderas.com') {
//                continue;
//            }
//            if (trim($email) == '') {
//                continue;
//            }
//            if (trim($email) == 'diego.perez@ciudadmaderas.com') {
//                array_push($correosEntregar, 'analista.comercial@ciudadmaderas.com');
//                continue;
//            }
//
//            array_push($correosEntregar, $email);
//        }
//
//        // Validación especial por el ticket 58603
//        if (in_array(intval($infoCliente->id_gerente), [1904, 1206, 113])) {
//            array_push($correosEntregar, 'asistente.cdmx13@ciudadmaderas.com');
//        }
//        // Validación especial por el ticket 59123
//        if (intval($infoCliente->id_gerente) === 113) {
//            array_push($correosEntregar, 'asistente.cdmx19@ciudadmaderas.com');
//        }

        $infoLote = (array)$this->Contraloria_model->getNameLote($idLote);

        $encabezados = [
            'nombreResidencial' => 'PROYECTO',
            'nombre' => 'CONDOMINIO',
            'nombreLote' => 'LOTE',
            'motivoRechazo' => 'MOTIVO DE RECHAZO',
            'fechaHora' => 'FECHA/HORA'
        ];

        $contenido[] = array_merge($infoLote, ["motivoRechazo" => $comentario, "fechaHora" => date("Y-m-d H:i:s")]);

        $this->email
            ->initialize()
            ->from('Ciudad Maderas')
            ->to('tester.ti2@ciudadmaderas.com')
            // ->to($correosEntregar)
            ->subject('EXPEDIENTE RECHAZADO-CONTRALORÍA (5. REVISIÓN 100%)')
            ->view($this->load->view('mail/contraloria/editar-registro-lote-rechazo-proceso5', [
                'encabezados' => $encabezados,
                'contenido' => $contenido,
                'comentario' => $comentario
            ], true));

        $this->email->send();

        $validate = $this->Contraloria_model->validateSt5($idLote);


        if($validate == 1){
            if ($this->Contraloria_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){
                $data['message'] = 'OK';
                echo json_encode($data);
            }else{
                $data['message'] = 'ERROR';
                echo json_encode($data);
            }
        }else {
            $data['message'] = 'FALSE';
            echo json_encode($data);
        }
    }

    public function editar_registro_lote_contraloria_proceceso6() {

        $idLote = $this->input->post('idLote');
        $idCondominio = $this->input->post('idCondominio');
        $nombreLote = $this->input->post('nombreLote');
        $idCliente = $this->input->post('idCliente');
        $comentario = $this->input->post('comentario');
        $modificado = date('Y-m-d H:i:s');
        $fechaVenc = $this->input->post('fechaVenc');
        $fechaVenStatus = $this->input->post('fechaVenStatus');
        $charactersNoPermit = array('$',',');
        $totalNeto = $this->input->post('totalNeto');
        $totalNeto = str_replace($charactersNoPermit, '', $totalNeto);

        $arreglo = array();
        $arreglo["idStatusContratacion"] = 6;
        $arreglo["idMovimiento"] = 36;
        $arreglo["comentario"] = $comentario;
        $arreglo["usuario"] = $this->session->userdata('id_usuario');
        $arreglo["perfil"] = $this->session->userdata('id_rol');
        $arreglo["modificado"] = date("Y-m-d H:i:s");
        $arreglo["totalNeto"] = $totalNeto;

        $horaActual = date('H:i:s');
        $horaInicio = date("08:00:00");
        $horaFin = date("16:00:00");
        if ($horaActual > $horaInicio and $horaActual < $horaFin) {
            $fechaAccion = date("Y-m-d H:i:s");
            $hoy_strtotime2 = strtotime($fechaAccion);
            $sig_fecha_dia2 = date('D', $hoy_strtotime2);
            $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
            if ($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
                $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
                $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
                $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
                $sig_fecha_feriado2 == "25-12") {
                $fecha = $fechaAccion;
                $i = 0;
                while ($i <= 2) {
                    $hoy_strtotime = strtotime($fecha);
                    $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                    $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                    $sig_fecha_dia = date('D', $sig_strtotime);
                    $sig_fecha_feriado = date('d-m', $sig_strtotime);
                    if ($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
                        $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                        $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                        $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                        $sig_fecha_feriado == "25-12") {
                    } else {
                        $fecha = $sig_fecha;
                        $i++;
                    }
                    $fecha = $sig_fecha;
                }
                $arreglo["fechaVenc"] = $fecha;
            } else {
                $fecha = $fechaAccion;
                $i = 0;
                while ($i <= 1) {
                    $hoy_strtotime = strtotime($fecha);
                    $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                    $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                    $sig_fecha_dia = date('D', $sig_strtotime);
                    $sig_fecha_feriado = date('d-m', $sig_strtotime);

                    if ($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
                        $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                        $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                        $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                        $sig_fecha_feriado == "25-12") {
                    } else {
                        $fecha = $sig_fecha;
                        $i++;
                    }
                    $fecha = $sig_fecha;
                }
                $arreglo["fechaVenc"] = $fecha;
            }

        }
        elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {

            $fechaAccion = date("Y-m-d H:i:s");
            $hoy_strtotime2 = strtotime($fechaAccion);
            $sig_fecha_dia2 = date('D', $hoy_strtotime2);
            $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);

            if ($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
                $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
                $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
                $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
                $sig_fecha_feriado2 == "25-12") {
                $fecha = $fechaAccion;
                $i = 0;
                while ($i <= 2) {
                    $hoy_strtotime = strtotime($fecha);
                    $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                    $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                    $sig_fecha_dia = date('D', $sig_strtotime);
                    $sig_fecha_feriado = date('d-m', $sig_strtotime);
                    if ($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
                        $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                        $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                        $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                        $sig_fecha_feriado == "25-12") {
                    } else {
                        $fecha = $sig_fecha;
                        $i++;
                    }
                    $fecha = $sig_fecha;
                }
                $arreglo["fechaVenc"] = $fecha;
            } else {
                $fecha = $fechaAccion;
                $i = 0;
                while ($i <= 2) {
                    $hoy_strtotime = strtotime($fecha);
                    $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                    $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                    $sig_fecha_dia = date('D', $sig_strtotime);
                    $sig_fecha_feriado = date('d-m', $sig_strtotime);

                    if ($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
                        $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                        $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                        $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                        $sig_fecha_feriado == "25-12") {
                    } else {
                        $fecha = $sig_fecha;
                        $i++;
                    }
                    $fecha = $sig_fecha;

                }
                $arreglo["fechaVenc"] = $fecha;

            }
        }
        $arreglo2 = array();
        $arreglo2["idStatusContratacion"] = 6;
        $arreglo2["idMovimiento"] = 36;
        $arreglo2["nombreLote"] = $nombreLote;
        $arreglo2["comentario"] = $comentario;
        $arreglo2["usuario"] = $this->session->userdata('id_usuario');
        $arreglo2["perfil"] = $this->session->userdata('id_rol');
        $arreglo2["modificado"] = date("Y-m-d H:i:s");
        $arreglo2["fechaVenc"] = $fechaVenc;
        $arreglo2["idLote"] = $idLote;
        $arreglo2["idCondominio"] = $idCondominio;
        $arreglo2["idCliente"] = $idCliente;
        $ub_jur = $this->Contraloria_model->val_ub($idLote);
        $id_sede_jur = '';
        $assigned_location = $ub_jur[0]['ubicacion'];
        if ($assigned_location == 2) { // EXPEDIENTES QUERÉTARO
            $id_sede_jur = 2;
            $data_asig = $this->Contraloria_model->get_id_asig($assigned_location);
            $id_asig = $data_asig->contador;
            $arreglo["asig_jur"] = $id_asig == 2765 ? 2876 : ($id_asig == 2876 ? 10463 : 2765);
        } else if ($assigned_location == 4) { // EXPEDIENTES CIUDAD DE MÉXICO
            $id_sede_jur = 4;
            $data_asig = $this->Contraloria_model->get_id_asig($assigned_location);
            $id_asig = $data_asig->contador;

            if ($id_asig == 2820)
                $assigned_user = 10437;
            else if ($id_asig == 10437)
                $assigned_user = 11258;
            else if ($id_asig == 11258)
                $assigned_user = 2820;

            $arreglo["asig_jur"] = $assigned_user;

        } else if ($assigned_location == 1) { // EXPEDIENTES SAN LUIS POTOSÍ
            $id_sede_jur = 1;
            $data_asig = $this->Contraloria_model->get_id_asig($assigned_location);
            $id_asig = $data_asig->contador;

            if ($id_asig == 5468)
                $assigned_user = 2764;
            else if ($id_asig == 2764)
                $assigned_user = 5468;

            $arreglo["asig_jur"] = $assigned_user;
        } else if ($assigned_location == 5) { // EXPEDIENTES LEÓN
            $id_sede_jur = 5;
            $data_asig = $this->Contraloria_model->get_id_asig($assigned_location);
            $id_asig = $data_asig->contador;

            if ($id_asig == 6856)
                $assigned_user = 2800;
            else if ($id_asig == 2800)
                $assigned_user = 12047;
            else if ($id_asig == 12047)
                $assigned_user = 6856;

            $arreglo["asig_jur"] = $assigned_user;
        }  else if ($assigned_location == 3) { // EXPEDIENTES MÉRIDA
            $id_sede_jur = 3;
            $data_asig = $this->Contraloria_model->get_id_asig($assigned_location);
            $id_asig = $data_asig->contador;

            if ($id_asig == 11097)
                $assigned_user = 12842;
            else if ($id_asig == 12842)
                $assigned_user = 11097;

            $arreglo["asig_jur"] = $assigned_user;
        }


        $validate = $this->Contraloria_model->validateSt6($idLote);

        if ($validate == 1) {
            //se valida si existe una corrida en el árbol de documentos
            $corrida = $this->Contraloria_model->validaCorrida($idLote);
            if(empty($corrida->expediente)){
                $data['message'] = 'MISSING_CORRIDA';
                echo json_encode($data);
            }else{
                if ($this->Contraloria_model->updateSt($idLote, $arreglo, $arreglo2) == TRUE) {
                    ($assigned_location == 1 || $assigned_location == 2 || $assigned_location == 4 || $assigned_location == 5 || $assigned_location == 3) ? $this->Contraloria_model->update_asig_jur($arreglo["asig_jur"], $id_sede_jur) : '';
                    $data['message'] = 'OK';
                    echo json_encode($data);
                } else {
                    $data['message'] = 'ERROR';
                    echo json_encode($data);
                }
            }

        } else {
            $data['message'] = 'FALSE';
            echo json_encode($data);
        }
    }

    public function editar_registro_loteRechazo_contraloria_proceceso6() {
        $idLote=$this->input->post('idLote');
        $idCondominio=$this->input->post('idCondominio');
        $nombreLote=$this->input->post('nombreLote');
        $idCliente=$this->input->post('idCliente');
        $comentario=$this->input->post('motivoRechazo');
        $perfil=$this->input->post('perfil');
        $modificado=date("Y-m-d H:i:s");

        $valida_tventa = $this->Asesor_model->getTipoVenta($idLote);//se valida el tipo de venta para ver si se va al nuevo status 3 (POSTVENTA)
        if($valida_tventa[0]['tipo_venta'] == 1 ){
            if($valida_tventa[0]['idStatusContratacion'] == 5 || $valida_tventa[0]['idMovimiento']==106){
                $statusContratacion = 1;
                $idMovimiento = 107;
            }else{
                $statusContratacion = 1;
                $idMovimiento = 104;
            }
        }else{
            $statusContratacion = 1;
            $idMovimiento = 63;
        }


        $arreglo=array();
        $arreglo["idStatusContratacion"]= $statusContratacion;
        $arreglo["idMovimiento"]=$idMovimiento;
        $arreglo["comentario"]=$comentario;
        $arreglo["usuario"]=$this->session->userdata('id_usuario');
        $arreglo["perfil"]=$this->session->userdata('id_rol');
        $arreglo["modificado"]=date("Y-m-d H:i:s");
        $arreglo["fechaVenc"]= $modificado;


        $arreglo2=array();
        $arreglo2["idStatusContratacion"]=$statusContratacion;
        $arreglo2["idMovimiento"]=$idMovimiento;
        $arreglo2["nombreLote"]=$nombreLote;
        $arreglo2["comentario"]=$comentario;
        $arreglo2["usuario"]=$this->session->userdata('id_usuario');
        $arreglo2["perfil"]=$this->session->userdata('id_rol');
        $arreglo2["modificado"]=date("Y-m-d H:i:s");
        $arreglo2["fechaVenc"]= $modificado;
        $arreglo2["idLote"]= $idLote;
        $arreglo2["idCondominio"]= $idCondominio;
        $arreglo2["idCliente"]= $idCliente;

        // $datos= $this->Contraloria_model->getCorreoSt($idCliente);
        // $lp = $this->Contraloria_model->get_lp($idLote);
        // $correosEntregar = [];

        // if(empty($lp)){
        //    $correos = array_unique(explode(',', $datos[0]["correos"]));
        // } else {
        //    $correos = array_unique(explode(',', $datos[0]["correos"].','.'ejecutivo.mktd@ciudadmaderas.com,cobranza.mktd@ciudadmaderas.com'));
        // }

        // foreach($correos as $email)
        // {
        // 	if(trim($email) != 'gustavo.mancilla@ciudadmaderas.com'){
        // 		if (trim($email) != ''){
        //            if(trim($email) == 'diego.perez@ciudadmaderas.com'){
        //                array_push($correosEntregar, 'analista.comercial@ciudadmaderas.com');
        //            } else {
        //                array_push($correosEntregar, $email);
        //            }
        // 		}
        // 	}
        // }

        $infoLote = (array)$this->Contraloria_model->getNameLote($idLote);

        $encabezados = [
            'nombreResidencial'   => 'PROYECTO',
            'nombre'              => 'CONDOMINIO',
            'nombreLote'          => 'LOTE',
            'motivoRechazo'       => 'MOTIVO DE RECHAZO',
            'fechaHora'           => 'FECHA/HORA'
        ];

        $contenido[] = array_merge($infoLote, ["motivoRechazo" => $comentario, "fechaHora" => date("Y-m-d H:i:s")]);

        $this->email
            ->initialize()
            ->from('Ciudad Maderas')
            ->to('tester.ti2@ciudadmaderas.com')
            // ->to($correosEntregar)
            ->subject('EXPEDIENTE RECHAZADO-CONTRALORÍA (6. CORRIDA ELABORADA)')
            ->view($this->load->view('mail/contraloria/editar-registro-lote-rechazo-proceso6', [
                'encabezados' => $encabezados,
                'contenido' => $contenido,
                'comentario' => $comentario
            ], true));

        $validate = $this->Contraloria_model->validateSt6($idLote);

        if($validate == 1){
            if ($this->Contraloria_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){
                if($this->email->send()){
                    $data['message_email'] = 'OK';
                }else{
                    $data['message_email'] = $this->email->print_debugger();
                }
                $data['message'] = 'OK';
                echo json_encode($data);
            }else{
                $data['message'] = 'ERROR';
                echo json_encode($data);
            }
        }else {
            $data['message'] = 'FALSE';
            echo json_encode($data);
        }
    }

    public function editar_registro_loteRevision_contraloria_proceceso6() {

        $idLote=$this->input->post('idLote');
        $idCondominio=$this->input->post('idCondominio');
        $nombreLote=$this->input->post('nombreLote');
        $idCliente=$this->input->post('idCliente');
        $comentario=$this->input->post('comentario');
        $modificado=date('Y-m-d H:i:s');
        $fechaVenc=$this->input->post('fechaVenc');
        $charactersNoPermit = array('$', ',');
        $totalNeto = $this->input->post('totalNeto');
        $totalNeto = str_replace($charactersNoPermit, '', $totalNeto);

        $arreglo=array();
        $arreglo["idStatusContratacion"]=6;
        $arreglo["idMovimiento"]=6;
        $arreglo["comentario"]=$comentario;
        $arreglo["usuario"]=$this->session->userdata('id_usuario');
        $arreglo["perfil"]=$this->session->userdata('id_rol');
        $arreglo["modificado"]=date("Y-m-d H:i:s");
        $arreglo["totalNeto"] = $totalNeto;

        $horaActual = date('H:i:s');
        $horaInicio = date("08:00:00");
        $horaFin = date("16:00:00");

        if ($horaActual > $horaInicio and $horaActual < $horaFin) {
            $fechaAccion = date("Y-m-d H:i:s");
            $hoy_strtotime2 = strtotime($fechaAccion);
            $sig_fecha_dia2 = date('D', $hoy_strtotime2);
            $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);

            if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
                $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
                $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
                $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
                $sig_fecha_feriado2 == "25-12") {

                $fecha = $fechaAccion;
                $i = 0;

                while($i <= 2) {
                    $hoy_strtotime = strtotime($fecha);
                    $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                    $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                    $sig_fecha_dia = date('D', $sig_strtotime);
                    $sig_fecha_feriado = date('d-m', $sig_strtotime);

                    if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
                        $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                        $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                        $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                        $sig_fecha_feriado == "25-12") {}
                    else{
                        $fecha= $sig_fecha;
                        $i++;
                    }
                    $fecha = $sig_fecha;
                }

                $arreglo["fechaVenc"]= $fecha;
            }else{
                $fecha = $fechaAccion;
                $i = 0;
                while($i <= 1) {
                    $hoy_strtotime = strtotime($fecha);
                    $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                    $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                    $sig_fecha_dia = date('D', $sig_strtotime);
                    $sig_fecha_feriado = date('d-m', $sig_strtotime);

                    if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
                        $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                        $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                        $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                        $sig_fecha_feriado == "25-12") {}
                    else{
                        $fecha= $sig_fecha;
                        $i++;
                    }
                    $fecha = $sig_fecha;
                }
                $arreglo["fechaVenc"]= $fecha;
            }

        }elseif($horaActual < $horaInicio || $horaActual > $horaFin){
            $fechaAccion = date("Y-m-d H:i:s");
            $hoy_strtotime2 = strtotime($fechaAccion);
            $sig_fecha_dia2 = date('D', $hoy_strtotime2);
            $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);

            if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
                $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
                $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
                $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
                $sig_fecha_feriado2 == "25-12") {

                $fecha = $fechaAccion;
                $i = 0;

                while($i <= 2) {
                    $hoy_strtotime = strtotime($fecha);
                    $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                    $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                    $sig_fecha_dia = date('D', $sig_strtotime);
                    $sig_fecha_feriado = date('d-m', $sig_strtotime);

                    if($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
                        $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                        $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                        $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                        $sig_fecha_feriado == "25-12") {}
                    else {
                        $fecha= $sig_fecha;
                        $i++;
                    }
                    $fecha = $sig_fecha;
                }
                $arreglo["fechaVenc"]= $fecha;
            }else{
                $fecha = $fechaAccion;

                $i = 0;
                while($i <= 2) {
                    $hoy_strtotime = strtotime($fecha);
                    $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                    $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                    $sig_fecha_dia = date('D', $sig_strtotime);
                    $sig_fecha_feriado = date('d-m', $sig_strtotime);

                    if($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
                        $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                        $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                        $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                        $sig_fecha_feriado == "25-12") {}
                    else {
                        $fecha= $sig_fecha;
                        $i++;
                    }
                    $fecha = $sig_fecha;
                }
                $arreglo["fechaVenc"]= $fecha;
            }
        }

        $arreglo2=array();
        $arreglo2["idStatusContratacion"]=6;
        $arreglo2["idMovimiento"]=6;
        $arreglo2["nombreLote"]=$nombreLote;
        $arreglo2["comentario"]=$comentario;
        $arreglo2["usuario"]=$this->session->userdata('id_usuario');
        $arreglo2["perfil"]=$this->session->userdata('id_rol');
        $arreglo2["modificado"]=date("Y-m-d H:i:s");
        $arreglo2["fechaVenc"]= $fechaVenc;
        $arreglo2["idLote"]= $idLote;
        $arreglo2["idCondominio"]= $idCondominio;
        $arreglo2["idCliente"]= $idCliente;
        $validate = $this->Contraloria_model->validateSt6($idLote);
        if($validate == 1){
            if ($this->Contraloria_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){
                $data['message'] = 'OK';
                echo json_encode($data);
            }else{
                $data['message'] = 'ERROR';
                echo json_encode($data);
            }
        }else{
            $data['message'] = 'FALSE';
            echo json_encode($data);
        }
    }

    public function editar_registro_loteRevision_contraloria5_Acontraloria6() {

        $idLote=$this->input->post('idLote');
        $idCondominio=$this->input->post('idCondominio');
        $nombreLote=$this->input->post('nombreLote');
        $idCliente=$this->input->post('idCliente');
        $comentario=$this->input->post('comentario');
        $modificado=date('Y-m-d H:i:s');
        $fechaVenc=$this->input->post('fechaVenc');

        $arreglo=array();
        $arreglo["idStatusContratacion"]=5;
        $arreglo["idMovimiento"]=75;
        $arreglo["comentario"]=$comentario;
        $arreglo["usuario"]=$this->session->userdata('id_usuario');
        $arreglo["perfil"]=$this->session->userdata('id_rol');
        $arreglo["modificado"]=date("Y-m-d H:i:s");

        $arreglo2=array();
        $arreglo2["idStatusContratacion"]=5;
        $arreglo2["idMovimiento"]=75;
        $arreglo2["nombreLote"]=$nombreLote;
        $arreglo2["comentario"]=$comentario;
        $arreglo2["usuario"]=$this->session->userdata('id_usuario');
        $arreglo2["perfil"]=$this->session->userdata('id_rol');
        $arreglo2["modificado"]=date("Y-m-d H:i:s");
        $arreglo2["fechaVenc"]= $modificado;
        $arreglo2["idLote"]= $idLote;
        $arreglo2["idCondominio"]= $idCondominio;
        $arreglo2["idCliente"]= $idCliente;

        $validate = $this->Contraloria_model->validateSt5($idLote);

        if($validate == 1){
            if ($this->Contraloria_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){
                $data['message'] = 'OK';
                echo json_encode($data);
            }else{
                $data['message'] = 'ERROR';
                echo json_encode($data);
            }
        }else {
            $data['message'] = 'FALSE';
            echo json_encode($data);
        }
    }

    public function editar_registro_loteRechazo_contraloria_proceceso5_2() {
        //phpmailer_lib
        $idLote=$this->input->post('idLote');
        $idCondominio=$this->input->post('idCondominio');
        $nombreLote=$this->input->post('nombreLote');
        $idCliente=$this->input->post('idCliente');
        $comentario=$this->input->post('comentario');
        $modificado=date('Y-m-d H:i:s');

        $arreglo=array();
        $arreglo["idStatusContratacion"]= 1;
        $arreglo["idMovimiento"]=92;
        $arreglo["comentario"]=$comentario;
        $arreglo["usuario"]=$this->session->userdata('id_usuario');
        $arreglo["perfil"]=$this->session->userdata('id_rol');
        $arreglo["modificado"]=date("Y-m-d H:i:s");

        $arreglo2=array();
        $arreglo2["idStatusContratacion"]=1;
        $arreglo2["idMovimiento"]=92;
        $arreglo2["nombreLote"]=$nombreLote;
        $arreglo2["comentario"]=$comentario;
        $arreglo2["usuario"]=$this->session->userdata('id_usuario');
        $arreglo2["perfil"]=$this->session->userdata('id_rol');
        $arreglo2["modificado"]=date("Y-m-d H:i:s");
        $arreglo2["fechaVenc"]= $modificado;
        $arreglo2["idLote"]= $idLote;
        $arreglo2["idCondominio"]= $idCondominio;
        $arreglo2["idCliente"]= $idCliente;

//        $datos= $this->Contraloria_model->getCorreoSt($idCliente);
//        $lp = $this->Contraloria_model->get_lp($idLote);
//        $infoCliente = $this->Clientes_model->buscarPorId($idCliente);
//        $correosEntregar = [];
//
//        if(empty($lp)){
//            $correos = array_unique(explode(',', $datos[0]["correos"]));
//        } else {
//            $correos = array_unique(explode(',', $datos[0]["correos"].','.'ejecutivo.mktd@ciudadmaderas.com,cobranza.mktd@ciudadmaderas.com'));
//        }
//
//        foreach($correos as $email)
//        {
//            if (trim($email) == 'gustavo.mancilla@ciudadmaderas.com') {
//                continue;
//            }
//            if (trim($email) == '') {
//                continue;
//            }
//            if (trim($email) == 'diego.perez@ciudadmaderas.com') {
//                array_push($correosEntregar, 'analista.comercial@ciudadmaderas.com');
//                continue;
//            }
//
//            array_push($correosEntregar, $email);
//        }
//
//        // Validación especial por el ticket 58603
//        if (in_array(intval($infoCliente->id_gerente), [1904, 1206, 113])) {
//            array_push($correosEntregar, 'asistente.cdmx13@ciudadmaderas.com');
//        }
//        // Validación especial por el ticket 59123
//        if (intval($infoCliente->id_gerente) === 113) {
//            array_push($correosEntregar, 'asistente.cdmx19@ciudadmaderas.com');
//        }

        $infoLote = (array)$this->Contraloria_model->getNameLote($idLote);

        $encabezados = [
            'nombreResidencial' => 'PROYECTO',
            'nombre'            => 'CONDOMINIO',
            'nombreLote'        => 'LOTE',
            'motivoRechazo'     => 'MOTIVO DE RECHAZO',
            'fechaHora'         => 'FECHA/HORA'
        ];

        $contenido[] = array_merge($infoLote, ["motivoRechazo" => $comentario, "fechaHora" => date("Y-m-d H:i:s")]);

        $this->email
            ->initialize()
            ->from('Ciudad Maderas')
            ->to('tester.ti2@ciudadmaderas.com')
            // ->to($correosEntregar)
            ->subject('EXPEDIENTE RECHAZADO-CONTRALORÍA (5. REVISIÓN 100%)')
            ->view($this->load->view('mail/contraloria/editar-registro-lote-rechazo-proceso5-2', [
                'encabezados' => $encabezados,
                'contenido' => $contenido,
                'comentario' => $comentario
            ], true));

        $validate = $this->Contraloria_model->validateSt5($idLote);

        if($validate == 1){
            if ($this->Contraloria_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){
                if($this->email->send()){
                    $data['message_email'] = 'OK';
                }else{
                    $data['message_email'] = $this->email->print_debugger();
                }
                $data['message'] = 'OK';
                echo json_encode($data);
            }else{
                $data['message'] = 'ERROR';
                echo json_encode($data);
            }
        }else {
            $data['message'] = 'FALSE';
            echo json_encode($data);
        }
    }

    public function editar_registro_loteRevision_contraloria6_AJuridico7() {
        $idLote = $this->input->post('idLote');
        $idCondominio = $this->input->post('idCondominio');
        $nombreLote = $this->input->post('nombreLote');
        $idCliente = $this->input->post('idCliente');
        $comentario = $this->input->post('comentario');
        $modificado = date('Y-m-d H:i:s');
        $fechaVenc = $this->input->post('fechaVenc');
        $charactersNoPermit = array('$', ',');
        $totalNeto = $this->input->post('totalNeto');
        $totalNeto = str_replace($charactersNoPermit, '', $totalNeto);

        $arreglo=array();
        $arreglo["idStatusContratacion"]=6;
        $arreglo["idMovimiento"]=76;
        $arreglo["comentario"]=$comentario;
        $arreglo["usuario"]=$this->session->userdata('id_usuario');
        $arreglo["perfil"]=$this->session->userdata('id_rol');
        $arreglo["modificado"]=date("Y-m-d H:i:s");
        $arreglo["totalNeto"] = $totalNeto;

        $arreglo2=array();
        $arreglo2["idStatusContratacion"]=6;
        $arreglo2["idMovimiento"]=76;
        $arreglo2["nombreLote"]=$nombreLote;
        $arreglo2["comentario"]=$comentario;
        $arreglo2["usuario"]=$this->session->userdata('id_usuario');
        $arreglo2["perfil"]=$this->session->userdata('id_rol');
        $arreglo2["modificado"]=date("Y-m-d H:i:s");
        $arreglo2["fechaVenc"]= $modificado;
        $arreglo2["idLote"]= $idLote;
        $arreglo2["idCondominio"]= $idCondominio;
        $arreglo2["idCliente"]= $idCliente;

        $validate = $this->Contraloria_model->validateSt6($idLote);
        if($validate == 1){
            if ($this->Contraloria_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){
                $data['message'] = 'OK';
                echo json_encode($data);
            }else{
                $data['message'] = 'ERROR';
                echo json_encode($data);
            }
        }else {
            $data['message'] = 'FALSE';
            echo json_encode($data);
        }
    }

    public function editar_registro_lote_contraloria_proceceso9() {
        $idLote=$this->input->post('idLote');
        $idCondominio=$this->input->post('idCondominio');
        $nombreLote=$this->input->post('nombreLote');
        $idCliente=$this->input->post('idCliente');
        $comentario=$this->input->post('comentario');
        $modificado=date("Y-m-d H:i:s");
        $fechaVenc=$this->input->post('fechaVenc');
        $totalNeto2=$this->input->post('totalNeto2');
        $rl = $this->input->post('rl');
        $residencia = $this->input->post('residencia');
        $charactersNoPermit = array('$',',');
        $totalNeto2 = str_replace($charactersNoPermit, '', $totalNeto2);
        $id_usuario = $this->session->userdata('id_usuario');

        $arreglo=array();
        $arreglo["idStatusContratacion"]=9;
        $arreglo["idMovimiento"]=39;
        $arreglo["comentario"]=$comentario;
        $arreglo["usuario"] = $id_usuario;
        $arreglo["perfil"]=$this->session->userdata('id_rol');
        $arreglo["modificado"]=date("Y-m-d H:i:s");
        $arreglo["fechaVenc"]= $modificado;
        $arreglo["totalNeto2"]=$totalNeto2;

        $arreglo2=array();
        $arreglo2["idStatusContratacion"]=9;
        $arreglo2["idMovimiento"]=39;
        $arreglo2["nombreLote"]=$nombreLote;
        $arreglo2["comentario"]=$comentario;
        $arreglo2["usuario"] = $id_usuario;
        $arreglo2["perfil"]=$this->session->userdata('id_rol');
        $arreglo2["modificado"]=date("Y-m-d H:i:s");
        $arreglo2["fechaVenc"]= $fechaVenc;
        $arreglo2["idLote"]= $idLote;
        $arreglo2["idCondominio"]= $idCondominio;
        $arreglo2["idCliente"]= $idCliente;

        $validate = $this->Contraloria_model->validateSt9($idLote);

        $this->Contraloria_model->validate90Dias($idLote,$idCliente,$this->session->userdata('id_usuario'));

        if($validate == 1){
            if ($this->Contraloria_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){
                $this->db->query("UPDATE clientes SET rl = $rl, tipo_nc = $residencia, modificado_por = $id_usuario WHERE idLote = $idLote AND status = 1");
                $data['message'] = 'OK';
                echo json_encode($data);
            }else{
                $data['message'] = 'ERROR';
                echo json_encode($data);
            }
        }else {
            $data['message'] = 'FALSE';
            echo json_encode($data);
        }
    }

    public function editar_registro_loteRechazo_contraloria_proceceso9() {
        $idLote=$this->input->post('idLote');
        $idCondominio=$this->input->post('idCondominio');
        $nombreLote=$this->input->post('nombreLote');
        $idCliente=$this->input->post('idCliente');
        $comentario=$this->input->post('comentario');
        $modificado=date("Y-m-d H:i:s");

        $arreglo=array();
        $arreglo["idStatusContratacion"]= 7;
        $arreglo["idMovimiento"]=64;
        $arreglo["comentario"]=$comentario;
        $arreglo["usuario"]=$this->session->userdata('id_usuario');
        $arreglo["perfil"]=$this->session->userdata('id_rol');
        $arreglo["modificado"]=date("Y-m-d H:i:s");
        $arreglo["status8Flag"]=0;

        $arreglo2=array();
        $arreglo2["idStatusContratacion"]=7;
        $arreglo2["idMovimiento"]=64;
        $arreglo2["nombreLote"]=$nombreLote;
        $arreglo2["comentario"]=$comentario;
        $arreglo2["usuario"]=$this->session->userdata('id_usuario');
        $arreglo2["perfil"]=$this->session->userdata('id_rol');
        $arreglo2["modificado"]=date("Y-m-d H:i:s");
        $arreglo2["fechaVenc"]= $modificado;
        $arreglo2["idLote"]= $idLote;
        $arreglo2["idCondominio"]= $idCondominio;
        $arreglo2["idCliente"]= $idCliente;

        $validate = $this->Contraloria_model->validateSt9($idLote);

        if($validate == 1){
            if ($this->Contraloria_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){
                $data['message'] = 'OK';
                echo json_encode($data);
            }else{
                $data['message'] = 'ERROR';
                echo json_encode($data);
            }
        }else {
            $data['message'] = 'FALSE';
            echo json_encode($data);
        }
    }

    public function registro_lote_contraloria_proceceso10() {
        $folio = array();
        $folio["variable"] = $this->Contraloria_model->findCount();

        if ($folio <> NULL) {
            foreach ($folio as $folioUpd) {
                $folioUp = array();
                $folioUp["contador"] = $folioUpd->contador + 1;

                if ($_POST <> NULL) {
                    $misDatosJSON = json_decode($_POST['datos']);

                    $f = 0;
                    $a = 0;

                    foreach ($misDatosJSON as list($b)) {

                        $info = array();
                        $info["lotes"] = $this->Contraloria_model->selectRegistroPorContrato($b);

                        if ($info["lotes"] <> NULL) {

                            foreach ($info as $fila) {

                                $updateStatus10 = array();
                                $updateStatus10["idStatusContratacion"] = 10;
                                $updateStatus10["idMovimiento"] = 40;
                                $updateStatus10["comentario"] = "Solicitud de validación de enganche y envio de contrato a RL";
                                $updateStatus10["usuario"] = $this->session->userdata('id_usuario');
                                $updateStatus10["perfil"] = $this->session->userdata('id_rol');
                                $updateStatus10["modificado"] = date("Y-m-d H:i:s");
                                $updateStatus10["fechaRL"] = date('Y-m-d H:i:s');


                                $histStatus10 = array();
                                $histStatus10["idStatusContratacion"] = 10;
                                $histStatus10["idMovimiento"] = 40;
                                $histStatus10["nombreLote"] = $fila->nombreLote;
                                $histStatus10["comentario"] = "Solicitud de validación de enganche y envio de contrato a RL";
                                $histStatus10["usuario"] = $this->session->userdata('id_usuario');
                                $histStatus10["perfil"] = $this->session->userdata('id_rol');
                                $histStatus10["modificado"] = date("Y-m-d H:i:s");
                                $histStatus10["fechaVenc"] = $fila->fechaVenc;
                                $histStatus10["idLote"] = $fila->idLote;
                                $histStatus10["idCondominio"] = $fila->idCondominio;
                                $histStatus10["idCliente"] = $fila->id_cliente;
                                $histStatus10["folioContrato"] = $folioUpd->contador + 1;


                                $arrayAacuse = array();
                                $arrayAacuse["primerNombre"] = $fila->nombre;
                                $arrayAacuse["apellidoPaterno"] = $fila->apellido_paterno;
                                $arrayAacuse["apellidoMaterno"] = $fila->apellido_materno;
                                $arrayAacuse["razonSocial"] = $fila->rfc;
                                $arrayAacuse["code"] = $b;
                                $arrayAacuse["mod"] = date("Y-m-d H:i:s");
                                $arrayAacuse["contratoUrgente"] = $fila->contratoUrgente;
                                $dato3 = array();
                                $dato3["numContrato"] = $b;
                                $dato3["fechaRecepcion"] = date('Y-m-d H:i:s');


                                if ($this->Contraloria_model->updateSt10($b,$updateStatus10,$histStatus10,$dato3,1, $folioUp) == TRUE) {
                                    $a = $a+1;
                                } else {
                                    $a;
                                }
                                $acuse = array();
                                $i = 0;
                                foreach ($arrayAacuse as $nombre) {
                                    $acuse[] = $nombre;
                                    $i++;
                                }
                            }
                        } else {
                            $f = $f+1;
                        }
                    }

                    if($f >= 1){
                        $data['message'] = 'NODETECTED';
                        echo json_encode($data);
                    } else {

                        if($a >= 1){
                            $data['message'] = 'OK';
                            echo json_encode($data);
                        } else {
                            $data['message'] = 'ERROR';
                            echo json_encode($data);
                        }

                    }

                } else {
                    $data['message'] = 'VOID';
                    echo json_encode($data);
                }
            }
        }
    }

    public function editar_registro_lote_contraloria_proceceso13() {
        $idLote=$this->input->post('idLote');
        $idCondominio=$this->input->post('idCondominio');
        $nombreLote=$this->input->post('nombreLote');
        $idCliente=$this->input->post('idCliente');
        $comentario=$this->input->post('comentario');
        $modificado=date('Y-m-d H:i:s');
        $fechaVenc=$this->input->post('fechaVenc');

        $arreglo=array();
        $arreglo["idStatusContratacion"]=13;
        $arreglo["idMovimiento"]=43;
        $arreglo["comentario"]=$comentario;
        $arreglo["usuario"]=$this->session->userdata('id_usuario');
        $arreglo["perfil"]=$this->session->userdata('id_rol');
        $arreglo["modificado"]=date("Y-m-d H:i:s");

        $horaActual = date('H:i:s');
        $horaInicio = date("08:00:00");
        $horaFin = date("16:00:00");

        if ($horaActual > $horaInicio and $horaActual < $horaFin) {

            $fechaAccion = date("Y-m-d H:i:s");
            $hoy_strtotime2 = strtotime($fechaAccion);
            $sig_fecha_dia2 = date('D', $hoy_strtotime2);
            $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);

            if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
                $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
                $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
                $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
                $sig_fecha_feriado2 == "25-12") {

                $fecha = $fechaAccion;
                $i = 0;
                while($i <= 6) {
                    $hoy_strtotime = strtotime($fecha);
                    $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                    $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                    $sig_fecha_dia = date('D', $sig_strtotime);
                    $sig_fecha_feriado = date('d-m', $sig_strtotime);

                    if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
                        $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                        $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                        $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                        $sig_fecha_feriado == "25-12") {
                    }
                    else {
                        $fecha= $sig_fecha;
                        $i++;
                    }
                    $fecha = $sig_fecha;
                }
                $arreglo["fechaVenc"]= $fecha;
            }else{
                $fecha = $fechaAccion;
                $i = 0;
                while($i <= 5) {
                    $hoy_strtotime = strtotime($fecha);
                    $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                    $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                    $sig_fecha_dia = date('D', $sig_strtotime);
                    $sig_fecha_feriado = date('d-m', $sig_strtotime);

                    if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
                        $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                        $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                        $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                        $sig_fecha_feriado == "25-12") {
                    }
                    else {
                        $fecha= $sig_fecha;
                        $i++;
                    }
                    $fecha = $sig_fecha;
                }
                $arreglo["fechaVenc"]= $fecha;
            }

        } elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {

            $fechaAccion = date("Y-m-d H:i:s");
            $hoy_strtotime2 = strtotime($fechaAccion);
            $sig_fecha_dia2 = date('D', $hoy_strtotime2);
            $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);

            if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
                $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
                $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
                $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
                $sig_fecha_feriado2 == "25-12") {

                $fecha = $fechaAccion;
                $i = 0;
                while($i <= 6) {
                    $hoy_strtotime = strtotime($fecha);
                    $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                    $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                    $sig_fecha_dia = date('D', $sig_strtotime);
                    $sig_fecha_feriado = date('d-m', $sig_strtotime);

                    if($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
                        $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                        $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                        $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                        $sig_fecha_feriado == "25-12") {
                    }
                    else {
                        $fecha= $sig_fecha;
                        $i++;
                    }
                    $fecha = $sig_fecha;
                }
                $arreglo["fechaVenc"]= $fecha;

            }else{

                $fecha = $fechaAccion;

                $i = 0;
                while($i <= 6) {
                    $hoy_strtotime = strtotime($fecha);
                    $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                    $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                    $sig_fecha_dia = date('D', $sig_strtotime);
                    $sig_fecha_feriado = date('d-m', $sig_strtotime);

                    if($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
                        $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                        $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                        $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                        $sig_fecha_feriado == "25-12") {
                    }
                    else {
                        $fecha= $sig_fecha;
                        $i++;
                    }
                    $fecha = $sig_fecha;
                }
                $arreglo["fechaVenc"]= $fecha;
            }

        }


        $arreglo2=array();
        $arreglo2["idStatusContratacion"]=13;
        $arreglo2["idMovimiento"]=43;
        $arreglo2["nombreLote"]=$nombreLote;
        $arreglo2["comentario"]=$comentario;
        $arreglo2["usuario"]=$this->session->userdata('id_usuario');
        $arreglo2["perfil"]=$this->session->userdata('id_rol');
        $arreglo2["modificado"]=date("Y-m-d H:i:s");
        $arreglo2["fechaVenc"]= $fechaVenc;
        $arreglo2["idLote"]= $idLote;
        $arreglo2["idCondominio"]= $idCondominio;
        $arreglo2["idCliente"]= $idCliente;

        $validate = $this->Contraloria_model->validateSt13($idLote);

        if($validate == 1){
            if ($this->Contraloria_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){
                $data['message'] = 'OK';
                echo json_encode($data);
            }else{
                $data['message'] = 'ERROR';
                echo json_encode($data);
            }
        }else {
            $data['message'] = 'FALSE';
            echo json_encode($data);
        }
    }

    public function editar_registro_lote_contraloria_proceceso15() {
        $idLote=$this->input->post('idLote');
        $idCondominio=$this->input->post('idCondominio');
        $nombreLote=$this->input->post('nombreLote');
        $idCliente=$this->input->post('idCliente');
        $comentario=$this->input->post('comentario');
        $modificado=date('Y-m-d H:i:s');
        $fechaVenc=$this->input->post('fechaVenc');

        $arreglo=array();
        $arreglo["idStatusContratacion"]=15;
        $arreglo["idMovimiento"]=45;
        $arreglo["comentario"]=$comentario;
        $arreglo["idStatusLote"]=2;
        $arreglo["usuario"]=$this->session->userdata('id_usuario');
        $arreglo["perfil"]=$this->session->userdata('id_rol');
        $arreglo["modificado"]=date("Y-m-d H:i:s");
        $arreglo["fechaVenc"]= $modificado;


        $arreglo2=array();
        $arreglo2["idStatusContratacion"]=15;
        $arreglo2["idMovimiento"]=45;
        $arreglo2["nombreLote"]=$nombreLote;
        $arreglo2["comentario"]=$comentario;
        $arreglo2["usuario"]=$this->session->userdata('id_usuario');
        $arreglo2["perfil"]=$this->session->userdata('id_rol');
        $arreglo2["modificado"]=date("Y-m-d H:i:s");
        $arreglo2["fechaVenc"]= $fechaVenc;
        $arreglo2["idLote"]= $idLote;
        $arreglo2["idCondominio"]= $idCondominio;
        $arreglo2["idCliente"]= $idCliente;


        $validate = $this->Contraloria_model->validateSt15($idLote);
        if($validate == 1){
            if ($this->Contraloria_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){

                $insertToData = array(
                    "movimiento" => 'CONTRATO FIRMADO',
                    "expediente" => '',
                    "modificado" => date('Y-m-d H:i:s'),
                    "status" => 1,
                    "idCliente" => $idCliente,
                    "idCondominio" => $idCondominio,
                    "idLote" => $idLote,
                    "idUser" => $this->session->userdata('id_usuario'),
                    "tipo_documento" => 0,
                    "id_autorizacion" => 0,
                    "tipo_doc" => 30,
                    "estatus_validacion" =>0
                );
                $this->General_model->addRecord('historial_documento', $insertToData);

                $data['message'] = 'OK';
                echo json_encode($data);
            }else{
                $data['message'] = 'ERROR';
                echo json_encode($data);
            }
        }else {
            $data['message'] = 'FALSE';
            echo json_encode($data);
        }
    }

    public function editar_registro_loteRechazo_contraloria_proceceso15() {
        $idLote=$this->input->post('idLote');
        $idCondominio=$this->input->post('idCondominio');
        $nombreLote=$this->input->post('nombreLote');
        $idCliente=$this->input->post('idCliente');
        $comentario=$this->input->post('comentario');
        $modificado=date("Y-m-d H:i:s");

        $arreglo=array();
        $arreglo["idStatusContratacion"]= 13;
        $arreglo["idMovimiento"]=68;
        $arreglo["comentario"]=$comentario;
        $arreglo["usuario"]=$this->session->userdata('id_usuario');
        $arreglo["perfil"]=$this->session->userdata('id_rol');
        $arreglo["modificado"]=date("Y-m-d H:i:s");
        $arreglo["fechaVenc"]=date("Y-m-d H:i:s");

        $arreglo2=array();
        $arreglo2["idStatusContratacion"]=13;
        $arreglo2["idMovimiento"]=68;
        $arreglo2["nombreLote"]=$nombreLote;
        $arreglo2["comentario"]=$comentario;
        $arreglo2["usuario"]=$this->session->userdata('id_usuario');
        $arreglo2["perfil"]=$this->session->userdata('id_rol');
        $arreglo2["modificado"]=date("Y-m-d H:i:s");
        $arreglo2["fechaVenc"]= $modificado;
        $arreglo2["idLote"]= $idLote;
        $arreglo2["idCondominio"]= $idCondominio;
        $arreglo2["idCliente"]= $idCliente;

        $validate = $this->Contraloria_model->validateSt15($idLote);
        if($validate == 1){
            if ($this->Contraloria_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){
                $data['message'] = 'OK';
                echo json_encode($data);
            }else{
                $data['message'] = 'ERROR';
                echo json_encode($data);
            }
        }else {
            $data['message'] = 'FALSE';
            echo json_encode($data);
        }
    }

    public function liberacion_contraloria() {
        $this->load->view('template/header');
        $datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
        $this->load->view("contraloria/vista_liberacion_contraloria", $datos);
    }

    public function app_lib() {
        $res =  $this->Contraloria_model->aplicaLiberaciones($this->input->post('idResidencial'));
        if($res == true){
            $data['message'] = 'OK';
            echo json_encode($data);
        }else {
            $data['message'] = 'FALSE';
            echo json_encode($data);
        }
    }

    public function return1() {
        $idLote=$this->input->post('idLote');
        $idCondominio=$this->input->post('idCondominio');
        $nombreLote=$this->input->post('nombreLote');
        $idCliente=$this->input->post('idCliente');
        $comentario=$this->input->post('comentario');
        $modificado=date('Y-m-d H:i:s');
        $fechaVenc=$this->input->post('fechaVenc');
        $charactersNoPermit = array('$', ',');
        $totalNeto = $this->input->post('totalNeto');
        $totalNeto = str_replace($charactersNoPermit, '', $totalNeto);

        $arreglo=array();
        $arreglo["idStatusContratacion"]=6;
        $arreglo["idMovimiento"]=95;
        $arreglo["comentario"]=$comentario;
        $arreglo["usuario"]=$this->session->userdata('id_usuario');
        $arreglo["perfil"]=$this->session->userdata('id_rol');
        $arreglo["modificado"]=date("Y-m-d H:i:s");
        $arreglo["totalNeto"] = $totalNeto;

        $arreglo2=array();
        $arreglo2["idStatusContratacion"]=6;
        $arreglo2["idMovimiento"]=95;
        $arreglo2["nombreLote"]=$nombreLote;
        $arreglo2["comentario"]=$comentario;
        $arreglo2["usuario"]=$this->session->userdata('id_usuario');
        $arreglo2["perfil"]=$this->session->userdata('id_rol');
        $arreglo2["modificado"]=date("Y-m-d H:i:s");
        $arreglo2["fechaVenc"]= $modificado;
        $arreglo2["idLote"]= $idLote;
        $arreglo2["idCondominio"]= $idCondominio;
        $arreglo2["idCliente"]= $idCliente;

        $validate = $this->Contraloria_model->validateSt6($idLote);
        if($validate == 1){
            if ($this->Contraloria_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){
                $data['message'] = 'OK';
                echo json_encode($data);
            }else{
                $data['message'] = 'ERROR';
                echo json_encode($data);
            }
        }else {
            $data['message'] = 'FALSE';
            echo json_encode($data);
        }
    }

    public function changeUb() {
        $idLote=$this->input->post('idLote');
        $ubicacion=$this->input->post('ubicacion');
        $validate = $this->Contraloria_model->update_sede($idLote, $ubicacion);
        if ($validate == TRUE){
            $data['message'] = 'OK';
            echo json_encode($data);
        }else{
            $data['message'] = 'ERROR';
            echo json_encode($data);
        }
    }


    public function inventario_c() {
        $this->validateSession();
        $datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
        $this->load->view('template/header');
        $this->load->view("contraloria/datos_lote_contratacion_c_view", $datos);
    }

    public function msni() {
        $this->validateSession();
        $datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
        $this->load->view('template/header');
        $this->load->view("contraloria/meses_sin_intereses", $datos);
    }

    public function msni_2() {
        $this->validateSession();
        $datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
        $this->load->view('template/header');
        $this->load->view("contraloria/vista_msni", $datos);
    }

    public function getMsni($typeTransaction, $key){
        $msni = $this->Contraloria_model->getMsni($typeTransaction, $key);
        if ($msni != NULL){
            echo json_encode($msni);
        }else{
            echo json_encode();
        }
    }

    public function update_msni(){
        $typeTranscation = $this->input->post('typeTransaction');
        $arrayMsi = json_decode($this->input->post('file_msni'));
        $idResidencial = $this->input->post('idResidencial');
        $idCondominio = $this->input->post('idCondominio');

        //si es tipo de transaccion es = a 1
        //quiere decir que la actualizacion es por condominios
        //si es 0: quiere decir que es por los lotes subidos
        //echo 'lotes a actualizar<br>';


        $array_update = array();
        $array_diferentes = array();
        $valorRepetidomveces = array();
        switch ($typeTranscation){
            case 1://condominios
                $longitud_array = count($arrayMsi);
                $flag = 1;
                $fecha_insercion = date('Y-m-d H:i:s');
                foreach ($arrayMsi as $index => $result){
                    $insert_aut = array(
                        "idResidencial" => $idResidencial, //NO ACEPTA NULOS
                        "idCondominio" => $result->ID, //NO ACEPTA NULOS
                        "lote" => null,
                        "msi" => $result->MSNI,
                        "comentario" => 'SE SUBE AUTORIZACIÓN',
                        "estatus_autorizacion" => 1,
                        "estatus" => 1,
                        "fecha_creacion" => $fecha_insercion,
                        "creado_por" => $this->session->userdata('id_usuario'),
                        "fecha_modificacion" => $fecha_insercion,
                        "modificado_por" => $this->session->userdata('id_usuario')
                    );
                    $resultado = $this->General_model->addRecord('autorizaciones_msi', $insert_aut);

                    //se inserta en el historial
                    $last_id = $this->db->insert_id(); //ultimo ID insertado //
                    $insert_ha = array(
                        'idAutorizacion' => $last_id,
                        'tipo' => 2, //tipo de historial es hacia MSI en la tabla de opcs_x_cats cuando el catalogo=91
                        'id_usuario' => $this->session->userdata('id_usuario'),
                        'fecha_movimiento' => $fecha_insercion,
                        'estatus' => 1,
                        'comentario' => 'SE SUBE AUTORIZACIÓN',
                        'estatus_autorizacion' => 1
                    );
                    $resultado_historial = $this->General_model->addRecord('historial_autorizacionesPMSI', $insert_ha);
                    $flag++;

                    if(($resultado && $resultado_historial) && $flag == $longitud_array){
                        $data['message'] = 'OK';
                        echo json_encode($data);
                    }
                }

                break;
            case 0: //lotes
                $array_msi = array();

                foreach ($arrayMsi as $index => $result){
                    $array_msi[$index]=$arrayMsi[$index]->MSNI;
                }


                $countedValues = array_count_values($array_msi);
                $valorRepetidomveces = array_search(max($countedValues), $countedValues);

                //sacar los valores distintos
                $fecha_insercion = date('Y-m-d H:i:s');
                foreach ($arrayMsi as $index => $result){
                    if($arrayMsi[$index]->MSNI != $valorRepetidomveces){
                        array_push($array_diferentes, $arrayMsi[$index]);
                    }
                }

                $array_diferentes = json_encode($array_diferentes, JSON_UNESCAPED_SLASHES);
                $condominioValue = ($typeTranscation == 1) ? '' : '';


                $insert_aut = array(
                    //id_autorizacion: AUTO_INCREMENT
                    "idResidencial" => $idResidencial, //NO ACEPTA NULOS
                    "idCondominio" => $idCondominio, //NO ACEPTA NULOS
                    "lote" => $array_diferentes,
                    "msi" => $valorRepetidomveces,
                    "comentario" => 'SE SUBE AUTORIZACIÓN',
                    "estatus_autorizacion" => 1,
                    "estatus" => 1,
                    "fecha_creacion" => $fecha_insercion,
                    "creado_por" => $this->session->userdata('id_usuario'),
                    "fecha_modificacion" => $fecha_insercion,
                    "modificado_por" => $this->session->userdata('id_usuario')
                );
                $resultado = $this->General_model->addRecord('autorizaciones_msi', $insert_aut);

                //se inserta en el historial
                $last_id = $this->db->insert_id(); //ultimo ID insertado
                $insert_ha = array(
                    'idAutorizacion' => $last_id,
                    'tipo' => 2, //tipo de historial es hacia MSI en la tabla de opcs_x_cats cuando el catalogo=91
                    'id_usuario' => $this->session->userdata('id_usuario'),
                    'fecha_movimiento' => $fecha_insercion,
                    'estatus' => 1,
                    'comentario' => 'SE SUBE AUTORIZACIÓN',
                    'estatus_autorizacion' => 1
                );
                $resultado_historial = $this->General_model->addRecord('historial_autorizacionesPMSI', $insert_ha);


                if($resultado && $resultado_historial){
                    $data['message'] = 'OK';
                }else{
                    $data['message'] = 'ERROR';
                }
                echo json_encode($data);

                break;
        }
        exit;
    }

    public function generalClientsReport() {
        $this->load->view('template/header');
        $this->load->view("contraloria/general_clients_report");
    }

    public function getGeneralClientsReport(){
        $data['data'] = $this->Contraloria_model->getGeneralClientsReport()->result_array();
        echo json_encode($data);
    }

    public function returnToStatusFourteen() {
        $this->load->view('template/header');
        $this->load->view("contraloria/returnToStatusFourteen");
    }

    function getClientsInStatusFifteen($idCondominio) {
        $data['data'] = $this->Contraloria_model->getClientsInStatusFifteen($idCondominio)->result_array();
        echo json_encode($data);
    }

    function getInfoReturnStatus15() {
        $idLote = $this->input->post("idLote");
        $datos = $this->Contraloria_model->selectRegistroLoteCaja($idLote);
        echo json_encode($datos);
    }

    function updateReturnStatus15() {
        if (isset($_POST) && !empty($_POST)) {
            $idLote = $this->input->post('idLote');
            $idCondominio = $this->input->post('idCondominio');
            $nombreLote = $this->input->post('nombreLote');
            $idCliente = $this->input->post('idCliente');
            $comentario = $this->input->post('comentario');
            $arreglo = array();
            $arreglo["idStatusContratacion"] = 14;
            $arreglo["idMovimiento"] = 80;
            $arreglo["comentario"] = $comentario;
            $arreglo["usuario"] = $this->session->userdata('id_usuario');
            $arreglo["perfil"] = $this->session->userdata('id_rol');
            $arreglo["idStatusLote"] = 3;
            $arreglo["modificado"] = date("Y-m-d H:i:s");
            $arreglo["fechaVenc"] = date("Y-m-d H:i:s");
            $arreglo2 = array();
            $arreglo2["idStatusContratacion"] = 14;
            $arreglo2["idMovimiento"] = 80;
            $arreglo2["comentario"] = $comentario;
            $arreglo2["usuario"] = $this->session->userdata('id_usuario');
            $arreglo2["perfil"] = $this->session->userdata('id_rol');
            $arreglo2["modificado"] = date("Y-m-d H:i:s");
            $arreglo2["fechaVenc"] = date("Y-m-d H:i:s");
            $arreglo2["idLote"] = $idLote;
            $arreglo2["nombreLote"] = $nombreLote;
            $arreglo2["idCondominio"] = $idCondominio;
            $arreglo2["idCliente"] = $idCliente;
            if ($this->Contraloria_model->editaRegistroLoteCaja($idLote, $arreglo)) {
                $this->Contraloria_model->insertHistorialLotes($arreglo2);
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        }
    }

    function getLotesAllAssistant($condominio) {
        $data = $this->Contraloria_model->getLotesAllAssistant($condominio);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function depositoSeriedadAssistant() {
        $this->validateSession();
        $datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
        $this->load->view('template/header');
        $this->load->view("contraloria/ds_assistant",$datos);
    }

    public function expedienteAssistant(){
        $this->load->view('template/header');
        $datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
        $this->load->view("contraloria/vista_expediente_assistant", $datos);
    }

    function getLotesAllTwo($condominio) {
        $data = $this->Contraloria_model->getLotesTwo($condominio);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function getLiberacionesInformation() {
        if (isset($_POST) && !empty($_POST)) {
            $data['data'] = $this->Contraloria_model->getLiberacionesInformation($this->input->post("idCondominio"))->result_array();
            echo json_encode($data);
        } else {
            json_encode(array());
        }
    }

    public function status9Report() {
        if ($this->session->userdata('id_rol') == FALSE) {
            redirect(base_url());
        }
        $this->load->view('template/header');
        $this->load->view("contraloria/status9Report");
    }

    public function getInformation() {
        if (isset($_POST) && !empty($_POST)) {
            $fechaInicio = explode('/', $this->input->post("beginDate"));
            $fechaFin = explode('/', $this->input->post("endDate"));
            $beginDate = date("Y-m-d", strtotime("{$fechaInicio[2]}-{$fechaInicio[1]}-{$fechaInicio[0]}"));
            $endDate = date("Y-m-d", strtotime("{$fechaFin[2]}-{$fechaFin[1]}-{$fechaFin[0]}"));
            $data['data'] = $this->Contraloria_model->getInformation($beginDate, $endDate)->result_array();
            echo json_encode($data);
        } else {
            json_encode(array());
        }
    }

    public function removeMark() {
        $data = array("observacionContratoUrgente" => NULL, "usuario" => $this->session->userdata('id_usuario'));
        $adata = array("id_parametro" => $this->input->post("idLote"), "tipo" => "update", "anterior" => 1, "nuevo" => "", "col_afect" => "observacionContratoUrgente", "tabla" => "lotes", "creado_por" => $this->session->userdata('id_usuario'));
        $this->Contraloria_model->addRecord("auditoria", $adata); // MJ: LLEVA 2 PARÁMETROS $table, $data
        $response = $this->Contraloria_model->updateRecord("lotes", $data, "idLote", $this->input->post("idLote")); // MJ: LLEVA 4 PARÁMETROS $table, $data, $key, $value
        echo json_encode($response);
    }

    public function updateLotesStatusLiberacion() {
        for ($i = 0; $i < count($this->input->post("idLote")); $i++) {
            $updateArrayData[] = array(
                'idLote' => $_POST['idLote'][$i],
                'observacionContratoUrgente' => 1,
                'usuario' => $this->session->userdata('id_usuario')
            );
            $insertArray[$i] = array(
                'id_parametro' => $_POST['idLote'][$i],
                'tipo' => 'update',
                'anterior' => '',
                'nuevo' => '1',
                'col_afect' => 'observacionContratoUrgente',
                'tabla' => 'lotes',
                'creado_por' => $this->session->userdata('id_usuario')
            );
        }
        $response = $this->db->update_batch('lotes', $updateArrayData, 'idLote');
        $this->db->insert_batch('auditoria',$insertArray);
        echo json_encode($response);
    }


    public function setData() {
        $json = json_decode($this->input->post("jsonInfo"));
        $insertArrayData = array();
        $updateArrayData = array();
        $updateArrayData = array();

        for ($i = 0; $i < count($json); $i++) { // MJ: SE ARMAN ARRAYS PARA INSERTAR | ACTUALIZAR SEGÚN SEA EL CASO
            $commonData = array();
            $commonData2 = array();

            $commonData +=  array("idLote" => $json[$i]->ID_LOTE);
            $commonData +=  array("observacionContratoUrgente" => 1);
            $commonData +=  array("usuario" => $this->session->userdata('id_usuario'));


            $commonData2 +=  array("id_parametro" => $json[$i]->ID_LOTE);
            $commonData2 +=  array("tipo" => 'update');
            $commonData2 +=  array("anterior" => '');
            $commonData2 +=  array("nuevo" => 1);
            $commonData2 +=  array("col_afect" => 'observacionContratoUrgente');
            $commonData2 +=  array("tabla" => 'lotes');
            $commonData2 +=  array("creado_por" => $this->session->userdata('id_usuario'));

            array_push($insertArrayData, $commonData2);
            array_push($updateArrayData, $commonData);
        }
        $response = $this->db->update_batch('lotes', $updateArrayData, 'idLote');
        $this->db->insert_batch('auditoria',$insertArrayData);

        echo json_encode($response);
    }

    public function lotes_apartados() {
        $this->validateSession();
        /*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/
        if ($this->session->userdata('id_usuario') == FALSE) {
            redirect(base_url());
        }
        
        switch($this->session->userdata('id_usuario')){
            case '2807': //Mariela Sánchez Sánchez
            case '2826': //Ana Laura García Tovar
            case '2767': //Irene Vallejo
            case '2754': //Gabriela Hernández Tovar
            case '2749': //Ariadna Martínez
            case '1297': //María de Jesús
            case '826': //Victor Hugo
                $this->load->view('template/header');
                $this->load->view("contraloria/vista_lotes_precio_enganche");
                break;
            default:
                echo '<script>alert("ACCESO DENEGADO"); window.location.href="' . base_url() . '";</script>';
                break;
        } 
    }

    /**al día de hoy**/ 
    public function backExp() {
        $this->load->view('template/header');
        $this->load->view("contraloria/checarExpediente");
    }


    public function get_lote_historial($lote) {
        echo json_encode($this->Contraloria_model->get_datos_lotes($lote)->result_array(),JSON_NUMERIC_CHECK);
    }

    public function get_lote_apartado() {
        $idLote = $_GET['idLote'];
        $data = $this->Contraloria_model->get_datos_lotes($idLote)->row();
        if($data != null)
            echo json_encode($data,JSON_NUMERIC_CHECK);
        else
            echo json_encode(array());
    }

    public function lista_lote_apartado($condominio) {
        $residencial = 0;
        $data = $this->registrolote_modelo->getLotesApartado($condominio,$residencial);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function updateLote() {
        $idLote = $_POST['idLote'];
        $data = $this->Contraloria_model->get_datos_lotes($idLote);
        $data = array(
            "totalNeto2" => $this->formatter->removeNumberFormat($_POST['preciodesc']),
            "totalNeto" => $this->formatter->removeNumberFormat($_POST['enganches']),
            "ubicacion" => $this->input->post("ubicacion_sede"));

        $response = $this->General_model->updateRecord('lotes', $data, 'idLote', $idLote);
        echo json_encode($response);
    }

    public function lista_sedes() {
        echo json_encode($this->Contraloria_model->get_sedes_lista()->result_array());
    }

    public function updateLotePrecioEnganche() {
        $idLote = $_POST['idLote'];
        $data = array(
            "usuario" => $this->session->userdata('id_usuario')
        );

        empty($_POST['preciodesc']) ? '' : (($_POST['registroComision'] == 0 || $_POST['registroComision'] == 8) ? $data['totalNeto2'] = $this->formatter->removeNumberFormat($_POST['preciodesc']) : '');
        empty($_POST['enganches']) ? '' : $data['totalNeto'] = $this->formatter->removeNumberFormat($_POST['enganches']);
        empty($_POST['ubicacion_sede']) ? : $data['ubicacion'] = $_POST['ubicacion_sede'];

        var_dump($data);

        $response = $this->General_model->updateRecord('lotes', $data, 'idLote', $idLote);
        echo json_encode($response);
    }

    public function reporte_diario() {
        $this->load->view('template/header');
        $this->load->view("contraloria/vista_reporte_diario");
    }

    public function getRegistroDiario() {
        $data = array();
        $data = $this->Contraloria_model->registroDiario();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function getRegistroDiarioPorFecha() {
        $fechaFin = explode('-', $this->input->post("fecha_inicio"));
        $begindDate = date("Y-m-d", strtotime("{$fechaFin[2]}-{$fechaFin[1]}-{$fechaFin[0]}"));
        $data = array();
        $data = $this->Contraloria_model->registroDiarioPorFecha($begindDate);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function fillSelectsForV9() {
        echo json_encode($this->Contraloria_model->getCatalogs()->result_array());
    }

    function todasAutorizacionesMSI(){
        $data = $this->Contraloria_model->todasAutorizacionesMSI();
        if($data != null) {
            echo json_encode($data, JSON_NUMERIC_CHECK);
        } else {
            echo json_encode(array());
        }
    }

    function getAutVis($id_autorizacion, $modo){
        //$modo 1: LOTE 2:CONDOMINIO
        if($modo == 2){
            $id_autorizacion = str_replace('%20','', $id_autorizacion);
            $arrayAutorizaciones= explode(",", $id_autorizacion);
            $arrayVista = array(); //se debe mandar el array final para la vista
            foreach ($arrayAutorizaciones as $autorizacion){

                $data = $this->Contraloria_model->getAutVis($autorizacion);
                $arrayManejo = array(
                    'idLote' =>   $data[0]['idCondominio'], //id del condominio
                    'nombre' =>   $data[0]['nombre'], // NOMBRE del condominio
                    'msi'    =>    $data[0]['msi'],
                    'msi_general'  =>    $data[0]['msi'] //msi definidos en la autorizacion
                );
                array_push($arrayVista, $arrayManejo);
            }
        }
        else{//cuando es por lotes "normal"
            $data = $this->Contraloria_model->getAutVis($id_autorizacion);
            $array_diferentes = json_decode($data[0]['lote']);
            $lotes = $this->General_model->getLotesList($data[0]['idCondominio']);
            $arrayVista = array(); //el array que armaremos par amandarlo a la vista
            foreach ($lotes as $item){
                $arrayManejo['idLote'] = $item['idLote'];
                $arrayManejo['nombre'] = $item['nombreLote'];
                $flag=0;
                foreach($array_diferentes as $item2){
                    if($item['idLote'] == $item2->ID){
                        $flag = 1;//flag para que no se inserte doble vez la posicion de ambos arrays
                        $arrayManejo = array(
                            'idLote'       =>   $item2->ID, //id del lote en el arreglo que son difernetes
                            'nombre'       =>   $item2->LOTE, // NOMBRE del lote en el arreglo donde son diferentes
                            'msi'          =>   $item2->MSNI,
                            'msi_general'  =>    $data[0]['msi'] //msi definidos en la autorizacion
                        );
                        array_push($arrayVista, $arrayManejo );
                    }
                }
                if($flag==0){
                    $arrayManejo = array(
                        'idLote' =>   $item['idLote'], //id del lote en el arreglo que son difernetes
                        'nombre' =>   $item['nombreLote'], // NOMBRE del lote en el arreglo donde son diferentes
                        'msi'    =>    $data[0]['msi'],
                        'msi_general'  =>    $data[0]['msi'] //msi definidos en la autorizacion
                    );
                    array_push($arrayVista, $arrayManejo);
                }
            }
        }

        if($arrayVista != null) {
            echo json_encode($arrayVista);
        } else {
            echo json_encode(array());
        }
    }

    function getHistorialAutorizacionMSI () {
        $id_autorizacion = $this->input->post('id_autorizacion');
        $modo = $this->input->post("modo");

        if($modo==1){//normal
            $data = $this->Contraloria_model->getHistorialAutorizacionMSI($id_autorizacion);
        }
        else if($modo==2){
            $id_autorizacion = str_replace('%20','', $id_autorizacion);
            $arrayAutorizaciones= explode(",", $id_autorizacion);
            $data = array();
            $array_manejo = array();
            foreach ($arrayAutorizaciones as $autorizacion){
                $dataHistorial = $this->Contraloria_model->getHistorialAutorizacionMSI($autorizacion);
                $array_manejo = array(
                    "nombre" => $dataHistorial[0]['nombre'],
                    "estatus_autorizacion" => $dataHistorial[0]['estatus_autorizacion'],
                    "data_historial" => $dataHistorial,
                    "idHistorial" => $dataHistorial[0]['idHistorial']
                );
                array_push($data, $array_manejo);
            }
        }
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    function actualizarMSI() {
        //$modo 1: LOTE 2:CONDOMINIO
        $data_vista = $this->input->post('data');
        $id_autorizacion = $this->input->post('id_aut');
        $modo = $this->input->post('modo');
        $actualizar = array();
        $array_update = array();
        if($modo == 1) {
            $data_autorizacion = $this->Contraloria_model->getAutVis($id_autorizacion);
            $msi_comun = $data_autorizacion[0]['msi']; //traigo el MSI común para sacar los diferentes

            $data_vista = json_decode($data_vista);
            $array_diferentes = array();
            foreach ($data_vista as $item){
                if($item->MSNI!=$msi_comun){
                    array_push($array_diferentes,$item);//hacer el nuevo array de diferentes
                }

            }

            $array_diferentes = json_encode($array_diferentes, JSON_UNESCAPED_SLASHES);
            $fecha_insercion = date('Y-M-d H:i:s');
            $data_actualizar = array(
                "lote"=>$array_diferentes,
                "comentario" => "Se actualizaron los MSI el:".$fecha_insercion,
                "fecha_modificacion" => $fecha_insercion,
                "modificado_por" => $this->session->userdata('id_usuario')
            );
            $table = 'autorizaciones_msi';
            $key = 'id_autorizacion';
            $actualizar = $this->General_model->updateRecord($table, $data_actualizar, $key, $id_autorizacion);// MJ: ACTUALIZA LA INFORMACIÓN DE UN REGISTRO EN PARTICULAR, RECIBE 4 PARÁMETROS. TABLA, DATA A ACTUALIZAR, LLAVE (WHERE) Y EL VALOR DE LA LLAVE

        }
        elseif($modo == 2){
            $id_autorizacion = str_replace('%20','', $id_autorizacion);
            $arrayAutorizaciones= explode(",", $id_autorizacion);
            $data_vista = json_decode($data_vista);
            foreach ($arrayAutorizaciones as $item){//id de la autorizacion
                $data = $this->Contraloria_model->getAutVis($item);//data_autorizacion
                foreach ($data_vista as $item_vista){ //data de la vista que se modifico
                    if($item_vista->ID == $data[0]['idCondominio']){
                        $arrayManejo = array(
                            'id_autorizacion' =>   $item, //id del condominio
                            'msi'    =>    $item_vista->MSNI,
                        );
                        array_push($array_update, $arrayManejo);
                    }
                }
            }
            //HACER EL UPDATE BATCH DE LAS AUTORIZACIONES
            $actualizar = $this->db->update_batch('autorizaciones_msi', $array_update, 'id_autorizacion');
        }

        if($actualizar){
            $data_response['message'] = 'OK';
        }else{
            $data_response['message'] = 'ERROR';
        }
        echo json_encode($data_response);
    }

    function actualizaAutMSI() {
        //$modo 1: LOTE 2:CONDOMINIO
        $id_autorizacion = $this->input->post('id_aut');
        $comentario = $this->input->post('comentario');
        $estatus_autorizacion = $this->input->post('estatus_autorizacion');
        $modo = $this->input->post('modo');

        $actualizar = array();
        $insert_historial = array();
        $update_lotes = array();

        $fecha_insercion = date('Y-M-d H:i:s');
        if($modo == 1){
            $data_actualizar = array(
                "estatus_autorizacion" => $estatus_autorizacion,
                "comentario" => $comentario,
                "fecha_modificacion" => $fecha_insercion,
                "modificado_por" => $this->session->userdata('id_usuario')
            );
            $data_historial = array(
                "idAutorizacion"        => $id_autorizacion,
                "tipo"                  => 2,
                "id_usuario"            => $this->session->userdata('id_usuario'),
                "fecha_movimiento"      => $fecha_insercion,
                "estatus"               => 1,
                "comentario"            => $comentario,
                "estatus_autorizacion"  => $estatus_autorizacion
            );

            $table = 'autorizaciones_msi';
            $key = 'id_autorizacion';
            $table_historial = 'historial_autorizacionesPMSI';
            $actualizar = $this->General_model->updateRecord($table, $data_actualizar, $key, $id_autorizacion);// MJ: ACTUALIZA LA INFORMACIÓN DE UN REGISTRO EN PARTICULAR, RECIBE 4 PARÁMETROS. TABLA, DATA A ACTUALIZAR, LLAVE (WHERE) Y EL VALOR DE LA LLAVE
            $insert_historial = $this->General_model->addRecord($table_historial, $data_historial);

            if($estatus_autorizacion==3){//cuando sea una aprobación se va hacer el update masivo de lotes de MSI
                $array_update_lotes = $this->actualizaMSI($id_autorizacion, $modo);
                $update_lotes = $this->db->update_batch('lotes', $array_update_lotes, 'idLote');
            }else{
                $update_lotes = true;
            }
        }
        elseif($modo == 2){
            $id_autorizacion = str_replace('%20','', $id_autorizacion);
            $arrayAutorizaciones= explode(",", $id_autorizacion);
            $fecha_insercion = date('Y-m-d H:i:s');
            foreach($arrayAutorizaciones as $id_aut){
                $data_actualizar = array(
                    "estatus_autorizacion" => $estatus_autorizacion,
                    "comentario" => $comentario,
                    "fecha_modificacion" => $fecha_insercion,
                    "modificado_por" => $this->session->userdata('id_usuario')
                );
                $data_historial = array(
                    "idAutorizacion"        => $id_aut,
                    "tipo"                  => 2,
                    "id_usuario"            => $this->session->userdata('id_usuario'),
                    "fecha_movimiento"      => $fecha_insercion,
                    "estatus"               => 1,
                    "comentario"            => $comentario,
                    "estatus_autorizacion"  => $estatus_autorizacion
                );

                $table = 'autorizaciones_msi';
                $key = 'id_autorizacion';
                $table_historial = 'historial_autorizacionesPMSI';
                $actualizar = $this->General_model->updateRecord($table, $data_actualizar, $key, $id_aut);// MJ: ACTUALIZA LA INFORMACIÓN DE UN REGISTRO EN PARTICULAR, RECIBE 4 PARÁMETROS. TABLA, DATA A ACTUALIZAR, LLAVE (WHERE) Y EL VALOR DE LA LLAVE
                $insert_historial = $this->General_model->addRecord($table_historial, $data_historial);


                if($estatus_autorizacion==3){//cuando sea una aprobación se va hacer el update masivo de lotes de MSI
                    $array_update_lotes = $this->actualizaMSI($id_aut, $modo);
                    $update_lotes = $this->db->update_batch('lotes', $array_update_lotes, 'idLote');
                }else{
                    $update_lotes = true;
                }
            }
        }

        if($actualizar && $insert_historial && $update_lotes){
            $data_response['message'] = 'OK';
        }else{
            $data_response['message'] = 'ERROR';
        }
        echo json_encode($data_response);
        //avanzar o rechazar autorizacion
    }

    function actualizaMSI($id_autorizacion, $modo) {//esta funcion obtiene los lotes con msi diferentes y los que no para -
        //mandarlos a actualizar definitivamente
        if($modo == 1){
            $data_autorizacion = $this->Contraloria_model->getAutVis($id_autorizacion);
            $lotes_diferentes = json_decode($data_autorizacion[0]['lote'], JSON_NUMERIC_CHECK);
            $idCondominio    = $data_autorizacion[0]['idCondominio'];
            $lotes_general = $this->Contraloria_model->getLotesByResCond($idCondominio);
            $arrayVista = array(); //el array que armaremos par amandarlo a la vista
            foreach ($lotes_general as $item){
                $arrayManejo['idLote'] = $item['idLote'];
                $arrayManejo['nombre'] = $item['nombreLote'];
                $flag=0;
                foreach($lotes_diferentes as $item2){
                    if($item['idLote'] == $item2['ID']){
                        $flag = 1;//flag para que no se inserte doble vez la posicion de ambos arrays
                        $arrayManejo = array(
                            'idLote'       =>  (int) $item2['ID'], //id del lote en el arreglo que son difernetes
                            'msi'          =>   (int) $item2['MSNI'],
                        );
                        array_push($arrayVista, $arrayManejo );
                    }
                }
                if($flag==0){
                    $arrayManejo = array(
                        'idLote' =>   $item['idLote'], //id del lote en el arreglo que son difernetes
                        'msi'    =>   $data_autorizacion[0]['msi']//los demás se actualizan con los MSI que se definieron al principio
                    );
                    array_push($arrayVista, $arrayManejo);
                }
            }
            $updateData = $arrayVista;
            return $updateData;
        }
        elseif($modo == 2){
            $data_autorizacion = $this->Contraloria_model->getAutVis($id_autorizacion);
            $idCondominio    = $data_autorizacion[0]['idCondominio'];
            $lotes_general = $this->Contraloria_model->getLotesByResCond($idCondominio);
            $arrayVista = array(); //el array que armaremos par amandarlo a la vista
            foreach ($lotes_general as $item) {
                $arrayManejo['idLote'] = $item['idLote'];
                $arrayManejo['msi'] = $data_autorizacion[0]['msi'];
                array_push($arrayVista, $arrayManejo);
            }
            $updateData = $arrayVista;
            return $updateData;
        }
    }

    public function inventarioComisionistas() {
        $this->load->view('template/header');
        $this->load->view("contraloria/inventarioComisionistas_view");

    }

    public function getInvientarioComisionista($estatus, $condominio, $proyecto) {
		$data = $this->Contraloria_model->getInvientarioComisionista($estatus, $condominio, $proyecto);
		if($data!=null)
            echo json_encode($data);
        else
		    echo json_encode(array());
		exit;
    }

    public function reporteEscaneos() {
        $this->load->view('template/header');
        $this->load->view("contraloria/reporteEscaneos_view");
    }

    public function getReporteEscaneos() {
        if (isset($_POST) && !empty($_POST)) {
            $typeTransaction = $this->input->post("typeTransaction");
            $beginDate = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post("beginDate"))));
            $endDate = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post("endDate"))));
            $where = $this->input->post("where");
            $data = $this->Contraloria_model->getReporteEscaneos($typeTransaction, $beginDate, $endDate, $where);
            echo json_encode($data);
        } else
            json_encode(array());
    }

    public function lineaVentaInventario() {
        $this->validateSession();
        $this->load->view('template/header');
        $this->load->view("contraloria/lineaVentaInventario");
    }
    public function get_inventario() {
		$this->validateSession();
        $fechaInicio = $this->input->post("fechaInicio");
        $fechaFin = $this->input->post("fechaFin");
		$data = $this->Contraloria_model->getInventarioData($fechaInicio, $fechaFin);
		if($data!=null)
            print_r(json_encode(array("data" => $data)));
        else
		    print_r(json_encode(array("data" => [])));
		exit;
    }
    public function getLineaVenta(){
        $idCliente = $this->input->post("idCliente");
        $banderaVC = $this->input->post("vanderaVC");
        $data = $this->Contraloria_model->getLineaVenta($idCliente,$banderaVC);
        echo json_encode($data,JSON_NUMERIC_CHECK);
    }
    public function allUserVentas()
    {
        $datos = $this->Contraloria_model->allUserVentas();
        echo json_encode($datos,JSON_NUMERIC_CHECK);
    }
    public function EditarInventario(){
        $datos = $_POST;
        $result = $this->Contraloria_model->EditarInventario($datos);
        if($result == true){
            echo json_encode(1);
        }else {
            echo json_encode(0);
        }
    }

    public function getAllDsByLider()
    {
        $data = $this->Contraloria_model->getAllDsByLider($this->session->userdata('id_lider'));
        echo json_encode($data);
    }
}