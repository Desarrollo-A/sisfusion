<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reporte extends CI_Controller {
	public function __construct() {
		parent::__construct();
        $this->load->model(array('Reporte_model', 'General_model'));
        $this->load->library(array('session','form_validation', 'get_menu', 'Email', 'Jwt_actions'));
		$this->load->helper(array('url','form'));
		$this->load->database('default');
        date_default_timezone_set('America/Mexico_City');
        $this->jwt_actions->authorize('9717', $_SERVER['HTTP_HOST']);
        $this->validateSession();
	}

    public function validateSession(){
        if($this->session->userdata('id_usuario')=="" || $this->session->userdata('id_rol')==""){
            redirect(base_url() . "index.php/login");
        }
    }

    public function reporte(){
        $this->load->view("dashboard/reporte/reporte");
    }

    public function getInformation(){
        $currentYear = date("Y");

        if (isset($_POST) && !empty($_POST)) {
            $typeTransaction = $this->input->post("typeTransaction");
            //si es consulta inicial = 1 o si es consulta con filtro de fechas = 2
            if( $typeTransaction==1){
                $beginDate = "$currentYear-01-01";
                $endDate = date("Y-m-d");
            }else{
                $beginDate = date("Y-m-d", strtotime($this->input->post("beginDate")));
                $endDate = date("Y-m-d", strtotime($this->input->post("endDate")));
            }
            $id_usuario = $this->input->post("id_usuario");
            $where = $this->input->post("where");
            $rol = $this->input->post("type");
            $render = $this->input->post("render");
            $asesor = $this->input->post("asesor");
            $coordinador = $this->input->post("coordinador");
            $gerente = $this->input->post("gerente");
            $subdirector = $this->input->post("subdirector");
            $regional = $this->input->post("regional");
            $typeSale = $this->input->post("typeSale");
            $currentYear = date("Y");
            $data['data'] = $this->Reporte_model->getGeneralInformation($beginDate, $endDate, $rol, $id_usuario, $render, [$asesor, $coordinador, $gerente, $subdirector, $regional], $typeTransaction, $typeSale)->result_array();
            echo json_encode($data, JSON_NUMERIC_CHECK);
        } else {
            json_encode(array());
        }
    }

    public function getDataChart() {
        $currentYear = date("Y");
        $general = $this->input->post('general');
        $tipoChart = $this->input->post('tipoChart');
        $typeSale = $this->input->post('typeSale');
        $id_rol = $this->input->post('type');
        $render = $this->input->post('render');
        $asesor = $this->input->post("asesor");
        $coordinador = $this->input->post("coordinador");
        $gerente = $this->input->post("gerente");
        $subdirector = $this->input->post("subdirector");
        $regional = $this->input->post("regional");

        if($this->input->post("beginDate") == null && $this->input->post("endDate") == null){
            $beginDate = "$currentYear-01-01";
            $endDate = date("Y-m-d");
        } else {
            $beginDate = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post("beginDate"))));
            $endDate = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post("endDate"))));
        }
        
        $data = $this->Reporte_model->getDataChart($general, $tipoChart, $id_rol, $beginDate, $endDate, $typeSale, $render, [$asesor, $coordinador, $gerente, $subdirector, $regional]);

        //Obtenemos solo array de ventas contratadas
        $vcArray = array_filter($data, function($element){
            return $element['tipo'] == 'vc';
        });

        //Obtenemos solo array de ventas apartadas
        $vaArray = array_filter($data, function($element){
            return $element['tipo'] == 'va';
        });

        //Reindexamos el filtro obtenido anteriormente
        $vcArray = array_values($vcArray);
        $vaArray = array_values($vaArray);

        //Recorremos uno de los arrays obtenido anteriormente y sumamos en cada uno de los puntos para obtener cantidad y total
        if( $general == "1" || $tipoChart == "vt"){
            if($tipoChart == "vt"){
                $data = array();
            }
            foreach( $vcArray as $key => $elemento ){
                $tot1 = floatval(preg_replace('/[^\d\.]/', '', $elemento['total']));
                $tot2 = floatval(preg_replace('/[^\d\.]/', '', $vaArray[$key]['total']));
                
                //Hacemos push a nuevo array de ventas generales ya con la sumatoria de va y vc por mes.
                $data[] = array(
                    'total' => "$" . number_format(($tot1 + $tot2), 2),
                    'cantidad' => $elemento['cantidad'] + $vaArray[$key]['cantidad'],
                    'mes' => $elemento['mes'],
                    'año' => $elemento['año'],
                    'tipo' => 'vt',
                    'rol' => $elemento['rol']
                ); 
            }
        }

        if($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    function validateDate($date, $format = 'Y-m-d'){
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }

    public function validateRegional($id){
        $data = $this->Reporte_model->validateRegional($id);
        if($data != null) $where = " AND cl.id_regional = " . $id;
        else $where = " AND cl.id_subdirector = " . $id;

        return $where;
    }

    public function getRolDR(){
        $idUser = $this->input->post('idUser');
        $data = $this->Reporte_model->validateRegional($idUser);
        if($data != null) {
            echo json_encode($data, JSON_NUMERIC_CHECK);
        }
        else echo json_encode(array());
    }

    public function getDetails(){
        $typeTransaction = $this->input->post("transaction");//si es consulta inicial = 1 o si es consulta con filtro de fechas = 2
        
        $beginDate = date("Y-m-d", strtotime($this->input->post("beginDate")));
        $endDate = date("Y-m-d", strtotime($this->input->post("endDate")));
        $id_usuario = $this->input->post("id_usuario");
        $rol = $this->input->post("rol");
        $render = $this->input->post("render");
        $leader = $this->input->post("leader");
        $asesor = $this->input->post("asesor");
        $coordinador = $this->input->post("coordinador");
        $gerente = $this->input->post("gerente");
        $subdirector = $this->input->post("subdirector");
        $regional = $this->input->post("regional");
        $typeSale = $this->input->post("typeSale");

        $data = $this->Reporte_model->getDetails($typeSale, $beginDate, $endDate, $rol, $id_usuario, $render, $leader, [$asesor, $coordinador, $gerente, $subdirector, $regional])->result_array();
        if($data != null) {
            echo json_encode($data, JSON_NUMERIC_CHECK);
        } else {
            echo json_encode(array());
        }
    }

    public function getLotesInformation(){
        if (isset($_POST) && !empty($_POST)) {
            $type = $this->input->post("type");
            $beginDate = date("Y-m-d", strtotime($this->input->post("beginDate")));
            $endDate = date("Y-m-d", strtotime($this->input->post("endDate")));
            $id_usuario = $this->input->post("user");
            $rol = $this->input->post("rol");
            $render = $this->input->post("render");
            $sede = $this->input->post("sede");
            $leader = $this->input->post("leader");
            $asesor = $this->input->post("asesor");
            $coordinador = $this->input->post("coordinador");
            $gerente = $this->input->post("gerente");
            $subdirector = $this->input->post("subdirector");
            $regional = $this->input->post("regional");
            $typeSale = $this->input->post("typeSale");

            $data['data'] = $this->Reporte_model->getGeneralLotesInformation($typeSale, $beginDate, $endDate, $rol, $id_usuario, $render, $type, $sede, $leader, [$asesor, $coordinador, $gerente, $subdirector, $regional])->result_array();
            echo json_encode($data, JSON_NUMERIC_CHECK);
        } else
            echo json_encode(array());
    }

    public function reporteConRecisiones(){
		$this->validateSession();

   		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
		$this->load->view('template/header');
		$this->load->view("reportes/reporteConRecisiones",$datos);
	}

    public function getVentasConSinRecision(){
        $beginDate = $this->input->post("beginDate");
        $endDate = $this->input->post("endDate");
        $data = $this->Reporte_model->getVentasConSinRecision($beginDate, $endDate)->result_array();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function reporteTrimestral(){
        $this->validateSession();

        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        $this->load->view('template/header');
        $this->load->view("reportes/reporteTrimestral",$datos);
    }

    public function getLotesTrimestral(){
        $beginDate = $this->input->post("beginDate");
        $endDate = $this->input->post("endDate");
        $data = $this->Reporte_model->getReporteTrimestral($beginDate, $endDate)->result_array();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function reporteApartados(){
        $this->validateSession();
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        $this->load->view('template/header');
        $this->load->view("reportes/reporteApartados",$datos);
    }

    public function getLotesApartados(){
        $beginDate = $this->input->post("beginDate");
        $endDate = $this->input->post("endDate");
        $data = $this->Reporte_model->getLotesApartados($beginDate, $endDate)->result_array();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

}
