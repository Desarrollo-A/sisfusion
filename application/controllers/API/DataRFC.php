<?php

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class DataRFC extends REST_Controller {

	/**
	 * Get All Data from this method.
	 *
	 * @return Response
	 */
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	

	public function index_get($id = 0)
	// {
		
	// 		$query = $this->db->query("");
	// 		$data['RESULT']['COMDATA'] = $query->result();
		
	// 	$this->response($data, REST_Controller::HTTP_OK);
	// }

	{
		if(!empty($id)){
			$query = $this->db-> query("SELECT us.id_usuario, us.nombre, us.apellido_paterno, us.apellido_materno, us.rfc, opc.nombre as forma_pago, op1.nombre as puesto FROM usuarios us
	inner join opcs_x_cats opc ON opc.id_opcion = us.forma_pago AND opc.id_catalogo = 16
	inner join opcs_x_cats op1 ON op1.id_opcion = us.id_rol AND op1.id_catalogo = 1
	WHERE us.id_rol in(3,9,7) and us.estatus = 1 and us.correo NOT LIKE '%test_%'");
			$data['RESULT']['COMDATA'] = $query->result();
		}
		$this->response($data, REST_Controller::HTTP_OK);
	}

	/**
	 * Get All Data from this method.
	 *
	 * @return Response
	 */
	public function index_post()
	{
		$input = $this->input->post();
		$this->db->insert('products',$input);

		$this->response(['Product created successfully.'], REST_Controller::HTTP_OK);
	}
	/**
	 * Get All Data from this method.
	 *
	 * @return Response
	 */
	public function index_put($id)
	{
		/*$input = $this->put();
		$this->db->update('comisiones', $input, array('id'=>$id));

		$this->response(['Registro comisión updated successfully.'], REST_Controller::HTTP_OK);*/
	}
}