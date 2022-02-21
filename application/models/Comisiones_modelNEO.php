<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comisiones_modelNEO extends CI_Model {

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
        $validate = $this->db->query("SELECT l.referencia, $filter
            FROM lotes l INNER JOIN condominios c ON c.idCondominio = l.idCondominio INNER JOIN residenciales r ON r.idResidencial = c.idResidencial INNER JOIN clientes cl ON cl.id_cliente = l.idCliente WHERE l.status = 1 AND cl.status = 1 AND l.idLote = $lote ");

        if($validate->num_rows()>0){
            $ref = $validate->row()->referencia;
            $des = $validate->row()->idResidencial;
            return $this->gphsis->query("EXEC [GPHSIS].[dbo].[004VerificaconNeoB] @referencia = $ref, @iddesarrollo = $des");
        }
        else{
            return false;
        }
    }


     public function getGeneralStatusFromNeodata($referencia, $desarrollo){
        return $this->gphsis->query("EXEC [GPHSIS].[dbo].[004VerificaconNeoB] @referencia = $referencia, @iddesarrollo = $desarrollo")->row();
    }




    public function getLotesByAdviser($proyecto, $condominio)
    {
        switch ($this->session->userdata('id_rol')) {
            case '1':// DIRECTOR VENTAS
                return $this->db->query("SELECT l.referencia, r.idResidencial, l.idLote
                                        FROM lotes l
                                        INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                                        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                                        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                                        INNER JOIN usuarios u ON u.id_usuario = cl.id_gerente
                                        WHERE l.status = 1 AND cl.status = 1 
                                        AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones)
                                        AND cl.fechaApartado >= '2020-03-01' AND c.idCondominio = $condominio AND idStatusContratacion between 9 and 15 and tipo_venta in (0,1,2)")->result_array();
                break;
            case '2':// SUBDIRECTOR VENTAS
                return $this->db->query("SELECT l.referencia, r.idResidencial, l.idLote
                                        FROM lotes l
                                        INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                                        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                                        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                                        INNER JOIN usuarios u ON u.id_usuario = cl.id_gerente
                                        WHERE u.id_lider = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 
                                        AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones)
                                        AND cl.fechaApartado >= '2020-03-01' AND c.idCondominio = $condominio AND idStatusContratacion between 9 and 15 and tipo_venta in (0,1,2)")->result_array();
                break;
            case '3':// GERENTE VENTAS
                return $this->db->query("SELECT l.referencia, r.idResidencial, l.idLote
                                        FROM lotes l
                                        INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                                        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                                        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                                        WHERE cl.id_gerente = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1 
                                        AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones)
                                        AND cl.fechaApartado >= '2020-03-01' AND c.idCondominio = $condominio AND idStatusContratacion between 9 and 15 and tipo_venta in (0,1,2)")->result_array();
            case '9': // COORDINADOR VENTAS
                if ($condominio == 0) { // SE FILTRA POR PROYECTO
                    return $this->db->query("SELECT l.referencia, r.idResidencial, l.idLote
                                        FROM lotes l
                                        INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                                        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                                        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                                        WHERE (cl.id_asesor = " . $this->session->userdata('id_usuario') . " 
                                        OR cl.id_coordinador = " . $this->session->userdata('id_usuario') . ")
                                        AND l.status = 1 AND cl.status = 1 
                                        AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones)
                                        AND cl.fechaApartado >= '2020-03-01' AND r.idResidencial = $proyecto AND idStatusContratacion between 9 and 15 and tipo_venta in (0,1,2)")->result_array();
                } else { // SE FILTRA POR CONDOMINIO
                    return $this->db->query("SELECT l.referencia, r.idResidencial, l.idLote
                                        FROM lotes l
                                        INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                                        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                                        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                                        WHERE (cl.id_asesor = " . $this->session->userdata('id_usuario') . " 
                                        OR cl.id_coordinador = " . $this->session->userdata('id_usuario') . ")
                                        AND l.status = 1 AND cl.status = 1 
                                        AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones)
                                        AND cl.fechaApartado >= '2020-03-01' AND c.idCondominio = $condominio AND idStatusContratacion between 9 and 15 and tipo_venta in (0,1,2)")->result_array();
                }
                break;
            case '7':// ASESOR VENTAS
                if ($condominio == 0) { // SE FILTRA POR PROYECTO
                    return $this->db->query("SELECT l.referencia, r.idResidencial, l.idLote
                                        FROM lotes l
                                        INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                                        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                                        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                                        WHERE cl.id_asesor = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1
                                         AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones)
                                         AND cl.fechaApartado >= '2020-03-01' AND r.idResidencial = $proyecto AND idStatusContratacion between 9 and 15 and tipo_venta in (0,1,2)")->result_array();
                } else { // SE FILTRA POR CONDOMINIO
                    return $this->db->query("SELECT l.referencia, r.idResidencial, l.idLote
                                        FROM lotes l
                                        INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                                        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                                        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                                        WHERE cl.id_asesor = " . $this->session->userdata('id_usuario') . " AND l.status = 1 AND cl.status = 1
                                         AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones)
                                         AND cl.fechaApartado >= '2020-03-01' AND c.idCondominio = $condominio AND idStatusContratacion between 9 and 15 and tipo_venta in (0,1,2)")->result_array();
                }
                break;
            default:// CONTRALORÍA
                return $this->db->query("SELECT l.referencia, r.idResidencial, l.idLote
                                        FROM lotes l
                                        INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                                        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                                        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                                        WHERE l.status = 1 AND cl.status = 1 AND l.registro_comision = 0 
                                        AND l.idLote NOT IN (SELECT id_lote FROM comisiones)
                                        AND cl.fechaApartado >= '2020-03-01' AND c.idCondominio = $condominio AND idStatusContratacion between 9 and 15 and tipo_venta in (0,1,2)")->result_array();
        }
    }



    public function getLoteInformation($idLote){
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
                                WHERE l.status = 1 AND cl.status = 1 AND l.idLote = $idLote ORDER BY 
                                r.nombreResidencial, c.nombre, l.nombreLote, nombreCliente")->row();
    }



    public function getLotesAAA()
           {
               return $this->db->query("SELECT l.referencia, r.idResidencial, l.idLote
                                               FROM lotes l
                                               INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                                               INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                                               INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                                               INNER JOIN usuarios u ON u.id_usuario = cl.id_gerente
                                               WHERE l.status = 1 AND cl.status = 1 
                                               AND l.registro_comision = 0 AND l.idLote NOT IN (SELECT id_lote FROM comisiones)
                                               AND cl.fechaApartado >= '2020-03-01' AND l.referencia IS NOT NULL
                                               AND l.idStatusContratacion between 9 and 15 and l.tipo_venta in (0,1,2)
                                               AND r.idResidencial in (17)
                                                
                                               ")->result_array();

                    
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
                                WHERE l.status = 1 AND cl.status = 1 AND l.idLote = $idLote ORDER BY 
                                r.nombreResidencial, c.nombre, l.nombreLote, nombreCliente")->row();
    }



    public function UpdateBanderaPagoComision($idLote){
    return $this->db->query("UPDATE pago_comision SET bandera = 0 WHERE id_lote = $idLote");
    }

 public function UpdateBanderaPagoComisionNO($idLote){
    return $this->db->query("UPDATE pago_comision SET bandera = 55 WHERE id_lote = $idLote");
    }


   
}