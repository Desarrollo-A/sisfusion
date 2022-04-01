<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class General extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
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

    function loginDemo()
    {
        $clientID = '267709590113-v4i5keof8q5gb07c85kbcl0in9tjuq1u.apps.googleusercontent.com';
        $clientSecret = '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';
        $redirectURL = base_url() . "index.php/login";
    }

    function getLotesList()
    {
        if ($this->input->post("typeTransaction") == 1) // MJ: LA BÚSQUEDA SERÁ POR MULTI CONDOMINIO
            if (count($this->input->post("idCondominio"))>1)
                $idCondominio = implode(", ", $this->input->post("idCondominio"));
            else
                $idCondominio = $this->input->post("idCondominio")[0];
        
        $data = $this->General_model->getLotesList($idCondominio);
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }
}
