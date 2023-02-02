<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 */
class Dashboard_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    public function getDataBetweenDates($fecha_inicio, $fecha_fin, $typeTransaction){
        $filtro = '';
        $filter = '';
        $filter2 = '';
        $year = date("Y");

        $id_usuario = $this->session->userdata('id_usuario');
        $id_rol = $this->session->userdata('id_rol');
        $id_lider = $this->session->userdata('id_lider'); // PARA ASISTENTES
    
        $filtro .= "AND cl.fechaApartado BETWEEN '$fecha_inicio 00:00:00' AND '$fecha_fin 23:59:59' ";
        $filter .= "p.fecha_creacion BETWEEN '$fecha_inicio 00:00:00' AND '$fecha_fin 23:59:59' ";

        if ($id_rol == 7) // MJ: Asesor
          {  $filtro .= " AND cl.id_asesor = $id_usuario";
            $filter .= " AND p.id_asesor = $id_usuario";
            $filter2 .= "WHERE p.id_asesor = $id_usuario";}

        else if ($id_rol == 9) // MJ: Coordinador
           {
            if($typeTransaction == 1){ #Filtro que solo muestra los del usuario sesionado
                // $condicionalPR = 'AND id_asesor='.$id_usuario;
                // $condicionalCL = 'AND cl.id_asesor='.$id_usuario;
                $filtro .= "AND cl.id_asesor = $id_usuario";
                $filter .= "AND id_asesor = $id_usuario";
                $filter2 .= "WHERE p.id_asesor = $id_usuario";

            }else if($typeTransaction == 2){#Filtro que solo muestra los de todos los asesres
                // $condicionalPR = 'AND id_coordinador='.$id_usuario;
                // $condicionalCL = 'AND cl.id_coordinador='.$id_usuario;
                $filtro .= "AND cl.id_coordinador = $id_usuario";
                $filter .= "AND id_coordinador = $id_usuario";
                $filter2 .= "WHERE p.id_coordinador = $id_usuario";

            }else if($typeTransaction == 3){ #Filtro que muestra los propios y los asesores
                // $condicionalPR = 'OR id_asesor='.$id_usuario." OR id_coordinador=".$id_usuario;
                // $condicionalCL = 'OR cl.id_asesor='.$id_usuario." OR cl.id_coordinador=".$id_usuario;
                $filtro .= "AND (cl.id_coordinador = $id_usuario OR cl.id_asesor = $id_usuario)";
                $filter .= "AND (p.id_coordinador = $id_usuario OR p.id_asesor = $id_usuario)";
                $filter2 .= "WHERE (p.id_coordinador = $id_usuario OR p.id_asesor = $id_usuario)";

            }else{
                $filtro .= '';
                $filter .= "";
                $filter2 .= "";
            }}
        else if ($id_rol == 3) // MJ: Gerente
          {  $filtro .= " AND cl.id_gerente = $id_usuario";
            $filter .= " AND id_gerente = $id_usuario";
            $filter2 .= "WHERE p.id_gerente = $id_usuario";}
        else if ($id_rol == 6) // MJ: Asistente de gerencia
          {  $filtro .= " AND cl.id_gerente = $id_lider";
            $filter .= " AND p.id_gerente = $id_lider";
            $filter2 .= "WHERE p.id_gerente = $id_lider";}
        else if ($id_rol == 2) // MJ: Subdirector
           {
            $getRol = $this->validateRegional($id_usuario);
            if(count($getRol) > 1){
                $filtro .= " AND (cl.id_subdirector = $id_usuario OR cl.id_regional = $id_usuario)";
                $filter .= " AND (p.id_subdirector = $id_usuario OR p.id_regional = $id_usuario)";
                $filter2 .= "WHERE (p.id_subdirector = $id_usuario OR p.id_regional = $id_usuario)"; 
            }else{
                $filtro .= " AND cl.id_subdirector = $id_usuario";
                $filter .= " AND p.id_subdirector = $id_usuario";
                $filter2 .= "WHERE p.id_subdirector = $id_usuario"; 
            }
        }
        else if ($id_rol == 5) // MJ: Asistente subdirección
          {  
           $getRol = $this->validateRegional($id_usuario);
            if(count($getRol) > 1){
                $filtro .= " AND (cl.id_subdirector = $id_lider OR cl.id_regional = $id_lider)";
                $filter .= " AND (p.id_subdirector = $id_lider OR p.id_regional = $id_lider)";
                $filter2 .= "WHERE (p.id_subdirector = $id_lider OR p.id_regional = $id_lider)"; 
            }else{
                $filtro .= " AND cl.id_subdirector = $id_lider";
                $filter .= " AND p.id_subdirector = $id_lider";
                $filter2 .= "WHERE p.id_subdirector = $id_lider"; 
            }
        }
        else if ($id_rol == 1 || $id_rol == 4 || $id_rol == 18 || $id_rol == 33 || $id_rol == 58 || $id_rol == 63 || $id_rol == 69 || $id_rol == 72) // MJ: Director comercial
           { $filtro .= "";
            $filter .= "";
            $filter2 .= "";
        }
        $query = $this->db->query("SELECT 
        ISNULL(a.totalVentas, 0) totalVentas, --TOTAL VENDIDO
        ISNULL(b.totalCT, 0) totalCT,  --TOTAL CANCELADO
        ISNULL(c.totalConT, 0) totalConT, --VENDIDO CONTRATADO
        ISNULL(d.totalAT, 0) totalAT, --VENDIDO APARTADO
        ISNULL(e.totalCanC, 0) totalCanC, --CANCELADOS CONTRATADOS
        ISNULL(i.totalCanA, 0) totalCanA, --CANCELADOS APARTADOS
        --ISNULL(b.totalCT, 0) - ISNULL(e.totalCanC, 0) totalCanA, --CANCELADOS APARTADOS
        f.prospTotales, --PROSPECTOS TOTALES
        g.prospNuevos, --PROSPECTOS NUEVOS
        h.prosCita, --PROSPECTOS C/CITA
        --porcentajes
        CAST(isNULL(CAST(a.totalVentas*100 as float) / NULLIF(CAST(a.totalVentas as float),0),0)as decimal (10,2)) porcentaje_totalVentas,
        CAST(isNULL(CAST(b.totalCT*100 as float) / NULLIF(CAST(a.totalVentas as float),0),0)as decimal (10,2)) porcentaje_totalCancelado,
        CAST(isNULL(CAST(c.totalConT*100 as float) / NULLIF(CAST(a.totalVentas as float),0),0) as decimal(10,2)) porcentaje_totalContratado,
        CAST(isNULL(CAST(d.totalAT*100 as float) / NULLIF(CASt(a.totalVentas as float),0),0)as decimal(10,2)) porcentaje_totalApartado,
        CAST(isNULL(CAST(e.totalCanC*100 as float) / NULLIF(CAST(a.totalVentas as float),0),0)as decimal(10,2)) porcentaje_totalCanceladoContratado,
        CAST(isNULL(CAST((ISNULL(b.totalCT, 0) - ISNULL(e.totalCanC, 0))*100 as float) / NULLIF(CAST(a.totalVentas as float),0),0)as decimal(10,2)) porcentaje_totalCanceladoapartado,
        CAST(isNULL(CAST(f.prospTotales*100 as float) / NULLIF(CAST(f.prospTotales as float),0),0)as decimal(10,2)) porcentaje_prospectosTotales,
        CAST(isNULL(CAST(g.prospNuevos*100 as float) / NULLIF(CAST(f.prospTotales as float),0),0)as decimal(10,2)) porcentaje_prospectosNuevos,
        CAST(isNULL(CAST(h.prosCita*100 as float) / NULLIF(CAST(f.prospTotales as float),0),0)as decimal(10,2)) porcentaje_prospectosCita

        FROM (
        --SUMA TOTAL
        SELECT SUM(
            CASE 
                WHEN tmpTotal.totalNeto2 IS NULL THEN tmpTotal.total 
                WHEN tmpTotal.totalNeto2 = 0 THEN tmpTotal.total 
                ELSE tmpTotal.totalNeto2 
            END) sumaTotal, 
            COUNT(*)
            totalVentas, '1' opt FROM (
                SELECT  lo.idLote, lo.nombreLote, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl, lo.totalNeto2) totalNeto2, isNULL(cl.total_cl,lo.total) total FROM clientes cl
                INNER JOIN lotes lo ON lo.idLote = cl.idLote
                WHERE isNULL(noRecibo, '') != 'CANCELADO' AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) $filtro
                GROUP BY lo.idLote, lo.nombreLote, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl, lo.totalNeto2), isNULL(cl.total_cl,lo.total)
            ) tmpTotal) a
        --SUMA CANCELADOS TOTALES
        LEFT JOIN(
        SELECT SUM(
            CASE 
                WHEN tmpCanT.totalNeto2 IS NULL THEN tmpCanT.total 
                WHEN tmpCanT.totalNeto2 = 0 THEN tmpCanT.total 
                ELSE tmpCanT.totalNeto2 
            END) sumaCT,
            COUNT(*)
            totalCT, '1' opt FROM (
                SELECT lo.idLote, lo.nombreLote, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl, lo.totalNeto2) totalNeto2, isNULL(cl.total_cl,lo.total) total FROM clientes cl
                INNER JOIN lotes lo ON lo.idLote = cl.idLote
                LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.idLote = lo.idLote AND hl.id_cliente = cl.id_cliente
                WHERE  isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 0 AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) $filtro
                GROUP BY lo.idLote, lo.nombreLote, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl, lo.totalNeto2), isNULL(cl.total_cl,lo.total)
            ) tmpCanT) b ON b.opt = a.opt
        --SUMA CONTRATOS TOTALES
        LEFT JOIN(
        SELECT SUM(
            CASE 
                WHEN tmpConT.totalNeto2 IS NULL THEN tmpConT.total 
                WHEN tmpConT.totalNeto2 = 0 THEN tmpConT.total 
                ELSE tmpConT.totalNeto2 
            END) sumaConT,
            COUNT(*)
            totalConT, '1' opt FROM (
                SELECT lo.idLote, lo.nombreLote, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl, lo.totalNeto2) totalNeto2, isNULL(cl.total_cl,lo.total) total FROM clientes cl
                INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote IN (2, 3)
                INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
                INNER JOIN historial_lotes hlo2 ON hlo2.idLote = hlo.idLote AND hlo2.idCliente = hlo.idCliente AND hlo2.modificado = hlo.modificado
                WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 1 AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) 
                $filtro
                AND hlo2.idStatusContratacion >= 11
                GROUP BY lo.idLote, lo.nombreLote, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl, lo.totalNeto2), isNULL(cl.total_cl,lo.total)
            ) tmpConT) c ON c.opt = a.opt
        --Suma apartados totales
        LEFT JOIN(
        SELECT SUM(
            CASE 
                WHEN tmpApT.totalNeto2 IS NULL THEN tmpApT.total 
                WHEN tmpApT.totalNeto2 = 0 THEN tmpApT.total 
                ELSE tmpApT.totalNeto2 
            END) sumaAT, 
            COUNT(*)
            totalAT, '1' opt FROM (
                SELECT  lo.idLote, lo.nombreLote, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl, lo.totalNeto2) totalNeto2, isNULL(cl.total_cl,lo.total) total FROM clientes cl
                INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote != 2 AND lo.idStatusContratacion < 11
                WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 1 AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) $filtro
                GROUP BY lo.idLote, lo.nombreLote, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl, lo.totalNeto2), isNULL(cl.total_cl,lo.total)
            ) tmpApT) d ON d.opt = c.opt
        --SUMA Cancelados contratados
        LEFT JOIN(
        SELECT SUM(
            CASE 
                WHEN tmpCC.totalNeto2 IS NULL THEN tmpCC.total 
                WHEN tmpCC.totalNeto2 = 0 THEN tmpCC.total 
                ELSE tmpCC.totalNeto2 
            END) sumaCanC, 
            COUNT(*)
            totalCanC, '1' opt FROM (
                SELECT  lo.idLote, lo.nombreLote, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl, lo.totalNeto2) totalNeto2, isNULL(cl.total_cl,lo.total) total FROM clientes cl
                INNER JOIN lotes lo ON lo.idLote = cl.idLote
                LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
                INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
                INNER JOIN historial_lotes hlo2 ON hlo2.idLote = hlo.idLote AND hlo2.idCliente = hlo.idCliente AND hlo2.modificado = hlo.modificado
                WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 0 AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) 
                $filtro
                AND hlo2.idStatusContratacion >= 11
                GROUP BY lo.idLote, lo.nombreLote, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl, lo.totalNeto2), isNULL(cl.total_cl,lo.total)
            ) tmpCC) e ON e.opt = d.opt
        --SUMA CANCELADOS APARTADOS
        LEFT JOIN(
        SELECT SUM(
            CASE 
                WHEN tmpCA.totalNeto2 IS NULL THEN tmpCA.total 
                WHEN tmpCA.totalNeto2 = 0 THEN tmpCA.total 
                ELSE tmpCA.totalNeto2 
            END) sumaCanA, 
            COUNT(*)
            totalCanA, '1' opt FROM (
                SELECT  lo.idLote, lo.nombreLote, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl, lo.totalNeto2) totalNeto2, isNULL(cl.total_cl,lo.total) total FROM clientes cl
                INNER JOIN lotes lo ON lo.idLote = cl.idLote
                LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
                INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
                INNER JOIN historial_lotes hlo2 ON hlo2.idLote = hlo.idLote AND hlo2.idCliente = hlo.idCliente AND hlo2.modificado = hlo.modificado
                WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 0 AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) 
                $filtro
                AND hlo2.idStatusContratacion < 11
                GROUP BY lo.idLote, lo.nombreLote, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl, lo.totalNeto2), isNULL(cl.total_cl,lo.total)
            ) tmpCA) i ON i.opt = e.opt
        INNER JOIN(SELECT COUNT(*) prospTotales, '1' opt FROM prospectos p $filter2) f ON f.opt = d.opt
        INNER JOIN (SELECT COUNT(*) prospNuevos, '1' opt FROM prospectos p WHERE $filter) g ON g.opt = f.opt
        INNER JOIN (SELECT COUNT(*) prosCita , '1' opt FROM prospectos p 
        INNER JOIN agenda ag ON ag.idCliente = p.id_prospecto  WHERE $filter) h ON h.opt = g.opt");
        return $query->row();
    }


    public function totalVentasData($typeTransaction){
        $id_rol = $this->session->userdata('id_rol');
        $id_usuario = $this->session->userdata('id_usuario'); // PARA ASESOR, COORDINADOR, GERENTE, SUBDIRECTOR, REGIONAL Y DIRECCIÓN COMERCIAL
        $id_lider = $this->session->userdata('id_lider'); // PARA ASISTENTES
        $year = date("Y");

        if ($id_rol == 7) // MJ: Asesor
            $filtro = " AND cl.id_asesor = $id_usuario AND YEAR(cl.fechaApartado) = $year";
        else if ($id_rol == 9) // MJ: Coordinador

            if($typeTransaction == 1){ #Filtro que solo muestra los del usuario sesionado
                
                $filtro = "AND cl.id_asesor = $id_usuario AND YEAR(cl.fechaApartado) = $year";

            }else if($typeTransaction == 2){#Filtro que solo muestra los de todos los asesres
            
                $filtro = "AND cl.id_coordinador = $id_usuario AND YEAR(cl.fechaApartado) = $year";

            }else if($typeTransaction == 3){ #Filtro que muestra los propios y los asesores
                $filtro = " AND (cl.id_coordinador = $id_usuario OR cl.id_asesor = $id_usuario) AND YEAR(cl.fechaApartado) = $year";
            }else{
                $filtro = "";
            }
        else if ($id_rol == 3) // MJ: Gerente
            $filtro = " AND cl.id_gerente = $id_usuario AND YEAR(cl.fechaApartado) = $year";
        else if ($id_rol == 6) // MJ: Asistente de gerencia
            $filtro = " AND cl.id_gerente = $id_lider AND YEAR(cl.fechaApartado) = $year";
        else if ($id_rol == 2) // MJ: Subdirector
        {
            $getRol = $this->validateRegional($id_usuario);
            if(count($getRol) > 1){
                $filtro = " AND (cl.id_subdirector = $id_usuario OR cl.id_regional = $id_usuario) AND YEAR(cl.fechaApartado) = $year";
            }else{
                $filtro = " AND cl.id_subdirector = $id_usuario AND YEAR(cl.fechaApartado) = $year";
            }
        }
        else if ($id_rol == 5) // MJ: Asistente subdirección
        {
            $getRol = $this->validateRegional($id_usuario);
            if(count($getRol) > 1){
                $filtro = " AND (cl.id_subdirector = $id_lider OR cl.id_regional = $id_lider) AND YEAR(cl.fechaApartado) = $year";
            }else{
                $filtro = " AND cl.id_subdirector = $id_lider AND YEAR(cl.fechaApartado) = $year";
            }
        }
        else if ($id_rol == 1 || $id_rol == 4 || $id_rol == 18 || $id_rol == 33 || $id_rol == 58 || $id_rol == 63 || $id_rol == 69 || $id_rol == 72) // MJ: Director comercial
            $filtro = " AND YEAR(cl.fechaApartado) = $year";

        $query = $this->db->query("SELECT 
            FORMAT(ISNULL(a.sumaTotal, 0), 'C') sumaTotal, ISNULL(a.totalVentas, 0) totalVentas, --TOTAL VENDIDO
            FORMAT(ISNULL(b.sumaCT, 0), 'C') sumaCT, ISNULL(b.totalCT, 0) totalCT,  --TOTAL CANCELADO
            FORMAT(ISNULL(c.sumaConT, 0), 'C') sumaConT, ISNULL(c.totalConT, 0) totalConT, --VENDIDO CONTRATADO
            FORMAT(ISNULL(d.sumaAT, 0), 'C') sumaAT, ISNULL(d.totalAT, 0) totalAT, --VENDIDO APARTADO
            FORMAT(ISNULL(e.sumaCanC, 0), 'C') sumaCanC, ISNULL(e.totalCanC, 0) totalCanC, --CANCELADOS CONTRATADOS
            FORMAT(ISNULL(f.sumaCanA, 0), 'C') sumaCanA, ISNULL(f.totalCanA, 0) totalCanA, --CANCELADOS APARTADOS
            --FORMAT(ISNULL(b.sumaCT, 0) - ISNULL(e.sumaCanC, 0), 'C') sumaCanA, 
            ISNULL(b.totalCT, 0) - ISNULL(e.totalCanC, 0) totalCanA,
            ----PORCENTAJES
            ISNULL(CAST((a.totalVentas * 100) / NULLIF(a.totalVentas,0) AS decimal(16,2)), 0) porcentajeTotal, 
            ISNULL(CAST((b.totalCT * 100) / NULLIF(a.totalVentas,0) AS decimal(16,2)), 0) porcentajeTotalC, 
            ISNULL(CAST((c.totalConT * 100) / NULLIF(a.totalVentas,0) AS decimal(16,2)), 0) porcentajeTotalCont, 
            ISNULL(CAST((d.totalAT * 100) / NULLIF(a.totalVentas,0) AS decimal(16,2)), 0) porcentajeTotalAp, 
            ISNULL(CAST((e.totalCanC * 100) / NULLIF(a.totalVentas,0) AS decimal(16,2)), 0) porcentajeTotalCanC, 
            ISNULL(CAST((f.totalCanA * 100) / NULLIF(a.totalVentas,0) AS decimal(16,2)), 0) porcentajeTotalCanA
            --ISNULL(CAST(((ISNULL(b.totalCT, 0) - ISNULL(e.totalCanC, 0)) * 100) / NULLIF(a.totalVentas,0) AS decimal(16,2)), 0) porcentajeTotalCanA 
            FROM (
            --SUMA TOTAL
            SELECT SUM(
                CASE 
                    WHEN tmpTotal.totalNeto2 IS NULL THEN tmpTotal.total 
                    WHEN tmpTotal.totalNeto2 = 0 THEN tmpTotal.total 
                    ELSE tmpTotal.totalNeto2 
                END) sumaTotal, 
                COUNT(*)
                totalVentas, '1' opt FROM (
                    SELECT  lo.idLote, lo.nombreLote,  cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl, lo.totalNeto2) totalNeto2, isNULL(cl.total_cl,lo.total) total FROM clientes cl
                    INNER JOIN lotes lo ON lo.idLote = cl.idLote
                    WHERE isNULL(noRecibo, '') != 'CANCELADO' AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) $filtro
                    GROUP BY lo.idLote, lo.nombreLote,  cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl, lo.totalNeto2), isNULL(cl.total_cl,lo.total)
                ) tmpTotal) a
            --SUMA CANCELADOS TOTALES
            LEFT JOIN(
            SELECT SUM(
                CASE 
                    WHEN tmpCanT.totalNeto2 IS NULL THEN tmpCanT.total 
                    WHEN tmpCanT.totalNeto2 = 0 THEN tmpCanT.total 
                    ELSE tmpCanT.totalNeto2 
                END) sumaCT,
                COUNT(*)
                totalCT, '1' opt FROM (
                    SELECT lo.idLote, lo.nombreLote,  cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl, lo.totalNeto2) totalNeto2, isNULL(cl.total_cl,lo.total) total FROM clientes cl
                    INNER JOIN lotes lo ON lo.idLote = cl.idLote
                    LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.idLote = lo.idLote AND hl.id_cliente = cl.id_cliente
                    WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 0 AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) $filtro
                    GROUP BY lo.idLote, lo.nombreLote,  cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl, lo.totalNeto2), isNULL(cl.total_cl,lo.total)
                ) tmpCanT) b ON b.opt = a.opt
            --SUMA CONTRATOS TOTALES
            LEFT JOIN(
            SELECT SUM(
                CASE 
                    WHEN tmpConT.totalNeto2 IS NULL THEN tmpConT.total 
                    WHEN tmpConT.totalNeto2 = 0 THEN tmpConT.total 
                    ELSE tmpConT.totalNeto2 
                END) sumaConT,
                COUNT(*)
                totalConT, '1' opt FROM (
                    SELECT lo.idLote, lo.nombreLote,  cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl, lo.totalNeto2) totalNeto2, isNULL(cl.total_cl,lo.total) total FROM clientes cl
                    INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote IN (2, 3)
                    INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion >= 11 GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
                    WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 1 AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) 
                    $filtro
                    GROUP BY lo.idLote, lo.nombreLote,  cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl, lo.totalNeto2), isNULL(cl.total_cl,lo.total)
                ) tmpConT) c ON c.opt = a.opt
            --Suma apartados totales
            LEFT JOIN(
            SELECT SUM(
                CASE 
                    WHEN tmpApT.totalNeto2 IS NULL THEN tmpApT.total 
                    WHEN tmpApT.totalNeto2 = 0 THEN tmpApT.total 
                    ELSE tmpApT.totalNeto2 
                END) sumaAT, 
                COUNT(*)
                totalAT, '1' opt FROM (
                    SELECT  lo.idLote, lo.nombreLote,  cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl, lo.totalNeto2) totalNeto2, isNULL(cl.total_cl,lo.total) total FROM clientes cl
                    INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote != 2 AND lo.idStatusContratacion < 11
                    WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 1 AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) $filtro
                    GROUP BY lo.idLote, lo.nombreLote,  cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl, lo.totalNeto2), isNULL(cl.total_cl,lo.total)
                ) tmpApT) d ON d.opt = c.opt
            --SUMA Cancelados contratados
            LEFT JOIN(
            SELECT SUM(
                CASE 
                    WHEN tmpCC.totalNeto2 IS NULL THEN tmpCC.total 
                    WHEN tmpCC.totalNeto2 = 0 THEN tmpCC.total 
                    ELSE tmpCC.totalNeto2 
                END) sumaCanC, 
                COUNT(*)
                totalCanC, '1' opt FROM (
                    SELECT  lo.idLote, lo.nombreLote,  cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl, lo.totalNeto2) totalNeto2, isNULL(cl.total_cl,lo.total) total FROM clientes cl
                    INNER JOIN lotes lo ON lo.idLote = cl.idLote
                    LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
                    INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
                    INNER JOIN historial_lotes hlo2 ON hlo2.idLote = hlo.idLote AND hlo2.idCliente = hlo.idCliente AND hlo2.modificado = hlo.modificado
                    WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 0 AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) 
                    $filtro
                    AND hlo2.idStatusContratacion >= 11
                    GROUP BY lo.idLote, lo.nombreLote,  cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl, lo.totalNeto2), isNULL(cl.total_cl,lo.total)
        ) tmpCC) e ON e.opt = d.opt
        --SUMA Cancelados apartados
        LEFT JOIN(
            SELECT SUM(
                CASE 
                    WHEN tmpCA.totalNeto2 IS NULL THEN tmpCA.total 
                    WHEN tmpCA.totalNeto2 = 0 THEN tmpCA.total 
                    ELSE tmpCA.totalNeto2 
                END) sumaCanA, 
                COUNT(*)
                totalCanA, '1' opt FROM (
                    SELECT  lo.idLote, lo.nombreLote,  cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl, lo.totalNeto2) totalNeto2, isNULL(cl.total_cl,lo.total) total FROM clientes cl
                    INNER JOIN lotes lo ON lo.idLote = cl.idLote
                    LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
                    INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
                    INNER JOIN historial_lotes hlo2 ON hlo2.idLote = hlo.idLote AND hlo2.idCliente = hlo.idCliente AND hlo2.modificado = hlo.modificado
                    WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 0 AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) 
                    $filtro
                    AND hlo2.idStatusContratacion < 11
                    GROUP BY lo.idLote, lo.nombreLote,  cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl, lo.totalNeto2), isNULL(cl.total_cl,lo.total)
        ) tmpCA) f ON f.opt = e.opt");
        return $query->row();
    }

    public function getProspectsByYear($data = null){
        $id_rol = $this->session->userdata('id_rol');
        $id_usuario = $this->session->userdata('id_usuario'); // PARA ASESOR, COORDINADOR, GERENTE, SUBDIRECTOR, REGIONAL Y DIRECCIÓN COMERCIAL
        $id_lider = $this->session->userdata('id_lider'); // PARA ASISTENTES
        $year = date("Y");
        $typeTransaction= $data['typeTransaction'];

        if($data['type'] == 2){
            $begin = $data['beginDate'];
            $end = $data['endDate'];
            $filtro = "WHERE fecha_creacion BETWEEN '$begin 00:00:00' AND '$end 23:59:59' ";
        }else{
            $begin = "$year-01-01";
            $end = date("Y-m-d");
            $filtro = "WHERE fecha_creacion BETWEEN '$begin 00:00:00' AND '$end 23:59:59' ";
        }

        if ($id_rol == 7) // MJ: Asesor
            $filtro .= " AND id_asesor = $id_usuario";
        else if ($id_rol == 9) // MJ: Coordinador

            if($typeTransaction == 1){ #Filtro que solo muestra los del usuario sesionado
                
                $filtro .= "AND id_asesor = $id_usuario";

            }else if($typeTransaction == 2){#Filtro que solo muestra los de todos los asesres
            
                $filtro .= "AND id_coordinador = $id_usuario";

            }else if($typeTransaction == 3){ #Filtro que muestra los propios y los asesores
                $filtro .= " AND (id_coordinador = $id_usuario OR id_asesor = $id_usuario)";
            }else{
                $filtro .= "";
            }
        else if ($id_rol == 3) // MJ: Gerente
            $filtro .= " AND id_gerente = $id_usuario";
        else if ($id_rol == 6) // MJ: Asistente de gerencia
            $filtro .= " AND id_gerente = $id_lider";
        else if ($id_rol == 2) // MJ: Subdirector
            {$getRol = $this->validateRegional($id_usuario);
            if(count($getRol) > 1){
                $filtro .= " AND (id_subdirector = $id_usuario OR id_regional = $id_usuario)";
            }else{
                $filtro .= " AND id_subdirector = $id_usuario";
            }}
        else if ($id_rol == 5) // MJ: Asistente subdirección
            $filtro .= " AND id_subdirector = $id_lider";
        else if ($id_rol == 2) {// MJ: Director regional
            $id_sede = "'" . implode("', '", explode(", ", $this->session->userdata('id_sede'))) . "'"; // MJ: ID sede separado por , como string
            $filtro .= " AND id_sede IN ($id_sede)";
        }
        else if ($id_rol == 5) // MJ: Asistente de dirección regional
            $filtro .= ""; // MJ: PENDIENTE
        else if ($id_rol == 1 || $id_rol == 4 || $id_rol == 18 || $id_rol == 33 || $id_rol == 58 || $id_rol == 63 || $id_rol == 69 || $id_rol == 72) // MJ: Director comercial
            $filtro .= "";
        $query = $this->db->query("WITH cte AS(
            SELECT CAST('$begin 00:00:00' AS DATETIME) DateValue
            UNION ALL
            SELECT  DateValue + 1
            FROM    cte   
            WHERE   DateValue + 1 <= '$end 00:00:00')

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
				END) MONTH, YEAR(DateValue) año, isNULL(qu.cantidad,0) counts FROM cte 
			LEFT JOIN (SELECT COUNT(*)cantidad, MONTH(fecha_creacion) mes, YEAR(fecha_creacion) año FROM prospectos
			$filtro
			GROUP BY MONTH(fecha_creacion), YEAR(fecha_creacion)) qu ON qu.mes = month(cte.DateValue) AND qu.año = year(cte.DateValue)
			GROUP BY YEAR(DateValue), MONTH(DateValue), cantidad
			ORDER BY YEAR(DateValue), MONTH(DateValue)
			OPTION (MAXRECURSION 0)");
        return $query->result_array();
    }


    public function getClientsByYear($data = null){
        $id_rol = $this->session->userdata('id_rol');
        $id_usuario = $this->session->userdata('id_usuario'); // PARA ASESOR, COORDINADOR, GERENTE, SUBDIRECTOR, REGIONAL Y DIRECCIÓN COMERCIAL
        $id_lider = $this->session->userdata('id_lider'); // PARA ASISTENTES
        $year = date("Y");
        $typeTransaction= $data['typeTransaction'];

        if($data['type'] == 2){
            $begin = $data['beginDate'];
            $end = $data['endDate'];
            $filtro = "WHERE isNULL(noRecibo, '') != 'CANCELADO' AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.fecha_creacion BETWEEN '$begin 00:00:00' AND '$end 23:59:59' ";
        }else{
            $begin = "$year-01-01";
            $end = date("Y-m-d");
            $filtro = "WHERE isNULL(noRecibo, '') != 'CANCELADO' AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.fecha_creacion BETWEEN '$begin 00:00:00' AND '$end 23:59:59'";
        }

        if ($id_rol == 7) // MJ: Asesor
            $filtro .= " AND cl.id_asesor = $id_usuario";
        else if ($id_rol == 9) // MJ: Coordinador

            if($typeTransaction == 1){ #Filtro que solo muestra los del usuario sesionado
                
                $filtro .= "AND cl.id_asesor = $id_usuario";

            }else if($typeTransaction == 2){#Filtro que solo muestra los de todos los asesres
            
                $filtro .= "AND cl.id_coordinador = $id_usuario";

            }else if($typeTransaction == 3){ #Filtro que muestra los propios y los asesores
                $filtro .= " AND (cl.id_coordinador = $id_usuario OR cl.id_asesor = $id_usuario)";
            }else{
                $filtro .= "";
            }
        else if ($id_rol == 3) // MJ: Gerente
            $filtro .= " AND cl.id_gerente = $id_usuario";
        else if ($id_rol == 6) // MJ: Asistente de gerencia
            $filtro .= " AND cl.id_gerente = $id_lider";
        else if ($id_rol == 5) // MJ: Asistente subdirección
        {    
            $getRol = $this->validateRegional($id_usuario);
            if(count($getRol) > 1){
                $filtro .= " AND (cl.id_subdirector = $id_lider OR cl.id_regional = $id_lider)";
            }else{
                $filtro .= " AND cl.id_subdirector = $id_lider";
            }
        }
        else if ($id_rol == 2)  {
            $getRol = $this->validateRegional($id_usuario);
            if(count($getRol) > 1){
                $filtro .= " AND (cl.id_subdirector = $id_usuario OR cl.id_regional = $id_usuario)";
            }else{
                $filtro .= " AND cl.id_subdirector = $id_usuario";
            }
        }
        else if ($id_rol == 1 || $id_rol == 4 || $id_rol == 18 || $id_rol == 33 || $id_rol == 58 || $id_rol == 63 || $id_rol == 69 || $id_rol == 72) // MJ: Director comercial
            $filtro .= "";
        $query = $this->db->query("WITH cte AS(
            SELECT CAST('$begin 00:00:00' AS DATETIME) DateValue
            UNION ALL
            SELECT  DateValue + 1
            FROM    cte   
            WHERE   DateValue + 1 <= '$end 23:59:59')

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
				END) MONTH, YEAR(DateValue) año, isNULL(qu.cantidad,0) counts FROM cte 
			LEFT JOIN (SELECT COUNT(*)cantidad, MONTH(cl.fecha_creacion) mes, YEAR(cl.fecha_creacion) año FROM clientes cl
			INNER JOIN lotes lo ON lo.idLote = cl.idLote
            $filtro
			GROUP BY MONTH(cl.fecha_creacion), YEAR(cl.fecha_creacion)) qu ON qu.mes = month(cte.DateValue) AND qu.año = year(cte.DateValue)
			GROUP BY YEAR(DateValue), MONTH(DateValue), cantidad
			ORDER BY YEAR(DateValue), MONTH(DateValue)
			OPTION (MAXRECURSION 0)");
        return $query->result_array();
    }

    public function cicloVenta($typeTransaction){
        $filtro = '';
        $year = date("Y");
        $id_usuario = $this->session->userdata('id_usuario');
        $id_rol = $this->session->userdata('id_rol');
        $id_lider = $this->session->userdata('id_lider'); // PARA ASISTENTES
    
        if ($id_rol == 7) // MJ: Asesor
            $filtro .= " AND p.id_asesor = $id_usuario AND YEAR(p.fecha_creacion) = $year";

        else if ($id_rol == 9) // MJ: Coordinador
           {
            if($typeTransaction == 1){ #Filtro que solo muestra los del usuario sesionado
               
                $filtro .= "AND p.id_asesor = $id_usuario AND p.estatus= 1 AND YEAR(p.fecha_creacion) = $year";

            }else if($typeTransaction == 2){#Filtro que solo muestra los de todos los asesres
               
                $filtro .= "AND p.id_coordinador = $id_usuario AND p.estatus= 1 AND YEAR(p.fecha_creacion) = $year";

            }else if($typeTransaction == 3){ #Filtro que muestra los propios y los asesores
                
                $filtro .= "AND (p.id_coordinador = $id_usuario OR p.id_asesor = $id_usuario) AND p.estatus= 1 AND YEAR(p.fecha_creacion) = $year";

            }else{
                $filtro = "";
            }
        }
        else if ($id_rol == 3) // MJ: Gerente
            $filter = " AND p.id_gerente = $id_usuario AND YEAR(p.fecha_creacion) = $year";
        else if ($id_rol == 6) // MJ: Asistente de gerencia
            $filter = " AND p.id_gerente = $id_lider AND YEAR(p.fecha_creacion) = $year";
        else if ($id_rol == 2) // MJ: Subdirector
        {    
            $getRol = $this->validateRegional($id_usuario);
            if(count($getRol) > 1){
                $filtro .= " AND (p.id_subdirector = $id_usuario OR p.id_regional = $id_usuario) AND YEAR(p.fecha_creacion) = $year";
            }else{
                $filtro .= " AND p.id_subdirector = $id_usuario AND YEAR(p.fecha_creacion) = $year";
            }
        }
        else if ($id_rol == 5) // MJ: Asistente subdirección
        {    
            $getRol = $this->validateRegional($id_usuario);
            if(count($getRol) > 1){
                $filtro .= " AND (p.id_subdirector = $id_lider OR p.id_regional = $id_lider) AND YEAR(p.fecha_creacion) = $year";
            }else{
                $filtro .= " AND p.id_subdirector = $id_lider AND YEAR(p.fecha_creacion) = $year";
            }
        }
        else if ($id_rol == 1 || $id_rol == 4 || $id_rol == 18 || $id_rol == 33 || $id_rol == 58 || $id_rol == 63 || $id_rol == 69 || $id_rol == 72) // MJ: Director comercial

            $filtro .= " AND YEAR(p.fecha_creacion) = $year";
        $query = $this->db->query("SELECT
        ISNULL(a.totalProspectos, 0) totalProspectos, --TOTAL PROSPECTOS
        ISNULL(b.totalProspectosCita, 0) totalProspectosCita,  --TOTAL PROSPECTOS C/CITA
        ISNULL(c.totalProspectosCitaSeguimiento, 0) totalProspectosCitaSeguimiento, --TOTAL PROSPECTOS C/CITA SEGUIMIENTO
        ISNULL(d.totalMitadProceso, 0) totalMitadProceso, --TOTAL PROSPECTOS DESPUES DE CIERTO STATUS
        ISNULL(e.totalApartados, 0) totalApartados, --TOTAL PROSPECTOS C/APARTADO
        ISNULL(f.prospectosNoInteresados, 0) prospectosNoInteresados, --TOTAL PROSPECTOS NO INTERESADOS
        --porcentajes
        CAST(isNULL(CAST(b.totalProspectosCita*100 as float) / CAST(a.totalProspectos as float),0)as decimal (10,2)) porcentaje_prospectosCita,
        CAST(isNULL(CAST(c.totalProspectosCitaSeguimiento*100 as float) / CAST(a.totalProspectos as float),0) as decimal(10,2)) porcentaje_prospectosSeguimiento,
        CAST(isNULL(CAST(e.totalApartados*100 as float) / CASt(a.totalProspectos as float),0)as decimal(10,2)) porcentaje_prospectosApartados,
        CAST(isNULL(CAST(f.prospectosNoInteresados*100 as float) / CAST(a.totalProspectos as float),0)as decimal(10,2)) porcentaje_prospectosNoInteresado

        from(
        --TOTAL PROSPECTOS
        SELECT COUNT(*) totalProspectos, '1' opt FROM (
            SELECT id_prospecto FROM prospectos p WHERE p.estatus= 1 $filtro
            ) tmpTotalProspectos
        )a
        --TOTAL PROSPECTOS C/CITA
        LEFT JOIN (
        SELECT COUNT(*) totalProspectosCita, '1' opt FROM (
            SELECT a.id_cita FROM agenda a
            INNER JOIN prospectos p ON p.id_prospecto = a.idCliente  $filtro
            ) tmpTotalProspectosCita
        )b ON b.opt = a.opt
         --TOTAL PROSPECTOS C/CITA SEGUIMIENTO
        LEFT JOIN (
        SELECT COUNT(*) totalProspectosCitaSeguimiento, '1' opt FROM (
            SELECT a.idCliente, COUNT(idCliente) countCliente FROM agenda a
            INNER JOIN prospectos p ON p.id_prospecto = a.idCliente $filtro
            GROUP BY idCliente
                HAVING COUNT(idCliente) > 1
            ) tmpTotalProspectosCitaSeguimiento
        )c ON c.opt = b.opt
        --TOTAL PROSPECTOS DESPUES DE CIERTO STATUS
        LEFT JOIN (
            SELECT  COUNT(*) totalMitadProceso, '1' opt FROM prospectos p
            INNER JOIN clientes cl ON cl.id_prospecto = p.id_prospecto AND cl.status = 1 
            INNER JOIN lotes l ON l.idCliente = cl.id_cliente AND l.idStatusContratacion > 6
            WHERE  isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 1 AND isNULL(cl.tipo_venta_cl, l.tipo_venta) IN(1, 2) $filtro
        )d ON d.opt = c.opt
        --TOTAL PROSPECTOS C/APARTADO
        LEFT JOIN(
            SELECT  COUNT(*) totalApartados, '1' opt FROM prospectos p
            INNER JOIN clientes cl ON  cl.id_prospecto = p.id_prospecto
            INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote != 2 AND lo.idStatusContratacion < 11
            WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 1 AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) $filtro
        )e ON e.opt = d.opt
        --TOTAL PROSPECTOS NO INTERESADOS
        LEFT JOIN (
            SELECT COUNT(*) prospectosNoInteresados, '1' opt FROM (
                SELECT * FROM prospectos p WHERE p.estatus_particular = 1 $filtro
            ) 
            tmpProsNo) f ON f.opt= e.opt");
        return $query->row();
    }

    public function validateRegional($id){
        $data = $this->db->query("SELECT * FROM roles_x_usuario WHERE idUsuario = $id and idRol IN (59,60)");
        return $data->result_array();    
    }
}
