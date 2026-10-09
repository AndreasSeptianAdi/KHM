<div class="container-fluid">
	<div class="row">
	  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	    <div class="card">
	      <div class="card-body">
	      	<div class="d-sm-flex d-block align-items-center justify-content-between mb-7">
            <div class="mb-3 mb-sm-0">
              <h5 class="card-title fw-semibold">User Register</h5>
            </div>
          </div>
          <button id="add_usr" style="display: none;opacity: 0;" type="button" 
          data-bs-toggle="modal" 
          data-modalsize="modal-lg" 
          data-title="Tambah User Baru" 
          data-href="<?=base_url('adminmodal/user')?>" 
          class="btn btn-sm btn-info ml-1" 
          data-bs-target="#ajax-modal">disii</button>

          <div class="table-responsive">
            <table id="data_table" class="table table-dark align-middle text-center mb-0" data-url="<?=base_url('admintable/user')?>">
	            <thead>
	              <tr> 
	                <th width="2%"  style="vertical-align:middle;">NO</th>
	                <th width="10%" style="vertical-align:middle;">STATUS</th>
	                <th width="10%" style="vertical-align:middle;">E-MAIL</th>
	                <th width="10%" style="vertical-align:middle;">DATE JOIN</th>
	                <th width="10%" style="vertical-align:middle;">OPTION</th> 
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
	  $(document).ready(function() {
	    //datatables

	    table = $('#data_table').DataTable({ 
	        "processing": true, 
	        "serverSide": true, 
	        "orderMulti": false,
	        "order": [[0, 'desc']], 
	        "columnDefs": [ 
          {
            "targets": [ 4 ], 
            "orderable": false, 
            "searchable": false,
          } ],
	        "ajax": {
	            "url": $('#data_table').data('url'),
	            "type": "GET",
	            "data": function(data){}
	        },
	        "bFilter": true,
	        "dom": 'lBfrtip', //lBfrtip
	        "buttons": [
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
	  });
	  
	</script>
</div>