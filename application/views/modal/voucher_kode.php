<?php
  $batchcode = get('batchcode');
  $this->db->join('master_kategori', 'kategori_id = voucher_kategori', 'left');
  $this->db->where('voucher_batchcode', $batchcode);
  $this->db->order_by('voucher_id', 'asc');
  $vouchers = $this->db->get('master_voucher')->result();

  $total   = count($vouchers);
  $terpakai = 0;
  $kategori_name = '';
  $batch_label   = '';
  $kode_list     = array();
  foreach ($vouchers as $v) {
    if ($v->voucher_used == 'T'){ $terpakai++; }
    $kategori_name = $v->kategori_name;
    $batch_label   = $v->voucher_batch;
    $kode_list[]   = $v->voucher_code;
  }
?>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-3"><b>Kode Batch</b><br><?=$batchcode?></div>
          <div class="col-md-3"><b>Label</b><br><?=($batch_label != '')? html_escape($batch_label) : '-'?></div>
          <div class="col-md-3"><b>Kategori Lomba</b><br><?=html_escape($kategori_name)?></div>
          <div class="col-md-3"><b>Total / Terpakai</b><br><?=$total?> / <?=$terpakai?></div>
        </div>

        <?php if ($total == 0){ ?>
          <div class="alert alert-warning">Tidak ada voucher pada batch ini.</div>
        <?php }else{ ?>
          <textarea id="csv_data" style="display:none"><?php
            $csv = "Kode Voucher;Kategori Lomba;Batch;Status;Berlaku Sampai;Dibuat\n";
            foreach ($vouchers as $v) {
              $st  = ($v->voucher_used == 'T')? 'Terpakai' : 'Belum Terpakai';
              $exp = (($v->voucher_expired != null) && ($v->voucher_expired != ''))? date('Y-m-d H:i', strtotime($v->voucher_expired)) : '-';
              $csv .= $v->voucher_code.';'.$kategori_name.';'.$batchcode.';'.$st.';'.$exp.';'.date('Y-m-d H:i', strtotime($v->voucher_created))."\n";
            }
            echo html_escape($csv);
          ?></textarea>

          <div id="area_kode">
            <h6 class="card-title fw-semibold">Daftar Kode Voucher</h6>
            <textarea id="txt_kode" class="form-control" rows="10" style="font-family:monospace;letter-spacing:1px" readonly><?=implode("\n", $kode_list)?></textarea>
          </div>

          <div class="d-md-flex align-items-center mt-3">
            <div class="ms-auto mt-3 mt-md-0">
              <button type="button" id="btn_copy" class="btn btn-info font-medium rounded-pill px-4">
                <i class="ti ti-copy me-2 fs-4"></i> Copy Semua Kode
              </button>
              <button type="button" id="btn_csv" class="btn btn-success font-medium rounded-pill px-4">
                <i class="ti ti-file-download me-2 fs-4"></i> Download CSV
              </button>
              <button type="button" id="btn_print" class="btn btn-primary font-medium rounded-pill px-4">
                <i class="ti ti-printer me-2 fs-4"></i> Print
              </button>
              <button type="button" id="btn_hapus_batch" class="btn btn-danger font-medium rounded-pill px-4">
                <i class="ti ti-trash me-2 fs-4"></i> Hapus Yang Belum Terpakai
              </button>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  var voucher_batch = '<?=$batchcode?>';
  var jml_kode      = <?=count($kode_list)?>;

  function notif_voucher(tipe, pesan){
    Swal.fire({ title: '', html: pesan, icon: tipe, position: 'top-end', showConfirmButton: false, timer: 1800 });
  }

  $('#btn_copy').click(function(event) {
    var teks = $('#txt_kode').val();
    var txt  = document.getElementById('txt_kode');

    if (navigator.clipboard && navigator.clipboard.writeText){
      navigator.clipboard.writeText(teks).then(function(){
        notif_voucher('success', jml_kode + ' kode voucher tersalin');
      }, function(){
        txt.select(); document.execCommand('copy');
        notif_voucher('success', jml_kode + ' kode voucher tersalin');
      });
    }else{
      txt.select();
      txt.setSelectionRange(0, 999999);
      document.execCommand('copy');
      notif_voucher('success', jml_kode + ' kode voucher tersalin');
    }
  });

  $('#btn_csv').click(function(event) {
    var isi  = "\uFEFF" + $('#csv_data').val();
    var blob = new Blob([isi], {type: 'text/csv;charset=utf-8;'});
    var link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'voucher-' + voucher_batch + '.csv';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    notif_voucher('success', 'CSV sedang diunduh');
  });

  $('#btn_print').click(function(event) {
    printElem('area_kode', 'Kode Voucher ' + voucher_batch);
  });

  $('#btn_hapus_batch').click(function(event) {
    Swal.fire({
      title: 'Hapus Voucher Belum Terpakai ?',
      text: 'Seluruh voucher belum terpakai di batch ini dihapus dan kuota kategori dikembalikan.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Tidak'
    }).then((result) => {
      if (result.value) {
        $('body').loading();
        $.ajax({
          url: '<?=base_url('admindata/hapus_batch_voucher')?>',
          type: 'post',
          dataType: 'json',
          data: {batchcode: voucher_batch},
        })
        .done(function(data) {
          Swal.fire({ title: data.heading, html: data.message, icon: data.type }).then(function(){
            if (data.status) { location.reload(); }
          });
        })
        .always(function() {
          $('body').loading('stop');
        });
      }
    });
  });
</script>
