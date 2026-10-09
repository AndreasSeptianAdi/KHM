<?=form_open('', ['id' => 'ok']);?>
<?=form_hidden('opt_name', get('opt_name'));?>
<div class="card">
	<div class="card-body">
<div class="row">
	<div class="col-md-12">
    <div class="form-floating mb-3">
      <input type="date" class="form-control" name="idate" id="tb-date" value='<?=date('Y-m-d', strtotime(option(get('opt_name'))))?>'
      />
      <label for="tb-date">Tanggal</label>
    </div>
  </div>
  <div class="col-md-12">
    <div class="form-floating mb-3">
      <input type="time" class="form-control" name="itime" id="tb-time" value='<?=date('H:i', strtotime(option(get('opt_name'))))?>'
      />
      <label for="tb-time">Jam</label>
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
	$('#ok').submit(function(event) {
		event.preventDefault();
		$('body').loading();
		$.ajax({
		  url: '<?=base_url('admindata/ubah_option') ?>',
		  type: 'post',
		  dataType: 'json',
		  data: $('#ok').serialize(),
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