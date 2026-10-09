<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Queue extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('quetablemodel', 'queue');
	}

	protected function json($data)
	{
		$this->output->set_content_type('application/json');
		echo json_encode($data);
	}

	/* Status antrean browser ini (polling) */
	public function status()
	{
		if (!$this->queue->queue_enabled()) {
			return $this->json(['enabled' => false, 'status' => 'active', 'position' => 0, 'can_login' => true, 'active' => 0, 'max' => $this->queue->queue_max()]);
		}
		$me = $this->queue->my_token();
		$st = $this->queue->status($me->token);
		$st['enabled'] = true;
		// simpan token di cookie agar konsisten
		$this->input->set_cookie('queue_token', $st['token'], 86400);
		return $this->json($st);
	}

	/* Heartbeat: perpanjang slot aktif */
	public function ping()
	{
		$token = $this->input->cookie('queue_token', true);
		$ok = $token ? $this->queue->heartbeat($token) : false;
		return $this->json(['ok' => $ok]);
	}

	/* Lepas slot (dipanggil saat logout / sebelum login ulang) */
	public function leave()
	{
		$token = $this->input->cookie('queue_token', true);
		if ($token) {
			$this->queue->release($token);
		}
		return $this->json(['ok' => true]);
	}
}

/* End of file  */
/* Location: ./application/controllers/ */
