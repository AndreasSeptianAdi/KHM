<div class="container-fluid">
	<div class="row">
	  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	    <div class="card">
	      <div class="card-body">
	      	<div class="d-sm-flex d-block align-items-center justify-content-between mb-7">
            <div class="mb-3 mb-sm-0">
              <h5 class="card-title fw-semibold">Pengambilan</h5>
            </div>
          </div>
          	<p>Filter</p>
          <div class="btn-group mb-2" role="group" aria-label="Basic example">
            <button type="button" data-status = 'F' class="btn change_status btn-info active">
              Belum Ambil
            </button>
            <button type="button" data-status = 'T' class="btn change_status btn-info ">
              Sudah Ambil
            </button>
            <button type="button" data-status = '' class="btn change_status btn-info ">
              Semua Data
            </button>
          </div>
            
            <button id="scanbarcode" style="display: none;opacity: 0;" type="button" 
		          data-bs-toggle="modal" 
		          data-modalsize="modal-lg"
		          data-title="Scan Pengambilan" 
		          data-href="<?=base_url('adminmodal/scanbarcode')?>" 
		          class="btn btn-sm btn-info ml-1" 
		          data-bs-target="#ajax-modal">disii</button>
          <div class="table-responsive">
            <table id="data_table" class="table table-dark align-middle text-center mb-0" data-url="<?=base_url('admintable/pengambilan')?>">
	            <thead>
	              <tr> 
	                <th width="2%" >NO</th>
	                <th width="10%">STATUS</th>
	                <th width="10%">NO BIB</th>
	                <th width="10%">NAMA</th>
	                <th width="10%">GROUP</th>
	                <th width="10%">KATEGORI</th>
	                <th width="10%">DATE JOIN</th>
	                <th width="10%">Nama Pengambil</th>
	                <th width="10%">Tanggal Ambil</th>
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
		function ambil(id,status) {
			event.preventDefault();
			$('body').loading();
			$.ajax({
			  url: '<?=base_url('admindata/ambil_check') ?>',
			  type: 'post',
			  dataType: 'json',
			  data: {id,status},
			})
			.done(function( data ) {
			  Swal.fire({
			    title: 'Paket Pelari',
			    html: data,
			    icon: 'success'
			  }).then(function(){
			    $('#data_table').DataTable().ajax.reload(null, false);
			    $('.pelari-'+id).hide();
			  })
			})
			.always(function(){
			  $('body').loading('stop');
			});
		}

		function removeambil(id,status) {
			event.preventDefault();
			$('body').loading();
			$.ajax({
			  url: '<?=base_url('admindata/ambil_old') ?>',
			  type: 'post',
			  dataType: 'json',
			  data: {id,status},
			})
			.done(function( data ) {
			  Swal.fire({
			    title: data.heading,
			    html: data.message,
			    icon: data.type
			  }).then(function(){
			    $('#data_table').DataTable().ajax.reload(null, false);
			  })
			})
			.always(function(){
			  $('body').loading('stop');
			});
		}

	  var table;
		var status = 'F';
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
	            "text": '<i class="fa fa-qrcode" title=""></i> SCAN',
	            "className": 'btn btn-info float-right ml-1',
	            "action": function ( e, dt, node, config ) {
	              show_scanner();
	            }
	          },{
	            "text": '<i class="fa fa-bars" title=""></i> PENGAMBILAN',
	            "className": 'btn btn-info float-right ml-1',
	            "action": function ( e, dt, node, config ) {
	              $('#scanbarcode').click();
	              $('#qrcodes').focus();
	            }
	          },{
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

	    $('.change_status').click(function(event) {
	      status = $(this).data('status');
	      $('#data_table').DataTable().ajax.reload();  
	      $('.change_status').removeClass('active');
	      $(this).addClass('active');

	    });

	    table.buttons().container().appendTo( $('.placing', table.table().container() ) );
	  });
	  

	  function show_scanner(){
	    Swal.fire({
	      title: 'SCAN HERE' ,
	      input: 'text',
	      inputAttributes: {
	        autocapitalize: 'off',
	      },
	      showCancelButton: true,
	      confirmButtonText: 'CHECK',
	      preConfirm: (pelari_id) => {
	        return fetch(`<?=base_url('admindata/cek_barcode')?>`, {
	          method: "POST",
	          body: JSON.stringify({pelari_id,sc:'yes'})
	          
	        })
	          .then(response => {
	            if (!response.ok) {
	              throw new Error(response.statusText)
	            }
	            return response.json()
	          })
	          .catch(error => {
	            Swal.showValidationMessage(
	              `Request failed: ${error}`
	            )
	          })
	      },
	      allowOutsideClick: () => !Swal.isLoading()
	    }).then((results) => {
	      if (results.value){
	        Swal.fire({
	          title: results.value.message,
	        }).then(() => {
	          if (results.value.status){
	            $('#data_table').DataTable().ajax.reload(null, false);
	            show_scanner();
	          }
	        });
	      }
	    })
	  }

	</script>
</div>