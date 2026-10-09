<?php 
	// $ok = base_url('');
	$password = BASE_PASSWORD;
	$bib=openssl_encrypt(get('bib'),"AES-128-ECB",$password);
	$ok = strip_tags($bib);
	$new = str_replace('/', '-', $ok);
	$text = get('bib');

?>

<style>
  :root{
    --card-bg: #ffffff;
    --accent: #0f62fe;
    --muted: #6b7280;
    --shadow: 0 6px 18px rgba(15, 34, 70, 0.08);
    --radius: 12px;
    --border: 1px solid rgba(15,22,39,0.06);
    --font-sans: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
  }

  /* Page background */
  .body{
    margin: 24px;
    font-family: var(--font-sans);
    font-size: 12px;
    background: linear-gradient(180deg, #f7fbff 0%, #ffffff 100%);
    color: #0f1724;
    border-radius: 15px;
  }

  .print-btn {
    display: inline-block;
    margin-bottom: 20px;
    padding: 10px 18px;
    background: var(--accent);
    color: white;
    font-weight: 600;
    font-size: 14px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(15, 98, 254, 0.2);
    transition: background 0.2s ease;
  }
  .print-btn:hover {
    background: #004ad9;
  }

  /* Ticket wrapper */
  .ticket {
    max-width: 900px;
    margin: 0 auto;
    background: var(--card-bg);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    border: var(--border);
    overflow: hidden;
    display: grid;
    grid-template-columns: 320px 1fr;
    gap: 0;
    align-items: stretch;
  }

  /* Left: QR column */
  .ticket__qr {
    background: linear-gradient(180deg, #f0f7ff 0%, #ffffff 100%);
    padding: 28px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 18px;
  }
  .ticket__qr .qr-wrap{
    width: 240px;
    height: 240px;
    background: #fff;
    border-radius: 10px;
    display:flex;
    align-items:center;
    justify-content:center;
    box-shadow: 0 6px 18px rgba(2,6,23,0.06);
    border: 1px solid rgba(2,6,23,0.04);
    overflow: hidden;
  }
  .ticket__qr img.qr {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .ticket__qr p{
    margin:0;
    color: var(--muted);
    font-size: 12px;
  }

  /* Right: Participant data */
  .ticket__info{
    padding: 22px 28px;
    display:flex;
    flex-direction:column;
    gap:12px;
  }
  .brand {
    display:flex;
    align-items:center;
    gap:12px;
  }
  .brand__logo{
    width:80px;
    height:80px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
    font-size:16px;
  }
  .brand__title{
    font-size:14px;
    font-weight:700;
    line-height:1;
  }
  .brand__subtitle{
    font-size:12px;
    color:var(--muted);
  }

  .participant {
    margin-top: 6px;
    display:grid;
    grid-template-columns: 1fr auto;
    gap:12px;
    align-items:center;
  }

  .participant__name {
    font-size:18px;
    font-weight:700;
    letter-spacing:0.2px;
  }
  .participant__meta {
    color:var(--muted);
    font-size:12px;
    margin-top:6px;
  }

  .details {
    margin-top: 14px;
    display:grid;
    grid-template-columns: repeat(2, minmax(0,1fr));
    gap:12px;
  }
  .detail {
    background: #fbfdff;
    border-radius:10px;
    padding:12px;
    border: 1px solid rgba(2,6,23,0.03);
  }
  .detail__label { font-size:11px; color:var(--muted); margin-bottom:6px; }
  .detail__value { font-weight:700; font-size:13px; }

  .footer {
    margin-top: auto;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
    padding-top:10px;
  }
  .chip {
    font-size:12px;
    padding:8px 12px;
    border-radius:999px;
    background:rgba(15,98,254,0.09);
    color:var(--accent);
    font-weight:600;
    border: 1px solid rgba(15,98,254,0.12);
  }

  .notes {
    font-size:11px;
    color:var(--muted);
  }

  /* Small screens: stack vertically and scale */
  @media (max-width:720px){
    .ticket{ grid-template-columns: 1fr; max-width:420px; }
    .ticket__qr{ padding:20px; }
    .ticket__qr .qr-wrap{ width:180px; height:180px; }
  }

  /* Print friendly */
  @media print{
    body{ margin:0; background: white; }
    .ticket{ box-shadow:none; border:none; }
  }
</style>
<?php 
$this->db->join('master_pelari', 'pelari_user = user_id', 'left');
$this->db->join('master_kategori', 'kategori_id = pelari_kategori', 'left');
$userdata = $this->db->get_where('master_user', ['user_id' => userid()])->row(); ?>
<div class="body" id="body">
  <div class="ticket" role="region" aria-label="Tiket Marathon">
    <!-- LEFT: QR -->
    <aside class="ticket__qr" aria-hidden="false">
      <div class="qr-wrap" title="Scan untuk verifikasi">
        <!-- placeholder QR. akan di-set otomatis oleh script -->
        <img class="qr" id="qrImage" alt="QR code placeholder" src="<?=base_url('assets/qr/'.$new.'.jpeg')?>">
      </div>
      <p><?=$text?></p>
      <p>Scan QR untuk verifikasi & pengambilan RPC</p>
      <p style="font-size:12px;color:var(--muted)">Tunjukkan tiket ini pada panitia saat registrasi.</p>
    </aside>

    <!-- RIGHT: Participant Info -->
    <section class="ticket__info" aria-labelledby="ticketTitle">
      <div class="brand" id="ticketTitle">
        <div class="brand__logo" aria-hidden="true">
        	<img src="<?=base_url('assets')?>/images/logos/logo_khm.png" alt="Logo Marathon" width='50px'>
        </div>
        <div>
          <div class="brand__title">Kediri Half Marathon 2026</div>
          <div class="brand__subtitle">17 Mei 2026 &middot; Dhoho International Airport</div>
        </div>
      </div>

      <div class="participant" role="group" aria-label="Informasi Peserta">
        <div>
          <div class="participant__name" id="participantName"><?=$userdata->pelari_name?></div>
        </div>
        <div style="text-align:right">
          <div class="chip" id="chipLabel"><?=$userdata->kategori_name?></div>
        </div>
      </div>

      <div class="details" aria-hidden="false">
      	<div class="detail">
          <div class="detail__label">Nomor Dada</div>
          <div class="detail__value" id="bibNumber"><?=$userdata->pelari_bib?></div>
        </div>
      	<div class="detail">
          <div class="detail__label">Nama BIB</div>
          <div class="detail__value" id="startTime"><?=$userdata->pelari_namabib?></div>
        </div>
        <div class="detail">
          <div class="detail__label">Jersey Size</div>
          <div class="detail__value"><?=$userdata->pelari_kaos?></div>
        </div>
        <div class="detail">
          <div class="detail__label">Kategori</div>
          <div class="detail__value" id="category"><?=$userdata->kategori_name?></div>
        </div>
      </div>

      <div class="footer">
        <div class="notes">Bawa identitas & bukti pendaftaran.</div>
        <div style="text-align:right; font-size:12px; color:var(--muted)">
          <div style="font-weight:700; margin-top:6px;">KHM2026</div>
        </div>
      </div>
    </section>
  </div>
</div>
  <div class="text-center mt-4 mb-2">
  	<button class="btn btn-danger btn-lg mb-2" id="print" onclick="printDiv('body')">DOWNLOAD</button>
  </div>

  <script>
  	function printDiv(divId) {
		    const content = document.getElementById(divId).outerHTML;
		    const printWindow = window.open('', '', 'width=900,height=700');
		    printWindow.document.open();
		    printWindow.document.write(`
		      <html>
		      <head>
		        <title>Print Ticket</title>
		        <style>
  :root{
    --card-bg: #ffffff;
    --accent: #0f62fe;
    --muted: #6b7280;
    --shadow: 0 6px 18px rgba(15, 34, 70, 0.08);
    --radius: 12px;
    --border: 1px solid rgba(15,22,39,0.06);
    --font-sans: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
  }

  /* Page background */
  .body{
    margin: 24px;
    font-family: var(--font-sans);
    font-size: 12px;
    background: linear-gradient(180deg, #f7fbff 0%, #ffffff 100%);
    color: #0f1724;
    border-radius: 15px;
  }

  .print-btn {
    display: inline-block;
    margin-bottom: 20px;
    padding: 10px 18px;
    background: var(--accent);
    color: white;
    font-weight: 600;
    font-size: 14px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(15, 98, 254, 0.2);
    transition: background 0.2s ease;
  }
  .print-btn:hover {
    background: #004ad9;
  }

  /* Ticket wrapper */
  .ticket {
    max-width: 900px;
    margin: 0 auto;
    background: var(--card-bg);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    border: var(--border);
    overflow: hidden;
    display: grid;
    grid-template-columns: 320px 1fr;
    gap: 0;
    align-items: stretch;
  }

  /* Left: QR column */
  .ticket__qr {
    background: linear-gradient(180deg, #f0f7ff 0%, #ffffff 100%);
    padding: 28px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 18px;
  }
  .ticket__qr .qr-wrap{
    width: 240px;
    height: 240px;
    background: #fff;
    border-radius: 10px;
    display:flex;
    align-items:center;
    justify-content:center;
    box-shadow: 0 6px 18px rgba(2,6,23,0.06);
    border: 1px solid rgba(2,6,23,0.04);
    overflow: hidden;
  }
  .ticket__qr img.qr {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .ticket__qr p{
    margin:0;
    color: var(--muted);
    font-size: 12px;
  }

  /* Right: Participant data */
  .ticket__info{
    padding: 22px 28px;
    display:flex;
    flex-direction:column;
    gap:12px;
  }
  .brand {
    display:flex;
    align-items:center;
    gap:12px;
  }
  .brand__logo{
    width:80px;
    height:80px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
    font-size:16px;
  }
  .brand__title{
    font-size:14px;
    font-weight:700;
    line-height:1;
  }
  .brand__subtitle{
    font-size:12px;
    color:var(--muted);
  }

  .participant {
    margin-top: 6px;
    display:grid;
    grid-template-columns: 1fr auto;
    gap:12px;
    align-items:center;
  }

  .participant__name {
    font-size:18px;
    font-weight:700;
    letter-spacing:0.2px;
  }
  .participant__meta {
    color:var(--muted);
    font-size:12px;
    margin-top:6px;
  }

  .details {
    margin-top: 14px;
    display:grid;
    grid-template-columns: repeat(2, minmax(0,1fr));
    gap:12px;
  }
  .detail {
    background: #fbfdff;
    border-radius:10px;
    padding:12px;
    border: 1px solid rgba(2,6,23,0.03);
  }
  .detail__label { font-size:11px; color:var(--muted); margin-bottom:6px; }
  .detail__value { font-weight:700; font-size:13px; }

  .footer {
    margin-top: auto;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
    padding-top:10px;
  }
  .chip {
    font-size:12px;
    padding:8px 12px;
    border-radius:999px;
    background:rgba(15,98,254,0.09);
    color:var(--accent);
    font-weight:600;
    border: 1px solid rgba(15,98,254,0.12);
  }

	.ktp{
		width: 620px;
    margin-top: 0.5rem;
    border: 1px dashed #c0c0c0;
    color: #00000096;
    border-radius: 13px;
    display: table-caption;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 11px;
    padding: 30px;
    text-align: left;
    box-shadow: var(--shadow);
	}

  .notes {
    font-size:11px;
    color:var(--muted);
  }

		        </style>
		      </head>
		      <body>
		        ${content}
		    		<center><div class="ktp" style="margin-top:2rem"><?=option('informasi')?></ktp></center>
		      </body>
		      </html>
		    `);
        printWindow.focus()
        printWindow.print();
        
				// window.print();
		  }
  </script>
