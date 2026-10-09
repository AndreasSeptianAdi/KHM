<?php 
  $isEdit = false;
  $this->db->join('master_pelari', 'pelari_user = user_id', 'left');
  $this->db->join('master_kategori', 'kategori_id = pelari_kategori', 'left');
  $this->db->join('master_city', 'city_id = pelari_kota', 'left');
  $userdata = $this->db->get_where('master_user', ['user_id' => userid()])->row();
  if (get('edit') == 'true'){
    $this->db->where('pelari_user', $userdata->user_id);
    $usr = $this->db->get('master_pelari')->row();
    $get_kat = $usr->pelari_kategori;
    $isEdit = true;
  }else{
    $get_kat = post('cat');
    if ($userdata->pelari_kategori != ''){
      $get_kat = $userdata->pelari_kategori;
    }
  }
  $this->db->where('kategori_id', $get_kat);
  $the_cat = $this->db->get('master_kategori')->row();

  $through = true;
  $text = '';
  if ($the_cat->kategori_kuota < 1){
    $through = false;
    redirect('https://register.kedirihalfmarathon.com/page/','refresh');
  }
  if (date('Y-m-d H:i:s') >= $the_cat->kategori_dateexp ){
    $through = false;
    redirect('https://register.kedirihalfmarathon.com/page/','refresh');
  }
  if (date('Y-m-d H:i:s') <= $the_cat->kategori_datestart ){
    $through = false;
    redirect('https://register.kedirihalfmarathon.com/page/','refresh');
  }
  $kategori_kat = get_kategori($get_kat);


  if ((date('Y-m-d H:i') >= date('Y-m-d H:i', strtotime(option('reg_umum')))) && (date('Y-m-d H:i') <= date('Y-m-d H:i', strtotime(option('reg_umum_close'))) )) {
    if ((date('Y-m-d H:i') >= date('Y-m-d H:i', strtotime(option('reg_khusus')))) && (date('Y-m-d H:i') <= date('Y-m-d H:i', strtotime(option('reg_khusus_close'))) )) {
      if ((get('group_add') != 'true') && (get('edit_group') != 'true')){
        redirect('https://register.kedirihalfmarathon.com/page/','refresh');
      }
    }
  }
  
  if ($userdata->pelari_bib == ''){
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="d-sm-flex d-block align-items-center justify-content-between mb-7">
            <div class="mb-3 mb-sm-0">
              <h5 class="card-title fw-semibold">Registrasi</h5>
            </div>
          </div>
        <?=form_open('', ['id' => 'pelari']);?>
      	<?php 
      		  $userid = get('id_user');
            $ispribadi = 'false';
            echo form_hidden('userid', userid());
            $group_id = $userdata->pelari_group;
            $is_new = false;
            $kat = new \stdClass();
            if ((get('group_add') == 'true') || get('regis_new') == 'true'){
              
              $is_new = true;
              $ispribadi = 'false';
              $kat->user_email = '';
              $kat->user_password = '';
              $kat->pelari_name = '';
              $kat->pelari_identitas = '';
              $kat->pelari_sex = '';
              $kat->pelari_tgllahir = '';
              $kat->pelari_goldar = '';
              $kat->pelari_provinsi = '';
              $kat->pelari_city = '';
              $kat->pelari_telp = '';
              $kat->pelari_alamat = '';
              $kat->pelari_riwayat = '';
              $kat->pelari_ketriwayat = '';
              $kat->pelari_namadarurat = '';
              $kat->pelari_tlpdarurat = '';
              $kat->pelari_namabib = '';
              $kat->pelari_kategori = '';
              $kat->pelari_kaos = '';
              $kat->pelari_kaosfinish = '';
              $kat->kategori_kaosfinish = '';
              $kat->pelari_created = '';
              $kat->kategori_kategori = '';
              $kat->pelari_club = '';
              $kat->group_user = '';
              $kat->pelari_setuju = '';
              $kat->kategori_id = $get_kat;
              $kat->kategori_kategori = $kategori_kat;
              if (get('group_add') == 'true'){
                $kat->group_user = $group_id;
                echo form_hidden('group_id', $group_id);
                echo form_hidden('add_group', 'true');
                echo form_hidden('userid', userid());
                $this->db->where('pelari_user', userid());
                $cek_sudah_daftar = $this->db->get('master_pelari')->num_rows();
                if ($cek_sudah_daftar == 0){
                  $ispribadi = 'true';
                }
              }
            }else{
              
              $this->db->join('master_pelari', 'user_id = pelari_user', 'left');
              $this->db->join('master_city', 'pelari_kota = city_id', 'left');
              $this->db->join('master_group', 'group_id = pelari_group', 'left');
              $this->db->join('master_kategori', 'kategori_id = pelari_kategori', 'left');
              if (get('edit_member') == 'true'){
                $this->db->where('user_id', $userid);
                echo form_hidden('edit_member', 'true');
                if (get('id_user') == userid()){
                  $ispribadi = 'true';
                }
              }else{
                $this->db->where('user_id', userid());
              }
        			$kate = $this->db->get('master_user');
              if ($kate->num_rows() == 0){
                redirect('','refresh');
                return;
              }else{
                $kat = $kate->row();
                if (post('tgl_lahir')){
                  $kat->pelari_tgllahir = post('tgl_lahir');
                }
                
              }
            }
            if ($kat->pelari_created != ''){
              echo form_hidden('id', $kat->pelari_id);
              echo form_hidden('userid', $kat->user_id);
            }

            echo form_hidden('ispribadi', $ispribadi);
      	?>
          <div class="row">
          <?php 
            if ((userid() == $kat->group_user) || (get('group_add') == 'true')){
              if ($ispribadi == 'false'){
                  if (!get('edit_member')){
          ?>
            <div class="col-md-12" style="background-color: #deecff;">
              <h6 class="p-2">-- Daftarkan Email, Password, dan Data Diri Teman Group Kalian --</h6>
                <div class="row">
                  <div class="col-6">
                    <div class="form-floating mb-3">
                      <input type="text" name="email" class="form-control" id="tb-email" value="<?=$kat->user_email?>" placeholder="" />
                      <label for="tb-email">Email</label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-floating mb-3">
                      <input type="password" name="password" required class="form-control" id="tb-password" placeholder="" />
                      <label for="tb-password">Password</label>
                    </div>
                  </div>
                </div>
            </div>
            <hr>
          <?php }}else{
            ?>
            <div class="col-md-12">
              <h2>Masukkan Data Leader Group</h2><br>
            </div>
            <?php
          }} ?>

            <div class="col-md-6">
              <h6>-- Info Kontak Pribadi --</h6>
              <div class="form-floating mb-3">
                <input type="text" name="name" class="form-control" id="tb-name" value="<?=$kat->pelari_name?>" placeholder="" />
                <label for="tb-name">Nama Lengkap</label>
              </div>

              <div class="form-floating mb-3">
                <input type="text" name="identitas" class="form-control angka" id="tb-identitas" value="<?=$kat->pelari_identitas?>" placeholder="" />
                <label for="tb-identitas">Nomor Identitas (KTP/KIA/NIK)</label>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-floating mb-3">
                    <select type="date" name="sex" class="form-control" id="tb-sex" placeholder="">
                      <option selected disabled>PILIH</option>
                      <option <?=($kat->pelari_sex == 'L')? 'selected' : '' ?> value="L">Laki-Laki</option>
                      <option <?=($kat->pelari_sex == 'P')? 'selected' : '' ?> value="P">Perempuan</option>
                    </select>
                    <label for="tb-sex">Jenis Kelamin</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating mb-3">
                    <select type="date" name="goldar" class="form-control" id="tb-goldar" placeholder="">
                      <option selected disabled>PILIH</option>
                      <option <?=($kat->pelari_goldar == '0')? 'selected' : '' ?> value="0">0</option>
                      <option <?=($kat->pelari_goldar == 'A')? 'selected' : '' ?> value="A">A</option>
                      <option <?=($kat->pelari_goldar == 'B')? 'selected' : '' ?> value="B">B</option>
                      <option <?=($kat->pelari_goldar == 'AB')? 'selected' : '' ?> value="AB">AB</option>
                    </select>
                    <label for="tb-goldar">Golongan Darah</label>
                  </div>
                </div>
              </div>

              <div class="form-floating mb-3">
                <input type="date" name="tgllahir" class="form-control" id="tb-tgllahir" value="<?=$kat->pelari_tgllahir?>" placeholder=""/>
                <label for="tb-tgllahir">Tanggal Lahir</label>
              </div>

              <div class="form-floating mb-3">
                <select name="provinsi" class="form-control" id="tb-provinsi" placeholder="Enter Name here">
                  <option selected disabled>PILIH</option>
                  <?php 
                    $provinsi = $this->db->get('master_provinsi');
                    foreach ($provinsi->result() as $data_province) {
                      $seled = ($data_province->provinsi_id == $kat->pelari_provinsi)? 'selected' : '';
                      echo '<option '.$seled.' value="'.$data_province->provinsi_id.'">'.$data_province->provinsi_nama.'</option>';
                    }
                  ?>
                </select>
                <label for="tb-provinsi">Provinsi</label>
              </div>
              <script type="text/javascript">
                $('#tb-provinsi').change(function(event) {
                  $('#tb-city').html('<select name="city" class="form-control" id="tb-city" placeholder="Enter Name here"><option value="" selected disabled>PILIH</option></select>');
                  $.ajax({
                    url: '<?=base_url('maindata/getcity')?>',
                    type: 'get',
                    dataType: 'json',
                    data: {id: $(this).val()},
                  })
                  .done(function(data) {
                    select = document.getElementById('tb-city');
                    data.forEach( function(element, index) {
                      var opt = document.createElement('option');
                      opt.value = element['value'];
                      opt.innerHTML = element['text'];
                      select.appendChild(opt);
                    });
                  });
                });
              </script>
              <div class="form-floating mb-3">
                <select name="city" class="form-control" id="tb-city" placeholder="Enter Name here">
                  <option selected disabled>PILIH</option>
                  <?php 
                    $this->db->where('city_provinceid', $kat->pelari_provinsi);
                    $kota = $this->db->get('master_city');
                    foreach ($kota->result() as $data_city) {
                      $seled = ($data_city->city_id == $kat->pelari_kota)? 'selected' : '';
                      echo '<option '.$seled.' value="'.$data_city->city_id.'">'.$data_city->city_type.' '.$data_city->city_name.'</option>';
                    }
                  ?>
                </select>
                <label for="tb-city">Kota</label>
              </div>

              <div class="form-floating mb-3">
                <input type="text" name="telp" class="form-control angka" id="tb-telp" value="<?=$kat->pelari_telp?>" placeholder=""/>
                <label for="tb-telp">Nomor Telp</label>
              </div>

              <div class="form-floating mb-3">
                <input type="text" name="alamat" class="form-control" id="tb-alamat" value="<?=$kat->pelari_alamat?>" placeholder=""/>
                <label for="tb-alamat">Alamat Lengkap</label>
              </div>
              
            </div>
            <div class="col-md-6">
              <h6>-- Info Detail --</h6>

              <div class="form-floating mb-3">
                <input type="text" name='namabib' class="form-control" value="<?=$kat->pelari_namabib?>" id="tb-namabib" placeholder=""/>
                <label for="tb-namabib">Nama BIB</label>
              </div>

              <div class="form-floating mb-3">
                <select name="riwayat" class="form-control" id="tb-riwayat" placeholder="Enter Name here">
                  <option selected disabled>PILIH</option>
                  <option <?=($kat->pelari_riwayat == 'T')? 'selected' : '' ?> value="T">Ya</option>
                  <option <?=($kat->pelari_riwayat == 'F')? 'selected' : '' ?> value="F">Tidak</option>
                </select>
                <label for="tb-riwayat">Riwayat Sakit Berat</label>
              </div>

              <script type="text/javascript">
                $('#tb-riwayat').change(function(event) {
                  if ($(this).val() == 'T'){
                    $('#div_ket').show();
                  }else{
                    $('#div_ket').hide();
                  }
                });
              </script>

              <div class="form-floating mb-3" id="div_ket" style="display:none">
                <input type="text" name='ketriwayat' class="form-control" value="<?=$kat->pelari_ketriwayat?>" id="tb-ketriwayat" placeholder=""/>
                <label for="tb-ketriwayat">Ket. Riwayat Sakit</label>
              </div>

              <div class="form-floating mb-3">
                <input type="text" name='namadarurat' class="form-control" value="<?=$kat->pelari_namadarurat?>" id="tb-namadarurat" placeholder=""/>
                <label for="tb-namadarurat">Nama Kontak Darurat</label>
              </div>

              <div class="form-floating mb-3">
                <input type="text" name='tlpdarurat' class="form-control angka" value="<?=$kat->pelari_tlpdarurat?>" id="tb-tlpdarurat" placeholder=""/>
                <label for="tb-tlpdarurat">Nomor Kontak Darurat</label>
              </div>

              
              <div class="form-floating mb-3">
                <select type="date" name="kategori" class="form-control" id="tb-kategori" placeholder="">
                  <option selected value="<?=$the_cat->kategori_id.'|'.$the_cat->kategori_kaosfinish.'|'.$the_cat->kategori_kategori?>"><?=$the_cat->kategori_name?></option>

                  <?php 
                      /*
                        OJOK DIBUSEK SEK MBLOOOO

                      $this->db->order_by('kategori_created', 'asc');
                      $this->db->where('kategori_status', '1');
                      $this->db->where('kategori_kuota > ', '0');
                      if ($get_kat != '4'){
                        $this->db->where('kategori_kategori', $kat->kategori_kategori);
                        if (get('type') != ''){
                          if (get('type') == 'smp'){
                            $this->db->where('kategori_id', '9');
                          }else if (get('type') == 'sma'){
                            $this->db->where('kategori_id', '2');
                          }
                        }
                      }
                      if ($is_new){
                        $this->db->where('kategori_id !=', 11); // hilangkan master dulu
                      }
                      $get = $this->db->get('master_kategori');
                      foreach ($get->result() as $kategorilari) {
                        $selected = ($kategorilari->kategori_id == $kat->pelari_kategori)? 'selected' : '';
                        echo '<option '.$selected.' value="'.$kategorilari->kategori_id.'|'.$kategorilari->kategori_kaosfinish.'|'.$kategorilari->kategori_kategori.'">'.$kategorilari->kategori_name.'</option>';  
                      } */
                  ?>
                </select>
                <label for="tb-kategori">Kategori Lari</label>
              </div>

              <div class="form-floating mb-3">
                <select type="date" name="kaos" class="form-control" id="tb-kaos" placeholder="">
                  <option selected disabled>PILIH</option>
                  <option <?=($kat->pelari_kaos == 'XXS')? 'selected' : ''?> value="XXS">XXS</option>
                  <option <?=($kat->pelari_kaos == 'XS')? 'selected' : ''?> value="XS">XS</option>
                  <option <?=($kat->pelari_kaos == 'S')? 'selected' : ''?> value="S">S</option>
                  <option <?=($kat->pelari_kaos == 'M')? 'selected' : ''?> value="M">M</option>
                  <option <?=($kat->pelari_kaos == 'L')? 'selected' : ''?> value="L">L</option>
                  <option <?=($kat->pelari_kaos == 'XL')? 'selected' : ''?> value="XL">XL</option>
                  <option <?=($kat->pelari_kaos == 'XXL')? 'selected' : ''?> value="XXL">XXL</option>
                </select>
                <label for="tb-kaos">Ukuran Kaos</label>

                <button type="button" 
                  data-bs-toggle="modal" 
                  data-title="Detail Ukuran Kaos" 
                  data-href="<?=base_url('modal/ukurankaos')?>" 
                  data-bs-target="#ajax-modal" class="btn btn-info mt-2">
                  <i class="ti ti-shirt"></i> Lihat Ukuran Kaos
                </button>
              </div>

              <script type="text/javascript">
                $(document).ready(function(event) {
                  val = $('#tb-kategori').val().split('|');
                  if (val[1] == 'T'){
                    $('.show_kaos').show();
                  }else{
                    $('.show_kaos').hide();
                  }
                  if (val[2] == 'pelajar'){
                    $('.show_sekolah').show();
                  }else{
                    $('.show_sekolah').hide();
                  }
                });
              </script>

              <div class="form-floating mb-3 show_sekolah" style="display:<?=($kat->kategori_kategori == 'pelajar')? 'block' : 'none'?>">
                <input type="text" name='asalsekolah' class="form-control" value="<?=$kat->pelari_club?>" id="tb-asalsekolah" placeholder=""/>
                <label for="tb-asalsekolah">Asal Sekolah</label>
              </div>

              <div class="form-floating mb-3 show_kaos" style="display:<?=($kat->kategori_kaosfinish == 'T')? 'block' : 'none'?>">
                <select type="date" name="kaosfinish" class="form-control" id="tb-kaosfinish" placeholder="">
                  <option selected disabled>PILIH</option>
                  <option <?=($kat->pelari_kaosfinish == 'S')? 'selected' : ''?> value="S">S</option>
                  <option <?=($kat->pelari_kaosfinish == 'M')? 'selected' : ''?> value="M">M</option>
                  <option <?=($kat->pelari_kaosfinish == 'L')? 'selected' : ''?> value="L">L</option>
                  <option <?=($kat->pelari_kaosfinish == 'XL')? 'selected' : ''?> value="XL">XL</option>
                  <option <?=($kat->pelari_kaosfinish == 'XXL')? 'selected' : ''?> value="XXL">XXL</option>
                </select>
                <label for="tb-kaosfinish">Finisher Jacket</label>

                <button type="button" 
                  data-bs-toggle="modal" 
                  data-title="Detail Ukuran" 
                  data-href="<?=base_url('modal/ukurankaosfinnish')?>" 
                  data-bs-target="#ajax-modal" class="btn btn-info mt-2">
                  <i class="ti ti-shirt"></i> Lihat Ukuran
                </button>
              </div>
            </div>

            <div class="col-12">
              <div class="d-md-flex align-items-center mt-3">
                <div class="ms-auto mt-3 mt-md-0">
                  <?php if ((get('group_add') == 'true') || (get('edit_member') == 'true')){ ?>
                    <a href="<?=base_url('page/daftar')?>" id="bck" class="btn btn-warning font-medium rounded-pill px-4">
                      <div class="d-flex align-items-center">
                        <i class="ti ti-arrow-left me-2 fs-4"></i>
                        Kembali Ke List Group
                      </div>
                    </a>
                  <?php } ?>
                  <button type="submit" class="btn btn-info font-medium rounded-pill px-4">
                    <div class="d-flex align-items-center">
                      <i class="ti ti-device-floppy me-2 fs-4"></i>
                      Simpan
                    </div>
                  </button>
                  
                </div>
              </div>
            </div>
          </div>
        <?=form_close();?>
      </div>
    </div>
	</div>
</div>

<script type="text/javascript">
  $(".angka").keypress(function(data){
      if (data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)) 
      {
          return false;
      }
  });
	$('#pelari').submit(function(event) {
		event.preventDefault();
		$('body').loading();
		$.ajax({
		  url: '<?=base_url('userdata/save_pelari') ?>',
		  type: 'post',
		  dataType: 'json',
		  data: $('#pelari').serialize(), 
		})
		.done(function( data ) {
		  Swal.fire({
		    title: data.heading,
		    html: data.message,
		    icon: data.type
		  }).then(function(){
		    if (data.status) {
          location.href = '<?=base_url('page/index')?>';
        }
		  })
		})
		.always(function(){
		  $('body').loading('stop');
		});
	});

</script>
<?php }else{ 
  redirect('', 'refresh');
  /*
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card">
          <div class="card-body">
            <h2>Data Saya</h2>
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
                      data-title="Tiket KHM 2027" 
                      data-href="<?=base_url('modal/qrcode?bib='.$userdata->pelari_bib)?>" 
                      data-bs-target="#ajax-modal" class="btn btn-info mt-2">
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
                      data-bs-target="#ajax-modal" class="btn btn-info mt-2">
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
    </div>
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
  </div>
*/ } ?>