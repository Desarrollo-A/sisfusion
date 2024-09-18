<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Anticipos_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getAnticipos() {
        $filtro = "";
        $filtroMonto = "";
        switch($this->session->userdata('id_rol')) {
            case '31':
                $filtro = "AND ant.proceso IN (7) ";
                $filtroMonto ="pra.monto_parcialidad";
                break;
            default:
                $filtro = "AND ant.proceso IN (6) ";
                $filtroMonto ="ant.monto";
                break;
        }
    
        $data = $this->db->query("SELECT fa.nombre_archivo AS factura,
        oxc.nombre AS esquema, se.nombre AS sede, us.forma_pago,  oxcPago.nombre AS formaNombre,
        opcE.id_opcion as clave_empresa , opcE.nombre as nombre_empresa,ea.empresa ,
        se.id_sede AS idsede,
		oxcPago.nombre AS formaNombre,
        fa.nombre_archivo AS factura_nombre,
        ant.evidencia, ant.impuesto, ant.id_anticipo, ant.monto, ant.id_usuario, ant.estatus, 
        UPPER(CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS nombreUsuario, 
        opcRol.nombre as puesto,
        ant.proceso, ant.comentario, 
        CASE WHEN ant.prioridad  = 0 THEN 'Normal' ELSE 'URGENTE' END AS prioridad_nombre, $filtroMonto as montoParcial,
        pra.monto_parcialidad as montoParcial1 ,
        pra.mensualidades, ant.numero_mensualidades as mensualidadesBoton, 
        pra.monto_parcialidad as valorTexto
        FROM anticipo ant
        INNER JOIN usuarios us ON us.id_usuario = ant.id_usuario 
        LEFT JOIN sedes se ON se.id_sede = us.id_sede 
        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = us.forma_pago AND oxc.id_catalogo = 23 
        LEFT JOIN facturas_anticipos fa ON fa.id_anticipo = ant.id_anticipo
        LEFT JOIN opcs_x_cats oxcPago ON oxcPago.id_opcion = us.forma_pago AND oxcPago.id_catalogo = 16 
        LEFT JOIN empresa_anticipo ea ON ea.id_anticipo = ant.id_anticipo 
		LEFT JOIN opcs_x_cats opcE ON opcE.id_catalogo = 61 and opcE.estatus = 1 AND  ea.empresa = opcE.id_opcion 
        LEFT JOIN opcs_x_cats opcRol ON opcRol.id_catalogo = 1 and us.id_rol = opcRol.id_opcion 
        LEFT JOIN parcialidad_relacion_anticipo pra ON pra.id_anticipo = ant.id_anticipo 
                AND pra.monto_parcialidad IS NOT NULL
        WHERE ant.estatus = 2
        $filtro");

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
        $ultimoId = $this->db->insert_id();
        if ($query) {
            return $ultimoId;
        } else {
            return 0;
        }
    }

    public function relacion_anticipo_prestamo($id_anticipo, $ultimoId){
        $query = $this->db->query("INSERT INTO relacion_anticipo_prestamo (id_anticipo, tipo_prestamo) VALUES ($id_anticipo, $ultimoId)");

        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

    public function parcialidad_relacion_anticipo($id_anticipo, $catalogo, $numeroPagosParcialidad, $montoPEntero){
        $query = $this->db->query("INSERT INTO parcialidad_relacion_anticipo (id_anticipo, catalogo, fecha_creacion, mensualidades, monto_parcialidad) VALUES ($id_anticipo, $catalogo, GETDATE(), $numeroPagosParcialidad, $montoPEntero)");

        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

    public function mensualidadesNumero($id_anticipo, $id_usuario, $numeroPagosParcialidad){
        $cmd = "UPDATE anticipo set numero_mensualidades = $numeroPagosParcialidad WHERE id_anticipo = $id_anticipo and id_usuario = $id_usuario ";
        $query = $this->db->query($cmd);
        if ($query) {
            return 1;
        }else {
            return 0;
        }
    }

    public function updateEstatusD($procesoAnt, $id_anticipo){

        $estatus = ($procesoAnt == 7) ? 2 : 0;

        $cmd = "UPDATE anticipo SET proceso=$procesoAnt, estatus=$estatus WHERE id_anticipo = $id_anticipo";
        $query = $this->db->query($cmd);
        if ($query) {
            return 1;
        }else {
            return 0;
        }
    }

    public function updateEstatusInterno($proceso,$id_anticipo){
        $cmd = "UPDATE anticipo set proceso = $proceso , estatus = 2 WHERE id_anticipo = $id_anticipo ";
        $query = $this->db->query($cmd);
        if ($query) {
            return 1;
        }else {
            return 0;
        }
    }

    public function getTipoAnticipo() {
        return $this->db->query("SELECT * FROM opcs_x_cats where id_catalogo = 139 AND estatus = 1");
    }

    public function updateMontoTotal($id_anticipo,$mensualidadParcialidad,$procesoAntInternomex){

        var_dump($mensualidadParcialidad);


        $estatus = ($procesoAntInternomex == 0) ? 0 : 2;
        $proceso = ($procesoAntInternomex == 0) ? 0 : 6;

        if($mensualidadParcialidad == 0){
            
            $mensualidadParcialidad=0;
        }

        $query = $this->db->query("UPDATE anticipo SET numero_mensualidades=$mensualidadParcialidad, proceso=$proceso, estatus=$estatus WHERE id_anticipo = $id_anticipo");
        
        if ($query) {
            return 1;
        }else {
            return 0;
        }
    }

    public function updateMensualidad0($id_anticipo){

        $estatusMensualidad_a_0 = 7;
        $procesoMensualidad_a_0 = 8;

        $cmd = "UPDATE anticipo SET proceso=$procesoMensualidad_a_0, estatus=$estatusMensualidad_a_0 WHERE id_anticipo = $id_anticipo";
        $query = $this->db->query($cmd);
        if ($query) {
            return 1;
        }else {
            return 0;
        }
    }

    public function regresoInternomex($id_anticipo, $id_usuario, $procesoParcialidad) {

        $estatus = ($procesoParcialidad == 0) ? 0 : 2;
        $proceso = ($procesoParcialidad == 0) ? 0 : 7;
    
        $sql = "UPDATE anticipo SET proceso = ?, estatus = ? WHERE id_anticipo = ? AND id_usuario = ?";
        $this->db->query($sql, array($proceso, $estatus, $id_anticipo, $id_usuario));
        
        return $this->db->affected_rows() > 0 ? 1 : 0;
    }
    

    public function datosCatalogos(){
        $cmd = "SELECT * FROM opcs_x_cats where id_catalogo = 61 and estatus = 1";
        $query = $this->db->query($cmd);
        return $query->result_array();
    }

    public function addEmpresa($id_anticipo, $empresa){
        $cmd = "INSERT INTO empresa_anticipo VALUES($id_anticipo,$empresa)";
        $query = $this->db->query($cmd);
        return $this->db->affected_rows() > 0 ? 1 : 0;
    }

    public function inserPAGOS($tabla, $insert){
        $respuesta = $this->db->insert($tabla,$insert);
                if($respuesta)
                {
                    return TRUE;
                }else{
                    return FALSE;
                }  
    }



    
}