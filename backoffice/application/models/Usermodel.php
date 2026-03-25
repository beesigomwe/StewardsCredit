<?php

class Usermodel extends CI_Model{

	public function login($email,$password) {
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('email',$email);
		$this->db->or_where('username',$email);
		//$this->db->where('password',$password);
		$query=$this->db->get();
		$row_count=$query->num_rows();
		if($row_count>0){
			$userdata=$query->row();	
			$newdata = array(
				'id'  => $userdata->id,	
				'username'  => $userdata->username,
				'fullname'  => $userdata->fullname,
				'role' => $userdata->role,
				'email'     => $userdata->email,
				'logged_in' => TRUE
			);
			$this->session->set_userdata($newdata);	
			$this->setLoginTime($userdata->id);
			return true;	
		}
		return false;
	}	

	public function logout(){
		$newdata = array(
			'id'   => '',
			'username'  => '',
			'fullname'  => '',
			'email'     => '',
			'logged_in' => FALSE
		);
		$this->session->set_userdata($newdata);	

	}

	public function setLoginTime($id){
		$data['last_login']=date("Y-m-d H:i:s");
		$this->db->where('id',$id);
		$this->db->update('users',$data);
	}

}