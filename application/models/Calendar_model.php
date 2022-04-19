<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendar_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    function getEvents(){
        $query = $this->db->query("SELECT a.titulo as title, a.fecha_cita as start, a.fecha_final as 'end', a.id_cita as id FROM agenda a
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = a.medio WHERE oxc.id_catalogo=65");
        return $query->result_array();
    }

    function getAppointmentData($idAgenda){
        $query = $this->db->query("SELECT a.id_cita, a.idCliente, a.fecha_cita, a.estatus, a.fecha_creacion, a.medio, a.titulo, a.id_direccion, a.titulo, a.fecha_final, a.descripcion, a.idGoogle, CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS nombre, p.telefono, p.telefono_2 ,
        (CASE WHEN a.id_direccion IS NOT NULL THEN dir.nombre ELSE a.direccion END) direccion
        FROM agenda a
        INNER JOIN prospectos p ON p.id_prospecto = a.idCliente
        LEFT JOIN direcciones dir ON dir.id_direccion = a.id_direccion WHERE a.id_cita = $idAgenda");
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
}
