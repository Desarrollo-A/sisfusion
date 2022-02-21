<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Dashboard_model'));
        $this->load->library(array('session', 'form_validation', 'get_menu'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
        date_default_timezone_set('America/Mexico_City');
        $this->validateSession();
    }

    public function index()
    {
        if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != '18') {
            redirect(base_url() . 'login');
        }
        $this->load->view('template/header');
        $this->load->view('asesor/inicio_asesor_view2');
        $this->load->view('template/footer');
    }

    public function validateSession()
    {
        if ($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "") {
            redirect(base_url() . "index.php/login");
        }
    }

    public function mainDashboard()
    {
        if ($this->session->userdata('id_rol') == FALSE) {
            redirect(base_url());
        }
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        $this->load->view('template/header');
        $this->load->view("dashboard/mainDashboard", $datos);
    }

    public function mainDashboardTwo()
    {
        if ($this->session->userdata('id_rol') == FALSE) {
            redirect(base_url());
        }
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        $this->load->view('template/header');
        $this->load->view("dashboard/mainDashboardTwo", $datos);
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
            echo json_encode($data);
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
            echo json_encode($data);
        } else {
            json_encode(array());
        }
    }


}
