<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Postventa extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Postventa_model', 'Documentacion_model', 'General_model'));
        $this->load->library(array('session', 'form_validation', 'get_menu'));
        $this->validateSession();
        date_default_timezone_set('America/Mexico_City');
    }

    public function index()
    {
        if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != '55' && $this->session->userdata('id_rol') != '56' && $this->session->userdata('id_rol') != '57' && $this->session->userdata('id_rol') != '13')
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
            case '13': // CONTRALORÏa
            case '55': // POSTVENTA
            case '56': // COMITÉ TÉCNICO
            case '57': // TITULACIÓN
                $this->load->view('template/header');
                $this->load->view("postventa/solicitudes_escrituracion", $datos);
                break;
            
            default:
                echo '<script>alert("ACCESSO DENEGADO"); window.location.href="' . base_url() . '";</script>';
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
        $data = $this->Postventa_model->getClient($idLote)->row();
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    public function printChecklist($data)
    {

        $this->load->library('Pdf');
        $pdf = new TCPDF('P', 'mm', 'LETTER', 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        // $pdf->SetAuthor('Sistemas Victor Manuel Sanchez Ramirez');
        $pdf->SetTitle('Checklist persona física');
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
                                                <td colspan="2" align="right"><b style="font-size: 1.7em; "> Checklist<BR></b>
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
                                                    <b>Nombre completo:</b><br>
                                                    ' . $informacion->nombre . '
                                                    </td>
                                                    <td style="font-size: 1em;">
                                                    <b>Ocupacíon:</b><br>
                                                    ' . $informacion->ocupacion . '
                                                    </td>
                                                    <td style="font-size: 1em;">
                                                    <b>Lugar de origen:</b><br>
                                                    ' . $informacion->origen . '
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 1em;">
                                                        <b>Domicilio actual:</b><br>
                                                        ' . $informacion->domicilio_particular . '
                                                    </td>
                                                    <td style="font-size: 1em;">
                                                        <b>Domicilio Fiscal:</b><br>
                                                        ' . $informacion->domicilio_particular . '
                                                    </td>
                                                </tr>
                                                <tr>
                                                
                                                    <td style="font-size: 1em;">
                                                        <b>Estado civil:</b><br>
                                                        ' . $informacion->estado_civil . '
                                                    </td>
                                                    <td style="font-size: 1em;">
                                                        <b>Régimen conyugal:</b><br>
                                                        ' . $informacion->regimen_matrimonial . '
                                                    </td>
                                                    <td style="font-size: 1em;">
                                                        <b>RFC:</b><br>
                                                        ' . $informacion->rfc . '
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 1em;">
                                                        <b>Teléfono (casa):</b><br>
                                                        ' . $informacion->telefono1 . '
                                                    </td>
                                                    <td style="font-size: 1em;">
                                                        <b>Teléfono (celular):</b><br>
                                                        ' . $informacion->telefono2 . '
                                                    </td>
                                                    <td style="font-size: 1em;">
                                                        <b>Correo electrónico:</b><br>
                                                        ' . $informacion->correo . '
                                                    </td>
                                                </tr>
                                            </table>
                                            <br>
                                            <br>
                                            <br>
                                            <table width="100%" style="text-align: center;padding:10px;height: 45px; border-top: 1px solid #ddd;border-left: 1px solid #ddd;border-right: 1px solid #ddd;" width="690">
                                                <tr>
                                                    <td colspan="2" style="background-color: #15578B;color: #fff;padding: 3px 6px; "><b style="font-size: 2em; ">Checklist</b>
                                                    </td>
                                                </tr>
                                            </table>                            
                                            <br><br>
                                            <table width="100%" style="padding:10px 3px;height: 45px; border: 1px solid #ddd; text-align: center;" width="690">
                                                <tr>
                                                    <td colspan="2" style="font-size: 1em;border: 1px solid #ddd;">
                                                        <b>Área</b>
                                                    </td>
                                                    <td colspan="3" style="font-size: 1em;border: 1px solid #ddd;">
                                                        <b>Documento</b>
                                                    </td>
                                                    <td colspan="1" style="font-size: 1em;border: 1px solid #ddd;">
                                                        <b>Status</b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" rowspan="10" style="font-size: 1em;border: 1px solid #ddd;text-align: center;align: middle;">
                                                        <b>POSTVENTA</b>
                                                    </td>
                                                    <td colspan="3" style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        1) Identificación oficial vigente
                                                    </td>
                                                    <td colspan="1" style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        <b></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        2) RFC (Cédula o constancia de situación fiscal)
                                                    </td>
                                                    <td colspan="1"style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        <b></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        3) Comprobante de domicilio actual luz, agua o telefonia fija(antiguedad menor a 2 meses)
                                                    </td>
                                                    <td colspan="1"  style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        <b></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        4) Acta de nacimiento
                                                    </td>
                                                    <td colspan="1" style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        <b></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        5) Acta de matrimonio (en su caso). *
                                                    </td>
                                                    <td colspan="1"  style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        <b></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        6) CURP(formato actualizado)
                                                    </td>
                                                    <td colspan="1"  style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        <b></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        7) Formas de pago (todos los comprobantes de pago a mensialidades / estados de cuenta bancarios) **
                                                    </td>
                                                    <td colspan="1"  style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        <b></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        8) Boleta predial al corriente y comprobante de pago retroactivo (si aplica)
                                                    </td>
                                                    <td colspan="1" style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        <b></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        9) Constancia no adeudo mantenimiento (si aplica)
                                                    </td>
                                                    <td colspan="1"  style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        <b></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        10) Constancia no adeudo de agua (si aplica)
                                                    </td>
                                                    <td colspan="1"  style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        <b></b>
                                                    </td>
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
        $pdf->Output(utf8_decode("Informacion.pdf"), 'I');
    }

    public function sendMail()
    {
        $data = $_POST['data'];
        $this->load->library('email');
        $mail = $this->email;

        $mail->from('noreply@ciudadmaderas.com', 'Ciudad Maderas');

        $mail->to('programador.analista18@ciudadmaderas.com');
        $mail->Subject(utf8_decode("Checklist escrituracion"));
        $mailContent = '
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
                                                <td colspan="2" align="right"><b style="font-size: 1.7em; "> Checklist<BR></b>
                                                </td>
                                            </tr>
                                        </table>
                                        <br><br>
                                        <table width="100%" style="padding:10px 0px; text-align: center;height: 45px; border: 1px solid #ddd;" width="690">
                                            <tr>
                                                <td colspan="2" style="padding: 3px 6px; ">
                                                    <b style="font-size: .8em; ">
                                                        Estimado ' . $data['nombre'] . '<br>
                                                        En seguimiento a su visita en oficina de Ciudad Maderas Querétaro, envio la informacion para iniciar con el proceso de escrituración
                                                        como primer paso es la solicitud del presupuesto para conocer el monto a pagar por la escritura y asignar notaria<br>
                                                        El presupuesto que envió es informativo, sin valor avalúo por parte del perito y es con el costo estimado, tambien aprovecho y envió el check list
                                                        en solicitud a la recepción de todos los documentos al momento de escriturar, estos documentos deben ser necesarios para efectuar la entrega del proyecto de escrituración 
                                                        con la notaria:
                                                    </b>
                                                </td>
                                            </tr>
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
                                                        <b>Nombre completo:</b><br>
                                                        ' . $data['nombre'] . '
                                                    </td>
                                                    <td style="font-size: 1em;">
                                                        <b>Ocupacíon:</b><br>
                                                        ' . $data['ocupacion'] . '
                                                    </td>
                                                    <td style="font-size: 1em;">
                                                        <b>Lugar de origen:</b><br>
                                                        ' . $data['origen'] . '
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 1em;">
                                                        <b>Domicilio actual:</b><br>
                                                        ' . $data['direccionf'] . '
                                                    </td>
                                                    <td style="font-size: 1em;">
                                                        <b>Domicilio Fiscal:</b><br>
                                                        ' . $data['direccionf'] . '
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 1em;">
                                                        <b>Estado civil:</b><br>
                                                        ' . $data['ecivil'] . '
                                                    </td>
                                                    <td style="font-size: 1em;">
                                                        <b>Régimen conyugal:</b><br>
                                                        ' . $data['rconyugal'] . '
                                                    </td>
                                                    <td style="font-size: 1em;">
                                                        <b>RFC:</b><br>
                                                        ' . $data['rfc'] . '
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 1em;">
                                                        <b>Teléfono (casa):</b><br>
                                                        ' . $data['telefono'] . '
                                                    </td>
                                                    <td style="font-size: 1em;">
                                                        <b>Teléfono (celular):</b><br>
                                                        ' . $data['cel'] . '
                                                    </td>
                                                    <td style="font-size: 1em;">
                                                        <b>Correo electrónico:</b><br>
                                                        ' . $data['correo'] . '
                                                    </td>
                                                </tr>
                                            </table>
                                            <br>
                                            <br>
                                            <br>
                                            <table width="100%" style="text-align: center;padding:10px;height: 45px; border-top: 1px solid #ddd;border-left: 1px solid #ddd;border-right: 1px solid #ddd;" width="690">
                                                <tr>
                                                    <td colspan="2" style="background-color: #15578B;color: #fff;padding: 3px 6px; "><b style="font-size: 2em; ">Checklist</b>
                                                    </td>
                                                </tr>
                                            </table>                            
                                            <br><br>
                                            <table width="100%" style="padding:10px 3px;height: 45px; border: 1px solid #ddd; text-align: center;" width="690">
                                                <tr>
                                                    <td colspan="2" style="font-size: 1em;border: 1px solid #ddd;">
                                                        <b>Área</b>
                                                    </td>
                                                    <td colspan="3" style="font-size: 1em;border: 1px solid #ddd;">
                                                        <b>Documento</b>
                                                    </td>
                                                    <td colspan="1" style="font-size: 1em;border: 1px solid #ddd;">
                                                        <b>Status</b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" rowspan="10" style="font-size: 1em;border: 1px solid #ddd;text-align: center;align: middle;">
                                                        <b>POSTVENTA</b>
                                                    </td>
                                                    <td colspan="3" style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        1) Identificación oficial vigente
                                                    </td>
                                                    <td colspan="1" style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        <b></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        2) RFC (Cédula o constancia de situación fiscal)
                                                    </td>
                                                    <td colspan="1"style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        <b></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        3) Comprobante de domicilio actual luz, agua o telefonia fija(antiguedad menor a 2 meses)
                                                    </td>
                                                    <td colspan="1"  style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        <b></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        4) Acta de nacimiento
                                                    </td>
                                                    <td colspan="1" style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        <b></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        5) Acta de matrimonio (en su caso). *
                                                    </td>
                                                    <td colspan="1"  style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        <b></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        6) CURP(formato actualizado)
                                                    </td>
                                                    <td colspan="1"  style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        <b></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        7) Formas de pago (todos los comprobantes de pago a mensialidades / estados de cuenta bancarios) **
                                                    </td>
                                                    <td colspan="1"  style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        <b></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        8) Boleta predial al corriente y comprobante de pago retroactivo (si aplica)
                                                    </td>
                                                    <td colspan="1" style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        <b></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        9) Constancia no adeudo mantenimiento (si aplica)
                                                    </td>
                                                    <td colspan="1"  style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        <b></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        10) Constancia no adeudo de agua (si aplica)
                                                    </td>
                                                    <td colspan="1"  style="font-size: 0.9em;border: 1px solid #ddd;">
                                                        <b></b>
                                                    </td>
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

        $mail->message($mailContent);
        $response = $mail->send();
        echo json_encode($response);
    }

    public function aportaciones()
    {
        $idLote = $_POST['idLote'];
        $idCliente = $_POST['idCliente'];

        $informacion = $this->Postventa_model->setEscrituracion($idLote, $idCliente);
        echo json_encode($informacion);
    }

    public function getSolicitudes()
    {
        $beginDate = date("Y-m-d", strtotime($this->input->post("beginDate")));
        $endDate = date("Y-m-d", strtotime($this->input->post("endDate")));
        $v = strtotime($this->input->post("endDate"));
        $data['data'] = $this->Postventa_model->getSolicitudes($beginDate, $endDate)->result_array();
        if ($data != null) {
            echo json_encode($data, JSON_NUMERIC_CHECK);
        } else {
            echo json_encode(array());
        }
    }

    public function changeStatus()
    {
        $id_solicitud = $_POST['id_solicitud'];
        $type = $_POST['type'];
        if ($type == 1) {
            $comentarios = $_POST['comentarios'];
            $informacion = $this->Postventa_model->changeStatus($id_solicitud, $type, $comentarios, 0);
        }elseif ($type == 2) {
            $motivos_rechazo = $_POST['comentarios'];
            $informacion = $this->Postventa_model->changeStatus($id_solicitud, $type, 'NULL', $motivos_rechazo);
        }else {
            $informacion = $this->Postventa_model->changeStatus($id_solicitud, $type, 'Cambio de fecha', 0);
        }

        echo json_encode($informacion);
    }

    public function uploadFile()
    {
        $file = $_FILES["uploadedDocument"];
        $idSolicitud = $this->input->post('idSolicitud');
        // $idDocumento = $this->input->post('idDocumento');
        $documentType = $this->input->post('documentType');
        $documentName = $this->Postventa_model->generateFilename($idSolicitud, $documentType)->row();
        $documentInfo = $documentName;
        $documentName = $documentName->fileName . '.' . substr(strrchr($_FILES["uploadedDocument"]["name"], '.'), 1);
        $folder = $this->getFolderFile($documentType);
        $this->updateDocumentBranch($file, $folder, $documentName, $idSolicitud, $documentType, $documentInfo->expediente, $documentInfo->idDocumento);
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
                $folder = "static/documentos/postventa/escrituracion/ESTATUS_CONSTRUCCION/";
                break;
            case 13:
                $folder = "static/documentos/postventa/escrituracion/PRESUPUESTO/";
                break;
            case 14:
                $folder = "static/documentos/postventa/escrituracion/PROYECTO/";
                break;
            case 15:
                $folder = "static/documentos/postventa/escrituracion/FACTURA/";
                break;
            case 16:
                $folder = "static/documentos/postventa/escrituracion/TESTIMONIO/";
                break;
            case 17:
                $folder = "static/documentos/postventa/escrituracion/PROYECTO_ESCRITURA/";
                break;
        }
        return $folder;
    }

    function updateDocumentBranch($file, $folder, $documentName, $idSolicitud, $documentType, $exists, $idDocumento)
    {
        $movement = move_uploaded_file($file["tmp_name"], $folder . $documentName);
        $validateMovement = $movement == FALSE ? 0 : 1;
        if ($validateMovement == 1) {
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
            // if($exists === null){
            //     print_r('if');


            // }else{
            //     print_r('else');

            //     $response = $this->Postventa_model->updateDocumentBranch($documentName, $idSolicitud, $idUsuario, $documentType);
            // }
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
            $response = $this->Postventa_model->replaceDocument($updateDocumentData, $idDocumento); // EL ARCHIVO NO SE PUDO MOVER
            echo json_encode($response);
        } else
            echo json_encode(2); // EL ARCHIVO NO SE PUDO MOVER
    }


    public function deleteFile()
    {
        $idDocumento = $this->input->post('idDocumento');
        $documentType = $this->input->post('documentType');
        $idSolicitud = $this->input->post('idSolicitud');
        $updateDocumentData = array(
            "expediente" => null,
            "movimiento" => '',
            "modificado" => date('Y-m-d H:i:s'),
            "idUsuario" => $this->session->userdata('id_usuario'),
            "modificado_por" => $this->session->userdata('id_usuario'),
            "status" => 1
        );
        $filename = $this->Postventa_model->getFilename($idDocumento)->row()->expediente;
        $folder = $this->getFolderFile($documentType);
        $file = $folder . $filename;
        if (file_exists($file))
            unlink($file);
        $response = $this->Postventa_model->replaceDocument($updateDocumentData, $idDocumento);
        echo json_encode($response);
        // FALTA ENVIAR EL CORREO CUANDO ES LA CORRIDA QUE SE ELIMINA
    }

    public function getMotivosRechazos()
    {
        $tipo_documento = $_POST['tipo_documento'];
        $data = $this->Postventa_model->getMotivosRechazos($tipo_documento);
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    public function getDocumentsClient()
    {
        $idEscritura = $_POST['idEscritura'];
        $data = $this->Postventa_model->getDocumentsClient($idEscritura);
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    public function getNotarias()
    {
        $data = $this->Postventa_model->getNotarias();
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

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
        /*$data['nombreT'] == '' || $data['nombreT'] == null ? $nombreT = null : $nombreT =  $data['nombreT'];
        $data['fechaCA'] == '' || $data['fechaCA'] == null ? $fechaCA = null : $fechaCA =  date("Y-m-d", strtotime($data['fechaCA']));
        $data['cliente'] == 'default' || $data['cliente'] == null ? $cliente = 2 : $data['cliente'] == 'uno' ?  $cliente = 1: $cliente = 2;
        $data['superficie'] == '' || $data['superficie'] == null ? $superficie =  null: $superficie = $data['superficie'];
        $data['catastral'] == '' || $data['catastral'] == null ? $catastral =  null: $catastral = $data['catastral'];
        $data['rfcDatos'] == 'N/A' ? $rfcDatos =  NULL :$rfcDatos =  $data['rfcDatos'];*/

        /*$construccion = $data['construccion'];
        $estatusPago = $data['estatusPago'];
        $nombrePresupuesto2 = $data['nombrePresupuesto2'];*/

        $id_solicitud = $data['id_solicitud3'];

        $updateData = array(
            "nombre_escrituras" => $data['nombrePresupuesto2'] == '' || $data['nombrePresupuesto2'] == null ? null : $data['nombrePresupuesto2'],
            "estatus_pago" => $data['estatusPago'],
            "superficie" => ($data['superficie'] == '' || $data['superficie'] == null) ? null : $data['superficie'],
            "clave_catastral" => ($data['catastral'] == '' || $data['catastral'] == null) ? null : $data['catastral'],
            "estatus_construccion" => $data['construccion'],
            "cliente_anterior" =>($data['cliente'] == 'default' || $data['cliente'] == null ? 2 : $data['cliente'] == 'uno') ? 1 : 2,
            "nombre_anterior" => $data['nombreT'] == '' || $data['nombreT'] == null ? null : $data['nombreT'],
            "fecha_anterior" => ($data['fechaCA'] == '' || $data['fechaCA'] == null) ? null : date("Y-m-d", strtotime($data['fechaCA'])),
            "RFC" => $data['rfcDatos'] == '' || $data['rfcDatos'] == 'N/A' ? null : $data['rfcDatos']
        );


        //$data = $this->Postventa_model->savePresupuesto($nombreT,$fechaCA,$cliente,$superficie,$catastral,$rfcDatos,$construccion,$nombrePresupuesto2,$id_solicitud,$estatusPago)->row();
        // $this->pdfPresupuesto($id_solicitud);
        $data = $this->Postventa_model->updatePresupuesto($updateData, $id_solicitud);
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
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
        $mail->message('Buen dia, se anexa documentacion de completa para proceder con escrituracion como compraventa del lote citado  al rubro a nombre de ' . $info->nombre_escrituras . ' existe dueño beneficiario, es la señora _____ pido de favor, en su caso, actualizar la cotizacion antes de  la firma, saludos cordiales.');
        $response = $mail->send();
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
                                                    <div>Nombre a quien escritura:</div>
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
        $mail->message('Buen dia me apoyan con el pre-avaluo con valor actual y referido  del lote que se menciona  en la tabla que se anexa ?');
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
                                                    ' . $data->nombre_escrituras . '
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
                                            </tr>
                                            <tr>
                                                <td style="font-size: 1em;">
                                                    <b>¿Tenemos cliente anterior (traspaso, cesión o segunda venta)?:</b><br>
                                                    ' . $data->cliente_anterior . '
                                                </td>
                                                
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

    public function getBudgetNotaria()
    {
        $idSolicitud = $_GET['idSolicitud'];

        $data = $this->Postventa_model->getNotariaClient($idSolicitud)->row();

        if($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    public function rechazarNotaria()
    {
        $idSolicitud = $_POST['idSolicitud'];
        $rol = $this->session->userdata('id_rol');

        $informacion = $this->Postventa_model->rechazarNotaria($idSolicitud);
        return $informacion;

        return $this->Postventa_model->rechazarNotaria($idSolicitud, $rol);
    }

    //OBSERVACIONES
    public function observacionesPostventa()
    {
        $idSolicitud = $_GET['idSolicitud'];
        $rol = $this->session->userdata('id_rol');

        $informacion = $this->Postventa_model->updateObservacionesPostventa($idSolicitud);
        return $informacion;

        return $this->Postventa_model->updateObservacionesPostventa($idSolicitud, $rol);
    }

    public function observacionesProyectos()
    {
        $idSolicitud = $_GET['idSolicitud'];
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
    }


}