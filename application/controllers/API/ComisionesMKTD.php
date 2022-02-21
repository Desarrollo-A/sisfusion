<?php

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class ComisionesMKTD extends REST_Controller {

	/**
	 * Get All Data from this method.
	 *
	 * @return Response
	 */
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Get All Data from this method.
	 *
	 * @return Response
	 */
	public function index_get($id = 0)
	{
		if(!empty($id)){
			$query = $this->db-> query("SELECT SUM(pcmk.abono_marketing) total,
(CASE us.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*SUM(pcmk.abono_marketing)) ELSE 0 END) descuento,
(CASE us.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*SUM(pcmk.abono_marketing)) ELSE SUM(pcmk.abono_marketing) END) totalPagar,
/* sed.impuesto valorImpuesto,*/
us.id_usuario, CONCAT(us.nombre,' ', us.apellido_paterno, ' ', us.apellido_materno) colaborador, pto.nombre as puesto, us.rfc, s.nombre sede,
oxc.nombre esquema
FROM pago_comision_mktd pcmk
INNER JOIN usuarios us ON us.id_usuario = pcmk.id_usuario
INNER JOIN sedes s ON s.id_sede = (CASE WHEN LEN (us.id_sede) > 1 THEN 2 ELSE us.id_sede END)
INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = us.forma_pago AND oxc.id_catalogo = 16
INNER JOIN opcs_x_cats pto ON pto.id_opcion = us.id_rol AND pto.id_catalogo = 1
LEFT JOIN sedes sed ON sed.id_sede =
(CASE us.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 5 ELSE (CASE WHEN LEN (us.id_sede) > 1 THEN 0 ELSE us.id_sede END)  END)
and sed.estatus = 1
WHERE pcmk.estatus = 8
GROUP BY pcmk.id_usuario, us.nombre, us.apellido_paterno, us.apellido_materno, us.id_usuario,
s.nombre, oxc.nombre, us.forma_pago, sed.impuesto, us.rfc, pto.nombre");
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
	/**
	 * Get All Data from this method.
	 *
	 * @return Response
	 */
	/*public function index_delete($id)
	{
		$this->db->delete('comisiones', array('id'=>$id));

		$this->response(['comisiones deleted successfully.'], REST_Controller::HTTP_OK);
	}*/
}