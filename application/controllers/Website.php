<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Website extends MY_Controller {
	function __construct(){
		parent::__construct();
        //logrequest();
	}
    
    public function index(){
		$this->load->view('website/index');
	}
}
