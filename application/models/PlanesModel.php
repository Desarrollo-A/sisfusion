<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class PlanesModel extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    public function getPlanesComision(){
        $query = "SELECT
            p.idPlan,
            p.nombre,
            p.fechaModificacion,
            p.fechaInicio,
            p.fechaFin,
            p.is_prospeccion,
            p.prospeccion,
            p.inicio_prospeccion,
            p.fin_prospeccion,
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
            p.is_regional,
            p.regional,
            p.comision_director,
            p.comision_regional,
            p.comision_subdirector,
            p.comision_gerente,
            p.comision_coordinador,
            p.comision_asesor,
            p.estatus
        FROM planes_comision p
        ORDER BY prioridad ASC, idPlan ASC";

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
            id_catalogo=9";

        return $this->db->query($query)->result_array();
    }

    public function enablePlan($idPlan){
        $user = $this->session->userdata('id_usuario');
        $date = date('Y-m-d H:i:s');

        $query = "UPDATE planes_comision
            SET
                estatus = 1,
                modificadoPor = $user,
                fechaModificacion = '$date'
            WHERE
                idPlan = $idPlan";

        return $this->db->query($query);
    }

    public function disablePlan($idPlan){
        $user = $this->session->userdata('id_usuario');
        $date = date('Y-m-d H:i:s');

        $query = "UPDATE planes_comision
            SET
                estatus = 0,
                modificadoPor = $user,
                fechaModificacion = '$date'
            WHERE
                idPlan = $idPlan";

        return $this->db->query($query);
    }

    public function subirPrioridad($idPlan){
        $user = $this->session->userdata('id_usuario');
        $date = date('Y-m-d H:i:s');

        $query = "UPDATE planes_comision
            SET
                prioridad = CASE WHEN prioridad > 0 THEN prioridad - 1 ELSE 0 END,
                modificadoPor = $user,
                fechaModificacion = '$date'
            WHERE
                idPlan = $idPlan";

        return $this->db->query($query);
    }

    public function bajarPrioridad($idPlan){
        $user = $this->session->userdata('id_usuario');
        $date = date('Y-m-d H:i:s');

        $query = "UPDATE planes_comision
            SET
                prioridad = prioridad + 1,
                modificadoPor = $user,
                fechaModificacion = '$date'
            WHERE
                idPlan = $idPlan";

        return $this->db->query($query);
    }

    public function insertarPlan($data){
        $user = $this->session->userdata('id_usuario');
        $date = date('Y-m-d H:i:s');

        $query = "INSERT INTO planes_comision(
            nombre,
            estatus,
            fechaInicio,
            fechaFin,

            is_prospeccion,
            prospeccion,
            inicio_prospeccion,
            fin_prospeccion,
            
            prioridad,
            sedes,
            residencial,
            lotes,

            is_regional,
            regional,

            comision_director,
            comision_regional,
            comision_subdirector,
            comision_gerente,
            comision_coordinador,
            comision_asesor,
            
            creadoPor,
            modificadoPor,
            fechaCreacion,
            fechaModificacion
        )
        VALUES (
            NULLIF('$data->nombre', ''),
            $data->estatus,
            NULLIF('$data->fechaInicio', ''),
            NULLIF('$data->fechaFin', ''),
            
            NULLIF('$data->is_prospeccion', ''),
            NULLIF('$data->prospeccion', ''),
            NULLIF('$data->inicio_prospeccion', ''),
            NULLIF('$data->fin_prospeccion', ''),

            $data->prioridad,
            NULLIF('$data->sedes', ''),
            NULLIF('$data->residencial', ''),
            NULLIF('$data->lotes', ''),

            NULLIF('$data->is_regional', ''),
            NULLIF('$data->regional', ''),

            $data->comision_director,
            $data->comision_regional,
            $data->comision_subdirector,
            $data->comision_gerente,
            $data->comision_coordinador,
            $data->comision_asesor,
            
            $user,
            $user,
            '$date',
            '$date'
        )";

        $this->db->query($query);

        return $this->db->insert_id();
    }

    public function guardarPlan($idPlan, $data){
        $user = $this->session->userdata('id_usuario');
        $date = date('Y-m-d H:i:s');

        $query = "UPDATE planes_comision
        SET
            nombre      = '$data->nombre',
            estatus     = $data->estatus,
            fechaInicio = NULLIF('$data->fechaInicio', ''),
            fechaFin    = NULLIF('$data->fechaFin', ''),
            
            is_prospeccion = NULLIF('$data->is_prospeccion', ''),
            prospeccion = NULLIF('$data->prospeccion', ''),
            inicio_prospeccion = NULLIF('$data->inicio_prospeccion', ''),
            fin_prospeccion = NULLIF('$data->fin_prospeccion', ''),

            prioridad   = $data->prioridad,
            sedes       = NULLIF('$data->sedes', ''),
            residencial = NULLIF('$data->residencial', ''),
            lotes       = NULLIF('$data->lotes', ''),

            is_regional = NULLIF('$data->is_regional', ''),
            regional    = NULLIF('$data->regional', ''),

            comision_director    = $data->comision_director,
            comision_regional    = $data->comision_regional,
            comision_subdirector = $data->comision_subdirector,
            comision_gerente     = $data->comision_gerente,
            comision_coordinador = $data->comision_coordinador,
            comision_asesor      = $data->comision_asesor,

            modificadoPor = $user,
            fechaModificacion = '$date'
        WHERE idPlan = $idPlan";

        return $this->db->query($query);
    }

    public function borrarPlan($idPlan){
        $query = "DELETE FROM planes_comision WHERE idPlan = $idPlan";

        return $this->db->query($query);
    }

    public function saveUsuarioPlanComision($idPlan, $idUsuario, $comentario, $valorComision){
        $user = $this->session->userdata('id_usuario');
        $date = date('Y-m-d H:i:s');

        $query = "BEGIN
            IF NOT EXISTS (
                SELECT * FROM usuariosPlanComision 
                WHERE
                    idUsuario = $idUsuario
                AND idPlan = $idPlan
            )
                BEGIN
                    INSERT INTO usuariosPlanComision (
                        idPlan, 
                        idUsuario, 
                        comentario, 
                        valorComision, 
                        valorNeodata,
                        estatus,
                        creadoPor,
                        modificadoPor,
                        fechaCreacion,
                        fechaModificacion
                    )
                    VALUES (
                        $idPlan, 
                        $idUsuario, 
                        '$comentario', 
                        $valorComision, 
                        $valorComision * 12.5,
                        1,
                        $user,
                        $user,
                        '$date',
                        '$date'
                    )
                END
            ELSE
                BEGIN
                    UPDATE usuariosPlanComision
                    SET
                        valorComision=$valorComision,
                        fechaModificacion='$date'
                    WHERE
                        idPlan = $idPlan
                    AND idUsuario = $idUsuario
                END
        END";

        return $this->db->query($query);
    }

}