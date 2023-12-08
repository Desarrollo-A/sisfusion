<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;

class XMLDownload extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library(array('session', 'form_validation'));
    $this->load->helper(array('url', 'form'));
    $this->load->database('default');
  }

  public function index()
  {
    redirect(base_url());
  }

    public function descargar_XML(){
      if( $this->session->userdata('id_rol') == 31 ){
        $filtro = " pci.estatus IN (8) ";
      } else{
        $filtro = " pci.estatus IN (4,8) ";
      }
      
      $facturas_disponibles = array();
      $facturas_disponibles = $this->db->query("SELECT DISTINCT(fa.nombre_archivo) 
      from facturas fa
      INNER JOIN pago_comision_ind pci ON fa.id_comision = pci.id_pago_i
      WHERE $filtro
      GROUP BY fa.nombre_archivo
      ORDER BY fa.nombre_archivo");
      
      if( $facturas_disponibles->num_rows() > 0 ){
        $this->load->library('zip');
        $nombre_documento = 'FACTURAS_INTERNOMEX_'.date("YmdHis").'.zip';
        foreach( $facturas_disponibles->result() as $row ){
          $this->zip->read_file( './UPLOADS/XMLS/'.$row->nombre_archivo );
        }
        
        $this->zip->archive( $nombre_documento );
        $this->zip->download( $nombre_documento );
      }else{
        echo 'no entra';
      }
    }

    public function descargar_PDF(){
      $facturas_disponibles = array();
      $facturas_disponibles = $this->db->query("SELECT DISTINCT(opn.archivo_name) from opinion_cumplimiento opn WHERE opn.estatus in (1,2) ORDER BY opn.archivo_name");
      if( $facturas_disponibles->num_rows() > 0 ){
        $this->load->library('zip');
        $nombre_documento = 'PDF_INTERNOMEX_'.date("YmdHis").'.zip';
        foreach( $facturas_disponibles->result() as $row ){
          $this->zip->read_file( './static/documentos/cumplimiento/'.$row->archivo_name );
        }
        
        $this->zip->archive( $nombre_documento );
        $this->zip->download( $nombre_documento );
      }else{
        echo 'no entra';
      }
    }

    public function descargar_XMLOOAM(){
      if( $this->session->userdata('id_rol') == 31 ){
        $filtro = " pci.estatus IN (8) ";
      } else{
        $filtro = " pci.estatus IN (4,8) ";
      }
      
      $facturas_disponibles = array();
      $facturas_disponibles = $this->db->query("SELECT DISTINCT(fa.nombre_archivo) 
      from facturas_ooam fa
      INNER JOIN pago_ooam_ind pci ON fa.id_comision = pci.id_pago_i
      WHERE $filtro
      GROUP BY fa.nombre_archivo
      ORDER BY fa.nombre_archivo");
      
      if( $facturas_disponibles->num_rows() > 0 ){
        $this->load->library('zip');
        $nombre_documento = 'FACTURAS_OOAM_INTERNOMEX_'.date("YmdHis").'.zip';
        foreach( $facturas_disponibles->result() as $row ){
          $this->zip->read_file( './UPLOADS/XMLSOOAM/'.$row->nombre_archivo );
        }
        
        $this->zip->archive( $nombre_documento );
        $this->zip->download( $nombre_documento );
      }else{
        echo 'no entra';
      }
    }

    public function descargar_PDFOOAM(){
      $facturas_disponibles = array();
      $facturas_disponibles = $this->db->query("SELECT DISTINCT(opn.archivo_name) from opinion_cumplimiento opn WHERE opn.estatus in (1,2) ORDER BY opn.archivo_name");
      if( $facturas_disponibles->num_rows() > 0 ){
        $this->load->library('zip');
        $nombre_documento = 'PDF_OOAM_INTERNOMEX_'.date("YmdHis").'.zip';
        foreach( $facturas_disponibles->result() as $row ){
          $this->zip->read_file( './static/documentos/cumplimiento/'.$row->archivo_name );
        }
        
        $this->zip->archive( $nombre_documento );
        $this->zip->download( $nombre_documento );
      }else{
        echo 'no entra';
      }
    }

    

}
