<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bonos_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }



    function getBonos(){
        return $this->db->query("SELECT p.id_bono,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ' ,u.apellido_materno) as nombre, CASE WHEN u.nueva_estructura = 1 THEN opcx2.nombre ELSE opcx.nombre END as id_rol,p.id_bono, p.id_usuario,p.monto,p.num_pagos, p.estatus,convert(date,p.fecha_creacion) as fecha_creacion, sum(d.abono) as suma,p.pago, CAST(p.comentario AS NVARCHAR(4000)) as comentario, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*p.pago) ELSE p.pago END) impuesto1,sed.impuesto
        FROM bonos p 
        LEFT JOIN pagos_bonos_ind d ON d.id_bono = p.id_bono
        INNER JOIN usuarios u ON u.id_usuario = p.id_usuario 
        INNER JOIN opcs_x_cats opcx on opcx.id_opcion = u.id_rol AND opcx.id_catalogo = 1
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.forma_pago AND oxc.id_catalogo = 16
        LEFT JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
        WHEN 2 THEN 2 
        WHEN 3 THEN 2 
        WHEN 1980 THEN 2 
        WHEN 1981 THEN 2 
        WHEN 1982 THEN 2 
        WHEN 1988 THEN 2 
        WHEN 4 THEN 5
        WHEN 5 THEN 3
        WHEN 607 THEN 1 
        WHEN 7092 THEN 4
        WHEN 9629 THEN 2
        ELSE u.id_sede END) and sed.estatus = 1
        LEFT JOIN opcs_x_cats opcx2 on opcx2.id_opcion = u.id_rol AND opcx2.id_catalogo = 83
        WHERE p.estatus = 1
        GROUP BY CONCAT(u.nombre, ' ', u.apellido_paterno, ' ' ,u.apellido_materno),opcx.nombre, p.id_bono, p.id_usuario, p.monto, p.num_pagos, p.estatus, p.fecha_creacion,p.pago, CAST(p.comentario AS NVARCHAR(4000)), p.id_bono, sed.impuesto, u.forma_pago, u.nueva_estructura, opcx2.nombre");
    }


    function insertar_bono($usuarioid,$rol,$monto,$numeroP,$pago,$comentario,$usuario){
        $respuesta = $this->db->query("INSERT INTO bonos(id_usuario,id_rol,monto,num_pagos,pago,estatus,comentario,fecha_creacion,creado_por) VALUES(".$usuarioid.",".$rol." ,".$monto.",".$numeroP.",".$pago.",1, '".$comentario."', GETDATE(), ".$usuario.")");
        if (! $respuesta ) {
            return 0;
            } else {
            return 1;
            }
    }

    function getHistorialAbono($id){
        $this->db->query("SET LANGUAGE Español;");
        return $this->db->query("SELECT b.*,p.*,x.nombre as est, b.comentario as motivo, convert(nvarchar, p.fecha_abono, 6) date_final, CONCAT(us.nombre, ' ',us.apellido_paterno, ' ',us.apellido_materno) AS creado_por
        FROM bonos b 
        INNER JOIN pagos_bonos_ind p on p.id_bono=b.id_bono 
        INNER JOIN opcs_x_cats x on x.id_opcion=p.estado
        INNER JOIN usuarios us on us.id_usuario = p.creado_por
        WHERE p.id_bono=$id and x.id_catalogo=46 ORDER BY p.id_bono DESC");
    }
    function TieneAbonos($id){
        return $this->db->query("SELECT * FROM pagos_bonos_ind WHERE id_bono=$id");    
    }



    function BonoCerrado($id){
        return $this->db->query("SELECT b.monto,b.num_pagos,SUM(p.abono) as suma,p.n_p FROM bonos b INNER JOIN pagos_bonos_ind p on p.id_bono=b.id_bono WHERE p.id_bono=$id GROUP BY b.monto, b.num_pagos,p.n_p");
    }


    function UpdateAbono($id_bono){
        $respuesta = $this->db->query("UPDATE bonos SET estatus=2 WHERE id_bono=$id_bono ");
        if (! $respuesta ) {
            return 0;
            } else {
            return 1;
            }
    }
    function InsertAbono($id_abono,$id_user,$pago,$usuario,$n_p){
        $respuesta = $this->db->query("INSERT INTO pagos_bonos_ind(id_bono,id_usuario,abono,estado,comentario,fecha_abono,fecha_abono_intmex,creado_por,n_p) VALUES(".$id_abono.",".$id_user." ,".$pago.",1,'ABONO', GETDATE(), GETDATE(), ".$usuario." ,$n_p)");
        $id = $this->db->insert_id();
        $respuesta = $this->db->query("INSERT INTO historial_bonos(id_pago_b,id_usuario,fecha_creacion,estatus,comentario) VALUES($id,".$this->session->userdata('id_usuario').",GETDATE(),1,'AGREGÓ UN NUEVO ABONO')");

        if (! $respuesta ) {
            return 0;
            } else {
            return 1;
            }
    }


    function BorrarBono($id_bono){
        $respuesta = $this->db->query("UPDATE bonos SET estatus = 0 WHERE id_bono=$id_bono ");
        if (! $respuesta ) {
        return 0;
        } else {
        return 1;
        }
    }



    function getUsuariosRolBonos($rol){
        if($rol == 20){
            $cadena = ' in (18, 19, 20, 25, 26, 27, 28, 30, 36) ';
        } else{
            $cadena = ' in ('.$rol.') ';
        }
        return $this->db->query("SELECT id_usuario,CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) as name_user FROM usuarios WHERE id_usuario NOT IN (SELECT id_usuario FROM bonos) AND id_rol $cadena");
    }



    function getBonosAllUser($a, $b){
        $cadena = ''; 
        switch($this->session->userdata('id_rol')){
            case 31:
                $cadena = ' WHERE b.estado in (3, 6)';
            break;
            
        case 18:
            $cadena = ' WHERE u.id_rol in (18, 19, 20, 25, 26, 27, 28, 30, 36)';
            break;

        case 1:
        case 2:  
        case 3:  
        case 9:  
        case 7: 
            $cadena = ' WHERE b.id_usuario in ('.$this->session->userdata('id_usuario').')';
            break;

        case 32: 
        case 13: 
        case 17: 
            if($b != 0){
                $cadena = ' WHERE b.id_usuario in ('.$b.') AND u.id_rol in ('.$a.')';
            } else {
                if($a == 20)
                    $cadena = ' WHERE u.id_rol in (18, 19, 20, 25, 26, 27, 28, 30, 36) ';
                else
                    $cadena = ' WHERE u.id_rol in ('.$a.')';
            }
            break;

        default:
            if($a == 20)
                $cadena = ' WHERE u.id_rol in (18, 19, 20, 25, 26, 27, 28, 30, 36) ';
            else
                $cadena = ' WHERE u.id_rol in ('.$a.') ';
            break;
    }

        return $this->db->query("SELECT CONCAT(u.nombre,' ',u.apellido_paterno,' ',u.apellido_materno) as nombre, p.id_rol, p.id_bono, p.id_usuario, p.monto, p.num_pagos, p.pago, p.estatus, p.comentario, convert(date, b.fecha_abono) as fecha_abono, b.estado, b.id_pago_bono, b.abono, b.n_p, x.nombre as name, CASE WHEN u.nueva_estructura = 1 THEN opcx2.nombre ELSE opcx.nombre END AS id_rol, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*p.pago) ELSE p.pago END) impuesto1, sed.impuesto, x.nombre as est, u.rfc
        FROM bonos p 
        INNER JOIN usuarios u ON u.id_usuario = p.id_usuario 
        INNER JOIN pagos_bonos_ind b on b.id_bono = p.id_bono 
        INNER JOIN opcs_x_cats x on x.id_opcion = b.estado AND x.id_catalogo = 46
        INNER JOIN opcs_x_cats opcx on opcx.id_opcion = u.id_rol AND opcx.id_catalogo = 1
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.forma_pago AND oxc.id_catalogo = 16
        LEFT JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
        WHEN 2 THEN 2 
	    WHEN 3 THEN 2 
	    WHEN 26 THEN 2 
	    WHEN 27 THEN 2 
	    WHEN 607 THEN 1 
	    WHEN 1980 THEN 2 
	    WHEN 1981 THEN 2 
	    WHEN 1982 THEN 2 
	    WHEN 1988 THEN 2 
	    WHEN 4 THEN 5 
	    WHEN 5 THEN 3 
	    WHEN 9629 THEN 2 
	    WHEN 13546 THEN 2 
	    WHEN 13547 THEN 2
	    WHEN 13548 THEN 2
        ELSE u.id_sede END) and sed.estatus = 1 
        LEFT JOIN opcs_x_cats opcx2 on opcx2.id_opcion = u.id_rol AND opcx2.id_catalogo = 83 $cadena");
    }
    function getHistorialAbono2($pago){ 
        $this->db->query("SET LANGUAGE Español;");
        return $this->db->query(" SELECT DISTINCT(hc.comentario), hc.id_pago_b, hc.id_usuario, convert(nvarchar(20), hc.fecha_creacion, 113) date_final, hc.fecha_creacion as fecha_movimiento, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_usuario
        FROM historial_bonos hc 
        INNER JOIN pagos_bonos_ind pci ON pci.id_pago_bono = hc.id_pago_b
        INNER JOIN usuarios u ON u.id_usuario = hc.id_usuario 
        WHERE hc.id_pago_b = $pago
        ORDER BY hc.fecha_creacion DESC");
    }
}