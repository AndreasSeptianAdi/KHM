<?php 
  $this->db->where('notif_id', get('id'));
  $this->db->update('master_notif', ['notif_status' => 'r']);
	$data = $this->db->get_where('master_notif', ['notif_id' => get('id')])->row(); 
?>

<div class="card bg-light border-light" >
  <div class="card-header"><i class="fa fa-clock"></i> <?=date('d F Y - H:i', strtotime($data->notif_created))?></div>
  <div class="card-body text-dark">
    <p class="card-text"><?=$data->notif_text?></p>
  </div>
</div>

<script type="text/javascript">
  $('#ajax-modal').on('hide.bs.modal', function (e) {
    $('.notifikasi').load(" .notifikasi > *");
  });  
</script>