<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function pembayaran_sukses($order_id='SHT1000003300')
  {
  	$this->db->where('tiket_order_id', $order_id);
  	$cek = $this->db->get('master_tiket');
  	if ($cek->num_rows() > 0){
  		$pembelian = $cek->row();

  		if ($pembelian->tiket_status == 'pending'){
  			$obj['tiket_status'] = 'success';
  			$this->db->where('tiket_id', $pembelian->tiket_id);
  			$this->db->update('master_tiket', $obj);

  			if (substr($order_id, 0,3) == 'SHT'){ 
  				// $this->give_shuttle($pembelian->tiket_id);
  				echo '$pembelian->tiket_id'. $pembelian->tiket_id;
  			}else{
  				// $this->give_bib($pembelian->tiket_id);
  				echo 'blog';
  			}
  		}
  	} 
  }

	public function give_shuttle($id_tiket='SHT2000003486')
  {
  	$this->db->join('master_user', 'user_id = tiket_user', 'left');
  	$this->db->where('tiket_order_id', $id_tiket);
  	$tiket = $this->db->get('master_tiket')->row();
  	$new = $this->makeQR2($tiket->tiket_order_id);

  	$object['shuttle_user'] = $tiket->tiket_user;
  	$data_tiket = json_decode($tiket->tiket_data);
  	$object['shuttle_pos'] = $data_tiket[0]->kategori;
  	$object['shuttle_status'] = 'success';
  	$object['shuttle_qr'] = $new;
  	$object['shuttle_orderid'] = $id_tiket;
  	$this->db->insert('master_shuttle', $object);
  }

  public function makeQR2($bibs='')
	{
		$password=BASE_PASSWORD;
		$bib=openssl_encrypt($bibs,"AES-128-ECB",$password);
		$this->load->library('ciqrcode');
		$params['data'] = $bib;
		$params['level'] = 'H';
		$params['size'] = 1024;
		$ok = strip_tags($bib);
		$new = str_replace('/', '-', $ok);
		$params['savename'] = FCPATH.'/assets/qr/shuttle/'.$new.'.jpeg';
		$this->ciqrcode->generate($params);

		return $new;
	}

	public function makeQRAsli($bibs='')
	{
		// for ($i=2849; $i <= 2869; $i++) { 
			
			$password=BASE_PASSWORD;
			$bib=openssl_encrypt($bibs,"AES-128-ECB",$password);
			$this->load->library('ciqrcode');
			$params['data'] = $bib;
			$params['level'] = 'H';
			$params['size'] = 1024;
			$ok = strip_tags($bib);
			$new = str_replace('/', '-', $ok);
			$params['savename'] = FCPATH.'/assets/qr/'.$new.'.jpeg';
			$this->ciqrcode->generate($params);
		// }
		// return $new;
	}

	function get_pelari_by_kota(){
		$this->db->join('master_user', 'user_id = pelari_user', 'left');
    $this->db->join('master_city', 'pelari_kota = city_id', 'left');
    $this->db->join('master_provinsi', 'pelari_provinsi = provinsi_id', 'left');
    $this->db->join('master_group', 'group_id = pelari_group', 'left');
    $this->db->join('master_kategori', 'kategori_id = pelari_kategori', 'left');
    $this->db->order_by('pelari_provinsi');
    $this->db->group_by('provinsi_id');
    $this->db->group_by('pelari_sex');
    $this->db->select('provinsi_nama, pelari_sex, count(pelari_id) as jml');
    $a = $this->db->get('master_pelari');
    foreach ($a->result() as $data) {
    	echo "<pre>";
    	print_r ($data);
    	echo "</pre>";
    }
	}

	public function ambil_qr($bibs='')
	{
		$password=BASE_PASSWORD;
		$bib=openssl_encrypt($bibs,"AES-128-ECB",$password);
		$this->load->library('ciqrcode');
		$params['data'] = $bib;
		$params['level'] = 'H';
		$params['size'] = 1024;
		$ok = strip_tags($bib);
		$new = str_replace('/', '-', $ok);
		$params['savename'] = FCPATH.'/assets/qr/'.$new.'.jpeg';
		$this->ciqrcode->generate($params);
		echo "<pre>";
		print_r ($new);
		echo "</pre>";
	}

	public function email($value='')
	{
		$data['nama_pelari'] = "edwin efendi";
		$data['kategori'] = '21K UMUM';
		$data['no_bib'] = '2005';
		$data['qrcode'] = '-+-dEMIqK4xD11yjYu+kMg==';
		$data['email'] = 'andreasflic18@gmail.com';
		$this->load->view('library/mail_content', $data, false);
	}

	public function makeQR($bibs='FREEEGGROLL')
	{
		$password=BASE_PASSWORD;
		$bib=openssl_encrypt($bibs,"AES-128-ECB",$password);
		$this->load->library('ciqrcode');
		$params['data'] = $bib;
		$params['level'] = 'H';
		$params['size'] = 1024;
		$ok = strip_tags($bib);
		$new = str_replace('/', '-', $ok);
		$params['savename'] = FCPATH.'/assets/qr/'.$new.'.jpeg';
		$this->ciqrcode->generate($params);
	}

	public function ok($value='')
	{
		$ambil = $this->session->userdata('ambil');
		echo "<pre>";
		print_r ($ambil);
		echo "</pre>";
		if (($key = array_search('682', $ambil)) !== false) {
			echo 'ada '.$key;
		}else{
			echo 'TIdak ada ';
		}
	}

	public function cetak_qris($bibs='FREEEGGROLLS')
	{
		$password=BASE_PASSWORD;
		$bib = openssl_encrypt($bibs,"AES-128-ECB",$password);
		$this->load->library('ciqrcode');
		$params['data'] = $bib;
		$params['level'] = 'H';
		$params['size'] = 1024;
		$ok = strip_tags($bib);
		$params['savename'] = FCPATH.'assets/qr/'.$ok.'.png';
		$this->ciqrcode->generate($params);

		echo '<img src="'.base_url('assets/qr/'.$ok.'.png').'">';
	}

	public function dua($value='')
	{
		$string_to_encrypt="5168";
		$password="password";
		$encrypted_string=openssl_encrypt($string_to_encrypt,"AES-128-ECB",$password);
		$decrypted_string=openssl_decrypt($encrypted_string,"AES-128-ECB",$password);
	}

	function safeEncrypt(string $message, string $key): string
	{
	    if (mb_strlen($key, '8bit') !== SODIUM_CRYPTO_SECRETBOX_KEYBYTES) {
	        throw new RangeException('Key is not the correct size (must be 32 bytes).');
	    }
	    $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
	    
	    $cipher = base64_encode(
	        $nonce.
	        sodium_crypto_secretbox(
	            $message,
	            $nonce,
	            $key
	        )
	    );
	    sodium_memzero($message);
	    sodium_memzero($key);
	    return $cipher;
	}
	function safeDecrypt(string $encrypted, string $key): string
	{   
	    $decoded = base64_decode($encrypted);
	    $nonce = mb_substr($decoded, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, '8bit');
	    $ciphertext = mb_substr($decoded, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, null, '8bit');
	    
	    $plain = sodium_crypto_secretbox_open(
	        $ciphertext,
	        $nonce,
	        $key
	    );
	    if (!is_string($plain)) {
	        throw new Exception('Invalid MAC');
	    }
	    sodium_memzero($ciphertext);
	    sodium_memzero($key);
	    return $plain;
	}

	public function indexxxxxx1237($value='https://www.doordash.com/store/chosen-wok-great-bend-34835577/74067348/')
	{
		// echo ASSETS.'images/logos/favicon.png';
		$this->load->library('ciqrcode');
		$value = md5($value);
		header("Content-Type: image/png");
		$params['data'] = $value;
		$params['level'] = 'H';
		$params['size'] = 1024;
		// $params['black']		= array(255,0,0); // RED
		// $params['white']		= array(255,255,255); // WHITE
		$ok = strip_tags($value);
		$params['savename'] = 'assets/qr/'.$ok.'.png';
		$this->ciqrcode->generate($params);

		// echo '<img src='.base_url('assets/qr/'.$ok).'.png>';
	}

	public function get_total_kaos($value='')
	{
		$this->db->where('pelari_bib >=', '1');
		$pelari = $this->db->get('master_pelari');
		$xs=0;
		$s=0;
		$m=0;
		$l=0;
		$xl=0;
		$xxl=0;
		$other=0;
		$kaos=[];
		foreach ($pelari->result() as $data) {
			$kaos[$data->pelari_kaos][] = $data->pelari_kaos;
		}

		echo 'XS = '.count($kaos['XS']).'<br>';
		echo 'S = '.count($kaos['S']).'<br>';
		echo 'M = '.count($kaos['M']).'<br>';
		echo 'L = '.count($kaos['L']).'<br>';
		echo 'XL = '.count($kaos['XL']).'<br>';
		echo '2XL = '.count($kaos['2XL']).'<br>';

	}
	
}
