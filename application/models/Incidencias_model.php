<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Incidencias_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
 
    public function getInCommissions($idlote)
    {
        $query = $this->db-> query("SELECT DISTINCT(l.idLote), res.nombreResidencial, cond.nombre as nombreCondominio, l.nombreLote,  
        CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) nombre_cliente, l.tipo_venta, 
        vc.id_cliente AS compartida, l.idStatusContratacion, l.totalNeto2, pc.fecha_modificacion, 
        convert(nvarchar, pc.ultima_dispersion, 6) ultima_dispersion,
        convert(nvarchar, pc.fecha_modificacion, 6) fecha_sistema, 
        convert(nvarchar, pc.fecha_neodata, 6) fecha_neodata, 
        convert(nvarchar, cl.fechaApartado, 6) fechaApartado, se.nombre as sede,
        l.registro_comision, l.referencia, cl.id_cliente,            
        (CASE WHEN cl.plan_comision IN (0) OR cl.plan_comision IS NULL THEN '-' ELSE pl.descripcion END) AS plan_descripcion, cl.plan_comision,cl.id_subdirector, cl.id_sede, cl.id_prospecto, cl.lugar_prospeccion 
        FROM lotes l
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
        INNER JOIN usuarios ae ON ae.id_usuario = cl.id_asesor
        LEFT JOIN pago_comision pc ON pc.id_lote = l.idLote
        LEFT JOIN (SELECT id_cliente FROM ventas_compartidas WHERE estatus = 1) AS vc ON vc.id_cliente = cl.id_cliente
        LEFT JOIN usuarios co ON co.id_usuario = cl.id_coordinador
        LEFT JOIN usuarios ge ON ge.id_usuario = cl.id_gerente
        LEFT JOIN usuarios su ON su.id_usuario = cl.id_subdirector
        LEFT JOIN usuarios re ON re.id_usuario = cl.id_regional
        LEFT JOIN usuarios di ON di.id_usuario = 2
        LEFT JOIN plan_comision pl ON pl.id_plan = cl.plan_comision
        LEFT JOIN sedes se ON se.id_sede = cl.id_sede 
        LEFT JOIN (SELECT idLote, idCliente, MAX(modificado) modificado, idStatusContratacion, idMovimiento FROM historial_lotes WHERE idStatusContratacion = 9 AND idMovimiento = 39 
        GROUP BY idLote, idCliente, idStatusContratacion, idMovimiento) hl 
        ON hl.idLote = l.idLote AND hl.idCliente = l.idCliente
        WHERE l.idStatusContratacion BETWEEN 9 AND 15 AND l.idLote = $idlote");
        return $query->result();

    }


    function getUsuariosRol3($rol){

        $cmd = "SELECT id_usuario,CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) as name_user,id_lider FROM 
                usuarios WHERE estatus in (0,1,3) /*and forma_pago != 2*/ AND id_rol=$rol";

        return $this->db->query($cmd);
    }

    public function getAsesoresBaja(){
        // $query =  $this->db->query("
        // SELECT us.id_usuario, CONCAT(us.nombre, ' ',us.apellido_paterno, ' ',us.apellido_materno) AS nombre 
        // FROM usuarios us inner join comisiones com on com.id_usuario=us.id_usuario inner join pago_comision pc on pc.id_lote=com.id_lote  WHERE pc.bandera=0 and us.id_rol in (7) AND us.estatus=0 AND us.rfc NOT LIKE '%TSTDD%' AND us.correo NOT LIKE '%test_%'
        // group by us.id_usuario, CONCAT(us.nombre, ' ',us.apellido_paterno, ' ',us.apellido_materno)");
    
         $query =  $this->db->query("SELECT us.id_usuario, CONCAT(us.nombre, ' ',us.apellido_paterno, ' ',us.apellido_materno) AS nombre 
          FROM usuarios us 
          inner join comisiones com on com.id_usuario=us.id_usuario 
          WHERE us.id_rol in (7) AND us.estatus=0 
          AND us.rfc NOT LIKE '%TSTDD%' AND us.correo NOT LIKE '%test_%' 
          group by us.id_usuario, CONCAT(us.nombre, ' ',us.apellido_paterno, ' ',us.apellido_materno)");
        return $query->result();
    
    }
    function getUsuariosByrol($rol,$user){
        if($rol == 7 || $rol == 9){
          $list_rol = '7,9';
        }else{
           $list_rol =  $rol;
        }
      
          return $this->db->query("SELECT id_usuario,CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) as name_user FROM usuarios WHERE estatus in (1,3) AND id_rol in ($list_rol) and id_usuario not in($user) ");
         }
 
                
        public function GuardarPago($id_comision, $comentario_topa, $monotAdd){    
                    
            $sumaxcomision=0;

            $pagos = $this->db->query("SELECT id_usuario FROM comisiones com WHERE id_comision = $id_comision");
            $user = $pagos->row()->id_usuario;
            
                $respuesta =  $this->db->query("INSERT INTO pago_comision_ind VALUES ($id_comision, $user, $monotAdd , GETDATE(), GETDATE(), 0, 11, ".$this->session->userdata('id_usuario').", 'IMPORTACION EXTEMPORANEA', NULL, NULL, NULL,'".$this->session->userdata('id_usuario')."' )");
                $insert_id = $this->db->insert_id();
            $this->db->query("INSERT INTO historial_comisiones VALUES (".$insert_id.", ".$this->session->userdata('id_usuario').", GETDATE(), 1, '".$comentario_topa."')");


                if($respuesta){
                        return 1;
                }else{
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
            $respuesta =  $this->db->query("UPDATE comisiones set comision_total=$comision_total,observaciones='SE MODIFICÓ PORCENTAJE',creado_por=".$this->session->userdata('id_usuario').",porcentaje_decimal=$porcentaje $q WHERE id_comision=$id_comision AND id_lote=$id_lote and id_usuario=$id_usuario");

       //  $respuesta =  $this->db->query("UPDATE comisiones set comision_total=$comision_total,porcentaje_decimal=$porcentaje,modificado_por='".$this->session->userdata('id_usuario')."' $q WHERE id_comision=$id_comision AND id_lote=$id_lote and id_usuario=$id_usuario");
         //$respuesta =  $this->db->query("UPDATE pago_comision_ind set estatus=5,modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_comision=$id_comision AND estatus in(1,6,3) and id_usuario=$usuario");
        if($opc == ''){
            $Abonado = $this->db-> query("SELECT SUM(pci.abono_neodata) abonado FROM pago_comision_ind pci WHERE pci.id_comision IN  ($id_comision)")->result_array();
            $pagos = $this->db-> query("SELECT * FROM pago_comision_ind WHERE id_comision=$id_comision and estatus in(1,6) and id_usuario=$id_usuario;")->result_array();

            if($porcentaje <= $porcentaje_ant ){
               
                for ($i=0; $i <count($pagos) ; $i++) { 
                    $comentario2='Se cancelo el pago por cambio de porcentaje';
                    $respuesta =  $this->db->query("UPDATE pago_comision_ind SET abono_neodata=0,estatus=0,modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i=".$pagos[$i]['id_pago_i']." AND id_usuario=".$id_usuario.";");
                    $respuesta = $this->db->query("INSERT INTO  historial_comisiones VALUES (".$pagos[$i]['id_pago_i'].", ".$this->session->userdata('id_usuario').", GETDATE(), 1, '".$comentario2."')");
                }  
            }
        }
        $respuesta = $this->db->query("INSERT INTO  historial_log VALUES ($id_comision,".$this->session->userdata('id_usuario').",'".$hoy."',1,'SE CAMBIO PORCENTAJE','comisiones',NULL)");
        //$this->Comisiones_model->RecalcularMontos($id_lote);
         return $respuesta;
        }



        public function CederComisiones($usuarioold,$newUser,$rol){
            ini_set('max_execution_time', 0);
            $comisiones =  $this->db->query("select com.id_comision,com.id_lote,com.id_usuario,l.totalNeto2,l.nombreLote,com.comision_total,com.porcentaje_decimal 
            from comisiones com 
            inner join lotes l on l.idLote=com.id_lote 
            where com.id_usuario=".$usuarioold."")->result_array();
        $infoCedida = array();
        $respuesta=true;
        $cc=0;
            $datosCreacionCorreo = array();
            for ($i=0; $i <count($comisiones) ; $i++) { 
                $sumaxcomision=0;
                $Restante=0;
                    $pagosElimnar = $this->db->query("SELECT pci.id_usuario,pci.id_pago_i,pci.abono_neodata,
                                                      CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario,pci.comentario
                    FROM pago_comision_ind pci INNER JOIN usuarios u ON u.id_usuario=pci.id_usuario 
                     WHERE pci.id_comision=".$comisiones[$i]['id_comision']." AND pci.estatus in(1,6)")->result_array();
        
                    $SumaTopar = $this->db->query(" SELECT SUM(abono_neodata) as suma 
                                                    FROM pago_comision_ind 
                                                    WHERE id_comision=".$comisiones[$i]['id_comision']." AND estatus NOT IN(1,6)")->result_array();
        
                    if( $SumaTopar[0]['suma'] == 'NULL' ||  $SumaTopar[0]['suma'] == null ||  $SumaTopar[0]['suma'] == 0 || $SumaTopar[0]['suma'] == '' ){
                        $sumaxcomision = 0;
                    }else{
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
                        $this->db->query("UPDATE comisiones set comision_total=$sumaxcomision,descuento=$newUser,modificado_por='".$this->session->userdata('id_usuario')."' where id_comision=".$comisiones[$i]['id_comision']." ");
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
            $datosUsuarioOld = $this->db->query("SELECT CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre,o.nombre as rol FROM usuarios u inner join opcs_x_cats o on o.id_opcion=u.id_rol WHERE u.id_usuario=".$usuarioold." and o.id_catalogo=1")->result_array();
            $datosUsuarioNew = $this->db->query("SELECT CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre,o.nombre as rol FROM usuarios u inner join opcs_x_cats o on o.id_opcion=u.id_rol WHERE u.id_usuario=".$newUser." and o.id_catalogo=1")->result_array();
        //echo var_dump($datosUsuarioOld);
        //echo var_dump($datosUsuarioNew);
            //echo var_dump($infoCedida);
        //echo $infoCedida[0]['id_lote'];
            $mail = $this->phpmailer_lib->load();
        
         // SMTP configuration
        //  $mail->isSMTP();
        //  $mail->Host     = 'smtp.gmail.com';
        //  $mail->SMTPAuth = true;
        //  $mail->Username = 'noreply@ciudadmaderas.com';
        //  $mail->Password = 'Marzo2019@';
        //  $mail->SMTPSecure = 'ssl';
        //  $mail->Port     = 465;
        
        
          $mail->setFrom('noreply@ciudadmaderas.com', 'Ciudad Maderas');
          $mail->AddAddress('programador.analista21@ciudadmaderas.com');
          
         $mail->Subject = utf8_decode('COMISIONES CEDIDAS');
         // Set email format to HTML
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
                             <th style='text-align:left; width:30%;'>
                             
                             </th>
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
                           
        
        $mailContent .= utf8_decode("</table>
           </center>
        
           </td></tr>
         </table>
        
         </body></html>");
        
           $mail->Body = $mailContent;
           $mail->send();
        
        $respuesta = true ;
            /**--------------------------------------------------------------- */
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

        // una sola consulta se modifico una sola consulta porque era muy complicado el mantenimiento y codigo extra
        // if($banderaSubRegional != false){
        //     $cmdRol = 'SET id_subdirector =  '.$newColab.'  id_regional = 0 ' ; 
        // }
        if($banderaSubRegional != false){

        }


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
        $respuesta = $this->db->query("INSERT INTO historial_log VALUES (".$idCliente.", ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'MOTIVO ACTUALIZACIÓN: ".$comentario."', 'ventas_compartidas',NULL)");
        
        $cmdComision =  "SELECT id_comision,comision_total,rol_generado from comisiones where id_usuario=$usuarioOld and id_lote=$idLote;";   
  
        $comision = $this->db->query($cmdComision)->result_array();
         if(count($comision) > 0){
        
        $sumaxcomision=0;
                    $cmdPagos = "SELECT pci.id_usuario,pci.id_pago_i,pci.abono_neodata,
                                CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario,
                                cat.nombre,pci.comentario
                                FROM pago_comision_ind pci 
                                INNER JOIN usuarios u ON u.id_usuario=pci.id_usuario 
                                INNER JOIN opcs_x_cats cat ON cat.id_opcion=pci.estatus
                                WHERE pci.id_comision=".$comision[0]['id_comision']." AND pci.estatus in(1,6) 
                                AND cat.id_catalogo=23";

                    $pagos = $this->db->query($cmdPagos)->result_array();

                    $cmdPagosInd = "SELECT SUM(abono_neodata) as suma FROM pago_comision_ind WHERE id_comision=".$comision[0]['id_comision']." and estatus not in(1,6)";
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
                        //$this->db->query("delete from comisiones where id_comision=".$comision[0]['id_comision']." and id_usuario=".$usuarioOld." ");
                        //si la suma de sis pagos pagados es igual a 0 solo cambiar el usuario                  
                    }
                    $respuesta =   $this->db->query("UPDATE comisiones set comision_total=$sumaxcomision,descuento=1,modificado_por='".$this->session->userdata('id_usuario')."' where id_comision=".$comision[0]['id_comision']." ");
                }
                    $validate = $this->db->query("SELECT id_usuario FROM comisiones WHERE id_lote IN (SELECT idLote FROM lotes WHERE idCliente = $idCliente) AND id_usuario = $newColab");
                    $data_lote = $this->db->query("SELECT idLote, totalNeto2 FROM lotes WHERE idCliente = $idCliente");
                    $count_com = $this->db->query("SELECT COUNT(id_usuario) val_total FROM comisiones WHERE id_lote IN (SELECT idLote FROM lotes WHERE idCliente = $idCliente) AND rol_generado = $rolSelect and descuento=0");
        
                    $var_lote = $data_lote->row()->idLote;
                    $precio_lote = $data_lote->row()->totalNeto2;
        
                $por=0;

                if($rolSelect == 7){
                    
                    //ASESOR
                    if($count_com->row()->val_total == 0){
                        $por=3;
                    }
                    elseif($count_com->row()->val_total == 1){
                        $por=1.5;
                    }else if($count_com->row()->val_total == 2){
                        $por=1;
                    }elseif($count_com->row()->val_total == 3){
                        $por=1;
                    }
        
                }else if($rolSelect == 9){
                    //COORDINADOR
                    if($count_com->row()->val_total == 0){
                        $por=1;
                    }
                    elseif($count_com->row()->val_total == 1){
                        $por=0.5;
                    }else if($count_com->row()->val_total == 2){
                        $por=0.33333;
                    }elseif($count_com->row()->val_total == 3){
                        $por=0.33333;
                    }
                }elseif($rolSelect == 3){
                    //GERENTE
                    if($count_com->row()->val_total == 0){
                        $por=1;
                    }
                    elseif($count_com->row()->val_total == 1){
                        $por=0.5;
                    }else if($count_com->row()->val_total == 2){
                        $por=0.33333;
                    }elseif($count_com->row()->val_total == 3){
                        $por=0.33333;
                    }
                }else if ($rolSelect == 2){
                    if($count_com->row()->val_total == 0){
                        $por=1;
                    }
                    elseif($count_com->row()->val_total == 1){
                        $por=0.5;
                    }else if($count_com->row()->val_total == 2){
                        $por=0.33333;
                    }elseif($count_com->row()->val_total == 3){
                        $por=0.33333;
                    }
                }else if ($rolSelect == 59){
                    if($count_com->row()->val_total == 0){
                        $por=1;
                    }
                    elseif($count_com->row()->val_total == 1){
                        $por=0.5;
                    }else if($count_com->row()->val_total == 2){
                        $por=0.33333;
                    }elseif($count_com->row()->val_total == 3){
                        $por=0.33333;
                    }
                }
                
                $comision_total=$precio_lote * ($por /100);
        
                if(empty($validate->row()->id_usuario)){
                $response = $this->db->query("INSERT INTO comisiones VALUES (".$idLote.",$newColab,$comision_total,1,'SE MODIFICÓ INVENTARIO',NULL,NULL,1,GETDATE(),$por,GETDATE(),$rolSelect,0,NULL,'".$this->session->userdata('id_usuario')."')");
                if($response){
                    return 1;
                }else{
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
                    $this->db->query("UPDATE ventas_compartidas set id_asesor=$newColab where id_cliente=$idCliente and estatus=1;");
                }else if($rolSelect == 9){
                    $this->db->query("UPDATE ventas_compartidas set id_coordinador=$newColab where id_cliente=$idCliente and estatus=1;");
                }else if($rolSelect == 3){
                    $this->db->query("UPDATE ventas_compartidas set id_gerente=$newColab where id_cliente=$idCliente and estatus=1;");
                }
                $respuesta = $this->db->query("INSERT INTO historial_log VALUES (".$idCliente.", ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'MOTIVO ACTUALIZACIÓN: ".$comentario."', 'ventas_compartidas',NULL)");
        
            }
          
            
            if($usuarioOld != 0 && $usuarioOld != '' && $usuarioOld != null && $usuarioOld != 'null'){
        
            
            $comision = $this->db->query("SELECT id_comision,comision_total,rol_generado from comisiones where id_usuario=$usuarioOld and id_lote=$idLote;")->result_array();
             if(count($comision) > 0){
            
            $sumaxcomision=0;
                        $pagos = $this->db->query("SELECT pci.id_usuario,pci.id_pago_i,pci.abono_neodata,CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario,cat.nombre,pci.comentario
                        FROM pago_comision_ind pci INNER JOIN usuarios u ON u.id_usuario=pci.id_usuario 
                        INNER JOIN opcs_x_cats cat ON cat.id_opcion=pci.estatus
                         WHERE pci.id_comision=".$comision[0]['id_comision']." AND pci.estatus in(1,6) AND cat.id_catalogo=23")->result_array();
                        $pagos_ind = $this->db->query("select SUM(abono_neodata) as suma from pago_comision_ind where id_comision=".$comision[0]['id_comision']." and estatus not in(1,6)")->result_array();
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
                            //$this->db->query("delete from comisiones where id_comision=".$comision[0]['id_comision']." and id_usuario=".$usuarioOld." ");
                            //si la suma de sis pagos pagados es igual a 0 solo cambiar el usuario
                            $respuesta = $this->db->query("UPDATE comisiones set comision_total=$sumaxcomision,descuento=1,modificado_por='".$this->session->userdata('id_usuario')."' where id_comision=".$comision[0]['id_comision']." ");
            
                        }else{
                            $respuesta = $this->db->query("UPDATE comisiones set comision_total=$sumaxcomision,descuento=1,modificado_por='".$this->session->userdata('id_usuario')."' where id_comision=".$comision[0]['id_comision']." ");
                        }  
            
                    }
        
                }
                        $validate = $this->db->query("SELECT id_usuario FROM comisiones WHERE id_lote IN (SELECT idLote FROM lotes WHERE idCliente = $idCliente) AND id_usuario = $newColab");
                        $data_lote = $this->db->query("SELECT idLote, totalNeto2 FROM lotes WHERE idCliente = $idCliente");
                        $count_com = $this->db->query("SELECT COUNT(id_usuario) val_total FROM comisiones WHERE id_lote IN (SELECT idLote FROM lotes WHERE idCliente = $idCliente) AND rol_generado = $rolSelect and descuento=0");
            
                        $var_lote = $data_lote->row()->idLote;
                    $precio_lote = $data_lote->row()->totalNeto2;
            
                    $por=0;
                    if($rolSelect == 7){
                        //ASESOR
                        if($count_com->row()->val_total == 0){
                            $por=3;
                        }
                        elseif($count_com->row()->val_total == 1){
                            $por=1.5;
                        }else if($count_com->row()->val_total == 2){
                            $por=1;
                        }elseif($count_com->row()->val_total == 3){
                            $por=1;
                        }
            
                    }else if($rolSelect == 9){
                        //COORDINADOR
                        if($count_com->row()->val_total == 0){
                            $por=1;
                        }
                        elseif($count_com->row()->val_total == 1){
                            $por=0.5;
                        }else if($count_com->row()->val_total == 2){
                            $por=0.33333;
                        }elseif($count_com->row()->val_total == 3){
                            $por=0.33333;
                        }
                    }elseif($rolSelect == 3){
                        //GERENTE
                        if($count_com->row()->val_total == 0){
                            $por=1;
                        }
                        elseif($count_com->row()->val_total == 1){
                            $por=0.5;
                        }else if($count_com->row()->val_total == 2){
                            $por=0.33333;
                        }elseif($count_com->row()->val_total == 3){
                            $por=0.33333;
                        }
                    }
                    $comision_total=$precio_lote * ($por /100);
            
                    if(empty($validate->row()->id_usuario)){
                    $response = $this->db->query("INSERT INTO comisiones VALUES (".$idLote.",$newColab,$comision_total,1,'SE MODIFICÓ VENTA COMPARTIDA',NULL,NULL,1,GETDATE(),$por,GETDATE(),$rolSelect,0,NULL,0)");
                    if($response){
                        return 1;
                    }else{
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

                return  $this->db->query("
                SELECT vc.id_vcompartida,cl.id_cliente,cl.nombre, cl.apellido_paterno, cl.apellido_materno,
                ae.id_usuario as id_asesor, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ', ae.apellido_materno) as asesor,
                co.id_usuario as id_coordinador, CONCAT(co.nombre, ' ', co.apellido_paterno, ' ', co.apellido_materno) as coordinador,
                ge.id_usuario as id_gerente, CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ', ge.apellido_materno) as gerente
                 FROM ventas_compartidas vc
                 INNER JOIN clientes cl ON vc.id_cliente = cl.id_cliente
                 INNER JOIN  usuarios ae ON ae.id_usuario = vc.id_asesor
                            LEFT JOIN  usuarios co ON co.id_usuario = vc.id_coordinador
                            LEFT JOIN  usuarios ge ON ge.id_usuario = vc.id_gerente
                            LEFT JOIN  usuarios su ON su.id_usuario = vc.id_subdirector
                            LEFT JOIN  usuarios di ON di.id_usuario = su.id_lider
                    WHERE cl.id_cliente=$id_cliente AND vc.estatus = 1 AND cl.status = 1
                  ");
              
              }
              public function getUserInventario($id_cliente){
                $cmd = "Select cl.id_cliente,
                ase.id_usuario as id_asesor, 
                CONCAT(ase.nombre, ' ', ase.apellido_paterno, ' ', ase.apellido_materno) as asesor,
                coor.id_usuario as id_coordinador, 
                CONCAT(coor.nombre, ' ', coor.apellido_paterno, ' ', coor.apellido_materno) as coordinador,
                ger.id_usuario as id_gerente, 
                CONCAT(ger.nombre, ' ', ger.apellido_paterno, ' ', ger.apellido_materno) as gerente,
                subd.id_usuario as id_subdirector,
                CONCAT(subd.nombre,' ', subd.apellido_paterno, ' ', subd.apellido_materno) as subdirector,
                regio.id_usuario as id_regional,
                concat (regio.nombre, ' ',regio.apellido_paterno, ' ', regio.apellido_materno) as regional
                from clientes cl 
                inner join usuarios ase on ase.id_usuario=cl.id_asesor 
                inner join usuarios ger on ger.id_usuario=cl.id_gerente 
                LEFT join usuarios coor on coor.id_usuario=cl.id_coordinador  
                inner join usuarios subd on subd.id_usuario=cl.id_subdirector 
                LEFT join usuarios regio on regio.id_usuario=cl.id_regional
                 where cl.id_cliente =$id_cliente";
                return  $this->db->query($cmd);
              }

              public function datosLotesaCeder($id_usuario){
                ini_set('max_execution_time', 0);
                $comisiones =  $this->db->query("select com.id_comision,com.id_lote,com.id_usuario,l.totalNeto2,l.nombreLote,com.comision_total,com.porcentaje_decimal 
                from comisiones com 
                inner join lotes l on l.idLote=com.id_lote 
                where com.id_usuario=".$id_usuario."")->result_array();
            $infoCedida = array();
            $cc=0;
                for ($i=0; $i <count($comisiones) ; $i++) { 
            
                    $sumaxcomision=0;
                    $Restante=0;
            
                        $SumaTopar = $this->db->query("select SUM(abono_neodata) as suma from pago_comision_ind where id_comision=".$comisiones[$i]['id_comision']." and estatus not in(1,6)")->result_array();
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
                $cmd = ("UPDATE lotes set tipo_venta = $tipo WHERE idLote = $idLote");
                $respuesta =  $this->db->query($cmd);
                if($respuesta){
                    return 1;
                }else{
                    return 0;
                }
               }
               function AddVentaCompartida($id_asesor,$coor,$ger,$sub,$id_cliente,$id_lote){
                date_default_timezone_set('America/Mexico_City');       
            $fecha_actual = strtotime(date("d-m-Y H:i:00"));
        
                $response = $this->db->query("insert into ventas_compartidas values($id_cliente,$id_asesor,$coor,$ger,1,GETDATE(),".$this->session->userdata('id_usuario').",$sub, GETDATE(),1,0,0);");
                //$response = $this->db->query("UPDATE pago_comision_ind SET abono_neodata = 0, estatus = 0,modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_comision IN (select id_comision from comisiones where id_lote = $id_lote) AND estatus  = 1");
        
            $usuario = 0;
            $rolSelect=0;
            $porcentaje=0;
            for($i=0;$i<4;$i++){
                if($i== 0){
                    //Asesor
                    $usuario=$id_asesor;
                    $rolSelect =7;
                    $porcentaje=1.5;
        
                }
               else if($i == 1){
                    //Asesor
                    $usuario=$coor;
                    $rolSelect =9;
                    $porcentaje=0.5;
        
                }
                else if($i == 2){
                    //Asesor
                    $usuario=$ger;
                    $rolSelect =3;
                    $porcentaje=0.5;
        
                }
                else if($i == 3){
                    //Asesor
                    $usuario=$sub;
                    $rolSelect =2;
                    $porcentaje=0.5;
        
                }
                $validate = $this->db->query("SELECT id_usuario FROM comisiones WHERE id_lote IN (SELECT idLote FROM lotes WHERE idLote = $id_lote) AND id_usuario = $usuario");
                $data_lote = $this->db->query("SELECT idLote, totalNeto2 FROM lotes WHERE idLote = $id_lote");
                //$count_com = $this->db->query("SELECT COUNT(id_usuario) val_total FROM comisiones WHERE id_lote IN (SELECT idLote FROM lotes WHERE idLote = $id_lote) AND rol_generado = $rolSelect and (descuento=0 or descuento=NULL)");
        
        
                $var_lote = $data_lote->row()->idLote;
                $precio_lote = $data_lote->row()->totalNeto2;
                $comision_total=$precio_lote * ($porcentaje /100);
        
                if(empty($validate->row()->id_usuario)){
                    $response = $this->db->query("UPDATE comisiones set comision_total=$comision_total,porcentaje_decimal=$porcentaje,modificado_por='".$this->session->userdata('id_usuario')."' where id_lote=".$id_lote." and rol_generado=$rolSelect");
                    $response = $this->db->query("INSERT INTO comisiones(id_lote,id_usuario,comision_total,estatus,observaciones,evidencia,factura,creado_por,fecha_creacion,porcentaje_decimal,fecha_autorizacion,rol_generado,descuento,idCliente,modificado_por) 
                    VALUES (".$id_lote.",$usuario,$comision_total,1,'SE AGREGÓ VENTA COMPARTIDA',NULL,NULL,".$this->session->userdata('id_usuario').",GETDATE(),$porcentaje,GETDATE(),$rolSelect,0,$id_cliente,'".$this->session->userdata('id_usuario')."')");
                      
                }
        
            }
        
            if($response){
                return 1;
            }else{
                return 0;
            }  
        
        
        }

         public function getPagosByComision($id_comision){
            $datos =  $this->db-> query("SELECT pci.id_pago_i,pci.abono_neodata,CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario,cat.nombre,pci.comentario
             FROM pago_comision_ind pci INNER JOIN usuarios u ON u.id_usuario=pci.id_usuario 
             INNER JOIN opcs_x_cats cat ON cat.id_opcion=pci.estatus
              WHERE pci.id_comision=$id_comision AND pci.estatus in(1,6) AND cat.id_catalogo=23")->result_array();
            return $datos;
           }

           function getComisionesLoteSelected($idLote){
            return $this->db->query("SELECT * FROM comisiones where id_lote=$idLote");
        }

   public function getDatosAbonadoSuma11($idlote){
        return $this->db->query("SELECT SUM(pci.abono_neodata) abonado, pac.total_comision, c2.abono_pagado, lo.totalNeto2, cl.lugar_prospeccion
        FROM lotes lo
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
        INNER JOIN comisiones c1 ON lo.idLote = c1.id_lote AND c1.estatus = 1
        LEFT JOIN (SELECT SUM(comision_total) abono_pagado, id_comision FROM comisiones WHERE descuento in (1) AND estatus = 1 GROUP BY id_comision) c2 ON c1.id_comision = c2.id_comision
        INNER JOIN pago_comision_ind pci on pci.id_comision = c1.id_comision
        INNER JOIN pago_comision pac ON pac.id_lote = lo.idLote
        WHERE lo.status = 1 AND cl.status = 1 AND c1.estatus = 1 AND lo.idLote in ($idlote)
        GROUP BY lo.idLote, lo.referencia, pac.total_comision, lo.totalNeto2, cl.lugar_prospeccion, c2.abono_pagado");
        }

        public function CambiarPrecioLote($idLote,$precio,$comentario){

            $comisiones = $this->db-> query("SELECT * FROM comisiones WHERE id_lote=$idLote and id_usuario !=0 and estatus not in(8,2)")->result_array();
            if(count($comisiones) == 0){
               $respuesta =  $this->db->query("UPDATE lotes set totalNeto2=".$precio." WHERE idLote=".$idLote.";");
               $respuesta = $this->db->query("INSERT INTO historial_log VALUES($idLote,".$this->session->userdata('id_usuario').",GETDATE(),1,'$comentario','lotes',NULL)");
             
            }else{
                $respuesta =  $this->db->query("UPDATE lotes set totalNeto2=".$precio." WHERE idLote=".$idLote.";");
               $respuesta = $this->db->query("INSERT INTO historial_log VALUES($idLote,".$this->session->userdata('id_usuario').",GETDATE(),1,'$comentario','lotes',NULL)");
                for ($i=0; $i <count($comisiones) ; $i++) { 
                    $comisionTotal =$precio *($comisiones[$i]['porcentaje_decimal']/100);
                    $comentario2='Se actualizó la comision total por cambio de precio del lote de'.$comisiones[$i]['comision_total'].' a '.$comisionTotal;
                    $respuesta =  $this->db->query("UPDATE comisiones SET comision_total=$comisionTotal,modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_comision=".$comisiones[$i]['id_comision']." AND id_lote=".$idLote.";");
                    $respuesta = $this->db->query("INSERT INTO historial_log VALUES(".$comisiones[$i]['id_comision'].",".$this->session->userdata('id_usuario').",GETDATE(),1,'$comentario2','comisiones',NULL)");   
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
            FROM pago_comision_ind pci INNER JOIN usuarios u ON u.id_usuario=pci.id_usuario 
            INNER JOIN opcs_x_cats cat ON cat.id_opcion=pci.estatus
             WHERE pci.id_comision=$id_comision AND pci.estatus in(1,6) AND cat.id_catalogo=23")->result_array();
            $pagos_ind = $this->db->query("select SUM(abono_neodata) as suma from pago_comision_ind where id_comision=".$id_comision." and estatus not in(1,6,5)")->result_array();
            $sumaxcomision = $pagos_ind[0]['suma'];
            for ($j=0; $j <count($pagos) ; $j++) { 
                $comentario= 'Se eliminó el pago';
                $respuesta =  $this->db->query("UPDATE pago_comision_ind SET estatus=0,abono_neodata=0,modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i=".$pagos[$j]['id_pago_i']." AND id_usuario=".$pagos[$j]['id_usuario'].";");
                $respuesta = $this->db->query("INSERT INTO  historial_comisiones VALUES (".$pagos[$j]['id_pago_i'].", ".$this->session->userdata('id_usuario').", GETDATE(), 1, '".$comentario."')");
            
            }
            $respuesta = $this->db->query("INSERT INTO  historial_log VALUES ($id_comision,".$this->session->userdata('id_usuario').",'".$hoy."',1,'SE TOPO COMISIÓN','comisiones',NULL)");

            if($sumaxcomision == 0  || $sumaxcomision == null || $sumaxcomision == 'null' ){
                $this->db->query("UPDATE comisiones set comision_total=0,descuento=1,modificado_por='".$this->session->userdata('id_usuario')."' $complemento where id_comision=".$id_comision." ");

            }else{
                $this->db->query("UPDATE comisiones set comision_total=$sumaxcomision,descuento=1,modificado_por='".$this->session->userdata('id_usuario')."' $complemento where id_comision=".$id_comision." ");

            }
    return $pagos;
        }

        public function tieneRegional ()
        {
            
            $cmd = "SELECT id_usuario FROM usuarios WHERE id_rol = 2";
            $query = $this->db->query($cmd);
            return $query->result_array();
        }
        public function tieneRegional1 ($usuario)
        {
       
            $cmd = "SELECT id_usuario,id_lider,id_rol, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) as name FROM usuarios 
                        WHERE  id_rol = 2 AND id_usuario  in (select id_lider from usuarios where id_usuario = $usuario ) ";
            
            $query = $this->db->query($cmd);
            
            return  $query->result_array()  ;
            
        }


        function getLideres($lider){
            return $this->db->query("select u.id_usuario as id_usuario1,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) as name_user,u2.id_usuario as id_usuario2,CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno) as name_user2,
            u3.id_usuario as id_usuario3,CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno) as name_user3 from usuarios u inner join usuarios u2 on u.id_lider=u2.id_usuario inner join usuarios u3 on u3.id_usuario=u2.id_lider where u.id_usuario=$lider");
        }



        function updateBandera($id_pagoc, $param) {
            // $response = $this->db->update("pago_comision", $data, "id_pagoc = $id_pagoc");
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
                
            return $this->db->query("SELECT com.id_comision, com.id_usuario, lo.totalNeto2, lo.idLote, res.idResidencial, lo.referencia, lo.tipo_venta,
            com.id_lote, lo.nombreLote, com.porcentaje_decimal, CONCAT(us.nombre,' ' ,us.apellido_paterno,' ',us.apellido_materno) colaborador, CASE WHEN $estrucura = 1 THEN oxc2.nombre ELSE oxc.nombre END as rol, com.comision_total, pci.abono_pagado, com.rol_generado,/* pc.porcentaje_saldos, (CASE us.id_usuario WHEN 832 THEN 25  ELSE pc.porcentaje_saldos END) porcentaje_saldos,*/com.descuento
            FROM comisiones com
            LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind 
            GROUP BY id_comision) pci ON pci.id_comision = com.id_comision
            INNER JOIN lotes lo ON lo.idLote = com.id_lote 
            INNER JOIN usuarios us ON us.id_usuario = com.id_usuario
            INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = com.rol_generado AND oxc.id_catalogo = 1
            INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
            INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
            LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = com.rol_generado AND oxc2.id_catalogo = 83
            /*INNER JOIN porcentajes_comisiones pc ON pc.id_rol = com.rol_generado  AND pc.relacion_prospeccion = $rel_final*/
            WHERE com.id_lote = $idlote  AND com.estatus = 1 ORDER BY com.rol_generado asc");
        }

        public  function sedesCambios (){
            $cmd = "SELECT id_sede,nombre,abreviacion FROM sedes WHERE estatus = 1";
            $query = $this->db->query($cmd);
            return $query->result();
        }

        public function updateSedesEdit($idCliente, $idLote, $data){
        try {
                $this->db->where('id_cliente', $idCliente);
                $this->db->where('idLote', $idLote);
                if($this->db->update('clientes', $data))
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

        }