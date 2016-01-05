<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {
	public function __construct()
    {
        parent::__construct();   
             
    }
	
	public function cek_login()
	{		
		$username = $this->input->post("username",true);	
		$password = $this->input->post("password",true);
		if ($username=="abc" && $password=="123")
		{
			$data=array('user'=>'astri');
			$this->session->set_userdata($data); //harus membuat session untuk set data agar bisa di logout
			redirect(site_url('backend/home'),'location');
		}
		else {
			redirect(site_url('backend/login'),'location');
		}
		
	}
	function logout(){
		$data=array('user'=>'');
		$this->session->unset_userdata($data);//perhatikan perbedaan pembuatan session dengan pada login unset artinya untuk menonaktifkan lagi.
		$data['pesan']='Anda berhasil logout';
		$this->load->view('login',$data);
	}
	
}