<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends CI_Controller {

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
		$this->load->library('midtrans');
		$this->midtrans->config($params);
		$this->load->helper('url');	
  }

  public function hapus_tiket($value='')
  {
  	$this->db->where('shuttle_user', post('userid'));
  	$this->db->delete('master_shuttle');
  }

  public function index()
  {
  	$this->load->view('checkout_snap');
  }

  public function handling($orderid='')
  {
  	$this->db->where('tiket_order_id', $orderid);
  	$cek = $this->db->get('master_tiket');
  	if ($cek->num_rows() > 0){
  		$pembelian = $cek->row();

  		if ($pembelian->tiket_status == 'pending'){
  			$obj['tiket_status'] = 'success';
  			$this->db->where('tiket_id', $pembelian->tiket_id);
  			$this->db->update('master_tiket', $obj);
  			// berikan Nomer BIB ke Pelari
  			$this->done('success');
  		}
  	}
  }

  public function done($value='')
  {
  	$this->output->set_content_type('application/json');
  	$status = get('status');
  	$return['status'] = true;
  	$return['type'] = 'warning';
  	$return['message'] = 'Pembayaran Gagal';

  	$content = post('result_data');
  	if ((($content['transaction_status'] == 'settlement') || ($content['transaction_status'] == 'capture')) && ($content['fraud_status'] == 'accept')){

  		$objc['transaksi_order_id'] = $content['order_id'];
			$objc['transaksi_type'] = $content['payment_type'];
			$objc['transaksi_date'] = date('Y-m-d H:i:s');
			$objc['transaksi_status'] = 'success';
			$this->db->insert('master_transaksi', $objc);

			$return['type'] = 'success';
  		$return['message'] = 'Pembayaran Berhasil';

			$this->pembayaran_sukses($content['order_id']);
  	}

		echo json_encode($return);
  }

  public function pembayaran_sukses($order_id)
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
  				$this->give_shuttle($pembelian->tiket_id);
  			}else{
  				$this->give_bib($pembelian->tiket_id);
  			}
  		}
  	} 
  }

  public function give_shuttle($id_tiket='')
  {
  	$this->db->where('tiket_id', $id_tiket);
  	$tiket = $this->db->get('master_tiket')->row();
  	// $new = $this->makeQR2($tiket->tiket_order_id);

  	$object['shuttle_user'] = $tiket->tiket_user;
  	$data_tiket = json_decode($tiket->tiket_data);
  	$object['shuttle_pos'] = $data_tiket[0]->kategori;
  	$object['shuttle_status'] = 'success';
  	// $object['shuttle_qr'] = $new;
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

  public function give_bib($notiket='19')
	{
		$this->db->where('tiket_id', $notiket);
		$tikets = $this->db->get('master_tiket')->row();
		if (empty($tikets)) return;
		foreach (json_decode($tikets->tiket_data) as $tiket) {
			// Transaksi + row-lock agar BIB berurutan & tidak duplikat saat webhook
			// kepanggil 2x / request bersamaan (race condition).
			$this->db->trans_start();
			$row = $this->db->query('SELECT pelari_bib, pelari_kategori FROM master_pelari WHERE pelari_id = ? FOR UPDATE', [$tiket->id_pelari])->row();
			if (!empty($row) && !empty($row->pelari_bib)){
				$this->db->trans_complete();
				continue; // sudah dapat BIB -> idempotent, lewati
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

	public function cek_kuota_dulu($value='')
	{
		$userdata = userdata();
		$this->db->where('kategori_id', $userdata->pelari_kategori);
		$cek = $this->db->get('master_kategori');
		if ($cek->row()->kategori_kuota < 1){
			return false;
		}

	}

  public function process($user='')
  {
  	$return['status'] = true;
  	$return['type'] = 'error';
  	$return['message'] = '';

  	$user = userid();
  	
    $ret = $this->make_tiket($user);
		
    $this->db->join('master_pelari', 'pelari_user = user_id', 'left');
		$users = $this->db->get_where('master_user', ['user_id' => $user])->row();

		// Required
		$transaction_details = array(
		  'order_id' => $ret['orderid'],
		  'gross_amount' => $ret['total'],
		);

		// Optional
		foreach (json_decode($ret['detail']) as $key) {
			$item_details[] = array(
			  'price' => $key->price,
			  'quantity' => 1,
			  'runner' => $key->nama,
			  'name' => $key->nama_kategori
			);
		}

		// Optional
		$customer_details = array(
		  'first_name'    => $users->pelari_name,
		  'last_name'     => "",
		  'email'         => $users->user_email,
		);

		// Data yang akan dikirim untuk request redirect_url.
        $credit_card['secure'] = true;
        //ser save_card true to enable oneclick or 2click
        //$credit_card['save_card'] = true;

        $time = time();
        $custom_expiry = array(
            'start_time' => date("Y-m-d H:i:s O",$time),
            'unit' => 'minutes', 
            'duration'  => 15
        );
        
        $transaction_data = array(
            'transaction_details'=> $transaction_details,
            'item_details'       => $item_details,
            'customer_details'   => $customer_details,
            'credit_card'        => $credit_card,
            'expiry'             => $custom_expiry
        );

		$snapToken = $this->midtrans->getSnapToken($transaction_data);
		$this->db->where('tiket_order_id', $ret['orderid']);
		$this->db->update('master_tiket', ['tiket_token' => $snapToken]);
		
		$return['type'] = 'success';
		$return['message'] = 'Sukses';
		$return['token'] = $snapToken;
  	
  	echo $snapToken;
  }

  public function process_shuttle($user='', $id='')
  {
  	$return['status'] = true;
  	$return['type'] = 'error';
  	$return['message'] = '';

  	$user = userid();
  	$idnya = post('idnya');
  	
    $ret = $this->make_shuttle($user, $idnya);
		
    $this->db->join('master_pelari', 'pelari_user = user_id', 'left');
		$users = $this->db->get_where('master_user', ['user_id' => $user])->row();

		// Required
		$transaction_details = array(
		  'order_id' => $ret['orderid'],
		  'gross_amount' => $ret['total'],
		);

		// Optional
		foreach (json_decode($ret['detail']) as $key) {
			$item_details[] = array(
			  'price' => $key->price,
			  'quantity' => 1,
			  'runner' => $key->nama,
			  'name' => $key->nama_kategori
			);
		}

		// Optional
		$customer_details = array(
		  'first_name'    => $users->pelari_name,
		  'last_name'     => "",
		  'email'         => $users->user_email,
		);

		// Data yang akan dikirim untuk request redirect_url.
        $credit_card['secure'] = true;
        //ser save_card true to enable oneclick or 2click
        //$credit_card['save_card'] = true;

        $time = time();
        $custom_expiry = array(
            'start_time' => date("Y-m-d H:i:s O",$time),
            'unit' => 'minutes', 
            'duration'  => 30
        );
        
        $transaction_data = array(
            'transaction_details'=> $transaction_details,
            'item_details'       => $item_details,
            'customer_details'   => $customer_details,
            'credit_card'        => $credit_card,
            'expiry'             => $custom_expiry
        );

		$snapToken = $this->midtrans->getSnapToken($transaction_data);
		$this->db->where('tiket_order_id', $ret['orderid']);
		$this->db->update('master_tiket', ['tiket_token' => $snapToken]);
		
		$return['type'] = 'success';
		$return['message'] = 'Sukses';
		$return['token'] = $snapToken;
  	
  	echo $snapToken;
  }

  public function make_shuttle($user='', $id='')
  {
  	
  	$userrrr = sprintf('%06d', userid());
		$orderid = MIDTRANS_TYPE.'SHT'.$id.''.$userrrr.''.rand(100,999);

  	$cek = $this->db->get_where('master_tiket', ['tiket_order_id' => $orderid]);
  	if ($cek->num_rows() == 0){
			$this->db->where('pelari_user', $user);
			$this->db->join('master_kategori', 'kategori_id = pelari_kategori', 'left');
		  $ok = $this->db->get('master_pelari');

			$total_harga = 0;
			$no = 0;
			
			if ($id == 1){
				$nama_shuttle = 'Titik 0 Pemkot Kediri';
			}else if ($id == 2){
				$nama_shuttle = 'Pemkab Kediri';
			}else{
				$nama_shuttle = 'Simpang Lima Gumul';
			}

			$pelari = $ok->row();
			$total_harga = 40000;
			$detail[$no]['kategori'] = $id;
			$detail[$no]['nama_kategori'] = 'SHUTTLE '.$id.' - '.$nama_shuttle;
			$detail[$no]['price'] = $total_harga;
			$detail[$no]['id_user'] = $pelari->pelari_user;
			$detail[$no]['id_pelari'] = $pelari->pelari_id;
			$detail[$no]['nama'] = $pelari->pelari_name;
			

			$ins['tiket_user'] = $user;
			$ins['tiket_amount'] = count($detail);
			$ins['tiket_price'] = $total_harga;
			$ins['tiket_data'] = json_encode($detail);
			$ins['tiket_order_id'] = $orderid;
			$this->db->insert('master_tiket', $ins);

			$ret['orderid'] = $orderid;
			$ret['total'] = $total_harga;
			$ret['detail'] = json_encode($detail);
		}else{
			$datane = $cek->row();
			$ret['orderid'] = $orderid;
			$ret['total'] = $datane->tiket_price;
			$ret['detail'] = $datane->tiket_data;
		}
		return $ret;
  }

  public function expiredthis($value='')
  {

  	$snapToken = $this->midtrans->expire(post('token'));
  	return $snapToken;
  }

  public function make_tiket($user='')
  {
  	
		$in_group = false;
  	$userrrr = sprintf('%06d', userid());
		$orderid = MIDTRANS_TYPE.'KHM'.$userrrr.''.rand(100,999);

  	$cek = $this->db->get_where('master_tiket', ['tiket_order_id' => $orderid]);
  	if ($cek->num_rows() == 0){
			$this->db->where('pelari_user', $user);
			$this->db->join('master_kategori', 'kategori_id = pelari_kategori', 'left');
		  $ok = $this->db->get('master_pelari');
		  if ($ok->num_rows() > 0){ $in_group = false;}

		  $grp = $ok->row()->pelari_group;
		  if ($grp != null){
				$this->db->where('pelari_group', $grp);
				$this->db->join('master_kategori', 'kategori_id = pelari_kategori', 'left');
				$ok2 = $this->db->get('master_pelari');
				if ($ok2->num_rows() > 1){ $in_group = true;}
			}

			$total_harga = 0;
			$no = 0;
			if ($in_group){
				$list = $ok2->result();
				foreach($list as $pelari){
					$harga = harga_group($pelari->kategori_id);

					$detail[$no]['kategori'] = $pelari->kategori_id;
					$detail[$no]['nama_kategori'] = $pelari->kategori_name;
					$detail[$no]['price'] = $harga;
					$detail[$no]['id_user'] = $pelari->pelari_user;
					$detail[$no]['id_pelari'] = $pelari->pelari_id;
					$detail[$no]['nama'] = $pelari->pelari_name;
					$total_harga += $harga;
					$no++;
				}
			}else{
				$pelari = $ok->row();
				$total_harga = $pelari->kategori_price;
				if (date('Y-m-d H:i:s') <= date('Y-m-d H:i:s', strtotime($pelari->kategori_dateearly))){
					$total_harga = $pelari->kategori_priceearly;
				}
				$detail[$no]['kategori'] = $pelari->kategori_id;
				$detail[$no]['nama_kategori'] = $pelari->kategori_name;
				$detail[$no]['price'] = $total_harga;
				$detail[$no]['id_user'] = $pelari->pelari_user;
				$detail[$no]['id_pelari'] = $pelari->pelari_id;
				$detail[$no]['nama'] = $pelari->pelari_name;
			}

			$ins['tiket_user'] = $user;
			$ins['tiket_amount'] = count($detail);
			$ins['tiket_price'] = $total_harga;
			$ins['tiket_data'] = json_encode($detail);
			$ins['tiket_order_id'] = $orderid;
			$this->db->insert('master_tiket', $ins);

			$ret['orderid'] = $orderid;
			$ret['total'] = $total_harga;
			$ret['detail'] = json_encode($detail);
		}else{
			$datane = $cek->row();
			$ret['orderid'] = $orderid;
			$ret['total'] = $datane->tiket_price;
			$ret['detail'] = $datane->tiket_data;
		}
		return $ret;
  }

  public function finish()
  {
  	$result = json_decode($this->input->post('result_data'));
  	echo 'RESULT <br><pre>';
  	var_dump($result);
  	echo '</pre>' ;

  }
}