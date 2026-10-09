<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card">
      <div class="card-body">
        <?=form_open('', ['id' => 'user']);?>
      	<?php 
      		if (get('is_dup') == 'true'){}else{echo form_hidden('id', get('id'));}
      		if (get('id') != ''){
      			$this->db->where('user_id', get('id'));
      			$kat = $this->db->get('master_user')->row();
      		}else{
      			$kat = new \stdClass();
      			$kat->user_email = '';
            $kat->user_status = '';
      		}
      	?>
          <div class="row">
          	<div class="col-md-12">
              <div class="form-floating mb-3">
                <input
                  type="text"
                  name="email"
                  class="form-control"
                  id="tb-nama"
                  value="<?=$kat->user_email?>"
                  placeholder="E-Mail User"
                />
                <label for="tb-nama">E-Mail User</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating mb-3">
                <input
                  type="text"
                  name='password'
                  class="form-control"
                  minlength = '6'
                  id="tb-password"
                  placeholder=""
                />
                <label for="tb-password">Ubah Password</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating">
                <input
                  type="password"
                  name='repassword'
                  class="form-control"
                  minlength = '6'
                  id="tb-repassword"
                  placeholder=""
                />
                <label for="tb-repassword">Ulangi Password</label>
              </div>
            </div>

            <div class="col-12">
              <div class="d-md-flex align-items-center mt-3">
                <?php if (get('id') != ''){ ?>
                  <div class="form-check">
                    <button
                      type="button"
                      class="btn btn-<?=($kat->user_status=='1')? 'warning' : 'success'?> font-medium rounded-pill px-4 change_status"
                    >
                      <div class="d-flex align-items-center">
                        <i class="ti ti-<?=($kat->user_status=='1')? 'x' : 'checks'?> me-2 fs-4"></i>
                        <?=($kat->user_status=='1')? 'Non Aktifkan' : 'Aktifkan'; ?>
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
	$('#user').submit(function(event) {
		event.preventDefault();
		$('body').loading();
		$.ajax({
		  url: '<?=base_url('admindata/save_user') ?>',
		  type: 'post',
		  dataType: 'json',
		  data: $('#user').serialize(),
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
    table='user';
    id='<?=get('id')?>';
    content='<?=$kat->user_status?>';
    $.ajax({
      url: '<?=base_url('admindata/change_status') ?>',
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
        if (data.status) {$('.btn-reload-table').click();$('.btn-close').click()}
      })
    })
    .always(function(){
      $('body').loading('stop');
    });
  });
</script>