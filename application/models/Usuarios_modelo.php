<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 */
class Usuarios_modelo extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function getPersonalInformation()
    {
        return $this->db->query("SELECT id_usuario, nombre, apellido_paterno, apellido_materno, correo, usuario, telefono, rfc, usuario, contrasena, forma_pago FROM usuarios WHERE id_usuario = " . $this->session->userdata('id_usuario') . "");
    }

    function updatePersonalInformation($data, $id_usuario)
    {
        $response = $this->db->update("usuarios", $data, "id_usuario = $id_usuario");
        if (!$response) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

    public function getUserByEmail($email)
    {
        $query = "SELECT * FROM usuarios WHERE correo = '$email' AND new_login = 1";

        return $this->db->query($query)->row();
    }

    function getUsersList(){
        $id_rol = $this->session->userdata('id_rol');
        $id_lider = $this->session->userdata('id_lider');
        $validacionTipo = "";
        if ($this->session->userdata('tipo') == 0)
            $validacionTipo = "AND tipo = 0";
        else if ($this->session->userdata('tipo') == 1)
            $validacionTipo = "AND tipo = 1";

        switch ($this->session->userdata('id_rol')) {
            case '54': // POPEA
                return $this->db->query("SELECT usuarios.id_usuario, id_rol, 
                UPPER(CASE WHEN usuarios.nueva_estructura = 1 THEN oxcNE.nombre ELSE opcs_x_cats.nombre END) puesto,
                CONCAT(usuarios.nombre, ' ', apellido_paterno, ' ', apellido_materno) AS nombre, 
                (CASE id_rol WHEN 7 THEN lider ELSE lider_coord END) AS jefe_directo, telefono, UPPER(correo) AS correo, usuarios.estatus, id_lider, id_lider_2, 0 nuevo, 
                usuarios.fecha_creacion, UPPER(s.nombre) sede, usuarios.nueva_estructura, usuarios.simbolico,
                tipoUser.nombre tipoUsuario,
                tipoUser.color colorTipo,
                 usuarios.tipo,usuarios.fac_humano
                FROM usuarios 
                INNER JOIN (SELECT * FROM opcs_x_cats WHERE id_catalogo = 1) opcs_x_cats ON usuarios.id_rol = opcs_x_cats.id_opcion 
                LEFT JOIN (SELECT id_usuario AS id_lid, id_lider AS id_lider_2, CONCAT(apellido_paterno, ' ', apellido_materno, ' ', usuarios.nombre) lider FROM usuarios) AS lider_2 ON lider_2.id_lid = usuarios.id_lider 
                LEFT JOIN (SELECT id_usuario, id_lider AS id_lider3, CONCAT(apellido_paterno, ' ', apellido_materno, ' ', usuarios.nombre) lider_coord FROM usuarios) AS lider_3 ON lider_3.id_usuario = lider_2.id_lid 
                INNER JOIN sedes s ON CAST(s.id_sede AS VARCHAR(45)) = CAST(usuarios.id_sede AS VARCHAR(45))  
                LEFT JOIN opcs_x_cats oxcNE ON oxcNE.id_opcion = usuarios.id_rol AND oxcNE.id_catalogo = 83
                LEFT JOIN opcs_x_cats tipoUser ON tipoUser.id_opcion = usuarios.tipo AND tipoUser.id_catalogo = 124
                WHERE (id_rol IN (7) AND rfc NOT LIKE '%TSTDD%' AND ISNULL(correo, '' ) NOT LIKE '%test_%' AND ISNULL(correo, '' ) NOT LIKE '%OOAM%' AND ISNULL(correo, '') NOT LIKE '%CASA%') $validacionTipo ORDER BY nombre");
                break;
            case '19': // SUBDIRECTOR MKTD
            case '20': // GERENTE MKTD
                return $this->db->query("SELECT u.estatus, u.id_usuario, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre, u.correo,
                u.telefono, 
                CASE WHEN u.nueva_estructura = 1 THEN oxcNE.nombre ELSE oxc.nombre END puesto,
                CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) jefe_directo, s.nombre sede,
                CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) jefe_directo2, 0 nuevo, u.fecha_creacion, u.nueva_estructura, u.simbolico,
                tipoUser.nombre tipoUsuario,
                tipoUser.color colorTipo,
                 u.tipo,usuarios.fac_humano
                FROM usuarios u 
                INNER JOIN sedes s ON CAST(s.id_sede as VARCHAR(45)) = u.id_sede
                LEFT JOIN usuarios us ON us.id_usuario = u.id_lider
                LEFT JOIN usuarios us2 ON us2.id_usuario = us.id_lider
                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.id_rol
                LEFT JOIN opcs_x_cats oxcNE ON oxcNE.id_opcion = u.id_rol AND oxcNE.id_catalogo = 83
                LEFT JOIN opcs_x_cats tipoUser ON tipoUser.id_opcion = u.tipo AND tipoUser.id_catalogo = 124
                WHERE u.estatus = 1 AND u.id_rol IN (7, 9) AND u.rfc NOT LIKE '%TSTDD%' AND ISNULL(u.correo, '' ) NOT LIKE '%test_%' AND oxc.id_catalogo = 1 $validacionTipo ORDER BY s.nombre, nombre");
                break;
            case '4': // ASISTENTE DIRECCIÓN
                return $this->db->query("SELECT usuarios.id_usuario, id_rol, 
                CASE WHEN usuarios.nueva_estructura = 1 THEN oxcNE.nombre ELSE opcs_x_cats.nombre END puesto,
                CONCAT(usuarios.nombre, ' ', apellido_paterno, ' ', apellido_materno) AS nombre, 
                (CASE id_rol WHEN 7 THEN lider ELSE lider_coord END) AS jefe_directo, telefono, correo, usuarios.estatus, id_lider, id_lider_2, 0 nuevo, 
                usuarios.fecha_creacion, s.nombre sede, usuarios.nueva_estructura, usuarios.simbolico, 
                tipoUser.nombre tipoUsuario,
                tipoUser.color colorTipo,
                usuarios.tipo,usuarios.fac_humano
                FROM usuarios 
                INNER JOIN (SELECT * FROM opcs_x_cats WHERE id_catalogo = 1) opcs_x_cats ON usuarios.id_rol = opcs_x_cats.id_opcion 
                LEFT JOIN (SELECT id_usuario AS id_lid, id_lider AS id_lider_2, CONCAT(apellido_paterno, ' ', apellido_materno, ' ', usuarios.nombre) lider FROM usuarios) AS lider_2 ON lider_2.id_lid = usuarios.id_lider 
                LEFT JOIN (SELECT id_usuario, id_lider AS id_lider3, CONCAT(apellido_paterno, ' ', apellido_materno, ' ', usuarios.nombre) lider_coord FROM usuarios) AS lider_3 ON lider_3.id_usuario = lider_2.id_lid 
                INNER JOIN sedes s ON CAST(s.id_sede AS VARCHAR(45)) = CAST(usuarios.id_sede AS VARCHAR(45))  
                LEFT JOIN opcs_x_cats oxcNE ON oxcNE.id_opcion = usuarios.id_rol AND oxcNE.id_catalogo = 83
                LEFT JOIN opcs_x_cats tipoUser ON tipoUser.id_opcion = usuarios.tipo AND tipoUser.id_catalogo = 124
                WHERE (id_rol IN (3, 7, 9) AND rfc NOT LIKE '%TSTDD%' AND ISNULL(correo, '' ) NOT LIKE '%test_%') $validacionTipo ORDER BY nombre");                        
                break;
            case '5': // ASISTENTE SUBDIRECCIÓN
                $correo = "AND ISNULL(correo, '') NOT LIKE '%OOAM%'";
                if($this->session->userdata('id_usuario') == 4888 || $this->session->userdata('id_usuario') == 546) // ADRIANA PEREZ && DIRCE 3 (MÉRIDA) Y 11 (MONTERREY)
                    $id_sede = "(usuarios.id_sede LIKE ('%3%') OR usuarios.id_sede LIKE '%11%') AND";
                else if($this->session->userdata('id_usuario') == 29 || $this->session->userdata('id_usuario') == 7934) // 29 FERNANDA MONJARAZ VE LO DE LEÓN Y GUADALAJARA
                    $id_sede = "(usuarios.id_sede IN ('5', '12', '16')) AND";
                else if($this->session->userdata('id_usuario') == 7310) // 7310	DANAE
                    $id_sede = "(usuarios.id_sede IN ('2', '4', '13', '14', '15')) AND";
                else if (in_array($this->session->userdata('id_usuario'), [30, 7401])) // 30 VALERIA PALACIOS / CLAUDIA LORENA SERRATO VEGA
                    $id_sede = "(usuarios.id_sede IN ('1', '8', '10', '11', '19') OR usuarios.id_sede LIKE '%18%') AND";
                else if (in_array($this->session->userdata('id_usuario'), [6627])) // 30 JUANA GUZMAN
                    $id_sede = "(usuarios.id_sede IN ('6', '12')) AND";
                else if (in_array($this->session->userdata('id_usuario'), [7097, 7096, 13094, 15842])) // 30 GRISSEL, SAMANTHA Y LEONARDO
                    $id_sede = "(usuarios.id_sede IN ('4', '13', '14')) AND";
                else 
                    $id_sede = "(usuarios.id_sede LIKE('%".$this->session->userdata('id_sede')."%')) AND";

                if($this->session->userdata('id_usuario') == 29 || $this->session->userdata('id_usuario') == 7934)
                    $id_usuario = " OR usuarios.id_usuario IN (10105, 9585, 9704, 9404, 10107, 10106)";
                else if($this->session->userdata('id_rol') == 5 && $this->session->userdata('tipo') == 2) {
                    $id_usuario = " AND usuarios.tipo = 2";
                    $id_sede = "";
                    $correo = "";
                }
                else if($this->session->userdata('id_rol') == 5 && $this->session->userdata('tipo') == 3) {
                    $id_usuario = " AND usuarios.tipo = 3";
                    $id_sede = "";
                    $correo = "";
                }
                else 
                    $id_usuario = "";

                    return $this->db->query("SELECT usuarios.id_usuario, id_rol, 
                    CASE WHEN usuarios.id_usuario IN (3, 5, 607, 4) THEN 'Director regional' WHEN usuarios.nueva_estructura = 1 THEN oxcNE.nombre ELSE opcs_x_cats.nombre END AS puesto, 
                    CONCAT(usuarios.nombre, ' ', apellido_paterno, ' ', apellido_materno)
                    AS nombre, (CASE id_rol WHEN 7 THEN lider ELSE lider_coord END) AS jefe_directo, telefono, correo, usuarios.estatus, 
                    id_lider, id_lider_2, 0 nuevo, usuarios.fecha_creacion, s.nombre sede, usuarios.nueva_estructura, usuarios.simbolico,
                    tipoUser.nombre tipoUsuario,
                    tipoUser.color colorTipo,
                     usuarios.tipo,usuarios.fac_humano 
                    FROM usuarios 
                    INNER JOIN (SELECT * FROM opcs_x_cats WHERE id_catalogo = 1) opcs_x_cats ON usuarios.id_rol = opcs_x_cats.id_opcion 
                    LEFT JOIN (SELECT id_usuario AS id_lid, id_lider AS id_lider_2, CONCAT(usuarios.nombre, ' ', apellido_paterno, ' ', apellido_materno) lider  
                    FROM usuarios) AS lider_2 ON lider_2.id_lid = usuarios.id_lider
                    LEFT JOIN (SELECT id_usuario, id_lider AS id_lider3, CONCAT(usuarios.nombre, ' ', apellido_paterno, ' ', apellido_materno) lider_coord  
                    FROM usuarios) AS lider_3 ON lider_3.id_usuario = lider_2.id_lid
                    LEFT JOIN sedes s ON CAST(s.id_sede AS VARCHAR(45)) = CAST(usuarios.id_sede AS VARCHAR(45))
                    LEFT JOIN opcs_x_cats oxcNE ON oxcNE.id_opcion = usuarios.id_rol AND oxcNE.id_catalogo = 83
                    LEFT JOIN opcs_x_cats tipoUser ON tipoUser.id_opcion = usuarios.tipo AND tipoUser.id_catalogo = 124
                    WHERE ($id_sede id_rol IN (2, 3, 7, 9) AND rfc NOT LIKE '%TSTDD%' $correo)
                    $id_usuario
                    $validacionTipo
                    ORDER BY nombre");
                break;
            case '6': // ASISTENTE GERENCIA
                $id_lider = $this->session->userdata('id_lider');
                if ($this->session->userdata('id_usuario') == 895)
                    $where = "((id_lider = $id_lider OR id_lider_2 = $id_lider) AND id_rol IN (7, 9) AND rfc NOT LIKE '%TSTDD%') OR (usuarios.id_usuario = $id_lider OR usuarios.id_lider = 896)";
                else if ($this->session->userdata('id_usuario') == 11656) { // Dulce María Facundo Torres VERÁ USUARIOS DE LA GERENCIA ACTUAL (7886 JESSIKA GUADALUPE NEAVES FLORES) Y LO DE SU ANTERIOR GERENCIA (106 ANA KARINA ARTEAGA LARA)
                    $id_lider = $this->session->userdata('id_lider') . ', 106';
                    $where = "(((id_lider IN ($id_lider) OR id_lider_2 IN ($id_lider)) AND id_rol IN (7, 9) AND (rfc NOT LIKE '%TSTDD%')) OR usuarios.id_usuario IN ($id_lider) OR usuarios.gerente_id IN ($id_lider))";
                }
                else if ($this->session->userdata('id_usuario') == 10270) { // ANDRES BARRERA VENEGAS
                    $id_lider = $this->session->userdata('id_lider') . ', 113';
                    $where = "(((id_lider IN ($id_lider) OR id_lider_2 IN ($id_lider)) AND id_rol IN (7, 9) AND (rfc NOT LIKE '%TSTDD%')) OR usuarios.id_usuario IN ($id_lider) OR usuarios.gerente_id IN ($id_lider))";
                }
                else if ($this->session->userdata('id_usuario') == 479) { // ANDRES BARRERA VENEGAS
                    $id_lider = $this->session->userdata('id_lider') . ', 4223';
                    $where = "(((id_lider IN ($id_lider) OR id_lider_2 IN ($id_lider)) AND id_rol IN (7, 9) AND (rfc NOT LIKE '%TSTDD%')) OR usuarios.id_usuario IN ($id_lider) OR usuarios.gerente_id IN ($id_lider))";
                }
                else if ($this->session->userdata('id_usuario') == 13770) { // ITAYETZI PAULINA CAMPOS GONZALEZ
                    $id_lider = $this->session->userdata('id_lider') . ', 21, 1545';
                    $where = "(((id_lider IN ($id_lider) OR id_lider_2 IN ($id_lider)) AND id_rol IN (7, 9) AND (rfc NOT LIKE '%TSTDD%')) OR usuarios.id_usuario IN ($id_lider) OR usuarios.gerente_id IN ($id_lider))";
                }
                else if ($this->session->userdata('id_usuario') == 12318) { // EMMA CECILIA MALDONADO RAMIREZ
                    $id_lider = $this->session->userdata('id_lider') . ', 1916, 11196, 2599';
                    $where = "(((id_lider IN ($id_lider) OR id_lider_2 IN ($id_lider)) AND id_rol IN (7, 9) AND (rfc NOT LIKE '%TSTDD%')) OR usuarios.id_usuario IN ($id_lider) OR usuarios.gerente_id IN ($id_lider))";
                }
				else if ($this->session->userdata('id_usuario') == 13418) { // MARIA FERNANDA RUIZ PEDROZA
                    $id_lider = $this->session->userdata('id_lider') . ', 5604';
                    $where = "(((id_lider IN ($id_lider) OR id_lider_2 IN ($id_lider)) AND id_rol IN (7, 9) AND (rfc NOT LIKE '%TSTDD%')) OR usuarios.id_usuario IN ($id_lider) OR usuarios.gerente_id IN ($id_lider))";
				}
				else if ($this->session->userdata('id_usuario') == 12855) { // ARIADNA ZORAIDA ALDANA ZAPATA
                    $id_lider = $this->session->userdata('id_lider') . ', 455';
                    $where = "(((id_lider IN ($id_lider) OR id_lider_2 IN ($id_lider)) AND id_rol IN (7, 9) AND (rfc NOT LIKE '%TSTDD%')) OR usuarios.id_usuario IN ($id_lider) OR usuarios.gerente_id IN ($id_lider))";
				}
                else if ($this->session->userdata('id_usuario') == 14649) { // NOEMÍ DE LOS ANGELES CASTILLO CASTILLO
                    $id_lider = $this->session->userdata('id_lider') . ', 12027, 13059, 2599, 609, 11680, 7435';
                    $where = "(((id_lider IN ($id_lider) OR id_lider_2 IN ($id_lider)) AND id_rol IN (7, 9) AND (rfc NOT LIKE '%TSTDD%')) OR usuarios.id_usuario IN ($id_lider) OR usuarios.gerente_id IN ($id_lider))";
				} else if ($this->session->userdata('id_usuario') == 14952) { // GUILLERMO HELI IZQUIERDO VIEYRA
                    $id_lider = $this->session->userdata('id_lider') . ', 13295, 7970';
                    $where = "(((id_lider IN ($id_lider) OR id_lider_2 IN ($id_lider)) AND id_rol IN (7, 9) AND (rfc NOT LIKE '%TSTDD%')) OR usuarios.id_usuario IN ($id_lider) OR usuarios.gerente_id IN ($id_lider))";
				} else if ($this->session->userdata('id_usuario') == 13348) { // VIRIDIANA ZAMORA ORTIZ
                    $id_lider = $this->session->userdata('id_lider') . ', 10063';
                    $where = "(((id_lider IN ($id_lider) OR id_lider_2 IN ($id_lider)) AND id_rol IN (7, 9) AND (rfc NOT LIKE '%TSTDD%')) OR usuarios.id_usuario IN ($id_lider) OR usuarios.gerente_id IN ($id_lider))";
                } else if ($this->session->userdata('id_usuario') == 12576) { // DIANA EVELYN PALENCIA AGUILAR
                    $id_lider = $this->session->userdata('id_lider') . ', 6942';
                    $where = "(((id_lider IN ($id_lider) OR id_lider_2 IN ($id_lider)) AND id_rol IN (7, 9) AND (rfc NOT LIKE '%TSTDD%')) OR usuarios.id_usuario IN ($id_lider) OR usuarios.gerente_id IN ($id_lider))";
                } else if ($this->session->userdata('id_usuario') == 12292) { // REYNALDO HERNANDEZ SANCHEZ
                    $id_lider = $this->session->userdata('id_lider') . ', 6661';
                    $where = "(((id_lider IN ($id_lider) OR id_lider_2 IN ($id_lider)) AND id_rol IN (7, 9) AND (rfc NOT LIKE '%TSTDD%')) OR usuarios.id_usuario IN ($id_lider) OR usuarios.gerente_id IN ($id_lider))";
                } else if ($this->session->userdata('id_usuario') == 16214) { // JESSICA PAOLA CORTEZ VALENZUELA
                    $id_lider = $this->session->userdata('id_lider') . ', 80, 664, 16458, 2599';
                    $where = "(((id_lider IN ($id_lider) OR id_lider_2 IN ($id_lider)) AND id_rol IN (7, 9) AND (rfc NOT LIKE '%TSTDD%')) OR usuarios.id_usuario IN ($id_lider) OR usuarios.gerente_id IN ($id_lider))";
                } else if ($this->session->userdata('id_usuario') == 15110) { // IVONNE BRAVO VALDERRAMA
                    $id_lider = $this->session->userdata('id_lider') . ', 12688';
                    $where = "(((id_lider IN ($id_lider) OR id_lider_2 IN ($id_lider)) AND id_rol IN (7, 9) AND (rfc NOT LIKE '%TSTDD%')) OR usuarios.id_usuario IN ($id_lider) OR usuarios.gerente_id IN ($id_lider))";
                } else if ($this->session->userdata('id_usuario') == 15545) { // PAMELA IVONNE LEE MORENO
                    $id_lider = $this->session->userdata('id_lider') . ', 13059, 11680';
                    $where = "(((id_lider IN ($id_lider) OR id_lider_2 IN ($id_lider)) AND id_rol IN (7, 9) AND (rfc NOT LIKE '%TSTDD%')) OR usuarios.id_usuario IN ($id_lider) OR usuarios.gerente_id IN ($id_lider))";
                } else if ($this->session->userdata('id_usuario') == 15109) { // MARIBEL GUADALUPE RIOS DIAZ
                    $id_lider = $this->session->userdata('id_lider') . ', 10251';
                    $where = "(((id_lider IN ($id_lider) OR id_lider_2 IN ($id_lider)) AND id_rol IN (7, 9) AND (rfc NOT LIKE '%TSTDD%')) OR usuarios.id_usuario IN ($id_lider) OR usuarios.gerente_id IN ($id_lider))";
                } else if ($this->session->userdata('id_usuario') == 16186) { // CAROLINA CORONADO YAÑEZ
                    $id_lider = $this->session->userdata('id_lider') . ', 6942';
                    $where = "(((id_lider IN ($id_lider) OR id_lider_2 IN ($id_lider)) AND id_rol IN (7, 9) AND (rfc NOT LIKE '%TSTDD%')) OR usuarios.id_usuario IN ($id_lider) OR usuarios.gerente_id IN ($id_lider))";
                } else if ($this->session->userdata('id_usuario') == 13511) { // DANYA YOALY LEYVA FLORIAN
                    $id_lider = $this->session->userdata('id_lider') . ', 654, 697, 5604, 10251, 12688';
                    $where = "(((id_lider IN ($id_lider) OR id_lider_2 IN ($id_lider)) AND id_rol IN (7, 9) AND (rfc NOT LIKE '%TSTDD%')) OR usuarios.id_usuario IN ($id_lider) OR usuarios.gerente_id IN ($id_lider))";
                } else if ($this->session->userdata('id_usuario') == 14556) { // KATTYA GUADALUPE CADENA CRUZ
                    $id_lider = $this->session->userdata('id_lider') . ', 113, 24';
                    $where = "(((id_lider IN ($id_lider) OR id_lider_2 IN ($id_lider)) AND id_rol IN (7, 9) AND (rfc NOT LIKE '%TSTDD%')) OR usuarios.id_usuario IN ($id_lider) OR usuarios.gerente_id IN ($id_lider))";
                } else if ($this->session->userdata('id_usuario') == 14946) { // MELANI BECERRIL FLORES
                    $id_lider = $this->session->userdata('id_lider') . ', 7474';
                    $where = "(((id_lider IN ($id_lider) OR id_lider_2 IN ($id_lider)) AND id_rol IN (7, 9) AND (rfc NOT LIKE '%TSTDD%')) OR usuarios.id_usuario IN ($id_lider) OR usuarios.gerente_id IN ($id_lider))";
                } else if ($this->session->userdata('id_usuario') == 16783) { // Mayra Alejandra Angulo Muñiz
                    $id_lider = $this->session->userdata('id_lider') . ', 13821, 234';
                    $where = "(((id_lider IN ($id_lider) OR id_lider_2 IN ($id_lider)) AND id_rol IN (7, 9) AND (rfc NOT LIKE '%TSTDD%')) OR usuarios.id_usuario IN ($id_lider) OR usuarios.gerente_id IN ($id_lider))";
                } else if ($this->session->userdata('id_usuario') == 16813) { // Vanessa Castro Muñoz
                    $id_lider = $this->session->userdata('id_lider') . ', 11680';
                    $where = "(((id_lider IN ($id_lider) OR id_lider_2 IN ($id_lider)) AND id_rol IN (7, 9) AND (rfc NOT LIKE '%TSTDD%')) OR usuarios.id_usuario IN ($id_lider) OR usuarios.gerente_id IN ($id_lider))";
                } else if ($this->session->userdata('id_usuario') == 2987) { // Alan Michell Alba Sánchez
                    $id_lider = $this->session->userdata('id_lider') . ', 6661';
                    $where = "(((id_lider IN ($id_lider) OR id_lider_2 IN ($id_lider)) AND id_rol IN (7, 9) AND (rfc NOT LIKE '%TSTDD%')) OR usuarios.id_usuario IN ($id_lider) OR usuarios.gerente_id IN ($id_lider))";
                } else if ($this->session->userdata('id_usuario') == 17029) { // Karen Ariadna Vazquez Muñoz
                    $id_lider = $this->session->userdata('id_lider') . ', 2080';
                    $where = "(((id_lider IN ($id_lider) OR id_lider_2 IN ($id_lider)) AND id_rol IN (7, 9) AND (rfc NOT LIKE '%TSTDD%')) OR usuarios.id_usuario IN ($id_lider) OR usuarios.gerente_id IN ($id_lider))";
                } else if ($this->session->userdata('id_usuario') == 15716) { // ADRIAN TREJO GUTIERREZ
                    $id_lider = $this->session->userdata('id_lider') . ', 7944';
                    $where = "(((id_lider IN ($id_lider) OR id_lider_2 IN ($id_lider)) AND id_rol IN (7, 9) AND (rfc NOT LIKE '%TSTDD%')) OR usuarios.id_usuario IN ($id_lider) OR usuarios.gerente_id IN ($id_lider))";
                } else if ($this->session->userdata('id_usuario') == 18027) { // ALMA ADRIANA PEREZ DOMINGUEZ
                    $id_lider = $this->session->userdata('id_lider') . ', 113';
                    $where = "(((id_lider IN ($id_lider) OR id_lider_2 IN ($id_lider)) AND id_rol IN (7, 9) AND (rfc NOT LIKE '%TSTDD%')) OR usuarios.id_usuario IN ($id_lider) OR usuarios.gerente_id IN ($id_lider))";
                }
                else
                    $where = "(((id_lider IN ($id_lider) OR id_lider_2 IN ($id_lider)) AND id_rol IN (7, 9) AND (rfc NOT LIKE '%TSTDD%')) OR usuarios.id_usuario IN ($id_lider) OR usuarios.gerente_id IN ($id_lider))";
                
                if($this->session->userdata('id_sede') == 6)
                    $where = "(((id_lider IN ($id_lider) OR id_lider_2 IN ($id_lider)) AND id_rol IN (7, 9) AND (rfc NOT LIKE '%TSTDD%')) OR (usuarios.id_usuario IN (9827)) OR usuarios.id_usuario IN ($id_lider) OR usuarios.gerente_id IN ($id_lider))";
                else if($this->session->userdata('id_sede') == 4)
                    $where = "(((id_lider IN ($id_lider) OR id_lider_2 IN ($id_lider)) AND id_rol IN (7, 9) AND (rfc NOT LIKE '%TSTDD%')) OR (usuarios.id_usuario IN (9359)) OR usuarios.id_usuario IN ($id_lider) OR usuarios.gerente_id IN ($id_lider))";

                return $this->db->query("SELECT usuarios.id_usuario, id_rol, 
                CASE WHEN usuarios.nueva_estructura = 1 THEN oxcNE.nombre ELSE opcs_x_cats.nombre END puesto,
                CONCAT(usuarios.nombre, ' ', apellido_paterno, ' ', apellido_materno)
                AS nombre, (CASE id_rol WHEN 7 THEN lider ELSE lider_coord END) AS jefe_directo, telefono, correo, usuarios.estatus, 
                id_lider, id_lider_2, 0 nuevo, usuarios.fecha_creacion, s.nombre sede, usuarios.nueva_estructura, usuarios.simbolico,
                tipoUser.nombre tipoUsuario,
                tipoUser.color colorTipo,
                usuarios.tipo,usuarios.fac_humano
                FROM usuarios 
                INNER JOIN (SELECT * FROM opcs_x_cats WHERE id_catalogo = 1) opcs_x_cats ON usuarios.id_rol = opcs_x_cats.id_opcion 
                LEFT JOIN (SELECT id_usuario AS id_lid, id_lider AS id_lider_2, CONCAT(usuarios.nombre, ' ', apellido_paterno, ' ', apellido_materno) lider  
                FROM usuarios) AS lider_2 ON lider_2.id_lid = usuarios.id_lider
                LEFT JOIN (SELECT id_usuario, id_lider AS id_lider3, CONCAT(usuarios.nombre, ' ', apellido_paterno, ' ', apellido_materno) lider_coord  
                FROM usuarios) AS lider_3 ON lider_3.id_usuario = lider_2.id_lid
                INNER JOIN sedes s ON CAST(s.id_sede AS VARCHAR(45)) = CAST(usuarios.id_sede AS VARCHAR(45))
                LEFT JOIN opcs_x_cats oxcNE ON oxcNE.id_opcion = usuarios.id_rol AND oxcNE.id_catalogo = 83
                LEFT JOIN opcs_x_cats tipoUser ON tipoUser.id_opcion = usuarios.tipo AND tipoUser.id_catalogo = 124
                WHERE $where
                $validacionTipo
                ORDER BY nombre");
                break;
            case '41': // GENERALISTA
                if($this->session->userdata('id_usuario') == 4585) // PAOLA HURTADO HERNANDEZ 4 (CIUDAD DE MÉXICO) Y 9 (SAN MIGUEL DE ALLENDE)
                    $id_sede = "'4', '9'";
                else 
                    $id_sede = "'".$this->session->userdata('id_sede')."'";

                return $this->db->query("SELECT u.estatus, u.id_usuario, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre, u.correo,
                u.telefono, 
                CASE WHEN u.nueva_estructura = 1 THEN oxcNE.nombre ELSE oxc.nombre END puesto,
                CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) jefe_directo, u.correo, CASE WHEN DAY(u.fecha_creacion) >= 6 AND MONTH(u.fecha_creacion) = MONTH(GETDATE()) AND YEAR(u.fecha_creacion) = YEAR(GETDATE()) THEN 1 ELSE 0 END as nuevo, u.fecha_creacion, s.nombre sede, u.simbolico,
                tipoUser.nombre tipoUsuario,
                tipoUser.color colorTipo,
                 u.tipo,u.fac_humano 
                FROM usuarios u 
                LEFT JOIN usuarios us ON us.id_usuario = u.id_lider
                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.id_rol
                INNER JOIN sedes s ON CAST(s.id_sede AS VARCHAR(45)) = CAST(u.id_sede AS VARCHAR(45))
                LEFT JOIN opcs_x_cats tipoUser ON tipoUser.id_opcion = u.tipo AND tipoUser.id_catalogo = 124
                WHERE oxc.id_catalogo = 1 AND u.id_rol IN (7, 9, 3) AND u.id_sede IN ($id_sede) AND u.rfc NOT LIKE '%TSTDD%' AND ( u.correo IS NULL OR u.correo NOT LIKE '%test_%' ) $validacionTipo ORDER BY nombre");
                break;
            case '13': // CONTRALORÍA
            case '17': // SUBDIRECTOR CONTRALORÍA
            case '70': // EJECUTIVO DE CONTRALORÍA JR
            case '32': // CONTRALORÍA CORPORATIVA
            case '63': // CONTRALORÍA CORPORATIVA
            case '33': // CONSULTA (CONTROL INTERNO)
            case '40': // COBRANZA
            case '73': // PRACTICANTE CONTRALORÍA
            case '80': // COORDINADOR DE CALL CENTER POSTVENTA
            case '81': // SUBDIRECCIÓN POSTVENTA
            case '55': // POSTVENTA
                return $this->db->query("SELECT pci2.abono_pendiente ,CONVERT(varchar,u.fechaIngreso,103) fechaIngreso, u.estatus, u.id_usuario, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre, UPPER(u.correo) AS correo,
                u.telefono, 
                UPPER(CASE WHEN u.id_usuario IN (3, 5, 607, 4) THEN 'Director regional' WHEN u.nueva_estructura = 1 THEN oxcNE.nombre ELSE oxc.nombre END) AS puesto, 
                CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) jefe_directo, u.correo, oxc2.nombre forma_pago, UPPER(s.nombre) AS sede, CASE WHEN DAY(u.fecha_creacion) >= 6 AND MONTH(u.fecha_creacion) = MONTH(GETDATE()) AND YEAR(u.fecha_creacion) = YEAR(GETDATE()) THEN 1 ELSE 0 END as nuevo, CONVERT(VARCHAR,u.fecha_creacion,20) AS fecha_creacion, u.ismktd, UPPER(oxcN.nombre) AS nacionalidad,
                CASE WHEN oxcN.id_opcion = 0 THEN '2D572C' ELSE 'aeaeae' END AS color,oxcn.id_opcion as id_nacionalidad, u.forma_pago as id_forma_pago, u.nueva_estructura, u.simbolico, 
                tipoUser.nombre tipoUsuario,
                tipoUser.color colorTipo,
                u.tipo,u.fac_humano
                FROM usuarios u 
                LEFT JOIN usuarios us ON us.id_usuario = u.id_lider
                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.id_rol AND oxc.id_catalogo = 1
                LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = u.forma_pago AND oxc2.id_catalogo = 16
                LEFT JOIN opcs_x_cats oxcN ON oxcN.id_opcion = u.nacionalidad AND oxcN.id_catalogo = 11
                INNER JOIN sedes s ON s.id_sede = (CASE WHEN LEN (u.id_sede) > 2 THEN 2 ELSE u.id_sede END)
                LEFT JOIN (SELECT SUM(abono_neodata) abono_pendiente, id_usuario FROM pago_comision_ind WHERE estatus=1 and ( descuento_aplicado is null or descuento_aplicado=0) 
                GROUP BY id_usuario) pci2 ON pci2.id_usuario = u.id_usuario
                LEFT JOIN opcs_x_cats oxcNE ON oxcNE.id_opcion = u.id_rol AND oxcNE.id_catalogo = 83
                LEFT JOIN opcs_x_cats tipoUser ON tipoUser.id_opcion = u.tipo AND tipoUser.id_catalogo = 124
                WHERE  u.id_rol IN (1, 2, 3, 7, 9, 25, 26, 27, 29, 30, 36) 
                AND (u.rfc NOT LIKE '%TSTDD%' AND ISNULL(u.correo, '' ) NOT LIKE '%test_%') 
                AND u.id_usuario NOT IN (821, 1366, 1923, 4340, 9623, 9624, 9625, 9626, 9627, 9628, 9629)
                OR u.id_usuario IN (9359, 9827)
                ORDER BY nombre");
                break;
            case '26': // MERCADÓLOGO
                return $this->db->query("SELECT u.estatus, u.id_usuario, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre, u.correo,
                u.telefono, 
                CASE WHEN u.nueva_estructura = 1 THEN oxcNE.nombre ELSE oxc.nombre END puesto,
                CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) jefe_directo, s.nombre sede,
                CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) jefe_directo2, 0 nuevo, u.fecha_creacion, u.nueva_estructura, u.simbolico,
                tipoUser.nombre tipoUsuario,
                tipoUser.color colorTipo,
                 u.tipo,u.fac_humano
                FROM usuarios u 
                INNER JOIN sedes s ON s.id_sede = u.id_sede
                LEFT JOIN usuarios us ON us.id_usuario = u.id_lider
                LEFT JOIN usuarios us2 ON us2.id_usuario = us.id_lider
                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.id_rol
                LEFT JOIN opcs_x_cats oxcNE ON oxcNE.id_opcion = u.id_rol AND oxcNE.id_catalogo = 83
                LEFT JOIN opcs_x_cats tipoUser ON tipoUser.id_opcion = u.tipo AND tipoUser.id_catalogo = 124
                WHERE u.estatus = 1 AND u.id_rol NOT IN (1, 2, 4, 5, 18, 19) AND u.rfc NOT LIKE '%TSTDD%' AND ISNULL(u.correo, '') NOT LIKE '%test_%' AND oxc.id_catalogo = 1 $validacionTipo ORDER BY s.nombre, nombre");
                break;


            case '49': // CONSULTA (CAPITAL HUMANO DESCUENTOS UNIVERSIDAD)
                return $this->db->query("SELECT CONVERT(varchar,u.fechaIngreso,120) fechaIngreso, u.estatus, u.id_usuario, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre, UPPER(u.correo) AS correo,
                u.telefono, UPPER(oxcN.nombre) AS nacionalidad,CONVERT(VARCHAR,u.fecha_creacion,20) AS fecha_alta,
                UPPER(CASE WHEN u.id_usuario IN (3, 5, 607, 4) THEN 'Director regional' WHEN u.nueva_estructura = 1 THEN oxcNE.nombre ELSE oxc.nombre END) AS puesto, 
                CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) jefe_directo, u.correo, UPPER(oxc2.nombre) AS forma_pago,
                UPPER(s.nombre) AS sede, CASE WHEN DAY(u.fecha_creacion) >= 6 AND MONTH(u.fecha_creacion) = MONTH(GETDATE()) AND YEAR(u.fecha_creacion) = YEAR(GETDATE()) THEN 1 ELSE 0 END as nuevo, 
                u.fecha_creacion, CASE WHEN du.id_usuario <> 0 THEN 1 ELSE 0 END as usuariouniv,
                (SELECT (MAX(CONVERT(VARCHAR,fecha_creacion,20))) FROM auditoria aud WHERE u.id_usuario = aud.id_parametro AND aud.tabla='usuarios' AND col_afect='estatus' and anterior='1' and (nuevo='0' OR nuevo='3')) as fecha_baja, u.nueva_estructura, u.simbolico,
                tipoUser.nombre tipoUsuario,
                tipoUser.color colorTipo,
                 u.tipo,u.fac_humano
                FROM usuarios u 
                LEFT JOIN usuarios us ON us.id_usuario = u.id_lider
                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.id_rol AND oxc.id_catalogo = 1
                LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = u.forma_pago AND oxc2.id_catalogo = 16
                INNER JOIN sedes s ON s.id_sede = (CASE WHEN LEN (u.id_sede) > 1 THEN 2 ELSE u.id_sede END)
                LEFT JOIN descuentos_universidad du ON du.id_usuario = u.id_usuario
                LEFT JOIN opcs_x_cats oxcNE ON oxcNE.id_opcion = u.id_rol AND oxcNE.id_catalogo = 83
                LEFT JOIN opcs_x_cats oxcN ON oxcN.id_opcion = u.nacionalidad AND oxcN.id_catalogo = 11
                LEFT JOIN opcs_x_cats tipoUser ON tipoUser.id_opcion = u.tipo AND tipoUser.id_catalogo = 124
                WHERE u.id_usuario not in (select id_usuario_d from relacion_usuarios_duplicados) AND (u.id_rol IN (3, 7, 9, 2) 
                AND (u.rfc NOT LIKE '%TSTDD%' AND ISNULL(u.correo, '' ) NOT LIKE '%test_%') AND u.id_usuario NOT IN (821, 1366, 1923, 4340, 4062, 4064, 4065, 4067, 4068, 4069, 6578, 712 , 9942, 4415, 3, 607, 13151)) OR u.id_usuario IN (9359, 9827)
                ORDER BY nombre");
                break;

            case '8': //SOPORTE
                if($this->session->userdata('id_usuario') != 1297)
                    $id_rol = "AND u.id_rol NOT IN ('18', '19', '20', '1', '28')";
                else 
                    $id_rol = "";
                    
                return $this->db->query("SELECT u.estatus, u.id_usuario, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre, u.correo,
                u.telefono, 
                CASE WHEN u.id_usuario IN (3, 5, 607, 4) THEN 'Director regional' WHEN u.nueva_estructura = 1 THEN oxcNE.nombre ELSE oxc.nombre END puesto, 
                CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) jefe_directo, u.correo, CASE WHEN DAY(u.fecha_creacion) >= 6 AND MONTH(u.fecha_creacion) = MONTH(GETDATE()) AND YEAR(u.fecha_creacion) = YEAR(GETDATE()) THEN 1 ELSE 0 END as nuevo, u.fecha_creacion, s.nombre sede, u.nueva_estructura, u.simbolico,
                tipoUser.nombre tipoUsuario,
                tipoUser.color colorTipo,
                 u.tipo,u.fac_humano
                FROM usuarios u 
                LEFT JOIN usuarios us ON us.id_usuario = u.id_lider
                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.id_rol AND oxc.id_catalogo = 1
                LEFT JOIN sedes s ON CAST(s.id_sede AS VARCHAR(45)) = CAST(u.id_sede AS VARCHAR(45))
                LEFT JOIN opcs_x_cats oxcNE ON oxcNE.id_opcion = u.id_rol AND oxcNE.id_catalogo = 83
                LEFT JOIN opcs_x_cats tipoUser ON tipoUser.id_opcion = u.tipo AND tipoUser.id_catalogo = 124
                WHERE (u.rfc NOT LIKE '%TSTDD%' AND ISNULL(u.correo, '' ) NOT LIKE '%test_%') $id_rol OR u.id_usuario IN (9359, 9827) ORDER BY nombre");
                break;

            default: // VE TODOS LOS REGISTROS
                if($this->session->userdata('id_usuario') != 1)
                    $id_rol = " AND u.id_rol NOT IN ('18', '19', '20','2','1','17','13','32','28')";
                else
                    $id_rol = "";

                return $this->db->query("SELECT u.estatus, u.id_usuario, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre, u.correo,
                u.telefono, 
                CASE WHEN u.id_usuario IN (3, 5, 607, 4) THEN 'Director regional' WHEN u.nueva_estructura = 1 THEN oxcNE.nombre ELSE oxc.nombre END puesto, 
                CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) jefe_directo, u.correo, CASE WHEN DAY(u.fecha_creacion) >= 6 AND MONTH(u.fecha_creacion) = MONTH(GETDATE()) AND YEAR(u.fecha_creacion) = YEAR(GETDATE()) THEN 1 ELSE 0 END as nuevo, u.fecha_creacion, s.nombre sede, u.nueva_estructura, u.simbolico,
                tipoUser.nombre tipoUsuario,
                tipoUser.color colorTipo,
                 u.tipo,u.fac_humano
                FROM usuarios u 
                LEFT JOIN usuarios us ON us.id_usuario = u.id_lider
                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.id_rol AND oxc.id_catalogo = 1
                LEFT JOIN sedes s ON CAST(s.id_sede AS VARCHAR(45)) = CAST(u.id_sede AS VARCHAR(45))
                LEFT JOIN opcs_x_cats oxcNE ON oxcNE.id_opcion = u.id_rol AND oxcNE.id_catalogo = 83
                LEFT JOIN opcs_x_cats tipoUser ON tipoUser.id_opcion = usuarios.tipo AND tipoUser.id_catalogo = 124
                WHERE (u.rfc NOT LIKE '%TSTDD%' AND ISNULL(u.correo, '' ) NOT LIKE '%test_%') $id_rol OR u.id_usuario IN (9359, 9827) ORDER BY nombre");
                break;
        }
    }
    
    function getPaymentMethod()
    {
        return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 16 AND estatus = 1 ORDER BY id_opcion, nombre");
    }

    function getMemberType()
    {
        switch ($this->session->userdata('id_rol')) {
            case '5': // ASISTENTE SUBDIRECCIÓN
                return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 1 AND estatus = 1 AND id_opcion IN (3, 7, 9) ORDER BY nombre");
                break;
            case '4': // ASISTENTE DIRECCIÓN
                return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 1 AND estatus = 1 AND id_opcion IN (7, 9) ORDER BY nombre");
            case '6': // ASISTENTE GERENCIA
                return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 1 AND estatus = 1 AND id_opcion IN (3, 7, 9) ORDER BY nombre");
                break;
            case '41': // GENERALISTA
                return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 1 AND estatus = 1 AND id_opcion IN (7, 9) ORDER BY nombre");
                break;
            default: // VE TODOS LOS REGISTROS (SOPORTE)
                return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 1 AND estatus = 1 ORDER BY nombre");
                break;
        }
    }

    function getHeadquarter()
    {
        switch ($this->session->userdata('id_rol')) {
            case '41': // GENERALISTA
                return $this->db->query("SELECT id_sede id_opcion, nombre FROM sedes WHERE estatus = 1 AND id_sede = " . $this->session->userdata('id_sede') . " ORDER BY nombre");
                break;
            default: // VE TODAS LAS SEDES (SOPORTE)
                return $this->db->query("SELECT id_sede id_opcion, nombre FROM sedes WHERE estatus = 1 ORDER BY nombre");
                break;
        }
    }

    function getLeadersList($headquarter, $type) {
        $id_lider = $this->session->userdata('id_lider');
        switch ($type) {
            case '2': // SUBDIRECTOR
                $validacionSede = '';
                if ($headquarter == 12)
                    $validacionSede = " OR id_sede = '6'";
                return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios 
                WHERE (id_rol = 1 AND estatus = 1) OR (id_usuario = $id_lider) OR ((id_sede LIKE '%$headquarter%' $validacionSede) AND id_rol = 2) ORDER BY nombre");
                break;
            case '3': // GERENTE
                $sede = '';
                $lider = "";
                $validacionSubdirector = "";
                 if ($headquarter == 11)
                    $sede = " OR id_sede='3'";
                else if (in_array($headquarter, array(12, 16)))
                    $sede = " OR id_sede='5'";
                else if (in_array($headquarter, [15, 18]))
                    $sede = " OR id_sede LIKE '%$headquarter%'";
                if (in_array($this->session->userdata('id_rol'), array(5, 6)) && $this->session->userdata('tipo') == 3) // SON DE CASAS, LES VAMOS A MOSTRAR JORGE DE LA CRUZ
                    $validacionSubdirector = "OR id_usuario = 11650";
                if ($this->session->userdata('tipo') == 2) // SON DE UPGRADE
                    $validacionSubdirector = "OR (id_rol = 2 AND estatus = 1 AND tipo = 2)";
                return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                        (id_rol = 2 AND (id_sede LIKE '%$headquarter%' $sede) $lider AND estatus = 1) $validacionSubdirector ORDER BY nombre");
                break;
            case '4': // ASISTENTE DIRECTOR
                return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                        id_rol = 1 AND estatus = 1 ORDER BY nombre");
                break;
            case '5': // ASISTENTE SUBDIRECTOR
                return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                        id_rol = 2 AND id_sede LIKE '%" . $headquarter . "%' AND estatus = 1 ORDER BY nombre");
                break;
            case '6': // ASISTENTE GERENTE
                return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                        id_rol = 3 AND id_sede='$headquarter' AND estatus = 1 ORDER BY nombre");
                break;
            case '7': // ASESOR
                if ($this->session->userdata('id_usuario') == 32) { // VALIDACIÓN ÚNICA PARA ASISTENTE DE GERENTE MONSERRAT - GTE ISABEL
                    return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                        id_rol = 9 AND id_sede='$headquarter' AND estatus = 1
                                        UNION ALL
                                        SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                        id_usuario = " . $this->session->userdata('id_lider') . " AND estatus = 1 ORDER BY nombre");
                } else {
                    return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                        id_rol IN (3, 9) AND id_sede='$headquarter' AND rfc NOT LIKE '%TSTDD%' AND correo NOT LIKE '%test_%' AND estatus = 1 ORDER BY nombre");
                }
                break;
            case '9': // COORDINADOR DE VENTAS
                if ($headquarter == 3) {
                    return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                        id_rol = 3 AND id_sede IN ('3', '6') AND rfc NOT LIKE '%TSTDD%' AND correo NOT LIKE '%test_%' AND estatus = 1 ORDER BY nombre");
                } else {
                    return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                        id_rol = 3 AND id_sede='$headquarter' AND rfc NOT LIKE '%TSTDD%' AND correo NOT LIKE '%test_%' AND estatus = 1 ORDER BY nombre");
                }
                break;
            case '10': // EJECUTIVO ADMINISTRATIVO DE MKTD
            case '19': // SUBDIRECTOR MKTD
            case '25': // ASESOR DE CONTENIDO RRSS
            case '26': // MERCADÓLOGO
            case '27': // COMUNITY MANAGER
            case '28': // EJECUTIVO ADMINISTRATIVO
            case '29': // ASESOR COBRANZA
            case '30': // DESARROLLO WEB
                return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                        id_rol = 18 AND estatus = 1 ORDER BY nombre");
                break;
            case '20': // GERENTE MKTD
                return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                        id_rol = 19 AND id_sede LIKE '%" . $headquarter . "%' AND estatus = 1 ORDER BY nombre");
                break;
            case '22': // EJECUTIVO CLUB MADERAS
                return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                        id_rol = 23 AND estatus = 1 ORDER BY nombre");
                break;
            case '1': // DIRECTOR
            case '8': // SOPORTE
            case '11': // ADMINISTRACIÓN
            case '12': // CAJA
            case '13': // CONTRALORÍA
            case '14': // DIRECCIÓN ADMINISTACIÓN
            case '15': // JURÍDICO
            case '16': // CONTRATACIÓN
            case '17': // SUBDIRECTOR CONTRALORÍA
            case '18': // DIRECTOR MKTD
            case '21': // CLIENTE
            case '23': // SUBDIRECTOR CLUB MADERAS
            case '24': // ASESOR USA
            case '31': // INTERNOMEX
            default:
                return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                        id_rol = 100 AND estatus = 1 ORDER BY nombre");
                break;
        }
    }

    function saveUser($data)
    {
        $nombre_usuario = $data['usuario'];
        $query = $this->db->query("SELECT * FROM usuarios WHERE usuario='".$nombre_usuario."'")->result_array();

        if(count($query)>0){
            $arrayResponse = array(
                "response" =>   -1,
                "data_lastInset" => array()
            );
        } else{
            if ($data != '' && $data != null) {
                $response = $this->db->insert("usuarios", $data);
                $query = $this->db->query("SELECT IDENT_CURRENT('usuarios') as lastId")->result_array();
                $arrayResponse = array(
                    "response" =>   $response,
                    "data_lastInset" => $query
                );

            } else {
                $arrayResponse = array(
                    "response" =>   0,
                    "data_lastInset" => array()
                );
            }
        }

        return $arrayResponse;
    }

    function changeUserStatus($data, $id_usuario)
    {
        $response = $this->db->update("usuarios", $data, "id_usuario = $id_usuario");
        if (!$response) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

    function getUserInformation($id_usuario)
    {
//        $query = $this->db->query("SELECT * FROM usuarios WHERE id_usuario = " . $id_usuario . "");
        $query = $this->db->query("SELECT (SELECT count(*) FROM menu_usuario WHERE id_usuario = ".$id_usuario.")  AS menuUsuario, * 
            FROM usuarios WHERE id_usuario = ".$id_usuario);
        return $query->result_array();
    }

    function updateUser($data, $id_usuario)
    {
        $response = $this->db->update("usuarios", $data, "id_usuario = $id_usuario");
        if (!$response) {
            return 0;
        } else {
            return 1;
        }
    }

    /*------CONSULTAS PARA EL CHAT-----------------------*/

    public function getNationality()
    {
        echo json_encode($this->Clientes_model->getNationality()->result_array());
    }
    public function getEstados()
    {
        echo json_encode($this->Clientes_model->getEstados()->result_array());
    }

    function getAllFoldersPDF()
    {
        $this->db->select("*");
        $this->db->where('estatus', 1);
        $query = $this->db->get('archivos_carpetas');
        return $query;
    }

    function getChangelog($id_usuario)
    {
        switch ($this->session->userdata('id_rol')) {
            case '13': // CONTRALORÍA
            case '17': // SUBDIRECCIÓN CONTRALORÍA
            case '70': // Ejecutivo de contraloría JR
            case '32': // CONTRALORÍA CORPORTATICA
            case '63': // CI AUDITORIA
            case '80': // CONTRALORÍA CORPORTATICA
            case '81': // POSTVENTA
            case '73': // PRACTICANTE CONTRALORIA
                $query = $this->db->query("SELECT CONVERT(VARCHAR,fecha_creacion,20) AS fecha_creacion, creador, 
                (CASE col_afect 
                WHEN 'id_lider' THEN 'líder'
                WHEN 'id_rol' THEN 'rol'
                WHEN 'id_sede' THEN 'sede'
                WHEN 'apellido_paterno' THEN 'apellido paterno'
                WHEN 'apellido_materno' THEN 'apellido materno'
                WHEN 'telefono' THEN 'teléfono'
                WHEN 'forma_pago' THEN 'forma de pago'
                ELSE col_afect
                END
                )parametro_modificado,(
                CASE col_afect
                WHEN 'id_lider' THEN (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) as nombre FROM usuarios WHERE id_usuario = nuevo)
                WHEN 'id_rol' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 1)
                WHEN 'id_sede' THEN (SELECT nombre FROM sedes WHERE id_sede = nuevo)
                WHEN 'estatus' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 3)
                WHEN 'forma_pago' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 16)
                ELSE nuevo  
                END) AS nuevo,(
                CASE col_afect
                WHEN 'id_lider' THEN (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) as nombre FROM usuarios WHERE id_usuario = anterior)
                WHEN 'id_rol' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 1)
                WHEN 'id_sede' THEN (SELECT nombre FROM sedes WHERE id_sede = anterior)
                WHEN 'estatus' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 3)
                WHEN 'forma_pago' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 16)
                ELSE anterior  
                END) AS anterior
                FROM auditoria
                INNER JOIN (SELECT id_usuario AS id_creador, 
                CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS creador  FROM usuarios) 
                AS creadores ON CAST(id_creador AS VARCHAR(255)) = CAST(creado_por AS VARCHAR(255))
                WHERE id_parametro = $id_usuario AND tabla = 'usuarios' ORDER BY fecha_creacion DESC");
                break;
            case '41': // GENERALISTAS
            case '5': // ASISTENTE SUBDIRECCIÓN
            case '6': // ASISTENTE GERENCIA
            case '8': // ASISTENTE SUBDIRECCIÓN
                $query = $this->db->query("SELECT fecha_creacion, creador, 
                (CASE col_afect 
                WHEN 'id_lider' THEN 'líder'
                WHEN 'id_rol' THEN 'rol'
                WHEN 'id_sede' THEN 'sede'
                WHEN 'apellido_paterno' THEN 'apellido paterno'
                WHEN 'apellido_materno' THEN 'apellido materno'
                WHEN 'telefono' THEN 'teléfono'
                WHEN 'forma_pago' THEN 'forma de pago'
                ELSE col_afect
                END
                )parametro_modificado,(
                CASE col_afect
                WHEN 'id_lider' THEN (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) as nombre FROM usuarios WHERE id_usuario = nuevo)
                WHEN 'id_rol' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 1)
                WHEN 'id_sede' THEN (SELECT nombre FROM sedes WHERE id_sede = nuevo)
                WHEN 'estatus' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 3)
                WHEN 'forma_pago' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 16)
                ELSE nuevo  
                END) AS nuevo,(
                CASE col_afect
                WHEN 'id_lider' THEN (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) as nombre FROM usuarios WHERE id_usuario = anterior)
                WHEN 'id_rol' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 1)
                WHEN 'id_sede' THEN (SELECT nombre FROM sedes WHERE id_sede = anterior)
                WHEN 'estatus' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 3)
                WHEN 'forma_pago' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 16)
                ELSE anterior  
                END) AS anterior
                FROM auditoria
                INNER JOIN (SELECT id_usuario AS id_creador, 
                CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS creador  FROM usuarios) 
                AS CAST(id_creador AS VARCHAR(255)) = CAST(creado_por AS VARCHAR(255))
                WHERE id_parametro = $id_usuario AND col_afect NOT IN ('contrasena', 'tiene_hijos', 'sesion_activa', 'imagen_perfil', 'jerarquia_user', 'usuario') AND tabla = 'usuarios' ORDER BY fecha_creacion DESC");
                break;
            case '49': // CAPITAL HUMANO
                $query = $this->db->query("SELECT fecha_creacion, creador, col_afect parametro_modificado,(
                CASE col_afect
                WHEN 'estatus' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 3)
                ELSE nuevo  
                END) AS nuevo,(
                CASE col_afect
                WHEN 'estatus' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 3)
                ELSE anterior  
                END) AS anterior
                FROM auditoria
                INNER JOIN (SELECT id_usuario AS id_creador, 
				CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS creador  FROM usuarios) 
				AS creadores ON CAST(id_creador AS VARCHAR(255)) = CAST(creado_por AS VARCHAR(255))
                WHERE id_parametro = $id_usuario AND tabla = 'usuarios' AND col_afect = 'estatus' ORDER BY fecha_creacion DESC");
                break;
        }
        return $query;
    }



    /**-------OPINION DE CUMPLIMIENTO */
    function Opn_cumplimiento($id_usuario)
    {
        return  $query = $this->db->query("SELECT * FROM opinion_cumplimiento WHERE id_usuario = " . $id_usuario . " order by fecha_creacion desc");
    }

    function SaveCumplimiento($user, $pdf, $opc, $obs = 'NULL')
    {
        $estatus = 1;
        if ($opc == 1) {
            $estatus = 2;
        }

        $respuesta = $this->db->query("INSERT INTO opinion_cumplimiento VALUES ($user,'$pdf',$estatus,GETDATE(), '$obs')");
        if (!$respuesta) {
            return 0;
        } else {
            return 1;
        }
    }

    function updatePDF($id)
    {
        $respuesta = $this->db->query("UPDATE opinion_cumplimiento set estatus=0 WHERE id_opn=$id");

        if (!$respuesta) {
            return 0;
        } else {
            return 1;
        }
    }

    function Update_OPN($usuario)
    {
        $respuesta = $this->db->query("UPDATE opinion_cumplimiento set estatus=2 WHERE id_usuario=$usuario and estatus=1;");

        if (!$respuesta) {
            return 0;
        } else {
            return 1;
        }
    }

    function getPersonalInformation2($id)
    { 
        return $this->db->query("SELECT id_usuario, nombre, apellido_paterno, apellido_materno, correo, usuario, telefono, rfc, usuario, contrasena, forma_pago FROM usuarios WHERE id_usuario = " . $id . "");
    }
    
    public function getChangeLogUsers($id_usuario){
        $query =  $this->db->query("SELECT CONVERT(varchar, fecha_creacion, 120) AS fecha_creacion, ISNULL(creador, 'SIN ESPECIFICAR') creador, col_afect,(
            CASE 
                WHEN col_afect = 'id_lider' THEN (SELECT CONCAT( apellido_paterno,' ',apellido_materno,' ',nombre) as nombre FROM usuarios WHERE id_usuario = nuevo)
                WHEN col_afect = 'personalidad_juridica' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 10)
                WHEN col_afect = 'forma_pago' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 16)
                WHEN col_afect = 'id_sede' THEN (SELECT nombre FROM sedes WHERE CAST(id_sede AS VARCHAR(45)) = CAST(nuevo AS VARCHAR(45)))
                WHEN col_afect = 'id_rol' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 1)
                WHEN col_afect = 'estatus' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 3)
                ELSE nuevo  
            END) AS nuevo,(
            CASE 
                WHEN col_afect = 'id_lider' THEN (SELECT CONCAT( apellido_paterno,' ',apellido_materno,' ',nombre) as nombre FROM usuarios WHERE id_usuario = anterior)
                WHEN col_afect = 'personalidad_juridica' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 10)
                WHEN col_afect = 'forma_pago' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 16)
                WHEN col_afect = 'id_sede' THEN (SELECT nombre FROM sedes WHERE CAST(id_sede AS VARCHAR(45)) = CAST(anterior AS VARCHAR(45)))
                WHEN col_afect = 'id_rol' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 1)
                WHEN col_afect = 'estatus' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 3)

                ELSE anterior  
            END) AS anterior
            FROM auditoria
            LEFT JOIN (SELECT id_usuario AS id_creador, CONCAT(nombre, ' ', apellido_paterno,' ',apellido_materno) AS creador  FROM usuarios) AS creadores ON CAST(id_creador AS VARCHAR(45)) = CAST(creado_por AS VARCHAR(45))
            WHERE id_parametro = $id_usuario AND tabla = 'usuarios' ORDER BY fecha_creacion DESC");
        return $query->result_array();
    }

    function getCatalogs()
    {
        $id_rol = $this->session->userdata('id_rol');
        $whereTwo = "";
        if ($id_rol == 5 || $id_rol == 6) // MJ: ASISTENTE SUBDIRECCIÓN / GERENCIA
            $where = " AND id_opcion IN (2, 3, 7, 9)";
        else if ($id_rol == 4 || $id_rol == 41) { // MJ: ASISTENTE DIRECCIÓN / GENERALISTA
            $where = " AND id_opcion IN (7, 9, 3)";
            if ($id_rol == 41)
                $whereTwo = "AND id_sede = " . $this->session->userdata('id_sede') . "";
        } else if ($id_rol == 8) {
            $where = " AND id_opcion NOT IN (1,2,3,7,9,59)";
        } else // MJ: VE TODOS LOS REGISTROS
            $where = "";

        return $this->db->query("SELECT id_catalogo, id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo IN (16) AND estatus = 1 
        UNION ALL
        SELECT id_catalogo, id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo IN (1) AND estatus = 1 $where
        UNION ALL
        SELECT 0 id_catalogo, id_sede id_opcion, nombre FROM sedes WHERE estatus = 1 $whereTwo
        ORDER BY nombre, id_catalogo");
    }

    function getMktdAvisersList()
    {
        $where = "";
        if ($this->session->userdata('id_rol') == 20)
            $where = " AND u.id_sede IN ('" . $this->session->userdata('id_sede') . "')";
        else {
            if ($this->session->userdata('id_usuario') == 1988)
                $where = " AND u.id_sede IN ('5')";
            else
                $where = " AND u.id_sede IN ('2', '3', '4', '6')";
        }
        return $this->db->query("SELECT u.estatus, u.id_usuario, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre, u.correo,
        u.telefono, oxc.nombre puesto, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) jefe_directo, s.nombre sede,
        CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) jefe_directo2, 0 nuevo, u.fecha_creacion, u.ismktd FROM usuarios u 
        INNER JOIN sedes s ON CAST(s.id_sede as VARCHAR(45)) = u.id_sede
        LEFT JOIN usuarios us ON us.id_usuario = u.id_lider
        LEFT JOIN usuarios us2 ON us2.id_usuario = us.id_lider
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.id_rol
        WHERE u.id_rol IN (7, 9) $where AND u.rfc NOT LIKE '%TSTDD%' AND ISNULL(u.correo, '' ) NOT LIKE '%test_%' AND oxc.id_catalogo = 1 ORDER BY s.nombre, nombre");
    }

    function changeUserType($data, $id_usuario)
    {
        $response = $this->db->update("usuarios", $data, "id_usuario = $id_usuario");
        if (!$response) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

    public function ServicePostCH($url, $data = array())
    {
        $ch = curl_init($url);
        # Setup request to send json via POST.
        $payload = json_encode($data);
        //echo base64_encode($payload);
        curl_setopt($ch, CURLOPT_POSTFIELDS, base64_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        # Return response instead of printing.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        # Send request.
        $result = curl_exec($ch);
        curl_close($ch);
        $row = base64_decode($result);
        return   $row;
    }

    public function UpdateProspect($id_usuario, $id_lider, $rol_seleccionado, $rol_actual, $sedeCH, $sucursal, $datosCH)
    {
        $resultado = 0;
        $url = "https://rh.gphsis.com/index.php/WS/movimiento_interno_asesor";
        if ($rol_seleccionado == $rol_actual) {
            //ENTONCES NO HUBO UN CAMBIO DE ROL
            $query = $this->db->query("SELECT * FROM usuarios WHERE id_usuario = " . $id_usuario . " and id_lider=" . $id_lider . " ")->result_array();
            if (count($query) == 0) {
                //ENTONCES SI CAMBIO DE LIDER
                $getLider = $this->db->query("SELECT u.id_usuario as lider,u2.id_usuario as lider2 FROM usuarios u inner join usuarios u2 on u.id_lider=u2.id_usuario WHERE u.id_usuario = " . $id_lider . " ")->result_array();
                if ($rol_actual == 7) {
                    //ASESOR, CONSULTAR LOS PROSPECTOS QUE TIENE ASIGNADOS DE TIPO 0 
                    $data = array(
                        "id_coordinador" => $id_lider,
                        "id_gerente" => $getLider[0]['lider2'],
                        "fecha_modificacion" => date("Y-m-d H:i:s"),
                        "modificado_por" => $this->session->userdata('id_usuario')
                    );
                    $datosCH['dcontrato']['idpuesto'] = 7;
                    $datosCH['dcontrato']['idgerente'] = $getLider[0]['lider2'];
                    $datosCH['dcontrato']['idcoordinador'] = $id_lider;
                    $datosCH['dcontrato']['idsedech'] = $sedeCH;
                    $datosCH['dcontrato']['idsucursalch'] = $sucursal;
                                 
                    $resultado = $this->Usuarios_modelo->ServicePostCH($url, $datosCH);
                } else if ($rol_actual == 9) {
                    $data = array(
                        "id_coordinador" => $id_usuario,
                        "id_gerente" => $id_lider,
                        "fecha_modificacion" => date("Y-m-d H:i:s"),
                        "modificado_por" => $this->session->userdata('id_usuario')
                    );
                    $dataCH = array(
                        "idasesor" => $id_usuario,
                        "idpuesto" => 9,
                        "idgerente" => $id_lider,
                        "idcoordinador" => $id_usuario,
                        "idsedech" => $sedeCH,
                        "idsucursalch" => $sucursal
                    );
                    $resultado = $this->Usuarios_modelo->ServicePostCH($url, $datosCH);
                    $datosCH['dcontrato']['idpuesto'] = 9;
                    $datosCH['dcontrato']['idgerente'] = $id_lider;
                    $datosCH['dcontrato']['idcoordinador'] = $id_usuario;
                    $datosCH['dcontrato']['idsedech'] = $sedeCH;
                    $datosCH['dcontrato']['idsucursalch'] = $sucursal;
                } else if ($rol_actual == 3) {
                    $data = array(
                        "id_coordinador" => $id_usuario,
                        "id_gerente" => $id_usuario,
                        "fecha_modificacion" => date("Y-m-d H:i:s"),
                        "modificado_por" => $this->session->userdata('id_usuario')
                    );
                    $dataCH = array(
                        "idasesor" => $id_usuario,
                        "idpuesto" => 3,
                        "idgerente" => $id_usuario,
                        "idcoordinador" => $id_usuario,
                        "idsedech" => $sedeCH,
                        "idsucursalch" => $sucursal
                    );
                    $datosCH['dcontrato']['idpuesto'] = 3;
                    $datosCH['dcontrato']['idgerente'] = $id_usuario;
                    $datosCH['dcontrato']['idcoordinador'] = $id_usuario;
                    $datosCH['dcontrato']['idsedech'] = $sedeCH;
                    $datosCH['dcontrato']['idsucursalch'] = $sucursal;
                    $resultado = $this->Usuarios_modelo->ServicePostCH($url, $datosCH);
                }
            } else {
                //NO CAMBIO DE LIDER Y TERMINA EL PROCESO, (SOLO SE ACTUALIZA SU INFO)
                $getLider = $this->db->query("SELECT u.id_usuario as lider,u2.id_usuario as lider2 FROM usuarios u inner join usuarios u2 on u.id_lider=u2.id_usuario WHERE u.id_usuario = " . $id_lider . " ")->result_array();
                $dataCH = array(
                    "idasesor" => $id_usuario,
                    "idpuesto" => $rol_actual,
                    "idgerente" => $getLider[0]['lider2'],
                    "idcoordinador" => $id_lider,
                    "idsedech" => $sedeCH,
                    "idsucursalch" => $sucursal
                );
        
                $datosCH['dcontrato']['idpuesto'] = $rol_actual;
                $datosCH['dcontrato']['idgerente'] = $getLider[0]['lider2'];
                $datosCH['dcontrato']['idcoordinador'] = $id_lider;
                $datosCH['dcontrato']['idsedech'] = $sedeCH;
                $datosCH['dcontrato']['idsucursalch'] = $sucursal;
                $resultado = $this->Usuarios_modelo->ServicePostCH($url, $datosCH);
            }
        } else {
            $getLider = $this->db->query("SELECT u.id_usuario as lider,u2.id_usuario as lider2 FROM usuarios u inner join usuarios u2 on u.id_lider=u2.id_usuario WHERE u.id_usuario = " . $id_lider . " ")->result_array();
            //SI HUBO UN CAMBIO DE ROL
            if ($rol_actual == 7 && $rol_seleccionado == 9) {
                //SE CAMBIO DE ASESOR A COORDINADOR
                $data = array(
                    "id_coordinador" => $id_usuario,
                    "id_gerente" => $id_lider,
                    "fecha_modificacion" => date("Y-m-d H:i:s"),
                    "modificado_por" => $this->session->userdata('id_usuario')
                );
                $dataCH = array(
                    "idasesor" => $id_usuario,
                    "idpuesto" => 9,
                    "idgerente" => $id_lider,
                    "idcoordinador" => $id_usuario,
                    "idsedech" => $sedeCH,
                    "idsucursalch" => $sucursal
                );
                $datosCH['dcontrato']['idpuesto'] = 9;
                $datosCH['dcontrato']['idgerente'] = $id_lider;
                $datosCH['dcontrato']['idcoordinador'] = $id_usuario;
                $datosCH['dcontrato']['idsedech'] = $sedeCH;
                $datosCH['dcontrato']['idsucursalch'] = $sucursal;

                $resultado = $this->Usuarios_modelo->ServicePostCH($url, $datosCH);
            } else if ($rol_actual == 7 && $rol_seleccionado == 3) {
                //SE CAMBIO DE ASESOR A GERENTE
                $datosCH['dcontrato']['idpuesto'] = 3;
                $datosCH['dcontrato']['idgerente'] = $id_usuario;
                $datosCH['dcontrato']['idcoordinador'] = $id_usuario;
                $datosCH['dcontrato']['idsedech'] = $sedeCH;
                $datosCH['dcontrato']['idsucursalch'] = $sucursal;

                $resultado = $this->Usuarios_modelo->ServicePostCH($url, $datosCH);
            } else if ($rol_actual == 9 && $rol_seleccionado == 7) {
                //SE CAMBIO DE COORDINADOR A ASESOR
                $data = array(
                    "id_coordinador" => $id_lider,
                    "id_gerente" => $getLider[0]['lider2'],
                    "fecha_modificacion" => date("Y-m-d H:i:s"),
                    "modificado_por" => $this->session->userdata('id_usuario')
                );
                $dataCH = array(
                "idasesor" => $id_usuario,
                    "idpuesto" => 7,
                    "idcoordinador" => $id_lider,
                    "idgerente" => $getLider[0]['lider2'],
                    "idsedech" => $sedeCH,
                    "idsucursalch" => $sucursal
                );
                $datosCH['dcontrato']['idpuesto'] = 7;
                $datosCH['dcontrato']['idgerente'] = $getLider[0]['lider2'];
                $datosCH['dcontrato']['idcoordinador'] = $id_lider;
                $datosCH['dcontrato']['idsedech'] = $sedeCH;
                $datosCH['dcontrato']['idsucursalch'] = $sucursal;

                $resultado = $this->Usuarios_modelo->ServicePostCH($url, $datosCH);
            } else if ($rol_actual == 9 && $rol_seleccionado == 3) {
                //SE CAMBIO DE COORDINADOR A GERENTE
                $data = array(
                    "id_coordinador" => $id_usuario,
                    "id_gerente" => $id_usuario,
                    "fecha_modificacion" => date("Y-m-d H:i:s"),
                    "modificado_por" => $this->session->userdata('id_usuario')
                );
                $dataCH = array(
                    "idasesor" => $id_usuario,
                    "idpuesto" => 3,
                    "idgerente" => $id_usuario,
                    "idcoordinador" => $id_usuario,
                    "idsedech" => $sedeCH,
                    "idsucursalch" => $sucursal
                );
        
                $datosCH['dcontrato']['idpuesto'] = 3;
                $datosCH['dcontrato']['idgerente'] = $id_usuario;
                $datosCH['dcontrato']['idcoordinador'] = $id_usuario;
                $datosCH['dcontrato']['idsedech'] = $sedeCH;
                $datosCH['dcontrato']['idsucursalch'] = $sucursal;
                $resultado = $this->Usuarios_modelo->ServicePostCH($url, $datosCH);
            } else if ($rol_actual == 3 && $rol_seleccionado == 9) {
                //SE CAMBIO DE GERENTE A COORDINADOR
                $data = array(
                    "id_coordinador" => $id_usuario,
                    "id_gerente" => $id_lider,
                    "fecha_modificacion" => date("Y-m-d H:i:s"),
                    "modificado_por" => $this->session->userdata('id_usuario')
                );
                $dataCH = array(
                    "idasesor" => $id_usuario,
                    "idpuesto" => 9,
                    "idgerente" => $id_lider,
                    "idcoordinador" => $id_usuario,
                    "idsedech" => $sedeCH,
                    "idsucursalch" => $sucursal
                );
                $datosCH['dcontrato']['idpuesto'] = 9;
                $datosCH['dcontrato']['idgerente'] = $id_lider;
                $datosCH['dcontrato']['idcoordinador'] = $id_usuario;
                $datosCH['dcontrato']['idsedech'] = $sedeCH;
                $datosCH['dcontrato']['idsucursalch'] = $sucursal;
                $resultado = $this->Usuarios_modelo->ServicePostCH($url, $datosCH);
            }
            else if ($rol_actual == 3 && $rol_seleccionado == 7) {
                //SE CAMBIO DE GERENTE A ASESOR
                $datosCH['dcontrato']['idpuesto'] = 7;
                $datosCH['dcontrato']['idgerente'] = $getLider[0]['lider2'];
                $datosCH['dcontrato']['idcoordinador'] = $id_lider;
                $datosCH['dcontrato']['idsedech'] = $sedeCH;
                $datosCH['dcontrato']['idsucursalch'] = $sucursal;
                $resultado = $this->Usuarios_modelo->ServicePostCH($url, $datosCH);
            }
        }
              
        $r = json_decode($resultado);
        if (isset($r->resultado)) {
            if ($r->resultado == 1) {
                return json_decode($r->resultado);
            } else {
                return json_decode(0);
            }
        } else {
            return json_decode(0);
        }
    }

    function getUsersListByLeader($idUsuario) {
        $validacionExtra = "";
        if ($this->session->userdata('id_usuario') == 607)
            $validacionExtra = "OR u.id_usuario = 9471";
        return $this->db->query("DECLARE @user INT 
        SELECT @user = $idUsuario
        SELECT u.id_usuario, u.id_rol, UPPER(opcs_x_cats.nombre) AS puesto, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno)
        AS nombre, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) AS jefe_directo, u.telefono, UPPER(u.correo) AS correo, u.estatus, 
        u.id_lider, 0 nuevo, u.fecha_creacion, UPPER(s.nombre) AS sede 
        FROM usuarios u
        INNER JOIN opcs_x_cats ON u.id_rol = opcs_x_cats.id_opcion and id_catalogo = 1
        LEFT JOIN sedes s ON CAST(s.id_sede AS VARCHAR(45)) = CAST(u.id_sede AS VARCHAR(45))
        INNER JOIN usuarios us ON us.id_usuario= u.id_lider
        where u.id_rol in(1,2,3,7,9) and u.rfc NOT LIKE '%TSTDD%' AND u.correo NOT LIKE '%test_%'
        AND (u.id_lider = @user  
        OR u.id_lider in (select u2.id_usuario from usuarios u2 where id_lider = @user )
        OR u.id_lider in (select u2.id_usuario from usuarios u2 where id_lider in (select u2.id_usuario from usuarios u2 where id_lider = @user ))
        $validacionExtra)
        ORDER BY u.id_rol");
    }

    function getUserPassword()
    {
        return $this->db->query("SELECT usuario, contrasena FROM usuarios WHERE id_usuario IN (12874, 10252)");        
    }

    function updatePersonalPassword($data)
    {
        $response = $this->db->update("usuarios", $data, "id_rol = 61");

        if (!$response) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

    function getFormaPago($id_factura)
    {
        return $this->db->query("select * from opcs_x_cats where id_catalogo=16 and id_opcion=$id_factura")->result_array();
    }

    function deleteDocumentoExtranjero($idDocumento)
    {
        $response = $this->db->query("UPDATE opinion_cumplimiento SET estatus = 0 WHERE id_opn = $idDocumento");

        return $response;
    }

    function VerificarComision($idUsuario)
    {
        return $this->db->query("SELECT SUM(abono_neodata) abono_pendiente, id_usuario 
            FROM pago_comision_ind 
            WHERE id_usuario=$idUsuario and estatus=1 and ( descuento_aplicado is null or descuento_aplicado=0) group by id_usuario");
    }

    function DatosProsp($id_usuario)
    {
        $query = $this->db->query("SELECT 
        CASE 
        WHEN u.id_rol = 7 THEN u.id_usuario 
        WHEN u.id_rol = 9 THEN u.id_usuario
        WHEN u.id_rol = 3 THEN u.id_usuario
        ELSE u.id_usuario
        END AS id_usuario_asesor,
        CASE 
        WHEN u.id_rol = 7 THEN c.id_usuario 
        WHEN u.id_rol = 9 THEN u.id_usuario
        WHEN u.id_rol = 3 THEN u.id_usuario
        ELSE u.id_usuario
        END AS id_coordinador,
        CASE 
        WHEN u.id_rol = 7 THEN g.id_usuario 
        WHEN u.id_rol = 9 THEN c.id_usuario 
        WHEN u.id_rol = 3 THEN u.id_usuario
        ELSE u.id_usuario
        END AS id_gerente,
        CASE 
        WHEN u.id_usuario = 2 THEN 0 
        WHEN u.id_rol = 7 THEN s.id_usuario 
        WHEN u.id_rol = 9 THEN g.id_usuario 
        WHEN u.id_rol = 3 THEN c.id_usuario
        ELSE  u.id_usuario END id_subdirector,
        CASE 
        WHEN u.id_usuario = 2 THEN 0 
        WHEN u.id_rol = 7 THEN IIF(r.id_usuario = 2, 0, r.id_usuario) 
        WHEN u.id_rol = 9 THEN IIF(s.id_usuario =2,0,s.id_usuario)
        WHEN u.id_rol = 3 THEN IIF(g.id_usuario=2,0,g.id_usuario)
        ELSE IIF(c.id_usuario=2,0,c.id_usuario) END id_regional
        FROM usuarios u 
        LEFT JOIN usuarios c ON u.id_lider = c.id_usuario
        LEFT JOIN usuarios g ON c.id_lider = g.id_usuario
        LEFT JOIN usuarios s ON g.id_lider = s.id_usuario
        LEFT JOIN usuarios r ON s.id_lider = r.id_usuario
        WHERE u.id_usuario = $id_usuario ");
        return $query;
    }

    function obtenerLideresPorIdUsuario($idUsuario, $idLiderNuevo, $idSedeNueva, $idRolNuevo)
    {
        $idCoordinador = ($idRolNuevo == 7) ? $idLiderNuevo : 'u0.id_lider';
        $idGerente = ($idRolNuevo == 9) ? $idLiderNuevo : 'u1.id_lider';
        $idSubdirector = ($idRolNuevo == 3) ? $idLiderNuevo : 'u2.id_lider';
        $idRegional = ($idRolNuevo == 2 ) ? $idLiderNuevo : 'u3.id_lider';

        $query = $this->db->query("SELECT u0.id_usuario AS id_asesor,
                u1.id_usuario AS id_coordinador,
                (CASE WHEN u0.id_lider = 832 THEN u0.id_lider WHEN u1.id_rol = 3 THEN u1.id_usuario ELSE u2.id_usuario END) AS id_gerente,
                (CASE WHEN u1.id_rol = 3 THEN u1.id_lider WHEN u3.id_usuario IS NOT NULL THEN u3.id_usuario ELSE 0 END) AS id_subdirector,
                CASE WHEN u3.id_usuario = 7092 
                    THEN 3 
                    WHEN u3.id_usuario IN (9471, 681, 609, 690, 2411) 
                        THEN 607 
                        WHEN u3.id_usuario = 692 
                            THEN u3.id_lider 
                            WHEN u3.id_usuario = 703 
                                THEN 4 
                                WHEN u3.id_usuario = 7886 
                                    THEN 5 
                                    WHEN u1.id_rol = 3 
                                    THEN (CASE WHEN (u2.id_lider = 2 OR u3.id_lider = 2)
                                        THEN 0 
                                        ELSE u2.id_lider 
                                    END)
                                ELSE 0 
                END AS id_regional,
                (CASE WHEN (($idSedeNueva = '13' AND u3.id_lider = 7092) OR ($idSedeNueva = '13' AND u2.id_lider = 7092)) 
                    THEN 3 
                        WHEN (($idSedeNueva = '13' AND u3.id_lider = 3) OR ($idSedeNueva = '13' AND u2.id_lider = 3)) 
                        THEN 7092 
                        ELSE 0 
                END) AS id_regional_2
            FROM usuarios u0 -- asesor
            LEFT JOIN usuarios u1 ON u1.id_usuario = (CASE WHEN u0.id_rol IN (9,3,2) THEN u0.id_usuario ELSE $idCoordinador END)  -- coordinador
            LEFT JOIN usuarios u2 ON u2.id_usuario = (CASE WHEN u1.id_rol IN (3,2) THEN u1.id_usuario ELSE $idGerente END) -- gerente
            LEFT JOIN usuarios u3 ON u3.id_usuario = (CASE WHEN u2.id_rol = 2 THEN u2.id_usuario ELSE $idSubdirector END)  -- subdirector
            LEFT JOIN usuarios u4 ON u4.id_usuario = $idRegional  -- regional 1
            LEFT JOIN usuarios u5 ON u5.id_usuario = u4.id_lider  -- regional 2
            WHERE u0.id_usuario = $idUsuario");

        return $query->row();
    }
    function getUserMultirol($id_usuario)
    {
        $query = $this->db->query("SELECT rxu.*,opc.nombre,s.nombre AS sede FROM roles_x_usuario rxu
        INNER JOIN opcs_x_cats opc ON opc.id_opcion=rxu.idRol AND opc.id_catalogo=1
        INNER JOIN sedes s ON s.id_sede = rxu.idSede
        WHERE rxu.idUsuario = " . $id_usuario . " AND rxu.idRol=59");
        return $query->result_array();
    }
    function borrarMulti($idRU,$modificado_por)
    {
        $response = $this->db->query("UPDATE roles_x_usuario SET estatus = 0,modificado_por=$modificado_por WHERE idRU = $idRU");
        return $response;
    }
    function consultarLinea($sede,$puesto,$lider)
    {   
        $sedesSinRegional = array(5,2,3,6);
        $columsQro = in_array($sede,$sedesSinRegional) ? '' : "         
            ,CONCAT(reg.nombre, ' ', reg.apellido_paterno, ' ', reg.apellido_materno) AS regional_1,
            regional.idSede idSedeReg,
            sedeReg.nombre as sedeReg,
            opcReg.nombre puestoReg ";
        $leftQro = in_array($sede,$sedesSinRegional) ? '' : "         
            LEFT JOIN (SELECT idUsuario,idSede,idRol FROM roles_x_usuario WHERE idRol=59 AND estatus=1) regional ON regional.idSede=$sede
            LEFT JOIN usuarios reg ON reg.id_usuario=regional.idUsuario
            LEFT JOIN sedes sedeReg ON sedeReg.id_sede = regional.idSede
            LEFT JOIN opcs_x_cats opcReg ON opcReg.id_opcion=regional.idRol AND opcReg.id_catalogo=1"; 
        $consulta = "";
        if($puesto == 7){
            $consulta = "SELECT 
            (CASE WHEN coor.id_rol = 3 THEN 1 ELSE 0 END) banderaGer,
            (CASE WHEN coor.id_rol = 3 THEN 'N/A' ELSE CONCAT(coor.nombre, ' ', coor.apellido_paterno, ' ', coor.apellido_materno) END) AS coordinador,
			(CASE WHEN coor.id_rol = 3 THEN CONCAT(coor.nombre, ' ', coor.apellido_paterno, ' ', coor.apellido_materno) ELSE CONCAT(ger.nombre, ' ', ger.apellido_paterno, ' ', ger.apellido_materno) END) AS gerente,
            (CASE WHEN coor.id_rol = 3 THEN sedeCoor.nombre ELSE sedeGer.nombre END) as sedeGerente,
			(CASE WHEN coor.id_rol = 3 THEN 'N/A' ELSE sedeCoor.nombre END) sedeCoor,
			(CASE WHEN coor.id_rol = 3 THEN CONCAT(ger.nombre, ' ', ger.apellido_paterno, ' ', ger.apellido_materno) ELSE CONCAT(sub.nombre, ' ', sub.apellido_paterno, ' ', sub.apellido_materno) END) sub,  
            (CASE WHEN coor.id_rol = 3 THEN sedeGer.nombre ELSE sedeSub.nombre END) sedeSubdirector,
			(CASE WHEN coor.id_rol = 3 THEN 'N/A' ELSE coor.id_sede END ) idSedeCoor,
			(CASE WHEN coor.id_rol = 3 THEN coor.id_sede ELSE ger.id_sede END ) idSedeGer,
			(CASE WHEN coor.id_rol = 3 THEN ger.id_sede ELSE sub.id_sede END ) idSedeSub,
			(CASE WHEN coor.id_rol = 3 THEN 'Coordinador de ventas' ELSE opcCoor.nombre END) puestoCoor,
			(CASE WHEN coor.id_rol = 3 THEN opcCoor.nombre ELSE opcGer.nombre END ) puestoGer,
			(CASE WHEN coor.id_rol = 3 THEN opcGer.nombre ELSE opcSub.nombre  END ) puestoSub
            $columsQro       
            FROM usuarios coor
            LEFT JOIN usuarios ger ON ger.id_usuario = coor.id_lider
            LEFT JOIN usuarios sub ON sub.id_usuario = ger.id_lider
            LEFT JOIN sedes sedeCoor ON sedeCoor.id_sede = coor.id_sede
            LEFT JOIN sedes sedeGer ON sedeGer.id_sede = ger.id_sede
            LEFT JOIN sedes sedeSub ON sedeSub.id_sede = sub.id_sede
            $leftQro
            LEFT JOIN opcs_x_cats opcCoor ON opcCoor.id_opcion=coor.id_rol AND opcCoor.id_catalogo=1
            LEFT JOIN opcs_x_cats opcGer ON opcGer.id_opcion=ger.id_rol AND opcGer.id_catalogo=1
            LEFT JOIN opcs_x_cats opcSub ON opcSub.id_opcion=sub.id_rol AND opcSub.id_catalogo=1
            WHERE coor.id_usuario = $lider";
        }
        if($puesto == 9){
            $consulta = "SELECT 
            0 banderaGer,
			CONCAT(ger.nombre, ' ', ger.apellido_paterno, ' ', ger.apellido_materno) AS gerente,
            sedeGer.nombre as sedeGerente,
            opcGer.nombre  puestoGer,
            ger.id_sede  idSedeGer,
			CONCAT(sub.nombre, ' ', sub.apellido_paterno, ' ', sub.apellido_materno) sub,  
            sedeSub.nombre  sedeSubdirector,
			sub.id_sede  idSedeSub,
			opcSub.nombre puestoSub
            $columsQro       
            FROM usuarios ger
            LEFT JOIN usuarios sub ON sub.id_usuario = ger.id_lider 
            LEFT JOIN sedes sedeGer ON sedeGer.id_sede = ger.id_sede
            LEFT JOIN sedes sedeSub ON sedeSub.id_sede  = (CASE sub.id_usuario 	WHEN 2 THEN 2 ELSE sub.id_sede END) 
            $leftQro
            LEFT JOIN opcs_x_cats opcGer ON opcGer.id_opcion=ger.id_rol AND opcGer.id_catalogo=1
            LEFT JOIN opcs_x_cats opcSub ON opcSub.id_opcion=sub.id_rol AND opcSub.id_catalogo=1
            WHERE ger.id_usuario = $lider";
        }
        if($puesto == 3){
            $consulta = "SELECT 
            0 banderaGer,
			CONCAT(sub.nombre, ' ', sub.apellido_paterno, ' ', sub.apellido_materno) sub,  
            sedeSub.nombre  sedeSubdirector,
			sub.id_sede  idSedeSub,
			opcSub.nombre puestoSub
            $columsQro       
            FROM usuarios sub
            LEFT JOIN opcs_x_cats opcSub ON opcSub.id_opcion=sub.id_rol AND opcSub.id_catalogo=1
            LEFT JOIN sedes sedeSub ON sedeSub.id_sede  = (CASE sub.id_usuario 	WHEN 2 THEN 2 ELSE sub.id_sede END) 
            $leftQro
            WHERE sub.id_usuario = $lider";
        }
        $response = $this->db->query($consulta);
        return $response;
    }


    public function getOptionByIdRol($id_rol){
        $query = $this->db->query("SELECT * FROM menu2 WHERE rol=".$id_rol." AND estatus=1");
        return $query->result_array();
    }

    public function getMenuUsuarioByIdUsuario($id_usuario){
        $query = $this->db->query("SELECT * FROM menu_usuario WHERE id_usuario=".$id_usuario);
        return $query->result_array();
    }

    public function getBitacoraUsuarios() {
        $query = "WITH ultimoCambio AS (
                    SELECT aud.id_parametro, aud.col_afect, aud.anterior, aud.nuevo, aud.fecha_creacion, 
                        ROW_NUMBER() OVER (PARTITION BY aud.id_parametro ORDER BY aud.fecha_creacion DESC) AS rn, aud.tabla
                    FROM auditoria aud
                    WHERE aud.col_afect IN ('estatus', 'id_rol', 'id_sede', 'id_lider') 
                    AND aud.tabla = 'usuarios'
                ),
                sede_anterior AS (
                    SELECT us.id_usuario, TRIM(value) AS id_sede
                    FROM usuarios us
                    JOIN ultimoCambio aud ON aud.id_parametro = us.id_usuario AND aud.rn = 1
                    CROSS APPLY STRING_SPLIT(TRY_CAST(aud.anterior AS VARCHAR), ',')
                    WHERE aud.col_afect = 'id_sede'
                ),
                sede_nuevo AS (
                    SELECT us.id_usuario, TRIM(value) AS id_sede
                    FROM usuarios us
                    JOIN ultimoCambio aud ON aud.id_parametro = us.id_usuario AND aud.rn = 1
                    CROSS APPLY STRING_SPLIT(TRY_CAST(aud.nuevo AS VARCHAR), ')')
                    WHERE aud.col_afect = 'id_sede'
                ),

                sede_anterior_names AS (
                    SELECT sa.id_usuario, STRING_AGG(s.nombre, ',') AS sedes_anterior_nombres
                    FROM sede_anterior sa 
                    LEFT JOIN sedes s ON s.id_sede = TRY_CAST(sa.id_sede AS INT)
                    GROUP BY sa.id_usuario
                ),
                sede_nuevo_names AS (
                    SELECT sn.id_usuario, STRING_AGG(s.nombre, ', ') AS sedes_nuevos_nombres
                    FROM sede_nuevo sn
                    LEFT JOIN sedes s ON s.id_sede = TRY_CAST(sn.id_sede AS INT)
                    GROUP BY sn.id_usuario
                )

                SELECT UPPER(opc.nombre) AS estatus, us.id_usuario AS ID, us.nombre AS nombreUsuario, CONCAT(us.apellido_paterno, ' ', us.apellido_materno) AS usApellidos, us.correo,us.telefono,
                CONCAT(jefe.nombre, ' ', jefe.apellido_paterno, ' ', jefe.apellido_materno) AS jefeDirecto,opc2.nombre AS puesto,us.fecha_creacion AS fechaUsuario,
                UPPER(  COALESCE(CASE WHEN aud.col_afect = 'estatus' AND TRY_CAST(aud.anterior AS VARCHAR) != TRY_CAST(aud.nuevo AS VARCHAR) 
                THEN CONCAT(FORMAT(aud.fecha_creacion, 'dd MMMMM', 'es-ES'), ' estatus (',estatusAnterior.nombre, ' - ', estatusNuevo.nombre,')')            
                WHEN aud.col_afect = 'id_rol' and aud.anterior != aud.nuevo 
                THEN CONCAT(FORMAT(aud.fecha_creacion, 'dd MMMMM', 'es-ES'), ' rol (',TRY_CAST(lastRol.nombre AS VARCHAR), ' - ',TRY_CAST(newRol.nombre AS VARCHAR), ')')            
                WHEN aud.col_afect = 'id_sede' AND aud.anterior != aud.nuevo
                THEN CONCAT(FORMAT(aud.fecha_creacion, 'dd MMMM', 'es-ES'), 'sede (', COALESCE(san.sedes_anterior_nombres, 'SIN SEDE'), ' - ', COALESCE(snn.sedes_nuevos_nombres, 'SIN SEDES'), ')')                
                WHEN aud.col_afect = 'id_lider' AND TRY_CAST(aud.anterior AS INT) != TRY_CAST(aud.nuevo AS INT) 
                THEN CONCAT(FORMAT(aud.fecha_creacion, 'dd MMMM', 'es-ES'), ' lider (', TRY_CAST(CASE WHEN concat(anteriorName.nombre, ' ', anteriorName.apellido_paterno, ' ', anteriorName.apellido_materno)
                = '  ' then 'SIN ESPECIFICAR' ELSE upper(concat(anteriorName.nombre, ' ', anteriorName.apellido_paterno, ' ', anteriorName.apellido_materno))END 
                AS VARCHAR(MAX)), ' - ', 
                TRY_CAST(CASE WHEN CONCAT(nuevoName.nombre, ' ', nuevoName.apellido_paterno, ' ', nuevoName.apellido_materno) = '  ' THEN 'SIN ESPECIFICAR'
                ELSE UPPER(CONCAT(nuevoName.nombre, ' ', nuevoName.apellido_paterno, ' ', nuevoName.apellido_materno)) END AS VARCHAR(MAX)), ')') END, 'SIN CAMBIOS')) AS cambiosRealizados, 
                CASE WHEN aud.fecha_creacion IS NULL THEN GETDATE() ELSE aud.fecha_creacion END AS fecha_creacion
                        
                FROM usuarios us
                LEFT JOIN opcs_x_cats opc ON opc.id_opcion = us.estatus AND opc.id_catalogo = 3
                LEFT JOIN opcs_x_cats  opc2 ON opc2.id_opcion = us.id_rol  AND opc2.id_catalogo = 1
                LEFT JOIN usuarios jefe ON jefe.id_usuario  = us.id_lider
                LEFT JOIN ultimoCambio aud ON aud.id_parametro = us.id_usuario AND aud.rn = 1

                --CAMBIO ESTATUS
                LEFT JOIN opcs_x_cats estatusAnterior ON estatusAnterior.id_opcion = TRY_CAST(aud.anterior AS INT) AND estatusAnterior.id_catalogo = 3 
                LEFT JOIN opcs_x_cats estatusNuevo ON estatusNuevo.id_opcion = TRY_CAST(aud.nuevo AS INT) AND estatusNuevo.id_catalogo = 3

                --CAMBIO LIDER
                LEFT JOIN usuarios anteriorName ON CASE WHEN aud.col_afect = 'id_lider' THEN TRY_CAST(aud.anterior AS INT) ELSE NULL END = anteriorName.id_usuario AND aud.col_afect = 'id_lider'
                LEFT JOIN usuarios nuevoName ON CASE when aud.col_afect = 'id_lider' THEN TRY_CAST(aud.nuevo AS INT ) ELSE NULL END = nuevoName.id_usuario AND aud.col_afect = 'id_lider'

                --CAMBIO ID ROL
                LEFT JOIN opcs_x_cats lastRol on case when aud.col_afect = 'id_rol' then try_cast(aud.anterior as int) else null end = lastRol.id_opcion and aud.col_afect = 'id_rol' AND lastRol.id_catalogo = 1
                LEFT JOIN opcs_x_cats newRol on case when aud.col_afect = 'id_rol' then try_cast(aud.nuevo as int) else null end = newRol.id_opcion and aud.col_afect = 'id_rol' AND newRol.id_catalogo = 1

                --CAMBIO SEDES
                LEFT JOIN sede_anterior_names san ON san.id_usuario = us.id_usuario
                LEFT JOIN sede_nuevo_names snn ON snn.id_usuario = us.id_usuario

                WHERE us.id_rol IN (7,9,3,2) AND aud.rn = 1
                GROUP BY opc.nombre, us.id_usuario, us.nombre, ,us.fecha_creacion,CONCAT(us.apellido_paterno, ' ', us.apellido_materno), us.correo,
                CONCAT(jefe.nombre, ' ', jefe.apellido_paterno, ' ', jefe.apellido_materno), opc2.nombre, aud.col_afect, aud.anterior, aud.nuevo, aud.fecha_creacion, estatusAnterior.nombre, 
                estatusNuevo.nombre, aud.fecha_creacion, lastRol.nombre, newRol.nombre, concat(anteriorName.nombre, ' ', anteriorName.apellido_paterno, ' ', anteriorName.apellido_materno) ,
                concat(nuevoName.nombre, ' ', nuevoName.apellido_paterno, ' ', nuevoName.apellido_materno),us.telefono, san.sedes_anterior_nombres, snn.sedes_nuevos_nombres";

                return $query->result_array();
    }


}
