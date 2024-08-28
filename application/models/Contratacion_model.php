<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contratacion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

   function get_proyecto_lista() {
      return $this->db->query("SELECT idResidencial, UPPER(CONCAT(nombreResidencial, ' - '  ,descripcion)) descripcion,ciudad, status, empresa, clave_residencial, abreviatura, active_comission, sede_residencial, sede FROM residenciales WHERE status = 1");
   }
   
   function get_condominio_lista($proyecto) {
      return $this->db->query("SELECT * FROM condominios WHERE status = 1 AND idResidencial IN($proyecto) ORDER BY nombre");
   }

   function get_estatus_lote() {
      $where = !in_array($this->session->userdata('id_rol'), array(17, 70, 71, 73, 11, 15, 33, 78)) ? "WHERE idStatusLote NOT IN (15, 16, 17, 18, 19, 20, 21)" : "";
      return $this->db->query("SELECT idStatusLote, UPPER(nombre) nombre FROM [statuslote] $where");
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


   function getInventarioData($estatus, $condominio, $proyecto) {
      $whereProceso = !in_array($this->session->userdata('id_rol'), array(17, 70, 71, 73, 11, 15, 33, 78)) ? "AND ISNULL(cl.proceso, 0) NOT IN (2, 3, 4, 5, 6, 7) AND lot.idStatusLote NOT IN (15, 16, 17, 18, 19, 20, 21)" : ($this->session->userdata('id_rol') == 40 ? "AND lot.idStatusLote NOT IN (15, 16, 17, 20, 21)" : "");
      $prospectingPlaceDetail = $this->getProspectingPlaceDetail();
      $filtroProyecto = "";
      $filtroCondominio = "";
      $filtroEstatus = "";
      $filtroEstatusLote = "";
      $unionCliente = "LEFT";
      $ventasCompartidasQuery = "";

      $filtroClientesPropios = "";
      $id_usuario = $this->session->userdata('id_usuario');
      $id_rol = $this->session->userdata('id_rol');
      $id_lider = $this->session->userdata('id_lider');

      if ($proyecto != 0)
          $filtroProyecto = "AND res.idResidencial = $proyecto";
      if ($condominio != 0)
          $filtroCondominio = "AND con.idCondominio = $condominio";
      if ($estatus != 0)
         $filtroEstatus = "AND lot.idStatusLote = $estatus";

      $idsGerente = $this->getIdsGerente($id_lider, $id_usuario);

      if (in_array($id_rol, [7, 9, 3])) // LO CONSULTA UN USUARIO TIPO ASESOR, COORDINADOR O GERENTE
         $filtroClientesPropios = "AND (cl.id_asesor = $id_usuario OR cl.id_coordinador = $id_usuario OR cl.id_gerente = $id_usuario)";
      else if (in_array($id_rol, [6])) // LO CONSULTA UN USUARIO TIPO ASISTNTE GERENTE
         $filtroClientesPropios = "AND (cl.id_gerente IN ($idsGerente))";
      else if (in_array($id_rol, [2])) // LO CONSULTA UN USUARIO TIPO SUBDIRECTOR
         $filtroClientesPropios = "AND (cl.id_asesor = $id_usuario OR cl.id_coordinador = $id_usuario OR cl.id_gerente = $id_usuario OR cl.id_subdirector = $id_usuario OR cl.id_regional = $id_usuario OR cl.id_regional_2 = $id_usuario)";
      else if (in_array($id_rol, [5])) // LO CONSULTA UN USUARIO TIPO ASISTENTE SUBDIRECTOR
         $filtroClientesPropios = "AND (cl.id_subdirector = $id_lider OR cl.id_regional = $id_lider OR cl.id_regional_2 = $id_lider)";

      if(in_array($this->session->userdata('id_rol'), array(1, 2, 3, 4, 5, 6, 7, 9))){
         $filtroEstatusLote = "AND lot.idStatusLote IN (2, 3)";
         $unionCliente = "INNER";
         $ventasCompartidasQuery = $this->getVentasCompartidasQuery($id_rol, $id_usuario, $id_lider, $prospectingPlaceDetail, $filtroProyecto, $filtroCondominio, $filtroEstatus, $idsGerente);
      }

      return $this->db->query("SELECT
         tbl.idLote, 
         tbl.nombreLote, 
         tbl.nombreCondominio, 
         tbl.nombreResidencial, 
         tbl.idStatusLote, 
         tbl.idCondominio, 
         tbl.superficie, 
         tbl.sup, 
         tbl.totalNeto2, 
         tbl.total, 
         tbl.referencia, 
         CAST(tbl.comentario AS varchar(255)), 
         tbl.comentarioLiberacion, 
         tbl.observacionLiberacion, 
         tbl.descripcion_estatus, 
         tbl.color, 
         tbl.tipo_venta, 
         tbl.msni, 
         tbl.asesor, 
         tbl.coordinador, 
         tbl.gerente, 
         tbl.subdirector, 
         tbl.regional, 
         tbl.regional2, 
         tbl.asesor2, tbl.coordinador2, tbl.gerente2, tbl.subdirector2, tbl.regional22, 
         tbl.precio, 
         tbl.fecha_modst, 
         tbl.fechaApartado, 
         tbl.apartadoXReubicacion, 
         tbl.fechaAlta, 
         tbl.observacionContratoUrgente, 
         tbl.nombreCliente, 
         tbl.motivo_change_status, 
         tbl.lugar_prospeccion, 
         tbl.fecha_creacion, 
         tbl.cantidad_enganche, 
         tbl.fecha_validacion, 
         tbl.idStatusContratacion, 
         tbl.nombreCopropietario, 
         tbl.background_sl, 
         tbl.tipo_casa, 
         tbl.nombre_tipo_casa, 
         tbl.casa, 
         tbl.ubicacion, 
         tbl.comentario_administracion, 
         tbl.venta_compartida, 
         tbl.statusContratacion, 
         tbl.tipo_proceso, 
         tbl.clave, 
         tbl.telefono1, 
         tbl.telefono2, 
         tbl.correo, 
         tbl.fecha_nacimiento, 
         tbl.nacionalidad, 
         tbl.originario_de, 
         tbl.estado_civil, 
         tbl.nombre_conyuge, 
         tbl.regimen_matrimonial, 
         tbl.domicilio_particular, 
         tbl.ocupacion, 
         tbl.empresa, 
         tbl.puesto, 
         tbl.antiguedad, 
         tbl.edad, 
         tbl.domicilio_empresa, 
         tbl.telefono_empresa, 
         tbl.tipo_vivienda, 
         tbl.costom2f, 
         tbl.municipio, 
         tbl.importOferta, 
         tbl.letraImport, 
         tbl.saldoDeposito, 
         tbl.aportMensualOfer, 
         tbl.fecha1erAport, 
         tbl.fechaLiquidaDepo, 
         tbl.fecha2daAport, 
         tbl.referenciasPersonales, 
         CAST(tbl.observacion AS varchar(255)), 
         tbl.personalidad_juridica, 
         tbl.idOficial_pf, 
         tbl.idDomicilio_pf, 
         tbl.actaMatrimonio_pf, 
         tbl.actaConstitutiva_pm, 
         tbl.poder_pm, 
         tbl.idOficialApoderado_pm, 
         tbl.idDomicilio_pm, 
         tbl.edadFirma, 
         tbl.sedeResidencial, 
         tbl.tipoEnganche, 
         tbl.nombre, 
         tbl.sedeCliente 
         FROM (
      SELECT lot.idLote, lot.nombreLote, con.nombre as nombreCondominio, res.nombreResidencial, lot.idStatusLote, con.idCondominio, CONVERT(varchar, CONVERT(money, lot.sup), 1) as superficie, lot.sup, lot.totalNeto2,
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
      sed.nombre as ubicacion, ISNULL(ca.comAdmon, 'SIN ESPECIFICAR') comentario_administracion, ISNULL(vc.total, 0) venta_compartida, ISNULL(sc.nombreStatus, 'SIN ESPECIFICAR') statusContratacion,
      ISNULL(oxc0.nombre, 'Normal') tipo_proceso 
      , ds.clave, cl.telefono1, cl.telefono2, cl.correo, cl.fecha_nacimiento, catNaci.nombre nacionalidad, cl.originario_de, catEdoCivil.nombre estado_civil,
      cl.nombre_conyuge, catRegMat.nombre regimen_matrimonial, cl.domicilio_particular, cl.ocupacion, cl.empresa, cl.puesto, cl.antiguedad, 
      cl.fecha_nacimiento as edad,
     cl.domicilio_empresa, cl.telefono_empresa, catalogoTipoViv.nombre tipo_vivienda, ds.costom2f, ds.municipio, ds.importOferta, ds.letraImport, ds.saldoDeposito, 
      ds.aportMensualOfer, ds.fecha1erAport, ds.fechaLiquidaDepo, ds.fecha2daAport, 
     ISNULL(ref.nombreReferencias, 'SIN ESPECIFICAR') as referenciasPersonales, 
      ds.observacion, cl.personalidad_juridica, ds.idOficial_pf, ds.idDomicilio_pf, ds.actaMatrimonio_pf, ds.actaConstitutiva_pm, ds.poder_pm, ds.idOficialApoderado_pm, ds.idDomicilio_pm,
      cl.edadFirma, sds.nombre as sedeResidencial, cl.tipoEnganche, loxc.nombre, ISNULL(sds2.nombre,'Sin especificar') sedeCliente
      FROM lotes lot
      INNER JOIN condominios con ON con.idCondominio = lot.idCondominio $filtroCondominio
      INNER JOIN residenciales res ON res.idResidencial = con.idResidencial $filtroProyecto
      INNER JOIN statuslote sl ON sl.idStatusLote = lot.idStatusLote 
      LEFT JOIN tipo_venta tv ON tv.id_tventa = lot.tipo_venta 
      $unionCliente JOIN clientes cl ON cl.id_cliente = lot.idCliente $filtroClientesPropios
      LEFT JOIN opcs_x_cats loxc ON loxc.id_opcion = cl.tipoEnganche AND id_catalogo = 147
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
      LEFT JOIN (SELECT nombreLote, STRING_AGG(CAST(comAdmon AS varchar(250)), ' | ') comAdmon FROM comentarios_administracion GROUP BY nombreLote) ca ON ca.nombreLote = lot.nombreLote
      LEFT JOIN (SELECT id_cliente, COUNT(*) total FROM ventas_compartidas WHERE estatus = 1 GROUP BY id_cliente) vc ON vc.id_cliente = cl.id_cliente
      LEFT JOIN statuscontratacion sc ON sc.idStatusContratacion = lot.idStatusContratacion
      LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
      --nuevo
      LEFT JOIN deposito_seriedad ds ON ds.id_cliente = cl.id_cliente
      LEFT JOIN (SELECT id_cliente, STRING_AGG(nombre, ', ') nombreReferencias FROM referencias WHERE estatus = 1 GROUP BY id_cliente) ref ON ref.id_cliente = cl.id_cliente
     LEFT JOIN opcs_x_cats catalogoTipoViv ON catalogoTipoViv.id_opcion = cl.tipo_vivienda AND catalogoTipoViv.id_catalogo = 20
     LEFT JOIN opcs_x_cats catRegMat ON catRegMat.id_opcion = cl.regimen_matrimonial AND catRegMat.id_catalogo = 19
     LEFT JOIN opcs_x_cats catEdoCivil ON catEdoCivil.id_opcion = cl.estado_civil AND catEdoCivil.id_catalogo = 18
     LEFT JOIN opcs_x_cats catNaci ON catNaci.id_opcion = cl.nacionalidad AND catNaci.id_catalogo = 11
     LEFT JOIN sedes sds ON sds.id_sede = res.sede_residencial
     LEFT JOIN sedes sds2 ON sds2.id_sede = cl.id_sede
      --nuevo 
      WHERE lot.status = 1 $filtroEstatusLote $filtroEstatus $whereProceso
      --ORDER BY lot.nombreLote
      $ventasCompartidasQuery
      ) tbl
         GROUP BY
         tbl.idLote, 
         tbl.nombreLote, 
         tbl.nombreCondominio, 
         tbl.nombreResidencial, 
         tbl.idStatusLote, 
         tbl.idCondominio, 
         tbl.superficie, 
         tbl.sup, 
         tbl.totalNeto2, 
         tbl.total, 
         tbl.referencia, 
         CAST(tbl.comentario AS varchar(255)), 
         tbl.comentarioLiberacion, 
         tbl.observacionLiberacion, 
         tbl.descripcion_estatus, 
         tbl.color, 
         tbl.tipo_venta, 
         tbl.msni, 
         tbl.asesor, 
         tbl.coordinador, 
         tbl.gerente, 
         tbl.subdirector, 
         tbl.regional, 
         tbl.regional2, 
         tbl.asesor2, tbl.coordinador2, tbl.gerente2, tbl.subdirector2, tbl.regional22, 
         tbl.precio, 
         tbl.fecha_modst, 
         tbl.fechaApartado, 
         tbl.apartadoXReubicacion, 
         tbl.fechaAlta, 
         tbl.observacionContratoUrgente, 
         tbl.nombreCliente, 
         tbl.motivo_change_status, 
         tbl.lugar_prospeccion, 
         tbl.fecha_creacion, 
         tbl.cantidad_enganche, 
         tbl.fecha_validacion, 
         tbl.idStatusContratacion, 
         tbl.nombreCopropietario, 
         tbl.background_sl, 
         tbl.tipo_casa, 
         tbl.nombre_tipo_casa, 
         tbl.casa, 
         tbl.ubicacion, 
         tbl.comentario_administracion, 
         tbl.venta_compartida, 
         tbl.statusContratacion, 
         tbl.tipo_proceso, 
         tbl.clave, 
         tbl.telefono1, 
         tbl.telefono2, 
         tbl.correo, 
         tbl.fecha_nacimiento, 
         tbl.nacionalidad, 
         tbl.originario_de, 
         tbl.estado_civil, 
         tbl.nombre_conyuge, 
         tbl.regimen_matrimonial, 
         tbl.domicilio_particular, 
         tbl.ocupacion, 
         tbl.empresa, 
         tbl.puesto, 
         tbl.antiguedad, 
         tbl.edad, 
         tbl.domicilio_empresa, 
         tbl.telefono_empresa, 
         tbl.tipo_vivienda, 
         tbl.costom2f, 
         tbl.municipio, 
         tbl.importOferta, 
         tbl.letraImport, 
         tbl.saldoDeposito, 
         tbl.aportMensualOfer, 
         tbl.fecha1erAport, 
         tbl.fechaLiquidaDepo, 
         tbl.fecha2daAport, 
         tbl.referenciasPersonales, 
         CAST(tbl.observacion AS varchar(255)), 
         tbl.personalidad_juridica, 
         tbl.idOficial_pf, 
         tbl.idDomicilio_pf, 
         tbl.actaMatrimonio_pf, 
         tbl.actaConstitutiva_pm, 
         tbl.poder_pm, 
         tbl.idOficialApoderado_pm, 
         tbl.idDomicilio_pm, 
         tbl.edadFirma, 
         tbl.sedeResidencial, 
         tbl.tipoEnganche, 
         tbl.nombre, 
         tbl.sedeCliente
      ORDER BY tbl.nombreLote
      ")->result_array();
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
        return $this->db->query("SELECT * FROM clausulas WHERE id_lote = $lote AND estatus = 1 ORDER BY id_clausula DESC");
    }

    function getInventoryBylote($idLote){
      $whereProceso = !in_array($this->session->userdata('id_rol'), array(17, 70, 71, 73, 11, 15, 33, 78)) ? "AND ISNULL(cl.proceso, 0) NOT IN (2, 3, 4, 5, 6, 7) AND ISNULL(lot.idStatusLote, 0) NOT IN (15, 16, 17, 18, 19, 20, 21)" : "";
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
      WHERE lot.status = 1 and lot.idLote = $idLote $whereProceso ORDER BY lot.idLote");
   }
   
   public function getCatalogosParaUltimoEstatus(){
      return $this->db->query("SELECT re.sede_residencial id, se.nombre, 1 tipo FROM residenciales re
      INNER JOIN sedes se ON se.id_sede = re.sede_residencial
      WHERE re.status = 1 GROUP BY re.sede_residencial, se.nombre
      UNION ALL
      SELECT re.idResidencial id,  UPPER(CAST(CONCAT(nombreResidencial, ' - ' ,re.descripcion ) as VARCHAR(75))) nombre, 2 tipo FROM residenciales re
      WHERE re.status = 1 AND re.sede_residencial = 2");
   }

   public function getCompleteInventory ($sede_residencial) {
      ini_set('max_execution_time', 900);
      set_time_limit(900);
      ini_set('memory_limit','2048M');
      $whereProceso = !in_array($this->session->userdata('id_rol'), array(17, 70, 71, 73, 11, 15, 33, 78)) ? "AND ISNULL(cl.proceso, 0) NOT IN (2, 3, 4, 5, 6, 7) AND ISNULL(lot.idStatusLote, 0) NOT IN (15, 16, 17, 18, 19, 20, 21)" : "";
      $prospectingPlaceDetail = $this->getProspectingPlaceDetail();
      return $this->db->query("SELECT lot.idLote, lot.nombreLote, con.nombre as nombreCondominio, lot.totalNeto2,
      res.nombreResidencial, lot.idStatusLote, con.idCondominio, lot.sup, 
      lot.total, lot.referencia, lot.comentario, lot.comentarioLiberacion, lot.observacionLiberacion,
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
      lot.precio, ISNULL(CONVERT(varchar, lot.fecha_modst, 20), '') fecha_modst, ISNULL(CONVERT(varchar, cl.fechaApartado, 20), '') fechaApartado, lot.observacionContratoUrgente,
      CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno) as nombreCliente,lot.motivo_change_status,
      UPPER($prospectingPlaceDetail) AS lugar_prospeccion, 
      ISNULL(CONVERT(varchar, lot.fecha_creacion, 20), '') fecha_creacion,sl.background_sl,
      lot.totalValidado as cantidad_enganche, ISNULL(CONVERT(varchar, fechaSolicitudValidacion, 20), '') fecha_validacion,
      cl.id_cliente_reubicacion, ISNULL(CONVERT(varchar, cl.fechaAlta, 20), '') fechaAlta, sc.nombreStatus as estatusContratacion,
      CONCAT(cl.nombre, ' ', cl.apellido_paterno,' ', cl.apellido_materno ) as nombreCliente,
      ISNULL(ca.comAdmon, 'SIN ESPECIFICAR') comentario_administracion, ISNULL(vc.total, 0) venta_compartida, sed.nombre as ubicacion,
      ISNULL(oxc0.nombre, 'Normal') tipo_proceso, ISNULL(co.nombreCopropietario, 'SIN ESPECIFICAR') nombreCopropietario,
      sds.nombre as sedeResidencial
      FROM lotes lot 
      INNER JOIN condominios con ON con.idCondominio = lot.idCondominio 
      INNER JOIN residenciales res ON res.idResidencial = con.idResidencial AND res.sede_residencial = $sede_residencial
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
      LEFT JOIN statusContratacion sc ON sc.idStatusContratacion = lot.idStatusContratacion 
      LEFT JOIN sedes sed ON sed.id_sede = lot.ubicacion
      LEFT JOIN (SELECT id_cliente, estatus, STRING_AGG(CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno), ' - ') nombreCopropietario
      FROM copropietarios GROUP BY id_cliente, estatus) co ON co.id_cliente = cl.id_cliente AND co.estatus = 1
      LEFT JOIN (SELECT nombreLote, STRING_AGG(CAST(comAdmon AS varchar(250)), ' | ') comAdmon FROM comentarios_administracion GROUP BY nombreLote) ca ON ca.nombreLote = lot.nombreLote
      LEFT JOIN (SELECT id_cliente, COUNT(*) total FROM ventas_compartidas WHERE estatus = 1 GROUP BY id_cliente) vc ON vc.id_cliente = cl.id_cliente
      LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
      INNER JOIN sedes sds ON sds.id_sede = res.sede_residencial
      WHERE lot.status = 1 $whereProceso ORDER BY con.nombre, lot.idLote");
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

   public function downloadCompleteInventory () {
      if (isset($_POST) && !empty($_POST)) {
         $data['data'] = $this->Contratacion_model->getCompleteInventory($this->input->post("id_sede"))->result_array();
         echo json_encode($data);
      }else
         echo json_encode(array());
   }

   public function getNombreTipo(){
      return $this->db->query("SELECT DISTINCT u.tipo, o.nombre AS nombre_tipo FROM usuarios u INNER JOIN opcs_x_cats o ON o.id_opcion = u.tipo WHERE o.id_catalogo = 124");
   }

   function getIdsGerente($id_lider, $id_usuario) {
      $idsGerente = "";
      if ($id_usuario == 13770) // ITAYETZI PAULINA CAMPOS GONZALEZ	
         $idsGerente = $id_lider . ", 21, 1545";
      else if ($id_usuario == 12318) // EMMA CECILIA MALDONADO RAMIREZ
         $idsGerente = $id_lider . ", 1916, 11196";
      else if ($id_usuario == 13418) // MARIA FERNANDA RUIZ PEDROZA
         $idsGerente = $id_lider . ", 5604";
      else if ($id_usuario == 12855) // ARIADNA ZORAIDA ALDANA ZAPATA
         $idsGerente = $id_lider . ", 455";
      else if ($id_usuario == 14649) // NOEMÍ DE LOS ANGELES CASTILLO CASTILLO
         $idsGerente = $id_lider . ", 12027, 13059, 2599, 609, 11680, 7435";
      else if ($id_usuario == 14952) // GUILLERMO HELI IZQUIERDO VIEYRA
         $idsGerente = $id_lider . ", 13295, 7970";
      else if ($id_usuario == 13348) // VIRIDIANA ZAMORA ORTIZ
         $idsGerente = $id_lider . ", 10063";
      else if ($id_usuario == 12576) // DIANA EVELYN PALENCIA AGUILAR
         $idsGerente = $id_lider . ", 6942";
      else if ($id_usuario == 12292) // REYNALDO HERNANDEZ SANCHEZ
         $idsGerente = $id_lider . ", 6661";
      else if ($id_usuario == 16214) // JESSICA PAOLA CORTEZ VALENZUELA
         $idsGerente = $id_lider . ", 80, 664, 16458, 2599";
      else if ($id_usuario == 15110) // IVONNE BRAVO VALDERRAMA
         $idsGerente = $id_lider . ", 12688";
      else if ($id_usuario == 15545) // PAMELA IVONNE LEE MORENO
         $idsGerente = $id_lider . ", 13059, 11680";
      else if ($id_usuario == 15109) // MARIBEL GUADALUPE RIOS DIAZ
         $idsGerente = $id_lider . ", 10251";
      else if ($id_usuario == 16186) // CAROLINA CORONADO YAÑEZ   
         $idsGerente = $id_lider . ", 6942";
      else if ($id_usuario == 13511) // DANYA YOALY LEYVA FLORIAN
         $idsGerente = $id_lider . ", 654, 697, 5604, 10251, 12688";
      else if ($id_usuario == 14556) // KATTYA GUADALUPE CADENA CRUZ
         $idsGerente = $id_lider . ", 24, 10";
      else if ($id_usuario == 14946) // MELANI BECERRIL FLORES
         $idsGerente = $id_lider . ", 7474";
      else if ($id_usuario == 16783) // Mayra Alejandra Angulo Muñiz
         $idsGerente = $id_lider . ", 13821";
      else if ($id_usuario == 16813) // Vanessa Castro Muñoz
         $idsGerente = $id_lider . ", 11843";
      else if ($id_usuario == 2987) // Alan Michell Alba Sánchez
         $idsGerente = $id_lider . ", 6661";
      else
         $idsGerente = $id_lider;
      return $idsGerente;
   }

   function getVentasCompartidasQuery($id_rol, $id_usuario, $id_lider, $prospectingPlaceDetail, $filtroProyecto, $filtroCondominio, $filtroEstatus, $idsGerente) {
      $filtroClientesPropios = "";
      if (in_array($id_rol, [7, 9, 3])) // LO CONSULTA UN USUARIO TIPO ASESOR, COORDINADOR O GERENTE
         $filtroClientesPropios = "AND (vcc.id_asesor = $id_usuario OR vcc.id_coordinador = $id_usuario OR vcc.id_gerente = $id_usuario)";
      else if (in_array($id_rol, [6])) // LO CONSULTA UN USUARIO TIPO ASISTNTE GERENTE
         $filtroClientesPropios = "AND (vcc.id_gerente IN ($idsGerente))";
      else if (in_array($id_rol, [2])) // LO CONSULTA UN USUARIO TIPO SUBDIRECTOR
         $filtroClientesPropios = "AND (vcc.id_subdirector = $id_usuario OR vcc.id_regional = $id_usuario OR vcc.id_regional_2 = $id_usuario)";
      else if (in_array($id_rol, [5])) // LO CONSULTA UN USUARIO TIPO ASISTENTE SUBDIRECTOR
         $filtroClientesPropios = "AND (vcc.id_subdirector = $id_lider OR vcc.id_regional = $id_lider OR vcc.id_regional_2 = $id_lider)";
      $consulta = "UNION ALL 
         SELECT 
            lot.idLote, 
            lot.nombreLote, 
            con.nombre as nombreCondominio, 
            res.nombreResidencial, 
            lot.idStatusLote, 
            con.idCondominio, 
            CONVERT(varchar, CONVERT(money, lot.sup), 1) as superficie, 
            lot.sup, 
            lot.totalNeto2, 
            lot.total, 
            lot.referencia, 
            ISNULL(lot.comentario, 'SIN ESPECIFICAR') comentario, 
            lot.comentarioLiberacion, 
            lot.observacionLiberacion, 
            CASE WHEN lot.casa = 1 THEN CONCAT(sl.nombre, ' casa') ELSE sl.nombre end as descripcion_estatus, 
            sl.color, 
            tv.tipo_venta, 
            lot.msi as msni, 
            CASE WHEN u0.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) END asesor, 
            CASE WHEN u1.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) END coordinador, 
            CASE WHEN u2.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) END gerente, 
            CASE WHEN u3.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) END subdirector, 
            CASE WHEN u4.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) END regional, 
            CASE WHEN u5.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u5.nombre, ' ', u5.apellido_paterno, ' ', u5.apellido_materno)) END regional2, 
            'SIN ESPECIFICAR' asesor2, 'SIN ESPECIFICAR' coordinador2, 'SIN ESPECIFICAR' gerente2, 'SIN ESPECIFICAR' subdirector2, 'SIN ESPECIFICAR' regional22, 
            lot.precio, 
            ISNULL(CONVERT(varchar, lot.fecha_modst, 20), '') fecha_modst, 
            ISNULL(CONVERT(varchar, cl.fechaApartado, 20), '') AS fechaApartado, 
            ISNULL (cl.apartadoXReubicacion, 0) AS apartadoXReubicacion, 
            ISNULL(CONVERT(varchar, cl.fechaAlta, 21), '') AS fechaAlta, 
            lot.observacionContratoUrgente, 
            CASE WHEN cl.id_cliente IS NULL THEN 'SIN ESPECIFICAR' ELSE CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) END as nombreCliente, 
            lot.motivo_change_status, 
            UPPER($prospectingPlaceDetail) AS lugar_prospeccion, 
            lot.fecha_creacion, 
            lot.totalValidado as cantidad_enganche, 
            ISNULL(CONVERT(varchar, fechaSolicitudValidacion, 20), '') as fecha_validacion, 
            lot.idStatusContratacion, 
            ISNULL(co.nombreCopropietario, 'SIN ESPECIFICAR') nombreCopropietario, 
            sl.background_sl, 
            ISNULL(cl.tipo_casa, 0) tipo_casa, 
            ISNULL(oxc2.nombre, 'SIN ESPECIFICAR') nombre_tipo_casa, 
            lot.casa, 
            sed.nombre as ubicacion, 
            ISNULL(ca.comAdmon, 'SIN ESPECIFICAR') comentario_administracion, 
            ISNULL(vc.total, 0) venta_compartida, 
            ISNULL(sc.nombreStatus, 'SIN ESPECIFICAR') statusContratacion, 
            ISNULL(oxc0.nombre, 'Normal') tipo_proceso, 
            ds.clave, 
            cl.telefono1, 
            cl.telefono2, 
            cl.correo, 
            cl.fecha_nacimiento, 
            catNaci.nombre nacionalidad, 
            cl.originario_de, 
            catEdoCivil.nombre estado_civil, 
            cl.nombre_conyuge, 
            catRegMat.nombre regimen_matrimonial, 
            cl.domicilio_particular, 
            cl.ocupacion, 
            cl.empresa, 
            cl.puesto, 
            cl.antiguedad, 
            cl.fecha_nacimiento as edad, 
            cl.domicilio_empresa, 
            cl.telefono_empresa, 
            catalogoTipoViv.nombre tipo_vivienda, 
            ds.costom2f, 
            ds.municipio, 
            ds.importOferta, 
            ds.letraImport, 
            ds.saldoDeposito, 
            ds.aportMensualOfer, 
            ds.fecha1erAport, 
            ds.fechaLiquidaDepo, 
            ds.fecha2daAport, 
            ISNULL(ref.nombreReferencias, 'SIN ESPECIFICAR') as referenciasPersonales, 
            ds.observacion, 
            cl.personalidad_juridica, 
            ds.idOficial_pf, 
            ds.idDomicilio_pf, 
            ds.actaMatrimonio_pf, 
            ds.actaConstitutiva_pm, 
            ds.poder_pm, 
            ds.idOficialApoderado_pm, 
            ds.idDomicilio_pm, 
            cl.edadFirma, 
            sds.nombre as sedeResidencial, 
            cl.tipoEnganche, 
            loxc.nombre, 
            ISNULL(sds2.nombre, 'Sin especificar') sedeCliente 
         FROM 
            lotes lot 
            INNER JOIN condominios con ON con.idCondominio = lot.idCondominio $filtroCondominio
            INNER JOIN residenciales res ON res.idResidencial = con.idResidencial AND res.idResidencial = 14 $filtroProyecto
            INNER JOIN statuslote sl ON sl.idStatusLote = lot.idStatusLote 
            LEFT JOIN tipo_venta tv ON tv.id_tventa = lot.tipo_venta 
            INNER JOIN clientes cl ON cl.id_cliente = lot.idCliente
            INNER JOIN ventas_compartidas vcc ON vcc.id_cliente = cl.id_cliente AND vcc.estatus = 1 $filtroClientesPropios
            LEFT JOIN opcs_x_cats loxc ON loxc.id_opcion = cl.tipoEnganche AND id_catalogo = 147 
            LEFT JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor 
            LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador 
            LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente 
            LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector 
            LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional 
            LEFT JOIN usuarios u5 ON u5.id_usuario = cl.id_regional_2 
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = cl.lugar_prospeccion AND oxc.id_catalogo = 9 
            LEFT JOIN prospectos pr ON pr.id_prospecto = cl.id_prospecto 
            LEFT JOIN (SELECT id_cliente, estatus, STRING_AGG(CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno), ' - ') nombreCopropietario FROM copropietarios GROUP BY id_cliente, estatus) co ON co.id_cliente = cl.id_cliente AND co.estatus = 1 
            LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = cl.tipo_casa AND oxc2.id_catalogo = 35 
            LEFT JOIN sedes sed ON sed.id_sede = lot.ubicacion 
            LEFT JOIN (SELECT nombreLote, STRING_AGG(CAST(comAdmon AS varchar(250)), ' | ') comAdmon FROM comentarios_administracion GROUP BY nombreLote) ca ON ca.nombreLote = lot.nombreLote 
            LEFT JOIN (SELECT id_cliente, COUNT(*) total FROM ventas_compartidas WHERE estatus = 1 GROUP BY id_cliente) vc ON vc.id_cliente = cl.id_cliente 
            LEFT JOIN statuscontratacion sc ON sc.idStatusContratacion = lot.idStatusContratacion 
            LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97 --nuevo
            LEFT JOIN deposito_seriedad ds ON ds.id_cliente = cl.id_cliente 
            LEFT JOIN (SELECT id_cliente, STRING_AGG(nombre, ', ') nombreReferencias FROM referencias WHERE estatus = 1 GROUP BY id_cliente) ref ON ref.id_cliente = cl.id_cliente 
            LEFT JOIN opcs_x_cats catalogoTipoViv ON catalogoTipoViv.id_opcion = cl.tipo_vivienda AND catalogoTipoViv.id_catalogo = 20 
            LEFT JOIN opcs_x_cats catRegMat ON catRegMat.id_opcion = cl.regimen_matrimonial AND catRegMat.id_catalogo = 19 
            LEFT JOIN opcs_x_cats catEdoCivil ON catEdoCivil.id_opcion = cl.estado_civil AND catEdoCivil.id_catalogo = 18 
            LEFT JOIN opcs_x_cats catNaci ON catNaci.id_opcion = cl.nacionalidad AND catNaci.id_catalogo = 11 
            LEFT JOIN sedes sds ON sds.id_sede = res.sede_residencial 
            LEFT JOIN sedes sds2 ON sds2.id_sede = cl.id_sede --nuevo 
         WHERE 
            lot.status = 1 
            AND lot.idStatusLote IN (2, 3)
            --AND lot.idLote IN (57976, 49180) --ORDER BY lot.nombreLote";
      return $consulta;
   }
   
}