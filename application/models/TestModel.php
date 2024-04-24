<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class TestModel extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

    public function getLotes(){
        $query = "SELECT TOP 10 * FROM lotes";

        return $this->db->query($query)->result();
    }

}