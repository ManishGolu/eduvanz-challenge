<?php
class ApiDataLogic extends CI_Model{
  public function saveRegistration($paramArray){
    $this->db->insert('participants', $paramArray);
  }

  public function updateParticipant($id, $updateParamArray){
    $this->db->where('id',$id)->update('participants',$updateParamArray);
  }

  public function getList($minID, $maxID){
    $this->db->select('*');
    $this->db->from('participants');
    $this->db->where("id BETWEEN ".$minID." AND ".$maxID);
    $query = $this->db->get();
    $rows = $query->result();
    return $rows;
  }

  public function searchInput($searchValue){
    $this->db->select('*');
    $this->db->from('participants');
    $this->db->like('name', $searchValue);
    $this->db->or_like('locality', $searchValue);
    $query = $this->db->get();
    $rows = $query->result();
    return $rows;
  }

  public function totalRows(){
    $this->db->select('*');
    $this->db->from('participants');
    $query = $this->db->get();
    return $query->num_rows();
  }

}
 ?>
