
<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table id="data_table2" style="width:100%" class="table align-middle text-center mb-0" data-url="<?=base_url('admintable/list_pelari')?>">
            <thead>
              <tr> 
                <th width="2%" >NO</th>
                <th width="10%">NAMA PELARI</th>
                <th width="10%">ASAL</th>
                <th width="10%">EMAIL</th>
                <th width="10%">KATEGORI</th>
                <th width="10%">HARGA</th>
                <th width="10%">DATE JOIN</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th colspan="5" class="text-right">Total</th>
                <th><?php 
                  $this->db->join('master_kategori', 'kategori_id = pelari_kategori', 'left');
                  $this->db->where('pelari_group', get('id'));
                  $a = $this->db->get('master_pelari')->result();
                  $jml = 0;
                  foreach($a as $b){
                    $jml += harga_group($b->kategori_id);
                  }
                  echo uang($jml);
                ?></th>
                <th>&nbsp;</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

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

    table = $('#data_table2').DataTable({ 
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
            "url": $('#data_table2').data('url'),
            "type": "GET",
            "data": function(data){
              data.group = '<?=get('id')?>'
            }
        },
        "bFilter": true,
        "dom": 'frtip', //lBfrtip
    });

    table.buttons().container().appendTo( $('.placing', table.table().container() ) );
  });
  
</script>