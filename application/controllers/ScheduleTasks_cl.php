<?php class ScheduleTasks_cl extends CI_Controller {
	public function __construct() {
		parent::__construct();
    $this->load->model('scheduleTasks_model');
    $this->load->model('Comisiones_model');
    $this->load->model('asesor/Asesor_model');
		$this->load->library(array('session','form_validation'));
		$this->load->helper(array('url','form'));
		$this->load->database('default');
		$this->load->library('phpmailer_lib');
    date_default_timezone_set('America/Mexico_City');
    $this->gphsis = $this->load->database('GPHSIS', TRUE);
		
	}

  public function validaVencimiento()
  {
    /*$data = $this->scheduleTasks_model->verificaProspectActivos();
    date_default_timezone_set('America/Mexico_city');
    for($i = 0; $i < count($data); $i ++)
    {
      $updateArray[] = array(
        'id_prospecto' => $data[$i]['id_prospecto'],
        'estatus' => 0,
        'fecha_modificacion' => date('Y-m-d H:i:s'),
        'modificado_por' => 1
      );
    }
    //$response = $this->db->update_batch('prospectos', $updateArray, 'id_prospecto'); 
    if (! $response ) {
      echo json_encode('Error'); // SOMETHING HAPPENED
    } else {
      echo json_encode('Success'); // SUCCESS TRANSACTION
    }*/
  }
  
	

	public function getDiffDays($fecha_2)
	{
		$now = date('Y-m-d');
		$fecha1 = new dateTime($now);
		$fecha2= new dateTime($fecha_2);
		$diff = $fecha1->diff($fecha2);
		return ($diff->invert == 1) ? $diasTrans='-'.$diff->days : $diasTrans=$diff->days;
	}
	
	
	
	
	
	
public function sendRv5(){
 
  $datos["sendApartados_old"]= $this->scheduleTasks_model->sendMailVentasRetrasos();
  

  $mail = $this->phpmailer_lib->load();
  $mail->isSMTP();

  $mail->Host     = 'smtp.gmail.com';
  $mail->SMTPAuth = true;
  $mail->Username = 'no-reply@ciudadmaderas.com';
  $mail->Password = 'Va7<*V8PP';
  $mail->SMTPSecure = 'ssl';
  $mail->Port     = 465;
  
  $mail->setFrom('no-reply@ciudadmaderas.com', 'Ciudad Maderas');

  $mail->addAddress('lucero.velazquez@ciudadmaderas.com');
  $mail->addAddress('subdirector.contraloria@ciudadmaderas.com');
  $mail->addAddress('rigel.silva@prohabitacion.com');
  $mail->addAddress('rafael.bautista@ciudadmaderas.com');
  $mail->addAddress('vicky.paulin@ciudadmaderas.com');
  $mail->addAddress('adriana.rodriguez@ciudadmaderas.com');
  $mail->addAddress('aurea.garcia@ciudadmaderas.com');
  $mail->addAddress('valeria.palacios@ciudadmaderas.com');
  $mail->addAddress('juanamaria.guzman@ciudadmaderas.com');
  $mail->addAddress('adriana.perez@ciudadmaderas.com');
  $mail->addAddress('fernanda.monjaraz@ciudadmaderas.com');
  $mail->addAddress('grisell.malagon@ciudadmaderas.com');

  //$mail->addAddress('coord.desarrollo2@ciudadmaderas.com');



  $mail->Subject = utf8_decode("Acumulado de lotes sin integrar Expediente al:"." ".date("Y-m-d H:i:s"));
  $mail->isHTML(true);

  $mailContent = utf8_decode("<html><head>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>
  <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>	
  <title>AVISO </title>
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
                  <img src='https://www.ciudadmaderas.com/assets/img/logo.png' width='100%' class='img-fluid'/><p><a href='#'>SISTEMA DE CONTRATACIÓN</a></p>
              </td></tr>
          </table>
      </td></tr>
      <tr><td border=1 bgcolor='#FFFFFF' align='center'>  
      <center><table id='reporyt' cellpadding='0' cellspacing='0' border='1' width ='50%' style class='darkheader'>
        <tr class='active'>

              <th >Plaza</th>
              <th>Condominio</th> 
              <th>Lote</th>
              <th>Fecha Apartado</th>
              <th>Cliente</th>
              <th>Gerente</th>
              <th>Coordinador</th>
              <th>Asesor</th>
              <th>Días acumulados sin integrar Expediente</th>

        </tr>");

        foreach ($datos["sendApartados_old"] as $row_cliente){
  
  
          $fechaHoy = $row_cliente->fechaApartado;
          $fechaDes = date('Y-m-d');
          $arregloFechas2 = array();
          
          $a = 0;
          
          while($fechaHoy <= $fechaDes) {
          $hoy_strtotime = strtotime($fechaHoy);
          $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
          $sig_fecha = date("Y-m-d", $sig_strtotime );
          $excluir_dia = date('D', $sig_strtotime);
          $excluir_feriado = date('d-m', $sig_strtotime);
          
        
          if($excluir_dia == "Sat" || $excluir_dia == "Sun" || $excluir_feriado == "01-01" || $excluir_feriado == "06-02" ||
          $excluir_feriado == "20-03" || $excluir_feriado == "01-05" || $excluir_feriado == "16-09" || $excluir_feriado == "20-11" ||
          $excluir_feriado == "25-12") {
          
          } 
          
            else { 
              $arregloFechas2[$a]= $sig_fecha ;
              $a++; 
            } 
            $fechaHoy = $sig_fecha;
          }
          
          
          
        if (count($arregloFechas2)>=5) {


        $mailContent.= utf8_decode( 
        "<tr>   

         <td><center>".$row_cliente->nombreResidencial."</center></td>
         <td><center>".$row_cliente->nombreCondominio."</center></td>
         <td><center>".$row_cliente->nombreLote."</center></td>
         <td><center>".$row_cliente->fechaApartado."</center></td>
         <td><center>".$row_cliente->nc." ".$row_cliente->appc." ".$row_cliente->apmc."</center></td>
         <td><center>".$row_cliente->gerente."</center></td>
         <td><center>".$row_cliente->coordinador."</center></td>
         <td><center>".$row_cliente->asesor."</center></td>
         <td><center>".count($arregloFechas2)."</center></td>

        </tr>");

  
      }  
    }


  $mailContent.= utf8_decode("</table></center>
      
      
      </td></tr>
  </table></body></html>");

  $mail->Body = $mailContent;
  $mail->send();

  
}  



public function eventBloqueos(){
  
  $datos= array();
  $datos= $this->scheduleTasks_model->getBloqueos();
    
  foreach ($datos as $bloqueosAct){
	  
  if($bloqueosAct[0]['idStatusLote'] <> 8) {

    $data=array();
    $data["idLote"]=$bloqueosAct[0]['idLote'];
		
    $descAct = $this->scheduleTasks_model->updateStatusBloqueo($data);

  } 
 }
}




public function mailBloqueosAfter45(){
 
  $datos["mailbloqueos"]= $this->scheduleTasks_model->sendMailBloqueosDireccion();

  $mail = $this->phpmailer_lib->load();
  $mail->isSMTP();
  $mail->Host     = 'smtp.gmail.com';
  $mail->SMTPAuth = true;
  $mail->Username = 'no-reply@ciudadmaderas.com';
  $mail->Password = 'Va7<*V8PP';
  $mail->SMTPSecure = 'ssl';
  $mail->Port     = 465;
  
  $mail->setFrom('no-reply@ciudadmaderas.com', 'Ciudad Maderas');
  $mail->addAddress("contraloria.corporativa6@ciudadmaderas.com");
  $mail->Subject = utf8_decode('LOTES BLOQUEADOS-CIUDAD MADERAS');
  $mail->isHTML(true);
  $mailContent = utf8_decode(

"<style type='text/css'>
 
table {  color: #333; border-collapse: collapse;}
td, th { border: 20px solid transparent; height: 30px; }
th { background: #D3D3D3; font-weight: bold; }
td { background: #FAFAFA; text-align: center; }
tr:nth-child(even) td { background: #F1F1F1; }  
tr:nth-child(odd) td { background: #FEFEFE; } 
tr td:hover { background: #666; color: #FFF; }

</style>

<h4><center>Lotes Bloqueados al:"." ".date("Y-m-d H:i:s")."</center></h4>
<center><table id='reporyt' cellpadding='0' cellspacing='0' border='1' width ='50%' style class='darkheader'>
  <tr class='active'>
  <th>Proyecto</th>
  <th>Condominio</th> 
  <th>Lote</th>
  <th>Superficie</th>
  <th>Gerente</th>
  <th>Coordinador</th>
  <th>Asesor</th>
  <th>Fecha Bloqueo</th>
  <th>Días acumulados con estatus Bloqueado</th>
  </tr> 

  ");


  foreach ($datos["mailbloqueos"] as $row_bloqueos){
    $fechaBloqueo = date_create($row_bloqueos->create_at);
    $fechaHoy = date_create(date("Y-m-d H:i:s"));
  
    $diff=date_diff($fechaBloqueo,$fechaHoy);
    $countDias = ($diff->format("%a") + 1);
  
    if ($countDias>=45) {
      $mailContent.= utf8_decode("
  <tr>   
           <td><center>".$row_bloqueos->nombreResidencial."</center></td>
           <td><center>".$row_bloqueos->nombreCondominio."</center></td>
           <td><center>".$row_bloqueos->nombreLote."</center></td>
           <td><center>".$row_bloqueos->sup."</center></td>
		   <td><center>".$row_bloqueos->gerente."</center></td>
		   <td><center>".$row_bloqueos->coordinador."</center></td>
		   <td><center>".$row_bloqueos->asesor."</center></td>
           <td><center>".$row_bloqueos->create_at."</center></td>
           <td><center>".$countDias."</center></td>
		   
  </tr>
  ");
  }
}

    $mail->Body = $mailContent;
    $mail->send();

}


	
	




//---------------------------------------- T A S K   C O M I S I O N E S ------------------------------------------





function insertar_gph_maderas_normal(){ //HACER INSERT DE LOS LOTES EN 0 Y PASARLOS A 1 VENTA ORDINARIA

  $QUERY_DATA_CONTRATACION = $this->db->query("SELECT l.idLote, l.idcliente, l.referencia, l.totalNeto2 , cl.lugar_prospeccion, r.idResidencial, l.nombreLote, c.nombre as nombreCondominio, r.idResidencial, r.nombreResidencial, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.totalNeto2,
  ae.id_usuario as id_asesor, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ',  ae.apellido_paterno) as asesor,
  co.id_usuario as id_coordinador, CONCAT(co.nombre, ' ', co.apellido_paterno, ' ',  co.apellido_paterno) as coordinador,
  ge.id_usuario as id_gerente, CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ',  ge.apellido_paterno) as gerente,
  su.id_usuario as id_subdirector, CONCAT(su.nombre, ' ', su.apellido_paterno, ' ',  su.apellido_paterno) as subdirector,
  di.id_usuario as id_director, CONCAT(di.nombre, ' ', di.apellido_paterno, ' ',  di.apellido_paterno) as director, cl.fechaApartado
   FROM [lotes] l
   INNER JOIN [condominios] c ON c.idCondominio = l.idCondominio
   INNER JOIN [residenciales] r ON r.idResidencial = c.idResidencial
   INNER JOIN [clientes] cl ON cl.id_cliente = l.idCliente
   INNER JOIN [usuarios] ae ON ae.id_usuario = cl.id_asesor
   LEFT JOIN [usuarios] co ON co.id_usuario = cl.id_coordinador
   LEFT JOIN [usuarios] ge ON ge.id_usuario = cl.id_gerente
   LEFT JOIN [usuarios] su ON su.id_usuario = ge.id_lider
   LEFT JOIN [usuarios] di ON di.id_usuario = su.id_lider
   WHERE l.idStatusContratacion BETWEEN 10 AND 15 
   AND l.plan_enganche is not null AND l.registro_comision = 0 AND l.totalNeto2 is not null AND cl.lugar_prospeccion NOT IN (6, 12) 
   AND l.tipo_venta not in (3,4,5) AND l.status = 1 
   AND ae.id_usuario is not null 
   AND ge.id_usuario is not null 
   AND su.id_usuario is not null 
   AND di.id_usuario is not null
   AND (ae.id_usuario <> co.id_usuario OR co.id_usuario IS NULL)");
 

  if($QUERY_DATA_CONTRATACION->num_rows() > 0){

    $client_vc = $QUERY_DATA_CONTRATACION->row()->idcliente;
    ///////////////////////////////////////////////////////////////////////
    $coord_count_titular = $QUERY_DATA_CONTRATACION->row()->id_coordinador;
    if($coord_count_titular!='' && $coord_count_titular!=null){
      $SUM_COORD = 1;
    }
    else{
      $SUM_COORD = 0;
    }
    ///////////////////////////////////////////////////////////////////////
    $gerente_count_titular = $QUERY_DATA_CONTRATACION->row()->id_gerente;
    if($gerente_count_titular!='' && $gerente_count_titular!=null){
      $SUM_GERENTE = 1;
    }
    else{
      $SUM_GERENTE = 0;
    }
    ///////////////////////////////////////////////////////////////////////

     $data_compartidas = $this->db->query("SELECT * FROM ventas_compartidas WHERE id_cliente = ".$client_vc." AND estatus = 1 ");
     
     //INICIA IF DE VENTA COMPARTIDA
     if($data_compartidas->num_rows() > 0){
     foreach ($QUERY_DATA_CONTRATACION->result() as $row) {

      $porcentajeAS = $this->db->query("SELECT porcentaje FROM porcentajes_comisiones WHERE relacion_prospeccion = 11 AND id_rol = 7"); 
      $porcentajeCO = $this->db->query("SELECT porcentaje FROM porcentajes_comisiones WHERE relacion_prospeccion = 11 AND id_rol = 9"); 
      $porcentajeGE = $this->db->query("SELECT porcentaje FROM porcentajes_comisiones WHERE relacion_prospeccion = 11 AND id_rol = 3"); 
      $porcentajeSU = $this->db->query("SELECT porcentaje FROM porcentajes_comisiones WHERE relacion_prospeccion = 11 AND id_rol = 2"); 
      $porcentajeDI = $this->db->query("SELECT porcentaje FROM porcentajes_comisiones WHERE relacion_prospeccion = 11 AND id_rol = 1"); 

      $count_as = $this->db->query("SELECT COUNT(DISTINCT(id_asesor)) val FROM  ventas_compartidas vc WHERE vc.estatus = 1 AND vc.id_cliente = ".$row->idcliente." AND id_asesor not in (0)");

      $count_co = $this->db->query("SELECT COUNT(DISTINCT(id_coordinador)) val FROM  ventas_compartidas vc WHERE vc.estatus = 1 AND vc.id_cliente = ".$row->idcliente." AND id_coordinador not in (0)");

      $count_ge = $this->db->query("SELECT COUNT(DISTINCT(id_gerente)) val FROM  ventas_compartidas vc WHERE vc.estatus = 1 AND vc.id_cliente = ".$row->idcliente." AND id_gerente not in (0)");

      $count_su = $this->db->query("SELECT COUNT(DISTINCT(u.id_lider)) val FROM ventas_compartidas vc INNER JOIN usuarios u ON u.id_usuario = vc.id_gerente  WHERE vc.estatus = 1 AND vc.id_cliente = ".$row->idcliente." AND id_gerente not in (0)");

      $count_asF = $count_as->row()->val + 1;
      $count_coF = $count_co->row()->val + $SUM_COORD;
      $count_geF = $count_ge->row()->val + $SUM_GERENTE;
      $count_suF = $count_su->row()->val + 1;
             
      $porcentajeAS1 = ($porcentajeAS->row()->porcentaje)/$count_asF;
      $porcentajeAS2 = ($porcentajeAS->row()->porcentaje);

      $porcentajeSU1 = ($porcentajeSU->row()->porcentaje)/$count_suF;
      $porcentajeSU2 = ($porcentajeSU->row()->porcentaje);

      $porcentajeDI1 = ($porcentajeDI->row()->porcentaje);


      if($SUM_COORD==1){
        $porcentajeCO1 = ($porcentajeCO->row()->porcentaje)/$count_coF;
        $porcentajeCO2 = ($porcentajeCO->row()->porcentaje);
      }else{
        $porcentajeCO1 = 0;
        $porcentajeCO2 = 0;
      }

      if($SUM_GERENTE==1){
        $porcentajeGE1 = ($porcentajeGE->row()->porcentaje)/$count_geF;
        $porcentajeGE2 = ($porcentajeGE->row()->porcentaje);
      }else{
        $porcentajeGE1 = 0;
        $porcentajeGE2 = 0;
      }
      
      $TotComisionAS1 = ($porcentajeAS1*($row->totalNeto2/100));
      $TotComisionSU1 = ($porcentajeSU1*($row->totalNeto2/100));
      $TotComisionDI1 = ($porcentajeDI1*($row->totalNeto2/100));

      if($SUM_COORD==1){
        $TotComisionCO1 = ($porcentajeCO1*($row->totalNeto2/100));
      }else{
        $TotComisionCO1 = 0;
      }

      if($SUM_GERENTE==1){
        $TotComisionGE1 = ($porcentajeGE1*($row->totalNeto2/100));
      }else{
        $TotComisionGE1 = 0;
      }

      $porcentajes_comision =  $porcentajeAS2+$porcentajeCO2+$porcentajeGE2+$porcentajeSU2+$porcentajeDI1;  

      $porcentajes_comision2 = $porcentajes_comision;
      $totalComision = $porcentajes_comision2*($row->totalNeto2/100); 

      //-------------------------------------------------------------------------------------------------------------------------------
      $this->db->query("INSERT INTO [pago_comision](id_lote, total_comision, abonado, porcentaje_abono, pendiente, fecha_abono, creado_por, fecha_modificacion) VALUES(".$row->idLote.", ".$totalComision.", 0, ".$porcentajes_comision2.", ".$totalComision.", getdate(), 1, getdate())");
      //-------------------------------------------------------------------------------------------------------------------------------
   
      $this->db->query("INSERT INTO [comisiones] ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$row->idLote.", ".$row->id_asesor.", ".$TotComisionAS1.", 1, 'NEODATA TIT AS N', NULL, NULL, 0, GETDATE(), ".$porcentajeAS1.", GETDATE(), 7)");

      if($SUM_COORD==1){
      $this->db->query("INSERT INTO [comisiones] ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$row->idLote.", ".$row->id_coordinador.", ".$TotComisionCO1.", 1, 'NEODATA TIT CO N', NULL, NULL, 0, GETDATE(), ".$porcentajeCO1.", GETDATE(), 9)");
     }
 
     if($SUM_GERENTE == 1){
      $this->db->query("INSERT INTO [comisiones] ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$row->idLote.", ".$row->id_gerente.", ".$TotComisionGE1.", 1, 'NEODATA TIT GE N', NULL, NULL, 0, GETDATE(), ".$porcentajeGE1.", GETDATE(), 3)");
     }
 
      $this->db->query("INSERT INTO [comisiones] ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$row->idLote.", ".$row->id_subdirector.", ".$TotComisionSU1.", 1, 'NEODATA TIT SU N', NULL, NULL, 0, GETDATE(), ".$porcentajeSU1.", GETDATE(), 2)");
  
      $this->db->query("INSERT INTO [comisiones] ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$row->idLote.", ".$row->id_director.", ".$TotComisionDI1.", 1, 'NEODATA TIT DI N', NULL, NULL, 0, GETDATE(), ".$porcentajeDI1.", GETDATE(), 1)");

      //**********************************************************************************************************************
 
      $dataAs = $this->db->query("SELECT DISTINCT(id_asesor) id_asesor FROM  ventas_compartidas vc WHERE vc.estatus = 1 AND vc.id_cliente = ".$row->idcliente." AND id_asesor not in (0)");
      $dataCo = $this->db->query("SELECT DISTINCT(id_coordinador) id_coordinador FROM  ventas_compartidas vc WHERE vc.estatus = 1 AND vc.id_cliente = ".$row->idcliente." AND id_coordinador not in (0)");
      $dataGe = $this->db->query("SELECT DISTINCT(id_gerente) id_gerente FROM  ventas_compartidas vc WHERE vc.estatus = 1 AND vc.id_cliente = ".$row->idcliente." AND id_gerente not in (0)");
      $dataSu = $this->db->query("SELECT DISTINCT(u.id_lider) id_subdirector FROM ventas_compartidas vc INNER JOIN usuarios u ON u.id_usuario = vc.id_gerente  WHERE vc.estatus = 1 AND vc.id_cliente = ".$row->idcliente." AND id_gerente not in (0)");

      foreach($dataAs->result() as $rowAs){
         $this->db->query("INSERT INTO [comisiones] ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$row->idLote.", ".$rowAs->id_asesor.", ".$TotComisionAS1.", 1, 'NEODATA AS CV N', NULL, NULL, 0, GETDATE(), ".$porcentajeAS1.", GETDATE(), 7)");
      }

      foreach($dataCo->result() as $rowCo){
         $this->db->query("INSERT INTO [comisiones] ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$row->idLote.", ".$rowCo->id_coordinador.", ".$TotComisionCO1.", 1, 'NEODATA CO CV N', NULL, NULL, 0, GETDATE(), ".$porcentajeCO1.", GETDATE(), 9)");
      }

      foreach($dataGe->result() as $rowGe){
         $this->db->query("INSERT INTO [comisiones] ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$row->idLote.", ".$rowGe->id_gerente.", ".$TotComisionGE1.", 1, 'NEODATA GE CV N', NULL, NULL, 0, GETDATE(), ".$porcentajeGE1.", GETDATE(), 3)"); 
      }

      foreach($dataSu->result() as $rowSu){
         $this->db->query("INSERT INTO [comisiones] ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$row->idLote.", ".$rowSu->id_subdirector.", ".$TotComisionSU1.", 1, 'NEODATA SU CV N', NULL, NULL, 0, GETDATE(), ".$porcentajeSU1.", GETDATE(), 2)");
      }

      $this->gphsis->query("INSERT INTO [GPHSIS].[dbo].[Comisiones](
        [Referencia] ,[Saldoinicial],[Saldorestante],[Fechaultimoabono],[Montoultimoabono],[Idaplicacion],[Marca],[IdDesarrollo],[TotalAplicado],[USR],[AbonoContraloria] ,[idcontrato]) 
         VALUES ('".$row->referencia."',".$totalComision.", NULL, NULL, NULL, NULL, 101, '".$row->idResidencial."', NULL, NULL, NULL, NULL)");
      $this->db->query("UPDATE [lotes] SET registro_comision = 1 WHERE idLote = '".$row->idLote."'");
    }
  
  }//FIN DE IF VENTA COMPARTIDA
     
  
  else{ //INICIA ELSE DE VENTA NORMAL
    
    foreach ($QUERY_DATA_CONTRATACION->result() as $row) {
      
      $porcentajeAS = $this->db->query("SELECT porcentaje FROM porcentajes_comisiones WHERE relacion_prospeccion = 11 AND id_rol = 7"); 
      $porcentajeCO = $this->db->query("SELECT porcentaje FROM porcentajes_comisiones WHERE relacion_prospeccion = 11 AND id_rol = 9"); 
      $porcentajeGE = $this->db->query("SELECT porcentaje FROM porcentajes_comisiones WHERE relacion_prospeccion = 11 AND id_rol = 3"); 
      $porcentajeSU = $this->db->query("SELECT porcentaje FROM porcentajes_comisiones WHERE relacion_prospeccion = 11 AND id_rol = 2"); 
      $porcentajeDI = $this->db->query("SELECT porcentaje FROM porcentajes_comisiones WHERE relacion_prospeccion = 11 AND id_rol = 1"); 
 
      $porcentajeAS1 = ($porcentajeAS->row()->porcentaje);
      $porcentajeSU1 = ($porcentajeSU->row()->porcentaje);
      $porcentajeDI1 = ($porcentajeDI->row()->porcentaje);


      if($SUM_COORD==1){
        $porcentajeCO1 = ($porcentajeCO->row()->porcentaje);
      }else{
        $porcentajeCO1 = 0;
      }

      if($SUM_GERENTE==1){
        $porcentajeGE1 = ($porcentajeGE->row()->porcentaje);
      }else{
        $porcentajeGE1 = 0;
      }
      
      $TotComisionAS1 = ($porcentajeAS1*($row->totalNeto2/100));
      $TotComisionSU1 = ($porcentajeSU1*($row->totalNeto2/100));
      $TotComisionDI1 = ($porcentajeDI1*($row->totalNeto2/100));

      if($SUM_COORD==1){
        $TotComisionCO1 = ($porcentajeCO1*($row->totalNeto2/100));
      }else{
        $TotComisionCO1 = 0;
      }

      if($SUM_GERENTE==1){
        $TotComisionGE1 = ($porcentajeGE1*($row->totalNeto2/100));
      }else{
        $TotComisionGE1 = 0;
      }

      $porcentajes_comision =  $porcentajeAS1+$porcentajeCO1+$porcentajeGE1+$porcentajeSU1+$porcentajeDI1;
      $porcentajes_comision2 = $porcentajes_comision;
      $totalComision = $porcentajes_comision2*($row->totalNeto2/100); 
      echo '<br>PORCENTAJE COMISION: '.$porcentajes_comision2;
      echo '<br>TOTAL COMISION: '.$totalComision;
 
    
        echo '<br>PORCENTAJE ASESOR: '.$porcentajeAS1;
        echo '<br>TOTAL COMISION AS: '.$porcentajeAS1*($row->totalNeto2/100); 
        
        echo '<br>PORCENTAJE COORD: '.$porcentajeCO1;
        echo '<br>TOTAL COMISION CO: '.$porcentajeCO1*($row->totalNeto2/100); 
    
        echo '<br>PORCENTAJE GERENTE: '.$porcentajeGE1;
        echo '<br>TOTAL COMISION GE: '.$porcentajeGE1*($row->totalNeto2/100); 
    
        echo '<br>PORCENTAJE SUBDIR: '.$porcentajeSU1;
        echo '<br>TOTAL COMISION SU: '.$porcentajeSU1*($row->totalNeto2/100); 
    
        echo '<br>PORCENTAJE DIR: '.$porcentajeDI1;
        echo '<br>TOTAL COMISION DI: '.$porcentajeDI1*($row->totalNeto2/100); 

        //---------------------------------------------------------------------------------------------------------------------------------------
        $this->db->query("INSERT INTO [pago_comision](id_lote, total_comision, abonado, porcentaje_abono, pendiente, fecha_abono, creado_por, fecha_modificacion) VALUES(".$row->idLote.", ".$totalComision.", 0, ".$porcentajes_comision2.", ".$totalComision.", getdate(), 1, getdate())");
        // --------------------------------------------------------------------------------------------------------------------------------------
 
    
        $this->db->query("INSERT INTO [comisiones] ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$row->idLote.", ".$row->id_asesor.", ".$TotComisionAS1.", 1, 'NEODATA TIT ASE N1', NULL, NULL, 0, GETDATE(), ".$porcentajeAS1.", GETDATE(), 7)");

        if($SUM_COORD==1){
          $this->db->query("INSERT INTO [comisiones] ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$row->idLote.", ".$row->id_coordinador.", ".$TotComisionCO1.", 1, 'NEODATA TIT COR N1', NULL, NULL, 0, GETDATE(), ".$porcentajeCO1.", GETDATE(), 9)");
         }
     
         if($SUM_GERENTE == 1){
          $this->db->query("INSERT INTO [comisiones] ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$row->idLote.", ".$row->id_gerente.", ".$TotComisionGE1.", 1, 'NEODATA TIT GER N1', NULL, NULL, 0, GETDATE(), ".$porcentajeGE1.", GETDATE(), 3)");
         }
 
        $this->db->query("INSERT INTO [comisiones] ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$row->idLote.", ".$row->id_subdirector.", ".$TotComisionSU1.", 1, 'NEODATA TIT SUB N1', NULL, NULL, 0, GETDATE(), ".$porcentajeSU1.", GETDATE(), 2)");
    
        $this->db->query("INSERT INTO [comisiones] ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$row->idLote.", ".$row->id_director.", ".$TotComisionDI1.", 1, 'NEODATA TIT DIR N1', NULL, NULL, 0, GETDATE(), ".$porcentajeDI1.", GETDATE(), 1)");

         
        $this->gphsis->query("INSERT INTO [GPHSIS].[dbo].[Comisiones](
        [Referencia] ,[Saldoinicial],[Saldorestante],[Fechaultimoabono],[Montoultimoabono],[Idaplicacion],[Marca],[IdDesarrollo],[TotalAplicado],[USR],[AbonoContraloria] ,[idcontrato]) 
         VALUES ('".$row->referencia."',".$totalComision.", NULL, NULL, NULL, NULL, 101, '".$row->idResidencial."', NULL, NULL, NULL, NULL)");
      $this->db->query("UPDATE [lotes] SET registro_comision = 1 WHERE idLote = '".$row->idLote."'");
      } 

     } // FIN ELSE VENTA NORMAL
 
  }//FINAL IF

  else{
    echo "<br>no entra ";
    $this->db->query("INSERT INTO [sin_dispersar] (id_lote, referencia, comentario, fecha_creacion) VALUES (NULL, NULL, 'NO SE ECONTRARON DATOS (insertar_gph_maderas 2)' , GETDATE())");
  }
}






function insertar_gph_maderas_otras(){ //HACER INSERT DE LOS LOTES EN 0 Y PASARLOS A 1 VENTA ORDINARIA

  $QUERY_DATA_CONTRATACION = $this->db->query("SELECT l.idLote, l.idcliente, l.referencia, l.totalNeto2 , cl.lugar_prospeccion, r.idResidencial, l.nombreLote, c.nombre as nombreCondominio, r.idResidencial, r.nombreResidencial, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.totalNeto2,
  ae.id_usuario as id_asesor, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ',  ae.apellido_paterno) as asesor,
  co.id_usuario as id_coordinador, CONCAT(co.nombre, ' ', co.apellido_paterno, ' ',  co.apellido_paterno) as coordinador,
  ge.id_usuario as id_gerente, CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ',  ge.apellido_paterno) as gerente,
  su.id_usuario as id_subdirector, CONCAT(su.nombre, ' ', su.apellido_paterno, ' ',  su.apellido_paterno) as subdirector,
  di.id_usuario as id_director, CONCAT(di.nombre, ' ', di.apellido_paterno, ' ',  di.apellido_paterno) as director, cl.fechaApartado
   FROM [lotes] l
   INNER JOIN [condominios] c ON c.idCondominio = l.idCondominio
   INNER JOIN [residenciales] r ON r.idResidencial = c.idResidencial
   INNER JOIN [clientes] cl ON cl.id_cliente = l.idCliente
   INNER JOIN [usuarios] ae ON ae.id_usuario = cl.id_asesor
   LEFT JOIN [usuarios] co ON co.id_usuario = cl.id_coordinador
   LEFT JOIN [usuarios] ge ON ge.id_usuario = cl.id_gerente
   LEFT JOIN [usuarios] su ON su.id_usuario = ge.id_lider
   LEFT JOIN [usuarios] di ON di.id_usuario = su.id_lider
   WHERE l.idStatusContratacion= 15 
   AND l.plan_enganche is not null AND l.registro_comision = 0 AND l.totalNeto2 is not null AND cl.lugar_prospeccion IN (6, 12) 
   AND l.tipo_venta not in (3,4,5) AND l.status = 1 
   AND ae.id_usuario is not null 
   AND ge.id_usuario is not null 
   AND su.id_usuario is not null 
   AND di.id_usuario is not null
   AND (ae.id_usuario <> co.id_usuario OR co.id_usuario IS NULL)");
 
  if($QUERY_DATA_CONTRATACION->num_rows() > 0){

    $client_vc = $QUERY_DATA_CONTRATACION->row()->idcliente;

    $coord_count_titular = $QUERY_DATA_CONTRATACION->row()->id_coordinador;
    if($coord_count_titular!='' && $coord_count_titular!=null){
      $SUM_COORD = 1;
    }
    else{
      $SUM_COORD = 0;
    }
    $gerente_count_titular = $QUERY_DATA_CONTRATACION->row()->id_gerente;
    if($gerente_count_titular!='' && $gerente_count_titular!=null){
      $SUM_GERENTE = 1;
    }
    else{
      $SUM_GERENTE = 0;
    }
     $data_compartidas = $this->db->query("SELECT * FROM ventas_compartidas WHERE id_cliente = ".$client_vc." AND estatus = 1 ");
     
     if($data_compartidas->num_rows() > 0){
     foreach ($QUERY_DATA_CONTRATACION->result() as $row) {

      $porcentajeAS = $this->db->query("SELECT porcentaje FROM porcentajes_comisiones WHERE relacion_prospeccion = ".$row->lugar_prospeccion." AND id_rol = 7");  
      $porcentajeCO = $this->db->query("SELECT porcentaje FROM porcentajes_comisiones WHERE relacion_prospeccion = ".$row->lugar_prospeccion." AND id_rol = 9");  
      $porcentajeGE = $this->db->query("SELECT porcentaje FROM porcentajes_comisiones WHERE relacion_prospeccion = ".$row->lugar_prospeccion." AND id_rol = 3");  
      $porcentajeSU = $this->db->query("SELECT porcentaje FROM porcentajes_comisiones WHERE relacion_prospeccion = ".$row->lugar_prospeccion." AND id_rol = 2");  
      $porcentajeDI = $this->db->query("SELECT porcentaje FROM porcentajes_comisiones WHERE relacion_prospeccion = ".$row->lugar_prospeccion." AND id_rol = 1");
      
      switch($row->lugar_prospeccion){
        case '6':
        case 6:
          $porcentajeOtros = $this->db->query("SELECT porcentaje FROM porcentajes_comisiones WHERE relacion_prospeccion = ".$row->lugar_prospeccion." AND id_rol = 38");
          $user_otro = 4394;
          $rol_otro = 38;
        break;

        case '12':
        case 12:
          $porcentajeOtros = $this->db->query("SELECT porcentaje FROM porcentajes_comisiones WHERE relacion_prospeccion = ".$row->lugar_prospeccion." AND id_rol = 42");
          $user_otro = 4615;
          $rol_otro = 42;
        break;
      }

      
      $count_as = $this->db->query("SELECT COUNT(DISTINCT(id_asesor)) val FROM  ventas_compartidas vc WHERE vc.estatus = 1 AND vc.id_cliente = ".$row->idcliente." AND id_asesor not in (0)");
      $count_co = $this->db->query("SELECT COUNT(DISTINCT(id_coordinador)) val FROM  ventas_compartidas vc WHERE vc.estatus = 1 AND vc.id_cliente = ".$row->idcliente." AND id_coordinador not in (0)");
      $count_ge = $this->db->query("SELECT COUNT(DISTINCT(id_gerente)) val FROM  ventas_compartidas vc WHERE vc.estatus = 1 AND vc.id_cliente = ".$row->idcliente." AND id_gerente not in (0)");
      $count_su = $this->db->query("SELECT COUNT(DISTINCT(u.id_lider)) val FROM ventas_compartidas vc INNER JOIN usuarios u ON u.id_usuario = vc.id_gerente  WHERE vc.estatus = 1 AND vc.id_cliente = ".$row->idcliente." AND id_gerente not in (0)");

      $count_asF = $count_as->row()->val + 1;
      $count_coF = $count_co->row()->val + $SUM_COORD;
      $count_geF = $count_ge->row()->val + $SUM_GERENTE;
      $count_suF = $count_su->row()->val + 1;
             
      $porcentajeAS1 = ($porcentajeAS->row()->porcentaje)/$count_asF;
      $porcentajeAS2 = ($porcentajeAS->row()->porcentaje);
      $porcentajeSU1 = ($porcentajeSU->row()->porcentaje)/$count_suF;
      $porcentajeSU2 = ($porcentajeSU->row()->porcentaje);
      $porcentajeDI1 = ($porcentajeDI->row()->porcentaje);
      $porcentajeOtros1 = ($porcentajeOtros->row()->porcentaje);
      
      if($SUM_COORD==1){
        $porcentajeCO1 = ($porcentajeCO->row()->porcentaje)/$count_coF;
        $porcentajeCO2 = ($porcentajeCO->row()->porcentaje);
      }else{
        $porcentajeCO1 = 0;
        $porcentajeCO2 = 0;
      }
      if($SUM_GERENTE==1){
        $porcentajeGE1 = ($porcentajeGE->row()->porcentaje)/$count_geF;
        $porcentajeGE2 = ($porcentajeGE->row()->porcentaje);
      }else{
        $porcentajeGE1 = 0;
        $porcentajeGE2 = 0;
      }
      
      $TotComisionAS1 = ($porcentajeAS1*($row->totalNeto2/100));
      $TotComisionSU1 = ($porcentajeSU1*($row->totalNeto2/100));
      $TotComisionDI1 = ($porcentajeDI1*($row->totalNeto2/100));
      $TotComisionOtros1 = ($porcentajeOtros1*($row->totalNeto2/100));

      if($SUM_COORD==1){
        $TotComisionCO1 = ($porcentajeCO1*($row->totalNeto2/100));
      }else{
        $TotComisionCO1 = 0;
      }
      if($SUM_GERENTE==1){
        $TotComisionGE1 = ($porcentajeGE1*($row->totalNeto2/100));
      }else{
        $TotComisionGE1 = 0;
      }

      $porcentajes_comision =  $porcentajeAS2+$porcentajeCO2+$porcentajeGE2+$porcentajeSU2+$porcentajeDI1+$porcentajeOtros1;  
      $porcentajes_comision2 = $porcentajes_comision;
      $totalComision = $porcentajes_comision2*($row->totalNeto2/100); 

      //-------------------------------------------------------------------------------------------------------------------------------
      $this->db->query("INSERT INTO [pago_comision](id_lote, total_comision, abonado, porcentaje_abono, pendiente, fecha_abono, creado_por, fecha_modificacion) VALUES(".$row->idLote.", ".$totalComision.", 0, ".$porcentajes_comision2.", ".$totalComision.", getdate(), 1, getdate())");
      //-------------------------------------------------------------------------------------------------------------------------------
   
      $this->db->query("INSERT INTO [comisiones] ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$row->idLote.", ".$row->id_asesor.", ".$TotComisionAS1.", 1, 'NEODATA TIT AS O', NULL, NULL, 0, GETDATE(), ".$porcentajeAS1.", GETDATE(), 7)");
      if($SUM_COORD==1){
      $this->db->query("INSERT INTO [comisiones] ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$row->idLote.", ".$row->id_coordinador.", ".$TotComisionCO1.", 1, 'NEODATA TIT CO O', NULL, NULL, 0, GETDATE(), ".$porcentajeCO1.", GETDATE(), 9)");
     }
     if($SUM_GERENTE == 1){
      $this->db->query("INSERT INTO [comisiones] ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$row->idLote.", ".$row->id_gerente.", ".$TotComisionGE1.", 1, 'NEODATA TIT GE O', NULL, NULL, 0, GETDATE(), ".$porcentajeGE1.", GETDATE(), 3)");
     }
      $this->db->query("INSERT INTO [comisiones] ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$row->idLote.", ".$row->id_subdirector.", ".$TotComisionSU1.", 1, 'NEODATA TIT SU O', NULL, NULL, 0, GETDATE(), ".$porcentajeSU1.", GETDATE(), 2)");
      $this->db->query("INSERT INTO [comisiones] ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$row->idLote.", ".$row->id_director.", ".$TotComisionDI1.", 1, 'NEODATA TIT DI O', NULL, NULL, 0, GETDATE(), ".$porcentajeDI1.", GETDATE(), 1)");
      $this->db->query("INSERT INTO [comisiones] ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$row->idLote.", ".$user_otro.", ".$TotComisionOtros1.", 1, 'NEODATA OTRO O', NULL, NULL, 0, GETDATE(), ".$porcentajeOtros1.", GETDATE(), ".$rol_otro.")");
      //**********************************************************************************************************************
      $dataAs = $this->db->query("SELECT DISTINCT(id_asesor) id_asesor FROM  ventas_compartidas vc WHERE vc.estatus = 1 AND vc.id_cliente = ".$row->idcliente." AND id_asesor not in (0)");
      $dataCo = $this->db->query("SELECT DISTINCT(id_coordinador) id_coordinador FROM  ventas_compartidas vc WHERE vc.estatus = 1 AND vc.id_cliente = ".$row->idcliente." AND id_coordinador not in (0)");
      $dataGe = $this->db->query("SELECT DISTINCT(id_gerente) id_gerente FROM  ventas_compartidas vc WHERE vc.estatus = 1 AND vc.id_cliente = ".$row->idcliente." AND id_gerente not in (0)");
      $dataSu = $this->db->query("SELECT DISTINCT(u.id_lider) id_subdirector FROM ventas_compartidas vc INNER JOIN usuarios u ON u.id_usuario = vc.id_gerente  WHERE vc.estatus = 1 AND vc.id_cliente = ".$row->idcliente." AND id_gerente not in (0)");

      foreach($dataAs->result() as $rowAs){
         $this->db->query("INSERT INTO [comisiones] ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$row->idLote.", ".$rowAs->id_asesor.", ".$TotComisionAS1.", 1, 'NEODATA AS CV O', NULL, NULL, 0, GETDATE(), ".$porcentajeAS1.", GETDATE(), 7)");
      }
      foreach($dataCo->result() as $rowCo){
         $this->db->query("INSERT INTO [comisiones] ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$row->idLote.", ".$rowCo->id_coordinador.", ".$TotComisionCO1.", 1, 'NEODATA CO CV O', NULL, NULL, 0, GETDATE(), ".$porcentajeCO1.", GETDATE(), 9)");
      }
      foreach($dataGe->result() as $rowGe){
         $this->db->query("INSERT INTO [comisiones] ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$row->idLote.", ".$rowGe->id_gerente.", ".$TotComisionGE1.", 1, 'NEODATA GE CV O', NULL, NULL, 0, GETDATE(), ".$porcentajeGE1.", GETDATE(), 3)"); 
      }
      foreach($dataSu->result() as $rowSu){
         $this->db->query("INSERT INTO [comisiones] ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$row->idLote.", ".$rowSu->id_subdirector.", ".$TotComisionSU1.", 1, 'NEODATA SU CV O', NULL, NULL, 0, GETDATE(), ".$porcentajeSU1.", GETDATE(), 2)");
      }

      $this->gphsis->query("INSERT INTO [GPHSIS].[dbo].[Comisiones](
        [Referencia] ,[Saldoinicial],[Saldorestante],[Fechaultimoabono],[Montoultimoabono],[Idaplicacion],[Marca],[IdDesarrollo],[TotalAplicado],[USR],[AbonoContraloria] ,[idcontrato]) 
         VALUES ('".$row->referencia."',".$totalComision.", NULL, NULL, NULL, NULL, 100, '".$row->idResidencial."', NULL, NULL, NULL, NULL)");
      $this->db->query("UPDATE [lotes] SET registro_comision = 1 WHERE idLote = '".$row->idLote."'");
    }
  
  }//FIN DE IF VENTA COMPARTIDA
     
  
  else{ //INICIA ELSE DE VENTA NORMAL
    
    foreach ($QUERY_DATA_CONTRATACION->result() as $row) {

      $porcentajeAS = $this->db->query("SELECT porcentaje FROM porcentajes_comisiones WHERE relacion_prospeccion = ".$row->lugar_prospeccion." AND id_rol = 7");  
      $porcentajeCO = $this->db->query("SELECT porcentaje FROM porcentajes_comisiones WHERE relacion_prospeccion = ".$row->lugar_prospeccion." AND id_rol = 9");  
      $porcentajeGE = $this->db->query("SELECT porcentaje FROM porcentajes_comisiones WHERE relacion_prospeccion = ".$row->lugar_prospeccion." AND id_rol = 3");  
      $porcentajeSU = $this->db->query("SELECT porcentaje FROM porcentajes_comisiones WHERE relacion_prospeccion = ".$row->lugar_prospeccion." AND id_rol = 2");  
      $porcentajeDI = $this->db->query("SELECT porcentaje FROM porcentajes_comisiones WHERE relacion_prospeccion = ".$row->lugar_prospeccion." AND id_rol = 1");
      
      switch($row->lugar_prospeccion){
        case '6':
        case 6:
          $porcentajeOtros = $this->db->query("SELECT porcentaje FROM porcentajes_comisiones WHERE relacion_prospeccion = ".$row->lugar_prospeccion." AND id_rol = 38");
          $user_otro = 4394;
          $rol_otro = 38;
        break;

        case '12':
        case 12:
          $porcentajeOtros = $this->db->query("SELECT porcentaje FROM porcentajes_comisiones WHERE relacion_prospeccion = ".$row->lugar_prospeccion." AND id_rol = 42");
          $user_otro = 4615;
          $rol_otro = 42;
        break;
      }
             
      $porcentajeAS1 = ($porcentajeAS->row()->porcentaje);
      $porcentajeSU1 = ($porcentajeSU->row()->porcentaje);
      $porcentajeDI1 = ($porcentajeDI->row()->porcentaje);
      $porcentajeOtros1 = ($porcentajeOtros->row()->porcentaje);
      
      if($SUM_COORD==1){
        $porcentajeCO1 = ($porcentajeCO->row()->porcentaje);
      }else{
        $porcentajeCO1 = 0;
      }
      if($SUM_GERENTE==1){
        $porcentajeGE1 = ($porcentajeGE->row()->porcentaje);
      }else{
        $porcentajeGE1 = 0;
      }
      
      $TotComisionAS1 = ($porcentajeAS1*($row->totalNeto2/100));
      $TotComisionSU1 = ($porcentajeSU1*($row->totalNeto2/100));
      $TotComisionDI1 = ($porcentajeDI1*($row->totalNeto2/100));
      $TotComisionOtros1 = ($porcentajeOtros1*($row->totalNeto2/100));

      if($SUM_COORD==1){
        $TotComisionCO1 = ($porcentajeCO1*($row->totalNeto2/100));
      }else{
        $TotComisionCO1 = 0;
      }
      if($SUM_GERENTE==1){
        $TotComisionGE1 = ($porcentajeGE1*($row->totalNeto2/100));
      }else{
        $TotComisionGE1 = 0;
      }

      $porcentajes_comision =  $porcentajeAS1+$porcentajeCO1+$porcentajeGE1+$porcentajeSU1+$porcentajeDI1+$porcentajeOtros1;  
      $porcentajes_comision2 = $porcentajes_comision;
      $totalComision = $porcentajes_comision2*($row->totalNeto2/100); 

        //---------------------------------------------------------------------------------------------------------------------------------------
        $this->db->query("INSERT INTO [pago_comision](id_lote, total_comision, abonado, porcentaje_abono, pendiente, fecha_abono, creado_por, fecha_modificacion) VALUES(".$row->idLote.", ".$totalComision.", 0, ".$porcentajes_comision2.", ".$totalComision.", getdate(), 1, getdate())");
        // --------------------------------------------------------------------------------------------------------------------------------------
 
        $this->db->query("INSERT INTO [comisiones] ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$row->idLote.", ".$row->id_asesor.", ".$TotComisionAS1.", 1, 'NEODATA TIT ASE O1', NULL, NULL, 0, GETDATE(), ".$porcentajeAS1.", GETDATE(), 7)");
        if($SUM_COORD==1){
          $this->db->query("INSERT INTO [comisiones] ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$row->idLote.", ".$row->id_coordinador.", ".$TotComisionCO1.", 1, 'NEODATA TIT COR O1', NULL, NULL, 0, GETDATE(), ".$porcentajeCO1.", GETDATE(), 9)");
         }
         if($SUM_GERENTE == 1){
          $this->db->query("INSERT INTO [comisiones] ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$row->idLote.", ".$row->id_gerente.", ".$TotComisionGE1.", 1, 'NEODATA TIT GER O1', NULL, NULL, 0, GETDATE(), ".$porcentajeGE1.", GETDATE(), 3)");
         }
        $this->db->query("INSERT INTO [comisiones] ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$row->idLote.", ".$row->id_subdirector.", ".$TotComisionSU1.", 1, 'NEODATA TIT SUB O1', NULL, NULL, 0, GETDATE(), ".$porcentajeSU1.", GETDATE(), 2)");
        $this->db->query("INSERT INTO [comisiones] ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$row->idLote.", ".$row->id_director.", ".$TotComisionDI1.", 1, 'NEODATA TIT DIR O1', NULL, NULL, 0, GETDATE(), ".$porcentajeDI1.", GETDATE(), 1)");
        $this->db->query("INSERT INTO [comisiones] ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$row->idLote.", ".$user_otro.", ".$TotComisionOtros1.", 1, 'NEODATA OTRO O1', NULL, NULL, 0, GETDATE(), ".$porcentajeOtros1.", GETDATE(), ".$rol_otro.")");

        $this->gphsis->query("INSERT INTO [GPHSIS].[dbo].[Comisiones](
        [Referencia] ,[Saldoinicial],[Saldorestante],[Fechaultimoabono],[Montoultimoabono],[Idaplicacion],[Marca],[IdDesarrollo],[TotalAplicado],[USR],[AbonoContraloria] ,[idcontrato]) 
         VALUES ('".$row->referencia."',".$totalComision.", NULL, NULL, NULL, NULL, 100, '".$row->idResidencial."', NULL, NULL, NULL, NULL)");
      $this->db->query("UPDATE [lotes] SET registro_comision = 1 WHERE idLote = '".$row->idLote."'");
      } 

     } // FIN ELSE VENTA NORMAL

  }//FINAL IF

  else{
    $this->db->query("INSERT INTO [sin_dispersar] (id_lote, referencia, comentario, fecha_creacion) VALUES (NULL, NULL, 'NO SE ECONTRARON DATOS (insertar_gph_maderas 2)' , GETDATE())");
  }
}


 
  
public function select_gph_maderas_64(){ //HACER INSERT DE LOS LOTES EN 0 Y PASARLOS A 1

  $QUERY_DATA_GPHSIS = $this->gphsis->query(" SELECT * FROM [GPHSIS].[dbo].[Comisiones] WHERE Saldorestante IS NOT NULL AND Montoultimoabono IS NOT NULL AND Marca = 1 AND USR IS NOT NULL AND USR NOT IN (0) 
  AND Referencia NOT IN (0,  1140094,  1150622,  5001029,  8020331) and idDesarrollo = 12");
   
 echo "num rows".$QUERY_DATA_GPHSIS->num_rows();
  if($QUERY_DATA_GPHSIS->num_rows() > 0){
    // if($QUERY_DATA_GPHSIS->num_rows() > 0 and $QUERY_DATA_GPHSIS->num_rows() < 2){

      foreach ($QUERY_DATA_GPHSIS->result() as $row2) {
        
        $comparativa = $row2->Saldorestante-$row2->TotalAplicado;

          $query_lote = $this->Comisiones_model->getDataLote($row2->Referencia, $row2->IdDesarrollo);
          $new_lote = $query_lote->idLote;
          $new_plan = $query_lote->plan_enganche;

          
          if(empty($query_lote->plan_enganche)){
            echo 'NO TIENE PLAN<BR>';
          }
          else{

            echo "<BR>PLAN:".$new_plan;
            $new_plan = $query_lote->plan_enganche;
            $REVISAR_QUERY = $this->db->query("SELECT id_comision FROM pago_comision_ind WHERE id_comision IN (SELECT id_comision FROM comisiones WHERE id_lote = ".$new_lote.")");
        
        if($REVISAR_QUERY->num_rows()<1){
          //ENGANCHE
          $valor_tabla = 'porcentajes_enganche';
          $dispersar = $row2->TotalAplicado;
          $pauta_neodata = 0;
        }
        else{
          // MENSUALIDAD
          $valor_tabla = 'porcentajes_mensualidades';

          
  
            if($row2->Saldorestante<=0){
              $dispersar = $row2->USR;
              $pauta_neodata = 7;
            }
            else if($row2->Saldorestante>0){
              $dispersar = $row2->USR-$row2->Saldorestante;
              $pauta_neodata = 0;
            }
        }


        if(empty($query_lote))
        {
          echo '<br>'."NO HAY DATOS CON ESTA REFERENCIA";
        }
  
        else{        
                $busquedaAsesor =  $this->db->query("SELECT com.id_usuario, com.id_comision, pm.porcentaje FROM comisiones com INNER JOIN ".$valor_tabla." pm ON pm.id_rol = com.rol_generado WHERE com.id_lote = ".$new_lote." AND com.rol_generado = 7 AND pm.id_plan = ".$new_plan."");
                $busquedaCoordinador =  $this->db->query("SELECT com.id_usuario, com.id_comision, pm.porcentaje FROM comisiones com INNER JOIN ".$valor_tabla." pm ON pm.id_rol = com.rol_generado WHERE com.id_lote = ".$new_lote." AND com.rol_generado = 9 AND pm.id_plan = ".$new_plan."");
                $busquedaGerente =  $this->db->query("SELECT com.id_usuario, com.id_comision, pm.porcentaje FROM comisiones com INNER JOIN ".$valor_tabla." pm ON pm.id_rol = com.rol_generado WHERE com.id_lote = ".$new_lote." AND com.rol_generado = 3 AND pm.id_plan = ".$new_plan."");
                $busquedaSubdirector =  $this->db->query("SELECT com.id_usuario, com.id_comision, pm.porcentaje FROM comisiones com INNER JOIN ".$valor_tabla." pm ON pm.id_rol = com.rol_generado WHERE com.id_lote = ".$new_lote." AND com.rol_generado = 2 AND pm.id_plan = ".$new_plan."");
                $busquedaDirector =  $this->db->query("SELECT com.id_usuario, com.id_comision, pm.porcentaje FROM comisiones com INNER JOIN ".$valor_tabla." pm ON pm.id_rol = com.rol_generado WHERE com.id_lote = ".$new_lote." AND com.rol_generado = 1 AND pm.id_plan = ".$new_plan."");
                $busquedaMktd =  $this->db->query("SELECT com.id_usuario, com.id_comision, pm.porcentaje FROM comisiones com INNER JOIN ".$valor_tabla." pm ON pm.id_rol = com.rol_generado WHERE com.id_lote = ".$new_lote." AND com.rol_generado = 38 AND pm.id_plan = ".$new_plan."");

                $COUNTAsesor =  $this->db->query("SELECT COUNT(*) totalAsesor FROM comisiones com INNER JOIN ".$valor_tabla." pm ON pm.id_rol = com.rol_generado WHERE com.id_lote = ".$new_lote." AND com.rol_generado = 7 AND pm.id_plan = ".$new_plan."");
                $COUNTCoordinador =  $this->db->query("SELECT COUNT(*) totalCoordinador FROM comisiones com INNER JOIN ".$valor_tabla." pm ON pm.id_rol = com.rol_generado WHERE com.id_lote = ".$new_lote." AND com.rol_generado = 9 AND pm.id_plan = ".$new_plan."");
                $COUNTGerente =  $this->db->query("SELECT COUNT(*) totalGerente FROM comisiones com INNER JOIN ".$valor_tabla." pm ON pm.id_rol = com.rol_generado WHERE com.id_lote = ".$new_lote." AND com.rol_generado = 3 AND pm.id_plan = ".$new_plan."");
                $COUNTSubdirector =  $this->db->query("SELECT COUNT(*) totalSubdirector FROM comisiones com INNER JOIN ".$valor_tabla." pm ON pm.id_rol = com.rol_generado WHERE com.id_lote = ".$new_lote." AND com.rol_generado = 2 AND pm.id_plan = ".$new_plan."");
                $COUNTDirector =  $this->db->query("SELECT COUNT(*) totalDirector FROM comisiones com INNER JOIN ".$valor_tabla." pm ON pm.id_rol = com.rol_generado WHERE com.id_lote = ".$new_lote." AND com.rol_generado = 1 AND pm.id_plan = ".$new_plan."");
                $COUNTMarketing =  $this->db->query("SELECT COUNT(*) totalMarketing FROM comisiones com INNER JOIN ".$valor_tabla." pm ON pm.id_rol = com.rol_generado WHERE com.id_lote = ".$new_lote." AND com.rol_generado = 38 AND pm.id_plan = ".$new_plan."");

                $COUNTAS = $COUNTAsesor->row()->totalAsesor;
                $COUNTCO = $COUNTCoordinador->row()->totalCoordinador;
                $COUNTGE = $COUNTGerente->row()->totalGerente;
                $COUNTSU = $COUNTSubdirector->row()->totalSubdirector;
                $COUNTDI = $COUNTDirector->row()->totalDirector;
                $COUNTMK = $COUNTMarketing->row()->totalMarketing;

                if($busquedaAsesor->num_rows() > 0){

                  foreach($busquedaAsesor->result() as $as ){
                    $porcentajeASESORES = ($busquedaAsesor->row()->porcentaje)/($COUNTAS);
                    $insert_new =  ($dispersar/100)*($porcentajeASESORES);
                    $this->db->query("INSERT INTO [pago_comision_ind] (id_comision, id_usuario, abono_neodata, fecha_abono, fecha_pago_intmex, estatus, pago_neodata) VALUES (".$as->id_comision.", ".$as->id_usuario.", ".$insert_new.",  GETDATE(),  GETDATE(), 18, ".$dispersar.")");
                  }
                }
                
                if($busquedaCoordinador->num_rows() > 0){
                  // for($c = 0; $c<$busquedaCoordinador->num_rows(); $c++){
                    foreach($busquedaCoordinador->result() as $co ){
                    $porcentajeCOORDINADORES = ($busquedaCoordinador->row()->porcentaje)/($COUNTCO);
                    $insert_new =  ($dispersar/100)*($porcentajeCOORDINADORES);
                    $this->db->query("INSERT INTO [pago_comision_ind] (id_comision, id_usuario, abono_neodata, fecha_abono, fecha_pago_intmex, estatus, pago_neodata) VALUES (".$co->id_comision.", ".$co->id_usuario.", ".$insert_new.",  GETDATE(),  GETDATE(), 18, ".$dispersar.")");
                  }
                }
        
                if($busquedaGerente->num_rows() > 0){
                  // for($g = 0; $g<$busquedaGerente->num_rows(); $g++){
                    foreach($busquedaGerente->result() as $ge ){
                  $porcentajeGERENTES = ($busquedaGerente->row()->porcentaje)/($COUNTGE);
                  $insert_new =  ($dispersar/100)*($porcentajeGERENTES);
                  $this->db->query("INSERT INTO [pago_comision_ind] (id_comision, id_usuario, abono_neodata, fecha_abono, fecha_pago_intmex, estatus, pago_neodata) VALUES (".$ge->id_comision.", ".$ge->id_usuario.", ".$insert_new.",  GETDATE(),  GETDATE(), 18, ".$dispersar.")");
                }
              }

                if($busquedaSubdirector->num_rows() > 0){
                  // for($s = 0; $s<$busquedaSubdirector->num_rows(); $s++){
                    foreach($busquedaSubdirector->result() as $su ){
                  $porcentajeSUBDIRECTORES = ($busquedaSubdirector->row()->porcentaje)/($COUNTSU);
                  $insert_new =  ($dispersar/100)*($porcentajeSUBDIRECTORES);
                  $this->db->query("INSERT INTO [pago_comision_ind] (id_comision, id_usuario, abono_neodata, fecha_abono, fecha_pago_intmex, estatus, pago_neodata) VALUES (".$su->id_comision.", ".$su->id_usuario.", ".$insert_new.",  GETDATE(),  GETDATE(), 18, ".$dispersar.")");
                }
              }

                if($busquedaDirector->num_rows() > 0){
                  foreach($busquedaDirector->result() as $di ){
                  // for($d = 0; $d<$busquedaDirector->num_rows(); $d++){
                  $porcentajeDIRECTORES = ($busquedaDirector->row()->porcentaje)/($COUNTDI);
                  $insert_new =  ($dispersar/100)*($porcentajeDIRECTORES);
                  $this->db->query("INSERT INTO [pago_comision_ind] (id_comision, id_usuario, abono_neodata, fecha_abono, fecha_pago_intmex, estatus, pago_neodata) VALUES (".$di->id_comision.", ".$di->id_usuario.", ".$insert_new.",  GETDATE(),  GETDATE(), 18, ".$dispersar.")");
                }
              }

                if($busquedaMktd->num_rows() > 0){
                  // for($mk = 0; $mk<$busquedaMktd->num_rows(); $mk++){
                    foreach($busquedaMktd->result() as $mk ){
                  $porcentajeMKTD = ($busquedaMktd->row()->porcentaje)/($COUNTMK);
                  $insert_new =  ($dispersar/100)*($porcentajeMKTD);
                  $this->db->query("INSERT INTO [pago_comision_ind] (id_comision, id_usuario, abono_neodata, fecha_abono, fecha_pago_intmex, estatus, pago_neodata) VALUES (".$mk->id_comision.", ".$mk->id_usuario.", ".$insert_new.",  GETDATE(),  GETDATE(), 18, ".$dispersar.")");
                }
              }
              $consultar_referencia = $this->db->query("SELECT referencia FROM lotes lot WHERE lot.idLote = ".$new_lote."");
              $REF_001 = $consultar_referencia->row()->referencia;
              $this->gphsis->query("UPDATE [GPHSIS].[dbo].[Comisiones] SET Marca = ".$pauta_neodata." WHERE Referencia = ".$REF_001." AND Saldorestante IS NOT NULL AND Montoultimoabono IS NOT NULL AND Marca IN (1)");

        }//fin else si hay datos 
      }//END ELSE SI TIENE PLAN DE ENGANCHE
    }//FIN PRIMER FOREACH
  }// FIN IF NUM ROWS ES MAYOR A 0
  else{
    return '';
  }

}//FIN DE LA FUNCION

  
  

  //////////////

/*****Fncion para enviar el correo de las evidencias rechazadas******/
    function sendMailReportER()
    {
      $users_array = $this->scheduleTasks_model->getUsersList();
      for ($i = 0; $i < count($users_array); $i++) {
        $rol = explode(", ", $users_array[$i]['id_sede']);
        $result = "'" . implode("', '", $rol) . "'";
        if ($users_array[$i]['id_rol'] == 19 || $users_array[$i]['id_rol'] == 20){ // MJ: SE TRAEN LOS RECHAZOS HECHOS POR COBRANZA PARA SUBDIRECTOR (19) Y GERNETE MKTD (20)
          $data_rechazo_cobranza = $this->scheduleTasks_model->getRejectList($result, '10', $users_array[$i]['id_rol']); // MJ: MANDA 3 PARÁMETRROS; ID_sEDE, TIPO_RECHAZO (10 COBRANZA | 20 CONTRALORÍA)
          if (count($data_rechazo_cobranza) > 0) {
            $data_enviar_mail = $this->notifyRejEv($users_array[$i]['correo'], $data_rechazo_cobranza, 'REPORTE SEMANA ' . date("W") . ' COBRANZA ', $users_array[$i]['id_rol']);
            //echo $data_enviar_mail;
            if ($data_enviar_mail > 0) {
              $data_request['msg'] = 'Correo enviado correctamente.';
            } else {
              $data_request['msg'] = 'Correo no enviado.';
            }
          } else {
            $data_request['msg'] = 'No hay registros para enviar un correo.';
          }
        }
        if ($users_array[$i]['id_rol'] == 19 || $users_array[$i]['id_rol'] == 28){ // MJ: SE TRAEN LOS RECHAZOS HECHOS POR CONTRALORÍA PARA SUBDIRECTOR (19) Y COBRANZA (28)
          $data_rechazo_contraloria = $this->scheduleTasks_model->getRejectList($result, '20', $users_array[$i]['id_rol']); // MJ: MANDA 3 PARÁMETRROS; ID_SEDE, TIPO_RECHAZO (10 COBRANZA | 20 CONTRALORÍA)
          if (count($data_rechazo_contraloria) > 0) {
            $data_enviar_mail = $this->notifyRejEv($users_array[$i]['correo'], $data_rechazo_contraloria, 'REPORTE SEMANA ' . date("W") . ' CONTRALORÍA ', $users_array[$i]['id_rol']);
            //echo $data_enviar_mail;
            if ($data_enviar_mail > 0) {
              $data_request['msg'] = 'Correo enviado correctamente.';
            } else {
              $data_request['msg'] = 'Correo no enviado.';
            }
          } else {
            $data_request['msg'] = 'No hay registros para enviar un correo.';
          }
        }
        if ($users_array[$i]['id_rol'] == 32){ // MJ: SE TRAEN LOS LOTES DONDE SE INDICÓ QUE NO ERA UNA VENTA DE MKTD
          $data_rechazo_mktd = $this->scheduleTasks_model->getRejectList($result, '0', $users_array[$i]['id_rol']); // MJ: MANDA 3 PARÁMETRROS; ID_SEDE, TIPO_RECHAZO (10 COBRANZA | 20 CONTRALORÍA)
          if (count($data_rechazo_mktd) > 0) {
            $data_enviar_mail = $this->notifyRejEv($users_array[$i]['correo'], $data_rechazo_mktd, 'REPORTE SEMANA ' . date("W") . ' CONTRALORÍA (ELIMINADOS DE LA LISTA MKTD)', $users_array[$i]['id_rol']);
            //echo $data_enviar_mail;
            if ($data_enviar_mail > 0) {
              $data_request['msg'] = 'Correo enviado correctamente.';
            } else {
              $data_request['msg'] = 'Correo no enviado.';

            }
          } else {
            $data_request['msg'] = 'No hay registros para enviar un correo.';
          }
        }
        if ($data_request != null) {
          echo json_encode($data_request);
        } else {
          echo json_encode(array());
        }
      }
    }

    public function notifyRejEv($correo, $data_eviRec, $subject, $userType) {
        $correo_test= 'programador.analista8@ciudadmaderas.com';/*se coloca el correo de testeo para desarrollo*/
        /*$correoDir = $dataUser[0]->correo;linea de codigo para produccion*/
        $mail = $this->phpmailer_lib->load();
        $mail->isSMTP();
        $mail->Host     = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'no-reply@ciudadmaderas.com';
        $mail->Password = 'Va7<*V8PP';
        $mail->SMTPSecure = 'ssl';
        $mail->Port     = 465;
        $mail->setFrom('no-reply@ciudadmaderas.com', 'Ciudad Maderas');
        $mail->addAddress($correo);
        $mail->Subject = $subject;
        $mail->isHTML(true);
        $mailContent = "<html><head>
          <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
          <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>
          <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'> 
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
          <img src='".base_url()."static/images/mailER/header9@4x.png' width='100%'>
          <table align='center' cellspacing='0' cellpadding='0' border='0' width='100%'> <br><br>";

              if ($userType == 32) { // CONTRALORÍA
              $mailContent .= "
              <tr>
                <td border=1 bgcolor='#FFFFFF' align='center'> 
                    <h3>¡ Buenos días estimad@ !</h3><br> <br>
                    
                    <p style='padding: 10px 90px;text-align: justify;'>¿Cómo estás?, espero que bien, te adjunto el reporte semanal de las evidencias donde se removió <b>marketing digital</b> de la venta, te invito a leer las observaciones.
                    </p><br><br>
                    
                    
                </td>
              </tr>
              <tr>
                <td border=1 bgcolor='#FFFFFF' align='center'>  
                  <center><table id='reporyt' cellpadding='0' cellspacing='0' border='1' width ='100%' style class='darkheader'>
                    <tr class='active' style='text-align: center'>
                      <th>ID lote</th>   
                      <th>Lote</th>   
                      <th>Comentario</th>   
                      <th>Cliente</th>   
                      <th>Usuario</th>   
                      <th>Fecha</th>   
                    </tr>";
                      for($p=0; $p < count($data_eviRec); $p++)
                      {
                          $mailContent .= '<tr>';
                          $mailContent .= '    <td><center>'.$data_eviRec[$p]['idLote'].'</center></td>';
                          $mailContent .= '    <td><center>'.$data_eviRec[$p]['nombreLote'].'</center></td>';
                          $mailContent .= '    <td><center>'.$data_eviRec[$p]['observacion'].'</center></td>';
                          $mailContent .= '    <td><center>'.$data_eviRec[$p]['nombreCliente'].'</center></td>';
                          $mailContent .= '    <td><center>'.$data_eviRec[$p]['nombreSolicitante'].'</center></td>';
                          $mailContent .= '    <td><center>'.$data_eviRec[$p]['fecha_creacion'].'</center></td>';
                          $mailContent .= '</tr>';
                      }
                      $mailContent .= "</table></center>
                    <br><br>
                </td>
              </tr>";
            } else { // MKTD
              $mailContent .= "
              <tr>
                <td border=1 bgcolor='#FFFFFF' align='center'> 
                    <h3>¡ Buenos días estimad@ !</h3><br> <br>
                    
                    <p style='padding: 10px 90px;text-align: justify;'>¿Cómo estás?, espero que bien, te adjunto el reporte semanal de las evidencias rechazadas por
                        <b>cobranza/contraloría</b>, te invito a leer las observaciones. Recuerda que deben ser corregidas a más
                        tardar los jueves a las 12:00 PM, con esto ayudas a que el proceso en cobranza sea en tiempo y forma,
                        dando como resultado el cobro a tiempo de las comisiones.
                    </p><br><br>
                    
                    
                </td>
              </tr>
              <tr>
                <td border=1 bgcolor='#FFFFFF' align='center'>  
                  <center><table id='reporyt' cellpadding='0' cellspacing='0' border='1' width ='100%' style class='darkheader'>
                    <tr class='active' style='text-align: center'>
                      <th>Número semana</th>   
                      <th>Plaza</th>   
                      <th>Solicitante</th>   
                      <th>Lote</th>   
                      <th>Comentario</th>   
                      <th>Fecha creación</th>   
                      <th>Fecha rechazo</th>   
                    </tr>";
                      for($p=0; $p < count($data_eviRec); $p++)
                      {
                          $mailContent .= '<tr>';
                          $mailContent .= '    <td><center>'.$data_eviRec[$p]['weekNumber'].'</center></td>';
                          $mailContent .= '    <td><center>'.$data_eviRec[$p]['plaza'].'</center></td>';
                          $mailContent .= '    <td><center>'.$data_eviRec[$p]['nombreSolicitante'].'</center></td>';
                          $mailContent .= '    <td><center>'.$data_eviRec[$p]['nombreLote'].'</center></td>';
                          $mailContent .= '    <td><center>'.$data_eviRec[$p]['comentario_autorizacion'].'</center></td>';
                          $mailContent .= '    <td><center>'.$data_eviRec[$p]['fecha_creacion'].'</center></td>';
                          $mailContent .= '    <td><center>'.$data_eviRec[$p]['fechaRechazo'].'</center></td>';
                          $mailContent .= '</tr>';
                      }
                      $mailContent .= "</table></center>
                    <br><br>
                </td>
              </tr>";
            }
          $mailContent .= "</table>
          <img src='".base_url()."static/images/mailER/footer@4x.png' width='100%'>
          </body></html>";

        $mail->Body = utf8_decode($mailContent);
        //return $mailContent;
        if($mail->send()){return 1;} else{return $mail->ErrorInfo;}
    }

    public function mailContentComptrollerNotification()
    {
      $date = date("Y-m-d");
      $mod_date = strtotime($date."- 1 days");
      $finalDate = date("Y-m-d", $mod_date);
      $data_first_report = $this->scheduleTasks_model->getReportInformation(1, $finalDate);
      $data_second_report = $this->scheduleTasks_model->getReportInformation(2, $finalDate);
      // MJ: FIRST EMAIL - ESTATUS 10
      if (count($data_first_report) > 0) {
        $data_enviar_mail = $this->sendComptrollerNotification($data_first_report, 'REPORTE ESTATUS 10 ' . $finalDate, 1);
        //echo $data_enviar_mail;
        if ($data_enviar_mail > 0) {
          $data_request['msg'] = 'Correo enviado correctamente.';
          echo $data_request['msg'];
        } else {
          $data_request['msg'] = 'Correo no enviado.';
          echo $data_request['msg'];
        }
      } else {
        $data_request['msg'] = 'No hay registros para enviar un correo.';
        echo $data_request['msg'];
      }

      // MJ: SECOND EMAIL - LIBERACIONES
      if (count($data_second_report) > 0) {
        $data_enviar_mail = $this->sendComptrollerNotification($data_second_report, 'REPORTE LOTES PARA LIBERAR ' . $finalDate, 2);
        //echo $data_enviar_mail;
        if ($data_enviar_mail > 0) {
          $data_request['msg'] = 'Correo enviado correctamente.';
          echo $data_request['msg'];
        } else {
          $data_request['msg'] = 'Correo no enviado.';
          echo $data_request['msg'];
        }
      } else {
        $data_request['msg'] = 'No hay registros para enviar un correo.';
        echo $data_request['msg'];
      }

    }

    public function sendComptrollerNotification($data_eviRec, $subject, $typeTransaction)
    {
        $mail = $this->phpmailer_lib->load();
        $mail->isSMTP();
        // $mail->SMTPDebug = 3;
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'no-reply@ciudadmaderas.com';
        $mail->Password = 'Va7<*V8PP';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('no-reply@ciudadmaderas.com', 'Ciudad Maderas');
        //$mail->addAddress('coord.desarrollo2@ciudadmaderas.com');
        $mail->addAddress('asistente.pv2@ciudadmaderas.com');
        $mail->addAddress('coord.contraloriacorporativa@ciudadmaderas.com');
        $mail->addAddress('subdirector.contraloria@ciudadmaderas.com');
        $mail->Subject = $subject;
        $mail->isHTML(true);
        $mailContent = "<html><head>
          <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
          <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>
          <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'> 
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
          <img src='" . base_url() . "static/images/mailER/header9@4x.png' width='100%'>
          <table align='center' cellspacing='0' cellpadding='0' border='0' width='100%'> <br><br>";

        if ($typeTransaction == 1) { // MJ: REPORTE ESTATUS 10
            $mailContent .= "
              <tr>
                <td border=1 bgcolor='#FFFFFF' align='center'> 
                    <h3>¡ Buenos días estimad@ !</h3><br> <br>
                    
                    <p style='padding: 10px 90px;text-align: center;'>¿Cómo estás?, espero que bien. Este es el listado de todos los registros de lotes cuyo contrató se envió a firma de RL.
                    </p><br><br>
                    
                    
                </td>
              </tr>
              <tr>
                <td border=1 bgcolor='#FFFFFF' align='center'>  
                  <center><table id='reporyt' cellpadding='0' cellspacing='0' border='1' width ='100%' style class='darkheader'>
                    <tr class='active' style='text-align: center'>
                      <th>SEDE</th>   
                      <th>PROYECTO</th>   
                      <th>CONDOMINIO</th>   
                      <th>LOTE</th>   
                      <th>CLIENTE</th>   
                      <th>SUPERFICIE</th>   
                      <th>REFERENCIA</th>   
                      <th>GERENTE</th>   
                      <th>ASESOR</th>   
                      <th>ESTATUS</th>   
                      <th>FECHA APARTADO</th>   
                    </tr>";
            for ($p = 0; $p < count($data_eviRec); $p++) {
                $mailContent .= '<tr>';
                $mailContent .= '    <td><center>' . $data_eviRec[$p]['nombreSede'] . '</center></td>';
                $mailContent .= '    <td><center>' . $data_eviRec[$p]['nombreResidencial'] . '</center></td>';
                $mailContent .= '    <td><center>' . $data_eviRec[$p]['nombreCondominio'] . '</center></td>';
                $mailContent .= '    <td><center>' . $data_eviRec[$p]['nombreLote'] . '</center></td>';
                $mailContent .= '    <td><center>' . $data_eviRec[$p]['nombreCliente'] . '</center></td>';
                $mailContent .= '    <td><center>' . $data_eviRec[$p]['sup'] . '</center></td>';
                $mailContent .= '    <td><center>' . $data_eviRec[$p]['referencia'] . '</center></td>';
                $mailContent .= '    <td><center>' . $data_eviRec[$p]['nombreGerente'] . '</center></td>';
                $mailContent .= '    <td><center>' . $data_eviRec[$p]['nombreAsesor'] . '</center></td>';
                $mailContent .= '    <td><center>' . $data_eviRec[$p]['estatusLote'] . '</center></td>';
                $mailContent .= '    <td><center>' . $data_eviRec[$p]['fechaApartado'] . '</center></td>';
                $mailContent .= '</tr>';
            }
            $mailContent .= "</table></center>
                    <br><br>
                </td>
              </tr>";
        } else if ($typeTransaction == 2) { // MJ: REPORTE LIBERACIONES
            $mailContent .= "
              <tr>
                <td border=1 bgcolor='#FFFFFF' align='center'> 
                    <h3>¡ Buenos días estimad@ !</h3><br> <br>
                    
                    <p style='padding: 10px 90px;text-align: center;'>¿Cómo estás?, espero que bien. Este es el listado de todos los registros de lotes que se marcaron para liberación.
                    </p><br><br>
                    
                    
                </td>
              </tr>
              <tr>
                <td border=1 bgcolor='#FFFFFF' align='center'>  
                  <center><table id='reporyt' cellpadding='0' cellspacing='0' border='1' width ='100%' style class='darkheader'>
                    <tr class='active' style='text-align: center'>
                      <th>PROYECTO</th>   
                      <th>CONDOMINIO</th>   
                      <th>LOTE</th>   
                      <th>SUPERFICIE</th>   
                      <th>REFERENCIA</th>   
                      <th>GERENTE</th>   
                      <th>ASESOR</th>   
                      <th>ESTATUS</th>   
                      <th>FECHA APARTADO</th>  
                      <th>FECHA LIBERACIÓN</th>  
                    </tr>";
            for ($p = 0; $p < count($data_eviRec); $p++) {
                $mailContent .= '<tr>';
                $mailContent .= '    <td><center>' . $data_eviRec[$p]['nombreResidencial'] . '</center></td>';
                $mailContent .= '    <td><center>' . $data_eviRec[$p]['nombreCondominio'] . '</center></td>';
                $mailContent .= '    <td><center>' . $data_eviRec[$p]['nombreLote'] . '</center></td>';
                $mailContent .= '    <td><center>' . $data_eviRec[$p]['sup'] . '</center></td>';
                $mailContent .= '    <td><center>' . $data_eviRec[$p]['referencia'] . '</center></td>';
                $mailContent .= '    <td><center>' . $data_eviRec[$p]['nombreGerente'] . '</center></td>';
                $mailContent .= '    <td><center>' . $data_eviRec[$p]['nombreAsesor'] . '</center></td>';
                $mailContent .= '    <td><center>' . $data_eviRec[$p]['estatusLote'] . '</center></td>';
                $mailContent .= '    <td><center>' . $data_eviRec[$p]['fechaApartado'] . '</center></td>';
                $mailContent .= '    <td><center>' . $data_eviRec[$p]['fechaLiberacion'] . '</center></td>';
                $mailContent .= '</tr>';
            }
            $mailContent .= "</table></center>
                    <br><br>
                </td>
              </tr>";
        }
        $mailContent .= "</table>
          <img src='" . base_url() . "static/images/mailER/footer@4x.png' width='100%'>
          </body></html>";

        $mail->Body = utf8_decode($mailContent);
        //return $mailContent;
        if ($mail->send()) {
            return 1;
        } else {
            return $mail->ErrorInfo;
        }
    }

    // public function interesMenos(){
    //   $data = $this->scheduleTasks_model->interesMenos()->result_array();

    //   for ($i = 0; $i < count($data); $i++) {
    //     $updateArrayData[] = array(
    //         'idCondominio' => $data[$i]['idCondominio'],
    //         'msni' => $data[$i]['msni'] - 1
    //     );
    //   }
    //   $response = $this->db->update_batch('condominios', $updateArrayData, 'idCondominio');
    //   echo json_encode($response);
    // }

    public function interesMenos(){
      $data = $this->scheduleTasks_model->interesMenos();

      $response = $this->db->update_batch('condominios', $data, 'idCondominio');
      echo json_encode($response);
    }

    public function changePassword(){
      $idUser = $this->session->userdata('id_usuario');
      $contrasena = $_POST['contrasena']

      $this->SheduleTasks_model->passwordChange($contrasena, $idUser);
    }

}
