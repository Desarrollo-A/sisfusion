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

    public function getProspectsByUserSessioned($id_asesor){
        $query = $this->db->query("SELECT COUNT(id_prospecto) as prospectos FROM prospectos WHERE id_asesor=$id_asesor");
        return $query->result_array();
    }

    public function getDataBetweenDates($fecha_inicio, $fecha_fin, $typeTransaction){
        $condicionalPR= '';
        $condicionalCL= '';
        $id_usuario = $this->session->userdata('id_usuario');


        if($typeTransaction == 1){ #Filtro que solo muestra los del usuario sesionado
            $condicionalPR = 'AND id_asesor='.$id_usuario;
            $condicionalCL = 'AND cl.id_asesor='.$id_usuario;
        }else if($typeTransaction == 2){#Filtro que solo muestra los de todos los asesres
            $condicionalPR = 'AND id_coordinador='.$id_usuario;
            $condicionalCL = 'AND cl.id_coordinador='.$id_usuario;
        }else if($typeTransaction == 3){ #Filtro que muestra los propios y los asesores
            $condicionalPR = 'OR id_asesor='.$id_usuario." OR id_coordinador=".$id_usuario;
            $condicionalCL = 'OR cl.id_asesor='.$id_usuario." OR cl.id_coordinador=".$id_usuario;
        }else{
            $condicionalPR= '';
            $condicionalCL= '';
        }
        $query = $this->db->query("
        SELECT ISNULL(COUNT(id_prospecto), 0) as numerosTotales, 'prospectos_totales' as 'queryType' FROM prospectos 
        WHERE fecha_creacion>'$fecha_inicio 00:00:00.000' AND fecha_creacion<'$fecha_fin  23:59:59.000' $condicionalPR 
            UNION ALL 
        SELECT ISNULL(COUNT(id_prospecto), 0) as numerosTotales, 'prospectos_nuevos' as 'queryType' FROM prospectos 
        WHERE tipo=0 AND fecha_creacion>'$fecha_inicio 00:00:00.000' AND fecha_creacion<'$fecha_fin  23:59:59.000' $condicionalPR        
            UNION ALL 
        SELECT ISNULL(COUNT(*),0) as numerosTotales, 'ventas_apartados' as 'queryType' FROM clientes 
        WHERE fechaApartado BETWEEN '$fecha_inicio 00:00:00.000' AND '$fecha_fin 23:59:59.000' AND status = 1 $condicionalPR
            UNION ALL 
        SELECT ISNULL(COUNT(*), 0)
        numerosTotales, 'cancelados_apartados' as 'queryType' FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote
        INNER JOIN historial_liberacion hl ON hl.idLote = lo.idLote
        INNER JOIN historial_lotes hl2 ON hl2.idLote =  lo.idLote AND hl2.idCliente = cl.id_cliente AND hl2.idStatusContratacion = 1 AND hl2.idMovimiento = 31
        WHERE cl.fechaApartado BETWEEN '$fecha_inicio 00:00:00.000' AND '$fecha_fin 23:59:59.000' AND cl.status = 0
        AND cl.noRecibo != 'CANCELADO' $condicionalCL
            UNION ALL 
        SELECT SUM (total) numerosTotales, 'cierres_totales' as 'queryType' FROM (
        SELECT ISNULL(COUNT(*),0)
        total FROM clientes 
        WHERE fechaApartado BETWEEN '$fecha_inicio 00:00:00.000' AND '$fecha_fin 23:59:59.000' AND status = 1 $condicionalPR
        --GROUP BY id_asesor
        UNION ALL
        SELECT ISNULL(COUNT(*),0)
        total FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idCliente = cl.id_cliente AND lo.idStatusContratacion = 15 AND lo.idMovimiento = 45 AND lo.idStatusLote = 2
        INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 15 AND idMovimiento = 45 GROUP BY idLote, idCliente) hl ON hl.idLote = lo.idLote AND hl.idCliente = cl.id_cliente
        AND hl.modificado BETWEEN '$fecha_inicio 00:00:00.000' AND '$fecha_fin 23:59:59.000'
        WHERE cl.status = 1 $condicionalCL 
        --GROUP BY cl.id_asesor
        ) result
            UNION ALL 
        SELECT 0 AS numerosTotales, 'prospectos_cita' as 'queryType'
            UNION ALL
        SELECT COUNT(*) ventas_contratadas, 'ventas_contratadas' AS 'queryType' FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idCliente = cl.id_cliente AND lo.idStatusContratacion = 15 AND lo.idMovimiento = 45 AND lo.idStatusLote = 2
        INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 15 AND idMovimiento = 45 GROUP BY idLote, idCliente) hl ON hl.idLote = lo.idLote AND hl.idCliente = cl.id_cliente
        AND hl.modificado BETWEEN '$fecha_inicio 00:00:00.000' AND '$fecha_fin 23:59:59.000'
        WHERE cl.status = 1 $condicionalCL
            UNION ALL 
        SELECT COUNT(*) contratos_cancelados, 'contratos_cancelados' AS 'queryType' FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote
        INNER JOIN (SELECT idLote, MAX(modificado) modificado FROM historial_liberacion GROUP BY idLote) hl ON hl.idLote = lo.idLote AND hl.modificado BETWEEN '$fecha_inicio 00:00:00.000' AND '$fecha_fin 23:59:59.000'
        INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 15 AND idMovimiento = 45 GROUP BY idLote, idCliente) hl2 ON hl2.idLote = lo.idLote AND hl2.idCliente = cl.id_cliente
        WHERE cl.status = 0 $condicionalCL
        ");
        return $query->result_array();
    }


    public function totalVentasData(){
        $query = $this->db->query("
        SELECT /*UPPER(a.nombre) nombre, a.id_sede id, '2' type, */
		FORMAT(ISNULL(a.apartado, 0), 'C') ventas_apartadas, ISNULL(a.totalApartados, 0) totalApartados,
		FORMAT(ISNULL(c.contratado, 0), 'C') ventas_contratadas, ISNULL(c.totalContratados, 0) totalContratados, 
		FORMAT(ISNULL(b.canceladoContratado, 0), 'C') canceladoContratados, ISNULL(b.totalCanceladosContratados, 0) totalCanceladosContratados, 
		FORMAT(ISNULL(d.canceladoTotal, 0) - ISNULL(b.canceladoContratado, 0), 'C') canceladoApartados, ISNULL(d.totalCancelados, 0) - ISNULL(b.totalCanceladosContratados, 0) totalApartados, 
		ISNULL(CAST((c.contratado * 100) / a.apartado AS decimal(16,2)), 0) porcentajeContratado,
		ISNULL(CAST((b.canceladoContratado * 100) / a.apartado AS decimal(16,2)), 0) porcentajeCanceladoApartado,
		ISNULL(CAST(((d.canceladoTotal - b.canceladoContratado) * 100) / a.apartado AS decimal(16,2)), 0) porcentajeCanceladoContratado,
		100 - (ISNULL(CAST((c.contratado * 100) / a.apartado AS decimal(16,2)), 0) + ISNULL(CAST((d.canceladoTotal * 100) / a.apartado AS decimal(16,2)), 0)) porcentajeApartado
		FROM (
		-- VENTAS APARTADAS
		SELECT /*s.nombre, s.id_sede,*/ SUM(ISNULL(l.totalNeto2, l.total)) apartado, COUNT(*) totalApartados, '1' opt FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1 AND YEAR(cl.fechaApartado) = 2022
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
        WHERE l.status = 1
        /*GROUP BY s.nombre, s.id_sede*/) a
		-- CANCELADOS CONTRATADOS
        LEFT JOIN(
        SELECT /*s.nombre,*/ SUM(ISNULL(l.totalNeto2, l.total)) canceladoContratado, COUNT(*) totalCanceladosContratados, '1' opt FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1 AND YEAR(cl.fechaApartado) = 2022
        INNER JOIN (SELECT MAX(modificado) modificado, idLote, status FROM historial_liberacion
        GROUP BY idLote, status) hl ON hl.idLote = l.idLote AND hl.status = 1
		INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes 
		WHERE idStatusContratacion = 15 AND idMovimiento = 45 AND status = 1 GROUP BY idLote, idCliente) hl2 ON hl2.idLote = l.idLote 
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
        WHERE l.status = 1
        /*GROUP BY s.nombre, s.id_sede*/) b ON b.opt = a.opt
		-- VENTAS CONTRATADAS
        LEFT JOIN(
		SELECT /*s.nombre, s.id_sede,*/ SUM(ISNULL(l.totalNeto2, l.total)) contratado, COUNT(*) totalContratados, '1' opt FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1 AND YEAR(cl.fechaApartado) = 2022
        INNER JOIN (SELECT MAX(modificado) modificado, idStatusContratacion, idMovimiento, idLote, status, idCliente FROM historial_lotes 
        GROUP BY idStatusContratacion, idMovimiento, idLote, status, idCliente) hl ON hl.idLote = l.idLote AND hl.idStatusContratacion = 15 
        AND hl.idMovimiento = 45 AND hl.status = 1 AND hl.idCliente = cl.id_cliente
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
        WHERE l.status = 1 AND l.idStatusLote = 2 AND l.idStatusContratacion = 15 AND l.idMovimiento = 45
        /*GROUP BY s.nombre, s.id_sede*/) c ON c.opt = a.opt
		-- GRAND TOTAL CANCELADOS
		LEFT JOIN(
        SELECT /*s.nombre,*/ SUM(ISNULL(l.totalNeto2, l.total)) canceladoTotal, COUNT(*) totalCancelados, '1' opt FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1 AND YEAR(cl.fechaApartado) = 2022
        INNER JOIN (SELECT MAX(modificado) modificado, idLote, status FROM historial_liberacion
        GROUP BY idLote, status) hl ON hl.idLote = l.idLote AND hl.status = 1
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
        WHERE l.status = 1
        /*GROUP BY s.nombre, s.id_sede*/) d ON d.opt = c.opt
		/*GROUP BY a.nombre, a.id_sede, c.contratado, c.totalContratados, 
        b.canceladoContratado, b.totalCanceladosContratados, a.apartado, a.totalApartados, d.canceladoTotal, d.totalCancelados ORDER BY a.id_sede*/
        ");
        return $query->result_array();
    }

    public function getProspectsByYear(){
        $year = date("Y");
        $id_usuario = $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT DATENAME(month,fecha_creacion) MONTH, COUNT(*) FROM prospectos 
        WHERE YEAR(fecha_creacion) = '2021' AND id_asesor = $id_usuario
        GROUP BY DATENAME(month,fecha_creacion), MONTH(fecha_creacion)
        ORDER BY MONTH(fecha_creacion)");
        return $query->result_array();
    }


}
