<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reportmodel extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function pemasukkan($value='')
	{
		if ($value=='week'){
			$this->db->where('YEAR(transaksi_date)', date('Y'));
			$this->db->where('MONTH(transaksi_date)', date('m'));
			$this->db->where('WEEK(transaksi_date)', date('W'));
		}
		$this->db->join('master_user', 'user_id = tiket_user', 'left');
    $this->db->join('master_pelari', 'user_id = pelari_user', 'left');
    $this->db->join('master_transaksi', 'transaksi_order_id = tiket_order_id', 'left');
    $this->db->where('transaksi_status', 'success');
    $a = $this->db->get(['master_tiket']);
    $Total = 0;
    foreach ($a->result() as $data) {
    	$Total += $data->tiket_price;
    }
		return $Total;
	}

	public function kategori($value='')
	{
		return $this->db->get_where('master_kategori',['kategori_status' => '1'])->num_rows();
	}

	public function pelari($value='')
	{
		if ($value=='week'){
			$this->db->where('YEAR(pelari_created)', date('Y'));
			$this->db->where('MONTH(pelari_created)', date('m'));
			$this->db->where('WEEK(pelari_created)', date('W'));
		}
		return $this->db->get('master_pelari')->num_rows();
	}

	public function group($value='')
	{
		if ($value=='week'){
			$this->db->where('YEAR(group_created)', date('Y'));
			$this->db->where('MONTH(group_created)', date('m'));
			$this->db->where('WEEK(group_created)', date('W'));
		}
		$amount = $this->db->get('master_group')->num_rows();

		return $amount;
	}

	public function user($value='')
	{
		if ($value=='week'){
			$this->db->where('YEAR(user_created)', date('Y'));
			$this->db->where('MONTH(user_created)', date('m'));
			$this->db->where('WEEK(user_created)', date('W'));
		}
		$this->db->where('user_is', 'user');
		$amount = $this->db->get('master_user')->num_rows();

		return $amount;
	}

}

/* End of file  */
/* Location: ./application/models/ */