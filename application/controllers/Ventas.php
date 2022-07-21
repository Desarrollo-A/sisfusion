<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ventas extends CI_Controller {
	public function __construct() {
		parent::__construct();
        $this->load->model(array('Ventas_modelo', 'Statistics_model'));
                $this->load->model('asesor/Asesor_model');
        $this->load->library(array('get_menu'));
		$this->load->helper(array('url','form'));
		$this->load->database('default');
	}

	public function index()
	{
        $id_rol = $this->session->userdata('id_rol');
		if($id_rol == FALSE || ($id_rol != '1' && $id_rol != '2' && $id_rol != '3' && $id_rol != '4' && $id_rol != '5'
                && $id_rol != '7' && $id_rol != '9' && $id_rol != '6' && $id_rol != '18')) {
			redirect(base_url().'login');
		}
        
         /*---------------------------------------------------------*/           
        $datos=array();

        $datos["datos2"] = $this->Asesor_model->getMenu($this->session->userdata('id_rol'))->result();
        $datos["datos3"] = $this->Asesor_model->getMenuHijos($this->session->userdata('id_rol'))->result();

        /*CONSULTAS PARA OBTENER EL PADRE DE LA OPCIÓN ACTUAL PARA ACTIVARLA*/
        $val = "https://".$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
       
        $salida = str_replace(''.base_url().'', '', $val);
        $datos["datos4"] = $this->Asesor_model->getActiveBtn($salida,$this->session->userdata('id_rol'))->result();
        /*-------------------------------------------------------------------------------*/

        $gendate = $this->Statistics_model->getGeneralData()->result();
        $datos['tprospectos'] = $gendate[0];
        $datos['pvigentes'] = $gendate[1];
        $datos['pnovigentes'] = $gendate[2];
        $datos['tclientes'] = $gendate[3];
        $dataPerSede = $this->Statistics_model->getDataPerSedeV2();
        $datos['dataSlp'] = $dataPerSede[0];
        $datos['dataQro'] = $dataPerSede[1];
        $datos['dataPen'] = $dataPerSede[2];
        $datos['dataCdmx'] = $dataPerSede[3];
        $datos['dataLeo'] = $dataPerSede[4];
        $datos['dataCan'] = $dataPerSede[5];
        $datos['monthlyProspects'] = $this->Statistics_model->getMonthlyProspects()->result();
        $datos['sub_menu'] = $this->get_menu->get_submenu_data($this->session->userdata('id_rol'), $this->session->userdata('id_usuario'));

        $this->load->view('template/header');
        //        $this->load->view('ventas/inicio_ventas');
        switch ($this->session->userdata('id_rol')) {
            case '2': // SUBDIRECTOR
                $this->load->view("dashboard/base/base", $datos);
            break;
            case '5': // ASISTENTE SUBDIRECTOR
                $this->load->view("clientes/consult_statistics_sd2", $datos);
            break;
            case '7': // ASESOR
                $this->load->view("dashboard/base/base", $datos);
            break;
            case '61': // ASESOR
                $this->load->view("clientes/consult_statistics_as", $datos);
            break;
            case '9': // COORDINADOR
                //$this->load->view("clientes/consult_statistics_co", $datos);
                $this->load->view("dashboard/base/base", $datos);
            break;
            case '6': // ASISTENTE GERENTE
            case '3': // GERENTE
                $this->load->view("dashboard/base/base", $datos);
            break;
            break;            //case '32': // CONTRALORÍA CONRPORATIVA
              //  $this->load->view('contraloria/inicio_contraloria_view');
            //break;
            case '1': // DIRECTOR
                $this->load->view("dashboard/base/base", $datos);
            break;
            case '18':// DIRECTOR MKTD
                $this->load->view("dashboard/base/base", $datos);
            break;
            case '4': // ASISTENTE DIRECTOR
            case '8': // SOPORTE
            case '19': // SUBDIRECTOR MKTD
            case '20': // GERENTE MKTD
            case '21': // CLIENTE
            case '10': // EJECUTIVO ADMINISTRATIVO MKTD
            case '22': // EJECUTIVO CLUB MADERAS
            case '23': // SUBDIRECTOR CLUB MADERAS
			case '28': // EJECUTIVO ADMINISTRATIVO MKTD
			case '33': // CONSULT
            case '53': // ANALISTA COMISIONES
            default: // VE TODOS LOS REGISTROS
                $this->load->view("clientes/consult_statistics", $datos);
            break;
        }
	}


}
