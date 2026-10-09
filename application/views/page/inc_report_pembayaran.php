<div class="container-fluid">
	<div class="row">
	  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	    <div class="card">
	      <div class="card-body">
	      	<div class="d-sm-flex d-block align-items-center justify-content-between mb-7">
            <div class="mb-3 mb-sm-0">
              <h5 class="card-title fw-semibold">Report Transaksi</h5>
            </div>
          </div>
          <div class="table-responsive">
            <table id="data_table" class="table table-dark align-middle text-center mb-0" data-url="<?=base_url('admintable/report_pembayaran')?>">
	            <thead>
	              <tr> 
	                <th width="2%" >NO</th>
	                <th width="10%">STATUS</th>
	                <th width="10%">USER</th>
	                <th width="10%">ORDER ID</th>
	                <th width="10%">JUMLAH TIKET</th>
	                <th width="10%">HARGA</th>
	                <th width="10%">TANGGAL BAYAR</th>
	                <th width="10%">TYPE TRANSAKSI</th>
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
	  $(document).ready(function() {
	    table = $('#data_table').DataTable({ 
	        "processing": true, 
	        "serverSide": true, 
	        "orderMulti": false,
	        "order": [[0, 'desc']],
	        "columnDefs": [ 
	        {
	          "targets": [ 1 ], 
	          "orderable": false, 
	          "searchable": false,
	        } ],
	        "ajax": {
	            "url": $('#data_table').data('url'),
	            "type": "GET",
	            "data": function(data){
	            	data.status  = status;
	            }
	        },
	        "bFilter": true,
	        "dom": 'lBfrtip', //lBfrtip
	        "buttons": [
	        	{
	            "extend": 'print',
	            "className": 'btn btn-primary float-right ml-1',
	            "action" : newexportaction
	          },
	          {
	            "extend": 'excel',
	            "className": 'btn btn-primary float-right ml-1',
	            "action" : newexportaction
	          },{
	            "extend": 'copy',
	            "className": 'btn btn-primary float-right ml-1',
	            "action" : newexportaction
	          },{
	            "extend": 'pdf',
	            "className": 'btn btn-primary float-right ml-1',
	            "action" : newexportaction
	          }
	        ]
	    });

	    table.buttons().container().appendTo( $('.placing', table.table().container() ) );
	  });
	  
	</script>
</div>