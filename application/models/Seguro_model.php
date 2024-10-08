<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Seguro_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    //MODELO DEDIC]
    function validaLoteComision($referencia, $empresa, $nombreLote){
        $query = $this->db->query("SELECT  lo.idLote , 
        ps.bandera,cs.id_comision,cs.comision_total ,
        lo.idLote,lo.idCliente, ps.abonado, ps.total_comision, 
        cs.id_usuario,cs.porcentaje_decimal,ps.pendiente,
        ps.id_pagoc ,psi.abono_pagado , psi.id_comision as pagoind,ps.ultimo_pago,ps.totalLote
        FROM  lotes lo 
        INNER JOIN pago_seguro ps ON ps.id_lote = lo.idLote 
        INNER JOIN comisiones_seguro cs on cs.idCliente = lo.idCliente  
        LEFT JOIN  (SELECT SUM(abono_neodata) abono_pagado, id_comision 
		FROM pago_seguro_ind WHERE (estatus in (1,3,8,11,4) OR descuento_aplicado = 1) 
		GROUP BY id_comision) psi ON psi.id_comision = cs.id_comision
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio 
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        WHERE lo.referencia = $referencia AND lo.nombreLote = '".$nombreLote."' AND re.empresa = '".$empresa."'");
        return $query->result_array();
    }


    function validarUsuarios($usuario_gerente, $usuario_asesor){
        $cmd = "SELECT tipo FROM usuarios WHERE id_usuario in ($usuario_gerente, $usuario_asesor) ";
        $query = $this->db->query($cmd);
        return $query->result_array();
    }

    function getInfoLote($referencia, $empresa, $nombreLote){
        $query = $this->db->query("SELECT lo.idLote ,
        (CASE WHEN	lo.idCliente IS NULL OR lo.idCliente = 0 THEN 0 ELSE lo.idCliente END) idCliente,lo.idCondominio
        FROM lotes lo
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        WHERE lo.referencia = $referencia AND lo.nombreLote = '".$nombreLote."' AND re.empresa = '".$empresa."'");
        return $query->row();
    }



    function getPlanComision($idAsesor, $idGerente,$totalSeguro,$divisorCompartida,$idAsesor2 = 0, $idGerente2 = 0){
        $sqlAsesor = $idAsesor2 != 0 ? "OR u1.id_usuario = $idAsesor2" : "";
        $sqlGerente = $idGerente2 != 0 ? "OR u1.id_usuario = $idGerente2" : "";
        $divisorGerente = ($divisorCompartida == 2 && $idGerente2 == 0) ? 1 : $divisorCompartida;
        $query = $this->db->query("DECLARE @idAsesor INT=$idAsesor,@idGerente INT = $idGerente, @totalSeguro FLOAT = $totalSeguro
            /* DIRECTOR */
        (SELECT DISTINCT(u1.id_usuario) AS id_usuario, up.valorComision porcentaje_decimal, ((@totalSeguro/100)*(up.valorComision)) comision_total, 
        CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, up.rolComisionista as id_rol,
        CASE WHEN up.comentario != '' THEN opc.nombre ELSE up.comentario END detail_rol, 5 as rolVal
        FROM plan_comision_seguros pl 
        INNER JOIN usuariosPlanComisionSeguros up ON up.idPlan=pl.id_plan
        INNER JOIN usuarios u1 ON u1.id_usuario=1980 AND up.rolComisionista=18
        INNER JOIN opcs_x_cats opc ON opc.id_opcion=u1.id_rol AND opc.id_catalogo=1
        )
        UNION
        (SELECT DISTINCT(u1.id_usuario) AS id_usuario, pl.comAsesor / $divisorCompartida porcentaje_decimal, ((@totalSeguro/100)*(pl.comAsesor / $divisorCompartida)) comision_total,
            CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, pl.asesor as id_rol, 
            opc.nombre as detail_rol, 1 rolVal
            FROM plan_comision_seguros pl
            INNER JOIN usuarios u1 ON u1.id_usuario = @idAsesor $sqlAsesor
            INNER JOIN opcs_x_cats opc ON opc.id_opcion=u1.id_rol AND opc.id_catalogo=1
        )
        UNION
        (SELECT DISTINCT(u1.id_usuario) AS id_usuario, pl.comGerente / $divisorGerente porcentaje_decimal, ((@totalSeguro/100)*(pl.comGerente / $divisorGerente)) comision_total,
            CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, pl.gerente as id_rol, 
            opc.nombre as detail_rol, 2 rolVal
            FROM plan_comision_seguros pl
            INNER JOIN usuarios u1 ON u1.id_usuario = @idGerente $sqlGerente
            INNER JOIN opcs_x_cats opc ON opc.id_opcion=u1.id_rol AND opc.id_catalogo=1
        )
        UNION
        (SELECT DISTINCT(u1.id_usuario) AS id_usuario, up.valorComision porcentaje_decimal, ((@totalSeguro/100)*(up.valorComision)) comision_total,
            CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, up.rolComisionista as id_rol, 
			CASE WHEN up.comentario != '' THEN up.comentario ELSE opc.nombre END detail_rol, 3 as rolVal
            FROM plan_comision_seguros pl
            INNER JOIN usuariosPlanComisionSeguros up ON up.idPlan=pl.id_plan 
            INNER JOIN usuarios u1 ON u1.id_usuario = up.idUsuario AND u1.id_usuario NOT IN (1980)
            INNER JOIN opcs_x_cats opc ON opc.id_opcion=u1.id_rol AND opc.id_catalogo=1
        )
        ORDER BY rolVal ASC
        ");
            return $query->result_array();
        }

        function pago_seguro($data){
            if ($data != '' && $data != null){
                $response = $this->db->insert('pago_seguro', $data);
                if (!$response) {
                    return 0;
                } else {
                    return 1;
                    // return 1;
                }
            }
        }

        function insertComisionSeguro($tabla, $data,$dataIndividual,$dataHistorialSeguros) {
            if ($data != '' && $data != null){
                $response = $this->db->insert($tabla, $data);
                if($tabla = 'comisiones_seguro'){

                $insertComision = $this->db->insert_id();
                // $cdmInsertPagoComision = "INSERT INTO  historial_comisiones 
                // VALUES ($insert_id_2, ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'DISPERSÓ CLUB MADERAS')";
                $dataIndividual['id_comision'] = $insertComision;

                $responsePago_seguro_ind = $this->db->insert('pago_seguro_ind', $dataIndividual);
                $responsePago_seguro_ind_Id = $this->db->insert_id();
                // $respuesta = $this->db->query("");             

                $dataHistorialSeguros['id_pago_i'] = $responsePago_seguro_ind_Id;

                $responsePago_seguro_ind = $this->db->insert('historial_seguro', $dataHistorialSeguros);

                // $dataPagoSeguro = $this->db->insert('pago_seguro', $dataPagoSeguro);
                    
                }
                if (!$response) {
                    return 0;
                } else {
                    return 1;
                    // return 1;
                }
            } else {
                return 0;
            }
        }


        function poderVentas($idAsesor) {
            $cmd = "select up.id_usuario as id_usuarioUp,    up.id_rol as id_rolUp,   
            CONCAT(up.nombre,' ',up.apellido_paterno,' ',up.apellido_materno) AS nombreUP,
            up2.id_usuario as id_usuarioUp2 ,  up2.id_rol as id_rolUp2, 
            CONCAT(up2.nombre,' ',up2.apellido_paterno,' ',up2.apellido_materno) AS nombreUp2,
            up3.id_usuario  as id_usuarioUp3,   up3.id_rol as id_rolUp3, 
            CONCAT(up3.nombre,' ',up3.apellido_paterno,' ',up3.apellido_materno) AS nombreUp3
            from usuarios up
            INNER JOIN  usuarios up2 on up2.id_usuario = up.id_lider
            INNER JOIN  usuarios up3 on up3.id_usuario = up2.id_lider
            where up.id_usuario = $idAsesor";

            $query = $this->db->query($cmd);
            return $query->result_array();
        }

        function getDatosComisionesAsesor($estado){
            $user_data = $this->session->userdata('id_usuario');
            $sede = $this->session->userdata('id_sede');
            
            return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision,lo.nombreLote  lote, re.nombreResidencial as proyecto, pac.totalLote precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, oxcpj.nombre as pj_name, u.forma_pago, pac.porcentaje_abono, 0 as factura, 1 expediente,
    
            oxcest.nombre  estatus_actual,
 
             (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, pac.bonificacion, cl.lugar_prospeccion,
             pci1.fecha_abono, opt.fecha_creacion AS fecha_opinion, opt.estatus as estatus_opinion, 
 
             (CASE WHEN cl.proceso = 0 THEN '' ELSE oxc0.nombre END) procesoCl,
             (CASE WHEN cl.proceso = 0 THEN '' ELSE 'label lbl-violetBoots' END) colorProcesoCl, cl.proceso, ISNULL(cl.id_cliente_reubicacion_2, 0)
 
             FROM pago_seguro_ind pci1 
             INNER JOIN comisiones_seguro com ON pci1.id_comision = com.id_comision
             INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1
             INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
             INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
             INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
             INNER JOIN usuarios u ON u.id_usuario = com.id_usuario  
             INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago AND oxcpj.id_catalogo = 16 
             LEFT JOIN pago_seguro pac ON pac.id_lote = com.id_lote
             INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
             INNER JOIN sedes sed ON sed.id_sede = 2 and sed.estatus = 1
             LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
             LEFT JOIN (SELECT id_usuario, fecha_creacion, estatus FROM opinion_cumplimiento WHERE estatus = 1) opt ON opt.id_usuario = com.id_usuario
             WHERE pci1.estatus IN ($estado) AND cl.estatusSeguro = 2   AND com.id_usuario = $user_data
             GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, pac.totalLote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata,
             pci1.pago_neodata, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, oxcpj.nombre, u.forma_pago,pci1.id_pago_i, pac.porcentaje_abono, oxcest.nombre, sed.impuesto, 
             pac.bonificacion, cl.lugar_prospeccion, opt.fecha_creacion, opt.estatus, cl.proceso, oxc0.nombre, cl.id_cliente_reubicacion_2");
        }
        public function getTotalComisionAsesor($idUsuario) {
            $query = $this->db->query("SELECT SUM(pci.abono_neodata) AS total
            FROM pago_seguro_ind pci 
            INNER JOIN comisiones_seguro com ON pci.id_comision = com.id_comision 
            where pci.estatus = 1 and com.id_usuario = $idUsuario");
            return $query->row();
        }
        function getComments($pago){
            $this->db->query("SET LANGUAGE Español;");
            return $this->db->query("SELECT DISTINCT(hc.comentario), hc.id_pago_i, hc.id_usuario, convert(nvarchar(20), hc.fecha_movimiento, 113) date_final, hc.fecha_movimiento, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_usuario
            FROM historial_seguro hc 
            INNER JOIN pago_seguro_ind pci ON pci.id_pago_i = hc.id_pago_i
            INNER JOIN usuarios u ON u.id_usuario = hc.id_usuario 
            WHERE hc.id_pago_i = $pago
            ORDER BY hc.fecha_movimiento DESC");
        }
        function consulta_codigo_postal($id_user){
            return $this->db->query("SELECT estatus, codigo_postal FROM cp_usuarios WHERE id_usuario = $id_user");
        }
        function update_acepta_solicitante($idsol) {
            $query = $this->db->query("UPDATE pago_seguro_ind SET estatus = 4, fecha_pago_intmex = GETDATE(),modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$idsol.")");
            return true;
        }
        function insertComisionSeguroAbono($dataIndividual,$banderaAbono , $comision,$dataHistorialSeguros) {
            if ($dataIndividual != '' && $dataIndividual != null){
                $response = $this->db->insert('pago_seguro_ind', $dataIndividual);
                $insertComision = $this->db->insert_id();
                $dataHistorialSeguros['id_pago_i'] = $insertComision;

                $response = $this->db->insert('historial_seguro', $dataHistorialSeguros);
                if (!$response) {
                    return 0;
                } else {
                    return 1;
                    // return 1;
                }
                if($banderaAbono == 1){
                    // "UPDATE pago_seguro set bandera = 7 where id_pagoc = $comision";
                } 
            } else {
                return 0;
            }
        }
        function updatePagoSeguro($cmd) {
        
                $response = $this->db->query($cmd);
            
                if ($response) {
                    return 1;
                } else {
                    return 0;
                    // return 1;
                }
        }

        function insert_phc($data){
            $this->db->insert_batch('historial_seguro', $data);
            return true;
        }

        function insertar_codigo_postal($codigo_postal, $nuevoCp){
            $id_user = $this->session->userdata('id_usuario');
            if($nuevoCp == 'true'){
                $this->db->query("INSERT INTO cp_usuarios (id_usuario, codigo_postal, estatus, fecha_creacion, fecha_modificacion, creado_por) VALUES ($id_user,$codigo_postal,1,GETDATE(),GETDATE(),$id_user)");
                echo "Código postal insertado con éxito";
            }else{
                $actualDatosCP= $this->consulta_codigo_postal($id_user)->result_array();
                $actualCP = $actualDatosCP[0]["codigo_postal"];
                $this->db->query("UPDATE cp_usuarios SET estatus = 1, codigo_postal = $codigo_postal, fecha_modificacion = GETDATE() WHERE id_usuario = $id_user");
                $this->db->query("INSERT INTO auditoria (id_parametro, tipo, anterior, nuevo, col_afect, tabla, fecha_creacion, creado_por) VALUES ($id_user,'update',$actualCP, $codigo_postal, 'codigo_postal', 'cp_usuarios', GETDATE(), ".$this->session->userdata('id_usuario').")");
                echo "Datos actualizados correctamente";
            }
        }

        function getDesarrolloSelect($a = ''){
            if($a == ''){
                $usuario = $this->session->userdata('id_usuario');
            }else{
                $usuario = $a;
            }
            
            return $this->db->query(" SELECT res.idResidencial id_usuario, concat(res.nombreResidencial,' ',res.descripcion)  as name_user FROM residenciales res WHERE res.idResidencial NOT IN 
            (SELECT re.idResidencial 
            FROM residenciales re
            INNER JOIN condominios co ON re.idResidencial = co.idResidencial
            INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio
            INNER JOIN comisiones_seguro com ON com.id_lote = lo.idLote AND com.estatus in (1,8)
            INNER JOIN pago_seguro_ind pci ON pci.id_comision = com.id_comision
            INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2) 
            WHERE pci.estatus IN (4) AND u.id_usuario = ".$usuario." GROUP BY re.idResidencial) AND res.status = 1
            AND res.idResidencial IN         
            (SELECT re.idResidencial 
            FROM residenciales re
            INNER JOIN condominios co ON re.idResidencial = co.idResidencial
            INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio
            INNER JOIN comisiones_seguro com ON com.id_lote = lo.idLote AND com.estatus in (1,8)
            INNER JOIN pago_seguro_ind pci ON pci.id_comision = com.id_comision
            INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2) 
            WHERE pci.estatus IN (1) AND u.id_usuario = ".$usuario." GROUP BY re.idResidencial)");
        }

        public function getDatosProyecto($idlote,$id_usuario = ''){
            if($id_usuario == ''){
                $id_user_V3 = $this->session->userdata('id_usuario');
            }else{
                $id_user_V3 = $id_usuario;
            }
            return $this->db->query("SELECT pci.id_pago_i, pci.pago_neodata, pci.abono_neodata  ,res.idResidencial , lot.nombreLote, res.nombreResidencial , res.idResidencial
            FROM pago_seguro_ind pci
            INNER JOIN comisiones_seguro com ON com.id_comision = pci.id_comision
            INNER JOIN lotes lot ON lot.idLote = com.id_lote
            INNER JOIN condominios con ON con.idCondominio = lot.idCondominio
            INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
            WHERE pci.estatus = 1 AND pci.id_usuario = $id_user_V3 AND res.idResidencial = $idlote");     
        }

        function verificar_uuid( $uuid ){
            return $this->db->query("SELECT * FROM facturas_seguros WHERE uuid = '".$uuid."'");
        }

        function leerxml( $xml_leer, $cargar_xml ){
            $str = '';
            if( $cargar_xml ){
                rename( $xml_leer, "./UPLOADS/XMLS/documento_temporal.txt" );
                $str = file_get_contents( "./UPLOADS/XMLS/documento_temporal.txt" );
                if( substr ( $str, 0, 3 ) == 'o;?' ){
                    $str = str_replace( "o;?", "", $str );
                    file_put_contents( './UPLOADS/XMLS/documento_temporal.txt', $str );
                }
                rename( "./UPLOADS/XMLS/documento_temporal.txt", $xml_leer );
            }
            libxml_use_internal_errors(true);
            $xml = simplexml_load_file( $xml_leer, null, true );
            $datosxml = array(
                "version" => $xml ->xpath('//cfdi:Comprobante')[0]['Version'],
                "regimenFiscal" => $xml ->xpath('//cfdi:Emisor')[0]['RegimenFiscal'],
                "formaPago" => $xml -> xpath('//cfdi:Comprobante')[0]['FormaPago'],
                "usocfdi" => $xml -> xpath('//cfdi:Receptor')[0]['UsoCFDI'],
                "metodoPago" => $xml -> xpath('//cfdi:Comprobante')[0]['MetodoPago'],
                "claveUnidad" => $xml -> xpath('//cfdi:Concepto')[0]['ClaveUnidad'],
                "unidad" => $xml -> xpath('//cfdi:Concepto')[0]['Unidad'],
                "claveProdServ" => $xml -> xpath('//cfdi:Concepto')[0]['ClaveProdServ'],
                "descripcion" => $xml -> xpath('//cfdi:Concepto')[0]['Descripcion'],
                "subTotal" => $xml -> xpath('//cfdi:Comprobante')[0]['SubTotal'],
                "total" => $xml -> xpath('//cfdi:Comprobante')[0]['Total'],
                "rfcemisor" => $xml -> xpath('//cfdi:Emisor')[0]['Rfc'],
                "nameEmisor" => $xml -> xpath('//cfdi:Emisor')[0]['Nombre'],
                "rfcreceptor" => $xml -> xpath('//cfdi:Receptor')[0]['Rfc'],
                "namereceptor" => $xml -> xpath('//cfdi:Receptor')[0]['Nombre'],
                "TipoRelacion"=> $xml->xpath('//@TipoRelacion'),
                "uuidV" =>$xml->xpath('//@UUID')[0],
                "fecha"=> $xml -> xpath('//cfdi:Comprobante')[0]['Fecha'],
                "folio"=> $xml -> xpath('//cfdi:Comprobante')[0]['Folio'],
            );
            $datosxml["textoxml"] = $str;
            return $datosxml;
        }

        function insertar_factura( $id_comision, $datos_factura,$usuarioid){
            $VALOR_TEXT = $datos_factura['textoxml'];
            $data = array(
                "fecha_factura"  => $datos_factura['fecha'],
                "folio_factura"  => $datos_factura['folio'],
                "descripcion" => $datos_factura['descripcion'],
                "subtotal" => $datos_factura['subTotal'],
                "total"  => $datos_factura['total'],
                "metodo_pago"  => $datos_factura['metodoPago'],
                "uuid" => $datos_factura['uuidV'],
                "nombre_archivo" => $datos_factura['nombre_xml'],
                "id_usuario" => $usuarioid,
                "id_comision" => $id_comision,
                "regimen" => $datos_factura['regimenFiscal'],
                "forma_pago" => $datos_factura['formaPago'],

                "fecha_creacion" => date('Y-m-d H:i:s'),

                "cfdi" => $datos_factura['usocfdi'],
                "unidad" => $datos_factura['claveUnidad'],
                "claveProd" => $datos_factura['claveProdServ']
            );
            return $this->db->insert("facturas_seguros", $data);
        }
        function getDatosHistorialPago($anio,$proyecto) {
            ini_set('memory_limit', -1);
            $filtro_02 = '';
            $filtro_00 = ' re.idResidencial = '.$proyecto.' AND YEAR(pci1.fecha_abono) = '.$anio.' ';
    
            switch ($this->session->userdata('id_rol')) {
                case 1:
                case 2:
                case 3:
                case 7:
                case 9:
                    $filtro_02 = ' com.id_usuario = '.$this->session->userdata('id_usuario').'  AND '.$filtro_00;
                    break;
                case 31:
                    $filtro_02 = ' '.$filtro_00. 'AND pci1.estatus IN (8,11,88) AND pci1.pago_neodata > 0 AND pci1.descuento_aplicado != 1 ';
                    break;
                default:
                    $filtro_02 = ' '.$filtro_00;
                    break;
            }
            return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote nombreLote, re.nombreResidencial as proyecto, co.nombre as condominio,lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion, 
            CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names ,pci1.id_usuario, CASE WHEN cl.estructura = 1 THEN UPPER(oprol2.nombre) ELSE UPPER(oprol.nombre) END as puesto, 
            oxcest.nombre estatus_actual, oxcest.id_opcion id_estatus_actual, pci1.descuento_aplicado, (CASE WHEN cl.lugar_prospeccion IS NULL THEN 0 ELSE cl.lugar_prospeccion END) lugar_prospeccion, lo.referencia, pac.bonificacion, u.estatus as activo, 
            (CASE WHEN pe.id_penalizacion IS NOT NULL THEN 1 ELSE 0 END) penalizacion, oxcest.color,
            (CASE WHEN cl.proceso = 0 THEN '' ELSE oxc0.nombre END) procesoCl,
            (CASE WHEN cl.proceso = 0 THEN '' ELSE 'label lbl-violetBoots' END) colorProcesoCl, cl.proceso, ISNULL(cl.id_cliente_reubicacion_2, 0) id_cliente_reubicacion_2
            FROM pago_seguro_ind pci1 
            LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision 
            FROM pago_seguro_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
            GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
            INNER JOIN comisiones_seguro com ON pci1.id_comision = com.id_comision and com.estatus = 1
            INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
            INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
            INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.status = 1 AND lo.idStatusContratacion > 8
            INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
            INNER JOIN pago_seguro pac ON pac.id_lote = com.id_lote
            INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
            LEFT JOIN penalizaciones pe ON pe.id_lote = lo.idLote AND pe.id_cliente = lo.idCliente
            LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
            LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
            WHERE $filtro_02
            GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, co.nombre, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, pci1.id_pago_i, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, pci1.descuento_aplicado, cl.lugar_prospeccion, lo.referencia, com.estatus, pac.bonificacion, u.estatus,pe.id_penalizacion, oxcest.color, cl.estructura, oprol2.nombre, cl.proceso, oxc0.nombre, cl.id_cliente_reubicacion_2 ORDER BY lo.nombreLote");
        }
        public function getPagosFinal($beginDate, $endDate) {
            ini_set('memory_limit', -1);
            $condicion = '';
            if (!in_array($this->session->userdata('id_rol'), array(31, 17, 70, 71, 73))) { 
                $idUsuario = $this->session->userdata('id_usuario');
                $condicion = " AND pt.id_usuario = $idUsuario";
            }
            return $this->db->query("SELECT pt.id_pagoi, pt.id_usuario,
            FORMAT(pt.monto_con_descuento,'C','En-Us') 'monto_con_descuento',
            FORMAT(pt.monto_sin_descuento,'C','En-Us') 'monto_sin_descuento',
            FORMAT(pt.monto_internomex,'C','En-Us') 'monto_internomex',
            UPPER(ISNULL(se.nombre, 'SIN ESPECIFICAR')) AS sede, UPPER(oxc0.nombre) AS forma_pago, CONVERT(varchar, pt.fecha_creacion, 20) fecha_creacion,
            CONCAT (u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno) nombre, 
            CASE WHEN (pt.comentario IS NULL OR CAST(pt.comentario AS VARCHAR(250)) = '') THEN 'SIN COMENTARIOS' ELSE pt.comentario END comentario,
            u0.id_rol, UPPER(oxc1.nombre) AS rol 
            FROM  pagos_internomex pt
            INNER JOIN usuarios u0 ON u0.id_usuario = pt.id_usuario
            LEFT JOIN sedes se ON CAST(se.id_sede AS VARCHAR(15)) = CAST(u0.id_sede AS VARCHAR(15))
            INNER JOIN opcs_x_cats oxc0 ON oxc0.id_catalogo = 16 AND oxc0.id_opcion = pt.forma_pago
            INNER JOIN opcs_x_cats oxc1 ON oxc1.id_catalogo = 1 AND oxc1.id_opcion = u0.id_rol
            WHERE pt.fecha_creacion BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000' $condicion");
        }
        public function getReporteLotesPorComisionista($beginDate, $endDate, $comisionista, $tipoUsuario) {
            $filtroFecha = " AND cl.fechaApartado BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
            
                $filtroComisionista = "";
            
            $query="SELECT UPPER(CAST(re.descripcion AS VARCHAR(74))) nombreResidencial, UPPER(cn.nombre) nombreCondominio, UPPER(lo.nombreLote) nombreLote, lo.idLote,
            FORMAT(ISNULL(lo.totalNeto2, '0.00'), 'C') precioTotalLote, CONVERT(varchar, cl.fechaApartado, 20) fechaApartado, UPPER(ISNULL(se.nombre, 'SIN ESPECIFICAR')) plaza,
            lo.idStatusContratacion, sl.nombre nombreEstatusLote, sl.color, sl.background_sl, lo.registro_comision registroComision, 
            0 estatusComision, 0.00 porcentaje_decimal,
            '0.00' comisionTotal, '0.00' abonoDispersado, '0.00' abonoPagado, 0 rec,
            UPPER(REPLACE(ISNULL(oxc.nombre, 'SIN ESPECIFICAR'), ' (especificar)', '')) AS lugar_prospeccion,
            UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente,
            UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) nombreAsesor,
            ISNULL(UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)), 'SIN ESPECIFICAR') nombreCoordinador,
            ISNULL(UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)), 'SIN ESPECIFICAR') nombreGerente,
            ISNULL(UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)), 'SIN ESPECIFICAR') nombreSubdirector,
            ISNULL(UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)), 'SIN ESPECIFICAR') nombreRegional,
            0 as ultimoEstatusCanceladas, pc.abonado pagoCliente
            FROM lotes lo
            INNER JOIN condominios cn ON cn.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = cn.idResidencial
            INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.status = 1 $filtroComisionista $filtroFecha
            LEFT JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
            LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
            LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
            LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
            LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
            LEFT JOIN sedes se ON se.id_sede = cl.id_sede
            INNER JOIN statuslote sl ON sl.idStatusLote = lo.idStatusLote
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = cl.lugar_prospeccion AND oxc.id_catalogo = 9
            LEFT JOIN pago_seguro pc ON pc.id_lote = lo.idLote
            WHERE lo.status = 1 AND lo.registro_comision NOT IN (1, 7)
            -- TRAE TODAS LAS VENTAS NUEVAS ACTIVAS SIN COMISIÓN
            UNION ALL
            -- TRAE TODAS LAS VENTAS ACTIVAS CON COMISIÓN
            SELECT UPPER(CAST(re.descripcion AS VARCHAR(74))) nombreResidencial, UPPER(cn.nombre) nombreCondominio, UPPER(lo.nombreLote) nombreLote, lo.idLote,
            FORMAT(ISNULL(lo.totalNeto2, '0.00'), 'C') precioTotalLote, CONVERT(varchar, cl.fechaApartado, 20) fechaApartado, UPPER(ISNULL(se.nombre, 'SIN ESPECIFICAR')) plaza,
            lo.idStatusContratacion, sl.nombre nombreEstatusLote, sl.color, sl.background_sl, lo.registro_comision registroComision, 
            pc.bandera estatusComision, ISNULL(cm.porcentaje_decimal, 0.00) porcentaje_decimal,
            ISNULL(cm.comision_total, '0.00') comisionTotal, 
            ISNULL(pci3.abonoDispersado, '0.00') abonoDispersado, 
            ISNULL(pci2.abonoPagado, '0.00') abonoPagado, cm.estatus rec,
            UPPER(REPLACE(ISNULL(oxc.nombre, 'SIN ESPECIFICAR'), ' (especificar)', '')) AS lugar_prospeccion,
            ISNULL(UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)), 'SIN ESPECIFICAR') nombreCliente,
            UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) nombreAsesor,
            ISNULL(UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)), 'SIN ESPECIFICAR') nombreCoordinador,
            ISNULL(UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)), 'SIN ESPECIFICAR') nombreGerente,
            ISNULL(UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)), 'SIN ESPECIFICAR') nombreSubdirector,
            ISNULL(UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)), 'SIN ESPECIFICAR') nombreRegional,
            0 as ultimoEstatusCanceladas, pc.abonado pagoCliente
            FROM lotes lo
            INNER JOIN condominios cn ON cn.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = cn.idResidencial
            INNER JOIN statuslote sl ON sl.idStatusLote = lo.idStatusLote
            INNER JOIN comisiones_seguro cm ON cm.id_lote = lo.idLote AND cm.id_usuario = $comisionista AND cm.estatus != 8
            INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.status = 1 $filtroComisionista $filtroFecha
            LEFT JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
            LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
            LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
            LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
            LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
            LEFT JOIN sedes se ON se.id_sede = cl.id_sede
            LEFT JOIN pago_seguro pc ON pc.id_lote = lo.idLote    
            LEFT JOIN (SELECT SUM(abono_neodata) abonoPagado, id_comision FROM pago_seguro_ind WHERE estatus IN (11) GROUP BY id_comision) pci2 ON cm.id_comision = pci2.id_comision
            LEFT JOIN (SELECT SUM(abono_neodata) abonoDispersado, id_comision FROM pago_seguro_ind GROUP BY id_comision) pci3 ON cm.id_comision = pci3.id_comision
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = cl.lugar_prospeccion AND oxc.id_catalogo = 9
            WHERE lo.status = 1
            GROUP BY 
            UPPER(CAST(re.descripcion AS VARCHAR(74))), UPPER(cn.nombre), UPPER(lo.nombreLote), lo.idLote,
            FORMAT(ISNULL(lo.totalNeto2, '0.00'), 'C'), CONVERT(varchar, cl.fechaApartado, 20), UPPER(ISNULL(se.nombre, 'SIN ESPECIFICAR')) ,
            lo.idStatusContratacion, sl.nombre, sl.color, sl.background_sl, lo.registro_comision, 
            pc.bandera, ISNULL(cm.porcentaje_decimal, 0.00),
            ISNULL(cm.comision_total, '0.00'), 
            ISNULL(pci3.abonoDispersado, '0.00'), 
            ISNULL(pci2.abonoPagado, '0.00'), cm.estatus,
            UPPER(REPLACE(ISNULL(oxc.nombre, 'SIN ESPECIFICAR'), ' (especificar)', '')),
            ISNULL(UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)), 'SIN ESPECIFICAR'),
            UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)),
            ISNULL(UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)), 'SIN ESPECIFICAR'),
            ISNULL(UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)), 'SIN ESPECIFICAR'),
            ISNULL(UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)), 'SIN ESPECIFICAR'),
            ISNULL(UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)), 'SIN ESPECIFICAR'), pc.abonado
            UNION ALL
            -- TRAE TODOAS LAS VENTAS DONDE EXISTE REGISTRO DE COMISIÓN PERO PUEDE O NO ESTAR RELACIONADO AL CLIENTE Y ES UNA RECISIÓN
            SELECT UPPER(CAST(re.descripcion AS VARCHAR(74))) nombreResidencial, UPPER(cn.nombre) nombreCondominio, UPPER(lo.nombreLote) nombreLote, lo.idLote,
            FORMAT(ISNULL(lo.totalNeto2, '0.00'), 'C') precioTotalLote, CONVERT(varchar, cl.fechaApartado, 20) fechaApartado, UPPER(ISNULL(se.nombre, 'SIN ESPECIFICAR')) plaza,
            lo.idStatusContratacion, sl.nombre nombreEstatusLote, sl.color, sl.background_sl, lo.registro_comision registroComision, 
            pc.bandera estatusComision, ISNULL(cm.porcentaje_decimal, 0.00) porcentaje_decimal,
            ISNULL(cm.comision_total, '0.00') comisionTotal, 
            ISNULL(pci3.abonoDispersado, '0.00') abonoDispersado, 
            ISNULL(pci2.abonoPagado, '0.00') abonoPagado, cm.estatus rec,
            UPPER(REPLACE(ISNULL(oxc.nombre, 'SIN ESPECIFICAR'), ' (especificar)', '')) lugar_prospeccion,
            ISNULL(UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)), 'SIN ESPECIFICAR') nombreCliente,
            UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) nombreAsesor,
            ISNULL(UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)), 'SIN ESPECIFICAR') nombreCoordinador,
            ISNULL(UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)), 'SIN ESPECIFICAR') nombreGerente,
            ISNULL(UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)), 'SIN ESPECIFICAR') nombreSubdirector,
            ISNULL(UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)), 'SIN ESPECIFICAR') nombreRegional,
            0 as ultimoEstatusCanceladas, pc.abonado pagoCliente
            FROM lotes lo
            INNER JOIN condominios cn ON cn.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = cn.idResidencial
            INNER JOIN statuslote sl ON sl.idStatusLote = lo.idStatusLote
            INNER JOIN comisiones_seguro cm ON cm.id_lote = lo.idLote AND cm.id_usuario = $comisionista AND cm.estatus = 8
            LEFT JOIN clientes cl ON cl.id_cliente = cm.idCliente $filtroComisionista $filtroFecha
            LEFT JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
            LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
            LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
            LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
            LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
            LEFT JOIN sedes se ON se.id_sede = cl.id_sede
            LEFT JOIN pago_seguro pc ON pc.id_lote = lo.idLote    
            LEFT JOIN (SELECT SUM(abono_neodata) abonoPagado, id_comision FROM pago_seguro_ind WHERE estatus IN (11) GROUP BY id_comision) pci2 ON cm.id_comision = pci2.id_comision
            LEFT JOIN (SELECT SUM(abono_neodata) abonoDispersado, id_comision FROM pago_seguro_ind GROUP BY id_comision) pci3 ON cm.id_comision = pci3.id_comision
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = cl.lugar_prospeccion AND oxc.id_catalogo = 9
            WHERE lo.status = 1 
            UNION ALL
            -- SE TRAE TODAS LAS VENTAS LIQUIDADAS
            SELECT UPPER(CAST(re.descripcion AS VARCHAR(74))) nombreResidencial, UPPER(cn.nombre) nombreCondominio, UPPER(lo.nombreLote) nombreLote, lo.idLote,
            FORMAT(ISNULL(lo.totalNeto2, '0.00'), 'C') precioTotalLote, CONVERT(varchar, cl.fechaApartado, 20) fechaApartado, UPPER(ISNULL(se.nombre, 'SIN ESPECIFICAR')) plaza,
            lo.idStatusContratacion, sl.nombre nombreEstatusLote, sl.color, sl.background_sl, lo.registro_comision registroComision, 
            pc.bandera estatusComision, ISNULL(cm.porcentaje_decimal, 0.00) porcentaje_decimal,
            ISNULL(cm.comision_total, '0.00') comisionTotal, 
            ISNULL(pci3.abonoDispersado, '0.00') abonoDispersado, 
            ISNULL(pci2.abonoPagado, '0.00') abonoPagado, cm.estatus rec,
            UPPER(REPLACE(ISNULL(oxc.nombre, 'SIN ESPECIFICAR'), ' (especificar)', '')) lugar_prospeccion,
            ISNULL(UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)), 'SIN ESPECIFICAR') nombreCliente,
            UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) nombreAsesor,
            ISNULL(UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)), 'SIN ESPECIFICAR') nombreCoordinador,
            ISNULL(UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)), 'SIN ESPECIFICAR') nombreGerente,
            ISNULL(UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)), 'SIN ESPECIFICAR') nombreSubdirector,
            ISNULL(UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)), 'SIN ESPECIFICAR') nombreRegional,
            0 as ultimoEstatusCanceladas, pc.abonado pagoCliente
            FROM lotes lo
            INNER JOIN condominios cn ON cn.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = cn.idResidencial
            INNER JOIN statuslote sl ON sl.idStatusLote = lo.idStatusLote
            LEFT JOIN comisiones_seguro cm ON cm.id_lote = lo.idLote AND cm.id_usuario = $comisionista
            INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.status = 1 $filtroComisionista $filtroFecha
            LEFT JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
            LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
            LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
            LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
            LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
            LEFT JOIN sedes se ON se.id_sede = cl.id_sede
            LEFT JOIN pago_seguro pc ON pc.id_lote = lo.idLote    
            LEFT JOIN (SELECT SUM(abono_neodata) abonoPagado, id_comision FROM pago_seguro_ind WHERE estatus IN (11) GROUP BY id_comision) pci2 ON cm.id_comision = pci2.id_comision
            LEFT JOIN (SELECT SUM(abono_neodata) abonoDispersado, id_comision FROM pago_seguro_ind GROUP BY id_comision) pci3 ON cm.id_comision = pci3.id_comision
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = cl.lugar_prospeccion AND oxc.id_catalogo = 9
            WHERE lo.status = 1 AND lo.registro_comision = 7 AND cm.id_lote IS NULL
            UNION ALL
            -- TRAE LAS VENTAS CANCELADAS
            SELECT UPPER(CAST(re.descripcion AS VARCHAR(74))) nombreResidencial, UPPER(cn.nombre) nombreCondominio, UPPER(lo.nombreLote) nombreLote, lo.idLote,
            FORMAT(ISNULL(lo.totalNeto2, '0.00'), 'C') precioTotalLote, CONVERT(varchar, cl.fechaApartado, 20) fechaApartado, UPPER(ISNULL(se.nombre, 'SIN ESPECIFICAR')) plaza,
            lo.idStatusContratacion, sl.nombre nombreEstatusLote, sl.color, sl.background_sl, lo.registro_comision registroComision, 
            pc.bandera estatusComision, ISNULL(cm.porcentaje_decimal, 0.00) porcentaje_decimal,
            ISNULL(cm.comision_total, '0.00') comisionTotal, 
            ISNULL(pci3.abonoDispersado, '0.00') abonoDispersado, 
            ISNULL(pci2.abonoPagado, '0.00') abonoPagado, 8 rec,
            UPPER(REPLACE(ISNULL(oxc.nombre, 'SIN ESPECIFICAR'), ' (especificar)', '')) lugar_prospeccion,
            ISNULL(UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)), 'SIN ESPECIFICAR') nombreCliente,
            UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) nombreAsesor,
            ISNULL(UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)), 'SIN ESPECIFICAR') nombreCoordinador,
            ISNULL(UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)), 'SIN ESPECIFICAR') nombreGerente,
            ISNULL(UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)), 'SIN ESPECIFICAR') nombreSubdirector,
            ISNULL(UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)), 'SIN ESPECIFICAR') nombreRegional,
            hlo2.idStatusContratacion as ultimoEstatusCanceladas, pc.abonado pagoCliente
            FROM lotes lo
            INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 0 AND isNULL(cl.noRecibo, '') != 'CANCELADO' $filtroComisionista $filtroFecha
            INNER JOIN condominios cn ON cn.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = cn.idResidencial
            INNER JOIN statuslote sl ON sl.idStatusLote = lo.idStatusLote
            INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
            INNER JOIN historial_lotes hlo2 ON hlo2.idLote = hlo.idLote AND hlo2.idCliente = hlo.idCliente AND hlo2.modificado = hlo.modificado
            LEFT JOIN comisiones_seguro cm ON cm.id_lote = lo.idLote AND cm.id_usuario = $comisionista AND cm.estatus = 8 --AND cm.idCliente = cl.id_cliente
            LEFT JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
            LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
            LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
            LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
            LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
            LEFT JOIN sedes se ON se.id_sede = cl.id_sede
            LEFT JOIN pago_seguro pc ON pc.id_lote = lo.idLote    
            LEFT JOIN (SELECT SUM(abono_neodata) abonoPagado, id_comision FROM pago_seguro_ind WHERE estatus IN (11) GROUP BY id_comision) pci2 ON cm.id_comision = pci2.id_comision
            LEFT JOIN (SELECT SUM(abono_neodata) abonoDispersado, id_comision FROM pago_seguro_ind GROUP BY id_comision) pci3 ON cm.id_comision = pci3.id_comision
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = cl.lugar_prospeccion AND oxc.id_catalogo = 9
            WHERE lo.status = 1 AND cm.id_comision IS NULL
            UNION ALL
            SELECT UPPER(CAST(re.descripcion AS VARCHAR(74))) nombreResidencial, UPPER(cn.nombre) nombreCondominio, UPPER(lo.nombreLote) nombreLote, lo.idLote,
            FORMAT(ISNULL(lo.totalNeto2, '0.00'), 'C') precioTotalLote, CONVERT(varchar, cl.fechaApartado, 20) fechaApartado, UPPER(ISNULL(se.nombre, 'SIN ESPECIFICAR')) plaza,
            lo.idStatusContratacion, sl.nombre nombreEstatusLote, sl.color, sl.background_sl, lo.registro_comision registroComision, 
            pc.bandera estatusComision, ISNULL(cm.porcentaje_decimal, 0.00) porcentaje_decimal,
            ISNULL(cm.comision_total, '0.00') comisionTotal, 
            ISNULL(pci3.abonoDispersado, '0.00') abonoDispersado, 
            ISNULL(pci2.abonoPagado, '0.00') abonoPagado, 8 rec,
            UPPER(REPLACE(ISNULL(oxc.nombre, 'SIN ESPECIFICAR'), ' (especificar)', '')) lugar_prospeccion,
            ISNULL(UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)), 'SIN ESPECIFICAR') nombreCliente,
            UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) nombreAsesor,
            ISNULL(UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)), 'SIN ESPECIFICAR') nombreCoordinador,
            ISNULL(UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)), 'SIN ESPECIFICAR') nombreGerente,
            ISNULL(UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)), 'SIN ESPECIFICAR') nombreSubdirector,
            ISNULL(UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)), 'SIN ESPECIFICAR') nombreRegional,
            hlo2.idStatusContratacion as ultimoEstatusCanceladas, pc.abonado pagoCliente
            FROM lotes lo
            INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 0 AND isNULL(cl.noRecibo, '') != 'CANCELADO' $filtroComisionista $filtroFecha
            INNER JOIN condominios cn ON cn.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = cn.idResidencial
            INNER JOIN statuslote sl ON sl.idStatusLote = lo.idStatusLote
            INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
            INNER JOIN historial_lotes hlo2 ON hlo2.idLote = hlo.idLote AND hlo2.idCliente = hlo.idCliente AND hlo2.modificado = hlo.modificado
            LEFT JOIN comisiones_seguro cm ON cm.id_lote = lo.idLote AND cm.id_usuario = $comisionista AND cm.estatus = 8 --AND cm.idCliente = cl.id_cliente
            LEFT JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
            LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
            LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
            LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
            LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
            LEFT JOIN sedes se ON se.id_sede = cl.id_sede
            LEFT JOIN pago_seguro pc ON pc.id_lote = lo.idLote
            LEFT JOIN (SELECT SUM(abono_neodata) abonoPagado, id_comision FROM pago_seguro_ind WHERE estatus IN (11) GROUP BY id_comision) pci2 ON cm.id_comision = pci2.id_comision
            LEFT JOIN (SELECT SUM(abono_neodata) abonoDispersado, id_comision FROM pago_seguro_ind GROUP BY id_comision) pci3 ON cm.id_comision = pci3.id_comision
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = cl.lugar_prospeccion AND oxc.id_catalogo = 9
            WHERE lo.status = 1 AND cm.id_comision IS NOT NULL
            ORDER BY nombreLote";
            return $this->db->query($query);
        }
        public function getOpcionesParaReporteComisionistas($condicionXUsuario) {
            return $this->db->query("SELECT us.id_usuario id_opcion, UPPER(CONCAT(us.id_usuario, ' - ', us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) nombre, 
            us.estatus atributo_extra, 1 id_catalogo, oxc.nombre atributo_extra2
            FROM usuarios us
            INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = us.id_rol AND oxc.id_catalogo = 1
            WHERE us.id_rol IN (1, 2, 3, 9, 7) AND us.estatus != 0 AND (us.rfc NOT LIKE '%TSTDD%' AND ISNULL(us.correo, '' ) NOT LIKE '%test_%' AND ISNULL(us.correo, '') NOT LIKE '%CASA%') $condicionXUsuario
            UNION ALL
            SELECT id_opcion, UPPER(nombre) nombre, id_catalogo atributo_extra, 2 id_catalogo,'0' atributo_extra2
            FROM opcs_x_cats WHERE id_catalogo = 1 AND id_opcion IN (1, 2, 3, 9, 7, 59)
            ORDER BY id_catalogo, UPPER(CONCAT(us.id_usuario, ' - ', us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno))");
        }
        
        public function getDataPagosSeguro($estatus = '') {
            $this->db->query("SET LANGUAGE Español;");
            ini_set('memory_limit', -1);  
            $cadena = $estatus != '' ? ( $estatus == 1 ? "WHERE  cl.estatusSeguro IN(".$estatus.",0)" : "WHERE  cl.estatusSeguro IN(".$estatus.")" ): "";  
    
            $query = $this->db->query("SELECT pg.numero_dispersion,re.descripcion nombreResidencial,l.referencia,co.nombre nombreCondominio,l.nombreLote,l.idLote,CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) nombreCliente,
			tv.tipo_venta,st.nombreStatus,pg.totalLote Precio_Total,(pg.porcentaje_abono * 100) porcentaje,pg.total_comision Comision_total,pg.abonado Comisiones_Pagadas,pg.pendiente Comisiones_pendientes,pg.fecha_modificacion,
            (CASE WHEN l.tipo_venta = 1 THEN 'lbl-warning' WHEN l.tipo_venta = 2 THEN 'lbl-green' ELSE 'lbl-gray' END) claseTipo_venta,
			(CASE WHEN l.idStatusContratacion = 15 THEN 'lbl-violetBoots' ELSE 'lbl-gray' END) colorContratacion,
			(CASE WHEN l.idStatusContratacion = 15 THEN 'CONTRATADO' ELSE CONVERT(VARCHAR,l.idStatusContratacion) END) idStatusContratacion,pl.descripcion plan_comision,pl.id_plan,
            (CASE WHEN cl.estatusSeguro = 0 THEN 'PENDIENTE' ELSE opc.nombre END) estatusSeguro,
			(CASE WHEN cl.estatusSeguro IN (0,1,4) THEN 'lbl-vividOrange' WHEN cl.estatusSeguro = 2 THEN 'lbl-green' WHEN cl.estatusSeguro = 3 THEN 'lbl-warning' ELSE '' END) colorSeguro,cl.id_cliente,cl.estatusSeguro AS idestatusSeguro
			FROM lotes l
			INNER JOIN clientes cl ON cl.id_cliente=l.idCliente
			INNER JOIN condominios co ON co.idCondominio=l.idCondominio
			INNER JOIN residenciales re ON re.idResidencial=co.idResidencial
			INNER JOIN pago_seguro pg ON pg.id_lote=l.idLote
			LEFT JOIN tipo_venta tv ON tv.id_tventa=l.tipo_venta
			LEFT JOIN statuscontratacion st ON st.idStatusContratacion=l.idStatusContratacion
            LEFT JOIN opcs_x_cats opc ON opc.id_opcion=cl.estatusSeguro AND opc.id_catalogo=125
			INNER JOIN plan_comision_seguros pl ON pl.id_plan=1
            $cadena
            ");
    
            return $query;
        }
        public function getDetallePlanesComisiones($idPlan)
        {
            $query = $this->db->query("SELECT pc.id_plan, pc.descripcion, pc.comGerente, rolGer.nombre AS gerente, pc.comAsesor, rolAse.nombre AS asesor,u.valorComision,
			(CASE WHEN u.comentario != '' THEN u.comentario ELSE rol.nombre END) nombre
            FROM plan_comision_seguros pc
            INNER  JOIN opcs_x_cats rolGer ON rolGer.id_opcion = pc.gerente AND rolGer.id_catalogo = 1
            INNER JOIN opcs_x_cats rolAse ON rolAse.id_opcion = pc.asesor AND rolAse.id_catalogo = 1
			INNER JOIN usuariosPlanComisionSeguros u ON u.idPlan=pc.id_plan
			INNER JOIN opcs_x_cats rol ON rol.id_opcion=u.rolComisionista AND rol.id_catalogo=1
            WHERE pc.id_plan = $idPlan");
            return $query;
        }
        public function getAbonado($idlote){
            return $this->db->query("SELECT SUM(pci.abono_neodata) abonado, c2.total_comision
            FROM lotes lo
            INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
            INNER JOIN comisiones_seguro c1 ON c1.id_lote=lo.idLote
            LEFT JOIN (SELECT SUM(comision_total) total_comision, id_lote FROM comisiones_seguro WHERE estatus = 1 GROUP BY id_lote) c2 ON c2.id_lote = lo.idLote
            INNER JOIN pago_seguro pac ON pac.id_lote = lo.idLote
            LEFT JOIN pago_seguro_ind pci on pci.id_comision = c1.id_comision
            WHERE c1.estatus = 1 AND lo.idLote in ($idlote)
            GROUP BY lo.idLote,c2.total_comision
            ");
        }
        
        public function getDatosAbonadoDispersion($idlote){
             return $this->db->query("SELECT com.id_comision, com.id_usuario, lo.totalNeto2, lo.idLote, res.idResidencial, lo.referencia, lo.tipo_venta, com.id_lote, 
             lo.nombreLote, com.porcentaje_decimal, CONCAT(us.nombre,' ' ,us.apellido_paterno,' ',us.apellido_materno) colaborador,
             (CASE WHEN us.id_usuario IN(15103) THEN 'EQUIPO ADMINISTRATIVO' ELSE oxc.nombre END) rol, 
             com.comision_total, pci.abono_pagado, com.rol_generado,
             com.descuento
             FROM comisiones_seguro com
             LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_seguro_ind 
             GROUP BY id_comision) pci ON pci.id_comision = com.id_comision
             INNER JOIN lotes lo ON lo.idLote = com.id_lote 
             INNER JOIN usuarios us ON us.id_usuario = com.id_usuario
             INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = com.rol_generado AND oxc.id_catalogo = 1
             INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
             INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
             LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = com.rol_generado AND oxc2.id_catalogo = 83
             WHERE com.id_lote = $idlote AND com.estatus = 1   ORDER BY com.rol_generado asc");
         }
         public function getHistorialSeguro($idCliente){
            return $this->db->query("SELECT h.*,opc.nombre,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreUsuario
            FROM historialSeguros h 
            INNER JOIN opcs_x_cats opc ON opc.id_opcion=h.estatus AND opc.id_catalogo=125
            INNER JOIN usuarios u ON u.id_usuario=h.idUsuario WHERE idCliente=$idCliente ORDER BY h.fechaCreacion")->result_array();
        }

        public function InsertCli($datos){
            $user = $this->session->userdata;
            $id_usuario = $user['id_usuario'] ;
            $dataCliente = array(
                'id_asesor' => 0,
                'id_coordinador' => 0,
                'id_gerente' => 0,
                'id_sede' => $user['id_sede'],
                'nombre' => $datos['nombre'],
                'apellido_paterno' => $datos['app'],
                'apellido_materno' => $datos['apm'],
                'rfc' => 0,
                'correo' => 0,
                'telefono1' => 0,
                'telefono2' => 0,
                'estado_civil' => 0,
                'regimen_matrimonial' => 0 ,
                'domicilio_particular' => '',
                'originario_de' => 0,
                'ocupacion' => 0,
                'status' => 1,
                'idLote' => $datos['idLote'],
                'usuario' => $user['usuario'],
                'idCondominio' => $datos['idCondominio'],
                'fecha_creacion' => date('Y-m-d h:i:s'),
                'fechaApartado' => date('Y-m-d h:i:s'),
                'creado_por' => $this->session->userdata('id_usuario'),
                'fecha_modificacion' => date('Y-m-d h:i:s'),
                'estatusSeguro' => 1
            );
            $this->db->insert('clientes', $dataCliente);
            $idCliente = $this->db->query("SELECT IDENT_CURRENT('clientes') idCliente")->row()->idCliente;
            $this->db->query("UPDATE lotes SET idCliente = $idCliente, usuario = $id_usuario WHERE idLote = ".$datos['idLote']." ");      
            return $idCliente;
        }
}