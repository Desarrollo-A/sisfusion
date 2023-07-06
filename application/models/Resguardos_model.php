
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resguardos_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    function getRetiros($user,$opc){
        $query = '';
        if($opc == 2){
            $query = 'AND rc.estatus in(67)';
        }
        return $this->db->query("SELECT rc.id_rc,CONCAT(us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno) AS usuario,rc.monto,rc.conceptos,rc.fecha_creacion,rc.estatus,CONCAT(u2.nombre,' ',u2.apellido_paterno,' ',u2.apellido_materno) AS creado_por,rc.estatus from usuarios us inner join resguardo_conceptos rc on rc.id_usuario=us.id_usuario inner join usuarios u2 on u2.id_usuario=rc.creado_por where rc.id_usuario=$user $query");
    }

    function getListaRetiros($id) {
        $query = $this->db->query("SELECT r.*,CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, CONVERT(varchar, r.fecha_creacion,20) AS fecha_creacion from historial_retiros r inner join usuarios u on u.id_usuario=r.id_usuario where id_retiro=$id");
        return $query;
    }

    function actualizarRetiro($datos,$id,$opcion){
        $motivo = '';
        if($opcion == 'Borrar' ||  $opcion == 'Rechazar' ){
            $motivo = $datos['motivodel'];
            $datos = ['estatus' => $datos['estatus']];
        }
        
        $comentario = '';
        $respuesta = $this->db->update("resguardo_conceptos", $datos, " id_rc = $id");
        if($opcion == 'Autorizar'){
            $comentario = 'SE AUTORIZÓ ESTE RETIRO';
        }elseif($opcion == 'Borrar'){
            $comentario = 'SE ELIMINÓ ESTE RETIRO, MOTIVO: '.$motivo;
        }elseif($opcion == 'Rechazar'){
            $comentario = 'SE RECHAZÓ ESTE RETIRO, MOTIVO: '.$motivo;
        }elseif($opcion == 'Actualizar'){
            $comentario = 'SE ACTUALIZÓ RETIRO POR MOTIVO DE: '.$datos["conceptos"].' POR LA CANTIDAD DE: '.$datos["monto"].' ';
        }
        $respuesta = $this->db->query("INSERT INTO  historial_retiros VALUES ($id, ".$this->session->userdata('id_usuario').", GETDATE(), 1, '$comentario')");
    
        if (! $respuesta ) {
            return 0;
        } else {
            return 1;
        }
    }

    function getDisponibleResguardo($user) {
        $query = $this->db->query("select SUM(abono_neodata) as suma from pago_comision_ind where id_usuario = $user and estatus = 3 and id_comision not in (select id_comision from comisiones where estatus = 0)");
        return $query;
    }
    function getDisponibleExtras($user) {
        $query = $this->db->query("select SUM(monto) as extras from resguardo_conceptos where id_usuario = $user and estatus in(67)");
        return $query;
    }
    function getAplicadoResguardo($user) {
        $query = $this->db->query("select SUM(monto) as aplicado from resguardo_conceptos where id_usuario = $user and estatus in(1,2)");
        return $query;
    }

   
    }