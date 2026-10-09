<div class="container-fluid">
	<div class="row">
	  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	    <div class="card">
	      <div class="card-body">
	      	<div class="d-sm-flex d-block align-items-center justify-content-between mb-7">
            <div class="mb-3 mb-sm-0">
              <h5 class="card-title fw-semibold">Pelari Terdaftar</h5>
            </div>
          </div>

          <legend>FILTER</legend> <br>
          <div class="btn-group">
	          <button data-id='' class="chs btn btn-info active">SEMUA PELARI</button>
	          <button data-id='4' class="chs btn btn-secondary">21K Master</button>
	          <button data-id='3' class="chs btn btn-secondary">21K</button>
	          <button data-id='2' class="chs btn btn-dark">10K</button>
	          <button data-id='1' class="chs btn btn-light">5K</button>
          </div>
          <br>
          <div class="btn-group mt-2">
	          <button data-id='' class="chs2 btn btn-info active">SEMUA STATUS</button>
	          <button data-id='T' class="chs2 btn btn-success">SUDAH BAYAR</button>
	          <button data-id='F' class="chs2 btn btn-warning">BELUM BAYAR</button>
          </div>
          <button id="kaos_kumulatif" style="display: none;opacity: 0;" type="button" 
          data-bs-toggle="modal" 
          data-modalsize="modal-lg"
          data-title="Ukuran Kaos" 
          data-href="<?=base_url('adminmodal/kaos_kumulatif')?>" 
          class="btn btn-info ml-1" 
          data-bs-target="#ajax-modal"></button>

          <div class="table-responsive mt-2">
            <table id="data_table" class="table table-dark align-middle text-center mb-0" data-url="<?=base_url('admintable/pelari')?>">
	            <thead>
	              <tr> 
	                <th width="2%" >NO</th>
	                <th width="10%">STATUS</th>
	                <th width="10%">NAMA</th>
	                <th width="10%">EMAIL</th>
	                <th width="10%">KATEGORI</th>
	                <th width="10%">NO BIB</th>
	                <th width="10%">UKURAN KAOS</th>
	                <th width="10%">No. TELP</th>
	                <th width="10%">DATE JOIN</th>
	                <th width="10%">OPTION</th> 
	              </tr>
	            </thead>
	          </table>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>

	<script type="text/javascript">
	  $('.btn-reload').click(function(event) {
	    var theCard = $(this).data('reload');
	    $(this).find('i').addClass('fa-spin');
	    $('#'+theCard).load(" #"+theCard+" > *");
	    setTimeout((e) => {$(this).find('i').removeClass('fa-spin');}, 4000);
	  });

	  var table;
	  var kat = '';
	  var bayar = '';
	  var ready = '';
	  $(document).ready(function() {
	    //datatables

	    table = $('#data_table').DataTable({ 
	        "processing": true, 
	        "serverSide": true, 
	        "orderMulti": false,
	        "order": [[0, 'desc']], 
	        "columnDefs": [ 
          {
            "targets": [ 9 ], 
            "orderable": false, 
            "searchable": false,
          } ],
	        "ajax": {
	            "url": $('#data_table').data('url'),
	            "type": "GET",
	            "data": function(data){
	            	data.kat  = kat;
	            	data.ready  = ready;
	            }
	        },
	        "bFilter": true,
	        "dom": 'lBfrtip', //lBfrtip
	        "buttons": [
	          {
	            "text": '<i class="fa fa-universal-access" title="Ukuran Kaos"></i>',
	            "className": 'btn btn-primary float-right ml-1',
	            "action": function ( e, dt, node, config ) {
	              $('#kaos_kumulatif').click();
	            }
	          },{
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
	      kat = $(this).data('id');
	      $('#data_table').DataTable().ajax.reload();  
	      $('.chs').removeClass('active');
	      $(this).addClass('active');
	    });
	    $('.chs2').click(function(event) {
	      ready = $(this).data('id');
	      $('#data_table').DataTable().ajax.reload();  
	      $('.chs2').removeClass('active');
	      $(this).addClass('active');
	    });
	  });
	  
	</script>
</div>