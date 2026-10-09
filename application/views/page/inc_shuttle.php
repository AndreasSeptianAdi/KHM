<script type="text/javascript" src="<?=MIDTRANS_SNAP?>" data-client-key="<?=MIDTRANS_CLIENT_KEY?>"></script>
<div class="container-fluid">
	<div class="row">
	  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	    <div class="card">
	      <div class="card-body">
	      	<div class="d-sm-flex d-block align-items-center justify-content-between mb-7">
            <div class="mb-3 mb-sm-0">
              <h5 class="card-title fw-semibold">Shuttle Kediri Half Marathon 2026</h5>
            </div>
          </div>

          <?php 
          	$this->db->where('shuttle_user', userdata()->user_id);
          	$cek = $this->db->get('master_shuttle');
          	if ($cek->num_rows() > 0){
          		$shuttle = $cek->row();
          		if ($shuttle->shuttle_pos == 1){
          			$img = '<img src="'.base_url('assets/images/maps/pemkot.png').'" width="100%">';
								$lokasi = 'Titik 0 Pemkot Kediri';
          			$warna = 'danger';
          		}else if ($shuttle->shuttle_pos == 2){
								$img = '<img src="'.base_url('assets/images/maps/pemkab.png').'" width="100%">';
								$lokasi = 'Pemkab Kediri';
								$warna = 'success';
          		}else if ($shuttle->shuttle_pos == 3){
								$img = '<img src="'.base_url('assets/images/maps/gumul.png').'" width="100%">';
								$lokasi = 'Simpang Lima Gumul';
								$warna = 'warning';
          		}else if ($shuttle->shuttle_pos == 4){
								$img = '<img src="'.base_url('assets/images/maps/lotus.png').'" width="100%">';
								$lokasi = 'Hotel Lotus Garden';
								$warna = 'primary';
          		}
          ?>
	          <style>
						  /* Page sizing for print */
						  @page { size: 7in 2in; margin: 0; }

						  /* Ticket container fixed to 7in x 2in */
						  .ticket {
						    width: 100%;
						    box-sizing: border-box;
						    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
						    display: flex;
						    align-items: stretch;
						    justify-content: space-between;
						    border: 1px solid #ddd;
						    padding: 2rem;
						    background: linear-gradient(90deg,#ffffff,#fbfbfb);
						    color: #111;
						  }

						  /* Left area: info */
						  .left {
						    flex: 1 1 60%;
						    display: flex;
						    flex-direction: column;
						    justify-content: space-between;
						    padding-right: 0.12in;
						  }
						  .brand {
						    display:flex;align-items:center;gap:8px;
						  }
						  .logo {
						    width:80px;height:50px;border-radius:6px;background:#2228;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:16px;
						  }
						  .route {
						    font-size:14px;font-weight:700;letter-spacing:0.2px;
						  }
						  .meta { font-size:10.5px;color:#3338;margin-top:3px }

						  /* Right area: price + QR */
						  .right {
						    flex: 0 0 34%;
						    display:flex;flex-direction:column;align-items:center;justify-content:space-between;padding-left:0.12in;border-left:1px dashed #ddd;
						  }
						  .price {
						    font-size:20px;font-weight:800;color:#d93a2c;
						  }
						  .price small{ display:block;font-size:10px;font-weight:600;color:#333 }

						  .qr {
						    width:200px;height:200px;display:flex;align-items:center;justify-content:center;border-radius:6px;font-size:10px;color:#999;border:1px solid #eee;
						  }

						  /* Ticket footer small text */
						  .footer { font-size:8.5px;color:#666 }

						  /* Make printable exactly to size and remove default margins */
						  @media print{
						    body,html{margin:0;padding:0}
						    .ticket{box-shadow:none;border:none}
						  }

						  @media (max-width: 600px) {
							  .ticket {
							    flex-direction: column;
							    padding: 14px;
							  }

							  .right {
							    width: 100%;
							    border-left: none;
							    border-top: 1px dashed #ccc;
							    padding-left: 0;
							    padding-top: 14px;
							    text-align: center;
							  }

							  .right .qr img {
							    width: 110px;
							  }

							  .price {
							    font-size: 24px;
							  }
							}

							/* Support very small screens */
							@media (max-width: 400px) {
							  .brand .logo {
							    width: 80px;
							    height: 80px;
							  }

							  .route h4 {
							    font-size: 16px;
							  }

							  .left div[style*='font-size:20px'] {
							    font-size: 16px !important;
							  }
							}

						  /* Utility */
						  .right .value { font-weight:700 }
						</style>

						<?php if ($shuttle->shuttle_status == 'success'){ ?>
							<div id="isi_tiket">
          	<div class="ticket" role="article" aria-label="Tiket Shuttle">
          		<style>
							  /* Ticket container fixed to 7in x 2in */
							  .ticket {
							    width: 100%;
							    box-sizing: border-box;
							    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
							    display: flex;
							    align-items: stretch;
							    justify-content: space-between;
							    border: 1px solid #ddd;
							    padding: 2rem;
							    background: linear-gradient(90deg,#ffffff,#fbfbfb);
							    color: #111;
							  }

							  /* Left area: info */
							  .left {
							    flex: 1 1 60%;
							    display: flex;
							    flex-direction: column;
							    justify-content: space-between;
							    padding-right: 0.12in;
							  }
							  .brand {
							    display:flex;align-items:center;gap:8px;
							  }
							  .logo {
							    width:80px;height:50px;border-radius:6px;background:#2228;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:16px;
							  }
							  .route {
							    font-size:14px;font-weight:700;letter-spacing:0.2px;
							  }
							  .meta { font-size:10.5px;color:#3338;margin-top:3px }

							  /* Right area: price + QR */
							  .right {
							    flex: 0 0 34%;
							    display:flex;flex-direction:column;align-items:center;justify-content:space-between;padding-left:0.12in;border-left:1px dashed #ddd;
							  }
							  .price {
							    font-size:20px;font-weight:800;color:#d93a2c;
							  }
							  .price small{ display:block;font-size:10px;font-weight:600;color:#333 }

							  .qr {
							    width:200px;height:200px;display:flex;align-items:center;justify-content:center;border-radius:6px;font-size:10px;color:#999;border:1px solid #eee;
							  }

							  /* Ticket footer small text */
							  .footer { font-size:8.5px;color:#666 }

							  /* Utility */
							  .right .value { font-weight:700 }

							  .text-indigo {
									color: #5410f2 !important;
								}
								.bg-indigo{
									background-color:#6610f2 !important;
								}
								.text-success {
							  	color: #13deb9 !important;
								}
								.bg-success{
									background-color:#6610f2 !important;
								}
								.text-warning {
							  	color: #ffae1f !important;
								}
								.bg-warning{
									background-color:#6610f2 !important;
								}

							</style>
						  <div class="left">
						    <div>
						      <div class="brand">
						        <div class="logo"><?=$img?></div>
						        <div>
						        	<?php 
						        		if ($shuttle->shuttle_pos == 1){
						        			$cl = 'indigo';
						        		}else if ($shuttle->shuttle_pos == 2){
													$cl = 'success';
												}else{
													$cl = 'warning';
												}
						        	?>
						          <div class="route text-<?=$cl?>"><h4>Shuttle Service</h4><?=$lokasi?> → Bandara Dhoho Internatioal Airports</div>
						          <div class="meta fs-5">Keberangkatan: <i class="text-<?=$cl?>">17 Mei 2026 • 03:45</i> </div>
						        </div>
						      </div>

						      <?php 
						      	$this->db->join('master_pelari', 'pelari_user = user_id', 'left');
						      	$this->db->join('master_kategori', 'pelari_kategori = kategori_id', 'left');
						      	$this->db->where('user_id', userid());
						      	$userdata = $this->db->get('master_user')->row();
						      ?>

						      <div style="margin-top:18px">
						        <div style="font-size:15px;font-weight:700">Data Penumpang</div>
						        <div style="font-size:20px;margin-top:2px"><?=$userdata->pelari_name?> - <?=$userdata->kategori_name?></div>
						        <div class="text-<?=$cl?>" style="font-size:30px;margin-top:2px"><?=$userdata->pelari_bib?></div>
						      </div>
						    </div>

						    <div class="footer">No. Tiket: <?=$shuttle->shuttle_orderid?> • Tunjukkan tiket ini saat boarding • Non-refundable</div>
						  </div>

						  <div class="right">
						    <div style="text-align:center">
						      <div class="price"><small>Harga</small>Rp 40.000</div>
						    </div>

						    <div class="qr bg-<?=$cl?>" aria-hidden="true">
						      <img width="170px" src="<?=base_url('assets/qr/shuttle/'.$shuttle->shuttle_qr.'.jpeg')?>">
						    </div>

						    <div style="font-size:9px;color:#666;text-align:center"> • Diperlukan identitas saat naik •</div>
						  </div>
						</div>
						<div class="terms" style="margin-top:16px;font-size:14px;line-height:1.45;color:#000;">
							<strong>Syarat dan Ketentuan Shuttle Bus:</strong>
							<ol style="padding-left:16px;margin-top:6px;">
							<li>Shuttle bus hanya diperuntukkan untuk peserta Kediri Half Marathon 2026.</li>
							<li>Satu peserta hanya bisa membeli 1 tiket shuttle.</li>
							<li>Harga yang tertera adalah harga untuk keberangkatan dan kepulangan.</li>
							<li>Tiket shuttle bus yang telah dibeli tidak dapat dikembalikan atau dipindahtangankan.</li>
							<li>Tidak bisa melakukan perubahan lokasi penjemputan. Pastikan memilih lokasi shuttle dengan benar.</li>
							<li>Peserta wajib berangkat dan kembali melalui titik yang telah ditentukan.</li>
							<li>Peserta wajib memperhatikan waktu keberangkatan. Pastikan hadir sebelum waktu yang ditentukan.</li>
							<li>Peserta yang tidak datang di jam yang ditentukan dianggap tidak berangkat/kembali menggunakan shuttle.</li>
							</ol>
							</div>
							</div>
						<center><button class="btn btn-lg btn-success" onclick="cetakIn('isi_tiket','e-Ticket Shuttle')">CETAK</button></center>

						<?php }else{ ?>
							<div id="snap-container" style="width:100%"></div>
						<?php } ?>
        	<?php }else{ ?>
        		<script type="text/javascript">
						    window.onbeforeunload = function() {
						        return "Are You Sure?";
						    }
						</script>
						<style>
							.shuttle-card{
								border: 1px solid #ebebeb !important;
						  	padding: 1rem;
							}
						</style>
	          <div class="shuttle-grid row g-2">
						  <div class="col-lg-4 col-md-12 shuttle-card text-center text-danger">
						    <h4 class="mb-4 text-danger">SHUTTLE 1</h4>
						    <p class="mb-3">Jemput di Titik 0 Pemkot Kediri</p>
						    <a target="_blank" href="https://maps.app.goo.gl/DQG3h3r66Hf2yEv36">
						      <img src="<?=base_url('assets/images/maps/pemkot.png')?>" width="100%">
						    </a>
						    <h4 class="mt-3 text-danger">Rp. 40.000</h4>
						    <button class="btn btn-danger btn-lg pesan" data-id="1">PESAN</button>
						  </div>

						  <div class="col-lg-4 col-md-12 shuttle-card text-center text-success">
						    <h4 class="mb-4 text-success">SHUTTLE 2</h4>
						    <p class="mb-3">Jemput di Pemkab Kediri</p>
						    <a target="_blank" href="https://maps.app.goo.gl/1zZRWcokD76mVTko8">
						      <img src="<?=base_url('assets/images/maps/pemkab.png')?>" width="100%">
						    </a>
						    <h4 class="mt-3 text-success">Rp. 40.000</h4>
						    <button class="btn btn-success btn-lg pesan" data-id="2">PESAN</button>
						  </div>

						  <div class="col-lg-4 col-md-12 shuttle-card text-center text-warning">
						    <h4 class="mb-4 text-warning">SHUTTLE 3</h4>
						    <p class="mb-3">Jemput di Simpang Lima Gumul</p>
						    <a target="_blank" href="https://maps.app.goo.gl/JRsmxwsMMo11enjK6">
						      <img src="<?=base_url('assets/images/maps/gumul.png')?>" width="100%">
						    </a>
						    <h4 class="mt-3 text-warning">Rp. 40.000</h4>
						    <button class="btn btn-warning btn-lg pesan" data-id="3">PESAN</button>
						  </div>

						  <div class="terms col-12" style="margin-top:16px;font-size:14px;line-height:1.45;color:#fff; width:100%">
								<strong>Syarat dan Ketentuan Shuttle Bus:</strong>
								<ol style="padding-left:16px;margin-top:6px;">
									<li>Shuttle bus hanya diperuntukkan untuk peserta Kediri Half Marathon 2026.</li>
									<li>Satu peserta hanya bisa membeli 1 tiket shuttle.</li>
									<li>Harga yang tertera adalah harga untuk keberangkatan dan kepulangan.</li>
									<li>Tiket shuttle bus yang telah dibeli tidak dapat dikembalikan atau dipindahtangankan.</li>
									<li>Tidak bisa melakukan perubahan lokasi penjemputan. Pastikan memilih lokasi shuttle dengan benar.</li>
									<li>Peserta wajib berangkat dan kembali melalui titik yang telah ditentukan.</li>
									<li>Peserta wajib memperhatikan waktu keberangkatan. Pastikan hadir sebelum waktu yang ditentukan.</li>
									<li>Peserta yang tidak datang di jam yang ditentukan dianggap tidak berangkat/kembali menggunakan shuttle.</li>
								</ol>
							</div>
						</div>

						<div id="keterangan" class="text-center text-warning fs-7 fs-bold"></div>
	          <div id="snap-container" class="mt-5" style="width:100%"></div>

	          <center><button class="btn btn-lg btn-warning btl mt-5" style="display:none" onclick="location.reload();">BATAL</button></center>
	          <script type="text/javascript">
							$('.pesan').click(function(event) {
								idnya = $(this).data('id');
								if (idnya == 1){
									nama_shuttle = 'SHUTTLE 1 - Titik 0 Pemkot Kediri';
								}else if (idnya == 2){
									nama_shuttle = 'SHUTTLE 2 - Pemkab Kediri';
								}else{
									nama_shuttle = 'SHUTTLE 3 - Simpang Lima Gumul';
								}
								$('#keterangan').html(nama_shuttle);
								$('.btl').show();
								$('.shuttle-grid').hide();
								event.preventDefault();
								$('body').loading();
								$.ajax({
								  url: '<?=base_url('userpay/process_shuttle/') ?>',
								  type: 'post',
								  dataType: 'html',
								  data: {userid:'<?=userid()?>',idnya},
								})
								.done(function( token ) {
									function pembayaran(result_data, status){
										$('#tiket_view').loading();
						        $.ajax({
						          url: '<?=base_url('userpay/done')?>',
						          type: 'post',
						          dataType: 'json',
						          data: {result_data, status},
						        })
						        .done(function(dataPembayaran) {
						          Swal.fire({
						            title: dataPembayaran.heading,
						            html: dataPembayaran.message,
						            icon: dataPembayaran.type
						          }).then(function(){
						          	$('.btl').hide();
						          	$('.shuttle-grid').show();
						          	$('#keterangan').html('');
						            location.reload();
						          });
						        })
						      }

						      $('.pesan').hide();
						      
						      window.snap.embed(token, {
						        embedId: 'snap-container',
						        onSuccess: function(result){
						        	console.log('success');
						          pembayaran(result, 'success');
						        },
						        onPending: function(result){
						        	console.log('pending');
						          pembayaran(result, 'pending');
						        },
						        onError: function(result){
						        	console.log('failed');
						          pembayaran(result, 'failed');
						        }
						      });
								})
								.always(function(){
								  $('body').loading('stop');
								});
							});
						</script>
        	<?php } ?>
	      </div>
	    </div>
	  </div>
	</div>
</div>

<script>
	$('#hapus_tike').click(function(event) {
		event.preventDefault();
		$('body').loading();
		$.ajax({
		  url: '<?=base_url('userpay/hapus_tiket') ?>',
		  type: 'post',
		  dataType: 'json',
		  data: {userid:'<?=userid()?>'},
		})
		.done(function( data ) {
		  location.reload();
		})
		.always(function(){
		  location.reload();
		});
	});

	function cetakIn(divId, title) {
    var content = document.getElementById(divId).innerHTML;
    var mywindow = window.open('', title, 'height=600,width=800');

    mywindow.document.write('<html><head><title>'+title+'</title>');
    mywindow.document.write('<link rel="stylesheet" href="<?=base_url()?>assets/styles/style.min.css">');
    mywindow.document.write('</head><body >');
    mywindow.document.write(content);
    mywindow.document.write('</body></html>');

    mywindow.document.close();
    mywindow.focus()
    mywindow.print();
  }
</script>