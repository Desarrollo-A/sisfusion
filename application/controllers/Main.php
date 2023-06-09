<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');



class Main extends CI_Controller

{

	public function __construct()

	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('registrolote_modelo');
		$this->load->database('default');

        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
    }


	function index()
	{
		$datos=array();
		$datos["kode"]= $this->registrolote_modelo->lots();
		$this->load->view('example',$datos);
	}

	function bikin_barcode($kode)
	{
		$this->load->library('zend');
		$this->zend->load('Zend/Barcode');
		Zend_Barcode::render('code128', 'image', array('text'=>$kode), array());
	}

	public function realizaContrato($idLote){
		$datos=array();
		$datos["lotes"]= $this->registrolote_modelo->contratin($idLote);
		$this->load->view('make_contrato_view',$datos);
	}

	public function send_contrato(){
		$one=$this->input->post('one');
		$nombreLote=$this->input->post('nombreLote');
		$nombre=$this->input->post('nombre');
		$nombreResidencial=$this->input->post('nombreResidencial');

		$dats=array();
		$dats["one"]= $one;
		$dats["nombreLote"]= $nombreLote;
		$dats["nombre"]= $nombre;
		$dats["nombreResidencial"]= $nombreResidencial;
		$this->load->view('contrato_view',$dats);
	}
}
