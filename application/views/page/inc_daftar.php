<style>
	:root{--accent:#41902f;--muted:#f3f4f6;--bg:#f2fbf0;--glass:rgba(255,255,255,0.06)}
	.btn{display:inline-block;padding:10px 16px;border-radius:10px;text-decoration:none;font-weight:600}
  .btn-primary{background:linear-gradient(90deg,var(--accent),#7ec964);color:#fff}
  .btn-ghost{background:#fff;border:1px solid #c9ecbc;color:#244f21}
  .countdown{display:inline-flex;gap:8px;margin-top:14px}
  .countdown .part{background:var(--glass);padding:10px 12px;border-radius:10px;min-width:64px;text-align:center}
  .part .num{font-weight:800;font-size:18px}
												    .part .label{font-size:11px;color:#4a6b46;margin-top:4px}
</style>
<script>
	function pad(n){return n.toString().padStart(2,'0')}
	var eventDate1 = '';
	var eventDate2 = '';
	var eventDate3 = '';
</script>
<div class="container-fluid">
	<div class="row">
	  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	    <div class="card">
	    	<?php 
	    		$view_bib = false;
	    		$userdata = userdata();
	    		if ($userdata->pelari_bib != ''){
	    			$view_bib = true;
	    		}
	    		$cek = $this->db->get_where('master_group',['group_user' => userid()]);
	    		if ($cek->num_rows() == 0){
	    			if ($userdata->pelari_id != ''){
	    				if ($userdata->pelari_kategori != ''){
	    					redirect(base_url('page/daftar_lari'),'refresh');
	    				}else{
	    					redirect(base_url('page/'),'refresh');
	    				}
	    			}
	    			?>
			      <div class="card-body">
		          <div class="row mb-5">
		          	<div class="col-12">
		          		<form action='<?=base_url('page/daftar_lari')?>' method='post'>
	          				<?php
	          					$this->db->order_by('kategori_datestart', 'asc'); 
	          					$this->db->order_by('kategori_id', 'asc');
			          			$this->db->where('kategori_status', '1');
			          			
			          			$all = $this->db->get('master_kategori');
			          			$no = 1;

			          			$this->db->order_by('kategori_id', 'asc'); 
			          			$this->db->where('kategori_status', '1');
			          			$this->db->where('kategori_id !=', '4');
			          			$this->db->order_by('kategori_datestart', 'desc');
			          			$this->db->where('kategori_datestart <', date('Y-m-d H:i:s'));
			          			$cekm = $this->db->get('master_kategori');

			          			if ($cekm->num_rows() == 0){
			          				?>
			          					<style>
												    *{box-sizing:border-box}
												    html,body{font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,'Helvetica Neue',Arial}
												    body{ color:#1c3d1e;align-items:center;justify-content:center;}
												    .card{width:100%;max-width:980px;background:linear-gradient(180deg,#ffffff 0%, #e4f7dd 60%);border-radius:18px;padding:32px;box-shadow:0 10px 30px rgba(65,144,47,.14);backdrop-filter: blur(6px)}
												    .row{display:inline-flex;gap:24px;align-items:center}
												    .left{flex:1}
												    .right{width:320px}
												    h1{margin:0;font-size:28px;letter-spacing:0.6px}
												    p.lead{margin:12px 0 20px;color:#4a6b46}
												    .btn{display:inline-block;padding:10px 16px;border-radius:10px;text-decoration:none;font-weight:600}
												    .btn-primary{background:linear-gradient(90deg,var(--accent),#7ec964);color:#fff}
												    .btn-ghost{background:#fff;border:1px solid #c9ecbc;color:#244f21}
												    .countdown{display:flex;gap:8px;margin-top:14px}
												    .countdown .part{background:var(--glass);padding:10px 12px;border-radius:10px;min-width:64px;text-align:center}
												    .part .num{font-weight:800;font-size:18px}
												    .part .label{font-size:11px;color:#4a6b46;margin-top:4px}
												    .subscribe{margin-top:18px;display:flex;gap:8px}
												    .subscribe input{flex:1;padding:10px;border-radius:10px;border:1px solid #c9ecbc;background:#fff;color:#1c3d1e}
												    .subscribe button{padding:10px 12px;border-radius:10px;border:0;background:var(--accent);color:#fff;font-weight:600}
												    .meta{margin-top:18px;display:flex;justify-content:space-between;align-items:center;color:#6b8a66;font-size:13px}
												    .socials{display:flex;gap:8px}
												    .dot{height:10px;width:10px;border-radius:50%;display:inline-block}
												    .sponsors{display:flex;gap:10px;flex-wrap:wrap;margin-top:14px}
												    .sponsor{background:#f2fbf0;padding:8px 12px;border-radius:8px;font-size:13px;color:#4a6b46;border:1px solid #d9efcf}
												    .progress{height:10px;background:#d9efcf;border-radius:999px;overflow:hidden;margin-top:14px}
												    .progress > i{display:block;height:100%;width:36%;background:linear-gradient(90deg,var(--accent),#a5dc90)}
												    footer{margin-top:18px;color:#6b8a66;font-size:13px}
												    /* Responsive */
												    @media (max-width:800px){.row{flex-direction:row}.right{width:100%}}
												  </style>
			          					<div class="row">
				          					<div class="col-12">
				          						<div class="card">
														    <div class="row">
														      <div class="col-8 left">
														        <h1 class="text-dark">KEDIRI HALF MARATHON 2026</h1>
														        <p class="lead">Siapkan dirimu, registrasi KHM 2026 akan segera dibuka!</p>

														        <!-- COUNTDOWN: Set eventDate in the script below. If you don't know the exact date yet, leave a placeholder. -->
														        <div id="countdown" class="countdown" aria-hidden="false">
														          <div class="part fs-4"><div class="num" id="days<?=$no?>">0</div><div class="label">Hari</div></div>
														          <div class="part fs-4"><div class="num" id="hours<?=$no?>">0</div><div class="label">Jam</div></div>
														          <div class="part fs-4"><div class="num" id="minutes<?=$no?>">0</div><div class="label">Menit</div></div>
														          <div class="part fs-4"><div class="num" id="seconds<?=$no?>">0</div><div class="label">Detik</div></div>
														        </div><script>eventDate<?=$no?> = new Date(<?=date('Y,m,d,H,i,s', strtotime($all->row()->kategori_datestart.'-1 month'))?>); </script>

														        <div class="meta">
														          <div>
														            <div style="margin-top:6px">Lokasi: Dhoho International Airport Kabupaten Kediri, Jawa Timur</div>
														          </div>
														          <div class="socials" aria-hidden="false">
														            <a class="btn btn-ghost" target="_blank" href="https://www.instagram.com/kedirihalfmarathon/" aria-label="Instagram"><i class="fa fa-instagram"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-brand-instagram"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 8a4 4 0 0 1 4 -4h8a4 4 0 0 1 4 4v8a4 4 0 0 1 -4 4h-8a4 4 0 0 1 -4 -4z" /><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /><path d="M16.5 7.5v.01" /></svg></i></a>
														          </div>
														        </div>

														        <div class="progress" aria-hidden="false" title="Progress development">
														          <i style="width:100%"></i>
														        </div>

														        <footer>Butuh bantuan? <a href="mailto:kedirihalfmarathon@gmail.com" style="color:inherit;text-decoration:underline">kedirihalfmarathon@gmail.com</a></footer>
														      	
														      </div>

														      <div class="col-4 right" aria-hidden="false">
														        <!-- Visual / Hero - can be replaced with an event photo or map -->
														        <div style="background-color:#fff;padding:18px;border-radius:12px;text-align:center">
														          <img src="https://register.kedirihalfmarathon.com/assets/images/logos/logo_khm.png" alt="Running" style="width:100%;height:160px;object-fit: contain;border-radius:8px;margin-bottom:12px"/>
														          <h3 style="margin:0 0 8px 0" class="text-dark">Tantang dirimu di</h3>
														          <h4  style="margin:0 0 8px 0" class="text-dark">KEDIRI HALF MARATHON 2026</h4>
														        </div>
														      </div>
														    </div>
														  </div>
														</div>
			          				<?php
			          			}else{
			          				echo '<div class=" text-center mb-7"><h2 class=" fw-semibold">PILIHAN PENDAFTARAN</h2><hr></div>';
			          				foreach ($all->result() as $kategori) {
		          				?>
		          				
		          					<div class="card" style="background: linear-gradient(180deg,#ffffff 0%, #e4f7dd 60%); font-size: 12px;">
			          					<div class="card-body row">
			          						<div class="col-1 p-1">
			          							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-ticket"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 5l0 2" /><path d="M15 11l0 2" /><path d="M15 17l0 2" /><path d="M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-3a2 2 0 0 0 0 -4v-3a2 2 0 0 1 2 -2" /></svg>
			          						</div>
						          			<div class="col-5">
						          				<?='Kategori '.$kategori->kategori_name."<br>"?>
						          				<?='Tiket Kediri Half Marathon 2026 Kategori '.$kategori->kategori_name.'<br>'?>
				          						<?php echo '<b>';
				          							if (date('Y-m-d H:i:s') >= $kategori->kategori_dateearly){
				          								echo uang($kategori->kategori_price);
				          							}else{
				          								echo 'Harga Normal : <s class="text-danger">'.uang($kategori->kategori_price)."</s> <br>";
				          								echo 'Harga Early Bird : '.uang($kategori->kategori_priceearly);
				          							}
				          							echo '</b>';
				          						?>
						          			</div>
						          			<?php if (date('Y-m-d H:i:s') <= $kategori->kategori_datestart ){ ?>
						          				<div class="col-12">
						          			<?php }else{ ?>
						          				<div class="col-4" style="text-align: center;margin: auto;">
						          			<?php } ?>
						          				<?php 
				          							$through = true;
				          							$text = '';
				          							if ($kategori->kategori_kuota < 1){
				          								$through = false;
				          								$text = 'Kuota Habis';
				          							}
				          							if (date('Y-m-d H:i:s') >= $kategori->kategori_dateexp ){
				          								$through = false;
				          								$text = 'Kategori Tutup';
				          							}
				          							if (date('Y-m-d H:i:s') <= $kategori->kategori_datestart ){
				          								$through = false;
				          								$tanggale = $kategori->kategori_datestart;
				          								
				          								$text = '<div class="row text-center"><div class="col-12">Dibuka Dalam<br><div id="countdown" class="countdown" aria-hidden="false">
													          <div class="part"><div class="num" id="days'.$no.'">0</div><div class="label">Hari</div></div>
													          <div class="part"><div class="num" id="hours'.$no.'">0</div><div class="label">Jam</div></div>
													          <div class="part"><div class="num" id="minutes'.$no.'">0</div><div class="label">Menit</div></div>
													          <div class="part"><div class="num" id="seconds'.$no.'">0</div><div class="label">Detik</div></div>
													        </div><script>eventDate'.$no.' = new Date('.date('Y,m,d,H,i,s', strtotime($tanggale.'-1 month')).'); </script></div></div>';
													        $no++;

				          							}

				          							if ($through){
				          								if ($kategori->kategori_id == '4'){
				          									?>
				          										<a type="button" data-bs-toggle="modal" 
													              data-modalsize="modal-md"
													              data-title="Masukkan Tanggal Lahir" 
													              data-href="<?=base_url('modal/cek_umur?cat='.$kategori->kategori_id)?>"  
													              data-bs-target="#ajax-modal"  class="btn btn-danger">DAFTAR SEKARANG</a>
				          									<?php
				          								}else{
				          							?>

				          								<button type="submit" name="cat" value="<?=$kategori->kategori_id?>" class="btn btn-danger">DAFTAR SEKARANG</button>
				          							<?php }}else{
				          								echo '<p class="text-danger">'.$text.'</p>';
				          						} ?>
						          				</div>
						          		</div>
					          		</div>
		          				<?php
			          			}}
			          		?>
		          		</form>
		          	</div>
		          </div>
			      </div>
			  <?php 
					}else{
						$siGroup = $cek->row();
						$this->db->where('pelari_group', $userdata->pelari_group);
						$jml = $this->db->get('master_pelari')->num_rows();
				?>
						<div class="row">
						  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						    <div class="card">
						      <div class="card-body">
						        <div class="table-responsive">
						          <table id="data_table" style="width:100%" class="table align-middle text-center mb-0" data-url="<?=base_url('usertable/list_pelari_group')?>">
						            <thead>
						              <tr> 
						                <th width="2%" >NO</th>
						                <th width="10%">NAMA PELARI</th>
						                <th width="10%">EMAIL</th>
						                <th width="10%">KATEGORI LARI</th>
						                <th width="10%">UKURAN KAOS</th>
						                <th width="10%">FINISHER JACKET</th>
						                <th width="10%">DATE JOIN</th>
						                <th width="10%"><?=(!$view_bib)? 'OPSI' : 'NO. BIB'?></th>
						              </tr>
						            </thead>
						          </table>
						        </div>
						      </div>
						    </div>
						  </div>
						</div>
						<?php if ($userdata->pelari_bib == ''){ ?>
						<button type="button" id="pros" class="btn btn-success font-medium rounded-pill px-4"
              data-bs-toggle="modal" 
              data-modalsize="modal-lg"
              style="display:none"
              data-title="Proses Pembelian Tiket" 
              data-href="<?=base_url('modal/tiket')?>"  
              data-bs-target="#ajax-modal"
            ></button>
          	<?php } ?>

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
						          "targets": [ 0 ], 
						          "orderable": false, 
						          "searchable": false,
						        } ],
						        "ajax": {
						            "url": $('#data_table').data('url'),
						            "type": "GET",
						            "data": function(data){}
						        },
						        "bFilter": true,
						        "dom": 'lBfrtip',
						        "buttons": [
						        	<?php if ($userdata->pelari_bib == null){
						        	if ($userdata->pelari_group != null){ ?>
						        		<?php $jml = $this->db->get_where('master_pelari', ['pelari_group' => $userdata->pelari_group])->num_rows();?>
						        	<?php if ($jml > 0){ ?>
					          {
					            "text": '<i class="fa fa-trash" title="Hapus"> Hapus Group</i>',
					            "className": 'btn btn-danger btn-disabled float-right ml-1',
					            "action": function ( e, dt, node, config ) {
					            	Swal.fire({
									        title: 'Tidak Dapat Hapus Data',
									        text: "Anda Harus Mengosongkan Data Pelari sebelum menghapus Group",
									        icon: 'error',
									        showCancelButton: false,
									        confirmButtonColor: '#3085d6',
									        cancelButtonColor: '#d33',
									        confirmButtonText: 'Ok',
									      });
					            }
					          },
					           <?php }}else{ ?>
					          	{
					            "text": '<i class="fa fa-trash" title="Hapus"> Hapus Group</i>',
					            "className": 'btn btn-danger btn-reload-table float-right ml-1',
					            "action": function ( e, dt, node, config ) {
					              hapus_group('<?=$siGroup->group_name?>');
					            }
					          },
					          <?php } ?>
					          {
					            "text": '<i class="fa fa-plus" title="Tambahkan Pelari"></i>',
					            "className": 'btn btn-info btn-reload-table float-right ml-1',
					            "action": function ( e, dt, node, config ) {
					              location.href="<?=base_url('page/daftar_lari?group_add=true&cat=1')?>";  
					            }
					          },{
					            "text": '<i class="fa fa-edit" title="Ubah Nama Group"></i>',
					            "className": 'btn btn-warning float-right ml-1',
					            "action": function ( e, dt, node, config ) {
					              ubah_nama('<?=$siGroup->group_name?>');
					            }
					          },<?php
                    $this->db->where('pelari_user', userid());
                    $ok = $this->db->get('master_pelari');
                    if ($ok->num_rows() > 0){
                    	$grp = $ok->row()->pelari_group;
                    	$this->db->where('pelari_group', $grp);
                    	$ok2 = $this->db->get('master_pelari');
                    	if ($ok2->num_rows() >= 7){
                    	    if ($ok->row()->pelari_setuju != 'T'){
                  ?>
										{
					            "text": '<i class="ti ti-cash"> </i> Lanjutkan Proses ',
					            "className": 'btn btn-success btn-reload-table float-right ml-1',
					            "action": function ( e, dt, node, config ) {
					              $('#pros').click();
					            }
					          },
                  	
                  
                  <?php }}}} ?>
                  {
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
						  });
						  
						</script>
				<?php
					}
				?>
	    </div>
	  </div>
	  <?php if ($view_bib){ ?>
	  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="d-sm-flex d-block align-items-center justify-content-between mb-7">
            <div class="mb-3 mb-sm-0">
              <h5 class="card-title fw-semibold">Informasi</h5>
            </div>
          </div>
          <div>
							<?=option('informasi')?>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>
	</div>
</div>

<script type="text/javascript">
	
  function tick1(){
    const now = new Date();
    const diff = Math.max(0, eventDate1 - now);
    const s = Math.floor(diff/1000);
    const d = Math.floor(s / (3600*24));
    const h = Math.floor((s % (3600*24)) / 3600);
    const m = Math.floor((s % 3600) / 60);
    const sec = s % 60;
    $('#days1').html(pad(d));
    $('#hours1').html(pad(h));
    $('#minutes1').html(pad(m));
    $('#seconds1').html(pad(sec));
    if (diff === 0) {
    	console.log(s,d,h,m,sec,diff);
	    location.reload(); 
	  }
  }
  if (eventDate1 != ''){
  	setInterval(tick1,1000);
  }

  function tick2(){
    const now2 = new Date();
    diff2 = Math.max(0, eventDate2 - now2);
    s2 = Math.floor(diff2/1000);
    d2 = Math.floor(s2 / (3600*24));
    h2 = Math.floor((s2 % (3600*24)) / 3600);
    m2 = Math.floor((s2 % 3600) / 60);
    sec2 = s2 % 60;
    $('#days2').html(pad(d2));
    $('#hours2').html(pad(h2));
    $('#minutes2').html(pad(m2));
    $('#seconds2').html(pad(sec2));
    if (diff2 === 0) {
    	console.log(s2,d2,h2,m2,sec2,diff2);
	    location.reload(); 
	  } 
  }
  if (eventDate2 != ''){
  	setInterval(tick2,1000);
  }

  function tick3(){
    const now3 = new Date();
    diff3 = Math.max(0, eventDate3 - now3);
    s3 = Math.floor(diff3/1000);
    d3 = Math.floor(s3 / (3600*24));
    h3 = Math.floor((s3 % (3600*24)) / 3600);
    m3 = Math.floor((s3 % 3600) / 60);
    sec3 = s3 % 60;

    $('#days3').html(pad(d3));
    $('#hours3').html(pad(h3));
    $('#minutes3').html(pad(m3));
    $('#seconds3').html(pad(sec3));

    if (diff3 === 0) {
    	console.log(s3,d3,h3,m3,sec3,diff3);
	    location.reload(); 
	  } 
  }
  if (eventDate3 != ''){
  	setInterval(tick3,1000);
  }
  
	function ubah_nama(group_name=''){
			nama_lama = group_name;
	    Swal.fire({
	      title: 'Ubah Nama Group Anda ?' ,
	      input: 'text',
	      inputAttributes: {
	        autocapitalize: 'off',
	      },
      	inputValue: group_name,
	      showCancelButton: true,
	      confirmButtonText: 'CHECK',
	      preConfirm: (nama_baru) => {
	        return fetch(`<?=base_url('userdata/ubah_nama_group')?>`, {
	          method: "POST",
	          body: JSON.stringify({nama_baru,nama_lama})
	          
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
	          icon: results.value.type,
	        }).then(() => {
	          if (!results.value.status){
	            ubah_nama(nama_lama);
	          }else{
	          	location.reload();
	          }
	        });
	      }
	    })
	  }
</script>