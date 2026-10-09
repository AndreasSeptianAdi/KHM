
<?php if (get('email') == 'done') { ?>
	<form id="forgot_code">
    <div class="mb-3">
      <label for="code" class="form-label">Masukkan Kode</label>
      <input type="text" name="code" class="form-control" id="code" aria-describedby="emailHelp">
    </div>
    <div class="mb-4">
      <label for="password" class="form-label">Password Baru</label>
      <input type="password" name="password" class="form-control" id="password">
    </div>
    <div class="mb-4">
      <label for="ulangi_password" class="form-label">Ulangi Password Baru</label>
      <input type="password" name="repassword" class="form-control" id="ulangi_password">
    </div>
    <button type="sumbit" class="btn btn-primary w-100 py-8 mb-3">Ganti Password</button>
  </form>
<?php }else{ ?>
  <form id="forgot" style="margin-bottom: 20px;">
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Email address</label>
      <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    </div>
    <button type="sumbit" class="btn btn-primary w-100 py-8 mb-3">Kirim Kode</button>
  </form>
<?php } ?>
  <a href="<?=base_url('')?>" class="btn btn-light-primary text-primary w-100 py-8"> << Kembali Ke Login</a>


<script type="text/javascript">
	$('#forgot').submit(function(event) {
		event.preventDefault();
		$('body').loading();
		$.ajax({
		  url: '<?=base_url('userdata/do_forgot') ?>',
		  type: 'post',
		  dataType: 'json',
		  data: $('#forgot').serialize(),
		})
		.done(function( data ) {
		  Swal.fire({
		    title: data.heading,
		    html: data.message,
		    icon: data.type
		  }).then(function(){
		    if (data.status) {location.href="?email=done";}
		  })
		})
		.always(function(){
		  $('body').loading('stop');
		});
	});

	$('#forgot_code').submit(function(event) {
		event.preventDefault();
		$('body').loading();
		$.ajax({
		  url: '<?=base_url('userdata/do_reset_pass') ?>',
		  type: 'post',
		  dataType: 'json',
		  data: $('#forgot_code').serialize(),
		})
		.done(function( data ) {
		  Swal.fire({
		    title: data.heading,
		    html: data.message,
		    icon: data.type
		  }).then(function(){
		    if (data.status) {location.href="<?=base_url()?>";}
		  })
		})
		.always(function(){
		  $('body').loading('stop');
		});
	});
</script>