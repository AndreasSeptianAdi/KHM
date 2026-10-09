<div class="container-fluid">
	<div class="row">
	  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	    <div class="card">
	      <div class="card-body">
	      	<div class="d-sm-flex d-block align-items-center justify-content-between mb-7">
            <div class="mb-3 mb-sm-0">
              <h5 class="card-title fw-semibold">Email Pengambilan</h5>
            </div>
          </div>
          <div class="table-responsive">
            <table id="data_table" class="table table-dark align-middle text-center mb-0" data-url="<?=base_url('admintable/email')?>">
	            <thead>
	              <tr> 
	                <th width="2%" ><input type="checkbox" name="" id="ok"></th>
	                <th width="10%">NO BIB</th>
	                <th width="10%">NAMA</th>
	                <th width="10%">EMAIL</th>
	                <th width="10%">KATEGORI</th>
	                <th width="10%">UKURAN KAOS</th>
	                <th width="10%">INFO EMAIL</th>
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
		var pilihan = false
	  $('.btn-reload').click(function(event) {
	    var theCard = $(this).data('reload');
	    $(this).find('i').addClass('fa-spin');
	    $('#'+theCard).load(" #"+theCard+" > *");
	    setTimeout((e) => {$(this).find('i').removeClass('fa-spin');}, 4000);
	  });


	  function kirim_email(user,email,ulang='') {
			event.preventDefault();
			Swal.fire({
        title: 'Kirim '+ulang+' Email Pengambilan ke '+email+' ?',
        text: "",
        icon: (ulang=='')?'question' : 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
      }).then((result) => {
        if (result.value) {
        	$('body').loading();
        	$.ajax({
					  url: '<?=base_url('admindata/kirim_email') ?>',
					  type: 'post',
					  dataType: 'json',
					  data: {user,email}
					})
					.done(function( data ) {
					  Swal.fire({
					    title: data.heading,
					    html: data.message,
					    icon: data.type
					  }).then(function(){
					    if (data.status) {$('#data_table').DataTable().ajax.reload(null, false);}
					  })
					})
					.always(function(){
					  $('body').loading('stop');
					});
				}
      });
		}

		function kirim_email2(user,email,ulang='') {
			event.preventDefault();
			Swal.fire({
        title: 'Kirim '+ulang+' Email BIB ke '+email+' ?',
        text: "",
        icon: (ulang=='')?'question' : 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
      }).then((result) => {
        if (result.value) {
        	$('body').loading();
        	$.ajax({
					  url: '<?=base_url('admindata/kirim_email2') ?>',
					  type: 'post',
					  dataType: 'json',
					  data: {user,email}
					})
					.done(function( data ) {
					  Swal.fire({
					    title: data.heading,
					    html: data.message,
					    icon: data.type
					  }).then(function(){
					    if (data.status) {$('#data_table').DataTable().ajax.reload(null, false);}
					  })
					})
					.always(function(){
					  $('body').loading('stop');
					});
				}
      });
		}

	  var table;
	  $(document).ready(function() {
	    //datatables

	    table = $('#data_table').DataTable({ 
	        "processing": true, 
	        "serverSide": true, 
	        "orderMulti": false,
	        "order": [[1, 'desc']], 
	        "columnDefs": [ {
            "orderable": false,
            "className": 'select-checkbox',
            "targets":   0
        	},{
            "targets": [ 0,7 ], 
            "orderable": false, 
            "searchable": false,
          } ],
          "select": {
            "style":    'form-control',
            "selector": 'td:first-child'
        	},
	        "ajax": {
	            "url": $('#data_table').data('url'),
	            "type": "GET",
	            "data": function(data){}
	        },
	        "bFilter": true,
	        "dom": 'lBfrtip', //lBfrtip
	        "buttons": [
	        	{ 
	            "extend": 'selected',
	            "text": 'Kirim Email Pengambilan',
	            "className": 'btn btn-info float-left ml-1',
	            action: function ( e, dt, button, config ) {
	              selectedIds = dt.rows( { selected: true } ).data().pluck(0).toArray();
	              $('body').loading();
	              $.ajax({
	                url: '<?=base_url('admindata/kirim_email')?>',
	                type: 'get',
	                dataType: 'json',
	                data: {selectedIds},
	              })
	              .done(function(data) {
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
	            }
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
	  });


	  $('#ok').click(function(event) {
	  	if ($('#ok').is(':checked')) {
		  	table.rows().select();
		  }
		  else {
		  	table.rows().deselect();
		  }
	  });
	  
	</script>
</div>