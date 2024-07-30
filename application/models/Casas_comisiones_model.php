<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Casas_comisiones_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    function getDatosComisionesAsesor($estado){
        $user_data = $this->session->userdata('id_usuario');
        $sede = $this->session->userdata('id_sede');
        
        return $this->db->query("(SELECT pci1.id_pago_i,'' id_arcus,cl.fechaApartado, pci1.id_comision, (CASE WHEN com.ooam = 2 THEN CONCAT(lo.nombreLote,' <i>(',com.loteReubicado,')</i>') ELSE lo.nombreLote END) lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, oxcpj.nombre as pj_name, u.forma_pago, pac.porcentaje_abono, 0 as factura, 1 expediente, 
            /*(CASE WHEN com.ooam = 1 THEN ' (EEC)' ELSE '' END) estatus_actual, */
            (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (EEC)') ELSE oxcest.nombre END) estatus_actual,

            (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, pac.bonificacion, 0 lugar_prospeccion,
            pci1.fecha_abono, opt.fecha_creacion as fecha_opinion, opt.estatus as estatus_opinion,

            '' as procesoCl,
            '' as colorProcesoCl, 0 as proceso, 0 as id_cliente_reubicacion_2

            FROM pago_casas_ind pci1
            INNER JOIN comisiones_casas com ON pci1.id_comision = com.id_comision
            INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
            INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
            INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago AND oxcpj.id_catalogo = 16
            LEFT JOIN pago_comision_casas pac ON pac.id_lote = com.id_lote
            /*INNER JOIN opcs_x_cats oxcC ON pci1.estatus = oxcC.id_opcion and oxcC.id_catalogo = 23*/
            INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
            LEFT JOIN clientes  cl ON cl.id_cliente=com.idCliente
            LEFT JOIN prospectos pr ON pr.id_prospecto=cl.id_prospecto

            LEFT JOIN sedes sed ON sed.id_sede = $sede and sed.estatus = 1
            LEFT JOIN (SELECT id_usuario, fecha_creacion, estatus FROM opinion_cumplimiento WHERE estatus = 1) opt ON opt.id_usuario = com.id_usuario
            WHERE pci1.estatus IN ($estado) AND ( (lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8 AND com.estatus IN (8))) AND com.id_usuario = $user_data
            GROUP BY pci1.id_comision,pr.id_arcus,cl.fechaApartado,com.ooam,com.loteReubicado, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, oxcpj.nombre, u.forma_pago,pci1.id_pago_i, pac.porcentaje_abono, oxcest.nombre, sed.impuesto, pac.bonificacion, opt.fecha_creacion, opt.estatus)
            UNION
            (SELECT pci1.id_pago_i,TRY_CAST(pr.id_arcus AS char) id_arcus,cl.fechaApartado, pci1.id_comision, (CASE WHEN com.ooam = 2 THEN CONCAT(lo.nombreLote,' <i>(',com.loteReubicado,')</i>') ELSE lo.nombreLote END) lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, oxcpj.nombre as pj_name, u.forma_pago, pac.porcentaje_abono, 0 as factura, 1 expediente,

             /*(CASE WHEN com.ooam = 1 THEN ' (EEC)' ELSE '' END) estatus_actual, */
            (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (EEC)') ELSE oxcest.nombre END) estatus_actual,

            (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, pac.bonificacion, cl.lugar_prospeccion,
            pci1.fecha_abono, opt.fecha_creacion AS fecha_opinion, opt.estatus as estatus_opinion, 

            (CASE WHEN cl.proceso = 0 THEN '' ELSE oxc0.nombre END) procesoCl,
            (CASE WHEN cl.proceso = 0 THEN '' ELSE 'label lbl-violetBoots' END) colorProcesoCl, cl.proceso, ISNULL(cl.id_cliente_reubicacion_2, 0)

            FROM pago_casas_ind pci1 
            INNER JOIN comisiones_casas com ON pci1.id_comision = com.id_comision
            INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
            INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
            LEFT JOIN prospectos pr ON pr.id_prospecto=cl.id_prospecto
            INNER JOIN usuarios u ON u.id_usuario = com.id_usuario  
            INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago AND oxcpj.id_catalogo = 16 
            LEFT JOIN pago_comision_casas pac ON pac.id_lote = com.id_lote
            /*INNER JOIN opcs_x_cats oxcC ON pci1.estatus = oxcC.id_opcion and oxcC.id_catalogo = 23*/
            INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
            INNER JOIN sedes sed ON sed.id_sede = $sede and sed.estatus = 1
            LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
            LEFT JOIN (SELECT id_usuario, fecha_creacion, estatus FROM opinion_cumplimiento WHERE estatus = 1) opt ON opt.id_usuario = com.id_usuario
            WHERE pci1.estatus IN ($estado) AND com.estatus in (1) AND lo.idStatusContratacion > 8   AND com.id_usuario = $user_data
            GROUP BY pci1.id_comision,pr.id_arcus,cl.fechaApartado,com.ooam,com.loteReubicado, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, oxcpj.nombre, u.forma_pago,pci1.id_pago_i, pac.porcentaje_abono, oxcest.nombre, sed.impuesto, pac.bonificacion, cl.lugar_prospeccion, opt.fecha_creacion, opt.estatus, cl.proceso, oxc0.nombre, cl.id_cliente_reubicacion_2)");
    }


    function Opn_cumplimiento($id_usuario)
    {
        return  $query = $this->db->query("SELECT * FROM opinion_cumplimiento WHERE id_usuario = " . $id_usuario . " order by fecha_creacion desc");
    }

    function consulta_codigo_postal($id_user){
        return $this->db->query("SELECT estatus, codigo_postal FROM cp_usuarios WHERE id_usuario = $id_user");
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

    public function getTotalComisionAsesor($idUsuario) {
        $query = $this->db->query("SELECT SUM(pci.abono_neodata) AS total
        FROM pago_casas_ind pci 
        INNER JOIN comisiones_casas com ON pci.id_comision = com.id_comision 
        where pci.estatus = 1 and com.id_usuario = $idUsuario");
        return $query->row();
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

    public function getFechaCorteActual($tipoUsuario,$diaActual){
        $mesActual = date('m');
        $formaPago = $this->session->userdata('forma_pago');
        $filtro = ($tipoUsuario == 2 || $tipoUsuario == 4) ?  ( $diaActual <= 15 ? "AND Day(fechaInicio) <= 17" : (($formaPago == 2 && $tipoUsuario == 2 ) ? " AND Day(fechaInicio) >= 17" :  "AND Day(fechaInicio) >= 17" ) ) : "";
        $filtro2 = $this->session->userdata('id_sede') == 8 ? ",fechaTijuana AS fechaFin" : ",fechaFinGeneral AS fechaFin";
        $tipoUsuario =  $tipoUsuario == 1 ? 0 : ($tipoUsuario == 2 ? 1 : ($tipoUsuario == 4 ? 4 : 3) );
        return $this->db->query("SELECT mes,fechaInicio,corteOoam $filtro2 FROM fechasCorte WHERE estatus = 1 AND 
          corteOoam IN($tipoUsuario) AND YEAR(GETDATE()) = YEAR(fechaInicio) AND mes = $mesActual $filtro ORDER BY corteOoam ASC")->result_array();
    }

    function get_proyecto_lista() {
        return $this->db->query("SELECT idResidencial, UPPER(CONCAT(nombreResidencial, ' - '  ,descripcion)) descripcion,ciudad, status, empresa, clave_residencial, abreviatura, active_comission, sede_residencial, sede FROM residenciales WHERE status = 1");
    }
  
    function update_acepta_solicitante($idsol) {
        $query = $this->db->query("UPDATE pago_casas_ind SET estatus = 4, fecha_pago_intmex = GETDATE(),modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$idsol.")");
        return true;
    }

    function insert_phc($data){
        $this->db->insert_batch('historial_comision_casas', $data);
        return true;
    }

    public function changeEstatusOpinion($idUsuario)
    {
        $this->db->query("UPDATE opinion_cumplimiento SET estatus = 2 WHERE estatus = 1 AND id_usuario = $idUsuario");
    }

    public function insertMany($data)
    {
        $this->db->insert_batch('pagos_invoice', $data);
    }

    function GetFormaPago($id){
        return $this->db->query("SELECT forma_pago FROM usuarios WHERE id_usuario=$id");
    }

    function ComisionesEnviar($usuario,$recidencial,$opc){
        switch ($opc) {
            case 3:
                $consulta = $this->db->query(" SELECT pci.id_pago_i
                FROM pago_casas_ind pci
                INNER JOIN comisiones_casas com ON com.id_comision = pci.id_comision
                INNER JOIN lotes lo ON lo.idLote = com.id_lote
                INNER JOIN condominios cod ON cod.idCondominio = lo.idCondominio
                INNER JOIN residenciales res ON res.idResidencial = cod.idResidencial
                INNER JOIN clientes cl ON cl.idLote = lo.idLote
                INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8)
                AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
                WHERE lo.status = 1 AND lo.registro_comision NOT IN (0) AND pci.estatus IN (1, 2)
                AND contrato.expediente IS NOT NULL AND pci.id_usuario = $usuario AND res.idResidencial = $recidencial")->result_array();

                for($i=0;$i < count($consulta); $i++){
                    $this->db->query("INSERT INTO historial_comision_casas VALUES (".$consulta[$i]['id_pago_i'].", ".$usuario.", GETDATE(), 1, 'COLABORADOR ENVÍO A CONTRALORÍA')");
                }
                $respuesta = $this->db->query(" UPDATE pago_casas_ind set estatus = 4,modificado_por='".$this->session->userdata('id_usuario')."'
                FROM pago_casas_ind pci
                INNER JOIN comisiones_casas com ON com.id_comision = pci.id_comision
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
                FROM pago_casas_ind pci
                INNER JOIN comisiones_casas com ON com.id_comision = pci.id_comision
                INNER JOIN lotes lo ON lo.idLote = com.id_lote
                INNER JOIN condominios cod ON cod.idCondominio = lo.idCondominio
                INNER JOIN residenciales res ON res.idResidencial = cod.idResidencial
                INNER JOIN clientes cl ON cl.idLote = lo.idLote
                INNER JOIN factura_casas fac ON fac.id_comision = pci.id_pago_i
                INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8)
                AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
                WHERE lo.status = 1 AND lo.registro_comision NOT IN (0) AND pci.estatus IN (1, 2)
                AND contrato.expediente IS NOT NULL AND pci.id_usuario = $usuario AND res.idResidencial = $recidencial")->result_array();
                echo print_r($consulta);

                for($i=0;$i < count($consulta); $i++){
                    $this->db->query("INSERT INTO historial_comision_casas VALUES (".$consulta[$i]['id_pago_i'].", ".$usuario.", GETDATE(), 1, 'COLABORADOR ENVÍO A CONTRALORÍA')");
                }
                $respuesta = $this->db->query(" UPDATE pago_casas_ind set estatus = 4,modificado_por='".$this->session->userdata('id_usuario')."'
                FROM pago_casas_ind pci
                INNER JOIN comisiones_casas com ON com.id_comision = pci.id_comision
                INNER JOIN lotes lo ON lo.idLote = com.id_lote
                INNER JOIN condominios cod ON cod.idCondominio = lo.idCondominio
                INNER JOIN residenciales res ON res.idResidencial = cod.idResidencial
                INNER JOIN clientes cl ON cl.idLote = lo.idLote
                INNER JOIN factura_casas fac ON fac.id_comision = pci.id_pago_i
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
                FROM pago_casas_ind pci
                INNER JOIN comisiones_casas com ON com.id_comision = pci.id_comision
                INNER JOIN lotes lo ON lo.idLote = com.id_lote
                INNER JOIN condominios cod ON cod.idCondominio = lo.idCondominio
                INNER JOIN residenciales res ON res.idResidencial = cod.idResidencial
                INNER JOIN clientes cl ON cl.idLote = lo.idLote
                INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8)
                AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
                WHERE lo.status = 1 AND lo.registro_comision NOT IN (0) AND pci.estatus IN (1, 2)
                AND contrato.expediente IS NOT NULL AND pci.id_usuario = $usuario  AND res.idResidencial > 0")->result_array();

                for($i=0;$i < count($consulta); $i++){;
                    $this->db->query("INSERT INTO historial_comision_casas VALUES (".$consulta[$i]['id_pago_i'].", ".$usuario.", GETDATE(), 1, 'COLABORADOR ENVÍO A CONTRALORÍA')");
                }

                $respuesta = $this->db->query(" UPDATE pago_casas_ind set estatus = 4,modificado_por='".$this->session->userdata('id_usuario')."'
                FROM pago_casas_ind pci
                INNER JOIN comisiones_casas com ON com.id_comision = pci.id_comision
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
                FROM pago_casas_ind pci
                INNER JOIN comisiones_casas com ON com.id_comision = pci.id_comision
                INNER JOIN lotes lo ON lo.idLote = com.id_lote
                INNER JOIN condominios cod ON cod.idCondominio = lo.idCondominio
                INNER JOIN residenciales res ON res.idResidencial = cod.idResidencial
                INNER JOIN clientes cl ON cl.idLote = lo.idLote
                INNER JOIN factura_casas fac ON fac.id_comision = pci.id_pago_i
                INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8)
                AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
                WHERE lo.status = 1 AND lo.registro_comision NOT IN (0) AND pci.estatus IN (1, 2)
                AND contrato.expediente IS NOT NULL AND pci.id_usuario = $usuario AND res.idResidencial > 0")->result_array();
                for($i=0;$i < count($consulta); $i++){
                    $this->db->query("INSERT INTO historial_comision_casas VALUES (".$consulta[$i]['id_pago_i'].", ".$usuario.", GETDATE(), 1, 'COLABORADOR ENVÍO A CONTRALORÍA')");
                }
                $respuesta = $this->db->query("UPDATE pago_casas_ind set estatus = 4,modificado_por='".$this->session->userdata('id_usuario')."'
                FROM pago_casas_ind pci
                INNER JOIN comisiones_cassas com ON com.id_comision = pci.id_comision
                INNER JOIN lotes lo ON lo.idLote = com.id_lote
                INNER JOIN condominios cod ON cod.idCondominio = lo.idCondominio
                INNER JOIN residenciales res ON res.idResidencial = cod.idResidencial
                INNER JOIN clientes cl ON cl.idLote = lo.idLote
                INNER JOIN factura_casas fac ON fac.id_comision = pci.id_pago_i
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
        FROM pago_casas_ind pci
        INNER JOIN comisiones_casas com ON com.id_comision = pci.id_comision
        INNER JOIN lotes lot ON lot.idLote = com.id_lote
        INNER JOIN condominios con ON con.idCondominio = lot.idCondominio
        INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
        WHERE pci.estatus = 1 AND pci.id_usuario = $id_user_V3 AND res.idResidencial = $idlote");     
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

    function verificar_uuid( $uuid ){
        return $this->db->query("SELECT * FROM factura_casas WHERE uuid = '".$uuid."'");
    }

    public function borrar_factura($id_comision){
        return $this->db->query("DELETE FROM factura_casas WHERE id_comision =".$id_comision."");
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
        return $this->db->insert("factura_casas", $data);
    }

    public function resumenIndividual($idLote){

        $usuario = $this->session->userdata('id_usuario');
        $cmd = "

        DECLARE @usuario INTEGER,
                @lote INTEGER,
                @rol INTEGER,
                @plan_comisiON INTEGER,
                @excedente FLOAT,
                --@plan_comisiON INTEGER,
            @porcentaje FLOAT; SET @usuario = $usuario; SET @lote = $idLote; SET @rol = (SELECT TOP 1 id_rol
            FROM usuarios
            WHERE id_usuario = @usuario); SET @plan_comisiON = (SELECT cl.plan_comision
            FROM lotes lo
            INNER JOIN clientes cl
            ON cl.id_cliente = lo.idCliente
            WHERE lo.idLote = @lote ); -- Uso de bloques BEGIN y
            IF  @plan_comisiON = 66
            BEGIN
                IF @rol = 7 BEGIN SET @excedente = (SELECT comAs FROM plan_comision WHERE id_plan = @plan_comisiON ); SET @porcentaje = 0.5; END
                ELSE IF @rol = 3 BEGIN SET @excedente = (SELECT comCo FROM plan_comision WHERE id_plan = @plan_comisiON ); SET @porcentaje = 0.2; END
                ELSE IF @rol = 2 BEGIN SET @excedente = (SELECT comSu FROM plan_comision WHERE id_plan = @plan_comisiON ); SET @porcentaje = 0.2; END
                ELSE IF @rol = 1 BEGIN SET @excedente = (SELECT comDi FROM plan_comision WHERE id_plan = @plan_comisiON ); SET @porcentaje = 0.1; END
                ELSE BEGIN SET @excedente = (SELECT comSu FROM plan_comision WHERE id_plan = @plan_comisiON );  SET @porcentaje = 0.0; END;
            END
            ELSE IF @plan_comisiON = 86 
            BEGIN 
                IF @rol = 7 BEGIN SET @excedente = (SELECT comAs FROM plan_comision WHERE id_plan = @plan_comisiON ); SET @porcentaje = 0.5; END
                ELSE IF @rol = 3 BEGIN SET @excedente = (SELECT comCo FROM plan_comision WHERE id_plan = @plan_comisiON ); SET @porcentaje = 0.2; END
                ELSE IF @rol = 2 BEGIN SET @excedente = (SELECT comSu FROM plan_comision WHERE id_plan = @plan_comisiON ); SET @porcentaje = 0.2; END
                ELSE IF @rol = 59 BEGIN SET @excedente = (SELECT comRe FROM plan_comision WHERE id_plan = @plan_comisiON ); SET @porcentaje = 0.2; END
                ELSE IF @rol = 1 BEGIN SET @excedente = (SELECT comDi FROM plan_comision WHERE id_plan = @plan_comisiON ); SET @porcentaje = 0.1; END
                ELSE BEGIN SET @excedente = (SELECT comSu FROM plan_comision WHERE id_plan = @plan_comisiON );  SET @porcentaje = 0.0; END;
            END;
        WITH UltimoValOR AS (SELECT *
            FROM UltimoPrecioDeLote )SELECT cl.id_cliente_reubicacion_2,
                cl.total8P,
                @excedente AS porcentajePlan,
                @plan_comisiON AS planC ,
                supXloteOri.total_origen,
                ContarDestino.numDestino,
                cl.idLote AS idLoteDestino,
                lo.sup AS superficieDestino,
                lo.totalNeto2 AS totalNeto2Destino,
                clReu.id_cliente AS clienteReubicado,
                loReu.idLote AS idLoteOrigen,
                lf1.idLote AS loteFuision,
                lf1.destino AS destino,
                lf.idLotePvOrigen AS pivote,
                loReu.totalNeto2 AS totalNeto2Origen,
                UPDL.anteriOR AS totalNeto2Origen,
                loReu.sup AS superficieOrigen,
                UPDL2.anteriOR AS totalnetoReal,
                loFusi.idLote AS loteReal,
                loFusi.nombreLote AS nombreOrigen,
                loFusi.sup,
                supXloteOri.superOrigen AS superficieOrigen,
                supXloteDesti.superDestino AS superficieDestino,
                ((cl.total8P * @excedente)/100 ) AS ExcedenteDinero,
                ((((supXloteOri.total_origen) / (ContarDestino.numDestino)) * 0.01) *@porcentaje) AS porciento1,
                ((((supXloteOri.total_origen) / (ContarDestino.numDestino)) * 0.01)) AS porciento10,
                ((supXloteDesti.superDestino) - ((supXloteOri.superOrigen * 0.05) + (supXloteOri.superOrigen))) AS Excedente_sup
            FROM lotes lo
        INNER JOIN clientes cl
            ON cl.idLote = lo.idLote
        INNER JOIN clientes clReu
            ON cl.id_cliente_reubicacion_2 = clReu.id_cliente
        INNER JOIN lotes loReu
            ON clReu.idLote = loReu.idLote
        INNER JOIN lotesFusiON lf
            ON lf.idLote = lo.idLote
        LEFT JOIN lotesFusiON lf1
            ON lf1.idLotePvOrigen = lf.idLotePvOrigen
        INNER JOIN lotes loFusi
            ON loFusi.idLote = lf1.idLote
        LEFT JOIN UltimoValOR UPDL2
            ON UPDL2.id_parametro = loFusi.idLote
                AND UPDL2.rn = 1
        LEFT JOIN UltimoValOR UPDL
            ON UPDL.id_parametro = loReu.idLote
                AND UPDL.rn = 1
        LEFT JOIN (SELECT COUNT(idLote) AS numDestino,
                idLotePvOrigen
            FROM lotesFusion
            WHERE destino = 1
            GROUP BY  idLotePvOrigen) ContarDestino
            ON lf1.idLotePvOrigen = ContarDestino.idLotePvOrigen
        LEFT JOIN (SELECT SUM(sup) AS superOrigen,
                SUM(lofusion.totalNeto2) AS total_origen,
                lofusion.idLotePvOrigen
            FROM lotesFusiON lofusion, lotes lote
            WHERE lofusion.idLote = lote.idLote
                AND destino = 0
            GROUP BY  lofusion.idLotePvOrigen) supXloteOri
            ON lf1.idLotePvOrigen = supXloteOri.idLotePvOrigen
        LEFT JOIN (SELECT SUM(sup) AS superDestino,
                lofusion.idLotePvOrigen
            FROM lotesFusiON lofusion, lotes lote
            WHERE lofusion.idLote = lote.idLote
                AND destino = 1
            GROUP BY  lofusion.idLotePvOrigen) supXloteDesti
            ON lf1.idLotePvOrigen = supXloteDesti.idLotePvOrigen
            WHERE lo.idLote = @lote;";
        $query = $this->db->query($cmd);

        return $query->result_array();
    }

    public function resumenIndividualExce($idLote){
        
        $usuario = $this->session->userdata('id_usuario');
        $cmd = "DECLARE @usuario INTEGER,
        @lote INTEGER,
        @rol INTEGER,
        @plan_comision INTEGER,
        @excedente FLOAT,
        @porcentaje FLOAT;

        -- Asignar valores iniciales
        SET @usuario = $usuario;
        SET @lote = $idLote;

        -- Obtener el rol del usuario
        SET @rol = (SELECT TOP 1 id_rol
                    FROM usuarios
                    WHERE id_usuario = @usuario);

        -- Obtener el plan de comisión del lote
        SET @plan_comision = (SELECT cl.plan_comision
                            FROM lotes lo
                            INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
                            WHERE lo.idLote = @lote);

        -- Determinar excedente y porcentaje basado en el plan de comisión y el rol
        IF @plan_comision = 66
        BEGIN
            IF @rol = 7 
            BEGIN 
                SET @excedente = (SELECT CAST(comAs AS FLOAT) FROM plan_comision WHERE id_plan = @plan_comision); 
                SET @porcentaje = 0.5; 
            END
            ELSE IF @rol = 3 
            BEGIN 
                SET @excedente = (SELECT CAST(comCo AS FLOAT) FROM plan_comision WHERE id_plan = @plan_comision); 
                SET @porcentaje = 0.2; 
            END
            ELSE IF @rol = 2 
            BEGIN 
                SET @excedente = (SELECT CAST(comSu AS FLOAT) FROM plan_comision WHERE id_plan = @plan_comision); 
                SET @porcentaje = 0.2; 
            END
            ELSE IF @rol = 1 
            BEGIN 
                SET @excedente = (SELECT CAST(comDi AS FLOAT) FROM plan_comision WHERE id_plan = @plan_comision); 
                SET @porcentaje = 0.1; 
            END
            ELSE 
            BEGIN 
                SET @excedente = (SELECT CAST(comSu AS FLOAT) FROM plan_comision WHERE id_plan = @plan_comision);  
                SET @porcentaje = 0.0; 
            END;
        END
        ELSE IF @plan_comision = 86 
        BEGIN 
            IF @rol = 7 
            BEGIN 
                SET @excedente = (SELECT CAST(comAs AS FLOAT) FROM plan_comision WHERE id_plan = @plan_comision); 
                SET @porcentaje = 0.5; 
            END
            ELSE IF @rol = 3 
            BEGIN 
                SET @excedente = (SELECT CAST(comCo AS FLOAT) FROM plan_comision WHERE id_plan = @plan_comision); 
                SET @porcentaje = 0.2; 
            END
            ELSE IF @rol = 2 
            BEGIN 
                SET @excedente = (SELECT CAST(comSu AS FLOAT) FROM plan_comision WHERE id_plan = @plan_comision); 
                SET @porcentaje = 0.2; 
            END
            ELSE IF @rol = 59 
            BEGIN 
                SET @excedente = (SELECT CAST(comRe AS FLOAT) FROM plan_comision WHERE id_plan = @plan_comision); 
                SET @porcentaje = 0.2; 
            END
            ELSE IF @rol = 1 
            BEGIN 
                SET @excedente = (SELECT CAST(comDi AS FLOAT) FROM plan_comision WHERE id_plan = @plan_comision); 
                SET @porcentaje = 0.1; 
            END
            ELSE 
            BEGIN 
                SET @excedente = (SELECT CAST(comSu AS FLOAT) FROM plan_comision WHERE id_plan = @plan_comision);  
                SET @porcentaje = 0.0; 
            END;
        END;

        -- Definir la CTE para obtener el último valor
        WITH UltimoValor AS (
            SELECT * 
            FROM UltimoPrecioDeLote
        )

        -- Consulta principal
        SELECT cl.id_cliente_reubicacion_2,
            cl.idLote AS idLoteDestino,
            lo.nombreLote AS nombreDestino,
            lo.sup AS superficieDestino,
            lo.totalNeto2 AS totalNeto2Destino,
            clReu.id_cliente AS clienteReubicado,
            loReu.idLote AS idLoteOrigen,
            loReu.nombreLote AS nombreOrigen,
            cl.total8P AS montoExcedente,
            ((lo.sup) - ((loReu.sup * 0.05) + (loReu.sup))) AS Excedente_sup,
            
                ((CAST(UPDL.anterior AS NUMERIC) * 0.01) * @porcentaje) AS porciento1,
                

                UPDL.anterior AS totalNeto2Origen,
            ((cl.total8P * @excedente) / 100) AS ExcedenteDinero,
            loReu.sup AS superficieOrigen
        FROM lotes lo
        INNER JOIN clientes cl ON cl.idLote = lo.idLote 
        INNER JOIN clientes clReu ON cl.id_cliente_reubicacion_2 = clReu.id_cliente		
        INNER JOIN lotes loReu ON clReu.idLote = loReu.idLote 
        LEFT JOIN UltimoValor UPDL   ON UPDL.id_parametro = loReu.idLote AND UPDL.rn = 1
        WHERE lo.idLote = @lote;";
        $query = $this->db->query($cmd);

        return $query->result_array();
    }

      // ----------------------------- modelo de historial_casas --------------------------------


    function getDatosHistorialPago($anio,$proyecto,$tipo) {
        ini_set('memory_limit', -1);

        $tipo = "AND u.tipo = '" . $tipo . "'";

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
        return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, (CASE WHEN com.ooam = 2 THEN CONCAT(lo.nombreLote,' <i>(',com.loteReubicado,')</i>') ELSE lo.nombreLote END) nombreLote, re.nombreResidencial as proyecto, co.nombre as condominio,lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion, 
        CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names ,pci1.id_usuario, CASE WHEN cl.estructura = 1 THEN UPPER(oprol2.nombre) ELSE UPPER(oprol.nombre) END as puesto, 
        (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (EEC)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, pci1.descuento_aplicado, (CASE WHEN cl.lugar_prospeccion IS NULL THEN 0 ELSE cl.lugar_prospeccion END) lugar_prospeccion, lo.referencia, pac.bonificacion, u.estatus as activo, 
        (CASE WHEN pe.id_penalizacion IS NOT NULL THEN 1 ELSE 0 END) penalizacion, oxcest.color,
        (CASE WHEN cl.proceso = 0 THEN '' ELSE oxc0.nombre END) procesoCl,
        (CASE WHEN cl.proceso = 0 THEN '' ELSE 'label lbl-violetBoots' END) colorProcesoCl, cl.proceso, ISNULL(cl.id_cliente_reubicacion_2, 0) id_cliente_reubicacion_2
        FROM pago_casas_ind pci1 
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision 
        FROM pago_casas_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
        GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision and com.estatus = 1
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario $tipo
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.status = 1 AND lo.idStatusContratacion > 8
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_comision_casas pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
        LEFT JOIN penalizaciones pe ON pe.id_lote = lo.idLote AND pe.id_cliente = lo.idCliente
        LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
        LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
        WHERE $filtro_02
        GROUP BY pci1.id_comision,com.ooam,com.loteReubicado, lo.nombreLote, re.nombreResidencial, co.nombre, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, pci1.id_pago_i, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, pci1.descuento_aplicado, cl.lugar_prospeccion, lo.referencia, com.estatus, pac.bonificacion, u.estatus,pe.id_penalizacion, oxcest.color, cl.estructura, oprol2.nombre, cl.proceso, oxc0.nombre, cl.id_cliente_reubicacion_2 ORDER BY lo.nombreLote");
    }

    function getDatosHistorialCancelacion($anio,$proyecto) {
        ini_set('memory_limit', -1);       
        $filtro_00 = ' AND re.idResidencial = '.$proyecto.' AND YEAR(pci1.fecha_abono) = '.$anio.' ';
        $filtro_estatus = ' pci1.estatus IN (0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,51,52,88,16,17,41,42,18,19,20,21,22,23,24,25,26,27,28) ';
        switch ($this->session->userdata('id_rol')) {
            case 1:
            case 2:
            case 3:
            case 7:
            case 9:
                $filtro_02 = ' AND com.id_usuario = '.$this->session->userdata('id_usuario').' '.$filtro_00;
                break;
            case 31:
                $filtro_02 = ' '.$filtro_00;
                $filtro_estatus = ' pci1.estatus IN (8,11,88) AND pci1.pago_neodata > 0 AND pci1.descuento_aplicado != 1 ';
                break;
            default:
                $filtro_02 = ' '.$filtro_00;
                break;
        }
        return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, (CASE WHEN com.ooam = 2 THEN CONCAT(lo.nombreLote,' <i>(',com.loteReubicado,')</i>') ELSE lo.nombreLote END) nombreLote,
         re.nombreResidencial as proyecto, co.nombre as condominio,lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, 
        pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names,
        pci1.id_usuario, CASE WHEN cl.estructura = 1 THEN UPPER(oprol2.nombre) ELSE UPPER(oprol.nombre) END as puesto, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (EEC)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, pci1.descuento_aplicado,
        (CASE WHEN cl.lugar_prospeccion IS NULL THEN 0 ELSE cl.lugar_prospeccion END) lugar_prospeccion, lo.referencia, pac.bonificacion, u.estatus as activo, (CASE WHEN pe.id_penalizacion IS NOT NULL THEN 1 ELSE 0 END) penalizacion, oxcest.color,

        (CASE WHEN cl.proceso = 0 THEN '' ELSE oxc0.nombre END) procesoCl,
        (CASE WHEN cl.proceso = 0 THEN '' ELSE 'label lbl-violetBoots' END) colorProcesoCl, cl.proceso, ISNULL(cl.id_cliente_reubicacion_2, 0) id_cliente_reubicacion_2

        FROM pago_casas_ind pci1 
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision 
        FROM pago_casas_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
        GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
        INNER JOIN comisiones_casas com ON pci1.id_comision = com.id_comision and com.estatus = 8
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
        LEFT JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.status = 1 AND lo.idStatusContratacion > 8 AND com.estatus = 1
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_comision_casas pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
        LEFT JOIN penalizaciones pe ON pe.id_lote = lo.idLote AND pe.id_cliente = lo.idCliente
        LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83

        LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97

        WHERE (($filtro_estatus) OR (pci1.estatus = 0 AND pci1.descuento_aplicado = 1)) $filtro_02 
        GROUP BY pci1.id_comision,com.ooam,com.loteReubicado, lo.nombreLote, re.nombreResidencial, co.nombre, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, pci1.estatus, pci1.fecha_abono, 
        pci1.id_usuario, pci1.id_pago_i, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, pci1.descuento_aplicado, cl.lugar_prospeccion, lo.referencia, com.estatus, pac.bonificacion, 
        u.estatus,pe.id_penalizacion, oxcest.color, cl.estructura, oprol2.nombre, cl.proceso, oxc0.nombre, cl.id_cliente_reubicacion_2 ORDER BY lo.nombreLote");
    }

    function update_estatus_pausa($id_pago_i, $obs, $estatus) {
        $id_user_Vl = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO  historial_comision_casas VALUES ($id_pago_i, ".$id_user_Vl.", GETDATE(), 1, 'SE PAUSÓ COMISIÓN, MOTIVO: ".$obs."')");
        return $this->db->query("UPDATE pago_casas_ind SET estatus = ".$estatus.", comentario = '".$obs."',modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$id_pago_i.")");
    }

    function inforReporteAsesor($id_asesor){
        $query = $this->db->query("SELECT * FROM descuentos_universidad du 
        INNER JOIN pago_casas_ind pci ON du.id_usuario = pci.id_usuario
        INNER JOIN comisiones_casas com ON com.id_comision = pci.id_comision
        INNER JOIN lotes l ON com.id_lote = l.idLote
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
        WHERE pci.estatus=17 AND pci.descuento_aplicado=1 AND com.id_usuario=".$id_asesor);
        return $query->result_array();
    }

    function update_estatus_edit($id_pago_i, $obs) {
        $id_user_Vl = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO historial_comision_casas VALUES ($id_pago_i, $id_user_Vl, GETDATE(), 1, 'ACTUALIZÓ CONTRALORIA CON NUEVO MONTO: ".$obs."')");
        return $this->db->query("UPDATE pago_casas_ind SET abono_neodata = '".$obs."',modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$id_pago_i.")");
    }

    function getHistorialDescuentosPorUsuario() {
        $id_usuario = $this->session->userdata('id_usuario');
        return $this->db->query("SELECT pci.id_pago_i, re.nombreResidencial, cn.nombre nombreCondominio,
        lo.nombreLote, lo.referencia, 
        FORMAT(ISNULL(lo.totalNeto2, 0.00), 'C') precioLote, 
        FORMAT(co.comision_total, 'C') comisionTotal, 
        FORMAT(pci.abono_neodata, 'C') montoDescuento, 
        ISNULL(oxc0.nombre, 'SIN ESPECIFICAR') tipoDescuento,
        (CASE 
        WHEN mrp.evidencia = ('true') THEN 'NA'   
        WHEN mrp.evidencia IS NULL THEN 'Sin préstamo relacionado' 
        
        ELSE mrp.evidencia 
        END) as RelacionMotivo,

        p.evidenciaDocs as evidencia,
        rpp.id_prestamo,rpp.id_relacion_pp, 
        mrp.evidencia as relacion_evidencia,
        mrp.id_opcion as relacionPrestamo,
        oxc0.id_opcion as opcion,
        mrp.estatus
        FROM pago_casas_ind pci  
        INNER JOIN comisiones_casas co ON co.id_comision = pci.id_comision AND co.id_usuario = pci.id_usuario
        INNER JOIN lotes lo ON lo.idLote = co.id_lote AND lo.status IN (0,1)
        INNER JOIN condominios cn ON cn.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = cn.idResidencial
        LEFT JOIN relacion_pagos_prestamo rpp ON rpp.id_pago_i = pci.id_pago_i
        LEFT JOIN prestamos_aut p ON p.id_prestamo = rpp.id_prestamo
        LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = pci.estatus AND oxc0.id_catalogo = 23
        LEFT JOIN motivosRelacionPrestamos mrp ON mrp.id_opcion = oxc0.id_opcion  AND mrp.estatus = 1
        WHERE pci.id_usuario = $id_usuario AND pci.descuento_aplicado = 1")->result_array();
    }
    public function porcentajes($idCliente, $costoConstruccion, $planComision){

            $innerMktd = 4394;
            $innerOtro = 'pl.id_o';
            $innerOtro2 = 'pl.id_o2';
            $innerOtro3 = 'pl.id_o3';
            $innerOtro4 = 'pl.id_o4';
            $innerCoord = 'cA.id_coordinador';
            $innerReg = 'cA.id_regional';

            $rol1 = 'pl.coordinador';//POSTVENTA
            $rol2 = 'pl.regional';//TI
            $rol3 = 'pl.mktd';//ADMINISTRACIÓN
            $rol4 = 'pl.otro';
            $rol5 = 'pl.otro2';
            $rol6 = 'pl.otro3';
            $rol7 = 'pl.otro4';
        

        $joinLotes = 'INNER JOIN lotes lo ON lo.idCliente = cA.id_cliente';
        

        $addCondition = " UNION  /* DIRECTOR */
        (SELECT DISTINCT(u1.id_usuario) AS id_usuario, pl.comDi porcentaje_decimal, (($costoConstruccion/100)*(pl.comDi)) comision_total, (pl.neoDi) porcentaje_neodata, CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, pl.director as id_rol, CASE WHEN cA.estructura = 1 THEN 'Director Comercial General' ELSE 'Director' END detail_rol, 1 as rolVal
        FROM clientes cA 
        $joinLotes  
        INNER JOIN usuarios u1 ON u1.id_usuario = 2
        INNER JOIN plan_comision pl ON pl.id_plan = cA.plan_comision and pl.director not in (0)
        WHERE cA.id_cliente = @idCliente)
        
        /*UNION   MARKETING-ADMINISTRACION 
        (SELECT DISTINCT(u1.id_usuario) AS id_usuario, pl.comMk porcentaje_decimal, (($costoConstruccion/100)*(pl.comMk)) comision_total, (pl.neoMk) porcentaje_neodata, CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, $rol3 as id_rol, (CASE WHEN pl.id_plan IN (66,86) THEN 'Administración' ELSE 'Marketing' END) detail_rol, 6 as rolVal
        FROM clientes cA 
        $joinLotes  
        INNER JOIN plan_comision pl ON pl.id_plan = cA.plan_comision and pl.mktd not in (0)
        INNER JOIN usuarios u1 ON u1.id_usuario = $innerMktd
        WHERE cA.id_cliente = @idCliente) */

        UNION  /* OTRO PRIMERO - Contabilidad */
        (SELECT DISTINCT(u1.id_usuario) AS id_usuario, pl.comOt porcentaje_decimal, (($costoConstruccion/100)*(pl.comOt)) comision_total, (pl.neoOt) porcentaje_neodata, CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, $rol4 as id_rol, (CASE WHEN pl.otro = 45 THEN 'Empresa' WHEN pl.id_o = 690 THEN 'Subdirector' WHEN pl.otro = 2 THEN 'Dr. Regional'  WHEN pl.id_o = 11053 THEN 'Internomex' WHEN pl.id_o = 12841 THEN 'Arcus' WHEN pl.id_plan IN (66,86) THEN 'Contabilidad' WHEN pl.id_plan = 70 THEN 'Asesor convenio' ELSE 'Influencer' END) detail_rol, (CASE WHEN pl.otro = 2 THEN 1 ELSE 7 END) as rolVal
        FROM clientes cA 
        $joinLotes  
        INNER JOIN plan_comision pl ON pl.id_plan = cA.plan_comision and pl.otro not in (0)
        INNER JOIN usuarios u1 ON u1.id_usuario = $innerOtro
        INNER JOIN opcs_x_cats opc ON opc.id_opcion = u1.id_rol AND opc.id_catalogo = 1
        WHERE cA.id_cliente = @idCliente)
        
        UNION  /* OTRO SEGUNDO - Titulación */
        (SELECT DISTINCT(u1.id_usuario) AS id_usuario, pl.comOt2 porcentaje_decimal, (($costoConstruccion/100)*(pl.comOt2)) comision_total, (pl.neoOt2) porcentaje_neodata, CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, $rol5 as id_rol, (CASE WHEN pl.otro2 = 45 THEN 'Empresa' WHEN pl.otro2 = 2 THEN 'Dr. Regional' WHEN pl.id_o2 = 11054 THEN 'Internomex' WHEN pl.id_o2 = 12841 THEN 'Arcus' WHEN pl.id_plan IN (66,86) THEN 'Titulación' WHEN pl.id_plan = 70 THEN 'Coordinador convenio' ELSE 'Influencer' END) detail_rol, (CASE WHEN pl.otro = 2 THEN 1 ELSE 8 END) as rolVal
        FROM clientes cA 
        $joinLotes  
        INNER JOIN plan_comision pl ON pl.id_plan = cA.plan_comision and pl.otro2 not in (0)
        INNER JOIN usuarios u1 ON u1.id_usuario = $innerOtro2
        INNER JOIN opcs_x_cats opc ON opc.id_opcion = u1.id_rol AND opc.id_catalogo = 1
        WHERE cA.id_cliente = @idCliente)

        UNION  /* OTRO TERCERO */
        (SELECT DISTINCT(u1.id_usuario) AS id_usuario, pl.comOt3 porcentaje_decimal, (($costoConstruccion/100)*(pl.comOt3)) comision_total, (pl.neoOt3) porcentaje_neodata, CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, $rol6 as id_rol, (CASE WHEN pl.otro3 = 45 THEN 'Empresa' WHEN pl.otro3 = 2 THEN 'Subdirector' WHEN pl.id_o3 = 11054 THEN 'Internomex' WHEN pl.id_o3 = 12841 THEN 'Arcus' WHEN pl.id_plan IN (66) THEN 'Titulación' WHEN pl.id_plan = 70 THEN 'Gerente convenio' WHEN pl.id_o3 = 13546 THEN 'Director comercial PE' ELSE 'Influencer' END) detail_rol, (CASE WHEN pl.otro = 2 THEN 1 WHEN pl.id_o3 = 13546 THEN 2 ELSE 9 END) as rolVal
        FROM clientes cA 
        $joinLotes  
        INNER JOIN plan_comision pl ON pl.id_plan = cA.plan_comision and pl.otro3 not in (0)
        INNER JOIN usuarios u1 ON u1.id_usuario = $innerOtro3
        INNER JOIN opcs_x_cats opc ON opc.id_opcion = u1.id_rol AND opc.id_catalogo = 1
        WHERE cA.id_cliente = @idCliente) 

        UNION  /* OTRO CUARTO */
        (SELECT DISTINCT(u1.id_usuario) AS id_usuario, pl.comOt4 porcentaje_decimal, (($costoConstruccion/100)*(pl.comOt4)) comision_total, (pl.neoOt4) porcentaje_neodata, CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, $rol7 as id_rol, (CASE WHEN pl.otro4 = 45 THEN 'Empresa' WHEN pl.otro4 = 2 THEN 'Subdirector' WHEN pl.id_o4 = 11054 THEN 'Internomex' WHEN pl.id_o4 = 12841 THEN 'Arcus' WHEN pl.id_plan IN (66,86) THEN 'Titulación' WHEN pl.id_plan = 70 THEN 'Director regional convenio' ELSE 'influencer' END) detail_rol, (CASE WHEN pl.otro = 2 THEN 1 ELSE 10 END) as rolVal
        FROM clientes cA 
        $joinLotes  
        INNER JOIN plan_comision pl ON pl.id_plan = cA.plan_comision and pl.otro4 not in (0)
        INNER JOIN usuarios u1 ON u1.id_usuario = $innerOtro4
        INNER JOIN opcs_x_cats opc ON opc.id_opcion = u1.id_rol AND opc.id_catalogo = 1
        WHERE cA.id_cliente = @idCliente)  ";

        $numAs = $this->db->query("(SELECT (COUNT(distinct(u1.id_usuario))) i FROM clientes cl INNER JOIN ventas_compartidas_casas v1 ON v1.id_cliente = cl.id_cliente AND v1.estatus = 1 AND cl.status = 1 INNER JOIN usuarios u1 ON u1.id_usuario = cl.id_asesor_c or  u1.id_usuario = v1.id_asesor WHERE cl.id_cliente = $idCliente)");
        $numCo = $this->db->query("(SELECT (COUNT(distinct(u1.id_usuario))) i FROM clientes cl LEFT JOIN ventas_compartidas_casas v1 ON v1.id_cliente = cl.id_cliente AND v1.estatus = 1 AND cl.status = 1 INNER JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador_c or  u1.id_usuario = v1.id_coordinador WHERE cl.id_cliente = $idCliente)");
        $numGe = $this->db->query("(SELECT (COUNT(u1.id_usuario)) i FROM clientes cl LEFT JOIN ventas_compartidas_casas v1 ON v1.id_cliente = cl.id_cliente AND v1.estatus = 1 AND cl.status = 1 INNER JOIN usuarios u1 ON u1.id_usuario = cl.id_gerente_c or  u1.id_usuario = v1.id_gerente WHERE cl.id_cliente = $idCliente)");
        $numSu = $this->db->query("(SELECT distinct(COUNT(u1.id_usuario)) i FROM clientes cl LEFT JOIN ventas_compartidas_casas v1 ON v1.id_cliente = cl.id_cliente AND v1.estatus = 1 AND cl.status = 1 INNER JOIN usuarios u1 ON u1.id_usuario = cl.id_subdirector_c or  u1.id_usuario = v1.id_subdirector  WHERE cl.id_cliente = $idCliente)");

        $numAsesores = $numAs->row()->i;
        $numCoordinadores = $numCo->row()->i;
        $numGerente = $numGe->row()->i;
        $numSubdir = $numSu->row()->i;
        
        $multiRegional = 'cA.id_regional';
        $numeroRegionales = $numAsesores;
        

        $fragmento = " u1.id_usuario = v1.id_asesor OR ";

        return $this->db->query("DECLARE @idCliente INTEGER, @numAsesores INTEGER, @numCoordinadores INTEGER, @numGerente INTEGER, @numSubdir INTEGER, @numDir INTEGER
  
        SET @idCliente = $idCliente  
        SET @numAsesores = $numAsesores  
        SET @numCoordinadores = $numCoordinadores 
        SET @numGerente = $numGerente 
        SET @numSubdir = $numSubdir 
        SET @numDir =  1
        
        IF @numAsesores > 1
        
            /* ASESORES */
            (SELECT DISTINCT(u1.id_usuario) AS id_usuario, pl.comAs/@numAsesores porcentaje_decimal, (($costoConstruccion/100)*(pl.comAs/@numAsesores)) comision_total, (pl.neoAs/@numAsesores) porcentaje_neodata, CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, pl.asesor as id_rol,  CASE WHEN cA.estructura = 1 THEN 'Asesor Financiero' ELSE 'Asesor' END detail_rol, 5 as rolVal
            FROM clientes cA 
            $joinLotes  
            INNER JOIN ventas_compartidas_casas v1 ON v1.id_cliente = cA.id_cliente and v1.estatus = 1 and cA.status = 1
            INNER JOIN usuarios u1 ON $fragmento u1.id_usuario = cA.id_asesor_c
            INNER JOIN plan_comision pl ON pl.id_plan = cA.plan_comision and pl.asesor not in (0) 
            WHERE cA.id_cliente = @idCliente)
        
            /*UNION   COORDINADORES 
            (SELECT DISTINCT(u1.id_usuario) AS id_usuario, 
            (pl.comCo/@numAsesores)*((SELECT COUNT(id_coordinador_c) FROM clientes cD WHERE cD.status = 1 AND cD.id_coordinador_c = u1.id_usuario and cD.id_cliente = @idCliente)+(SELECT COUNT(id_coordinador) FROM ventas_compartidas_casas vD WHERE vD.estatus = 1 AND vD.id_coordinador = u1.id_usuario AND vD.id_cliente = @idCliente)) porcentaje_decimal, 
            (($costoConstruccion/100)*(pl.comCo/@numAsesores))*((SELECT COUNT(id_coordinador_c) FROM clientes cD WHERE cD.status = 1 AND cD.id_coordinador_c = u1.id_usuario and cD.id_cliente = @idCliente)+(SELECT COUNT(id_coordinador) FROM ventas_compartidas_casas vD WHERE vD.estatus = 1 AND vD.id_coordinador = u1.id_usuario AND vD.id_cliente = @idCliente)) comision_total, 
            (pl.neoCo/@numAsesores)*((SELECT COUNT(id_coordinador_c) FROM clientes cD WHERE cD.status = 1 AND cD.id_coordinador_c = u1.id_usuario and cD.id_cliente = @idCliente)+(SELECT COUNT(id_coordinador) FROM ventas_compartidas_casas vD WHERE vD.estatus = 1 AND vD.id_coordinador = u1.id_usuario AND vD.id_cliente = @idCliente)) porcentaje_neodata, 
            CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, pl.coordinador as id_rol,  CASE WHEN cA.estructura = 1 THEN 'Líder comercial' ELSE 'Coordinador' END detail_rol, 4 as rolVal
            FROM clientes cA 
            $joinLotes  
            INNER JOIN ventas_compartidas_casas v1 ON v1.id_cliente = cA.id_cliente and v1.estatus = 1 and cA.status = 1
            INNER JOIN usuarios u1 ON u1.id_usuario = v1.id_coordinador OR u1.id_usuario = cA.id_coordinador_c
            INNER JOIN plan_comision pl ON pl.id_plan = cA.plan_comision and pl.coordinador not in (0) 
            WHERE cA.id_cliente = @idCliente)*/
            
            UNION  /* GERENTES */
            (SELECT DISTINCT(u1.id_usuario) AS id_usuario, 
            (pl.comGe/@numAsesores)*((SELECT COUNT(id_gerente_c) FROM clientes cD WHERE cD.status = 1 AND cD.id_gerente_c = u1.id_usuario and cD.id_cliente = @idCliente)+(SELECT COUNT(id_gerente) FROM ventas_compartidas_casas vD WHERE vD.estatus = 1 AND vD.id_gerente = u1.id_usuario AND vD.id_cliente = @idCliente)) porcentaje_decimal, 
            (($costoConstruccion/100)*(pl.comGe/@numAsesores))*((SELECT COUNT(id_gerente_c) FROM clientes cD WHERE cD.status = 1 AND cD.id_gerente = u1.id_usuario and cD.id_cliente = @idCliente)+(SELECT COUNT(id_gerente) FROM ventas_compartidas_casas vD WHERE vD.estatus = 1 AND vD.id_gerente = u1.id_usuario AND vD.id_cliente = @idCliente)) comision_total, 
            (pl.neoGe/@numAsesores)*((SELECT COUNT(id_gerente_c) FROM clientes cD WHERE cD.status = 1 AND cD.id_gerente_c = u1.id_usuario and cD.id_cliente = @idCliente)+(SELECT COUNT(id_gerente) FROM ventas_compartidas_casas vD WHERE vD.estatus = 1 AND vD.id_gerente = u1.id_usuario AND vD.id_cliente = @idCliente)) porcentaje_neodata, 
            CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, pl.gerente as id_rol,  CASE WHEN cA.estructura = 1 THEN 'Embajador' ELSE 'Gerente' END detail_rol, 3 as rolVal  
            FROM clientes cA 
            $joinLotes  
            INNER JOIN ventas_compartidas_casas v1 ON v1.id_cliente = cA.id_cliente and v1.estatus = 1 and cA.status = 1
            INNER JOIN usuarios u1 ON u1.id_usuario = v1.id_gerente OR u1.id_usuario = cA.id_gerente_c
            INNER JOIN plan_comision pl ON pl.id_plan = cA.plan_comision and pl.gerente not in (0) 
            WHERE cA.id_cliente = @idCliente)
            
            UNION  /* SUBDIRECTORES */
            (SELECT DISTINCT(u1.id_usuario) AS id_usuario, 
            (pl.comSu/@numAsesores)*((SELECT COUNT(id_subdirector_c) FROM clientes cD WHERE cD.status = 1 AND cD.id_subdirector_c = u1.id_usuario and cD.id_cliente = @idCliente)+(SELECT COUNT(id_gerente) FROM ventas_compartidas_casas vD WHERE vD.estatus = 1 AND vD.id_subdirector = u1.id_usuario AND vD.id_cliente = @idCliente)) porcentaje_decimal, 
            (($costoConstruccion/100)*(pl.comSu/@numAsesores))*((SELECT COUNT(id_subdirector_c) FROM clientes cD WHERE cD.status = 1 AND cD.id_subdirector_c = u1.id_usuario and cD.id_cliente = @idCliente)+(SELECT COUNT(id_gerente) FROM ventas_compartidas_casas vD WHERE vD.estatus = 1 AND vD.id_subdirector = u1.id_usuario AND vD.id_cliente = @idCliente)) comision_total, 
            (pl.neoSu/@numAsesores)*((SELECT COUNT(id_subdirector_c) FROM clientes cD WHERE cD.status = 1 AND cD.id_subdirector_c = u1.id_usuario and cD.id_cliente = @idCliente)+(SELECT COUNT(id_gerente) FROM ventas_compartidas_casas vD WHERE vD.estatus = 1 AND vD.id_subdirector = 
            u1.id_usuario AND vD.id_cliente = @idCliente)) porcentaje_neodata, 
            CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, pl.subdirector as id_rol, CASE WHEN cA.estructura = 1 THEN 'Subdirector Comercial' ELSE 'Subdirector' END detail_rol, 2 as rolVal  
            FROM clientes cA 
            $joinLotes  
            INNER JOIN ventas_compartidas_casas v1 ON v1.id_cliente = cA.id_cliente and v1.estatus = 1 and cA.status = 1
            INNER JOIN usuarios u1 ON u1.id_usuario = v1.id_subdirector OR u1.id_usuario = cA.id_subdirector_c
            INNER JOIN plan_comision pl ON pl.id_plan = cA.plan_comision and pl.subdirector not in (0)
            WHERE cA.id_cliente = @idCliente)

            /*UNION   REGIONALES 
            (SELECT DISTINCT(u1.id_usuario) AS id_usuario, 
            (pl.comRe/ $numeroRegionales)*
            ((SELECT COUNT(id_gerente) FROM clientes cD WHERE cD.status = 1 AND cD.id_regional = u1.id_usuario and cD.id_cliente = @idCliente)+(SELECT COUNT(id_gerente) FROM ventas_compartidas_casas vD WHERE vD.estatus = 1 AND vD.id_regional = u1.id_usuario AND vD.id_cliente = @idCliente)) porcentaje_decimal, 
            (($costoConstruccion/100)*(pl.comRe/ $numeroRegionales))*((SELECT COUNT(id_gerente) FROM clientes cD WHERE cD.status = 1 AND cD.id_regional = u1.id_usuario and cD.id_cliente = @idCliente)+(SELECT COUNT(id_gerente) FROM ventas_compartidas_casas vD WHERE vD.estatus = 1 AND vD.id_regional = u1.id_usuario AND vD.id_cliente = @idCliente)) comision_total, 
            (pl.neoRe/ $numeroRegionales)*((SELECT COUNT(id_gerente) FROM clientes cD WHERE cD.status = 1 AND cD.id_regional = u1.id_usuario and cD.id_cliente = @idCliente)+(SELECT COUNT(id_gerente) FROM ventas_compartidas_casas vD WHERE vD.estatus = 1 AND vD.id_regional = u1.id_usuario AND vD.id_cliente = @idCliente)) porcentaje_neodata, 
            CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, pl.subdirector as id_rol, 'Director Regional' detail_rol, 2 as rolVal  
            FROM clientes cA 
            $joinLotes  
            INNER JOIN ventas_compartidas_casas v1 ON v1.id_cliente = cA.id_cliente and v1.estatus = 1 and cA.status = 1
            INNER JOIN usuarios u1 ON u1.id_usuario = v1.id_regional OR u1.id_usuario = $multiRegional
            INNER JOIN plan_comision pl ON pl.id_plan = cA.plan_comision and pl.regional not in (0)
            WHERE cA.id_cliente = @idCliente)*/
        
            $addCondition
        
            ORDER BY rolVal 
        
            ELSE  
        
            /* ASESOR */
            (SELECT DISTINCT(u1.id_usuario) AS id_usuario, pl.comAs porcentaje_decimal, (($costoConstruccion/100)*(pl.comAs)) comision_total,
            (pl.neoAs) porcentaje_neodata, CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, pl.asesor as id_rol, 
            CASE WHEN cA.estructura = 1 THEN 'Asesor Financiero' ELSE 'Asesor' END detail_rol, 5 as rolVal
            FROM clientes cA 
            $joinLotes  
            INNER JOIN usuarios u1 ON u1.id_usuario = cA.id_asesor_c
            INNER JOIN plan_comision pl ON pl.id_plan = cA.plan_comision and pl.asesor not in (0)
            WHERE cA.id_cliente = @idCliente)
        
           /* UNION   COORDINADOR 
            (SELECT DISTINCT(u1.id_usuario) AS id_usuario, pl.comCo porcentaje_decimal, (($costoConstruccion/100)*(pl.comCo)) comision_total,
            (pl.neoCo) porcentaje_neodata, CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, $rol1 as id_rol, CASE WHEN cA.estructura = 1 THEN 'Líder comercial' WHEN pl.id_plan IN (66,86) THEN 'Postventa' ELSE 'Coordinador' END detail_rol, 
            CASE WHEN pl.id_plan IN (66,86) THEN 9 ELSE 4 END rolVal
            FROM clientes cA 
            $joinLotes  
            INNER JOIN plan_comision pl ON pl.id_plan = cA.plan_comision and pl.coordinador not in (0)
            INNER JOIN usuarios u1 ON u1.id_usuario = $innerCoord
            WHERE cA.id_cliente = @idCliente)*/
            
            UNION  /* GERENTE */
            (SELECT DISTINCT(u1.id_usuario) AS id_usuario, pl.comGe porcentaje_decimal, (($costoConstruccion/100)*(pl.comGe)) comision_total,
            (pl.neoGe) porcentaje_neodata, CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, pl.gerente as id_rol, CASE WHEN cA.estructura = 1 THEN 'Embajador' ELSE 'Gerente' END detail_rol, 3 as rolVal  
            FROM clientes cA 
            $joinLotes  
            INNER JOIN usuarios u1 ON u1.id_usuario = cA.id_gerente_c
            INNER JOIN plan_comision pl ON pl.id_plan = cA.plan_comision and pl.gerente not in (0)
            WHERE cA.id_cliente = @idCliente)
            
            UNION  /* SUBDIRECTOR */
            (SELECT DISTINCT(u1.id_usuario) AS id_usuario, pl.comSu porcentaje_decimal, (($costoConstruccion/100)*(pl.comSu)) comision_total,
            (pl.neoSu) porcentaje_neodata, CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, pl.subdirector as id_rol, CASE WHEN cA.estructura = 1 THEN 'Subdirector Comercial' ELSE 'Subdirector' END detail_rol, 2 as rolVal  
            FROM clientes cA 
            $joinLotes  
            INNER JOIN usuarios u1 ON u1.id_usuario = cA.id_subdirector_c
            INNER JOIN plan_comision pl ON pl.id_plan = cA.plan_comision and pl.subdirector not in (0)
            WHERE cA.id_cliente = @idCliente)

            /* UNION  REGIONAL 
            (SELECT DISTINCT(u1.id_usuario) AS id_usuario, pl.comRe porcentaje_decimal, (($costoConstruccion/100)*(pl.comRe)) comision_total,
            (pl.neoRe) porcentaje_neodata, CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, $rol2 as id_rol, CASE WHEN pl.id_plan IN (66,86) THEN 'TI Comisión' ELSE 'Director Regional' END detail_rol, 

            CASE WHEN pl.id_plan IN (66,86) THEN 9 ELSE 2 END rolVal

            FROM clientes cA 
            $joinLotes  
            INNER JOIN plan_comision pl ON pl.id_plan = cA.plan_comision and pl.regional not in (0)
            INNER JOIN usuarios u1 ON u1.id_usuario = $innerReg
            WHERE cA.id_cliente = @idCliente) */
            $addCondition
            ORDER BY rolVal");
        
    }

    public function getDataDispersionPago() {
        $this->db->query("SET LANGUAGE Español;");
        $query = $this->db->query("SELECT DISTINCT(l.idLote), res.nombreResidencial, cond.nombre AS nombreCondominio, l.nombreLote,
        (CASE WHEN l.tipo_venta = 1 THEN 'Particular' WHEN l.tipo_venta = 2 THEN 'NORMAL' WHEN l.tipo_venta = 8 THEN 'Reestructura' ELSE ' SIN DEFINIR' END) tipo_venta,
        (CASE WHEN l.tipo_venta = 1 THEN 'lbl-warning' WHEN l.tipo_venta = 2 THEN 'lbl-green' ELSE 'lbl-gray' END) claseTipo_venta,
        (CASE WHEN cl.proceso = 0 THEN '' ELSE oxc0.nombre END) procesoCl,cl.estructura,
        (CASE WHEN cl.proceso = 0 THEN '' ELSE 'label lbl-violetBoots' END) colorProcesoCl, cl.proceso, 
        CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) nombreCliente, vc.id_cliente AS compartida, l.idStatusContratacion, l.totalNeto2, 
        (CASE WHEN year(pc.fecha_modificacion) < 2019 THEN NULL ELSE convert(nvarchar,  pc.fecha_modificacion , 6) END) fecha_sistema, se.nombre AS sede, l.referencia, cl.id_cliente,
        CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ', ae.apellido_materno) AS asesor, 
        CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ', ge.apellido_materno) AS gerente, 
        CONCAT(su.nombre, ' ', su.apellido_paterno, ' ', su.apellido_materno) AS subdirector, 
        (CASE WHEN re.id_usuario IN (0) OR re.id_usuario IS NULL THEN 'NA' ELSE CONCAT(re.nombre, ' ', re.apellido_paterno, ' ', re.apellido_materno) END) regional,
        CONCAT(di.nombre, ' ', di.apellido_paterno, ' ', di.apellido_materno) AS director, 
        (CASE WHEN cl.plan_comision IN (0) OR cl.plan_comision IS NULL THEN '-' ELSE pl.descripcion END) AS plan_descripcion, cl.plan_comision,cl.id_subdirector, cl.id_sede, cl.id_prospecto, cl.lugar_prospeccion,
        (CASE WHEN pe.id_penalizacion IS NOT NULL AND pe.estatus not IN (3) THEN 1 ELSE 0 END) penalizacion, pe.bandera AS bandera_penalizacion, pe.id_porcentaje_penalizacion, pe.dias_atraso, 
        (CASE WHEN clr.plan_comision IN (0) OR clr.plan_comision IS NULL THEN '-' ELSE plr.descripcion END) AS descripcion_planReu, clr.plan_comision plan_comisionReu, clr.totalNeto2Cl, cl.total8P,
        (CASE WHEN (liquidada2-liquidada) = 0 THEN 1 ELSE 0 END) AS validaLiquidadas, 
        (CASE WHEN clr.banderaComisionCl IN (0,8) AND l.registro_comision IN (9) THEN 1
        WHEN clr.banderaComisionCl = 1 AND l.registro_comision IN (9) THEN 2 
        WHEN clr.banderaComisionCl = 7 AND l.registro_comision IN (9) THEN 3 ELSE 0 END) AS bandera_dispersion, l.registro_comision, ISNULL(cl.id_cliente_reubicacion_2, 0) id_cliente_reubicacion_2, ISNULL(reub.reubicadas, 0) reubicadas, 
        (CASE WHEN lf.idLotePvOrigen IS NOT NULL THEN CONCAT(l.nombreLote,'</b> <i>(',lf.nombreLotes,')</i><b>') ELSE CONCAT(l.nombreLote,'</b> <i>(',lor.nombreLote,')</i><b>') END) AS nombreLoteReub, 
        ISNULL(ooamDis.dispersar, 0) banderaOOAM, lf.cuantosDestinos,
        (CASE WHEN lf.idLotePvOrigen IS NOT NULL THEN lf.nombreLotes ELSE lor.nombreLote END) AS nombreOtro,
        lor.sup AS supAnt, l.sup AS supAct, 
        ISNULL(pc.abonado,0) abonadoAnterior,ISNULL(sumComisionReu.sumComisiones,0) sumComisionesReu,lof.sumaFusion,l.totalNeto2 as Precio_Total, pc.porcentaje_abono as Comision_total, pc.ultimo_pago as Comisiones_Pagadas, pc.pendiente as Comisiones_pendientes,mc.opcion as opcionMensualidad, ISNULL(opc_mc.nombre, 'Mensualidad No Existente') AS nombreMensualidad
        FROM lotes l
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
        INNER JOIN condominios cond ON l.idCondominio = cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
        INNER JOIN proceso_casas procs ON procs.idLote=l.idLote 
        INNER JOIN usuarios ae ON ae.id_usuario = cl.id_asesor_c
        LEFT JOIN pago_comision_casas pc ON pc.id_lote = l.idLote AND pc.bandera IN (0,100)
        LEFT JOIN (SELECT id_cliente FROM ventas_compartidas_casas WHERE estatus = 1) AS vc ON vc.id_cliente = cl.id_cliente
        LEFT JOIN usuarios ge ON ge.id_usuario = cl.id_gerente_c
        LEFT JOIN usuarios su ON su.id_usuario = cl.id_subdirector_c
        LEFT JOIN usuarios re ON re.id_usuario = cl.id_regional_c
        LEFT JOIN usuarios di ON di.id_usuario = 2
        LEFT JOIN plan_comision pl ON pl.id_plan = cl.plan_comision
        LEFT JOIN sedes se ON se.id_sede = cl.id_sede       
        LEFT JOIN penalizaciones pe ON pe.id_lote = l.idLote AND pe.id_cliente = l.idCliente
        LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
        LEFT JOIN clientes clr ON clr.id_cliente = cl.id_cliente_reubicacion_2
        LEFT JOIN plan_comision plr ON plr.id_plan = clr.plan_comision
        LEFT JOIN lotes lor ON lor.idLote = clr.idLote
        LEFT JOIN (SELECT idLotePvOrigen, nombreLotes,COUNT(*) cuantosDestinos FROM lotesFusion WHERE destino = 1 GROUP BY idLotePvOrigen, nombreLotes) AS lf ON lf.idLotePvOrigen = clr.idLote
        LEFT JOIN (SELECT COUNT(*) liquidada, id_lote FROM comisiones WHERE liquidada = 1 GROUP BY id_lote) liq ON liq.id_lote = l.idLote
        LEFT JOIN (SELECT COUNT(*) liquidada2, id_lote FROM comisiones WHERE ooam = 2 GROUP BY id_lote) liq2 ON liq2.id_lote = l.idLote
        LEFT JOIN (SELECT COUNT(*) reubicadas, idCliente FROM comisionesReubicadas GROUP BY idCliente) reub ON reub.idCliente = clr.id_cliente
        LEFT JOIN (SELECT COUNT(*) dispersar, id_lote FROM comisiones WHERE ooam = 1 GROUP BY id_lote) ooamDis ON ooamDis.id_lote = l.idLote
        LEFT JOIN (SELECT SUM(comision_total) AS sumComisiones,idCliente FROM comisiones WHERE estatus=8 GROUP BY idCliente) sumComisionReu ON sumComisionReu.idCliente = cl.id_cliente_reubicacion_2
        LEFT JOIN (SELECT SUM(totalNeto2) as sumaFusion,idLotePvOrigen FROM lotesFusion WHERE origen=1 GROUP BY idLotePvOrigen) lof ON lof.idLotePvOrigen=clr.idLote
        LEFT JOIN mensualidad_cliente mc ON mc.id_lote = l.idLote 
        LEFT JOIN opcs_x_cats opc_mc ON opc_mc.id_opcion = mc.opcion AND opc_mc.id_catalogo= 127
        WHERE l.idLote IN (7167,7168,10304,17231,18338,18549,23730,27250,25836) 
        AND l.registro_comision not IN (7) 
        AND (pc.bandera IN (0,100) OR pc.bandera IS NULL)
        AND cl.proceso IN (0)
        OR (
        l.idStatusContratacion IN (9,10,13,14,15) 
        AND cl.status = 1 
        AND l.status IN (0,1) 
        AND (l.registro_comision IN (0,8,2,9) OR (l.registro_comision IN (1,8,9) 
        AND pc.bandera IN (0,100))) 
        AND ((l.tipo_venta IS NULL OR l.tipo_venta IN (0,1,2) AND ISNULL(l.totalNeto2, 0) > 0) OR (l.tipo_venta IN (8))) 
        AND cl.fechaApartado >= '2020-03-01' 
        AND (cl.id_subdirector IS NOT NULL AND cl.id_subdirector != '' AND cl.id_subdirector != 0 )
        )
        ORDER BY l.idLote"); 
        return $query;
    }
    

}