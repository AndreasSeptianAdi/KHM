<?php $this->load->view('auth/inc_queue_gate'); ?>
<div id="loginWrap">
<form id="loginForm">
  <label for="email">Email</label>
  <input type="text" class="form-control" name="username" id="email" aria-describedby="emailHelp">

  <label for="password">Kata Sandi</label>
  <input type="password" class="form-control" name="password" id="password">
  <a href="<?=base_url('auth/forgot')?>">Lupa Password ?</a>
  <button style="margin-top: 20px;" type="submit">Masuk Sekarang</button>
</form>
</div>

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
		if (window.__queueCanLogin === false) {
			Swal.fire({
				title: 'Masih Dalam Antrean',
				html: 'Slot login penuh. Akun <b>admin dikecualikan</b> dan tetap bisa masuk.<br>Lanjutkan login?',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Tetap Login',
				cancelButtonText: 'Tunggu Giliran'
			}).then(function(res){
				if (res.value) { doLoginSubmit(); }
			});
			return;
		}
		doLoginSubmit();
	});

	function doLoginSubmit(){
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
	}
</script>