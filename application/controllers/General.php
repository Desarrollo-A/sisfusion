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
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    function getCondominiosList()
    {
        $data = $this->General_model->getCondominiosList($this->input->post("idResidencial"));
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    function getLotesList()
    {
        if ($this->input->post("typeTransaction") == 1) // MJ: LA BÚSQUEDA SERÁ POR MULTI CONDOMINIO
            if (strpos($this->input->post("idCondominio"), ',') !== false)
                $idCondominio = implode(", ", $this->input->post("idCondominio"));
            else
                $idCondominio = $this->input->post("idCondominio");
        
        $data = $this->General_model->getLotesList($idCondominio);
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    public function multirol(){ //chriscrosspapas
        $usuario = $this->session->userdata('id_usuario');
        $data = $this->General_model->getMultirol($usuario)->result_array();
        if ($data != null)
            echo json_encode($data,  JSON_NUMERIC_CHECK);
        else
            echo json_encode(array());
    }

    public function getUsersByLeader(){
        $rol = $this->input->post("rol");
        $secondRol = $this->input->post("secondRol");
        $data = $this->General_model->getUsersByLeader($rol, $secondRol)->result_array();
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }
    public function getCatalogOptions(){
        if ($this->input->post("id_catalogo") == '' || $this->input->post("id_catalogo") == undefined)
            echo json_encode(array("status" => 400, "error" => "Algún parámetro no tiene un valor especificado o no viene informado."));
        else
            echo json_encode($this->General_model->getCatalogOptions($this->input->post("id_catalogo"))->result_array());
    }

    public function getAsesoresList()
    {
        $data = $this->General_model->getAsesoresList();
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

}
