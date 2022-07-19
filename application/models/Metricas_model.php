<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Metricas_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
    public function getSuperficieVendida($data = null){
        $year = date("Y");
        $query = $this->db->query("SELECT t.range AS [superficie], COUNT(*) as [cantidad], 
                FORMAT(SUM(CASE WHEN (t.totalNeto2 IS NULL OR t.totalNeto2 = 0.00) THEN t.total ELSE t.totalNeto2 END), 'C') [precio]
                FROM (
                      SELECT
                         CASE 
                            WHEN sup >= 0 AND sup <= 100 THEN '0-100'
                            WHEN sup >= 101 AND sup <= 110 THEN '101-110'
                            WHEN sup >= 111 AND sup <= 120 THEN '111-120'
                            WHEN sup >= 121 AND sup <= 130 THEN '121-130'
                            WHEN sup >= 131 AND sup <= 140 THEN '131-140'
                            WHEN sup >= 141 AND sup <= 150 THEN '141-150'
                            WHEN sup >= 151 AND sup <= 160 THEN '151-160'
                            WHEN sup >= 161 AND sup <= 170 THEN '161-170'
                            WHEN sup >= 171 AND sup <= 180 THEN '171-180'
                            WHEN sup >= 181 AND sup <= 190 THEN '181-190'
                            WHEN sup >= 191 AND sup <= 200 THEN '191-200'
                            WHEN sup >= 201 AND sup <= 210 THEN '201-210'
                            WHEN sup >= 211 AND sup <= 220 THEN '211-220'
                            WHEN sup >= 221 AND sup <= 230 THEN '221-230'
                            WHEN sup >= 231 AND sup <= 240 THEN '231-240'
                            WHEN sup >= 241 AND sup <= 250 THEN '241-250'
                            WHEN sup >= 251 AND sup <= 260 THEN '251-260'
                            WHEN sup >= 261 AND sup <= 270 THEN '261-270'
                            WHEN sup >= 271 AND sup <= 280 THEN '271-280'
                            WHEN sup >= 281 AND sup <= 290 THEN '281-290'
                            WHEN sup >= 291 AND sup <= 300 THEN '291-300'
                            ELSE '300 +' 
                        END AS range,
                        totalNeto2, total
                     FROM lotes lo
                     INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
                     WHERE lo.status = 1 AND idStatusLote IN (2, 3) AND isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 1 
                     AND YEAR(cl.fechaApartado)= $year AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2)) t 
                GROUP BY t.range
                ORDER BY cantidad DESC");
        return $query->result_array();
    }

    public function getDisponibilidadProyecto($data = null){
        $query = $this->db->query("SELECT re.nombreResidencial,  CAST(re.descripcion as varchar(max)) descripcion, COUNT(lo.idLote) totales, COUNT(lot.idLote) ocupados, (COUNT(lo.idLote) -  COUNT(lot.idLote)) restante  FROM lotes lo
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = con.idResidencial
        LEFT JOIN lotes lot ON lot.idLote = lo.idLote AND lot.idStatusLote != 1 AND lot.status = 1
        WHERE lo.status = 1
        GROUP BY nombreResidencial, CAST(re.descripcion as varchar(max))
        ORDER BY restante DESC");
        return $query->result_array();
    }

    public function getVentasM2($ídCondo){
        $year = date("Y");
        $query = $this->db->query("SELECT t.range AS [sup], COUNT(*) as [cantidad], 
        FORMAT(SUM(CASE WHEN (t.totalNeto2 IS NULL OR t.totalNeto2 = 0.00) THEN t.total ELSE t.totalNeto2 END), 'C') [precio]
        FROM (
              SELECT
                 CASE 
                    WHEN sup >= 0 AND sup <= 100 THEN '0-100'
                    WHEN sup >= 101 AND sup <= 110 THEN '101-110'
                    WHEN sup >= 111 AND sup <= 120 THEN '111-120'
                    WHEN sup >= 121 AND sup <= 130 THEN '121-130'
                    WHEN sup >= 131 AND sup <= 140 THEN '131-140'
                    WHEN sup >= 141 AND sup <= 150 THEN '141-150'
                    WHEN sup >= 151 AND sup <= 160 THEN '151-160'
                    WHEN sup >= 161 AND sup <= 170 THEN '161-170'
                    WHEN sup >= 171 AND sup <= 180 THEN '171-180'
                    WHEN sup >= 181 AND sup <= 190 THEN '181-190'
                    WHEN sup >= 191 AND sup <= 200 THEN '191-200'
                    WHEN sup >= 201 AND sup <= 210 THEN '201-210'
                    WHEN sup >= 211 AND sup <= 220 THEN '211-220'
                    WHEN sup >= 221 AND sup <= 230 THEN '221-230'
                    WHEN sup >= 231 AND sup <= 240 THEN '231-240'
                    WHEN sup >= 241 AND sup <= 250 THEN '241-250'
                    WHEN sup >= 251 AND sup <= 260 THEN '251-260'
                    WHEN sup >= 261 AND sup <= 270 THEN '261-270'
                    WHEN sup >= 271 AND sup <= 280 THEN '271-280'
                    WHEN sup >= 281 AND sup <= 290 THEN '281-290'
                    WHEN sup >= 291 AND sup <= 300 THEN '291-300'
                    ELSE '300 +' 
                END AS range,
                totalNeto2, total
             FROM lotes WHERE status = 1 AND idCondominio = $ídCondo AND idStatusLote IN (2, 3)) t
        GROUP BY t.range
        ORDER BY [sup]");
        return $query->result_array();
    }

    public function getLugarProspeccion($data = null){
        $year = date("Y");
        $query = $this->db->query("SELECT s.nombre, COUNT(pros.id_prospecto) prospectos, COUNT(cl.id_cliente) clientes FROM sedes s
        INNER JOIN prospectos pros ON pros.id_sede =s.id_sede
        LEFT JOIN (SELECT id_sede, id_cliente, id_prospecto FROM clientes WHERE status = 1) cl ON cl.id_prospecto = pros.id_prospecto
        WHERE pros.estatus = 1 AND YEAR(pros.fecha_creacion)= $year
        GROUP BY s.nombre
        ORDER BY prospectos DESC");
        return $query->result_array();
    }

    public function getMedioProspeccion($data = null){
        $year = date("Y");
        $query = $this->db->query("SELECT oxc.nombre,pros.lugar_prospeccion, COUNT(*) cantidad FROM prospectos pros
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pros.lugar_prospeccion AND oxc.id_catalogo = 9 AND oxc.estatus = 1
        WHERE pros.estatus = 1 AND YEAR(pros.fecha_creacion)= $year
        GROUP BY oxc.nombre,pros.lugar_prospeccion
        ORDER BY cantidad DESC");
        return $query->result_array();
    }

    public function getProyectos(){
        $query = $this->db->query("SELECT * FROM residenciales WHERE status = 1");
        return $query->result_array();
    }

    public function getCondominios($idProyecto){
        $query = $this->db->query("SELECT * FROM condominios WHERE idResidencial=$idProyecto AND status = 1");
        return $query->result_array();
    }

}
