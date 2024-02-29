<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class PlanesModel extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    public function getPlanesComision($idPlan = null){
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
            p.gerentes,
            (SELECT STUFF((
                select ', '+ nombre + ' ' + apellido_paterno from usuarios u
                WHERE
                    u.id_usuario IN (select value id from STRING_SPLIT(p.gerentes, ',')) FOR XML PATH('') ),1,1,''
            )) AS gerentes_list,
            p.asesores,
            (SELECT STUFF((
                select ', '+ nombre + ' ' + apellido_paterno from usuarios u
                WHERE
                    u.id_usuario IN (select value id from STRING_SPLIT(p.asesores, ',')) FOR XML PATH('') ),1,1,''
            )) AS asesores_list,
            p.coordinadores,
            (SELECT STUFF((
                select ', '+ nombre + ' ' + apellido_paterno from usuarios u
                WHERE
                    u.id_usuario IN (select value id from STRING_SPLIT(p.coordinadores, ',')) FOR XML PATH('') ),1,1,''
            )) AS coordinadores_list,
            p.subdirectores,
            (SELECT STUFF((
                select ', '+ nombre + ' ' + apellido_paterno from usuarios u
                WHERE
                    u.id_usuario IN (select value id from STRING_SPLIT(p.subdirectores, ',')) FOR XML PATH('') ),1,1,''
            )) AS subdirectores_list,
            p.tipo_venta,
            (SELECT STUFF((
                select ', '+ tipo_venta from tipo_venta t
                WHERE
                    t.id_tventa IN (select value id from STRING_SPLIT(p.tipo_venta, ',')) FOR XML PATH('') ),1,1,''
            )) AS tipo_venta_list,
            p.procesos,
            (SELECT STUFF((
                select ', '+ nombre from opcs_x_cats o
                WHERE
                    o.id_catalogo=97
                AND o.id_opcion IN (select value id from STRING_SPLIT(p.procesos, ',')) FOR XML PATH('') ),1,1,''
            )) AS procesos_list,
            p.prioridad,
            
            p.venta_compartida,
            p.sedes_compartidas,
            (SELECT STUFF((
                select ', '+ nombre from sedes s
                WHERE
                    s.id_sede IN (select value id from STRING_SPLIT(p.sedes_compartidas, ',')) FOR XML PATH('') ),1,1,''
            )) AS sedes_compartidas_list,
            p.asesor_compartida,
            (SELECT STUFF((
                select ', '+ nombre + ' ' + apellido_paterno from usuarios u
                WHERE
                    u.id_usuario IN (select value id from STRING_SPLIT(p.asesor_compartida, ',')) FOR XML PATH('') ),1,1,''
            )) AS asesores_compartida_list,
            p.coordinador_compartida,
            (SELECT STUFF((
                select ', '+ nombre + ' ' + apellido_paterno from usuarios u
                WHERE
                    u.id_usuario IN (select value id from STRING_SPLIT(p.coordinador_compartida, ',')) FOR XML PATH('') ),1,1,''
            )) AS coordinadores_compartida_list,

            p.is_regional,
            p.regional,
            p.descuento_mdb,
            p.ismktd,
            p.comision_director,
            p.comision_regional,
            p.comision_subdirector,
            p.comision_gerente,
            p.comision_coordinador,
            p.comision_asesor,
            p.estatus
        FROM planes_comision p";

        if($idPlan){
            $query .= " WHERE p.idPlan IN ($idPlan) ";
        }

        $query .= " ORDER BY prioridad ASC, idPlan ASC";

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

    public function getTipoVenta(){
        $query = "SELECT
            id_tventa as id,
            tipo_venta as label
        FROM tipo_venta
        WHERE
            status=1";

        return $this->db->query($query)->result_array();
    }

    public function getProcesos(){
        $query = "SELECT
            id_opcion as id,
            nombre as label
        FROM opcs_x_cats
        WHERE
            estatus = 1
        AND id_catalogo = 97";

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

            descuento_mdb,
            ismktd,

            gerentes,
            asesores,
            coordinadores,
            subdirectores,

            tipo_venta,
            procesos,

            venta_compartida,
            sedes_compartidas,
            asesor_compartida,
            coordinador_compartida,

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

            NULLIF('$data->descuento_mdb', ''),
            NULLIF('$data->ismktd', ''),

            NULLIF('$data->gerentes', ''),
            NULLIF('$data->asesores', ''),
            NULLIF('$data->coordinadores', ''),
            NULLIF('$data->subdirectores', ''),

            NULLIF('$data->tipo_venta', ''),
            NULLIF('$data->procesos', ''),

            NULLIF('$data->venta_compartida', ''),
            NULLIF('$data->sedes_compartidas', ''),
            NULLIF('$data->asesor_compartida', ''),
            NULLIF('$data->coordinador_compartida', ''),

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
            
            is_prospeccion      = NULLIF('$data->is_prospeccion', ''),
            prospeccion         = NULLIF('$data->prospeccion', ''),
            inicio_prospeccion  = NULLIF('$data->inicio_prospeccion', ''),
            fin_prospeccion     = NULLIF('$data->fin_prospeccion', ''),

            prioridad   = $data->prioridad,
            sedes       = NULLIF('$data->sedes', ''),
            residencial = NULLIF('$data->residencial', ''),
            lotes       = NULLIF('$data->lotes', ''),

            is_regional = NULLIF('$data->is_regional', ''),
            regional    = NULLIF('$data->regional', ''),

            descuento_mdb   = NULLIF('$data->descuento_mdb', ''),
            ismktd          = NULLIF('$data->ismktd', ''),

            gerentes            = NULLIF('$data->gerentes', ''),
            asesores            = NULLIF('$data->asesores', ''),
            coordinadores       = NULLIF('$data->coordinadores', ''),
            subdirectores       = NULLIF('$data->subdirectores', ''),
            tipo_venta          = NULLIF('$data->tipo_venta', ''),
            procesos            = NULLIF('$data->procesos', ''),

            venta_compartida        = NULLIF('$data->venta_compartida', ''),
            sedes_compartidas       = NULLIF('$data->sedes_compartidas', ''),
            asesor_compartida       = NULLIF('$data->asesor_compartida', ''),
            coordinador_compartida  = NULLIF('$data->coordinador_compartida', ''),

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

    public function removeUsuarioPlanComision($idUsuario, $idPlan){
        $query = "DELETE FROM usuariosPlanComision WHERE idPlan = $idPlan AND idUsuario = $idUsuario";

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

    public function queries($id_plan = null){
        $planes = $this->getPlanesComision($id_plan);

        $queries = [];
        foreach ($planes as $key => $plan) {
            if($plan->estatus == 1){
                $conditions = [];

                $where = '';

                if($plan->venta_compartida){
                    $where .= "INNER JOIN ventas_compartidas vc ON vc.id_cliente = cl.id_cliente AND vc.estatus = 1 AND cl.status = 1 ";

                    if($plan->sedes_compartidas !== NULL){
                        array_push($conditions, "vc.id_sede IN ($plan->sedes_compartidas)");
                    }

                    if($plan->asesor_compartida !== NULL){
                        array_push($conditions, "vc.id_asesor IN ($plan->asesor_compartida)");
                    }

                    if($plan->coordinador_compartida !== NULL){
                        array_push($conditions, "vc.id_coordinador IN ($plan->coordinador_compartida)");
                    }

                    if($plan->is_regional !== null){
                        if($plan->is_regional === 0){
                            array_push($conditions, "vc.id_regional NOT IN ($plan->regional)");
                        }
                    }
                }

                if($plan->sedes){
                    array_push($conditions, "cl.id_sede IN ($plan->sedes)");
                }

                if($plan->residencial){
                    array_push($conditions, "r.idResidencial IN ($plan->residencial)");
                }

                if($plan->lotes){
                    array_push($conditions, "l.idLote IN ($plan->lotes)");
                }

                if($plan->fechaInicio){
                    array_push($conditions, "cl.fechaApartado >= '$plan->fechaInicio'");
                }

                if($plan->fechaFin){
                    array_push($conditions, "cl.fechaApartado < '$plan->fechaFin'");
                }

                if($plan->prospeccion !== NULL){
                    if($plan->is_prospeccion == 0){
                        array_push($conditions, "cl.lugar_prospeccion NOT IN ($plan->prospeccion)");
                    }else{
                        array_push($conditions, "cl.lugar_prospeccion IN ($plan->prospeccion)");
                    }
                }

                if($plan->is_regional !== null){
                    if($plan->is_regional){
                        array_push($conditions, "cl.id_regional IN ($plan->regional)");
                    }else{
                        array_push($conditions, "cl.id_regional NOT IN ($plan->regional)");
                    }
                }

                if($plan->subdirectores){
                    array_push($conditions, "cl.id_subdirector IN ($plan->subdirectores)");
                }

                if($plan->inicio_prospeccion){
                    array_push($conditions, "ps.fecha_creacion > '$plan->inicio_prospeccion'");
                }

                if($plan->fin_prospeccion){
                    array_push($conditions, "ps.fecha_creacion < '$plan->fin_prospeccion'");
                }

                if($plan->descuento_mdb !== null){
                    if($plan->descuento_mdb == 1){
                        array_push($conditions, "cl.descuento_mdb = 1");
                    }else{
                        array_push($conditions, "cl.descuento_mdb != 0");
                    }
                }

                if($plan->gerentes !== null){
                    array_push($conditions, "cl.id_gerente IN ($plan->gerentes)");
                }

                if($plan->coordinadores !== null){
                    array_push($conditions, "cl.id_coordinador IN ($plan->coordinadores)");
                }

                if($plan->asesores){
                    array_push($conditions, "cl.id_asesor IN ($plan->asesores)");
                }

                if($plan->ismktd !== null){
                    if($plan->ismktd == 0){
                        array_push($conditions, "ae.ismktd != 1");
                    }else{
                        array_push($conditions, "ae.ismktd = 1");
                    }
                }

                if($plan->procesos){
                    array_push($conditions, "cl.proceso IN ($plan->procesos)");
                }

                if($plan->tipo_venta !== null){
                    array_push($conditions, "l.tipo_venta IN ($plan->tipo_venta)");
                }

                $where .= 'WHERE ' . implode(' AND ', $conditions) . "\n";
            }

            $query = (object) ['plan' => $plan->idPlan, 'cadena' => $where];

            array_push($queries, $query);
        }

        return $queries;
    }

}