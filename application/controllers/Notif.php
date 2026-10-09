<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notif extends CI_Controller {

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
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */


	public function __construct()
    {
      parent::__construct();
      $params = array('server_key' => MIDTRANS_SERVER_KEY, 'production' => MIDTRANS_PRODUCTIONS);
			$this->load->library('veritrans');
			$this->veritrans->config($params);
			$this->load->helper('url');
    }

	public function index()
	{
		echo 'test notification handlers';
		$json_result = file_get_contents('php://input');
		$result = json_decode($json_result);

		$notif = '';
		if($result){
			$notif = $this->veritrans->status($result->order_id);
		}

		error_log(print_r($result,TRUE));
		
		$transaction = $notif->transaction_status;
		$type = $notif->payment_type;
		$order_id = $notif->order_id;
		$fraud = $notif->fraud_status;

		if ($transaction == 'capture') {
		  // For credit card transaction, we need to check whether transaction is challenge by FDS or not
		  if ($type == 'credit_card'){
		    if($fraud == 'challenge'){
		      // TODO set payment status in merchant's database to 'Challenge by FDS'
		      // TODO merchant should decide whether this transaction is authorized or not in MAP
		      echo "Transaction order_id: " . $order_id ." is challenged by FDS";
		      } 
		      else {
		      // TODO set payment status in merchant's database to 'Success'
		      echo "Transaction order_id: " . $order_id ." successfully captured using " . $type;
		      }
		    }
		  }
		else if ($transaction == 'settlement'){
		  // TODO set payment status in merchant's database to 'Settlement'
		  echo "Transaction order_id: " . $order_id ." successfully transfered using " . $type;
		  $objc['transaksi_order_id'] = $order_id;
			$objc['transaksi_type'] = $type;
			$objc['transaksi_date'] = date('Y-m-d H:i:s');
			$objc['transaksi_status'] = 'success';
			$this->db->insert('master_transaksi', $objc);

			$this->db->where('tiket_order_id', $order_id);
		  	$cek = $this->db->get('master_tiket');
		  	if ($cek->num_rows() > 0){
		  		$pembelian = $cek->row();

		  		if ($pembelian->tiket_status == 'pending'){
		  			$obj['tiket_status'] = 'success';
		  			$this->db->where('tiket_id', $pembelian->tiket_id);
		  			$this->db->update('master_tiket', $obj);
		  			if (substr($order_id, 0,3) == 'SHT'){ 
  						$this->give_shuttle($pembelian->tiket_id);
  					}else{
		  				$this->give_bib($pembelian->tiket_id);
  					}
		  		}
		  	}
		  } 
		  else if($transaction == 'pending'){
		  // TODO set payment status in merchant's database to 'Pending'
		  echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
		  } 
		  else if ($transaction == 'deny') {
		  // TODO set payment status in merchant's database to 'Denied'
		  echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
		}
	}

	public function give_bib($notiket='19')
	{
		$this->db->where('tiket_id', $notiket);
		$tikets = $this->db->get('master_tiket')->row();
		if (empty($tikets)) return;
		foreach (json_decode($tikets->tiket_data) as $tiket) {
			// Alokasi BIB atomik + idempotent. Kuota sudah dipotong saat register,
			// jadi di sini HANYA majukan kategori_startid (sekali per pelari).
			$this->db->trans_start();
			$row = $this->db->query('SELECT pelari_bib FROM master_pelari WHERE pelari_id = ? FOR UPDATE', [$tiket->id_pelari])->row();
			if (!empty($row) && !empty($row->pelari_bib)){
				$this->db->trans_complete();
				continue;
			}
			$kat = $this->db->query('SELECT kategori_prefix, kategori_startid FROM master_kategori WHERE kategori_id = ? FOR UPDATE', [$tiket->kategori])->row();
			if (empty($kat)) { $this->db->trans_complete(); continue; }
			$no_bib = $kat->kategori_prefix.''.$kat->kategori_startid;
			$this->db->where('pelari_id', $tiket->id_pelari);
			$this->db->update('master_pelari', ['pelari_bib' => $no_bib]);
			$this->db->query('UPDATE master_kategori SET kategori_startid = kategori_startid + 1 WHERE kategori_id = ?', [$tiket->kategori]);
			$this->db->trans_complete();

			$this->db->join('master_user', 'user_id = pelari_user', 'left');
			$this->db->join('master_kategori', 'kategori_id = pelari_kategori', 'left');
			$this->db->join('master_group', 'group_id = pelari_group', 'left');
			$this->db->where('pelari_id', $tiket->id_pelari);
			$si_pelari = $this->db->get('master_pelari')->row();
			$qr = $this->makeQR($no_bib);

			$data['nama_pelari'] = $si_pelari->pelari_name;
			$data['kategori'] = $si_pelari->kategori_name;
			$data['no_bib'] = $no_bib;
			$data['qrcode'] = $qr;
			$data['email'] = $si_pelari->user_email;
			$email = $this->load->view('library/mail_content', $data, TRUE);
			makeNotif('Selamat Pembayaran Berhasil', $email, $tiket->id_user);
			
			$this->mainmodel->send_email($si_pelari->user_email, $email, 'Pembayaran Berhasil');
		}
	}

	public function makeQR($bibs='')
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
		return $new;
	}

  public function give_shuttle($id_tiket='')
  {
  	$this->db->where('tiket_id', $id_tiket);
  	$tiket = $this->db->get('master_tiket')->row();
  	$new = $this->makeQR2($tiket->tiket_order_id);

  	$object['shuttle_user'] = $tiket->tiket_user;
  	$data_tiket = json_decode($tiket->tiket_data);
  	$object['shuttle_pos'] = $data_tiket[0]->kategori;
  	$object['shuttle_status'] = 'success';
  	$object['shuttle_qr'] = $new;
  	$object['shuttle_orderid'] = $tiket->tiket_order_id;
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
}