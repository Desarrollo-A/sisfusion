<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    //Global vrbls
    public $googleCode;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Dashboard_model'));
        $this->load->library(array('session', 'form_validation', 'get_menu'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
        date_default_timezone_set('America/Mexico_City');
        $this->validateSession();
        $this->googleCode = isset($_GET["code"]) ? $_GET["code"] : '';

        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
    }
    public function index()
    {
        if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != '55' && $this->session->userdata('id_rol') != '56' && $this->session->userdata('id_rol') != '57' && $this->session->userdata('id_rol') != '13')
            redirect(base_url() . 'login');
        $this->load->view('template/header');
        $this->load->view('template/home');
        $this->load->view('template/footer');
    }

    public function validateSession()
    {
        if ($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "") {
            redirect(base_url() . "index.php/login");
        }
    }

    public function dashboard(){
        if ($this->session->userdata('id_rol') == FALSE) {
            redirect(base_url());
        }
        $datos['sub_menu'] = $this->get_menu->get_submenu_data($this->session->userdata('id_rol'), $this->session->userdata('id_usuario'),$this->session->userdata('estatus'));
        $datos['googleCode'] = $this->googleCode;
        $this->load->view('template/header');
        $this->load->view("dashboard/base/base", $datos);
    }
    
    public function getInformation()
    {
        if (isset($_POST) && !empty($_POST)) {
            $typeTransaction = $this->input->post("typeTransaction");
            $beginDate = date("Y-m-d", strtotime($this->input->post("beginDate")));
            $endDate = date("Y-m-d", strtotime($this->input->post("endDate")));
            $where = $this->input->post("where");
            $type = $this->input->post("type");
            $saleType = $this->input->post("saleType");
            $currentYear = date("Y");
            if ($type == 1) { // GENERAL TABLE
                $data['data'] = $this->Dashboard_model->getGeneralInformation($typeTransaction, $beginDate, $endDate, $currentYear, $saleType)->result_array();
            } else if ($type == 2) { // MANAGER TABLE
                $data['data'] = $this->Dashboard_model->getInformationByManager($typeTransaction, $beginDate, $endDate, $currentYear, $where, $saleType)->result_array();
            } else if ($type == 3) { // COORDINATOR TABLE
                $data['data'] = $this->Dashboard_model->getInformationByCoordinator($typeTransaction, $beginDate, $endDate, $currentYear, $where, $saleType)->result_array();
            } else if ($type == 4) { // ADVISER TABLE
                $data['data'] = $this->Dashboard_model->getInformationByAdviser($typeTransaction, $beginDate, $endDate, $currentYear, $where, $saleType)->result_array();
            }
            echo json_encode($data, JSON_NUMERIC_CHECK);
        } else {
            json_encode(array());
        }
    }

    public function getDetails()
    {
        if (isset($_POST) && !empty($_POST)) {
            $typeTransaction = $this->input->post("typeTransaction");
            $beginDate = date("Y-m-d", strtotime($this->input->post("beginDate")));
            $endDate = date("Y-m-d", strtotime($this->input->post("endDate")));
            $where = $this->input->post("id");
            $type = $this->input->post("type");
            $saleType = $this->input->post("saleType");
            $currentYear = date("Y");
            if ($type == 1) { // GENERAL TABLE
                $data = $this->Dashboard_model->getGeneralDetails($typeTransaction, $beginDate, $endDate, $currentYear, $where, $saleType)->result_array();
            } else if ($type == 2) { // MANAGER TABLE
                $data = $this->Dashboard_model->getDetailsByManager($typeTransaction, $beginDate, $endDate, $currentYear, $where, $saleType)->result_array();
            } else if ($type == 3) { // COORDINATOR TABLE
                $whereTwo = $this->input->post("idTwo");
                $data = $this->Dashboard_model->getDetailsByCoordinator($typeTransaction, $beginDate, $endDate, $currentYear, $where, $whereTwo, $saleType)->result_array();
            } else if ($type == 4) { // ADVISER TABLE
                $data = $this->Dashboard_model->getDetailsByAdviser($typeTransaction, $beginDate, $endDate, $currentYear, $where, $saleType)->result_array();
            }
            echo json_encode($data, JSON_NUMERIC_CHECK);
        } else {
            json_encode(array());
        }
    }

    public function getProspectsByUserSessioned(){
        $id_asesor = $this->session->userdata('id_usuario');
        $data = $this->Dashboard_model->getProspectsByUserSessioned($id_asesor);
        $data['total_ventas'] = $this->Dashboard_model->totalVentasData();
        if($data != null) {
            echo json_encode($data, JSON_NUMERIC_CHECK);
        } else {
            echo json_encode(array());
        }
    }
    public function getDataFromDates(){
        $fecha_inicio = $this->input->post('fecha_inicio');
        $fecha_fin = $this->input->post('fecha_fin');
        $typeTransaction = $this->input->post('typeTransaction');

        $data = $this->Dashboard_model->getDataBetweenDates($fecha_inicio, $fecha_fin, $typeTransaction);
        if($data != null) {
            echo json_encode($data, JSON_NUMERIC_CHECK);
        } else {
            echo json_encode(array());
        }
    }

    public function totalVentasData(){
        $typeTransaction = $this->input->post('typeTransaction');

        $data = $this->Dashboard_model->totalVentasData($typeTransaction);
        if($data != null) {
            echo json_encode($data, JSON_NUMERIC_CHECK);
        } else {
            echo json_encode(array());
        }
    }

    public function getProspectsByYear(){
        $typeTransaction = $this->input->post('typeTransaction');
        $data= [
            'type'=>1,
            'typeTransaction' =>  $typeTransaction
        ];
        $data = $this->Dashboard_model->getProspectsByYear($data);
        if($data != null) {
            echo json_encode($data, JSON_NUMERIC_CHECK);
        } else {
            echo json_encode(array());
        }
    }

    public function getClientsByYear(){
        $data = $this->Dashboard_model->getClientsByYear();
        if($data != null) {
            echo json_encode($data, JSON_NUMERIC_CHECK);
        } else {
            echo json_encode(array());
        }
    }

    public function getClientsAndProspectsByYear(){
        $data= [
            'type'=>$_POST['type'],
            'beginDate'=>$_POST['beginDate'],
            'endDate'=>$_POST['endDate'],
            'typeTransaction' => $_POST['typeTransaction']
        ];
        $prospect = $this->Dashboard_model->getProspectsByYear($data);
        $client = $this->Dashboard_model->getClientsByYear($data);

        $data = array('Prospectos' => $prospect, 'Clientes'=>$client);

        if($data != null) {
            echo json_encode($data, JSON_NUMERIC_CHECK);
        } else {
            echo json_encode(array());
        }
    }

    
    public function generalMetricsByYear(){
        $data= [
            'type'=>$_POST['type'],
            'beginDate'=>$_POST['beginDate'],
            'endDate'=>$_POST['endDate'],
        ];
        $data = $this->Dashboard_model->generalMetricsByYear($data);
        if($data != null) {
            echo json_encode($data, JSON_NUMERIC_CHECK);
        } else {
            echo json_encode(array());
        }
    }

    public function cicloVenta(){
        $data = $this->Dashboard_model->cicloVenta($_POST['typeTransaction']);
        if($data != null) {
            echo json_encode($data, JSON_NUMERIC_CHECK);
        } else {
            echo json_encode(array());
        }
    }
}




