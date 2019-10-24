<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
class Category extends REST_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('m_category');

	}
	// private function has_child($category_id){
	// 	$children=$this->m_category->get_category_child($category_id);
	// 	$output['data']['children'] =$children->result_array();
	// 	foreach ($data as $key => $value) {
	// 		# code...
	// 	}
	// }
	// public function list_child_get(){

	// }
	public function list_get(){
		$headers = $this->input->request_headers();
		if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            //TODO: Change 'token_timeout' in application\config\jwt.php
			$decodedToken = AUTHORIZATION::validateTimestamp($headers['Authorization']);
            // return response if token is valid
			if ($decodedToken != false) {
				$output['status']='true';
				$output['message']='Load data Successfully';
				if ($this->input->get('category_parent')) {
					$data=$this->m_category->get_category_child($this->input->get('category_parent'));
				}
				else{
					$data=$this->m_category->get_category();
				}
				
				$output['data']=$data->result_array(); 
				$i=0;

				foreach ($data->result_array() as $parent) {

					$children=$this->m_category->get_category_child($parent['category_id']);
					if(!empty($children->result())){
						$output['data'][$i]['has_child']=true;
					} else {
						$output['data'][$i]['has_child']=false;
					}
					
					$i++;
				}

			}
			else
			{
				$output['status']='false';
				$output['message']='Unauthorised';
			}
		}
		else {
			$output['status']='false';
			$output['message']='Unauthorised';
		}

		$this->set_response($output, REST_Controller::HTTP_OK);
	}
	function add_post(){
		$headers = $this->input->request_headers();
		if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            //TODO: Change 'token_timeout' in application\config\jwt.php
			$decodedToken = AUTHORIZATION::validateTimestamp($headers['Authorization']);
            // return response if token is valid
			if ($decodedToken != false) {

				if (isset($_POST['category_name'])) {

					$output['status']='true';
					$output['message']='Add data Successfully';
					$output['data']['category_name']=$this->input->post('category_name');
					$output['data']['category_parent']=$this->input->post('category_parent');

					$this->m_category->create_category(
						$output['data']['category_name'],
						$output['data']['category_parent']
					);
				}
				else{
					$output['status']='false';
					$output['message']='Check your data';
				}


			}
			else
			{
				$output['status']='false';
				$output['message']='Unauthorised';
			}
		}
		else {
			$output['status']='false';
			$output['message']='Unauthorised';
		}

		$this->set_response($output, REST_Controller::HTTP_OK);
	}
	function edit_post(){
		if ($this->input->get('category_id')){
			$category_id=$this->input->get('category_id');
		}
		else{
			$category_id='';
		}
		if ($category_id=='') {
			$output['status']='false';
			$output['message']='Unknown method';
			$this->set_response($output, REST_Controller::HTTP_OK);
			return;
		}
		$headers = $this->input->request_headers();
		if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            //TODO: Change 'token_timeout' in application\config\jwt.php
			$decodedToken = AUTHORIZATION::validateTimestamp($headers['Authorization']);
            // return response if token is valid
			if ($decodedToken != false) {
				if (isset($_POST['category_name'])) {
					$output['status']='true';
					$output['message']='Edit data Successfully';
					$output['data']['category_name']=
					$this->input->post('category_name');

					$this->m_category->update_category(
						$category_id,
						$output['data']['category_name']
					);
				}
				else{
					$output['status']='false';
					$output['message']='Check your data';
				}
			}
			else
			{
				$output['status']='false';
				$output['message']='Unauthorised';
			}
		}
		else {
			$output['status']='false';
			$output['message']='Unauthorised';
		}

		$this->set_response($output, REST_Controller::HTTP_OK);
	}
	function delete_get($category_id=''){
		if ($category_id=='') {
			$output['status']='false';
			$output['message']='Unknown method';
			$this->set_response($output, REST_Controller::HTTP_OK);
			return;
		}
		$headers = $this->input->request_headers();
		if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            //TODO: Change 'token_timeout' in application\config\jwt.php
			$decodedToken = AUTHORIZATION::validateTimestamp($headers['Authorization']);
            // return response if token is valid
			if ($decodedToken != false) {

				$output['status']='true';
				$output['message']='Delete data Successfully';
				$this->m_category->delete_category($category_id);

			}
			else
			{
				$output['status']='false';
				$output['message']='Unauthorised';
			}
		}
		else {
			$output['status']='false';
			$output['message']='Unauthorised';
		}

		$this->set_response($output, REST_Controller::HTTP_OK);


	}
}