<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Apimodel extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
	}

	public function login($value='')
	{
		header("HTTP/1.1 404");
		$json = file_get_contents('php://input');
		$post = json_decode($json);
		$this->db->where('user_email', $post->username);
		$this->db->where('user_password', md5($post->password) );
		$get_member = $this->db->get('master_user');
		if ($get_member->num_rows() == 0){
			$return['status'] = false;
			$return['message'] = 'Username Atau Password Salah';
		}else{
			$data = $get_member->row();
			if ($data->user_status == '0'){
				$return['status'] = false;
				$return['message'] = 'User Anda terblokir';	
			}
		}

		if ($return['status']){
			$data = $get_member->row();
			$this->check_user($data->user_id);
			
			$session = array(
				'logged_in' 	=> TRUE,
				'user_id'			=> $data->user_id,
				'user_email'	=> $data->user_email,
				'user_join'		=> date('d F Y', strtotime($data->user_created)),
				'logged_date'	=> date('Y-m-d H:i:s'),
			);

			$object['user_last_login'] = date('Y-m-d H:i:s');
			$this->db->where('user_id', $data->user_id);
			$this->db->update('master_user', $object);

			header("HTTP/1.1 200");
			$return['code'] = '200';
			$return['type'] = 'success';
			$return['message'] = 'Selamat Datang';
		}
	
		return $return;
	}

	public function check_user($value='')
	{
		$this->db->where('pelari_user', $value);
		$this->db->where('pelari_bib', null);
		$this->db->where('pelari_group', null);
		$this->db->where('date(pelari_created) <=', date('Y-m-d H:i:s', strtotime('-7 days')));
		$this->db->join('master_kategori', 'kategori_id = pelari_kategori', 'left');
		$getuser = $this->db->get('master_pelari');

		if ($getuser->num_rows() > 0){
			$user = $getuser->row();
			$this->db->where('pelari_id', $user->pelari_id);
			$this->db->delete('master_pelari');
			$katt['kategori_kuota'] = $user->kategori_kuota+1;
			$this->db->where('kategori_id', $user->kategori_id);
			$this->db->update('master_kategori', $katt);
		}
	}
}

/* End of file  */
/* Location: ./application/models/ */