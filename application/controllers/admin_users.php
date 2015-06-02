<?php
class Admin_users extends CI_Controller {
 

    public function __construct()
    {
        parent::__construct();
        $this->load->model('users_model');
        $this->load->model('courses_model');

        if(!$this->session->userdata('is_logged_in')){
            redirect('admin/login');
        }
    }
 

    public function index()
    {

     
        $course_id = $this->input->post('course_id');        
        $search_string = $this->input->post('search_string');        
        $order = $this->input->post('order'); 
        $order_type = $this->input->post('order_type'); 

    
        $config['per_page'] = 5;
        $config['base_url'] = base_url().'admin/users';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 20;
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';

      
        $page = $this->uri->segment(3);


        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0){
            $limit_end = 0;
        } 

    
        if($order_type){
            $filter_session_data['order_type'] = $order_type;
        }
        else{
           
            if($this->session->userdata('order_type')){
                $order_type = $this->session->userdata('order_type');    
            }else{
        
                $order_type = 'Asc';    
            }
        }
    
        $data['order_type_selected'] = $order_type;        


        if($course_id !== false && $search_string !== false && $order !== false || $this->uri->segment(3) == true){ 
           


            if($course_id !== 0){
                $filter_session_data['course_selected'] = $course_id;
            }else{
                $course_id = $this->session->userdata('course_selected');
            }
            $data['course_selected'] = $course_id;

            if($search_string){
                $filter_session_data['search_string_selected'] = $search_string;
            }else{
                $search_string = $this->session->userdata('search_string_selected');
            }
            $data['search_string_selected'] = $search_string;

            if($order){
                $filter_session_data['order'] = $order;
            }
            else{
                $order = $this->session->userdata('order');
            }
            $data['order'] = $order;

            //save session data into the session
            $this->session->set_userdata($filter_session_data);

            //fetch courses data into arrays
            $data['courses2'] = $this->courses_model->get_courses();

            $data['count_users']= $this->users_model->count_users($course_id, $search_string, $order);
            $config['total_rows'] = $data['count_users'];

            //fetch sql data into arrays
            if($search_string){
                if($order){
                    $data['users'] = $this->users_model->get_users($course_id, $search_string, $order, $order_type, $config['per_page'],$limit_end);        
                }else{
                    $data['users'] = $this->users_model->get_users($course_id, $search_string, '', $order_type, $config['per_page'],$limit_end);           
                }
            }else{
                if($order){
                    $data['users'] = $this->users_model->get_users($course_id, '', $order, $order_type, $config['per_page'],$limit_end);        
                }else{
                    $data['users'] = $this->users_model->get_users($course_id, '', '', $order_type, $config['per_page'],$limit_end);        
                }
            }

        }else{

            //clean filter data inside section
            $filter_session_data['course_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
            $data['course_selected'] = 0;
            $data['order'] = 'id';

            //fetch sql data into arrays
            $data['courses2'] = $this->courses_model->get_courses();
            $data['count_users']= $this->users_model->count_users();
            $data['users'] = $this->users_model->get_users('', '', '', $order_type, $config['per_page'],$limit_end);        
            $config['total_rows'] = $data['count_users'];

        }//!isset($course_id) && !isset($search_string) && !isset($order)

   
        $this->pagination->initialize($config);   

        //load the view
        $data['main_content'] = 'admin/users/list';
        $this->load->view('includes/template', $data);  

    }//index

    public function add()
    {
      
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {

            //form validation
            $this->form_validation->set_rules('name', 'name', 'required');
            $this->form_validation->set_rules('image', 'image', 'required');
            $this->form_validation->set_rules('timelearn', 'timelearn', 'required');
            $this->form_validation->set_rules('timeuse', 'timeuse', 'required|time');
            $this->form_validation->set_rules('course_id', 'course_id', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

   
            if ($this->form_validation->run())
            {
                $data_to_store = array(
                    'name' => $this->input->post('name'),
                    'image' => $this->input->post('image'),
                    'timelearn' => $this->input->post('timelearn'),
                    'timeuse' => $this->input->post('timeuse'),          
                    'course_id' => $this->input->post('course_id')
                );
 
                if($this->users_model->store_user($data_to_store)){
                    $data['flash_message'] = TRUE; 
                }else{
                    $data['flash_message'] = FALSE; 
                }

            }

        }
   
        $data['courses2'] = $this->courses_model->get_courses();
        //load the view
        $data['main_content'] = 'admin/users/add';
        $this->load->view('includes/template', $data);  
    }       

    public function update()
    {
        //user id 
        $id = $this->uri->segment(4);
  

        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {

            $this->form_validation->set_rules('name', 'name', 'required');
            $this->form_validation->set_rules('image', 'image', 'required');
            $this->form_validation->set_rules('timelearn', 'timelearn', 'required');
            $this->form_validation->set_rules('timeuse', 'timeuse', 'required|time');
            $this->form_validation->set_rules('course_id', 'course_id', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
  
            if ($this->form_validation->run())
            {
    
                $data_to_store = array(
                    'name' => $this->input->post('name'),
                    'image' => $this->input->post('image'),
                    'timelearn' => $this->input->post('timelearn'),
                    'timeuse' => $this->input->post('timeuse'),          
                    'course_id' => $this->input->post('course_id')
                );
 
                if($this->users_model->update_user($id, $data_to_store) == TRUE){
                    $this->session->set_flashdata('flash_message', 'updated');
                }else{
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }
                redirect('admin/users/update/'.$id.'');

            }

        }

  
        $data['user'] = $this->users_model->get_user_by_id($id);
      
        $data['courses2'] = $this->courses_model->get_courses();
     
        $data['main_content'] = 'admin/users/edit';
        $this->load->view('includes/template', $data);            

    }


    public function delete()
    {
     
        $id = $this->uri->segment(4);
        $this->users_model->delete_user($id);
        redirect('admin/users');
    }

}