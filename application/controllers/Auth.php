<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

/*
 * Changes:
 * 1. This project contains .htaccess file for windows machine.
 *    Please update as per your requirements.
 *    Samples (Win/Linux): http://stackoverflow.com/questions/28525870/removing-index-php-from-url-in-codeigniter-on-mandriva
 *
 * 2. Change 'encryption_key' in application\config\config.php
 *    Link for encryption_key: http://jeffreybarke.net/tools/codeigniter-encryption-key-generator/
 * 
 * 3. Change 'jwt_key' in application\config\jwt.php
 *
 */

class Auth extends REST_Controller
{
   function __construct()
   {
    parent:: __construct();
    $this->load->model('m_login');
}

public function token_post()
{

    $user_name=strip_tags(stripslashes($this->input->post('user_name',TRUE)));
    $user_password=strip_tags(stripslashes($this->input->post('user_password',TRUE)));
    $u=$user_name;
    $p=$user_password;
    if (isset($_POST['user_name']) and isset($_POST['user_password'])) {
     $cekuser=$this->m_login->cekuser($u,$p);
     if($cekuser->num_rows() > 0 ){
         $data_user=$cekuser->row_array();
             //$output=$data_user;
         $tokenData = array();
         $tokenData['user_name'] = $data_user['user_name']; 
         $tokenData['user_fullname'] = $data_user['user_fullname']; 
         $tokenData['timestamp'] = now();
         $output['data']['token'] = AUTHORIZATION::generateToken($tokenData);
         $output['status']='true';
         $output['message']='Login Successfully';
     }
     else{
        $output['status']='false';
        $output['message']='Invalid user_name or user_password';
    }
}
else{
    $output['status']='false';
    $output['message']='Unknown method';
}

$this->set_response($output, REST_Controller::HTTP_OK);

}


}