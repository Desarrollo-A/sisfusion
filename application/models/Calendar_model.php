<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendar_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    function getEvents($idSource, $idUsuario){
        $query = $this->db->query("SELECT a.titulo as title, a.fecha_cita as start, a.fecha_final as 'end', 'fab fa-google' as icon, a.id_cita as id, a.idOrganizador, 'transparent' as borderColor,
        CASE u.id_rol WHEN 7 THEN '#103f7533' ELSE '#dfdac4a3' END backgroundColor,
        CASE u.id_rol WHEN 7 THEN '#103f75' ELSE '#96843D' END textColor,
        CASE u.id_rol WHEN 7 THEN (CASE a.estatus WHEN 1 THEN 'evtAbierto asesor' WHEN 2 THEN 'evtFinalizado asesor' END ) 
		ELSE(CASE a.estatus WHEN 1 THEN 'evtAbierto coordinador' WHEN 2 THEN 'evtFinalizado coordinador' END ) END className
        FROM agenda a
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = a.medio 
        INNER JOIN usuarios u ON u.id_usuario = a.idOrganizador
        WHERE idOrganizador IN ($idSource) AND oxc.id_catalogo=65");
        return $query->result_array();
    }

    function getAllEvents($idUsuario){
        $query = $this->db->query("SELECT a.id_cita, CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) nombre, a.fecha_cita FROM agenda a 
        INNER JOIN prospectos p ON p.id_prospecto = a.idCliente
        WHERE a.idOrganizador = $idUsuario AND a.estatus = 1");
        return $query->result_array();
    }

    function getAppointmentData($idAgenda){
        $query = $this->db->query("SELECT a.id_cita, a.idCliente, a.idOrganizador, a.fecha_cita, a.fecha_final, a.fecha_creacion, a.titulo, a.descripcion, 
            CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS nombre, p.telefono, p.telefono_2 ,  a.id_direccion,
            (CASE WHEN a.id_direccion IS NOT NULL THEN dir.nombre ELSE a.direccion END) direccion, a.medio, oxc.nombre as nombre_medio, a.estatus, a.idGoogle,
            CONCAT(org.nombre, ' ', org.apellido_paterno, ' ', org.apellido_materno) AS nombreOrganizador
            FROM agenda a
            INNER JOIN prospectos p ON p.id_prospecto = a.idCliente
            INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = a.medio
            INNER JOIN usuarios org ON org.id_usuario = a.idOrganizador
            LEFT JOIN direcciones dir ON dir.id_direccion = a.id_direccion 
            WHERE a.id_cita = $idAgenda AND oxc.id_catalogo = 65");
        return $query->result_array();
    }

    function updateAppointmentData($data, $idAgenda) {
        $response = $this->db->update("agenda", $data, "id_cita = $idAgenda");
        if (! $response ) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

    function deleteAppointment($idAgenda) {
        $response =$this->db->query("DELETE FROM agenda WHERE id_cita = $idAgenda");
        if (! $response ) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

    function getStatusRecordatorio(){
        return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 65 AND estatus = 1 ORDER BY nombre");
    }

    function getProspectos($idUser){
        $response = $this->db->query("SELECT id_prospecto, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS nombre, telefono, telefono_2 FROM prospectos WHERE id_asesor = $idUser");

        return $response;
    }

    function getOfficeAddresses(){
        $response = $this->db->query("SELECT dir.id_direccion, dir.nombre as direccion 
        FROM direcciones dir 
        WHERE dir.estatus = 1");

        return $response;
    }

    function getManagers($idUser){
        $response = $this->db->query("SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) nombre, id_usuario FROM usuarios us WHERE id_lider = $idUser AND id_rol = 3 AND estatus = 1");

        return $response;
    }

    function getCoordinators($idUser){
        $response = $this->db->query("SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) nombre, id_usuario FROM usuarios us WHERE id_lider = $idUser AND id_rol = 9 AND estatus = 1");

        return $response;
    }

    function getAdvisers($idUser){
        $response = $this->db->query("SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) nombre, id_usuario FROM usuarios us WHERE id_lider = $idUser AND id_rol = 7 AND estatus = 1");

        return $response;
    }
}
