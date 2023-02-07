<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Postventa extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Postventa_model', 'Documentacion_model', 'General_model'));
        $this->load->library(array('session', 'form_validation', 'get_menu', 'Jwt_actions','formatter'));
        $this->jwt_actions->authorize('2278',$_SERVER['HTTP_HOST']);
        $this->validateSession();
        date_default_timezone_set('America/Mexico_City');
    }

    public function index()
    {
        if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != '55' && $this->session->userdata('id_rol') != '56' && $this->session->userdata('id_rol') != '57' && $this->session->userdata('id_rol') != '13' && $this->session->userdata('id_rol') != '62')
            redirect(base_url() . 'login');
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        $this->load->view('template/header');
        $this->load->view('template/home', $datos);
        $this->load->view('template/footer');
    }

    public function validateSession()
    {
        if ($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "") {
            redirect(base_url() . "index.php/login");
        }
    }

    

    public function escrituracion()
    {
        if ($this->session->userdata('id_rol') == FALSE) {
            redirect(base_url());
        }
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        switch ($this->session->userdata('id_rol')) {
            case '55': // POSTVENTA
            case '56': // COMITÉ TÉCNICO
            case '57': // TITULACIÓN
                $this->load->view('template/header');
                $this->load->view("postventa/escrituracion", $datos);
                break;

            default:
                echo '<script>alert("ACCESSO DENEGADO"); window.location.href="' . base_url() . '";</script>';
                break;
        }
    }

    public function solicitudes_escrituracion()
    {
        if ($this->session->userdata('id_rol') == FALSE) {
            redirect(base_url());
        }
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
 
        switch ($this->session->userdata('id_rol')) {
            case '11': // ADMON
            case '17': // CONTRALORÍA corporativa
            case '55': // POSTVENTA
            case '56': // COMITÉ TÉCNICO
            case '57': // TITULACIÓN
            case '62': // PROYECTOS
                $this->load->view('template/header');
                $this->load->view("postventa/solicitudes_escrituracion", $datos);
                break;
            
            default:
                echo '<script>alert("ACCESSO DENEGADO"); window.location.href="' . base_url() . '";</script>';
                break;
        }
    }


    public function notaria(){
        if($this->session->userdata('id_rol') == FALSE){
            redirect(base_url());
        }
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        switch ($this->session->userdata('id_rol')){
            case '11': //ADMON
            case '17': //CONTRALORIA
            case '55': //POSTVENTA
            case '56': //COMITE TECNICO
            case '57': //TITULACION
            case '62': //Proyectos
            $this->load->view('template/header');
            $this->load->view("postventa/notaria", $datos);
            break;

            default:
                echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'"</script>';
                break;
        }

    }

    public function getProyectos()
    {
        $data = $this->Postventa_model->getProyectos()->result_array();
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    public function getCondominios()
    {
        $idResidencial = $this->input->post("idResidencial");
        $data = $this->Postventa_model->getCondominios($idResidencial)->result_array();
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());

    }

    public function getLotes()
    {
        $idCondominio = $this->input->post("idCondominio");
        $data = $this->Postventa_model->getLotes($idCondominio)->result_array();
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    public function getClient()
    {
        $idLote = $this->input->post("idLote");
        $data1 = $this->Postventa_model->getEmpRef($idLote)->result_array();
        $idClient = $this->Postventa_model->getClient($idLote);
        $idClient = empty($idClient) ? -1 : $idClient;
        $resDecode = $this->servicioPostventa($data1[0]['referencia'], $data1[0]['empresa']);
        // print_r(!empty($resDecode->data));
        if(!empty($resDecode->data)){
            $resDecode->data[0]->bandera_exist_cli = true;
        }else{
            $resDecode->data[0]= new \stdClass();
            $resDecode->data[0]->bandera_exist_cli = false;
        }
        if(is_object($idClient->row()) AND $idClient->row()->num_cli > 0){
            //$resDecode = $this->servicioPostventa($data1[0]['referencia'], $data1[0]['empresa']);
            if (count($resDecode->data) > 0 && $resDecode->data[0]->bandera_exist_cli == true) {
                $resDecode->data[0]->id_cliente = $idClient->row()->id_cliente;
                $resDecode->data[0]->referencia = $data1[0]['referencia'];
                $resDecode->data[0]->empresa = $data1[0]['empresa'];
                $resDecode->data[0]->personalidad = $idClient->row()->personalidad_juridica;
                $resDecode->data[0]->ocupacion = $idClient->row()->ocupacion;
                $resDecode->data[0]->regimen_matrimonial = $idClient->row()->regimen_matrimonial;
                $resDecode->data[0]->estado_civil = $idClient->row()->estado_civil;
                $resDecode->data[0]->nombre_juridica = $idClient->row()->nombre_juridica;
                echo json_encode($resDecode->data[0]);
            } else {
                $resDecode->data[0]->bandera_exist_cli = false;
                echo json_encode($resDecode->data[0]);
            }
        }else {
            $resDecode->data[0]->bandera_exist_cli = false;
            echo json_encode($resDecode->data[0]);
        }
    }

    public function printChecklist($data)
    {

        $this->load->library('Pdf');
        $pdf = new TCPDF('P', 'mm', 'LETTER', 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        // $pdf->SetAuthor('Sistemas Victor Manuel Sanchez Ramirez');
        $pdf->SetTitle('Documentos para Escrituración');
        $pdf->SetSubject('escrituracion (CRM)');
        $pdf->SetKeywords('CRM, escrituracion, PERSONAL, solicitud');
        // se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        // se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetAutoPageBreak(TRUE, 0);
        //relación utilizada para ajustar la conversión de los píxeles
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setPrintHeader(false);
        // $pdf->setPrintFooter();
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('Helvetica', '', 9, '', true);
        $pdf->SetMargins(7, 10, 10, true);
        $pdf->AddPage('P', 'LETTER');
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $bMargin = $pdf->getBreakMargin();
        $auto_page_break = $pdf->getAutoPageBreak();
        $pdf->Image('dist/img/ar4c.png', 120, 0, 300, 0, 'PNG', '', '', false, 150, '', false, false, 0, false, false, false);
        $pdf->setPageMark();

        $informacion = $this->Postventa_model->getClient($data)->row();
        $personalidad = $informacion->personalidad_juridica;
        $persona = $informacion->personalidad_juridica == 2 ? 'Persona Física':'Persona Moral';

        if($personalidad == 1){
            
            $Opcion10 = '<b>10) Constancia de no adeudo de agua </b><i>(No obligatorio).</i>';
            
            $tableFinal = '
            <table width="100%" style="padding:10px 0px; text-align: center;height: 45px; border: 1px solid #ddd;" width="690">
                <tr>
                    <td colspan="2" style="background-color: #15578B;color: #fff;padding: 3px 6px; "><b style="font-size: 1.5em; ">Datos del comprador – '.$persona.'</b></td>
                </tr>
            </table>
            <br>    
            <div class="row"> 
            <table width="100%" style="padding:10px 3px;height: 45px; border: 1px solid #ddd; text-align: center;" width="690">
                <tr>
                    <td style="font-size: 1em;"><b>Nombre completo:</b><br>'.$informacion->nombre.'</td>
                    <td style="font-size: 1em;"><b>Ocupación:</b><br>'.$informacion->ocupacion.'</td>
                    <td style="font-size: 1em;"><b>Lugar de origen:</b><br>'.$informacion->nacionalidad.'</td>
                </tr>
                <tr>
                    <td style="font-size: 1em;"><b>Domicilio actual:</b><br>'.$informacion->domicilio_particular.'</td>
                    <td style="font-size: 1em;"><b>Domicilio fiscal:</b><br>'.$informacion->domicilio_particular.'</td>
                    <td style="font-size: 1em;"><b>Personalidad jurídica:</b><br>'.$persona.'</td>
                </tr>
                <tr>
                    <td style="font-size: 1em;"><b>Estado civil:</b><br>'.$informacion->estado_civil.'</td>
                    <td style="font-size: 1em;"><b>Régimen conyugal:</b><br>'.$informacion->regimen_matrimonial.'</td>
                    <td style="font-size: 1em;"><b>RFC:</b><br>'.$informacion->rfc.'</td>
                </tr>
                <tr>
                    <td style="font-size: 1em;"><b>Teléfono (casa):</b><br>'.$informacion->telefono1.'</td>
                    <td style="font-size: 1em;"><b>Teléfono (celular):</b><br>'.$informacion->telefono2.'</td>
                    <td style="font-size: 1em;"><b>Correo electrónico:</b><br><center>'.$informacion->correo.'</center></td>
                </tr>
            </table>';

        }else{

            $Opcion10 = '<b>10) Acta constitutiva y poder notariado.</b>';

            $tableFinal = '
            <table width="100%" style="padding:10px 0px; text-align: center;height: 45px; border: 1px solid #ddd;" width="690">
                <tr>
                    <td colspan="2" style="background-color: #15578B;color: #fff;padding: 3px 6px; "><b style="font-size: 1.5em; ">Datos del comprador – '.$persona.'</b></td>
                </tr>
            </table>                            
            <br>
            <table width="100%" style="padding:10px 3px;height: 45px; border: 1px solid #ddd; text-align: center;" width="690">
            <tr>
                <td style="font-size: 1em;"><b>Razón social:</b><br>'.$informacion->nombre.'</td>
                <td style="font-size: 1em;"><b>RFC:</b><br>'.$informacion->rfc.'</td>
                <td style="font-size: 1em;"><b>Domicilio fiscal:</b><br>'.$informacion->domicilio_particular.'</td>
                </tr>
            <tr>
                <td style="font-size: 1em;"><b>Personalidad jurídica:</b><br>'.$persona.'</td>
                <td style="font-size: 1em;"><b>Teléfono(s):</b><br>'.$informacion->telefono1.' '.$informacion->telefono2.'</td>
                <td style="font-size: 1em;"><b>Correo electrónico:</b><br><center>'.$informacion->correo.'</center></td>
            </tr>
            </table>
            <br>
            
            <table width="100%" style="padding:10px 0px; text-align: center;height: 45px; border: 1px solid #ddd;" width="690">
                <tr>
                    <td colspan="2" style="background-color: #15578B;color: #fff;padding: 3px 6px; "><b style="font-size: 1.5em; ">Generales del Apoderado Legal</b></td>
                </tr>
            </table>                            
            <br>

            <table width="100%" style="padding:10px 3px;height: 45px; border: 1px solid #ddd; text-align: center;" width="690">
            <tr>
                <td style="font-size: 1em;"><b>Nombre completo:</b><br>'.$informacion->nombre.'</td>
                <td style="font-size: 1em;"><b>Ocupación:</b><br>'.$informacion->ocupacion.'</td>
                <td style="font-size: 1em;"><b>Lugar de origen:</b><br>'.$informacion->nacionalidad.'</td>
            </tr>
           
            </table>
            <br>';

        }

        $html = '
        <!DOCTYPE html>
            <html lang="es_mx"  ng-app="CRM">
                <head>
                    <style>
                    legend {
                        background-color: #296D5D;
                        color: #fff;
                    }           
                    </style>
                </head>
                <body>
                    <section class="content">
                        <div class="row">
                            <div class="col-xs-10 col-md-offset-1">
                                <div class="box">
                                    <div class="box-body">
                                        <table width="100%" style="height: 100px; border: 1px solid #ddd;" width="690">
                                            <tr>
                                                <td colspan="2" align="left"><img src="https://www.ciudadmaderas.com/assets/img/logo.png" style=" max-width: 70%; height: auto;"></td>
                                                <td colspan="2" align="right"><b style="font-size: 1.5em; "> Documentación para Escriturar<BR></b>
                                                </td>
                                            </tr>
                                        </table>
                                        <br>
                                       
                                        <div class="row">       
                                           '.$tableFinal.'
                                            
                                            <table width="100%" style="text-align: center;padding:10px;height: 45px; border-top: 1px solid #ddd;border-left: 1px solid #ddd;border-right: 1px solid #ddd;" width="690">
                                                <tr>
                                                    <td colspan="2" style="background-color: #15578B;color: #fff;padding: 3px 6px; "><b style="font-size: 1.5em; ">Documentos para Escrituración</b>
                                                    </td>
                                                </tr>
                                            </table>                            
                                            <br><br>
                                            <table width="100%" style="padding:10px 3px;height: 45px; border: 1px solid #ddd; text-align: left;" width="690">
                                                <tr>
                                                    <td colspan="1" style="font-size: 1em;border: 1px solid #ddd; text-align: center;"><b>Área</b></td>
                                                    <td colspan="4" style="font-size: 1em;border: 1px solid #ddd; text-align: center;"><b>Documento</b></td>
                                                    <td colspan="1" style="font-size: 1em;border: 1px solid #ddd; text-align: center;"><b>Estatus</b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="1" rowspan="10" style="font-size: 1em;border: 1px solid #ddd;text-align: center;align: middle;"><b>POSTVENTA</b></td>
                                                    <td colspan="4" style="font-size: 0.9em;border: 1px solid #ddd;"><b>1) Identificación oficial vigente</b>.</td>
                                                    <td colspan="1" style="font-size: 0.9em;border: 1px solid #ddd;"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="font-size: 0.9em;border: 1px solid #ddd;"><b>2) RFC </b><i>(Cédula o constancia de situación fiscal).</i></td>
                                                    <td colspan="1"style="font-size: 0.9em;border: 1px solid #ddd;"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="font-size: 0.9em;border: 1px solid #ddd;"><b>3) Comprobante de domicilio </b><i>(Luz, agua o telefonía fija con antigüedad menor a 2 meses).</i></td>
                                                    <td colspan="1"  style="font-size: 0.9em;border: 1px solid #ddd;"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="font-size: 0.9em;border: 1px solid #ddd;"><b>4) Acta de Nacimiento</b>.</td>
                                                    <td colspan="1" style="font-size: 0.9em;border: 1px solid #ddd;"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="font-size: 0.9em;border: 1px solid #ddd;"><b>5) Acta de Matrimonio </b><i>(No obligatorio).</i></td>
                                                    <td colspan="1"  style="font-size: 0.9em;border: 1px solid #ddd;"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="font-size: 0.9em;border: 1px solid #ddd;"><b>6) CURP </b><i>(Formato actualizado).</i></td>
                                                    <td colspan="1"  style="font-size: 0.9em;border: 1px solid #ddd;"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="font-size: 0.9em;border: 1px solid #ddd;"><b>7) Formas de pago <b style="color:red">*</b></b><i>(Todos los comprobantes de pagos a mensualidades / estados de cuenta bancarios).</i></td>
                                                    <td colspan="1"  style="font-size: 0.9em;border: 1px solid #ddd;"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="font-size: 0.9em;border: 1px solid #ddd;"><b>8) Boleta predial al corriente y pago retroactivo </b><i>(No obligatorio).</i></td>
                                                    <td colspan="1" style="font-size: 0.9em;border: 1px solid #ddd;"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="font-size: 0.9em;border: 1px solid #ddd;"><b>9) Constancia de no adeudo mantenimiento </b><i>(No obligatorio).</i></td>
                                                    <td colspan="1"  style="font-size: 0.9em;border: 1px solid #ddd;"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="font-size: 0.9em;border: 1px solid #ddd;">'.$Opcion10.'</td>
                                                    <td colspan="1"  style="font-size: 0.9em;border: 1px solid #ddd;"></td>                                                   
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                <body>
            </html>';

        $pdf->writeHTMLCell(0, 0, $x = '', $y = '1', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
        ob_end_clean();
        $pdf->Output(utf8_decode(" Documentación para Escriturar.pdf"), 'I');
    }

    // public function sendMail()
    // {
    //     $data = $_POST['data'];
    //     $this->load->library('email');
    //     $mail = $this->email;

    //     $mail->from('noreply@ciudadmaderas.com', 'Ciudad Maderas');

    //     $mail->to('programador.analista18@ciudadmaderas.com');
    //     $mail->Subject(utf8_decode("Documentos para Escrituración"));
    //     $mailContent = '
    //     <!DOCTYPE html>
    //         <html lang="es_mx"  ng-app="CRM">
    //             <head>
    //                 <style>
    //                 legend {
    //                     background-color: #296D5D;
    //                     color: #fff;
    //                 }           
    //                 </style>
    //             </head>
    //             <body>
    //                 <section class="content">
    //                     <div class="row">
    //                         <div class="col-xs-10 col-md-offset-1">
    //                             <div class="box">
    //                                 <div class="box-body">
    //                                     <table width="100%" style="height: 100px; border: 1px solid #ddd;" width="690">
    //                                         <tr>
    //                                             <td colspan="2" align="left"><img src="https://www.ciudadmaderas.com/assets/img/logo.png" style=" max-width: 70%; height: auto;"></td>
    //                                             <td colspan="2" align="right"><b style="font-size: 1.7em; "> Requisitos para Escrituración<BR></b>
    //                                             </td>
    //                                         </tr>
    //                                     </table>
    //                                     <br><br>
    //                                     <table width="100%" style="padding:10px 0px; text-align: center;height: 45px; border: 1px solid #ddd;" width="690">
    //                                         <tr>
    //                                             <td colspan="2" style="padding: 3px 6px; ">
    //                                                 <b style="font-size: .8em; ">
    //                                                     Estimado ' . $data['nombre'] . '<br>
    //                                                     En seguimiento a su visita en oficina de Ciudad Maderas Querétaro, envio la información para iniciar con el proceso de escrituración
    //                                                     como primer paso es la solicitud del presupuesto para conocer el monto a pagar por la escritura y asignar Notaria<br>
    //                                                     El presupuesto que envió es informativo, sin valor avalúo por parte del perito y es con el costo estimado, también aprovecho y envió el check list
    //                                                     en solicitud a la recepción de todos los documentos al momento de escriturar, estos documentos deben ser necesarios para efectuar la entrega del proyecto de escrituración 
    //                                                     con la Notaria:
    //                                                 </b>
    //                                             </td>
    //                                         </tr>
    //                                         <tr>
    //                                             <td colspan="2" style="background-color: #15578B;color: #fff;padding: 3px 6px; "><b style="font-size: 2em; ">Datos del comprador – Persona Física</b>
    //                                             </td>
    //                                         </tr>
    //                                     </table>                            
    //                                     <br>                       
    //                                     <div class="row">                
    //                                         <table width="100%" style="padding:10px 3px;height: 45px; border: 1px solid #ddd; text-align: center;" width="690">
    //                                             <tr>
    //                                                 <td style="font-size: 1em;">
    //                                                     <b>Nombre completo:</b><br>
    //                                                     ' . $data['nombre'] . '
    //                                                 </td>
    //                                                 <td style="font-size: 1em;">
    //                                                     <b>Ocupacíon:</b><br>
    //                                                     ' . $data['ocupacion'] . '
    //                                                 </td>
    //                                                 <td style="font-size: 1em;">
    //                                                     <b>Lugar de origen:</b><br>
    //                                                     ' . $data['origen'] . '
    //                                                 </td>
    //                                             </tr>
    //                                             <tr>
    //                                                 <td style="font-size: 1em;">
    //                                                     <b>Domicilio actual:</b><br>
    //                                                     ' . $data['direccionf'] . '
    //                                                 </td>
    //                                                 <td style="font-size: 1em;">
    //                                                     <b>Domicilio Fiscal:</b><br>
    //                                                     ' . $data['direccionf'] . '
    //                                                 </td>
    //                                             </tr>
    //                                             <tr>
    //                                                 <td style="font-size: 1em;">
    //                                                     <b>Estado civil:</b><br>
    //                                                     ' . $data['ecivil'] . '
    //                                                 </td>
    //                                                 <td style="font-size: 1em;">
    //                                                     <b>Régimen conyugal:</b><br>
    //                                                     ' . $data['rconyugal'] . '
    //                                                 </td>
    //                                                 <td style="font-size: 1em;">
    //                                                     <b>RFC:</b><br>
    //                                                     ' . $data['rfc'] . '
    //                                                 </td>
    //                                             </tr>
    //                                             <tr>
    //                                                 <td style="font-size: 1em;">
    //                                                     <b>Teléfono (casa):</b><br>
    //                                                     ' . $data['telefono'] . '
    //                                                 </td>
    //                                                 <td style="font-size: 1em;">
    //                                                     <b>Teléfono (celular):</b><br>
    //                                                     ' . $data['cel'] . '
    //                                                 </td>
    //                                                 <td style="font-size: 1em;">
    //                                                     <b>Correo electrónico:</b><br>
    //                                                     ' . $data['correo'] . '
    //                                                 </td>
    //                                             </tr>
    //                                         </table>
    //                                         <br>
    //                                         <br>
    //                                         <br>
    //                                         <table width="100%" style="text-align: center;padding:10px;height: 45px; border-top: 1px solid #ddd;border-left: 1px solid #ddd;border-right: 1px solid #ddd;" width="690">
    //                                             <tr>
    //                                                 <td colspan="2" style="background-color: #15578B;color: #fff;padding: 3px 6px; "><b style="font-size: 2em; ">Documentos para Escrituración</b>
    //                                                 </td>
    //                                             </tr>
    //                                         </table>                            
    //                                         <br><br>
    //                                         <table width="100%" style="padding:10px 3px;height: 45px; border: 1px solid #ddd; text-align: center;" width="690">
    //                                             <tr>
    //                                                 <td colspan="2" style="font-size: 1em;border: 1px solid #ddd;">
    //                                                     <b>Área</b>
    //                                                 </td>
    //                                                 <td colspan="3" style="font-size: 1em;border: 1px solid #ddd;">
    //                                                     <b>Documento</b>
    //                                                 </td>
    //                                                 <td colspan="1" style="font-size: 1em;border: 1px solid #ddd;">
    //                                                     <b>Estatus</b>
    //                                                 </td>
    //                                             </tr>
    //                                             <tr>
    //                                                 <td colspan="2" rowspan="10" style="font-size: 1em;border: 1px solid #ddd;text-align: left;left: middle;">
    //                                                     <b>POSTVENTA</b>
    //                                                 </td>
    //                                                 <td colspan="3" style="font-size: 0.9em;border: 1px solid #ddd;">
    //                                                     1) Identificación oficial vigente
    //                                                 </td>
    //                                                 <td colspan="1" style="font-size: 0.9em;border: 1px solid #ddd;">
    //                                                     <b></b>
    //                                                 </td>
    //                                             </tr>
    //                                             <tr>
    //                                                 <td colspan="3" style="font-size: 0.9em;border: 1px solid #ddd;">
    //                                                     2) RFC (Cédula o constancia de situación fiscal)
    //                                                 </td>
    //                                                 <td colspan="1"style="font-size: 0.9em;border: 1px solid #ddd;">
    //                                                     <b></b>
    //                                                 </td>
    //                                             </tr>
    //                                             <tr>
    //                                                 <td colspan="3" style="font-size: 0.9em;border: 1px solid #ddd;">
    //                                                     3) Comprobante de domicilio actual luz, agua o telefonia fija(antigüedad menor a 2 meses)
    //                                                 </td>
    //                                                 <td colspan="1"  style="font-size: 0.9em;border: 1px solid #ddd;">
    //                                                     <b></b>
    //                                                 </td>
    //                                             </tr>
    //                                             <tr>
    //                                                 <td colspan="3" style="font-size: 0.9em;border: 1px solid #ddd;">
    //                                                     4) Acta de nacimiento
    //                                                 </td>
    //                                                 <td colspan="1" style="font-size: 0.9em;border: 1px solid #ddd;">
    //                                                     <b></b>
    //                                                 </td>
    //                                             </tr>
    //                                             <tr>
    //                                                 <td colspan="3" style="font-size: 0.9em;border: 1px solid #ddd;">
    //                                                     5) Acta de matrimonio (en su caso).
    //                                                 </td>
    //                                                 <td colspan="1"  style="font-size: 0.9em;border: 1px solid #ddd;">
    //                                                     <b></b>
    //                                                 </td>
    //                                             </tr>
    //                                             <tr>
    //                                                 <td colspan="3" style="font-size: 0.9em;border: 1px solid #ddd;">
    //                                                     6) CURP (formato actualizado)
    //                                                 </td>
    //                                                 <td colspan="1"  style="font-size: 0.9em;border: 1px solid #ddd;">
    //                                                     <b></b>
    //                                                 </td>
    //                                             </tr>
    //                                             <tr>
    //                                                 <td colspan="3" style="font-size: 0.9em;border: 1px solid #ddd;">
    //                                                     7) Formas de pago (todos los comprobantes de pago a mensialidades / estados de cuenta bancarios)
    //                                                 </td>
    //                                                 <td colspan="1"  style="font-size: 0.9em;border: 1px solid #ddd;">
    //                                                     <b></b>
    //                                                 </td>
    //                                             </tr>
    //                                             <tr>
    //                                                 <td colspan="3" style="font-size: 0.9em;border: 1px solid #ddd;">
    //                                                     8) Boleta predial al corriente y comprobante de pago retroactivo (si aplica)
    //                                                 </td>
    //                                                 <td colspan="1" style="font-size: 0.9em;border: 1px solid #ddd;">
    //                                                     <b></b>
    //                                                 </td>
    //                                             </tr>
    //                                             <tr>
    //                                                 <td colspan="3" style="font-size: 0.9em;border: 1px solid #ddd;">
    //                                                     9) Constancia no adeudo mantenimiento (si aplica)
    //                                                 </td>
    //                                                 <td colspan="1"  style="font-size: 0.9em;border: 1px solid #ddd;">
    //                                                     <b></b>
    //                                                 </td>
    //                                             </tr>
    //                                             <tr>
    //                                                 <td colspan="3" style="font-size: 0.9em;border: 1px solid #ddd;">
    //                                                     10) Constancia no adeudo de agua (si aplica)
    //                                                 </td>
    //                                                 <td colspan="1"  style="font-size: 0.9em;border: 1px solid #ddd;">
    //                                                     <b></b>
    //                                                 </td>
    //                                             </tr>
    //                                         </table>
    //                                     </div>
    //                                 </div>
    //                             </div>
    //                         </div>
    //                     </div>
    //                 </section>
    //             <body>
    //         </html>';

    //     $mail->message($ );
    //     $response = $mail->send();
    //     echo json_encode($response);
    // }

    public function aportaciones()
    {
        $idLote = $_POST['idLote'];
        $idCliente = $_POST['idCliente'];
        $idPostventa = $_POST['idPostventa'];
        $referencia = $_POST['referencia'];
        $empresa = $_POST['empresa'];
        $personalidad = $_POST['perj'];
        $resDecode = $this->servicioPostventa($referencia, $empresa);
      //  print_r($resDecode->data[0]);
        $dataFiscal = array(
            "id_dpersonal" => $_POST['idPostventa'],
            "rfc" => $_POST['rfc'],
        );
        ($_POST['calleF'] == '' || $_POST['calleF'] == null) ? '': $dataFiscal['calle'] =  $_POST['calleF'];
        ($_POST['numExtF'] == '' || $_POST['numExtF'] == null) ? '': $dataFiscal['numext'] =  $_POST['numExtF'];
        ($_POST['numIntF'] == '' || $_POST['numIntF'] == null) ? '': $dataFiscal['numint'] =  $_POST['numIntF'];
        ($_POST['coloniaf'] == '' || $_POST['coloniaf'] == null) ? '': $dataFiscal['colonia'] =  $_POST['coloniaf'];
        ($_POST['municipiof'] == '' || $_POST['municipiof'] == null) ? '': $dataFiscal['municipio'] =  $_POST['municipiof'];
        ($_POST['estadof'] == '' || $_POST['estadof'] == null) ? '': $dataFiscal['estado'] =  $_POST['estadof'];
        ($_POST['cpf'] == '' || $_POST['cpf'] == null) ? '': $dataFiscal['cp'] =  $_POST['cpf'];
 
        $dataFiscal = base64_encode(json_encode($dataFiscal));
        $responseInsert = $this->insertPostventaDF($dataFiscal);
       // print_r($responseInsert);
        if($responseInsert->resultado == 1){
            
            $usuarioJuridico = $this->Postventa_model->obtenerJuridicoAsignacion();
            if (!$usuarioJuridico) {
                $this->Postventa_model->restablecerJuridicosAsignados();
                $usuarioJuridico = $this->Postventa_model->obtenerJuridicoAsignacion();
            }

            $this->Postventa_model->asignarJuridicoActivo($usuarioJuridico->id_usuario);
            // echo "Persona juridica dato".$personalidad."<br>";
            // echo "<br>";
            // echo $idLote;
            // echo "<br>";
            // echo $idCliente;
            // echo "<br>";
            // echo $idPostventa;
            // echo "<br>";
            // print_r($resDecode->data[0]);
            // echo "<br>";
            // echo $usuarioJuridico->id_usuario;
            // echo "<br>";
            $informacion = $this->Postventa_model->setEscrituracion( $personalidad, $idLote,$idCliente, $idPostventa,
                $resDecode->data[0], $usuarioJuridico->id_usuario);
            echo json_encode($informacion);
        }else{
            echo json_encode(false);
        }
    }

    public function AltaCli(){
        $data1 = $this->Postventa_model->getEmpRef($_POST['idLote'])->result_array();
        $_POST['referencia'] = $data1[0]['referencia'];
        $_POST['empresa'] = $data1[0]['empresa'];
        $result = $this->Postventa_model->InsertCli($_POST);
        $idLote = $_POST['idLote'];
        $idCliente = $result->ult_reg;
        $idPostventa = $_POST['idPostventa'];
        $referencia = $_POST['referencia'];
        $empresa = $_POST['empresa'];
        $personalidad = $_POST['perj'];
        $resDecode = $this->servicioPostventa($referencia, $empresa);
        $dataFiscal = array(
            "id_dpersonal" => $_POST['idPostventa'],
            "rfc" => $_POST['rfc'],
        );
        ($_POST['calleF'] == '' || $_POST['calleF'] == null) ? '': $dataFiscal['calle'] =  $_POST['calleF'];
        ($_POST['numExtF'] == '' || $_POST['numExtF'] == null) ? '': $dataFiscal['numext'] =  $_POST['numExtF'];
        ($_POST['numIntF'] == '' || $_POST['numIntF'] == null) ? '': $dataFiscal['numint'] =  $_POST['numIntF'];
        ($_POST['coloniaf'] == '' || $_POST['coloniaf'] == null) ? '': $dataFiscal['colonia'] =  $_POST['coloniaf'];
        ($_POST['municipiof'] == '' || $_POST['municipiof'] == null) ? '': $dataFiscal['municipio'] =  $_POST['municipiof'];
        ($_POST['estadof'] == '' || $_POST['estadof'] == null) ? '': $dataFiscal['estado'] =  $_POST['estadof'];
        ($_POST['cpf'] == '' || $_POST['cpf'] == null) ? '': $dataFiscal['cp'] =  $_POST['cpf'];
        $dataFiscal = base64_encode(json_encode($dataFiscal));
        $responseInsert = $this->insertPostventaDF($dataFiscal);
        if($responseInsert->resultado == 1){
            $usuarioJuridico = $this->Postventa_model->obtenerJuridicoAsignacion();
            // echo"Esto es lo que trae el usuario".$usuarioJuridico."<br>";
            if (!$usuarioJuridico) {
                $this->Postventa_model->restablecerJuridicosAsignados();
                $usuarioJuridico = $this->Postventa_model->obtenerJuridicoAsignacion();
            }

            $this->Postventa_model->asignarJuridicoActivo($usuarioJuridico->id_usuario);
            $personalidad = (!isset($personalidad) || $personalidad == '') ? 'NULL' : $personalidad;
            $idLote = (!isset($idLote) || $idLote == '') ? 'NULL' : $idLote;
            // echo "idLote:".$idLote."\n";
            $idCliente = (!isset($idCliente) || $idCliente == '') ? 'NULL' : $idCliente;
            //echo "idCliente:".$idCliente."\n";
            $idPostventa = (!isset($idPostventa) || $idPostventa == '') ? 'NULL' : $idPostventa;
            //echo "idPostVenta:".$idPostventa."\n";
            if(empty($resDecode->data[0])){
                $resDecode->data[0]["ncliente"] = $_POST['nombreComp'];
                $resDecode->data[0]["idECons;"] = 'NULL';
                $resDecode->data[0]["ClaveCat"] = 'NULL';
                $resDecode->data[0]["ult_ncliente"] = 'NULL';
                $resDecode->data[0]["ult_rfc"] = 'NULL';
                $resDecode->data[0]["idEstatus"] = $_POST['estatus'];

            }else {
                $resDecode->data[0]->ult_rfc = $resDecode->data[0]->rfc;
                $resDecode->data[0]->ult_ncliente = $resDecode->data[0]->ncliente;
                $resDecode->data[0]->ncliente = $_POST['nombreComp'];
                $resDecode->data[0]->idEstatus = $_POST['estatus'];
            }
            $informacion = $this->Postventa_model->setEscrituracion($personalidad,$idLote,$idCliente, $idPostventa, $resDecode->data[0], $usuarioJuridico->id_usuario);
            echo json_encode($informacion);
        }else{
            echo json_encode(false);
        }
        
    }

    public function getSolicitudes()
    {
        $beginDate = $this->input->post("beginDate") != 0 ?  date("Y-m-d", strtotime($this->input->post("beginDate"))) : 0;
        $endDate = $this->input->post("endDate") != 0 ? date("Y-m-d", strtotime($this->input->post("endDate"))) : 0;
        $estatus = $this->input->post("estatus");
        $tipo_tabla = $this->input->post("tipo_tabla");
        $v = strtotime($this->input->post("endDate"));
        $data['data'] = $this->Postventa_model->getSolicitudes($beginDate, $endDate, $estatus, $tipo_tabla)->result_array();
        if ($data != null) {
            echo json_encode($data, JSON_NUMERIC_CHECK);
        } else {
            echo json_encode(array());
        }
    }

    // Funciones para el apartado de notaria
    public function getNotarias() {
        $data['data'] = $this->Postventa_model->getNotarias()->result_array();
            if ($data != null) {
                    echo json_encode($data, JSON_NUMERIC_CHECK);
                } else {
                    echo json_encode(array());
            }
        }

    // Funcion para eliminar los registros de la tabla notaria
    public function updateNotarias(){

            $respuesta = $this->Postventa_model->updateNotarias($this->input->post("idNotaria"));
            echo json_encode($respuesta);

    }
    // Funcion para agregar a un nuevo notario
    public function insertNotaria(){

        $nombre_notaria = $this->input->post('notaria_nombre');
        $notario_nombre = $this->input->post('notario_nombre');
        $direccion = $this->input->post('direccion');
        $correo = $this->input->post('correo');
        $telefono = $this->input->post('telefono');
        $sede = $this->input->post('sede');

        $respuesta = $this->Postventa_model->insertNotaria($nombre_notaria, $notario_nombre, $direccion, $correo, $telefono, $sede);
        echo json_encode($respuesta);
    }

    public function listSedes()
    {
        echo json_encode($this->Postventa_model->listSedes()->result_array());
    }

    public function getDetalleNota($id_solicitud){
        echo json_encode($this->Postventa_model->getDetalleNota($id_solicitud)->result_array());
    }

    public function changeStatus()
    {
        $id_solicitud = $_POST['id_solicitud'];
        $type = $_POST['type'];

       /* if ($type == 1 || $type == 3 || $type == 4 || $type == 5) {
            $comentarios = $_POST['comentarios'];
            $informacion = $this->Postventa_model->changeStatus($id_solicitud, $type, $comentarios, 0);
        }elseif ($type == 2) {
            $motivos_rechazo = $_POST['comentarios'];
            $informacion = $this->Postventa_model->changeStatus($id_solicitud, $type, 'NULL', $motivos_rechazo);
        }*/
        $motivos_rechazo = $_POST['comentarios'];
        $area_rechazo = $_POST['area_rechazo'];

        $informacion = $this->Postventa_model->changeStatus($id_solicitud, $type, $motivos_rechazo,$area_rechazo);
        // }elseif($type == 3) {
        //     $comentarios = $_POST['comentarios'];
        //     $informacion = $this->Postventa_model->changeStatus($id_solicitud, $type, $comentarios, 0);
        // }

        echo json_encode($informacion);
    }

    public function uploadFile()
    {
        $file = $_FILES["uploadedDocument"];
        $idSolicitud = $this->input->post('idSolicitud');
        $documentType = $this->input->post('documentType');
        $presupuestoType = null;
        $idPresupuesto = null;
        $idNxS = null;
        if( $documentType == 13){
            $presupuestoType = $this->input->post('presupuestoType');
            $idPresupuesto = $this->input->post('idPresupuesto');
            $idNxS = $this->input->post('idNxS');
        }
        $documentName = $this->Postventa_model->generateFilename($idSolicitud, $documentType)->row();
        $documentInfo = $documentName;
        if($documentType == 13){
            $documentName = $documentName->fileName . '.' . $presupuestoType . '.' . substr(strrchr($_FILES["uploadedDocument"]["name"], '.'), 1);
        }else{
            /*if($documentInfo->estatus == 22){

            }else{

            }*/
            $documentName = $documentName->fileName . '.' . substr(strrchr($_FILES["uploadedDocument"]["name"], '.'), 1);
        }
        $folder = $this->getFolderFile($documentType);
        $this->updateDocumentBranch($file, $folder, $documentName, $idSolicitud, $documentType, $documentInfo->expediente, $documentInfo->idDocumento, $presupuestoType, $documentInfo->estatus_validacion, $idPresupuesto, $idNxS);
    }

    public function uploadFile2()
    {
        $file = $_FILES["uploadedDocument2"];
        // $idSolicitud = $this->input->post('idSolicitud');
        $idDocumento = $this->input->post('idDocumento');
        // $documentType = $this->input->post('documentType');
        $documentName = $this->Postventa_model->generateFilename2($idDocumento)->row();
        $documentInfo = $documentName;
        $documentName = $documentName->fileName . '.' . substr(strrchr($_FILES["uploadedDocument2"]["name"], '.'), 1);
        $folder = $this->getFolderFile($documentInfo->tipo_documento);
        $this->updateDocumentBranch($file, $folder, $documentName, $idSolicitud, $documentInfo->tipo_documento, $documentInfo->expediente, $documentInfo->idDocumento);
    }


    function getFolderFile($documentType)
    {
        switch ($documentType) {
            case 1:
                $folder = "static/documentos/postventa/escrituracion/INE/";
                break;
            case 2:
                $folder = "static/documentos/postventa/escrituracion/RFC/";
                break;
            case 3:
                $folder = "static/documentos/postventa/escrituracion/COMPROBANTE_DE_DOMICILIO/";
                break;
            case 4:
                $folder = "static/documentos/postventa/escrituracion/ACTA_DE_NACIMIENTO/";
                break;
            case 5:
                $folder = "static/documentos/postventa/escrituracion/ACTA_DE_MATRIMONIO/";
                break;
            case 6:
                $folder = "static/documentos/postventa/escrituracion/CURP/";
                break;
            case 7:
                $folder = "static/documentos/postventa/escrituracion/FORMAS_DE_PAGO/";
                break;
            case 8:
                $folder = "static/documentos/postventa/escrituracion/BOLETA_PREDIAL/";
                break;
            case 9:
                $folder = "static/documentos/postventa/escrituracion/CONSTANCIA_MANTENIMIENTO/";
                break;
            case 10:
                $folder = "static/documentos/postventa/escrituracion/CONSTANCIA_AGUA/";
                break;
            case 11:
                $folder = "static/documentos/postventa/escrituracion/SOLICITUD_PRESUPUESTO/";
                break;
            case 12:
                // antes fue 13
                $folder = "static/documentos/postventa/escrituracion/PRESUPUESTO/";
                break;
            case 13:
                // fue 15
                $folder = "static/documentos/postventa/escrituracion/FACTURA/";
                break;
            case 14:
                // fue 16
                $folder = "static/documentos/postventa/escrituracion/TESTIMONIO/";
                break;
            case 15:
                // fue la 17
                $folder = "static/documentos/postventa/escrituracion/PROYECTO_ESCRITURA/";
                break;
            case 18:
                $folder = "static/documentos/postventa/escrituracion/RFC_MORAL/";
                break;
            case 19:
                $folder = "static/documentos/postventa/escrituracion/ACTA_CONSTITUTIVA/";
                break;
            case 17:
                // fue 20
                $folder = "static/documentos/postventa/escrituracion/OTROS/";
                break;
            case 21:
                // fue 21
                $folder = "static/documentos/postventa/escrituracion/CONTRATO/";
                break;
            case 20:
                // fue 22
                $folder = "static/documentos/postventa/escrituracion/COPIA_CERTIFICADA/";
                break;
            case 23:
                $folder = "static/documentos/postventa/escrituracion/PRESUPUESTO_NOTARIA_EXTERNA/";
                break;  
        }
        return $folder;



    }

    function updateDocumentBranch($file, $folder, $documentName, $idSolicitud, $documentType, $exists, $idDocumento, $presupuestoType = null, $estatus_validacion = null, $idPresupuesto = null, $idNxS= null)
    {
        $movement = move_uploaded_file($file["tmp_name"], $folder . $documentName);
        $validateMovement = $movement == FALSE ? 0 : 1;
        if ($validateMovement == 1) {
            $idUsuario = $this->session->userdata('id_usuario');
            if($presupuestoType == null){
                if($estatus_validacion ==2){
                    $updateDocumentData = array(
                        "expediente" => $documentName,
                        "movimiento" => $documentName,
                        "modificado" => date('Y-m-d H:i:s'),
                        "idUsuario" => $idUsuario,
                        "modificado_por" => $idUsuario,
                        "status" => 1, 
                        "editado" => 1
                    );
                }else{
                    $updateDocumentData = array(
                        "expediente" => $documentName,
                        "movimiento" => $documentName,
                        "modificado" => date('Y-m-d H:i:s'),
                        "idUsuario" => $idUsuario,
                        "modificado_por" => $idUsuario,
                        "status" => 1
                    );
                }
               
                $response = $this->Postventa_model->replaceDocument($updateDocumentData, $idDocumento);
            }else{
                $updateDocumentData = array(
                    "expediente" => $documentName,
                    "modificado_por" => $idUsuario,
                    "idNotariaxSolicitud" => $idNxS
                );
                $response = $this->Postventa_model->addPresupuesto($updateDocumentData, $idSolicitud, $presupuestoType, $idPresupuesto);
            }
            echo json_encode($response);
        } else if ($exists == 99) {
            $idUsuario = $this->session->userdata('id_usuario');
            $updateDocumentData = array(
                "expediente" => $documentName,
                "movimiento" => $documentName,
                "modificado" => date('Y-m-d H:i:s'),
                "idUsuario" => $idUsuario,
                "modificado_por" => $idUsuario,
                "status" => 1
            );
            $response = $this->Postventa_model->replaceDocument($updateDocumentData, $idDocumento);
            echo json_encode($response);
        } else
            echo json_encode(2); // EL ARCHIVO NO SE PUDO MOVER
    }


    public function deleteFile()
    {
        $documentType = $this->input->post('documentType');
        $presupuestoType = null;
        $idSolicitud = $this->input->post('idSolicitud');
        $idDocumento = $this->input->post('idDocumento');

        if( $documentType == 13){
            $presupuestoType = $this->input->post('presupuestoType');
            $updateDocumentData = array(
                "expediente" => '',
                "modificado_por" => $this->session->userdata('id_usuario'),
            );
        }else{
            $updateDocumentData = array(
                "expediente" => null,
                "movimiento" => '',
                "modificado" => date('Y-m-d H:i:s'),
                "idUsuario" => $this->session->userdata('id_usuario'),
                "modificado_por" => $this->session->userdata('id_usuario'),
                "status" => 1
            );
        }
        $filename = $this->Postventa_model->getFilename($idDocumento, $documentType)->row()->expediente;
        $folder = $this->getFolderFile($documentType);
        $file = $folder . $filename;
        if (file_exists($file))
            unlink($file);
        $response = $this->Postventa_model->replaceDocument($updateDocumentData, $idDocumento, $documentType);
        echo json_encode($response);
        // FALTA ENVIAR EL CORREO CUANDO ES LA CORRIDA QUE SE ELIMINA
    }

    public function getMotivosRechazos()
    {
        $tipo_documento = $_POST['tipo_documento'];
        $estatus = $_POST['estatus'];
        $dataMotivos = $this->Postventa_model->getMotivosRechazos($tipo_documento);
        $dataEstatus = $this->Postventa_model->getStatusSiguiente($estatus);
        $data = array("dataMotivos" => $dataMotivos,
                     "dataEstatus" => $dataEstatus);
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    public function getDocumentsClient()
    {
        $idEscritura = $_POST['idEscritura'];
        $idEstatus = $_POST['idEstatus'];
        $notariaExterna = $this->Postventa_model->existNotariaExterna($idEscritura);
        $data = $this->Postventa_model->getDocumentsClient($idEscritura, $idEstatus, $notariaExterna);
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    public function getDocumentsClientOtros()
    {
        $idEscritura = $_POST['idEscritura'];
        $data = $this->Postventa_model->getDocumentsClientOtros($idEscritura);
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    public function getDocumentsClientPago()
    {
        $idEscritura = $_POST['idEscritura'];
        $data = $this->Postventa_model->getDocumentsClientPago($idEscritura);
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    // public function getNotarias()
    // {
    //     $data = $this->Postventa_model->getNotarias();
    //     if ($data != null)
    //         echo json_encode($data);
    //     else
    //         echo json_encode(array());
    // }

    public function getValuadores()
    {
        $data = $this->Postventa_model->getValuadores();
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }


    public function getNotaria()
    {
        $idNotaria = $_POST['idNotaria'];
        $data = $this->Postventa_model->getNotaria($idNotaria);
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    public function getValuador()
    {
        $idValuador = $_POST['idValuador'];
        $data = $this->Postventa_model->getValuador($idValuador);
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }


    public function getBudgetInfo()
    {
        $idSolicitud = $this->input->post('idSolicitud');
        $data = $this->Postventa_model->getBudgetInfo($idSolicitud)->row();
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    public function checkBudgetInfo()
    {
        $idSolicitud = $this->input->post('idSolicitud');
        $data = $this->Postventa_model->checkBudgetInfo($idSolicitud)->row();
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    public function savePresupuesto()
    {
        $data = $_POST;
      
        $id_solicitud = $data['id_solicitud3'];

        $updateData = array(
            "nombre_a_escriturar" => $data['nombrePresupuesto2'] == '' || $data['nombrePresupuesto2'] == null ? null : $data['nombrePresupuesto2'],
            "estatus_pago" => $data['estatusPago'],
            "superficie" => ($data['superficie'] == '' || $data['superficie'] == null) ? NULL : $data['superficie'],
            "clave_catastral" => ($data['catastral'] == '' || $data['catastral'] == null) ? NULL : $data['catastral'],
            //"cliente_anterior" =>($data['cliente'] == 'default' || $data['cliente'] == null ? 2 : $data['cliente'] == 'uno') ? 1 : 2,
            //"nombre_anterior" => $data['nombreT'] == '' || $data['nombreT'] == null || $data['nombreT'] == 'null' ? '' : $data['nombreT'],
            //"RFC" => $data['rfcDatos'] == '' || $data['rfcDatos'] == 'N/A' || $data['rfcDatos'] == 'null' ? NULL : $data['rfcDatos'],
            "tipo_escritura" => $data['tipoE'],
           // "aportacion" => $data['aportaciones'],
           // "descuento" => $data['descuentos'],
           // "motivo" => $data['motivo']
        );
        //($data['fechaCA2'] == '' || $data['fechaCA2'] == null || $data['fechaCA2'] == 'null' || $data['fechaCA2'] == 'NaN-NaN-NaN') ? '': $updateData['fecha_anterior'] =  $data['fechaCA2'];
        
        if($_POST['tipoNotaria'] == 1){
            $updateData['id_notaria'] = 0;
            $updateData['bandera_notaria'] = 1;
        }

        $data = $this->Postventa_model->updatePresupuesto($updateData, $id_solicitud);
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());

        if ($_POST['tipoNotaria'] == 2){
            $idSolicitud = $_POST['id_solicitud3'];
            $nombre_notaria = $_POST['nombre_notaria'];
            $nombre_notario = $_POST['nombre_notario'];
            $direccion = $_POST['direccion'];
            $correo = $_POST['correo'];
            $telefono = $_POST['telefono'];

            $informacion = $this->Postventa_model->asignarNotariaExterna($nombre_notaria, $nombre_notario, $direccion, $correo, $telefono, $id_solicitud);
          

            //$informacion = $this->Postventa_model->newNotaria($nombre_notaria, $nombre_notario, $direccion, $correo, $telefono, 0, 2);
            return $informacion;
    
            //return $this->Postventa_model->newNotaria($idSolicitud);
        } 

    }

    public function mailNotaria()
    {
        $idSolicitud = $_POST['idSolicitud'];

        $data = $this->Postventa_model->getInfoNotaria($idSolicitud)->result_array();
        $info = $this->Postventa_model->getInfoSolicitud($idSolicitud)->row();

        $this->load->library('email');
        $mail = $this->email;
        $mail->from('noreply@ciudadmaderas.com', 'Ciudad Maderas');
        $mail->to('programador.analista18@ciudadmaderas.com');
        $mail->Subject(utf8_decode("Expediente Cliente"));
        foreach ($data as $row) {
            $folder = $this->getFolderFile($row['tipo_documento']);
            // print_r($folder.$row['expediente']);
            // print_r(' / ');
            $this->email->attach($folder . $row['expediente']);
        }
        $mail->message('Buen día, se anexa documentación de completa para proceder con escrituración como compraventa del lote citado  al rubro a nombre de ' . $info->nombre_escrituras . ' existe dueño beneficiario, es la señora _____ pido de favor, en su caso, actualizar la cotizacion antes de  la firma, saludos cordiales.');
        $response = $mail->send();
        // echo $this->email->print_debugger();

        echo json_encode($response);
    }

    public function mailFecha()
    {
        $idSolicitud = $_POST['idSolicitud'];
        $data = $this->Postventa_model->getInfoSolicitud($idSolicitud)->row();
        $this->load->library('email');
        $mail = $this->email;
        $mail->from('noreply@ciudadmaderas.com', 'Ciudad Maderas');
        $mail->to('programador.analista18@ciudadmaderas.com');
        $mail->Subject(utf8_decode("Fecha Propuesta"));
        $mail->message('buenas tardes la fecha propuesta es: ' . $data->fechaFirma);
        $response = $mail->send();

        echo json_encode($response);
    }

    public function presupuestoPDF($data)
    {
        $this->load->library('Pdf');
        $pdf = new TCPDF('P', 'mm', 'LETTER', 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        // $pdf->SetAuthor('Sistemas Victor Manuel Sanchez Ramirez');
        $pdf->SetTitle('Presupuesto Escrituración.');
        $pdf->SetSubject('Escrituración (CRM)');
        $pdf->SetKeywords('CRM, escrituracion, PERSONAL, presupuesto');
        // se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        // se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetAutoPageBreak(TRUE, 0);
        //relación utilizada para ajustar la conversión de los píxeles
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setPrintHeader(false);
        // $pdf->setPrintFooter();
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('Helvetica', '', 9, '', true);
        $pdf->SetMargins(7, 3, 10, true);
        $pdf->AddPage('P', 'LEGAL');
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $bMargin = $pdf->getBreakMargin();
        $auto_page_break = $pdf->getAutoPageBreak();
        $pdf->Image('dist/img/ar4c.png', 120, 0, 300, 0, 'PNG', '', '', false, 150, '', false, false, 0, false, false, false);
        $pdf->setPageMark();

        $html = '
        <!DOCTYPE html>
            <html lang="es_mx"  ng-app="CRM">
                <head>
                    <style>
                    legend {
                        background-color: #296D5D;
                        color: #fff;
                    }           
                    </style>
                </head>
                <body>
                    <section class="content">
                    <div class="row">
                        <div class="col-xs-10 col-md-offset-1">
                            <div class="box">
                                <div class="box-body">
                                    <table width="100%" style="height: 80px; border: 1px solid #ddd;" width="690">
                                        <tr>
                                            <td colspan="2" align="left"><img src="https://www.ciudadmaderas.com/assets/img/logo.png" style=" max-width: 70%; height: auto;"></td>
                                            <td colspan="2" align="right"><b style="font-size: 1.7em; "> Solicitud de presupuesto<BR></b>
                                            </td>
                                        </tr>
                                    </table>
                                    <br><br>
                                    <table width="100%" style="padding:10px 0px; text-align: center;height: 35px; border: 1px solid #ddd;" width="690">
                                        <tr>
                                            <td colspan="2" style="background-color: #15578B;color: #fff;padding: 3px 6px; "><b style="font-size: 1.5em; ">' . $data->nombreResidencial . ' / ' . $data->nombreCond . ' / ' . $data->nombreLote . '</b>
                                            </td>
                                        </tr>
                                    </table>                            
                                    <br>                       
                                    <div class="row">                
                                        <table width="100%" style="padding:10px 3px;border: 1px solid #333; text-align: center;" width="690">
                                            <tr style="border: 1px solid #333;">
                                                <td style="font-size: 1em;width: 50%;border: 1px solid #333;background-color: #D9E1F2; vertical-align:middle;height:fit-content">
                                                    <div>Nombre del cliente:</div>
                                                </td>
                                                <td style="border: 1px solid #333;width: 50%;text-align: initial; display:flex; align-items: center;">
                                                    <div style ="width: 100%;border: 1px solid #F1F4FF;">' . $data->nombre . '</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 1em;width: 50%;border: 1px solid #333;background-color: #D9E1F2; vertical-align:middle;height:fit-content">
                                                    <div>Tipo de escrituración:</div>
                                                </td>
                                                <td style="border: 1px solid #333;width: 50%;text-align: initial; display:flex; align-items: center;">
                                                    <div style ="width: 100%;border: 1px solid #F1F4FF;">' . $data->nombre_escrituras . '</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 1em;width: 50%;border: 1px solid #333;background-color: #D9E1F2; vertical-align:middle;height:fit-content">
                                                    <div>Estatus de pago:</div>
                                                </td>
                                                <td style="border: 1px solid #333;width: 50%;text-align: initial; display:flex; align-items: center;">
                                                    <div style ="width: 100%;border: 1px solid #F1F4FF;">' . $data->estatus_pago . '</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 1em;width: 50%;border: 1px solid #333;background-color: #D9E1F2; vertical-align:middle;height:fit-content">
                                                    <div>Valor de operación (descontando bonificaciones y/o descuentos) de pago:</div>
                                                </td>
                                                <td style="border: 1px solid #333;width: 50%;text-align: initial; display:flex; align-items: center;">
                                                    <div style ="width: 100%;border: 1px solid #F1F4FF;">esta cantidad debe venir de postventa</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 1em;width: 50%;border: 1px solid #333;background-color: #D9E1F2; vertical-align:middle;height:fit-content">
                                                    <div>Superficie:</div>
                                                </td>
                                                <td style="border: 1px solid #333;width: 50%;text-align: initial; display:flex; align-items: center;">
                                                    <div style ="width: 100%;border: 1px solid #F1F4FF;">' . $data->superficie . '</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 1em;width: 50%;border: 1px solid #333;background-color: #D9E1F2; vertical-align:middle;height:fit-content">
                                                    <div>Fecha de contrato:</div>
                                                </td>
                                                <td style="border: 1px solid #333;width: 50%;text-align: initial; display:flex; align-items: center;">
                                                    <div style ="width: 100%;border: 1px solid #F1F4FF;">Fecha de contrato se consigue de postventa</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 1em;width: 50%;border: 1px solid #333;background-color: #D9E1F2; vertical-align:middle;height:fit-content">
                                                    <div>Clave catastral:</div>
                                                </td>
                                                <td style="border: 1px solid #333;width: 50%;text-align: initial; display:flex; align-items: center;">
                                                    <div style ="width: 100%;border: 1px solid #F1F4FF;">' . $data->clave_catastral . '</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 1em;width: 50%;border: 1px solid #333;background-color: #D9E1F2; vertical-align:middle;height:fit-content">
                                                    <div>Estatus construcción:</div>
                                                </td>
                                                <td style="border: 1px solid #333;width: 50%;text-align: initial; display:flex; align-items: center;">
                                                    <div style ="width: 100%;border: 1px solid #F1F4FF;">' . $data->estatus_construccion . '</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 1em;width: 50%;border: 1px solid #333;background-color: #D9E1F2; vertical-align:middle;height:fit-content">
                                                    <div>¿Tenemos cliente anterior (traspaso, cesión o segunda venta)?:</div>
                                                </td>
                                                <td style="border: 1px solid #333;width: 50%;text-align: initial; display:flex; align-items: center;">
                                                    <div style ="width: 100%;border: 1px solid #F1F4FF;">' . $data->cliente_anterior . '</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 1em;width: 100%;border: 1px solid #333;background-color: #D9E1F2; vertical-align:middle;height:fit-content">
                                                <div>En caso de ser positivo la respuesta anterior. Llenar lo siguiente:</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 1em;width: 50%;border: 1px solid #333;background-color: #D9E1F2; vertical-align:middle;height:fit-content">
                                                    <div>Nombre del titular anterior:</div>
                                                </td>
                                                <td style="border: 1px solid #333;width: 50%;text-align: initial; display:flex; align-items: center;">
                                                    <div style ="width: 100%;border: 1px solid #F1F4FF;">' . ($data->cliente_anterior == 1 ? $data->nombre_anterior : ' ') . '</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 1em;width: 50%;border: 1px solid #333;background-color: #D9E1F2; vertical-align:middle;height:fit-content">
                                                    <div>Fecha del contrato anterior:</div>
                                                </td>
                                                <td style="border: 1px solid #333;width: 50%;text-align: initial; display:flex; align-items: center;">
                                                    <div style ="width: 100%;border: 1px solid #F1F4FF;">' . ($data->cliente_anterior == 1 ? $data->fecha_anterior : ' ') . '</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 1em;width: 50%;border: 1px solid #333;background-color: #D9E1F2; vertical-align:middle;height:fit-content">
                                                    <div>¿Factura con RFC genérico o datos personales?:</div>
                                                </td>
                                                <td style="border: 1px solid #333;width: 50%;text-align: initial; display:flex; align-items: center;">
                                                    <div style ="width: 100%;border: 1px solid #F1F4FF;">' . ($data->cliente_anterior == 1 ? $data->RFC : ' ') . '</div>
                                                </td>
                                            </tr>
                                        </table>
                                        <br></br>
                                        <p style="line-height: 0.5;color:#FF6161">* Opciones: liquidado o pendiente. En ambos casos revisar con anticipación si aplicaron bonificaciones o descuentos.</p>
                                        <p style="line-height: 1;color:#FF6161">** Revisión de superficie en contrato, declaratoria y física con comité técnico para cotejar cuál es la real. En caso de que aplique hacer la observación en cuerpo del correo de la diferencia en superficie y plasmar en cuadro de datos la real.</p>
                                        <p style="line-height: 0.5;color:#FF6161">*** Confirmar con comité técnico de construcción estatus del lote.</p>
                                        <p style="line-height: 0.5;color:#FF6161">**** Indicar si el lote viene de un traspaso, cesión de derechos o segunda venta (liberado de jurídico y se vende nuevamente).</p>
                                        <p style="line-height: 0.5;color:#FF6161">Fecha límite para recepción de presupuesto: (3 días hábiles).</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <body>
            </html>';

        $pdf->writeHTMLCell(0, 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);

        $pdf->Output(__DIR__ . "/../../static/documentos/postventa/escrituracion/SOLICITUD_PRESUPUESTO/solicitud_".$data->nombre_escrituras."_presupuesto.pdf", 'F');

        // $pdf->Output(utf8_decode('Hola.pdf'), 'I');
    }

    public function mailPresupuesto()
    {
        $idSolicitud = $_POST['idSolicitud'];
        $idNotaria = $_POST['notaria'];
        $idValuador = $_POST['valuador'];

        $this->load->library('email');
        $mail = $this->email;
        $insert = $this->Postventa_model->insertNotariaValuador($idNotaria, $idValuador, $idSolicitud);
        $data = $this->Postventa_model->checkBudgetInfo($idSolicitud)->row();

        $documentName = $this->Postventa_model->getFileNameByDoctype($idSolicitud,11)->row();
        //correos
        //$data->correoN correos de la notaria
        //$data->correoV correos del valuador
        $this->presupuestoPDF($data);

        $mail->from('noreply@ciudadmaderas.com', 'Ciudad Maderas');
        $mail->to('programador.analista18@ciudadmaderas.com');
        $mail->Subject(utf8_decode("Solicitud de presupuesto y valores"));
        $mail->message('Buen dia me apoyan con el pre-avaluo con valor actual y referido  del lote que se menciona en la tabla que se anexa ?');
        $this->email->attach(__DIR__ . "/../../static/documentos/postventa/escrituracion/SOLICITUD_PRESUPUESTO/".$documentName->expediente);

        $response = $mail->send();
        // echo $this->email->print_debugger();

        echo json_encode($response);
    }

    public function presupuestoCliente()
    {
        $idSolicitud = $_POST['idSolicitud'];
        $this->load->library('email');
        $mail = $this->email;
        $data = $this->Postventa_model->checkBudgetInfo($idSolicitud)->row();
        $mail->from('noreply@ciudadmaderas.com', 'Ciudad Maderas');
        $mail->to('programador.analista18@ciudadmaderas.com');
        $mail->Subject(utf8_decode("Presupuesto escrituracion"));
        // $mail->message('');

        $doc = $this->getFileNameByDoctype($idSolicitud, 13);
        $this->email->attach(__DIR__ . "/../../static/documentos/postventa/escrituracion/PRESUPUESTO/" . $doc->expediente);

        $response = $mail->send();

        echo json_encode($response);
    }

    public function pdfPresupuesto($idSolicitud)
    {

        $this->load->library('Pdf');
        $pdf = new TCPDF('P', 'mm', 'LETTER', 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        // $pdf->SetAuthor('Sistemas Victor Manuel Sanchez Ramirez');
        $pdf->SetTitle('Presupuesto Escrituracion.');
        $pdf->SetSubject('Escrituracion (CRM)');
        $pdf->SetKeywords('CRM, escrituracion, PERSONAL, presupuesto');
        // se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        // se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetAutoPageBreak(TRUE, 0);
        //relación utilizada para ajustar la conversión de los píxeles
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setPrintHeader(false);
        // $pdf->setPrintFooter();
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('Helvetica', '', 9, '', true);
        $pdf->SetMargins(7, 10, 10, true);
        $pdf->AddPage('P', 'LETTER');
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $bMargin = $pdf->getBreakMargin();
        $auto_page_break = $pdf->getAutoPageBreak();
        $pdf->Image('dist/img/ar4c.png', 120, 0, 300, 0, 'PNG', '', '', false, 150, '', false, false, 0, false, false, false);
        $pdf->setPageMark();

        $data = $this->Postventa_model->checkBudgetInfo($idSolicitud)->row();


        $html = '
        <!DOCTYPE html>
            <html lang="es_mx"  ng-app="CRM">
                <head>
                    <style>
                    legend {
                        background-color: #296D5D;
                        color: #fff;
                    }           
                    </style>
                </head>
                <body>
                    <section class="content">
                    <div class="row">
                        <div class="col-xs-10 col-md-offset-1">
                            <div class="box">
                                <div class="box-body">
                                    <table width="100%" style="height: 100px; border: 1px solid #ddd;" width="690">
                                        <tr>
                                            <td colspan="2" align="left"><img src="https://www.ciudadmaderas.com/assets/img/logo.png" style=" max-width: 70%; height: auto;"></td>
                                            <td colspan="2" align="right"><b style="font-size: 1.7em; "> Solicitud de presupuesto<BR></b>
                                            </td>
                                        </tr>
                                    </table>
                                    <br><br>
                                    <table width="100%" style="padding:10px 0px; text-align: center;height: 45px; border: 1px solid #ddd;" width="690">
                                        <tr>
                                            <td colspan="2" style="background-color: #15578B;color: #fff;padding: 3px 6px; "><b style="font-size: 2em; ">Datos del comprador – Persona Física</b>
                                            </td>
                                        </tr>
                                    </table>                            
                                    <br>                       
                                    <div class="row">                
                                        <table width="100%" style="padding:10px 3px;height: 45px; border: 1px solid #ddd; text-align: center;" width="690">
                                            <tr>
                                                <td style="font-size: 1em;">
                                                    <b>Nombre del cliente:</b><br>
                                                    ' . $data->nombre . '
                                                </td>
                                                <td style="font-size: 1em;">
                                                    <b>Nombre a quien escritura:</b><br>
                                                    ' . $data->nombre_a_escriturar . '
                                                </td>
                                                <td style="font-size: 1em;">
                                                    <b>Tipo de escrituración:</b><br>
                                                    ' . $data->tipoEscritura . '
                                                </td>
                                                <td style="font-size: 1em;">
                                                    <b>Estatus de pago:</b><br>
                                                    ' . $data->nombrePago . '
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 1em;">
                                                    <b>Valor de operación (descontando bonificaciones y/o descuentos):</b><br>
                                                    
                                                </td>
                                                <td style="font-size: 1em;">
                                                    <b>Superficie:</b><br>
                                                    ' . $data->superficie . '
                                                </td>
                                                <td style="font-size: 1em;">
                                                    <b>Aportaciones:</b><br>
                                                    $'.number_format($data->aportacion, 2, '.', '').'
                                                </td>
                                                <td style="font-size: 1em;">
                                                    <b>Descuentos:</b><br>
                                                    $'.number_format($data->descuento, 2, '.', '').'
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 1em;">
                                                    <b>Fecha de contrato:</b><br>
                                                    ' . $data->modificado . '
                                                </td>
                                                <td style="font-size: 1em;">
                                                    <b>Clave catastral:</b><br>
                                                    ' . $data->clave_catastral . '
                                                </td>
                                                <td style="font-size: 1em;">
                                                    <b>Estatus construcción:</b><br>
                                                    ' . $data->nombreConst . '
                                                </td>
                                                <td style="font-size: 1em;">
                                                <b>Motivo:</b><br>
                                                ' . $data->motivo . '
                                            </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 1em;">
                                                    <b>¿Tenemos cliente anterior (traspaso, cesión o segunda venta)?:</b><br>
                                                    ' . ($data->cliente_anterior == 1 ? 'Si':'NO') . '
                                                </td>
                                            </tr>
                                        </table>
                                    </div>';
                                            if($data->cliente_anterior == 1){
                                                $html .= '
                                                <div class="row">                
                                                    <table width="100%" style="padding:10px 3px;height: 45px; border: 1px solid #ddd; text-align: center;" width="690">
                                                        <tr>
                                                            <td style="font-size: 1em;">
                                                                <b>Nombre del titular anterior:</b><br>
                                                                ' . $data->nombre_anterior . '
                                                            </td>
                                                            <td style="font-size: 1em;">
                                                                <b>Fecha contrato anterior:</b><br>
                                                                ' . $data->fecha_anterior . '
                                                            </td>
                                                            <td style="font-size: 1em;">
                                                                <b>RFC del titular anterior:</b><br>
                                                                ' . $data->RFC . '
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                ';
                                            }

                                            if($data->pertenece == 2){
                                                $html .= '
                                                <div class="row">
                                                    <table width="100%" style="padding:10px 3px;height: 45px; border: 1px solid #ddd; text-aling: center;" width="690">
                                                        <tr>
                                                            <td style="font-size: 1em;">
                                                                <b>Nombre de la Notaría</b><br>
                                                                ' . $data->nombre_notaria . '
                                                            </td>
                                                            <td style="font-size: 1em;">
                                                                <b>Nombre del notario</b><br>
                                                                ' . $data->nombre_notario . ' 
                                                            </td>
                                                            <td style="font-size: 1em;">
                                                                <b>Correo</b><br>
                                                                ' . $data->correo . '
                                                            </td>
                                                            <td style="font-size: 1em;">
                                                                <b>Teléfono</b><br>
                                                                ' . $data->telefono . '
                                                            </td>
                                                            <td style="font-size: 1em;">
                                                                <b>Dirección</b><br>
                                                                ' . $data->direccion . '
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                ';
                                            }
            $html .= '
                                        
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <body>
            </html>';

        $pdf->writeHTMLCell(0, 0, $x = '', $y = '1', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
        ob_end_clean();
        $documentInfo = $this->Postventa_model->generateFilename($idSolicitud, 11)->row();
        $documentName = $documentInfo->fileName . ".pdf";
        $folder = $this->getFolderFile(11);
        $pdf->Output(__DIR__ . "/../../" . $folder . utf8_decode($documentName), 'F');

        $pdf->Output(utf8_decode($documentName), 'I');

        $this->updateDocumentBranch($file, $folder, $documentName, $idSolicitud, 11, 99, $documentInfo->idDocumento);


    }

    public function saveDate()
    {
        // $signDate = date("Y-m-d", strtotime($_POST['signDate']));
        // print_r($signDate);
        $idSolicitud = $_POST['idSolicitud'];
        $response = $this->Postventa_model->saveDate($_POST['signDate'], $idSolicitud);
        echo json_encode($response);
    }

    public function getFileNameByDoctype($idSolicitud, $docType)
    {
        $document = $this->Postventa_model->getFileNameByDoctype($idSolicitud, $docType)->row();
        return $document;
    }

    public function validateFile()
    {
        $idDocumento = $this->input->post('idDocumento');
        $idSolicitud = $this->input->post('idSolicitud');
        $documentType = $this->input->post('documentType');
        $action = $this->input->post('action');
        if ($action == 4) {
            $rejectionReasons = explode(",", $this->input->post('rejectionReasons'));
            for ($i = 0; $i < count($rejectionReasons); $i++) {
                $insertData[$i] = array(
                    "id_motivo" => $rejectionReasons[$i],
                    "id_documento" => $idDocumento,
                    "tipo" => $documentType,
                    "tipo_proceso" => 2,
                    "creado_por" => $this->session->userdata('id_usuario')
                );
            }
        }
        $rejectionReasonsList = $this->Documentacion_model->getRejectReasonsTwo($idDocumento, $idSolicitud, $documentType)->result_array(); // MJ: LLEVA 3 PARÁMETROS $idDocumento, $idSolicitud, $documentType
        if (count($rejectionReasonsList) >= 1) { // SÍ ENCONTRÓ REGISTROS
            for ($r = 0; $r < count($rejectionReasonsList); $r++) {
                $updateArrayData[] = array(
                    'id_mrxdoc' => $rejectionReasonsList[$r]["id_mrxdoc"],
                    'estatus' => 0
                );
            }
            $this->General_model->updateBatch("motivos_rechazo_x_documento", $updateArrayData, "id_mrxdoc"); // MJ: SE MANDA CORRER EL UPDATE BATCH
        }
        $updateData = array("estatus_validacion" => $action == 4 ? 2 : 1, "validado_por" => $this->session->userdata('id_usuario'));
        $updateResponse = $this->General_model->updateRecord("documentos_escrituracion", $updateData, "idDocumento", $idDocumento); // MJ: LLEVA 4 PARÁMETROS $table, $data, $key, $value
        if ($action == 4) {
            $insertResponse = $this->General_model->insertBatch("motivos_rechazo_x_documento", $insertData);
            echo json_encode(($updateResponse == 1 && $insertResponse == 1) == TRUE ? 1 : 0);
        } else
            echo json_encode($updateResponse == 1 ? 1 : 0);
    }

    public function getEstatusConstruccion()
    {
        $data = $this->Postventa_model->getEstatusConstruccion();
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    public function getEstatusPago()
    {
        $data = $this->Postventa_model->getEstatusPago();
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    //NOTARIA
    public function registrarNotaria()
    {
        $id_solicitud = $_POST['id_solicitud'];
        $tipoNotaria =  $_POST['tipo_notaria'];
        $nombre_notaria = $_POST['nombre_notaria'];
        $nombre_notario = $_POST['nombre_notario'];
        $direccion = $_POST['direccion'];
        $correo = $_POST['correo'];
        $telefono = $_POST['telefono'];

        if($tipoNotaria == 2){
            $response = $this->Postventa_model->asignarNotariaExterna($nombre_notaria, $nombre_notario, $direccion, $correo, $telefono, $id_solicitud);
        }else{
            $response = $this->Postventa_model->asignarNotariaInterna($id_solicitud);
            
        }
        echo json_encode( array( "data" => $response));
    }

    public function getBudgetNotaria()
    {
        $idSolicitud = $_GET['idSolicitud'];

        $data = $this->Postventa_model->getNotariaClient($idSolicitud)->row();

        if($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }
    function getStatusSiguiente(){
        $actividad = $_POST['actividad'];
        $tipo = $_POST['tipo'];
        $estatus = $_POST['estatus'];
        $data = $this->Postventa_model->getStatusSiguiente($actividad,$tipo,$estatus)->row();
        if($data != null)
        echo json_encode($data);
    else
        echo json_encode(array());
    }

    public function rechazarNotaria()
    {
        $idSolicitud = $_POST['idSolicitud'];
        $rol = $this->session->userdata('id_rol');

        $estatus = $this->db->query("SELECT estatus FROM solicitud_escrituracion WHERE idSolicitud = $idSolicitud")->row()->estatus;

        if($estatus == 5){
            $informacion = $this->Postventa_model->rechazarNotaria5($idSolicitud);
            return $informacion;

            return $this->Postventa_model->rechazarNotaria5($idSolicitud, $rol);
        } else if($estatus == 11){
            $informacion = $this->Postventa_model->rechazarNotaria($idSolicitud);
            return $informacion;

            return $this->Postventa_model->rechazarNotaria($idSolicitud, $rol);
        }

        
    }

    //OBSERVACIONES
    public function observacionesPostventa()
    {
        $idSolicitud = $_POST['idSolicitud'];
        $rol = $this->session->userdata('id_rol');

        // $informacion = $this->Postventa_model->updateObservacionesPostventa($idSolicitud);
        // return $informacion;

        return $this->Postventa_model->updateObservacionesPostventa($idSolicitud, $rol);
    }

    public function observacionesProyectos()
    {
        $idSolicitud = $_POST['idSolicitud'];
        $rol = $this->session->userdata('id_rol');

        return $this->Postventa_model->updateObservacionesProyectos($idSolicitud, $rol);
    }

    public function mailObservaciones()
    {
        $idSolicitud = $_POST['idSolicitud'];
        $observaciones = $_POST['observaciones'];
        
        $this->load->library('email');
        $mail = $this->email;
        $mail->from('noreply@ciudadmaderas.com', 'Ciudad Maderas');
        $mail->to('programador.analista21@ciudadmaderas.com');
        $mail->Subject(utf8_decode("Observaciones Notaria"));
        $mail->message('Buen día! Las observaciones que la notaria envío sobre la solicitud: ' . $idSolicitud . ' son: ' . $observaciones);
        $response = $mail->send();
        echo json_encode($response);
    }

    public function saveEstatusLote()
    {
        $data = $_POST;
      
        $id_solicitud = $data['id_solicitudEstatus'];

        $updateData = array(
            "estatus_construccion" => $data['construccion']
        );

        $data = $this->Postventa_model->saveEstatusLote($updateData, $id_solicitud);
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    public function getPresupuestos(){
        $idSolicitud = $_POST['idEscritura'];
        $data = $this->Postventa_model->getPresupuestos($idSolicitud)->result();
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    public function approvePresupuesto(){
        $data = $_POST;
        $response = $this->Postventa_model->approvePresupuesto($data);
        if ($response != null)
            echo json_encode(1);
        else
            echo json_encode(0);
    }

    public function reportes()
    {
        if ($this->session->userdata('id_rol') == FALSE) {
            redirect(base_url());
        }
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        switch ($this->session->userdata('id_rol')) {
            case '17': // CONTRALORIA
            case '55': // POSTVENTA
            case '57': // TITULACIÓN
                $this->load->view('template/header');
                $this->load->view("postventa/Reportes/reportes", $datos);
                break;

            default:
                echo '<script>alert("ACCESSO DENEGADO"); window.location.href="' . base_url() . '";</script>';
                break;
        }
    }

    function getData(){
        $data = $this->Postventa_model->getData_contraloria()->result();
        switch ($this->session->userdata('id_rol')){
            case '17': //CONTRALORIA 
                $columns = array(
                    [
                        "title" => 'ID',
                        "data" => 'idSolicitud'
                    ],
                    [
                        "title" => 'Lote',
                        "data" => 'nombreLote'
                    ],
                    [
                        "title" => 'Condominio',
                        "data" => 'nombreCondominio'
                    ],
                    [
                        "title" => 'Residencial',
                        "data" => 'nombreResidencial'
                    ],
                    [
                        "title" => 'Cliente',
                        "data" => 'nombre'
                    ],
                    [
                        "title" => 'Estatus',
                        "data" => 'estatus'
                    ],
                    [
                        "title" => 'Área',
                        "data" => 'area'
                    ],
                    [
                        "title" => 'Vigencia',
                        "data" => 'atrasado'
                    ],
                    [
                        "title" => 'Dias de atraso',
                        "data" => 'diferencia'
                    ],
                    [
                        "title" => 'Fecha del estatus',
                        "data" => 'fecha_creacion'
                    ],
                );
            break;

            case 55: //POSTVENTA
                $columns = array(
                    [
                        "title" => 'ID',
                        "data" => 'idSolicitud'
                    ],
                    [
                        "title" => 'Lote',
                        "data" => 'nombreLote'
                    ],
                    [
                        "title" => 'Condominio',
                        "data" => 'nombreCondominio' 
                    ],
                    [
                        "title" => 'Residencial',
                        "data" => 'nombreResidencial'
                    ],
                    [
                        "title" => 'Cliente',
                        "data" => 'nombre'
                    ],
                    [
                        "title" => 'Estatus',
                        "data" => 'estatus'
                    ],
                    [
                        "title" => 'Área',
                        "data" => 'area'
                    ],
                    [
                        "title" => 'Vigencia',
                        "data" => 'atrasado'
                    ],
                    [
                        "title" => 'Días de atraso',
                        "data" => 'diferencia'
                    ],
                    [
                        "title" => 'Fecha del estatus',
                        "data" => 'fecha_creacion'
                    ]
                );
            break;

            case 57: //TITULACION
                $columns = array(
                    [
                        "title" => 'ID',
                        "data" => 'idSolicitud'
                    ],
                    [
                        "title" => 'Lote',
                        "data" => 'nombreLote'
                    ],
                    [
                        "title" => 'Condominio',
                        "data" => 'nombreCondominio'
                    ],
                    [
                        "title" => 'Residencial',
                        "data" => 'nombreResidencial'
                    ],
                    [
                        "title" => 'Cliente',
                        "data" => 'nombre'
                    ],
                    [
                        "title" => 'Estatus',
                        "data" => 'estatus'
                    ],
                    [
                        "title" => 'Area',
                        "data" => 'area'
                    ],
                    [
                        "title" => 'Vigencia',
                        "data" => 'atrasado'
                    ],
                    [
                        "title" => 'Días de atraso',
                        "data" => 'diferencia'
                    ],
                    [
                        "title" => 'Fecha del estatus',
                        "data" => 'fecha_creacion'
                    ]
                );
            break;
        }
        $data = json_decode(json_encode($data), True);

        for ($i = 0; $i < count($data); $i++) {
            $a = 0;
            if ( $data[$i]['dias'] == 0 || $data[$i]['dias'] == null ){
                $data[$i]['atrasado']  = 'EN TIEMPO';
                $data[$i]['diferencia']  = 0;
            }
            else{
                $endDate = date('m/d/Y h:i:s a', time());
                $result = $this->getWorkingDays($data[$i]['fecha_creacion'], $endDate, $data[$i]['dias']);
                $data[$i]['atrasado'] = $result['atrasado'];
                $data[$i]['diferencia'] = $result['diferencia'];
            }
        }

        $array = [
            "columns" => $columns,
            "data" => $data
        ];
        if ($data != null)
            echo json_encode($array);
        else
            echo json_encode(array());
    }

    public function getEstatusEscrituracion()
    {
        $data = $this->Postventa_model->getEstatusEscrituracion();
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    public function getFullReportContraloria(){
        $idSolicitud = $_POST['idEscritura'];
        $data = $this->Postventa_model->getFullReportContraloria($idSolicitud);
        for ($i = 0; $i < count($data); $i++) {
            $a = 0;
            if ( $data[$i]['tiempo'] != 0 && $data[$i]['tiempo'] != null){
                $startDate = $data[$i]['fecha_creacion'];
                $endDate = ( $i+1 < count($data) ) ? $data[$i+1]['fecha_creacion'] : date('m/d/Y h:i:s a', time());


                $result = $this->getWorkingDays($startDate, $endDate, $data[$i]['tiempo']);
                $data[$i]['atrasado'] = $result['atrasado'];
                $data[$i]['diferencia'] = $result['diferencia'];
            }
            else{
                $data[$i]['atrasado'] = "EN TIEMPO";
                $data[$i]['diferencia'] = 0;
            }
        }
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());    
    }

    public function getTipoEscrituracion()
    {
        $data = $this->Postventa_model->getTipoEscrituracion();
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    public function servicioPostventa($referencia, $empresa){
        //$url = 'https://prueba.gphsis.com/backCobranza/index.php/PaginaCDM/getDatos_clientePV';
        $url = 'https://api-cobranza.gphsis.com/index.php/PaginaCDM/getDatos_clientePV';
        $datos = base64_encode(json_encode(array(
            "referencia" => $referencia,
            "empresa" => $empresa
        )));

        $opciones = array(
            "http" => array(
                "header" => ["Content-type: application/x-www-form-urlencoded", "Origin: maderascrm.gphsis.com, localhost"],
                "method" => "POST",
                "content" => $datos, # Agregar el contenido definido antes
            ),
        );
        # Preparar petición
        $contexto = stream_context_create($opciones);
        # Hacerla
        $resultado = file_get_contents($url, false, $contexto);
        $resDecode = json_decode(base64_decode($resultado));
        return $resDecode;
    }

    public function insertPostventaDF($dataFiscal){
        // print_r($dataFiscal);
        // $opciones = array(
        //     "http" => array(
        //         "header" => "Content-type: application/x-www-form-urlencoded\r\n",
        //         "method" => "POST",
        //         "content" => $dataFiscal, # Agregar el contenido definido antes
        //         'timeout' => 30,
        //     ),
        // );
        $url = 'https://prueba.gphsis.com/backCobranza/index.php/PaginaCDM/updateDFiscales';
       // $url = base_url().'backCobranza/index.php/PaginaCDM/updateDFiscales';
        // $fields_string = http_build_query($dataFiscal);
        $ch = curl_init($url);
        # Setup request to send json via POST.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataFiscal);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        # Return response instead of printing.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        # Send request.
        $result = curl_exec($ch);
        curl_close($ch);
        // $resultado = file_get_contents($url, false, $contexto);
        $resDecode = json_decode(base64_decode($result));
      //  print_r($resDecode);
        return $resDecode; 
    }

    //INFORMACIÓN ADMIN
    public function newInformacion()
    {
        $data = $_POST;
        $id_solicitud = $data['idSolicitud'];
        $updateData = array(
            "cliente_anterior" =>($data['clienteI'] == 'default' || $data['clienteI'] == null ? 2 : $data['clienteI'] == 'uno') ? 1 : 2,
            "nombre_anterior" => $data['nombreI'] == '' || $data['nombreI'] == null || $data['nombreI'] == 'null' ? '' : $data['nombreI'],
            "RFC" => $data['rfcDatosI'] == '' || $data['rfcDatosI'] == 'N/A' || $data['rfcDatosI'] == 'null' ? NULL : $data['rfcDatosI'],
             "aportacion" => $data['aportaciones'],
            "descuento" => $data['descuentos'],
            "motivo" => $data['motivo']
        );
        ($data['fechaCAI'] == '' || $data['fechaCAI'] == null || $data['fechaCAI'] == 'null' || $data['fechaCAI'] == 'NaN-NaN-NaN') ? '': $updateData['fecha_anterior'] = date("Y-m-d",strtotime($data['fechaCAI']));

        //print_r($data);
        $data = $this->Postventa_model->updateInformacion($updateData, $id_solicitud);
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    public function getBudgetInformacion()
    {
        $idSolicitud = $this->input->post('idSolicitud');
        $data = $this->Postventa_model->getBudgetInformacion($idSolicitud)->row();
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

function getWorkingDays($startDate, $endDate, $tiempo){
    $dataTime=[];
    $stop_date = date('Y-m-d H:i:s', strtotime($startDate . ' +'.$tiempo.' day'));
    $begin = strtotime($startDate);
    $end   = strtotime($endDate);
    $stop = strtotime($stop_date);
    $validDays = 0;

        $dt = new DateTime($startDate);
        $dt2 = new DateTime($stop_date);    
        $timeStart = $dt->format('h:i:s A');
        $timeEnd = $dt2->format('h:i:s A');
        $st_time    =   strtotime($timeStart);
        $end_time   =   strtotime($timeEnd);

        if( $end_time <= $st_time ){
            $dataTime['atrasado'] = "EN TIEMPO";
            $dataTime['diferencia'] = 0;

            return $dataTime;
        }
        else{
            $dataTime['atrasado'] = "ATRASADO";
            $dataTime['diferencia'] = ( $working_days != 0 ) ? $working_days - 1 : $working_days;

            return $dataTime;
        }        
    // while ($begin < $stop) {
        
    // };
    $working_days = $no_days - $weekends;

    $dt = new DateTime($startDate);
    $dt2 = new DateTime($stop_date);    
    $timeStart = $dt->format('h:i:s A');
    $timeEnd = $dt2->format('h:i:s A');
    $st_time    =   strtotime($timeStart);
    $end_time   =   strtotime($timeEnd);

    if( $end_time <= $st_time ){
        $dataTime['atrasado'] = "En tiempo";
        $dataTime['diferencia'] = 0;

        return $dataTime;
    }
    else{
        $dataTime['atrasado'] = "Atrasado";
        $dataTime['diferencia'] = ( $working_days != 0 ) ? $working_days - 1 : $working_days;

        return $dataTime;
    }        
}

function getNotariasXUsuario(){
    $idSolicitud = $_POST['idSolicitud'];
    if($idSolicitud != ''){
        $data = $this->Postventa_model->getNotariasXUsuario($idSolicitud);
    }else{
        $data = null;
    }
    if ($data != null)
        echo json_encode($data);
    else
        echo json_encode(array());
}

function saveNotaria(){
    $idSolicitud = $_POST['idSolicitud'];
    $idNotaria = $_POST['idNotaria'];

    $result = $this->Postventa_model->existeNotariaSolicitud($idSolicitud, $idNotaria);
    if ($result) {
        echo json_encode(array('message' => 'Notaría ya registrada. Favor de seleccionar otra'));
        return;
    }

    $arrayData = array(
        "id_solicitud" => $idSolicitud,
        "id_notaria" => $idNotaria,
        "estatus" => 1
    );
    $data = $this->General_model->addRecord('notarias_x_usuario', $arrayData);
    $data2 = $this->updatePresupuestosNXU($idSolicitud, $idNotaria);
    if ($data != null)
        echo json_encode($data);
    else
        echo json_encode(array());
}

    function getPresupuestosUpload(){
        $idNxS = $_POST['idNxS'];
        $data = $this->Postventa_model->getPresupuestosUpload($idNxS);
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    function updatePresupuestosNXU($idSolicitud, $idNotaria){
        $data = $this->Postventa_model->updatePresupuestosNXU($idSolicitud, $idNotaria);
    }
    public function getOpcCat(){
        $id_cat = $this->input->post("id_cat");
        $data = $this->Postventa_model->getOpcCat($id_cat)->result_array();
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }







  
    public function solicitudes_usuario(){
        if ($this->session->userdata('id_rol') == FALSE) {
            redirect(base_url());
        }
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        $datos['titulaciones'] = $this->Postventa_model->GetTitulaciones();
        switch ($this->session->userdata('id_rol')) {
            case '55': // POSTVENTA
            case '56': // COMITÉ TÉCNICO
            case '57': // TITULACIÓN
                $this->load->view('template/header');
               
                $this->load->view("postventa/solicitudes_usuario_view", $datos);
                break;

            default:
                echo '<script>alert("ACCESSO DENEGADO"); window.location.href="' . base_url() . '";</script>';
                break;
        }
    } 
    public function SolicitudesEscrituracion()
    {
        $id_usuario       = $this->input->post('id_usuario');
        $data['data'] =  $this->Postventa_model->SolicitudesEscrituracion($id_usuario);
      
        echo json_encode($data);

    }

    public function validarDocumento(){
      
        $estatus_validacion       = $this->input->post('estatus_validacion');
        $Iddocumento       = $this->input->post('Iddocumentos');
        $tipo       = $this->input->post('idOpcion');
        $validado_por  =   $this->session->userdata('id_usuario');
        $editado  =   $this->session->userdata('id_usuario');
        $modificado =  date("Y-m-d H:i:s");
        $opcionEditar  =   $this->input->post('opcionEditar');
        

        $insertArray = array(
            'estatus_validacion'      =>   $opcionEditar ,
            'validado_por'          => $validado_por,
            'editado'             => 1, 
            'modificado_por'     => $validado_por  ,
            'modificado'             => $modificado, 
        );
        $updates = $this->Postventa_model->actualizarDocs( $Iddocumento ,$insertArray);
        if($updates){
            $respuesta =  array(
              "response_code" => 200, 
              "response_type" => 'success',
              "message" => "Validado correctamente");
          }else{
            $respuesta =  array(
              "response_code" => 400, 
              "response_type" => 'error',
              "message" => "Validado Incorrecto");
          }  
          echo json_encode ($respuesta);
    }

    
    public function descuentoUpdateTi(){

        $id_solicitud       = $this->input->post('id_solicitud');
        $id_titulacion       = $this->input->post('id_titulacion');
        $id_titulacionviejo       = $this->input->post('idTitular');
        $id_titulacionneuvo       = $this->input->post('titulares');
          $arr_update = array( 
            "id_titulacion" => $id_titulacionneuvo,
                            );
        $update = $this->Postventa_model->cambiarTitulacion($id_solicitud,$arr_update); 
        $info =  $this->session->userdata('id_usuario');                          
        $insertArray = array(
            'id_parametro'      => intval($id_solicitud)   ,
            'tipo'              => 'update ',
            'anterior'          => intval($id_titulacionviejo),
            'nuevo'             => intval($id_titulacionneuvo), 
            'col_afect'         => 'id_titulacion',
            'tabla'             => 'solicitudes_escrituracion',
            'fecha_creacion'    =>  date("Y-m-d H:i:s"),
            'creado_por'        =>  intval($info) ,
        );
        $updates = $this->Postventa_model->updateauditoria($insertArray);
        if($update){
          $respuesta =  array(
            "response_code" => 200, 
            "response_type" => 'success',
            "message" => "actividad actualizado satisfactoriamente");
        }else{
          $respuesta =  array(
            "response_code" => 400, 
            "response_type" => 'error',
            "message" => "actividad no actualizada, intentalo más tarde");
        }
        echo json_encode ($respuesta);
      } 
      public function getDocumentosPorSolicitud()
      {
          $solicitud      = $this->input->post('solicitud');
          $estatus        = $this->input->post('estatus');
          $validacion     = true;

            if($estatus == 8){
                $opciones = ' (11,13,20,23)';
            }else if($estatus == 11 ){
                $opciones = ' (7)';
            }else if($estatus == 12 ){
                $opciones = ' (1,2,3,4,5,6,8,9,10,12,14,20,21)';
            }else if($estatus == 18 ){
                $opciones = ' (17)';
            }else if($estatus == 20 ){
                $opciones = ' (15)';
            }else if($estatus == 23 ){
                $opciones = ' (22)';
            }else if($estatus == 24 ){
                $opciones = ' (16)';
            }else {
                $validacion = false;
                $opciones = ' (0)';
            }
            

          if($solicitud == '' || $estatus == '')
          {
              $validacion = false;
          }
          if($validacion){
              $respuesta['misDocumentos'] = $this->Postventa_model->getDocumentosPorSolicitud($solicitud,$opciones);
              $respuesta['losDocumentos'] = $this->Postventa_model->documentosNecesarios($opciones);
              $respuesta['nuevosDocs'] = $this->Postventa_model->getDocumentsClient($solicitud, $estatus, $notariaExterna);
          }else{
              $respuesta = array();
          }
   
          
          echo json_encode($respuesta);
      }

      public function UParchivosFroms(){
		$tamanoOfAuts = (1);
    	$indexx = ($_POST['indexx']);
        $solicitud = ($_POST['solicitudId']);
        $tipoDocuemento = ($_POST['iddocumento']);
        // $lote = ($_POST['lote']);

			if ($_FILES["docSubir$indexx"]["name"] != '' && $_FILES["docSubir$indexx"]["name"] != null) {
				$aleatorio = rand(100,1000);
				$expediente=preg_replace('[^A-Za-z0-9]', '',$_FILES["docSubir$indexx"]["name"]);
				// $proyecto = str_replace(' ', '',$nombreResidencial);
				// $condominio = str_replace(' ', '',$nombreCondominio);
				// $condominioQuitaN= str_replace(array('Ñ','ñ'),"N",$condominio);
				// $condom = substr($condominioQuitaN, 0, 3);
				// $cond= strtoupper($condom);
				// $numeroLote = preg_replace('/[^0-9]/','',$nombreLote);
				$date = date('dmY');
				 $expediente = $date."_".$aleatorio."_".$expediente;
                $ruta = 'static/documentos/postventa/escrituracion/RFC/';
                $ruta = $this->getFolderFile($tipoDocuemento);
                $info =  $this->session->userdata('id_usuario');
                if (move_uploaded_file($_FILES["docSubir$indexx"]["tmp_name"], $ruta.$expediente)) {
                    $response   = 1 ;
                    $code       = 'success';
                    $mensaje    = 'La acción se ha realizado correctamente.';
                    $arrayInsertDocumentos = array(
                        'movimiento'    => 'creacion de documento escrituracion',
                        'expediente'    =>  $expediente,
                        'modificado'    => date("Y-m-d H:i:s"),
                        'status'       => 1, 
                        'idSolicitud'   => $solicitud ,
                        'idUsuario'     => $info ,
                        'tipo_documento' => $tipoDocuemento,
                        'creado_por'    => $info,
                        'fecha_creacion' => date("Y-m-d H:i:s"),
                    );

                    $ultimoInsert =   $this->Postventa_model->insertDocumentNuevo($arrayInsertDocumentos);
                   
 
				}else{
                    $response   = 2 ;
                    $code       = 'warning';
                    $mensaje    = 'No se ha ejecutado la acción correctamente';
                    $ultimoInsert = 0;
                }
			}

    $respuesta = array(
      'code'    => $response,
      'mensaje' => $mensaje,
      'respuesta' => $response,
      'ultimoInsert' =>  $ultimoInsert,

      // donde 1 es succes y 2 es error
    );
    echo json_encode ($respuesta);
	}


    public function deleteFileActualizado()
    {
        $documentType = $this->input->post('documentType');
        $presupuestoType = null;
        $idSolicitud = $this->input->post('idSolicitud');
        $idDocumento = $this->input->post('idDocumento');
        if( $documentType == 13){
            $presupuestoType = $this->input->post('presupuestoType');
            $updateDocumentData = array(
                "expediente" => '',
                "modificado_por" => $this->session->userdata('id_usuario'),
            );
        }else{
            $updateDocumentData = array(
                "expediente" => null,
                "movimiento" => '',
                "modificado" => date('Y-m-d H:i:s'),
                "estatus_validacion" => null,
                "idUsuario" => $this->session->userdata('id_usuario'),
                "modificado_por" => $this->session->userdata('id_usuario'),
                "status" => 1
            );
            
        }
        
        $filename = $this->Postventa_model->getFilename($idDocumento, $documentType)->row()->expediente;
        $folder = $this->getFolderFile($documentType);
        $file = $folder . $filename;
        if (file_exists($file))
            unlink($file);

        $response = $this->Postventa_model->eliminarDoc( $idDocumento);
        echo json_encode($response);
        // FALTA ENVIAR EL CORREO CUANDO ES LA CORRIDA QUE SE ELIMINA
    }

    public function descargarInf(){
        $documentType = $this->input->post('documentType');
        $folder = $this->getFolderFile($documentType);
        return $folder;
    }

    public function descargarDocs()
    {
        $this->load->helper('download');
        $name = $this->input->post('name');
        $documentType = $this->input->post('documentType');
        var_dump( $documentType,  $name);
        $folders = $this->getFolderFile($documentType);
        
        $Ruta = $folders.$name;
        var_dump(  $Ruta );
     
        force_download($Ruta, NULL);
     
    }
    // public function 
    public function nuevoNotario()
    {
        $idSolicitud = $_POST['idSolicitud'];
        $nombre_notaria = $_POST['nombre_notaria'];
        $nombre_notario = $_POST['nombre_notario'];
        $direccion = $_POST['direccion'];
        $correo = $_POST['correo'];
        $telefono = $_POST['telefono'];

        $informacion = $this->Postventa_model->insertNewNotaria($nombre_notaria, $nombre_notario, $direccion, $correo, $telefono, 0, 2);
        return $informacion;

        return $this->Postventa_model->insertNewNotaria($idSolicitud);
    }
      



    public function validarDocumentoss(){
        $motivo = 0;
        $estatus_validacion       = $this->input->post('estatus_validacion');
        $Iddocumento       = $this->input->post('Iddocumentos');
        $tipo       = $this->input->post('idOpcion');
        $validado_por  =   $this->session->userdata('id_usuario');
        $editado  =   $this->session->userdata('id_usuario');
        $modificado =  date("Y-m-d H:i:s");
        $opcionEditar  =   $this->input->post('opcionEditar');
        if($estatus_validacion ==2){
            $proceso  =   $this->input->post('proceso');
            $motivo  =   $this->input->post('motivo');
            $insertArray = array(
                'id_motivo'      => $motivo,
                'id_documento'   => $Iddocumento,
                'tipo'           => $tipo, 
                'estatus'        => 0,
                'tipo_proceso'   => $proceso,
                'creado_por'     => $validado_por,
                'fecha_creacion' => $modificado,
            );
            $respuestaAct = $this->Postventa_model->insertMotivoPorDoc( $insertArray);
            
        }
        $insertArray = array(
            'estatus_validacion'      =>   $opcionEditar ,
            'validado_por'          => $validado_por,
            'editado'             => 1, 
            'modificado_por'     => $validado_por  ,
            'modificado'             => $modificado, 
        );
        $updates = $this->Postventa_model->actualizarDocs( $Iddocumento ,$insertArray);
        if($updates ){
            $respuesta =  array(
              "response_code" => 200, 
              "response_type" => 'success',
              "message" => "Validado correctamente");
          }else{
            $respuesta =  array(
              "response_code" => 400, 
              "response_type" => 'error',
              "message" => "Validado Incorrecto");
          }  
          echo json_encode ($respuesta);
    }

    
    public function descuentoUpdateTis(){

        $id_solicitud       = $this->input->post('id_solicitud');
        $id_titulacion       = $this->input->post('id_titulacion');
        $id_titulacionviejo       = $this->input->post('idTitular');
        $id_titulacionneuvo       = $this->input->post('titulares');
          $arr_update = array( 
            "id_titulacion" => $id_titulacionneuvo,
                            );
        $update = $this->Postventa_model->cambiarTitulacion($id_solicitud,$arr_update); 
        $info =  $this->session->userdata('id_usuario');                          
        $insertArray = array(
            'id_parametro'      => intval($id_solicitud) ,
            'tipo'              => 'update ',
            'anterior'          => intval($id_titulacionviejo),
            'nuevo'             => intval($id_titulacionneuvo), 
            'col_afect'         => 'id_titulacion',
            'tabla'             => 'solicitudes_escrituracion',
            'fecha_creacion'    =>  date("Y-m-d H:i:s"),
            'creado_por'        =>  intval($info) ,
        );
        $updates = $this->Postventa_model->updateauditoria($insertArray);
        if($update){
          $respuesta =  array(
            "response_code" => 200, 
            "response_type" => 'success',
            "message" => "actividad actualizado satisfactoriamente");
        }else{
          $respuesta =  array(
            "response_code" => 400, 
            "response_type" => 'error',
            "message" => "actividad no actualizada, intentalo más tarde");
        }
        echo json_encode ($respuesta);
      } 

      public function getDocumentosPorSolicitudss()
      {
        
          $solicitud      = $this->input->post('solicitud');
          $status        = $this->input->post('estatus');
          $notariaExterna = ''; 
          $validacion     = true;

        // var_dump ($solicitud, $estatus);
        if($status == 9){
            $opciones = " (11,13,20 )";
        }else if($status == 11){
            $opciones = ' (7)';
        }else if($status == 12){
            $opciones = ' (1,2,3,4,5,6,8,9,10,12,14,20,21)';
        }else if($status == 3 || $status == 4 || $status == 6 || $status == 8 || $status == 10 ){
            $opciones = ' (17,18)';
        }else if($status == 19 || $status == 20){
            $opciones = ' (1,2,3,4,5,6,8,9,10,16,20,21)';
        }else if($status == 23){
            $opciones = ' (22)';
        }else if($status == 24){
               $opciones = ' (16)';
        }

          if($solicitud == '' || $status == '')
          {
              $validacion = false;
          }
          if($validacion){

              $respuesta['misDocumentos'] = $this->Postventa_model->getDocumentosPorSolicituds($solicitud,$opciones);
              $respuesta['losDocumentos'] = $this->Postventa_model->documentosNecesarios($opciones);

              $respuesta['nuevosDocs'] = $this->Postventa_model->getDocumentsClient($solicitud, $status, $notariaExterna);
          }else{
              $respuesta = array();
          }
   
          
          echo json_encode($respuesta);
      }

      public function UParchivosFromss(){
		$tamanoOfAuts = (1);
    	$indexx = ($_POST['indexx']);
        $solicitud = ($_POST['solicitudId']);   
        $tipoDocuemento = ($_POST['iddocumento']);
        $estatus_validacion = 0;
        // $lote = ($_POST['lote']);
             // CONSULTAR SI EXISTE UN DOCUMENTO
             if($this->Postventa_model->validarExisteDocumento($tipoDocuemento ,$solicitud))
             {   
                // NO EXISTE DOCUMENTO AGREGAMOS NORMAL
                if ($_FILES["docSubir$indexx"]["name"] != '' && $_FILES["docSubir$indexx"]["name"] != null) {
                    $aleatorio = rand(100,1000);
                    $expediente=preg_replace('[^A-Za-z0-9]', '',$_FILES["docSubir$indexx"]["name"]);
                    // $proyecto = str_replace(' ', '',$nombreResidencial);
                    // $condominio = str_replace(' ', '',$nombreCondominio);
                    // $condominioQuitaN= str_replace(array('Ñ','ñ'),"N",$condominio);
                    // $condom = substr($condominioQuitaN, 0, 3);
                    // $cond= strtoupper($condom);
                    // $numeroLote = preg_replace('/[^0-9]/','',$nombreLote);
                    $date = date('dmYHis');
                     $expediente = $date."_".$aleatorio."_".$expediente;

                    $ruta = $this->getFolderFile($tipoDocuemento);
                    $info =  $this->session->userdata('id_usuario');
                    if (move_uploaded_file($_FILES["docSubir$indexx"]["tmp_name"], $ruta.$expediente)) {
                        $response   = 1 ;
                        $code       = 'success';
                        $mensaje    = 'La acción se ha realizado correctamente.';
                        $arrayInsertDocumentos = array(
                            'movimiento'    => 'creacion de documento escrituracion',
                            'expediente'    =>  $expediente,
                            'modificado'    => date("Y-m-d H:i:s"),
                            'status'       => 1, 
                            'idSolicitud'   => $solicitud ,
                            'idUsuario'     => $info ,
                            'tipo_documento' => $tipoDocuemento,

                            'fecha_creacion' => date("Y-m-d H:i:s"),
                            // 'estatus_validacion' => $estatus_validacion, 
                        );
    
                        $ultimoInsert =   $this->Postventa_model->insertDocumentNuevo($arrayInsertDocumentos);
                       
     
                    }else{
                        $response   = 2 ;
                        $code       = 'warning';
                        $mensaje    = 'No se ha ejecutado la acción correctamente';
                        $ultimoInsert = 0;
                    }
             }else{
                $response   = 2 ;
                        $code       = 'warning';
                        $mensaje    = 'No se ha ejecutado la acción correctamente';
                        $ultimoInsert = 0;
             }
            
            } else {
                // ELIMINAMOS DOCUMENTO ACUTALIZANDO DATOS

                if ($_FILES["docSubir$indexx"]["name"] != '' && $_FILES["docSubir$indexx"]["name"] != null) {
                    $aleatorio = rand(100,1000);
                    $expediente=preg_replace('[^A-Za-z0-9]', '',$_FILES["docSubir$indexx"]["name"]);
                    // $proyecto = str_replace(' ', '',$nombreResidencial);
                    // $condominio = str_replace(' ', '',$nombreCondominio);
                    // $condominioQuitaN= str_replace(array('Ñ','ñ'),"N",$condominio);
                    // $condom = substr($condominioQuitaN, 0, 3);
                    // $cond= strtoupper($condom);
                    // $numeroLote = preg_replace('/[^0-9]/','',$nombreLote);
                    $date = date('dmYHis');
                    $expediente = $date."_".$aleatorio."_".$expediente;
                    $ruta = $this->getFolderFile($tipoDocuemento);
                    $info =  $this->session->userdata('id_usuario');
                    $documento = $this->Postventa_model->validarExisteDocumentos($tipoDocuemento ,$solicitud);
                    $clave = $documento->idDocumento; 
                    if (move_uploaded_file($_FILES["docSubir$indexx"]["tmp_name"], $ruta.$expediente)) {
                        $response   = 1 ;
                        $code       = 'success';
                        $mensaje    = 'La acción se ha realizado correctamente.';
                        $arrayInsertDocumentos = array(
                            'movimiento'    => 'creacion de documento escrituracion',
                            'expediente'    =>  $expediente,
                            'modificado'    =>  date("Y-m-d H:i:s"),
                            'status'        =>  1,
                            // 'estatus_validacion' => $estatus_validacion, 
                        );
                        $updates = $this->Postventa_model->actualizarDocs( $clave ,$arrayInsertDocumentos);
                        $response   = 1 ;
                        $code       = 'success';
                        $mensaje    = 'La acción se ha realizado correctamente.';
                        $ultimoInsert = $clave ;
                    
                    }else{
                        $response   = 2 ;
                        $code       = 'warning';
                        $mensaje    = 'No se ha ejecutado la acción correctamente';
                        $ultimoInsert = 0;
                    }

                
             }


		
			}

    $respuesta = array(
      'code'    => $response,
      'mensaje' => $mensaje,
      'respuesta' => $response,
      'ultimoInsert' =>  $ultimoInsert,

      // donde 1 es succes y 2 es error
    );
    echo json_encode ($respuesta);
	}


    public function deleteFileActualizadoss()
    {
        $documentType = $this->input->post('documentType');
        $presupuestoType = null;
        $idSolicitud = $this->input->post('idSolicitud');
        $idDocumento = $this->input->post('idDocumento');
        if( $documentType == 13){
            $presupuestoType = $this->input->post('presupuestoType');
            $updateDocumentData = array(
                "expediente" => '',
                "modificado_por" => $this->session->userdata('id_usuario'),
            );
        }else{
            $updateDocumentData = array(
                "expediente" => null,
                "movimiento" => '',
                "modificado" => date('Y-m-d H:i:s'),
                "estatus_validacion" => null,
                "idUsuario" => $this->session->userdata('id_usuario'),
                "modificado_por" => $this->session->userdata('id_usuario'),
                "status" => 1
            );
            
        }
        // var_dump($idDocumento , $documentType);
        $filename = $this->Postventa_model->getFilename($idDocumento, $documentType)->row()->expediente;
        $folder = $this->getFolderFile($documentType);
        $file = $folder . $filename;
        if (file_exists($file))
            unlink($file);  
            // AQUI SE VA A AACTUALIZAR
            $arrayInsertDocumentos = array(
                'expediente'    => null,
                'estatus_validacion' => null, 
                'movimiento'    => 'creacion de documento escrituracion',
                'modificado'    =>  date("Y-m-d H:i:s"),
                'status'        =>  0, 
            );
            $updates = $this->Postventa_model->actualizarDocs( $idDocumento ,$arrayInsertDocumentos);
        // $response = $this->Postventa_model->eliminarDoc( $idDocumento);
        echo json_encode($updates);
        // FALTA ENVIAR EL CORREO CUANDO ES LA CORRIDA QUE SE ELIMINA
    }

    public function descargarDocsss()
    {
        $this->load->helper('download');
        $name = $this->input->post('name');
        $documentType = $this->input->post('documentType');
        var_dump( $documentType,  $name);
        $folders = $this->getFolderFile($documentType);
        $Ruta = $folders.$name;
        var_dump(  $Ruta );
        force_download($Ruta, NULL);     
    }

    public function motivosRechazos(){
        $tipoDocuemento = $this->input->post("tipoDocumento");
        $motivosRechazo = $this->Postventa_model->motivosRechazo($tipoDocuemento);
        echo json_encode ($motivosRechazo); 
    }
  
    public function cambiarEstatusDocsSiguienteMotivo(){

        $tipoDocuemento = $this->input->post("tipoDocumento");
        $motivosRechazo = $this->Postventa_model->motivosRechazo($tipoDocuemento);
        echo json_encode ($motivosRechazo); 

    }
  



      
}



 
