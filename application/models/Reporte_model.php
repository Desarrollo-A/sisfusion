<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reporte_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getDataChart($general, $tipoChart, $id_rol, $beginDate, $endDate, $typeSale, $typeLote, $typeConstruccion, $estatusContratacion, $render, $leadersList){
        $filtroEsp = "";
        $comodin2 = "";
        $id_usuario = $this->session->userdata('id_usuario');
        $id_lider = $this->session->userdata('id_lider');
        $typeTransaction = 1;
        $generalFilters = '';
        $generalFiltersExt = '';
        $filtroSt = '';

        $endDateDos =  date("Y-m-01", strtotime($endDate));
        //Crear por defecto las columnas en default para evaluar esos puntos en la gráfica. 
        $defaultColumns = "WITH cte AS(
            SELECT CAST('$beginDate' AS DATETIME) DateValue
            UNION ALL
            SELECT  DateValue + 1
            FROM    cte   
            WHERE   DateValue + 1 <= '$endDateDos'
        )";
        $enganche = $this->getValorEnganche(); // REGRESA CASE CON EL VALOR DEL ENGANCHE
        /* $typeSale "1": CON ENGANCHE | $typeSale "2": SIN ENGANCHE | $typeSale "3": AMBAS */
        if( $typeSale == "1" )
            $generalFilters = " AND $enganche >= 10000";
        elseif( $typeSale == "2" )
            $generalFilters = " AND $enganche < 10000";
        
        /* $typeLote "0": Lotes habitacionales | "1": lotes comerciales | "3": AMBAS */
        if( $typeLote != "3" )
            $generalFiltersExt .= ' AND co.tipo_lote = ' . $typeLote;
        
        /* $typeConstruccion "0": Sin casa | "1": Con casa */
        if( $typeConstruccion != "3" )
            $generalFiltersExt .= ' AND lo.casa = ' . $typeConstruccion;

        if( $estatusContratacion != null )
            $filtroSt = 'INNER JOIN (SELECT idLote, idCliente, MAX(idStatusContratacion) statusContratacion FROM historial_lotes GROUP BY idLote, idCliente) hlo3 ON hlo3.idLote = lo.idLote AND hlo3.idCliente = cl.id_cliente AND hlo3.statusContratacion = ' . $estatusContratacion;
        

        if ($id_rol != 9){
            list($filtroEsp, $comodin, $comodin2) = $this->setFilters($id_rol, $render, $filtroEsp, $leadersList, $comodin2, $id_usuario, $id_lider, $typeTransaction);
            list($ventasContratadas, $ventasApartadas, $canceladasContratadas, $canceladasApartadas) = $this->getChartQueries($generalFilters, $generalFiltersExt, $filtroSt, $id_rol, $beginDate, $endDate, $filtroEsp);
        } else {
            $filtroEsp = " AND cl.id_asesor = $id_usuario";
            list($ventasContratadas, $ventasApartadas, $canceladasContratadas, $canceladasApartadas) = $this->getChartQueries($generalFilters, $generalFiltersExt, $filtroSt, $id_rol, $beginDate, $endDate, $filtroEsp);
            $filtroEsp = " AND cl.id_coordinador = $id_usuario";
            $id_rol = 7;
            list($ventasContratadasN, $ventasApartadasN, $canceladasContratadasN, $canceladasApartadasN) = $this->getChartQueries($generalFilters, $generalFiltersExt, $filtroSt, $id_rol, $beginDate, $endDate, $filtroEsp);
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

    public function getChartQueries( $generalFilters, $generalFiltersExt, $filtroSt, $id_rol, $beginDate, $endDate, $filtroEsp) {
        
        $nombreUsuario = '';
        $precioDescuento = "";
        $total = '';
        $totalChart = "";
        list($nombreUsuario, $total, $precioDescuento, $totalChart) = $this->amountShare($id_rol);
        $ventasContratadas = "SELECT ISNULL(total, 0) total, ISNULL(cantidad, 0) cantidad, MONTH(DateValue) mes, YEAR(DateValue) año, 'vc' tipo, '$id_rol' rol FROM cte
        LEFT JOIN (SELECT --FORMAT(SUM(CASE WHEN (lo.totalNeto2 IS NULL OR lo.totalNeto2 = 0.00) THEN ISNULL(TRY_CAST(ds.costom2f AS DECIMAL(16, 2)) * lo.sup, lo.precio * lo.sup) ELSE lo.totalNeto2 END), 'C') total,
        a.total total,
        COUNT(*)
        cantidad, MONTH(cl.fechaApartado) mes, YEAR(cl.fechaApartado) año
        FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote IN (2, 3, 9) --AND (lo.totalNeto2 IS NOT NULL AND lo.totalNeto2 != 0.00)
        INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 9 AND idMovimiento = 39 GROUP BY idLote, idCliente) hl ON hl.idLote = lo.idLote AND hl.idCliente = cl.id_cliente
        INNER JOIN deposito_seriedad ds ON ds.id_cliente = cl.id_cliente
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        LEFT JOIN ventas_compartidas vc ON vc.id_cliente = cl.id_cliente AND vc.estatus = 1
        LEFT JOIN (
            SELECT ISNULL(tmpConT.total, 0)total, tmpConT.mes, tmpConT.año FROM (
                SELECT COUNT(*) cantidad, MONTH(cl.fechaApartado) mes, YEAR(cl.fechaApartado) año, 
                $totalChart
                FROM clientes cl
                INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote IN (2, 3) AND (lo.totalNeto2 IS NOT NULL AND lo.totalNeto2 != 0.00)
                INNER JOIN deposito_seriedad ds ON ds.id_cliente = cl.id_cliente
                LEFT JOIN ventas_compartidas vc on vc.id_cliente = cl.id_cliente and vc.estatus = 1
                LEFT JOIN (select count(vc.id_cliente) cuenta, cl.id_cliente, cl.fechaApartado from clientes cl
                        INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote IN (2, 3) AND (lo.totalNeto2 IS NOT NULL AND lo.totalNeto2 != 0.00)
                        INNER JOIN ventas_compartidas vc on vc.id_cliente = cl.id_cliente  and vc.estatus = 1
                        WHERE cl.cancelacion_proceso = 2 AND ISNULL(noRecibo, '') != 'CANCELADO' AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 1 AND cl.id_asesor NOT IN (2541, 2562, 2583, 2551, 2572, 2593, 2591, 2570, 2549, 12845) AND cl.id_gerente NOT IN (6739) 
                        AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000' $filtroEsp $generalFilters $generalFiltersExt
                        GROUP BY cl.id_cliente, vc.id_cliente , cl.fechaApartado
                ) vc2 on vc2.id_cliente = cl.id_cliente
                $filtroSt
                WHERE cl.cancelacion_proceso = 2 AND ISNULL(noRecibo, '') != 'CANCELADO' AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 1 AND cl.id_asesor NOT IN (2541, 2562, 2583, 2551, 2572, 2593, 2591, 2570, 2549, 12845) AND cl.id_gerente NOT IN (6739) 
                AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000' $filtroEsp $generalFilters $generalFiltersExt
                GROUP BY MONTH(cl.fechaApartado), YEAR(cl.fechaApartado), cl.fechaApartado, vc.id_cliente, vc.id_regional, vc.id_regional_2, vc.id_subdirector, cl.id_subdirector, vc.id_gerente, cl.id_gerente, vc.id_coordinador, cl.id_coordinador
                ,cl.id_regional,month(cl.fechaApartado), year(cl.fechaApartado), total, lo.totalNeto2, ds.costom2f, lo.sup, lo.precio   
            )AS tmpConT GROUP BY tmpConT.mes, tmpConT.año, tmpConT.total
        ) a on a.año = year(cl.fechaApartado) AND a.mes = month(cl.fechaApartado)
        $filtroSt
        WHERE cl.cancelacion_proceso = 2 AND ISNULL(noRecibo, '') != 'CANCELADO' AND ISNULL(lo.tipo_venta, 0) IN (0, 1, 2) AND cl.status = 1 AND cl.id_asesor NOT IN (2541, 2562, 2583, 2551, 2572, 2593, 2591, 2570, 2549, 12845) AND cl.id_gerente NOT IN (6739) 
        AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000' $filtroEsp $generalFilters $generalFiltersExt
        GROUP BY MONTH(cl.fechaApartado), YEAR(cl.fechaApartado), a.total) qu ON qu.mes = month(cte.DateValue) AND qu.año = year(cte.DateValue)
        GROUP BY Month(DateValue), YEAR(DateValue), cantidad, total";

        $ventasApartadas = "SELECT ISNULL(total, 0) total, ISNULL(cantidad, 0) cantidad, MONTH(DateValue) mes, YEAR(DateValue) año, 'va' tipo, '$id_rol' rol FROM cte
        LEFT JOIN (SELECT --FORMAT(SUM(CASE WHEN (lo.totalNeto2 IS NULL OR lo.totalNeto2 = 0.00) THEN ISNULL(TRY_CAST(ds.costom2f AS DECIMAL(16, 2)) * lo.sup, lo.precio * lo.sup) ELSE lo.totalNeto2 END), 'C') total, 
        a.total total,
        COUNT(*)
        cantidad, MONTH(cl.fechaApartado) mes, YEAR(cl.fechaApartado) año
        FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote = 3 AND (lo.idStatusContratacion < 9 OR lo.idStatusContratacion = 11) AND (lo.totalNeto2 IS NULL OR lo.totalNeto2 = 0.00)
        INNER JOIN deposito_seriedad ds ON ds.id_cliente = cl.id_cliente
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        LEFT JOIN ventas_compartidas vc ON vc.id_cliente = cl.id_cliente AND vc.estatus = 1
        LEFT JOIN (
            SELECT ISNULL(tmpApt.total, 0)total, tmpApt.mes, tmpApt.año FROM (
                SELECT COUNT(*) cantidad, MONTH(cl.fechaApartado) mes, YEAR(cl.fechaApartado) año, 
                $totalChart
                FROM clientes cl
                INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote = 3 AND (lo.idStatusContratacion < 9 OR lo.idStatusContratacion = 11) AND (lo.totalNeto2 IS NULL OR lo.totalNeto2 = 0.00)
                INNER JOIN deposito_seriedad ds ON ds.id_cliente = cl.id_cliente
                LEFT JOIN ventas_compartidas vc on vc.id_cliente = cl.id_cliente and vc.estatus = 1
                LEFT JOIN (select count(vc.id_cliente) cuenta, cl.id_cliente from clientes cl
                            INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote = 3 AND (lo.idStatusContratacion < 9 OR lo.idStatusContratacion = 11) AND (lo.totalNeto2 IS NULL OR lo.totalNeto2 = 0.00)
                            INNER JOIN
                            ventas_compartidas vc on vc.id_cliente = cl.id_cliente  and vc.estatus = 1
                            WHERE cl.cancelacion_proceso = 2 AND isNULL(noRecibo, '') != 'CANCELADO'  AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 1 AND cl.id_asesor NOT IN (2541, 2562, 2583, 2551, 2572, 2593, 2591, 2570, 2549, 12845) AND cl.id_gerente NOT IN (6739)
                            AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000' $filtroEsp $generalFilters $generalFiltersExt
                            GROUP BY cl.id_cliente, vc.id_cliente 
                ) vc2 on vc2.id_cliente = cl.id_cliente
                $filtroSt
                WHERE cl.cancelacion_proceso = 2 AND isNULL(noRecibo, '') != 'CANCELADO'  AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 1 AND cl.id_asesor NOT IN (2541, 2562, 2583, 2551, 2572, 2593, 2591, 2570, 2549, 12845) AND cl.id_gerente NOT IN (6739)
                AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000' $filtroEsp $generalFilters $generalFiltersExt
                GROUP BY MONTH(cl.fechaApartado), YEAR(cl.fechaApartado), cl.fechaApartado, vc.id_cliente, vc.id_regional, vc.id_regional_2, vc.id_subdirector, cl.id_subdirector, vc.id_gerente, cl.id_gerente, vc.id_coordinador, cl.id_coordinador
                ,cl.id_regional,month(cl.fechaApartado), year(cl.fechaApartado), total, lo.totalNeto2, ds.costom2f, lo.sup, lo.precio   
            )AS tmpApt GROUP BY tmpApt.mes, tmpApt.año, tmpApt.total
        ) a on a.año = year(cl.fechaApartado) AND a.mes = month(cl.fechaApartado)
        $filtroSt
        WHERE cl.cancelacion_proceso = 2 AND isNULL(noRecibo, '') != 'CANCELADO'  AND ISNULL(lo.tipo_venta, 0) IN (0, 1, 2) AND cl.status = 1 AND cl.id_asesor NOT IN (2541, 2562, 2583, 2551, 2572, 2593, 2591, 2570, 2549, 12874) AND cl.id_gerente NOT IN (6739)
        AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000' $filtroEsp $generalFilters $generalFiltersExt
        GROUP BY MONTH(cl.fechaApartado), YEAR(cl.fechaApartado), a.total) qu ON qu.mes = month(cte.DateValue) AND qu.año = year(cte.DateValue)
        GROUP BY Month(DateValue), YEAR(DateValue), cantidad, total";

        $canceladasContratadas = "SELECT ISNULL(total, 0) total, ISNULL(cantidad ,0) cantidad, MONTH(DateValue) mes, YEAR(DateValue) año, 'cc' tipo, '$id_rol' rol FROM cte
        LEFT JOIN (SELECT --FORMAT(SUM(CASE WHEN (lo.totalNeto2 IS NULL OR lo.totalNeto2 = 0.00) THEN ISNULL(TRY_CAST(ds.costom2f AS DECIMAL(16, 2)) * lo.sup, lo.precio * lo.sup) ELSE lo.totalNeto2 END), 'C') total, 
        a.total total,
        COUNT(*)
        cantidad, MONTH(cl.fechaApartado) mes, YEAR(cl.fechaApartado) año
        FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote
        LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
        INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 9 AND idMovimiento = 39 AND status = 0 GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
        LEFT JOIN ventas_compartidas vc ON vc.id_cliente = cl.id_cliente AND vc.estatus = 1
        LEFT JOIN (
            SELECT ISNULL(tmpCC.total, 0)total, tmpCC.mes, tmpCC.año FROM (
                SELECT COUNT(*) cantidad, MONTH(cl.fechaApartado) mes, YEAR(cl.fechaApartado) año, 
                $totalChart
                FROM clientes cl
                INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote IN (2, 3) AND (lo.totalNeto2 IS NOT NULL AND lo.totalNeto2 != 0.00)
                INNER JOIN deposito_seriedad ds ON ds.id_cliente = cl.id_cliente
                LEFT JOIN ventas_compartidas vc on vc.id_cliente = cl.id_cliente and vc.estatus = 1
                LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
                INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 9 AND idMovimiento = 39 AND status = 0 GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
                LEFT JOIN (select count(vc.id_cliente) cuenta, cl.id_cliente from clientes cl
                        INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote IN (2, 3) AND (lo.totalNeto2 IS NOT NULL AND lo.totalNeto2 != 0.00)
                        LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
                        INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 9 AND idMovimiento = 39 AND status = 0 GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
                        INNER JOIN
                        ventas_compartidas vc on vc.id_cliente = cl.id_cliente  and vc.estatus = 1
                        WHERE (cl.cancelacion_proceso != 2 OR ( isNULL(noRecibo, '') != 'CANCELADO'  AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 0 AND cl.id_asesor NOT IN (2541, 2562, 2583, 2551, 2572, 2593, 2591, 2570, 2549, 12845) AND cl.id_gerente NOT IN (6739)))
                        AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000' $filtroEsp $generalFilters $generalFiltersExt
                        GROUP BY cl.id_cliente, vc.id_cliente 
                ) vc2 on vc2.id_cliente = cl.id_cliente
                WHERE (cl.cancelacion_proceso != 2 OR ( isNULL(noRecibo, '') != 'CANCELADO'  AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 0 AND cl.id_asesor NOT IN (2541, 2562, 2583, 2551, 2572, 2593, 2591, 2570, 2549, 12845) AND cl.id_gerente NOT IN (6739)))
                AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000' $filtroEsp $generalFilters $generalFiltersExt
                GROUP BY MONTH(cl.fechaApartado), YEAR(cl.fechaApartado), cl.fechaApartado, vc.id_cliente, vc.id_regional, vc.id_regional_2, vc.id_subdirector, cl.id_subdirector, vc.id_gerente, cl.id_gerente, vc.id_coordinador, cl.id_coordinador
                ,cl.id_regional,month(cl.fechaApartado), year(cl.fechaApartado), total, lo.totalNeto2, ds.costom2f, lo.sup, lo.precio   
            )AS tmpCC GROUP BY tmpCC.mes, tmpCC.año, tmpCC.total
        ) a on a.año = year(cl.fechaApartado) AND a.mes = month(cl.fechaApartado)
        $filtroSt
        INNER JOIN deposito_seriedad ds ON ds.id_cliente = cl.id_cliente
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        WHERE (cl.cancelacion_proceso != 2 OR ( isNULL(noRecibo, '') != 'CANCELADO'  AND ISNULL(lo.tipo_venta, 0) IN (0, 1, 2) AND cl.status = 0 AND cl.id_asesor NOT IN (2541, 2562, 2583, 2551, 2572, 2593, 2591, 2570, 2549, 12845) AND cl.id_gerente NOT IN (6739)))
        AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000' $filtroEsp $generalFilters $generalFiltersExt
        GROUP BY MONTH(cl.fechaApartado), YEAR(cl.fechaApartado), a.total) qu ON qu.mes = month(cte.DateValue) AND qu.año = year(cte.DateValue)
        GROUP BY Month(DateValue), YEAR(DateValue), cantidad, total";

        $canceladasApartadas = "SELECT ISNULL(total, 0) total, ISNULL(cantidad ,0) cantidad, MONTH(DateValue) mes, YEAR(DateValue) año, 'ca' tipo, '$id_rol' rol FROM cte
        LEFT JOIN (SELECT --FORMAT(SUM(CASE WHEN (lo.totalNeto2 IS NULL OR lo.totalNeto2 = 0.00) THEN ISNULL(TRY_CAST(ds.costom2f AS DECIMAL(16, 2)) * lo.sup, lo.precio * lo.sup) ELSE lo.totalNeto2 END), 'C') total, 
        a.total total,
        COUNT(*)
        cantidad, MONTH(cl.fechaApartado) mes, YEAR(cl.fechaApartado) año
        FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote
        LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
        INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
        INNER JOIN historial_lotes hlo2 ON hlo2.idLote = hlo.idLote AND hlo2.idCliente = hlo.idCliente AND hlo2.modificado = hlo.modificado
        INNER JOIN deposito_seriedad ds ON ds.id_cliente = cl.id_cliente
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        LEFT JOIN ventas_compartidas vc ON vc.id_cliente = cl.id_cliente AND vc.estatus = 1
        LEFT JOIN (
            SELECT ISNULL(tmpCanCon.total, 0)total, tmpCanCon.mes, tmpCanCon.año FROM (
                SELECT COUNT(*) cantidad, MONTH(cl.fechaApartado) mes, YEAR(cl.fechaApartado) año, 
                $totalChart
                FROM clientes cl
                INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote IN (2, 3) AND (lo.totalNeto2 IS NOT NULL AND lo.totalNeto2 != 0.00)
                INNER JOIN deposito_seriedad ds ON ds.id_cliente = cl.id_cliente
                LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
                INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
                INNER JOIN historial_lotes hlo2 ON hlo2.idLote = hlo.idLote AND hlo2.idCliente = hlo.idCliente AND hlo2.modificado = hlo.modificado
                
                LEFT JOIN ventas_compartidas vc on vc.id_cliente = cl.id_cliente and vc.estatus = 1
                LEFT JOIN (select count(vc.id_cliente) cuenta, cl.id_cliente from clientes cl
                        INNER JOIN lotes lo ON lo.idLote = cl.idLote
                        LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
                        INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
                        INNER JOIN historial_lotes hlo2 ON hlo2.idLote = hlo.idLote AND hlo2.idCliente = hlo.idCliente AND hlo2.modificado = hlo.modificado
        
                        INNER JOIN
                        ventas_compartidas vc on vc.id_cliente = cl.id_cliente  and vc.estatus = 1
                        WHERE (cl.cancelacion_proceso != 2 OR (isNULL(noRecibo, '') != 'CANCELADO'  AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 0 AND cl.id_asesor NOT IN (2541, 2562, 2583, 2551, 2572, 2593, 2591, 2570, 2549, 12845) AND cl.id_gerente NOT IN (6739)))
                        AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000' $filtroEsp $generalFilters $generalFiltersExt
                        AND (hlo2.idStatusContratacion < 9 OR hlo2.idStatusContratacion = 11)
                        GROUP BY cl.id_cliente, vc.id_cliente 
                ) vc2 on vc2.id_cliente = cl.id_cliente
                WHERE (cl.cancelacion_proceso != 2 OR (isNULL(noRecibo, '') != 'CANCELADO'  AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 0 AND cl.id_asesor NOT IN (2541, 2562, 2583, 2551, 2572, 2593, 2591, 2570, 2549, 12845) AND cl.id_gerente NOT IN (6739)))
                AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000' $filtroEsp $generalFilters $generalFiltersExt
                AND (hlo2.idStatusContratacion < 9 OR hlo2.idStatusContratacion = 11)
                GROUP BY MONTH(cl.fechaApartado), YEAR(cl.fechaApartado), cl.fechaApartado, vc.id_cliente, vc.id_regional, vc.id_regional_2, vc.id_subdirector, cl.id_subdirector, vc.id_gerente, cl.id_gerente, vc.id_coordinador, cl.id_coordinador
                ,cl.id_regional,month(cl.fechaApartado), year(cl.fechaApartado), total, lo.totalNeto2, ds.costom2f, lo.sup, lo.precio   
            )AS tmpCanCon GROUP BY tmpCanCon.mes, tmpCanCon.año, tmpCanCon.total
        ) a on a.año = year(cl.fechaApartado) AND a.mes = month(cl.fechaApartado)
        WHERE (cl.cancelacion_proceso != 2 OR (isNULL(noRecibo, '') != 'CANCELADO'  AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 0 AND cl.id_asesor NOT IN (2541, 2562, 2583, 2551, 2572, 2593, 2591, 2570, 2549, 12845) AND cl.id_gerente NOT IN (6739)))
        AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000' $filtroEsp $generalFilters $generalFiltersExt
        AND (hlo2.idStatusContratacion < 9 OR hlo2.idStatusContratacion = 11)
        GROUP BY MONTH(cl.fechaApartado), YEAR(cl.fechaApartado), a.total) qu ON qu.mes = month(cte.DateValue) AND qu.año = year(cte.DateValue)
        GROUP BY Month(DateValue), YEAR(DateValue), cantidad, total";   

        return [$ventasContratadas, $ventasApartadas, $canceladasContratadas, $canceladasApartadas];
    }

    public function setFilters($id_rol, $render, $filtro, $leadersList, $comodin2, $id_usuario, $id_lider, $typeTransaction = null, $leader = null) {
        $comodin = '';

        $current_rol = $this->session->userdata('id_rol');
        if ($id_rol == 7) { // ASESOR
            if ($render == 1) {
                if ($typeTransaction == null) { // SE CONSULTA DESDE EL ROWDETAIL O LA MODAL QUE SE TRAE EL DETALLE DE LOS LOTES
                    if ($current_rol == 9) // SE VALIAD EL ROL LOGUEADO SÍ ES COORDINADOR SE AGREGA AND
                        $filtro .= " AND (cl.id_asesor = $id_usuario or vc.id_asesor = $id_usuario)  AND (cl.id_coordinador = $leader or vc.id_coordinador = $leader)";
                    else
                        $filtro .= " AND (cl.id_asesor = $id_usuario or vc.id_asesor = $id_usuario)";
                }
                else // SE CONSULTA DESDE LA TABLA PAPÁ
                    $filtro .= " AND (cl.id_asesor = $id_usuario  OR vc.id_asesor = $id_usuario  OR cl.id_coordinador = $id_usuario OR vc.id_coordinador = $id_usuario)";
            }
            else {
                if ($typeTransaction == null) // SE CONSULTA DESDE EL ROWDETAIL O LA MODAL QUE SE TRAE EL DETALLE DE LOS LOTES
                    if ($leadersList[4] == 0) // NO TIENE REGIONAL NI SUBDIRECTOR
                        $filtro .= " AND (cl.id_asesor = $leadersList[0] or vc.id_asesor = $leadersList[0]) AND (cl.id_coordinador = $leadersList[1] or vc.id_coordinador = $leadersList[1]) AND (cl.id_gerente = $leadersList[2] or vc.id_gerente = $leadersList[3])";
                    else // ESTE SÍ TIENE SUBDIRECTOR
                        $filtro .= " AND (cl.id_asesor = $leadersList[0] or vc.id_asesor = $leadersList[0]) AND (cl.id_coordinador = $leadersList[1] or vc.id_coordinador= $leadersList[1]) AND (cl.id_gerente = $leadersList[2] or vc.id_gerente = $leadersList[2]) AND (cl.id_subdirector = $leadersList[3] or vc.id_subdirector = $leadersList[3])";
                else { // SE CONSULTA DESDE LA TABLA PAPÁ
                    if ($leadersList[4] == 0) { // NO TIENE REGIONAL 
                        if ($leadersList[3] == 0) // NO TIENE SUBDIRECTPR
                            $filtro .= " AND (cl.id_coordinador = $leadersList[1] or vc.id_coordinador = $leadersList[1]) AND (cl.id_gerente = $leadersList[2] or vc.id_gerente = $leadersList[2])";
                        else if ($leadersList[3] != 0) // SÍ TIENE SUBDIRECTPR
                            $filtro .= " AND (cl.id_coordinador = $leadersList[1] or vc.id_coordinador = $leadersList[1]) AND (cl.id_gerente = $leadersList[2] or vc.id_gerente = $leadersList[2]) AND (cl.id_subdirector = $leadersList[3] or vc.id_subdirector = $leadersList[3])";
                    }
                    else // ESTE SÍ TIENE SUBDIRECTOR
                        $filtro .= " AND (cl.id_coordinador = $leadersList[1] or vc.id_coordinador = $leadersList[1]) AND (cl.id_gerente = $leadersList[2] or vc.id_gerente = $leadersList[2]) AND (cl.id_subdirector = $leadersList[3] or vc.id_subdirector = $leadersList[3]) AND (cl.id_regional = $leadersList[4] or vc.id_regional = $leadersList[4])";
                }
            }
            $comodin = "id_asesor";
        }
        else if ($id_rol == 9) { // COORDINADORES: VA POR ELLOS
            if ($render == 1) {  // CONSULTADA POR ASISTENTE DE GERENCIA
                if ($typeTransaction == null) // SE CONSULTA DESDE EL ROWDETAIL O LA MODAL QUE SE TRAE EL DETALLE DE LOS LOTES
                    $filtro .= " AND (cl.id_coordinador = $leadersList[1] or vc.id_coordinador = $leadersList[1]) AND (cl.id_gerente = $leadersList[2] or vc.id_gerente = $leadersList[2])";
                else  {// SE CONSULTA DESDE LA TABLA PAPÁ ANTES TENIA ID_GERENTE = $ID_LIDER
                    if ($current_rol == 9) // ES UN COORDINADOR EL QUE ESTPA LOGUEADO (TRAE LAS VENTAS DONDE ES COORDINADOR O ÉL EL ASESOR) hay que ver si también ponemos al asesor
                        $filtro .= " AND (cl.id_asesor = $id_usuario OR vc.id_asesor = $id_usuario OR cl.id_coordinador = $id_usuario OR vc.id_coordinador = $id_usuario)";
                    else // ES ASESOR O CUALQUIER OTRO ROL DISTINTO AL DE COORDINADOR
                        $filtro .= " AND (cl.id_coordinador = $id_usuario or vc.id_coordinador = $id_usuario)";
                }               
                $comodin = "id_asesor";
            } else { // CONSULTA DIRECTOR GENERAL, ASISTENTE DE DIRECCIÓN, FAB Y LIC. GASTÓN, SUBDIRECTOR REGIONAL, ASISTENTES DE SUBDIRECCIÓN REGIONAL
                if ($typeTransaction == null) // SE CONSULTA DESDE EL ROWDETAIL O LA MODAL QUE SE TRAE EL DETALLE DE LOS LOTES
                    $filtro .= " AND (cl.id_coordinador = $leadersList[1] or vc.id_coordinador = $leadersList[1]) AND (cl.id_gerente = $leadersList[2] or vc.id_gerente = $leadersList[2]) AND (cl.id_subdirector = $leadersList[3] or vc.id_subdirector = $leadersList[3]) AND (cl.id_regional = $leadersList[4] or vc.id_regional = $leadersList[4])";
                else // SE CONSULTA DESDE LA TABLA PAPÁ
                    $filtro .= " AND (cl.id_gerente = $leadersList[2] or vc.id_gerente = $leadersList[2]) AND (cl.id_subdirector = $leadersList[3] or vc.id_subdirector = $leadersList[3]) AND (cl.id_regional = $leadersList[4] or vc.id_regional = $leadersList[4])";
                $comodin = "id_coordinador";
            }
        }
        else if ($id_rol == 3) { // GERENTES: VA POR ELLOS
            if ($render == 1) {
                $filtro .= " AND (cl.id_gerente = $id_usuario OR vc.id_gerente = $id_usuario)";
                $comodin = "id_coordinador";
            } else {  // CONSULTA DIRECTOR GENERAL, ASISTENTE DE DIRECCIÓN, FAB Y LIC. GASTÓN, SUBDIRECTOR REGIONAL, ASISTENTES DE SUBDIRECCIÓN REGIONAL
                if ($typeTransaction == null) // SE CONSULTA DESDE EL ROWDETAIL O LA MODAL QUE SE TRAE EL DETALLE DE LOS LOTES
                    $filtro .= " AND (cl.id_gerente = $leadersList[2] or vc.id_gerente = $leadersList[2]) AND (cl.id_subdirector = $leadersList[3] or vc.id_subdirector = $leadersList[3]) AND (cl.id_regional = $leadersList[4] or vc.id_regional = $leadersList[4])";
                else // SE CONSULTA DESDE LA TABLA PAPÁ
                    $filtro .= "AND (cl.id_subdirector = $leadersList[3] or vc.id_subdirector = $leadersList[3]) AND (cl.id_regional = $leadersList[4] or vc.id_regional = $leadersList[4])" ;
                $comodin = "id_gerente";
            }
        }
        else if ($id_rol == 6) { // MJ: Asistente de gerencia
            if ($render == 1) {
                $filtro .= " AND (cl.id_gerente = $id_lider OR vc.id_gerente = $id_lider)";
                $comodin = "id_coordinador";
            } else {
                $filtro .= " AND (cl.id_subdirector = $id_usuario or vc.id_subdirector = $id_usuario) AND (cl.id_gerente = $id_usuario or vc.id_gerente = $id_usuario)";
                $comodin = "id_gerente";
            }
        }
        else if ($id_rol == 2) { // CONSULTA DE SUBDIRECTORES
            if ($render == 1) { // SE TRAE LOS GERENTES
                $filtro .= " AND (cl.id_subdirector = $id_usuario OR vc.id_subdirector = $id_usuario)";
                $comodin = "id_gerente";
            } else { // CONSULTA NIVEL MÁS ALTO DIRECTOR GENERAL, ASISTENTE DE DIRECCIÓN, FAB Y LIC. GASTÓN
                if ($typeTransaction == null) // SE CONSULTA DESDE EL ROWDETAIL O LA MODAL QUE SE TRAE EL DETALLE DE LOS LOTES
                    $filtro .= " AND (cl.id_subdirector = $leadersList[3] or vc.id_subdirector = $leadersList[3]) AND (cl.id_regional = $leadersList[4] or vc.id_regional = $leadersList[4])"; // CON BASE EN UN REGIONAL SE TRAE LAS SUBDIRECCIONES
                else // SE CONSULTA DESDE LA TABLA PAPÁ
                    $filtro .= " AND (cl.id_regional = $leadersList[4] or vc.id_regional = $leadersList[4])"; // CON BASE EN UN REGIONAL SE TRAE LAS SUBDIRECCIONES
                $comodin = "id_subdirector";
            }
        }
        else if ($id_rol == 5 && ($id_usuario == 28 || $id_usuario == 30 || $id_usuario == 4888)) { 
            // MJ: Asistente dirección regional
            if ($render == 1) {
                $filtro .= " AND (cl.id_regional = $id_lider OR vc.id_regional = $id_lider OR cl.id_subdirector = $id_lider OR vc.id_subdirector = $id_lider)";
                $comodin = "id_subdirector";
            } else {
                $filtro .= "";
            }
        }
        else if ($id_rol == 5 && ($id_usuario != 28 || $id_usuario != 30 || $id_usuario != 4888)) { // CONSULTA DE ASISTENTES DE SUBDIRECCIÓN
            if ($render == 1) { // SE TRAE LOS GERENTES
                $filtro .= " AND (cl.id_subdirector = $id_lider OR vc.id_subdirector)";
                $comodin = "id_gerente";
            } else {
                $filtro .= " AND (cl.id_regional = $leadersList[4] or vc.id_regional = $leadersList[4])";
                $comodin = "id_subdirector";
            }
        }
        else if ($id_rol == 59) { // CONSULTA UN DIRECTOR REGIONAL Y VA POR LOS SUBDIRECTORES
            if ($render == 1) { // CONSULTA LO DE SU REGION Y SI ES SUBDIRECTOR DE UNA SEDE TAMBIÉN TRAE LOS REGISTROS
                // SE DESCOMENTÓ EL OR DE SUBDIRECTOR PORQUE NO MOSTRABA ASÍ MISMO A CHUCHO
                // $filtro .= " AND (cl.id_regional = $id_usuario OR vc.id_regional = $id_usuario OR cl.id_subdirector = $id_usuario OR vc.id_subdirector = $id_usuario)";
                if ($typeTransaction == null) // SE CONSULTA DESDE EL ROWDETAIL O LA MODAL QUE SE TRAE EL DETALLE DE LOS LOTES
                    $filtro .= " AND (cl.id_regional = $leadersList[4] or vc.id_regional = $leadersList[4])"; // CON BASE EN UN REGIONAL SE TRAE LAS SUBDIRECCIONES
                else // SE CONSULTA DESDE LA TABLA PAPÁ
                    $filtro .= " AND (cl.id_regional = $id_usuario OR vc.id_regional= $id_usuario OR cl.id_subdirector = $id_usuario OR vc.id_subdirector = $id_usuario)"; // CON BASE EN UN REGIONAL SE TRAE LAS SUBDIRECCIONES
                $comodin = "id_subdirector";
            } else
                $filtro .= "";
        }
        else if ($id_rol == 1 || $id_rol == 4 || $id_rol == 18 || $id_rol == 33 || $id_rol == 58 || $id_rol == 63 || $id_rol == 69 || $id_rol == 72) { // CONSULTA DIRECTOR, ASISTENTE DE DIRECCIÓN, FAB, LIC. GASTÓN Y CONNIE
            $comodin2 = 'LEFT';
            if ($render == 1) { // PRIMERA CARGA
                $filtro .= "";
                $comodin = "id_regional";
            } else {
                $filtro .= "";
                $comodin = "id_regional";
            }
        }

        return [$filtro, $comodin, $comodin2];
    }

    public function getGeneralInformation($beginDate, $endDate, $typeSale, $typeLote, $typeConstruccion, $estatusContratacion, $id_rol, $id_usuario, $render, $leadersList, $typeTransaction, $generalArr, $aptArr, $contArr, $canaparArr, $canconArr){
        // PARA ASESOR, COORDINADOR, GERENTE, SUBDIRECTOR, REGIONAL Y DIRECCIÓN COMERCIAL
        $id_lider = $this->session->userdata('id_lider'); // PARA ASISTENTES
        $comodin2 = 'LEFT';
        $filtroExt = '';
        $filtroSt = '';
        $join = '';
        
        $loteFiltro = '';
        $aptList = '';
        $conList = '';
        $canConList = '';
        $canAptList = '';
        $nombreUsuario = '';
        $precioDescuento = "";
        $total = '';
        
        $enganche = $this->getValorEnganche(); // REGRESA CASE CON EL VALOR DEL ENGANCHE
        $filtro = " AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000'";
        /* $typeSale "1": CON ENGANCHE | $typeSale "2": SIN ENGANCHE | $typeSale "3": AMBAS */
        if( $typeSale == "1" )
            $filtro .= " AND $enganche >= 10000";
        elseif( $typeSale == "2" )
            $filtro .= " AND $enganche < 10000";
        
        /* $typeLote "0": Lotes habitacionales | "1": lotes comerciales | "3": AMBAS */
        if( $typeLote != "3" )
            $filtroExt .= ' AND co.tipo_lote = ' . $typeLote;
        
        /* $typeConstruccion "0": Sin casa | "1": Con casa */
        if( $typeConstruccion != "3" )
            $filtroExt .= ' AND lo.casa = ' . $typeConstruccion;

        if( $estatusContratacion != null )
            $filtroSt = 'INNER JOIN (SELECT idLote, idCliente, MAX(idStatusContratacion) statusContratacion FROM historial_lotes GROUP BY idLote, idCliente) hlo3 ON hlo3.idLote = lo.idLote AND hlo3.idCliente = cl.id_cliente AND hlo3.statusContratacion = ' . $estatusContratacion;

        $aptId = $aptArr == "0" ? ['0'] : '(' . implode(',', $aptArr) . ')';
        $aptList .= $aptId == '(0)' ? '': 'and lo.idLote in'.$aptId;
        $contId = $contArr == "0" ? ['0'] : '(' . implode(',', $contArr) . ')';
        $conList .= $contId == '(0)' ? '': 'and lo.idLote in'.$contId;
        $canaptId = $canaparArr == "0" ? ['0'] : '(' . implode(',', $canaparArr) . ')';
        $canAptList .= $canaptId == '(0)' ? '': 'and lo.idLote in'.$canaptId;
        $cacontId = $canconArr == "0" ? ['0'] : '(' . implode(',', $canconArr) . ')';
        $canConList .= $cacontId == '(0)' ? '': 'and lo.idLote in'.$cacontId;
        $idList = $generalArr == [0,0,0,0] ? '0' : '(' . implode(',', $generalArr) . ')';
        $loteFiltro .= $idList == "0" ? '' : ' and lo.idLote IN ' . $idList;


        list($filtro, $comodin, $comodin2) = $this->setFilters($id_rol, $render, $filtro, $leadersList, $comodin2, $id_usuario, $id_lider, $typeTransaction);
        list($nombreUsuario, $total, $precioDescuento) = $this->amountShare($id_rol);

        $query = $this->db->query("SELECT 
        
            FORMAT(ISNULL(contratadas.sumaConT, 0), 'C') sumaConT, ISNULL(contratadas.totalConT, 0) totalConT, --VENDIDO CONTRATADO
            FORMAT(ISNULL(apartadas.sumaAT, 0), 'C') sumaAT, ISNULL(apartadas.totalAT, 0) totalAT, --VENDIDO APARTADO
            FORMAT(ISNULL(cancontratadas.sumaCanC, 0), 'C') sumaCanC, ISNULL(cancontratadas.totalCanC, 0) totalCanC, --CANCELADOS CONTRATADOS
            FORMAT(ISNULL(canapartadas.sumaCanA, 0), 'C') sumaCanA, ISNULL(canapartadas.totalCanA, 0) totalCanA, --CANCELADOS APARTADOS
            FORMAT((ISNULL(apartadas.sumaAT, 0) + ISNULL(contratadas.sumaConT, 0)), 'C') gran_total,
            ----PORCENTAJES
            ISNULL( CAST( ( (ISNULL(contratadas.totalConT, 0) + ISNULL(apartadas.totalAT, 0) ) * 100) /  NULLIF(ISNULL(contratadas.totalConT, 0) + ISNULL(apartadas.totalAT, 0), 0) AS decimal(16,2)), 0) porcentajeTotal,
            ISNULL( CAST( ( (ISNULL(canapartadas.totalCanA, 0) + ISNULL(cancontratadas.totalCanC, 0) ) * 100) /  NULLIF(ISNULL(contratadas.totalConT, 0) + ISNULL(apartadas.totalAT, 0), 0) AS decimal(16,2)), 0) porcentajeTotalC,
            ISNULL( CAST( (contratadas.totalConT * 100) /  NULLIF(ISNULL(contratadas.totalConT, 0) + ISNULL(apartadas.totalAT, 0), 0) AS decimal(16,2)), 0) porcentajeTotalCont,
            ISNULL( CAST( (apartadas.totalAT * 100) /  NULLIF(ISNULL(contratadas.totalConT, 0) + ISNULL(apartadas.totalAT, 0), 0) AS decimal(16,2)), 0) porcentajeTotalAp,
            ISNULL( CAST( (cancontratadas.totalCanC * 100) /  NULLIF(ISNULL(contratadas.totalConT, 0) + ISNULL(apartadas.totalAT, 0), 0) AS decimal(16,2)), 0) porcentajeTotalCanC,
            ISNULL( CAST( (canapartadas.totalCanA * 100) /  NULLIF(ISNULL(contratadas.totalConT, 0) + ISNULL(apartadas.totalAT, 0), 0) AS decimal(16,2)), 0) porcentajeTotalCanA,
            ISNULL(ISNULL(ISNULL (apartadas.nombreUsuario, contratadas.nombreUsuario), canapartadas.nombreUsuario), cancontratadas.nombreUsuario) nombreUsuario, general.userID
            ,UPPER(ISNULL(contratadas.sedeNombre, 'SIN ESPECIFICAR')) AS contratadasSede
            ,UPPER(ISNULL(apartadas.sedeNombre, 'SIN ESPECIFICAR')) as apartadasSede,
            
            COALESCE(apartadas.id_array, '0') AS apt_arr,COALESCE(contratadas.id_array, '0') AS cont_arr,COALESCE(cancontratadas.id_array, '0') AS cancon_arr,COALESCE(canapartadas.id_array, '0') AS canapar_arr
            FROM (
				-- SUMA TOTALES
				SELECT SUM(tmpTotal.total) sumaTotal, COUNT(*) totalVentas, '1' opt, $comodin userID, tmpTotal.id_rol, tmpTotal.nombreUsuario, tmpTotal.id_sede
				FROM (
					SELECT 
                    $nombreUsuario,
                    u.id_rol, lo.idLote, lo.nombreLote, cl.id_asesor, cl.id_coordinador, cl.id_gerente, 
					cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, 
					
                    SUM(CASE WHEN (lo.totalNeto2 IS NULL OR lo.totalNeto2 = 0.00) THEN ISNULL(TRY_CAST(ds.costom2f AS DECIMAL(16, 2)) * lo.sup, lo.precio * lo.sup) ELSE lo.totalNeto2 END) total
					,COALESCE(sede.id_sede, 0) id_sede
                    FROM clientes cl
					INNER JOIN lotes lo ON lo.idLote = cl.idLote
                    INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                    LEFT JOIN ventas_compartidas vc ON vc.id_cliente = cl.id_cliente and vc.estatus = 1
                    LEFT JOIN sedes sede ON sede.id_sede = cl.id_sede
					$comodin2 JOIN usuarios u ON u.id_usuario = cl.$comodin
					INNER JOIN deposito_seriedad ds ON ds.id_cliente = cl.id_cliente
                    $filtroSt
                    
                    WHERE isNULL(noRecibo, '') != 'CANCELADO'  AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.id_asesor NOT IN (2541, 2562, 2583, 2551, 2572, 2593, 2591, 2570, 2549, 12845) AND cl.id_gerente NOT IN (6739)
					$filtro $filtroExt
                    $loteFiltro
					GROUP BY u.id_rol, lo.idLote, lo.nombreLote, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, 
					cl.nombre, cl.apellido_paterno, cl.apellido_materno,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), sede.id_sede
                    ,vc.id_cliente, cl.id_cliente, u.id_lider,  vc.id_cliente, vc.id_asesor , vc.id_coordinador, vc.id_gerente, vc.id_subdirector, vc.id_regional, vc.id_regional_2
				) tmpTotal GROUP BY $comodin, tmpTotal.id_rol, tmpTotal.nombreUsuario, tmpTotal.id_sede
			) general
            LEFT JOIN (
                --VENTAS APARTADAS
                SELECT SUM(tmpApT.total) sumaAT, COUNT(*) totalAT, '1' opt, $comodin userID, tmpApT.nombreUsuario, tmpApT.id_rol , tmpApT.id_sede, tmpApT.sedeNombre,STRING_AGG(CAST(tmpApT.idLote AS VARCHAR(MAX)),',')id_array
                FROM(
                    SELECT 
                    ISNULL(u.id_rol, 0) id_rol, lo.idLote, lo.nombreLote, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, 
                    $nombreUsuario,
                    COALESCE(sede.nombre, 'SIN ESPECIFICAR') sedeNombre, COALESCE(sede.id_sede, 0) id_sede,
                    $total
                    FROM clientes cl
                    INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote = 3 AND (lo.idStatusContratacion < 9 OR lo.idStatusContratacion = 11)  AND (lo.totalNeto2 IS NULL OR lo.totalNeto2 = 0.00)
                    INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                    LEFT JOIN sedes sede ON sede.id_sede = cl.id_sede
                    LEFT JOIN ventas_compartidas vc ON vc.id_cliente = cl.id_cliente and vc.estatus = 1
                    left join (select count(vc.id_cliente) cuenta, cl.id_cliente from clientes cl
                        inner join
                        ventas_compartidas vc on vc.id_cliente = cl.id_cliente  and vc.estatus = 1
                        group by cl.id_cliente, vc.id_cliente
                    ) vc2 on vc2.id_cliente = cl.id_cliente
                    $comodin2 JOIN usuarios u ON u.id_usuario = cl.$comodin
                    INNER JOIN deposito_seriedad ds ON ds.id_cliente = cl.id_cliente
                    $filtroSt
                    WHERE cl.cancelacion_proceso = 2 AND isNULL(noRecibo, '') != 'CANCELADO'  AND ISNULL(lo.tipo_venta, 0) IN (0, 1, 2) AND cl.status = 1 AND cl.id_asesor NOT IN (2541, 2562, 2583, 2551, 2572, 2593, 2591, 2570, 2549, 12845) AND cl.id_gerente NOT IN (6739)
                    $filtro $filtroExt
                    $aptList
                    GROUP BY u.id_rol, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), lo.idLote, lo.nombreLote, cl.id_asesor, 
                    cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, 
                    CONVERT(VARCHAR, cl.fechaApartado, 103),  vc.id_cliente, u.id_lider,sede.nombre, sede.id_sede, cl.id_cliente, vc.id_cliente, vc.id_asesor , vc.id_coordinador, vc.id_gerente, vc.id_subdirector, vc.id_regional, vc.id_regional_2
                ) tmpApT GROUP BY $comodin, tmpApT.nombreUsuario, tmpApT.id_rol, tmpApT.sedeNombre, tmpApT.id_sede
            ) apartadas ON apartadas.userID = general.userID and apartadas.id_sede = general.id_sede AND apartadas.nombreUsuario = general.nombreUsuario
            LEFT JOIN(
                -- VENTAS CONTRATADAS
                SELECT SUM(tmpConT.total) sumaConT, COUNT(*) totalConT, '1' opt, $comodin userID, tmpConT.nombreUsuario, tmpConT.id_rol , tmpConT.id_sede, tmpConT.sedeNombre, STRING_AGG(CAST(tmpConT.idLote AS VARCHAR(MAX)), ',')id_array
                FROM (
                    SELECT 
                    ISNULL(u.id_rol, 0) id_rol, lo.idLote, lo.nombreLote, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
                    $nombreUsuario
                    
                    ,COALESCE(sede.nombre, 'SIN ESPECIFICAR') sedeNombre, COALESCE(sede.id_sede, 0) id_sede,
                    $total
                    FROM clientes cl
                    INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote IN (2, 3, 9) -- AND (lo.totalNeto2 IS NOT NULL AND lo.totalNeto2 != 0.00)
                    INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                    LEFT JOIN ventas_compartidas vc ON vc.id_cliente = cl.id_cliente and vc.estatus = 1
                    left join (select count(vc.id_cliente) cuenta, cl.id_cliente from clientes cl
                        inner join
                        ventas_compartidas vc on vc.id_cliente = cl.id_cliente  and vc.estatus = 1
                        group by cl.id_cliente, vc.id_cliente
                    ) vc2 on vc2.id_cliente = cl.id_cliente
                    LEFT JOIN sedes sede ON sede.id_sede = cl.id_sede
                    $comodin2  JOIN usuarios u ON u.id_usuario = cl.$comodin
                    INNER JOIN deposito_seriedad ds ON ds.id_cliente = cl.id_cliente
                    INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 9 AND idMovimiento = 39
                    GROUP BY idLote, idCliente) hl ON hl.idLote = lo.idLote AND hl.idCliente = cl.id_cliente
                    $filtroSt
                    WHERE cl.cancelacion_proceso = 2 AND isNULL(noRecibo, '') != 'CANCELADO'  AND ISNULL(lo.tipo_venta, 0) IN (0, 1, 2) AND cl.status = 1 AND cl.id_asesor NOT IN (2541, 2562, 2583, 2551, 2572, 2593, 2591, 2570, 2549, 12845) AND cl.id_gerente NOT IN (6739)
                    $filtro $filtroExt
                    $conList
                    GROUP BY u. id_rol, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), lo.idLote, lo.nombreLote, cl.id_asesor, 
                    cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, 
                    u.id_lider,sede.nombre, sede.id_sede, cl.id_cliente,vc.id_cliente, vc.id_asesor , vc.id_coordinador, vc.id_gerente, vc.id_subdirector, vc.id_regional, vc.id_regional_2
                ) tmpConT GROUP BY $comodin, tmpConT.nombreUsuario, tmpConT.id_rol, tmpConT.id_sede, tmpConT.sedeNombre
            ) contratadas ON contratadas.userID = general.userID and contratadas.id_sede = general.id_sede AND contratadas.nombreUsuario = general.nombreUsuario
            LEFT JOIN(
                SELECT SUM(tmpCC.total) sumaCanC, COUNT(*) totalCanC, '1' opt, $comodin userID, tmpCC.nombreUsuario, tmpCC.id_rol, tmpCC.id_sede, tmpCC.sedeNombre ,STRING_AGG(CAST(tmpCC.idLote AS VARCHAR(MAX)), ',')id_array

                FROM (
                    --CANCELADAS CONTRATADAS
                    SELECT 
                    ISNULL(u.id_rol, 0) id_rol, lo.idLote, lo.nombreLote, cl.id_asesor, cl.id_coordinador, 
                    cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, 
                    $nombreUsuario,
                    COALESCE(sede.nombre, 'SIN ESPECIFICAR') sedeNombre, COALESCE(sede.id_sede, 0) id_sede,
                    $total
                    FROM clientes cl
                    INNER JOIN lotes lo ON lo.idLote = cl.idLote
                    INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                    LEFT JOIN sedes sede ON sede.id_sede = cl.id_sede
                    LEFT JOIN ventas_compartidas vc ON vc.id_cliente = cl.id_cliente and vc.estatus = 1
                    left join (select count(vc.id_cliente) cuenta, cl.id_cliente from clientes cl
                        inner join
                        ventas_compartidas vc on vc.id_cliente = cl.id_cliente  and vc.estatus = 1
                        group by cl.id_cliente, vc.id_cliente
                    ) vc2 on vc2.id_cliente = cl.id_cliente
                    $comodin2 JOIN usuarios u ON u.id_usuario = cl.$comodin
                    INNER JOIN deposito_seriedad ds ON ds.id_cliente = cl.id_cliente
                    LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.idLote = lo.idLote AND hl.id_cliente = cl.id_cliente
                    INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 9 AND idMovimiento = 39 AND status = 0
                    GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
                    $filtroSt
                    WHERE (cl.cancelacion_proceso != 2 OR (isNULL(noRecibo, '') != 'CANCELADO'  AND ISNULL(lo.tipo_venta, 0) IN (0, 1, 2) AND cl.status = 0 AND cl.id_asesor NOT IN (2541, 2562, 2583, 2551, 2572, 2593, 2591, 2570, 2549, 12845) AND cl.id_gerente NOT IN (6739)))
                    $filtro $filtroExt
                    $canConList
                    GROUP BY u. id_rol, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), lo.idLote, lo.nombreLote, cl.id_asesor, 
                    cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
                     vc.id_cliente, sede.id_sede, sede.nombre, vc.id_asesor , vc.id_coordinador, vc.id_gerente, vc.id_subdirector, vc.id_regional, vc.id_regional_2
                )tmpCC GROUP BY $comodin, tmpCC.nombreUsuario, tmpCC.id_rol, tmpCC.id_sede, tmpCC.sedeNombre
            ) cancontratadas ON cancontratadas.userID = general.userID and cancontratadas.id_sede = general.id_sede AND cancontratadas.nombreUsuario = general.nombreUsuario
            LEFT JOIN(
                SELECT SUM(tmpCA.total) sumaCanA, COUNT(*) totalCanA, '1' opt, $comodin userID, tmpCA.nombreUsuario, tmpCA.id_rol, tmpCA.id_sede, tmpCA.sedeNombre,STRING_AGG(CAST(tmpCA.idLote AS VARCHAR(MAX)), ',')id_array
                FROM (
                    --CANCELADAS APARTADAS
                    SELECT --CASE WHEN CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) = '  ' THEN 'ACUMULADO SIN ESPECIFICAR' ELSE CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) END nombreUsuario,
                    ISNULL(u.id_rol, 0) id_rol, lo.idLote, lo.nombreLote, 
                    cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, 
                    CONVERT(VARCHAR, cl.fechaApartado, 103) fechaApartado ,
                    $nombreUsuario
                    ,COALESCE(sede.nombre, 'SIN ESPECIFICAR') sedeNombre, COALESCE(sede.id_sede, 0) id_sede,
                    $total
                    FROM clientes cl
                    INNER JOIN lotes lo ON lo.idLote = cl.idLote
                    INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                    LEFT JOIN sedes sede ON sede.id_sede = cl.id_sede
                    LEFT JOIN ventas_compartidas vc ON vc.id_cliente = cl.id_cliente and vc.estatus = 1
                    left join (select count(vc.id_cliente) cuenta, cl.id_cliente from clientes cl
                        inner join
                        ventas_compartidas vc on vc.id_cliente = cl.id_cliente  and vc.estatus = 1
                        group by cl.id_cliente, vc.id_cliente
                    ) vc2 on vc2.id_cliente = cl.id_cliente
                    $comodin2 JOIN usuarios u ON u.id_usuario = cl.$comodin
                    INNER JOIN deposito_seriedad ds ON ds.id_cliente = cl.id_cliente
                    LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
                    INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
                    INNER JOIN historial_lotes hlo2 ON hlo2.idLote = hlo.idLote AND hlo2.idCliente = hlo.idCliente AND hlo2.modificado = hlo.modificado AND (hlo2.idStatusContratacion < 9 OR hlo2.idStatusContratacion = 11)
                    $filtroSt
                    LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = hl.tipo AND oxc.id_catalogo = 48
                    WHERE (cl.cancelacion_proceso != 2 OR (isNULL(noRecibo, '') != 'CANCELADO'  AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 0 AND cl.id_asesor NOT IN (2541, 2562, 2583, 2551, 2572, 2593, 2591, 2570, 2549, 12845) AND cl.id_gerente NOT IN (6739)))
                    $filtro $filtroExt
                    $canAptList
                    GROUP BY u.id_rol, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), lo.idLote, lo.nombreLote, cl.id_asesor, 
                    cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, 
                    CONVERT(VARCHAR, cl.fechaApartado, 103),sede.id_sede, sede.nombre, vc.id_cliente, vc.id_asesor , vc.id_coordinador, vc.id_gerente, vc.id_subdirector, vc.id_regional, vc.id_regional_2
                ) tmpCA GROUP BY $comodin, tmpCA.nombreUsuario, tmpCA.id_rol, tmpCA.id_sede, tmpCA.sedeNombre
            ) canapartadas ON canapartadas.userID = general.userID and canapartadas.id_sede = general.id_sede AND canapartadas.nombreUsuario = general.nombreUsuario
            WHERE COALESCE(apartadas.nombreUsuario, contratadas.nombreUsuario, canapartadas.nombreUsuario, cancontratadas.nombreUsuario) IS NOT NULL
            GROUP BY contratadas.sumaConT, apartadas.sumaAT, cancontratadas.sumaCanC, canapartadas.sumaCanA, contratadas.totalConT, apartadas.totalAT, cancontratadas.totalCanC, canapartadas.totalCanA,
            apartadas.nombreUsuario, contratadas.nombreUsuario, general.userID, canapartadas.nombreUsuario, cancontratadas.nombreUsuario, apartadas.sedeNombre, contratadas.sedeNombre, 
            apartadas.id_array, contratadas.id_array, canapartadas.id_array, cancontratadas.id_array
            ORDER BY apartadas.nombreUsuario
        ");
        return $query;
    }

    public function validateRegional($id){
        $data = $this->db->query("SELECT * FROM roles_x_usuario WHERE idUsuario = $id and idRol IN (59,60)");
        return $data->result_array();    
    }

    public function getDetails($beginDate, $endDate, $typeSale, $typeLote, $typeConstruccion, $estatusContratacion, $id_rol, $id_usuario, $render, $leader, $leadersList, $sede, $generalArr, $aptArr, $contArr, $canaparArr, $canconArr) {
        $id_lider = $this->session->userdata('id_lider'); // PARA ASISTENTES
        $comodin2 = 'LEFT';
        $filtroExt = '';
        $filtroSt = '';
        $filtroSede = array();
        $join = '';
        $total = '';
        $loteFiltro = '';
        $aptList = '';
        $conList = '';
        $canConList = '';
        $canAptList = '';
        $nombreUsuario ="";
        $precioDescuento = "";
        $total = "";
        $enganche = $this->getValorEnganche(); // REGRESA CASE CON EL VALOR DEL ENGANCHE
        $filtro=" AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000'";
        /* $typeSale "1": CON ENGANCHE | $typeSale "2": SIN ENGANCHE | $typeSale "3": AMBAS */
        if( $typeSale == "1" )
            $filtro .= " AND $enganche >= 10000";
        elseif( $typeSale == "2" )
            $filtro .= " AND $enganche < 10000";
        
        /* $typeLote "0": Lotes habitacionales | "1": lotes comerciales | "3": AMBAS */
        if( $typeLote != "3" )
            $filtroExt .= ' AND cn.tipo_lote = ' . $typeLote;
        
        /* $typeConstruccion "0": Sin casa | "1": Con casa */
        if( $typeConstruccion != "3" )
            $filtroExt .= ' AND lo.casa = ' . $typeConstruccion;

        if( $estatusContratacion != null )
            $filtroSt .= 'INNER JOIN (SELECT idLote, idCliente, MAX(idStatusContratacion) statusContratacion FROM historial_lotes GROUP BY idLote, idCliente) hlo3 ON hlo3.idLote = lo.idLote AND hlo3.idCliente = cl.id_cliente AND hlo3.statusContratacion = ' . $estatusContratacion;
        
        list($filtro, $comodin, $comodin2) = $this->setFilters($id_rol, $render, $filtro, $leadersList, $comodin2, $id_usuario, $id_lider, null, $leader);
        list($nombreUsuario, $total, $precioDescuento) = $this->amountShare($id_rol);
        
        $idList = $generalArr == [0,0,0,0] ? '0' : '(' . implode(',', $generalArr) . ')';
        $loteFiltro .= $idList == "0" ? '' : ' and lo.idLote IN ' . $idList;

        $aptId = $aptArr == "0" ? ['0'] : '(' . implode(',', $aptArr) . ')';
        $aptList .= $aptId == '0' ? '': 'and lo.idLote in'.$aptId;
        
        $contId = $contArr == "0" ? ['0'] : '(' . implode(',', $contArr) . ')';
        $conList .= $contId == '0' ? '': 'and lo.idLote in'.$contId;

        $canaptId = $canaparArr == "0" ? ['0'] : '(' . implode(',', $canaparArr) . ')';
        $canAptList .= $canaptId == '0' ? '': 'and lo.idLote in'.$canaptId;

        $cacontId = $canconArr == "0" ? ['0'] : '(' . implode(',', $canconArr) . ')';
        $canConList .= $cacontId == '0' ? '': 'and lo.idLote in'.$cacontId;


        $query = $this->db->query("SELECT
        FORMAT(ISNULL(contratadas.sumaConT, 0), 'C') sumaConT, ISNULL(contratadas.totalConT, 0) totalConT, --VENDIDO CONTRATADO
        FORMAT(ISNULL(apartadas.sumaAT, 0), 'C') sumaAT, ISNULL(apartadas.totalAT, 0) totalAT, --VENDIDO APARTADO
        FORMAT(ISNULL(cancontratadas.sumaCanC, 0), 'C') sumaCanC, ISNULL(cancontratadas.totalCanC, 0) totalCanC, --CANCELADOS CONTRATADOS
        FORMAT(ISNULL(canapartadas.sumaCanA, 0), 'C') sumaCanA, ISNULL(canapartadas.totalCanA, 0) totalCanA, --CANCELADOS APARTADOS
        FORMAT((ISNULL(apartadas.sumaAT, 0) + ISNULL(contratadas.sumaConT, 0)), 'C') gran_total,
        --PORCENTAJES
        ISNULL( CAST( ( (ISNULL(contratadas.totalConT, 0) + ISNULL(apartadas.totalAT, 0) ) * 100) /  NULLIF(ISNULL(contratadas.totalConT, 0) + ISNULL(apartadas.totalAT, 0), 0) AS decimal(16,2)), 0) porcentajeTotal,
        ISNULL( CAST( ( (ISNULL(canapartadas.totalCanA, 0) + ISNULL(cancontratadas.totalCanC, 0) ) * 100) /  NULLIF(ISNULL(contratadas.totalConT, 0) + ISNULL(apartadas.totalAT, 0), 0) AS decimal(16,2)), 0) porcentajeTotalC,
        ISNULL( CAST( (contratadas.totalConT * 100) /  NULLIF(ISNULL(contratadas.totalConT, 0) + ISNULL(apartadas.totalAT, 0), 0) AS decimal(16,2)), 0) porcentajeTotalCont,
        ISNULL( CAST( (apartadas.totalAT * 100) /  NULLIF(ISNULL(contratadas.totalConT, 0) + ISNULL(apartadas.totalAT, 0), 0) AS decimal(16,2)), 0) porcentajeTotalAp,
        ISNULL( CAST( (cancontratadas.totalCanC * 100) /  NULLIF(ISNULL(contratadas.totalConT, 0) + ISNULL(apartadas.totalAT, 0), 0) AS decimal(16,2)), 0) porcentajeTotalCanC,
        ISNULL( CAST( (canapartadas.totalCanA * 100) /  NULLIF(ISNULL(contratadas.totalConT, 0) + ISNULL(apartadas.totalAT, 0), 0) AS decimal(16,2)), 0) porcentajeTotalCanA,
        ISNULL(ISNULL(ISNULL (apartadas.nombreUsuario, contratadas.nombreUsuario), canapartadas.nombreUsuario), cancontratadas.nombreUsuario) nombreUsuario,
        CASE WHEN contratadas.sede IS NULL AND apartadas.sede IS NULL THEN 'SIN ESPECIFICAR' ELSE ISNULL(UPPER(contratadas.sede), UPPER(apartadas.sede)) END AS sede,
        COALESCE(apartadas.id_array, '0') AS apt_arr,COALESCE(contratadas.id_array, '0') AS cont_arr,COALESCE(cancontratadas.id_array, '0') AS cancon_arr,COALESCE(canapartadas.id_array, '0') AS canapar_arr

        FROM(
            -- GENERAL
            SELECT SUM(tmpConT.total) sumaConT, COUNT(*) totalConT, '1' opt, tmpConT.sede, tmpConT.id_sede, tmpConT.nombreUsuario
             ,$comodin userID
            FROM(
                SELECT 
                $nombreUsuario,
                lo.idLote, lo.nombreLote, 
                cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, 
                ISNULL(cl.totalNeto2_cl ,lo.totalNeto2) totalNeto2, ISNULL(cl.total_cl ,lo.total) totalLista,
                SUM(CASE WHEN (lo.totalNeto2 IS NULL OR lo.totalNeto2 = 0.00) THEN ISNULL(TRY_CAST(ds.costom2f AS DECIMAL(16, 2)) * lo.sup, lo.precio * lo.sup) ELSE lo.totalNeto2 END) total
                ,COALESCE(ss.nombre, 'SIN ESPECIFICAR') sede, COALESCE(ss.id_sede, 0) id_sede
                
                FROM clientes cl
                INNER JOIN lotes lo ON lo.idLote = cl.idLote
                $comodin2 JOIN usuarios u ON u.id_usuario = cl.$comodin
                INNER JOIN deposito_seriedad ds ON ds.id_cliente = cl.id_cliente
                INNER JOIN condominios cn ON cn.idCondominio = lo.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
                --LEFT JOIN sedes ss ON ss.id_sede = r.sede_residencial
                LEFT JOIN ventas_compartidas vc ON vc.id_cliente = cl.id_cliente AND vc.estatus = 1
                LEFT JOIN sedes ss ON ss.id_sede = cl.id_sede
                WHERE isNULL(noRecibo, '') != 'CANCELADO'  AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.id_asesor NOT IN (2541, 2562, 2583, 2551, 2572, 2593, 2591, 2570, 2549, 12845) AND cl.id_gerente NOT IN (6739)
                $filtro
                $loteFiltro
                GROUP BY ss.nombre, ss.id_sede,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), lo.idLote, lo.nombreLote, cl.id_asesor, 
                cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, 
                isNULL(cl.totalNeto2_cl ,lo.totalNeto2), isNULL(cl.total_cl ,lo.total), vc.id_cliente, cl.id_cliente,
                vc.id_asesor , vc.id_coordinador, vc.id_gerente, vc.id_subdirector, vc.id_regional, vc.id_regional_2
            ) tmpConT GROUP BY $comodin, tmpConT.sede, tmpConT.id_sede, tmpConT.nombreUsuario
        ) general
        LEFT JOIN(
            SELECT SUM(tmpConT.total) sumaConT, COUNT(*) totalConT, tmpConT.nombreUsuario, $comodin userID,STRING_AGG(CAST(tmpConT.idLote AS VARCHAR(MAX)),',')id_array,
            '1' opt, tmpConT.sede, tmpConT.id_sede
			FROM(
                SELECT 
                lo.idLote, lo.nombreLote, 
                cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, 
                ISNULL(cl.totalNeto2_cl ,lo.totalNeto2) totalNeto2, ISNULL(cl.total_cl ,lo.total) totalLista,
                $nombreUsuario,
                $total,
                COALESCE(ss.nombre, 'SIN ESPECIFICAR') sede, COALESCE(ss.id_sede, 0) id_sede
                FROM clientes cl
                INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote IN (2, 3) AND ( lo.totalNeto2 IS NOT NULL AND lo.totalNeto2 != 0.00 )
                $comodin2 JOIN usuarios u ON u.id_usuario = cl.$comodin
                INNER JOIN deposito_seriedad ds ON ds.id_cliente = cl.id_cliente
                INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 9 AND idMovimiento = 39
                $filtroSt
                GROUP BY idLote, idCliente) hl ON hl.idLote = lo.idLote AND hl.idCliente = cl.id_cliente
                INNER JOIN condominios cn ON cn.idCondominio = lo.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
                LEFT JOIN sedes ss ON ss.id_sede = cl.id_sede
                LEFT JOIN ventas_compartidas vc ON vc.id_cliente = cl.id_cliente AND vc.estatus = 1
                left join (select count(vc.id_cliente) cuenta, cl.id_cliente from clientes cl
                        inner join
                        ventas_compartidas vc on vc.id_cliente = cl.id_cliente  and vc.estatus = 1
                        group by cl.id_cliente, vc.id_cliente
                ) vc2 on vc2.id_cliente = cl.id_cliente
                WHERE cl.cancelacion_proceso = 2 AND isNULL(noRecibo, '') != 'CANCELADO'  AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 1 AND cl.id_asesor NOT IN (2541, 2562, 2583, 2551, 2572, 2593, 2591, 2570, 2549, 12845) AND cl.id_gerente NOT IN (6739)
                $filtro
                $conList
                GROUP BY ss.nombre, ss.id_sede,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), lo.idLote, lo.nombreLote, cl.id_asesor, 
                cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, 
                isNULL(cl.totalNeto2_cl ,lo.totalNeto2), isNULL(cl.total_cl ,lo.total),vc.id_cliente, cl.id_cliente,
                vc.id_asesor , vc.id_coordinador, vc.id_gerente, vc.id_subdirector, vc.id_regional, vc.id_regional_2
            ) tmpConT GROUP BY $comodin, tmpConT.sede, tmpConT.id_sede, tmpConT.nombreUsuario
        ) contratadas on contratadas.id_sede = general.id_sede AND contratadas.userID = general.userID AND contratadas.nombreUsuario = general.nombreUsuario
        LEFT JOIN (
            SELECT SUM(tmpApT.total) sumaAT,
            COUNT(*) totalAT, tmpApT.nombreUsuario, $comodin userID,STRING_AGG(CAST(tmpApT.idLote AS VARCHAR(MAX)),',')id_array,
            '1' opt, tmpApT.sede, tmpApT.id_sede
            FROM (
                --VENTAS APARTADAS
                SELECT  
                lo.idLote, lo.nombreLote, 
                cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, 
                isNULL(cl.totalNeto2_cl ,lo.totalNeto2) totalNeto2, isNULL(cl.total_cl ,lo.total) totalLista,
                $nombreUsuario,
                $total,
                COALESCE(ss.nombre, 'SIN ESPECIFICAR') sede, COALESCE(ss.id_sede, 0) id_sede
                FROM clientes cl
                INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote = 3 AND (lo.idStatusContratacion < 9 OR lo.idStatusContratacion = 11) AND (lo.totalNeto2 IS NULL OR lo.totalNeto2 = 0.00)
                $comodin2 JOIN usuarios u ON u.id_usuario = cl.$comodin
                INNER JOIN deposito_seriedad ds ON ds.id_cliente = cl.id_cliente
                INNER JOIN condominios cn ON cn.idCondominio = lo.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
                LEFT JOIN sedes ss ON ss.id_sede = cl.id_sede
                LEFT JOIN ventas_compartidas vc ON vc.id_cliente = cl.id_cliente AND vc.estatus = 1
                left join (select count(vc.id_cliente) cuenta, cl.id_cliente from clientes cl
                        inner join
                        ventas_compartidas vc on vc.id_cliente = cl.id_cliente  and vc.estatus = 1
                        group by cl.id_cliente, vc.id_cliente
                ) vc2 on vc2.id_cliente = cl.id_cliente
                $filtroSt
                WHERE cl.cancelacion_proceso = 2 AND isNULL(noRecibo, '') != 'CANCELADO'  AND ISNULL(lo.tipo_venta, 0) IN (0, 1, 2) AND cl.status = 1 AND cl.id_asesor NOT IN (2541, 2562, 2583, 2551, 2572, 2593, 2591, 2570, 2549, 12845) AND cl.id_gerente NOT IN (6739)
                $filtro
                $aptList
                GROUP BY ss.nombre, ss.id_sede, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), lo.idLote, lo.nombreLote, cl.id_asesor, 
                cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, 
                isNULL(cl.totalNeto2_cl ,lo.totalNeto2), isNULL(cl.total_cl ,lo.total),vc.id_cliente, cl.id_cliente,
                vc.id_asesor , vc.id_coordinador, vc.id_gerente, vc.id_subdirector, vc.id_regional, vc.id_regional_2
            ) tmpApT GROUP BY $comodin, tmpApT.sede, tmpApT.id_sede, tmpApT.nombreUsuario
        ) apartadas ON apartadas.id_sede = general.id_sede AND apartadas.userID = general.userID AND apartadas.nombreUsuario = general.nombreUsuario
        LEFT JOIN(
            SELECT SUM(tmpCC.total) sumaCanC, COUNT(*) totalCanC, 
            tmpCC.nombreUsuario,  $comodin userID,'1' opt, tmpCC.sede, tmpCC.id_sede,
            STRING_AGG(CAST(tmpCC.idLote AS VARCHAR(MAX)),',')id_array
            FROM (
                --CANCELADOS CONTRATADOS
                SELECT 
                lo.idLote, lo.nombreLote, 
                cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, 
                isNULL(cl.totalNeto2_cl ,lo.totalNeto2) totalNeto2, isNULL(cl.total_cl ,lo.total) totalLista, CONVERT(VARCHAR, cl.fechaApartado, 103) fechaApartado,
                $nombreUsuario,
                $total,
                COALESCE(ss.nombre, 'SIN ESPECIFICAR') sede, COALESCE(ss.id_sede, 0) id_sede
                FROM clientes cl
                INNER JOIN lotes lo ON lo.idLote = cl.idLote
                $comodin2 JOIN usuarios u ON u.id_usuario = cl.$comodin
                INNER JOIN deposito_seriedad ds ON ds.id_cliente = cl.id_cliente
                LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
                INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 9 AND idMovimiento = 39 AND status = 0
                GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
                $filtroSt
                INNER JOIN condominios cn ON cn.idCondominio = lo.idCondominio 
                INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
                LEFT JOIN ventas_compartidas vc ON vc.id_cliente = cl.id_cliente AND vc.estatus = 1
                left join (select count(vc.id_cliente) cuenta, cl.id_cliente from clientes cl
                        inner join
                        ventas_compartidas vc on vc.id_cliente = cl.id_cliente  and vc.estatus = 1
                        group by cl.id_cliente, vc.id_cliente
                ) vc2 on vc2.id_cliente = cl.id_cliente
                LEFT JOIN sedes ss ON ss.id_sede = cl.id_sede
                WHERE (cl.cancelacion_proceso != 2 OR (isNULL(noRecibo, '') != 'CANCELADO'  AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 0 AND cl.id_asesor NOT IN (2541, 2562, 2583, 2551, 2572, 2593, 2591, 2570, 2549, 12874) AND cl.id_gerente NOT IN (6739))) 
                $filtro
                $filtroExt
                $canConList
                GROUP BY ss.nombre, ss.id_sede,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno),lo.idLote, lo.nombreLote, 
                cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, 
                isNULL(cl.totalNeto2_cl ,lo.totalNeto2), isNULL(cl.total_cl ,lo.total), CONVERT(VARCHAR, cl.fechaApartado, 103),vc.id_cliente, cl.id_cliente,
                vc.id_asesor , vc.id_coordinador, vc.id_gerente, vc.id_subdirector, vc.id_regional, vc.id_regional_2
            ) tmpCC GROUP BY $comodin, tmpCC.sede, tmpCC.id_sede, tmpCC.nombreUsuario
        ) cancontratadas ON cancontratadas.id_sede = general.id_sede AND cancontratadas.userID = general.userID AND cancontratadas.nombreUsuario = general.nombreUsuario
        LEFT JOIN(
            SELECT SUM(tmpCA.total) sumaCanA,COUNT(*) totalCanA,
            $comodin userID, tmpCA.nombreUsuario,'1' opt, tmpCA.sede, tmpCA.id_sede,
            STRING_AGG(CAST(tmpCA.idLote AS VARCHAR(MAX)), ',')id_array
            FROM(
                --CANCELADOS APARTADOS
                SELECT  
                lo.idLote, lo.nombreLote, 
                cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, 
                isNULL(cl.totalNeto2_cl ,lo.totalNeto2) totalNeto2, isNULL(cl.total_cl ,lo.total) totalLista, CONVERT(VARCHAR, cl.fechaApartado, 103) fechaApartado,
                $nombreUsuario,
                $total,COALESCE(ss.nombre, 'SIN ESPECIFICAR') sede, COALESCE(ss.id_sede, 0) id_sede
                FROM clientes cl
                INNER JOIN lotes lo ON lo.idLote = cl.idLote
                $comodin2 JOIN usuarios u ON u.id_usuario = cl.$comodin
                INNER JOIN deposito_seriedad ds ON ds.id_cliente = cl.id_cliente
                LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
                INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
                INNER JOIN historial_lotes hlo2 ON hlo2.idLote = hlo.idLote AND hlo2.idCliente = hlo.idCliente AND hlo2.modificado = hlo.modificado
                LEFT JOIN ventas_compartidas vc ON vc.id_cliente = cl.id_cliente AND vc.estatus = 1
                left join (select count(vc.id_cliente) cuenta, cl.id_cliente from clientes cl
                        inner join
                        ventas_compartidas vc on vc.id_cliente = cl.id_cliente  and vc.estatus = 1
                        group by cl.id_cliente, vc.id_cliente
                ) vc2 on vc2.id_cliente = cl.id_cliente
                $filtroSt
                INNER JOIN condominios cn ON cn.idCondominio = lo.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
                LEFT JOIN sedes ss ON ss.id_sede = cl.id_sede
                WHERE (cl.cancelacion_proceso != 2 OR (isNULL(noRecibo, '') != 'CANCELADO'  AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 0 AND cl.id_asesor NOT IN (2541, 2562, 2583, 2551, 2572, 2593, 2591, 2570, 2549, 12874) AND cl.id_gerente NOT IN (6739)))
                $filtro
                $filtroExt
                $canAptList
                AND (hlo2.idStatusContratacion < 9 OR hlo2.idStatusContratacion = 11)
                GROUP BY ss.nombre, ss.id_sede,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno),lo.idLote, lo.nombreLote, 
                cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, 
                isNULL(cl.totalNeto2_cl ,lo.totalNeto2), isNULL(cl.total_cl ,lo.total), CONVERT(VARCHAR, cl.fechaApartado, 103),vc.id_cliente, cl.id_cliente,
                vc.id_asesor , vc.id_coordinador, vc.id_gerente, vc.id_subdirector, vc.id_regional, vc.id_regional_2
            ) tmpCA GROUP BY $comodin, tmpCA.sede, tmpCA.id_sede, tmpCA.nombreUsuario
        ) canapartadas ON canapartadas.id_sede = general.id_sede  AND canapartadas.userID = general.userID  AND canapartadas.nombreUsuario = general.nombreUsuario
        WHERE COALESCE(apartadas.nombreUsuario, contratadas.nombreUsuario, canapartadas.nombreUsuario, cancontratadas.nombreUsuario) IS NOT NULL
        
        GROUP BY contratadas.sumaConT, apartadas.sumaAT, cancontratadas.sumaCanC, canapartadas.sumaCanA, contratadas.totalConT, apartadas.totalAT, 
        cancontratadas.totalCanC, canapartadas.totalCanA, apartadas.id_sede, apartadas.sede, contratadas.id_sede, contratadas.sede, canapartadas.id_sede, cancontratadas.id_sede
        ,apartadas.nombreUsuario, contratadas.nombreUsuario, canapartadas.nombreUsuario, cancontratadas.nombreUsuario,apartadas.id_array,  contratadas.id_array, cancontratadas.id_array, canapartadas.id_array
        ");
        
        return $query;
    }
    public function getGeneralLotesInformation($beginDate, $endDate, $typeSale, $typeLote, $typeConstruccion, $estatusContratacion, $id_rol, $id_usuario, $render, $type, $sede, $idArr,$leader, $leadersList) {
        
        $filtroExt = '';
        $filtroSt = '';
        $loteFiltro = '';
        // PARA ASESOR, COORDINADOR, GERENTE, SUBDIRECTOR, REGIONAL Y DIRECCIÓN COMERCIAL
        $id_lider = $this->session->userdata('id_lider'); // PARA ASISTENTES
        $comodin2 = 'LEFT';
        /* Filtros de búsqueda */
        $filtro=" AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000'";
        /* $typeSale "1": CON ENGANCHE | $typeSale "2": SIN ENGANCHE | $typeSale "3": AMBAS */
        $enganche = $this->getValorEnganche(); // REGRESA CASE CON EL VALOR DEL ENGANCHE
        $precioDescuento = "";
        $nombreUsuario = "";
        $total = "";
        if( $typeSale == "1" )
            $filtro .= " AND $enganche >= 10000";
        elseif( $typeSale == "2" )
            $filtroExt .= " AND $enganche < 10000";
        
        /* $typeLote "0": Lotes habitacionales | "1": lotes comerciales | "3": 1AMBAS */
        if( $typeLote != "3" )
            $filtroExt .= ' AND co.tipo_lote = ' . $typeLote;
        
        /* $typeConstruccion "0": Sin casa | "1": Con casa */
        if( $typeConstruccion != "3" )
            $filtro .= ' AND lo.casa = ' . $typeConstruccion;
        /* Filtros de búsqueda */
        
        if( $estatusContratacion != null )
            $filtroSt = 'INNER JOIN (SELECT idLote, idCliente, MAX(idStatusContratacion) statusContratacion FROM historial_lotes GROUP BY idLote, idCliente) hlo3 ON hlo3.idLote = lo.idLote AND hlo3.idCliente = cl.id_cliente AND hlo3.statusContratacion = ' . $estatusContratacion;
        
        $joinHist = "";
        list($filtro, $comodin, $comodin2) = $this->setFilters($id_rol, $render, $filtro, $leadersList, $comodin2, $id_usuario, $id_lider, null, $leader);
        list($nombreUsuario, $total, $precioDescuento) = $this->amountShare($id_rol);

        $idList = $idArr == ("0,0,0,0") ? ['0'] : '('.implode(',', $idArr). ')';
        $loteFiltro .= $idList == "0" ? '' : ' and lo.idLote IN ' . $idList;
      
       
        
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
                $statusLote = "= 3 AND (lo.idStatusContratacion < 9 OR lo.idStatusContratacion = 11)";
            else if($type == 2 || $type == 22) {// MJ: CONTRATADOS
                $statusLote = "IN (2, 3, 9) /*AND (lo.totalNeto2 IS NOT NULL AND lo.totalNeto2 != 0.00)*/";
                $joinHist = "INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 9 AND idMovimiento = 39 GROUP BY idLote, idCliente) hl ON hl.idLote = lo.idLote AND hl.idCliente = cl.id_cliente";
            }
            else // MJ: APARTADOS / CONTRATADOS
                $statusLote = "IN (2, 3)";
            $filtroSede = ($type == 11 || $type == 22 || $type == 55) ? "AND re.sede_residencial = $sede" : "";
            $query = $this->db->query("    
            SELECT  UPPER(CAST(re.descripcion AS VARCHAR(150))) nombreResidencial, UPPER(co.nombre) nombreCondominio, UPPER(lo.nombreLote) nombreLote, 
            UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente,
            UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) nombreAsesor,
            CASE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) WHEN '  ' THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) END nombreCoordinador,
            CASE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) WHEN '  ' THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) END nombreGerente,
            CASE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) WHEN '  ' THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) END nombreSubdirector,
            CASE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) WHEN '  ' THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) END nombreRegional,
            CONVERT(VARCHAR, cl.fechaApartado, 103) fechaApartado, CONVERT(VARCHAR, hl3.fechaUltimoStatus, 103) fechaUltimoStatus, CONVERT(VARCHAR, hl2.fechaStatus9, 103) fechaStatus9, UPPER(sc.nombreStatus) AS nombreStatus, UPPER(st.nombre) AS estatusLote,
            FORMAT(ISNULL(lo.sup * lo.precio, '0.00'), 'C') precioLista, 
			CASE WHEN(lo.casa = '0') THEN 'SIN CASA' ELSE 'CON CASA' END casa, DATEDIFF(day, cl.fechaApartado, GETDATE()) AS diasApartado, cl.apartadoXReubicacion, 
            lo.sup, 
            CASE WHEN MAX(vc.id_vcompartida) IS NULL THEN 'NORMAL' ELSE 'COMPARTIDA' END modalidad,
            $precioDescuento
            
            FROM clientes cl
            INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idCliente = cl.id_cliente AND lo.idStatusLote $statusLote
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial --$filtroSede
            INNER JOIN statusContratacion sc ON sc.idStatusContratacion = lo.idStatusContratacion
            INNER JOIN statusLote st ON st.idStatusLote = lo.idStatusLote
            INNER JOIN deposito_seriedad ds ON ds.id_cliente = cl.id_cliente
            $joinHist
            $filtroSt
            $comodin2 JOIN usuarios us ON us.id_usuario = cl.$comodin
            LEFT JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
            LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
            LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
            LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
            LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
            LEFT JOIN ventas_compartidas vc ON vc.id_cliente = cl.id_cliente AND vc.estatus = 1 
            left join (select count(vc.id_cliente) cuenta, cl.id_cliente from clientes cl
                        inner join
                        ventas_compartidas vc on vc.id_cliente = cl.id_cliente  and vc.estatus = 1
                        group by cl.id_cliente, vc.id_cliente
            ) vc2 on vc2.id_cliente = cl.id_cliente
            LEFT JOIN sedes sede ON sede.id_sede = cl.id_sede
            
            LEFT JOIN (SELECT idLote, idCliente, MAX(modificado) fechaStatus9 FROM historial_lotes WHERE idStatusContratacion = 9 AND idMovimiento = 39 GROUP BY idLote, idCliente) hl2 ON hl2.idLote = lo.idLote AND hl2.idCliente = cl.id_cliente
			LEFT JOIN (SELECT idLote, idCliente, MAX(modificado) fechaUltimoStatus FROM historial_lotes GROUP BY idLote, idCliente) hl3 ON hl3.idLote = lo.idLote AND hl3.idCliente = cl.id_cliente
            LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.venta_extranjero AND oxc0.id_catalogo = 116
            WHERE cl.cancelacion_proceso = 2 AND isNULL(noRecibo, '') != 'CANCELADO' AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 1 AND cl.id_asesor NOT IN (2541, 2562, 2583, 2551, 2572, 2593, 2591, 2570, 2549, 12874) AND cl.id_gerente NOT IN (6739)
            $filtro 
            $filtroExt
            $loteFiltro
            GROUP BY
            CAST(re.descripcion AS VARCHAR(150)), UPPER(co.nombre), UPPER(lo.nombreLote), 
            UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)),
            UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)),
            UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)),
            UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)),
            UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)),
            UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)),
            CONVERT(VARCHAR, cl.fechaApartado, 103), sc.nombreStatus, st.nombre, lo.total, lo.totalNeto2, lo.casa, 
            cl.fechaApartado, cl.fechaAlta, cl.apartadoXReubicacion, cl.fechaApartado, hl2.fechaStatus9, hl3.fechaUltimoStatus,
            lo.sup, lo.precio, oxc0.nombre, vc.id_cliente, vc.id_asesor, vc.id_coordinador, vc.id_subdirector, vc.id_gerente, vc.id_regional, vc.id_regional_2,
            cl.id_asesor, cl.id_coordinador, cl.id_subdirector, cl.id_gerente, cl.id_regional, cl.id_regional_2
            ORDER BY sc.nombreStatus");
        } else if ($type == 3 || $type == 33 || $type == 4 || $type == 44) { // MJ: CANCELADOS CONTRATADOS / APARTADOS
            if ( $type == 4 || $type == 44 ) {
               $statusLote = "AND (hlo2.idStatusContratacion < 9 OR hlo2.idStatusContratacion = 11)";
               $extraValidacion = "";
            }
            else{
                $statusLote = "";
                $extraValidacion = " WHERE idStatusContratacion = 9 AND idMovimiento = 39";
            }
            $filtroSede = ($type == 33 || $type == 44) ? "AND re.sede_residencial = $sede" : "";
           
            $query = $this->db->query("SELECT CAST(re.descripcion AS VARCHAR(150)) nombreResidencial, UPPER(co.nombre) nombreCondominio, UPPER(lo.nombreLote) nombreLote, 
            UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente,
            UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) nombreAsesor,
            CASE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) WHEN '  ' THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) END nombreCoordinador,
            CASE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) WHEN '  ' THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) END nombreGerente,
            CASE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) WHEN '  ' THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) END nombreSubdirector,
            CASE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) WHEN '  ' THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) END nombreRegional,
            CONVERT(VARCHAR, cl.fechaApartado, 103) fechaApartado, CONVERT(VARCHAR, hl3.fechaUltimoStatus, 103) fechaUltimoStatus, CONVERT(VARCHAR, hl2.fechaStatus9, 103) fechaStatus9, st.nombreStatus, 'Cancelado' estatusLote, CONVERT(VARCHAR, hl.modificado, 103) fechaLiberacion, oxc.nombre motivoLiberacion,
            FORMAT(ISNULL(lo.sup * lo.precio, '0.00'), 'C') precioLista,  
			CASE WHEN(lo.casa = '0') THEN 'Sin casa' ELSE 'Con casa' END casa, DATEDIFF(day, cl.fechaApartado, GETDATE()) AS diasApartado, cl.apartadoXReubicacion, 
            lo.sup,
            $precioDescuento,
            CASE WHEN MAX(vc.id_vcompartida) IS NULL THEN 'NORMAL' ELSE 'COMPARTIDA' END modalidad
            FROM clientes cl
            INNER JOIN lotes lo ON lo.idLote = cl.idLote
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial $filtroSede
            INNER JOIN deposito_seriedad ds ON ds.id_cliente = cl.id_cliente
            $comodin2 JOIN usuarios us ON us.id_usuario = cl.$comodin
            LEFT JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
            LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
            LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
            LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
            LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
            LEFT JOIN sedes sede ON sede.id_sede = cl.id_sede
            LEFT JOIN ventas_compartidas vc ON vc.id_cliente = cl.id_cliente AND vc.estatus = 1 
            left join (select count(vc.id_cliente) cuenta, cl.id_cliente from clientes cl
                        inner join
                        ventas_compartidas vc on vc.id_cliente = cl.id_cliente  and vc.estatus = 1
                        group by cl.id_cliente, vc.id_cliente
            ) vc2 on vc2.id_cliente = cl.id_cliente
            
            LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
            LEFT JOIN (SELECT idLote, idCliente, MAX(modificado) fechaStatus9 FROM historial_lotes WHERE idStatusContratacion = 9 AND idMovimiento = 39 GROUP BY idLote, idCliente) hl2 ON hl2.idLote = lo.idLote AND hl2.idCliente = cl.id_cliente
			LEFT JOIN (SELECT idLote, idCliente, MAX(modificado) fechaUltimoStatus FROM historial_lotes GROUP BY idLote, idCliente) hl3 ON hl3.idLote = lo.idLote AND hl3.idCliente = cl.id_cliente
            INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes $extraValidacion GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
			INNER JOIN historial_lotes hlo2 ON hlo2.idLote = hlo.idLote AND hlo2.idCliente = hlo.idCliente AND hlo2.modificado = hlo.modificado
            $filtroSt
			INNER JOIN statuscontratacion st ON st.idStatusContratacion = hlo2.idStatusContratacion
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = hl.tipo AND oxc.id_catalogo = 48
            LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.venta_extranjero AND oxc0.id_catalogo = 116
            WHERE (cl.cancelacion_proceso != 2 OR (isNULL(noRecibo, '') != 'CANCELADO' AND ISNULL(lo.tipo_venta, 0) IN (0, 1, 2) AND cl.status = 0 AND cl.id_asesor NOT IN (2541, 2562, 2583, 2551, 2572, 2593, 2591, 2570, 2549, 12874) AND cl.id_gerente NOT IN (6739)))
            $statusLote
            $filtro
            $loteFiltro
			GROUP BY CAST(re.descripcion AS VARCHAR(150)), UPPER(co.nombre), UPPER(lo.nombreLote), 
            UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)),
            UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)),
            UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)),
            UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)),
            UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)),
            UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)),
            CONVERT(VARCHAR, cl.fechaApartado, 103), st.nombreStatus,
            cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional,
            CONVERT(VARCHAR, hl.modificado, 103), oxc.nombre, lo.total, lo.totalNeto2, lo.casa, cl.fechaApartado, cl.fechaAlta, cl.apartadoXReubicacion, hl2.fechaStatus9, hl3.fechaUltimoStatus,
            lo.sup, lo.precio, oxc0.nombre,
            vc.id_cliente, vc.id_asesor, vc.id_coordinador, vc.id_subdirector, vc.id_gerente, vc.id_regional, vc.id_regional_2,
            cl.id_asesor, cl.id_coordinador, cl.id_subdirector, cl.id_gerente, cl.id_regional, cl.id_regional_2
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
        t.nombreAsesor as nombreAsesor, CONVERT(VARCHAR,t.fechaApartado,20) AS fechaApartado, t.nombreSede as nombreSede, t.tipo_venta as tipo_venta, CONVERT(VARCHAR,t.fechaEstatus9,20) AS fechaEstatus9, t.estatusActual,
        cliente, enganche, estatus, movimiento, colorEstatus, fondoEstatus, ISNULL(numeroVC, 0) numeroVC
        FROM (
            SELECT re.descripcion nombreResidencial, UPPER(co.nombre) nombreCondominio, UPPER(lo.nombreLote) nombreLote,
            lo.idLote, FORMAT(lo.totalNeto2, 'C') precioFinal, lo.referencia, 
            CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) nombreAsesor,
            cl.fechaApartado, se.nombre nombreSede, tv.tipo_venta, st.nombre estatus, hl.modificado fechaEstatus9,
            sc.nombreStatus estatusActual, mo.descripcion movimiento, CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) cliente,
            ISNULL(totalValidado, 0)enganche, st.color colorEstatus, st.background_sl fondoEstatus, vc.numeroVC
            FROM lotes lo
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
            INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.idLote = lo.idLote AND cl.status = 1
            LEFT JOIN (SELECT COUNT(id_vcompartida) as numeroVC, id_cliente FROM ventas_compartidas GROUP BY  id_cliente) vc ON vc.id_cliente = cl.id_cliente
            
            INNER JOIN usuarios us ON us.id_usuario = cl.id_asesor
            INNER JOIN sedes se ON se.id_sede = cl.id_sede
            INNER JOIN tipo_venta tv ON tv.id_tventa = lo.tipo_venta
            INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE status = 1 GROUP BY idLote, idCliente) 
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
            sc.nombreStatus estatusActual, mo.descripcion movimiento, CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) cliente,
            ISNULL(totalValidado, 0)enganche, st.color colorEstatus, st.background_sl fondoEstatus, vc2.numeroVC
            FROM lotes lo
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
            INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.status = 1
            LEFT JOIN (SELECT COUNT(id_vcompartida) as numeroVC, id_cliente FROM ventas_compartidas GROUP BY  id_cliente) vc2 ON vc2.id_cliente = cl.id_cliente

            INNER JOIN ventas_compartidas vc ON vc.id_cliente = cl.id_cliente AND vc.estatus = 1
            INNER JOIN usuarios us ON us.id_usuario = vc.id_asesor
            INNER JOIN sedes se ON se.id_sede = cl.id_sede
            INNER JOIN tipo_venta tv ON tv.id_tventa = lo.tipo_venta
            INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE status = 1 GROUP BY idLote, idCliente) 
            hl ON hl.idLote = lo.idLote AND hl.idCliente = cl.id_cliente 
            INNER JOIN statuslote st ON st.idStatusLote = lo.idStatusLote
            INNER JOIN statuscontratacion sc ON sc.idStatusContratacion = lo.idStatusContratacion
            INNER JOIN movimientos mo ON mo.idMovimiento = lo.idMovimiento
            WHERE lo.idStatusLote IN (2, 3) AND hl.modificado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:59.999'
            UNION ALL

            SELECT CAST(re.descripcion AS VARCHAR(100)) nombreResidencial, UPPER(co.nombre) nombreCondominio, UPPER(lo.nombreLote) nombreLote,
            lo.idLote, '$0.00' precioFinal, lo.referencia, 
            CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) nombreAsesor,
            MAX (cl.fechaApartado) fechaApartado, se.nombre nombreSede, 'Sin especificar' tipo_venta, 'Cancelado' estatus, hl.modificado fechaEstatus9,
            sc.nombreStatus estatusActual, 'NA' movimiento, CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) cliente, 0 enganche,
             '' colorEstatus, '' fondoEstatus, vc.numeroVC
            FROM lotes lo
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
            INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 0
            LEFT JOIN (SELECT COUNT(id_vcompartida) as numeroVC, id_cliente FROM ventas_compartidas GROUP BY  id_cliente) vc ON vc.id_cliente = cl.id_cliente
            
            INNER JOIN usuarios us ON us.id_usuario = cl.id_asesor
            INNER JOIN sedes se ON se.id_sede = cl.id_sede
            INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE status = 0 GROUP BY idLote, idCliente) 
            hl ON hl.idLote = lo.idLote AND hl.idCliente = cl.id_cliente
            INNER JOIN historial_liberacion hi ON hi.idLote = lo.idLote AND hi.modificado >= hl.modificado 
            LEFT JOIN historial_lotes hl2 ON hl2.idLote = hl.idLote AND hl2.idCliente = hl.idCliente AND hl2.modificado = hl.modificado
			INNER JOIN statuscontratacion sc ON sc.idStatusContratacion = hl2.idStatusContratacion
            WHERE hl.modificado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:59.999'
            GROUP BY CAST(re.descripcion AS VARCHAR(100)), UPPER(co.nombre), UPPER(lo.nombreLote),
            lo.idLote, lo.referencia, 
            CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno),
            cl.fechaApartado, se.nombre, hl.modificado, sc.nombreStatus, CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno), numeroVC
            UNION ALL

            SELECT CAST(re.descripcion AS VARCHAR(100)) nombreResidencial, UPPER(co.nombre) nombreCondominio, UPPER(lo.nombreLote) nombreLote,
            lo.idLote, '$0.00' precioFinal, lo.referencia, 
            CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) nombreAsesor,
            MAX (cl.fechaApartado) fechaApartado, se.nombre nombreSede, 'Sin especificar' tipo_venta, 'Cancelado' estatus, hl.modificado fechaEstatus9,
            sc.nombreStatus estatusActual, 'NA' movimiento, CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) cliente, 0 enganche,
            '' colorEstatus, '' fondoEstatus, vc2.numeroVC
            FROM lotes lo
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
            INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 0
            LEFT JOIN (SELECT COUNT(id_vcompartida) as numeroVC, id_cliente FROM ventas_compartidas GROUP BY id_cliente) vc2 ON vc2.id_cliente = cl.id_cliente
            INNER JOIN ventas_compartidas vc ON vc.id_cliente = cl.id_cliente AND vc.estatus = 1
            INNER JOIN usuarios us ON us.id_usuario = vc.id_asesor
            INNER JOIN sedes se ON se.id_sede = cl.id_sede  
            INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE status = 0 GROUP BY idLote, idCliente) 
            hl ON hl.idLote = lo.idLote AND hl.idCliente = cl.id_cliente
            INNER JOIN historial_liberacion hi ON hi.idLote = lo.idLote AND hi.modificado >= hl.modificado
            LEFT JOIN historial_lotes hl2 ON hl2.idLote = hl.idLote AND hl2.idCliente = hl.idCliente AND hl2.modificado = hl.modificado
			INNER JOIN statuscontratacion sc ON sc.idStatusContratacion = hl2.idStatusContratacion
            WHERE hl.modificado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:59.999'
            GROUP BY CAST(re.descripcion AS VARCHAR(100)), UPPER(co.nombre), UPPER(lo.nombreLote),
            lo.idLote, lo.referencia, 
            CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno),
            cl.fechaApartado, se.nombre, hl.modificado, sc.nombreStatus, CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno), numeroVC
        ) t
        ORDER BY t.fechaApartado");
        return $query;
    }

    public function getLotesApartados($beginDate, $endDate){
        $query=$this->db->query("SELECT t.nombreResidencial, t.nombreCondominio, t.nombreLote, t.precioFinal, t.referencia,
        t.nombreAsesor, CONVERT(varchar, t.fechaApartado, 20) fechaApartado, t.nombreSede, t.tipo_venta, 
        CONVERT(varchar, t.fechaEstatus9, 20) fechaEstatus9, t.estatusVenta
        FROM (
        SELECT re.descripcion nombreResidencial, UPPER(co.nombre) nombreCondominio, UPPER(lo.nombreLote) nombreLote,
        lo.idLote, FORMAT(lo.totalNeto2, 'C') precioFinal, lo.referencia, 
        CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) nombreAsesor,
        cl.fechaApartado, se.nombre nombreSede, ISNULL(tv.tipo_venta, 'Sin especificar') tipo_venta, hl.modificado fechaEstatus9, 'Activa' estatusVenta
        FROM lotes lo
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.idLote = lo.idLote AND cl.status = 1
        INNER JOIN usuarios us ON us.id_usuario = cl.id_asesor
        INNER JOIN sedes se ON se.id_sede = cl.id_sede
        LEFT JOIN tipo_venta tv ON tv.id_tventa = lo.tipo_venta
        INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes 
        WHERE idStatusContratacion = 9 AND idMovimiento = 39 AND status = 1 GROUP BY idLote, idCliente) 
        hl ON hl.idLote = lo.idLote AND hl.idCliente = cl.id_cliente
        WHERE cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:59.999'
        UNION ALL
        SELECT re.descripcion nombreResidencial, UPPER(co.nombre) nombreCondominio, UPPER(lo.nombreLote) nombreLote,
        lo.idLote, FORMAT(lo.totalNeto2, 'C') precioFinal, lo.referencia, 
        CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) nombreAsesor,
        cl.fechaApartado, se.nombre nombreSede, ISNULL(tv.tipo_venta, 'Sin especificar') tipo_venta, hl.modificado fechaEstatus9, 'Cancelada' estatusVenta
        FROM lotes lo
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 0
        INNER JOIN usuarios us ON us.id_usuario = cl.id_asesor
        INNER JOIN sedes se ON se.id_sede = cl.id_sede
        LEFT JOIN tipo_venta tv ON tv.id_tventa = lo.tipo_venta
        INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes 
        WHERE idStatusContratacion = 9 AND idMovimiento = 39 AND status = 0 GROUP BY idLote, idCliente) 
        hl ON hl.idLote = lo.idLote AND hl.idCliente = cl.id_cliente
        WHERE cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:59.999') t
        ORDER BY t.fechaApartado");
        return $query;
    }

    public function getLotesXStatus($beginDate, $endDate){
        $query=$this->db->query("SELECT UPPER(CAST(re.descripcion AS VARCHAR(75))) proyecto, co.nombre condominio, lo.idLote, lo.nombreLote, cl.id_cliente, UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente, se.nombre sede, 
        UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) nombreGerente,
        UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) nombreCoordinador,
        UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) nombreAsesor,
        'VENTA ACTIVA' estatus, cl.fechaApartado, sc.nombreStatus estatusContratacion
        FROM lotes lo
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio AND co.status = 1
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial AND re.status = 1
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.idLote = lo.idLote  AND cl.status = 1 
        INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE status = 1 GROUP BY idLote, idCliente) hl ON hl.idLote = lo.idLote AND hl.idCliente = cl.id_cliente
        INNER JOIN historial_lotes hl2 ON hl2.idLote = lo.idLote AND hl2.idCliente = cl.id_cliente AND hl2.modificado = hl.modificado AND hl2.status = 1
        INNER JOIN statuscontratacion sc ON sc.idStatusContratacion = hl2.idStatusContratacion
        INNER JOIN sedes se ON se.id_sede = cl.id_sede
        LEFT JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
        LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
        INNER JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
        WHERE lo.status = 1 AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:59.999'
        UNION ALL
        SELECT UPPER(CAST(re.descripcion AS VARCHAR(75))) proyecto, co.nombre condominio, lo.idLote, lo.nombreLote, cl.id_cliente, UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente, se.nombre sede, 
        UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) nombreGerente,
        UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) nombreCoordinador,
        UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) nombreAsesor,
        'VENTA CANCELADA' estatus, cl.fechaApartado, sc.nombreStatus estatusContratacion
        FROM lotes lo
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio AND co.status = 1
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial AND re.status = 1
        INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 0 AND isNULL(cl.noRecibo, '') != 'CANCELADO'
        INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE status = 0 GROUP BY idLote, idCliente) hl ON hl.idLote = lo.idLote AND hl.idCliente = cl.id_cliente
        INNER JOIN historial_lotes hl2 ON hl2.idLote = lo.idLote AND hl2.idCliente = cl.id_cliente AND hl2.modificado = hl.modificado AND hl2.status = 0
        INNER JOIN statuscontratacion sc ON sc.idStatusContratacion = hl2.idStatusContratacion
        INNER JOIN sedes se ON se.id_sede = cl.id_sede
        LEFT JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
        LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
        INNER JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
        WHERE lo.status = 1 AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:59.999' ORDER BY cl.fechaApartado");
        return $query;
    }
    
    public function getEstatusContratacionList(){
        $query = $this->db->query("SELECT * FROM statuscontratacion WHERE idStatusContratacion NOT IN (8,11)");
        return $query;
    }

    public function getValorEnganche() {
        $enganche = "CASE 
                        WHEN (lo.totalValidado IS NULL OR lo.totalValidado = 0.00) 
                            THEN
                                (CASE
                                    WHEN (lo.totalNeto IS NULL OR lo.totalNeto = 0.00)
                                    THEN (
                                        CASE
                                            WHEN ds.cantidad IS NULL OR ds.cantidad = ''
                                            THEN 0
                                            ELSE TRY_CAST(REPLACE(REPLACE(REPLACE(ds.cantidad, '$', ''), ',', ''), ' ', '')  AS decimal(16,2))
                                        END
                                    )
                                    ELSE
                                    lo.totalNeto
                                    END
                                )
                        ELSE
                            lo.totalValidado 
                        END";
        return $enganche;
    }
    function getLotesContrato($beginDate, $endDate){
        $whereDinamico = '';
        if($beginDate=='' || $endDate==''){
            $whereDinamico = '';
        }else {
            $whereDinamico = " AND cl.fechaApartado BETWEEN '".$beginDate." 00:00:00.000' AND '".$endDate." 23:59:59.99'";
        }
        $query = $this->db->query("SELECT 
        r.nombreResidencial as proyecto, l.nombreLote, l.referencia,
        CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno) AS nombreCliente, cl.id_cliente,
        CONCAT(asesor.nombre,' ', asesor.apellido_paterno,' ', asesor.apellido_materno) AS nombreAsesor,
        ISNULL(sedes.nombre,'NA') AS nombreSede, 
        ISNULL(sedes.id_sede, 0) AS id_sede, 
        ISNULL(sedes.abreviacion,'NA') AS abreviacion, 
        cl.fechaApartado, 
        ISNULL(hd.expediente,'NA') AS expediente,  
        ISNULL(hd.modificado,'') AS modificado
        FROM lotes l
        INNER JOIN condominios c ON c.idCondominio = l.idCondominio
        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
        LEFT JOIN usuarios asesor ON asesor.id_usuario = cl.id_asesor
        LEFT JOIN sedes ON sedes.id_sede = cl.id_sede
        LEFT JOIN historial_documento hd ON hd.idLote = l.idLote AND hd.tipo_doc=30
        WHERE l.idStatusContratacion=15 AND l.idMovimiento=45 AND l.idStatusLote=2 $whereDinamico");
        return $query->result_array();
    }

    public function getListadoDeVentas($beginDate, $endDate) {
        $id_usuario = $this->session->userdata('id_usuario');
        $id_lider = $this->session->userdata('id_lider');
        $id_rol = $this->session->userdata('id_rol');
        $filtroRol = "";

        if ($id_usuario == 13418)
            $id_lider = $id_lider . ', 5604';

        if ($id_rol == 7) // CONSULTA UN ASESOR
            $filtroRol = "AND cl.id_asesor = $id_usuario";
        else if ($id_rol == 9) // CONSULTA UN COORDINADOR
            $filtroRol = "AND (cl.id_asesor = $id_usuario OR cl.id_coordinador = $id_usuario)";
        else if ($id_rol == 3) // CONSULTA UN GERENTE
            $filtroRol = "AND cl.id_gerente = $id_usuario";
        else if ($id_rol == 6) // CONSULTA UN ASISTENTE DE GERENTE
            $filtroRol = "AND cl.id_gerente = $id_lider";
        else if ($id_rol == 5) // CONSULTA UN ASISTENTE DE SUBDIRECTOR
            $filtroRol = "AND (cl.id_subdirector = $id_lider OR cl.id_regional = $id_lider)";

        return $this->db->query(
            "SELECT 
                re.nombreResidencial,
                co.nombre nombreCondominio,
                lo.nombreLote,
                lo.idLote,
                UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente,
                cl.fechaApartado,
                CASE WHEN u0.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) END nombreAsesor,
                CASE WHEN u1.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) END nombreCoordinador,
                CASE WHEN u2.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) END nombreGerente,
                CASE WHEN u3.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) END nombreSubdirector,
                CASE WHEN u4.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) END nombreRegional,
                CASE WHEN u5.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u5.nombre, ' ', u5.apellido_paterno, ' ', u5.apellido_materno)) END nombreRegional2,
                sc.nombreStatus estatusContratacion,
                mo.descripcion detalleMovimiento,
                sl.nombre estatusLote,
                sl.color coloStatusLote, sl.background_sl as fondoStatuslote,
                CASE WHEN lo.idMovimiento IN (31, 85, 20, 63, 73, 82, 92, 96, 99, 102, 104, 107, 108, 109, 111) THEN 'Sí' ELSE 'No' END estaConAsesor,
                CASE WHEN lo.idMovimiento IN (85, 20, 63, 73, 82, 92, 96, 99, 102, 104, 107, 108, 109, 111) THEN 'Rechazado' WHEN lo.idMovimiento IN (31) THEN 'Nuevo' ELSE 'No aplica' END detalleEstatus,
                lo.comentario
            FROM lotes lo
            INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.idLote = lo.idLote AND cl.status = 1 AND cl.fechaApartado BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59' $filtroRol
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
            INNER JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
            LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
            LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
            LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
            LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
            LEFT JOIN usuarios u5 ON u5.id_usuario = cl.id_regional_2
            INNER JOIN statuscontratacion sc ON sc.idStatusContratacion = lo.idStatusContratacion
            INNER JOIN movimientos mo ON mo.idMovimiento = lo.idMovimiento
            INNER JOIN statuslote sl ON sl.idStatusLote = lo.idStatusLote
            WHERE 
                lo.status = 1 
            ORDER BY
                cl.fechaApartado
            "
        )->result_array();
    }

    public function amountShare($id_rol){
        $nombreUsuario = "";
        $total = "";
        $precioDescuento = "";
        $join = "";
        $selectRol = "";
        $filtroPrecio = "";
        $filtroTotal = "";
        $filtroChart = "";

        if($id_rol == 1 || $id_rol == 4 || $id_rol == 18 || $id_rol == 33 || $id_rol == 58 || $id_rol == 63 || $id_rol == 69 || $id_rol == 72) {
            $join = 'id_regional';
            $selectRol = "vc.id_regional";
            $filtroTotal = "(CASE WHEN vc.id_regional = cl.id_regional AND vc.id_subdirector = cl.id_subdirector AND vc.id_gerente = cl.id_gerente AND vc.id_coordinador = cl.id_coordinador THEN 1 + 1 ELSE 0 + 1 END) END AS total";
            $filtroPrecio = "(CASE WHEN vc.id_regional = cl.id_regional AND vc.id_subdirector = cl.id_subdirector AND vc.id_gerente = cl.id_gerente AND vc.id_coordinador = cl.id_coordinador THEN 1 + 1 ELSE 0 + 1 END) END, 'C') AS precioDescuento";
            $filtroChart = "(CASE WHEN vc.id_regional = cl.id_regional AND vc.id_subdirector = cl.id_subdirector AND vc.id_gerente = cl.id_gerente AND vc.id_coordinador = cl.id_coordinador THEN 1 + 1 ELSE 0 + 1 END)";
            $filter = "vc.id_regional = cl.id_regional";
            }
        if($id_rol == 2) {
            $join = 'id_subdirector';
            $selectRol = "vc.id_regional,vc.id_subdirector";
            $filtroTotal = "(CASE WHEN vc.id_subdirector = cl.id_subdirector AND vc.id_gerente = cl.id_gerente AND vc.id_coordinador = cl.id_coordinador THEN 1 + 1 ELSE 0 + 1 END) END AS total";
            $filtroPrecio = "(CASE WHEN vc.id_subdirector = cl.id_subdirector AND vc.id_gerente = cl.id_gerente AND vc.id_coordinador = cl.id_coordinador THEN 1 + 1 ELSE 0 + 1 END) END, 'C') AS precioDescuento";
            $filtroChart = "(CASE WHEN vc.id_subdirector = cl.id_subdirector AND vc.id_gerente = cl.id_gerente AND vc.id_coordinador = cl.id_coordinador THEN 1 + 1 ELSE 0 + 1 END)";
            $filter = "vc.id_subdirector = cl.id_subdirector";
        }
        if ($id_rol == 5 && ($id_usuario == 28 || $id_usuario == 30 || $id_usuario == 4888)) { 
            $join = 'id_subdirector';
            $selectRol = "vc.id_regional,vc.id_subdirector";
            $filtroTotal = "(CASE WHEN vc.id_subdirector = cl.id_subdirector AND vc.id_gerente = cl.id_gerente AND vc.id_coordinador = cl.id_coordinador THEN 1 + 1 ELSE 0 + 1 END) END AS total";
            $filtroPrecio = "(CASE WHEN vc.id_subdirector = cl.id_subdirector AND vc.id_gerente = cl.id_gerente AND vc.id_coordinador = cl.id_coordinador THEN 1 + 1 ELSE 0 + 1 END) END, 'C' AS precioDescuento";
            $filtroChart = "(CASE WHEN vc.id_subdirector = cl.id_subdirector AND vc.id_gerente = cl.id_gerente AND vc.id_coordinador = cl.id_coordinador THEN 1 + 1 ELSE 0 + 1 END) ";
            $filter = "vc.id_subdirector = cl.id_subdirector";
        }
        if ($id_rol == 5 && ($id_usuario != 28 || $id_usuario != 30 || $id_usuario != 4888)) { 
            $join = 'id_gerente';
            $selectRol = "vc.id_regional,vc.id_subdirector";
            $filtroTotal = "(CASE WHEN vc.id_subdirector = cl.id_subdirector AND vc.id_gerente = cl.id_gerente AND vc.id_coordinador = cl.id_coordinador THEN 1 + 1 ELSE 0 + 1 END) END AS total";
            $filtroPrecio = "(CASE WHEN vc.id_subdirector = cl.id_subdirector AND vc.id_gerente = cl.id_gerente AND vc.id_coordinador = cl.id_coordinador THEN 1 + 1 ELSE 0 + 1 END) END , 'C' AS precioDescuento";
            $filtroChart = "(CASE WHEN vc.id_subdirector = cl.id_subdirector AND vc.id_gerente = cl.id_gerente AND vc.id_coordinador = cl.id_coordinador THEN 1 + 1 ELSE 0 + 1 END)" ;
            $filter = "vc.id_subdirector = cl.id_subdirector";
        }
        if($id_rol == 3 || $id_rol == 6) {
            $join = 'id_subdirector';
            $selectRol = "vc.id_regional,vc.id_subdirector,vc.id_coordinador,vc.id_gerente";
            $filtroTotal = "(CASE WHEN vc.id_gerente = cl.id_gerente AND vc.id_coordinador = cl.id_coordinador THEN 1 + 1 ELSE 0 + 1 END)END as total";
            $filtroPrecio = "(CASE WHEN vc.id_gerente = cl.id_gerente AND vc.id_coordinador = cl.id_coordinador THEN 1 + 1 ELSE 0 + 1 END)END, 'C') as precioDescuento";
            $filtroChart = "(CASE WHEN vc.id_gerente = cl.id_gerente AND vc.id_coordinador = cl.id_coordinador THEN 1 + 1 ELSE 0 + 1 END)";
            $filter = "vc.id_gerente = cl.id_gerente";
        }
        if($id_rol == 7) {
            $join = 'id_gerente';
            $selectRol = "vc.id_regional,vc.id_subdirector,vc.id_coordinador,vc.id_gerente,vc.id_regional_2,vc.id_asesor";
            $filtroTotal = "(COUNT(vc.id_cliente) )END AS total";
            $filtroPrecio = "(COUNT(vc.id_cliente) )END, 'C') AS precioDescuento";
            $filtroChart = "(COUNT(vc.id_cliente) )";
            $filter = "vc.id_asesor = cl.id_asesor";
        }
        if($id_rol == 9) {
            $join = 'id_coordinador';
            $selectRol = "vc.id_regional,vc.id_subdirector,vc.id_coordinador,vc.id_gerente,vc.id_regional_2,vc.id_asesor";
            $filtroTotal  =" (COUNT(vc.id_cliente) )END AS total";
            $filtroPrecio ="(COUNT(vc.id_cliente))END, 'C') AS precioDescuento";
            $filtroChart  =" (COUNT(vc.id_cliente) )";
            $filter = "vc.id_coordinador = cl.id_coordinador";
        }
        if($id_rol == 59) {
            $join = 'id_subdirector';
            $selectRol = "vc.id_regional,vc.id_subdirector,vc.id_coordinador,vc.id_gerente,vc.id_regional_2";
            $filtroTotal = "(CASE WHEN vc.id_subdirector = cl.id_subdirector AND vc.id_gerente = cl.id_gerente AND vc.id_coordinador = cl.id_coordinador THEN 1 + 1 ELSE 0 + 1 END) END AS total";
            $filtroPrecio = "(CASE WHEN vc.id_subdirector = cl.id_subdirector AND vc.id_gerente = cl.id_gerente AND vc.id_coordinador = cl.id_coordinador THEN 1 + 1 ELSE 0 + 1 END) END, 'C') AS precioDescuento";
            $filtroChart = "(CASE WHEN vc.id_subdirector = cl.id_subdirector AND vc.id_gerente = cl.id_gerente AND vc.id_coordinador = cl.id_coordinador THEN 1 + 1 ELSE 0 + 1 END) ";
            $filter = "vc.id_subdirector = vc.id_subdirector";
        }
        $nombreUsuario = "CASE WHEN vc.id_cliente IS NULL THEN CASE WHEN CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) = '  ' THEN 'ACUMULADO SIN ESPECIFICAR' ELSE CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno)END ELSE CASE WHEN $filter THEN CASE WHEN CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) = '  ' THEN 'ACUMULADO SIN ESPECIFICAR' ELSE CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) END ELSE 'ACUMULADO SIN ESPECIFICAR (COMPARTIDO)' END END AS nombreUsuario";
        $total = "CASE WHEN vc.id_cliente IS NULL THEN SUM(CASE WHEN (lo.totalNeto2 IS NULL OR lo.totalNeto2 = 0.00) THEN ISNULL(TRY_CAST(ds.costom2f AS DECIMAL(16,2)) * lo.sup, lo.precio * lo.sup)ELSE lo.totalNeto2 END) ELSE SUM(CASE WHEN (lo.totalNeto2 IS NULL OR lo.totalNeto2 = 0.00) THEN ISNULL(TRY_CAST(ds.costom2f AS DECIMAL(16,2)) * lo.sup, lo.precio * lo.sup) ELSE lo.totalNeto2 END ) / (MAX(vc2.cuenta) + COUNT(cl.id_cliente)) * $filtroTotal";
        $precioDescuento = "FORMAT(CASE WHEN vc.id_cliente IS NULL THEN SUM(CASE WHEN (lo.totalNeto2 IS NULL OR lo.totalNeto2 = 0.00) THEN ISNULL(TRY_CAST(ds.costom2f AS DECIMAL(16,2)) * lo.sup, lo.precio * lo.sup)
                ELSE lo.totalNeto2 END) ELSE SUM(CASE WHEN (lo.totalNeto2 IS NULL OR lo.totalNeto2 = 0.00) THEN ISNULL(TRY_CAST(ds.costom2f AS DECIMAL(16,2)) * lo.sup, lo.precio * lo.sup) ELSE lo.totalNeto2 END ) / (MAX(vc2.cuenta) + COUNT(cl.id_cliente)) * $filtroPrecio";

        $totalChart = " SUM(CASE WHEN vc.id_cliente IS NULL THEN CASE WHEN (lo.totalNeto2 IS NULL OR lo.totalNeto2 = 0.00) THEN ISNULL(TRY_CAST(ds.costom2f AS DECIMAL(16,2)) * lo.sup, lo.precio * lo.sup) 
                    ELSE lo.totalNeto2 END
                    ELSE CASE WHEN (lo.totalNeto2 IS NULL OR lo.totalNeto2 = 0.00) THEN ISNULL(TRY_CAST(ds.costom2f AS DECIMAL(16,2)) * lo.sup, lo.precio * lo.sup) 
                    ELSE lo.totalNeto2 END / (COUNT(vc2.cuenta) + COUNT(cl.id_cliente)) 
                    * $filtroChart
                    END) OVER (PARTITION BY MONTH(cl.fechaApartado), year(cl.fechaApartado)) AS total";

        return [$nombreUsuario, $total, $precioDescuento, $totalChart];
    }

    public function getLotesUnicos(){
        $query=$this->db->query("SELECT reporteIndividual.id_cliente, reporteIndividual.nombre_cliente, 
        CASE
            WHEN COALESCE(cp.nombre, '') = '' THEN 'Sin copropietario'
            ELSE UPPER(CONCAT(cp.nombre, ' ', cp.apellido_paterno, ' ', cp.apellido_materno))
        END AS nombre_copropietario, reporteIndividual.fechaApartado, reporteIndividual.repeticiones
        FROM (
        SELECT UPPER(CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS nombre_cliente, us.id_cliente, us.fechaApartado, repeticiones_por_nombre.repeticiones, 
            ROW_NUMBER() OVER (PARTITION BY repeticiones_por_nombre.nombre_normalizado ORDER BY us.fechaApartado) AS rn
        FROM clientes AS us
        JOIN (
            SELECT REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(UPPER(CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno)),'á','a'),'é','e'),'í','i'),'ó','o'),'ú','u'),'Á','A'),'É','E'),'Í','I'),'Ó','O'),'Ú','U') AS nombre_normalizado, 
                COUNT(*) AS repeticiones
            FROM clientes
            GROUP BY REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(UPPER(CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno)),'á','a'),'é','e'),'í','i'),'ó','o'),'ú','u'),'Á','A'),'É','E'),'Í','I'),'Ó','O'),'Ú','U'), status
            HAVING COUNT(*) > 10 and status=1
        ) AS repeticiones_por_nombre
        ON UPPER(CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) = repeticiones_por_nombre.nombre_normalizado
        ) AS reporteIndividual
        LEFT JOIN copropietarios cp ON cp.id_cliente = reporteIndividual.id_cliente
        WHERE rn = 1 
        ORDER BY nombre_cliente;");
        return $query;
    }

    public function getAllLotes($nombreCliente){
        $query=$this->db->query("SELECT us.status, us.id_cliente, lo.idLote, res.nombreResidencial as proyectoCondominio, res.descripcion, 
        cond.nombre_condominio, lo.nombreLote, UPPER(CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS nombreRepetidos, 
        repeticiones_por_nombre.repeticiones, us.fechaApartado, 
        CASE WHEN COALESCE(cp.nombre, '') = '' THEN 'Sin copropietario' ELSE UPPER(CONCAT(cp.nombre, ' ', cp.apellido_paterno, ' ', cp.apellido_materno)) END AS nombre_copropietario, 
        lo.referencia, us.fechaApartado, 
        CONCAT(ase.nombre,' ',ase.apellido_paterno,' ',ase.apellido_materno) AS asesor, 
        CONCAT(coo.nombre,' ',coo.apellido_paterno,' ',coo.apellido_materno) AS coordinador,
        CONCAT(ger.nombre,' ',ger.apellido_paterno,' ',ger.apellido_materno) AS gerente, 
        st.nombre as estatusApartado, sc.nombreStatus as estatus_contratacion, se.nombre as sede, oxc0.nombre as tipo_proceso
         FROM clientes AS us
         LEFT JOIN lotes lo ON lo.idLote = us.idLote
         LEFT JOIN copropietarios cp ON cp.id_cliente = us.id_cliente
         LEFT JOIN opcs_x_cats oxc0 ON 
             (CASE 
                 WHEN us.proceso = 0 THEN 1 
                 WHEN us.proceso IS NULL THEN 1 
                 ELSE us.proceso 
             END) = oxc0.id_opcion
         AND oxc0.id_catalogo = 97
         LEFT JOIN sedes se ON se.id_sede = us.id_sede 
         LEFT JOIN condominios cond ON lo.idCondominio = cond.idCondominio
         LEFT JOIN statuslote st ON st.idStatusLote = lo.idStatusLote
         LEFT JOIN residenciales res ON cond.idResidencial = res.idResidencial
         LEFT JOIN usuarios ase ON ase.id_usuario = us.id_asesor
         LEFT JOIN statuscontratacion sc ON sc.idStatusContratacion = lo.idStatusContratacion
         LEFT JOIN usuarios coo ON coo.id_usuario = us.id_coordinador
         LEFT JOIN usuarios ger ON ger.id_usuario = us.id_gerente
         JOIN (
             SELECT REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(UPPER(CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno)),'á','a'),'é','e'),'í','i'),'ó','o'),'ú','u'),'Á','A'),'É','E'),'Í','I'),'Ó','O'),'Ú','U') AS nombre_normalizado, 
                    COUNT(*) AS repeticiones
             FROM clientes
             GROUP BY REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(UPPER(CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno)),'á','a'),'é','e'),'í','i'),'ó','o'),'ú','u'),'Á','A'),'É','E'),'Í','I'),'Ó','O'),'Ú','U'), 
                      status
             HAVING COUNT(*) > 1 and status = 1
         ) AS repeticiones_por_nombre
         ON REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(UPPER(CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)),'á','a'),'é','e'),'í','i'),'ó','o'),'ú','u'),'Á','A'),'É','E'),'Í','I'),'Ó','O'),'Ú','U') = repeticiones_por_nombre.nombre_normalizado
         WHERE repeticiones > 10 
         AND REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(UPPER(CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)),'á','a'),'é','e'),'í','i'),'ó','o'),'ú','u'),'Á','A'),'É','E'),'Í','I'),'Ó','O'),'Ú','U') LIKE '%" . strtoupper($nombreCliente) . "%'
         AND us.status = 1
         ORDER BY us.nombre");
        return $query;
    }   

    public function getLotesTotal(){
        
        $query=$this->db->query("SELECT us.status, us.id_cliente, lo.idLote, res.nombreResidencial as proyectoCondominio, res.descripcion, 
        cond.nombre_condominio, lo.nombreLote, UPPER(CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS nombreRepetidos, 
        repeticiones_por_nombre.repeticiones, us.fechaApartado, 
        CASE WHEN COALESCE(cp.nombre, '') = '' THEN 'Sin copropietario' ELSE UPPER(CONCAT(cp.nombre, ' ', cp.apellido_paterno, ' ', cp.apellido_materno)) END AS nombre_copropietario, 
        lo.referencia, us.fechaApartado, 
        CONCAT(ase.nombre,' ',ase.apellido_paterno,' ',ase.apellido_materno) AS asesor, 
        CONCAT(coo.nombre,' ',coo.apellido_paterno,' ',coo.apellido_materno) AS coordinador,
        CONCAT(ger.nombre,' ',ger.apellido_paterno,' ',ger.apellido_materno) AS gerente, 
        st.nombre as estatusApartado, sc.nombreStatus as estatus_contratacion, se.nombre as sede, oxc0.nombre as tipo_proceso
         FROM clientes AS us
         LEFT JOIN lotes lo ON lo.idLote = us.idLote
         LEFT JOIN copropietarios cp ON cp.id_cliente = us.id_cliente
         LEFT JOIN opcs_x_cats oxc0 ON 
             (CASE 
                 WHEN us.proceso = 0 THEN 1 
                 WHEN us.proceso IS NULL THEN 1 
                 ELSE us.proceso 
             END) = oxc0.id_opcion
         AND oxc0.id_catalogo = 97
         LEFT JOIN sedes se ON se.id_sede = us.id_sede 
         LEFT JOIN condominios cond ON lo.idCondominio = cond.idCondominio
         LEFT JOIN statuslote st ON st.idStatusLote = lo.idStatusLote
         LEFT JOIN residenciales res ON cond.idResidencial = res.idResidencial
         LEFT JOIN usuarios ase ON ase.id_usuario = us.id_asesor
         LEFT JOIN statuscontratacion sc ON sc.idStatusContratacion = lo.idStatusContratacion
         LEFT JOIN usuarios coo ON coo.id_usuario = us.id_coordinador
         LEFT JOIN usuarios ger ON ger.id_usuario = us.id_gerente
         JOIN (
             SELECT REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(UPPER(CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno)),'á','a'),'é','e'),'í','i'),'ó','o'),'ú','u'),'Á','A'),'É','E'),'Í','I'),'Ó','O'),'Ú','U') AS nombre_normalizado, 
                    COUNT(*) AS repeticiones
             FROM clientes
             GROUP BY REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(UPPER(CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno)),'á','a'),'é','e'),'í','i'),'ó','o'),'ú','u'),'Á','A'),'É','E'),'Í','I'),'Ó','O'),'Ú','U'), 
                      status
             HAVING COUNT(*) > 1 and status = 1
         ) AS repeticiones_por_nombre
         ON REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(UPPER(CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)),'á','a'),'é','e'),'í','i'),'ó','o'),'ú','u'),'Á','A'),'É','E'),'Í','I'),'Ó','O'),'Ú','U') = repeticiones_por_nombre.nombre_normalizado
         WHERE repeticiones > 10 
         AND us.status = 1
         ORDER BY us.nombre;");
        return $query;
    }
}
