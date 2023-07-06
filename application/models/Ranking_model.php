<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ranking_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getRankingApartados($beginDate, $endDate, $sede){
        return $this->db->query("SELECT ROW_NUMBER() OVER (Order by (select 1)) AS ranking,
        FORMAT(SUM(CASE 
            WHEN tmpApT.totalNeto2 IS NULL THEN tmpApT.total 
            WHEN tmpApT.totalNeto2 = 0 THEN tmpApT.total 
            ELSE tmpApT.totalNeto2 
        END),'C') sumaTotal, COUNT(*) totalAT, id_asesor, tmpApT.nombreUsuario, tmpApT.rol FROM (
            SELECT  oxc.nombre rol, u.id_rol, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreUsuario, lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl ,lo.totalNeto2) totalNeto2, isNULL(cl.total_cl ,lo.total) total FROM clientes cl
            INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote != 2 AND lo.idStatusContratacion < 11
            INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
            INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.id_rol AND oxc.id_catalogo = 1
            WHERE isNULL(noRecibo, '') != 'CANCELADO' 
            AND cl.status = 1 
            AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2)
            AND cl.id_sede = $sede
            AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000'
            GROUP BY oxc.nombre, u.id_rol, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl ,lo.totalNeto2), isNULL(cl.total_cl ,lo.total)
        ) tmpApT GROUP BY id_asesor, tmpApT.nombreUsuario, tmpApT.rol
        ORDER BY totalAT DESC");
    }

    public function getRankingContratados($beginDate, $endDate, $sede){
        return $this->db->query("SELECT ROW_NUMBER() OVER (Order by (select 1)) AS ranking,
        FORMAT(SUM(CASE 
            WHEN tmpConT.totalNeto2 IS NULL THEN tmpConT.total 
            WHEN tmpConT.totalNeto2 = 0 THEN tmpConT.total 
            ELSE tmpConT.totalNeto2 
        END),'C') sumaTotal, COUNT(*) totalConT, id_asesor, tmpConT.nombreUsuario, tmpConT.rol FROM (
            SELECT  oxc.nombre rol, u.id_rol, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreUsuario, lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl ,lo.totalNeto2) totalNeto2, isNULL(cl.total_cl ,lo.total) total FROM clientes cl
            INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote IN (2, 3)
            INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
            INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.id_rol AND oxc.id_catalogo = 1
            INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
            INNER JOIN historial_lotes hlo2 ON hlo2.idLote = hlo.idLote AND hlo2.idCliente = hlo.idCliente AND hlo2.modificado = hlo.modificado
            WHERE isNULL(noRecibo, '') != 'CANCELADO' 
            AND cl.status = 1 
            AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2)
            AND cl.id_sede = $sede
            AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000'
            AND hlo2.idStatusContratacion >= 11
            GROUP BY  oxc.nombre, u. id_rol, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl ,lo.totalNeto2), isNULL(cl.total_cl ,lo.total)
        )tmpConT GROUP BY id_asesor, tmpConT.nombreUsuario, tmpConT.rol
        ORDER BY totalConT DESC");
    }

    public function getRankingConEnganche($beginDate, $endDate, $sede){
        return  $this->db->query("SELECT ROW_NUMBER() OVER (Order by (select 1)) AS ranking,
        FORMAT(SUM(CASE 
            WHEN isNULL(cl.totalNeto2_cl ,lo.totalNeto2) IS NULL THEN isNULL(cl.total_cl ,lo.total)
            WHEN isNULL(cl.totalNeto2_cl ,lo.totalNeto2) = 0 THEN isNULL(cl.total_cl ,lo.total)
            ELSE isNULL(cl.totalNeto2_cl ,lo.totalNeto2)
        END),'C') sumaTotal,oxc.nombre rol, COUNT (cl.id_asesor) cuantos, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor , cl.id_asesor FROM clientes cl 
        INNER JOIN lotes lo ON lo.idLote = cl.idLote AND (isNULL(cl.totalNeto_cl, lo.totalNeto) IS NOT NULL AND isNULL(cl.totalNeto_cl, lo.totalNeto) > 0.00)
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor AND u.estatus = 1
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.id_rol AND oxc.id_catalogo = 1
        WHERE isNULL(noRecibo, '') != 'CANCELADO' 
        AND cl.status = 1 
        AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2)
        AND cl.id_sede = $sede
        AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000'
        GROUP BY oxc.nombre, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), cl.id_asesor
        ORDER BY cuantos DESC");
    }

    public function getRankingSinEnganche($beginDate, $endDate, $sede){
        return  $this->db->query("SELECT  ROW_NUMBER() OVER (Order by (select 1)) AS ranking,
        FORMAT(SUM(CASE 
            WHEN isNULL(cl.totalNeto2_cl ,lo.totalNeto2) IS NULL THEN isNULL(cl.total_cl ,lo.total)
            WHEN isNULL(cl.totalNeto2_cl ,lo.totalNeto2) = 0 THEN isNULL(cl.total_cl ,lo.total)
            ELSE isNULL(cl.totalNeto2_cl ,lo.totalNeto2)
        END),'C') sumaTotal, oxc.nombre rol, COUNT (cl.id_asesor) cuantos, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor , cl.id_asesor FROM clientes cl 
        INNER JOIN lotes lo ON lo.idLote = cl.idLote AND (isNULL(cl.totalNeto_cl, lo.totalNeto) IS NULL OR isNULL(isNULL(cl.totalNeto_cl, lo.totalNeto), 0.00)  = 0.00)
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor AND u.estatus = 1
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.id_rol AND oxc.id_catalogo = 1
        WHERE isNULL(noRecibo, '') != 'CANCELADO' 
        AND cl.status = 1 
        AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2)
        AND cl.id_sede = $sede
        AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000'
        GROUP BY oxc.nombre, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), cl.id_asesor
        ORDER BY cuantos DESC");
    }

    public function getSedes(){
        return $this->db->query("SELECT * FROM sedes WHERE estatus != 0");
    }

    public function getGeneralLotesInformation($type, $asesor, $sede, $beginDate, $endDate) {
        /*
        $type = 1 APARTADO 
        $type = 2 CONTRATADO 
        $type = 3 CON ENGANCHE
        $type = 4 SIN ENGANCHE
        */
        if ($type == 1) // MJ: APARTADOS
            $statusLote = "!= 2 AND lo.idStatusContratacion < 11";
        else if ($type == 2) // MJ: CONTRATADOS
            $statusLote = "IN (2, 3) AND lo.idStatusContratacion >= 11";
        else // MJ: // CON ENGANCHE / SIN ENGANCHE
            $statusLote = "IN (2, 3)";

        if ($type == 3) // MJ: CON ENGANCHE
            $filtroTotal = "AND (isNULL(cl.totalNeto_cl, lo.totalNeto) IS NOT NULL AND isNULL(cl.totalNeto_cl, lo.totalNeto) > 0.00)";
        else if ($type == 4) // MJ: SIN ENGANCHE
            $filtroTotal = "AND (isNULL(cl.totalNeto_cl, lo.totalNeto) IS NULL AND isNULL(isNULL(cl.totalNeto_cl, lo.totalNeto), 0.00) = 0.00)";
        else // MJ: APARTADOS / CONTRATADOS
            $filtroTotal = "";
            
        $query = $this->db->query("SELECT  UPPER(CAST(re.descripcion AS VARCHAR (120))) AS nombreResidencial, UPPER(co.nombre) nombreCondominio, UPPER(lo.nombreLote) nombreLote, 
        UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente,
        UPPER(CONCAT(ua.nombre, ' ', ua.apellido_paterno, ' ', ua.apellido_materno)) nombreAsesor,
        CONVERT(VARCHAR,cl.fechaApartado,20) AS fechaApartado, UPPER(sc.nombreStatus) AS nombreStatus, UPPER(st.nombre) AS estatusLote, 
        FORMAT(CASE WHEN (lo.totalNeto2 IS NULL OR lo.totalNeto2 = 0.00) THEN lo.total ELSE lo.totalNeto2 END, 'C') total
        FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idCliente = cl.id_cliente AND lo.idStatusLote $statusLote $filtroTotal
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN statusContratacion sc ON sc.idStatusContratacion = lo.idStatusContratacion
        INNER JOIN statusLote st ON st.idStatusLote = lo.idStatusLote
        LEFT JOIN usuarios ua ON ua.id_usuario = cl.id_asesor
        WHERE isNULL(noRecibo, '') != 'CANCELADO' 
        AND cl.status = 1 
        AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2)
        AND cl.id_sede = $sede
        AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000'
        AND cl.id_asesor = $asesor
        ORDER BY cl.fechaApartado");
        return $query;       
    }
}
