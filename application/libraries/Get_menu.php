<?php
    class get_menu{
        private $_CI;   
        public function __construct()
        {
            $this->_CI = & get_instance();
            $this->_CI->load->model('General_model','gm');
        }

        function get_menu_data($id_rol){
            
            if ($id_rol == FALSE) {
                redirect(base_url());
            }
            $datos = array();
            $datos['datos2'] = $this->_CI->gm->get_menu($id_rol)->result();
            $datos['datos3'] = $this->_CI->gm->get_children_menu($id_rol)->result();
    		$val = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
            $salida = str_replace('' . base_url() . '', '', $val);
            $datos['datos4'] = $this->_CI->gm->get_active_buttons($salida, $id_rol)->result();
            return $datos;
        }
    }
?>