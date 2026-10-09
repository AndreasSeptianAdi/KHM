<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card">
      <div class="card-body">
        <form id="ok" method="post">
          <label>Tanggal Lahir</label>
          <input type="date" name="tgl" id="inputTgl" class="form-control" value="" required="required" title="">
          <br><center id="cen">
          <button class="btn btn-danger" class="submit">Cek Kategori Lari</button>
          </center>
        </form>
        <center id="cen2">

        </center>
      </div>
    </div>
  </div>
</div>


<script>
  $('#ok').submit(function(event) {
    event.preventDefault();
    $('body').loading();
    $.ajax({
      url: '<?=base_url('userdata/cek_umur') ?>',
      type: 'post',
      dataType: 'json',
      data: $('#ok').serialize(),
    })
    .done(function( data ) {
      if (data.status) {
        $('#cen').html('');
        umur = "<input type='text' value='"+$('#inputTgl').val()+"' name='tgl_lahir' style='display:none'>";
        $('#cen2').html("<form action='<?=base_url('page/daftar_lari')?>' method='post'>"+data.button+""+umur+"</form>");
      }else{
        Swal.fire({
          title: data.heading,
          html: data.message,
          icon: data.type
        })
      }
    })
    .always(function(){
      $('body').loading('stop');
    });
  });
</script>