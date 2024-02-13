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



    function getPlanComision($rol, $planComision){
            $query = $this->db->query("SELECT (CASE 
            WHEN $rol = asesor THEN comAs 
            WHEN $rol = coordinador THEN comCo
            WHEN $rol = gerente THEN comGe 
            WHEN $rol = subdirector THEN comSu 
            WHEN $rol = director THEN comDi 
            END) AS porcentajeComision,
            (CASE 
            WHEN $rol = asesor THEN neoAs 
            WHEN $rol = coordinador THEN neoCo 
            WHEN $rol = gerente THEN neoGe 
            WHEN $rol = subdirector THEN neoSu 
            WHEN $rol = director THEN neoDi 
            END) AS porcentajeNeodata
            
            FROM plan_comision WHERE id_plan = $planComision");
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