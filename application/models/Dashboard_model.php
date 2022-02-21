<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 */
class Dashboard_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    public function getTotalSalesByMonth() {
        return $this->db->query("SELECT(CASE WHEN MONTH(hl.modificado) = 1 THEN 'Enero' WHEN MONTH(hl.modificado) = 2 THEN 'Febrero' WHEN MONTH(hl.modificado) = 3 THEN 'Marzo'
        WHEN MONTH(hl.modificado) = 4 THEN 'Abril' WHEN MONTH(hl.modificado) = 5 THEN 'Mayo' WHEN MONTH(hl.modificado) = 6 THEN 'Junio'
        WHEN MONTH(hl.modificado) = 7 THEN 'Julio' WHEN MONTH(hl.modificado) = 8 THEN 'Agosto' WHEN MONTH(hl.modificado) = 9 THEN 'Septiembre'
        WHEN MONTH(hl.modificado) = 10 THEN 'Octubre' WHEN MONTH(hl.modificado) = 11 THEN 'Noviembre' WHEN MONTH(hl.modificado) = 12 THEN 'Diciembre' END) month_name,
        COUNT(l.idLote) lotesNumber, SUM(l.totalNeto2) total FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1
        INNER JOIN (SELECT MAX(modificado) modificado, idStatusContratacion, idMovimiento, idLote, status, idCliente FROM historial_lotes 
        GROUP BY idStatusContratacion, idMovimiento, idLote, status, idCliente) hl ON hl.idLote = l.idLote AND hl.idStatusContratacion = 15 
        AND hl.idMovimiento = 45 AND hl.status = 1 AND hl.idCliente = cl.id_cliente
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
        INNER JOIN sedes s ON s.id_sede = u.id_sede
        WHERE l.status = 1 AND l.idStatusLote = 2 AND l.idStatusContratacion = 15 AND l.idMovimiento = 45
        AND YEAR(hl.modificado) = 2021
        GROUP BY MONTH(hl.modificado)");
    }

    public function getGeneralInformation($typeTransaction, $beginDate, $endDate, $currentYear, $saleType) {
        if ($saleType == 1) $prospectingPlace = " AND cl.lugar_prospeccion != 6";
        else if ($saleType ==2) $prospectingPlace = " AND cl.lugar_prospeccion = 6";
        else $prospectingPlace = "";

        if ($typeTransaction == 1) { // MJ: Por año
            $filter = "AND YEAR(cl.fechaApartado) = $currentYear";
        } else if ($typeTransaction == 2) { // MJ: Año y tipo de venta
            $filter = "AND YEAR(cl.fechaApartado) = $currentYear" . $prospectingPlace;
        } else if ($typeTransaction == 3) { // MJ: Por fecha
            $filter = "AND cl.fechaApartado BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
        } else if ($typeTransaction == 4) { // MJ: Por fecha y por tipo de venta
            $filter = "AND cl.fechaApartado BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'" . $prospectingPlace;
        }
        
        return $this->db->query("SELECT UPPER(a.nombre) nombre, a.id_sede id, '2' type, ISNULL(c.contratado, 0) contratado, ISNULL(c.totalContratados, 0) totalContratados, ISNULL(b.cancelado, 0) cancelado, ISNULL(b.totalCancelados, 0) totalCancelados, ISNULL(a.apartado, 0) apartado, ISNULL(a.totalApartados, 0) totalApartados, 0 pa,
		SUM(ISNULL(c.contratado, 0) + ISNULL(a.apartado, 0)) total, SUM(ISNULL(c.totalContratados, 0) + ISNULL(a.totalApartados, 0)) totalLotes,
		d.finalTotal, d.finalTotalLotes, ISNULL(CAST((c.contratado * 100) / d.finalTotal AS decimal(16,2)), 0) porcentajeContratado,
		ISNULL(CAST((a.apartado * 100) / d.finalTotal AS decimal(16,2)), 0) porcentajeApartado FROM (
		-- APARTADO
		SELECT s.nombre, s.id_sede, SUM(ISNULL(l.totalNeto2, l.total)) apartado, COUNT(*) totalApartados, '1' opt FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1 $filter
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
        WHERE l.status = 1
        GROUP BY s.nombre, s.id_sede) a
		-- CANCELADOS
        LEFT JOIN(
        SELECT s.nombre, SUM(ISNULL(l.totalNeto2, l.total)) cancelado, COUNT(*) totalCancelados FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1 $filter
        INNER JOIN (SELECT MAX(modificado) modificado, idLote, status FROM historial_liberacion
        GROUP BY idLote, status) hl ON hl.idLote = l.idLote AND hl.status = 1
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
        WHERE l.status = 1
        GROUP BY s.nombre, s.id_sede) b ON b.nombre = a.nombre
		-- CONTRATADO
        LEFT JOIN(
		SELECT s.nombre, s.id_sede, SUM(ISNULL(l.totalNeto2, l.total)) contratado, COUNT(*) totalContratados FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1 $filter
        INNER JOIN (SELECT MAX(modificado) modificado, idStatusContratacion, idMovimiento, idLote, status, idCliente FROM historial_lotes 
        GROUP BY idStatusContratacion, idMovimiento, idLote, status, idCliente) hl ON hl.idLote = l.idLote AND hl.idStatusContratacion = 15 
        AND hl.idMovimiento = 45 AND hl.status = 1 AND hl.idCliente = cl.id_cliente
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
        WHERE l.status = 1 AND l.idStatusLote = 2 AND l.idStatusContratacion = 15 AND l.idMovimiento = 45
        GROUP BY s.nombre, s.id_sede) c ON c.nombre = a.nombre
		-- GRAND TOTAL
		LEFT JOIN (
		SELECT '1' opt, SUM(aa.total + bb.contratado) finalTotal, SUM(aa.totalLotes + bb.totalContratados) finalTotalLotes FROM (
		SELECT '1' nombre, SUM(ISNULL(l.totalNeto2, l.total)) total, COUNT(*) totalLotes FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1 $filter
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
        WHERE l.status = 1) aa
		INNER JOIN (
		SELECT '1' nombre, SUM(ISNULL(l.totalNeto2, l.total)) contratado, COUNT(*) totalContratados FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1 $filter
        INNER JOIN (SELECT MAX(modificado) modificado, idStatusContratacion, idMovimiento, idLote, status, idCliente FROM historial_lotes 
        GROUP BY idStatusContratacion, idMovimiento, idLote, status, idCliente) hl ON hl.idLote = l.idLote AND hl.idStatusContratacion = 15 
        AND hl.idMovimiento = 45 AND hl.status = 1 AND hl.idCliente = cl.id_cliente
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
        WHERE l.status = 1 AND l.idStatusLote = 2 AND l.idStatusContratacion = 15 AND l.idMovimiento = 45) bb ON bb.nombre = aa.nombre GROUP BY aa.total, aa.totalLotes, bb.contratado, bb.totalContratados ) d ON d.opt = a.opt
		GROUP BY a.nombre, a.id_sede, c.contratado, c.totalContratados, 
        b.cancelado, b.totalCancelados, a.apartado, a.totalApartados, d.finalTotal, d.finalTotalLotes ORDER BY a.id_sede");
    }

    public function getInformationByManager($typeTransaction, $beginDate, $endDate, $currentYear, $plaza, $saleType) {
        if ($saleType == 1) $prospectingPlace = " AND cl.lugar_prospeccion != 6";
        else if ($saleType ==2) $prospectingPlace = " AND cl.lugar_prospeccion = 6";
        else $prospectingPlace = "";

        if ($typeTransaction == 1) { // MJ: Por año
            $filter = "AND YEAR(cl.fechaApartado) = $currentYear AND s.id_sede = '$plaza'";
        } else if ($typeTransaction == 2) { // MJ: Año y tipo de venta
            $filter = "AND YEAR(cl.fechaApartado) = $currentYear AND s.id_sede = '$plaza'" . $prospectingPlace;
        } else if ($typeTransaction == 3) { // MJ: Por fecha
            $filter = "AND cl.fechaApartado BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59' AND s.id_sede = '$plaza'";
        } else if ($typeTransaction == 4) { // MJ: Por fecha y por tipo de venta
            $filter = "AND cl.fechaApartado BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59' AND s.id_sede = '$plaza'" . $prospectingPlace;
        }

        return $this->db->query("SELECT UPPER(a.nombre) nombre, a.id_usuario id, '3' type, ISNULL(c.contratado, 0) contratado, ISNULL(c.totalContratados, 0) totalContratados, ISNULL(b.cancelado, 0) cancelado, ISNULL(b.totalCancelados, 0) totalCancelados, ISNULL(a.apartado, 0) apartado, ISNULL(a.totalApartados, 0) totalApartados,
		SUM(ISNULL(c.contratado, 0) + ISNULL(a.apartado, 0)) total, SUM(ISNULL(c.totalContratados, 0) + ISNULL(a.totalApartados, 0)) totalLotes,
		d.finalTotal, d.finalTotalLotes, ISNULL(CAST((c.contratado * 100) / d.finalTotal AS decimal(16,2)), 0) porcentajeContratado,
		ISNULL(CAST((a.apartado * 100) / d.finalTotal AS decimal(16,2)), 0) porcentajeApartado FROM (
	   -- APARTADO
		SELECT CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) nombre,
		uu.id_usuario, SUM(ISNULL(l.totalNeto2, l.total)) apartado, COUNT(*) totalApartados, '1' joption FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
		LEFT JOIN usuarios uu ON uu.id_usuario = cl.id_gerente
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
        WHERE l.status = 1
        $filter
        GROUP BY CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno), uu.id_usuario
	    ) a
		-- CANCELADO
        LEFT JOIN(
        SELECT CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) nombre, 
		uu.id_usuario, SUM(ISNULL(l.totalNeto2, l.total)) cancelado, COUNT(*) totalCancelados FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1
        INNER JOIN (SELECT MAX(modificado) modificado, idLote, status FROM historial_liberacion
        GROUP BY idLote, status) hl ON hl.idLote = l.idLote AND hl.status = 1
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
		LEFT JOIN usuarios uu ON uu.id_usuario = cl.id_gerente
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
        WHERE l.status = 1
        $filter
        GROUP BY CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno), uu.id_usuario) b ON b.nombre = a.nombre
		-- CONTRATADO
        LEFT JOIN(
		SELECT CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) nombre, 
		uu.id_usuario, SUM(ISNULL(l.totalNeto2, l.total)) contratado, COUNT(*) totalContratados FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1
        INNER JOIN (SELECT MAX(modificado) modificado, idStatusContratacion, idMovimiento, idLote, status, idCliente FROM historial_lotes 
        GROUP BY idStatusContratacion, idMovimiento, idLote, status, idCliente) hl ON hl.idLote = l.idLote AND hl.idStatusContratacion = 15 
        AND hl.idMovimiento = 45 AND hl.status = 1 AND hl.idCliente = cl.id_cliente
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
        LEFT JOIN usuarios uu ON uu.id_usuario = cl.id_gerente
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
        WHERE l.status = 1 AND l.idStatusLote = 2 AND l.idStatusContratacion = 15 AND l.idMovimiento = 45
        $filter
        GROUP BY CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno), uu.id_usuario) c ON c.nombre = a.nombre
		-- GRAND TOTAL
		LEFT JOIN (
		SELECT SUM(aa.total + bb.contratado) finalTotal, SUM(aa.totalLotes + bb.totalContratados) finalTotalLotes, '1' joption FROM (
		SELECT '1' nombre, SUM(ISNULL(l.totalNeto2, l.total)) total, COUNT(*) totalLotes FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
		LEFT JOIN usuarios uu ON uu.id_usuario = cl.id_gerente
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
        WHERE l.status = 1  $filter) aa
		INNER JOIN (
		SELECT '1' nombre, SUM(ISNULL(l.totalNeto2, l.total)) contratado, COUNT(*) totalContratados FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1
        INNER JOIN (SELECT MAX(modificado) modificado, idStatusContratacion, idMovimiento, idLote, status, idCliente FROM historial_lotes 
        GROUP BY idStatusContratacion, idMovimiento, idLote, status, idCliente) hl ON hl.idLote = l.idLote AND hl.idStatusContratacion = 15 
        AND hl.idMovimiento = 45 AND hl.status = 1 AND hl.idCliente = cl.id_cliente
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
        LEFT JOIN usuarios uu ON uu.id_usuario = cl.id_gerente
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
        WHERE l.status = 1 AND l.idStatusLote = 2 AND l.idStatusContratacion = 15 AND l.idMovimiento = 45
        $filter) bb ON bb.nombre = aa.nombre 
        GROUP BY aa.total, aa.totalLotes, bb.contratado, bb.totalContratados) d ON d.joption = a.joption
		GROUP BY a.nombre, a.id_usuario, c.contratado, c.totalContratados, b.cancelado, b.totalCancelados, a.apartado, a.totalApartados, d.finalTotal, d.finalTotalLotes");
    }

    public function getInformationByCoordinator($typeTransaction, $beginDate, $endDate, $currentYear, $manager, $saleType) {
        if ($saleType == 1) $prospectingPlace = " AND cl.lugar_prospeccion != 6";
        else if ($saleType ==2) $prospectingPlace = " AND cl.lugar_prospeccion = 6";
        else $prospectingPlace = "";

        if ($typeTransaction == 1) { // MJ: Por año
            $filter = "AND YEAR(cl.fechaApartado) = $currentYear AND cl.id_gerente = '$manager'";
        } else if ($typeTransaction == 2) { // MJ: Año y tipo de venta
            $filter = "AND YEAR(cl.fechaApartado) = $currentYear AND cl.id_gerente = '$manager'" . $prospectingPlace;
        } else if ($typeTransaction == 3) { // MJ: Por fecha
            $filter = "AND cl.fechaApartado BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59' AND cl.id_gerente = '$manager'";
        } else if ($typeTransaction == 4) { // MJ: Por fecha y por tipo de venta
            $filter = "AND cl.fechaApartado BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59' AND cl.id_gerente = '$manager'" . $prospectingPlace;
        }

        return $this->db->query("SELECT UPPER(a.nombre) nombre, a.id_usuario id, '4' type, ISNULL(c.contratado, 0) contratado,  ISNULL(c.totalContratados, 0) totalContratados, ISNULL(b.cancelado, 0) cancelado, ISNULL(b.totalCancelados, 0) totalCancelados, ISNULL(a.apartado, 0) apartado, ISNULL(a.totalApartados, 0) totalApartados,
		SUM(ISNULL(c.contratado, 0) + ISNULL(a.apartado, 0)) total, SUM(ISNULL(c.totalContratados, 0) + ISNULL(a.totalApartados, 0)) totalLotes,
		d.finalTotal, d.finalTotalLotes, ISNULL(CAST((c.contratado * 100) / d.finalTotal AS decimal(16,2)), 0) porcentajeContratado,
		ISNULL(CAST((a.apartado * 100) / d.finalTotal AS decimal(16,2)), 0) porcentajeApartado FROM (
		-- APARTADO
		SELECT (CASE cl.id_coordinador WHEN 0 THEN CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) 
		ELSE CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) END) nombre,
		(CASE cl.id_coordinador WHEN 0 THEN u.id_usuario
		ELSE uu.id_usuario END) id_usuario, SUM(ISNULL(l.totalNeto2, l.total)) apartado, COUNT(*) totalApartados, '1' joption FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1 $filter
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
		LEFT JOIN usuarios uu ON uu.id_usuario = cl.id_coordinador
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
        WHERE l.status = 1
        GROUP BY (CASE cl.id_coordinador WHEN 0 THEN CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) 
		ELSE CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) END),
		(CASE cl.id_coordinador WHEN 0 THEN u.id_usuario ELSE uu.id_usuario END)) a
		-- CANCELADO
        LEFT JOIN(
        SELECT (CASE cl.id_coordinador WHEN 0 THEN CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) 
		ELSE CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) END) nombre, 
		(CASE cl.id_coordinador WHEN 0 THEN u.id_usuario
		ELSE uu.id_usuario END) id_usuario, SUM(ISNULL(l.totalNeto2, l.total)) cancelado, COUNT(*) totalCancelados FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1 $filter
        INNER JOIN (SELECT MAX(modificado) modificado, idLote, status FROM historial_liberacion
        GROUP BY idLote, status) hl ON hl.idLote = l.idLote AND hl.status = 1
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
		LEFT JOIN usuarios uu ON uu.id_usuario = cl.id_coordinador
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
        WHERE l.status = 1
        GROUP BY (CASE cl.id_coordinador WHEN 0 THEN CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) 
		ELSE CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) END), 
		(CASE cl.id_coordinador WHEN 0 THEN u.id_usuario ELSE uu.id_usuario END)) b ON b.nombre = a.nombre
		-- CONTRATADO
		LEFT JOIN(
		SELECT (CASE cl.id_coordinador WHEN 0 THEN CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) 
		ELSE CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) END) nombre,
		(CASE cl.id_coordinador WHEN 0 THEN u.id_usuario
		ELSE uu.id_usuario END) id_usuario, SUM(ISNULL(l.totalNeto2, l.total)) contratado, COUNT(*) totalContratados FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1 $filter
        INNER JOIN (SELECT MAX(modificado) modificado, idStatusContratacion, idMovimiento, idLote, status, idCliente FROM historial_lotes 
        GROUP BY idStatusContratacion, idMovimiento, idLote, status, idCliente) hl ON hl.idLote = l.idLote AND hl.idStatusContratacion = 15 
        AND hl.idMovimiento = 45 AND hl.status = 1 AND hl.idCliente = cl.id_cliente
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
        LEFT JOIN usuarios uu ON uu.id_usuario = cl.id_coordinador
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
        WHERE l.status = 1 AND l.idStatusLote = 2 AND l.idStatusContratacion = 15 AND l.idMovimiento = 45
        GROUP BY (CASE cl.id_coordinador WHEN 0 THEN CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) 
		ELSE CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) END), (CASE cl.id_coordinador WHEN 0 THEN u.id_usuario
		ELSE uu.id_usuario END)) c ON c.nombre = a.nombre
		-- GRAND TOTAL
		LEFT JOIN (
		SELECT SUM(aa.total + bb.contratado) finalTotal, SUM(aa.totalLotes + bb.totalContratados) finalTotalLotes, '1' joption FROM (
		SELECT '1' nombre, SUM(ISNULL(l.totalNeto2, l.total)) total, COUNT(*) totalLotes FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1 $filter
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
		LEFT JOIN usuarios uu ON uu.id_usuario = cl.id_coordinador
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
        WHERE l.status = 1) aa
		INNER JOIN (
		SELECT '1' nombre, SUM(ISNULL(l.totalNeto2, l.total)) contratado, COUNT(*) totalContratados FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1 $filter
        INNER JOIN (SELECT MAX(modificado) modificado, idStatusContratacion, idMovimiento, idLote, status, idCliente FROM historial_lotes 
        GROUP BY idStatusContratacion, idMovimiento, idLote, status, idCliente) hl ON hl.idLote = l.idLote AND hl.idStatusContratacion = 15 
        AND hl.idMovimiento = 45 AND hl.status = 1 AND hl.idCliente = cl.id_cliente
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
        LEFT JOIN usuarios uu ON uu.id_usuario = cl.id_coordinador
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
        WHERE l.status = 1 AND l.idStatusLote = 2 AND l.idStatusContratacion = 15 AND l.idMovimiento = 45) bb ON bb.nombre = aa.nombre GROUP BY aa.total, aa.totalLotes, bb.contratado, bb.totalContratados) d ON d.joption = a.joption
		GROUP BY a.nombre, a.id_usuario, c.contratado, c.totalContratados, b.cancelado, b.totalCancelados, a.apartado, a.totalApartados, d.finalTotal, d.finalTotalLotes");
    }

    public function getInformationByAdviser($typeTransaction, $beginDate, $endDate, $currentYear, $coordinator, $saleType) {
        if ($saleType == 1) $prospectingPlace = " AND cl.lugar_prospeccion != 6";
        else if ($saleType ==2) $prospectingPlace = " AND cl.lugar_prospeccion = 6";
        else $prospectingPlace = "";

        if ($typeTransaction == 1) { // MJ: Por año
            $filter = "AND YEAR(cl.fechaApartado) = $currentYear AND (cl.id_coordinador = '$coordinator' OR cl.id_asesor = '$coordinator')";
        } else if ($typeTransaction == 2) { // MJ: Año y tipo de venta
            $filter = "AND YEAR(cl.fechaApartado) = $currentYear AND (cl.id_coordinador = '$coordinator' OR cl.id_asesor = '$coordinator')" . $prospectingPlace;
        } else if ($typeTransaction == 3) { // MJ: Por fecha
            $filter = "AND cl.fechaApartado BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59' AND (cl.id_coordinador = '$coordinator' OR cl.id_asesor = '$coordinator')";
        } else if ($typeTransaction == 4) { // MJ: Por fecha y por tipo de venta
            $filter = "AND cl.fechaApartado BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59' AND (cl.id_coordinador = '$coordinator' OR cl.id_asesor = '$coordinator')" . $prospectingPlace;
        }

        return $this->db->query("SELECT UPPER(a.nombre) nombre, a.id_usuario id, '5' type, ISNULL(c.contratado, 0) contratado, ISNULL(c.totalContratados, 0) totalContratados, ISNULL(b.cancelado, 0) cancelado, 
        ISNULL(b.totalCancelados, 0) totalCancelados, ISNULL(a.apartado, 0) apartado, ISNULL(a.totalApartados, 0) totalApartados, SUM(ISNULL(c.contratado, 0) + ISNULL(a.apartado, 0)) total, SUM(ISNULL(c.totalContratados, 0) + ISNULL(a.totalApartados, 0)) totalLotes,
		d.finalTotal, d.finalTotalLotes, ISNULL(CAST((c.contratado * 100) / d.finalTotal AS decimal(16,2)), 0) porcentajeContratado,
		ISNULL(CAST((a.apartado * 100) / d.finalTotal AS decimal(16,2)), 0) porcentajeApartado FROM (
		-- APARTADO
		SELECT CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre,
		u.id_usuario, SUM(ISNULL(l.totalNeto2, l.total)) apartado, COUNT(*) totalApartados, '1' joption FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1 $filter
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
        WHERE l.status = 1
        GROUP BY CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), u.id_usuario) a
		-- CANCELADO
        LEFT JOIN(
        SELECT CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre, 
		u.id_usuario, SUM(ISNULL(l.totalNeto2, l.total)) cancelado, COUNT(*) totalCancelados FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1 $filter
        INNER JOIN (SELECT MAX(modificado) modificado, idLote, status FROM historial_liberacion
        GROUP BY idLote, status) hl ON hl.idLote = l.idLote AND hl.status = 1
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
        WHERE l.status = 1 
        GROUP BY CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), u.id_usuario) b ON b.nombre = a.nombre
		-- CONTRATADO
        LEFT JOIN(
		SELECT CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre, 
		u.id_usuario, SUM(ISNULL(l.totalNeto2, l.total)) contratado, COUNT(*) totalContratados FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1 $filter
        INNER JOIN (SELECT MAX(modificado) modificado, idStatusContratacion, idMovimiento, idLote, status, idCliente FROM historial_lotes 
        GROUP BY idStatusContratacion, idMovimiento, idLote, status, idCliente) hl ON hl.idLote = l.idLote AND hl.idStatusContratacion = 15 
        AND hl.idMovimiento = 45 AND hl.status = 1 AND hl.idCliente = cl.id_cliente
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
        WHERE l.status = 1 AND l.idStatusLote = 2 AND l.idStatusContratacion = 15 AND l.idMovimiento = 45
        GROUP BY CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), u.id_usuario) c ON c.nombre = a.nombre
		-- GRAND TOTAL
		LEFT JOIN (
		SELECT SUM(aa.total + bb.contratado) finalTotal, SUM(aa.totalLotes + bb.totalContratados) finalTotalLotes, '1' joption FROM (
		-- APARTADO
		SELECT '1' nombre, SUM(ISNULL(l.totalNeto2, l.total)) total, COUNT(*) totalLotes FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1 $filter
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
        WHERE l.status = 1) aa
		-- CONTRATADO
		INNER JOIN (
		SELECT '1' nombre, SUM(ISNULL(l.totalNeto2, l.total)) contratado, COUNT(*) totalContratados FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1 $filter
        INNER JOIN (SELECT MAX(modificado) modificado, idStatusContratacion, idMovimiento, idLote, status, idCliente FROM historial_lotes 
        GROUP BY idStatusContratacion, idMovimiento, idLote, status, idCliente) hl ON hl.idLote = l.idLote AND hl.idStatusContratacion = 15 
        AND hl.idMovimiento = 45 AND hl.status = 1 AND hl.idCliente = cl.id_cliente
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
        WHERE l.status = 1 AND l.idStatusLote = 2 AND l.idStatusContratacion = 15 AND l.idMovimiento = 45)
		bb ON bb.nombre = aa.nombre GROUP BY aa.total, aa.totalLotes, bb.contratado, bb.totalContratados
		) d ON d.joption = a.joption
		GROUP BY a.nombre, a.id_usuario, c.contratado, c.totalContratados, b.cancelado, b.totalCancelados, a.apartado, a.totalApartados, d.finalTotal, d.finalTotalLotes");
    }

    public function getGeneralDetails($typeTransaction, $beginDate, $endDate, $currentYear, $id_sede, $saleType) {
        if ($saleType == 1) $prospectingPlace = " AND cl.lugar_prospeccion != 6";
        else if ($saleType ==2) $prospectingPlace = " AND cl.lugar_prospeccion = 6";
        else $prospectingPlace = "";

        if ($typeTransaction == 1) { // MJ: Por año
            $filter = "AND YEAR(cl.fechaApartado) = $currentYear";
        } else if ($typeTransaction == 2) { // MJ: Año y tipo de venta
            $filter = "AND YEAR(cl.fechaApartado) = $currentYear" . $prospectingPlace;
        } else if ($typeTransaction == 3) { // MJ: Por fecha
            $filter = "AND cl.fechaApartado BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
        } else if ($typeTransaction == 4) { // MJ: Por fecha y por tipo de venta
            $filter = "AND cl.fechaApartado BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'" . $prospectingPlace;
        }
        return $this->db->query("SELECT a.nombre, a.id_sede id, ISNULL(c.contratado, 0) contratado, ISNULL(c.totalContratados, 0) totalContratados, 
        ISNULL(b.cancelado, 0) cancelado, ISNULL(b.totalCancelados, 0) totalCancelados, ISNULL(a.apartado, 0) apartado, ISNULL(a.totalApartados, 0) totalApartados FROM (
		-- APARTADOS
		SELECT ss.nombre, ss.id_sede, SUM(ISNULL(l.totalNeto2, l.total)) apartado, COUNT(*) totalApartados FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1 $filter
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
		INNER JOIN condominios cn ON cn.idCondominio = l.idCondominio
		INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
		INNER JOIN sedes ss ON ss.id_sede = r.sede_residencial
        WHERE l.status = 1 
        GROUP BY ss.nombre, ss.id_sede) a
		-- CANCELADOS
        LEFT JOIN(
        SELECT ss.nombre, ss.id_sede, SUM(ISNULL(l.totalNeto2, l.total)) cancelado, COUNT(*) totalCancelados FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1 $filter
        INNER JOIN (SELECT MAX(modificado) modificado, idLote, status FROM historial_liberacion
        GROUP BY idLote, status) hl ON hl.idLote = l.idLote AND hl.status = 1
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
		INNER JOIN condominios cn ON cn.idCondominio = l.idCondominio
		INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
		INNER JOIN sedes ss ON ss.id_sede = r.sede_residencial
        WHERE l.status = 1 
        GROUP BY ss.nombre, ss.id_sede) b ON b.nombre = a.nombre
		-- CONTRATADOS
        LEFT JOIN(
		SELECT ss.nombre, ss.id_sede, SUM(ISNULL(l.totalNeto2, l.total)) contratado, COUNT(*) totalContratados FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1 $filter
        INNER JOIN (SELECT MAX(modificado) modificado, idStatusContratacion, idMovimiento, idLote, status, idCliente FROM historial_lotes 
        GROUP BY idStatusContratacion, idMovimiento, idLote, status, idCliente) hl ON hl.idLote = l.idLote AND hl.idStatusContratacion = 15 
        AND hl.idMovimiento = 45 AND hl.status = 1 AND hl.idCliente = cl.id_cliente
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
		INNER JOIN condominios cn ON cn.idCondominio = l.idCondominio
		INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
		INNER JOIN sedes ss ON ss.id_sede = r.sede_residencial
        WHERE l.status = 1 AND l.idStatusLote = 2 AND l.idStatusContratacion = 15 AND l.idMovimiento = 45
        GROUP BY ss.nombre, ss.id_sede
        ) c ON c.nombre = a.nombre
		ORDER BY a.id_sede");
    }

    public function getDetailsByManager($typeTransaction, $beginDate, $endDate, $currentYear, $id_gerente, $saleType) {
        if ($saleType == 1) $prospectingPlace = " AND cl.lugar_prospeccion != 6";
        else if ($saleType ==2) $prospectingPlace = " AND cl.lugar_prospeccion = 6";
        else $prospectingPlace = "";

        if ($typeTransaction == 1) { // MJ: Por año
            $filter = "AND YEAR(cl.fechaApartado) = $currentYear";
        } else if ($typeTransaction == 2) { // MJ: Año y tipo de venta
            $filter = "AND YEAR(cl.fechaApartado) = $currentYear" . $prospectingPlace;
        } else if ($typeTransaction == 3) { // MJ: Por fecha
            $filter = "AND cl.fechaApartado BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
        } else if ($typeTransaction == 4) { // MJ: Por fecha y por tipo de venta
            $filter = "AND cl.fechaApartado BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'" . $prospectingPlace;
        }

        return $this->db->query("SELECT a.nombre, ISNULL(c.contratado, 0) contratado, ISNULL(c.totalContratados, 0) totalContratados, 
        ISNULL(b.cancelado, 0) cancelado, ISNULL(b.totalCancelados, 0) totalCancelados, 
		ISNULL(a.apartado, 0) apartado, ISNULL(a.totalApartados, 0) totalApartados FROM (
	   -- APARTADO
		SELECT ss.nombre, ss.id_sede, SUM(ISNULL(l.totalNeto2, l.total)) apartado, COUNT(*) totalApartados FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1 AND cl.id_gerente = $id_gerente
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
		LEFT JOIN usuarios uu ON uu.id_usuario = cl.id_gerente
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
		INNER JOIN condominios cn ON cn.idCondominio = l.idCondominio
		INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
		INNER JOIN sedes ss ON ss.id_sede = r.sede_residencial
        WHERE l.status = 1
        $filter
        GROUP BY ss.nombre, ss.id_sede) a
		-- CANCELADO
        LEFT JOIN(
        SELECT ss.nombre, ss.id_sede, SUM(ISNULL(l.totalNeto2, l.total)) cancelado, COUNT(*) totalCancelados FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1 AND cl.id_gerente = $id_gerente
        INNER JOIN (SELECT MAX(modificado) modificado, idLote, status FROM historial_liberacion
        GROUP BY idLote, status) hl ON hl.idLote = l.idLote AND hl.status = 1
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
		LEFT JOIN usuarios uu ON uu.id_usuario = cl.id_gerente
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
		INNER JOIN condominios cn ON cn.idCondominio = l.idCondominio
		INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
		INNER JOIN sedes ss ON ss.id_sede = r.sede_residencial
        WHERE l.status = 1 
        $filter
        GROUP BY ss.nombre, ss.id_sede) b ON b.nombre = a.nombre
		-- CONTRATADO
        LEFT JOIN(
		SELECT ss.nombre, ss.id_sede, SUM(ISNULL(l.totalNeto2, l.total)) contratado, COUNT(*) totalContratados FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1 AND cl.id_gerente = $id_gerente
        INNER JOIN (SELECT MAX(modificado) modificado, idStatusContratacion, idMovimiento, idLote, status, idCliente FROM historial_lotes 
        GROUP BY idStatusContratacion, idMovimiento, idLote, status, idCliente) hl ON hl.idLote = l.idLote AND hl.idStatusContratacion = 15 
        AND hl.idMovimiento = 45 AND hl.status = 1 AND hl.idCliente = cl.id_cliente
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
        LEFT JOIN usuarios uu ON uu.id_usuario = cl.id_gerente
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
		INNER JOIN condominios cn ON cn.idCondominio = l.idCondominio
		INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
		INNER JOIN sedes ss ON ss.id_sede = r.sede_residencial
        WHERE l.status = 1 AND l.idStatusLote = 2 AND l.idStatusContratacion = 15 AND l.idMovimiento = 45
        $filter
        GROUP BY ss.nombre, ss.id_sede) c ON c.nombre = a.nombre");
    }

    public function getDetailsByCoordinator($typeTransaction, $beginDate, $endDate, $currentYear, $id_coordinador, $id_gerente, $saleType) {
        if ($saleType == 1) $prospectingPlace = " AND cl.lugar_prospeccion != 6";
        else if ($saleType ==2) $prospectingPlace = " AND cl.lugar_prospeccion = 6";
        else $prospectingPlace = "";

        if ($typeTransaction == 1) { // MJ: Por año
            $filter = "AND YEAR(cl.fechaApartado) = $currentYear";
        } else if ($typeTransaction == 2) { // MJ: Año y tipo de venta
            $filter = "AND YEAR(cl.fechaApartado) = $currentYear" . $prospectingPlace;
        } else if ($typeTransaction == 3) { // MJ: Por fecha
            $filter = "AND cl.fechaApartado BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
        } else if ($typeTransaction == 4) { // MJ: Por fecha y por tipo de venta
            $filter = "AND cl.fechaApartado BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'" . $prospectingPlace;
        }
        return $this->db->query("SELECT a.nombre, ISNULL(c.contratado, 0) contratado, ISNULL(c.totalContratados, 0) totalContratados, 
        ISNULL(b.cancelado, 0) cancelado, ISNULL(b.totalCancelados, 0) totalCancelados, 
		ISNULL(a.apartado, 0) apartado, ISNULL(a.totalApartados, 0) totalApartados FROM (
		-- APARTADO
		SELECT ss.nombre, ss.id_sede, SUM(ISNULL(l.totalNeto2, l.total)) apartado, COUNT(*) totalApartados FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1 AND cl.id_gerente = $id_gerente AND (cl.id_asesor = $id_coordinador OR cl.id_coordinador = $id_coordinador) $filter
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
		LEFT JOIN usuarios uu ON uu.id_usuario = cl.id_coordinador
        INNER JOIN sedes s ON CAST(s.id_sede AS VARCHAR(45)) = CAST(u.id_sede AS VARCHAR(45))
		INNER JOIN condominios cn ON cn.idCondominio = l.idCondominio
		INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
		INNER JOIN sedes ss ON ss.id_sede = r.sede_residencial
        WHERE l.status = 1
        GROUP BY ss.nombre, ss.id_sede) a
		-- CANCELADO
        LEFT JOIN(
        SELECT ss.nombre, ss.id_sede, SUM(ISNULL(l.totalNeto2, l.total)) cancelado, COUNT(*) totalCancelados FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1 AND cl.id_gerente = $id_gerente AND (cl.id_asesor = $id_coordinador OR cl.id_coordinador = $id_coordinador) $filter
        INNER JOIN (SELECT MAX(modificado) modificado, idLote, status FROM historial_liberacion
        GROUP BY idLote, status) hl ON hl.idLote = l.idLote AND hl.status = 1
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
		LEFT JOIN usuarios uu ON uu.id_usuario = cl.id_coordinador
        INNER JOIN sedes s ON CAST(s.id_sede AS VARCHAR(45)) = CAST(u.id_sede AS VARCHAR(45))
		INNER JOIN condominios cn ON cn.idCondominio = l.idCondominio
		INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
		INNER JOIN sedes ss ON ss.id_sede = r.sede_residencial
        WHERE l.status = 1 
        GROUP BY ss.nombre, ss.id_sede) b ON b.nombre = a.nombre
		-- CONTRATADO
		LEFT JOIN(
		SELECT ss.nombre, ss.id_sede, SUM(ISNULL(l.totalNeto2, l.total)) contratado, COUNT(*) totalContratados FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1 AND cl.id_gerente = $id_gerente AND (cl.id_asesor = $id_coordinador OR cl.id_coordinador = $id_coordinador) $filter
        INNER JOIN (SELECT MAX(modificado) modificado, idStatusContratacion, idMovimiento, idLote, status, idCliente FROM historial_lotes 
        GROUP BY idStatusContratacion, idMovimiento, idLote, status, idCliente) hl ON hl.idLote = l.idLote AND hl.idStatusContratacion = 15 
        AND hl.idMovimiento = 45 AND hl.status = 1 AND hl.idCliente = cl.id_cliente
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
        LEFT JOIN usuarios uu ON uu.id_usuario = cl.id_coordinador
        INNER JOIN sedes s ON CAST(s.id_sede AS VARCHAR(45)) = CAST(u.id_sede AS VARCHAR(45))
		INNER JOIN condominios cn ON cn.idCondominio = l.idCondominio
		INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
		INNER JOIN sedes ss ON ss.id_sede = r.sede_residencial
        WHERE l.status = 1 AND l.idStatusLote = 2 AND l.idStatusContratacion = 15 AND l.idMovimiento = 45
        GROUP BY ss.nombre, ss.id_sede) c ON c.nombre = a.nombre");
    }

    public function getDetailsByAdviser($typeTransaction, $beginDate, $endDate, $currentYear, $id_asesor, $saleType) {
        if ($saleType == 1) $prospectingPlace = " AND cl.lugar_prospeccion != 6";
        else if ($saleType ==2) $prospectingPlace = " AND cl.lugar_prospeccion = 6";
        else $prospectingPlace = "";

        if ($typeTransaction == 1) { // MJ: Por año
            $filter = "AND YEAR(cl.fechaApartado) = $currentYear";
        } else if ($typeTransaction == 2) { // MJ: Año y tipo de venta
            $filter = "AND YEAR(cl.fechaApartado) = $currentYear" . $prospectingPlace;
        } else if ($typeTransaction == 3) { // MJ: Por fecha
            $filter = "AND cl.fechaApartado BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
        } else if ($typeTransaction == 4) { // MJ: Por fecha y por tipo de venta
            $filter = "AND cl.fechaApartado BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'" . $prospectingPlace;
        }
        return $this->db->query("SELECT a.nombre, ISNULL(c.contratado, 0) contratado, ISNULL(c.totalContratados, 0) totalContratados, 
        ISNULL(b.cancelado, 0) cancelado, ISNULL(b.totalCancelados, 0) totalCancelados, 
		ISNULL(a.apartado, 0) apartado, ISNULL(a.totalApartados, 0) totalApartados FROM (
		-- APARTADO
		SELECT ss.nombre, ss.id_sede, SUM(ISNULL(l.totalNeto2, l.total)) apartado, COUNT(*) totalApartados, '1' joption FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1 AND cl.id_asesor = $id_asesor $filter
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
		INNER JOIN condominios cn ON cn.idCondominio = l.idCondominio
		INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
		INNER JOIN sedes ss ON ss.id_sede = r.sede_residencial
        WHERE l.status = 1
        GROUP BY ss.nombre, ss.id_sede) a
		-- CANCELADO
        LEFT JOIN(
        SELECT ss.nombre, ss.id_sede, SUM(ISNULL(l.totalNeto2, l.total)) cancelado, COUNT(*) totalCancelados FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1 AND cl.id_asesor = $id_asesor $filter
        INNER JOIN (SELECT MAX(modificado) modificado, idLote, status FROM historial_liberacion
        GROUP BY idLote, status) hl ON hl.idLote = l.idLote AND hl.status = 1
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
		INNER JOIN condominios cn ON cn.idCondominio = l.idCondominio
		INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
		INNER JOIN sedes ss ON ss.id_sede = r.sede_residencial
        WHERE l.status = 1 
        GROUP BY ss.nombre, ss.id_sede) b ON b.nombre = a.nombre
		-- CONTRATADO
        LEFT JOIN(
		SELECT ss.nombre, ss.id_sede, SUM(ISNULL(l.totalNeto2, l.total)) contratado, COUNT(*) totalContratados FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1 AND cl.id_asesor = $id_asesor $filter
        INNER JOIN (SELECT MAX(modificado) modificado, idStatusContratacion, idMovimiento, idLote, status, idCliente FROM historial_lotes 
        GROUP BY idStatusContratacion, idMovimiento, idLote, status, idCliente) hl ON hl.idLote = l.idLote AND hl.idStatusContratacion = 15 
        AND hl.idMovimiento = 45 AND hl.status = 1 AND hl.idCliente = cl.id_cliente
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
		INNER JOIN condominios cn ON cn.idCondominio = l.idCondominio
		INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
		INNER JOIN sedes ss ON ss.id_sede = r.sede_residencial
        WHERE l.status = 1 AND l.idStatusLote = 2 AND l.idStatusContratacion = 15 AND l.idMovimiento = 45
        GROUP BY ss.nombre, ss.id_sede) c ON c.nombre = a.nombre");
    }

}
