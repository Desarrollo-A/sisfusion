<?php
class Migrate extends CI_Controller {
	public function index()
	{
		// load migration library
		$this->load->library('migration');

		if ( ! $this->migration->current())
		{
			echo 'Error ' . $this->migration->error_string();
		} else {
			echo 'Se ejecutó la migración corrcetamente! ';
        }
	}
}
?>
