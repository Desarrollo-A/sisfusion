<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Liberaciones_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }
    
    public function getLotesParaLiberacion() 
    {
        $query = $this->db->query(
        "SELECT re.nombreResidencial, co.nombre AS nombreCondominio, lo.nombreLote, lo.idLote, lo.idCliente,
        UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) AS cliente, lo.sup, (ISNULL(lo.totalNeto2, 0.00) / lo.sup) costom2f, ISNULL(lo.totalNeto2, 0.00) total,
        CASE WHEN u0.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) END nombreAsesor,
        CASE WHEN u1.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) END nombreCoordinador,
        CASE WHEN u2.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) END nombreGerente,
        CASE WHEN u3.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) END nombreSubdirector,
        CASE WHEN u4.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) END nombreRegional,
        CASE WHEN u5.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u5.nombre, ' ', u5.apellido_paterno, ' ', u5.apellido_materno)) END nombreRegional2, 
        CASE WHEN pl.idLote IS NOT NULL THEN '1' ELSE '0' END enProcesoLiberacion, pl.id_proceso_lib,  pl.rescision, pl.autorizacion_DG, pl.proceso_lib, pl.estatus_lib, 
        pl.concepto 
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
        LEFT JOIN proceso_liberaciones AS pl ON pl.idLote = lo.idLote 
        WHERE lo.tipo_venta = 1 AND cl.status = 1 AND lo.idStatusContratacion IN (9,10,13,14,15)
        ORDER BY enProcesoLiberacion DESC;"
        );
        return $query->result_array();
    }

    public function obtenerDocumentacionPorLiberacion($idCatalogo)
    {
        $query = $this->db->query('SELECT * FROM opcs_x_cats WHERE id_catalogo = ?', $idCatalogo);
        return $query->result_array();
    }
}