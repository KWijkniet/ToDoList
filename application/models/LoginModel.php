<?php
class LoginModel extends CI_Model {
    public function GetUserByEmail($email){
        $this->db->select('*');
        $this->db->from('Users');
        $this->db->where('email', $email);
        $this->db->limit(1);

        $query = $this->db->get();
        return $query->row();
    }

    public function CreateUser($email){
        $data = array(
            'email' => $email,
            'role_id' => '2'
        );
        $this->db->insert('Users', $data);

        $this->db->select('*');
        $this->db->order_by('id','desc');
        $this->db->limit(1);
        $this->db->from('Users');
        $query = $this->db->get();
        return $query->row();
    }

    public function SetUserPassword($id, $pass){
        $this->db->set('password', $pass);
        $this->db->where('id', $id);
        $this->db->update('Users');
    }

    public function GetUsers(){
        $this->db->select('*');
        $this->db->from('Users');
        $query = $this->db->get();
        return $query->result();
    }

    public function ToggleAdmin($id, $value){
        $this->db->set('role_id', $value);
        $this->db->where('id', $id);
        $this->db->update('Users');
    }
}
