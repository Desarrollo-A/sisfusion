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
    $this->load->model('Comisiones_model','Comisiones_model');
  }

  public function index()
  {
    redirect(base_url());
  }


  public function CierrePrestamo($id_prestamo){
             
    $datos = $this->db->query("SELECT  pa.id_prestamo,sum( pci.abono_neodata) as pagado
                               FROM prestamos_aut pa
                               JOIN usuarios u ON u.id_usuario = pa.id_usuario
                               JOIN relacion_pagos_prestamo rpp ON rpp.id_prestamo = pa.id_prestamo
                               JOIN pago_comision_ind pci ON pci.id_pago_i = rpp.id_pago_i AND pci.estatus in(18,19,20,21,22,23,24,25,26) AND pci.descuento_aplicado = 1
                               JOIN comisiones c ON c.id_comision = pci.id_comision
                               WHERE pa.id_prestamo = ".$id_prestamo."
                               group by pa.id_prestamo")->result_array();

                               if(count($datos) == 0){
                                   return array(array('id_prestamo' => $id_prestamo,
                                                 'pagado' => 0  ));
                               }else{
                                   return $datos;
                               }

   }
  function descuentos_aut(){
    /*CONSULTAMOS LOS PRESTAOS LOS CUALES YA HAYAN PASADO MAS DE 28 DIAS DESPUES DEL REGISTRO*/
    $data = $this->db->query("select p.*,opc.nombre from prestamos_aut p inner join opcs_x_cats opc on opc.id_opcion=p.tipo and opc.id_catalogo=23 where p.estatus=1")->result_array();
    $updateArrayData = array();
    $insertArrayData = array();
    for ($m=0; $m <count($data); $m++) {
        $pagoMensual = $data[$m]['pago_individual'] + $data[$m]['pendiente'];
        $VerificarCierre = $this->CierrePrestamo($data[$m]['id_prestamo']);
        if(($pagoMensual + $VerificarCierre[0]['pagado']) > ($data[$m]['monto'] - 0.50)){
            $pagoMensual =  $data[$m]['monto'] - $VerificarCierre[0]['pagado'];
        }
            $tipo_prestamo = $data[$m]['tipo'];
        $PagosByUSer = $this->db->query("select * from pago_comision_ind where id_usuario=".$data[$m]['id_usuario']." and estatus=1 order by abono_neodata desc")->result_array();
        $Suma = 0;
            if(count($PagosByUSer) > 0)
            {
                for ($n=0;$n<count($PagosByUSer);$n++) {
                    $commonData = array();
                    $commonData2 = array();
                    $Suma = $Suma + $PagosByUSer[$n]['abono_neodata'];

                        if($Suma >= $pagoMensual)
                        {
                            /*SI EL PAGO MENSUAL DEL PRESTAMO SE CUBRE CON LA SUMA ACTUAL DE LOS PAGOS, ESTE SE TOMARA PARA HACER EL DESCUENTO DEL PRESTAMO*/
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
                                /**YA NO HAY MAS PAGOS*/
                              $pendiente = $pagoMensual - $Suma;
                                if($pendiente > $data[$m]['monto']){
                                    $pendiente =  $data[$m]['monto'] - $CierrePrestamo[0]['pagado'];
                                }
                                $this->db->query("UPDATE pago_comision_ind SET estatus=$tipo_prestamo,descuento_aplicado=1,modificado_por=1 WHERE id_pago_i = ".$PagosByUSer[$n]['id_pago_i']." ");
                                $this->db->query("INSERT INTO relacion_pagos_prestamo(id_prestamo,id_pago_i,estatus,creado_por,fecha_creacion,modificado_por,fecha_modificacion,np) values(".$data[$m]['id_prestamo'].",".$PagosByUSer[$n]['id_pago_i'].",1,1,GETDATE(),1,GETDATE(),".$data[$m]['n_p'].")");
                                $this->db->query("INSERT INTO historial_comisiones values(".$PagosByUSer[$n]['id_pago_i'].",1,GETDATE(),1,'DESCUENTO POR ".$data[$m]['nombre'].", TOTAL A DESCONTAR $".number_format($data[$m]['monto'], 2, '.', ',')." A ".$data[$m]['num_pagos']." MES(ES), MOTIVO DESCUENTO: ".$data[$m]['comentario']."')");
                                $this->db->query("UPDATE prestamos_aut SET n_p=n_p+1,modificado_por=1,fecha_modificacion=GETDATE(),pendiente=$pendiente WHERE id_prestamo=".$data[$m]['id_prestamo']."");
                                break;
                            }else{
                                /**EL SUMA ACOMULADA NO CUBRE EL MONTO CORRESPONDIENTE AL MES, Y SE TOMA POR COMPLETO EL PAGO*/
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
            }
    }
}






}
