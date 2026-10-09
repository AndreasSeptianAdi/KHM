<form id="loginForm">
  <label for="email">Email</label>
  <input type="text" class="form-control" name="username" id="email" aria-describedby="emailHelp">

  <label for="password">Kata Sandi</label>
  <input type="password" class="form-control" name="password" id="password">
  <a href="<?=base_url('auth/forgot')?>">Lupa Password ?</a>
  <button style="margin-top: 20px;" type="submit">Masuk Sekarang</button>
</form>

<?php 
  if (date('Y-m-d H:i') <= date('Y-m-d H:i', strtotime(option('last_regis')))) {
?>
<div class="meta">
  <?php 
    if (date('Y-m-d H:i') <= date('Y-m-d H:i', strtotime(option('last_regis')))) {
  ?>
  Belum punya akun? <a href="<?=base_url('auth/register')?>">Daftar di sini</a>
  <?php } ?>
</div>
<?php } ?>

<script type="text/javascript">
	$('#loginForm').submit(function(event) {
		event.preventDefault();
		$('body').loading();
		$.ajax({
		  url: '<?=base_url('userdata/do_login') ?>',
		  type: 'post',
		  dataType: 'json',
		  data: $('#loginForm').serialize(),
		})
		.done(function( data ) {
		  Swal.fire({
		    title: data.heading,
		    html: data.message,
		    icon: data.type,
        showClass: {
          popup: `
            animate__animated
            animate__fadeInUp
            animate__normal
          `
        },
        hideClass: {
          popup: `
            animate__animated
            animate__fadeOutRight
            animate__faster
          `
        }
		  }).then(function(){
		    if (data.status) {
          location.href= "<?=base_url('')?>"+data.redirect;
        }
		  })
		})
		.always(function(){
		  $('body').loading('stop');
		});
	});
</script>