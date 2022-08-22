<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Suma_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function getUserInformation($username, $password)
    {
        $query = $this->db->query("SELECT u0.id_rol, u0.estatus,
        u0.id_usuario id_asesor, UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) nombre_asesor,
        u1.id_usuario id_coordinador, UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) nombre_coordinador,
        u2.id_usuario id_gerente, UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) nombre_gerente,
        u3.id_usuario id_subdirector, UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) nombre_subdirector,
        CASE u4.id_usuario WHEN 2 THEN 0 ELSE u4.id_usuario END id_regional, CASE u4.id_usuario WHEN 2 THEN 'NO APLICA' ELSE CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno) END nombre_regional
        FROM usuarios u0
        LEFT JOIN usuarios u1 ON u1.id_usuario = u0.id_lider
        LEFT JOIN usuarios u2 ON u2.id_usuario = u1.id_lider
        LEFT JOIN usuarios u3 ON u3.id_usuario = u2.id_lider
        LEFT JOIN usuarios u4 ON u4.id_usuario = u3.id_lider
        WHERE u0.usuario = '$username' AND u0.contrasena = '$password'");

        if($query->num_rows() > 0)
            return $query->row();
        else
            return false;
    }
}
