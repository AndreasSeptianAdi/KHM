<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pendaftaran lari lewat VOUCHER.
 *
 * Halaman ini berada DI DALAM aplikasi (wajib login) dan memakai layout utama
 * app_index.php, jadi menu sidebar tetap tampil seperti halaman lain.
 * Akun peserta dibuat lewat alur registrasi biasa (auth/register lalu
 * auth/login) dan TIDAK diubah sama sekali.
 *
 * Titik masuknya: menu "Daftar Pelari" (page/daftar) diarahkan ke /voucher
 * ketika peserta belum punya data pelari sama sekali.
 *
 *  /voucher              -> step 1: cek keaslian voucher
 *  /voucher/kode/{KODE}  -> sama, kode terisi otomatis (buat link/QR share)
 *  /voucher?v={KODE}     -> sama, kode terisi otomatis
 *  /voucher/cek          -> ajax validasi kode
 *  /voucher/daftar       -> step 2: form data pelari (hanya jika voucher valid)
 *  /voucher/simpan       -> ajax simpan data pelari
 *  /voucher/sukses       -> step 3: konfirmasi + nomor BIB + QR code
 */
class Voucher extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('vouchermodel');
	}

	/**
	 * Bungkus view voucher ke dalam layout utama supaya sidebar tetap tampil.
	 */
	private function render($view = '', $data = array())
	{
		$data['content'] = $this->load->view('voucher/'.$view, $data, TRUE);
		$this->load->view('app_index', $data);
	}

	/**
	 * Guard 1 - wajib login. Akun dibuat lewat registrasi biasa, bukan di sini.
	 */
	private function butuh_login()
	{
		if ($this->session->userdata('logged_in') != TRUE){
			redirect('auth/login');
		}
	}

	/**
	 * Guard 2 - peserta belum boleh punya data pelari, supaya tidak dobel.
	 * userdata() bisa mengembalikan array kalau user punya banyak baris pelari
	 * (pendaftaran group), jadi diambil baris pertamanya dulu.
	 */
	private function belum_terdaftar()
	{
		$saya = userdata();
		if (is_array($saya)){ $saya = reset($saya); }
		if (!empty($saya) && !empty($saya->pelari_kategori)){
			redirect('page/daftar_lari');
		}
	}

	/**
	 * Step 1 - halaman cek keaslian voucher.
	 */
	public function index($kode = '')
	{
		$this->butuh_login();
		$this->belum_terdaftar();

		// kalau sudah terverifikasi dan belum dipakai, langsung lanjut ke form
		if ($this->session->userdata('voucher_code') != ''){
			redirect('voucher/daftar');
			return;
		}

		$prefill = ($kode != '')? $kode : get('v');
		$this->render('inc_cek', array('prefill' => $this->vouchermodel->rapikan_kode($prefill)));
	}

	/**
	 * Ajax - validasi kode voucher, simpan ke session kalau asli.
	 */
	public function cek()
	{
		$this->output->set_content_type('application/json');

		if ($this->session->userdata('logged_in') != TRUE){
			echo json_encode(array(
				'status'  => FALSE,
				'type'    => 'error',
				'message' => 'Silakan login terlebih dahulu.',
			));
			return;
		}

		$hasil = $this->vouchermodel->cek_voucher(post('kode'));

		if ($hasil['status']){
			$this->session->set_userdata(array(
				'voucher_code'     => $hasil['kode'],
				'voucher_kategori' => $hasil['kategori']->kategori_id,
			));
			$hasil['redirect'] = base_url('voucher/daftar');
		}

		echo json_encode($hasil);
	}

	/**
	 * Step 2 - form data pelari. Hanya bisa dibuka kalau voucher lolos verifikasi.
	 */
	public function daftar()
	{
		$this->butuh_login();
		$this->belum_terdaftar();

		$kode = $this->session->userdata('voucher_code');
		if ($kode == ''){
			redirect('voucher');
			return;
		}

		// verifikasi ulang tiap kali form dibuka (voucher bisa dinonaktifkan admin)
		$hasil = $this->vouchermodel->cek_voucher($kode);
		if ($hasil['status'] == FALSE){
			$this->session->set_userdata(array('voucher_code' => '', 'voucher_kategori' => ''));
			redirect('voucher');
			return;
		}

		$this->render('inc_daftar', array('voucher' => $hasil['voucher'], 'kategori' => $hasil['kategori']));
	}

	/**
	 * Ajax - simpan data pelari, tandai voucher terpakai, terbitkan nomor BIB.
	 */
	public function simpan()
	{
		$this->output->set_content_type('application/json');

		if ($this->session->userdata('logged_in') != TRUE){
			echo json_encode(array(
				'status'  => FALSE,
				'type'    => 'error',
				'message' => 'Silakan login terlebih dahulu.',
			));
			return;
		}

		$hasil = $this->vouchermodel->save_pelari_voucher();
		echo json_encode($hasil);
	}

	/**
	 * Batalkan sesi voucher yang sedang diverifikasi (tombol "Ganti Voucher").
	 */
	public function reset()
	{
		$this->session->set_userdata(array('voucher_code' => '', 'voucher_kategori' => ''));
		redirect('voucher');
	}

	/**
	 * Step 3 - halaman sukses berisi nomor BIB + QR code.
	 * Sengaja TIDAK memakai belum_terdaftar(), karena setelah sukses menyimpan
	 * peserta sudah punya data pelari dan halaman ini harus tetap bisa dibuka.
	 */
	public function sukses()
	{
		$this->butuh_login();

		$info = $this->session->userdata('voucher_sukses');
		if (empty($info)){
			redirect('page/daftar_lari');
			return;
		}

		$this->render('inc_sukses', array('info' => $info));
	}

}

/* End of file Voucher.php */
/* Location: ./application/controllers/Voucher.php */

