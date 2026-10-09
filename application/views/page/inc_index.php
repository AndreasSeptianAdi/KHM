<style type="text/css">
  .pull-right{
    text-align: right;
    display: block;
  }
</style>
<?php $userdata = userdata(); ?>
<div class="container-fluid">
  <!--  Owl carousel -->
  <?php if (userid() == 1){ ?>
    <div class="owl-carousel counter-carousel owl-theme">
      <div class="item">
        <div class="card border-0 zoom-in bg-light-primary shadow-none">
          <div class="card-body">
            <div class="text-center">
              <img src="<?=base_url('assets')?>/images/svgs/icon-user-male.svg" width="50" height="50" class="mb-3" alt="" />
              <p class="fw-semibold fs-3 text-primary mb-1"> User Daftar </p>
              <h5 class="fw-semibold text-primary mb-0"><?=hitung($this->reportmodel->user())?></h5>
            </div>
          </div>
        </div>
      </div>
      <div class="item">
        <div class="card border-0 zoom-in bg-light-warning shadow-none">
          <div class="card-body">
            <div class="text-center">
              <img src="<?=base_url('assets')?>/images/svgs/icon-briefcase.svg" width="50" height="50" class="mb-3" alt="" />
              <p class="fw-semibold fs-3 text-warning mb-1">Group Daftar</p>
              <h5 class="fw-semibold text-warning mb-0"><?=hitung($this->reportmodel->group())?></h5>
            </div>
          </div>
        </div>
      </div>
      <div class="item">
        <div class="card border-0 zoom-in bg-light-info shadow-none">
          <div class="card-body">
            <div class="text-center">
              <img src="<?=base_url('assets')?>/images/svgs/icon-dd-lifebuoy.svg" width="50" height="50" class="mb-3" alt="" />
              <p class="fw-semibold fs-3 text-info mb-1">Total Pelari</p>
              <h5 class="fw-semibold text-info mb-0"><?=hitung($this->reportmodel->pelari())?></h5>
            </div>
          </div>
        </div>
      </div>
      <div class="item">
        <div class="card border-0 zoom-in bg-light-danger shadow-none">
          <div class="card-body">
            <div class="text-center">
              <img src="<?=base_url('assets')?>/images/svgs/icon-favorites.svg" width="50" height="50" class="mb-3" alt="" />
              <p class="fw-semibold fs-3 text-danger mb-1">Kategori Lari</p>
              <h5 class="fw-semibold text-danger mb-0"><?=hitung($this->reportmodel->kategori())?></h5>
            </div>
          </div>
        </div>
      </div>
      <div class="item">
        <div class="card border-0 zoom-in bg-light-success shadow-none">
          <div class="card-body">
            <div class="text-center">
              <img src="<?=base_url('assets')?>/images/svgs/icon-wallet.svg" width="50" height="50" class="mb-3" alt="" />
              <p class="fw-semibold fs-3 text-success mb-1">Pemasukan</p>
              <h5 class="fw-semibold text-success mb-0"><?=hitung($this->reportmodel->pemasukkan())?></h5>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--  Row 3 -->
    <div class="row">
      <!-- Weekly Stats -->
      <div class="col-lg-4 d-flex align-items-strech">
        <div class="card w-100">
          <div class="card-body">
            <h5 class="card-title fw-semibold">Weekly Stats</h5>
            <p class="card-subtitle mb-0">Average sales</p>
            <div id="stats" class="my-4"></div>
            <div class="position-relative">
              <div class="d-flex align-items-center justify-content-between mb-7">
                <div class="d-flex">
                  <div class="p-6 bg-light-primary rounded me-6 d-flex align-items-center justify-content-center">
                    <i class="ti ti-grid-dots text-primary fs-6"></i>
                  </div>
                  <div>
                    <h6 class="mb-1 fs-4 fw-semibold">Group Join</h6>
                    <p class="fs-3 mb-0">Jumlah Group Tergabung </p>
                  </div>
                </div>
                <div class="bg-light-primary badge">
                  <p class="fs-3 text-primary fw-semibold mb-0">+ <?=hitung($this->reportmodel->group('week'))?></p>
                </div>
              </div>
              <div class="d-flex align-items-center justify-content-between mb-7">
                <div class="d-flex">
                  <div class="p-6 bg-light-success rounded me-6 d-flex align-items-center justify-content-center">
                    <i class="ti ti-grid-dots text-success fs-6"></i>
                  </div>
                  <div>
                    <h6 class="mb-1 fs-4 fw-semibold">User Join</h6>
                    <p class="fs-3 mb-0">Jumlah User Tergabung</p>
                  </div>
                </div>
                <div class="bg-light-success badge">
                  <p class="fs-3 text-success fw-semibold mb-0">+ <?=hitung($this->reportmodel->user('week'))?></p>
                </div>
              </div>
              <div class="d-flex align-items-center justify-content-between mb-7">
                <div class="d-flex">
                  <div class="p-6 bg-light-info rounded me-6 d-flex align-items-center justify-content-center">
                    <i class="ti ti-grid-dots text-info fs-6"></i>
                  </div>
                  <div>
                    <h6 class="mb-1 fs-4 fw-semibold">Runner Join</h6>
                    <p class="fs-3 mb-0">Jumlah Pelari Tergabung</p>
                  </div>
                </div>
                <div class="bg-light-info badge">
                  <p class="fs-3 text-info fw-semibold mb-0">+ <?=hitung($this->reportmodel->pelari('week'))?></p>
                </div>
              </div>
              <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex">
                  <div class="p-6 bg-light-danger rounded me-6 d-flex align-items-center justify-content-center">
                    <i class="ti ti-grid-dots text-danger fs-6"></i>
                  </div>
                  <div>
                    <h6 class="mb-1 fs-4 fw-semibold">Payment In</h6>
                    <p class="fs-3 mb-0">Pembayaran Masuk</p>
                  </div>
                </div>
                <div class="bg-light-danger badge">
                  <p class="fs-3 text-danger fw-semibold mb-0">+ <?=hitung($this->reportmodel->pemasukkan('week'))?></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Top Performers -->
      <div class="col-lg-8 d-flex align-items-strech">
        <div class="card w-100">
          <div class="card-body">
            <div class="d-sm-flex d-block align-items-center justify-content-between mb-7">
              <div class="mb-3 mb-sm-0">
                <h5 class="card-title fw-semibold">Lattest Join Runner</h5>
                <p class="card-subtitle mb-0">Pelari Baru</p>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-dark align-middle text-nowrap mb-0">
                <thead>
                  <tr class="text-light fw-semibold">
                    <th scope="col">Assigned</th>
                    <th scope="col">Group</th>
                    <th scope="col">Category</th>
                    <th scope="col">Date Join</th>
                  </tr>
                </thead>
                <tbody class="border-top">
                  <?php 
                    $this->db->limit(10);
                    $this->db->order_by('pelari_id', 'desc');
                    $this->db->join('master_kategori', 'kategori_id = pelari_kategori', 'left');
                    $this->db->join('master_group', 'group_id = pelari_group', 'left');
                    $ok = $this->db->get('master_pelari');
                    foreach ($ok->result() as $pelari) {
                      $dob = new DateTime($pelari->pelari_tgllahir);
                      $today   = new DateTime('today');
                      $umurnya = $dob->diff($today)->y;
                  ?>
                  <tr>
                    <td>
                      <div class="d-flex align-items-center">
                        <div>
                          <h6 class="fw-semibold mb-1 text-info"><?=$pelari->pelari_name?></h6>
                          <p class="fs-2 mb-0 text-light"><?=$umurnya?> Th</p>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="mb-0 fs-3"><?=$pelari->group_name?></p>
                    </td>
                    <td>
                      <p class="mb-0 fs-3"><?=$pelari->kategori_name?></p>
                    </td>
                    <td>
                      <p class="fs-3 text-light mb-0"><?=relative_time($pelari->pelari_created)?></p>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php } else{
      if ($userdata->pelari_id == ''){
        // redirect('page/daftar');
      }
      $this->db->join('master_pelari', 'pelari_user = user_id', 'left');
      $this->db->join('master_kategori', 'kategori_id = pelari_kategori', 'left');
      $this->db->join('master_city', 'city_id = pelari_kota', 'left');
      $userdata = $this->db->get_where('master_user', ['user_id' => userid()])->row();
  ?>
  
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="card">
        <div class="card-body">
          <h2>Data Saya</h2> 
          <div class="pull-right m-2 p-2">
            <?php $this->db->where('pelari_user', userid());
                $this->db->where('pelari_group', null);
                $this->db->where('pelari_bib', null);
                $ok = $this->db->get('master_pelari');
                if ($ok->num_rows() > 0){ 
                  //style= "display:none"
                  ?>
              
              <button type="button" class="btn btn-success font-medium rounded-pill px-4"
                data-bs-toggle="modal" 
                data-modalsize="modal-lg"
                
                data-title="Proses Pembelian Tiket" 
                data-href="<?=base_url('modal/tiket')?>"  
                data-bs-target="#ajax-modal"
              >
                <div class="d-flex align-items-center">
                  <i class="ti ti-cash me-2 fs-4"></i>
                  Proses Pembayaran
                </div>
              </button>
              
               <a type="button" href="<?=base_url('page/daftar_lari?edit=true&id_user='.userid())?>" class="btn btn-info font-medium rounded-pill px-4">
                <div class="d-flex align-items-center">
                  <i class="ti ti-edit me-2 fs-4"></i>
                  Lanjut Edit
                </div>
              </a>
            </div>
            <?php } ?>
          <div class="table-responsive">
            <table id="data_table" style="width:100%" class="table table-dark align-middle text-center mb-0">
              <thead>
                <tr> 
                  <th width="10%">NAMA PELARI</th>
                  <th width="10%">NOMOR BIB</th>
                  <th width="10%">KATEGORI LARI</th>
                  <th width="10%">ASAL</th>
                  <th width="10%">EMAIL</th>
                  <th width="10%">UKURAN KAOS</th>
                  <?php if(($userdata->pelari_name != '') && ($userdata->pelari_kaosfinish != '')){ ?>
                  <th width="10%">JAKET FINISHER</th>
                  <?php } ?>
                  <th width="10%">TIKET</th>
                </tr>
              </thead>
              <tbody>
                <?php if($userdata->pelari_name != ''){ ?>
                <tr> 
                  <th width="10%"><?=$userdata->pelari_name?></th>
                  <th width="10%"><?=$userdata->pelari_bib?></th>
                  <th width="10%"><?=$userdata->kategori_name?></th>
                  <th width="10%"><?=$userdata->city_name?></th>
                  <th width="10%"><?=$userdata->user_email?></th>
                  <th width="10%"><?=$userdata->pelari_kaos?></th>
                  <?php if ($userdata->pelari_kaosfinish != ''){ ?>
                  <th width="10%"><?=$userdata->pelari_kaosfinish?></th>
                  <?php } ?>
                  <th width="10%">
                    <?php if($userdata->pelari_bib != ''){ ?>
                    <button type="button" 
                    data-bs-toggle="modal" 
                    data-title="Tiket KHM 2026" 
                    data-href="<?=base_url('modal/qrcode?bib='.$userdata->pelari_bib)?>" 
                    data-bs-target="#ajax-modal" class="btn btn-danger mt-2">
                    <i class="ti ti-qrcode"></i> TIKET
                  </button><?php } ?></th>
                </tr>
                <?php } ?>
                <?php 
                  if ($userdata->pelari_group != null){
                    $this->db->where('pelari_user !=', $userdata->user_id);
                    $this->db->where('pelari_group', $userdata->pelari_group);
                    $this->db->join('master_kategori', 'kategori_id = pelari_kategori', 'left');
                    $this->db->join('master_city', 'city_id = pelari_kota', 'left');
                    $this->db->join('master_user', 'user_id = pelari_user', 'left');
                    $list = $this->db->get('master_pelari');
                    foreach ($list->result() as $key) {
                      ?>
                      <tr> 
                        <th width="10%"><?=$key->pelari_name?></th>
                        <th width="10%"><?=$key->pelari_bib?></th>
                        <th width="10%"><?=$key->kategori_name?></th>
                        <th width="10%"><?=$key->city_name?></th>
                        <th width="10%"><?=$key->user_email?></th>
                        <th width="10%"><button type="button" 
                    data-bs-toggle="modal" 
                    data-title="QRCODE Pengambilan Kaos" 
                    data-href="<?=base_url('modal/qrcode?bib='.$key->pelari_bib)?>" 
                    data-bs-target="#ajax-modal" class="btn btn-danger mt-2">
                    <i class="ti ti-qrcode"></i> TIKET
                  </button></th>
                      </tr>
                      <?php
                    }
                ?>

                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <?php if ($userdata->pelari_bib != ''){ ?>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="d-sm-flex d-block align-items-center justify-content-between mb-7">
            <div class="mb-3 mb-sm-0">
              <h5 class="card-title fw-semibold">Informasi</h5>
            </div>
          </div>
          <div>
            <?=option('informasi')?>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>
  </div>


</div>

<?php } ?>
