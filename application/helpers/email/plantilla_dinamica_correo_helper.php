<?php

class plantilla_dinamica_correo
{
	function crearPlantillaCorreo($correos_entregar, $elementos_correo, $datos_correo, $datos_encabezados_tabla, 
								  $datos_etiquetas = null, $comentario_general, array $archivo_adjunto = null){
		
		$phpMailer = new PHPMailer_Lib;
		$email = $phpMailer->load();
		$tipo_estilo_tabla = count($datos_encabezados_tabla);

		$etiquetas =  !is_null($datos_etiquetas)? $this->generaEtiquetas($datos_etiquetas): null;
		$tabla = !is_null($datos_correo) ? $this->generaTabla($datos_encabezados_tabla, $datos_correo): null;
		$html_correo = $this->correoDisenio($etiquetas, $tabla, !is_null($comentario_general) ? $comentario_general : '', $tipo_estilo_tabla);
		foreach ($elementos_correo as $key => $value) {
			if (is_array($value)){
				if($key === 'setFrom'){
					$email->setFrom(implode(", ", $value));
				}
			}else{
				if($key === 'Subject'){
					$email->Subject = utf8_decode($value);
				}
			}
		}

		if (is_array($correos_entregar)) {
			foreach ($correos_entregar as $correo) {
				$email->addAddress($correo);
			}
		}else{
			$email->addAddress($correos_entregar);
		}
		
		$email->isHTML(true);
		$email->Body = utf8_decode($html_correo);
		
		if(!empty($archivo_adjunto) || !is_null($archivo_adjunto)){
			$email->AddStringAttachment($archivo_adjunto['adjunto'], $archivo_adjunto['nombre_pdf']);
		}
		
		if ($email->send()) {
			return 1;
		}else {
			return $email->ErrorInfo;
		}
	}

	function correoDisenio($etiquetas_generadas, $tabla_generada, $comentario_general, $tipo_estilo_tabla){
		$tipo_estilo_tabla > 7 
			?	$estilo_css	=	'<style type=text/css>
									table {
										border:none;
										margin:auto;
										display: block;
										overflow-x: auto;
									}
									.encabezados{
										box-sizing: border-box;
										border: 1px solid white;
										border-top: 2px solid #eaeaea;
										padding: 10px 15px;
										font-size: 12px
									}
								</style>'
			:	$estilo_css	=	'<style type=text/css>
									table {
										border:none;
										margin:auto;
										display: block;
										overflow-x: auto;
										width: fit-content;
									}
									.encabezados{
										box-sizing: border-box;
										border: 1px solid white;
										border-top: 2px solid #eaeaea;
										padding: 10px 15px;
										font-size: 12px
									}
								</style>';
		$correo_disenio =
		'<html>
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
				<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
				 integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
				'.$estilo_css.'
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
						$correo_disenio .= ($comentario_general!='') ? '<p style="text-align: center;">'.$comentario_general.'</p>':'';
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

	function generaTabla($datos_encabezados_tabla, $datos_correo){ 
		$contenidoHtml = '<center><table cellpadding=\'0\' cellspacing=\'0\' border=\'1\'>
							<tr class=\'active\' style=\'text-align: center; border:none; background: #ffffff\'>';
		foreach ($datos_encabezados_tabla as $index=>$item) {
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

		foreach ($datos_correo as $indice_datos_correo => $info_datos_correo) {
			$contenidoHtml .= '<tr style=\'text-align: center; border: none; font-size: 12px;background: #ffffff\'>';
			foreach (array_keys($datos_encabezados_tabla) as $indice_encabezado_tab) {
				$contenidoHtml .= '<td class="encabezados">
										<center>' . $info_datos_correo[$indice_encabezado_tab]. '</center>
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
}
?>