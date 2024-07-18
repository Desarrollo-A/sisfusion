<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;


class ScheduleTasks_Universidad extends CI_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->library(array('session', 'form_validation'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
        $this->load->library('email');
        $this->load->model('Comisiones_model');
        $this->load->model('Universidad_function_model');
    }

    public function index(){
        redirect(base_url());
    }


    function descuentos_universidad(){
        ini_set('max_execution_time', 99999999999);
        set_time_limit(99999999999);
        ini_set('memory_limit','10240M');
        $hoy = date("Y-m-d");
        $arrayCorreo = array();
        $arrayDatosCorreo = array();
        $comentarioA = 'prueba desdes automatización 1';
        /*CONSULTAMOS LOS PRÉSTAMOS*/
        // $data = $this->db->query("SELECT * FROM vista_Descuentos_Universidad order by id_usuario")->result_array();
        $data = $this->db->query("SELECT * FROM vista_saldo_universidad  order by id_usuario")->result_array();
        // vista_saldo_universidad
        $hoy = date("Y-m-d");
        
        for ($contador_de_consulta = 0; $contador_de_consulta <count($data); $contador_de_consulta++){
            // $this->db->trans_begin();
        if($data[$contador_de_consulta]['estatus'] == 2 ){

        }else{
            // if($REVISAR_FECHA == 1)
            // {
    
            // }else{
                
            // }
            if($data[$contador_de_consulta]['saldo_comisiones'] >= $data[$contador_de_consulta]['pago_individual'] ){
                if( 
                (($data[$contador_de_consulta]['estatus'] == 1 || $data[$contador_de_consulta]['banderaReactivado'] == 1) )
                &&  ($data[$contador_de_consulta]['pendiente'] > 1  && $data[$contador_de_consulta]['REVISAR_FECHA'] == 1)
                
                ){

                    $pagado_caja            = ($data[$contador_de_consulta]['pagado_caja'] );
                    $pagos_que_se_llevan    = ($data[$contador_de_consulta]['Diferencia'] - 3 );
                
                    $saldo_comisiones       = $data[$contador_de_consulta]['saldo_comisiones'];
                    $pago_individual        = $data[$contador_de_consulta]['pago_individual'];
                    $id_descuento           = $data[$contador_de_consulta]['id_descuento'];
                    $pendiente              = $data[$contador_de_consulta]['pendiente'];
                    $monto                  = $data[$contador_de_consulta]['monto'];
                    //$pago_individual = $data[$contador_de_consulta]['pago_individual']
                    $usuario_por_CONTADOR = $data[$contador_de_consulta]['id_usuario'];
                    $resultado ;
                    $LotesInvolucrados = "";
                    if ($pagos_que_se_llevan >0 ){
                    }
                    if( ($data[$contador_de_consulta]['ultimo_pago_automatico']) == NULL){
                        // VIENE POR SU PRIMER PAGO,
                        // echo ($data[$contador_de_consulta]['ultimo_pago_automatico']);
                        $viene_por_pagos = 0;
                    }else{
                        // aqui viene por segundo pago
                        $viene_por_pagos = $data[$contador_de_consulta]['ultimo_pago_automatico'];
                    }
                    $datos_de_pagos = $this->Universidad_function_model->getLotesDescuentosUniversidad($data[$contador_de_consulta]['id_usuario'],$data[$contador_de_consulta]['pago_individual']);
                    // echo json_encode($datos_de_pagos);
                    // echo json_encode($datos_de_pagos[0]);
                    $cuantosLotes = count($datos_de_pagos);
                    echo('<br>');  
                    echo json_encode($cuantosLotes);
                    $comentario = 0;
                    echo('<br>'); 
                    for($i=0; $i < ($cuantosLotes) ; $i++) 
                    { 
                        
                        echo json_encode($datos_de_pagos[$i]);
                        echo('<br>');
                        $texto = implode(", ", $datos_de_pagos[$i]);
                        echo json_encode($texto);
                        echo('<br>'); 
                        $formatear = explode(",",$texto);
                        $nameLoteComent = $formatear[3];
                        $LotesInvolucrados =  $LotesInvolucrados." ".$nameLoteComent.",\n";
                        $id = $formatear[3]; 
                        $monto = $formatear[1];
                        $pago_neodata = $formatear[7];
                    
                    }
                    
                    $descuento = $pago_individual;
                    $cuantos = count($datos_de_pagos); 
                    
                    

                    if($cuantos > 1){
                        // 
                        // PRIMER PASO
                        // 
                        $sumaMontos = 0;
                        for($contador_insert=0;  $contador_insert < $cuantos; $contador_insert++ )
                        {
                            // contador_para saber cuantos pagos llemaos
                            if($contador_insert == ($cuantos-1))
                            {
                                // 
                                // 
                                // PRIMER PASO 1.25
                                // 
                                // 
                                $texto = implode(", ", $datos_de_pagos[$contador_insert]);
                                $formatear = explode(",",$texto);
                                $id = $formatear[3];
                                $monto = $formatear[1];
                                $pago_neodata = $formatear[2]; 
                                $montoAinsertar = $descuento - $sumaMontos;
                                $Restante = $monto - $montoAinsertar;
                                
                                if( !is_null($id) || $id != '' )
                                {
                                    $comision  = $this->Universidad_function_model->obtenerID($id);
                                }else{
                                    echo('error');
                                }
                                $comentario = 'prueba desdes automatización 1';
                                echo('<br>'); 
                                // $dat =  $this->Universidad_function_model->update_descuento($id,$montoAinsertar,$comentario, $saldo_comisiones, $this->session->userdata('id_usuario'),$usuario,$id_descuento);
                                // $dat =  $this->Universidad_function_model->insertar_descuento($usuario,$Restante,$comision[0]['id_comision'],$comentario,$this->session->userdata('id_usuario'),$pago_neodata,$id_descuento);
                                
                                echo('<br>');
                                $cmd = "UPDATE descuentos_universidad 
                                SET saldo_comisiones = $saldo_comisiones ,  
                                estatus = 2, 
                                primer_descuento = (CASE WHEN primer_descuento IS NULL THEN GETDATE() ELSE primer_descuento END) ,
                                ultimo_pago_automatico = GETDATE(),
                                pagos_universidad = pagos_universidad - 1 
                                WHERE id_descuento = $id_descuento 
                                AND estatus IN (1, 0)";
                                $cmd_relacion_universidad = "INSERT INTO realcion_universidad_pago  
                                values ( $id_descuento , $id , 1 , 1, GETDATE(), 1 )"; 

                                $this->Universidad_function_model->updateCMD($cmd);
                                echo('cmd 156');
                                echo($cmd);
                                if($montoAinsertar == 0 ){
                                    $cmd_pago_comision_ind="UPDATE pago_comision_ind 
                                    SET estatus = 17, 
                                    descuento_aplicado=1, 
                                    modificado_por= 1, 
                                    fecha_pago_intmex = GETDATE(), 
                                    comentario= $comentarioA
                                    WHERE 
                                    id_pago_i=$id";
                                }else{
                                    $cmd_pago_comision_ind = "UPDATE pago_comision_ind 
                                    SET estatus = 17, 
                                    descuento_aplicado=1, 
                                    modificado_por=1, 
                                    fecha_pago_intmex = GETDATE(), 
                                    abono_neodata = $montoAinsertar, 
                                    comentario='$comentarioA' 
                                    WHERE id_pago_i=$id";
                                    // $respuesta = $this->db->query("INSERT INTO realcion_universidad_pago  values ( $id_descuento , $id_pago_i , 1 , 1, GETDATE(), 1 )"); 
                                } 
                                echo('cmd pago_comision_ind 178');
                                echo($cmd_pago_comision_ind);
                                $this->Universidad_function_model->updateCMD($cmd_pago_comision_ind);
                                // $dat =  $this->Universidad_function_model->update_descuento($id,$montoAinsertar,$comentario, $saldo_comisiones, 1,$data[$contador_de_consulta]['id_usuario'],$id_descuento);
                                $cmd_inserPago ="INSERT INTO pago_comision_ind
                                (id_comision, id_usuario, abono_neodata, fecha_abono, fecha_pago_intmex, pago_neodata, estatus, modificado_por, comentario, descuento_aplicado,abono_final,aply_pago_intmex) 
                                VALUES ($comision->id_comision, $usuario_por_CONTADOR, $Restante, GETDATE(), GETDATE(), $monto, 1, 1, 'DESCUENTO NUEVO PAGO comentario Automatico', 0 ,null, null)";
                                $insert_id = $this->db->insert_id();
                                echo('cmd insertPago 186');
                                echo($cmd_inserPago);
                                $this->Universidad_function_model->updateCMD($cmd_inserPago);

                                $cmd_historial = "INSERT INTO historial_comisiones VALUES ($insert_id, 1, GETDATE(), 1, 'MOTIVO DESCUENTO: $comentarioA')";
                                $this->Universidad_function_model->updateCMD($cmd_historial);
                                
                            }else{
                                // 
                                // 
                                // PRIMER PASO 1.5
                                // 
                                // 
                                echo('<br>'); 
                                $texto = implode(", ", $datos_de_pagos[$contador_insert]);
                                $formatear = explode(",",$texto);
                                $id = $formatear[3];
                                // id_del pago
                                $monto = $formatear[1];
                                
                                $pago_neodata = $formatear[2];
                                $num = $i +1;
                                // inicio
                                
                                
                                $cmd = "UPDATE descuentos_universidad 
                                SET saldo_comisiones = $saldo_comisiones ,  
                                estatus = 2, 
                                primer_descuento = (CASE WHEN primer_descuento IS NULL THEN GETDATE() ELSE primer_descuento END) ,
                                ultimo_pago_automatico = GETDATE(),
                                pagos_universidad = pagos_universidad - 1 
                                WHERE id_descuento = $id_descuento 
                                AND estatus IN (1, 0)";

                                $this->Universidad_function_model->updateCMD($cmd);
                                echo('cmd cmd 221');
                                echo($cmd);
                                $cmd_relacion_universidad = "INSERT INTO realcion_universidad_pago  
                                values ( $id_descuento , $id , 1 , 1, GETDATE(), 1 )"; 
                                    $cmd_pago_comision_ind="UPDATE pago_comision_ind 
                                    SET estatus = 17, 
                                    descuento_aplicado=1, 
                                    modificado_por= 1, 
                                    fecha_pago_intmex = GETDATE(), 
                                    comentario= $comentarioA
                                    WHERE 
                                    id_pago_i=$id";
                                    $cmd_historial = "INSERT INTO historial_comisiones VALUES ($id, 1, GETDATE(), 1, 'MOTIVO DESCUENTO: $comentario')";
                                    $sumaMontos = $sumaMontos + $monto;
                                $this->Universidad_function_model->updateCMD($cmd_relacion_universidad);
                                echo('cmd cmd_relacion_universidad 236');
                                echo($cmd_relacion_universidad);
                                    
                            }
                        }

                    }   else{

                        // 
                        // 
                        // SEGUNDO PASO
                        // 
                        // 
                        $sumaMontos = 0;
                        $texto = implode(", ", $datos_de_pagos[0]);
                        $formatear = explode(",",$texto);
                        $id = $formatear[3];
                        $monto = $formatear[1];
                        // abono neodata.
                        $pago_neodata = $formatear[2];

                        if((!is_null($id) 
                        || $id == ''
                        || $id == ' ')
                        && (!is_null($pago_neodata) 
                        || $pago_neodata == ''
                        || $pago_neodata == ' ')
                        && (!is_null($monto)
                        || $monto == ''
                        || $monto == ' ') ){

                            
                            $montoAinsertar = $descuento - $sumaMontos;
                            $Restante = $monto - $montoAinsertar;
                            if( !is_null($id) || $id != '' )
                            {
                                $comision = $this->Universidad_function_model->obtenerID($id);
                            }else{
                                echo('error');
                            }
                        
                            $cmd = "UPDATE descuentos_universidad 
                            SET saldo_comisiones = $saldo_comisiones ,  
                            estatus = 2, 
                            primer_descuento = (CASE WHEN primer_descuento IS NULL THEN GETDATE() ELSE primer_descuento END) ,
                            ultimo_pago_automatico = GETDATE(),
                            pagos_universidad = pagos_universidad - 1 
                            WHERE id_descuento = $id_descuento 
                            AND estatus IN (1, 0)";
                            
                            $this->Universidad_function_model->updateCMD($cmd);
                            echo('cmd cmd 287');
                            echo($cmd);
                            $cmd_relacion_universidad = "INSERT INTO realcion_universidad_pago  
                            values ( $id_descuento , $id , 1 , 1, GETDATE(), 1 )"; 
                            
                            $this->Universidad_function_model->updateCMD($cmd_relacion_universidad);
                            echo('cmd cmd_relacion_universidad 287');
                            echo($cmd_relacion_universidad);
                            if($montoAinsertar == 0 ){
                                echo('es 0 ');

                                $cmd_pago_comision_ind="UPDATE pago_comision_ind 
                                SET estatus = 17, 
                                descuento_aplicado=1, 
                                modificado_por= 1, 
                                fecha_pago_intmex = GETDATE(), 
                                comentario= $comentarioA
                                WHERE 
                                id_pago_i=$id";
                            }else{
                                echo('es diferente 0');
                                
                                $cmd_pago_comision_ind = "UPDATE pago_comision_ind 
                                SET estatus = 17, 
                                descuento_aplicado=1, 
                                modificado_por= 1, 
                                fecha_pago_intmex = GETDATE(), 
                                abono_neodata = $montoAinsertar, 
                                comentario='$comentarioA' 
                                WHERE id_pago_i=$id";
                                // $respuesta = $this->db->query("INSERT INTO realcion_universidad_pago  values ( $id_descuento , $id_pago_i , 1 , 1, GETDATE(), 1 )"); 
                            }

                            $this->Universidad_function_model->updateCMD($cmd_pago_comision_ind);
                            echo('cmd cmd_pago_comision_ind 321');
                            echo($cmd_pago_comision_ind);
                            $cmd_historial = "INSERT INTO historial_comisiones VALUES ($id, 1, GETDATE(), 1, 'MOTIVO DESCUENTO: $comentario')";
                            
                            $this->Universidad_function_model->updateCMD($cmd_historial);
                            
                            $cmd_inserPago ="INSERT INTO pago_comision_ind
                            (id_comision, id_usuario, abono_neodata, fecha_abono,
                            fecha_pago_intmex, pago_neodata, estatus, modificado_por,
                            comentario, descuento_aplicado,abono_final,aply_pago_intmex) 
                            VALUES (
                            $comision->id_comision, 
                            $usuario_por_CONTADOR, $Restante,GETDATE(), 
                            GETDATE(), $monto, 1,1, 
                            'DESCUENTO NUEVO PAGO_ automatizado', 0 ,null, null)";
                            // $insert_id = $this->db->insert_id();
                            // $respuesta = $this->db->query("INSERT INTO historial_comisiones VALUES ($insert_id, $usuario, GETDATE(), 1, 'NUEVO PAGO, DISPONIBLE PARA COBRO')");
                            $this->Universidad_function_model->updateCMD($cmd_inserPago);
                            echo('cmd cmd_inserPago 339');
                            echo($cmd_inserPago);

                        }else{
                            echo('cmd no entro a nada  343');
                        }
                        // $dat =  $this->Universidad_function_model->update_descuento($id,$montoAinsertar,$comentario, $saldo_comisiones, 1,$data[$contador_de_consulta]['id_usuario'],$id_descuento,$cmd);

                        // $dat =  $this->Universidad_function_model->update_descuento($id,$descuento,$comentario, $saldo_comisiones, $this->session->userdata('id_usuario'),$usuario,$id_descuento);
                        // $dat =  $this->Universidad_function_model->insertar_descuento($usuario,$montoAinsertar,$comision[0]['id_comision'],$comentario,$this->session->userdata('id_usuario'),$pago_neodata, $id_descuento);
                    }
                    // if ($this->db->trans_status() === TRUE)
                    //     {
                    //         $this->db->trans_commit();
                    //     }
                    // else
                    // {
                    //     $this->db->trans_rollback();
                    // }
                        
                    
                    echo('<br>');
                    echo('-------------------------------------------------------------------------------');
                    echo('-------------------------------------------------------------------------------');
        
                    echo('<br>');
                    echo('-------------------------------------------------------------------------------');
                    echo('-------------------------------------------------------------------------------');
                    echo('-------------------------------------------------------------------------------');
                    echo('-------------------------------------------------------------------------------');
                    echo('-------------------------------------------------------------------------------');
                    echo('-------------------------------------------------------------------------------');
                    echo('<br>');

                    


                }   else{
                    
                    echo('cmd no ha pasado el mes 378');
                    // echo ($pagosDescontar);
                    // echo json_encode($abonado, $pagos_que_se_llevan );
                }
                
                
            } //llave para saldo de comisione >= pago_individual 
        }   //llave para el else estatus 2
    }


}



}