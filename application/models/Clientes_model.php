<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 */
class Clientes_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    function getProspectingPlaces(){
        return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 9 AND estatus = 1 ORDER BY CASE id_opcion WHEN 31 THEN '' WHEN 6 THEN '' ELSE nombre END");
    }

    function getNationality(){
        return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 11 AND estatus = 1 ORDER BY id_opcion, nombre");
    }
    function getEstados(){
        return $this->db->query("SELECT id_estado, nombre FROM estados ORDER BY nombre");
    }
    function getCAPListByAdvisor(){
        return $this->db->query("SELECT id_prospecto id_opcion, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) nombre, '0' tipo FROM prospectos WHERE id_asesor = ".$this->session->userdata('id_usuario')."
                                UNION ALL
                                SELECT id_cliente id_opcion, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) nombre, '1' tipo FROM clientes WHERE id_asesor = ".$this->session->userdata('id_usuario')." ORDER BY nombre;");
    }
/**REPORTE CLIENTES */
function getRpClientes()
{
    $query = $this->db->query("select CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', ISNULL(c.apellido_materno, '')) nombre,CONCAT(c.telefono1, ' - ', c.telefono2) telefono,c.correo,c.empresa,c.originario_de,c.domicilio_particular,o.nombre as civil,l.nombreLote,d.nombre as condominio,r.nombreResidencial from clientes c 
    inner join lotes l on c.idLote=l.idLote 
    inner join condominios d on l.idCondominio=d.idCondominio 
    inner join residenciales r on d.idResidencial=r.idResidencial 
    inner join opcs_x_cats o on c.estado_civil=o.id_opcion  where c.status=1 and o.id_catalogo=18;");
    return $query->result();
}
/** */
    function getAdvisersMktd(){
        switch ($this->session->userdata('id_rol')) {
            case '19': // SUBDIRECTOR MKTD
                return $this->db->query("SELECT id_usuario as id_opcion, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                id_rol IN (7, 9) AND id_sede IN (".$this->session->userdata('id_sede').") AND estatus = 1 ORDER BY nombre");
            break;
            case '20': // GERENTE MKTD
                return $this->db->query("SELECT id_usuario as id_opcion, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                id_rol IN (7, 9) AND id_sede LIKE '%".$this->session->userdata('id_sede')."%' AND estatus = 1 ORDER BY nombre");
            break;
            case '22': // EJECUTIVO CLUB MADERAS
            case '35': // ATENCIÓN A CLIENTES CLUB MADERAS
                return $this->db->query("SELECT id_usuario as id_opcion, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                id_rol IN (7) AND estatus = 1 ORDER BY nombre");
                break;
        }
    }

    function getKinship(){
        return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 26 AND estatus = 1 ORDER BY id_opcion, nombre");
    }

    function getStatusMktd(){
        return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 38 AND estatus = 1 AND id_opcion BETWEEN 1 AND 6 ORDER BY nombre");
    }

    function getLegalPersonality(){
        return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 10 AND estatus = 1 ORDER BY nombre");
    }

    function getAdvertising(){
        return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 7 AND estatus = 1 ORDER BY nombre");
    }

    function getSalesPlaza(){
        return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 5 AND estatus = 1 ORDER BY nombre");
    }

    function getCivilStatus(){
        return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 18 AND estatus = 1 ORDER BY nombre");
    }

    function getMatrimonialRegime(){
        return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 19 AND estatus = 1 ORDER BY nombre");
    }

    function getState(){
        return $this->db->query("SELECT id_estado, nombre FROM estados ORDER BY nombre");
    }

    function checkProspectValidity(){
        return $this->db->query("SELECT id_estado, nombre FROM estados ORDER BY nombre");
    }

    function getManagersVentas(){
        return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                id_rol = 3 AND id_usuario NOT BETWEEN 2535 AND 2597 AND estatus = 1 ORDER BY nombre");
    }

    function getCoordinatorsVentas(){
        return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                id_rol = 9 AND id_usuario NOT BETWEEN 2535 AND 2597 AND estatus = 1 ORDER BY nombre");
    }

    function getAdvisersVentas(){
        return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                id_rol IN (7, 9) AND id_usuario NOT BETWEEN 2535 AND 2597 AND estatus = 1 ORDER BY nombre");
    }

    function uploadData($data) {
        $this->db->trans_begin();
        $response = $this->db->insert("prospectos", $data);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return $finalAnswer = 0;
        } else {
            $this->db->trans_commit();
            return $finalAnswer = 1;
        }
    }

