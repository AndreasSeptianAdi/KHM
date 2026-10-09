<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usertable extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('usertablemodel');
	}

	function list_pelari_group(){

    $groupid = $this->db->get_where('master_group', ['group_user' => userid()])->row()->group_id;
    $list = $this->usertablemodel->get_list_pelari_group($groupid);
    $data = array();
    $no = get('start');
    foreach ($list as $view) {
      $no++;
      $row = array();
      $row[] = $no;
      $row[] = $view->pelari_name;
      $row[] = $view->user_email;
      $row[] = $view->kategori_name;
      $row[] = $view->pelari_kaos;
      $row[] = $view->pelari_kaosfinish;
      $row[] = date('d F Y', strtotime($view->pelari_created));
      $hapus = '<a href="javascript:void(0);" onclick="hapus_pelari('.$view->pelari_id.', \'pelari\' )" title="Hapus" class="btn btn-danger btn-sm ml-1" data-id="'.$view->pelari_id.'"><i class="fas fa-trash"></i></a>';
      $edit ='<a 
          href="'.base_url('page/daftar_lari?edit_member=true&edit_group=true&id_user='.$view->user_id).'" 
          class="btn btn-sm btn-info ml-1">
          <i class="fa fa-edit"></i>
        </a>';
      if ($view->pelari_bib == null){
        $row[] = $edit.' '.$hapus;
      }else{
        $row[] = $view->pelari_bib;
      }
      $data[] = $row;
    }

    $output = array(
      "draw" => get('draw'),
      "recordsTotal" => $this->usertablemodel->count_all_pelari_group($groupid),
      "recordsFiltered" => $this->usertablemodel->count_filtered_pelari_group($groupid),
      "data" => $data,
    );
    echo json_encode($output);
  } 

}

/* End of file  */
/* Location: ./application/controllers/ */