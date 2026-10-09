<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card">
      <div class="card-body">
        <?=form_open('', ['id' => 'user']);?>
      	<?php 
      		if (get('id') != ''){
      			$this->db->where('user_id', get('id'));
      			$kat = $this->db->get('master_user')->row();
      		}
      	?>
          <div class="row">
          	<div class="col-md-12">
              <div class="form-floating mb-3">
                <input
                  type="text"
                  class="form-control"
                  id="tb-nama"
                  disabled
                  value='<?=$kat->user_email?>'
                />
                <label for="tb-nama">E-Mail</label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-floating mb-3">
                <input
                  type="password"
                  name='old_pass'
                  class="form-control"
                  minlength = '6'
                  id="tb-old_pass"
                  placeholder=""
                />
                <label for="tb-old_pass">Password Lama</label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-floating mb-3">
                <input
                  type="password"
                  name='new_pass'
                  class="form-control"
                  minlength = '6'
                  id="tb-new_pass"
                  placeholder=""
                />
                <label for="tb-new_pass">Ubah Password</label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-floating">
                <input
                  type="password"
                  name='re_pass'
                  class="form-control"
                  minlength = '6'
                  id="tb-re_pass"
                  placeholder=""
                />
                <label for="tb-re_pass">Ulangi Password</label>
              </div>
            </div>

            <div class="col-12">
              <div class="d-md-flex align-items-center mt-3">
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
		  url: '<?=base_url('userdata/save_user') ?>',
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
</script>