<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card">
      <div class="card-body">
        <?=form_open('', ['id' => 'pelari']);?>
      	<?php 
      		if (get('is_dup') == 'true'){}else{echo form_hidden('id', get('id'));}
      		if (get('id') != ''){
            $this->db->join('master_user', 'user_id = pelari_user', 'left');
            $this->db->join('master_city', 'pelari_kota = city_id', 'left');
            $this->db->join('master_group', 'group_id = pelari_group', 'left');
            $this->db->join('master_kategori', 'kategori_id = pelari_kategori', 'left');
      			$this->db->where('pelari_id', get('id'));
      			$kat = $this->db->get('master_pelari')->row();
      		}else{
      			$kat = new \stdClass();
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
            $kat->pelari_club = '';
            $kat->group_user = '';
            $kat->kategori_kategori = '';

      		}
      	?>
          <div class="row">
          <?php 
            if ((userid() == '1') && (get('id') == '')){
          ?>
            <div class="col-md-12">
              <h6>-- Info Login --</h6>
                <div class="row">
                  <div class="col-6">
                    <div class="form-floating mb-3">
                      <input type="text" name="email" class="form-control" id="tb-email" value="<?=$kat->user_email?>" placeholder="" />
                      <label for="tb-email">Email</label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-floating mb-3">
                      <input type="password" name="password" class="form-control" id="tb-password" placeholder="Masukkan Apabila Ingin Ubah Password" />
                      <label for="tb-password">Password</label>
                    </div>
                  </div>
                </div>
            </div>
            <hr>
          <?php } ?>

            <div class="col-md-6">
              <h6>-- Info Kontak Pribadi --</h6>
              <div class="form-floating mb-3">
                <input type="text" name="name" class="form-control" id="tb-name" value="<?=$kat->pelari_name?>" placeholder="" />
                <label for="tb-name">Nama Lengkap</label>
              </div>

              <div class="form-floating mb-3">
                <input type="text" name="identitas" class="form-control angka" id="tb-identitas" value="<?=$kat->pelari_identitas?>" placeholder="" />
                <label for="tb-identitas">Nomor Identitas</label>
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

              <script type="text/javascript">
                $(".angka").keypress(function(data){
                    if (data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)) 
                    {
                        return false;
                    }
                });
              </script>

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

              <div class="form-floating mb-3" id="div_ket" style="display:<?=($kat->pelari_riwayat == 'T')? 'block' : 'none'?>">
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

              <script type="text/javascript">
                $('#tb-tgllahir').change(function(event) {
                  $('#tb-kategori').html('<select name="kategori" class="form-control" id="tb-kategori" placeholder=""><option value="" selected disabled>PILIH </option></select>');
                  $('#show_kaos').hide();
                  $.ajax({
                    url: '<?=base_url('maindata/getkategori')?>',
                    type: 'get',
                    dataType: 'json',
                    data: {id: $(this).val(),kategori: '1'},
                  })
                  .done(function(data) {
                    select = document.getElementById('tb-kategori');
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
                <select type="date" name="kategori" class="form-control" id="tb-kategori" placeholder="">
                  <option selected disabled>PILIH</option>
                  <?php 
                      // $this->db->where('kategori_status', '1');
                      $get = $this->db->get('master_kategori');
                      foreach ($get->result() as $kategorilari) {
                        $selected = ($kategorilari->kategori_id == $kat->pelari_kategori)? 'selected' : '';
                        echo '<option '.$selected.' value="'.$kategorilari->kategori_id.'|'.$kategorilari->kategori_kaosfinish.'|'.$kategorilari->kategori_kategori.'">'.$kategorilari->kategori_name.'</option>';  
                      }
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
              </div>

              <script type="text/javascript">
                $('#tb-kategori').change(function(event) {
                  val = $(this).val().split('|');
                  
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
                <select type="date" name="pelari_kaosfinish" class="form-control" id="tb-kaosfinish" placeholder="">
                  <option selected disabled>PILIH</option>
                  <option <?=($kat->pelari_kaosfinish == 'S')? 'selected' : ''?> value="S">S</option>
                  <option <?=($kat->pelari_kaosfinish == 'M')? 'selected' : ''?> value="M">M</option>
                  <option <?=($kat->pelari_kaosfinish == 'L')? 'selected' : ''?> value="L">L</option>
                  <option <?=($kat->pelari_kaosfinish == 'XL')? 'selected' : ''?> value="XL">XL</option>
                  <option <?=($kat->pelari_kaosfinish == 'XXL')? 'selected' : ''?> value="XXL">XXL</option>
                </select>
                <label for="tb-kaosfinish">Finisher Jacket</label>
              </div>


            </div>

            <div class="col-12">
              <div class="d-md-flex align-items-center mt-3">
                <div class="ms-auto mt-3 mt-md-0">
                  <button
                    type="submit"
                    class="btn btn-info font-medium rounded-pill px-4"
                  >
                    <div class="d-flex align-items-center">
                      <i class="ti ti-device-floppy me-2 fs-4"></i>
                      Simpan
                    </div>
                  </button>
                  <?php if ((get('id') != '') && ($kat->pelari_bib == null)){?>
                  <button
                    type="button"
                    class="btn btn-danger font-medium rounded-pill px-4 todo"
                  >
                    <div class="d-flex align-items-center">
                      <i class="ti ti-credit-card-off me-2 fs-4"></i>
                      By Pass Pembayaran
                    </div>
                  </button>
                <?php } ?>
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
	$('#pelari').submit(function(event) {
		event.preventDefault();
		$('body').loading();
		$.ajax({
		  url: '<?=base_url('admindata/save_pelari') ?>',
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
		    if (data.status) {location.reload();}
		  })
		})
		.always(function(){
		  $('body').loading('stop');
		});
	});

  $('.todo').click(function(event) {
    id = '<?=get('id')?>';
    Swal.fire({
      title: 'Apakah Anda Yakin ?',
      text: "",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Tidak'
    }).then((result) => {
      if (result.value) {
        $('body').loading();
        $.ajax({
          url: '<?=base_url('admindata/by_pass')?>',
          type: 'post',
          dataType: 'json',
          data: {id},
        })
        .done(function(data) { 
          Swal.fire({
            title: data.heading,
            html: data.message,
            icon: data.type,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500
          }).then(function(){
            if (data.status){location.reload()}
          });
          
        })
        .always(function() {
          $('body').loading('stop');
        });  
      }
    });
  });

</script>