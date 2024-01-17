<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reporteContratacion_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    function comisiones_reporteDatos($beginDate, $endDate){
        return $this->db->query("SELECT  lo.idLote, lo.nombre_lote, c.fechaApartado, pc.descripcion AS plan_comision, 
		CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) NombreCliente, 
		CONCAT(asesor.nombre, ' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as Asesor,
		CONCAT(gerentes.nombre, ' ', gerentes.apellido_paterno, ' ', gerentes.apellido_materno) as Gerente
		FROM clientes c 
		INNER JOIN plan_comision pc ON c.plan_comision = pc.id_plan
		INNER JOIN lotes lo ON c.id_cliente = lo.idCliente  
		INNER JOIN usuarios asesor ON asesor.id_usuario = c.id_asesor
		INNER JOIN usuarios gerentes ON gerentes.id_usuario = c.id_gerente 
		WHERE c.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000'");
    }

	function usuarios_rol_7(){
		$result = $this->db->query("SELECT id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) nombre from usuarios as us where id_rol = 7 and estatus in (1,3)");
		return $result->result_array();
	}

}