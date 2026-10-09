<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card">
      <div class="card-body">
        <?=form_open('', ['id' => 'kategori']);?>
      	<?php 
      		if (get('is_dup') == 'true'){}else{echo form_hidden('id', get('id'));}
      		if (get('id') != ''){
      			$this->db->where('kategori_id', get('id'));
      			$kat = $this->db->get('master_kategori')->row();
      		}else{
      			$kat = new \stdClass();
      			$kat->kategori_name = '';
						$kat->kategori_kategori = '';
						$kat->kategori_price = '';
						$kat->kategori_priceearly = '';
						$kat->kategori_dateearly = '';
						$kat->kategori_kuota = '';
						$kat->kategori_dateexp = '';
            $kat->kategori_datestart = '';
						$kat->kategori_umurmin = '';
						$kat->kategori_umurmax = '';
						$kat->kategori_kaosfinish = '';
            $kat->kategori_status = '';
            $kat->kategori_prefix = '';
            $kat->kategori_startid = '';
      		}
      	?>
          <div class="row">
          	<div class="col-md-12">
              <div class="form-floating mb-3">
                <input
                  type="text"
                  name="name"
                  class="form-control"
                  id="tb-nama"
                  value="<?=$kat->kategori_name;?>"
                  placeholder="Nama Kategori Lari"
                />
                <label for="tb-nama">Nama Kategori</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating mb-3">
                <select
                  type="text"
                  name="kategori"
                  class="form-control"
                  id="tb-kat"
                  placeholder="Enter Name here"
                >
                	<option selected disabled>Pilih</option>
                	<option <?=($kat->kategori_kategori == 'umum')? 'selected' : '' ?> value="umum">Umum</option>
                	<option <?=($kat->kategori_kategori == 'pelajar')? 'selected' : '' ?> value="pelajar">Pelajar</option>
                  <option <?=($kat->kategori_kategori == 'difabel')? 'selected' : '' ?> value="difabel">Difabel</option>
              	</select>
                <label for="tb-kat">Kategori</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating">
                <input
                  type="text"
                  name='harga'
                  class="form-control"
                  id="tb-harga"
                  value="<?=$kat->kategori_price;?>"
                  placeholder=""
                />
                <label for="tb-harga">Harga Normal</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating mb-3">
                <input
                  type="text"
                  name='early'
                  class="form-control"
                  id="tb-hargaearly"
                  value="<?=$kat->kategori_priceearly;?>"
                  placeholder=""
                />
                <label for="tb-hargaearly">Harga Early Bit</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating mb-3">
                <input
                  type="datetime"
                  name='earlydate'
                  class="form-control"
                  id="tb-earlydate"
                  value="<?=$kat->kategori_dateearly;?>"
                  placeholder=""
                />
                <label for="tb-earlydate">Batas Early Bit</label>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="form-floating">
                <input
                  type="number"
                  name="kuota"
                  class="form-control"
                  id="tb-kuota"
                  value="<?=$kat->kategori_kuota;?>"
                  placeholder="Kuota Pelari"
                />
                <label for="tb-kuota">Kuota Pelari</label>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="form-floating">
                <input
                  type="datetime"
                  name="startdates"
                  class="form-control"
                  id="tb-tanggalstart"
                  value="<?=$kat->kategori_datestart;?>"
                  placeholder="Tanggal Start"
                />
                <label for="tb-tanggalstart">Tanggal Awal Register</label>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="form-floating">
                <input
                  type="datetime"
                  name="expired"
                  class="form-control"
                  id="tb-tanggal"
                  value="<?=$kat->kategori_dateexp;?>"
                  placeholder="Tanggal Expired"
                />
                <label for="tb-tanggal">Batas Tanggal Register</label>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="form-floating">
                <input
                  type="number"
                  name="umurmin"
                  class="form-control"
                  id="tb-umur"
                  value="<?=$kat->kategori_umurmin;?>"
                  placeholder="Umur Minimal"
                />
                <label for="tb-umur">Umur Minimal</label>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="form-floating">
                <input
                  type="number"
                  name="umurmax"
                  class="form-control"
                  id="tb-umurmax"
                  value="<?=$kat->kategori_umurmax;?>"
                  placeholder="Umur Minimal"
                />
                <label for="tb-umurmax">Umur Maximal</label>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="form-floating">
                <select
                  type="text"
                  name="kaos"
                  class="form-control"
                  id="tb-nama"
                  placeholder="Enter Name here"
                >
                	<option selected disabled>Pilih</option>
                	<option <?=($kat->kategori_kaosfinish == 'T')? 'selected' : ''?> value="T">Ada</option>
                	<option <?=($kat->kategori_kaosfinish == 'F')? 'selected' : ''?> value="F">Tidak</option>
              	</select>
                <label for="tb-kuota">Kaos Finish ?</label>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-floating">
                <input
                  type="text"
                  name="prefix"
                  class="form-control text-uppercase"
                  id="tb-prefix"
                  value="<?=$kat->kategori_prefix;?>"
                  placeholder="prefix"
                />
                <label for="tb-prefix">Prefix Pernomoran</label>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-floating">
                <input
                  type="text"
                  name="startid"
                  class="form-control angka"
                  id="tb-startid"
                  maxlength = "8"
                  value="<?=$kat->kategori_startid;?>"
                  placeholder="startid"
                />
                <label for="tb-startid">Start Pernomoran</label>
              </div>
            </div>

            <div class="col-12">
              <div class="d-md-flex align-items-center mt-3">
                <?php if (get('id') != ''){ ?>
                  <div class="form-check">
                    <button
                      type="button"
                      class="btn btn-<?=($kat->kategori_dateexp >= date('Y-m-d H:i:s'))? 'warning' : ''?> font-medium rounded-pill px-4 change_status"
                    >
                      <div class="d-flex align-items-center">
                        <i class="ti ti-<?=($kat->kategori_dateexp >= date('Y-m-d H:i:s'))? 'x' : ''?> me-2 fs-4"></i>
                        <?=($kat->kategori_dateexp <= date('Y-m-d H:i:s'))? '' : 'Close Pendaftaran'; ?>
                      </div>
                    </button>
                  </div>
                <?php } ?>
                <div class="ms-auto mt-3 mt-md-0">
                  <button
                    type="submit"
                    class="btn btn-info font-medium rounded-pill px-4"
                  >
                    <div class="d-flex align-items-center">
                      <i class="ti ti-device-floppy me-2 fs-4"></i>
                      Simpan
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
  $(".angka").keypress(function(data){
    if (data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)) 
    {
      return false;
    }
  });
	$('#kategori').submit(function(event) {
		event.preventDefault();
		$('body').loading();
		$.ajax({
		  url: '<?=base_url('admindata/save_kategori') ?>',
		  type: 'post',
		  dataType: 'json',
		  data: $('#kategori').serialize(),
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

  $('.change_status').click(function(event) {
    event.preventDefault();
    $('body').loading();
    table='kategori';
    id='<?=get('id')?>';
    content='<?=$kat->kategori_status?>';
    $.ajax({
      url: '<?=base_url('admindata/change_status_kat') ?>',
      type: 'post',
      dataType: 'json',
      data: {table,id,content},
    })
    .done(function( data ) {
      Swal.fire({
        title: data.heading,
        html: data.message,
        icon: data.type
      }).then(function(){
        if (data.status) {location.reload()}
      })
    })
    .always(function(){
      $('body').loading('stop');
    });
  });
</script>