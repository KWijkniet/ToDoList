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

    public function UpdateTable($id, $value){
        $this->db->set('name', $value);
        $this->db->where('id', $id);
        $this->db->update('Tables');
    }
}
