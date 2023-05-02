
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resguardos_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        // $this->gphsis = $this->load->database('GPHSIS', TRUE);
    }

    function getRetiros($user,$opc){
        $query = '';
        if($opc == 2){
            $query = 'AND rc.estatus in(67)';
        }
        return $this->db->query("SELECT rc.id_rc,CONCAT(us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno) AS usuario,rc.monto,rc.conceptos,rc.fecha_creacion,rc.estatus,CONCAT(u2.nombre,' ',u2.apellido_paterno,' ',u2.apellido_materno) AS creado_por,rc.estatus from usuarios us inner join resguardo_conceptos rc on rc.id_usuario=us.id_usuario inner join usuarios u2 on u2.id_usuario=rc.creado_por where rc.id_usuario=$user $query");
    }

    function getListaRetiros($id) {
        $query = $this->db->query("SELECT r.*,CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario  from historial_retiros r inner join usuarios u on u.id_usuario=r.id_usuario where id_retiro=$id");
        return $query;
    }

   
    }