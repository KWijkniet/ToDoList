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

    public function CheckLogin(){
        if(isset($_SESSION['user'])){
            echo json_encode($_SESSION['user']);
        }else{
            echo "null";
        }
    }

    public function Logout(){
        if(isset($_SESSION['user'])){
            unset($_SESSION['user']);
        }
    }

    public function Login(){
        $data = $this->GetPostData();
        if(isset($data)){
            $email = $data['email'];
            $password = $data['password'];

            $foundUser = (array)$this->Login->GetUserByEmail($email);
            if(isset($foundUser['salt_key'])){
                $protectedPass = md5($password . $foundUser['salt_key']);
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

    public function Register(){
        $data = $this->GetPostData();
        if(isset($data)){
            $email = $data['email'];
            $password = $data['password'];

            $createUser = (array)$this->Login->CreateUser($email);
            if(isset($createUser)){
                $protectedPass = md5($password . $createUser['salt_key']);
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

    public function GetUsers(){
        echo json_encode($this->Login->GetUsers());
    }

    public function ToggleAdmin(){
		$data = $this->GetPostData();
		if(isset($data['id'])){
			$this->Login->ToggleAdmin($data['id'], $data['value']);
		}
    }

	public function GetTableByUser(){
		$data = $this->GetPostData();
		if(isset($data['id'])){
    		$tables = array();
    		$tables = $this->ToDo->GetUserTables($data['id']);
    		if(isset($tables)){
    			for($i = 0; $i < count($tables); $i++){
    				$tables[$i] = (array)$tables[$i];
    				$tables[$i]['content'] = (array)$this->ToDo->GetTablesRows($tables[$i]['id']);
    			}
    		}
    		echo json_encode($tables);
		}
	}

    public function GetPostData(){
        $postdata = file_get_contents("php://input");
        if(isset($postdata) && !empty($postdata)){
            return json_decode($postdata, true);
        }
        return null;
    }
}
