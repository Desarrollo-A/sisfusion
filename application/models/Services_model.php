<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Services_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function getNacionalidades()
    {
        $FormasPago =  $this->db->query("SELECT id_opcion as id_forma_pago,nombre as forma_pago FROM opcs_x_cats WHERE id_catalogo=16")->result_array();
       $ArrayMex = $FormasPago;
       $contadorMex=0;
       $contadorExt=0;
        unset($ArrayMex[4]);
        $ArrayExt =  array_pop($FormasPago);

        $Nacionalidades =  $this->db->query("SELECT id_opcion as id_nacionalidad,nombre as nacionalidad,
        CASE WHEN id_opcion=0 THEN 0 ELSE 1 END as tipo_contrato
         FROM opcs_x_cats WHERE id_catalogo=11 and id_opcion in(0,1,14,17)")->result_array();
        for ($m=0; $m <count($Nacionalidades) ; $m++) { 
                if($m == 0){
                    $Nacionalidades[$m]['tipo_pago'] = $ArrayMex; 
                }else{
                    $Nacionalidades[$m]['tipo_pago'] = $ArrayExt;
                } 
        }
        return $Nacionalidades;
    }



     function saveUserCH($data) {
        if ($data != '' && $data != null) {
            $this->db->db_debug = false;
            $response = $this->db->insert("usuarios", $data);
            if (!$response) {  
            $error = $this->db->error();
            $datos = explode('.',$error['message']);
          //  echo  $error['code'];
            //echo $datos[3];
            $message = $datos[3];
            if($error['code'] == "23000/2627"){
                $separarCadena = explode('is ',$datos[3]);
                $message = "El usuario ".$separarCadena[1]." ya se encuentra registrado";
            }else{
                echo $error;

            }
            return $finalAnswer = array("result" => false,
                                        "code" => $error['code'],
                                        "message" => $message);
            } else {
            return 1;
            } 


        } else {
            return 0;
        }
    }
     function getLider($id_lider,$id_rol)
	{
        if($id_rol == 7){
            //Asesor
            $query = $this->db->query("SELECT coor.id_lider as id_gerente,u.id_lider as id_subdirector, (CASE WHEN u.id_lider = 7092 THEN 3 WHEN u.id_lider = 9471 THEN 607 ELSE 0 END) id_regional
            FROM usuarios u
            INNER JOIN usuarios coor on u.id_usuario=coor.id_lider
            WHERE coor.id_usuario=$id_lider");
            return $query->result_array();
        }else if($id_rol == 9){
            //Coordinador
            $query = $this->db->query("SELECT u.id_lider as id_subdirector, (CASE WHEN u.id_lider = 7092 THEN 3 WHEN u.id_lider = 9471 THEN 607 ELSE 0 END) id_regional
            FROM usuarios u
            WHERE u.id_usuario=$id_lider");
            return $query->result_array();
        }else if($id_rol == 3){
            //Gerente
            $query = $this->db->query("SELECT (CASE WHEN u.id_usuario = 7092 THEN 3 WHEN u.id_usuario = 9471 THEN 607 ELSE 0 END) id_regional
            FROM usuarios u
            WHERE u.id_usuario=$id_lider");
            return $query->result_array();
        }
	}

    function getRFC($rfc){
        $query = $this->db->query("select * from usuarios where rfc='$rfc'");
        return $query->result_array();
    }

}
