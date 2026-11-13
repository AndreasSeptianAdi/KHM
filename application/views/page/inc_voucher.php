<div class="container-fluid">
	<div class="row">
	  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	    <div class="card">
	      <div class="card-body">
	      	<div class="d-sm-flex d-block align-items-center justify-content-between mb-7">
            <div class="mb-3 mb-sm-0">
              <h5 class="card-title fw-semibold">Voucher Pendaftaran</h5>
              <small>Kuota kategori otomatis berkurang sejumlah QTY saat voucher dibuat.</small>
            </div>
          </div>

          <button id="add_voucher" style="display: none;opacity: 0;" type="button"
          data-bs-toggle="modal"
          data-modalsize="modal-lg"
          data-title="Buat Voucher Baru"
          data-href="<?=base_url('adminmodal/voucher')?>"
          class="btn btn-sm btn-info ml-1"
          data-bs-target="#ajax-modal">disii</button>

          <legend>FILTER</legend> <br>
          <div class="row">
            <div class="col-md-4">
              <select id="flt_kategori" class="form-control">
                <option value="">SEMUA KATEGORI LOMBA</option>
                <?php
                  $this->db->order_by('kategori_id', 'asc');
                  foreach ($this->db->get('master_kategori')->result() as $katlari) {
                    echo '<option value="'.$katlari->kategori_id.'">'.html_escape($katlari->kategori_name).' (Sisa Kuota: '.$katlari->kategori_kuota.')</option>';
                  }
                ?>
              </select>
            </div>
            <div class="col-md-8">
              <div class="btn-group">
                <button data-id='' class="chs btn btn-info active">SEMUA</button>
                <button data-id='F' class="chs btn btn-warning">BELUM TERPAKAI</button>
                <button data-id='T' class="chs btn btn-success">SUDAH TERPAKAI</button>
              </div>
            </div>
          </div>

          <div class="table-responsive mt-3">
            <table id="data_table" class="table align-middle text-center mb-0 table-dark" data-url="<?=base_url('admintable/voucher')?>">
	            <thead>
	              <tr>
	                <th width="2%">NO</th>
	                <th width="16%">KODE VOUCHER</th>
	                <th width="12%">KATEGORI LOMBA</th>
	                <th width="12%">BATCH</th>
	                <th width="8%">STATUS</th>
	                <th width="18%">DIGUNAKAN OLEH</th>
	                <th width="10%">BERLAKU SAMPAI</th>
	                <th width="10%">DIBUAT</th>
	                <th width="12%">OPTION</th>
	              </tr>
	            </thead>
	          </table>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>

	<script type="text/javascript">
	  var table;
	  var kat   = '';
	  var used  = '';

	  $(document).ready(function() {
	    table = $('#data_table').DataTable({
	        "processing": true,
	        "serverSide": true,
	        "orderMulti": false,
	        "order": [[0, 'desc']],
	        "columnDefs": [
	          {
	            "targets": [ 8 ],
	            "orderable": false,
	            "searchable": false,
	          } ],
	        "ajax": {
	            "url": $('#data_table').data('url'),
	            "type": "GET",
	            "data": function(data){
	            	data.kat  = kat;
	            	data.used = used;
	            }
	        },
	        "bFilter": true,
	        "dom": 'lBfrtip',
	        "buttons": [
	          {
	            "text": '<i class="fa fa-plus" title="Buat Voucher"></i>',
	            "className": 'btn btn-info float-right ml-1',
	            "action": function ( e, dt, node, config ) {
	              $('#add_voucher').click();
	            }
	          },
	          {
	            "extend": 'excel',
	            "className": 'btn btn-primary float-right ml-1',
	            "action" : newexportaction
	          },
	          {
	            "text": '<i class="fa fa-retweet" title="Reload"></i>',
	            "className": 'btn btn-success btn-reload-table float-right ml-1',
	            "action": function ( e, dt, node, config ) {
	              $('#data_table').DataTable().ajax.reload();
	            }
	          }
	        ]
	    });

	    table.buttons().container().appendTo( $('.placing', table.table().container() ) );

	    $('.chs').click(function(event) {
	      used = $(this).data('id');
	      $('#data_table').DataTable().ajax.reload();
	      $('.chs').removeClass('active');
	      $(this).addClass('active');
	    });

	    $('#flt_kategori').change(function(event) {
	      kat = $(this).val();
	      $('#data_table').DataTable().ajax.reload();
	    });
	  });

	  // hapus voucher yang belum terpakai -> kuota kategori dikembalikan +1
	  function hapus_voucher(id){
	    Swal.fire({
	      title: 'Hapus Voucher ?',
	      text: 'Kuota kategori akan dikembalikan +1',
	      icon: 'warning',
	      showCancelButton: true,
	      confirmButtonColor: '#3085d6',
	      cancelButtonColor: '#d33',
	      confirmButtonText: 'Ya',
	      cancelButtonText: 'Tidak'
	    }).then((result) => {
	      if (result.value) {
	        $('body').loading();
	        $.ajax({
	          url: '<?=base_url('admindata/hapus_voucher')?>',
	          type: 'post',
	          dataType: 'json',
	          data: {id},
	        })
	        .done(function(data) {
	          Swal.fire({
	            title: data.heading,
	            html: data.message,
	            icon: data.type,
	            position: 'top-end',
	            showConfirmButton: false,
	            timer: 1800
	          }).then(function(){
	            if (data.status){$('#data_table').DataTable().ajax.reload(null, false);}
	          });
	        })
	        .always(function() {
	          $('body').loading('stop');
	        });
	      }
	    });
	  }

	  // aktif / nonaktifkan voucher (memakai fungsi generik change_status)
	  function ubah_status_voucher(id, content){
	    $('body').loading();
	    var nama_table = 'voucher';
	    $.ajax({
	      url: '<?=base_url('admindata/change_status')?>',
	      type: 'post',
	      dataType: 'json',
	      data: {table:nama_table, id, content},
	    })
	    .done(function(data) {
	      Swal.fire({
	        title: data.heading,
	        html: data.message,
	        icon: data.type,
	        position: 'top-end',
	        showConfirmButton: false,
	        timer: 1500
	      }).then(function(){
	        if (data.status){$('#data_table').DataTable().ajax.reload(null, false);}
	      });
	    })
	    .always(function() {
	      $('body').loading('stop');
	    });
	  }
	</script>
</div>
