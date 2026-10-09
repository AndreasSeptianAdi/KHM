<?=form_open('', ['id' => 'oktext']);?>
<?=form_hidden('opt_name', get('opt_name'));?>
<div class="card">
	<div class="card-body">
<div class="row">
	<div class="col-md-12">
    <div class="form-floating mb-3">
      <input type="text" class="form-control" name="ovalue" id="tb-ovalue" value='<?=htmlspecialchars(option(get('opt_name')))?>'
      />
      <label for="tb-ovalue">Nilai (<?=htmlspecialchars(get('opt_name'))?>)</label>
    </div>
  </div>

  <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
  	<button class="btn btn-success" type="submit">Simpan</button>
  </div>
</div>
</div>
</div>
<?=form_close();?>

<script type="text/javascript">
	$('#oktext').submit(function(event) {
		event.preventDefault();
		$('body').loading();
		$.ajax({
		  url: '<?=base_url('admindata/ubah_option_text') ?>',
		  type: 'post',
		  dataType: 'json',
		  data: $('#oktext').serialize(),
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
