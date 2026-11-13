<?php
  $kode_voucher = $voucher->voucher_code;
  $kaos_finish  = ($kategori->kategori_kaosfinish == 'T');
  $is_pelajar   = ($kategori->kategori_kategori == 'pelajar');
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="d-sm-flex d-block align-items-center justify-content-between mb-7">
            <div class="mb-3 mb-sm-0">
              <h5 class="card-title fw-semibold">Registrasi Voucher</h5>
            </div>
          </div>

<div class="alert alert-success">
  <i class="ti ti-circle-check"></i> <b>Voucher Terverifikasi</b>
  <div class="row mt-2">
    <div class="col-md-3">Kode Voucher<br><span class="kode-voucher"><?=html_escape($kode_voucher)?></span></div>
    <div class="col-md-3">Kategori Lomba<br><b><?=html_escape($kategori->kategori_name)?></b></div>
    <div class="col-md-3">Tipe Kategori<br><b><?=humanize($kategori->kategori_kategori)?></b></div>
    <div class="col-md-3">Terdaftar Sebagai<br><b><?=html_escape($this->session->userdata('user_email'))?></b></div>
  </div>
  <small>
    Pendaftaran ini <b>GRATIS</b>. Kategori lari sudah terkunci sesuai voucher dan tidak dapat diubah.
    Nomor BIB dan QR code akan dikirim ke email di atas.
  </small>
</div>

<?=form_open('', ['id' => 'pelari']);?>
  <?=form_hidden('voucher_code', $kode_voucher);?>

  <div class="row">
    <div class="col-md-6">
      <h6>-- Info Kontak Pribadi --</h6>
      <div class="form-floating mb-3">
        <input type="text" name="name" class="form-control" id="tb-name" placeholder="" />
        <label for="tb-name">Nama Lengkap</label>
      </div>

      <div class="form-floating mb-3">
        <input type="text" name="identitas" class="form-control angka" id="tb-identitas" placeholder="" />
        <label for="tb-identitas">Nomor Identitas (KTP/KIA/NIK)</label>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-floating mb-3">
            <select name="sex" class="form-control" id="tb-sex">
              <option selected disabled value="">PILIH</option>
              <option value="L">Laki-Laki</option>
              <option value="P">Perempuan</option>
            </select>
            <label for="tb-sex">Jenis Kelamin</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating mb-3">
            <select name="goldar" class="form-control" id="tb-goldar">
              <option selected disabled value="">PILIH</option>
              <option value="0">0</option>
              <option value="A">A</option>
              <option value="B">B</option>
              <option value="AB">AB</option>
            </select>
            <label for="tb-goldar">Golongan Darah</label>
          </div>
        </div>
      </div>

      <div class="form-floating mb-3">
        <input type="date" name="tgllahir" class="form-control" id="tb-tgllahir" placeholder="" />
        <label for="tb-tgllahir">Tanggal Lahir</label>
      </div>

      <div class="form-floating mb-3">
        <select name="provinsi" class="form-control" id="tb-provinsi">
          <option selected disabled value="">PILIH</option>
          <?php
            $provinsi = $this->db->get('master_provinsi');
            foreach ($provinsi->result() as $data_province) {
              echo '<option value="'.$data_province->provinsi_id.'">'.html_escape($data_province->provinsi_nama).'</option>';
            }
          ?>
        </select>
        <label for="tb-provinsi">Provinsi</label>
      </div>

      <div class="form-floating mb-3">
        <select name="city" class="form-control" id="tb-city">
          <option value="" selected disabled>PILIH</option>
        </select>
        <label for="tb-city">Kota</label>
      </div>

      <div class="form-floating mb-3">
        <input type="text" name="telp" class="form-control angka" id="tb-telp" placeholder="" />
        <label for="tb-telp">Nomor Telp</label>
      </div>

      <div class="form-floating mb-3">
        <input type="text" name="alamat" class="form-control" id="tb-alamat" placeholder="" />
        <label for="tb-alamat">Alamat Lengkap</label>
      </div>
    </div>

    <div class="col-md-6">
      <h6>-- Info Detail --</h6>

      <div class="form-floating mb-3">
        <input type="text" name='namabib' class="form-control" id="tb-namabib" placeholder="" />
        <label for="tb-namabib">Nama BIB</label>
      </div>

      <div class="form-floating mb-3">
        <select name="riwayat" class="form-control" id="tb-riwayat">
          <option selected disabled value="">PILIH</option>
          <option value="T">Ya</option>
          <option value="F">Tidak</option>
        </select>
        <label for="tb-riwayat">Riwayat Sakit Berat</label>
      </div>

      <div class="form-floating mb-3" id="div_ket" style="display:none">
        <input type="text" name='ketriwayat' class="form-control" id="tb-ketriwayat" placeholder="" />
        <label for="tb-ketriwayat">Ket. Riwayat Sakit</label>
      </div>

      <div class="form-floating mb-3">
        <input type="text" name='namadarurat' class="form-control" id="tb-namadarurat" placeholder="" />
        <label for="tb-namadarurat">Nama Kontak Darurat</label>
      </div>

      <div class="form-floating mb-3">
        <input type="text" name='tlpdarurat' class="form-control angka" id="tb-tlpdarurat" placeholder="" />
        <label for="tb-tlpdarurat">Nomor Kontak Darurat</label>
      </div>

      <div class="form-floating mb-3">
        <select class="form-control" id="tb-kategori" disabled>
          <option selected value=""><?=html_escape($kategori->kategori_name)?> (Terkunci Sesuai Voucher)</option>
        </select>
        <label for="tb-kategori">Kategori Lari</label>
      </div>

      <div class="form-floating mb-3">
        <select name="kaos" class="form-control" id="tb-kaos">
          <option selected disabled value="">PILIH</option>
          <option value="XXS">XXS</option>
          <option value="XS">XS</option>
          <option value="S">S</option>
          <option value="M">M</option>
          <option value="L">L</option>
          <option value="XL">XL</option>
          <option value="XXL">XXL</option>
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

      <?php if ($is_pelajar){ ?>
      <div class="form-floating mb-3">
        <input type="text" name='asalsekolah' class="form-control" id="tb-asalsekolah" placeholder="" />
        <label for="tb-asalsekolah">Asal Sekolah</label>
      </div>
      <?php } ?>

      <?php if ($kaos_finish){ ?>
      <div class="form-floating mb-3">
        <select name="kaosfinish" class="form-control" id="tb-kaosfinish">
          <option selected disabled value="">PILIH</option>
          <option value="S">S</option>
          <option value="M">M</option>
          <option value="L">L</option>
          <option value="XL">XL</option>
          <option value="XXL">XXL</option>
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
      <?php } ?>
    </div>

    <div class="col-12">
      <div class="d-md-flex align-items-center mt-3">
        <div class="ms-auto mt-3 mt-md-0">
          <a href="<?=base_url('voucher/reset')?>" class="btn btn-warning font-medium rounded-pill px-4 me-2">
            <div class="d-flex align-items-center">
              <i class="ti ti-arrow-left me-2 fs-4"></i>
              Ganti Voucher
            </div>
          </a>
          <button type="submit" class="btn btn-info font-medium rounded-pill px-4">
            <div class="d-flex align-items-center">
              <i class="ti ti-device-floppy me-2 fs-4"></i>
              Daftar Sekarang
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
</div>

