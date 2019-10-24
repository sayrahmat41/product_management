<?php
class M_category extends CI_Model{

	function delete_category($category_id){
		$hsl=$this->db->query("DELETE FROM category where category_id='$this->db->escape($category_id)'");
		return $hsl;
	}

	function update_category($category_id,$category_name){
		$hsl=$this->db->query("UPDATE category set 
			category_name='$category_name' 
			where category_id='$this->db->escape($category_id)'");
		return $hsl;
	}

	function get_category(){
		$hsl=$this->db->query("select * from category where category_parent is null");
		return $hsl;
	}

	function get_category_child($parent_id){
		$hsl=$this->db->query("select * from category where category_parent = ".$this->db->escape($parent_id)."");
		return $hsl;
	}

	function create_category($category_name,$category_parent=null){
		$hsl=$this->db->query("INSERT INTO category(category_name,category_parent) VALUES (".$this->db->escape($category_name).",".$this->db->escape($category_parent).")");
		return $hsl;
	}

}