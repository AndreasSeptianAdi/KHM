<?php

define('APP_NAME', 'KEDIRI HALF MARATHON 2026');
define('APP_CURNAME', 'KEDIRI 2026');
define('PT_NAME', '');
define('CNF_PHONE', '');
define('CNF_ALAMAT', 'KEDIRI');
define('CNF_EMAIL1', 'kedirihalfmarathon@gmail.com');

define('FRONT_URL', 'https://kedirihalfmarathon.com');
define('APP_CREATOR', 'AndreasFlic');

// Midtrans
define('MIDTRANS_MERCHANT_ID' , 'M796687716');
define('MIDTRANS_PRODUCTIONS' , true);
define('ADMIN_PENGAMBILAN','8');
define('BASE_PASSWORD','kud4p0n1');

if (MIDTRANS_PRODUCTIONS == false){
	define('MIDTRANS_SNAP', 'https://app.sandbox.midtrans.com/snap/snap.js');
	define('MIDTRANS_CLIENT_KEY' , 'Mid-client-bUCwt94d_fuQbvri');
	define('MIDTRANS_SERVER_KEY' , 'Mid-server-H8x_qajn5_ov65B58_Wx5Uw8');
	define('MIDTRANS_TYPE' , 'SB');
}else{
	define('MIDTRANS_SNAP', 'https://app.midtrans.com/snap/snap.js');
	define('MIDTRANS_CLIENT_KEY' , 'Mid-client-qel0I0XFpGzM_48k');
	define('MIDTRANS_SERVER_KEY' , 'Mid-server-XTVv0RqitnOpiQD1yfjcB4cL');
	define('MIDTRANS_TYPE' , '');
}

//Licence Name: SerialFree
//Licence Code: 786V7PNR8VMNFNA