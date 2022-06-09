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
            $filter = " AND cl.id_asesor = $id_usuario";
        else if ($id_rol == 9) // MJ: Coordinador
           {
            if($typeTransaction == 1){ #Filtro que solo muestra los del usuario sesionado
                // $condicionalPR = 'AND id_asesor='.$id_usuario;
                // $condicionalCL = 'AND cl.id_asesor='.$id_usuario;
                $filtro .= "AND cl.id_asesor = $id_usuario";
                $filter .= "AND id_asesor = $id_usuario";
                $filter2 .= "p.id_asesor = $id_usuario";

            }else if($typeTransaction == 2){#Filtro que solo muestra los de todos los asesres
                // $condicionalPR = 'AND id_coordinador='.$id_usuario;
                // $condicionalCL = 'AND cl.id_coordinador='.$id_usuario;
                $filtro .= "AND cl.id_coordinador = $id_usuario";
                $filter .= "AND id_coordinador = $id_usuario";
                $filter2 .= "p.id_coordinador = $id_usuario";

            }else if($typeTransaction == 3){ #Filtro que muestra los propios y los asesores
                // $condicionalPR = 'OR id_asesor='.$id_usuario." OR id_coordinador=".$id_usuario;
                // $condicionalCL = 'OR cl.id_asesor='.$id_usuario." OR cl.id_coordinador=".$id_usuario;
                $filtro .= "AND (cl.id_coordinador = $id_usuario OR cl.id_asesor = $id_usuario)";
                $filter .= "AND (p.id_coordinador = $id_usuario OR p.id_asesor = $id_usuario)";
                $filter2 .= "(p.id_coordinador = $id_usuario OR p.id_asesor = $id_usuario)";

            }else{
                $filtro = '';
                $filter = "";
                $filter2 = "";
            }}
        else if ($id_rol == 3) // MJ: Gerente
            $filter = " AND cl.id_gerente = $id_usuario";
        else if ($id_rol == 6) // MJ: Asistente de gerencia
            $filter = " AND cl.id_gerente = $id_lider";
        else if ($id_rol == 2) // MJ: Subdirector
            $filter = " AND cl.id_subdirector = $id_usuario";
        else if ($id_rol == 5) // MJ: Asistente subdirección
            $filter = " AND cl.id_subdirector = $id_lider";
        else if ($id_rol == 2) {// MJ: Director regional
            $id_sede = "'" . implode("', '", explode(", ", $this->session->userdata('id_sede'))) . "'"; // MJ: ID sede separado por , como string
            $filter = " AND cl.id_sede IN ($id_sede)";
        }
        else if ($id_rol == 5) // MJ: Asistente de dirección regional
            $filter = ""; // MJ: PENDIENTE
        else if ($id_rol == 1 || $id_rol == 4) // MJ: Director comercial
            $filter = "";
        $query = $this->db->query("SELECT 
        ISNULL(a.totalVentas, 0) totalVentas, --TOTAL VENDIDO
        ISNULL(b.totalCT, 0) totalCT,  --TOTAL CANCELADO
        ISNULL(c.totalConT, 0) totalConT, --VENDIDO CONTRATADO
        ISNULL(d.totalAT, 0) totalAT, --VENDIDO APARTADO
        ISNULL(e.totalCanC, 0) totalCanC, --CANCELADOS CONTRATADOS
        ISNULL(b.totalCT, 0) - ISNULL(e.totalCanC, 0) totalCanA, --CANCELADOS APARTADOS
        f.prospTotales, --PROSPECTOS TOTALES
        g.prospNuevos, --PROSPECTOS NUEVOS
        h.prosCita --PROSPECTOS C/CITA
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
                SELECT  lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total FROM clientes cl
                INNER JOIN lotes lo ON lo.idLote = cl.idLote
                WHERE isNULL(noRecibo, '') != 'CANCELADO' $filtro
                GROUP BY lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total
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
                SELECT lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total FROM clientes cl
                INNER JOIN lotes lo ON lo.idLote = cl.idLote
                LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.idLote = lo.idLote AND hl.id_cliente = cl.id_cliente
                WHERE  isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 0 $filtro
                GROUP BY lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total
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
                SELECT lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total FROM clientes cl
                INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote = 2
                INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 15 AND idMovimiento = 45
                GROUP BY idLote, idCliente) hl ON hl.idLote = lo.idLote AND hl.idCliente = cl.id_cliente
                WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 1 $filtro
                GROUP BY lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total
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
                SELECT  lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total FROM clientes cl
                INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote != 2
                WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 1 $filtro
                GROUP BY lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total
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
                SELECT  lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total FROM clientes cl
                INNER JOIN lotes lo ON lo.idLote = cl.idLote
                LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
                INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 15 AND idMovimiento = 45
                GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
                WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 0 $filtro
                GROUP BY lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total
            ) tmpCC) e ON e.opt = d.opt
        INNER JOIN(SELECT COUNT(*) prospTotales, '1' opt FROM prospectos p WHERE $filter2) f ON f.opt = d.opt
        INNER JOIN (SELECT COUNT(*) prospNuevos, '1' opt FROM prospectos p WHERE $filter) g ON g.opt = f.opt
        INNER JOIN (SELECT COUNT(*) prosCita , '1' opt FROM prospectos p INNER JOIN agenda ag ON ag.idCliente = p.id_prospecto  WHERE $filter) h ON h.opt = g.opt");
        return $query->row();
    }


    public function totalVentasData($typeTransaction){
        $id_rol = $this->session->userdata('id_rol');
        $id_usuario = $this->session->userdata('id_usuario'); // PARA ASESOR, COORDINADOR, GERENTE, SUBDIRECTOR, REGIONAL Y DIRECCIÓN COMERCIAL
        $id_lider = $this->session->userdata('id_lider'); // PARA ASISTENTES
        $year = date("Y");

        if ($id_rol == 7) // MJ: Asesor
            $filtro = " AND cl.id_asesor = $id_usuario";
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
            $filtro = " AND cl.id_gerente = $id_usuario";
        else if ($id_rol == 6) // MJ: Asistente de gerencia
            $filtro = " AND cl.id_gerente = $id_lider";
        else if ($id_rol == 2) // MJ: Subdirector
            $filtro = " AND cl.id_subdirector = $id_usuario";
        else if ($id_rol == 5) // MJ: Asistente subdirección
            $filtro = " AND cl.id_subdirector = $id_lider";
        else if ($id_rol == 2) {// MJ: Director regional
            $id_sede = "'" . implode("', '", explode(", ", $this->session->userdata('id_sede'))) . "'"; // MJ: ID sede separado por , como string
            $filtro = " AND cl.id_sede IN ($id_sede)";
        }
        else if ($id_rol == 5) // MJ: Asistente de dirección regional
            $filtro = ""; // MJ: PENDIENTE
        else if ($id_rol == 1 || $id_rol == 4) // MJ: Director comercial
            $filtro = "";

        $query = $this->db->query("SELECT 
            FORMAT(ISNULL(a.sumaTotal, 0), 'C') sumaTotal, ISNULL(a.totalVentas, 0) totalVentas, --TOTAL VENDIDO
            FORMAT(ISNULL(b.sumaCT, 0), 'C') sumaCT, ISNULL(b.totalCT, 0) totalCT,  --TOTAL CANCELADO
            FORMAT(ISNULL(c.sumaConT, 0), 'C') sumaConT, ISNULL(c.totalConT, 0) totalConT, --VENDIDO CONTRATADO
            FORMAT(ISNULL(d.sumaAT, 0), 'C') sumaAT, ISNULL(d.totalAT, 0) totalAT, --VENDIDO APARTADO
            FORMAT(ISNULL(e.sumaCanC, 0), 'C') sumaCanC, ISNULL(e.totalCanC, 0) totalCanC, --CANCELADOS CONTRATADOS
            FORMAT(ISNULL(b.sumaCT, 0) - ISNULL(e.sumaCanC, 0), 'C') sumaCanA, 
            ISNULL(b.totalCT, 0) - ISNULL(e.totalCanC, 0) totalCanA,
            ----PORCENTAJES
            ISNULL(CAST((a.totalVentas * 100) / a.totalVentas AS decimal(16,2)), 0) porcentajeTotal,
            ISNULL(CAST((b.totalCT * 100) / a.totalVentas AS decimal(16,2)), 0) porcentajeTotalC,
            ISNULL(CAST((c.totalConT * 100) / a.totalVentas AS decimal(16,2)), 0) porcentajeTotalCont,
            ISNULL(CAST((d.totalAT * 100) / a.totalVentas AS decimal(16,2)), 0) porcentajeTotalAp,
            ISNULL(CAST((e.totalCanC * 100) / a.totalVentas AS decimal(16,2)), 0) porcentajeTotalCanC,
            ISNULL(CAST(((ISNULL(b.totalCT, 0) - ISNULL(e.totalCanC, 0)) * 100) / a.totalVentas AS decimal(16,2)), 0) porcentajeTotalCanA
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
                    SELECT  lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total FROM clientes cl
                    INNER JOIN lotes lo ON lo.idLote = cl.idLote
                    WHERE isNULL(noRecibo, '') != 'CANCELADO' $filtro
                    GROUP BY lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total
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
                    SELECT lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total FROM clientes cl
                    INNER JOIN lotes lo ON lo.idLote = cl.idLote
                    LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.idLote = lo.idLote AND hl.id_cliente = cl.id_cliente
                    WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 0 $filtro
                    GROUP BY lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total
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
                    SELECT lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total FROM clientes cl
                    INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote = 2
                    INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 15 AND idMovimiento = 45
                    GROUP BY idLote, idCliente) hl ON hl.idLote = lo.idLote AND hl.idCliente = cl.id_cliente
                    WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 1 $filtro
                    GROUP BY lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total
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
                    SELECT  lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total FROM clientes cl
                    INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote != 2
                    WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 1 $filtro
                    GROUP BY lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total
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
                    SELECT  lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total FROM clientes cl
                    INNER JOIN lotes lo ON lo.idLote = cl.idLote
                    LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
                    INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 15 AND idMovimiento = 45
                    GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
                    WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 0 $filtro
                    GROUP BY lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total
        ) tmpCC) e ON e.opt = d.opt");
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
            $filtro = "WHERE YEAR(fecha_creacion) = $year ";
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
            $filtro .= " AND id_subdirector = $id_usuario";
        else if ($id_rol == 5) // MJ: Asistente subdirección
            $filtro .= " AND id_subdirector = $id_lider";
        else if ($id_rol == 2) {// MJ: Director regional
            $id_sede = "'" . implode("', '", explode(", ", $this->session->userdata('id_sede'))) . "'"; // MJ: ID sede separado por , como string
            $filtro .= " AND id_sede IN ($id_sede)";
        }
        else if ($id_rol == 5) // MJ: Asistente de dirección regional
            $filtro .= ""; // MJ: PENDIENTE
        else if ($id_rol == 1 || $id_rol == 4) // MJ: Director comercial
            $filtro .= "";
      
        $query = $this->db->query("SELECT DATENAME(month,fecha_creacion) MONTH, COUNT(*) counts FROM prospectos
        $filtro
        GROUP BY DATENAME(month,fecha_creacion), MONTH(fecha_creacion)
        ORDER BY MONTH(fecha_creacion)");
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
            $filtro = "WHERE fecha_creacion BETWEEN '$begin 00:00:00' AND '$end 23:59:59' ";
        }else{
            $filtro = "WHERE YEAR(fecha_creacion) = $year ";
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
            $filtro .= " AND id_subdirector = $id_usuario";
        else if ($id_rol == 5) // MJ: Asistente subdirección
            $filtro .= " AND id_subdirector = $id_lider";
        else if ($id_rol == 2) {// MJ: Director regional
            $id_sede = "'" . implode("', '", explode(", ", $this->session->userdata('id_sede'))) . "'"; // MJ: ID sede separado por , como string
            $filtro .= " AND id_sede IN ($id_sede)";
        }
        else if ($id_rol == 5) // MJ: Asistente de dirección regional
            $filtro .= ""; // MJ: PENDIENTE
        else if ($id_rol == 1 || $id_rol == 4) // MJ: Director comercial
            $filtro .= "";
    
        $query = $this->db->query("SELECT DATENAME(month,fecha_creacion) MONTH, COUNT(*) counts FROM clientes 
        $filtro
        GROUP BY DATENAME(month,fecha_creacion), MONTH(fecha_creacion)
        ORDER BY MONTH(fecha_creacion)");
        return $query->result_array();
    }

    // public function generalMetricsByYear(){
    //     $year = date("Y");
    //     $id_usuario = $this->session->userdata('id_usuario');
    //     $query = $this->db->query("SELECT 
    //     ISNULL(a.totalVentas, 0) totalVentas, --TOTAL VENDIDO
    //     ISNULL(b.totalCT, 0) totalCT,  --TOTAL CANCELADO
    //     ISNULL(c.totalConT, 0) totalConT, --VENDIDO CONTRATADO
    //     ISNULL(d.totalAT, 0) totalAT, --VENDIDO APARTADO
    //     ISNULL(e.totalCanC, 0) totalCanC, --CANCELADOS CONTRATADOS
    //     ISNULL(b.totalCT, 0) - ISNULL(e.totalCanC, 0) totalCanA, --CANCELADOS APARTADOS
    //     f.prospTotales,
    //     g.prospNuevos
    //     FROM (
    //     --SUMA TOTAL
    //     SELECT SUM(
    //         CASE 
    //             WHEN tmpTotal.totalNeto2 IS NULL THEN tmpTotal.total 
    //             WHEN tmpTotal.totalNeto2 = 0 THEN tmpTotal.total 
    //             ELSE tmpTotal.totalNeto2 
    //         END) sumaTotal, 
    //         COUNT(*)
    //      totalVentas, '1' opt FROM (
    //             SELECT  lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total FROM clientes cl
    //             INNER JOIN lotes lo ON lo.idLote = cl.idLote
    //             WHERE MONTH(fechaApartado) = 02 AND YEAR(fechaApartado) = 2022 AND isNULL(noRecibo, '') != 'CANCELADO'
    //             GROUP BY lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total
    //         ) tmpTotal) a
    //     --SUMA CANCELADOS TOTALES
    //     LEFT JOIN(
    //     SELECT SUM(
    //         CASE 
    //             WHEN tmpCanT.totalNeto2 IS NULL THEN tmpCanT.total 
    //             WHEN tmpCanT.totalNeto2 = 0 THEN tmpCanT.total 
    //             ELSE tmpCanT.totalNeto2 
    //         END) sumaCT,
    //         COUNT(*)
    //      totalCT, '1' opt FROM (
    //             SELECT lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total FROM clientes cl
    //             INNER JOIN lotes lo ON lo.idLote = cl.idLote
    //             LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.idLote = lo.idLote AND hl.id_cliente = cl.id_cliente
    //             WHERE  MONTH(fechaApartado) = 02 AND YEAR(fechaApartado) = 2022 AND isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 0
    //             GROUP BY lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total
    //         ) tmpCanT) b ON b.opt = a.opt
    //     --SUMA CONTRATOS TOTALES
    //     LEFT JOIN(
    //     SELECT SUM(
    //         CASE 
    //             WHEN tmpConT.totalNeto2 IS NULL THEN tmpConT.total 
    //             WHEN tmpConT.totalNeto2 = 0 THEN tmpConT.total 
    //             ELSE tmpConT.totalNeto2 
    //         END) sumaConT,
    //         COUNT(*)
    //      totalConT, '1' opt FROM (
    //             SELECT lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total FROM clientes cl
    //             INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote = 2
    //             INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 15 AND idMovimiento = 45
    //             GROUP BY idLote, idCliente) hl ON hl.idLote = lo.idLote AND hl.idCliente = cl.id_cliente
    //             WHERE MONTH(fechaApartado) = 02 AND YEAR(fechaApartado) = 2022 AND isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 1
    //             GROUP BY lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total
    //         ) tmpConT) c ON c.opt = a.opt
    //     --Suma apartados totales
    //     LEFT JOIN(
    //     SELECT SUM(
    //         CASE 
    //             WHEN tmpApT.totalNeto2 IS NULL THEN tmpApT.total 
    //             WHEN tmpApT.totalNeto2 = 0 THEN tmpApT.total 
    //             ELSE tmpApT.totalNeto2 
    //         END) sumaAT, 
    //         COUNT(*)
    //      totalAT, '1' opt FROM (
    //             SELECT  lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total FROM clientes cl
    //             INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote != 2
    //             WHERE MONTH(fechaApartado) = 02 AND YEAR(fechaApartado) = 2022 AND isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 1
    //             GROUP BY lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total
    //         ) tmpApT) d ON d.opt = c.opt
    //     --SUMA Cancelados contratados
    //     LEFT JOIN(
    //     SELECT SUM(
    //         CASE 
    //             WHEN tmpCC.totalNeto2 IS NULL THEN tmpCC.total 
    //             WHEN tmpCC.totalNeto2 = 0 THEN tmpCC.total 
    //             ELSE tmpCC.totalNeto2 
    //         END) sumaCanC, 
    //         COUNT(*)
    //      totalCanC, '1' opt FROM (
    //             SELECT  lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total FROM clientes cl
    //             INNER JOIN lotes lo ON lo.idLote = cl.idLote
    //             LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
    //             INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 15 AND idMovimiento = 45
    //             GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
    //             WHERE MONTH(fechaApartado) = 02 AND YEAR(fechaApartado) = 2022 AND isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 0
    //             GROUP BY lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.total
    //         ) tmpCC) e ON e.opt = d.opt
    //     --Prospectos totales
    //     INNER JOIN(SELECT COUNT(*) prospTotales, '1' opt FROM prospectos WHERE id_asesor = 103) f ON f.opt = d.opt
    //     --Prospectos nuevos
    //     INNER JOIN (SELECT COUNT(*) prospNuevos, '1' opt FROM prospectos WHERE id_asesor = 103 AND fecha_creacion BETWEEN '2021-11-21 00:00:00.000' AND '2020-11-27 23:59:59.000') g ON g.opt = f.opt");
    //     return $query->row();
    // }

    public function cicloVenta($typeTransaction){
        $filtro = '';
        $year = date("Y");
        $id_usuario = $this->session->userdata('id_usuario');
        $id_rol = $this->session->userdata('id_rol');
        $id_lider = $this->session->userdata('id_lider'); // PARA ASISTENTES
    
        if ($id_rol == 7) // MJ: Asesor
            $filter = " AND cl.id_asesor = $id_usuario";
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
            $filter = " AND cl.id_gerente = $id_usuario";
        else if ($id_rol == 6) // MJ: Asistente de gerencia
            $filter = " AND cl.id_gerente = $id_lider";
        else if ($id_rol == 2) // MJ: Subdirector
            $filter = " AND cl.id_subdirector = $id_usuario";
        else if ($id_rol == 5) // MJ: Asistente subdirección
            $filter = " AND cl.id_subdirector = $id_lider";
        else if ($id_rol == 2) {// MJ: Director regional
            $id_sede = "'" . implode("', '", explode(", ", $this->session->userdata('id_sede'))) . "'"; // MJ: ID sede separado por , como string
            $filter = " AND cl.id_sede IN ($id_sede)";
        }
        else if ($id_rol == 5) // MJ: Asistente de dirección regional
            $filter = ""; // MJ: PENDIENTE
        else if ($id_rol == 1 || $id_rol == 4) // MJ: Director comercial
            $filter = "";
        $query = $this->db->query("SELECT
        ISNULL(a.totalProspectos, 0) totalProspectos, --TOTAL PROSPECTOS
        ISNULL(b.totalProspectosCita, 0) totalProspectosCita,  --TOTAL PROSPECTOS C/CITA
        ISNULL(c.totalProspectosCitaSeguimiento, 0) totalProspectosCitaSeguimiento, --TOTAL PROSPECTOS C/CITA SEGUIMIENTO
        ISNULL(d.totalMitadProceso, 0) totalMitadProceso, --TOTAL PROSPECTOS DESPUES DE CIERTO STATUS
        ISNULL(e.totalApartados, 0) totalApartados, --TOTAL PROSPECTOS C/APARTADO
        ISNULL(f.prospectosNoInteresados, 0) prospectosNoInteresados --TOTAL PROSPECTOS NO INTERESADOS
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
            WHERE  isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 1 $filtro
        )d ON d.opt = c.opt
        --TOTAL PROSPECTOS C/APARTADO
        LEFT JOIN(
            SELECT  COUNT(*) totalApartados, '1' opt FROM prospectos p
            INNER JOIN clientes cl ON  cl.id_prospecto = p.id_prospecto
            INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote != 2
            WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 1 $filtro
        )e ON e.opt = d.opt
        --TOTAL PROSPECTOS NO INTERESADOS
        LEFT JOIN (
            SELECT COUNT(*) prospectosNoInteresados, '1' opt FROM (
                SELECT * FROM prospectos p WHERE p.estatus_particular = 1 $filtro
            ) 
            tmpProsNo) f ON f.opt= e.opt");
        return $query->row();
    }
}