<script type="text/javascript">
  $(".angka").keypress(function(data){
      if (data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
      {
          return false;
      }
  });

  $('#tb-riwayat').change(function(event) {
    if ($(this).val() == 'T'){
      $('#div_ket').show();
    }else{
      $('#div_ket').hide();
    }
  });

  // ambil daftar kota mengikuti provinsi terpilih
  $('#tb-provinsi').change(function(event) {
    $('#tb-city').html('<option value="" selected disabled>PILIH</option>');
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

	$('#pelari').submit(function(event) {
		event.preventDefault();
		$('body').loading();
		$.ajax({
		  url: '<?=base_url('voucher/simpan')?>',
		  type: 'post',
		  dataType: 'json',
		  data: $('#pelari').serialize(),
		})
		.done(function( data ) {
		  Swal.fire({
		    title: (data.status)? 'Pendaftaran Berhasil' : 'Pendaftaran Gagal',
		    html: data.message,
		    icon: data.type,
		    allowOutsideClick: false
		  }).then(function(){
		    if (data.status) {
		      location.href = data.redirect;
		    }
		  })
		})
		.fail(function() {
		  Swal.fire({
		    title: 'Terjadi Kesalahan',
		    html: 'Terjadi kesalahan pada server, silahkan coba beberapa saat lagi.',
		    icon: 'error'
		  });
		})
		.always(function(){
		  $('body').loading('stop');
		});
	});
</script>
