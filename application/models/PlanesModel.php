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
            p.residencial,
            (SELECT STUFF((
                select ', '+ CAST(descripcion as VARCHAR(MAX)) from residenciales r
                WHERE
                    r.idResidencial IN (select value id from STRING_SPLIT(p.residencial, ',')) FOR XML PATH('') ),1,1,''
            )) AS residencial_list,
            p.lotes,
            (SELECT STUFF((
                select ', '+ nombreLote from lotes r
                WHERE
                    r.idLote IN (select value id from STRING_SPLIT(p.lotes, ',')) FOR XML PATH('') ),1,1,''
            )) AS lotes_list,
            p.prioridad,
            p.comision_director,
            p.comision_regional,
            p.comision_subdirector,
            p.comision_gerente,
            p.comision_coordinador,
            p.comision_asesor,
            p.estatus
        FROM planes_comision p
        ORDER BY prioridad ASC";

        return $this->db->query($query)->result();
    }

    public function getUsuariosPlanComision($idPlan){
        $query = "SELECT
            upc.idPlan,
            upc.valorComision,
            upc.idUsuario,
            upc.comentario,
            u.nombre
        FROM usuariosPlanComision upc
        LEFT JOIN usuarios u ON u.id_usuario = upc.idUsuario
        WHERE
            upc.idPlan = $idPlan";

        return $this->db->query($query)->result();
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
            CONCAT(nombreResidencial, ' - ', descripcion) as label
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
            prioridad = CASE WHEN prioridad > 0 THEN prioridad - 1 ELSE 0 END
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

    public function insertarPlan($data){
        $date = date('Y-m-d');

        $query = "INSERT INTO planes_comision(
            nombre,
            estatus,
            fechaInicio,
            fechaFin,
            prospeccion,
            prioridad,
            sedes,
            residencial,
            lotes,
            comision_director,
            comision_regional,
            comision_subdirector,
            comision_gerente,
            comision_coordinador,
            comision_asesor,
            fechaActualizado
        ) VALUES (
            NULLIF('$data->nombre', ''),
            $data->estatus,
            NULLIF('$data->fechaInicio', ''),
            NULLIF('$data->fechaFin', ''),
            NULLIF('$data->prospeccion', ''),
            $data->prioridad,
            NULLIF('$data->sedes', ''),
            NULLIF('$data->residencial', ''),
            NULLIF('$data->lotes', ''),
            $data->comision_director,
            $data->comision_regional,
            $data->comision_subdirector,
            $data->comision_gerente,
            $data->comision_coordinador,
            $data->comision_asesor,
            '$date'
        )";

        return $this->db->query($query);
    }

    public function guardarPlan($idPlan, $data){
        $date = date('Y-m-d');

        $query = "UPDATE planes_comision
        SET
            nombre      = '$data->nombre',
            estatus     = $data->estatus,
            fechaInicio = NULLIF('$data->fechaInicio', ''),
            fechaFin    = NULLIF('$data->fechaFin', ''),
            prospeccion = NULLIF('$data->prospeccion', ''),
            prioridad   = $data->prioridad,
            sedes       = NULLIF('$data->sedes', ''),
            residencial = NULLIF('$data->residencial', ''),
            lotes       = NULLIF('$data->lotes', ''),

            comision_director    = $data->comision_director,
            comision_regional    = $data->comision_regional,
            comision_subdirector = $data->comision_subdirector,
            comision_gerente     = $data->comision_gerente,
            comision_coordinador = $data->comision_coordinador,
            comision_asesor      = $data->comision_asesor,

            fechaActualizado = '$date'
        WHERE idPlan = $idPlan";

        return $this->db->query($query);
    }

    public function borrarPlan($idPlan){
        $query = "DELETE FROM planes_comision WHERE idPlan = $idPlan";

        return $this->db->query($query);
    }

}