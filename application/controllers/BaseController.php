<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class BaseController extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function json($object){
        header('Content-Type: application/json');

        echo json_encode($object, JSON_NUMERIC_CHECK);

        exit();
    }

    public function post($key = null){
        $data = json_decode( file_get_contents('php://input'));

        if(!isset($data)){
            return null;
        }

        if(isset($key)){
            if(isset($data->$key)){
                return $data->$key;
            }else{
                return null;
            }
        }

        return $data;
    }

    public function form($key = null){
        $data = (object) $this->input->post();

        if(!isset($data)){
            return null;
        }

        if(isset($key)){
            if(isset($data->$key)){
                return $data->$key;
            }else{
                return null;
            }
        }

        return $data;
    }
}