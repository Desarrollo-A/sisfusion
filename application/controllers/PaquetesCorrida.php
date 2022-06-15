<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class PaquetesCorrida extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('PaquetesCorrida_model', 'asesor/Asesor_model','General_model'));
        $this->load->library(array('session', 'form_validation', 'get_menu'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
        $this->programacion = $this->load->database('programacion', TRUE);
        //$this->validateSession();
    }

    public function index()
    {
    }

    public function validateSession()
    {
        if ($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "")
            redirect(base_url() . "index.php/login");
    }

    public function Planes()
    { 

      $datos = array();
      $datos["datos2"] = $this->Asesor_model->getMenu($this->session->userdata('id_rol'))->result();
      $datos["datos3"] = $this->Asesor_model->getMenuHijos($this->session->userdata('id_rol'))->result();
      $val = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
      $salida = str_replace('' . base_url() . '', '', $val);
      $datos["datos4"] = $this->Asesor_model->getActiveBtn($salida, $this->session->userdata('id_rol'))->result();
      $this->load->view('template/header');
      $this->load->view("ventas/Planes", $datos);
    }
    function getResidencialesList($id_sede)
    {
        $data = $this->PaquetesCorrida_model->getResidencialesList($id_sede);
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }
    function getTipoDescuento()
    {
        $data = $this->PaquetesCorrida_model->getTipoDescuento();
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    public function SavePaquete()
    {
     //echo $this->input->post("pago");
        $index = $this->input->post("index");
        $id_sede = $this->input->post("sede");
        $residenciales = $this->input->post("residencial[]");
        $superficie = $this->input->post("superficie");
        /** */
        $inicio = $this->input->post("inicio");
        $fin = $this->input->post("fin");
        //Superficie
        /**
         * 1.-Mayor a
         * 2.-Rango
         * 3.-Cualquiera
         */
        if($superficie == 1){ //Mayor a
            
        }else if($superficie == 2){ // Rango

        }else if($superficie == 3){ // Cualquiera

        }
        $Fechainicio = $this->input->post("Fechainicio");
        $Fechafin = $this->input->post("Fechafin");
        /*
        Tipo lote
        1.-Habitacional
        2.-Comercial
        3.-Ambos
        */
        $TipoLote = $this->input->post("tipoLote");

        for ($i=1; $i < $index ; $i++) { 
            //VALIDAR SI EXISTE PAQUETE
            if(isset($_POST["descripcion_".$i])){

            }
        }
        


    }
    public function lista_sedes()
    {
      echo json_encode($this->PaquetesCorrida_model->get_lista_sedes()->result_array());
    }
    public function getDescuentosPorTotal()
    {
    $tdescuento=$this->input->post("tdescuento");
	$id_condicion=$this->input->post("id_condicion");
	$eng_top=$this->input->post("eng_top");
	$apply=$this->input->post("apply");
      echo json_encode($this->PaquetesCorrida_model->getDescuentosPorTotal($tdescuento,$id_condicion,$eng_top,$apply)->result_array());
    }

}

