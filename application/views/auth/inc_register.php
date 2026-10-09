<?php 
  if (date('Y-m-d H:i') >= date('Y-m-d H:i', strtotime(option('last_regis')))) {
  	redirect(base_url(),'refresh');
  }
?>

  <form id="register">
    <div class="mb-3">
      <label for="email" class="form-label">E-Mail</label>
      <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp">
    </div>
    <div class="mb-4">
      <label for="password" class="form-label">Password</label>
      <input type="password" name="password" class="form-control" id="password">
    </div>
    <div class="mb-4">
      <label for="ulangi_password" class="form-label">Ulangi Password</label>
      <input type="password" name="repassword" class="form-control" id="ulangi_password">
    </div>
    <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Sign Up</button>
    <div class="d-flex align-items-center">
      <p class="fs-4 mb-0 text-dark">Sudah Punya Akun? <a class="text-primary fw-medium ms-2" href="<?=base_url()?>">Sign In</a></p>
      
    </div>
  </form>

<script type="text/javascript">
	$('#register').submit(function(event) {
		event.preventDefault();
		$('body').loading();
		$.ajax({
		  url: '<?=base_url('userdata/do_register') ?>',
		  type: 'post',
		  dataType: 'json',
		  data: $('#register').serialize(),
		})
		.done(function( data ) {
		  Swal.fire({
		    title: data.heading,
		    html: data.message,
		    icon: data.type
		  }).then(function(){
		    if (data.status) {location.href='<?=base_url('')?>';}
		  })
		})
		.always(function(){
		  $('body').loading('stop');
		});
	});
</script>