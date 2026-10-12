<?=form_open('', ['id' => 'oktext']);?>
<?=form_hidden('opt_name', get('opt_name'));?>
<?php
	$opt_val = option(get('opt_name'));
?>
<div class="card">
	<div class="card-body">
<div class="row">
	<div class="col-md-12">
    <div class="form-floating mb-3">
      <label for="tb-ovalue">Status</label>
	  <?php
		if (get('opt_name') != 'queue_max'){
	  ?>
	  <select name="ovalue" id="tb-ovalue" class="form-control">
		<option value="0" <?=($opt_val == 0)? 'selected' : ''?>>Tidak Aktif</option>
		<option value="1" <?=($opt_val == 1)? 'selected' : ''?>>Aktif</option>
	  </select>
	  <?php
		}else{
	  ?>
		<input type="text" class="form-control" name="ovalue" id="tb-ovalue" value='<?=htmlspecialchars(option(get('opt_name')))?>'/>
	  <?php
		}
	  ?>
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
