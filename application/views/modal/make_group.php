<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card">
      <div class="card-body">
        <?=form_open('', ['id' => 'group']);?>
          <div class="row">
          	<div class="col-md-12">
              <div class="form-floating mb-3">
                <input
                  type="text"
                  class="form-control"
                  id="tb-nama"
                  name="groupname"
                  placeholder=""
                />
                <label for="tb-nama">Nama Group</label>
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
	$('#group').submit(function(event) {
		event.preventDefault();
		$('body').loading();
		$.ajax({
		  url: '<?=base_url('userdata/save_group_name') ?>',
		  type: 'post',
		  dataType: 'json',
		  data: $('#group').serialize(),
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