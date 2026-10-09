<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admintable extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admintablemodel');
    
	}

  function kategori(){

    $list = $this->admintablemodel->get_kategori();
    $data = array();
    $no = get('start');
    foreach ($list as $view) {
      $no++;
      $row = array();
      $row[] = $no;
      $row[] = $view->kategori_name;
      $row[] = humanize($view->kategori_kategori);
      $row[] = uang($view->kategori_priceearly);
      $row[] = uang($view->kategori_price);
      $row[] = $view->kategori_kuota;
      
      $hapus = '<a href="javascript:void(0);" onclick="hapus_data('.$view->kategori_id.', \'kategori\' )" title="Hapus" class="btn btn-danger btn-sm ml-1" data-id="'.$view->kategori_id.'"><i class="fas fa-trash"></i></a>';
      $duplikat = '<button 
          type="button" 
          data-bs-toggle="modal" 
          data-modalsize="modal-lg"
          title="Duplikat"
          data-title="Buat Kategori Baru" 
          data-href="'.base_url('adminmodal/kategori?is_dup=true&id='.$view->kategori_id).'" 
          class="btn btn-sm btn-warning ml-1" 
          data-bs-target="#ajax-modal">
          <i class="fa fa-copy"></i>
        </button>';
      $edit ='<button 
          type="button" 
          data-bs-toggle="modal" 
          data-modalsize="modal-lg"
          data-title="Edit Kategori" 
          data-href="'.base_url('adminmodal/kategori?id='.$view->kategori_id).'" 
          class="btn btn-sm btn-info ml-1" 
          data-bs-target="#ajax-modal">
          <i class="fa fa-edit"></i>
        </button>';
      $row[] = $edit.' '.$duplikat.' '.$hapus;

      $data[] = $row;
    }

    $output = array(
      "draw" => get('draw'),
      "recordsTotal" => $this->admintablemodel->count_all_data('kategori'),
      "recordsFiltered" => $this->admintablemodel->count_filtered_data('kategori'),
      "data" => $data,
    );
    echo json_encode($output);
  } 

  function user(){

    $list = $this->admintablemodel->get_user();
    $data = array();
    $no = get('start');
    foreach ($list as $view) {
      $no++;
      $row = array();
      $row[] = $no;
      $row[] = ($view->user_status == '1')?'Aktif':'Tidak Aktif';
      $row[] = $view->user_email;
      $row[] = date('d F Y', strtotime($view->user_created));
      
      $this->db->where('pelari_user', $view->user_id);
      $cek = $this->db->get('master_pelari');
      $hapus = '';
      if ($cek->num_rows() == 0){
        $hapus = '';
      }else{
        if ($cek->row()->pelari_bib != null){
          $hapus = '';
        }else{
          $hapus = '<a href="javascript:void(0);" onclick="hapus_data('.$view->user_id.', \'user\' )" title="Hapus" class="btn btn-danger btn-sm ml-1" data-id="'.$view->user_id.'"><i class="fas fa-trash"></i></a>';
        }
      }
      $duplikat = '<button 
          type="button" 
          data-bs-toggle="modal" 
          data-modalsize="modal-lg"
          title="Duplikat"
          data-title="Buat User Baru" 
          data-href="'.base_url('adminmodal/user?is_dup=true&id='.$view->user_id).'" 
          class="btn btn-sm btn-warning ml-1" 
          data-bs-target="#ajax-modal">
          <i class="fa fa-copy"></i>
        </button>';
      $edit ='<button 
          type="button" 
          data-bs-toggle="modal" 
          data-modalsize="modal-lg"
          data-title="Edit User '.$view->user_email.'" 
          data-href="'.base_url('adminmodal/user?id='.$view->user_id).'" 
          class="btn btn-sm btn-info ml-1" 
          data-bs-target="#ajax-modal">
          <i class="fa fa-edit"></i>
        </button>';
      $row[] = $edit.' '.$duplikat.' '.$hapus;

      $data[] = $row;
    }

    $output = array(
      "draw" => get('draw'),
      "recordsTotal" => $this->admintablemodel->count_all_data('user'),
      "recordsFiltered" => $this->admintablemodel->count_filtered_data('user'),
      "data" => $data,
    );
    echo json_encode($output);
  } 

  function group(){

    $list = $this->admintablemodel->get_group();
    $data = array();
    $no = get('start');
    foreach ($list as $view) {
      $no++;
      $row = array();
      $row[] = $no;
      $row[] = $view->group_name;
      $row[] = $view->user_email;
      $row[] = $this->db->get_where('master_pelari', ['pelari_group' => $view->group_id])->num_rows();
      $row[] = date('d F Y', strtotime($view->group_created));
      
      $this->db->where('pelari_user', $view->user_id);
      $cek = $this->db->get('master_pelari');
      $hapus = '';
      if ($cek->num_rows() == 0){
        $hapus = '';
      }else{
        if ($cek->row()->pelari_bib != null){
          $hapus = '';
        }else{
          $hapus = '<a href="javascript:void(0);" onclick="hapus_data('.$view->group_id.', \'group\' )" title="Hapus" class="btn btn-danger btn-sm ml-1" data-id="'.$view->group_id.'"><i class="fas fa-trash"></i></a>';
        }
      }
      
      $view ='<button 
          type="button" 
          data-bs-toggle="modal" 
          data-modalsize="modal-lg"
          data-title="List Pelari" 
          data-href="'.base_url('adminmodal/group?id='.$view->group_id).'" 
          class="btn btn-sm btn-info ml-1" 
          data-bs-target="#ajax-modal">
          <i class="fa fa-search"></i>
        </button>';
      $row[] = $view.' '.$hapus;

      $data[] = $row;
    }

    $output = array(
      "draw" => get('draw'),
      "recordsTotal" => $this->admintablemodel->count_all_data('group'),
      "recordsFiltered" => $this->admintablemodel->count_filtered_data('group'),
      "data" => $data,
    );
    echo json_encode($output);
  } 

  function list_pelari(){

    $list = $this->admintablemodel->get_list_pelari(get('group'));
    $data = array();
    $no = get('start');
    foreach ($list as $view) {
      $no++;
      $row = array();
      $row[] = $no;
      $row[] = $view->pelari_name;
      $row[] = $view->city_name;
      $row[] = $view->user_email;
      $row[] = $view->kategori_name;
      $row[] = uang(harga_group($view->kategori_id));
      $row[] = date('d F Y', strtotime($view->pelari_created));
      $data[] = $row;
    }

    $output = array(
      "draw" => get('draw'),
      "recordsTotal" => $this->admintablemodel->count_all_list_pelari(get('group')),
      "recordsFiltered" => $this->admintablemodel->count_filtered_list_pelari(get('group')),
      "data" => $data,
    );
    echo json_encode($output);
  } 

  function pelari(){

    $list = $this->admintablemodel->get_pelari(get('kat'),get('ready'),get('bayar'));
    $data = array();
    $no = get('start');
    foreach ($list as $view) {
      $no++;
      $row = array();
      $row[] = $no;
      $status = ($view->pelari_bib == '')? 'Belum Bayar' : 'Sudah Bayar';
      $warna = ($view->pelari_bib == '')? 'danger' : 'success';
      // if ($view->pelari_setuju == 'F'){
      //   if ($view->pelari_bib == null){
      //     $status = 'BELUM READY';
      //     $warna = 'danger';
      //   }
      // }
      $row[] = '<span class="text-'.$warna.'">'.$status.'</span>';
      // $row[] = $view->group_name;
      $row[] = $view->pelari_name;
      $row[] = $view->user_email;
      $row[] = $view->kategori_name;
      $row[] = $view->pelari_bib;
      $finis = ($view->pelari_kaosfinish != '')? ' - '.$view->pelari_kaosfinish : '';
      $row[] = $view->pelari_kaos .''.$finis;
      $row[] = $view->pelari_telp;
      $row[] = date('d F Y H:i', strtotime($view->pelari_created));
      
      // $modal_pelari = ($view->kategori_kategori == 'umum')? 'pelariumum' : 'pelaripelajar';
      $modal_pelari ='pelariumum';

      if ($view->pelari_bib != null){
        $hapus = '';
      }else{
        $hapus = '<a href="javascript:void(0);" onclick="hapus_data('.$view->pelari_id.', \'pelari\' )" title="Hapus" class="btn btn-danger btn-sm ml-1" data-id="'.$view->pelari_id.'"><i class="fas fa-trash"></i></a>';
      }

      
      $edit ='<button 
          type="button" 
          data-bs-toggle="modal" 
          data-modalsize="modal-lg"
          data-title="Edit Pelari" 
          data-href="'.base_url('adminmodal/'.$modal_pelari.'?id='.$view->pelari_id).'" 
          class="btn btn-sm btn-info ml-1" 
          data-bs-target="#ajax-modal">
          <i class="fa fa-edit"></i>
        </button>';
      if ($view->pelari_bib != null){
      
      $edit .=' <button 
          type="button" 
          data-bs-toggle="modal" 
          data-modalsize="modal-md"
          data-title="Edit Kaos" 
          data-href="'.base_url('adminmodal/ubah_kaos?id='.$view->pelari_id).'" 
          class="btn btn-sm btn-warning ml-1" 
          data-bs-target="#ajax-modal">
          <i class="fa fa-universal-access"></i>
        </button> ';
      }
      $row[] = $edit.' '.$hapus;

      $data[] = $row;
    }

    $output = array(
      "draw" => get('draw'),
      "recordsTotal" => $this->admintablemodel->count_all_data('pelari'),
      "recordsFiltered" => $this->admintablemodel->count_all_pelari(get('kat'),get('ready'),get('bayar')),
      "data" => $data,
    );
    echo json_encode($output);
  }  

  function pelari_kota(){

    $list = $this->admintablemodel->get_pelari_kota(get('kat'),get('kota'));
    $data = array();
    $no = get('start');
    foreach ($list as $view) {
      $no++;
      $row = array();
      $row[] = $no;
      $row[] = $view->pelari_name;
      $row[] = $view->user_email;
      $row[] = $view->pelari_telp;
      $row[] = $view->kategori_name;
      $row[] = $view->pelari_bib;
      $row[] = $view->pelari_sex;
      $finis = ($view->pelari_kaosfinish != '')? ' - '.$view->pelari_kaosfinish : '';
      $row[] = $view->pelari_kaos .''.$finis;
      $row[] = $view->provinsi_nama;
      $row[] = $view->city_name;
      $row[] = $view->pelari_alamat;
      $row[] = $view->pelari_namadarurat.' - '.$view->pelari_tlpdarurat;
      $row[] = date('d F Y H:i', strtotime($view->pelari_created));
      $modal_pelari ='pelariumum';

      if ($view->pelari_bib != null){
        $hapus = '';
      }else{
        $hapus = '<a href="javascript:void(0);" onclick="hapus_data('.$view->pelari_id.', \'pelari\' )" title="Hapus" class="btn btn-danger btn-sm ml-1" data-id="'.$view->pelari_id.'"><i class="fas fa-trash"></i></a>';
      }

      
      $edit ='<button 
          type="button" 
          data-bs-toggle="modal" 
          data-modalsize="modal-lg"
          data-title="Edit Pelari" 
          data-href="'.base_url('adminmodal/'.$modal_pelari.'?id='.$view->pelari_id).'" 
          class="btn btn-sm btn-info ml-1" 
          data-bs-target="#ajax-modal">
          <i class="fa fa-edit"></i>
        </button>';
      $row[] = $edit.' '.$hapus;

      $data[] = $row;
    }

    $output = array(
      "draw" => get('draw'),
      "recordsTotal" => $this->admintablemodel->count_all_data('pelari', ['pelari_bib !=' => '']),
      "recordsFiltered" => $this->admintablemodel->count_all_pelari_kota(get('kat'),get('kota')),
      "data" => $data,
    );
    echo json_encode($output);
  } 

  function shuttle_pelari(){

    $list = $this->admintablemodel->get_shuttle(get('shuttle'));
    $data = array();
    $no = get('start');
    foreach ($list as $view) {
      $no++;
      $row = array();
      $row[] = $no;
      $row[] = $view->shuttle_orderid;
      $row[] = $view->pelari_name;
      $row[] = $view->pelari_bib;
      $row[] = $view->kategori_name;
      if ($view->shuttle_pos == 1){
        $sht = 'PEMKOT';
      }else if ($view->shuttle_pos == 2){
        $sht = 'PEMKAB';
      }else{
        $sht = 'GUMUL';
      }
      $row[] = $sht;
      
      $row[] = date('d F Y H:i', strtotime($view->shuttle_created));

      $data[] = $row;
    }

    $output = array(
      "draw" => get('draw'),
      "recordsTotal" => $this->admintablemodel->count_all_data('shuttle'),
      "recordsFiltered" => $this->admintablemodel->count_all_data_shuttle(get('shuttle')),
      "data" => $data,
    );
    echo json_encode($output);
  } 

  function pengambilan(){

    $list = $this->admintablemodel->get_pengambilan(get('status'));
    $data = array();
    $no = get('start');
    foreach ($list as $view) {
      $no++;
      $row = array();
      $row[] = $no;
      $row[] = ($view->pelari_ambil == 'T')? 'Sudah Ambil' : 'Belum Ambil';
      $row[] = $view->pelari_bib;
      $row[] = $view->pelari_name;
      $row[] = $view->group_name;
      $row[] = $view->kategori_name;
      $row[] = date('d F Y', strtotime($view->pelari_created));
      $row[] = humanize($view->pelari_ambilnama);
      $ambil = ($view->pelari_ambil == 'T')? true : false;
      $status = $view->pelari_ambil;
      $row[] = ($view->pelari_ambildate != '')? date('d-m-Y H:i', strtotime($view->pelari_ambildate)) : '';
      $icon  = ($ambil)? 'times' : 'check';
      $btn   = ($ambil)? 'danger' : 'success';
      if (!$ambil){
        $list = $this->session->userdata('ambil');
        if (is_array($list)){
          if (count($list) > 0){
            foreach ($list as $ko){
              if ($ko == $view->pelari_id){
                $ambil = true;
                $status = 'T';
              }
            }
          }
        }
        $icon  = ($ambil)? 'times' : 'check';
        $btn   = ($ambil)? 'warning' : 'success';
        $button = '<a href="javascript:void(0);" onclick="ambil('.$view->pelari_id.', \''.$status.'\' )" title="Ambil Paket" class="btn btn-'.$btn.' btn-sm ml-1" data-id="'.$view->pelari_id.'"><i class="fas fa-'.$icon.'"></i></a>';
      }else{
        $button = '<a href="javascript:void(0);" onclick="removeambil('.$view->pelari_id.', \''.$status.'\' )" title="Ambil Paket" class="btn btn-'.$btn.' btn-sm ml-1" data-id="'.$view->pelari_id.'"><i class="fas fa-'.$icon.'"></i></a>';
      }
      $row[] = $button;

      $data[] = $row;
    }

    $output = array(
      "draw" => get('draw'),
      "recordsTotal" => $this->admintablemodel->count_all_pengambilan(get('status')),
      "recordsFiltered" => $this->admintablemodel->count_filtered_pengambilan(get('status')),
      "data" => $data,
    );
    echo json_encode($output);
  }

  function report_pembayaran(){

    $list = $this->admintablemodel->get_pembayaran();
    $data = array();
    $no = get('start');
    foreach ($list as $view) {
      $no++;
      $row = array();
      $row[] = $no;
      $row[] = humanize($view->tiket_status);
      $row[] = $view->user_email."\n".$view->pelari_name;
      $row[] = $view->tiket_order_id;
      $jml = count(json_decode($view->tiket_data));
      $row[] = $jml;
      $row[] = uang($view->tiket_price);
      $row[] = date('d F Y H:i:s', strtotime($view->transaksi_date));
      $row[] = strtoupper($view->transaksi_type);

      $data[] = $row;
    }

    $output = array(
      "draw" => get('draw'),
      "recordsTotal" => $this->admintablemodel->count_all_data('tiket'),
      "recordsFiltered" => $this->admintablemodel->count_filtered_data('tiket'),
      "data" => $data,
    );
    echo json_encode($output);
  } 

  function email(){

    $list = $this->admintablemodel->get_email();
    $data = array();
    $no = get('start');
    foreach ($list as $view) {
      $no++;
      $row = array();
      $row[] = '<input value="'.$view->pelari_id.'" type="hidden"  data-email="'.$view->user_email.'">';
      $row[] = humanize($view->pelari_bib);
      $row[] = $view->pelari_name;
      $row[] = $view->user_email;
      $row[] = $view->kategori_name;
      $kaos = ($view->pelari_kaosfinish != '')? ' - '.$view->pelari_kaosfinish : '';
      $row[] = $view->pelari_kaos.$kaos;

      if ($view->pelari_ambilinfo != ''){
        $row[] = date('d F Y H:i:s', strtotime($view->pelari_ambilinfo));
        $button = ' <a href="javascript:void(0);" onclick="kirim_email('.$view->pelari_id.', \''.$view->user_email.'\',\'ulang\')" title="Kirim Ulang Email" class="btn btn-warning btn-sm ml-1" data-id="'.$view->pelari_id.'"><i class="ti ti-mail-forward"></i> Pengambilan</a>';
      }else{
        $row[] = ' - ';
        $button = ' <a href="javascript:void(0);" onclick="kirim_email('.$view->pelari_id.', \''.$view->user_email.'\')" title="Kirim Email" class="btn btn-info btn-sm ml-1" data-id="'.$view->pelari_id.'"><i class="ti ti-mail"></i> Pengambilan</a>';
      }

      $button .= ' <a href="javascript:void(0);" onclick="kirim_email2('.$view->pelari_id.', \''.$view->user_email.'\',\'ulang\')" title="Kirim Ulang Email BIB" class="btn btn-success btn-sm ml-1 mt-1" data-id="'.$view->pelari_id.'"><i class="ti ti-message-forward"></i> Nomor BIB</a>';
      $row[] = $button;

      $data[] = $row;
    }

    $output = array(
      "draw" => get('draw'),
      "recordsTotal" => $this->admintablemodel->count_all_email(),
      "recordsFiltered" => $this->admintablemodel->count_filtered_email(),
      "data" => $data,
    );
    echo json_encode($output);
  } 
}

/* End of file  */
/* Location: ./application/controllers/ */
