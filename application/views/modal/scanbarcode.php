<div class="table-responsive">
	<table class="table align-middle table-dark text-center mb-0">
	  <thead>
	    <tr> 
	      <th width="2%" >NO</th>
	      <th width="10%">NO BIB</th>
	      <th width="10%">NAMA</th>
	      <th width="10%">GROUP</th>
	      <th width="10%">KAOS</th>
	      <th width="10%">KATEGORI LARI</th>
	      <th width="10%">OPTION</th> 
	    </tr>
	  </thead>
	  <tbody class="listUsersss">
	  	<?php 
	  		$user = $this->session->userdata('ambil');
	  		$no = 1;
	  		if (is_array($user)){
	  		if (count($user) > 0){
	  		foreach ($user as $key) {
	  			$this->db->join('master_user', 'user_id = pelari_user', 'left');
			    $this->db->join('master_group', 'group_id = pelari_group', 'left');
			    $this->db->join('master_kategori', 'kategori_id = pelari_kategori', 'left');
			    $this->db->where('pelari_id', $key);
			    $a = $this->db->get('master_pelari')->row();	
			    
			    ?>
			    <tr class="pelari-<?=$a->pelari_id?>">
			    	<td><?=$no++?></td>
			    	<td><?=$a->pelari_bib?></td>
			    	<td><?=$a->pelari_name?></td>
			    	<td><?=$a->group_name?></td>
			    	<td><?=$a->pelari_kaos?></td>
			    	<td><?=$a->kategori_name?></td>
			    	<td><?php
			    		$button = '<a href="javascript:void(0);" onclick="ambil('.$a->pelari_id.', \'T\' )" title="Ambil Paket" class="btn btn-warning btn-sm ml-1" data-id="'.$a->pelari_id.'"><i class="fas fa-times"></i></a>';
			    		echo $button;
			    	?></td>
			    </tr>
			    <?php
	  		}}}
	  	?>
	  </tbody>
	</table>
</div>
<div class="card mt-2">
	<div class="card-body">
		<form id="ok">
		  <div class="row">
		    <div class="col-10">
		      <input type="text" class="form-control" name="pengambil" required placeholder="Masukkan Nama Pengambil">
		    </div>
		    <div class="col-2">
		    	<button class="btn btn-success">SIMPAN</button>
		    </div>
		  </div>
		</form>
	</div>
</div>

<script type="text/javascript">
	$('#ok').submit(function(event) {
			event.preventDefault();
			$('body').loading();
			$.ajax({
			  url: '<?=base_url('admindata/ambil') ?>',
			  type: 'post',
			  dataType: 'json',
			  data: $('#ok').serialize(),
			})
			.done(function( data ) {
			  Swal.fire({
			    title: 'Pengambilan Paket Pelari',
			    html: data.message,
			    icon: data.type
			  }).then(function(){
			  	if (data.status){
			    	location.reload();
			    }
			  })
			})
			.always(function(){
			  $('body').loading('stop');
			});
		});
</script>