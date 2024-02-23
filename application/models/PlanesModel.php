<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class PlanesModel extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    public function getPlanesComision(){
        $query = "SELECT
            idPlan,
            nombre,
            fechaActualizado,
            prioridad,
            estatus
        FROM planes_comision
        ORDER BY prioridad DESC";

        return $this->db->query($query)->result_array();
    }

    public function getSedes(){
        $query = "SELECT
            id_sede as id,
            nombre as label
        FROM sedes WHERE estatus = 1";

        return $this->db->query($query)->result_array();
    }

    public function getResidenciales(){
        $query = "SELECT
            idResidencial as id,
            nombreResidencial as label
        FROM residenciales
        WHERE
            status = 1
        ORDER BY nombreResidencial ASC";

        return $this->db->query($query)->result_array();
    }

    function getUserInformation($id_usuario){
        $query = "SELECT *
        FROM usuarios
        WHERE
            id_usuario = $id_usuario";

        return $this->db->query($query)->row();
    }

    public function getLugaresProspeccion(){
        $query = "SELECT
            id_opcion as id,
            nombre as label
        FROM opcs_x_cats
        WHERE
            id_catalogo=9
        AND estatus = 1";

        return $this->db->query($query)->result_array();
    }

    public function enablePlan($idPlan){
        $query = "UPDATE planes_comision
        SET
            estatus = 1
        WHERE
            idPlan = $idPlan";

        return $this->db->query($query);
    }

    public function disablePlan($idPlan){
        $query = "UPDATE planes_comision
        SET
            estatus = 0
        WHERE
            idPlan = $idPlan";

        return $this->db->query($query);
    }

}