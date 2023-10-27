<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Universidad_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

function getDescuentosUniversidad($estatus){
        
        switch($estatus) {
            case '1':
                $filtro = ' WHERE (du.estatus in (0,1,5) AND us.estatus not in (0,3) AND (ISNULL(du.monto-(ISNULL(pci2.total_descontado,0) + ISNULL(du.pagado_caja, 0)), 0)) > 1) OR (du.estatus in (2) AND us.estatus not in (0,3))';
            break;
            case '2':
                $filtro = ' WHERE du.estatus not in (3,4) AND us.estatus in (0,3) '; //BAJA USUARIOS
            break;
            case '3':
                $filtro = ' WHERE du.estatus in (4) ';//LIQUIDADOS
            break;
            case '4':
                $filtro = ' ';
            break;
            case '5':
                $filtro = ' WHERE du.estatus in (3) '; //DETENIDOS
            break;
            default:
                $filtro = ' ';
        }

        $query = $this->db->query("SELECT du.id_descuento, du.id_usuario, UPPER(CONCAT(us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno)) AS nombre, UPPER(opc.nombre) AS puesto, se.id_sede, UPPER(se.nombre) AS sede, ISNULL(pci3.saldo_comisiones, 0) saldo_comisiones, du.monto, ISNULL(pci2.total_descontado, 0) total_descontado, ISNULL(du.pagado_caja, 0) pagado_caja, ISNULL(du.monto-(ISNULL(pci2.total_descontado,0) + ISNULL(du.pagado_caja, 0)), 0) pendiente, du.pago_individual, du.estatus, us.estatus as estado_usuario, convert(nvarchar(20), du.fecha_modificacion, 113) fecha_modificacion, (CASE WHEN DAY(du.fecha_modificacion) BETWEEN 1 AND 10 AND du.estatus = 5 AND MONTH(du.fecha_modificacion) = MONTH(GETDATE()) AND YEAR(du.fecha_modificacion) = YEAR(GETDATE()) THEN 1 ELSE 0 END ) banderaReactivado, convert(nvarchar(20), du.fecha_creacion, 113) fecha_creacion, du.primer_descuento, ISNULL((CASE WHEN du.estatus_certificacion = '0' OR du.estatus_certificacion = NULL THEN NULL ELSE opc1.nombre END),0) as certificacion, ISNULL((CASE WHEN du.estatus_certificacion = '0' OR du.estatus_certificacion = NULL THEN NULL ELSE opc1.id_opcion END),0) as idCertificacion, opc1.color as colorCertificacion
        FROM descuentos_universidad du
        INNER JOIN usuarios us ON us.id_usuario = du.id_usuario
        INNER JOIN usuarios ua ON ua.id_usuario = du.creado_por
        INNER JOIN opcs_x_cats opc ON opc.id_opcion = us.id_rol AND opc.id_catalogo = 1
        LEFT JOIN opcs_x_cats opc1 ON opc1.id_opcion = du.estatus_certificacion AND opc1.id_catalogo = 79
        LEFT JOIN (SELECT SUM(abono_neodata) total_descontado, id_usuario FROM pago_comision_ind WHERE estatus in (17) GROUP BY id_usuario) pci2 ON du.id_usuario = pci2.id_usuario
        LEFT JOIN (SELECT SUM(pccom.abono_neodata) saldo_comisiones, pccom.id_usuario FROM pago_comision_ind pccom INNER JOIN comisiones com ON com.id_comision = pccom.id_comision WHERE pccom.estatus in (1) GROUP BY pccom.id_usuario) pci3 ON du.id_usuario = pci3.id_usuario 
		LEFT JOIN sedes se ON se.id_sede = Try_Cast(us.id_sede  As int)
        LEFT JOIN (SELECT COUNT(DISTINCT(CAST(fecha_abono AS DATE))) no_descuentos, id_usuario FROM pago_comision_ind WHERE estatus = 17 GROUP BY id_usuario) des ON des.id_usuario = du.id_usuario
        $filtro 
        GROUP BY du.id_descuento, du.id_usuario, us.nombre, us.apellido_paterno, us.apellido_materno, opc.nombre, se.id_sede, se.nombre, pci3.saldo_comisiones, du.monto, pci2.total_descontado, du.pagado_caja, du.pago_individual, du.estatus, du.fecha_modificacion, du.fecha_creacion, opc1.nombre, opc1.color, du.primer_descuento, du.estatus_certificacion, us.estatus, opc1.id_opcion ORDER BY du.id_usuario ");

        return $query->result_array();
    }

    
    public function getCertificaciones()
    {
        $catalogoCertificaciones = "SELECT * FROM opcs_x_cats where id_catalogo = 79";
        $query = $this->db->query($catalogoCertificaciones);
        return $query->result();
    }

    function toparDescuentoUniversidad($id_usuario, $comentario) {
        return $this->db->query("UPDATE descuentos_universidad SET estatus = 3, pagos_activos = 0, comentario = '".$this->session->userdata('id_usuario')." DETUVO EL DESCUENTO POR MÓTIVO DE: $comentario' WHERE id_usuario IN ($id_usuario)");
   }

   
   function validarNuevoDescuentoUM($usuario){

    $validarUsuario = $this->db->query("SELECT id_usuario FROM descuentos_universidad WHERE id_usuario = $usuario");
    if(!empty($validarUsuario)){
        return 0;
    } else {
        return 1;
    }
}


function altaNuevoDescuentoUM($usuario, $montoFinalDescuento, $numeroMeses, $montoMensualidad, $descripcionAltaDescuento, $userdata){
        
    $respuesta = $this->db->query("INSERT INTO descuentos_universidad VALUES ($usuario, $montoFinalDescuento, 1, 'DESCUENTO UNIVERSIDAD MADERAS', '".$descripcionAltaDescuento."', $userdata, GETDATE(), 0, $montoMensualidad, $numeroMeses, 0, NULL, NULL, GETDATE())");       
    
    if (! $respuesta ) {
        return 0;
    } else {
        return 1;
    }
}

function getUsuariosUM($rol) {
    return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) as nombre FROM usuarios WHERE id_usuario NOT IN (SELECT id_usuario FROM descuentos_universidad) AND estatus = 1 AND id_rol = $rol ORDER BY nombre");
}

