<?php
class M_product extends CI_Model{

	function delete_product($product_id){
		$hsl=$this->db->query("DELETE FROM product where product_id='$product_id'");
		return $hsl;
	}

	function update_product(
		$product_id,
		$product_name,
		$product_description,
		$product_currency,
		$product_price,
		$product_category){
		$hsl=$this->db->query("UPDATE product set 
			product_name='$product_name',
			product_description='$product_description',
			product_currency='$product_currency',
			product_price='$product_price',
			product_category='$product_category'
			where product_id='$product_id'");
		return $hsl;
	}

	function get_product($category_id=''){
		$this->load->model('m_category');
		if ($category_id!=''){
			$filter=" AND product.product_category=".$category_id;
		}
		else{
			$filter="";
			
		}
		$hsl=$this->db->query("select 
			category.category_id,
			category.category_name,
			product.product_id,
			product.product_name,
			product.product_description,
			product.product_currency,
			product.product_price,
			product.product_category,
			product.product_thumbnail
			FROM
			category
			INNER JOIN product ON product.product_category = category.category_id".$filter);
		$final = $hsl->result_array(); 
		$i=0;
		foreach ($final as $hsl) {
			$children=$this->m_category->get_category_child($hsl['product_category']);
			$final[$i]['product_category']=array(
				'category_id'=>$hsl['category_id'],
				'category_name'=>$hsl['category_name']
			);
			if(!empty($children->result())){
				$final[$i]['product_category']['has_child']=true;
				$final[$i]['product_category']['children']=$children->result_array();
			} else {
				$final[$i]['product_category']['has_child']=false;
			}
			$i++;
		}
		return $final;
	}

	function create_product(
		$product_name,
		$product_description,
		$product_currency,
		$product_price,
		$product_category){
		$hsl=$this->db->query("INSERT INTO product(
			product_name,
			product_description,
			product_currency,
			product_price,
			product_category) 
			VALUES (
			'$product_name',
			'$product_description',
			'$product_currency',
			'$product_price',
			'$product_category')");
		return $hsl;
	}

}