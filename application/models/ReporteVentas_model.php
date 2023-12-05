<?php
class ReporteVentas_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }
  
    public function getTimeInfo(){
        return $this->db->query("SELECT id_direccion, hora_inicio FROM direcciones");
    }

    public function getProspectingPlaceDetail() {
        $id_rol = $this->session->userdata('id_rol');
        if ($id_rol == 19 || $id_rol == 63)
            $lpReturn = "CONCAT(REPLACE(ISNULL(oxc.nombre, 'Sin especificar'), ' (especificar)', ''), (CASE pr.source WHEN '0' THEN '' ELSE CONCAT(' - ', pr.source) END))";
        else
            $lpReturn = "ISNULL(oxc.nombre, 'Sin especificar')";
        
        return $lpReturn;
    }

    function getInventarioData2($beginDate, $endDate){
        
        $id_rol = $this->session->userdata('id_rol');
        $id_usuario = $this->session->userdata('id_usuario');
        $id_lider = $this->session->userdata('id_lider');
        $where = "";

        if ($id_rol == 3) // MJ: GERENTE
            $where = "AND cl.id_gerente = $id_usuario";
        else if ($id_rol == 6)  // MJ: ASISTENTE DE GERENTE
            $where = "AND cl.id_gerente = $id_lider";
        else if ($id_rol == 7) // MJ: ASESOR
            $where = "AND cl.id_asesor = $id_usuario";
        else if ($id_rol == 9) // MJ: COORDINADIR
            $where = "AND cl.id_coordinador = $id_usuario";

        $query = $this->db->query("SELECT UPPER(CAST(re.descripcion AS varchar(150))) nombreResidencial, co.nombre nombreCondominio, lo.nombreLote, lo.idLote, lo.referencia,
        UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente, cl.fechaApartado,
                CASE WHEN u0.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) END nombreAsesor,
                CASE WHEN u1.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) END nombreCoordinador,
                CASE WHEN u2.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) END nombreGerente,
                CASE WHEN u3.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) END nombreSubdirector,
                CASE WHEN u4.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) END nombreRegional,
                CASE WHEN u5.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u5.nombre, ' ', u5.apellido_paterno, ' ', u5.apellido_materno)) END nombreRegional2,
                sl.nombre estatusLote, sc.nombreStatus estatusContratacion, mo.descripcion, lo.comentario, ISNULL(se.nombre, 'SIN ESPECIFICAR') ubicacionVenta
                FROM lotes lo
                INNER JOIN condominios co ON co.idCondominio = lo.idCondominio 
                INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
                INNER JOIN statuslote sl ON sl.idStatusLote = lo.idStatusLote 
                INNER JOIN statuscontratacion sc ON sc.idStatusContratacion = lo.idStatusContratacion
                INNER JOIN movimientos mo ON mo.idMovimiento = lo.idMovimiento
                INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.status = 1 AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:59.999' $where
                LEFT JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
                LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
                LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
                LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
                LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
                LEFT JOIN usuarios u5 ON u5.id_usuario = cl.id_regional_2
                LEFT JOIN sedes se ON se.id_sede = lo.ubicacion
                WHERE lo.status = 1");

        return $query->result_array();
    }
}