public function get_lista_roles() {
    return $this->db->query("SELECT id_opcion, nombre, id_catalogo FROM opcs_x_cats WHERE id_catalogo IN (1) and id_opcion IN (3, 9, 7, 2) ORDER BY id_opcion");
}


function getCommentsDU($user){
    return $this->db->query("SELECT pci.abono_neodata as comentario,concat(' - ',pci.comentario) comentario2, pci.id_pago_i, pci.modificado_por, convert(nvarchar(20), pci.fecha_abono, 113) date_final, convert(nvarchar(20), pci.fecha_abono, 113) fecha_abono, 
    CONCAT(u.nombre,' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_usuario 
    FROM pago_comision_ind pci  
    INNER JOIN usuarios u ON u.id_usuario = pci.modificado_por
    WHERE pci.estatus = 17 AND pci.id_usuario = $user
    ORDER BY pci.fecha_abono DESC");
}



function getPagosByUser($user,$mes,$anio){
    return $this->db-> query("SELECT sum(abono_neodata) as suma from pago_comision_ind  WHERE MONTH(fecha_abono) = '".$mes."' AND YEAR(fecha_abono) = '".$anio."' and id_usuario=".$user." ");   
}


function getLotesDescuentosUniversidad($user,$valor){
    $datos =  $this->db->query("SELECT l.idLote, l.nombreLote, pci.id_pago_i, pci.abono_neodata as comision_total, 0 abono_pagado,u.id_sede,pci.pago_neodata
    FROM comisiones com 
    INNER JOIN lotes l ON l.idLote = com.id_lote
    INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
    INNER JOIN usuarios u on u.id_usuario=pci.id_usuario
    WHERE com.estatus = 1 AND pci.estatus IN (1) AND pci.id_usuario = $user order by pci.abono_neodata desc")->result_array();

    if(!empty($datos)){ 
    $pagos =  $this->db->query(" SELECT sum(abono_neodata) as suma
    FROM comisiones com 
    INNER JOIN lotes l ON l.idLote = com.id_lote
    INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
    WHERE com.estatus = 1 AND pci.estatus IN (1) AND pci.id_usuario = $user ")->result_array();

    $maximo = 12500;
 
    if($pagos[0]['suma'] < $maximo){
        $datosnew[0] = array(
        'abono_pagado'=> null,
        'comision_total'=> null,
        'idLote'=> null,
        'id_pago_i'=> null,
        'nombreLote'=> null,
        'suma'=>$pagos[0]['suma'],
        'id_sede'=>$datos[0]['id_sede'],
        'pago_neodata' => $datos[0]['pago_neodata']);
    }else{
        $suma=0;
        for ($i=0; $i <count($datos); $i++) { 
            if($datos[$i]['comision_total'] > $valor){
                $datosnew[$i] = array(
                    'abono_pagado'=> $datos[$i]['abono_pagado'],
                    'comision_total'=> $datos[$i]['comision_total'],
                    'idLote'=> $datos[$i]['idLote'],
                    'id_pago_i'=> $datos[$i]['id_pago_i'],
                    'nombreLote'=> $datos[$i]['nombreLote'],
                    'suma'=>$pagos[0]['suma'],
                    'id_sede'=>$datos[0]['id_sede'],
                    'pago_neodata' => $datos[$i]['pago_neodata']);
                    break;
            }else{
                $suma = $suma + $datos[$i]['comision_total'];
                $datosnew[$i] = array(
                    'abono_pagado'=> $datos[$i]['abono_pagado'],
                    'comision_total'=> $datos[$i]['comision_total'],
                    'idLote'=> $datos[$i]['idLote'],
                    'id_pago_i'=> $datos[$i]['id_pago_i'],
                    'nombreLote'=> $datos[$i]['nombreLote'],
                    'suma'=>$pagos[0]['suma'],
                    'pago_neodata' => $datos[$i]['pago_neodata']);
                    
                    if( $suma >= $valor){
                        break;
                    }
                }
            }
        }
    }else{
        $datosnew[0] = array(
            'abono_pagado'=> null,
            'comision_total'=> null,
            'idLote'=> null,
            'id_pago_i'=> null,
            'nombreLote'=> null,
            'suma'=>null,
            'id_sede'=>null,
            'pago_neodata'=>null);
        }
    return $datosnew;
}

function obtenerID($id){
    return $this->db->query("SELECT id_comision from pago_comision_ind WHERE id_pago_i=$id");
}


function update_descuento($id_pago_i,$monto, $comentario, $saldo_comisiones, $usuario,$user){
    $estatus = 0;
    $uni='DESCUENTO';
 
        $estatus =17;
        $respuesta = $this->db->query("UPDATE descuentos_universidad SET saldo_comisiones=".$saldo_comisiones.", estatus = 2, primer_descuento = (CASE WHEN primer_descuento IS NULL THEN GETDATE() ELSE primer_descuento END) WHERE id_usuario = ".$user." AND estatus IN (1, 0)");
        $uni='SALDO COMISIONES: $'.number_format($saldo_comisiones,2, '.', ',');
    
    

    if ($monto == 0) {
        $respuesta = $this->db->query("UPDATE pago_comision_ind SET estatus = $estatus, descuento_aplicado=1, modificado_por='$usuario', fecha_pago_intmex = GETDATE(), fecha_abono = GETDATE(), comentario='$uni' WHERE id_pago_i=$id_pago_i");
    } else {
        $respuesta = $this->db->query("UPDATE pago_comision_ind SET estatus = $estatus, descuento_aplicado=1, modificado_por='$usuario', fecha_pago_intmex = GETDATE(), fecha_abono = GETDATE(), abono_neodata = $monto, comentario='$uni' WHERE id_pago_i=$id_pago_i");
    }
    $respuesta = $this->db->query("INSERT INTO historial_comisiones VALUES ($id_pago_i, $usuario, GETDATE(), 1, 'MOTIVO DESCUENTO: ".$comentario."')");

    if (! $respuesta ) {
        return 0;
        } else {
        return 1;
        }
}


function insertar_descuento($usuarioid,$monto,$ide_comision,$comentario,$usuario,$pago_neodata){

        $estatus = $monto < 1 ? 0 : 1;
    
        $respuesta = $this->db->query("INSERT INTO pago_comision_ind(id_comision, id_usuario, abono_neodata, fecha_abono, fecha_pago_intmex, pago_neodata, estatus, modificado_por, comentario, descuento_aplicado,abono_final,aply_pago_intmex) VALUES ($ide_comision, $usuarioid, $monto, GETDATE(), GETDATE(), $pago_neodata, $estatus, $usuario, 'DESCUENTO NUEVO PAGO', 0 ,null, null)");
        $insert_id = $this->db->insert_id();
    
        $respuesta = $this->db->query("INSERT INTO historial_comisiones VALUES ($insert_id, $usuario, GETDATE(), 1, 'NUEVO PAGO, DISPONIBLE PARA COBRO')");
    
    
        if (! $respuesta ) {
            return 0;
            } else {
            return 1;
            }
}

public function updateCertificacion($clave, $data){
    try {
        $this->db->where('id_descuento', $clave);
        if($this->db->update('descuentos_universidad', $data))
        {
            return TRUE;
        }else{
            return FALSE;
        }               
    }
    catch(Exception $e) {
        return $e->getMessage();
    }     
}



function getDatosHistorialUM($anio, $mes) {
    if($mes == 0)
        $filtro = '  AND YEAR(pci1.fecha_pago_intmex) = '.$anio.' ';
    else
         $filtro = '  AND MONTH(pci1.fecha_pago_intmex) = '.$mes.' AND YEAR(pci1.fecha_pago_intmex) = '.$anio.'';
    
    return $this->db-> query("SELECT pci1.id_pago_i, lo.nombreLote, re.empresa, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names, 
    CONVERT(VARCHAR(20),pci1.fecha_pago_intmex,113) AS fecha_pago_intmex, pci1.id_usuario, CASE WHEN cl.estructura = 1 THEN oprol2.nombre ELSE oprol.nombre END as puesto, pci1.abono_neodata,
     UPPER(se.nombre) AS sede, pci1.abono_neodata, CONCAT(cr.nombre, ' ',cr.apellido_paterno, ' ', cr.apellido_materno) creado
    FROM pago_comision_ind pci1
    INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
    INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
    INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
    INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
    INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
    INNER JOIN usuarios cr ON cr.id_usuario = pci1.modificado_por
    INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
    LEFT JOIN sedes se   
    ON se.id_sede = (CASE u.id_usuario 
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
    ELSE u.id_sede END) and se.estatus = 1
    LEFT JOIN clientes cl ON cl.id_cliente = com.idCliente
    LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
    WHERE pci1.estatus = 17 $filtro 
    GROUP BY pci1.id_pago_i, lo.nombreLote, re.empresa, u.nombre, u.apellido_paterno, u.apellido_materno, pci1.id_usuario, oprol.nombre, pci1.abono_neodata, se.nombre, pci1.abono_neodata, cr.nombre, cr.apellido_paterno, cr.apellido_materno, pci1.fecha_pago_intmex, cl.estructura, oprol2.nombre");
}
 

}