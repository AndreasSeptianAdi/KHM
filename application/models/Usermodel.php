<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usermodel extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function ubah_kategori_lari($value='')
	{
		$return['status'] = true;
		$return['type'] = 'success';
		$return['message'] = 'Silahkan Pilih Kategori Lari Lainnya';
		$userdata = userdata();
		$this->db->where('pelari_id', $userdata->pelari_id);
		$this->db->update('master_pelari', ['pelari_kategori' => null]);
		return $return;
	}

	public function cek_umur($value='')
	{
		$return['status'] = true;
		$return['type'] = 'error';
		$return['message'] = 'Umur Anda Belum Mencukupi';
		
		$dob = new DateTime(post('tgl'));
    $today   = new DateTime('today');
    $umurnya = $dob->diff($today)->y;

		$this->db->where('kategori_status', '1');
		$this->db->where('kategori_kuota > ', '0');
		$this->db->where('kategori_id >= ', '4');
		$this->db->where('kategori_umurmin <=', $umurnya);
		$this->db->where('kategori_umurmax >=', $umurnya);
		$this->db->where('DATE(kategori_dateexp) >=', date('Y-m-d'));
		$get = $this->db->get('master_kategori');

		if ($get->num_rows() < 1){
			$return['status'] = false;
		}
	
		if ($return['status']){
			$return['type'] = 'success';
			$return['message'] = '';
			$button = '';

			foreach ($get->result() as $kat) {
				$button .= '<button type="submit" name="cat" value="'.$kat->kategori_id.'" class="btn btn-danger btn-lg">';
				$button .= $kat->kategori_name;
				$button .= '</button> ';
			}
			$return['button'] = $button;
		}
	
		return $return;
	}

	public function ubah_nama_group($value='')
	{
		$return['status'] = true;
		$data = json_decode(file_get_contents('php://input'),1);
		$baru = $data['nama_baru'];
		$lama = $data['nama_lama'];

		$this->db->where('group_name', $baru);
		$cek_group = $this->db->get('master_group');
		if ($baru != $lama){
			if ($cek_group->num_rows() > 0){
				$return['status'] = false;
				$return['type'] = 'error';
				$return['message'] = 'Nama Sudah digunakan oleh Group pelari Lain';	
			}else{
				$return['type'] = 'success';
				$return['message'] = 'Nama Group Diubah';	
				$ubh['group_name'] = $baru;
				$this->db->where('group_name', $lama);
				$this->db->update('master_group', $ubh);
			}
		}else{
			$return['status'] = true;
			$return['type'] = 'warning';
			$return['message'] = 'Tidak Terdapat Perubahan Nama';	
		}

		return $return;
	}

	public function do_login()
	{
		$return['status'] = true;
		$return['type'] = 'error';
		$return['message'] = '';

		// === Queue gate: tolak login jika slot penuh / belum giliran ===
		$this->load->model('quetablemodel', 'queue');
		if ($this->queue->queue_enabled()) {
			$token = $this->input->cookie('queue_token', true);
			$allowed = false;
			if ($token) {
				$st = $this->queue->status($token);
				$allowed = !empty($st['can_login']);
			}
			if (!$allowed) {
				$return['status'] = false;
				$return['type'] = 'warning';
				$return['heading'] = 'Ruang Antrean Penuh';
				$return['message'] = 'Slot login sedang penuh (maks ' . $this->queue->queue_max() . ' pengguna). Tetap di halaman login, giliran Anda akan dibuka otomatis.';
				$return['queue_wait'] = true;
				return $return;
			}
		}

		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$return['status'] = false;
			$return['message'] = validation_errors(' ',' <br>');
		}

		$this->db->where('user_email', post('username'));
		$this->db->where('user_password', md5(post('password')) );
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
				'user_id'		=> $data->user_id,
				'user_email'		=> $data->user_email,
				'user_join'		=> date('d F Y', strtotime($data->user_created)),
				'logged_date'	=> date('Y-m-d H:i:s'),
			);

			$object['user_last_login'] = date('Y-m-d H:i:s');
			$this->db->where('user_id', $data->user_id);
			$this->db->update('master_user', $object);
			$this->session->set_userdata($session);

			// ikat slot antrean ke user ini
			$__qt = $this->input->cookie('queue_token', true);
			if ($__qt) {
				$this->queue->bind_user($__qt, $data->user_id);
			}

			// cek redirect
			if (userdata()->pelari_group != null){
				$redirect = 'page/daftar';
			}else{
				$redirect = 'page/daftar';
			}

			$return['type'] = 'success';
			$return['redirect'] = $redirect;
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

	public function do_register()
	{
		$return['status'] = true;
		$return['type'] = 'error';
		$return['message'] = '';
		
		$this->form_validation->set_rules('email', 'E-Mail', 'trim|required|valid_email|is_unique[master_user.user_email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('repassword', 'Ulangi Password', 'trim|required|matches[password]');
		if ($this->form_validation->run() == FALSE) {
			$return['status'] = false;
			$return['message'] = validation_errors(' ', ' <br>');
		}
	
		if ($return['status']){
			$member['user_password'] = md5(post('password'));
			$member['user_email'] = post('email');
			$this->db->insert('master_user', $member);
			$return['type'] = 'success';
			$return['message'] = 'Pendaftaran Sukses Silahkan Login';
		}
	
		return $return;
	}

	public function do_forgot()
	{
		$return['status'] = true;
		$return['type'] = 'error';
		$return['message'] = 'Failed To Send';
		
		$this->db->where('user_email', post('email'));
		$cek = $this->db->get('master_user');
		if ($cek->num_rows() == 0){
			$return['status'] = false;
			$return['message'] = 'User Tidak Kami Temukan';
		}
	
		if ($return['status']){
			$data = $cek->row();
			$code = random_int(100000, 999999);
			$object['user_forgot'] = $code;
			$this->db->where('user_id', $data->user_id);
			$this->db->update('master_user', $object);

			$this->load->model('mainmodel');
			$email = '
				<h2>Permohonan Reset Password</h2>
				<br>
				Hi <br>

				Kami baru mendapat pemberitahuan tentang reset password Anda, <br>
				Silahkan masukkan kode <br><br><center><h2><b>'.$code.'</b></h2></center> <br><br>

				Kami tidak akan mengubah data Password Anda apabila Code yang Anda masukkan salah, atau mengabaikan email ini.

				<br>
				Terima Kasih
				';
			$this->mainmodel->send_email($data->user_email,$email);
			$return['type'] = 'success';
			$return['message'] = 'Silahkan Cek kode pada email Anda';
		}
	
		return $return;
	}

	public function do_reset_pass()
	{
		$return['status'] = true;
		$return['type'] = 'error';
		$return['message'] = '';

		$this->db->limit(1);
		$this->db->order_by('user_last_login', 'desc');
		$this->db->where('user_forgot', post('code'));
		$get = $this->db->get('master_user');
		if ($get->num_rows() == 0){
			$return['status'] = false;
			$return['message'] = 'Code Salah';
		}

		$this->form_validation->set_rules('code', 'Code', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('repassword', 'Ulangi Password', 'trim|required|matches[password]');
		if ($this->form_validation->run() == FALSE) {
			$return['status'] = false;
			$return['message'] = validation_errors(' ', ' <br>');
		}
	
		if ($return['status']){
			$data = $get->row();
			$object['user_password'] = md5(post('password'));
			$object['user_forgot'] = '';
			$this->db->where('user_id', $data->user_id);
			$this->db->update('master_user', $object);
			$return['type'] = 'success';
			$return['message'] = 'Password Sukses Diubah';
		}
	
		return $return;
	}

	public function send_email()
	{
		$return['status'] = true;
		$return['type'] = 'error';
		$return['message'] = '';
		$return['csrf_data'] = $this->security->get_csrf_hash();
		
		$this->form_validation->set_rules('name', 'Nama', 'trim|required');
		$this->form_validation->set_rules('email', 'E-Mail', 'trim|required');
		$this->form_validation->set_rules('phone_number', 'Nomor Telf', 'trim|required');
		$this->form_validation->set_rules('msg_subject', 'Subjek Pesan', 'trim|required');
		$this->form_validation->set_rules('message', 'Pesan', 'trim|required');
		$this->form_validation->set_rules('checkme', 'Aggrement', 'trim|required');

		if ($this->form_validation->run() == false) {
			$return['status'] = false;
			$return['message'] = validation_errors(' ', ' <br>');
		}
	
		if ($return['status']){

			$object['message_from'] = post('name');
			$object['message_email'] = post('email');
			$object['message_subject'] = post('msg_subject');
			$object['message_content'] = post('message');
			$this->db->insert('tb_message', $object);

			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
			$config['protocol	'] = 'mail';
			$this->load->library('email', $config);
			$this->email->from(post('email'), post('name'));
			$this->email->to(CNF_EMAIL1.', '.CNF_EMAIL2);
			$this->email->cc('tpelajar.official@gmail.com');
			$this->email->subject(post('name').' - '.post('msg_subject'));
			$this->email->message(post('message'));
			$this->email->send();

			makeNotif('Anda Mendapatkan E-Mail Baru dari '.post('name'));
			$return['type'] = 'success';
			$return['message'] = 'Pesan Terkirim';
		}
	
		return $return;
	}

	public function logoff(){
	
		$this->session->sess_destroy();
		redirect('',301);
	}

	public function hapus_pelari()
	{
		$return['status'] = true;
		$return['type'] = 'error';
		$return['message'] = '';
		$tabel = post('from');

		$this->db->where('pelari_id', post('id'));
		$cek = $this->db->get('master_pelari');
		if ($cek->num_rows() == 0){
			$this->logoff();
		}else{
			if ($cek->row()->pelari_group != userdata()->pelari_group){
				$this->logoff();
			}
		}
		
		if ($return['status']){
			$del = $this->db->get_where('master_pelari', ['pelari_id' => post('id')])->row();
			$this->db->where('pelari_id', post('id'));
			$this->db->delete('master_pelari');
			// Kembalikan kuota HANYA jika belum dapat BIB (kuota dipotong saat register).
			if (!empty($del) && empty($del->pelari_bib) && !empty($del->pelari_kategori)){
				$this->db->query('UPDATE master_kategori SET kategori_kuota = kategori_kuota + 1 WHERE kategori_id = ?', [$del->pelari_kategori]);
			}
			$return['type'] = 'success';
			$return['message'] = 'Terhapus';
		}
	
		return $return;
	}

	public function hapus_group()
	{
		$return['status'] = true;
		$return['type'] = 'error';
		$return['message'] = '';
		
		if ($return['status']){
			$this->db->where('group_user', userid());
			$this->db->delete('master_group');
			$return['type'] = 'success';
			$return['message'] = 'Group Terhapus';
		}
	
		return $return;
	}

	public function save_user()
	{
		$return['status'] = true;
		$return['type'] = 'error';
		$return['message'] = '';
		$return['csrf_data'] = $this->security->get_csrf_hash();
	
		$this->form_validation->set_rules('old_pass', 'Password Lama', 'trim|required');
		$this->form_validation->set_rules('new_pass', 'Password Baru', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('re_pass', 'Ulangi Pasword', 'trim|required|min_length[6]|matches[new_pass]');

		if ($this->form_validation->run() == false){
			$return['status'] = false;
			$return['message'] = validation_errors(' ', ' <br>');
		}

		$userdata = userdata();
		if (md5(post('old_pass')) != $userdata->user_password){
			$return['status'] = false;
			$return['message'] = 'Password lama Anda salah';	
		}
	
		if ($return['status']){
			$this->db->where('user_id', userid());
			$object['user_password'] = md5(post('new_pass'));
			$this->db->update('master_user', $object);
			$return['type'] = 'success';
			$return['message'] = 'Password Tersimpan';
			makeNotif('Perubahan Password',$userdata->user_email.' Melakukan perubahan Password',userid());
		}
	
		return $return;
	}

	public function save_pelari($value='')
	{
		$return['status'] = true;
		$return['type'] = 'error';
		$return['message'] = 'Gagal Menyimpan';
		$return['group_add'] = false;
		
		if ((post('group_id') != '') && (post('add_group') == 'true')) {
			if (post('ispribadi') == 'false') {
			    if (!post('edit_member')){
				$this->form_validation->set_rules('email', 'E-Mail', 'trim|required|valid_email|is_unique[master_user.user_email]');
				$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
			}}
		}

		$this->form_validation->set_rules('name', 'Nama Lengkap', 'trim|required');
		$get_in = '';
		if (post('id') != ''){
			$this->db->where('pelari_id', post('id'));
			$a = $this->db->get('master_pelari')->row();
			if ($a->pelari_identitas != post('identitas')){
				$get_in = '|is_unique[master_pelari.pelari_identitas]';
			}
		}
		$this->form_validation->set_rules('identitas', 'No Identitas', 'trim|required'.$get_in);
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

		if (post('kategori') != ''){
			$exp = explode('|', post('kategori'));
			if ($exp[1] == 'T'){
				$this->form_validation->set_rules('kaosfinish', 'Finnish Tee', 'trim|required');
			}
			if ($exp[2] == 'pelajar'){
				$this->form_validation->set_rules('asalsekolah', 'Asal Sekolah', 'trim|required');
			}

			$this->db->where('kategori_id', $exp[0]);
			$cek = $this->db->get('master_kategori');
			if ($cek->row()->kategori_kuota < 1){
				$return['status'] = false;
				$return['message'] = 'Kuota Penuh, silahkan pilih Kategori lari lainnya!';
			}
		}


		if ($this->form_validation->run() == FALSE) {
			$return['status'] = false;
			$return['message'] = validation_errors(' ',' <br>');
		}
	
		if ($return['status']){

			$group = $this->db->get_where('master_group', ['group_user' => post('userid')]);
			if ($group->num_rows() != 0){
				$ins['pelari_group'] = $group->row()->group_id;
				$return['group_add'] = true;
			}

			if ((post('group_id') != '') && (post('add_group') == 'true')) {
				$usr['user_email'] =	post('email');
				$usr['user_password'] =	md5(post('password'));
				$this->db->insert('master_user', $usr);
				$ins['pelari_user'] =	$this->db->insert_id();
			}else{
				if (post('email' != '')){
					$usr2['user_email'] =	post('email');
					$usr2['user_password'] =	md5(post('password'));
					$this->db->where('user_id', post('userid'));
					$this->db->update('master_user', $usr2);
				}
				$return['group_add'] = true;
				$ins['pelari_user'] =	post('userid');
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
				$ins['pelari_kaosfinish'] =	post('kaosfinish');
			}else{
				$ins['pelari_kaosfinish'] =	'';
			}
			if ($exp[2] == 'pelajar'){
				$ins['pelari_club'] =	post('asalsekolah');
			}else{
				$ins['pelari_club'] =	'';
			}

			$new_kategori_id = (int)$exp[0];
			if (post('id') != ''){
				$old_pelari = $this->db->get_where('master_pelari', ['pelari_id' => post('id')])->row();
				$old_kategori_id = $old_pelari ? (int)$old_pelari->pelari_kategori : null;
				$this->db->where('pelari_id', post('id'));
				$this->db->update('master_pelari', $ins);
				// Edit data: JANGAN sentuh startid. Hanya sesuaikan kuota jika ganti kategori.
				if ($old_kategori_id !== $new_kategori_id){
					if (!empty($old_kategori_id)){
						$this->db->query('UPDATE master_kategori SET kategori_kuota = kategori_kuota + 1 WHERE kategori_id = ?', [$old_kategori_id]);
					}
					$this->db->query('UPDATE master_kategori SET kategori_kuota = kategori_kuota - 1 WHERE kategori_id = ? AND kategori_kuota > 0', [$new_kategori_id]);
				}
			}else{
				$this->db->insert('master_pelari', $ins);
				// Register baru: reservasi kuota saja. Nomor BIB (kategori_startid) HANYA
				// dialokasikan saat pembayaran sukses (give_bib) agar tidak loncat.
				$this->db->query('UPDATE master_kategori SET kategori_kuota = kategori_kuota - 1 WHERE kategori_id = ? AND kategori_kuota > 0', [$new_kategori_id]);
			}

			$return['type'] = 'success';
			$return['message'] = 'Data Tersimpan';
		}
	
		return $return;
	}

	public function save_group_name($value='')
	{
		$return['status'] = true;
		$return['type'] = 'error';
		$return['message'] = 'Gagal Menyimpan';
		
		$this->form_validation->set_rules('groupname', 'Nama Group', 'trim|required|is_unique[master_group.group_name]');

		if ($this->form_validation->run() == FALSE) {
			$return['status'] = false;
			$return['message'] = validation_errors(' ',' <br>');
		}
	
		if ($return['status']){
			$ins['group_name'] = post('groupname');
			$ins['group_user'] = userid();
			$this->db->insert('master_group', $ins);

			$return['type'] = 'success';
			$return['message'] = 'Group Terbentuk';
		}
	
		return $return;
	}
	
}

/* End of file  */
/* Location: ./application/models/ */