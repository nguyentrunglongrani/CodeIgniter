<?php
class Users_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_user_by_id($id)
    {
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
    }

 
    public function get_users($course_id=null, $search_string=null, $order=null, $order_type='Asc', $limit_start, $limit_end)
    {
	    
		$this->db->select('users.id');
		$this->db->select('users.name');
		$this->db->select('users.image');
		$this->db->select('users.timelearn');
		$this->db->select('users.timeuse');
		$this->db->select('users.course_id');
		$this->db->select('courses.course as course_name');
		$this->db->from('users');
		if($course_id != null && $course_id != 0){
			$this->db->where('course_id', $course_id);
		}
		if($search_string){
			$this->db->like('name', $search_string);
		}

		$this->db->join('courses', 'users.course_id = courses.id', 'left');

		$this->db->group_by('users.id');

		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('id', $order_type);
		}


		$this->db->limit($limit_start, $limit_end);
		//$this->db->limit('4', '4');


		$query = $this->db->get();
		return $query->result_array(); 	
    }


    function count_users($course_id=null, $search_string=null, $order=null)
    {
		$this->db->select('*');
		$this->db->from('users');
		if($course_id != null && $course_id != 0){
			$this->db->where('course_id', $course_id);
		}
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

    function store_user($data)
    {
		$insert = $this->db->insert('users', $data);
	    return $insert;
	}


    function update_user($id, $data)
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

	function delete_user($id){
		$this->db->where('id', $id);
		$this->db->delete('users'); 
	}
 
}
?>	
