<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends CI_Controller {

	public function __construct()
    {
        parent::__construct();   
        $this->load->model('Categories_model','datamodel');     
		$this->load->helper(array('form', 'url'));
		$this->load->library('image_lib');
		$this->load->library('upload');	
    }
	   
	public function index()
	{
		$data['title']='List Of Categories';	
		$data['array_categories'] = $this->datamodel->get_categories();
		$this->mytemplate->loadBackend('categories',$data);
	}

	public function form($mode,$id='')
	{
		$data['title']=($mode=='insert')? 'Add Categories' : 'Update Categories' ;				
		$data['categories'] = ($mode=='update') ? $this->datamodel->get_categories_by_id($id) : '';				
		$this->mytemplate->loadBackend('frmcategories',$data);	
	}

	public function process($mode,$id='')
	{
		
		if(($mode=='insert') || ($mode=='update'))
		{
			//memanggil fungsi do_upload saat proses input
			$this->do_upload();
			$result = ($mode=='insert') ? $this->datamodel->insert_entry($this->upload->file_name) : 
				$this->datamodel->update_entry($this->upload->file_name) ;
			//$this->datamodel->update_entry())
		}
		
		else if($mode=='delete'){
			$result = $this->datamodel->hapus($id);			
		}
		if ($result) redirect(site_url('backend/categories'),'location');
	}
	
	public function do_upload()
    {
            //isi fungsi do_upload
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']    = 1000;
		$config['max_width']  = 1024;
		$config['max_height']  = 768;
		$config['encrypt_name']  = TRUE;
		//$config['create_thumb'] = TRUE;
	
		
		$this->upload->initialize($config);
		$this->load->library('upload', $config);
		//$nama = $this->upload->file_name;
		
		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			echo "tidak berhasil";
			
		}
		else
		{
			echo "berhasil";
			$this->resize_image();
			$this->wmark();
			//$this->thumbnail();
			//$this->thumbnail($this->upload->file_name);
			//$this->wmark($this->upload->file_name);
			//$this->thumb_image($this->upload->file_name);
		
		//redirect(site_url('backend/categories'),'location');
			
		}
    }
	
	private function resize_image() 
	{ 
		$config['image_library'] = 'gd2'; 
		$config['source_image'] = './uploads/'.$this->upload->file_name; 
		$config['maintain_ratio'] = TRUE; 
		$config['width'] = 500; 
		$config['height'] = 300; 
		
		$this->image_lib->initialize($config); 
		$this->load->library('image_lib', 
		$config); $this->image_lib->resize(); 
		
		if ( ! $this->image_lib->resize()) 
		{ 
			echo $this->image_lib->display_errors();
		} 
		$this->image_lib->clear(); 
	}
	
	private function wmark($npath)
	{

			$config['image_library'] = 'gd2';
			$config['source_image'] = './uploads/'.$this->upload->file_name;
			$config['wm_text'] = '12121189_Astri';
			$config['wm_type'] = 'text';
			$config['wm_font_path'] = './system/fonts/texb.ttf';
			$config['wm_font_size'] = 25;
			$config['wm_font_color'] = '0000FF';
			$config['wm_vrt_alignment'] = 'middle';
			$config['wm_hor_alignment'] = 'center';
			$config['wm_padding'] = 20;
			$config['overwrite'] = TRUE;
			
			
			$this->image_lib->initialize($config);	
			$this->load->library('image_lib',$config);
			//$this->image_lib->watermark();
			if ( ! $this->image_lib->watermark())
			{
				echo $this->image_lib->display_errors();
			}
			$this->image_lib->clear();
	}

	/*private function thumbnail() 
	{ 
		$config['image_library'] = 'gd2'; 
		$config['source_image'] = './uploads/'.$this->upload->file_name; 
		$config['new_image'] = './uploads/thumbs'; 
		//mengcopy image ke folder thumbs 
		$config['create_thumb'] = TRUE; 
		$config['maintain_ratio'] = TRUE; 
		$config['thumb_marker'] = TRUE; 
		$config['width'] = 60; 
		$config['height'] = 20; 
		$this->image_lib->initialize($config); 
		$this->load->library('image_lib', $config); 
		if ( ! $this->image_lib->resize()) 
		{ 
			echo $this->image_lib->display_errors(); 
		} 
			$this->image_lib->clear(); 
		 
	}*/
	
	private function dependensi($id)
	{
		return $this->datamodel->cek_dependensi($id);
	}
	
	

	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

