<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Suma_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function getUserInformation($id_asesor, $contrasena)
    {
        $query = $this->db->query("SELECT u0.estatus,
        u0.id_usuario id_asesor, u0.id_rol rol_asesor, UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) nombre_asesor,
        u1.id_usuario id_coordinador, u1.id_rol rol_coordinador, UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) nombre_coordinador,
        u2.id_usuario id_gerente, u2.id_rol rol_gerente, UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) nombre_gerente,
        u3.id_usuario id_subdirector, u3.id_rol rol_subdirector, UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) nombre_subdirector,
        CASE u4.id_usuario WHEN 2 THEN 0 ELSE u4.id_usuario END id_regional, CASE u4.id_usuario WHEN 2 THEN 0 ELSE 59 END rol_regional,
		CASE u4.id_usuario WHEN 2 THEN 'NO APLICA' ELSE CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno) END nombre_regional
        FROM usuarios u0
        LEFT JOIN usuarios u1 ON u1.id_usuario = u0.id_lider
        LEFT JOIN usuarios u2 ON u2.id_usuario = u1.id_lider
        LEFT JOIN usuarios u3 ON u3.id_usuario = u2.id_lider
        LEFT JOIN usuarios u4 ON u4.id_usuario = u3.id_lider
        WHERE u0.id_usuario = $id_asesor AND u0.contrasena = '$contrasena'");

        if($query->num_rows() > 0)
            return $query->row();
        else
            return false;
    }

    function setComisionesPagos($dataComisiones, $dataPagos){
        $this->db->trans_begin();
        $c = $this->db->insert_batch('comisiones_suma', $dataComisiones);
        $b = $this->db->insert_batch('pagos_suma', $dataPagos);
        if ($this->db->trans_status() === FALSE) { // Hubo errores en la consulta, entonces se cancela la transacción.
            $this->db->trans_rollback();
            return false;
        } else { // Se realize primer insert correctamente
            $this->db->trans_commit();
            return true;
        }
    }

    function getComisionesByStatus($estatus, $user){
        $query = $this->db->query("SELECT cs.id_cliente, cs.nombre_cliente, cs.id_pago,  cs.estatus, cs.referencia, ps.id_pago_suma, ps.id_usuario,
        CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) nombre_comisionista, se.nombre sede, oxc.nombre forma_pago, 
        us.forma_pago id_forma_pago, ps.total_comision, ps.porcentaje_comision, cs.total_venta,
        (CASE us.forma_pago WHEN 3 THEN (((100-se.impuesto)/100)* ps.total_comision) ELSE ps.total_comision END) impuesto
        FROM comisiones_suma cs
        INNER JOIN pagos_suma ps ON ps.referencia = cs.referencia
        INNER JOIN usuarios us ON us.id_usuario = ps.id_usuario
        INNER JOIN sedes se ON se.id_sede = us.id_sede
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = us.forma_pago AND oxc.id_catalogo = 16
        WHERE ps.estatus = $estatus AND ps.id_usuario = $user");

        return $query->result_array();
    }

    function getHistorial($idPago){
        $result = $this->db->query("SELECT hs.fecha_movimiento, hs.comentario, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) modificado_por
        FROM historial_suma hs
        INNER JOIN usuarios u ON u.id_usuario = hs.id_usuario 
        WHERE id_pago = $idPago
        ORDER BY hs.fecha_movimiento DESC");

        return $result;
    }

    function insert_historial($data){
        $this->db->insert_batch('historial_suma', $data);
        return true;
    }

    function update_acepta_solicitante($idsol) {
        $query = $this->db->query("UPDATE pagos_suma SET estatus = 2 WHERE id_pago_suma IN (".$idsol.")");

        return true;
    }  

    function insertar_factura( $id_comision, $datos_factura,$usuarioid){
        $VALOR_TEXT = $datos_factura['textoxml'];
        $data = array(
            "fecha_factura"  => $datos_factura['fecha'],
            "folio_factura"  => $datos_factura['folio'],
            "descripcion" => $datos_factura['descripcion'],
            "subtotal" => $datos_factura['subTotal'],
            "total"  => $datos_factura['total'],
            "metodo_pago"  => $datos_factura['metodoPago'],
            "uuid" => $datos_factura['uuidV'],
            "nombre_archivo" => $datos_factura['nombre_xml'],
            "id_usuario" => $usuarioid,
            "id_pago_suma" => $id_comision,
            "regimen" => $datos_factura['regimenFiscal'],
            "forma_pago" => $datos_factura['formaPago'],
            "cfdi" => $datos_factura['usocfdi'],
            "unidad" => $datos_factura['claveUnidad'],
            "claveProd" => $datos_factura['claveProdServ']
        );
        
        return $this->db->insert("facturas_suma", $data);
    }

    function getAsimiladosRevision(){
        $datos = $this->db->query("SELECT ps.id_pago_suma, ps.referencia, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) nombreComisionista,
        se.nombre sede, oxc.nombre estatus, ps.total_comision, (CASE us.forma_pago WHEN 3 THEN (((100-se.impuesto)/100)* ps.total_comision) ELSE ps.total_comision END) impuesto,
        ps.porcentaje_comision, us.id_usuario
        FROM pagos_suma ps
        INNER JOIN usuarios us ON us.id_usuario = ps.id_usuario
        INNER JOIN sedes se ON se.id_sede = us.id_sede
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = ps.estatus AND oxc.id_catalogo = 74
        WHERE us.forma_pago = 3 AND ps.estatus IN (2, 4, 5)");

        return $datos;
    }
}