/*--------------------------------------PREVENTA----------------------------------------------------------------------*/
function updateStatusPreventa($data, $id_prospecto) {
        $response = $this->db->update("prospectos", $data, "id_prospecto = $id_prospecto");
        if (! $response ) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

function getStatusMktdPreventa(){
        return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 38 AND estatus = 1 AND id_opcion=7 ORDER BY nombre");
    }
  function getProspectsPreventaList(){
        switch ($this->session->userdata('id_rol')) {
            case '2': // SUBDIRECTOR
            case '5': // ASISTENTE SUBDIRECTOR
                return $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, c.estatus_particular
                                        FROM prospectos c
                                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        WHERE c.id_sede IN(".$this->session->userdata('id_sede').") AND c.tipo = 0 AND c.estatus_particular = 6 AND c.lugar_prospeccion != 6 ORDER BY c.fecha_creacion DESC");
                break;
            case '3': // GERENTE
                return $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, c.estatus_particular
                                        FROM prospectos c 
                                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        WHERE c.id_gerente = ".$this->session->userdata('id_usuario')." AND c.tipo = 0 AND c.estatus_particular = 6 AND c.lugar_prospeccion != 6 ORDER BY c.fecha_creacion DESC");
                break;
            case '6': // ASISTENTE GERENTE
                return $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente,  
                                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, c.estatus_particular
                                        FROM prospectos c 
                                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        WHERE c.id_gerente = ".$this->session->userdata('id_lider')." AND c.tipo = 0 AND c.estatus_particular = 6 AND c.lugar_prospeccion != 6 ORDER BY c.fecha_creacion DESC");
                break;
            case '9': // COORDINADOR
                return $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, c.estatus_particular
                                        FROM prospectos c 
                                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        WHERE (c.id_asesor = ".$this->session->userdata('id_usuario')." OR c.id_coordinador = ".$this->session->userdata('id_usuario').") AND c.tipo = 0 AND c.estatus_particular = 6 AND c.lugar_prospeccion != 6 ORDER BY c.fecha_creacion DESC");
                break;
            case '7': // ASESOR
                return $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, c.estatus_particular
                                        FROM prospectos c 
                                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        WHERE c.id_asesor = ".$this->session->userdata('id_usuario')." AND c.tipo = 0 AND c.estatus_particular = 6 ORDER BY c.fecha_creacion DESC");
                break;
            case '1': // DIRECTOR
            case '4': // ASISTENTE DIRECTOR
            default: // VE TODOS LOS REGISTROS
                return $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, c.estatus_particular
                                        FROM prospectos c 
                                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        WHERE c.tipo = 0 AND c.estatus_particular = 6 AND c.lugar_prospeccion != 6 ORDER BY c.fecha_creacion DESC");
                break;
        }

    }

    function getProspectsListMktd($typeTransaction, $beginDate, $endDate, $where){
        if ($typeTransaction == 1 || $typeTransaction == 3) {  // FIRST LOAD || SEARCH BY DATE RANGE
            $filter = "AND c.fecha_creacion BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
        }else{
            $filter = '';
        }

        switch ($this->session->userdata('id_rol')) {
            case '20': //GERENTE MKTD
                return $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre, c.vigencia,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, c.estatus_particular, c.lugar_prospeccion, oxc.nombre nombre_lp, c.telefono, c.telefono_2
                                        FROM prospectos c 
                                        INNER JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        INNER JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        INNER JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                                        WHERE c.estatus_vigencia = 1 $filter AND c.id_sede IN('".$this->session->userdata('id_sede')."') AND c.lugar_prospeccion = 6 AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                break;
            case '19': // SUBDIRECTOR MKTD
                return $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre, c.vigencia,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, c.estatus_particular, c.lugar_prospeccion, oxc.nombre nombre_lp, c.telefono, c.telefono_2
                                        FROM prospectos c 
                                        INNER JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        INNER JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        INNER JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                                        WHERE c.estatus_vigencia = 1 $filter AND c.id_sede IN('".$this->session->userdata('id_sede')."') AND c.lugar_prospeccion = 6 AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                break;
                case '18': //GERENTE MKTD
                    return $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre, c.vigencia,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, c.estatus_particular, c.lugar_prospeccion, oxc.nombre nombre_lp, c.telefono, c.telefono_2
                                        FROM prospectos c 
                                        INNER JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        INNER JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        INNER JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                                        WHERE c.estatus_vigencia = 1 $filter AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                break;
        }

    }

    function getProspectsReport($typeTransaction, $beginDate, $endDate, $where){
        if ($typeTransaction == 1 || $typeTransaction == 3) {  // FIRST LOAD || SEARCH BY DATE RANGE
            $filter = " AND c.fecha_creacion BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
            $filterTwo = "";
        } else if($typeTransaction == 2) { // SEARCH BY LOTE
            $filter = "";
            $filterTwo = " AND l.idLote = $where";
        }


        switch ($this->session->userdata('id_rol')) {
            case '20': //GERENTE MKTD
                return $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                        CONVERT(VARCHAR,c.fecha_creacion,120) AS fecha_creacion, CONVERT(VARCHAR,c.fecha_vencimiento,120) AS fecha_vencimiento, CONVERT(VARCHAR,c.fecha_modificacion,120) AS fecha_modificacion, c.estatus_particular, c.estatus, c.otro_lugar
                                        FROM prospectos c 
                                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        WHERE c.id_sede = ".$this->session->userdata('id_sede')." AND c.tipo = 0 AND c.lugar_prospeccion = 6 
                                        ".$filter." 
                                        AND c.estatus_particular IN (1, 2, 3, 5, 6, 7) ORDER BY c.fecha_creacion DESC");
                break;
            case '19': // SUBDIRECTOR MKTD
                return $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                        CONVERT(VARCHAR,c.fecha_creacion,120) AS fecha_creacion, CONVERT(VARCHAR,c.fecha_vencimiento,120) AS fecha_vencimiento, CONVERT(VARCHAR,c.fecha_modificacion,120) AS fecha_modificacion, c.estatus_particular, c.estatus, c.otro_lugar
                                        FROM prospectos c 
                                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        WHERE c.id_sede IN (".$this->session->userdata('id_sede').") AND c.tipo = 0 AND c.lugar_prospeccion = 6
                                        ".$filter." 
                                        AND c.estatus_particular IN (1, 2, 3, 5, 6, 7) ORDER BY c.fecha_creacion DESC");
                break;
            case '18': //GERENTE MKTD
                return $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                        CONVERT(VARCHAR,c.fecha_creacion,120) AS fecha_creacion, CONVERT(VARCHAR,c.fecha_vencimiento,120) AS fecha_vencimiento, CONVERT(VARCHAR,c.fecha_modificacion,120) AS fecha_modificacion, c.estatus_particular, c.estatus, c.otro_lugar
                                        FROM prospectos c 
                                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        WHERE c.tipo = 0 AND c.lugar_prospeccion = 6 AND c.estatus_particular IN (1, 2, 3, 5)
                                        ".$filter."
                                         ORDER BY c.fecha_creacion DESC");
                break;
            case '2': // SUBDIRECTOR
            case '5': // ASISTENTE SUBDIRECTOR
                return $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                        CONVERT(VARCHAR,c.fecha_creacion,120) AS fecha_creacion, CONVERT(VARCHAR,c.fecha_vencimiento,120) AS fecha_vencimiento, CONVERT(VARCHAR,c.fecha_modificacion,120) AS fecha_modificacion, c.estatus_particular, c.estatus, c.otro_lugar
                                        FROM prospectos c 
                                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        WHERE c.id_sede IN(".$this->session->userdata('id_sede').") AND c.tipo = 0 AND c.lugar_prospeccion != 6 
                                        ".$filter."
                                        AND c.estatus_particular IN (1, 2, 3, 5, 6) ORDER BY c.fecha_creacion DESC");
                break;
            case '3': // GERENTE
                return $this->db->query("SELECT c.id_prospecto, UPPER(CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno)) nombre,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                        CONVERT(VARCHAR,c.fecha_creacion,120) AS fecha_creacion, CONVERT(VARCHAR,c.fecha_vencimiento,120) AS fecha_vencimiento, CONVERT(VARCHAR,c.fecha_modificacion,120) AS fecha_modificacion, c.estatus_particular, c.estatus, c.otro_lugar
                                        FROM prospectos c 
                                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        WHERE c.id_gerente = ".$this->session->userdata('id_usuario')." AND c.tipo = 0 AND c.lugar_prospeccion != 6 
                                        ".$filter."
                                        AND c.estatus_particular IN (1, 2, 3, 5, 6) ORDER BY c.fecha_creacion DESC");
                break;
            case '6': // ASISTENTE GERENTE
                return $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                        CONVERT(VARCHAR,c.fecha_creacion,120) AS fecha_creacion, CONVERT(VARCHAR,c.fecha_vencimiento,120) AS fecha_vencimiento, CONVERT(VARCHAR,c.fecha_modificacion,120) AS fecha_modificacion, c.estatus_particular, c.estatus, c.otro_lugar
                                        FROM prospectos c 
                                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        WHERE c.id_gerente = ".$this->session->userdata('id_lider')." AND c.tipo = 0 AND c.lugar_prospeccion != 6 
                                        ".$filter."
                                        AND c.estatus_particular IN (1, 2, 3, 5, 6) ORDER BY c.fecha_creacion DESC");
                break;
            case '9': // COORDINADOR
                return $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                        CONVERT(VARCHAR,c.fecha_creacion,120) AS fecha_creacion, CONVERT(VARCHAR,c.fecha_vencimiento,120) AS fecha_vencimiento, CONVERT(VARCHAR,c.fecha_modificacion,120) AS fecha_modificacion, c.estatus_particular, c.estatus, c.otro_lugar
                                        FROM prospectos c 
                                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        WHERE (c.id_asesor = ".$this->session->userdata('id_usuario')." 
                                        OR c.id_coordinador = ".$this->session->userdata('id_usuario').") AND c.tipo = 0 AND c.lugar_prospeccion != 6 
                                        ".$filter."
                                        AND c.estatus_particular IN (1, 2, 3, 5, 6) ORDER BY c.fecha_creacion DESC");
                break;
            case '7': // ASESOR
                return $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                        CONVERT(VARCHAR,c.fecha_creacion,120) AS fecha_creacion, CONVERT(VARCHAR,c.fecha_vencimiento,120) AS fecha_vencimiento, CONVERT(VARCHAR,c.fecha_modificacion,120) AS fecha_modificacion, c.estatus_particular, c.estatus, c.otro_lugar
                                        FROM prospectos c 
                                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        WHERE c.id_asesor = ".$this->session->userdata('id_usuario')." AND c.tipo = 0 
                                        ".$filter."
                                        AND c.estatus_particular IN (1, 2, 3, 5, 6) ORDER BY c.fecha_creacion DESC");
                break;
            case '1': // DIRECTOR
            case '4': // ASISTENTE DIRECTOR
            case '53': // ANALISTA COMISIONES
                return $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                        CONVERT(VARCHAR,c.fecha_creacion,120) AS fecha_creacion, CONVERT(VARCHAR,c.fecha_vencimiento,120) AS fecha_vencimiento, CONVERT(VARCHAR,c.fecha_modificacion,120) AS fecha_modificacion, c.estatus_particular, c.estatus, c.otro_lugar
                                        FROM prospectos c 
                                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        WHERE c.tipo = 0 AND c.lugar_prospeccion != 6 
                                        ".$filter."
                                        AND c.estatus_particular IN (1, 2, 3, 5, 6) ORDER BY c.fecha_creacion DESC");
                break;
        }

    }
    function getProspectsSalesTeam(){
        switch ($this->session->userdata('id_rol')) {
            case '20': //GERENTE MKTD
                return $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                        CONVERT(VARCHAR,c.fecha_creacion,120) AS fecha_creacion, CONVERT(VARCHAR,c.fecha_vencimiento,120) AS fecha_vencimiento, CONVERT(VARCHAR,c.fecha_modificacion,120) AS fecha_modificacion, c.estatus_particular, c.estatus, c.otro_lugar
                                        FROM prospectos c 
                                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        WHERE c.id_sede = ".$this->session->userdata('id_sede')." AND c.tipo = 0 AND c.lugar_prospeccion = 6 AND c.id_coordinador != ".$this->session->userdata('id_usuario')." ORDER BY c.fecha_creacion DESC");
                break;
            case '19': // SUBDIRECTOR MKTD
                return $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                        CONVERT(VARCHAR,c.fecha_creacion,120) AS fecha_creacion, CONVERT(VARCHAR,c.fecha_vencimiento,120) AS fecha_vencimiento, CONVERT(VARCHAR,c.fecha_modificacion,120) AS fecha_modificacion, c.estatus_particular, c.estatus, c.otro_lugar
                                        FROM prospectos c 
                                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        WHERE c.id_sede IN (".$this->session->userdata('id_sede').") AND c.tipo = 0 AND c.lugar_prospeccion = 6 AND c.id_gerente != ".$this->session->userdata('id_usuario')." ORDER BY c.fecha_creacion DESC");
                break;
            case '18': //GERENTE MKTD
                return $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, c.fecha_modificacion, c.estatus_particular, c.estatus, c.otro_lugar
                                        FROM prospectos c 
                                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        WHERE c.tipo = 0 AND c.lugar_prospeccion = 6 AND c.estatus_particular IN (1, 2, 3, 5) ORDER BY c.fecha_creacion DESC");
                break;
        }

    }

    function getProspectsList($typeTransaction, $beginDate, $endDate, $where){
        $id_rol = $this->session->userdata('id_rol');
        $id_usuario = $this->session->userdata('id_usuario');
        $id_lider = $this->session->userdata('id_lider');
        $and = "AND ((pr.lugar_prospeccion != 6) OR (pr.fecha_creacion > '2022-01-19 23:59:59.999' AND pr.lugar_prospeccion = 6))";
        if ($id_rol == 3) // MJ: GERENTE
            $where = "pr.id_gerente = $id_usuario";
        else if ($id_rol == 6) { // MJ: ASISTENTE DE GERENTE
            if ($id_usuario == 10795) // ALMA GALICIA ACEVEDO QUEZADA
                $where = "pr.id_gerente IN ($id_lider, 671) AND pr.id_sede = 12";
            else if ($id_usuario == 12449) // MARCELA CUELLAR MORON
                $where = "pr.id_gerente IN ($id_lider, 654) AND pr.id_sede = 12";
            else if ($id_usuario == 10270) // ANDRES BARRERA VENEGAS
                $where = "pr.id_gerente IN ($id_lider, 113) AND pr.id_sede IN (4, 13)";
            else
                $where = "pr.id_gerente = $id_lider";
        }
        else if ($id_rol == 9) // MJ: COORDINADOR
            $where = "(pr.id_asesor = $id_usuario OR pr.id_coordinador = $id_usuario)";
        else if ($id_rol == 7) { // MJ: ASESOR
            $and = "";
            if ($id_usuario == 6578) // MJ: COREANO VLOGS
                $where = "pr.lugar_prospeccion IN (26)";
            else if ($id_usuario == 9942) // MJ: BADABUN
                $where = "pr.lugar_prospeccion IN (33)";
            else if ($id_usuario == 11750) // MJ: FLACO CON SUERTE
                $where = "pr.lugar_prospeccion IN (43)";
            else
                $where = "pr.id_asesor = $id_usuario";
        }

        return $this->db->query("SELECT pr.id_prospecto, UPPER(CONCAT (pr.nombre, ' ', pr.apellido_paterno, ' ', pr.apellido_materno)) AS nombre, pr.vigencia,
        UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) asesor, 
        UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) coordinador, 
        UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) gerente, 
        UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) subdirector, 
        UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) regional,
        CONVERT(varchar, pr.fecha_creacion, 20) fecha_creacion, pr.fecha_vencimiento, pr.estatus, pr.estatus_particular, pr.lugar_prospeccion , UPPER(oxc.nombre) AS nombre_lp, pr.id_asesor, pr.telefono, pr.telefono_2,
        pr.source, pr.editProspecto, CASE WHEN CAST(pr.id_dragon AS VARCHAR(25)) = 0 THEN 'NO DISPONIBLE' ELSE CAST(pr.id_dragon AS VARCHAR(25)) END id_dragon
        FROM prospectos pr
        INNER JOIN usuarios u0 ON u0.id_usuario = pr.id_asesor
        LEFT JOIN usuarios u1 ON u1.id_usuario = pr.id_coordinador
        LEFT JOIN usuarios u2 ON u2.id_usuario = pr.id_gerente
        LEFT JOIN usuarios u3 ON u3.id_usuario = pr.id_subdirector
        LEFT JOIN usuarios u4 ON u4.id_usuario = pr.id_regional
        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = pr.lugar_prospeccion AND oxc.id_catalogo = 9
        WHERE $where AND pr.tipo = 0 $and ORDER BY pr.fecha_creacion DESC");
    }

    function getClientsList(){
        $id_rol = $this->session->userdata('id_rol');
        $id_usuario = $this->session->userdata('id_usuario');
        $id_lider = $this->session->userdata('id_lider');
        $id_sede = $this->session->userdata('id_sede');
        $lugar_prospeccion = "AND ((pr.lugar_prospeccion != 6) OR (pr.lugar_prospeccion = 6 AND pr.fecha_creacion < '2022-01-20 23:59:59.999'))";
        if ($id_rol == 3 || $id_rol == 6) // MJ: GERENTE
            $where = "pr.id_gerente = $id_usuario";
        else if ($id_rol == 6) // MJ: ASISTENTE DE GERENTE
            $where = "pr.id_gerente = $id_lider";
        else if ($id_rol == 9) // MJ: COORDINADOR
            $where = "(pr.id_asesor = $id_usuario OR pr.id_coordinador = $id_usuario)";
        else if ($id_rol == 7) { // MJ: ASESOR
            $lugar_prospeccion = "";
            if ($id_usuario == 6578) // MJ: COREANO VLOGS
                $where = "pr.lugar_prospeccion IN (26)";
            else if ($id_usuario == 9942) // MJ: BADABUN
            $where = "pr.lugar_prospeccion IN (33)";
            else
                $where = "pr.id_asesor = $id_usuario";
        }
        else if ($id_rol == 1 || $id_rol == 4) { // MJ: DIRECCIÓN COMERCIAL / ASISTENTES DIRECCIÓN COMERCIAL
            $where = "";
            $lugar_prospeccion = "((pr.lugar_prospeccion != 6) OR (pr.lugar_prospeccion = 6 AND pr.fecha_creacion < '2022-01-20 23:59:59.999'))";
        }
        else if ($id_rol == 2 || $id_rol == 5) // MJ: SUBDIRECCIÓN / ASISTENTES SUBDIRECCIÓN
            $where = "pr.id_sede IN ($id_sede)";


        return $this->db->query(
            "SELECT pr.id_prospecto, 
                    CONCAT (pr.nombre, ' ', pr.apellido_paterno, ' ', pr.apellido_materno) AS nombre,
                    pr.vigencia,
                    UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) AS asesor, 
                    UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) AS coordinador, 
                    UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) AS gerente, 
                    UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) AS subdirector, 
                    UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) AS regional,
                    CONVERT(varchar, pr.fecha_creacion, 20) AS fecha_creacion, 
                    CONVERT(varchar, pr.fecha_vencimiento, 20) AS fecha_vencimiento, 
                    pr.estatus, 
                    pr.estatus_particular, 
                    pr.lugar_prospeccion, 
                    UPPER(oxc.nombre) AS nombre_lp, 
                    pr.id_asesor, 
                    pr.telefono, 
                    pr.telefono_2, 
                    CASE 
                        WHEN pr.correo IS NULL OR pr.correo = '' THEN
                            'SIN ESPECIFICAR'
                        ELSE
                            pr.correo
                    END AS correo, 
                    CONVERT(varchar, becameClient, 20) AS fecha_cliente
            FROM prospectos pr
            INNER JOIN usuarios u0 ON u0.id_usuario = pr.id_asesor
            LEFT JOIN usuarios u1 ON u1.id_usuario = pr.id_coordinador
            LEFT JOIN usuarios u2 ON u2.id_usuario = pr.id_gerente
            LEFT JOIN usuarios u3 ON u3.id_usuario = pr.id_subdirector
            LEFT JOIN usuarios u4 ON u4.id_usuario = pr.id_regional
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = pr.lugar_prospeccion AND oxc.id_catalogo = 9
            WHERE $where $lugar_prospeccion AND pr.tipo = 1 ORDER BY pr.fecha_creacion DESC");
    }

    function getCMReport(){
        return $this->db->query("SELECT '1' tipo, CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre, c.telefono1, c.correo, r.nombreResidencial, cn.nombre condominio, l.nombreLote, l.totalNeto2,
                                CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor,
                                CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) coordinador,
                                CONCAT(uuu.nombre, ' ', uuu.apellido_paterno, ' ', uuu.apellido_materno) gerente, c.fechaApartado, c.id_cliente id_prospecto
                                FROM clientes c
                                INNER JOIN deposito_seriedad_consulta dsc ON dsc.idCliente = c.id_cliente
                                INNER JOIN lotes l ON l.idLote = c.idLote
                                INNER JOIN condominios cn ON cn.idCondominio = l.idCondominio
                                INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
                                LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                LEFT JOIN usuarios uu ON uu.id_usuario = c.id_coordinador
                                LEFT JOIN usuarios uuu ON uuu.id_usuario = c.id_gerente
                                WHERE dsc.especificar = 12 AND c.status = 1
                                UNION ALL
                                SELECT '1' tipo, CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre, c.telefono1, c.correo, r.nombreResidencial, cn.nombre condominio, l.nombreLote, l.totalNeto2,
                                CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor,
                                CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) coordinador,
                                CONCAT(uuu.nombre, ' ', uuu.apellido_paterno, ' ', uuu.apellido_materno) gerente, c.fechaApartado, c.id_cliente id_prospecto
                                FROM clientes c
                                INNER JOIN lotes l ON l.idLote = c.idLote
                                INNER JOIN condominios cn ON cn.idCondominio = l.idCondominio
                                INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
                                LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                LEFT JOIN usuarios uu ON uu.id_usuario = c.id_coordinador
                                LEFT JOIN usuarios uuu ON uuu.id_usuario = c.id_gerente
                                WHERE c.lugar_prospeccion = 12 AND c.status = 1
                                UNION ALL
                                SELECT '0' tipo, CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) nombre, p.telefono, p.correo, '' nombreResidencial, '' condominio,  '' nombreLote, '0.00' totalNeto2,
                                CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor,
                                CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) coordinador,
                                CONCAT(uuu.nombre, ' ', uuu.apellido_paterno, ' ', uuu.apellido_materno) gerente, p.fecha_creacion fechaApartado, p.id_prospecto
                                FROM prospectos p
                                LEFT JOIN usuarios u ON u.id_usuario = p.id_asesor
                                LEFT JOIN usuarios uu ON uu.id_usuario = p.id_coordinador
                                LEFT JOIN usuarios uuu ON uuu.id_usuario = p.id_gerente
                                WHERE p.lugar_prospeccion = 12 ORDER BY nombre");
    }
    
    function getOFReport(){
        return $this->db->query("SELECT r.nombreResidencial, cn.nombre condominio, l.nombreLote, (CASE WHEN c.personalidad_juridica = 1 THEN c.nombre 
                                WHEN c.personalidad_juridica IN (2, 3, 4) THEN CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) END) nombreCliente,
                                oxc.nombre lugar_prospeccion, c.edadFirma, c.originario_de FROM clientes c 
                                INNER JOIN lotes l ON l.idLote = c.idLote 
                                INNER JOIN condominios cn ON cn.idCondominio = l.idCondominio
                                INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
                                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion
                                WHERE c.status = 1 AND oxc.id_catalogo = 9 AND c.originario_de != '' ORDER BY nombreCliente;");
    }
    
    function getRecommendedList(){
        return $this->db->query("SELECT id_prospecto, tipo_recomendado, otro_lugar FROM prospectos WHERE lugar_prospeccion = 21");
    }

    function getRecommendedReport($type, $id, $who_recommends){
        switch ($type) {
            case '0': // IS PROSPECT
                if ($who_recommends == 0) { // WHO RECOMMENDS IS IQUAL TO 0
                    return $this->db->query("SELECT p.id_prospecto, p.estatus, p.estatus_particular, CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) nombre,
                                        CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor,
                                        CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) coordinador,
                                        CONCAT(uuu.nombre, ' ', uuu.apellido_paterno, ' ', uuu.apellido_materno) gerente,
                                        'Sin especificar' recomendado_por,
                                        'Sin especificar' lugar_prospeccion, 'Sin especificar' option_selected, 'Sin especificar' especificacion,
                                        p.fecha_creacion, p.fecha_vencimiento, p.fecha_modificacion, p.tipo_recomendado
                                        FROM prospectos p
                                        INNER JOIN usuarios u ON u.id_usuario = p.id_asesor
                                        INNER JOIN usuarios uu ON uu.id_usuario = p.id_coordinador
                                        INNER JOIN usuarios uuu ON uuu.id_usuario = p.id_gerente
                                        WHERE p.id_prospecto = $id");
                } else { // WHO RECOMMENDS IS NOT IQUAL TO 0
                    return $this->db->query("SELECT p.id_prospecto, p.estatus, p.estatus_particular, CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) nombre,
                                        CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor,
                                        CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) coordinador,
                                        CONCAT(uuu.nombre, ' ', uuu.apellido_paterno, ' ', uuu.apellido_materno) gerente,
                                        CONCAT(pp.nombre, ' ', pp.apellido_paterno, ' ', pp.apellido_materno) recomendado_por,
                                        pp.lugar_prospeccion, oxc.nombre option_selected, (CASE WHEN pp.lugar_prospeccion IN (3, 6, 7, 9, 10, 21) THEN pp.otro_lugar ELSE '' END) especificacion,
                                        p.fecha_creacion, p.fecha_vencimiento, p.fecha_modificacion, p.tipo_recomendado
                                        FROM prospectos p
                                        INNER JOIN usuarios u ON u.id_usuario = p.id_asesor
                                        INNER JOIN usuarios uu ON uu.id_usuario = p.id_coordinador
                                        INNER JOIN usuarios uuu ON uuu.id_usuario = p.id_gerente
                                        INNER JOIN prospectos pp ON pp.id_prospecto = p.otro_lugar
                                        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = pp.lugar_prospeccion
                                        WHERE p.id_prospecto = $id AND oxc.id_catalogo = 9");
                }
                break;
            case '1': // IS CLIENT
                if ($who_recommends == 0) { // WHO RECOMMENDS IS IQUAL TO 0
                    return $this->db->query("SELECT p.id_prospecto, p.estatus, p.estatus_particular, CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) nombre,
                                        CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor,
                                        CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) coordinador,
                                        CONCAT(uuu.nombre, ' ', uuu.apellido_paterno, ' ', uuu.apellido_materno) gerente,
                                        'Sin especificar' recomendado_por,
                                        'Sin especificar' lugar_prospeccion, 'Sin especificar' option_selected, 'Sin especificar' especificacion,
                                        p.fecha_creacion, p.fecha_vencimiento, p.fecha_modificacion, p.tipo_recomendado
                                        FROM prospectos p
                                        INNER JOIN usuarios u ON u.id_usuario = p.id_asesor
                                        LEFT JOIN usuarios uu ON uu.id_usuario = p.id_coordinador
                                        INNER JOIN usuarios uuu ON uuu.id_usuario = p.id_gerente
                                        WHERE p.id_prospecto = $id");
                } else { // WHO RECOMMENDS IS NOT IQUAL TO 0
                    return $this->db->query("SELECT p.id_prospecto, p.estatus, p.estatus_particular, CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) nombre,
                                        CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor,
                                        CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) coordinador,
                                        CONCAT(uuu.nombre, ' ', uuu.apellido_paterno, ' ', uuu.apellido_materno) gerente,
                                        CONCAT(pp.nombre, ' ', pp.apellido_paterno, ' ', pp.apellido_materno) recomendado_por,
                                        pp.lugar_prospeccion, oxc.nombre option_selected, (CASE WHEN pp.lugar_prospeccion IN (3, 6, 7, 9, 10, 21) THEN pp.otro_lugar ELSE '' END) especificacion,
                                        p.fecha_creacion, p.fecha_vencimiento, p.fecha_modificacion, p.tipo_recomendado
                                        FROM prospectos p
                                        INNER JOIN usuarios u ON u.id_usuario = p.id_asesor
                                        LEFT JOIN usuarios uu ON uu.id_usuario = p.id_coordinador
                                        INNER JOIN usuarios uuu ON uuu.id_usuario = p.id_gerente
                                        INNER JOIN clientes pp ON pp.id_cliente = p.otro_lugar
                                        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = pp.lugar_prospeccion
                                        WHERE p.id_prospecto = $id AND oxc.id_catalogo = 9");
                }
                break;
        }
    }

    function getSharedSalesList(){
        switch ($this->session->userdata('id_rol')) {
            case '2': // SUBDIRECTOR
            case '5': // ASISTENTE SUBDIRECTOR
                return $this->db->query("SELECT vcp.id_vcompartida, p.id_prospecto, CONCAT (p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) nombre_prospecto,
                                        vcp.id_asesor, CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_asesor,
                                        vcp.id_coordinador, CONCAT (uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) nombre_coordinador,
                                        vcp.id_gerente, CONCAT (uuu.nombre, ' ', uuu.apellido_paterno, ' ', uuu.apellido_materno) nombre_gerente,
                                        vcp.fecha_creacion, vcp.estatus FROM prospectos p
                                        INNER JOIN ventas_compartidas_prospeccion vcp ON vcp.id_prospecto = p.id_prospecto
                                        INNER JOIN usuarios u ON u.id_usuario = vcp.id_asesor
                                        INNER JOIN usuarios uu ON uu.id_usuario = vcp.id_coordinador
                                        INNER JOIN usuarios uuu ON uuu.id_usuario = vcp.id_gerente
                                        WHERE p.id_sede IN(".$this->session->userdata('id_sede').")");
                break;
            case '3': // GERENTE
                return $this->db->query("SELECT vcp.id_vcompartida, p.id_prospecto, CONCAT (p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) nombre_prospecto,
                                        vcp.id_asesor, CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_asesor,
                                        vcp.id_coordinador, CONCAT (uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) nombre_coordinador,
                                        vcp.id_gerente, CONCAT (uuu.nombre, ' ', uuu.apellido_paterno, ' ', uuu.apellido_materno) nombre_gerente,
                                        vcp.fecha_creacion, vcp.estatus FROM prospectos p
                                        INNER JOIN ventas_compartidas_prospeccion vcp ON vcp.id_prospecto = p.id_prospecto
                                        INNER JOIN usuarios u ON u.id_usuario = vcp.id_asesor
                                        INNER JOIN usuarios uu ON uu.id_usuario = vcp.id_coordinador
                                        INNER JOIN usuarios uuu ON uuu.id_usuario = vcp.id_gerente
                                        WHERE p.id_gerente = ".$this->session->userdata('id_usuario')."");
                break;
            case '6': // ASISTENTE GERENTE
                return $this->db->query("SELECT vcp.id_vcompartida, p.id_prospecto, CONCAT (p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) nombre_prospecto,
                                        vcp.id_asesor, CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_asesor,
                                        vcp.id_coordinador, CONCAT (uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) nombre_coordinador,
                                        vcp.id_gerente, CONCAT (uuu.nombre, ' ', uuu.apellido_paterno, ' ', uuu.apellido_materno) nombre_gerente,
                                        vcp.fecha_creacion, vcp.estatus FROM prospectos p
                                        INNER JOIN ventas_compartidas_prospeccion vcp ON vcp.id_prospecto = p.id_prospecto
                                        INNER JOIN usuarios u ON u.id_usuario = vcp.id_asesor
                                        INNER JOIN usuarios uu ON uu.id_usuario = vcp.id_coordinador
                                        INNER JOIN usuarios uuu ON uuu.id_usuario = vcp.id_gerente
                                        WHERE p.id_gerente = ".$this->session->userdata('id_lider')."");
                break;
            case '9': // COORDINADOR
                return $this->db->query("SELECT vcp.id_vcompartida, p.id_prospecto, CONCAT (p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) nombre_prospecto,
                                        vcp.id_asesor, CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_asesor,
                                        vcp.id_coordinador, CONCAT (uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) nombre_coordinador,
                                        vcp.id_gerente, CONCAT (uuu.nombre, ' ', uuu.apellido_paterno, ' ', uuu.apellido_materno) nombre_gerente,
                                        vcp.fecha_creacion, vcp.estatus FROM prospectos p
                                        INNER JOIN ventas_compartidas_prospeccion vcp ON vcp.id_prospecto = p.id_prospecto
                                        INNER JOIN usuarios u ON u.id_usuario = vcp.id_asesor
                                        INNER JOIN usuarios uu ON uu.id_usuario = vcp.id_coordinador
                                        INNER JOIN usuarios uuu ON uuu.id_usuario = vcp.id_gerente
                                        WHERE p.id_coordinador = ".$this->session->userdata('id_usuario')."");
                break;
            case '7': // ASESOR
                return $this->db->query("SELECT vcp.id_vcompartida, p.id_prospecto, CONCAT (p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) nombre_prospecto,
                                        vcp.id_asesor, CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_asesor,
                                        vcp.id_coordinador, CONCAT (uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) nombre_coordinador,
                                        vcp.id_gerente, CONCAT (uuu.nombre, ' ', uuu.apellido_paterno, ' ', uuu.apellido_materno) nombre_gerente,
                                        vcp.fecha_creacion, vcp.estatus FROM prospectos p
                                        INNER JOIN ventas_compartidas_prospeccion vcp ON vcp.id_prospecto = p.id_prospecto
                                        INNER JOIN usuarios u ON u.id_usuario = vcp.id_asesor
                                        INNER JOIN usuarios uu ON uu.id_usuario = vcp.id_coordinador
                                        INNER JOIN usuarios uuu ON uuu.id_usuario = vcp.id_gerente
                                        WHERE p.id_asesor = ".$this->session->userdata('id_usuario')."");
                break;
            case '1': // DIRECTOR
            case '4': // ASISTENTE DIRECTOR
            default: // VE TODOS LOS REGISTROS
                return $this->db->query("SELECT vcp.id_vcompartida, p.id_prospecto, CONCAT (p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) nombre_prospecto,
                                        vcp.id_asesor, CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_asesor,
                                        vcp.id_coordinador, CONCAT (uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) nombre_coordinador,
                                        vcp.id_gerente, CONCAT (uuu.nombre, ' ', uuu.apellido_paterno, ' ', uuu.apellido_materno) nombre_gerente,
                                        vcp.fecha_creacion, vcp.estatus FROM prospectos p
                                        INNER JOIN ventas_compartidas_prospeccion vcp ON vcp.id_prospecto = p.id_prospecto
                                        INNER JOIN usuarios u ON u.id_usuario = vcp.id_asesor
                                        INNER JOIN usuarios uu ON uu.id_usuario = vcp.id_coordinador
                                        INNER JOIN usuarios uuu ON uuu.id_usuario = vcp.id_gerente");
                break;
        }

    }

    function getSharedSalesListTitular(){
        return $this->db->query("SELECT c.id_cliente, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre_cliente,
                                c.id_asesor, CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_asesor,
                                c.id_coordinador, CONCAT (uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) nombre_coordinador,
                                c.id_gerente, CONCAT (uuu.nombre, ' ', uuu.apellido_paterno, ' ', uuu.apellido_materno) nombre_gerente
                                FROM clientes c
                                LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                LEFT JOIN usuarios uu ON uu.id_usuario = c.id_coordinador
                                LEFT JOIN usuarios uuu ON uuu.id_usuario = c.id_gerente");
    }

    function getCoOwnersList(){
        return $this->db->query("SELECT * FROM copropietarios_prospeccion");
    }

    function getReferencesList(){
        switch ($this->session->userdata('id_rol')) {
            case '2': // SUBDIRECTOR
            case '5': // ASISTENTE SUBDIRECTOR
                return $this->db->query("SELECT rp.id_referencia, rp.id_prospecto, rp.nombre, CONCAT (p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) nombre_prospecto, 
                                        rp.telefono, oxc.nombre parentesco, rp. fecha_creacion, rp.estatus FROM referencias_prospeccion rp
                                        INNER JOIN prospectos p ON p.id_prospecto = rp.id_prospecto
                                        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = rp.parentesco
                                        WHERE p.id_sede IN(".$this->session->userdata('id_sede').") AND oxc.id_catalogo = 26");
                break;
            case '3': // GERENTE
                return $this->db->query("SELECT rp.id_referencia, rp.id_prospecto, rp.nombre, CONCAT (p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) nombre_prospecto, 
                                        rp.telefono, oxc.nombre parentesco, rp. fecha_creacion, rp.estatus FROM referencias_prospeccion rp
                                        INNER JOIN prospectos p ON p.id_prospecto = rp.id_prospecto
                                        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = rp.parentesco
                                        WHERE p.id_gerente = ".$this->session->userdata('id_usuario')." AND oxc.id_catalogo = 26");
                break;
            case '6': // ASISTENTE GERENTE
                return $this->db->query("SELECT rp.id_referencia, rp.id_prospecto, rp.nombre, CONCAT (p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) nombre_prospecto, 
                                        rp.telefono, oxc.nombre parentesco, rp. fecha_creacion, rp.estatus FROM referencias_prospeccion rp
                                        INNER JOIN prospectos p ON p.id_prospecto = rp.id_prospecto
                                        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = rp.parentesco
                                        WHERE p.id_gerente = ".$this->session->userdata('id_lider')." AND oxc.id_catalogo = 26");
                break;
            case '9': // COORDINADOR
                return $this->db->query("SELECT rp.id_referencia, rp.id_prospecto, rp.nombre, CONCAT (p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) nombre_prospecto, 
                                        rp.telefono, oxc.nombre parentesco, rp. fecha_creacion, rp.estatus FROM referencias_prospeccion rp
                                        INNER JOIN prospectos p ON p.id_prospecto = rp.id_prospecto
                                        WHERE p.id_coordinador = ".$this->session->userdata('id_usuario')." AND oxc.id_catalogo = 26");
                break;
            case '7': // ASESOR
                return $this->db->query("SELECT rp.id_referencia, rp.id_prospecto, rp.nombre, CONCAT (p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) nombre_prospecto, 
                                        rp.telefono, oxc.nombre parentesco, rp. fecha_creacion, rp.estatus FROM referencias_prospeccion rp
                                        INNER JOIN prospectos p ON p.id_prospecto = rp.id_prospecto
                                        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = rp.parentesco
                                        WHERE p.id_asesor = ".$this->session->userdata('id_usuario')." AND oxc.id_catalogo = 26");
                break;
            case '1': // DIRECTOR
            case '4': // ASISTENTE DIRECTOR
            default: // VE TODOS LOS REGISTROS
                return $this->db->query("SELECT rp.id_referencia, rp.id_prospecto, rp.nombre, CONCAT (p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) nombre_prospecto, 
                                        rp.telefono, oxc.nombre parentesco, rp. fecha_creacion, rp.estatus FROM referencias_prospeccion rp
                                        INNER JOIN prospectos p ON p.id_prospecto = rp.id_prospecto
                                        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = rp.parentesco
                                        WHERE oxc.id_catalogo = 26");
                break;
        }

    }

    function VerInformacionVentas($id_prospecto){
    	        if($this->session->userdata('id_rol') == 9) {
    	        	return $this->db->query("SELECT p.id_asesor, CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_asesor,
                                u.id_usuario id_coordinador, u.telefono telefono_coordinador, CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno, '') nombre_coordinador,
                                uu.id_usuario id_gerente, uu.telefono telefono_gerente, CONCAT (uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno, '') nombre_gerente
                                FROM prospectos p 
								INNER JOIN usuarios u ON u.id_usuario = p.id_asesor 
								INNER JOIN usuarios uu ON uu.id_usuario = p.id_coordinador
                                INNER JOIN usuarios uuu ON uuu.id_usuario = p.id_gerente
                                WHERE p.id_prospecto  = $id_prospecto");
    	        } else {
    	        	return $this->db->query("SELECT p.id_asesor, CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_asesor,
                                uu.id_usuario id_coordinador, uu.telefono telefono_coordinador, CONCAT (uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno, '') nombre_coordinador,
                                uuu.id_usuario id_gerente, uuu.telefono telefono_gerente, CONCAT (uuu.nombre, ' ', uuu.apellido_paterno, ' ', uuu.apellido_materno, '') nombre_gerente
                                FROM prospectos p 
								INNER JOIN usuarios u ON u.id_usuario = p.id_asesor 
								INNER JOIN usuarios uu ON uu.id_usuario = u.id_lider
                                INNER JOIN usuarios uuu ON uuu.id_usuario = uu.id_lider
                                WHERE p.id_prospecto  = $id_prospecto");
    	        }
        
    }

    function VerInformacionMktd(){
    	return $this->db->query("SELECT CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) gerente, u.telefono telefono_gerente,
								CONCAT (uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) subdirector, uu.telefono telefono_subdirector
								FROM usuarios u
								INNER JOIN usuarios uu ON uu.id_usuario = u.id_lider
								WHERE u.id_sede IN( ".$this->session->userdata('id_sede').") AND u.id_rol = 20 AND u.estatus = 1");        
    }

    function getProspectInformation($id_prospecto){
        return $this->db->query("SELECT * FROM prospectos WHERE id_prospecto = ".$id_prospecto."");
    }

    function getAuthorizationDetails($idLote){
        $condicion;
        if($this->session->userdata('id_rol') == 1)
        {
            $condicion ='';
            $query = $this->db-> query('SELECT res.nombreResidencial, cond.nombre AS nombreCondominio, lotes.nombreLote, aut.estatus,
                                        aut.autorizacion, aut.fecha_creacion, users.usuario AS sol, users1.usuario AS aut, id_autorizacion, aut.idLote
                                        FROM autorizaciones aut
                                        INNER JOIN lotes ON lotes.idLote = aut.idLote 
                                        INNER JOIN condominios cond ON cond.idCondominio = lotes.idCondominio 
                                        INNER JOIN residenciales res ON res.idResidencial = cond.idResidencial 
                                        INNER JOIN usuarios AS users ON aut.id_sol = users.id_usuario 
                                        INNER JOIN usuarios AS users1 ON aut.id_aut = users1.id_usuario 
                                        WHERE aut.estatus = 3 AND '.$condicion.' lotes.idLote='.$idLote);

        } else {
            $condicion = ' autorizaciones.id_aut ='.$this->session->userdata('id_usuario').' AND';
            $query = $this->db-> query("SELECT residencial.nombreResidencial, condominio.nombre AS nombreCondominio, 
                                        lotes.nombreLote, autorizaciones.estatus, lotes.idLote, condominio.idCondominio,
                                        autorizaciones.autorizacion, autorizaciones.fecha_creacion, id_autorizacion, autorizaciones.idLote,
                                        CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) AS sol, 
                                        CONCAT(autorizador.nombre,' ', autorizador.apellido_paterno, ' ', autorizador.apellido_materno) AS aut
                                        FROM autorizaciones 
                                        INNER JOIN lotes ON lotes.idLote = autorizaciones.idLote 
                                        INNER JOIN condominios condominio ON condominio.idCondominio = lotes.idCondominio 
                                        INNER JOIN residenciales residencial ON residencial.idResidencial = condominio.idResidencial 
                                        INNER JOIN usuarios AS asesor ON autorizaciones.id_sol = asesor.id_usuario 
                                        INNER JOIN usuarios AS autorizador ON autorizaciones.id_aut = autorizador.id_usuario
                                        WHERE ".$condicion." lotes.idLote=".$idLote);
        }

        return $query->result_array();
    }

    function getAuthorizationsBySubdirector(){
        $query = $this->db-> query("SELECT  residencial.nombreResidencial, condominio.nombre as nombreCondominio, 
                                    lotes.nombreLote, autorizaciones.estatus,  autorizaciones.id_autorizacion, autorizaciones.fecha_creacion,
                                    UPPER(autorizaciones.autorizacion) AS autorizacion, id_aut, cl.id_cliente, condominio.idCondominio,
                                    users.usuario as sol,   autorizaciones.idLote,
                                    CONCAT(cl.nombre,' ', cl.apellido_paterno,' ', cl.apellido_materno) as cliente,
                                    CONCAT(asesor.nombre,' ', asesor.apellido_paterno,' ', asesor.apellido_materno) as asesor, ha.autorizacion comentario
                                    FROM autorizaciones 
                                    INNER JOIN lotes on lotes.idLote = autorizaciones.idLote 
                                    INNER JOIN condominios as condominio on condominio.idCondominio = lotes.idCondominio 
                                    INNER JOIN residenciales as residencial on residencial.idResidencial = condominio.idResidencial
                                    INNER JOIN usuarios as users on autorizaciones.id_sol = users.id_usuario
                                    INNER JOIN clientes as cl ON autorizaciones.idCliente=cl.id_cliente
                                    INNER JOIN usuarios as asesor ON cl.id_asesor=asesor.id_usuario
                                    INNER JOIN historial_autorizaciones as ha ON ha.id_autorizacion = autorizaciones.id_autorizacion
                                    WHERE autorizaciones.id_aut = ".$this->session->userdata('id_usuario')." AND ha.estatus != 1");
        return $query->result();
    }

    function getClubMaderasSales(){
        $query = $this->db-> query("SELECT r.nombreResidencial residencial, cc.nombre condominio, l.nombreLote lote, CONCAT(clc.primerNombre, ' ', clc.segundoNombre, ' ', clc.apellidoPaterno, ' ', clc.apellidoMaterno) cliente,
                                    ac.nombreAsesor asesor, ds.fechaCrate fecha FROM deposito_seriedad_consulta ds 
                                    INNER JOIN lotes_consulta l ON l.idCliente = ds.idCliente
                                    INNER JOIN condominios cc ON cc.idCondominio = l.idCondominio
                                    INNER JOIN residenciales r ON r.idResidencial = cc.idResidencial
                                    INNER JOIN cliente_consulta clc ON clc.idCliente = ds.idCliente
                                    INNER JOIN asesor_consulta ac ON ac.idAsesor = clc.idAsesor
                                    WHERE ds.especificar = 12
                                    UNION ALL
                                    SELECT r.nombreResidencial residencial, cc.nombre condominio, l.nombreLote lote, CONCAT(c.nombre, ' ', c.apellido_paterno, c.apellido_materno) cliente,
                                    CONCAT(u.nombre, ' ', u.apellido_paterno, u.apellido_materno) asesor, ds.fechaCrate fecha FROM clientes c 
                                    INNER JOIN lotes l ON l.idLote = c.idLote
                                    INNER JOIN condominios cc ON cc.idCondominio = l.idCondominio
                                    INNER JOIN residenciales r ON r.idResidencial = cc.idResidencial
                                    INNER JOIN usuarios u ON c.id_asesor = u.id_usuario
                                    INNER JOIN deposito_seriedad ds ON ds.id_cliente = c.id_cliente
                                    WHERE c.lugar_prospeccion = 12");
        return $query->result();
    }

    function getAuthorizationsByDirector() {
        $query = $this->db-> query("SELECT  residencial.nombreResidencial, condominio.nombre as nombreCondominio, 
                                    lotes.nombreLote, autorizaciones.estatus,  autorizaciones.id_autorizacion, autorizaciones.fecha_creacion,
                                    autorizaciones.autorizacion, id_aut, cl.id_cliente, condominio.idCondominio,
                                    users.usuario as sol,   autorizaciones.idLote,
                                    CONCAT(cl.nombre,' ', cl.apellido_paterno,' ', cl.apellido_materno) as cliente,
                                    CONCAT(asesor.nombre,' ', asesor.apellido_paterno,' ', asesor.apellido_materno) as asesor
                                    FROM autorizaciones 
                                    INNER JOIN lotes on lotes.idLote = autorizaciones.idLote 
                                    INNER JOIN condominios as condominio on condominio.idCondominio = lotes.idCondominio 
                                    INNER JOIN residenciales as residencial on residencial.idResidencial = condominio.idResidencial
                                    INNER JOIN usuarios as users on autorizaciones.id_sol = users.id_usuario
                                    INNER JOIN clientes as cl ON autorizaciones.idCliente=cl.id_cliente
                                    INNER JOIN usuarios as asesor ON cl.id_asesor=asesor.id_usuario
                                    WHERE cl.status = 1 AND aut.estatus=3");
        return $query->result();
    }
    
    function getReferenceInformation($id_referencia){
        return $this->db->query("SELECT * FROM referencias_prospeccion WHERE id_referencia = ".$id_referencia."");
    }

    function getCoOwnerInformation($id_copropietario){
        return $this->db->query("SELECT * FROM copropietarios_prospeccion WHERE id_copropietario = ".$id_copropietario."");
    }

    function getManagersMktd(){
        return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                id_rol = 20 AND id_sede IN (".$this->session->userdata('id_sede').") AND estatus = 1
                                UNION SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, 
                                CASE id_usuario WHEN 1981 THEN 1 WHEN 1988 THEN 5 END id_sede
                                FROM usuarios 
                                WHERE id_usuario = ".$this->session->userdata('id_usuario')." ORDER BY nombre");
    }

    function getManagers(){
        return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                id_rol = 3 AND estatus = 1 AND id_usuario NOT BETWEEN 2535 AND 2555 ORDER BY nombre");
    }

    function getCoordinatorsByManager($id_gerente){
        return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                id_rol = 9 AND id_lider = ".$id_gerente." AND estatus = 1 ORDER BY nombre");
    }

    function getAdvisersByCoordinator($id_coordinador){
        return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                id_rol = 7 AND id_lider = ".$id_coordinador." AND estatus = 1 ORDER BY nombre");
    }

    function getCoordinators(){
        return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                id_rol = 9 AND id_sede IN (".$this->session->userdata('id_sede').") AND estatus = 1 ORDER BY nombre");
    }

    function getProspects(){
        switch ($this->session->userdata('id_rol')) {
            case '2': // SUBDIRECTOR
            case '5': // ASISTENTE SUBDIRECTOR
                return $this->db->query("SELECT id_prospecto, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM prospectos WHERE 
                                        id_sede IN (".$this->session->userdata('id_usuario').") AND estatus = 1 AND lugar_prospeccion != 6 ORDER BY nombre");
            break;
            case '3': // GERENTE
                return $this->db->query("SELECT id_prospecto, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM prospectos WHERE 
                                        id_gerente = ".$this->session->userdata('id_usuario')." AND estatus = 1 AND lugar_prospeccion != 6 ORDER BY nombre");
            break;
            case '6': // ASISTENTE GERENTE
                return $this->db->query("SELECT id_prospecto, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM prospectos WHERE 
                                        id_gerente = ".$this->session->userdata('id_lider')." AND estatus = 1 AND lugar_prospeccion != 6 ORDER BY nombre");
            break;
            case '9': // COORDINADOR
                return $this->db->query("SELECT id_prospecto, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM prospectos WHERE 
                                        id_coordinador = ".$this->session->userdata('id_usuario')." AND estatus = 1 AND lugar_prospeccion != 6 ORDER BY nombre");
            break;
            case '7': // ASESOR
                return $this->db->query("SELECT id_prospecto, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM prospectos WHERE 
                                        id_asesor = ".$this->session->userdata('id_usuario')." AND estatus = 1 ORDER BY nombre");
            break;
            case '1': // DIRECTOR
            case '4': // ASISTENTE DIRECTOR
            default: // VE TODOS LOS REGISTROS
                return $this->db->query("SELECT id_prospecto, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM prospectos WHERE 
                                        estatus = 1 AND lugar_prospeccion != 6 ORDER BY nombre");
            break;
        }
    }

    function getAllAdvisers(){
        return $this->db->query("SELECT u.id_usuario id_asesor, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', ISNULL(u.apellido_materno, '')) nombre_asesor,
                                uu.id_usuario id_coordinador, uuu.id_usuario id_gerente FROM usuarios u 
                                INNER JOIN usuarios uu ON uu.id_usuario = u.id_lider
                                INNER JOIN usuarios uuu ON uuu.id_usuario = uu.id_lider
                                WHERE u.id_rol = 7 AND u.estatus = 1 AND u.id_usuario NOT IN (".$this->session->userdata('id_usuario').") ORDER BY nombre_asesor");
    }

    function getAdvisers($id_sede){
        return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                id_rol IN (7, 9) AND id_sede = '".$id_sede."' AND estatus = 1 ORDER BY nombre");
    }

    function getAdvisersM(){
        return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                id_rol = 7 AND id_sede IN (".$this->session->userdata('id_sede').") AND estatus = 1
                                UNION ALL
                                SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                id_usuario = (".$this->session->userdata('id_usuario').") AND estatus = 1 ORDER BY nombre");
    }

    function getInformationToPrint($id_prospecto){
        return $this->db->query(
            "SELECT p.id_prospecto, p.id_asesor, p.id_coordinador, p.id_gerente,
                    CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS  nombre, 
                    oxc.nombre AS personalidad_juridica,
                    p.rfc, p.curp, p.correo, p.telefono, 
                    p.telefono_2, p.observaciones,
                    oxc2.nombre AS lugar_prospeccion, 
                    P.otro_lugar,
                    oxc3.nombre AS plaza_venta, 
                    oxc4.nombre AS nacionalidad,
                    us.telefono tel_asesor,
                    us2.telefono tel_coordinador,
                    us3.telefono tel_gerente,
                    CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) AS asesor, 
                    CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) AS coordinador,
                    CONCAT(us3.nombre, ' ', us3.apellido_paterno, ' ', us3.apellido_materno) AS gerente
            FROM prospectos p 
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = p.personalidad_juridica AND oxc.id_catalogo = 10
            LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = p.lugar_prospeccion AND oxc2.id_catalogo = 9
            LEFT JOIN opcs_x_cats oxc3 ON oxc3.id_opcion = p.plaza_venta AND oxc3.id_catalogo = 5
            LEFT JOIN opcs_x_cats oxc4 ON oxc4.id_opcion = p.nacionalidad AND oxc4.id_catalogo = 11
            LEFT JOIN usuarios us ON us.id_usuario = p.id_asesor
            LEFT JOIN usuarios us2 ON us2.id_usuario = p.id_coordinador
            LEFT JOIN usuarios us3 ON us3.id_usuario = p.id_gerente
            WHERE p.id_prospecto = $id_prospecto");
    }

    function saveProspect($data) {
        /*echo json_encode($data);
        if ($data.nacionalidad != '' && $data.nombre != '' && $data.personalidad_juridica != '' && $data.correo != '' && $data.telefono != ''
            && $data.lugar_prospeccion != '' && $data.medio_publicitario != '' && $data.plaza_venta != '') {*/
            $response = $this->db->insert("prospectos", $data);
            if (! $response ) {
                return $finalAnswer = 0;
            } else {
                return $finalAnswer = 1;
            }
        /*} else {
            return 0;
        }*/
    }

    function saveCoOwner($data) {
        /*echo json_encode($data);
        if ($data.nacionalidad != '' && $data.nombre != '' && $data.personalidad_juridica != '' && $data.correo != '' && $data.telefono != ''
            && $data.lugar_prospeccion != '' && $data.medio_publicitario != '' && $data.plaza_venta != '') {*/
        $response = $this->db->insert("copropietarios_prospeccion", $data);
        if (! $response ) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
        /*} else {
            return 0;
        }*/
    }

    function getComments($prospecto){
        return $this->db->query("SELECT observacion, CONVERT(varchar, fecha_creacion, 20) AS fecha_creacion, creador
            FROM observaciones
            INNER JOIN (SELECT id_usuario AS id_creador, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS creador FROM usuarios) AS creadores ON creadores.id_creador = observaciones.creado_por
            WHERE id_prospecto = $prospecto  ORDER BY fecha_creacion DESC");
    }

    function getPrintableInformation($id_prospecto)
    {
        return $this->db->query("SELECT id_prospecto, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS cliente, rfc, telefono, telefono_2, correo, personalidad, nacionalidades.nacionalidad, 
        REPLACE(curp, '<', '') AS curp,
                                lugar, otro_lugar, plaza, asesor, telefono_asesor, gerente, telefono_gerente, coordinador, telefono_coordinador, CONCAT(creador, ' ', fecha_creacion) as creacion, p.id_sede, p.id_coordinador, p.id_gerente FROM prospectos p
                                LEFT JOIN (SELECT id_opcion AS id_personalidad, nombre AS personalidad FROM opcs_x_cats WHERE id_catalogo LIKE 10) AS personalidades ON personalidades.id_personalidad = p.personalidad_juridica
                                LEFT JOIN (SELECT id_opcion AS id_nacionalidad, nombre AS nacionalidad FROM opcs_x_cats WHERE id_catalogo LIKE 11) AS nacionalidades ON nacionalidades.id_nacionalidad = p.nacionalidad
                                LEFT JOIN (SELECT id_opcion AS id_lugar, nombre AS lugar FROM opcs_x_cats WHERE id_catalogo LIKE 9) AS lugares ON lugares.id_lugar = p.lugar_prospeccion
                                LEFT JOIN (SELECT id_opcion AS id_plaza, nombre AS plaza FROM opcs_x_cats WHERE id_catalogo LIKE 5) AS plazas ON plazas.id_plaza = p.plaza_venta
                                LEFT JOIN (SELECT id_usuario AS id_asesor, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS asesor, telefono AS telefono_asesor FROM usuarios) AS asesores ON asesores.id_asesor = p.id_asesor
                                LEFT JOIN (SELECT id_usuario AS id_gerente, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS gerente, telefono AS telefono_gerente FROM usuarios) AS gerentes ON gerentes.id_gerente = p.id_gerente
                                LEFT JOIN (SELECT id_usuario AS id_coordinador, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS coordinador, telefono AS telefono_coordinador FROM usuarios) AS coordinadores ON coordinadores.id_coordinador = p.id_coordinador
                                LEFT JOIN (SELECT id_usuario AS id_creador, CONCAT(apellido_paterno, ' ', apellido_materno, ' ', nombre) AS creador FROM usuarios) AS creadores ON creadores.id_creador = p.creado_por
                                WHERE id_prospecto = $id_prospecto");
    }

    function getProspectSpecification($id_prospecto){
        return $this->db->query("SELECT ISNULL(p.id_prospecto, '') prospecto, ISNULL(p.otro_lugar, '') especificar FROM prospectos p 
                                WHERE p.id_prospecto = $id_prospecto AND p.lugar_prospeccion IN (3, 6, 7, 9, 10)");
    }

    function getChangelog($prospecto){
        return $this->db->query("SELECT CONVERT(VARCHAR,fecha_creacion,20) AS fecha_creacion, isNULL(creador, cambios.creado_por) creador, UPPER(parametro_modificado) AS parametro_modificado,UPPER((
            CASE 
                WHEN parametro_modificado = 'Nacionalidad' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 11)
                WHEN parametro_modificado = 'Personalidad jurídica' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 10)
                WHEN parametro_modificado = 'Asesor' THEN (SELECT CONCAT( apellido_paterno,' ',apellido_materno,' ',nombre) as nombre FROM usuarios WHERE id_usuario = nuevo)
                WHEN parametro_modificado = 'Sede' THEN (SELECT nombre FROM sedes WHERE id_sede = nuevo)
                WHEN parametro_modificado = 'Coordinador' THEN (SELECT CONCAT( apellido_paterno,' ',apellido_materno,' ',nombre) as nombre FROM usuarios WHERE id_usuario = nuevo)
                WHEN parametro_modificado = 'Gerente' THEN (SELECT CONCAT( apellido_paterno,' ',apellido_materno,' ',nombre) as nombre FROM usuarios WHERE id_usuario = nuevo)
                WHEN parametro_modificado = 'Tipo' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 8)
                WHEN parametro_modificado = 'Lugar de prospección' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 9)
                WHEN parametro_modificado = 'Plaza de venta' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 5)
                WHEN parametro_modificado = 'Zona de venta' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 6)
                WHEN parametro_modificado = 'Método de prospección' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 7)
                WHEN parametro_modificado = 'Estado civil' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 18)
                WHEN parametro_modificado = 'Régimen Matrimonial' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 19)
                WHEN parametro_modificado = 'Tpo vivienda' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 20)
                WHEN parametro_modificado = 'Estatus vigencia' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 3)
                WHEN parametro_modificado = 'Estatus prospecto' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 38)
                ELSE nuevo  
            END)) AS nuevo,UPPER((
            CASE 
                WHEN parametro_modificado = 'Nacionalidad' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 11)
                WHEN parametro_modificado = 'Personalidad jurídica' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 10)
                WHEN parametro_modificado = 'Asesor' THEN (SELECT CONCAT( apellido_paterno,' ',apellido_materno,' ',nombre) as nombre FROM usuarios WHERE id_usuario = anterior)
                WHEN parametro_modificado = 'Sede' THEN (SELECT nombre FROM sedes WHERE id_sede = anterior)
                WHEN parametro_modificado = 'Coordinador' THEN (SELECT CONCAT( apellido_paterno,' ',apellido_materno,' ',nombre) as nombre FROM usuarios WHERE id_usuario = anterior)
                WHEN parametro_modificado = 'Gerente' THEN (SELECT CONCAT( apellido_paterno,' ',apellido_materno,' ',nombre) as nombre FROM usuarios WHERE id_usuario = anterior)
                WHEN parametro_modificado = 'Tipo' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 8)
                WHEN parametro_modificado = 'Lugar de prospección' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 9)
                WHEN parametro_modificado = 'Plaza de venta' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 5)
                WHEN parametro_modificado = 'Zona de venta' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 6)
                WHEN parametro_modificado = 'Método de prospección' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 7)
                WHEN parametro_modificado = 'Estado civil' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 18)
                WHEN parametro_modificado = 'Régimen matrimonial' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 19)
                WHEN parametro_modificado = 'Tpo vivienda' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 20)
                WHEN parametro_modificado = 'Estatus vigencia' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 3)
                WHEN parametro_modificado = 'Estatus prospecto' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 38)
                ELSE anterior  
            END)) AS anterior
            FROM cambios
            LEFT JOIN (SELECT id_usuario AS id_creador, CONCAT(nombre, ' ', apellido_paterno,' ',apellido_materno) AS creador  FROM usuarios) AS creadores ON CAST(id_creador as VARCHAR(45)) = creado_por
            WHERE id_prospecto = $prospecto ORDER BY fecha_creacion DESC");
    }

    function saveComment($id_usuario, $id_prospecto, $comentario) {
	    if ($id_prospecto != '' && $comentario) {
            $response = $this->db->insert("observaciones", array(
                "id_prospecto" => $id_prospecto,
                "observacion" => $comentario,
                "creado_por" => $id_usuario
            ));
            if (!$response) {
                return $finalAnswer = 0;
            } else {
                return $finalAnswer = 1;
            }
        } else {
	        return 0;
        }
    }

    function saveSalesPartner($data) {
        if ($data != '' && $data != null) {
            $response = $this->db->insert("ventas_compartidas_prospeccion", $data);
            if (!$response) {
                return $finalAnswer = 0;
            } else {
                return $finalAnswer = 1;
            }
        } else {
            return 0;
        }
    }

    function saveReference($data) {
        if ($data != '' && $data != null) {
            $response = $this->db->insert("referencias_prospeccion", $data);
            if (!$response) {
                return $finalAnswer = 0;
            } else {
                return $finalAnswer = 1;
            }
        } else {
            return 0;
        }
    }

    function updateProspect($data, $id_prospecto) {
        $response = $this->db->update("prospectos", $data, "id_prospecto = $id_prospecto");
        if (! $response ) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

    function updateReference($data, $id_referencia) {
        $response = $this->db->update("referencias_prospeccion", $data, "id_referencia = $id_referencia");
        if (! $response ) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

//    function reasignProspect($data, $id_prospecto) {
//        $response = $this->db->update("prospectos", $data, "id_prospecto = $id_prospecto");
//        if (! $response ) {
//            return $finalAnswer = 0;
//        } else {
//            return $finalAnswer = 1;
//        }
//    }

    function updateValidity($data, $id_prospecto) {
        $response = $this->db->update("prospectos", $data, "id_prospecto = $id_prospecto");
        if (! $response ) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

    function changeSalesPartnerStatus($data, $id_vcompartida) {
        $response = $this->db->update("ventas_compartidas_prospeccion", $data, "id_vcompartida = $id_vcompartida");
        if (! $response ) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

    function changeTitualar($data, $id_cliente) {
        $response = $this->db->update("clientes", $data, "id_cliente = $id_cliente");
        if (! $response ) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

    function changeCoOwnerStatus($data, $id_vcompartida) {
        $response = $this->db->update("copropietarios_prospeccion", $data, "id_copropietario = $id_vcompartida");
        if (! $response ) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

    function updateCoOwner($data, $id_copropietario) {
        $response = $this->db->update("copropietarios_prospeccion", $data, "id_copropietario = $id_copropietario");
        if (! $response ) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

    function changeReferenceStatus($data, $id_referencia) {
        $response = $this->db->update("referencias_prospeccion", $data, "id_referencia = $id_referencia");
        if (! $response ) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

    function getSubdirs()
    {
        $this->db->select("*");
        $this->db->where('id_rol', 2);
        $this->db->where('estatus', 1);
        $query = $this->db->get('usuarios');
        return $query->result();
    }
    function getSubdirs_mkt()
    {
        $this->db->select("*");
        $this->db->where('id_rol', 19);
        $this->db->where('estatus', 1);
        $this->db->where('id_lider', $this->session->userdata('id_usuario'));
        $query = $this->db->get('usuarios');
        return $query->result();
    }
    function getGerentesBySubdir($id_subdir)
    {
        $this->db->select("*");
        $this->db->where('id_rol', 3);
        $this->db->where('estatus', 1);
        $this->db->where('id_lider', $id_subdir);
        $query = $this->db->get('usuarios');
        return $query->result();
    }
    function getGerentesBySubdir_mkt($id_subdir)
    {
        $query = $this->db->query("SELECT * FROM usuarios WHERE id_rol = 20 AND estatus = 1 AND id_lider = $id_subdir OR id_usuario = 1988");
        return $query->result();
    }
    function getGerentesBySubdir_ASB()
    {
        $this->db->select("*");
        $this->db->where('id_rol', 3);
        $this->db->where('estatus', 1);
        $this->db->where('id_lider', $this->session->userdata('id_lider'));
        $query = $this->db->get('usuarios');
        return $query->result();
    }

    function getCoordsByGrs($id_gerente) {
        return $this->db
            ->query(
                "SELECT * 
                FROM usuarios 
                WHERE  (id_rol = 9 AND id_lider = $id_gerente) OR 
                        (id_usuario = $id_gerente)
                ORDER BY nombre, apellido_paterno, apellido_materno")
            ->result();
    }

    function getAsesorByCoords($id_coords) {
        $query = $this->db->query("SELECT * FROM usuarios WHERE id_rol = 7 AND id_lider = $id_coords ORDER BY nombre, apellido_paterno, apellido_materno");
        return $query->result();
    }


    function getProspectsListBySubdir($id_sede)
    {
    	switch ($this->session->userdata('id_rol')) {
            case '18': // SUBDIRECTOR
            case '19': // SUBDIRECTOR
            case '20': // SUBDIRECTOR
            case '28': // SUBDIRECTOR
             $query = $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre, c.vigencia,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                        c.fecha_creacion, c.fecha_vencimiento, c.estatus
                                        FROM prospectos c
                                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        WHERE c.estatus_vigencia = 1 AND c.id_sede =".$id_sede." AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
            break;
            default:
             $query = $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre, c.vigencia,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                        c.fecha_creacion, c.fecha_vencimiento, c.estatus
                                        FROM prospectos c
                                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        WHERE c.estatus_vigencia = 1 AND c.id_sede =".$id_sede." AND c.tipo = 0 AND c.lugar_prospeccion != 6 ORDER BY c.fecha_creacion DESC");
            break;
        }
        return $query->result();
    }

    function getProspectsListByGerente($id_gerente, $typeTransaction, $beginDate, $endDate, $where)

    {
        if ($typeTransaction == 1 || $typeTransaction == 3) {  // FIRST LOAD || SEARCH BY DATE RANGE
            $filter = " AND c.fecha_creacion BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
            //$this->db->where("c.fecha_creacion BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'");
        }
        /**/
        switch ($this->session->userdata('id_rol')) {
            case '19': // SUBDIRECTOR MKTD
                $query = $this->db->query(
                    "SELECT c.id_prospecto, c.vigencia, c.tipo, c.telefono, c.telefono_2,
                            CONVERT(VARCHAR, c.fecha_vencimiento, 20) AS fecha_vencimiento,
                            CONVERT(VARCHAR, c.fecha_creacion, 20) AS fecha_creacion,
                            UPPER(CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno)) nombre,
                            CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor,
                            CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador,
                            CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente,
                            c.estatus, c.estatus_particular, c.lugar_prospeccion, UPPER(oxc.nombre) AS nombre_lp,
                    FROM prospectos c
                    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                    LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                    WHERE   c.estatus_vigencia = 1 AND
                            c.id_sede IN($id_gerente) AND 
                            c.lugar_prospeccion = 6 AND
                            c.tipo = 0 OR 
                            c.tipo = 1 ".$filter."
                    ORDER BY c.fecha_creacion DESC");
            break;

            default:
                $query = $this->db->query(
                    "SELECT c.id_prospecto, c.vigencia, c.estatus, c.estatus_particular,
                            c.lugar_prospeccion, UPPER(oxc.nombre) AS nombre_lp, c.tipo, c.telefono, c.telefono_2,
                            CONVERT(VARCHAR, c.fecha_creacion, 20) AS fecha_creacion,
                            CONVERT(VARCHAR, c.fecha_vencimiento, 20) AS fecha_vencimiento,
                            UPPER(CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno)) nombre,
                            CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor,
                            CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador,
                            CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente
                    FROM prospectos c
                    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                    LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                    WHERE   c.estatus_vigencia = 1 AND 
                            c.id_gerente = ".$id_gerente." AND 
                            c.tipo IN(0,1) ".$filter."
                    ORDER BY c.fecha_creacion DESC");
            break;
        }
       
        return $query->result();
    }

    function getProspectsListByCoord($id_coord, $typeTransaction, $beginDate, $endDate, $where)
    {
        if ($typeTransaction == 1 || $typeTransaction == 3) {  // FIRST LOAD || SEARCH BY DATE RANGE
            $filter = " AND c.fecha_creacion BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
            //$this->db->where("c.fecha_creacion BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'");
        }
        switch ($this->session->userdata('id_rol')) {
            case '19': // SUBDIRECTOR MKTD
                $query = $this->db->query(
                    "SELECT c.id_prospecto, c.vigencia, c.tipo, c.telefono, c.telefono_2,
                            UPPER(CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno)) AS nombre,
                            CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                            CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                            CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                            CONVERT(VARCHAR, c.fecha_creacion, 20) AS fecha_creacion, 
                            CONVERT(VARCHAR, c.fecha_vencimiento, 20) AS fecha_creacion,
                            c.estatus,c.estatus_particular, c.lugar_prospeccion, UPPER(oxc.nombre) AS nombre_lp
                    FROM prospectos c 
                    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                    LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                    WHERE   c.estatus_vigencia = 1 AND
                            c.id_sede IN($id_coord) AND
                            c.lugar_prospeccion = 6 AND
                            c.tipo = 0 OR
                            c.tipo = 1 $filter
                    ORDER BY c.fecha_creacion DESC");
            break;
            default:
                $query = $this->db->query(
                    "SELECT c.id_prospecto, c.vigencia, c.tipo, c.telefono, c.telefono_2,
                            UPPER(CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno)) nombre,
                            CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                            CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                            CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                            CONVERT(VARCHAR, c.fecha_creacion, 20) AS fecha_creacion,
                            CONVERT(VARCHAR, c.fecha_vencimiento, 20) AS fecha_vencimiento,
                            c.estatus,c.estatus_particular, c.lugar_prospeccion, UPPER(oxc.nombre) AS nombre_lp
                    FROM prospectos c 
                    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                    LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                    WHERE   c.estatus_vigencia = 1 AND
                            (c.id_coordinador = ".$id_coord.") AND 
                            c.tipo IN(0,1) ".$filter." 
                    ORDER BY c.fecha_creacion DESC");
            break;
        }
        
        return $query->result();
    }

    public function getProspectsListByAsesor($id_asesor, $typeTransaction, $beginDate, $endDate, $where)
    {
        if ($typeTransaction == 1 || $typeTransaction == 3) {  // FIRST LOAD || SEARCH BY DATE RANGE
            $filter = " AND c.fecha_creacion BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
            //$this->db->where("c.fecha_creacion BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'");
        }
        /**/
        switch ($this->session->userdata('id_rol')) {
            case '18': // SUBDIRECTOR
            case '19': // SUBDIRECTOR
            case '20': // SUBDIRECTOR
            default:
                $query = $this->db->query(
                    "SELECT c.id_prospecto, c.vigencia, c.tipo, c.telefono, c.telefono_2,
                            CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
                            CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                            CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                            CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                            CONVERT(VARCHAR, c.fecha_creacion, 20) AS fecha_creacion,
                            CONVERT(VARCHAR, c.fecha_vencimiento, 20) AS fecha_vencimiento,
                            c.estatus, UPPER(c.lugar_prospeccion) AS lugar_prospeccion, UPPER(oxc.nombre) nombre_lp, c.estatus_particular
                FROM prospectos c 
                LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                WHERE (c.id_asesor = $id_asesor) $filter 
                ORDER BY c.fecha_creacion DESC");
            break;
            case '28': // SUBDIRECTOR
                $query = $this->db->query(
                    "SELECT c.id_prospecto, c.vigencia, c.otro_lugar, c.tipo, c.telefono, c.telefono_2,
                        CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                        CONVERT(VARCHAR, c.fecha_creacion, 20) AS fecha_creacion,
                        CONVERT(VARCHAR, c.fecha_vencimiento, 20) AS fecha_vencimiento, 
                        c.estatus, c.lugar_prospeccion, UPPER(oxc.nombre) nombre_lp, c.estatus_particular
                    FROM prospectos c 
                    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                    LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                    WHERE   c.lugar_prospeccion = 6 AND 
                            c.estatus_vigencia = 1 AND
                            (c.id_asesor = ".$id_asesor.")
                            AND c.tipo IN(0,1) ".$filter." 
                    ORDER BY c.fecha_creacion DESC");
            break;
        }
        return $query->result();
    }
    /***************************/

    function getProspByName($name_prospect)
    {
        switch ($this->session->userdata('id_rol')) {
            case '18': // DIRECTOR MKTD
                case '19': // SUBDIRECTOR MKTD
                case '20': // GERENTE
                case '28': // COBRANZA
                case '13': // CONTRALORÍA
                case '32': // CONTRALORÍA CORPORATIVA
                $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                                    CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                    CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                    CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                    c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                                    FROM prospectos c 
                                    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                                    WHERE c.nombre LIKE '%".$name_prospect."%' AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                break;
            default:
                $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                                    CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                    CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                    CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                    c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                                    FROM prospectos c 
                                    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9 AND c.lugar_prospeccion != 6
                                    WHERE c.nombre LIKE '%".$name_prospect."%' AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                break;
        }
        return $query->result();
    }

    function getProspByMail($correo_prospect)
    {
    	switch ($this->session->userdata('id_rol')) {
            case '18': // DIRECTOR MKTD
                case '19': // SUBDIRECTOR MKTD
                case '20': // GERENTE
                case '28': // COBRANZA
                case '13': // CONTRALORÍA
                case '32': // CONTRALORÍA CORPORATIVA
            $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
							    CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
							    CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
							    CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
							    c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
							    FROM prospectos c 
							    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
							    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
							    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
							    WHERE c.correo='".$correo_prospect."' OR c.correo LIKE '%".$correo_prospect."%' AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
            break;
            default:
            $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
							    CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
							    CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
							    CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
							    c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
							    FROM prospectos c 
							    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
							    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
							    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9 AND c.lugar_prospeccion != 6
							    WHERE c.correo='".$correo_prospect."' OR c.correo LIKE '%".$correo_prospect."%' AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
            break;
        }
        return $query->result();
    }

    function getProspByTel($telefono_prospect)
    {
    	switch ($this->session->userdata('id_rol')) {
            case '18': // DIRECTOR MKTD
            case '19': // SUBDIRECTOR MKTD
            case '20': // GERENTE
            case '28': // COBRANZA
            case '13': // CONTRALORÍA
            case '32': // CONTRALORÍA CORPORATIVA
            $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
							    CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
							    CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
							    CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
							    c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
							    FROM prospectos c 
							    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
							    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
							    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
							    WHERE c.telefono='".$telefono_prospect."' OR c.telefono_2='".$telefono_prospect."'  AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
            break;
            default:
            $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
							    CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
							    CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
							    CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
							    c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
							    FROM prospectos c 
							    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
							    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
							    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
							    WHERE c.telefono='".$telefono_prospect."' OR c.telefono_2='".$telefono_prospect."'  AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
            break;
        }
        return $query->result();
    }

    function getProspByMailName($name_prospect, $correo_prospect)
    {
    	switch ($this->session->userdata('id_rol')) {
            case '18': // DIRECTOR MKTD
            case '19': // SUBDIRECTOR MKTD
            case '20': // GERENTE
            case '28': // COBRANZA
            case '13': // CONTRALORÍA
            case '32': // CONTRALORÍA CORPORATIVA
            $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
						        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
						        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
						        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
						        c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
						        FROM prospectos c 
						        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
						        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
						        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
						        WHERE c.nombre LIKE '%".$name_prospect."%' OR c.correo LIKE '%".$correo_prospect."%'  AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
            break;
            default:
            $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
						        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
						        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
						        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
						        c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
						        FROM prospectos c 
						        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
						        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
						        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9 AND c.lugar_prospeccion != 6
						        WHERE c.nombre LIKE '%".$name_prospect."%' OR c.correo LIKE '%".$correo_prospect."%'  AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
            break;
        }
        return $query->result();
    }

    function getProspByNameTel($name_prospect, $telefono_prospect)
    {
    	switch ($this->session->userdata('id_rol')) {
            case '18': // DIRECTOR MKTD
            case '19': // SUBDIRECTOR MKTD
            case '20': // GERENTE
            case '28': // COBRANZA
            case '13': // CONTRALORÍA
            case '32': // CONTRALORÍA CORPORATIVA
                    $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
						        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
						        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
						        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
						        c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
						        FROM prospectos c 
						        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
						        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
						        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
						        WHERE c.nombre LIKE '%".$name_prospect."%' OR c.telefono LIKE '%".$telefono_prospect."%'  
						        OR c.telefono_2 LIKE '%".$telefono_prospect."%' 
						        AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
            break;
            default:
                    $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
						        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
						        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
						        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
						        c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
						        FROM prospectos c 
						        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
						        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
						        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9 AND c.lugar_prospeccion != 6
						        WHERE c.nombre LIKE '%".$name_prospect."%' OR c.telefono LIKE '%".$telefono_prospect."%'  
						        OR c.telefono_2 LIKE '%".$telefono_prospect."%' 
						        AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
            break;
        }

        return $query->result();
    }

    function getProspByMailTel($correo_prospect, $telefono_prospect)
    {
    	switch ($this->session->userdata('id_rol')) {
            case '18': // DIRECTOR MKTD
            case '19': // SUBDIRECTOR MKTD
            case '20': // GERENTE
            case '28': // COBRANZA
            case '13': // CONTRALORÍA
            case '32': // CONTRALORÍA CORPORATIVA
                    $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
						        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
						        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
						        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
						        c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
						        FROM prospectos c 
						        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
						        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
						        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
						        WHERE c.correo LIKE '%".$correo_prospect."%' OR c.telefono LIKE '%".$telefono_prospect."%'  
						        OR c.telefono_2 LIKE '%".$telefono_prospect."%' 
						        AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
            break;
            default:
                    $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
						        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
						        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
						        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
						        c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
						        FROM prospectos c 
						        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
						        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
						        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9 AND c.lugar_prospeccion != 6
						        WHERE c.correo LIKE '%".$correo_prospect."%' OR c.telefono LIKE '%".$telefono_prospect."%'  
						        OR c.telefono_2 LIKE '%".$telefono_prospect."%' 
						        AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
            break;
        }
        return $query->result();
    }


    function getProspByAllFiels($name_prospect, $correo_prospect, $telefono_prospect)
    {
    	switch ($this->session->userdata('id_rol')) {
            case '18': // DIRECTOR MKTD
            case '19': // SUBDIRECTOR MKTD
            case '20': // GERENTE
            case '28': // COBRANZA
            case '13': // CONTRALORÍA
            case '32': // CONTRALORÍA CORPORATIVA
                    $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
						        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
						        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
						        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
						        c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
						        FROM prospectos c 
						        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
						        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
						        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
						        WHERE c.nombre LIKE '%".$name_prospect."%' OR
						        c.correo LIKE '%".$correo_prospect."%' OR c.telefono LIKE '%".$telefono_prospect."%'  
						        OR c.telefono_2 LIKE '%".$telefono_prospect."%' 
						        AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
            break;
            default:
                    $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
						        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
						        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
						        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
						        c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
						        FROM prospectos c 
						        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
						        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
						        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9 AND c.lugar_prospeccion != 6
						        WHERE c.nombre LIKE '%".$name_prospect."%' OR
						        c.correo LIKE '%".$correo_prospect."%' OR c.telefono LIKE '%".$telefono_prospect."%'  
						        OR c.telefono_2 LIKE '%".$telefono_prospect."%' 
						        AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
            break;
        }
        return $query->result();
    }
    

    /*nuuuuuuuuuevossssss*/
    function getProspByAp_Paterno($apPaterno_prospect)
    {
        switch ($this->session->userdata('id_rol')) {
            case '18': // DIRECTOR MKTD
            case '19': // SUBDIRECTOR MKTD
            case '20': // GERENTE
            case '28': // COBRANZA
            case '13': // CONTRALORÍA
            case '32': // CONTRALORÍA CORPORATIVA
                $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                    CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                    CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                    CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                    c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                    FROM prospectos c 
                    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                    WHERE c.apellido_paterno LIKE '%".$apPaterno_prospect."%' AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                break;
            default:
                $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                    CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                    CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                    CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                    c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                    FROM prospectos c 
                    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9 AND c.lugar_prospeccion != 6
                    WHERE c.apellido_paterno LIKE '%".$apPaterno_prospect."%' AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                break;
        }
        return $query->result();
    }
    function getProspByAp_Materno($apMaterno_prospect)
    {
        switch ($this->session->userdata('id_rol')) {
            case '18': // DIRECTOR MKTD
            case '19': // SUBDIRECTOR MKTD
            case '20': // GERENTE
            case '28': // COBRANZA
            case '13': // CONTRALORÍA
            case '32': // CONTRALORÍA CORPORATIVA
                $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                FROM prospectos c 
                LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                WHERE c.apellido_materno LIKE '%".$apMaterno_prospect."%' AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                break;
            default:
                $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                FROM prospectos c 
                LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9 AND c.lugar_prospeccion != 6
                WHERE c.apellido_materno LIKE '%".$apMaterno_prospect."%' AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                break;
        }
        return $query->result();
    }

    function getProspByNameApPaterno($name_prospect, $ap_paterno_prospect)
    {
        switch ($this->session->userdata('id_rol')) {
            case '18': // DIRECTOR MKTD
            case '19': // SUBDIRECTOR MKTD
            case '20': // GERENTE
            case '28': // COBRANZA
            case '13': // CONTRALORÍA
            case '32': // CONTRALORÍA CORPORATIVA
                $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                FROM prospectos c 
                LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                WHERE c.nombre LIKE '%".$name_prospect."%' OR c.apellido_paterno LIKE '%".$ap_paterno_prospect."%'  
                AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                break;
            default:
                $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                FROM prospectos c 
                LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9 AND c.lugar_prospeccion != 6
                WHERE c.nombre LIKE '%".$name_prospect."%' OR c.apellido_paterno LIKE '%".$ap_paterno_prospect."%'  
                AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                break;
        }
        return $query->result();
    }
    function getProspByNameApMaterno($name_prospect, $ap_materno_prospect)
    {
        switch ($this->session->userdata('id_rol')) {
            case '18': // DIRECTOR MKTD
            case '19': // SUBDIRECTOR MKTD
            case '20': // GERENTE
            case '28': // COBRANZA
            case '13': // CONTRALORÍA
            case '32': // CONTRALORÍA CORPORATIVA
                $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                FROM prospectos c 
                LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                WHERE c.nombre LIKE '%".$name_prospect."%' OR c.apellido_materno LIKE '%".$ap_materno_prospect."%'  
                AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                break;
            default:
                $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                FROM prospectos c 
                LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9 AND c.lugar_prospeccion != 6
                WHERE c.nombre LIKE '%".$name_prospect."%' OR c.apellido_materno LIKE '%".$ap_materno_prospect."%'  
                AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                break;
        }
        return $query->result();
    }
    function getProspByApPaternoApMaterno($ap_paterno_prospect, $ap_materno_prospect)
    {
        switch ($this->session->userdata('id_rol')) {
            case '18': // DIRECTOR MKTD
            case '19': // SUBDIRECTOR MKTD
            case '20': // GERENTE
            case '28': // COBRANZA
            case '13': // CONTRALORÍA
            case '32': // CONTRALORÍA CORPORATIVA
                $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                FROM prospectos c 
                LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                WHERE c. apellido_paterno LIKE '%".$ap_paterno_prospect."%' OR
                c.apellido_materno LIKE '%".$ap_materno_prospect."%' AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                break;
            default:
                $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                FROM prospectos c 
                LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9 AND c.lugar_prospeccion != 6
                WHERE c. apellido_paterno LIKE '%".$ap_paterno_prospect."%' OR
                c.apellido_materno LIKE '%".$ap_materno_prospect."%' AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                break;
        }
        return $query->result();
    }
    function getProspByApPaternoCorreo($ap_paterno_prospect, $correo_prospect)
    {
        switch ($this->session->userdata('id_rol')) {
            case '18': // DIRECTOR MKTD
            case '19': // SUBDIRECTOR MKTD
            case '20': // GERENTE
            case '28': // COBRANZA
            case '13': // CONTRALORÍA
            case '32': // CONTRALORÍA CORPORATIVA
                    $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                    CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                    CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                    CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                    c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                    FROM prospectos c 
                    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                    WHERE c. apellido_paterno LIKE '%".$ap_paterno_prospect."%' OR
                    c.correo LIKE '%".$correo_prospect."%' AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                break;
            default:
                $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                    CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                    CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                    CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                    c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                    FROM prospectos c 
                    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9 AND c.lugar_prospeccion != 6
                    WHERE c. apellido_paterno LIKE '%".$ap_paterno_prospect."%' OR
                    c.correo LIKE '%".$correo_prospect."%' AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                break;
        }
        return $query->result();
    }

    function getProspByApPaternoTel($ap_paterno_prospect, $telefono_prospect)
    {
        switch ($this->session->userdata('id_rol')) {
            case '18': // DIRECTOR MKTD
            case '19': // SUBDIRECTOR MKTD
            case '20': // GERENTE
            case '28': // COBRANZA
            case '13': // CONTRALORÍA
            case '32': // CONTRALORÍA CORPORATIVA
                $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                        FROM prospectos c 
                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                        WHERE c. apellido_paterno LIKE '%".$ap_paterno_prospect."%' 
                        OR c.telefono LIKE '%".$telefono_prospect."%'  
                        OR c.telefono_2 LIKE '%".$telefono_prospect."%' AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                break;
            default:
                $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                        FROM prospectos c 
                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9 AND c.lugar_prospeccion != 6
                        WHERE c. apellido_paterno LIKE '%".$ap_paterno_prospect."%' 
                        OR c.telefono LIKE '%".$telefono_prospect."%'  
                        OR c.telefono_2 LIKE '%".$telefono_prospect."%' AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");

                break;
        }
        return $query->result();
    }
    function getProspByApMaternoMail($ap_materno_prospect, $correo_prospect)
    {
        switch ($this->session->userdata('id_rol')) {
            case '18': // DIRECTOR MKTD
            case '19': // SUBDIRECTOR MKTD
            case '20': // GERENTE
            case '28': // COBRANZA
            case '13': // CONTRALORÍA
            case '32': // CONTRALORÍA CORPORATIVA
                $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                        FROM prospectos c 
                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                        WHERE c. apellido_materno LIKE '%".$ap_materno_prospect."%' 
                        OR c.correo LIKE '%".$correo_prospect."%' AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                break;
            default:
                $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                        FROM prospectos c 
                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9 AND c.lugar_prospeccion != 6
                        WHERE c. apellido_materno LIKE '%".$ap_materno_prospect."%' 
                        OR c.correo LIKE '%".$correo_prospect."%' AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");

                break;
        }
        return $query->result();
    }
    function getProspByApMaternoTel($ap_materno_prospect, $telefono_prospect)
    {
        switch ($this->session->userdata('id_rol')) {
            case '18': // DIRECTOR MKTD
            case '19': // SUBDIRECTOR MKTD
            case '20': // GERENTE
            case '28': // COBRANZA
            case '13': // CONTRALORÍA
            case '32': // CONTRALORÍA CORPORATIVA
                $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                        FROM prospectos c 
                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                        WHERE c. apellido_materno LIKE '%".$ap_materno_prospect."%' 
                        OR c.telefono LIKE '%".$telefono_prospect."%'   OR c.telefono_2 LIKE '%".$telefono_prospect."%' 
                        AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                break;
            default:
                $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                        FROM prospectos c 
                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9 AND c.lugar_prospeccion != 6
                        WHERE c. apellido_materno LIKE '%".$ap_materno_prospect."%' 
                        OR c.telefono LIKE '%".$telefono_prospect."%'   OR c.telefono_2 LIKE '%".$telefono_prospect."%' 
                        AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                break;
        }
        return $query->result();
    }


    function getProspByNameApPaternoApMaterno($name_prospect, $ap_paterno_prospect, $ap_materno_prospect)
    {
        switch ($this->session->userdata('id_rol')) {
            case '18': // DIRECTOR MKTD
            case '19': // SUBDIRECTOR MKTD
            case '20': // GERENTE
            case '28': // COBRANZA
            case '13': // CONTRALORÍA
            case '32': // CONTRALORÍA CORPORATIVA
                $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                    CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                    CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                    CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                    c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                    FROM prospectos c 
                    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                    WHERE c.nombre LIKE '".$name_prospect."' OR c.apellido_paterno LIKE '%".$ap_paterno_prospect."%' OR
                    c.apellido_materno LIKE '%".$ap_materno_prospect."%' AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                break;
            default:
                $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                    CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                    CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                    CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                    c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                    FROM prospectos c 
                    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9 AND c.lugar_prospeccion != 6
                    WHERE c.nombre LIKE '".$name_prospect."' OR c.apellido_paterno LIKE '%".$ap_paterno_prospect."%' OR
                    c.apellido_materno LIKE '%".$ap_materno_prospect."%' AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                break;
        }
        return $query->result();
    }
    function getProspByNameApPaternoApMaternoCorreo($name_prospect, $ap_paterno_prospect, $ap_materno_prospect, $correo_prospect)
    {
        switch ($this->session->userdata('id_rol')) {
            case '18': // DIRECTOR MKTD
            case '19': // SUBDIRECTOR MKTD
            case '20': // GERENTE
            case '28': // COBRANZA
            case '13': // CONTRALORÍA
            case '32': // CONTRALORÍA CORPORATIVA
                $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                    CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                    CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                    CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                    c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                    FROM prospectos c 
                    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                    WHERE c.nombre LIKE '%".$name_prospect."%' OR
                    c.correo LIKE '%".$correo_prospect."%' OR c.apellido_paterno LIKE '%".$ap_paterno_prospect."%'
                    OR c.apellido_materno LIKE '%".$ap_materno_prospect."%'
                    AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                break;
            default:
                $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                    CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                    CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                    CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                    c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                    FROM prospectos c 
                    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9 AND c.lugar_prospeccion != 6
                    WHERE c.nombre LIKE '%".$name_prospect."%' OR
                    c.correo LIKE '%".$correo_prospect."%' OR c.apellido_paterno LIKE '%".$ap_paterno_prospect."%'
                    OR c.apellido_materno LIKE '%".$ap_materno_prospect."%'
                    AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                break;
        }
        return $query->result();
    }
    function getProspByTelCorreoApMaterno($telefono_prospect, $ap_materno_prospect, $correo_prospect)
    {
        switch ($this->session->userdata('id_rol')) {
            case '18': // DIRECTOR MKTD
            case '19': // SUBDIRECTOR MKTD
            case '20': // GERENTE
            case '28': // COBRANZA
            case '13': // CONTRALORÍA
            case '32': // CONTRALORÍA CORPORATIVA
                $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                    CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                    CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                    CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                    c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                    FROM prospectos c 
                    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                    WHERE c.correo LIKE '%".$correo_prospect."%' OR c.telefono LIKE '%".$telefono_prospect."%'
                    OR c.apellido_materno LIKE '%".$ap_materno_prospect."%' OR c.telefono_2 LIKE '%".$telefono_prospect."%' 
                    AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                break;
            default:
                $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                    CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                    CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                    CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                    c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                    FROM prospectos c 
                    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9 AND c.lugar_prospeccion != 6
                    WHERE c.correo LIKE '%".$correo_prospect."%' OR c.telefono LIKE '%".$telefono_prospect."%'
                    OR c.apellido_materno LIKE '%".$ap_materno_prospect."%' OR c.telefono_2 LIKE '%".$telefono_prospect."%' 
                    AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                break;
        }
        return $query->result();
    }


    function getProspByTelCorreoApMaternoApPaterno($telefono_prospect, $ap_materno_prospect, $correo_prospect, $ap_paterno_prospect)
     {
         switch ($this->session->userdata('id_rol')) {
            case '18': // DIRECTOR MKTD
            case '19': // SUBDIRECTOR MKTD
            case '20': // GERENTE
            case '28': // COBRANZA
            case '13': // CONTRALORÍA
            case '32': // CONTRALORÍA CORPORATIVA
                $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                    CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                    CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                    CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                    c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                    FROM prospectos c 
                    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                    WHERE c.correo LIKE '%".$correo_prospect."%' OR c.telefono LIKE '%".$telefono_prospect."%'
                    OR c.apellido_materno LIKE '%".$ap_materno_prospect."%' OR c.telefono_2 LIKE '%".$telefono_prospect."%'
                    OR c.apellido_paterno LIKE '%".$ap_paterno_prospect."%'
                    AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                 break;
             default:
                 $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                    CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                    CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                    CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                    c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                    FROM prospectos c 
                    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9 AND c.lugar_prospeccion != 6
                    WHERE c.correo LIKE '%".$correo_prospect."%' OR c.telefono LIKE '%".$telefono_prospect."%'
                    OR c.apellido_materno LIKE '%".$ap_materno_prospect."%' OR c.telefono_2 LIKE '%".$telefono_prospect."%'
                    OR c.apellido_paterno LIKE '%".$ap_paterno_prospect."%'
                    AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                 break;
         }
         return $query->result();
     }
     function getProspByTelCorreoApPaterno($telefono_prospect, $ap_paterno_prospect, $correo_prospect)
     {
         switch ($this->session->userdata('id_rol')) {
            case '18': // DIRECTOR MKTD
            case '19': // SUBDIRECTOR MKTD
            case '20': // GERENTE
            case '28': // COBRANZA
            case '13': // CONTRALORÍA
            case '32': // CONTRALORÍA CORPORATIVA
                $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                    CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                    CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                    CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                    c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                    FROM prospectos c 
                    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                    WHERE c.correo LIKE '%".$correo_prospect."%' OR c.telefono LIKE '%".$telefono_prospect."%'
                    OR c.telefono_2 LIKE '%".$telefono_prospect."%'
                    OR c.apellido_paterno LIKE '%".$ap_paterno_prospect."%'
                    AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                 break;
             default:
                 $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                    CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                    CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                    CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                    c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                    FROM prospectos c 
                    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9 AND c.lugar_prospeccion != 6
                    WHERE c.correo LIKE '%".$correo_prospect."%' OR c.telefono LIKE '%".$telefono_prospect."%'
                    OR c.telefono_2 LIKE '%".$telefono_prospect."%'
                    OR c.apellido_paterno LIKE '%".$ap_paterno_prospect."%'
                    AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                 break;
         }
         return $query->result();
     }
     function getProspByTelCorreoName($telefono_prospect, $name_prospect, $correo_prospect)
     {
         switch ($this->session->userdata('id_rol')) {
            case '18': // DIRECTOR MKTD
            case '19': // SUBDIRECTOR MKTD
            case '20': // GERENTE
            case '28': // COBRANZA
            case '13': // CONTRALORÍA
            case '32': // CONTRALORÍA CORPORATIVA
                $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                    CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                    CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                    CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                    c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                    FROM prospectos c 
                    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                    WHERE c.correo LIKE '%".$correo_prospect."%' OR c.telefono LIKE '%".$telefono_prospect."%'
                    OR c.telefono_2 LIKE '%".$telefono_prospect."%'
                    OR c.nombre LIKE '%".$name_prospect."%'
                    AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                 break;
             default:
                 $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                    CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                    CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                    CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                    c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                    FROM prospectos c 
                    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9 AND c.lugar_prospeccion != 6
                    WHERE c.correo LIKE '%".$correo_prospect."%' OR c.telefono LIKE '%".$telefono_prospect."%'
                    OR c.telefono_2 LIKE '%".$telefono_prospect."%'
                    OR c.nombre LIKE '%".$name_prospect."%'
                    AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                 break;
         }
         return $query->result();
     }

    function getProspByNameCorreoApMaterno($name_prospect, $correo_prospect, $ap_materno_prospect)
     {
         switch ($this->session->userdata('id_rol')) {
            case '18': // DIRECTOR MKTD
            case '19': // SUBDIRECTOR MKTD
            case '20': // GERENTE
            case '28': // COBRANZA
            case '13': // CONTRALORÍA
            case '32': // CONTRALORÍA CORPORATIVA
                    $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                        FROM prospectos c 
                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                        WHERE c.correo LIKE '%".$correo_prospect."%' OR c.apellido_materno LIKE '%".$ap_materno_prospect."%'
                        OR c.nombre LIKE '%".$name_prospect."%'
                        AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                 break;
             default:
                 $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                        FROM prospectos c 
                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9 AND c.lugar_prospeccion != 6
                        WHERE c.correo LIKE '%".$correo_prospect."%' OR c.apellido_materno LIKE '%".$ap_materno_prospect."%'
                        OR c.nombre LIKE '%".$name_prospect."%'
                        AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                 break;
         }
         return $query->result();
     }
     function getProspByNameTelApMaterno($name_prospect, $telefono_prospect, $ap_materno_prospect)
     {
         switch ($this->session->userdata('id_rol')) {
            case '18': // DIRECTOR MKTD
            case '19': // SUBDIRECTOR MKTD
            case '20': // GERENTE
            case '28': // COBRANZA
            case '13': // CONTRALORÍA
            case '32': // CONTRALORÍA CORPORATIVA
                $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                    CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                    CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                    CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                    c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                    FROM prospectos c 
                    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                    WHERE c.telefono LIKE '%".$telefono_prospect."%' OR c.apellido_materno LIKE '%".$ap_materno_prospect."%'
                    OR c.nombre LIKE '%".$name_prospect."%'  OR c.telefono_2 LIKE '%".$telefono_prospect."%'
                    AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                 break;
             default:
                 $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                    CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                    CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                    CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                    c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                    FROM prospectos c 
                    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9 AND c.lugar_prospeccion != 6
                    WHERE c.telefono LIKE '%".$telefono_prospect."%' OR c.apellido_materno LIKE '%".$ap_materno_prospect."%'
                    OR c.nombre LIKE '%".$name_prospect."%'  OR c.telefono_2 LIKE '%".$telefono_prospect."%'
                    AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                 break;
         }
         return $query->result();
     }
     function getProspByNameTelCorreoApMaterno($name_prospect, $telefono_prospect, $ap_materno_prospect, $correo_prospect)
     {
         switch ($this->session->userdata('id_rol')) {
            case '18': // DIRECTOR MKTD
            case '19': // SUBDIRECTOR MKTD
            case '20': // GERENTE
            case '28': // COBRANZA
            case '13': // CONTRALORÍA
            case '32': // CONTRALORÍA CORPORATIVA
                    $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                        FROM prospectos c 
                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                        WHERE c.telefono LIKE '%".$telefono_prospect."%' OR c.apellido_materno LIKE '%".$ap_materno_prospect."%'
                        OR c.nombre LIKE '%".$name_prospect."%'  OR c.telefono_2 LIKE '%".$telefono_prospect."%' OR
                        c.correo LIKE '".$correo_prospect."'
                        AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                 break;
             default:
                 $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                        FROM prospectos c 
                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9 AND c.lugar_prospeccion != 6
                        WHERE c.telefono LIKE '%".$telefono_prospect."%' OR c.apellido_materno LIKE '%".$ap_materno_prospect."%'
                        OR c.nombre LIKE '%".$name_prospect."%'  OR c.telefono_2 LIKE '%".$telefono_prospect."%' OR
                        c.correo LIKE '".$correo_prospect."'
                        AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                 break;
         }
         return $query->result();
     }
     function getProspByNameTelCorreoApPaterno($name_prospect, $telefono_prospect, $ap_paterno_prospect, $correo_prospect)
     {
         switch ($this->session->userdata('id_rol')) {
            case '18': // DIRECTOR MKTD
            case '19': // SUBDIRECTOR MKTD
            case '20': // GERENTE
            case '28': // COBRANZA
            case '13': // CONTRALORÍA
            case '32': // CONTRALORÍA CORPORATIVA
                    $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                        FROM prospectos c 
                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                        WHERE c.telefono LIKE '%".$telefono_prospect."%' OR c.apellido_paterno LIKE '%".$ap_paterno_prospect."%'
                        OR c.nombre LIKE '%".$name_prospect."%'  OR c.telefono_2 LIKE '%".$telefono_prospect."%' OR
                        c.correo LIKE '".$correo_prospect."'
                        AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                 break;
             default:
                 $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                        FROM prospectos c 
                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9 AND c.lugar_prospeccion != 6
                        WHERE c.telefono LIKE '%".$telefono_prospect."%' OR c.apellido_paterno LIKE '%".$ap_paterno_prospect."%'
                        OR c.nombre LIKE '%".$name_prospect."%'  OR c.telefono_2 LIKE '%".$telefono_prospect."%' OR
                        c.correo LIKE '".$correo_prospect."'
                        AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                 break;
         }
         return $query->result();
     }



    function getProspByNameCorreoApPaterno($name_prospect, $ap_paterno_prospect, $correo_prospect)
     {
         switch ($this->session->userdata('id_rol')) {
            case '18': // DIRECTOR MKTD
            case '19': // SUBDIRECTOR MKTD
            case '20': // GERENTE
            case '28': // COBRANZA
            case '13': // CONTRALORÍA
            case '32': // CONTRALORÍA CORPORATIVA
                    $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                        FROM prospectos c 
                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                        WHERE c.apellido_paterno LIKE '%".$ap_paterno_prospect."%'
                        OR c.nombre LIKE '%".$name_prospect."%'  OR
                        c.correo LIKE '".$correo_prospect."'
                        AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                 break;
             default:
                 $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                        FROM prospectos c 
                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9 AND c.lugar_prospeccion != 6
                        WHERE c.apellido_paterno LIKE '%".$ap_paterno_prospect."%'
                        OR c.nombre LIKE '%".$name_prospect."%'  OR
                        c.correo LIKE '".$correo_prospect."'
                        AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                 break;
         }
         return $query->result();
     }
     function getProspByNameTelApPaterno($name_prospect, $ap_paterno_prospect, $telefono_prospect)
     {
         switch ($this->session->userdata('id_rol')) {
            case '18': // DIRECTOR MKTD
            case '19': // SUBDIRECTOR MKTD
            case '20': // GERENTE
            case '28': // COBRANZA
            case '13': // CONTRALORÍA
            case '32': // CONTRALORÍA CORPORATIVA
                $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                    CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                    CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                    CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                    c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                    FROM prospectos c 
                    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                    WHERE c.apellido_paterno LIKE '%".$ap_paterno_prospect."%'
                    OR c.nombre LIKE '%".$name_prospect."%'  OR
                    c.telefono LIKE '".$telefono_prospect."' OR c.telefono_2 LIKE '%".$telefono_prospect."%'
                    AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                 break;
             default:
                 $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                    CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                    CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                    CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                    c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                    FROM prospectos c 
                    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9 AND c.lugar_prospeccion != 6
                    WHERE c.apellido_paterno LIKE '%".$ap_paterno_prospect."%'
                    OR c.nombre LIKE '%".$name_prospect."%'  OR
                    c.telefono LIKE '".$telefono_prospect."' OR c.telefono_2 LIKE '%".$telefono_prospect."%'
                    AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                 break;
         }
         return $query->result();
     }
     function getProspByApPaternoApMaternoCorreo($ap_materno_prospect, $ap_paterno_prospect, $correo_prospect)
     {
         switch ($this->session->userdata('id_rol')) {
            case '18': // DIRECTOR MKTD
            case '19': // SUBDIRECTOR MKTD
            case '20': // GERENTE
            case '28': // COBRANZA
            case '13': // CONTRALORÍA
            case '32': // CONTRALORÍA CORPORATIVA
                $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                    CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                    CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                    CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                    c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                    FROM prospectos c 
                    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                    WHERE c.apellido_paterno LIKE '%".$ap_paterno_prospect."%'
                    OR c.apellido_materno LIKE '%".$ap_materno_prospect."%'  OR
                    c.correo LIKE '".$correo_prospect."' 
                    AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                 break;
             default:
                 $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                    CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                    CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                    CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                    c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                    FROM prospectos c 
                    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9 AND c.lugar_prospeccion != 6
                    WHERE c.apellido_paterno LIKE '%".$ap_paterno_prospect."%'
                    OR c.apellido_materno LIKE '%".$ap_materno_prospect."%'  OR
                    c.correo LIKE '".$correo_prospect."' 
                    AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                 break;
         }
         return $query->result();
     }
     function getProspByApMaternoTelApPaterno($ap_materno_prospect, $ap_paterno_prospect, $telefono_prospect)
     {
         switch ($this->session->userdata('id_rol')) {
            case '18': // DIRECTOR MKTD
            case '19': // SUBDIRECTOR MKTD
            case '20': // GERENTE
            case '28': // COBRANZA
            case '13': // CONTRALORÍA
            case '32': // CONTRALORÍA CORPORATIVA
                $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                    CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                    CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                    CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                    c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                    FROM prospectos c 
                    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9
                    WHERE c.apellido_paterno LIKE '%".$ap_paterno_prospect."%'
                    OR c.apellido_materno LIKE '%".$ap_materno_prospect."%'  OR
                    c.telefono LIKE '".$telefono_prospect."' OR c.telefono_2 LIKE '%".$telefono_prospect."%'
                    AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                 break;
             default:
                 $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno,  c.apellido_materno,
                    CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                    CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                    CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                    c.fecha_creacion, c.fecha_vencimiento, c.estatus, oxc.nombre lugar_prospeccion, c.otro_lugar
                    FROM prospectos c 
                    LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                    LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                    LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion AND oxc.id_catalogo = 9 AND c.lugar_prospeccion != 6
                    WHERE c.apellido_paterno LIKE '%".$ap_paterno_prospect."%'
                    OR c.apellido_materno LIKE '%".$ap_materno_prospect."%'  OR
                    c.telefono LIKE '".$telefono_prospect."' OR c.telefono_2 LIKE '%".$telefono_prospect."%'
                    AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");
                 break;
         }
         return $query->result();
     }

     function getMKTDReport(){
        return $this->db->query("SELECT '0' tipo, CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) nombre, p.telefono, p.correo, '' nombreResidencial, '' condominio,  '' nombreLote, '0.00' totalNeto2,
                                CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor,
                                CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) coordinador,
                                CONCAT(uuu.nombre, ' ', uuu.apellido_paterno, ' ', uuu.apellido_materno) gerente, p.fecha_creacion fechaApartado, p.id_prospecto,
                                oxc.nombre lugar_prospeccion, p.otro_lugar, /*oxc2.nombre plaza_venta,*/ s.nombre sede,  p.estado_civil, p.originario_de
                                FROM prospectos p
                                LEFT JOIN usuarios u ON u.id_usuario = p.id_asesor
                                LEFT JOIN usuarios uu ON uu.id_usuario = p.id_coordinador
                                LEFT JOIN usuarios uuu ON uuu.id_usuario = p.id_gerente
                                LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = p.lugar_prospeccion
                                /*LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = p.plaza_venta*/
                                LEFT JOIN sedes s ON s.id_sede = p.id_sede
                                WHERE p.lugar_prospeccion = 6 AND oxc.id_catalogo = 9 /*AND oxc2.id_catalogo = 5 */
                                UNION ALL
                                SELECT '1' tipo, CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre, c.telefono1, c.correo, r.nombreResidencial, cn.nombre condominio, l.nombreLote, l.totalNeto2,
                                CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor,
                                CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) coordinador,
                                CONCAT(uuu.nombre, ' ', uuu.apellido_paterno, ' ', uuu.apellido_materno) gerente, c.fechaApartado, c.id_cliente id_prospecto,
                                oxc.nombre lugar_prospeccion, c.otro_lugar, /*oxc2.nombre plaza_venta,*/ s.nombre sede, c.estado_civil, c.originario_de
                                FROM clientes c
                                INNER JOIN lotes l ON l.idLote = c.idLote
                                INNER JOIN condominios cn ON cn.idCondominio = l.idCondominio
                                INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
                                LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                LEFT JOIN usuarios uu ON uu.id_usuario = c.id_coordinador
                                LEFT JOIN usuarios uuu ON uuu.id_usuario = c.id_gerente
                                LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion
                                /*LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = c.plaza_venta*/
                                LEFT JOIN sedes s ON s.id_sede = c.id_sede
                                WHERE c.lugar_prospeccion = 6 AND oxc.id_catalogo = 9 /*AND oxc2.id_catalogo = 5*/ AND c.status = 1 ORDER BY nombre");
    }



    function addPresale($data) {
        $response = $this->db->insert("preventas", $data);
        if (! $response ) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

    function getPresales(){
        switch ($this->session->userdata('id_rol')) {
            case '22': // EJECUTIVO CLUB MADERAS
            case '35': // ATENCIÓN A CLIENTES CLUB MADERAS
                return $this->db->query("SELECT p.id_prospecto, CONCAT (p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) prospecto, r.nombreResidencial, 
                                        c.nombre condominio, l.nombreLote, l.referencia,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente,
                                        pv.fecha_creacion, pv.fecha_vencimiento FROM prospectos p 
                                        INNER JOIN preventas pv ON pv.id_prospecto = p.id_prospecto
                                        INNER JOIN lotes l ON l.idLote = pv.id_lote
                                        INNER JOIN condominios c ON c.idCondominio = pv.id_condominio
                                        INNER JOIN residenciales r ON r.idResidencial = pv.id_residencial
                                        LEFT JOIN usuarios u ON u.id_usuario = p.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = p.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = p.id_gerente
                                        WHERE p.id_coordinador = ".$this->session->userdata('id_usuario')." AND p.estatus_particular = 6 AND p.lugar_prospeccion = 12 AND pv.estatus = 1");
                break;
            case '20': //GERENTE MKTD
                return $this->db->query("SELECT p.id_prospecto, CONCAT (p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) prospecto, r.nombreResidencial, 
                                        c.nombre condominio, l.nombreLote, l.referencia,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente,
                                        pv.fecha_creacion, pv.fecha_vencimiento FROM prospectos p 
                                        INNER JOIN preventas pv ON pv.id_prospecto = p.id_prospecto
                                        INNER JOIN lotes l ON l.idLote = pv.id_lote
                                        INNER JOIN condominios c ON c.idCondominio = pv.id_condominio
                                        INNER JOIN residenciales r ON r.idResidencial = pv.id_residencial
                                        LEFT JOIN usuarios u ON u.id_usuario = p.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = p.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = p.id_gerente
                                        WHERE p.id_coordinador = ".$this->session->userdata('id_usuario')." AND p.estatus_particular = 6 AND pv.estatus = 1");
                break;
            case '19': // SUBDIRECTOR MKTD
                return $this->db->query("SELECT p.id_prospecto, CONCAT (p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) prospecto, r.nombreResidencial, 
                                        c.nombre condominio, l.nombreLote, l.referencia,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente,
                                        pv.fecha_creacion, pv.fecha_vencimiento FROM prospectos p 
                                        INNER JOIN preventas pv ON pv.id_prospecto = p.id_prospecto
                                        INNER JOIN lotes l ON l.idLote = pv.id_lote
                                        INNER JOIN condominios c ON c.idCondominio = pv.id_condominio
                                        INNER JOIN residenciales r ON r.idResidencial = pv.id_residencial
                                        LEFT JOIN usuarios u ON u.id_usuario = p.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = p.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = p.id_gerente
                                        WHERE p.id_gerente = ".$this->session->userdata('id_usuario')." AND p.estatus_particular = 6 AND pv.estatus = 1");
                break;
            case '18': // DIRECTOR MKTD
                return $this->db->query("");
                break;
            case '2': // SUBDIRECTOR
            case '5': // ASISTENTE SUBDIRECTOR
                return $this->db->query("SELECT p.id_prospecto, CONCAT (p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) prospecto, r.nombreResidencial, 
                                        c.nombre condominio, l.nombreLote, l.referencia,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente,
                                        pv.fecha_creacion, pv.fecha_vencimiento FROM prospectos p 
                                        INNER JOIN preventas pv ON pv.id_prospecto = p.id_prospecto
                                        INNER JOIN lotes l ON l.idLote = pv.id_lote
                                        INNER JOIN condominios c ON c.idCondominio = pv.id_condominio
                                        INNER JOIN residenciales r ON r.idResidencial = pv.id_residencial
                                        LEFT JOIN usuarios u ON u.id_usuario = p.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = p.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = p.id_gerente
                                        WHERE p.id_sede IN(".$this->session->userdata('id_sede').") AND l.lugar_prospeccion != 6 AND p.estatus_particular = 6 AND pv.estatus = 1");
                break;
            case '3': // GERENTE
                return $this->db->query("SELECT p.id_prospecto, CONCAT (p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) prospecto, r.nombreResidencial, 
                                        c.nombre condominio, l.nombreLote, l.referencia,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente,
                                        pv.fecha_creacion, pv.fecha_vencimiento FROM prospectos p 
                                        INNER JOIN preventas pv ON pv.id_prospecto = p.id_prospecto
                                        INNER JOIN lotes l ON l.idLote = pv.id_lote
                                        INNER JOIN condominios c ON c.idCondominio = pv.id_condominio
                                        INNER JOIN residenciales r ON r.idResidencial = pv.id_residencial
                                        LEFT JOIN usuarios u ON u.id_usuario = p.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = p.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = p.id_gerente
                                        WHERE p.id_gerente = ".$this->session->userdata('id_usuario')." AND l.lugar_prospeccion != 6 AND p.estatus_particular = 6 AND pv.estatus = 1");
                break;
            case '6': // ASISTENTE GERENTE
                return $this->db->query("SELECT p.id_prospecto, CONCAT (p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) prospecto, r.nombreResidencial, 
                                        c.nombre condominio, l.nombreLote, l.referencia,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente,
                                        pv.fecha_creacion, pv.fecha_vencimiento FROM prospectos p 
                                        INNER JOIN preventas pv ON pv.id_prospecto = p.id_prospecto
                                        INNER JOIN lotes l ON l.idLote = pv.id_lote
                                        INNER JOIN condominios c ON c.idCondominio = pv.id_condominio
                                        INNER JOIN residenciales r ON r.idResidencial = pv.id_residencial
                                        LEFT JOIN usuarios u ON u.id_usuario = p.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = p.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = p.id_gerente
                                        WHERE p.id_gerente = ".$this->session->userdata('id_lider')." AND c.lugar_prospeccion != 6 AND p.estatus_particular = 6 AND pv.estatus = 1");
                break;
            case '9': // COORDINADOR
                return $this->db->query("SELECT p.id_prospecto, CONCAT (p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) prospecto, r.nombreResidencial, 
                                        c.nombre condominio, l.nombreLote, l.referencia,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente,
                                        pv.fecha_creacion, pv.fecha_vencimiento FROM prospectos p 
                                        INNER JOIN preventas pv ON pv.id_prospecto = p.id_prospecto
                                        INNER JOIN lotes l ON l.idLote = pv.id_lote
                                        INNER JOIN condominios c ON c.idCondominio = pv.id_condominio
                                        INNER JOIN residenciales r ON r.idResidencial = pv.id_residencial
                                        LEFT JOIN usuarios u ON u.id_usuario = p.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = p.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = p.id_gerente
                                        WHERE (p.id_asesor = ".$this->session->userdata('id_usuario')." OR p.id_coordinador = ".$this->session->userdata('id_usuario').") AND p.lugar_prospeccion != 6 AND p.estatus_particular = 6 AND pv.estatus = 1");
                break;
            case '7': // ASESOR
                return $this->db->query("SELECT p.id_prospecto, CONCAT (p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) prospecto, r.nombreResidencial, 
                                        c.nombre condominio, l.nombreLote, l.referencia,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente,
                                        pv.fecha_creacion, pv.fecha_vencimiento FROM prospectos p 
                                        INNER JOIN preventas pv ON pv.id_prospecto = p.id_prospecto
                                        INNER JOIN lotes l ON l.idLote = pv.id_lote
                                        INNER JOIN condominios c ON c.idCondominio = pv.id_condominio
                                        INNER JOIN residenciales r ON r.idResidencial = pv.id_residencial
                                        LEFT JOIN usuarios u ON u.id_usuario = p.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = p.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = p.id_gerente
                                        WHERE p.id_asesor = ".$this->session->userdata('id_usuario')." AND p.estatus_particular = 6 AND pv.estatus = 1");
                break;
            case '1': // DIRECTOR
            case '4': // ASISTENTE DIRECTOR
                return $this->db->query("SELECT p.id_prospecto, CONCAT (p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) prospecto, r.nombreResidencial, 
                                        c.nombre condominio, l.nombreLote, l.referencia,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente,
                                        pv.fecha_creacion, pv.fecha_vencimiento FROM prospectos p 
                                        INNER JOIN preventas pv ON pv.id_prospecto = p.id_prospecto
                                        INNER JOIN lotes l ON l.idLote = pv.id_lote
                                        INNER JOIN condominios c ON c.idCondominio = pv.id_condominio
                                        INNER JOIN residenciales r ON r.idResidencial = pv.id_residencial
                                        LEFT JOIN usuarios u ON u.id_usuario = p.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = p.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = p.id_gerente
                                        WHERE p.lugar_prospeccion != 6 AND p.estatus_particular = 6 AND pv.estatus = 1");
                break;
        }

    }

    public function getProspectInformationByReference($reference) {
        return $this->db->query("SELECT p.id_prospecto, CONCAT (p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) nombre, r.nombreResidencial, 
                                c.nombre condominio, l.nombreLote, l.referencia, u.id_usuario id_asesor, us.id_usuario id_coordinador, uss.id_usuario id_gerente,
                                CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente,
                                pv.fecha_creacion, pv.fecha_vencimiento, l.sup, l.total, l.enganche, l.idLote, l.precio,
                                 r.idResidencial, c.idCondominio, l.idLote, c.tipo_lote, pv.tipo es_casa, pv.estatus, pv.recibo_pago FROM prospectos p 
                                INNER JOIN preventas pv ON pv.id_prospecto = p.id_prospecto
                                INNER JOIN lotes l ON l.idLote = pv.id_lote
                                INNER JOIN condominios c ON c.idCondominio = pv.id_condominio
                                INNER JOIN residenciales r ON r.idResidencial = pv.id_residencial
                                LEFT JOIN usuarios u ON u.id_usuario = p.id_asesor
                                LEFT JOIN usuarios us ON us.id_usuario = p.id_coordinador
                                LEFT JOIN usuarios uss ON uss.id_usuario = p.id_gerente
                                WHERE l.referencia = '$reference' AND pv.estatus = 1")->result_array();
    }

    function updateLote($data, $idLote) {
        $response = $this->db->update("lotes", $data, "idLote = $idLote");
        if (! $response ) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

    function getPresalesList(){
        switch ($this->session->userdata('id_rol')) {
            case '20': //GERENTE MKTD
                return $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, c.estatus_particular
                                        FROM prospectos c 
                                        INNER JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        INNER JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        INNER JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        WHERE c.id_sede IN(".$this->session->userdata('id_sede').") AND c.lugar_prospeccion = 6 AND c.tipo = 0 AND c.estatus_particular = 6 ORDER BY c.fecha_creacion DESC");
                break;
            case '19': // SUBDIRECTOR MKTD
                return $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, c.estatus_particular
                                        FROM prospectos c 
                                        INNER JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        INNER JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        INNER JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        WHERE c.id_sede IN(".$this->session->userdata('id_sede').") AND c.lugar_prospeccion = 6 AND c.tipo = 0 AND c.estatus_particular = 6 ORDER BY c.fecha_creacion DESC");
                break;
            case '18': //GERENTE MKTD
                return $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, c.estatus_particular
                                        FROM prospectos c 
                                        INNER JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        INNER JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        INNER JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        WHERE c.tipo = 0 AND c.estatus_particular = 6 AND c.lugar_prospeccion = 6 ORDER BY c.fecha_creacion DESC");
                break;
            case '2': // SUBDIRECTOR
            case '5': // ASISTENTE SUBDIRECTOR
                return $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, c.estatus_particular
                                        FROM prospectos c
                                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        WHERE c.id_sede IN(".$this->session->userdata('id_sede').") AND c.tipo = 0 AND c.estatus_particular = 6 AND c.lugar_prospeccion != 6 ORDER BY c.fecha_creacion DESC");
                break;
            case '3': // GERENTE
                return $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, c.estatus_particular
                                        FROM prospectos c 
                                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        WHERE c.id_gerente = ".$this->session->userdata('id_usuario')." AND c.tipo = 0 AND c.estatus_particular = 6 AND c.lugar_prospeccion != 6 ORDER BY c.fecha_creacion DESC");
                break;
            case '6': // ASISTENTE GERENTE
                return $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente,  
                                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, c.estatus_particular
                                        FROM prospectos c 
                                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        WHERE c.id_gerente = ".$this->session->userdata('id_lider')." AND c.tipo = 0 AND c.estatus_particular = 6 AND c.lugar_prospeccion != 6 ORDER BY c.fecha_creacion DESC");
                break;
            case '9': // COORDINADOR
                return $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, c.estatus_particular
                                        FROM prospectos c 
                                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        WHERE (c.id_asesor = ".$this->session->userdata('id_usuario')." OR c.id_coordinador = ".$this->session->userdata('id_usuario').") AND c.tipo = 0 AND c.estatus_particular = 6 AND c.lugar_prospeccion != 6 ORDER BY c.fecha_creacion DESC");
                break;
            case '7': // ASESOR
                return $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, c.estatus_particular
                                        FROM prospectos c 
                                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        WHERE c.id_asesor = ".$this->session->userdata('id_usuario')." AND c.tipo = 0 AND c.estatus_particular = 6 ORDER BY c.fecha_creacion DESC");
                break;
            case '22': // EJECUTIVO CLUB MADERAS
            case '35': // ATENCIÓN A CLIENTES CLUB MADERAS
                return $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                        CONVERT(VARCHAR,c.fecha_creacion,120) AS fecha_creacion, CONVERT(VARCHAR,c.fecha_vencimiento,120) AS fecha_vencimiento, CONVERT(VARCHAR,c.fecha_modificacion,120) AS fecha_modificacion, c.estatus_particular, c.estatus, c.otro_lugar
                                        FROM prospectos c 
                                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        WHERE c.tipo = 0 AND c.id_coordinador = ".$this->session->userdata('id_usuario')." AND  c.estatus_particular = 6 AND c.lugar_prospeccion = 12 ORDER BY c.fecha_creacion DESC");
                break;
            case '23': // SUBDIRECTOR CLUB MADERAS
                return $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                        CONVERT(VARCHAR,c.fecha_creacion,120) AS fecha_creacion, CONVERT(VARCHAR,c.fecha_vencimiento,120) AS fecha_vencimiento, CONVERT(VARCHAR,c.fecha_modificacion,120) AS fecha_modificacion, c.estatus_particular, c.estatus, c.otro_lugar
                                        FROM prospectos c 
                                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        WHERE c.tipo = 0 AND c.estatus_particular = 6 AND c.lugar_prospeccion = 12 ORDER BY c.fecha_creacion DESC");
                break;
            case '1': // DIRECTOR
            case '4': // ASISTENTE DIRECTOR
            default: // VE TODOS LOS REGISTROS
                return $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
                                        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
                                        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
                                        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
                                        c.fecha_creacion, c.fecha_vencimiento, c.estatus, c.estatus_particular
                                        FROM prospectos c 
                                        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                                        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                                        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                                        WHERE c.tipo = 0 AND c.estatus_particular = 6 AND c.lugar_prospeccion != 6 ORDER BY c.fecha_creacion DESC");
                break;
        }

    }

    function getSedeByUser($id_usuario){
        $query = $this->db-> query("SELECT id_usuario, id_sede FROM usuarios WHERE id_usuario = $id_usuario");
        return $query->result_array();
    }

    function getLeadersByAdviser($id_asesor)
    {
        return $this->db->query("SELECT u.id_lider id_coordinador, uu.id_lider id_gerente FROM usuarios u INNER JOIN usuarios uu ON uu.id_usuario = u.id_lider WHERE u.id_usuario = $id_asesor");
    }

    function getLeadersByCoordinator($id_asesor)
    {
        return $this->db->query("SELECT u.id_usuario id_coordinador, uu.id_lider id_gerente FROM usuarios u 
                                INNER JOIN usuarios uu ON uu.id_usuario = u.id_lider WHERE u.id_usuario = $id_asesor");
    }

    function getRole($id_asesor)
    {
        return $this->db->query("SELECT id_rol, id_sede FROM usuarios WHERE id_usuario = $id_asesor");
    }

    function saveProspectMktd($data, $data_spi)
    {
        $response = $this->db->insert("prospectos", $data);
        $id = $this->db->insert_id();
        if (!$response) {
            return $finalAnswer = 0;
        } else {
            $data_spi["id_prospecto"] = $id;
            $this->db->insert("sales_partner_inf", $data_spi);
            return $finalAnswer = 1;
        }
    }

    function getLeadersBySede($id_sede)
    {
        return $this->db->query("SELECT id_usuario id_coordinador, id_lider id_gerente FROM usuarios WHERE id_rol = 20 AND estatus = 1 AND id_sede = $id_sede");
    }

    function getSalesPartnerRecords($id_prospecto){
        return $this->db-> query("SELECT * FROM sales_partner_inf WHERE id_prospecto = $id_prospecto AND estatus = 1")->result_array();
    }

    function updateSalesPartnerInfo($data, $id_sale)
    {
        $response = $this->db->update("sales_partner_inf", $data, "id_sale = $id_sale");
        if (!$response) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

    function saveSalesPartnerInfo($data)
    {
        $response = $this->db->insert("sales_partner_inf", $data);
        if (!$response) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

    function getSalesPartnerInformation($id_prospecto, $tipo)
    {
        return $this->db->query("SELECT spi.id_sale, spi.id_prospecto, spi.tipo,
                                CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) coordinador, u.telefono telefono_coordinador,
                                CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) gerente, uu.telefono telefono_gerente
                                FROM sales_partner_inf spi 
                                LEFT JOIN usuarios u ON u.id_usuario = spi.id_coordinador
                                LEFT JOIN usuarios uu ON uu.id_usuario = spi.id_gerente
                                WHERE spi.id_prospecto = $id_prospecto AND spi.tipo = $tipo");
    }


    function getProspectsListByPlace($id_lugar){
        if ($id_lugar == 0){
             $query = $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
                CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor,
                CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador,
                CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente,
                CONCAT (sub.nombre, ' ', sub.apellido_paterno, ' ', sub.apellido_materno) sub,
                c.fecha_creacion, c.fecha_vencimiento, c.estatus, c.estatus_particular, c.lugar_prospeccion
                ,c.correo,c.telefono, oxc.nombre as lp
                FROM prospectos c
                LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion and oxc.id_catalogo = 9
                LEFT JOIN usuarios sub ON uss.id_lider = sub.id_usuario and sub.id_rol = 2
                WHERE c.estatus_vigencia = 1 AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");

        } else {
             $query = $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
                CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor,
                CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador,
                CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente,
                CONCAT (sub.nombre, ' ', sub.apellido_paterno, ' ', sub.apellido_materno) sub,
                c.fecha_creacion, c.fecha_vencimiento, c.estatus, c.estatus_particular, c.lugar_prospeccion
                ,c.correo,c.telefono, oxc.nombre as lp
                FROM prospectos c
                LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
                LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
                LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente
                LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion and oxc.id_catalogo = 9
                LEFT JOIN usuarios sub ON uss.id_lider = sub.id_usuario and sub.id_rol = 2
                WHERE c.estatus_vigencia = 1 AND c.lugar_prospeccion = ".$id_lugar." AND c.tipo = 0 ORDER BY c.fecha_creacion DESC");

        }
        return $query->result();
    }


    function getProspectsListBySubdir_p($id_sub){         
        $query = $this->db->query("SELECT c.id_prospecto, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre,
        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
        CONCAT (sub.nombre, ' ', sub.apellido_paterno, ' ', sub.apellido_materno) sub,
        c.fecha_creacion, c.fecha_vencimiento, c.estatus
        ,c.correo,c.telefono, oxc.nombre as lp
        FROM prospectos c
        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente

        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion and oxc.id_catalogo = 9
        LEFT JOIN usuarios sub ON uss.id_lider = sub.id_usuario and sub.id_rol = 2
        WHERE c.estatus_vigencia = 1 AND sub.id_usuario = $id_sub and c.tipo = 0 ORDER BY c.fecha_creacion DESC;");
                
        return $query->result();
    }



    /*function getProspectsListByGte($lugar,$id_gte){   
    if ($lugar == 0) { // TODOS
        $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno, c.apellido_materno,
        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
        CONCAT (sub.nombre, ' ', sub.apellido_paterno, ' ', sub.apellido_materno) sub,
        c.fecha_creacion, c.fecha_vencimiento, c.estatus
        ,c.correo,c.telefono, oxc.nombre as lp
        FROM prospectos c
        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente

        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion and oxc.id_catalogo = 9
        LEFT JOIN usuarios sub ON uss.id_lider = sub.id_usuario and sub.id_rol = 2
        WHERE c.estatus_vigencia = 1 AND uss.id_usuario = $id_gte and c.tipo = 0 
        ORDER BY c.fecha_creacion DESC;");

    } else {
        $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno, c.apellido_materno,
        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
        CONCAT (sub.nombre, ' ', sub.apellido_paterno, ' ', sub.apellido_materno) sub,
        c.fecha_creacion, c.fecha_vencimiento, c.estatus
        ,c.correo,c.telefono, oxc.nombre as lp
        FROM prospectos c
        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente

        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion and oxc.id_catalogo = 9
        LEFT JOIN usuarios sub ON uss.id_lider = sub.id_usuario and sub.id_rol = 2
        WHERE c.lugar_prospeccion = $lugar and uss.id_usuario = $id_gte and c.tipo = 0 
        ORDER BY c.fecha_creacion DESC;");

    }
                
        return $query->result();
    }*/
    function getProspectsListByGte($lugar, $id_gte, $typeTransaction, $beginDate, $endDate, $where)
    {
        if ($typeTransaction == 1 || $typeTransaction == 3) {  // FIRST LOAD || SEARCH BY DATE RANGE
            $filter = " AND c.fecha_creacion BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
            $filterTwo = "";
        } else if ($typeTransaction == 2) { // SEARCH BY LOTE
            $filter = "";
            $filterTwo = " AND l.idLote = $where";
        }
        if ($lugar == 0) { // TODOS
            $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno, c.apellido_materno,
        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
        CONCAT (sub.nombre, ' ', sub.apellido_paterno, ' ', sub.apellido_materno) sub,
        c.fecha_creacion, c.fecha_vencimiento, c.estatus
        ,c.correo,c.telefono, oxc.nombre as lp
        FROM prospectos c
        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente

        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion and oxc.id_catalogo = 9
        LEFT JOIN usuarios sub ON uss.id_lider = sub.id_usuario and sub.id_rol = 2
        WHERE c.estatus_vigencia = 1 AND uss.id_usuario = $id_gte and c.tipo = 0 
        ".$filter."
        ORDER BY c.fecha_creacion DESC;");

        } else {
            $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno, c.apellido_materno,
        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
        CONCAT (sub.nombre, ' ', sub.apellido_paterno, ' ', sub.apellido_materno) sub,
        c.fecha_creacion, c.fecha_vencimiento, c.estatus
        ,c.correo,c.telefono, oxc.nombre as lp
        FROM prospectos c
        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente

        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion and oxc.id_catalogo = 9
        LEFT JOIN usuarios sub ON uss.id_lider = sub.id_usuario and sub.id_rol = 2
        WHERE c.lugar_prospeccion = $lugar and uss.id_usuario = $id_gte and c.tipo = 0 
        ".$filter."
        ORDER BY c.fecha_creacion DESC;");

        }

        return $query->result();
    }


    /*function getProspectsListByCoord_v2($lugar,$id_sub,$id_gte,$id_coord){       
    if ($lugar == 0) { // TODOS
        $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno, c.apellido_materno,
        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
        CONCAT (sub.nombre, ' ', sub.apellido_paterno, ' ', sub.apellido_materno) sub,
        c.fecha_creacion, c.fecha_vencimiento, c.estatus
        ,c.correo,c.telefono, oxc.nombre as lp
        FROM prospectos c
        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente

        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion and oxc.id_catalogo = 9
        LEFT JOIN usuarios sub ON uss.id_lider = sub.id_usuario and sub.id_rol = 2
        WHERE sub.id_usuario = $id_sub and uss.id_usuario = $id_gte and us.id_usuario = $id_coord
        and c.estatus_vigencia = 1 AND c.tipo = 0 ORDER BY c.fecha_creacion DESC;");

    } else {
        $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno, c.apellido_materno,
        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
        CONCAT (sub.nombre, ' ', sub.apellido_paterno, ' ', sub.apellido_materno) sub,
        c.fecha_creacion, c.fecha_vencimiento, c.estatus
        ,c.correo,c.telefono, oxc.nombre as lp
        FROM prospectos c
        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente

        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion and oxc.id_catalogo = 9
        LEFT JOIN usuarios sub ON uss.id_lider = sub.id_usuario and sub.id_rol = 2
        WHERE c.lugar_prospeccion = $lugar and sub.id_usuario = $id_sub and uss.id_usuario = $id_gte and us.id_usuario = $id_coord
        and c.estatus_vigencia = 1 AND c.tipo = 0 ORDER BY c.fecha_creacion DESC;");

    } 
        
                
        return $query->result();
    }*/
    function getProspectsListByCoord_v2($lugar, $id_sub, $id_gte, $id_coord, $typeTransaction, $beginDate, $endDate, $where){
        if ($typeTransaction == 1 || $typeTransaction == 3) {  // FIRST LOAD || SEARCH BY DATE RANGE
            $filter = " AND c.fecha_creacion BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
            $filterTwo = "";
        } else if($typeTransaction == 2) { // SEARCH BY LOTE
            $filter = "";
            $filterTwo = " AND l.idLote = $where";
        }

        if ($lugar == 0) { // TODOS
            $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno, c.apellido_materno,
        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
        CONCAT (sub.nombre, ' ', sub.apellido_paterno, ' ', sub.apellido_materno) sub,
        c.fecha_creacion, c.fecha_vencimiento, c.estatus
        ,c.correo,c.telefono, oxc.nombre as lp
        FROM prospectos c
        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente

        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion and oxc.id_catalogo = 9
        LEFT JOIN usuarios sub ON uss.id_lider = sub.id_usuario and sub.id_rol = 2
        WHERE sub.id_usuario = $id_sub and uss.id_usuario = $id_gte and us.id_usuario = $id_coord
        and c.estatus_vigencia = 1 AND c.tipo = 0
         ".$filter."
         ORDER BY c.fecha_creacion DESC;");

        } else {
            $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno, c.apellido_materno,
        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
        CONCAT (sub.nombre, ' ', sub.apellido_paterno, ' ', sub.apellido_materno) sub,
        c.fecha_creacion, c.fecha_vencimiento, c.estatus
        ,c.correo,c.telefono, oxc.nombre as lp
        FROM prospectos c
        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente

        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion and oxc.id_catalogo = 9
        LEFT JOIN usuarios sub ON uss.id_lider = sub.id_usuario and sub.id_rol = 2
        WHERE c.lugar_prospeccion = $lugar and sub.id_usuario = $id_sub and uss.id_usuario = $id_gte and us.id_usuario = $id_coord
        and c.estatus_vigencia = 1 AND c.tipo = 0 
        ".$filter."
        ORDER BY c.fecha_creacion DESC;");

        }


        return $query->result();
    }


    /*function getProspectsListByAs($lugar,$id_sub,$id_gte,$id_coord,$id_as){        
    if ($lugar == 0) { // TODOS
        $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno, c.apellido_materno,
        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
        CONCAT (sub.nombre, ' ', sub.apellido_paterno, ' ', sub.apellido_materno) sub,
        c.fecha_creacion, c.fecha_vencimiento, c.estatus
        ,c.correo,c.telefono, oxc.nombre as lp
        FROM prospectos c
        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente

        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion and oxc.id_catalogo = 9
        LEFT JOIN usuarios sub ON uss.id_lider = sub.id_usuario and sub.id_rol = 2
        WHERE sub.id_usuario = $id_sub and uss.id_usuario = $id_gte and us.id_usuario = $id_coord
        and u.id_usuario = $id_as
        and c.estatus_vigencia = 1 AND c.tipo = 0 ORDER BY c.fecha_creacion DESC;");
    } else {
        $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno, c.apellido_materno,
        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
        CONCAT (sub.nombre, ' ', sub.apellido_paterno, ' ', sub.apellido_materno) sub,
        c.fecha_creacion, c.fecha_vencimiento, c.estatus
        ,c.correo,c.telefono, oxc.nombre as lp
        FROM prospectos c
        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente

        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion and oxc.id_catalogo = 9
        LEFT JOIN usuarios sub ON uss.id_lider = sub.id_usuario and sub.id_rol = 2
        WHERE c.lugar_prospeccion = $lugar and sub.id_usuario = $id_sub and uss.id_usuario = $id_gte and us.id_usuario = $id_coord
        and u.id_usuario = $id_as
        and c.estatus_vigencia = 1 AND c.tipo = 0 ORDER BY c.fecha_creacion DESC;");

    }
                
        return $query->result();
    }*/
    function getProspectsListByAs($lugar,$id_sub,$id_gte,$id_coord,$id_as,$typeTransaction, $beginDate, $endDate, $where){
        if ($typeTransaction == 1 || $typeTransaction == 3) {  // FIRST LOAD || SEARCH BY DATE RANGE
            $filter = " AND c.fecha_creacion BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
            $filterTwo = "";
        } else if($typeTransaction == 2) { // SEARCH BY LOTE
            $filter = "";
            $filterTwo = " AND l.idLote = $where";
        }
    if ($lugar == 0) { // TODOS
        $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno, c.apellido_materno,
        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
        CONCAT (sub.nombre, ' ', sub.apellido_paterno, ' ', sub.apellido_materno) sub,
        c.fecha_creacion, c.fecha_vencimiento, c.estatus
        ,c.correo,c.telefono, oxc.nombre as lp
        FROM prospectos c
        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente

        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion and oxc.id_catalogo = 9
        LEFT JOIN usuarios sub ON uss.id_lider = sub.id_usuario and sub.id_rol = 2
        WHERE sub.id_usuario = $id_sub and uss.id_usuario = $id_gte and us.id_usuario = $id_coord
        and u.id_usuario = $id_as
        and c.estatus_vigencia = 1 AND c.tipo = 0 
        ".$filter."
        ORDER BY c.fecha_creacion DESC;");
    } else {
        $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno, c.apellido_materno,
        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
        CONCAT (sub.nombre, ' ', sub.apellido_paterno, ' ', sub.apellido_materno) sub,
        c.fecha_creacion, c.fecha_vencimiento, c.estatus
        ,c.correo,c.telefono, oxc.nombre as lp
        FROM prospectos c
        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente

        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion and oxc.id_catalogo = 9
        LEFT JOIN usuarios sub ON uss.id_lider = sub.id_usuario and sub.id_rol = 2
        WHERE c.lugar_prospeccion = $lugar and sub.id_usuario = $id_sub and uss.id_usuario = $id_gte and us.id_usuario = $id_coord
        and u.id_usuario = $id_as
        and c.estatus_vigencia = 1 AND c.tipo = 0 
        ".$filter."
        ORDER BY c.fecha_creacion DESC;");

    }
                
        return $query->result();
    }

    function getGerentesAll(){
        $this->db->select("*");
        $this->db->where('id_rol', 3);
        $this->db->where('estatus', 1);
        $query = $this->db->get('usuarios');
        return $query;
    }


    /*function getProspectsListByGteAll($id_gte){         
        $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno, c.apellido_materno,
        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
        CONCAT (sub.nombre, ' ', sub.apellido_paterno, ' ', sub.apellido_materno) sub,
        c.fecha_creacion, c.fecha_vencimiento, c.estatus
        ,c.correo,c.telefono, oxc.nombre as lp
        FROM prospectos c
        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente

        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion and oxc.id_catalogo = 9
        LEFT JOIN usuarios sub ON uss.id_lider = sub.id_usuario and sub.id_rol = 2
        WHERE c.estatus_vigencia = 1 AND uss.id_usuario = $id_gte and c.tipo = 0 ORDER BY c.fecha_creacion DESC;");
                
        return $query->result();
    }*/
    function getProspectsListByGteAll($id_gte, $typeTransaction, $beginDate, $endDate, $where){
        if ($typeTransaction == 1 || $typeTransaction == 3) {  // FIRST LOAD || SEARCH BY DATE RANGE
            $filter = " AND c.fecha_creacion BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
            $filterTwo = "";
        } else if($typeTransaction == 2) { // SEARCH BY LOTE
            $filter = "";
            $filterTwo = " AND l.idLote = $where";
        }

        $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno, c.apellido_materno,
        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
        CONCAT (sub.nombre, ' ', sub.apellido_paterno, ' ', sub.apellido_materno) sub,
        c.fecha_creacion, c.fecha_vencimiento, c.estatus
        ,c.correo,c.telefono, oxc.nombre as lp
        FROM prospectos c
        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente

        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion and oxc.id_catalogo = 9
        LEFT JOIN usuarios sub ON uss.id_lider = sub.id_usuario and sub.id_rol = 2
        WHERE c.estatus_vigencia = 1 AND uss.id_usuario = $id_gte and c.tipo = 0 
        ".$filter."
        ORDER BY c.fecha_creacion DESC;");
        return $query->result();
    }


    /*function getProspectsListByCoordByGte($id_gte,$id_coord){         
        $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno, c.apellido_materno,
        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
        CONCAT (sub.nombre, ' ', sub.apellido_paterno, ' ', sub.apellido_materno) sub,
        c.fecha_creacion, c.fecha_vencimiento, c.estatus
        ,c.correo,c.telefono, oxc.nombre as lp
        FROM prospectos c
        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente

        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion and oxc.id_catalogo = 9
        LEFT JOIN usuarios sub ON uss.id_lider = sub.id_usuario and sub.id_rol = 2
        WHERE uss.id_usuario = $id_gte and us.id_usuario = $id_coord
        and c.estatus_vigencia = 1 AND c.tipo = 0 ORDER BY c.fecha_creacion DESC;");
                
        return $query->result();
    }*/
    function getProspectsListByCoordByGte($id_gte, $id_coord, $typeTransaction, $beginDate, $endDate, $where){
        if ($typeTransaction == 1 || $typeTransaction == 3) {  // FIRST LOAD || SEARCH BY DATE RANGE
            $filter = " AND c.fecha_creacion BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
            $filterTwo = "";
        } else if($typeTransaction == 2) { // SEARCH BY LOTE
            $filter = "";
            $filterTwo = " AND l.idLote = $where";
        }

        $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno, c.apellido_materno,
        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
        CONCAT (sub.nombre, ' ', sub.apellido_paterno, ' ', sub.apellido_materno) sub,
        c.fecha_creacion, c.fecha_vencimiento, c.estatus
        ,c.correo,c.telefono, oxc.nombre as lp
        FROM prospectos c
        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente

        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion and oxc.id_catalogo = 9
        LEFT JOIN usuarios sub ON uss.id_lider = sub.id_usuario and sub.id_rol = 2
        WHERE uss.id_usuario = $id_gte and us.id_usuario = $id_coord
        and c.estatus_vigencia = 1 AND c.tipo = 0 
        ".$filter."
        ORDER BY c.fecha_creacion DESC;");
                
        return $query->result();
    }


    /*function getProspectsListByAsByCoord($id_gte,$id_coord,$id_as){         
        $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno, c.apellido_materno,
        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
        CONCAT (sub.nombre, ' ', sub.apellido_paterno, ' ', sub.apellido_materno) sub,
        c.fecha_creacion, c.fecha_vencimiento, c.estatus
        ,c.correo,c.telefono, oxc.nombre as lp
        FROM prospectos c
        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente

        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion and oxc.id_catalogo = 9
        LEFT JOIN usuarios sub ON uss.id_lider = sub.id_usuario and sub.id_rol = 2
        WHERE uss.id_usuario = $id_gte and us.id_usuario = $id_coord
        and u.id_usuario = $id_as
        and c.estatus_vigencia = 1 AND c.tipo = 0 ORDER BY c.fecha_creacion DESC;");
                
        return $query->result();
    }*/
    function getProspectsListByAsByCoord($id_gte,$id_coord,$id_as, $typeTransaction, $beginDate, $endDate, $where){
        if ($typeTransaction == 1 || $typeTransaction == 3) {  // FIRST LOAD || SEARCH BY DATE RANGE
            $filter = " AND c.fecha_creacion BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
            $filterTwo = "";
        } else if($typeTransaction == 2) { // SEARCH BY LOTE
            $filter = "";
            $filterTwo = " AND l.idLote = $where";
        }


        $query = $this->db->query("SELECT c.id_prospecto, c.nombre, c.apellido_paterno, c.apellido_materno,
        CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, 
        CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) coordinador, 
        CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) gerente, 
        CONCAT (sub.nombre, ' ', sub.apellido_paterno, ' ', sub.apellido_materno) sub,
        c.fecha_creacion, c.fecha_vencimiento, c.estatus
        ,c.correo,c.telefono, oxc.nombre as lp
        FROM prospectos c
        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
        LEFT JOIN usuarios us ON us.id_usuario = c.id_coordinador
        LEFT JOIN usuarios uss ON uss.id_usuario = c.id_gerente

        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = c.lugar_prospeccion and oxc.id_catalogo = 9
        LEFT JOIN usuarios sub ON uss.id_lider = sub.id_usuario and sub.id_rol = 2
        WHERE uss.id_usuario = $id_gte and us.id_usuario = $id_coord
        and u.id_usuario = $id_as
        and c.estatus_vigencia = 1 AND c.tipo = 0 
        ".$filter."
        ORDER BY c.fecha_creacion DESC;");
                
        return $query->result();
    }
 
    function getSedes(){
        $query = $this->db-> query("SELECT id_sede, nombre FROM sedes");
        return $query->result_array();
    }
	
	public function change_lp($id, $data){
        $this->db->update("prospectos", $data, "id_prospecto = $id");
		//$this->db->query("UPDATE prospectos SET otro_lugar = '".$lugar_p."' WHERE id_prospecto = ".$id." ");		
        return true;
	}
	
    function getVicePrincipal($id_sede)
    {
        return $this->db->query("SELECT 0 id_coordinador, id_usuario id_gerente FROM usuarios WHERE id_rol = 19 AND estatus = 1 AND id_sede LIKE '%$id_sede%'");
    }

    function getClientsListByManager(){
        return $this->db->query("SELECT l.idLote, l.nombreLote, CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombreCliente,
        CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreAsesor,
        CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) nombreGerente,
        c.fechaApartado, ISNULL(c.otro_lugar, '') medio FROM lotes l 
        INNER JOIN clientes c ON c.id_cliente = l.idCliente AND c.status = 1 AND c.lugar_prospeccion = 6
        LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor
        LEFT JOIN usuarios uu ON uu.id_usuario = c.id_gerente
        WHERE l.status = 1 AND u.id_sede = '".$this->session->userdata('id_sede')."'");
    }

    function getClientsReportMktd($typeTransaction, $beginDate, $endDate, $where){
        if ($typeTransaction == 1 || $typeTransaction == 3) {  // FIRST LOAD || SEARCH BY DATE RANGE
            $filter = " AND c.fechaApartado BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
            $filterTwo = "";
        } else if($typeTransaction == 2) { // SEARCH BY LOTE
            $filter = "";
            $filterTwo = " AND l.idLote = $where";
        }

        $rol = explode(", ", $this->session->userdata('id_sede'));
        $result = "'" . implode ( "', '", $rol ) . "'";
        if ($this->session->userdata('id_usuario') == 2042) // IS JOSSELIN
            $result = "'2', '3', '4', '6'";
        else if ($this->session->userdata('id_usuario') == 5363) // IS PAULINA
            $result = "'1', '5'";
        switch ($this->session->userdata('id_rol')) {
            case '18': // SUBDIRECTOR MKTD & TI
            case '19': // SUBDIRECTOR MKTD
            case '20': // GERENTE MKTD
            case '28': // GERENTE MKTD
                $query = $this->db->query("SELECT r.descripcion nombreResidencial, cn.nombre nombreCondominio, l.nombreLote, l.idLote,
                CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombreCliente,
                ISNULL(c.telefono1, '') telefono, ISNULL(c.otro_lugar, '') medioProspeccion, l.totalNeto2,
                s.nombre plaza, CONVERT(VARCHAR(10), c.fechaApartado, 111) fechaApartado, 
                CONVERT(VARCHAR(10), hl.modificado, 111) fechaEstatusQuince, l.enganche, ISNULL(oxc.nombre, 'SIN ESPECIFICAR') planEnganche,
                CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreAsesor,
                CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) nombreGerente, l.idStatusLote
                FROM lotes l
                INNER JOIN clientes c ON c.idLote = l.idLote AND c.lugar_prospeccion = 6 AND c.status = 1
                INNER JOIN condominios cn ON cn.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial  = cn.idResidencial
                INNER JOIN usuarios u ON u.id_usuario = c.id_asesor AND u.id_sede IN ($result)
                INNER JOIN usuarios uu ON uu.id_usuario = c.id_gerente
                INNER JOIN sedes s ON s.id_sede = u.id_sede
                
                LEFT JOIN (SELECT MAX(modificado) modificado, idStatusContratacion, idMovimiento, idLote, status, idCliente FROM historial_lotes 
                GROUP BY idStatusContratacion, idMovimiento, idLote, status, idCliente) hl ON hl.idLote = l.idLote AND hl.idStatusContratacion = 15 
                AND hl.idMovimiento = 45 AND hl.status = 1 AND hl.idCliente = c.id_cliente
                
                LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = l.plan_enganche AND oxc.id_catalogo = 39
                WHERE l.status = 1 AND l.idStatusLote IN (2, 3) $filter ORDER BY r.nombreResidencial, cn.nombre, l.nombreLote");
            break;

            case '4': // ASISTENTE GERENTE
            case '13': // CONTRALORÍA
            case '17': // CONTRALORÍA
            case '63': // CONTROL INTERNO
            case '70': // EJECUTIVO CONTRALORIA JR
                $query = $this->db->query("SELECT r.descripcion nombreResidencial, cn.nombre nombreCondominio, l.nombreLote, l.idLote,
                CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombreCliente,
                ISNULL(c.telefono1, '') telefono, ISNULL(UPPER(c.otro_lugar), '') medioProspeccion, UPPER(oxc2.nombre) lp, l.totalNeto2,
                UPPER(s.nombre) plaza, CONVERT(VARCHAR(10), c.fechaApartado, 111) fechaApartado, 
                CONVERT(VARCHAR(10), hl.modificado, 111) fechaEstatusQuince, l.enganche, ISNULL(oxc.nombre, 'SIN ESPECIFICAR') planEnganche,
                CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreAsesor,
                CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) nombreGerente,
                CONCAT(uuu.nombre, ' ', uuu.apellido_paterno, ' ', uuu.apellido_materno) nombreCoordinador
                FROM lotes l
                INNER JOIN clientes c ON c.idLote = l.idLote AND c.status = 1
                INNER JOIN condominios cn ON cn.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial  = cn.idResidencial
                INNER JOIN usuarios u ON u.id_usuario = c.id_asesor
                INNER JOIN usuarios uu ON uu.id_usuario = c.id_gerente
                LEFT JOIN usuarios uuu ON uuu.id_usuario = c.id_coordinador
                INNER JOIN sedes s ON CONVERT(VARCHAR(12), s.id_sede) = CONVERT(VARCHAR(12), u.id_sede)
                
                INNER JOIN (SELECT MAX(modificado) modificado, idStatusContratacion, idMovimiento, idLote, status, idCliente FROM historial_lotes 
                GROUP BY idStatusContratacion, idMovimiento, idLote, status, idCliente) hl ON hl.idLote = l.idLote AND hl.idStatusContratacion = 9 
                AND hl.idMovimiento = 39 AND hl.status = 1 AND hl.idCliente = c.id_cliente

                LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = l.plan_enganche AND oxc.id_catalogo = 39
                LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = c.lugar_prospeccion AND oxc2.id_catalogo = 9
                WHERE l.status = 1 AND l.idStatusLote = 2 $filter ORDER BY r.nombreResidencial, cn.nombre, l.nombreLote");
            break;

        }
        return $query;
    }

    function getProspectsAssignedList($typeTransaction, $beginDate, $endDate, $where)
    {
        if ($typeTransaction == 1 || $typeTransaction == 3) {  // FIRST LOAD || SEARCH BY DATE RANGE
            $filter = " AND p.fecha_creacion BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
            $filterTwo = "";
        } else if($typeTransaction == 2) { // SEARCH BY LOTE
            $filter = "";
            $filterTwo = " AND l.idLote = $where";
        }


        
        $rol = explode(", ", $this->session->userdata('id_sede'));
        $result = "'" . implode ( "', '", $rol ) . "'";
        $query = $this->db->query("SELECT p.id_prospecto, CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) nombreProspecto, s.nombre sede,
        CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) nombreUsuarioModifica,
        CONCAT(old.nombre, ' ', old.apellido_paterno, ' ', old.apellido_materno) valorAnterior, 
        CONCAT(new.nombre, ' ', new.apellido_paterno, ' ', new.apellido_materno) valorNuevo,
        p.fecha_creacion, oxc.nombre lugar_prospeccion, p.otro_lugar, c.fecha_creacion fecha_asignacion
        FROM prospectos p
        INNER JOIN usuarios u ON u.id_usuario = p.id_asesor AND u.id_sede IN ($result)
        INNER JOIN cambios c ON c.id_prospecto = p.id_prospecto AND c.parametro_modificado = 'Asesor' 
        INNER JOIN usuarios uu ON uu.id_usuario = c.creado_por AND uu.id_rol IN (19, 20)
        INNER JOIN usuarios new ON new.id_usuario = c.nuevo
        INNER JOIN usuarios old ON old.id_usuario = c.anterior
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = p.lugar_prospeccion AND oxc.id_catalogo = 9
        INNER JOIN sedes s ON s.id_sede = u.id_sede
        WHERE p.lugar_prospeccion = 6 
        ".$filter."
        ORDER BY nombreUsuarioModifica, nombreProspecto
        ");
        return $query->result_array();
    }

    public function getGeneralProspectsListInformation($typeTransaction) {
        if ($typeTransaction == 1) { // MJ: PROSPECTOS  = MKTD
            $filter = "p.lugar_prospeccion = 6";
        } else if ($typeTransaction == 2) { // MJ: PROSPECTOS != MKTD
            $filter = "p.lugar_prospeccion != 6";
        }
        $query = $this->db->query("SELECT p.id_prospecto, p.nombre, p.apellido_paterno, p.apellido_materno, p.telefono, p.correo, 
        s.nombre plaza, CONVERT(VARCHAR(10), p.fecha_creacion, 111) fecha_creacion FROM prospectos p 
        INNER JOIN sedes s ON s.id_sede = p.id_sede
        WHERE $filter");

        return $query;

        /*return $this->db->query("SELECT p.id_prospecto, p.nombre, p.apellido_paterno, p.apellido_materno, p.telefono, p.correo, 
        s.nombre plaza, CONVERT(VARCHAR(10), p.fecha_creacion, 111) fecha_creacion FROM prospectos p 
        INNER JOIN sedes s ON s.id_sede = p.id_sede
        WHERE $filter");*/
    }

    function getSimilarName($key){
        $query = $this->db->query("SELECT * FROM prospectos WHERE nombre LIKE '%".$key."%' AND id_asesor = " . $this->session->userdata('id_usuario'). " ");
        return $query->result_array();
    }

    function getSimilarPhone($key){
        $query = $this->db->query("SELECT * FROM prospectos WHERE telefono LIKE '%".$key."%' AND id_asesor = " . $this->session->userdata('id_usuario'). " ");
        return $query->result_array();
    }

    function getSimilarEmail($key){
        $query = $this->db->query("SELECT * FROM prospectos WHERE correo LIKE '%".$key."%' AND id_asesor = " . $this->session->userdata('id_usuario'). " ");
        return $query->result_array();
    }
    function getNameLoteById($id_lote){
        $query = $this->db->query("SELECT nombreLote, idCliente FROM lotes WHERE idLote=".$id_lote);
        return $query->result_array();
    }

    function getCatalogs(){
        return $this->db->query("SELECT id_catalogo, id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo IN (5, 7, 9, 10, 11, 18, 19, 38) AND estatus = 1 ORDER BY id_catalogo, 
        (CASE id_catalogo WHEN 9 THEN (CASE id_opcion WHEN 31 THEN ' ' WHEN 6 THEN '' ELSE nombre END) WHEN 11 THEN (CASE id_opcion WHEN 0 THEN '' ELSE nombre END) ELSE nombre END)");
        //return $this->db->query("SELECT id_catalogo, id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo IN (5, 7, 9, 10, 11, 18, 19, 38) AND estatus = 1 ORDER BY id_catalogo, id_opcion");
    }
    
    function getregistrosLP(){
        if($this->session->userdata('id_rol') == 54) // MJ: SUBDIRECCIÓN CONSULTA
            $extraFilter = "WHERE rlp.fecha_creacion > '2022-01-26 17:57:38.000'";
        else
            $extraFilter = "";
        $query = $this->db->query("SELECT rlp.id_registro, UPPER(se.nombre) AS nombre_sede, UPPER(rlp.nombre) AS nombre, rlp.telefono, UPPER(rlp.correo) AS correo, UPPER(rlp.origen) AS origen, CONVERT(VARCHAR,rlp.fecha_creacion,120) AS fecha_creacion
        FROM registros_lp rlp
        INNER JOIN sedes se ON se.id_sede = rlp.id_sede
        $extraFilter");
        return $query->result();
    }

    function getCoincidencias($where, $where2)
    {
        $query = $this->db->query("SELECT cl.id_cliente, CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) nombre, cl.telefono1, cl.correo, cl.idLote, cl.fechaApartado, 
        REPLACE(ISNULL (oxc.nombre, 'Sin especificar'), ' (especificar)', '') nombre_lp, lo.nombreLote, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ', ae.apellido_materno)
        nombreAsesor, CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ', ge.apellido_materno) nombreGerente,
        ISNULL (se.nombre, 'Sin especificar') sede, st.nombre nombreEstatus, cl.descuento_mdb
        FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idCliente = cl.id_cliente
        INNER JOIN statuslote st ON st.idStatusLote = lo.idStatusLote
        LEFT JOIN opcs_x_cats oxc ON cl.lugar_prospeccion = oxc.id_opcion AND oxc.id_catalogo = 9
        INNER JOIN usuarios ae ON ae.id_usuario = cl.id_asesor
        INNER JOIN usuarios ge ON ge.id_usuario = cl.id_gerente
        INNER JOIN sedes se ON CAST(se.id_sede AS VARCHAR(10)) = ae.id_sede
        WHERE cl.status = 1 $where2 AND $where");

        return $query;
    }
    function getGrsBySub($idSubdir)
    {
        $this->db->select("*");
        $this->db->where('id_rol', 3);
        $this->db->where('estatus', 1);
        $this->db->where('id_lider', $idSubdir);
        $query = $this->db->get('usuarios');
        return $query->result();
    }

    function getProspectsListBySubdirector($idSubdir, $typeTransaction, $beginDate, $endDate, $where)
    {
      if ($typeTransaction == 1 || $typeTransaction == 3) {  // FIRST LOAD || SEARCH BY DATE RANGE
            $filter = " AND p.fecha_creacion BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
            //$this->db->where("p.fecha_creacion BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'");
        }
        /**/
        switch ($this->session->userdata('id_rol')) {
            case '19': // SUBDIRECTOR MKTD
                 $query = $this->db->query(
                    "SELECT p.id_prospecto, p.vigencia,
                            p.estatus, p.estatus_particular, p.lugar_prospeccion, UPPER(oxp.nombre) nombre_lp,
                            CONVERT(VARCHAR, p.fecha_vencimiento, 20) AS fecha_vencimiento,
                            CONVERT(VARCHAR, p.fecha_creacion, 20) AS fecha_creacion,
                            UPPER(CONCAT (p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno)) AS nombre,
                            CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) AS asesor,
                            CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) AS coordinador,
                            CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) AS gerente
                    FROM prospectos c
                    LEFT JOIN usuarios u ON u.id_usuario = p.id_asesor
                    LEFT JOIN usuarios us ON us.id_usuario = p.id_coordinador
                    LEFT JOIN usuarios uss ON uss.id_usuario = p.id_gerente
                    LEFT JOIN opcs_x_cats oxc ON oxp.id_opcion = p.lugar_prospeccion AND oxp.id_catalogo = 9
                    WHERE   p.estatus_vigencia = 1 AND 
                            p.id_sede IN(SELECT idSede FROM roles_x_usuario WHERE idUsuario = $idSubdir AND idRol = 2)) AND
                            p.lugar_prospeccion = 6 AND 
                            p.tipo = 0 ".$filter." ORDER BY p.fecha_creacion DESC");
            break;

            default:
                 $query = $this->db->query(
                    "SELECT p.id_prospecto, UPPER(p.nombre) AS nombre, p.apellido_paterno, p.apellido_materno, p.vigencia, 
                            p.estatus, p.estatus_particular,
                            p.lugar_prospeccion, UPPER(oxc.nombre) AS nombre_lp , p.id_sede,
                            CONVERT(VARCHAR, p.fecha_creacion,20) AS fecha_creacion,
                            CONVERT(VARCHAR, p.fecha_vencimiento, 20) AS fecha_vencimiento,
                            CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) AS asesor, 
                            CONCAT (us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) AS coordinador, 
                            CONCAT (uss.nombre, ' ', uss.apellido_paterno, ' ', uss.apellido_materno) AS gerente
                    FROM prospectos p
                    LEFT JOIN usuarios u ON u.id_usuario = p.id_asesor 
                    LEFT JOIN usuarios us ON us.id_usuario = p.id_coordinador 
                    LEFT JOIN usuarios uss ON uss.id_usuario = p.id_gerente 
                    LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = p.lugar_prospeccion AND oxc.id_catalogo = 9
                    WHERE p.estatus_vigencia = 1 AND p.id_sede IN (SELECT idSede FROM roles_x_usuario WHERE idUsuario = $idSubdir AND idRol = 2) AND p.tipo = 0 $filter 
                    ORDER BY p.fecha_creacion DESC");
            break;
        }
       
        return $query->result();
    }

    public function getProspectsReportInformation($type, $beginDate, $endDate){
        //$type = 0 Hace referencia a prospectos; 
        //$type = 1 Hace referencia a clientes;

        ini_set('memory_limit', -1);

        $a = $this->input->post("beginDate");
        $b = $this->input->post("endDate");
        $beginDate = date("Y-m-d", strtotime($this->input->post("beginDate")));
        $endDate = date("Y-m-d", strtotime($this->input->post("endDate")));

        $filter = "AND pr.fecha_creacion BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";

        if ( $type == 0 ){
            return $this->db->query("SELECT CONCAT(pr.nombre, ' ', pr.apellido_paterno, ' ', pr.apellido_materno) nombreProspecto, pr.id_prospecto,
            pr.fecha_creacion, pr.becameClient, pr.lugar_prospeccion,  
            UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) asesor, 
            UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) coordinador, 
            UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) gerente, 
            UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) subdirector,
            UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) regional,
            CASE WHEN pr.telefono IS NULL THEN '' ELSE pr.telefono END telefono,
            CASE WHEN pr.correo IS NULL THEN '' ELSE pr.correo END correo,
            CASE WHEN pr.domicilio_particular IS NULL THEN '' ELSE pr.domicilio_particular END direccion,
            CONVERT(varchar, pr.fecha_nacimiento, 103) fn, pr.domicilio_particular dp1,
            CASE WHEN CHARINDEX('(especificar)', oxc.nombre) != 0 THEN CONCAT(oxc.nombre, ' - ', pr.otro_lugar) ELSE oxc.nombre END lugar_prospeccion2,
            CASE WHEN pr.source = '0' THEN 'PROSPECCIÓN ASESOR' ELSE pr.source END medio
            FROM prospectos pr
            INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pr.lugar_prospeccion AND oxc.id_catalogo = 9
            INNER JOIN usuarios u0 ON u0.id_usuario = pr.id_asesor
            LEFT JOIN usuarios u1 ON u1.id_usuario = pr.id_coordinador
            LEFT JOIN usuarios u2 ON u2.id_usuario = pr.id_gerente
            LEFT JOIN usuarios u3 ON u3.id_usuario = pr.id_subdirector
            LEFT JOIN usuarios u4 ON u4.id_usuario = pr.id_regional
            WHERE pr.source = 'DragonCEM' AND pr.tipo = 0 $filter
            ORDER BY pr.fecha_creacion");
        }
        else{
            return $this->db->query("SELECT CONCAT(pr.nombre, ' ', pr.apellido_paterno, ' ', pr.apellido_materno) nombreProspecto, pr.id_prospecto, pr.fecha_creacion, pr.becameClient, pr.lugar_prospeccion,  
            UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) asesor, 
            UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) coordinador, 
            UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) gerente, 
            UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) subdirector, 
            UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) regional,
            cl.fechaApartado, DATEDIFF(DAY, cl.fechaApartado, pr.fecha_creacion) dias_cierre,
            CASE WHEN cl.id_cliente IS NULL THEN pr.telefono ELSE cl.telefono1 END telefono,
            CASE WHEN cl.id_cliente IS NULL THEN pr.correo ELSE cl.correo END correo,
            CASE WHEN cl.id_cliente IS NULL THEN pr.domicilio_particular ELSE cl.domicilio_particular END direccion,
            CONVERT(varchar, pr.fecha_nacimiento, 103) fn, CONVERT(varchar, cl.fecha_nacimiento, 103) fn2, pr.domicilio_particular dp1, cl.domicilio_particular dp2,
            CASE WHEN CHARINDEX('(especificar)', oxc.nombre) != 0 THEN CONCAT(oxc.nombre, ' - ', pr.otro_lugar) ELSE oxc.nombre END lugar_prospeccion2,
            CASE WHEN pr.source = '0' THEN 'PROSPECCIÓN ASESOR' ELSE pr.source END medio, re.descripcion residemcial, cn.nombre condominio, lo.nombreLote lote
            FROM prospectos pr
            INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pr.lugar_prospeccion AND oxc.id_catalogo = 9
            INNER JOIN clientes cl ON cl.id_prospecto = pr.id_prospecto AND cl.status = 1
            INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idCliente = cl.id_cliente
            INNER JOIN condominios cn ON cn.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = cn.idResidencial
            INNER JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
            LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
            LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
            LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
            LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
            WHERE pr.source = 'DragonCEM' AND pr.tipo = 1 $filter
            ORDER BY pr.fecha_creacion");
        }
    }

    public function searchData($data_search){
        $flag_where=0;
        $condicion_dinamica = '';
        $prefix = ($data_search['tipo_busqueda']==1) ? 'cl' : 'pr';

        if(!empty($data_search['nombre'])){
            $flag_where = $flag_where+1;
            if($flag_where==1){
                $condicion_dinamica = ' WHERE ';
            }elseif($flag_where>1){
                $condicion_dinamica = ' OR ';
            }
            $condition_nombre = $condicion_dinamica." CONCAT($prefix.nombre, ' ', $prefix.apellido_paterno, ' ', $prefix.apellido_materno) LIKE '%".$data_search['nombre']."%' ";
        }else{
            $condition_nombre = "";
        }

        if(!empty($data_search['idLote'])){
            $flag_where = $flag_where+1;
            if($flag_where==1){
                $condicion_dinamica = ' WHERE ';
            }elseif($flag_where>1){
                $condicion_dinamica = ' OR ';
            }
            $condition_idlote = $condicion_dinamica." cl.idLote=".$data_search['idLote'];
        }else{
            $condition_idlote = "";
        }

        if(!empty($data_search['correo'])){
            $flag_where = $flag_where+1;
            if($flag_where==1){
                $condicion_dinamica = ' WHERE ';
            }elseif($flag_where>1){
                $condicion_dinamica = ' OR ';
            }
            $condition_correo = $condicion_dinamica." $prefix.correo LIKE '%".$data_search['correo']."%'";
        }else{
            $condition_correo = "";
        }

        if(!empty($data_search['telefono'])){
            $flag_where = $flag_where+1;
            if($flag_where==1){
                $condicion_dinamica = ' WHERE ';
            }elseif($flag_where>1){
                $condicion_dinamica = ' OR ';
            }
            if($data_search['tipo_busqueda']==1){
                $condition_telefono = $condicion_dinamica." (cl.telefono1 LIKE '%".$data_search['telefono']."%' OR cl.telefono2 LIKE'%".$data_search['telefono']."%' OR cl.telefono3 LIKE '%".$data_search['telefono']."%')";
            }elseif($data_search['tipo_busqueda']==2){
                $condition_telefono = $condicion_dinamica." $prefix.telefono LIKE '%".$data_search['telefono']."%' OR $prefix.telefono_2 LIKE '%".$data_search['telefono']."%'";
            }
        }else {
            $condition_telefono = "";
        }


        if(!empty($data_search['sede'])){
            $flag_where = $flag_where+1;
            if($flag_where==1){
                $condicion_dinamica = ' WHERE ';
            }elseif($flag_where>1){
                $condicion_dinamica = ' OR ';
            }

            if($data_search['tipo_busqueda']==1){
                $condition_sedes = $condicion_dinamica." $prefix.fechaApartado BETWEEN '".$data_search['fecha_init']."' AND '".$data_search['fecha_end']."' AND $prefix.id_sede IN(".$data_search['sede'].")";
            }elseif($data_search['tipo_busqueda']==2){
                $condition_sedes = $condicion_dinamica." $prefix.fecha_creacion BETWEEN '".$data_search['fecha_init']."' AND '".$data_search['fecha_end']."' AND $prefix.id_sede IN(".$data_search['sede'].")";
            }
        }else {
            $condition_sedes = "";
        }

        if(!empty($data_search['id_dragon'])){
            $flag_where = $flag_where+1;
            if($flag_where==1){
                $condicion_dinamica = ' WHERE ';
            }elseif($flag_where>1){
                $condicion_dinamica = ' OR ';
            }
            $condition_iddragon = $condicion_dinamica." pr.id_dragon=".$data_search['id_dragon'];
        }else{
            $condition_iddragon = "";
        }


        switch ($data_search['tipo_busqueda']){
            case 1://clientes
                $query = $this->db->query("SELECT cl.idLote,  l.idStatusContratacion, r.descripcion AS nombreProyecto,
                c.nombre as nombreCondominio, l.nombreLote, UPPER(CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno)) AS nombreCliente,
                cl.noRecibo, l.referencia, cl.fechaApartado, l.totalValidado engancheCliente, cl.fechaEnganche, pr.fecha_creacion as fechaCreacionProspecto,
                sc.nombreStatus as nombreStatusContratacion, l.idStatusContratacion, cl.id_cliente, pr.id_dragon, pr.id_prospecto,
                CASE WHEN pr.source = '0' THEN 'CRM' ELSE pr.source END source
                FROM clientes cl 
                INNER JOIN lotes l ON cl.idLote = l.idLote 
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                INNER JOIN prospectos pr ON pr.id_prospecto = cl.id_prospecto 
                INNER JOIN statuscontratacion sc ON sc.idStatusContratacion = l.idStatusContratacion 
                $condition_nombre
                $condition_idlote
                $condition_correo
                $condition_telefono
                $condition_sedes
                $condition_iddragon
                AND cl.status=1");
                break;
            case 2:    //prospectos
                $query = $this->db->query("SELECT UPPER(concat(pr.nombre,' ', pr.apellido_paterno, ' ', pr.apellido_materno)) AS nombre_prospecto,
                pr.telefono, pr.telefono_2, UPPER(pr.correo) AS correo, pr.lugar_prospeccion, CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as nombre_asesor,
                CONCAT(coord.nombre, ' ', coord.apellido_materno, ' ', coord.apellido_paterno) as nombre_coordinador, 
                CONCAT(ger.nombre,' ', ger.apellido_paterno, ' ', ger.apellido_materno) as nombre_gerente, pr.fecha_creacion, pr.id_dragon, UPPER(sedes.nombre) as sede_nombre,
                sedes.abreviacion as abreviacion_sedes, pr.source, UPPER(opc.nombre) as lugar_prospeccion, pr.id_prospecto,
                CASE WHEN pr.source = '0' THEN 'CRM' ELSE pr.source END source
                FROM prospectos pr
                INNER JOIN usuarios asesor ON pr.id_asesor = asesor.id_usuario
                LEFT JOIN usuarios coord ON pr.id_coordinador = coord.id_usuario
                LEFT JOIN usuarios ger ON pr.id_gerente = ger.id_usuario
                INNER JOIN opcs_x_cats opc ON opc.id_opcion = pr.lugar_prospeccion AND opc.id_catalogo = 9
                INNER JOIN sedes ON pr.id_sede = sedes.id_sede 
                $condition_nombre
                $condition_idlote
                $condition_correo
                $condition_telefono
                $condition_iddragon
                $condition_sedes");
                break;
        }
        return $query->result_array();
    }

    public function getDragonsClientsList() {
        return $this->db->query("SELECT cl.idLote,  l.idStatusContratacion,r.descripcion AS nombreProyecto,
        c.nombre nombreCondominio, l.nombreLote, UPPER(CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno)) AS nombreCliente,
        cl.noRecibo, l.referencia, CONVERT(VARCHAR,cl.fechaApartado,20) AS fechaApartado, l.totalValidado engancheCliente, CONVERT(VARCHAR,cl.fechaEnganche,20) AS fechaEnganche, CONVERT(VARCHAR,pr.fecha_creacion,20) AS fechaCreacionProspecto,
        sc.nombreStatus nombreStatusContratacion, l.idStatusContratacion, cl.id_cliente, pr.id_dragon, pr.id_prospecto, ISNULL(hd.expediente, 0) nombre_archivo
        FROM clientes cl 
        INNER JOIN lotes l ON cl.idLote = l.idLote 
        INNER JOIN condominios c ON c.idCondominio = l.idCondominio
        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
        INNER JOIN prospectos pr ON pr.id_prospecto = cl.id_prospecto AND pr.lugar_prospeccion = 42
        INNER JOIN statuscontratacion sc ON sc.idStatusContratacion = l.idStatusContratacion 
        LEFT JOIN historial_documento hd ON hd.idLote = l.idLote AND hd.idCliente = cl.id_cliente AND hd.status = 1 AND hd.tipo_doc = 15
        WHERE cl.status = 1 ORDER BY l.nombreLote")->result_array();
    }

    public function getClientsByProyect($id_lider) {
        if ($this->session->userdata('id_usuario') == 7092)
            $id_lider = 7092;
        $where = ($id_lider == 0 || is_null($id_lider))
                 ? ""
                 : "AND (cli.id_subdirector = $id_lider OR cli.id_regional = $id_lider OR cli.id_gerente = $id_lider OR cli.id_gerente = $id_lider)";
        $query = $this->db->query(
            "SELECT res.nombreResidencial AS proyecto, con.nombre AS nombre_condominio, lot.nombreLote, sc.nombreStatus AS StatusContratacion, sl.nombre AS StatusLote,
                    CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS nombre_completo, CONVERT(VARCHAR, cli.fechaApartado, 20) AS fechaApartado,
                    oxc.nombre, CASE WHEN cli.fecha_nacimiento = '1900-01-01 00:00:00.000' THEN 'SIN ESPECIFICAR' ELSE cli.fecha_nacimiento END as fecha_nacimiento,
                    CASE 
                        WHEN ISDATE(REPLACE(cli.fecha_nacimiento, '-', '/')) = 1 THEN
                            CASE 
                                WHEN PATINDEX('%[/,-]00%', cli.fecha_nacimiento) > 0 THEN 
                                    CASE 
                                        WHEN YEAR(REPLACE(REPLACE(cli.fecha_nacimiento, 
                                                (SUBSTRING(cli.fecha_nacimiento,
                                                            PATINDEX('%[^ 0-9A-Za-z]%', cli.fecha_nacimiento)+1,
                                                            PATINDEX('%[^ 0-9A-Za-z]%', REVERSE(cli.fecha_nacimiento))-2)),
                                                (SUBSTRING(SUBSTRING(cli.fecha_nacimiento,
                                                            PATINDEX('%[^ 0-9A-Za-z]%', cli.fecha_nacimiento)+1,
                                                            PATINDEX('%[^ 0-9A-Za-z]%', REVERSE(cli.fecha_nacimiento))-2), 2, 2))),'-', '/')) <> 1900 THEN 
                                            DATEDIFF(YEAR, CAST(REPLACE(REPLACE(cli.fecha_nacimiento, 
                                                                (SUBSTRING(cli.fecha_nacimiento,
                                                                            PATINDEX('%[^ 0-9A-Za-z]%', cli.fecha_nacimiento)+1,
                                                                            PATINDEX('%[^ 0-9A-Za-z]%', REVERSE(cli.fecha_nacimiento))-2)),
                                                                (SUBSTRING(SUBSTRING(cli.fecha_nacimiento,
                                                                            PATINDEX('%[^ 0-9A-Za-z]%', cli.fecha_nacimiento)+1,
                                                                            PATINDEX('%[^ 0-9A-Za-z]%', REVERSE(cli.fecha_nacimiento))-2), 2, 2))),'-', '/') AS date), GETDATE())
                                    END
                                ELSE
                                    CASE
                                        WHEN YEAR(CASE
                                                    WHEN PATINDEX('%.%', cli.fecha_nacimiento) > 19 THEN 
                                                        cli.fecha_nacimiento
                                                    ELSE
                                                        REPLACE(REPLACE(cli.fecha_nacimiento, '.', '/'), '-', '/' )
                                                END) <> 1900 THEN
                                            DATEDIFF(YEAR, CAST(REPLACE(CASE
                                                                            WHEN PATINDEX('%.%', cli.fecha_nacimiento) > 19 THEN 
                                                                                cli.fecha_nacimiento
                                                                            ELSE
                                                                                REPLACE(REPLACE(cli.fecha_nacimiento, '.', '/'), '-', '/' )
                                                                        END, '-', '/') AS date), GETDATE())
                                    END
                            END 
                        WHEN cli.fecha_nacimiento = cli_fec_nac.fecha_nacimiento AND ISDATE(CONCAT(cli_fec_nac.mes_fecha_nac, '/', cli_fec_nac.dia_fecha_nac, '/',cli_fec_nac.año_fecha_nac)) = 1 THEN 
                            DATEDIFF(YEAR, CAST(CONCAT(cli_fec_nac.mes_fecha_nac, '/', cli_fec_nac.dia_fecha_nac, '/', cli_fec_nac.año_fecha_nac) AS DATE), GETDATE())
                        WHEN LEN(cli.fecha_nacimiento) - LEN(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(TRIM(cli.fecha_nacimiento),' DE ', '/'), '-', '/'), ' ', '/'),'.', '/'), '/', '')) = 2 AND 
                            LEN (REPLACE(REPLACE(REPLACE(REPLACE(TRIM(cli.fecha_nacimiento),' DE ', '/'), '-', '/'), ' ', '/'),'.', '/')) = 10 AND 
                            CHARINDEX('/', REPLACE(REPLACE(REPLACE(REPLACE(TRIM(cli.fecha_nacimiento),' DE ', '/'), '-', '/'), ' ', '/'),'.', '/')) < 5 THEN 
                            DATEDIFF(YEAR, CONVERT(date, REPLACE(REPLACE(REPLACE(REPLACE(TRIM(cli.fecha_nacimiento),' DE ', '/'), '-', '/'), ' ', '/'),'.', '/'), 103), GETDATE())
                        ELSE
                            NULL
                    END AS edad, cli.edadFirma, cli.ocupacion
            FROM residenciales AS res
            INNER JOIN condominios AS con
            ON res.idResidencial = con.idResidencial
            INNER JOIN lotes AS lot
            ON con.idCondominio = lot.idCondominio
            INNER JOIN statuscontratacion AS sc
            ON lot.idStatusContratacion = SC.idStatusContratacion
            INNER JOIN statuslote AS sl
            ON lot.idStatusLote = SL.idStatusLote
            LEFT JOIN clientes AS cli
            ON lot.idCliente = cli.id_cliente
            INNER JOIN opcs_x_cats AS oxc
            ON cli.personalidad_juridica = oxc.id_opcion
            LEFT JOIN (SELECT   cli.id_cliente, cli.fecha_nacimiento, 
                                meses.dia_fecha AS dia_fecha_nac, meses_render.num_mes AS mes_fecha_nac,
                                REPLACE(REPLACE(
                                    SUBSTRING(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(TRIM(cli.fecha_nacimiento),'1. ',''),'1.',''), 'FE', 'DE'),' DEL ', '/'),' DE ', '/'),'-', '/'),' / ', '/'),'/ ', '/'),' /', '/'),' ', '/'),'.', '/'),'(1)', ''),'1) ', ''),'1)', ''), '1 Y 2)', ''),'1y2)', ''), '1/Y/2', ''), '//', '/'),
                                        meses.inicio + LEN(CASE CHARINDEX(meses_render.mes, TRIM(cli.fecha_nacimiento))
                                                                WHEN 0 THEN SUBSTRING(meses_render.mes, 1, 3)
                                                                ELSE meses_render.mes
                                                            END)+1,
                                        5)
                                    , '/_', ''), '/', ''
                        )AS año_fecha_nac
                        FROM (SELECT '01' AS ENERO, '02' AS FEBRERO, '03' AS MARZO, '04' AS ABRIL, '05' AS MAYO, '06' AS JUNIO, '07' AS JULIO, '08' AS AGOSTO,
                                '09' AS SEPTIEMBRE, '10' AS OCTUBRE, '11' AS NOVIEMBRE, '12' AS DICIEMBRE) AS meses
                        UNPIVOT
                            (num_mes FOR mes IN 
                                (ENERO,	FEBRERO,	MARZO,	ABRIL,	MAYO,	JUNIO,	JULIO,	AGOSTO,	SEPTIEMBRE,	OCTUBRE,	NOVIEMBRE,	DICIEMBRE)
                            ) AS meses_render
                        INNER JOIN clientes AS cli
                        ON  REPLACE(RTRIM(cli.fecha_nacimiento), '.', '') LIKE '%'+meses_render.mes+'%' OR
                            REPLACE(RTRIM(cli.fecha_nacimiento), '.', '') LIKE '%'+SUBSTRING(meses_render.mes,1,3)+'%'
                        INNER JOIN (SELECT cli.id_cliente, cli.fecha_nacimiento, 
                                        CASE
                                            WHEN PATINDEX('%[^0-9]%',
                                                    TRIM(SUBSTRING(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(SUBSTRING(cli.fecha_nacimiento, 1, MIN(CASE CHARINDEX(mes, TRIM(cli.fecha_nacimiento)) WHEN 0 THEN CHARINDEX(SUBSTRING(mes, 1, 3), TRIM(cli.fecha_nacimiento)) ELSE CHARINDEX(mes, TRIM(cli.fecha_nacimiento))END)-1),'(1)',''), '1)', ''), '1.', ''),'1 Y 2)', ''), '1   ', ''), 
                                                        PATINDEX('%[0-9]%', REPLACE(REPLACE(REPLACE(REPLACE(REPLACE( SUBSTRING(cli.fecha_nacimiento, 1, MIN(CASE CHARINDEX(mes, TRIM(cli.fecha_nacimiento)) WHEN 0 THEN CHARINDEX(SUBSTRING(mes, 1, 3), TRIM(cli.fecha_nacimiento)) ELSE CHARINDEX(mes, TRIM(cli.fecha_nacimiento)) END)-1), '(1)',''), '1)', ''), '1.', ''),'1 Y 2)', ''), '1   ', '')), 
                                                        LEN(cli.fecha_nacimiento) - PATINDEX('%[0-9]%',REPLACE(REPLACE(REPLACE(SUBSTRING(cli.fecha_nacimiento, 1, MIN(CASE CHARINDEX(mes, TRIM(cli.fecha_nacimiento)) WHEN 0 THEN CHARINDEX(SUBSTRING(mes, 1, 3), TRIM(cli.fecha_nacimiento)) ELSE CHARINDEX(mes, TRIM(cli.fecha_nacimiento)) END)-1), '(1)',''), '1)', ''), '1.', ''))
                                                    ))) > 1 THEN 
                                                SUBSTRING(TRIM(SUBSTRING(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(SUBSTRING(cli.fecha_nacimiento, 1, MIN(CASE CHARINDEX(mes, TRIM(cli.fecha_nacimiento)) WHEN 0 THEN CHARINDEX(SUBSTRING(mes, 1, 3), TRIM(cli.fecha_nacimiento)) ELSE CHARINDEX(mes, TRIM(cli.fecha_nacimiento))END)-1),'(1)',''), '1)', ''), '1.', ''),'1 Y 2)', ''), '1   ', ''), 
                                                            PATINDEX('%[0-9]%', REPLACE(REPLACE(REPLACE(REPLACE(REPLACE( SUBSTRING(cli.fecha_nacimiento, 1, MIN(CASE CHARINDEX(mes, TRIM(cli.fecha_nacimiento)) WHEN 0 THEN CHARINDEX(SUBSTRING(mes, 1, 3), TRIM(cli.fecha_nacimiento)) ELSE CHARINDEX(mes, TRIM(cli.fecha_nacimiento)) END)-1), '(1)',''), '1)', ''), '1.', ''),'1 Y 2)', ''), '1   ', '')), 
                                                            LEN(cli.fecha_nacimiento) - PATINDEX('%[0-9]%', REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(SUBSTRING(cli.fecha_nacimiento, 1, MIN(CASE CHARINDEX(mes, TRIM(cli.fecha_nacimiento)) WHEN 0 THEN CHARINDEX(SUBSTRING(mes, 1, 3), TRIM(cli.fecha_nacimiento)) ELSE CHARINDEX(mes, TRIM(cli.fecha_nacimiento)) END)-1), '(1)',''), '1)', ''), '1.', ''),'1 Y 2)', ''), '1   ', ''))
                                                        )), 1,
                                                        PATINDEX('%[^0-9]%',
                                                            TRIM(SUBSTRING(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(SUBSTRING(cli.fecha_nacimiento, 1, MIN(CASE CHARINDEX(mes, TRIM(cli.fecha_nacimiento)) WHEN 0 THEN CHARINDEX(SUBSTRING(mes, 1, 3), TRIM(cli.fecha_nacimiento)) ELSE CHARINDEX(mes, TRIM(cli.fecha_nacimiento))END)-1),'(1)',''), '1)', ''), '1.', ''),'1 Y 2)', ''), '1   ', ''), 
                                                                PATINDEX('%[0-9]%', REPLACE(REPLACE(REPLACE(REPLACE(REPLACE( SUBSTRING(cli.fecha_nacimiento, 1, MIN(CASE CHARINDEX(mes, TRIM(cli.fecha_nacimiento)) WHEN 0 THEN CHARINDEX(SUBSTRING(mes, 1, 3), TRIM(cli.fecha_nacimiento)) ELSE CHARINDEX(mes, TRIM(cli.fecha_nacimiento)) END)-1), '(1)',''), '1)', ''), '1.', ''),'1 Y 2)', ''), '1   ', '')), 
                                                                LEN(cli.fecha_nacimiento) - PATINDEX('%[0-9]%', REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(SUBSTRING(cli.fecha_nacimiento, 1, MIN(CASE CHARINDEX(mes, TRIM(cli.fecha_nacimiento)) WHEN 0 THEN CHARINDEX(SUBSTRING(mes, 1, 3), TRIM(cli.fecha_nacimiento)) ELSE CHARINDEX(mes, TRIM(cli.fecha_nacimiento)) END)-1), '(1)',''), '1)', ''), '1.', ''),'1 Y 2)', ''), '1   ', ''))
                                                            )))-1)
                                            ELSE TRIM(SUBSTRING(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(SUBSTRING(cli.fecha_nacimiento, 1, MIN(CASE CHARINDEX(mes, TRIM(cli.fecha_nacimiento)) WHEN 0 THEN CHARINDEX(SUBSTRING(mes, 1, 3), TRIM(cli.fecha_nacimiento)) ELSE CHARINDEX(mes, TRIM(cli.fecha_nacimiento))END)-1),'(1)',''), '1)', ''), '1.', ''),'1 Y 2)', ''), '1   ', ''), 
                                                    PATINDEX('%[0-9]%', REPLACE(REPLACE(REPLACE(REPLACE(REPLACE( SUBSTRING(cli.fecha_nacimiento, 1, MIN(CASE CHARINDEX(mes, TRIM(cli.fecha_nacimiento)) WHEN 0 THEN CHARINDEX(SUBSTRING(mes, 1, 3), TRIM(cli.fecha_nacimiento)) ELSE CHARINDEX(mes, TRIM(cli.fecha_nacimiento)) END)-1), '(1)',''), '1)', ''), '1.', ''),'1 Y 2)', ''), '1   ', '')), 
                                                    LEN(cli.fecha_nacimiento) - PATINDEX('%[0-9]%',REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(SUBSTRING(cli.fecha_nacimiento, 1, MIN(CASE CHARINDEX(mes, TRIM(cli.fecha_nacimiento)) WHEN 0 THEN CHARINDEX(SUBSTRING(mes, 1, 3), TRIM(cli.fecha_nacimiento)) ELSE CHARINDEX(mes, TRIM(cli.fecha_nacimiento)) END)-1), '(1)',''), '1)', ''), '1.', ''),'1 Y 2)', ''), '1   ', ''))
                                                ))
                                        END AS dia_fecha,
                                        MIN(CASE CHARINDEX(mes, REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(TRIM(cli.fecha_nacimiento),'1. ',''),'1.',''),' DEL ', '/'),' DE ', '/'),'-', '/'),' / ', '/'),'/ ', '/'),' /', '/'),' ', '/'),'.', '/'),'(1)', ''),'1) ', ''),'1)', ''), '1 Y 2)', ''),'1y2)', ''), '1/Y/2', ''))
                                            WHEN 0 THEN CHARINDEX(SUBSTRING(mes, 1, 3), REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(TRIM(cli.fecha_nacimiento),'1. ',''),'1.',''),' DEL ', '/'),' DE ', '/'),'-', '/'),' / ', '/'),'/ ', '/'),' /', '/'),' ', '/'),'.', '/'),'(1)', ''),'1) ', ''),'1)', ''), '1 Y 2)', ''),'1y2)', ''), '1/Y/2', ''))
                                            ELSE CHARINDEX(mes, REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(TRIM(cli.fecha_nacimiento),'1. ',''),'1.',''),' DEL ', '/'),' DE ', '/'),'-', '/'),' / ', '/'),'/ ', '/'),' /', '/'),' ', '/'),'.', '/'),'(1)', ''),'1) ', ''),'1)', ''), '1 Y 2)', ''),'1y2)', ''), '1/Y/2', ''))
                                        END) AS inicio
                                        FROM (SELECT '01' AS ENERO, '02' AS FEBRERO, '03' AS MARZO, '04' AS ABRIL, '05' AS MAYO, '06' AS JUNIO, '07' AS JULIO, '08' AS AGOSTO,
                                                '09' AS SEPTIEMBRE, '10' AS OCTUBRE, '11' AS NOVIEMBRE, '12' AS DICIEMBRE) AS meses
                                        UNPIVOT
                                            (num_mes FOR mes IN 
                                                (ENERO,	FEBRERO, MARZO,	ABRIL, MAYO, JUNIO, JULIO, AGOSTO,	SEPTIEMBRE, OCTUBRE, NOVIEMBRE,	DICIEMBRE)
                                            ) AS meses_render
                                        INNER JOIN clientes AS cli
                                        ON  cli.fecha_nacimiento LIKE '%'+meses_render.mes+'%' OR
                                            cli.fecha_nacimiento LIKE '%'+SUBSTRING(meses_render.mes,1,3)+'%'
                                        WHERE cli.status = 1
                                        GROUP BY cli.id_cliente, cli.fecha_nacimiento) AS meses
                        ON cli.id_cliente = meses.id_cliente AND
                        CASE CHARINDEX(mes, REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(TRIM(cli.fecha_nacimiento),'1. ',''),'1.',''), 'FE', 'DE'),' DEL ', '/'),' DE ', '/'),'-', '/'),' / ', '/'),'/ ', '/'),' /', '/'),' ', '/'),'.', '/'),'(1)', ''),'1) ', ''),'1)', ''), '1 Y 2)', ''),'1y2)', ''), '1/Y/2', ''), '//', '/'))
                            WHEN 0 THEN CHARINDEX(SUBSTRING(mes, 1, 3), REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(TRIM(cli.fecha_nacimiento),'1. ',''),'1.',''), 'FE', 'DE'),' DEL ', '/'),' DE ', '/'),'-', '/'),' / ', '/'),'/ ', '/'),' /', '/'),' ', '/'),'.', '/'),'(1)', ''),'1) ', ''),'1)', ''), '1 Y 2)', ''),'1y2)', ''), '1/Y/2', ''), '//', '/'))
                            ELSE CHARINDEX(mes, REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(TRIM(cli.fecha_nacimiento),'1. ',''),'1.',''), 'FE', 'DE'),' DEL ', '/'),' DE ', '/'),'-', '/'),' / ', '/'),'/ ', '/'),' /', '/'),' ', '/'),'.', '/'),'(1)', ''),'1) ', ''),'1)', ''), '1 Y 2)', ''),'1y2)', ''), '1/Y/2', ''), '//', '/'))
                        END = meses.inicio
                        WHERE cli.status = 1) AS cli_fec_nac
            ON cli.id_cliente = cli_fec_nac.id_cliente
            WHERE cli.status = 1 AND oxc.id_catalogo = 10 AND oxc.estatus = 1 $where
            ORDER BY cli.id_cliente");
        return $query->result_array();
    }

    function clienteAutorizacion(int $id)
    {
        $query = $this->db->query("SELECT c.id_cliente, c.nombre, c.apellido_paterno, c.apellido_materno, c.correo, c.telefono1, c.lada_tel,
                acc.id_aut_clientes AS id_aut_correo, c.autorizacion_correo, acc.codigo AS codigo_correo, 
                acs.id_aut_clientes AS id_aut_sms, c.autorizacion_sms, acs.codigo AS codigo_sms,
                ISNULL(tipo_correo_aut.total, 0) AS total_sol_correo_aut, ISNULL(tipo_correo_pend.total, 0) AS total_sol_correo_pend, 
	            ISNULL(tipo_sms_aut.total, 0) AS total_sol_sms_aut, ISNULL(tipo_sms_pend.total, 0) AS total_sol_sms_pend
            FROM clientes c
            INNER JOIN lotes l ON l.idCliente = c.id_cliente
            LEFT JOIN codigo_autorizaciones acc ON c.id_cliente = acc.id_cliente AND acc.tipo = 2
            LEFT JOIN codigo_autorizaciones acs ON c.id_cliente = acs.id_cliente AND acs.tipo = 3
            LEFT JOIN (SELECT COUNT(*) AS total, idCliente, idLote
                FROM autorizaciones
                WHERE id_tipo = 2 AND estatus = 0
                GROUP BY idCliente, idLote) tipo_correo_aut ON tipo_correo_aut.idCliente = $id AND tipo_correo_aut.idLote = l.idLote
            
            LEFT JOIN (SELECT COUNT(*) AS total, idCliente, idLote
                FROM autorizaciones
                WHERE id_tipo = 2 AND estatus = 1
                GROUP BY idCliente, idLote) tipo_correo_pend ON tipo_correo_pend.idCliente = $id AND tipo_correo_pend.idLote = l.idLote
            
            LEFT JOIN (SELECT COUNT(*) AS total, idCliente, idLote
                FROM autorizaciones
                WHERE id_tipo = 3 AND estatus = 0
                GROUP BY idCliente, idLote) tipo_sms_aut ON tipo_sms_aut.idCliente = $id AND tipo_sms_aut.idLote = l.idLote
            
            LEFT JOIN (SELECT COUNT(*) AS total, idCliente, idLote
                FROM autorizaciones
                WHERE id_tipo = 3 AND estatus = 1
                GROUP BY idCliente, idLote) tipo_sms_pend ON tipo_sms_pend.idCliente = $id AND tipo_sms_pend.idLote = l.idLote
            WHERE c.id_cliente = $id");
        return $query->row();
    }

    public function getCancelacionesProceso($idUsuario, $idRol, $fechaInicio, $fechaFin) {
        $condicion = ($idRol == 6)
            ? "AND cl.id_gerente = $idUsuario"
            : 'AND cl.cancelacion_proceso = 1';

        $query = $this->db->query("SELECT lo.idLote, lo.nombreLote, lo.idCliente, UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) AS cliente, 
        CONVERT(VARCHAR, cl.fechaApartado, 20) as fechaApartado, co.nombre AS nombreCondominio, re.nombreResidencial,
        CASE WHEN u0.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) END nombreAsesor,
        CASE WHEN u1.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) END nombreCoordinador,
        CASE WHEN u2.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) END nombreGerente,
        CASE WHEN u3.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) END nombreSubdirector,
        CASE WHEN u4.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) END nombreRegional,
        CASE WHEN u5.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u5.nombre, ' ', u5.apellido_paterno, ' ', u5.apellido_materno)) END nombreRegional2,
        cl.cancelacion_proceso, cp.nombre AS nombreCancelacion, cp.color
        FROM lotes lo
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.idLote = lo.idLote AND cl.status = 1 AND cl.fechaApartado BETWEEN '$fechaInicio 00:00:00' AND '$fechaFin 23:59:59'
        INNER JOIN condominios co ON lo.idCondominio = co.idCondominio
        INNER JOIN residenciales re ON co.idResidencial = re.idResidencial
        INNER JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
        LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
        LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
        LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
        LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
        LEFT JOIN usuarios u5 ON u5.id_usuario = cl.id_regional_2
        INNER JOIN opcs_x_cats cp ON cp.id_opcion = cl.cancelacion_proceso AND cp.id_catalogo = 94
        WHERE lo.idStatusLote IN (2, 3) $condicion");

        return $query->result_array();
    }

    public function getLotesApartadosReubicacion($fechaInicio, $fechaFin)
    {
        $query = $this->db->query("SELECT l.idLote, l.nombreLote,
            UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) AS cliente, CONVERT(VARCHAR, cl.fechaApartado, 20) as fechaApartado, CONVERT(VARCHAR, cl.fechaAlta, 20) AS fechaAlta,
            cond.nombre AS nombreCondominio, 
            res.nombreResidencial, cl.apartadoXReubicacion,
            CASE WHEN ase.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(ase.nombre, ' ', ase.apellido_paterno, ' ', ase.apellido_materno)) END asesor,
            CASE WHEN coord.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(coord.nombre, ' ', coord.apellido_paterno, ' ', coord.apellido_materno)) END coordinador,
            CASE WHEN ge.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ', ge.apellido_materno)) END gerente,
            CASE WHEN sub.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(sub.nombre, ' ', sub.apellido_paterno, ' ', sub.apellido_materno)) END subdirector,
            CASE WHEN reg.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(reg.nombre, ' ', reg.apellido_paterno, ' ', reg.apellido_materno)) END regional,
            CASE WHEN reg2.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(reg2.nombre, ' ', reg2.apellido_paterno, ' ', reg2.apellido_materno)) END regional2
        FROM lotes l 
        LEFT JOIN clientes cl ON l.idLote = cl.idLote
        LEFT JOIN condominios cond ON l.idCondominio = cond.idCondominio
        LEFT JOIN residenciales as res ON cond.idResidencial = res.idResidencial
        LEFT JOIN usuarios ase ON ase.id_usuario = cl.id_asesor
        LEFT JOIN usuarios coord ON coord.id_usuario = cl.id_coordinador
        LEFT JOIN usuarios ge ON ge.id_usuario = cl.id_gerente
        LEFT JOIN usuarios sub ON sub.id_usuario = cl.id_subdirector
        LEFT JOIN usuarios reg ON reg.id_usuario = cl.id_regional
        LEFT JOIN usuarios reg2 ON reg2.id_usuario = cl.id_regional_2
        WHERE cl.apartadoXReubicacion = 1 AND cl.fechaApartado BETWEEN '$fechaInicio 00:00:00' AND '$fechaFin 23:59:59'");

        return $query->result_array();
    }

    public function buscarPorId($idCliente)
    {
        $query = $this->db->query("SELECT * FROM clientes WHERE id_cliente = $idCliente");

        return $query->row();
    }

    public function actualizarProspectosPorPropietario($idOwner, $data)
    {
        $set = '';

        foreach (array_keys($data) as $key) {
            if (empty($set)) {
                $set .= "$key = $data[$key]";
                continue;
            }

            $set .= ", $key = $data[$key]";
        }

        $this->db->query("UPDATE prospectos SET $set WHERE id_asesor = $idOwner AND becameClient IS NULL");
    }
}
