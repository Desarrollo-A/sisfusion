<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class login_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
 
	public function login_user($username, $password) {
		$new_pass = encriptar($password);
		return $this->db->query("SELECT u.id_usuario, u.id_lider, (CASE u.id_lider WHEN 832 THEN 832 ELSE us.id_lider END) id_lider_2, 
		CASE WHEN us.id_rol = 3 THEN u.id_lider ELSE ge.id_usuario END id_lider_3, 
		CASE WHEN us.id_rol = 3 THEN  us.id_lider ELSE sb.id_usuario END id_lider_4, 
		(CASE  WHEN sb.id_usuario = 7092 THEN 3 
		WHEN sb.id_usuario IN (9471, 681, 609, 690, 2411) THEN 607 
		WHEN sb.id_usuario = 692 THEN sb.id_lider
		WHEN sb.id_usuario = 703 THEN 4
		WHEN sb.id_usuario =  7886 THEN 5
		ELSE 0 END) id_lider_5,
		CASE WHEN (u.id_sede = '13' AND sb.id_lider = 7092) THEN 3
		WHEN (u.id_sede = '13' AND sb.id_lider = 3) THEN 7092 ELSE 0 END id_regional_2,
		u.id_rol, u.id_sede, u.nombre, u.apellido_paterno, u.apellido_materno,
		u.correo, u.usuario, u.contrasena, u.telefono, u.tiene_hijos, u.estatus, u.sesion_activa, u.imagen_perfil, u.fecha_creacion, u.creado_por, u.modificado_por, u.forma_pago, u.jerarquia_user,
		hr.controlador
		FROM usuarios u
		LEFT JOIN usuarios us ON us.id_usuario = u.id_lider
		LEFT JOIN usuarios ge ON ge.id_usuario = us.id_lider
		LEFT JOIN usuarios sb ON sb.id_usuario = ge.id_lider
		LEFT JOIN homePorRol  hr ON hr.id_rol = u.id_rol
        WHERE u.usuario = '$username' AND u.contrasena = '$new_pass' AND u.estatus IN (1,3)")->result();
	}

	public function checkGerente($idGerente)
	{
		$query = $this->db-> query('SELECT *  FROM usuarios WHERE id_usuario='.$idGerente);
		return $query->result();
	}

	public function getLocation($id_sede)
	{
		$query = $this->db-> query('SELECT *  FROM sedes WHERE id_sede IN ( '.$id_sede.' ) AND estatus=1');
		return $query->result();
	}
	public function getRolByUser($id_opcion)
	{
		$query = $this->db-> query('SELECT *  FROM opcs_x_cats WHERE id_catalogo=1 AND id_opcion='.$id_opcion);
		return $query->result();
	}
}
