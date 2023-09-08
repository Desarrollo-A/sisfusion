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
        ISNULL (ds.costom2f, 'SIN ESPECIFICAR') costom2f, SUM(CASE WHEN (lo.totalNeto2 IS NULL OR lo.totalNeto2 = 0.00) THEN ISNULL(TRY_CAST(ds.costom2f AS DECIMAL(16, 2)) * lo.sup, lo.precio * lo.sup) ELSE lo.totalNeto2 END) total
        FROM lotes lo
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.idLote = lo.idLote AND cl.status = 1
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
        GROUP BY lr.idProyecto, lo.idLote, lo.nombreLote,  cl.fechaApartado, co.nombre, re.nombreResidencial,
        lo.idCliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, 
        u0.id_usuario, u0.nombre, u0.apellido_paterno, u0.apellido_materno,
        u1.id_usuario, u1.nombre, u1.apellido_paterno, u1.apellido_materno,
        u2.id_usuario, u2.nombre, u2.apellido_paterno, u2.apellido_materno,
        u3.id_usuario, u3.nombre, u3.apellido_paterno, u3.apellido_materno,
        u4.id_usuario, u4.nombre, u4.apellido_paterno, u4.apellido_materno,
        u5.id_usuario, u5.nombre, u5.apellido_paterno, u5.apellido_materno,
        ds.costom2f, lo.sup");

        return $query->result_array();
    }

    public function getProyectosDisponibles(){
        $query = $this->db->query("SELECT lr.idProyecto, UPPER(CAST((CONCAT(re.nombreResidencial, ' - ', re.descripcion)) AS NVARCHAR(100))) descripcion
        FROM loteXReubicacion lr
        INNER JOIN residenciales re ON re.idResidencial = lr.idProyecto
        WHERE lr.idProyecto IN ('13', '21', '25', '30') AND re.status = 1
        GROUP BY lr.idProyecto,  re.nombreResidencial, CAST( (CONCAT(re.nombreResidencial, ' - ', re.descripcion)) AS NVARCHAR(100))");

        return $query->result_array();
    }

    public function getCondominiosDisponibles($proyecto){
        $query = $this->db->query("SELECT lo.idCondominio, co.nombre, COUNT(lo.idLote) disponibles
        FROM condominios co
        INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio
        WHERE lo.idStatusLote IN (1) AND lo.status in(1)
        AND co.idResidencial = $proyecto
        GROUP BY lo.idCondominio, co.nombre");

        return $query->result();
    }

    public function getLotesDisponibles($condominio){
        $query = $this->db->query("SELECT lo.idLote, lo.nombreLote, lo.sup, lo.precio, lo.total
        FROM lotes lo
        WHERE lo.idCondominio = $condominio AND  lo.idStatusLote in(1) AND lo.status in(1)");

        return $query->result();
    }

    public function obtenerDocumentacionActiva($idLote, $idCliente)
    {
        $query = $this->db->query("SELECT * FROM historial_documento WHERE idLote = $idLote AND idCliente = $idCliente AND status = 1");
        return $query->result_array();
    }

    public function obtenerLotePorId($idLote)
    {
        $query = $this->db->query("SELECT lo.*,
            cl.personalidad_juridica
            FROM lotes lo
            INNER JOIN clientes cl ON lo.idLote = cl.idLote
            WHERE lo.idLote = $idLote AND cl.status = 1");
        return $query->row();
    }

    public function obtenerDocumentacionPorReubicacion($personalidadJuridica)
    {
        $idCatalogo = ($personalidadJuridica == 1) ? 101 : 98;
        $query = $this->db->query("SELECT * FROM opcs_x_cats WHERE id_catalogo = $idCatalogo AND estatus = 1");
        return $query->result_array();
    }

    public function obtenerDSPorIdCliente($idCliente)
    {
        $query = $this->db->query("SELECT * FROM deposito_seriedad WHERE id_cliente = $idCliente");
        return $query->row();
    }

    public function obtenerResidencialPorIdCliente($idCliente)
    {
        $query = $this->db->query("SELECT re.* 
            FROM clientes cl 
            INNER JOIN lotes lo ON cl.idLote = lo.idLote
            INNER JOIN condominios co ON lo.idCondominio = co.idCondominio
            INNER JOIN residenciales re ON co.idResidencial = re.idResidencial
            WHERE id_cliente = $idCliente
        ");
        return $query->row();
    }

    public function obtenerCopropietariosPorIdCliente($idCliente)
    {
        $query = $this->db->query("SELECT * FROM copropietarios WHERE id_cliente = $idCliente");
        return $query->result_array();
    }
}