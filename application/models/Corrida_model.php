<?php class Corrida_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getPaquetes($idLote){

        $query = $this->db-> query('SELECT id_descuento from [lotes] where idLote = '.$idLote.'');

        foreach ($query->result_array() as $desc)
        {
        }
        $query = $this->db-> query('SELECT id_paquete, descripcion from [paquetes] WHERE estatus = 1 and id_paquete IN ('.$desc['id_descuento'].')');

        return $query->result_array();
    }


    public function getGerente(){
        $query = $this->db-> query("SELECT u.id_rol, u.estatus, u.id_usuario idGerente, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreGerente 
                                FROM usuarios u WHERE u.id_rol = 3 AND u.estatus = 1 ORDER BY nombreGerente");
        return $query->result_array();
    }

    public function getCoordinador($gerent){
        $query = $this->db->query("SELECT u.id_lider, u.id_rol, u.estatus, u.id_usuario idCoordinador, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreCoordinador 
                                FROM usuarios u WHERE u.id_rol = 9 AND u.estatus = 1 AND u.id_lider IN (".$gerent.")
                                UNION ALL
                                SELECT u.id_lider, u.id_rol, u.estatus, u.id_usuario idCoordinador, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreCoordinador 
                                FROM usuarios u WHERE u.id_rol = 3 AND u.estatus = 1 AND u.id_usuario IN (".$gerent.") ORDER BY nombreCoordinador");
        return $query->result_array();
    }

    public function getAsesores($coordinador){
        $query = $this->db->query("SELECT u.id_lider, u.id_rol, u.estatus, u.id_usuario idAsesor, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreAsesor 
                                FROM usuarios u WHERE u.id_rol = 7 AND u.estatus = 1 AND u.id_lider IN (".$coordinador.")
                                UNION SELECT u.id_lider, u.id_rol, u.estatus, u.id_usuario idAsesor, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreAsesor 
								FROM usuarios u WHERE u.id_rol = 9 AND u.estatus = 1 AND u.id_usuario IN (".$coordinador.")
								UNION SELECT u.id_lider, u.id_rol, u.estatus, u.id_usuario idAsesor, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreAsesor 
								FROM usuarios u WHERE u.id_rol = 3 AND u.estatus = 1 AND u.id_usuario IN (".$coordinador.") ORDER BY nombreAsesor");
        return $query->result_array();
    }



    public function insertCorrida($dato, $id_corrida){

        for($i=0;$i<count($dato);$i++) {
            $data = array(
                'fecha'=> $dato[$i]->fecha,
                'pago'=> $dato[$i]->pago,
                'capital'=> $dato[$i]->capital,
                'interes'=> $dato[$i]->interes,
                'total'=> $dato[$i]->total,
                'saldo'=> $dato[$i]->saldo,
                'id_corrida'=> $id_corrida
            );

            $this->db->insert('corrida_dump',$data);
        }

    }




    public function getinfoCorrida_mala($id_corrida) {
        return $this->db->query("SELECT id_lote, nombre, edad, telefono, correo, id_asesor, id_gerente, plan_corrida, anio, dias_pagar_enganche, porcentaje_enganche, cantidad_enganche, 
                            meses_diferir, apartado, paquete, opcion_paquete, precio_m2_final, saldo, precio_final, fecha_limite, pago_enganche, msi_1p, msi_2p, msi_3p, primer_mensualidad, observaciones, 
                            finalMesesp1, finalMesesp2, finalMesesp3 FROM corridas_financieras WHERE id_corrida = ".$id_corrida."");

    }
    public function getinfoCorrida($id_corrida) {
        $query = $this->db->query("SELECT id_lote, nombre, edad, telefono, correo, id_asesor, id_coordinador, id_gerente, plan_corrida, anio, dias_pagar_enganche, porcentaje_enganche, cantidad_enganche, 
                            meses_diferir, apartado, paquete, opcion_paquete, precio_m2_final, saldo, precio_final, fecha_limite, pago_enganche, msi_1p, msi_2p, msi_3p, primer_mensualidad, observaciones, 
                            finalMesesp1, finalMesesp2, finalMesesp3 FROM corridas_financieras WHERE id_corrida = ".$id_corrida);
        return $query->row();

    }

    public function getinfoLoteCorrida_mala($id_lote) {
        return $this->db->query("SELECT idLote, nombreLote, referencia, con.nombre as nombreCondominio, res.nombreResidencial, sup, precio, total, porcentaje, enganche, dbc.empresa, 
                            dbc.banco, dbc.cuenta, dbc.clabe FROM [lotes] lot INNER JOIN [condominios] con ON con.idCondominio = lot.idCondominio 
                            INNER JOIN [residenciales] res ON res.idResidencial = con.idResidencial 
                            INNER JOIN [datosbancarios] dbc ON con.idDBanco = dbc.idDBanco WHERE lot.status = 1 AND lot.idLote = ".$id_lote."");
    }
    public function getinfoLoteCorrida($id_lote) {
        $query = $this->db->query("SELECT idLote, nombreLote, referencia, con.nombre as nombreCondominio, res.nombreResidencial, sup, precio, total, porcentaje, enganche, dbc.empresa, 
                            dbc.banco, dbc.cuenta, dbc.clabe FROM [lotes] lot INNER JOIN [condominios] con ON con.idCondominio = lot.idCondominio 
                            INNER JOIN [residenciales] res ON res.idResidencial = con.idResidencial 
                            INNER JOIN [datosbancarios] dbc ON con.idDBanco = dbc.idDBanco WHERE lot.status = 1 AND lot.idLote = ".$id_lote."");
        return $query->row();
    }

    public function getinfoDescLoteCorrida_mala($idLote, $id_corrida) {
        return $this->db-> query("SELECT id_pf, precio_t as pt, precio_m as pm, ahorro, idLote, id_corrida FROM [precios_finales] WHERE idLote = ".$idLote." AND id_corrida = ".$id_corrida."");
    }
    public function getinfoDescLoteCorrida($idLote, $id_corrida) {
        $query = $this->db-> query("SELECT id_pf, porcentaje, precio_t as pt, precio_m as pm, ahorro, idLote, id_corrida, precios_finales.id_condicion, c.descripcion as aplicable_a
                FROM [precios_finales] 
                LEFT JOIN condiciones c ON c.id_condicion=precios_finales.id_condicion
                WHERE idLote = ".$idLote." AND id_corrida = ".$id_corrida);
        return $query->result_array();
    }

    public function getAsesorCorrida_mala($id_asesor, $id_gerente) {
        return $this->db->query("SELECT u.id_usuario idAsesor, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreAsesor, uu.id_usuario idCoordinador, 
                                CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) nombreCoordinador, uuu.id_usuario idGerente, CONCAT(uuu.nombre, ' ', uuu.apellido_paterno, ' ', uuu.apellido_materno) nombreGerente 
                                FROM [usuarios] u INNER JOIN [usuarios] uu ON uu.id_usuario = u.id_lider 
                                INNER JOIN [usuarios] uuu ON uuu.id_usuario = uu.id_lider WHERE u.id_rol = 7 AND u.estatus = 1 AND u.id_usuario = ".$id_asesor." AND uuu.id_usuario =  ".$id_gerente."");
    }

    public function getAsesorCorrida($id_asesor, $id_gerente) {
        $query = $this->db->query("SELECT u.id_usuario idAsesor, uu.id_usuario idCoordinador, uuu.id_usuario idGerente, 
		                           CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreAsesor,
                                   CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) nombreCoordinador,
								   CONCAT(uuu.nombre, ' ', uuu.apellido_paterno, ' ', uuu.apellido_materno) nombreGerente 
                                   FROM [usuarios] u 
								   INNER JOIN [usuarios] uu ON uu.id_usuario = u.id_lider 
                                   INNER JOIN [usuarios] uuu ON uuu.id_usuario = uu.id_lider 
								   
								   WHERE u.id_rol = 7 AND u.estatus = 1 AND u.id_usuario = ".$id_asesor." AND uuu.id_usuario =  ".$id_gerente."");
        return $query->row();
    }

    public function getCoordCorrida($id_asesor, $id_gerente) {
        $query = $this->db->query("SELECT u.id_usuario idAsesor, uu.id_usuario idCoordinador,  
		                           CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreAsesor,
                                   CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) nombreGerente
                                   FROM [usuarios] u 
								   INNER JOIN [usuarios] uu ON uu.id_usuario = u.id_lider 
								   WHERE u.id_rol = 9 AND u.estatus = 1 AND u.id_usuario = ".$id_asesor." AND uu.id_usuario =  ".$id_gerente."");
        return $query->row();
    }

    public function getGerenteCorrida($id_asesor, $id_gerente) {
        $query = $this->db->query("SELECT u.id_usuario idAsesor, uu.id_usuario idCoordinador,  
		                           CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreAsesor,
                                   CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreGerente
                                   FROM [usuarios] u 
								   INNER JOIN [usuarios] uu ON uu.id_usuario = u.id_lider 
								   WHERE u.id_rol = 3 AND u.estatus = 1 AND u.id_usuario = ".$id_asesor."");
        return $query->row();
    }


    public function getPlanCorrida_mala($id_corrida) {
        return $this->db->query("SELECT id_cd, fecha, pago, capital, interes, total, saldo, id_corrida FROM corrida_dump WHERE id_corrida = ".$id_corrida."");
    }
    public function getPlanCorrida($id_corrida) {
        $query = $this->db->query("SELECT corrida_dump FROM corridas_financieras WHERE id_corrida = ".$id_corrida);
        return $query->result_array();
    }


    /*modificada by MJ*/
    public function getDescuentos()
    {
        $query = $this->db->query('SELECT descuentos.porcentaje, relaciones.id_paquete, relaciones.prioridad, c.apply, descuentos.id_condicion, 
            relaciones.id_descuento,  relaciones.msi_descuento 
            FROM [relaciones] 
            INNER JOIN [descuentos] ON relaciones.id_descuento = descuentos.id_descuento
            INNER JOIN condiciones c ON descuentos.id_condicion = c.id_condicion  
            
            order by prioridad');
        return $query->result_array();
    }

    public function insertCf($dato){
        $this->db->insert('corridas_financieras',$dato);
        $id_c = $this->db->query("SELECT IDENT_CURRENT('corridas_financieras') as lastId")->result_array();

        $query = $this->db-> query("SELECT id_corrida from corridas_financieras where id_corrida = ".$id_c[0]['lastId']."");
        return $query->result_array();
    }



    public function insertPreciosAll($dato, $idLote, $idCorrida){
        for($i=0;$i<count($dato);$i++) {
            $data = array(
                'porcentaje'=> $dato[$i]->porcentaje,
                'precio_t'=> $dato[$i]->pt,
                'precio_m'=> $dato[$i]->pm,
                'ahorro'=> $dato[$i]->ahorro,
                'idLote'=> $idLote,
                'id_condicion'=> $dato[$i]->id_condicion,
                'id_corrida'=> $idCorrida
            );

            // var_dump($data);
            $this->db->insert('precios_finales',$data);
        }

    }



    public function getResidencialDis() {
        $query = $this->db->query("SELECT res.idResidencial, res.nombreResidencial,  CAST(res.descripcion AS NVARCHAR(100)) as descripcion 
        FROM [residenciales] res 
        INNER JOIN [condominios] con ON con.idResidencial = res.idResidencial 
        INNER JOIN [lotes] lot ON lot.idCondominio = con.idCondominio 
        --WHERE lot.idStatusLote = 1 
        GROUP BY res.idResidencial,res.nombreResidencial,  CAST(res.descripcion AS NVARCHAR(100)) ORDER BY res.idResidencial");
        return $query->result_array();
    }


    public function getCondominioDis($residencial) {

        if($this->session->userdata('id_rol') == 6){

            $query = $this->db->query("SELECT con.idCondominio, con.nombre FROM [condominios] con JOIN [lotes] ON con.idCondominio = lotes.idCondominio 
                                    WHERE lotes.idStatusLote in ('1', '3') AND con.status = '1' AND idResidencial = ".$residencial." GROUP BY con.idCondominio, con.nombre ORDER BY con.nombre ASC");
        } elseif ($this->session->userdata('id_rol') == 11 AND $this->session->userdata('id_usuario') == 2755) {

            $query = $this->db->query("SELECT con.idCondominio, con.nombre FROM [condominios] con JOIN [lotes] ON con.idCondominio = lotes.idCondominio 
                                    WHERE con.status = '1' AND idResidencial = ".$residencial." GROUP BY con.idCondominio, con.nombre ORDER BY con.nombre ASC");
        }else
         {
            $statusLote = '1';
                if($this->session->userdata('id_rol') == 17 || $this->session->userdata('id_rol') == 32){
                    $statusLote = '2,3';
                } 

            $query = $this->db->query("SELECT con.idCondominio, con.nombre FROM [condominios] con JOIN [lotes] ON con.idCondominio = lotes.idCondominio 
                                    WHERE lotes.idStatusLote in($statusLote) AND con.status = '1' AND idResidencial = ".$residencial." GROUP BY con.idCondominio, con.nombre ORDER BY con.nombre ASC");


        }

        return $query->result_array();

        // $this->db->select('condominio.idCondominio, condominio.nombre');
        // $this->db->from('condominio');
        // $this->db->join('lotes', 'condominio.idCondominio = lotes.idCondominio');
        // $this->db->where('lotes.idStatusLote','1');
        // $this->db->where('condominio.status','1');
        // $this->db->order_by('nombre','asc');
        // $this->db->where("idResidencial",$residencial);
        // $this->db->group_by('condominio.idCondominio');
        // $query = $this->db->get();
        // return $query->result_array();
    }
    public function getCondominioDisMora($residencial) {
        $query = $this->db->query("SELECT con.idCondominio, con.nombre FROM [condominios] con JOIN [lotes] ON con.idCondominio = lotes.idCondominio 
                                    WHERE lotes.status = 1 AND con.status = '1' AND idResidencial = ".$residencial." GROUP BY con.idCondominio, con.nombre ORDER BY con.nombre ASC");
        return $query->result_array();
    }


    public function getRol($id_asesor) {
        $query = $this->db->query("SELECT u.id_usuario idAsesor, u.id_rol FROM [usuarios] u WHERE u.id_usuario = ".$id_asesor." ");
        return $query->row();
    }

    /*COSAS DE LA CORRIDA Y DEMÁS*/
    public function getAllInfoCorrida($id_corrida){
        $query = $this->db->query("SELECT res.nombreResidencial, res.descripcion as residencial, l.nombreLote, l.precio as preciom2, c.nombre as nombreCondominio,
        l.total as precioOriginal, l.sup as superficie, l.idCliente, l.total as precio_total_lote, cf.*
        FROM corridas_financieras cf
        INNER JOIN lotes l ON l.idLote = cf.id_lote
        INNER JOIN condominios c ON c.idCondominio=l.idCondominio
        INNER JOIN residenciales res ON res.idResidencial = c.idResidencial WHERE id_corrida= ".$id_corrida);
        return $query->row();
    }

    public function getInfoCorridaByID($id_corrida){
        $query = $this->db->query("SELECT *,cf.nombre as nombre, cf.telefono as telefono, cf.correo as correo,
        c.idCondominio, r.idResidencial, l.idLote, coord.id_lider as id_coordinador,
		cf.status as corridaStatus,
		CASE WHEN cf.tipo_casa IS NULL THEN 0
		ELSE cf.tipo_casa END 
		as tipo_casa,
		CASE WHEN cf.id_asesor IS NULL THEN 0
		ELSE cf.id_asesor END 
		as id_asesor, 
		CASE WHEN cf.id_gerente IS NULL THEN 0
        ELSE cf.id_gerente END 
        as id_gerente,
		CASE WHEN cf.id_coordinador IS NULL THEN 0
        ELSE cf.id_coordinador END 
        as id_coordinador,
        CASE WHEN cl.status IS NULL THEN 0
        ELSE cl.status END
        as status,
        CASE WHEN cf.fechaApartado IS NULL THEN '0'
        ELSE cf.fechaApartado END as fechaApartadoCF,
        cl.id_cliente
        FROM corridas_financieras cf 
        INNER JOIN lotes l ON cf.id_lote = l.idLote
        INNER JOIN condominios c ON l.idCondominio=c.idCondominio
        INNER JOIN residenciales r ON c.idResidencial=r.idResidencial
        /*INNER JOIN clientes cl ON cl.id_cliente = l.idCliente */
        INNER JOIN usuarios coord ON coord.id_usuario = cf.id_coordinador/*test*/
        INNER JOIN corridas_x_lotes cpl ON cf.id_corrida = cpl.id_corrida
        LEFT JOIN clientes cl ON cl.id_cliente=cf.id_cliente
        WHERE cf.id_corrida =  ".$id_corrida);
        return $query->row();
    }
    /*MJ*/
    public function getPaquetesByCondominio($id_condominio, $id_corrida)
    {
        return $this->db->query("SELECT id_pxc, id_condominio, id_paquete, nombre, fecha_inicio, fecha_fin,
        (SELECT fecha_creacion FROM corridas_financieras WHERE id_corrida=".$id_corrida.") AS fecha_creacion
        FROM paquetes_x_condominios WHERE id_condominio IN ($id_condominio) ORDER BY fecha_inicio");
    }
    public function getcxl($cxl){
        return $this->db->query("SELECT detalle_paquete FROM corridas_x_lotes WHERE id_cxl IN ($cxl) AND estatus = 1")->row();
    }
    public function getDescById($id_descuento){
        $query = $this->db->query("SELECT
            des.porcentaje, re.id_paquete, re.prioridad, c.apply, des.id_condicion, 
            re.id_descuento,  re.msi_descuento, pq.descripcion as leyenda
        FROM relaciones re
        INNER JOIN descuentos des ON re.id_descuento = des.id_descuento
        INNER JOIN condiciones c ON c.id_condicion = des.id_condicion 
        INNER JOIN paquetes pq ON pq.id_paquete = re.id_paquete
        WHERE des.id_descuento=".$id_descuento." ORDER BY prioridad");
        return $query->row();
    }
    public function getPaqById($id_paquete){
        $query = $this->db->query("SELECT * FROM paquetes WHERE id_paquete=".$id_paquete);
        return $query->row();
    }
    public function getRelDescByIdPq($id_paquete){
        $query = $this->db->query("SELECT * FROM relaciones WHERE id_paquete IN ($id_paquete) ORDER BY prioridad");
        return $query->result_array();
    }
    function getDescsByCondominio($id_condominio, $id_pxc){
        $query = $this->db->query("SELECT * FROM paquetes_x_condominios WHERE estatus=1 AND id_pxc=".$id_pxc);
        return $query->row();
    }
    public function getLotesAsesor($condominio,$residencial){
        switch ($this->session->userdata('id_rol')) {
            case '2':
            case '3': // GERENTE
            case '4': // ASISTENTE DIRECTOR
            case '5': // ASISTENTE SUBDIRECTOR
            case '6': // ASISTENTE GERENTE
            case '9': // COORDINADOR
            case '13': // CONTRALORIA
            case '17': // CONTRALORIA
            case '32': // CONTRALORIA
                $query = $this->db->query("SELECT l.idLote, nombreLote, idStatusLote, cl.id_asesor FROM  lotes l
                        INNER JOIN corridas_financieras cf ON l.idLote = cf.id_lote
                        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
                        WHERE l.idCondominio = ".$condominio."
                        GROUP BY l.idLote, nombreLote, idStatusLote, cl.id_asesor;");
                break;
            case '7': // ASESOR
                $query = $this->db->query("SELECT l.idLote, nombreLote, idStatusLote FROM  lotes l
                        INNER JOIN corridas_financieras cf ON l.idLote = cf.id_lote
                        /*INNER JOIN clientes cl ON cl.id_cliente = l.idCliente*/
                        INNER JOIN usuarios u ON u.id_usuario = cf.id_asesor
                        WHERE l.idCondominio = ".$condominio." AND cf.created_by=".$this->session->userdata('id_usuario')."
                        GROUP BY l.idLote, nombreLote, idStatusLote;");

                break;
            default: // SEE EVERYTHING
                $query = $this->db->query("SELECT lotes.idLote, nombreLote, idStatusLote, clientes.id_asesor FROM lotes
                                        INNER JOIN clientes ON clientes.idLote = lotes.idLote WHERE lotes.status = 1
                                        AND clientes.status = 1 AND lotes.idCondominio = $condominio ORDER BY lotes.idLote");
                break;
        }
        if($query){
            $query = $query->result_array();
            return $query;
        }
    }
    function getCorridasByLote($idLote){
        $id_rol = $this->session->userdata('id_rol');
        $id_usuario = $this->session->userdata('id_usuario');
        $condicion='';
        $valInner = '';

        if($id_rol == 7){
            $condicion='AND cf.created_by='.$id_usuario;
        }else{
            $condicion='';
        }

        if($id_rol == 13 || $id_rol==17 || $id_rol==32){
            $valInner = 'INNER JOIN clientes cl ON l.idCliente = cl.id_cliente';
        }
        $query = $this->db->query("SELECT *,c.nombre as nombreCondominio,
        cf.nombre as nombreCliente,
        CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno ) as nombreAsesor,
        cf.status as status, cf.fecha_creacion as creacion_corrida, l.idStatusContratacion, l.idMovimiento
        FROM corridas_financieras cf
        INNER JOIN lotes l ON l.idLote = cf.id_lote
        INNER JOIN condominios c ON c.idCondominio = l.idCondominio
        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
        $valInner
        INNER JOIN usuarios u ON u.id_usuario = cf.id_asesor WHERE id_lote=".$idLote." ".$condicion);
        return $query->result_array();
    }
    function updateCF($id_corrida, $arreglo){
        $response = $this->db->update("corridas_financieras", $arreglo, "id_corrida = $id_corrida");
        if (! $response ) {
            return 0;
        } else {
            return 1;
        }
    }
    function updatePrecioByCF($idLote, $id_corrida){
        /*print_r($idLote);
        echo '<br>';
        print_r($id_corrida);
        echo '<br>';*/
        $query = $this->db->query("UPDATE precios_finales SET estatus=0, fecha_modificado=GETDATE() WHERE idLote=".$idLote." AND id_corrida=".$id_corrida);
        return $query->affected_rows();

    }
    public function updatePreciosAll($dato, $idLote, $idCorrida){
        #primero se tienen que borrar los registros y luego se deben de insertar alv
        $this->db->query('DELETE FROM precios_finales WHERE id_corrida='.$idCorrida);
        $this->db->affected_rows();



        #insertar despues de haber borrado
        for($i=0;$i<count($dato);$i++) {
            $data = array(
                'porcentaje'=> $dato[$i]->porcentaje,
                'precio_t'=> $dato[$i]->pt,
                'precio_m'=> $dato[$i]->pm,
                'ahorro'=> $dato[$i]->ahorro,
                'idLote'=> $idLote,
                'id_condicion'=> $dato[$i]->id_condicion,
                'id_corrida'=> $idCorrida
            );

            // var_dump($data);
            $this->db->insert('precios_finales',$data);
        }
    }
    public function insertCXL($data_tocxl){
        $this->db->insert('corridas_x_lotes',$data_tocxl);
    }
    public function update_cxl($data, $id_corrida){
        $data_insert = json_encode($data);
//        $data_insert = str_replace('"', "'", $data_insert);
        $this->db->query("UPDATE corridas_x_lotes SET detalle_paquete='".$data_insert."', fecha_modificacion=GETDATE() WHERE id_corrida=".$id_corrida);

        return $this->db->affected_rows();
    }
    public function updateCorridaDump($id_corrida, $corrida_dump){
        $data_insert = json_encode($corrida_dump);
        //$data_insert = str_replace('"', "'", $data_insert);
        $this->db->query("UPDATE corridas_financieras SET corrida_dump='".$data_insert."' WHERE id_corrida=".$id_corrida);
        return $this->db->affected_rows();
    }
    public function actionMCorrida($id_corrida, $action){

        $this->db->query("UPDATE corridas_financieras SET status=".$action." WHERE id_corrida=".$id_corrida);
        return $this->db->affected_rows();
    }
    public function checCFActived($idLote){
        $query = $this->db->query("SELECT id_corrida FROM corridas_financieras WHERE status=1 AND id_lote=".$idLote);
        return $query->result_array();
    }

    public function updateExpCorr($idLote, $data)
    {
        $this->db->where("idLote", $idLote);
        $this->db->where("tipo_doc", 7);
        //$this->db->where("status", 1);
        $this->db->update('historial_documento', $data);
        return $this->db->affected_rows();
    }
    public function getExpedienteCorrida($idLote){
        $query = $this->db->query("SELECT * FROM historial_documento WHERE tipo_doc=7 AND idLote=".$idLote);
        return $query->row();
    }

    public function getInfoCasasRes($idLote){
        $query = $this->db->query("SELECT * FROM casas WHERE estatus=1 AND id_lote=".$idLote);
        return $query->row();
    }

    function getCorridasPCByLote($idLote){
        $id_usuario = $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT *, c.nombre as nombreCondominio, pc.fecha_creacion as fecha_creacionpc, 
        CONCAT(u.nombre,' ', u.apellido_paterno,' ', u.apellido_materno) as nombre_creador,
        CONCAT(um.nombre,' ', um.apellido_paterno,' ', um.apellido_materno) as modificado_nombre
        FROM pagos_capital pc
        INNER JOIN lotes l ON l.idLote = pc.idLote
        INNER JOIN condominios c ON c.idCondominio = l.idCondominio
        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
        /*INNER JOIN clientes cl ON l.idCliente = cl.id_cliente*/
        INNER JOIN usuarios u ON u.id_usuario = pc.creado_por 
        LEFT JOIN usuarios um ON um.id_usuario = pc.modificado_por
        WHERE pc.idLote=".$idLote);
        return $query->result_array();
    }
    public function getLotesPC($condominio,$residencial){
        $query = $this->db->query("SELECT l.idLote, nombreLote, idStatusLote, pc.creado_por FROM  lotes l
                        INNER JOIN pagos_capital pc ON l.idLote = pc.idLote
                        /*INNER JOIN clientes cl ON cl.id_cliente = l.idCliente*/
                        INNER JOIN usuarios u ON u.id_usuario = pc.creado_por
                        WHERE l.idCondominio = ".$condominio." GROUP BY l.idLote, nombreLote, idStatusLote, pc.creado_por;");
        #AND pc.creado_por=".$this->session->userdata('id_usuario')."
        #se cambia para que todos puedan verlo
        if($query){
            $query = $query->result_array();
            return $query;
        }
    }

    public function getInfoPCyID($id_corrida){
        $query = $this->db->query("SELECT  *, c.idCondominio, r.idResidencial, l.idLote, pc.estatus as corridaStatus, pc.fecha_creacion as creacionpc,
        pc.porcentajeEng as porcentajePC, pc.engancheCantidad as enganchePC,
        l.porcentaje as porcentajeLote, l.enganche as engancheLote,
        CASE WHEN pc.apartado IS NULL THEN 0
		ELSE pc.apartado END 
		as apartado
        FROM pagos_capital pc 
        INNER JOIN lotes l ON pc.idLote = l.idLote
        INNER JOIN condominios c ON l.idCondominio=c.idCondominio
        INNER JOIN residenciales r ON c.idResidencial=r.idResidencial
        /*INNER JOIN clientes cl ON cl.id_cliente = l.idCliente */
        WHERE pc.id_pc = ".$id_corrida);
        return $query->row();
    }

    function getAllLotesY($idCondominio){
        $query = $this->db->query("SELECT lo.idLote, lo.nombreLote, lo.total, lo.sup FROM lotes lo
			LEFT JOIN clientes cl ON cl.idLote = lo.idLote AND cl.id_cliente = lo.idCliente 
			WHERE lo.idCondominio IN (".$idCondominio.")");
        return $query->result();
    }
    public function getLotesInfoY($lote)
    {
            $query = $this->db->query("SELECT lot.idLote, nombreLote, total, sup, precio, porcentaje, enganche, con.msni, 
            descSup1, descSup2, referencia, db.banco, db.cuenta, db.empresa, db.clabe, lot.casa, (
            CASE lot.casa
            WHEN 0 THEN ''
            WHEN 1 THEN  casas.casasDetail
            END) casasDetail, idStatusLote, cl.fechaApartado, cl.id_cliente, CONCAT(cl.nombre,'', cl.apellido_paterno,' ', cl.apellido_materno) as nombre_cliente
                                    FROM lotes lot LEFT JOIN condominios con ON lot.idCondominio = con.idCondominio LEFT JOIN residenciales res 
                                    ON con.idResidencial = res.idResidencial LEFT JOIN datosbancarios db ON con.idDBanco = db.idDBanco 
                                    LEFT JOIN (SELECT id_lote, CONCAT( '{''total_terreno'':''', total_terreno, ''',', tipo_casa, '}') casasDetail 
            						FROM casas WHERE estatus = 1) casas ON casas.id_lote = lot.idLote
                                    LEFT JOIN clientes cl ON lot.idLote = cl.idLote AND cl.status=1
                                    WHERE lot.idLote = ".$lote ) ; /*1: original*/
        if ($query) {
            $query = $query->result_array();
            return $query;
        }
    }

    public function getGerenteByID($id_gerente){
            $query = $this->db-> query("SELECT u.id_rol, u.estatus, u.id_usuario idGerente, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreGerente 
                                FROM usuarios u WHERE u.id_usuario=".$id_gerente." ORDER BY nombreGerente");
            //u.id_rol = 3 AND
            return $query->result_array();

    }
    public function getCoordinadorByID($coordinador){
        $query = $this->db->query("SELECT u.id_lider, u.id_rol, u.estatus, u.id_usuario idCoordinador, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreCoordinador 
                                FROM usuarios u WHERE u.estatus = 1 AND u.id_usuario = ".$coordinador."
                                UNION ALL
                                SELECT u.id_lider, u.id_rol, u.estatus, u.id_usuario idCoordinador, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreCoordinador 
                                FROM usuarios u WHERE u.estatus = 1 AND u.id_usuario = ".$coordinador." ORDER BY nombreCoordinador");
        //u.id_rol = 9 AND
        // u.id_rol = 3 AND
        return $query->result_array();
    }
    public function getAsesorByID($asesor){
        $query = $this->db->query("SELECT u.id_lider, u.id_rol, u.estatus, u.id_usuario idAsesor, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreAsesor 
								FROM usuarios u WHERE u.estatus = 1 AND u.id_usuario = ".$asesor." ORDER BY nombreAsesor");
        //u.id_rol = 7 AND
        // u.id_rol = 9 AND
        //u.id_rol = 3 AND
        return $query->result_array();
    }

    function getDataAsesorToPR($id_asesor){
        //SELECT u.id_usuario idAsesor, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreAsesor, uu.id_usuario idCoordinador,
        //CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) nombreCoordinador, uuu.id_usuario idGerente, CONCAT(uuu.nombre, ' ', uuu.apellido_paterno, ' ', uuu.apellido_materno) nombreGerente
        // FROM [usuarios] u INNER JOIN [usuarios] uu ON uu.id_usuario = u.id_lider
        //INNER JOIN [usuarios] uuu ON uuu.id_usuario = uu.id_lider WHERE u.id_rol = 7 AND u.estatus = 1 AND u.id_usuario = ".$id_asesor." AND uuu.id_usuario
            $query=$this->db->query("SELECT id_usuario as idAsesor,  
            CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreAsesor
            FROM usuarios u WHERE id_usuario=".$id_asesor);
            return $query->row();
    }

    function getDataCoordToPR($id_coordinador){
//SELECT u.id_usuario idAsesor, uu.id_usuario idCoordinador,
//		                           CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreAsesor,
//                                   CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) nombreGerente
//                                   FROM [usuarios] u
//								   INNER JOIN [usuarios] uu ON uu.id_usuario = u.id_lider
//								   WHERE u.id_rol = 9 AND u.estatus = 1 AND u.id_usuario = ".$id_asesor." AND uu.id_usuario =  ".$id_gerente.""
        $query=$this->db->query("SELECT id_usuario as idCoordinador,  
            CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreCoordinador
            FROM usuarios u WHERE id_usuario=".$id_coordinador);
        return $query->row();
    }
    function getDataGerToPR($id_gerente){
        //"SELECT u.id_usuario idAsesor, uu.id_usuario idCoordinador,
        //		                           CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreAsesor,
        //                                   CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreGerente
        //                                   FROM [usuarios] u
        //								   INNER JOIN [usuarios] uu ON uu.id_usuario = u.id_lider
        //								   WHERE u.id_rol = 3 AND u.estatus = 1 AND u.id_usuario =
        $query=$this->db->query("SELECT id_usuario as idGerente,  
            CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreGerente
            FROM usuarios u WHERE id_usuario=".$id_gerente);
        return $query->row();
    }

    function revisaFIFCDOC($idLote, $idCliente){//revisa si ya existe la rama en caso de que ya hayan guardado anteriormente para la
                            //autorizacion de la fecha de inicio
        $query = $this->db->query("SELECT * FROM historial_documento WHERE idCliente=".$idCliente." AND idLote=".$idLote." AND tipo_doc=31");
        return $query->result_array();
    }


}