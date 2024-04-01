
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resguardos_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    //MODELO DEDICADO A PROCESO DE RESGUARDO QUE APLICA UNICAMENTE PARA CONTRALORIA Y SUBDIRECTORES, DIRECTORES DE VENTAS
    function getRetiros($user,$opc){
        $query = '';
        if($opc == 2){
            $query = 'AND rc.estatus in(67)';
        }
        return $this->db->query("SELECT rc.id_rc,CONCAT(us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno) AS usuario,rc.monto, UPPER(CONVERT(VARCHAR,rc.conceptos)) AS conceptos,rc.fecha_creacion,rc.estatus,CONCAT(u2.nombre,' ',u2.apellido_paterno,' ',u2.apellido_materno) AS creado_por,rc.estatus from usuarios us inner join resguardo_conceptos rc on rc.id_usuario=us.id_usuario inner join usuarios u2 on u2.id_usuario=rc.creado_por where rc.id_usuario=$user $query");
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
    function getDatosResguardoContraloria($usuario,$proyecto){
        if($proyecto == 0){
            $filtro_00 = ' ';
        } else{
            $filtro_00 = ' AND re.idResidencial = '.$proyecto.' ';
        }
        
        switch ($this->session->userdata('id_rol')) {
            case 1:
            case 2:
            case 3:
                $filtro_02 = ' pci1.estatus IN (3) AND com.id_usuario = '.$this->session->userdata('id_usuario').' '.$filtro_00;
            break;
    
            default:
                $filtro_02 = ' pci1.estatus IN (3) AND pci1.id_usuario = '.$usuario.' '.$filtro_00;
            break;
        }

        return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision,
        (CASE WHEN com.ooam = 2 THEN CONCAT(lo.nombreLote,' <i>(',com.loteReubicado,')</i>') ELSE lo.nombreLote END) nombreLote, 
        re.nombreResidencial as proyecto, co.nombre as condominio,lo.totalNeto2 precio_lote, 
        com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente,
        pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion, 
        CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names ,pci1.id_usuario, 
        CASE WHEN cl.estructura = 1 THEN UPPER(oprol2.nombre) ELSE UPPER(oprol.nombre) END as puesto, 
        (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (EEC)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, 
        pci1.descuento_aplicado, (CASE WHEN cl.lugar_prospeccion IS NULL THEN 0 ELSE cl.lugar_prospeccion END) lugar_prospeccion, lo.referencia, 
        pac.bonificacion, u.estatus as activo, 
        (CASE WHEN pe.id_penalizacion IS NOT NULL THEN 1 ELSE 0 END) penalizacion, oxcest.color,
        (CASE WHEN cl.proceso = 0 THEN '' ELSE oxc0.nombre END) procesoCl,
        (CASE WHEN cl.proceso = 0 THEN '' ELSE 'label lbl-violetBoots' END) colorProcesoCl, 
        cl.proceso, ISNULL(cl.id_cliente_reubicacion_2, 0) id_cliente_reubicacion_2
        FROM pago_comision_ind pci1 
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision 
        FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
        GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision and com.estatus = 1
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.status = 1 AND lo.idStatusContratacion > 8
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
        LEFT JOIN penalizaciones pe ON pe.id_lote = lo.idLote AND pe.id_cliente = lo.idCliente
        LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
        LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
        WHERE $filtro_02
        GROUP BY pci1.id_comision,com.ooam,com.loteReubicado, lo.nombreLote,
        re.nombreResidencial, co.nombre, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata,
        pci1.pago_neodata, pci2.abono_pagado, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, pci1.id_pago_i, u.nombre, 
        u.apellido_paterno, u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, pci1.descuento_aplicado, cl.lugar_prospeccion, lo.referencia, com.estatus, pac.bonificacion, u.estatus,pe.id_penalizacion, oxcest.color, cl.estructura, oprol2.nombre, cl.proceso, oxc0.nombre, cl.id_cliente_reubicacion_2 ORDER BY lo.nombreLote");

    }


   
    }