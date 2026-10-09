<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title><?=APP_NAME?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <script src="<?=base_url()?>assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="<?=base_url()?>assets/js/jquery-ui.js"></script>
  <link rel="shortcut icon" type="image/png" href="<?=base_url('assets')?>/images/logos/logo_khm.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <link href="<?=base_url()?>assets/plugins/sweet-alert/sweetalert.css" rel="stylesheet" >
  <script src="<?=base_url()?>assets/plugins/sweet-alert/sweetalert.min.js"></script>
  <script src="<?=base_url()?>assets/plugins/jquery-loading/jquery.loading.js"></script> 
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
  <style>
    :root{--accent:#41902f;--accent2:#7ec964;--bg:#f2fbf0;--glass:rgba(255,255,255,0.92)}
    *{box-sizing:border-box}
    body{margin:0;font-family:Inter,system-ui,Roboto,Arial;color:#1c3d1e;min-height:100vh;display:flex;align-items:center;justify-content:center;background:radial-gradient(900px 420px at 10% 0%,rgba(143,214,148,.45),transparent 60%),radial-gradient(800px 380px at 95% 10%,rgba(217,242,199,.95),transparent 55%),linear-gradient(180deg,#f7fdf5 0%,#f2fbf0 45%,#e6f6dc 100%);padding:24px}
    .card{background:var(--glass);padding:40px 32px;border-radius:22px;backdrop-filter:blur(10px);max-width:400px;width:100%;box-shadow:0 18px 44px rgba(65,144,47,.16);border:1px solid #dcefce}
    h1{margin:0 0 8px;font-weight:800;text-align:center;font-size:26px;letter-spacing:.5px;color:#1c3d1e}
    p.subtitle{text-align:center;color:#41902f;margin:0 0 28px;font-weight:600}
    label{display:block;font-weight:600;margin-bottom:6px;color:#244f21}
    input{width:100%;padding:12px 14px;margin-bottom:16px;border-radius:12px;border:1px solid #c9ecbc;background:#f7fdf5;color:#1c3d1e;font-size:15px}
    input::placeholder{color:#7aa377}
    input:focus{outline:none;border-color:#58ae42;box-shadow:0 0 0 3px rgba(126,201,100,.25)}
    button{width:100%;padding:12px;border:none;border-radius:12px;background:linear-gradient(90deg,var(--accent),var(--accent2));color:#fff;font-weight:700;font-size:15px;cursor:pointer;transition:.2s;box-shadow:0 10px 22px rgba(65,144,47,.3)}
    button:hover{filter:brightness(1.05)}
    .meta{margin-top:20px;text-align:center;font-size:14px;color:#4a6b46}
    a{color:#2f6e26;text-decoration:none;font-weight:700}
    a:hover{text-decoration:underline}
    .logo{display:flex;margin:0 auto 20px;width:150px;height:150px;border-radius:50%;overflow:hidden;background:#fff;border:4px solid #d9f2c7;box-shadow:0 10px 26px rgba(65,144,47,.2);align-items:center;justify-content:center}
    .logo img{width:82%;height:82%;object-fit:contain}
    footer{text-align:center;margin-top:28px;font-size:12px;color:#6b8a66}
  </style>
</head>
<body>
  <div class="card">
    <div class="logo">
      <img src="<?=base_url('assets')?>/images/logos/logo_khm.png" alt="Logo Marathon">
    </div>
    <h1>Masuk</h1>
    <p class="subtitle">Kediri Half Marathon 2026</p>

    <?=$content?>

    <footer>© 2026 Kediri Half Marathon. Semua hak dilindungi.</footer>
  </div>

</body>
</html>
