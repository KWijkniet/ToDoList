<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//search for "/* $_SESSION['user']['id'] */" and enable these if you want to make user only ToDoList

class Login extends CI_Controller {
	public function __construct(){
        parent::__construct();
        //connect to the LoginModel
        $this->load->model('LoginModel', 'Login');
        $this->load->model('ToDoModel', 'ToDo');
    }

	//check if session is set
    public function CheckLogin(){
        if(isset($_SESSION['user'])){
            echo json_encode($_SESSION['user']);
        }else{
            echo "null";
        }
    }

	//unset session
    public function Logout(){
        if(isset($_SESSION['user'])){
            unset($_SESSION['user']);
        }
    }

	//login the user
    public function Login(){
        $data = $this->GetPostData();
        if(isset($data)){
			//set email and password
            $email = $data['email'];
            $password = $data['password'];
			//get user from db with same email
            $foundUser = (array)$this->Login->GetUserByEmail($email);
			//if user from db has salt key then continue
            if(isset($foundUser['salt_key'])){
				//create protected password from (user from db salt key) + password
                $protectedPass = md5($password . $foundUser['salt_key']);
				//if they match with user from db password
                if($foundUser['password'] == $protectedPass){
                    $_SESSION['user'] = $foundUser;
                    echo json_encode($foundUser);
                }else{
                    echo "null";
                }
            }else{
                echo "null";
            }
        }else{
            echo "null";
        }
    }

	//register new user
    public function Register(){
        $data = $this->GetPostData();
        if(isset($data)){
			//set email and password
            $email = $data['email'];
            $password = $data['password'];
			//create and get user from db
            $createUser = (array)$this->Login->CreateUser($email);
            if(isset($createUser)){
				//create protected password from (user from db salt key) + password
                $protectedPass = md5($password . $createUser['salt_key']);
				//update new user password with protected password
                $this->Login->SetUserPassword($createUser['id'], $protectedPass);
                $_SESSION['user'] = $createUser;
				echo json_encode($createUser);
            }else{
                echo "null";
            }
        }else{
            echo "null";
        }
    }

	//get all users
    public function GetUsers(){
        echo json_encode($this->Login->GetUsers());
    }

	//toggle role_id
    public function ToggleAdmin(){
		$data = $this->GetPostData();
		if(isset($data['id'])){
			$this->Login->ToggleAdmin($data['id'], $data['value']);
		}
    }

	//get tables by user id
	public function GetTableByUser(){
		$data = $this->GetPostData();
		if(isset($data['id'])){
    		$tables = array();
    		$tables = $this->ToDo->GetUserTables($data['id']);
    		if(isset($tables)){
				//get content (items) of each table
    			for($i = 0; $i < count($tables); $i++){
    				$tables[$i] = (array)$tables[$i];
    				$tables[$i]['content'] = (array)$this->ToDo->GetTablesRows($tables[$i]['id']);
    			}
    		}
    		echo json_encode($tables);
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
}
