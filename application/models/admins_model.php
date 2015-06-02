<?php

class Admins_model extends CI_Model {

	public function __construct()
    {
        $this->load->database();
    }

	function validate($username, $password)
	{
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		$query = $this->db->get('admins');
		
		if($query->num_rows == 1)
		{
			return true;
		}
	}


	function get_db_session_data()
	{
		$query = $this->db->select('user_data')->get('ci_sessions');
		$user = array(); 
		foreach ($query->result() as $row)
		{
		    $udata = unserialize($row->user_data);
		  
		    $user['username'] = $udata['username']; 
		    $user['is_logged_in'] = $udata['is_logged_in']; 
		}
		return $user;
	}
	

	function create_member()
	{

		$this->db->where('username', $this->input->post('username'));
		$query = $this->db->get('admins');

        if($query->num_rows > 0){
        	echo '<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>';
			  echo "Username already taken";	
			echo '</strong></div>';
		}else{

			$new_member_insert_data = array(		
				'username' => $this->input->post('username'),
				'password' => md5($this->input->post('password'))						
			);
			$insert = $this->db->insert('admins', $new_member_insert_data);
		    return $insert;
		}
	      
	}
}

