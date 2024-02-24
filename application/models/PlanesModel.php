<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class PlanesModel extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    public function getPlanesComision(){
        $query = "SELECT
            p.idPlan,
            p.nombre,
            p.fechaActualizado,
            p.fechaInicio,
            p.fechaFin,
            p.prospeccion,
            (SELECT STUFF((
                select ', '+ nombre from opcs_x_cats o
                WHERE
                    o.id_catalogo = 9
                    AND o.id_opcion IN (select value id from STRING_SPLIT(p.prospeccion, ',')) FOR XML PATH('') ),1,1,''
            )) AS prospeccion_list,
            p.sedes,
            (SELECT STUFF((
                select ', '+ nombre from sedes s
                WHERE
                    s.id_sede IN (select value id from STRING_SPLIT(p.sedes, ',')) FOR XML PATH('') ),1,1,''
            )) AS sedes_list,
            prioridad,
            estatus
        FROM planes_comision p
        ORDER BY prioridad ASC";

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

    public function subirPrioridad($idPlan){
        $query = "UPDATE planes_comision
        SET
            prioridad = prioridad - 1
        WHERE
            idPlan = $idPlan";

        return $this->db->query($query);
    }

    public function bajarPrioridad($idPlan){
        $query = "UPDATE planes_comision
        SET
            prioridad = prioridad + 1
        WHERE
            idPlan = $idPlan";

        return $this->db->query($query);
    }

    public function insertarPlan($data)
    {
        $query = "INSERT INTO planes_comision(
            nombre,
            prospeccion,
            prioridad,
        ) VALUES(
            '$data->nombre',
            '$data->prospeccion',
            $data->prioridad
        )";

        return $this->db->query($query);
    }

}