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
?>