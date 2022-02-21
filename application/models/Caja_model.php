<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Caja_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
 

	 function get_proyecto_lista(){
        return $this->db->query("SELECT * FROM [residenciales] WHERE status = 1");
     }
     function get_condominio_lista($proyecto){
        return $this->db->query("SELECT * FROM [condominios] WHERE status = 1 AND idResidencial = ".$proyecto."");
     }
     function get_lote_lista($condominio){
        return $this->db->query("SELECT * FROM [lotes] WHERE status = 1 AND idCondominio =  ".$condominio." AND idCliente in (SELECT idCliente FROM [clientes] ) AND (idCliente <> 0 AND idCliente <>'')");
     }
 
     function get_datos_lote_exp($lote){
        return $this->db->query("SELECT cli.id_cliente, cli.nombre, cli.apellido_paterno, cli.apellido_materno, cli.idLote, lot.nombreLote, con.nombre as condominio, res.nombreResidencial,  lot.contratoArchivo 
                                FROM [clientes] cli 
                                INNER JOIN [lotes] lot ON lot.idLote = cli.idLote 
                                INNER JOIN [condominios] con ON con.idCondominio = lot.idCondominio 
                                INNER JOIN [residenciales] res ON res.idResidencial = con.idResidencial WHERE cli.status = 1 AND cliente.idLote = ".$lote."");
     }
     function get_datos_lote_pagos($lote){
        return $this->db->query("SELECT cli.id_cliente, cli.nombre, cli.apellido_paterno, cli.apellido_materno, cli.idLote, lot.nombreLote, con.nombre as condominio, res.nombreResidencial,  lot.contratoArchivo 
                                FROM [clientes] cli 
                                INNER JOIN [lotes] lot ON lot.idLote = cli.idLote 
                                INNER JOIN [condominios] con ON con.idCondominio = lot.idCondominio 
                                INNER JOIN [residenciales] res ON res.idResidencial = con.idResidencial WHERE cli.status = 1 AND cliente.idLote = ".$lote."");
     }

     function get_datos_condominio($condominio){
        return $this->db->query("SELECT cli.id_cliente, cli.nombre, cli.apellido_paterno, cli.apellido_materno, cli.idLote, lot.nombreLote, con.nombre as condominio, res.nombreResidencial,  lot.contratoArchivo 
                                FROM [clientes] cli 
                                inner join [lotes] lot ON lot.idLote = cli.idLote 
                                inner join [condominios] con ON con.idCondominio = lot.idCondominio 
                                inner join [residenciales] res on res.idResidencial = con.idResidencial WHERE cli.status = 1 and lot.idCondominio = ".$condominio."");
     }

     
 
}