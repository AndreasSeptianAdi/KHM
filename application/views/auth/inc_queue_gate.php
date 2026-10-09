<?php
// Queue gate: hanya yang pegang slot aktif boleh login.
// File ini di-include di atas inc_login.php
$__q_enabled = false;
$__q_can = true;
$__q_pos = 0;
$__q_active = 0;
$__q_max = 10;
try {
  $CI =& get_instance();
  $CI->load->model('quetablemodel', 'queue');
  $__q_enabled = $CI->queue->queue_enabled();
  $__q_max = $CI->queue->queue_max();
  if ($__q_enabled) {
    $me = $CI->queue->my_token();
    $st = $CI->queue->status($me->token);
    $__q_can = !empty($st['can_login']);
    $__q_pos = isset($st['position']) ? (int) $st['position'] : 0;
    $__q_active = isset($st['active']) ? (int) $st['active'] : 0;
  }
} catch (Exception $e) { $__q_enabled = false; $__q_can = true; }
?>
<style>
  .queue-box{border:1px solid #dcefce;background:linear-gradient(135deg,#f7fdf5,#eef9e9);border-radius:16px;padding:18px 18px 16px;margin-bottom:20px;text-align:center}
  .queue-box.waiting{border-color:#f0d9a8;background:linear-gradient(135deg,#fffdf4,#fef6df)}
  .queue-num{font-size:44px;font-weight:800;color:#2f6e26;line-height:1;margin:6px 0}
  .queue-box.waiting .queue-num{color:#9a6b12}
  .queue-label{font-size:13px;color:#4a6b46;font-weight:600;letter-spacing:.4px;text-transform:uppercase}
  .queue-sub{font-size:13px;color:#6b8a66;margin-top:6px}
  .queue-bar{height:8px;background:#e4ecdf;border-radius:999px;overflow:hidden;margin-top:12px}
  .queue-bar > i{display:block;height:100%;background:linear-gradient(90deg,#41902f,#7ec964);border-radius:999px;transition:width .6s}
  .queue-spin{display:inline-block;width:18px;height:18px;border:3px solid #c9ecbc;border-top-color:#41902f;border-radius:50%;animation:qspin 1s linear infinite;vertical-align:-3px;margin-right:8px}
  @keyframes qspin{to{transform:rotate(360deg)}}
  #loginWrap.locked{opacity:.45;pointer-events:none;filter:grayscale(.3)}
</style>

<?php if ($__q_enabled): ?>
<div id="queueBox" class="queue-box <?= $__q_can ? '' : 'waiting' ?>">
  <div class="queue-label" id="queueLabel"><?= $__q_can ? 'Giliran Anda — silakan login' : 'Ruang antrean' ?></div>
  <div class="queue-num" id="queueNum"><?= $__q_can ? '✔' : ('#' . max(1, $__q_pos)) ?></div>
  <div class="queue-sub" id="queueSub">
    <?php if ($__q_can): ?>
      Slot login tersedia untuk Anda.
    <?php else: ?>
      <?= ($__q_active >= $__q_max)
        ? 'Slot penuh (' . $__q_active . '/' . $__q_max . '). Anda urutan ke-' . max(1, $__q_pos) . ' — tetap di halaman ini, giliran dibuka otomatis.'
        : 'Slot tersedia (' . $__q_active . '/' . $__q_max . '). Menyiapkan giliran Anda…' ?>
    <?php endif; ?>
  </div>
  <div class="queue-bar"><i id="queueBar" style="width:<?= $__q_can ? 100 : max(5, 100 - $__q_pos * 8) ?>%"></i></div>
  <div class="queue-sub" style="margin-top:10px"><span class="queue-spin"></span><span id="queueHint">Memeriksa antrean…</span></div>
</div>

<script type="text/javascript">
(function(){
  var canLogin = <?= $__q_can ? 'true' : 'false' ?>;
  var wrap = document.getElementById('loginWrap');
  function applyLock(){
    if (!wrap) return;
    if (canLogin) { wrap.classList.remove('locked'); }
    else { wrap.classList.add('locked'); }
  }
  applyLock();
  function poll(){
    $.ajax({ url: '<?=base_url('queue/status')?>', type: 'get', dataType: 'json' })
    .done(function(d){
      if (!d || d.enabled === false) {
        $('#queueBox').hide(); canLogin = true; applyLock();
        $('#queueHint').text('Antrean nonaktif.');
        return;
      }
      canLogin = !!d.can_login;
      applyLock();
      var box = $('#queueBox');
      if (canLogin) {
        box.removeClass('waiting');
        $('#queueLabel').text('Giliran Anda — silakan login');
        $('#queueNum').text('✔');
        $('#queueSub').first().text('Slot login tersedia untuk Anda.');
        $('#queueBar').css('width', '100%');
        $('#queueHint').text('Mempertahankan slot… jangan tutup halaman ini.');
      } else {
        box.addClass('waiting');
        $('#queueLabel').text('Ruang antrean');
        var pos = Math.max(1, d.position || 1);
        $('#queueNum').text('#' + pos);
        if (d.active >= d.max) {
          $('#queueSub').first().text('Slot penuh. Anda urutan ke-' + pos + ' — tetap di halaman ini, giliran dibuka otomatis.');
        } else {
          $('#queueSub').first().text('Slot tersedia. Menyiapkan giliran Anda…');
        }
        $('#queueBar').css('width', Math.max(5, 100 - pos * 8) + '%');
        $('#queueHint').text('Menunggu giliran… refresh otomatis tiap 5 detik.');
      }
      window.__queueCanLogin = canLogin;
    })
    .always(function(){ setTimeout(poll, 5000); });
  }
  window.__queueCanLogin = canLogin;
  setTimeout(poll, 5000);
  // heartbeat ringan agar slot aktif tidak kedaluwarsa saat user mengetik lama
  setInterval(function(){
    if (window.__queueCanLogin) {
      $.ajax({ url: '<?=base_url('queue/ping')?>', type: 'get', dataType: 'json' });
    }
  }, 45000);
})();
</script>
<?php endif; ?>
