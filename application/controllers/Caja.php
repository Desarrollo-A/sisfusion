<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Caja extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Caja_model');
		$this->load->model('registrolote_modelo');
		$this->load->library(array('session','form_validation'));
		$this->load->helper(array('url','form'));
		$this->load->database('default');

        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
		$rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
        $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
    }

	public function index()
	{
		if($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != '12')
		{
			redirect(base_url().'login');
		}
		$this->load->view('template/header');
		$this->load->view('caja/inicio_caja_view');
		$this->load->view('template/footer');
	}
 
	public function cambiar_asesor(){
		$this->load->view('template/header');
		$this->load->view("caja/vista_cambiar_asesor_caja");
	}

	public function historial_pagos(){
		$this->load->view('template/header');
		$this->load->view("caja/vista_historial_pagos_caja");
	}

	public function pagos_cancelados(){
		$this->load->view('template/header');
		$this->load->view("caja/vista_cancelados_pagos_caja");
	}

	public function alta_cluster(){
		$this->load->view('template/header');
		$this->load->view("caja/vista_alta_cluster_caja");
	}

	public function alta_lote(){
		$this->load->view('template/header');
		$this->load->view("caja/vista_alta_lote_caja");
	}

	public function actualiza_precio(){
		$this->load->view('template/header');
		$this->load->view("caja/vista_actualiza_precios_caja");
	}

	public function actualiza_referencia(){
		$this->load->view('template/header');
		$this->load->view("caja/vista_actualiza_referencias_caja");
	}

	public function liberacion(){
		$this->load->view('template/header');
		$this->load->view("caja/vista_liberacion_caja");
	}

	public function lista_proyecto(){
      echo json_encode($this->Caja_model->get_proyecto_lista()->result_array());
	}
	public function lista_condominio($proyecto){
      echo json_encode($this->Caja_model->get_condominio_lista($proyecto)->result_array());
	}
	public function lista_lote($condominio){
      echo json_encode($this->Caja_model->get_lote_lista($condominio)->result_array());
	}
	public function get_lista_condominio($condominio){
      echo json_encode($this->Caja_model->get_datos_condominio($condominio)->result_array());
	}
	// public function get_lote_historial_pagos($lote){
 //      echo json_encode($this->Caja_model->get_datos_lote_pagos($lote)->result_array());
	// }
	public function lista_clientes(){
		$this->load->view('template/header');
		$this->load->view("contratacion/datos_cliente_contratacion_view");
	}

	public function inventario()/*this is the function*/
	{
		$datos = array();
		$datos["registrosLoteContratacion"] = $this->registrolote_modelo->registroLote();
		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
		$this->load->view('template/header');
		$this->load->view("contratacion/datos_lote_contratacion_view", $datos);
	}
 


}
