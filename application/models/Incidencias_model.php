<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Incidencias_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
 
    public function getInCommissions($idlote)
    {
        $query = $this->db-> query("(SELECT DISTINCT(l.idLote), l.idStatusContratacion, l.registro_comision, cl.id_cliente, 
 CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) nombre_cliente, l.nombreLote, l.idStatusContratacion, 
                res.nombreResidencial, cond.nombre as nombreCondominio, l.tipo_venta, l.referencia, vc.id_cliente AS compartida, l.totalNeto, 
                l.totalNeto2, l.plan_enganche, plane.nombre as enganche_tipo, cl.lugar_prospeccion,
                      ae.id_usuario as id_asesor, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ', ae.apellido_materno) as asesor,
                      co.id_usuario as id_coordinador, CONCAT(co.nombre, ' ', co.apellido_paterno, ' ', co.apellido_materno) as coordinador,
                      ge.id_usuario as id_gerente, CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ', ge.apellido_materno) as gerente,
                      su.id_usuario as id_subdirector, CONCAT(su.nombre, ' ', su.apellido_paterno, ' ', su.apellido_materno) as subdirector,
                      di.id_usuario as id_director, CONCAT(di.nombre, ' ', di.apellido_paterno, ' ', di.apellido_materno) as director, pc.fecha_modificacion,
                      (CASE WHEN cl.plan_comision IN (0) OR cl.plan_comision IS NULL THEN '-' ELSE pl.descripcion END) AS plan_descripcion,
                      convert(nvarchar, pc.fecha_modificacion, 6) date_final,
                      convert(nvarchar, pc.fecha_modificacion, 6)  fecha_sistema,
					  convert(nvarchar, pc.fecha_neodata, 6) fecha_neodata
                      FROM  lotes l
                      INNER JOIN  clientes cl ON cl.id_cliente = l.idCliente
                      INNER JOIN  condominios cond ON l.idCondominio=cond.idCondominio
                      INNER JOIN  residenciales res ON cond.idResidencial = res.idResidencial
                      LEFT JOIN  pago_comision pc ON pc.id_lote = l.idLote AND pc.bandera in (0)
                      LEFT JOIN  opcs_x_cats plane ON plane.id_opcion= l.plan_enganche AND plane.id_catalogo = 39
                      LEFT JOIN plan_comision pl ON pl.id_plan = cl.plan_comision
                      LEFT JOIN (SELECT id_cliente FROM ventas_compartidas WHERE estatus = 1) AS vc ON vc.id_cliente = cl.id_cliente
                      INNER JOIN  usuarios ae ON ae.id_usuario = cl.id_asesor
                      LEFT JOIN  usuarios co ON co.id_usuario = cl.id_coordinador
                      LEFT JOIN  usuarios ge ON ge.id_usuario = cl.id_gerente
                      LEFT JOIN  usuarios su ON su.id_usuario = cl.id_subdirector
                      LEFT JOIN  usuarios di ON di.id_usuario = su.id_lider
                      WHERE l.idStatusContratacion BETWEEN 9 AND 15 AND cl.status = 1 AND l.status = 1 AND l.idLote = $idlote)
                      UNION
                      (SELECT DISTINCT(l.idLote), l.idStatusContratacion, l.registro_comision, cl.id_cliente, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',
                      cl.apellido_materno) nombre_cliente, l.nombreLote, l.idStatusContratacion, 
                      res.nombreResidencial, cond.nombre as nombreCondominio, l.tipo_venta, l.referencia, vc.id_cliente AS compartida, l.totalNeto, 
                      l.totalNeto2, l.plan_enganche, plane.nombre as enganche_tipo, cl.lugar_prospeccion,
                      ae.id_usuario as id_asesor, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ', ae.apellido_materno) as asesor,
                      co.id_usuario as id_coordinador, CONCAT(co.nombre, ' ', co.apellido_paterno, ' ', co.apellido_materno) as coordinador,
                      ge.id_usuario as id_gerente, CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ', ge.apellido_materno) as gerente,
                      su.id_usuario as id_subdirector, CONCAT(su.nombre, ' ', su.apellido_paterno, ' ', su.apellido_materno) as subdirector,
                      di.id_usuario as id_director, CONCAT(di.nombre, ' ', di.apellido_paterno, ' ', di.apellido_materno) as director, 
                      pc.fecha_modificacion, 
                      (CASE WHEN cl.plan_comision IN (0) OR cl.plan_comision IS NULL THEN '-' ELSE pl.descripcion END) AS plan_descripcion,
                      convert(nvarchar, pc.fecha_modificacion, 6) date_final,
                      convert(nvarchar, pc.fecha_modificacion, 6)  fecha_sistema,
					  convert(nvarchar, pc.fecha_neodata, 6) fecha_neodata
                      FROM  lotes l
                      INNER JOIN  clientes cl ON cl.id_cliente = l.idCliente
                      INNER JOIN  condominios cond ON l.idCondominio=cond.idCondominio
                      INNER JOIN  residenciales res ON cond.idResidencial = res.idResidencial
                      LEFT JOIN  pago_comision pc ON pc.id_lote = l.idLote AND pc.bandera in (0)
                      LEFT JOIN  opcs_x_cats plane ON plane.id_opcion= l.plan_enganche AND plane.id_catalogo = 39
                      LEFT JOIN plan_comision pl ON pl.id_plan = cl.plan_comision
                      LEFT JOIN (SELECT id_cliente FROM ventas_compartidas WHERE estatus = 1) AS vc ON vc.id_cliente = cl.id_cliente
                      INNER JOIN  usuarios ae ON ae.id_usuario = cl.id_asesor
                      LEFT JOIN  usuarios co ON co.id_usuario = cl.id_coordinador
                      LEFT JOIN  usuarios ge ON ge.id_usuario = cl.id_gerente
                      LEFT JOIN  usuarios su ON su.id_usuario = cl.id_subdirector
                      LEFT JOIN  usuarios di ON di.id_usuario = su.id_lider
                      WHERE l.idStatusContratacion BETWEEN 9 AND 15 AND cl.status = 1 AND l.status = 1 AND l.idLote = $idlote
                      AND l.registro_comision in (0,8))");
        return $query->result();

    }


    function getUsuariosRol3($rol){

        $cmd = "SELECT id_usuario,CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) as name_user,id_lider FROM 
                usuarios WHERE estatus in (0,1,3) /*and forma_pago != 2*/ AND id_rol=$rol";

        return $this->db->query($cmd);
    }


}