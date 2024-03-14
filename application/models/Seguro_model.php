<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Seguro_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    //MODELO DEDIC]
    function validaLoteComision($referencia, $empresa, $nombreLote){
        $query = $this->db->query("SELECT po.id_lote 
        FROM pago_seguro po 
        INNER JOIN lotes lo ON lo.idLote = po.id_lote
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        WHERE lo.referencia = $referencia AND lo.nombreLote = '".$nombreLote."' AND re.empresa = '".$empresa."'");

        return $query->result_array();
    }


    function getInfoLote($referencia, $empresa, $nombreLote){
        $query = $this->db->query("SELECT lo.idLote
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
            return $query->row();
        }


        function insertComisionSeguro($tabla, $data) {
            if ($data != '' && $data != null){
                $response = $this->db->insert($tabla, $data);
                if (!$response) {
                    return 0;
                } else {
                    return 1;
                }
            } else {
                return 0;
            }
        }
    
}