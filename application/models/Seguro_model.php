<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Seguro_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    //MODELO DEDIC]
    function validaLoteComision($referencia, $empresa, $nombreLote){
        $query = $this->db->query("SELECT  lo.idLote , 
        ps.bandera,cs.id_comision,cs.comision_total ,
        lo.idLote,lo.idCliente, ps.abonado, ps.total_comision, 
        cs.id_usuario,cs.porcentaje_decimal,ps.pendiente,
        ps.id_pagoc ,psi.abono_pagado , psi.id_comision as pagoind
        FROM  lotes lo 
        INNER JOIN pago_seguro ps ON ps.id_lote = lo.idLote 
        INNER JOIN comisiones_seguro cs on cs.idCliente = lo.idCliente  

        LEFT JOIN  (SELECT SUM(abono_neodata) abono_pagado, id_comision 
		FROM pago_seguro_ind WHERE (estatus in (1,3) OR descuento_aplicado = 1) 
		GROUP BY id_comision) psi ON psi.id_comision = cs.id_comision

        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio 
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        WHERE lo.referencia = $referencia 
        AND lo.nombreLote = '".$nombreLote."' AND re.empresa = '".$empresa."'");

        return $query->result_array();
    }


    function getInfoLote($referencia, $empresa, $nombreLote){
        $query = $this->db->query("SELECT lo.idLote , idCliente
        FROM lotes lo
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        WHERE lo.referencia = $referencia AND lo.nombreLote = '".$nombreLote."' AND re.empresa = '".$empresa."'");
        return $query->row();
    }



    function getPlanComision($idAsesor, $idGerente,$totalSeguro){
        $query = $this->db->query("DECLARE @idAsesor INT=$idAsesor,@idGerente INT = $idGerente, @totalSeguro FLOAT = $totalSeguro
            /* DIRECTOR */
        (SELECT DISTINCT(u1.id_usuario) AS id_usuario, up.valorComision porcentaje_decimal, ((@totalSeguro/100)*(up.valorComision)) comision_total, 
        CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, up.rolComisionista as id_rol,
        CASE WHEN up.comentario != '' THEN opc.nombre ELSE up.comentario END detail_rol, 1 as rolVal
        FROM plan_comision_seguros pl 
        INNER JOIN usuariosPlanComisionSeguros up ON up.idPlan=pl.id_plan
        INNER JOIN usuarios u1 ON u1.id_usuario=1980 AND up.rolComisionista=18
        INNER JOIN opcs_x_cats opc ON opc.id_opcion=u1.id_rol AND opc.id_catalogo=1
        )
        UNION
        (SELECT DISTINCT(u1.id_usuario) AS id_usuario, pl.comAsesor porcentaje_decimal, ((@totalSeguro/100)*(pl.comAsesor)) comision_total,
            CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, pl.asesor as id_rol, 
            opc.nombre as detail_rol, 3 rolVal
            FROM plan_comision_seguros pl
            INNER JOIN usuarios u1 ON u1.id_usuario = @idAsesor
            INNER JOIN opcs_x_cats opc ON opc.id_opcion=u1.id_rol AND opc.id_catalogo=1
        )
        UNION
        (SELECT DISTINCT(u1.id_usuario) AS id_usuario, pl.comGerente porcentaje_decimal, ((@totalSeguro/100)*(pl.comGerente)) comision_total,
            CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, pl.asesor as id_rol, 
            opc.nombre as detail_rol, 2 rolVal
            FROM plan_comision_seguros pl
            INNER JOIN usuarios u1 ON u1.id_usuario = @idGerente
            INNER JOIN opcs_x_cats opc ON opc.id_opcion=u1.id_rol AND opc.id_catalogo=1
        )
        UNION
        (SELECT DISTINCT(u1.id_usuario) AS id_usuario, up.valorComision porcentaje_decimal, ((@totalSeguro/100)*(up.valorComision)) comision_total,
            CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, pl.asesor as id_rol, 
            CASE WHEN up.comentario != '' THEN opc.nombre ELSE up.comentario END detail_rol, 1 as rolVal
            FROM plan_comision_seguros pl
            INNER JOIN usuariosPlanComisionSeguros up ON up.idPlan=pl.id_plan 
            INNER JOIN usuarios u1 ON u1.id_usuario = up.idUsuario AND u1.id_usuario NOT IN (1980)
            INNER JOIN opcs_x_cats opc ON opc.id_opcion=u1.id_rol AND opc.id_catalogo=1
        )");
            return $query->result_array();
        }


        function insertComisionSeguro($tabla, $data,$dataIndividual,$dataHistorialSeguros,$dataPagoSeguro) {
            if ($data != '' && $data != null){
                $response = $this->db->insert('comisiones_seguro', $data);
                if($tabla = 'comisiones_seguro'){

                $insertComision = $this->db->insert_id();
                // $cdmInsertPagoComision = "INSERT INTO  historial_comisiones 
                // VALUES ($insert_id_2, ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'DISPERSÓ CLUB MADERAS')";
                $dataIndividual['id_comision'] = $insertComision;

                $responsePago_seguro_ind = $this->db->insert('pago_seguro_ind', $dataIndividual);
                $responsePago_seguro_ind_Id = $this->db->insert_id();
                // $respuesta = $this->db->query("");             

                $dataHistorialSeguros['id_pago_i'] = $responsePago_seguro_ind_Id;

                $responsePago_seguro_ind = $this->db->insert('historial_seguro', $dataHistorialSeguros);

                // $dataPagoSeguro = $this->db->insert('pago_seguro', $dataPagoSeguro);
                
                }
                if (!$response) {
                    return 0;
                } else {
                    return 1;
                    // return 1;
                }
            } else {
                return 0;
            }
        }


        function poderVentas($idAsesor) {
            $cmd = "select up.id_usuario as id_usuarioUp,    up.id_rol as id_rolUp,   
            CONCAT(up.nombre,' ',up.apellido_paterno,' ',up.apellido_materno) AS nombreUP,
            up2.id_usuario as id_usuarioUp2 ,  up2.id_rol as id_rolUp2, 
            CONCAT(up2.nombre,' ',up2.apellido_paterno,' ',up2.apellido_materno) AS nombreUp2,
            up3.id_usuario  as id_usuarioUp3,   up3.id_rol as id_rolUp3, 
            CONCAT(up3.nombre,' ',up3.apellido_paterno,' ',up3.apellido_materno) AS nombreUp3
            from usuarios up
            INNER JOIN  usuarios up2 on up2.id_usuario = up.id_lider
            INNER JOIN  usuarios up3 on up3.id_usuario = up2.id_lider
            where up.id_usuario = $idAsesor";

            $query = $this->db->query($cmd);
            return $query->result_array();
        }


        function pago_seguro($dataPagoSeguro) {
            if ($dataPagoSeguro != '' && $dataPagoSeguro != null){
                $dataPagoSeguro = $this->db->insert('pago_seguro', $dataPagoSeguro);
                if (!$dataPagoSeguro) {
                    return 0;
                } else {
                    return 1;
                    // return 1;
                }
            } else {
                return 0;
            }

        }
        function getDatosComisionesAsesor($estado){
            $user_data = $this->session->userdata('id_usuario');
            $sede = $this->session->userdata('id_sede');
            
            return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision,lo.nombreLote  lote, re.nombreResidencial as proyecto, pac.totalLote precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, oxcpj.nombre as pj_name, u.forma_pago, pac.porcentaje_abono, 0 as factura, 1 expediente,
    
            oxcest.nombre  estatus_actual,
 
             (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, pac.bonificacion, cl.lugar_prospeccion,
             pci1.fecha_abono, opt.fecha_creacion AS fecha_opinion, opt.estatus as estatus_opinion, 
 
             (CASE WHEN cl.proceso = 0 THEN '' ELSE oxc0.nombre END) procesoCl,
             (CASE WHEN cl.proceso = 0 THEN '' ELSE 'label lbl-violetBoots' END) colorProcesoCl, cl.proceso, ISNULL(cl.id_cliente_reubicacion_2, 0)
 
             FROM pago_seguro_ind pci1 
             INNER JOIN comisiones_seguro com ON pci1.id_comision = com.id_comision
             INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1
             INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
             INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
             INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
             INNER JOIN usuarios u ON u.id_usuario = com.id_usuario  
             INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago AND oxcpj.id_catalogo = 16 
             LEFT JOIN pago_seguro pac ON pac.id_lote = com.id_lote
             INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
             INNER JOIN sedes sed ON sed.id_sede = 2 and sed.estatus = 1
             LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
             LEFT JOIN (SELECT id_usuario, fecha_creacion, estatus FROM opinion_cumplimiento WHERE estatus = 1) opt ON opt.id_usuario = com.id_usuario
             WHERE pci1.estatus IN ($estado) AND com.estatus in ($estado) AND lo.idStatusContratacion > 8   AND com.id_usuario = $user_data
             GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, pac.totalLote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata,
             pci1.pago_neodata, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, oxcpj.nombre, u.forma_pago,pci1.id_pago_i, pac.porcentaje_abono, oxcest.nombre, sed.impuesto, 
             pac.bonificacion, cl.lugar_prospeccion, opt.fecha_creacion, opt.estatus, cl.proceso, oxc0.nombre, cl.id_cliente_reubicacion_2");
        }

        public function getTotalComisionAsesor($idUsuario) {
            $query = $this->db->query("SELECT SUM(pci.abono_neodata) AS total
            FROM pago_seguro_ind pci 
            INNER JOIN comisiones_seguro com ON pci.id_comision = com.id_comision 
            where pci.estatus = 1 and com.id_usuario = $idUsuario");
            return $query->row();
        }
        function getComments($pago){
            $this->db->query("SET LANGUAGE Español;");
            return $this->db->query("SELECT DISTINCT(hc.comentario), hc.id_pago_i, hc.id_usuario, convert(nvarchar(20), hc.fecha_movimiento, 113) date_final, hc.fecha_movimiento, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_usuario
            FROM historial_seguro hc 
            INNER JOIN pago_seguro_ind pci ON pci.id_pago_i = hc.id_pago_i
            INNER JOIN usuarios u ON u.id_usuario = hc.id_usuario 
            WHERE hc.id_pago_i = $pago
            ORDER BY hc.fecha_movimiento DESC");
        }
        function consulta_codigo_postal($id_user){
            return $this->db->query("SELECT estatus, codigo_postal FROM cp_usuarios WHERE id_usuario = $id_user");
        }

        function update_acepta_solicitante($idsol) {
            $query = $this->db->query("UPDATE pago_seguro_ind SET estatus = 4, fecha_pago_intmex = GETDATE(),modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$idsol.")");
            return true;
        }
        function insertComisionSeguroAbono($dataIndividual,$banderaAbono , $comision) {
            if ($dataIndividual != '' && $dataIndividual != null){
                $response = $this->db->insert('pago_seguro_ind', $dataIndividual);
                if (!$response) {
                    return 0;
                } else {
                    return 1;
                    // return 1;
                }
                if($banderaAbono == 1){
                    "UPDATE pago_seguro set bandera = 7 where id_pagoc = $comision";
                } 
            } else {
                return 0;
            }
        }
        function updatePagoSeguro($cmd) {
            var_dump($cmd);
                $response = $this->db->query($cmd);
                var_dump($response);
                if ($response) {
                    return 1;
                } else {
                    return 0;
                    // return 1;
                }
        }

        

}