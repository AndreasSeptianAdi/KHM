<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card">
      <div class="card-body">
        <?=form_open('', ['id' => 'voucher']);?>
          <div class="row">
            <!-- 1. NAMA NASABAH -->
            <div class="col-md-6">
              <div class="form-floating mb-3">
                <input
                  type="text"
                  name="nasabah"
                  class="form-control"
                  id="tb-nasabah"
                  maxlength="100"
                  autocomplete="off"
                  placeholder="Nama Nasabah"
                />
                <label for="tb-nasabah">Nama Nasabah</label>
              </div>
            </div>

            <!-- 2. NOMOR REKENING -->
            <div class="col-md-6">
              <div class="form-floating mb-3">
                <input
                  type="text"
                  name="norekening"
                  class="form-control"
                  id="tb-norekening"
                  maxlength="50"
                  inputmode="numeric"
                  autocomplete="off"
                  placeholder="Nomor Rekening"
                />
                <label for="tb-norekening">Nomor Rekening</label>
              </div>
            </div>

            <!-- 3. KATEGORI LOMBA -->
            <div class="col-md-6">
              <div class="form-floating mb-3">
                <select name="kategori" class="form-control" id="tb-kategori">
                  <option selected disabled value="">Pilih</option>
                  <?php
                    $this->db->order_by('kategori_id', 'asc');
                    $this->db->where('kategori_status', '1');
                    foreach ($this->db->get('master_kategori')->result() as $katlari) {
                      $sisa     = (int)$katlari->kategori_kuota;
                      $disabled = ($sisa < 1)? 'disabled' : '';
                      echo '<option '.$disabled.' value="'.$katlari->kategori_id.'" data-kuota="'.$sisa.'">'.html_escape($katlari->kategori_name).' - '.humanize($katlari->kategori_kategori).' (Sisa Kuota: '.$sisa.')</option>';
                    }
                  ?>
                </select>
                <label for="tb-kategori">Kategori Lomba</label>
              </div>
            </div>
            <!-- 4. BANK JATIM CABANG -->
            <div class="col-md-6">
              <div class="form-floating mb-3">
                <input
                  type="text"
                  name="cabang"
                  class="form-control"
                  id="tb-cabang"
                  maxlength="100"
                  list="list_cabang_bankjatim"
                  autocomplete="off"
                  placeholder="Bank Jatim Cabang"
                />
                <label for="tb-cabang">Bank Jatim Cabang</label>
                <!-- hanya saran pengisian, admin tetap bisa mengetik cabang lain -->
                <datalist id="list_cabang_bankjatim">
                  <option value="Kediri"></option>
                  <option value="Kediri Kota"></option>
                  <option value="Pare"></option>
                  <option value="Blitar"></option>
                  <option value="Tulungagung"></option>
                  <option value="Nganjuk"></option>
                  <option value="Jombang"></option>
                  <option value="Mojokerto"></option>
                  <option value="Sidoarjo"></option>
                  <option value="Gresik"></option>
                  <option value="Surabaya"></option>
                  <option value="Malang"></option>
                  <option value="Madiun"></option>
                  <option value="Jember"></option>
                  <option value="Banyuwangi"></option>
                  <option value="Pamekasan"></option>
                </datalist>
              </div>
            </div>

            <!-- 5. BERLAKU SAMPAI (dipatok akhir November 2026, tidak bisa diubah) -->
            <div class="col-md-6">
              <div class="form-floating mb-3">
                <input
                  type="date"
                  name="expired"
                  class="form-control"
                  id="tb-expired"
                  value="2026-11-30"
                  readonly
                />
                <label for="tb-expired">Berlaku Sampai</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="alert alert-secondary mb-3 py-2">
                <i class="ti ti-calendar-event"></i>
                Voucher berlaku sampai <b>30 November 2026</b> pukul 23:59.<br>
                Tanggal ini sudah dipatok otomatis oleh sistem.
              </div>
            </div>

            <div class="col-12">
              <div class="alert alert-info">
                <i class="ti ti-info-circle"></i>
                Setiap kali disimpan, sistem membuat <b>1 (satu) kode voucher</b> acak
                <b>16 karakter alfanumerik</b> yang dijamin unik atas nama nasabah tersebut.
                <b>Sisa kuota kategori otomatis berkurang 1</b>
                (kalau kuota habis, pembuatan dibatalkan dan kuota tidak tersentuh).
                <br><span id="info_kuota" class="fw-semibold"></span>
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
                      <i class="ti ti-ticket me-2 fs-4"></i>
                      Buat Voucher
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
  var sisa_kuota = 0;

  // nomor rekening hanya boleh angka
  $('#tb-norekening').on('input', function() {
    $(this).val($(this).val().replace(/[^0-9]/g, ''));
  });

  $('#tb-kategori').change(function(event) {
    sisa_kuota = parseInt($(this).find(':selected').data('kuota'));
    if (isNaN(sisa_kuota)) { sisa_kuota = 0; }
    $('#info_kuota').text('Sisa kuota kategori terpilih: ' + sisa_kuota + ' voucher.');
  });

	$('#voucher').submit(function(event) {
		event.preventDefault();

		if ($.trim($('#tb-nasabah').val()) == ''){
		  Swal.fire({ title: 'Nama Nasabah Belum Diisi', icon: 'warning' });
		  $('#tb-nasabah').focus();
		  return;
		}
		var rekening = $.trim($('#tb-norekening').val());
		if (rekening == ''){
		  Swal.fire({ title: 'Nomor Rekening Belum Diisi', icon: 'warning' });
		  $('#tb-norekening').focus();
		  return;
		}
		if (!/^[0-9]+$/.test(rekening)){
		  Swal.fire({ title: 'Nomor Rekening Tidak Valid', html: 'Nomor rekening hanya boleh berisi angka.', icon: 'warning' });
		  $('#tb-norekening').focus();
		  return;
		}
		if ($('#tb-kategori').val() == '' || $('#tb-kategori').val() == null){
		  Swal.fire({ title: 'Kategori Lomba Belum Dipilih', icon: 'warning' });
		  return;
		}
		if ($.trim($('#tb-cabang').val()) == ''){
		  Swal.fire({ title: 'Bank Jatim Cabang Belum Diisi', icon: 'warning' });
		  $('#tb-cabang').focus();
		  return;
		}
		if (sisa_kuota < 1){
		  Swal.fire({ title: 'Kuota Kategori Habis', html: 'Sisa kuota kategori terpilih tidak mencukupi.', icon: 'warning' });
		  return;
		}

		$('body').loading();
		$.ajax({
		  url: '<?=base_url('admindata/save_voucher') ?>',
		  type: 'post',
		  dataType: 'json',
		  data: $('#voucher').serialize(),
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
</script>
