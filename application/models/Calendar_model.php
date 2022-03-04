<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendar_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    function getEvents(){
        $query = $this->db->query("SELECT a.titulo as title, a.fecha_cita as start, a.fecha_final as 'end', a.id_cita as id FROM agenda a
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = a.medio WHERE oxc.id_catalogo=57");
        return $query->result_array();
    }

    function getAppointmentData($idAgenda){
        $query = $this->db->query("SELECT a.*, CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) as nombre, p.telefono, p.telefono_2 FROM agenda a
        INNER JOIN prospectos p ON p.id_prospecto = a.idCliente WHERE a.id_cita = $idAgenda");
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
        return $this->db->query("SELECT id_opcion, nombre FROM sisfusion.dbo.opcs_x_cats WHERE id_catalogo = 57 AND estatus = 1 ORDER BY nombre");
    }

    function insertAgenda($data) {
        $response = $this->db->insert("agenda", $data);

        if (! $response ) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }
}
