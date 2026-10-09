<!DOCTYPE html>
<html>
<head>
  <!-- set the encoding of your site -->
  <meta charset="utf-8">
  <!-- set the viewport width and initial-scale on mobile devices -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 Not Found</title>
  <!-- include the site animate stylesheet -->
  <link rel="stylesheet" type="text/css" href="<?=base_url('assets/error_assets/')?>css/style.css" media="screen"/>
  <link rel="shortcut icon" type="image/png" href="<?=base_url()?>/assets/images/logos/logo_khm.png" />
  <link href='https://fonts.googleapis.com/css?family=Bangers' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Poppins:400,300' rel='stylesheet' type='text/css'>  
  <style type="text/css">
    .updiv {
      background: red;
      margin-top: 10px;
      animation: upToDown 2s infinite;
    }

    @keyframes upToDown {
      0% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(-10px);
      }
      100% {
        transform: translateY(0);
      }
    }
  </style>
</head>
<body>
  <!-- Page Loader -->
  <div id="pre-loader" class="loader-container">
    <div class="loader">
      <div></div>
      <div></div>
    </div>
  </div>
  <!-- main container of all the page elements -->
  <div id="wrapper">
    <!-- mt bluesky -->
    <div id="mt-bluesky"></div>
    <!-- Page Loader -->
    <div id="mt-sun"></div>
    <!-- mt sun -->
    <div id="mt-sun2"></div>
    <!-- mt cloud -->
    <div id="mt-cloud"></div>
    <!-- mt base -->
    <div id="mt-base"></div>
    <!-- base overlay -->
    <div id="base-overlay"></div>
    <!-- night -->
    <div id="night"></div>
    <!-- stars -->
    <div id="stars"></div>
    <!-- sstar -->
    <div id="sstar"></div>
    <!-- moon -->
    <div id="moon"></div>
    <!-- hock -->
    <div id="hock"></div>
    <!-- title -->
    <span id="title"><span>404</span></span>
    <!-- oh -->
    <span id="oh">oh no</span>
    <!-- txt -->
    <div class="txt">
      <p>We're sorry, but something went wrong.</p>
      <a href="<?=base_url()?>" class="btn">Go Home</a>
    </div>
  </div>
  <script type="text/javascript" src="<?=base_url('assets/error_assets/')?>js/jquery-1.11.3.min.js"></script>
  <script type="text/javascript" src="<?=base_url('assets/error_assets/')?>js/jquery.color.js"></script>
  <script type="text/javascript">
    $(function() {
      $('#mt-sun').animate({'top':'96%','opacity':0.4}, 600,function(){
        $('#stars').animate({'opacity':1}, 100,function(){
          $('#moon').animate({'top':'10%','opacity':1}, 1000, function(){
            $('#hock').animate({'bottom':'190px','opacity':1}, 600, function(){
              $('#hock').animate({'bottom':'46%'}, 200);
              $('#title').animate({'top':'44%','opacity':1}, 200);
              $('#sstar').animate({'opacity':0.8}, 500);
              $('#sstar').animate({'backgroundPosition':'0px 0px','top':'15%', 'opacity':0
              }, 300,function(){
                $('#ground-overlay').animate({'opacity':1}, 300);
                $('#title').animate({'top':'53%','opacity':1}, 300, function(){
                  $('#oh').animate({'opacity':1}, 1000);
                  $('.txt').animate({'opacity':1}, 1000);
                  $('#title').addClass('updiv');
                });

              });
            });
          });
        });
      });
      $('#mt-sun').animate({'top':'96%','opacity':0.8}, 600);
      $('#mt-bluesky').animate({'backgroundColor':'#4F0030'}, 5000);
      $('#mt-cloud').animate({'backgroundPosition':'1000px 0px','opacity':0}, 2000);
      $('#night').animate({'opacity':0.8}, 2000);
      $('html').animate({'backgroundColor':'#1c2401'}, 5000);
    });
  </script>
</body>
</html>