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
    :root{--accent:#ff6b35;--accent2:#ffb18a;--bg:#0b1020;--glass:rgba(0,0,0,0.8)}
    *{box-sizing:border-box}
    body{margin:0;font-family:Inter,system-ui,Roboto,Arial;color:#fff;height:100vh;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#071021,#0f1724 70%),url('https://images.unsplash.com/photo-1508609349937-5ec4ae374ebf?auto=format&fit=crop&w=1600&q=80') center/cover no-repeat}
    .card{background:var(--glass);padding:40px 32px;border-radius:20px;backdrop-filter:blur(8px);max-width:380px;width:100%;box-shadow:0 10px 30px rgba(0,0,0,0.4)}
    h1{margin:0 0 20px;font-weight:800;text-align:center;font-size:26px;letter-spacing:0.5px}
    p.subtitle{text-align:center;color:#cbd5e1;margin:0 0 30px}
    label{display:block;font-weight:600;margin-bottom:6px}
    input{width:100%;padding:12px 14px;margin-bottom:16px;border-radius:10px;border:1px solid rgba(255,255,255,0.1);background:rgba(255,255,255,0.05);color:#fff;font-size:15px}
    input::placeholder{color:#9aa4b2}
    button{width:100%;padding:12px;border:none;border-radius:10px;background:linear-gradient(90deg,var(--accent),var(--accent2));color:#fff;font-weight:700;font-size:15px;cursor:pointer;transition:0.2s}
    button:hover{opacity:0.9}
    .meta{margin-top:20px;text-align:center;font-size:14px;color:#cbd5e1}
    a{color:var(--accent2);text-decoration:none;font-weight:600}
    a:hover{text-decoration:underline}
    .logo{display:block;margin:0 auto 24px;width:170px;height:170px;border-radius:50%;overflow:hidden}
    .logo img{width:100%;height:100%;object-fit:contain}
    footer{text-align:center;margin-top:30px;font-size:12px;color:#a3a8b5}
  </style>
</head>
<body style="background-image: url('https://gelarfakta.com/wp-content/uploads/2025/05/kediri-half-marathon.jpeg'); background-size: cover;">
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
