<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Statistics extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Statistics_model');
        $this->validateSession();

        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
    }

    public function index()
    {    }

    public function consultMktdChart(){
        $this->load->view('template/header');
        $this->load->view("clientes/consult_statistics_em");
    }

    public function consultProspectingPlaceChart(){
        $this->load->view('template/header');
        $this->load->view("clientes/consult_statistics_lp");
    }

    function getSubdirectories()
    {
        echo json_encode($this->Statistics_model->getSubdirectories()->result_array());
    }

    public function getManagersBySubdirector($id_subdir){
        echo json_encode($this->Statistics_model->getManagersBySubdirector($id_subdir)->result_array());
    }

    public function getManagersBySub(){
        $id_subdir = $this->session->userdata('id_usuario');
        if($this->session->userdata('id_rol') == 5){
            echo json_encode($this->Statistics_model->getManagersBySubdirector_assist($id_subdir)->result_array());
        }else{
            echo json_encode($this->Statistics_model->getManagersBySubdirector($id_subdir)->result_array());
        }
    }

    public function getCoordinatorsByManager(){
        $id_gerente = $this->session->userdata('id_usuario');
        echo json_encode($this->Statistics_model->getCoordinatorsByManager($id_gerente)->result_array());
    }

    public function getAdvisersByCoordinator(){
        $id_coordinador = $this->session->userdata('id_usuario');
        echo json_encode($this->Statistics_model->getAdvisersByCoordinator($id_coordinador)->result_array());
    }

    public function get_clientes()
    {
        $user = $this->session->userdata('id_usuario');
        $clientes = $this->Statistics_model->get_clientes($user)->result();
        echo json_encode($clientes);
    }

    public function get_chart()
    {
        $request = json_decode(file_get_contents("php://input"));
        $tipo = $request->tipo;
        $fecha_ini = date("Y/m/d", strtotime($request->fecha_ini));
        $fecha_fin = date("Y/m/d", strtotime($request->fecha_fin));
        $user = $this->session->userdata('id_usuario');

        if ($tipo == "0" || $tipo == "1") {
            $clientes = $this->Statistics_model->get_chartuser($user, $tipo, $fecha_ini, $fecha_fin)->result();
        } else {
            $clientes = $this->Statistics_model->get_chartuser2($user, $tipo, $fecha_ini, $fecha_fin)->result();
        }

        echo json_encode($clientes);

    }

    public function get_total_gerente()
    {
        $tipo = 0;
        $user = $this->session->userdata('id_usuario');
        if ($this->session->userdata('id_rol') == '3') {
            $clientes = $this->Statistics_model->get_total_gerente($user, $tipo)->result();
        } else {
            $clientes = $this->Statistics_model->get_total_gerente_asis($user, $tipo)->result();
        }
        echo json_encode($clientes);

    }

    public function get_total_coordinador()
    {
        $tipo = 0;
        $user = $this->session->userdata('id_usuario');

        $clientes = $this->Statistics_model->get_total_coordinador($user, $tipo)->result();

        echo json_encode($clientes);

    }

    public function get_chart_dir()
    {
        $request = json_decode(file_get_contents("php://input"));
        $tipo = $request->tipo;
        $fecha_ini = date("Y/m/d", strtotime($request->fecha_ini));
        $fecha_fin = date("Y/m/d", strtotime($request->fecha_fin));
        $user = $request->asesor;
        $currentuser = $this->session->userdata('id_usuario');
        $gerente = $request->gerente;
        if ($tipo == "0" || $tipo == "1") {
            $clientes = $this->Statistics_model->get_chart_dirbyase($user, $tipo, $fecha_ini, $fecha_fin)->result();
        } else {
            $clientes = $this->Statistics_model->get_chart_dirbyase1($user, $fecha_ini, $fecha_fin)->result();
        }
        echo json_encode($clientes);
    }

    public function get_all_dir()
    {
        $request = json_decode(file_get_contents("php://input"));
        $tipo = $request->tipo;
        $fecha_ini = date("Y/m/d", strtotime($request->fecha_ini));
        $fecha_fin = date("Y/m/d", strtotime($request->fecha_fin));

        if ($tipo == "0" || $tipo == "1") {
            $clientes = $this->Statistics_model->get_all_dir($tipo, $fecha_ini, $fecha_fin)->result();
        } else {
            $clientes = $this->Statistics_model->get_alldir($fecha_ini, $fecha_fin)->result();
        }
        echo json_encode($clientes);
    }

    public function get_chart_dir_byger()
    {
        $request = json_decode(file_get_contents("php://input"));
        $tipo = $request->tipo;
        $fecha_ini = date("Y/m/d", strtotime($request->fecha_ini));
        $fecha_fin = date("Y/m/d", strtotime($request->fecha_fin));
        $currentuser = $this->session->userdata('id_usuario');
        $gerente = $request->gerente;
        if ($tipo == "0" || $tipo == "1") {
            $clientes = $this->Statistics_model->get_total_gerente1($gerente, $tipo, $fecha_ini, $fecha_fin)->result();
        } else {
            $clientes = $this->Statistics_model->get_total_gerente2($gerente, $fecha_ini, $fecha_fin)->result();
        }
        echo json_encode($clientes);
    }

    public function get_chart_dir_bycoord()
    {
        $request = json_decode(file_get_contents("php://input"));
        $tipo = $request->tipo;
        $fecha_ini = date("Y/m/d", strtotime($request->fecha_ini));
        $fecha_fin = date("Y/m/d", strtotime($request->fecha_fin));
        $currentuser = $this->session->userdata('id_usuario');
        $gerente = $request->gerente;
        $coordinador = $request->coordinador;
        if ($tipo == "0" || $tipo == "1") {
            $clientes = $this->Statistics_model->get_total_coordinador1($gerente, $coordinador, $tipo, $fecha_ini, $fecha_fin)->result();
        } else {
            $clientes = $this->Statistics_model->get_total_coordinador2($gerente, $coordinador, $fecha_ini, $fecha_fin)->result();
        }
        echo json_encode($clientes);
    }

    public function get_chart_ger_bycoord()
    {
        $request = json_decode(file_get_contents("php://input"));
        $tipo = $request->tipo;
        $fecha_ini = date("Y/m/d", strtotime($request->fecha_ini));
        $fecha_fin = date("Y/m/d", strtotime($request->fecha_fin));
        $user = $this->session->userdata('id_usuario');
        $leader = $this->session->userdata('id_lider');
        $coordinador = $request->coordinador;
        if ($this->session->userdata('id_rol') == '3') {
            if ($tipo == "0" || $tipo == "1") {
                $clientes = $this->Statistics_model->get_total_coordinador1($user, $coordinador, $tipo, $fecha_ini, $fecha_fin)->result();
            } else {
                $clientes = $this->Statistics_model->get_total_coordinador2($user, $coordinador, $fecha_ini, $fecha_fin)->result();
            }
        } else {
            if ($tipo == "0" || $tipo == "1") {
                $clientes = $this->Statistics_model->get_total_coordinador_asis1($user, $coordinador, $tipo, $fecha_ini, $fecha_fin, $leader)->result();
            } else {
                $clientes = $this->Statistics_model->get_total_coordinadorasis2($user, $coordinador, $fecha_ini, $fecha_fin, $leader)->result();
            }

        }
        echo json_encode($clientes);
    }

    public function get_chart_dir_bysub()
    {
        $request = json_decode(file_get_contents("php://input"));
        $tipo = $request->tipo;
        $subdir = $request->subdir;
        $fecha_ini = date("Y/m/d", strtotime($request->fecha_ini));
        $fecha_fin = date("Y/m/d", strtotime($request->fecha_fin));
        $currentuser = $this->session->userdata('id_usuario');
        if ($tipo == "0" || $tipo == "1") {
            $clientes = $this->Statistics_model->get_total_subdir1($subdir, $fecha_ini, $fecha_fin, $tipo)->result();
        } else {
            $clientes = $this->Statistics_model->get_total_subdir2($subdir, $fecha_ini, $fecha_fin)->result();
        }
        echo json_encode($clientes);
    }

    public function get_chart_gerente()
    {
        $request = json_decode(file_get_contents("php://input"));
        $tipo = $request->tipo;
        $fecha_ini = date("Y/m/d", strtotime($request->fecha_ini));
        $fecha_fin = date("Y/m/d", strtotime($request->fecha_fin));
        $user = $request->asesor;
        $currentuser = $this->session->userdata('id_usuario');

        if ($this->session->userdata('id_rol') == '3') { //si es gerente
            $coordinador = $request->coordinador;
            if ($tipo == "0" || $tipo == "1") {
                $clientes = $this->Statistics_model->get_chart($user, $tipo, $fecha_ini, $fecha_fin, $currentuser)->result();
            } else {
                $clientes = $this->Statistics_model->get_chart2($user, $tipo, $fecha_ini, $fecha_fin, $currentuser, $coordinador)->result();
            }
        } elseif ($this->session->userdata('id_rol') == '9') { //si es coordinador
            if ($tipo == "0" || $tipo == "1") {
                $clientes = $this->Statistics_model->get_chart_coord($user, $tipo, $fecha_ini, $fecha_fin, $currentuser)->result();
            } else {
                $clientes = $this->Statistics_model->get_chart_coord2($user, $fecha_ini, $fecha_fin, $currentuser)->result();
            }
        } elseif ($this->session->userdata('id_rol') == '6') { //si es asistente de gerente
            if ($tipo == "0" || $tipo == "1") {
                $clientes = $this->Statistics_model->get_chart_asisger($user, $tipo, $fecha_ini, $fecha_fin, $currentuser)->result();
            } else {
                $clientes = $this->Statistics_model->get_chart_asisger2($user, $tipo, $fecha_ini, $fecha_fin, $currentuser)->result();
            }
        } elseif ($this->session->userdata('id_rol') == '2') { //si es subdirector
            $gerente = $request->gerente;
            if ($tipo == "0" || $tipo == "1") {

                $clientes = $this->Statistics_model->get_chart_subdir($user, $tipo, $fecha_ini, $fecha_fin, $gerente, $currentuser)->result();
            } else {
                $clientes = $this->Statistics_model->get_chart_subdir2($user, $tipo, $fecha_ini, $fecha_fin, $gerente, $currentuser)->result();
            }
        } elseif ($this->session->userdata('id_rol') == '1' || $this->session->userdata('id_rol') == '4' || $this->session->userdata('id_rol') == '10') { //si es director o asistente director
            $gerente = $request->gerente;
            if ($gerente != NULL && $user != NULL) {
                if ($tipo == "0" || $tipo == "1") {
                    $clientes = $this->Statistics_model->get_chart_subdir($user, $tipo, $fecha_ini, $fecha_fin, $gerente, $currentuser)->result();
                } else {
                    $clientes = $this->Statistics_model->get_chart_subdir2($user, $tipo, $fecha_ini, $fecha_fin, $gerente, $currentuser)->result();
                }
            } elseif ($gerente != NULL && $user == NULL) {
                if ($tipo == "0" || $tipo == "1") {
                    $clientes = $this->Statistics_model->get_total_gerente1($gerente, $tipo, $fecha_ini, $fecha_fin)->result();
                } else {
                    $clientes = $this->Statistics_model->get_total_gerente2($gerente, $tipo, $fecha_ini, $fecha_fin)->result();
                }

            } else {

            }

        } else {// si es asistente de subdirector
            $gerente = $request->gerente;
            if ($tipo == "0" || $tipo == "1") {

                $clientes = $this->Statistics_model->get_chart_subdir_asis($user, $tipo, $fecha_ini, $fecha_fin, $gerente, $currentuser)->result();
            } else {
                $clientes = $this->Statistics_model->get_chart_subdir_asis2($user, $tipo, $fecha_ini, $fecha_fin, $gerente, $currentuser)->result();
            }

        }


        echo json_encode($clientes);

    }

    public function get_total_director()
    {
        $user = $this->session->userdata('id_usuario');
        if ($this->session->userdata('id_rol') == '1' || $this->session->userdata('id_rol') == '4' || $this->session->userdata('id_rol') == '10') {
            $clientes = $this->Statistics_model->get_total_director()->result();
        } elseif ($this->session->userdata('id_rol') == '2') {
            $clientes = $this->Statistics_model->get_total_subdir($user)->result();
        } else {
            $clientes = $this->Statistics_model->get_total_subdir_byasis($user)->result();
        }

        echo json_encode($clientes);

    }

    public function get_asesores_gerentes()
    {
        $request = json_decode(file_get_contents("php://input"));
        $user = $request->gerente;
        $asesores = $this->Statistics_model->get_asesoresbygerente($user)->result();

        echo json_encode($asesores);
    }

    public function get_asesores_coordinadores($id_coordinator)
    {
        $request = json_decode(file_get_contents("php://input"));
        $currentuser = $this->session->userdata('id_usuario');
        $coordinador = $id_coordinator;
        $asesores = $this->Statistics_model->get_asesores_bycoord($coordinador, $currentuser)->result();

        echo json_encode($asesores);
    }

    public function get_coordinadores_bysub($id_gerente)
    {
        $request = json_decode(file_get_contents("php://input"));
        $currentuser = $this->session->userdata('id_usuario');
        $asesores = $this->Statistics_model->get_coordinadoresbyasis($id_gerente)->result();

        echo json_encode($asesores);
    }


    public function generar_reporte()
    {

        $request = json_decode(file_get_contents("php://input"));
        $tipo = $request->tipo;
        $fecha_ini = date("Y/m/d", strtotime($request->fecha_ini));
        $fecha_fin = date("Y/m/d", strtotime($request->fecha_fin));
        $user = $this->session->userdata('id_usuario');

        $reader = new PhpOffice\PhpSpreadsheet\Spreadsheet();
        $encabezados = [
            'font' => [
                'color' => [
                    'argb' => 'FFFFFFFF',
                ]
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'startColor' => [
                    'argb' => '00000000',
                ],
                'endColor' => [
                    'argb' => '00000000',
                ],
            ],
        ];

        $informacion = [
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ]
        ];

        $reporte = $this->db->query("SELECT MONTHNAME(fecha_creacion) AS mes, COUNT(id_cliente) AS clientes FROM sisgphco_crm.clientes
                  WHERE (tipo = '$tipo' AND id_asesor = '$user') AND fecha_creacion BETWEEN '$fecha_ini' AND '$fecha_fin' GROUP BY mes 
                  ORDER BY MONTH(fecha_creacion)");

        //Inicio de Reporte
        $i = 1;
        $reader->getActiveSheet()->setCellValue('A' . $i, 'MES');
        $reader->getActiveSheet()->setCellValue('B' . $i, '# Clientes');

        $reader->getActiveSheet()->getStyle("A$i:B$i")->applyFromArray($encabezados);
        $i += 1;

        if ($reporte->num_rows() > 0) {

            foreach ($reporte->result() as $row) {

                $reader->getActiveSheet()->setCellValue('A' . $i, $row->mes);
                $reader->getActiveSheet()->setCellValue('B' . $i, $row->clientes);


                $reader->getActiveSheet()->getStyle("A$i:B$i")->applyFromArray($informacion);
                $i += 1;

            }
        }

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($reader, "Xlsx");

        $temp_file = tempnam(sys_get_temp_dir(), 'PHPExcel');
        $writer->save($temp_file);

        header("Content-Disposition: attachment; filename=REPORTE.xlsx");
        readfile($temp_file); // or echo file_get_contents($temp_file);
        unlink($temp_file);


    }

    public function get_repo_asesor()
    {
        $request = json_decode(file_get_contents("php://input"));
        $fecha_ini = date("Y/m/d", strtotime($request->fecha_ini));
        $fecha_fin = date("Y/m/d", strtotime($request->fecha_fin));
        $tipo = $request->tipo;
        $user = $this->session->userdata('id_usuario');

        if ($tipo == '2') {
            $clientes = $this->Statistics_model->get_reporte_asesor_1($user, $fecha_ini, $fecha_fin)->result();
        } else {
            $clientes = $this->Statistics_model->get_reporte_asesor($user, $fecha_ini, $fecha_fin, $tipo)->result();
        }
        echo json_encode($clientes);

    }

    public function get_repo_asesor_general()
    {
        $tipo = 0;
        $user = $this->session->userdata('id_usuario');

        $clientes = $this->Statistics_model->get_reporte_asesor_general($user, $tipo)->result();

        echo json_encode($clientes);

    }

    public function get_repo_gerente()
    {
        $user = $this->session->userdata('id_usuario');

        if ($this->session->userdata('id_rol') == '3') { // si es gerente
            $clientes = $this->Statistics_model->get_reporte_gerente($user)->result();
        } else { // si es asistente de gerente
            $clientes = $this->Statistics_model->get_reporte_asisgerente($user)->result();
        }

        echo json_encode($clientes);

    }

    public function get_repo_gerente_general()
    {
        $user = $this->session->userdata('id_usuario');
        $tipo = 0;
        if ($this->session->userdata('id_rol') == '3') { // si es gerente
            $clientes = $this->Statistics_model->get_reporte_gerente_general($user, $tipo)->result();
        } else { // si es asistente de gerente
            $clientes = $this->Statistics_model->get_reporte_asisgeneralgerente($user, $tipo)->result();
        }

        echo json_encode($clientes);

    }

    public function get_repo_coord()
    {
        $user = $this->session->userdata('id_usuario');

        $clientes = $this->Statistics_model->get_reporte_coordinador($user)->result();

        echo json_encode($clientes);

    }

    public function get_repo_gerente1()
    {
        $request = json_decode(file_get_contents("php://input"));
        $tipo = $request->tipo;
        $asesor = $request->asesor;
        $fecha_ini = date("Y/m/d", strtotime($request->fecha_ini));
        $fecha_fin = date("Y/m/d", strtotime($request->fecha_fin));
        $user = $this->session->userdata('id_usuario');

        if ($tipo == '2') {
            if ($this->session->userdata('id_rol') == '3') {
                $clientes = $this->Statistics_model->get_reporte_gerente2($user, $fecha_ini, $fecha_fin, $tipo, $asesor)->result();
            } else {
                $clientes = $this->Statistics_model->get_reporte_asisgerente2($user, $fecha_ini, $fecha_fin, $tipo, $asesor)->result();
            }
        } else {
            if ($this->session->userdata('id_rol') == '3') {
                $clientes = $this->Statistics_model->get_reporte_gerente1($user, $fecha_ini, $fecha_fin, $tipo, $asesor)->result();
            } else {
                $clientes = $this->Statistics_model->get_reporte_asisgerente1($user, $fecha_ini, $fecha_fin, $tipo, $asesor)->result();
            }
        }

        echo json_encode($clientes);

    }


    public function get_repo_gerentecoord1()
    {
        $request = json_decode(file_get_contents("php://input"));
        $tipo = $request->tipo;
        $coordinador = $request->coordinador;
        $fecha_ini = date("Y/m/d", strtotime($request->fecha_ini));
        $fecha_fin = date("Y/m/d", strtotime($request->fecha_fin));
        $user = $this->session->userdata('id_usuario');

        if ($tipo == '2') {
            if ($this->session->userdata('id_rol') == '3') {
                $clientes = $this->Statistics_model->get_reporte_gerente_coord2($user, $fecha_ini, $fecha_fin, $coordinador)->result();
            } else {
                $clientes = $this->Statistics_model->get_reporte_asisgerente_coord2($user, $fecha_ini, $fecha_fin, $coordinador)->result();
            }
        } else {
            if ($this->session->userdata('id_rol') == '3') {
                $clientes = $this->Statistics_model->get_reporte_gerente_coord1($user, $fecha_ini, $fecha_fin, $tipo, $coordinador)->result();
            } else {
                $clientes = $this->Statistics_model->get_reporte_asisgerente_coord1($user, $fecha_ini, $fecha_fin, $tipo, $coordinador)->result();
            }
        }

        echo json_encode($clientes);

    }

    public function get_repo_coord1()
    {
        $request = json_decode(file_get_contents("php://input"));
        $tipo = $request->tipo;
        $asesor = $request->asesor;
        $fecha_ini = date("Y/m/d", strtotime($request->fecha_ini));
        $fecha_fin = date("Y/m/d", strtotime($request->fecha_fin));
        $user = $this->session->userdata('id_usuario');

        if ($tipo == '2') {
            $clientes = $this->Statistics_model->get_reporte_coordinador2($user, $fecha_ini, $fecha_fin, $asesor)->result();
        } else {
            $clientes = $this->Statistics_model->get_reporte_coordinador1($user, $fecha_ini, $fecha_fin, $tipo, $asesor)->result();
        }

        echo json_encode($clientes);

    }

    public function get_repo_coord_general1()
    {
        $tipo = 0;
        $user = $this->session->userdata('id_usuario');

        $clientes = $this->Statistics_model->get_reporte_coordinadorgeneral1($user, $tipo)->result();

        echo json_encode($clientes);

    }

    public function get_repo_dir()
    {
        $user = $this->session->userdata('id_usuario');

        if ($this->session->userdata('id_rol') == '1' || $this->session->userdata('id_rol') == '4' || $this->session->userdata('id_rol') == '10') {
            $clientes = $this->Statistics_model->get_reporte_dir()->result();
        } elseif ($this->session->userdata('id_rol') == '2') {
            $clientes = $this->Statistics_model->get_reporte_subdir($user)->result();
        } else {
            $clientes = $this->Statistics_model->get_reporte_subdir_byasis($user)->result();
        }
        echo json_encode($clientes);
    }

    public function get_repo_dir_general()
    {
        $tipo = 0;
        $user = $this->session->userdata('id_usuario');

        if ($this->session->userdata('id_rol') == '1' || $this->session->userdata('id_rol') == '4' || $this->session->userdata('id_rol') == '10') {
            $clientes = $this->Statistics_model->get_reporte_dir_general($tipo)->result();
        } elseif ($this->session->userdata('id_rol') == '2') {
            $clientes = $this->Statistics_model->get_reporte_subdir_general($user, $tipo)->result();
        } else {
            $clientes = $this->Statistics_model->get_reporte_subdir_byasisgeneral($user, $tipo)->result();
        }


        echo json_encode($clientes);

    }

    public function get_repo_dir_byger()
    {
        $request = json_decode(file_get_contents("php://input"));
        $tipo = $request->tipo;
        $fecha_ini = date("Y/m/d", strtotime($request->fecha_ini));
        $fecha_fin = date("Y/m/d", strtotime($request->fecha_fin));
        $currentuser = $this->session->userdata('id_usuario');
        $gerente = $request->gerente;
        if ($tipo == "0" || $tipo == "1") {
            $clientes = $this->Statistics_model->get_repo_dir_byger1($gerente, $fecha_ini, $fecha_fin, $tipo)->result();
        } else {
            $clientes = $this->Statistics_model->get_repo_dir_byger($gerente, $fecha_ini, $fecha_fin)->result();
        }
        echo json_encode($clientes);

    }

    public function get_repo_dir_bycoord()
    {
        $request = json_decode(file_get_contents("php://input"));
        $tipo = $request->tipo;
        $coordinador = $request->coordinador;
        $fecha_ini = date("Y/m/d", strtotime($request->fecha_ini));
        $fecha_fin = date("Y/m/d", strtotime($request->fecha_fin));
        $currentuser = $this->session->userdata('id_usuario');
        $gerente = $request->gerente;
        if ($tipo == "0" || $tipo == "1") {
            $clientes = $this->Statistics_model->get_repo_dir_bycoord1($gerente, $coordinador, $fecha_ini, $fecha_fin, $tipo)->result();
        } else {
            $clientes = $this->Statistics_model->get_repo_dir_bycoord2($gerente, $coordinador, $fecha_ini, $fecha_fin)->result();
        }
        echo json_encode($clientes);

    }

    public function get_repo_dir_bysub()
    {
        $request = json_decode(file_get_contents("php://input"));
        $tipo = $request->tipo;
        $fecha_ini = date("Y/m/d", strtotime($request->fecha_ini));
        $fecha_fin = date("Y/m/d", strtotime($request->fecha_fin));
        $currentuser = $this->session->userdata('id_usuario');
        $subdir = $request->subdir;
        if ($tipo == "0" || $tipo == "1") {
            $clientes = $this->Statistics_model->get_repo_dir_bysub1($subdir, $fecha_ini, $fecha_fin, $tipo)->result();
        } else {
            $clientes = $this->Statistics_model->get_repo_dir_bysub($subdir, $fecha_ini, $fecha_fin)->result();
        }
        echo json_encode($clientes);

    }

    public function get_repo_dir_all()
    {
        $request = json_decode(file_get_contents("php://input"));
        $tipo = $request->tipo;
        $fecha_ini = date("Y/m/d", strtotime($request->fecha_ini));
        $fecha_fin = date("Y/m/d", strtotime($request->fecha_fin));
        if ($tipo == "0" || $tipo == "1") {
            $clientes = $this->Statistics_model->get_repo_dir_all($tipo, $fecha_ini, $fecha_fin)->result();
        } else {
            $clientes = $this->Statistics_model->get_repo_dirall($fecha_ini, $fecha_fin)->result();
        }
        echo json_encode($clientes);
    }

    public function get_repo_dir1()
    {
        $request = json_decode(file_get_contents("php://input"));
        $fecha_ini = date("Y/m/d", strtotime($request->fecha_ini));
        $fecha_fin = date("Y/m/d", strtotime($request->fecha_fin));
        $tipo = $request->tipo;
        $gerente = $request->gerente;
        $asesor = $request->asesor;
        $user = $this->session->userdata('id_usuario');


        if ($tipo == '2') {
            if ($this->session->userdata('id_rol') == '1' || $this->session->userdata('id_rol') == '4' || $this->session->userdata('id_rol') == '10') {
                $clientes = $this->Statistics_model->get_reporte_dir2($fecha_ini, $fecha_fin, $tipo, $asesor)->result();
            } elseif ($this->session->userdata('id_rol') == '2') {
                $clientes = $this->Statistics_model->get_reporte_subdir2($user, $fecha_ini, $fecha_fin, $tipo, $asesor)->result();
            } else {
                $clientes = $this->Statistics_model->get_reporte_subdir_byasis2($user, $fecha_ini, $fecha_fin, $tipo, $asesor)->result();
            }
        } else {
            if ($this->session->userdata('id_rol') == '1' || $this->session->userdata('id_rol') == '4' || $this->session->userdata('id_rol') == '10') {
                $clientes = $this->Statistics_model->get_reporte_dir1($fecha_ini, $fecha_fin, $tipo, $asesor)->result();
            } elseif ($this->session->userdata('id_rol') == '2') {
                $clientes = $this->Statistics_model->get_reporte_subdir1($user, $fecha_ini, $fecha_fin, $tipo, $asesor)->result();
            } else {
                $clientes = $this->Statistics_model->get_reporte_subdir_byasis1($user, $fecha_ini, $fecha_fin, $tipo, $asesor)->result();
            }
        }

        echo json_encode($clientes);
    }

    public function validateSession()
    {
        if($this->session->userdata('id_usuario')=="" || $this->session->userdata('id_rol')=="")
        {
            //echo "<script>console.log('No hay sesión iniciada');</script>";
            redirect(base_url() . "index.php/login");
        }
    }

    public function getDataAsesorGrafica($anio)
    {
        $data = $this->Statistics_model->getDataGraficaAnual($anio);
        echo json_encode($data);
    }

    public function getDataGraficaTopUsuarios($anio, $mes)
    {
        $data = $this->Statistics_model->getDataGraficaTopUsuarios($anio, $mes);
        echo json_encode($data);
    }

    public function getDataAsesorGraficaTabla($anio, $mes)
    {
        $data = $this->Statistics_model->getDataAsesorGraficaTabla($anio, $mes);
        foreach($data as &$user) {
            if (!isset($user['mes'])) {
                $user['mes'] = 0;
            }
        }
        echo json_encode($data);
    }
}




