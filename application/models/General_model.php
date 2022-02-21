<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

    function get_menu($id_rol)
    {


        if ($this->session->userdata('id_usuario') == 4415) { // ES GREENHAM
            return $this->db->query("SELECT * FROM Menu2 WHERE rol=".$id_rol." AND nombre IN ('Inicio', 'Comisiones') AND estatus = 1 order by orden asc");
        } else {
        if ($id_rol == 33) { // ES UN USUARIO DE CONSULTA
            if ($this->session->userdata('id_usuario') == 2896) { // ES PATRICIA MAYA
                return $this->db->query("SELECT * FROM Menu2 WHERE rol=".$id_rol." AND estatus = 1 ORDER BY orden ASC");
            } else { // ES OTRO USUARIO DE CONSULTA Y NO VE COMISIONES
                return $this->db->query("SELECT * FROM Menu2 WHERE rol=".$id_rol." AND nombre NOT IN ('Inicio', 'Comisiones') AND estatus = 1 ORDER BY orden ASC");
            }
        } 
        
        else{
            if($this->session->userdata('id_usuario') == 2762){
                return $this->db->query("SELECT * FROM Menu2 WHERE rol=".$id_rol." AND estatus = 1 ORDER BY orden ASC");
            }else{
                return $this->db->query("SELECT * FROM Menu2 WHERE rol=".$id_rol." AND estatus = 1 AND nombre NOT IN ('Reemplazo contrato') ORDER BY orden ASC");
            }
        }

    }
      //  return $this->db->query("SELECT * FROM Menu2 WHERE rol=".$id_rol." AND estatus = 1 ORDER BY orden ASC");
    }
    /*function get_menu($id_rol)
    {
        if ($id_rol == 33) { // ES UN USUARIO DE CONSULTA
            if ($this->session->userdata('id_usuario') == 2896) { // ES PATRICIA MAYA
                return $this->db->query("SELECT * FROM Menu2 WHERE rol=".$id_rol." AND estatus = 1 ORDER BY orden ASC");
            } else { // ES OTRO USUARIO DE CONSULTA Y NO VE COMISIONES
                return $this->db->query("SELECT * FROM Menu2 WHERE rol=".$id_rol." AND nombre NOT IN ('Inicio', 'Comisiones') AND estatus = 1 ORDER BY orden ASC");
            }
        } else{
            return $this->db->query("SELECT * FROM Menu2 WHERE rol=".$id_rol." AND estatus = 1 ORDER BY orden ASC");
        }
        return $this->db->query("SELECT * FROM Menu2 WHERE rol=".$id_rol." AND estatus = 1 ORDER BY orden ASC");
    }*/
    
    function get_children_menu($id_rol)
    {
        if($this->session->userdata('id_usuario') == 2762){
            return $this->db->query("SELECT * FROM Menu2 WHERE rol = ".$id_rol." AND padre > 0 AND estatus = 1 ORDER BY orden ASC");
        }else{
            return $this->db->query("SELECT * FROM Menu2 WHERE rol = ".$id_rol." AND padre > 0 AND estatus = 1 AND nombre NOT IN ('Reemplazo contrato') ORDER BY orden ASC");
        }
    }
    
    function get_active_buttons($var, $id_rol)
    {
        return $this->db->query("SELECT padre FROM Menu2 WHERE pagina = '".$var."' AND rol = ".$id_rol." ");
    }

    function getResidencialesList()
    {
        return $this->db->query("SELECT idResidencial, nombreResidencial, UPPER(CAST(descripcion AS VARCHAR(75))) descripcion FROM residenciales WHERE status = 1 ORDER BY nombreResidencial ASC")->result_array();
    }

    function getCondominiosList($idResidencial)
    {
        return $this->db->query("SELECT idCondominio, UPPER(nombre) nombre FROM condominios WHERE status = 1 AND idResidencial = $idResidencial ORDER BY nombre ASC")->result_array();
    }

    function getLotesList($idCondominio)
    {
        return $this->db->query("SELECT idLote, UPPER(nombreLote) nombreLote, idStatusLote FROM lotes WHERE status = 1 AND idCondominio = $idCondominio")->result_array();
    }

}
