<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Internomex_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    

     function getDatosNuevasInternomex($proyecto,$condominio){

        if($condominio == 0){
                return $this->db->query("SELECT pci1.id_pago_i, re.nombreResidencial as proyecto, lo.nombreLote, lo.totalNeto2 precio_lote, pci1.abono_neodata a_pagar, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) comisionista, oprol.nombre as puesto, u.forma_pago, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, oxformap.nombre AS regimen 
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus 
                 INNER JOIN opcs_x_cats oxformap ON oxformap.id_opcion = u.forma_pago 
                 WHERE pci1.estatus IN (8) AND re.idResidencial = $proyecto AND oxformap.id_catalogo = 16
                 AND com.estatus in (1) AND oprol.id_catalogo = 1 AND oxcest.id_catalogo = 23 AND lo.status = 1 AND cl.status = 1
                 GROUP BY pci1.id_pago_i, re.nombreResidencial, lo.nombreLote, lo.totalNeto2, pci1.abono_neodata, pci1.estatus, pci1.fecha_abono, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, u.forma_pago, oxcest.nombre, oxcest.id_opcion, re.empresa, oxformap.nombre
                 ORDER BY lo.nombreLote");
    
            }else{
                return $this->db->query("SELECT pci1.id_pago_i, re.nombreResidencial as proyecto, lo.nombreLote, lo.totalNeto2 precio_lote, pci1.abono_neodata a_pagar, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) comisionista, oprol.nombre as puesto, u.forma_pago, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, oxformap.nombre AS regimen 
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus 
                 INNER JOIN opcs_x_cats oxformap ON oxformap.id_opcion = u.forma_pago 
                 WHERE pci1.estatus IN (8) AND co.idCondominio = $condominio AND oxformap.id_catalogo = 16
                 AND com.estatus in (1) AND oprol.id_catalogo = 1 AND oxcest.id_catalogo = 23 AND lo.status = 1 AND cl.status = 1
                 GROUP BY pci1.id_pago_i, re.nombreResidencial, lo.nombreLote, lo.totalNeto2, pci1.abono_neodata, pci1.estatus, pci1.fecha_abono, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, u.forma_pago, oxcest.nombre, oxcest.id_opcion, re.empresa, oxformap.nombre
                 ORDER BY lo.nombreLote");
         }
        }



             function getDatosAplicadosInternomex($proyecto,$condominio){

        if($condominio == 0){
                return $this->db->query("SELECT pci1.id_pago_i, re.nombreResidencial as proyecto, lo.nombreLote, lo.totalNeto2 precio_lote, pci1.abono_neodata a_pagar, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) comisionista, oprol.nombre as puesto, u.forma_pago, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, oxformap.nombre AS regimen 
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus 
                 INNER JOIN opcs_x_cats oxformap ON oxformap.id_opcion = u.forma_pago 
                 WHERE pci1.estatus IN (9) AND re.idResidencial = $proyecto AND oxformap.id_catalogo = 16
                 AND com.estatus in (1) AND oprol.id_catalogo = 1 AND oxcest.id_catalogo = 23 AND lo.status = 1 AND cl.status = 1
                 GROUP BY pci1.id_pago_i, re.nombreResidencial, lo.nombreLote, lo.totalNeto2, pci1.abono_neodata, pci1.estatus, pci1.fecha_abono, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, u.forma_pago, oxcest.nombre, oxcest.id_opcion, re.empresa, oxformap.nombre
                 ORDER BY lo.nombreLote");
    
            }else{
                return $this->db->query("SELECT pci1.id_pago_i, re.nombreResidencial as proyecto, lo.nombreLote, lo.totalNeto2 precio_lote, pci1.abono_neodata a_pagar, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) comisionista, oprol.nombre as puesto, u.forma_pago, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, oxformap.nombre AS regimen 
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus 
                 INNER JOIN opcs_x_cats oxformap ON oxformap.id_opcion = u.forma_pago 
                 WHERE pci1.estatus IN (9) AND co.idCondominio = $condominio AND oxformap.id_catalogo = 16
                 AND com.estatus in (1) AND oprol.id_catalogo = 1 AND oxcest.id_catalogo = 23 AND lo.status = 1 AND cl.status = 1
                 GROUP BY pci1.id_pago_i, re.nombreResidencial, lo.nombreLote, lo.totalNeto2, pci1.abono_neodata, pci1.estatus, pci1.fecha_abono, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, u.forma_pago, oxcest.nombre, oxcest.id_opcion, re.empresa, oxformap.nombre
                 ORDER BY lo.nombreLote");
         }
        }



        function getDatosHistorialInternomex($proyecto,$condominio){

        if($condominio == 0){
                return $this->db->query("SELECT pci1.id_pago_i, re.nombreResidencial as proyecto, lo.nombreLote, lo.totalNeto2 precio_lote, pci1.abono_neodata a_pagar, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) comisionista, oprol.nombre as puesto, u.forma_pago, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, oxformap.nombre AS regimen 
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus 
                 INNER JOIN opcs_x_cats oxformap ON oxformap.id_opcion = u.forma_pago 
                 WHERE pci1.estatus IN (8,9,10,11) AND pci1.descuento_aplicado = 0  AND re.idResidencial = $proyecto AND oxformap.id_catalogo = 16
                 AND com.estatus in (1) AND oprol.id_catalogo = 1 AND oxcest.id_catalogo = 23 AND lo.status = 1 AND cl.status = 1
                 GROUP BY pci1.id_pago_i, re.nombreResidencial, lo.nombreLote, lo.totalNeto2, pci1.abono_neodata, pci1.estatus, pci1.fecha_abono, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, u.forma_pago, oxcest.nombre, oxcest.id_opcion, re.empresa, oxformap.nombre
                 ORDER BY lo.nombreLote");
    
            }else{
                return $this->db->query("SELECT pci1.id_pago_i, re.nombreResidencial as proyecto, lo.nombreLote, lo.totalNeto2 precio_lote, pci1.abono_neodata a_pagar, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) comisionista, oprol.nombre as puesto, u.forma_pago, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, oxformap.nombre AS regimen 
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus 
                 INNER JOIN opcs_x_cats oxformap ON oxformap.id_opcion = u.forma_pago 
                 WHERE pci1.estatus IN (8,9,10,11) AND pci1.descuento_aplicado = 0 AND co.idCondominio = $condominio AND oxformap.id_catalogo = 16
                 AND com.estatus in (1) AND oprol.id_catalogo = 1 AND oxcest.id_catalogo = 23 AND lo.status = 1 AND cl.status = 1
                 GROUP BY pci1.id_pago_i, re.nombreResidencial, lo.nombreLote, lo.totalNeto2, pci1.abono_neodata, pci1.estatus, pci1.fecha_abono, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, u.forma_pago, oxcest.nombre, oxcest.id_opcion, re.empresa, oxformap.nombre
                 ORDER BY lo.nombreLote");
         }
        }


        function update_aplica_intemex($idsol) {
            $this->db->query("INSERT INTO historial_comisiones VALUES ($idsol, ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'SE APLICÓ PAGO DE INTERNOMEX')");
            return $this->db->query("UPDATE pago_comision_ind SET estatus = 9 WHERE id_pago_i IN (".$idsol.")");
        }

    

}
