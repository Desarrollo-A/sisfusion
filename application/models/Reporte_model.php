<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reporte_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getDataChart($general, $tipoChart, $id_rol, $beginDate, $endDate, $typeSale, $render, $leadersList){
        $filtro = "";
        $comodin2 = "";
        $id_usuario = $this->session->userdata('id_usuario');
        $id_lider = $this->session->userdata('id_lider');
        $typeTransaction = 1;
        $filterTypeSale = '';
        $endDateDos =  date("Y-m-01", strtotime($endDate));
        //Crear por defecto las columnas en default para evaluar esos puntos en la gráfica. 
        $defaultColumns = "WITH cte AS(
            SELECT CAST('$beginDate' AS DATETIME) DateValue
            UNION ALL
            SELECT  DateValue + 1
            FROM    cte   
            WHERE   DateValue + 1 <= '$endDateDos'
        )";

        /* $typeSale "1": CON ENGANCHE | $typeSale "2": SIN ENGANCHE | $typeSale "3": AMBAS */
        if($typeSale == "1")
            $filterTypeSale = ' AND totalValidado  != 0.00 AND totalValidado IS NOT NULL';
        elseif($typeSale == "2")
            $filterTypeSale = ' AND ISNULL(totalValidado, 0.00) <= 0.00';

        if ($id_rol != 9){
            list($filtro, $comodin, $comodin2) = $this->setFilters($typeSale, $id_rol, $render, $filtro, $leadersList, $comodin2, $id_usuario, $id_lider, $typeTransaction);
            list($ventasContratadas, $ventasApartadas, $canceladasContratadas, $canceladasApartadas) = $this->getChartQueries($filtro, $filterTypeSale, $id_rol, $beginDate, $endDate);
        } else {
            $filtro = " AND cl.id_asesor = $id_usuario";
            list($ventasContratadas, $ventasApartadas, $canceladasContratadas, $canceladasApartadas) = $this->getChartQueries($filtro, $filterTypeSale, $id_rol, $beginDate, $endDate);
            $filtro = " AND cl.id_coordinador = $id_usuario";
            $id_rol = 7;
            list($ventasContratadasN, $ventasApartadasN, $canceladasContratadasN, $canceladasApartadasN) = $this->getChartQueries($filtro, $filterTypeSale, $id_rol, $beginDate, $endDate);
            $ventasContratadas = $ventasContratadas . " UNION ALL " . $ventasContratadasN;
            $ventasApartadas = $ventasApartadas . " UNION ALL " . $ventasApartadasN;
            $canceladasContratadas = $canceladasContratadas . " UNION ALL " . $canceladasContratadasN;
            $canceladasApartadas = $canceladasApartadas . " UNION ALL " . $canceladasApartadasN;
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
        else if ($tipoChart == 'vt'){
            $data = $this->db->query("$defaultColumns
            $ventasContratadas
            UNION ALL
            $ventasApartadas
            ORDER BY tipo DESC, rol, año, mes
            OPTION (MAXRECURSION 0)");
        }
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
            $canceladasApartadas
            ORDER BY tipo DESC, rol, año, mes
            OPTION (MAXRECURSION 0)");
        }

        return $data->result_array();    
    }

    public function getChartQueries($filtro, $filterTypeSale, $id_rol, $beginDate, $endDate) {
        $ventasContratadas = "SELECT ISNULL(total, 0) total, ISNULL(cantidad, 0) cantidad, MONTH(DateValue) mes, YEAR(DateValue) año, 'vc' tipo, '$id_rol' rol FROM cte
        LEFT JOIN (SELECT FORMAT(ISNULL(SUM(CASE WHEN isNULL(cl.totalNeto2_cl, lo.totalNeto2) IS NULL THEN isNull(cl.total_cl, lo.total) WHEN isNULL(cl.totalNeto2_cl, lo.totalNeto2) = 0 THEN isNull(cl.total_cl, lo.total) ELSE isNULL(cl.totalNeto2_cl, lo.totalNeto2) END), 0), 'C') total,
        COUNT(*) cantidad, MONTH(cl.fechaApartado) mes, YEAR(cl.fechaApartado) año
        FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote IN (2, 3) AND lo.idStatusContratacion >= 11
        INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 11 AND idMovimiento = 41
        GROUP BY idLote, idCliente) hl ON hl.idLote = lo.idLote AND hl.idCliente = cl.id_cliente
        WHERE ISNULL(noRecibo, '') != 'CANCELADO'  AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 1 AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000' $filtro $filterTypeSale
        GROUP BY MONTH(cl.fechaApartado), YEAR(cl.fechaApartado)) qu ON qu.mes = month(cte.DateValue) AND qu.año = year(cte.DateValue)
        GROUP BY Month(DateValue), YEAR(DateValue), cantidad, total";

        $ventasApartadas = "SELECT ISNULL(total, 0) total, ISNULL(cantidad, 0) cantidad, MONTH(DateValue) mes, YEAR(DateValue) año, 'va' tipo, '$id_rol' rol FROM cte
        LEFT JOIN (SELECT FORMAT(ISNULL(SUM(CASE WHEN isNULL(cl.totalNeto2_cl, lo.totalNeto2) IS NULL THEN isNull(cl.total_cl, lo.total) WHEN isNULL(cl.totalNeto2_cl, lo.totalNeto2) = 0 THEN isNull(cl.total_cl, lo.total) ELSE isNULL(cl.totalNeto2_cl, lo.totalNeto2) END), 0), 'C') total, 
        COUNT(*) cantidad, MONTH(cl.fechaApartado) mes, YEAR(cl.fechaApartado) año
        FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote != 2 AND lo.idStatusContratacion < 11
        WHERE isNULL(noRecibo, '') != 'CANCELADO'  AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 1 AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000' $filtro $filterTypeSale
        GROUP BY MONTH(cl.fechaApartado), YEAR(cl.fechaApartado)) qu ON qu.mes = month(cte.DateValue) AND qu.año = year(cte.DateValue)
        GROUP BY Month(DateValue), YEAR(DateValue), cantidad, total";

        $canceladasContratadas = "SELECT ISNULL(total, 0) total, ISNULL(cantidad ,0) cantidad, MONTH(DateValue) mes, YEAR(DateValue) año, 'cc' tipo, '$id_rol' rol FROM cte
        LEFT JOIN (SELECT FORMAT(ISNULL(SUM(CASE WHEN isNULL(cl.totalNeto2_cl, lo.totalNeto2) IS NULL THEN isNull(cl.total_cl, lo.total) WHEN isNULL(cl.totalNeto2_cl, lo.totalNeto2) = 0 THEN isNull(cl.total_cl, lo.total) ELSE isNULL(cl.totalNeto2_cl, lo.totalNeto2) END), 0), 'C') total, 
        COUNT(*) cantidad, MONTH(cl.fechaApartado) mes, YEAR(cl.fechaApartado) año
        FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote
        LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
        INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
        INNER JOIN historial_lotes hlo2 ON hlo2.idLote = hlo.idLote AND hlo2.idCliente = hlo.idCliente AND hlo2.modificado = hlo.modificado
        WHERE isNULL(noRecibo, '') != 'CANCELADO'  AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 0  
        AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000' $filtro $filterTypeSale
        AND hlo2.idStatusContratacion >= 11
        GROUP BY MONTH(cl.fechaApartado), YEAR(cl.fechaApartado)) qu ON qu.mes = month(cte.DateValue) AND qu.año = year(cte.DateValue)
        GROUP BY Month(DateValue), YEAR(DateValue), cantidad, total";

        $canceladasApartadas = "SELECT ISNULL(total, 0) total, ISNULL(cantidad ,0) cantidad, MONTH(DateValue) mes, YEAR(DateValue) año, 'ca' tipo, '$id_rol' rol FROM cte
        LEFT JOIN (SELECT FORMAT(ISNULL(SUM(CASE WHEN isNULL(cl.totalNeto2_cl, lo.totalNeto2) IS NULL THEN isNull(cl.total_cl, lo.total) WHEN isNULL(cl.totalNeto2_cl, lo.totalNeto2) = 0 THEN isNull(cl.total_cl, lo.total) ELSE isNULL(cl.totalNeto2_cl, lo.totalNeto2) END), 0), 'C') total, 
        COUNT(*) cantidad, MONTH(cl.fechaApartado) mes, YEAR(cl.fechaApartado) año
        FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote
        LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
        INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
        INNER JOIN historial_lotes hlo2 ON hlo2.idLote = hlo.idLote AND hlo2.idCliente = hlo.idCliente AND hlo2.modificado = hlo.modificado
        WHERE isNULL(noRecibo, '') != 'CANCELADO'  AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 0  
        AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000' $filtro $filterTypeSale
        AND hlo2.idStatusContratacion < 11
        GROUP BY MONTH(cl.fechaApartado), YEAR(cl.fechaApartado)) qu ON qu.mes = month(cte.DateValue) AND qu.año = year(cte.DateValue)
        GROUP BY Month(DateValue), YEAR(DateValue), cantidad, total";

        return [$ventasContratadas, $ventasApartadas, $canceladasContratadas, $canceladasApartadas];
    }

    public function setFilters($typeSale = '', $id_rol, $render, $filtro, $leadersList, $comodin2, $id_usuario, $id_lider, $typeTransaction = null, $leader = null) {
        $filterTypeSale = '';
        $comodin = '';
        /* $typeSale "1": CON ENGANCHE | $typeSale "2": SIN ENGANCHE | $typeSale "3": AMBAS */
        if($typeSale == "1"){
            $filterTypeSale = 'AND totalValidado  != 0.00 AND totalValidado IS NOT NULL';
        }elseif($typeSale == "2"){
            $filterTypeSale = 'AND ISNULL(totalValidado, 0.00) <= 0.00';
        }

        $current_rol = $this->session->userdata('id_rol');
        if ($id_rol == 7) { // ASESOR
            if ($render == 1) {
                if ($typeTransaction == null) { // SE CONSULTA DESDE EL ROWDETAIL O LA MODAL QUE SE TRAE EL DETALLE DE LOS LOTES
                    if ($current_rol == 9) // SE VALIAD EL ROL LOGUEADO SÍ ES COORDINADOR SE AGREGA AND
                        $filtro .= " AND cl.id_asesor = $id_usuario AND cl.id_coordinador = $leader";
                    else
                        $filtro .= " AND cl.id_asesor = $id_usuario";
                }
                else // SE CONSULTA DESDE LA TABLA PAPÁ
                    $filtro .= " AND (cl.id_asesor = $id_usuario OR cl.id_coordinador = $id_usuario)";
            }
            else{
                if ($typeTransaction == null) // SE CONSULTA DESDE EL ROWDETAIL O LA MODAL QUE SE TRAE EL DETALLE DE LOS LOTES
                    if ($leadersList[4] == 0) // NO TIENE REGIONAL NI SUBDIRECTOR
                        $filtro .= " AND cl.id_asesor = $leadersList[0] AND cl.id_coordinador = $leadersList[1] AND cl.id_gerente = $leadersList[2]";
                    else // ESTE SÍ TIENE SUBDIRECTOR
                        $filtro .= " AND cl.id_asesor = $leadersList[0] AND cl.id_coordinador = $leadersList[1] AND cl.id_gerente = $leadersList[2] AND cl.id_subdirector = $leadersList[3]";
                else { // SE CONSULTA DESDE LA TABLA PAPÁ
                    if ($leadersList[4] == 0) // NO TIENE REGIONAL NI SUBDIRECTOR
                        $filtro .= " AND cl.id_coordinador = $leadersList[1] AND cl.id_gerente = $leadersList[2]";
                    else // ESTE SÍ TIENE SUBDIRECTOR
                        $filtro .= " AND cl.id_coordinador = $leadersList[1] AND cl.id_gerente = $leadersList[2] AND cl.id_subdirector = $leadersList[3]";
                }
            }
            $comodin = "id_asesor";
        }
        else if ($id_rol == 9) { // COORDINADORES: VA POR ELLOS
            if ($render == 1) {  // CONSULTADA POR ASISTENTE DE GERENCIA
                if ($typeTransaction == null) // SE CONSULTA DESDE EL ROWDETAIL O LA MODAL QUE SE TRAE EL DETALLE DE LOS LOTES
                    $filtro .= " AND cl.id_coordinador = $leadersList[1] AND cl.id_gerente = $leadersList[2]";
                else // SE CONSULTA DESDE LA TABLA PAPÁ ANTES TENIA ID_GERENTE = $ID_LIDER
                    $filtro .= " AND cl.id_coordinador = $id_usuario";                 
                $comodin = "id_asesor";
            } else { // CONSULTA DIRECTOR GENERAL, ASISTENTE DE DIRECCIÓN, FAB Y LIC. GASTÓN, SUBDIRECTOR REGIONAL, ASISTENTES DE SUBDIRECCIÓN REGIONAL
                if ($typeTransaction == null) // SE CONSULTA DESDE EL ROWDETAIL O LA MODAL QUE SE TRAE EL DETALLE DE LOS LOTES
                    $filtro .= " AND cl.id_coordinador = $leadersList[1] AND cl.id_gerente = $leadersList[2] AND cl.id_subdirector = $leadersList[3] AND cl.id_regional = $leadersList[4]";
                else // SE CONSULTA DESDE LA TABLA PAPÁ
                    $filtro .= " AND cl.id_gerente = $leadersList[2] AND cl.id_subdirector = $leadersList[3] AND cl.id_regional = $leadersList[4]";
                $comodin = "id_coordinador";
            }
        }
        else if ($id_rol == 3) { // GERENTES: VA POR ELLOS
            if ($render == 1) {
                $filtro .= " AND cl.id_gerente = $id_usuario";
                $comodin = "id_coordinador";
            } else {  // CONSULTA DIRECTOR GENERAL, ASISTENTE DE DIRECCIÓN, FAB Y LIC. GASTÓN, SUBDIRECTOR REGIONAL, ASISTENTES DE SUBDIRECCIÓN REGIONAL
                if ($typeTransaction == null) // SE CONSULTA DESDE EL ROWDETAIL O LA MODAL QUE SE TRAE EL DETALLE DE LOS LOTES
                    $filtro .= " AND cl.id_gerente = $leadersList[2] AND cl.id_subdirector = $leadersList[3] AND cl.id_regional = $leadersList[4]";
                else // SE CONSULTA DESDE LA TABLA PAPÁ
                    $filtro .= " AND cl.id_subdirector = $leadersList[3] AND cl.id_regional = $leadersList[4]";
                $comodin = "id_gerente";
            }
        }
        else if ($id_rol == 6) { // MJ: Asistente de gerencia
            if ($render == 1) {
                $filtro .= " AND cl.id_gerente = $id_lider";
                $comodin = "id_coordinador";
            } else {
                $filtro .= " AND cl.id_subdirector = $id_usuario AND cl.id_gerente = $id_usuario";
                $comodin = "id_gerente";
            }
        }
        else if ($id_rol == 2) { // CONSULTA DE SUBDIRECTORES
            if ($render == 1) { // SE TRAE LOS GERENTES
                $filtro .= " AND cl.id_subdirector = $id_usuario";
                $comodin = "id_gerente";
            } else { // CONSULTA NIVEL MÁS ALTO DIRECTOR GENERAL, ASISTENTE DE DIRECCIÓN, FAB Y LIC. GASTÓN
                if ($typeTransaction == null) // SE CONSULTA DESDE EL ROWDETAIL O LA MODAL QUE SE TRAE EL DETALLE DE LOS LOTES
                    $filtro .= " AND cl.id_subdirector = $leadersList[3] AND cl.id_regional = $leadersList[4]"; // CON BASE EN UN REGIONAL SE TRAE LAS SUBDIRECCIONES
                else // SE CONSULTA DESDE LA TABLA PAPÁ
                    $filtro .= " AND cl.id_regional = $leadersList[4]"; // CON BASE EN UN REGIONAL SE TRAE LAS SUBDIRECCIONES
                $comodin = "id_subdirector";
            }
        }
        else if ($id_rol == 5 && ($id_usuario == 28 || $id_usuario == 30)) { 
            // MJ: Asistente dirección regional
            if ($render == 1) {
                $filtro .= " AND (cl.id_regional = $id_lider OR cl.id_subdirector = $id_lider)";
                $comodin = "id_subdirector";
            } else {
                $filtro .= "";
            }
        }
        else if ($id_rol == 5 && ($id_usuario != 28 || $id_usuario != 30)) { // CONSULTA DE ASISTENTES DE SUBDIRECCIÓN
            if ($render == 1) { // SE TRAE LOS GERENTES
                $filtro .= " AND cl.id_subdirector = $id_lider";
                $comodin = "id_gerente";
            } else {
                $filtro .= " AND cl.id_regional = $leadersList[4]";
                $comodin = "id_subdirector";
            }
        }
        else if ($id_rol == 59) { // CONSULTA UN DIRECTOR REGIONAL Y VA POR LOS SUBDIRECTORES
            if ($render == 1) { // CONSULTA LO DE SU REGION Y SI ES SUBDIRECTOR DE UNA SEDE TAMBIÉN TRAE LOS REGISTROS
                // SE DESCOMENTÓ EL OR DE SUBDIRECTOR PORQUE NO MOSTRABA ASÍ MISMO A CHUCHO
                // $filtro .= " AND (cl.id_regional = $id_usuario OR cl.id_subdirector = $id_usuario)";
                if ($typeTransaction == null) // SE CONSULTA DESDE EL ROWDETAIL O LA MODAL QUE SE TRAE EL DETALLE DE LOS LOTES
                    $filtro .= " AND cl.id_regional = $leadersList[4]"; // CON BASE EN UN REGIONAL SE TRAE LAS SUBDIRECCIONES
                else // SE CONSULTA DESDE LA TABLA PAPÁ
                    $filtro .= " AND (cl.id_regional = $id_usuario OR cl.id_subdirector = $id_usuario)"; // CON BASE EN UN REGIONAL SE TRAE LAS SUBDIRECCIONES
                $comodin = "id_subdirector";
            } else
                $filtro .= "";
        }
        else if ($id_rol == 1 || $id_rol == 4 || $id_rol == 18 || $id_rol == 33 || $id_rol == 58 || $id_rol == 63 || $id_rol == 69) { // CONSULTA DIRECTOR, ASISTENTE DE DIRECCIÓN, FAB Y LIC. GASTÓN
            $comodin2 = 'LEFT';
            if ($render == 1) { // PRIMERA CARGA
                $filtro .= "";
                $comodin = "id_regional";
            } else {
                $filtro .= "";
                $comodin = "id_regional";
            }
        }

        $filtro = $filtro . $filterTypeSale;

        return [$filtro, $comodin, $comodin2];
    }

    public function getGeneralInformation($beginDate, $endDate, $id_rol, $id_usuario, $render, $leadersList, $typeTransaction, $typeSale) {
        // PARA ASESOR, COORDINADOR, GERENTE, SUBDIRECTOR, REGIONAL Y DIRECCIÓN COMERCIAL
        $id_lider = $this->session->userdata('id_lider'); // PARA ASISTENTES
        $comodin2 = 'LEFT';
        $filtro = " AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000'";

        list($filtro, $comodin, $comodin2) = $this->setFilters($typeSale, $id_rol, $render, $filtro, $leadersList, $comodin2, $id_usuario, $id_lider, $typeTransaction);

        $query = $this->db->query("SELECT
            FORMAT(ISNULL(a.sumaTotal, 0), 'C') sumaTotal, ISNULL(a.totalVentas, 0) totalVentas, --TOTAL VENDIDO
            FORMAT(ISNULL(b.sumaCT, 0), 'C') sumaCT, ISNULL(b.totalCT, 0) totalCT,  --TOTAL CANCELADO
            FORMAT(ISNULL(c.sumaConT, 0), 'C') sumaConT, ISNULL(c.totalConT, 0) totalConT, --VENDIDO CONTRATADO
            FORMAT(ISNULL(d.sumaAT, 0), 'C') sumaAT, ISNULL(d.totalAT, 0) totalAT, --VENDIDO APARTADO
            FORMAT(ISNULL(e.sumaCanC, 0), 'C') sumaCanC, ISNULL(e.totalCanC, 0) totalCanC, --CANCELADOS CONTRATADOS
            FORMAT(ISNULL(f.sumaCanA, 0), 'C') sumaCanA, ISNULL(f.totalCanA, 0) totalCanA, --CANCELADOS APARTADOS
            --FORMAT(ISNULL(b.sumaCT, 0) - ISNULL(e.sumaCanC, 0), 'C') sumaCanA, 
            --ISNULL(b.totalCT, 0) - ISNULL(e.totalCanC, 0) totalCanA,
            FORMAT((ISNULL(d.sumaAT, 0) + ISNULL(c.sumaConT, 0)), 'C') gran_total,
            ----PORCENTAJES
            ISNULL(CAST((a.totalVentas * 100) / NULLIF(a.totalVentas,0) AS decimal(16,2)), 0) porcentajeTotal, 
            ISNULL(CAST((b.totalCT * 100) / NULLIF(a.totalVentas,0) AS decimal(16,2)), 0) porcentajeTotalC, 
            ISNULL(CAST((c.totalConT * 100) / NULLIF(a.totalVentas,0) AS decimal(16,2)), 0) porcentajeTotalCont, 
            ISNULL(CAST((d.totalAT * 100) / NULLIF(a.totalVentas,0) AS decimal(16,2)), 0) porcentajeTotalAp, 
            ISNULL(CAST((e.totalCanC * 100) / NULLIF(a.totalVentas,0) AS decimal(16,2)), 0) porcentajeTotalCanC, 
            ISNULL(CAST((f.totalCanA * 100) / NULLIF(a.totalVentas,0) AS decimal(16,2)), 0) porcentajeTotalCanA, 
            --ISNULL(CAST(((ISNULL(b.totalCT, 0) - ISNULL(e.totalCanC, 0)) * 100) / NULLIF(a.totalVentas,0) AS decimal(16,2)), 0) porcentajeTotalCanA,
            a.userID,
            CASE WHEN a.nombreUsuario = ' ' THEN 'ACUMULADO SIN ESPECIFICAR' ELSE a.nombreUsuario END nombreUsuario,
            ISNULL(a.id_rol, 0) id_rol
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
                    SELECT  u.id_rol, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreUsuario,lo.idLote, lo.nombreLote, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl ,lo.totalNeto2) totalNeto2, isNULL(cl.total_cl ,lo.total) total FROM clientes cl
                    INNER JOIN lotes lo ON lo.idLote = cl.idLote
                    $comodin2 JOIN usuarios u ON u.id_usuario = cl.$comodin
                    WHERE isNULL(noRecibo, '') != 'CANCELADO'  AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) 
                    $filtro
                    GROUP BY  u.id_rol, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno),lo.idLote, lo.nombreLote, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl ,lo.totalNeto2), isNULL(cl.total_cl ,lo.total)
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
                    SELECT u.id_rol,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreUsuario, lo.idLote, lo.nombreLote, 
                    cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, 
                    UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente, 
                    isNULL(cl.totalNeto2_cl ,lo.totalNeto2) totalNeto2, isNULL(cl.total_cl ,lo.total) total FROM clientes cl
                    INNER JOIN lotes lo ON lo.idLote = cl.idLote
                    $comodin2 JOIN usuarios u ON u.id_usuario = cl.$comodin
                    LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.idLote = lo.idLote AND hl.id_cliente = cl.id_cliente
                    INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
                    INNER JOIN historial_lotes hlo2 ON hlo2.idLote = hlo.idLote AND hlo2.idCliente = hlo.idCliente AND hlo2.modificado = hlo.modificado
                    WHERE isNULL(noRecibo, '') != 'CANCELADO'  AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 0 
                    $filtro
                    GROUP BY u.id_rol, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), lo.idLote, lo.nombreLote, 
                    cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, 
                    UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)), 
                    isNULL(cl.totalNeto2_cl ,lo.totalNeto2), isNULL(cl.total_cl ,lo.total)
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
                    SELECT  u.id_rol, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreUsuario, lo.idLote, lo.nombreLote, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl ,lo.totalNeto2) totalNeto2, isNULL(cl.total_cl ,lo.total) total FROM clientes cl
                    INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote IN (2, 3) AND lo.idStatusContratacion >= 11
                    $comodin2 JOIN usuarios u ON u.id_usuario = cl.$comodin
                    INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion >= 11
                    GROUP BY idLote, idCliente) hl ON hl.idLote = lo.idLote AND hl.idCliente = cl.id_cliente
                    WHERE isNULL(noRecibo, '') != 'CANCELADO'  AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 1 
                    $filtro
                    GROUP BY u. id_rol, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), lo.idLote, lo.nombreLote, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl ,lo.totalNeto2), isNULL(cl.total_cl ,lo.total)
                ) tmpConT GROUP BY $comodin, tmpConT.nombreUsuario, tmpConT.id_rol) c ON c.userID = a.userID
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
                    SELECT  u.id_rol, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreUsuario, lo.idLote, lo.nombreLote, 
                    cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, 
                    isNULL(cl.totalNeto2_cl ,lo.totalNeto2) totalNeto2, isNULL(cl.total_cl ,lo.total) total, CONVERT(VARCHAR, cl.fechaApartado, 103) fechaApartado FROM clientes cl
                    INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote != 2 AND lo.idStatusContratacion < 11
                    $comodin2 JOIN usuarios u ON u.id_usuario = cl.$comodin
                    WHERE isNULL(noRecibo, '') != 'CANCELADO'  AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 1 
                    $filtro
                    GROUP BY u.id_rol, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), lo.idLote, lo.nombreLote, cl.id_asesor, 
                    cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, 
                    isNULL(cl.totalNeto2_cl ,lo.totalNeto2), isNULL(cl.total_cl ,lo.total), CONVERT(VARCHAR, cl.fechaApartado, 103)
                ) tmpApT GROUP BY $comodin, tmpApT.nombreUsuario, tmpApT.id_rol) d ON d.userID = a.userID
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
                    SELECT  u.id_rol, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreUsuario, lo.idLote, lo.nombreLote, cl.id_asesor, 
                    cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, 
                    UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente,
                    isNULL(cl.totalNeto2_cl ,lo.totalNeto2) totalNeto2, isNULL(cl.total_cl ,lo.total) total, CONVERT(VARCHAR, cl.fechaApartado, 103) fechaApartado
                    FROM clientes cl
                    INNER JOIN lotes lo ON lo.idLote = cl.idLote
                    $comodin2 JOIN usuarios u ON u.id_usuario = cl.$comodin
                    LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
                    INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
                    INNER JOIN historial_lotes hlo2 ON hlo2.idLote = hlo.idLote AND hlo2.idCliente = hlo.idCliente AND hlo2.modificado = hlo.modificado
                    WHERE isNULL(noRecibo, '') != 'CANCELADO'  AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 0 
                    $filtro AND hlo2.idStatusContratacion >= 11
                    GROUP BY u.id_rol, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno),lo.idLote, lo.nombreLote, cl.id_asesor, cl.id_coordinador, 
                    cl.id_gerente, cl.id_subdirector, cl.id_regional, 
                    UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)),
                    isNULL(cl.totalNeto2_cl ,lo.totalNeto2), isNULL(cl.total_cl ,lo.total), CONVERT(VARCHAR, cl.fechaApartado, 103)
        ) tmpCC GROUP BY $comodin, tmpCC.nombreUsuario, tmpCC.id_rol) e ON e.userID = a.userID
        LEFT JOIN(
            SELECT SUM(
                CASE 
                    WHEN tmpCA.totalNeto2 IS NULL THEN tmpCA.total 
                    WHEN tmpCA.totalNeto2 = 0 THEN tmpCA.total 
                    ELSE tmpCA.totalNeto2 
                END) sumaCanA, 
                COUNT(*)
                totalCanA, '1' opt, $comodin userID, tmpCA.nombreUsuario, tmpCA.id_rol FROM (
                    SELECT  u.id_rol, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreUsuario, lo.idLote, lo.nombreLote, cl.id_asesor, 
                    cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, 
                    UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente,
                    isNULL(cl.totalNeto2_cl ,lo.totalNeto2) totalNeto2, isNULL(cl.total_cl ,lo.total) total, CONVERT(VARCHAR, cl.fechaApartado, 103) fechaApartado
                    FROM clientes cl
                    INNER JOIN lotes lo ON lo.idLote = cl.idLote
                    $comodin2 JOIN usuarios u ON u.id_usuario = cl.$comodin
                    LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
                    INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
                    INNER JOIN historial_lotes hlo2 ON hlo2.idLote = hlo.idLote AND hlo2.idCliente = hlo.idCliente AND hlo2.modificado = hlo.modificado
                    LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = hl.tipo AND oxc.id_catalogo = 48
                    WHERE isNULL(noRecibo, '') != 'CANCELADO'  AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 0 
                    $filtro AND hlo2.idStatusContratacion < 11
                    GROUP BY 
                    u.id_rol, 
                    CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno),
                    lo.idLote, 
                    lo.nombreLote, 
                    cl.id_asesor, 
                    cl.id_coordinador, 
                    cl.id_gerente, 
                    cl.id_subdirector, 
                    cl.id_regional, 
                    UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)),
                    isNULL(cl.totalNeto2_cl ,lo.totalNeto2), 
                    isNULL(cl.total_cl ,lo.total), 
                    CONVERT(VARCHAR, cl.fechaApartado, 103),
                    CONVERT(VARCHAR, hl.modificado, 103), oxc.nombre
        ) tmpCA GROUP BY $comodin, tmpCA.nombreUsuario, tmpCA.id_rol) f ON f.userID = a.userID
        GROUP BY a.id_rol, a.userID,a.nombreUsuario, a.sumaTotal, b.sumaCT, c.sumaConT, d.sumaAT, e.sumaCanC, f.sumaCanA, a.totalVentas, b.totalCT, c.totalConT, d.totalAT, e.totalCanC, f.totalCanA
        ORDER BY a.nombreUsuario");
        return $query;
    }

    public function validateRegional($id){
        $data = $this->db->query("SELECT * FROM roles_x_usuario WHERE idUsuario = $id and idRol IN (59,60)");
        return $data->result_array();    
    }

    public function getDetails($typeSale, $beginDate, $endDate, $id_rol, $id_usuario, $render, $leader, $leadersList) {
        $id_lider = $this->session->userdata('id_lider'); // PARA ASISTENTES
        $comodin2 = 'LEFT';
        $filtro=" AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000'";
        
        list($filtro, $comodin, $comodin2) = $this->setFilters($typeSale, $id_rol, $render, $filtro, $leadersList, $comodin2, $id_usuario, $id_lider, null, $leader);

        $query = $this->db->query("SELECT 
        FORMAT(ISNULL(a.sumaTotal, 0), 'C') sumaTotal, ISNULL(a.totalVentas, 0) totalVentas, --TOTAL VENDIDO
        FORMAT(ISNULL(b.sumaCT, 0), 'C') sumaCT, ISNULL(b.totalCT, 0) totalCT,  --TOTAL CANCELADO
        FORMAT(ISNULL(c.sumaConT, 0), 'C') sumaConT, ISNULL(c.totalConT, 0) totalConT, --VENDIDO CONTRATADO
        FORMAT(ISNULL(d.sumaAT, 0), 'C') sumaAT, ISNULL(d.totalAT, 0) totalAT, --VENDIDO APARTADO
        FORMAT(ISNULL(e.sumaCanC, 0), 'C') sumaCanC, ISNULL(e.totalCanC, 0) totalCanC, --CANCELADOS CONTRATADOS
        FORMAT(ISNULL(f.sumaCanA, 0), 'C') sumaCanA, ISNULL(f.totalCanA, 0) totalCanA, --CANCELADOS APARTADOS
        /*FORMAT(ISNULL(b.sumaCT, 0) - ISNULL(e.sumaCanC, 0), 'C') sumaCanA, 
        ISNULL(b.totalCT, 0) - ISNULL(e.totalCanC, 0) totalCanA,*/
        FORMAT((ISNULL(d.sumaAT, 0) + ISNULL(c.sumaConT, 0)), 'C') gran_total,
        ----PORCENTAJES
        ISNULL(CAST((a.totalVentas * 100) / NULLIF(a.totalVentas,0) AS decimal(16,2)), 0) porcentajeTotal, 
        ISNULL(CAST((b.totalCT * 100) / NULLIF(a.totalVentas,0) AS decimal(16,2)), 0) porcentajeTotalC, 
        ISNULL(CAST((c.totalConT * 100) / NULLIF(a.totalVentas,0) AS decimal(16,2)), 0) porcentajeTotalCont, 
        ISNULL(CAST((d.totalAT * 100) / NULLIF(a.totalVentas,0) AS decimal(16,2)), 0) porcentajeTotalAp, 
        ISNULL(CAST((e.totalCanC * 100) / NULLIF(a.totalVentas,0) AS decimal(16,2)), 0) porcentajeTotalCanC, 
        ISNULL(CAST((f.totalCanA * 100) / NULLIF(a.totalVentas,0) AS decimal(16,2)), 0) porcentajeTotalCanA, 
        --ISNULL(CAST(((ISNULL(b.totalCT, 0) - ISNULL(e.totalCanC, 0)) * 100) / NULLIF(a.totalVentas,0) AS decimal(16,2)), 0) porcentajeTotalCanA,
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
                SELECT  ss.nombre sede, ss.id_sede, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreUsuario,lo.idLote, lo.nombreLote, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl ,lo.totalNeto2) totalNeto2, isNULL(cl.total_cl ,lo.total) total FROM clientes cl
                INNER JOIN lotes lo ON lo.idLote = cl.idLote
                $comodin2 JOIN usuarios u ON u.id_usuario = cl.$comodin
                INNER JOIN condominios cn ON cn.idCondominio = lo.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
                LEFT JOIN sedes ss ON ss.id_sede = r.sede_residencial
                WHERE isNULL(noRecibo, '') != 'CANCELADO'  AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) $filtro
                GROUP BY  ss.nombre, ss.id_sede, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno),lo.idLote, lo.nombreLote, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl ,lo.totalNeto2), isNULL(cl.total_cl ,lo.total)
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
                SELECT ss.nombre sede, ss.id_sede,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreUsuario, lo.idLote, lo.nombreLote, 
                cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, 
                isNULL(cl.totalNeto2_cl ,lo.totalNeto2) totalNeto2, isNULL(cl.total_cl ,lo.total) total, CONVERT(VARCHAR, cl.fechaApartado, 103) fechaApartado FROM clientes cl
                INNER JOIN lotes lo ON lo.idLote = cl.idLote
                $comodin2 JOIN usuarios u ON u.id_usuario = cl.$comodin
                LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.idLote = lo.idLote AND hl.id_cliente = cl.id_cliente
                INNER JOIN condominios cn ON cn.idCondominio = lo.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
                LEFT JOIN sedes ss ON ss.id_sede = r.sede_residencial
                WHERE isNULL(noRecibo, '') != 'CANCELADO'  AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 0  $filtro
                GROUP BY  ss.nombre, ss.id_sede,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), lo.idLote, lo.nombreLote, 
                cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, 
                isNULL(cl.totalNeto2_cl ,lo.totalNeto2), isNULL(cl.total_cl ,lo.total), CONVERT(VARCHAR, cl.fechaApartado, 103)
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
                SELECT  ss.nombre sede, ss.id_sede, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreUsuario, lo.idLote, lo.nombreLote, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl ,lo.totalNeto2) totalNeto2, isNULL(cl.total_cl ,lo.total) total FROM clientes cl
                INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote IN (2, 3) AND lo.idStatusContratacion >= 11
                $comodin2 JOIN usuarios u ON u.id_usuario = cl.$comodin
                INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion >= 11
                GROUP BY idLote, idCliente) hl ON hl.idLote = lo.idLote AND hl.idCliente = cl.id_cliente
                INNER JOIN condominios cn ON cn.idCondominio = lo.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
                LEFT JOIN sedes ss ON ss.id_sede = r.sede_residencial
                WHERE isNULL(noRecibo, '') != 'CANCELADO'  AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 1  $filtro
                GROUP BY ss.nombre, ss.id_sede,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), lo.idLote, lo.nombreLote, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl ,lo.totalNeto2), isNULL(cl.total_cl ,lo.total)
            ) tmpConT GROUP BY tmpConT.sede, tmpConT.id_sede) c ON c.id_sede = a.id_sede
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
                SELECT  ss.nombre sede, ss.id_sede,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreUsuario, lo.idLote, lo.nombreLote, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl ,lo.totalNeto2) totalNeto2, isNULL(cl.total_cl ,lo.total) total FROM clientes cl
                INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote != 2 AND lo.idStatusContratacion < 11
                $comodin2 JOIN usuarios u ON u.id_usuario = cl.$comodin
                INNER JOIN condominios cn ON cn.idCondominio = lo.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
                LEFT JOIN sedes ss ON ss.id_sede = r.sede_residencial
                WHERE isNULL(noRecibo, '') != 'CANCELADO'  AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 1  $filtro
                GROUP BY ss.nombre, ss.id_sede,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), lo.idLote, lo.nombreLote, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl ,lo.totalNeto2), isNULL(cl.total_cl ,lo.total)
            ) tmpApT GROUP BY tmpApT.sede, tmpApT.id_sede) d ON d.id_sede = a.id_sede
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
                SELECT  ss.nombre sede, ss.id_sede,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreUsuario, lo.idLote, lo.nombreLote, 
                cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, 
                isNULL(cl.totalNeto2_cl ,lo.totalNeto2) totalNeto2, isNULL(cl.total_cl ,lo.total) total, CONVERT(VARCHAR, cl.fechaApartado, 103) fechaApartado FROM clientes cl
                INNER JOIN lotes lo ON lo.idLote = cl.idLote
                $comodin2 JOIN usuarios u ON u.id_usuario = cl.$comodin
                LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
                INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
                INNER JOIN historial_lotes hlo2 ON hlo2.idLote = hlo.idLote AND hlo2.idCliente = hlo.idCliente AND hlo2.modificado = hlo.modificado
                INNER JOIN condominios cn ON cn.idCondominio = lo.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
                LEFT JOIN sedes ss ON ss.id_sede = r.sede_residencial
                WHERE isNULL(noRecibo, '') != 'CANCELADO'  AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 0  
                $filtro
                AND hlo2.idStatusContratacion >= 11
                GROUP BY ss.nombre, ss.id_sede,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno),lo.idLote, lo.nombreLote, 
                cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, 
                isNULL(cl.totalNeto2_cl ,lo.totalNeto2), isNULL(cl.total_cl ,lo.total), CONVERT(VARCHAR, cl.fechaApartado, 103)
    ) tmpCC GROUP BY tmpCC.sede, tmpCC.id_sede) e ON e.id_sede = a.id_sede
    --SUMA Cancelados apartados
    LEFT JOIN(
        SELECT SUM(
            CASE 
                WHEN tmpCA.totalNeto2 IS NULL THEN tmpCA.total 
                WHEN tmpCA.totalNeto2 = 0 THEN tmpCA.total 
                ELSE tmpCA.totalNeto2 
            END) sumaCanA, 
            COUNT(*)
            totalCanA, '1' opt, tmpCA.sede, tmpCA.id_sede FROM (
                SELECT  ss.nombre sede, ss.id_sede,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreUsuario, lo.idLote, lo.nombreLote, 
                cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, 
                isNULL(cl.totalNeto2_cl ,lo.totalNeto2) totalNeto2, isNULL(cl.total_cl ,lo.total) total, CONVERT(VARCHAR, cl.fechaApartado, 103) fechaApartado FROM clientes cl
                INNER JOIN lotes lo ON lo.idLote = cl.idLote
                $comodin2 JOIN usuarios u ON u.id_usuario = cl.$comodin
                LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
                INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
                INNER JOIN historial_lotes hlo2 ON hlo2.idLote = hlo.idLote AND hlo2.idCliente = hlo.idCliente AND hlo2.modificado = hlo.modificado
                INNER JOIN condominios cn ON cn.idCondominio = lo.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
                LEFT JOIN sedes ss ON ss.id_sede = r.sede_residencial
                WHERE isNULL(noRecibo, '') != 'CANCELADO'  AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 0  
                $filtro
                AND hlo2.idStatusContratacion < 11
                GROUP BY ss.nombre, ss.id_sede,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno),lo.idLote, lo.nombreLote, 
                cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, 
                isNULL(cl.totalNeto2_cl ,lo.totalNeto2), isNULL(cl.total_cl ,lo.total), CONVERT(VARCHAR, cl.fechaApartado, 103)
    ) tmpCA GROUP BY tmpCA.sede, tmpCA.id_sede) f ON f.id_sede = a.id_sede
    GROUP BY a.id_sede,a.sede, a.sumaTotal, b.sumaCT, c.sumaConT, d.sumaAT, e.sumaCanC, f.sumaCanA, a.totalVentas, b.totalCT, c.totalConT, d.totalAT, e.totalCanC, f.totalCanA");
    return $query;
    }

    public function getGeneralLotesInformation($typeSale, $beginDate, $endDate, $id_rol, $id_usuario, $render, $type, $sede, $leader, $leadersList) {
        // PARA ASESOR, COORDINADOR, GERENTE, SUBDIRECTOR, REGIONAL Y DIRECCIÓN COMERCIAL
        $id_lider = $this->session->userdata('id_lider'); // PARA ASISTENTES
        $comodin2 = 'LEFT';
        $filtro=" AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000'";
        
        list($filtro, $comodin, $comodin2) = $this->setFilters($typeSale, $id_rol, $render, $filtro, $leadersList, $comodin2, $id_usuario, $id_lider, null, $leader);

        /*
        $type = 1 APARTADO FILA PAPÁ
        $type = 11 APARTADO FILA ROW DETAIL POR SEDE
        $type = 2 CONTRATADO FILA PAPÁ
        $type = 22 CONTRATADO FILA ROW DETAIL POR SEDE
        $type = 3 CANCELADO CONTRATADO FILA PAPÁ
        $type = 33 CANCELADO CONTRATADO FILA ROW DETAIL POR SEDE
        $type = 4 CANCELADO APARTADO FILA PAPÁ
        $type = 44 CANCELADO APARTADO FILA ROW DETAIL POR SEDE
        $type = 5 APARTADOS + CONTRATADOS CONTRATADO FILA PAPÁ
        $type = 55 APARTADOS + CONTRATADOS FILA ROW DETAIL POR SEDE */
        if ($type == 1 || $type == 2 || $type == 5 || $type == 11 || $type == 22 || $type == 55) { // MJ: APARTADOS || CONTRATADOS
            if($type == 1 || $type == 11) // MJ: APARTADOS
                $statusLote = "!= 2 AND lo.idStatusContratacion < 11";
            else if($type == 2 || $type == 22) // MJ: CONTRATADOS
                $statusLote = "IN (2, 3) AND lo.idStatusContratacion >= 11";
            else // MJ: APARTADOS / CONTRATADOS
                $statusLote = "IN (2, 3)";
            $filtroSede = ($type == 11 || $type == 22 || $type == 55) ? "AND re.sede_residencial = $sede" : "";
            $query = $this->db->query("SELECT CAST(re.descripcion AS VARCHAR(150)) nombreResidencial, UPPER(co.nombre) nombreCondominio, UPPER(lo.nombreLote) nombreLote, 
            UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente,
            UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) nombreAsesor,
            CASE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) WHEN '  ' THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) END nombreCoordinador,
            CASE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) WHEN '  ' THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) END nombreGerente,
            CASE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) WHEN '  ' THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) END nombreSubdirector,
            CASE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) WHEN '  ' THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) END nombreRegional,
            CONVERT(VARCHAR, cl.fechaApartado, 103) fechaApartado, sc.nombreStatus, st.nombre estatusLote
            FROM clientes cl
            INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idCliente = cl.id_cliente AND lo.idStatusLote $statusLote
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial $filtroSede
            INNER JOIN statusContratacion sc ON sc.idStatusContratacion = lo.idStatusContratacion
            INNER JOIN statusLote st ON st.idStatusLote = lo.idStatusLote
            $comodin2 JOIN usuarios us ON us.id_usuario = cl.$comodin
            LEFT JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
            LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
            LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
            LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
            LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
            WHERE isNULL(noRecibo, '') != 'CANCELADO' AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 1 
            $filtro
            GROUP BY
            CAST(re.descripcion AS VARCHAR(150)), UPPER(co.nombre), UPPER(lo.nombreLote), 
            UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)),
            UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)),
            UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)),
            UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)),
            UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)),
            UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)),
            CONVERT(VARCHAR, cl.fechaApartado, 103), sc.nombreStatus, st.nombre
            ORDER BY sc.nombreStatus");
        } else if ($type == 3 || $type == 33 || $type == 4 || $type == 44) { // MJ: CANCELADOS CONTRATADOS / APARTADOS
            $statusLote = ($type == 4 || $type == 44) ? "<" : ">=";
            $filtroSede = ($type == 33 || $type == 44) ? "AND re.sede_residencial = $sede" : "";
            $query = $this->db->query("SELECT CAST(re.descripcion AS VARCHAR(150)) nombreResidencial, UPPER(co.nombre) nombreCondominio, UPPER(lo.nombreLote) nombreLote, 
            UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente,
            UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) nombreAsesor,
            CASE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) WHEN '  ' THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) END nombreCoordinador,
            CASE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) WHEN '  ' THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) END nombreGerente,
            CASE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) WHEN '  ' THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) END nombreSubdirector,
            CASE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) WHEN '  ' THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) END nombreRegional,
            CONVERT(VARCHAR, cl.fechaApartado, 103) fechaApartado, st.nombreStatus, 'Cancelado' estatusLote, CONVERT(VARCHAR, hl.modificado, 103) fechaLiberacion, oxc.nombre motivoLiberacion
            FROM clientes cl
            INNER JOIN lotes lo ON lo.idLote = cl.idLote
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial $filtroSede
            $comodin2 JOIN usuarios us ON us.id_usuario = cl.$comodin
            LEFT JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
            LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
            LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
            LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
            LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
            LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
            INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
			INNER JOIN historial_lotes hlo2 ON hlo2.idLote = hlo.idLote AND hlo2.idCliente = hlo.idCliente AND hlo2.modificado = hlo.modificado
			INNER JOIN statuscontratacion st ON st.idStatusContratacion = hlo2.idStatusContratacion
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = hl.tipo AND oxc.id_catalogo = 48
            WHERE isNULL(noRecibo, '') != 'CANCELADO' AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 0
            AND hlo2.idStatusContratacion $statusLote 11
            $filtro
			GROUP BY CAST(re.descripcion AS VARCHAR(150)), UPPER(co.nombre), UPPER(lo.nombreLote), 
            UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)),
            UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)),
            UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)),
            UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)),
            UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)),
            UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)),
            CONVERT(VARCHAR, cl.fechaApartado, 103), st.nombreStatus,
            cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional,
            CONVERT(VARCHAR, hl.modificado, 103), oxc.nombre
            ORDER BY st.nombreStatus");
        }
        return $query;       
    }

    public function getVentasConSinRecision($beginDate, $endDate){
        $filtro_query = "";
        $id_rol = $this->session->userdata('id_rol');
        $id_usu = $this->session->userdata('id_usuario');
        $id_lid = $this->session->userdata('id_lider');
        if( ($id_rol !== 1 || $id_rol !== 4) ){
            if ($id_rol == 9 || $id_rol == 7) { // COORDINADOR O ASESOR
                $filtro_query = "AND cl.id_coordinador = $id_usu OR cl.id_asesor = $id_usu";
            }elseif($id_rol == 3) { // GERENTE
                $filtro_query = "AND cl.id_gerente = $id_usu";
            }elseif($id_rol == 2){ //DIRECTORE REGIONAL O SUBDIRECTOR
                $filtro_query = "AND cl.id_subdirector = $id_usu OR cl.id_regional = $id_usu";
            }elseif($id_rol == 6) { // ASISNTENTE DE GERENTE
                $filtro_query = "AND cl.id_gerente = $id_lid";
            }elseif($id_rol == 5){ // ASISTENTE DE SUBDIRECCIÓN
                $filtro_query = "AND cl.id_subdirector = $id_lid OR cl.id_regional = $id_lid";
            }
        }
        $data = $this->db->query("SELECT lo.idLote idLote, CAST(re.descripcion AS VARCHAR(150)) nombreResidencial, UPPER(co.nombre) nombreCondominio, UPPER(lo.nombreLote) nombreLote, 
        UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente,
        UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) nombreAsesor,
        CASE CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno) WHEN '  ' THEN 'SIN ESPECIFICAR' 
        ELSE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) END nombreCoordinador,
        UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) nombreGerente,
        'ACTIVO' estatusActualCliente, UPPER(ISNULL(se.nombre, 'SIN ESPECIFICAR')) plazaVenta,
        UPPER(ISNULL (tv.tipo_venta, 'SIN ESPECIFICAR')) tipoVenta, lo.referencia, 
        CASE WHEN vc.id_cliente IS NULL THEN 'SIN COMPARTIR' ELSE 'ES COMPARTIDA' END esCompartida,
        CASE WHEN (lo.totalNeto2 IS NULL OR lo.totalNeto2 = 0.00) THEN FORMAT(lo.total, 'C') ELSE FORMAT(lo.totalNeto2, 'C') END precioFinal,
        cl.fechaApartado, hlo3.modificado estatus9, hlo5.modificado estatus11, 
        CASE co.tipo_lote WHEN 1 THEN 'COMERCIAL' ELSE 'HABITACIONAL' END tipoLote,
        CASE lo.casa WHEN 1 THEN 'SÍ' ELSE 'NO' END esCasa
        FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idCliente = cl.id_cliente
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
        LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
        INNER JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
        LEFT JOIN sedes se ON se.id_sede = cl.id_sede
        LEFT JOIN tipo_venta tv ON tv.id_tventa = lo.tipo_venta
        LEFT JOIN (SELECT id_cliente FROM ventas_compartidas WHERE estatus IN (1,2) GROUP BY id_cliente) vc ON vc.id_cliente = cl.id_cliente
        LEFT JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 9 AND idMovimiento = 39 AND status = 1 GROUP BY idLote, idCliente) hlo3 ON hlo3.idLote = lo.idLote AND hlo3.idCliente = cl.id_cliente
        LEFT JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 11 AND idMovimiento = 41 AND status = 1 GROUP BY idLote, idCliente) hlo5 ON hlo5.idLote = lo.idLote AND hlo5.idCliente = cl.id_cliente
        WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.fechaApartado BETWEEN '$beginDate 23:59:59.999' AND '$endDate 23:59:59.999' AND cl.status = 1 $filtro_query
        GROUP BY lo.idLote, CAST(re.descripcion AS VARCHAR(150)), UPPER(co.nombre), UPPER(lo.nombreLote), 
        CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno),
        CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno),
        CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno),
        CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno),
        cl.status, se.nombre, tv.tipo_venta, lo.referencia, vc.id_cliente,
        lo.total, lo.totalNeto2, cl.totalNeto2_cl, cl.fechaApartado, hlo3.modificado, hlo5.modificado,
        CASE co.tipo_lote WHEN 1 THEN 'COMERCIAL' ELSE 'HABITACIONAL' END,
        CASE lo.casa WHEN 1 THEN 'SÍ' ELSE 'NO' END
        UNION ALL
        SELECT lo.idLote idLote, CAST(re.descripcion AS VARCHAR(150)) nombreResidencial, UPPER(co.nombre) nombreCondominio, UPPER(lo.nombreLote) nombreLote,
        UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente,
        UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) nombreAsesor,
        CASE CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno) WHEN '  ' THEN 'SIN ESPECIFICAR' 
        ELSE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) END nombreCoordinador,
        UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) nombreGerente,
        'CANCELADO' estatusActualCliente, UPPER(ISNULL(se.nombre, 'SIN ESPECIFICAR')) plazaVenta, 
        'SIN ESPECIFICAR' tipoVenta, lo.referencia, 
        CASE WHEN vc.id_cliente IS NULL THEN 'SIN COMPARTIR' ELSE 'ES COMPARTIDA' END esCompartida,
        CASE WHEN (cl.totalNeto2_cl IS NULL OR cl.totalNeto2_cl = 0.00) THEN FORMAT(lo.total, 'C') ELSE FORMAT(cl.totalNeto2_cl, 'C') END precioFinal,
        cl.fechaApartado, hlo3.modificado estatus9, hlo5.modificado estatus11,
        CASE co.tipo_lote WHEN 1 THEN 'COMERCIAL' ELSE 'HABITACIONAL' END tipoLote,
        CASE lo.casa WHEN 1 THEN 'SÍ' ELSE 'NO' END esCasa
        FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
        LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
        INNER JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
        LEFT JOIN sedes se ON se.id_sede = cl.id_sede
        LEFT JOIN tipo_venta tv ON tv.id_tventa = lo.tipo_venta
        LEFT JOIN (SELECT id_cliente FROM ventas_compartidas WHERE estatus IN (1, 2) GROUP BY id_cliente) vc ON vc.id_cliente = cl.id_cliente
        LEFT JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 9 AND idMovimiento = 39 AND status = 0 GROUP BY idLote, idCliente) hlo3 ON hlo3.idLote = lo.idLote AND hlo3.idCliente = cl.id_cliente
        LEFT JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 11 AND idMovimiento = 41 AND status = 0 GROUP BY idLote, idCliente) hlo5 ON hlo5.idLote = lo.idLote AND hlo5.idCliente = cl.id_cliente
        WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.usuario NOT IN ('MARIA JOSE MARTINEZ MARTINEZ', 'DESARROLLO DESARROLLO DESARROLLO') AND cl.fechaApartado BETWEEN '$beginDate 23:59:59.999' AND '$endDate 23:59:59.999' AND cl.status = 0
        AND isNULL(cl.tipo_venta_cl, 0) IN (0, 1, 2) $filtro_query
        GROUP BY lo.idLote, CAST(re.descripcion AS VARCHAR(150)), UPPER(co.nombre), UPPER(lo.nombreLote), 
        CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno),
        CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno),
        CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno),
        CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno),
        cl.status, se.nombre, tv.tipo_venta, lo.referencia, vc.id_cliente,
        lo.total, lo.totalNeto2, cl.totalNeto2_cl, cl.fechaApartado, hlo3.modificado, hlo5.modificado,
        CASE co.tipo_lote WHEN 1 THEN 'COMERCIAL' ELSE 'HABITACIONAL' END,
        CASE lo.casa WHEN 1 THEN 'SÍ' ELSE 'NO' END");
        return $data;
        
    }
    
    public function getReporteTrimestral($beginDate, $endDate){
        $query=$this->db->query("SELECT t.nombreResidencial as nombreResidencial, t.nombreCondominio as nombreCondominio, t.nombreLote as nombreLote, t.precioFinal as precioFinal, t.referencia as referencia,
        t.nombreAsesor as nombreAsesor, t.fechaApartado as fechaApartado, t.nombreSede as nombreSede, t.tipo_venta as tipo_venta, t.fechaEstatus9 as fechaEstatus9
        FROM (
            SELECT re.descripcion nombreResidencial, UPPER(co.nombre) nombreCondominio, UPPER(lo.nombreLote) nombreLote,
            lo.idLote, FORMAT(lo.totalNeto2, 'C') precioFinal, lo.referencia, 
            CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) nombreAsesor,
            cl.fechaApartado, se.nombre nombreSede, tv.tipo_venta, st.nombre estatus, hl.modificado fechaEstatus9,
            sc.nombreStatus estatusActual, mo.descripcion movimiento
            FROM lotes lo
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
            INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.idLote = lo.idLote AND cl.status = 1
            INNER JOIN usuarios us ON us.id_usuario = cl.id_asesor
            INNER JOIN sedes se ON se.id_sede = cl.id_sede
            INNER JOIN tipo_venta tv ON tv.id_tventa = lo.tipo_venta
            INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes 
            WHERE idStatusContratacion = 9 AND idMovimiento = 39 AND status = 1 GROUP BY idLote, idCliente) 
            hl ON hl.idLote = lo.idLote AND hl.idCliente = cl.id_cliente
            INNER JOIN statuslote st ON st.idStatusLote = lo.idStatusLote
            INNER JOIN statuscontratacion sc ON sc.idStatusContratacion = lo.idStatusContratacion
            INNER JOIN movimientos mo ON mo.idMovimiento = lo.idMovimiento
            WHERE lo.idStatusLote IN (2, 3) AND hl.modificado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:59.999'
            UNION ALL
            SELECT re.descripcion nombreResidencial, UPPER(co.nombre) nombreCondominio, UPPER(lo.nombreLote) nombreLote,
            lo.idLote, FORMAT(lo.totalNeto2, 'C') precioFinal, lo.referencia, 
            CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) nombreAsesor,
            cl.fechaApartado, se.nombre nombreSede, tv.tipo_venta, st.nombre estatus, hl.modificado fechaEstatus9,
            sc.nombreStatus estatusActual, mo.descripcion movimiento
            FROM lotes lo
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
            INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.status = 1
            INNER JOIN ventas_compartidas vc ON vc.id_cliente = cl.id_cliente AND vc.estatus = 1
            INNER JOIN usuarios us ON us.id_usuario = vc.id_asesor
            INNER JOIN sedes se ON se.id_sede = cl.id_sede
            INNER JOIN tipo_venta tv ON tv.id_tventa = lo.tipo_venta
            INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes 
            WHERE idStatusContratacion = 9 AND idMovimiento = 39 AND status = 1 GROUP BY idLote, idCliente) 
            hl ON hl.idLote = lo.idLote AND hl.idCliente = cl.id_cliente 
            INNER JOIN statuslote st ON st.idStatusLote = lo.idStatusLote
            INNER JOIN statuscontratacion sc ON sc.idStatusContratacion = lo.idStatusContratacion
            INNER JOIN movimientos mo ON mo.idMovimiento = lo.idMovimiento
            WHERE lo.idStatusLote IN (2, 3) AND hl.modificado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:59.999'
            UNION ALL
            SELECT re.descripcion nombreResidencial, UPPER(co.nombre) nombreCondominio, UPPER(lo.nombreLote) nombreLote,
            lo.idLote, '$0.00' precioFinal, lo.referencia, 
            CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) nombreAsesor,
            cl.fechaApartado, se.nombre nombreSede, 'Sin especificar' tipo_venta, 'Cancelado' estatus, hl.modificado fechaEstatus9,
            'NA' estatusActual, 'NA' movimiento
            FROM lotes lo
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
            INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 0
            INNER JOIN usuarios us ON us.id_usuario = cl.id_asesor
            INNER JOIN sedes se ON se.id_sede = cl.id_sede
            INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes 
            WHERE idStatusContratacion = 9 AND idMovimiento = 39 AND status = 0 GROUP BY idLote, idCliente) 
            hl ON hl.idLote = lo.idLote AND hl.idCliente = cl.id_cliente
            INNER JOIN historial_liberacion hi ON hi.idLote = lo.idLote AND hi.modificado >= hl.modificado 
            WHERE hl.modificado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:59.999'
            UNION ALL
            SELECT re.descripcion nombreResidencial, UPPER(co.nombre) nombreCondominio, UPPER(lo.nombreLote) nombreLote,
            lo.idLote, '$0.00' precioFinal, lo.referencia, 
            CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) nombreAsesor,
            cl.fechaApartado, se.nombre nombreSede, 'Sin especificar' tipo_venta, 'Cancelado' estatus, hl.modificado fechaEstatus9,
            'NA' estatusActual, 'NA' movimiento
            FROM lotes lo
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
            INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 0
            INNER JOIN ventas_compartidas vc ON vc.id_cliente = cl.id_cliente AND vc.estatus = 1
            INNER JOIN usuarios us ON us.id_usuario = vc.id_asesor
            INNER JOIN sedes se ON se.id_sede = cl.id_sede  
            INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes 
            WHERE idStatusContratacion = 9 AND idMovimiento = 39 AND status = 0 GROUP BY idLote, idCliente) 
            hl ON hl.idLote = lo.idLote AND hl.idCliente = cl.id_cliente
            INNER JOIN historial_liberacion hi ON hi.idLote = lo.idLote AND hi.modificado >= hl.modificado
            WHERE hl.modificado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:59.999'
        ) t
        ORDER BY t.fechaApartado");
        return $query;
    }
}
