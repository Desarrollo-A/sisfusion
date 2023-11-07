<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ooam_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }


    function getDatosNuevasAContraloria($proyecto, $condominio){
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

        $cmd = "SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as nombreLote, re.nombreResidencial as proyecto, lo.nombreLote as lote, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus,  CONVERT(VARCHAR,pci1.fecha_pago_intmex,20) AS fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, cp1.codigo_postal, pci1.id_usuario, oprol.nombre  puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre as condominio, lo.referencia, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto, u.rfc
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
        GROUP BY pci1.id_comision,lo.nombreLote,  re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, cp1.codigo_postal, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia,sed.impuesto, u.rfc, oprol2.nombre";

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
            return $this->db->query("SELECT idResidencial, 
            UPPER(CONCAT(nombreResidencial, ' - '  ,descripcion)) descripcion, 
            ciudad, 
            status, 
            empresa, 
            clave_residencial, 
            abreviatura, 
            active_comission, 
            sede_residencial, 
            sede FROM residenciales
            WHERE status = 1");
         }

         public function findOpinionActiveByIdUsuario($idUsuario)
         {
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
            
            return $this->db->query("(SELECT pci1.id_pago_i, pci1.id_comision,
            re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, 
            ooamco.comision_total, ooamco.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata,
            pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, 
            oxcpj.nombre as pj_name,
            u.forma_pago,
            poam.porcentaje_abono, 0 as factura, 1 expediente, 
            /*(CASE WHEN com.ooam = 1 THEN ' (EEC)' ELSE '' END) estatus_actual, */
            (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto,
            poam.bonificacion, 0 lugar_prospeccion,
            pci1.fecha_abono, opt.fecha_creacion as fecha_opinion, opt.estatus as estatus_opinion,
            '' as procesoCl,
            '' as colorProcesoCl, 0 as proceso, 0 as id_cliente_reubicacion_2
            FROM pago_ooam_ind pci1 
            INNER JOIN comisiones_ooam ooamco ON pci1.id_comision = ooamco.id_comision 
            INNER JOIN lotes lo ON lo.idLote = ooamco.id_lote AND lo.status = 1
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
            INNER JOIN usuarios u ON u.id_usuario = ooamco.id_usuario  
            INNER JOIN comisiones_ooam cooam ON u.id_usuario = cooam.id_usuario
            INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago AND oxcpj.id_catalogo = 16 
            LEFT JOIN pago_ooam poam on poam.id_lote = cooam.id_lote
            /*INNER JOIN opcs_x_cats oxcC ON pci1.estatus = oxcC.id_opcion and oxcC.id_catalogo = 23*/
            INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
            LEFT JOIN sedes sed ON sed.id_sede = $sede and sed.estatus = 1
            LEFT JOIN (SELECT id_usuario, fecha_creacion,
            estatus FROM opinion_cumplimiento WHERE estatus = 1) opt ON opt.id_usuario = ooamco.id_usuario
            WHERE pci1.estatus IN ($estado) 
            AND ( (lo.idStatusContratacion < 9 AND ooamco.estatus IN (1,8)) OR (lo.idStatusContratacion > 8 AND ooamco.estatus IN (8)))
            AND ooamco.id_usuario = $user_data
            GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, lo.totalNeto2,
            ooamco.comision_total, ooamco.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono,
            pci1.id_usuario, oxcpj.nombre, u.forma_pago,pci1.id_pago_i, poam.porcentaje_abono, oxcest.nombre, sed.impuesto,
            poam.bonificacion, opt.fecha_creacion, opt.estatus)
            UNION
            (SELECT pci1.id_pago_i, pci1.id_comision,  
            re.nombreResidencial as proyecto, 
            lo.totalNeto2 precio_lote, ooamco.comision_total, ooamco.porcentaje_decimal, pci1.abono_neodata pago_cliente,
            pci1.pago_neodata, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, oxcpj.nombre as pj_name, u.forma_pago, poam.porcentaje_abono, 0 as factura, 1 expediente,
            (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, poam.bonificacion, cl.lugar_prospeccion,
            pci1.fecha_abono, opt.fecha_creacion AS fecha_opinion, opt.estatus as estatus_opinion, 
            (CASE WHEN cl.proceso = 0 THEN '' ELSE oxc0.nombre END) procesoCl,
            (CASE WHEN cl.proceso = 0 THEN '' ELSE 'label lbl-violetBoots' END) colorProcesoCl, cl.proceso, ISNULL(cl.id_cliente_reubicacion_2, 0)
            FROM pago_ooam_ind pci1 
             INNER JOIN comisiones_ooam ooamco ON pci1.id_comision = ooamco.id_comision 
            INNER JOIN lotes lo ON lo.idLote = ooamco.id_lote AND lo.status = 1
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
            INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
            INNER JOIN usuarios u ON u.id_usuario = ooamco.id_usuario  
            INNER JOIN comisiones_ooam cooam ON u.id_usuario = cooam.id_usuario
            INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago AND oxcpj.id_catalogo = 16 
            LEFT JOIN pago_ooam poam on poam.id_lote = cooam.id_lote
            /*INNER JOIN opcs_x_cats oxcC ON pci1.estatus = oxcC.id_opcion and oxcC.id_catalogo = 23*/
            INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
            INNER JOIN sedes sed ON sed.id_sede = $sede and sed.estatus = 1
            LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
            LEFT JOIN (SELECT id_usuario, fecha_creacion, estatus FROM opinion_cumplimiento WHERE estatus = 1) opt ON opt.id_usuario = ooamco.id_usuario
            WHERE pci1.estatus IN ($estado) AND ooamco.estatus in (1) AND lo.idStatusContratacion > 8
            AND ooamco.id_usuario = $user_data
            GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, lo.totalNeto2,
            ooamco.comision_total, ooamco.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono,
            pci1.id_usuario, oxcpj.nombre, u.forma_pago,pci1.id_pago_i, poam.porcentaje_abono, oxcest.nombre, sed.impuesto,
            poam.bonificacion, cl.lugar_prospeccion, opt.fecha_creacion, opt.estatus, cl.proceso, oxc0.nombre, cl.id_cliente_reubicacion_2)");
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
                "cfdi" => $datos_factura['usocfdi'],
                "unidad" => $datos_factura['claveUnidad'],
                "claveProd" => $datos_factura['claveProdServ']
            );
            return $this->db->insert("facturas", $data);
        }

        function GetFormaPago($id){
            return $this->db->query("SELECT forma_pago FROM usuarios WHERE id_usuario=$id");
        }
        function ComisionesEnviar($usuario,$recidencial,$opc){
            switch ($opc) {
                case 3:
                    $consulta = $this->db->query(" SELECT pci.id_pago_i
                    FROM pago_comision_ind pci
                    INNER JOIN comisiones com ON com.id_comision = pci.id_comision
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
                    $respuesta = $this->db->query(" UPDATE pago_comision_ind set estatus = 4,modificado_por='".$this->session->userdata('id_usuario')."'
                    FROM pago_comision_ind pci
                    INNER JOIN comisiones com ON com.id_comision = pci.id_comision
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
                    FROM pago_comision_ind pci
                    INNER JOIN comisiones com ON com.id_comision = pci.id_comision
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
                    $respuesta = $this->db->query(" UPDATE pago_comision_ind set estatus = 4,modificado_por='".$this->session->userdata('id_usuario')."'
                    FROM pago_comision_ind pci
                    INNER JOIN comisiones com ON com.id_comision = pci.id_comision
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
                    FROM pago_comision_ind pci
                    INNER JOIN comisiones com ON com.id_comision = pci.id_comision
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
    
                    $respuesta = $this->db->query(" UPDATE pago_comision_ind set estatus = 4,modificado_por='".$this->session->userdata('id_usuario')."'
                    FROM pago_comision_ind pci
                    INNER JOIN comisiones com ON com.id_comision = pci.id_comision
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
                    FROM pago_comision_ind pci
                    INNER JOIN comisiones com ON com.id_comision = pci.id_comision
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
                    $respuesta = $this->db->query("UPDATE pago_comision_ind set estatus = 4,modificado_por='".$this->session->userdata('id_usuario')."'
                    FROM pago_comision_ind pci
                    INNER JOIN comisiones com ON com.id_comision = pci.id_comision
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
        FROM pago_comision_ind pci
        INNER JOIN comisiones com ON com.id_comision = pci.id_comision
        INNER JOIN lotes lot ON lot.idLote = com.id_lote
        INNER JOIN condominios con ON con.idCondominio = lot.idCondominio
        INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
        WHERE pci.estatus = 1 AND pci.id_usuario = $id_user_V3 AND res.idResidencial = $idlote");     
    }



    function verificar_uuid( $uuid ){
        return $this->db->query("SELECT * FROM facturas WHERE uuid = '".$uuid."'");
    }
    


    public function borrar_factura($id_comision){
        return $this->db->query("DELETE FROM facturas WHERE id_comision =".$id_comision."");
    }

    
}// llave fin del modal

