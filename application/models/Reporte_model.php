<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reporte_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getDataChart($general, $tipoChart, $rol, $condicion_x_rol, $coordinador, $coordinadorVC, $coordinadorVA, $coordinadorCC, $coordinadorCA, $beginDate, $endDate){

        $ventasContratadas = ''; $ventasApartadas = ''; $canceladasContratadas = ''; $canceladasApartadas = '';
        $endDateDos =  date("Y-m-01", strtotime($endDate));
        //Crear por defecto las columnas en default para evaluar esos puntos en la gráfica. 
        $defaultColumns = "WITH cte AS(
            SELECT CAST('$beginDate' AS DATETIME) DateValue
            UNION ALL
            SELECT  DateValue + 1
            FROM    cte   
            WHERE   DateValue + 1 < '$endDateDos'
        )";

        $ventasContratadas = "SELECT ISNULL(total, 0) total, ISNULL(cantidad, 0) cantidad, MONTH(DateValue) mes, YEAR(DateValue) año, 'vc' tipo, '$rol' rol FROM cte
        LEFT JOIN (SELECT FORMAT(ISNULL(SUM(CASE WHEN totalNeto2 IS NULL THEN total WHEN totalNeto2 = 0 THEN total ELSE totalNeto2 END), 0), 'C') total,
        COUNT(*) cantidad, MONTH(cl.fechaApartado) mes, YEAR(cl.fechaApartado) año
        FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote = 2
        INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 15 AND idMovimiento = 45
        GROUP BY idLote, idCliente) hl ON hl.idLote = lo.idLote AND hl.idCliente = cl.id_cliente
        WHERE ISNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 1 AND cl.fechaApartado BETWEEN '$beginDate' AND '$endDate'
        $condicion_x_rol
        GROUP BY MONTH(cl.fechaApartado), YEAR(cl.fechaApartado)) qu ON qu.mes = month(cte.DateValue) AND qu.año = year(cte.DateValue)
        GROUP BY Month(DateValue), YEAR(DateValue), cantidad, total";

        $ventasApartadas = "SELECT ISNULL(total, 0) total, ISNULL(cantidad, 0) cantidad, MONTH(DateValue) mes, YEAR(DateValue) año, 'va' tipo, '$rol' rol FROM cte
        LEFT JOIN (SELECT FORMAT(ISNULL(SUM(CASE WHEN totalNeto2 IS NULL THEN total WHEN totalNeto2 = 0 THEN total ELSE totalNeto2 END), 0), 'C') total, 
        COUNT(*) cantidad, MONTH(cl.fechaApartado) mes, YEAR(cl.fechaApartado) año
        FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote != 2
        WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 1 AND cl.fechaApartado BETWEEN '$beginDate' AND '$endDate'
        $condicion_x_rol
        GROUP BY MONTH(cl.fechaApartado), YEAR(cl.fechaApartado)) qu ON qu.mes = month(cte.DateValue) AND qu.año = year(cte.DateValue)
        GROUP BY Month(DateValue), YEAR(DateValue), cantidad, total";

        $canceladasContratadas = "SELECT ISNULL(total, 0) total, ISNULL(cantidad ,0) cantidad, MONTH(DateValue) mes, YEAR(DateValue) año, 'cc' tipo, '$rol' rol FROM cte
        LEFT JOIN (SELECT FORMAT(ISNULL(SUM(CASE WHEN totalNeto2 IS NULL THEN total WHEN totalNeto2 = 0 THEN total ELSE totalNeto2 END), 0), 'C') total, 
        COUNT(*) cantidad, MONTH(cl.fechaApartado) mes, YEAR(cl.fechaApartado) año
        FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote
        LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
        INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 15 AND idMovimiento = 45
        GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
        WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 0  AND cl.fechaApartado BETWEEN '$beginDate' AND '$endDate' 
        $condicion_x_rol
        GROUP BY MONTH(cl.fechaApartado), YEAR(cl.fechaApartado)) qu ON qu.mes = month(cte.DateValue) AND qu.año = year(cte.DateValue)
        GROUP BY Month(DateValue), YEAR(DateValue), cantidad, total";

        $canceladasApartadas = "SELECT ISNULL(total, 0) total, ISNULL(cantidad ,0) cantidad, MONTH(DateValue) mes, YEAR(DateValue) año, 'ca' tipo, '$rol' rol FROM cte
        LEFT JOIN (SELECT FORMAT(ISNULL(SUM(CASE WHEN totalNeto2 IS NULL THEN total WHEN totalNeto2 = 0 THEN total ELSE totalNeto2 END), 0), 'C') total, 
        COUNT(*) cantidad, MONTH(cl.fechaApartado) mes, YEAR(cl.fechaApartado) año
        FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote
        LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
        INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 15 AND idMovimiento = 45
        GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
        WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 0  AND cl.fechaApartado BETWEEN '$beginDate' AND '$endDate' 
        $condicion_x_rol
        GROUP BY MONTH(cl.fechaApartado), YEAR(cl.fechaApartado)) qu ON qu.mes = month(cte.DateValue) AND qu.año = year(cte.DateValue)
        GROUP BY Month(DateValue), YEAR(DateValue), cantidad, total";

        if($coordinador){
            $ventasContratadas = $ventasContratadas . " UNION ALL " . $coordinadorVC;

            $ventasApartadas = $ventasApartadas . " UNION ALL " . $coordinadorVA;

            $canceladasContratadas = $canceladasContratadas . " UNION ALL " . $coordinadorCC;

            $canceladasApartadas = $canceladasApartadas . " UNION ALL " . $coordinadorCA;
        }

        //General 1. Cuado la consulta va a ser hecho por primera vez por los minicharts
        if($general == '1' || $general){
            $data = $this->db->query("$defaultColumns
            $ventasContratadas
            UNION ALL
            $ventasApartadas
            UNION ALL
            $canceladasContratadas
            UNION ALL
            $canceladasApartadas
            ORDER BY tipo DESC, rol, año, mes
            OPTION (MAXRECURSION 0)");
        }
        //Si general 0 traemos un tipo vc, va, cc o ca para evaluar el chart especifico al que se le hizo clic
        else if ($tipoChart == 'vc'){
            $data = $this->db->query("$defaultColumns
            $ventasContratadas
            ORDER BY tipo DESC, rol, año, mes
            OPTION (MAXRECURSION 0)");
        }
        else if ($tipoChart == 'va'){
            $data = $this->db->query("$defaultColumns
            $ventasApartadas
            ORDER BY tipo DESC, rol, año, mes
            OPTION (MAXRECURSION 0)");
        }
        else if ($tipoChart == 'cc'){
            $data = $this->db->query("$defaultColumns
            $canceladasContratadas
            ORDER BY tipo DESC, rol, año, mes
            OPTION (MAXRECURSION 0)");
        }
        else if ($tipoChart == 'ca'){
            $data = $this->db->query("$defaultColumns
            $canceladasContratadas
            ORDER BY tipo DESC, rol, año, mes
            OPTION (MAXRECURSION 0)");
        }

        return $data->result_array();    
    }

    public function getGeneralInformation($beginDate, $endDate, $id_rol, $id_usuario, $render) {
        // $id_rol = $this->session->userdata('id_rol');
        // $id_usuario = $this->session->userdata('id_usuario'); // PARA ASESOR, COORDINADOR, GERENTE, SUBDIRECTOR, REGIONAL Y DIRECCIÓN COMERCIAL
        $id_lider = $this->session->userdata('id_lider'); // PARA ASISTENTES

        $filtro=" AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000'";
        if ($id_rol == 7) // MJ: Asesor
           { 
            if($render == 1){
                $filtro .= " AND cl.id_asesor = $id_usuario";
            }else{
                $filtro .= " AND cl.id_coordinador = $id_usuario";
            }
            $comodin = "id_asesor";}
        else if ($id_rol == 9) // MJ: Coordinador
           { 
            if($render == 1){
                $filtro .= " AND (cl.id_coordinador = $id_usuario OR cl.id_asesor = $id_usuario)";
                $comodin = "id_asesor";
            }else{
                $filtro .= " AND cl.id_gerente = $id_usuario";
                $comodin = "id_coordinador";
            }
        }
        else if ($id_rol == 3) // MJ: Gerente
            {
            if($render == 1){
                $filtro .= " AND cl.id_gerente = $id_usuario";
                $comodin = "id_coordinador";

            }else{
                $filtro .= " AND cl.id_subdirector = $id_usuario";
                $comodin = "id_gerente";

            }
        }
        else if ($id_rol == 6) // MJ: Asistente de gerencia
           {
            if($render == 1){
                $filtro .= " AND cl.id_gerente = $id_usuario";
                $comodin = "id_coordinador";

            }else{
                $filtro .= " AND cl.id_subdirector = $id_usuario";
                $comodin = "id_gerente";

            }
        }
        else if ($id_rol == 2) // MJ: Subdirector
           {
            if($render == 1){
                $filtro .= " AND cl.id_subdirector = $id_usuario";
                $comodin = "id_gerente";

            }else{
                $filtro .= " AND cl.id_regional = $id_usuario";
                $comodin = "id_subdirector";
            }
        }
        else if ($id_rol == 5) // MJ: Asistente subdirección
            {
                if($render == 1){
                    $filtro .= " AND cl.id_subdirector = $id_usuario";
                    $comodin = "id_gerente";
    
                }else{
                    $filtro .= " AND cl.id_regional = $id_usuario";
                    $comodin = "id_subdirector";
                }
            }
        else if ($id_rol == 59) {// MJ: Director regional
            $id_sede = "'" . implode("', '", explode(", ", $this->session->userdata('id_sede'))) . "'"; // MJ: ID sede separado por , como string
            if($render == 1){
                $filtro .= " AND cl.id_regional = $id_usuario OR cl.id_subdirector = $id_usuario";
                $comodin = "id_subdirector";//pendiente

            }else{
                $filtro .= "";
            }
        }
        else if ($id_rol == 59) // MJ: Asistente de dirección regional
            {
                $id_sede = "'" . implode("', '", explode(", ", $this->session->userdata('id_sede'))) . "'"; // MJ: ID sede separado por , como string
                if($render == 1){
                    $filtro .= " AND cl.id_sede IN ($id_sede)";
                }else{
                    $filtro .= "";
                }
                $comodin = "id_subdirector";//pendiente
            }
        else if ($id_rol == 1 || $id_rol == 4) // MJ: Director comercial
           { 
            if($render == 1){

            }else{
                
            }
            $filtro .= "";
            $comodin = "";
            }

        $query = $this->db->query("SELECT 
            FORMAT(ISNULL(a.sumaTotal, 0), 'C') sumaTotal, ISNULL(a.totalVentas, 0) totalVentas, --TOTAL VENDIDO
            FORMAT(ISNULL(b.sumaCT, 0), 'C') sumaCT, ISNULL(b.totalCT, 0) totalCT,  --TOTAL CANCELADO
            FORMAT(ISNULL(c.sumaConT, 0), 'C') sumaConT, ISNULL(c.totalConT, 0) totalConT, --VENDIDO CONTRATADO
            FORMAT(ISNULL(d.sumaAT, 0), 'C') sumaAT, ISNULL(d.totalAT, 0) totalAT, --VENDIDO APARTADO
            FORMAT(ISNULL(e.sumaCanC, 0), 'C') sumaCanC, ISNULL(e.totalCanC, 0) totalCanC, --CANCELADOS CONTRATADOS
            FORMAT(ISNULL(b.sumaCT, 0) - ISNULL(e.sumaCanC, 0), 'C') sumaCanA, 
            ISNULL(b.totalCT, 0) - ISNULL(e.totalCanC, 0) totalCanA,
            ----PORCENTAJES
            ISNULL(CAST((a.totalVentas * 100) / NULLIF(a.totalVentas,0) AS decimal(16,2)), 0) porcentajeTotal, 
            ISNULL(CAST((b.totalCT * 100) / NULLIF(a.totalVentas,0) AS decimal(16,2)), 0) porcentajeTotalC, 
            ISNULL(CAST((c.totalConT * 100) / NULLIF(a.totalVentas,0) AS decimal(16,2)), 0) porcentajeTotalCont, 
            ISNULL(CAST((d.totalAT * 100) / NULLIF(a.totalVentas,0) AS decimal(16,2)), 0) porcentajeTotalAp, 
            ISNULL(CAST((e.totalCanC * 100) / NULLIF(c.totalConT,0) AS decimal(16,2)), 0) porcentajeTotalCanC, 
            ISNULL(CAST(((ISNULL(b.totalCT, 0) - ISNULL(e.totalCanC, 0)) * 100) / NULLIF(d.totalAT,0) AS decimal(16,2)), 0) porcentajeTotalCanA,
            a.userID,
            a.nombreUsuario,
            a.id_rol
            FROM (
            --SUMA TOTAL
            SELECT SUM(
                CASE 
                    WHEN tmpTotal.totalNeto2 IS NULL THEN tmpTotal.total 
                    WHEN tmpTotal.totalNeto2 = 0 THEN tmpTotal.total 
                    ELSE tmpTotal.totalNeto2 
                END) sumaTotal, 
                COUNT(*)
            totalVentas, '1' opt, $comodin userID, tmpTotal.nombreUsuario, tmpTotal.id_rol FROM (
                    SELECT  u.id_rol, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreUsuario,lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total FROM clientes cl
                    INNER JOIN lotes lo ON lo.idLote = cl.idLote
                    INNER JOIN usuarios u ON u.id_usuario = cl.$comodin
                    WHERE isNULL(noRecibo, '') != 'CANCELADO' $filtro
                    GROUP BY  u.id_rol, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno),lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total
                ) tmpTotal GROUP BY $comodin, tmpTotal.nombreUsuario, tmpTotal.id_rol) a
            --SUMA CANCELADOS TOTALES
            LEFT JOIN(
            SELECT SUM(
                CASE 
                    WHEN tmpCanT.totalNeto2 IS NULL THEN tmpCanT.total 
                    WHEN tmpCanT.totalNeto2 = 0 THEN tmpCanT.total 
                    ELSE tmpCanT.totalNeto2 
                END) sumaCT,
                COUNT(*)
            totalCT, '1' opt, $comodin userID, tmpCanT.nombreUsuario, tmpCanT.id_rol FROM (
                    SELECT u.id_rol,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreUsuario, lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total FROM clientes cl
                    INNER JOIN lotes lo ON lo.idLote = cl.idLote
                    INNER JOIN usuarios u ON u.id_usuario = cl.$comodin
                    LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.idLote = lo.idLote AND hl.id_cliente = cl.id_cliente
                    WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 0 $filtro
                    GROUP BY u.id_rol, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total
                ) tmpCanT GROUP BY $comodin, tmpCanT.nombreUsuario, tmpCanT.id_rol) b ON b.userID = a.userID
            --SUMA CONTRATOS TOTALES
            LEFT JOIN(
            SELECT SUM(
                CASE 
                    WHEN tmpConT.totalNeto2 IS NULL THEN tmpConT.total 
                    WHEN tmpConT.totalNeto2 = 0 THEN tmpConT.total 
                    ELSE tmpConT.totalNeto2 
                END) sumaConT,
                COUNT(*)
            totalConT, '1' opt, $comodin userID, tmpConT.nombreUsuario, tmpConT.id_rol FROM (
                    SELECT  u.id_rol, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreUsuario, lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total FROM clientes cl
                    INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote = 2
                    INNER JOIN usuarios u ON u.id_usuario = cl.$comodin
                    INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 15 AND idMovimiento = 45
                    GROUP BY idLote, idCliente) hl ON hl.idLote = lo.idLote AND hl.idCliente = cl.id_cliente
                    WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 1 $filtro
                    GROUP BY u. id_rol, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total
                ) tmpConT GROUP BY $comodin, tmpConT.nombreUsuario, tmpConT.id_rol) c ON c.userID = b.userID
            --Suma apartados totales
            LEFT JOIN(
            SELECT SUM(
                CASE 
                    WHEN tmpApT.totalNeto2 IS NULL THEN tmpApT.total 
                    WHEN tmpApT.totalNeto2 = 0 THEN tmpApT.total 
                    ELSE tmpApT.totalNeto2 
                END) sumaAT, 
                COUNT(*)
            totalAT, '1' opt, $comodin userID, tmpApT.nombreUsuario, tmpApT.id_rol FROM (
                    SELECT  u.id_rol, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreUsuario, lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total FROM clientes cl
                    INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote != 2
                    INNER JOIN usuarios u ON u.id_usuario = cl.$comodin
                    WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 1 $filtro
                    GROUP BY u.id_rol, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total
                ) tmpApT GROUP BY $comodin, tmpApT.nombreUsuario, tmpApT.id_rol) d ON d.userID = c.userID
            --SUMA Cancelados contratados
            LEFT JOIN(
            SELECT SUM(
                CASE 
                    WHEN tmpCC.totalNeto2 IS NULL THEN tmpCC.total 
                    WHEN tmpCC.totalNeto2 = 0 THEN tmpCC.total 
                    ELSE tmpCC.totalNeto2 
                END) sumaCanC, 
                COUNT(*)
            totalCanC, '1' opt, $comodin userID, tmpCC.nombreUsuario, tmpCC.id_rol FROM (
                    SELECT  u.id_rol, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreUsuario, lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total FROM clientes cl
                    INNER JOIN lotes lo ON lo.idLote = cl.idLote
                    INNER JOIN usuarios u ON u.id_usuario = cl.$comodin
                    LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
                    INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 15 AND idMovimiento = 45
                    GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
                    WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 0 $filtro
                    GROUP BY u.id_rol, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno),lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total
        ) tmpCC GROUP BY $comodin, tmpCC.nombreUsuario, tmpCC.id_rol) e ON e.userID = d.userID
        GROUP BY a.id_rol, a.userID,a.nombreUsuario, a.sumaTotal, b.sumaCT, c.sumaConT, d.sumaAT, e.sumaCanC, a.totalVentas, b.totalCT, c.totalConT, d.totalAT, e.totalCanC");
        return $query;
    }

    public function validateRegional($id){
        $data = $this->db->query("SELECT * FROM roles_x_usuario WHERE idUsuario = $id and idRol IN (59,60)");
        return $data->result_array();    
    }

    public function getDetails($beginDate, $endDate, $id_rol, $id_usuario, $render){
        $id_lider = $this->session->userdata('id_lider'); // PARA ASISTENTES

        $filtro=" AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000'";
        if ($id_rol == 7) // MJ: Asesor
           { 
            $filtro .= " AND cl.id_asesor = $id_usuario";

            // if($render == 1){
            //     $filtro .= " AND cl.id_asesor = $id_usuario";
            // }else{
            //     $filtro .= " AND cl.id_coordinador = $id_usuario";
            // }
            $comodin = "id_asesor";}
        else if ($id_rol == 9) // MJ: Coordinador
           { 
            if($render == 1){
                $filtro .= " AND (cl.id_coordinador = $id_usuario OR cl.id_asesor = $id_usuario)";
                $comodin = "id_coordinador";
            }else{
                $filtro .= " AND cl.id_coordinador = $id_usuario";
                $comodin = "id_coordinador";
            }
        }
        else if ($id_rol == 3) // MJ: Gerente
            {
            if($render == 1){
                $filtro .= " AND cl.id_gerente = $id_usuario";
                $comodin = "id_gerente";

            }else{
                $filtro .= " AND cl.id_gerente = $id_usuario";
                $comodin = "id_gerente";

            }
        }
        else if ($id_rol == 6) // MJ: Asistente de gerencia
           {
            if($render == 1){
                $filtro .= " AND cl.id_gerente = $id_usuario";
                $comodin = "id_gerente";

            }else{
                $filtro .= " AND cl.id_gerente = $id_usuario";
                $comodin = "id_gerente";

            }
        }
        else if ($id_rol == 2) // MJ: Subdirector
           {
            if($render == 1){
                $filtro .= " AND cl.id_subdirector = $id_usuario";
                $comodin = "id_subdirector";

            }else{
                $filtro .= " AND cl.id_subdirector = $id_usuario";
                $comodin = "id_subdirector";
            }
        }
        else if ($id_rol == 5) // MJ: Asistente subdirección
            {
                if($render == 1){
                    $filtro .= " AND cl.id_subdirector = $id_usuario";
                    $comodin = "id_subdirector";
    
                }else{
                    $filtro .= " AND cl.id_subdirector = $id_usuario";
                    $comodin = "id_subdirector";
                }
            }
        else if ($id_rol == 59) {// MJ: Director regional
            $id_sede = "'" . implode("', '", explode(", ", $this->session->userdata('id_sede'))) . "'"; // MJ: ID sede separado por , como string
            if($render == 1){
                $filtro .= " AND cl.id_regional = $id_usuario OR cl.id_subdirector = $id_usuario";
                $comodin = "id_subdirector";//pendiente

            }else{
                $filtro .= "";
            }
        }
        else if ($id_rol == 59) // MJ: Asistente de dirección regional
            {
                $id_sede = "'" . implode("', '", explode(", ", $this->session->userdata('id_sede'))) . "'"; // MJ: ID sede separado por , como string
                if($render == 1){
                    $filtro .= " AND cl.id_sede IN ($id_sede)";
                }else{
                    $filtro .= "";
                }
                $comodin = "id_subdirector";//pendiente
            }
        else if ($id_rol == 1 || $id_rol == 4) // MJ: Director comercial
           { 
            if($render == 1){

            }else{
                
            }
            $filtro .= "";
            $comodin = "";
            }
        $query = $this->db->query("SELECT 
            FORMAT(ISNULL(a.sumaTotal, 0), 'C') sumaTotal, ISNULL(a.totalVentas, 0) totalVentas, --TOTAL VENDIDO
            FORMAT(ISNULL(b.sumaCT, 0), 'C') sumaCT, ISNULL(b.totalCT, 0) totalCT,  --TOTAL CANCELADO
            FORMAT(ISNULL(c.sumaConT, 0), 'C') sumaConT, ISNULL(c.totalConT, 0) totalConT, --VENDIDO CONTRATADO
            FORMAT(ISNULL(d.sumaAT, 0), 'C') sumaAT, ISNULL(d.totalAT, 0) totalAT, --VENDIDO APARTADO
            FORMAT(ISNULL(e.sumaCanC, 0), 'C') sumaCanC, ISNULL(e.totalCanC, 0) totalCanC, --CANCELADOS CONTRATADOS
            FORMAT(ISNULL(b.sumaCT, 0) - ISNULL(e.sumaCanC, 0), 'C') sumaCanA, 
            ISNULL(b.totalCT, 0) - ISNULL(e.totalCanC, 0) totalCanA,
            ----PORCENTAJES
            ISNULL(CAST((a.totalVentas * 100) / NULLIF(a.totalVentas,0) AS decimal(16,2)), 0) porcentajeTotal, 
            ISNULL(CAST((b.totalCT * 100) / NULLIF(a.totalVentas,0) AS decimal(16,2)), 0) porcentajeTotalC, 
            ISNULL(CAST((c.totalConT * 100) / NULLIF(a.totalVentas,0) AS decimal(16,2)), 0) porcentajeTotalCont, 
            ISNULL(CAST((d.totalAT * 100) / NULLIF(a.totalVentas,0) AS decimal(16,2)), 0) porcentajeTotalAp, 
            ISNULL(CAST((e.totalCanC * 100) / NULLIF(c.totalConT,0) AS decimal(16,2)), 0) porcentajeTotalCanC, 
            ISNULL(CAST(((ISNULL(b.totalCT, 0) - ISNULL(e.totalCanC, 0)) * 100) / NULLIF(d.totalAT,0) AS decimal(16,2)), 0) porcentajeTotalCanA,
            a.id_sede,
            a.sede
            FROM (
            --SUMA TOTAL
            SELECT SUM(
                CASE 
                    WHEN tmpTotal.totalNeto2 IS NULL THEN tmpTotal.total 
                    WHEN tmpTotal.totalNeto2 = 0 THEN tmpTotal.total 
                    ELSE tmpTotal.totalNeto2 
                END) sumaTotal, 
                COUNT(*)
            totalVentas, '1' opt, tmpTotal.sede, tmpTotal.id_sede FROM (
                    SELECT  ss.nombre sede, ss.id_sede, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreUsuario,lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total FROM clientes cl
                    INNER JOIN lotes lo ON lo.idLote = cl.idLote
                    INNER JOIN usuarios u ON u.id_usuario = cl.$comodin
                    INNER JOIN condominios cn ON cn.idCondominio = lo.idCondominio
                    INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
                    LEFT JOIN sedes ss ON ss.id_sede = r.sede_residencial
                    WHERE isNULL(noRecibo, '') != 'CANCELADO'  $filtro
                    GROUP BY  ss.nombre, ss.id_sede, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno),lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total
                ) tmpTotal GROUP BY tmpTotal.sede, tmpTotal.id_sede) a
            --SUMA CANCELADOS TOTALES
            LEFT JOIN(
            SELECT SUM(
                CASE 
                    WHEN tmpCanT.totalNeto2 IS NULL THEN tmpCanT.total 
                    WHEN tmpCanT.totalNeto2 = 0 THEN tmpCanT.total 
                    ELSE tmpCanT.totalNeto2 
                END) sumaCT,
                COUNT(*)
            totalCT, '1' opt, tmpCanT.sede, tmpCanT.id_sede FROM (
                    SELECT ss.nombre sede, ss.id_sede,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreUsuario, lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total FROM clientes cl
                    INNER JOIN lotes lo ON lo.idLote = cl.idLote
                    INNER JOIN usuarios u ON u.id_usuario = cl.$comodin
                    LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.idLote = lo.idLote AND hl.id_cliente = cl.id_cliente
                    INNER JOIN condominios cn ON cn.idCondominio = lo.idCondominio
                    INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
                    LEFT JOIN sedes ss ON ss.id_sede = r.sede_residencial
                    WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 0  $filtro
                    GROUP BY  ss.nombre, ss.id_sede,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total
                ) tmpCanT GROUP BY tmpCanT.sede, tmpCanT.id_sede) b ON b.id_sede = a.id_sede
            --SUMA CONTRATOS TOTALES
            LEFT JOIN(
            SELECT SUM(
                CASE 
                    WHEN tmpConT.totalNeto2 IS NULL THEN tmpConT.total 
                    WHEN tmpConT.totalNeto2 = 0 THEN tmpConT.total 
                    ELSE tmpConT.totalNeto2 
                END) sumaConT,
                COUNT(*)
            totalConT, '1' opt, tmpConT.sede, tmpConT.id_sede FROM (
                    SELECT  ss.nombre sede, ss.id_sede, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreUsuario, lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total FROM clientes cl
                    INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote = 2
                    INNER JOIN usuarios u ON u.id_usuario = cl.$comodin
                    INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 15 AND idMovimiento = 45
                    GROUP BY idLote, idCliente) hl ON hl.idLote = lo.idLote AND hl.idCliente = cl.id_cliente
                    INNER JOIN condominios cn ON cn.idCondominio = lo.idCondominio
                    INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
                    LEFT JOIN sedes ss ON ss.id_sede = r.sede_residencial
                    WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 1  $filtro
                    GROUP BY ss.nombre, ss.id_sede,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total
                ) tmpConT GROUP BY tmpConT.sede, tmpConT.id_sede) c ON c.id_sede = b.id_sede
            --Suma apartados totales
            LEFT JOIN(
            SELECT SUM(
                CASE 
                    WHEN tmpApT.totalNeto2 IS NULL THEN tmpApT.total 
                    WHEN tmpApT.totalNeto2 = 0 THEN tmpApT.total 
                    ELSE tmpApT.totalNeto2 
                END) sumaAT, 
                COUNT(*)
            totalAT, '1' opt, tmpApT.sede, tmpApT.id_sede FROM (
                    SELECT  ss.nombre sede, ss.id_sede,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreUsuario, lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total FROM clientes cl
                    INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote != 2
                    INNER JOIN usuarios u ON u.id_usuario = cl.$comodin
                    INNER JOIN condominios cn ON cn.idCondominio = lo.idCondominio
                    INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
                    LEFT JOIN sedes ss ON ss.id_sede = r.sede_residencial
                    WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 1  $filtro
                    GROUP BY ss.nombre, ss.id_sede,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total
                ) tmpApT GROUP BY tmpApT.sede, tmpApT.id_sede) d ON d.id_sede = c.id_sede
            --SUMA Cancelados contratados
            LEFT JOIN(
            SELECT SUM(
                CASE 
                    WHEN tmpCC.totalNeto2 IS NULL THEN tmpCC.total 
                    WHEN tmpCC.totalNeto2 = 0 THEN tmpCC.total 
                    ELSE tmpCC.totalNeto2 
                END) sumaCanC, 
                COUNT(*)
            totalCanC, '1' opt, tmpCC.sede, tmpCC.id_sede FROM (
                    SELECT  ss.nombre sede, ss.id_sede,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreUsuario, lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total FROM clientes cl
                    INNER JOIN lotes lo ON lo.idLote = cl.idLote
                    INNER JOIN usuarios u ON u.id_usuario = cl.$comodin
                    LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
                    INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 15 AND idMovimiento = 45
                    GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
                    INNER JOIN condominios cn ON cn.idCondominio = lo.idCondominio
                    INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
                    LEFT JOIN sedes ss ON ss.id_sede = r.sede_residencial
                    WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 0  $filtro
                    GROUP BY ss.nombre, ss.id_sede,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno),lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total
        ) tmpCC GROUP BY tmpCC.sede, tmpCC.id_sede) e ON e.id_sede = d.id_sede
        GROUP BY a.id_sede,a.sede, a.sumaTotal, b.sumaCT, c.sumaConT, d.sumaAT, e.sumaCanC, a.totalVentas, b.totalCT, c.totalConT, d.totalAT, e.totalCanC");
        return $query;
    }
}
