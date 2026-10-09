<div class="container-fluid">
	<div class="row">
	  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	    <div class="card">
	      <div class="card-body">
	      	<div class="d-sm-flex d-block align-items-center justify-content-between mb-7">
            <div class="mb-3 mb-sm-0">
              <h5 class="card-title fw-semibold">Group Register</h5>
            </div>
          </div>
          <div class="table-responsive">
            <table id="data_table" class="table table-dark align-middle text-center mb-0" data-url="<?=base_url('admintable/group')?>">
	            <thead>
	              <tr> 
	                <th width="2%" >NO</th>
	                <th width="10%">NAMA GROUP</th>
	                <th width="10%">EMAIL KETUA</th>
	                <th width="10%">JML PESERTA</th>
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
	  $(document).ready(function() {
	    //datatables

	    table = $('#data_table').DataTable({ 
	        "processing": true, 
	        "serverSide": true, 
	        "orderMulti": false,
	        "order": [[0, 'desc']], 
	        "columnDefs": [ 
          {
            "targets": [ 3,5 ], 
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