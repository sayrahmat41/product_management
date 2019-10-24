<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
class Product extends REST_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('m_product');
	}
	public function list_get(){

		$headers = $this->input->request_headers();
		if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            //TODO: Change 'token_timeout' in application\config\jwt.php
			$decodedToken = AUTHORIZATION::validateTimestamp($headers['Authorization']);
            // return response if token is valid
			if ($decodedToken != false) {
				$output['status']='true';
				$output['message']='Load data Successfully';

				if ($this->input->get('category_id')){
					$data=$data=$this->m_product->get_product($this->input->get('category_id'));
				}
				else{
					$data=$this->m_product->get_product();
				}
				//$output['data']=$data->result_array(); 
				$output['data']=$data;
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

				if (
					isset($_POST['product_name'])
					&&isset($_POST['product_description'])
					&&isset($_POST['product_currency'])
					&&isset($_POST['product_price'])
					&&isset($_POST['product_category'])

				) {

					$output['status']='true';
					$output['message']='Add data Successfully';

					$output['data']['product_name']
					=$this->input->post('product_name');
					$output['data']['product_description']
					=$this->input->post('product_description');
					$output['data']['product_currency']
					=$this->input->post('product_currency');
					$output['data']['product_price']
					=$this->input->post('product_price');
					$output['data']['product_category']
					=$this->input->post('product_category');

					$this->m_product->create_product(
						$output['data']['product_name'],
						$output['data']['product_description'],
						$output['data']['product_currency'],
						$output['data']['product_price'],
						$output['data']['product_category']
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
		if ($this->input->get('product_id')){
			$product_id=$this->input->get('product_id');
		}
		else{
			$product_id='';
		}
		if ($product_id=='') {
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
				if (
					isset($_POST['product_name'])
					&&isset($_POST['product_description'])
					&&isset($_POST['product_currency'])
					&&isset($_POST['product_price'])
					&&isset($_POST['product_category'])

				) {
					$output['status']='true';
					$output['message']='Edit data Successfully';
					$output['data']['product_name']
					=$this->input->post('product_name');
					$output['data']['product_description']
					=$this->input->post('product_description');
					$output['data']['product_currency']
					=$this->input->post('product_currency');
					$output['data']['product_price']
					=$this->input->post('product_price');
					$output['data']['product_category']
					=$this->input->post('product_category');

					$this->m_product->update_product(
						$product_id,
						$output['data']['product_name'],
						$output['data']['product_description'],
						$output['data']['product_currency'],
						$output['data']['product_price'],
						$output['data']['product_category']
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
	function delete_get($product_id=''){
		if ($product_id=='') {
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
				$this->m_product->delete_product($product_id);

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