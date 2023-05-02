<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;


class ScheduleTasks_Prestamos extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library(array('session', 'form_validation'));
    $this->load->helper(array('url', 'form'));
    $this->load->database('default');
    $this->load->library('phpmailer_lib');
    $this->load->model('Comisiones_model','Comisiones_model');
  }

  public function index()
  {
    redirect(base_url());
  }


  public function CierrePrestamo($id_prestamo){
             
    $datos = $this->db->query("SELECT  pa.id_prestamo,sum( pci.abono_neodata) as pagado,MAX(rpp.fecha_creacion) as modificado
                               FROM prestamos_aut pa
                               JOIN usuarios u ON u.id_usuario = pa.id_usuario
                               JOIN relacion_pagos_prestamo rpp ON rpp.id_prestamo = pa.id_prestamo
                               JOIN pago_comision_ind pci ON pci.id_pago_i = rpp.id_pago_i AND pci.estatus in(18,19,20,21,22,23,24,25,26) AND pci.descuento_aplicado = 1
                               JOIN comisiones c ON c.id_comision = pci.id_comision
                               WHERE pa.id_prestamo = ".$id_prestamo."
                               group by pa.id_prestamo")->result_array();

                               if(count($datos) == 0){
                                   return array(array('id_prestamo' => $id_prestamo,
                                                 'pagado' => 0,
                                                'modificado' => 0 ));
                               }else{
                                   return $datos;
                               }

   }
  function descuentos_aut(){
    ini_set('max_execution_time', 99999999999);
    set_time_limit(99999999999);
    ini_set('memory_limit','10240M');
    $hoy = date("Y-m-d");
    $arrayCorreo = array();
    $arrayDatosCorreo = array();
    /*CONSULTAMOS LOS PRÉSTAMOS*/
    $data = $this->db->query("SELECT p.*,opc.nombre 
    FROM prestamos_aut p 
    INNER JOIN opcs_x_cats opc ON opc.id_opcion=p.tipo AND opc.id_catalogo=23 
    WHERE p.estatus=1
    ORDER BY monto ASC")->result_array();
    for ($m=0; $m <count($data); $m++){
        $pagoMensual = $data[$m]['pago_individual'] + $data[$m]['pendiente'];
        $VerificarCierre = $this->CierrePrestamo($data[$m]['id_prestamo']);
        if(($pagoMensual + $VerificarCierre[0]['pagado']) > ($data[$m]['monto'] - 0.50)){
            $pagoMensual =  $data[$m]['monto'] - $VerificarCierre[0]['pagado'];
        }
            $tipo_prestamo = $data[$m]['tipo'];
        $PagosByUSer = $this->db->query("SELECT * FROM pago_comision_ind WHERE id_usuario=".$data[$m]['id_usuario']." AND estatus=1 ORDER BY abono_neodata DESC")->result_array();
        $Suma = 0;
        $FechaUltimoAbono = $VerificarCierre[0]['modificado'] != 0 ?  explode(" ",$VerificarCierre[0]['modificado']) : explode(" ",'2022-01-01 00:00:00');

        //SI LAS FECHAS SON DIFERENTES => ENTONCES NO SE HA APLICADO EL PRÉSTAMO AUN, APLICARLO
        if(strtotime($FechaUltimoAbono[0]) != strtotime($hoy)){
            $this->db->trans_begin();
            if(count($PagosByUSer) > 0)
            {
                for ($n=0;$n<count($PagosByUSer);$n++) {
                    $Suma = $Suma + $PagosByUSer[$n]['abono_neodata'];

                        if($Suma >= $pagoMensual)
                        {
                            //SI EL PAGO MENSUAL DEL PRESTAMO SE CUBRE CON LA SUMA ACTUAL DE LOS PAGOS, ESTE SE TOMARA PARA HACER EL DESCUENTO DEL PRESTAMO
                           $restante = $Suma - $pagoMensual; //ESTE PAGO SE INSERTA EN ESTATUS 1
                           $MontoAdescontar = $PagosByUSer[$n]['abono_neodata'] - $restante; //UPDATE PARA EL PAGO ACTUAL
                           $neodata =  $PagosByUSer[$n]['pago_neodata'] == '' || $PagosByUSer[$n]['pago_neodata'] == 0 ? $restante : $PagosByUSer[$n]['abono_neodata'];
                           
                           
                           $this->db->query("UPDATE pago_comision_ind SET estatus=$tipo_prestamo,descuento_aplicado=1,abono_neodata=$MontoAdescontar,modificado_por=1 WHERE id_pago_i = ".$PagosByUSer[$n]['id_pago_i']." ");
                           $this->db->query("INSERT INTO relacion_pagos_prestamo(id_prestamo,id_pago_i,estatus,creado_por,fecha_creacion,modificado_por,fecha_modificacion,np) values(".$data[$m]['id_prestamo'].",".$PagosByUSer[$n]['id_pago_i'].",1,1,GETDATE(),1,GETDATE(),".$data[$m]['n_p'].")");
                           $this->db->query("INSERT INTO historial_comisiones values(".$PagosByUSer[$n]['id_pago_i'].",1,GETDATE(),1,'DESCUENTO POR ".$data[$m]['nombre'].", TOTAL A DESCONTAR $".number_format($data[$m]['monto'], 2, '.', ',')." A ".$data[$m]['num_pagos']." MES(ES), MOTIVO DESCUENTO: ".$data[$m]['comentario']."')");
                           if($restante > 0){
                                               $this->db->query("INSERT INTO pago_comision_ind (id_comision, id_usuario, abono_neodata, fecha_abono, fecha_pago_intmex, estatus, pago_neodata, creado_por, comentario,modificado_por) VALUES (".$PagosByUSer[$n]['id_comision'].", ".$PagosByUSer[$n]['id_usuario'].", ".$restante.", GETDATE(), GETDATE(), 1, ".$neodata.",1, 'ESTE MONTO ES EL RESTANTE DEL PAGO CON ID ".$PagosByUSer[$n]['id_pago_i']."',1)");            
                                               $insert_id = $this->db->insert_id();
                                            }
                                            $this->db->query("INSERT INTO  historial_comisiones VALUES ($insert_id, 1, GETDATE(), 1, 'ESTE ES EL RESTANTE A UN DESCUENTO, SALDO DISPONIBLE PARA COBRO')");
                                            //Proceso para cerrar el prestamo, si es que ya se pago por completo
                            $CierrePrestamo = $this->CierrePrestamo($data[$m]['id_prestamo']);
                            if($CierrePrestamo[0]['pagado'] > ($data[$m]['monto'] - 0.50)){
                                $this->db->query("UPDATE prestamos_aut SET modificado_por=1,pendiente=0,fecha_modificacion=GETDATE(),estatus=3 WHERE id_prestamo=".$data[$m]['id_prestamo']."");
                            }else{
                                $this->db->query("UPDATE prestamos_aut SET n_p=n_p+1,modificado_por=1,pendiente=0,fecha_modificacion=GETDATE() WHERE id_prestamo=".$data[$m]['id_prestamo']."");
                            }
                            break;
                        }else{
                            $CierrePrestamo = $this->CierrePrestamo($data[$m]['id_prestamo']);
                            if($n == count($PagosByUSer) -1 ){
                                //YA NO HAY MAS PAGOS
                              $pendiente = $pagoMensual - $Suma;
                                if($pendiente > $data[$m]['monto']){
                                    $pendiente =  $data[$m]['monto'] - $CierrePrestamo[0]['pagado'];
                                }
                                $this->db->query("UPDATE pago_comision_ind SET estatus=$tipo_prestamo,descuento_aplicado=1,modificado_por=1 WHERE id_pago_i = ".$PagosByUSer[$n]['id_pago_i']." ");
                                $this->db->query("INSERT INTO relacion_pagos_prestamo(id_prestamo,id_pago_i,estatus,creado_por,fecha_creacion,modificado_por,fecha_modificacion,np) values(".$data[$m]['id_prestamo'].",".$PagosByUSer[$n]['id_pago_i'].",1,1,GETDATE(),1,GETDATE(),".$data[$m]['n_p'].")");
                                $this->db->query("INSERT INTO historial_comisiones values(".$PagosByUSer[$n]['id_pago_i'].",1,GETDATE(),1,'DESCUENTO POR ".$data[$m]['nombre'].", TOTAL A DESCONTAR $".number_format($data[$m]['monto'], 2, '.', ',')." A ".$data[$m]['num_pagos']." MES(ES), MOTIVO DESCUENTO: ".$data[$m]['comentario']."')");
                                $this->db->query("UPDATE prestamos_aut SET n_p=n_p+1,modificado_por=1,fecha_modificacion=GETDATE(),pendiente=$pendiente WHERE id_prestamo=".$data[$m]['id_prestamo']."");
                                $arrayCorreo[$m] = array(
                                    "id_prestamo" => $data[$m]['id_prestamo'],
                                    "id_usuario" => $data[$m]['id_usuario'],
                                    "motivo" => "Se tomaron todos los pagos del usuario, no se cubrio el pago mensual por completo"
                                );
                                array_push($arrayDatosCorreo,$arrayCorreo);
                                break;
                            }else{
                                //EL SUMA ACOMULADA NO CUBRE EL MONTO CORRESPONDIENTE AL MES, Y SE TOMA POR COMPLETO EL PAGO
                                $this->db->query("UPDATE pago_comision_ind SET estatus=$tipo_prestamo,descuento_aplicado=1,modificado_por=1 WHERE id_pago_i = ".$PagosByUSer[$n]['id_pago_i']." ");
                                $this->db->query("INSERT INTO relacion_pagos_prestamo(id_prestamo,id_pago_i,estatus,creado_por,fecha_creacion,modificado_por,fecha_modificacion,np) values(".$data[$m]['id_prestamo'].",".$PagosByUSer[$n]['id_pago_i'].",1,1,GETDATE(),1,GETDATE(),".$data[$m]['n_p'].")");
                                $this->db->query("INSERT INTO historial_comisiones values(".$PagosByUSer[$n]['id_pago_i'].",1,GETDATE(),1,'DESCUENTO POR ".$data[$m]['nombre'].", TOTAL A DESCONTAR $".number_format($data[$m]['monto'], 2, '.', ',')." A ".$data[$m]['num_pagos']." MES(ES), MOTIVO DESCUENTO: ".$data[$m]['comentario']."')");
                            }
                        }
                }
            }else{
                $CierrePrestamo = $this->CierrePrestamo($data[$m]['id_prestamo']);

                if($CierrePrestamo[0]['pagado'] > ($data[$m]['monto'] - 0.50)){
                    $this->db->query("UPDATE prestamos_aut SET modificado_por=1,pendiente=0,fecha_modificacion=GETDATE(),estatus=3 WHERE id_prestamo=".$data[$m]['id_prestamo']."");
                }else{
                    $pendiente = $pagoMensual;
                    if($pendiente > $data[$m]['monto']){
                        $pendiente =  $data[$m]['monto'] - $CierrePrestamo[0]['pagado'];
                    }
                    $this->db->query("UPDATE prestamos_aut SET modificado_por=1,fecha_modificacion=GETDATE(),pendiente=$pendiente WHERE id_prestamo=".$data[$m]['id_prestamo']."");
                }
                $arrayCorreo = array(
                    "id_prestamo" => $data[$m]['id_prestamo'],
                    "id_usuario" => $data[$m]['id_usuario'],
                    "motivo" => "Sin pagos disponibles"
                );
                array_push($arrayDatosCorreo,$arrayCorreo);

            }
            //SI DIO UN ERROR EN UN PRÉSTAMO, DAR ROLLBACK, DE LO CONTRARIO HARA COMMIT
            if ($this->db->trans_status() === FALSE) {
                $arrayCorreo = array(
                    "id_prestamo" => $data[$m]['id_prestamo'],
                    "id_usuario" => $data[$m]['id_usuario'],
                    "motivo" => "Hubo un error de base de datos"
                );
                array_push($arrayDatosCorreo,$arrayCorreo);
                $this->db->trans_rollback();      
            } else {
               $this->db->trans_commit();
            }
        }else{
            
            //DE LO CONTRARIO YA SE APLICO HOY Y CONTUNUEA CON EL SIGUIENTE 

        }   
    }
    $this->SendMailPrestamos( $arrayDatosCorreo);
}

function SendMailPrestamos($data){
    var_dump($data);
    $mail = $this->phpmailer_lib->load();
    $mail->setFrom('no-reply@ciudadmaderas.com', 'Ciudad Maderas');
    $mail->addAddress('programador.analista5@ciudadmaderas.com');
    $mail->addAddress('programador.analista16@ciudadmaderas.com');
    //$mail->addAddress('tester.ti2@ciudadmaderas.com');


   $cadena='';
   for ($i=0; $i <count($data) ; $i++) { 
    $id_p = $data[$i]['id_prestamo'];
    $id_user = $data[$i]['id_usuario'];
    $motivo = $data[$i]['motivo'];
    $cadena = "
    <tr>
        <td>".$id_p."</td>
        <td>".$id_user."</td>
        <td>".$motivo."</td>
    </tr>
    ";
   }
    
  $mailContent = utf8_decode( "<html><head>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>
  <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>	
  <title>PRÉSTAMOS NO APLICADOS </title>
  <style media='all' type='text/css'>
      .encabezados{
          text-align: center;
          padding-top:  1.5%;
          padding-bottom: 1.5%;
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
  </style>
</head>
<body>
  <table align='center' cellspacing='0' cellpadding='0' border='0' width='100%'>
      <tr colspan='3'><td class='navbar navbar-inverse' align='center'>
          <table width='750px' cellspacing='0' cellpadding='3' class='container'>
              <tr class='navbar navbar-inverse encabezados'><td>
                  <img src='https://www.ciudadmaderas.com/assets/img/logo.png' width='100%' class='img-fluid'/>
              </td></tr>
          </table>
      </td></tr>
      <tr><td border=1 bgcolor='#FFFFFF' align='center'>  
      <center><table id='reporyt' cellpadding='0' cellspacing='0' border='1' width ='50%' style class='darkheader'>
        <tr class='active'>
          <th>Id préstamo</th>
          <th>Id usuario</th> 
          <th>Motivo</th>     
        </tr> 
        ".$cadena."
        </table></center>
      
      
      </td></tr>
  </table></body></html>");

  $mail->Body = $mailContent;
  


  $mail->Subject = utf8_decode('PRÉSTAMOS NO APLICADOS EL DÍA '.date('Y-m-d'));
  $mail->isHTML(true);
  $mail->send();
}






}
