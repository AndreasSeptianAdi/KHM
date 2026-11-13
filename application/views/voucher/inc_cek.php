<div class="text-center mb-4">
  <h5 class="card-title fw-semibold">Cek Keaslian Voucher</h5>
  <p class="text-muted">
    Masukkan <b>16 karakter</b> kode voucher yang Anda terima.<br>
    Setelah kode terverifikasi, Anda akan diarahkan untuk mengisi data pelari.
  </p>
</div>

<?=form_open('', ['id' => 'form_cek']);?>
  <div class="row justify-content-md-center">
    <div class="col-md-8">
      <div class="form-floating mb-3">
        <input
          type="text"
          name="kode"
          class="form-control kode-voucher"
          id="tb-kode"
          value="<?=html_escape($prefill)?>"
          maxlength="20"
          autocomplete="off"
          placeholder="Kode Voucher"
        />
        <label for="tb-kode">Kode Voucher</label>
      </div>

      <button type="submit" class="btn btn-info font-medium rounded-pill px-4 w-100">
        <div class="d-flex align-items-center justify-content-center">
          <i class="ti ti-search me-2 fs-4"></i>
          Cek Voucher
        </div>
      </button>

      <div class="alert alert-secondary mt-4 mb-0">
        <i class="ti ti-info-circle"></i>
        Satu voucher hanya berlaku untuk <b>satu pelari</b>.
        Apabila kode ditolak, pastikan tidak ada spasi berlebih dan hubungi panitia.
      </div>
    </div>
  </div>
<?=form_close();?>

<script type="text/javascript">
  // paksa huruf besar & buang karakter yang tidak perlu saat mengetik
  $('#tb-kode').on('input', function() {
    var bersih = $(this).val().toUpperCase().replace(/[^A-Z0-9]/g, '');
    $(this).val(bersih);
  });

	$('#form_cek').submit(function(event) {
		event.preventDefault();

		if ($('#tb-kode').val().length != 16){
		  Swal.fire({ title: 'Kode Belum Lengkap', html: 'Kode voucher harus terdiri dari 16 karakter.', icon: 'warning' });
		  return;
		}

		$('body').loading();
		$.ajax({
		  url: '<?=base_url('voucher/cek')?>',
		  type: 'post',
		  dataType: 'json',
		  data: $('#form_cek').serialize(),
		})
		.done(function( data ) {
		  if (data.status){
		    Swal.fire({
		      title: 'Voucher Asli',
		      html: data.message + '<br>Anda akan diarahkan ke form data pelari...',
		      icon: data.type,
		      timer: 1800,
		      showConfirmButton: false
		    }).then(function(){
		      location.href = data.redirect;
		    });
		  }else{
		    Swal.fire({
		      title: 'Voucher Tidak Valid',
		      html: data.message,
		      icon: data.type
		    });
		  }
		})
		.always(function(){
		  $('body').loading('stop');
		});
	});
</script>
