<div class="container-fluid">
	<div class="row">
	  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	    <div class="card">
	      <div class="card-body">
	      	<div class="d-sm-flex d-block align-items-center justify-content-between mb-7">
            <div class="mb-3 mb-sm-0">
              <h5 class="card-title fw-semibold">Pelari Terdaftar By Kota</h5>
            </div>
          </div>
          <button id="add_usr" style="display: none;opacity: 0;" type="button" 
          data-bs-toggle="modal" 
          data-modalsize="modal-lg"
          data-title="Tambah Pelari Baru" 
          data-href="<?=base_url('adminmodal/pelariumum')?>" 
          class="btn btn-sm btn-info ml-1" 
          data-bs-target="#ajax-modal"></button>
          <button id="add_usr2" style="display: none;opacity: 0;" type="button" 
          data-bs-toggle="modal" 
          data-modalsize="modal-lg"
          data-title="Tambah Pelajar Baru" 
          data-href="<?=base_url('adminmodal/pelaripelajar')?>" 
          class="btn btn-sm btn-info ml-1" 
          data-bs-target="#ajax-modal"></button>

          <legend>FILTER</legend> <br>
          <div class="btn-group">
	          <select class="form-control" id="filter_kota">
	          	<option value="">SEMUA KOTA</option>
	          	<?php 
	          		$this->db->order_by('provinsi_id', 'asc');
	          		$this->db->group_by('pelari_kota');
	          		$this->db->select('pelari_kota,city_id, city_name, city_type,provinsi_nama');
	          		$this->db->join('master_city', 'city_id = pelari_kota', 'left');
	          		$this->db->join('master_provinsi', 'city_provinceid = provinsi_id', 'left');
	          		$gets = $this->db->get('master_pelari');
	          		foreach ($gets->result() as $data) {
	          			echo "<option value='$data->pelari_kota'>$data->city_type $data->city_name - ($data->provinsi_nama)</option>";
	          		}
	          	?>
	          </select>
          </div>
          <br>
          <div class="btn-group">
	          
          </div>
          <div class="table-responsive mt-2">
            <table id="data_table" class="table table-dark align-middle text-center mb-0" data-url="<?=base_url('admintable/pelari_kota')?>">
	            <thead>
	              <tr> 
	                <th width="2%" >NO</th>
	                <th width="10%">NAMA</th>
	                <th width="10%">EMAIL</th>
	                <th width="10%">PHONE</th>
	                <th width="10%">KATEGORI</th>
	                <th width="10%">NO BIB</th>
	                <th width="10%">GENDER</th>
	                <th width="10%">UKURAN KAOS</th>
	                <th width="10%">PROVINSI</th>
	                <th width="10%">KOTA</th>
	                <th width="10%">ALAMAT</th>
	                <th width="10%">DARURAT</th>
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
	  $(document).ready(function() {
	    //datatables

	    table = $('#data_table').DataTable({ 
	        "processing": true, 
	        "serverSide": true, 
	        "orderMulti": false,
	        "order": [[0, 'desc']], 
	        "columnDefs": [ 
          {
            "targets": [ 7 ], 
            "orderable": false, 
            "searchable": false,
          } ],
	        "ajax": {
	            "url": $('#data_table').data('url'),
	            "type": "GET",
	            "data": function(data){
	            	data.kat  = kat;
	            	data.kota  = $('#filter_kota').val();
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

	    $('#filter_kota').change( function() {
	        $('#data_table').DataTable().ajax.reload();  
	    } );

	    $('.chs').click(function(event) {
	      kat = $(this).data('id');
	      $('#data_table').DataTable().ajax.reload();  
	      $('.chs').removeClass('active');
	      $(this).addClass('active');
	    });
	  });
	  
	</script>
</div>