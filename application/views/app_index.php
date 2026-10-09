<!DOCTYPE HTML>
<html lang="zxx">
  <head>
    <meta charset="utf-8">
    <title><?=APP_NAME?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="keywords" content="<?=APP_CURNAME?>" />
    <meta name="description" content="<?=APP_NAME.' '.APP_CURNAME?>">
    <meta name="author" content="AndreasFlic">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="handheldfriendly" content="true" />
    <meta name="MobileOptimized" content="width" />
    <link href="<?=base_url()?>/assets/plugins/sweet-alert/sweetalert.css" rel="stylesheet" >
    <link rel="shortcut icon" type="image/png" href="<?=base_url()?>/assets/images/logos/logo_khm.png" />
    <link rel="stylesheet" href="<?=base_url()?>/assets/libs/owl.carousel/dist/assets/owl.carousel.min.css">
    <link id="themeColors" rel="stylesheet" href="<?=base_url()?>/assets/css/style.css?v=1.8" />
    <link rel="stylesheet" href="<?=base_url()?>/assets/css/khm-fresh-2027.css?v=1.0" />
    <script src="<?=base_url()?>assets/libs/jquery/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="<?=base_url()?>/assets/datatable_manual/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="<?=base_url('assets/datatable_manual/')?>select.dataTables.css" />
    <style type="text/css">
      .dt-buttons{
        text-align: right;
        margin-bottom: 1rem;
      }
    </style>
    <!-- <script src="<?=MIDTRANS_SNAP?>" data-client-key="<?=MIDTRANS_CLIENT_KEY?>"></script> -->
  </head>
  

  <body data-bs-theme="light">
    <div class="preloader">
      <img src="<?=base_url('assets')?>/images/logos/logo_khm.png" alt="loader" class="lds-ripple img-fluid" />
    </div>

    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin3" data-sidebartype="mini-sidebar" data-sidebar-position="fixed" data-header-position="fixed">
      <!-- Sidebar Start -->
      <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div>
          <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="<?=base_url()?>" class="text-nowrap logo-img">
              <img src="<?=base_url('assets')?>/images/logos/light-logo_khm_new.png" class="dark-logo" width="180" alt="" />
              <img src="<?=base_url('assets')?>/images/logos/light-logo_khm_new.png" class="light-logo"  width="180" alt="" />
            </a>
            <div class="close-btn d-lg-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
              <i class="ti ti-x fs-8"></i>
            </div>
          </div>
          <!-- Sidebar navigation-->
          <nav class="sidebar-nav scroll-sidebar" data-simplebar>
            <ul id="sidebarnav">
              <?php if (userdata()->pelari_group == ''){ ?>
              <li class="sidebar-item">
                <a class="sidebar-link" href="<?=base_url()?>" aria-expanded="false">
                  <span>
                    <i class="ti ti-brand-slack"></i>
                  </span>
                  <span class="hide-menu">Beranda</span>
                </a>
              </li>
              <?php } ?>
              <?php if (userid() != 1){ ?>
                <?php $userdata = userdata(); if ($userdata->pelari_name == ''){ ?>
                <li class="sidebar-item">
                  <a class="sidebar-link" href="<?=base_url()?>page/daftar" aria-expanded="false">
                    <span>
                      <i class="ti ti-run"></i>
                    </span>
                    <span class="hide-menu">Daftar Pelari</span>
                  </a>
                </li>
              <?php }else{ if ($userdata->pelari_group != ''){ ?>
                <li class="sidebar-item">
                  <a class="sidebar-link" href="<?=base_url()?>page/daftar" aria-expanded="false">
                    <span>
                      <i class="ti ti-run"></i>
                    </span>
                    <span class="hide-menu">Daftar Group</span>
                  </a>
                </li>
              <?php }}}else{ ?>
              <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Master</span>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link" href="<?=base_url()?>page/kategori" aria-expanded="false">
                  <span>
                    <i class="ti ti-shirt-sport"></i>
                  </span>
                  <span class="hide-menu">Kategori Lari</span>
                </a>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link" href="<?=base_url()?>page/user" aria-expanded="false">
                  <span>
                    <i class="ti ti-user"></i>
                  </span>
                  <span class="hide-menu">Data User</span>
                </a>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link" href="<?=base_url()?>page/group" aria-expanded="false">
                  <span>
                    <i class="ti ti-users"></i>
                  </span>
                  <span class="hide-menu">Data Group</span>
                </a>
              </li>

              <li class="sidebar-item">
                <a class="sidebar-link" href="<?=base_url()?>page/pelari" aria-expanded="false">
                  <span>
                    <i class="ti ti-run"></i>
                  </span>
                  <span class="hide-menu">Data Pelari</span>
                </a>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link" href="<?=base_url()?>page/datashuttle" aria-expanded="false">
                  <span>
                    <i class="ti ti-bus"></i>
                  </span>
                  <span class="hide-menu">Data Shuttle</span>
                </a>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link" href="<?=base_url()?>page/email" aria-expanded="false">
                  <span>
                    <i class="ti ti-mail"></i>
                  </span>
                  <span class="hide-menu">Kirim Email</span>
                </a>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link" href="<?=base_url()?>page/pengambilan" aria-expanded="false">
                  <span>
                    <i class="ti ti-hand-grab"></i>
                  </span>
                  <span class="hide-menu">Pengambilan</span>
                </a>
              </li>
              <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Setting</span>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link" href="<?=base_url()?>page/setting" aria-expanded="false">
                  <span>
                    <i class="ti ti-settings"></i>
                  </span>
                  <span class="hide-menu">Website</span>
                </a>
              </li>
              <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Report</span>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link" href="<?=base_url()?>page/report_pelari" aria-expanded="false">
                  <span>
                    <i class="ti ti-run"></i>
                  </span>
                  <span class="hide-menu">Pelari</span>
                </a>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link" href="<?=base_url()?>page/report_pembayaran" aria-expanded="false">
                  <span>
                    <i class="ti ti-report-money"></i>
                  </span>
                  <span class="hide-menu">Pembayaran</span>
                </a>
              </li>
              <?php } ?>
              <li class="sidebar-item">
                  <a class="sidebar-link" href="<?=base_url()?>page/shuttle" aria-expanded="false">
                    <span>
                      <i class="ti ti-bus"></i>
                    </span>
                    <span class="hide-menu">Daftar Shuttle</span>
                  </a>
                </li>
              <li class="sidebar-item">
                <a class="sidebar-link actLogout" href="#" aria-expanded="false">
                  <span class="d-flex">
                    <i class="ti ti-login"></i>
                  </span>
                  <span class="hide-menu">Logout</span>
                </a>
              </li>
            </ul>
          </nav> 
        </div>
        <!-- End Sidebar scroll-->
      </aside>
      <div class="body-wrapper">
        <header class="app-header"> 
          <nav class="navbar navbar-expand-lg navbar-light">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link sidebartoggler nav-icon-hover ms-n3" id="headerCollapse" href="javascript:void(0)">
                  <i class="ti ti-menu-2"></i>
                </a>
              </li>
            </ul>
            
            <div class="d-block d-lg-none">
              <img src="<?=base_url('assets')?>/images/logos/light-logo_khm_new.png" class="dark-logo" width="180" alt="" />
              <img src="<?=base_url('assets')?>/images/logos/light-logo_khm_new.png" class="light-logo"  width="180" alt="" />
            </div>
            <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="p-2">
                <i class="ti ti-dots fs-7"></i>
              </span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
              <div class="d-flex align-items-center justify-content-between">
                <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                  <li class="nav-item dropdown notifikasi">
                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="ti ti-bell-ringing"></i>
                      <?php 
                        $this->db->where('notif_user', userid());
                        $this->db->where('notif_status', 'n');
                        if ($this->db->get('master_notif')->num_rows() > 0){
                      ?>
                      <div class="notification bg-primary rounded-circle"></div>
                      <?php } ?>
                    </a>
                    <div class="dropdown-menu bg-muted content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                      <div class="d-flex align-items-center justify-content-between py-3 px-7 bg-muted ">
                        <h5 class="mb-0 fs-5 fw-semibold text-light">Notifications</h5>
                      </div>
                      <div class="message-body bg-light" data-simplebar>
                        <?php 
                          $this->db->order_by('notif_id', 'desc');
                          $this->db->limit(7);
                          $this->db->where('notif_user', userid());
                          $ok = $this->db->get('master_notif');
                          foreach ($ok->result() as $notip) {
                            $color = ($notip->notif_status != 'r')? 'text-success' : 'text-dark';
                        ?>
                        <button type="button" 
                          data-bs-toggle="modal" 
                          data-title="Detail Notifikasi" 
                          data-href="<?=base_url('modal/notif?id='.$notip->notif_id)?>" 
                          data-bs-target="#ajax-modal" class="py-6 px-7 d-flex align-items-center dropdown-item">
                          <div class="w-75 d-inline-block v-middle">
                            <h6 class="mb-1 <?=$color?> fw-semibold fs-3"><?=$notip->notif_title?></h6>
                            <span class="d-block"><?php $isi = (strlen($notip->notif_text) > 30 )? substr($notip->notif_text, 0, 30).'...' : $notip->notif_text; echo strip_tags($isi)?></span> 
                            <span class="time text-muted fs-3"><?=relative_time($notip->notif_created);?></span>
                          </div>
                        </button>
                        <?php } ?>
                      </div>
                    </div>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link pe-0" href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown" aria-expanded="false">
                      <div class="d-flex align-items-center">
                        <div class="user-profile-img">
                          <img src="<?=base_url('assets')?>/images/profile/logo_khm.png?v=1" class="rounded-circle" width="35" height="35" alt="" />
                        </div>
                      </div>
                    </a>
                    <div class="dropdown-menu bg-muted content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop1">
                      <div class="profile-dropdown position-relative" data-simplebar>
                        <div class="py-3 px-7 pb-0">
                          <h5 class="mb-0 fs-5 fw-semibold text-light">User Profile</h5>
                        </div>
                        <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                          <img src="<?=base_url('assets')?>/images/profile/logo_khm.png" class="rounded-circle" width="80" height="80" alt="" />
                          <div class="ms-3">
                            <h5 class="mb-1 fs-3 text-light"><?=$this->session->userdata('user_email');?></h5>
                            <span class="mb-1 d-block text-light"><?=$this->session->userdata('user_join');?></span>
                            <p class="mb-0 d-flex text-light align-items-center gap-2">
                              <i class="ti ti-run fs-4"></i>
                            </p>
                          </div>
                        </div>
                        <div class="message-body">
                          <a href="#" class="py-8 px-7 mt-8 d-flex align-items-center" 
                          data-bs-toggle="modal" 
                          data-modalsize="modal-md"
                          data-title="Account Setting" 
                          data-href="<?=base_url('modal/profil?id='.userid())?>" 
                          class="btn btn-sm btn-info ml-1" 
                          data-bs-target="#ajax-modal">
                            <span class="d-flex align-items-center justify-content-center bg-light rounded-1 p-6">
                              <img src="<?=base_url('assets')?>/images/svgs/icon-user-male.svg" alt="" width="24" height="24">
                            </span>
                            <div class="w-75 d-inline-block v-middle ps-3">
                              <h6 class="mb-1 bg-hover-primary fw-semibold text-light"> Setting Password </h6>
                              <span class="d-block text-light">Account Settings</span>
                            </div>
                          </a>
                        </div>
                        <div class="d-grid py-4 px-7 pt-8">
                          
                          <a href="#" class="actLogout btn btn-outline-primary" style="color:#fff !important">Log Out</a>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </nav>
        </header>
        <?php echo $content ?>
      </div>
    </div>
   
    <div id="ajax-modal" class="modal fade" tabindex="-1" data-bs-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" id="modal-size">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Modal Heading</h4>
            <a type="button" id='closeModal' class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></a>
          </div>
          <div class="modal-body">
            ...
          </div>
        </div> 
      </div> 
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="<?=base_url()?>assets/js/jquery-ui.js"></script>
    <script src="<?=base_url()?>assets/plugins/sweet-alert/sweetalert.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/jquery-loading/jquery.loading.js"></script> 

    <script type="text/javascript" src="<?=base_url('assets/datatable_manual/')?>pdfmake.min.js"></script>
    <script type="text/javascript" src="<?=base_url('assets/datatable_manual/')?>vfs_fonts.js"></script>
    <script type="text/javascript" src="<?=base_url('assets/datatable_manual/')?>datatables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/datetime/1.0.3/js/dataTables.dateTime.min.js"></script>

    <script src="<?=base_url('assets')?>/libs/simplebar/dist/simplebar.min.js"></script>
    <script src="<?=base_url('assets')?>/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!--  core files -->
    <script src="<?=base_url('assets')?>/js/app.min.js"></script>
    <script src="<?=base_url('assets')?>/js/app.init.js"></script>
    <script src="<?=base_url('assets')?>/js/sidebarmenu.js"></script>
    <script src="<?=base_url('assets')?>/js/custom.js"></script>
    <!--  current page js files -->

    <script src="<?=base_url('assets')?>/libs/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="<?=base_url('assets')?>/js/dashboard.js"></script>
      
    <script type="text/javascript">
      $("#ajax-modal").on("show.bs.modal", function(e) {
        $('.modal-body').html('loading.....');
        var link = $(e.relatedTarget);
        var modalSize = (link.data('modalsize'))? link.data('modalsize') : 'modal-lg';
        $(this).find('#modal-size').removeClass('modal-lg');
        $(this).find('#modal-size').removeClass('modal-sm');
        $(this).find('#modal-size').removeClass('modal-md');
        $(this).find('#modal-size').addClass(modalSize);
        $(this).find(".modal-body").load(link.data("href"));
        $('h4.modal-title').text( link.data("title") );

      });
      $(".actLogout").click(function(event) {
        Swal.fire({
          title: 'Sign Out?',
          text: "",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya !',
          cancelButtonText: 'Tidak'
        }).then((result) => {
          if (result.value) {
            window.location = "<?=base_url('route/logout')?>";
          }
        })
      });

      function printElem(divId, title) {
      var content = document.getElementById(divId).innerHTML;
      var mywindow = window.open('', title, 'height=600,width=800');

      mywindow.document.write('<html><head><title>'+title+'</title>');
      mywindow.document.write('<link rel="stylesheet" href="<?=base_url()?>assets/styles/style.min.css">');
      mywindow.document.write('<style>.hidden_button{display:none!important}</style>');
      mywindow.document.write('</head><body >');
      mywindow.document.write(content);
      mywindow.document.write('</body></html>');

      mywindow.document.close();
      mywindow.focus()
      mywindow.print();
    }

    function fnExcelReport(TableID)
    {
      var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
      var textRange; var j=0;
      tab = document.getElementById(TableID); // id of table

      for(j = 0 ; j < tab.rows.length ; j++) 
      {     
          tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
          //tab_text=tab_text+"</tr>";
      }

      tab_text=tab_text+"</table>";
      tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
      tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
      tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

      var ua = window.navigator.userAgent;
      var msie = ua.indexOf("MSIE "); 

      if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
      {
          txtArea1.document.open("txt/html","replace");
          txtArea1.document.write(tab_text);
          txtArea1.document.close();
          txtArea1.focus(); 
          sa=txtArea1.document.execCommand("SaveAs",true,"Excell.xls");
      }else{                 //other browser not tested on IE 11
          sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  
      }
      return sa;
    }

    function hapus_data(id, from){
      Swal.fire({
        title: 'Hapus Data ?',
        text: "",
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
            url: '<?=base_url('admindata/hapus_data')?>',
            type: 'post',
            dataType: 'json',
            data: {id,from},
          })
          .done(function(data) { 
            Swal.fire({
              title: data.heading,
              html: data.message,
              icon: data.type,
              position: 'top-end',
              showConfirmButton: false,
              timer: 1500
            }).then(function(){
              if (data.status){$('#data_table').DataTable().ajax.reload(null, false);}
            });
            
          })
          .always(function() {
            $('body').loading('stop');
          });  
        }
      });
    }

    function hapus_pelari(id, from){
      Swal.fire({
        title: 'Hapus Data ?',
        text: "",
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
            url: '<?=base_url('userdata/hapus_pelari')?>',
            type: 'post',
            dataType: 'json',
            data: {id,from},
          })
          .done(function(data) { 
            Swal.fire({
              title: data.heading,
              html: data.message,
              icon: data.type,
              position: 'top-end',
              showConfirmButton: false,
              timer: 1500
            }).then(function(){
              if (data.status){location.reload();}
            });
            
          })
          .always(function() {
            $('body').loading('stop');
          });  
        }
      });
    }
    function hapus_group(id){
      Swal.fire({
        title: 'Hapus Data ?',
        text: "",
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
            url: '<?=base_url('userdata/hapus_group')?>',
            type: 'post',
            dataType: 'json',
            data: {id},
          })
          .done(function(data) { 
            Swal.fire({
              title: data.heading,
              html: data.message,
              icon: data.type,
              position: 'top-end',
              showConfirmButton: false,
              timer: 1500
            }).then(function(){
              if (data.status){location.reload();}
            });
            
          })
          .always(function() {
            $('body').loading('stop');
          });  
        }
      });
    }

    function newexportaction(e, dt, button, config) {
      var self = this;
      var oldStart = dt.settings()[0]._iDisplayStart;
      dt.one('preXhr', function (e, s, data) {
        // Just this once, load all data from the server...
        data.start = 0;
        data.length = 2147483647; 
        dt.one('preDraw', function (e, settings) {
          // Call the original action function
          if (button[0].className.indexOf('buttons-copy') >= 0) {
              $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
          } else if (button[0].className.indexOf('buttons-excel') >= 0) {
              $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                  $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                  $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
          } else if (button[0].className.indexOf('buttons-csv') >= 0) {
              $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                  $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                  $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
          } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
              $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                  $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                  $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
          } else if (button[0].className.indexOf('buttons-print') >= 0) {
              $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
          }
          dt.one('preXhr', function (e, s, data) {
              settings._iDisplayStart = oldStart;
              data.start = oldStart;
          });
          setTimeout(dt.ajax.reload, 0);
          return false;
        });
      });
      // Requery the server with the new one-time export settings
      dt.ajax.reload();
    };

    </script>
  </body>
</html>