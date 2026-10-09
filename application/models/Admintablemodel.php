<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admintablemodel extends CI_Model {

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

  public function count_all_data($table='',$where='')
  {
    if ($where != '') {
      $this->db->where($where);
    }
    $this->db->from(['master_'.$table]);
    return $this->db->count_all_results();
  }

  function get_kategori()
  {
  	switch ($_GET['order'][0]['column']) {
  		case '1':
  			$ordering = 'kategori_status';
  			break;
  		case '2':
  			$ordering = 'kategori_kategori';
  			break;
  		case '3':
  			$ordering = 'kategori_name';
  			break;
  		case '4':
  			$ordering = 'kategori_priceearly';
  			break;
  		case '5':
  			$ordering = 'kategori_price';
  			break;
  		case '6':
  			$ordering = 'kategori_kuota';
  			break;
  		default:
  			$ordering = 'kategori_id';
  			break;
  	}
  	$this->db->order_by($ordering, $_GET['order'][0]['dir']);
    $this->_get_datatables_query(['master_kategori']);
    if($_GET['length'] != -1)
    $this->db->limit($_GET['length'], $_GET['start']);
    $query = $this->db->get();
    return $query->result();
  }
  
  function get_user()
  {
  	switch ($_GET['order'][0]['column']) {
  		case '1':
  			$ordering = 'user_status';
  			break;
  		case '2':
  			$ordering = 'user_email';
  			break;
  		case '3':
  			$ordering = 'user_created';
  			break;
  		default:
  			$ordering = 'user_id';
  			break;
  	}
  	$this->db->order_by($ordering, $_GET['order'][0]['dir']);
    $this->_get_datatables_query(['master_user']);
    if($_GET['length'] != -1)
    $this->db->limit($_GET['length'], $_GET['start']);
    $query = $this->db->get();
    return $query->result();
  }
  ////////////////////////////////////////
  
  function get_group()
  {
  	switch ($_GET['order'][0]['column']) {
  		case '1':
  			$ordering = 'group_name';
  			break;
  		case '2':
  			$ordering = 'user_email';
  			break;
  		case '4':
  			$ordering = 'group_created';
  			break;
  		default:
  			$ordering = 'group_id';
  			break;
  	}
  	$this->db->join('master_user', 'user_id = group_user', 'left');
  	$this->db->order_by($ordering, $_GET['order'][0]['dir']);
    $this->_get_datatables_query(['master_group','master_user']);
    if($_GET['length'] != -1)
    $this->db->limit($_GET['length'], $_GET['start']);
    $query = $this->db->get();
    return $query->result();
  }
  ////////////////////////////////////////
  
  function get_list_pelari($group='')
  {
  	switch ($_GET['order'][0]['column']) {
  		case '1':
  			$ordering = 'pelari_name';
  			break;
  		case '2':
  			$ordering = 'city_name';
  			break;
  		case '4':
  			$ordering = 'user_email';
  			break;
  		default:
  			$ordering = 'pelari_id';
  			break;
  	}
  	$this->db->join('master_user', 'user_id = pelari_user', 'left');
  	$this->db->join('master_kategori', 'kategori_id = pelari_kategori', 'left');
  	$this->db->join('master_city', 'pelari_kota = city_id', 'left');
    $this->db->where('pelari_group', $group);
  	$this->db->order_by($ordering, $_GET['order'][0]['dir']);
    $this->_get_datatables_query(['master_pelari','master_city','master_user','master_kategori']);
    if($_GET['length'] != -1)
    $this->db->limit($_GET['length'], $_GET['start']);
    $query = $this->db->get();
    return $query->result();
  }

  function count_filtered_list_pelari($group='')
  { 
    $this->db->where('pelari_group', $group);
    $this->_get_datatables_query(['master_pelari']);
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_all_list_pelari($group='')
  {
    $this->db->where('pelari_group', $group);
    $this->db->from(['master_pelari']);
    return $this->db->count_all_results();
  }
  ////////////////////////////////////////
  
  function get_pelari($kat = '',$ready='')
  {
  	switch ($_GET['order'][0]['column']) {
  		case '2':
  			$ordering = 'pelari_club';
  			break;
  		case '2':
  			$ordering = 'pelari_name';
  			break;
  		case '3':
  			$ordering = 'kategori_name';
  			break;
  		case '4':
  			$ordering = 'user_email';
  			break;
  		case '5':
  			$ordering = 'pelari_bib';
  			break;
  		case '6':
  			$ordering = 'pelari_created';
  			break;
  		default:
  			$ordering = 'pelari_id';
  			break;
  	}
    if ($kat!=''){
      $this->db->where('pelari_kategori', $kat);
    }
    if ($ready != ''){
      if ($ready == 'T'){
        $this->db->where('pelari_bib !=', '');
      }else{
        $this->db->where('pelari_bib', null);
      }
    }
  	$this->db->join('master_user', 'user_id = pelari_user', 'left');
  	$this->db->join('master_city', 'pelari_kota = city_id', 'left');
  	$this->db->join('master_group', 'group_id = pelari_group', 'left');
  	$this->db->join('master_kategori', 'kategori_id = pelari_kategori', 'left');
  	$this->db->order_by($ordering, $_GET['order'][0]['dir']);
    $this->_get_datatables_query(['master_pelari','master_city','master_user','master_group','master_kategori']);
    if($_GET['length'] != -1)
    $this->db->limit($_GET['length'], $_GET['start']);
    $query = $this->db->get();
    return $query->result();
  }
  ////////////////////////////////////////
  
  function count_all_pelari($kat = '',$ready='')
  { 
    if ($kat!=''){
      $this->db->where('pelari_kategori', $kat);
    }
    
    if ($ready != ''){
      if ($ready == 'T'){
        $this->db->where('pelari_bib !=', '');
      }else{
        $this->db->where('pelari_bib', null);
      }
    }
    
    $this->db->join('master_user', 'user_id = pelari_user', 'left');
    $this->db->join('master_city', 'pelari_kota = city_id', 'left');
    $this->db->join('master_group', 'group_id = pelari_group', 'left');
    $this->db->join('master_kategori', 'kategori_id = pelari_kategori', 'left');
    
    $this->_get_datatables_query(['master_pelari','master_city','master_user','master_group','master_kategori']);
    
    $query = $this->db->get();
    return $query->num_rows();
  }

  ////////////////////////////////////////
  
  function get_pelari_kota($kat = '',$kota='')
  {
    switch ($_GET['order'][0]['column']) {
      case '1':
        $ordering = 'pelari_name';
        break;
      case '2':
        $ordering = 'user_email';
        break;
      case '3':
        $ordering = 'pelari_telp';
        break;
      case '4':
        $ordering = 'kategori_id';
        break;
      case '5':
        $ordering = 'pelari_bib';
        break;
      case '6':
        $ordering = 'pelari_sex';
        break;
      case '7':
        $ordering = 'pelari_created';
        break;
      case '8':
        $ordering = 'provinsi_nama';
        break;
      case '9':
        $ordering = 'city_name';
        break;
      case '10':
        $ordering = 'pelari_alamat';
        break;
      case '11':
        $ordering = 'pelari_namadarurat';
        break;
      default:
        $ordering = 'pelari_id';
        break;
    }
    if ($kat!=''){
      if ($kat >= 1){
        $this->db->where('kategori_id', $kat);
      }else{
        $this->db->where('kategori_kategori', $kat);
      }
    }
    if ($kota != ''){
      $this->db->where('pelari_kota', $kota);
    }
    $this->db->where('pelari_bib !=', '');
    $this->db->join('master_user', 'user_id = pelari_user', 'left');
    $this->db->join('master_city', 'pelari_kota = city_id', 'left');
    $this->db->join('master_provinsi', 'pelari_provinsi = provinsi_id', 'left');
    $this->db->join('master_group', 'group_id = pelari_group', 'left');
    $this->db->join('master_kategori', 'kategori_id = pelari_kategori', 'left');
    $this->db->order_by($ordering, $_GET['order'][0]['dir']);
    $this->_get_datatables_query(['master_pelari','master_city','master_user','master_group','master_kategori']);
    if($_GET['length'] != -1)
    $this->db->limit($_GET['length'], $_GET['start']);
    $query = $this->db->get();
    return $query->result();
  }
  ////////////////////////////////////////
  
  function count_all_pelari_kota($kat = '',$kota='')
  { 
    if ($kat!=''){
      if ($kat >= 1){
        $this->db->where('kategori_id', $kat);
      }else{
        $this->db->where('kategori_kategori', $kat);
      }
    }
    if ($kota != ''){
      $this->db->where('pelari_kota', $kota);
    }

    $this->db->where('pelari_bib !=', '');
    $this->db->join('master_user', 'user_id = pelari_user', 'left');
    $this->db->join('master_city', 'pelari_kota = city_id', 'left');
    $this->db->join('master_group', 'group_id = pelari_group', 'left');
    $this->db->join('master_kategori', 'kategori_id = pelari_kategori', 'left');
    
    $this->_get_datatables_query(['master_pelari','master_city','master_user','master_group','master_kategori']);
    
    $query = $this->db->get();
    return $query->num_rows();
  }



  ////////////////////////////////////////
  
  function get_shuttle($sht='')
  {
    switch ($_GET['order'][0]['column']) {
      case '1':
        $ordering = 'shuttle_orderid';
        break;
      case '2':
        $ordering = 'pelari_name';
        break;
      case '3':
        $ordering = 'pelari_bib';
        break;
      case '4':
        $ordering = 'kategori_id';
        break;
      case '5':
        $ordering = 'shuttle_pos';
        break;
      default:
        $ordering = 'shuttle_id';
        break;
    }
    
    if ($sht != ''){
      $this->db->where('shuttle_pos', $sht);
    }
    $this->db->join('master_user', 'user_id = shuttle_user', 'left');
    $this->db->join('master_pelari', 'pelari_user = user_id', 'left');
    $this->db->join('master_kategori', 'kategori_id = pelari_kategori', 'left');
    $this->db->order_by($ordering, $_GET['order'][0]['dir']);
    $this->_get_datatables_query(['master_shuttle','master_user','master_pelari','master_kategori']);
    if($_GET['length'] != -1)
    $this->db->limit($_GET['length'], $_GET['start']);
    $query = $this->db->get();
    return $query->result();
  }
  ////////////////////////////////////////
  
  function count_all_data_shuttle($sht='')
  { 
    if ($sht != ''){
      $this->db->where('shuttle_pos', $sht);
    }
    $this->db->join('master_user', 'user_id = shuttle_user', 'left');
    $this->db->join('master_pelari', 'pelari_user = user_id', 'left');
    $this->db->join('master_kategori', 'kategori_id = pelari_kategori', 'left');
    
    $this->_get_datatables_query(['master_shuttle','master_user','master_pelari','master_kategori']);
    
    $query = $this->db->get();
    return $query->num_rows();
  }
  
  function get_pengambilan($status='')
  {
    if ($status != ''){
      $this->db->where('pelari_ambil', $status);
    }
    switch ($_GET['order'][0]['column']) {
      case '1':
        $ordering = 'pelari_bib';
        break;
      case '3':
        $ordering = 'pelari_name';
        break;
      case '4':
        $ordering = 'group_name';
        break;
      case '5':
        $ordering = 'kategori_name';
        break;
      case '6':
        $ordering = 'pelari_created';
        break;
      default:
        $ordering = 'pelari_id';
        break;
    }
    $this->db->join('master_user', 'user_id = pelari_user', 'left');
    $this->db->join('master_group', 'group_id = pelari_group', 'left');
    $this->db->join('master_kategori', 'kategori_id = pelari_kategori', 'left');
    $this->db->where('pelari_bib !=', null);
    $this->db->order_by($ordering, $_GET['order'][0]['dir']);
    $this->_get_datatables_query(['master_pelari','master_user','master_group','master_kategori']);
    if($_GET['length'] != -1)
    $this->db->limit($_GET['length'], $_GET['start']);
    $query = $this->db->get();
    return $query->result();
  }

  function count_filtered_pengambilan($status='')
  { 
    if ($status != ''){
      $this->db->where('pelari_ambil', $status);
    }
    $this->db->where('pelari_bib !=', null);
    $this->_get_datatables_query(['master_pelari']);
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_all_pengambilan($status='')
  {
    if ($status != ''){
      $this->db->where('pelari_ambil', $status);
    }
    $this->db->where('pelari_bib !=', null);
    $this->db->from(['master_pelari']);
    return $this->db->count_all_results();
  }

  function get_pembayaran()
  {
    switch ($_GET['order'][0]['column']) {
      case '1':
        $ordering = 'tiket_status';
        break;
      case '2':
        $ordering = 'user_email';
        break;
      case '3':
        $ordering = 'tiket_order_id';
        break;
      case '5':
        $ordering = 'tiket_price';
        break;
      case '6':
        $ordering = 'transaksi_date';
        break;
      case '7':
        $ordering = 'transaksi_type';
        break;
      default:
        $ordering = 'tiket_id';
        break;
    }
    $this->db->join('master_user', 'user_id = tiket_user', 'left');
    $this->db->join('master_pelari', 'user_id = pelari_user', 'left');
    $this->db->join('master_transaksi', 'transaksi_order_id = tiket_order_id', 'left');
    $this->db->where('transaksi_status', 'success');
    $this->db->group_by('tiket_order_id');
    $this->db->order_by($ordering, $_GET['order'][0]['dir']);
    $this->_get_datatables_query(['master_tiket','master_pelari','master_user','master_transaksi']);
    if($_GET['length'] != -1)
    $this->db->limit($_GET['length'], $_GET['start']);
    $query = $this->db->get();
    return $query->result();
  }
  ////////////////////////////////////////


  function get_email()
  {
    switch ($_GET['order'][0]['column']) {
      case '1':
        $ordering = 'pelari_bib';
        break;
      case '2':
        $ordering = 'pelari_name';
        break;
      case '3':
        $ordering = 'user_email';
        break;
      case '5':
        $ordering = 'kategori_name';
        break;
      case '6':
        $ordering = 'pelari_kaos';
        break;
      case '7':
        $ordering = 'pelari_ambilinfo';
        break;
      default:
        $ordering = 'pelari_id';
        break;
    }
    $this->db->where('pelari_bib !=', null);
    $this->db->join('master_user', 'user_id = pelari_user', 'left');
    $this->db->join('master_kategori', 'kategori_id = pelari_kategori', 'left');
    $this->db->order_by($ordering, $_GET['order'][0]['dir']);
    $this->_get_datatables_query(['master_pelari','master_user','master_kategori']);
    if($_GET['length'] != -1)
    $this->db->limit($_GET['length'], $_GET['start']);
    $query = $this->db->get();
    return $query->result();
  }

  function count_filtered_email($status='')
  { 
    $this->db->where('pelari_bib !=', null);
    $this->_get_datatables_query(['master_pelari']);
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_all_email($status='')
  {
    $this->db->where('pelari_bib !=', null);
    $this->db->from(['master_pelari']);
    return $this->db->count_all_results();
  }
}



/* End of file Admintablemodel.php */
/* Location: ./application/models/Admintablemodel.php */
