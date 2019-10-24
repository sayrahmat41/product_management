<?php
class M_login extends CI_Model{
	
	function cekuser($u,$p){
		$hasil = $this->db->get_where('users', 
			array(
				'user_name' => $u,
				'user_password' => md5($p)
			));

		return $hasil;
	}


}
