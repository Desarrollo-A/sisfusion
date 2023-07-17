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
        $query = $this->db->query("SELECT re.nombreResidencial,  UPPER(CAST(re.descripcion as varchar(max))) descripcion, COUNT(lo.idLote) totales, COUNT(lot.idLote) ocupados, (COUNT(lo.idLote) -  COUNT(lot.idLote)) restante  FROM lotes lo
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = con.idResidencial
        LEFT JOIN lotes lot ON lot.idLote = lo.idLote AND lot.idStatusLote != 1 AND lot.status = 1
        WHERE lo.status = 1
        GROUP BY nombreResidencial, CAST(re.descripcion as varchar(max))
        ORDER BY restante DESC");
        return $query->result_array();
    }

    public function getVentasM2($ídCondo){
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
        $query = $this->db->query("SELECT UPPER(t1.nombre) AS nombre, t1.prospectos, t2.clientes FROM (
        (SELECT se.nombre, COUNT(*) prospectos FROM prospectos pr
        INNER JOIN sedes se ON se.id_sede = pr.id_sede
        WHERE YEAR(pr.fecha_creacion) = 2022
        GROUP BY se.nombre) t1
        LEFT JOIN
        (SELECT se.nombre, COUNT(DISTINCT(cl.id_prospecto)) clientes FROM clientes cl
        INNER JOIN prospectos pr ON pr.id_prospecto = cl.id_prospecto AND YEAR(pr.fecha_creacion) = 2022
        INNER JOIN sedes se ON se.id_sede = pr.id_sede
        WHERE cl.status = 1
        GROUP BY se.nombre) t2 ON (t1.nombre = t2.nombre)
        ) ORDER BY t1.prospectos DESC");
        return $query->result_array();
    }

    public function getMedioProspeccion($data = null){
        $year = date("Y");
        $query = $this->db->query("SELECT UPPER(oxc.nombre) AS nombre,pros.lugar_prospeccion, COUNT(*) cantidad FROM prospectos pros
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pros.lugar_prospeccion AND oxc.id_catalogo = 9 AND oxc.estatus = 1
        WHERE pros.estatus = 1 AND YEAR(pros.fecha_creacion)= $year
        GROUP BY oxc.nombre,pros.lugar_prospeccion
        ORDER BY cantidad DESC");
        return $query->result_array();
    }

    public function getProyectos($sede){
        if($sede == ''){
            $filtro = '';
        }else{
            $filtro = "AND sede_residencial=$sede";
        }
        $query = $this->db->query("SELECT UPPER(CAST(descripcion as varchar(MAX))) AS descripcion, sede_residencial, idResidencial FROM residenciales WHERE status = 1 $filtro");
        return $query->result_array();
    }

    public function getCondominios($idProyecto){
        $query = $this->db->query("SELECT * FROM condominios WHERE idResidencial=$idProyecto AND status = 1");
        return $query->result_array();
    }

    public function getPromedio($sede, $proyecto, $beginDate, $endDate){
        if($sede == ''){
            $filtro = "";
        }else if($proyecto == ''){
            $filtro = "AND res.sede_residencial = $sede";
        }else{
            $filtro = "AND res.sede_residencial = $sede AND res.idResidencial = $proyecto";
        }

        $query = $this->db->query("WITH cte AS(
            SELECT CAST('$beginDate 00:00:00' AS DATETIME) DateValue
            UNION ALL
            SELECT  DateValue + 1
            FROM    cte   
            WHERE   DateValue + 1 <= '$endDate 23:59:59')
            SELECT 
                (CASE 
                    WHEN MONTH(DateValue) = '1' THEN 'Enero'
                    WHEN MONTH(DateValue) = '2' THEN 'Febrero'
                    WHEN MONTH(DateValue) = '3' THEN 'Marzo'
                    WHEN MONTH(DateValue) = '4' THEN 'Abril'
                    WHEN MONTH(DateValue) = '5' THEN 'Mayo'
                    WHEN MONTH(DateValue) = '6' THEN 'Junio'
                    WHEN MONTH(DateValue) = '7' THEN 'Julio'
                    WHEN MONTH(DateValue) = '8' THEN 'Agosto'
                    WHEN MONTH(DateValue) = '9' THEN 'Septiembre'
                    WHEN MONTH(DateValue) = '10' THEN 'Octubre'
                    WHEN MONTH(DateValue) = '11' THEN 'Noviembre'
                    WHEN MONTH(DateValue) = '12' THEN 'Diciembre'
                END) MONTH, YEAR(DateValue) año, isNULL(qu.superficieSUMA, 0) superficieSUMA, FORMAT(isNULL(qu.precioSUMA,0),'C') precioSUMA, CAST(isNULL(qu.promedio,0) AS decimal(16,2)) promedio FROM cte 
            LEFT JOIN (
            SELECT SUM(lo.sup) superficieSUMA,
            SUM(CASE WHEN (lo.totalNeto2 IS NULL OR lo.totalNeto2 = 0.00) THEN lo.total ELSE lo.totalNeto2 END) precioSUMA, 
            SUM(CASE WHEN (lo.totalNeto2 IS NULL OR lo.totalNeto2 = 0.00) THEN lo.total ELSE lo.totalNeto2 END) /SUM(lo.sup) promedio, MONTH(cl.fechaApartado) mes, YEAR(cl.fechaApartado) año
            FROM lotes lo
            INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
            INNER JOIN condominios cond ON cond.idCondominio = lo.idCondominio
            INNER JOIN residenciales res ON res.idResidencial = cond.idResidencial
            WHERE cl.fechaApartado BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59' AND cond.tipo_lote = 0 $filtro AND cl.status = 1
            AND lo.totalNeto2>0.00
            GROUP BY MONTH(cl.fechaApartado), YEAR(cl.fechaApartado)) qu ON qu.mes = month(cte.DateValue) AND qu.año = year(cte.DateValue)
            GROUP BY YEAR(DateValue), MONTH(DateValue), qu.superficieSUMA, qu.precioSUMA, qu.promedio
            ORDER BY YEAR(DateValue), MONTH(DateValue)
            OPTION (MAXRECURSION 0)");
        return $query->result_array();
    }

    public function getSedes(){
        $query = $this->db->query("SELECT id_sede, UPPER(nombre) as nombre FROM sedes
        WHERE estatus = 1");
        return $query->result_array();
    }

    public function getLotesInformation($sede_residencial, $idResidencial, $beginDate, $endDate){
        if($sede_residencial == ''){
            $filtro = "";
        }else if($idResidencial == ''){
            $filtro = "AND res.sede_residencial = $sede_residencial";
        }else{
            $filtro = "AND res.sede_residencial = $sede_residencial AND res.idResidencial = $idResidencial";
        }
        $query = $this->db->query("SELECT lo.nombreLote, cond.nombre nombreCondominio, UPPER(CAST(res.descripcion AS VARCHAR(max))) AS nombreResidencial, 
        UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente,
        UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) nombreAsesor,
        UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) nombreCoordinador,
        UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) nombreGerente,
        UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) nombreSubdirector,
        UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) nombreRegional,
        CONVERT(VARCHAR,cl.fechaApartado,20) AS fechaApartado, lo.sup,  
        FORMAT(isNULL(CASE 
        WHEN isNULL(cl.totalNeto2_cl ,lo.totalNeto2) IS NULL THEN isNULL(cl.total_cl ,lo.total) 
        WHEN isNULL(cl.totalNeto2_cl ,lo.totalNeto2) = 0 THEN isNULL(cl.total_cl ,lo.total) 
        ELSE isNULL(cl.totalNeto2_cl ,lo.totalNeto2) 
        END,0), 'C') totalNeto2 FROM lotes lo 
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
        INNER JOIN condominios cond ON cond.idCondominio = lo.idCondominio
        INNER JOIN residenciales res ON res.idResidencial = cond.idResidencial
        INNER JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
        LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
        LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
        LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
        LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
        WHERE cl.fechaApartado BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59' 
        AND cond.tipo_lote = 0 $filtro ");
        return $query->result_array();
    }
}
