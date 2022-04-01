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


    public function getResidencialDis2($rol)
    {

        $val_idStatusLote = ($rol == 8 || $rol == 4) ? ('1,101,102') : ('1');


        return $this->db->query("SELECT residenciales.idResidencial, residenciales.nombreResidencial, CAST(residenciales.descripcion AS varchar(MAX)) as descripcion FROM residenciales
            INNER JOIN condominios ON residenciales.idResidencial = condominios.idResidencial
            INNER JOIN lotes ON condominios.idCondominio = lotes.idCondominio WHERE lotes.idStatusLote in (" . $val_idStatusLote . ") AND lotes.status IN ( 1 ) AND
            (lotes.idMovimiento = 0 OR lotes.idMovimiento IS NULL )
            group by residenciales.idResidencial, residenciales.nombreResidencial, CAST(residenciales.descripcion AS varchar(MAX))
            ORDER BY CAST(residenciales.descripcion AS varchar(MAX))")->result_array();

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

        $val_idStatusLote = ($rol == 8 || $rol == 4) ? ('1,101,102') : ('1');


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


    /////////
    public function getLotesDis2($condominio, $rol)
    {

        $val_idStatusLote = ($rol == 8 || $rol == 4) ? ('1,101,102') : ('1');

        /*return $query = $this->db->query("SELECT lotes.idLote, lotes.nombreLote, lotes.precio, lotes.total, lotes.sup, condominios.tipo_lote, lotes.referencia
        FROM lotes
        INNER JOIN condominios ON lotes.idCondominio = condominios.idCondominio
        WHERE lotes.status = 1 AND lotes.idStatusLote in (".$val_idStatusLote.") AND lotes.idCondominio = '$condominio'")->result_array();*/
        return $query = $this->db->query("SELECT lotes.idLote, lotes.nombreLote, lotes.precio, lotes.total, lotes.sup, condominios.tipo_lote, lotes.referencia, lotes.casa, (
            CASE lotes.casa
            WHEN 0 THEN ''
            WHEN 1 THEN  casas.casasDetail
            END
            ) casasDetail
            FROM lotes
            INNER JOIN condominios ON lotes.idCondominio = condominios.idCondominio
            LEFT JOIN (SELECT id_lote, CONCAT( '{''total_terreno'':''', total_terreno, ''',', tipo_casa, '}') casasDetail 
            FROM casas WHERE estatus = 1) casas ON casas.id_lote = lotes.idLote
            WHERE lotes.status = 1 AND lotes.idStatusLote in (" . $val_idStatusLote . ") AND lotes.idCondominio = '$condominio'")->result_array();
    }

    /////////


    public function getResidencial()
    {
        $this->db->select('idResidencial as id_proy, nombreResidencial as siglas, descripcion as nproyecto');
        $this->db->from('residenciales');
        $this->db->where('status', '1');
        $this->db->order_by('nombreResidencial', 'asc');
        $query = $this->db->get();

        return $query->result_array();
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
            $this->db->query("UPDATE lotes SET precio = " . $datos['precio'] . ", 
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


    public function aplicaLiberacion($datos)
    {

        $query = $this->db->query("SELECT idLote, nombreLote, status, sup FROM lotes where idCondominio = " . $datos['idCondominio'] . " and nombreLote = '" . $datos['nombreLote'] . "' and status = 1");

        foreach ($query->result_array() as $row) {

            $this->db->trans_begin();

            $this->db->query("UPDATE historial_documento SET status = 0 WHERE status = 1 and idLote IN (" . $row['idLote'] . ") ");
            $this->db->query("UPDATE prospectos SET tipo = 0, estatus_particular = 4, modificado_por = 1, fecha_modificacion = GETDATE() WHERE id_prospecto IN (SELECT id_prospecto FROM clientes WHERE status = 1 AND idLote = " . $row['idLote'] . ")");
            $this->db->query("UPDATE clientes SET status = 0 WHERE status = 1 and idLote IN (" . $row['idLote'] . ") ");
            $this->db->query("UPDATE historial_enganche SET status = 0, comentarioCancelacion = 'LOTE LIBERADO' WHERE status = 1 and idLote IN (" . $row['idLote'] . ") ");
            $this->db->query("UPDATE historial_lotes SET status = 0 WHERE status = 1 and idLote IN (" . $row['idLote'] . ") ");


            /**------------------------------------------------- */
            $comisiones = $this->db->query("SELECT id_comision,id_lote,comision_total FROM comisiones where id_lote=" . $row['idLote'] . "")->result_array();

            for ($i = 0; $i < count($comisiones); $i++) {
                $sumaxcomision = 0;
                $pagos_ind = $this->db->query("select * from pago_comision_ind where id_comision=" . $comisiones[$i]['id_comision'] . "")->result_array();
                for ($j = 0; $j < count($pagos_ind); $j++) {
                    $sumaxcomision = $sumaxcomision + $pagos_ind[$j]['abono_neodata'];

                }
                $this->db->query("UPDATE comisiones set modificado_por='" . $datos['userLiberacion'] . "',comision_total=$sumaxcomision,estatus=8 where id_comision=" . $comisiones[$i]['id_comision'] . " ");

            }
            //$this->db->query("UPDATE lotes set registro_comision=8  where idLote=".$row['idLote']." ");
            $this->db->query("UPDATE pago_comision set bandera=0,total_comision=0,abonado=0,pendiente=0,ultimo_pago=0 where id_lote=" . $row['idLote'] . " ");
            /**----------------------------------------------- */


            $data_l = array(
                'nombreLote' => $datos['nombreLote'],
                'comentarioLiberacion' => $datos['comentarioLiberacion'],
                'observacionLiberacion' => $datos['observacionLiberacion'],
                'precio' => $datos['precio'],
                'fechaLiberacion' => $datos['fechaLiberacion'],
                'modificado' => $datos['modificado'],
                'status' => $datos['status'],
                'idLote' => $row['idLote'],
                'tipo' => $datos['tipo'],
                'userLiberacion' => $datos['userLiberacion']
            );

            $this->db->insert('historial_liberacion', $data_l);


            if ($datos['activeLE'] == 0) {

                $st = ($datos['activeLP'] == 1) ? 1 : 1;
                $tv = ($datos['activeLP'] == 1) ? 1 : 0;

                if ($tv == 1) { // LIBERACIÓN VENTA DE PARTICULAES
                    $data_lp = array(
                        'id_lote' => $row['idLote'],
                        'nombre' => $datos['clausulas'],
                        'estatus' => 1,
                        "fecha_creacion" => date("Y-m-d H:i:s"),
                        "creado_por" => $datos['userLiberacion']
                    );
                    $clauses_data = $this->db->query("SELECT * FROM clausulas WHERE id_lote = " . $row['idLote'] . " AND estatus = 1")->result_array();
                    if (COUNT($clauses_data) > 0) {
                        for ($i = 0; $i < COUNT($clauses_data); $i++) {
                            $this->db->query("UPDATE clausulas SET estatus = 0 WHERE id_clausula = " . $clauses_data[$i]['id_clausula'] . " AND estatus = 1");
                        }
                    }
                    $this->db->insert('clausulas', $data_lp);
                } else {
                    $clauses_data = $this->db->query("SELECT * FROM clausulas WHERE id_lote = " . $row['idLote'] . " AND estatus = 1")->result_array();
                    if (COUNT($clauses_data) > 0) {
                        for ($i = 0; $i < COUNT($clauses_data); $i++) {
                            $this->db->query("UPDATE clausulas SET estatus = 0 WHERE id_clausula = " . $clauses_data[$i]['id_clausula'] . " AND estatus = 1");
                        }
                    }
                }


                $this->db->query("UPDATE lotes SET idStatusContratacion = 0, nombreLote = REPLACE(REPLACE(nombreLote, ' AURA', ''), ' STELLA', ''),
                        idMovimiento = 0, comentario = 'NULL', idCliente = 0, usuario = 'NULL', perfil = 'NULL ', 
                        fechaVenc = null, modificado = null, 
                        ubicacion = 0, totalNeto = 0, totalNeto2 = 0,
                            totalValidado = 0, validacionEnganche = 'NULL', 
                            fechaSolicitudValidacion = null, 
                            fechaRL = null, 
							registro_comision = 8,
                            tipo_venta = " . $tv . ", 
							observacionContratoUrgente = NULL,
                            firmaRL = 'NULL', comentarioLiberacion = 'LIBERADO', 
                            observacionLiberacion = 'LIBERADO POR CORREO', idStatusLote = " . $st . ", 
                            fechaLiberacion = '" . date("Y-m-d H:i:s") . "', 
                            userLiberacion = '" . $this->session->userdata('username') . "',
                            precio = " . $datos['precio'] . ", total = ((" . $row['sup'] . ") * " . $datos['precio'] . "),
                            enganche = (((" . $row['sup'] . ") * " . $datos['precio'] . ") * 0.1), 
                            saldo = (((" . $row['sup'] . ") * " . $datos['precio'] . ") - (((" . $row['sup'] . ") * " . $datos['precio'] . ") * 0.1))
                            WHERE idLote IN (" . $row['idLote'] . ") and status = 1 ");

            } else if ($datos['activeLE'] == 1) {

                $this->db->query("UPDATE lotes SET idStatusContratacion = 0, 
                            idMovimiento = 0, comentario = 'NULL', idCliente = 0, usuario = 'NULL', perfil = 'NULL ', 
                            fechaVenc = null, modificado = null,
                             ubicacion = 0, totalNeto = 0, totalNeto2 = 0,
                            totalValidado = 0, validacionEnganche = 'NULL', 
                            fechaSolicitudValidacion = null,
                            fechaRL = null, 
							registro_comision = 8,
                            tipo_venta = null, 
							observacionContratoUrgente = NULL,
                            firmaRL = 'NULL', comentarioLiberacion = 'LIBERADO', 
                            observacionLiberacion = 'LIBERADO POR CORREO', idStatusLote = 101, 
                            fechaLiberacion = '" . date("Y-m-d H:i:s") . "', 
                            userLiberacion = '" . $this->session->userdata('username') . "',
                            precio = " . $datos['precio'] . ", total = ((" . $row['sup'] . ") * " . $datos['precio'] . "),
                            enganche = (((" . $row['sup'] . ") * " . $datos['precio'] . ") * 0.1), 
                            saldo = (((" . $row['sup'] . ") * " . $datos['precio'] . ") - (((" . $row['sup'] . ") * " . $datos['precio'] . ") * 0.1))
                            WHERE idLote IN (" . $row['idLote'] . ") and status = 1 ");

            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
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
        $query = $this->db->query("SELECT u.id_usuario id_asesor, uu.id_usuario id_coordinador, uuu.id_usuario id_gerente, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre FROM usuarios u 
                                    INNER JOIN usuarios uu ON uu.id_usuario = u.id_lider 
                                    INNER JOIN usuarios uuu ON uuu.id_usuario = uu.id_lider WHERE u.id_rol = 7 AND u.estatus = 1 AND u.correo NOT LIKE '%SINCO%' AND u.correo NOT LIKE '%test_%'
                                    UNION ALL
                                    SELECT u.id_usuario id_asesor, u.id_usuario id_coordinador, u.id_lider id_gerente, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre FROM usuarios u 
                                    WHERE u.id_rol = 9 AND u.estatus = 1 AND u.correo NOT LIKE '%SINCO%' AND u.correo NOT LIKE '%test_%' ORDER BY nombre");
        return $query->result();
    }


    public function prospectoXAsesor($idAsesor)
    {
        $query = $this->db->query("SELECT p.id_prospecto, CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno, ' (', (CASE oxc.nombre WHEN 'Evento (especificar)' THEN 'Evento' 
        WHEN 'MKT digital (especificar)' THEN 'MKT digital'WHEN 'Pase (especificar)' THEN 'Pase' WHEN 'Visita a empresas (especificar)' THEN 'Visita a empresas' 
        WHEN 'Recomendado (especificar)' THEN 'Recomendado' WHEN 'Otro (especificar)' THEN 'Otro' ELSE oxc.nombre END), ')') nombre FROM prospectos p 
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = p.lugar_prospeccion AND oxc.id_catalogo = 9 WHERE p.id_asesor = $idAsesor AND p.estatus = 1");
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

    public function getDocsByType($typeOfPersona)
    {
        $query = $this->db->query("SELECT * FROM opcs_x_cats WHERE id_catalogo = $typeOfPersona AND estatus = 1");
        /*$this->db->select('*');
        $this->db->where('id_catalogo', $typeOfPersona);
        $query= $this->db->get("opcs_x_cats");*/
        return $query->result_array();
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


    public function getCondominioByIdLote($idLote)
    {
        $this->db->select('*');
        $this->db->join('condominios cond', 'cond.idcondominio = l.idCondominio');

        $this->db->where('idLote', $idLote);
        $query = $this->db->get("lotes l");
        return $query->result_array();
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
        $this->db->where_in('idStatusLote', array('1', '101', '102'));
        $this->db->where("(idStatusContratacion = 0 OR idStatusContratacion IS NULL)");
        $query = $this->db->get('lotes');
        $valida = (empty($query->result())) ? 0 : 1;
        return $valida;
        //var_dump( $valida);

    }

    //VERIFICAMOS PARA EL APARTADO EN LINEA QUE SE ENCUENTRE EN ESTATUS 99
    public function validar_aOnline($idLote)
    {
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
        $query = $this->db->query('SELECT nombreLote from lotes where idLote =  ' . $idLote . ' ');
        return $query->row();
    }


    public function table_condominio($idResidencial)
    {
        $this->db->select('condominios.idCondominio, residenciales.nombreResidencial, condominios.nombre as nombreCluster, etapas.descripcion, datosbancarios.empresa, tipo_lote');
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
		LEFT JOIN usuarios coordinador ON asesor.id_lider = coordinador.id_usuario
        LEFT JOIN usuarios gerente ON coordinador.id_lider = gerente.id_usuario


        LEFT JOIN usuarios asesor2 ON l.idAsesor = asesor2.id_usuario
		LEFT JOIN usuarios coordinador2 ON asesor2.id_lider = coordinador2.id_usuario
        LEFT JOIN usuarios gerente2 ON coordinador2.id_lider = gerente2.id_usuario

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

        if ($idCondominio != 0) {

            $query = $this->db->query("SELECT l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
                l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
                CAST(l.comentario AS varchar(MAX)) as comentario, l.fechaVenc, l.perfil, cond.nombre as nombreCondominio, res.nombreResidencial, l.ubicacion,
                l.tipo_venta, cl.fechaApartado, l.idStatusLote,
                concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
                concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
                concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
                concat(asesor2.nombre,' ', asesor2.apellido_paterno, ' ', asesor2.apellido_materno) as asesor2,
                (CASE WHEN asesor2.id_rol = 9 THEN concat(asesor2.nombre,' ', asesor2.apellido_paterno, ' ', asesor2.apellido_materno) ELSE concat(coordinador2.nombre,' ', coordinador2.apellido_paterno, ' ', coordinador2.apellido_materno) END)coordinador2,
                /*concat(coordinador2.nombre,' ', coordinador2.apellido_paterno, ' ', coordinador2.apellido_materno) as coordinador2x,*/
                (CASE WHEN asesor2.id_rol = 9 THEN concat(coordinador2.nombre,' ', coordinador2.apellido_paterno, ' ', coordinador2.apellido_materno) ELSE concat(gerente2.nombre,' ', gerente2.apellido_paterno, ' ', gerente2.apellido_materno) END)gerente2,
                /*concat(gerente2.nombre,' ', gerente2.apellido_paterno, ' ', gerente2.apellido_materno) as gerente2,*/
                cond.idCondominio, l.sup, l.precio, l.total, l.porcentaje, l.enganche, l.saldo, l.referencia, st.nombre, l.fecha_modst, l.motivo_change_status,
                l.idAsesor, l.motivo_change_status, tv.tipo_venta, (CASE tv.id_tventa WHEN 1 THEN 1 ELSE 0 END) es_particular
                FROM lotes l
                LEFT JOIN clientes cl ON l.idLote=cl.idLote and l.idCliente = cl.id_cliente and cl.status = 1             
                INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
                INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
                LEFT JOIN statuslote st ON l.idStatusLote = st.idStatusLote
                LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
                LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
                LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario
                LEFT JOIN usuarios asesor2 ON l.idAsesor = asesor2.id_usuario
                LEFT JOIN usuarios coordinador2 ON asesor2.id_lider = coordinador2.id_usuario
                LEFT JOIN usuarios gerente2 ON coordinador2.id_lider = gerente2.id_usuario
                LEFT JOIN tipo_venta tv ON tv.id_tventa = l.tipo_venta /*NUEVO*/
                WHERE l.status = 1 and l.idCondominio = " . $idCondominio . "
                GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
                l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
                CAST(l.comentario AS varchar(MAX)), l.fechaVenc, l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
                l.tipo_venta, cl.fechaApartado, l.idStatusLote,
                concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno),
                concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno),
                concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno),
                concat(asesor2.nombre,' ', asesor2.apellido_paterno, ' ', asesor2.apellido_materno),
                (CASE WHEN asesor2.id_rol = 9 THEN concat(asesor2.nombre,' ', asesor2.apellido_paterno, ' ', asesor2.apellido_materno) ELSE concat(coordinador2.nombre,' ', coordinador2.apellido_paterno, ' ', coordinador2.apellido_materno) END),
                /*concat(coordinador2.nombre,' ', coordinador2.apellido_paterno, ' ', coordinador2.apellido_materno),*/
                (CASE WHEN asesor2.id_rol = 9 THEN concat(coordinador2.nombre,' ', coordinador2.apellido_paterno, ' ', coordinador2.apellido_materno) ELSE concat(gerente2.nombre,' ', gerente2.apellido_paterno, ' ', gerente2.apellido_materno) END),
                /*concat(gerente2.nombre,' ', gerente2.apellido_paterno, ' ', gerente2.apellido_materno),*/
                cond.idCondominio, l.sup, l.precio, l.total, l.porcentaje, l.enganche, l.saldo, l.referencia, st.nombre, l.fecha_modst, l.motivo_change_status,
                l.idAsesor, tv.tipo_venta, tv.id_tventa order by l.idLote;");


        } else {

            $query = $this->db->query("SELECT l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
                l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
                CAST(l.comentario AS varchar(MAX)) as comentario, l.fechaVenc, l.perfil, cond.nombre as nombreCondominio, res.nombreResidencial, l.ubicacion,
                l.tipo_venta, cl.fechaApartado, l.idStatusLote,
                concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
                concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
                concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
                concat(asesor2.nombre,' ', asesor2.apellido_paterno, ' ', asesor2.apellido_materno) as asesor2,
                (CASE WHEN asesor2.id_rol = 9 THEN concat(asesor2.nombre,' ', asesor2.apellido_paterno, ' ', asesor2.apellido_materno) ELSE concat(coordinador2.nombre,' ', coordinador2.apellido_paterno, ' ', coordinador2.apellido_materno) END)coordinador2,
                /*concat(coordinador2.nombre,' ', coordinador2.apellido_paterno, ' ', coordinador2.apellido_materno) as coordinador2x,*/
                (CASE WHEN asesor2.id_rol = 9 THEN concat(coordinador2.nombre,' ', coordinador2.apellido_paterno, ' ', coordinador2.apellido_materno) ELSE concat(gerente2.nombre,' ', gerente2.apellido_paterno, ' ', gerente2.apellido_materno) END)gerente2,
                /*concat(gerente2.nombre,' ', gerente2.apellido_paterno, ' ', gerente2.apellido_materno) as gerente2,*/
                cond.idCondominio, l.sup, l.precio, l.total, l.porcentaje, l.enganche, l.saldo, l.referencia, st.nombre, l.fecha_modst, l.motivo_change_status,
                l.idAsesor, l.motivo_change_status, tv.tipo_venta, (CASE tv.id_tventa WHEN 1 THEN 1 ELSE 0 END) es_particular
                FROM lotes l
                LEFT JOIN clientes cl ON l.idLote=cl.idLote and l.idCliente = cl.id_cliente and cl.status = 1             
                INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
                INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
                LEFT JOIN statuslote st ON l.idStatusLote = st.idStatusLote
                LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
                LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
                LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario
                LEFT JOIN usuarios asesor2 ON l.idAsesor = asesor2.id_usuario
                LEFT JOIN usuarios coordinador2 ON asesor2.id_lider = coordinador2.id_usuario
                LEFT JOIN usuarios gerente2 ON coordinador2.id_lider = gerente2.id_usuario
                LEFT JOIN tipo_venta tv ON tv.id_tventa = l.tipo_venta /*NUEVO*/
                WHERE l.status = 1 and res.idResidencial = " . $idResidencial . "  
                GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
                l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
                CAST(l.comentario AS varchar(MAX)), l.fechaVenc, l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
                l.tipo_venta, cl.fechaApartado, l.idStatusLote,
                concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno),
                concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno),
                concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno),
                concat(asesor2.nombre,' ', asesor2.apellido_paterno, ' ', asesor2.apellido_materno),
                (CASE WHEN asesor2.id_rol = 9 THEN concat(asesor2.nombre,' ', asesor2.apellido_paterno, ' ', asesor2.apellido_materno) ELSE concat(coordinador2.nombre,' ', coordinador2.apellido_paterno, ' ', coordinador2.apellido_materno) END),
                /*concat(coordinador2.nombre,' ', coordinador2.apellido_paterno, ' ', coordinador2.apellido_materno),*/
                (CASE WHEN asesor2.id_rol = 9 THEN concat(coordinador2.nombre,' ', coordinador2.apellido_paterno, ' ', coordinador2.apellido_materno) ELSE concat(gerente2.nombre,' ', gerente2.apellido_paterno, ' ', gerente2.apellido_materno) END),
                /*concat(gerente2.nombre,' ', gerente2.apellido_paterno, ' ', gerente2.apellido_materno),*/
                cond.idCondominio, l.sup, l.precio, l.total, l.porcentaje, l.enganche, l.saldo, l.referencia, st.nombre, l.fecha_modst, l.motivo_change_status,
                l.idAsesor, tv.tipo_venta, tv.id_tventa order by l.idLote");

        }

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
        $query = $this->db->query("SELECT id_usuario, CONCAT(id_usuario,' - ',nombre, ' ', apellido_paterno, ' ', apellido_materno) nombre FROM usuarios WHERE id_rol = 3 AND estatus = 1 OR id_usuario IN (6482)");
        return $query->result_array();
    }


    public function getCoordinador($id_gerente)
    {
        /*$query = $this->db-> query("SELECT id_usuario, CONCAT(id_usuario,' - ', nombre, ' ', apellido_paterno, ' ', apellido_materno) nombre FROM usuarios WHERE id_rol = 9 AND estatus = 1 AND id_lider = $id_gerente
            UNION ALL
            SELECT id_usuario, CONCAT(id_usuario,' - ', nombre, ' ', apellido_paterno, ' ', apellido_materno) nombre FROM usuarios WHERE id_usuario = $id_gerente");*/

        $query = $this->db->query("SELECT id_usuario, CONCAT(id_usuario,' - ',nombre, ' ', apellido_paterno, ' ', apellido_materno) nombre FROM usuarios 
			WHERE (id_rol IN (7, 9, 3) AND (rfc NOT LIKE '%TSTDD%' AND ISNULL(correo, '' ) NOT LIKE '%test_%') AND estatus = 1) OR (id_usuario IN (2567, 4064, 4068, 2588, 4065, 4069, 2541, 2583, 2562, 2572,2559,2576, 2595, 2570, 1383)) ORDER BY nombre");

        return $query->result_array();
    }


    public function getAsesor($id_coordinador)
    {
        /*$query = $this->db-> query("SELECT id_usuario, CONCAT(id_usuario,' - ', nombre, ' ', apellido_paterno, ' ', apellido_materno) nombre FROM usuarios WHERE id_rol = 7 AND estatus = 1 AND id_lider = ".$id_coordinador." ");*/

        $query = $this->db->query("SELECT id_usuario, CONCAT(id_usuario,' - ',nombre, ' ', apellido_paterno, ' ', apellido_materno) nombre FROM usuarios 
			WHERE (id_rol IN (7, 9, 3) AND (rfc NOT LIKE '%TSTDD%' AND ISNULL(correo, '' ) NOT LIKE '%test_%') AND estatus = 1) OR 
            (id_usuario IN (2567, 4064, 4068, 2588, 4065, 4069, 2541, 2583, 2562, 2593,2580,2597, 1917, 2591))  ORDER BY nombre");

        return $query->result_array();
    }

    public function getAsesorSpecial()
    {
        $query = $this->db->query("SELECT u.id_usuario id_asesor, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_asesor, 
                                        uu.id_usuario id_coordinador, uuu.id_usuario id_gerente FROM usuarios u 
                                        INNER JOIN usuarios uu ON uu.id_usuario = u.id_lider
                                        INNER JOIN usuarios uuu ON uuu.id_usuario = uu.id_lider
                                        WHERE u.id_usuario IN (2583, 2593)");
        return $query->result_array();
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
        return $this->db->query("SELECT * FROM sedes WHERE id_sede IN (1,2,3,4,5) AND estatus = 1");
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
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc, cl.id_prospecto
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


    public function data_cliente2($idCondominio)
    {

        $query = $this->db->query("SELECT cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede, cl.nombre ,cl.apellido_paterno, cl.apellido_materno,
		                        lotes.referencia ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc, cl.id_prospecto
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por,
								CASE
								WHEN (registro_comision != 1) THEN 0
                                WHEN (cl.lugar_prospeccion IN(27, 28)) THEN 0
								ELSE registro_comision
								END AS registro_comision,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, residencial.descripcion , cl.status, nombreLote,


                                (SELECT CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) AS ncliente,


                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador,
                                /*(CASE lotes.idStatusContratacion WHEN 1 THEN 1 ELSE 0 END)*/ '1' changePermission, lotes.idStatusContratacion, lotes.idMovimiento
								
								
								
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
                                        vcp.fecha_creacion, vcp.estatus FROM clientes p
                                        INNER JOIN ventas_compartidas vcp ON vcp.id_cliente = p.id_cliente
                                        INNER JOIN usuarios u ON u.id_usuario = vcp.id_asesor
                                        LEFT JOIN usuarios uu ON uu.id_usuario = vcp.id_coordinador
                                        INNER JOIN usuarios uuu ON uuu.id_usuario = vcp.id_gerente
										WHERE vcp.id_cliente = " . $id_cliente . " AND vcp.estatus = 1")->result_array();

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


    public function getHistLib($idLote)
    {

        $this->db->where("idLote", $idLote);
        $query = $this->db->get("historial_liberacion");
        return $query->result_array();

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
        $query = $this->db->query('SELECT 
		hd.expediente, hd.idDocumento, hd.modificado, hd.status, hd.idCliente, hd.idLote, lotes.nombreLote, 
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
    public function trasns_vo($data, $data2, $casas, $idLote)
    {
        //Iniciamos la transacción.    
        $this->db->trans_begin();
        //Intenta insertar un cliente.    
        $this->db->insert('clientes', $data);
        //Recuperamos el id del cliente registrado.    
        //$cliente_id = $this->db->last_id();
        $cliente_id = $this->db->query("SELECT IDENT_CURRENT('clientes') as lastId")->row()->lastId;

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
            $casasDetail = $this->db->query("SELECT (l.sup * l.precio) total_terreno, c.casasDetail FROM lotes l 
                INNER JOIN (SELECT id_lote, CONCAT( '{''total_terreno'':''', total_terreno, ''',', tipo_casa, '}') casasDetail  
                FROM casas WHERE estatus = 1) c ON c.id_lote = l.idLote WHERE l.idLote = $idLote AND l.status = 1")->result_array();
            $cd = json_decode(str_replace("'", '"', $casasDetail[0]['casasDetail']));

            $update_pcasas = array();

            for ($c = 0; $c < count($array_casas); $c++) {

                $info = $this->getDatosLote($array_casas[$c][0]);

                if ($array_casas[$c][1] == 'STELLA') {
                    $total_construccion = 0; // MJ: AQUÍ VAMOS A GUARDAR EL TOTAL DE LA CONSTRUCCIÓN + LOS EXRTAS
                    foreach ($cd->tipo_casa as $value) {
                        if ($value->nombre == 'Stella') {
                            $total_construccion = $value->total_const;
                            foreach ($value->extras as $v) {
                                $total_construccion += $v->techado;
                            }
                        }
                    }
                    $total = $info->total;
                    $update_pcasas["total"] = ($total + $total_construccion);
                    $update_pcasas["enganche"] = ($update_pcasas["total"] * 0.1);
                    $update_pcasas["saldo"] = ($update_pcasas["total"] - $update_pcasas["enganche"]);
                    $update_pcasas["nombreLote"] = $array_casas[$c][3];

                } else if ($array_casas[$c][1] == 'AURA') {
                    $total_construccion = 0; // MJ: AQUÍ VAMOS A GUARDAR EL TOTAL DE LA CONSTRUCCIÓN + LOS EXRTAS
                    foreach ($cd->tipo_casa as $value) {
                        if ($value->nombre == 'Aura') {
                            $total_construccion = $value->total_const; // MJ: SE EXTRAE EL TOTAL DE LA CONSTRUCCIÓN POR TIPO DE CASA
                            foreach ($value->extras as $v) {
                                $total_construccion += $v->techado;
                            }
                        }
                    }
                    $total = $info->total;
                    $update_pcasas["total"] = ($total + $total_construccion);
                    $update_pcasas["enganche"] = ($update_pcasas["total"] * 0.1);
                    $update_pcasas["saldo"] = ($update_pcasas["total"] - $update_pcasas["enganche"]);
                    $update_pcasas["nombreLote"] = $array_casas[$c][3];

                } /*if($array_casas[$c][1] == 'STELLA'){
             
             if(
                 $array_casas[$c][2] == 'CCMP-LAMAY-011' || $array_casas[$c][2] == 'CCMP-LAMAY-021' || $array_casas[$c][2] == 'CCMP-LAMAY-030' ||
                 $array_casas[$c][2] == 'CCMP-LAMAY-031' || $array_casas[$c][2] == 'CCMP-LAMAY-032' || $array_casas[$c][2] == 'CCMP-LAMAY-045' ||
                 $array_casas[$c][2] == 'CCMP-LAMAY-046' || $array_casas[$c][2] == 'CCMP-LAMAY-047' || $array_casas[$c][2] == 'CCMP-LAMAY-054' || 
                 $array_casas[$c][2] == 'CCMP-LAMAY-064' || $array_casas[$c][2] == 'CCMP-LAMAY-079' || $array_casas[$c][2] == 'CCMP-LAMAY-080' ||
                 $array_casas[$c][2] == 'CCMP-LAMAY-090' || $array_casas[$c][2] == 'CCMP-LIRIO-010' ||
                 
                 $array_casas[$c][2] == 'CCMP-LIRIO-10' ||
                 $array_casas[$c][2] == 'CCMP-LIRIO-033' || $array_casas[$c][2] == 'CCMP-LIRIO-048' || $array_casas[$c][2] == 'CCMP-LIRIO-049' ||
                 $array_casas[$c][2] == 'CCMP-LIRIO-067' || $array_casas[$c][2] == 'CCMP-LIRIO-089' || $array_casas[$c][2] == 'CCMP-LIRIO-091' ||
                 $array_casas[$c][2] == 'CCMP-LIRIO-098' || $array_casas[$c][2] == 'CCMP-LIRIO-100'
             
             ){
                 $total = $info->total;
                 $update_pcasas["total"]= ($total + 2029185.00);
                 $update_pcasas["enganche"]= ($update_pcasas["total"] * 0.1);
                 $update_pcasas["saldo"]= ($update_pcasas["total"] - $update_pcasas["enganche"]);
 
             
             } else {
                 
                 $total = $info->total;
                 $update_pcasas["total"]= ($total + 2104340.00);
                 $update_pcasas["enganche"]= ($update_pcasas["total"] * 0.1);
                 $update_pcasas["saldo"]= ($update_pcasas["total"] - $update_pcasas["enganche"]);
                 
             
             }
             
             $update_pcasas["nombreLote"]=$array_casas[$c][3];
 
 
             } else if($array_casas[$c][1] == 'AURA'){
                     
             if(
 
                 $array_casas[$c][2] == 'CCMP-LAMAY-011' || $array_casas[$c][2] == 'CCMP-LAMAY-021' || $array_casas[$c][2] == 'CCMP-LAMAY-030' ||
                 $array_casas[$c][2] == 'CCMP-LAMAY-031' || $array_casas[$c][2] == 'CCMP-LAMAY-032' || $array_casas[$c][2] == 'CCMP-LAMAY-045' ||
                 $array_casas[$c][2] == 'CCMP-LAMAY-046' || $array_casas[$c][2] == 'CCMP-LAMAY-047' || $array_casas[$c][2] == 'CCMP-LAMAY-054' || 
                 $array_casas[$c][2] == 'CCMP-LAMAY-064' || $array_casas[$c][2] == 'CCMP-LAMAY-079' || $array_casas[$c][2] == 'CCMP-LAMAY-080' ||
                 $array_casas[$c][2] == 'CCMP-LAMAY-090' || $array_casas[$c][2] == 'CCMP-LIRIO-010' ||
                 
                 $array_casas[$c][2] == 'CCMP-LIRIO-10' ||
                 $array_casas[$c][2] == 'CCMP-LIRIO-033' || $array_casas[$c][2] == 'CCMP-LIRIO-048' || $array_casas[$c][2] == 'CCMP-LIRIO-049' ||
                 $array_casas[$c][2] == 'CCMP-LIRIO-067' || $array_casas[$c][2] == 'CCMP-LIRIO-089' || $array_casas[$c][2] == 'CCMP-LIRIO-091' ||
                 $array_casas[$c][2] == 'CCMP-LIRIO-098' || $array_casas[$c][2] == 'CCMP-LIRIO-100'
             
             ){
                 $total = $info->total;
                 $update_pcasas["total"]= ($total + 1037340.00);
                 $update_pcasas["enganche"]= ($update_pcasas["total"] * 0.1);
                 $update_pcasas["saldo"]= ($update_pcasas["total"] - $update_pcasas["enganche"]);
             
             } else {
                     
                 $total = $info->total;
                 $update_pcasas["total"]= ($total + 1075760.00);
                 $update_pcasas["enganche"]= ($update_pcasas["total"] * 0.1);
                 $update_pcasas["saldo"]= ($update_pcasas["total"] - $update_pcasas["enganche"]);
             
             }
             
             
             $update_pcasas["nombreLote"]=$array_casas[$c][3];
 
 
             }*/ else if ($array_casas[$c][1] == 'TERRENO') {


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

        //EL TIPO DE DOCUMENTOS A CARGAR POR EL TIPO DE CLIENTE
        $tipoDoc = $this->getDocsByType(31);
        foreach ($tipoDoc AS $arrayDocs) {
            $arrayDocs = array(
                'movimiento' => $arrayDocs["nombre"],
                'idCliente' => $cliente_id,
                'idCondominio' => $data["idCondominio"],
                'idLote' => $data["idLote"],
                'tipo_doc' => $arrayDocs["id_opcion"]
            );
            $this->insertDocToHist($arrayDocs);

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

    public function getLider($id_gerente)
    {
        $this->db->select('id_lider as id_subdirector, (CASE WHEN u.id_lider = 7092 THEN 3 WHEN u.id_lider = 9471 THEN 607 ELSE null END) id_regional');
        $this->db->from('usuarios u');
        $this->db->where("u.id_usuario", $id_gerente);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function insertResidencial($data)
    {
        $this->db->trans_begin();
        $this->db->insert('residenciales', $data);
        if ($this->db->trans_status() === FALSE) { // Hubo errores en la consulta, entonces se cancela la transacción.
            $this->db->trans_rollback();
            return false;
        } else { // Todas las consultas se hicieron correctamente.
            $this->db->trans_commit();
            return true;
        }
    }

    public function getEmpresasList()
    {
        return $this->db->query("SELECT id_opcion, id_catalogo, nombre FROM opcs_x_cats WHERE id_catalogo = 61 AND estatus = 1")->result_array();
    }

    public function updateResidencial($data, $idResidencial)
    {
        $this->db->trans_begin();
        $this->db->update("residenciales", $data, "idResidencial = $idResidencial");
        if ($this->db->trans_status() === FALSE) { // Hubo errores en la consulta, entonces se cancela la transacción.
            $this->db->trans_rollback();
            return false;
        } else { // Todas las consultas se hicieron correctamente.
            $this->db->trans_commit();
            return true;
        }
    }

    public function getTokensInformation()
    {
        return $this->db->query("SELECT tk.id_token, tk.token, CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno) generado_para,
        tk.fecha_creacion, CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno) creado_por
        FROM tokens tk
        INNER JOIN usuarios u1 ON u1.id_usuario = tk.para
        INNER JOIN usuarios u2 ON u2.id_usuario = tk.creado_por
        WHERE tk.creado_por = " . $this->session->userdata('id_usuario') . " ORDER BY tk.fecha_creacion");
    }

}
