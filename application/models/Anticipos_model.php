<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Anticipos_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getAnticipos(){
        $filtro = "";
        switch($this->session->userdata('id_rol')){
            case '31':
                $filtro = "AND ant.proceso IN (7) ";
            break;
                
            default:
                
                $filtro = "AND ant.proceso IN (6) ";
            break;
            }

        $data = $this->db->query("SELECT fa.nombre_archivo as factura,
        oxc.nombre as esquema, se.nombre as sede, us.forma_pago, fa.nombre_archivo as factura_nombre,
        ant.evidencia, ant.impuesto, ant.id_anticipo, ant.monto, ant.id_usuario, ant.estatus, 
        UPPER(CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS nombreUsuario, 
        ant.proceso,ant.comentario, ant.prioridad 
        FROM anticipo ant
        INNER JOIN usuarios us ON us.id_usuario= ant.id_usuario 
        LEFT JOIN sedes se ON se.id_sede = us.id_sede 
        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = us.forma_pago AND oxc.id_catalogo = 23 
        LEFT JOIN facturas_anticipos fa ON fa.id_anticipo = ant.id_anticipo 
        WHERE  ant.estatus=2
        $filtro ");
        return $data;
    }

    public function updateEstatus($procesoAnt, $id_usuario){
        $query = $this->db->query("UPDATE anticipo SET proceso=$procesoAnt WHERE id_usuario = $id_usuario");
        
        if ($query) {
            return 1;
        }else {
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

    public function autPrestamoAnticipo($id_usuario, $monto, $numeroPagos, $pago, $comentario, $creado_por, $procesoTipo) {
        $query = $this->db->query("INSERT INTO prestamos_aut (id_usuario, monto, num_pagos, pago_individual, comentario, estatus, pendiente, creado_por, fecha_creacion, modificado_por, fecha_modificacion, n_p, tipo, id_cliente, evidenciaDocs) 
        VALUES ($id_usuario, $monto, $numeroPagos, $pago, '$comentario', 1, $pago, $creado_por, GETDATE(), 1, GETDATE(), 0, 94, NULL, NULL)");
    
        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

    public function relacion_anticipo_prestamo($id_anticipo, $procesoTipo){
        $query = $this->db->query("INSERT INTO relacion_anticipo_prestamo (id_anticipo, tipo_prestamo) VALUES ($id_anticipo, $procesoTipo)");

        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }
    public function updateEstatusD($procesoAnt, $id_anticipo){
        $CMD = "UPDATE anticipo SET proceso=$procesoAnt,estatus = 0 WHERE id_anticipo = $id_anticipo";
        
        $query = $this->db->query($CMD);
        
        if ($query) {
            return 1;
        }else {
            return 0;
        }
    }
    public function updateEstatusInterno($proceso,$id_anticipo){
        $cmd = "UPDATE anticipo set proceso = $proceso , estatus = 11 WHERE id_anticipo = $id_anticipo ";
        $query = $this->db->query($cmd);
        if ($query) {
            return 1;
        }else {
            return 0;
        }
    }
}