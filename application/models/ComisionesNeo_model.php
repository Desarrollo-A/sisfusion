<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ComisionesNeo_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->gphsis = $this->load->database('GPHSIS', TRUE);
    }

    public function getStatusNeodata($lote){
        $pre_validate = $this->db->query("SELECT l.id_estado FROM lotes l WHERE l.status = 1 AND l.idLote = $lote");
        $var = $pre_validate->row()->id_estado;
        if($var == 1){
            $filter = " l.id_desarrollo_n AS idResidencial";
        }else{
            $filter = " r.idResidencial ";
        }

        $validate = $this->db->query("SELECT l.referencia, $filter FROM lotes l INNER JOIN condominios c ON c.idCondominio = l.idCondominio INNER JOIN residenciales r ON r.idResidencial = c.idResidencial INNER JOIN clientes cl ON cl.id_cliente = l.idCliente WHERE l.status = 1 AND cl.status = 1 AND l.idLote = $lote");

        if($validate->num_rows()>0){
            $ref = $validate->row()->referencia;
            $des = $validate->row()->idResidencial;
            return $this->gphsis->query("EXEC [GPHSIS].[dbo].[004VerificaconNeoPrueba2] @referencia = $ref, @iddesarrollo = $des");
        }else{
            return false;
        }
    }

    function getGeneralStatusFromNeodata($referencia, $desarrollo){
        return $this->gphsis->query("EXEC [GPHSIS].[dbo].[004VerificaconNeoPrueba2] @referencia = $referencia, @iddesarrollo = $desarrollo")->row();
    }

    function getLotesByAdviser($proyecto, $condominio)
    {
        switch ($this->session->userdata('id_rol')) {
            case '3':// GERENTE VENTAS
            if ($condominio == 0) { // SE FILTRA POR PROYECTO
                return $this->db->query("(SELECT l.referencia, r.idResidencial, l.idLote FROM lotes l
                    INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                    INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                    INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                    WHERE cl.id_gerente = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones) AND cl.fechaApartado >= '2020-03-01' AND r.idResidencial = $proyecto AND idStatusContratacion between 9 and 15 and tipo_venta in (0,1,2)) 
                    UNION 
                    (SELECT l.referencia, r.idResidencial, l.idLote FROM lotes l
                    INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                    INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                    INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                    WHERE cl.id_gerente = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 AND l.registro_comision = 1 AND l.idLote IN (SELECT id_lote FROM pago_comision where bandera not in (0,7)) AND cl.fechaApartado >= '2020-03-01' AND r.idResidencial = $proyecto AND idStatusContratacion between 9 and 15 and tipo_venta in (0,1,2))")->result_array();
                    
                    }else { // SE FILTRA POR CONDOMINIO
                        return $this->db->query("(SELECT l.referencia, r.idResidencial, l.idLote FROM lotes l
                            INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                            INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                            INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                            WHERE cl.id_gerente = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones) AND cl.fechaApartado >= '2020-03-01' AND c.idCondominio = $condominio AND idStatusContratacion between 9 and 15 and tipo_venta in (0,1,2)) 
                            UNION 
                            (SELECT l.referencia, r.idResidencial, l.idLote FROM lotes l
                            INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                            INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                            INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                            WHERE cl.id_gerente = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 AND l.registro_comision = 1 AND l.idLote IN (SELECT id_lote FROM pago_comision where bandera not in (0,7)) AND cl.fechaApartado >= '2020-03-01' AND c.idCondominio = $condominio AND idStatusContratacion between 9 and 15 and tipo_venta in (0,1,2))")->result_array();
                    }
            break;

            case '9': // COORDINADOR VENTAS

            if ($condominio == 0) { // SE FILTRA POR PROYECTO
                return $this->db->query("(SELECT l.referencia, r.idResidencial, l.idLote FROM lotes l
                    INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                    INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                    INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                    WHERE cl.id_coordinador = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones) AND cl.fechaApartado >= '2020-03-01' AND r.idResidencial = $proyecto AND idStatusContratacion between 9 and 15 and tipo_venta in (0,1,2)) 
                    UNION 
                    (SELECT l.referencia, r.idResidencial, l.idLote FROM lotes l
                    INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                    INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                    INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                    WHERE cl.id_coordinador = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 AND l.registro_comision = 1 AND l.idLote IN (SELECT id_lote FROM pago_comision where bandera not in (0,7)) AND cl.fechaApartado >= '2020-03-01' AND r.idResidencial = $proyecto AND idStatusContratacion between 9 and 15 and tipo_venta in (0,1,2))")->result_array();

                    }else { // SE FILTRA POR CONDOMINIO
                        return $this->db->query("(SELECT l.referencia, r.idResidencial, l.idLote FROM lotes l
                            INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                            INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                            INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                            WHERE cl.id_coordinador = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones) AND cl.fechaApartado >= '2020-03-01' AND c.idCondominio = $condominio AND idStatusContratacion between 9 and 15 and tipo_venta in (0,1,2)) 
                            UNION 
                            (SELECT l.referencia, r.idResidencial, l.idLote FROM lotes l
                            INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                            INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                            INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                            WHERE cl.id_coordinador = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 AND l.registro_comision = 1 AND l.idLote IN (SELECT id_lote FROM pago_comision where bandera not in (0,7)) AND cl.fechaApartado >= '2020-03-01' AND c.idCondominio = $condominio AND idStatusContratacion between 9 and 15 and tipo_venta in (0,1,2))")->result_array();
                    }
            break;

            case '7':// ASESOR VENTAS
            if ($condominio == 0) { // SE FILTRA POR PROYECTO
                return $this->db->query("(SELECT l.referencia, r.idResidencial, l.idLote FROM lotes l
                    INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                    INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                    INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                    WHERE cl.id_asesor = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones) AND cl.fechaApartado >= '2020-03-01' AND r.idResidencial = $proyecto AND idStatusContratacion between 9 and 15 and tipo_venta in (0,1,2))
                    UNION 
                    (SELECT l.referencia, r.idResidencial, l.idLote FROM lotes l
                    INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                    INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                    INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                    WHERE cl.id_asesor = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 AND l.registro_comision = 1 AND l.idLote IN (SELECT id_lote FROM pago_comision where bandera not in (0,7)) AND cl.fechaApartado >= '2020-03-01' AND r.idResidencial = $proyecto AND idStatusContratacion between 9 and 15 and tipo_venta in (0,1,2))")->result_array();

                    }else { // SE FILTRA POR CONDOMINIO
                        return $this->db->query("(SELECT l.referencia, r.idResidencial, l.idLote FROM lotes l
                            INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                            INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                            INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                            WHERE cl.id_asesor = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones) AND cl.fechaApartado >= '2020-03-01' AND c.idCondominio = $condominio AND idStatusContratacion between 9 and 15 and tipo_venta in (0,1,2)) UNION 
                            (SELECT l.referencia, r.idResidencial, l.idLote FROM lotes l
                            INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                            INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                            INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                            WHERE cl.id_asesor = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 AND l.registro_comision = 1 AND l.idLote IN (SELECT id_lote FROM pago_comision where bandera not in (0,7)) AND cl.fechaApartado >= '2020-03-01' AND c.idCondominio = $condominio AND idStatusContratacion between 9 and 15 and tipo_venta in (0,1,2))")->result_array();
                    }
            break;

            case '2':// VENTAS SUB
            if ($condominio == 0) { // SE FILTRA POR PROYECTO
                return $this->db->query("(SELECT l.referencia, r.idResidencial, l.idLote FROM lotes l
                    INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                    INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                    INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                    INNER JOIN usuarios ge on ge.id_usuario=cl.id_gerente
                    WHERE ge.id_lider = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones) AND cl.fechaApartado >= '2020-03-01' AND r.idResidencial = $proyecto AND idStatusContratacion between 9 and 15 and tipo_venta in (0,1,2)) 
                    UNION 
                    (SELECT l.referencia, r.idResidencial, l.idLote FROM lotes l
                    INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                    INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                    INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                    INNER JOIN usuarios ge on ge.id_usuario=cl.id_gerente
                    WHERE ge.id_lider = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 AND l.registro_comision = 1 AND l.idLote IN (SELECT id_lote FROM pago_comision where bandera not in (0,7)) AND cl.fechaApartado >= '2020-03-01' AND r.idResidencial = $proyecto AND idStatusContratacion between 9 and 15 and tipo_venta in (0,1,2))")->result_array();

                    }else { // SE FILTRA POR CONDOMINIO
                        return $this->db->query("(SELECT l.referencia, r.idResidencial, l.idLote FROM lotes l
                            INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                            INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                            INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                            INNER JOIN usuarios ge on ge.id_usuario=cl.id_gerente
                            WHERE ge.id_lider = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones) AND cl.fechaApartado >= '2020-03-01' AND c.idCondominio = $condominio AND idStatusContratacion between 9 and 15 and tipo_venta in (0,1,2)) 
                            UNION 
                            (SELECT l.referencia, r.idResidencial, l.idLote FROM lotes l
                            INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                            INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                            INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                            INNER JOIN usuarios ge on ge.id_usuario=cl.id_gerente
                            WHERE ge.id_lider = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 AND l.registro_comision = 1 AND l.idLote IN (SELECT id_lote FROM pago_comision where bandera not in (0,7)) AND cl.fechaApartado >= '2020-03-01' AND c.idCondominio = $condominio AND idStatusContratacion between 9 and 15 and tipo_venta in (0,1,2))")->result_array();
                    }
            break;

            case '1':// VENTAS DIR
            if ($condominio == 0) { // SE FILTRA POR PROYECTO
                return $this->db->query("(SELECT l.referencia, r.idResidencial, l.idLote FROM lotes l
                    INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                    INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                    INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                    WHERE l.status = 1 AND cl.status = 1 AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones) AND cl.fechaApartado >= '2020-03-01' AND r.idResidencial = $proyecto AND idStatusContratacion between 9 and 15 and tipo_venta in (0,1,2)) 
                    UNION (SELECT l.referencia, r.idResidencial, l.idLote FROM lotes l
                    INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                    INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                    INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                    WHERE l.status = 1 AND cl.status = 1 AND l.registro_comision = 1 AND l.idLote IN (SELECT id_lote FROM pago_comision where bandera not in (0,7)) AND cl.fechaApartado >= '2020-03-01' AND r.idResidencial = $proyecto AND idStatusContratacion between 9 and 15 and tipo_venta in (0,1,2))")->result_array();

                    }else { // SE FILTRA POR CONDOMINIO
                        return $this->db->query("(SELECT l.referencia, r.idResidencial, l.idLote FROM lotes l
                            INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                            INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                            INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                            WHERE l.status = 1 AND cl.status = 1 AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones) AND cl.fechaApartado >= '2020-03-01' AND c.idCondominio = $condominio AND idStatusContratacion between 9 and 15 and tipo_venta in (0,1,2)) 7
                            UNION (SELECT l.referencia, r.idResidencial, l.idLote FROM lotes l
                            INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                            INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                            INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                            WHERE l.status = 1 AND cl.status = 1 AND l.registro_comision = 1 AND l.idLote IN (SELECT id_lote FROM pago_comision where bandera not in (0,7)) AND cl.fechaApartado >= '2020-03-01' AND c.idCondominio = $condominio AND idStatusContratacion between 9 and 15 and tipo_venta in (0,1,2))")->result_array();
                    }
            break;

            case '11':// ADMINISTRACIÓN
            case '17':// CONTRA
            case '13':// CONTRA
            case '32':// CONTRA

            if ($condominio == 0) { // SE FILTRA POR PROYECTO
                return $this->db->query("SELECT l.referencia, r.idResidencial, l.idLote FROM lotes l
                    INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                    INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                    INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                    WHERE l.status = 1 AND cl.status = 1 AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones) AND cl.fechaApartado >= '2020-03-01' AND r.idResidencial = $proyecto AND idStatusContratacion between 9 and 15 and tipo_venta in (0,1,2)")->result_array();

                    }else { // SE FILTRA POR CONDOMINIO
                        return $this->db->query("SELECT l.referencia, r.idResidencial, l.idLote FROM lotes l
                            INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                            INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                            INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                            WHERE l.status = 1 AND cl.status = 1 AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones) AND cl.fechaApartado >= '2020-03-01' AND c.idCondominio = $condominio AND idStatusContratacion between 9 and 15 and tipo_venta in (0,1,2)")->result_array();
                    }
            break;

            default:// CONTRALORÍA
            return $this->db->query("SELECT l.referencia, r.idResidencial, l.idLote FROM lotes l
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                WHERE l.status = 1 AND cl.status = 1 AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones) AND cl.fechaApartado >= '2020-03-01' AND c.idCondominio = $condominio AND idStatusContratacion between 9 and 15 and tipo_venta in (0,1,2)")->result_array();
            break;
        }
    }

    public function getLotesAAA(){
        return $this->db->query("SELECT l.referencia, r.idResidencial, l.idLote FROM lotes l
            INNER JOIN condominios c ON c.idCondominio = l.idCondominio
            INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
            INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
            INNER JOIN usuarios u ON u.id_usuario = cl.id_gerente
            WHERE l.status = 1 AND cl.status = 1 AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones) AND cl.fechaApartado >= '2020-03-01' AND l.referencia IS NOT NULL AND l.idStatusContratacion between 9 and 15 and l.tipo_venta in (0,1,2) AND r.idResidencial in (17)")->result_array();
    }

    function getLoteInformation($idLote){ 
        return $this->db->query("SELECT l.referencia, r.idResidencial, l.idLote, l.nombreLote, c.nombre nombreCondominio,
                                r.nombreResidencial, CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) nombreCliente, 
                                CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreAsesor,
                                CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) nombreCoordinador,
                                CONCAT(uuu.nombre, ' ', uuu.apellido_paterno, ' ', uuu.apellido_materno) nombreGerente,
                                'Sin pago reflejado en NEODATA' reason
                                FROM lotes l 
                                INNER JOIN condominios c ON c.idCondominio = l.idCondominio 
                                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial 
                                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente 
                                INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor 
                                LEFT JOIN usuarios uu ON uu.id_usuario = cl.id_coordinador 
                                INNER JOIN usuarios uuu ON uuu.id_usuario = cl.id_gerente 
                                WHERE l.status = 1 AND cl.status = 1 AND l.idLote = $idLote ORDER BY r.nombreResidencial, c.nombre, l.nombreLote, nombreCliente")->row();
    }

    public function getLotesPagados($res){
        return $this->db->query("SELECT p.id_lote,p.bandera,l.registro_comision,p.ultimo_pago,l.referencia,r.idResidencial 
            FROM pago_comision p
            INNER JOIN lotes l ON l.idLote = p.id_lote
            INNER JOIN condominios c ON c.idCondominio = l.idCondominio
            INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
            WHERE p.bandera = 1 AND l.registro_comision IN (1,5) AND l.idStatusContratacion = 15 AND p.ultimo_pago > 0 AND r.idResidencial = $res");
    }

    public function UpdateBanderaPagoComision($idLote, $bonificacion, $FechaAplicado){
        return $this->db->query("UPDATE pago_comision SET bandera = (case when numero_dispersion >= 2 then 2 else 0 end), fecha_modificacion = GETDATE(), bonificacion = ".$bonificacion.", fecha_neodata = '".$FechaAplicado."', modificado_por = 'NEO' WHERE id_lote = ".$idLote."");
        $this->db->query("UPDATE lotes SET registro_comision = 1 WHERE registro_comision = 5 AND idLote = ".$idLote."");

    }

    public function UpdateBanderaPagoComisionNO($idLote){
        return $this->db->query("UPDATE pago_comision SET bandera = 55, modificado_por = 'NEO' WHERE id_lote = $idLote");
        $this->db->query("DELETE FROM comisiones where id_usuario = 0");
        

    }

    public function UpdateBanderaPagoComisionAnticipo(){
        return $this->db->query("UPDATE pago_comision SET CASE bandera = 0, fecha_modificacion = GETDATE(), modificado_por = 'NEO' FROM pago_comision P INNER JOIN lotes l ON l.idLote = p.id_lote WHERE p.bandera not in (0,8) AND l.registro_comision = 1 AND l.idStatusContratacion = 15 AND p.ultimo_pago > 0 AND p.pendiente > 1 AND p.ultimo_pago > p.total_comision");
    }

    public function getPrioridad($prioridad){
        return $this->db->query("SELECT id_plan, CONCAT(where_principal,' ', fecha_inicio, ' ', fecha_fin, ' ', lugar_prospeccion, ' ', regional, ' ', otro) cadena FROM plan_comision WHERE prioridad = $prioridad");
    }

    public function updatePlan($prioridad, $plan){
        $whereData =  $this->db->query("SELECT CONCAT(where_principal,' ', fecha_inicio, ' ', fecha_fin, ' ', lugar_prospeccion, ' ', venta_regional, ' ', otro_vobo) cadena FROM plan_comision WHERE id_plan = $plan AND prioridad = $prioridad");
        $whereRes = $whereData->row()->cadena;

        return $this->db->query("UPDATE clientes set modificado_por = 1, plan_comision = $plan where id_cliente in (
            SELECT cl.id_cliente FROM clientes cl
            INNER JOIN lotes l on l.idCliente = cl.id_cliente AND l.status = 1 AND l.registro_comision not in (7) AND l.idStatusContratacion BETWEEN 9 AND 15
            INNER JOIN condominios c on c.idCondominio = l.idCondominio
            INNER JOIN residenciales r on r.idResidencial = c.idResidencial
            INNER JOIN usuarios ae on ae.id_usuario = cl.id_asesor
            LEFT JOIN prospectos ps on ps.id_prospecto = cl.id_prospecto AND cl.lugar_prospeccion = 6
            $whereRes AND l.tipo_venta IS NOT NULL AND l.tipo_venta IN (1,2,7) AND cl.status = 1 AND cl.fechaApartado >= '2020-03-01' and cl.id_sede not in (0) and (cl.plan_comision is null OR cl.plan_comision IN (0)) )");
    }

    public function getFlag(){
        return $this->db->query("SELECT cm.id_lote, sum(cm.comision_total) as total,  (sum(cm.comision_total) - pc.total_comision) resta, 
            (CASE when pc.bandera = 0 then 10 when pc.bandera = 55 then 15 when pc.bandera = 1 then 11 when pc.bandera = 7 then 17 end) as bandera
        FROM comisiones cm
        INNER JOIN pago_comision pc on pc.id_lote = cm.id_lote 
        INNER JOIN lotes lo on lo.idLote = cm.id_lote AND lo.registro_comision not in (8)
        WHERE cm.estatus = 1 AND cm.id_usuario NOT IN (0) AND pc.bandera in (0,1,7,55) and (cm.descuento is null OR cm.descuento = 0) --and pc.id_lote = 33355
        GROUP BY cm.id_lote, pc.total_comision, pc.bandera
        HAVING (sum(cm.comision_total) - pc.total_comision) not between -1 and 1  
        order by cm.id_lote");
    }

    public function updateFlag($a, $b, $c){
        return $this->db->query("UPDATE pago_comision SET total_comision = $b, bandera = $c, modificado_por = 'NEO' WHERE id_lote in ($a)");
    }

    public function getFlagAbonado(){
        return $this->db->query("SELECT DISTINCT(cm.id_lote), SUM(abono_neodata) abonado, (sum(abono_neodata) - pc.abonado) resta, (CASE when pc.bandera = 10 then 100 when pc.bandera = 0 then 100 when pc.bandera = 55 then 150 when pc.bandera = 15 then 150 when pc.bandera = 1 then 110 when pc.bandera = 11 then 110 when pc.bandera = 7 then 170 when pc.bandera = 17 then 170 end) as bandera
               FROM pago_comision_ind pci
               INNER JOIN comisiones cm on cm.id_comision = pci.id_comision and cm.estatus = 1
               INNER JOIN pago_comision pc on pc.id_lote = cm.id_lote 
               WHERE cm.estatus = 1 and (cm.descuento is null OR cm.descuento = 0) and pc.bandera not in (100, 150, 110, 170)
               GROUP BY cm.id_lote, pc.abonado, pc.bandera
               HAVING (SUM(abono_neodata) - pc.abonado) not between -1 and 1");
    }

    public function updateFlagAbonado($a, $b, $c){
        return $this->db->query("UPDATE pago_comision SET abonado = $b, bandera = $c, modificado_por = 'NEO' WHERE id_lote in ($a)");
    }

    public function getFlagPendiente(){
        return $this->db->query("SELECT pc.id_lote, (CASE when pc.bandera = 100 then 0 when pc.bandera = 150 then 55 when pc.bandera = 110 then 1 when pc.bandera = 170 then 7 else pc.bandera end) as bandera FROM pago_comision pc WHERE pc.bandera in (100, 150, 110, 170)");
    }
    
    public function updateFlagPendiente($a, $b){
        $this->db->query("UPDATE pago_comision SET pendiente = total_comision - abonado, bandera = $b, modificado_por = 'NEO' WHERE id_lote in ($a)");
    }

    public function updateFlagPendienteDistintos(){
        $this->db->query("UPDATE pago_comision SET pendiente = total_comision - abonado, modificado_por = 'NEO' WHERE total_comision not in (0) and bandera not in (100, 150, 110, 170) ");
    }

    public function getLotesPagadosAutomatica($res){
        $cmd = "SELECT p.id_lote, p.numero_dispersion, 
        p.ultima_dispersion ,p.bandera,l.registro_comision, 
        p.ultimo_pago,l.referencia,r.idResidencial 
        FROM pago_comision p
        INNER JOIN lotes l ON l.idLote = p.id_lote
        INNER JOIN condominios c ON c.idCondominio = l.idCondominio
        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
        WHERE p.bandera = 1 
        AND l.registro_comision IN (1,5) 
        AND l.idStatusContratacion = 15 
        AND p.ultimo_pago > 0 
        AND r.idResidencial = $res";
        $query =  $this->db->query($cmd);
        return $query->result_array();
    }

}