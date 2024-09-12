<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Credito_model extends CI_Model
{
    function __construct()
    {
        $this->load->library('email');
        parent::__construct();
        $this->load->model(array('Comisiones_model', 'General_model'));
    }

    public function getOrdenCompra()
    {
        $query = "SELECT cd.id_proceso_credito_directo AS id, cd.idLote, lo.nombreLote AS lote, con.nombre AS condominio, resi.descripcion AS proyecto 
        FROM proceso_credito_directo cd
        INNER JOIN lotes lo ON lo.idLote = cd.idLote
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        WHERE cd.proceso = 17 AND cd.estatus = 1 AND cli.status = 1";

        return $this->db->query($query)->result();
    }

    public function getProyectos($id){
        $query = "SELECT  cd.id_proceso_credito_directo AS id, lo.nombreLote 
        FROM proceso_credito_directo cd
        INNER JOIN lotes lo ON lo.idLote = cd.idLote 
        WHERE cd.id_proceso_credito_directo = $id";

        return $this->db->query($query)->row();
    }

}