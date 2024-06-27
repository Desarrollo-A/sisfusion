<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Incidencias_model extends CI_Model {

    public function __construct()
    { 
        parent::__construct();
    }
    
    public function getInCommissions($idlote){
        $query = $this->db-> query("(SELECT DISTINCT(l.idLote), com.estatus, cl.plan_comision, l.idStatusContratacion, l.registro_comision, cl.id_cliente, cl.id_sede,sd.nombre, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) nombre_cliente, l.nombreLote, l.idStatusContratacion, res.nombreResidencial, cond.nombre AS nombreCondominio, l.tipo_venta, l.referencia, vc.id_cliente AS compartida, l.totalNeto, l.totalNeto2, l.plan_enganche, plane.nombre AS enganche_tipo, cl.lugar_prospeccion, ae.id_usuario AS id_asesor, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ', ae.apellido_materno) AS asesor, co.id_usuario AS id_coordinador, CONCAT(co.nombre, ' ', co.apellido_paterno, ' ', co.apellido_materno) AS coordinador, ge.id_usuario AS id_gerente, CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ', ge.apellido_materno) AS gerente, su.id_usuario AS id_subdirector, CONCAT(su.nombre, ' ', su.apellido_paterno, ' ', su.apellido_materno) AS subdirector, di.id_usuario AS id_director, CONCAT(di.nombre, ' ', di.apellido_paterno, ' ', di.apellido_materno) AS director, pc.fecha_modificacion, (CASE WHEN cl.plan_comision IN (0) OR cl.plan_comision IS NULL THEN '-' ELSE pl.descripcion END) AS plan_descripcion, convert(nvarchar, pc.fecha_modificacion, 6) date_final, convert(nvarchar, pc.fecha_modificacion, 6)  fecha_sistema, convert(nvarchar, pc.fecha_neodata, 6) fecha_neodata, mc.opcion
        FROM  lotes l
        INNER JOIN  clientes cl ON cl.id_cliente = l.idCliente
        INNER JOIN  condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN  residenciales res ON cond.idResidencial = res.idResidencial
        LEFT JOIN  pago_comision pc ON pc.id_lote = l.idLote AND pc.bandera IN (0)
        LEFT JOIN  opcs_x_cats plane ON plane.id_opcion= l.plan_enganche AND plane.id_catalogo = 39
        LEFT JOIN plan_comision pl ON pl.id_plan = cl.plan_comision
        LEFT JOIN (SELECT id_cliente FROM ventas_compartidas WHERE estatus = 1) AS vc ON vc.id_cliente = cl.id_cliente
        INNER JOIN  usuarios ae ON ae.id_usuario = cl.id_asesor
        LEFT JOIN sedes sd ON cl.id_sede = sd.id_sede 
        LEFT JOIN  usuarios co ON co.id_usuario = cl.id_coordinador
        LEFT JOIN  usuarios ge ON ge.id_usuario = cl.id_gerente
        LEFT JOIN  usuarios su ON su.id_usuario = cl.id_subdirector
        LEFT JOIN  usuarios di ON di.id_usuario = su.id_lider
        LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
		LEFT JOIN mensualidad_cliente mc ON mc.id_cliente = l.idCliente
        LEFT JOIN comisiones com ON com.id_lote = l.idLote and com.estatus= 1
        WHERE l.idStatusContratacion BETWEEN 9 AND 15 AND cl.status = 1 AND l.status = 1 AND l.idLote = $idlote)
        UNION
        (SELECT DISTINCT(l.idLote), com.estatus,cl.plan_comision, l.idStatusContratacion, l.registro_comision, cl.id_cliente, cl.id_sede, sd.nombre, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ', cl.apellido_materno) nombre_cliente, l.nombreLote, l.idStatusContratacion, res.nombreResidencial, cond.nombre AS nombreCondominio, l.tipo_venta, l.referencia, vc.id_cliente AS compartida, l.totalNeto, l.totalNeto2, l.plan_enganche, plane.nombre AS enganche_tipo, cl.lugar_prospeccion, ae.id_usuario AS id_asesor, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ', ae.apellido_materno) AS asesor, co.id_usuario AS id_coordinador, CONCAT(co.nombre, ' ', co.apellido_paterno, ' ', co.apellido_materno) AS coordinador, ge.id_usuario AS id_gerente, CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ', ge.apellido_materno) AS gerente, su.id_usuario AS id_subdirector, CONCAT(su.nombre, ' ', su.apellido_paterno, ' ', su.apellido_materno) AS subdirector, di.id_usuario AS id_director, CONCAT(di.nombre, ' ', di.apellido_paterno, ' ', di.apellido_materno) AS director, pc.fecha_modificacion, (CASE WHEN cl.plan_comision IN (0) OR cl.plan_comision IS NULL THEN '-' ELSE pl.descripcion END) AS plan_descripcion, convert(nvarchar, pc.fecha_modificacion, 6) date_final, convert(nvarchar, pc.fecha_modificacion, 6)  fecha_sistema, convert(nvarchar, pc.fecha_neodata, 6) fecha_neodata, mc.opcion
        FROM  lotes l
        INNER JOIN  clientes cl ON cl.id_cliente = l.idCliente
        INNER JOIN  condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN  residenciales res ON cond.idResidencial = res.idResidencial
        LEFT JOIN  pago_comision pc ON pc.id_lote = l.idLote AND pc.bandera IN (0)
        LEFT JOIN  opcs_x_cats plane ON plane.id_opcion= l.plan_enganche AND plane.id_catalogo = 39
        LEFT JOIN plan_comision pl ON pl.id_plan = cl.plan_comision
        LEFT JOIN (SELECT id_cliente FROM ventas_compartidas WHERE estatus = 1) AS vc ON vc.id_cliente = cl.id_cliente
        INNER JOIN  usuarios ae ON ae.id_usuario = cl.id_asesor
        LEFT JOIN sedes sd ON cl.id_sede = sd.id_sede 
        LEFT JOIN  usuarios co ON co.id_usuario = cl.id_coordinador
        LEFT JOIN  usuarios ge ON ge.id_usuario = cl.id_gerente
        LEFT JOIN  usuarios su ON su.id_usuario = cl.id_subdirector
        LEFT JOIN  usuarios di ON di.id_usuario = su.id_lider
        LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
		LEFT JOIN mensualidad_cliente mc ON mc.id_cliente = l.idCliente
        LEFT JOIN comisiones com ON com.id_lote = l.idLote and com.estatus= 1
        WHERE l.idStatusContratacion BETWEEN 9 AND 15 AND cl.status = 1 AND l.status = 1 AND l.idLote = $idlote AND l.registro_comision IN (0,8))");
        return $query->result();
    }


    function getUsuariosRol3($rol){
        $cmd = "SELECT id_usuario,CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS name_user,id_lider 
        FROM usuarios 
        WHERE estatus IN (0,1,3) /*and forma_pago != 2*/ AND id_rol = $rol";
        return $this->db->query($cmd);
    }

    public function getAsesoresBaja(){
        $query =  $this->db->query("SELECT us.id_usuario, CONCAT(us.nombre, ' ',us.apellido_paterno, ' ',us.apellido_materno) AS nombre 
        FROM usuarios us 
        INNER JOIN comisiones com on com.id_usuario=us.id_usuario 
        WHERE us.id_rol IN (7) AND us.estatus = 0 AND us.rfc NOT LIKE '%TSTDD%' AND us.correo NOT LIKE '%test_%' 
        GROUP BY us.id_usuario, CONCAT(us.nombre, ' ',us.apellido_paterno, ' ',us.apellido_materno)");
        return $query->result();
    }

    function getUsuariosByrol($rol,$user){
        if($rol == 7 || $rol == 9){
            $list_rol = '7,9';
        } else{
            $list_rol =  $rol;
        }
        return $this->db->query("SELECT id_usuario,CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS name_user FROM usuarios WHERE estatus IN (1,3) AND id_rol IN ($list_rol) AND id_usuario NOT IN($user) ");
    }
            
    public function GuardarPago($id_comision, $comentario_topa, $monotAdd){
        $pagos = $this->db->query("SELECT id_usuario FROM comisiones com WHERE id_comision = $id_comision");
        $user = $pagos->row()->id_usuario;    
        $respuesta =  $this->db->query("INSERT INTO pago_comision_ind VALUES ($id_comision, $user, $monotAdd , GETDATE(), GETDATE(), 0, 11, ".$this->session->userdata('id_usuario').", 'IMPORTACION EXTEMPORANEA', NULL, NULL, NULL,'".$this->session->userdata('id_usuario')."' )");
        $insert_id = $this->db->insert_id();
        $this->db->query("INSERT INTO historial_comisiones VALUES (".$insert_id.", ".$this->session->userdata('id_usuario').", GETDATE(), 1, '".$comentario_topa."')");
        
        if($respuesta){
            return 1;
        } else{
            return 0;
        }
    }

    // este no se borra de comisiones porque se utliza 2 veces
    public function SaveAjuste($id_comision,$id_lote,$id_usuario,$porcentaje,$porcentaje_ant,$comision_total,$opc = ''){
        date_default_timezone_set('America/Mexico_City');
        $hoy = date('Y-m-d H:i:s');  
        $q = '';
        if($opc != ''){
            $q=',descuento=0';
        }
        $respuesta =  $this->db->query("UPDATE comisiones SET comision_total=$comision_total,observaciones='SE MODIFICÓ PORCENTAJE',creado_por=".$this->session->userdata('id_usuario').",porcentaje_decimal=$porcentaje $q WHERE id_comision=$id_comision AND id_lote=$id_lote AND id_usuario=$id_usuario");
        
        if($opc == ''){
            $pagos = $this->db-> query("SELECT * FROM pago_comision_ind WHERE id_comision=$id_comision AND estatus IN(1,6) AND id_usuario=$id_usuario;")->result_array();

            if($porcentaje <= $porcentaje_ant ){
                for ($i=0; $i <count($pagos) ; $i++) { 
                    $comentario2='Se cancelo el pago por cambio de porcentaje';
                    $respuesta =  $this->db->query("UPDATE pago_comision_ind SET abono_neodata=0,estatus=0,modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i=".$pagos[$i]['id_pago_i']." AND id_usuario=".$id_usuario.";");
                    $respuesta = $this->db->query("INSERT INTO  historial_comisiones VALUES (".$pagos[$i]['id_pago_i'].", ".$this->session->userdata('id_usuario').", GETDATE(), 1, '".$comentario2."')");
                }  
            }
        }

        $respuesta = $this->db->query("INSERT INTO  historial_log VALUES ($id_comision,".$this->session->userdata('id_usuario').",'".$hoy."',1,'SE CAMBIO PORCENTAJE','comisiones',NULL, null, null, null)");
        return $respuesta;
    }

    public function CederComisiones($usuarioold,$newUser,$rol){
        ini_set('max_execution_time', 0);
        $comisiones =  $this->db->query("SELECT com.id_comision,com.id_lote,com.id_usuario,l.totalNeto2,l.nombreLote,com.comision_total,com.porcentaje_decimal 
        FROM comisiones com 
        INNER JOIN lotes l on l.idLote=com.id_lote 
        WHERE com.id_usuario=".$usuarioold."")->result_array();

        $infoCedida = array();
        $respuesta=true;
        $cc=0;

        for ($i=0; $i <count($comisiones) ; $i++) { 
            $sumaxcomision=0;
            $Restante=0;
            $pagosElimnar = $this->db->query("SELECT pci.id_usuario,pci.id_pago_i,pci.abono_neodata, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario,pci.comentario
            FROM pago_comision_ind pci 
            INNER JOIN usuarios u ON u.id_usuario=pci.id_usuario 
            WHERE pci.id_comision=".$comisiones[$i]['id_comision']." AND pci.estatus IN(1,6)")->result_array();
        
            $SumaTopar = $this->db->query("SELECT SUM(abono_neodata) AS suma 
            FROM pago_comision_ind 
            WHERE id_comision=".$comisiones[$i]['id_comision']." AND estatus NOT IN(1,6)")->result_array();
        
            if( $SumaTopar[0]['suma'] == 'NULL' ||  $SumaTopar[0]['suma'] == null ||  $SumaTopar[0]['suma'] == 0 || $SumaTopar[0]['suma'] == '' ){
                $sumaxcomision = 0;
            } else{
                $sumaxcomision = $SumaTopar[0]['suma'];
            }
            
            $Restante=0;
            
            if(count($pagosElimnar) > 0 || $sumaxcomision < ($comisiones[$i]['comision_total'] - 0.5)){
                if(count($pagosElimnar) > 0){
                    for ($j=0; $j <count($pagosElimnar) ; $j++) { 
                        $comentario= 'Se eliminó pago';
                        $respuesta =  $this->db->query("UPDATE pago_comision_ind SET estatus=0,abono_neodata=0,modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i=".$pagosElimnar[$j]['id_pago_i']." AND id_usuario=".$pagosElimnar[$j]['id_usuario'].";");
                        $respuesta = $this->db->query("INSERT INTO  historial_comisiones VALUES (".$pagosElimnar[$j]['id_pago_i'].", ".$this->session->userdata('id_usuario').", GETDATE(), 1, '".$comentario."')");
                    }
                }
                
                if($sumaxcomision < ($comisiones[$i]['comision_total'] - 0.5)){
                    $Restante = $comisiones[$i]['comision_total'] - $sumaxcomision;
                    $this->db->query("UPDATE comisiones SET comision_total=$sumaxcomision,descuento=$newUser,modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_comision=".$comisiones[$i]['id_comision']." ");
                    $this->db->query("INSERT INTO comisiones VALUES (".$comisiones[$i]['id_lote'].",".$newUser.",".$Restante.",1,'COMISIÓN CEDIDA',NULL,NULL,".$this->session->userdata('id_usuario').",GETDATE(),".$comisiones[$i]['porcentaje_decimal'].",GETDATE(),".$rol.",0,$usuarioold,'".$this->session->userdata('id_usuario')."')");  
                    $infoCedida[$cc] = array(
                        "id_lote" => $comisiones[$i]['id_lote'],
                        "nombreLote" => $comisiones[$i]['nombreLote'],
                        "com_total" => $comisiones[$i]['comision_total'],
                        "tope" => $sumaxcomision,
                        "resto" => $Restante
                    );
                    $cc=$cc+1;
                }
            }
        }
        
        /**-------------------------ENVIO DE CORREO----------------------- */
        $datosUsuarioOld = $this->db->query("SELECT CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre,o.nombre AS rol FROM usuarios u INNER JOIN opcs_x_cats o on o.id_opcion=u.id_rol WHERE u.id_usuario=".$usuarioold." AND o.id_catalogo=1")->result_array();
        $datosUsuarioNew = $this->db->query("SELECT CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre,o.nombre AS rol FROM usuarios u INNER JOIN opcs_x_cats o on o.id_opcion=u.id_rol WHERE u.id_usuario=".$newUser." AND o.id_catalogo=1")->result_array();

        $mail = $this->phpmailer_lib->load();
        $mail->setFrom('noreply@ciudadmaderas.com', 'Ciudad Maderas');
        $mail->AddAddress('programador.analista21@ciudadmaderas.com');
        $mail->Subject = utf8_decode('COMISIONES CEDIDAS');
        $mail->isHTML(true);
        $mailContent = utf8_decode( "<html><head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>
        <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>
        <title>COMISIONES CEDIDAS</title>
        <style media='all' type='text/css'>
            .encabezados{
                text-align: center;
                padding-top:  1.5%;
                padding-bottom: 1.5%;
                font-size: 25px;
            }
            .encabezados a{
                color: #234e7f;
                font-weight: bold;
            }
            .fondo{
                background-color: #234e7f;
                color: #fff;
            }
            h4{
                text-align: center;
            }
            p{
                text-align: right;
            }
            strong{
                color: #234e7f;
            }
            b {
                color: white;
            }
            </style>
            </head>
            <body>
            <table align='center' cellspacing='0' cellpadding='0' border='0' width='100%'>
            
            <tr colspan='3'>
                <td class='navbar navbar-inverse' align='center'>
                    <table width='90%' cellspacing='0' cellpadding='3' class='container'>
                        <tr class='navbar navbar-inverse encabezados'>
                            <th style='text-align:left; width:30%;'></th>
                            <th style='text-align:right; width:70%;'>
                                <a href='#'>CIUDAD MADERAS</a>
                            </th>
                        </tr>
                        <tr class='navbar navbar-inverse'>
                            <b> &nbsp </b>
                        </tr>
                    </table>
                </td>
            </tr>
        
            <tr><td border=1 bgcolor='#FFFFFF' align='center'>
            <h4>El ".$datosUsuarioOld[0]['rol']." ".$datosUsuarioOld[0]['nombre']." cedió sus comisiones al  ".$datosUsuarioNew[0]['rol']." ".$datosUsuarioNew[0]['nombre']."  </h4>
            <center>
                <table id='email' cellpadding='0' cellspacing='0' border='1' width ='90%' style class='darkheader'>
                    <tr class='active'>
                        <th>ID LOTE</th>
                        <th>LOTE</th>
                        <th>COMISIÓN TOTAL</th>
                        <th>COMISIÓN TOPADA</th>
                        <th>COMISIÓN TOTAL NUEVO ASESOR</th>
                    </tr>"); 
                    
                    for ($m=0; $m <count($infoCedida) ; $m++) { 
                        $mailContent .= utf8_decode("<tr>
                        <td><center>".$infoCedida[$m]['id_lote']."</center></td>
                        <td><center>".$infoCedida[$m]['nombreLote']."</center></td>
                        <td><center>".number_format($infoCedida[$m]['com_total'], 2, '.', '')."</center></td>
                        <td><center>".number_format($infoCedida[$m]['tope'], 2, '.', '')."</center></td>
                        <td><center>".number_format($infoCedida[$m]['resto'], 2, '.', '')."</center></td>
                        </tr>");
                    }
        
                    $mailContent .= utf8_decode("</table></center></td></tr></table></body></html>");
                    $mail->Body = $mailContent;
                    $mail->send();
                    $respuesta = true ;
            
                    if($respuesta){
                        return 1;
                    }else{
                        return 0;
                    }
        }

        function UpdateInventarioClient($usuarioOld,$newColab,$rolSelect,$idLote,$idCliente,$comentario,$banderaSubRegional,$regional){
            ini_set('max_execution_time', 0);
            $comentario= 'Se eliminó el pago';
            //1-- se topa la comision del usuario a modificar de la tabla clientes

            if($rolSelect == 7){
                $cmdRol = 'SET id_asesor = '.$newColab ;   
            }else if($rolSelect == 9){
                $cmdRol = 'SET id_coordinador = '.$newColab;
            }else if($rolSelect == 3){
                $cmdRol = 'SET id_gerente = '.$newColab ;
            }else if($rolSelect == 2){
                $cmdRol = 'SET id_subdirector = '.$newColab;
            }else if($rolSelect == 59){
                $cmdRol = 'SET id_regional = '.$newColab;
            }

            $cmd = "UPDATE clientes  $cmdRol WHERE id_cliente=$idCliente;";
            $this->db->query($cmd);
            $respuesta = $this->db->query("INSERT INTO historial_log VALUES (".$idCliente.", ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'MOTIVO ACTUALIZACIÓN: ".$comentario."', 'ventas_compartidas',NULL, null, null, null)");
            $cmdComision =  "SELECT id_comision,comision_total,rol_generado FROM comisiones WHERE id_usuario=$usuarioOld AND id_lote=$idLote;";   
            $comision = $this->db->query($cmdComision)->result_array();
            
            if(count($comision) > 0){
                $sumaxcomision=0;
                $cmdPagos = "SELECT pci.id_usuario,pci.id_pago_i,pci.abono_neodata, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, cat.nombre,pci.comentario
                FROM pago_comision_ind pci 
                INNER JOIN usuarios u ON u.id_usuario=pci.id_usuario 
                INNER JOIN opcs_x_cats cat ON cat.id_opcion=pci.estatus
                WHERE pci.id_comision=".$comision[0]['id_comision']." AND pci.estatus IN(1,6) AND cat.id_catalogo=23";

                $pagos = $this->db->query($cmdPagos)->result_array();
                $cmdPagosInd = "SELECT SUM(abono_neodata) AS suma FROM pago_comision_ind WHERE id_comision=".$comision[0]['id_comision']." AND estatus NOT IN(1,6)";
                $pagos_ind = $this->db->query($cmdPagosInd)->result_array();
                $sumaxcomision = $pagos_ind[0]['suma'];
                
                if(count($pagos) > 0){
                    for ($j=0; $j <count($pagos) ; $j++){
                        $respuesta =  $this->db->query("UPDATE pago_comision_ind SET estatus=0,abono_neodata=0,modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i=".$pagos[$j]['id_pago_i']." AND id_usuario=".$pagos[$j]['id_usuario'].";");
                        $respuesta = $this->db->query("INSERT INTO  historial_comisiones VALUES (".$pagos[$j]['id_pago_i'].", ".$this->session->userdata('id_usuario').", GETDATE(), 1, '".$comentario."')");
                    }
                }
                
                if($sumaxcomision == 0 || $sumaxcomision == '' || $sumaxcomision == null){
                    $sumaxcomision = 0;
                }
                    $respuesta =   $this->db->query("UPDATE comisiones SET comision_total=$sumaxcomision,descuento=1,modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_comision=".$comision[0]['id_comision']." ");
            }
            
            $validate = $this->db->query("SELECT id_usuario FROM comisiones WHERE id_lote IN (SELECT idLote FROM lotes WHERE idCliente = $idCliente) AND id_usuario = $newColab");
            $data_lote = $this->db->query("SELECT idLote, totalNeto2 FROM lotes WHERE idCliente = $idCliente");
            $count_com = $this->db->query("SELECT COUNT(id_usuario) val_total FROM comisiones WHERE id_lote IN (SELECT idLote FROM lotes WHERE idCliente = $idCliente) AND rol_generado = $rolSelect AND descuento=0");
            $precio_lote = $data_lote->row()->totalNeto2;
            $por=0;
            
            if($rolSelect == 7){ //ASESOR
                if($count_com->row()->val_total == 0){
                    $por=3;
                } else if($count_com->row()->val_total == 1){
                    $por=1.5;
                } else if($count_com->row()->val_total == 2){
                    $por=1;
                } else if($count_com->row()->val_total == 3){
                    $por=1;
                }
            }else if($rolSelect == 9){//COORDINADOR
                if($count_com->row()->val_total == 0){
                    $por=1;
                } else if($count_com->row()->val_total == 1){
                    $por=0.5;
                } else if($count_com->row()->val_total == 2){
                    $por=0.33333;
                } else if($count_com->row()->val_total == 3){
                    $por=0.33333;
                }
            }elseif($rolSelect == 3){//GERENTE
                if($count_com->row()->val_total == 0){
                    $por=1;
                } else if($count_com->row()->val_total == 1){
                    $por=0.5;
                }else if($count_com->row()->val_total == 2){
                    $por=0.33333;
                }elseif($count_com->row()->val_total == 3){
                    $por=0.33333;
                }
            }else if ($rolSelect == 2){
                if($count_com->row()->val_total == 0){
                    $por=1;
                } else if($count_com->row()->val_total == 1){
                    $por=0.5;
                } else if($count_com->row()->val_total == 2){
                    $por=0.33333;
                } else if($count_com->row()->val_total == 3){
                    $por=0.33333;
                }
            }else if ($rolSelect == 59){
                if($count_com->row()->val_total == 0){
                    $por=1;
                } else if($count_com->row()->val_total == 1){
                    $por=0.5;
                } else if($count_com->row()->val_total == 2){
                    $por=0.33333;
                } else if($count_com->row()->val_total == 3){
                    $por=0.33333;
                }
            }
            
            $comision_total=$precio_lote * ($por /100);
            
            if(empty($validate->row()->id_usuario)){
                $response = $this->db->query("INSERT INTO comisiones VALUES (".$idLote.",$newColab,$comision_total,1,'SE MODIFICÓ INVENTARIO',NULL,NULL,1,GETDATE(),$por,GETDATE(),$rolSelect,0,NULL,'".$this->session->userdata('id_usuario')."',NULL)");
                
                if($response){
                    return 1;
                } else{
                    return 0;
                }
            }else{
                return 1;
            }
        
            if($respuesta){
                return 1;
            }else{
                return 0;
            } 
        }



        function UpdateVcUser($usuarioOld,$newColab,$rolSelect,$idLote,$idCliente,$comentario,$cuantos){
            //1-- se topa la comision del usuario a modificar de la tabla clientes
            ini_set('max_execution_time', 0);
            if($cuantos == 1){
                if($rolSelect == 7){
                    $this->db->query("UPDATE ventas_compartidas SET id_asesor=$newColab WHERE id_cliente=$idCliente AND estatus=1;");
                }else if($rolSelect == 9){
                    $this->db->query("UPDATE ventas_compartidas SET id_coordinador=$newColab WHERE id_cliente=$idCliente AND estatus=1;");
                }else if($rolSelect == 3){
                    $this->db->query("UPDATE ventas_compartidas SET id_gerente=$newColab WHERE id_cliente=$idCliente AND estatus=1;");
                }else if($rolSelect == 2){
                    $this->db->query("UPDATE ventas_compartidas SET id_subdirector=$newColab WHERE id_cliente=$idCliente AND estatus=1;");
                }else if($rolSelect == 59){
                    $this->db->query("UPDATE ventas_compartidas SET id_subdirector=$newColab WHERE id_cliente=$idCliente AND estatus=1;");
                }
                
                $respuesta = $this->db->query("INSERT INTO historial_log VALUES (".$idCliente.", ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'MOTIVO ACTUALIZACIÓN: ".$comentario."', 'ventas_compartidas',NULL, null, null, null)");
            }
            
            if($usuarioOld != 0 && $usuarioOld != '' && $usuarioOld != null && $usuarioOld != 'null'){
                $comision = $this->db->query("SELECT id_comision,comision_total,rol_generado FROM comisiones WHERE id_usuario=$usuarioOld AND id_lote=$idLote;")->result_array();
                if(count($comision) > 0){
                    $sumaxcomision=0;
                    $pagos = $this->db->query("SELECT pci.id_usuario,pci.id_pago_i,pci.abono_neodata,CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario,cat.nombre,pci.comentario
                    FROM pago_comision_ind pci 
                    INNER JOIN usuarios u ON u.id_usuario=pci.id_usuario 
                    INNER JOIN opcs_x_cats cat ON cat.id_opcion=pci.estatus
                    WHERE pci.id_comision=".$comision[0]['id_comision']." AND pci.estatus IN(1,6) AND cat.id_catalogo=23")->result_array();
                    
                    $pagos_ind = $this->db->query("SELECT SUM(abono_neodata) AS suma FROM pago_comision_ind WHERE id_comision=".$comision[0]['id_comision']." AND estatus NOT IN(1,6)")->result_array();
                    $sumaxcomision = $pagos_ind[0]['suma'];
                    if(count($pagos) > 0){
                        for ($j=0; $j <count($pagos) ; $j++){
                            $comentario= 'Se eliminó el pago';
                            $respuesta =  $this->db->query("UPDATE pago_comision_ind SET estatus=0,abono_neodata=0,modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i=".$pagos[$j]['id_pago_i']." AND id_usuario=".$pagos[$j]['id_usuario'].";");
                            $respuesta = $this->db->query("INSERT INTO  historial_comisiones VALUES (".$pagos[$j]['id_pago_i'].", ".$this->session->userdata('id_usuario').", GETDATE(), 1, '".$comentario."')");
                        }
                    }
                    if($sumaxcomision == 0 || $sumaxcomision == '' || $sumaxcomision == null){
                        $sumaxcomision = 0;
                        $respuesta = $this->db->query("UPDATE comisiones SET comision_total=$sumaxcomision,descuento=1,modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_comision=".$comision[0]['id_comision']." ");
                    } else{
                        $respuesta = $this->db->query("UPDATE comisiones SET comision_total=$sumaxcomision,descuento=1,modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_comision=".$comision[0]['id_comision']." ");
                    } 
                }
            }
            
            $validate = $this->db->query("SELECT id_usuario FROM comisiones WHERE id_lote IN (SELECT idLote FROM lotes WHERE idCliente = $idCliente) AND id_usuario = $newColab");
            $data_lote = $this->db->query("SELECT idLote, totalNeto2 FROM lotes WHERE idCliente = $idCliente");
            $count_com = $this->db->query("SELECT COUNT(id_usuario) val_total FROM comisiones WHERE id_lote IN (SELECT idLote FROM lotes WHERE idCliente = $idCliente) AND rol_generado = $rolSelect AND descuento=0");
            $precio_lote = $data_lote->row()->totalNeto2;
            $por=0;
            
            if($rolSelect == 7){ //ASESOR
                if($count_com->row()->val_total == 0){
                    $por=3;
                } else if($count_com->row()->val_total == 1){
                    $por=1.5;
                } else if($count_com->row()->val_total == 2){
                    $por=1;
                } else if($count_com->row()->val_total == 3){
                    $por=1;
                }
            }else if($rolSelect == 9){ //COORDINADOR
                if($count_com->row()->val_total == 0){
                    $por=1;
                } else if($count_com->row()->val_total == 1){
                    $por=0.5;
                } else if($count_com->row()->val_total == 2){
                    $por=0.33333;
                } else if($count_com->row()->val_total == 3){
                    $por=0.33333;
                }
            }else if($rolSelect == 3){ //GERENTE
                if($count_com->row()->val_total == 0){
                    $por=1;
                } else if($count_com->row()->val_total == 1){
                    $por=0.5;
                } else if($count_com->row()->val_total == 2){
                    $por=0.33333;
                } else if($count_com->row()->val_total == 3){
                    $por=0.33333;
                }
            }
            else if ($rolSelect == 2){
                if($count_com->row()->val_total == 0){
                    $por=1;
                } else if($count_com->row()->val_total == 1){
                    $por=0.5;
                } else if($count_com->row()->val_total == 2){
                    $por=0.33333;
                } else if($count_com->row()->val_total == 3){
                    $por=0.33333;
                }
            }
            else if ($rolSelect == 59){
                if($count_com->row()->val_total == 0){
                    $por=1;
                } else if($count_com->row()->val_total == 1){
                    $por=0.5;
                } else if($count_com->row()->val_total == 2){
                    $por=0.33333;
                } else if($count_com->row()->val_total == 3){
                    $por=0.33333;
                }
            }
            
            
            $comision_total=$precio_lote * ($por /100);
            if(empty($validate->row()->id_usuario)){
                $response = $this->db->query("INSERT INTO comisiones VALUES (".$idLote.",$newColab,$comision_total,1,'SE MODIFICÓ VENTA COMPARTIDA',NULL,NULL,1,GETDATE(),$por,GETDATE(),$rolSelect,0,NULL,0,NULL)");
                if($response){
                    return 1;
                } else{
                    return 0;
                }
            }else{
                return 1;
            }
            
            if($respuesta){
                return 1;
            }else{
                return 0;
            }
        }

        public function getUserVC($id_cliente){
            return  $this->db->query("SELECT vc.id_vcompartida,cl.id_cliente,cl.nombre, cl.apellido_paterno, cl.apellido_materno, 
            ae.id_usuario AS id_asesor, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ', ae.apellido_materno) AS asesor, 
            co.id_usuario AS id_coordinador, CONCAT(co.nombre, ' ', co.apellido_paterno, ' ', co.apellido_materno) AS coordinador, 
            ge.id_usuario AS id_gerente, CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ', ge.apellido_materno) AS gerente, 
            su.id_usuario AS id_subdirector, CONCAT(su.nombre, ' ', su.apellido_paterno, ' ', su.apellido_materno) AS subdirector,
            re.id_usuario AS id_regional, CONCAT(re.nombre, ' ', re.apellido_paterno, ' ', re.apellido_materno) AS regional,
            di.id_usuario AS id_lider, CONCAT(di.nombre, ' ', di.apellido_paterno, ' ', di.apellido_materno) AS lider
            FROM ventas_compartidas vc
            INNER JOIN clientes cl ON vc.id_cliente = cl.id_cliente
            INNER JOIN  usuarios ae ON ae.id_usuario = vc.id_asesor
            LEFT JOIN  usuarios co ON co.id_usuario = vc.id_coordinador
            LEFT JOIN  usuarios ge ON ge.id_usuario = vc.id_gerente
            LEFT JOIN  usuarios su ON su.id_usuario = vc.id_subdirector
            LEFT JOIN  usuarios di ON di.id_usuario = su.id_lider
            LEFT JOIN  usuarios re ON re.id_usuario = vc.id_regional
            WHERE cl.id_cliente=$id_cliente AND vc.estatus = 1 AND cl.status = 1");
        }

        public function getUserVP($idLote){
            return  $this->db->query("SELECT
            CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ', ae.apellido_materno) AS asesor, 
            CONCAT(co.nombre, ' ', co.apellido_paterno, ' ', co.apellido_materno) AS coordinador,
            CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ', ge.apellido_materno) AS gerente, 
            CONCAT(su.nombre, ' ', su.apellido_paterno, ' ', su.apellido_materno) AS subdirector,
            CONCAT(re.nombre, ' ', re.apellido_paterno, ' ', re.apellido_materno) AS regional
            FROM lotes l
            INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
            INNER JOIN usuarios ae ON ae.id_usuario = cl.id_asesor
            LEFT JOIN usuarios co ON co.id_usuario = cl.id_coordinador
            LEFT JOIN usuarios ge ON ge.id_usuario = cl.id_gerente
            LEFT JOIN usuarios su ON su.id_usuario = cl.id_subdirector
            LEFT JOIN usuarios re ON re.id_usuario = cl.id_regional
            WHERE l.idLote = $idLote  AND cl.status = 1");
        }

        public function updateVentaCompartida($id, $idLote, $idCliente){
            $modificadoPor = $this->session->userdata('id_usuario');
            
            $cmd = ("UPDATE ventas_compartidas SET estatus = 0, modificado_por = $modificadoPor WHERE id_vcompartida = $id");
            $respuesta =  $this->db->query($cmd);

            return $respuesta ? 1 : 0;
        }

        /* public function updateVentaCompartida($id, $idLote, $idCliente){

            $modificadoPor = $this->session->userdata('id_usuario');

            // Se consulta quien es el adicional a la venta compartida
            $query = $this->db->query("SELECT ase.id_asesor, co.id_coordinador, ge.id_gerente, sub.id_subdirector, reg.id_regional
            FROM clientes cli
            LEFT JOIN ventas_compartidas ase ON ase.id_cliente = cli.id_cliente AND cli.id_asesor != ase.id_asesor AND ase.id_vcompartida = $id
            LEFT JOIN ventas_compartidas co ON co.id_cliente = cli.id_cliente AND co.id_coordinador != cli.id_coordinador AND co.id_vcompartida = $id
            LEFT JOIN ventas_compartidas ge ON ge.id_cliente = cli.id_cliente AND ge.id_gerente != cli.id_gerente AND ge.id_vcompartida = $id
            LEFT JOIN ventas_compartidas sub ON sub.id_cliente = cli.id_cliente AND sub.id_subdirector != cli.id_subdirector AND sub.id_vcompartida = $id
            LEFT JOIN ventas_compartidas reg ON reg.id_cliente = cli.id_cliente AND reg.id_regional != cli.id_regional AND reg.id_regional != 0 AND reg.id_vcompartida= $id
            WHERE cli.id_cliente IN 
            (SELECT idCliente FROM lotes WHERE idLote = $idLote)")->result();

            $asesor = '';
            $coordinador = '';
            $gerente = '';
            $subdirector = '';
            $regional = '';

            $queryEstatus = $this->db->query("SELECT estatus
            FROM pago_comision_ind
            WHERE id_comision IN (
                SELECT id_comision FROM comisiones WHERE estatus = 1 AND id_lote = $idLote)
            ORDER BY id_usuario")->result();

            $estusUno = true; // Variable para verificar si todos los estatus son 1

            foreach ($queryEstatus as $row) {
                if ($row->estatus != 1) {
                    $estusUno = false; // Si encontramos un estatus diferente de 1, cambiamos la variable a false
                    break; // No necesitamos seguir buscando, salimos del bucle
                }
            }

            if ($estusUno) {
                // Todos los registros tienen estatus = 1

                foreach ($query as $row) {
                    if ($row->id_asesor != null) {
                        $asesor = $row->id_asesor;

                        // Número de usuarios de la venta principal
                        $count = $this->db->query("SELECT COUNT(*) AS count FROM comisiones comi
                        WHERE id_lote = $idLote AND comi.rol_generado IN(SELECT rol_generado FROM comisiones WHERE id_usuario = $asesor AND id_lote = $idLote)
                        AND comi.id_usuario != $asesor AND comi.estatus = 1
                        ")->row()->count;

                        // Comisión y porcentaje del usuario de venta compartida
                        $valoresC = $this->db->query("SELECT comision_total, porcentaje_decimal 
                        FROM comisiones
                        WHERE id_usuario = $asesor AND id_lote = $idLote
                        ");

                        // Comisión y porcentaje del usuarios de venta principal
                        $valoresP = $this->db->query("SELECT  TOP 1 comi.id_usuario, comi.comision_total, comi.porcentaje_decimal 
                        FROM comisiones comi
                        WHERE comi.id_usuario != $asesor AND comi.id_lote = $idLote 
                        AND comi.rol_generado IN(SELECT rol_generado FROM comisiones WHERE id_usuario = $asesor AND id_lote = $idLote)
                        ");

                        $rowValores = $valoresC ->row();
                        $comision = $rowValores->comision_total;
                        $porcentaje = $rowValores->porcentaje_decimal;

                        $rowValoresP = $valoresP ->row();
                        $comisionP = $rowValoresP->comision_total;
                        $porcentajeP = $rowValoresP->porcentaje_decimal;

                        // Porcentaje y comision proporcional individual para usuarios principales
                        $comisionRep = ($comisionP/$count);
                        $porcentajeRep = ($porcentajeP/$count);

                        // Porcentaje y comision resultante para usuarios de venta principal
                        $comisionPr =  $comisionRep + $comisionP;
                        $porcentajePr = $porcentajeRep + $porcentajeP;

                        // Porcentaje y comision resultante para usuario de venta compartida
                        $comisionC = $comision - $comisionRep;
                        $porcentajeC = $porcentaje - $porcentajeRep;
                        
                        // Se ajustan paramentros de los usuarios principales
                        $updateUsP = $this->db->query("UPDATE comisiones 
                        SET comision_total = $comisionPr,
                            porcentaje_decimal = $porcentajePr, 
                            modificado_por = '$modificadoPor'
                        WHERE id_lote = $idLote 
                          AND id_usuario IN (
                              SELECT comi.id_usuario 
                              FROM comisiones comi
                              WHERE id_lote = $idLote 
                                AND rol_generado IN(SELECT rol_generado FROM comisiones WHERE id_lote = $idLote AND id_usuario = $asesor)
                                AND comi.id_usuario != $asesor
                          )");

                          // Se ajustan paramentros a usuario compartido
                          if ($updateUsP) {
                            // Segunda actualización: usuario compartido
                            $updateUsC = $this->db->query("UPDATE comisiones 
                                                    SET comision_total = $comisionC,
                                                        porcentaje_decimal = $porcentajeC, 
                                                        estatus = 0,
                                                        modificado_por = '$modificadoPor'
                                                    WHERE id_lote = $idLote 
                                                    AND id_usuario = $asesor");
                          }

                        if ($updateUsC) {

                            $ventasCompartidas = $this->db->query("SELECT * FROM ventas_compartidas 
                            WHERE id_cliente = $idCliente AND id_asesor = $asesor");

                            if($ventasCompartidas->num_rows() == 1){
                            // Se eliminan todos los registros en estatus 1
                            $this->db->query("DELETE FROM pago_comision_ind
                            WHERE id_comision IN (
                                SELECT id_comision FROM comisiones WHERE estatus = 1 AND id_lote = $idLote AND id_usuario = $asesor
                            )");

                            }
                        }else{
                            return 0;
                        }
                    }
                    if ($row->id_coordinador != null) {
                        $coordinador = $row->id_coordinador;

                        // Número de usuarios de la venta principal
                        $count = $this->db->query("SELECT COUNT(*) AS count FROM comisiones comi
                        WHERE id_lote = $idLote AND comi.rol_generado IN(SELECT rol_generado FROM comisiones WHERE id_usuario = $coordinador AND id_lote = $idLote)
                        AND comi.id_usuario != $coordinador AND comi.estatus = 1
                        ")->row()->count;

                        // Comisión y porcentaje del usuario de venta compartida
                        $valoresC = $this->db->query("SELECT comision_total, porcentaje_decimal 
                        FROM comisiones
                        WHERE id_usuario = $coordinador AND id_lote = $idLote
                        ");

                        // Comisión y porcentaje del usuarios de venta principal
                        $valoresP = $this->db->query("SELECT  TOP 1 comi.id_usuario, comi.comision_total, comi.porcentaje_decimal 
                        FROM comisiones comi
                        WHERE comi.id_usuario != $coordinador AND comi.id_lote = $idLote 
                        AND comi.rol_generado IN(SELECT rol_generado FROM comisiones WHERE id_usuario = $coordinador AND id_lote = $idLote)
                        ");

                        $rowValores = $valoresC ->row();
                        $comision = $rowValores->comision_total;
                        $porcentaje = $rowValores->porcentaje_decimal;

                        $rowValoresP = $valoresP ->row();
                        $comisionP = $rowValoresP->comision_total;
                        $porcentajeP = $rowValoresP->porcentaje_decimal;

                        // Porcentaje y comision proporcional individual para usuarios principales
                        $comisionRep = ($comisionP/$count);
                        $porcentajeRep = ($porcentajeP/$count);

                        // Porcentaje y comision resultante para usuarios de venta principal
                        $comisionPr =  $comisionRep + $comisionP;
                        $porcentajePr = $porcentajeRep + $porcentajeP;

                        // Porcentaje y comision resultante para usuario de venta compartida
                        $comisionC = $comision - $comisionRep;
                        $porcentajeC = $porcentaje - $porcentajeRep;
                        
                        // Se ajustan paramentros de los usuarios principales
                        $updateUsP = $this->db->query("UPDATE comisiones 
                        SET comision_total = $comisionPr,
                            porcentaje_decimal = $porcentajePr, 
                            modificado_por = '$modificadoPor'
                        WHERE id_lote = $idLote 
                          AND id_usuario IN (
                              SELECT comi.id_usuario 
                              FROM comisiones comi
                              WHERE id_lote = $idLote 
                                AND rol_generado IN(SELECT rol_generado FROM comisiones WHERE id_lote = $idLote AND id_usuario = $coordinador)
                                AND comi.id_usuario != $coordinador
                          )");

                          // Se ajustan paramentros a usuario compartido
                          if ($updateUsP) {
                            // Segunda actualización: usuario compartido
                            $updateUsC = $this->db->query("UPDATE comisiones 
                                                    SET comision_total = $comisionC,
                                                        porcentaje_decimal = $porcentajeC, 
                                                        estatus = 0,
                                                        modificado_por = '$modificadoPor'
                                                    WHERE id_lote = $idLote 
                                                    AND id_usuario = $coordinador");
                          }

                        if ($updateUsC) {

                            $ventasCompartidas = $this->db->query("SELECT * FROM ventas_compartidas 
                            WHERE id_cliente = $idCliente AND id_asesor = $coordinador");

                            if($ventasCompartidas->num_rows() == 1){
                            // Se eliminan todos los registros en estatus 1
                            $this->db->query("DELETE FROM pago_comision_ind
                            WHERE id_comision IN (
                                SELECT id_comision FROM comisiones WHERE estatus = 1 AND id_lote = $idLote AND id_usuario = $coordinador
                            )");

                            }
                        }else{
                            return 0;
                        }
                    }
                    if ($row->id_gerente != null) {
                        $gerente = $row->id_gerente;

                        // Número de usuarios de la venta principal
                        $count = $this->db->query("SELECT COUNT(*) AS count FROM comisiones comi
                        WHERE id_lote = $idLote AND comi.rol_generado IN(SELECT rol_generado FROM comisiones WHERE id_usuario = $gerente AND id_lote = $idLote)
                        AND comi.id_usuario != $gerente AND comi.estatus = 1
                        ")->row()->count;

                        // Comisión y porcentaje del usuario de venta compartida
                        $valoresC = $this->db->query("SELECT comision_total, porcentaje_decimal 
                        FROM comisiones
                        WHERE id_usuario = $gerente AND id_lote = $idLote
                        ");

                        // Comisión y porcentaje del usuarios de venta principal
                        $valoresP = $this->db->query("SELECT  TOP 1 comi.id_usuario, comi.comision_total, comi.porcentaje_decimal 
                        FROM comisiones comi
                        WHERE comi.id_usuario != $gerente AND comi.id_lote = $idLote 
                        AND comi.rol_generado IN(SELECT rol_generado FROM comisiones WHERE id_usuario = $gerente AND id_lote = $idLote)
                        ");

                        $rowValores = $valoresC ->row();
                        $comision = $rowValores->comision_total;
                        $porcentaje = $rowValores->porcentaje_decimal;

                        $rowValoresP = $valoresP ->row();
                        $comisionP = $rowValoresP->comision_total;
                        $porcentajeP = $rowValoresP->porcentaje_decimal;

                        // Porcentaje y comision proporcional individual para usuarios principales
                        $comisionRep = ($comisionP/$count);
                        $porcentajeRep = ($porcentajeP/$count);

                        // Porcentaje y comision resultante para usuarios de venta principal
                        $comisionPr =  $comisionRep + $comisionP;
                        $porcentajePr = $porcentajeRep + $porcentajeP;

                        // Porcentaje y comision resultante para usuario de venta compartida
                        $comisionC = $comision - $comisionRep;
                        $porcentajeC = $porcentaje - $porcentajeRep;
                        
                        // Se ajustan paramentros de los usuarios principales
                        $updateUsP = $this->db->query("UPDATE comisiones 
                        SET comision_total = $comisionPr,
                            porcentaje_decimal = $porcentajePr, 
                            modificado_por = '$modificadoPor'
                        WHERE id_lote = $idLote 
                          AND id_usuario IN (
                              SELECT comi.id_usuario 
                              FROM comisiones comi
                              WHERE id_lote = $idLote 
                                AND rol_generado IN(SELECT rol_generado FROM comisiones WHERE id_lote = $idLote AND id_usuario = $gerente)
                                AND comi.id_usuario != $gerente
                          )");

                          // Se ajustan paramentros a usuario compartido
                          if ($updateUsP) {
                            // Segunda actualización: usuario compartido
                            $updateUsC = $this->db->query("UPDATE comisiones 
                                                    SET comision_total = $comisionC,
                                                        porcentaje_decimal = $porcentajeC, 
                                                        estatus = 0,
                                                        modificado_por = '$modificadoPor'
                                                    WHERE id_lote = $idLote 
                                                    AND id_usuario = $gerente");
                          }

                        if ($updateUsC) {

                            $ventasCompartidas = $this->db->query("SELECT * FROM ventas_compartidas 
                            WHERE id_cliente = $idCliente AND id_asesor = $gerente");

                            if($ventasCompartidas->num_rows() == 1){
                            // Se eliminan todos los registros en estatus 1
                            $this->db->query("DELETE FROM pago_comision_ind
                            WHERE id_comision IN (
                                SELECT id_comision FROM comisiones WHERE estatus = 1 AND id_lote = $idLote AND id_usuario = $gerente
                            )");

                            }
                        }else{
                            return 0;
                        }
                    }

                    if ($row->id_subdirector != null) {
                        $subdirector = $row->id_subdirector;

                        // Número de usuarios de la venta principal
                        $count = $this->db->query("SELECT COUNT(*) AS count FROM comisiones comi
                        LEFT JOIN usuarios us ON us.id_usuario = comi.id_usuario
                        WHERE id_lote = $idLote AND comi.rol_generado IN(SELECT rol_generado FROM comisiones WHERE id_usuario = $subdirector AND id_lote = $idLote)
                        AND comi.id_usuario != $subdirector AND comi.estatus = 1
                        ")->row()->count;

                        // Comisión y porcentaje del usuario de venta compartida
                        $valoresC = $this->db->query("SELECT comision_total, porcentaje_decimal 
                        FROM comisiones
                        WHERE id_usuario = $subdirector AND id_lote = $idLote
                        ");

                        // Comisión y porcentaje del usuarios de venta principal
                        $valoresP = $this->db->query("SELECT  TOP 1 comi.id_usuario, comi.comision_total, comi.porcentaje_decimal 
                        FROM comisiones comi
                        WHERE comi.id_usuario != $subdirector AND comi.id_lote = $idLote 
                        AND comi.rol_generado IN(SELECT rol_generado FROM comisiones WHERE id_usuario = $subdirector AND id_lote = $idLote)
                        ");

                        $rowValores = $valoresC ->row();
                        $comision = $rowValores->comision_total;
                        $porcentaje = $rowValores->porcentaje_decimal;

                        $rowValoresP = $valoresP ->row();
                        $comisionP = $rowValoresP->comision_total;
                        $porcentajeP = $rowValoresP->porcentaje_decimal;

                        // Porcentaje y comision proporcional individual para usuarios principales
                        $comisionRep = ($comisionP/$count);
                        $porcentajeRep = ($porcentajeP/$count);

                        // Porcentaje y comision resultante para usuarios de venta principal
                        $comisionPr =  $comisionRep + $comisionP;
                        $porcentajePr = $porcentajeRep + $porcentajeP;

                        // Porcentaje y comision resultante para usuario de venta compartida
                        $comisionC = $comision - $comisionRep;
                        $porcentajeC = $porcentaje - $porcentajeRep;
                        
                        // Se ajustan paramentros de los usuarios principales
                        $updateUsP = $this->db->query("UPDATE comisiones 
                        SET comision_total = $comisionPr,
                            porcentaje_decimal = $porcentajePr, 
                            modificado_por = '$modificadoPor'
                        WHERE id_lote = $idLote 
                          AND id_usuario IN (
                              SELECT comi.id_usuario 
                              FROM comisiones comi
                              WHERE id_lote = $idLote 
                                AND rol_generado IN(SELECT rol_generado FROM comisiones WHERE id_lote = $idLote AND id_usuario = $subdirector)
                                AND comi.id_usuario != $subdirector
                          )");

                          // Se ajustan paramentros a usuario compartido
                          if ($updateUsP) {
                            // Segunda actualización: usuario compartido
                            $updateUsC = $this->db->query("UPDATE comisiones 
                                                    SET comision_total = $comisionC,
                                                        porcentaje_decimal = $porcentajeC, 
                                                        estatus = 0,
                                                        modificado_por = '$modificadoPor'
                                                    WHERE id_lote = $idLote 
                                                    AND id_usuario = $subdirector");
                          }

                        if ($updateUsC) {

                            $ventasCompartidas = $this->db->query("SELECT * FROM ventas_compartidas 
                            WHERE id_cliente = $idCliente AND id_asesor = $subdirector");

                            if($ventasCompartidas->num_rows() == 1){
                            // Se eliminan todos los registros en estatus 1
                            $this->db->query("DELETE FROM pago_comision_ind
                            WHERE id_comision IN (
                                SELECT id_comision FROM comisiones WHERE estatus = 1 AND id_lote = $idLote AND id_usuario = $subdirector
                            )");

                            }
                        }else{
                            return 0;
                        }
                    }

                    if ($row->id_regional != null) {
                        $regional = $row->id_regional;

                        // Número de usuarios de la venta principal
                        $count = $this->db->query("SELECT COUNT(*) AS count FROM comisiones comi
                        WHERE id_lote = $idLote AND comi.rol_generado IN(SELECT rol_generado FROM comisiones WHERE id_usuario = $regional AND id_lote = $idLote)
                        AND comi.id_usuario != $regional AND comi.estatus = 1
                        ")->row()->count;

                        // Comisión y porcentaje del usuario de venta compartida
                        $valoresC = $this->db->query("SELECT comision_total, porcentaje_decimal 
                        FROM comisiones
                        WHERE id_usuario = $regional AND id_lote = $idLote
                        ");

                        // Comisión y porcentaje del usuarios de venta principal
                        $valoresP = $this->db->query("SELECT  TOP 1 comi.id_usuario, comi.comision_total, comi.porcentaje_decimal 
                        FROM comisiones comi
                        WHERE comi.id_usuario != $regional AND comi.id_lote = $idLote 
                        AND comi.rol_generado IN(SELECT rol_generado FROM comisiones WHERE id_usuario = $regional AND id_lote = $idLote)
                        ");

                        $rowValores = $valoresC ->row();
                        $comision = $rowValores->comision_total;
                        $porcentaje = $rowValores->porcentaje_decimal;

                        $rowValoresP = $valoresP ->row();
                        $comisionP = $rowValoresP->comision_total;
                        $porcentajeP = $rowValoresP->porcentaje_decimal;

                        // Porcentaje y comision proporcional individual para usuarios principales
                        $comisionRep = ($comisionP/$count);
                        $porcentajeRep = ($porcentajeP/$count);

                        // Porcentaje y comision resultante para usuarios de venta principal
                        $comisionPr =  $comisionRep + $comisionP;
                        $porcentajePr = $porcentajeRep + $porcentajeP;

                        // Porcentaje y comision resultante para usuario de venta compartida
                        $comisionC = $comision - $comisionRep;
                        $porcentajeC = $porcentaje - $porcentajeRep;
                        
                        // Se ajustan paramentros de los usuarios principales
                        $updateUsP = $this->db->query("UPDATE comisiones 
                        SET comision_total = $comisionPr,
                            porcentaje_decimal = $porcentajePr, 
                            modificado_por = '$modificadoPor'
                        WHERE id_lote = $idLote 
                          AND id_usuario IN (
                              SELECT comi.id_usuario 
                              FROM comisiones comi
                              WHERE id_lote = $idLote 
                                AND rol_generado IN(SELECT rol_generado FROM comisiones WHERE id_lote = $idLote AND id_usuario = $regional)
                                AND comi.id_usuario != $regional
                          )");

                          // Se ajustan paramentros a usuario compartido
                          if ($updateUsP) {
                            // Segunda actualización: usuario compartido
                            $updateUsC = $this->db->query("UPDATE comisiones 
                                                    SET comision_total = $comisionC,
                                                        porcentaje_decimal = $porcentajeC, 
                                                        estatus = 0,
                                                        modificado_por = '$modificadoPor'
                                                    WHERE id_lote = $idLote 
                                                    AND id_usuario = $regional");
                          }

                        if ($updateUsC) {

                            $ventasCompartidas = $this->db->query("SELECT * FROM ventas_compartidas 
                            WHERE id_cliente = $idCliente AND id_asesor = $regional");

                            if($ventasCompartidas->num_rows() == 1){
                            // Se eliminan todos los registros en estatus 1
                            $this->db->query("DELETE FROM pago_comision_ind
                            WHERE id_comision IN (
                                SELECT id_comision FROM comisiones WHERE estatus = 1 AND id_lote = $idLote AND id_usuario = $regional
                            )");

                            }
                        }else{
                            return 0;
                        }
                    }
                }

            } else {
                // Al menos un registro tiene un estatus diferente de 1
                
                foreach ($query as $row) {
                    if ($row->id_asesor != null) {
                        $asesor = $row->id_asesor;

                        // Número de registros de ventas compartidas de usuario 
                        $queryVc = $this->db->query("SELECT * FROM ventas_compartidas vc 
                        WHERE id_asesor = $asesor AND id_cliente = $idCliente");

                        // Número de usuarios de la venta principal
                        $count = $this->db->query("SELECT COUNT(*) AS count FROM comisiones comi
                        WHERE id_lote = $idLote AND rol_generado IN(SELECT rol_generado FROM comisiones WHERE id_lote = $idLote AND id_usuario = $asesor)
                        AND comi.id_usuario != $asesor AND estatus = 1
                        ")->row()->count;

                        // Comisión y porcentaje del usuario de venta principal
                        $valoresP = $this->db->query("SELECT  TOP 1 comi.id_usuario, comi.porcentaje_decimal, comi.comision_total 
                        FROM comisiones comi
                        WHERE comi.id_usuario != $asesor AND comi.id_lote = $idLote 
                        AND comi.rol_generado IN(SELECT TOP 1 rol_generado FROM comisiones WHERE id_usuario = $asesor AND id_lote = $idLote)
                        ");

                        // Si el usuario de vc tiene mas de un registro
                        if($queryVc->num_rows() > 1){

                        //Número de usuarios a topar
                        $usComi = ($count + $queryVc->num_rows())-1;

                        $UsVc = $this->db->query("SELECT porcentaje_decimal, comision_total from comisiones WHERE id_lote = $idLote AND id_usuario = $asesor");

                        $rowPcjVc = $UsVc->row();
                        $pcjVc = $rowPcjVc->porcentaje_decimal;
                        $comiVc= $rowPcjVc->comision_total;

                        $newPorcentajeVc = (($pcjVc/$queryVc->num_rows())*($queryVc->num_rows()-1));
                        $newPorcentajeVp = (($pcjVc/$queryVc->num_rows())/$usComi);

                        $rowPcjVp = $valoresP ->row();
                        $pcjVp= $rowPcjVp->porcentaje_decimal;
                        $comiVp= $rowPcjVp->comision_total;

                        $newComiVp = (($comiVp*$newPorcentajeVp)/$pcjVp);
                        $newComiVc = (($comiVc*$newPorcentajeVc)/$pcjVc);

                        // Se topa comision del usuario de vc
                            $UpdateComiVc = "UPDATE comisiones 
                            SET comision_total = ?,
                                porcentaje_decimal = ?,
                                modificado_por = ?
                            WHERE id_lote = ? 
                            AND id_usuario = ?";
                            $this->db->query($UpdateComiVc, array($newComiVc, $newPorcentajeVc, $modificadoPor, $idLote, $asesor));

                        // Se topa comision de usuarios vp
                            $updateComiVp = "UPDATE comisiones 
                            SET comision_total = ?, 
                                porcentaje_decimal = ?, 
                                modificado_por = ? 
                            WHERE id_lote = ? 
                            AND id_usuario IN (
                                SELECT comi.id_usuario 
                                FROM comisiones comi
                                WHERE id_lote = ? 
                                AND rol_generado IN (
                                    SELECT rol_generado 
                                    FROM comisiones 
                                    WHERE id_lote = ? 
                                    AND id_usuario = ?
                                ) 
                                AND comi.id_usuario != ?)";
                                $this->db->query($updateComiVp, [
                                    $newComiVp,
                                    $newPorcentajeVp,
                                    $modificadoPor,
                                    $idLote,
                                    $idLote,
                                    $idLote,
                                    $asesor,
                                    $asesor
                                ]);

                        }else{

                            // Delete a pagos individuales de usuario vc en estatus = 1
                            $sqlDelete = "DELETE FROM pago_comision_ind
                            WHERE id_usuario = ? AND estatus = 1
                            AND id_comision IN (
                                SELECT id_comision FROM comisiones WHERE estatus = 1 AND id_lote = ? AND id_usuario = ?
                            )";
                            $this->db->query($sqlDelete, array($asesor, $idLote, $asesor));

                            // Consulta para obtener suma de pagos individuales de usuario de vc estatus != 1
                            $querySum = $this->db->query("SELECT SUM(abono_neodata) AS abono
                            FROM pago_comision_ind
                            WHERE id_usuario = $asesor AND estatus != 1
                            AND id_comision IN (
                            SELECT id_comision FROM comisiones WHERE estatus = 1 AND id_lote = $idLote)");

                            $rowSumaAn = $querySum->row();
                            $abonoUsVc = $rowSumaAn->abono;

                            // Se topa comision del usuario de vc
                            $sqlUpdate = "UPDATE comisiones 
                            SET comision_total = ?,
                                modificado_por = ?
                            WHERE id_lote = ? 
                            AND id_usuario = ?";
                            $this->db->query($sqlUpdate, array($abonoUsVc, $modificadoPor, $idLote, $asesor));

                            $rowValoresP = $valoresP ->row();
                            $porcentajeP = $rowValoresP->porcentaje_decimal;
                            $comisionP = $rowValoresP->comision_total;

                            $prcentajeVpFinal = (($porcentajeP/$count)+$porcentajeP);
                            $comisionVpFinal = (($comisionP*($prcentajeVpFinal/100))/($porcentajeP/100));

                            // Se topa comision de usuarios vp
                            $updateUsP = $this->db->query("UPDATE comisiones 
                            SET porcentaje_decimal = $prcentajeVpFinal, 
                                comision_total = $comisionVpFinal,
                                modificado_por = '$modificadoPor'
                            WHERE id_lote = $idLote 
                            AND id_usuario IN (
                                SELECT comi.id_usuario 
                                FROM comisiones comi
                                WHERE id_lote = $idLote 
                                    AND rol_generado IN(SELECT rol_generado FROM comisiones WHERE id_lote = $idLote AND id_usuario = $asesor)
                                    AND comi.id_usuario != $asesor)");
                        }

                    }
                    if ($row->id_coordinador != null) {
                        $coordinador = $row->id_coordinador;

                        // Número de registros de ventas compartidas de usuario 
                        $queryVc = $this->db->query("SELECT * FROM ventas_compartidas vc 
                        WHERE id_asesor = $coordinador AND id_cliente = $idCliente");

                        // Número de usuarios de la venta principal
                        $count = $this->db->query("SELECT COUNT(*) AS count FROM comisiones comi
                        WHERE id_lote = $idLote AND rol_generado IN(SELECT rol_generado FROM comisiones WHERE id_lote = $idLote AND id_usuario = $coordinador)
                        AND comi.id_usuario != $coordinador AND estatus = 1
                        ")->row()->count;

                        // Comisión y porcentaje del usuario de venta principal
                        $valoresP = $this->db->query("SELECT  TOP 1 comi.id_usuario, comi.porcentaje_decimal, comi.comision_total 
                        FROM comisiones comi
                        WHERE comi.id_usuario != $coordinador AND comi.id_lote = $idLote 
                        AND comi.rol_generado IN(SELECT TOP 1 rol_generado FROM comisiones WHERE id_usuario = $coordinador AND id_lote = $idLote)
                        ");

                        // Si el usuario de vc tiene mas de un registro
                        if($queryVc->num_rows() > 1){

                        //Número de usuarios a topar
                        $usComi = ($count + $queryVc->num_rows())-1;

                        $UsVc = $this->db->query("SELECT porcentaje_decimal, comision_total from comisiones WHERE id_lote = $idLote AND id_usuario = $coordinador");

                        $rowPcjVc = $UsVc->row();
                        $pcjVc = $rowPcjVc->porcentaje_decimal;
                        $comiVc= $rowPcjVc->comision_total;

                        $newPorcentajeVc = (($pcjVc/$queryVc->num_rows())*($queryVc->num_rows()-1));
                        $newPorcentajeVp = (($pcjVc/$queryVc->num_rows())/$usComi);

                        $rowPcjVp = $valoresP ->row();
                        $pcjVp= $rowPcjVp->porcentaje_decimal;
                        $comiVp= $rowPcjVp->comision_total;

                        $newComiVp = (($comiVp*$newPorcentajeVp)/$pcjVp);
                        $newComiVc = (($comiVc*$newPorcentajeVc)/$pcjVc);

                        // Se topa comision del usuario de vc
                            $UpdateComiVc = "UPDATE comisiones 
                            SET comision_total = ?,
                                porcentaje_decimal = ?,
                                modificado_por = ?
                            WHERE id_lote = ? 
                            AND id_usuario = ?";
                            $this->db->query($UpdateComiVc, array($newComiVc, $newPorcentajeVc, $modificadoPor, $idLote, $coordinador));

                        // Se topa comision de usuarios vp
                            $updateComiVp = "UPDATE comisiones 
                            SET comision_total = ?, 
                                porcentaje_decimal = ?, 
                                modificado_por = ? 
                            WHERE id_lote = ? 
                            AND id_usuario IN (
                                SELECT comi.id_usuario 
                                FROM comisiones comi
                                WHERE id_lote = ? 
                                AND rol_generado IN (
                                    SELECT rol_generado 
                                    FROM comisiones 
                                    WHERE id_lote = ? 
                                    AND id_usuario = ?
                                ) 
                                AND comi.id_usuario != ?)";
                                $this->db->query($updateComiVp, [
                                    $newComiVp,
                                    $newPorcentajeVp,
                                    $modificadoPor,
                                    $idLote,
                                    $idLote,
                                    $idLote,
                                    $coordinador,
                                    $coordinador
                                ]);

                        }else{

                            // Delete a pagos individuales de usuario vc en estatus = 1
                            $sqlDelete = "DELETE FROM pago_comision_ind
                            WHERE id_usuario = ? AND estatus = 1
                            AND id_comision IN (
                                SELECT id_comision FROM comisiones WHERE estatus = 1 AND id_lote = ? AND id_usuario = ?
                            )";
                            $this->db->query($sqlDelete, array($coordinador, $idLote, $coordinador));

                            // Consulta para obtener suma de pagos individuales de usuario de vc estatus != 1
                            $querySum = $this->db->query("SELECT SUM(abono_neodata) AS abono
                            FROM pago_comision_ind
                            WHERE id_usuario = $coordinador AND estatus != 1
                            AND id_comision IN (
                            SELECT id_comision FROM comisiones WHERE estatus = 1 AND id_lote = $idLote)");

                            $rowSumaAn = $querySum->row();
                            $abonoUsVc = $rowSumaAn->abono;

                            // Se topa comision del usuario de vc
                            $sqlUpdate = "UPDATE comisiones 
                            SET comision_total = ?,
                                modificado_por = ?
                            WHERE id_lote = ? 
                            AND id_usuario = ?";
                            $this->db->query($sqlUpdate, array($abonoUsVc, $modificadoPor, $idLote, $coordinador));

                            $rowValoresP = $valoresP ->row();
                            $porcentajeP = $rowValoresP->porcentaje_decimal;
                            $comisionP = $rowValoresP->comision_total;

                            $prcentajeVpFinal = (($porcentajeP/$count)+$porcentajeP);
                            $comisionVpFinal = (($comisionP*($prcentajeVpFinal/100))/($porcentajeP/100));

                            // Se topa comision de usuarios vp
                            $updateUsP = $this->db->query("UPDATE comisiones 
                            SET porcentaje_decimal = $prcentajeVpFinal, 
                                comision_total = $comisionVpFinal,
                                modificado_por = '$modificadoPor'
                            WHERE id_lote = $idLote 
                            AND id_usuario IN (
                                SELECT comi.id_usuario 
                                FROM comisiones comi
                                WHERE id_lote = $idLote 
                                    AND rol_generado IN(SELECT rol_generado FROM comisiones WHERE id_lote = $idLote AND id_usuario = $coordinador)
                                    AND comi.id_usuario != $coordinador)");
                        }

                    }
                    if ($row->id_gerente != null) {
                        $gerente = $row->id_gerente;

                        // Número de registros de ventas compartidas de usuario 
                        $queryVc = $this->db->query("SELECT * FROM ventas_compartidas vc 
                        WHERE id_asesor = $gerente AND id_cliente = $idCliente");

                        // Número de usuarios de la venta principal
                        $count = $this->db->query("SELECT COUNT(*) AS count FROM comisiones comi
                        WHERE id_lote = $idLote AND rol_generado IN(SELECT rol_generado FROM comisiones WHERE id_lote = $idLote AND id_usuario = $gerente)
                        AND comi.id_usuario != $gerente AND estatus = 1
                        ")->row()->count;

                        // Comisión y porcentaje del usuario de venta principal
                        $valoresP = $this->db->query("SELECT  TOP 1 comi.id_usuario, comi.porcentaje_decimal, comi.comision_total 
                        FROM comisiones comi
                        WHERE comi.id_usuario != $gerente AND comi.id_lote = $idLote 
                        AND comi.rol_generado IN(SELECT TOP 1 rol_generado FROM comisiones WHERE id_usuario = $gerente AND id_lote = $idLote)
                        ");

                        // Si el usuario de vc tiene mas de un registro
                        if($queryVc->num_rows() > 1){

                        //Número de usuarios a topar
                        $usComi = ($count + $queryVc->num_rows())-1;

                        $UsVc = $this->db->query("SELECT porcentaje_decimal, comision_total from comisiones WHERE id_lote = $idLote AND id_usuario = $gerente");

                        $rowPcjVc = $UsVc->row();
                        $pcjVc = $rowPcjVc->porcentaje_decimal;
                        $comiVc= $rowPcjVc->comision_total;

                        $newPorcentajeVc = (($pcjVc/$queryVc->num_rows())*($queryVc->num_rows()-1));
                        $newPorcentajeVp = (($pcjVc/$queryVc->num_rows())/$usComi);

                        $rowPcjVp = $valoresP ->row();
                        $pcjVp= $rowPcjVp->porcentaje_decimal;
                        $comiVp= $rowPcjVp->comision_total;

                        $newComiVp = (($comiVp*$newPorcentajeVp)/$pcjVp);
                        $newComiVc = (($comiVc*$newPorcentajeVc)/$pcjVc);

                        // Se topa comision del usuario de vc
                            $UpdateComiVc = "UPDATE comisiones 
                            SET comision_total = ?,
                                porcentaje_decimal = ?,
                                modificado_por = ?
                            WHERE id_lote = ? 
                            AND id_usuario = ?";
                            $this->db->query($UpdateComiVc, array($newComiVc, $newPorcentajeVc, $modificadoPor, $idLote, $gerente));

                        // Se topa comision de usuarios vp
                            $updateComiVp = "UPDATE comisiones 
                            SET comision_total = ?, 
                                porcentaje_decimal = ?, 
                                modificado_por = ? 
                            WHERE id_lote = ? 
                            AND id_usuario IN (
                                SELECT comi.id_usuario 
                                FROM comisiones comi
                                WHERE id_lote = ? 
                                AND rol_generado IN (
                                    SELECT rol_generado 
                                    FROM comisiones 
                                    WHERE id_lote = ? 
                                    AND id_usuario = ?
                                ) 
                                AND comi.id_usuario != ?)";
                                $this->db->query($updateComiVp, [
                                    $newComiVp,
                                    $newPorcentajeVp,
                                    $modificadoPor,
                                    $idLote,
                                    $idLote,
                                    $idLote,
                                    $gerente,
                                    $gerente
                                ]);

                        }else{

                            // Delete a pagos individuales de usuario vc en estatus = 1
                            $sqlDelete = "DELETE FROM pago_comision_ind
                            WHERE id_usuario = ? AND estatus = 1
                            AND id_comision IN (
                                SELECT id_comision FROM comisiones WHERE estatus = 1 AND id_lote = ? AND id_usuario = ?
                            )";
                            $this->db->query($sqlDelete, array($gerente, $idLote, $gerente));

                            // Consulta para obtener suma de pagos individuales de usuario de vc estatus != 1
                            $querySum = $this->db->query("SELECT SUM(abono_neodata) AS abono
                            FROM pago_comision_ind
                            WHERE id_usuario = $gerente AND estatus != 1
                            AND id_comision IN (
                            SELECT id_comision FROM comisiones WHERE estatus = 1 AND id_lote = $idLote)");

                            $rowSumaAn = $querySum->row();
                            $abonoUsVc = $rowSumaAn->abono;

                            // Se topa comision del usuario de vc
                            $sqlUpdate = "UPDATE comisiones 
                            SET comision_total = ?,
                                modificado_por = ?
                            WHERE id_lote = ? 
                            AND id_usuario = ?";
                            $this->db->query($sqlUpdate, array($abonoUsVc, $modificadoPor, $idLote, $gerente));

                            $rowValoresP = $valoresP ->row();
                            $porcentajeP = $rowValoresP->porcentaje_decimal;
                            $comisionP = $rowValoresP->comision_total;

                            $prcentajeVpFinal = (($porcentajeP/$count)+$porcentajeP);
                            $comisionVpFinal = (($comisionP*($prcentajeVpFinal/100))/($porcentajeP/100));

                            // Se topa comision de usuarios vp
                            $updateUsP = $this->db->query("UPDATE comisiones 
                            SET porcentaje_decimal = $prcentajeVpFinal, 
                                comision_total = $comisionVpFinal,
                                modificado_por = '$modificadoPor'
                            WHERE id_lote = $idLote 
                            AND id_usuario IN (
                                SELECT comi.id_usuario 
                                FROM comisiones comi
                                WHERE id_lote = $idLote 
                                    AND rol_generado IN(SELECT rol_generado FROM comisiones WHERE id_lote = $idLote AND id_usuario = $gerente)
                                    AND comi.id_usuario != $gerente)");
                        }

                    }
                    if ($row->id_subdirector != null) {
                        $subdirector = $row->id_subdirector;

                        // Número de registros de ventas compartidas de usuario 
                        $queryVc = $this->db->query("SELECT * FROM ventas_compartidas vc 
                        WHERE id_asesor = $subdirector AND id_cliente = $idCliente");

                        // Número de usuarios de la venta principal
                        $count = $this->db->query("SELECT COUNT(*) AS count FROM comisiones comi
                        WHERE id_lote = $idLote AND rol_generado IN(SELECT rol_generado FROM comisiones WHERE id_lote = $idLote AND id_usuario = $subdirector)
                        AND comi.id_usuario != $subdirector AND estatus = 1
                        ")->row()->count;

                        // Comisión y porcentaje del usuario de venta principal
                        $valoresP = $this->db->query("SELECT  TOP 1 comi.id_usuario, comi.porcentaje_decimal, comi.comision_total 
                        FROM comisiones comi
                        WHERE comi.id_usuario != $subdirector AND comi.id_lote = $idLote 
                        AND comi.rol_generado IN(SELECT TOP 1 rol_generado FROM comisiones WHERE id_usuario = $subdirector AND id_lote = $idLote)
                        ");

                        // Si el usuario de vc tiene mas de un registro
                        if($queryVc->num_rows() > 1){

                        //Número de usuarios a topar
                        $usComi = ($count + $queryVc->num_rows())-1;

                        $UsVc = $this->db->query("SELECT porcentaje_decimal, comision_total from comisiones WHERE id_lote = $idLote AND id_usuario = $subdirector");

                        $rowPcjVc = $UsVc->row();
                        $pcjVc = $rowPcjVc->porcentaje_decimal;
                        $comiVc= $rowPcjVc->comision_total;

                        $newPorcentajeVc = (($pcjVc/$queryVc->num_rows())*($queryVc->num_rows()-1));
                        $newPorcentajeVp = (($pcjVc/$queryVc->num_rows())/$usComi);

                        $rowPcjVp = $valoresP ->row();
                        $pcjVp= $rowPcjVp->porcentaje_decimal;
                        $comiVp= $rowPcjVp->comision_total;

                        $newComiVp = (($comiVp*$newPorcentajeVp)/$pcjVp);
                        $newComiVc = (($comiVc*$newPorcentajeVc)/$pcjVc);

                        // Se topa comision del usuario de vc
                            $UpdateComiVc = "UPDATE comisiones 
                            SET comision_total = ?,
                                porcentaje_decimal = ?,
                                modificado_por = ?
                            WHERE id_lote = ? 
                            AND id_usuario = ?";
                            $this->db->query($UpdateComiVc, array($newComiVc, $newPorcentajeVc, $modificadoPor, $idLote, $subdirector));

                        // Se topa comision de usuarios vp
                            $updateComiVp = "UPDATE comisiones 
                            SET comision_total = ?, 
                                porcentaje_decimal = ?, 
                                modificado_por = ? 
                            WHERE id_lote = ? 
                            AND id_usuario IN (
                                SELECT comi.id_usuario 
                                FROM comisiones comi
                                WHERE id_lote = ? 
                                AND rol_generado IN (
                                    SELECT rol_generado 
                                    FROM comisiones 
                                    WHERE id_lote = ? 
                                    AND id_usuario = ?
                                ) 
                                AND comi.id_usuario != ?)";
                                $this->db->query($updateComiVp, [
                                    $newComiVp,
                                    $newPorcentajeVp,
                                    $modificadoPor,
                                    $idLote,
                                    $idLote,
                                    $idLote,
                                    $subdirector,
                                    $subdirector
                                ]);

                        }else{

                            // Delete a pagos individuales de usuario vc en estatus = 1
                            $sqlDelete = "DELETE FROM pago_comision_ind
                            WHERE id_usuario = ? AND estatus = 1
                            AND id_comision IN (
                                SELECT id_comision FROM comisiones WHERE estatus = 1 AND id_lote = ? AND id_usuario = ?
                            )";
                            $this->db->query($sqlDelete, array($subdirector, $idLote, $subdirector));

                            // Consulta para obtener suma de pagos individuales de usuario de vc estatus != 1
                            $querySum = $this->db->query("SELECT SUM(abono_neodata) AS abono
                            FROM pago_comision_ind
                            WHERE id_usuario = $subdirector AND estatus != 1
                            AND id_comision IN (
                            SELECT id_comision FROM comisiones WHERE estatus = 1 AND id_lote = $idLote)");

                            $rowSumaAn = $querySum->row();
                            $abonoUsVc = $rowSumaAn->abono;

                            // Se topa comision del usuario de vc
                            $sqlUpdate = "UPDATE comisiones 
                            SET comision_total = ?,
                                modificado_por = ?
                            WHERE id_lote = ? 
                            AND id_usuario = ?";
                            $this->db->query($sqlUpdate, array($abonoUsVc, $modificadoPor, $idLote, $subdirector));

                            $rowValoresP = $valoresP ->row();
                            $porcentajeP = $rowValoresP->porcentaje_decimal;
                            $comisionP = $rowValoresP->comision_total;

                            $prcentajeVpFinal = (($porcentajeP/$count)+$porcentajeP);
                            $comisionVpFinal = (($comisionP*($prcentajeVpFinal/100))/($porcentajeP/100));

                            // Se topa comision de usuarios vp
                            $updateUsP = $this->db->query("UPDATE comisiones 
                            SET porcentaje_decimal = $prcentajeVpFinal, 
                                comision_total = $comisionVpFinal,
                                modificado_por = '$modificadoPor'
                            WHERE id_lote = $idLote 
                            AND id_usuario IN (
                                SELECT comi.id_usuario 
                                FROM comisiones comi
                                WHERE id_lote = $idLote 
                                    AND rol_generado IN(SELECT rol_generado FROM comisiones WHERE id_lote = $idLote AND id_usuario = $subdirector)
                                    AND comi.id_usuario != $subdirector)");
                        }

                    }
                    if ($row->id_regional != null) {
                        $regional = $row->id_regional;

                        // Número de registros de ventas compartidas de usuario 
                        $queryVc = $this->db->query("SELECT * FROM ventas_compartidas vc 
                        WHERE id_asesor = $regional AND id_cliente = $idCliente");

                        // Número de usuarios de la venta principal
                        $count = $this->db->query("SELECT COUNT(*) AS count FROM comisiones comi
                        WHERE id_lote = $idLote AND rol_generado IN(SELECT rol_generado FROM comisiones WHERE id_lote = $idLote AND id_usuario = $regional)
                        AND comi.id_usuario != $regional AND estatus = 1
                        ")->row()->count;

                        // Comisión y porcentaje del usuario de venta principal
                        $valoresP = $this->db->query("SELECT  TOP 1 comi.id_usuario, comi.porcentaje_decimal, comi.comision_total 
                        FROM comisiones comi
                        WHERE comi.id_usuario != $regional AND comi.id_lote = $idLote 
                        AND comi.rol_generado IN(SELECT TOP 1 rol_generado FROM comisiones WHERE id_usuario = $regional AND id_lote = $idLote)
                        ");

                        // Si el usuario de vc tiene mas de un registro
                        if($queryVc->num_rows() > 1){

                        //Número de usuarios a topar
                        $usComi = ($count + $queryVc->num_rows())-1;

                        $UsVc = $this->db->query("SELECT porcentaje_decimal, comision_total from comisiones WHERE id_lote = $idLote AND id_usuario = $regional");

                        $rowPcjVc = $UsVc->row();
                        $pcjVc = $rowPcjVc->porcentaje_decimal;
                        $comiVc= $rowPcjVc->comision_total;

                        $newPorcentajeVc = (($pcjVc/$queryVc->num_rows())*($queryVc->num_rows()-1));
                        $newPorcentajeVp = (($pcjVc/$queryVc->num_rows())/$usComi);

                        $rowPcjVp = $valoresP ->row();
                        $pcjVp= $rowPcjVp->porcentaje_decimal;
                        $comiVp= $rowPcjVp->comision_total;

                        $newComiVp = (($comiVp*$newPorcentajeVp)/$pcjVp);
                        $newComiVc = (($comiVc*$newPorcentajeVc)/$pcjVc);

                        // Se topa comision del usuario de vc
                            $UpdateComiVc = "UPDATE comisiones 
                            SET comision_total = ?,
                                porcentaje_decimal = ?,
                                modificado_por = ?
                            WHERE id_lote = ? 
                            AND id_usuario = ?";
                            $this->db->query($UpdateComiVc, array($newComiVc, $newPorcentajeVc, $modificadoPor, $idLote, $regional));

                        // Se topa comision de usuarios vp
                            $updateComiVp = "UPDATE comisiones 
                            SET comision_total = ?, 
                                porcentaje_decimal = ?, 
                                modificado_por = ? 
                            WHERE id_lote = ? 
                            AND id_usuario IN (
                                SELECT comi.id_usuario 
                                FROM comisiones comi
                                WHERE id_lote = ? 
                                AND rol_generado IN (
                                    SELECT rol_generado 
                                    FROM comisiones 
                                    WHERE id_lote = ? 
                                    AND id_usuario = ?
                                ) 
                                AND comi.id_usuario != ?)";
                                $this->db->query($updateComiVp, [
                                    $newComiVp,
                                    $newPorcentajeVp,
                                    $modificadoPor,
                                    $idLote,
                                    $idLote,
                                    $idLote,
                                    $regional,
                                    $regional
                                ]);

                        }else{

                            // Delete a pagos individuales de usuario vc en estatus = 1
                            $sqlDelete = "DELETE FROM pago_comision_ind
                            WHERE id_usuario = ? AND estatus = 1
                            AND id_comision IN (
                                SELECT id_comision FROM comisiones WHERE estatus = 1 AND id_lote = ? AND id_usuario = ?
                            )";
                            $this->db->query($sqlDelete, array($regional, $idLote, $regional));

                            // Consulta para obtener suma de pagos individuales de usuario de vc estatus != 1
                            $querySum = $this->db->query("SELECT SUM(abono_neodata) AS abono
                            FROM pago_comision_ind
                            WHERE id_usuario = $regional AND estatus != 1
                            AND id_comision IN (
                            SELECT id_comision FROM comisiones WHERE estatus = 1 AND id_lote = $idLote)");

                            $rowSumaAn = $querySum->row();
                            $abonoUsVc = $rowSumaAn->abono;

                            // Se topa comision del usuario de vc
                            $sqlUpdate = "UPDATE comisiones 
                            SET comision_total = ?,
                                modificado_por = ?
                            WHERE id_lote = ? 
                            AND id_usuario = ?";
                            $this->db->query($sqlUpdate, array($abonoUsVc, $modificadoPor, $idLote, $regional));

                            $rowValoresP = $valoresP ->row();
                            $porcentajeP = $rowValoresP->porcentaje_decimal;
                            $comisionP = $rowValoresP->comision_total;

                            $prcentajeVpFinal = (($porcentajeP/$count)+$porcentajeP);
                            $comisionVpFinal = (($comisionP*($prcentajeVpFinal/100))/($porcentajeP/100));

                            // Se topa comision de usuarios vp
                            $updateUsP = $this->db->query("UPDATE comisiones 
                            SET porcentaje_decimal = $prcentajeVpFinal, 
                                comision_total = $comisionVpFinal,
                                modificado_por = '$modificadoPor'
                            WHERE id_lote = $idLote 
                            AND id_usuario IN (
                                SELECT comi.id_usuario 
                                FROM comisiones comi
                                WHERE id_lote = $idLote 
                                    AND rol_generado IN(SELECT rol_generado FROM comisiones WHERE id_lote = $idLote AND id_usuario = $regional)
                                    AND comi.id_usuario != $regional)");
                        }

                    }
                }
            }
           // exit;

            $cmd = ("UPDATE ventas_compartidas SET estatus = 0, modificado_por = $modificadoPor WHERE id_vcompartida = $id");
            $respuesta =  $this->db->query($cmd);

            return $respuesta ? 1 : 0;
        } */
        
        public function getUserInventario($id_cliente){
            $cmd = "SELECT cl.id_cliente, ase.id_usuario AS id_asesor,  CONCAT(ase.nombre, ' ', ase.apellido_paterno, ' ', ase.apellido_materno) AS asesor, coor.id_usuario AS id_coordinador,  CONCAT(coor.nombre, ' ', coor.apellido_paterno, ' ', coor.apellido_materno) AS coordinador, ger.id_usuario AS id_gerente,  CONCAT(ger.nombre, ' ', ger.apellido_paterno, ' ', ger.apellido_materno) AS gerente, subd.id_usuario AS id_subdirector, CONCAT(subd.nombre,' ', subd.apellido_paterno, ' ', subd.apellido_materno) AS subdirector, regio.id_usuario AS id_regional, concat (regio.nombre, ' ',regio.apellido_paterno, ' ', regio.apellido_materno) AS regional
            FROM clientes cl 
            INNER JOIN usuarios ase on ase.id_usuario=cl.id_asesor 
            INNER JOIN usuarios ger on ger.id_usuario=cl.id_gerente 
            LEFT JOIN usuarios coor on coor.id_usuario=cl.id_coordinador  
            INNER JOIN usuarios subd on subd.id_usuario=cl.id_subdirector 
            LEFT JOIN usuarios regio on regio.id_usuario=cl.id_regional
            WHERE cl.id_cliente =$id_cliente";
            return  $this->db->query($cmd);
        }

        public function datosLotesaCeder($id_usuario){
            ini_set('max_execution_time', 0);
            $comisiones =  $this->db->query("SELECT com.id_comision,com.id_lote,com.id_usuario,l.totalNeto2,l.nombreLote,com.comision_total,com.porcentaje_decimal 
            FROM comisiones com 
            INNER JOIN lotes l on l.idLote=com.id_lote 
            WHERE com.id_usuario=".$id_usuario."")->result_array();
            $infoCedida = array();
            $cc=0;

            for ($i=0; $i <count($comisiones) ; $i++) { 
                $sumaxcomision=0;
                $Restante=0;
                $SumaTopar = $this->db->query("SELECT SUM(abono_neodata) AS suma 
                FROM pago_comision_ind 
                WHERE id_comision=".$comisiones[$i]['id_comision']." AND estatus NOT IN(1,6)")->result_array();
                
                if( $SumaTopar[0]['suma'] == 'NULL' ||  $SumaTopar[0]['suma'] == null ||  $SumaTopar[0]['suma'] == 0 || $SumaTopar[0]['suma'] == '' ){
                    $sumaxcomision = 0;
                }else{
                    $sumaxcomision = $SumaTopar[0]['suma'];
                }
                
                $Restante=0;
            
                if($sumaxcomision < ($comisiones[$i]['comision_total'] - 0.5)){
                    $Restante = $comisiones[$i]['comision_total'] - $sumaxcomision;
                    $infoCedida[$cc] = array(
                        "id_lote" => $comisiones[$i]['id_lote'],
                        "nombreLote" => $comisiones[$i]['nombreLote'],
                        "com_total" => $comisiones[$i]['comision_total'],
                        "tope" => $sumaxcomision,
                        "resto" => $Restante
                    );
                    $cc=$cc+1;
                }
            }
            return $infoCedida;
        }
            
        public function saveTipoVenta($idLote,$tipo){
            $cmd = ("UPDATE lotes SET tipo_venta = $tipo WHERE idLote = $idLote");
            $respuesta =  $this->db->query($cmd);
                
            if($respuesta){
                return 1;
            }else{
                return 0;
            }
        }
        
        function AddVentaCompartida($id_asesor,$coor,$ger,$sub,$id_cliente,$id_lote){
            date_default_timezone_set('America/Mexico_City');       
            $response = $this->db->query("INSERT INTO ventas_compartidas VALUES($id_cliente,$id_asesor,$coor,$ger,1,GETDATE(),".$this->session->userdata('id_usuario').",$sub, GETDATE(),".$this->session->userdata('id_usuario').",0,0,0);");

            $usuario = 0;
            $rolSelect = 0;
            $porcentaje = 0;

            for($i=0;$i<4;$i++){
                if($i== 0){ //Asesor
                    $usuario=$id_asesor;
                    $rolSelect =7;
                    $porcentaje=1.5;
                } else if($i == 1){ //Coordinador
                    $usuario=$coor;
                    $rolSelect =9;
                    $porcentaje=0.5;
                } else if($i == 2){ //Gerente
                    $usuario=$ger;
                    $rolSelect =3;
                    $porcentaje=0.5;
                } else if($i == 3){ //Subdir
                    $usuario=$sub;
                    $rolSelect =2;
                    $porcentaje=0.5;
                }

                $validate = $this->db->query("SELECT id_usuario FROM comisiones WHERE id_lote IN (SELECT idLote FROM lotes WHERE idLote = $id_lote) AND id_usuario = $usuario");
                $data_lote = $this->db->query("SELECT idLote, totalNeto2 FROM lotes WHERE idLote = $id_lote");
                $precio_lote = $data_lote->row()->totalNeto2;
                $comision_total=$precio_lote * ($porcentaje /100);
        
                if(empty($validate->row()->id_usuario)){
                    $response = $this->db->query("UPDATE comisiones SET comision_total=$comision_total,porcentaje_decimal=$porcentaje,modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_lote=".$id_lote." AND rol_generado=$rolSelect");
                    $response = $this->db->query("INSERT INTO comisiones(id_lote,id_usuario,comision_total,estatus,observaciones,evidencia,factura,creado_por,fecha_creacion,porcentaje_decimal,fecha_autorizacion,rol_generado,descuento,idCliente,modificado_por) 
                    VALUES (".$id_lote.",$usuario,$comision_total,1,'SE AGREGÓ VENTA COMPARTIDA',NULL,NULL,".$this->session->userdata('id_usuario').",GETDATE(),$porcentaje,GETDATE(),$rolSelect,0,$id_cliente,'".$this->session->userdata('id_usuario')."')");
                }
            }
        
            if($response){
                return 1;
            } else{
                return 0;
            }  
        }

        public function getPagosByComision($id_comision){
            $datos =  $this->db-> query("SELECT pci.id_pago_i,pci.abono_neodata,CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario,cat.nombre,pci.comentario
            FROM pago_comision_ind pci 
            INNER JOIN usuarios u ON u.id_usuario=pci.id_usuario 
            INNER JOIN opcs_x_cats cat ON cat.id_opcion=pci.estatus
            WHERE pci.id_comision=$id_comision AND pci.estatus IN(1,6) AND cat.id_catalogo=23")->result_array();
            return $datos;
        }

        function getComisionesLoteSelected($idLote){
            return $this->db->query("SELECT * FROM comisiones WHERE id_lote=$idLote");
        }

        public function getDatosAbonadoSuma11($idlote){
            return $this->db->query("SELECT SUM(pci.abono_neodata) abonado, pac.total_comision, c2.abono_pagado, lo.totalNeto2, cl.lugar_prospeccion
            FROM lotes lo
            INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
            INNER JOIN comisiones c1 ON lo.idLote = c1.id_lote AND c1.estatus = 1
            LEFT JOIN (SELECT SUM(comision_total) abono_pagado, id_comision FROM comisiones WHERE descuento IN (1) AND estatus = 1 GROUP BY id_comision) c2 ON c1.id_comision = c2.id_comision
            INNER JOIN pago_comision pac ON pac.id_lote = lo.idLote
            LEFT JOIN pago_comision_ind pci on pci.id_comision = c1.id_comision
            WHERE lo.status = 1 AND cl.status = 1 AND c1.estatus = 1 AND lo.idLote IN ($idlote)
            GROUP BY lo.idLote, lo.referencia, pac.total_comision, lo.totalNeto2, cl.lugar_prospeccion, c2.abono_pagado");
        }

        public function CambiarPrecioLote($idLote,$precio,$comentario){

            $comisiones = $this->db-> query("SELECT * FROM comisiones WHERE id_lote=$idLote AND id_usuario !=0 AND estatus NOT IN(8,2)")->result_array();
            if(count($comisiones) == 0){
                $respuesta =  $this->db->query("UPDATE lotes SET totalNeto2=".$precio." WHERE idLote=".$idLote.";");
                $respuesta = $this->db->query("INSERT INTO historial_log VALUES($idLote,".$this->session->userdata('id_usuario').",GETDATE(),1,'$comentario','lotes',NULL, null, null, null)");
            } else{
                $respuesta =  $this->db->query("UPDATE lotes SET totalNeto2=".$precio." WHERE idLote=".$idLote.";");
                $respuesta = $this->db->query("INSERT INTO historial_log VALUES($idLote,".$this->session->userdata('id_usuario').",GETDATE(),1,'$comentario','lotes', null, null, null, null)");
                for ($i=0; $i <count($comisiones) ; $i++) { 
                    $comisionTotal =$precio *($comisiones[$i]['porcentaje_decimal']/100);
                    $comentario2='Se actualizó la comision total por cambio de precio del lote de'.$comisiones[$i]['comision_total'].' a '.$comisionTotal;
                    $respuesta =  $this->db->query("UPDATE comisiones SET comision_total=$comisionTotal,modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_comision=".$comisiones[$i]['id_comision']." AND id_lote=".$idLote.";");
                    $respuesta = $this->db->query("INSERT INTO historial_log VALUES(".$comisiones[$i]['id_comision'].",".$this->session->userdata('id_usuario').",GETDATE(),1,'$comentario2','comisiones',NULL, null, null, null)");   
                }
            }
            
            if($respuesta){
                return 1;
            }else{
                return 0;
            }
        }

        public function ToparComision($id_comision,$comentario=''){  
            date_default_timezone_set('America/Mexico_City');
            $hoy = date('Y-m-d H:i:s');     
            $complemento = '';
            if($comentario != ''){
                $complemento = ",observaciones='".$comentario."'";
            }

            $sumaxcomision=0;
            $pagos = $this->db->query("SELECT pci.id_usuario,pci.id_pago_i,pci.abono_neodata,CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario,cat.nombre,pci.comentario
            FROM pago_comision_ind pci 
            INNER JOIN usuarios u ON u.id_usuario=pci.id_usuario 
            INNER JOIN opcs_x_cats cat ON cat.id_opcion=pci.estatus
            WHERE pci.id_comision=$id_comision AND pci.estatus IN(1,6) AND cat.id_catalogo=23")->result_array();
            $pagos_ind = $this->db->query("SELECT SUM(abono_neodata) AS suma FROM pago_comision_ind WHERE id_comision=".$id_comision." AND estatus NOT IN(1,6,5)")->result_array();
            $sumaxcomision = $pagos_ind[0]['suma'];
            for ($j=0; $j <count($pagos) ; $j++) { 
                $comentario= 'Se eliminó el pago';
                $this->db->query("UPDATE pago_comision_ind SET estatus=0,abono_neodata=0,modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i=".$pagos[$j]['id_pago_i']." AND id_usuario=".$pagos[$j]['id_usuario'].";");
                $this->db->query("INSERT INTO  historial_comisiones VALUES (".$pagos[$j]['id_pago_i'].", ".$this->session->userdata('id_usuario').", GETDATE(), 1, '".$comentario."')");
            }

            $this->db->query("INSERT INTO  historial_log VALUES ($id_comision,".$this->session->userdata('id_usuario').",'".$hoy."',1,'SE TOPO COMISIÓN','comisiones',NULL, null, null, null)");

            if($sumaxcomision == 0  || $sumaxcomision == null || $sumaxcomision == 'null' ){
                $this->db->query("UPDATE comisiones SET comision_total=0,descuento=1,modificado_por='".$this->session->userdata('id_usuario')."' $complemento WHERE id_comision=".$id_comision." ");
            }else{
                $this->db->query("UPDATE comisiones SET comision_total=$sumaxcomision,descuento=1,modificado_por='".$this->session->userdata('id_usuario')."' $complemento WHERE id_comision=".$id_comision." ");
            }
    
            return $pagos;
        }

        public function tieneRegional (){
            $cmd = "SELECT id_usuario FROM usuarios WHERE id_rol = 2";
            $query = $this->db->query($cmd);
            return $query->result_array();
        }

        public function tieneRegional1 ($usuario){
            $cmd = "SELECT id_usuario,id_lider,id_rol, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS name 
            FROM usuarios 
            WHERE  id_rol = 2 AND id_usuario  IN (SELECT id_lider FROM usuarios WHERE id_usuario = $usuario ) ";
            $query = $this->db->query($cmd);
            return  $query->result_array()  ;
        }

        function getLideres($lider){
            return $this->db->query("SELECT u.id_usuario AS id_usuario1,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) AS name_user,u2.id_usuario AS id_usuario2,CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno) AS name_user2,
            u3.id_usuario AS id_usuario3,CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno) AS name_user3 FROM usuarios u INNER JOIN usuarios u2 on u.id_lider=u2.id_usuario INNER JOIN usuarios u3 on u3.id_usuario=u2.id_lider WHERE u.id_usuario=$lider");
        }

        function updateBandera($id_pagoc, $param) {
            $response = $this->db->query("UPDATE pago_comision SET bandera = ".$param." WHERE id_lote IN (".$id_pagoc.")");
            if($param == 55){
                $response = $this->db->query("UPDATE lotes SET registro_comision = 1 WHERE idLote IN (".$id_pagoc.")");
            }
    
            if (! $response ) {
                return $finalAnswer = 0;
            } else {
                return $finalAnswer = 1;
            }
        }

        public function getDatosAbonadoDispersion($idlote){
            $request = $this->db->query("SELECT lugar_prospeccion, estructura FROM clientes WHERE idLote = $idlote AND status = 1")->row();
            $estrucura = $request->estructura;
            if($request->lugar_prospeccion == 6)
                $rel_final = 6;
            else
                $rel_final = 11;
                
            return $this->db->query("SELECT com.id_comision, com.id_usuario, lo.totalNeto2, lo.idLote, res.idResidencial, lo.referencia, lo.tipo_venta, com.id_lote, lo.nombreLote, com.porcentaje_decimal, CONCAT(us.nombre,' ' ,us.apellido_paterno,' ',us.apellido_materno) colaborador, CASE WHEN $estrucura = 1 THEN oxc2.nombre ELSE oxc.nombre END AS rol, com.comision_total, pci.abono_pagado, com.rol_generado, com.descuento
            FROM comisiones com
            LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind 
            GROUP BY id_comision) pci ON pci.id_comision = com.id_comision
            INNER JOIN lotes lo ON lo.idLote = com.id_lote 
            INNER JOIN usuarios us ON us.id_usuario = com.id_usuario
            INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = com.rol_generado AND oxc.id_catalogo = 1
            INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
            INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
            LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = com.rol_generado AND oxc2.id_catalogo = 83
            WHERE com.id_lote = $idlote  AND com.estatus = 1 ORDER BY com.rol_generado asc");
        }

        public  function sedesCambios (){
            $cmd = "SELECT id_sede,nombre,abreviacion FROM sedes WHERE estatus = 1";
            $query = $this->db->query($cmd);
            return $query->result();
        }

        public function getModalidadCambio($estatus, $id_cliente)
        {
            $query = $this->db->query("UPDATE ventas_compartidas SET estatus = $estatus WHERE id_cliente = $id_cliente");
            return $query;
        }

        public function agregarComentario($id_cliente,$idLote,$descripcionCambio) {
            $data = array(
                'id_cliente' => $id_cliente,
                'comentario' => $descripcionCambio,
                'idLote' => $idLote
            );
        
            $this->db->insert('historial_venta_compartida', $data);
        }        

        public function updateSedesEdit($idCliente, $idLote, $data){
        try {
            $this->db->WHERE('id_cliente', $idCliente);
            $this->db->WHERE('idLote', $idLote);
            if($this->db->update('clientes', $data)){
                return TRUE;
            }else{
                return FALSE;
            }               
        } catch(Exception $e) {
            return $e->getMessage();
            }    
        }

        public function getNuevoIdComision($idLote, $idCliente, $id_usuario_Asesor){

            $query = $this->db->query("SELECT * from comisiones where id_lote = $idLote and idCliente = $idCliente and id_usuario= $id_usuario_Asesor");
            $result = $query->row_array();
            return $result['id_comision'];
        }

        // public function getTopadas(){
        //     $query= $this->query("SELECT
        //     vc.id_vcompartida,
        //     CASE WHEN COUNT(DISTINCT c.id_asesor) = COUNT(c.id_asesor) THEN MAX(CASE WHEN c.id_asesor = vc.id_asesor THEN NULL ELSE vc.id_asesor END) ELSE NULL END AS Topar_Asesor,
        //     CASE WHEN COUNT(DISTINCT c.id_coordinador) = COUNT(c.id_coordinador) THEN MAX(CASE WHEN c.id_coordinador = vc.id_coordinador THEN NULL ELSE vc.id_coordinador END) ELSE NULL END AS Topar_Coordinador,
        //     CASE WHEN COUNT(DISTINCT c.id_subdirector) = COUNT(c.id_subdirector) THEN MAX(CASE WHEN c.id_subdirector = vc.id_subdirector THEN NULL ELSE vc.id_subdirector END) ELSE NULL END AS Topar_Subdirector,
        //     CASE WHEN COUNT(DISTINCT c.id_regional) = COUNT(c.id_regional) THEN MAX(CASE WHEN c.id_regional = vc.id_regional THEN NULL ELSE vc.id_regional END) ELSE NULL END AS Topar_Regional,
        //     CASE WHEN COUNT(DISTINCT c.id_regional_2) = COUNT(c.id_regional_2) THEN MAX(CASE WHEN c.id_regional_2 = vc.id_regional_2 THEN NULL ELSE vc.id_regional_2 END) ELSE NULL END AS Topar_id_regional2
        //     FROM clientes c
        //     LEFT JOIN ventas_compartidas vc ON c.id_cliente = vc.id_cliente
        //     WHERE c.id_cliente = 77798
        //     GROUP BY vc.id_vcompartida, vc.id_cliente, vc.id_asesor, vc.id_coordinador;")
        //     return $query->result_array();

        // }

        public function updateEstatusCompartidas($id_vcompartida,$estatus){
            return $this->db->query("UPDATE ventas_compartidas SET estatus = $estatus WHERE id_vcompartida = $id_vcompartida;");
        }

        public function getComisionistas($idLote){

            $query = $this->db->query("(SELECT lo.idLote,cl.id_cliente,NULL id_vcompartida,
            cl.id_asesor,cl.id_coordinador,cl.id_gerente,cl.id_subdirector,cl.id_sede,
            (CASE WHEN (cl.id_regional   IS NULL OR cl.id_regional   = 0) THEN 0 ELSE cl.id_regional_2 END) id_regional,
            (CASE WHEN (cl.id_regional_2 IS NULL OR cl.id_regional_2 = 0) THEN 0 ELSE cl.id_regional_2 END) id_regional_2,
            CONCAT(ase.nombre, ' ', ase.apellido_paterno, ' ', ase.apellido_materno) AS asesor,
            CONCAT(coor.nombre, ' ', coor.apellido_paterno, ' ', coor.apellido_materno) AS coordinador,
            CONCAT(ger.nombre, ' ', ger.apellido_paterno, ' ', ger.apellido_materno) AS gerente,
            CONCAT(sub.nombre, ' ', sub.apellido_paterno, ' ', sub.apellido_materno) AS subdirector,
            (CASE WHEN (cl.id_regional IS NULL OR cl.id_regional = 0) THEN 'NO APLICA' ELSE CONCAT(reg.nombre, ' ', reg.apellido_paterno, ' ', reg.apellido_materno) END)  regional,
            (CASE WHEN (cl.id_regional_2 IS NULL OR cl.id_regional_2 = 0) THEN 'NO APLICA' ELSE (CONCAT(reg2.nombre, ' ', reg2.apellido_paterno, ' ', reg2.apellido_materno)) END) regional2

            FROM lotes lo
            INNER JOIN clientes cl on cl.id_cliente=lo.idCliente
            LEFT JOIN usuarios ase ON ase.id_usuario = cl.id_asesor
            LEFT JOIN usuarios coor ON coor.id_usuario = cl.id_coordinador
            LEFT JOIN usuarios ger ON ger.id_usuario = cl.id_gerente
            LEFT JOIN usuarios sub ON sub.id_usuario = cl.id_subdirector
            LEFT JOIN usuarios reg ON reg.id_usuario = cl.id_regional
            LEFT JOIN usuarios reg2 ON reg2.id_usuario = cl.id_regional_2
            WHERE lo.idLote=$idLote)
            UNION 
            (SELECT lo.idLote,vc.id_cliente,vc.id_vcompartida,
            vc.id_asesor,vc.id_coordinador,vc.id_gerente,vc.id_subdirector,vc.id_sede,
            (CASE WHEN (vc.id_regional   IS NULL OR vc.id_regional   = 0) THEN 0 ELSE vc.id_regional_2 END) id_regional,
            (CASE WHEN (vc.id_regional_2 IS NULL OR vc.id_regional_2 = 0) THEN 0 ELSE vc.id_regional_2 END) id_regional_2,

            CONCAT(vcAse.nombre, ' ', vcAse.apellido_paterno, ' ', vcAse.apellido_materno) AS asesor,
            CONCAT(vcCoor.nombre, ' ', vcCoor.apellido_paterno, ' ', vcCoor.apellido_materno) AS coordinador,
            CONCAT(vcGer.nombre, ' ', vcGer.apellido_paterno, ' ', vcGer.apellido_materno) AS gerente,
            CONCAT(vcSub.nombre, ' ', vcSub.apellido_paterno, ' ', vcSub.apellido_materno) AS subdirector,
            (CASE WHEN (cl.id_regional IS NULL OR cl.id_regional = 0) THEN 'NO APLICA' ELSE CONCAT(vcReg.nombre, ' ', vcReg.apellido_paterno, ' ', vcReg.apellido_materno) END)  regional,
            (CASE WHEN (cl.id_regional_2 IS NULL OR cl.id_regional_2 = 0) THEN 'NO APLICA' ELSE (CONCAT(vcReg2.nombre, ' ', vcReg2.apellido_paterno, ' ', vcReg2.apellido_materno)) END) regional2
            FROM lotes lo
            INNER JOIN clientes cl on cl.id_cliente=lo.idCliente
            INNER JOIN ventas_compartidas vc ON vc.id_cliente=cl.id_cliente AND vc.estatus=1
            LEFT JOIN usuarios vcAse ON vcAse.id_usuario = vc.id_asesor
            LEFT JOIN usuarios vcCoor ON vcCoor.id_usuario = vc.id_coordinador
            LEFT JOIN usuarios vcGer ON vcGer.id_usuario = vc.id_gerente
            LEFT JOIN usuarios vcSub ON vcSub.id_usuario = vc.id_subdirector
            LEFT JOIN usuarios vcReg ON vcReg.id_usuario = vc.id_regional
            LEFT JOIN usuarios vcReg2 ON vcReg2.id_usuario = vc.id_regional_2
            WHERE lo.idLote=$idLote)");
            return $query->result_array();
        }

        public function getAllCompartidas($id_cliente){

            $query = $this->db->query("SELECT
            vc.id_vcompartida, vc.estatus as estatusCompartida,vc.id_cliente, id_asesor, lo.idLote,
            CONCAT(asesor.nombre, ' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) AS asesor,
            id_coordinador,
            CONCAT(coordinador.nombre, ' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) AS coordinador,
            id_gerente,
            CONCAT(gerente.nombre, ' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) AS gerente,
            id_subdirector,
            CONCAT(subdirector.nombre, ' ', subdirector.apellido_paterno, ' ', subdirector.apellido_materno) AS subdirector,
            id_regional,
            CONCAT(CASE WHEN regional.nombre IS NULL THEN 'no disponible' ELSE regional.nombre END, ' ', regional.apellido_paterno, ' ', regional.apellido_materno) AS regional,
            CASE WHEN id_regional_2 IS NULL THEN 'no disponible' ELSE CAST(id_regional_2 AS CHAR) END as id_regional_2,
            CONCAT(CASE WHEN regional_2.nombre IS NULL THEN 'no disponible' ELSE regional_2.nombre END, ' ', regional_2.apellido_paterno, ' ', regional_2.apellido_materno) AS regional_2
            FROM ventas_compartidas vc
            INNER JOIN usuarios asesor ON vc.id_asesor = asesor.id_usuario
            INNER JOIN usuarios coordinador ON vc.id_coordinador = coordinador.id_usuario
            INNER JOIN usuarios gerente ON vc.id_gerente = gerente.id_usuario
            INNER JOIN usuarios subdirector ON vc.id_subdirector = subdirector.id_usuario
            LEFT JOIN usuarios regional ON vc.id_regional = regional.id_usuario
            LEFT JOIN usuarios regional_2 ON vc.id_regional_2 = regional_2.id_usuario
            INNER JOIN lotes lo ON vc.id_cliente = lo.idCliente
            WHERE id_cliente = $id_cliente;");
            return $query->result_array();
        }

        // public function ToparComision($id_comision,$comentario=''){  
        //     date_default_timezone_set('America/Mexico_City');
        //     $hoy = date('Y-m-d H:i:s');     
        //     $complemento = '';
        //     if($comentario != ''){
        //         $complemento = ",observaciones='".$comentario."'";
        //     }
        //     $sumaxcomision=0;
        //     $pagos = $this->db->query("SELECT pci.id_usuario,pci.id_pago_i,pci.abono_neodata,CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario,cat.nombre,pci.comentario
        //     FROM pago_comision_ind pci INNER JOIN usuarios u ON u.id_usuario=pci.id_usuario 
        //     INNER JOIN opcs_x_cats cat ON cat.id_opcion=pci.estatus
        //     WHERE pci.id_comision=$id_comision AND pci.estatus in(1,6) AND cat.id_catalogo=23")->result_array();
        //     $pagos_ind = $this->db->query("SELECT SUM(abono_neodata) AS suma FROM pago_comision_ind WHERE id_comision=".$id_comision." AND estatus not in(1,6,5)")->result_array();
        //     $sumaxcomision = $pagos_ind[0]['suma'];
            
        //     for ($j=0; $j <count($pagos) ; $j++) { 
        //         $comentario= 'Se eliminó el pago';
        //         $pagos =  $this->db->query("UPDATE pago_comision_ind SET estatus=0,abono_neodata=0,modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i=".$pagos[$j]['id_pago_i']." AND id_usuario=".$pagos[$j]['id_usuario'].";");
        //         $pagos = $this->db->query("INSERT INTO  historial_comisiones VALUES (".$pagos[$j]['id_pago_i'].", ".$this->session->userdata('id_usuario').", GETDATE(), 1, '".$comentario."')");
        //     }
        //         $pagos = $this->db->query("INSERT INTO  historial_log VALUES ($id_comision,".$this->session->userdata('id_usuario').",'".$hoy."',1,'SE TOPO COMISIÓN','comisiones',NULL)");
    
        //         if($sumaxcomision == 0  || $sumaxcomision == null || $sumaxcomision == 'null' ){
        //             $this->db->query("UPDATE comisiones set comision_total=0,descuento=1,modificado_por='".$this->session->userdata('id_usuario')."' $complemento WHERE id_comision=".$id_comision." ");
        //         }else{
        //             $this->db->query("UPDATE comisiones set comision_total=$sumaxcomision,descuento=1,modificado_por='".$this->session->userdata('id_usuario')."' $complemento WHERE id_comision=".$id_comision." ");
    
        //         }
        //         return $pagos;
        // }

        public function updateEstatusVentasC($id_vcompartida,$id_usuario)
        {
            $query = $this->db->query("UPDATE ventas_compartidas SET estatus=0,modificado_por=$id_usuario where id_vcompartida = $id_vcompartida");
            return $query;
        }

        public function updateEstatus8($infoLotes, $infoClientes, $estatusComisiones, $data, $descripcionCambio) {
        
            return $this->db->query("UPDATE comisiones
                SET estatus = $estatusComisiones, modificado_por = $data, observaciones='$descripcionCambio', descuento = 1
                WHERE id_lote = $infoLotes
                    AND EXISTS (
                        SELECT *
                        FROM ventas_compartidas vc
                        JOIN clientes cl ON vc.id_cliente = cl.id_cliente
                        WHERE vc.id_cliente = $infoClientes AND cl.id_cliente IN (SELECT idCliente FROM lotes WHERE idLote = $infoLotes) AND vc.id_asesor = comisiones.id_usuario);");
        }
        

        public function updateComisiones($data, $idComision) {
            $this->db->where('id_comision', $idComision);
            $response = $this->db->update('comisiones', $data);
        
            if ($response) {
                return true;
            } else {
                return false;
            }
        }

        public function getMensualidades() {
            return $this->db->query("SELECT id_catalogo, id_opcion, UPPER(nombre) nombre FROM opcs_x_cats WHERE id_catalogo IN (126) AND estatus = 1");
        }

        public function updateMensualidades($mensualidad, $idCliente, $idLote, $idUsuarioM) {
            $query = $this->db->query("UPDATE mensualidad_cliente SET opcion=$mensualidad, modificado_por=$idUsuarioM, fecha_modificacion=GETDATE() WHERE id_cliente = $idCliente  AND id_lote= $idLote");
            
            if ($query) {
                return 1;
            } else {
                return 0;
            }

        }


        //----------------------Cambio de plan de comision----------------------//

        public function getPlanComision(){
            $planComision= $this->db->query("SELECT id_plan, descripcion FROM plan_comision");
            return $planComision->result_array();
        }

        public function updatePlanComision($planComision, $idCliente ,$idUsuarioM){
            $plan = $this->db->query("UPDATE clientes SET  modificado_por=$idUsuarioM, plan_comision=$planComision, fecha_modificacion=GETDATE() WHERE  id_cliente=$idCliente");

            if($plan){
            return 1;
             }else{
            return 0;
            }
        }

        public function AddEmpresa($idLote,$comision,$idCliente){

            $comisionesEmpresa = $this->db-> query("SELECT * FROM comisiones WHERE id_lote=$idLote AND id_usuario=4824 AND estatus=1")->result_array();
            $comisiones = $this->db-> query("SELECT * FROM comisiones WHERE id_lote=$idLote AND estatus=1")->result_array();

            $respuesta=false;
            if(count($comisionesEmpresa) == 0 && count($comisiones) > 0){
                $respuesta=    $this->db->query("INSERT INTO comisiones
                ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [ooam], [loteReubicado], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado],[idCliente]) VALUES (".$idLote.",4824,".$comision.", 1, 'SE AGREGÓ EMPRESA', NULL, NULL, ".$this->session->userdata('id_usuario').", GETDATE(),1, GETDATE(), 45,$idCliente)");
                
                if($respuesta){
                    return 1;
            }else{
                    return 0;
            }
             }else{
                return 2;
             }    
        }
    }

 
