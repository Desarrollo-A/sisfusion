<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contratacion_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }


     function get_proyecto_lista(){
        return $this->db->query("SELECT * FROM [residenciales] WHERE status = 1");
     }
     function get_condominio_lista($proyecto){
        return $this->db->query("SELECT * FROM condominios WHERE status = 1 AND idResidencial IN($proyecto) ORDER BY nombre");
     }


     function get_proyecto_lista_dos(){
        // return $this->db->query("SELECT * FROM [residenciales] WHERE status = 1");
        return $this->db->query("SELECT res.idResidencial, res.descripcion FROM residenciales res WHERE res.status = 1 AND res.active_comission = 1 ORDER BY res.idResidencial");
     }
     function get_condominio_lista_dos($proyecto){
        return $this->db->query("SELECT * FROM condominios WHERE status = 1 AND idResidencial = ".$proyecto." ORDER BY nombre");
    //        return $this->db->query("SELECT DISTINCT(con.idCondominio), CAST(con.nombre AS VARCHAR(MAX)) AS nombre FROM condominios con
    // INNER JOIN lotes lot ON lot.idCondominio = con.idCondominio
    // INNER JOIN comisiones com ON com.id_lote = lot.idLote
    // INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision $filtro_post ORDER BY CAST(con.nombre AS VARCHAR(MAX))");
     }


     function get_estatus_lote(){
        return $this->db->query("SELECT idStatusLote,nombre FROM [statuslote]");
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

   function get_datos_inventario($estatus, $condominio) {
      $prospectingPlaceDetail = $this->getProspectingPlaceDetail();
      return $this->db->query("SELECT  lot.idLote, lot.nombreLote, con.nombre as nombreCondominio, res.nombreResidencial, lot.idStatusLote, con.idCondominio, lot.sup as superficie, lot.totalNeto2,
      lot.total, lot.referencia, lot.comentario, lot.comentarioLiberacion, lot.observacionLiberacion, 
      CASE WHEN lot.casa = 1 THEN CONCAT(sl.nombre, ' casa') ELSE sl.nombre end as descripcion_estatus, sl.color, tv.tipo_venta, lot.msi as msni,
      CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
      CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
      CONCAT(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
      CONCAT(asesor2.nombre,' ', asesor2.apellido_paterno, ' ', asesor2.apellido_materno) as asesor2,
      CONCAT(asesor2.nombre,' ', asesor2.apellido_paterno, ' ', asesor2.apellido_materno) as coordinador2,
      CONCAT(coordinador2.nombre,' ', coordinador2.apellido_paterno, ' ', coordinador2.apellido_materno) as gerente2,
      lot.precio, lot.fecha_modst, cl.fechaApartado, lot.observacionContratoUrgente,
      CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno) as nombreCliente, lot.motivo_change_status,
      $prospectingPlaceDetail lugar_prospeccion, 
      lot.fecha_creacion, lot.totalValidado as cantidad_enganche, fechaSolicitudValidacion as fecha_validacion,
      lot.idStatusContratacion, ISNULL(co.nombreCopropietario, 'Sin copropietarios') nombreCopropietario
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
      LEFT JOIN (SELECT id_cliente, estatus, STRING_AGG(CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno), ' - ') nombreCopropietario
      FROM copropietarios GROUP BY id_cliente, estatus) co ON co.id_cliente = cl.id_cliente AND co.estatus = 1
      WHERE lot.status = 1 and lot.idCondominio IN ($condominio) AND lot.idStatusLote = $estatus ORDER BY lot.idLote");
   }

   function get_todo_inventario(){
      $prospectingPlaceDetail = $this->getProspectingPlaceDetail();
      return $this->db->query("SELECT  lot.idLote, lot.nombreLote, con.nombre as nombreCondominio, res.nombreResidencial, lot.idStatusLote, con.idCondominio, lot.sup as superficie, lot.totalNeto2,
      lot.total, lot.referencia, lot.comentario, lot.comentarioLiberacion, lot.observacionLiberacion, 
      CASE WHEN lot.casa = 1 THEN CONCAT(sl.nombre, ' casa') ELSE sl.nombre end as descripcion_estatus, sl.color , tv.tipo_venta, lot.msi as msni, lot.observacionContratoUrgente,
      CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
      CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
      CONCAT(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
      CONCAT(asesor2.nombre,' ', asesor2.apellido_paterno, ' ', asesor2.apellido_materno) as asesor2,
      CONCAT(coordinador2.nombre,' ', coordinador2.apellido_paterno, ' ', coordinador2.apellido_materno) as coordinador2,
      CONCAT(gerente2.nombre,' ', gerente2.apellido_paterno, ' ', gerente2.apellido_materno) as gerente2, asesor2.id_rol,
      CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno) as nombreCliente,lot.motivo_change_status,
      $prospectingPlaceDetail lugar_prospeccion, 
      lot.fecha_creacion, lot.totalValidado as cantidad_enganche, fechaSolicitudValidacion as fecha_validacion,
      lot.idStatusContratacion, ISNULL(co.nombreCopropietario, 'Sin copropietarios') nombreCopropietario
      FROM [lotes] lot 
      INNER JOIN [condominios] con ON con.idCondominio = lot.idCondominio 
      INNER JOIN [residenciales] res ON res.idResidencial = con.idResidencial 
      INNER JOIN [statuslote] sl ON sl.idStatusLote = lot.idStatusLote 
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
      LEFT JOIN (SELECT id_cliente, estatus, STRING_AGG(CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno), ' - ') nombreCopropietario
      FROM copropietarios GROUP BY id_cliente, estatus) co ON co.id_cliente = cl.id_cliente AND co.estatus = 1
      WHERE lot.status = 1 and lot.idStatusLote = 100 ORDER BY lot.idLote");
   }

      function get_datos_inventario_pe($proyecto, $estatus){
         $prospectingPlaceDetail = $this->getProspectingPlaceDetail();
         if ($proyecto == 0) {
            return $this->db->query("SELECT  lot.idLote, lot.nombreLote, con.nombre as nombreCondominio, res.nombreResidencial, lot.idStatusLote, con.idCondominio, lot.sup as superficie, lot.total, lot.totalNeto2,
            lot.referencia, lot.comentario, lot.comentarioLiberacion, lot.observacionLiberacion, CASE WHEN lot.casa = 1 THEN CONCAT(sl.nombre, ' casa') ELSE sl.nombre end as descripcion_estatus, sl.color, tv.tipo_venta, lot.msi as msni,                
            CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
            CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
            CONCAT(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,                 
            CONCAT(asesor2.nombre,' ', asesor2.apellido_paterno, ' ', asesor2.apellido_materno) as asesor2,
            CONCAT(coordinador2.nombre,' ', coordinador2.apellido_paterno, ' ', coordinador2.apellido_materno) as coordinador2,
            CONCAT(gerente2.nombre,' ', gerente2.apellido_paterno, ' ', gerente2.apellido_materno) as gerente2, asesor2.id_rol,
            lot.precio, lot.fecha_modst, cl.fechaApartado, lot.observacionContratoUrgente,
            CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno) as nombreCliente,lot.motivo_change_status,
            $prospectingPlaceDetail lugar_prospeccion, 
            lot.fecha_creacion, lot.totalValidado as cantidad_enganche, fechaSolicitudValidacion as fecha_validacion,
            lot.idStatusContratacion, ISNULL(co.nombreCopropietario, 'Sin copropietarios') nombreCopropietario
            FROM [lotes] lot
            INNER JOIN [condominios] con ON con.idCondominio = lot.idCondominio 
            INNER JOIN [residenciales] res ON res.idResidencial = con.idResidencial 
            INNER JOIN [statuslote] sl ON sl.idStatusLote = lot.idStatusLote 
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
            LEFT JOIN (SELECT id_cliente, estatus, STRING_AGG(CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno), ' - ') nombreCopropietario
            FROM copropietarios GROUP BY id_cliente, estatus) co ON co.id_cliente = cl.id_cliente AND co.estatus = 1
            WHERE lot.status = 1 and lot.idStatusLote = $estatus ORDER BY lot.idLote");
         } else {
            return $this->db->query("SELECT  lot.idLote, lot.nombreLote, con.nombre as nombreCondominio, res.nombreResidencial, lot.idStatusLote, con.idCondominio, lot.sup as superficie, lot.total, 
            lot.referencia, lot.comentario, lot.comentarioLiberacion, lot.observacionLiberacion, CASE WHEN lot.casa = 1 THEN CONCAT(sl.nombre, ' casa') ELSE sl.nombre end as descripcion_estatus, sl.color, tv.tipo_venta, lot.msi as msni,              
            CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
            CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
            CONCAT(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,                 
            CONCAT(asesor2.nombre,' ', asesor2.apellido_paterno, ' ', asesor2.apellido_materno) as asesor2,
            CONCAT(coordinador2.nombre,' ', coordinador2.apellido_paterno, ' ', coordinador2.apellido_materno) as coordinador2,
            CONCAT(gerente2.nombre,' ', gerente2.apellido_paterno, ' ', gerente2.apellido_materno) as gerente2, asesor2.id_rol,
            lot.precio, lot.fecha_modst, cl.fechaApartado, lot.observacionContratoUrgente,
            CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno) as nombreCliente,lot.motivo_change_status,
            $prospectingPlaceDetail lugar_prospeccion, 
            lot.fecha_creacion, lot.totalValidado as cantidad_enganche, fechaSolicitudValidacion as fecha_validacion,
            lot.idStatusContratacion, ISNULL(co.nombreCopropietario, 'Sin copropietarios') nombreCopropietario
            FROM [lotes] lot
            INNER JOIN [condominios] con ON con.idCondominio = lot.idCondominio 
            INNER JOIN [residenciales] res ON res.idResidencial = con.idResidencial 
            INNER JOIN [statuslote] sl ON sl.idStatusLote = lot.idStatusLote 
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
            LEFT JOIN (SELECT id_cliente, estatus, STRING_AGG(CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno), ' - ') nombreCopropietario
            FROM copropietarios GROUP BY id_cliente, estatus) co ON co.id_cliente = cl.id_cliente AND co.estatus = 1
            WHERE lot.status = 1 and res.idResidencial IN ($proyecto) AND lot.idStatusLote = $estatus ORDER BY con.nombre, lot.idLote");
         }
     }
     
   function get_datos_inventario_e($estatus){
      $prospectingPlaceDetail = $this->getProspectingPlaceDetail();
      return $this->db->query("SELECT  lot.idLote, lot.nombreLote, con.nombre as nombreCondominio, res.nombreResidencial, lot.idStatusLote, con.idCondominio, lot.sup as superficie, lot.totalNeto2,
      lot.total, lot.referencia, lot.comentario, lot.comentarioLiberacion, lot.observacionLiberacion, 
      CASE WHEN lot.casa = 1 THEN CONCAT(sl.nombre, ' casa') ELSE sl.nombre end as descripcion_estatus, sl.color, tv.tipo_venta, lot.msi as msni, lot.observacionContratoUrgente,
      CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
      CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
      CONCAT(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
      CONCAT(asesor2.nombre,' ', asesor2.apellido_paterno, ' ', asesor2.apellido_materno) as asesor2,
      CONCAT(coordinador2.nombre,' ', coordinador2.apellido_paterno, ' ', coordinador2.apellido_materno) as coordinador2,
      CONCAT(gerente2.nombre,' ', gerente2.apellido_paterno, ' ', gerente2.apellido_materno) as gerente2, asesor2.id_rol, lot.precio, lot.fecha_modst, cl.fechaApartado,
      CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno) as nombreCliente,lot.motivo_change_status,
      $prospectingPlaceDetail lugar_prospeccion, 
      lot.fecha_creacion, lot.totalValidado as cantidad_enganche, fechaSolicitudValidacion as fecha_validacion,
      lot.idStatusContratacion, ISNULL(co.nombreCopropietario, 'Sin copropietarios') nombreCopropietario
      FROM [lotes] lot 
      INNER JOIN [condominios] con ON con.idCondominio = lot.idCondominio 
      INNER JOIN [residenciales] res ON res.idResidencial = con.idResidencial 
      INNER JOIN [statuslote] sl ON sl.idStatusLote = lot.idStatusLote 
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
      LEFT JOIN (SELECT id_cliente, estatus, STRING_AGG(CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno), ' - ') nombreCopropietario
      FROM copropietarios GROUP BY id_cliente, estatus) co ON co.id_cliente = cl.id_cliente AND co.estatus = 1
      WHERE lot.status = 1 and lot.idStatusLote = $estatus ORDER BY lot.idLote");
   }

   function get_datos_inventario_p($proyecto){
      $prospectingPlaceDetail = $this->getProspectingPlaceDetail();
      if ($proyecto == 0) {
         return $this->db->query("SELECT lot.idLote, lot.nombreLote, con.nombre as nombreCondominio, lot.totalNeto2,
         res.nombreResidencial, lot.idStatusLote, con.idCondominio, lot.sup as superficie, 
         lot.total, lot.referencia, lot.comentario, lot.comentarioLiberacion, lot.observacionLiberacion,
         CASE WHEN lot.casa = 1 THEN CONCAT(sl.nombre, ' casa') ELSE sl.nombre end as descripcion_estatus, sl.color, tv.tipo_venta, lot.msi as msni,
         CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
         CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
         CONCAT(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
         CONCAT(asesor2.nombre,' ', asesor2.apellido_paterno, ' ', asesor2.apellido_materno) as asesor2,
         CONCAT(coordinador2.nombre,' ', coordinador2.apellido_paterno, ' ', coordinador2.apellido_materno) as coordinador2,
         CONCAT(gerente2.nombre,' ', gerente2.apellido_paterno, ' ', gerente2.apellido_materno) as gerente2, asesor2.id_rol,
         lot.precio, lot.fecha_modst, cl.fechaApartado, lot.observacionContratoUrgente,
         CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno) as nombreCliente,lot.motivo_change_status,
         $prospectingPlaceDetail lugar_prospeccion, 
         lot.fecha_creacion, lot.totalValidado as cantidad_enganche, fechaSolicitudValidacion as fecha_validacion,
         lot.idStatusContratacion, ISNULL(co.nombreCopropietario, 'Sin copropietarios') nombreCopropietario
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
         LEFT JOIN (SELECT id_cliente, estatus, STRING_AGG(CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno), ' - ') nombreCopropietario
         FROM copropietarios GROUP BY id_cliente, estatus) co ON co.id_cliente = cl.id_cliente AND co.estatus = 1     
         WHERE lot.status = 1  ORDER BY con.nombre, lot.idLote");
      } else {
         return $this->db->query("SELECT lot.idLote, lot.nombreLote, con.nombre as nombreCondominio, 
         res.nombreResidencial, lot.idStatusLote, con.idCondominio, lot.sup as superficie, 
         lot.total, lot.referencia, lot.comentario, lot.comentarioLiberacion, lot.observacionLiberacion,
         CASE WHEN lot.casa = 1 THEN CONCAT(sl.nombre, ' casa') ELSE sl.nombre end as descripcion_estatus, sl.color, tv.tipo_venta, con.msni,
         CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
         CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
         CONCAT(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
         CONCAT(asesor2.nombre,' ', asesor2.apellido_paterno, ' ', asesor2.apellido_materno) as asesor2,
         CONCAT(coordinador2.nombre,' ', coordinador2.apellido_paterno, ' ', coordinador2.apellido_materno) as coordinador2,
         CONCAT(gerente2.nombre,' ', gerente2.apellido_paterno, ' ', gerente2.apellido_materno) as gerente2, asesor2.id_rol,
         lot.precio, lot.fecha_modst, cl.fechaApartado, lot.observacionContratoUrgente,
         CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno) as nombreCliente,lot.motivo_change_status,
         $prospectingPlaceDetail lugar_prospeccion, 
         lot.fecha_creacion, lot.totalValidado as cantidad_enganche, fechaSolicitudValidacion as fecha_validacion,
         lot.idStatusContratacion, ISNULL(co.nombreCopropietario, 'Sin copropietarios') nombreCopropietario
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
         LEFT JOIN (SELECT id_cliente, estatus, STRING_AGG(CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno), ' - ') nombreCopropietario
         FROM copropietarios GROUP BY id_cliente, estatus) co ON co.id_cliente = cl.id_cliente AND co.estatus = 1
         WHERE lot.status = 1 and res.idResidencial IN ($proyecto) ORDER BY res.nombreResidencial, con.nombre, lot.idLote");
      }
   }

   function get_datos_inventario_pc($proyecto, $condominio){
      $prospectingPlaceDetail = $this->getProspectingPlaceDetail();
      return $this->db->query("SELECT  lot.idLote, lot.nombreLote, con.nombre as nombreCondominio, res.nombreResidencial, lot.idStatusLote, con.idCondominio, lot.sup as superficie, lot.total, lot.totalNeto2,
      lot.referencia, lot.comentario, lot.comentarioLiberacion, lot.observacionLiberacion, CASE WHEN lot.casa = 1 THEN CONCAT(sl.nombre, ' casa') ELSE sl.nombre end as descripcion_estatus, sl.color, tv.tipo_venta, lot.msi as msni,
      CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
      CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
      CONCAT(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
      CONCAT(asesor2.nombre,' ', asesor2.apellido_paterno, ' ', asesor2.apellido_materno) as asesor2,
      CONCAT(coordinador2.nombre,' ', coordinador2.apellido_paterno, ' ', coordinador2.apellido_materno) as coordinador2,
      CONCAT(gerente2.nombre,' ', gerente2.apellido_paterno, ' ', gerente2.apellido_materno) as gerente2, asesor2.id_rol,
      lot.precio, lot.fecha_modst, cl.fechaApartado, lot.observacionContratoUrgente,
      CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno) as nombreCliente,lot.motivo_change_status,
      $prospectingPlaceDetail lugar_prospeccion, 
      lot.fecha_creacion, lot.totalValidado as cantidad_enganche, fechaSolicitudValidacion as fecha_validacion,
      lot.idStatusContratacion, ISNULL(co.nombreCopropietario, 'Sin copropietarios') nombreCopropietario
      FROM lotes lot INNER JOIN condominios con ON con.idCondominio = lot.idCondominio 
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
      LEFT JOIN (SELECT id_cliente, estatus, STRING_AGG(CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno), ' - ') nombreCopropietario
      FROM copropietarios GROUP BY id_cliente, estatus) co ON co.id_cliente = cl.id_cliente AND co.estatus = 1
      WHERE lot.status = 1 and res.idResidencial IN ($proyecto) AND lot.idCondominio IN ($condominio) ORDER BY lot.idLote");
   }


      function get_datos_historial($lote){
        /* return $this->db->query("SELECT nombreLote, idLiberacion, observacionLiberacion, modificado, usuarios.nombre, usuarios.apellido_paterno, usuarios.apellido_materno 
                                FROM historial_liberacion INNER JOIN statuslote ON statuslote.idStatusLote = historial_liberacion.status 
                                LEFT JOIN usuarios ON usuarios.usuario = historial_liberacion.userLiberacion WHERE idLote = ".$lote." ORDER BY modificado");*/
         return $this->db->query("SELECT nombreLote, idLiberacion, observacionLiberacion, precio, fechaLiberacion
                modificado, usuarios.nombre, status, idLote, userLiberacion,
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
        return $this->db->query("SELECT idLote, idCliente FROM lotes WHERE idLote = $idLote");
    }

   function getCoSallingAdvisers($id_cliente){
      $query = $this->db-> query("SELECT id_cliente, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor,
      CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) coordinador,
      CONCAT(uuu.nombre, ' ', uuu.apellido_paterno, ' ', uuu.apellido_materno) gerente,
      vc.fecha_creacion, (CASE vc.creado_por WHEN '1297' THEN 'Control interno' ELSE vc.creado_por END) creado_por FROM ventas_compartidas vc 
      LEFT JOIN usuarios u ON u.id_usuario = vc.id_asesor
      LEFT JOIN usuarios uu ON uu.id_usuario = vc.id_coordinador
      LEFT JOIN usuarios uuu ON uuu.id_usuario = vc.id_gerente
      WHERE vc.estatus IN (1, 2) AND vc.id_cliente = $id_cliente ORDER BY vc.id_cliente");
        return $query->result_array();
   }

    function getClauses($lote){
         return $this->db->query("SELECT * FROM clausulas WHERE id_lote = $lote AND estatus = 1");                        
    }

    function getInventoryBylote($idLote){
      return $this->db->query("SELECT  lot.idLote, lot.nombreLote, con.nombre as nombreCondominio, res.nombreResidencial, lot.idStatusLote, con.idCondominio, lot.sup as superficie, 
      lot.total, lot.totalNeto2, lot.referencia, lot.comentario, lot.comentarioLiberacion, lot.observacionLiberacion, 
      CASE WHEN lot.casa = 1 THEN CONCAT(sl.nombre, ' CASA') ELSE sl.nombre END as descripcion_estatus, sl.color, tv.tipo_venta, con.msni,
      CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
      CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
      CONCAT(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
      CONCAT(asesor2.nombre,' ', asesor2.apellido_paterno, ' ', asesor2.apellido_materno) as asesor2,
      CONCAT(asesor2.nombre,' ', asesor2.apellido_paterno, ' ', asesor2.apellido_materno) as coordinador2,
      CONCAT(coordinador2.nombre,' ', coordinador2.apellido_paterno, ' ', coordinador2.apellido_materno) as gerente2,
      lot.precio, lot.fecha_modst, cl.fechaApartado, lot.observacionContratoUrgente,
      CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno) as nombreCliente, lot.motivo_change_status,
      CONCAT(REPLACE(ISNULL(oxc.nombre, 'Sin especificar'), ' (especificar)', ''), (CASE pr.source WHEN '0' THEN '' ELSE CONCAT(' - ', pr.source) END)) lugar_prospeccion, 
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
      SELECT re.idResidencial id, UPPER(CAST(re.descripcion AS VARCHAR(75))) nombre, 2 tipo FROM residenciales re
      WHERE re.status = 1 AND re.sede_residencial = 2");
   }

   public function getCompleteInventory ($sede_residencial) {
      $prospectingPlaceDetail = $this->getProspectingPlaceDetail();
      return $this->db->query("SELECT lot.idLote, lot.nombreLote, con.nombre as nombreCondominio, lot.totalNeto2,
      res.nombreResidencial, lot.idStatusLote, con.idCondominio, lot.sup as superficie, 
      lot.total, lot.referencia, lot.comentario, lot.comentarioLiberacion, lot.observacionLiberacion,
      CASE WHEN lot.casa = 1 THEN CONCAT(sl.nombre, ' casa') ELSE sl.nombre end as descripcion_estatus, sl.color, tv.tipo_venta, lot.msi as msni,
      CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
      CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
      CONCAT(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
      CONCAT(asesor2.nombre,' ', asesor2.apellido_paterno, ' ', asesor2.apellido_materno) as asesor2,
      CONCAT(coordinador2.nombre,' ', coordinador2.apellido_paterno, ' ', coordinador2.apellido_materno) as coordinador2,
      CONCAT(gerente2.nombre,' ', gerente2.apellido_paterno, ' ', gerente2.apellido_materno) as gerente2, asesor2.id_rol,
      lot.precio, lot.fecha_modst, cl.fechaApartado, lot.observacionContratoUrgente,
      CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno) as nombreCliente,lot.motivo_change_status,
      $prospectingPlaceDetail lugar_prospeccion, 
      lot.fecha_creacion,
      lot.totalValidado as cantidad_enganche, fechaSolicitudValidacion as fecha_validacion
      FROM lotes lot 
      INNER JOIN condominios con ON con.idCondominio = lot.idCondominio 
      INNER JOIN residenciales res ON res.idResidencial = con.idResidencial AND res.sede_residencial = $sede_residencial
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
      WHERE lot.status = 1  ORDER BY con.nombre, lot.idLote");
   }

   public function getSedesPorDesarrollos(){
      return $this->db->query("SELECT re.sede_residencial id_sede, se.nombre FROM residenciales re
      INNER JOIN sedes se ON se.id_sede = re.sede_residencial
      WHERE re.status = 1 GROUP BY re.sede_residencial, se.nombre");
   }
     
}