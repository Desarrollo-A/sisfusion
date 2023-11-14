<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ooam_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    function getRevisionAsimiladosOOAM($proyecto, $condominio){
        if($this->session->userdata('id_rol') == 31) { // INTERNOMEX
            $filtro = "pci1.estatus IN (8, 88) AND com.id_usuario = $condominio";
            $where = "";
        } else { // CONTRALORÍA
            $filtro = "pci1.estatus IN (4)";
            if($condominio == 0)
                $where = "AND co.idResidencial  = $proyecto";
            else
                $where = "AND co.idCondominio  = $condominio";       
        }

        $cmd = "SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as nombreLote, re.nombreResidencial as proyecto, lo.nombreLote as lote, 
        lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus,  
        CONVERT(VARCHAR,pci1.fecha_pago_intmex,20) AS fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, cp1.codigo_postal, 
        pci1.id_usuario, oprol.nombre  puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, 
        re.empresa, 0 lugar_prospeccion, co.nombre as condominio, lo.referencia, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, 
        (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto, u.rfc
        FROM pago_ooam_ind pci1 
        INNER JOIN comisiones_ooam com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (3)
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_ooam pac ON pac.id_lote = com.id_lote
        INNER JOIN cp_usuarios cp1 ON pci1.id_usuario = cp1.id_usuario
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
        INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 WHEN 7092 THEN 4 WHEN 9629 THEN 2 ELSE u.id_sede END) and sed.estatus = 1
        LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
        WHERE $filtro $where
        GROUP BY pci1.id_comision,lo.nombreLote,  re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, 
        pci1.fecha_pago_intmex, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, cp1.codigo_postal, 
        oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia,sed.impuesto, u.rfc, oprol2.nombre";

        $query = $this->db->query($cmd); 

        return $query->result_array();
    }

    function getRevisionRemanenteOOAM($proyecto, $condominio){
        if($this->session->userdata('id_rol') == 31) { // INTERNOMEX
            $filtro = "pci1.estatus IN (8, 88) AND com.id_usuario = $condominio";
            $where = "";
        } else { // CONTRALORÍA
            $filtro = "pci1.estatus IN (4)";
            if($condominio == 0)
                $where = "AND co.idResidencial  = $proyecto";
            else
                $where = "AND co.idCondominio  = $condominio";       
        }

        $cmd = "SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as nombreLote, re.nombreResidencial as proyecto, lo.nombreLote as lote, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus,  CONVERT(VARCHAR,pci1.fecha_pago_intmex,20) AS fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, pci1.id_usuario, oprol.nombre  puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre as condominio, lo.referencia, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto, u.rfc
        FROM pago_ooam_ind pci1 
        INNER JOIN comisiones_ooam com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (4)
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_ooam pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
        INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 WHEN 7092 THEN 4 WHEN 9629 THEN 2 ELSE u.id_sede END) and sed.estatus = 1
        LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
        WHERE $filtro $where
        GROUP BY pci1.id_comision,lo.nombreLote,  re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia,sed.impuesto, u.rfc, oprol2.nombre";

        $query = $this->db->query($cmd); 
        return $query->result_array();
    }

    function getRevisionFacturasOOAM($proyecto, $condominio){
        if($this->session->userdata('id_rol') == 31) { // INTERNOMEX
            $filtro = "pci1.estatus IN (8, 88) AND com.id_usuario = $condominio";
            $where = "";
        } else { // CONTRALORÍA
            $filtro = "pci1.estatus IN (4)";
            if($condominio == 0)
                $where = "AND co.idResidencial  = $proyecto";
            else
                $where = "AND co.idCondominio  = $condominio";       
        }

        $cmd = "SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as nombreLote, re.nombreResidencial as proyecto, lo.nombreLote as lote, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus,  CONVERT(VARCHAR,pci1.fecha_pago_intmex,20) AS fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, pci1.id_usuario, oprol.nombre  puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre as condominio, lo.referencia, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto, u.rfc
        FROM pago_ooam_ind pci1 
        INNER JOIN comisiones_ooam com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2)
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_ooam pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
        INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 WHEN 7092 THEN 4 WHEN 9629 THEN 2 ELSE u.id_sede END) and sed.estatus = 1
        LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
        WHERE $filtro $where
        GROUP BY pci1.id_comision,lo.nombreLote,  re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia,sed.impuesto, u.rfc, oprol2.nombre";

        $query = $this->db->query($cmd); 
        return $query->result_array();
    }

    public function consulta_comisiones($sol){
        $cmd = ("SELECT id_pago_i FROM pago_ooam_ind where id_pago_i IN (".$sol.")");
        $query = $this->db->query($cmd);       
        return  count($query->result_array()) > 0 ? $query->result_array() : FALSE ;
    }

    public function update_acepta_contraloria($data , $clave){
        try {
            $id_user_Vl = $this->session->userdata('id_usuario');
            $cmd = "UPDATE pago_ooam_ind SET estatus = 8, modificado_por =  $id_user_Vl  WHERE id_pago_i IN  ($clave) ";
            $query = $this->db->query($cmd);
            
            if($this->db->affected_rows() > 0 )
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

    function insert_phc($data){
            $this->db->insert_batch('historial_ooam', $data);
            return true;
    }

    function getComments($pago){
        
        $cmd = "SELECT DISTINCT(hc.comentario), hc.id_pago_i, hc.id_usuario, 
        convert(nvarchar(20), hc.fecha_movimiento, 113) date_final,
        hc.fecha_movimiento,
        CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_usuario
        FROM historial_ooam hc 
        INNER JOIN pago_ooam_ind pci ON pci.id_pago_i = hc.id_pago_i
        INNER JOIN usuarios u ON u.id_usuario = hc.id_usuario 
        WHERE hc.id_pago_i = $pago
        ORDER BY hc.fecha_movimiento DESC";

        $query = $this->db->query($cmd);
        return $query->result();
    }
    
    function comisiones_Ooam_forma_pago(){
        $usuarioid =  $this->session->userdata('id_usuario');
        $cmd = "SELECT forma_pago FROM usuarios WHERE id_usuario = $usuarioid";
        $query = $this->db->query($cmd);
        return $query->row();
    }
    
    function setPausaPagosOOAM($id_pago_i, $obs , $facturaBandera) {
        $id_user_Vl = $this->session->userdata('id_usuario');
        $respuesta = $this->db->query("INSERT INTO  historial_ooam VALUES ($id_pago_i, $id_user_Vl, GETDATE(), 1, 'SE PAUSÓ COMISIÓN, MOTIVO: ".$obs."')");
        $respuesta = $this->db->query("UPDATE pago_ooam_ind SET estatus = 6, comentario = '".$obs."',modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$id_pago_i.")");
        if($facturaBandera == 1 ){
        $row = $this->db->query("SELECT uuid FROM facturas_ooam WHERE id_comision = ".$id_pago_i.";")->result_array();
        if(count($row) > 0){
            $datos =  $this->db->query("SELECT id_factura, total, id_comision, bandera FROM facturas_ooam WHERE uuid='".$row[0]['uuid']."'")->result_array();
            for ($i=0; $i <count($datos); $i++) { 
                    if($datos[$i]['bandera'] == 1){
                        $respuesta = 1;
                    }else{
                        $comentario = 'Se regresó esta factura que correspondo al pago con id '.$datos[$i]['id_comision'].' con el monto global de '.$datos[$i]['total'].' por motivo de: '.$obs.' ';
                        $respuesta = $this->db->query("UPDATE facturas_ooam set total = 0, id_comision = 0, bandera = 1,descripcion = '$comentario' where id_factura = ".$datos[$i]['id_factura']."");
                        $respuesta = $this->db->query("INSERT INTO historial_ooam VALUES (".$datos[$i]['id_comision'].", ".$this->session->userdata('id_usuario').", GETDATE(), 1, '".$comentario."')");
                    }
            }
        }
        }
  
        return $respuesta;
    }
    
    function get_condominio_lista($proyecto) {
        return $this->db->query("SELECT * FROM condominios WHERE status = 1 AND idResidencial IN($proyecto) ORDER BY nombre");
    }
    
    function SaveCumplimiento($user, $pdf, $opc, $obs = 'NULL')
    {
        $estatus = 1;
        if ($opc == 1) {
            $estatus = 2;
        }
        $respuesta = $this->db->query("INSERT INTO opinion_cumplimiento VALUES ($user,'$pdf',$estatus,GETDATE(), '$obs')");
        if (!$respuesta) {
            return 0;
        } else {
            return 1;
        }
    }
    
    function get_proyecto_lista() {
        return $this->db->query("SELECT idResidencial, UPPER(CONCAT(nombreResidencial, ' - '  ,descripcion)) descripcion, ciudad, status, empresa, clave_residencial, abreviatura, active_comission, sede_residencial, sede 
            FROM residenciales
            WHERE status = 1");
    }
    
    public function findOpinionActiveByIdUsuario($idUsuario){
        $query = $this->db->query("SELECT id_opn, id_usuario, archivo_name FROM opinion_cumplimiento WHERE estatus = 1 AND id_usuario = $idUsuario");
        return $query->row();
    }
    
    function consulta_codigo_postal($id_user){
        return $this->db->query("SELECT estatus, codigo_postal FROM cp_usuarios WHERE id_usuario = $id_user");
    }

    function update_acepta_solicitante($idsol) {
        $query = $this->db->query("UPDATE pago_ooam_ind SET estatus = 4, fecha_pago_intmex = GETDATE(),modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$idsol.")");
        return true;
    }

    public function changeEstatusOpinion($idUsuario)
    {
        $this->db->query("UPDATE opinion_cumplimiento SET estatus = 2 WHERE estatus = 1 AND id_usuario = $idUsuario");
    }
    
    function getDatosComisionesAsesor($estado){
        $user_data = $this->session->userdata('id_usuario');
        $sede = $this->session->userdata('id_sede');
        
        return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, ooamco.comision_total, ooamco.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, lo.nombreLote as lote, oxcpj.nombre as pj_name, u.forma_pago, poam.porcentaje_abono, 0 as factura, 1 expediente, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, poam.bonificacion, 0 lugar_prospeccion, pci1.fecha_abono, opt.fecha_creacion as fecha_opinion, opt.estatus as estatus_opinion, '' as procesoCl, '' as colorProcesoCl, 0 as proceso, 0 as id_cliente_reubicacion_2
            FROM pago_ooam_ind pci1 
            INNER JOIN comisiones_ooam ooamco ON pci1.id_comision = ooamco.id_comision 
            INNER JOIN lotes lo ON lo.idLote = ooamco.id_lote AND lo.status = 1
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
            INNER JOIN usuarios u ON u.id_usuario = ooamco.id_usuario  
            INNER JOIN comisiones_ooam cooam ON u.id_usuario = cooam.id_usuario
            INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago AND oxcpj.id_catalogo = 16 
            LEFT JOIN pago_ooam poam on poam.id_lote = cooam.id_lote
            INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
            LEFT JOIN sedes sed ON sed.id_sede = $sede and sed.estatus = 1
            LEFT JOIN (SELECT id_usuario, fecha_creacion,
            estatus FROM opinion_cumplimiento WHERE estatus = 1) opt ON opt.id_usuario = ooamco.id_usuario
            WHERE pci1.estatus IN ($estado) AND ooamco.id_usuario = $user_data
            GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, ooamco.comision_total, ooamco.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, oxcpj.nombre, u.forma_pago,pci1.id_pago_i, poam.porcentaje_abono, oxcest.nombre, sed.impuesto, poam.bonificacion, opt.fecha_creacion, opt.estatus");
    }


    function leerxml( $xml_leer, $cargar_xml ){
        $str = '';
        if( $cargar_xml ){
            rename( $xml_leer, "./UPLOADS/XMLSOOAM/documento_temporal.txt" );
            $str = file_get_contents( "./UPLOADS/XMLSOOAM/documento_temporal.txt" );
            if( substr ( $str, 0, 3 ) == 'o;?' ){
                $str = str_replace( "o;?", "", $str );
                file_put_contents( './UPLOADS/XMLSOOAM/documento_temporal.txt', $str );
            }
                rename( "./UPLOADS/XMLSOOAM/documento_temporal.txt", $xml_leer );
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
                "cfdi" => $datos_factura['usocfdi'],
                "unidad" => $datos_factura['claveUnidad'],
                "claveProd" => $datos_factura['claveProdServ'],
                "bandera" => 0
            );
            return $this->db->insert("facturas_ooam", $data);
        }

        function GetFormaPago($id){
            return $this->db->query("SELECT forma_pago FROM usuarios WHERE id_usuario=$id");
        }

        function ComisionesEnviar($usuario,$recidencial,$opc){
            switch ($opc) {
                case 3:
                    $consulta = $this->db->query(" SELECT pci.id_pago_i
                    FROM pago_ooam_ind pci
                    INNER JOIN comisiones_ooam com ON com.id_comision = pci.id_comision
                    INNER JOIN lotes lo ON lo.idLote = com.id_lote
                    INNER JOIN condominios cod ON cod.idCondominio = lo.idCondominio
                    INNER JOIN residenciales res ON res.idResidencial = cod.idResidencial
                    INNER JOIN clientes cl ON cl.idLote = lo.idLote
                    INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8)
                    AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
                    WHERE lo.status = 1 AND lo.registro_comision NOT IN (0) AND pci.estatus IN (1, 2)
                    AND contrato.expediente IS NOT NULL AND pci.id_usuario = $usuario AND res.idResidencial = $recidencial")->result_array();
    
                    for($i=0;$i < count($consulta); $i++){
                        $this->db->query("INSERT INTO historial_comisiones VALUES (".$consulta[$i]['id_pago_i'].", ".$usuario.", GETDATE(), 1, 'COLABORADOR ENVÍO A CONTRALORÍA')");
                    }
                    $respuesta = $this->db->query(" UPDATE pago_ooam_ind set estatus = 4,modificado_por='".$this->session->userdata('id_usuario')."'
                    FROM pago_ooam_ind pci
                    INNER JOIN comisiones_ooam com ON com.id_comision = pci.id_comision
                    INNER JOIN lotes lo ON lo.idLote = com.id_lote
                    INNER JOIN condominios cod ON cod.idCondominio = lo.idCondominio
                    INNER JOIN residenciales res ON res.idResidencial = cod.idResidencial
                    INNER JOIN clientes cl ON cl.idLote = lo.idLote
                    INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8)
                    AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
                    WHERE lo.status = 1 AND lo.registro_comision NOT IN (0) AND pci.estatus IN (1, 2)
                    AND contrato.expediente IS NOT NULL AND pci.id_usuario = $usuario AND res.idResidencial = $recidencial");
    
                    if (! $respuesta ) {
                        return 0;
                    } else {
                        return 1;
                    }
                    break;
    
                case 4:
                    $consulta = $this->db->query("  SELECT pci.id_pago_i
                    FROM pago_ooam_ind pci
                    INNER JOIN comisiones_ooam com ON com.id_comision = pci.id_comision
                    INNER JOIN lotes lo ON lo.idLote = com.id_lote
                    INNER JOIN condominios cod ON cod.idCondominio = lo.idCondominio
                    INNER JOIN residenciales res ON res.idResidencial = cod.idResidencial
                    INNER JOIN clientes cl ON cl.idLote = lo.idLote
                    INNER JOIN facturas fac ON fac.id_comision = pci.id_pago_i
                    INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8)
                    AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
                    WHERE lo.status = 1 AND lo.registro_comision NOT IN (0) AND pci.estatus IN (1, 2)
                    AND contrato.expediente IS NOT NULL AND pci.id_usuario = $usuario AND res.idResidencial = $recidencial")->result_array();
                    echo print_r($consulta);
    
                    for($i=0;$i < count($consulta); $i++){
                        $this->db->query("INSERT INTO historial_comisiones VALUES (".$consulta[$i]['id_pago_i'].", ".$usuario.", GETDATE(), 1, 'COLABORADOR ENVÍO A CONTRALORÍA')");
                    }
                    $respuesta = $this->db->query(" UPDATE pago_ooam_ind set estatus = 4,modificado_por='".$this->session->userdata('id_usuario')."'
                    FROM pago_ooam_ind pci
                    INNER JOIN comisiones_ooam com ON com.id_comision = pci.id_comision
                    INNER JOIN lotes lo ON lo.idLote = com.id_lote
                    INNER JOIN condominios cod ON cod.idCondominio = lo.idCondominio
                    INNER JOIN residenciales res ON res.idResidencial = cod.idResidencial
                    INNER JOIN clientes cl ON cl.idLote = lo.idLote
                    INNER JOIN facturas fac ON fac.id_comision = pci.id_pago_i
                    INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8)
                    AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
                    WHERE lo.status = 1 AND lo.registro_comision NOT IN (0) AND pci.estatus IN (1, 2)
                    AND contrato.expediente IS NOT NULL AND pci.id_usuario = $usuario AND res.idResidencial = $recidencial");
    
                    if (! $respuesta ) {
                        return 0;
                    } else {
                        return 1;
                    }
                    break;
                    
                case 1:
                    //ASIMILADOS TODAS
                    $consulta = $this->db->query("SELECT pci.id_pago_i
                    FROM pago_ooam_ind pci
                    INNER JOIN comisiones_ooam com ON com.id_comision = pci.id_comision
                    INNER JOIN lotes lo ON lo.idLote = com.id_lote
                    INNER JOIN condominios cod ON cod.idCondominio = lo.idCondominio
                    INNER JOIN residenciales res ON res.idResidencial = cod.idResidencial
                    INNER JOIN clientes cl ON cl.idLote = lo.idLote
                    INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8)
                    AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
                    WHERE lo.status = 1 AND lo.registro_comision NOT IN (0) AND pci.estatus IN (1, 2)
                    AND contrato.expediente IS NOT NULL AND pci.id_usuario = $usuario  AND res.idResidencial > 0")->result_array();
    
                    for($i=0;$i < count($consulta); $i++){;
                        $this->db->query("INSERT INTO historial_comisiones VALUES (".$consulta[$i]['id_pago_i'].", ".$usuario.", GETDATE(), 1, 'COLABORADOR ENVÍO A CONTRALORÍA')");
                    }
    
                    $respuesta = $this->db->query(" UPDATE pago_ooam_ind set estatus = 4,modificado_por='".$this->session->userdata('id_usuario')."'
                    FROM pago_ooam_ind pci
                    INNER JOIN comisiones_ooam com ON com.id_comision = pci.id_comision
                    INNER JOIN lotes lo ON lo.idLote = com.id_lote
                    INNER JOIN condominios cod ON cod.idCondominio = lo.idCondominio
                    INNER JOIN residenciales res ON res.idResidencial = cod.idResidencial
                    INNER JOIN clientes cl ON cl.idLote = lo.idLote
                    INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8)
                    AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
                    WHERE lo.status = 1 AND lo.registro_comision NOT IN (0) AND pci.estatus IN (1, 2)
                    AND contrato.expediente IS NOT NULL AND pci.id_usuario = $usuario AND res.idResidencial > 0");
    
                    if (! $respuesta ) {
                        return 0;
                    } else {
                        return 1;
                    }
                    break;
    
                case 2:
                    //FACTURAS TODAS
                    $consulta = $this->db->query("SELECT pci.id_pago_i
                    FROM pago_ooam_ind pci
                    INNER JOIN comisiones_ooam com ON com.id_comision = pci.id_comision
                    INNER JOIN lotes lo ON lo.idLote = com.id_lote
                    INNER JOIN condominios cod ON cod.idCondominio = lo.idCondominio
                    INNER JOIN residenciales res ON res.idResidencial = cod.idResidencial
                    INNER JOIN clientes cl ON cl.idLote = lo.idLote
                    INNER JOIN facturas fac ON fac.id_comision = pci.id_pago_i
                    INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8)
                    AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
                    WHERE lo.status = 1 AND lo.registro_comision NOT IN (0) AND pci.estatus IN (1, 2)
                    AND contrato.expediente IS NOT NULL AND pci.id_usuario = $usuario AND res.idResidencial > 0")->result_array();
                    for($i=0;$i < count($consulta); $i++){
                        $this->db->query("INSERT INTO historial_comisiones VALUES (".$consulta[$i]['id_pago_i'].", ".$usuario.", GETDATE(), 1, 'COLABORADOR ENVÍO A CONTRALORÍA')");
                    }
                    $respuesta = $this->db->query("UPDATE pago_ooam_ind set estatus = 4,modificado_por='".$this->session->userdata('id_usuario')."'
                    FROM pago_ooam_ind pci
                    INNER JOIN comisiones_ooam com ON com.id_comision = pci.id_comision
                    INNER JOIN lotes lo ON lo.idLote = com.id_lote
                    INNER JOIN condominios cod ON cod.idCondominio = lo.idCondominio
                    INNER JOIN residenciales res ON res.idResidencial = cod.idResidencial
                    INNER JOIN clientes cl ON cl.idLote = lo.idLote
                    INNER JOIN facturas fac ON fac.id_comision = pci.id_pago_i
                    INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8)
                    AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
                    WHERE lo.status = 1 AND lo.registro_comision NOT IN (0) AND pci.estatus IN (1, 2)
                    AND contrato.expediente IS NOT NULL AND pci.id_usuario = $usuario AND res.idResidencial > 0");
    
                    if (! $respuesta ) {
                        return 0;
                    } else {
                        return 1;
                    }
                    break;
            }
        }

    public function getDatosProyecto($idlote,$id_usuario = ''){
        if($id_usuario == ''){
            $id_user_V3 = $this->session->userdata('id_usuario');
        }else{
            $id_user_V3 = $id_usuario;
        }
        return $this->db->query("SELECT pci.id_pago_i, pci.pago_neodata, pci.abono_neodata  ,res.idResidencial , lot.nombreLote, res.nombreResidencial , res.idResidencial
        FROM pago_ooam_ind pci
        INNER JOIN comisiones_ooam com ON com.id_comision = pci.id_comision
        INNER JOIN lotes lot ON lot.idLote = com.id_lote
        INNER JOIN condominios con ON con.idCondominio = lot.idCondominio
        INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
        WHERE pci.estatus = 1 AND pci.id_usuario = $id_user_V3 AND res.idResidencial = $idlote");     
    }

    function verificar_uuid( $uuid ){
        return $this->db->query("SELECT * FROM facturas_ooam WHERE uuid = '".$uuid."'");
    }
    
    public function borrar_factura($id_comision){
        return $this->db->query("DELETE FROM facturas WHERE id_comision =".$id_comision."");
    }

    function validaLoteComision($referencia, $empresa, $nombreLote){
        $query = $this->db->query("SELECT po.id_lote 
        FROM pago_ooam po 
        INNER JOIN lotes lo ON lo.idLote = po.id_lote
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        WHERE lo.referencia = $referencia AND lo.nombreLote = '".$nombreLote."' AND re.empresa = '".$empresa."'");

        return $query->result_array();
    }

    function insertComisionOOAM($tabla, $data) {
        if ($data != '' && $data != null){
            $response = $this->db->insert($tabla, $data);
            if (!$response) {
                return 0;
            } else {
                return 1;
            }
        } else {
            return 0;
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
        INNER JOIN comisiones_ooam com ON com.id_lote = lo.idLote AND com.estatus in (1,8)
        INNER JOIN pago_ooam_ind pci ON pci.id_comision = com.id_comision
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2) 
        WHERE pci.estatus IN (4) AND u.id_usuario = ".$usuario." GROUP BY re.idResidencial) AND res.status = 1
        AND res.idResidencial IN         
        (SELECT re.idResidencial 
        FROM residenciales re
        INNER JOIN condominios co ON re.idResidencial = co.idResidencial
        INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio
        INNER JOIN comisiones_ooam com ON com.id_lote = lo.idLote AND com.estatus in (1,8)
        INNER JOIN pago_ooam_ind pci ON pci.id_comision = com.id_comision
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2) 
        WHERE pci.estatus IN (1) AND u.id_usuario = ".$usuario." GROUP BY re.idResidencial)");
    }

    function getPlanComision($rol, $planComision){
        $query = $this->db->query("SELECT (CASE 
        WHEN $rol = asesor THEN comAs 
        WHEN $rol = coordinador THEN comCo
        WHEN $rol = gerente THEN comGe 
        WHEN $rol = subdirector THEN comSu 
        WHEN $rol = director THEN comDi 
        END) AS porcentajeComision,
        (CASE 
        WHEN $rol = asesor THEN neoAs 
        WHEN $rol = coordinador THEN neoCo 
        WHEN $rol = gerente THEN neoGe 
        WHEN $rol = subdirector THEN neoSu 
        WHEN $rol = director THEN neoDi 
        END) AS porcentajeNeodata
        
        FROM plan_comision WHERE id_plan = $planComision");
        return $query->row();
    }

    function getInfoLote($referencia, $empresa, $nombreLote){
        $query = $this->db->query("SELECT lo.idLote
        FROM lotes lo
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        WHERE lo.referencia = $referencia AND lo.nombreLote = '".$nombreLote."' AND re.empresa = '".$empresa."'");
        return $query->row();
    }

    public function getDataDispersionOOAM() {
        $this->db->query("SET LANGUAGE Español;");
        $query = $this->db->query("SELECT DISTINCT(l.idLote), res.nombreResidencial, cond.nombre as nombreCondominio, l.nombreLote, (CASE WHEN l.tipo_venta = 1 THEN 'Particular' WHEN l.tipo_venta = 2 THEN 'NORMAL' ELSE ' SIN DEFINIR' END) tipo_venta, (CASE WHEN l.tipo_venta = 1 THEN 'lbl-warning' WHEN l.tipo_venta = 2 THEN 'lbl-green' ELSE 'lbl-gray' END) claseTipo_venta, pc.nombreCliente, pc.estatusContratacion idStatusOOAM, l.totalNeto2, (CASE WHEN year(pc.fecha_modificacion) < 2019 THEN NULL ELSE convert(nvarchar,  pc.fecha_modificacion , 6) END) fecha_sistema, l.referencia, pc.numero_dispersion, pc.bandera,
        CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ', ae.apellido_materno) as asesor, 
        CONCAT(co.nombre, ' ', co.apellido_paterno, ' ', co.apellido_materno) as coordinador,
        CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ', ge.apellido_materno) as gerente, 
        CONCAT(di.nombre, ' ', di.apellido_paterno, ' ', di.apellido_materno) as director, 
        (CASE WHEN pc.plan_comision IN (0) OR pc.plan_comision IS NULL THEN '-' ELSE pl.descripcion END) AS plan_descripcion, pc.plan_comision, l.registro_comision 
        FROM lotes l
        INNER JOIN pago_ooam pc ON pc.id_lote = l.idLote AND pc.bandera in (0,100)
        INNER JOIN condominios cond ON l.idCondominio = cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
        LEFT JOIN clientes_ooam cl ON cl.idLote = pc.id_lote 
        AND cl.fechaModificacion = (select max(cl2.fechaModificacion) from clientes_ooam cl2 Where cl2.idCliente = cl2.idCliente)
        INNER JOIN usuarios ae ON ae.id_usuario = cl.idAsesor 
        LEFT JOIN usuarios co ON co.id_usuario =  cl.idCoordinador 
        LEFT JOIN usuarios ge ON ge.id_usuario = cl.idGerente 
        LEFT JOIN usuarios su ON su.id_usuario = cl.idSubdirector
        LEFT JOIN usuarios di ON di.id_usuario = cl.idDirector
        LEFT JOIN plan_comision pl ON pl.id_plan = pc.plan_comision
        WHERE pc.bandera in (0,100)
        ORDER BY l.idLote");

            
        return $query;
    }


    public function getDataLiquidadasOOAM() {
        $this->db->query("SET LANGUAGE Español;");
        $query = $this->db->query("SELECT DISTINCT(l.idLote), res.nombreResidencial, cond.nombre as nombreCondominio, l.nombreLote, (CASE WHEN l.tipo_venta = 1 THEN 'Particular' WHEN l.tipo_venta = 2 THEN 'NORMAL' ELSE ' SIN DEFINIR' END) tipo_venta, (CASE WHEN l.tipo_venta = 1 THEN 'lbl-warning' WHEN l.tipo_venta = 2 THEN 'lbl-green' ELSE 'lbl-gray' END) claseTipo_venta, pc.nombreCliente, pc.estatusContratacion idStatusOOAM, l.totalNeto2, (CASE WHEN year(pc.fecha_modificacion) < 2019 THEN NULL ELSE convert(nvarchar,  pc.fecha_modificacion , 6) END) fecha_sistema, l.referencia, pc.numero_dispersion, pc.bandera,
        CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ', ae.apellido_materno) as asesor, 
        CONCAT(co.nombre, ' ', co.apellido_paterno, ' ', co.apellido_materno) as coordinador,
        CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ', ge.apellido_materno) as gerente, 
        CONCAT(di.nombre, ' ', di.apellido_paterno, ' ', di.apellido_materno) as director, 
        (CASE WHEN pc.plan_comision IN (0) OR pc.plan_comision IS NULL THEN '-' ELSE pl.descripcion END) AS plan_descripcion, pc.plan_comision, l.registro_comision 
        FROM lotes l
        INNER JOIN pago_ooam pc ON pc.id_lote = l.idLote AND pc.bandera NOT in (0,100)
        INNER JOIN condominios cond ON l.idCondominio = cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial   
        INNER JOIN usuarios ae ON ae.id_usuario = cl.idAsesor 
        LEFT JOIN clientes_ooam cl ON cl.idLote = pc.id_lote 
        AND cl.fechaModificacion = (select max(cl2.fechaModificacion) from clientes_ooam cl2 Where cl2.idCliente = cl2.idCliente)
        LEFT JOIN usuarios co ON co.id_usuario =  cl.idCoordinador 
        LEFT JOIN usuarios ge ON ge.id_usuario = cl.idGerente 
        LEFT JOIN usuarios su ON su.id_usuario = cl.idSubdirector
        LEFT JOIN usuarios di ON di.id_usuario = cl.idDirector
        LEFT JOIN plan_comision pl ON pl.id_plan = pc.plan_comision
        WHERE pc.bandera NOT in (0,100) ORDER BY l.idLote");
            
        return $query;
    }

    function getMontoDispersado(){
        return $this->db->query("SELECT SUM(abono_neodata) monto FROM pago_ooam_ind WHERE id_comision IN (select id_comision from comisiones_ooam) AND MONTH(GETDATE()) = MONTH(fecha_abono) AND Day(GetDate()) = Day(fecha_abono)");
    }

    function getPagosDispersado(){
        return $this->db->query("SELECT count(id_pago_i) pagos FROM pago_ooam_ind WHERE id_comision IN (select id_comision from comisiones_ooam) AND MONTH(GETDATE()) = MONTH(fecha_abono) AND Day(GetDate()) = Day(fecha_abono) AND abono_neodata>0");
    }

    function getLotesDispersado(){
        return $this->db->query("SELECT count(distinct(id_lote)) lotes FROM comisiones_ooam WHERE id_comision IN (select id_comision from pago_ooam_ind WHERE MONTH(GETDATE()) = MONTH(fecha_abono) AND Day(GetDate()) = Day(fecha_abono) AND id_comision IN (SELECT id_comision FROM comisiones_ooam))");
    }

    public function getDatosAbonadoSuma11($idlote){
        return $this->db->query("SELECT SUM(pci.abono_neodata) abonado, pac.total_comision, c2.abono_pagado, cl.totalLote as totalNeto2/*, cl.lugar_prospeccion*/
        FROM lotes lo
        INNER JOIN clientes_ooam cl ON cl.idCliente = lo.idCliente
        INNER JOIN comisiones_ooam c1 ON lo.idLote = c1.id_lote AND c1.estatus = 1
        LEFT JOIN (SELECT SUM(comision_total) abono_pagado, id_comision FROM comisiones_ooam WHERE descuento in (1) AND estatus = 1 GROUP BY id_comision) c2 ON c1.id_comision = c2.id_comision
        INNER JOIN pago_ooam pac ON pac.id_lote = lo.idLote
        LEFT JOIN pago_ooam_ind pci on pci.id_comision = c1.id_comision
        WHERE lo.status = 1 AND cl.estatus = 1 AND c1.estatus = 1 AND lo.idLote in ($idlote)
        GROUP BY lo.idLote, lo.referencia, pac.total_comision, lo.totalNeto2, c2.abono_pagado");
    }

    public function getDatosAbonadoDispersion($idlote){ 
        return $this->db->query("SELECT com.id_comision, com.id_usuario, lo.totalNeto2, lo.idLote, res.idResidencial, lo.referencia, lo.tipo_venta, com.id_lote, lo.nombreLote, com.porcentaje_decimal, CONCAT(us.nombre,' ' ,us.apellido_paterno,' ',us.apellido_materno) colaborador, oxc.nombre as rol, com.comision_total, pci.abono_pagado, com.rol_generado, com.descuento
        FROM comisiones_ooam com
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_ooam_ind 
        GROUP BY id_comision) pci ON pci.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote 
        INNER JOIN usuarios us ON us.id_usuario = com.id_usuario
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = com.rol_generado AND oxc.id_catalogo = 1
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
        INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
        LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = com.rol_generado AND oxc2.id_catalogo = 83
        WHERE com.id_lote = $idlote AND com.estatus = 1  ORDER BY com.rol_generado asc");
    }

    function insert_dispersion_individual($id_comision, $id_usuario, $abono_nuevo, $pago){
        $llenarTablaCliente = ("SELECT com.id_comision, com.id_usuario, lo.totalNeto2, lo.idLote, res.idResidencial, lo.referencia, lo.tipo_venta, com.id_lote, lo.nombreLote, com.porcentaje_decimal, CONCAT(us.nombre,' ' ,us.apellido_paterno,' ',us.apellido_materno) colabora");
        $respuesta = $this->db->query("INSERT INTO pago_ooam_ind (id_comision, id_usuario, abono_neodata, pago_neodata, estatus, creado_por, comentario, descuento_aplicado, modificado_por, abono_final) VALUES (".$id_comision.", ".$id_usuario.", ".$abono_nuevo.",".$pago.", 1, ".$this->session->userdata('id_usuario').", 'NUEVO PAGO', 0, ".$this->session->userdata('id_usuario').", 0)");
        $insert_id_2 = $this->db->insert_id();
        $respuesta = $this->db->query("INSERT INTO historial_ooam VALUES ($insert_id_2, ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'DISPERSÓ PAGO DE COMISIÓN')");

        if (! $respuesta ) {
            return 0;
            } else {   
            return 1;
            }
    }

    public function UpdateLoteDisponible($lote){
        $respuesta =  $this->db->query("UPDATE pago_ooam SET bandera = 1 WHERE id_lote = $lote");
        $respuesta =  $this->db->query("UPDATE pago_ooam_ind SET estatus = 0,modificado_por='".$this->session->userdata('id_usuario')."' WHERE abono_neodata = 0");
        $respuesta =  $this->db->query("UPDATE comisiones_ooam SET estatus = 0,modificado_por='".$this->session->userdata('id_usuario')."' WHERE comision_total = 0");
        if (! $respuesta ) {
            return 0;
        } else {
            return 1;
        }
    }

    function update_pago_dispersion($suma, $ideLote, $pago){
        $respuesta = $this->db->query("UPDATE pago_ooam SET abonado = (abonado + ".$suma."), pendiente = (total_comision-abonado-".$suma."), bandera = 1, ultimo_pago = ".$pago." , ultima_dispersion = GETDATE() WHERE id_lote = ".$ideLote."");
        if (! $respuesta ) {
            return 0;
        } else {
            return 1;
        }
    }

    public function lotes(){
        $cmd = "SELECT SUM(lotes) nuevo_general 
        FROM (SELECT  COUNT(DISTINCT(id_lote)) lotes 
        FROM pago_ooam_ind pci 
        INNER JOIN comisiones_ooam c on c.id_comision = pci.id_comision 
        INNER JOIN usuarios u ON u.id_usuario = pci.creado_por 
        AND u.id_rol IN (32,13,17) 
        INNER JOIN lotes l ON l.idLote = c.id_lote 
        WHERE MONTH(GETDATE()) = MONTH(pci.fecha_abono) 
        AND year(GetDate()) = year(pci.fecha_abono) 
        AND Day(GetDate()) = Day(pci.fecha_abono) 
        AND pci.estatus NOT IN (0) 
        AND l.tipo_venta NOT IN (7) 
        GROUP BY u.id_usuario) as nuevo_general";
        $query = $this->db->query($cmd); 
        $query->result();
        return $query->row();
    }

    public function pagos(){
        $cmd = "SELECT SUM(pagos) nuevo_general 
        FROM (SELECT  count(id_pago_i) pagos 
        FROM pago_ooam_ind pci 
        INNER JOIN comisiones_ooam c on c.id_comision = pci.id_comision 
        INNER JOIN usuarios u ON u.id_usuario = pci.creado_por 
        AND u.id_rol IN (32,13,17) 
        INNER JOIN lotes l ON l.idLote = c.id_lote 
        WHERE MONTH(GETDATE()) = MONTH(pci.fecha_abono) 
        AND year(GetDate()) = year(pci.fecha_abono) 
        AND Day(GetDate()) = Day(pci.fecha_abono) 
        AND pci.estatus NOT IN (0)
        AND l.tipo_venta NOT IN (7) 
        GROUP BY u.id_usuario) as nuevo_general ";
        $query = $this->db->query($cmd);
        $query->result();
        return $query->row();
    }

    public function monto(){
        $cmd = "SELECT ROUND (SUM(monto), 3 ) nuevo_general 
        FROM (SELECT SUM(pci.abono_neodata) monto 
        FROM pago_ooam_ind pci 
        INNER JOIN comisiones_ooam c on c.id_comision = pci.id_comision 
        INNER JOIN usuarios u ON u.id_usuario = pci.creado_por 
        AND u.id_rol IN (32,13,17) INNER JOIN lotes l ON l.idLote = c.id_lote 
        WHERE MONTH(GETDATE()) = MONTH(pci.fecha_abono) 
        AND year(GetDate()) = year(pci.fecha_abono)
        AND Day(GetDate()) = Day(pci.fecha_abono) 
        AND pci.estatus NOT IN (0) 
        AND l.tipo_venta NOT IN (7)
        GROUP BY u.id_usuario) as nuevo_general ";
        $query = $this->db->query($cmd);
        $query->result();
        return $query->row();
    }

    public  function get_lista_usuarios($rol, $forma_pago){
        $cmd = "SELECT id_usuario AS idCondominio, 
                CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS nombre FROM usuarios 
                WHERE id_usuario in (SELECT id_usuario FROM pago_ooam_ind WHERE estatus in (8,88)) AND id_rol = $rol AND forma_pago = $forma_pago ORDER BY nombre";
        $query = $this->db->query($cmd);
        return $query->result_array();
    }

    public function report_empresa(){
        $cmd = "SELECT SUM(pci.abono_neodata) as porc_empresa, res.empresa
        FROM pago_ooam_ind pci 
        INNER JOIN comisiones_ooam com  ON com.id_comision = pci.id_comision
        INNER JOIN lotes lo  ON lo.idLote = com.id_lote 
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales res ON res.idResidencial = con.idResidencial 
        WHERE pci.estatus in (8) GROUP BY res.empresa";

        $query = $this->db->query($cmd);

        return $query->result_array();
        }

    function getRevisionXMLOOAM($proyecto){
        if( $this->session->userdata('id_rol') == 31 ){
            $filtro = "WHERE pci1.estatus IN (8,88) ";
        }
        else{
            $filtro = "WHERE pci1.estatus IN (4) ";
        }
        $user_data = $this->session->userdata('id_usuario');
        switch($this->session->userdata('id_rol')){
            case 2:
            case 3:
            case 7:
            case 9:
            $filtro02 = $filtro.' AND  fa.id_usuario = '.$user_data .' ';
            break;
            default:
            $filtro02 = $filtro.' ';
            break;
        }
            return $this->db->query("SELECT SUM(pci1.abono_neodata) total, re.idResidencial, re.nombreResidencial as proyecto, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, pci1.id_usuario, u.forma_pago, 0 as factura, oxcest.id_opcion id_estatus_actual, re.empresa, opn.estatus estatus_opinion, opn.archivo_name, fa.uuid,fa.nombre_archivo as xmla,fa.bandera, u.rfc
            FROM pago_ooam_ind pci1 
            INNER JOIN comisiones_ooam com ON pci1.id_comision = com.id_comision AND com.estatus in (1,8)
            INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial AND re.idResidencial = $proyecto
            INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2)
            INNER JOIN pago_ooam pac ON pac.id_lote = com.id_lote
            INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
            INNER JOIN opinion_cumplimiento opn ON opn.id_usuario = u.id_usuario and opn.estatus IN (2) 
            INNER JOIN facturas_ooam fa ON fa.id_comision = pci1.id_pago_i
            $filtro02 
            GROUP BY re.idResidencial, re.nombreResidencial, u.nombre, u.apellido_paterno, u.apellido_materno, pci1.id_usuario, u.forma_pago, oxcest.id_opcion, re.empresa, re.idResidencial, opn.estatus, opn.archivo_name, fa.uuid, fa.nombre_archivo, fa.bandera, u.rfc
            ORDER BY u.nombre");
    }

    public function validateDispersionCommissions($lote){
        return $this->db->query("SELECT count(*) dispersion, pc.bandera 
        FROM comisiones_ooam com
        LEFT JOIN pago_ooam pc ON pc.id_lote = com.id_lote and pc.bandera = 0
        WHERE com.id_lote = $lote /*AND com.id_usuario = 2*/ AND com.estatus = 1 AND com.fecha_creacion <= GETDATE() GROUP BY pc.bandera");
    }

        function update_acepta_INTMEX($idsol) {
            return $this->db->query("UPDATE pago_ooam_ind SET estatus = 11, aply_pago_intmex = GETDATE(),modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$idsol.")");
        }

        function consultaComisiones ($id_pago_is){
            $cmd = "SELECT id_pago_i FROM pago_ooam_ind where id_pago_i IN ($id_pago_is)";
            $query = $this->db->query($cmd);
            return count($query->result()) > 0 ? $query->result_array() : 0 ; 
        }
        function getDesarrolloSelectINTMEX($a = ''){

            if($a == ''){
        
                $forma_p = $this->session->userdata('id_usuario');
        
            }else{
                $forma_p = $a;
        
            }
            return $this->db->query("SELECT res.idResidencial id_usuario, res.descripcion  as name_user
            FROM residenciales res WHERE res.idResidencial IN 
                            
                    (SELECT re.idResidencial
                        FROM residenciales re
                        INNER JOIN condominios co ON re.idResidencial = co.idResidencial
                        INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio
                        INNER JOIN comisiones_ooam com ON com.id_lote = lo.idLote AND com.estatus in (1,8)
                        INNER JOIN pago_ooam_ind pci ON pci.id_comision = com.id_comision
                        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario 
                        WHERE pci.estatus IN (8) and u.forma_pago=$forma_p GROUP BY re.idResidencial)");
        
            // return $this->db->query("SELECT res.idResidencial id_usuario, res.nombreResidencial  as name_user, descripcion FROM residenciales res");
        }
        
        function getPagosByProyect($proyect = '',$formap = ''){

            if(!empty($proyect)){
                $id = $proyect;
                $forma = $formap;
            }else{
                $id = 0;
            }
            $datos =array();
            $suma =  $this->db->query("(SELECT sum(pci.abono_neodata) as suma
            FROM residenciales re
            INNER JOIN condominios co ON re.idResidencial = co.idResidencial
            INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio
            INNER JOIN comisiones_ooam com ON com.id_lote = lo.idLote AND com.estatus in (1,8)
            INNER JOIN pago_ooam_ind pci ON pci.id_comision = com.id_comision
            INNER JOIN usuarios u ON u.id_usuario = com.id_usuario 
            WHERE pci.estatus IN (8) and u.forma_pago=$formap and re.idResidencial=$id)")->result_array();
            $ids = $this->db->query("( SELECT pci.id_pago_i
            FROM residenciales re
            INNER JOIN condominios co ON re.idResidencial = co.idResidencial
            INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio
            INNER JOIN comisiones_ooam com ON com.id_lote = lo.idLote AND com.estatus in (1,8)
            INNER JOIN pago_ooam_ind pci ON pci.id_comision = com.id_comision
            INNER JOIN usuarios u ON u.id_usuario = com.id_usuario 
            WHERE pci.estatus IN (8) and u.forma_pago=$forma and re.idResidencial=$id)")->result_array();
            
            $datos[0]=$suma;
            $datos[1]=$ids;
            return $datos;
        }

        
        function update_estatus_pausa($id_pago_i, $obs, $estatus) {
            $id_user_Vl = $this->session->userdata('id_usuario');
            $this->db->query("INSERT INTO  historial_ooam VALUES ($id_pago_i, ".$id_user_Vl.", GETDATE(), 1, 'SE PAUSÓ COMISIÓN, MOTIVO: ".$obs."')");
            return $this->db->query("UPDATE pago_ooam_ind SET estatus = ".$estatus.", comentario = '".$obs."',modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$id_pago_i.")");
        }

        function update_estatus_despausa($id_pago_i, $obs, $estatus) {
            $id_user_Vl = $this->session->userdata('id_usuario');
            $this->db->query("INSERT INTO  historial_ooam VALUES ($id_pago_i, ".$id_user_Vl.", GETDATE(), 1, 'SE ACTIVÓ COMISIÓN, MOTIVO: ".$obs."')");
            return $this->db->query("UPDATE pago_ooam_ind SET estatus = ".$estatus.", comentario = '".$obs."',modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$id_pago_i.")");
        }
        public function registroComisionAsimilados($id_pago){
            $cmd = "SELECT registro_comision from lotes l where l.idLote in (select c.id_lote from comisiones_ooam c WHERE c.id_comision IN (SELECT p.id_comision FROM pago_comision_ind p WHERE p.id_pago_i = $id_pago ";
            
            $query = $this->db->query($cmd);
            
            return  $query->result_array();
            
        }

        function update_estatus_edit($id_pago_i, $obs) {

            $id_user_Vl = $this->session->userdata('id_usuario');
            $this->db->query("INSERT INTO historial_ooam VALUES ($id_pago_i, $id_user_Vl, GETDATE(), 1, 'ACTUALIZÓ CONTRALORIA CON NUEVO MONTO: ".$obs."')");
            return $this->db->query("UPDATE pago_ooam_ind SET abono_neodata = '".$obs."',modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$id_pago_i.")");
        }

        function update_estatus_refresh($idcom) {
            $id_user_Vl = $this->session->userdata('id_usuario');
            $this->db->query("INSERT INTO  historial_ooam VALUES ($idcom, $id_user_Vl, GETDATE(), 1, 'SE ACTIVÓ NUEVAMENTE COMISIÓN')");
            return $this->db->query("UPDATE pago_ooam_ind SET estatus = 4,modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$idcom.")");
        } 
        public function getDatosDocumentos($id_comision, $id_pj){
            if ($id_pj == 1){
                return $this->db->query("(SELECT ox.id_opcion, ox.nombre, 'NO EXISTE' as estado, 
                '0' as expediente FROM opcs_x_cats ox 
                WHERE ox.id_opcion NOT IN (SELECT oxc.id_opcion FROM lotes lo 
                INNER JOIN comisiones_ooam com ON com.id_lote = lo.idLote 
                INNER JOIN historial_documento hd ON hd.idLote = lo.idLote 
                LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = hd.tipo_doc 
                WHERE com.id_comision = ".$id_comision." AND oxc.id_catalogo = 31) 
                AND ox.id_catalogo = 31 AND ox.estatus = 1)
                UNION (SELECT oxc.id_opcion, oxc.nombre, 'EXISTE' as estado, hd.expediente 
                FROM lotes lO INNER JOIN comisiones com ON com.id_lote = lo.idLote
                INNER JOIN historial_documento hd ON hd.idLote = lo.idLote 
                LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = hd.tipo_doc 
                WHERE com.id_comision = ".$id_comision." AND oxc.id_catalogo = 31 AND oxc.estatus = 1)");
            }
            else{
                return $this->db->query("(SELECT ox.id_opcion, ox.nombre, 'NO EXISTE' as estado, 
                '0' as expediente FROM opcs_x_cats ox 
                WHERE ox.id_opcion NOT IN (SELECT oxc.id_opcion FROM lotes lo 
                INNER JOIN comisiones_ooam com ON com.id_lote = lo.idLote 
                INNER JOIN historial_documento hd ON hd.idLote = lo.idLote 
                LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = hd.tipo_doc 
                WHERE com.id_comision = ".$id_comision." AND oxc.id_catalogo = 32) 
                AND ox.id_catalogo = 32 AND ox.estatus = 1)
                UNION (SELECT oxc.id_opcion, oxc.nombre, 'EXISTE' as estado, hd.expediente 
                FROM lotes lO INNER JOIN comisiones_ooam com ON com.id_lote = lo.idLote
                INNER JOIN historial_documento hd ON hd.idLote = lo.idLote 
                LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = hd.tipo_doc 
                WHERE com.id_comision = ".$id_comision." AND oxc.id_catalogo = 32 AND oxc.estatus = 1)");
        
            }
        }

        public function getDataLiquidadasPagoOOAM($val = '') {
            ini_set('memory_limit', -1);
    
            $query = $this->db->query("SELECT DISTINCT(l.idLote), res.nombreResidencial, cond.nombre as nombreCondominio, l.nombreLote,
            (CASE WHEN l.tipo_venta = 1 THEN 'Particular' WHEN l.tipo_venta = 2 THEN 'NORMAL' ELSE ' SIN DEFINIR' END) tipo_venta,
            (CASE WHEN l.tipo_venta = 1 THEN 'lbl-warning' WHEN l.tipo_venta = 2 THEN 'lbl-green' ELSE 'lbl-gray' END) claseTipo_venta,
            (CASE WHEN cl.proceso = 0 THEN '' ELSE oxc0.nombre END) procesoCl,
            (CASE WHEN cl.proceso = 0 THEN '' ELSE 'label lbl-violetBoots' END) colorProcesoCl, cl.proceso, 
            CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) nombreCliente, vc.id_cliente AS compartida, l.idStatusContratacion, l.totalNeto2, 
            (CASE WHEN year(pc.fecha_modificacion) < 2019 THEN NULL ELSE convert(nvarchar,  pc.fecha_modificacion , 6) END) fecha_sistema, se.nombre as sede, l.referencia, cl.id_cliente, 
            CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ', ae.apellido_materno) as asesor, 
            CONCAT(co.nombre, ' ', co.apellido_paterno, ' ', co.apellido_materno) as coordinador,
            CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ', ge.apellido_materno) as gerente, 
            CONCAT(su.nombre, ' ', su.apellido_paterno, ' ', su.apellido_materno) as subdirector, 
            (CASE WHEN re.id_usuario IN (0) OR re.id_usuario IS NULL THEN 'NA' ELSE CONCAT(re.nombre, ' ', re.apellido_paterno, ' ', re.apellido_materno) END) regional,
            CONCAT(di.nombre, ' ', di.apellido_paterno, ' ', di.apellido_materno) as director, 
            (CASE WHEN cl.plan_comision IN (0) OR cl.plan_comision IS NULL THEN '-' ELSE pl.descripcion END) AS plan_descripcion, cl.plan_comision,cl.id_subdirector, cl.id_sede, cl.id_prospecto, cl.lugar_prospeccion,
            (CASE WHEN pe.id_penalizacion IS NOT NULL AND pe.estatus not in (3) THEN 1 ELSE 0 END) penalizacion, pe.bandera as bandera_penalizacion, pe.id_porcentaje_penalizacion, pe.dias_atraso, 
            (CASE WHEN clr.plan_comision IN (0) OR clr.plan_comision IS NULL THEN '-' ELSE plr.descripcion END) AS descripcion_planReu, clr.plan_comision plan_comisionReu, clr.totalNeto2Cl, 
            (CASE WHEN (liquidada2-liquidada) = 0 THEN 1 ELSE 0 END) AS validaLiquidadas, 
            (CASE WHEN clr.banderaComisionCl in (0,8) AND l.registro_comision IN (9) THEN 1
            WHEN clr.banderaComisionCl = 1 AND l.registro_comision IN (9) THEN 2 
            WHEN clr.banderaComisionCl = 7 AND l.registro_comision IN (9) THEN 3 ELSE 0 END) AS bandera_dispersion, 
            l.registro_comision, ISNULL(cl.id_cliente_reubicacion_2, 0) id_cliente_reubicacion_2, ISNULL(reub.reubicadas, 0) reubicadas, CONCAT(l.nombreLote,'</b> <i>(',lor.nombreLote,')</i><b>') as nombreLoteReub, ISNULL(ooamDis.dispersar, 0) banderaOOAM, lor.nombreLote as nombreOtro, abono_comisiones, pc.abonado,  (CASE WHEN ((abono_comisiones-pc.abonado) BETWEEN -1 AND 1) OR (abono_comisiones-pc.abonado) IS NULL THEN 0 ELSE (abono_comisiones-pc.abonado)END) pendiente, pcm.porcentaje_comisiones
    
            FROM lotes l
            INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
            INNER JOIN condominios cond ON l.idCondominio = cond.idCondominio
            INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
            INNER JOIN usuarios ae ON ae.id_usuario = cl.id_asesor
            LEFT JOIN pago_comision pc ON pc.id_lote = l.idLote
            LEFT JOIN (SELECT id_cliente FROM ventas_compartidas WHERE estatus = 1) AS vc ON vc.id_cliente = cl.id_cliente
            LEFT JOIN (SELECT SUM(comision_total) abono_comisiones, id_lote FROM comisiones WHERE estatus in (1) AND id_usuario not in (0) GROUP BY id_lote) cm ON cm.id_lote = l.idLote 
            LEFT JOIN (SELECT SUM(porcentaje_decimal) porcentaje_comisiones, id_lote FROM comisiones WHERE estatus in (1) AND id_usuario not in (0) GROUP BY id_lote) pcm ON pcm.id_lote = l.idLote
            
            LEFT JOIN usuarios co ON co.id_usuario = cl.id_coordinador
            LEFT JOIN usuarios ge ON ge.id_usuario = cl.id_gerente
            LEFT JOIN usuarios su ON su.id_usuario = cl.id_subdirector
            LEFT JOIN usuarios re ON re.id_usuario = cl.id_regional
            LEFT JOIN usuarios di ON di.id_usuario = 2
            LEFT JOIN plan_comision pl ON pl.id_plan = cl.plan_comision
            LEFT JOIN sedes se ON se.id_sede = cl.id_sede       
            LEFT JOIN penalizaciones pe ON pe.id_lote = l.idLote AND pe.id_cliente = l.idCliente
            LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
            LEFT JOIN clientes clr ON clr.id_cliente = cl.id_cliente_reubicacion_2
            LEFT JOIN plan_comision plr ON plr.id_plan = clr.plan_comision
            LEFT JOIN lotes lor ON lor.idLote = clr.idLote
            LEFT JOIN (select COUNT(*) liquidada, id_lote FROM comisiones WHERE liquidada = 1 GROUP BY id_lote) liq ON liq.id_lote = l.idLote
            LEFT JOIN (select COUNT(*) liquidada2, id_lote FROM comisiones WHERE ooam = 2 GROUP BY id_lote) liq2 ON liq2.id_lote = l.idLote
            LEFT JOIN (select COUNT(*) reubicadas, idCliente FROM comisionesReubicadas GROUP BY idCliente) reub ON reub.idCliente = clr.id_cliente
            LEFT JOIN (select COUNT(*) dispersar, id_lote FROM comisiones WHERE ooam = 1 GROUP BY id_lote) ooamDis ON ooamDis.id_lote = l.idLote
            WHERE l.idStatusContratacion BETWEEN 11 AND 15 AND cl.status = 1 AND l.status = 1 AND l.registro_comision in (7) AND l.tipo_venta IS NOT NULL AND l.tipo_venta IN (1,2,7) /*AND YEAR(cl.fechaApartado) = 2023 AND MONTH(cl.fechaApartado) = 03 or l.idLote =50139*/
            ORDER BY l.idLote");
            return $query ;
        }



        function factura_comision( $uuid, $id_res){
            return $this->db->query("SELECT DISTINCT CAST(uuid AS VARCHAR(MAX)) AS uuid ,
            u.nombre, u.apellido_paterno, u.apellido_materno, res.nombreResidencial as nombreLote, f.fecha_factura, f.folio_factura, f.metodo_pago, f.regimen, f.forma_pago, f.cfdi, f.unidad, f.claveProd, f.total, f.total as porcentaje_dinero, f.nombre_archivo, CAST(f.descripcion AS VARCHAR(MAX)) AS descrip,f.fecha_ingreso
            FROM facturas f 
            INNER JOIN usuarios u ON u.id_usuario = f.id_usuario
            INNER JOIN pago_comision_ind pci ON pci.id_pago_i = f.id_comision
            INNER JOIN comisiones com ON com.id_comision = pci.id_comision
            INNER JOIN lotes l ON l.idLote = com.id_lote
            INNER JOIN condominios con ON con.idCondominio = l.idCondominio
            INNER JOIN residenciales res ON res.idResidencial = con.idResidencial and res.idResidencial = $id_res
            WHERE /*MONTH(f.fecha_ingreso) >= 4 AND*/ f.uuid = '".$uuid."' ");
            }

        function getMontoDispersadoDates($fecha1, $fecha2){
            return $this->db->query("SELECT SUM(lotes) as lotes, SUM(comisiones) as comisiones, SUM(pagos) as pagos, SUM(monto) monto
            FROM (
            SELECT COUNT(DISTINCT(id_lote)) lotes , 
            COUNT(c.id_comision) comisiones, 
            COUNT(pci.id_pago_i) pagos, 
            SUM(pci.abono_neodata) monto
            FROM pago_ooam_ind pci 
            INNER JOIN comisiones_ooam c on c.id_comision = pci.id_comision
            INNER JOIN usuarios u ON u.id_usuario = pci.creado_por AND u.id_rol IN (32,13,17) 
            WHERE CAST(pci.fecha_abono as date) >= CAST('$fecha1' AS date)
            AND CAST(pci.fecha_abono as date) <= CAST('$fecha2' AS date) 
            AND pci.estatus NOT IN (0) 
            GROUP BY u.id_usuario) as lotes ; ");
        }

        function getPagosDispersadoDates($fecha1, $fecha2){
            return $this->db->query("SELECT count(id_pago_i) pagos FROM pago_ooam_ind WHERE estatus NOT IN (11,0) AND id_comision IN (select id_comision from comisiones_ooam) AND CAST(fecha_abono as date) >= CAST('$fecha1' AS date) AND CAST(fecha_abono as date) <= CAST('$fecha2' AS date) AND abono_neodata>0");
        }
        
        function getLotesDispersadoDates($fecha1, $fecha2){
            return $this->db->query("SELECT count(distinct(id_lote)) lotes FROM comisiones_ooam WHERE id_comision IN (select id_comision from pago_ooam_ind WHERE CAST(fecha_abono as date) >= CAST('$fecha1' AS date) AND CAST(fecha_abono as date) <= CAST('$fecha2' AS date) AND estatus NOT IN (11,0) AND id_comision IN (SELECT id_comision FROM comisiones_ooam))");
        }



        function getDatosHistorialAsesor(){
            $user_data = $this->session->userdata('id_usuario');
            $sede = $this->session->userdata('id_sede');
            
            return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, 
                ooamco.comision_total, ooamco.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, 
                pci1.fecha_abono fecha_creacion, pci1.id_usuario, lo.nombreLote as lote, oxcpj.nombre as pj_name, 
                u.forma_pago, poam.porcentaje_abono, 0 as factura, 1 expediente, 
                (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, poam.bonificacion, 0 lugar_prospeccion, 
                pci1.fecha_abono, opt.fecha_creacion as fecha_opinion, opt.estatus as estatus_opinion, '' as procesoCl, '' as colorProcesoCl, 0 as proceso, 0 as id_cliente_reubicacion_2
                FROM pago_ooam_ind pci1 
                INNER JOIN comisiones_ooam ooamco ON pci1.id_comision = ooamco.id_comision 
                INNER JOIN lotes lo ON lo.idLote = ooamco.id_lote AND lo.status = 1
                INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                INNER JOIN usuarios u ON u.id_usuario = ooamco.id_usuario  
                INNER JOIN comisiones_ooam cooam ON u.id_usuario = cooam.id_usuario
                INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago AND oxcpj.id_catalogo = 16 
                LEFT JOIN pago_ooam poam on poam.id_lote = cooam.id_lote
                INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
                LEFT JOIN sedes sed ON sed.id_sede = $sede and sed.estatus = 1
                LEFT JOIN (SELECT id_usuario, fecha_creacion,
                estatus FROM opinion_cumplimiento WHERE estatus = 1) opt ON opt.id_usuario = ooamco.id_usuario
                WHERE ooamco.id_usuario = $user_data
                GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, ooamco.comision_total, 
                ooamco.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono, pci1.id_usuario,
                oxcpj.nombre, u.forma_pago,pci1.id_pago_i, poam.porcentaje_abono, oxcest.nombre, sed.impuesto, poam.bonificacion, opt.fecha_creacion, opt.estatus");
        }
        

        
}// llave fin del modal

