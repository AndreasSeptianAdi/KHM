<?php /*<div class="card text-center">
			<div class="card-inner">
	      <div class="emoji" style="font-size:64px;" aria-hidden="true">😔</div>

	      <h4 id="headline" class="headline">Ups! Semua tiket sudah terjual habis</h4>

	      <p class="sub">Terima kasih atas minat Anda pada KHM 2027!</p>

	      <section class="info-box" aria-label="Apa yang dapat Anda lakukan">
	        <h4 class="info-title">Apa yang dapat Anda lakukan:</h4>
	        <ul class="info-list">
	          <li>1. Periksa kembali nanti untuk kemungkinan pembatalan</li>
	          <li>2. Ikuti media sosial kami untuk acara mendatang</li>
	        </ul>
	      </section>
	    </div>
	  </div> */?>




<?php 
	// if (date('Y-m-d H:i') >= date('Y-m-d H:i', strtotime(option('last_regis')))) {
		// echo '<div class="row"><h2 class="col-12 text-center"><br>Pendafataran telah BERAKHIR<br>Sampai jumpa di event selanjutnya</h2></div><br><br>';
	// }else{
?>

<script type="text/javascript" src="<?=MIDTRANS_SNAP?>" data-client-key="<?=MIDTRANS_CLIENT_KEY?>"></script>
<?php 


	$through = false;
	$in_group = false;
	$this->db->where('pelari_user', userid());
	$this->db->join('master_kategori', 'kategori_id = pelari_kategori', 'left');
  $ok = $this->db->get('master_pelari');
  if ($ok->num_rows() == 0){ ?><script>location.href='';</script><?php }else{$through = true;$in_group = false;}

  $grp = $ok->row()->pelari_group;
  if ($grp != null){
		$this->db->where('pelari_group', $grp);
		$this->db->join('master_kategori', 'kategori_id = pelari_kategori', 'left');
		$ok2 = $this->db->get('master_pelari');
		if ($ok2->num_rows() < 2){ ?><script>location.href='';</script><?php }else{$through = true;$in_group = true;}
	}


	if ($ok->row()->kategori_kuota < 1){
		?>
		<div class="card text-center">
			<div class="card-inner">
	      <div class="emoji" style="font-size:64px;" aria-hidden="true">😔</div>

	      <h4 id="headline" class="headline">Ups! Semua tiket sudah terjual habis</h4>

	      <p class="sub">Terima kasih atas minat Anda pada KHM 2027!</p>

	      <section class="info-box" aria-label="Apa yang dapat Anda lakukan">
	        <h4 class="info-title">Apa yang dapat Anda lakukan:</h4>
	        <ul class="info-list">
	          <li>1. Periksa kembali nanti untuk kemungkinan pembatalan</li>
	          <li>2. Ikuti media sosial kami untuk acara mendatang</li>
	        </ul>
	      </section>
	    </div>
	  </div>

	    <?php 
	    /* <script>
	    // 	$('#ubahkat').click(function(event) {
			// 		event.preventDefault();
			// 		$('body').loading();
			// 		$.ajax({
			// 		  url: '<?=base_url('userdata/ubah_kategori_lari') ?>',
			// 		  type: 'post',
			// 		  dataType: 'json',
			// 		  data: [],
			// 		})
			// 		.done(function( data ) {
			// 		  Swal.fire({
			// 		    title: data.heading,
			// 		    html: data.message,
			// 		    icon: data.type
			// 		  }).then(function(){
			// 		    if (data.status) {location.href="<?=base_url('page/daftar')?>";}
			// 		  })
			// 		})
			// 		.always(function(){
			// 		  $('body').loading('stop');
			// 		});
			// 	});
	     </script>*/
	     ?>
		<?php
		return false;
	}

	$total_harga = 0;
	$no = 0;
	if ($through){
		if ($in_group){
			$list = $ok2->result();
			foreach($list as $pelari){
				$harga = harga_group($pelari->kategori_id); //-50000;
				
				$detail[$no]['kategori'] = $pelari->kategori_name;
				$detail[$no]['price'] = $harga;
				$detail[$no]['nama'] = $pelari->pelari_name;
				$total_harga += $harga;
				$no++;
			}
		}else{
			$pelari = $ok->row();
			$total_harga = $pelari->kategori_price;
			if (date('Y-m-d H:i:s') <= date('Y-m-d H:i:s', strtotime($pelari->kategori_dateearly))){
				$total_harga = $pelari->kategori_priceearly;
			}
			$detail[$no]['kategori'] = $pelari->kategori_name;
			$detail[$no]['price'] = $total_harga;
			$detail[$no]['nama'] = $pelari->pelari_name;
		}
	}
?>

<div class="row" id="tiket_view">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table id="data_table2" style="width:100%" class="table table-dark align-middle text-center mb-0" data-url="<?=base_url('admintable/list_pelari')?>">
            <thead>
              <tr> 
                <th width="2%" >NO</th>
                <th width="10%">NAMA PELARI</th>
                <th width="10%">Kategori</th>
                <th width="10%">Harga Tiket</th>
              </tr>
            </thead>
            <tbody>
            	<?php 
            		$noo = 1;
            		foreach ($detail as $value) {
            			echo '<tr>';
            			echo '<td>'.$noo++.'</td>';
            			echo '<td>'.$value['nama'].'</td>';
            			echo '<td>'.$value['kategori'].'</td>';
            			echo '<td>'.uang($value['price']).'</td>';
            		}
            	?>
            </tbody>
            <tfoot>
            	<tr>
            		<td colspan="3"></td>
            		<td>Total : <b><?=uang($total_harga)?></b></td>
            	</tr>
            </tfoot>
          </table>
        </div>

        <center>
        <button class="btn btn-success mt-3" id="pay"><i class="ti ti-cash"></i> Bayar Sekarang</button>
        </center>
        <div class="row text-center" >
        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
        		<center>
        		<div id="snap-container" style="width:100%"></div>
        		</center>
        	</div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	$('#pay').click(function(event) {
		event.preventDefault();
		$('body').loading();
		$.ajax({
		  url: '<?=base_url('userpay/process/') ?>',
		  type: 'post',
		  dataType: 'html',
		  data: {userid:'<?=userid()?>'},
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
            location.reload();
          });
        })
      }

      $('#pay').hide();
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

<?php //} ?>

<?php  ?>