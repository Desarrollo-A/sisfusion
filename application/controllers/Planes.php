<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Planes extends CI_Controller{

    public function __construct(){
        parent::__construct();

        $this->load->model('PlanesModel');
        $this->load->model('Usuarios_modelo');
        $this->load->model('General_model');
    }

    public function index() {
        if ($this->session->userdata('id_rol') == FALSE)
            redirect(base_url());
            $this->load->view('template/header');
            $this->load->view("comisiones/planes/list");
    }

    public function list(){
        $planes = $this->PlanesModel->getPlanesComision();

        foreach ($planes as $key => $plan) {
            $plan->usuarios = $this->PlanesModel->getUsuariosPlanComision($plan->idPlan);
        }
        
        echo json_encode(["data" => $planes]);
    }

    public function usuario(){
        $id_usuario = $this->input->get('id_usuario');

        $usuario = (object) [];
        if($id_usuario){
            $usuario = $this->PlanesModel->getUserInformation($id_usuario);
        }

        echo json_encode($usuario);
    }

    public function residenciales(){
        echo json_encode($this->PlanesModel->getResidenciales());
    }

    public function sedes(){
        echo json_encode($this->PlanesModel->getSedes());
    }

    public function prospecciones(){
        echo json_encode($this->PlanesModel->getLugaresProspeccion());
    }

    public function enable(){
        $id_plan = $this->input->get('plan');

        if($id_plan){
            $is_ok = $this->PlanesModel->enablePlan($id_plan);
        }

        echo json_encode($is_ok);
    }

    public function disable(){
        $id_plan = $this->input->get('plan');

        if($id_plan){
            $is_ok = $this->PlanesModel->disablePlan($id_plan);
        }

        echo json_encode($is_ok);
    }

    public function subir(){
        $id_plan = $this->input->get('plan');

        if($id_plan){
            $is_ok = $this->PlanesModel->subirPrioridad($id_plan);
        }

        echo json_encode($is_ok);
    }

    public function bajar(){
        $id_plan = $this->input->get('plan');

        if($id_plan){
            $is_ok = $this->PlanesModel->bajarPrioridad($id_plan);
        }

        echo json_encode($is_ok);
    }

    public function insertar(){
        $data = (object) $this->input->post();

        if($data){
            $is_ok = $this->PlanesModel->insertarPlan($data);
        }

        echo json_encode($is_ok);
    }

    public function guardar(){
        $data = (object) $this->input->post();

        if($data->fechaFin == ''){
            $data->fechaFin = NULL;
        }

        $id = $data->idPlan;

        if($id && $data){
            $is_ok = $this->PlanesModel->guardarPlan($id, $data);
        }

        echo json_encode($is_ok);
    }

    public function borrar(){
        $id_plan = $this->input->get('plan');

        if($id_plan){
            $is_ok = $this->PlanesModel->borrarPlan($id_plan);
        }

        echo json_encode($is_ok);
    }
}