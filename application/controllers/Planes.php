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

    public function tipo_venta(){
        echo json_encode($this->PlanesModel->getTipoVenta());
    }

    public function procesos(){
        echo json_encode($this->PlanesModel->getProcesos());
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
            $id = $this->PlanesModel->insertarPlan($data);
        }

        $this->saveUsuariosPlanComision($id, $data);

        echo json_encode($id);
    }

    public function guardar(){
        $data = (object) $this->input->post();

        $id = $data->idPlan;

        if($id && $data){
            $is_ok = $this->PlanesModel->guardarPlan($id, $data);
        }

        $this->saveUsuariosPlanComision($id, $data);

        echo json_encode($is_ok);
    }

    private function saveUsuariosPlanComision($id, $data){
        if($data->usuarios){
            foreach ($data->usuarios as $key => $usuario) {
                $usuario = (object) $usuario;

                $this->PlanesModel->saveUsuarioPlanComision($id, $usuario->id, $usuario->nombre, $usuario->comision);
            }
        }
    }

    public function borrar(){
        $id_plan = $this->input->get('plan');

        if($id_plan){
            $is_ok = $this->PlanesModel->borrarPlan($id_plan);
        }

        echo json_encode($is_ok);
    }

    public function remove_usuario()
    {
        $id_usuario = $this->input->get('usuario');
        $id_plan = $this->input->get('plan');

        $this->PlanesModel->removeUsuarioPlanComision($id_usuario, $id_plan);
    }

    public function llenado(){
        $planes = $this->PlanesModel->getPlanesComision();

        foreach ($planes as $key => $plan) {
            if($plan->estatus == 1){
                $conditions = [];

                $where = '';

                if($plan->venta_compartida){
                    $where .= "INNER JOIN ventas_compartidas vc ON vc.id_cliente = cl.id_cliente AND vc.estatus = 1 AND cl.status = 1 ";

                    if($plan->sedes_compartidas){
                        array_push($conditions, "vc.id_sede IN ($plan->sedes_compartidas) AND vc.id_regional NOT IN(0)");
                    }
                }

                if($plan->sedes){
                    array_push($conditions, "cl.id_sede IN ($plan->sedes)");
                }

                if($plan->residencial){
                    array_push($conditions, "r.idResidencial IN ($plan->residencial)");
                }

                if($plan->lotes){
                    array_push($conditions, "l.idLote IN ($plan->lotes)");
                }

                if($plan->fechaInicio){
                    array_push($conditions, "cl.fechaApartado >= '$plan->fechaInicio'");
                }

                if($plan->fechaFin){
                    array_push($conditions, "cl.fechaApartado < '$plan->fechaFin'");
                }

                if($plan->prospeccion !== NULL){
                    if($plan->is_prospeccion == 0){
                        array_push($conditions, "cl.lugar_prospeccion NOT IN ($plan->prospeccion)");
                    }else{
                        array_push($conditions, "cl.lugar_prospeccion IN ($plan->prospeccion)");
                    }
                }

                if($plan->is_regional !== null){
                    if($plan->is_regional){
                        array_push($conditions, "cl.id_regional IN ($plan->regional)");
                    }else{
                        array_push($conditions, "cl.id_regional NOT IN ($plan->regional)");
                    }
                }

                if($plan->subdirectores){
                    array_push($conditions, "cl.id_subdirector IN ($plan->subdirectores)");
                }

                if($plan->inicio_prospeccion){
                    array_push($conditions, "ps.fecha_creacion > '$plan->inicio_prospeccion'");
                }

                if($plan->fin_prospeccion){
                    array_push($conditions, "ps.fecha_creacion < '$plan->fin_prospeccion'");
                }

                if($plan->descuento_mdb !== null){
                    if($plan->descuento_mdb == 1){
                        array_push($conditions, "cl.descuento_mdb = 1");
                    }else{
                        array_push($conditions, "cl.descuento_mdb != 0");
                    }
                }

                if($plan->gerentes){
                    array_push($conditions, "cl.id_gerente IN ($plan->gerentes)");
                }

                if($plan->ismktd !== null){
                    if($plan->ismktd == 0){
                        array_push($conditions, "ae.ismktd != 1");
                    }else{
                        array_push($conditions, "ae.ismktd = 1");
                    }
                }

                if($plan->procesos){
                    array_push($conditions, "cl.proceso IN ($plan->procesos)");
                }

                $where .= 'WHERE ' . implode(' AND ', $conditions) . "\n";
                print_r($plan->nombre . ': ' . $where);
            }
        }
        exit;
    }
}