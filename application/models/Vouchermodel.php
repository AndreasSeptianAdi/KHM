<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model untuk pendaftaran lari lewat VOUCHER (di dalam aplikasi, wajib login).
 *
 * Alur:
 *  1. Peserta register + login lewat alur biasa (auth/register, auth/login)
 *  2. Menu "Daftar Pelari" diarahkan ke halaman voucher -> input kode -> cek_voucher()
 *  3. Kalau asli, kode disimpan di session lalu peserta isi data pelari
 *  4. save_pelari_voucher() menyimpan data pelari + nomor BIB untuk user yang
 *     sedang login, lalu voucher ditandai terpakai. Tidak ada akun baru dibuat.
 *
 * PENTING: kuota kategori (kategori_kuota) TIDAK dipotong di sini, karena sudah
 * dipotong oleh admin saat men-generate voucher (Adminmodel::save_voucher).
 */
class Vouchermodel extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Normalisasi kode voucher: buang spasi/tanda baca, jadikan huruf besar.
	 */
	public function rapikan_kode($kode='')
	{
		$kode = strtoupper(trim((string)$kode));
		$kode = preg_replace('/[^A-Z0-9]/', '', $kode);
		return $kode;
	}

	/**
	 * Cek keaslian voucher. Kalau valid, ikut mengembalikan data voucher + kategorinya.
	 */
	public function cek_voucher($kode='')
	{
		$return['status']  = FALSE;
		$return['type']    = 'error';
		$return['message'] = 'Kode voucher tidak dikenali';

		$kode = $this->rapikan_kode($kode);

		if (strlen($kode) != 16){
			$return['message'] = 'Kode voucher harus terdiri dari 16 karakter';
			return $return;
		}

		$get = $this->db->get_where('master_voucher', array('voucher_code' => $kode));
		if ($get->num_rows() != 1){
			$return['message'] = 'Kode voucher tidak dikenali. Periksa kembali kode Anda.';
			return $return;
		}
		$vou = $get->row();

		if ($vou->voucher_used == 'T'){
			$return['message'] = 'Voucher ini sudah pernah digunakan untuk mendaftar.';
			return $return;
		}
		if ($vou->voucher_status != '1'){
			$return['message'] = 'Voucher ini sedang dinonaktifkan. Silahkan hubungi panitia.';
			return $return;
		}
		if (($vou->voucher_expired != NULL) && ($vou->voucher_expired != '') && ($vou->voucher_expired < date('Y-m-d H:i:s'))){
			$return['message'] = 'Voucher ini sudah kadaluarsa pada '.date('d F Y H:i', strtotime($vou->voucher_expired));
			return $return;
		}

		$getkat = $this->db->get_where('master_kategori', array('kategori_id' => $vou->voucher_kategori));
		if ($getkat->num_rows() != 1){
			$return['message'] = 'Kategori lomba voucher ini tidak ditemukan.';
			return $return;
		}
		$kat = $getkat->row();

		if ($kat->kategori_status != '1'){
			$return['message'] = 'Kategori <b>'.$kat->kategori_name.'</b> sedang tidak aktif.';
			return $return;
		}

		$return['status']    = TRUE;
		$return['type']      = 'success';
		$return['message']   = 'Voucher ASLI dan masih tersedia.';
		$return['voucher']   = $vou;
		$return['kategori']  = $kat;
		$return['kode']      = $kode;

		return $return;
	}

	/**
	 * Bikin QR code nomor BIB (sama persis dengan Payment::makeQR / Adminmodel::makeQR
	 * supaya tetap terbaca oleh scanner pengambilan paket).
	 */
	public function buat_qr($bibs='')
	{
		$password = BASE_PASSWORD;
		$bib = openssl_encrypt($bibs, "AES-128-ECB", $password);
		$this->load->library('ciqrcode');
		$params['data']     = $bib;
		$params['level']    = 'H';
		$params['size']     = 1024;
		$ok                 = strip_tags($bib);
		$new                = str_replace('/', '-', $ok);
		$params['savename'] = FCPATH.'/assets/qr/'.$new.'.jpeg';
		$this->ciqrcode->generate($params);

		return $new;
	}

	/**
	 * Simpan data pelari dari pendaftaran voucher.
	 * Memakai akun user yang sedang login (tidak membuat akun baru), menyimpan
	 * data pelari + nomor BIB, lalu menandai voucher jadi terpakai.
	 * Semuanya dalam 1 transaksi DB.
	 */
	public function save_pelari_voucher($value='')
	{
		$return['status']  = FALSE;
		$return['type']    = 'error';
		$return['message'] = 'Gagal Menyimpan';

		$kode = $this->rapikan_kode(post('voucher_code'));
		$sesi = $this->rapikan_kode($this->session->userdata('voucher_code'));

		// kode harus sama dengan yang sudah diverifikasi di halaman cek voucher
		if (($sesi == '') || ($sesi != $kode)){
			$return['message'] = 'Sesi voucher Anda berakhir. Silahkan cek ulang kode voucher.';
			return $return;
		}

		// Akun login sudah dibuat lewat registrasi biasa (auth/register),
		// jadi di sini tinggal memakai user yang sedang login.
		if ($this->session->userdata('logged_in') != TRUE){
			$return['message'] = 'Silakan login terlebih dahulu.';
			return $return;
		}
		$user_id  = userid();
		$user_ada = $this->db->get_where('master_user', array('user_id' => $user_id))->row();
		if (empty($user_ada)){
			$return['message'] = 'Akun Anda tidak ditemukan, silahkan login ulang.';
			return $return;
		}
		$email = $user_ada->user_email;

		// satu akun hanya boleh punya satu data pelari
		$pelari_ada = $this->db->get_where('master_pelari', array('pelari_user' => $user_id))->row();
		if (!empty($pelari_ada) && ($pelari_ada->pelari_kategori != '')){
			$return['message'] = 'Akun ini sudah terdaftar sebagai pelari.';
			return $return;
		}

		$this->form_validation->set_rules('name', 'Nama Lengkap', 'trim|required');
		$this->form_validation->set_rules('identitas', 'No Identitas', 'trim|required|is_unique[master_pelari.pelari_identitas]');
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
		$this->form_validation->set_rules('kaos', 'Ukuran Kaos', 'trim|required');

		// kategori lari DIKUNCI mengikuti voucher, bukan pilihan peserta
		$getvou = $this->db->get_where('master_voucher', array('voucher_code' => $kode));
		if ($getvou->num_rows() != 1){
			$return['message'] = 'Voucher tidak ditemukan.';
			return $return;
		}
		$vou = $getvou->row();
		$kat = $this->db->get_where('master_kategori', array('kategori_id' => $vou->voucher_kategori))->row();
		if (empty($kat)){
			$return['message'] = 'Kategori lomba voucher tidak ditemukan.';
			return $return;
		}

		if ($kat->kategori_kaosfinish == 'T'){
			$this->form_validation->set_rules('kaosfinish', 'Finisher Jacket', 'trim|required');
		}
		if ($kat->kategori_kategori == 'pelajar'){
			$this->form_validation->set_rules('asalsekolah', 'Asal Sekolah', 'trim|required');
		}

		if ($this->form_validation->run() == FALSE) {
			$return['message'] = validation_errors(' ',' <br>');
			return $return;
		}

		// umur harus masuk rentang kategori yang dipilih admin
		try {
			$dob     = new DateTime(post('tgllahir'));
			$today   = new DateTime('today');
			$umurnya = $dob->diff($today)->y;
		} catch (Exception $e) {
			$return['message'] = 'Format tanggal lahir tidak valid';
			return $return;
		}
		if (($umurnya < (int)$kat->kategori_umurmin) || ($umurnya > (int)$kat->kategori_umurmax)){
			$return['message'] = 'Umur Anda ('.$umurnya.' tahun) tidak sesuai kategori <b>'.$kat->kategori_name.'</b> ('.(int)$kat->kategori_umurmin.' - '.(int)$kat->kategori_umurmax.' tahun).';
			return $return;
		}

		// ===== simpan dalam 1 transaksi DB =====
		$this->db->trans_start();

		// kunci baris voucher & kategori supaya tidak bisa di-claim 2x bersamaan
		$vou = $this->db->query('SELECT * FROM master_voucher WHERE voucher_code = ? FOR UPDATE', array($kode))->row();
		if (empty($vou) || ($vou->voucher_used == 'T') || ($vou->voucher_status != '1')){
			$this->db->trans_complete();
			$return['message'] = 'Voucher ini sudah tidak tersedia.';
			return $return;
		}
		if (($vou->voucher_expired != NULL) && ($vou->voucher_expired != '') && ($vou->voucher_expired < date('Y-m-d H:i:s'))){
			$this->db->trans_complete();
			$return['message'] = 'Voucher ini sudah kadaluarsa.';
			return $return;
		}

		$kat = $this->db->query('SELECT * FROM master_kategori WHERE kategori_id = ? FOR UPDATE', array($vou->voucher_kategori))->row();
		if (empty($kat)){
			$this->db->trans_complete();
			$return['message'] = 'Kategori lomba voucher tidak ditemukan.';
			return $return;
		}

		// 1) akun login peserta SUDAH ADA (dibuat lewat registrasi biasa),
		//    jadi tidak ada master_user baru yang dibuat di sini.

		// 2) data pelari + nomor BIB sekaligus (voucher gratis, BIB langsung keluar)
		$no_bib = $kat->kategori_prefix.''.$kat->kategori_startid;

		$ins = array();
		$ins['pelari_user']        = $user_id;
		$ins['pelari_name']        = post('name');
		$ins['pelari_identitas']   = post('identitas');
		$ins['pelari_sex']         = post('sex');
		$ins['pelari_tgllahir']    = post('tgllahir');
		$ins['pelari_goldar']      = post('goldar');
		$ins['pelari_provinsi']    = post('provinsi');
		$ins['pelari_kota']        = post('city');
		$ins['pelari_telp']        = post('telp');
		$ins['pelari_alamat']      = post('alamat');
		$ins['pelari_riwayat']     = post('riwayat');
		$ins['pelari_ketriwayat']  = (post('riwayat') == 'T')? post('ketriwayat') : '';
		$ins['pelari_namadarurat'] = post('namadarurat');
		$ins['pelari_tlpdarurat']  = post('tlpdarurat');
		$ins['pelari_namabib']     = post('namabib');
		$ins['pelari_kategori']    = $kat->kategori_id;
		$ins['pelari_kaos']        = post('kaos');
		$ins['pelari_kaosfinish']  = ($kat->kategori_kaosfinish == 'T')? post('kaosfinish') : '';
		$ins['pelari_club']        = ($kat->kategori_kategori == 'pelajar')? post('asalsekolah') : '';
		$ins['pelari_bib']         = $no_bib;
		$ins['pelari_created']     = date('Y-m-d H:i:s');

		$this->db->insert('master_pelari', $ins);
		$pelari_id = $this->db->insert_id();

		// naikkan penomoran BIB kategori
		$this->db->query('UPDATE master_kategori SET kategori_startid = kategori_startid + 1 WHERE kategori_id = ?', array($kat->kategori_id));

		// 3) tandai voucher terpakai.
		//    KUOTA TIDAK DIPOTONG LAGI di sini, karena sudah dipotong oleh admin
		//    saat men-generate voucher (Adminmodel::save_voucher).
		$this->db->where('voucher_id', $vou->voucher_id);
		$this->db->update('master_voucher', array(
			'voucher_used'     => 'T',
			'voucher_pelari'   => $pelari_id,
			'voucher_user'     => $user_id,
			'voucher_useddate' => date('Y-m-d H:i:s'),
		));

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE){
			$return['message'] = 'Gagal menyimpan data pelari, silahkan coba beberapa saat lagi.';
			return $return;
		}

		// ===== QR code + email konfirmasi (di luar transaksi) =====
		$qr = $this->buat_qr($no_bib);

		$data['nama_pelari'] = post('name');
		$data['kategori']    = $kat->kategori_name;
		$data['no_bib']      = $no_bib;
		$data['qrcode']      = $qr;
		$data['email']       = $email;
		$email_html = $this->load->view('library/mail_content', $data, TRUE);

		$this->mainmodel->send_email($email, $email_html, 'Pendaftaran Voucher Berhasil');
		makeNotif('Pendaftaran Voucher Berhasil', $email_html, $user_id);

		// simpan ringkasan untuk halaman sukses, lalu lepas kode voucher dari sesi
		$this->session->set_userdata(array(
			'voucher_code'     => '',
			'voucher_kategori' => '',
			'voucher_sukses'   => array(
				'nama'     => post('name'),
				'kategori' => $kat->kategori_name,
				'bib'      => $no_bib,
				'qr'       => $qr,
				'email'    => $email,
			),
		));

		$return['status']   = TRUE;
		$return['type']     = 'success';
		$return['message']  = 'Pendaftaran berhasil. Nomor BIB Anda: <b>'.$no_bib.'</b>';
		$return['redirect'] = base_url('voucher/sukses');

		return $return;
	}

}

/* End of file Vouchermodel.php */
/* Location: ./application/models/Vouchermodel.php */
/* Location: ./application/models/Vouchermodel.php */
