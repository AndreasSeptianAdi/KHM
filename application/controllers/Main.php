<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function coba_mail($value='')
	{
		$data['nama_pelari'] = 'Andreas';
		$data['kategori'] = 'Master';
		$data['no_bib'] = '5274';
		$data['email'] = 'andreasflic18@gmail.com';
		$this->load->view('library/mail_content', $data, false);
	}

	function index( $filename = 'index', $idData = '' )
	{
		if ( $this->session->userdata('logged_in') == TRUE ) {
			if ( file_exists('application/views/page/inc_'.$filename.'.php') ) {	
				$alowed_page = ['','index','daftar_lari','daftar','checkout','shuttle'];
				if ((userid() != 1) && (!in_array($filename, $alowed_page))){
					$this->empatkosongempat();
				}
				$this->data['idData']	= $idData;			
				$this->data['content'] = $this->load->view('page/inc_'.$filename.'', $this->data, true);
				$this->load->view('app_index', $this->data);
			}else{
				$this->empatkosongempat();
			}
		}else{
			$this->auth('login');
		}
	}

	function auth( $filename = 'login', $idData = '' )
	{
		if ( $this->session->userdata('logged_in') == FALSE ) {
			if ( file_exists('application/views/auth/inc_'.$filename.'.php') ) {	
				$this->data['idData']	= $idData;			
				$this->data['content'] = $this->load->view('auth/inc_'.$filename.'', $this->data, true);
				$this->load->view('app_login', $this->data);
			} else {
				$this->empatkosongempat();
			}
		}else{
			$this->data['idData']	= $idData;			
			$this->data['content'] = $this->load->view('page/inc_index', $this->data, true);
			$this->load->view('app_index', $this->data);
		}
	}

	function edit( $filename = 'index', $metode = 'edit' )
	{
		
		if (( $this->session->userdata('logged_in') == TRUE ) && ( $this->session->userdata('member_type') == 'admin' )) {
			$this->data['content'] = $this->load->view('admin/edit/'.$filename.'_'.$metode, [], true);
			$this->load->view('admin/adm_index', $this->data);

		}else{
			$this->empatkosongempat();
		}
		
	}

	public function postdata( $model = null, $function = null )
	{

		$this->load->model( $model );
		$data 	= $this->$model->$function();
		$this->output->set_content_type('application/json');
		echo json_encode( $data );

	}

	public function postdataadmin( $model = null, $function = null )
	{

		if ($this->session->userdata('logged_in') == true){
			if ($this->session->userdata('user_id') != '1'){
				$this->empatkosongempat();
			}
		}
	
		$this->load->model( $model );
		$data 	= $this->$model->$function();
		$this->output->set_content_type('application/json');
		echo json_encode( $data );
	

	}

	public function basicdata( $model = null, $function = null )
	{

		$this->load->model( $model );
		$data 	= $this->$model->$function();
		echo $data;

	}

	public function logout(){
	
		// lepas slot antrean agar giliran berikutnya masuk
		try {
			$this->load->model('quetablemodel', 'queue');
			$token = $this->input->cookie('queue_token', true);
			if ($token) {
				$this->queue->release($token);
			}
			// pengaman: hapus juga by user_id (kalau cookie hilang/rusak)
			$uid = $this->session->userdata('user_id');
			if ($uid) {
				$this->queue->release_by_user($uid);
			}
		} catch (Exception $e) {}
		$this->session->sess_destroy();
		redirect('',301);
	}


	public function empatkosongempat()
	{

		$this->load->view('errors/html/custom_404');

	}

	public function edit_user($userid)
	{		

		$get = $this->db->get_where('tb_anggota', ['id' => $userid] );
		$this->data['user'] = $get->row();
		$return['data'] = $this->data;
		$this->data['content'] 	= $this->load->view('library/user_edit', $this->data, true);
		$this->load->view('app_index', $this->data);

	}

	public function modal( $filename = 'null', $data = '' )
	{

		if ( file_exists('application/views/modal/'.$filename.'.php') ) {
			
			echo $this->load->view( 'modal/'.$filename , ($data == '')? array() : $data , TRUE);

		}

	}

	public function adminmodal( $filename = 'null', $data = '' )
	{
		if ($this->session->userdata('logged_in') == true){
			if ($this->session->userdata('user_id') != '1'){
				$this->empatkosongempat();
			}
		}

		if ( file_exists('application/views/modal/'.$filename.'.php') ) {
			
			echo $this->load->view( '/modal/'.$filename , ($data == '')? array() : $data , TRUE);

		}

	}

}

/* End of file  */
/* Location: ./application/controllers/ */