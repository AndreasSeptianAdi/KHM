<div class="container-fluid">
	<div class="row">
	  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	    <div class="card">
	      <div class="card-body">
	      	<div class="d-sm-flex d-block align-items-center justify-content-between mb-7">
            <div class="mb-3 mb-sm-0">
              <h5 class="card-title fw-semibold">Kategori Lari</h5>
            </div>
          </div>

          <div class="table-responsive">
            <table id="data_table" class="table table-dark align-middle text-center mb-0">
	            <thead>
	              <tr> 
	                <th width="30%" style="vertical-align:middle;">OPTION</th>
	                <th width="50%" style="vertical-align:middle;">CONTENT</th>
	                <th width="20%" style="vertical-align:middle;">OPTION</th> 
	              </tr>
	            </thead>
	            <tbody>
	            	<tr>
	            		<td><h6>Antrean Login (Waiting Room)</h6><small class="text-muted d-block">CONTOH : <b>1</b> aktif / <b>0</b> mati</small></td>
	            		<td><h6><?=htmlspecialchars(option('queue_enabled') === '' ? '1' : option('queue_enabled'))?></h6></td>
	            		<td>
	            			<button 
	            				class="btn btn-sm btn-info" 
	            				data-bs-toggle="modal" 
					          data-modalsize="modal-xs"
					          data-title="Ubah Status Antrean" 
					          data-href="<?=base_url('adminmodal/ubah_option_text?opt_name=queue_enabled')?>" 
					          class="btn btn-sm btn-info ml-1" 
					          data-bs-target="#ajax-modal">
					          	<i class="ti ti-pencil"></i> EDIT</button></td>
	            	</tr><?php
						
					/*
	            	<tr>
	            		<td><h6>Maks Slot Login Bersamaan</h6><small class="text-muted d-block">Default: <b>10</b></small></td>
	            		<td><h6><?=htmlspecialchars(option('queue_max') === '' ? '10' : option('queue_max'))?></h6></td>
	            		<td>
	            			<button 
	            				class="btn btn-sm btn-info" 
	            				data-bs-toggle="modal" 
					          data-modalsize="modal-xs"
					          data-title="Ubah Maks Slot" 
					          data-href="<?=base_url('adminmodal/ubah_option_text?opt_name=queue_max')?>" 
					          class="btn btn-sm btn-info ml-1" 
					          data-bs-target="#ajax-modal">
					          	<i class="ti ti-pencil"></i> EDIT</button></td>
	            	</tr>*/ 
					?>
	            	<tr>
	            		<td><h6>Setting Batas Akhir Pendaftaran Akun</h6></td>
	            		<td><h6><?=$a=date('d F Y H:i A', strtotime(option('last_regis')))?></h6></td>
	            		<td>
	            			<button 
	            				class="btn btn-sm btn-info" 
	            				data-bs-toggle="modal" 
						          data-modalsize="modal-xs"
						          data-title="Ubah Batas Registrasi" 
						          data-href="<?=base_url('adminmodal/ubah_option?opt_name=last_regis')?>" 
						          class="btn btn-sm btn-info ml-1" 
						          data-bs-target="#ajax-modal">
						          	<i class="ti ti-pencil"></i> EDIT</button></td>
	            	</tr>
	            	<?php /* ?>
	            	<tr>
	            		<td><h6>Group Open</h6></td>
	            		<td><h6><?=$b=date('d F Y H:i A', strtotime(option('group_open')))?></h6></td>
	            		<td>
	            			<button 
	            				class="btn btn-sm btn-info" 
	            				data-bs-toggle="modal" 
						          data-modalsize="modal-xs"
						          data-title="Ubah Open Group" 
						          data-href="<?=base_url('adminmodal/ubah_option?opt_name=group_open')?>" 
						          class="btn btn-sm btn-info ml-1" 
						          data-bs-target="#ajax-modal">
						          	<i class="ti ti-pencil"></i> EDIT</button></td>
	            	</tr>
	            	<tr>
	            		<td><h6>Group Close</h6></td>
	            		<td><h6><?=$c=date('d F Y H:i A', strtotime(option('group_close')))?></h6></td>
	            		<td>
	            			<button 
	            				class="btn btn-sm btn-info" 
	            				data-bs-toggle="modal" 
						          data-modalsize="modal-xs"
						          data-title="Ubah Group Close" 
						          data-href="<?=base_url('adminmodal/ubah_option?opt_name=group_close')?>" 
						          class="btn btn-sm btn-info ml-1" 
						          data-bs-target="#ajax-modal">
						          	<i class="ti ti-pencil"></i> EDIT</button></td>
	            	</tr>
	            	<tr>
	            		<td><h6>Kategori Umum Open</h6></td>
	            		<td><h6><?=$c=date('d F Y H:i A', strtotime(option('reg_umum')))?></h6></td>
	            		<td>
	            			<button 
	            				class="btn btn-sm btn-info" 
	            				data-bs-toggle="modal" 
						          data-modalsize="modal-xs"
						          data-title="Ubah Open Registrasi Umum" 
						          data-href="<?=base_url('adminmodal/ubah_option?opt_name=reg_umum')?>" 
						          class="btn btn-sm btn-info ml-1" 
						          data-bs-target="#ajax-modal">
						          	<i class="ti ti-pencil"></i> EDIT</button></td>
	            	</tr>
	            	<tr>
	            		<td><h6>Kategori Umum Close</h6></td>
	            		<td><h6><?=$c=date('d F Y H:i A', strtotime(option('reg_umum_close')))?></h6></td>
	            		<td>
	            			<button 
	            				class="btn btn-sm btn-info" 
	            				data-bs-toggle="modal" 
						          data-modalsize="modal-xs"
						          data-title="Ubah Close Registrasi Umum" 
						          data-href="<?=base_url('adminmodal/ubah_option?opt_name=reg_umum_close')?>" 
						          class="btn btn-sm btn-info ml-1" 
						          data-bs-target="#ajax-modal">
						          	<i class="ti ti-pencil"></i> EDIT</button></td>
	            	</tr>
	            	<tr>
	            		<td><h6>Kategori Khusus Open</h6></td>
	            		<td><h6><?=$c=date('d F Y H:i A', strtotime(option('reg_khusus')))?></h6></td>
	            		<td>
	            			<button 
	            				class="btn btn-sm btn-info" 
	            				data-bs-toggle="modal" 
						          data-modalsize="modal-xs"
						          data-title="Ubah Open Registrasi Khusus" 
						          data-href="<?=base_url('adminmodal/ubah_option?opt_name=reg_khusus')?>" 
						          class="btn btn-sm btn-info ml-1" 
						          data-bs-target="#ajax-modal">
						          	<i class="ti ti-pencil"></i> EDIT</button></td>
	            	</tr>
	            	<tr>
	            		<td><h6>Kategori Khusus Close</h6></td>
	            		<td><h6><?=$c=date('d F Y H:i A', strtotime(option('reg_khusus_close')))?></h6></td>
	            		<td>
	            			<button 
	            				class="btn btn-sm btn-info" 
	            				data-bs-toggle="modal" 
						          data-modalsize="modal-xs"
						          data-title="Ubah Close Registrasi Khusus" 
						          data-href="<?=base_url('adminmodal/ubah_option?opt_name=reg_khusus_close')?>" 
						          class="btn btn-sm btn-info ml-1" 
						          data-bs-target="#ajax-modal">
						          	<i class="ti ti-pencil"></i> EDIT</button></td>
	            	</tr>
	            	<?php */ ?>
	            </tbody>
	          </table>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>

	<script type="text/javascript">
	  var table;
	  $(document).ready(function() {
	    //datatables

	    table = $('#data_table').DataTable({ 
	        "processing": false, 
	        "serverSide": false, 
	        "orderMulti": false,
	        "order": [[0, 'desc']], 
	        "columnDefs": [ 
          {
            "targets": [ 1 ], 
            "orderable": false, 
            "searchable": false,
          } ],
	        "bFilter": true,
	        "dom": 'frt', //lBfrtip
	        
	    });

	    table.buttons().container().appendTo( $('.placing', table.table().container() ) );
	  });
	</script>
</div>