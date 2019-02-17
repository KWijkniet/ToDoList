<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//search for "/* $_SESSION['user']['id'] */" and enable these if you want to make user only ToDoList

class Dashboard extends CI_Controller {
	public function __construct(){
        parent::__construct();
        //connect to the LoginModel
        $this->load->model('ToDoModel', 'ToDo');
    }

	//show page
	public function index()
	{
		$this->LoadPage('index');
	}

	//get user tables
	public function GetUserTables(){
		$tables = array();
		$tables = $this->ToDo->GetUserTables($_SESSION['user']['id']);
		if(isset($tables)){
			//get content (items) of each table
			for($i = 0; $i < count($tables); $i++){
				$tables[$i] = (array)$tables[$i];
				$tables[$i]['content'] = (array)$this->ToDo->GetTablesRows($tables[$i]['id']);
			}
		}
		echo json_encode($tables);
	}

	//update item (name)
	public function UpdateItem(){
		$data = $this->GetPostData();
		if(isset($data)){
			$this->ToDo->UpdateItem($data['id'], $data['value']);
		}
	}

	//update item (time)
	public function UpdateItemTime(){
		$data = $this->GetPostData();
		if(isset($data)){
			$this->ToDo->UpdateItemTime($data['id'], $data['value']);
		}
	}

	//update table
	public function UpdateTable(){
		$data = $this->GetPostData();
		if(isset($data)){
			$this->ToDo->UpdateTable($data['id'], $data['value']);
		}
	}

	//create item
	public function CreateItem(){
		$data = $this->GetPostData();
		if(isset($data)){
			echo json_encode($this->ToDo->CreateItem($data['table_id']));
		}
	}

	//create table
	public function CreateTable(){
		echo json_encode($this->ToDo->CreateTable($_SESSION['user']['id']));
	}

	//delete item
	public function DeleteItem(){
		$data = $this->GetPostData();
		if(isset($data)){
			$this->ToDo->DeleteItem($data['id']);
		}
	}

	//delete table
	public function DeleteTable(){
		$data = $this->GetPostData();
		if(isset($data)){
			$this->ToDo->DeleteTable($data['id']);
		}
	}

	//accept item
	public function AcceptItem(){
		$data = $this->GetPostData();
		if(isset($data)){
			$this->ToDo->AcceptItem($data['id'], $data['value']);
		}
	}

	//get post data from js post
    public function GetPostData(){
        $postdata = file_get_contents("php://input");
        if(isset($postdata) && !empty($postdata)){
            return json_decode($postdata, true);
        }
        return null;
    }

	//easy to use page loading function (load page with templates based on given name)
	public function LoadPage($pageName){
        $this->load->view('templates/pagetop');
		$this->load->view('pages/'.$pageName);
		$this->load->view('templates/pagebottom');
    }
}
