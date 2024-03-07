<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 */
class Ventas_modelo extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function editDireccionOficce($idDireccion, $direccionOffice){
		$query = $this->db->query("UPDATE direcciones SET nombre = '$direccionOffice' WHERE id_direccion = '$idDireccion'");

		return $query;
	}

	public function statusOffice($idDireccion, $status){
		$status = $status == 0 ? 1 : 0;
		$query = $this->db->query("UPDATE direcciones SET estatus = '$status' WHERE id_direccion = '$idDireccion'");

		return $query;
	}

	public function addDireccionOficce($direccion, $idSede, $inicio, $fin){
		$idUsuario = $this->session->userdata('id_usuario');
		$query = $this->db->query("INSERT INTO direcciones VALUES ('$idSede', '$direccion', '1', '$inicio', '$fin', '1', GETDATE(), '$idUsuario')");

		return $query;
	}
}
