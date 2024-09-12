<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Casas_comisiones_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    function getDatosComisionesAsesor($estado){
        $estado = $estado == 6 ? '6,88' : $estado;
        $user_data = $this->session->userdata('id_usuario');
        $sede = $this->session->userdata('id_sede');
        
        return $this->db->query("(SELECT pci1.id_pago_i,'' id_arcus,cl.fechaApartado, pci1.id_comision, (CASE WHEN com.ooam = 2 THEN CONCAT(lo.nombreLote,' <i>(',com.loteReubicado,')</i>') ELSE lo.nombreLote END) lote, re.nombreResidencial as proyecto, cl.costo_construccion precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, oxcpj.nombre as pj_name, u.forma_pago, pac.porcentaje_abono, 0 as factura, 1 expediente, 
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
            WHERE pci1.estatus IN ($estado) AND ( (lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8 AND com.estatus IN (8))) AND com.id_usuario = $user_data AND pci1.abono_neodata > 0
            GROUP BY pci1.id_comision,pr.id_arcus,cl.fechaApartado,com.ooam,com.loteReubicado, lo.nombreLote, re.nombreResidencial, cl.costo_construccion, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, oxcpj.nombre, u.forma_pago,pci1.id_pago_i, pac.porcentaje_abono, oxcest.nombre, sed.impuesto, pac.bonificacion, opt.fecha_creacion, opt.estatus)
            UNION
            (SELECT pci1.id_pago_i,TRY_CAST(pr.id_arcus AS char) id_arcus,cl.fechaApartado, pci1.id_comision, (CASE WHEN com.ooam = 2 THEN CONCAT(lo.nombreLote,' <i>(',com.loteReubicado,')</i>') ELSE lo.nombreLote END) lote, re.nombreResidencial as proyecto, cl.costo_construccion precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, oxcpj.nombre as pj_name, u.forma_pago, pac.porcentaje_abono, 0 as factura, 1 expediente,

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
            WHERE pci1.estatus IN ($estado) AND com.estatus in (1) AND lo.idStatusContratacion > 8   AND com.id_usuario = $user_data AND pci1.abono_neodata > 0
            GROUP BY pci1.id_comision,pr.id_arcus,cl.fechaApartado,com.ooam,com.loteReubicado, lo.nombreLote, re.nombreResidencial, cl.costo_construccion, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, oxcpj.nombre, u.forma_pago,pci1.id_pago_i, pac.porcentaje_abono, oxcest.nombre, sed.impuesto, pac.bonificacion, cl.lugar_prospeccion, opt.fecha_creacion, opt.estatus, cl.proceso, oxc0.nombre, cl.id_cliente_reubicacion_2)");
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

    public function getFechaCorteActual($diaActual){

        $id_user_Vl = $this->session->userdata('id_usuario');
        $multitipo = $this->db->query("SELECT tipo FROM multitipo WHERE id_usuario = $id_user_Vl")->result_array();
        $tipo = $multitipo != null ?  $multitipo[0]["tipo"] : $this->session->userdata('tipo');
        $tipoUsuario = $tipo == 2 ? 1 : ($tipo == 3 || $tipo == 4 ? $tipo : 0);
        //  var_dump($tipoUsuario);

        // $tipoUsuario =  $this->session->userdata('tipo');
        $mesActual = date('m');
        $formaPago = $this->session->userdata('forma_pago');
        $filtro =   in_array($tipoUsuario, [2,4,3], true) ?  ( $diaActual <= 15 ? "AND Day(fechaInicio) <= 17" : (($formaPago == 2 && $tipoUsuario == 2 ) ? " AND Day(fechaInicio) >= 17" :  "AND Day(fechaInicio) >= 15" ) ) : "";
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
                INNER JOIN comisiones_casas com ON com.id_comision = pci.id_comision
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
            rename( $xml_leer, "./UPLOADS/XMLS_CASAS/documento_temporal.txt" );
            $str = file_get_contents( "./UPLOADS/XMLS_CASAS/documento_temporal.txt" );
            if( substr ( $str, 0, 3 ) == 'o;?' ){
                $str = str_replace( "o;?", "", $str );
                file_put_contents( './UPLOADS/XMLS_CASAS/documento_temporal.txt', $str );
            }
            rename( "./UPLOADS/XMLS_CASAS/documento_temporal.txt", $xml_leer );
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

    function update_estatus_despausa($id_pago_i, $obs, $estatus) {
        $id_user_Vl = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO  historial_comision_casas VALUES ($id_pago_i, ".$id_user_Vl.", GETDATE(), 1, 'SE ACTIVÓ COMISIÓN, MOTIVO: ".$obs."')");
        return $this->db->query("UPDATE pago_casas_ind SET estatus = ".$estatus.", comentario = '".$obs."',modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$id_pago_i.")");
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
            WHERE id_usuario = @usuario); SET @plan_comisiON = (SELECT cl.plan_comision_c
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
        SET @plan_comision = (SELECT cl.plan_comision_c
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

    function getComments($pago){
        $this->db->query("SET LANGUAGE Español;");
        return $this->db->query("SELECT DISTINCT(hc.comentario), hc.id_pago_i, hc.id_usuario, convert(nvarchar(20), hc.fecha_movimiento, 113) date_final, hc.fecha_movimiento, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_usuario
        FROM historial_comision_casas hc 
        INNER JOIN pago_casas_ind pci ON pci.id_pago_i = hc.id_pago_i
        INNER JOIN usuarios u ON u.id_usuario = hc.id_usuario 
        WHERE hc.id_pago_i = $pago
        ORDER BY hc.fecha_movimiento DESC");
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
        INNER JOIN comisiones_casas com ON com.id_lote = lo.idLote AND com.estatus in (1,8)
        INNER JOIN pago_casas_ind pci ON pci.id_comision = com.id_comision
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2) 
        WHERE pci.estatus IN (4) AND u.id_usuario = ".$usuario." GROUP BY re.idResidencial) AND res.status = 1
        AND res.idResidencial IN         
        (SELECT re.idResidencial 
        FROM residenciales re
        INNER JOIN condominios co ON re.idResidencial = co.idResidencial
        INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio
        INNER JOIN comisiones_casas com ON com.id_lote = lo.idLote AND com.estatus in (1,8)
        INNER JOIN pago_casas_ind pci ON pci.id_comision = com.id_comision
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2) 
        WHERE pci.estatus IN (1) AND u.id_usuario = ".$usuario." GROUP BY re.idResidencial)");
    }

      // ----------------------------- modelo de historial_casas --------------------------------


    function getDatosHistorialPago($anio,$proyecto,$tipo) {
        ini_set('memory_limit', -1);

        // $tipo = "AND u.tipo = '" . $tipo . "'";

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
        
        return $this->db->query("SELECT pci1.id_pago_i, COUNT(pcbo.id_pago_i) AS cuantos_pagos, pci1.id_comision, (CASE WHEN com.ooam = 2 THEN CONCAT(lo.nombreLote,' <i>(',com.loteReubicado,')</i>') ELSE lo.nombreLote END) nombreLote, re.nombreResidencial as proyecto, co.nombre as condominio, cl.costo_construccion precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion, 
        CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names ,pci1.id_usuario, CASE WHEN cl.estructura = 1 THEN UPPER(oprol2.nombre) ELSE UPPER(oprol.nombre) END as puesto, 
        (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (EEC)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, pci1.descuento_aplicado, (CASE WHEN cl.lugar_prospeccion IS NULL THEN 0 ELSE cl.lugar_prospeccion END) lugar_prospeccion, lo.referencia, pac.bonificacion, u.estatus as activo, 
        (CASE WHEN pe.id_penalizacion IS NOT NULL THEN 1 ELSE 0 END) penalizacion, oxcest.color,
        (CASE WHEN cl.proceso = 0 THEN '' ELSE oxc0.nombre END) procesoCl,
        (CASE WHEN cl.proceso = 0 THEN '' ELSE 'label lbl-violetBoots' END) colorProcesoCl, cl.proceso, ISNULL(cl.id_cliente_reubicacion_2, 0) id_cliente_reubicacion_2
        FROM pago_casas_ind pci1 
        LEFT JOIN pago_comision_bono pcbo on pcbo.id_pago_i = pci1.id_pago_i
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision 
        FROM pago_casas_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
        GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
        INNER JOIN comisiones_casas com ON pci1.id_comision = com.id_comision and com.estatus = 1
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario --$tipo
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.status = 1 AND lo.idStatusContratacion > 8
        INNER JOIN usuarios us ON us.id_usuario = pci1.id_usuario
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = us.id_rol AND oprol.id_catalogo = 1
        INNER JOIN pago_comision_casas pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
        LEFT JOIN penalizaciones pe ON pe.id_lote = lo.idLote AND pe.id_cliente = lo.idCliente
        LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
        LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
        WHERE $filtro_02 AND pci1.abono_neodata > 0
        GROUP BY pci1.id_comision,com.ooam,com.loteReubicado, lo.nombreLote, re.nombreResidencial, co.nombre, cl.costo_construccion, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, pci1.id_pago_i, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, pci1.descuento_aplicado, cl.lugar_prospeccion, lo.referencia, com.estatus, pac.bonificacion, u.estatus,pe.id_penalizacion, oxcest.color, cl.estructura, oprol2.nombre, cl.proceso, oxc0.nombre, cl.id_cliente_reubicacion_2 ORDER BY lo.nombreLote");
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
    public function findOpinionActiveByIdUsuario($idUsuario)
    {
        $query = $this->db->query("SELECT id_opn, id_usuario, archivo_name FROM opinion_cumplimiento WHERE estatus = 1 AND id_usuario = $idUsuario");
        return $query->row();
    }

    // ------------------------------ consultas casas_colaboradorRigel --------------------------------

    public function get_condominios_lista($proyecto = '') {
        $filtro = $proyecto == '' ? '' : "AND idResidencial IN($proyecto)";
        return $this->db->query("SELECT * FROM condominios WHERE status = 1 $filtro ORDER BY nombre");
    }

    public function getSumaPagos($idUsuario){
        return $this->db->query("
        SELECT u.id_usuario,pciN.nuevas,pciR.resguardo,pciRe.revision,pciI.internomex,pciP.pausadas,sed.impuesto FROM 
        usuarios u 
        LEFT JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
                WHEN 2 THEN 2 
                WHEN 3 THEN 2 
                WHEN 1980 THEN 2 
                WHEN 1981 THEN 2 
                WHEN 1982 THEN 2 
                WHEN 1988 THEN 2 
                WHEN 4 THEN 5
                WHEN 5 THEN 3
                WHEN 607 THEN 1 
                WHEN 7092 THEN 4
                WHEN 9629 THEN 2
                WHEN 9471 THEN 1
                ELSE u.id_sede END) AND sed.estatus = 1
        LEFT JOIN ( SELECT id_usuario,SUM(abono_neodata) nuevas FROM pago_casas_ind WHERE estatus=1 AND id_comision IN(SELECT id_comision FROM comisiones_casas) GROUP BY id_usuario) pciN ON pciN.id_usuario=u.id_usuario
        LEFT JOIN ( SELECT id_usuario,SUM(abono_neodata) resguardo FROM pago_casas_ind WHERE estatus=3 AND id_comision IN(SELECT id_comision FROM comisiones_casas) GROUP BY id_usuario) pciR ON pciR.id_usuario=u.id_usuario
        LEFT JOIN ( SELECT id_usuario,SUM(abono_neodata) revision FROM pago_casas_ind WHERE estatus=4 AND id_comision IN(SELECT id_comision FROM comisiones_casas) GROUP BY id_usuario) pciRe ON pciRe.id_usuario=u.id_usuario
        LEFT JOIN ( SELECT id_usuario,SUM(abono_neodata) internomex FROM pago_casas_ind WHERE estatus=8 AND id_comision IN(SELECT id_comision FROM comisiones_casas) GROUP BY id_usuario) pciI ON pciI.id_usuario=u.id_usuario
        LEFT JOIN ( SELECT id_usuario,SUM(abono_neodata) pausadas FROM pago_casas_ind WHERE estatus=6 AND id_comision IN(SELECT id_comision FROM comisiones_casas) GROUP BY id_usuario) pciP ON pciP.id_usuario=u.id_usuario
        WHERE u.id_usuario= $idUsuario
        ");
    }

    function getDatosComisionesRigel($proyecto,$condominio,$estado){
        $user_data = $this->session->userdata('id_usuario');
        switch($this->session->userdata('id_usuario')){
            case 2:
            case 3:
            case 1980:
            case 1981:
            case 1982:
            case 13546:
                $sede = 2;
                break;
            case 4:
                $sede = 5;
                break;
            case 5:                           
                $sede = 3;
                break;
            case 607:
                $sede = 1;
                break;
            default:
                $sede = $this->session->userdata('id_sede');
                break;
        }
        
        if($condominio == 0){
            $filtroExtra = ' AND com.id_usuario = '.$user_data.' AND re.idResidencial = '.$proyecto.'';
            $filtroSuma = 'AND res.idResidencial = '.$proyecto.'';
        } else{
            $filtroExtra = ' AND com.id_usuario = '.$user_data.' AND co.idCondominio = '.$condominio.'';
            $filtroSuma = ' AND co.idCondominio = '.$condominio.'';
        }

        return $this->db->query("SELECT pci1.id_pago_i, tot_suma,pci1.id_comision, re.nombreResidencial AS proyecto, cl.costo_construccion precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, oxcpj.nombre AS pj_name, u.forma_pago, pac.porcentaje_abono, 0 AS factura, 1 expediente,oxcpj.color,
    
        (CASE WHEN com.ooam = 2 THEN CONCAT(lo.nombreLote,'</b> <i>(',com.loteReubicado,')</i><b>') ELSE lo.nombreLote END) lote, 
        (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (EEC)') ELSE oxcest.nombre END) estatus_actual,

        (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, pac.bonificacion, cl.lugar_prospeccion, pci1.fecha_abono, opt.fecha_creacion AS fecha_opinion, opt.estatus AS estatus_opinion, 
        (CASE WHEN cl.proceso = 0 THEN '' ELSE oxc0.nombre END) procesoCl,
        (CASE WHEN u.forma_pago  = 1  THEN 'yellow/REVISAR CON RH: '
              WHEN u.forma_pago  = 2  THEN 'melon/SUBIR XML: '
              WHEN u.forma_pago  = 3  THEN 'oceanGreen/LISTA PARA APROBAR: '
              WHEN u.forma_pago  = 4  THEN 'oceanGreen/LISTA PARA APROBAR: ' 
              WHEN u.forma_pago  = 5  THEN 'yellow/REVISAR CON RH: '  
              ELSE 'yellow/REVISAR CON RH: ' 
        END ) texto,
        (CASE WHEN cl.proceso = 0 THEN '' ELSE 'label lbl-violetBoots' END) colorProcesoCl, cl.proceso, ISNULL(cl.id_cliente_reubicacion_2, 0)
        FROM pago_casas_ind pci1 
        INNER JOIN comisiones_casas com ON pci1.id_comision = com.id_comision AND com.estatus IN (1,8) 
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status IN (0,1)
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        LEFT JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.status = 1
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario  
        INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago AND oxcpj.id_catalogo = 16 
        LEFT JOIN pago_comision_casas pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
        INNER JOIN sedes sed ON sed.id_sede = $sede AND sed.estatus = 1
        LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
        LEFT JOIN (SELECT id_usuario, fecha_creacion, estatus FROM opinion_cumplimiento WHERE estatus = 1) opt ON opt.id_usuario = com.id_usuario
        LEFT JOIN (SELECT SUM(abono_neodata) tot_suma, paca.id_usuario FROM pago_casas_ind paca
            INNER JOIN comisiones_casas coc ON coc.id_comision = paca.id_comision 
            INNER JOIN lotes lo ON lo.idLote = coc.id_lote AND lo.status IN (0,1)
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales res ON res.idResidencial = co.idResidencial
            WHERE paca.estatus = $estado $filtroSuma GROUP BY paca.id_usuario ) SumP ON Sump.id_usuario = pci1.id_usuario
        WHERE pci1.estatus IN ($estado) $filtroExtra
        GROUP BY pci1.id_comision,tot_suma,com.ooam,com.loteReubicado, lo.nombreLote, oxcpj.color, re.nombreResidencial, cl.costo_construccion, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, oxcpj.nombre, u.forma_pago,pci1.id_pago_i, pac.porcentaje_abono, oxcest.nombre, sed.impuesto, pac.bonificacion, cl.lugar_prospeccion, opt.fecha_creacion, opt.estatus, cl.proceso, oxc0.nombre, cl.id_cliente_reubicacion_2");
    }

    function update_acepta_resguardo($idsol) {
        $query = $this->db->query("UPDATE pago_casas_ind SET estatus = 3, fecha_pago_intmex = GETDATE(),modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$idsol.")");
        return true;
    }

    public function porcentajes($idCliente, $costoConstruccion, $planComision){
        return $this->db->query("EXEC porcentajesCom @idCliente = $idCliente, @precioTotal = $costoConstruccion,@planComision = $planComision");
    }

    public function validateDispersionCommissions($lote){
        return $this->db->query("SELECT count(*) dispersion, pc.bandera 
        FROM comisiones_casas com
        LEFT JOIN pago_comision_casas pc ON pc.id_lote = com.id_lote and pc.bandera = 0
        WHERE com.id_lote = $lote AND com.estatus = 1 AND com.fecha_creacion <= GETDATE() GROUP BY pc.bandera");
    }
    public function InsertPagoComision($lote,$sumaComi,$sumaDispo,$porcentaje,$resta,$id_user,$pagado,$bonificacion){
        $QUERY_VOBO =  $this->db->query("SELECT id_pagoc FROM pago_comision_casas WHERE id_lote = ".$lote."");
        if($QUERY_VOBO->num_rows() > 0){
            $respuesta =  $this->db->query("UPDATE pago_comision_casas SET total_comision = $sumaComi, abonado = $sumaDispo, porcentaje_abono = $porcentaje, pendiente = $resta, creado_por = $id_user, fecha_modificacion = GETDATE(), ultimo_pago = $pagado, bonificacion = $bonificacion, ultima_dispersion = GETDATE(), numero_dispersion = (numero_dispersion+1) WHERE id_lote = $lote");
        } else{
            $respuesta =  $this->db->query("INSERT INTO pago_comision_casas ([id_lote],[total_comision],[abonado],[porcentaje_abono],[pendiente],[creado_por],[fecha_modificacion],[fecha_abono],[bandera],[ultimo_pago],[bonificacion],[fecha_neodata],[modificado_por],[new_neo],[ultima_dispersion],[numero_dispersion],[monto_anticipo]) VALUES ($lote,$sumaComi,$sumaDispo,$porcentaje,$resta,$id_user,GETDATE(),GETDATE(),1,$pagado,$bonificacion,null,null,null,GETDATE(),1,$sumaDispo)");
        }

        if (! $respuesta ) {
            return 0;
        } else {
            return 1;
        }
    }
    public function UpdateLoteDisponible($lote,$idCliente){
        $respuesta =  $this->db->query("UPDATE pago_comision_casas SET bandera = 0 WHERE id_lote = $lote");
        $respuesta =  $this->db->query("UPDATE clientes SET registroComisionCasas = 1,usuario=".$this->session->userdata('id_usuario')." WHERE id_cliente = $idCliente");
        if (! $respuesta ) {
            return 0;
        } else {
            return 1;
        }
    }


    public function InsertNeo($idLote, $id_usuario, $TotComision,$user, $porcentaje,$abono,$pago,$rol,$idCliente,$tipo_venta,$ooam, $nombreOtro){
        
        if($porcentaje != 0 && $porcentaje != ''){
            $respuesta =  $this->db->query("INSERT INTO comisiones_casas ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [ooam], [loteReubicado], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado],[idCliente],[modificado_por]) VALUES (".$idLote.", ".$id_usuario.", ".$TotComision.", 1, 'NUEVA DISPERSIÓN - $tipo_venta ', $ooam, '".$nombreOtro."', ".$user.", GETDATE(), ".$porcentaje.", GETDATE(), ".$rol.",".$idCliente.",'".$this->session->userdata('id_usuario')."')");
            $insert_id = $this->db->insert_id();

            $respuesta = $this->db->query("INSERT INTO pago_casas_ind (id_comision, id_usuario, abono_neodata, fecha_abono, fecha_pago_intmex, estatus, pago_neodata, creado_por, comentario, modificado_por) VALUES (".$insert_id.", ".$id_usuario.", ".$abono.", GETDATE(), GETDATE(), 1 , ".$pago.",'$user', 'PAGO 1 - NEDOATA', '$user')");
            $insert_id_2 = $this->db->insert_id();

            $respuesta = $this->db->query("INSERT INTO historial_comision_casas VALUES ($insert_id_2, ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'DISPERSÓ PAGO DE COMISIÓN')");

            $respuesta = $this->db->query("UPDATE comisiones_casas SET liquidada = 1 
            FROM comisiones_casas com
            LEFT JOIN (SELECT SUM(abono_neodata) abonado, id_comision FROM pago_casas_ind GROUP BY id_comision) as pci ON pci.id_comision = com.id_comision
            WHERE com.id_comision = $insert_id AND com.ooam IN (2) AND (com.comision_total-abonado) < 1");
        }
        if (! $respuesta ) {
            return 0;
        } else {
            return 1;
        }
    }

    public function getDataDispersionPagoInsertNeoNew($bandera_segunda,$idLote, $id_usuario, $idCliente, $TotComisionXusuario = null,$user = null, $porcentaje = null,$abono = null,$pago = null,$rol = null, $porcentaje_abono = null,$comisionesTotal = null, $abonado = null,$resta= null){
        
        if($bandera_segunda == 2 ){
            $TotComisionXusuario = 0;
         
            $porcentaje = 2;
        
            $rol = 0; 
            $porcentaje_abono = 0;
            $comisionesTotal = 0; 
            $abonado = 0;
            $resta= 0;
        }

        $cmd = "
            DECLARE @resultadoEsperarDatos INT;
            DECLARE @resultadoEsperarComisiones INT;
            DECLARE @resultadoComisionEntrada INT;
            DECLARE @resultadoPrioridad INT;
            
            EXEC MiProcedimiento 
                @badera_real            = 1,
                @prioridad              = @resultadoPrioridad OUTPUT,
                @esperarDatos           = @resultadoEsperarDatos OUTPUT,       -- Parámetro de salida
                @esperarDatosComisiones = @resultadoEsperarComisiones OUTPUT, -- Parámetro de salida
                @comisionEntrada        = @resultadoComisionEntrada OUTPUT, -- Parámetro de salida
                @abonoNeodata           = $abono,
                @pagoNeodata            = $pago,
                @comentario             = 'Nueva dispersión: casas',
                @abonoFinal             = 0,
                @porcentajes            = $porcentaje_abono,
                @DispersadoPor          = $user,
                @idLote                 = $idLote,
                @idUsuario              = $id_usuario,
                @ComisionTotalXUsuario  = $TotComisionXusuario,
                @estatus                = 1,
                @observaciones          = 'Nueva dispersión: casas',
                @porcentajeDecimal      = $porcentaje,
                @rolGenerado            = $rol,
                @cliente                = $idCliente,
                @totalComision          = $comisionesTotal,
                @abonado                = $abonado,
                @pendiente_pc           = $resta";
        // el query lo puedes encontrar en dist/
        $respuesta = $this->db->query($cmd);

        if (! $respuesta ) {
            return $respuesta ;
        } else {
            return $respuesta ;
        }

    }





public function getDataDispersionPago() {
    $this->db->query("SET LANGUAGE Español;");
    $query = $this->db->query("SELECT DISTINCT(l.idLote),cl.esquemaCreditoCasas,
    (CASE WHEN cl.esquemaCreditoCasas = 2 THEN opcDir.nombre ELSE opcBanco.nombre END) estatusConstruccion,cl.prioridadComision,
    cl.registroComisionCasas, res.nombreResidencial, cond.nombre AS nombreCondominio, l.nombreLote,
    oxctipo.nombre tipo_venta,
    (CASE WHEN l.tipo_venta = 1 THEN 'lbl-warning' WHEN l.tipo_venta = 2 THEN 'lbl-green' ELSE 'lbl-gray' END) claseTipo_venta,
    (CASE WHEN cl.proceso = 0 THEN '' ELSE oxc0.nombre END) procesoCl,cl.estructura,
    (CASE WHEN cl.proceso = 0 THEN '' ELSE 'label lbl-violetBoots' END) colorProcesoCl, cl.proceso, 
    CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) nombreCliente, vc.id_cliente AS compartida, l.idStatusContratacion,cl.costo_construccion costoTotalConstruccion,
	pcp.montoDepositado,
    (CASE WHEN year(pc.fecha_modificacion) < 2019 THEN NULL ELSE convert(nvarchar,  pc.fecha_modificacion , 6) END) fecha_sistema, se.nombre AS sede, l.referencia, cl.id_cliente,
    CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ', ae.apellido_materno) AS asesor, 
    CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ', ge.apellido_materno) AS gerente, 
    CONCAT(su.nombre, ' ', su.apellido_paterno, ' ', su.apellido_materno) AS subdirector, 
    CONCAT(di.nombre, ' ', di.apellido_paterno, ' ', di.apellido_materno) AS director, 
    (CASE WHEN cl.plan_comision_c IN (0) OR cl.plan_comision_c IS NULL THEN '-' ELSE pl.descripcion END) AS plan_descripcion, cl.plan_comision_c,cl.id_subdirector, cl.id_sede, cl.id_prospecto, cl.lugar_prospeccion,
    0 bandera_dispersion, l.registro_comision, ISNULL(cl.id_cliente_reubicacion_2, 0) id_cliente_reubicacion_2, 
    l.sup AS supAct, 
    ISNULL(pc.abonado,0) abonadoAnterior, pc.porcentaje_abono as Comision_total, pc.ultimo_pago as Comisiones_Pagadas, pc.pendiente as Comisiones_pendientes
    FROM lotes l
    INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
    INNER JOIN condominios cond ON l.idCondominio = cond.idCondominio
    INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
	LEFT JOIN opcs_x_cats oxctipo ON oxctipo.id_opcion = cl.esquemaCreditoCasas AND oxctipo.id_catalogo = 151
    LEFT JOIN proceso_casas_banco procsb ON procsb.idLote=l.idLote AND procsb.status = 1
	LEFT JOIN opcs_x_cats opcBanco ON opcBanco.id_opcion=procsb.proceso AND opcBanco.id_catalogo=135
	LEFT JOIN proceso_pagos pcp ON pcp.idLote = l.idLote
	LEFT JOIN proceso_casas_directo procd ON procd.idLote=l.idLote AND procd.estatus = 1 
	LEFT JOIN opcs_x_cats opcDir ON opcDir.id_opcion=procd.proceso AND opcDir.id_catalogo=150
    INNER JOIN usuarios ae ON ae.id_usuario = cl.id_asesor_c
    LEFT JOIN pago_comision_casas pc ON pc.id_lote = l.idLote AND pc.bandera IN (0,100)
    LEFT JOIN (SELECT id_cliente FROM ventas_compartidas_casas WHERE estatus = 1) AS vc ON vc.id_cliente = cl.id_cliente
    LEFT JOIN usuarios ge ON ge.id_usuario = cl.id_gerente_c
    LEFT JOIN usuarios su ON su.id_usuario = cl.id_subdirector_c
    LEFT JOIN usuarios di ON di.id_usuario = 2
    LEFT JOIN plan_comision pl ON pl.id_plan = cl.plan_comision_c
    LEFT JOIN sedes se ON se.id_sede = cl.id_sede       
    LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
    WHERE l.idStatusContratacion IN (15)
    "); 
    return $query;
}

    public function changePrioridad($prioridadActual,$idClienteCasas,$idUsuario){

        $query = "UPDATE clientes SET prioridadComision= ?, modificado_por= ? WHERE  id_cliente = ?";
        return $this->db->query($query, [$prioridadActual,$idUsuario,$idClienteCasas]); 
    }


    public function getPagosBonos(){
        $query = "SELECT 
            pci1.id_pago_i,'' id_arcus,cl.fechaApartado, pci1.id_comision, 
            lo.nombreLote  lote, 
            re.nombreResidencial as proyecto, cl.costo_construccion precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, 
            pci1.pago_neodata, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, oxcpj.nombre as pj_name, u.forma_pago, 
            pac.porcentaje_abono, 0 as factura, 1 expediente, 
            lo.idLote,oxcest.nombre estatus_actual,
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
            INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
            LEFT JOIN clientes  cl ON cl.id_cliente=com.idCliente
            LEFT JOIN prospectos pr ON pr.id_prospecto=cl.id_prospecto
            LEFT JOIN sedes sed ON sed.id_sede = 2 and sed.estatus = 1
            LEFT JOIN (SELECT id_usuario, fecha_creacion, estatus FROM opinion_cumplimiento WHERE estatus = 1) opt ON opt.id_usuario = com.id_usuario
            WHERE pci1.estatus IN (1) AND com.id_usuario = 16660 AND pci1.abono_neodata > 0
            GROUP BY lo.idLote, pci1.id_comision,pr.id_arcus,cl.fechaApartado,com.ooam,com.loteReubicado, lo.nombreLote, re.nombreResidencial, cl.costo_construccion, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, oxcpj.nombre, u.forma_pago,pci1.id_pago_i, pac.porcentaje_abono, oxcest.nombre, sed.impuesto, pac.bonificacion, opt.fecha_creacion, opt.estatus";
             return $this->db->query($query)->result_array();
    }

    public function getUsuariosBonos(){
        return $this->db->query("SELECT * FROM usuarios WHERE id_usuario  IN(16716,16719)"); 
    }

    public function getDatosAbonadoSuma11($idlote){
        return $this->db->query("SELECT SUM(pci.abono_neodata) abonado, pac.total_comision, c2.abono_pagado, lo.totalNeto2, cl.lugar_prospeccion,cl.estructura
        FROM lotes lo
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
        INNER JOIN comisiones_casas c1 ON lo.idLote = c1.id_lote AND c1.estatus = 1
        LEFT JOIN (SELECT SUM(comision_total) abono_pagado, id_comision FROM comisiones_casas WHERE descuento in (1) AND estatus = 1 GROUP BY id_comision) c2 ON c1.id_comision = c2.id_comision
        INNER JOIN pago_comision_casas pac ON pac.id_lote = lo.idLote
        LEFT JOIN pago_casas_ind pci on pci.id_comision = c1.id_comision
        WHERE lo.status = 1 AND cl.status = 1 AND c1.estatus = 1 AND lo.idLote in ($idlote)
        GROUP BY lo.idLote, lo.referencia, pac.total_comision, lo.totalNeto2, cl.lugar_prospeccion, c2.abono_pagado,cl.estructura");
    }

    public function getDatosAbonadoDispersion($idlote){
         return $this->db->query("SELECT com.id_comision, com.id_usuario, lo.totalNeto2, lo.idLote, res.idResidencial, lo.referencia, lo.tipo_venta, com.id_lote, lo.nombreLote, com.porcentaje_decimal, CONCAT(us.nombre,' ' ,us.apellido_paterno,' ',us.apellido_materno) colaborador, 
          oxc.nombre as rol, com.comision_total, pci.abono_pagado, com.rol_generado,com.descuento
         FROM comisiones_casas com
         LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_casas_ind 
         GROUP BY id_comision) pci ON pci.id_comision = com.id_comision
         INNER JOIN lotes lo ON lo.idLote = com.id_lote 
         INNER JOIN usuarios us ON us.id_usuario = com.id_usuario
         INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = com.rol_generado AND oxc.id_catalogo = 1
         INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
         INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
         LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = com.rol_generado AND oxc2.id_catalogo = 83
         WHERE com.id_lote = $idlote AND com.estatus = 1   ORDER BY com.rol_generado asc");
     }
// ------------------------------ CONSULTAS DE resguardo_casas.js ------------------------------

function getDatosResguardoContraloria($directivo,$proyecto,$anio,$mes){
    if($proyecto == 0){
        $filtro_00 = ' ';
    } else{
        $filtro_00 = ' AND re.idResidencial = '.$proyecto.' ';
    }
    
    switch ($this->session->userdata('id_rol')) {
        case 1:
        case 2:
        case 3:
            $filtro_02 = ' pci1.estatus IN (3) AND com.id_usuario = '.$this->session->userdata('id_usuario').' '.$filtro_00;
        break;

        default:
            $filtro_02 = ' pci1.estatus IN (3) AND pci1.id_usuario = '.$directivo.' '.$filtro_00;
        break;
    }

    return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision,
    re.empresa,
    (CASE WHEN com.ooam = 2 THEN CONCAT(lo.nombreLote,' <i>(',com.loteReubicado,')</i>') ELSE lo.nombreLote END) nombreLote, re.nombreResidencial as proyecto, co.nombre as condominio,lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, 
    CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names ,pci1.id_usuario, CASE WHEN cl.estructura = 1 THEN UPPER(oprol2.nombre) ELSE UPPER(oprol.nombre) END as puesto, 
    (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (EEC)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, pci1.descuento_aplicado, (CASE WHEN cl.lugar_prospeccion IS NULL THEN 0 ELSE cl.lugar_prospeccion END) lugar_prospeccion, lo.referencia, pac.bonificacion, u.estatus as activo, 
    (CASE WHEN pe.id_penalizacion IS NOT NULL THEN 1 ELSE 0 END) penalizacion, oxcest.color,
    (CASE WHEN cl.proceso = 0 THEN '' ELSE oxc0.nombre END) procesoCl,
    (CASE WHEN cl.proceso = 0 THEN '' ELSE 'label lbl-violetBoots' END) colorProcesoCl, cl.proceso, ISNULL(cl.id_cliente_reubicacion_2, 0) id_cliente_reubicacion_2
    FROM pago_casas_ind pci1 
    LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision 
    FROM pago_casas_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
    GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
    INNER JOIN comisiones_casas com ON pci1.id_comision = com.id_comision and com.estatus NOT IN(0)
    INNER JOIN lotes lo ON lo.idLote = com.id_lote  
    INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
    INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
    INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
    LEFT JOIN clientes cl ON cl.id_cliente = lo.idCliente
    INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
    INNER JOIN pago_comision_casas pac ON pac.id_lote = com.id_lote
    INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
    LEFT JOIN penalizaciones pe ON pe.id_lote = lo.idLote AND pe.id_cliente = lo.idCliente
    LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
    LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
    WHERE $filtro_02 and YEAR(fecha_pago_intmex) = $anio and MONTH(fecha_pago_intmex)= $mes

    GROUP BY pci1.id_comision,com.ooam,com.loteReubicado,re.empresa, lo.nombreLote, re.nombreResidencial, co.nombre, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, pci1.id_pago_i, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, pci1.descuento_aplicado, cl.lugar_prospeccion, lo.referencia, com.estatus, pac.bonificacion, u.estatus,pe.id_penalizacion, oxcest.color, cl.estructura, oprol2.nombre, cl.proceso, oxc0.nombre, cl.id_cliente_reubicacion_2 ORDER BY lo.nombreLote");

}
//--------------------------- modelos para solicitudes_bono_casas --------------------------------
function getDatosBonoAsesor($estado){
    $estado = $estado == 6 ? '6,88' : $estado;
    $user_data = $this->session->userdata('id_usuario');
    $sede = $this->session->userdata('id_sede');
    
    return $this->db->query("(SELECT pcbo.id_pago_bono,'' id_arcus,cl.fechaApartado, pci1.id_comision, (CASE WHEN com.ooam = 2 THEN CONCAT(lo.nombreLote,' <i>(',com.loteReubicado,')</i>') ELSE lo.nombreLote END) lote, re.nombreResidencial as proyecto, cl.costo_construccion precio_lote, com.comision_total, com.porcentaje_decimal, pcbo.abono_bono pago_cliente, pcbo.pago_bono, pcbo.estatus, pcbo.fecha_abono fecha_creacion, pcbo.id_usuario, oxcpj.nombre as pj_name, u.forma_pago, pac.porcentaje_abono, 0 as factura, 1 expediente, 
        /*(CASE WHEN com.ooam = 1 THEN ' (EEC)' ELSE '' END) estatus_actual, */
        (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (EEC)') ELSE oxcest.nombre END) estatus_actual,

        (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pcbo.abono_bono) ELSE pcbo.abono_bono END) impuesto, pac.bonificacion, 0 lugar_prospeccion,
        pcbo.fecha_abono, opt.fecha_creacion as fecha_opinion, opt.estatus as estatus_opinion,

        '' as procesoCl,
        '' as colorProcesoCl, 0 as proceso, 0 as id_cliente_reubicacion_2

        FROM pago_comision_bono pcbo
        INNER JOIN pago_casas_ind pci1 ON pci1.id_pago_i = pcbo.id_pago_i
        INNER JOIN comisiones_casas com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN usuarios u ON u.id_usuario = pcbo.id_usuario
        INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago AND oxcpj.id_catalogo = 16
        LEFT JOIN pago_comision_casas pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pcbo.estatus AND oxcest.id_catalogo = 23
        LEFT JOIN clientes  cl ON cl.id_cliente=com.idCliente
        LEFT JOIN prospectos pr ON pr.id_prospecto=cl.id_prospecto

        LEFT JOIN sedes sed ON sed.id_sede = $sede and sed.estatus = 1
        LEFT JOIN (SELECT id_usuario, fecha_creacion, estatus FROM opinion_cumplimiento WHERE estatus = 1) opt ON opt.id_usuario = com.id_usuario
        WHERE pcbo.estatus IN ($estado) AND pcbo.id_usuario = $user_data /* en este and se modifica el com por pci1 añadiendo el 1 despues del*/
        GROUP BY pcbo.id_pago_bono, pci1.id_comision,pr.id_arcus,cl.fechaApartado,com.ooam,com.loteReubicado, lo.nombreLote, re.nombreResidencial, cl.costo_construccion, com.comision_total, com.porcentaje_decimal, pcbo.abono_bono, pcbo.pago_bono, pcbo.estatus, pcbo.fecha_abono, pcbo.id_usuario, oxcpj.nombre, u.forma_pago,pcbo.id_pago_i, pac.porcentaje_abono, oxcest.nombre, sed.impuesto, pac.bonificacion, opt.fecha_creacion, opt.estatus)
        ");
}

function update_aceptar_bono($idsol) {
    $query = $this->db->query("UPDATE pago_comision_bono SET estatus = 4, fecha_pago_intmex = GETDATE(),modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_bono IN (".$idsol.")");
    return true;
}

function insert_phc_bono($data){
    $this->db->insert_batch('historial_casas_bono', $data);
    return true;
}

public function getSumaBono($idUsuario){
    return $this->db->query("
     SELECT u.id_usuario,pciN.nuevas,pciR.resguardo,pciRe.revision,pciI.internomex,pciP.pausadas,sed.impuesto FROM 
        usuarios u 
        LEFT JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
                WHEN 2 THEN 2 
                WHEN 3 THEN 2 
                WHEN 1980 THEN 2 
                WHEN 1981 THEN 2 
                WHEN 1982 THEN 2 
                WHEN 1988 THEN 2 
                WHEN 4 THEN 5
                WHEN 5 THEN 3
                WHEN 607 THEN 1 
                WHEN 7092 THEN 4
                WHEN 9629 THEN 2
                WHEN 9471 THEN 1
                ELSE u.id_sede END) AND sed.estatus = 1
        LEFT JOIN ( SELECT id_usuario,SUM(abono_bono) nuevas FROM pago_comision_bono WHERE estatus=1 AND id_pago_i IN(SELECT id_pago_i FROM pago_casas_ind) GROUP BY id_usuario) pciN ON pciN.id_usuario=u.id_usuario
        LEFT JOIN ( SELECT id_usuario,SUM(abono_bono) resguardo FROM pago_comision_bono WHERE estatus=3 AND id_pago_i IN(SELECT id_pago_i FROM pago_casas_ind) GROUP BY id_usuario) pciR ON pciR.id_usuario=u.id_usuario
        LEFT JOIN ( SELECT id_usuario,SUM(abono_bono) revision FROM pago_comision_bono WHERE estatus=4 AND id_pago_i IN(SELECT id_pago_i FROM pago_casas_ind) GROUP BY id_usuario) pciRe ON pciRe.id_usuario=u.id_usuario
        LEFT JOIN ( SELECT id_usuario,SUM(abono_bono) internomex FROM pago_comision_bono WHERE estatus=8 AND id_pago_i IN(SELECT id_pago_i FROM pago_casas_ind) GROUP BY id_usuario) pciI ON pciI.id_usuario=u.id_usuario
        LEFT JOIN ( SELECT id_usuario,SUM(abono_bono) pausadas FROM pago_comision_bono WHERE estatus=6 AND id_pago_i IN(SELECT id_pago_i FROM pago_casas_ind) GROUP BY id_usuario) pciP ON pciP.id_usuario=u.id_usuario
        WHERE u.id_usuario= $idUsuario
    ");
}

function getBonoHistorialPago($id_pago) {
    ini_set('memory_limit', -1);

    
    return $this->db->query("
        SELECT pcbo. id_pago_bono, lo.nombreLote AS nombreLote, re.nombreResidencial as proyecto, co.nombre as condominio, opc.nombre AS puesto, u.id_usuario, pci.descuento_aplicado, oxcest.color,
        oxcest.nombre AS estatus_actual, lo.totalNeto2 AS precio_lote, com.comision_total, pcbo.abono_bono AS dispersado, pci.descuento_aplicado,
        CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names
        FROM pago_comision_bono pcbo
        INNER JOIN pago_casas_ind pci on pci.id_pago_i = pcbo.id_pago_i
        INNER JOIN comisiones_casas com ON pci.id_comision = com.id_comision and com.estatus = 1 
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1	
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio 
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
        INNER JOIN usuarios u on u.id_usuario = pcbo.id_usuario
        INNER JOIN opcs_x_cats opc on opc.id_opcion = u.id_rol and opc.id_catalogo =1
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pcbo.estatus AND oxcest.id_catalogo = 23
        WHERE pcbo.id_pago_i = $id_pago
    ");
}

    public function getPagosBonosEnviados($idPagos){
            $query = "SELECT id_pago_i, abono_neodata,id_comision FROM pago_casas_ind WHERE id_pago_i IN (?)";
            return $this->db->query($query, [intval($idPagos)]); 
    }
    public function lotes(){
        $cmd = "SELECT SUM(lotes)  nuevo_general 
        FROM (SELECT  COUNT(DISTINCT(id_lote)) lotes 
        FROM pago_casas_ind pci 
        INNER JOIN comisiones_casas c on c.id_comision = pci.id_comision 
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
        FROM pago_casas_ind pci 
        INNER JOIN comisiones_casas c on c.id_comision = pci.id_comision 
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
        FROM pago_casas_ind pci 
        INNER JOIN comisiones_casas c on c.id_comision = pci.id_comision 
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
    function getDatosHistorialCasas($proyecto, $estado, $usuario) {

        $filtro_00 = ($proyecto === '0') ? '' : " AND re.idResidencial = $proyecto ";
        $userWhereClause = ($usuario != 0) ? "AND com.id_usuario = $usuario" : '';
        switch ($estado) {
            case '1':
                $filtro_estatus = " pci1.estatus IN (1,2,41,42,51,52,61,62)  AND (pci1.descuento_aplicado is null or pci1.descuento_aplicado = '0') ";
                break;
            case '2':
                $filtro_estatus = " pci1.estatus IN (4,13)  AND (pci1.descuento_aplicado is null or pci1.descuento_aplicado = '0') ";
                break;
            case '3':
                $filtro_estatus = " pci1.estatus IN (8,88)  AND (pci1.descuento_aplicado is null or pci1.descuento_aplicado = '0') ";
                break;
            case '4':
                $filtro_estatus = " pci1.estatus IN (6)  AND (pci1.descuento_aplicado is null or pci1.descuento_aplicado = '0') ";
                break;
            case '5':
                $filtro_estatus = " pci1.descuento_aplicado = 1 ";
                break;
            case '6':
                $filtro_estatus = " pci1.estatus IN (3)  AND (pci1.descuento_aplicado is null or pci1.descuento_aplicado = '0') ";
                break;
            case '7':
                $filtro_estatus = " pci1.estatus IN (11,12)  AND (pci1.descuento_aplicado is null or pci1.descuento_aplicado = '0') ";
                break;
            case '8':
                $filtro_estatus = " lo.tipo_venta = 7  AND pci1.estatus IN (1,6) AND (pci1.descuento_aplicado is null or pci1.descuento_aplicado = '0')";
                break;
            case '9':
                $filtro_estatus= " com.estatus IN (8)";
                break;
        }
        return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, (CASE WHEN com.ooam = 2 THEN CONCAT(lo.nombreLote,' <i>(',com.loteReubicado,')</i>') ELSE lo.nombreLote END) nombreLote, re.nombreResidencial as proyecto, co.nombre as condominio,lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names ,pci1.id_usuario, CASE WHEN cl.estructura = 1 THEN oprol2.nombre ELSE oprol.nombre END as puesto, u.forma_pago, pac.porcentaje_abono, 
        (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (EEC)') ELSE oxcest.nombre END) estatus_actual, 
        oxcest.id_opcion id_estatus_actual, pci1.descuento_aplicado, (CASE WHEN cl.lugar_prospeccion IS NULL THEN 0 ELSE cl.lugar_prospeccion END) lugar_prospeccion, lo.referencia, com.estatus estado_comision, pac.bonificacion, u.estatus as activo, lo.tipo_venta, oxcest.color, (CASE WHEN pe.id_penalizacion IS NOT NULL THEN 1 ELSE 0 END) penalizacion, (CASE WHEN com.estatus = 8 THEN 1 ELSE 0 END) recision, 

        (CASE WHEN cl.proceso = 0 THEN '' ELSE oxc0.nombre END) procesoCl,
        (CASE WHEN cl.proceso = 0 THEN '' ELSE 'label lbl-violetBoots' END) colorProcesoCl, cl.proceso, ISNULL(cl.id_cliente_reubicacion_2, 0)

        FROM pago_casas_ind pci1 
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_casas_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
        INNER JOIN comisiones_casas com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial $filtro_00
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
        LEFT JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.status = 1 AND lo.idStatusContratacion > 8 AND com.estatus = 1
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_comision_casas pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
        LEFT JOIN penalizaciones pe ON pe.id_lote = lo.idLote AND pe.id_cliente = lo.idCliente
        LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83

        LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97

        WHERE $filtro_estatus $userWhereClause 
        GROUP BY pci1.id_comision,com.ooam,com.loteReubicado, lo.nombreLote, re.nombreResidencial, co.nombre, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, pci1.descuento_aplicado, lo.referencia, com.estatus, pac.bonificacion, u.estatus, lo.tipo_venta, oxcest.color, pe.id_penalizacion, cl.lugar_prospeccion, com.estatus, cl.estructura, oprol2.nombre, cl.proceso, oxc0.nombre, id_cliente_reubicacion_2 ");
    }


    function selectTipo(){
        return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 124");
    }

    public function massiveUpdateEstatusComisionInd($idPagos, $estatus)
    {
        return $this->db->query("UPDATE pago_casas_ind SET estatus = $estatus WHERE id_pago_i IN ($idPagos)");
    }

    function update_pago_dispersion($suma, $ideLote, $pago){
        $respuesta = $this->db->query("UPDATE pago_comision_casas SET abonado = (abonado + ".$suma."), pendiente = (total_comision-abonado-".$suma."), bandera = 1, ultimo_pago = ".$pago." , ultima_dispersion = GETDATE() WHERE id_lote = ".$ideLote."");
        if (! $respuesta ) {
            return 0;
        } else {
            return 1;
        }
    }
}