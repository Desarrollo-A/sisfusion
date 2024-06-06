<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class EnganchesModel extends CI_Model{
    // private $idUsuario;
    public $programacion;

    public function __construct(){
        parent::__construct();

        $this->programacion = $this->load->database('programacion', true);

        // $this->load->library(['session']);

        // $this->idUsuario = $this->session->userdata('id_usuario');
    }

    public function borrarEnganches(){
        $this->db->query("TRUNCATE TABLE det_enganche");
        $this->db->query("TRUNCATE TABLE enganche");

        return true;
    }

    public function getEmpresas($empresa){
        return $this->db->query("SELECT
            distinct(empresa) empresa
        FROM residenciales
        WHERE
            status = 1
        AND empresa LIKE '%$empresa%'")->result();
    }

    public function getEnganchesPorEmpresa($empresa){
        return $this->programacion->query("EXEC [programacion].[dbo].[CDM056ClientesCRM1erPagoTipoPlan] @empresa='$empresa'")->result_array();
    }

    public function getLotePorNombre($nombreLote){
        return $this->db->query("SELECT * FROM lotes WHERE nombreLote = '$nombreLote'")->row();
    }

    public function insertEnganche($data){
        $this->db->insert('enganche', $data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }

    public function insertDetalleEnganche($data){
        $this->db->insert('det_enganche', $data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }

}