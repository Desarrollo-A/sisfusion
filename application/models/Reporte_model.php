<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reporte_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
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
}
