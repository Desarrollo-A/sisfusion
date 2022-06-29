<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Metricas_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
    public function getSuperficieVendida($data = null){
        $year = date("Y");
        $query = $this->db->query("SELECT COUNT(lo.sup) cantidad, lo.sup superficie,  
        FORMAT(SUM(
            CASE 
                WHEN isNULL(cl.totalNeto2_cl ,lo.totalNeto2) IS NULL THEN isNULL(cl.total_cl, lo.total)
                WHEN isNULL(cl.totalNeto2_cl ,lo.totalNeto2) = 0 THEN isNULL(cl.total_cl, lo.total)
                ELSE isNULL(cl.totalNeto2_cl ,lo.totalNeto2) 
            END), 'C') suma FROM clientes cl 
        INNER JOIN lotes lo ON lo.idCliente = cl.id_cliente
        WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 1 AND YEAR(cl.fechaApartado)= $year
        GROUP BY lo.sup
        ORDER BY cantidad DESC");
        return $query->result_array();
    }

    public function getDisponibilidadProyecto($data = null){
        $query = $this->db->query("SELECT re.nombreResidencial,  CAST(re.descripcion as varchar(max)) descripcion, COUNT(lo.idLote) totales, COUNT(lot.idLote) ocupados, (COUNT(lo.idLote) -  COUNT(lot.idLote)) restante  FROM lotes lo
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = con.idResidencial
        LEFT JOIN lotes lot ON lot.idLote = lo.idLote AND lot.idStatusLote != 1 AND lot.status = 1
        WHERE lo.status = 1
        GROUP BY nombreResidencial, CAST(re.descripcion as varchar(max))
        ORDER BY restante DESC");
        return $query->result_array();
    }

    public function getVentasM2($ídCondo){
        $year = date("Y");
        $query = $this->db->query("SELECT lo.sup,FORMAT(ISNULL(lo.precio, 0), 'C'), COUNT(lo.idLote) cantidad FROM clientes cl
        INNER JOIN lotes lo ON lo.idCliente = cl.id_cliente AND lo.idCondominio = $ídCondo
        WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 1 AND YEAR(cl.fechaApartado)= $year
        GROUP BY lo.sup, lo.precio
        ORDER BY lo.sup DESC");
        return $query->result_array();
    }

    public function getLugarProspeccion($data = null){
        $year = date("Y");
        $query = $this->db->query("SELECT s.nombre, COUNT(pros.id_prospecto) prospectos, COUNT(cl.id_cliente) clientes FROM sedes s
        INNER JOIN prospectos pros ON pros.id_sede =s.id_sede
        LEFT JOIN (SELECT id_sede, id_cliente, id_prospecto FROM clientes WHERE status = 1) cl ON cl.id_prospecto = pros.id_prospecto
        WHERE pros.estatus = 1 AND YEAR(pros.fecha_creacion)= $year
        GROUP BY s.nombre
        ORDER BY prospectos DESC");
        return $query->result_array();
    }

    public function getMedioProspeccion($data = null){
        $year = date("Y");
        $query = $this->db->query("SELECT oxc.nombre,pros.lugar_prospeccion, COUNT(*) cantidad FROM prospectos pros
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pros.lugar_prospeccion AND oxc.id_catalogo = 9 AND oxc.estatus = 1
        WHERE pros.estatus = 1 AND YEAR(pros.fecha_creacion)= $year
        GROUP BY oxc.nombre,pros.lugar_prospeccion
        ORDER BY cantidad DESC");
        return $query->result_array();
    }

    public function getProyectos(){
        $query = $this->db->query("SELECT * FROM residenciales WHERE status = 1");
        return $query->result_array();
    }

    public function getCondominios($idProyecto){
        $query = $this->db->query("SELECT * FROM condominios WHERE idResidencial=$idProyecto AND status = 1");
        return $query->result_array();
    }

}
