<?php
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
	function getFolderFile($documentType)
    {
        if ($documentType == 7) $folder = "static/documentos/cliente/corrida/";
        else if ($documentType == 8) $folder = "static/documentos/cliente/contrato/";
        else $folder = "static/documentos/cliente/expediente/";
        return $folder;
    }

    function validateUserVts($dataValidate){
    $id_sede = $dataValidate["id_sede"];
    $id_rol = $dataValidate["id_rol"];
    $id_lider = $dataValidate["id_lider"];
    $maxAsesores=0;
    $maxCoordinador=10;//original: 10
    $maxGerente=10; //original: 10
    $respuesta = 0;
    $mensaje = '';
    $sedeString = '';


    $CI =& get_instance();
    $CI->load->model('Services_model');
    $colabsData = $CI->Services_model->countColabsByRol($id_rol, $id_sede, $id_lider);
    $data_return = $CI->Services_model->getSedeById($id_sede);
    $sedeString = $data_return->nombre;
    switch ($id_rol){
        case 7:
            if($id_sede == 4){
                //si es CDMX debe dejar 40 asesores
                $maxAsesores = 40;//original: 40
            }else{
                $maxAsesores = 20;//original: 20
            }
            if(count($colabsData) < $maxAsesores){
                //si puede ingresar más asesores
                $respuesta = 1;
            }else{
                //no puede ingresar más asesores
                $respuesta = 0;
                $mensaje = 'No se pueden añadir más asesores, recuerda que el máximo para está sede('.$sedeString.') por coordinación es: '.$maxAsesores;
            }
            break;
        case 3:
        case 9:
            if(count($colabsData) < (($id_rol==9) ? $maxCoordinador : $maxGerente)){
                //si puede ingresar Coordinadores o gerente
                $respuesta = 1;
            }else{
                //no puede ingresar más Coordinadores o gerente
                $respuesta = 0;
                $palabra= ($id_rol==9) ? 'coordinadores' : 'gerentes';
                $maxPalabra= ($id_rol==9) ? $maxCoordinador : $maxGerente;
                $mensaje = 'No se pueden añadir más '.$palabra.', recuerda que el máximo para está sede('.$sedeString.') es:'.$maxPalabra;
            }
            break;
        case 2:
            $respuesta = 1;
        break;
        default:
            break;
    }

    return array(
        "respuesta" => $respuesta,
        "mensaje" => $mensaje
    );
	}

    // Función para obtener el enésimo lunes del mes
    function nLunesDelMes($fecha, $n) {
        $anio = $fecha->format('Y');
        $mes = $fecha->format('m');
    
        // Comenzamos en el primer día del mes
        $nuevaFecha = new DateTime("$anio-$mes-01");
    
        // Avanzamos hasta el próximo lunes
        while ($nuevaFecha->format('N') != 1) {
            $nuevaFecha->modify('+1 day');
        }
    
        // Avanzamos (n-1) semanas más para llegar al n-ésimo lunes
        $nuevaFecha->modify('+' . (7 * ($n - 1)) . ' days');
    
        return $nuevaFecha;
    }
    
    // Genera dia festivos de MX de los siguientes dos años al año que reciba como parametro
    function generarDiasFestivos($anio) {
        $diasFestivos = [
            new DateTime("$anio-01-01"), // Año Nuevo
            new DateTime("$anio-02-05"), // Día de la Constitución
            new DateTime("$anio-03-21"), // Natalicio de Benito Juárez
            new DateTime("$anio-05-01"), // Día del Trabajo
            new DateTime("$anio-09-16"), // Día de la Independencia
            new DateTime("$anio-11-20"), // Día de la Revolución
            new DateTime("$anio-12-01"), // Transmisión del Poder Ejecutivo Federal
            new DateTime("$anio-12-25"), // Navidad
            new DateTime(($anio + 1) . "-01-01"), // Año Nuevo
            new DateTime(($anio + 1) . "-02-05"), // Día de la Constitución
            new DateTime(($anio + 1) . "-03-21"), // Natalicio de Benito Juárez
            new DateTime(($anio + 1) . "-05-01"), // Día del Trabajo
            new DateTime(($anio + 1) . "-09-16"), // Día de la Independencia
            new DateTime(($anio + 1) . "-11-20"), // Día de la Revolución
            new DateTime(($anio + 1) . "-12-01"), // Transmisión del Poder Ejecutivo Federal
            new DateTime(($anio + 1) . "-12-25"), // Navidad
        ];
    
        // Ajustar los días que se mueven al lunes más cercano
        $diasFestivos[1] = nLunesDelMes($diasFestivos[1], 1); // Día de la Constitución
        $diasFestivos[2] = nLunesDelMes($diasFestivos[2], 3); // Natalicio de Benito Juárez
        $diasFestivos[5] = nLunesDelMes($diasFestivos[5], 3); // Día de la Revolución
        $diasFestivos[9] = nLunesDelMes($diasFestivos[9], 1); // Día de la Constitución
        $diasFestivos[10] = nLunesDelMes($diasFestivos[10], 3); // Natalicio de Benito Juárez
        $diasFestivos[13] = nLunesDelMes($diasFestivos[13], 3); // Día de la Revolución
    
        // Convertir a formato ISO y obtener solo la parte de la fecha
        $festivos = array_map(function($fecha) {
            return $fecha->format('Y-m-d');
        }, $diasFestivos);
    
        return $festivos;
    }
    
    // Función para calcular días HABILES transcurridos entre dos fechas
    function elapsedDaysBetweenTwoDates($start, $end) {
        $startDate = new DateTime($start);
        $endDate = new DateTime($end);
        $elapsedDays = 0;
        
        if ($startDate > $endDate){
            return ["result" => false, "msg" => 'Error al calcular el tiempo bloqueado del lote', "days" => 0];
        }
        
        $festivalDays = generarDiasFestivos($startDate->format('Y'));
        
        while ($startDate->format('Y-m-d') < $endDate->format('Y-m-d')) {
            $startDate->modify('+1 day');
            if ($startDate->format('N') != 6 && $startDate->format('N') != 7 && !in_array($startDate->format('Y-m-d'), $festivalDays)) {
                $elapsedDays++;
            }
        }
        
        return ["result" => true, "msg" => 'Días calculados', "days" => $elapsedDays];
    }
?>