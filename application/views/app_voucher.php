<!DOCTYPE HTML>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <title><?=APP_NAME?> - Registrasi Voucher</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="<?=APP_NAME?> Registrasi Voucher">
    <meta name="author" content="AndreasFlic">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="handheldfriendly" content="true" />
    <meta name="MobileOptimized" content="width" />
    <link rel="shortcut icon" type="image/png" href="<?=base_url()?>/assets/images/logos/logo_khm.png" />
    <link href="<?=base_url()?>/assets/plugins/sweet-alert/sweetalert.css" rel="stylesheet">
    <link id="themeColors" rel="stylesheet" href="<?=base_url()?>/assets/css/style.css?v=1.8" />
    <link rel="stylesheet" href="<?=base_url()?>/assets/css/khm-softred-2027.css?v=1.0" />
    <script src="<?=base_url()?>assets/libs/jquery/dist/jquery.min.js"></script>
    <style type="text/css">
      body{background:#fdf6f7;}
      .voucher-wrap{max-width:960px;margin:0 auto;padding:24px 16px 48px;}
      .voucher-head{text-align:center;margin-bottom:22px;}
      .voucher-head .logo{width:110px;height:110px;margin:0 auto 12px;border-radius:50%;overflow:hidden;background:#fff;border:4px solid #f7dfe3;box-shadow:0 10px 26px rgba(181,74,90,.18);display:flex;align-items:center;justify-content:center}
      .voucher-head .logo img{width:82%;height:82%;object-fit:contain}
      .voucher-head h1{font-size:24px;font-weight:800;margin:0;color:#5e2632;letter-spacing:.5px}
      .voucher-head p{margin:4px 0 0;color:#b54a5a;font-weight:600}
      .voucher-foot{text-align:center;margin-top:22px;font-size:12px;color:#96797e}
      .kode-voucher{font-family:monospace;font-size:16px;letter-spacing:2px;text-transform:uppercase}
    </style>
  </head>

  <body data-bs-theme="light">
    <div class="voucher-wrap">
      <div class="voucher-head">
        <div class="logo">
          <img src="<?=base_url('assets')?>/images/logos/logo_khm.png" alt="Kediri Half Marathon">
        </div>
        <h1>KEDIRI HALF MARATHON 2027</h1>
        <p>Registrasi Melalui Voucher</p>
      </div>

      <div class="card">
        <div class="card-body">
          <?php echo $content ?>
        </div>
      </div>

      <div class="voucher-foot">
        Butuh bantuan? <a href="mailto:kedirihalfmarathon@gmail.com">kedirihalfmarathon@gmail.com</a>
        <br>© 2027 Kediri Half Marathon. Semua hak dilindungi.
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

    <script src="<?=base_url()?>assets/plugins/sweet-alert/sweetalert.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/jquery-loading/jquery.loading.js"></script>
    <script src="<?=base_url('assets')?>/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

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
    </script>
  </body>
</html>
