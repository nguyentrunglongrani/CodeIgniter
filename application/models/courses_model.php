<?php
class Courses_model extends CI_Model {
 

    public function __construct()
    {
        $this->load->database();
    }

    public function get_course_by_id($id)
    {
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
    }    

    public function get_courses($search_string=null, $order=null, $order_type='Asc', $limit_start=null, $limit_end=null)
    {
	    
		$this->db->select('*');
		$this->db->from('users');

		if($search_string){
			$this->db->like('name', $search_string);
		}
		$this->db->group_by('id');

		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('id', $order_type);
		}

        if($limit_start && $limit_end){
          $this->db->limit($limit_start, $limit_end);	
        }

        if($limit_start != null){
          $this->db->limit($limit_start, $limit_end);    
        }
        
		$query = $this->db->get();
		
		return $query->result_array(); 	
    }


    function count_courses($search_string=null, $order=null)
    {
		$this->db->select('*');
		$this->db->from('users');
		if($search_string){
			$this->db->like('name', $search_string);
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('id', 'Asc');
		}
		$query = $this->db->get();
		return $query->num_rows();        
    }


    function store_course($data)
    {
		$insert = $this->db->insert('users', $data);
	    return $insert;
	}


    function update_course($id, $data)
    {
		$this->db->where('id', $id);
		$this->db->update('users', $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}


	function delete_course($id){
		$this->db->where('id', $id);
		$this->db->delete('users'); 
	}
 
}
?>	
