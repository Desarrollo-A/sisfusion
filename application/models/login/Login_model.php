<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 */
class login_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function login_user($username,$password)
	{
		$new_pass = encriptar($password);
//		var_dump($new_pass);

			$query = $this->db->query("SELECT u.id_usuario, u.id_lider, u.gerente_id as id_lider_2, u.gerente_id as id_lider_3, u.subdirector_id as id_lider_4,u.regional_id as id_lider_5,
			u.id_rol, u.id_sede, u.nombre, u.apellido_paterno, u.apellido_materno,u.correo, u.usuario, u.contrasena, u.telefono, u.tiene_hijos, u.estatus, u.sesion_activa, u.imagen_perfil, 
			u.fecha_creacion, u.creado_por, u.modificado_por, u.forma_pago, u.jerarquia_user
			FROM usuarios u
            WHERE u.usuario = '$username' AND u.contrasena = '$new_pass' AND u.estatus in(1,3)");

		/*if($query->num_rows() == 1)
		{
			return $query->row();
		}else{
			print_r($query->row());
			exit;
			$this->session->set_flashdata('usuario_incorrecto','Los datos introducidos son incorrectos');
			redirect(base_url().'login','refresh');
		}*/
		return $query->result();
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
