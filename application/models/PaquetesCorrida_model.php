<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class PaquetesCorrida_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function getTipoDescuento()
    {
        return $this->db->query("SELECT * FROM condiciones WHERE estatus = 1")->result_array();
    }
    public  function get_lista_sedes(){
    return $this->db->query("SELECT * FROM sedes where id_sede in(1,2,3,4,5,6,9) ORDER BY nombre");
    }
    
    public function getResidencialesList($id_sede)
    {
        return $this->db->query("SELECT idResidencial, nombreResidencial, UPPER(CAST(descripcion AS VARCHAR(75))) descripcion, empresa FROM residenciales WHERE status = 1 and sede_residencial=$id_sede ORDER BY nombreResidencial ASC")->result_array();
    }
    public function getDescuentosPorTotal($id_condicion)
    {
        //Modificar
        return $this->db->query("SELECT de.inicio, de.fin, de.id_condicion,max(de.id_descuento) AS de.id_descuento, de.porcentaje 
        FROM descuentos de
        INNER JOIN condiciones co ON co.id_condicion = de.id_condicion
        WHERE de.id_condicion = $id_condicion AND de.inicio is null 
        group by de.inicio, de.fin, de.id_condicion, de.porcentaje 
        order by de.porcentaje");
    }
 
    public function UpdateLotes($desarrollos,$cadena_lotes,$query_superdicie,$query_tipo_lote,$usuario,$inicio,$fin){
        $this->db->query("UPDATE  l 
        set l.id_descuento = '$cadena_lotes',usuario='$usuario'
        from lotes l
        inner join condominios c on c.idCondominio=l.idCondominio 
        inner join residenciales r on r.idResidencial=c.idResidencial
        where r.idResidencial in($desarrollos)  and l.idStatusLote = 1 
        $query_superdicie
        $query_tipo_lote");
        $this->db->query("UPDATE  l 
        set l.id_descuento = '$cadena_lotes',usuario='$usuario'
        from lotes l
        inner join condominios c on c.idCondominio=l.idCondominio 
        inner join residenciales r on r.idResidencial=c.idResidencial
        inner join clientes cl on cl.id_cliente=l.idCliente
        where r.idResidencial in($desarrollos)  and l.idStatusLote = 3 
        and cl.fechaApartado >= $inicio and cl.fechaApartado <= $fin
        $query_superdicie
        $query_tipo_lote"); 
    }

    public function insertBatch($table, $data)
    {
      $row = $this->db->insert_batch($table, $data);
        if ($row === FALSE) { 
            return false;
        } else { 
            return true;
        }
    }

    public function getDescuentosYCondiciones($tipoCondicion = 0){
        $queryFinal = ''; $condiciones = '';

        if($tipoCondicion == 0)
            $condiciones = $this->db->query("SELECT * FROM condiciones WHERE estatus = 1")->result_array();
        else
            $condiciones = $this->db->query("SELECT * FROM condiciones WHERE estatus = 1 AND id_condicion = $tipoCondicion")->result_array();

        foreach ($condiciones as $index => $valor) {
            $id_condicion = $valor['id_condicion'];
            $queryFinal .= "SELECT c.descripcion, d.inicio, d.fin, d.id_condicion,
        MAX(d.id_descuento) AS id_descuento, d.porcentaje 
        FROM descuentos d
        INNER JOIN condiciones c ON c.id_condicion = d.id_condicion
            WHERE d.id_condicion = $id_condicion 
        AND d.inicio IS NULL
            GROUP BY c.descripcion, d.inicio, d.fin, d.id_condicion, d.porcentaje";
            if( ($index+1) != count($condiciones)) {
                $queryFinal .= " UNION ALL ";
            }
        }

        $data = $this->db->query("$queryFinal ORDER BY id_condicion, d.porcentaje")->result_array();
        $allArray = array();
        foreach ($condiciones as $indexC => $condicion) {
            $arrayXCondicion = array();
            foreach ($data as $indexD => $valor) {
                if( $condicion['id_condicion'] == $valor['id_condicion'])
                    $arrayXCondicion[] = $valor;
            }

            $allArray[] = array("condicion" => $condicion, "data" => $arrayXCondicion, );
        }

        return $allArray;
    }

    public function SaveNewDescuento($id_condicion,$descuento){
      $response =  $this->db->query("INSERT INTO descuentos VALUES(NULL,NULL,$id_condicion,$descuento,NULL)"); 

        if (! $response ) {
            return $finalAnswer = 0;
        } else {
            $finalAnswer = $this->db->query("SELECT IDENT_CURRENT('descuentos') as lastId")->result_array();
            return $finalAnswer;
        }
    }

    public function ValidarDescuento($id_condicion,$descuento)
    {
        return $this->db->query("SELECT c.descripcion,d.inicio,d.fin,d.id_condicion,max(d.id_descuento) AS id_descuento,d.porcentaje 
        FROM descuentos d
		INNER JOIN condiciones c on c.id_condicion=d.id_condicion
		AND d.id_condicion = $id_condicion 
        AND d.porcentaje=$descuento
		and d.inicio is null 
        group by c.descripcion,d.inicio,d.fin,d.id_condicion,d.porcentaje 
        order by d.porcentaje");
    }
 

public function getPaquetesByLotes($desarrollos,$query_superdicie,$query_tipo_lote,$superficie,$inicio,$fin){
    date_default_timezone_set('America/Mexico_City');
    $hoy2 = date('Y-m-d H:i:s');
    
    $cuari1 =  $this->db->query("SELECT DISTINCT(l.idCondominio) FROM lotes l
        INNER JOIN condominios c ON c.idCondominio = l.idCondominio 
        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
        WHERE r.idResidencial IN ($desarrollos)
        $query_superdicie
        $query_tipo_lote 
        GROUP BY l.idCondominio")->result_array();
        
    $imploded = array();
    foreach($cuari1 as $array) {
        $imploded[] = implode(',', $array);
    }
    
    $stack= array();
  
    for ($i=0; $i < sizeof($cuari1); $i++) {
        $arrCondominio= implode(",", $cuari1[$i]);
        $queryRes =  $this->db->query("DECLARE @condominio varchar(200), @tags VARCHAR(MAX); 
        SET @condominio = ($arrCondominio) 
      
        /*INICIO DEL PROCESO*/ 
        SET @tags = (SELECT STRING_AGG(CONVERT(VARCHAR(MAX),(id_descuento) ), ',') 
        FROM lotes l 
        INNER JOIN condominios c ON c.idCondominio = l.idCondominio 
        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial 
        WHERE c.idCondominio IN (@condominio)) 
      
        (SELECT 
        @condominio condominio, STRING_AGG(id_paquete, ',') paquetes, fecha_inicio, fecha_fin, 
        UPPER(CONCAT('PAQUETE ', DATENAME(MONTH, fecha_inicio), ' ', YEAR(fecha_inicio))) descripcion 
        FROM paquetes 
        WHERE id_paquete in (SELECT DISTINCT(value) FROM STRING_SPLIT(@tags, ',') WHERE RTRIM(value) <> '') 
        GROUP BY fecha_inicio, fecha_fin)");
        
        foreach ($queryRes->result() as  $valor) {
        array_push($stack, array('condominio' => $valor->condominio, 'paquetes' => $valor->paquetes, 'fecha_inicio' => $valor->fecha_inicio, 'fecha_fin' => $valor->fecha_fin, 'descripcion' => $valor->descripcion));
  
    }
  }
  $getPaquetesByName = $stack;
  
  $datosInsertar_x_condominio = array();
  for ($o=0; $o <count($getPaquetesByName) ; $o++) {
    $json = array();
    if(!empty($getPaquetesByName[$o]['paquetes'])){
        array_push($json,array( 
            "paquetes" => $getPaquetesByName[$o]['paquetes'],
            "tipo_superficie" => array("tipo" => $superficie,
            "sup1" => $inicio,
            "sup2" => $fin) ));
            
            $json = json_encode($json);
            $json = ltrim($json,'[');
            $json = rtrim($json,']');
            
            $array_x_condominio =array(
                'id_condominio' => $getPaquetesByName[$o]['condominio'],
                'id_paquete' => $json,
                'nombre' => $getPaquetesByName[$o]['descripcion'],
                'fecha_inicio' =>  $getPaquetesByName[$o]['fecha_inicio'],
                'fecha_fin' =>  $getPaquetesByName[$o]['fecha_fin'],
                'estatus' => 1,
                'creado_por' => $this->session->userdata('id_usuario'),
                'fecha_modificacion' =>  $hoy2,
                'modificado_por' => $this->session->userdata('id_usuario'),
                'list_paquete' => $getPaquetesByName[$o]['paquetes']);
                
                array_push($datosInsertar_x_condominio,$array_x_condominio);
            }
        }
        if(count($datosInsertar_x_condominio) > 0){
            $this->PaquetesCorrida_model->insertBatch('paquetes_x_condominios',$datosInsertar_x_condominio);
        }
    }
   
    public function getPaquetes($query_tipo_lote,$query_superdicie,$desarrollos, $fechaInicio, $fechaFin){
        return  $this->db->query("SELECT STRING_AGG(t.descuentos, ',') id_paquete FROM (
        SELECT DISTINCT(id_descuento) descuentos
        FROM lotes l
        INNER JOIN condominios c ON c.idCondominio = l.idCondominio 
        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
        where l.idStatusLote = 1 AND r.idResidencial IN ($desarrollos) AND id_descuento IS NOT NULL
        $query_superdicie
        $query_tipo_lote
        UNION 
        SELECT DISTINCT(id_descuento) id_paquete
        FROM lotes l
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente AND cl.status = 1 AND cl.fechaApartado BETWEEN '$fechaInicio 00:00:00.000' AND '$fechaFin 23:59:59.999'
        INNER JOIN condominios c ON c.idCondominio = l.idCondominio 
        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
        where l.idStatusLote = 3 AND r.idResidencial IN ($desarrollos) AND id_descuento IS NOT NULL
        $query_superdicie
        $query_tipo_lote
        ) t")->result_array();
    }

    public function getPaquetesById($id_paquete){
        return  $this->db->query("SELECT * FROM paquetes WHERE id_paquete in($id_paquete)")->result_array();
    } 

    public function getDescuentosByPlan($id_paquete){
        return  $this->db->query("SELECT r.*,d.*,c.descripcion FROM relaciones r 
        INNER JOIN descuentos d ON d.id_descuento=r.id_descuento
        INNER JOIN condiciones c ON c.id_condicion = d.id_condicion
        WHERE r.id_paquete IN ($id_paquete) ORDER BY r.id_paquete, r.prioridad ASC")->result_array();
    }
    

    public function getPaquetesDisponiblesyApart($query_tipo_lote,$query_superdicie,$desarrollos, $fechaInicio, $fechaFin){
            $paquetes =  $this->db->query("SELECT STRING_AGG(t.descuentos, ',') id_descuento FROM (
                SELECT DISTINCT(id_descuento) descuentos
                FROM lotes l
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio 
                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                where l.idStatusLote = 1 AND r.idResidencial IN ($desarrollos) AND id_descuento IS NOT NULL
                $query_superdicie
                $query_tipo_lote
                ) t")->result_array();
                if(count($paquetes) == 0){
                    $paquetes =  $this->db->query("SELECT STRING_AGG(t.descuentos, ',') id_descuento FROM (
                        SELECT DISTINCT(id_descuento) descuentos
                        FROM lotes l
                        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente AND cl.status = 1 AND cl.fechaApartado BETWEEN '$fechaInicio 00:00:00.000' AND '$fechaFin 23:59:59.999'
                        INNER JOIN condominios c ON c.idCondominio = l.idCondominio 
                        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                        where l.idStatusLote = 3 AND r.idResidencial IN ($desarrollos) AND id_descuento IS NOT NULL
                        $query_superdicie
                        $query_tipo_lote
                        ) t")->result_array();
                }
            return $paquetes;
    }
    public function getAutorizaciones($id_rol,$opcion = 1,$anio = '',$estatus = ''){
        $estatusWhere1 = $opcion == 2 ? ($estatus == 0 ? 'YEAR(aut.fecha_creacion) = '.$anio : 'aut.estatus_autorizacion in('.$estatus.') AND YEAR(aut.fecha_creacion) = '.$anio) : '' ;
        $estatusWhere2 = $opcion == 1 ? ($id_rol == 17 ? ' aut.estatus_autorizacion in(2,3,4)' : ' aut.estatus_autorizacion in(1,3,4)') : '';
        return $this->db->query("SELECT aut.*,sd.nombre as sede,STRING_AGG((CONVERT(VARCHAR(MAX), RE.descripcion)), ',') nombreResidencial,
        (CASE WHEN opc.id_opcion = 1 THEN 'Comercial' WHEN opc.id_opcion = 0 THEN 'Habitacional' ELSE 'Ambos' END) tipoLote,
        opc2.nombre as estatusA,CONCAT(us.nombre, ' ',us.apellido_paterno, ' ', us.apellido_materno) creadoPor,
        (CASE WHEN aut.estatus_autorizacion=1 THEN 'lbl-sky' WHEN aut.estatus_autorizacion=2 THEN 'lbl-yellow' WHEN aut.estatus_autorizacion=3 THEN 'lbl-green' WHEN aut.estatus_autorizacion=4 THEN 'lbl-warning' ELSE 'lbl-gray' END) colorEstatus,
        (CASE WHEN aut.superficie=1 THEN 'Menor a 200' WHEN aut.superficie=2 THEN 'Mayor a 200' WHEN aut.superficie=3 THEN 'Cualquiera' ELSE '' END) tipoSuperficie
        FROM autorizaciones_pventas aut
        INNER JOIN sedes sd ON sd.id_sede=aut.id_sede
        LEFT JOIN opcs_x_cats opc ON opc.id_opcion=aut.tipo_lote AND opc.id_catalogo=27
        INNER JOIN usuarios us ON us.id_usuario=aut.creado_por
        INNER JOIN opcs_x_cats opc2 ON  opc2.id_opcion=aut.estatus_autorizacion AND opc2.id_catalogo=90
		LEFT JOIN
        (SELECT value, id_autorizacion FROM autorizaciones_pventas A0
         CROSS APPLY STRING_SPLIT(A0.idResidencial, ',') 
         GROUP BY id_autorizacion, value) A2 ON A2.id_autorizacion = aut.id_autorizacion
         LEFT JOIN residenciales RE ON RE.idResidencial IN (CAST(A2.value AS INT))
        WHERE $estatusWhere1 $estatusWhere2
        GROUP BY aut.id_autorizacion, aut.idResidencial,aut.fecha_inicio,aut.fecha_fin,aut.id_sede,aut.tipo_lote,aut.superficie,aut.paquetes,aut.estatus,aut.fecha_creacion,aut.modificado_por,
         opc.id_opcion,opc2.nombre,CONCAT(us.nombre, ' ',us.apellido_paterno, ' ', us.apellido_materno),aut.estatus_autorizacion,aut.creado_por,aut.fecha_modificacion,sd.nombre")->result_array();
    }
    public function saveAutorizacion($datos){
        $idResidencial = $datos['idResidencial'];
        $fecha_inicio = $datos['fecha_inicio'];
        $fecha_fin = $datos['fecha_fin'];
        $id_sede = $datos['id_sede'];
        $tipo_lote = $datos['tipo_lote'];
        $superficie = $datos['superficie'];
        $paquetes = $datos['paquetes'];
        $estatus_autorizacion = $datos['estatus_autorizacion'];
        $estatus = $datos['estatus'];
        $fecha_creacion = $datos['fecha_creacion'];
        $creado_por = $datos['creado_por'];
        $fecha_modificacion = $datos['fecha_modificacion'];
        $modificado_por = $datos['modificado_por'];

        $comentario = $datos['accion'] == 1 ? 'Agregó una nueva autorización' : 'Actualizó la autorización de planes';
        if($datos['accion'] == 1){
            $this->db->query("INSERT INTO autorizaciones_pventas 
            VALUES('$idResidencial','$fecha_inicio','$fecha_fin',$id_sede,$tipo_lote,$superficie,'$paquetes',$estatus_autorizacion,$estatus,'$fecha_creacion',$creado_por,'$fecha_modificacion',$modificado_por)");
            $id_autorizacion = $this->db->insert_id();
        }else{
            $id_autorizacion = $datos['idAutorizacion'];
            $this->db->query("UPDATE autorizaciones_pventas SET 
            idResidencial='$idResidencial',fecha_inicio='$fecha_inicio',fecha_fin='$fecha_fin',id_sede=$id_sede,tipo_lote=$tipo_lote,superficie=$superficie,paquetes='$paquetes',fecha_modificacion='$fecha_modificacion',modificado_por=$modificado_por WHERE id_autorizacion=$id_autorizacion");            
        }


        $this->db->query("INSERT INTO historial_autorizacionesPMSI(idAutorizacion,tipo,id_usuario,fecha_movimiento,estatus,comentario) values($id_autorizacion,1,$creado_por ,'$fecha_creacion',1,'$comentario')");
    
    }
    public function avanceAutorizacion($id_autorizacion,$estatus,$tipo,$comentario,$sesionado){
            $this->db->trans_begin();
            date_default_timezone_set('America/Mexico_City');
            $hoy2 = date('Y-m-d H:i:s');
            $datosAvance =  $this->db->query("SELECT * FROM avanceAutorizacion a
            INNER JOIN autorizaciones_pventas pv ON pv.estatus_autorizacion=a.estatus
            WHERE a.estatus=$estatus AND a.tipo=$tipo AND pv.id_autorizacion=$id_autorizacion")->result_array();
            $siguienteEstatus = $datosAvance[0]['estatus_siguiente'];

            $comentario = $comentario == 0 ? $datosAvance[0]['comentario'] : $comentario;
            $estatusRegistro = $tipo == 1 ? 1 : 2;
                if($siguienteEstatus == 3){
                    $query_tipo_lote = $datosAvance[0]['tipo_lote'] == 2 ? '' : 'AND c.tipo_lote='.$datosAvance[0]['tipo_lote'];
                    $query_superdicie = $datosAvance[0]['superficie'] == 2 ? '' :($datosAvance[0]['superficie'] == 1 ? 'AND sup < 200' : 'AND sup >= 200');
                    $this->UpdateLotes($datosAvance[0]['idResidencial'],$datosAvance[0]['paquetes'],$query_superdicie,$query_tipo_lote,$sesionado,$datosAvance[0]['fecha_inicio'],$datosAvance[0]['fecha_fin']);
                }
            $this->db->query("UPDATE autorizaciones_pventas SET estatus_autorizacion=$siguienteEstatus,modificado_por=$sesionado WHERE id_autorizacion=$id_autorizacion"); 
            $this->db->query("INSERT INTO historial_autorizacionesPMSI(idAutorizacion,tipo,id_usuario,fecha_movimiento,estatus,comentario) values($id_autorizacion,1,$sesionado,'$hoy2',$estatusRegistro,'$comentario')");
                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    return 0;
                } else {
                    $this->db->trans_commit();
                    return array("respuesta" => $datosAvance[0]['comentario'],
                                  "estatus" => 1);
                }
    }

    public function getHistorialAutorizacion($id_autorizacion){
        return $this->db->query("SELECT ha.*,CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) creadoPor 
        FROM historial_autorizacionesPMSI ha
        INNER JOIN usuarios u ON u.id_usuario=ha.id_usuario
        WHERE idAutorizacion=$id_autorizacion AND tipo=1 
        ORDER BY fecha_movimiento DESC")->result_array();
    }
    public function getCatalogo($id_catalogo){ 
        return $this->db->query("SELECT * FROM opcs_x_cats WHERE id_catalogo=$id_catalogo")->result_array();
    }
}
