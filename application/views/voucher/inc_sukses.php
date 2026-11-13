<div class="text-center">
  <i class="ti ti-circle-check text-success" style="font-size:64px"></i>
  <h4 class="card-title fw-semibold mt-3">Pendaftaran Berhasil</h4>
  <p class="text-muted">
    Voucher Anda sudah digunakan. Nomor BIB dan QR code telah dikirim ke
    <b><?=html_escape($info['email'])?></b>
  </p>

  <hr>

  <h2 class="fw-semibold"><?=strtoupper(html_escape($info['nama']))?></h2>
  <div style="font-size:50px;font-weight:800;letter-spacing:2px"><?=html_escape($info['bib'])?></div>
  <p class="text-muted"><?=html_escape($info['kategori'])?></p>

  <img
    src="<?=base_url('assets')?>/qr/<?=html_escape($info['qr'])?>.jpeg"
    class="img-fluid mt-3"
    style="max-width:320px"
    alt="QR Code Nomor BIB"
  />

  <div class="alert alert-info mt-4 text-start">
    <i class="ti ti-info-circle"></i>
    Simpan QR code ini untuk <b>pengambilan paket lari</b>.
    Data pendaftaran Anda sudah tersimpan di akun
    <b><?=html_escape($info['email'])?></b>.
  </div>

  <div class="d-md-flex align-items-center justify-content-center mt-3">
    <button type="button" onclick="window.print()" class="btn btn-primary font-medium rounded-pill px-4 me-2">
      <div class="d-flex align-items-center">
        <i class="ti ti-printer me-2 fs-4"></i>
        Cetak / Simpan PDF
      </div>
    </button>
    <a href="<?=base_url('page/daftar_lari')?>" class="btn btn-info font-medium rounded-pill px-4">
      <div class="d-flex align-items-center">
        <i class="ti ti-user me-2 fs-4"></i>
        Lihat Data Pelari Saya
      </div>
    </a>
  </div>
</div>
