<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mainmodel extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		$date = date('Y-m-d');
		if ($date != option('running_modul')){
			// $this->check_user();
			option_update('running_modul', $date);
		}
		$array = array(
			'ambil' => array()
		);
		
		// $this->session->set_userdata( $array );
	}

	public function check_user($value='') //sudah gak dipakai
	{
		$this->db->where('pelari_bib', null);
		$this->db->where('pelari_group', null);
		$this->db->where('date(pelari_created) <=', date('Y-m-d H:i:s', strtotime('-10 hours')));
		$this->db->join('master_user', 'user_id = pelari_user', 'left');
		$this->db->join('master_kategori', 'kategori_id = pelari_kategori', 'left');
		$getuser = $this->db->get('master_pelari');

		foreach($getuser->result() as $user){
			//$this->db->where('user_id', $user->user_id);
			//$this->db->delete('master_user');
			$this->db->where('pelari_id', $user->pelari_id);
			$this->db->delete('master_pelari');
			$katt['kategori_kuota'] = $user->kategori_kuota+1;
			$this->db->where('kategori_id', $user->kategori_id);
			$this->db->update('master_kategori', $katt);
		}
	}

	public function send_email($to='', $mail = '', $subject='Forget Password Code')
	{
    $config = [
        'mailtype'  => 'html',
        'charset'   => 'utf-8',
        'protocol'  => 'smtp',
        'smtp_host' => 'ssl://smtp.gmail.com',
        'smtp_user' => 'kedirihalfmarathon@gmail.com',  // Email gmail
        'smtp_pass'   => 'vzzjubpjyrjmvkuv',  // Password App gmail rpho tuha oqdd zkrv
        'smtp_port'   => 465,
        'crlf'    => "\r\n",
        'newline' => "\r\n"
    ];

		$this->load->library('email', $config);
		$this->email->from(CNF_EMAIL1, APP_NAME);
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($mail);
		$this->email->send();
	}

	public function getcity($provinsi='')
	{
		$this->db->where('city_provinceid', get('id'));
		$get_kota = $this->db->get('master_city');
		$kotas = [];
		$no = 0;
		foreach ($get_kota->result() as $kota) {
			$kotas[$no]['value'] = $kota->city_id;
			$kotas[$no]['text'] = $kota->city_type.' '.$kota->city_name;
			$no++;
		}
		return $kotas;
	}

	public function cek_kategori($no='')
	{
		if ($no == '1'){
			return 'umum';
		}else if ($no == '2'){
			return 'pelajar';
		}else if ($no == '3'){
			return 'difabel';
		}
	}

	public function getkategori($provinsi='')
	{
		$this->db->order_by('kategori_created', 'asc');
		$this->db->where('kategori_status', '1');
		$this->db->where('kategori_kuota > ', '0');
		if ((get('kategori') != '') && (get('kategori') != '4')){
			$kat = $this->cek_kategori(get('kategori'));
			$this->db->where('kategori_kategori', $kat);
			if (get('type') != '0'){
				if (get('type') == 'smp'){
					$this->db->where('kategori_id', '9');
				}else if (get('type') == 'sma'){
          $this->db->where('kategori_id', '2');
        }
			}
		}
		$dob = new DateTime(get('id'));
    	$today   = new DateTime('today');
    	$umurnya = $dob->diff($today)->y;

		$this->db->where('kategori_umurmin <=', $umurnya);
		$this->db->where('kategori_umurmax >=', $umurnya);
		$this->db->where('DATE(kategori_dateexp) >=', date('Y-m-d'));
		$get = $this->db->get('master_kategori');
		
		$kotas = [];
		$no = 0;
		foreach ($get->result() as $kota) {
			$kuota = ($kota->kategori_kuota == 0)? ' - Kuota Habis' : '';
			$kotas[$no]['value'] = $kota->kategori_id.'|'.$kota->kategori_kaosfinish.'|'.$kota->kategori_kategori;
			$kotas[$no]['text'] = $kota->kategori_name.' '.$kuota;
			$kotas[$no]['disabled'] = ($kota->kategori_kuota > 0)? false : true;
			$no++;
		}
		return $kotas;
	}
}

/* End of file  */
/* Location: ./application/models/ */