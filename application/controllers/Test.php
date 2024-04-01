<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . "/controllers/BaseController.php");

class Test extends BaseController {
    public function __construct() {
        parent::__construct();

        $this->load->model(['TestModel']);
    }

    public function layout(){
        $this->load->view('template/header');
        $this->load->view("test/layout");
    }

    public function lotes(){
        $lotes = $this->TestModel->getLotes();

        echo json_encode($lotes);
    }

    public function form()
    {
        $form = $this->input->post();
        print_r($form);
    }
}