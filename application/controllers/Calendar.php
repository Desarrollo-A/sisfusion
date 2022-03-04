<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Calendar extends CI_Controller {
	public function __construct() {
		parent::__construct();
        $this->load->model(array('Calendar_model'));
                //$this->load->model('asesor/Asesor_model');	

        $this->load->library(array('session','form_validation', 'get_menu', 'Email'));
		$this->load->helper(array('url','form'));
		$this->load->database('default');
        date_default_timezone_set('America/Mexico_City');
        $this->validateSession();
	}

    public function validateSession()
    {
        if($this->session->userdata('id_usuario')=="" || $this->session->userdata('id_rol')=="")
        {
            //echo "<script>console.log('No hay sesión iniciada');</script>";
            redirect(base_url() . "index.php/login");
        }
    }

    public function calendar(){
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));

        $this->load->view('template/header');
        $this->load->view("asesor/calendar", $datos);
    }

    public function Events(){
        $data = $this->Calendar_model->getEvents();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }    
    }

    public function getAppointmentData(){
        $data = $this->Calendar_model->getAppointmentData($_POST['idAgenda']);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }    
    }

    public function updateAppointmentData(){
        $data = array(
            "medio" => $this->input->post("estatus_recordatorio2"),
            "fecha_cita" => str_replace("T", " ", $this->input->post("dateStart")),
            "titulo" => $this->input->post("evtTitle"),
            "fecha_final" => str_replace("T", " ", $this->input->post("dateEnd")),
            "direccion" => $this->input->post("comodin") ? $this->input->post("comodin"):null,
            "descripcion" => $this->input->post("description") == '' ? null:$this->input->post("description")
        );
        $response = $this->Calendar_model->updateAppointmentData($data, $this->input->post("idAgenda"));
        echo json_encode($response);
    }

    public function deleteAppointment(){
        $response = $this->Calendar_model->deleteAppointment($_POST['idAgenda']);
        echo json_encode($response);
    }

    public function getStatusRecordatorio(){
        echo json_encode($this->Calendar_model->getStatusRecordatorio()->result_array());
    }

    public function insertRecordatorio(){
        $data = array(
            "fecha_creacion" => date("Y-m-d H:i:s"),
            "medio" => $this->input->post("estatus_recordatorio"),
            "fecha_cita" =>  str_replace("T", " ", $this->input->post("dateStart")),
            "idCliente" => $this->input->post("id_prospecto_estatus_particular"),
            "estatus" => 1,
            "titulo" => $this->input->post("evtTitle"), 
            "fecha_final" =>  str_replace("T", " ", $this->input->post("dateEnd")),
            "direccion" => $this->input->post("comodin") ? $this->input->post("comodin"):null,
            "descripcion" => $this->input->post("description")
        );

        $response = $this->Calendar_model->insertAgenda($data);
        echo json_encode($response);
    }
}
 
