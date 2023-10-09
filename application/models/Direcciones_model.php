<?php class Direcciones_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    function getDirecciones(){
        return $this->db->query("SELECT dir.id_direccion,dir.estatus,dir.hora_inicio,dir.hora_fin,dir.id_sede, dir.nombre as direccion, se.nombre as estado, tipo_oficina FROM direcciones dir INNER JOIN sedes se ON se.id_sede = dir.id_sede WHERE tipo_oficina = 1");
    }

    public function getEstadoInfo(){
        return $this->db->query("SELECT id_sede, nombre as estado FROM sedes");
    }

    public function insertarCampo($datos){    
        return $this->db->query("INSERT INTO direcciones VALUES (".$datos['id_sede'].",'".$datos['direccion']."',1,".$datos['hora_inicio'].",".$datos['hora_fin'].",1,GETDATE(),1)");
    }
   
    public function editarDireccion($datos){
        return $this->db->query("UPDATE direcciones SET id_sede = ".$datos['id_sedeEdit'].", hora_inicio = ".$datos['hora_inicio'].", hora_fin = ".$datos['hora_fin'].", nombre = '".$datos['direccion']."' WHERE id_direccion = ".$datos['id_direccion']."");
    }

    public function borrarDirecciones($datos){
        return $this->db->query("UPDATE direcciones SET estatus = ".$datos['estatus_n']." WHERE id_direccion = ".$datos['id_direccion']."");
    }
}