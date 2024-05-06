<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Anticipos_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getAnticipos(){
        $data = $this->db->query("SELECT ant.evidencia, ant.id_anticipo, ant.monto, ant.id_usuario, ant.estatus, UPPER(CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS nombreUsuario, ant.proceso,ant.comentario, ant.prioridad FROM anticipo ant
        INNER JOIN usuarios us ON us.id_usuario= ant.id_usuario where ant.estatus=2");
        return $data;
    }

    public function updateEstatus($procesoAnt, $id_usuario) {
        $query = $this->db->query("UPDATE anticipo SET proceso=$procesoAnt WHERE id_usuario = $id_usuario");
        
        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

    public function updateHistorial($id_anticipo, $id_usuario, $comentario, $procesoAnt){
        $query = $this->db->query("INSERT INTO historial_anticipo (id_anticipo, id_usuario, proceso, comentario) VALUES ($id_anticipo, $id_usuario, $procesoAnt, '$comentario')");
        
        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }
}