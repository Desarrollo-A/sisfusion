
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dispersion_automatica_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        // $this->gphsis = $this->load->database('GPHSIS', TRUE);
    }


    public function getDatosDispersion (){
     /* pc.porcentaje_saldos, (CASE us.id_usuario WHEN 832 THEN 25  ELSE pc.porcentaje_saldos END) porcentaje_saldos,*/
     /*INNER JOIN porcentajes_comisiones pc ON pc.id_rol = com.rol_generado  AND pc.relacion_prospeccion = $rel_final*/
     
    $cmd = "SELECT com.id_comision, com.id_usuario, lo.totalNeto2, lo.idLote, res.idResidencial, lo.referencia, lo.tipo_venta,
     com.id_lote, lo.nombreLote, com.porcentaje_decimal, CONCAT(us.nombre,' ' ,us.apellido_paterno,' ',us.apellido_materno) colaborador, 
     CASE 
     WHEN 0 = 1 THEN oxc2.nombre ELSE oxc.nombre END as rol, 
     com.comision_total, pci.abono_pagado, 
     com.rol_generado,

     com.descuento
     FROM comisiones com
     LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind 
     GROUP BY id_comision) pci ON pci.id_comision = com.id_comision
     INNER JOIN lotes lo ON lo.idLote = com.id_lote 
     INNER JOIN usuarios us ON us.id_usuario = com.id_usuario
     INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = com.rol_generado AND oxc.id_catalogo = 1
     INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
     INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
     LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = com.rol_generado AND oxc2.id_catalogo = 83

     WHERE com.id_lote = 66018  AND com.estatus = 1 ORDER BY com.rol_generado asc"; 

    $query =  $this->db->query($cmd);
    return $query->result_array();

    }


}