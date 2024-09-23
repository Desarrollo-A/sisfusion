<?php class Caja_model_outside extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }


    public function getResidencialDis()
    {
        return $this->db->query("SELECT residenciales.idResidencial, residenciales.nombreResidencial, CAST(residenciales.descripcion AS varchar(MAX)) as descripcion FROM residenciales
            INNER JOIN condominios ON residenciales.idResidencial = condominios.idResidencial
            INNER JOIN lotes ON condominios.idCondominio = lotes.idCondominio WHERE lotes.idStatusLote IN (1,102)  AND lotes.status IN ( 1 ) AND
            (lotes.idMovimiento = 0 OR lotes.idMovimiento IS NULL )
            group by residenciales.idResidencial, residenciales.nombreResidencial, CAST(residenciales.descripcion AS varchar(MAX))
            ORDER BY CAST(residenciales.descripcion AS varchar(MAX))")->result_array();

    }


    public function getResidencialDis2($rol) {
        $val_idStatusLote = in_array($rol, array(8, 4, 11)) ? "1, 101, 102" : "1";
        return $this->db->query("SELECT re.idResidencial, re.nombreResidencial, CAST(re.descripcion AS varchar(MAX)) as descripcion 
        FROM residenciales re
        INNER JOIN condominios co ON co.idResidencial = re.idResidencial
        INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio AND lo.idStatusLote in ($val_idStatusLote) AND lo.status IN ( 1 ) AND (lo.idMovimiento = 0 OR lo.idMovimiento IS NULL )
        --WHERE re.idResidencial NOT IN (21, 22, 25, 14)
        group by re.idResidencial, re.nombreResidencial, CAST(re.descripcion AS varchar(MAX))
        ORDER BY CAST(re.descripcion AS varchar(MAX))")->result_array();
    }


    public function getCondominioDis($residencial)
    {
        return $this->db->query("SELECT condominios.idCondominio, condominios.nombre FROM condominios
            INNER JOIN lotes ON condominios.idCondominio = lotes.idCondominio
            WHERE lotes.status = 1 AND lotes.idStatusLote in (1,102) AND condominios.status = 1 AND
            (lotes.idMovimiento = 0 OR lotes.idMovimiento IS NULL ) AND idResidencial = $residencial 
            GROUP BY condominios.idCondominio, condominios.nombre ORDER BY nombre ASC")->result_array();
    }


    public function getCondominioDis2($residencial, $rol)
    {

        $val_idStatusLote = ($rol == 8 || $rol == 4 || $rol == 11) ? ('1,101,102') : ('1');


        return $this->db->query("SELECT condominios.idCondominio, condominios.nombre FROM condominios
            INNER JOIN lotes ON condominios.idCondominio = lotes.idCondominio
            WHERE lotes.status = 1 AND lotes.idStatusLote in (" . $val_idStatusLote . ") AND condominios.status = 1 AND
            (lotes.idMovimiento = 0 OR lotes.idMovimiento IS NULL ) AND idResidencial = $residencial 
            GROUP BY condominios.idCondominio, condominios.nombre ORDER BY nombre ASC")->result_array();
    }


    public function getLotesDis($condominio)
    {
        /*return $query = $this->db->query("SELECT lotes.idLote, lotes.nombreLote, lotes.precio, lotes.total, lotes.sup, condominios.tipo_lote, lotes.referencia,
        lotes.idStatusLote, lotes.tipo_venta, ISNULL(clausulas.nombre, '') clausulas
        FROM lotes
        INNER JOIN condominios ON lotes.idCondominio = condominios.idCondominio
        LEFT JOIN ( SELECT * FROM clausulas WHERE clausulas.estatus = 1 ) clausulas ON clausulas.id_lote = lotes.idLote
        WHERE lotes.status = 1 AND lotes.idStatusLote in (1, 102) AND
        (lotes.idMovimiento = 0 OR lotes.idMovimiento IS NULL ) AND
        lotes.idCondominio = '$condominio'")->result_array();*/
        return $query = $this->db->query("SELECT lotes.idLote, lotes.nombreLote, lotes.precio, lotes.total, lotes.sup, condominios.tipo_lote, lotes.referencia, 
            lotes.idStatusLote, lotes.tipo_venta, ISNULL(clausulas.nombre, '') clausulas, lotes.casa, (
            CASE lotes.casa
            WHEN 0 THEN ''
            WHEN 1 THEN  casas.casasDetail
            END
            ) casasDetail
            FROM lotes
            INNER JOIN condominios ON lotes.idCondominio = condominios.idCondominio
            LEFT JOIN ( SELECT * FROM clausulas WHERE clausulas.estatus = 1 ) clausulas ON clausulas.id_lote = lotes.idLote
            LEFT JOIN (SELECT id_lote, CONCAT( '{''total_terreno'':''', total_terreno, ''',', tipo_casa, '}') casasDetail 
            FROM casas WHERE estatus = 1) casas ON casas.id_lote = lotes.idLote
            WHERE lotes.status = 1 AND lotes.idStatusLote IN (1, 102) AND
            (lotes.idMovimiento = 0 OR lotes.idMovimiento IS NULL ) AND
            lotes.idCondominio = $condominio")->result_array();
    }

    public function getLotesDis2($condominio, $rol) {
        $val_idStatusLote = ($rol == 8 || $rol == 4 || $rol == 11) ? ('1, 101, 102') : ('1');
        return $query = $this->db->query("SELECT lotes.idLote, lotes.nombreLote, lotes.precio, lotes.total, lotes.sup, condominios.tipo_lote, lotes.referencia, lotes.casa, (
        CASE lotes.casa WHEN 0 THEN '' WHEN 1 THEN  casas.casasDetail END) casasDetail, re.empresa
        FROM lotes
        INNER JOIN condominios ON lotes.idCondominio = condominios.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = condominios.idResidencial
        LEFT JOIN (SELECT id_lote, CONCAT( '{''total_terreno'':''', total_terreno, ''',', tipo_casa, '}') casasDetail 
        FROM casas WHERE estatus = 1) casas ON casas.id_lote = lotes.idLote
        WHERE lotes.status = 1 AND lotes.idStatusLote in ($val_idStatusLote) AND lotes.idCondominio = $condominio")->result_array();
    }

    public function getResidencial() {
        return $this->db->query("SELECT idResidencial as id_proy, nombreResidencial as siglas, descripcion as nproyecto
        FROM residenciales
        WHERE status = 1 --AND idResidencial NOT IN (21, 22, 25, 14)
        ORDER BY nombreResidencial ")->result_array();
    }


    public function getCondominio($residencial)
    {
        $this->db->select('idCondominio, nombre as Nombre');
        $this->db->from('condominios');
        $this->db->where('status', '1');
        $this->db->order_by('nombre', 'asc');
        $this->db->where("idResidencial", $residencial);
        $query = $this->db->get();

        return $query->result_array();
    }


    public function getLotes($condominio)
    {
        $this->db->select('idLote,nombreLote, idStatusLote');
        $this->db->where('idCondominio', $condominio);
        $this->db->where('lotes.status', 1);

        if ($this->session->userdata('id') == 22) {
            $this->db->where_in('idStatusLote', array('1', '101'));

        } else {
            $this->db->where_in('idStatusLote', array('1'));

        }

        $query = $this->db->get('lotes');
        if ($query) {
            $query = $query->result_array();
            return $query;
        }
    }

    public function getAllLotes($condominio){
        $query = $this->db->query("SELECT idLote, nombreLote, idStatusLote FROM lotes WHERE idCondominio = $condominio AND status = 1")->result_array();
        return $query;
    }

    public function getAllClientsByLote($lote){
        $query = $this->db->query("SELECT id_cliente, CONCAT( nombre, ' ', apellido_paterno, ' ', apellido_materno, ' - ', CONVERT(varchar, fechaApartado, 23)) nombre, fechaApartado FROM clientes WHERE idLote =  $lote")->result_array();
        return $query;
    }


    public function table_datosBancarios()
    {
        $this->db->select('idDBanco, empresa, banco, cuenta, clabe');
        $query = $this->db->get("datosbancarios");
        return $query->result_array();
    }


    public function table_etapa()
    {
        $this->db->select('idEtapa, descripcion');
        $query = $this->db->get("etapas");
        return $query->result_array();
    }


    public function loadLotes($datos)
    {
        $this->db->insert('lotes', $datos);
        return true;
    }


    public function uploadPrecio($datos)
    {

        $query = $this->db->query("SELECT idLote, nombreLote, status, sup FROM lotes where idCondominio = " . $datos['idCondominio'] . " and nombreLote = '" . $datos['nombreLote'] . "' and status = 1");

        foreach ($query->result_array() as $row) {
            $this->db->query("UPDATE lotes SET usuario = 'CAJA', precio = " . $datos['precio'] . ", 
                total = (" . $datos['precio'] * $row['sup'] . "), 
                enganche = (" . $datos['precio'] * $row['sup'] . " * 0.1), 
                saldo = (" . $datos['precio'] * $row['sup'] . " - (" . $datos['precio'] * $row['sup'] . " * 0.1))
                WHERE idLote IN (" . $row['idLote'] . ") and nombreLote IN ('" . $row['nombreLote'] . "') and status = 1 ");

            return true;


        }

    }


    public function uploadReferencias($datos)
    {
        $query = $this->db->query("SELECT idLote, nombreLote, status FROM lotes where idCondominio = " . $datos['idCondominio'] . " and nombreLote = '" . $datos['nombreLote'] . "' and status = 1");

        foreach ($query->result_array() as $row) {
            $this->db->query("UPDATE lotes SET referencia = " . $datos['referencia'] . "
                    WHERE idLote IN (" . $row['idLote'] . ") and nombreLote IN ('" . $row['nombreLote'] . "') and status = 1 ");

            return true;

        }

    }


    public function aplicaLiberacion($datos) {
        $descuentosComerciales = !isset($datos['descuentosComerciales']) ? NULL : $datos['descuentosComerciales'];
        $descuentoHabMenores = !isset($datos['descuentoHabMenores']) ? NULL : $datos['descuentoHabMenores'] ;
        $descuentoHabMayores = !isset($datos['descuentoHabMayores']) ? NULL : $datos['descuentoHabMayores'] ;
        $idCondominio = $datos['idCondominio'];
        $nombreLote = $datos['nombreLote'];
        $userLiberacion = $datos['userLiberacion'];
        $query = $this->db->query("SELECT lo.idLote, lo.nombreLote, lo.status, lo.sup, cl.lugar_prospeccion, pr.id_arcus, lo.tipo_venta, lo.msi_reslpado
        FROM lotes lo
        LEFT JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.idLote = lo.idLote AND cl.status = 1 AND cl.lugar_prospeccion = 47
        LEFT JOIN prospectos pr ON pr.id_prospecto = cl.id_prospecto
        WHERE lo.idCondominio = $idCondominio AND lo.nombreLote = '$nombreLote' AND lo.status = 1");
        foreach ($query->result_array() as $row) {
            $this->db->trans_begin();
            $id_cliente = $this->db->query("SELECT id_cliente FROM clientes WHERE status = 1 and idLote IN (" . $row['idLote'] . ") ")->result_array();
            $this->db->query("UPDATE historial_documento SET status = 0 WHERE status = 1 and idLote IN (".$row['idLote'].") ");
            $this->db->query("UPDATE prospectos SET tipo = 0, estatus_particular = 4, modificado_por = 1, fecha_modificacion = GETDATE() WHERE id_prospecto IN (SELECT id_prospecto FROM clientes WHERE status = 1 AND idLote = ".$row['idLote'].")");
            $this->db->query("UPDATE clientes SET status = 0 WHERE status = 1 and idLote IN (".$row['idLote'].") ");
            $this->db->query("UPDATE historial_enganche SET status = 0, comentarioCancelacion = 'LOTE LIBERADO' WHERE status = 1 and idLote IN (".$row['idLote'].") ");
            $this->db->query("UPDATE historial_lotes SET status = 0 WHERE status = 1 and idLote IN (".$row['idLote'].") ");
            $this->db->query("UPDATE informacion_lotes SET estatus = 0 WHERE estatus = 1 and idLote IN (".$row['idLote'].") ");
            $comisiones = $this->db->query("SELECT id_comision,id_lote,comision_total FROM comisiones where id_lote=".$row['idLote']."")->result_array();
            for ($i=0; $i <count($comisiones) ; $i++) {
                $sumaxcomision=0;
                $pagos_ind = $this->db->query("select * from pago_comision_ind where id_comision=".$comisiones[$i]['id_comision']."")->result_array();
                for ($j=0; $j <count($pagos_ind) ; $j++) {
                    $sumaxcomision = $sumaxcomision + $pagos_ind[$j]['abono_neodata'];
                }
                $this->db->query("UPDATE comisiones set  modificado_por='" . $datos['userLiberacion'] . "',comision_total=$sumaxcomision,estatus=8 where id_comision=".$comisiones[$i]['id_comision']." ");
            }
            $this->db->query("UPDATE pago_comision set bandera=0,total_comision=0,abonado=0,pendiente=0,ultimo_pago=0  where id_lote=".$row['idLote']." ");
            //PAQUETES CF
            if($datos['tipo_lote'] == 1 ){ //1 - Comercial
                //si el condominio es comercial solo consultar sin importar la superficie
                $descuentos=$datos['descuentosComerciales'];
            }else{ //0 - Habitacional
                $descuentos = $row['sup'] < 200 ? $datos['descuentoHabMenores'] : $datos['descuentoHabMayores'];
                //var_dump($datos['descuentoHabMenores']);
            }
            $descuento = $descuentos != NULL ? "id_descuento='$descuentos'," : "id_descuento=NULL,";

            /**----------------------------------------------- */


            $data_l = array(
                'nombreLote'=> $datos['nombreLote'],
                'comentarioLiberacion'=> $datos['comentarioLiberacion'],
                'observacionLiberacion'=> $datos['observacionLiberacion'],
                'precio'=> $datos['precio'],
                'fechaLiberacion'=> $datos['fechaLiberacion'],
                'modificado'=> $datos['modificado'],
                'status'=> $datos['status'],
                'idLote'=> $row['idLote'],
                'tipo'=> $datos['tipo'],
                'userLiberacion'=> $datos['userLiberacion'],
                'id_cliente' => (count($id_cliente)>=1 ) ? $id_cliente[0]['id_cliente'] : 0
            );
            $this->db->insert('historial_liberacion',$data_l);

            $tventa = ($row['tipo_venta'] == 1) ? 1 : ($datos['activeLP'] == 1 ? 1 : 0);
            if ($datos['activeLE'] == 0) {
                $st = ($datos['activeLP'] == 1) ? 1 : 1;
                $tv = ($datos['activeLP'] == 1) ? 1 : 0;
                if ($tv == 1) { // LIBERACIÓN VENTA DE PARTICULAES
                    $data_lp = array(
                        'id_lote'=> $row['idLote'],
                        'nombre'=> $datos['clausulas'],
                        'estatus'=> 1,
                        "fecha_creacion" => date("Y-m-d H:i:s"),
                        "creado_por" => $datos['userLiberacion']
                    );
                    $clauses_data =  $this->db->query("SELECT * FROM clausulas WHERE id_lote = ". $row['idLote'] ." AND estatus = 1")->result_array();
                    if (COUNT($clauses_data) > 0) {
                        for ($i = 0; $i < COUNT($clauses_data); $i++) {
                            $this->db->query("UPDATE clausulas SET estatus = 0 WHERE id_clausula = ". $clauses_data[$i]['id_clausula'] ." AND estatus = 1");
                        }
                    }
                    $this->db->insert('clausulas', $data_lp);
                } else {
                    $clauses_data =  $this->db->query("SELECT * FROM clausulas WHERE id_lote = ". $row['idLote'] ." AND estatus = 1")->result_array();
                    if (COUNT($clauses_data) > 0) {
                        for ($i = 0; $i < COUNT($clauses_data); $i++) {
                            $this->db->query("UPDATE clausulas SET estatus = 0 WHERE id_clausula = ". $clauses_data[$i]['id_clausula'] ." AND estatus = 1");
                        }
                    }
                }
                $this->db->query("UPDATE lotes SET idStatusContratacion = 0, nombreLote = REPLACE(REPLACE(nombreLote, ' AURA', ''), ' STELLA', ''),
                idMovimiento = 0, comentario = 'NULL', idCliente = 0, usuario = '".$userLiberacion."', perfil = 'NULL ', 
                fechaVenc = null, modificado = null, status8Flag = 0, 
                ubicacion = 0, totalNeto = 0, totalNeto2 = 0,
                casa = (CASE WHEN idCondominio IN (759, 639) THEN 1 ELSE 0 END),
                totalValidado = 0, validacionEnganche = 'NULL', 
                fechaSolicitudValidacion = null, 
                fechaRL = null, 
                registro_comision = 8,
                tipo_venta = ".$tventa.", 
                $descuento
                observacionContratoUrgente = NULL,
                firmaRL = 'NULL', comentarioLiberacion = 'LIBERADO', 
                observacionLiberacion = 'LIBERADO POR CORREO', idStatusLote = ".$st.", 
                fechaLiberacion = '".date("Y-m-d H:i:s")."', 
                userLiberacion = '".$this->session->userdata('username')."',
                precio = ".$datos['precio'].", total = ((".$row['sup'].") * ".$datos['precio']."),
                enganche = (((".$row['sup'].") * ".$datos['precio'].") * 0.1), 
                saldo = (((".$row['sup'].") * ".$datos['precio'].") - (((".$row['sup'].") * ".$datos['precio'].") * 0.1)),
                asig_jur = 0,
                msi = " . $row['msi_respaldo'] . "
                WHERE idLote IN (".$row['idLote'].") and status = 1 ");
            } else if ($datos['activeLE'] == 1) {
                $this->db->query("UPDATE lotes SET idStatusContratacion = 0, 
                idMovimiento = 0, comentario = 'NULL', idCliente = 0, usuario = '".$userLiberacion."', perfil = 'NULL ', 
                fechaVenc = null, modificado = null, status8Flag = 0,
                ubicacion = 0, totalNeto = 0, totalNeto2 = 0,
                totalValidado = 0, validacionEnganche = 'NULL', 
                casa = (CASE WHEN idCondominio IN (759, 639) THEN 1 ELSE 0 END),
                fechaSolicitudValidacion = null,
                fechaRL = null, 
                registro_comision = 8,
                tipo_venta = ".$tventa.", 
                $descuento
                observacionContratoUrgente = NULL,
                firmaRL = 'NULL', comentarioLiberacion = 'LIBERADO', 
                observacionLiberacion = 'LIBERADO POR CORREO', idStatusLote = 101, 
                fechaLiberacion = '".date("Y-m-d H:i:s")."', 
                userLiberacion = '".$this->session->userdata('username')."',
                precio = ".$datos['precio'].", total = ((".$row['sup'].") * ".$datos['precio']."),
                enganche = (((".$row['sup'].") * ".$datos['precio'].") * 0.1), 
                saldo = (((".$row['sup'].") * ".$datos['precio'].") - (((".$row['sup'].") * ".$datos['precio'].") * 0.1)),
                asig_jur = 0,
                msi = " . $row['msi_respaldo'] . "
                WHERE idLote IN (".$row['idLote'].") and status = 1 ");
            }
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                if (intval($row['lugar_prospeccion']) == 47) { // ES UN CLIENTE CUYO PROSPECTO SE CAPTURÓ A TRAVÉS DE ARCUS
                    $arcusData = array(
                        "propiedadRelacionada" => $row['idLote'],
                        "uid" => $row['id_arcus'],
                        "etapa" => 'No viable'
                    );
                    $response = $this->arcus->sendLeadInfoRecord($arcusData);
                }
                return true;
            }
        }
    }

    public function uploadSup($datos)
    {

        $query = $this->db->query("SELECT idLote, nombreLote, precio, status FROM lotes where idCondominio = " . $datos['idCondominio'] . " and nombreLote = '" . $datos['nombreLote'] . "' and status = 1");

        foreach ($query->result_array() as $row) {
            $this->db->query("UPDATE lotes SET 
                sup = " . $datos['sup'] . ",
                total = (" . $datos['sup'] * $row['precio'] . "), 
                enganche = (" . $datos['sup'] * $row['precio'] . " * 0.1), 
                saldo = (" . $datos['sup'] * $row['precio'] . " - (" . $datos['sup'] * $row['precio'] . " * 0.1))
                WHERE idLote IN (" . $row['idLote'] . ") and nombreLote IN ('" . $row['nombreLote'] . "') and status = 1 ");

            return true;


        }

    }


    public function allAsesor()
    {
        return $this->db->query("SELECT u0.id_usuario as id_asesor,u0.id_sede, 
		CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno) asesor,
		u0.id_lider as id_coordinador,
		(CASE u1.id_rol WHEN 9 THEN CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno) WHEN 3 THEN CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno) END) coordinador,
		(CASE u1.id_rol WHEN 3 THEN u1.id_usuario ELSE u2.id_usuario END) id_gerente, 
		(CASE u1.id_rol WHEN 3 THEN CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno) ELSE CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno) END) gerente,
		(CASE u1.id_rol WHEN 3 THEN u1.id_lider ELSE u3.id_usuario END) id_subdirector, 
		(CASE u1.id_rol WHEN 3 THEN CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno) ELSE CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno) END) subdirector,
		(CASE u1.id_rol WHEN 3 THEN (CASE WHEN u2.id_lider = 2 THEN 0 ELSE u2.id_lider END) ELSE CASE 
		WHEN u2.id_usuario = 7092 THEN 3 
		WHEN u2.id_usuario IN (9471,681,609,690) THEN 607 
		WHEN u2.id_lider = 692 THEN u0.id_lider
        WHEN u2.id_lider = 703 THEN 4
        WHEN u2.id_lider = 7886 THEN 5
		ELSE 0 END END) id_regional,
			(CASE u1.id_rol WHEN 3 THEN (CASE WHEN u2.id_lider = 2 THEN 'NO APLICA' ELSE CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno) END) ELSE CASE 
		WHEN u2.id_usuario = 7092 THEN CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno) 
		WHEN u2.id_usuario = 9471 THEN CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno) 
		WHEN u2.id_usuario = 681 THEN CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno) 
		WHEN u2.id_usuario = 609 THEN CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno) 
		WHEN u2.id_usuario = 690 THEN CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno) 
		WHEN (u2.id_usuario = 5 AND u0.id_sede = '11') THEN 'NO APLICA' ELSE 'NO APLICA' END END) regional,
				CASE 
		WHEN (u0.id_sede = '13' AND u2.id_lider = 7092) THEN 3
		WHEN (u0.id_sede = '13' AND u2.id_lider = 3) THEN 7092
		ELSE 0 END id_regional_2,
		CASE 
		WHEN (u0.id_sede = '13' AND u2.id_lider = 7092) THEN CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)
		WHEN (u0.id_sede = '13' AND u2.id_lider = 3) THEN CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)
		ELSE 'NO APLICA' END regional_2
		FROM usuarios u0
		LEFT JOIN usuarios u1 ON u1.id_usuario = u0.id_lider -- COORDINADOR
		LEFT JOIN usuarios u2 ON u2.id_usuario = u1.id_lider -- GERENTE
		LEFT JOIN usuarios u3 ON u3.id_usuario = u2.id_lider -- SUBDIRECTOR
		LEFT JOIN usuarios u4 ON u4.id_usuario = u3.id_lider -- REGIONAL
        WHERE u0.id_rol = 7 AND u0.estatus = 1 AND ISNULL(u0.correo, '') NOT LIKE '%SINCO%' AND ISNULL(u0.correo, '') NOT LIKE '%test_%'
		AND u0.id_usuario NOT IN (4415, 11160, 11161, 11179, 11750, 12187, 11332, 2595, 10828, 9942, 10549, 12874, 13151)
		UNION ALL
		(SELECT id_usuario as id_asesor,0 id_sede,CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) as asesor,0 id_coordinador ,'NO APLICA' coordinador, 0 id_gerente, 'NO APLICA' gerente,
		0 id_subdirector, 'NO APLICA' subdirector,0 id_regional, 'NO APLICA' regional, 0 id_regional_2, 'NO APLICA' regional_2 FROM usuarios WHERE id_usuario = 12874)")->result();
    }


    public function prospectoXAsesor($idAsesor) {
        if($idAsesor == 12874) {
            $where = " p.id_asesor=p.id_coordinador ";
        }else{
            $where = " p.id_asesor = $idAsesor ";
        }
        $query = $this->db->query("SELECT p.id_prospecto, CONCAT(UPPER(p.nombre), ' ', UPPER(p.apellido_paterno), ' ', UPPER(p.apellido_materno), ' (', REPLACE(oxc.nombre, ' (especificar)', ''), ')') nombre,
        UPPER(p.nombre) nombre_cliente, UPPER(p.apellido_paterno) apellido_paterno, UPPER(p.apellido_materno) apellido_materno, p.source
        FROM prospectos p 
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = p.lugar_prospeccion AND oxc.id_catalogo = 9
		WHERE $where AND p.estatus = 1 AND p.lugar_prospeccion != 6
		ORDER BY nombre, apellido_paterno, apellido_materno");
        return $query->result();
    }

    public function insert_proyecto($dato)
    {
        $this->db->insert('residenciales', $dato);
        return true;
    }

    public function insert_cluster($dato)
    {
        $this->db->insert('condominios', $dato);
        return true;
    }

    public function update_proyecto($id, $dato)
    {
        $this->db->where("idResidencial", $id);
        $this->db->update('residenciales', $dato);
        return true;
    }

    public function update_cluster($id, $dato)
    {
        $this->db->where("idCondominio", $id);
        $this->db->update('condominios', $dato);
        return true;
    }

    public function getDocsByType($typeOfPersona, $tipo_venta = NULL) {
        $extraWhere = "";
        if ($tipo_venta == 1) // VENTA DE PARTICULAES
            $extraWhere = "OR (id_catalogo = $typeOfPersona AND id_opcion IN (50))";
        return $this->db-> query("SELECT * FROM opcs_x_cats WHERE (id_catalogo = $typeOfPersona AND estatus = 1 AND id_opcion NOT IN (30)) $extraWhere")->result_array();
    }

    public function insertLotToHist($data)
    {
        $this->db->insert('historial_lotes', $data);
        return true;
    }

    public function insertDocToHist($data)
    {
        $this->db->insert('historial_documento', $data);
        return true;
    }

    public function updateProspecto($id_prospecto, $dataActualizaProspecto)
    {
        $this->db->where("id_prospecto", $id_prospecto);
        $this->db->update('prospectos', $dataActualizaProspecto);
        // return true;
        return $this->db->affected_rows();
    }

    function getReferencesList()
    {
        return $this->db->query("SELECT r.id_referencia, r.id_cliente, r.nombre, CONCAT (c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre_prospecto, 
                                r.telefono, oxc.nombre parentesco, r. fecha_creacion, r.estatus FROM referencias r
                                INNER JOIN clientes c ON c.id_cliente = r.id_cliente
                                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = r.parentesco
                                WHERE oxc.id_catalogo = 26");
    }


    function changeReferenceStatus($data, $id_referencia)
    {
        $response = $this->db->update("referencias", $data, "id_referencia = $id_referencia");
        if (!$response) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }


    function saveReference($data)
    {
        if ($data != '' && $data != null) {
            $response = $this->db->insert("referencias", $data);
            if (!$response) {
                return $finalAnswer = 0;
            } else {
                return $finalAnswer = 1;
            }
        } else {
            return 0;
        }
    }


    function updateReference($data, $id_referencia)
    {
        $response = $this->db->update("referencias", $data, "id_referencia = $id_referencia");
        if (!$response) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }


    public function getCondominioByIdLote($idLote) {
        return $this->db->query(
            "SELECT 
                co.idCondominio,
                lo.idLote,
                lo.nombreLote,
                lo.idViviendaNeoData,
                co.idProyectoNeoData
            FROM 
                lotes lo
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            WHERE 
                lo.idLote = $idLote
            "
        )->result_array();
    }

    public function getLoteData($idLote)
    {
        $this->db->select('*');
        $this->db->where('idLote', $idLote);
        $query = $this->db->get("lotes");
        return $query->result_array();
    }

    public function consultByProspect($id_prospect)
    {
        $this->db->select('*');
        $this->db->where('id_prospecto', $id_prospect);
        $query = $this->db->get("prospectos");
        return $query->result_array();
    }

    public function insertClient($data)
    {
        $this->db->insert('clientes', $data);
        $query = $this->db->query("SELECT IDENT_CURRENT('clientes') as lastId")->result_array();
        return $query;
    }

    public function addClientToLote($idLote, $data)
    {
        $this->db->where("idLote", $idLote);
        $this->db->update('lotes', $data);
        return true;
    }


    public function validate($idLote)
    {
        $this->db->where("idLote", $idLote);
        $this->db->where_in('idStatusLote', array('1', '101', '102', '16', '20'));
        $this->db->where("(idStatusContratacion = 0 OR idStatusContratacion IS NULL)");
        $query = $this->db->get('lotes');
        $valida = (empty($query->result())) ? 0 : 1;
        return $valida;
    }

    //VERIFICAMOS PARA EL APARTADO EN LINEA QUE SE ENCUENTRE EN ESTATUS 99
    public function validar_aOnline( $idLote ){
        $this->db->where("idLote", $idLote);
        $this->db->where_in('idStatusLote', array('99'));
        $this->db->where("(idStatusContratacion = 0 OR idStatusContratacion IS NULL)");
        $query = $this->db->get('lotes');
        $valida = (empty($query->result())) ? 0 : 1;
        return $valida;
    }

    public function validateLote($idLote)
    {
        $this->db->where("idLote", $idLote);
        $this->db->where_in('idStatusLote', array('1', '101', '102'));
        $this->db->where("(idStatusContratacion = 0 OR idStatusContratacion IS NULL)");
        $query = $this->db->get('lotes');
        $valida = (empty($query->result())) ? 0 : 1;
        return $valida;
        //var_dump( $valida);
    }


    public function getNameLote($idLote)
    {
        $query = $this->db->query('SELECT nombreLote, tipo_venta from lotes where idLote =  ' . $idLote . ' ');
        return $query->row();
    }


    public function table_condominio($idResidencial)
    {
        $this->db->select('condominios.idCondominio, residenciales.nombreResidencial, condominios.nombre as nombreCluster, 
        etapas.descripcion, datosbancarios.empresa, tipo_lote, residenciales.abreviatura as abreviatura, condominios.idEtapa as etapa, tipo_lote as tipo, condominios.idDBanco cuenta');
        $this->db->join('residenciales', 'condominios.idResidencial = residenciales.idResidencial');

        $this->db->join('etapas', 'condominios.idEtapa = etapas.idEtapa', 'LEFT');
        $this->db->join('datosbancarios', 'condominios.idDBanco = datosbancarios.idDBanco', 'LEFT');
        $this->db->where('condominios.idResidencial', $idResidencial);

        $this->db->where('condominios.status', 1);
        $query = $this->db->get("condominios");
        return $query->result();

    }


    public function getInventario($condominio)
    {

        $this->db->select('lotes.idLote, nombreLote, sup, precio, total, porcentaje, enganche, saldo, modalidad_1, modalidad_2, 
		referencia, statuslote.nombre, 
		comentarioLiberacion, fechaLiberacion, condominios.nombre as nombreCondominio, residenciales.nombreResidencial, 
		lotes.fecha_modst, clientes.usuario as userApartado, 
		lotes.userstatus as userLote, motivo_change_status, statuslote.idStatusLote');


        $this->db->join('statuslote', 'lotes.idStatusLote = statuslote.idStatusLote');
        $this->db->join('condominios', 'lotes.idCondominio = condominios.idCondominio');
        $this->db->join('residenciales', 'condominios.idResidencial = residenciales.idResidencial');
        $this->db->join('clientes', 'clientes.idLote = lotes.idLote and clientes.status = 1', 'LEFT');


        $this->db->where('lotes.idCondominio', $condominio);
        $this->db->where('lotes.status', 1);

        $this->db->group_by('lotes.idLote, nombreLote, sup, precio, total, porcentaje, enganche, saldo, modalidad_1, modalidad_2, 
		 referencia, statuslote.nombre, comentarioLiberacion, fechaLiberacion, condominios.nombre, residenciales.nombreResidencial, 
		 lotes.fecha_modst, clientes.usuario, lotes.userstatus, motivo_change_status, statuslote.idStatusLote');


        $query = $this->db->get('lotes');
        if ($query) {
            $query = $query->result_array();
            return $query;

        }
    }


    public function getInventario2($idCondominio)
    {

        $query = $this->db->query("SELECT l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
        CAST(l.comentario AS varchar(MAX)) as comentario, l.fechaVenc, l.perfil, cond.nombre as nombreCondominio, res.nombreResidencial, l.ubicacion,
        l.tipo_venta, cl.fechaApartado, l.idStatusLote,

		concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
        concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
        concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,

		concat(asesor2.nombre,' ', asesor2.apellido_paterno, ' ', asesor2.apellido_materno) as asesor2,
        concat(coordinador2.nombre,' ', coordinador2.apellido_paterno, ' ', coordinador2.apellido_materno) as coordinador2,
        concat(gerente2.nombre,' ', gerente2.apellido_paterno, ' ', gerente2.apellido_materno) as gerente2,
	    cond.idCondominio, l.sup, l.precio, l.total, l.porcentaje, l.enganche, l.saldo, l.referencia, st.nombre, l.fecha_modst,
		l.idAsesor

        FROM lotes l
        LEFT JOIN clientes cl ON l.idLote=cl.idLote and cl.status = 1
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
        LEFT JOIN statuslote st ON l.idStatusLote = st.idStatusLote

        LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
		LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
        LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario

        LEFT JOIN usuarios asesor2 ON asesor2.id_usuario = l.idAsesor
		LEFT JOIN usuarios coordinador2 ON coordinador2.id_usuario = asesor2.id_lider
        LEFT JOIN usuarios gerente2 ON gerente2.id_usuario = coordinador2.gerente_id

	    WHERE l.status = 1 and l.idCondominio = " . $idCondominio . "

        GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
        CAST(l.comentario AS varchar(MAX)), l.fechaVenc, l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
        l.tipo_venta, cl.fechaApartado, l.idStatusLote,

		concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno),
        concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno),
        concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno),

		concat(asesor2.nombre,' ', asesor2.apellido_paterno, ' ', asesor2.apellido_materno),
        concat(coordinador2.nombre,' ', coordinador2.apellido_paterno, ' ', coordinador2.apellido_materno),
        concat(gerente2.nombre,' ', gerente2.apellido_paterno, ' ', gerente2.apellido_materno),
	    cond.idCondominio, l.sup, l.precio, l.total, l.porcentaje, l.enganche, l.saldo, l.referencia, st.nombre, l.fecha_modst,
		l.idAsesor order by l.nombreLote;");
        return $query->result();

    }


    public function getInventario3($idCondominio, $idResidencial)
    {
        if ($idCondominio != 0)
            $where = " AND l.idCondominio = $idCondominio";
        else
            $where = " AND res.idResidencial = $idResidencial";

        $query = $this->db->query("SELECT l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
        CAST(l.comentario AS varchar(MAX)) as comentario2, l.fechaVenc, l.perfil, cond.nombre as nombreCondominio, res.nombreResidencial, l.ubicacion,
        l.tipo_venta, cl.fechaApartado, l.idStatusLote,
        concat(u0.nombre,' ', u0.apellido_paterno, ' ', u0.apellido_materno) as asesor,
        concat(u1.nombre,' ', u1.apellido_paterno, ' ', u1.apellido_materno) as coordinador,
        concat(u2.nombre,' ', u2.apellido_paterno, ' ', u2.apellido_materno) as gerente,
        concat(u00.nombre,' ', u00.apellido_paterno, ' ', u00.apellido_materno) as asesor2,
        (CASE WHEN u00.id_rol = 9 THEN concat(u00.nombre,' ', u00.apellido_paterno, ' ', u00.apellido_materno) ELSE concat(u11.nombre,' ', u11.apellido_paterno, ' ', u11.apellido_materno) END) coordinador2,
        (CASE WHEN u00.id_rol = 9 THEN concat(u11.nombre,' ', u11.apellido_paterno, ' ', u11.apellido_materno) ELSE concat(u22.nombre,' ', u22.apellido_paterno, ' ', u22.apellido_materno) END) gerente2,
        cond.idCondominio, l.sup, l.precio, l.total, l.porcentaje, l.enganche, l.saldo, l.referencia, st.nombre, l.fecha_modst, l.motivo_change_status comentario,
        l.idAsesor, l.motivo_change_status, tv.tipo_venta, (CASE l.tipo_venta WHEN 1 THEN 1 ELSE 0 END) es_particular,cond.tipo_lote
        FROM lotes l
        LEFT JOIN clientes cl ON l.idLote=cl.idLote and l.idCliente = cl.id_cliente and cl.status = 1             
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
        LEFT JOIN statuslote st ON l.idStatusLote = st.idStatusLote
        LEFT JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
        LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
        LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
        LEFT JOIN usuarios u00 ON u00.id_usuario = l.idAsesor
        LEFT JOIN usuarios u11 ON u11.id_usuario = u00.id_lider
        LEFT JOIN usuarios u22 ON u22.id_usuario = u11.gerente_id
        LEFT JOIN tipo_venta tv ON tv.id_tventa = l.tipo_venta /*NUEVO*/
        WHERE l.status = 1 $where
        GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
        CAST(l.comentario AS varchar(MAX)), l.fechaVenc, l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
        l.tipo_venta, cl.fechaApartado, l.idStatusLote,
        concat(u0.nombre,' ', u0.apellido_paterno, ' ', u0.apellido_materno),
        concat(u1.nombre,' ', u1.apellido_paterno, ' ', u1.apellido_materno),
        concat(u2.nombre,' ', u2.apellido_paterno, ' ', u2.apellido_materno),
        concat(u00.nombre,' ', u00.apellido_paterno, ' ', u00.apellido_materno),
        (CASE WHEN u00.id_rol = 9 THEN concat(u00.nombre,' ', u00.apellido_paterno, ' ', u00.apellido_materno) ELSE concat(u11.nombre,' ', u11.apellido_paterno, ' ', u11.apellido_materno) END),
        (CASE WHEN u00.id_rol = 9 THEN concat(u11.nombre,' ', u11.apellido_paterno, ' ', u11.apellido_materno) ELSE concat(u22.nombre,' ', u22.apellido_paterno, ' ', u22.apellido_materno) END),
        cond.idCondominio, l.sup, l.precio, l.total, l.porcentaje, l.enganche, l.saldo, l.referencia, st.nombre, l.fecha_modst, l.motivo_change_status,
        l.idAsesor, tv.tipo_venta,cond.tipo_lote order by l.idLote;");
        return $query->result();
    }


    public function getEstatus()
    {
        $query = $this->db->get("statuslote");
        return $query->result_array();
    }

 
    public function editaEstatus($id, $dato)
    {
        $this->db->where("idLote", $id);
        $this->db->update('lotes', $dato);
        return true;
    }

    public function insert_bloqueos($data)
    {
        $this->db->insert('historial_bloqueo', $data);
        return true;
    }


    public function infoBloqueos($idLote)
    {

        $this->db->select('lotes.idLote as idLoteL, condominios.idCondominio, residenciales.idResidencial, lotes.nombreLote, residenciales.nombreResidencial, condominios.nombre as nombreCondominio');
        $this->db->join('condominios', 'lotes.idCondominio = condominios.idCondominio');
        $this->db->join('residenciales', 'condominios.idResidencial = residenciales.idResidencial');
        $this->db->where("lotes.idLote", $idLote);
        $query = $this->db->get('lotes');
        return $query->row();
    }


    public function getGerente()
    {
        $query = $this->db->query("SELECT id_usuario, CONCAT(id_usuario,' - ',nombre, ' ', apellido_paterno, ' ', apellido_materno) nombre FROM usuarios WHERE id_rol = 3 AND estatus = 1 OR id_usuario IN (6482, 5, 7092, 14161, 15844)");
        return $query->result_array();
    }


    public function getCoordinador($id_gerente)
    {
        /*$query = $this->db-> query("SELECT id_usuario, CONCAT(id_usuario,' - ', nombre, ' ', apellido_paterno, ' ', apellido_materno) nombre FROM usuarios WHERE id_rol = 9 AND estatus = 1 AND id_lider = $id_gerente
            UNION ALL
            SELECT id_usuario, CONCAT(id_usuario,' - ', nombre, ' ', apellido_paterno, ' ', apellido_materno) nombre FROM usuarios WHERE id_usuario = $id_gerente");*/

        $query = $this->db->query("SELECT id_usuario, CONCAT(id_usuario,' - ',nombre, ' ', apellido_paterno, ' ', apellido_materno) nombre FROM usuarios 
			WHERE (id_rol IN (7, 9, 3) AND (rfc NOT LIKE '%TSTDD%' AND ISNULL(correo, '' ) NOT LIKE '%test_%') AND estatus = 1) OR (id_usuario IN (2567, 4064, 4068, 2588, 4065, 4069, 2541, 2583, 2562, 2572,2559,2576, 2595, 2570, 1383, 5,7092, 10806, 15844)) ORDER BY nombre");

        return $query->result_array();
    }


    public function getAsesor($id_coordinador)
    {
        /*$query = $this->db-> query("SELECT id_usuario, CONCAT(id_usuario,' - ', nombre, ' ', apellido_paterno, ' ', apellido_materno) nombre FROM usuarios WHERE id_rol = 7 AND estatus = 1 AND id_lider = ".$id_coordinador." ");*/

        $query = $this->db->query("SELECT id_usuario, CONCAT(id_usuario,' - ',nombre, ' ', apellido_paterno, ' ', apellido_materno) nombre FROM usuarios 
			WHERE (id_rol IN (7, 9, 3) AND (rfc NOT LIKE '%TSTDD%' AND ISNULL(correo, '' ) NOT LIKE '%test_%') AND estatus = 1) OR 
            (id_usuario IN (2567, 4064, 4068, 2588, 4065, 4069, 2541, 2583, 2562, 2593,2580,2597, 1917, 2591, 9827, 5, 6626, 7092, 5, 691, 690, 681))  ORDER BY nombre");

        return $query->result_array();
    }

    public function getAsesorSpecial() {
        return $this->db->query("SELECT u.id_usuario id_asesor, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_asesor, 
        uu.id_usuario id_coordinador, uuu.id_usuario id_gerente, 
		 uuu.id_usuario id_subdirector,
		  uuu.id_usuario  id_regional,
		 uuu.id_usuario  id_regional_2 FROM usuarios u 
        INNER JOIN usuarios uu ON uu.id_usuario = u.id_lider
        INNER JOIN usuarios uuu ON uuu.id_usuario = uu.id_lider
        WHERE u.id_usuario IN (2583, 2593, 10808)")->result_array();
    }


    function getCoOwnersList($id_cliente)
    {
        return $this->db->query("SELECT * FROM copropietarios where id_cliente = " . $id_cliente . " ");
    }


    function getCoOwnerInformation($id_copropietario)
    {
        return $this->db->query("SELECT * FROM copropietarios WHERE id_copropietario = " . $id_copropietario . "");
    }


    function saveCoOwner($data)
    {

        $response = $this->db->insert("copropietarios", $data);
        if (!$response) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }

    }

    function updateCoOwner($data, $id_copropietario)
    {
        $response = $this->db->update("copropietarios", $data, "id_copropietario = $id_copropietario");
        if (!$response) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }


    function changeCoOwnerStatus($data, $id_vcompartida)
    {
        $response = $this->db->update("copropietarios", $data, "id_copropietario = $id_vcompartida");
        if (!$response) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

    public function get_sede()
    {
        return $this->db->query("SELECT * FROM sedes WHERE estatus = 1");
    }


    public function insert_coopropietarios($data)
    {
        $this->db->insert('copropietarios', $data);
        return true;
    }


    public function insert_vcompartidas($data)
    {
        $this->db->insert('ventas_compartidas', $data);
        return true;
    }


    public function data_cliente()
    {

        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno, lotes.referencia,
                                cl.apellido_materno ,personalidad_juridica ,cl.nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc, cl.id_prospecto
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, 
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, residencial.descripcion , cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN referencias as ref on ref.id_cliente=cl.id_cliente
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                where cl.status = 1 order by cl.id_cliente desc");

        return $query->result();

    }


    public function data_cliente2($idCondominio){
        $query = $this->db->query("SELECT cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,id_subdirector,id_regional,id_regional_2,cl.id_sede, cl.nombre ,cl.apellido_paterno, cl.apellido_materno,
		lotes.referencia ,personalidad_juridica ,cl.nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc, cl.id_prospecto
        ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
        ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
        ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por,
		CASE
		WHEN registro_comision IN (0, 8) THEN 0
		ELSE 1
		END AS registro_comision,
        cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, residencial.descripcion , cl.status, nombreLote,
        (SELECT CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) AS ncliente,
        (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
        (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
        (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador,
		(SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_subdirector=id_usuario) AS subdirector,
		(SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_regional=id_usuario) AS regional,
		(SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_regional_2=id_usuario) AS regional_2,
         '1' changePermission, lotes.idStatusContratacion, lotes.idMovimiento, residencial.empresa
        FROM clientes as cl
        LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
        LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
        LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
        LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
        LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
        where lotes.idCondominio = " . $idCondominio . " AND cl.status = 1 AND lotes.idStatusLote <> 99 order by cl.id_cliente desc");
        return $query->result();
    }


    public function payment($id, $dato)
    {
        $this->db->where("id_cliente", $id);
        $this->db->update('clientes', $dato);
        return true;
    }


    public function historial_Enganche($dato)
    {
        $this->db->insert('historial_enganche', $dato);
        return true;
    }

    function getSharedSalesList($id_cliente)
    {
        return $this->db->query("SELECT vcp.id_vcompartida, p.id_cliente, CONCAT (p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) nombre_prospecto,
        vcp.id_asesor, CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_asesor,
        vcp.id_coordinador, CONCAT (uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) nombre_coordinador,
        vcp.id_gerente, CONCAT (uuu.nombre, ' ', uuu.apellido_paterno, ' ', uuu.apellido_materno) nombre_gerente,
		vcp.id_subdirector, CONCAT (sb.nombre, ' ', sb.apellido_paterno, ' ', sb.apellido_materno) nombre_subdirector,
		vcp.id_regional, CONCAT (rg1.nombre, ' ', rg1.apellido_paterno, ' ', rg1.apellido_materno) nombre_regional,
		vcp.id_regional_2, CONCAT (rg2.nombre, ' ', rg2.apellido_paterno, ' ', rg2.apellido_materno) nombre_regional_2,
        vcp.fecha_creacion, 1 estatus FROM clientes p
        INNER JOIN ventas_compartidas vcp ON vcp.id_cliente = p.id_cliente
        INNER JOIN usuarios u ON u.id_usuario = vcp.id_asesor
        LEFT JOIN usuarios uu ON uu.id_usuario = vcp.id_coordinador
        INNER JOIN usuarios uuu ON uuu.id_usuario = vcp.id_gerente
		INNER JOIN usuarios sb ON sb.id_usuario=vcp.id_subdirector
		LEFT JOIN usuarios rg1 ON rg1.id_usuario=vcp.id_regional
		LEFT JOIN usuarios rg2 ON rg2.id_usuario=vcp.id_regional_2
		WHERE vcp.id_cliente = " . $id_cliente . " AND vcp.estatus IN (1, 2)")->result_array();

    }


    function confirmarPago()
    {
        $this->db->query("UPDATE lt 
        SET lt.idStatusLote = 3 
        FROM lotes lt INNER JOIN
        ( SELECT idLote FROM clientes
          WHERE clientes.noRecibo LIKE 'CONFPAGO%' AND clientes.noRecibo LIKE '%" . $this->input->post('num_operacion') . "') clientes
        ON clientes.idLote = lt.idLote WHERE idStatusLote = 99");

        $this->db->query("  UPDATE clientes
          SET clientes.noRecibo = '" . $this->input->post('folio') . "'
          WHERE clientes.noRecibo LIKE 'CONFPAGO%' AND clientes.noRecibo LIKE '%" . $this->input->post('num_operacion') . "'");
    }

    function saveSalesPartner($data)
    {
        if ($data != '' && $data != null) {
            $response = $this->db->insert("ventas_compartidas", $data);
            if (!$response) {
                return $finalAnswer = 0;
            } else {
                return $finalAnswer = 1;
            }
        } else {
            return 0;
        }
    }


    function changeSalesPartnerStatus($data, $id_vcompartida)
    {
        $response = $this->db->update("ventas_compartidas", $data, "id_vcompartida = $id_vcompartida");
        if (!$response) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

    function changeTitular($data, $id_cliente)
    {
        $response = $this->db->update("clientes", $data, "id_cliente = $id_cliente");
        if (!$response) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }


    function changeTitularAll($data, $id_cliente, $id_pc)
    {

        $this->db->trans_begin();

        $this->db->update("clientes", $data, "id_cliente = $id_cliente");
        $this->db->query("UPDATE copropietarios SET personalidad_juridica = " . $id_pc . " WHERE id_cliente = " . $id_cliente . " ");


        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return $finalAnswer = 0;
        } else {
            $this->db->trans_commit();
            return $finalAnswer = 1;
        }


    }


    public function cancelaPago($id, $dato)
    {

        $this->db->where("idEnganche", $id);
        $this->db->update('historial_enganche', $dato);
        return true;

    }


    public function getHistLib($idLote) {
        return $this->db->query("SELECT hl.idLiberacion, hl.nombreLote, hl.comentarioLiberacion, hl.observacionLiberacion, hl.precio,
        hl.fechaLiberacion, hl.modificado, hl.status, hl.idLote, hl.id_cliente, hl.tipo,
        CASE WHEN ISNUMERIC(TRY_CAST(hl.userLiberacion AS INT)) = 1 THEN CASE WHEN u0.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) END ELSE hl.userLiberacion END userLiberacion
        FROM historial_liberacion hl
        LEFT JOIN usuarios u0 ON u0.id_usuario = TRY_CAST(hl.userLiberacion AS INT)
        WHERE hl.idLote = $idLote")->result_array();
    }


    public function getHistPago($idLote)
    {

        $this->db->where("idLote", $idLote);
        $this->db->where("status", 1);
        $query = $this->db->get("historial_enganche");
        return $query->result_array();

    }


    public function getExpedienteAll($lotes)
    {
        $query = $this->db->query('SELECT hd.expediente, hd.idDocumento, hd.modificado, hd.status, hd.idCliente, hd.idLote, lotes.nombreLote, 
		cl.nombre as nomCliente, cl.apellido_paterno, cl.apellido_materno, cl.rfc, cond.nombre, res.nombreResidencial, 
		u.nombre as primerNom, u.apellido_paterno as apellidoPa, u.apellido_materno as apellidoMa, sedes.abreviacion as ubic, 
		hd.movimiento, hd.movimiento, cond.idCondominio, hd.tipo_doc, lotes.idMovimiento
		FROM historial_documento hd
		INNER JOIN lotes ON lotes.idLote = hd.idLote
		INNER JOIN clientes cl ON  hd.idCliente = cl.id_cliente
		INNER JOIN condominios cond ON cond.idCondominio = lotes.idCondominio
		INNER JOIN residenciales res ON res.idResidencial = cond.idResidencial
		LEFT JOIN usuarios u ON hd.idUser = u.id_usuario
		LEFT JOIN sedes ON lotes.ubicacion = sedes.id_sede
		WHERE hd.status = 1 and hd.idLote = ' . $lotes);

        return $query->result_array();

    }


    public function getDatosLote($idLote)
    {
        $query = $this->db->query('SELECT nombreLote, total, sup, precio, (sup * precio) total_t from lotes where idLote =  ' . $idLote . ' ');
        return $query->row();
    }


    public function validatep($idLote)
    {
        $this->db->where("idLote", $idLote);
        $this->db->where_in('idStatusLote', array('102'));
        $query = $this->db->get('lotes');
        $valida = (empty($query->result())) ? 0 : 1;
        return $valida;

    }

    function updatePresale($data, $id_lote)
    {
        $response = $this->db->update("preventas", $data, "id_lote = $id_lote");
        if (!$response) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

    function validateAvailability($idlotes)
    {
        //return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 11 AND estatus = 1 ORDER BY id_opcion, nombre");
        return $this->db->query("SELECT COUNT(idLote) disponibles FROM lotes WHERE status = 1 AND idStatusLote = 12 AND idLote IN ($idlotes) GROUP BY idStatusLote");
    }

    public function getReasons()
    {
        $query = $this->db->query("SELECT * FROM opcs_x_cats WHERE id_catalogo = 48 AND estatus = 1");
        return $query->result_array();
    }

    public function getProspectByIdClient($id_cliente)
    {
        $query = $this->db->query("SELECT * FROM clientes WHERE id_cliente=" . $id_cliente);
        return $query->result_array();
    }


    function updateProspectoCTN($id_prospecto, $data_update)
    {
        $this->db->where("id_prospecto", $id_prospecto);
        $this->db->update('prospectos', $data_update);
        return $this->db->affected_rows();
    }

    /***********APARTADO ONLINE***********/
    public function trasns_vo($data, $data2, $casas, $idLote, $token_data)
    {
        //Iniciamos la transacción.    
        $this->db->trans_begin();
        //Intenta insertar un cliente.    
        $this->db->insert('clientes', $data);
        //Recuperamos el id del cliente registrado.
        $cliente_id = $this->db->query("SELECT IDENT_CURRENT('clientes') as lastId")->row()->lastId;

        ###UPDATE id_cliente, id_lote
        if(count($token_data)>0){
            $loclup_data = $this->db->query("UPDATE tokens SET id_cliente=".$cliente_id.", id_lote=".$idLote." WHERE token LIKE '". $token_data[0]['token']."'");
        }
        ###END UPDATE

        $horaActual = date('H:i:s');
        $horaInicio = date("08:00:00");
        $horaFin = date("16:00:00");
        $fecha_apartado = date("Y-m-d H:i:s");
        $fecha = $fecha_apartado;

        $limite = $horaActual > $horaInicio && $horaActual < $horaFin ? 5 : 6;
        $i = 0;

        while ($i <= $limite) {
            $hoy_strtotime = strtotime($fecha);
            $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
            $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
            $sig_fecha_dia = date('D', $sig_strtotime);
            $sig_fecha_feriado = date('d-m', $sig_strtotime);

            if (!in_array($sig_fecha_dia, array("Sat", "Sun")) && !in_array($sig_fecha_feriado,
                    array("01-01", "06-02", "20-03", "01-05", "16-09", "20-11", "25-12"))) {
                $i++;
            }

            $fecha = $sig_fecha;
        }

        $updateLote = array();
        $updateLote["idStatusContratacion"] = 1;
        $updateLote["idStatusLote"] = 99;
        $updateLote["idMovimiento"] = 31;
        $updateLote["idCliente"] = $cliente_id;
        $updateLote["comentario"] = 'OK';
        $updateLote["perfil"] = 'caja';
        $updateLote["modificado"] = date("Y-m-d H:i:s");
        $updateLote["fechaVenc"] = $fecha;

        //////////////////////////// CASAS /////////////////////////////////////
        $array_casas = json_decode(json_encode($casas), true);

        if (empty($array_casas)) {

        } else {
            $casasDetail = $this->db->query("SELECT (l.sup * l.precio) total_terreno, c.casasDetail, c.aditivas_extra FROM lotes l 
                INNER JOIN (SELECT id_lote, CONCAT( '{''total_terreno'':''', total_terreno, ''',', tipo_casa, '}') casasDetail, aditivas_extra  
                FROM casas WHERE estatus = 1) c ON c.id_lote = l.idLote WHERE l.idLote = $idLote AND l.status = 1")->result_array();
            $cd = json_decode(str_replace("'", '"', $casasDetail[0]['casasDetail']));

            $update_pcasas = array();

            for ($c = 0; $c < count($array_casas); $c++) {

                $info = $this->getDatosLote($array_casas[$c][0]);

                if ($array_casas[$c][1] == 'STELLA') {
                    $tipo_casa = 2;//TIPO DE CASA PARA GUARDARLO EN CLIENTES
                    $total_construccion = 0; // MJ: AQUÍ VAMOS A GUARDAR EL TOTAL DE LA CONSTRUCCIÓN + LOS EXRTAS
                    foreach ($cd->tipo_casa as $value) {
                        if ($value->nombre == 'Stella') {
                            $total_construccion = $value->total_const;
                            if($casasDetail[0]['aditivas_extra'] == 1){
                                foreach ($value->extras as $v) {
                                    $total_construccion += $v->techado;
                                }
                            }
                        }
                    }
                    $total = $info->total;
                    $update_pcasas["total"] = ($total + $total_construccion);
                    $update_pcasas["enganche"] = ($update_pcasas["total"] * 0.1);
                    $update_pcasas["saldo"] = ($update_pcasas["total"] - $update_pcasas["enganche"]);

                }
                else if ($array_casas[$c][1] == 'AURA') {
                    $tipo_casa = 1;//TIPO DE CASA PARA GUARDARLO EN CLIENTES
                    $total_construccion = 0; // MJ: AQUÍ VAMOS A GUARDAR EL TOTAL DE LA CONSTRUCCIÓN + LOS EXRTAS
                    foreach ($cd->tipo_casa as $value) {
                        if ($value->nombre == 'Aura') {
                            $total_construccion = $value->total_const; // MJ: SE EXTRAE EL TOTAL DE LA CONSTRUCCIÓN POR TIPO DE CASA
                            if($casasDetail[0]['aditivas_extra'] == 1){
                                foreach ($value->extras as $v) {
                                    $total_construccion += $v->techado;
                                }
                            }
                        }
                    }
                    $total = $info->total;
                    $update_pcasas["total"] = ($total + $total_construccion);
                    $update_pcasas["enganche"] = ($update_pcasas["total"] * 0.1);
                    $update_pcasas["saldo"] = ($update_pcasas["total"] - $update_pcasas["enganche"]);

                }  else if ($array_casas[$c][1] == 'TERRENO') {

                    $tipo_casa = 0;//TIPO DE CASA PARA GUARDARLO EN CLIENTES
                    $t = (($info->precio + 500) * $info->sup);
                    $e = ($t * 0.1);
                    $s = ($t - $e);
                    $m2 = ($t / $info->sup);

                    $update_pcasas["total"] = $t;
                    $update_pcasas["enganche"] = $e;
                    $update_pcasas["saldo"] = $s;
                    $update_pcasas["precio"] = $m2;

                }
                $this->addClientToLote($array_casas[$c][0], $update_pcasas);
                $this->db->query("UPDATE clientes SET tipo_casa=".$tipo_casa." WHERE id_cliente=".$cliente_id);
            }

        }

        

        //////////////////////////// CASAS /////////////////////////////////////

    

        $nomLote = $this->getNameLote($data["idLote"]);
        

        $arreglo2 = array();
        $arreglo2["idStatusContratacion"] = 1;
        $arreglo2["idMovimiento"] = 31;
        $arreglo2["nombreLote"] = $nomLote->nombreLote;
        $arreglo2["comentario"] = 'OK';
        $arreglo2["perfil"] = 'caja';
        $arreglo2["usuario"] = $data["id_asesor"];
        $arreglo2["modificado"] = date("Y-m-d H:i:s");
        $arreglo2["fechaVenc"] = date('Y-m-d H:i:s');
        $arreglo2["idLote"] = $data["idLote"];
        $arreglo2["idCondominio"] = $data["idCondominio"];
        $arreglo2["idCliente"] = $cliente_id;
        
        $updateLote["tipo_venta"] = $nomLote->tipo_venta;

        
        $flag_particular = 0;
        
        if($updateLote['tipo_venta'] == 1){
            $flag_particular=1;
        }

        //EL TIPO DE DOCUMENTOS A CARGAR POR EL TIPO DE CLIENTE
        $tipoDoc = $this->getDocsByType(31, $nomLote->tipo_venta);
        foreach ($tipoDoc AS $arrayDocs) {
            $arrayDocs = array(
                'movimiento' => $arrayDocs["nombre"],
                'idCliente' => $cliente_id,
                'idCondominio' => $data["idCondominio"],
                'idLote' => $data["idLote"],
                'tipo_doc' => $arrayDocs["id_opcion"]
            );

            $this->insertDocToHist($arrayDocs);

            /*if($updateLote["tipo_venta"] == 50){
                $this->insertDocToHist($arrayDocs);
            }else{
                $this->insertDocToHist($arrayDocs);
            }   


            if($arrayDocs["id_opcion"] == 50){
                if($flag_particular == 1){
                    $this->caja_model_outside->insertDocToHist($arrayDocs);
                }
                        
            }else{
                    $this->caja_model_outside->insertDocToHist($arrayDocs);

            }*/


        }


        //AGREGAMOS EL LISTADO DE ASESORES
        $array_asesores = json_decode(json_encode($data2), true);

        /*foreach($array_asesores as $value) {

            $arreglo_asesores=array();
            $arreglo_asesores["id_gerente"]= $value["idGerente"];
            $arreglo_asesores["id_coordinador"]= $value["idCoordinador"];
            $arreglo_asesores["id_asesor"]= $value["idAsesor"];
            $arreglo_asesores["id_cliente"]= $cliente_id;
            $arreglo_asesores["estatus"] = 1;
            $arreglo_asesores["creado_por"] = $value["idAsesor"];


            $this->insert_vcompartidas($arreglo_asesores);
        }*/


        $this->addClientToLote($data["idLote"], $updateLote);
        $this->insertLotToHist($arreglo2);

        if ($this->db->trans_status() === FALSE) {
            //Hubo errores en la consulta, entonces se cancela la transacción.
            $this->db->trans_rollback();
            return false;
        } else {
            //Todas las consultas se hicieron correctamente.
            $this->db->trans_commit();
            return true;
        }
    }


    function getClientInformation($id_cliente)
    {
        return $this->db->query("SELECT id_cliente, id_asesor, id_coordinador, id_gerente FROM clientes WHERE id_cliente = $id_cliente");
    }

    function getSalesPartnerInformation($id_cliente)
    {
        return $this->db->query("SELECT id_vcompartida, id_cliente, id_asesor, id_coordinador, id_gerente FROM ventas_compartidas WHERE id_cliente = $id_cliente AND estatus = 1");
    }

    public function getLider($id_gerente) {
        return $this->db->query("SELECT us.id_lider as id_subdirector, 
		(CASE 
        WHEN us.id_lider IN (7092, 15316) THEN 3 
        WHEN us.id_lider IN (9471, 681, 609, 2411, 9783, 896) THEN 607 
		WHEN us.id_lider = 692 THEN u0.id_lider
        WHEN us.id_lider IN (703, 19) THEN 4
        WHEN us.id_lider = 7886 THEN 5
        WHEN us.id_lider = 690 THEN 6626
        ELSE 0 END) id_regional,
		CASE 
		WHEN (us.id_sede IN ('13', '14') AND u0.id_lider = 7092) THEN 3
		WHEN (us.id_sede IN ('13', '14') AND u0.id_lider = 3) THEN 7092
		ELSE 0 END id_regional_2,
        us.id_sede
        FROM usuarios us
        LEFT JOIN usuarios u0 ON u0.id_usuario = us.id_lider
        WHERE us.id_usuario IN ($id_gerente)")->result_array();
    }

    public function getEmpresasList()
    {
        return $this->db->query("SELECT id_opcion, id_catalogo, nombre FROM opcs_x_cats WHERE id_catalogo = 61 AND estatus = 1")->result_array();
    }

    public function getTokensInformation()
    {
        if($this->session->userdata('id_usuario') == 3)
            $where = "WHERE tk.creado_por = " . $this->session->userdata('id_usuario');
        else
            $where = "";
        return $this->db->query("SELECT tk.id_token, tk.token, CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno) generado_para,
        tk.fecha_creacion, CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno) creado_por, tk.nombre_archivo, tk.estatus,
        cl.fechaApartado, tk.id_cliente, tk.id_lote, CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno ) as nombreCliente,
        l.nombreLote, ".$this->session->userdata('id_rol')." as currentRol
        FROM tokens tk
        INNER JOIN usuarios u1 ON u1.id_usuario = tk.para
        INNER JOIN usuarios u2 ON u2.id_usuario = tk.creado_por
        LEFT JOIN clientes cl ON cl.id_cliente = tk.id_cliente
        LEFT JOIN lotes l ON l.idLote = tk.id_lote
        $where  ORDER BY tk.fecha_creacion");
    }

    public function getEmpresasLargoList()
    {
        return $this->db->query("SELECT id_opcion, id_catalogo, nombre FROM opcs_x_cats WHERE id_catalogo = 72 AND estatus = 1")->result_array();
    }

    public function getBancosLargoList(){
        return $this->db->query("SELECT id_opcion, id_catalogo, nombre FROM opcs_x_cats WHERE id_catalogo = 73 AND estatis = 1")->result_array();
    }

    public function validateCurrentLoteStatus($idLote){
        return $this->db->query("SELECT lo.idLote, lo.nombreLote, lo.idStatusContratacion, lo.idStatusLote,con.tipo_lote,re.idResidencial,lo.sup, 
        UPPER(sc.nombreStatus) nombreStatusContratacion, st.nombre nombreStatusLote FROM lotes lo
        LEFT JOIN statuscontratacion sc ON sc.idStatusContratacion = lo.idStatusContratacion
        LEFT JOIN statuslote st ON st.idStatusLote = lo.idStatusLote
        LEFT JOIN condominios con ON con.idCondominio=lo.idCondominio
        LEFT JOIN residenciales re ON re.idResidencial=con.idResidencial
        WHERE lo.idLote IN ($idLote)");
    }

    public function getTipoLote()
    {
        return $this->db->query("SELECT id_opcion, id_catalogo, nombre FROM opcs_x_cats WHERE id_catalogo = 27 AND estatus = 1")->result_array();
    }

    public function allSubdirector()
    {
        return $this->db->query("SELECT u.id_usuario id_subdirector, 
        CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre FROM usuarios u 
        WHERE u.id_rol IN (2) AND u.estatus = 1 AND ISNULL(u.correo, '') NOT LIKE '%SINCO%' AND ISNULL(u.correo, '') NOT LIKE '%test_%'")->result();
    }
    public function allUserVentas()
    {
        return $this->db->query("SELECT u0.id_usuario as id_asesor,u0.id_sede, 
		CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno) asesor,
		u0.id_lider as id_coordinador,
		(CASE u1.id_rol WHEN 9 THEN CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno) WHEN 3 THEN CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno) END) coordinador,
		(CASE u1.id_rol WHEN 3 THEN u1.id_usuario ELSE u2.id_usuario END) id_gerente, 
		(CASE u1.id_rol WHEN 3 THEN CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno) ELSE CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno) END) gerente,
		(CASE u1.id_rol WHEN 3 THEN u1.id_lider ELSE u3.id_usuario END) id_subdirector, 
		(CASE u1.id_rol WHEN 3 THEN CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno) ELSE CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno) END) subdirector,
		(CASE u1.id_rol WHEN 3 THEN (CASE WHEN u2.id_lider = 2 THEN 0 ELSE u2.id_lider END) ELSE CASE 
		WHEN u3.id_usuario = 7092 THEN 3 
		WHEN u2.id_usuario IN (9471,681,609,690) THEN 607 
		WHEN u2.id_lider = 692 THEN u0.id_lider
        WHEN u2.id_lider = 703 THEN 4
        WHEN u2.id_lider = 7886 THEN 5
		ELSE 0 END END) id_regional,
			(CASE u1.id_rol WHEN 3 THEN (CASE WHEN u2.id_lider = 2 THEN 'NO APLICA' ELSE CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno) END) ELSE CASE 
		WHEN u3.id_usuario = 7092 THEN CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno) 
		WHEN u3.id_usuario = 9471 THEN CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno) 
		WHEN u3.id_usuario = 681 THEN CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno) 
		WHEN u3.id_usuario = 609 THEN CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno) 
		WHEN u3.id_usuario = 690 THEN CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno) 
		WHEN (u3.id_usuario = 5 AND u0.id_sede = '11') THEN 'NO APLICA' ELSE 'NO APLICA' END END) regional,
				CASE 
		WHEN (u0.id_sede = '13' AND u2.id_lider = 7092) THEN 3
		WHEN (u0.id_sede = '13' AND u2.id_lider = 3) THEN 7092
		ELSE 0 END id_regional_2,
		CASE 
		WHEN (u0.id_sede = '13' AND u2.id_lider = 7092) THEN CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)
		WHEN (u0.id_sede = '13' AND u2.id_lider = 3) THEN CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)
		ELSE 'NO APLICA' END regional_2
		FROM usuarios u0
		LEFT JOIN usuarios u1 ON u1.id_usuario = u0.id_lider -- COORDINADOR
		LEFT JOIN usuarios u2 ON u2.id_usuario = u1.id_lider -- GERENTE
		LEFT JOIN usuarios u3 ON u3.id_usuario = u2.id_lider -- SUBDIRECTOR
		LEFT JOIN usuarios u4 ON u4.id_usuario = u3.id_lider -- REGIONAL
        WHERE u0.id_rol = 7 AND u0.estatus = 1 AND ISNULL(u0.correo, '') NOT LIKE '%SINCO%' AND ISNULL(u0.correo, '') NOT LIKE '%test_%'
		AND u0.id_usuario NOT IN (4415, 11160, 11161, 11179, 11750, 12187, 11332, 2595, 10828, 9942, 10549, 12874, 13151)
		UNION ALL
		(SELECT id_usuario as id_asesor,0 id_sede,CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) as asesor,0 id_coordinador ,'NO APLICA' coordinador, 0 id_gerente, 'NO APLICA' gerente,
		0 id_subdirector, 'NO APLICA' subdirector,0 id_regional, 'NO APLICA' regional, 0 id_regional_2, 'NO APLICA' regional_2 FROM usuarios WHERE id_usuario = 12874)")->result();
    }

    function checkTipoJuridico($id_cliente){
        //función para revisar el tipo de personalidad juridica
        $data = $this->db->query("SELECT * FROM clientes WHERE id_cliente=".$id_cliente);
        return $data->row();
    }
    function documentacionActual($id_cliente){
        $query = $this->db->query("SELECT hd.*, cl.personalidad_juridica 
        FROM clientes cl 
        INNER JOIN historial_documento hd ON cl.id_cliente=hd.idCliente WHERE hd.idCliente=".$id_cliente);
        return $query->result_array();
    }
    function nuevaDocByTP($personaJuridica){
        $tipoPersonalidad = 0;
        switch ($personaJuridica){
            case 1:
                $tipoPersonalidad = 32;
                break;
            case 2:
                $tipoPersonalidad = 31;
                break;
        }
        //obtiene la documentacion por tipo de persona
        $data = $this->db->query("SELECT * FROM opcs_x_cats WHERE id_catalogo=".$tipoPersonalidad." AND estatus=1");
        return $data->result_array();
    }
    function deshabDocsByLoteCliente($idLote, $idCliente){
        //deshabilita los registros por idLote y idCliente
        $dataActualiza = array(
            'status' => 0
        );
        $this->db->where("idLote", $idLote);
        $this->db->where("idCliente", $idCliente);
        $this->db->update('historial_documento', $dataActualiza);
        return $this->db->affected_rows();
//        return 5;//prueba
    }

    public function validarTipoVenta($idLote) {
        return $this->db-> query("SELECT ISNULL(tipo_venta, 0) tipo_venta FROM lotes WHERE idLote = $idLote")->row(); 
    }
    public function getDatosCondominio($idCondominio){
        return $this->db->query("SELECT tipo_lote FROM condominios WHERE idCondominio=$idCondominio")->result_array();
    }

    public function getInformaciongGeneralPorCliente($id_cliente) {
        return $this->db->query(
            "SELECT
                lo.nombreLote,
                lo.idViviendaNeoData,
                co.idProyectoNeoData,
                cl.telefono1,
                cl.ladaTel1,
                cl.telefono2,
                cl.correo,
                REPLACE(cl.fecha_nacimiento, ' 00:00:00.000', '') fecha_nacimiento,
                CONVERT(varchar, cl.fechaApartado, 23) fechaApartado,
                lo.referencia,
                cl.rfc,
                cl.estado,
                cl.pais,
                cl.genero,
                cl.municipio,
                cl.tipoMoneda,
                cl.exterior,
                cl.interior,
                cl.cp,
                cl.calle,
                cl.localidad, 
                cl.regimen_fac,
                cl.cp_fac, 
                cl.colonia,
                cl.pais
            FROM
                clientes cl
            INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idCliente = cl.id_cliente
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN deposito_seriedad ds ON ds.id_cliente = cl.id_cliente
            WHERE
                cl.id_cliente = $id_cliente"
        )->row();
    }

    public function getInformaciongGeneralPorLote($idLote) {
        return $this->db->query(
            "SELECT
                lo.nombreLote,
                lo.idViviendaNeoData,
                co.idProyectoNeoData,
                lo.referencia
            FROM
                lotes lo
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            WHERE
                lo.idLote = $idLote"
        )->row();
    }

}