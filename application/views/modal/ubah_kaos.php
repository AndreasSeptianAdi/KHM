<?=form_open('', ['id' => 'ok']);?>
<?php 
		$this->db->join('master_kategori', 'kategori_id = pelari_kategori', 'left');
    $this->db->where('pelari_id', get('id'));
    $kat = $this->db->get('master_pelari')->row();
?>
<?=form_hidden('pelari_id', get('id'));?>
<div class="row">
	<div class="col-md-12">
    <div class="form-floating mb-3">
      <select type="date" name="kaos" class="form-control" id="tb-kaos" placeholder="">
        <option selected disabled>PILIH</option>
        <option <?=($kat->pelari_kaos == 'XS')? 'selected' : ''?> value="XS">XS</option>
        <option <?=($kat->pelari_kaos == 'S')? 'selected' : ''?> value="S">S</option>
        <option <?=($kat->pelari_kaos == 'M')? 'selected' : ''?> value="M">M</option>
        <option <?=($kat->pelari_kaos == 'L')? 'selected' : ''?> value="L">L</option>
        <option <?=($kat->pelari_kaos == 'XL')? 'selected' : ''?> value="XL">XL</option>
        <option <?=($kat->pelari_kaos == '2XL')? 'selected' : ''?> value="2XL">2XL</option>
      </select>
      <label for="tb-kaos">Ukuran Kaos</label>
    </div>
  </div>
  <?php if ($kat->kategori_kaosfinish == 'T'){ ?>
  <div class="col-md-12">
    <div class="form-floating mb-3">
      <select type="date" name="kaosfinish" class="form-control" id="tb-finish" placeholder="">
        <option selected disabled>PILIH</option>
        <option <?=($kat->pelari_kaosfinish == 'XS')? 'selected' : ''?> value="XS">XS</option>
        <option <?=($kat->pelari_kaosfinish == 'S')? 'selected' : ''?> value="S">S</option>
        <option <?=($kat->pelari_kaosfinish == 'M')? 'selected' : ''?> value="M">M</option>
        <option <?=($kat->pelari_kaosfinish == 'L')? 'selected' : ''?> value="L">L</option>
        <option <?=($kat->pelari_kaosfinish == 'XL')? 'selected' : ''?> value="XL">XL</option>
        <option <?=($kat->pelari_kaosfinish == '2XL')? 'selected' : ''?> value="2XL">2XL</option>
      </select>
      <label for="tb-finish">Ukuran Jaket Finish</label>
    </div>
  </div>
	<?php } ?>

  <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
  	<button class="btn btn-success" type="submit">Simpan</button>
  </div>
</div>
<?=form_close();?>

<script type="text/javascript">
	$('#ok').submit(function(event) {
		event.preventDefault();
		$('body').loading();
		$.ajax({
		  url: '<?=base_url('admindata/ubah_kaos') ?>',
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