<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Calendar extends CI_Controller {
	public function __construct() {
		parent::__construct();
        $this->load->model(array('Calendar_model', 'General_model'));
        $this->load->library(array('session','form_validation', 'get_menu', 'Email','permisos_sidebar', 'GoogleApi'));
		$this->load->helper(array('url','form'));
		$this->load->database('default');
        date_default_timezone_set('America/Mexico_City');
        $this->validateSession();
        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
        $rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
        $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
    }

    public function validateSession(){
        if($this->session->userdata('id_usuario')=="" || $this->session->userdata('id_rol')==""){
            redirect(base_url() . "index.php/login");
        }
    }

    public function calendar(){
        $this->load->view("dashboard/agenda/calendar");
    }

    public function Events(){
        $ids = $this->input->post('ids');
        $data = $this->Calendar_model->getEvents($ids, $this->session->userdata('id_usuario'));
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
        $objDatos = json_decode(file_get_contents("php://input"));
        $data = array(
            "medio" => $objDatos->estatus_recordatorio2,
            "fecha_cita" => str_replace("T", " ", $objDatos->dateStart),
            "titulo" => $objDatos->evtTitle,
            "fecha_final" => str_replace("T", " ", $objDatos->dateEnd),
            "id_direccion" => $objDatos->id_direccion ?? null,
            "direccion" => $objDatos->direccion ?? null,
            "descripcion" => $objDatos->description == '' ? null:$objDatos->description,
            "idGoogle" => $objDatos->idGoogle ?? null
        );

        $response = $this->General_model->updateRecord('agenda', $data, 'id_cita',  $objDatos->idAgenda);

        if($response){
            if(isset($objDatos->telefono2)){
                $dataN = array(
                    "telefono_2" => $objDatos->telefono2,
                );
                $responseN = $this->General_model->updateRecord('prospectos', $dataN, 'id_prospecto',  $objDatos->prospectoE);

                if($responseN)
                    echo json_encode(array("status" => 200, "message" => "Se ha actualizado el recordatorio y dato del prospecto correctamente."));
                else 
                    echo json_encode(array("status" => 400, "message" => "Oops, algo salió mal.Se ha actualizado el recordatorio pero no el dato del prospecto."));
            }
            else
                echo json_encode(array("status" => 200, "message" => "Se ha actualizado el recordatorio correctamente."));
        }
        else 
            echo json_encode(array("status" => 503, "message" => "Oops, no se ha podido actualizar el recordatorio ni el dato del prospecto."));
    }

    public function deleteAppointment(){
        $appointment = (object) $this->Calendar_model->getAppointmentData($_POST['idAgenda'])[0];

        if(isset($appointment->idGoogle)){
            $user = (object) $this->session->userdata;

            if(isset($user)){
                $this->googleapi->getAccessToken($user->correo);

                $this->googleapi->deleteCalendarEvent('primary', $appointment->idGoogle);
            }
        }

        $response = $this->Calendar_model->deleteAppointment($_POST['idAgenda']);
        echo json_encode($response);
    }

    public function getStatusRecordatorio(){
        echo json_encode($this->Calendar_model->getStatusRecordatorio()->result_array());
    }

    private function buildEventGoogle($data){
        $date_start = date('Y-m-d\Th:i:s', strtotime($data->dateStart));
        $date_end = date('Y-m-d\Th:i:s', strtotime($data->dateEnd));

        $object = json_encode(array(
            'summary' => $data->evtTitle,
            'description' => $data->description,
            'start' => array(
                'dateTime' => $date_start,
                'timeZone' => 'America/Mexico_City',
            ),
            'end' => array(
                'dateTime' => $date_end,
                'timeZone' => 'America/Mexico_City',
            ),
            'attendees' => [
                0 => [
                    'email' => $data->correo,
                    'responseStatus' => 'accepted',
                ],
            ],
            'source' => [
                'title' => 'El google',
                'url' => 'https://www.google.com'
            ],
            'reminders' => array(
                'useDefault' => FALSE,
                'overrides' => array(
                    array('method' => 'email', 'minutes' => 24 * 60),
                    array('method' => 'popup', 'minutes' => 60),
                    array('method' => 'popup', 'minutes' => 10),
                ),
            ),
            'visibility' => 'public',
        ));

        return $object;
    }

    public function insertRecordatorio(){
        $objDatos = json_decode(file_get_contents("php://input"));

        $user = (object) $this->session->userdata;
        $objDatos->correo = $user->correo;

        $this->googleapi->getAccessToken($user->correo);

        $event = $this->buildEventGoogle($objDatos);

        $result = $this->googleapi->createCalendarEvent('primary', $event);

        $objDatos->id = $result->id;

        $data = array(
            "fecha_creacion" => date("Y-m-d H:i:s"),
            "medio" => $objDatos->estatus_recordatorio,
            "fecha_cita" =>  str_replace("T", " ", $objDatos->dateStart),
            "idCliente" => $objDatos->id_prospecto_estatus_particular,
            "idOrganizador" => $this->session->userdata('id_usuario'),
            "estatus" => 1,
            "titulo" => $objDatos->evtTitle, 
            "fecha_final" =>  str_replace("T", " ", $objDatos->dateEnd),
            "id_direccion" => isset($objDatos->id_direccion) ? $objDatos->id_direccion :null,
            "direccion" => isset($objDatos->direccion) ? $objDatos->direccion :null,
            "descripcion" => $objDatos->description,
            "idGoogle" => $objDatos->id
        );

        $response = $this->General_model->addRecord('agenda', $data);

        if ($response){
            $dataN = array(
                "fecha_modificacion" => date("Y-m-d H:i:s"),
                "modificado_por" => $this->session->userdata('id_usuario'),
                "estatus_particular" => 3
            );

            if(isset($objDatos->telefono2)){
                $dataN['telefono_2'] = $objDatos->telefono2;
            }

            $responseN = $this->General_model->updateRecord('prospectos', $dataN, 'id_prospecto', $this->input->post("id_prospecto_estatus_particular"));

            if ($responseN)
                echo json_encode(array("status" => 200, "message" => "Se ha registrado el evento de manera exitosa."));
            else 
                echo json_encode(array("status" => 400, "message" => "Oops, algo salió mal. No se ha podido actualizar el estatus del prospecto"));
        } else 
            echo json_encode(array("status" => 503, "message" => "Oops, no se ha podido agendar cita, ni actualizar estatus del prospecto"));
    }

    public function getProspectos(){
        $idUser = $this->session->userdata('id_usuario');
        $data = $this->Calendar_model->getProspectos($idUser)->result_array();

        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }    
    }

    public function getOfficeAddresses(){
        $data = $this->Calendar_model->getOfficeAddresses()->result_array();

        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function getManagers(){
        $idUser = $this->session->userdata('id_usuario');
        $data = $this->Calendar_model->getManagers($idUser)->result_array();

        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        } 
    }

    public function getCoordinators(){
        $idUser = $this->input->post('id');
        $data = $this->Calendar_model->getCoordinators($idUser)->result_array();

        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        } 
    }

    public function getAdvisers(){
        $idUser = $this->input->post('id');
        $data = $this->Calendar_model->getAdvisers($idUser)->result_array();

        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        } 
    }

    public function setAppointmentRate(){
        $objDatos = json_decode(file_get_contents("php://input"));
        $data = array(
            "estatus" => 2,
            "evaluacion" => $objDatos->rate,
            "observaciones" => $objDatos->observaciones
        );
        
        $response = $this->General_model->updateRecord('agenda', $data, 'id_cita',  $objDatos->idAgenda);

        if ($response)
            echo json_encode(array("status" => 200, "message" => "El registro se ha actualizado de manera exitosa."));
        else 
            echo json_encode(array("status" => 503, "message" => "Oops, algo salió mal. No se ha podido actualizar el estatus del prospecto"));
    }

    public function AllEvents(){
        $data['data'] = $this->Calendar_model->getAllEvents($this->session->userdata('id_usuario'));
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }    
    }

    public function updateNFinishAppointments(){
        $response = $this->General_model->updateBatch("agenda", json_decode(file_get_contents("php://input")), "id_cita"); // MJ: SE MANDA CORRER EL UPDATE BATCH
        if ($response)
            echo json_encode(array("status" => 200, "message" => "El registro se ha actualizado de manera exitosa."));
        else 
            echo json_encode(array("status" => 503, "message" => "Oops, algo salió mal. No se ha podido actualizar la información de la(s) cita(s)."));
    }
}
 
