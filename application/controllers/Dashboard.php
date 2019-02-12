<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct(){
        parent::__construct();
        //connect to the LoginModel
        $this->load->model('ToDoModel', 'ToDo');
    }

	public function index()
	{
		$this->LoadPage('index');
	}

	public function UpdateItem(){
		$data = $this->GetPostData();
		if(isset($data)){
			$this->ToDo->UpdateItem($data['id'], $data['value']);
		}
	}

	public function UpdateTable(){
		$data = $this->GetPostData();
		if(isset($data)){
			$this->ToDo->UpdateTable($data['id'], $data['value']);
		}
	}

	public function CreateItem(){
		$data = $this->GetPostData();
		if(isset($data)){
			echo json_encode($this->ToDo->CreateItem($data['table_id']));
		}
	}

	public function GetUserTables(){
		$tables = $this->ToDo->GetUserTables(0);
		if(isset($tables)){
			for($i = 0; $i < count($tables); $i++){
				$tables[$i] = (array)$tables[$i];
				$tables[$i]['content'] = (array)$this->ToDo->GetTablesRows($tables[$i]['id']);
			}
		}
		echo json_encode($tables);
	}

    public function GetPostData(){
        $postdata = file_get_contents("php://input");
        if(isset($postdata) && !empty($postdata)){
            return json_decode($postdata, true);
        }
        return null;
    }

	public function LoadPage($pageName){
        $this->load->view('templates/pagetop');
		$this->load->view('pages/'.$pageName);
		$this->load->view('templates/pagebottom');
    }
}
