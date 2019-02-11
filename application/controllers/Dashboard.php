<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function index()
	{
		$this->LoadPage('index');
	}

	public function LoadPage($pageName){
        $this->load->view('templates/pagetop');
		$this->load->view('pages/'.$pageName);
		$this->load->view('templates/pagebottom');
    }
}
