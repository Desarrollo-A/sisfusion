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
        } else { // Se realiza primer insert correctamente
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

    function getAllComisiones($user, $year){
        $query = $this->db->query("SELECT cs.id_cliente, cs.nombre_cliente, cs.id_pago,  cs.estatus, cs.referencia, ps.id_pago_suma, ps.id_usuario,
        CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) nombre_comisionista, se.nombre sede, oxc.nombre forma_pago, 
        us.forma_pago id_forma_pago, ps.total_comision, ps.porcentaje_comision, cs.total_venta,
        (CASE us.forma_pago WHEN 3 THEN (((100-se.impuesto)/100)* ps.total_comision) ELSE ps.total_comision END) impuesto, oxc2.nombre estatus
        FROM comisiones_suma cs
        INNER JOIN pagos_suma ps ON ps.referencia = cs.referencia
        INNER JOIN usuarios us ON us.id_usuario = ps.id_usuario
        INNER JOIN sedes se ON se.id_sede = us.id_sede
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = us.forma_pago AND oxc.id_catalogo = 16
        INNER JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = ps.estatus AND oxc2.id_catalogo = 74 
        WHERE ps.id_usuario = $user AND year(ps.fecha_creacion) = $year");

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
        se.nombre sede, oxc.nombre estatusString, ps.estatus, ps.total_comision, (CASE us.forma_pago WHEN 3 THEN (((100-se.impuesto)/100)* ps.total_comision) ELSE ps.total_comision END) impuesto,
        ps.porcentaje_comision, us.id_usuario
        FROM pagos_suma ps
        INNER JOIN usuarios us ON us.id_usuario = ps.id_usuario
        INNER JOIN sedes se ON se.id_sede = us.id_sede
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = ps.estatus AND oxc.id_catalogo = 74
        WHERE us.forma_pago = 3 AND ps.estatus IN (2, 4)");

        return $datos;
    }

    function getAsimiladosRevisionIntMex($idRol, $idUsuario){
        $datos = $this->db->query("SELECT ps.id_pago_suma, ps.referencia, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) nombreComisionista, se.nombre sede, oxc.nombre estatusString, ps.estatus, ps.total_comision, (CASE us.forma_pago WHEN 3 THEN (((100-se.impuesto)/100)* ps.total_comision) ELSE ps.total_comision END) impuesto, ps.porcentaje_comision, us.id_usuario, oxc2.nombre puesto
        FROM pagos_suma ps
        INNER JOIN usuarios us ON us.id_usuario = ps.id_usuario
        INNER JOIN sedes se ON se.id_sede = us.id_sede
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = ps.estatus AND oxc.id_catalogo = 74
        INNER JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = us.id_rol AND oxc2.id_catalogo = 1
        WHERE ps.id_usuario = $idUsuario AND us.id_rol = $idRol AND us.forma_pago = 3 AND ps.estatus IN (3, 5)");

        return $datos;
    }

    function getRemanentesRevision(){
        $datos = $this->db->query("SELECT ps.id_pago_suma, ps.referencia, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) nombreComisionista,
        se.nombre sede, oxc.nombre estatusString, ps.estatus, ps.total_comision, (CASE us.forma_pago WHEN 3 THEN (((100-se.impuesto)/100)* ps.total_comision) ELSE ps.total_comision END) impuesto,
        ps.porcentaje_comision, us.id_usuario
        FROM pagos_suma ps
        INNER JOIN usuarios us ON us.id_usuario = ps.id_usuario
        INNER JOIN sedes se ON se.id_sede = us.id_sede
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = ps.estatus AND oxc.id_catalogo = 74
        WHERE us.forma_pago = 4 AND ps.estatus IN (2, 4)");

        return $datos;
    }

    function getFacturaRevision(){
        $datos = $this->db->query("SELECT ps.id_pago_suma, ps.referencia, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) nombreComisionista,
        se.nombre sede, oxc.nombre estatusString, ps.estatus, ps.total_comision, (CASE us.forma_pago WHEN 3 THEN (((100-se.impuesto)/100)* ps.total_comision) ELSE ps.total_comision END) impuesto,
        ps.porcentaje_comision, us.id_usuario
        FROM pagos_suma ps
        INNER JOIN usuarios us ON us.id_usuario = ps.id_usuario
        INNER JOIN sedes se ON se.id_sede = us.id_sede
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = ps.estatus AND oxc.id_catalogo = 74
        WHERE us.forma_pago = 2 AND ps.estatus IN (2, 4)");

        return $datos;
    }

    function getFacturaExtranjeroRevision(){
        $datos = $this->db->query("SELECT ps.id_pago_suma, ps.referencia, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) nombreComisionista,
        se.nombre sede, oxc.nombre estatusString, ps.estatus, ps.total_comision, (CASE us.forma_pago WHEN 3 THEN (((100-se.impuesto)/100)* ps.total_comision) ELSE ps.total_comision END) impuesto,
        ps.porcentaje_comision, us.id_usuario
        FROM pagos_suma ps
        INNER JOIN usuarios us ON us.id_usuario = ps.id_usuario
        INNER JOIN sedes se ON se.id_sede = us.id_sede
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = ps.estatus AND oxc.id_catalogo = 74
        WHERE us.forma_pago = 5 AND ps.estatus IN (2, 4)");

        return $datos;
    }

    function setPausarDespausarComision($estatus, $idPago, $idUsuario, $obs){
        $leyendaStatus = ( $estatus == 5 || $estatus == 4 ) ? 'PAUSÓ' : 'ACTIVÓ';

        $this->db->query("INSERT INTO historial_suma VALUES ($idPago, $idUsuario, GETDATE(), $estatus, 'SE ".$leyendaStatus." COMISIÓN, MOTIVO: ".strtoupper($obs)." ')");
        return $this->db->query("UPDATE pagos_suma SET estatus = $estatus WHERE id_pago_suma = $idPago");
    }

    function setAsimiladosInternomex($updateArray, $insertArray){
        $this->db->trans_begin();
        $c = $this->db->update_batch('pagos_suma', $updateArray, 'id_pago_suma');
        $b = $this->db->insert_batch('historial_suma', $insertArray);
        if ($this->db->trans_status() === FALSE) { // Hubo errores en la consulta, entonces se cancela la transacción.
            $this->db->trans_rollback();
            return false;
        } else { // Se realize primer insert correctamente
            $this->db->trans_commit();
            return true;
        }
    }

    function setPagosInternomex($updateArray, $insertArray){
        $this->db->trans_begin();
        $c = $this->db->update_batch('pagos_suma', $updateArray, 'id_pago_suma');
        $b = $this->db->insert_batch('historial_suma', $insertArray);
        if ($this->db->trans_status() === FALSE) { // Hubo errores en la consulta, entonces se cancela la transacción.
            $this->db->trans_rollback();
            return false;
        } else { // Se realize primer insert correctamente
            $this->db->trans_commit();
            return true;
        }
    }

    function get_lista_roles(){
        return $this->db->query("SELECT id_opcion AS idRol, nombre AS descripcion FROM opcs_x_cats WHERE id_catalogo = 1 and id_opcion in (3,9,7) ORDER BY nombre");
    }

    function get_lista_usuarios($rol, $forma_pago){
        return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS nombre FROM usuarios WHERE id_usuario in (SELECT id_usuario FROM pagos_suma WHERE estatus in (3, 5)) AND id_rol = $rol AND forma_pago = $forma_pago ORDER BY nombre");
    }

    function getRemanentesRevisionInternomex(){
        $datos = $this->db->query("SELECT ps.id_pago_suma, ps.referencia, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) nombreComisionista,
        se.nombre sede, oxc.nombre estatusString, ps.estatus, ps.total_comision, (CASE us.forma_pago WHEN 3 THEN (((100-se.impuesto)/100)* ps.total_comision) ELSE ps.total_comision END) impuesto,
        ps.porcentaje_comision, us.id_usuario
        FROM pagos_suma ps
        INNER JOIN usuarios us ON us.id_usuario = ps.id_usuario
        INNER JOIN sedes se ON se.id_sede = us.id_sede
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = ps.estatus AND oxc.id_catalogo = 74
        WHERE us.forma_pago = 4 AND ps.estatus IN (2, 4, 5)");

        return $datos;
    }

    function getDatosNuevasXSuma(){
        return $this->db->query("SELECT SUM(pci1.total_comision) total,  CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, u.forma_pago, 0 as factura, oxcest.id_opcion id_estatus_actual, opn.estatus estatus_opinion, opn.archivo_name, fa.uuid,fa.nombre_archivo as xmla, fa.bandera, u.rfc, pci1.id_usuario
        FROM pagos_suma pci1 
        INNER JOIN comisiones_suma com ON pci1.referencia = com.referencia  
        INNER JOIN usuarios u ON u.id_usuario = pci1.id_usuario  
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 74 
        INNER JOIN opinion_cumplimiento opn ON opn.id_usuario = u.id_usuario  and opn.estatus IN (2) 
        INNER JOIN facturas_suma fa ON fa.id_pago_suma = pci1.id_pago_suma
        GROUP BY  u.nombre, u.apellido_paterno, u.apellido_materno, u.forma_pago, oxcest.id_opcion, opn.estatus, opn.archivo_name, fa.uuid,fa.nombre_archivo,fa.bandera, u.rfc, pci1.id_usuario
        ORDER BY u.nombre");
    }

    function get_solicitudes_factura($usuario){
        return $this->db->query("SELECT ps.total_comision, cm.referencia, ps.id_pago_suma
        FROM pagos_suma ps 
        INNER JOIN comisiones_suma cm ON ps.referencia = cm.referencia  
        INNER JOIN usuarios u ON u.id_usuario = ps.id_usuario AND u.id_usuario = $usuario
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = ps.estatus AND oxcest.id_catalogo = 74 
        INNER JOIN opinion_cumplimiento opn ON opn.id_usuario = u.id_usuario AND opn.estatus IN (2) 
        INNER JOIN facturas_suma fa ON fa.id_pago_suma = ps.id_pago_suma
        GROUP BY ps.total_comision, cm.referencia, ps.id_pago_suma")->result_array();
    }

    
    function factura_comision( $uuid){
        return $this->db->query("SELECT DISTINCT(CAST(f.uuid AS VARCHAR(MAX))) AS uuid, u.nombre, u.apellido_paterno, u.apellido_materno, f.fecha_factura, f.folio_factura, 
		f.metodo_pago, f.regimen, f.forma_pago, f.cfdi, f.unidad, f.claveProd, f.total, f.total as porcentaje_dinero, f.nombre_archivo, 
		CAST(f.descripcion AS VARCHAR(MAX)) AS descrip, f.fecha_ingreso

        FROM facturas_suma f
        INNER JOIN pagos_suma p ON p.id_pago_suma = f.id_pago_suma  
        INNER JOIN usuarios u ON u.id_usuario = p.id_usuario --AND u.id_usuario = 896
		WHERE f.uuid = '".$uuid."' ");
        }
    
 

  
}
