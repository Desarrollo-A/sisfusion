<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ComisionesNeo_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->gphsis = $this->load->database('GPHSIS', TRUE);
    }

    public function getStatusNeodata($lote){
        $pre_validate = $this->db->query("SELECT l.id_estado FROM lotes l WHERE l.status = 1 AND l.idLote = $lote");

        
        
        if( !isset($pre_validate->row()->id_estado) )
        {
            $var = 2;
        }else{
            $var = $pre_validate->row()->id_estado;
        }
        
        
        if($var == 1){
            $filter = " l.id_desarrollo_n AS idResidencial";
        }else{
            $filter = " r.idResidencial ";
        }

        $validate = $this->db->query("SELECT l.referencia, $filter FROM lotes l INNER JOIN condominios c ON c.idCondominio = l.idCondominio INNER JOIN residenciales r ON r.idResidencial = c.idResidencial INNER JOIN clientes cl ON cl.id_cliente = l.idCliente WHERE l.status = 1 AND cl.status = 1 AND l.idLote = $lote");

        if($validate->num_rows()>0){
            $ref = $validate->row()->referencia;
            $des = $validate->row()->idResidencial;
            return $this->gphsis->query("EXEC [GPHSIS].[dbo].[004VerificaconNeoPrueba3] @referencia = $ref, @iddesarrollo = $des");
            return false;
        }else{
            return false;
        }
    }

    function getGeneralStatusFromNeodata($referencia, $desarrollo){
        return $this->gphsis->query("EXEC [GPHSIS].[dbo].[004VerificaconNeoPrueba3] @referencia = $referencia, @iddesarrollo = $desarrollo")->row();
    }

    function getLotesByAdviser($proyecto, $condominio)
    {
        switch ($this->session->userdata('id_rol')) {
            case '3':// GERENTE VENTAS
            if ($condominio == 0) { // SE FILTRA POR PROYECTO
                return $this->db->query("(SELECT l.referencia, r.idResidencial, l.idLote 
                FROM lotes l
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                WHERE cl.id_gerente = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones) AND cl.fechaApartado >= '2020-03-01' AND r.idResidencial = $proyecto AND idStatusContratacion BETWEEN 9 AND 15 AND tipo_venta IN (0,1,2)) 
                UNION 
                (SELECT l.referencia, r.idResidencial, l.idLote 
                FROM lotes l
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                WHERE cl.id_gerente = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 AND l.registro_comision = 1 AND l.idLote IN (SELECT id_lote FROM pago_comision WHERE bandera NOT IN (0,7)) AND cl.fechaApartado >= '2020-03-01' AND r.idResidencial = $proyecto AND idStatusContratacion BETWEEN 9 AND 15 AND tipo_venta IN (0,1,2))")->result_array();        
            }else { // SE FILTRA POR CONDOMINIO
                return $this->db->query("(SELECT l.referencia, r.idResidencial, l.idLote 
                FROM lotes l
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                WHERE cl.id_gerente = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones) AND cl.fechaApartado >= '2020-03-01' AND c.idCondominio = $condominio AND idStatusContratacion BETWEEN 9 AND 15 AND tipo_venta IN (0,1,2)) 
                UNION 
                (SELECT l.referencia, r.idResidencial, l.idLote 
                FROM lotes l
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                WHERE cl.id_gerente = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 AND l.registro_comision = 1 AND l.idLote IN (SELECT id_lote FROM pago_comision WHERE bandera NOT IN (0,7)) AND cl.fechaApartado >= '2020-03-01' AND c.idCondominio = $condominio AND idStatusContratacion BETWEEN 9 AND 15 AND tipo_venta IN (0,1,2))")->result_array();
            }
            break;

            case '9': // COORDINADOR VENTAS
            if ($condominio == 0) { // SE FILTRA POR PROYECTO
                return $this->db->query("(SELECT l.referencia, r.idResidencial, l.idLote 
                FROM lotes l
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                WHERE cl.id_coordinador = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones) AND cl.fechaApartado >= '2020-03-01' AND r.idResidencial = $proyecto AND idStatusContratacion BETWEEN 9 AND 15 AND tipo_venta IN (0,1,2)) 
                UNION 
                (SELECT l.referencia, r.idResidencial, l.idLote 
                FROM lotes l
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                WHERE cl.id_coordinador = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 AND l.registro_comision = 1 AND l.idLote IN (SELECT id_lote FROM pago_comision WHERE bandera NOT IN (0,7)) AND cl.fechaApartado >= '2020-03-01' AND r.idResidencial = $proyecto AND idStatusContratacion BETWEEN 9 AND 15 AND tipo_venta IN (0,1,2))")->result_array();
            }else { // SE FILTRA POR CONDOMINIO
                return $this->db->query("(SELECT l.referencia, r.idResidencial, l.idLote 
                FROM lotes l
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                WHERE cl.id_coordinador = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones) AND cl.fechaApartado >= '2020-03-01' AND c.idCondominio = $condominio AND idStatusContratacion BETWEEN 9 AND 15 AND tipo_venta IN (0,1,2)) 
                UNION 
                (SELECT l.referencia, r.idResidencial, l.idLote 
                FROM lotes l
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                WHERE cl.id_coordinador = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 AND l.registro_comision = 1 AND l.idLote IN (SELECT id_lote FROM pago_comision WHERE bandera NOT IN (0,7)) AND cl.fechaApartado >= '2020-03-01' AND c.idCondominio = $condominio AND idStatusContratacion BETWEEN 9 AND 15 AND tipo_venta IN (0,1,2))")->result_array();
            }
            break;

            case '7':// ASESOR VENTAS
            if ($condominio == 0) { // SE FILTRA POR PROYECTO
                return $this->db->query("(SELECT l.referencia, r.idResidencial, l.idLote 
                FROM lotes l
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                WHERE cl.id_asesor = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones) AND cl.fechaApartado >= '2020-03-01' AND r.idResidencial = $proyecto AND idStatusContratacion BETWEEN 9 AND 15 AND tipo_venta IN (0,1,2))
                UNION 
                (SELECT l.referencia, r.idResidencial, l.idLote 
                FROM lotes l
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                WHERE cl.id_asesor = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 AND l.registro_comision = 1 AND l.idLote IN (SELECT id_lote FROM pago_comision WHERE bandera NOT IN (0,7)) AND cl.fechaApartado >= '2020-03-01' AND r.idResidencial = $proyecto AND idStatusContratacion BETWEEN 9 AND 15 AND tipo_venta IN (0,1,2))")->result_array();
            }else { // SE FILTRA POR CONDOMINIO
                return $this->db->query("(SELECT l.referencia, r.idResidencial, l.idLote 
                FROM lotes l
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                WHERE cl.id_asesor = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones) AND cl.fechaApartado >= '2020-03-01' AND c.idCondominio = $condominio AND idStatusContratacion BETWEEN 9 AND 15 AND tipo_venta IN (0,1,2)) UNION 
                (SELECT l.referencia, r.idResidencial, l.idLote 
                FROM lotes l
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                WHERE cl.id_asesor = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 AND l.registro_comision = 1 AND l.idLote IN (SELECT id_lote FROM pago_comision WHERE bandera NOT IN (0,7)) AND cl.fechaApartado >= '2020-03-01' AND c.idCondominio = $condominio AND idStatusContratacion BETWEEN 9 AND 15 AND tipo_venta IN (0,1,2))")->result_array();
            }
            break;

            case '2':// VENTAS SUB
            if ($condominio == 0) { // SE FILTRA POR PROYECTO
                return $this->db->query("(SELECT l.referencia, r.idResidencial, l.idLote 
                FROM lotes l
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                INNER JOIN usuarios ge ON ge.id_usuario=cl.id_gerente
                WHERE ge.id_lider = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones) AND cl.fechaApartado >= '2020-03-01' AND r.idResidencial = $proyecto AND idStatusContratacion BETWEEN 9 AND 15 AND tipo_venta IN (0,1,2)) 
                UNION 
                (SELECT l.referencia, r.idResidencial, l.idLote 
                FROM lotes l
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                INNER JOIN usuarios ge ON ge.id_usuario=cl.id_gerente
                WHERE ge.id_lider = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 AND l.registro_comision = 1 AND l.idLote IN (SELECT id_lote FROM pago_comision WHERE bandera NOT IN (0,7)) AND cl.fechaApartado >= '2020-03-01' AND r.idResidencial = $proyecto AND idStatusContratacion BETWEEN 9 AND 15 AND tipo_venta IN (0,1,2))")->result_array();
            }else { // SE FILTRA POR CONDOMINIO
                return $this->db->query("(SELECT l.referencia, r.idResidencial, l.idLote 
                FROM lotes l
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                INNER JOIN usuarios ge ON ge.id_usuario=cl.id_gerente
                WHERE ge.id_lider = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones) AND cl.fechaApartado >= '2020-03-01' AND c.idCondominio = $condominio AND idStatusContratacion BETWEEN 9 AND 15 AND tipo_venta IN (0,1,2)) 
                UNION 
                (SELECT l.referencia, r.idResidencial, l.idLote 
                FROM lotes l
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                INNER JOIN usuarios ge ON ge.id_usuario=cl.id_gerente
                WHERE ge.id_lider = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 AND l.registro_comision = 1 AND l.idLote IN (SELECT id_lote FROM pago_comision WHERE bandera NOT IN (0,7)) AND cl.fechaApartado >= '2020-03-01' AND c.idCondominio = $condominio AND idStatusContratacion BETWEEN 9 AND 15 AND tipo_venta IN (0,1,2))")->result_array();
            }
            break;

            case '1':// VENTAS DIR
            if ($condominio == 0) { // SE FILTRA POR PROYECTO
                return $this->db->query("(SELECT l.referencia, r.idResidencial, l.idLote 
                FROM lotes l
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                WHERE l.status = 1 AND cl.status = 1 AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones) AND cl.fechaApartado >= '2020-03-01' AND r.idResidencial = $proyecto AND idStatusContratacion BETWEEN 9 AND 15 AND tipo_venta IN (0,1,2)) 
                UNION 
                (SELECT l.referencia, r.idResidencial, l.idLote 
                FROM lotes l
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                WHERE l.status = 1 AND cl.status = 1 AND l.registro_comision = 1 AND l.idLote IN (SELECT id_lote FROM pago_comision WHERE bandera NOT IN (0,7)) AND cl.fechaApartado >= '2020-03-01' AND r.idResidencial = $proyecto AND idStatusContratacion BETWEEN 9 AND 15 AND tipo_venta IN (0,1,2))")->result_array();
            }else { // SE FILTRA POR CONDOMINIO
                return $this->db->query("(SELECT l.referencia, r.idResidencial, l.idLote 
                FROM lotes l
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                WHERE l.status = 1 AND cl.status = 1 AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones) AND cl.fechaApartado >= '2020-03-01' AND c.idCondominio = $condominio AND idStatusContratacion BETWEEN 9 AND 15 AND tipo_venta IN (0,1,2)) 
                UNION 
                (SELECT l.referencia, r.idResidencial, l.idLote 
                FROM lotes l
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                WHERE l.status = 1 AND cl.status = 1 AND l.registro_comision = 1 AND l.idLote IN (SELECT id_lote FROM pago_comision WHERE bandera NOT IN (0,7)) AND cl.fechaApartado >= '2020-03-01' AND c.idCondominio = $condominio AND idStatusContratacion BETWEEN 9 AND 15 AND tipo_venta IN (0,1,2))")->result_array();
            }
            break;

            case '11':// ADMINISTRACIÓN
            case '17':// CONTRA
            case '63':// CONTRA
            case '32':// CONTRA
            if ($condominio == 0) { // SE FILTRA POR PROYECTO
                return $this->db->query("SELECT l.referencia, r.idResidencial, l.idLote 
                FROM lotes l
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                WHERE l.status = 1 AND cl.status = 1 AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones) AND cl.fechaApartado >= '2020-03-01' AND r.idResidencial = $proyecto AND idStatusContratacion BETWEEN 9 AND 15 AND tipo_venta IN (0,1,2)")->result_array();
            }else { // SE FILTRA POR CONDOMINIO
                return $this->db->query("SELECT l.referencia, r.idResidencial, l.idLote 
                FROM lotes l
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidenc ial = c.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                WHERE l.status = 1 AND cl.status = 1 AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones) AND cl.fechaApartado >= '2020-03-01' AND c.idCondominio = $condominio AND idStatusContratacion BETWEEN 9 AND 15 AND tipo_venta IN (0,1,2)")->result_array();
            }
            break;

            default:// CONTRALORÍA
                return $this->db->query("SELECT l.referencia, r.idResidencial, l.idLote 
                FROM lotes l
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                WHERE l.status = 1 AND cl.status = 1 AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones) AND cl.fechaApartado >= '2020-03-01' AND c.idCondominio = $condominio AND idStatusContratacion BETWEEN 9 AND 15 AND tipo_venta IN (0,1,2)")->result_array();
            break;
        }
    }

    public function getLotesAAA(){
        return $this->db->query("SELECT l.referencia, r.idResidencial, l.idLote 
        FROM lotes l
        INNER JOIN condominios c ON c.idCondominio = l.idCondominio
        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
        INNER JOIN usuarios u ON u.id_usuario = cl.id_gerente
        WHERE l.status = 1 AND cl.status = 1 AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones) AND cl.fechaApartado >= '2020-03-01' AND l.referencia IS NOT NULL AND l.idStatusContratacion BETWEEN 9 AND 15 AND l.tipo_venta IN (0,1,2) AND r.idResidencial IN (17)")->result_array();
    }

    function getLoteInformation($idLote){ 
        return $this->db->query("SELECT l.referencia, r.idResidencial, l.idLote, l.nombreLote, c.nombre nombreCondominio, r.nombreResidencial, CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) nombreCliente, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreAsesor, CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) nombreCoordinador, CONCAT(uuu.nombre, ' ', uuu.apellido_paterno, ' ', uuu.apellido_materno) nombreGerente, 'Sin pago reflejado en NEODATA' reason
        FROM lotes l 
        INNER JOIN condominios c ON c.idCondominio = l.idCondominio 
        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial 
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente 
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor 
        LEFT JOIN usuarios uu ON uu.id_usuario = cl.id_coordinador 
        INNER JOIN usuarios uuu ON uuu.id_usuario = cl.id_gerente 
        WHERE l.status = 1 AND cl.status = 1 AND l.idLote = $idLote 
        ORDER BY r.nombreResidencial, c.nombre, l.nombreLote, nombreCliente")->row();
    }

    public function getLotesPagados($res){
        return $this->db->query("SELECT l.idLote as id_lote, l.registro_comision, ISNULL(p.ultimo_pago, 0) ultimo_pago,l.referencia,r.idResidencial
        FROM lotes l
        LEFT JOIN pago_comision p ON l.idLote = p.id_lote
        INNER JOIN condominios c ON c.idCondominio = l.idCondominio
        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
        LEFT JOIN (SELECT COUNT(*) total, id_lote FROM comisiones WHERE ooam = 1 GROUP BY id_lote) ooam ON ooam.id_lote = l.idLote
        LEFT JOIN (SELECT COUNT(*) total, id_lote FROM comisiones WHERE ooam = 2 GROUP BY id_lote) ventas ON ventas.id_lote = l.idLote
        WHERE (p.bandera = 1 AND l.registro_comision IN (1) 
		AND (l.idStatusContratacion = 15 OR (l.idStatusContratacion >= 9 AND (CASE WHEN ooam.total > 1 THEN 1 ELSE 0 END) = 0 
		AND (CASE WHEN ventas.total > 1 THEN 1 ELSE 0 END) = 1)) AND p.ultimo_pago > 0 AND r.idResidencial = 1
		AND (((abonado - ultimo_pago) > 10 AND (new_neo-ultimo_pago) > 10) OR (total_comision - abonado) > 10)  AND total_comision > 1)
		OR l.registro_comision IN (4,6) 
		OR (l.registro_comision IN (3) AND l.idStatusContratacion = 15 )");
    } 

    public function getLotesPagados2($res){
        return $this->db->query("SELECT p.id_lote,p.bandera,l.registro_comision,p.ultimo_pago,l.referencia,r.idResidencial 
        FROM pago_comision p
        INNER JOIN lotes l ON l.idLote = p.id_lote
        INNER JOIN condominios c ON c.idCondominio = l.idCondominio
        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
        WHERE p.bandera NOT IN (7) AND p.total_comision NOT IN (0) AND p.modificado_por = 'NEO' AND r.idResidencial = $res");
    }

    public function UpdateBanderaPagoComision2($idLote, $bonificacion, $FechaAplicado, $Aplicado){
        return $this->db->query("UPDATE pago_comision SET fecha_neodata = '".$FechaAplicado."', modificado_por = 'KUPDATE', new_neo = '".$Aplicado."' WHERE id_lote = ".$idLote."");
    }

    public function UpdateBanderaPagoComision($idLote, $bonificacion, $FechaAplicado, $FPoliza, $Aplicado){
        $this->db->query("UPDATE lotes SET registro_comision = 1 WHERE registro_comision IN (3,4,6) AND idLote = ".$idLote."");
        return $this->db->query("UPDATE pago_comision SET bandera = 0, fecha_modificacion = GETDATE(), bonificacion = ".$bonificacion.", fecha_neodata = '".$FechaAplicado."', modificado_por = 'NEO' WHERE id_lote = ".$idLote."");
    }

    public function UpdateBanderaPagoComisionNO($idLote){
        return $this->db->query("UPDATE pago_comision SET bandera = 55 WHERE id_lote = $idLote");
    }

    public function UpdateBanderaPagoComisionAnticipo(){
        return $this->db->query("UPDATE pago_comision SET bandera = 0, fecha_modificacion = GETDATE() FROM pago_comision P INNER JOIN lotes l ON l.idLote = p.id_lote WHERE p.bandera NOT IN (0,8) AND l.registro_comision = 1 AND l.idStatusContratacion = 15 AND p.ultimo_pago > 0 AND p.pendiente > 1 AND p.ultimo_pago > p.total_comision");
    }

    public function UpdateBanderaPagoComisionNewNeo(){
        return $this->db->query("UPDATE pago_comision SET bandera = 55, modificado_por = 'NEO_NN' FROM pago_comision WHERE (((abonado - ultimo_pago) < 1 AND (new_neo-ultimo_pago) < 1) OR (total_comision - abonado) < 1) AND bandera = 0 AND total_comision > 1");
    }

    public function getPrioridad($prioridad){
        return $this->db->query("SELECT id_plan, CONCAT(where_principal,' ', fecha_inicio, ' ', fecha_fin, ' ', lugar_prospeccion, ' ', regional, ' ', otro) cadena FROM plan_comision WHERE prioridad = $prioridad");
    }

    public function updatePlan($prioridad, $plan){
        $whereData =  $this->db->query("SELECT CONCAT(where_principal,' ', fecha_inicio, ' ', fecha_fin, ' ', lugar_prospeccion, ' ', venta_regional, ' ', otro_vobo) cadena FROM plan_comision WHERE id_plan = $plan AND prioridad = $prioridad");
        $whereRes = $whereData->row()->cadena;
        return $this->db->query("UPDATE clientes set modificado_por = 1, plan_comision = $plan WHERE id_cliente IN (
            SELECT cl.id_cliente FROM clientes cl
            INNER JOIN lotes l ON l.idCliente = cl.id_cliente AND l.status = 1 AND l.registro_comision NOT IN (7) AND l.idStatusContratacion BETWEEN 9 AND 15
            INNER JOIN condominios c ON c.idCondominio = l.idCondominio
            INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
            INNER JOIN usuarios ae ON ae.id_usuario = cl.id_asesor
            LEFT JOIN prospectos ps ON ps.id_prospecto = cl.id_prospecto AND cl.lugar_prospeccion = 6
            $whereRes AND l.tipo_venta IS NOT NULL AND l.tipo_venta IN (1,2,7) AND cl.status = 1 AND cl.fechaApartado >= '2020-03-01' AND cl.id_sede NOT IN (0) AND (cl.plan_comision IS NULL OR cl.plan_comision IN (0)) )");
    }

    public function getFlag(){
        return $this->db->query("SELECT cm.id_lote, sum(cm.comision_total) AS total, (sum(cm.comision_total) - pc.total_comision) resta, (CASE WHEN pc.bandera = 0 THEN 10 WHEN pc.bandera = 55 THEN 15 WHEN pc.bandera = 1 THEN 11 WHEN pc.bandera = 7 THEN 17 END) AS bandera
        FROM comisiones cm
        INNER JOIN pago_comision pc ON pc.id_lote = cm.id_lote 
        INNER JOIN lotes lo ON lo.idLote = cm.id_lote AND lo.registro_comision NOT IN (8)
        WHERE cm.estatus = 1 AND pc.bandera IN (0,1,7,55) AND (cm.descuento IS NULL OR cm.descuento = 0) --AND pc.id_lote = 33355
        GROUP BY cm.id_lote, pc.total_comision, pc.bandera
        HAVING (sum(cm.comision_total) - pc.total_comision) NOT BETWEEN -1 AND 1  
        ORDER BY cm.id_lote");
    }

    public function updateFlag($a, $b, $c){
        return $this->db->query("UPDATE pago_comision SET total_comision = $b, bandera = $c WHERE id_lote IN ($a)");
    }

    public function getFlagAbonado(){
        return $this->db->query("SELECT DISTINCT(cm.id_lote), SUM(abono_neodata) abonado, (sum(abono_neodata) - pc.abonado) resta, (CASE WHEN pc.bandera = 10 THEN 100 WHEN pc.bandera = 0 THEN 100 WHEN pc.bandera = 55 THEN 150 WHEN pc.bandera = 15 THEN 150 WHEN pc.bandera = 1 THEN 110 WHEN pc.bandera = 11 THEN 110 WHEN pc.bandera = 7 THEN 170 WHEN pc.bandera = 17 THEN 170 END) AS bandera
        FROM pago_comision_ind pci
        INNER JOIN comisiones cm ON cm.id_comision = pci.id_comision AND cm.estatus = 1
        INNER JOIN pago_comision pc ON pc.id_lote = cm.id_lote 
        WHERE cm.estatus = 1 AND (cm.descuento IS NULL OR cm.descuento = 0) AND pc.bandera NOT IN (100, 150, 110, 170)
        GROUP BY cm.id_lote, pc.abonado, pc.bandera
        HAVING (SUM(abono_neodata) - pc.abonado) NOT BETWEEN -1 AND 1");
    }

    public function updateFlagAbonado($a, $b, $c){
        return $this->db->query("UPDATE pago_comision SET abonado = $b, bandera = $c WHERE id_lote IN ($a)");
    }

    public function getFlagPendiente(){
        $this->updateFlagPendienteDistintos();
        return $this->db->query("SELECT pc.id_lote, (CASE WHEN pc.bandera = 100 THEN 0 WHEN pc.bandera = 150 THEN 55 WHEN pc.bandera = 110 THEN 1 WHEN pc.bandera = 170 THEN 7 ELSE pc.bandera END) AS bandera FROM pago_comision pc WHERE pc.bandera IN (100, 150, 110, 170)");
    }
    
    public function updateFlagPendiente($a, $b){
        $this->db->query("UPDATE pago_comision SET pendiente = total_comision - abonado, bandera = $b WHERE id_lote IN ($a)");
    }

    public function updateFlagPendienteDistintos(){
        $this->db->query("UPDATE pago_comision SET pendiente = total_comision - abonado WHERE total_comision NOT IN (0) AND bandera NOT IN (100, 150, 110, 170) ");
    }

}