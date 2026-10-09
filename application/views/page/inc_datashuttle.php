<div class="container-fluid">
	<div class="row">
	  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	    <div class="card">
	      <div class="card-body">
	      	<div class="d-sm-flex d-block align-items-center justify-content-between mb-7">
            <div class="mb-3 mb-sm-0">
              <h5 class="card-title fw-semibold">Shuttle Pelari</h5>
            </div>
          </div>
          
          <legend>FILTER</legend> <br>
          <div class="btn-group">
	          <select class="form-control" id="filter_shuttle">
	          	<option value="">SEMUA SHUTTLE</option>
	          	<option value="1">SHUTTLE PEMKOT</option>
	          	<option value="2">SHUTTLE PEMKAB</option>
	          	<option value="3">SHUTTLE GUMUL</option>
	          </select>
          </div>
          <br>
          <div class="btn-group">
	          
          </div>
          <div class="table-responsive mt-2">
            <table id="data_table" class="table table-dark align-middle text-center mb-0" data-url="<?=base_url('admintable/shuttle_pelari')?>">
	            <thead>
	              <tr> 
	                <th width="2%" >NO</th>
	                <th width="10%">CODE</th>
	                <th width="10%">NAMA</th>
	                <th width="10%">NO BIB</th>
	                <th width="10%">KATEGORI</th>
	                <th width="10%">LOKASI JEMPUT</th>
	                <th width="10%">TANGGAL BELI</th>
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

	  var shuttle = '';
	  $(document).ready(function() {
	    //datatables

	    table = $('#data_table').DataTable({ 
	        "processing": true, 
	        "serverSide": true, 
	        "orderMulti": false,
	        "order": [[0, 'desc']], 
	        "columnDefs": [ 
          {
            "targets": [ 0 ], 
            "orderable": false, 
            "searchable": false,
          } ],
	        "ajax": {
	            "url": $('#data_table').data('url'),
	            "type": "GET",
	            "data": function(data){
	            	data.shuttle  = $('#filter_shuttle').val();
	            }
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
	          },{
	            "extend": 'excel',
	            "text": '<i class="ti ti-file-spreadsheet"> </i> Download',
	            "className": 'btn btn-primary float-right ml-1',
	            "action" : newexportaction
	          },,{
	            "extend": 'print',
	            "text": '<i class="ti ti-printer"> </i> Cetak',
	            "className": 'btn btn-primary float-right ml-1',
	            "action" : newexportaction
	          },{
	            "extend": 'pdf',
	            "text": '<i class="ti ti-printer"> </i> PDF',
	            "className": 'btn btn-primary float-right ml-1',
	            "action" : newexportaction
	          }
	        ]
	    });

	    table.buttons().container().appendTo( $('.placing', table.table().container() ) );

	    $('#filter_shuttle').change( function() {
	        $('#data_table').DataTable().ajax.reload();  
	    } );
	  });
	  
	</script>
</div>