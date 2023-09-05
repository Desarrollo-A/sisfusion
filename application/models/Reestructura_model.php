<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Reestructura_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_proyecto_lista(){
        return $this->db->query("SELECT idResidencial,CONCAT(nombreResidencial ,' - ', descripcion) as descripcion FROM residenciales WHERE status = 1 and idResidencial in (30,21,25,13)");
    }

    public function get_valor_lote($id_proyecto)
    {
        return $this->db->query("SELECT res.nombreResidencial,con.nombre AS condominio, lot.nombreLote, lot.idLote ,lot.sup AS superficie, lot.precio, lot.observacionLiberacion AS observacion 
        FROM lotes lot
        INNER JOIN condominios con ON con.idCondominio = lot.idCondominio
        INNER JOIN residenciales res on res.idResidencial = con.idResidencial
        INNER JOIN loteXReubicacion lotx ON lotx.proyectoReubicacion = con.idResidencial and lotx.idProyecto in ($id_proyecto)
        INNER JOIN clientes cli ON cli.id_cliente = lot.idCliente and cli.status = 1")->result();
    }
}