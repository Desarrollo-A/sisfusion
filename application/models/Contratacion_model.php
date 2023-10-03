<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contratacion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

   function get_proyecto_lista($WHERE = NULL) {
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
      WHERE status = 1
      $WHERE");
   }
   
   function get_condominio_lista($proyecto) {
      return $this->db->query("SELECT * FROM condominios WHERE status = 1 AND idResidencial IN($proyecto) ORDER BY nombre");
   }

   function get_estatus_lote() {
      return $this->db->query("SELECT idStatusLote, UPPER(nombre) nombre FROM [statuslote]");
   }

     function get_datos_lote_exp($lote){
         return $this->db->query("SELECT cli.id_cliente, cli.nombre, cli.apellido_paterno, cli.apellido_materno, cli.idLote, lot.nombreLote, con.nombre as condominio, res.nombreResidencial,  
                                lot.contratoArchivo FROM clientes cli 
                                INNER JOIN lotes lot ON lot.idLote = cli.idLote 
                                INNER JOIN condominios con ON con.idCondominio = lot.idCondominio 
                                INNER JOIN residenciales res ON res.idResidencial = con.idResidencial WHERE cli.status = 1 AND cliente.idLote = ".$lote."");
     }

     function get_lote_lista($condominio){
        return $this->db->query("SELECT * FROM lotes WHERE status = 1 AND idCondominio =  ".$condominio." AND idCliente in (SELECT idCliente FROM clientes ) AND (idCliente <> 0 AND idCliente <>'')");
     }
     
     function get_datos_lote_pagos($lote){
         return $this->db->query("SELECT cli.id_cliente, cli.nombre, cli.apellido_paterno, cli.apellido_materno, cli.idLote, lot.nombreLote, con.nombre as condominio, 
                                res.nombreResidencia,  lot.contratoArchivo FROM clientes cli 
                                INNER JOIN lotes lot ON lot.idLote = cli.idLote 
                                INNER JOIN condominios con ON con.idCondominio = lot.idCondominio 
                                INNER JOIN residenciales res ON res.idResidencial = con.idResidencial WHERE cli.status = 1 AND cliente.idLote = ".$lote."");
     }

     public function getProspectingPlaceDetail() {
      $id_rol = $this->session->userdata('id_rol');
      if ($id_rol == 19 || $id_rol == 63)
         $lpReturn = "CONCAT(REPLACE(ISNULL(oxc.nombre, 'Sin especificar'), ' (especificar)', ''), (CASE pr.source WHEN '0' THEN '' ELSE CONCAT(' - ', pr.source) END))";
      else
         $lpReturn = "ISNULL(oxc.nombre, 'Sin especificar')";
      
      return $lpReturn;
   }

   function getInventarioData($estatus, $condominio, $proyecto,  $sede_residencial) {
      $prospectingPlaceDetail = $this->getProspectingPlaceDetail();
      $filtroProyecto = "";
      $filtroCondominio = "";
      $filtroEstatus = "";
      $filtroSederesidencial = '';
      if ($proyecto != 0)
         $filtroProyecto = "AND res.idResidencial = $proyecto";
      if ($condominio != 0)
         $filtroCondominio = "AND con.idCondominio = $condominio";
      if ($estatus != 0)
            $filtroEstatus = "AND lot.idStatusLote = $estatus";  
      if ($sede_residencial != 0)
      $filtroSederesidencial = "AND res.sede_residencial = $sede_residencial";      

      $query = $this->db->query("SELECT  lot.idLote, lot.nombreLote, con.nombre as nombreCondominio, res.nombreResidencial, lot.idStatusLote, con.idCondominio, CONVERT(varchar, CONVERT(money, lot.sup), 1) as superficie, lot.sup, lot.totalNeto2,
      lot.total, lot.referencia, ISNULL(lot.comentario, 'SIN ESPECIFICAR') comentario, lot.comentarioLiberacion, lot.observacionLiberacion, 
      CASE WHEN lot.casa = 1 THEN CONCAT(sl.nombre, ' casa') ELSE sl.nombre end as descripcion_estatus, sl.color, tv.tipo_venta, lot.msi as msni,
      CASE WHEN u0.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) END asesor,
      CASE WHEN u1.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) END coordinador,
      CASE WHEN u2.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) END gerente,
      CASE WHEN u3.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) END subdirector,
      CASE WHEN u4.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) END regional,
      CASE WHEN u5.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u5.nombre, ' ', u5.apellido_paterno, ' ', u5.apellido_materno)) END regional2,
      CASE WHEN u00.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u00.nombre, ' ', u00.apellido_paterno, ' ', u00.apellido_materno)) END asesor2,
      CASE WHEN u11.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u11.nombre, ' ', u11.apellido_paterno, ' ', u11.apellido_materno)) END coordinador2,
      CASE WHEN lot.idAsesor = 832 THEN UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) ELSE CASE u11.id_rol WHEN 3 THEN CASE WHEN u11.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u11.nombre, ' ', u11.apellido_paterno, ' ', u11.apellido_materno)) END ELSE CASE WHEN u22.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u22.nombre, ' ', u22.apellido_paterno, ' ', u22.apellido_materno)) END END END gerente2, 
      CASE u11.id_rol WHEN 3 THEN CASE WHEN u22.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u22.nombre, ' ', u22.apellido_paterno, ' ', u22.apellido_materno)) END ELSE CASE WHEN u33.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u33.nombre, ' ', u33.apellido_paterno, ' ', u33.apellido_materno)) END END subdirector2, 
      CASE u11.id_rol WHEN 3 THEN CASE WHEN u33.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u33.nombre, ' ', u33.apellido_paterno, ' ', u33.apellido_materno)) END ELSE CASE WHEN u44.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u44.nombre, ' ', u44.apellido_paterno, ' ', u44.apellido_materno)) END END regional22,
      lot.precio, ISNULL(CONVERT(varchar, lot.fecha_modst, 20), '') fecha_modst,  ISNULL(CONVERT(varchar, cl.fechaApartado, 20), '') AS fechaApartado, ISNULL (cl.apartadoXReubicacion, 0) AS apartadoXReubicacion, ISNULL(CONVERT(varchar, cl.fechaAlta, 21), '') AS fechaAlta, lot.observacionContratoUrgente,
      CASE WHEN cl.id_cliente IS NULL THEN 'SIN ESPECIFICAR' ELSE CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno) END as nombreCliente, lot.motivo_change_status,
      UPPER($prospectingPlaceDetail) AS lugar_prospeccion, 
      lot.fecha_creacion, lot.totalValidado as cantidad_enganche, ISNULL(CONVERT(varchar, fechaSolicitudValidacion, 20), '') as fecha_validacion,
      lot.idStatusContratacion, ISNULL(co.nombreCopropietario, 'SIN ESPECIFICAR') nombreCopropietario,
      sl.background_sl, ISNULL(cl.tipo_casa, 0) tipo_casa, ISNULL(oxc2.nombre, 'SIN ESPECIFICAR') nombre_tipo_casa, lot.casa,
      sed.nombre as ubicacion, ISNULL(ca.comAdmon, 'SIN ESPECIFICAR') comentario_administracion, ISNULL(vc.total, 0) venta_compartida, ISNULL(sc.nombreStatus, 'SIN ESPECIFICAR') statusContratacion
      FROM lotes lot
      INNER JOIN condominios con ON con.idCondominio = lot.idCondominio $filtroCondominio
      INNER JOIN residenciales res ON res.idResidencial = con.idResidencial $filtroProyecto $filtroSederesidencial
      INNER JOIN statuslote sl ON sl.idStatusLote = lot.idStatusLote 
      LEFT JOIN tipo_venta tv ON tv.id_tventa = lot.tipo_venta 
      LEFT JOIN clientes cl ON cl.id_cliente = lot.idCliente 
      LEFT JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
      LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
      LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
      LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
      LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
      LEFT JOIN usuarios u5 ON u5.id_usuario = cl.id_regional_2
      LEFT JOIN usuarios u00 ON u00.id_usuario = lot.idAsesor
      LEFT JOIN usuarios u11 ON u11.id_usuario = u00.id_lider -- COORDINADOR
      LEFT JOIN usuarios u22 ON u22.id_usuario = u11.id_lider -- GERENTE
      LEFT JOIN usuarios u33 ON u33.id_usuario = u22.id_lider -- SUBDIRECTOR
      LEFT JOIN usuarios u44 ON u44.id_usuario = u33.id_lider -- REGIONAL
      LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = cl.lugar_prospeccion AND oxc.id_catalogo = 9
      LEFT JOIN prospectos pr ON pr.id_prospecto = cl.id_prospecto
      LEFT JOIN (SELECT id_cliente, estatus, STRING_AGG(CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno), ' - ') nombreCopropietario
      FROM copropietarios GROUP BY id_cliente, estatus) co ON co.id_cliente = cl.id_cliente AND co.estatus = 1
      LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = cl.tipo_casa AND oxc2.id_catalogo = 35
      LEFT JOIN sedes sed ON sed.id_sede = lot.ubicacion
      LEFT JOIN comentarios_administracion ca ON ca.nombreLote = lot.nombreLote
      LEFT JOIN (SELECT id_cliente, COUNT(*) total FROM ventas_compartidas WHERE estatus = 1 GROUP BY id_cliente) vc ON vc.id_cliente = cl.id_cliente
      LEFT JOIN statuscontratacion sc ON sc.idStatusContratacion = lot.idStatusContratacion
      WHERE lot.status = 1 $filtroEstatus
      ORDER BY lot.nombreLote");
      return $query->result_array();

   }

   function get_datos_historial($lote){
       return $this->db->query("SELECT nombreLote, idLiberacion, UPPER(observacionLiberacion) AS observacionLiberacion, precio, fechaLiberacion
              modificado, usuarios.nombre, status, idLote, UPPER(userLiberacion) AS userLiberacion,
              usuarios.apellido_paterno, usuarios.apellido_materno , comentarioLiberacion
                              FROM historial_liberacion 
                              INNER JOIN statuslote ON statuslote.idStatusLote = historial_liberacion.status 
                              LEFT JOIN usuarios ON usuarios.usuario = historial_liberacion.userLiberacion 
                              WHERE idLote = ".$lote." ORDER BY modificado");                       
   }

     function get_datos_proceso($lote){
         return $this->db->query("SELECT idHistorialLote, nombreLote, UPPER(statuslote.nombre) as stlt, comentario, UPPER(perfil) as perfil,
 modificado, usuarios.nombre, usuarios.apellido_paterno, usuarios.apellido_materno 
 FROM [historial_lotes] 
 INNER JOIN [statuslote] ON statuslote.idStatusLote = historial_lotes.idStatusContratacion 
 LEFT JOIN [usuarios] ON usuarios.usuario = historial_lotes.usuario 
 WHERE idLote = ".$lote." ORDER BY modificado");
     }

     function get_expedientesIngresados($datos)
	 {
		 $this->db->select("idHistorialLote, hd.nombreLote, hd.idStatusContratacion, hd.idMovimiento, hd.modificado, 
							hd.fechaVenc, lotes.idLote, cl.fechaApartado, cond.nombre as nombreCondominio,
							CAST(lotes.comentario AS varchar(MAX)) as comentario, res.nombreResidencial,
							hd.status, lotes.totalNeto, totalValidado, lotes.totalNeto2, 
							concat(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as asesor, 
							concat(ge.nombre, ' ', ge.apellido_paterno, ' ', ge.apellido_materno) as gerente ");

		 $this->db->join('clientes cl', 'hd.idCliente = cl.id_cliente', 'INNER');
		 $this->db->join('lotes lotes', 'hd.idLote = lotes.idLote', 'INNER');
		 $this->db->join('condominios cond', 'cond.idCondominio = lotes.idCondominio', 'INNER');
		 $this->db->join('residenciales res', 'cond.idResidencial = res.idResidencial', 'INNER');
		 $this->db->join('usuarios us', 'cl.id_asesor = us.id_usuario', 'INNER');
		 $this->db->join('usuarios ge', 'ge.id_usuario=us.id_lider', 'LEFT');
		 $this->db->where("hd.idStatusContratacion",$datos['idStatusContratacion']);
		 $this->db->where("hd.idMovimiento",$datos['idMovimiento']);
		 $this->db->where("hd.status",1);

		  $this->db->order_by(" hd.idLote, hd.idHistorialLote, hd.nombreLote, hd.idStatusContratacion, hd.idMovimiento, hd.modificado, 
						hd.fechaVenc, lotes.idLote, cl.fechaApartado, res.nombreResidencial,
						CAST(lotes.comentario AS varchar(MAX)), cond.nombre,
						hd.status, lotes.totalNeto, totalValidado, lotes.totalNeto2, 
						concat(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno), 
						concat(ge.nombre, ' ', ge.apellido_paterno, ' ', ge.apellido_materno)");
		 $query = $this->db->get('historial_lotes hd');
		 return $query->result();
	 }


   function getClient($idLote){
      return $this->db->query(
         "SELECT idLote, idCliente
          FROM lotes
          WHERE idLote = $idLote");
   }

   function getCoSallingAdvisers($id_cliente) {
      return $this->db-> query("SELECT id_cliente,
      CASE WHEN u0.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) END asesor,
      CASE WHEN u1.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) END coordinador,
      CASE WHEN u2.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) END gerente,
      CASE WHEN u3.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) END subdirector,
      CASE WHEN u4.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) END regional,
      CASE WHEN u5.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u5.nombre, ' ', u5.apellido_paterno, ' ', u5.apellido_materno)) END regional2,
      CONVERT(varchar, vc.fecha_creacion, 20) fecha_creacion, (CASE vc.creado_por WHEN '1297' THEN 'Control interno' ELSE vc.creado_por END) creado_por 
         FROM ventas_compartidas vc 
         LEFT JOIN usuarios u0 ON u0.id_usuario = vc.id_asesor
         LEFT JOIN usuarios u1 ON u1.id_usuario = vc.id_coordinador
         LEFT JOIN usuarios u2 ON u2.id_usuario = vc.id_gerente
         LEFT JOIN usuarios u3 ON u3.id_usuario = vc.id_subdirector
         LEFT JOIN usuarios u4 ON u4.id_usuario = vc.id_regional
         LEFT JOIN usuarios u5 ON u5.id_usuario = vc.id_regional_2
         WHERE vc.estatus IN (1, 2) AND vc.id_cliente = $id_cliente ORDER BY vc.id_cliente")->result_array();
   }

    function getClauses($lote){
         return $this->db->query("SELECT * FROM clausulas WHERE id_lote = $lote AND estatus = 1");                        
    }

    function getInventoryBylote($idLote){
      return $this->db->query("SELECT  lot.idLote, lot.nombreLote, con.nombre as nombreCondominio, res.nombreResidencial, lot.idStatusLote, con.idCondominio, lot.sup as superficie, 
      lot.total, lot.totalNeto2, lot.referencia, UPPER(CONVERT(VARCHAR,lot.comentario)) AS comentario, lot.comentarioLiberacion, lot.observacionLiberacion, 
      CASE WHEN lot.casa = 1 THEN CONCAT(sl.nombre, ' CASA') ELSE sl.nombre END as descripcion_estatus, sl.color, tv.tipo_venta, con.msni,
      CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
      CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
      CONCAT(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
      CONCAT(asesor2.nombre,' ', asesor2.apellido_paterno, ' ', asesor2.apellido_materno) as asesor2,
      CONCAT(asesor2.nombre,' ', asesor2.apellido_paterno, ' ', asesor2.apellido_materno) as coordinador2,
      CONCAT(coordinador2.nombre,' ', coordinador2.apellido_paterno, ' ', coordinador2.apellido_materno) as gerente2,
      lot.precio, ISNULL(CONVERT(varchar, lot.fecha_modst, 21), '') AS fecha_modst, ISNULL(CONVERT(varchar, cl.fechaApartado, 120), '') AS fechaApartado, lot.observacionContratoUrgente,
      CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno) as nombreCliente, lot.motivo_change_status,
      UPPER(CONCAT(REPLACE(ISNULL(oxc.nombre, 'Sin especificar'), ' (especificar)', ''), (CASE pr.source WHEN '0' THEN '' ELSE CONCAT(' - ', pr.source) END))) lugar_prospeccion, 
      lot.fecha_creacion
      FROM lotes lot
      INNER JOIN condominios con ON con.idCondominio = lot.idCondominio 
      INNER JOIN residenciales res ON res.idResidencial = con.idResidencial 
      INNER JOIN statuslote sl ON sl.idStatusLote = lot.idStatusLote 
      LEFT JOIN tipo_venta tv ON tv.id_tventa = lot.tipo_venta 
      LEFT JOIN clientes cl ON cl.id_cliente = lot.idCliente 
      LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
      LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
      LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario
      LEFT JOIN usuarios asesor2 ON lot.idAsesor = asesor2.id_usuario
      LEFT JOIN usuarios coordinador2 ON asesor2.id_lider = coordinador2.id_usuario
      LEFT JOIN usuarios gerente2 ON coordinador2.id_lider = gerente2.id_usuario
      LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = cl.lugar_prospeccion AND oxc.id_catalogo = 9
      LEFT JOIN prospectos pr ON pr.id_prospecto = cl.id_prospecto
      WHERE lot.status = 1 and lot.idLote = $idLote ORDER BY lot.idLote");
   }
   
   public function getCatalogosParaUltimoEstatus(){
      return $this->db->query("SELECT re.sede_residencial id, se.nombre, 1 tipo FROM residenciales re
      INNER JOIN sedes se ON se.id_sede = re.sede_residencial
      WHERE re.status = 1 GROUP BY re.sede_residencial, se.nombre
      UNION ALL
      SELECT re.idResidencial id,  UPPER(CAST(CONCAT(nombreResidencial, ' - ' ,re.descripcion ) as VARCHAR(75))) nombre, 2 tipo FROM residenciales re
      WHERE re.status = 1 AND re.sede_residencial = 2");
   }

   public function getSedesPorDesarrollos(){
      return $this->db->query("SELECT re.sede_residencial id_sede, se.nombre FROM residenciales re
      INNER JOIN sedes se ON se.id_sede = re.sede_residencial
      WHERE re.status = 1 GROUP BY re.sede_residencial, se.nombre");
   }

   function getInformationHistorialEstatus($id_parametro){
      return $this->db->query("SELECT au.id_auditoria, au.id_parametro, sl1.nombre valorAnterior, sl2.nombre valorNuevo,
      au.fecha_creacion,
      CASE WHEN au.creado_por = 'null' THEN 'SIN ESPECIFICAR' WHEN ISNUMERIC(au.creado_por) = 1 
      THEN UPPER(CONCAT(us.nombre, ' ', us.apellido_paterno,' ', us.apellido_materno)) ELSE au.creado_por END creado_por
      FROM auditoria au 
      INNER JOIN statuslote sl1 ON sl1.idStatusLote = au.anterior
      INNER JOIN statuslote sl2 ON sl2.idStatusLote = au.nuevo
      LEFT JOIN usuarios us ON us.id_usuario = TRY_CAST (au.creado_por AS INT)
      WHERE id_parametro = $id_parametro AND tabla = 'lotes' AND col_afect = 'idStatusLote' ORDER BY id_auditoria");
  }
     
}