<div id="cetak_ini">
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

<?php 
	if (get('id') == '1'){
		$img = '<img src="'.base_url('assets/images/maps/pemkot.png').'" width="100%">';
		$lokasi = 'Titik 0 Pemkot Kediri';
		$warna = 'indigo';
	}else if (get('id') == '2'){
		$img = '<img src="'.base_url('assets/images/maps/pemkab.png').'" width="100%">';
		$lokasi = 'Pemkab Kediri';
		$warna = 'success';
	}else{
		$img = '<img src="'.base_url('assets/images/maps/gumul.png').'" width="100%">';
		$lokasi = 'Simpang Lima Gumul';
		$warna = 'warning';
	}

  $this->db->where('shuttle_id', get('id'));
  $shuttle = $this->db->get('master_shuttle')->row();
?>
  
  <div class="ticket" id="isi_tiket" role="article" aria-label="Tiket Shuttle">
    <div class="left">
      <div>
        <div class="brand">
          <div class="logo"><?=$img?></div>
          <div>
            <div class="route text-<?=$warna?>"><h4>Shuttle Service</h4><?=$lokasi?> → Bandara Dhoho Internatioal Airports</div>
            <div class="meta fs-5">Keberangkatan: <i class="text-danger">17 Mei 2027 • 03:45</i> </div>
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
          <div class="text-<?=$warna?>" style="font-size:30px;margin-top:2px"><?=$userdata->pelari_bib?></div>
        </div>
      </div>

      <div class="footer">No. Tiket: <?=$shuttle->shuttle_orderid?> • Tunjukkan tiket ini saat boarding • Non-refundable</div>
    </div>

    <div class="right">
      <div style="text-align:center">
        <div class="price"><small>Harga</small>Rp 40.000</div>
      </div>

      <div class="qr bg-<?=$warna?>" aria-hidden="true">
        <img width="170px" src="<?=base_url('assets/qr/shuttle/'.$shuttle->shuttle_qr.'.jpeg')?>">
      </div>

      <div style="font-size:9px;color:#666;text-align:center"> • Diperlukan identitas saat naik •</div>
    </div>
  </div> 
  <div class="terms" style="margin-top:16px;font-size:14px;line-height:1.45;color:#000;">
    <strong>Syarat dan Ketentuan Shuttle Bus:</strong>
    <ol style="padding-left:16px;margin-top:6px;">
    <li>Shuttle bus hanya diperuntukkan untuk peserta Kediri Half Marathon 2027.</li>
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
  