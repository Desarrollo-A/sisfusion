<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Reestructura_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function getListaClientesReubicar() {
        ini_set('memory_limit', -1);
        $query = $this->db->query("SELECT lr.idProyecto, lo.idLote, lo.nombreLote, lo.idCliente, UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) AS cliente, 
        CONVERT(VARCHAR, cl.fechaApartado, 20) as fechaApartado, co.nombre AS nombreCondominio, re.nombreResidencial,
        CASE WHEN u0.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) END nombreAsesor,
        CASE WHEN u1.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) END nombreCoordinador,
        CASE WHEN u2.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) END nombreGerente,
        CASE WHEN u3.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) END nombreSubdirector,
        CASE WHEN u4.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) END nombreRegional,
        CASE WHEN u5.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u5.nombre, ' ', u5.apellido_paterno, ' ', u5.apellido_materno)) END nombreRegional2, lo.sup, 
        ISNULL (ds.costom2f, 'SIN ESPECIFICAR') costom2f, SUM(CASE WHEN (lo.totalNeto2 IS NULL OR lo.totalNeto2 = 0.00) THEN ISNULL(TRY_CAST(ds.costom2f AS DECIMAL(16, 2)) * lo.sup, lo.precio * lo.sup) ELSE lo.totalNeto2 END) total, co.tipo_lote, oxc.nombre nombreTipoLote
        FROM lotes lo
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.idLote = lo.idLote AND cl.status = 1
        -- LEFT JOIN clientes cl2 ON cl.id_cliente_reubicacion = cl.id_cliente AND cl2.status = 1
        INNER JOIN condominios co ON lo.idCondominio = co.idCondominio
        INNER JOIN residenciales re ON co.idResidencial = re.idResidencial
        INNER JOIN loteXReubicacion lr ON lr.idProyecto = re.idResidencial
        LEFT JOIN deposito_seriedad ds ON ds.id_cliente = cl.id_cliente
        INNER JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
        LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
        LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
        LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
        LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
        LEFT JOIN usuarios u5 ON u5.id_usuario = cl.id_regional_2
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = co.tipo_lote AND oxc.id_catalogo = 27
        -- WHERE cl2.id_cliente IS NULL
        GROUP BY lr.idProyecto, lo.idLote, lo.nombreLote,  cl.fechaApartado, co.nombre, re.nombreResidencial,
        lo.idCliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, 
        u0.id_usuario, u0.nombre, u0.apellido_paterno, u0.apellido_materno,
        u1.id_usuario, u1.nombre, u1.apellido_paterno, u1.apellido_materno,
        u2.id_usuario, u2.nombre, u2.apellido_paterno, u2.apellido_materno,
        u3.id_usuario, u3.nombre, u3.apellido_paterno, u3.apellido_materno,
        u4.id_usuario, u4.nombre, u4.apellido_paterno, u4.apellido_materno,
        u5.id_usuario, u5.nombre, u5.apellido_paterno, u5.apellido_materno,
        ds.costom2f, lo.sup, co.tipo_lote, oxc.nombre");

        return $query->result_array();
    }

    public function getProyectosDisponibles($proyecto, $superficie, $tipoLote){
        $query = $this->db->query("SELECT lr.proyectoReubicacion, UPPER(CAST((CONCAT(re.nombreResidencial, ' - ', re.descripcion)) AS NVARCHAR(100))) descripcion, COUNT(*) disponibles
        FROM loteXReubicacion lr
        INNER JOIN residenciales re ON re.idResidencial = lr.proyectoReubicacion AND re.status = 1
		INNER JOIN condominios co ON co.idResidencial = re.idResidencial AND co.tipo_lote = $tipoLote
		INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio AND lo.sup >= $superficie AND lo.idStatusLote = 13 AND lo.status = 1
        WHERE lr.idProyecto = $proyecto
		GROUP BY lr.proyectoReubicacion, UPPER(CAST((CONCAT(re.nombreResidencial, ' - ', re.descripcion)) AS NVARCHAR(100)))");

        return $query->result_array();
    }

    public function getCondominiosDisponibles($proyecto, $superficie, $tipoLote){
        $query = $this->db->query("SELECT lo.idCondominio, co.nombre, COUNT(*) disponibles
        FROM condominios co
        INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio
        WHERE lo.idStatusLote = 13 AND lo.status = 1
        AND co.idResidencial = $proyecto AND lo.sup >= $superficie AND co.tipo_lote = $tipoLote
        GROUP BY lo.idCondominio, co.nombre");

        return $query->result();
    }

    public function getLotesDisponibles($condominio, $superficie){
        $query = $this->db->query("SELECT
		    CASE WHEN sup = $superficie THEN '1%' 
			WHEN sup = ($superficie + 2)THEN '1%' ELSE '8%' END a_favor,
            lo.idLote, lo.nombreLote, lo.sup, lo.precio, lo.total
            FROM lotes lo
            WHERE lo.idCondominio = $condominio AND lo.idStatusLote = 13 AND lo.status = 1
            AND lo.sup >= $superficie");

        return $query->result();
    }
}