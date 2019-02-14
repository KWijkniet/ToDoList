<?php
class ToDoModel extends CI_Model {
    public function GetUserTables($userID){
        $this->db->select("*")
        ->from('Tables')
        ->where('user_id', $userID);

        $query = $this->db->get();
        return $query->result();
    }

    public function GetTablesRows($tableID){
        $this->db->select("*")
        ->from('Items')
        ->where('table_id', $tableID);

        $query = $this->db->get();
        return $query->result();
    }

    public function UpdateItem($id, $value){
        $this->db->set('name', $value);
        $this->db->where('id', $id);
        $this->db->update('Items');
    }

    public function AcceptItem($id, $value){
        $this->db->set('completed', $value);
        $this->db->where('id', $id);
        $this->db->update('Items');
    }

    public function UpdateTable($id, $value){
        $this->db->set('name', $value);
        $this->db->where('id', $id);
        $this->db->update('Tables');
    }

    public function CreateItem($id){
        $data = array(
            'table_id' => $id,
            'name' => 'placeholder',
            'completed' => '0'
        );
        $this->db->insert('Items', $data);

        $this->db->select_max('id');
        $this->db->limit(1);
        $query = $this->db->get('Items');
        return $query->row();
    }

    public function CreateTable($id){
        $data = array(
            'name' => 'placeholder',
            'user_id' => $id
        );
        $this->db->insert('Tables', $data);

        $this->db->select_max('id');
        $this->db->limit(1);
        $query = $this->db->get('Tables');
        return $query->row();
    }

    public function DeleteItem($id){
        $this->db->where('id', $id);
        $this->db->delete('Items');
    }

    public function DeleteTable($id){
        $this->db->where('table_id', $id);
        $this->db->delete('Items');

        $this->db->where('id', $id);
        $this->db->delete('Tables');
    }
}
