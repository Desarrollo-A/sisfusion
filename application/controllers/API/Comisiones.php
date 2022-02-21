<?php

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Comisiones extends REST_Controller {

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
			$query = $this->db-> query("SELECT pci.id_pago_i AS idSolicitudDeComision, pci.fecha_abono as fechaSolicitudDeComision, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', 
			us.apellido_materno) AS nombreComisionista, us.rfc, oprol.nombre as puesto, CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
				re.nombreResidencial as desarrollo, co.nombre as cluster, lo.nombreLote as lote, lo.sup as superficie, lo.total as precioNeto, 
				pci.abono_neodata as solicitado, (CASE us.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci.abono_neodata) ELSE 0 END) descuento,
				(CASE us.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci.abono_neodata) ELSE pci.abono_neodata END) comisionTotal, 
				 com.porcentaje_decimal as porcentajeComision, null as entradaVenta, oxc3.nombre as esquema, 'completa' AS cobro, null as xmldata, pci.id_pago_i as idPago 	
					FROM pago_comision_ind pci
					 INNER JOIN comisiones com ON pci.id_comision = com.id_comision AND com.estatus in (1)
					 INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
					 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
					 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
					 INNER JOIN clientes cli ON cli.idLote = lo.idLote AND cli.status = 1
					 INNER JOIN usuarios us ON us.id_usuario = com.id_usuario AND us.forma_pago in (3,4)
					 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
					 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
					 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci.estatus AND oxcest.id_catalogo = 23
					 INNER JOIN opcs_x_cats oxc3 ON oxc3.id_opcion = us.forma_pago AND oxc3.id_catalogo = 16
					--  left JOIN facturas fa ON fa.id_comision = pci.id_pago_i
					--  left JOIN xmldatos xm ON xm.idFactura = fa.id_factura
					 INNER JOIN sedes sed ON sed.id_sede = (CASE us.id_usuario 
	 WHEN 2 THEN 2 
	 WHEN 3 THEN 2 
	 WHEN 1980 THEN 2 
	 WHEN 1981 THEN 2 
	 WHEN 1982 THEN 2 
	 WHEN 1988 THEN 2 
	 WHEN 4 THEN 5
	 WHEN 5 THEN 3
	 WHEN 607 THEN 1 
	 ELSE us.id_sede END) and sed.estatus = 1
					 WHERE pci.estatus IN (8) 
					 GROUP BY pci.id_pago_i, pci.id_comision, pci.fecha_abono, us.nombre, us.apellido_paterno, us.apellido_materno,
				us.rfc, oprol.nombre, cli.nombre, cli.apellido_paterno, cli.apellido_materno,
				re.nombreResidencial, co.nombre, lo.nombreLote, lo.sup, lo.total, 
				pci.abono_neodata, us.forma_pago, sed.impuesto, pci.abono_neodata, us.forma_pago, sed.impuesto, 
				pci.abono_neodata, pci.abono_neodata, com.porcentaje_decimal, oxc3.nombre 
				ORDER BY lo.nombreLote");
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