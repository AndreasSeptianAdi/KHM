<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adminmodel extends CI_Model {

	public $variable;

	// ==================== KONFIGURASI VOUCHER ====================
	// Karakter penyusun kode voucher. Huruf/angka yang mirip satu sama lain
	// (I, O, 0, 1) sengaja dibuang supaya kode tidak ambigu saat dibaca peserta.
	private $voucher_charset = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
	private $voucher_length  = 16;   // jumlah digit kode
	private $voucher_max_qty = 500;  // batas maksimal QTY sekali generate

	public function __construct()
	{
		parent::__construct();
		
	}

	public function ubah_option($value='')
	{
		$date = post('idate');
		$time = post('itime');
		$tanggal = date('Y-m-d H:i:s', strtotime("$date $time"));
		option_update(post('opt_name'),$tanggal);

		$return['status'] = true;
		$return['type'] = 'success';
		$return['message'] = 'Data Tersimpan';
		return $return;
	}

	public function ubah_option_text($value='')
	{
		$opt = post('opt_name');
		$val = post('ovalue');
		$get = $this->db->get_where('master_options', ['option_name' => $opt]);
		if ($get->num_rows() == 1) {
			$this->db->where('option_name', $opt);
			$this->db->update('master_options', ['option_value' => $val]);
		} else {
			$this->db->insert('master_options', ['option_name' => $opt, 'option_value' => $val]);
		}
		$return['status'] = true;
		$return['type'] = 'success';
		$return['message'] = 'Data Tersimpan';
		return $return;
	}

	public function ubah_kaos($value='')
	{
		$kaos = post('kaos');
		$kaosfinish = post('kaosfinish');
		$id = post('pelari_id');

		$upd['pelari_kaosfinish'] = $kaosfinish;
		$upd['pelari_kaos'] = $kaos;
		$this->db->where('pelari_id', $id);
		$this->db->update('master_pelari', $upd);

		$return['status'] = true;
		$return['type'] = 'success';
		$return['message'] = 'Data Tersimpan';
		return $return;
	}

	public function cek_barcode($value='')
	{
		$return['status'] = true;
		$return['type'] = 'error';
		$return['message'] = 'Data Tidak Ditemukan';

		$data = json_decode(file_get_contents('php://input'),1);
		$val = $data['pelari_id'];

		$ambil = $this->session->userdata('ambil');

		$password=BASE_PASSWORD;
		$decrypted_string=openssl_decrypt($val,"AES-128-ECB",$password);
		
		$this->db->where('pelari_bib', $decrypted_string);
		$a = $this->db->get('master_pelari');
		if (($decrypted_string != '') || ($decrypted_string != null)){
			if ($a->num_rows() == 0){
				$return['status'] = false;
			}else{
				if ($a->row()->pelari_ambil == 'T'){
					$return['status'] = false;
					$return['message'] = 'Sudah Terambil';
				}
			}
		}else{
			$return['status'] = false;
		}
	
		if ($return['status']){
			$data = $a->row();
			$rettt = $this->ambil_check($data->pelari_id);
			$return['type'] = 'success';
			$return['message'] = humanize($data->pelari_name).' '.$rettt;
		}
		$return['status'] = true;
		return $return;
	}

	public function ambil_old($value='')
	{
		$object['pelari_ambil'] = (post('status') == 'T')? 'F' : 'T';
		$object['pelari_ambildate'] = (post('status') != 'T')? date('Y-m-d H:i:s') : null;
		$object['pelari_ambilnama'] = null;
		$this->db->where('pelari_id', post('id'));
		$this->db->update('master_pelari', $object);

		$return['status'] = true;
		$return['type'] = 'success';
		$text = (post('status') == 'T')? 'Dibatalkan' : 'Diambil';
		$return['message'] = 'Sukses '.$text;
		return $return;
	}

	public function ambil($value='')
	{
		$return['status'] = false;
		$return['type'] = 'error';
		$return['message'] = 'Pengambilan Error, No List ';
		$ambil = $this->session->userdata('ambil');
		if (is_array($ambil)){
  		if (count($ambil) > 0){
			foreach($ambil as $list){
				$object['pelari_ambil'] = 'T';
				$object['pelari_ambilnama'] = post('pengambil');
				$object['pelari_ambildate'] = date('Y-m-d H:i:s');
				$this->db->where('pelari_id', $list);
				$this->db->update('master_pelari', $object);
			}

			$this->session->set_userdata('ambil', '');

			$return['status'] = true;
			$return['type'] = 'success';
			$return['message'] = 'Sukses Tersimpan';
		}}
		return $return;
	}

	public function ambil_check($or_id='', $setatus = 'F')
	{
		$status = (post('status') != null)? post('status') : $setatus;
		$id_ambil = ($or_id == '')? post('id') : $or_id;
		$ambil = $this->session->userdata('ambil');
		$out = '';
		if ($status == 'F'){
			if ($ambil == null){
				$ambil = array();
			}

			if (($key = array_search($id_ambil, $ambil)) !== false) {
				$out = 'Sudah Ditambahkan';
			}else{
				$out = 'Ditambahkan';
				array_push($ambil, $id_ambil);
			}
			
		}else{
      if (($key = array_search($id_ambil, $ambil)) !== false) {
				unset($ambil[$key]);
			}
			$out = 'Dihilangkan';
		} 

		$array = array(
			'ambil' => $ambil
		);
		
		$this->session->set_userdata( $array );
		return $out;
	}

	public function hapus_data()
	{
		$return['status'] = true;
		$return['type'] = 'error';
		$return['message'] = '';

		if (userid() != 1){
			$this->main->logout();
			return;
		}
		
		$tabel = post('from');
		
	
		if ($return['status']){
			$this->db->where($tabel.'_id', post('id'));
			$this->db->delete('master_'.$tabel);
			$return['type'] = 'success';
			$return['message'] = 'Terhapus';
		}
	
		return $return;
	}

	public function update_status($table='',$status='',$id='')
	{
		$status = ($status == 'checked')? '0' : '1';
		$this->db->where($table.'_status', $status);
		$upd[$table.'_status'] = $status;
		$this->db->update('master_'.$table, $upd);
	}

	public function read_notif()
	{
		$return['status'] = true;
		$return['type'] = 'error';
		$return['message'] = '';
		$return['csrf_data'] = $this->security->get_csrf_hash();
	
		if ($return['status']){
			if (get('selectedIds')){
				foreach (get('selectedIds') as $key => $value) {
					$explode1 = explode('<input value="', $value);
					$dataID = explode('" type="hidden">', $explode1[1]);
					$object['notif_status'] = get('mode');
					$this->db->where('notif_id', $dataID[0]);
					$this->db->update('tb_notif', $object);
				}
			}else{
				$object['notif_status'] = (get('view') == 'read')? 'unread' : 'read';
				$this->db->where('notif_id', get('id'));
				$this->db->update('tb_notif', $object);
			}
			$return['type'] = 'success';
			$return['message'] = $object['notif_status'];
		}
	
		return $return;
	}

	public function change_status($value='')
	{
		$return['status'] = true;
		$return['type'] = 'error';
		$return['message'] = 'Gagal Menyimpan';

		if (userid() != 1){
			$return['status']  = FALSE;
			$return['message'] = 'Akses Ditolak';
			return $return;
		}

		$table = post('table');
		$id = post('id');
		$content = post('content');
	
		if ($return['status']){
			$upd[$table.'_status'] = ($content == '1')? '0' : '1';
			$this->db->where($table.'_id', $id);
			$this->db->update('master_'.$table, $upd);
			$return['type'] = 'success';
			$return['message'] = 'Sukses';
		}
	
		return $return;
	}

	public function change_status_kat($value='')
	{
		$return['status'] = true;
		$return['type'] = 'error';
		$return['message'] = 'Gagal Menyimpan';
		
		$table = post('table');
		$id = post('id');
		$content = post('content');
	
		if ($return['status']){
			$tgl1 = date('Y-m-d H:i:s', strtotime('-2 days'));
			$tgl2 = date('Y-m-d H:i:s', strtotime('+10 days'));
			$upd[$table.'_dateexp'] = ($content == '1')? $tgl1 : $tgl2;
			$this->db->where($table.'_id', $id);
			$this->db->update('master_'.$table, $upd);
			$return['type'] = 'success';
			$return['message'] = 'Sukses';
		}
	
		return $return;
	}

	public function save_kategori($value='')
	{
		$return['status'] = true;
		$return['type'] = 'error';
		$return['message'] = '';
		
		$this->form_validation->set_rules('name', 'Nama Kategori', 'trim|required');
		$this->form_validation->set_rules('kategori', 'Kategori Lomba', 'trim|required');
		$this->form_validation->set_rules('harga', 'Harga Normal', 'trim|required');
		$this->form_validation->set_rules('early', 'Harga Awal', 'trim|required');
		$this->form_validation->set_rules('earlydate', 'Masa Harga Awal', 'trim|required');
		$this->form_validation->set_rules('kuota', 'Kuota Pelari', 'trim|required');
		$this->form_validation->set_rules('startdates', 'Tanggal Awal Registrasi', 'trim|required');
		$this->form_validation->set_rules('expired', 'Tanggal Berakhir Registrasi', 'trim|required');
		$this->form_validation->set_rules('umurmin', 'Umur Minimal Kategori', 'trim|required');
		$this->form_validation->set_rules('umurmax', 'Umur Maxmal Kategori', 'trim|required');
		$this->form_validation->set_rules('kaos', 'Kaos Finish', 'trim|required');
		$this->form_validation->set_rules('prefix', 'Prefix Penomoran', 'trim');
		$this->form_validation->set_rules('startid', 'Start Nomor', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$return['status'] = false;
			$return['message'] = validation_errors(' ',' <br>');
		}
	
		if ($return['status']){
			$ins['kategori_name'] =	post('name');
			$ins['kategori_kategori'] =	post('kategori');
			$ins['kategori_price'] = post('harga');
			$ins['kategori_priceearly'] =	post('early');
			$ins['kategori_dateearly'] = date('Y-m-d H:i:s', strtotime(post('earlydate')));
			$ins['kategori_kuota'] = post('kuota');
			$ins['kategori_datestart'] = date('Y-m-d H:i:s', strtotime(post('startdates')));
			$ins['kategori_dateexp'] = date('Y-m-d H:i:s', strtotime(post('expired')));
			$ins['kategori_umurmin'] =	post('umurmin');
			$ins['kategori_umurmax'] =	post('umurmax');
			$ins['kategori_kaosfinish'] =	post('kaos');
			$ins['kategori_prefix'] =	post('prefix');
			$ins['kategori_startid'] =	post('startid');

			if (post('id') != ''){
				$this->db->where('kategori_id', post('id'));
				$this->db->update('master_kategori', $ins);
			}else{
				$this->db->insert('master_kategori', $ins);
			}
			$return['type'] = 'success';
			$return['message'] = 'Kategori Tersimpan';
		}
	
		return $return;
	}

	// ==================== VOUCHER ====================

	/**
	 * Bikin satu kode voucher acak sepanjang $voucher_length.
	 */
	private function make_voucher_code()
	{
		$max  = strlen($this->voucher_charset) - 1;
		$code = '';
		for ($i = 0; $i < $this->voucher_length; $i++) {
			$rand = function_exists('random_int') ? random_int(0, $max) : mt_rand(0, $max);
			$code .= $this->voucher_charset[$rand];
		}
		return $code;
	}

	/**
	 * Kode grouping untuk satu kali generate (dipakai buat lihat/copy/export
	 * semua kode dalam satu batch QTY).
	 */
	private function make_batch_code()
	{
		$max  = strlen($this->voucher_charset) - 1;
		$code = '';
		for ($i = 0; $i < 5; $i++) {
			$rand = function_exists('random_int') ? random_int(0, $max) : mt_rand(0, $max);
			$code .= $this->voucher_charset[$rand];
		}
		return 'B'.date('ymd').'-'.$code;
	}

	/**
	 * Bikin $qty kode unik (dicek ke DB biar tidak bentrok dengan voucher lama).
	 * Return array kode, atau FALSE kalau gagal.
	 */
	private function generate_unique_codes($qty)
	{
		$codes   = array();
		$putaran = 0;

		while (count($codes) < $qty) {
			$putaran++;
			if ($putaran > 10){ return FALSE; }

			$butuh    = $qty - count($codes);
			$buat     = (int)ceil($butuh * 1.2) + 5; // dilebihkan buat nutup bentrok
			$kandidat = array();

			for ($i = 0; $i < $buat; $i++) {
				$c = $this->make_voucher_code();
				if (!isset($codes[$c]) && !isset($kandidat[$c])){
					$kandidat[$c] = $c;
				}
			}
			if (count($kandidat) == 0){ continue; }

			$list = array_values($kandidat);
			$in   = implode(',', array_fill(0, count($list), '?'));
			$ada  = $this->db->query('SELECT voucher_code FROM master_voucher WHERE voucher_code IN ('.$in.')', $list)->result();
			foreach ($ada as $row) {
				unset($kandidat[$row->voucher_code]);
			}

			foreach ($kandidat as $c) {
				if (count($codes) >= $qty){ break; }
				$codes[$c] = $c;
			}
		}

		return array_values($codes);
	}

	/**
	 * Admin generate voucher (bisa banyak sekaligus lewat QTY).
	 * Kuota kategori OTOMATIS berkurang sejumlah QTY dalam 1 transaksi,
	 * jadi kalau kuota tidak cukup semuanya di-rollback (kuota tidak tersentuh).
	 */
	public function save_voucher($value='')
	{
		$return['status']  = TRUE;
		$return['type']    = 'error';
		$return['message'] = 'Gagal Membuat Voucher';

		if (userid() != 1){
			$return['status']  = FALSE;
			$return['message'] = 'Akses Ditolak';
			return $return;
		}

		$this->form_validation->set_rules('kategori', 'Kategori Lomba', 'trim|required|numeric');
		$this->form_validation->set_rules('qty', 'Jumlah Voucher (QTY)', 'trim|required|numeric');
		$this->form_validation->set_rules('batch', 'Nama Batch', 'trim|max_length[100]');
		$this->form_validation->set_rules('note', 'Catatan', 'trim|max_length[255]');
		$this->form_validation->set_rules('expired', 'Berlaku Sampai', 'trim');

		if ($this->form_validation->run() == FALSE) {
			$return['status']  = FALSE;
			$return['message'] = validation_errors(' ',' <br>');
			return $return;
		}

		$kategori_id = (int)post('kategori');
		$qty         = (int)post('qty');

		if (($qty < 1) || ($qty > $this->voucher_max_qty)){
			$return['status']  = FALSE;
			$return['message'] = 'QTY harus antara 1 sampai '.$this->voucher_max_qty;
			return $return;
		}

		$expired = NULL;
		if (trim(post('expired')) != ''){
			$ts = strtotime(post('expired'));
			if ($ts === FALSE){
				$return['status']  = FALSE;
				$return['message'] = 'Format tanggal "Berlaku Sampai" tidak valid';
				return $return;
			}
			$expired = date('Y-m-d H:i:s', $ts);
		}

		// kunci baris kategori supaya kuota tidak berebut dengan request lain
		$this->db->trans_start();
		$kat = $this->db->query('SELECT kategori_id, kategori_name, kategori_kuota, kategori_status FROM master_kategori WHERE kategori_id = ? FOR UPDATE', array($kategori_id))->row();

		if (empty($kat)){
			$this->db->trans_complete();
			$return['status']  = FALSE;
			$return['message'] = 'Kategori lomba tidak ditemukan';
			return $return;
		}
		if ($kat->kategori_status != '1'){
			$this->db->trans_complete();
			$return['status']  = FALSE;
			$return['message'] = 'Kategori <b>'.$kat->kategori_name.'</b> sedang tidak aktif';
			return $return;
		}
		if ((int)$kat->kategori_kuota < $qty){
			$this->db->trans_complete();
			$return['status']  = FALSE;
			$return['message'] = 'Sisa kuota <b>'.$kat->kategori_name.'</b> hanya <b>'.(int)$kat->kategori_kuota.'</b>, tidak cukup untuk membuat '.$qty.' voucher';
			return $return;
		}

		$codes = $this->generate_unique_codes($qty);
		if ($codes === FALSE){
			$this->db->trans_complete();
			$return['status']  = FALSE;
			$return['message'] = 'Gagal membuat kode unik, silahkan coba lagi';
			return $return;
		}

		$batchcode = $this->make_batch_code();
		$batch     = (trim(post('batch')) != '')? trim(post('batch')) : $kat->kategori_name;
		$now       = date('Y-m-d H:i:s');
		$rows      = array();

		foreach ($codes as $code) {
			$rows[] = array(
				'voucher_code'      => $code,
				'voucher_kategori'  => $kategori_id,
				'voucher_batchcode' => $batchcode,
				'voucher_batch'     => $batch,
				'voucher_note'      => post('note'),
				'voucher_expired'   => $expired,
				'voucher_status'    => '1',
				'voucher_used'      => 'F',
				'voucher_created'   => $now,
			);
		}

		$this->db->insert_batch('master_voucher', $rows);

		// kuota otomatis berkurang sejumlah QTY (guard >= qty biar tidak pernah minus)
		$this->db->query('UPDATE master_kategori SET kategori_kuota = kategori_kuota - ? WHERE kategori_id = ? AND kategori_kuota >= ?', array($qty, $kategori_id, $qty));

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE){
			$return['status']  = FALSE;
			$return['message'] = 'Gagal menyimpan voucher, kuota tidak jadi dipotong';
			return $return;
		}

		$return['status']    = TRUE;
		$return['type']      = 'success';
		$return['message']   = $qty.' voucher berhasil dibuat untuk kategori <b>'.$kat->kategori_name.'</b>.<br>Sisa kuota sekarang <b>'.((int)$kat->kategori_kuota - $qty).'</b>.<br>Kode Batch: <b>'.$batchcode.'</b>';
		$return['batchcode'] = $batchcode;

		makeNotif('Voucher Dibuat', $qty.' voucher dibuat untuk kategori '.$kat->kategori_name.' (batch '.$batchcode.')', '1');

		return $return;
	}

	/**
	 * Hapus 1 voucher yang BELUM terpakai -> kuota kategori dikembalikan (+1).
	 * Voucher yang sudah dipakai pelari tidak boleh dihapus.
	 */
	public function hapus_voucher($value='')
	{
		$return['status']  = TRUE;
		$return['type']    = 'error';
		$return['message'] = 'Gagal Menghapus Voucher';

		if (userid() != 1){
			$return['status']  = FALSE;
			$return['message'] = 'Akses Ditolak';
			return $return;
		}

		$id = (int)post('id');

		$this->db->trans_start();
		$vou = $this->db->query('SELECT voucher_id, voucher_code, voucher_kategori, voucher_used FROM master_voucher WHERE voucher_id = ? FOR UPDATE', array($id))->row();

		if (empty($vou)){
			$this->db->trans_complete();
			$return['status']  = FALSE;
			$return['message'] = 'Voucher tidak ditemukan';
			return $return;
		}
		if ($vou->voucher_used == 'T'){
			$this->db->trans_complete();
			$return['status']  = FALSE;
			$return['message'] = 'Voucher <b>'.$vou->voucher_code.'</b> sudah dipakai pelari, tidak bisa dihapus';
			return $return;
		}

		$this->db->where('voucher_id', $id);
		$this->db->delete('master_voucher');

		// kembalikan kuota yang tadi dipotong saat generate
		$this->db->query('UPDATE master_kategori SET kategori_kuota = kategori_kuota + 1 WHERE kategori_id = ?', array($vou->voucher_kategori));

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE){
			$return['status']  = FALSE;
			$return['message'] = 'Gagal menghapus voucher';
			return $return;
		}

		$return['type']    = 'success';
		$return['message'] = 'Voucher <b>'.$vou->voucher_code.'</b> terhapus, kuota dikembalikan';
		return $return;
	}

	/**
	 * Hapus seluruh voucher BELUM TERPAKAI dalam satu batch generate,
	 * kuota dikembalikan sebanyak jumlah voucher yang terhapus.
	 */
	public function hapus_batch_voucher($value='')
	{
		$return['status']  = TRUE;
		$return['type']    = 'error';
		$return['message'] = 'Gagal Menghapus Batch Voucher';

		if (userid() != 1){
			$return['status']  = FALSE;
			$return['message'] = 'Akses Ditolak';
			return $return;
		}

		$batchcode = trim(post('batchcode'));
		if ($batchcode == ''){
			$return['status']  = FALSE;
			$return['message'] = 'Kode batch kosong';
			return $return;
		}

		$this->db->trans_start();
		$rows = $this->db->query("SELECT voucher_id, voucher_kategori FROM master_voucher WHERE voucher_batchcode = ? AND voucher_used = 'F' FOR UPDATE", array($batchcode))->result();

		if (count($rows) == 0){
			$this->db->trans_complete();
			$return['status']  = FALSE;
			$return['message'] = 'Tidak ada voucher belum terpakai di batch <b>'.$batchcode.'</b>';
			return $return;
		}

		// hitung jumlah voucher per kategori, lalu kembalikan kuotanya
		$per_kategori = array();
		$ids          = array();
		foreach ($rows as $row) {
			$ids[] = (int)$row->voucher_id;
			$katid = (int)$row->voucher_kategori;
			$per_kategori[$katid] = (isset($per_kategori[$katid]))? $per_kategori[$katid] + 1 : 1;
		}

		foreach ($per_kategori as $katid => $jml) {
			$this->db->query('UPDATE master_kategori SET kategori_kuota = kategori_kuota + ? WHERE kategori_id = ?', array($jml, $katid));
		}

		$in = implode(',', array_fill(0, count($ids), '?'));
		$this->db->query('DELETE FROM master_voucher WHERE voucher_id IN ('.$in.')', $ids);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE){
			$return['status']  = FALSE;
			$return['message'] = 'Gagal menghapus batch voucher';
			return $return;
		}

		$return['type']    = 'success';
		$return['message'] = count($ids).' voucher di batch <b>'.$batchcode.'</b> terhapus, kuota dikembalikan';
		return $return;
	}

	public function save_user($value='')
	{
		$return['status'] = true;
		$return['type'] = 'error';
		$return['message'] = 'Gagal Menyimpan';
		
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		if (post('password') != ''){
			$this->form_validation->set_rules('password', 'Password Baru', 'trim|required|min_length[6]');
			$this->form_validation->set_rules('repassword', 'Ulangi Password', 'trim|min_length[6]|required|matches[password]');
		}

		if ($this->form_validation->run() == FALSE) {
			$return['status'] = false;
			$return['message'] = validation_errors(' ',' <br>');
		}
	
		if ($return['status']){
			$ins['user_email'] =	post('email');
			if (post('password') != ''){
				$ins['user_password'] =	md5(post('repassword'));
			}

			if (post('id') != ''){
				$this->db->where('user_id', post('id'));
				$this->db->update('master_user', $ins);
			}else{
				$this->db->insert('master_user', $ins);
			}
			$return['type'] = 'success';
			$return['message'] = 'User Tersimpan';
		}
	
		return $return;
	}

	public function save_pelari($value='')
	{
		$return['status'] = true;
		$return['type'] = 'error';
		$return['message'] = 'Gagal Menyimpan';
		
		if ((userid() == '1') && (post('id') == '')) {
			$this->form_validation->set_rules('email', 'E-Mail', 'trim|required|is_unique[master_user.user_email]');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
		}

		$this->form_validation->set_rules('name', 'Nama Lengkap', 'trim|required');
		$this->form_validation->set_rules('identitas', 'No Identitas', 'trim|required');
		$this->form_validation->set_rules('sex', 'Jenis Kelamin', 'trim|required');
		$this->form_validation->set_rules('tgllahir', 'Tanggal Lahir', 'trim|required');
		$this->form_validation->set_rules('goldar', 'Golongan Darah', 'trim|required');
		$this->form_validation->set_rules('provinsi', 'Provinsi', 'trim|required');
		$this->form_validation->set_rules('city', 'Kota', 'trim|required');
		$this->form_validation->set_rules('telp', 'Nomor Telepon', 'trim|required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
		$this->form_validation->set_rules('riwayat', 'Riwayat Sakit', 'trim|required');
		$this->form_validation->set_rules('namadarurat', 'Nama Kontak Darurat', 'trim|required');
		$this->form_validation->set_rules('tlpdarurat', 'Nomor Telp Kontak', 'trim|required');
		$this->form_validation->set_rules('namabib', 'Nama BIB', 'trim|required');
		$this->form_validation->set_rules('kategori', 'Kategori Lari', 'trim|required');

		$this->form_validation->set_rules('kaos', 'Ukuran Kaos', 'trim|required');
		
		$exp = explode('|', post('kategori'));
		if ($exp[1] == 'T'){
			$this->form_validation->set_rules('pelari_kaosfinish', 'Finnish Jacket', 'trim|required');
		}
		if ($exp[2] == 'pelajar'){
			$this->form_validation->set_rules('asalsekolah', 'Asal Sekolah', 'trim|required');
		}

		if ($this->form_validation->run() == FALSE) {
			$return['status'] = false;
			$return['message'] = validation_errors(' ',' <br>');
		}
	
		if ($return['status']){

			if ((userid() == '1') && (post('id') == '')) {
				$usr['user_email'] =	post('email');
				$usr['user_password'] =	md5(post('password'));
				$this->db->insert('master_user', $usr);
				$ins['pelari_user'] =	$this->db->insert_id();
			}

			$ins['pelari_name'] =	post('name');
			$ins['pelari_identitas'] =	post('identitas');
			$ins['pelari_sex'] =	post('sex');
			$ins['pelari_tgllahir'] =	post('tgllahir');
			$ins['pelari_goldar'] =	post('goldar');
			$ins['pelari_provinsi'] =	post('provinsi');
			$ins['pelari_kota'] =	post('city');
			$ins['pelari_telp'] =	post('telp');
			$ins['pelari_alamat'] =	post('alamat');
			$ins['pelari_riwayat'] =	post('riwayat');
			if (post('riwayat') == 'T'){
				$ins['pelari_ketriwayat'] =	post('ketriwayat');
			}else{
				$ins['pelari_ketriwayat'] =	'';
			}
			$ins['pelari_namadarurat'] =	post('namadarurat');
			$ins['pelari_tlpdarurat'] =	post('tlpdarurat');
			$ins['pelari_namabib'] =	post('namabib');
			
			$ins['pelari_kategori'] =	$exp[0];
			$ins['pelari_kaos'] =	post('kaos');
			if ($exp[1] == 'T'){
				$ins['pelari_kaosfinish'] =	post('pelari_kaosfinish');
			}else{
				$ins['pelari_kaosfinish'] =	'';
			}
			if ($exp[2] == 'pelajar'){
				$ins['pelari_club'] =	post('asalsekolah');
			}else{
				$ins['pelari_club'] =	'';
			}

			if (post('id') != ''){
				$this->db->where('pelari_id', post('id'));
				$this->db->update('master_pelari', $ins);
			}else{
				$this->db->insert('master_pelari', $ins);
			}
			$return['type'] = 'success';
			$return['message'] = 'Pelari Tersimpan';
		}
	
		return $return;
	}

	public function by_pass($value='')
	{
		$return['status'] = true;
		$return['type'] = 'error';
		$return['message'] = '';

		$this->db->trans_start();
		$kat = $this->db->query('SELECT p.pelari_id, p.pelari_bib, p.pelari_kategori, p.pelari_user, p.pelari_name, k.kategori_prefix, k.kategori_startid, k.kategori_name, u.user_email, u.user_id FROM master_pelari p LEFT JOIN master_kategori k ON k.kategori_id = p.pelari_kategori LEFT JOIN master_user u ON u.user_id = p.pelari_user WHERE p.pelari_id = ? FOR UPDATE', [post('id')])->row();
		if (empty($kat)){
			$this->db->trans_complete();
			$return['message'] = 'Data pelari tidak ditemukan';
			return $return;
		}
		if (!empty($kat->pelari_bib)){
			$this->db->trans_complete();
			$return['type'] = 'warning';
			$return['message'] = 'Pelari sudah punya BIB '.$kat->pelari_bib;
			return $return;
		}
		$no_bib = $kat->kategori_prefix.''.$kat->kategori_startid;
		$this->db->where('pelari_id', $kat->pelari_id);
		$this->db->update('master_pelari', ['pelari_bib' => $no_bib, 'pelari_bypass' => 'true']);
		$this->db->query('UPDATE master_kategori SET kategori_startid = kategori_startid + 1 WHERE kategori_id = ?', [$kat->pelari_kategori]);
		$this->db->trans_complete();
		$qr = $this->makeQR($no_bib); // QR dibuat SETELAH counter maju

		$data['nama_pelari'] = $kat->pelari_name;
		$data['kategori'] = $kat->kategori_name;
		$data['no_bib'] = $no_bib;
		$data['qrcode'] = $qr;
		$data['email'] = $kat->user_email;
		$email = $this->load->view('library/mail_content', $data, TRUE);
		makeNotif('Selamat Pembayaran Berhasil', $email, $kat->user_id);
		

		$this->mainmodel->send_email($kat->user_email, $email, 'Pembayaran Berhasil');

		// counter startid sudah +1 di transaksi atas (atomic), jangan increment lagi
  	
	
		if ($return['status']){
			$return['type'] = 'success';
			$return['message'] = 'By Pass Sukses';
		}
	
		return $return;
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
		return $new;
	}

	public function kirim_email($value='')
	{
		$return['status'] = true;
		$return['type'] = 'error';
		$return['message'] = '';
		
		if (get('selectedIds')){
			foreach (get('selectedIds') as $key => $value) {
				$explode1 = explode('<input value="', $value);
				$user = explode('" type="hidden" data-email="', $explode1[1]);
				$uemail = explode('"', $user[0]);
				
				$data['email'] = $uemail[4];
				$email = $this->load->view('library/pengambilan', $data, TRUE);
				
				$this->mainmodel->send_email($uemail[4],$email,'Pengambilan Paket Lari');
				
				$ob['pelari_ambilinfo'] = date('Y-m-d H:i:s');
				$this->db->where('pelari_id', $uemail[0]);
				$this->db->update('master_pelari', $ob);
			}
		}else{

			$data['email'] = post('email');
			$email = $this->load->view('library/pengambilan', $data, TRUE);
			
			$this->mainmodel->send_email(post('email'),$email,'Pengambilan Paket Lari');

			$ob['pelari_ambilinfo'] = date('Y-m-d H:i:s');
			$this->db->where('pelari_id', post('user'));
			$this->db->update('master_pelari', $ob);
		}
		if ($return['status']){
			$return['type'] = 'success';
			$return['message'] = 'Email Terkirim';
		}
	
		return $return;
	}

	public function kirim_email2($value='')
	{
		$return['status'] = true;
		$return['type'] = 'error';
		$return['message'] = '';

		$this->db->join('master_kategori', 'kategori_id = pelari_kategori', 'left');
		$this->db->join('master_user', 'user_id = pelari_user', 'left');
		$kat = $this->db->get_where('master_pelari', ['pelari_id' => post('user')])->row();
		$no_bib = humanize($kat->pelari_bib);
		$qr = $this->ambil_qr($no_bib);
		$data['nama_pelari'] = $kat->pelari_name;
		$data['kategori'] = $kat->kategori_name;
		$data['no_bib'] = $no_bib;
		$data['qrcode'] = $qr;
		$data['email'] = post('email');
		$email = $this->load->view('library/mail_content', $data, TRUE);
		$this->mainmodel->send_email(post('email'), $email, 'Pembayaran Berhasil');
		makeNotif('Selamat Pembayaran Berhasil', $email, $kat->user_id);
		

		if ($return['status']){
			$return['type'] = 'success';
			$return['message'] = 'Email Terkirim';
		}
	
		return $return;
	}

}

/* End of file  */
/* Location: ./application/models/ */