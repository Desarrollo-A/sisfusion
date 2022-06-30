<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ranking_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getRankingApartados($beginDate, $endDate, $sede){
        return $this->db->query("SELECT COUNT(*) totalAT, id_asesor, tmpApT.nombreUsuario, tmpApT.id_rol FROM (
            SELECT  u.id_rol, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreUsuario, lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl ,lo.totalNeto2) totalNeto2, isNULL(cl.total_cl ,lo.total) total FROM clientes cl
            INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote != 2
            INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
            WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 1 AND cl.id_sede = $sede
            AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000'
            GROUP BY u.id_rol, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl ,lo.totalNeto2), isNULL(cl.total_cl ,lo.total)
        ) tmpApT GROUP BY id_asesor, tmpApT.nombreUsuario, tmpApT.id_rol
        ORDER BY totalAT DESC");
    }

    public function getRankingContratados($beginDate, $endDate, $sede){
        return $this->db->query("SELECT COUNT(*) totalConT, id_asesor, tmpConT.nombreUsuario, tmpConT.id_rol FROM (
            SELECT  u.id_rol, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreUsuario, lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl ,lo.totalNeto2) totalNeto2, isNULL(cl.total_cl ,lo.total) total FROM clientes cl
            INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote = 2
            INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
            INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 15 AND idMovimiento = 45
            GROUP BY idLote, idCliente) hl ON hl.idLote = lo.idLote AND hl.idCliente = cl.id_cliente
            WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 1 AND cl.id_sede = $sede
            AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000'
            GROUP BY u. id_rol, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), lo.idLote, lo.nombreLote, cl.id_cliente, cl.id_asesor, cl.id_coordinador, cl.id_gerente, cl.id_subdirector, cl.id_regional, cl.nombre, cl.apellido_paterno, cl.apellido_materno, isNULL(cl.totalNeto2_cl ,lo.totalNeto2), isNULL(cl.total_cl ,lo.total)
        )tmpConT GROUP BY id_asesor, tmpConT.nombreUsuario, tmpConT.id_rol
        ORDER BY totalConT DESC");
    }

    public function getRankingConEnganche($beginDate, $endDate, $sede){
        return  $this->db->query("SELECT COUNT (cl.id_asesor) cuantos, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor , cl.id_asesor FROM clientes cl 
        INNER JOIN lotes lo ON lo.idLote = cl.idLote AND (isNULL(cl.totalNeto_cl, lo.totalNeto) IS NOT NULL AND isNULL(cl.totalNeto_cl, lo.totalNeto) > 0.00)
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor AND u.estatus = 1
        WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 1 AND cl.id_sede = $sede
        AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000'
        GROUP BY CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), cl.id_asesor
        ORDER BY cuantos DESC");
    }

    public function getRankingSinEnganche($beginDate, $endDate, $sede){
        return  $this->db->query("SELECT COUNT (cl.id_asesor) cuantos, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor , cl.id_asesor FROM clientes cl 
        INNER JOIN lotes lo ON lo.idLote = cl.idLote AND (isNULL(cl.totalNeto_cl, lo.totalNeto) IS NULL OR isNULL(cl.totalNeto_cl, lo.totalNeto) = 0.00)
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor AND u.estatus = 1
        WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 1 AND cl.id_sede = $sede
        AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000'
        GROUP BY CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), cl.id_asesor
        ORDER BY cuantos DESC");
    }

    public function getSedes(){
        return $this->db->query("SELECT * FROM sedes WHERE estatus != 0");
    }
}
