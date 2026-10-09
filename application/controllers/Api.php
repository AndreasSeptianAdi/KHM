<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index($function)
	{
		$this->load->model('apimodel');
		$data 	= $this->apimodel->$function();
		$this->output->set_content_type('application/json');
		echo json_encode( $data );
	}

}

/* End of file  */
/* Location: ./application/controllers/ */