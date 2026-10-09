<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quetablemodel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function opt($name, $default = '')
	{
		$this->db->reset_query();
		$get = $this->db->get_where('master_options', ['option_name' => $name]);
		if ($get->num_rows() == 1) {
			return $get->row()->option_value;
		}
		if ($default !== '') {
			$this->db->insert('master_options', ['option_name' => $name, 'option_value' => $default]);
		}
		return $default;
	}

	public function queue_enabled()
	{
		return $this->opt('queue_enabled', '1') == '1';
	}

	public function queue_max()
	{
		return (int) $this->opt('queue_max', '10');
	}

	public function active_grace()
	{
		return (int) $this->opt('queue_active_grace', '90');
	}

	public function ensure_table()
	{
		if ($this->db->table_exists('queue_tokens')) {
			return true;
		}
		if (!$this->db->table_exists('master_options')) {
			return false;
		}
		$this->load->dbforge();
		$this->dbforge->add_field([
			'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
			'token' => ['type' => 'VARCHAR', 'constraint' => 64],
			'status' => ['type' => 'VARCHAR', 'constraint' => 16, 'default' => 'waiting'],
			'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true, 'default' => null],
			'ip' => ['type' => 'VARCHAR', 'constraint' => 64, 'null' => true],
			'created_at' => ['type' => 'DATETIME', 'null' => true],
			'updated_at' => ['type' => 'DATETIME', 'null' => true],
			'expires_at' => ['type' => 'DATETIME', 'null' => true],
		]);
		$this->dbforge->add_key('id', true);
		$this->dbforge->add_key('token');
		$this->dbforge->add_key('status');
		return $this->dbforge->create_table('queue_tokens', true);
	}

	public function prune()
	{
		if (!$this->ensure_table()) {
			return;
		}
		$this->db->reset_query();
		$this->db->where('expires_at <', date('Y-m-d H:i:s'));
		$this->db->delete('queue_tokens');
		// Bersih-bersih: satu IP hanya boleh punya 1 token aktif/waiting.
		// Sisa token ganda (akibat race sebelum lock) dihapus, sisakan yg terbaru.
		$this->db->reset_query();
		$this->db->select('ip, MAX(id) AS keep_id, COUNT(*) AS c');
		$this->db->from('queue_tokens');
		$this->db->where('created_at >=', date('Y-m-d H:i:s', time() - 86400));
		$this->db->group_by('ip');
		$this->db->having('c >', 1);
		$dupes = $this->db->get()->result();
		foreach ($dupes as $d) {
			$this->db->reset_query();
			$this->db->where('ip', $d->ip);
			$this->db->where('id !=', $d->keep_id);
			$this->db->where('created_at >=', date('Y-m-d H:i:s', time() - 86400));
			$this->db->delete('queue_tokens');
		}
	}

	public function active_count()
	{
		$this->prune();
		$this->db->reset_query();
		$this->db->where('status', 'active');
		return $this->db->count_all_results('queue_tokens');
	}

	public function my_token()
	{
		$this->prune();
		$this->db->reset_query();
		$token = $this->input->cookie('queue_token', true);
		if ($token) {
			$this->db->reset_query();
			$row = $this->db->get_where('queue_tokens', ['token' => $token])->row();
			if ($row) {
				$_COOKIE['queue_token'] = $token;
				return $row;
			}
		}
		// Satu browser = satu token: pakai lock file per-IP agar request
		// paralel (halaman + polling AJAX) tidak bikin token ganda.
		$ip = (string) $this->input->ip_address();
		$lock_dir = rtrim(sys_get_temp_dir(), '/\\') . '/khm_queue';
		if (!is_dir($lock_dir)) {
			@mkdir($lock_dir, 0777, true);
		}
		$lock_fp = null;
		$lock_file = $lock_dir . '/ip_' . preg_replace('/[^a-zA-Z0-9_.-]/', '_', $ip) . '.lock';
		$lock_fp = @fopen($lock_file, 'c');
		if ($lock_fp) {
			@flock($lock_fp, LOCK_EX);
		}
		// cek ulang setelah dapat lock (mungkin request lain sudah bikin)
		$this->db->reset_query();
		$this->db->where('ip', $ip);
		$this->db->where('created_at >=', date('Y-m-d H:i:s', time() - 86400));
		$this->db->order_by('id', 'desc');
		$this->db->limit(1);
		$existing = $this->db->get('queue_tokens')->row();
		if ($existing) {
			$token = $existing->token;
			$this->input->set_cookie('queue_token', $token, 86400);
			$_COOKIE['queue_token'] = $token;
			if ($lock_fp) {
				@flock($lock_fp, LOCK_UN);
				@fclose($lock_fp);
			}
			return $existing;
		}
		$token = bin2hex(random_bytes(16));
		$now = date('Y-m-d H:i:s');
		$this->db->reset_query();
		$this->db->insert('queue_tokens', [
			'token' => $token,
			'status' => 'waiting',
			'user_id' => null,
			'ip' => $ip,
			'created_at' => $now,
			'updated_at' => $now,
			'expires_at' => date('Y-m-d H:i:s', time() + 86400),
		]);
		$this->input->set_cookie('queue_token', $token, 86400);
		$_COOKIE['queue_token'] = $token;
		$this->db->reset_query();
		$row = $this->db->get_where('queue_tokens', ['token' => $token])->row();
		if ($lock_fp) {
			@flock($lock_fp, LOCK_UN);
			@fclose($lock_fp);
		}
		return $row;
	}

	public function position($token)
	{
		$this->db->reset_query();
		$row = $this->db->get_where('queue_tokens', ['token' => $token])->row();
		if (!$row) {
			return 0;
		}
		if ($row->status == 'active') {
			return 0;
		}
		$this->db->reset_query();
		$this->db->where('status', 'waiting');
		$this->db->where('id <=', $row->id);
		$ahead = $this->db->count_all_results('queue_tokens');
		return max(1, (int) $ahead);
	}

	/* Berapa slot kosong tersedia (tanpa efek samping) */
	public function free_slots()
	{
		$this->prune();
		$this->db->reset_query();
		$this->db->where('status', 'active');
		$active = $this->db->count_all_results('queue_tokens');
		return max(0, $this->queue_max() - $active);
	}

	public function try_activate($token)
	{
		$this->prune();
		$this->db->reset_query();
		$row = $this->db->get_where('queue_tokens', ['token' => $token])->row();
		if (!$row) {
			return false;
		}
		if ($row->status == 'active') {
			$this->touch($row->id);
			return true;
		}
		if ($row->status != 'waiting') {
			return false;
		}
		// FIFO: hanya yang paling depan yang boleh naik saat ada slot kosong
		$this->db->reset_query();
		$this->db->where('status', 'waiting');
		$this->db->where('id <', $row->id);
		$ahead = $this->db->count_all_results('queue_tokens');
		if ($ahead > 0) {
			return false; // bukan giliran: masih ada yang lebih dulu
		}
		if ($this->free_slots() < 1) {
			return false; // slot penuh
		}
		$grace = (int) $this->opt('queue_active_grace', '90');
		$this->db->reset_query();
		$this->db->where('id', $row->id);
		$this->db->update('queue_tokens', [
			'status' => 'active',
			'updated_at' => date('Y-m-d H:i:s'),
			'expires_at' => date('Y-m-d H:i:s', time() + $grace),
		]);
		return true;
	}

	public function touch($id)
	{
		$grace = $this->active_grace();
		$this->db->reset_query();
		$this->db->where('id', $id);
		$this->db->update('queue_tokens', [
			'updated_at' => date('Y-m-d H:i:s'),
			'expires_at' => date('Y-m-d H:i:s', time() + $grace),
		]);
	}

	public function heartbeat($token)
	{
		$this->db->reset_query();
		$row = $this->db->get_where('queue_tokens', ['token' => $token])->row();
		if ($row && $row->status == 'active') {
			$this->touch($row->id);
			return true;
		}
		return false;
	}

	public function bind_user($token, $user_id)
	{
		$grace = $this->active_grace();
		$this->db->reset_query();
		$this->db->where('token', $token);
		$this->db->update('queue_tokens', [
			'user_id' => $user_id,
			'updated_at' => date('Y-m-d H:i:s'),
			'expires_at' => date('Y-m-d H:i:s', time() + $grace),
		]);
	}

	public function release($token)
	{
		$this->db->reset_query();
		$this->db->where('token', $token);
		$this->db->delete('queue_tokens');
		$this->input->set_cookie('queue_token', '', -3600);
	}

	public function status($token)
	{
		$this->prune();
		$this->db->reset_query();
		$row = $this->db->get_where('queue_tokens', ['token' => $token])->row();
		if (!$row) {
			$row = $this->my_token();
		}
		$active = $this->active_count();
		$max = $this->queue_max();
		if ($row->status == 'active') {
			$this->touch($row->id);
			return ['status' => 'active', 'position' => 0, 'active' => $active, 'max' => $max, 'can_login' => true, 'token' => $row->token];
		}
		if ($this->try_activate($row->token)) {
			return ['status' => 'active', 'position' => 0, 'active' => $this->active_count(), 'max' => $max, 'can_login' => true, 'token' => $row->token];
		}
		return ['status' => 'waiting', 'position' => $this->position($row->token), 'active' => $active, 'max' => $max, 'can_login' => false, 'token' => $row->token];
	}
}

/* End of file  */
/* Location: ./application/models/ */
