<?php
class ToDoModel extends CI_Model {
    //get all user tables
    public function GetUserTables($userID){
        $this->db->select("*")
        ->from('Tables')
        ->where('user_id', $userID);

        $query = $this->db->get();
        return $query->result();
    }

    //get all user items via table id
    public function GetTablesRows($tableID){
        $this->db->select("*")
        ->from('Items')
        ->where('table_id', $tableID);

        $query = $this->db->get();
        return $query->result();
    }

    //update item (name)
    public function UpdateItem($id, $value){
        $this->db->set('name', $value);
        $this->db->where('id', $id);
        $this->db->update('Items');
    }

    //update item (time)
    public function UpdateItemTime($id, $value){
        $this->db->set('time', $value);
        $this->db->where('id', $id);
        $this->db->update('Items');
    }

    //accept item
    public function AcceptItem($id, $value){
        $this->db->set('completed', $value);
        $this->db->where('id', $id);
        $this->db->update('Items');
    }

    //update table
    public function UpdateTable($id, $value){
        $this->db->set('name', $value);
        $this->db->where('id', $id);
        $this->db->update('Tables');
    }

    //create item
    public function CreateItem($id){
        $data = array(
            'table_id' => $id,
            'name' => 'placeholder',
            'completed' => '0',
            'time' => 0
        );
        $this->db->insert('Items', $data);

        $this->db->select_max('id');
        $this->db->limit(1);
        $query = $this->db->get('Items');
        return $query->row();
    }

    //create table
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

    //delete item
    public function DeleteItem($id){
        $this->db->where('id', $id);
        $this->db->delete('Items');
    }

    //delete table with all items
    public function DeleteTable($id){
        $this->db->where('table_id', $id);
        $this->db->delete('Items');

        $this->db->where('id', $id);
        $this->db->delete('Tables');
    }
}
