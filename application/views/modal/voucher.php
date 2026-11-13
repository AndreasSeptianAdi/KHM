<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card">
      <div class="card-body">
        <?=form_open('', ['id' => 'voucher']);?>
          <div class="row">
            <div class="col-md-8">
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
            <div class="col-md-4">
              <div class="form-floating mb-3">
                <input
                  type="number"
                  name="qty"
                  class="form-control"
                  id="tb-qty"
                  min="1"
                  max="500"
                  value="1"
                  placeholder="Jumlah Voucher"
                />
                <label for="tb-qty">Jumlah Voucher (QTY)</label>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-floating mb-3">
                <input
                  type="text"
                  name="batch"
                  class="form-control"
                  id="tb-batch"
                  placeholder="Nama Batch"
                />
                <label for="tb-batch">Nama Batch / Label</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating mb-3">
                <input
                  type="datetime"
                  name="expired"
                  class="form-control"
                  id="tb-expired"
                  placeholder="2027-08-31 23:59:59"
                />
                <label for="tb-expired">Berlaku Sampai</label>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-floating mb-3">
                <input
                  type="text"
                  name="note"
                  class="form-control"
                  id="tb-note"
                  placeholder="Catatan"
                />
                <label for="tb-note">Catatan</label>
              </div>
            </div>

            <div class="col-12">
              <div class="alert alert-info">
                <i class="ti ti-info-circle"></i>
                Kode voucher dibuat acak <b>16 karakter alfanumerik</b> dan dijamin unik.
                Setelah berhasil dibuat, <b>sisa kuota kategori otomatis berkurang sejumlah QTY</b>
                (kalau kuota tidak cukup, pembuatan dibatalkan dan kuota tidak tersentuh).
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

  $('#tb-kategori').change(function(event) {
    sisa_kuota = parseInt($(this).find(':selected').data('kuota'));
    if (isNaN(sisa_kuota)) { sisa_kuota = 0; }
    $('#tb-qty').attr('max', sisa_kuota);
    if (parseInt($('#tb-qty').val()) > sisa_kuota){
      $('#tb-qty').val(sisa_kuota);
    }
    $('#info_kuota').text('Sisa kuota kategori terpilih: ' + sisa_kuota + ' voucher.');
  });

	$('#voucher').submit(function(event) {
		event.preventDefault();

		if ($('#tb-kategori').val() == '' || $('#tb-kategori').val() == null){
		  Swal.fire({ title: 'Kategori Lomba Belum Dipilih', icon: 'warning' });
		  return;
		}
		var qty = parseInt($('#tb-qty').val());
		if (isNaN(qty) || qty < 1){
		  Swal.fire({ title: 'QTY minimal 1', icon: 'warning' });
		  return;
		}
		if (qty > sisa_kuota){
		  Swal.fire({ title: 'QTY melebihi sisa kuota (' + sisa_kuota + ')', icon: 'warning' });
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
