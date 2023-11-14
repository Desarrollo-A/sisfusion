
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dispersion_automatica_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
        // $this->gphsis = $this->load->database('GPHSIS', TRUE);


    public function getDatosDispersion (){
     /* pc.porcentaje_saldos, (CASE us.id_usuario WHEN 832 THEN 25  ELSE pc.porcentaje_saldos END) porcentaje_saldos,*/
     /*INNER JOIN porcentajes_comisiones pc ON pc.id_rol = com.rol_generado  AND pc.relacion_prospeccion = $rel_final*/
     
    $cmd = "SELECT com.id_comision, com.id_usuario, lo.totalNeto2, lo.idLote, res.idResidencial, lo.referencia, lo.tipo_venta,
     com.id_lote, lo.nombreLote, com.porcentaje_decimal, CONCAT(us.nombre,' ' ,us.apellido_paterno,' ',us.apellido_materno) colaborador, 
     CASE WHEN 0 = 1 THEN oxc2.nombre ELSE oxc.nombre END as rol, 
     com.comision_total, pci.abono_pagado, com.rol_generado, com.descuento
     FROM comisiones com
     LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind 
     GROUP BY id_comision) pci ON pci.id_comision = com.id_comision
     INNER JOIN lotes lo ON lo.idLote = com.id_lote 
     INNER JOIN usuarios us ON us.id_usuario = com.id_usuario
     INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = com.rol_generado AND oxc.id_catalogo = 1
     INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
     INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
     LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = com.rol_generado AND oxc2.id_catalogo = 83
     WHERE  com.estatus = 1 ORDER BY com.rol_generado asc"; 
    $query =  $this->db->query($cmd);
    return $query->result_array();

    }

    public function porcentajeLotes ($idLote){
        $cmd  = "SELECT l.idLote,cl.id_cliente, cl.plan_comision ,
		comi.id_pagoc , com.id_comision 
		,com.id_usuario 
		,com.idCliente
         FROM  clientes cl 
		 INNER JOIN lotes l on l.idLote = cl.idLote
		 INNER JOIN pago_comision comi on comi.id_lote = l.idLote
		 INNER JOIN comisiones com on com.id_lote = l.idLote  and com.estatus = 1 
		 WHERE  l.idLote = $idLote ";
        $query = $this->db->query($cmd);
        return $query->result_array();
    }

    function insert_dispersion_individual($id_comision, $id_usuario, $abono_nuevo, $pago){

        if($id_usuario == 2){
            return false;
        }else{
        $respuesta = $this->db->query("INSERT INTO pago_comision_ind (id_comision, id_usuario, abono_neodata, fecha_abono, fecha_pago_intmex, estatus, pago_neodata, creado_por, comentario,modificado_por) VALUES (".$id_comision.", ".$id_usuario.", ".$abono_nuevo.", GETDATE(), GETDATE(), 1, ".$pago.", ".$this->session->userdata('id_usuario').", 'NUEVO PAGO','".$this->session->userdata('id_usuario')."')");
        $insert_id_2 = $this->db->insert_id();
        $respuesta = $this->db->query("INSERT INTO historial_comisiones VALUES ($insert_id_2, ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'DISPERSÓ PAGO DE COMISIÓN')");
    }
        if (! $respuesta ) {
            return 0;
            } else {
            return 1;
            }
    }
    
        public function consulta ($idLote) {
        $cmd = " SELECT com.id_comision, com.id_usuario, 
        (CASE WHEN ((com.comision_total-ISNULL(pci.abonado, 0))) <= ((pc.new_neo-ISNULL(pci.abonado, 0))*(0.125*com.porcentaje_decimal)) 
        THEN ((com.comision_total - ISNULL(pci.abonado, 0)))
        WHEN ((com.comision_total-ISNULL(pci.abonado, 0))) > ((pc.new_neo-ISNULL(pci.abonado, 0))*(0.125*com.porcentaje_decimal)) 
        THEN  ((pc.new_neo - ISNULL(pci.abonado, 0))*(0.125*com.porcentaje_decimal)) 
        ELSE 0 END) abono_neodata, pc.new_neo pago_neodata, com.id_lote
       
        FROM comisiones com 
        INNER JOIN pago_comision pc ON pc.id_lote = com.id_lote 
        AND pc.bandera = 2
        LEFT JOIN (SELECT SUM(abono_neodata) abonado, id_comision FROM pago_comision_ind pci GROUP BY id_comision) pci ON pci.id_comision = com.id_comision
        WHERE com.estatus = 1 and com.descuento NOT IN (1) 
        AND (pc.new_neo - pc.abonado) > 0 
        AND  com.id_lote = $idLote";
        
        $query = $this->db->query($cmd);        

        return $query->result_array();

    }



    public function getLotesPagadosAutomatica($res){
        $cmd = "SELECT p.id_lote, p.numero_dispersion, 
        p.ultima_dispersion ,p.bandera,l.registro_comision, 
        p.ultimo_pago,l.referencia,r.idResidencial 
        FROM pago_comision p
        INNER JOIN lotes l ON l.idLote = p.id_lote
        INNER JOIN condominios c ON c.idCondominio = l.idCondominio
        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
        WHERE p.bandera = 2
        AND l.registro_comision IN (1,5) 
        AND l.idStatusContratacion = 15 
        AND p.ultimo_pago > 0 
        AND r.idResidencial = $res";
        $query =  $this->db->query($cmd);
        return $query->result_array();
    }
    








}