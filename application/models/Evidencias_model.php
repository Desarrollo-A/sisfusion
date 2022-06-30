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


}