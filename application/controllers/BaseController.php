<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require 'vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;

class BaseController extends CI_Controller {
    public function __construct() {
        parent::__construct();

        $storage = new StorageClient([
            //'keyFilePath' => APPPATH . 'config/google.json'
        ]);

        $this->bucket = $storage->bucket('bucket_prueba_php');
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

    public function get($key = null){
        $data = (object) $this->input->get();

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

    public function file($key = null){
        $data = (object) $_FILES;

        if(!isset($data)){
            return null;
        }

        if(isset($key)){
            if(isset($data->$key)){
                return (object) $data->$key;
            }else{
                return null;
            }
        }

        return $data;
    }

    public function upload($path, $filename){
        $file = $this->bucket->upload(
            fopen($path, 'r'),
            [
                'name' => $filename,
            ]
        );

        if($file->exists()){
            return True;
        }

        return False;
    }
}