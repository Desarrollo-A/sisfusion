<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class General extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('General_model'));
        $this->load->library(array('session', 'form_validation', 'get_menu'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
        date_default_timezone_set('America/Mexico_City');
        $this->validateSession();
    }

    public function index()
    {
    }

    public function validateSession()
    {
        if ($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "") {
            redirect(base_url() . "index.php/login");
        }
    }

    function getResidencialesList()
    {
        $data = $this->General_model->getResidencialesList();
        if ($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    function getCondominiosList($idResidencial)
    {
        $data = $this->General_model->getCondominiosList($idResidencial);
        if ($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    function getLotesList($idCondominio)
    {
        $data = $this->General_model->getLotesList($idCondominio);
        if ($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

}
