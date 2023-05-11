<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class AdmonAccesos_model extends CI_Model
{

    function __construct() {
        parent::__construct();
    }

    function getUserInformation($usuario, $contrasena) {
        $query = $this->db->query("SELECT u0.estatus, u0.id_usuario, 
        UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) nombre_usuarios
        FROM usuarios u0
        WHERE u0.usuario = '$usuario' AND u0.contrasena = '$contrasena' AND u0.estatus = 1");
        if($query->num_rows() > 0)
            return $query->row();
        else
            return false;
    }
}
