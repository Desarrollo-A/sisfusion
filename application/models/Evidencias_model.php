<?php class Evidencias_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getTokensInformation()
    {
        if($this->session->userdata('id_usuario') == 3)
            $where = "WHERE tk.creado_por = " . $this->session->userdata('id_usuario');
        else
            $where = "";
        return $this->db->query("SELECT tk.id_token, tk.token, CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno) generado_para,
        tk.fecha_creacion, CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno) creado_por, tk.nombre_archivo, tk.estatus,
        cl.fechaApartado, tk.id_cliente, tk.id_lote, CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno ) as nombreCliente,
        l.nombreLote, ".$this->session->userdata('id_rol')." as currentRol
        FROM tokens tk
        INNER JOIN usuarios u1 ON u1.id_usuario = tk.para
        INNER JOIN usuarios u2 ON u2.id_usuario = tk.creado_por
        LEFT JOIN clientes cl ON cl.id_cliente = tk.id_cliente
        LEFT JOIN lotes l ON l.idLote = tk.id_lote
        $where  ORDER BY tk.fecha_creacion");
    }

    public function getClient($idLote){
        return $this->db->query("SELECT CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) nombre, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreAsesor,
        cl.fechaApartado, FORMAT(lo.totalNeto2,'C') totalLote, FORMAT(isNULL(cl.totalNeto_cl, lo.totalNeto), 'C') engancheValidado, sl.nombre estatus_lote,
        sc.nombreStatus, oxc.nombre estatus_comision, cl.id_cliente, lo.nombreLote,
        cond.nombre nombreCondominio, res.nombreResidencial, ve.estatus evidencia FROM clientes cl
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
        INNER JOIN lotes lo ON lo.idLote = cl.idLote
        INNER JOIN condominios cond ON cond.idCondominio = lo.idCondominio
        INNER JOIN residenciales res ON res.idResidencial = cond.idResidencial
        INNER JOIN statuslote sl ON sl.idStatusLote = lo.idStatusLote
        INNER JOIN statuscontratacion sc ON sc.idStatusContratacion = lo.idStatusContratacion
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = lo.registro_comision AND oxc.id_catalogo =23
        LEFT JOIN video_evidencia ve ON ve.idCliente = cl.id_cliente AND ve.idLote = lo.idLote AND ve.estatus=1
        WHERE cl.idLote = $idLote AND cl.status = 1");
    }

    public function validateRecords($data){
        return $this->db->query("SELECT * FROM video_evidencia WHERE idCliente = $data->idCliente AND idLote = $data->idLote AND estatus =1");
    }
}