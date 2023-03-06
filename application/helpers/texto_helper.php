<?php

use PHPMailer\PHPMailer\PHPMailer;

    function limpiar_dato($dato){
        $limpia = "";

        if($dato && $dato != " "){
            
            //DIVIDO LA CADENA POR LOS ESPACIOS QUE TENGA
            $parts = preg_split("/[\s*]+/",$dato);
            
            $palabras = 0;
            
            foreach($parts as $subcadena){ 
                //ELIMINO LOS ESPACIOS QUE TENGA
                $subcadena = trim($subcadena); 
                //LUEGO LOS VUELVO A UNIR OMITO SOLO LOS QUE UNICAMENTE SEAN ESPACIOS
                if($subcadena != "" && $subcadena != " "){
                    $limpia .= $subcadena;
                }
                
                $palabras++;
                if($palabras < count($parts) && $parts[$palabras] != " " && $parts[$palabras] != "")
                    $limpia .= " ";
            }
            
            $limpia = strtoupper(str_replace(array('á', 'é', 'í', 'ó', 'ú', 'Á',  'É',  'Í',  'Ó',  'Ú'), array('a', 'e', 'i', 'o', 'u', 'A',  'E',  'I',  'O',  'U'), $limpia));
        }

        return $limpia ? $limpia : null ;
    }	

	function encriptar($texto_encriptar){
        return openssl_encrypt($texto_encriptar, 'AES-128-CBC', 'S1ST3MA_6E5T0R_RH_C1UD4D_MAD3RA5', 0, '8102cdmqsd0912vs');
	}
	function pruebaEncriptar($password)
	{
		return 'hola mundo esto es una prueba: '.$password;
	}
	function desencriptar($texto_desencriptar){
		return openssl_decrypt($texto_desencriptar, 'AES-128-CBC', 'S1ST3MA_6E5T0R_RH_C1UD4D_MAD3RA5', 0, '8102cdmqsd0912vs');
	}

    function guardar_observacion( $id_usuario, $id_cliente, $observacion ){
		$CI = get_instance();
        $CI->load->model('Model_Clientes');
        
        $data = array(
            "creado_por" => $id_usuario,
            "id_cliente" => $id_cliente,
            "observacion" => $observacion
        );

		$CI->Model_Clientes->guardar_observacion( $data );
    }

	function eliminar_acentos($String){
	    $String = str_replace(array('á','à','â','ã','ª','ä'),"a",$String);
	    $String = str_replace(array('Á','À','Â','Ã','Ä'),"A",$String);
	    $String = str_replace(array('Í','Ì','Î','Ï'),"I",$String);
	    $String = str_replace(array('í','ì','î','ï'),"i",$String);
	    $String = str_replace(array('é','è','ê','ë'),"e",$String);
	    $String = str_replace(array('É','È','Ê','Ë'),"E",$String);
	    $String = str_replace(array('ó','ò','ô','õ','ö','º'),"o",$String);
	    $String = str_replace(array('Ó','Ò','Ô','Õ','Ö'),"O",$String);
	    $String = str_replace(array('ú','ù','û','ü'),"u",$String);
	    $String = str_replace(array('Ú','Ù','Û','Ü'),"U",$String);
	    $String = str_replace(array('[','^','´','`','¨','~',']','%'),"",$String);
	    $String = str_replace("ç","c",$String);
	    $String = str_replace("Ç","C",$String);
	    $String = str_replace("ñ","n",$String);
	    $String = str_replace("Ñ","N",$String);
	    $String = str_replace("Ý","Y",$String);
	    $String = str_replace("ý","y",$String);

	    $String = str_replace("&aacute;","a",$String);
	    $String = str_replace("&Aacute;","A",$String);
	    $String = str_replace("&eacute;","e",$String);
	    $String = str_replace("&Eacute;","E",$String);
	    $String = str_replace("&iacute;","i",$String);
	    $String = str_replace("&Iacute;","I",$String);
	    $String = str_replace("&oacute;","o",$String);
	    $String = str_replace("&Oacute;","O",$String);
	    $String = str_replace("&uacute;","u",$String);
	    $String = str_replace("&Uacute;","U",$String);
	    return $String;
	}
	function delete_img($path_to, $img)
	{
	    $path_to = str_replace('\\', '/', $path_to);
	    if (file_exists($path_to.$img)) {
	        //borrar archivo
	        unlink($path_to.$img);
	        $resp = 'El archivo '.$img.' ha sido borrado.';
	    } else {
	        $resp = 'El archivo no existe';
	    }
	    return $resp;
	}

	function crearPlantillaCorreo($correos_submit = null, $data_eviRec = null, $data_mail,
											$data_encabezados_tabla = null, $comentarioGeneral= null){


			require_once APPPATH.'third_party/PHPMailer/Exception.php';
			require_once APPPATH.'third_party/PHPMailer/PHPMailer.php';
			require_once APPPATH.'third_party/PHPMailer/SMTP.php';

			$mail = new PHPMailer();
			//$correos_submit: array con correos a los que se va a enviar EJ: $correos_submit[0] = 'programador.analista8@ciudadmaderas.com';
			//$data_eviRec: datos para colocar tipo: Id Lote: $data_eviRec['tipo_lote]
			//$data_encabezados_etiquetas: Un arreglo con los nombre de los labels EJ: ID LOTE
			//$data_encabezados_tabla: Arreglo con los encabezados
			//$data_mail: Arreglo con los datos de la tabla con el tipo $data_mail[0]=array(...), $data_mail[1] = array(...)
			//IMPORTANTE: si tu correo no tiene 'comentario general', 'tabla' o 'etiquetas', aún así debes mandar el arreglo-
			//pero vacio ya que la funcion recibe los parámetros
			$etiquetas =  !is_null($data_eviRec)? generaEtiquetas($data_eviRec): null;
			$tabla = !is_null($data_mail) ? generaTabla($data_encabezados_tabla, $data_mail): null;
			$html_correo = correoDisenio($etiquetas, $tabla, !is_null($comentarioGeneral) ? $comentarioGeneral : '');
			return $html_correo;
			// SMTP configuration
			// $mail->isSMTP();
			// $mail->Host = 'smtp.gmail.com';
			// $mail->SMTPAuth = true;
			// $mail->Username = 'no-reply@ciudadmaderas.com';
			// $mail->Password = 'JDe64%8q5D';
			// $mail->SMTPSecure = 'ssl';
			// $mail->Port = 465;
			// $mail->setFrom('no-reply@ciudadmaderas.com', 'Ciudad Maderas');
			// if(is_array($correos_submit)){
			// 	foreach($correos_submit as $item){
			// 		$mail->addAddress($item);
			// 	}
			// }else{
			// 	$mail->addAddress($correos_submit);
			// }

			// $mail->Subject = utf8_decode($data_eviRec['comentario'].' --- 2');
			// $mail->isHTML(true);
			// $mail->Body = utf8_decode($html_correo);

			// if ($mail->send()) {
			// 	return($html_correo);
			// } else {
			// 	return $mail->ErrorInfo;
			// }
	}

	function correoDisenio($etiquetas_generadas, $tabla_generada, $comentarioGeneral){
		$correo_disenio =
		'
		<html>
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
				<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
						integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
			</head>
			<div style="background:#00263A;">
				<center>
					<img style="width:40%;padding-top: 40px; margin-bottom:30px"
					src="https://maderascrm.gphsis.com/static/images/Logo_CM_white.png">
				</center>
			</div>
			<body style="background:#00263A; font-family: sans-serif; margin: 0px;"
						marginheight="0"
						topmargin="0"
						marginwidth="0"
						leftmargin="0">
				<div style="background:#ffffff; border-radius: 10px; padding: 40px; width: 70%; margin:auto;">

					<p style="text-align:center; font-weight: 100; font-size: 20px; margin-top: 4px; margin-bottom: 10px;">Estimado usuario</p>';
					
					$correo_disenio .= '
						<div style="display:flex;">'
							.$etiquetas_generadas.
						'</div>';

					'<div style= "padding: 30px 20px 20px;">';
						$correo_disenio .= ($comentarioGeneral!='') ? '<p class="comentario">'.$comentarioGeneral.'</p>':'';
						$correo_disenio .=  !is_null($tabla_generada)? $tabla_generada.'<br><br>' : '';
					$correo_disenio .= '</div>';
					$correo_disenio .= '
					
					<div style="color:#f9; text-align:center;  margin-top: 30px; padding-bottom: 40px;">
						<p style="margin: 0px; color: #8d8d8d; font-size:10px;">
							¡Saludos!
							<br>Este correo fue generado de manera automática, te pedimos no respondas este correo, para cualquier duda o aclaración envía un correo a soporte@ciudadmaderas.com
							<br>Al ingresar tus datos aceptas la política de privacidad, términos y condiciones las cuales pueden ser consultadas en nuestro sitio www.ciudadmaderas.com/legal
						</p>
						<h6 style="font-size:10px; text-align:center; color: #8d8d8d; margin-top: 10px; margin-bottom: 30px;">';
							$correo_disenio .= date('Y').' | Departamento TI
						</h6>';
						$correo_disenio .=
						'
					</div>
				</div>
				<div class="yj6qo"></div>
				<div class="adL"></div>
				<div class="adL"></div>
				<div id=":nx" class="ii gt" style="display:none">
					<div id=":ny" class="a3s aiL undefined"></div>
				</div>
				<div class="hi"></div>
				<div class="ajx"></div>
				
			</body>
		</html>';
		return  $correo_disenio;
	}

	function generaTabla($data_encabezados_tabla, $data_mail){
		$contenidoHtml = '<center><table cellpadding=\'0\' cellspacing=\'0\' border=\'1\'
								style=\'border:none;
									margin:auto;
									display: block;
									overflow-x: auto;
									width: fit-content;\' >
							<tr class=\'active\' style=\'text-align: center; border:none; background: #ffffff\'>';
		foreach ($data_encabezados_tabla as $index=>$item) {
			$contenidoHtml .='<th style=\'border-top: none;
										border-bottom: none;
										border-right: none;
    									border-left: none;
										color: #333;
										white-space: nowrap;
										padding: 10px;
										font-size: 9px;
										font-weight: 100;
										background: #eaeaea\'>'.$item.'</th>';
		}
		$contenidoHtml .='</tr>';
		for ($i=0; $i<count($data_mail); $i++) {
			$contenidoHtml .= '<tr style=\'text-align: center; border: none; font-size: 12px;background: #ffffff\'>';
			
			foreach ($data_mail[$i] as $item){
				$contenidoHtml .= '<td style=\' box-sizing: border-box;
												border: 1px solid white;
												border-top: 2px solid #eaeaea;
												padding: 10px 15px;
												font-size: 12px\'>
										<center>' . $item. '</center>
									</td>';
			}
			$contenidoHtml .= '</tr>';
		}
		$contenidoHtml .= ' </table></center>';
		return $contenidoHtml;
	}
	function generaEtiquetas($datos_etiquetas){
		//$contenidoHtml = '<p>';
		$contenidoHtml = '<table style="width: 100%; border: none; text-align: center;"><tr>';
		foreach($datos_etiquetas as $index => $item){
			if($index !== 'comentario'){
				$contenidoHtml .= 
					'<td>
						<label style="text-transform: uppercase; font-size:12px">
							<b>'.strtoupper(str_replace('_', ' ', $index)).'</b> '.$item.'
						</label>
					</td>';
			}
		}
		$contenidoHtml .='</tr></table>';
		return $contenidoHtml;
	}
?>