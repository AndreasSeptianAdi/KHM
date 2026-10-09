<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usertablemodel extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	private function _get_datatables_query($table = ['master_member']){
		$coloumn = [];

		foreach ($table as $key => $value) :

			$coloumn = array_merge($coloumn, $this->db->list_fields($value));

		endforeach;

    $this->db->from($table[0]);
    $i = 0;
    foreach ($coloumn as $item){
      if($_GET['search']['value']){
        if($i===0){
            $this->db->group_start(); 
            $this->db->like($item, $_GET['search']['value']);
        }else{
            $this->db->or_like($item, $_GET['search']['value']);
        }
        if(count($coloumn) - 1 == $i) 
            $this->db->group_end(); 
    	}
      $i++;
    }
    if(isset($_GET['order'])) {
      $this->db->order_by($coloumn[$_GET['order']['0']['column']], $_GET['order']['0']['dir']);
    }else if(isset($this->order)){
      $order = $this->order;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }

  function count_filtered_data($table='')
  {	
    $this->_get_datatables_query(['master_'.$table]);
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_all_data($table='')
  {
    $this->db->from(['master_'.$table]);
    return $this->db->count_all_results();
  }

  function get_list_pelari_group($groupid = '')
  {
    switch ($_GET['order'][0]['column']) {
      case '1':
        $ordering = 'pelari_name';
        break;
      case '2':
        $ordering = 'user_email';
        break;
      case '3':
        $ordering = 'kategori_name';
        break;
      case '4':
        $ordering = 'user_created';
        break;
      default:
        $ordering = 'pelari_id';
        break;
    }
    $this->db->order_by($ordering, $_GET['order'][0]['dir']);
    $this->db->where('pelari_group', $groupid);
    $this->db->join('master_user', 'user_id = pelari_user', 'left');
    $this->db->join('master_kategori', 'kategori_id = pelari_kategori', 'left');
    $this->_get_datatables_query(['master_pelari','master_user']);
    if($_GET['length'] != -1)
    $this->db->limit($_GET['length'], $_GET['start']);
    $query = $this->db->get();
    return $query->result();
  }

  function count_filtered_pelari_group($groupid = '')
  { 
    $this->db->where('pelari_group', $groupid);
    $this->_get_datatables_query(['master_pelari']);
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_all_pelari_group($groupid = '')
  {
    $this->db->where('pelari_group', $groupid);
    $this->db->from(['master_pelari']);
    return $this->db->count_all_results();
  }
}