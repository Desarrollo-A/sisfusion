<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Liberaciones_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }

    public function lista_proyectos(){
        return $this->db->query("SELECT * FROM residenciales WHERE status = 1");
    }

    function lista_condominios($proyecto){
        return $this->db->query("SELECT * FROM condominios WHERE status = 1 AND idResidencial = ".$proyecto."");
    }

    function lista_lotes($condominio, $tipoVenta){
        return $this->db->query(
            "WITH proceso_liberacion_temp AS (SELECT *, ROW_NUMBER() OVER(PARTITION BY idLote ORDER BY fecha_creacion DESC) AS rn FROM proceso_liberaciones)
            SELECT lo.idLote, lo.nombreLote
            FROM lotes AS lo
                LEFT JOIN clientes AS cl ON cl.id_cliente = lo.idCliente
                LEFT JOIN condominios AS co ON lo.idCondominio = co.idCondominio
                LEFT JOIN residenciales AS re ON co.idResidencial = re.idResidencial
                LEFT JOIN proceso_liberacion_temp AS pl ON pl.idLote = lo.idLote AND rn = 1
            WHERE lo.tipo_venta = ? AND cl.status = 1 AND lo.idStatusContratacion IN (9,10,13,14,15) AND lo.idCondominio = ? AND pl.idLote IS NULL
            ORDER BY pl.proceso_lib DESC;", array($tipoVenta, $condominio));
    }
    
    public function getLotesParaLiberacion($idProcesoTipoLiberacion, $tipoVenta, $condicion) 
    {
        ini_set('memory_limit', -1);
        $query = $this->db->query(
        "WITH proceso_liberacion_temp AS (SELECT *, ROW_NUMBER() OVER(PARTITION BY idLote ORDER BY fecha_creacion DESC) AS rn FROM proceso_liberaciones)
        SELECT re.nombreResidencial, co.nombre AS nombreCondominio, lo.nombreLote, lo.idLote, co.idCondominio, re.idResidencial, lo.idCliente,
			CONVERT(VARCHAR, cl.fechaApartado, 20) as fechaApartado, UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) AS cliente,
			lo.precio, lo.sup, (ISNULL(lo.totalNeto2, 0.00) / lo.sup) costom2f, ISNULL(lo.totalNeto2, 0.00) total, lo.referencia,
            CASE WHEN u0.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) END nombreAsesor,
            CASE WHEN u1.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) END nombreCoordinador,
            CASE WHEN u2.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) END nombreGerente,
            CASE WHEN u3.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) END nombreSubdirector,
            CASE WHEN u4.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) END nombreRegional,
            CASE WHEN u5.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u5.nombre, ' ', u5.apellido_paterno, ' ', u5.apellido_materno)) END nombreRegional2, 
            CASE WHEN pl.idLote IS NOT NULL THEN pl.proceso_lib ELSE '0' END enProcesoLiberacion, CASE WHEN oxc.nombre IS NOT NULL THEN oxc.nombre ELSE 'Lote por liberar' END nombreProcesoLiberacion, 
			pl.id_proceso_lib,  pl.rescision, pl.autorizacion_DG, pl.estatus_lib, CASE WHEN oxc2.nombre IS NOT NULL THEN oxc2.nombre ELSE 'Nuevo' END nombreEstatusLiberacion,
			CASE WHEN oxc2.color IS NOT NULL THEN oxc2.color ELSE '#1B4F72' END colorMovimiento, pl.concepto, hd.idDocumento, 
            CASE WHEN hd.movimiento IS NULL THEN 'SIN ESPECIFICAR' ELSE hd.movimiento END AS movimiento, hd.expediente, hd.tipo_doc,
			CASE WHEN oxc3.nombre IS NOT NULL THEN oxc3.nombre ELSE 'Sin concepto' END nombreConceptoLiberacion, 
            CASE WHEN pl.comentario = '' THEN 'Sin comentarios.' ELSE pl.comentario END AS comentario, pl.precioLiberacion, pl.plazo
        FROM lotes AS lo
            LEFT JOIN clientes AS cl ON cl.id_cliente = lo.idCliente
            LEFT JOIN condominios AS co ON lo.idCondominio = co.idCondominio
            LEFT JOIN residenciales AS re ON co.idResidencial = re.idResidencial
            LEFT JOIN usuarios AS u0 ON u0.id_usuario = cl.id_asesor
            LEFT JOIN usuarios AS u1 ON u1.id_usuario = cl.id_coordinador
            LEFT JOIN usuarios AS u2 ON u2.id_usuario = cl.id_gerente
            LEFT JOIN usuarios AS u3 ON u3.id_usuario = cl.id_subdirector  
            LEFT JOIN usuarios AS u4 ON u4.id_usuario = cl.id_regional
            LEFT JOIN usuarios AS u5 ON u5.id_usuario = cl.id_regional_2
            LEFT JOIN proceso_liberacion_temp AS pl ON pl.idLote = lo.idLote AND rn = 1
			LEFT JOIN historial_documento hd ON hd.idLote = lo.idLote AND hd.tipo_doc IN (53, 54) AND hd.status = 1 AND hd.expediente IS NOT NULL
			LEFT JOIN opcs_x_cats AS oxc ON pl.proceso_lib = oxc.id_opcion AND oxc.id_catalogo = ?
			LEFT JOIN opcs_x_cats AS oxc2 ON pl.estatus_lib = oxc2.id_opcion AND oxc2.id_catalogo = 108
			LEFT JOIN opcs_x_cats AS oxc3 ON pl.concepto = oxc3.id_opcion AND oxc3.id_catalogo = 132
        WHERE lo.tipo_venta = ? AND cl.status = 1 AND lo.idStatusContratacion IN (9,10,13,14,15) $condicion 
        ORDER BY enProcesoLiberacion DESC;", array($idProcesoTipoLiberacion, $tipoVenta));
        return $query->result_array();
    }

    public function getLotesPendientesLiberacion($idProcesoTipoLiberacion, $tipoVenta, $condicion) 
    {
        ini_set('memory_limit', -1);
        $query = $this->db->query(
        "WITH proceso_liberacion_temp AS (SELECT *, ROW_NUMBER() OVER(PARTITION BY idLote ORDER BY fecha_creacion DESC) AS rn FROM proceso_liberaciones)
        SELECT re.nombreResidencial, co.nombre AS nombreCondominio, lo.nombreLote, lo.idLote, co.idCondominio, re.idResidencial, lo.idCliente,
			CONVERT(VARCHAR, cl.fechaApartado, 20) as fechaApartado, UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) AS cliente,
			lo.precio, lo.sup, (ISNULL(lo.totalNeto2, 0.00) / lo.sup) costom2f, ISNULL(lo.totalNeto2, 0.00) total, lo.referencia,
            CASE WHEN u0.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) END nombreAsesor,
            CASE WHEN u1.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) END nombreCoordinador,
            CASE WHEN u2.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) END nombreGerente,
            CASE WHEN u3.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) END nombreSubdirector,
            CASE WHEN u4.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) END nombreRegional,
            CASE WHEN u5.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u5.nombre, ' ', u5.apellido_paterno, ' ', u5.apellido_materno)) END nombreRegional2, 
            CASE WHEN pl.idLote IS NOT NULL THEN pl.proceso_lib ELSE '0' END enProcesoLiberacion, CASE WHEN oxc.nombre IS NOT NULL THEN oxc.nombre ELSE 'Lote por liberar' END nombreProcesoLiberacion, 
			pl.id_proceso_lib,  pl.rescision, pl.autorizacion_DG, pl.estatus_lib, CASE WHEN oxc2.nombre IS NOT NULL THEN oxc2.nombre ELSE 'Nuevo' END nombreEstatusLiberacion,
			CASE WHEN oxc2.color IS NOT NULL THEN oxc2.color ELSE '#1B4F72' END colorMovimiento, pl.concepto, hd.idDocumento, 
            CASE WHEN hd.movimiento IS NULL THEN 'SIN ESPECIFICAR' ELSE hd.movimiento END AS movimiento, hd.expediente, hd.tipo_doc,
			CASE WHEN oxc3.nombre IS NOT NULL THEN oxc3.nombre ELSE 'Sin concepto' END nombreConceptoLiberacion, 
            CASE WHEN pl.comentario = '' THEN 'Sin comentarios.' ELSE pl.comentario END comentario, pl.precioLiberacion, pl.plazo
        FROM lotes AS lo
            LEFT JOIN clientes AS cl ON cl.id_cliente = lo.idCliente
            LEFT JOIN condominios AS co ON lo.idCondominio = co.idCondominio
            LEFT JOIN residenciales AS re ON co.idResidencial = re.idResidencial
            LEFT JOIN usuarios AS u0 ON u0.id_usuario = cl.id_asesor
            LEFT JOIN usuarios AS u1 ON u1.id_usuario = cl.id_coordinador
            LEFT JOIN usuarios AS u2 ON u2.id_usuario = cl.id_gerente
            LEFT JOIN usuarios AS u3 ON u3.id_usuario = cl.id_subdirector  
            LEFT JOIN usuarios AS u4 ON u4.id_usuario = cl.id_regional
            LEFT JOIN usuarios AS u5 ON u5.id_usuario = cl.id_regional_2
            LEFT JOIN proceso_liberacion_temp AS pl ON pl.idLote = lo.idLote AND rn = 1
			LEFT JOIN historial_documento hd ON hd.idLote = lo.idLote AND hd.tipo_doc IN (53, 54) AND hd.status = 1 AND hd.expediente IS NOT NULL
			LEFT JOIN opcs_x_cats AS oxc ON pl.proceso_lib = oxc.id_opcion AND oxc.id_catalogo = ?
			LEFT JOIN opcs_x_cats AS oxc2 ON pl.estatus_lib = oxc2.id_opcion AND oxc2.id_catalogo = 108
			LEFT JOIN opcs_x_cats AS oxc3 ON pl.concepto = oxc3.id_opcion AND oxc3.id_catalogo = 132
        WHERE lo.tipo_venta = ? AND cl.status = 1 AND lo.idStatusContratacion IN (9,10,13,14,15) $condicion 
        ORDER BY enProcesoLiberacion DESC;", array($idProcesoTipoLiberacion, $tipoVenta));
        return $query->result_array();
    }

    public function getLotesEnProcesoLiberacion($idProcesoTipoLiberacion, $tipoVenta, $condicion) 
    {
        ini_set('memory_limit', -1);
        $query = $this->db->query(
        "WITH proceso_liberacion_temp AS (SELECT *, ROW_NUMBER() OVER(PARTITION BY idLote ORDER BY fecha_creacion DESC) AS rn FROM proceso_liberaciones)
        SELECT re.nombreResidencial, co.nombre AS nombreCondominio, lo.nombreLote, lo.idLote, co.idCondominio, re.idResidencial, lo.idCliente,
			CONVERT(VARCHAR, cl.fechaApartado, 20) as fechaApartado, UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) AS cliente,
			lo.precio, lo.sup, (ISNULL(lo.totalNeto2, 0.00) / lo.sup) costom2f, ISNULL(lo.totalNeto2, 0.00) total, lo.referencia,
            CASE WHEN u0.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) END nombreAsesor,
            CASE WHEN u1.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) END nombreCoordinador,
            CASE WHEN u2.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) END nombreGerente,
            CASE WHEN u3.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) END nombreSubdirector,
            CASE WHEN u4.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) END nombreRegional,
            CASE WHEN u5.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u5.nombre, ' ', u5.apellido_paterno, ' ', u5.apellido_materno)) END nombreRegional2, 
            CASE WHEN pl.idLote IS NOT NULL THEN pl.proceso_lib ELSE '0' END enProcesoLiberacion, CASE WHEN oxc.nombre IS NOT NULL THEN oxc.nombre ELSE 'Lote por liberar' END nombreProcesoLiberacion, 
			pl.id_proceso_lib,  pl.rescision, pl.autorizacion_DG, pl.estatus_lib, CASE WHEN oxc2.nombre IS NOT NULL THEN oxc2.nombre ELSE 'Nuevo' END nombreEstatusLiberacion,
			CASE WHEN oxc2.color IS NOT NULL THEN oxc2.color ELSE '#1B4F72' END colorMovimiento, pl.concepto, hd.idDocumento, 
            CASE WHEN hd.movimiento IS NULL THEN 'SIN ESPECIFICAR' ELSE hd.movimiento END AS movimiento, hd.expediente, hd.tipo_doc,
			CASE WHEN oxc3.nombre IS NOT NULL THEN oxc3.nombre ELSE 'Sin concepto' END nombreConceptoLiberacion, CASE WHEN pl.comentario = '' THEN 'Sin comentarios.' ELSE pl.comentario END comentario, pl.precioLiberacion, pl.plazo
        FROM lotes AS lo
            LEFT JOIN clientes AS cl ON cl.id_cliente = lo.idCliente
            LEFT JOIN condominios AS co ON lo.idCondominio = co.idCondominio
            LEFT JOIN residenciales AS re ON co.idResidencial = re.idResidencial
            LEFT JOIN usuarios AS u0 ON u0.id_usuario = cl.id_asesor
            LEFT JOIN usuarios AS u1 ON u1.id_usuario = cl.id_coordinador
            LEFT JOIN usuarios AS u2 ON u2.id_usuario = cl.id_gerente
            LEFT JOIN usuarios AS u3 ON u3.id_usuario = cl.id_subdirector  
            LEFT JOIN usuarios AS u4 ON u4.id_usuario = cl.id_regional
            LEFT JOIN usuarios AS u5 ON u5.id_usuario = cl.id_regional_2
            LEFT JOIN proceso_liberacion_temp AS pl ON pl.idLote = lo.idLote AND rn = 1
			LEFT JOIN historial_documento hd ON hd.idLote = lo.idLote AND hd.tipo_doc IN (53, 54) AND hd.status = 1 AND hd.expediente IS NOT NULL
			LEFT JOIN opcs_x_cats AS oxc ON pl.proceso_lib = oxc.id_opcion AND oxc.id_catalogo = ?
			LEFT JOIN opcs_x_cats AS oxc2 ON pl.estatus_lib = oxc2.id_opcion AND oxc2.id_catalogo = 108
			LEFT JOIN opcs_x_cats AS oxc3 ON pl.concepto = oxc3.id_opcion AND oxc3.id_catalogo = 132
        WHERE lo.tipo_venta = ? AND cl.status = 1 AND lo.idStatusContratacion IN (9,10,13,14,15) $condicion 
        ORDER BY enProcesoLiberacion DESC;", array($idProcesoTipoLiberacion, $tipoVenta));
        return $query->result_array();
    }

    public function obtenerDocumentacionPorLiberacion($idCatalogo)
    {
        $query = $this->db->query('SELECT * FROM opcs_x_cats WHERE id_catalogo = ?', $idCatalogo);
        return $query->result_array();
    }

    public function historialLiberacionLote($idProcesoTipoLiberacion, $tipoVenta, $idLote) 
    {
        $query = $this->db->query(
            "SELECT re.nombreResidencial, co.nombre AS nombreCondominio, lo.nombreLote, lo.idLote, co.idCondominio, re.idResidencial, lo.idCliente,  CONVERT(VARCHAR, cl.fechaApartado, 20) as fechaApartado,
            UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) AS cliente, lo.precio, lo.sup, (ISNULL(lo.totalNeto2, 0.00) / lo.sup) costom2f, ISNULL(lo.totalNeto2, 0.00) total,
            CASE WHEN pl.idLote IS NOT NULL THEN pl.proceso_lib ELSE '0' END enProcesoLiberacion, CASE WHEN oxc.nombre IS NOT NULL THEN oxc.nombre ELSE 'Lote por liberar' END nombreProcesoLiberacion, 
            pl.id_proceso_lib,  pl.rescision, pl.autorizacion_DG, pl.estatus_lib, CASE WHEN oxc2.nombre IS NOT NULL THEN oxc2.nombre ELSE 'Nuevo' END nombreEstatusLiberacion,
            CASE WHEN oxc2.color IS NOT NULL THEN oxc2.color ELSE '#1B4F72' END colorMovimiento, pl.concepto, 
            CASE WHEN oxc3.nombre IS NOT NULL THEN oxc3.nombre ELSE 'Sin concepto' END nombreConceptoLiberacion, CASE WHEN pl.comentario = '' THEN 'Sin comentarios.' ELSE pl.comentario END comentario, pl.precioLiberacion, pl.plazo,
            us.nombre AS nombreMod, us.apellido_paterno AS ap1_mod, us.apellido_materno AS ap2_mod, pl.estatus, pl.modificado_por, pl.fecha_modificacion, pl.creado_por, pl.fecha_creacion
        FROM proceso_liberaciones AS pl
            LEFT JOIN lotes AS lo ON lo.idLote = pl.idLote
            LEFT JOIN clientes AS cl ON cl.id_cliente = lo.idCliente
            LEFT JOIN condominios AS co ON lo.idCondominio = co.idCondominio
            LEFT JOIN residenciales AS re ON co.idResidencial = re.idResidencial
            LEFT JOIN opcs_x_cats AS oxc ON pl.proceso_lib = oxc.id_opcion AND oxc.id_catalogo = ?
            LEFT JOIN opcs_x_cats AS oxc2 ON pl.estatus_lib = oxc2.id_opcion AND oxc2.id_catalogo = 108
            LEFT JOIN opcs_x_cats AS oxc3 ON pl.concepto = oxc3.id_opcion AND oxc3.id_catalogo = 132
            LEFT JOIN usuarios AS us ON us.id_usuario = pl.modificado_por
        WHERE lo.tipo_venta = ? AND cl.status = 1 AND pl.estatus = 1 AND lo.idStatusContratacion IN (9,10,13,14,15)
            AND pl.idLote= ?
        ORDER BY pl.id_proceso_lib DESC;", array($idProcesoTipoLiberacion, $tipoVenta, $idLote));
        return $query;
    }

    
}